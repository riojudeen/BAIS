<?php
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM leave_alocation")) or die(mysqli_error($link));
    if(isset($_POST['add'])){
        
        $kode_absen = $_POST['leave_code'][0];
        $effDate = dateToDB($_POST['start'][0]);
        $aloc = $_POST['alokasi'][0];
        $id = $maxId['id'] + 1;
        // echo $effDate;
        $sql = mysqli_query($link, "INSERT INTO leave_alocation (id, effective_date, id_leave, alocation) VALUES 
            ('$id' ,'$effDate' , '$kode_absen', '$aloc')")or die(mysqli_error($link));
        if($sql){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }
    }else if(isset($_GET['del'])){
        mysqli_query($link, "DELETE FROM leave_alocation WHERE id = '$_GET[del]' ")or die(mysqli_error($link));
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='index.php'</script>";
    }else if(isset($_POST['edit'])){
        $kode_absen = $_POST['leave_code'][0];
        $effDate = dateToDB($_POST['start'][0]);
        $aloc = $_POST['alokasi'][0];
        $id = $_POST['id'][0];
        // echo $effDate;
        // echo $id;
        $sql = mysqli_query($link, "UPDATE leave_alocation SET 
                effective_date = '$effDate', id_leave = '$kode_absen', alocation = '$aloc' WHERE id ='$id' ")or die(mysqli_error($link));
        if($sql){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }
    }
        
    
    

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}