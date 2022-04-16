<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../../header.php");
    // require_once('../../organization/card.php');
    $listMenu = array(
        "car model" => "model",
        "production type" => "type",
        "production line" => "line",
    );
    // $q_data = mysqli_query($link, "SELECT * FROM production_model WHERE id_model = '2' ")or die(mysqli_error($link));
    // $s_data = mysqli_fetch_assoc($q_data);
    // $dataLama = $s_data['alias'].".png";
    // $alias = "tes";
    // $temp = '../../../../assets/img/unit_model/';
    // $namaBaru = $temp.$alias.".png";
    //         $namaLama = $temp.$dataLama;
    //         echo $namaLama;
    //         echo "<br>".$namaBaru;
    //         rename("$namaLama","$namaBaru");
    ?>
    <div class="row">
        <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notice">
                <div class="modal-content modalEdit">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="modalLoadDataArea" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
            <div class="modal-dialog modal-xl " role="document">
                <div class="modal-content modalLoadDataArea">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header">
                <div class="row">
                    <h5 class="title pull-left col-md-6" id="mainpage"><i class="fas fa-network-wired "></i> Data Register Organization</h5>
                    <div class="col-md-6 text-right">
                        <a href="../index.php" class="btn btn-sm">Kembali</a>
                    </div>
                </div>
                
            </div>
            <!-- <div class="nav-tabs-navigation "> -->
            <div class="card-body">
                
            
                <div class="row">
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker">
                            <h6>Navigasi</h6>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <!--  -->
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-info active navigasi_data navigasi_active"  data-toggle="tab" data-id="model" href="#model" role="tab" aria-expanded="true">Model Kendaraan</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data "  data-toggle="tab" data-id="model-composition" href="#model" role="tab" aria-expanded="true">Model Kendaraan</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="line" href="#line" role="tab" aria-expanded="true">Line Produksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="area" href="#area" role="tab" aria-expanded="true">Area Produksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="pos" href="#pos" role="tab" aria-expanded="true">Pos Produksi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <?php
                        ?>
                        <div id="my-tab-content" >
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="lihat"></div>
    <?php
    include_once("../../../footer.php");
    ?>
    
    
    <script>
        $(document).ready(function(){
            load_active()
            $('.navigasi_data').on('click', function(){
                $('.navigasi_data').removeClass('navigasi_active');
                $(this).addClass('navigasi_active');
                load_active()
            })
            function load_active(){
                if($('.navigasi_active')[0]){
                    id = $('.navigasi_active').attr('data-id');
                    console.log(id)
                    $.ajax({
                        url: '../ajax/index.php',	
                        method: 'GET',
                        data:{id:id},
                        success:function(data){
                            $('#my-tab-content').html(data);
                        }
                    })
                }
                
            }
            
        })
    </script>
    <?php
    include_once("../../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

