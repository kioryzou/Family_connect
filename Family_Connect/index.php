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

<body class="index-page">
   <?php MostrarMenu();?>
  <main class="main">

    <section id="hero" class="hero section light-background">

      <img src="assets/img/principal.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative text-center" data-aos="fade-down" data-aos-delay="100">
          <h2 >BIENVENIDOS A FAMILY CONNECT</h2>
          <p style="color: rgb(255, 255, 255);">Nos alegra tenerte aqui, FamilyConnect es una plataforma diseñada para fortalecer los lazos <br> entre los adultos mayores en hodares de retiro y sus seres queridos  </p>
        </div>

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box " data-aos="zoom-out" data-aos-delay="200">
              <h3>Por que elegir FamilyConnect?</h3>
              <p>
                FamilyConnect es la solucion ideal para mantener a los adultos mayores conectados con sus familias. Nuestra plataforma ofrece una gestion sencilla de visitas, permitiendo a los familiares agendar, modificar o cancelar visitas de manera intuitiva. Ademas, facilita la comunicacion emocional continua, permitiendo enviar mensajes de voz, fotos o videos que los residentes reciben en momentos especiales.
              </p>
              <div class="text-center">
                <a href="sobreNosotros.php" class="more-btn"><span>Más información</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>Estadisticas de satisfaccion</h4>
                    <p>Estudios muestra que el contacto constante con familiares y las actvidades cognitivas mejoran notablemen
                       el estado de animo, reducen la sensacion de abandono y aumentan la participacion social en los residentes.</p>
                  </div>
                </div>

      
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-gem"></i>
                    <h4>Valor</h4>
                    <p>FamilyConnect aporta valor real al combinar tecnologia accesible, gestion eficiente y atencion emocional. Mejora la planificacion del hogar de retiro y brinda tranqulidad a las familias.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>


    <section id="gallery" class="gallery section">
    
      <div class="container section-title" data-aos="fade-up">
        <h2>Galeria</h2>
        <p>Nuestra misión es hacer que nuestros residentes se sientan como en su hogar.</p>
      </div>

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/1.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/1.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/2.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/3.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/4.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/5.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/5.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/6.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/6.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/7.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/7.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/8.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/8.jpg" alt="" class="img-fluid">
              </a>
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