<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){ 
    if(isset($_POST['mpchecked'])){
        foreach($_POST['mpchecked'] as $npk){
            $sqlmp = mysqli_query($link, "DELETE FROM karyawan WHERE npk = '$npk'") or die(mysqli_error($link));
        }
        if($sqlmp){
            
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../manpower.php'</script>";
        }

    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='../manpower.php'</script>";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>