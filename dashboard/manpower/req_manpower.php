<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitor Request Man Power";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    
    $_SESSION['thn'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
    $_SESSION['startM'] = (isset($_POST['start']))? $_POST['start'] : date('m');
    $_SESSION['endM'] = (isset($_POST['end']))? $_POST['end'] : date('m');
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
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
    }else{
        $hari = 0;
    }

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);
?>
    <div class="row">
    <?php
    $q_draft = "SELECT * FROM req_absensi WHERE `status` = '0' " ;
    $s_draft = mysqli_query($link, $q_draft)or die(mysqli_error($link));
    $j_draft = mysqli_num_rows($s_draft);

    $q_reqs = "SELECT * FROM req_absensi WHERE `status` = '25' " ;
    $s_reqs = mysqli_query($link, $q_reqs)or die(mysqli_error($link));
    $j_reqs = mysqli_num_rows($s_reqs);

    $q_apprv = "SELECT * FROM req_absensi WHERE `status` = '50' " ;
    $s_apprv = mysqli_query($link, $q_apprv)or die(mysqli_error($link));
    $j_apprv = mysqli_num_rows($s_apprv);

    $q_prcss = "SELECT * FROM req_absensi WHERE `status` = '75' " ;
    $s_prcss = mysqli_query($link, $q_prcss)or die(mysqli_error($link));
    $j_prcss = mysqli_num_rows($s_prcss);

    $q_scss = "SELECT * FROM req_absensi WHERE `status` = '100' " ;
    $s_scss = mysqli_query($link, $q_scss)or die(mysqli_error($link));
    $j_scss = mysqli_num_rows($s_scss);
    
    ?>

    <div class="col-3 border-right">
            <div class="card-plain card-stats bg-transparent h-100 my-0">
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
                                <p class="card-title"><?=$j_reqs?><p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 border-right">
            <div class="card-plain card-stats bg-transparent h-100 my-0">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning ">
                            <i class="nc-icon nc-paper text-danger "></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers ">
                                <p class="card-category">Approval</p>
                                <p class="card-title"><?=$j_apprv?><p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 border-right">
            <div class="card-plain card-stats bg-transparent h-100 my-0 ">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 border-right">
            <div class="card-plain card-stats bg-transparent h-100 my-0 ">
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
                                <p class="card-title"><?=$j_prcss?><p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<br>

<?php
    include_once('monitor.php');
?>

<?php
    include_once("../footer.php");
    ?>


<?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>