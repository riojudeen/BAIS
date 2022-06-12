<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Overtime Rate</h6>
            </div>
            <div class="col-md-12">
                <h5>Working Days</h5>
            </div>
            <div class="col-md-12">
                <h5>Production Effeciency</h5>
            </div>
            <div class="col-md-12">
                <h5>Overtime in Minutes</h5>
            </div>
            <div class="col-md-12">
                <h6>Production Overtime</h6>
            </div>
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
