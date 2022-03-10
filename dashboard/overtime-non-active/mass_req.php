<?php
require_once("../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['mpchecked']) && count($_POST['mpchecked']) > 0){
        
        foreach($_POST['mpchecked'] AS $data){
            mysqli_query($link, "UPDATE lembur SET `status` = 'a', status_approve = '25' WHERE kode_lembur = '$data' ");
        }
        $_SESSION['info'] = 'Request';
        echo "<script>document.location.href='index.php'</script>";
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='index.php'</script>";
    }
    
    
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }