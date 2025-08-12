<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['admin']);
require_once __DIR__ . '/controller/familiarController.php';
require_once __DIR__ . '/controller/residenteController.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$familiar_to_edit = null;

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    $id = trim($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $parentesco = trim($_POST['parentesco']);
    $residente_id = trim($_POST['residente_id']);
    $clave = trim($_POST['clave']);

    // Validar ID familiar
    if (!preg_match('/^familiar_id_\d+$/', $id)) {
        $errores[] = "El ID debe tener formato familiar_id_#";
    }

    // Validar campos requeridos
    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    if ($telefono === '') $errores[] = "El teléfono es obligatorio.";
    if ($direccion === '') $errores[] = "La dirección es obligatoria.";
    if ($parentesco === '') $errores[] = "El parentesco es obligatorio.";
    if ($residente_id === '') $errores[] = "El residente asociado es obligatorio.";
    if (!preg_match('/^residente_id_\d+$/', $residente_id)) {
        $errores[] = "El residente_id debe tener formato residente_id_#";
    }
    if ($clave === '') $errores[] = "La clave es obligatoria.";

    // Validar que residente exista (usar controlador residente)
    $residenteExistente = residenteController::obtenerResidentePorId($residente_id);
    if (!$residenteExistente) {
        $errores[] = "No existe residente con ID $residente_id";
    }

    if (count($errores) > 0) {
        $_SESSION['error_message'] = implode('<br>', $errores);
        header("Location: gestionar_familiar.php");
        exit();
    }

    // Preparar datos para insertar
    $data = [
        '_id' => $id,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'parentesco' => $parentesco,
        'residente_id' => $residente_id,
        'clave' => $clave
    ];
echo "<pre>Datos que se intentan insertar:\n";
print_r($data);
echo "</pre>";
try {
    
    $resultado = familiarController::agregarFamiliar($data);
// Después de insertar:
var_dump($resultado);
    if ($resultado && $resultado->getInsertedId()) {
        $_SESSION['success_message'] = "Familiar creado exitosamente con ID $id.";
    } else {
        $_SESSION['error_message'] = "No se pudo insertar el familiar. Intenta de nuevo.";
        echo "<pre>Datos enviados a insertOne:\n";
        print_r($data);
        echo "\nResultado de insertOne:\n";
        var_dump($resultado);
        echo "</pre>";
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = "Error al crear familiar: " . $e->getMessage();
    echo "<pre>Excepción capturada:\n" . $e->getMessage() . "</pre>";
}

    header("Location: gestionar_familiar.php");
    exit();
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $parentesco = trim($_POST['parentesco']);
    $residente_id = trim($_POST['residente_id']);
    $clave = trim($_POST['clave']);

    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/', $nombre)) {
        $errores[] = "El nombre solo debe contener letras y espacios.";
    }
    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio.";
    }
    if (empty($direccion)) {
        $errores[] = "La dirección es obligatoria.";
    }
    if (empty($parentesco)) {
        $errores[] = "El parentesco es obligatorio.";
    }
    if (!preg_match('/^residente_id_\d+$/', $residente_id)) {
        $errores[] = "El residente_id debe tener el formato residente_id_X";
    }
    if (empty($clave)) {
        $errores[] = "La clave es obligatoria.";
    }

    if (count($errores) > 0) {
        $_SESSION['error_message'] = implode('<br>', $errores);
        header("Location: gestionar_familiar.php?action=edit&id=$id");
        exit();
    }

    $data = [
        'nombre' => $nombre,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'parentesco' => $parentesco,
        'residente_id' => $residente_id,
        'clave' => $clave
    ];

    familiarController::editarFamiliar($id, $data);
    $_SESSION['success_message'] = "Familiar actualizado exitosamente.";
    header("Location: gestionar_familiar.php");
    exit();
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    familiarController::eliminarFamiliar($id);
    $_SESSION['success_message'] = "Familiar eliminado exitosamente.";
    header("Location: gestionar_familiar.php");
    exit();
}

if ($action === 'edit' && $id) {
    $familiares = familiarController::obtenerFamiliares();
    foreach ($familiares as $f) {
        $fid = $f['_id'] ?? null;
        if ($fid == $id) {
            $familiar_to_edit = $f;
            break;
        }
    }
}

$lista_familiares = familiarController::obtenerFamiliares();

include('layout.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestionar Familiares - FamilyConnect</title>
    <?php IncluirCSS(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="index-page">
    <?php MostrarMenu(); ?>
    <main class="main">
        <section id="gestionar-familiares" class="section" style="padding-top: 140px; padding-bottom: 60px;">
            <div class="container" data-aos="fade-up">
                <div class="container section-title">
                    <h2>Gestionar Familiares</h2>
                    <p>Administra los familiares y su asociación con residentes.</p>
                </div>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="card mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header" style="background-color: var(--accent-color); color: var(--contrast-color);">
                        <h3 class="h5 mb-0 p-2"><?= $familiar_to_edit ? 'Editar Familiar' : 'Añadir Nuevo Familiar'; ?></h3>
                    </div>
                    <div class="card-body p-4">
                      <form action="gestionar_familiar.php" method="POST">
    <input type="hidden" name="action" value="<?= $familiar_to_edit ? 'update' : 'create'; ?>">
    <?php if (!empty($familiar_to_edit) && isset($familiar_to_edit['_id'])): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($familiar_to_edit['_id']); ?>">
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="id" class="form-label">ID Familiar</label>
            <input type="text" class="form-control" id="id" name="id" value="<?= isset($familiar_to_edit['_id']) ? htmlspecialchars($familiar_to_edit['_id']) : '' ?>" <?= $familiar_to_edit ? 'readonly' : 'required'; ?>>
            <div class="form-text"><?= $familiar_to_edit ? 'El ID no se puede cambiar.' : 'Debe tener formato familiar_id_#'; ?></div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($familiar_to_edit['nombre'] ?? ''); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($familiar_to_edit['telefono'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($familiar_to_edit['direccion'] ?? ''); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="parentesco" class="form-label">Parentesco</label>
            <input type="text" class="form-control" id="parentesco" name="parentesco" value="<?= htmlspecialchars($familiar_to_edit['parentesco'] ?? ''); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="residente_id" class="form-label">ID de Residente Asociado</label>
            <input type="text" class="form-control" id="residente_id" name="residente_id" value="<?= htmlspecialchars($familiar_to_edit['residente_id'] ?? ''); ?>" required placeholder="Ejemplo: residente_id_49">
            <div class="form-text">Ingrese el ID del residente asociado.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="clave" class="form-label">Clave</label>
            <input type="text" class="form-control" id="clave" name="clave" value="<?= htmlspecialchars($familiar_to_edit['clave'] ?? ''); ?>" required>
        </div>
    </div>

            <button type="submit" class="btn btn-primary"><?= $familiar_to_edit ? 'Actualizar Familiar' : 'Crear Familiar'; ?></button>
            <?php if ($familiar_to_edit): ?>
                <a href="gestionar_familiar.php" class="btn btn-secondary">Cancelar Edición</a>
            <?php endif; ?>
        </form>
                    </div>
                </div>

                <div class="card shadow p-4 rounded">
                    <h4 class="mb-4">Lista de Familiares</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Parentesco</th>
                                    <th>ID Residente</th>
                                    <th>Clave</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($lista_familiares) > 0): ?>
                                    <?php foreach ($lista_familiares as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['_id']); ?></td>
                                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                                            <td><?= htmlspecialchars($row['telefono']); ?></td>
                                            <td><?= htmlspecialchars($row['direccion']); ?></td>
                                            <td><?= htmlspecialchars($row['parentesco']); ?></td>
                                            <td><?= htmlspecialchars($row['residente_id']); ?></td>
                                            <td><?= htmlspecialchars($row['clave']); ?></td>
                                            <td class="text-center">
                                                <a href="gestionar_familiar.php?action=edit&id=<?= urlencode($row['_id']); ?>#gestionar-familiares" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="gestionar_familiar.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este familiar?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['_id']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay familiares registrados.</td>
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