<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h5>Request Overview</h6>
            </div>
            <div class="col-md-12">
                <h6>Overtime</h6>
            </div>
            <div class="col-md-12">
                <h6>Leave & Permit</h6>
            </div>
            
        </div>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
