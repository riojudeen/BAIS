<?php 
//////////////////////////////////////////////////////////////////////
include("../config/config.php");
include("../config/cost/date.php"); 
include("../config/cost/index.php");
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Dashboard";
if(isset($_SESSION['user'])){
  
echo "<script>window.location='".base_url('dashboard/cost/index.php?dept=5')."';</script>";
?>

<?php
///jika tidak ada session maka akan diarahkan ke ahalam login
} else{
  echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}

?>