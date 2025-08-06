<?php
// 1. Reanudar la sesión existente
session_start();

// 2. Eliminar todas las variables de sesión
session_unset();

// 3. Destruir la sesión
session_destroy();

// 4. Redirigir al usuario a la página de inicio (index.php)
header("Location: index.php");
exit();