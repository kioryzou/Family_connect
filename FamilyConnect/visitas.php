<?php

require 'vendor/autoload.php';
use MongoDB\Client;
$client = new Client("mongodb://localhost:27017");
$collection = $client->FamilyConnect->visitas;

$visitas = $collection->find()->toArray();

include('layout.php'); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>FamilyConnect</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <?php IncluirCSS(); ?>
</head>

<body>
  <?php MostrarMenu(); ?>
  <main>

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gestión de Visitas</h2>
        <p>
          FamilyConnect integra herramientas diseñadas para mejorar la experiencia en hogares de retiro,
          fortaleciendo la conexión emocional, organizando mejor las visitas y promoviendo el bienestar integral
          del residente.
        </p>
      </div>

      <!-- End Section Title -->

    <div class="container-visitas">


  <a href="appointmentForm.php" class="reservar-general">Reservar Visita</a>

  <table class="tabla-visitas">
    <thead>
      <tr>
        <th>Visitante</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Autorizada</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($visitas as $visita): ?>
        <tr>
          <td><?php echo htmlspecialchars($visita['nombre_visitante']); ?></td>
          <td><?php echo htmlspecialchars($visita['fecha']); ?></td>
          <td><?php echo htmlspecialchars($visita['hora']); ?></td>
          <td><?php echo $visita['autorizada'] ? ' Sí' : ' No'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


    </section>
    <!-- /Services Section -->
  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>

</html>
