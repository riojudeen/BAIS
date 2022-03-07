<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
require("../../../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_SESSION['user'])){
    if($_GET['export'] == "wh" ){
        $tanggal_mulai = dateToDB($_GET['start_date']);
        $tanggal_selesai = dateToDB($_GET['end_date']);
        $tanggal = date('d-M-y');
        $spreadsheet = new Spreadsheet();
        
        // Add some data
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('WD');
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('shift');
        
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setTitle('jam kerja');

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(3);
        $spreadsheet->getActiveSheet()->setTitle('skema istirahat');

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(4);
        $spreadsheet->getActiveSheet()->setTitle('waktu istirahat');

        $spreadsheet->setActiveSheetIndex(0);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Shift');
        $sheet->setCellValue('D1', 'Kode Jam Kerja');
        $sheet->setCellValue('E1', 'DAY / NIGHT');
        $sheet->setCellValue('F1', 'Check In');
        $sheet->setCellValue('G1', 'Check Out');
        $sheet->setCellValue('H1', 'Operational');
        $sheet->setCellValue('J1', 'Kode Istirahat');
        
        $sqlWd = mysqli_query($link, "SELECT working_days.date AS `date`,
                working_days.shift AS `shift`,
                working_days.id AS `id`,
                working_days.wh AS `wh`,
                working_days.break_id AS `break_id`,
                working_days.ket AS `operational`,
                working_hours.code_name AS `code_name`,
                working_hours.start AS `start_time`,
                working_hours.end AS `end_time`, 
                working_hours.ket AS `ket`,
                working_day_shift.name AS `name`
                FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh
                LEFT JOIN working_day_shift ON working_hours.code_name = working_day_shift.id
                WHERE working_days.date BETWEEN '$tanggal_mulai' AND '$tanggal_selesai' ORDER BY working_days.shift ")or die(mysqli_error($link));
        $no = 2;
        $i=1;
        while($data = mysqli_fetch_assoc($sqlWd)){
            $sheet->setCellValue('A'.$no, $i);
            $sheet->setCellValue('B'.$no, $data['date']);
            $sheet->setCellValue('C'.$no, $data['shift']);
            $sheet->setCellValue('D'.$no, $data['wh']);
            $sheet->setCellValue('H'.$no, $data['operational']);
            $sheet->setCellValue('J'.$no, $data['break_id']);
            $no ++;
            $i++;
        }
        $sheet2 = $spreadsheet->setActiveSheetIndex(1);   
        $sheet2->setCellValue('A1', 'No');
        $sheet2->setCellValue('B1', 'Kode Shift');
        $sheet2->setCellValue('C1', 'Shift');
        $sql_shift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
        $no = 2;
        $i=1;
        while($dataShift = mysqli_fetch_assoc($sql_shift)){
            $sheet2->setCellValue('A'.$no, $i);
            $sheet2->setCellValue('B'.$no, $dataShift['id_shift']);
            $sheet2->setCellValue('C'.$no, $dataShift['shift']);
            $no ++;
            $i++;
        }
        $sheet3 = $spreadsheet->setActiveSheetIndex(2);   
        $sheet3->setCellValue('A1', 'No');
        $sheet3->setCellValue('B1', 'Code Name');
        $sheet3->setCellValue('C1', 'Start Time');
        $sheet3->setCellValue('D1', 'End Time');
        $sheet3->setCellValue('E1', 'Keterangan');
        $sql_wh = mysqli_query($link, "SELECT * FROM working_hours")or die(mysqli_error($link));
        $no = 2;
        $i=1;
        while($dataWh = mysqli_fetch_assoc($sql_wh)){
            $sheet3->setCellValue('A'.$no, $i);
            $sheet3->setCellValue('B'.$no, $dataWh['code_name']);
            $sheet3->setCellValue('C'.$no, $dataWh['start']);
            $sheet3->setCellValue('D'.$no, $dataWh['end']);
            $sheet3->setCellValue('E'.$no, $dataWh['ket']);
            $no ++;
            $i++;
        }
        $sheet4 = $spreadsheet->setActiveSheetIndex(3);   
        $sheet4->setCellValue('A1', 'No');
        $sheet4->setCellValue('B1', 'Day/Night');
        $sheet4->setCellValue('C1', 'Kode Istirahat');
        $sheet4->setCellValue('D1', 'effective date');
        $sheet4->setCellValue('E1', 'kode skema istirahat');
        $sql_wbs = mysqli_query($link, "SELECT working_break_shift.id_working_day_shift AS `shift`,
        working_day_shift.id AS working_day,
        working_break_shift.id_working_break AS `id_break`,
        working_break_shift.effective_date AS `effective`,
        working_break_shift.break_group_id AS `break_group`,
        working_break.scheme_name AS `skema`,
        working_break.start_time AS `start`,
        working_break.end_time AS `end`
        FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
        LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
        ORDER BY working_break_shift.break_group_id
        ")or die(mysqli_error($link));
        $no = 2;
        $i=1;
        while($dataWbs = mysqli_fetch_assoc($sql_wbs)){
            $sheet4->setCellValue('A'.$no, $i);
            $sheet4->setCellValue('B'.$no, $dataWbs['working_day']);
            $sheet4->setCellValue('C'.$no, $dataWbs['id_break']);
            $sheet4->setCellValue('D'.$no, $dataWbs['effective']);
            $sheet4->setCellValue('E'.$no, $dataWbs['break_group']);
            $no ++;
            $i++;
        }
        $sheet5 = $spreadsheet->setActiveSheetIndex(4);   
        $sheet5->setCellValue('A1', 'No');
        $sheet5->setCellValue('B1', 'id');
        $sheet5->setCellValue('C1', 'Skema');
        $sheet5->setCellValue('D1', 'Start Time');
        $sheet5->setCellValue('E1', 'End Time');
        $sheet5->setCellValue('F1', 'effective date');
        $sql_wb = mysqli_query($link, "SELECT * FROM working_break
        ")or die(mysqli_error($link));
        $no = 2;
        $i=1;
        while($dataWb = mysqli_fetch_assoc($sql_wb)){
            $sheet5->setCellValue('A'.$no, $i);
            $sheet5->setCellValue('B'.$no, $dataWb['id']);
            $sheet5->setCellValue('C'.$no, $dataWb['scheme_name']);
            $sheet5->setCellValue('D'.$no, $dataWb['start_time']);
            $sheet5->setCellValue('E'.$no, $dataWb['end_time']);
            $sheet5->setCellValue('F'.$no, $dataWb['effective_date']);
            $no ++;
            $i++;
        }
        //membuat file name
        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "Data-Working-Days_".$date.".xlsx";

        //savng file
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        $content = file_get_contents($filename);

        //redirect dan download file
        header("Content-Disposition: attachment; filename=".$filename);
        
        unlink($filename);
        exit($content);
        // echo "<script>window.location='../user.php';</script>";
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }