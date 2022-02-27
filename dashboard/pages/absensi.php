<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Dashboard";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    $_SESSION['now'] = $tanggalSekarang = date('Y-m-d');

    $_SESSION['startD'] = (isset($_POST['start']))? dateToDB($_POST['start']) : date('Y-m-d');
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
    
    //absensi
    $t = "org.".$org_access;
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
    LEFT JOIN attendance_code ON attendance_code.kode = absensi.ket 
    JOIN org ON org.npk = karyawan.npk
    JOIN groupfrm ON groupfrm.id_group = org.grp
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";

    $q_masuk = $qryAbsenHr." AND (absensi.check_in <> '00:00:00' OR absensi.check_out <> '00:00:00' OR absensi.ket = 'WFH') ";
    $q_mangkir = $qryAbsenHr." AND attendance_code.kode = 'M' ";
    $q_telat = $qryAbsenHr." AND (attendance_code.kode = 'T1' OR attendance_code.kode = 'T2' OR attendance_code.kode = 'T3')";
    $q_tl = $qryAbsenHr." AND attendance_code.kode = 'TL' ";
    $q_sakit = $qryAbsenHr." AND (attendance_code.kode = 'S1' OR attendance_code.kode = 'S2' OR attendance_code.kode = 'S3')";
    $q_ijin = $qryAbsenHr." AND attendance_code.type = 'SUPEM'  AND (absensi.ket <> 'S1' OR absensi.ket <> 'S2' OR absensi.ket <> 'S3') AND absensi.ket <> 'WFH'";

    $sqlMasuk = mysqli_query($link, $q_masuk)or die(mysqli_error($link));
    $sqlmangkir = mysqli_query($link, $q_mangkir)or die(mysqli_error($link));
    $sqltelat = mysqli_query($link, $q_telat)or die(mysqli_error($link));
    $sqltl = mysqli_query($link, $q_tl)or die(mysqli_error($link));
    $sqlsakit = mysqli_query($link, $q_sakit)or die(mysqli_error($link));
    $sqlijin = mysqli_query($link, $q_ijin)or die(mysqli_error($link));

    $masuk = mysqli_num_rows($sqlMasuk);

    $totalMangkir = mysqli_num_rows($sqlmangkir);
    $totalTelat = mysqli_num_rows($sqltelat);
    $totalTl = mysqli_num_rows($sqltl);
    $totalSakit = mysqli_num_rows($sqlsakit);
    $totalIjin = mysqli_num_rows($sqlijin);
    $TotalMasuk = $masuk;

    $absen = mysqli_query($link, $qryAbsenHr);
    // echo mysqli_num_rows($absen);
    // echo $masuk;

?>
<form action="proses.php" method="POST">
   
    <div id="view_data"></div>
           
</form>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-success text-white">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-briefcase text-white"></i>
                            
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Masuk WFO</p>
                            <p class="card-title"><?=$TotalMasuk?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="masuk" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats text-white" style="background:#FF9E00">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="nc-icon nc-touch-id text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Absen Tidak lengkap</p>
                            <p class="card-title"><?=$totalTl?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="absen tidak lengkap" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            <hr>
           
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-warning text-white" >
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="nc-icon nc-user-run text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Terlambat</p>
                            <p class="card-title"><?=$totalTelat?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="telat" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            <hr>
           
        </div>
    </div>
</div>
<hr class="mt-0">
<div class="row">
        
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats text-white" style="background:#81A3FF">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fas fa-suitcase-rolling"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Cuti</p>
                            <p class="card-title"><?=$totalIjin?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="ijin" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats  text-white" style="background:#A582F5">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Cuti Lain-Lain</p>
                            <p class="card-title"><?=$totalIjin?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="ijin" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-primary">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-bed text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Cuti Dokter & Dirawat</p>
                            <p class="card-title text-white"><?=$totalSakit?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="sakit" ></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats  text-white" style="background:#F5828E">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Ijin Keluar Perusahaan</p>
                            <p class="card-title"><?=$totalIjin?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="ijin" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-info text-white">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fas fa-laptop-house"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">WFH</p>
                            <p class="card-title"><?=$totalIjin?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="ijin" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-danger text-white">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fa fa-bell-slash text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Mangkir</p>
                            <p class="card-title"><?=$totalMangkir?> MP
                            <p>
                            <a class="stretched-link view_data text-white" id="mangkir" ></a> 
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            
        </div>
    </div>

</div>
<form method="POST">
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
                <div class="col-md-7 border-2 ">
                    
                    <p class="float-right mr-2">
                        <button data-toggle="modal" data-id="" id="" data-target="#modal" class="btn btn-icon btn-info btn-outline-info btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                            <i class="nc-icon nc-calendar-60 "> </i>
                        </button>
                    </p>
                    
                    <div class="my-2 mr-2 float-right order-3">
                        <div class="input-group bg-transparent">
                            <input type="text" name="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk..">
                            <div class="input-group-append bg-transparent">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
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
<?php
    include_once('../absensi/monitoring.php');
   
    include_once("../footer.php");
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.view_data').click(function(e){
                var id = $(this).attr("id");
                $.ajax({
                    url: '../absensi/modal_monitoring.php',	
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