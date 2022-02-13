<?php
require_once("../../../config/config.php"); 

$id_WD = $_POST['rowid'];
$sqlTanggal_ = mysqli_query($link, "SELECT * FROM working_days WHERE id = '$_POST[rowid]' ")or die(mysqli_error($link));
$dataTanggal_ = mysqli_fetch_assoc($sqlTanggal_);
$dataWH = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM working_hours WHERE id = '$dataTanggal_[wh]' "));
$dataSHF = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM shift WHERE id_shift = '$dataTanggal_[shift]' "));
    

?>
<div class="text-center ">
    <input type="hidden" name="id" class="form-control " placeholder="Enter email" value="<?=$id_WD?>">
    <label class="text-muted"><?=hari($dataTanggal_['date'])?></label>
    
    <p class="bold600 display-4 mb-1 card bg-light"><?=tgl($dataTanggal_['date'])?></p>
    <hr>
    <p class="bold600  mt-0"><?=$dataSHF['shift']." - ".$dataWH['code_name']?></p>

    <!-- <input type="text" name="date" class="form-control datepicker bold600 display-4" placeholder="Enter email" value=""> -->
    
    <hr>
    <label class="text-muted">Working Hours</label>
    <div class="">
    <span><p class="bold600 badge badge-pill badge-info col-3">in: <?=$dataWH['start']?></p></span>
    <span><i class="nc-icon nc-time-alarm  my-auto py-1"></i></span>
    <span><p class="bold600 badge badge-pill badge-info col-3">out: <?=$dataWH['end']?></p></span>
    
    
    </div>
    

    
</div>
