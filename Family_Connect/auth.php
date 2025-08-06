<?php
 include('layout.php'); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Acceso - FamilyConnect</title>
  <meta name="description" content="Página de selección de acceso para FamilyConnect">
  <meta name="keywords" content="login, registro, familyconnect, acceso">
  <?php IncluirCSS();?>
</head>

<body class="auth-page">
   <?php MostrarMenu();?>

  <main class="main">
    <section id="auth-choice" class="auth-choice section" style="padding-top: 120px; padding-bottom: 120px;">
      <div class="container" data-aos="fade-up">

        <div class="container section-title text-center mb-5">
          <h2>Acceso de Usuarios</h2>
        </div>

        <div class="row justify-content-center gy-4">
          
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center d-flex flex-column p-4">
                <i class="bi bi-box-arrow-in-right fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Iniciar Sesión</h5>
                <p class="card-text">Ingresa desde aquí para acceder a la plataforma.</p>
                <a href="login.php" class="btn btn-primary mt-auto">Ir a Iniciar Sesión</a>
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