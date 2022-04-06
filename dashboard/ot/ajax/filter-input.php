<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
$shift = $_GET['shift'];
$work_date = $_GET['work_date'];
$type = $_GET['type'];


if($shift != '' && $work_date != '' && $type != ''){
    list($tglini, $sesudah, $start_time, $end_time, $ket, $wb) = whwithket($link, $shift, $work_date);
    // echo $wb;
    $qry_wb = "SELECT working_break_shift.id_working_break , working_break.start_time, working_break.end_time FROM working_break_shift JOIN working_break ON working_break_shift.id_working_break = working_break.id  WHERE working_break_shift.break_group_id = '$wb' ORDER BY start_time ASC ";
    $sql_wb = mysqli_query($link, $qry_wb)or die(mysqli_error($link));
    $array_wb_start = array();
    $array_wb_end = array();
    if(mysqli_num_rows($sql_wb)>0){
        // echo mysqli_num_rows($sql_wb);
        while($data_wb = mysqli_fetch_assoc($sql_wb)){
            array_push($array_wb_start, $data_wb['start_time']);
            array_push($array_wb_end , $data_wb['end_time']);
        }
    }
    // print_r($array_wb_end);
    
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
    // echo $_GET['count'];
  
      
    ?>
    <div class="row">
        
        <div class="col-md-3 pr-1">
            <div class="form-group">
                <label for="">Tanggal Mulai</label>
               
                <input type="date" name="tanggal_mulai" <?=$sidabled_date?> value="<?=$start_date?>" class="form-control no-border" id="date_in_ot" required>
            </div>
        </div>
        <p class="col-md-1 pt-4 mt-2 text-center text-muted ">
            <i class="fas fa-arrow-right"></i>
        </p>
        <div class="col-md-3 pr-1">
            <div class="form-group">
                <label for="">Tanggal Selesai</label>
                <input type="date"   name="tanggal_selesai" <?=$sidabled_date?> value="<?=$end_date?>" class=" form-control no-border" id="date_out_ot" required>
            </div>
        </div>
        <div class="col-md-5">
            <label for="">Production Overtime</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input checked class="form-check-input all" type="checkbox" name="prodcek" id="prodcek" value="1">
                    <span class="form-check-sign">centang / check jika menyertakan overtime produksi</span>
                </label>
            </div>

        </div>
    </div>
    <?php
for($i=1 ; $i <= $_GET['count']; $i++){
    
    ?>
    <div class="row"> 
        
        <div class="col-md-3 pr-1">
            <div class="form-group">
                <label for="">Waktu Mulai</label>
                <?php
                    if($type == 'EO'){
                        if($i == $_GET['count']){
                            $disabled_start = $disabled_time_start;
                            $disabled_end = $disabled_time_end;
                        }else{
                            $disabled_start = '';
                            $disabled_end = '';
                        }
                        
                    }else if($type == 'PO'){
                        if($i == 1){
                            $array_search_start = array_search($start_time, $array_wb_start);
                            // echo $array_search_start;
                            if($array_search_start != ''){
                                $array_search_end = array_search($end_time, $array_wb_end);
                                $start_time = $array_wb_end[$array_search_start];
                               
                            }
                            $disabled_start = $disabled_time_start;
                            $disabled_end = $disabled_time_end;
                        }else{
                            $disabled_start = '';
                            $disabled_end = '';
                        }
                    }
                    // echo $start_time;
                ?>

                <input type="time" <?=$disabled_start?> name="waktu_mulai<?=$i?>" data-date-format="hh:mm" value="<?=jam($start_time)?>" data-id="<?=$i?>" class="form-control no-border start_time datepicker" id="start_time<?=$i?>" required>
            </div>
        </div>
        <p class="col-md-1 pt-4 mt-2 text-center text-muted ">
            <i class="fas fa-arrow-right"></i>
        </p>
        <div class="col-md-3 pr-1">
            <div class="form-group">
                <label for="">Waktu Selesai <?=$_GET['count']?> <?=$i?></label>
                <input type="time" <?=$disabled_end?> name="waktu_selesai<?=$i?>" value="<?=jam($end_time)?>" data-id="<?=$i?>" class="form-control no-border end_time" id="end_time<?=$i?>" required>
            </div>
        </div>
        <div class="col-md-5 pr-4">
            <label for="">Jenis Activity</label>
            <div class="row">
                <div class="col-md-12">

                    <div class="input-group">
                        <?php
                        if($i == 1){
                            $readOnly_code = "d-none";
                         }else{
                            $readOnly_code = "";
                         }
                        ?>
                        <select data-id="<?=$i?>" name="ot_code" class="form-control no-border overtime_code <?=$readOnly_code?> ot_code<?=$i?>" id="ot_code<?=$i?>" >
                            <option value="" >Kode Overtime</option>
                            <?php
                            
                                $query = mysqli_query($link, "SELECT * FROM kode_lembur")or die(mysqli_error($link));
                                $a = 1;
                                if(mysqli_num_rows($query) > 0){
                                    while($data=mysqli_fetch_assoc($query)){
                                        if($data['kode_lembur'] == "PROD" && $i == 1){
                                            $selected = "selected";
                                            $readOnly = "readonly";
                                         }else{
                                            $selected = "";
                                            $readOnly = "";
                                         }
                                        ?>
                                        <option  <?=$selected?> value="<?=$data['kode_lembur']?>"><?=$data['nama']?></option>
                                        <?php
                                    }
                                    $a++;
                                }
                            ?>
                        </select>
                        <div class="input-group-append ot_code<?=$i?> <?=$readOnly_code?> " >
                            <span class="input-group-text px-2 py-0 " id="ot_code_display<?=$i?>">
                                Kode
                            </span>
                            
                        </div>
                        <?php
                        if($i == 1){
                            ?>
                            <div class="form-group">

                                <input type="text"  class="form-control cd_ot " value="PRODUKSI" readonly>
                            </div>
                            <?php
                        }
                        ?>
                        
                        
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-6 text-right">
            
        </div>
    </div>
    <?php

}  
    ?>
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
?>
<script>
    $(document).ready(function(){
        function paddy(num, padlen, padchar) {
            var pad_char = typeof padchar !== 'undefined' ? padchar : '0';
            var pad = new Array(1 + padlen).join(pad_char);
            return (pad + num).slice(-pad.length);
        }
        function getIndex_End(index){
            var start_val = $('#start_time'+index).val();
            var start = Number($('#start_time'+index).attr('data-id'));
            var explode = start_val.split(':');
            var jam = Number(explode[0]);
            var menit = Number(explode[1]);
            if(menit-1 < 0){
                var jam_str = paddy(jam-1, 2);
                var menit_str = paddy(60-1, 2);
            }else{
                var jam_str = paddy(jam, 2);
                var menit_str = paddy(menit-1, 2);
            }
            
            var before_end_val = jam_str+':'+menit_str
            var before_end = start-1;
            if(before_end >= 0){
                // console.log(before_end_val);
                
                $('#end_time'+before_end).val(before_end_val)
                // console.log(start_val);
            }
        }
        function getIndex_Start(index){
            var end_val = $('#end_time'+index).val();
            var end = Number($('#end_time'+index).attr('data-id'));
            var next_start = end+1;
            
            var explode = end_val.split(':');
            var jam = Number(explode[0]);
            var menit = Number(explode[1]);
            if(menit+1 > 60){
                var jam_str = paddy(jam+1, 2);
                var menit_str = paddy(0+1, 2);
            }else{
                var jam_str = paddy(jam, 2);
                var menit_str = paddy(menit+1, 2);
            }
            
            var next_start_val = jam_str+':'+menit_str

            if(next_start >= 0){
                $('#start_time'+next_start).val(next_start_val)
                // console.log(menit_str);
            }
        }
        $('.start_time').on('blur', function(){
            var index = $(this).attr('data-id')
            console.log(index);
            getIndex_End(index)
        })
        $('.end_time').on('blur', function(){
            var index = $(this).attr('data-id')
            console.log(index);
            getIndex_Start(index)
        })
        $('#prodcek').on('click', function(){
            var val = $(this).prop('checked');
            if(val == false){
                $('.ot_code1').removeClass('d-none');
                $('.cd_ot').addClass('d-none');
            }else{
                $('.ot_code1').addClass('d-none');
                $('.cd_ot').removeClass('d-none');
            }
            // console.log(val)
        })
    })
</script>