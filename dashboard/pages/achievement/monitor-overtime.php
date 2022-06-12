<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $mulai = $_GET['start'] ;
        $selesai = $_GET['end'] ;
        $today = date('Y-m-d');
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <h6>Working Days</h6>
            </div>
            <div class="col-md-12 " >
                <div class="table-striped border " style="border:2px ; border-radius:15px">
                    <table class="table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Operational</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                            $query_wd = mysqli_query($link, 
                            "SELECT
                            `working_days`.`id` AS `id`,
                            `working_days`.`date` AS `date`,
                            `working_days`.`shift` AS `shift`,
                            `working_days`.`ket` AS `operational`,
                            `working_hours`.`start` AS `start_working`,
                            `working_hours`.`end` AS `end_working`,
                            `working_day_shift`.`name` AS `working_day_shift`,
                            IF(
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`end`,
                                        `working_hours`.`start`
                                    )
                                ) / 60 < 0,
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`start`,
                                        `working_hours`.`end`
                                    )
                                ) / 60,
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`end`,
                                        `working_hours`.`start`
                                    )
                                ) / 60
                            ) AS `working_minutes`
                            FROM `working_days` 
                            JOIN `working_hours` ON `working_hours`.`id` = `working_days`.`wh`
                            LEFT JOIN `working_day_shift` ON `working_day_shift`.`id` = `working_hours`.`code_name`
                            WHERE working_days.date BETWEEN '$today' AND '$today' "
                            )or die(mysqli_error($link));
                            if(mysqli_num_rows($query_wd) > 0){
                                while($data = mysqli_fetch_assoc($query_wd)){
                                    $wd = ($data['operational'] == 'HOP')?'Holiday Operational':'Daily Operational';
                                    ?>
                                    <tr>
                                        <td><?=$data['shift']?></td>
                                        <td><?=$wd?></td>
                                        <td><?=jam($data['start_working'])?></td>
                                        <td><?=jam($data['end_working'])?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h5>Overtime in Minutes</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>Non Production Overtime</h6>
            </div>
        </div>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
