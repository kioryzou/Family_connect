<?php
 include('layout.php'); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Iniciar Sesión - FamilyConnect</title>
  <meta name="description" content="Página de inicio de sesión para FamilyConnect">
  <meta name="keywords" content="login, familyconnect, inicio de sesion">
  <?php IncluirCSS();?>
</head>

<body class="login-page">
   <?php MostrarMenu();?>

  <main class="main">
    <section id="login" class="login section" style="padding-top: 120px; padding-bottom: 120px;">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-8">
            <div class="card shadow-sm">
              <div class="card-body p-4">
                <div class="container section-title text-center pb-0">
                  <h2 class="mb-2">Iniciar Sesión</h2>
                  <p>Ingrese sus credenciales para acceder</p>
                </div>

                <form action="procesar_login.php" method="post" role="form" class="php-email-form">
                  <div class="form-group mt-3">
                    <label for="username" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="username" placeholder="Su Correo" required>
                  </div>

                  <div class="form-group mt-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Su Contraseña" required>
                  </div>

                  <div class="text-center my-4">
                    <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>

</html>