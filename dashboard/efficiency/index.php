<?php 

//////////////////////////////////////////////////////////////////////
include("../../config/config.php");
include("../../config/cost/date.php");
include("../../config/cost/otDL.php"); 
include("../../config/cost/otIDL.php");
include("../../config/cost/index.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Labour Cost Body 1";
if(isset($_SESSION['user'])){
    include_once("../header.php");
    // echo bln($tanggalAwal);

    ?>
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="card card-pain">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                <h4 class="card-title">
                Efficiency Man Power
                </h4>
                <p class="card-category">
                    Agustus 2020
                </p>
                </div>
                <div class="col-sm-7">
                    <div class="pull-right">
                        <span class="badge badge-pill badge-success">
                        std 95%
                        </span>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-body">
                    <!-- <h6 class="big-title">Efficiency Man Power</h6> -->
                    <canvas id="eff_dept" width="826" height="200"></canvas>
                   
            
            
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                    <div class="footer-title">
                        <form action="" method="get">
                            <select class="selectpicker" data-size="7" name="start" data-style="btn btn-outline-default text-default btn-sm btn-round" title="Month">
                                <option disabled>Select Month</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <select class="selectpicker" data-size="7" name="start" data-style="btn btn-outline-default text-default btn-sm btn-round" title="Department" multiple>
                                <option disabled>Select Department</option>
                                <option value="01">BODY 1</option>
                                <option value="02">BODY 2</option>
                                <option value="03">BQC</option>
                                
                            </select>
                            <button type="submit" class="btn btn-danger btn-round btn-icon btn-sm btn-outline-default text-default">
                                <i class="nc-icon nc-zoom-split"></i>
                            </button>
                        </form>
                        
                    </div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <button class="btn btn-danger btn-round btn-icon btn-sm">
                    <i class="nc-icon nc-simple-add"></i>
                    </button>
                    <button class="btn btn-warning btn-round btn-icon btn-sm">
                    <i class="nc-icon nc-simple-add"></i>
                    </button>
                    <button class="btn btn-success btn-round btn-icon btn-sm">
                    <i class="nc-icon nc-simple-add"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Total MP</h5>
            <p class="card-category">August 2021</p>
        </div>
        <div class="card-body ">
            <canvas id="totalmp" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas>
        </div>
        <div class="card-footer ">
            <div class="legend">
            <i class="fa fa-circle text-primary"></i> Open
            </div>
            <hr>
            <div class="stats">
            <i class="fa fa-calendar"></i> Number of emails sent
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">MP Masuk</h5>
            <p class="card-category">August 2021</p>
        </div>
        <div class="card-body ">
            <canvas id="masuk" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas>
        </div>
        <div class="card-footer ">
            <div class="legend">
            <i class="fa fa-circle text-primary"></i> Open
            </div>
            <hr>
            <div class="stats">
            <i class="fa fa-calendar"></i> Number of emails sent
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title">Ijin</h5>
                <p class="card-category">August 2021</p>
            </div>
            <div class="card-body ">
                <canvas id="ijin" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas>
            </div>
            <div class="card-footer ">
                <div class="legend">
                <i class="fa fa-circle text-primary"></i> Open
                </div>
                <hr>
                <div class="stats">
                <i class="fa fa-calendar"></i> Number of emails sent
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Sakit</h5>
            <p class="card-category">August 2021</p>
        </div>
        <div class="card-body ">
            <canvas id="sakit" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas>
        </div>
        <div class="card-footer ">
            <div class="legend">
            <i class="fa fa-circle text-primary"></i> Open
            </div>
            <hr>
            <div class="stats">
            <i class="fa fa-calendar"></i> Number of emails sent
            </div>
        </div>
        </div>
    </div>
</div>


    <?php
    include_once("../footer.php"); 
    include_once("../endbody.php");

    include_once("../chart/eff.php");
    include_once("../chart/totalmp.php");
///jika tidak ada session maka akan diarahkan ke ahalam login
} else{
  echo "<script>window.location='".base_url('../auth/login.php')."';</script>";
}

?>