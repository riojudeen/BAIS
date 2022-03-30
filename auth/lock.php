<?php 
include("../config/config.php");
mysqli_query($link, "UPDATE data_user SET stats = '0' WHERE npk = '$_SESSION[user]'")or die(mysqli_error($link));
unset($_SESSION['user']);
$cekUser = @$_GET['u'];
//encode gambar foro profile dari personal site
$title = (isset($halaman))? "BAIS | ".$halaman : "Body Administration Information System ";


$npkUser = $_SESSION['lock'];
//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['lock']) && $cekUser == sha1($_SESSION['lock'])){
  $path = "//adm-fs/HRD/HRD-Photo/".$npkUser.".jpg";
  $type = pathinfo($path, PATHINFO_EXTENSION);
  if (file_exists($path)) {
    $dataImage = file_get_contents($path);
    $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
    $base64 = ($image)? $image : "";
    // die("File tidak ditemukan");
  } else {
    $base64 = base_url()."/assets/img/img/tm.png";
    // $file = fopen($path, "r");
    // echo "File berhasil dibaca.";
  }
  $_npk = $_SESSION['lock'];
  $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM karyawan WHERE npk = '$_npk' "));
  $sql_role = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$_npk' "));
  $nama = $data['nama'];
  //nama depan
  $pecah = explode(" ",$nama);
  $nick = $pecah[0];
  if(isset($_POST['unlock'])) {
    $pass = sha1(trim(mysqli_real_escape_string($link, $_POST['psw']))); //untuk password ditmbah function sha1 karena password dienkrpsi dengan sha1//
    
    //periksa ke database                      
    $query_login = mysqli_query($link, "SELECT * FROM data_user WHERE npk = '$_npk' AND pass = '$pass' ") or die (mysqli_error($link));
    $query = mysqli_fetch_assoc($query_login);
    // echo mysqli_num_rows($query_login);
    $idRole = (!empty($query['level']))?$query['level']:"";
    // echo $idRole;
    $user = $_npk;
    if(mysqli_num_rows($query_login) > 0){
      mysqli_query($link, "UPDATE data_user SET stats = '1' WHERE npk = '$_npk'")or die(mysqli_error($link));
      //jika benar maka simpan session user sebagai variable user, dan redirect ke base_url / dashboard
      ($_SESSION['user'] = $user);
      ($_SESSION['level'] = $idRole);
      
      echo "<script>window.location='$_SESSION[link]';</script>";
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
    Lock | BAIS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?=base_url();?>/assets/css/css.css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="<?=base_url();?>/assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="<?=base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?=base_url();?>/assets/css/paper-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?=base_url();?>/assets/demo/demo.css" rel="stylesheet" />
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
            <a href="<?=base_url('')?>" class="nav-link">
              <i class="nc-icon nc-book-bookmark"></i>
              General Informasi
            </a>
          </li>
         
          <li class="nav-item  active ">
            <a href="logout.php" class="nav-link">
              <i class="nc-icon nc-tap-01"></i>
              Log Out
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?=base_url('dashboard/')?>" class="nav-link">
              <i class="nc-icon nc-satisfied"></i>
              Hi, <?=$nick?>
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
            
          <!--form login-->
            <form class="form" method="post" action="">
                <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                    <div class="card card-lock text-center">
                        <div class="card-header ">
                            <img src="<?=$base64?>" alt="profile" style="">
                        </div>
                        <div class="card-body ">
                            <h4 class="card-title"><?=$nama?></h4>
                            
                            <?php
                              if(isset($pesan)){
                                // echo $npkUser;
                                ?>
                                <!--jika password dan user salah keluarkan alert gagal-->
                                <div class="alert alert-danger alert-dismissible fade show text-left">
                                  <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="nc-icon nc-simple-remove"></i>
                                  </button>
                                  <span><b> <?=$pesan?>! </b><br/> password salah!"</span>
                                </div>

                                <?php
                              }
                            ?>
                            <div class="form-group">
                                <input type="password" name="psw" class="form-control" placeholder="Enter Password..">
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button name="unlock" type="submit" class="btn btn-outline-default btn-round">Unlock</button>
                        </div>
                    </div>
                </div>
            </form>
         
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

</body>

</html>
<?php

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>