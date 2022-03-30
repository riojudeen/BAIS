<?php
require_once("../../config/config.php"); 
require_once("../../config/schedule_system.php"); 
require_once("../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Permit & Permit Request";
    include_once("../header.php");
    // include_once("leave_calc.php");
    $npk_kry = $_GET['npk'];
    $tgl = $_GET['tanggal'];
    $jmlHari = $_GET['count'];
    $tanggal_array = json_decode(loopHari($tgl, $jmlHari));

    // echo $tgl;
    $sql_reqAbs = mysqli_query($link, "SELECT * FROM req_absensi
    WHERE npk = '$npk_kry' AND `date` = '$tgl' ")or die(mysqli_error($link));
    
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

                FROM karyawan
                LEFT JOIN absensi ON karyawan.npk = absensi.npk
                LEFT JOIN org ON org.npk = karyawan.npk
                WHERE karyawan.npk = '$npk_kry' AND absensi.date = '$tgl' ")or die(mysqli_error($link));
    
    $dataAbsenHr = mysqli_fetch_assoc($sql_absenHr);
    
    // echo mysqli_num_rows($sql_absenHr);

    if(mysqli_num_rows($sql_absenHr) > 0){
        $cin = ($dataAbsenHr['check_in'] == '00:00:00')? "-" : $dataAbsenHr['check_in'];
        $cout = ($dataAbsenHr['check_out'] == '00:00:00')? "-" : $dataAbsenHr['check_out'];
        $shift = $dataAbsenHr['shift_'];
        $pesan = "data sudah pernah diinput / sudah ada di database";
        $nama_ = $dataAbsenHr['nama_'];
        $ket = $dataAbsenHr['ket'];
    }else{
        $datashift = mysqli_fetch_assoc(mysqli_query($link, "SELECT shift, nama FROM karyawan WHERE npk = '$npk_kry'"));  
        $sqlWD = mysqli_query($link, "SELECT working_hours.id AS id_wh,
                                working_hours.start AS ci,
                                working_hours.end AS co,
                                working_days.shift AS shf,
                                working_hours.code_name AS code_wh,
                                working_days.date AS tgl,
                                working_days.wh AS wh,
                                working_days.ket AS ket,
                                working_days.id AS id
                                        
                                FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
                                WHERE working_days.shift = '$datashift[shift]' AND working_days.date = '$tgl' ")or die(mysqli_error($link));
        $dataWD = mysqli_fetch_assoc($sqlWD);
        
        $cin = ($dataWD['ci'] == '00:00:00')? "-" : $dataWD['ci'];
        $cout = ($dataWD['co'] == '00:00:00')? "-" : $dataWD['co']; 
        $shift = $dataWD['shf'];
        $nama_ = $datashift['nama'];

        
    }
    $disableTanggalAkhir = (mysqli_num_rows($sql_reqAbs) > 0)?"disabled":"";

    if($cin > $cout){
        $tglini = ($tgl);
        $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($tgl)));
    }else{
        $tglini = $tgl;
        $sesudah = $tgl;
    }
    // echo $tglini;
    
    $waktuAwal = strtotime("$tglini $cin");
    $waktuAkhir = strtotime("$sesudah $cout"); // bisa juga waktu sekarang now()
            
        //menghitung selisih dengan hasil detik
        $diff = $waktuAkhir - $waktuAwal;

        //membagi detik menjadi jam
        $jam = floor($diff / (60 * 60));

        //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit = $diff - $jam * (60 * 60);

?>
<div class="row ">

<div class="col-md-12 ">
   
    <div class="card">
        <div class="card-header">
            <h5 class="title pull-left">Input Data</h5>
            <a href="req_absensi.php" class="btn pull-right">
                Back
                <span class="btn-label btn-label-right">
                    <i class="nc-icon nc-minimal-right"></i>
                </span>
            </a>
        </div>
        <hr>
        <form action="proses.php" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                
                <input type="hidden" name="id_" class="form-control" value="<?=$_GET['jenis']?>">
                <input type="hidden" name="npk" class="form-control" value="<?=$npk_kry?>">
                
                <div class="form-group after-add-more row">
                    <div class="col-md-3 d-sm-none d-md-block">
                        <h6>Working Days</h6>
                        <label>Tanggal</label>
                        <input disabled type="text"  class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tgl)?>" id="schedule" >
                        <label for="">Shift</label>
                        <div class="form-inline">
                        <input type="text" class="form-control col-lg-12"  value="<?=$shift?>" readonly>
                        </div>
                        <br>
                        <label for="">
                        <i class="nc-icon nc-time-alarm"></i>
                        
                        Tanggal Kerja</label>
                        <div class="form-inline text-left">
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Jam Masuk" value="<?=DBtoForm($tglini)?>" readonly >
                            <label class="col-2 text-left">to</label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="DD/MM/YYYY" placeholder="Jam Pulang" value="<?=DBtoForm($sesudah)?>" readonly >
                        </div>
                        <br>
                        <label>
                        <i class="nc-icon nc-calendar-60"></i>
                        Jam Kerja</label>
                        <div class="form-inline">
                            <input type="text" class="form-control col-lg-5 datepicker  " data-date-format="HH:mm:ss" placeholder="Jam Masuk" value="<?=$cin?>" readonly >
                            <label class="col-2 text-left">to </label>
                            <input type="text" class="form-control col-lg-5 datepicker " data-date-format="HH:mm:ss" placeholder="Jam Pulang" value="<?=$cout?>" readonly >
                            
                        
                        </div>
                        <br>
                        <label>Keterangan</label>
                        <input type="text" class="form-control col-lg-12 " placeholder="" value="<?=$dataAbsenHr['ket']?>" readonly >
                        <br>
                        <hr />


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
                        $qry_tglMasuk = "SELECT tgl_masuk FROM karyawan WHERE npk = '$npk_kry' ";
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
                                $jatah[$periodeCuti] = (mysqli_num_rows($sqlAloc_C2) > 0)? $aloc_C2 : 12;
                               
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

                        $qry_C1 = "SELECT * FROM req_absensi WHERE npk = '$npk_kry' AND `date` BETWEEN '$startD' AND '$endD' AND keterangan = 'C1' ";
                        $sql_C1 = mysqli_query($link, $qry_C1);
                        $jml_C1 = mysqli_num_rows($sql_C1);
                        // echo $jml_;

                        $qry_C2 = "SELECT * FROM req_absensi WHERE npk = '$npk_kry' AND `date` BETWEEN '$periodStart[$maxPeriod]' AND '$periodEnd[$maxPeriod]' AND keterangan = 'C2' ";
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
                   
                    
                    <div class="col-md-9 border-left" id="sticker">
                        <?php
                            list($npk,$subpost,$post,$group,$sect,$dept,$dept_account,$div,$plant) = dataOrg($link, $npk_kry);
                        ?>
                        <h5><?=$nama_." - ".$npk_kry?></h5>
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
                         <h6>Input Pengajuan Absensi</h6>
                         
                        <?php
                        $col = ($_GET['jenis'] == 'SUKET')?'4':'10';
                        $no = 1;
                        $sql_code = mysqli_query($link, "SELECT * FROM attendance_code WHERE `type` = 'SUPEM' AND kode = '$_GET[att_code]' ")or die(mysqli_error($link));
                        
                        foreach($tanggal_array AS $date){
                            $readonly = ($date == $tgl)?'readonly':'';
                            $q_absensi = "SELECT shift, `date`, check_in, check_out, ket FROM absensi WHERE `date` = '$date' AND npk = '$npk_kry'";
                            $q_reqabsensi = "SELECT shift, `date`, check_in, check_out, keterangan FROM req_absensi WHERE `date` = '$date' AND npk = '$npk_kry'";
                            $sql_absensi = mysqli_query($link, $q_absensi)or die(mysqli_error($link));
                            $sql_reqabsensi = mysqli_query($link, $q_reqabsensi)or die(mysqli_error($link));
                            $data_absensi = mysqli_fetch_assoc($sql_absensi);
                            $data_reqabsensi = mysqli_fetch_assoc($sql_reqabsensi);
                            // echo $q_absensi;
                            if(mysqli_num_rows($sql_reqabsensi) > 0){
                                
                                $pesan = "pengajuan sudah pernah dibuat";
                                $disabled_in = 'readonly';
                                $disabled_out = 'readonly';

                                $in_ = (isset($data_reqabsensi['check_in']) && $data_reqabsensi['check_in'] != "00:00:00" )?$data_reqabsensi['check_in']:'';
                                $out_ = (isset($data_reqabsensi['check_out']) && $data_reqabsensi['check_out'] != "00:00:00" )?$data_reqabsensi['check_out']:'';

                            }else{
                                if(mysqli_num_rows($sql_absensi) > 0){
                                    $disabled_in = (isset($data_absensi['check_in']) && $data_absensi['check_in'] != "00:00:00" )?'readony':'';
                                    $disabled_out = (isset($data_absensi['check_out']) && $data_absensi['check_out'] != "00:00:00" )?'readony':'';
                                    $pesan = "";
                                    $in_ = (isset($data_absensi['check_in']) && $data_absensi['check_in'] != "00:00:00" )?$data_absensi['check_in']:'';
                                    $out_ = (isset($data_absensi['check_out']) && $data_absensi['check_out'] != "00:00:00" )?$data_absensi['check_out']:'';
                                }else{
                                    $pesan = "data absensi belum tersedia";
                                    $disabled_in = 'readonly';
                                    $disabled_out = 'readonly';
    
                                    $in_ = '';
                                    $out_ = '';
                                }
                            }
                            // echo $pesan;
                            $disabled_tgl = ($_GET['jenis'] == 'SUKET')?'readony':'';
                            ?>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-horizontal">
                                        <div class="row">
                                            <label class="col-md-2 col-form-label text-left">Cuti ke-<?=$no++?></label>
                                            <div class="col-md-<?=$col?>"> 
                                                <div class="form-group">
                                                    <input <?=$disabled_tgl?> <?=$readonly?> type="text" name="sd[]" class="form-control col-lg-12 datepicker mr-0 datepickertgl" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($date)?>" required >
                                                </div>
                                                
                                            </div>
                                            <?php
                                                if($_GET['jenis'] == 'SUKET'){
                                                    ?>
                                                    <label class="col-md-1 col-form-label text-right px-1"><i class="nc-icon  nc-time-alarm"></i> In</label>
                                                <div class="col-md-2"> 
                                                    <div class="form-group">
                                                        <input <?=$disabled_in?> type="text" name="ci[]" class="form-control text-center col-lg-12 datepicker mr-0" data-date-format="H:mm" value="<?=$in_?>" required >
                                                    </div>
                                                </div>
                                                <label class="col-md-1 col-form-label text-right px-1"><i class="nc-icon nc-time-alarm"></i> Out</label>
                                                <div class="col-md-2"> 
                                                    <div class="form-group">
                                                        <input <?=$disabled_out?> type="text" name="co[]" class="form-control text-center col-lg-12 datepicker mr-0" data-date-format="HH:mm" value="<?=$out_?>" required >
                                                    </div>
                                                    
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        ?>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-horizontal">
                                    <div class="row">
                                        <label class="col-md-2 col-form-label text-left">Shift</label>
                                        <div class="col-md-10"> 
                                            <div class="form-group">
                                                 <input type="text" name="shift[]" class="form-control col-lg-12"  value="<?=$shift?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <label>Pengajuan</label>
                        <?php
                        $query_attendance_type = mysqli_query($link, "SELECT * FROM attendance_type WHERE `id` = '$_GET[jenis]' ")or die(mysqli_error($link));
                        $att_type = mysqli_fetch_assoc($query_attendance_type)or die(mysqli_error($link));
                        $type = $att_type['name'];
                        ?>
                        <div class="form-group ">
                            <input readonly name="jenis" type="text" value="<?=$type?>" class="text-uppercase form-control">
                        </div>
                        <?php
                        $query_attendance_code = mysqli_query($link, "SELECT * FROM attendance_code WHERE `kode` = '$_GET[att_code]' ")or die(mysqli_error($link));
                        $att_code = mysqli_fetch_assoc($query_attendance_code)or die(mysqli_error($link));
                        $code = $att_code['kode'];
                        $ket = $att_code['keterangan'];
                        ?>
                        <div class="form-group ">
                            <input name="code" type="hidden" value="<?=$code?>" class="text-uppercase form-control">
                        </div>
                        <div class="form-group ">
                            <input readonly name="ket" type="text" value="<?=$ket?>" class="text-uppercase form-control">
                        </div>
                        
                        <label>Alasan / keperluan</label>
                        <div class="form-group">
                            <input  name="note" minLength="5" maxLength="20" rows="4" cols="70" placeholder="tulis alasan / keperluan pengajuan.." class="form-control textarea"  required />
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label> <i class="fas fa-paperclip"></i>
                                    Attachment / Lampiran
                                </label>
                                <p class="category mb-0">
                                    pengajuan membutuhkan lampiran tambahan
                                </p>
                                <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                                
                                    <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:500px;">
                                            <input type="text" class="form-control mx-0">
                                        </div>
                                        <div >
                                            <span class="btn btn-sm  btn-round btn-rose btn-file ">
                                            <span class="fileinput-new ">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                                <input type="file"  name="attach-upload" accept="image/png, image/jpeg, image/jpg" id="attach-upload"/>
                                            </span>
                                            <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                            <p class="category mt-0">
                                                pastikan gambar yang diupload berekstensi JPG, JPEG atau PNG
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <hr>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <input class="btn btn-success float-right" type="submit" name="req_<?=$_GET['jenis']?>" value="Submit <?=$_GET['jenis']?>">
                            </div>
                        </div>
                        
                    
                    </div>
                </div>
                
            </div>   
            
            
            <div class="card-footer">   

            </div>
            <br/>
            
        </form>
    </div>
    
</div>
</div>
<?php
    include_once("../footer.php");
    ?>
  <script>
    $('.datepickertgl').datetimepicker({
            //   daysOfWeekDisabled: [0, 6],
        disabledDates: [
            // moment("06/11/2021"), //bulan/tanggal/tahun
            <?php
            $qryDataLibur = mysqli_query($link, "SELECT * FROM holidays ORDER BY `date` ASC");
            while($dataLibur = mysqli_fetch_assoc($qryDataLibur)){
                $exp = explode('-', $dataLibur['date']);
                echo "moment(\"$exp[1]/$exp[2]/$exp[0]\"), ";
               
            }
            ?>
            // new Date(2021, 01 - 1, 01),
            // "06/07/2021 00:53"
        ],
    });
  </script>
  <script type="text/javascript">
   $(function () {
        $('#DateTimePicker1').datetimepicker({format: 'YYYY-MM-DD'});
        $('#DateTimePicker2').datetimepicker({format: 'YYYY-MM-DD',
        useCurrent: true //Important! See issue #1075     
        });
        var date = $('#DateTimePicker1').val();
        $('#DateTimePicker2').data("DateTimePicker").minDate(date);
   });
</script>
<?php
    //javascript
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

