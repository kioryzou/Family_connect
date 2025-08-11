<?php

session_start();
include('layout.php');
require_once __DIR__ . '/controller/visitaController.php';






// --- LÓGICA PARA MANEJAR ACCIONES (CREAR, ACTUALIZAR, ELIMINAR) ---
$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$visita_to_edit = null;

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => uniqid('visita_'),
        'residente_id' => $_POST['residente_id'],
        'nombre_visitante' => $_POST['nombre_visitante'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'autorizada' => isset($_POST['autorizada']) ? true : false
    ];
    visitaController::agregarVisita($data);
    $_SESSION['success_message'] = "Visita agregada exitosamente.";
    header("Location: gestionar_visitas.php");
    exit();
}




if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'residente_id' => $_POST['residente_id'],
        'nombre_visitante' => $_POST['nombre_visitante'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'autorizada' => isset($_POST['autorizada']) ? true : false
    ];
    visitaController::editarVisita($id, $data);
    $_SESSION['success_message'] = "Visita actualizada exitosamente.";
    header("Location: gestionar_visitas.php");
    exit();
}



if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    visitaController::eliminarVisita($id);
    $_SESSION['success_message'] = "Visita eliminada exitosamente.";
    header("Location: gestionar_visitas.php");
    exit();
}


if ($action === 'edit' && $id) {
    $visitas = visitaController::obtenerVisitas();
    foreach ($visitas as $v) {
        $vid = $v['id'] ?? ($v['_id'] ?? null);
        if ($vid && $vid == $id) {
            $visita_to_edit = $v;
            break;
        }
    }
}


$lista_visitas = visitaController::obtenerVisitas();
?>
<head>
    <meta charset="UTF-8">
    <title>Gestionar Visitas</title>
    <?php IncluirCSS(); ?>
</head>
<body>
    <?php MostrarMenu(); ?>
    <main class="container py-5">
        <h2 class="text-center mb-4">Gestionar Visitas</h2>
        <table class="table table-bordered">
            <thead>


        <!-- Mensajes de éxito -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success text-center"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>



        <!-- Formulario para Crear o Editar Visita -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><?php echo $visita_to_edit ? 'Editar Visita' : 'Añadir Nueva Visita'; ?></h3>
            </div>
            <div class="card-body">
                <form action="gestionar_visitas.php" method="POST">
                    <input type="hidden" name="action" value="<?php echo $visita_to_edit ? 'update' : 'create'; ?>">
                    <?php if ($visita_to_edit): ?>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($visita_to_edit['id'] ?? $visita_to_edit['_id'] ?? ''); ?>">
                     <?php endif; ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="residente_id" class="form-label">ID Residente</label>
                            <input type="text" class="form-control" id="residente_id" name="residente_id" value="<?php echo htmlspecialchars($visita_to_edit['residente_id'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nombre_visitante" class="form-label">Nombre Visitante</label>
                            <input type="text" class="form-control" id="nombre_visitante" name="nombre_visitante" value="<?php echo htmlspecialchars($visita_to_edit['nombre_visitante'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($visita_to_edit['fecha'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="hora" name="hora" value="<?php echo htmlspecialchars($visita_to_edit['hora'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="autorizada" name="autorizada" <?php echo (isset($visita_to_edit['autorizada']) && $visita_to_edit['autorizada']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="autorizada">Autorizada</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $visita_to_edit ? 'Actualizar Visita' : 'Crear Visita'; ?></button>
                    <?php if ($visita_to_edit): ?>
                        <a href="gestionar_visitas.php" class="btn btn-secondary">Cancelar Edición</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Tabla de Visitas -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Visitas Progaramadas
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Residente</th>
                                <th>Visitante</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Autorizada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_visitas as $visita): ?>
                            <tr>
                                <td><?= isset($visita['id']) ? htmlspecialchars($visita['id']) : (isset($visita['_id']) ? htmlspecialchars($visita['_id']) : '') ?></td>
                                <td><?= htmlspecialchars($visita['residente_id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($visita['nombre_visitante'] ?? '') ?></td>
                                <td><?= htmlspecialchars($visita['fecha'] ?? '') ?></td>
                                <td><?= htmlspecialchars($visita['hora'] ?? '') ?></td>
                                <td><?= (isset($visita['autorizada']) && $visita['autorizada']) ? 'Sí' : 'No' ?></td>
                                <td>
                                  <a href="gestionar_visitas.php?action=edit&id=<?= isset($visita['id']) ? urlencode($visita['id']) : (isset($visita['_id']) ? urlencode($visita['_id']) : '') ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">Editar</a>

                                    <form action="gestionar_visitas.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta visita?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= isset($visita['id']) ? htmlspecialchars($visita['id']) : (isset($visita['_id']) ? htmlspecialchars($visita['_id']) : '') ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>
</body>
</html>