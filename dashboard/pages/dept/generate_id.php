<?php
include("../../../config/config.php"); 

$nama_dept = $_POST['dept-1'];
$nama = explode(" ", $nama_dept);
$kode_nama = substr($nama['0'],0,3);

$sql_dept = mysqli_query($link, "SELECT max(id_dept) as kodeTerbesar FROM department") or die(mysqli_error($link));
$data = mysqli_fetch_array($sql_dept);
$kode_dept = $data['kodeTerbesar'];
$urutan = (int) substr($kode_dept, 3, 3);
$urutan++;

$huruf = "DEPT-";
$kode_dept = $huruf . $kode_nama . sprintf("%03s", $urutan);

echo "<input type=\"text\" class=\"form-control\" value=\"$kode_dept\" name=\"id-1\" maxlength=\"5\" id=\"kode\" required>";
                                      
?>