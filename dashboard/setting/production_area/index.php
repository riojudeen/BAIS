<?php
$_SESSION['tab'] = 'pos';
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../header.php");
    require_once('../organization/card.php');
    require_once('collapse.php');
    ?>
    <form method="POST">
        <div class="row">
            <div class="col-md-12" >
                <div class="card bg-transparent" >
                    <div class="card-body bg-transparent">
                    
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h5 class="title pull-left col-md-6" id="mainpage"><i class="fas fa-network-wired "></i> Data Man Power Arrangement</h5>
                        <div class="col-md-6 text-right">
                            <div class="dropdown dropleft">
                                <button class="btn btn-sm btn-primary btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header">Menu</div>
                                    <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                                    <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Download Format</a>
                                    <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <hr>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
    


    <?php    
    include_once("../../footer.php");
    //javascript
    ?>



    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

