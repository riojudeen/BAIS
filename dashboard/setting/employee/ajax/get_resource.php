<?php
$_POST['npk'] = $_GET['data'];
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
$npk = (isset($_POST['npk']))? $_POST['npk'] : "";
$sNpk = mysqli_query($link, "SELECT npk, nama, jabatan, `status` FROM karyawan WHERE npk = '$npk'")or die(mysqli_error($link));
$jNpk = mysqli_num_rows($sNpk);
$data = array();
$notifikasi = array();
if($jNpk > 0){    
    while($dataKary = mysqli_fetch_assoc($sNpk)){
        $q_expatriat = mysqli_query($link, "SELECT * FROM expatriat WHERE npk = '$dataKary[npk]' ")or die(mysqli_error($link));
        if(mysqli_num_rows($q_expatriat)>0){
            $notif = array(
                'total' => 0,
                'msg' => "data sudah ada",
            );
            array_push($notifikasi, $notif);
        }else{
            $notif = array(
                'total' => mysqli_num_rows($sNpk),
                'msg' => "data tersedia",
            );
            $array = array(
                'nama' => $dataKary['nama'],
                'jabatan' => $dataKary['jabatan'],
                'status' => $dataKary['status'],
            );
            $s_expatriat = mysqli_fetch_assoc($q_expatriat);
            array_push($notifikasi, $notif);
            array_push($data, $array);
        }
    }
    
}else if($_POST['npk'] == ""){
    $notif = array(
        'total' => "",
        'msg' => "",
    );
    array_push($notifikasi, $notif);
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