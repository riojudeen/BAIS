<?php
require_once("../../../config/config.php");

if(!isset($_POST['deptchecked'])){
    echo "<script>alert('tidak ada data yang dipilih');window.location='index.php';</script>";
} else {
    $check = $_POST['deptchecked'];
    foreach($check as $id){
        $sqldept = mysqli_query($link, "DELETE FROM department WHERE id_dept = '$id'") or die(mysqli_error($link));
    }
    if($sqldept){
        echo "<script>alert(' ".count($check)." data berhasil dihapus');window.location='index.php'</script>";

    }else{
        echo "<script>alert(' data gagal dihapus')</script>";
    
    } 
}
    
    ?>