<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Salary Rate</h6>
            </div>
            <div class="col-md-12">
                <h5>Production Result</h5>
            </div>
            <div class="col-md-12">
                <h5>Cost Achievement</h5>
            </div>
            
        </div>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
