<?php
require_once("../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['checked']) && count($_POST['checked']) > 0){
        
        foreach($_POST['checked'] AS $data){
            mysqli_query($link, "UPDATE req_absensi SET `status` = '25', req_status = 'a' WHERE id = '$data' ");
        }
        $_SESSION['info'] = 'Diproses';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }
    
    
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }