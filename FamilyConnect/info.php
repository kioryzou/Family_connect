<?php
require 'vendor/autoload.php'; // Si estás usando Composer

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    echo "Conexión exitosa a MongoDB!";
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>