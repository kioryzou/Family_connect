<?php
session_start();
require_once __DIR__ . '/auth_helper.php';
require_once __DIR__ . '/controller/comunicacionController.php';
include('layout.php');  

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'familiar'){
    header('Location: index.php');
    exit();
}

$mensaje = '';
$tipoSeleccionado = 'mensaje'; 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tipo = $_POST['tipo'] ?? 'mensaje';
    $tipoSeleccionado = $tipo; 
    $contenido = '';
    $familiarId = $_SESSION['user_id'];
    $residenteId = $_SESSION['residente_id'];

    if ($tipo === 'audio' || $tipo === 'imagen') {
        if(isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0){
            $uploadDir = __DIR__ . '/uploads/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $nombreArchivo = uniqid() . '_' . basename($_FILES['archivo']['name']);
            $rutaArchivo = $uploadDir . $nombreArchivo;

            if(move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)){
                $contenido = 'uploads/' . $nombreArchivo;
            } else {
                $mensaje = 'Error al subir el archivo.';
            }
        } else {
            $mensaje = 'Archivo no válido o no seleccionado.';
        }
    } else {
    
        $contenido = trim($_POST['mensaje'] ?? '');
    }

    if($contenido && !$mensaje){
        $datos = [
            'residente_id' => $residenteId,
            'familiar_id' => $familiarId,
            'tipo' => $tipo,
            'contenido' => $contenido,
            'fecha_envio' => (new DateTime())->format(DateTime::ATOM)
        ];

        if(comunicacionController::guardarMensaje($datos)){
            $mensaje = 'Mensaje enviado correctamente.';
        } else {
            $mensaje = 'Error al guardar el mensaje.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Comunicación Familiar</title>
    <?php IncluirCSS(); ?>
</head>
<body>
    <?php MostrarMenu(); ?>

    <main class="container py-5">
        <h2>Enviar Mensaje a Residente</h2>

        <?php if($mensaje): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de mensaje</label>
                <select id="tipo" name="tipo" class="form-select" onchange="mostrarInputArchivo(this.value)">
                    <option value="mensaje" <?= $tipoSeleccionado === 'mensaje' ? 'selected' : '' ?>>Mensaje de texto</option>
                    <option value="audio" <?= $tipoSeleccionado === 'audio' ? 'selected' : '' ?>>Audio</option>
                    <option value="imagen" <?= $tipoSeleccionado === 'imagen' ? 'selected' : '' ?>>Imagen</option>
                </select>
            </div>

            <div class="mb-3" id="input-mensaje" style="display: <?= $tipoSeleccionado === 'mensaje' ? 'block' : 'none' ?>;">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="3" class="form-control"><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>
            </div>

            <div class="mb-3" id="input-archivo" style="display: <?= $tipoSeleccionado !== 'mensaje' ? 'block' : 'none' ?>;">
                <label for="archivo" class="form-label">Subir archivo</label>
                <input type="file" name="archivo" id="archivo" class="form-control" accept="image/*,audio/*" />
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </main>

    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>

   <script src="comunicacion.js"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    const tipoSeleccionado = '<?= $tipoSeleccionado ?>';
    mostrarInputArchivo(tipoSeleccionado);
  });
</script>
</body>
</html>