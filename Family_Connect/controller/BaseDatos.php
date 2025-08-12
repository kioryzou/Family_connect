<?php

require_once __DIR__ . '/../vendor/autoload.php';
use MongoDB\BSON\ObjectId;

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



<?php
//error curioso, el delete sirve si no se corrije el error



function eliminarDocumentoPorId(string $nombreColeccion, string $id): bool {
    try {
        $db = AbrirBDMongo();
        $coleccion = $db->selectCollection($nombreColeccion);
        $resultado = $coleccion->deleteOne(['_id' => new ObjectId($id)]);
        return $resultado->getDeletedCount() > 0;
    } catch (Exception $e) {
        error_log("Error al eliminar documento en {$nombreColeccion} con ID {$id}: " . $e->getMessage());
        return false;
    }
}
?>