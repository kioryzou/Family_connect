<?php
require_once __DIR__ . '/auth_helper.php'; 
protect_page(['admin']);

require_once __DIR__ . '/controller/BaseDatos.php';
$db = AbrirBDMongo();
$collection = $db->usuarios;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$user_to_edit = null;

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_POST['user_id']);  
    $nombre = trim($_POST['nombre']);
    $correo = strtolower(trim($_POST['correo']));
    $password = $_POST['clave'];
    $rol = $_POST['rol'];

    if (empty($user_id) || empty($nombre) || empty($correo) || empty($password) || empty($rol)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
    } elseif (!preg_match('/^usuario_id_\d+$/', $user_id)) {
        $_SESSION['error_message'] = "El ID debe tener el formato usuario_id_X, donde X es un número.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "El formato del correo electrónico no es válido.";
    } else {
        $existeId = $collection->findOne(['_id' => $user_id]);
        $existeCorreo = $collection->findOne(['correo' => $correo]);
        if ($existeId) {
            $_SESSION['error_message'] = "El ID de usuario ya existe.";
        } elseif ($existeCorreo) {
            $_SESSION['error_message'] = "El correo ya está registrado.";
        } else {
            try {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $newUser = [
                    '_id' => $user_id,
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'clave' => $hashed_password,
                    'rol' => $rol,
                    'activo' => true,
                ];
                $collection->insertOne($newUser);
                $_SESSION['success_message'] = "Usuario creado exitosamente con ID: $user_id";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error inesperado al crear el usuario: " . $e->getMessage();
            }
        }
    }
    header("Location: gestionar_usuarios.php");
    exit();
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = strtolower(trim($_POST['correo']));
    $rol = $_POST['rol'];
    $password = $_POST['clave'];
    $activo = $_POST['activo'] === 'true';

    if (empty($nombre) || empty($correo) || empty($rol) || empty($id)) {
        $_SESSION['error_message'] = "Los campos nombre, correo y rol son obligatorios.";
    } else {
        try {
            $usuarioActual = $collection->findOne(['_id' => $id]);
            if ($usuarioActual && $usuarioActual['correo'] !== $correo) {
                $existeCorreo = $collection->findOne(['correo' => $correo]);
                if ($existeCorreo) {
                    $_SESSION['error_message'] = "El correo ya está registrado por otro usuario.";
                    header("Location: gestionar_usuarios.php");
                    exit();
                }
            }

            $updateData = [
                'nombre' => $nombre,
                'correo' => $correo,
                'rol' => $rol,
                'activo' => $activo
            ];
            if (!empty($password)) {
                $updateData['clave'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $updateResult = $collection->updateOne(
                ['_id' => $id],
                ['$set' => $updateData]
            );
            if ($updateResult->getModifiedCount() > 0) {
                $_SESSION['success_message'] = "Usuario actualizado exitosamente.";
            } else {
                $_SESSION['success_message'] = "No se realizaron cambios en el usuario.";
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error al actualizar el usuario: " . $e->getMessage();
        }
    }
    header("Location: gestionar_usuarios.php");
    exit();
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $deleteResult = $collection->deleteOne(['_id' => $id]);
        if ($deleteResult->getDeletedCount() > 0) {
            $_SESSION['success_message'] = "Usuario eliminado exitosamente.";
        } else {
            $_SESSION['error_message'] = "No se encontró el usuario para eliminar.";
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al eliminar el usuario: " . $e->getMessage();
    }
    header("Location: gestionar_usuarios.php");
    exit();
}

if ($action === 'edit' && $id) {
    $user_to_edit = $collection->findOne(['_id' => $id]);
}

$result_usuarios = $collection->find([], ['sort' => ['nombre' => 1]]);


include('layout.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Gestionar Usuarios - FamilyConnect</title>
  <?php IncluirCSS(); ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .section {
            background-color: #f9f9f9;
        }
        .card {
            border: none;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .form-control, .form-select {
            height: 44px;
        }
        .table-responsive {
            border-radius: 8px;
            overflow-x: auto;
        }
    </style>
</head>
<body class="index-page"> 
  <?php MostrarMenu(); ?>

  <main class="main">
    <section id="gestionar-usuarios" class="section" style="padding-top: 140px; padding-bottom: 60px;">
      <div class="container" data-aos="fade-up">

        <div class="container section-title">
          <h2>Gestionar Usuarios</h2>
          <p>Administra los usuarios del sistema, sus roles y credenciales.</p>
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
            <h3 class="h5 mb-0 p-2"><?= $user_to_edit ? 'Editar Usuario' : 'Añadir Nuevo Usuario'; ?></h3>
          </div>
          <div class="card-body p-4">
            <form action="gestionar_usuarios.php" method="POST">
              <input type="hidden" name="action" value="<?= $user_to_edit ? 'update' : 'create'; ?>">
              <?php if ($user_to_edit): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($user_to_edit['_id']); ?>">
              <?php endif; ?>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="user_id" class="form-label">ID de Usuario</label>
                  <input type="text" class="form-control" id="user_id" name="user_id" value="<?= htmlspecialchars($user_to_edit['_id'] ?? ''); ?>" <?= $user_to_edit ? 'readonly' : 'required'; ?> >
                  <div class="form-text"><?= $user_to_edit ? 'El ID de usuario no se puede cambiar.' : 'Este será el ID para iniciar sesión.'; ?></div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="nombre" class="form-label">Nombre Completo</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($user_to_edit['nombre'] ?? ''); ?>" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="correo" class="form-label">Correo Electrónico</label>
                  <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($user_to_edit['correo'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="clave" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="clave" name="clave" <?= $user_to_edit ? '' : 'required'; ?>>
                  <div class="form-text"><?= $user_to_edit ? 'Dejar en blanco para no cambiar la contraseña.' : 'Contraseña para el nuevo usuario.'; ?></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="rol" class="form-label">Rol</label>
                  <select class="form-select" id="rol" name="rol" required>
                    <option value="" disabled <?= !isset($user_to_edit['rol']) ? 'selected' : ''; ?>>Seleccione un rol</option>
                    <option value="admin" <?= (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="cuidador" <?= (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'cuidador') ? 'selected' : ''; ?>>Cuidador</option>
                    <option value="doctor" <?= (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'doctor') ? 'selected' : ''; ?>>Doctor</option>
                    <option value="enfermero" <?= (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'enfermero') ? 'selected' : ''; ?>>Enfermero</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="activo" class="form-label">Estado</label>
                  <select class="form-select" id="activo" name="activo" required>
                    <option value="true" <?= (isset($user_to_edit['activo']) && $user_to_edit['activo']) ? 'selected' : ''; ?>>Activo</option>
                    <option value="false" <?= (isset($user_to_edit['activo']) && !$user_to_edit['activo']) ? 'selected' : ''; ?>>Inactivo</option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary"><?= $user_to_edit ? 'Actualizar Usuario' : 'Crear Usuario'; ?></button>
              <?php if ($user_to_edit): ?>
                <a href="gestionar_usuarios.php" class="btn btn-secondary">Cancelar Edición</a>
              <?php endif; ?>
            </form>
          </div>
        </div>



        

        <?php
  $usuarios_por_pagina = 10;
  $pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;

  $usuarios_array = iterator_to_array($result_usuarios);
  $total_usuarios = count($usuarios_array);

  $indice_inicio = ($pagina_actual - 1) * $usuarios_por_pagina;
  $usuarios_pagina = array_slice($usuarios_array, $indice_inicio, $usuarios_por_pagina);
  $total_paginas = ceil($total_usuarios / $usuarios_por_pagina);
?>

<div class="card shadow p-4 rounded">
    
  <h4 class="mb-4">Lista de Usuarios</h4>
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Email</th>
          <th>Nombre</th>
          <th>Rol</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($usuarios_pagina) > 0): ?>
          <?php foreach($usuarios_pagina as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['_id']); ?></td>
              <td><?= htmlspecialchars($row['nombre']); ?></td>
              <td>
                <span class="badge text-bg-<?= $row['rol'] === 'admin' ? 'success' : 'secondary'; ?>">
                  <?= ucfirst($row['rol']); ?>
                </span>
              </td>
              <td class="text-center">
                <a href="gestionar_usuarios.php?action=edit&id=<?= urlencode($row['_id']); ?>#gestionar-usuarios" class="btn btn-sm btn-warning" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <form action="gestionar_usuarios.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
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
            <td colspan="4" class="text-center">No hay usuarios registrados.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Paginación -->
  <?php if ($total_paginas > 1): ?>
    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
          <li class="page-item <?= $i === $pagina_actual ? 'active' : ''; ?>">
            <a class="page-link" href="?pagina=<?= $i; ?>#gestionar-usuarios"><?= $i; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
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
