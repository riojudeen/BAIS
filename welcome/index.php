
<?php

//////////////////////////////////////////////////////////////////////
include("../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <style>
    @font-face {
        font-family: hotel_de_paris;
        src: url('fonts/hotel_de_paris.ttf') format('truetype');
    }
    .judul{
      font-family :hotel_de_paris;
    }
  </style>

  <title>Welcome to BAIS!</title>

  <!-- Bootstrap Core CSS -->
  <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom Fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href=".../ccs/font_family.css" rel="stylesheet" type="text/css"> -->
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/stylish-portfolio.min.css" rel="stylesheet">
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url();?>/assets/img//apple-icon.png">
  <link rel="icon" href="<?=base_url();?>/assets/img/img/logo.png" type="image/png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?=base_url();?>/assets/css/css.css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="<?=base_url();?>/assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="<?=base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" />


</head>

<body id="page-top">

  <!-- Navigation -->
  <a class="menu-toggle rounded" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <a class="js-scroll-trigger" href="#page-top">Navigasi</a>
      </li>
      <li class="sidebar-nav-item">
        <a href="../auth/login.php" class="js-scroll-trigger" href="#page-top">Login</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="#about">About</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="#services">Services</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="#portfolio">Coming Soon</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="js-scroll-trigger" href="../dashboard/administrasi/in_out.php">Attendance Monitor</a>
      </li>
    </ul>
  </nav>

  <!-- Header -->
  <header class="masthead d-flex">
    <div class="container text-center my-auto">
      <h1 class="mb-1 judul">BAIS</h1>
      <h3 class="mb-5">
        <em>Body Administration & Information System</em>
      </h3>
      <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Tentang BAIS</a>
    </div>
    <div class="overlay"></div>
  </header>

  <!-- About -->
  <section class="content-section bg-light" id="about">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <h2>DIGITALIZATION X ADMIN</h2>
          <p class="lead mb-5">Hasil kolaborasi untuk membuat setiap proses administrasi di Internal Divisi Body menjadi lebih mudah.
            Kami memahami keterbatasan di sistem HR yang ada sekarang. Kami ingin merespon semua keinginan Anda dengan cepat. Kami ingin
            memberi solusi untuk kecepatan proses Administrasi dan Penyediaan media informasi yang dapat diakses dari mejamu. Gunakan tenagamu, untuk
            hal yang lebih penting!</p>
          <a class="btn btn-dark btn-xl js-scroll-trigger my-5" href="#services">Service</a>
          <a class="btn btn-dark btn-xl js-scroll-trigger my-5 bg-primary" href="../auth/login.php">Login sekarang!</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="content-section bg-primary text-white text-center" id="services">
    <div class="container">
      <div class="content-section-heading">
        <h3 class="text-white mb-0">Services</h3>
        <h2 class="mb-5">Help You to Service</h2>
      </div>
      <div class="row">
        
        <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-pencil"></i>
          </span>
          <h4>
            <strong>Monitoring</strong>
          </h4>
          <p class="text-faded mb-0">Lakukan monitoring melalui layar komputer anda. Dapatkan informasi tanpa harus bertanya kepada Admin Area</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-like"></i>
          </span>
          <h4>
            <strong>Request</strong>
          </h4>
          <p class="text-faded mb-0">Anda dapat mengajukan proses administrasi tanpa mencetak dokumen & formulir. Lakukan semuanya dengan BAIS
            <i class="fas fa-heart"></i>
            Start Bootstrap!</p>
        </div>
        <div class="col-lg-3 col-md-6">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-mustache"></i>
          </span>
          <h4>
            <strong>Control</strong>
          </h4>
          <p class="text-faded mb-0">Semua pengajuanmu dapat dilihat secara realtime. Pastikan jangan sampai Anda kehilangan dokument yang berharga!</p>
        </div>
        <div class="col-lg-3 col-md-6">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-mustache"></i>
          </span>
          <h4>
            <strong>Cost Monitoring</strong>
          </h4>
          <p class="text-faded mb-0">Dedesain untuk control Labour Cost semudah menghidupkan komputer anda</p>
        </div>
      </div>
    </div>
  </section>

  
  <!-- Portfolio -->
  <section class="content-section" id="portfolio">
    <div class="container">
      <div class="content-section-heading text-center">
        <h3 class="text-secondary mb-0">development</h3>
        <h2 class="mb-5">Recent Project</h2>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6">
          <a class="portfolio-item" href="#!">
            <div class="caption">
              <div class="caption-content">
                <div class="h2">SPL Online</div>
                <p class="mb-0">coming soon</p>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio-1.jpg" alt="">
          </a>
        </div>
        <div class="col-lg-6">
          <a class="portfolio-item" href="#!">
            <div class="caption">
              <div class="caption-content">
                <div class="h2">Monitoring Absen</div>
                <p class="mb-0">Coming Soon</p>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio-2.jpg" alt="">
          </a>
        </div>
        <div class="col-lg-6">
          <a class="portfolio-item" href="#!">
            <div class="caption">
              <div class="caption-content">
                <div class="h2">Pengjuan Absen</div>
                <p class="mb-0">Coming Soon</p>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio-3.jpg" alt="">
          </a>
        </div>
        <div class="col-lg-6">
          <a class="portfolio-item" href="#!">
            <div class="caption">
              <div class="caption-content">
                <div class="h2">Informasi Transfer</div>
                <p class="mb-0">coming soon</p>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio-4.jpg" alt="">
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="content-section bg-primary text-white">
    <div class="container text-center">
      <h2 class="mb-4">contact administrator</h2>
      <a href="#!" class="btn btn-xl btn-light mr-4">email me!</a>
    </div>
  </section>


  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <p class="text-muted small mb-0">Copyright &copy; 2020</p>
    </div>
  </footer>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/stylish-portfolio.min.js"></script>

</body>

</html>

