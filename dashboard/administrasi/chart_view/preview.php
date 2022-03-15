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


$color_masuk = ($data_['CODE'] == '' || $data_['CODE'] == 'TL')?'bg-success':'';
$color_ta = ($data_['CODE'] == 'M' )?'bg-danger':'';
$color_ijin = ($data_['CODE'] != '' || $data_['CODE'] != 'TL' || $data_['CODE'] != 'T1' &&  $data_['CODE'] != 'T2' && $data_['CODE'] != 'T3' )?"bg-info":'';
$color_telat = ($data_['CODE'] == 'T1' ||  $data_['CODE'] == 'T2' || $data_['CODE'] == 'T3')?"bg-warning":'';
$color = "bg-warning";
// echo getFoto($data);
?>
<div class="card card-user card-plain" >
   
    <div class="card-body " >
        <div class="author" >
            <a href="#">
                <img class="avatar border-gray" src="<?=getFoto($data)?>" alt="..." style="border-radius:100px">
                <h5 class="title text-uppercase"><?=$dataMp['nama']?></h5>
            </a>
            <p class="description">
            <?=$dataMp['npk']?></p>
        </div>
    </div>
    <label class="title text-center"><?=tgl($date)?></label>
    <div class="card-footer <?=$color_masuk?> <?=$color_ta?> <?=$color_ijin?> <?=$color_telat?> ">
        <div class="button-container ">
            <div class="row">
                
                <div class="col-lg-4 col-sm-12 col-md-4 ml-auto mr-auto text-white">
                    <h5><?=$check_in?><br><label class="label text-white">Check In</label></h5>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4 ml-auto mr-auto text-white">
                    <h5><?=$check_out?><br><label class="label text-white">Check Out</label></h5>
                </div>
                <div class="col-lg-4  col-sm-12 col-md-4  ml-auto mr-auto text-white">
                    <h5><?=$ket?><br><label class="label text-white">Ket</label></h5>
                </div>
            </div>
        </div>
    </div>
</div>