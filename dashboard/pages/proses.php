<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
//tampung id department 


if(isset($_POST['add'])){
  $nama = trim(mysqli_real_escape_string($link, $_POST['nama']));
  $npk = trim(mysqli_real_escape_string($link, $_POST['npk']));
  $nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
  $tgl_masuk = dateToDB(trim(mysqli_real_escape_string($link, $_POST['tgl_masuk'])));
  $jabatan = trim(mysqli_real_escape_string($link, $_POST['jabatan'])); 
  $shift = trim(mysqli_real_escape_string($link, $_POST['shift']));
  $status = trim(mysqli_real_escape_string($link, $_POST['status']));
  $username = "body".$npk;

  $role = trim(mysqli_real_escape_string($link, $_POST['role']));
  $pass = sha1(trim(mysqli_real_escape_string($link, $_POST['pass'])));
  //validasi inputan primary key yang sudah ada
  $cekvalidasi = mysqli_query($link, "SELECT * FROM karyawan WHERE npk='$npk'");
  if(mysqli_num_rows($cekvalidasi) > 0){
    $_SESSION['info'] = "Gagal Disimpan";
    $_SESSION['pesan'] = "Data karyawan sudah ada sebelumnya, ";
    header('location: addmp.php');
    // echo "<script>alert('karayawan dengan NPK $npk sudah ada di dalam database!');window.location='addmp.php'</script>";

  }else{
    // echo $pass."<br>";
    // echo $role."<br>";
    // echo $npk."<br>";
    // echo $nick."<br>";
    // echo $tgl_masuk."<br>";
    // echo $jabatan."<br>";
    // echo $shift."<br>";
    // echo $status."<br>";
    // echo $username."<br>";
    $sql = mysqli_query($link, "INSERT INTO karyawan (npk, nama_depan, nama, tgl_masuk, jabatan, shift, status, id_area) 
            VALUES ('$npk' , '$nick', '$nama' , '$tgl_masuk' , '$jabatan' , '$shift', '$status' , NULL)") or die(mysqli_error($link));
    if($sql){
      mysqli_query($link, "INSERT INTO data_user (username, npk, pass, `level`) VALUES ('$username', '$npk', '$pass', '$role' )")or die(mysqli_error($link));
      mysqli_query($link, "INSERT INTO org (npk, plant) VALUES ('$npk', '1' )")or die(mysqli_error($link));
      $_SESSION['info'] = "Disimpan";
      header('location: ../../dashboard/setting/employee/add_karyawan.php');
    }else{
      $_SESSION['info'] = "Gagal Disimpan";
      $_SESSION['pesan'] = "error code : ".mysqli_error($link);
      header('location: addmp.php');
    }
    
    // echo "<script>alert('karayawan dengan NPK $npk sudah ditambahkan!');window.location='manpower.php'</script>";
  }
  


}else if(isset($_POST['edit'])){
  $nama = trim(mysqli_real_escape_string($link, $_POST['nama']));
  $npk = trim(mysqli_real_escape_string($link, $_POST['npk']));
  $nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
  $tgl_masuk = trim(mysqli_real_escape_string($link, $_POST['tgl_masuk']));
  $jabatan = trim(mysqli_real_escape_string($link, $_POST['jabatan'])); 
  $shift = trim(mysqli_real_escape_string($link, $_POST['shift']));
  $status = trim(mysqli_real_escape_string($link, $_POST['status']));
  $pos = trim(mysqli_real_escape_string($link, $_POST['pos']));

  mysqli_query($link, "UPDATE karyawan SET nama = '$nama', nama_depan = '$nick', tgl_masuk = '$tgl_masuk', jabatan = '$jabatan', shift = '$shift', status = '$status', id_area = '$pos' WHERE npk = '$npk'") or die(mysqli_error($link));
  echo "<script>alert('data sudah diedit!');window.location='manpower.php'</script>";
}

?>