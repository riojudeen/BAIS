<?php
// echo "tes";
include("../../../config/config.php"); 
// $index = ($_GET['index'] != '' || $_GET['index'] != 'undefined')?$_GET['index']:0;
$index =  $_GET['index'];

$q_group = mysqli_query($link,"SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($link));
$jml_data = mysqli_num_rows($q_group);

$limit = $index;
// echo $limit;
if($limit > $jml_data){
    $limit = 0;
}
// echo $limit;
// echo $jml_data;
// echo "SELECT * FROM view_daftar_area WHERE part = 'group' LIMIT $limit,1";
$q_getGroup = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group' LIMIT $limit,1");
$total_data = mysqli_num_rows($q_getGroup);
// echo $total_data;

if($total_data>0){
    while($data_getGroup = mysqli_fetch_assoc($q_getGroup)){
        // echo $data_getGroup['nama_org'];
        ?>
        <div class="row">
            <div class="col md-12">
            <h5 id="data_index" class="d-none" data-id="<?=$limit?>"></h5>
        <h5 id="data_total" class="d-none" data-id="<?=$jml_data?>"></h5>
            </div>
        </div>
        
        <?php
    }
}
?>