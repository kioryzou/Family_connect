
<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['familiar']); 

include('layout.php');
require_once __DIR__ . '/controller/residenteController.php';
require_once __DIR__ . '/controller/medicamentoController.php';
require_once __DIR__ . '/controller/seguimientoMedicoController.php';
require_once __DIR__ . '/controller/alergiaController.php';
require_once __DIR__ . '/controller/alimentacionController.php';
require_once __DIR__ . '/controller/alertaEmergenciaController.php';
 
$residente = null;
$medicamentos = [];
$seguimientos = [];
$alergias = [];
$alimentacion = null;

$alertas = [];
if (isset($_SESSION['residente_id'])) {
    $residente_id = $_SESSION['residente_id'];
    $residente = residenteController::obtenerResidentePorId($residente_id);
    if ($residente) {
        $medicamentos = medicamentoController::obtenerMedicamentosPorResidenteId($residente_id);
        $seguimientos = seguimientoMedicoController::obtenerSeguimientosPorResidenteId($residente_id);
        $alergias = alergiaController::obtenerAlergiasPorResidenteId($residente_id);
        $alimentacion = alimentacionController::obtenerAlimentacionPorResidenteId($residente_id);
        $alertas = alertaEmergenciaController::obtenerAlertasPorResidenteId($residente_id);
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
    
    <div class="card shadow p-4 mx-auto mb-4">
        <h4 class="mb-3 text-primary">Alergias Conocidas</h4>
        <?php if (!empty($alergias)): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($alergias as $alergia): ?>
                    <li class="list-group-item"><?= htmlspecialchars($alergia['alergia'] ?? 'N/A') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay alergias registradas para este residente.</div>
        <?php endif; ?>
    </div>
    
    <div class="card shadow p-4 mx-auto mb-4">
        <h4 class="mb-3 text-primary">Plan de Alimentación</h4>
        <?php if ($alimentacion): ?>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Dieta:</strong> <?= htmlspecialchars($alimentacion['dieta'] ?? 'No especificada') ?></li>
                <li class="list-group-item">
                    <strong>Restricciones:</strong>
                    <?php if (!empty($alimentacion['restricciones']) && is_array($alimentacion['restricciones'])): ?>
                        <ul class="mt-2">
                            <?php foreach ($alimentacion['restricciones'] as $restriccion): ?>
                                <li><?= htmlspecialchars($restriccion) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span class="ms-2">Ninguna</span>
                    <?php endif; ?>
                </li>
                <li class="list-group-item"><strong>Observaciones:</strong> <?= nl2br(htmlspecialchars($alimentacion['observaciones'] ?? 'Sin observaciones')) ?></li>
            </ul>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay información de alimentación registrada para este residente.</div>
        <?php endif; ?>
    </div>
    
    <div class="card shadow p-4 mx-auto mb-4">
        <h4 class="mb-3 text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Alertas de Emergencia</h4>
        <?php if (!empty($alertas)): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($alertas as $alerta): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($alerta['tipo_alerta'] ?? 'N/A') ?></strong>
                            <small class="d-block text-muted">
                                Fecha: <?= htmlspecialchars($alerta['fecha'] ?? 'N/A') ?> | 
                                Registrado por: <?= htmlspecialchars($alerta['registrado_por'] ?? 'N/A') ?>
                            </small>
                        </div>
                        <span class="badge rounded-pill <?= $alerta['resuelto'] ? 'bg-success' : 'bg-warning text-dark' ?>">
                            <?= $alerta['resuelto'] ? 'Resuelto' : 'Pendiente' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay alertas de emergencia registradas.</div>
        <?php endif; ?>
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
