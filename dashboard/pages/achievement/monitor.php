<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        if($_GET['data'] == 'mp'){

            $mulai = $_GET['start'];
            $selesai = $_GET['end'];
            // echo  $_GET['end'];
            $today = date('Y-m-d');
            
            $part = partAccess($level, "part");
            $data_tanggal = json_decode(get_date($mulai, $selesai));
            $filter_date = '';
            
            $data_area= array(); 
            $data_total = array(); 
            $data_ijin = array(); 
            $data_jabatan = array(); 
            $data_id_jab = array(); 

            $qry_area = "SELECT SUM(mp) AS mp FROM karyawan_record";
            $qry_jabatan = "SELECT id_jabatan, jabatan FROM jabatan";
            $sql_jabatan = mysqli_query($link, $qry_jabatan)or die(mysqli_error($link));
            if(mysqli_num_rows($sql_jabatan)>0){
                while($jab = mysqli_fetch_assoc($sql_jabatan)){
                    array_push($data_jabatan, $jab['jabatan'] );
                    array_push($data_id_jab, $jab['id_jabatan'] );
                }
            }
            foreach( $data_tanggal AS $date){
                // get mp total
                $qry = $qry_area." WHERE part = '$part' AND `date` = '$date' " ;
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($sql);
                array_push($data_total, $data['mp'] );

                //get mp / jabatan
                


            }

            $filter_date = substr($filter_date , 0,-2);
            // echo $filter_date;
            $filter_date = ($filter_date != "")?" AND ($filter_date) ": "";
            $qry = "SELECT SUM(mp) AS mp FROM karyawan_record WHERE part = '$part' ".$filter_date." GROUP BY date ASC " ;
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));

            
            
            // while($data = mysqli_fetch_assoc($sql)){
            //     // echo " $data[id] - $data[id_area] - $data[nama_area] - $data[part] - $data[id_jabatan] - $data[mp] <br>";
            //     array_push($data_total, $part);
            // }
            //
            ?>
            <div class="row">
                <div class="col-md-7">
                    <h5 class="">MP Arrangement </h5>
                    <p class="card-category">periode : <?=tgl($mulai)?> - <?=tgl(($selesai))?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="attendancerate" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>MP Position</h5>
                </div>
                <div class="col-md-12">
                    <h5>MP Position</h5>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                
                    // CHARTS
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('attendancerate').getContext("2d");

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
                                $masuk = '';
                                foreach($data_total AS $total){
                                    $masuk .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $masuk = substr($masuk, 0, -1);
                                echo 
                                "{ 
                                    label: \"Total\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill$no,
                                    hoverBorderColor: '#fcc468',
                                    order: $no,
                                    borderWidth: 0,
                                    data: [
                                    $masuk
                                    ],
                                },";
                            //     $no++;
                            // // echo getOrgName($link, $dept, "deptAcc")."<br>";
                            // // print_r($val)."<br>";
                            
                            // }
                            $data_target = '';
                            foreach($data_tanggal AS $tgl){
                            $data_target .= "95,";
                            // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                            }
                            $data_target = substr($data_target, 0,-1);
                            echo 
                            "{
                            label: \"Target\",
                            borderColor: '#fcc468',
                            fill: true,
                            type: 'line',
                            backgroundColor: 'rgba(255, 39, 0, 0.1)',
                            hoverBorderColor: '#fcc468',
                            borderWidth: 0,
                            data: [
                                $data_target
                            ],
                            }"
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
                            fontColor: "#9f9f9f",
                            fontStyle: "bold",
                            beginAtZero: false,
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
                            barPercentage: 0.9,
                            gridLines: {
                            zeroLineColor: "white",
                            
                            display: false,

                            drawBorder: false,
                            color: 'transparent',
                            },
                            ticks: {
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
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
