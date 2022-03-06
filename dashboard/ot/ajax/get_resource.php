<?php
$_POST['npk'] =$_GET['data'];
//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");

if($level >=1 && $level <=8){
    require_once("../../../config/approval_system.php");
    
    
    // echo $deptAcc_filter;
    $shift = '';
    // echo $shift;
    $cari = '';
    $npk = $npkUser;
    list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
    // echo $npk.$sub_post.$post.$group.$sect.$dept.$dept_account.$div.$plant;
    

    $origin_query = "SELECT 
        view_organization.npk,
        view_organization.nama,
        view_organization.tgl_masuk,
        view_organization.jabatan,
        view_organization.shift,
        view_organization.pos,
        view_organization.status,
        view_organization.pos,
        view_organization.groupfrm,
        view_organization.section,
        view_organization.dept,
        view_organization.subpos,
        view_organization.division,
        view_organization.dept_account
        
        FROM view_organization ";
    $access_org = orgAccessOrg($level);
    $data_access = generateAccess($link,$level,$npk);
    // echo $data_access;
    $table = partAccess($level, "table");
    $field_request = partAccess($level, "field_request");
    $table_field1 = partAccess($level, "table_field1");
    $table_field2 = partAccess($level, "table_field2");
    $part = partAccess($level, "part");
    $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
    
    // echo $generate ;

    $npk_cari = (isset($_POST['npk']))? $_POST['npk'] : "";
    // echo 
    $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND npk = '$npk_cari'";
    $sNpk = mysqli_query($link, $queryMP)or die(mysqli_error($link));
    // echo $queryMP;
    $jNpk = mysqli_num_rows($sNpk);
    $data = array();
    $notifikasi = array();
    if(mysqli_num_rows($sNpk)>0){
        while($dataKary= mysqli_fetch_assoc($sNpk)){
            $notif = array(
                'total' => mysqli_num_rows($sNpk),
                'msg' => "data tersedia",
            );
            $array = array(
                'nama' => $dataKary['nama'],
                'jabatan' => $dataKary['jabatan'],
                'status' => $dataKary['status'],
            );
            array_push($notifikasi, $notif);
            array_push($data, $array);
            
        }
    }else if($_POST['npk'] == ""){
        $notif = array(
            'total' => mysqli_num_rows($sNpk),
            'msg' => "data tidak tersedia",
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
}

?>