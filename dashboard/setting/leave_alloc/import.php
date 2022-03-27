<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 if(isset($_POST['import_cuti'])){
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
     
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $today = date('Y-m-d');
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        $sql = "INSERT INTO req_absensi 
            (`id`,
            `npk`,
            `shift`,
            `date`,
            `date_in`,
            `date_out`,
            `check_in`,
            `check_out`,
            `keterangan`,
            `requester`,
            `status`,
            `req_status`,
            `req_date`,
            `note`, 
            `shift_req`
            ) VALUES ";
        $max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS id FROM req_absensi"));
        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        // echo count($sheetData);
        $no = 1;
        $idx = 1;
        for($i = 1;$i < count($sheetData);$i++){
            
            $npk = $sheetData[$i]['1'];
            $dataShift = mysqli_fetch_assoc(mysqli_query($link, "SELECT shift FROM karyawan WHERE npk = '$npk' "));
            $shift = $dataShift['shift'];
            $date_mulai = $sheetData[$i]['6'];
            $date_selesai = $sheetData[$i]['7'];
            
            // $date_out = "tanggal keluar";
            $check_in = ($sheetData[$i]['8'] == "")?"00:00:00":$sheetData[$i]['8'];
            $check_out = ($sheetData[$i]['9'] == "")?"00:00:00":$sheetData[$i]['9'];
            $keterangan = $sheetData[$i]['4'];
            $requester = $npkUser;
            switch($sheetData[$i]['12']){
                case "PENDING": //belum diapprove oleh Manager
                    $status = '25';
                    $req_status = "a";
                    break;
                case "-": //belum diapprove oleh Manager
                    $status = '25';
                    $req_status = "a";
                    break;
                case "APPROVED ONLINE": //approve online pleh manager
                    $status = '100';
                    $req_status = "f";
                    break;
                case "OK": //close
                    $status = '100';
                    $req_status = "a";
                    break;
                case "NOK": //ditolak / dihentikan
                    $status = '100';
                    $req_status = "c";
                    break;
            }
            
            
            //cari selisih tanggal
            $tanggalAwal = date('Y-m-d', strtotime($date_mulai));
            $tanggalAkhir = date('Y-m-d', strtotime($date_selesai));

            $count_awal = date_create($tanggalAwal);
            $count_akhir = date_create($tanggalAkhir);
            if($count_awal  <= $count_akhir){
                $hari = date_diff($count_awal,$count_akhir)->days +1;;
            }else{
                $hari = 0;
            }
            $start = $month = strtotime($tanggalAwal);
            $end = strtotime($tanggalAkhir);
            $index = 0;
            
            while($month <= $end){ 
                $tgl = date('Y-m-d', $month);
                $month = strtotime("+1 day", $month);
                $array_tgl[$index] = $tgl;
                
            
                
                // mencari date_in dan date_out berdasarkan shift
                $wD = mysqli_fetch_assoc(mysqli_query($link, "SELECT working_hours.id AS id_wh,
                    working_hours.start AS ci,
                    working_hours.end AS co,
                    working_days.shift AS shf,
                    working_hours.code_name AS code_wh,
                    working_days.date AS tgl,
                    working_days.wh AS wh,
                    working_days.ket AS ket,
                    working_days.id AS id
                        
                FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
                WHERE working_days.shift = '$shift' AND working_days.date = '$array_tgl[$index]' "));
                
                $cin = $wD['ci'];
                $cout = $wD['co'];
                $waktuAwal = strtotime("$array_tgl[$index] $cin");
                $waktuAkhir = strtotime("$array_tgl[$index] $cout"); // bisa juga waktu sekarang now()
                
                $date_out =($waktuAwal > $waktuAkhir)? date('Y-m-d', strtotime("+1 days", strtotime($array_tgl[$index]))) : $array_tgl[$index];
                $date_in = $array_tgl[$index];
                $date = $date_in;
                $id =  $npk.$date; //untuk id
                
                // echo $id;
                
                $req_date = date('Y-m-d');
                $note = "transfer PS";
                //cek absensi 
                $cek_abs = mysqli_query($link, "SELECT 
                    `id`, `npk` , `date`
                    FROM absensi WHERE  `date` = '$date_in' AND id = '$id'
                ")or die(mysqli_error($link));
                // cek pengajuan
                $cek_req = mysqli_query($link, "SELECT 
                    `id`,
                    `npk`,
                    `shift`,
                    `date`,
                    `date_in`,
                    `date_out`,
                    `check_in`,
                    `check_out`,
                    `keterangan`,
                    `requester`,
                    `status`,
                    `req_status`,
                    `req_date`,
                    `note`, 
                    `shift_req`
                    FROM req_absensi WHERE `date` = '$date_in' AND id = '$id' AND npk = '$npk' AND keterangan = '$keterangan' 
                    AND shift_req <> '1' ")or die(mysqli_error($link));
                // jika pengajuan sudah pernah dibuat, lakukan update
                if(mysqli_num_rows($cek_req)>0){
                    $query = " UPDATE req_absensi SET
                        `status` = '$status' ,
                        `req_status` = '$req_status'
                        WHERE `date` = '$date_in' AND id = '$id' AND keterangan = '$keterangan' AND shift_req <> '1'
                    ";
                    // echo $idx." - ".$query."<br>";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                }else{
                    //jika belum pernah dibuat, cek apakah data absensi sudah ada sebelum tanggal sekarang?
                    //jika belum , jadikan sebagai arsip, jika sudah jadikan sebagai request baru
                    if(mysqli_num_rows($cek_abs)>0){
                        $delete_date = "NULL";
                    }else{
                        if(strtotime($date_in) > strtotime($today) ){
                            //jadikan sebagai arsip
                            $delete_date = "NULL";
                        }else{
                            $delete_date = "'$today'";
                        }
                    }
                    // echo "INSERT";
                    $shift_req = '0';
                    $query = " INSERT INTO req_absensi (`id`, `npk`,
                    `shift`,
                    `date`,
                    `date_in`,
                    `date_out`,
                    `check_in`,
                    `check_out`,
                    `keterangan`,
                    `requester`,
                    `status`,
                    `req_status`,
                    `req_date`,
                    `note`, 
                    `shift_req`, `delete_date`) VALUES ('$id' ,
                        '$npk' ,
                        '$shift' ,
                        '$date_in' ,
                        '$date_in' ,
                        '$date_out',
                        '$check_in',
                        '$check_out',
                        '$keterangan',
                        '$requester' ,
                        '$status' ,
                        '$req_status',
                        '$req_date',
                        '$note' , 
                        '$shift_req', $delete_date )";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    
                }
                $index++;
                $idx++;
                
            }
        }
        $total = count($sheetData) - 1;
      
        if($sql){
            // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
            $_SESSION['info'] = "Disimpan";
            header("Location: index.php"); 
        }else{
            $_SESSION['info'] = "Gagal Disimpan";
            $_SESSION['pesan'] = mysqli_error($link);
            header("Location: index.php");
        }
       
    }else{
        $_SESSION['info'] = "Kosong";
        header("Location: ../manpower.php");
    }
 }else{
     if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
     
         $arr_file = explode('.', $_FILES['file_import']['name']);
         $extension = end($arr_file);
     
         if('csv' == $extension) {
             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
         } else {
             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
         }
         
         $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
         $sql = "INSERT INTO req_absensi (id , npk , shift , `date` , date_in , date_out , check_in , check_out , keterangan , requester , `status`, req_status, req_date, note ) VALUES ";
         $max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS id FROM req_absensi"));
         // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
         $sheetData = $spreadsheet->getActiveSheet()->toArray();
         // echo count($sheetData);
         $no = 1;
         for($i = 1;$i < count($sheetData);$i++){
             
             $npk = $sheetData[$i]['1'];
             $dataShift = mysqli_fetch_assoc(mysqli_query($link, "SELECT shift FROM karyawan WHERE npk = '$npk' "));
             $shift = $dataShift['shift'];
             $date_mulai = $sheetData[$i]['6'];
             $date_selesai = $sheetData[$i]['7'];
             
             // $date_out = "tanggal keluar";
             $check_in = ($sheetData[$i]['8'] == "")?"00:00:00":$sheetData[$i]['8'];
             $check_out = ($sheetData[$i]['9'] == "")?"00:00:00":$sheetData[$i]['9'];
             $keterangan = $sheetData[$i]['4'];
             $requester = $npkUser;
             if($sheetData[$i]['12'] == "OK"){
                 $status = '100';
                 $req_status = "a";
             }else if($sheetData[$i]['12'] == "NOK"){
                 $status = '100';
                 $req_status = "b";
             }else{
                 $status = '75';
                 $req_status = "a";
             }
             
             $req_date = date('Y-m-d');
             $note = "transfer PS";
             
             //cari selisih tanggal
             $tanggalAwal = date('Y-m-d', strtotime($date_mulai));
             $tanggalAkhir = date('Y-m-d', strtotime($date_selesai));
 
             $count_awal = date_create($tanggalAwal);
             $count_akhir = date_create($tanggalAkhir);
             if($count_awal  <= $count_akhir){
                 $hari = date_diff($count_awal,$count_akhir)->days +1;;
             }else{
                 $hari = 0;
             }
             $start = $month = strtotime($tanggalAwal);
             $end = strtotime($tanggalAkhir);
             $index = 0;
             while($month <= $end){ 
                 $tgl = date('Y-m-d', $month);
                 $month = strtotime("+1 day", $month);
                 $array_tgl[$index] = $tgl;
                 
             
                 
                 // mencari date_in dan date_out berdasarkan shift
                 $wD = mysqli_fetch_assoc(mysqli_query($link, "SELECT working_hours.id AS id_wh,
                     working_hours.start AS ci,
                     working_hours.end AS co,
                     working_days.shift AS shf,
                     working_hours.code_name AS code_wh,
                     working_days.date AS tgl,
                     working_days.wh AS wh,
                     working_days.ket AS ket,
                     working_days.id AS id
                         
                 FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
                 WHERE working_days.shift = '$shift' AND working_days.date = '$array_tgl[$index]' "));
                 
                 $cin = $wD['ci'];
                 $cout = $wD['co'];
                 $waktuAwal = strtotime("$array_tgl[$index] $cin");
                 $waktuAkhir = strtotime("$array_tgl[$index] $cout"); // bisa juga waktu sekarang now()
                 
                 $date_out =($waktuAwal > $waktuAkhir)? date('Y-m-d', strtotime("+1 days", strtotime($array_tgl[$index]))) : $array_tgl[$index];
                 $date_in = $array_tgl[$index];
                 $date = $date_in;
                 $id =  $npk.$date; //untuk id
                 // echo $cin."<br>";
                 // echo $cout."<br>";
                 // echo $hari." hari <br>";
                 // echo $id." hari <br>";
                 // echo $startDay;
                 // // echo "----- <br>";
                 // // echo "id -".$id."<br>";
                 // echo $npk."<br>";
                 // echo $shift."<br>";
                 // echo $array_tgl[$startDay]."<br>";
                 // echo $date."<br>";
                 // echo $date_in."<br>";
                 // echo $date_out."<br>";
                 // echo $keterangan."<br>";
                 // // echo $requester."<br>";
                 // echo $check_in."<br>";
                 // echo $check_out."<br>";
                 // echo $status."<br>";
                 // echo $req_status."<br>";
                 // echo $req_date."<br>";
                 // echo $note."<br>";
                 // echo "----- <br>";
                 $sql .= "('$id', '$npk', '$shift', '$date', '$date_in', '$date_out', '$check_in', '$check_out', '$keterangan', '$requester', '$status', '$req_status', '$req_date', '$note' ),";
                 $index++;
 
             }
             
         }
         $total = count($sheetData) - 1;
         $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
         $data = mysqli_query($link, $sql)or die(mysqli_error($link));
         // echo $sql;
         
         //query dan alihkan
         if($data){
             // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
             $_SESSION['info'] = "Disimpan";
             header("Location: index.php"); 
         }else{
             $_SESSION['info'] = "Kosong";
             header("Location: index.php");
         }
         // echo $sql."<br>";
         // echo $total."<br>";
 
 
 
 
 
 
         // $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
         // // $sqlUser = substr($dataUser, 0 , -1); //untuk trim koma terakhir
         // $total = count($sheetData) - 3;
         // $data = mysqli_query($link, $sql)or die(mysqli_error($link));
         // // echo $sqlUser;
         // if($data){
         //     // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
         //     $_SESSION['info'] = "Disimpan";
         //     header("Location: ../manpower.php"); 
         // }else{
         //     $_SESSION['info'] = "Kosong";
         //     header("Location: ../manpower.php");
         // }
     }else{
         // $_SESSION['info'] = "Kosong";
         // header("Location: ../manpower.php");
     }
 }


 

?>