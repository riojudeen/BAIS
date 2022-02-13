<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../header.php");
    require_once('../organization/card.php');
    echo $npkUser;
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
    <div class="row">
        <div class="col-md-12 mb-4" >
            <div class="graph" >
                <p class="badge badge-pill badge-warning">result</p>
                <canvas class="" id="productionResult" width="456" height="100" ></canvas>
            </div>
        </div>
    </div>
       
    <?php
    include_once('collapse.php');
    echo "<hr>";
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
                                <h5 class="text-uppercase">Shift Produksi</h5>
                                <div class="nav-tabs-wrapper">
                                    <div class="data-shift"></div>
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
    <script type="text/javascript">
        $(document).ready(function(){
        //   var id = "";
        //   $.ajax({
            
        //       url: 'ajax/get_detail.php?id='+id,
        //       method: 'get',
        //       data: {id:id},		
        //       success:function(data){		
        //           $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                  
        //       }
        //   });
          $(".model").hover(function(){
              $(this).css("background-color", "#EBEBE7");
              $(this).removeClass("bg-transparent");

          }, function(){
              $(this).css("background-color", "transparent");
          });
            // $('.view_data').click(function(e){
            //     e.preventDefault();
            //     var name = $(this).attr('data-id');
            //     var id = $(this).attr('id');
                
                
            //     // console.log(id)
            //     $.ajax({
            //         url: 'ajax/get_detail.php?model='+id,
            //         method: 'get',
            //         data: {id:id},		
            //         success:function(data){		
            //             $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
            //             $('#lineup_model').html(name);	// menampilkan dialog modal nya
            //         }
            //     });
            // });
        });

    </script>
   <script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('productionResult').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill.addColorStop(0, "rgba(148, 234, 255, 0.4)");
    gradientFill.addColorStop(1, "rgba(133, 228, 251, 0.1)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill2.addColorStop(0, "rgba(255, 164, 32, 0.4)");
    gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.1)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          'aug', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30
        ],
        datasets: [
          {
            label: "Production",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
            ],
          },{
            label: "Production",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill2,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
            ],
          },{
            label: "Target",
            borderColor: '#fcc468',
            fill: true,
            type: 'line',
            backgroundColor: 'rgba(255, 39, 0, 0.1)',
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100
            ],
          },{
            label: "Acc",
            borderColor: '#fcc468',
            fill: true,
            type: 'line',
            backgroundColor: 'rgba(255, 39, 0, 0.1)',
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 200,300,150,400,450,300,250,460,264,432,398,222,333,432,345,314,234,567,313,555
            ],
          }
        ]
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },


        legend: {

          display: false
        },
        scales: {

          yAxes: [{
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 1000
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          }],
          xAxes: [{
            stacked: true,
            barPercentage: 0.4,
            barThickness: 10,  // number (pixels) or 'flex'
            maxBarThickness: 15, // number (pixels)
            gridLines: {
              zeroLineColor: "white",
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
    </script>
    <script>
        $(document).ready(function(){
            $('.view_data').click(function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                var title = $(this).attr('data-id');
                $('.model').removeClass("bg-warning");
                $('.model').removeClass("data-active");
                $('#card'+id).addClass('bg-warning');
                $('.model'+id).addClass('data-active');
                $('#model-title').text(title);
                $('.data-shift').load("monitor/shift.php?model="+id);
            })
            
        })
    </script>
    <script>
        $(document).ready(function(){
            if($(".data-active")[0]){
                var id = $('.data-active').attr('id');
                var title = $('.data-active').attr('data-id');
                // console.log(id);
                $('#model-title').text(title);
                $('.data-shift').load("monitor/shift.php?model="+id);
            }
        })
    </script>
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

