<?php 
//////////////////////////////////////////////////////////////////////
include_once("../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Dashboard";
if(isset($_SESSION['user'])){
  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="icon" href="img/logo.png" type="image/png">
  <style>
    @font-face {
        font-family: hotel_de_paris;
        src: url('font/hotel_de_paris.ttf') format('truetype');
    }
    </style>
  <title>
    Body Administration & Information System
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="assets/css/stylefonts.css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Files -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

  
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar bg-primary" data-color="warning" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color=" default | primary | info | success | warning | danger |"
    -->
      <div class="logo">
        <a href="index.php" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="img/logo.png">
          </div>
          <!-- <p>CT</p> -->
        </a>
        <a href="index.php" class="simple-text logo-normal" style="font-family: hotel_de_paris; font-size:1.5rem">
          B A I S
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="img/tm.png" />
          </div>
          <div class="info">
            <a data-toggle="collapse" href="#profile" class="collapsed">
              <span>
                Profil Man Power
                <b class="caret"></b>
              </span>
            </a>
            <div class="clearfix"></div>
            <div class="collapse" id="profile">
              <ul class="nav">
                <li>
                  <a href="#">
                    <span class="sidebar-mini-icon">MP</span>
                    <span class="sidebar-normal">My Profile</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <span class="sidebar-mini-icon">EP</span>
                    <span class="sidebar-normal">Edit Profile</span>
                  </a>
                </li>
                <li>
                  <a href="../auth/logout.php">
                    <span class="sidebar-mini-icon">LO</span>
                    <span class="sidebar-normal">Log Out</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="">
            <a href="index.php">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="">
            <a data-toggle="collapse" href="#transfer">
              <i class="nc-icon nc-book-bookmark"></i>
              <p>
                Informasi Transfer <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="transfer">
              <ul class="nav">
                <li class="">
                  <a href="index.php?go=tf_um"> <!---link halaman uang makan--->
                    <span class="sidebar-mini-icon">UM</span>
                    <span class="sidebar-normal"> Transfer Uang Makan </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?go=tf_ss"><!---link halaman SS--->
                    <span class="sidebar-mini-icon">SS</span>
                    <span class="sidebar-normal"> Transfer SS </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?go=tf_obat"><!---link halaman Tunjangan Pengobatan--->
                    <span class="sidebar-mini-icon">TJ</span>
                    <span class="sidebar-normal"> Transfer Tunjangan </span>
                  </a>
                </li>
                </ul>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#monitoring" aria-expanded="true">
              <i class="nc-icon nc-layout-11"></i>
              <p>
                Monitoring <b class="caret"></b>
              </p>
            </a>
            <div class="collapse show" id="monitoring" >
              <ul class="nav">
                <li class="<?php if($_GET['go'] == 'update_mp'){echo 'active';}else{echo '';}?>">
                  <a href="index.php?go=update_mp"><!---link halaman update MP--->
                    <span class="sidebar-mini-icon">MP</span>
                    <span class="sidebar-normal"> Man Power </span>
                  </a>
                </li>
                <li class="<?php if($_GET['go'] == 'absensi'){echo 'active';}?>">
                  <a href="index.php?go=absensi"><!---link halaman absen MP--->
                    <span class="sidebar-mini-icon">A</span>
                    <span class="sidebar-normal"> Absensi </span>
                  </a>
                </li>
                <li class="<?php if($_GET['go'] == 'lembur'){echo 'active';}?>">
                  <a href="index.php?go=lembur">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Lembur </span>
                  </a>
                </li>
                </ul>
            </div>
          </li>
          <li  class="">
            <a data-toggle="collapse" href="#requests" aria-expanded="true">
              <i class="nc-icon nc-ruler-pencil"></i>
              <p>
                Request <b class="caret"></b>
              </p>
            </a>
            <div class="collapse show" id="requests">
              <ul class="nav">
                <li class="<?php if($_GET['req'] == 'req_absen'){echo 'active';}?>">
                  <a href="index.php?req=req_absen"><!---link halaman pengajuan SUPEM--->
                    <span class="sidebar-mini-icon">RA</span>
                    <span class="sidebar-normal"> Request Absensi </span>
                  </a>
                </li>
                <li class="<?php if($_GET['req'] == 'req_lembur'){echo 'active';}?>">
                  <a href="index.php?req=req_lembur"><!---link halaman request lembur--->
                    <span class="sidebar-mini-icon">RL</span>
                    <span class="sidebar-normal"> Request Lembur </span>
                  </a>
                </li>
                <li class="<?php if($_GET['req'] == 'req_datamp'){echo 'active';}?>">
                  <a href="index.php?req=req_datamp"><!---link halaman request edit MP--->
                    <span class="sidebar-mini-icon">RM</span>
                    <span class="sidebar-normal"> Request Edit MP </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>         
          
          <li>
            <a href="index.php?ap=approval"><!---link halaman Kontrol--->
              <i class="nc-icon nc-box"></i>
              <p>Kontrol & Approval</p>
            </a>
          </li>
          <li>
            <a href="#"><!---link halaman Display Andon--->
              <i class="nc-icon nc-chart-bar-32"></i>
              <p>Efisiensi MP</p>
            </a>
          </li>          
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-icon btn-round">
                <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
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

          <!--- inactive sementara
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-magnify" href="javascript:;">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="javascript:;">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
          ends ---> 
        </div>
      </nav>
      <!-- Seleseai Navbar -->
      <div class="content">
          <!--content taruh sini--->        
        <div class="row">