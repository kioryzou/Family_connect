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
<!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/imagen2.webp" class="img-fluid" alt="">
            <!-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a> -->
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>Sobre FAMILY CONNECT</h3>
            <p>
              FamilyConnect es una plataforma innovadora que busca mejorar la calidad de vida de los adultos mayores en hogares de retiro, facilitando la comunicacion y el contacto con sus seres queridos. Nuestra mision es crear un espacio donde las familias puedan mantenerse conectadas, compartiendo momentos significativos y apoyando a sus seres queridos en su dia a dia.
            </p>
            <ul>
              <li>
                <i class="fa-solid fa-calendar-check"></i>
                <div>
                  <h5>Gestion facil y rapida de visitas</h5>
                  <p>Los familiares pueden agenedr, modificar o cancelar visitas de forma intuitiva, evitando conflictos de horarios y mejorando la organizacion del hogar de retiro</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-comments"></i>
                <div>
                  <h5>comunicacion emocional continua</h5>
                  <p>Permite enviar mensajes de voz, fotos o videos que los residentes reciben en momentos especiales, incluso si no usan dispositivos electronicos.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-brain"></i>
                <div>
                  <h5>Actividades para la memoria y socializacion</h5>
                  <p>Integra actividades interactivas para estimular la memoria y promover la interaccion social, con estimulacion visible para los familiares </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
    </div>
 </section><!-- /About Section -->
  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>

</html>