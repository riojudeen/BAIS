<?php 
//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Dashboard";
if(isset($_SESSION['user'])){
  
echo "<script>window.location='".base_url('dashboard/pages/display.php')."';</script>";


///jika tidak ada session maka akan diarahkan ke ahalam login
} else{
  echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}

?>