<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['edit'])){
        $totalData = count($_POST['npk']);
        for($i = 0 ; $i < $totalData ; $i++){
            $npk = $_POST['nama'][$i];
            $role = $_POST['level'][$i];
            $passOld = sha1(trim(mysqli_real_escape_string($link, $_POST['pass1'][$i])));
            $passNew = sha1(trim(mysqli_real_escape_string($link, $_POST['pass2'][$i])));
            $pass = ($_POST['passactive'][$i] == 'new')? $passNew : $passOld;
            $query = mysqli_query($link, "UPDATE data_user SET pass = '$pass', `level` = '$role' WHERE npk = '$npk' ")or die(mysqli_error($link));
            
        }
       
        if($query){
            
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../user.php?tab=$role'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../user.php?tab=$role'</script>";
        }
        
    }else if(isset($_GET['del'])){
        $sqldu= mysqli_query($link, "DELETE FROM data_user WHERE npk = '$_GET[del]'") or die(mysqli_error($link));
        if($sqldu){
            
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../user.php?tab=$_GET[tab]'</script>";
        }
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}  

?>