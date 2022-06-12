<?php

// error_reporting(0);
// untuk sidebar dan active color
$sidebar_color = (isset($_SESSION['sidebar_color']))?$_SESSION['sidebar_color']:'default';
$active_color = (isset($_SESSION['active_color']))?$_SESSION['active_color']:'danger';
//encode gambar foro profile dari personal site
  $title = (isset($halaman))? "BAIS | ".$halaman : "Body Administration Information System ";
  // $level = 8;
  // include(base_url()'assets/config/function.php');
  /*
  PROGRAM UNTUK GET FOTO LAMA 
  AMBIL DARI FS HRD-FOTO
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
*/
$base64 = getFoto($npkUser)
?>

<?php
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../img/logo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="icon" href="<?=base_url()?>/assets/img/img/logo.png" type="image/png">
  <link rel="manifest" href="<?=base_url()?>/assets/js/manifest.json">
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
    <script>
      document.onreadystatechange = function () {
      if (document.readyState === "complete") {
      console.log(document.readyState);
      document.getElementById("PreLoaderBar").style.display = "none";
      }
      }
  </script>
  <!-- css progreess bar loading page -->
  <style type="text/css">
    .progress {
    position: relative;
    height: 2px;
    display: block;
    width: 100%;
    background-color: white;
    border-radius: 2px;
    background-clip: padding-box;
    /*margin: 0.5rem 0 1rem 0;*/
  overflow: hidden;

  }
    .progress .indeterminate {
    background-color:black; }
    .progress .indeterminate:before {
    content: '';
    position: absolute;
    background-color: #FF5733;
    top: 0;
    left: 0;
    bottom: 0;
    will-change: left, right;
    -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
    animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite; }
    .progress .indeterminate:after {
    content: '';
    position: absolute;
    background-color: #FFC300;
    top: 0;
    left: 0;
    bottom: 0;
    will-change: left, right;
    -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
    animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
    -webkit-animation-delay: 1.15s;
  animation-delay: 1.15s; }


  @-webkit-keyframes indeterminate {
    0% {
    left: -35%;
    right: 100%; }
    60% {
    left: 100%;
    right: -90%; }
    100% {
    left: 100%;
    right: -90%; } }
    @keyframes indeterminate {
    0% {
    left: -35%;
    right: 100%; }
    60% {
    left: 100%;
    right: -90%; }
    100% {
    left: 100%;
    right: -90%; } }
    @-webkit-keyframes indeterminate-short {
    0% {
    left: -200%;
    right: 100%; }
    60% {
    left: 107%;
    right: -8%; }
    100% {
    left: 107%;
    right: -8%; } }
    @keyframes indeterminate-short {
    0% {
    left: -200%;
    right: 100%; }
    60% {
    left: 107%;
    right: -8%; }
    100% {
    left: 107%;
    right: -8%; } }
  </style>
  <div class="progress" id="PreLoaderBar">
      <div class="indeterminate"></div>
  </div>
  <title>
    <?=$title?>
  </title>
 
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?=base_url('assets/css/stylefonts.css?family=Montserrat:400,700,200')?>" rel="stylesheet"/>
 
  <link href="<?=base_url('assets/fontawesome/css/all.css')?>" rel="stylesheet" />
  
  <!-- CSS Files -->
  <link href="<?=base_url('assets/css/bootstrap.min.css" rel="stylesheet')?>"/>
  <link href="<?=base_url('assets/css/paper-dashboard.css?v=2.1.1')?>" rel="stylesheet" />
  <link href="<?=base_url('assets/css/moreicon/moreicon.css')?>" rel="stylesheet" />
  <link href="<?=base_url('assets/fontawesome/css/all.css')?>" rel="stylesheet" />
    <!-- CSS Files 
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />-->
  <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->

  <link href="<?=base_url('assets/js/multi-step-modal-wizard/dist/css/MultiStep-theme.css')?>" rel="stylesheet">
  <link href="<?=base_url('assets/js/multi-step-modal-wizard/dist/css/MultiStep.css')?>" rel="stylesheet">
  <link href="<?=base_url('assets/timepicker/bootstrap-timepicker.css')?>" rel="stylesheet">

  <!-- owl carousel -->
  <link rel="stylesheet" href="<?=base_url('assets/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/js/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.cs')?>">
  
  <script src="<?=base_url('assets/js/core/jquery.min.js')?>"></script>
  <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
  <link href="<?=base_url('assets/css/csscustom.css')?>" rel="stylesheet"/>
  
  <!-- loading bar -->
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/dist/loading-bar.css"/>
  <script type="text/javascript" src="<?=base_url()?>/assets/dist/loading-bar.js"></script>
<!-- untuk notifikasi Supervisor & Admin -->
<?php

?>
  <!-- heatmap -->
  <!-- date range picker -->
  <style type="text/css">
    .lds-ellipsis {
      display: inline-block;
      position: absolute;
      top:40%;
      width: 80px;
      height: 80px;
    }
    .lds-ellipsis div {
      position: absolute;
      top: 33px;
      width: 13px;
      height: 13px;
      border-radius: 50%;
      background: #66615B;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }
    .lds-ellipsis div:nth-child(1) {
      left: 8px;
      animation: lds-ellipsis1 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(2) {
      left: 8px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(3) {
      left: 32px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(4) {
      left: 56px;
      animation: lds-ellipsis3 0.6s infinite;
    }
    @keyframes lds-ellipsis1 {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }
    @keyframes lds-ellipsis3 {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(0);
      }
    }
    @keyframes lds-ellipsis2 {
      0% {
        transform: translate(0, 0);
      }
      100% {
        transform: translate(24px, 0);
      }
    }
    
    .overlay {
      z-index :9999;
      position : fixed;
      top:0;
      bottom:0;
      left:0;
      right:0;
      background-color: rgba(255, 255, 255, 0.7);
      text-align: center;
    }

  </style>

  
</head>

<body class="" onload="hide_loading();">

  <div class="loading overlay">
    <!-- <div class="loadingio-spinner-wedges-kild66l96a"><div class="ldio-wgt5lhdj7pi">
      <div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div>
    </div></div> -->
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
  </div>
  <div class="wrapper ">
    <div class="sidebar bg-primary sdbr" data-color="<?=$sidebar_color?>" data-active-color="<?=$active_color?>">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color=" default | primary | info | success | warning | danger |"
      -->
      <div class="logo">
        <a href="index.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="<?=base_url()?>/assets/img/img/logo.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="../../welcome" class="simple-text logo-normal" style="font-family: hotel_de_paris; font-size:1.5rem">
          B A I S
          <!-- <div class="logo-image-big">
            <img src="../img/logo.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-icon btn-round">
                <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini "></i>
                <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
              </button>
            </div>
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;"><strong><?=$halaman?></strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>

          <!--- inactive sementara-->
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
          <span class="col-md-4 px-0" >
            <span id="tgl" class="input-group no-border "></span>
          </span>
          <span class="px-0 col-sm-3 col-md-2 " style="width:140px">
          <div id="clock" class="input-group no-border"></div>
          </span>
          <!--
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>-->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="javascript:;">
                  <i id="fullscreen" class="fas fa-expand" onclick="toggleFullScreen ();"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              
              
            </ul>
          </div>
        </div>
        
      </nav>
      
      <!-- Seleseai Navbar -->
      <div class="content">
        <!--content taruh sini--->      
        <!-- untuk notifikasi -->
        <div class="info-data" data-infodata="<?php if(isset($_SESSION['info'])){ echo $_SESSION['info']; } unset($_SESSION['info']); ?>" ></div>
        <div class="message" data-infodata="<?php if(isset($_SESSION['pesan'])){ echo $_SESSION['pesan']; } unset($_SESSION['pesan']); ?>" ></div>
        
        <div class="row">
            <div class="modal fade" id="modal_lock" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered ">
            
                <div class="modal-content border" style="border:5px">
                    <div class="modal-body ">
                      <h6>Lock</h6>
                    </div>
                </div>
              </div>
            </div>

        </div>
        