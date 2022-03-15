<?php
include("../../../config/config.php"); 
$data = $_GET['data'];
$date = dateToDB($_GET['date']);
$queryMP = "SELECT nama, npk FROM view_organization WHERE npk = '$data'";
$query = "SELECT nama, npk, work_date, check_in, check_out , CODE FROM view_absen_hr WHERE npk = '$data' AND work_date = '$date' ";
$sql = mysqli_query($link, $query)or die(mysqli_error($link));
$sqlMp = mysqli_query($link, $queryMP)or die(mysqli_error($link));
$data_ = mysqli_fetch_assoc($sql);
$dataMp = mysqli_fetch_assoc($sqlMp);
$check_in = (isset($data_['check_in'])&&($data_['check_in'] != '' OR $data_['check_in'] != '00:00:00'))?jam($data_['check_in']):'-';
$check_out = (isset($data_['check_out'])&&($data_['check_out'] != '' OR $data_['check_out'] != '00:00:00'))?jam($data_['check_out']):'-';
$ket = (isset($data_['CODE'])&&$data_['CODE'] != '')?$data_['CODE']:'-';
?>
<div class="card card-user card-plain" >
   
    <div class="card-body" >
        <div class="author" >
            <a href="#">
                <img class="avatar border-gray" src="/BAIS/assets/img/img/tm.png" alt="..." style="border-radius:100px">
                <h5 class="title text-uppercase"><?=$dataMp['nama']?></h5>
            </a>
            <p class="description">
            <?=$dataMp['npk']?></p>
        </div>
    </div>
    <div class="card-footer">
        <hr>
        <div class="button-container">
            <div class="row">
                <div class="col-md-12">
                    <label class="label"><?=tgl($date)?></label>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4 ml-auto mr-auto">
                    <h5><?=$check_in?><br><label class="label">Check In</label></h5>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4 ml-auto mr-auto">
                    <h5><?=$check_out?><br><label class="label">Check Out</label></h5>
                </div>
                <div class="col-lg-4  col-sm-12 col-md-4  ml-auto mr-auto">
                    <h5><?=$ket?><br><label class="label">Ket</label></h5>
                </div>
            </div>
        </div>
    </div>
</div>