<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['admin', 'doctor', 'enfermero', 'cuidador']);

include('layout.php');
require_once __DIR__ . '/controller/residenteController.php';
require_once __DIR__ . '/controller/medicamentoController.php';
require_once __DIR__ . '/controller/alergiaController.php';
require_once __DIR__ . '/controller/alimentacionController.php';
require_once __DIR__ . '/controller/seguimientoMedicoController.php';

$residente_id = $_GET['residente_id'] ?? $_POST['residente_id'] ?? null;
$residente = null;
$medicamentos = [];
$alergias = [];
$alimentacion = null;
$seguimientos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $redirect_url = "gestionar_salud.php?residente_id=" . urlencode($residente_id);

    switch ($action) {
        case 'agregar_medicamento':
            $datos = [
                'residente_id' => $residente_id,
                'nombre_medicamento' => $_POST['nombre_medicamento'],
                'dosis' => $_POST['dosis'],
                'frecuencia' => $_POST['frecuencia'],
                'hora' => $_POST['hora']
            ];
            medicamentoController::agregarMedicamento($datos);
            $_SESSION['success_message'] = "Medicamento agregado.";
            break;
        case 'eliminar_medicamento':
            medicamentoController::eliminarMedicamento($_POST['id']);
            $_SESSION['success_message'] = "Medicamento eliminado.";
            break;

        case 'agregar_alergia':
            $datos = ['residente_id' => $residente_id, 'alergia' => $_POST['alergia']];
            alergiaController::agregarAlergia($datos);
            $_SESSION['success_message'] = "Alergia agregada.";
            break;
        case 'eliminar_alergia':
            alergiaController::eliminarAlergia($_POST['id']);
            $_SESSION['success_message'] = "Alergia eliminada.";
            break;

        case 'guardar_alimentacion':
            $restricciones = !empty($_POST['restricciones']) ? array_map('trim', explode(',', $_POST['restricciones'])) : [];
            $datos = [
                'residenteId' => $residente_id,
                'dieta' => $_POST['dieta'],
                'restricciones' => $restricciones,
                'observaciones' => $_POST['observaciones']
            ];
            alimentacionController::guardarOActualizarAlimentacion($datos);
            $_SESSION['success_message'] = "Plan de alimentación guardado.";
            break;

        case 'agregar_seguimiento':
            $datos = [
                'residente_id' => $residente_id,
                'fecha' => $_POST['fecha'],
                'presion' => $_POST['presion'],
                'temperatura' => $_POST['temperatura'],
                'comentarios' => $_POST['comentarios'],
                'registrado_por' => $_SESSION['user_nombre'] ?? 'Sistema'
            ];
            seguimientoMedicoController::agregarSeguimiento($datos);
            $_SESSION['success_message'] = "Seguimiento médico agregado.";
            break;
        case 'eliminar_seguimiento':
            seguimientoMedicoController::eliminarSeguimiento($_POST['id']);
            $_SESSION['success_message'] = "Seguimiento médico eliminado.";
            break;

    }
    header("Location: $redirect_url");
    exit();
}

if ($residente_id) {
    $residente = residenteController::obtenerResidentePorId($residente_id);
    if ($residente) {
        $medicamentos = medicamentoController::obtenerMedicamentosPorResidenteId($residente_id);
        $alergias = alergiaController::obtenerAlergiasPorResidenteId($residente_id);
        $alimentacion = alimentacionController::obtenerAlimentacionPorResidenteId($residente_id);
        $seguimientos = seguimientoMedicoController::obtenerSeguimientosPorResidenteId($residente_id);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Salud del Residente</title>
    <?php IncluirCSS(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <?php MostrarMenu(); ?>

    <main class="container py-5" style="padding-top: 120px !important;">
        <h2 class="text-center mb-4">Gestionar Salud del Residente</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <!-- Buscador de Residente -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form method="GET" action="gestionar_salud.php">
                    <div class="input-group">
                        <input type="text" class="form-control" name="residente_id" placeholder="Ingrese el ID del Residente" value="<?= htmlspecialchars($residente_id ?? '') ?>" required>
                        <button class="btn btn-primary" type="submit">Buscar Residente</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($residente): ?>
            <h3 class="mb-4">Mostrando datos para: <span class="text-primary"><?= htmlspecialchars($residente['nombre']) ?></span></h3>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header"><h4><i class="bi bi-shield-plus"></i> Alergias</h4></div>
                        <div class="card-body">
                            <ul class="list-group mb-3">
                                <?php if (!empty($alergias)): ?>
                                    <?php foreach ($alergias as $alergia): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= htmlspecialchars($alergia['alergia']) ?>
                                            <form method="POST" onsubmit="return confirm('¿Eliminar esta alergia?');">
                                                <input type="hidden" name="action" value="eliminar_alergia">
                                                <input type="hidden" name="id" value="<?= $alergia['_id'] ?>">
                                                <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="list-group-item">No hay alergias registradas.</li>
                                <?php endif; ?>
                            </ul>
                            <form method="POST">
                                <input type="hidden" name="action" value="agregar_alergia">
                                <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                <div class="input-group">
                                    <input type="text" name="alergia" class="form-control" placeholder="Nueva alergia" required>
                                    <button class="btn btn-success" type="submit">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header"><h4><i class="bi bi-egg-fried"></i> Plan de Alimentación</h4></div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="guardar_alimentacion">
                                <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                <div class="mb-2">
                                    <label class="form-label">Dieta</label>
                                    <input type="text" name="dieta" class="form-control" value="<?= htmlspecialchars($alimentacion['dieta'] ?? '') ?>" placeholder="Ej: Baja en sal">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Restricciones (separadas por coma)</label>
                                    <input type="text" name="restricciones" class="form-control" value="<?= isset($alimentacion['restricciones']) ? htmlspecialchars(implode(', ', (array)$alimentacion['restricciones'])) : '' ?>" placeholder="Ej: Azúcar, Grasas">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" class="form-control" rows="2"><?= htmlspecialchars($alimentacion['observaciones'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Guardar Plan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h4><i class="bi bi-capsule"></i> Plan de Medicamentos</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr><th>Medicamento</th><th>Dosis</th><th>Frecuencia</th><th>Hora</th><th>Acción</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($medicamentos)): ?>
                                            <?php foreach ($medicamentos as $med): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($med['nombre_medicamento']) ?></td>
                                                    <td><?= htmlspecialchars($med['dosis']) ?></td>
                                                    <td><?= htmlspecialchars($med['frecuencia']) ?></td>
                                                    <td><?= htmlspecialchars($med['hora']) ?></td>
                                                    <td>
                                                        <form method="POST" onsubmit="return confirm('¿Eliminar este medicamento?');">
                                                            <input type="hidden" name="action" value="eliminar_medicamento">
                                                            <input type="hidden" name="id" value="<?= $med['_id'] ?>">
                                                            <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="5" class="text-center">No hay medicamentos registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <h5>Agregar Nuevo Medicamento</h5>
                            <form method="POST">
                                <input type="hidden" name="action" value="agregar_medicamento">
                                <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                <div class="row g-2">
                                    <div class="col-md-3"><input type="text" name="nombre_medicamento" class="form-control" placeholder="Nombre" required></div>
                                    <div class="col-md-3"><input type="text" name="dosis" class="form-control" placeholder="Dosis" required></div>
                                    <div class="col-md-2"><input type="text" name="frecuencia" class="form-control" placeholder="Frecuencia" required></div>
                                    <div class="col-md-2"><input type="time" name="hora" class="form-control" placeholder="Hora" required></div>
                                    <div class="col-md-2"><button type="submit" class="btn btn-success w-100">Agregar</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h4><i class="bi bi-heart-pulse"></i> Seguimientos Médicos</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr><th>Fecha</th><th>Presión</th><th>Temperatura</th><th>Comentarios</th><th>Registrado por</th><th>Acción</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($seguimientos)): ?>
                                            <?php foreach ($seguimientos as $seg): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($seg['fecha']) ?></td>
                                                    <td><?= htmlspecialchars($seg['presion']) ?></td>
                                                    <td><?= htmlspecialchars($seg['temperatura']) ?> °C</td>
                                                    <td><?= htmlspecialchars($seg['comentarios']) ?></td>
                                                    <td><?= htmlspecialchars($seg['registrado_por']) ?></td>
                                                    <td>
                                                        <form method="POST" onsubmit="return confirm('¿Eliminar este seguimiento?');">
                                                            <input type="hidden" name="action" value="eliminar_seguimiento">
                                                            <input type="hidden" name="id" value="<?= $seg['_id'] ?>">
                                                            <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="6" class="text-center">No hay seguimientos registrados.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <h5>Agregar Nuevo Seguimiento</h5>
                            <form method="POST">
                                <input type="hidden" name="action" value="agregar_seguimiento">
                                <input type="hidden" name="residente_id" value="<?= $residente_id ?>">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-2">
                                        <label class="form-label">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" required value="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Presión Arterial</label>
                                        <input type="text" name="presion" class="form-control" placeholder="Ej: 120/80" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Temperatura (°C)</label>
                                        <input type="number" step="0.1" name="temperatura" class="form-control" placeholder="Ej: 36.5" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Comentarios</label>
                                        <textarea name="comentarios" class="form-control" rows="1" required></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success w-100">Agregar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <?php if ($residente_id): ?>
                <div class="alert alert-warning text-center">No se encontró un residente con el ID proporcionado.</div>
            <?php else: ?>
                <div class="alert alert-info text-center">Por favor, ingrese el ID de un residente para ver su información de salud.</div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
</body>
</html>