<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
    
    /////////////
    if(isset($_POST['addbreak'])){
        $total = count($_POST['skema']); //kaena ada form yang dihiden maka total harus dikurangi 1 agar form terhiden tidak terbaca
        
        $sql = "INSERT working_break (id, scheme_name, `start_time`, `end_time`, effective_date) VALUES ";
        $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM working_break")) or die(mysqli_error($link));
        $lastId = $maxId['id'];
        for($i = 0 ; $i < $total; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['skema'][$i]));
            $start = trim(mysqli_real_escape_string($link, $_POST['start'][$i]));
            if($i>0){
                $ket = dateToDB(DBtoForm(trim(mysqli_real_escape_string($link, $_POST['effective'][$i]))));
            }else{
                $ket = dateToDB(trim(mysqli_real_escape_string($link, $_POST['effective'][$i])));
            }
            $end = trim(mysqli_real_escape_string($link, $_POST['end'][$i]));
            $id = $lastId + 1+ $i;
            $sql .= " ('$id', '$code', '$start', '$end', '$ket'),";
        }
        // echo $sql;
        $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
        $add = mysqli_query($link, $sql);
        
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }
    }else if(isset($_GET['del'])){
        
        mysqli_query($link, "DELETE FROM working_break WHERE  id = '$_GET[del]' ");
        $_SESSION['info'] = 'Dihapus';  
        echo "<script>document.location.href='../index.php#b'</script>";
    }else if(isset($_POST['edit'])){
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['skema'][$i]));
        $start = trim(mysqli_real_escape_string($link, $_POST['start'][$i]));
        $end = trim(mysqli_real_escape_string($link, $_POST['end'][$i]));
        $ket = dateToDB(trim(mysqli_real_escape_string($link, $_POST['effective'][$i])));
        $id = trim(mysqli_real_escape_string($link, $_POST['edit'][$i]));

        $sql = mysqli_query($link,"UPDATE working_break SET scheme_name = '$code' , `start_time` = '$start', `end_time` = '$end', `effective_date` = '$ket' WHERE id = '$id' ") or die(mysqli_error($link));
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../index.php#b'</script>";    
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php#wh'</script>";    
        }
        
    }else if(isset($_POST['addbreakshift'])){
        $sql = "INSERT working_break_shift (id_working_day_shift, id_working_break, `effective_date`, `break_group_id`) VALUES ";
        $total = count($_POST['wb']);
        $shift = trim(mysqli_real_escape_string($link, $_POST['shift']));
        $efft = dateToDB(trim(mysqli_real_escape_string($link, $_POST['effective'])));
        $breakGroup = idIncrement($link, "working_break_shift","break_group_id");
        for($i=0 ;$i<$total;$i++){
            $wb = trim(mysqli_real_escape_string($link, $_POST['wb'][$i]));
            $sql .= " ('$shift', '$wb', '$efft', '$breakGroup'),";
        }
        $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
        // echo $sql;
        $add = mysqli_query($link, $sql);
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }

    }else if(isset($_GET['delbreak'])){
        // echo "tes";
        $sql = "DELETE FROM working_break_shift WHERE id_working_day_shift = '$_GET[idshift]' AND id_working_break = '$_GET[delbreak]' AND effective_date = '$_GET[eff]' ";
        $del = mysqli_query($link, $sql)or die(mysqli_error($link));
        
        
        // echo $sql;
        if($del){
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Dihapus';
            echo "<script>document.location.href='../index.php#b'</script>";
        }
    }else if(isset($_POST['previewBrakShift'])){
        $sql = "DELETE FROM working_break_shift WHERE break_group_id = '$_POST[previewBrakShift]'";
        $del = mysqli_query($link, $sql)or die(mysqli_error($link));
        
        
        // echo $sql;
        if($del){
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Dihapus';
            echo "<script>document.location.href='../index.php#b'</script>";
        }
    }else if(isset($_POST['editbreakshift'])){
        // echo $_POST['editbreakshift'];
        $sqlDel = "DELETE FROM working_break_shift WHERE break_group_id = '$_POST[editbreakshift]' ";
        mysqli_query($link, $sqlDel)or die(mysqli_error($link));
        $sql = "INSERT working_break_shift (id_working_day_shift, id_working_break, `effective_date`, `break_group_id`) VALUES ";
        $total = count($_POST['wb']);
        $shift = trim(mysqli_real_escape_string($link, $_POST['shift']));
        $efft = dateToDB(trim(mysqli_real_escape_string($link, $_POST['effective'])));
        $breakGroup = $_POST['editbreakshift'];
        for($i=0 ;$i<$total;$i++){
            $wb = trim(mysqli_real_escape_string($link, $_POST['wb'][$i]));
            $sql .= " ('$shift', '$wb', '$efft', '$breakGroup'),";
        }
        $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
        // echo $sql;
        $add = mysqli_query($link, $sql);
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }
    }else{
        $_SESSION['info'] = 'Kosong'; 
        echo $_GET['del'];
        // echo "<script>document.location.href='../index.php'</script>";   
    }

/////////////
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>