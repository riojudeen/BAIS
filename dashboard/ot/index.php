<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
if(isset($_SESSION['user'])){
    header('location:../profile/index.php?profile=me');
} else{
    header('location:../../auth/login.php');
}
  

?>