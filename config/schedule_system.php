<?php

// $start = $_POST['start_date'];
// $end = $_POST['end_date'];
// $shift_start = $_POST['shift_start'];
// $start_day = $_POST['start_day'];
// $skema = $_POST['skema'];
function get_date($mulai, $selesai){
    $mulai = $month = strtotime($mulai);
    $selesai = strtotime($selesai);

    $i = 0;
    $array_tgl = array();
    while($month <= $selesai){
        $tgl = date('Y-m-d', $month);
        $month = strtotime("+1 day", $month);
        $array_tgl[$i++] = $tgl;
    }
    $data = json_encode($array_tgl);
    return $data;
}
function loopHari($mulai, $jmlHari){
    $mulai = $month = strtotime($mulai);
    $jmlHari = ($jmlHari > 0 )?$jmlHari-1:'';
    $selesai = date('Y-m-d', strtotime("+$jmlHari day", $mulai));

    $end = strtotime($selesai);

    $i = 0;
    $array_tgl = array();
    while($month <= $end){
        $tgl = date('Y-m-d', $month);
        $month = strtotime("+1 day", $month);
        $array_tgl[$i++] = $tgl;
    }
    $data = json_encode($array_tgl);
    return $data;

}
$tgl_mulai = '2021-01-13';
$tgl_selesai = '2021-10-1';

$default_holiday = array('Sun','Sat');

$dataShifting = 
$arrayShifting = array('DAY','NIGHT');
$skemaShift = 7;

$jmlShift = count($arrayShifting);


// echo $start;

function workingDays($tgl_mulai, $tgl_selesai, $arrayShifting, $skemaShift, $shiftInput){

    $dayList = array(
        'Sun' => 0,
        'Mon' => 1,
        'Tue' => 2,
        'Wed' => 3,
        'Thu' => 4,
        'Fri' => 5,
        'Sat' => 6,
        );

    //menghitung total hari
    $start = $month = strtotime($tgl_mulai);
    $end = strtotime($tgl_selesai);

    $awal = date_create($tgl_mulai);
    $akhir = date_create($tgl_selesai);

    $jml = date_diff($awal,$akhir);
    if($start <= $end){
        $jml = date_diff($awal,$akhir);
        $jml_hari = $jml->days +1;
    }else{
        $jml_hari = 0;
    }

    $arrayTgl = array();
    
    // $perulanganShift = $skemaShift*$jmlShift;
    
    if($jml_hari >0){
        $indexHariMulai = $dayList[date('D', strtotime($tgl_mulai))];
        if( $indexHariMulai > 0 ){
            $indexMulai = 7 - $indexHariMulai;
            $tglMulai = date('Y-m-d', strtotime("+$indexMulai day", $month));
            // echo $tglMulai."<br>";
            // echo $indexMulai." ".date('D', strtotime($tgl_mulai)) ;
        }
        while($month <= $end){
            
    
            foreach($arrayShifting AS $dayORnight => $value){
                $tglCek = date('Y-m-d', $month);
                $cekMulai = $dayList[date('D', strtotime($tglCek))];
    
    
                if($month == $start){
                    $mulaiShiftSama = $skemaShift-$cekMulai;
                    // echo $mulaiShiftSama;
                }else{
                    $mulaiShiftSama = $skemaShift;
                }
    
                
                
                $tgl = date('Y-m-d', $month);
                $data = [$tgl,$dayORnight,$value];
                array_push($arrayTgl, $data);
                // echo $tgl." $value<br>";
    
    
                $month = strtotime("+$mulaiShiftSama day", $month);
                // echo $month." == $start<br>";
            }
        }
    }
    // var_dump($arrayTgl);
    $dataArray = array();
    foreach($arrayTgl AS $data => $shift){
        $tanggal = strtotime($shift[0]);
        $tglCek = date('Y-m-d', $tanggal);
                $cekMulai = $dayList[date('D', strtotime($tglCek))];
        // echo $tanggal."<br>";
        if($tanggal == $start){
            $mulaiShiftSama = $skemaShift-$cekMulai;
            // echo $mulaiShiftSama;
        }else{
            $mulaiShiftSama = $skemaShift;
        }
        for($i = 0 ; $i < $mulaiShiftSama ; $i++){
            
            $tgl = date('Y-m-d', strtotime("+$i day",$tanggal ));
            
            
            $tglAkhirCek =strtotime( $tgl);
            if($tglAkhirCek <= $end){
                $dataAkhir = array($tgl,$shift[2],$shiftInput);
                // echo "$tgl : $shift[2]<br>";
                array_push($dataArray, $dataAkhir);
            }
            
            
        }
    }
    $dataFinal = json_encode($dataArray);
    return $dataFinal;
}
function cutiTahunan($link, $npk, $tahunPeriod){

}
function cutiPanjang($link, $npk, $tglMasuk){

}
function cuti(){
    
}
function WD($link, $shift, $tanggal){
    /// cek working days
    $query_workingDays = "SELECT working_hours.id AS id_wh,
        working_hours.start AS ci,
        working_hours.end AS co,
        working_hours.code_name AS code_wh,
        working_days.date AS tgl,
        working_days.wh AS wh,
        working_days.ket AS ket,
        working_days.id AS id
            
    FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
    WHERE working_days.shift = '$shift' AND working_days.date = '$tanggal' ";
    $sqlWD = mysqli_query($link, $query_workingDays)or die(mysqli_error($link));
    $dataWD = mysqli_fetch_assoc($sqlWD);
    $cin = ($dataWD['ci'] == '' )? "00:00" : $dataWD['ci'];
    $cout = ($dataWD['co'] == '' )? "00:00" : $dataWD['co'];
    // echo $dataWD['wh'];
    // echo $dataWD['ci'];
    // echo $dataWD['co'];
    // // echo $cout;
    // $waktu_awal = strtotime("2019-10-11 07:15:00");
    // $waktu_akhir = strtotime("2019-10-11 16:00:00"); // bisa juga waktu sekarang now()
    // echo $dataWD['code_wh']."<br/>";
    if($cin > $cout){
        $tglini = $dataWD['tgl'];
        $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($dataWD['tgl'])));
    }else{
        $tglini = $dataWD['tgl'];
        $sesudah = $dataWD['tgl'];
    }
    $waktuAwal = strtotime("$tglini $cin");
    $waktuAkhir = strtotime("$sesudah $cout"); // bisa juga waktu sekarang now()
            
    //menghitung selisih dengan hasil detik
    $diff = $waktuAkhir - $waktuAwal;

    //membagi detik menjadi jam
    $jam = floor($diff / (60 * 60));

    //membagi sisa detik setelah dikurangi $jam menjadi menit
    $menit = $diff - $jam * (60 * 60);

    $jml = mysqli_num_rows($sqlWD);

    $tglMasuk = $tglini;
    $tglPulang = $sesudah;
    $checkIn = $cin;
    $checkOut = $cout;


    return array($tglMasuk, $tglPulang, $checkIn, $checkOut, $jml);
}
?>