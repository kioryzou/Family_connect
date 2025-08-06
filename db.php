<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña de XAMPP, usualmente está vacía
define('DB_NAME', 'family_connect'); // Asegúrate que el nombre de la BD sea correcto

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Falló la conexión: " . $conn->connect_error);
}

?>