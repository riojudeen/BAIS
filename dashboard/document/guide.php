<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "User Guide";
if(isset($_SESSION['user'])){

    include("../header.php");
    echo getFoto($npkUser);
    
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h5 class="title">Manual</h5>
                </div>
                <hr>
                <div class="card-body mx-0 px-0">
                    <iframe src=""  style="width:100%;height:500px" ></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php
//footer
    include_once("../footer.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
	

?>