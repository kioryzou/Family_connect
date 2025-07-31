<?php


function obtenerRetroalimencacion(){
    try{
 $cliente = new MongoDB\Client("mongodb://localhost:27017");
 $baseDatos = $cliente->//va el nombre de la bd;
$coleccion = $db->//nombre de la coleccion;

$datos = $coleccion->find();

if($datos->isDead()) {
    return null;
}else{
    return $datos;
}
    }catch(Exception $e){
        echo "Error de conexion:" . $e->getMessage());
        return null;
    }
}
?>