
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php");

if(isset($_SESSION['user'])){
    header('Location: user.php');

    
   
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }