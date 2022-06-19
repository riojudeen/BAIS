<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $mulai = $_GET['start'] ;
        $selesai = $_GET['end'] ;
        $today = date('Y-m-d');

        list($dataOt, $dataMp) = arrayMP($link, $mulai, $selesai, '1-001', 'division', 'shift', '');
        $data_ot = json_decode($dataOt);
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
        <div class="row">
            <div class="col-md-12">
                <h5>Overtime in Minutes</h5>
            </div>
            <div class="col-md-12">
                <canvas id="mpOt" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h6>Non Production Overtime</h6>
            </div>
            <div class="col-md-12">
                <canvas id="mpOt_nonProd" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
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

                    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill.addColorStop(1, "rgba(55, 164, 255,0.4)");

                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill1.addColorStop(1, "rgba(55, 164, 255, 0.1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(1, 181, 225, 1)");
                    gradientFill2.addColorStop(1, "rgba(1, 181, 225, 0.1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill3.addColorStop(1, "rgba(5, 217, 246, 0.1)");
                    gradientFill4 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill4.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill4.addColorStop(1, "rgba(5, 217, 246, 0.1)");
                    gradientFill5 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill5.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill5.addColorStop(1, "rgba(5, 217, 246, 0.1)");

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
                            
                            $no = 1;
                            // foreach($data_dept AS $dept => $val){
                            //     $dept = getOrgName($link, $dept, "deptAcc");
                                $ot = '';
                                foreach($data_ot AS $total){
                                    $ot .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $ot = substr($ot, 0, -1);
                                
                                echo 
                                "{ 
                                    label: \"Production \",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill$no,
                                    hoverBorderColor: '#fcc468',
                                    order: $no,
                                    borderWidth: 0,
                                    data: [
                                    $ot
                                    ],
                                },";
                                echo 
                                "{ 
                                    label: \"Non Production\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill2,
                                    hoverBorderColor: '#fcc468',
                                    order: 1,
                                    borderWidth: 0,
                                    data: [
                                    $ot
                                    ],
                                },";
                            
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
                        display: true
                        },
                        scales: {

                        yAxes: [{
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
                            gridLines: {
                                zeroLineColor: "white",
                                display: false,

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

                    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill.addColorStop(1, "rgba(55, 164, 255,0.4)");

                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill1.addColorStop(1, "rgba(55, 164, 255, 0.1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(1, 181, 225, 1)");
                    gradientFill2.addColorStop(1, "rgba(1, 181, 225, 0.1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill3.addColorStop(1, "rgba(5, 217, 246, 0.1)");
                    gradientFill4 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill4.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill4.addColorStop(1, "rgba(5, 217, 246, 0.1)");
                    gradientFill5 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill5.addColorStop(0, "rgba(5, 217, 246, 1)");
                    gradientFill5.addColorStop(1, "rgba(5, 217, 246, 0.1)");

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
                            
                            $no = 1;
                            // foreach($data_dept AS $dept => $val){
                            //     $dept = getOrgName($link, $dept, "deptAcc");
                                $ot = '';
                                foreach($data_ot AS $total){
                                    $ot .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $ot = substr($ot, 0, -1);
                                
                                echo 
                                "{ 
                                    label: \"Production \",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill$no,
                                    hoverBorderColor: '#fcc468',
                                    order: $no,
                                    borderWidth: 0,
                                    data: [
                                    $ot
                                    ],
                                },";
                                echo 
                                "{ 
                                    label: \"Non Production\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill2,
                                    hoverBorderColor: '#fcc468',
                                    order: 1,
                                    borderWidth: 0,
                                    data: [
                                    $ot
                                    ],
                                },";
                            
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
                        display: true
                        },
                        scales: {

                        yAxes: [{
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
                            gridLines: {
                                zeroLineColor: "white",
                                display: false,

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
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
