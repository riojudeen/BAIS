<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
/////////////
if(isset($_POST['add'])){
    $total = count($_POST['date']) - 1; //kaena ada form yang dihiden maka total harus dikurangi 1 agar form terhiden tidak terbaca
    
    $sql = "REPLACE INTO holidays (id, `date`, `type`, ket) VALUES ";
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM holidays")) or die(mysqli_error($link));
    $lastId = $maxId['id'];
    for($i = 0 ; $i < $total; $i++){
        $date = trim(mysqli_real_escape_string($link, $_POST['date'][$i]));
       
        $type = trim(mysqli_real_escape_string($link, $_POST['type'][$i]));
        $ket = trim(mysqli_real_escape_string($link, $_POST['ket'][$i]));
        $id = $lastId + 1+$i;
        $sql .= " ('$id', '$date', '$type', '$ket'),";
    }
    $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
    $add = mysqli_query($link, $sql);
    
    if($add){
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../index.php#holiday'</script>";
    }else{
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../index.php#holiday'</script>";
    }
}else if(isset($_GET['del'])){
    mysqli_query($link, "DELETE FROM holidays WHERE  id = '$_GET[del]' ");
    $_SESSION['info'] = 'Dihapus';
    echo "<script>document.location.href='../index.php#hd'</script>";
}else if(isset($_POST['edit'])){
   
    $date = trim(mysqli_real_escape_string($link, $_POST['date'][0]));
    
    $type = trim(mysqli_real_escape_string($link, $_POST['type'][0]));
    $ket = trim(mysqli_real_escape_string($link, $_POST['ket'][0]));
    $id = trim(mysqli_real_escape_string($link, $_POST['id'][0]));
    $sql = mysqli_query($link,"UPDATE holidays SET `type` = '$type' , `date` = '$date', ket = '$ket' WHERE id = '$id' " );
    if($sql){
        $_SESSION['info'] = 'Disimpan'; 
        echo "<script>document.location.href='../index.php#holiday'</script>";    
    }

}else if(isset($_POST['addholidays'])){
    if(isset($_POST['index'])){
        // echo $total;
        $total = count($_POST['index']);
        $idStart = idIncrement($link,"holidays","id");
        $query = "REPLACE INTO holidays (`id`,`date`,`type`,`ket`) VALUES ";
        for($i=0;$i<$total;$i++){
            $id = $idStart+$i;
            $ind = trim(mysqli_real_escape_string($link, $_POST['index'][$i]));
            $date = trim(mysqli_real_escape_string($link, $_POST['date'.$ind]));
            $ket = trim(mysqli_real_escape_string($link, $_POST['keterangan'.$ind]));
            $type = trim(mysqli_real_escape_string($link, $_POST['holidayType'.$ind]));
    
            $query .= "('$id','$date','$type','$ket'),";
            // echo $_POST['date'.$ind]."<br>";
            
        }
        // print_r( $_POST['index']);
        $sql = substr($query, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $add = mysqli_query($link, $sql)or die(mysqli_error($link));
        if($add){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../index.php#holiday'</script>";   
        }else{
            $_SESSION['info'] = 'Gagal Disimpan'; 
            echo "<script>document.location.href='../index.php#holiday'</script>";   
        }

    }else{
        $_SESSION['info'] = 'Kosong'; 
        echo "<script>document.location.href='../index.php#holiday'</script>";   
    }
}else{
    $_SESSION['info'] = 'Kosong'; 
    echo "<script>document.location.href='../index.php#holiday'</script>";   
}

/////////////
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>