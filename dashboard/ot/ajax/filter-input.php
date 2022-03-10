<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
?>
<div class="row">                          
    <div class="col-md-3 pr-1">
        <div class="form-group">
            <label for="">Tanggal Mulai</label>
            <?php
            $hari_ini = date('Y-m-d');
            ?>
            <input type="date" name="tanggal_mulai" value="<?=$hari_ini?>" class="form-control no-border" id="date_in_ot" required>
        </div>
    </div>
    <div class="col-md-3 pls-1">
        <div class="form-group">
            <label for="">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" value="" class="form-control no-border" id="start_time" required>
        </div>
    </div>
    <div class="col-md-3 pr-1">
        <div class="form-group">
            <label for="">Tanggal Selesai</label>
            <?php
            $hari_ini = date('Y-m-d');
            ?>
            <input type="date" name="tanggal_selesai" value="<?=$hari_ini?>" class=" form-control no-border" id="date_out_ot" required>
        </div>
    </div>
    <div class="col-md-3 pl-1">
        <div class="form-group">
            <label for="">Waktu Selesai</label>
            <input type="time" name="waktu_selesai" value="" class="form-control no-border" id="end_time" required>
        </div>
    </div>
    
</div>
<div class="row">
    
    <div class="col-md-5  ">
        <label for="">Jenis Activity</label>
        <div class="input-group">
            <select name="ot_code" class="form-control no-border" id="ot_code" required>
                <option value="">Kode Overtime</option>
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
    <div class="col-md-7  pl-1">
        <label for="">Activity</label>
        <div class="form-group">
            <input type="text" name="ot_activity" id="ot_activity" class="form-control" >
            
        </div>
    </div>
</div>
<div class="collapse " id="collapsePlot">
    <div class="row ">
        <div class="col-md-12">
            <label for="">Input NPK</label>
            <div class="form-group">
                <textarea class="form-control " name="" id="text_input" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>
<button type="reset" class="btn btn-sm btn-warning reset">Reset</button>
<button type="button" class="btn btn-sm btn-info " data-toggle="modal" data-target="#modal_input_npk" aria-expanded="false" aria-controls="add_input_npk">Input Data Karyawan</button>
<button type="button" class="btn btn-sm btn-info " data-toggle="collapse" data-target="#collapsePlot" aria-expanded="false" aria-controls="collapsePlot">Add Request</button>
<button type="submit" name="add_request" disabled id="prosesrequest"  class=" btn btn-sm btn-primary load-data pull-right" >Proses</button>
<div class="row">
    <div class="col-md-12">
        <div class="notification"></div>
    </div>
</div>