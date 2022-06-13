<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >= 2){
        $req = " AND shift_req = '0' ";
        $start = $_GET['start'] ;
        $end = $_GET['end']  ;
        // echo  $_GET['end'];
        $today = date('Y-m-d');
        
        $part = partAccess($level, "part");
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npkUser);
        
        $array_wait = array();
        $array_approve = array();
        $array_reject = array();
        $array_return = array();
        $array_stop = array();
        $array_proccess = array();
        $array_onl = array();
        $array_success = array();
        $array_tot = array();
        

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
            array_push($array_wait , $wait['jml'] );
            array_push($array_approve , $apprv['jml'] );
            array_push($array_reject , $reject['jml']);
            array_push($array_stop , $stop['jml'] );
            array_push($array_return , $confirm['jml'] );
            array_push($array_proccess , $prcss['jml'] );
            array_push($array_success, $scss['jml'] );
            array_push($array_onl, $onl['jml']);
            array_push($array_tot, $tot_req);
            
            
        }
        print_r($array_proccess);
        
        
        //monitor progress
        
        echo $qryData;
       
        ?>
        <div class="row">
            <div class="col-md-12">
                <h5>Request Overview</h6>
            </div>
            <div class="col-md-12">
                <canvas id="summaryAbsen" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
            </div>
            <div class="col-md-12">
                <h6>Overtime</h6>
            </div>
            <div class="col-md-12">
                <h6>Leave & Permit</h6>
            </div>
            
        </div>
        <script>
                $(document).ready(function(){
                    chartColor = "#FFFFFF";

                    ctx = document.getElementById('summaryAbsen').getContext("2d");

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
                        datasets: [{
                            borderColor: "#6bd098",
                            backgroundColor: "#6bd098",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#f17e5d",
                            backgroundColor: "#f17e5d",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#fcc468",
                            backgroundColor: "#fcc468",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#F05909",
                            backgroundColor: "#F05909",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#E4DD08",
                            backgroundColor: "#E4DD08",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#0879E4",
                            backgroundColor: "#0879E4",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#4BE408",
                            backgroundColor: "#4BE408",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#4BE408",
                            backgroundColor: "#4BE408",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
                        },
                        {
                            borderColor: "#4BE408",
                            backgroundColor: "#4BE408",
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            borderWidth: 3,
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
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
