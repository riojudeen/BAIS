<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
// require("../../../_assets/vendor/autoload.php");
if(isset($_SESSION['user'])){
/////////////
// echo $_POST['editMaster'];
//jika add
if(isset($_POST['addMaster'])){
    $tab = $_POST['master'];
    //jika Jabatan
    if($_POST['master'] == "jbtn"){
        $sql = "INSERT INTO jabatan (id_jabatan, jabatan, `level`) VALUES";
        $total = count($_POST['code']);
        // echo $total;
        for($i = 0 ; $i < $total ; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
            $jbt = trim(mysqli_real_escape_string($link, $_POST['jbt'][$i]));
            $lvl = trim(mysqli_real_escape_string($link, $_POST['lvl'][$i]));
            $sql .= "('$code' , '$jbt', '$lvl'),";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        $add = mysqli_query($link, $sql);
        // echo $sql;
        if($add){
            $_SESSION['info'] = 'Disimpan';
            // echo "ok";
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }

    //jika absensi
    }else if($_POST['master'] == "abs"){
        
        $sql = "INSERT INTO attendance_code (kode, keterangan, `type`) VALUES";
        $total = count($_POST['code']);

        for($i = 0 ; $i < $total ; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
            $ijin = trim(mysqli_real_escape_string($link, $_POST['ijin'][$i]));
            $type = trim(mysqli_real_escape_string($link, $_POST['type'][$i]));

            $sql .= "('$code' , '$ijin', '$type'),";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $add = mysqli_query($link, $sql);
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }
    //jika overtime code
    }else if($_POST['master'] == "ot"){
        // echo $_POST['master'];
        $sql = "INSERT INTO kode_lembur (kode_lembur, nama) VALUES";
        $total = count($_POST['code']);

        for($i = 0 ; $i < $total ; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
            $lembur = trim(mysqli_real_escape_string($link, $_POST['lembur'][$i]));

            $sql .= "('$code' , '$lembur'),";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        $add = mysqli_query($link, $sql);
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }
    //jika shift
    }else if($_POST['master'] == "shf"){
        // echo $_POST['master'];
        $sql = "INSERT INTO shift (id_shift, shift, production) VALUES";
        $total = count($_POST['code']);

        for($i = 0 ; $i < $total ; $i++){
            $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
            $shift = trim(mysqli_real_escape_string($link, $_POST['shift'][$i]));
            $prod = trim(mysqli_real_escape_string($link, $_POST['production'][$i]));
            

            $sql .= "('$code' , '$shift', '$prod'),";

        }
        // echo $sql;
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        $add = mysqli_query($link, $sql);
        if($add){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }
        
    //jika tidak ada
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='../master.php'</script>";
    }

//jika edit
}else if(isset($_POST['editMaster'])){
    // echo $_POST['editMaster'];
    $tab = $_POST['master'];
    
    if($_POST['master'] == "jbtn"){
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
        $jbt = trim(mysqli_real_escape_string($link, $_POST['jbt'][$i]));
        $lvl = trim(mysqli_real_escape_string($link, $_POST['lvl'][$i]));


        $sql = mysqli_query($link,"UPDATE jabatan SET jabatan = '$jbt', `level` = '$lvl' WHERE id_jabatan = '$code' " );
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";    
        }

    }else if($_POST['master'] == "abs"){
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
        $ijin = trim(mysqli_real_escape_string($link, $_POST['ijin'][$i]));
        $type = trim(mysqli_real_escape_string($link, $_POST['type'][$i]));
        
        $sql = mysqli_query($link,"UPDATE attendance_code SET keterangan = '$ijin', `type` = '$type'  WHERE kode = '$code' " );
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }

    }else if($_POST['master'] == "shf"){
        // echo $_POST['master'];
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
        $shift = trim(mysqli_real_escape_string($link, $_POST['shift'][$i]));
        $prod = trim(mysqli_real_escape_string($link, $_POST['production'][$i]));
        $sql = mysqli_query($link,"UPDATE shift SET shift = '$shift', production = '$prod'  WHERE id_shift = '$code' " );
        // echo "UPDATE shift SET shift = '$shift', production = '$prod'  WHERE id_shift = '$code' ";
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan'; 
            $_SESSION['pesan'] = mysqli_error($link); 
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }

    }else if($_POST['master'] == "ot"){
        $i = 0;
        $code = trim(mysqli_real_escape_string($link, $_POST['code'][$i]));
        $lembur = trim(mysqli_real_escape_string($link, $_POST['lembur'][$i]));

        $sql = mysqli_query($link,"UPDATE kode_lembur SET nama= '$lembur' WHERE kode_lembur = '$code' " );
        if($sql){
            $_SESSION['info'] = 'Disimpan'; 
            echo "<script>document.location.href='../master.php?tab=$tab'</script>";
        }

    }
    
    
}else if(isset($_GET['del'])){
    $tab = $_GET['del'];

    if($_GET['del'] == "jbtn"){
        mysqli_query($link, "DELETE FROM jabatan WHERE  id_jabatan = '$_GET[jbt]' ");
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../master.php?tab=$tab'</script>";
    }else if($_GET['del'] == "abs"){
        mysqli_query($link, "DELETE FROM attendance_code WHERE  kode= '$_GET[abs]' ");
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../master.php?tab=$tab'</script>";
    }else if($_GET['del'] == "shf"){
        mysqli_query($link, "DELETE FROM shift WHERE  id_shift = '$_GET[shf]' ");
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../master.php?tab=$tab'</script>";
    }else if($_GET['del'] == "ot"){
        mysqli_query($link, "DELETE FROM kode_lembur WHERE kode_lembur = '$_GET[ot]' ");
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../master.php?tab=$tab'</script>";
    }
}else{
    $_SESSION['info'] = 'Kosong';
    echo "<script>document.location.href='../master.php'</script>";
}


/////////////
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>