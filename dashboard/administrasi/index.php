<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitor Absensi";
if(isset($_SESSION['user'])){
header('location: attendance_record.php');

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>