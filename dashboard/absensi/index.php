<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitor Absensi";
if(isset($_SESSION['user'])){

    include_once("../header.php");
?>

<?php
    include_once('../absensi/grafik_ijin.php');
    include_once('../absensi/grafik_sakit.php');
    include_once('../absensi/grafik_mangkir.php');
    include_once("../footer.php");
    ?>


<?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>