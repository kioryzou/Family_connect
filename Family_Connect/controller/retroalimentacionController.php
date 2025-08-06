<?php
require_once __DIR__ . '/../vendor/autoload.php';

 class obtenerRetroalimencacionController{

public static function obtenerRetroalimencacion(){
    try{
 $cliente = new MongoDB\Client("mongodb://localhost:27017");
 $baseDatos = $cliente->Hoga;

$coleccionRetro = $baseDatos->retroalimentacion;
$coleccionUsuarios = $baseDatos->usuarios;
 
$retroalimentaciones= $coleccionRetro->find()->toArray();

$usuarios = $coleccionUsuarios->find()->toArray();
$mapaUsuarios = [];
foreach ($usuarios as $usuario){
    $mapaUsuarios[(string)$usuario['_id']] = $usuario['nombre'];

}

foreach ($retroalimentaciones as &$r){
    $idPersonal= $r['personal'] ?? null;
    if ($idPersonal && isset($mapaUsuarios[$idPersonal])) {
        $r['personal'] = $mapaUsuarios[$idPersonal];
    }else{
        $r['personal']= 'Desconocido';

    }
    }
return $retroalimentaciones;

    }catch(Exception $e){
        echo "Error de conexion:" . $e->getMessage();
        return null;
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