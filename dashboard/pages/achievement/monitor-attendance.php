<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $_GET['data'] = "mp";
        $_GET['start'] = date('2022-06-01');
        $_GET['end'] = date('2022-06-09');
        if($_GET['data'] == 'mp'){

            $mulai = $_GET['start'] ;
            $selesai = $_GET['end'] ;
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
            // echo $query_req_absensi;
            
            



            $q_dept_account = "SELECT id_dept_account , department_account FROM dept_account ";
            $sql_dept_account = mysqli_query($link, $q_dept_account)or die(mysqli_error($link));


            if(mysqli_num_rows($sql_jabatan)>0){
                while($jab = mysqli_fetch_assoc($sql_jabatan)){
                    array_push($data_jabatan, $jab['jabatan'] );
                    array_push($data_id_jab, $jab['id_jabatan'] );
                }
            }
            
        
                
                
            $i = 0;
            
            foreach( $data_tanggal AS $date){
                list($ket, $shift) = getShiftByTime($link, $date, date('H:i:s'));
                if($shift != ''){
                    $add_shift = " AND ( $shift ) ";
                }else{
                    $add_shift = '';
                }
                // get mp total
                $qry = $qry_area." WHERE part = '$part' AND `date` = '$date' AND id_area = '$data_access'  " ;
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($sql);
                // array_push($data_total, $data['mp'] );

                $addWFO = " AND att_alias = '1' AND (check_in <> '00:00:00' OR  check_out <> '00:00:00' )";
                $addTL = " AND att_alias = '2' ";
                $addT = " AND att_alias = '3' ";
                $addC = " AND att_alias = '4' ";
                $addCL = " AND att_alias = '5' ";
                $addS = " AND att_alias = '6' ";
                $addP = " AND att_alias = '7' ";
                $addWFH = " AND att_alias = '8' ";
                $addM = " AND att_alias = '9' ";
                
                $permit = $addC.$addCL.$addP;
                // echo $query_req_absensi.$addWFO." AND work_date = '$date' ".$add_shift."<br>";
                $sql_wfo = mysqli_query($link, $query_req_absensi.$addWFO." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                $sql_tl = mysqli_query($link, $query_req_absensi.$addTL." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                $sql_t = mysqli_query($link, $query_req_absensi.$addT." AND work_date = '$date' ".$add_shift)or die(mysqli_error($link));
                // $sql_c = mysqli_query($link, $query_req_absensi.$addC." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_cl = mysqli_query($link, $query_req_absensi.$addCL." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_s = mysqli_query($link, $query_req_absensi.$addS." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_p = mysqli_query($link, $query_req_absensi.$addP." AND work_date = '$date' ")or die(mysqli_error($link));
                // $sql_wfh = mysqli_query($link, $query_req_absensi.$addWFH." AND work_date = '$date' ")or die(mysqli_error($link));
                $sql_m = mysqli_query($link, $query_req_absensi.$addM." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                
                $sql_permit = mysqli_query($link, $query_req_absensi.$permit." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                $sql_sakit = mysqli_query($link, $query_req_absensi.$addS." AND work_date = '$date' ".$add_shift )or die(mysqli_error($link));
                
                $data_absensi = mysqli_fetch_assoc($sql_wfo);
                $wfo = $data_absensi['jml'];
                if($data['mp'] > 0 ){
                    if($data['mp'] >= $wfo){
                        $masuk = ($wfo/$data['mp'])*100;
                    }else{
                        $masuk = 100;
                        
                    }
                }else{
                    $masuk = 0;
                }
                
                if($ket == "DOP"){
                    $masuk =$masuk;
                    // echo "tes";
                }else{
                    $masuk = 0;
                }
                array_push($data_total, number_format($masuk,2) );
                // echo $ket.$data['mp']."<br>";

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
                    <canvas id="mpTotal-scheculed" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                </div>
                <div class="col-md-12">
                    <h6>Late Employee Summary</h6>
                </div>
                <div class="col-md-12">
                    <canvas id="mpTotal-late" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
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
            
        <?php
        }
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
