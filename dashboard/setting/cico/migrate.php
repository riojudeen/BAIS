<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        echo $_FILES['file_import']['name'];
        $today = date('Y-m-d');
        $pecahtanggal = explode("-", $today);
        $extention = '.xls';
        $nama_file = $pecahtanggal[2].$pecahtanggal[1].$extention;
        $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/".$nama_file;
        
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $dataImage = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
           
        } else {
            $base64 = base_url()."/assets/img/img/tm.png";
            // $file = fopen($path, "r");
            // echo "File berhasil dibaca.";
        }
    }else{
        echo "data belum masuk";
    }
    ?>