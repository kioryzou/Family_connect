<?php
 include('layout.php'); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Registrarse - FamilyConnect</title>
  <meta name="description" content="Página de registro para FamilyConnect">
  <meta name="keywords" content="registro, familyconnect, crear cuenta">
  <?php IncluirCSS();?>
</head>

<body class="register-page">
   <?php MostrarMenu();?>

  <main class="main">
    <section id="register" class="register section" style="padding-top: 120px; padding-bottom: 120px;">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm">
              <div class="card-body p-4">
                <div class="container section-title text-center pb-0">
                  <h2 class="mb-2">Crear una Cuenta</h2>
                  <p>Completa el formulario para registrarte</p>
                </div>

                <form action="procesar_registro.php" method="post" role="form" class="php-email-form">
                  <div class="form-group mt-3">
                    <label for="fullname" class="form-label">Nombre Completo</label>
                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Su Nombre Completo" required>
                  </div>

                  <div class="form-group mt-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Su Correo" required>
                  </div>

                  <div class="form-group mt-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Cree una Contraseña" required>
                  </div>
                  
                  <div class="form-group mt-3">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirme su Contraseña" required>
                  </div>

                  <div class="text-center my-4">
                    <button class="btn btn-primary w-100" type="submit">Registrarse</button>
                  </div>
                  
                  <div class="text-center">
                    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>

</html>