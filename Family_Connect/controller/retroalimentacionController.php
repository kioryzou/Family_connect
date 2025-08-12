<?php
require_once __DIR__ . '/../vendor/autoload.php';

 class obtenerRetroalimencacionController{

public static function obtenerRetroalimencacion(){
    try{
 $cliente = new MongoDB\Client("mongodb://localhost:27017");
 $baseDatos = $cliente->Hoga;

$coleccionRetro = $baseDatos->retroalimentacion;

$pipeline = [
    [
        '$lookup' => [
            'from' => 'residentes',
            'localField' => 'residente_id',
            'foreignField' => '_id',
            'as' => 'residente_info'
         ]
        ],
        [
            '$unwind' => '$residente_info'
        ]
    ];
        $resultado = $coleccionRetro->aggregate($pipeline)->toArray();

return $resultado;

    }catch(Exception $e){
        echo "Error al obtener datos de retroalimentacion:" . $e->getMessage();
        return [];
    }
}
public static function obtenerRetroalimencacionPorResidenteYFecha($residenteId, $fechaInicio= null, $fechaFin= null){
    try {
        $cliente = new MongoDB\Client("mongodb://localhost:27017");
        $baseDatos = $cliente->Hoga;
        $coleccion= $baseDatos->retroalimentacion;

        $filtros = ['residente_id' => $residenteId];

         if ($fechaInicio || $fechaFin) {
            $rangoFechas = [];
            if ($fechaInicio) {
                $rangoFechas['$gte'] = $fechaInicio;
            }
            if ($fechaFin) {
                $rangoFechas['$lte'] = $fechaFin;
            }
               if (!empty($rangoFechas)) {
                $filtros['fecha'] = $rangoFechas;
            }
        }
        $cursor = $coleccion->find($filtros);
        $resultados = iterator_to_array($cursor);

        return $resultados;

    }catch(Exception $e) {
       error_log("Error en retroalimentacion por residente:" . $e->getMessage());
    return [];
    }
    
}
 
 

public static function agregarRetroalimencacion($datos){
    try{
 $cliente = new MongoDB\Client("mongodb://localhost:27017");
 $baseDatos = $cliente->Hoga;
$coleccionRetro = $baseDatos->retroalimentacion;

 $coleccionRetro->insertOne($datos);
return "Retroalimentación agregada correctamente";
    }catch(Exception $e){
        echo "Error de conexion:" . $e->getMessage();
        return "Ocurrió un error al agregar la retroalimentacion";
    }
}

public static function manejarFormulacio(){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_retro'])){

        $nuevaRetro = [
            'residente_id' =>$_POST['residente_id'],
            'fecha' => $_POST['fecha'],
            'actividad' => $_POST['actividad'],
            'notas' => $_POST['notas'],
            'diagnostico' => $_POST['diagnostico'],
            'personal' => $_POST['personal']
        ];
        $mensaje = self::agregarRetroalimencacion($nuevaRetro);
        return $mensaje;
    }
    return 'Retroalimentación no agregada';
}

}
?>