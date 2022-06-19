<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
/////////////
    if(isset($_POST['add'])){
        $total = count($_POST['name_code']); //kaena ada form yang dihiden maka total harus dikurangi 1 agar form terhiden tidak terbaca
        
        $sql = "INSERT working_hours (id, code_name, `start`, `end`, ket) VALUES ";
        $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM working_hours")) or die(mysqli_error($link));
        $lastId = $maxId['id'];
        for($i = 0 ; $i < $total; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['name_code'][$i]));
            $start = trim(mysqli_real_escape_string($link, $_POST['start'][$i]));
            $end = trim(mysqli_real_escape_string($link, $_POST['end'][$i]));
            $ket = trim(mysqli_real_escape_string($link, $_POST['ket'][$i]));
            $id = $lastId + 1+ $i;
            $sql .= " ('$id', '$code', '$start', '$end', '$ket'),";
        }
        $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
        $add = mysqli_query($link, $sql);
        
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../index.php?tab=wh'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php?tab=wh'</script>";
        }
    }else if(isset($_GET['del'])){
        mysqli_query($link, "DELETE FROM working_hours WHERE  id = '$_GET[del]' ");
        $_SESSION['info'] = 'Dihapus';  
        echo "<script>document.location.href='../index.php?tab=wh'</script>";
    }else if(isset($_POST['edit'])){
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['name_code'][$i]));
        $start = trim(mysqli_real_escape_string($link, $_POST['start'][$i]));
        $end = trim(mysqli_real_escape_string($link, $_POST['end'][$i]));
        $ket = trim(mysqli_real_escape_string($link, $_POST['ket'][$i]));
        $id = trim(mysqli_real_escape_string($link, $_POST['id'][$i]));

        $sql = mysqli_query($link,"UPDATE working_hours SET code_name = '$code' , `start` = '$start', `end` = '$end', `ket` = '$ket' WHERE id = '$id' ") or die(mysqli_error($link));
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../index.php?tab=wh'</script>";    
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php?tab=wh'</script>";    
        }
        


    }else{
        $_SESSION['info'] = 'Kosong'; 
        echo "<script>document.location.href='../index.php?tab=wh'</script>";   
        // echo "tes";
    }

/////////////
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>