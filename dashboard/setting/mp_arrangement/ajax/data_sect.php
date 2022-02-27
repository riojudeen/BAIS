<?php
$id = $_GET['id'];
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
$q_org = "SELECT section.section AS `nama_section`,
section.id_section AS `id_section`,
department.dept AS `nama_dept`,
department.id_dept AS `id_dept`,
division.id_div AS `id_div`,
division.nama_divisi AS `nama_div`
FROM section JOIN department ON department.id_dept = section.id_dept
JOIN division ON division.id_div = department.id_div WHERE section.id_section = '$id'
";
$data = array();
$notifikasi = array();
$s_org = mysqli_query($link,$q_org)or die(mysqli_error($link));
$jml = mysqli_num_rows($s_org);
if($jml>0){
    $notif = array(
        'total' => mysqli_num_rows($s_org),
        'msg' => "data tersedia",
    );
    array_push($notifikasi, $notif);
    while($dataOrg = mysqli_fetch_assoc($s_org)){
        $array = array(
            'nama_sect' => $dataOrg['nama_section'],
            'nama_dept' => $dataOrg['nama_dept'],
            'nama_div' => $dataOrg['nama_div'],
            'id_sect' => $dataOrg['id_section'],
            'id_dept' => $dataOrg['id_dept'],
            'id_div' => $dataOrg['id_div'],
        );
        array_push($data, $array);
    }
}else{
    $notif = array(
        'total' => mysqli_num_rows($s_org),
        'msg' => "data tidak tersedia",
    );
    array_push($notifikasi, $notif);

}
$dataJSON = json_encode($data);
$stats = json_encode($notifikasi);
$output = "{\"data\":".$dataJSON.",\"msg\":".$stats."}";
echo $output;
?>
