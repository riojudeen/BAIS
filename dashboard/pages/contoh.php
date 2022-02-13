<?php
if(isset($_GET['tmblfilterdariform'])){
    $blA = $_GET['blnmulaiform'];
    $blAk = $_GET['blnakhirform'];
    $y = $_GET['tahunform']; //Y-m-d

    $blnPertama= date('d-'.$blA.'-'.$y);
    $today = date('d-'.$blAk.'-'.$y);
}else{
    $blnPertama= date('d-1-Y'); //bulan pertama tahun berjalan
    $today = date('d-m-Y'); //bulan berjalan
    $y = date('Y'); //tahun berjalan
}

$blnAwal = date('m', strtotime($blnPertama));
$blnAkhir = date('m', strtotime($today));

$tanggalAwal = date('Y-m-d', strtotime($y.'-'.$blnAwal.'-01'));
// echo "tanggal awal : ".$tanggalAwal."<br>";
$tanggalAkhir = date('Y-m-t', strtotime($y.'-'.$blnAkhir.'-01'));
// echo "tanggal akhir : ". $tanggalAkhir."<br>";
$count_awal = date_create($tanggalAwal);
$count_akhir = date_create($tanggalAkhir);
$hari = date_diff($count_awal,$count_akhir)->days +1;
$selisihBln = ($blnAkhir - $blnAwal)+1;

$bln = $selisihBln;

?>
<table style="border:1px solid black">
<?php
for($i = 1 ; $i <= $bln ;$i++){
    $namaBln = date('M-Y', strtotime($y.'-'.$i.'-01'))
    ?>
    <td style="border:1px solid black"><?=$namaBln?></td>
    <?php
}
?>
</table>
<?php

// for($i; $i<)