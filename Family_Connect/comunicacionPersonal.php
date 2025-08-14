<?php
session_start();
require_once __DIR__ . '/auth_helper.php';
require_once __DIR__ . '/controller/comunicacionController.php';
include('layout.php');

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'doctor', 'enfermero', 'cuidador'])) {
    header('Location: index.php');
    exit();
}

$residenteId = null;
$mensajes = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residenteId = trim($_POST['residente_id'] ?? '');
    if ($residenteId === '') {
        $error = "Debe ingresar un ID válido";
    } else {
        $mensajes = comunicacionController::obtenerMensajesPorResidente($residenteId);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mensajes de Familiares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <?php IncluirCSS(); ?>
</head>
<body>
    <?php MostrarMenu(); ?>

    <main class="container py-5">
        <h2>Mensajes para Residente</h2>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="residente_id" class="form-label">Ingrese el ID del Residente a Consultar</label>
                <input type="text" id="residente_id" name="residente_id" class="form-control" placeholder="Residente_id_" value="<?= htmlspecialchars($residenteId) ?>" required />
            </div>
            <button type="submit" class="btn btn-primary">Buscar mensajes</button>
        </form>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($residenteId && !$error): ?>
            <?php if (empty($mensajes)): ?>
                <div class="alert alert-info">No hay mensajes disponibles para este residente.</div>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($mensajes as $msg): ?>
                        <div class="list-group-item">
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($msg['fecha_envio'])) ?></small>
                            <p>
                                <?php
                                if ($msg['tipo'] === 'mensaje') {
                                    echo nl2br($msg['contenido']);
                                } elseif ($msg['tipo'] === 'imagen') {
                                    echo '<img src="' . $msg['contenido'] . '" alt="Imagen subida" class="img-fluid">';
                                } elseif ($msg['tipo'] === 'audio') {
                                    echo '<audio controls src="' . $msg['contenido'] . '"></audio>';
                                }
                                ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>

 
    <script src="ruta/a/comunicacion.js"></script>

</body>
</html>