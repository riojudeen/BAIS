<?php 
include("../config/config.php");
mysqli_query($link, "UPDATE data_user SET stats = '0' WHERE npk = '$_SESSION[user]' ")or die(mysqli_error($link));
unset($_SESSION['user']);
echo "<script>window.location='".base_url('auth/login.php')."';</script>";
?>
