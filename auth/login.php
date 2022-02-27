<?php 
include("../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
  echo "<script>window.location='".base_url('/dashboard')."';</script>";

} else{
  //ambil data inputan form login//
  //jika file diset cara bacanya jika nilai yang dikirim adalah login / name=login di dalam form yang memiliki method=post,
      //maka masukkan parameter name=user kedalam variabel user dan masukan parameter pass kedalam variabel pass//
      if(isset($_POST['login'])) {
        $user = trim(mysqli_real_escape_string($link, $_POST['user']));
        $pass = sha1(trim(mysqli_real_escape_string($link, $_POST['pass']))); //untuk password ditmbah function sha1 karena password dienkrpsi dengan sha1//
        
        //periksa ke database                      
        $query_login = mysqli_query($link, "SELECT * FROM data_user WHERE npk = '$user' AND pass = '$pass' ") or die (mysqli_error($link));
        $query = mysqli_fetch_assoc($query_login);
        $idRole = $query['level'];
        

        if(mysqli_num_rows($query_login) > 0){
          //jika benar maka simpan session user sebagai variable user, dan redirect ke base_url / dashboard
          ($_SESSION['user'] = $user);
          ($_SESSION['level'] = $idRole);
          
          echo "<script>window.location='".base_url('dashboard/')."';</script>";
        } else {
          $pesan = "galat";               
        }
    }
  ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url();?>/assets/img//apple-icon.png">
  <link rel="icon" href="<?=base_url();?>/assets/img/img/logo.png" type="image/png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Login | BAIS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?=base_url();?>/assets/css/css.css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="<?=base_url();?>/assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?=base_url('assets/fontawesome/css/all.css')?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?=base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?=base_url();?>/assets/css/paper-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?=base_url();?>/assets/demo/demo.css" rel="stylesheet" />
  <style>
    @font-face {
        font-family: hotel_de_paris;
        src: url('<?=base_url()?>/assets/font/hotel_de_paris.ttf') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-regular-400.woff2') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-regular-400.woff') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-brands-400.woff') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-brands-400.woff2') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-solid-900.woff') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-solid-900.woff2') format('truetype');
    }
    @font-face {
        font-family: FontAwesome;
        src: url('<?=base_url()?>/assets/fontawesome/webfonts/fa-regular-400.ttf') format('truetype');
    }
    </style>
</head>

<body class="login-page">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="javascript:;">Body Administration - Information System</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a href="../" class="nav-link">
              <i class="nc-icon nc-book-bookmark"></i>
              General Informasi
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url('')?>/dashboard/" class="nav-link">
              <i class="nc-icon nc-layout-11"></i>
              Dashboard
            </a>
          </li>
          <li class="nav-item  active ">
            <a href="login.html" class="nav-link">
              <i class="nc-icon nc-tap-01"></i>
              Login
            </a>
          </li>
          <li class="nav-item ">
            <a href="user.html" class="nav-link">
              <i class="nc-icon nc-satisfied"></i>
              User
            </a>
          </li>
          <li class="nav-item ">
            <a href="lock.html" class="nav-link">
              <i class="nc-icon nc-key-25"></i>
              Lock
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page ">
    <div class="full-page section-image" filter-color="black" data-image="<?=base_url()?>/assets/img/bg/rawpixel-com.jpg">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="content">
        <div class="container">
          <div class="col-lg-4 col-md-6 ml-auto mr-auto">             
          <!--form login-->
            <form class="form" method="post" action="">
              <div class="card card-login">
                <div class="card-header ">
                  <div class="card-header ">
                    <h3 class="header text-center">Login</h3>
                  </div>

                  <?php
                  if(isset($pesan)){?>
                  <!--jika password dan user salah keluarkan alert gagal-->
                    <div class="alert alert-danger alert-dismissible fade show">
                      <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                      </button>
                      <span><b> Login gagal - </b> username atau password salah!"</span>
                    </div>
                  <?php
                  }
                  //ambil nilai password//
                  ?>
                </div>
                <div class="card-body ">
                  <div class="input-group">
                    <input type="text" name="user" class="form-control" placeholder="npk" required autofocus>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group ">
                      <input type="password"
                        name="pass" id="pass" class="form-control pass2 passw " placeholder="password">
                      <div class="input-group-append ">
                        <div class="input-group-text ">
                            <i class="fa fa-eye mata2 d-none"></i>
                            <i class="fa fa-eye-slash mata1"></i>
                        </div>
                      </div>
                    </div>
                    <span class="form-text text-info">default password : ddmmyyyy sesuai tanggal masuk</span>
                  </div>
                  <br />                  
                </div>
                <div class="card-footer ">
                  <input type="submit" name="login" class="btn btn-success btn-round btn-block mb-3" value="Log In">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="mailto:admin.body1@daihatsu.astra.co.id" target="_blank">Admin Body 1</a></li>
                <li><a href="mailto:support.body2@daihatsu.astra.co.id" target="_blank">Admin Body 2</a></li>
                <li><a href="mailto:agus.catur@daihatsu.astra.co.id" target="_blank">Admin BQC</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, Admin x DnA Body Division
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?=base_url();?>/assets/js/core/jquery.min.js"></script>
  <script src="<?=base_url();?>/assets/js/core/popper.min.js"></script>
  <script src="<?=base_url();?>/assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url();?>/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?=base_url();?>/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="<?=base_url();?>/assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?=base_url();?>/assets/js/plugins/sweetalert2.min.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?=base_url();?>/assets/js/plugins/jquery.validate.min.js"></script>
  <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?=base_url();?>/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="<?=base_url();?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?=base_url();?>/assets/js/plugins/bootstrap-datetimepicker.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
  <script src="<?=base_url();?>/assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?=base_url();?>/assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?=base_url();?>/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?=base_url();?>/assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script src="<?=base_url();?>/assets/js/plugins/fullcalendar/daygrid.min.js"></script>
  <script src="<?=base_url();?>/assets/js/plugins/fullcalendar/timegrid.min.js"></script>
  <script src="<?=base_url();?>/assets/js/plugins/fullcalendar/interaction.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?=base_url();?>/assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Bootstrap Table -->
  <script src="<?=base_url();?>/assets/js/plugins/nouislider.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="<?=base_url();?>/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?=base_url();?>/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url();?>/assets/js/paper-dashboard.min.js?v=2.1.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?=base_url();?>/assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      demo.checkFullPageBackgroundImage();
    });
  </script>
  <script>
            $('.mata1').mousedown(function(){
                $('.mata2').removeClass('d-none')
                $('.mata1').addClass('d-none')
                $('.passw').removeAttr('type')
                $('.passw').attr('type','text')
            })
            $('.mata2').mouseup(function(){
                $('.mata1').removeClass('d-none')
                $('.mata2').addClass('d-none')
                $('.passw').removeAttr('type')
                $('.passw').attr('type','password')
            })
        </script>
</body>

</html>
<?php
}
?>