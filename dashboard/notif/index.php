<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    if($level == 4){
        $prog = "25a";
    }else if($level > 5 ){
        $prog = "50a";
    }
    $_GET['prog'] = '';

        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        // echo $start;
        $filter = '';
        $div_filter = '';
        // echo $div;
        $dept_filter = '';
        // echo $dept_filter;
        $sect_filter = '';
        // echo $sect_filter;
        $group_filter = '';
        // echo $group_filter;
        $deptAcc_filter = '';
        // echo $deptAcc_filter;
        $shift = '';
        // echo $shift;
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        // echo $cari;
        $level = $level;
        $npk = $npkUser;

        // $query = "SELECT "
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_req_ot.id_ot,
            view_req_ot.npk
            
            FROM view_req_ot ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        $filter = " AND CONCAT(view_req_ot.status_approve, view_req_ot.status_progress) = '$prog' ";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$filter;
        // absensi data
        $origin_query_at = "SELECT view_absen_req.id_absensi,
            view_absen_req.npk
            FROM view_absen_req ";
       
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter_at = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$prog'
            AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' 
            AND req_date IS NOT NULL  AND shift_req = '0' ";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query_at, $access_org).$add_filter_at.$exception;

        // informasi
        $query_info = "SELECT info FROM info WHERE (category = 'ext' 
            OR category = 'int' 
            OR category = 'mtc' 
            OR category = 'oth' ) AND `stats` = '1' AND ((date_start BETWEEN '$start' AND '$end') OR (date_end BETWEEN '$start' AND '$end'))";
        $sql_info = mysqli_query($link, $query_info)or die(mysqli_error($link));
        
        $jml_info = mysqli_num_rows($sql_info);
        $sql_at = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
        $jml_at = mysqli_num_rows($sql_at);
        $sql_ot = mysqli_query($link, $query_req_overtime)or die(mysqli_error($link));
        $jml_ot = mysqli_num_rows($sql_ot);
        $total_info = $jml_at+$jml_ot+$jml_info;
        $data = array();
        $notifikasi = array();

        $notif = array(
            'jml' => $total_info,
        );
        $array = array(
            'ot' => $jml_ot,
            'at' => $jml_at,
            'info' => $jml_info,
            
        );
        array_push($notifikasi, $notif);
        array_push($data, $array);


        $dataJSON = json_encode($data);
        $stats = json_encode($notifikasi);
        $output = "{\"data\":".$dataJSON.",\"msg\":".$stats."}";
        echo $output;
} else{
    header('location:../../auth/login.php');
}
  

?>