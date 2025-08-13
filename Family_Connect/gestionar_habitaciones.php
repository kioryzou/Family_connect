<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['admin']);

require_once __DIR__ . '/controller/habitacionController.php';
include('layout.php');

function generate_uuid_v4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$habitacion_to_edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $redirect_url = "gestionar_habitaciones.php";

    switch ($action) {
        case 'create':
            $datos = [
                '_id' => generate_uuid_v4(),
                'numero' => trim($_POST['numero']),
                'tipo' => $_POST['tipo'],
                'disponible' => isset($_POST['disponible'])
            ];
            if (habitacionController::agregarHabitacion($datos)) {
                $_SESSION['success_message'] = "Habitación agregada exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al agregar la habitación.";
            }
            break;

        case 'update':
            $datos = [
                'numero' => trim($_POST['numero']),
                'tipo' => $_POST['tipo'],
                'disponible' => isset($_POST['disponible'])
            ];
            if (habitacionController::editarHabitacion($id, $datos)) {
                $_SESSION['success_message'] = "Habitación actualizada exitosamente.";
            } else {
                $_SESSION['error_message'] = "No se realizaron cambios o hubo un error al actualizar.";
            }
            break;

        case 'delete':
            if (habitacionController::eliminarHabitacion($id)) {
                $_SESSION['success_message'] = "Habitación eliminada exitosamente.";
            } else {
                $_SESSION['error_message'] = "Error al eliminar la habitación.";
            }
            break;
    }
    header("Location: $redirect_url");
    exit();
}

if ($action === 'edit' && $id) {
    $habitacion_to_edit = habitacionController::obtenerHabitacionPorId($id);
}

$lista_habitaciones = habitacionController::obtenerHabitaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestionar Habitaciones - FamilyConnect</title>
    <?php IncluirCSS(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="index-page">
    <?php MostrarMenu(); ?>
    <main class="main">
        <section id="gestionar-habitaciones" class="section" style="padding-top: 140px; padding-bottom: 60px;">
            <div class="container" data-aos="fade-up">
                <div class="container section-title">
                    <h2>Gestionar Habitaciones</h2>
                    <p>Administra las habitaciones, su tipo y disponibilidad.</p>
                </div>

                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert"><?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></div>
                <?php endif; ?>

                <div class="card mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header" style="background-color: var(--accent-color); color: var(--contrast-color);">
                        <h3 class="h5 mb-0 p-2"><?= $habitacion_to_edit ? 'Editar Habitación' : 'Añadir Nueva Habitación'; ?></h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="gestionar_habitaciones.php" method="POST">
                            <input type="hidden" name="action" value="<?= $habitacion_to_edit ? 'update' : 'create'; ?>">
                            <?php if ($habitacion_to_edit): ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($habitacion_to_edit['_id']); ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="numero" class="form-label">Número de Habitación</label>
                                    <input type="text" class="form-control" id="numero" name="numero" value="<?= htmlspecialchars($habitacion_to_edit['numero'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo" class="form-label">Tipo de Habitación</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="" disabled <?= !isset($habitacion_to_edit['tipo']) ? 'selected' : ''; ?>>Seleccione un tipo</option>
                                        <option value="Compartida" <?= (isset($habitacion_to_edit['tipo']) && $habitacion_to_edit['tipo'] == 'Compartida') ? 'selected' : ''; ?>>Compartida</option>
                                        <option value="Individual" <?= (isset($habitacion_to_edit['tipo']) && $habitacion_to_edit['tipo'] == 'Individual') ? 'selected' : ''; ?>>Individual</option>
                                        <option value="Suite" <?= (isset($habitacion_to_edit['tipo']) && $habitacion_to_edit['tipo'] == 'Suite') ? 'selected' : ''; ?>>Suite</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="disponible" name="disponible" <?= (isset($habitacion_to_edit['disponible']) && $habitacion_to_edit['disponible']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="disponible">
                                            Disponible
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><?= $habitacion_to_edit ? 'Actualizar Habitación' : 'Crear Habitación'; ?></button>
                            <?php if ($habitacion_to_edit): ?>
                                <a href="gestionar_habitaciones.php" class="btn btn-secondary">Cancelar Edición</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="card shadow p-4 rounded">
                    <h4 class="mb-4">Lista de Habitaciones</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Tipo</th>
                                    <th class="text-center">Disponible</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($lista_habitaciones) > 0): ?>
                                    <?php foreach ($lista_habitaciones as $hab): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($hab['numero']); ?></td>
                                            <td><?= htmlspecialchars($hab['tipo']); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?= $hab['disponible'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?= $hab['disponible'] ? 'Sí' : 'No'; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="gestionar_habitaciones.php?action=edit&id=<?= urlencode($hab['_id']); ?>#gestionar-habitaciones" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="gestionar_habitaciones.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta habitación?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($hab['_id']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay habitaciones registradas.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <?php MostrarFooter(); ?>
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>
    <?php IncluirScripts(); ?>
</body>
</html>