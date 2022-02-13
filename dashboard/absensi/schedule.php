<?php
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Monitor Request Absensi";
    include_once("../header.php");
    // include_once("leave_calc.php");
    $npk_kry = $_GET['npk'];
    $tgl = dateToDB($_GET['tanggal']);

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
    
    // /// cek working days

    
    // $tanggal = DBtoForm($dataAbsenHr['tanggal']);
    // echo $tanggal;
    

    


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


    // echo $dataWD['wh'];
    // echo $dataWD['ci'];
    // echo $dataWD['co'];
    // // echo $cout;
    // $waktu_awal = strtotime("2019-10-11 07:15:00");
    // $waktu_akhir = strtotime("2019-10-11 16:00:00"); // bisa juga waktu sekarang now()
    // echo $dataWD['code_wh']."<br/>";
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
        <form action="proses.php" method="POST">
            <div class="card-body">
                <h5><?=$nama_." - ".$npk_kry?></h5>
                <input type="hidden" name="id_" class="form-control" value="<?=$_GET['id']?>">
                <input type="hidden" name="npk" class="form-control" value="<?=$npk_kry?>">
                
                <div class="form-group after-add-more row">
                    <div class="col-3">
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
                   
                    
                    <div class="col-9 border-left pull-right" id="sticker">
                    <h6>Input Pengajuan Absensi</h6>
                        <label>Tanggal Muai</label>
                        <input readonly id="DateTimePicker1" type="text" name="sd" class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tgl)?>" required >
                        <label>Tanggal Selesai</label>
                        <input <?=$disableTanggalAkhir?> id="DateTimePicker2" type="text" name="ed" class="form-control col-lg-12 datepicker mr-0" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tgl)?>" required data-date-end-date="10d">
                        
                        <label for="">Shift</label>
                        <div class="form-inline">
                        <input type="text" name="shift[]" class="form-control col-lg-12"  value="<?=$shift?>" required readonly>
                        </div>
                        <br>
                        
                        <label>Pengajuan</label>
                        <select disabled name="tipe[]" class="form-control col-lg-12 text-uppercase col-lg-4" id="keterangan" data-id="<?=$_GET['id']?>">
                        <option >pilih pengajuan</option>
                        <option selected value="SUPEM" >Surat Pemberitahuan</option>
                        <option value="SUKET">Surat Keterangan</option>
                        </select>
                        <br>
                        <?php
                        
                        if(mysqli_num_rows($sql_reqAbs) > 0){
                            
                            $btn = "edit";
                            $dataReq = mysqli_fetch_assoc($sql_reqAbs);
                            $cekin = ($dataReq['check_in'] == '00:00:00')? "-" : $dataReq['check_in'];
                            $cekot = ($dataReq['check_out'] == '00:00:00')? "-" : $dataReq['check_out'];
                            $stts_ = ($dataReq['status'] < 25)?"active":"";
                            $note_ = $dataReq['note'];
                            ?>
                            <h6>History Pengajuan</h6>
                            <div class="">
                                <label>Keterangan</label>
                                <div class="form-inline">
                                    <input disabled type="text" name="ci[]" minLength="8" maxLength="8" class="form-control col-lg-4  mr-2 "  value="<?=$dataReq['keterangan']?>" required >
                                    
                                </div>
                                <label>Check In / Check Out</label>
                                <div class="form-inline">
                                    <input disabled type="text"  class="form-control col-lg-4 datepicker mr-2 " value="<?=$cekin?>" data-date-format="HH:mm:ss" required >
                                    <label>sampai </label>
                                    <input disabled type="text" name="co[]" class="form-control col-lg-4 datepicker ml-2"  value="<?=$cekot?>" data-date-format="HH:mm:ss" required >
                                </div>
                            </div>
                            <?php
                        }else{
                            $note_ = "";
                            $btn = "schedule";
                        }
                        ///cek apakah pengajuan sudah diproses atau masih draft
                        $sql_draft = mysqli_query($link, "SELECT * FROM req_absensi
                        WHERE npk = '$npk_kry' AND `date` = '$tgl' AND `status` > '0'")or die(mysqli_error($link));
                        // echo mysqli_num_rows($sql_draft);

                        $disable_Edit = (mysqli_num_rows($sql_draft) > 0)?"disabled":"";
                        $pesan_ = (mysqli_num_rows($sql_draft) > 0)?"Data Sudah Diproses (tidak dapat diubah)":"Piih / Ubah Jenis Cuti";
                        
                        ?>
                        <br>
                        <div class="">
                        <h6><?=$pesan_?></h6>
                            <label>Keterangan</label>
                            <?php
                                if(isset($ket)){
                                    $disabled= "disabled";
                                }else{
                                    $disabled= "";
                                }
                            ?>
                            <select <?=$disabled?> <?=$disable_Edit?> name="kode_absen[]" class="form-control col-lg-12 text-uppercase col-lg-4" id="">
                            <?php
                            $sqlAbs = mysqli_query($link, "SELECT * FROM attendance_code WHERE `type` = 'SUPEM' ")or die(mysqli_error($link));
                            echo mysqli_num_rows($sqlAbs);
                            if(mysqli_num_rows($sqlAbs) > 0){
                                
                                ?>
                                <option disabled>pilih</option>
                                <?php
                                while($dataCode = mysqli_fetch_assoc($sqlAbs)){
                                    if(isset($ket)){
                                        $slct = ($dataCode['kode'] == $dataAbsenHr['ket'])? "selected" : "";
                                    }else{
                                        $slct ="";
                                    }
                                    
                                    ?>
                                    <option  value="<?=$dataCode['kode']?>" <?=$slct?>><?=$dataCode['keterangan']?> - <?=$dataCode['kode']?></option>
                                        
                                    
                                    <?php
                                }
                            }

                            ?>

                            </select>
                            <br/>
                            
                            <label>Alasan / keperluan</label>
                            <div class="form-inline">
                                <textarea <?=$disable_Edit?>  <?=$disabled?> name="note[]" minLength="5" maxLength="20" rows="4" cols="70" placeholder="tulis alasan / keperluan pengajuan.." class="form-control textarea"  required><?=$note_?></textarea>
                            </div>
                        </div>
                        
                    
                    </div>
                </div>
                <hr>   
                <div class="col-12">
                        <input <?=$disabled?> <?=$disable_Edit?> class="btn btn-success pull-right" type="submit" name="<?=$btn?>" value="<?=$btn?>">
               
                </div>
                <br>
                
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
    $('.datepicker').datetimepicker({
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

