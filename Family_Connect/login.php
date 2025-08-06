<?php
session_start();
include('layout.php');
require_once __DIR__ . '/controller/loginController.php';

// Si el método es POST, intentamos procesar el login.
// La función redirigirá si es exitoso, o devolverá false si falla.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!loginController::procesarLogin()) {
        $error_message = "ID o contraseña incorrectos.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FamilyConnect</title>
   <?php IncluirCSS();?>
</head>
    <body>
       <?php MostrarMenu();?>

<main class="container py-5">
    <h2 class="text-center mb-4" style="padding-top: 80px;">Iniciar Sesión</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php" class="col-md-6 offset-md-3">
            <div class="mb-3">
                <label for="user_id" class="form-label">Ingrese el ID</label>
                <input type="text" class="form-control" name="user_id" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" required>
            </div>
            <div class="text-center my-4">
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </div>
        </form>
    </main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
    </body>
</html>