<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
require("../../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if(isset($_GET['del'])){
    $npk = $_GET['del'];
    $del = mysqli_query($link, "DELETE FROM karyawan WHERE npk = '$npk'") or die(mysqli_error($link));
    if($del){
        $_SESSION['info'] = 'Dihapus';
        echo "<script>document.location.href='../manpower.php'</script>";
    }else{
        $_SESSION['info'] = 'Gagal Dihapus';
        echo "<script>document.location.href='../manpower.php'</script>";
    }
}else if(isset($_POST['save'])){
    $total = count($_POST['npk']);

        // $_POST['npk'][$i];
        // $_POST['nama'][$i];
        // $_POST['tgl_masuk'][$i];

        // $_POST['department'][$i];
        // $_POST['shift'][$i];
        // $_POST['jabatan'][$i];
        // $_POST['status'][$i];

        //menelusuri id_area
        // $_POST['dept'][$i];
        // $_POST['sect'][$i];
        // $_POST['group'][$i];
        // $_POST['pos'][$i];

    // echo $total."<br />";
    $sql = "INSERT INTO karyawan (npk, nama, tgl_masuk, jabatan, shift, `status` , department , id_area) VALUES";
    for($i = 0 ; $i < $total ; $i++){

        $npk = trim(mysqli_real_escape_string($link, $_POST['npk'][$i]));
        $nama = trim(mysqli_real_escape_string($link, $_POST['nama'][$i]));
        $tanggal = trim(mysqli_real_escape_string($link, $_POST['tgl_masuk'][$i]));
        // memecah tanggal :
        $pecah_tanggal = explode("-" , $tanggal);
        $tanggal = $pecah_tanggal[2]."-".$pecah_tanggal[1]."-".$pecah_tanggal[0];

        // mencari id area yang tidak kosong
        $dept = ($_POST['dept'][$i]);
        $sect = $_POST['sect'][$i];
        $group = $_POST['group'][$i];
        $pos = $_POST['pos'][$i];
        
        $department = $_POST['department'][$i];
        $shift = $_POST['shift'][$i];
        $jabatan = $_POST['jabatan'][$i];
        $status = $_POST['status'][$i];

        if($dept == "0"){
            $id_area = "1";
        }else if($sect == "0" && $group == "0" && $pos == "0"){
            $id_area = $dept;
        }else if($group == "0" && $pos == "0"){
            $id_area = $sect;
        }else if($pos == "0"){
            $id_area = $group;
        }else{
            $id_area = $pos;
        }
        //lanjutan
        $sql .= "('$npk', '$nama', '$tanggal', '$jabatan' , '$shift' , '$status' , '$department' , '$id_area'),";

    }

    $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
    $del = mysqli_query($link, $sql);
    if($del){
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../manpower.php'</script>";
    }else{
        $_SESSION['info'] = 'Gagal Disimpan';
        echo "<script>document.location.href='../addMp.php'</script>";
    }
}else if(isset($_POST['edit'])){
    $total = count($_POST['npk']);
    for ($i=0; $i<count($_POST['npk']); $i++){
        $npk = $_POST['npk'][$i];
        $nama = $_POST['nama'][$i];
        $nick = $_POST['nick'][$i];
        $tgl_masuk = $_POST['tgl_masuk'][$i];
        $shift = $_POST['shift'][$i];
        $jabatan = $_POST['jabatan'][$i];
        $status = $_POST['status'][$i];
        $dept = $_POST['dept'][$i];
        $sect = $_POST['sect'][$i];
        $group = $_POST['group'][$i];
        $pos = $_POST['pos'][$i];

        echo "$npk<br />";
        echo "$nama<br />";
        echo "$nick<br />";
        echo "$tgl_masuk<br />";
        echo "$shift<br />";
        echo "$jabatan<br />";
        echo "$status<br />";
        echo "$dept<br />";
        echo "$sect<br />";
        echo "$group<br />";
        echo "$pos<br />";
        echo "$total<br /><br />";

        $sqMp = mysqli_query($link, "UPDATE karyawan SET nama = '$nama' , nama_depan = '$nick', tgl_masuk = '$tgl_masuk' , shift = '$shift' , 
        jabatan = '$jabatan' , `status` = '$status' , id_area = '$dept' WHERE npk = '$npk'") or die(mysqli_error($link));

    }
    // if($sqldept){
    //     echo "<script>alert('berhasil $total edit data');window.location='index.php'</script>";
    // }else{
    //     echo "<script>alert('gagal edit $total data');window.location='edit.php'</script>";

    // }
}else if(isset($_POST['transfer'])){
    $i = 0;
    $npk = $_POST['npk'][$i];
    $t_division = (isset($_POST['t_div']))?"'".$_POST['t_div']."'":'NULL';
    $t_deptAcc = (isset($_POST['t_deptAcc']))?"'".$_POST['t_deptAcc']."'":'NULL';
    $t_dept = (isset($_POST['t_dept']))?"'".$_POST['t_dept']."'":'NULL';
    $division = (isset($_POST['division']) && $_POST['division'][$i] != '-' )?"'".$_POST['division'][$i]."'":'NULL';
    $deptAcc = (isset($_POST['deptAcc']) && $_POST['deptAcc'][$i] != '-' )?"'".$_POST['deptAcc'][$i]."'":'NULL';
    $dept = (isset($_POST['dept']) && $_POST['dept'][$i] != '-')?"'".$_POST['dept'][$i]."'":'NULL';
    $sect = (isset($_POST['sect']) && $_POST['sect'][$i] != '-')?"'".$_POST['sect'][$i]."'":'NULL';
    $group = (isset($_POST['group']) && $_POST['group'][$i] != '-' )?"'".$_POST['group'][$i]."'":'';
    $pos = (isset($_POST['pos']) && $_POST['pos'][$i] != '-')?"'".$_POST['pos'][$i]."'":'NULL';
    
    $cek = mysqli_query($link, "SELECT npk FROM org_transfer WHERE npk = '$npk' ")or die(mysqli_error($link));
    switch($level){
        case "8":
            $dis_division = $division;
            $dis_dept_acc = $deptAcc;
            $dis_dept= $dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        case "7":
            $dis_division = $division;
            $dis_dept_acc = $deptAcc;
            $dis_dept= $dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        case "6":
            $dis_division = $division;
            $dis_dept_acc = $deptAcc;
            $dis_dept= $dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        case "5":
            $dis_division = $t_division;
            $dis_dept_acc = $t_deptAcc;
            $dis_dept= $dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        
        case "4":
            $dis_division = $t_division;
            $dis_dept_acc = $t_deptAcc;
            $dis_dept= $dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        case "3":
            $dis_division = $t_division;
            $dis_dept_acc = $t_deptAcc;
            $dis_dept= $t_dept;
            $dis_sect = $sect;
            $dis_group = $group;
            $dis_pos = $pos;
            break;
        
    }
    $date = date('Y-m-d');
    if($level > 2){
        // echo "INSERT INTO org_transfer (`npk`,`post`,`grp`,`sect`,`dept`,`dept_account`,`division`,`plant`) VALUES
        // ('$npk', $dis_pos, $dis_group, $dis_sect, $dis_dept, $dis_dept_acc,$dis_division, '1' ) ";
        if(mysqli_num_rows($cek) > 0){
            $_SESSION['info'] = "Gagal Disimpan";
            header("location:../edit_mp.php?transfer=$npk");
        }else{
            $sql = mysqli_query($link, "INSERT INTO org_transfer (`npk`,`post`,`grp`,`sect`,`dept`,`dept_account`,`division`,`plant`, `stats`, `req_date`, `requester`) VALUES
            ('$npk', $dis_pos, $dis_group, $dis_sect, $dis_dept, $dis_dept_acc,$dis_division, '1' , '1', '$date' , '$npkUser' ) ")or die(mysqli_error($link));
            // if($sql){
            //     $_SESSION['info'] = "Disimpan";
            //      header("location:../edit_mp.php?transfer=$npk");
            // }else{
            //     $_SESSION['info'] = "Gagal Disimpan";
            //      header("location:../edit_mp.php?transfer=$npk");
            // }
        }
    }
   
    
}else if($_GET['proccess_tf']){
    $npk = $_GET['proccess_tf'];
    $query_cek = mysqli_query($link, "SELECT id_pos, id_grp, id_sect, id_dept, id_dept_account, id_division FROM view_org_trf WHERE npk = '$npk' ")or die(mysqli_error($link));
    if($level >= 6){
        if(mysqli_num_rows($query_cek) > 0 ){
            $sql_cek = mysqli_fetch_assoc($query_cek);
            $pos = $sql_cek['id_pos'];
            $group = $sql_cek['id_grp'];
            $sect = $sql_cek['id_sect'];
            $dept = $sql_cek['id_dept'];
            $dept_account = $sql_cek['id_dept_account'];
            $division = $sql_cek['id_division'];
            // echo "tes";
            $sql = mysqli_query($link, "UPDATE org SET post = '$pos' , grp = '$group' , sect= '$sect' , dept = '$dept', dept_account = '$dept_account', division = '$division' WHERE npk = '$npk' ")or die(mysqli_error($link));
            if($sql){
                $sql_tf = mysqli_query($link, "DELETE FROM org_transfer WHERE npk = '$npk' ")or die(mysqli_error($link));
                $_SESSION['info'] = "Disimpan";
                header('location:../../pages/mp_update.php');
            }
        }else{
            $_SESSION['info'] = "Gagal Disimpan";
            header('location:../../pages/mp_update.php');
        }
    }else{
        if(mysqli_num_rows($query_cek) > 0 ){
            // $sql_cek = mysqli_fetch_assoc($query_cek);
            // $pos = $sql_cek['id_pos'];
            // $group = $sql_cek['id_grp'];
            // $sect = $sql_cek['id_sect'];
            // $dept = $sql_cek['id_dept'];
            // $dept_account = $sql_cek['id_dept_account'];
            // $division = $sql_cek['id_division'];
            // echo "tes";
            $sql_tf = mysqli_query($link, "UPDATE org_transfer SET review = '$npkUser' WHERE npk = '$npk' ")or die(mysqli_error($link));
            // $sql = mysqli_query($link, "UPDATE org SET post = '$pos' , grp = '$grp' , sect= '$sect' , dept = '$dept', dept_account = '$dept_account', division = '$division' WHERE npk = '$npk' ")or die(mysqli_error($link));
            if($sql_tf){
                
                $_SESSION['info'] = "Disimpan";
                header('location:../../pages/mp_update.php');
            }
        }else{
            $_SESSION['info'] = "Gagal Disimpan";
            header('location:../../pages/mp_update.php');
        }
    }
    // echo "tes";
}else if($_GET['del_tf']){
    $npk = $_GET['del_tf'];
    
    $sql = mysqli_query($link, "DELETE FROM org_transfer WHERE npk = '$npk' ")or die(mysqli_error($link));
    if($sql){
        
        $_SESSION['info'] = "Dihapus";
        header('location:../../pages/mp_update.php');
    }else{
        $_SESSION['info'] = "Gagal Dihapus";
        header('location:../../pages/mp_update.php');
    }
    // echo "tes";
}

?>