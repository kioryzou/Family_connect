<?php
require_once __DIR__ . '/../vendor/autoload.php';

 class comunicacionController{

public static function guardarMensaje(array $datos): bool{
    try{
         $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $db = $cliente->Hoga;
            $coleccion = $db->comunicacion;

            $coleccion->insertOne($datos);
            return true;
            
    }catch(Exception $e){
        error_log("Error al guardar comunicación:" . $e->getMessage());
        return false;
    }
    }

    public static function obtenerMensajesPorResidente(string $residenteId){
    try{
         $cliente = new MongoDB\Client("mongodb://localhost:27017");
            $db = $cliente->Hoga;
            $coleccion = $db->comunicacion;

            $cursor = $coleccion->find(['residente_id' => $residenteId], ['sort' => ['fecha_envio'=> -1]]);
            return iterator_to_array($cursor);

            

             $resultados = $resultados;
    }catch(Exception $e){
        error_log("Error al obtener mensaje:" . $e->getMessage());
        return [];
    }
  }
}