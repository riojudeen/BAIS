<?php
$m = (isset($_GET['start']))? $_GET['start']: date('m');
$_SESSION['startD'] = (isset($_GET['start']))? date('Y-'.$m.'-01') : date('Y-m-01');
$_SESSION['endD'] = (isset($_GET['start']))? date('Y-'.$m.'-t') : date('Y-m-d');

$sD = $_SESSION['startD'];
$eD = $_SESSION['endD'];
////////////////////////////////////////
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
$i = 0; //index awal 0 agar array di dalam looping dimulai dari 1

if($hari > 0 ){
    while($blnAwal <= $akhir){
        $tgl = date('Y-m-d', $blnAwal);
        $blnAwal = strtotime("+1 day", $blnAwal);
        $hari = explode(' ', $tgl);
        $array_tgl[$i++] = $tgl;
    }
}else{
    $array_tgl = array();
}
