<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $mulai = $_GET['start'] ;
        $selesai = $_GET['end'] ;
        $today = date('Y-m-d');

        list($dataOt, $dataMp) = arrayMP($link, $mulai, $selesai, '1-001', 'division', 'shift', 'ot_total');
        list($dataOtProd, $dataMp) = arrayMP($link, $mulai, $selesai, '1-001', 'division', 'shift', 'ot_prod');
        list($dataOtNon, $dataMp) = arrayMP($link, $mulai, $selesai, '1-001', 'division', 'shift', 'ot_non_prod');
        list($dataOtAcc, $dataMp) = arrayMP($link, $mulai, $selesai, '1-001', 'division', 'shift', 'ot_acc');
        $data_ot = json_decode($dataOt);
        $data_otProd = json_decode($dataOtProd);
        $data_otNon = json_decode($dataOtNon);
        $data_otAcc = json_decode($dataOtAcc);
        $data_tanggal = json_decode(get_date($mulai, $selesai));
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <h6>Working Days</h6>
            </div>
            <div class="col-md-12 " >
                <div class="table-striped border " style="border:2px ; border-radius:15px">
                    <table class="table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Operational</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                            $query_wd = mysqli_query($link, 
                            "SELECT
                            `working_days`.`id` AS `id`,
                            `working_days`.`date` AS `date`,
                            `working_days`.`shift` AS `shift`,
                            `working_days`.`ket` AS `operational`,
                            `working_hours`.`start` AS `start_working`,
                            `working_hours`.`end` AS `end_working`,
                            `working_day_shift`.`name` AS `working_day_shift`,
                            IF(
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`end`,
                                        `working_hours`.`start`
                                    )
                                ) / 60 < 0,
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`start`,
                                        `working_hours`.`end`
                                    )
                                ) / 60,
                                TIME_TO_SEC(
                                    TIMEDIFF(
                                        `working_hours`.`end`,
                                        `working_hours`.`start`
                                    )
                                ) / 60
                            ) AS `working_minutes`
                            FROM `working_days` 
                            JOIN `working_hours` ON `working_hours`.`id` = `working_days`.`wh`
                            LEFT JOIN `working_day_shift` ON `working_day_shift`.`id` = `working_hours`.`code_name`
                            WHERE working_days.date BETWEEN '$today' AND '$today' "
                            )or die(mysqli_error($link));
                            if(mysqli_num_rows($query_wd) > 0){
                                while($data = mysqli_fetch_assoc($query_wd)){
                                    $wd = ($data['operational'] == 'HOP')?'Holiday Operational':'Daily Operational';
                                    ?>
                                    <tr>
                                        <td><?=$data['shift']?></td>
                                        <td><?=$wd?></td>
                                        <td><?=jam($data['start_working'])?></td>
                                        <td><?=jam($data['end_working'])?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        <hr>
        <div class="row px-0">
            <div class="col-md-12">
                <h5>Overtime in Minutes</h5>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 " height="100px">
                         <canvas id="mpOtMonthly" class="ct-chart ct-perfect-fourth"  height="50"></canvas>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body mb-0 pb-0">
                                        <ul class="list-unstyled team-members">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2 col-2">
                                                        <div class="avatar">
                                                        <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 col-7">
                                                        5000
                                                        <br />
                                                        <span class="text-muted"><small>Production overtime</small></span>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body mb-0 pb-0">
                                        <ul class="list-unstyled team-members">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2 col-2">
                                                        <div class="avatar">
                                                        <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 col-7">
                                                        5000
                                                        <br />
                                                        <span class="text-muted"><small>Non Prod. overtime</small></span>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="card-plain">
                                    <div class="card-body mb-0 pb-0">
                                        <ul class="list-unstyled team-members">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2 col-2">
                                                        <div class="avatar">
                                                        <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 col-7">
                                                        5000
                                                        <br />
                                                        <span class="text-muted"><small>Total Overtime</small></span>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                                <canvas id="mpOt" class="ct-chart ct-perfect-fourth"  height="100"></canvas>
                                

                            <div class="col-md-12"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-9">
                    <canvas id="mpOt_nonProd" class="ct-chart ct-perfect-fourth"  height="200"></canvas>
                    </div>
                </div>
                
            </div>
        </div>
        
       
        <script>
            $(document).ready(function(){
            
                // CHARTS
                chartColor = "#FFFFFF";

                ctx = document.getElementById('mpOt').getContext("2d");

                gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                gradientStroke.addColorStop(0, '#80b6f4');
                gradientStroke.addColorStop(1, chartColor);

                
                gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                gradientFill1.addColorStop(0, "rgba(8, 185, 228,1)");
                gradientFill1.addColorStop(1, "rgba(8, 185, 228, 1)");

                gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                gradientFill2.addColorStop(0, "rgba(8, 211, 228, 1)");
                gradientFill2.addColorStop(1, "rgba(8, 211, 228, 1)");

                gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                gradientFill3.addColorStop(0, "rgba(228, 125, 8, 0.5)");
                gradientFill3.addColorStop(1, "rgba(228, 125, 8, 0.1)");

                
                myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                    <?php
                    $data_label = '';
                    $i = 1;
                        foreach($data_tanggal AS $tgl){
                        $data = explode('-',$tgl);
                        $tanggal = $data[2];
                        $data_label .= "'".$tanggal."',";
                        // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                        }
                        $data_label = substr($data_label, 0, -1);
                        echo 
                        "$data_label";
                    ?>
                    ],
                    
                    datasets: [
                    <?php
                            $otNon = '';
                            foreach($data_otNon AS $total){
                                $otNon.= $total.",";
                                // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                            }
                            $otNon = substr($otNon, 0, -1);
                            
                            echo 
                            "{ 

                                label: \"Production Non Prod\",
                                yAxisID: 'A',
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill2,
                                hoverBorderColor: '#fcc468',
                                order: 3,
                                borderWidth: 0,
                                data: [
                                $otNon
                                ],
                            },";
                            $otProd = '';
                            foreach($data_otProd AS $total){
                                $otProd .= $total.",";
                                // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                            }
                            $otProd = substr($otProd, 0, -1);
                            
                            echo 
                            "{ 
                                label: \"Production \",
                                yAxisID: 'A',
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill1,
                                hoverBorderColor: '#fcc468',
                                order: 2,
                                borderWidth: 0,
                                data: [
                                $otProd
                                ],
                            },";
                            
                            $no = 1;
                            // foreach($data_dept AS $dept => $val){
                            //     $dept = getOrgName($link, $dept, "deptAcc");
                            $otAcc = '';
                            foreach($data_otAcc AS $total){
                                $otAcc .= $total.",";
                                // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                            }
                            $otAcc = substr($otAcc, 0, -1);
                            
                            echo 
                            "{ 
                                label: \"Total \",
                                yAxisID: 'A',
                                type: 'line',
                                fill: true,
                                backgroundColor: gradientFill3,
                                hoverBorderColor: '#fcc468',
                                order: 1,

                                borderColor: false,
                                pointBackgroundColor: \"#f17e5d\",
                                pointRadius: 2,
                                pointHoverRadius: 10,
                                lineTension: 0,
                                borderWidth: false,
                                
                                data: [
                                $otAcc
                                ],
                            },";
                            echo 
                            "{ 
                                label: \"Total \",
                                yAxisID: 'B',
                                type: 'bar',
                                fill: true,
                                backgroundColor: 'transparent',
                                hoverBorderColor: '#fcc468',
                                order: 5,

                                borderColor: false,
                                pointBackgroundColor: \"#f17e5d\",
                                pointRadius: 2,
                                pointHoverRadius: 10,
                                lineTension: 0,
                                borderWidth: false,
                                
                                data: [
                                $otAcc
                                ],
                            }";
                            
                        
                    ?>
                    
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

                        yAxes: [
                            {
                                id: 'A',
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#9f9f9f",
                                    fontStyle: "bold",
                                    
                                    maxTicksLimit: 100,
                                    padding: 20,
                                    min: 0,
                                    max: 10000,
                                    stepSize: 1000,
                                },
                                gridLines: {
                                    zeroLineColor: "transparent",
                                    display: true,
                                    drawBorder: false,
                                    color: '#9f9f9f',
                                }

                            },
                            {
                                id: 'B',
                                position: 'right',
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#9f9f9f",
                                    fontStyle: "bold",
                                    
                                    maxTicksLimit: 100,
                                    padding: 20,
                                    min: 0,
                                    max: 10000,
                                    stepSize: 1000,
                                },
                                gridLines: {
                                    zeroLineColor: "transparent",
                                    display: true,
                                    drawBorder: false,
                                    color: '#9f9f9f',
                                }

                            }
                        ],
                        xAxes: [{
                            stacked: true,
                            barPercentage: 0.9,
                            scaleLabel: {
                                display: true,
                                labelString: 'April'
                            },
                            gridLines: {
                                zeroLineColor: "white",
                                display: true,

                                drawBorder: false,
                                color: '#9f9f9f',   
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 20,
                                fontColor: "#9f9f9f",
                                fontStyle: "bold",
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: 'Overtime'
                    }
                }
                });
                
            })
        </script>
            <script>
                $(document).ready(function(){
                
                    // CHARTS
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('mpOtMonthly').getContext("2d");

                    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                    gradientStroke.addColorStop(0, '#80b6f4');
                    gradientStroke.addColorStop(1, chartColor);

                    
                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(8, 185, 228,1)");
                    gradientFill1.addColorStop(1, "rgba(8, 185, 228, 1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(8, 211, 228, 1)");
                    gradientFill2.addColorStop(1, "rgba(8, 211, 228, 1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(228, 125, 8, 0.5)");
                    gradientFill3.addColorStop(1, "rgba(228, 125, 8, 0.1)");

                    
                    myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                        "04", "05", "06", "07", "08","09","10", "11", "12", "", "01","02","03"
                        ],
                        
                        datasets: [
                            { 
                                    label: 'Production Non Prod',
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill2,
                                    hoverBorderColor: '#fcc468',
                                    order: 3,
                                    borderWidth: 0,
                                    data: [

                                    ],
                                },
                                {
                                    label: 'Production Non Prod',
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill2,
                                    hoverBorderColor: '#fcc468',
                                    order: 3,
                                    borderWidth: 0,
                                    data: [ 
                                        10000, 10000,10000,10000,1900,1000,10000, 10000,10000,10000,1900,1000
                                    ],
                                },
                                { 
                                    label: "Production ",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill1,
                                    hoverBorderColor: '#fcc468',
                                    order: 2,
                                    borderWidth: 0,
                                    data: [ 
                                        10000, 10000,10000,10000,1900,1000,10000, 10000,10000,10000,1900,1000
                                    ],
                                },
                                { 
                                    label: "Total ",
                                    type: 'line',
                                    fill: true,
                                    backgroundColor: gradientFill3,
                                    hoverBorderColor: '#fcc468',
                                    order: 1,

                                    borderColor: false,
                                    pointBackgroundColor: "#f17e5d",
                                    pointRadius: 2,
                                    pointHoverRadius: 10,
                                    lineTension: 0,
                                    borderWidth: false,
                                    
                                    data: [
                                        10000, 10000,10000,10000,1900,1000,10000, 10000,10000,10000,1900,1000
                                    ],
                                }
                        
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                                beginAtZero: true,
                                fontColor: "#9f9f9f",
                                fontStyle: "bold",
                                
                                maxTicksLimit: 5,
                                padding: 20
                            },
                            gridLines: {
                                zeroLineColor: "transparent",
                                display: true,
                                drawBorder: false,
                                color: '#9f9f9f',
                            }

                        }],
                        xAxes: [{
                            stacked: true,
                            barPercentage: 0.9,
                            scaleLabel: {
                                display: true,
                                labelString: 'April'
                            },
                            gridLines: {
                                zeroLineColor: "white",
                                display: true,

                                drawBorder: false,
                                color: 'transparent',   
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 20,
                                fontColor: "#9f9f9f",
                                fontStyle: "bold",
                            }
                        }]
                        }
                    }
                    });
                    
                })
            </script>
        <script>
                $(document).ready(function(){
                
                    // CHARTS
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('mpOt_nonProd').getContext("2d");

                    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                    gradientStroke.addColorStop(0, '#80b6f4');
                    gradientStroke.addColorStop(1, chartColor);

                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(8, 185, 228,1)");
                    gradientFill1.addColorStop(1, "rgba(8, 185, 228, 1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(8, 211, 228, 1)");
                    gradientFill2.addColorStop(1, "rgba(8, 211, 228, 1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(228, 125, 8, 0.5)");
                    gradientFill3.addColorStop(1, "rgba(228, 125, 8, 0.1)");

                    myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                        <?php
                        $data_label = '';
                        $i = 1;
                            foreach($data_tanggal AS $tgl){
                            $data = explode('-',$tgl);
                            $tanggal = $data[2];
                            $data_label .= "'".$tanggal."',";
                            // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                            }
                            $data_label = substr($data_label, 0, -1);
                            echo 
                            "$data_label";
                        ?>
                        ],
                        
                        datasets: [
                        <?php
                            $queryOT = mysqli_query($link, "SELECT kode_lembur, nama FROM kode_lembur WHERE kode_lembur <> 'PROD' ")or die(mysqli_error($link));
                            
                            if(mysqli_num_rows($queryOT)>0){
                                $i = 1;
                                $total = mysqli_num_rows($queryOT);
                                while($data = mysqli_fetch_assoc($queryOT)){
                                    list($acc , $nonProd) = arrayOTnonProd($link, $mulai, $selesai, '1-001', 'division', $data['kode_lembur']);
                                    $dataOT = '';
                                    $dataAcc = '';
                                    $ot = json_decode($nonProd);
                                    foreach($ot AS $ot){
                                        $dataOT .= $ot.",";
                                    }
                                    $dataOT = substr($dataOT, 0, -1);

                                    $otAcc = json_decode($acc);
                                    foreach($otAcc AS $otacc){
                                        $dataAcc .= $otacc.",";
                                    }
                                    $dataOT = substr($dataOT, 0, -1);
                                    $dataAcc = substr($dataAcc, 0, -1);
                                    echo 
                                    "{ 
                                        label: \"$data[nama]\",
                                        type: 'bar',
                                        yAxisID: 'A',
                                        borderColor: '#fcc468',
                                        fill: true,
                                        backgroundColor: gradientFill1,
                                        hoverBorderColor: '#fcc468',
                                        order: $i,
                                        borderWidth: 0,
                                        data: [
                                            $dataOT
                                        ],
                                    },";
                                    if($i == $total){
                                        "{ 
                                            label: \"Accumulation\",
                                            yAxisID: 'A',
                                            type: 'line',
                                            fill: true,
                                            backgroundColor: gradientFill,
                                            hoverBorderColor: '#fcc468',
                                            order: 1,
            
                                            borderColor: false,
                                            pointBackgroundColor: \"#f17e5d\",
                                            pointRadius: 2,
                                            pointHoverRadius: 10,
                                            lineTension: 0,
                                            borderWidth: false,
                                            
                                            data: [
                                            $dataAcc
                                            ],
                                        }";
                                        // echo 
                                        // "{ 
                                        //     label: \"Total \",
                                        //     yAxisID: 'B',
                                        //     type: 'bar',
                                        //     fill: true,
                                        //     backgroundColor: 'transparent',
                                        //     hoverBorderColor: '#fcc468',
                                        //     order: 5,
            
                                        //     borderColor: false,
                                        //     pointBackgroundColor: \"#f17e5d\",
                                        //     pointRadius: 2,
                                        //     pointHoverRadius: 10,
                                        //     lineTension: 0,
                                        //     borderWidth: false,
                                            
                                        //     data: [
                                        //     $dataAcc
                                        //     ],
                                        // }";
                                        
                                    }
                                    $i++;
                                    
                                }
                            }
                           
                            
                            
                        ?>
                        
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

                        yAxes: [
                            {
                                id: 'A',
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#9f9f9f",
                                    fontStyle: "bold",
                                    
                                    maxTicksLimit: 100,
                                    padding: 20,
                                    min: 0,
                                    max: 10000,
                                    stepSize: 1000,
                                },
                                gridLines: {
                                    zeroLineColor: "transparent",
                                    display: true,
                                    drawBorder: false,
                                    color: '#9f9f9f',
                                }

                            },
                            {
                                id: 'B',
                                position: 'right',
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#9f9f9f",
                                    fontStyle: "bold",
                                    
                                    maxTicksLimit: 100,
                                    padding: 20,
                                    min: 0,
                                    max: 10000,
                                    stepSize: 1000,
                                },
                                gridLines: {
                                    zeroLineColor: "transparent",
                                    display: true,
                                    drawBorder: false,
                                    color: '#9f9f9f',
                                }

                            }
                        ],
                        xAxes: [{
                            stacked: true,
                            barPercentage: 0.9,
                            scaleLabel: {
                                display: true,
                                labelString: 'April'
                            },
                            gridLines: {
                                zeroLineColor: "white",
                                display: true,

                                drawBorder: false,
                                color: '#9f9f9f',   
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 20,
                                fontColor: "#9f9f9f",
                                fontStyle: "bold",
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: 'Overtime'
                    }
                }
                    });
                    
                })
            </script>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
