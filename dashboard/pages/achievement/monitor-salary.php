<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $req = " AND shift_req = '0' ";
        $start = $_GET['start'] = '2022-06-01' ;
        $end = $_GET['end']  = '2022-06-30'  ;
        // echo  $_GET['end'];
        $today = date('Y-m-d');
        
        $part = partAccess($level, "part");
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npkUser);
        
        $array_wait = array();
        $array_wait_ot = array();
        $array_approve = array();
        $array_approve_ot = array();
        $array_reject = array();
        $array_reject_ot = array();
        $array_return = array();
        $array_return_ot = array();
        $array_stop = array();
        $array_stop_ot = array();
        $array_proccess = array();
        $array_proccess_ot = array();
        $array_onl = array();
        $array_onl_ot = array();
        $array_success = array();
        $array_success_ot = array();
        $array_tot = array();
        $array_tot_ot = array();
        

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
        
        // echo $shift;
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        $level = $level;
        $npk = $npkUser;

        




        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query_ot = "SELECT COUNT(view_req_ot.npk) AS jml, view_req_ot.id_ot,
            view_req_ot.npk,
            view_req_ot.nama,
            view_req_ot.shift,
            view_req_ot.ot_code,
            view_req_ot.requester,
            view_req_ot.in_date,
            view_req_ot.work_date,
            view_req_ot.start,
            view_req_ot.out_date,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity,
            view_req_ot.status_approve,
            view_req_ot.status_progress,
            view_req_ot.post,
            view_req_ot.grp,
            view_req_ot.sect,
            view_req_ot.dept,
            view_req_ot.dept_account,
            view_req_ot.division,
            view_req_ot.plant, CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) AS `status`
            FROM view_req_ot ";
        $origin_query = "SELECT COUNT(view_absen_req.npk) AS jml, view_absen_req.id_absensi,
            view_absen_req.npk,
            view_absen_req.nama,
            view_absen_req.employee_shift, 
            view_absen_req.grp,
            view_absen_req.dept_account,
            view_absen_req.req_work_date,
            view_absen_req.req_date_in,
            view_absen_req.req_date_out,
            view_absen_req.req_in,
            view_absen_req.req_out,
            view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
            FROM view_absen_req ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        $generate_ot = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $query_req_overtime = filtergenerator($link, $level, $generate_ot, $origin_query_ot, $access_org)." ";

        // echo  $query_req_overtime;

        $exception = " AND `status` <> '100e' AND req_date IS NOT NULL ";
        $filterType = (isset($_GET['att_type']) && $_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$req;
        
        $data_tanggal = json_decode(get_date($start, $end));
        $qryData = $query_req_absensi;
        $tot_req = 0;
        foreach($data_tanggal AS $date){
            
            // total pengajuan , tidak terhitung data yang dari upload migrasi
            $q_reqs = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_work_date = '$date' ";
            $s_reqs = mysqli_query($link, $q_reqs)or die(mysqli_error($link));
            $reqs = mysqli_fetch_assoc($s_reqs);
            $tot_req += $reqs['jml'];
            // pengajuan yang belum diproses spv
            $q_wait = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '25a' AND req_work_date = '$date' ";
            $s_wait = mysqli_query($link, $q_wait)or die(mysqli_error($link));
            $wait = mysqli_fetch_assoc($s_wait);
            // pengajuan yang diapprove spv
            $q_apprv = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '50a' AND req_work_date = '$date' " ;
            $s_apprv = mysqli_query($link, $q_apprv)or die(mysqli_error($link));
            $apprv = mysqli_fetch_assoc($s_apprv);
            // pengajuan yang diproses admin
            $q_prcss = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '75a' AND req_work_date = '$date' ";
            $s_prcss = mysqli_query($link, $q_prcss)or die(mysqli_error($link));
            $prcss = mysqli_fetch_assoc($s_prcss);
            // pengajuan yang sudah selesai
            $q_scss = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100a' AND req_work_date = '$date' ";
            $s_scss = mysqli_query($link, $q_scss)or die(mysqli_error($link));
            $scss = mysqli_fetch_assoc($s_scss);
            // pengajuan yang ditolak spv
            $q_reject = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100b' AND req_work_date = '$date'";
            $s_reject = mysqli_query($link, $q_reject)or die(mysqli_error($link));
            $reject = mysqli_fetch_assoc($s_reject);
            // pengajuan yang dihentikan admin, misal jml pengajuan habis
            $q_stop = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100c' AND req_work_date = '$date'";
            $s_stop = mysqli_query($link, $q_stop)or die(mysqli_error($link));
            $stop = mysqli_fetch_assoc($s_stop);
            // pengajuan yang dikembalikan admin untuk dikonfirmasi tolak atau dihapus foreman
            $q_confirm = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100d' AND req_work_date = '$date' ";
            $s_confirm = mysqli_query($link, $q_confirm)or die(mysqli_error($link));
            $confirm = mysqli_fetch_assoc($s_confirm);
            // pengajuan yang masih dalam status approval online oleh dept head
            $q_onl = $qryData." AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100f' AND req_work_date = '$date' ";
            $s_onl = mysqli_query($link, $q_onl)or die(mysqli_error($link));
            $onl = mysqli_fetch_assoc($s_onl);

            // $sql_waiting = mysqli_query($link, $query_req_absensi." AND work_date = '$date' ")or die(mysqli_error($link));
            $sql_total = mysqli_query($link, $query_req_absensi." AND req_work_date = '$date' ")or die(mysqli_error($link));
            // $data_request = 

            // $d_wait = ()
            // $wt =($wait['jml'] == 0)?'':$wait['jml'];
            // $ap =($apprv['jml'] == 0)?'':$apprv['jml'];
            // $rj =($reject['jml'] == 0)?'':$reject['jml'];
            // $st =($stop['jml'] == 0)?'':$stop['jml'];
            // $cf =($confirm['jml'] == 0)?'':$confirm['jml'];
            // $pr =($prcss['jml'] == 0)?'':$prcss['jml'];
            // $sc =($scss['jml'] == 0)?'':$scss['jml'];
            // $ol =($onl['jml'] == 0)?'':$onl['jml'];

            array_push($array_wait , $wait['jml'] );
            array_push($array_approve , $apprv['jml'] );
            array_push($array_reject , $reject['jml']);
            array_push($array_stop , $stop['jml'] );
            array_push($array_return , $confirm['jml'] );
            array_push($array_proccess , $prcss['jml'] );
            array_push($array_success, $scss['jml'] );
            array_push($array_onl, $onl['jml']);
            array_push($array_tot, $tot_req);
            

            // total pengajuan , tidak terhitung data yang dari upload migrasi
            $q_reqs_ot = $query_req_overtime."  AND work_date = '$date' AND (CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '100e' AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '' )";
            $s_reqs_ot = mysqli_query($link, $q_reqs_ot)or die(mysqli_error($link));
            $reqs_ot = mysqli_fetch_assoc($s_reqs_ot);

            array_push($array_tot_ot, $reqs_ot['jml']);
            // pengajuan yang belum diproses spv
            $q_wait_ot = $query_req_overtime."  AND work_date = '$date'   AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '50a' ";
            $s_wait_ot = mysqli_query($link, $q_wait_ot)or die(mysqli_error($link));
            $wait_ot = mysqli_fetch_assoc($s_wait_ot);
            array_push($array_wait_ot , $wait_ot['jml'] );

            // pengajuan yang diapprove spv
            $q_apprv_ot =  $query_req_overtime."  AND work_date = '$date'  AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '50a' " ;
            $s_apprv_ot = mysqli_query($link, $q_apprv_ot)or die(mysqli_error($link));
            $apprv_ot = mysqli_fetch_assoc($s_apprv_ot);
            // pengajuan yang diproses admin
            $q_prcss_ot =  $query_req_overtime." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '75a' AND work_date = '$date'  ";
            $s_prcss_ot = mysqli_query($link, $q_prcss_ot)or die(mysqli_error($link));
            $prcss_ot = mysqli_fetch_assoc($s_prcss_ot);
            // pengajuan yang sudah selesai
            $q_scss_ot = $query_req_overtime." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100a' AND work_date = '$date'  ";
            $s_scss_ot = mysqli_query($link, $q_scss_ot)or die(mysqli_error($link));
            $scss_ot = mysqli_fetch_assoc($s_scss_ot);
            // pengajuan yang ditolak spv
            $q_reject_ot =  $query_req_overtime." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100b' AND work_date = '$date' ";
            $s_reject_ot = mysqli_query($link, $q_reject)or die(mysqli_error($link));
            $reject_ot = mysqli_fetch_assoc($s_reject_ot);
            // pengajuan yang dihentikan admin, misal jml pengajuan habis
            $q_stop_ot =  $query_req_overtime." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100c' AND work_date = '$date' ";
            $s_stop_ot = mysqli_query($link, $q_stop_ot)or die(mysqli_error($link));
            $stop_ot = mysqli_fetch_assoc($s_stop_ot);
            // pengajuan yang dikembalikan admin untuk dikonfirmasi tolak atau dihapus foreman
            $q_confirm_ot =  $query_req_overtime." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100d' AND work_date = '$date' ";
            $s_confirm_ot = mysqli_query($link, $q_confirm_ot)or die(mysqli_error($link));
            $confirm_ot = mysqli_fetch_assoc($s_confirm_ot);
            // pengajuan yang masih dalam status approval online oleh dept head
            $q_onl_ot =  $query_req_overtime."  AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100f' AND work_date = '$date'";
            $s_onl_ot = mysqli_query($link, $q_onl_ot)or die(mysqli_error($link));
            $onl_ot = mysqli_fetch_assoc($s_onl_ot);


            array_push($array_reject_ot , $reject_ot['jml']);
            array_push($array_stop_ot , $stop_ot['jml'] );
            array_push($array_return_ot , $confirm_ot['jml'] );
            array_push($array_proccess_ot , $prcss_ot['jml'] );
            array_push($array_success_ot, $scss_ot['jml'] );
            array_push($array_onl_ot, $onl_ot['jml']);
            
        }
       
       
        ?>
        <div class="row">
            <div class="col-md-12">
                <h5>Request Overview</h6>
            </div>
            <div class="col-md-12">
                <h6>Leave & Permit</h6>
            </div>
            <div class="col-md-12">
                <canvas id="summaryAbsen" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
            </div>
            <div class="col-md-12">
                <h6>Overtime</h6>
            </div>
            <div class="col-md-12">
                <canvas id="summaryOT" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
            </div>
            
            
        </div>
        <script>
            $(document).ready(function(){
            
                // CHARTS
                chartColor = "#FFFFFF";

                ctx = document.getElementById('summaryOT').getContext("2d");

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
                        
                        
                            { 
                                label: "In Waiting",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill1,
                                hoverBorderColor: '#fcc468',
                                order: 1,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_wait = '';
                                    // $i = 1;
                                    foreach($array_wait_ot AS $total){
                                        $d_wait .= $total.",";
                                    }
                                    $_wait = substr($d_wait, 0, -1);
                                    echo 
                                    "$_wait";
                                    ?>
                                ]
                            },{ 
                                label: "In Approval",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill2,
                                hoverBorderColor: '#fcc468',
                                order: 2,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_approve = '';
                                    // $i = 1;
                                    foreach($array_approve_ot AS $total){
                                        $d_approve .= $total.",";
                                    }
                                    $_approve = substr($d_approve, 0, -1);
                                    echo 
                                    "$_approve";
                                    ?>
                                ]
                            },{ 
                                label: "In Proccess",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill3,
                                hoverBorderColor: '#fcc468',
                                order: 2,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_proccess = '';
                                    // $i = 1;
                                    foreach($array_proccess_ot AS $total){
                                        $d_proccess .= $total.",";
                                    }
                                    $_proccess = substr($d_proccess, 0, -1);
                                    echo 
                                    "$_proccess";
                                    ?>
                                ]
                            },{ 
                                label: "Dept Head Approval",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill4,
                                hoverBorderColor: '#fcc468',
                                order: 4,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_online = '';
                                    // $i = 1;
                                    foreach($array_onl_ot AS $total){
                                        $d_online .= $total.",";
                                    }
                                    $_online = substr($d_online, 0, -1);
                                    echo 
                                    "$_online";
                                    ?>
                                ]
                            },{ 
                                label: "Close / Success",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill5,
                                hoverBorderColor: '#fcc468',
                                order: 5,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_success = '';
                                    // $i = 1;
                                    foreach($array_success_ot AS $total){
                                        $d_success .= $total.",";
                                    }
                                    $_success = substr($d_success, 0, -1);
                                    echo 
                                    "$_success";
                                    ?>
                                ]
                            },{ 
                                label: "Reject By SPV",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill6,
                                hoverBorderColor: '#fcc468',
                                order: 6,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_rjct = '';
                                    // $i = 1;
                                    foreach($array_reject_ot AS $total){
                                        $d_rjct .= $total.",";
                                    }
                                    $_reject = substr($d_rjct, 0, -1);
                                    echo 
                                    "$_reject";
                                    ?>
                                ]
                            },{ 
                                label: "Stop Request",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill7,
                                hoverBorderColor: '#fcc468',
                                order: 7,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_stop = '';
                                    // $i = 1;
                                    foreach($array_stop_ot AS $total){
                                        $d_stop .= $total.",";
                                    }
                                    $_stop = substr($d_stop, 0, -1);
                                    echo 
                                    "$_stop";
                                    ?>
                                ]
                            },{ 
                                label: "Return Request",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill8,
                                hoverBorderColor: '#fcc468',
                                order: 8,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_return = '';
                                    // $i = 1;
                                    foreach($array_return_ot AS $total){
                                        $d_return .= $total.",";
                                    }
                                    $_return = substr($d_return, 0, -1);
                                    echo 
                                    "$_return";
                                    ?>
                                ]
                            },{ 
                                label: "Total Request",
                                type: 'line',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill9,
                                hoverBorderColor: '#fcc468',
                                order: 9,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_total = '';
                                    // $i = 1;
                                    foreach($array_tot_ot AS $total){
                                        $d_total .= $total.",";
                                    }
                                    $_total = substr($d_total, 0, -1);
                                    echo 
                                    "$_total";
                                    ?>
                                ]
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

                ctx = document.getElementById('summaryAbsen').getContext("2d");

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
                        
                        
                            { 
                                label: "In Waiting",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill1,
                                hoverBorderColor: '#fcc468',
                                order: 1,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_wait = '';
                                    // $i = 1;
                                    foreach($array_wait AS $total){
                                        $d_wait .= $total.",";
                                    }
                                    $_wait = substr($d_wait, 0, -1);
                                    echo 
                                    "$_wait";
                                    ?>
                                ]
                            },{ 
                                label: "In Approval",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill2,
                                hoverBorderColor: '#fcc468',
                                order: 2,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_approve = '';
                                    // $i = 1;
                                    foreach($array_approve AS $total){
                                        $d_approve .= $total.",";
                                    }
                                    $_approve = substr($d_approve, 0, -1);
                                    echo 
                                    "$_approve";
                                    ?>
                                ]
                            },{ 
                                label: "In Proccess",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill3,
                                hoverBorderColor: '#fcc468',
                                order: 2,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_proccess = '';
                                    // $i = 1;
                                    foreach($array_proccess AS $total){
                                        $d_proccess .= $total.",";
                                    }
                                    $_proccess = substr($d_proccess, 0, -1);
                                    echo 
                                    "$_proccess";
                                    ?>
                                ]
                            },{ 
                                label: "Dept Head Approval",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill4,
                                hoverBorderColor: '#fcc468',
                                order: 4,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_online = '';
                                    // $i = 1;
                                    foreach($array_onl AS $total){
                                        $d_online .= $total.",";
                                    }
                                    $_online = substr($d_online, 0, -1);
                                    echo 
                                    "$_online";
                                    ?>
                                ]
                            },{ 
                                label: "Close / Success",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill5,
                                hoverBorderColor: '#fcc468',
                                order: 5,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_success = '';
                                    // $i = 1;
                                    foreach($array_success AS $total){
                                        $d_success .= $total.",";
                                    }
                                    $_success = substr($d_success, 0, -1);
                                    echo 
                                    "$_success";
                                    ?>
                                ]
                            },{ 
                                label: "Reject By SPV",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill6,
                                hoverBorderColor: '#fcc468',
                                order: 6,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_rjct = '';
                                    // $i = 1;
                                    foreach($array_reject AS $total){
                                        $d_rjct .= $total.",";
                                    }
                                    $_reject = substr($d_rjct, 0, -1);
                                    echo 
                                    "$_reject";
                                    ?>
                                ]
                            },{ 
                                label: "Stop Request",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill7,
                                hoverBorderColor: '#fcc468',
                                order: 7,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_stop = '';
                                    // $i = 1;
                                    foreach($array_stop AS $total){
                                        $d_stop .= $total.",";
                                    }
                                    $_stop = substr($d_stop, 0, -1);
                                    echo 
                                    "$_stop";
                                    ?>
                                ]
                            },{ 
                                label: "Return Request",
                                type: 'bar',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill8,
                                hoverBorderColor: '#fcc468',
                                order: 8,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_return = '';
                                    // $i = 1;
                                    foreach($array_return AS $total){
                                        $d_return .= $total.",";
                                    }
                                    $_return = substr($d_return, 0, -1);
                                    echo 
                                    "$_return";
                                    ?>
                                ]
                            },{ 
                                label: "Total Request",
                                type: 'line',
                                borderColor: '#fcc468',
                                fill: true,
                                backgroundColor: gradientFill9,
                                hoverBorderColor: '#fcc468',
                                order: 9,
                                borderWidth: 0,
                                data: [
                                    <?php
                                    $d_total = '';
                                    // $i = 1;
                                    foreach($array_tot AS $total){
                                        $d_total .= $total.",";
                                    }
                                    $_total = substr($d_total, 0, -1);
                                    echo 
                                    "$_total";
                                    ?>
                                ]
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
