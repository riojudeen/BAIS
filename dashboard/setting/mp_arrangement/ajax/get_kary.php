<?php
$_POST['npk'] = $_GET['data'];
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
$npk = (isset($_POST['npk']))? $_POST['npk'] : "";
$sNpk = mysqli_query($link, "SELECT nama, jabatan, `status` FROM karyawan WHERE npk = '$npk'")or die(mysqli_error($link));
$jNpk = mysqli_num_rows($sNpk);
$data = array();
$notifikasi = array();
if($jNpk > 0){
    $notif = array(
        'total' => mysqli_num_rows($sNpk),
        'msg' => "data tersedia",
    );
    array_push($notifikasi, $notif);
    while($dataKary = mysqli_fetch_assoc($sNpk)){
        $array = array(
            'nama' => $dataKary['nama'],
            'jabatan' => $dataKary['jabatan'],
            'status' => $dataKary['status'],
        );
        array_push($data, $array);
    }
    
}else{
    $notif = array(
        'total' => mysqli_num_rows($sNpk),
        'msg' => "data tidak tersedia",
    );
    array_push($notifikasi, $notif);

}
$dataJSON = json_encode($data);
$stats = json_encode($notifikasi);
$output = "{\"data\":".$dataJSON.",\"msg\":".$stats."}";
echo $output;

?>