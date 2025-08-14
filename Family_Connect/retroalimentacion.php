
<?php
require_once __DIR__ . '/auth_helper.php';
include('layout.php');
require_once __DIR__ . '/controller/retroalimentacionController.php';
 

protect_page(['admin', 'doctor', 'enfermero', 'cuidador', 'familiar']);

$fechaInicio = $_GET['fecha_inicio'] ?? null;
$fechaFin = $_GET['fecha_fin'] ?? null;

if($_SESSION['role'] === 'familiar') {
  $residenteId = $_SESSION['residente_id'] ?? null;
  $datos = $residenteId
  ? obtenerRetroalimencacionController::obtenerRetroalimencacionPorResidenteYFecha($residenteId)
   : [];
}else{
$datos = obtenerRetroalimencacionController::obtenerRetroalimencacion();
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
    <h2 class="text-center mb-4">Retroalimentacion de Gamificación Cognitiva</h2>

    <?php if($_SESSION['role']!== 'familiar'): ?>
      <div class="mb-4 text-center">
    <a href="agregarRetroalimentacion.php" class="btn btn-primary">
      <i class= "bi bi-plus-circle"></i>Agregar Retroalimentacion</a>   
    </div>
      <?php endif; ?>

      <?php if(empty($datos)): ?>
    <div class="alert alert-info text-center" role="alert">
      No hay retroalimentacion disponible
      </div>
      <?php else: ?>

  <div class="row g-4">
    <?php foreach ($datos as $dato): ?>
      <div class= "col-md-6 col-lg-4">
        <div class ="card shadow-sm h-100">
          <div class="card-header bg-primary text-white">
            <strong>Fecha:</strong> <?=$dato['fecha'] ?? '-' ?>
    </div>
      <div class="card-body">
        <h5 class="card-title"><?= $dato['actividad'] ?? 'Actividad no especificada'?></h5>
        <p class="card-text"><strong>Notas:</strong> <?= $dato['notas'] ?? '-' ?></p>
         <p class="card-text"><strong>Diagnóstico:</strong> <?= $dato['diagnostico'] ?? '-' ?></p>
    </div>
    <div class= "card-footer text-muted">
      <small>Personal a cargo: <?= $dato['personal'] ?></small>
    </div>
  </div>
  </div>
  <?php endforeach; ?>
    </div>
    <?php endif; ?>
</main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
    </body>
</html>
