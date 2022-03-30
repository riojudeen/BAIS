<?php
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM leave_alocation")) or die(mysqli_error($link));
    if(isset($_POST['add'])){
        
        $kode_absen = $_POST['leave_code'][0];
        $effDate = dateToDB($_POST['start'][0]);
        $endeffDate = dateToDB($_POST['end'][0]);
        $period = $_POST['leave_period_type'][0];
        $aloc = $_POST['alokasi'][0];
        $id = $maxId['id'] + 1;
        // echo $effDate;
        $sql = mysqli_query($link, "INSERT INTO leave_alocation (id, effective_date, `end`, `type`, id_leave, alocation) VALUES 
            ('$id' ,'$effDate' , '$endeffDate', '$period', '$kode_absen', '$aloc')")or die(mysqli_error($link));
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
        $endeffDate = dateToDB($_POST['end'][0]);
        $aloc = $_POST['alokasi'][0];
        $period = $_POST['leave_period_type'][0];
        $id = $_POST['id'][0];
        // echo $effDate;
        // echo $id;
        $sql = mysqli_query($link, "UPDATE leave_alocation SET 
                effective_date = '$effDate', 
                `end` = '$endeffDate', 
                id_leave = '$kode_absen', 
                alocation = '$aloc' ,
                `type` = '$period'
                WHERE id ='$id' ")or die(mysqli_error($link));
        if($sql){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='index.php'</script>";
        }
    }else if(isset($_POST['attachment_seting'])){
        $attach_seting = $_POST['attachment_seting'];
        $id = $_POST['input_kode_cuti'];
        $sql = mysqli_query($link, "UPDATE attendance_code SET attachment = '$attach_seting' WHERE kode = '$id' ");
    }
        
    
    

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}