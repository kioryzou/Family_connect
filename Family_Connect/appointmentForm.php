<?php
require_once __DIR__ . '/auth_helper.php';
protect_page(['familiar']); 

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

<body class="about-page">
   <?php MostrarMenu();?>

  <main class="main">

    <section id="appointment" class="appointment section">

      <div class="container section-title text-center my-5" data-aos="fade-up">
        <h2>Visita</h2>
        <p>Reserve su visita llenando el formulario</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-4 form-group">
                <label for="date" class="form-label">Nombre Completo</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
                <label for="date" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
                <label for="date" class="form-label">Número de Teléfono</label>
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Número de Teléfono" required="">
            </div>
          </div>
          <div class="row ">
            <div class="col-md-4 form-group mt-3">
                <label for="date" class="form-label">Fecha de Cita</label>
              <input type="datetime-local" name="date" class="form-control datepicker " id="date" placeholder="Fecha de Cita" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
                <label for="residente_id" class="form-label">ID del Residente</label>
                <input type="text" class="form-control" name="residente_id" id="residente_id" placeholder="ID del Residente" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Mensaje (Opcional)"></textarea>
          </div>
          <div class="mt-3">
            <div class="loading">Cargando</div>
            <div class="error-message"></div>
            <div class="sent-message">Su visita ha sido reserva con éxito.</div>
            <div class="text-center my-2"><button class="btn btn-outline-light bg-primary" type="submit">Agendar Cita</button></div>
             </div>
          </div>
        </form>
     </div>
  </section>
</main>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>
</html>
