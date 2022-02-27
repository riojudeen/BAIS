<?php 
//////////////////////////////////////////////////////////////////////
include_once("../../config/config.php");
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Lembur";
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
    


    
    //mencari kode lembur
    $q_otCode = "SELECT * FROM kode_lembur ORDER BY kode_lembur";
    $sqlOtCode = mysqli_query($link, $q_otCode)or die(mysqli_error($link));

    $jmlOtCode = mysqli_num_rows($sqlOtCode);
    $i = 0;
    while($dataOtCode = mysqli_fetch_assoc($sqlOtCode)){
        $array_otCode[$i] =  $dataOtCode['kode_lembur'];
        $array_otName[$i] =  $dataOtCode['nama'];
        $i++;
    }

    //query overtime hr
    $t = "org.".$org_access;
    $q_Ot = "SELECT 
    hr_lembur.id AS id_lemburHr,
    hr_lembur.npk AS npk_lemburHr,
    hr_lembur.date AS date_lemburHr,
    hr_lembur.start AS start_lemburHr,
    hr_lembur.end AS end_lemburHr,

    -- lembur._id AS id_lembur, 
    -- lembur.kode_lembur AS kode_lembur, 
    -- lembur.requester AS reuester, 
    -- lembur.npk AS npk_lembur,
    -- lembur.in_date AS in_date,
    -- lembur.out_date AS out_date,
    -- lembur.in_lembur AS start_lembur,
    -- lembur.out_lembur AS end_lembur,
    -- lembur.kode_job AS kode_job,
    -- lembur.aktifitas AS activity,
    -- lembur.tanggal_input AS tgl_input
    -- lembur.status_approve AS statApp,
    -- lembur.status AS stats,

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

    FROM hr_lembur
    JOIN karyawan ON karyawan.npk = hr_lembur.npk
    LEFT JOIN org ON org.npk = karyawan.npk
    LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
    LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    WHERE hr_lembur.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";
    $sqlLembur = mysqli_query($link, $q_Ot)or die(mysqli_error($link));

    $qryAbsenHr = "SELECT absensi.id AS id_absen,
    absensi.npk AS npk_absen, 
    absensi.shift AS shift_absen,
    absensi.date AS tanggal,
    absensi.check_in AS check_in,
    absensi.check_out AS check_out,
    absensi.ket AS ket 
    FROM absensi ";


    // echo $q_Ot;
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
                            <p class="card-category text-white">Overtime Total</p>
                            <p class="card-title"><?=""?> Menit
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-footer ">
                <div class="stats">
                    <a class="stretched-link view_data text-white" id="masuk" ><i class="nc-icon nc-tile-56 text-white "></i> Detail</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-info text-white">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Overtime Non Prod</p>
                            <p class="card-title"><?=""?> Menit
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-footer ">
                <div class="stats">
                    <a class="stretched-link view_data text-white" id="ijin" ><i class="nc-icon nc-tile-56 text-white "></i> Detail</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats bg-primary text-white">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-white">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category text-white">Overtime Prod</p>
                            <p class="card-title"><?=""?> Menit
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-footer ">
                <div class="stats">
                    <a class="stretched-link view_data text-white" id="ijin" ><i class="nc-icon nc-tile-56 text-white "></i> Detail</a> 
                </div>
            </div>
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
                        <a href="absen_lembur.php" class="btn btn-icon btn-info btn-outline-info btn-round" type="button" >
                            <i class="nc-icon nc-calendar-60 "> </i>
                        </a>
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
    include_once('../overtime/monitoring.php');
?>
<script type="text/javascript">
   $(function () {
       $('#datetimepicker6').datetimepicker({format: 'YYYY-MM-DD'});
       $('#datetimepicker7').datetimepicker({format: 'YYYY-MM-DD',
        useCurrent: true //Important! See issue #1075     
   });
       $("#datetimepicker6").on("dp.change", function (e) {
           $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
       });
       $("#datetimepicker7").on("dp.change", function (e) {
           $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
       });
   });
</script>
<script type="text/javascript">
$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});
</script>



<?php

    include_once("../footer.php");
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.view_data').click(function(e){
                e.preventDefault();
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