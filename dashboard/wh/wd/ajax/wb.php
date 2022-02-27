<?php
require_once("../../../../config/config.php");
?>
<div class="table-striped">
    <table class="table">
        <thead class="table-info">
            <th colspan="2">Waktu Istirahat</th>
            <th>Start</th>
            <th>End</th>
        </thead>
        <tbody>
            <?php
            $queryWb = mysqli_query($link, "SELECT working_break_shift.id_working_day_shift AS `shift`,
            working_day_shift.name AS working_day,
            working_break_shift.id_working_break AS `id_break`,
            working_break_shift.effective_date AS `effective`,
            working_break_shift.break_group_id AS `break_group`,
            working_break.scheme_name AS `skema`,
            working_break.start_time AS `start`,
            working_break.end_time AS `end`
            FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
            LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
            WHERE working_break_shift.break_group_id =  '$_GET[wb]' ")or die(mysqli_error($link));
            if(mysqli_num_rows($queryWb)>0){
                while($dataWb = mysqli_fetch_assoc($queryWb)){
                    ?>
                    <tr>
                        <td><?=$dataWb['working_day']?></td>
                        <td><?=$dataWb['skema']?></td>
                        <td><?=$dataWb['start']?></td>
                        <td><?=$dataWb['end']?></td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="4">Belum Ada Data</td>
                </tr>
                <?php
            }
            ?>
            
        </tbody>
    </table>
</div>
