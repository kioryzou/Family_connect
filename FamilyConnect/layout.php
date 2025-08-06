<?php

function MostrarMenu(){
    echo '
    <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">FamilyConnect@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>(506)+ 2222-2222</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
       </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">FamilyConnect</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
             <li><a href="index.php">Inicio</a></li>
            <li><a href="sobreNosotros.php">Sobre Nosotros</a></li>
            <li><a href="servicios.php">Servicios</a></li>
            <li><a href="contacto.php">Contacto</a></li>
             <li><a href="login.php">Iniciar Sesión</a></li>
              <li><a href="logout.php">Cerrar Sesión</a></li>
            <li class="dropdown"><a href="#"><span>Actividades</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="retroalimentacion.php">Retroalimentacion</a></li>
                <li><a href="#">Mensaje Programados</a></li>
                
              </ul>
            </li>
                <li class="dropdown"><a href="#"><span>Residente</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                  <ul>
                    <li><a href="perfilResidente.php">Perfil de Residente</a></li>
                    <li><a href="appointmentForm.php">Reservar Visita</a></li>
                    <li><a href="#">Deep Dropdown 3</a></li>
                    <li><a href="#">Deep Dropdown 4</a></li>
                    <li><a href="#">Deep Dropdown 5</a></li>
                  </ul>
                </li>
            <li><a href="auth.php">Acceder</a></li>
          
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
     </div>

    </div>

  </header>';
}

function MostrarFooter(){
	echo '<footer class="footer">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-12 text-center">

                    <p class="copyright">
                        <!-- Link back to Colorlib cant be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                        </script> Todos los derechos reservados <a href="" target="_blank"></a>
                        <!-- Link back to Colorlib cant be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>';
}
function IncluirCSS() {
    echo '  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">';
}
  function IncluirScripts() {
    echo '  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>';
  }

?>