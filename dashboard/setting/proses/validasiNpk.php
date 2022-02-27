<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
$npk = (isset($_POST['npk']))? $_POST['npk'] : "";
$sNpk = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$npk'");
$jNpk = mysqli_num_rows($sNpk);
$hNpk = mysqli_fetch_assoc($sNpk);
$data = array(
    'jumlah' => $jNpk ,
    'nama' => $hNpk['nama']
);

echo json_encode($data['jumlah']);

?>