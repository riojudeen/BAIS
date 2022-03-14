<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
$shift = $_GET['shift'];
$work_date = $_GET['work_date'];
$type = $_GET['type'];


if($shift != '' && $work_date != '' && $type != ''){
    list($tglini, $sesudah, $start_time, $end_time, $ket, $wb) = whwithket($link, $shift, $work_date);
    // echo $start_time;
    // echo $end_time;
    if($type == "PO"){
        if($ket == "DOP"){
            $disabled_time_start = 'readonly';
            $disabled_time_end = '';
        }else{
            $disabled_time_start = '';
            $disabled_time_end = '';
        }
        $start_date = $sesudah;
        $end_date = $sesudah;
        $start_time = $end_time;
        $end_time = '00:00';

    //     echo $start_time;
    // echo $end_time;
        
    }else if($type == "EO"){
        if($ket == "DOP"){
            $disabled_time_start = '';
            $disabled_time_end = 'readonly';
        }else{
            $disabled_time_start = '';
            $disabled_time_end = '';
        }
        $start_date = $tglini;
        $end_date = $tglini;
        $end_time = $start_time;
        $start_time = '00:00';
    //     echo $start_time;
    // echo $end_time;
    }
    $sidabled_date = 'readonly';
    
?>
<div class="row">                          
    <div class="col-md-3 pr-1">
        <div class="form-group">
            <label for="">Tanggal Mulai</label>
            
            <input type="date" name="tanggal_mulai" <?=$sidabled_date?> value="<?=$start_date?>" class="form-control no-border" id="date_in_ot" required>
        </div>
    </div>
    <div class="col-md-3 pls-1">
        <div class="form-group">
            <label for="">Waktu Mulai</label>
            <input type="time" <?=$disabled_time_start?> name="waktu_mulai" value="<?=jam($start_time)?>" class="form-control no-border" id="start_time" required>
        </div>
    </div>
    <div class="col-md-3 pr-1">
        <div class="form-group">
            <label for="">Tanggal Selesai</label>
            <input type="date"   name="tanggal_selesai" <?=$sidabled_date?> value="<?=$end_date?>" class=" form-control no-border" id="date_out_ot" required>
        </div>
    </div>
    <div class="col-md-3 pl-1">
        <div class="form-group">
            <label for="">Waktu Selesai</label>
            <input type="time" <?=$disabled_time_end?> name="waktu_selesai" value="<?=jam($end_time)?>" class="form-control no-border" id="end_time" required>
        </div>
    </div>
    
</div>
<div class="row">
    
    <div class="col-md-5  ">
        <label for="">Jenis Activity</label>
        <div class="input-group">
            <select name="ot_code" class="form-control no-border" id="ot_code" required>
                <option value="" disabled>Kode Overtime</option>
                <?php
                
                    $query = mysqli_query($link, "SELECT * FROM kode_lembur")or die(mysqli_error($link));
                    if(mysqli_num_rows($query)){
                        while($data=mysqli_fetch_assoc($query)){
                            ?>
                            <option value="<?=$data['kode_lembur']?>"><?=$data['nama']?></option>
                            <?php
                        }
                    }
                ?>
            </select>
            <div class="input-group-append">
                <span class="input-group-text px-2 py-0" id="ot_code_display">
                    Kode
                </span>
            </div>
        </div>
    </div>
</div>
<div class="collapse show" id="collapsePlot">
    <div class="row ">
        <div class="col-md-12">
            <label for="">Input NPK karyawan</label>
            <div class="form-group">
                <textarea class="form-control " name="" id="text_input" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>
<button type="reset" class="btn btn-sm btn-warning reset">Reset</button>
<button type="submit" class="btn btn-sm btn-info float-right" id="inputActivity">Input Activity</button>
<!-- <button type="button" class="btn btn-sm btn-info " data-toggle="collapse" data-target="#collapsePlot" aria-expanded="false" aria-controls="collapsePlot">Add Request</button> -->

<div class="row">
    <div class="col-md-12">
        <div class="notification"></div>
    </div>
</div>
<?php
}