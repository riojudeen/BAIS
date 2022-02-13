<?php
require_once("../../config/config.php");
//tampung id department 


if(isset($_POST['add'])){
  $nama = trim(mysqli_real_escape_string($link, $_POST['nama']));
  $npk = trim(mysqli_real_escape_string($link, $_POST['npk']));
  $nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
  $tgl_masuk = trim(mysqli_real_escape_string($link, $_POST['tgl_masuk']));
  $jabatan = trim(mysqli_real_escape_string($link, $_POST['jabatan'])); 
  $shift = trim(mysqli_real_escape_string($link, $_POST['shift']));
  $status = trim(mysqli_real_escape_string($link, $_POST['status']));

  $pos = trim(mysqli_real_escape_string($link, $_POST['pos']));
  //validasi inputan primary key yang sudah ada
  $cekvalidasi = mysqli_query($link, "SELECT * FROM karyawan WHERE npk='$npk'");
  if(mysqli_num_rows($cekvalidasi) > 0){
    echo "<script>alert('karayawan dengan NPK $npk sudah ada di dalam database!');window.location='addmp.php'</script>";

  }else{
  mysqli_query($link, "INSERT INTO karyawan (npk, nama_depan, nama, tgl_masuk, jabatan, shift, status, id_area) 
                                    VALUES ('$npk' , '$nick', '$nama' , '$tgl_masuk' , '$jabatan' , '$shift', '$status' , '$pos')") or die(mysqli_error($link));
  echo "<script>alert('karayawan dengan NPK $npk sudah ditambahkan!');window.location='manpower.php'</script>";
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