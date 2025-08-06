
<?php
session_start();
 include('layout.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/Family_connect-main/FamilyConnect/controller/residenteController.php';
 
$residente = null;

if (isset($_SESSION['residente_id'])) {
    $residente_id = $_SESSION['residente_id'];
    $residente = residenteController::obtenerResidentePorId($residente_id);
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
    <h2 class="text-center mb-4">Perfil del Residente</h2>
    <?php if ($residente): ?>
        <div class="card shadow p-4 mx-auto">
          <h4 class="mb-3 text-primary"><?= htmlspecialchars($residente['nombre']) ?></h4>

          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID del Residente: </strong><?=htmlspecialchars($residente['_id']) ?></li>
             <li class="list-group-item"><strong>Edad: </strong><?=htmlspecialchars($residente['edad']) ?> años</li>
              <li class="list-group-item"><strong>Género: </strong><?=htmlspecialchars($residente['genero']) ?></li>
               <li class="list-group-item"><strong>Fecha de Ingreso: </strong><?=htmlspecialchars($residente['fecha_ingreso']) ?></li>
                <li class="list-group-item"><strong>habitación: </strong><?=htmlspecialchars($residente['habitacion']) ?></li>
                 <li class="list-group-item"><strong>Estado de Salud: </strong><?=htmlspecialchars($residente['estado_salud']) ?></span></li>
    </ul>
    </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        No se encuentra información del residente</div>
        <?php endif; ?>
</main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
    </body>
</html>
