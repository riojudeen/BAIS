<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
/////////////
if(isset($_POST['add'])){
    $total = count($_POST['shift']); //kaena ada form yang dihiden maka total harus dikurangi 1 agar form terhiden tidak terbaca
    
    $sql = "INSERT working_scheme (id, shift, shifting, working_hours, effective_date) VALUES ";
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM working_scheme")) or die(mysqli_error($link));
    $lastId = $maxId['id'];
    for($i = 0 ; $i < $total; $i++){
        $shift = $_POST['shift'][$i];
        $shifting = $_POST['shifting'][$i];
        $wh = $_POST['wh'][$i];
        $effDate = dateToDB($_POST['effdate'][$i]);
        $id = $lastId + 1+ $i;
        $sql .= " ('$id', '$shift', '$shifting','$wh', '$effDate'),";

    }
    $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
    $add = mysqli_query($link, $sql);
    
    if($add){
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../index.php#ws'</script>";
    }else{
        
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../index.php#ws'</script>";
    }
}else if(isset($_GET['del'])){
    mysqli_query($link, "DELETE FROM working_scheme WHERE  id = '$_GET[del]' ");
    $_SESSION['info'] = 'Dihapus';
    echo "<script>document.location.href='../index.php#ws'</script>";
}else if(isset($_POST['edit'])){
    $i = 0;
    $shift = $_POST['shift'][$i];
    $shifting = $_POST['shifting'][$i];
    $wh = $_POST['wh'][$i];
    $effDate = dateToDB($_POST['effdate'][$i]);
    $id = trim(mysqli_real_escape_string($link, $_POST['id'][$i]));

    $sql = mysqli_query($link,"UPDATE working_scheme SET working_hours = '$wh' , `shift` = '$shift', `shifting` = '$shifting', `effective_date` = '$effDate' WHERE id = '$id' ") or die(mysqli_error($link));
    if($sql){
        $_SESSION['info'] = 'Disimpan'; 
        echo "<script>document.location.href='../index.php#ws'</script>";    
    }else{
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../index.php#ws'</script>";    
    }
    


}else{
    $_SESSION['info'] = 'Kosong'; 
    echo "<script>document.location.href='../index.php'</script>";   
}

/////////////
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>