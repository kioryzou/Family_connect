
<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['familiar']); 

include('layout.php');
require_once __DIR__ . '/controller/residenteController.php';
require_once __DIR__ . '/controller/medicamentoController.php';
require_once __DIR__ . '/controller/seguimientoMedicoController.php';
 
$residente = null;
$medicamentos = [];
$seguimientos = [];

if (isset($_SESSION['residente_id'])) {
    $residente_id = $_SESSION['residente_id'];
    $residente = residenteController::obtenerResidentePorId($residente_id);
    if ($residente) {
        $medicamentos = medicamentoController::obtenerMedicamentosPorResidenteId($residente_id);
        $seguimientos = seguimientoMedicoController::obtenerSeguimientosPorResidenteId($residente_id);
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
    <h2 class="text-center mb-4">Perfil del Residente</h2>
    <?php if ($residente): ?>
        <div class="card shadow p-4 mx-auto mb-4">
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

    <div class="card shadow p-4 mx-auto">
        <h4 class="mb-3 text-primary">Plan de Medicamentos</h4>
        <?php if (!empty($medicamentos)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Dosis</th>
                            <th>Frecuencia</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicamentos as $medicamento): ?>
                            <tr>
                                <td><?= htmlspecialchars($medicamento['nombre_medicamento'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($medicamento['dosis'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($medicamento['frecuencia'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($medicamento['hora'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay medicamentos registrados para este residente.</div>
        <?php endif; ?>
    </div>

    <div class="card shadow p-4 mx-auto mt-4">
        <h4 class="mb-3 text-primary">Seguimientos Médicos</h4>
        <?php if (!empty($seguimientos)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Presión Arterial</th>
                            <th>Temperatura</th>
                            <th>Comentarios</th>
                            <th>Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seguimientos as $seguimiento): ?>
                            <tr>
                                <td><?= htmlspecialchars($seguimiento['fecha'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguimiento['presion'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguimiento['temperatura'] ?? 'N/A') ?> °C</td>
                                <td><?= htmlspecialchars($seguimiento['comentarios'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($seguimiento['registrado_por'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay seguimientos médicos registrados para este residente.</div>
        <?php endif; ?>
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
