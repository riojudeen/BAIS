<?php 
include("../config/config.php"); 
unset($_SESSION['user']);
echo "<script>window.location='".base_url('auth/login.php')."';</script>";
?>
