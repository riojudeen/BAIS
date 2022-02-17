<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitor Request Absensi";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    include("../../config/approval_system.php");
    if($level >=1 && $level <=8){
        // mysqli_query($link, "DELETE FROM req_absensi");
        $_SESSION['tahunnn'] = (isset($_SESSION['thn']))? $_SESSION['thn']: date('Y');

        $_SESSION['thn'] = (isset($_GET['tahun']))? $_GET['tahun'] : $_SESSION['tahunnn'];
        $_SESSION['startM'] = (isset($_GET['start']))? $_GET['start'] : date('m');
        $_SESSION['endM'] = (isset($_GET['end']))? $_GET['end'] : date('m');

        
        $y = $_SESSION['thn'];
        // echo $y."<br>";
        $sM = $_SESSION['startM'];
        $eM = $_SESSION['endM'];
        // mysqli_query($link, "UPDATE working_days SET ket = 'DOP' WHERE ket = 'DOT' ");
        // echo $_SESSION['startM']."<br >";
        // echo $_SESSION['endM']."<br >";
        $tahun = $_SESSION['thn'];

        $tanggalAwal = date('Y-m-d', strtotime($y.'-'.$sM.'-01'));
        // echo "tanggal awal : ".$tanggalAwal."<br>";
        $tanggalAkhir = date('Y-m-t', strtotime($y.'-'.$eM.'-01'));
        // echo "tanggal akhir : ". $tanggalAkhir."<br>";

        $count_awal = date_create($tanggalAwal);
        $count_akhir = date_create($tanggalAkhir);

        if($sM <= $eM){
            $hari = date_diff($count_awal,$count_akhir)->days +1;
        }else{
            $hari = 0;
        }

        $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
        $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

        $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
        $totalBln = count($bln);


        
        $t = "org.".$org_access;
        if($level < 4){
            
            //konfirmasi absen
            $qryAbsenHr = "SELECT absensi.id AS id_absen,
            absensi.npk AS npk_absen, 
            absensi.shift AS shift_absen,
            absensi.date AS tanggal,
            absensi.check_in AS check_in,
            absensi.check_out AS check_out,
            absensi.ket AS ket,
            
            attendance_code.kode AS kode_absen,
            attendance_code.keterangan AS ket_kode_absen,
            attendance_code.type AS tipe_kode_absen,

            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,

            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,

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
            karyawan.shift AS shift_,
            karyawan.id_area AS id_area_,
            karyawan.department AS department_

            FROM absensi
            JOIN karyawan ON karyawan.npk = absensi.npk
            JOIN attendance_code ON attendance_code.kode = absensi.ket 
            JOIN org ON org.npk = karyawan.npk

            JOIN groupfrm ON groupfrm.id_group = org.grp
            JOIN dept_account ON dept_account.id_dept_account = org.dept_account
        
            
            WHERE attendance_code.type = 'REMARK' AND  absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";


            //request absensi
            $qryData = "SELECT req_absensi.id AS id_absen,
            req_absensi.npk AS npk_absen, 
            req_absensi.shift AS shift_absen,
            req_absensi.date AS tanggal,
            req_absensi.date_in AS tanggal_masuk,
            req_absensi.date_out AS tanggal_keluar,
            req_absensi.check_in AS check_in,
            req_absensi.check_out AS check_out,
            req_absensi.keterangan AS keterangan,
            req_absensi.requester AS requester,
            req_absensi.status AS status_absen,
            req_absensi.req_status AS req_status,
            req_absensi.req_date AS req_date,

            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,

            org.npk AS npk_org,
            org.sub_post AS sub_post,
            org.post AS post,
            org.grp AS grp,
            org.sect AS sect,
            org.dept AS dept,
            org.dept_account AS dept_account,
            org.division AS division,
            org.plant AS plant,

            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,

            karyawan.npk AS npk_,
            karyawan.nama AS nama_,
            karyawan.shift AS shift_,
            karyawan.id_area AS id_area_,
            karyawan.department AS department_

            FROM req_absensi
            JOIN karyawan ON karyawan.npk = req_absensi.npk
            JOIN org ON org.npk = karyawan.npk

            
            JOIN dept_account ON dept_account.id_dept_account = org.dept_account
            JOIN groupfrm ON groupfrm.id_group = org.grp
            -- JOIN pos_leader ON pos_leader.id_post = org.post

            WHERE req_absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";
        }else{
            //konfirmasi absen
            $qryAbsenHr = "SELECT absensi.id AS id_absen,
            absensi.npk AS npk_absen, 
            absensi.shift AS shift_absen,
            absensi.date AS tanggal,
            absensi.check_in AS check_in,
            absensi.check_out AS check_out,
            absensi.ket AS ket,
            
            attendance_code.kode AS kode_absen,
            attendance_code.keterangan AS ket_kode_absen,
            attendance_code.type AS tipe_kode_absen,

            org.npk AS npk_org,
            org.sub_post AS sub_post,
            org.post AS post,
            org.grp AS grp,
            org.sect AS sect,
            org.dept AS dept,
            org.dept_account AS dept_account,
            org.division AS division,
            org.plant AS plant,
            
            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,

            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,
            
            karyawan.npk AS npk_,
            karyawan.nama AS nama_,
            karyawan.shift AS shift_,
            karyawan.id_area AS id_area_,
            karyawan.department AS department_

            FROM karyawan
            JOIN absensi ON karyawan.npk = absensi.npk
            LEFT JOIN attendance_code ON attendance_code.kode = absensi.ket 
            LEFT JOIN org ON org.npk = karyawan.npk

            LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
            LEFT JOIN groupfrm ON groupfrm.id_group = org.grp

            WHERE attendance_code.type = 'REMARK' AND  absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";

            //request absensi
            $qryData = "SELECT req_absensi.id AS id_absen,
            req_absensi.npk AS npk_absen, 
            req_absensi.shift AS shift_absen,
            req_absensi.date AS tanggal,
            req_absensi.date_in AS tanggal_masuk,
            req_absensi.date_out AS tanggal_keluar,
            req_absensi.check_in AS check_in,
            req_absensi.check_out AS check_out,
            req_absensi.keterangan AS keterangan,
            req_absensi.requester AS requester,
            req_absensi.status AS status_absen,
            req_absensi.req_status AS req_status,
            req_absensi.req_date AS req_date,

            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,

            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,

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
            karyawan.shift AS shift_,
            karyawan.id_area AS id_area_,
            karyawan.department AS department_

            FROM karyawan
            LEFT JOIN req_absensi ON karyawan.npk = req_absensi.npk
            LEFT JOIN org ON org.npk = karyawan.npk

        
            LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
            LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
            
            WHERE req_absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";
        }
        //monitor progress
        $select_join = $qryData." ORDER BY req_absensi.status, req_absensi.date ASC";
        
    ?>
        <form action="proses.php" method="GET">
            <div class="modal fade bd-example-modal-lg"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div id="view_data"></div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <?php
            $q_draft = $qryData." AND req_absensi.status = '0'";
            $s_draft = mysqli_query($link, $q_draft)or die(mysqli_error($link));
            $j_draft = mysqli_num_rows($s_draft);
            if($j_draft > 0){
                $draft = $j_draft." draft";
            }else{
                $draft = '';
            }

            $q_reject = $qryData." AND req_absensi.status = '50' AND req_absensi.req_status = 'b' ";
            $s_reject = mysqli_query($link, $q_reject)or die(mysqli_error($link));
            $j_reject = mysqli_num_rows($s_reject);
            if($j_reject  > 0){
                $reject = $j_reject ." ditolak";
            }else{
                $reject = '';
            }

            $q_confirm = $qryData." AND req_absensi.status = '75' AND req_absensi.req_status = 'b' ";
            $s_confirm = mysqli_query($link, $q_reject)or die(mysqli_error($link));
            $j_confirm = mysqli_num_rows($s_reject);
            if($j_confirm  > 0){
                $confirm = $j_confirm ." need confirm";
            }else{
                $confirm = '';
            }

            $q_reqs = $qryData." AND req_absensi.status <> '0'";
            $s_reqs = mysqli_query($link, $q_reqs)or die(mysqli_error($link));
            $j_reqs = mysqli_num_rows($s_reqs);

            $q_apprv = $qryData." AND req_absensi.status BETWEEN '25' AND '50' " ;
            $s_apprv = mysqli_query($link, $q_apprv)or die(mysqli_error($link));
            $j_apprv = mysqli_num_rows($s_apprv);

            $q_prcss = $qryData." AND req_absensi.status = '75' ";
            $s_prcss = mysqli_query($link, $q_prcss)or die(mysqli_error($link));
            $j_prcss = mysqli_num_rows($s_prcss);

            $q_scss = $qryData." AND req_absensi.status = '100' ";
            $s_scss = mysqli_query($link, $q_scss)or die(mysqli_error($link));
            $j_scss = mysqli_num_rows($s_scss);
        //
        ?>
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="card-plain card-stats bg-transparent h-100 my-0 border-right border-left">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning ">
                                    <i class="nc-icon nc-ruler-pencil text-warning "></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="numbers ">
                                        <p class="card-category">Pengajuan</p>
                                        <p class="card-title"><?=$j_reqs?></p>
                                    </div>
                                    <span class="badge badge-pill badge-info pull-right"><?=$draft?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning ">
                                    <i class="nc-icon nc-paper text-danger "></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="numbers ">
                                        <p class="card-category">In Approval</p>
                                        <p class="card-title"><?=$j_apprv?><p>
                                    </div>
                                    <span class="badge badge-pill badge-danger pull-right"><?=$reject?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning ">
                                    <i class="nc-icon nc-single-copy-04 text-primary "></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="numbers ">
                                        <p class="card-category">In Process</p>
                                        <p class="card-title"><?=$j_prcss?><p>
                                    </div>
                                    <span class="badge badge-pill badge-primary pull-right"><?=$confirm?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning ">
                                    <i class="nc-icon nc-check-2 text-success "></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="numbers ">
                                        <p class="card-category">Success</p>
                                        <p class="card-title"><?=$j_scss?><p>
                                    </div>
                                    <span class="badge badge-pill badge-primary pull-right"><?=$confirm?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>

        
    <br>
    <form method="GET">
    <div class="row">
        <div class="col-md-12" >
            <div class="card bg-transparent" >
                <div class="card-body bg-transparent">
                <div class="row">
                <div class="col-md-5 border-2">
                        <div class="input-group border-2 bg-transparent no-border">
                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <select type="date" name="start" class="form-control bg-transparent" >
                                <option Disabled>Pilih Bulan</option>
                                <?php
                                
                                $i =0;
                                foreach($bln AS $namaBln){
                                    $i++;
                                    $selectBln = ($i == $sM)?"selected":"";
                                    
                                    echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                                }
                                ?>
                            </select>
                            <div class="input-group-prepend ml-0 bg-transparent">
                                <div class="input-group-text px-2 bg-transparent">
                                    <i>to</i>
                                </div>
                            </div>
                            <select type="date" name="end" class="form-control bg-transparent" >
                                <option Disabled>Pilih Bulan</option>
                                <?php
                                
                                $i =0;
                                foreach($bln AS $namaBln){
                                    $i++;
                                    $selectBln = ($i == $eM)?"selected":"";
                                    
                                    echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                                }
                                ?>
                            </select>
                            <select type="text" name="tahun" class=" form-control bg-transparent">
                            <option Disabled>Tahun</option>
                            <?php
                            $thnPertama = 2021;
                            for($i=date("Y"); $i>=$thnPertama; $i--){
                                $selectThn = ($i == $tahun)?"selected":"";
                                echo "<option $selectThn value=\"$i\">$i</option>";
                            }
                            ?>
                            </select>
                            <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                            
                        </div>
                        
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                    <div class="col-md-7 border-2 ">
                        <p class="box float-right order-1">
                            <button class="btn btn-icon btn-round btn-default" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                            <i class="nc-icon nc-simple-add "></i>
                            </button>
                        </p>
                        <p class="float-right mr-2">
                            <button data-toggle="modal" data-id="" id="" data-target="#modal" class="btn btn-icon btn-info btn-outline-info btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                                <i class="nc-icon nc-calendar-60 "> </i>
                            </button>
                        </p>
                        
                        
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
    <?php
        // include('monitor.php');
        // require_once('leave_request.php');
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="title " id="mainpage"> Pengajuan Absensi</h5>
                            <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                            <input type="hidden" id="startDate" value="<?=$tanggalAwal?>">
                            <input type="hidden" id="endDate" value="<?=$tanggalAkhir?>">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group no-border">
                                <select class="form-control" name="div" id="s_div">
                                    <option value="">Pilih Divisi</option>
                                </select>
                                <select class="form-control" name="dept" id="s_dept">
                                    <option value="">Pilih Department</option>
                                    <option value="" disabled>Pilih Division Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="section" id="s_section">
                                    <option value="">Pilih Section</option>
                                    <option value="" disabled>Pilih Department Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="groupfrm" id="s_goupfrm">
                                    <option value="">Pilih Group</option>
                                    <option value="" disabled>Pilih Section Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="shift" id="s_shift">
                                    <option value="">Pilih Shift</option>
                                    <?php
                                        $query_shift = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query_shift)>0){
                                            while($data = mysqli_fetch_assoc($query_shift)){
                                                ?>
                                                <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data Shift</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="form-control" name="deptacc" id="s_deptAcc">
                                    <option value="">Pilih Department Administratif</option>
                                    <?php
                                        $q_div = mysqli_query($link, "SELECT `id`,`nama_org`,`cord`,`nama_cord` FROM `view_cord_area` WHERE `part` = 'deptAcc'")or die(mysqli_error($link));
                                        if(mysqli_num_rows($q_div) > 0){
                                            while($data = mysqli_fetch_assoc($q_div)){
                                            ?>
                                            <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data Department Administratif</option>
                                            <?php
                                        }
                                    ?>
                                    </select>
                                <div class="input-group-append ">
                                    <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form name="organization" method="POST" class="card-body">
                    <!-- <div class="nav-tabs-navigation "> -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sticker">
                                <h6>Access Control</h6>
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                        <!--  -->
                                        <li class="nav-item ">
                                        
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi active data-active"  data-toggle="tab" data-id="req" href="#result" role="tab" aria-expanded="true"></i>Pengajuan & Konfirmasi</a>
                                        </li>
                                        
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="approve" href="#approved" role="tab" aria-expanded="true">Aproval Monitoring</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="proccess" href="#proccess" role="tab" aria-expanded="true">Admin Proccess Monitoring</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="success" href="#success" role="tab" aria-expanded="true">Close/Succesed Monitoring</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="my-tab-content" class="tab-content ">
                                <div class="tab-pane active " id="request" role="tabpanel" aria-expanded="true">
                                    <div id="monitor">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <?php
    // include_once('hr_absensi.php');
    }else{
        include_once ("../../no_access.php");
    }
    include_once("../footer.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        dataActive()
        function dataActive(page){
            if($(".data-active")[0]){
                var div_id = $('#s_div').val();
                var dept_id = $('#s_dept').val();
                var section_id = $('#s_section').val();
                var group_id = $('#s_goupfrm').val();
                var deptAcc_id = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                var cari = $('#cari').val();

                var id = $('.data-active').attr('data-id');
                var start = $('#startDate').val();
                var end = $('#endDate').val();
                console.log(cari);
                // $('#monitor').load("ajax/index.php?id="+id+"&start="+start+"&end="+end);
               
                $.ajax({
                    url:"ajax/index.php",
                    method:"GET",
                    data:{page:page,cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,filter:'yes'},
                    success:function(data){
                        $('#monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                        // $('#data-monitoring').html(data)
                    }
                })
            }
        }
        $(document).on('click','.navigasi-absensi', function(){
            $('.navigasi-absensi').removeClass('data-active');
            $(this).addClass('data-active');
            dataActive()
        });
        $(document).on('click', '.halaman', function(){
            var page = $(this).attr("id");
            dataActive(page)
            // console.log(hal)
        });
        // getSumary()
        function getDiv(){
            var data = $('#s_div').val()
            $.ajax({
                url: 'ajax/get_div.php',
                method: 'GET',
                data: {data:data},		
                success:function(data){
                    $('#s_div').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getDept(){
            var data = $('#s_div').val()
            $.ajax({
                url: 'ajax/get_dept.php',	
                method: 'GET',
                data: {data:data},
                success:function(data){
                    $('#s_dept').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    // console.log(data)
                }
            });
        }
        function getSect(){
            var data = $('#s_dept').val()
            $.ajax({
                url: 'ajax/get_sect.php',	
                method: 'GET',
                data: {data:data},		
                success:function(data){
                    $('#s_section').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getGroup(){
            var data = $('#s_section').val()
            $.ajax({
                url: 'ajax/get_group.php',
                method: 'GET',
                data: {data:data},
                success:function(data){
                    $('#s_goupfrm').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                }
            });
        }
        getDiv()
        $('#s_div').on('change', function(){
            getDept()
            getSect()
            getGroup()
        })
        $('#s_dept').on('change', function(){
            getSect()
            getGroup()
        })
        $('#s_section').on('change', function(){
            getGroup()
        })
        $(document).on('blur', '#cari', function(){
            // var cari = $(this).val()
            dataActive()
            // console.log(cari);
        });
        $('#filterGo').on('click', function(){
            dataActive();
        })
        
        $(document).on('click', '.sort', function(){
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();

            var id = $('.data-active').attr('data-id');
            var start = $('#startDate').val();
            var end = $('#endDate').val();
            var sort = $("#dataSort").serialize()
            var page = $('.page_active').attr('id');
            console.log(sort);
            // dataActive(page)
            $.ajax({
                            
                url:"ajax/index.php?page="+page+"&id="+id+"&start="+start+"&end="+end+"&div="+div_id+"&dept="+dept_id+"&sect="+section_id+"&group="+group_id+"&deptAcc="+deptAcc_id+"&shift="+shift+"&filter=yes",
                method:"GET",
                data:sort,
                success:function(data){
                    $('#monitor').fadeOut('fast', function(){
                        $(this).html(data).fadeIn('fast');
                    });
                }
            })
        })
        $('.checkOne').on('click', function() {
            if($('.checkOne:checked').length == $('.checkOne').length){
                $('.checkAll').prop('checked', true)
            } else {
                $('.checkAll').prop('checked', false)
            }
        })
        $(document).on('click', '.remove', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan dihapus permanent",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#CB4335',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{del:data},
                        success:function(){
                            load_data(page);
                            getSumary()
                            success('Dihapus','data pengajuan telah dihapus, silakan ajukan kembali');
                        }
                    })
                }
            })
                
        });
    })
    </script>
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });

            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                }
            })
        })
    </script>
    
    <script>
    //untuk crud masal update department

    $('.proses').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
            
        Swal.fire({
        title: 'Pengajuan Siap Diproses',
        text: "Draft pengajuan anda akan dikirim untuk diproses",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00B9FF',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, Proses!'
        }).then((result) => {
            if (result.value) {
                document.location.href=getLink;
            }
        })
        
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

        document.proses.action = getLink;
        document.proses.submit();
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.view_data').click(function(){
                var id = $(this).parents("tr").attr("id");
                
                
                $.ajax({
                    url: 'ajax/view.php',	
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
<?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>