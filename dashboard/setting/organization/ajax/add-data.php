<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        echo "tes";
        
    }else{
        // echo "gagal";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}