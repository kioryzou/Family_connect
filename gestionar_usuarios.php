<?php
session_start();
require_once '../config/db.php';

// --- LÓGICA PARA MANEJAR ACCIONES (CREAR, ACTUALIZAR, ELIMINAR) ---

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$user_to_edit = null;

// Procesar la creación de un nuevo usuario
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password) || empty($rol)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "El formato del email no es válido.";
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $rol);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Usuario creado exitosamente.";
        } else {
            $_SESSION['error_message'] = "Error al crear el usuario: " . $stmt->error;
        }
        $stmt->close();
    }
    header("Location: gestionar_usuarios.php");
    exit();
}

// Procesar la actualización de un usuario
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $password = $_POST['password'];

    if (empty($nombre) || empty($email) || empty($rol)) {
        $_SESSION['error_message'] = "Los campos nombre, email y rol son obligatorios.";
    } else {
        if (!empty($password)) {
            // Si se provee una nueva contraseña, se actualiza
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nombre, $email, $rol, $hashed_password, $id);
        } else {
            // Si no, se actualiza sin cambiar la contraseña
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Usuario actualizado exitosamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar el usuario: " . $stmt->error;
        }
        $stmt->close();
    }
    header("Location: gestionar_usuarios.php");
    exit();
}

// Procesar la eliminación de un usuario
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Usuario eliminado exitosamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar el usuario.";
    }
    $stmt->close();
    header("Location: gestionar_usuarios.php");
    exit();
}

// Cargar datos del usuario para editar
if ($action === 'edit' && $id) {
    $stmt = $conn->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_to_edit = $result->fetch_assoc();
    $stmt->close();
}

// --- VISTA HTML ---

// Obtener todos los usuarios para mostrarlos en la tabla
$result_usuarios = $conn->query("SELECT id, nombre, email, rol, fecha_creacion FROM usuarios ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Gestionar Usuarios</h1>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario para Crear o Editar Usuario -->
    <div class="card mb-4">
        <div class="card-header">
            <h3><?php echo $user_to_edit ? 'Editar Usuario' : 'Añadir Nuevo Usuario'; ?></h3>
        </div>
        <div class="card-body">
            <form action="gestionar_usuarios.php" method="POST">
                <input type="hidden" name="action" value="<?php echo $user_to_edit ? 'update' : 'create'; ?>">
                <?php if ($user_to_edit): ?>
                    <input type="hidden" name="id" value="<?php echo $user_to_edit['id']; ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user_to_edit['nombre'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_to_edit['email'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" <?php echo $user_to_edit ? '' : 'required'; ?>>
                        <?php if ($user_to_edit): ?>
                            <small class="form-text text-muted">Dejar en blanco para no cambiar la contraseña.</small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="miembro" <?php echo (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'miembro') ? 'selected' : ''; ?>>Miembro</option>
                            <option value="admin" <?php echo (isset($user_to_edit['rol']) && $user_to_edit['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $user_to_edit ? 'Actualizar Usuario' : 'Crear Usuario'; ?></button>
                <?php if ($user_to_edit): ?>
                    <a href="gestionar_usuarios.php" class="btn btn-secondary">Cancelar Edición</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card">
        <div class="card-header">
            <h3>Lista de Usuarios</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_usuarios->num_rows > 0): ?>
                            <?php while($row = $result_usuarios->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><span class="badge bg-<?php echo $row['rol'] === 'admin' ? 'success' : 'info'; ?>"><?php echo ucfirst($row['rol']); ?></span></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_creacion'])); ?></td>
                                    <td>
                                        <a href="gestionar_usuarios.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="gestionar_usuarios.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>