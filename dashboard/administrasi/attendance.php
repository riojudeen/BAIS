<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Attendance Achievement";
if(isset($_SESSION['user'])){

    include_once("../header.php");
?>
<div class="row">
    
    <div class="col-md-4">
        <h5 class="">Attendace Monitoring</h5>
    </div>
    <div class="col-md-8 ">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <label class="col-md-4 col-form-label text-right">Based On :</label>
                    <div class="col-md-8">
                        <div class="form-group-sm pr-1">
                            <select name="show_dept" id="show_dept" class="form-control">
                                <option value="deptAcc">Departmen Administratif</option>
                                <option value="dept">Departmen Functional</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Date :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <input type="text" class="form-control datepicker">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Shift :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 text-right">
                <div class="row ">
                    <!-- <div class="nav-link active btn-magnify mt-0"><i class="fas fa-th-list"></i></div> -->
                    <div class="nav-link text-danger btn-magnify mt-0"><i class="fas fa-th-large"></i></div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row ">
            <div class="col-md-2 ">
                <div class="card card-user card-plain sticker">
                    <div class="image">
                        <img src="../../assets/img/bg/damir-bosnjak.jpg" alt="...">
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="../../assets/img/mike.jpg" alt="...">
                                <h5 class="card-title text-uppercase">Rio Setiawan Judin</h5>
                            </a>
                            <p class="description">
                                Group 1
                            </p>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="button-container">
                        <div class="row">
                            <div class="col-md-12 ml-auto bg-success rounded">
                            <h6 class="py-3 mb-0 text-white">MASUK</h6>
                            </div>
                            <div class="col-md-12 col-md-6 col-6 ml-auto mr-auto">
                            <label>Check In</label>
                            <h5>07:30</h5>
                            </div>
                            <div class="col-md-12 mr-auto">
                            <label>Check In</label>
                            <h5>07:30</h5>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <h5>Group Foreman 1</h5>
                <p class="card-category">Top 10 Karyawan Terbaik berdasarkan data absen dalam sebulan</p>
                <div class="row ">
                    <div class="col-md-12 owl-carousel ">
                        
                        
                        <div class="card  " >
                            <div class="card-header p-0 ">
                                <div class="image rounded-top">
                                <img src="../../assets/img/img/tm.png" alt="..." >
                                </div>

                            </div>
                            <div class="card-body" height="200px">
                                <h6 class="text-uppercase ">Rio Setiawan Judin</h6>
                                <p class="category">44131</p>
                            </div>
                            
                        </div>
                        <div class="card  " >
                            <div class="card-header p-0 ">
                                <div class="image rounded-top">
                                <img src="../../assets/img/img/tm.png" alt="..." >
                                </div>

                            </div>
                            <div class="card-body" height="200px">
                                <h6 class="text-uppercase ">Rio Setiawan Judin</h6>
                                <p class="category">44131</p>
                            </div>
                            
                        </div>
                        <div class="card  " >
                            <div class="card-header p-0 ">
                                <div class="image rounded-top">
                                <img src="../../assets/img/img/tm.png" alt="..." >
                                </div>

                            </div>
                            <div class="card-body" height="200px">
                                <h6 class="text-uppercase ">Rio Setiawan Judin</h6>
                                <p class="category">44131</p>
                            </div>
                            
                        </div>
                        
                    </div>
                        
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="list-unstyled team-members">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2 col-2">
                                                        <div class="avatar">
                                                        <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10 col-10">
                                                        <h6 class="text-uppercase">Rio Setiawan Ju...</h6>
                                                        <span class="text-muted"><small>Team Leader 1</small></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3 bg-success text-center rounded ">                                            
                                                <h6 class="py-3 mb-0 text-white">Masuk</h6>
                                            </div>
                                            <div class="col-9 col-md-9 ">
                                                <div class="row">
                                                    <div class="col-md-4 text-left">
                                                        <label class="description">
                                                            Cehck In : 
                                                        </label>
                                                        <label class="description">
                                                            Cehck Out : 
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-md-8 border-left">
                                                        <h6 class="">Team Member</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p class="category">Total MP: <p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="category">Total Masuk: <p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 numbers text-right">
                                        <p class="card-title">80%<p>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title text-success col-md-6">Monitoring Absensi</h6>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="card-body table-full-width">
                                <table class="table table-xs table-bordered">
                                    <tbody class="text-center text-uppercase">
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-danger ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-info ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-primary ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="table-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-success">Team Member Ijin</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-success">Team Member Ijin</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="list-unstyled team-members">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2 col-2">
                                                        <div class="avatar">
                                                        <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10 col-10">
                                                        <h6 class="text-uppercase">Rio Setiawan Ju...</h6>
                                                        <span class="text-muted"><small>Team Leader 1</small></span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3 bg-success text-center rounded ">                                            
                                                <h6 class="py-3 mb-0 text-white">Masuk</h6>
                                            </div>
                                            <div class="col-9 col-md-9 ">
                                                <div class="row">
                                                    <div class="col-md-4 text-left">
                                                        <label class="description">
                                                            Cehck In : 
                                                        </label>
                                                        <label class="description">
                                                            Cehck Out : 
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-md-8 border-left">
                                                        <h6 class="">Team Member</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p class="category">Total MP: <p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="category">Total Masuk: <p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 numbers text-right">
                                        <p class="card-title">80%<p>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title text-success col-md-6">Monitoring Absensi</h6>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="card-body table-full-width">
                                <table class="table table-xs table-bordered">
                                    <tbody class="text-center text-uppercase">
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-danger ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-info ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-primary ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="table-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-warning ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                            <td class="bg-success ">Rio</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-success">Team Member Ijin</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-success">Team Member Ijin</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
<?php
    include_once("../footer.php");
    ?>
<script>
    $(document).ready(function(){
        Chart.pluginService.register({
        beforeDraw: function(chart) {
            if (chart.config.options.elements.center) {
            //Get ctx from string
            var ctx = chart.chart.ctx;

            //Get options from the center object in options
            var centerConfig = chart.config.options.elements.center;
            var fontStyle = centerConfig.fontStyle || 'Arial';
            var txt = centerConfig.text;
            var color = centerConfig.color || '#000';
            var sidePadding = centerConfig.sidePadding || 20;
            var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
            //Start with a base font of 30px
            ctx.font = "30px " + fontStyle;

            //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
            var stringWidth = ctx.measureText(txt).width;
            var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

            // Find out how much the font can grow in width.
            var widthRatio = elementWidth / stringWidth;
            var newFontSize = Math.floor(30 * widthRatio);
            var elementHeight = (chart.innerRadius * 2);

            // Pick a new font size so it will not be larger than the height of label.
            var fontSizeToUse = Math.min(newFontSize, elementHeight);

            //Set font settings to draw it correctly.
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
            var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
            ctx.font = fontSizeToUse + "px " + fontStyle;
            ctx.fillStyle = color;

            //Draw text in center
            ctx.fillText(txt, centerX, centerY);
            }
        }
        });
        ctx = document.getElementById('chartDonut1').getContext("2d");

        myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [1, 2, 3],
            datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#4acccd', '#f4f3ef', '#FF5733'],
            borderWidth: 0,
            data: [60, 30, 10]
            }]
        },
        options: {
            elements: {
            center: {
                text: '95%',
                color: '#66615c', // Default is #000000
                fontStyle: 'Arial', // Default is Arial
                sidePadding: 60 // Defualt is 20 (as a percentage)
            }
            },
            cutoutPercentage: 80,
            legend: {

            display: false
            },

            tooltips: {
            enabled: true
            },

            scales: {
            yAxes: [{

                ticks: {
                display: false
                },
                gridLines: {
                drawBorder: true,
                zeroLineColor: "transparent",
                color: 'rgba(255,255,255,0.05)'
                }

            }],

            xAxes: [{
                barPercentage: 1.6,
                gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent"
                },
                ticks: {
                display: false,
                }
            }]
            },
        }
        });
    })
</script>
<script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('attendancerate').getContext("2d");

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
          display: true
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
        //Load Chart
        var ctx = $("#verticalchart");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <!-- dummy -->
    <script>
        //Load Chart
        var ctx = $("#verticalchart2");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <script>
        //Load Chart
        var ctx = $("#verticalchart3");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <script>
        //Load Chart
        var ctx = $("#verticalchart4");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <script>
        //Load Chart
        var ctx = $("#verticalchart5");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <script>
        //Load Chart
        var ctx = $("#verticalchart6");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
            },
            options: {
                //Set the index of the value where you want to draw the line
                lineAtIndex: 60,
                legend: {
                    display: false
                },
                scales: {

                    yAxes: [{
                        stacked: true,
                        ticks: {
                            display: true
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
                            beginAtZero: true,
                            display: false
                        },
                    }]
                }
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items:5,
                loop:true,
                margin:10,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
            $('.play').on('click',function(){
                owl.trigger('play.owl.autoplay',[1000])
            })
            $('.stop').on('click',function(){
                owl.trigger('stop.owl.autoplay')
            })
        });
    </script>
    <?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
  

?>