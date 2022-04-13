<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../header.php");
    require_once('../organization/card.php');
    // echo $npkUser;
    $listMenu = array("area", "result");
    

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
    <!-- <div class="row">
        <div class="col-md-12 mb-4" >
            <div class="graph" >
                <p class="badge badge-pill badge-warning">result</p>
                <canvas class="" id="productionResult" width="456" height="100" ></canvas>
            </div>
        </div>
    </div> -->
       
    <?php
    // include_once('collapse.php');
    include_once('production_model.php');
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

<!-- halaman utama end -->
<div class="row">
    <div class="col-md-12">
        <div class="card" >
            
            <div class="card-body">
                <div id="monitor">
                    <div class="row">
                        <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                            <div class="sticker">
                              <div class="row">
                                  <h5 class="text-uppercase col-md-12">Shift Produksi</h5>
                                  <div class="col-md-12">
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <?php
                                    $query_shift = "SELECT * FROM shift WHERE production = '1' ";
                                    $sql_shift = mysqli_query($link, $query_shift)or die(mysqli_error($link));
                                    if(mysqli_num_rows($sql_shift)>0){
                                      $index = 0;
                                      $no = 0;
                                      while($data_shift = mysqli_fetch_assoc($sql_shift)){
                                        if($index == $no++){
                                            $active = "active";
                                            $tab_active = "shift-active";
                                        }else{
                                            $active = "";
                                            $tab_active = "";
                                        }
                                        ?>
                                        <li class="nav-item  ">
                                            <a class="btn btn-sm btn-link btn-round btn-info shift navigasi_data shift-<?=$data_shift['id_shift']?> <?=$tab_active?> <?=$active?>"  data-toggle="tab" data-id="<?=$data_shift['id_shift']?>" id="<?=$data_shift['id_shift']?>" href="#model" role="tab" aria-expanded="true"><?=$data_shift['shift']?></a>
                                        </li>
                                        <?php
                                      }
                                    }
                                    ?>
                                    </ul>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 border-left">
                            <div class="row">
                                <h5 class="col-md-6 text-uppercase" id="model-title">Data Area Produksi</h5>
                                <div class="col-md-6 text-right">
                                
                                </div>
                            </div>
                            <div class="data-monitor">

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    // include_once('production_area.php');
    ?>

    <?php    
    include_once("../../footer.php");
    //javascript
    
    ?>
    
    <script>
        $(document).ready(function(){
          $(".model").hover(function(){
                $(this).css("background-color", "#EBEBE7");
                $(this).removeClass("bg-transparent");
            }, function(){
                $(this).css("background-color", "transparent");
            });
            $('.shift').click(function(){
                var id = $(this).attr('id');
                $('.shift').removeClass("shift-active");
                $('.shift-'+id).addClass('shift-active');
                data_active()
            })
            $('.view_data').on('click',function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                var title = $(this).attr('data-id');
                $('.model').removeClass("bg-warning");
                $('#card'+id).addClass('bg-warning');
                $('.model').removeClass("data-active");
                $('.model'+id).addClass('data-active');
                $('#model-title').text(title);
                data_active()
            })
          data_active()
          function data_active(){
                
                var dataShift = $('.shift-active').attr('id');
                var id = $('.data-active').attr('id');
                console.log(id)
                console.log(dataShift)
                $.ajax({
                    url:"monitor/index.php",
                    method:"GET",
                    data:{model:id,shift:dataShift},
                    success:function(data){
                        $('.data-monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                    }
                })
            }
        })
    </script>
    
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

