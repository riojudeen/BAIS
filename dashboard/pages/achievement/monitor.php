<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        // $_GET['data'] = "mp";
        if($_GET['data'] == 'mp'){

            $mulai = $_GET['start'] ;
            $selesai = $_GET['end'] ;
            // echo  $_GET['end'];
            $today = date('Y-m-d');
            
            $part = partAccess($level, "part");
            $access_org = orgAccess($level);
            $data_access = generateAccess($link,$level,$npkUser);
            echo $data_access ;

            $data_tanggal = json_decode(get_date($mulai, $selesai));
            $filter_date = '';
            
            $data_area= array(); 
            $data_total = array(); 
            $data_ijin = array(); 

            $data_jabatan = array(); 
            $data_id_jab = array(); 

            $data_id_dept_account = array(); 
            $data_dept_account = array(); 

            $array_total_deptAcc = array(); 
            $array_total_jabatan = array(); 

            $array_total_mp_jabatan_dept = array(); 

            $qry_area = "SELECT SUM(mp) AS mp , id_area, id_jabatan, nama_area, id_dept_account FROM karyawan_record";
            $qry_jabatan = "SELECT id_jabatan, jabatan FROM jabatan";
            $sql_jabatan = mysqli_query($link, $qry_jabatan)or die(mysqli_error($link));

            $q_dept_account = "SELECT id_dept_account , department_account FROM dept_account ";
            $sql_dept_account = mysqli_query($link, $q_dept_account)or die(mysqli_error($link));


            if(mysqli_num_rows($sql_jabatan)>0){
                while($jab = mysqli_fetch_assoc($sql_jabatan)){
                    array_push($data_jabatan, $jab['jabatan'] );
                    array_push($data_id_jab, $jab['id_jabatan'] );
                }
            }
            if(mysqli_num_rows($sql_dept_account)>0){
                while($dept_account= mysqli_fetch_assoc($sql_dept_account)){
                    array_push($data_dept_account, $dept_account['department_account'] );
                    array_push($data_id_dept_account, $dept_account['id_dept_account'] );
                    
                }
            }
            $i = 0;
            foreach( $data_tanggal AS $date){
                // get mp total
                $qry = $qry_area." WHERE part = '$part' AND `date` = '$date' AND id_area = '$data_access'  " ;
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($sql);
                array_push($data_total, $data['mp'] );

                //get mp / dep 
                if(count($data_id_dept_account)>0){
                    foreach($data_id_dept_account AS $dept_account){
                        $qry_total_deptAcc = $qry." AND id_dept_account = '$dept_account' ";
                        $sql_total_deptAcc = mysqli_query($link, $qry_total_deptAcc)or die(mysqli_error($link));
                        $data_total_deptAcc = mysqli_fetch_assoc($sql_total_deptAcc);
                        
                        $dataDept[$dept_account] = $data_total_deptAcc['mp'];
                        
                    }
                    array_push($array_total_deptAcc, $dataDept);

                }
                //get mp / jabatan
                if(count($data_id_jab)>0){
                    foreach($data_id_jab AS $dataJabatan){
                        $qry_total_jabatan = $qry." AND id_jabatan = '$dataJabatan'  ";
                        $sql_total_jabatan = mysqli_query($link, $qry_total_jabatan)or die(mysqli_error($link));
                        $data_total_jabatan = mysqli_fetch_assoc($sql_total_jabatan);

                        $dataJab[$dataJabatan] = $data_total_jabatan['mp'];
                        
                       
                        //get mp / jabatan / dept
                        if(count($data_id_dept_account)>0){
                            foreach($data_id_dept_account AS $dept_account){
                                $qry_mp_deptAcc = $qry_total_jabatan." AND id_dept_account = '$dept_account' ";
                                $sql_mp_deptAcc = mysqli_query($link, $qry_mp_deptAcc)or die(mysqli_error($link));
                                $data_mp_deptAcc = mysqli_fetch_assoc($sql_mp_deptAcc);
                                $dataMpDept[$dept_account] = $data_mp_deptAcc['mp'];
                            }
                            // untuk perhitungan data mp jabatan dan per dept
                            $data_perJabatan[$dataJabatan] = $dataMpDept;
                            array_push($array_total_mp_jabatan_dept,  $data_perJabatan);
                        }
                        
                    }

                    // untuk perhitungan data mp langsun per dept
                    array_push($array_total_jabatan, $dataJab);

                }
                

               
            }
            
            // cek data
            // print_r($array_total_jabatan);
            $dataJSON = json_encode($array_total_jabatan);
            $output = "{\"data\":".$dataJSON."}";
            // print_r($array_total_jabatan);



            $filter_date = substr($filter_date , 0,-2);
            // echo $filter_date;
            $filter_date = ($filter_date != "")?" AND ($filter_date) ": "";
            $qry = "SELECT SUM(mp) AS mp FROM karyawan_record WHERE part = '$part' ".$filter_date." GROUP BY date ASC " ;
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
            
            ?>
            <div class="row">
                <div class="col-md-7">
                    <h5 class="">MP Arrangement </h5>
                    <p class="card-category">periode : <?=tgl($mulai)?> - <?=tgl(($selesai))?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="mpTotal" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>MP Position</h5>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-jab" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <h5>MP Position</h5>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-dept" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                
                    // CHARTS
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('mpTotal').getContext("2d");

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

                    ctx = document.getElementById('mpTotal-jab').getContext("2d");

                    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                    gradientStroke.addColorStop(0, '#80b6f4');
                    gradientStroke.addColorStop(1, chartColor);

                    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill.addColorStop(1, "rgba(55, 164, 255,0.4)");

                    gradientFill0 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill0.addColorStop(0, "rgba(255, 135, 132,1)");
                    gradientFill0.addColorStop(1, "rgba(255, 135, 132, 0.1)");

                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(255, 135, 132,1)");
                    gradientFill1.addColorStop(1, "rgba(255, 135, 132, 0.1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(1, 181, 225, 1)");
                    gradientFill2.addColorStop(1, "rgba(1, 181, 225, 0.1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(251, 190, 84, 1)");
                    gradientFill3.addColorStop(1, "rgba(255, 199, 102, 0.1)");

                    gradientFill4 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill4.addColorStop(0, "rgba(122, 206, 149, 1)");
                    gradientFill4.addColorStop(1, "rgba(96, 191, 126, 0.1)");

                    gradientFill5 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill5.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill5.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill6 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill6.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill6.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill7 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill7.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill7.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill8 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill8.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill8.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill9 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill9.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill9.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill10 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill10.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill10.addColorStop(1, "rgba(107, 189, 253, 0.1)");

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
                            $index_jab = 0;
                            $data_ = $array_total_jabatan[0]["TM"];
                            // echo $data_;
                            foreach($data_jabatan AS $data_jabatan){
                                $id_jab = $data_id_jab[$index_jab];
                                $data_mp_jab = '';
                                $index_tgl = 0;
                                foreach($data_tanggal AS $tgl){
                                    if (array_key_exists($id_jab,$array_total_jabatan[$index_tgl])){
                                        $total_mp = $array_total_jabatan[$index_tgl][$id_jab];
                                    }else{
                                        $total_mp = 0;
                                    }
                                    $data_mp_jab .= $total_mp.",";
                                    $index_tgl++;
                                }
                                $id_jab;
                            
                                $data_mp_jab = substr($data_mp_jab, 0, -1);
                                $data = "
                                { 
                                    label: \"$data_jabatan\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill$index_jab,
                                    hoverBorderColor: '#fcc468',
                                    order: 2,
                                    borderWidth: 0,
                                    data: [
                                        $data_mp_jab
                                    ],
                                },
                                ";
                                $index_jab++;
                                echo $data;
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
                            stacked: true,
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
            <script>
                $(document).ready(function(){
                
                // CHARTS
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('mpTotal-dept').getContext("2d");

                    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                    gradientStroke.addColorStop(0, '#80b6f4');
                    gradientStroke.addColorStop(1, chartColor);

                    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill.addColorStop(0, "rgba(55, 164, 255,1)");
                    gradientFill.addColorStop(1, "rgba(55, 164, 255,0.4)");

                    gradientFill0 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill0.addColorStop(0, "rgba(107, 189, 253,1)");
                    gradientFill0.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill1.addColorStop(0, "rgba(255, 135, 132,1)");
                    gradientFill1.addColorStop(1, "rgba(255, 135, 132, 0.1)");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(1, 181, 225, 1)");
                    gradientFill2.addColorStop(1, "rgba(1, 181, 225, 0.1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(251, 190, 84, 1)");
                    gradientFill3.addColorStop(1, "rgba(255, 199, 102, 0.1)");

                    gradientFill4 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill4.addColorStop(0, "rgba(122, 206, 149, 1)");
                    gradientFill4.addColorStop(1, "rgba(96, 191, 126, 0.1)");

                    gradientFill5 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill5.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill5.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill6 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill6.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill6.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill7 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill7.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill7.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill8 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill8.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill8.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill9 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill9.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill9.addColorStop(1, "rgba(107, 189, 253, 0.1)");

                    gradientFill10 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill10.addColorStop(0, "rgba(105, 180, 240, 1)");
                    gradientFill10.addColorStop(1, "rgba(107, 189, 253, 0.1)");

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
                            $index_dept = 0;
                            // $data_ = $array_total_jabatan[0]["TM"];
                            // echo $data_;
                            foreach($data_dept_account  AS $data_dept){
                                $id_dept = $data_id_dept_account[$index_dept];
                                $data_mp_dept = '';
                                $index_tgl = 0;
                                foreach($data_tanggal AS $tgl){
                                    if (array_key_exists($id_dept,$array_total_deptAcc[$index_tgl])){
                                        $total_mp = $array_total_deptAcc[$index_tgl][$id_dept];
                                    }else{
                                        $total_mp = 0;
                                    }
                                    $data_mp_dept .= $total_mp.",";
                                    $index_tgl++;
                                }
                                $id_jab;
                            
                                $data_mp_dept = substr($data_mp_dept, 0, -1);
                                $data = "
                                { 
                                    label: \"$data_dept\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill$index_dept,
                                    hoverBorderColor: '#fcc468',
                                    order: 2,
                                    borderWidth: 0,
                                    data: [
                                        $data_mp_dept
                                    ],
                                },
                                ";
                                $index_dept++;
                                echo $data;
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
