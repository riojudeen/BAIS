<?php
require_once("../../config/config.php"); 
//menangkap nilai tahun

$_SESSION['t'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
$_SESSION['sM'] = (isset($_POST['start']))? $_POST['start'] : 01;
$_SESSION['eM'] = (isset($_POST['end']))? $_POST['end'] : 12;
$t = $_SESSION['t'];
// echo $y."<br>";
$bM = $_SESSION['sM'];
$bS = $_SESSION['eM'];

$startD = date('Y-m-d', strtotime($t.'-'.$bM.'-01'));
$endD = date('Y-m-t', strtotime($t.'-'.$bS.'-01'));

/*
mencari periode cuti 
*/

$qry_tglMasuk = "SELECT tgl_masuk FROM karyawan WHERE npk = '44131' ";
$sql_tglMasuk = mysqli_query($link, $qry_tglMasuk);
$data_tglMasuk = mysqli_fetch_assoc($sql_tglMasuk);
$tglMasuk = $data_tglMasuk['tgl_masuk'];
// echo $tglMasuk."<br />";
$timestamp = strtotime($tglMasuk);
$limaTahun = date('d-m-Y', strtotime('+5 years', $timestamp)); // 01-03-2017
// echo $limaTahun;

$bulanMasuk = date('m', strtotime($tglMasuk));
$hariMasuk = date('d', strtotime($tglMasuk));;
// echo $bulanMasuk;
// echo $tglMasuk;

$tglTahunini = date('Y-m-d', strtotime($t.'-'.$bulanMasuk.'-'.$hariMasuk));
// echo $tglTahunini;


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
    // $array_tahun[$i++] = $tgl;
    echo "Periode - ".$period[$i]." :";
    echo "Start ".$periodStart[$i].", "."End ".$periodEnd[$i]."<br />";
    echo max($period);
    $i++;
}


// echo $timeStampAwal."<br>";
// echo $timeStampAkhir."<br>";

//hitung berapa tahun
$count_awal = date_create($tglMasuk);
$count_akhir = date_create($tglTahunini);
$jmlhari = date_diff($count_awal,$count_akhir)->days +1;
// echo $jmlhari." hari <br>";

$qryAloc = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C1' ";
$sqlAloc = mysqli_query($link, $qryAloc);
$dataAloc = mysqli_fetch_assoc($sqlAloc);
$aloc = $dataAloc['alocation'];
// echo $aloc;

$qryAloc_C2 = "SELECT * FROM leave_alocation WHERE effective_date BETWEEN '$startD' AND '$endD' AND id_leave = 'C2' ";
$sqlAloc_C2 = mysqli_query($link, $qryAloc_C2);
$dataAloc_C2 = mysqli_fetch_assoc($sqlAloc_C2);
$aloc_C2 = $dataAloc_C2['alocation'];
// echo $aloc_C2;

$qry_C1 = "SELECT * FROM req_absensi WHERE npk = '44131' AND `date` BETWEEN '$startD' AND '$endD' AND keterangan = 'C1' ";
$sql_C1 = mysqli_query($link, $qry_C1);
$jml_C1 = mysqli_num_rows($sql_C1);
// echo $jml_;

$qry_C2 = "SELECT * FROM req_absensi WHERE npk = '44131' AND `date` BETWEEN '$startD' AND '$endD' AND keterangan = 'C2' ";
$sql_C2 = mysqli_query($link, $qry_C2);
$jml_C2 = mysqli_num_rows($sql_C2);
// echo $jml_;

$sisaC1 = $aloc - $jml_C1;
$sisaC2 = $aloc_C2 - $jml_C2;
// echo $sisaC1." hari <br>";
// echo $sisaC2." hari <br>";



?>