<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 
include("../../config/schedule_system.php"); 

//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
    
    $npk = $_GET['npk'];
    $start = $_GET['start'];
    $end = $_GET['end'];
    $shift = $_GET['shift'];
    $data_tanggal = json_decode(get_date($start, $end));
    $q_work_day = "SELECT count(`date`) AS hari_kerja FROM working_days WHERE `date` BETWEEN '$start' AND '$end' AND shift = '$shift' AND ket = 'DOP' ";
    $sql = mysqli_query($link, $q_work_day)or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($sql);
    $hari_kerja = (isset($data['hari_kerja']))?$data['hari_kerja']:0;
    // print_r($data_tanggal);
    if($_GET['id'] == 'data-absen'){
        ?>

        <div class="table-responsive text-uppercase" >
            <table class="table-sm  table-striped" style="width:100%">
                <thead class="table-info">
                    <tr >
                        <th scope="col" rowspan="2">No</th>
                        <th scope="col" rowspan="2">Hari</th>
                        <th scope="col" rowspan="2">Tanggal</th>                  
                        <th scope="col" colspan="2">Absensi</th>
                        <th scope="col" rowspan="2">Ket</th>
                        <th scope="col" colspan="2">Overtime</th>
                    </tr>
                    <tr>

                    <th scope="col" colspan="1">In</th>
                        <th scope="col" colspan="1">Out</th>
                        <th scope="col" colspan="1">Mulai</th>
                        <th scope="col" colspan="1">Selesai</th>
                    </tr>
                </thead>
                <tbody class="text-nowrap">
                    <?php

                    $no = 1;
                    foreach($data_tanggal AS $date){
                        $clr_data = (strtotime($date) > strtotime(date('Y-m-d')))?'table-danger':'';
                        $absen = mysqli_query($link, "SELECT nama, npk, employee_shift, work_date, check_in, check_out , CODE FROM view_absen_hr WHERE npk = '$npk' AND work_date = '$date'")or die(mysqli_error($link));
                        $origin_query = "SELECT `id_ot`,
                            `npk`,
                            `nama`,
                            `shift`,
                            `sub_post`,
                            `post`,
                            `grp`,
                            `sect`,
                            `dept`,
                            `dept_account`,
                            `division`,
                            `plant`,
                            `work_date`,
                            `in_date`,
                            `out_date`,
                            `start`,
                            `end`,
                            `start_req`,
                            `end_req`,
                            `status_approve`,
                            `status_progress`,
                            CONCAT(`status_approve`, `status_progress`) AS `stats`
                            FROM `view_hr_ot`";
                        $overtime = mysqli_query($link, $origin_query."WHERE npk = '$npk' AND work_date = '$date'")or die(mysqli_error($link));
                        $dataAbsen = mysqli_fetch_assoc($absen);
                        $dataOT = mysqli_fetch_assoc($overtime);

                        $start_req = (isset($dataOT['start_req']) && ($dataOT['start_req'] != "00:00:00"))?jam($dataOT['start_req']):'';
                        $end_req = (isset($dataOT['end_req']) && ($dataOT['end_req'] != "00:00:00"))?jam($dataOT['end_req']):'';
                        // $start_req = (isset($dataOT['start_req']) && ($dataOT['start_req'] == "00:00:00" || $dataOT['start_req'] == "" || $dataOT['start_req'] == NULL))?"":jam($dataOT['start_req']);
                        // $end_req = (isset($dataOT['end_req']) && ($dataOT['end_req'] == "00:00:00" || $dataOT['end_req'] == "" || $dataOT['end_req'] == NULL ))?"":jam($dataOT['end_req']);
                        
                        $startOT = (isset($dataOT['start']) && ($dataOT['start'] != "00:00:00"))?jam($dataOT['start']):$start_req;
                        $endOT = (isset($dataOT['end']) && ($dataOT['end'] != "00:00:00"))?jam($dataOT['end']):$end_req;
                        
                        
                        $code = $dataOT['stats'];
                        if(($dataOT['start'] == '' OR $dataOT['start'] == '00:00:00') && $start_req != ''){
                            // if($start_req != ''){
                            
                            if($code == "75a"){
                                $tb_clr = "text-warning";
                            }else if($code == "50a"){
                                $tb_clr = "text-success";
                            }else if($code == "75a"){
                                $tb_clr = "text-info";
                            }else{
                                $tb_clr = "";
                            }
                            // }else{
                            //     $tb_clr = "";
                            // }
                        }else{
                            $tb_clr = "";
                        }
                        $dataOT = mysqli_fetch_assoc($absen);
                        $check_in = (isset($dataAbsen['check_in']) && ($dataAbsen['check_in'] != "00:00:00"))?jam($dataAbsen['check_in']):'';
                        $check_out = (isset($dataAbsen['check_out']) && ($dataAbsen['check_out'] != "00:00:00"))?jam($dataAbsen['check_out']):'';
                        $hari = hari($date);
                        $clr_libur = ($hari == 'Sabtu' || $hari == 'Minggu')?'table-warning':'';
                        $tanggal = tgl($date);
                        ?>                        

                    
                        <tr class="<?=$clr_libur?> <?=$clr_data?> ">
                        
                            <td><?=$no++?></td>
                            <td><?=$hari?></td>
                            <td><?=$tanggal?></td>
                            <td><?=$check_in?></td>
                            <td><?=$check_out?></td>
                            <td ><?=$dataAbsen['CODE']?></td>
                            <td class="<?=$tb_clr?>"> <?=$startOT?> </td>
                            <td class="<?=$tb_clr?>"> <?=$endOT?> </td>                             							
                        </tr>
                        
                        <?php
                    }
                    

                    
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }else if($_GET['id'] == 'sumary'){
        $queryAbs = mysqli_query($link, "SELECT 
            COUNT(
                IF(`check_in` = '00:00:00' || `check_in` IS NULL ,
                    `check_out`, `check_in` )
            ) AS total_masuk FROM view_absen_hr WHERE npk = '$npk' AND `work_date` BETWEEN '$start' AND '$end'  ")or die(mysqli_error($link));
        $queryOT = mysqli_query($link, "SELECT 
                COUNT(
                    IF(`end` = '00:00:00' || `end` IS NULL ,
                    `end_req`, `end` )
                ) AS total_hari
                FROM `view_hr_ot` WHERE npk = '$npk' AND `work_date` BETWEEN '$start' AND '$end' ")or die(mysqli_error($link));
        $qryJmlOT = mysqli_query($link,"SELECT SUM(over_time) AS jml FROM view_req_ot_bulk  WHERE npk = '$npk' AND `work_date` BETWEEN '$start' AND '$end'
            AND (CONCAT(status_approve, status_progress) = '75a' OR CONCAT(status_approve, status_progress) = '100a' OR CONCAT(status_approve, status_progress) = '50a' )" )or die(mysqli_error($link));
        $dataOT = mysqli_fetch_assoc($qryJmlOT);
        $dataHariOT = mysqli_fetch_assoc($queryOT);
        $dataMasuk = mysqli_fetch_assoc($queryAbs);

        $menitOT = $dataOT['jml'];
        $jmlMasuk = $dataMasuk['total_masuk'];
        $hariOT = $dataHariOT['total_hari'];

        $hours = floor($menitOT / 60);
        $minutes = $menitOT % 60;
        $jmlOT = "$hours jam, $minutes menit";
        ?>
         <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-globe text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                        <p class="card-category">Masuk</p>
                        <p class="card-title"><?=$jmlMasuk?> hari<p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                    <i class="fa fa-refresh"></i>
                    <?=$hari_kerja?> hari produksi
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-globe text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                        <p class="card-category">Overtime</p>
                        <p class="card-title"><?=$jmlOT?> <p>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                    <i class="fa fa-refresh"></i>
                    <?=$hariOT?> hari
                    </div>
                </div>
            </div>
        </div>
        
        <?php
    }
	
} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>