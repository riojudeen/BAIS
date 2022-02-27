<?php
include("../../config/config.php"); 
if(isset($_GET['data_sm'])){
    // echo $_GET['data_sm'];
    if($_GET['data_sm'] == 1){
        mysqli_query($link, "UPDATE system_lock SET `status` = '0' WHERE `type` = 'sm' ")or die(mysqli_error($link));
        echo "0";
    }else{
        mysqli_query($link, "UPDATE system_lock SET `status` = '1' WHERE `type` = 'sm' ")or die(mysqli_error($link));
        echo "1";
    }
}
if(isset($_GET['id_skema'])){
    // echo count($_GET['status']);
    for($i=0 ; $i < count($_GET['id_skema']) ; $i++){
        $id = $_GET['id_skema'][$i];
        $nama = $_GET['nama_skema'][$i];
        $start = $_GET['start_off'][$i];
        $end = $_GET['end_off'][$i];
        $type = $_GET['type_skema'][$i];
        $status = (isset($_GET['status-'.$i]))?"1":"0";

       $query = "UPDATE `system_lock` SET 
       `system_name`= '$nama',
       `status`= '$status' ,
       `off_start`= '$start',
       `off_end`= '$end'
       WHERE `id` = '$id'";

        mysqli_query($link, $query)or die(mysqli_error($link));
       
    }
}