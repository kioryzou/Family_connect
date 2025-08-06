<?php
session_start();
 include('layout.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/Family_connect-main/FamilyConnect/controller/loginController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   if (loginController::procesarLogin()) {
    echo "<div class= 'alert alert-success text-center'>Sesión iniciada: ".htmlspecialchars($_SESSION['user_nombre']).".</div>";
}else{
    echo"<div class='alert alert-danger text-center'>ID o contraseña incorrectos.</div>";
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
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <?php if (isset($_SESSION['error_login'])): ?>
        <div class="alert alert-danger text-center"><?=$_SESSION['error_login'] ?></div>
        <?php unset($_SESSION['error_login']); ?>
        <?php endif; ?>

        <form method="POST"action="" class="col-md-6 offset-md-3">
            <div class="mb-3">
                <label for="user_id" class="form-label">Ingrese el ID</label>
                <input type="text" class="form-control" name="user_id" required>
    </div>
    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="text" class="form-control" name="contrasena" required>
    </div>
    </div>
    <div class="col-md-12 text-center my-4">
    <input type="submit" class="btn btn-primary"></button>
    </div>
    </form>
    </main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
    </body>
</html>