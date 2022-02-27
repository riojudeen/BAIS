<?php
require_once("../../../../config/config.php");
  
?>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" name="previewBrakShift" class="form-control" value="<?=$_GET['id']?>">
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-warning">
                            <th>#</th>
                            <th>Day / Night</th>
                            <th>Skema</th>
                            <th>Start</th>
                            <th>End</th>
                        </thead>
                        <tbody>
                        <?php
                        $queryBreak = mysqli_query($link, "SELECT working_break_shift.id_working_day_shift AS `shift`,
                            working_day_shift.name AS working_day,
                            working_break_shift.id_working_break AS `id_break`,
                            working_break_shift.effective_date AS `effective`,
                            working_break_shift.break_group_id AS `break_group`,
                            working_break.scheme_name AS `skema`,
                            working_break.start_time AS `start`,
                            working_break.end_time AS `end`
                            FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
                            LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
                            WHERE working_break_shift.break_group_id = '$_GET[id]'
                            ")or die(mysqli_error($link));
                            $no = 1;
                        while($data = mysqli_fetch_assoc($queryBreak)){
                            ?>
                            
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['working_day']?></td>
                                <td><?=$data['skema']?></td>
                                <td><?=$data['start']?></td>
                                <td><?=$data['end']?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div> 
</div>
<div class="modal-footer">
    <div class="col-md-12">
        
        <div class="row">
            <div class="col-md-6">
                <a href="workingbreak/editbreakshift.php?edit=<?=$_GET['id']?>" class="btn btn-info btn-link">Edit</a>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-info btn-link" name="delBreakShift">Delete</button>
            </div>
        </div>

    </div>
</div>
<script src="<?=base_url('assets/js/plugins/bootstrap-selectpicker.js')?>"></script>