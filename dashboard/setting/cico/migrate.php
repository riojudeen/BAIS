<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    // if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        // echo $_FILES['file_import']['name'];
        $firstdate = date('Y-m-1');
        $today = date('Y-m-d');
        $pecahtanggal = explode("-", $today);
        $extention = '.xls';
        $nama_file = $pecahtanggal[0].$pecahtanggal[1].$extention;
        $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/".$nama_file;
        
        
        // echo $path;
        if (file_exists($path)) {
            // echo $path['name'];
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            

            $indexColumn = 4 ;
            $jml_hari = hitungHari($firstdate, $today);
            $lastcolomn = $indexColumn + $jml_hari;
            //menghitung total hari
            $mulai = $firstdate ;
            $selesai = $today ;
    
            $tgl_pertama = date('Y-m-d', strtotime($mulai));
            $tgl_terakhir = date('Y-m-d', strtotime($selesai));
            $start = $month = strtotime($tgl_pertama);
            $end = strtotime($tgl_terakhir);
    
            $awal = date_create($tgl_pertama);
            $akhir = date_create($tgl_terakhir);
    
            $no_urut = 1;
            $i = 0;
            $array_tgl = array();
            while($month <= $end){
                $tgl = date('Y-m-d', $month);
                $month = strtotime("+1 day", $month);
                $hari = hari_singkat($tgl);
                $array_tgl[$i++] = $tgl;
            }
            print_r($array_tgl);
            
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $spreadsheet = $reader->load($path);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $sheetColumn = $spreadsheet->getActiveSheet();
            $lastColumn = $sheetColumn->getHighestColumn();
            $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
            


            foreach($array_tgl AS $date){
                // looping data karyawan
                $index_tanggal =( date('d', strtotime($date)) - 1)*3;
                
                for($i = 3;$i < count($sheetData);$i++){
                    
                    $npk = $sheetData[$i]['0'];
                    $nama = $sheetData[$i]['1'];
                    $dept = $sheetData[$i]['2'];
                    $shift = $sheetData[$i]['3'];
                    $scope = $sheetData[$i]['4'];
                    // ambil data check ini -out -ket berdasarkan tanggal mulai
                    $index_mulai = 4 + $index_tanggal; //index pertama 5
                    $in = $index_mulai + 1;
                    $out = $index_mulai + 2;
                    $ket = $index_mulai + 3;

                    $checkin = $sheetData[$i][$in];
                    $checkout = $sheetData[$i][$out];
                    $ket = $sheetData[$i][$ket];
                    $id= $npk.$date;

                    if($scope == 'Absen'){
                        echo $date."-".$scope."- in : ".$checkin."- out : ".$checkout."<br>";
                    }else if($scope == 'Lembur'){
                        echo $date."-".$scope."- in : ".$checkin."- out : ".$checkout."<br>";
                    }
                     /*
                    selama belum ada perubahan data shift , 
                    gunakan shift awal
                    */
                    // $q_reqAbsensi = mysqli_query($link, "SELECT `shift` FROM req_absensi WHERE npk = '$npk' AND `date` = '$date' AND shift_req = '1' ")or die(mysqli_error($link));
                    
    
    
                    
                    // $q_shift = mysqli_query($link, "SELECT shift FROM karyawan WHERE npk = '$npk' ")or die(mysqli_error($link));
                    // if(mysqli_num_rows($q_reqAbsensi) > 0){
                    //     $data = mysqli_fetch_assoc($q_reqAbsensi);
                    //     $shift = $data['shift'];
                    // }else if(mysqli_num_rows($q_shift) > 0){
                    //     $data = mysqli_fetch_assoc($q_shift);
                    //     $shift = $data['shift'];
                    // }else{
                    //     // menggunakan shift dari dokumen
                    //     $shift = shift_ubah($shift);
                    // }
                    
                    
                    // $query .= "('$id','$npk','$shift', '$date', '$date','$date','$checkin','$checkout','$ket','$id','$npkUser'),";
                    
                    ?>
                    
                    <?php
                    
                }
            }


        } else {
            $base64 = base_url()."/assets/img/img/tm.png";
            // echo "null";
            // $file = fopen($path, "r");
            // echo "File berhasil dibaca.";
        }
    // }else{
    //     echo "data belum masuk";
    // }
    ?>