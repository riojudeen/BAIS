<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
require_once("../../config/approval_system.php"); 
require_once("../../config/schedule_system.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Konfirmasi Absensi";
    include_once("../header.php");

    if(isset($_GET['req'])){
        // mysqli_query($link, "DELETE FROM req_absensi");
        $query_cekCuti = "SELECT `npk`,`date`,`date_in`,`date_out`, `req_date`, `keterangan` FROM `req_absensi` WHERE id = '$_GET[id]' AND shift_req <> 1";
        $sqlCheck = mysqli_query($link, $query_cekCuti)or die(mysqli_error($link));
        $dataCek = mysqli_fetch_assoc($sqlCheck);
        if(mysqli_num_rows($sqlCheck) > 0){
            $submit = "disabled";
            $disableOption = "disabled";
            $notif = 1;
        }else{
            $submit = "";
            $notif = 0;
            $disableOption = "";
        }
        // echo $_GET['id'];
        ///cari data absensi
        $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
            absensi.npk AS npk_absen, 
            absensi.shift AS shift_absen,
            absensi.date AS tanggal,
            absensi.check_in AS check_in,
            absensi.check_out AS check_out,
            absensi.ket AS ket,

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
            LEFT JOIN karyawan ON karyawan.npk = absensi.npk
            LEFT JOIN org ON org.npk = karyawan.npk
            WHERE absensi.id = '$_GET[id]' ")or die(mysqli_error($link));
        $dataAbsenHr = mysqli_fetch_assoc($sql_absenHr);
        $check_in = ($dataAbsenHr['check_in'] == '00:00:00')? "" : $dataAbsenHr['check_in'];
        $check_out = ($dataAbsenHr['check_out'] == '00:00:00')? "" : $dataAbsenHr['check_out'];
        $shift = $dataAbsenHr['shift_absen'];
        $tanggal = $dataAbsenHr['tanggal'];
        // echo mysqli_num_rows($sql_absenHr)."<br>";
        // echo $tanggal."<br>";
        // echo $shift."<br>";

        list($tglini, $sesudah, $cin, $cout, $jml) = WD($link, $shift, $dataAbsenHr['tanggal']);
        /// cek working days
    

        // echo $tglini."<br>";
        // echo $sesudah."<br>";
        // echo $shift."<br>";
        // echo $cin."<br>";
        // echo $cout."<br>";
        // echo mysqli_num_rows($sqlCheck)."<br>";



        ?>
        <!-- halaman utama -->

        <div class="row ">
            <div class="col-md-3 ">
                <div class="card sticker">
                    <div class="card-body">
                        <h6>Informasi Hari Kerja</h6>
                        <label>Tanggal</label>
                        <input type="text"  class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggal)?>" readonly>
                        <label for="">Shift</label>
                        <div class="form-inline">
                        <input type="text" class="form-control col-lg-12"  value="<?=$shift?>" readonly>
                        </div>
                        <br>
                        <label for="">
                        <i class="nc-icon nc-time-alarm"></i>
                        
                        Tanggal Kerja</label>
                        <div class="form-inline text-left">
                            <input name="di" type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Tanggal Masuk" value="<?=DBtoForm($tglini)?>" readonly >
                            <label class="col-2 text-left">to</label>
                            <input name="do" type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Tanggal Pulang" value="<?=DBtoForm($sesudah)?>" readonly >
                        </div>
                        <br>
                        <label>
                        <i class="nc-icon nc-calendar-60"></i>
                        Jam Kerja</label>
                        <div class="form-inline">
                            <input type="text" class="form-control col-lg-5 datepicker  " data-date-format="HH:mm" placeholder="Jam Masuk" value="<?=$cin?>" readonly >
                            <label class="col-2 text-left">to </label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="HH:mm" placeholder="Jam Pulang" value="<?=$cout?>" readonly >
                            
                        
                        </div>
                        <br>
                        <label>Keterangan</label>
                        <input type="text" class="form-control col-lg-12 " placeholder="Jam Pulang" value="<?=$dataAbsenHr['ket']?>" readonly >
                        <br />

                        
                        <!-- sisa cuti -->
                        <?php
                                                
                        $tahunPeriod = date('Y');
                        $startMonth = 01;
                        $endMonth = 12;
                        $t = $tahunPeriod ;
                        // echo $y."<br>";
                        $bM = $startMonth ;
                        $bS = $endMonth;

                        $startD = date('Y-m-d', strtotime($t.'-'.$bM.'-01'));
                        $endD = date('Y-m-t', strtotime($t.'-'.$bS.'-01'));

                        /*
                        mencari periode cuti 
                        */
                        $qry_tglMasuk = "SELECT tgl_masuk FROM karyawan WHERE npk = '$dataAbsenHr[npk_]' ";
                        $sql_tglMasuk = mysqli_query($link, $qry_tglMasuk);
                        $data_tglMasuk = mysqli_fetch_assoc($sql_tglMasuk);
                        $tglMasuk = $data_tglMasuk['tgl_masuk'];
                        $timestamp = strtotime($tglMasuk);
                    

                        $bulanMasuk = date('m', strtotime($tglMasuk));
                        $hariMasuk = date('d', strtotime($tglMasuk));;

                        $tglTahunini = date('Y-m-d', strtotime($t.'-'.$bulanMasuk.'-'.$hariMasuk));
                        
                        $timeStampAwal = $bln = $timestamp;
                        $timeStampAkhir = strtotime($tglTahunini);
                        $i = 0;
                        while($bln <= $timeStampAkhir ){
                            
                            $tgl_ = date('Y-m-d', $bln);
                            $bln = strtotime("+5 years", $bln);

                            $end = date('Y-m-d', strtotime("-1 day", $bln));

                            $periodEnd[$i] = $end;
                            $period[$i] = $i;
                            $periodStart[$i] = $tgl_;
                            
                            $i++;
                        }
                        
                        
                        foreach($period AS $periodeCuti){
                            $qryAloc_C2 = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C2' ";
                            $sqlAloc_C2 = mysqli_query($link, $qryAloc_C2);
                            $dataAloc_C2 = mysqli_fetch_assoc($sqlAloc_C2);
                            $aloc_C2 = $dataAloc_C2['alocation'];
                            if($periodeCuti == 0){
                                $jatah[$periodeCuti] = 0;
                                
                            }else{
                                $jatah[$periodeCuti] = (mysqli_num_rows($sqlAloc_C2) > 0)? $aloc_C2 : 22;
                            
                            }
                        }
                        $maxPeriod = max($period);
                        

                        // echo $timeStampAwal."<br>";
                        // echo $timeStampAkhir."<br>";

                        // //hitung berapa tahun
                        // $count_awal = date_create($tglMasuk);
                        // $count_akhir = date_create($tglTahunini);
                        // $jmlhari = date_diff($count_awal,$count_akhir)->days +1;
                        // // echo $jmlhari." hari <br>";

                        $qryAloc = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C1' ";
                        $sqlAloc = mysqli_query($link, $qryAloc);
                        $dataAloc = mysqli_fetch_assoc($sqlAloc);
                        $aloc = $dataAloc['alocation'];
                        // // echo $aloc;

                        // $qryAloc_C2 = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C2' ";
                        // $sqlAloc_C2 = mysqli_query($link, $qryAloc_C2);
                        // $dataAloc_C2 = mysqli_fetch_assoc($sqlAloc_C2);
                        // $aloc_C2 = $dataAloc_C2['alocation'];
                        // // echo $aloc_C2;

                        $qry_C1 = "SELECT * FROM req_absensi WHERE npk = '$dataAbsenHr[npk_]' AND `date` BETWEEN '$startD' AND '$endD' AND keterangan = 'C1' ";
                        $sql_C1 = mysqli_query($link, $qry_C1);
                        $jml_C1 = mysqli_num_rows($sql_C1);
                        // echo $jml_;

                        $qry_C2 = "SELECT * FROM req_absensi WHERE npk = '$dataAbsenHr[npk_]' AND `date` BETWEEN '$periodStart[$maxPeriod]' AND '$periodEnd[$maxPeriod]' AND keterangan = 'C2' ";
                        $sql_C2 = mysqli_query($link, $qry_C2);
                        $jml_C2 = mysqli_num_rows($sql_C2);
                        // // echo $jml_;

                        $sisaC1 = $aloc - $jml_C1;
                        $sisaC2 = $aloc_C2 - $jml_C2;
                        // echo $sisaC1." hari <br>";
                        // echo $sisaC2." hari <br>";




                        ?>
                        <h6>Cuti Panjang - C2</h6>
                        <label for="">ALOKASI CUTI PANJANG :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$jatah[$maxPeriod]?> hari</p>
                        </div>
                        <label for="">SISA CUTI :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$sisaC2?> hari</p>
                        </div>
                        <br />
                        <label for="">
                            <i class="nc-icon nc-calendar-60"></i> Periode :
                        </label>
                        <div class="form-inline text-left">
                            <input type="text" class="form-control col-lg-5 " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($periodStart[$maxPeriod])?>" disabled >
                            <label class="col-2 text-left">to</label>
                            <input type="text" class="form-control col-lg-5 " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($periodEnd[$maxPeriod])?>" disabled >
                        </div>
                        <br>
                        <h6>Cuti Tahunan - C1</h6>
                        <label for="">ALOKASI CUTI TAHUNAN :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$aloc?> hari</p>
                        </div>
                        <label for="">SISA CUTI</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$sisaC1?> hari</p>
                        </div>
                        <br />
                        <label for="">
                            <i class="nc-icon nc-calendar-60"></i> Periode :
                        </label>
                        <div class="form-inline text-left">
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" value="<?=DBtoForm($startD)?>" disabled >
                            <label class="col-2 text-left">to</label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($endD)?>" disabled >
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-9 ">

                <div class="card">
                    <div class="card-header">
                        <h5 class="title pull-left">Input Pengajuan Absensi </h5>
                        
                        <a href="req_absensi.php" class="btn pull-right">
                            Back
                            <span class="btn-label btn-label-right">
                                <i class="nc-icon nc-minimal-right"></i>
                            </span>
                        </a>
                    </div>
                    <hr>
                    
                    <div class="card-body">
                    <?php

                        if($notif == 1){
                            ?>
                            <div class="alert alert-info alert-with-icon alert-dismissible fade show" data-notify="container">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                            <span data-notify="message">
                                Pengajuan Telah Dibuat tanggal    <?=tgl($dataCek['req_date'])?>                    
                            </span>
                            </div>
                            <?php
                        }

                        ?>
                        <form action="proses.php" method="POST">
                            <div class="row">
                                <?php
                                    list($npk,$subpost,$post,$group,$sect,$dept,$dept_account,$div,$plant) = dataOrg($link, $dataAbsenHr['npk_']);
                                ?>
                                <div class="col-12 border-left pull-right">
                                    <h5><?=$dataAbsenHr['nama_']." - ".$dataAbsenHr['npk_'] ?></h5>
                                    <input type="hidden" name="add" class="form-control" value="<?=$_GET['id']?>">
                                    <div class="row">
                                        <div class="col-md-3 pr-1">
                                            <label for="">Divisi</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $div, "division")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Department</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $dept, "dept")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Section</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $sect, "section")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Group</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $group, "group")?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6>Pengajuan Absensi</h6>
                                    
                                    <label>Tanggal</label>
                                    <input name="npk" type="hidden" id="npk" value="<?=$dataAbsenHr['npk_']?>">
                                    <input name="shift" type="hidden" value="<?=$shift?>">
                                    <input name="d" type="text" id="tanggal" class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggal)?>" required readonly>
                                    <label for="">Shift</label>
                                    <div class="form-inline">
                                    <input type="text" class="form-control col-lg-12"  value="<?=$shift?>" required readonly>
                                    
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="">Keterangan Absensi</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control " placeholder="Jam Pulang" value="<?=$dataAbsenHr['ket']?>" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="">Jenis Pengajuan</label>
                                                    <div class="form-group">
                                                    
                                                        <select <?=$disableOption?> name="tipe" id="tipe_ijin" data-id="leave" class="form-control text-uppercase ">
                                                            

                                                            <option disabled value="">pilih pengajuan</option>
                                                            <?php
                                                                if($notif == 1){
                                                                    $qAttType = mysqli_query($link, "SELECT attendance_type.id AS `type`, 
                                                                        attendance_type.name AS `name`, 
                                                                        attendance_code.kode AS `kode` FROM attendance_code
                                                                        JOIN attendance_type ON attendance_code.type = attendance_type.id WHERE attendance_code.kode = '$dataCek[keterangan]' ")or die(mysqli_error($link));
                                                                    $dataType = mysqli_fetch_assoc($qAttType);
                                                                    $data = $dataType['type'];
                                                                    // echo $data;
                                                                    $addQuery = " AND id = '$data'";
                                                                    
                                                                }else{
                                                                    $addQuery = "";
                                                                
                                                                }
                                                                $qry = mysqli_query($link, "SELECT `id`,`name` FROM `attendance_type` WHERE id <> 'REMARK' AND stats = '1' $addQuery")or die(mysqli_error($link));
                                                                if(mysqli_num_rows($qry) > 0){
                                                                    while($data = mysqli_fetch_assoc($qry)){
                                                                        $select = ($_GET['req'] == $data['id'])?'selected':'';
                                                                    ?>
                                                                        <option <?=$select?> value="<?=$data['id']?>"><?=$data['name']?></option>
                                                                    <?php
                                                                    }
                                                                }else{
                                                                    ?>
                                                                    <option value=""><?=noData()?></option>
                            
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="input"></div>
                                    
                                    </div>
                                    
                                
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="row pull-right">
                                        <?php
                                        if($notif == 1){
                                            ?>
                                            <a href="" class="btn btn-warning" >tambah pengajuan</a>
                                            <?php
                                        }
                                        ?>
                                        
                                            <input <?=$submit?> class="btn btn-success " type="submit" value="SUBMIT">

                                        

                                    </div>
                                </div>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
                
            </div>
        <!-- halaman utama end -->
        <?php
    }else if(isset($_GET['add_request'])){
        // mysqli_query($link, "DELETE FROM req_absensi");
        $query_cekCuti = "SELECT `npk`,`date`,`date_in`,`date_out`, `req_date`, `keterangan` FROM `req_absensi` WHERE id = '$_GET[id]' AND shift_req <> 1";
        $sqlCheck = mysqli_query($link, $query_cekCuti)or die(mysqli_error($link));
        $dataCek = mysqli_fetch_assoc($sqlCheck);
        if(mysqli_num_rows($sqlCheck) > 0){
            $submit = "disabled";
            $disableOption = "disabled";
            $notif = 1;
        }else{
            $submit = "";
            $notif = 0;
            $disableOption = "";
        }
        // echo $_GET['id'];
        ///cari data absensi
        $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
            absensi.npk AS npk_absen, 
            absensi.shift AS shift_absen,
            absensi.date AS tanggal,
            absensi.check_in AS check_in,
            absensi.check_out AS check_out,
            absensi.ket AS ket,

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
            LEFT JOIN karyawan ON karyawan.npk = absensi.npk
            LEFT JOIN org ON org.npk = karyawan.npk
            WHERE absensi.id = '$_GET[id]' ")or die(mysqli_error($link));
        $dataAbsenHr = mysqli_fetch_assoc($sql_absenHr);
        $check_in = ($dataAbsenHr['check_in'] == '00:00:00')? "" : $dataAbsenHr['check_in'];
        $check_out = ($dataAbsenHr['check_out'] == '00:00:00')? "" : $dataAbsenHr['check_out'];
        $shift = $dataAbsenHr['shift_absen'];
        $tanggal = $dataAbsenHr['tanggal'];
        // echo mysqli_num_rows($sql_absenHr)."<br>";
        // echo $tanggal."<br>";
        // echo $shift."<br>";

        list($tglini, $sesudah, $cin, $cout, $jml) = WD($link, $shift, $dataAbsenHr['tanggal']);
        /// cek working days
    

        // echo $tglini."<br>";
        // echo $sesudah."<br>";
        // echo $shift."<br>";
        // echo $cin."<br>";
        // echo $cout."<br>";
        // echo mysqli_num_rows($sqlCheck)."<br>";



        ?>
        <!-- halaman utama -->

        <div class="row ">
            <div class="col-md-3 ">
                <div class="card sticker">
                    <div class="card-body">
                        <h6>Informasi Hari Kerja</h6>
                        <label>Tanggal</label>
                        <input type="text"  class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggal)?>" readonly>
                        <label for="">Shift</label>
                        <div class="form-inline">
                        <input type="text" class="form-control col-lg-12"  value="<?=$shift?>" readonly>
                        </div>
                        <br>
                        <label for="">
                        <i class="nc-icon nc-time-alarm"></i>
                        
                        Tanggal Kerja</label>
                        <div class="form-inline text-left">
                            <input name="di" type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Tanggal Masuk" value="<?=DBtoForm($tglini)?>" readonly >
                            <label class="col-2 text-left">to</label>
                            <input name="do" type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Tanggal Pulang" value="<?=DBtoForm($sesudah)?>" readonly >
                        </div>
                        <br>
                        <label>
                        <i class="nc-icon nc-calendar-60"></i>
                        Jam Kerja</label>
                        <div class="form-inline">
                            <input type="text" class="form-control col-lg-5 datepicker  " data-date-format="HH:mm" placeholder="Jam Masuk" value="<?=$cin?>" readonly >
                            <label class="col-2 text-left">to </label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="HH:mm" placeholder="Jam Pulang" value="<?=$cout?>" readonly >
                            
                        
                        </div>
                        <br>
                        <label>Keterangan</label>
                        <input type="text" class="form-control col-lg-12 " placeholder="Jam Pulang" value="<?=$dataAbsenHr['ket']?>" readonly >
                        <br />

                        
                        <!-- sisa cuti -->
                        <?php
                                                
                        $tahunPeriod = date('Y');
                        $startMonth = 01;
                        $endMonth = 12;
                        $t = $tahunPeriod ;
                        // echo $y."<br>";
                        $bM = $startMonth ;
                        $bS = $endMonth;

                        $startD = date('Y-m-d', strtotime($t.'-'.$bM.'-01'));
                        $endD = date('Y-m-t', strtotime($t.'-'.$bS.'-01'));

                        /*
                        mencari periode cuti 
                        */
                        $qry_tglMasuk = "SELECT tgl_masuk FROM karyawan WHERE npk = '$dataAbsenHr[npk_]' ";
                        $sql_tglMasuk = mysqli_query($link, $qry_tglMasuk);
                        $data_tglMasuk = mysqli_fetch_assoc($sql_tglMasuk);
                        $tglMasuk = $data_tglMasuk['tgl_masuk'];
                        $timestamp = strtotime($tglMasuk);
                    

                        $bulanMasuk = date('m', strtotime($tglMasuk));
                        $hariMasuk = date('d', strtotime($tglMasuk));;

                        $tglTahunini = date('Y-m-d', strtotime($t.'-'.$bulanMasuk.'-'.$hariMasuk));
                        
                        $timeStampAwal = $bln = $timestamp;
                        $timeStampAkhir = strtotime($tglTahunini);
                        $i = 0;
                        while($bln <= $timeStampAkhir ){
                            
                            $tgl_ = date('Y-m-d', $bln);
                            $bln = strtotime("+5 years", $bln);

                            $end = date('Y-m-d', strtotime("-1 day", $bln));

                            $periodEnd[$i] = $end;
                            $period[$i] = $i;
                            $periodStart[$i] = $tgl_;
                            
                            $i++;
                        }
                        
                        
                        foreach($period AS $periodeCuti){
                            $qryAloc_C2 = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C2' ";
                            $sqlAloc_C2 = mysqli_query($link, $qryAloc_C2);
                            $dataAloc_C2 = mysqli_fetch_assoc($sqlAloc_C2);
                            $aloc_C2 = $dataAloc_C2['alocation'];
                            if($periodeCuti == 0){
                                $jatah[$periodeCuti] = 0;
                                
                            }else{
                                $jatah[$periodeCuti] = (mysqli_num_rows($sqlAloc_C2) > 0)? $aloc_C2 : 22;
                            
                            }
                        }
                        $maxPeriod = max($period);
                        

                        // echo $timeStampAwal."<br>";
                        // echo $timeStampAkhir."<br>";

                        // //hitung berapa tahun
                        // $count_awal = date_create($tglMasuk);
                        // $count_akhir = date_create($tglTahunini);
                        // $jmlhari = date_diff($count_awal,$count_akhir)->days +1;
                        // // echo $jmlhari." hari <br>";

                        $qryAloc = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C1' ";
                        $sqlAloc = mysqli_query($link, $qryAloc);
                        $dataAloc = mysqli_fetch_assoc($sqlAloc);
                        $aloc = $dataAloc['alocation'];
                        // // echo $aloc;

                        // $qryAloc_C2 = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C2' ";
                        // $sqlAloc_C2 = mysqli_query($link, $qryAloc_C2);
                        // $dataAloc_C2 = mysqli_fetch_assoc($sqlAloc_C2);
                        // $aloc_C2 = $dataAloc_C2['alocation'];
                        // // echo $aloc_C2;

                        $qry_C1 = "SELECT * FROM req_absensi WHERE npk = '$dataAbsenHr[npk_]' AND `date` BETWEEN '$startD' AND '$endD' AND keterangan = 'C1' ";
                        $sql_C1 = mysqli_query($link, $qry_C1);
                        $jml_C1 = mysqli_num_rows($sql_C1);
                        // echo $jml_;

                        $qry_C2 = "SELECT * FROM req_absensi WHERE npk = '$dataAbsenHr[npk_]' AND `date` BETWEEN '$periodStart[$maxPeriod]' AND '$periodEnd[$maxPeriod]' AND keterangan = 'C2' ";
                        $sql_C2 = mysqli_query($link, $qry_C2);
                        $jml_C2 = mysqli_num_rows($sql_C2);
                        // // echo $jml_;

                        $sisaC1 = $aloc - $jml_C1;
                        $sisaC2 = $aloc_C2 - $jml_C2;
                        // echo $sisaC1." hari <br>";
                        // echo $sisaC2." hari <br>";




                        ?>
                        <h6>Cuti Panjang - C2</h6>
                        <label for="">ALOKASI CUTI PANJANG :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$jatah[$maxPeriod]?> hari</p>
                        </div>
                        <label for="">SISA CUTI :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$sisaC2?> hari</p>
                        </div>
                        <br />
                        <label for="">
                            <i class="nc-icon nc-calendar-60"></i> Periode :
                        </label>
                        <div class="form-inline text-left">
                            <input type="text" class="form-control col-lg-5 " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($periodStart[$maxPeriod])?>" disabled >
                            <label class="col-2 text-left">to</label>
                            <input type="text" class="form-control col-lg-5 " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($periodEnd[$maxPeriod])?>" disabled >
                        </div>
                        <br>
                        <h6>Cuti Tahunan - C1</h6>
                        <label for="">ALOKASI CUTI TAHUNAN :</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$aloc?> hari</p>
                        </div>
                        <label for="">SISA CUTI</label>
                        <div class="form-inline border-bottom ">
                            <p class="mb-0 "><?=$sisaC1?> hari</p>
                        </div>
                        <br />
                        <label for="">
                            <i class="nc-icon nc-calendar-60"></i> Periode :
                        </label>
                        <div class="form-inline text-left">
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" value="<?=DBtoForm($startD)?>" disabled >
                            <label class="col-2 text-left">to</label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($endD)?>" disabled >
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-9 ">

                <div class="card">
                    <div class="card-header">
                        <h5 class="title pull-left">Input Pengajuan Absensi </h5>
                        
                        <a href="req_absensi.php" class="btn pull-right">
                            Back
                            <span class="btn-label btn-label-right">
                                <i class="nc-icon nc-minimal-right"></i>
                            </span>
                        </a>
                    </div>
                    <hr>
                    
                    <div class="card-body">
                    <?php

                        if($notif == 1){
                            ?>
                            <div class="alert alert-info alert-with-icon alert-dismissible fade show" data-notify="container">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                            <span data-notify="message">
                                Pengajuan Telah Dibuat tanggal    <?=tgl($dataCek['req_date'])?>                    
                            </span>
                            </div>
                            <?php
                        }

                        ?>
                        <form action="proses.php" method="POST">
                            <div class="row">
                                <?php
                                    list($npk,$subpost,$post,$group,$sect,$dept,$dept_account,$div,$plant) = dataOrg($link, $dataAbsenHr['npk_']);
                                ?>
                                <div class="col-12 border-left pull-right">
                                    <h5><?=$dataAbsenHr['nama_']." - ".$dataAbsenHr['npk_'] ?></h5>
                                    <input type="hidden" name="add" class="form-control" value="<?=$_GET['id']?>">
                                    <div class="row">
                                        <div class="col-md-3 pr-1">
                                            <label for="">Divisi</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $div, "division")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Department</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $dept, "dept")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Section</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $sect, "section")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <label for="">Group</label>
                                            <div class="form-group">
                                                <input disabled type="text" class="form-control" value="<?=getOrgName($link, $group, "group")?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6>Pengajuan Absensi</h6>
                                    
                                    <label>Tanggal</label>
                                    <input name="npk" type="hidden" id="npk" value="<?=$dataAbsenHr['npk_']?>">
                                    <input name="shift" type="hidden" value="<?=$shift?>">
                                    <input name="d" type="text" id="tanggal" class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggal)?>" required readonly>
                                    <label for="">Shift</label>
                                    <div class="form-inline">
                                    <input type="text" class="form-control col-lg-12"  value="<?=$shift?>" required readonly>
                                    
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="">Keterangan Absensi</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control " placeholder="Jam Pulang" value="<?=$dataAbsenHr['ket']?>" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="">Jenis Pengajuan</label>
                                                    <div class="form-group">
                                                    
                                                        <select <?=$disableOption?> name="tipe" id="tipe_ijin" data-id="leave" class="form-control text-uppercase ">
                                                            

                                                            <option disabled value="">pilih pengajuan</option>
                                                            <?php
                                                                if($notif == 1){
                                                                    $qAttType = mysqli_query($link, "SELECT attendance_type.id AS `type`, attendance_type.name AS `name`, attendance_code.kode AS `kode` FROM attendance_code
                                                                        JOIN attendance_type ON attendance_code.type = attendance_type.id WHERE attendance_code.kode = '$dataCek[keterangan]'")or die(mysqli_error($link));
                                                                    $dataType = mysqli_fetch_assoc($qAttType);
                                                                    $data = $dataType['type'];
                                                                    // echo $data;
                                                                    $addQuery = " AND id = '$data'";
                                                                    
                                                                }else{
                                                                    $addQuery = "";
                                                                
                                                                }
                                                                $qry = mysqli_query($link, "SELECT `id`,`name` FROM `attendance_type` WHERE id <> 'REMARK' $addQuery")or die(mysqli_error($link));
                                                                if(mysqli_num_rows($qry) > 0){
                                                                    while($data = mysqli_fetch_assoc($qry)){
                                                                        $select = ($_GET['req'] == $data['id'])?'selected':'';
                                                                    ?>
                                                                        <option <?=$select?> value="<?=$data['id']?>"><?=$data['name']?></option>
                                                                    <?php
                                                                    }
                                                                }else{
                                                                    ?>
                                                                    <option value=""><?=noData()?></option>
                            
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="input"></div>
                                    
                                    </div>
                                    
                                
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="row pull-right">
                                        <?php
                                        if($notif == 1){
                                            ?>
                                            <a href="" class="btn btn-warning" >tambah pengajuan</a>
                                            <?php
                                        }
                                        ?>
                                        
                                            <input <?=$submit?> class="btn btn-success " type="submit" value="SUBMIT">

                                        

                                    </div>
                                </div>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
                
            </div>
        <!-- halaman utama end -->
        <?php
    }
    
    include_once("../footer.php");
    ?>
    <script type="text/javascript">

    $(document).ready(function(){
        function loadPermit(){
            var tipe = $('#tipe_ijin').val();
            var npk = $('#npk').val();
            var date = $('#tanggal').val();
            $.ajax({
                type : 'post',
                url : 'ajax/input.php',
                data: {tipe : tipe, npk:npk, date:date},
                success : function(data){
                $('.input').html(data);//menampilkan data ke dalam modal
                }
            });
        }
        loadPermit();
        $(document).on('change', '#tipe_ijin', function(){
            loadPermit();
        })
        // $('#keterangan').on('change', function (e) {
        //     var data = $(this).val();
        //     var id = $(this).attr('data-id');
        //     //menggunakan fungsi ajax untuk pengambilan data
        //     $.ajax({
        //         type : 'post',
        //         url : 'ajax/input.php',
        //         data: {data : data , id : id},
        //         success : function(data){
        //         $('.input').html(data);//menampilkan data ke dalam modal
        //         }
        //     });
        // });
    });
</script>
<?php
    //javascript
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
