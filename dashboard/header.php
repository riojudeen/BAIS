<?php
// error_reporting(0);
// untuk sidebar dan active color
$sidebar_color = (isset($_SESSION['sidebar_color']))?$_SESSION['sidebar_color']:'default';
$active_color = (isset($_SESSION['active_color']))?$_SESSION['active_color']:'danger';
//encode gambar foro profile dari personal site
  $title = (isset($halaman))? "BAIS | ".$halaman : "Body Administration Information System ";
  // $level = 8;
  // include(base_url()'assets/config/function.php');
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
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/dist/loading-bar.css"/>
  <script type="text/javascript" src="<?=base_url()?>/assets/dist/loading-bar.js"></script>
  <script>
    $(document).ready(function(){
      // get_notif_data()
      window.setInterval(function () {
        get_notif_data()
      }, 5000);
      function get_notif_data(){
        $.ajax({
            type: 'GET',
            url: '<?=base_url()?>/dashboard/notif/index.php',
            success: function (data) {
              var obj = $.parseJSON(data);
              var total = obj.msg[0].jml;
              var ot = obj.data[0].ot;
              var at = obj.data[0].at;
              var inf = obj.data[0].info;
              if(total > 0){
                $('#notif-all').text(total)
                if(at > 0){
                  $('#notif-app-ot').text(ot)
                }
                if(ot > 0){
                  $('#notif-app-at').text(at)
                }
                if(inf > 0){
                  $('#notif-gen-info').text(inf)
                }
              }
            },
        }); 
      }
    })
  </script>

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
        <?php
        if($level >= 10){
            
          ?>
          <div class="user">
            
            <div class="photo">
              <img src="<?=base_url()?>/assets/img/img/dvh.png"/>
            </div>
            <div class="info"> 
              <a data-toggle="collapse" href="#profile" class="clpse collapsed" data-id="profile" data-name="profile">
                <span style="text-transform:uppercase">
                  BODY DIVISION
                  <br class="m-0">
                  <small for="" style="font-size:8px" class="label text-white m-0 py-0">(version X.alpha )</small>
                  <b class="caret"></b>
                </span>
              </a>
              <div class="clearfix"></div>
              <div class="collapse " id="profile">
                <ul class="nav">
                  <li class="menu " data-name="myprofile" id="myprofile">
                    <a href="<?=base_url()?>/auth/login.php">
                      <span class="sidebar-mini-icon">UL</span>
                      <span class="sidebar-normal">User Login</span>
                    </a>
                  </li>                
                  
                </ul>
              </div>
              
            </div>
          </div>
          <?php
        }else{
          
        ?>
        <div class="user">
          
          <div class="photo">
            <img src="<?=$base64?>"  />
          </div>
          <div class="info"> 
            <a data-toggle="collapse" href="#profile" class="clpse collapsed" data-id="profile" data-name="profile">
              <span style="text-transform:uppercase">
                <?=$nick." [$role]";?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="clearfix"></div>
            <div class="collapse " id="profile">
              <ul class="nav">
                <li class="menu " data-name="myprofile" id="myprofile">
                  <a href="<?=base_url()?>/dashboard/profile/index.php?profile=me">
                    <span class="sidebar-mini-icon">MP</span>
                    <span class="sidebar-normal">My Profile</span>
                  </a>
                </li>                
                <li>
                  <a href="<?=base_url('auth/logout.php')?>">
                    <span class="sidebar-mini-icon">LO</span>
                    <span class="sidebar-normal">Log Out</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
        <ul class="nav" >
            <li class="menu clpse d-none" data-name="dashboard" id="dashboard" data-target="dashboard">
              <a href="<?php echo base_url('dashboard/');?>">
                <i class="nc-icon nc-bank"></i>
                <p>Dashboard</p>
              </a>
            </li>
            
            <li class="clpse " data-name="achieve" id="achieve" data-target="achieve_">
              <a data-toggle="collapse" href="#achieve_" aria-expanded="false">
                <i class="nc-icon nc-chart-bar-32"></i>
                <p>
                Dashboard <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="achieve_">
                <ul class="nav">
                  <li class="menu " data-name="ach" id="ach">
                    <a href="<?=base_url()?>/dashboard/administrasi/attendance_record.php"><!---link halaman absen MP--->
                      <span class="sidebar-mini-icon">ME</span>
                      <span class="sidebar-normal"> Attendance Efficiency </span>
                    </a>
                  </li>
                  <li class="menu " data-name="rcg" id="rcg">
                    <a href="<?=base_url()?>/dashboard/administrasi/in_out.php"><!---link halaman pengajuan SUPEM--->
                      <span class="sidebar-mini-icon">IO</span>
                      <span class="sidebar-normal"> In - Out Monitoring</span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </li>
            <?php
          if($level < 10){

              
              //akses menu
                // if($role == "admin" || $role == "frm" || $role == "spv" || $role == "mng"){?>
              <li class="clpse " data-name="tf" id="tf" data-target="transfer">
                <a data-toggle="collapse" href="#transfer">
                  <i class="nc-icon nc-book-bookmark"></i>
                  <p>
                    INFORMATION <b class="caret"></b>
                  </p>
                </a>
                <div class="collapse" id="transfer">
                  <ul class="nav">
                    
                    <li class="menu " data-name="infoportal" id="infoportal">
                      <a href="<?=base_url()?>/dashboard/administrasi/info.php"><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">GI</span>
                        <span class="sidebar-normal"> General Information </span>
                      </a>
                    </li>
                    <li class="menu" data-name="lisbl" id="lisbl">
                      <a ><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">BL</span>
                        <span class="sidebar-normal"> BlackListed Hospital </span>
                      </a>
                    </li>
                    <li class="menu" data-name="lisrc" id="lisrc">
                      <a ><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">RH</span>
                        <span class="sidebar-normal"> Recomended Hospital </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <?php
                // }
              ?>         
              <?php 
              if($level > 2 && $level != 5){
                ?>
              <li class="clpse " data-name="mntrg" id="mntrg" data-target="monitoring">
                <a data-toggle="collapse" href="#monitoring" aria-expanded="false">
                  <i class="nc-icon nc-layout-11"></i>
                  <p>
                    Organization Data <b class="caret"></b>
                  </p>
                </a>
                <div class="collapse " id="monitoring" >
                  <ul class="nav">
                    <?php 
                    // if($role == "user"){
                    //   echo "";
                    // }else{
                    
                    ?>
                    <li class="menu d-none" data-name="emp" id="emp">
                      <a href="<?=base_url()?>/dashboard/pages/manpower.php"><!---link halaman update MP--->
                        <span class="sidebar-mini-icon">EM</span>
                        <span class="sidebar-normal"> Employee Monitoring (exp)</span>
                      </a>
                    </li> 
                    <?php
                    if($level == 3 || $level == 8){
                      ?> 
                    <li class="menu " data-name="mpu" id="mpu">
                      <a href="<?=base_url()?>/dashboard/pages/mp_update.php"><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">ED</span>
                        <span class="sidebar-normal"> Employee Data </span>
                      </a>
                    </li>
                    <li class="menu " data-name="mpeval" id="mpeval">
                      <a href="<?=base_url()?>/dashboard/manpower/layoff.php"><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">ED</span>
                        <span class="sidebar-normal"> Evaluation Employee </span>
                      </a>
                    </li>
                    <li class="menu d-none" data-name="reqmp" id="reqmp">
                      <a href="<?=base_url()?>/dashboard/manpower/req_manpower.php"><!---link halaman request edit MP--->
                        <span class="sidebar-mini-icon">MR</span>
                        <span class="sidebar-normal"> Employee Update Request </span>
                      </a>
                    </li>
                    
                    <?php
                      }else if($level >= 6 ){
                        
                      ?>
                    <li class="menu " data-name="reinburst" id="reinburst">
                      <a href="">
                        <span class="sidebar-mini-icon">EA</span>
                        <span class="sidebar-normal"> Employee Update Approval </span>
                      </a>
                    </li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              </li>
              <?php
              }
              ?>

              <?php 

              if($level >= 1 ){
              ?>                  
              <li class="clpse " data-name="req" id="req" data-target="requests">
                <a data-toggle="collapse" href="#requests" aria-expanded="false">
                  <i class="nc-icon nc-ruler-pencil"></i>
                  <p>
                  attendance <b class="caret"></b>
                  </p>
                </a>
                <div class="collapse" id="requests">
                  <ul class="nav">
                    <li class="menu " data-name="abs" id="abs">
                      <a href="<?=base_url()?>/dashboard/pages/absensi.php"><!---link halaman absen MP--->
                        <span class="sidebar-mini-icon">AM</span>
                        <span class="sidebar-normal"> attendance Monitoring </span>
                      </a>
                    </li>
                    <?php 

                    if($level != 5 && $level >= 3 ){
                    ?> 
                    <li class="menu " data-name="reqabs" id="reqabs">
                      <a href="<?=base_url()?>/dashboard/absensi/req_absensi.php"><!---link halaman pengajuan SUPEM--->
                        <span class="sidebar-mini-icon">LR</span>
                        <span class="sidebar-normal"> Leave Request </span>
                      </a>
                    </li>
                    <li class="menu " data-name="reqshift" id="reqshift">
                      <a href="<?=base_url()?>/dashboard/absensi/shift_request.php"><!---link halaman pengajuan SUPEM--->
                        <span class="sidebar-mini-icon">LR</span>
                        <span class="sidebar-normal"> Shift Request </span>
                      </a>
                    </li>
                    <?php
                    }
                    if($level >= 4 && $level != 5){
                      
                    ?>
                    <li class="menu " data-name="leave" id="leave">
                      <a href="<?=base_url()?>/dashboard/absensi/approval/index.php">
                        <span class="sidebar-mini-icon">LA</span>
                        <span class="sidebar-normal"> Leave Approval </span>
                      </a>
                    </li>
                    <li class="menu " data-name="shiftapprove" id="shiftapprove">
                      <a href="<?=base_url()?>/dashboard/absensi/approval/shift-approval.php">
                        <span class="sidebar-mini-icon">SA</span>
                        <span class="sidebar-normal"> Shift Approval </span>
                      </a>
                    </li>
                    <?php
                    }
                    
                    ?>
                  </ul>
                </div>
              </li>
              <?php
                }
              ?>         
              <?php if($level >= 1){?>
              <li class="clpse " data-name="ot" id="ot" data-target="overtime">
                <a data-toggle="collapse" href="#overtime" aria-expanded="false"><!---link halaman Kontrol--->
                  <i class="nc-icon nc-box"></i>
                  <p>
                  Overtime <b class="caret"></b>
                  </p>
                  </p>
                </a>
                <div class="cllpse collapse " id="overtime" data-name="overtime">
                  <ul class="nav">
                    
                    <li class="menu " data-name="ovrtime" id="ovrtime">
                      <a href="<?=base_url()?>/dashboard/pages/overtime.php">
                        <span class="sidebar-mini-icon">OM</span>
                        <span class="sidebar-normal"> Overtime Montoring </span>
                      </a>
                    </li>
                    <?php
                    if($level != 5 && $level >= 3 ){
                    ?>
                    <li class="menu " data-name="ovrtime2" id="ovrtime2">
                      <a href="<?=base_url()?>/dashboard/ot/req_overtime.php">
                        <span class="sidebar-mini-icon">OR</span>
                        <span class="sidebar-normal"> Overtime Request</span>
                      </a>
                    </li>
                    <?php 
                    }
                    if($level >= 4 && $level != 5){
                    ?>
                    <li class="menu " data-name="appot" id="appot">
                      <a href="<?=base_url()?>/dashboard/ot/approval/index.php">
                        <span class="sidebar-mini-icon">OA</span>
                        <span class="sidebar-normal"> Overtime Approval </span>
                      </a>
                    </li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>
              </li>
              <?php
              }
              ?> 
              <?php 
              if($level >= 6 ){?>
              <li class="clpse " data-name="contsettings" id="contsettings" data-target="settings">
                <a data-toggle="collapse" href="#settings" aria-expanded="false"><!---link halaman Kontrol--->
                  <i class="nc-icon nc-lock-circle-open"></i>
                  <p>
                  Control Settings <b class="caret"></b>
                  </p>
                  </p>
                </a>
                <div class="collapse" id="settings">
                  <ul class="nav" >
                  <?php
                    if($level >= 7){
                      
                    ?>
                    <li class="menu " data-name="master" id="master">
                      <a href="<?=base_url()?>/dashboard/setting/master.php">
                        <span class="sidebar-mini-icon">MD</span>
                        <span class="sidebar-normal"> Master Data</span>
                      </a>
                    </li>
                    <li class="menu " data-name="leave_transfer" id="leave_transfer">
                      <a href="<?=base_url()?>/dashboard/setting/leave_alloc/index.php">
                        <span class="sidebar-mini-icon">LA</span>
                        <span class="sidebar-normal"> Leave Allocation</span>
                      </a>
                    </li>
                    
                    <!-- seting waktu dan schedule produksi -->
                    <li class="menu " data-name="workinghours" id="workinghours">
                      <a href="<?=base_url()?>/dashboard/wh">
                        <span class="sidebar-mini-icon">WH</span>
                        <span class="sidebar-normal"> Working Schedule</span>
                      </a>
                    </li>
                    <!-- seting waktu dan schedule produksi -->
                    <?php
                    }
                    ?>
                    <li class="menu " data-name="resource" id="resource">
                      <a href="<?=base_url()?>/dashboard/setting/employee/add_karyawan.php">
                        <span class="sidebar-mini-icon">ED</span>
                        <span class="sidebar-normal"> Employee Data</span>
                      </a>
                    </li>
                    <li class="menu " data-name="user" id="user">
                      <a href="<?=base_url()?>/dashboard/setting/employee/user.php">
                        <span class="sidebar-mini-icon">UD</span>
                        <span class="sidebar-normal"> User Data</span>
                      </a>
                    </li>
                    
                    <li class="menu " data-name="org" id="org">
                      <a href="<?=base_url()?>/dashboard/setting/organization/">
                        <span class="sidebar-mini-icon">OS</span>
                        <span class="sidebar-normal"> Organization Setting</span>
                      </a>
                    </li>
                    <li class="menu d-none" data-name="mps" id="mps">
                      <a href="<?=base_url()?>/dashboard/setting/manpower.php">
                        <span class="sidebar-mini-icon">MO</span>
                        <span class="sidebar-normal"> Man Power Setting</span>
                      </a>
                    </li>
                    
                    <li class="menu " data-name="infoport" id="infoport">
                      <a href="<?=base_url()?>/dashboard/setting/portal.php">
                        <span class="sidebar-mini-icon">TP</span>
                        <span class="sidebar-normal"> Transfer Portal</span>
                      </a>
                    </li>
                    <li class="menu " data-name="infprt" id="infprt">
                      <a href="<?=base_url()?>/dashboard/setting/portBlast.php">
                        <span class="sidebar-mini-icon">IP</span>
                        <span class="sidebar-normal"> Information Portal</span>
                      </a>
                    </li>
                    <li class="menu " data-name="attendanceport" id="attendanceport">
                      <a href="<?=base_url()?>/dashboard/setting/portAtt.php">
                        <span class="sidebar-mini-icon">DM</span>
                        <span class="sidebar-normal"> Data Migration</span>
                      </a>
                    </li>
                    <li class="menu d-none" data-name="overtimeport" id="overtimeport">
                      <a href="<?=base_url()?>/dashboard/setting/portOt.php">
                        <span class="sidebar-mini-icon">IP</span>
                        <span class="sidebar-normal"> Overtime Portal</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <?php
              }
              if($level == 2 || $level == 8 ){
                
              ?>
              
              <li class="clpse " data-name="costmon" id="costmon" data-target="costMonitoring">
                <a data-toggle="collapse" href="#costMonitoring" aria-expanded="false"><!---link halaman Kontrol--->
                  <i class="nc-icon nc-money-coins"></i>
                  <p>
                  Cost Monitoring <b class="caret"></b>
                  </p>
                  </p>
                </a>
                <div class="collapse" id="costMonitoring">
                  <ul class="nav">
                    <li class="menu " data-name="costBody1" id="costBody1">
                      <a href="<?=base_url()?>/dashboard/cost/index.php?dept=5">
                        <span class="sidebar-mini-icon">B1</span>
                        <span class="sidebar-normal"> Body 1</span>
                      </a>
                    </li>
                    <li class="menu " data-name="costBody2" id="costBody2">
                      <a href="<?=base_url()?>/dashboard/cost/index.php?dept=6">
                        <span class="sidebar-mini-icon">B2</span>
                        <span class="sidebar-normal"> Body 2</span>
                      </a>
                    </li>
                    <li class="menu " data-name="costBQC" id="costBQC">
                      <a href="<?=base_url()?>/dashboard/cost/index.php?dept=3">
                        <span class="sidebar-mini-icon">BQ</span>
                          <span class="sidebar-normal"> BQC <span class="badge badge-sm badge-pill badge-white">Dev</span>
                        </span>
                      </a>
                      
                    </li>
                  </ul>
                </div>
              </li>
              <?php
              
            }
              ?>
              <li class="clpse " data-name="doc" id="doc" data-target="documentation">
                <a data-toggle="collapse" href="#documentation" aria-expanded="false"><!---link halaman Kontrol--->
                  <i class="nc-icon nc-book-bookmark"></i>
                  <p>
                  Document & Form <b class="caret"></b>
                  </p>
                  </p>
                </a>
                <div class="collapse" id="documentation">
                  <ul class="nav">
                    <li class="menu " data-name="UG" id="UG">
                      <a href="<?=base_url()?>/dashboard/document/guide.php">
                        <span class="sidebar-mini-icon">UG</span>
                        <span class="sidebar-normal"> User Guidance </span>
                      </a>
                    </li>
                    
                    
                    <li class="menu " data-name="admForm" id="admForm">
                      <a href="<?=base_url()?>/dashboard/document/form.php">
                        <span class="sidebar-mini-icon">AF</span>
                        <span class="sidebar-normal"> Administration Forms </span>
                      </a>
                    </li>
                    <li class="menu " data-name="exportmp" id="exportmp">
                      <a href="<?=base_url()?>/dashboard/setting/employee/proses/export.php?export=mp">
                        <span class="sidebar-mini-icon">EX</span>
                        <span class="sidebar-normal"> Export Employee Data </span>
                      </a>
                    </li>
                    <li class="menu " data-name="exportmp" id="exportmp">
                      <a href="<?=base_url()?>/dashboard/setting/employee/proses/export.php?export=organization">
                        <span class="sidebar-mini-icon">EO</span>
                        <span class="sidebar-normal"> Export Org Data </span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <?php
              if($level >= 7){
                
              ?>
              <li class="menu clpse " data-name="chat" id="chat" data-target="chat">
                <a target="blank" href="<?php echo base_url('chat/');?>">
                  <i class="nc-icon nc-chat-33"></i>
                  <p>Chat </p>
                </a>
              </li>
              <li class="menu clpse " data-name="lm" id="lm" data-target="lm">
                <a href="<?php echo base_url('dashboard/time_lock/');?>">
                <i class="far fa-clock"></i>
                  <p>Time-Lock Management </p>
                </a>
              </li>
              <li>
                <?php
            }

            
          }
          ?>
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
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-send"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Personal Site</a>
                  <a class="dropdown-item" href="#">HRIS</a>
                  <a class="dropdown-item" href="#">MOS</a>
                  <a class="dropdown-item" href="<?=base_url()?>/dashboard/setting/portBlast.php">Report Issue</a>
                </div>
              </li>
              <li class="nav-item btn-rotate dropdown" >
                <a class="nav-link dropdown-toggle" href="" id="btn-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p class="badge-colors">
                    <span class="d-lg-none d-md-block">Notification</span>
                    <span class="badge badge-sm category filter badge-primary active" data-color="primary" id="notif-all"></span>
                    </p>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-notification" >
                  <a class="dropdown-item " href="<?=base_url()?>/dashboard/absensi/approval/">Leave Request 
                  <span class="badge filter badge-primary" data-color="primary" id="notif-app-at" ></span>
                  </a>
                  <a class="dropdown-item" href="<?=base_url()?>/dashboard/ot/approval/">Overtime Request
                    <span class="badge filter badge-primary" data-color="primary" id="notif-app-ot"></span>
                    </a>
                  </a>
                  <a class="dropdown-item" href="#">New Info
                    <span  class="badge filter badge-primary" data-color="primary" id="notif-gen-info"></span>
                    </a>
                  </a>
                </div>
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
        