<?php
// function untuk get menit istirahat overtime
include_once('config.php');
function break_time_ot($link, $shift, $date, $start_ot, $end_ot){
    $link = $link; //connection
    // cek Working hours
    $array_break = array();
    $array_tot_break = array();
    $cekWH = mysqli_query($link, "SELECT working_days.ket AS `ket`, working_days.break_id AS `break_id`, working_hours.id, working_hours.start AS `start`,  working_hours.end AS `end`
        FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date' AND working_days.shift = '$shift' ")or die(mysqli_error($link));
    
    if(mysqli_num_rows($cekWH)>0){
        $data = mysqli_fetch_assoc($cekWH);
        $waktuAwal = strtotime("$date $data[start]");
        $waktuAkhir = strtotime("$date $data[end]"); // bisa juga waktu sekarang now()
        $wb = $data['break_id']; //
        // $ket = $data['ket']; // 

        // $start_time = $data['start'];
        // $end_time = $data['end'];

        $query_break = "SELECT working_break.id AS 'id_break' , working_break.start_time AS 'break_start' , working_break.end_time AS 'break_end'
        FROM working_break JOIN working_break_shift ON working_break_shift.id_working_break = working_break.id
        WHERE working_break_shift.break_group_id = '$wb'";
        $sql_break = mysqli_query($link, $query_break)or die(mysqli_error($link));
        if(mysqli_num_rows($sql_break)>0){
            while($data_break = mysqli_fetch_assoc($sql_break)){
                $time_break = array(
                    'start_break' => "$data_break[break_start]",
                    'end_break' => "$data_break[break_end]"
                );
                array_push($array_break, $time_break);
            }
        }
        if($waktuAwal > $waktuAkhir){
            $tglini = ($date);
            $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
            
            
        }else{
            $tglini = $date;
            $sesudah = $date;
        }

        $str_start_ot = strtotime("$tglini $start_ot");
        $str_end_ot = strtotime("$sesudah $end_ot");
        $total_ot = ($str_end_ot - $str_start_ot)/60;
        foreach($array_break AS $break => $val_break){
            $str_start_break = strtotime("$tglini $val_break[start_break]");
            $str_end_break = strtotime("$sesudah $val_break[end_break]");
            $total_break = ($str_end_break-$str_start_break)/60;
            if(($str_start_ot <= $str_start_break && $str_end_ot <= $str_start_break) || ($str_start_ot >= $str_end_break && $str_end_ot >= $str_end_break)){
                $total_break_time = 0;
                
            }else if($str_start_ot >= $str_start_break && $str_end_ot <= $str_end_break){
                
                $total_break_time = $total_ot;
            }else if($str_start_ot >= $str_start_break && $str_end_ot >= $str_end_break){
                
                $total_break_time = ($str_end_break - $str_end_ot)/60;
            }else if($str_start_ot <= $str_start_break && $str_end_ot >= $str_end_break){

                $total_break_time = $total_break;
            }else if($str_start_ot <= $str_start_break && $str_end_ot <= $str_end_break){

                $total_break_time = ($str_end_ot - $str_start_break)/60;
            }
            array_push($array_tot_break, $total_break_time);
        }
        
    }
    return $array_tot_break;
    //get working break 

}
$shift = "N";
$date = date('Y-m-d');
$start_ot = '07:00';
$end_ot = '17:00';
// print_r(break_time_ot($link, $shift, $date, $start_ot, $end_ot));
// echo array_sum(break_time_ot($link, $shift, $date, $start_ot, $end_ot));
// function untuk dapat data date out
function DateOut($date, $cin, $cout){
    if($date != '' && $cin != '' && $cout != ''){
        $waktuAwal = strtotime("$date $cin");
        $waktuAkhir = strtotime("$date $cout"); // bisa juga waktu sekarang now()
        if($waktuAwal > $waktuAkhir){
            $tglini = ($date);
            $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
        }else{
            $tglini = $date;
            $sesudah = $date;
        }
        
    }else{
        $tglini = '';
        $sesudah = '';
    }
    return array($tglini, $sesudah);
    
}

function whwithket($link, $shift, $date){
    $cekWH = mysqli_query($link, "SELECT working_days.ket AS `ket`, working_days.break_id AS `break_id`, working_hours.id, working_hours.start AS `start`,  working_hours.end AS `end`
        FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date' AND working_days.shift = '$shift' ")or die(mysqli_error($link));
    if(mysqli_num_rows($cekWH)>0){
        $data = mysqli_fetch_assoc($cekWH);
        $waktuAwal = strtotime("$date $data[start]");
        $waktuAkhir = strtotime("$date $data[end]"); // bisa juga waktu sekarang now()
        $wb = $data['break_id']; //
        $ket = $data['ket']; // 
        $start_time = $data['start'];
        $end_time = $data['end'];
        if($waktuAwal > $waktuAkhir){
            $tglini = ($date);
            $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
        }else{
            $tglini = $date;
            $sesudah = $date;
        }
    }else{
        $tglini = $date;
        $sesudah = $date;
    }
    return array($tglini, $sesudah, $start_time, $end_time, $ket, $wb);
}


function getShiftByTime($link, $date, $time){
    $str_time = "$time";

    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
    // 
    // echo "curr : ".$time."<br>";
    $qWH = "SELECT 
            working_days.ket AS `ket`, 
            working_days.break_id AS `break_id`,working_days.shift AS `shift`, working_hours.id, TIME_TO_SEC(working_hours.start) AS `start`,  working_hours.end AS `end`
            FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date'";
    $cekKet =  mysqli_query($link, $qWH." GROUP BY ket ")or die(mysqli_error($link));
    $dataKet = mysqli_fetch_assoc($cekKet);
    $ket = $dataKet['ket'];

    $cekWH = mysqli_query($link, $qWH." AND TIME_TO_SEC(working_hours.start) <= '$time' ")or die(mysqli_error($link));
    $shift = "";
    if(mysqli_num_rows($cekWH)>0){
        while($data = mysqli_fetch_assoc($cekWH)){
            $shift .= "employee_shift = '$data[shift]' OR ";
        }
    }
    $shift = substr($shift, 0 ,-3);
    return array($ket, $shift);
    // return array($tglini, $sesudah, $start_time, $end_time, $ket, $wb);
}
function workingHours($link, $shift, $date){
    $cekWH = mysqli_query($link, "SELECT working_hours.id, working_hours.start AS `start`,  working_hours.end AS `end`
    FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date' AND working_days.shift = '$shift' ")or die(mysqli_error($link));
    if(mysqli_num_rows($cekWH)>0){
        $data = mysqli_fetch_assoc($cekWH);
        $waktuAwal = strtotime("$date $data[start]");
        $waktuAkhir = strtotime("$date $data[end]"); // bisa juga waktu sekarang now()
        $start_time = $data['start'];
        $end_time = $data['end'];
        if($waktuAwal > $waktuAkhir){
            $tglini = ($date);
            $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
        }else{
            $tglini = $date;
            $sesudah = $date;
        }
    }else{
        $tglini = $date;
        $sesudah = $date;
    }
    return array($tglini, $sesudah, $start_time, $end_time);
}
function genericOut($link, $date, $shift){
    $link = $GLOBALS['link'];
    $cekWH = mysqli_query($link, "SELECT working_days.ket AS `ket`, working_hours.start AS `start`,  working_hours.end AS `end`
    FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date' AND working_days.shift = '$shift' ")or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($cekWH);

    $waktuAwal = strtotime("$date $data[start]");
    $waktuAkhir = strtotime("$date $data[end]"); // bisa juga waktu sekarang now() 
    $ket = $data['ket'];
    
    if(mysqli_num_rows($cekWH)>0){
        if($ket == 'DOP'){
            if($waktuAwal > $waktuAkhir){
                $tglini = ($date);
                $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
            }else{
                $tglini = $date;
                $sesudah = $date;
            }
        }else{
            $tglini = $date;
            $sesudah = $date;
        }
        
    }else{
        $tglini = $date;
        $sesudah = $date;
    }
    return array($tglini, $sesudah, $ket);
}
function DateOut2($link, $shift, $date){
    $cekWH = mysqli_query($link, "SELECT working_days.ket AS `ket`, working_hours.start AS `start`,  working_hours.end AS `end`
    FROM working_days JOIN working_hours ON working_hours.id = working_days.wh WHERE working_days.date = '$date' AND working_days.shift = '$shift' ")or die(mysqli_error($link));
    if(mysqli_num_rows($cekWH)>0){
        $data = mysqli_fetch_assoc($cekWH);
        $waktuAwal = strtotime("$date $data[start]");
        $waktuAkhir = strtotime("$date $data[end]"); // bisa juga waktu sekarang now()
        
        if($waktuAwal > $waktuAkhir){
            $tglini = ($date);
            $sesudah = date('Y-m-d', strtotime("+1 days", strtotime($date)));
        }else{
            $tglini = $date;
            $sesudah = $date;
        }
    }else{
        $tglini = $date;
        $sesudah = $date;
    }
    return array($tglini, $sesudah);
}
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
