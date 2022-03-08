<?php
require_once("../../../../config/config.php");
require_once("../../../../config/error.php");
require "../../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        // mysqli_query($link, "DELETE FROM division");
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        if($_POST['part'] == 'division'){
            $sql = "REPLACE INTO `division`(`id_div`, `nama_divisi`, `npk_cord`, `id_company`, `part`) VALUES "; 
        }else if($_POST['part'] == 'deptAcc'){
            $sql = "REPLACE INTO `dept_account`(`id_dept_account`, `department_account`, `npk_dept`, `id_div`, `part`) VALUES "; 
        }else if($_POST['part'] == 'section'){
            $sql = "REPLACE INTO `section`(`id_section`, `section`, `npk_cord`, `id_dept`, `part`) VALUES "; 
        }else if($_POST['part'] == 'dept'){
            $sql = "REPLACE INTO `department`(`id_dept`, `dept`, `npk_cord`, `id_div`, `part`) VALUES"; 
        }else if($_POST['part'] == 'group'){
            $sql = "REPLACE INTO `groupfrm`(`id_group`, `nama_group`, `npk_cord`, `id_section`, `part`) VALUES "; 
        }else if($_POST['part'] == 'pos'){
            $sql = "REPLACE INTO `pos_leader`(`id_post`, `nama_pos`, `npk_cord`, `id_group`, `part`) VALUES "; 
        }else{
            $_SESSION['info'] = "Kosong";
            header("Location: ../index.php");
        }

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for($i = 1;$i < count($sheetData);$i++){
            $code = $sheetData[$i]['2'];
            $nama = $sheetData[$i]['0'];
            $cord = $sheetData[$i]['1'];
            $id_parent = $sheetData[$i]['3'];
            $part = $_POST['part'];
            
            $sql .=" ('$code', '$nama', '$cord','$id_parent','$part'),";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $data = mysqli_query($link, $sql);
        echo $sqlUser;
        if($data){
            $total = count($sheetData) - 1;
            // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
            $_SESSION['tab'] = $part;
            $_SESSION['info'] = "Disimpan";
            $_SESSION['pesan'] = $total;
            header("Location: ../index.php");
        }else{
            $_SESSION['tab'] = $part;
            $_SESSION['kodeerror'] = mysqli_errno($link);
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