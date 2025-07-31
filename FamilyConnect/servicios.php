
<?php
 include('layout.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>FamilyConnect</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
<?php IncluirCSS();?>
</head>

<body>
   <?php MostrarMenu();?>
  <main>
<!-- Services Section -->
<section id="services" class="services section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Servicios del Sistema</h2>
    <p>FamylyConnect integra herramientas diseñadas para mejorar la experiencia en hogares de retiro, fortaleciendo la conexión emocional, organizando mejor las visitas y promoviendo el bienestar integral del residente.</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <h3>Gestión de Visitas</h3>
          <p>Permite a los familiares agendar, modificar o cancelar visitas fácilmente. El personal puede aceptar o reorganizar los horarios para evitar conflictos y garantizar orden.</p>
          
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-voicemail"></i>
          </div>
          <h3>Mensajes Programados</h3>
          <p>Los familiares pueden enviar mensajes de voz, fotos o videos. Estos se muestran a los residentes en momentos específicos, ideal para quienes no usan tecnología por sí mismos.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-brain"></i>
          </div>
          <h3>Gamificación Cognitiva</h3>
          <p>Incluye juegos y actividades diseñadas para estimular la memoria, aumentar la interacción social y promover la actividad mental diaria de los residentes.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-user-circle"></i>
          </div>
          <h3>Perfil del Residente</h3>
          <p>Registra información relevante del residente: datos personales, historial médico, habitación asignada y familiares vinculados, facilitando la gestión centralizada.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <h3>Gestión de Familiares</h3>
          <p>Permite registrar y administrar familiares autorizados por cada residente, controlar el acceso al sistema y facilitar la interacción programada con el adulto mayor.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Seguridad y Control</h3>
          <p>El sistema contribuye a una mejor organización interna y control de acceso a la información y visitas, reforzando la seguridad emocional y física de los residentes.</p>
        </div>
      </div><!-- End Service Item -->

    </div>

  </div>

</section><!-- /Services Section -->
  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>

</html>