<?php
//////////////////////////////////////////////////////////////////////
include("../config/config.php"); 
if(isset($_SESSION['user'])){
   if(isset($_POST['sidebar_color'])){
        unset($_SESSION['sidebar_color']);
        $_SESSION['sidebar_color'] = $_POST['sidebar_color'];
   }else if($_POST['active_color']){
        unset($_SESSION['active_color']);
        $_SESSION['active_color'] = $_POST['active_color'];
   }
}