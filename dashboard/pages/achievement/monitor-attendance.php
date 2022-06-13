<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $_GET['data'] = "mp";
        
        if($_GET['data'] == 'mp'){

            $mulai = $_GET['start'] ;
            $selesai = $_GET['end']  ;
            // echo  $_GET['end'];
            $today = date('Y-m-d');
            
            $part = partAccess($level, "part");
            $access_org = orgAccess($level);
            $data_access = generateAccess($link,$level,$npkUser);
            // echo $data_access ;

            $data_tanggal = json_decode(get_date($mulai, $selesai));
            $filter_date = '';
            
            $data_area= array(); 
            $data_total = array(); 
            $data_ijin = array(); 
            $data_telat = array(); 
            $data_mangkir = array(); 
            $data_schedule = array(); 


            $qry_area = "SELECT SUM(mp) AS mp , id_area, id_jabatan, nama_area, id_dept_account FROM karyawan_record";
            $qry_jabatan = "SELECT id_jabatan, jabatan FROM jabatan";
            $sql_jabatan = mysqli_query($link, $qry_jabatan)or die(mysqli_error($link));

            

            // data absens
            $_GET['prog'] = '';
            // $_GET['cari'] = '';
            $_GET['att_type'] = '';
            
            // echo $start;
            $div_filter = $_GET['div_id'] = '';
            // echo $div;
            $dept_filter = $_GET['dept_id'] = '';
            // echo $dept_filter;
            $sect_filter = $_GET['section_id'] = '';
            // echo $sect_filter;
            $group_filter = $_GET['group_id'] ='';
            // echo $group_filter;
            $deptAcc_filter = $_GET['deptAcc_id'] = '';
            // echo $deptAcc_filter;
            $shift = $_GET['shift'] = '';
            // echo $shift;
            $cari = (isset($_GET['cari']))?$_GET['cari']:'';
            // echo $cari;
            $level = $level;
            $npk = $npkUser;
            $data_tanggal = json_decode(get_date($mulai, $selesai));
            
            list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
            

            $origin_query = "SELECT COUNT(npk) AS jml, work_date
                FROM view_absen_hr ";
            $access_org = orgAccess($level);
            $data_access = generateAccess($link,$level,$npk);
            $table = partAccess($level, "table");
            $field_request = partAccess($level, "field_request");
            $table_field1 = partAccess($level, "table_field1");
            $table_field2 = partAccess($level, "table_field2");
            $part = partAccess($level, "part");
            $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
            $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
            
            // view_absen_hr.req_in IS NULL OR view_absen_hr.req_out IS NULL OR view_absen_hr.req_code IS NULL OR view_absen_hr.att_alias = '9'
            $filter_cari = ($add_filter != '')?"( $add_filter)":'';
            // echo $filter_cari;
            $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
            // list($status, $req_status) = pecahProg("$_GET[prog]");
            $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
            $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org);
            echo $query_req_absensi;
            "SELECT
            `bais_db`.`absensi`.`id` AS `id_absensi`,
            `bais_db`.`absensi`.`npk` AS `npk`,
            `bais_db`.`karyawan`.`nama` AS `nama`,
            `bais_db`.`karyawan`.`shift` AS `employee_shift`,
            `bais_db`.`org`.`sub_post` AS `sub_post`,
            `bais_db`.`org`.`post` AS `post`,
            `bais_db`.`org`.`grp` AS `grp`,
            `bais_db`.`org`.`sect` AS `sect`,
            `bais_db`.`org`.`dept` AS `dept`,
            `bais_db`.`org`.`dept_account` AS `dept_account`,
            `bais_db`.`org`.`division` AS `division`,
            `bais_db`.`org`.`plant` AS `plant`,
            `bais_db`.`absensi`.`shift` AS `att_shift`,
            `bais_db`.`absensi`.`date` AS `work_date`,
            `bais_db`.`absensi`.`check_in` AS `check_in`,
            `bais_db`.`absensi`.`check_out` AS `check_out`,
            `bais_db`.`absensi`.`ket` AS `CODE`,
            `bais_db`.`attendance_code`.`keterangan` AS `keterangan`,
            `bais_db`.`attendance_code`.`type` AS `att_type`,
            `bais_db`.`attendance_code`.`alias` AS `att_alias`
        FROM
            (
                (
                    (
                        `bais_db`.`absensi`
                    JOIN `bais_db`.`org` ON
                        (
                            `bais_db`.`absensi`.`npk` = `bais_db`.`org`.`npk`
                        )
                    )
                LEFT JOIN `bais_db`.`karyawan` ON
                    (
                        `bais_db`.`org`.`npk` = `bais_db`.`karyawan`.`npk`
                    )
                )
            LEFT JOIN `bais_db`.`attendance_code` ON
                (
                    `bais_db`.`attendance_code`.`kode` = `bais_db`.`absensi`.`ket`
                )
            )";
            
            "SELECT
            `bais_db`.`absensi`.`id` AS `id_absensi`,
            `bais_db`.`absensi`.`npk` AS `npk`,
            `bais_db`.`karyawan`.`nama` AS `nama`,
            `bais_db`.`karyawan`.`shift` AS `employee_shift`,
            `bais_db`.`org`.`sub_post` AS `sub_post`,
            `bais_db`.`org`.`post` AS `post`,
            `bais_db`.`org`.`grp` AS `grp`,
            `bais_db`.`org`.`sect` AS `sect`,
            `bais_db`.`org`.`dept` AS `dept`,
            `bais_db`.`org`.`dept_account` AS `dept_account`,
            `bais_db`.`org`.`division` AS `division`,
            `bais_db`.`org`.`plant` AS `plant`,
            `bais_db`.`absensi`.`shift` AS `att_shift`,
            `bais_db`.`absensi`.`date` AS `work_date`,
            `bais_db`.`absensi`.`check_in` AS `check_in`,
            `bais_db`.`absensi`.`check_out` AS `check_out`,
            `bais_db`.`absensi`.`ket` AS `CODE`,
            `req_absensi`.`req_date` AS `req_date`,
            `req_absensi`.`keterangan` AS `req_code`,
            `bais_db`.`attendance_code`.`keterangan` AS `keterangan`,
            `bais_db`.`attendance_code`.`type` AS `att_type`,
            `bais_db`.`attendance_code`.`alias` AS `att_alias`, 
            
            IF(req_absensi.req_date <= req_absensi.date , '1', '0' 
            ) AS `schedule`

            
        FROM `bais_db`.`absensi`
                    JOIN `bais_db`.`org` ON `bais_db`.`absensi`.`npk` = `bais_db`.`org`.`npk`
                       LEFT JOIN `bais_db`.`karyawan` ON `bais_db`.`org`.`npk` = `bais_db`.`karyawan`.`npk`
                   LEFT JOIN `bais_db`.`attendance_code` ON `bais_db`.`attendance_code`.`kode` = `bais_db`.`absensi`.`ket`
               LEFT JOIN (
                SELECT * FROM req_absensi WHERE (keterangan <> 'SKTA' OR  keterangan <> 'SHIFT') AND shift_req <> '1' 
               ) req_absensi ON  req_absensi.id = absensi.id
               ";


            $q_dept_account = "SELECT id_dept_account , department_account FROM dept_account ";
            $sql_dept_account = mysqli_query($link, $q_dept_account)or die(mysqli_error($link));


           
            
        
                
                
            $i = 0;
            
            foreach( $data_tanggal AS $date){
                $hariIni = strtotime(date('Y-m-d'));
                $date_str = strtotime($date);
                list($ket, $shift) = getShiftByTime($link, $date, date('H:i:s'));
                if($date_str == $hariIni ){
                    if($shift != ''){
                        $add_shift = " AND ( $shift ) ";
                    }else{
                        $add_shift = '';
                    }
                }else{
                    $add_shift = '';
                }
                
                
                // get mp total
                $qry = $qry_area." WHERE part = '$part' AND `date` = '$date' AND id_area = '$data_access'  " ;
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($sql);
                // array_push($data_total, $data['mp'] );

                $addWFO = " AND (( att_alias = '1' AND (check_in <> '00:00:00' OR  check_out <> '00:00:00' )) OR att_alias = '2' OR att_alias = '3')";
                $addTL = " AND att_alias = '2' ";
                $addT = " AND att_alias = '3' ";
                $addC = " AND (att_alias = '4'  OR att_alias = '5'  OR att_alias = '6'  OR att_alias = '7'  OR att_alias = '8' )";
                $addSchedule = " AND schedule = '1' ";

                $addM = " AND att_alias = '9' ";
                
                $permit = $addC;
                // echo $query_req_absensi.$addWFO.$addTL.$addT." AND work_date = '$date' ".$add_shift."<br>";
                $sql_wfo = mysqli_query($link, $query_req_absensi.$addWFO." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                $sql_schedule = mysqli_query($link, $query_req_absensi.$addWFO." AND work_date = '$date' ".$add_shift.$addSchedule)or die(mysqli_error($link));
                // $sql_tl = mysqli_query($link, $query_req_absensi.$addTL." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                $sql_t = mysqli_query($link, $query_req_absensi.$addT." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                // $sql_c = mysqli_query($link, $query_req_absensi.$addC." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_cl = mysqli_query($link, $query_req_absensi.$addCL." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_s = mysqli_query($link, $query_req_absensi.$addS." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_p = mysqli_query($link, $query_req_absensi.$addP." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_wfh = mysqli_query($link, $query_req_absensi.$addWFH." AND work_date = '$date' ")or die(mysqli_error($link));
                $sql_m = mysqli_query($link, $query_req_absensi.$addM." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                
                $sql_permit = mysqli_query($link, $query_req_absensi.$permit." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                // $sql_sakit = mysqli_query($link, $query_req_absensi.$addS." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                
                $data_absensi = mysqli_fetch_assoc($sql_wfo);
                $data_permit = mysqli_fetch_assoc($sql_permit);
                $d_telat = mysqli_fetch_assoc($sql_t);
                $d_mangkir = mysqli_fetch_assoc($sql_m);
                $d_sch = mysqli_fetch_assoc($sql_schedule);


                $wfo = $data_absensi['jml'];
                $schedule = $d_sch['jml'];
                $permit = $data_permit['jml']-$d_sch['jml'];
                $telat = $d_telat['jml'];
                $mangkir = $d_mangkir['jml'];

                
                if($data['mp'] > 0 ){
                    if($data['mp'] >= $wfo){
                        $masuk = ($wfo/$data['mp'])*100;
                       
                    }else{
                        $masuk = 100;
                    }
                    $telat = $telat;

                }else{
                    $masuk = 0;
                    $telat = 0;
                    
                }
                
                if($ket == "DOP"){
                    $masuk =$masuk;
                    $permit =$permit;
                    $telat = $telat;
                    $mangkir = $mangkir;
                    $sch = $schedule;
                    // echo "tes";
                }else{
                    $masuk = 0;
                    $permit = 0;
                    $telat = 0;
                    $mangkir = 0;
                    $sch = 0;
                }
                array_push($data_total, number_format($masuk,2) );
                array_push($data_ijin, $permit );
                array_push($data_telat,$telat );
                array_push($data_mangkir, $mangkir );
                array_push($data_schedule, $sch );
                // echo $date."-".$ket."-".$wfo."-".$permit."-".$telat."-".$mangkir."<br>";

            }
            
            
            ?>
            <div class="row">
                <div class="col-md-7">
                    <h5 class="">Attendance Rate </h5>
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
                    <h6>Scheduled Leave & Permit</h6>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-scheduled" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <h6>Late Employee Summary</h6>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-late" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <h6>Absent Employee Summary</h6>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-mangkir" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <canvas id="mp-telat" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <canvas id="chartHours" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script> -->
<!-- <canvas id="myChart"></canvas> -->

            </div>
            <script>
                $(document).ready(function(){
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('chartHours').getContext("2d");

                    myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
                        datasets: [{
                            borderColor: "#6bd098",
                            backgroundColor: "#6bd098",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
                            data: [300, 310, 316, 322, 330, 326, 333, 345, 338, 354]
                        },
                        {
                            borderColor: "#f17e5d",
                            backgroundColor: "#f17e5d",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
                            data: [320, 340, 365, 360, 370, 385, 390, 384, 408, 420]
                        },
                        {
                            borderColor: "#fcc468",
                            backgroundColor: "#fcc468",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
                            data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 484]
                        }
                        ]
                    },
                    options: {

                        legend: {

                        display: false
                        },

                        tooltips: {
                        enabled: false
                        },

                        scales: {
                        yAxes: [{

                            ticks: {
                            fontColor: "#9f9f9f",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            //padding: 20
                            },
                            gridLines: {
                            drawBorder: false,
                            zeroLineColor: "transparent",
                            color: 'rgba(255,255,255,0.05)'
                            }

                        }],

                        xAxes: [{
                            barPercentage: 1.6,
                            gridLines: {
                            drawBorder: false,
                            color: 'rgba(255,255,255,0.1)',
                            zeroLineColor: "transparent",
                            display: false,
                            },
                            ticks: {
                            padding: 20,
                            fontColor: "#9f9f9f"
                            }
                        }]
                        },
                    }
                    });

                })
            </script>
            <script>
                $(document).ready(function(){
                    var labels = ['2018-12-20 14:00', '2018-12-20 15:00', '2018-12-20 16:00', '2018-12-20 17:00', '2018-12-20 18:00', '2018-12-20 19:00', '2018-12-20 23:00','2018-12-20 14:00', '2018-12-20 15:00', '2018-12-20 16:00', '2018-12-20 17:00', '2018-12-20 18:00', '2018-12-20 19:00', '2018-12-20 23:00'];
                        var data = [256,24,14,12,154,123,23,254,145,123,11,255];

                        var ctx = document.getElementById("mp-telat").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Tickets selling',
                                    data: data,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 20,
                                        maxRotation: 0,
                                    },
                                    type: 'time',
                                    time: {
                                        unit: 'hour',
                                        displayFormats: {
                                            hour: 'HH:mm'
                                        }
                                    }
                                    }]
                                },
                            }
                        });


                    // var s1 = {
                    // label: 'Nama Karyawan',
                    // borderColor: '#335e5',
                    // data: [{
                    //         x: '2017-01-06 00:00:30',
                    //         y: '2017-01-06 04:15:30'
                    //     },
                    //     {
                    //         x: '2017-01-07 00:00:00',
                    //         y: '2017-01-07 07:39:30'
                    //     },
                    //     {
                    //         x: '2017-01-08 00:00:00',
                    //         y: '2017-01-08 06:39:30'
                    //     },
                    //     {
                    //         x: '2017-01-09 00:00:00',
                    //         y: '2017-01-09 08:00:30'
                    //     },
                    //     {
                    //         x: '2017-01-10 00:00:00',
                    //         y: '2017-01-10 05:39:30'
                    //     }
                    // ]
                    // };
                    // var s2 = {
                    // label: 'Nama Karyawan',
                    // borderColor: '#335e5',
                    // data: [{
                    //         x: '2017-01-06 00:00:00',
                    //         y: '2017-01-06 04:16:30'
                    //     },
                    //     {
                    //         x: '2017-01-07 00:00:00',
                    //         y: '2017-01-07 08:39:30'
                    //     },
                    //     {
                    //         x: '2017-01-08 00:00:00',
                    //         y: '2017-01-08 13:39:30'
                    //     },
                    //     {
                    //         x: '2017-01-09 00:00:00',
                    //         y: '2017-01-09 20:00:30'
                    //     },
                    //     {
                    //         x: '2017-01-10 00:00:00',
                    //         y: '2017-01-10 05:39:30'
                    //     }
                    // ]
                    // };
                    // var ctx = document.getElementById('mp-telat').getContext('2d');
                    // var chart = new Chart(ctx, {
                    // type: 'line',
                    // data: {
                    //     datasets: [s1,s2]
                    // },
                    // options: {
                    //     legend: {
                    //     display: false
                    //     },
                    //     scales: {
                    //     xAxes: [{
                    //         type: 'time',
                    //         weight: 0,
                    //         time: {
                    //         unit: 'day'
                    //         }
                    //     }],
                    //     yAxes: [{
                    //         type: 'time',
                    //         time: {
                    //         unit: 'hour'
                    //         },
                    //         ticks: {
                    //         // reverse: true,
                    //         beginAtZero: true
                    //         }
                    //     }]
                    //     }
                    // }
                    // });

                    // chart.canvas.parentNode.style.height = '380px';
                    // chart.canvas.parentNode.style.width = '700px';
                })
            </script>
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
                                    label: \"Attendance Rate\",
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

                    ctx = document.getElementById('mpTotal-scheduled').getContext("2d");

                    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill2.addColorStop(0, "rgba(2, 209, 140, 1)");
                    gradientFill2.addColorStop(1, "rgba(2, 209, 140, 0.1)");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(0, 161, 254, 1)");
                    gradientFill3.addColorStop(1, "rgba(0, 161, 254, 0.1)");
                    

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
                                $ijin = '';
                                $schedule = '';
                                foreach($data_ijin AS $total){
                                    $ijin .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $ijin = substr($ijin, 0, -1);
                                
                                foreach($data_schedule AS $total){
                                    $schedule .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $schedule = substr($schedule, 0, -1);
                                
                                echo 
                                "{ 
                                    label: \"Leave & Permit\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill2,
                                    hoverBorderColor: '#fcc468',
                                    order: 1,
                                    borderWidth: 0,
                                    data: [
                                    $ijin
                                    ],
                                },";
                                echo 
                                "{ 
                                    label: \"Scheduled\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill3,
                                    hoverBorderColor: '#fcc468',
                                    order: 2,
                                    borderWidth: 0,
                                    data: [
                                    $schedule
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

                    ctx = document.getElementById('mpTotal-late').getContext("2d");

                    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
                    gradientFill3.addColorStop(0, "rgba(255, 171, 56, 1)");
                    gradientFill3.addColorStop(1, "rgba(255, 171, 56, 0.1)");

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
                                $telat = '';
                                // echo count($data_telat);
                                foreach($data_telat AS $d_telat){
                                    $telat .= $d_telat.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $d_telat = substr($telat, 0, -1);
                                
                                echo 
                                "{ 
                                    label: \"Telat\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill3,
                                    hoverBorderColor: '#fcc468',
                                    order: $no,
                                    borderWidth: 0,
                                    data: [
                                    $d_telat
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

                    ctx = document.getElementById('mpTotal-mangkir').getContext("2d");

                    
                    gradientFill4 = ctx.createLinearGradient(255, 110, 81, 200);
                    gradientFill4.addColorStop(0, "rgba(255, 110, 81, 1)");
                    gradientFill4.addColorStop(1, "rgba(255, 110, 81, 0.1)");

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
                                $mangkir = '';
                                foreach($data_mangkir AS $total){
                                    $mangkir .= $total.",";
                                    // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
                                }
                                $mangkir = substr($mangkir, 0, -1);
                                
                                echo 
                                "{ 
                                    label: \"Mangkir\",
                                    type: 'bar',
                                    borderColor: '#fcc468',
                                    fill: true,
                                    backgroundColor: gradientFill4,
                                    hoverBorderColor: '#fcc468',
                                    order: $no,
                                    borderWidth: 0,
                                    data: [
                                    $mangkir
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
            
        <?php
        }
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
