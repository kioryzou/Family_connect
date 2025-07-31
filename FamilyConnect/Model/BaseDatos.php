<?php

// Abre una conexion a la base de datos
function AbrirBDMongo(){
try {
    $cliente = new MongoDB\Client("mongodb://localhost:27017");
    $baseDatos = $cliente->//va el nombre de la bd;
    return $baseDatos;
}catch (Exception $e){
    die("Error de conexión:". $e->getMessage());
  }
}
?>

 