<?php
require_once("../../../../config/config.php");
$sqlWd = mysqli_query($link, "SELECT working_days.date AS `date`,
        working_days.shift AS `shift`,
        working_days.id AS `id`,
        working_days.ket AS `operational`,
        working_days.break_id AS `break_group`,
        working_hours.code_name AS `code_name`,
        working_hours.start AS `start_time`,
        working_hours.end AS `end_time`, 
        working_hours.ket AS `ket`,
        working_day_shift.name AS `name`
        FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh
        LEFT JOIN working_day_shift ON working_hours.code_name = working_day_shift.id
        WHERE working_days.id = '$_GET[id]'")or die(mysqli_error($link));
$data = mysqli_fetch_assoc($sqlWd)    
?>
<div class="row">
    <div class="col-md-3">
        <label for="">Hari Kerja</label>
        <div class="form-group-sm">
            <input type="hidden" name="workday" class="form-control" value="<?=$data['id']?>">
            <input readonly type="text" class=" form-control datepicker" value="<?=hari($data['date']).", ".tgl($data['date'])?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group-sm">
            <label for="">Operational</label>
            <input readonly type="text" class=" form-control datepicker" value="<?=$data['operational']?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group-sm">
            <label for="">Shift</label>
            <input readonly type="text" class=" form-control datepicker" value="<?=$data['code_name']?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group-sm">
            <label for="">Day/Night</label>
            <input readonly type="text" class=" form-control datepicker" value="<?=$data['code_name']?>">
        </div>
    </div>
    <hr>
    <div class="col-md-6 mt-1 mb-0">
        <div class="form-group-sm mt-0">
            <label for=""><span><i class="nc-icon nc-time-alarm  my-auto py-1"></i></span> Check In</label>
            <input readonly type="text" class=" form-control datepicker" value="<?=$data['start_time']?>">
        </div>
    </div>
    <div class="col-md-6 mt-1 mb-0">
        <div class="form-group-sm mt-0">
            <label for=""><span><i class="nc-icon nc-time-alarm  my-auto py-1"></i></span> Check Out</label>
            <input readonly type="text" class=" form-control datepicker" value="<?=$data['end_time']?>">
        </div>
    </div>
    
</div>
<hr>
<div class="row">
    <h6 class="col-md-12">Waktu Isirahat</h6>
    <div class="table-responsive col-md-12">
        <table class="table">
            <thead class="table-info">
                <th>#</th>
                <th>Skema</th>
                <th>Start time</th>
                <th>End time</th>
            </thead>
            <tbody>
            <?php
            $query_istirahat = mysqli_query($link,"SELECT working_break_shift.break_group_id AS 'break_group',
            working_break.scheme_name AS 'skema',
            working_break.start_time AS 'start_time',
            working_break.end_time AS 'end_time'

            FROM working_break_shift 
            JOIN working_break ON working_break_shift.id_working_break = working_break.id
            WHERE working_break_shift.break_group_id = '$data[break_group]'")or die(mysqli_error($link));
            if(mysqli_num_rows($query_istirahat)){
                $no = 1;
                while($dataIstirahat = mysqli_fetch_assoc($query_istirahat)){
                ?>
                <tr>
                    <td>
                        <?=$no++?>
                    </td>
                    <td>
                        <?=$dataIstirahat['skema']?>
                    </td>
                    <td>
                        <?=$dataIstirahat['start_time']?>
                    </td>
                    <td>
                        <?=$dataIstirahat['end_time']?>
                    </td>
                </tr>
            
            <?php
            }
        }else{
            ?>
            <tr>
                <td colspan="4" class="text-center text-uppercase">Belum Ada Data Seting</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
