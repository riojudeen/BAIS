
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/function_status_approve.php");
require_once("../../config/function_access_query.php");
require_once("../../config/function_filter.php");

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Overtime Request";
if(isset($_SESSION['user'])){

    include("../header.php");
    //menghapus session kode lembur
    if(isset($_SESSION['kode-lembur'])){
        unset($_SESSION['kode-lembur']);
    }
    
    $_SESSION['startD'] = (isset($_POST['start']))? dateToDB($_POST['start']) : date('Y-m-01');
    $_SESSION['endD'] = (isset($_POST['end']))? dateToDB($_POST['end']) : date('Y-m-d');

    $sD = $_SESSION['startD'];
    $eD = $_SESSION['endD'];
   
    $tanggalAwal = date('Y-m-d', strtotime($sD));
    // echo "tanggal awal : ".$tanggalAwal."<br>";
    $tanggalAkhir = date('Y-m-d', strtotime($eD));
    // echo "tanggal akhir : ". $tanggalAkhir."<br>";

    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);

    if($sD <= $eD){
        $hari = date_diff($count_awal,$count_akhir)->days +1;
    }else{
        $hari = 0;
    }

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);

    if($role  > 3){
        $clm = "grp";
        $clm2 = "nama_group";
        $clm3 = "id_group";
        $tbl2 = "groupfrm";
        
    }else{
        $clm = "post";
        $clm2 = "nama_pos";
        $clm3 = "id_post";
        $tbl2 = "pos_leader";
    }
    
    $t = "org.".$org_access;
    
    // echo $area;
    $qry_area = "SELECT 
        org.npk AS npk_org,
        org.sub_post AS sub_post,
        org.post AS post,
        org.grp AS grp,
        org.sect AS sect,
        org.dept AS dept,
        org.dept_account AS dept_account,
        org.division AS division,
        org.plant AS plant,

        $tbl2.$clm3 AS id_area,
        $tbl2.$clm2 AS nama_area,

        karyawan.npk AS npk_,
        karyawan.nama AS nama_,
        karyawan.shift AS shift_

        FROM org
        JOIN $tbl2 ON $tbl2.$clm3 = org.$clm
        LEFT JOIN karyawan ON $tbl2.npk_cord = karyawan.npk
        WHERE $t = '$access_' GROUP BY $tbl2.$clm3 ";
// $s_area = fiter_area_request($link, $jabatan, $npkUser);
list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
$kolom = $sub_area_access;
// echo $kolom;
$t = "org.".$org_access;
$_SESSION['area'] = "" ;
$_SESSION['shift'] = "" ;
$_SESSION['sumary'] = "" ;
$index = 0;
if(isset($_POST['area'])){
    
    foreach($_POST['area'] AS $area){
        $_SESSION['area'] .= "OR $kolom = '$area' ";
        $array_area[$index] = $area;
        $index++; 
    }
}else{
    $array_area[$index] = $access_;
    $_SESSION['area'] = "";
}
if(isset($_POST['shift'])){
    foreach($_POST['shift'] AS $shift){
        $_SESSION['shift'] .= "OR karyawan.shift = '$shift' ";
        $array_shift[$index] = $shift;
        $index++; 
    }
}else{
    $array_shift[$index] = '';
    $_SESSION['shift'] = "";
}
if(isset($_POST['sumary'])){
    foreach($_POST['sumary'] AS $sumary){
        $_SESSION['sumary'] .= "OR CONCAT(lembur.status_approve, lembur.status) = '$sumary' ";
        $array_sumary[$index] = $sumary;
        $index++;
    }
}else{
    $array_sumary[$index] = '';
    $_SESSION['sumary'] = "";
}
if(isset($_POST['pencarian'])){
        $_SESSION['pencarian'] = "AND (karyawan.npk LIKE '%$_POST[pencarian]%' OR karyawan.nama LIKE '%$_POST[pencarian]%')";
}else{
    $_SESSION['pencarian'] = "";
}
//filter shift

$jml_query = mysqli_num_rows(table_access($link, $level, 'lembur', $access_ , "AND karyawan.npk = '37290' " ));
$area = ($_SESSION['area'] != '')?" AND (".substr($_SESSION['area'], 2).")":"";
$shift = ($_SESSION['shift'] != '')?" AND (".substr($_SESSION['shift'], 2).")":"";
$progress = ($_SESSION['sumary'] != '')?" AND (".substr($_SESSION['sumary'], 2).")":"";
$cari = ($_SESSION['pencarian'] != '')?"$_SESSION[pencarian]":"";
// echo $shift;
// // print_r($array_shift);
// echo $area;
// echo $progress;
// mysqli_query($link, "DELETE FROM lembur");

$no = 1;
$dataArea = area($link, $level, $access_);
// echo $access_."<br>";
// echo $npkUser."<br>";
// echo $jabatan;

require_once("../../config/calculation/calc_progressReq.php");
    
?>
<form action="req_lembur.php" method="POST">
    <div class="modal fade bd-example-modal-xl" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-left" id="exampleModalLongTitle">Set Record SPL</h5>
                </div>
                <div class="modal-body px-3">
                    <div class="fetched-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            
            </div>
        </div>
    </div>
</form>
<!-- modal tambah -->
    <div class="modal fade bd-example-modal-md" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalgenerate" data-current-step="1">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                    <div id="generate"></div>
            </div>
        </div>
    </div>
<!-- modal tambah -->
<!-- modal lihat data  -->
<form action="proses.php" method="POST">
    <div class="modal fade bd-example-modal-xl" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div id="view_data"></div>
            </div>
        </div>
    </div>
</form>

<form method="POST">
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
                <div class="row">
                    <div class="col-md-3 border-2">
                        <div class="input-group border-2 bg-transparent no-border">
                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <input type="text" name="start" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAwal)?>">
                                
                            <div class="input-group-prepend ml-0 bg-transparent">
                                <div class="input-group-text px-2 bg-transparent">
                                    <i>to</i>
                                </div>
                            </div>
                            <input type="text" name="end" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAkhir)?>">
                            
                            <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                            
                        </div>
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                    <div class="col-md-9 border-2 ">
                        <div class="box float-right">
                            <a href="approval/index.php" type="button" class=" btn btn-default btn-icon btn-round align-center align-bottom generate" data-toggle="modalgenerate" data-target=".bd-example-modal-xl">
                                <span class="btn-label">
                                    <i class="nc-icon nc-minimal-right"></i>
                                </span>
                            </a>
                        </div>
                        <p class="float-right mr-2">
                            <button id="" type="submit" name="cari" class="btn btn-icon btn-default btn-outline-default btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                                <i class="nc-icon nc-zoom-split "> </i>
                            </button>   
                        </p>
                        <div class="mr-2 my-0 py-0 float-right order-1">
                            <div class="input-group bg-transparent">
                                <select type="text" name="sumary[]" class="text-uppercase bg-transparent selectpicker" data-title="Progress" data-style="btn btn-outline-default"  multiple>
                                    <?php
                                    $sumary = array(
                                            array( 'Draft' , '0a'),
                                            array( 'Waiting Approval' , '25a'),
                                            array( 'Disetujui SPV' , '50a'),
                                            array( 'Ditolak SPV' , '50b'),
                                            array( 'Dikembalikan SPV' , '50c'),
                                            array( 'Diproses Admin' , '75a'),
                                            array( 'Ditolak Admin' , '75b'),
                                            array( 'Dikembalikan Admin' , '75c'),
                                            array( 'Pengajuan Dihentikan' , '100b'),
                                            array( 'Close' , '100a')
                                    );
                                    foreach($sumary AS $data){
                                        $select = (in_array($data['1'], $array_sumary))?"selected":"";
                                    ?>
                                        <option <?=$select?> value="<?=$data['1']?>"><?=$data['0']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mr-2 my-0 py-0 float-right order-3">
                            <div class="input-group bg-transparent">
                                <select type="text" name="area[]" class="bg-transparent selectpicker" data-title="filter area" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                <?php  
                                $filterarea = area_jabatan($link, $jabatan, $npkUser);
                                while($dArea = mysqli_fetch_assoc($filterarea)){
                                    $select = (in_array($dArea['id_area'], $array_area))?"selected":"";
                                    ?>
                                        <option <?=$select?> data-subtext="<?=$dArea['nama']?>" value="<?=$dArea['id_area']?>"><?=$dArea['nama_area']?></option>
                                     <?php   
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mr-2 my-0 py-0 float-right order-3 ">
                            <div class="input-group bg-transparent">
                                <select type="text" name="shift[]" class="bg-transparent selectpicker" data-title="shift" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    $sqlShift = mysqli_query($link , "SELECT * FROM shift")or die(mysqli_error($link));
                                    while($dataShift = mysqli_fetch_assoc($sqlShift)){
                                        $select = (in_array($dataShift['id_shift'], $array_shift))?"selected":"";
                                        ?>
                                        <option <?=$select?> value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</form>

<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <div class="pull-left">
                    <h5 class="card-title">Progress Pengajuan Lembur</h5>
                    <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                </div>
                <div class="box pull-right">
                    <button type="button" class="btn btn-default align-center align-bottom generate" data-toggle="modalgenerate" data-target=".bd-example-modal-xl">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>
                            Add Request
                    </button>
                    <button class="btn btn-danger deleteall">
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove"></i> 
                        </span>
                        Delete
                    </button>
                    <button class="btn btn-success requestall">
                        <span class="btn-label">
                            <i class="nc-icon nc-send"></i> 
                        </span>
                        Submit Request
                    </button>
                    <div class="stats">
                        <i class=""></i>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <form action="" method="post">
                    <div class="my-2 mr-2 float-right order-3">
                        <div class="input-group bg-transparent">
                            <input type="text" name="pencarian" class="form-control bg-transparent" placeholder="Cari nama atau npk..">
                            <div class="input-group-append bg-transparent">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form name="proses" method="POST">
                    <div class="table-responsive" style="height:200">
                        <table class="table text-uppercase table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">No Surat</th>
                                    <th scope="col">Hari</th> 
                                    <th scope="col">Tanggal</th>                                
                                    <th scope="col">Total</th>
                                    <th scope="col">Progress</th>
                                    
                                    <th scope="col" colspan="2">Status</th>
                                    <th scope="col">Action</th>
                                    
                                    <th scope="col">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input class="form-check-input " id="allreq" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
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
                                    lembur._id AS id_ot,
                                    lembur.kode_lembur AS ot_code, 
                                    lembur.requester AS requester,
                                    lembur.in_date AS in_date, 
                                    lembur.work_date AS work_date, 
                                    lembur.in_lembur AS `start`, 
                                    lembur.out_date AS out_date, 
                                    lembur.out_lembur AS `end`,
                                    lembur.kode_job AS job_code,
                                    lembur.aktifitas AS activity, 
                                    lembur.status_approve AS status_approve, 
                                    lembur.status AS status_progress,

                                    -- hr_lembur.date AS id_ot_hr,
                                    -- hr_lembur.in_date AS in_date_hr,
                                    -- hr_lembur.out_date AS out_date_hr,
                                    -- hr_lembur.start AS start_hr,
                                    -- hr_lembur.end AS end_hr,

                                    org.sub_post AS sub_post,
                                    org.post AS post,
                                    org.grp AS grp,
                                    org.sect AS sect,
                                    org.dept AS dept,
                                    org.dept_account AS dept_account,
                                    org.division AS division,
                                    org.plant AS plant,

                                    karyawan.npk AS npk_,
                                    karyawan.nama AS nama_,
                                    karyawan.shift AS shift_

                                    FROM lembur
                                    JOIN org ON org.npk = lembur.npk
                                    JOIN karyawan ON karyawan.npk = lembur.npk";

                                    $qry_ = "SELECT 
                                        lembur._id AS id_lembur,
                                        lembur.kode_lembur AS kode_lembur, 
                                        lembur.requester AS requester,
                                        lembur.npk AS npk_lembur, 
                                        lembur.in_date AS inDate_lembur, 
                                        lembur.out_date AS outDate_lembur, 
                                        lembur.in_lembur AS in_lembur, 
                                        lembur.work_date AS work_date, 
                                        lembur.out_lembur AS out_lembur,
                                        lembur.kode_job AS kode_job,
                                        lembur.aktifitas AS aktivity, 
                                        lembur.status_approve AS status_approve, 
                                        lembur.status AS status_lembur,

                                        org.npk AS npk_org,
                                        org.sub_post AS sub_post,
                                        org.post AS post,
                                        org.grp AS grp,
                                        org.sect AS sect,
                                        org.dept AS dept,
                                        org.dept_account AS dept_account,
                                        org.division AS division,
                                        org.plant AS plant,

                                        karyawan.npk AS npk_,
                                        karyawan.nama AS nama_,
                                        karyawan.shift AS shift_

                                        FROM lembur
                                        JOIN org ON org.npk = lembur.npk
                                        JOIN karyawan ON karyawan.npk = lembur.npk
                                        
                                        WHERE lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $area_access = '$value_access' AND CONCAT(lembur.status_approve, lembur.status) <> '100c' $area $shift $progress $cari";

                                    $qry_lembur = $qry_." GROUP BY lembur.kode_lembur  ORDER BY lembur.kode_lembur, lembur.status_approve, lembur.status, lembur.in_date DESC";

                                    $sql_lembur = mysqli_query($link, $qry_lembur)or die(mysqli_error($link));

                                    $total_req = mysqli_num_rows($sql_lembur);
                                    if($total_req > 0){
                                        while($data_spl = mysqli_fetch_assoc($sql_lembur)){
                                            $kode_lembur = $data_spl['kode_lembur'];
                                            $collect_spl = mysqli_query($link, $qry_." AND lembur.kode_lembur = '$kode_lembur' ")or die(mysqli_error($link));

                                            $s_max = mysqli_query($link, "SELECT max(lembur.status_approve) AS data_max,
                                                
                                                karyawan.npk AS npk_,
                                                karyawan.nama AS nama_,
                                                karyawan.shift AS shift_
                                                
                                                FROM lembur 
                                                JOIN org ON org.npk = lembur.npk
                                                JOIN karyawan ON org.npk = karyawan.npk

                                                WHERE lembur.in_date BETWEEN '$tanggalAwal'
                                                AND '$tanggalAkhir' AND lembur.kode_lembur = '$kode_lembur' 
                                                AND $area_access = '$value_access'
                                                $area $shift $progress $cari
                                                ")or die(mysqli_error($link));

                                            $d_max = mysqli_fetch_assoc($s_max);

                                            $data_req = mysqli_fetch_assoc($collect_spl);
                                            $total_req =  mysqli_num_rows($collect_spl);
                                            $requester = $data_spl['requester'];

                                            $status = sumary($d_max['data_max'], $d_max['data_max'], 'status');
                                            $color = sumary($d_max['data_max'], $d_max['data_max'], 'color');
                                            $persen = $d_max['data_max']."%";
                                            
                                            echo "<tr class=\"text-nowrap\" id=\"".$data_spl['kode_lembur']."\"><td>".$no++. "</td>";
                                            echo "<td class=\"text-nowrap\">".$data_spl['kode_lembur']."</td>";
                                            echo "<td class=\"text-nowrap\">".hari($data_spl['work_date'])."</td>";
                                            echo "<td class=\"text-nowrap\">".DBtoForm($data_spl['work_date'])."</td>";
                                            echo "<td class=\"text-nowrap\">".$total_req."</td>";
                                            ?>
                                            

                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-animated progress-bar-<?=$color?> progress-bar-striped" role="progressbar" style="width: <?=$persen?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?=$color?>"><?=$status?></span>
                                        </td>
                                        <td class="text-nowrap">
                                            <!-- <span class="badge badge-pill badge-<?=$color?>"> -->
                                                <?php
                                                $q_summaryStatus = mysqli_query($link, $qry_." AND lembur.kode_lembur = '$kode_lembur' $area $shift $progress $cari GROUP BY lembur.status_approve ")or die(mysqli_error($link));
                                                while($data_SumaryStatus = mysqli_fetch_assoc($q_summaryStatus)){
                                                    
                                                    $q_summary = mysqli_query($link, $qry_." AND lembur.kode_lembur = '$kode_lembur' 
                                                    AND lembur.status_approve = '$data_SumaryStatus[status_approve]' 
                                                    AND CONCAT(lembur.status_approve, lembur.status) <> '100c' $area $shift $progress $cari GROUP BY lembur.status")or die(mysqli_error($link));
                                                    
                                                    while($dataSumary = mysqli_fetch_assoc($q_summary)){
                                                        $sql_sumary = mysqli_query($link, $qry_." AND kode_lembur = '$kode_lembur'
                                                        AND lembur.status_approve = '$dataSumary[status_approve]' 
                                                        AND lembur.status = '$dataSumary[status_lembur]' 
                                                        AND CONCAT(lembur.status_approve, lembur.status) <> '100c' $area $shift $progress $cari")or die(mysqli_error($link));
                                                        $jmlSumary = mysqli_num_rows($sql_sumary);

                                                        $dataStatus = $dataSumary['status_approve'].$dataSumary['status_lembur'];
                                                        $info = sumary($dataSumary['status_approve'], $dataSumary['status_lembur'] , 'info');
                                                        $color = sumary($dataSumary['status_approve'], $dataSumary['status_lembur'], 'color');
                                                        
                                                        ?>
                                                        <div class="text-<?=$color?>"><?=$jmlSumary?> <?=$info?></div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            <!-- </span>                                  -->
                                        </td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-success btn-simple btn-icon btn-round  btn-sm view_data" type="button" >
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <?php
                                            if($level > 0 && $progress > 0){
                                                $tbl = "disabled";
                                            }else{
                                                $tbl = "";
                                            }
                                            ?>
                                            <a href="proses/ot_delete.php?kl=<?=$data_req['kode_lembur']?>" type="button" <?=$tbl?> class="btn btn-danger btn-simple btn-round btn-icon btn-sm hapus">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                            
                                        <td>
                                            <?php
                                            if($progress == 0){
                                                ?>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input req" type="checkbox" value="<?=$data_req['kode_lembur']?>" name="mpchecked[]">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="form-check disabled">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" value="<?=$data_req['kode_lembur']?>" name="mpchecked[]">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                        echo "<tr><td class=\"text-center\" colspan=\"10\">tidak ada data pengajuan</td></tr>";
                                    }

                                    ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
               
            </div>
        </div>
    </div>
</div>





    <?php
//footer
    include_once("../footer.php");
    ?>
<script type="text/javascript">
    
    $('.hapus').on('click', function(e){
	    e.preventDefault();
        var getLink = $(this).attr('href');
        var id = $(this).parents("tr").attr("id");
         
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "SPL dengan No Surat : " + id +" akan dihapus secara permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                window.location.href = getLink;
            }
        })
        
    });
    
</script>


<script type="text/javascript">
   $(function () {
       $('#DateTimePicker1').datetimepicker({format: 'YYYY-MM-DD'});
       $('#DateTimePicker2').datetimepicker({format: 'YYYY-MM-DD',
        useCurrent: true //Important! See issue #1075     
   });
       $("#DateTimePicker1").on("dp.change", function (e) {
           $('#DateTimePicker2').data("DateTimePicker").minDate(e.date);
       });
       $("#DateTimePicker2").on("dp.change", function (e) {
           $('#DateTimePicker1').data("DateTimePicker").maxDate(e.date);
       });
   });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });
})
</script>




<!-- ajax untuk modal -->
<script type="text/javascript">
    $(document).ready(function(){

		$('.generate').click(function(){

			var id = $(this).attr("id");
			$.ajax({
				url: 'generate.php',
				method: 'post',	
				data: {id:id},		
				success:function(data){	
					$('#generate').html(data);	
					$('#modalgenerate').modal("show");
				}
			});
		});
	});

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'ajax/set_record.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);
                }
            });
         });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
		$('.view_data').click(function(e){
            e.preventDefault();
			var id = $(this).parents("tr").attr("id");
			
			
			$.ajax({
				url: 'lookup/view.php',	
				method: 'post',		
				data: {id:id},		
				success:function(data){		
					$('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
					$('#myView').modal("show");	// menampilkan dialog modal nya
				}
			});
		});
	});

</script>
<script>
    $(document).ready(function(){
        $('#allreq').on('click', function() {
            if(this.checked){
                $('.req').each(function() {
                    this.checked = true;
                })
            } else {
                $('.req').each(function() {
                    this.checked = false;
                })
            }

        });

        $('.req').on('click', function() {
            if($('.req:checked').length == $('.req').length){
                $('#allreq').prop('checked', true)
            } else {
                $('#allreq').prop('checked', false)
            }
        })
    })
</script>
<script>
$(document).ready(function() {
    $('#modalgenerate').modalWizard().on('submit', function (e) {
        // alert('submited');
        Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: 'Surat Pengajuan berhasil Dibuat!'
        });
        $(this).trigger('reset');
        $(this).modal('hide');
    });
});
</script>
<script>
    //untuk crud masal update department
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'mass_del.php';
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Semua data yang dicheck / centang akan dihapus permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                document.proses.action = getLink;
                document.proses.submit();
            }
        })
        
    });
    $('.requestall').on('click', function(e){
        e.preventDefault();
        var getLink = 'mass_req.php';

        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Semua data yang dicheck / centang akan disubmit",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#6BD098',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, Process!'
        }).then((result) => {
            if (result.value) {
                document.proses.action = getLink;
                document.proses.submit();
            }
        })
    });
    
</script>
    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }

  

