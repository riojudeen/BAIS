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
}
?>