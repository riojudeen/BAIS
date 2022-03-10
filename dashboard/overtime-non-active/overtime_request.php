
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/function_status_approve.php");
require_once("../../config/function_access_query.php");
require_once("../../config/function_filter.php");

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Overtime Request";
if(isset($_SESSION['user'])){

    include("../header.php");
    //menghapus session kode lembur
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <h5 class="title pull-left col-md-6" id="mainpage"> Overtime Request</h5>
                        <div class="col-md-6 text-right">
                            <div class="dropdown dropleft">
                                <button class="btn btn-primary btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <form name="organization" method="POST" class="card-body">
                    <!-- <div class="nav-tabs-navigation "> -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sticker">
                                <h6>Access Control</h6>
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                        <!--  -->
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-overtime active data-active"  data-toggle="tab" data-id="req" href="#result" role="tab" aria-expanded="true">Request</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-overtime"  data-toggle="tab" data-id="draft" href="#draft" role="tab" aria-expanded="true">Draft Monitoring</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-overtime"  data-toggle="tab" data-id="approve" href="#approved" role="tab" aria-expanded="true">Aproval Monitor</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-overtime"  data-toggle="tab" data-id="proccess" href="#proccess" role="tab" aria-expanded="true">Proccess Monitor</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-overtime"  data-toggle="tab" data-id="success" href="#success" role="tab" aria-expanded="true">Succeed Monitoring</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="my-tab-content" class="tab-content ">
                                <div class="tab-pane active " id="request" role="tabpanel" aria-expanded="true">
                                    <div id="monitor">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <?php
    //footer
    include_once("../footer.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        if($(".data-active")[0]){
            var id = $('.data-active').attr('data-id');
            
            $('#monitor').load("ajax/monitoring.php?id="+id);
        }
        $('.navigasi-overtime').click(function(){
            var id = $(this).attr('data-id')
            $('#monitor').load("ajax/monitoring.php?id="+id);
        })
    })
    </script>

    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }

  

