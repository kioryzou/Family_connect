
<?php
 include('layout.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/Family_connect-main/FamilyConnect/controller/retroalimentacionController.php';
 
$datos = obtenerRetroalimencacionController::obtenerRetroalimencacion();
if(!$datos){
  $datos = [];
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
<a href="agregarRetroalimentacion.php" class="btn btn-primary">Agregar Retroalimentacion</a>   
<div class="table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
       <th>Fecha</th>
       <th>Actividad</th>
       <th>Notas</th>
       <th>Diagnóstico</th>
       <th>Personal a cargo</th>
       </tr>
    </thead>
    <tbody>
      <?php if (!empty($datos)): ?>
       <?php foreach ($datos as $dato): ?>
      <tr>
          <td><?=$dato['fecha'] ??'-'?></td>
           <td><?=$dato['actividad'] ??'-'?></td>
           <td><?=$dato['notas'] ??'-'?></td>
           <td><?=$dato['diagnostico'] ??'-'?></td>
            <td><?=$dato['personal'] ??'-'?></td>
      </tr>

      <?php endforeach; ?> 
      <?php endif; ?>
       </tbody>
    </table>
  </div>
</main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
    </body>
</html>
