<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
/////////////
if(isset($_POST['add'])){
    $total = count($_POST['code']); //kaena ada form yang dihiden maka total harus dikurangi 1 agar form terhiden tidak terbaca
    
    $sql = "INSERT working_day_shift (id, `name`) VALUES ";
    for($i = 0 ; $i < $total; $i++){
        $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
        $ket = trim(mysqli_real_escape_string($link, $_POST['name'][$i]));
       
        $sql .= " ('$code', '$ket'),";
    }
    $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
    $add = mysqli_query($link, $sql);
    // echo $sql;
    if($add){
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../index.php#ws'</script>";
    }else{
        
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../index.php#ws'</script>";
    }
}else if(isset($_GET['del'])){
    $query = "DELETE FROM working_day_shift WHERE  id = '$_GET[del]'";
    $sql = mysqli_query($link, $query);
    if($sql){

        $_SESSION['info'] = 'Dihapus'; 
        echo "<script>document.location.href='../index.php#ws'</script>";
    }else{
        $_SESSION['info'] = 'Gagal Dihapus'; 
        echo "<script>document.location.href='../index.php#ws'</script>";
    }
    
}else if(isset($_POST['edit'])){
    $i = 0;
    $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
    $ket = trim(mysqli_real_escape_string($link, $_POST['name'][$i]));

    $sql = mysqli_query($link,"UPDATE working_day_shift SET `name` = '$ket' WHERE id  = '$code'") or die(mysqli_error($link));
    
    if($sql){
        $_SESSION['info'] = 'Disimpan'; 
        echo "<script>document.location.href='../index.php#wh'</script>";    
    }else{
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../index.php#wh'</script>";    
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