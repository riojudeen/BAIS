<?php
require_once("../../../../config/config.php");
require_once("../../../../config/error.php");
require "../../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
        $sql = "REPLACE INTO org (`npk`, `post`, `grp`, `sect`, `dept`, `dept_account`, `division`, `plant`) VALUES";
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for($i = 2;$i < count($sheetData);$i++){
            $npk = $sheetData[$i]['1'];
            $pos = $sheetData[$i]['7'];
            $group = $sheetData[$i]['8'];
            $section = $sheetData[$i]['9'];
            $dept = $sheetData[$i]['10'];
            $dept_account = $sheetData[$i]['11'];
            $division = $sheetData[$i]['12'];

            $npk = ($npk != '')?"'$npk'":"NULL";
            $pos = ($pos != '')?"'$pos'":"NULL";
            $group = ($group!= '')?"'$group'":"NULL";
            $section = ($section != '')?"'$section'":"NULL";
            $dept = ($dept != '')?"'$dept'":"NULL";
            $dept_account =($dept_account != '')?"'$dept_account'":"NULL";
            $division = ($division != '')?"'$division'":"NULL";
            
            $sql .=" ($npk, $pos, $group,$section,$dept,$dept_account,$division, '1'),";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $data = mysqli_query($link, $sql)or die(mysqli_error($link));
        // echo $sqlUser;
        if($data){
            $total = count($sheetData) - 2;
            // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
            
            $_SESSION['info'] = "Disimpan";
            $_SESSION['pesan'] = $total;
            header("Location: ../index.php"); 
        }else{
            
            $_SESSION['pesan'] = error(mysqli_errno($link),mysqli_error($link), $part);
            $_SESSION['info'] = "Import Gagal";
            header("Location: ../index.php");
        }
        
    }else{
        // echo "tes NG";
        $_SESSION['info'] = "Kosong";
        header("Location: ../index.php");
    }
?>