<?php
session_start();
// En el futuro, aquí puedes añadir la lógica para verificar si el usuario es 'admin'
// y si no lo es, redirigirlo a otra página.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Family Connect</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Family Connect Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Panel de Administración</h1>
        <p class="col-md-8 fs-4">Bienvenido al panel de control. Desde aquí puedes gestionar las diferentes secciones de la aplicación.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body text-center p-4">
            <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
            <h2 class="card-title mt-3">Gestionar Usuarios</h2>
            <p class="card-text">Añade, edita o elimina usuarios de la plataforma y gestiona sus roles.</p>
            <a href="gestionar_usuarios.php" class="btn btn-primary">
              Ir a Gestionar Usuarios
            </a>
          </div>
        </div>
      </div>
      <!-- Aquí puedes añadir más tarjetas para otras funcionalidades -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>