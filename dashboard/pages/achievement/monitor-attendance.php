<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h5>Attendance Ratio</h5>
            </div>
            <div class="col-md-12">
                <h5>Leave Schedule</h5>
            </div>
            <div class="col-md-12">
                <h5>Sick Monitoring</h5>
            </div>
            <div class="col-md-12">
                <h5>Late Monitoring</h5>
            </div>
            <div class="col-md-12">
                <h5>Late Monitoring</h5>
            </div>
        </div>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
