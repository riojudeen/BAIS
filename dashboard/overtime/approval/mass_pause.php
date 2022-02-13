<?php
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['mpchecked']) && count($_POST['mpchecked']) > 0){
        foreach($_POST['mpchecked'] AS $data){
            mysqli_query($link, "UPDATE lembur 
            SET `status` = 'b', 
            status_approve = '100' 
            WHERE _id = '$data' ");
        }
        $_SESSION['info'] = 'Stop';
        echo "<script>document.location.href='index.php'</script>";
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='index.php'</script>";
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }