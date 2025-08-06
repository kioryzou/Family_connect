<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Abre una conexion a la base de datos
function AbrirBDMongo(){
try {
    $cliente = new MongoDB\Client("mongodb://localhost:27017");
    $baseDatos = $cliente->Hoga;
    return $baseDatos;
}catch (Exception $e){
    die("Error de conexión:". $e->getMessage());
  }
}
?>

 