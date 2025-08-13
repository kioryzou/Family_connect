<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['admin']);
require_once __DIR__ . '/controller/residenteController.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$residente_to_edit = null;

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];
    $id = trim($_POST['id']);
    $nombre = $_POST['nombre'];
    $edad = (int)$_POST['edad'];
    $genero = $_POST['genero'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $habitacion = $_POST['habitacion'];
    $estado_salud = $_POST['estado_salud'];

    // Validaciones
    if (!preg_match('/^residente_id_\d+$/', $id)) {
        $errores[] = "El ID debe tener el formato residente_id_X";
    }
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/', $nombre)) {
        $errores[] = "El nombre solo debe contener letras y espacios.";
    }
    if ($edad < 0 || $edad > 130) {
        $errores[] = "La edad debe estar entre 0 y 130.";
    }
    if (!in_array($genero, ['Masculino', 'Femenino', 'Prefiere no decir'])) {
        $errores[] = "El género debe ser Masculino, Femenino o Prefiere no decir.";
    }
    if (empty($habitacion)) {
        $errores[] = "La habitación es obligatoria.";
    }
    if (empty($estado_salud)) {
        $errores[] = "El estado de salud es obligatorio.";
    }
    // Validar fecha
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha_ingreso);
    if (!$fechaObj) {
        $errores[] = "La fecha de ingreso no es válida.";
    }

    if (count($errores) > 0) {
        $_SESSION['error_message'] = implode('<br>', $errores);
        header("Location: gestionar_residentes.php");
        exit();
    }

    // Transformar fecha a MongoDB\BSON\UTCDateTime
    $fechaMongo = new MongoDB\BSON\UTCDateTime($fechaObj->getTimestamp() * 1000);

    $data = [
        '_id' => $id,
        'nombre' => $nombre,
        'edad' => $edad,
        'genero' => $genero,
        'fecha_ingreso' => $fechaMongo,
        'habitacion' => $habitacion,
        'estado_salud' => $estado_salud
    ];
    residenteController::agregarResidente($data);
    $_SESSION['success_message'] = "Residente creado exitosamente.";
    header("Location: gestionar_residentes.php");
    exit();
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];
    $nombre = $_POST['nombre'];
    $edad = (int)$_POST['edad'];
    $genero = $_POST['genero'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $habitacion = $_POST['habitacion'];
    $estado_salud = $_POST['estado_salud'];

    // Validaciones
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/', $nombre)) {
        $errores[] = "El nombre solo debe contener letras y espacios.";
    }
    if ($edad < 0 || $edad > 130) {
        $errores[] = "La edad debe estar entre 0 y 130.";
    }
    if (!in_array($genero, ['Masculino', 'Femenino', 'Prefiere no decir'])) {
        $errores[] = "El género debe ser Masculino, Femenino o Prefiere no decir.";
    }
    if (empty($habitacion)) {
        $errores[] = "La habitación es obligatoria.";
    }
    if (empty($estado_salud)) {
        $errores[] = "El estado de salud es obligatorio.";
    }
    // Validar fecha
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha_ingreso);
    if (!$fechaObj) {
        $errores[] = "La fecha de ingreso no es válida.";
    }

    if (count($errores) > 0) {
        $_SESSION['error_message'] = implode('<br>', $errores);
        header("Location: gestionar_residentes.php?action=edit&id=$id");
        exit();
    }

    // Transformar fecha a MongoDB\BSON\UTCDateTime
    $fechaMongo = new MongoDB\BSON\UTCDateTime($fechaObj->getTimestamp() * 1000);

    $data = [
        'nombre' => $nombre,
        'edad' => $edad,
        'genero' => $genero,
        'fecha_ingreso' => $fechaMongo,
        'habitacion' => $habitacion,
        'estado_salud' => $estado_salud
    ];
    residenteController::editarResidente($id, $data);
    $_SESSION['success_message'] = "Residente actualizado exitosamente.";
    header("Location: gestionar_residentes.php");
    exit();
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        residenteController::eliminarResidente($id);
        $_SESSION['success_message'] = "Residente eliminado exitosamente.";
        header("Location: gestionar_residentes.php");
        exit();
}

if ($action === 'edit' && $id) {
        $residentes = residenteController::obtenerResidentes();
        foreach ($residentes as $r) {
                $rid = $r['id'] ?? ($r['_id'] ?? null);
                if ($rid == $id) {
                    $residente_to_edit = $r;
                    break;
                }
        }
}

$lista_residentes = residenteController::obtenerResidentes();
include('layout.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestionar Residentes - FamilyConnect</title>
    <?php IncluirCSS(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="index-page">
    <?php MostrarMenu(); ?>
    <main class="main">
        <section id="gestionar-residentes" class="section" style="padding-top: 140px; padding-bottom: 60px;">
            <div class="container" data-aos="fade-up">
                <div class="container section-title">
                    <h2>Gestionar Residentes</h2>
                    <p>Administra los residentes del sistema y sus datos personales.</p>
                </div>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert" >
                        <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>
                <div class="card mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header" style="background-color: var(--accent-color); color: var(--contrast-color);">
                        <h3 class="h5 mb-0 p-2"><?= $residente_to_edit ? 'Editar Residente' : 'Añadir Nuevo Residente'; ?></h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="gestionar_residentes.php" method="POST">
                            <input type="hidden" name="action" value="<?= $residente_to_edit ? 'update' : 'create'; ?>">
                           <?php if (!empty($residente_to_edit) && isset($residente_to_edit['id'])): ?>
                           <input type="hidden" name="id" value="<?= htmlspecialchars($residente_to_edit['id']); ?>">
                           <?php endif; ?>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="id" class="form-label">ID Residente</label>
                                    <input type="text" class="form-control" id="id" name="id" value="<?= isset($residente_to_edit['id']) ? htmlspecialchars($residente_to_edit['id']) : (isset($residente_to_edit['_id']) ? htmlspecialchars($residente_to_edit['_id']) : '') ?>" <?= $residente_to_edit ? 'readonly' : 'required'; ?> >
                                    <div class="form-text"><?= $residente_to_edit ? 'El ID no se puede cambiar.' : 'Este será el identificador único del residente.'; ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nombre" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($residente_to_edit['nombre'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edad" class="form-label">Edad</label>
                                    <input type="number" class="form-control" id="edad" name="edad" value="<?= htmlspecialchars($residente_to_edit['edad'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="" disabled <?= !isset($residente_to_edit['genero']) ? 'selected' : ''; ?>>Seleccione género</option>
                                        <option value="Masculino" <?= (isset($residente_to_edit['genero']) && $residente_to_edit['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="Femenino" <?= (isset($residente_to_edit['genero']) && $residente_to_edit['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                    <?php
                                    $fecha_valor = '';
                                    if (isset($residente_to_edit['fecha_ingreso'])) {
                                        if ($residente_to_edit['fecha_ingreso'] instanceof MongoDB\BSON\UTCDateTime) {
                                            $fecha_valor = $residente_to_edit['fecha_ingreso']->toDateTime()->format('Y-m-d');
                                        } elseif (is_numeric($residente_to_edit['fecha_ingreso'])) {
                                            $fecha_valor = (new DateTime('@' . ($residente_to_edit['fecha_ingreso'] / 1000)))->format('Y-m-d');
                                        } else {
                                            $fecha_valor = htmlspecialchars($residente_to_edit['fecha_ingreso']);
                                        }
                                    }
                                    ?>
                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?= $fecha_valor ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="habitacion" class="form-label">Habitación</label>
                                    <input type="text" class="form-control" id="habitacion" name="habitacion" value="<?= htmlspecialchars($residente_to_edit['habitacion'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="estado_salud" class="form-label">Estado de Salud</label>
                                    <input type="text" class="form-control" id="estado_salud" name="estado_salud" value="<?= htmlspecialchars($residente_to_edit['estado_salud'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= $residente_to_edit ? 'Actualizar Residente' : 'Crear Residente'; ?></button>
                            <?php if ($residente_to_edit): ?>
                                <a href="gestionar_residentes.php" class="btn btn-secondary">Cancelar Edición</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="card shadow p-4 rounded">
                    <h4 class="mb-4">Lista de Residentes</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Género</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Habitación</th>
                                    <th>Estado Salud</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($lista_residentes) > 0): ?>
                                    <?php foreach($lista_residentes as $row): ?>
                                        <tr>
                                            <td><?= isset($row['id']) ? htmlspecialchars($row['id']) : (isset($row['_id']) ? htmlspecialchars($row['_id']) : ''); ?></td>
                                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                                            <td><?= htmlspecialchars($row['edad']); ?></td>
                                            <td><?= htmlspecialchars($row['genero']); ?></td>
                                            <td>
                                                <?php
                                                if (isset($row['fecha_ingreso'])) {
                                                    if ($row['fecha_ingreso'] instanceof MongoDB\BSON\UTCDateTime) {
                                                        echo $row['fecha_ingreso']->toDateTime()->format('Y-m-d');
                                                    } elseif (is_numeric($row['fecha_ingreso'])) {
                                                        echo (new DateTime('@' . ($row['fecha_ingreso'] / 1000)))->format('Y-m-d');
                                                    } else {
                                                        echo htmlspecialchars($row['fecha_ingreso']);
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($row['habitacion']); ?></td>
                                            <td><?= htmlspecialchars($row['estado_salud']); ?></td>
                                            <td class="text-center">
                                                <a href="gestionar_residentes.php?action=edit&id=<?= isset($row['id']) ? urlencode($row['id']) : (isset($row['_id']) ? urlencode($row['_id']) : '') ?>#gestionar-residentes" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="gestionar_residentes.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este residente?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= isset($row['id']) ? htmlspecialchars($row['id']) : (isset($row['_id']) ? htmlspecialchars($row['_id']) : '') ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay residentes registrados.</td>
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