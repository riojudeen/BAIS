<?php 
//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Labour Cost Body 2";
if(isset($_SESSION['user'])){
    include_once("../header.php");
    ?>
    
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                <div class="numbers pull-left">
                    Rp 4000.000
                </div>
                </div>
                <div class="col-sm-7">
                    <div class="pull-right">
                        <span class="badge badge-pill badge-success">
                        x1000.000
                        </span>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <h6 class="big-title">Labour Cost / Unit</h6>
            <canvas id="activeUsers" width="826" height="300"></canvas>
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                    <div class="footer-title">
                        
                        
                            <form action="" method="get">
                                <select class="selectpicker" data-size="7" data-style="btn btn-outline-default text-default btn-sm btn-round" title="Month">
                                    <option disabled>Select Month</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <button class="btn btn-danger btn-round btn-icon btn-sm btn-outline-default text-default">
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
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                <div class="numbers pull-left">
                    Rp 4000.000
                </div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <span class="badge badge-pill badge-success">
                    x1000.000
                    </span>
                </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <h6 class="big-title">Salary Cost / Unit</h6>
            <canvas id="activeUsers" width="826" height="200"></canvas>
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                <div class="footer-title">Ot Rate</div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <button class="btn btn-success btn-round btn-icon btn-sm">
                    <i class="nc-icon nc-simple-add"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                <div class="numbers pull-left">
                    Rp 4000.000
                </div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <span class="badge badge-pill badge-success">
                    x1000.000
                    </span>
                </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <h6 class="big-title">Overtime Cost / Unit</h6>
            <canvas id="activeUsers" width="826" height="200"></canvas>
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                    <div class="footer-title">Ot Rate</div>
                </div>
                <div class="col-sm-5">
                    <div class="pull-right">
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
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                <div class="numbers pull-left">
                    D40D
                </div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <span class="badge badge-pill badge-success">
                    x1000.000
                    </span>
                </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <h6 class="big-title">Salary Cost / Unit</h6>
            <canvas id="activeUsers" width="826" height="200"></canvas>
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                <div class="footer-title">Ot Rate</div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <button class="btn btn-success btn-round btn-icon btn-sm">
                    <i class="nc-icon nc-simple-add"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                <div class="numbers pull-left">
                    D40D
                </div>
                </div>
                <div class="col-sm-5">
                <div class="pull-right">
                    <span class="badge badge-pill badge-success">
                    x1000.000
                    </span>
                </div>
                </div>
            </div>
            </div>
            <div class="card-body">
            <h6 class="big-title">Overtime Cost / Unit</h6>
            <canvas id="activeUsers" width="826" height="200"></canvas>
            </div>
            <div class="card-footer">
            <hr>
            <div class="row">
                <div class="col-sm-7">
                    <div class="footer-title">Ot Rate</div>
                </div>
                <div class="col-sm-5">
                    <div class="pull-right">
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

    <?php
    include_once("../footer.php"); 
    include_once("../endbody.php"); 
///jika tidak ada session maka akan diarahkan ke ahalam login
} else{
  echo "<script>window.location='".base_url('../auth/login.php')."';</script>";
}

?>