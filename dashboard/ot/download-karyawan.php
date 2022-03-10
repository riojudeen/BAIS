<?php
//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 
include("../../config/schedule_system.php"); 
require("../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_SESSION['user'])){
    if($_GET['export'] == "mp" ){
        $tanggal = date('d-M-y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'NPK');
        $sheet->setCellValue('C2', 'Nama');
        $sheet->setCellValue('D2', 'Jabatan');
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Shift');
        $sheet->setCellValue('G2', 'Tanggal Masuk');
        $sheet->setCellValue('H2', 'Pos');
        $sheet->setCellValue('I2', 'Group');
        $sheet->setCellValue('J2', 'Section');
        $sheet->setCellValue('K2', 'Department');
        $sheet->setCellValue('L2', 'Dept Account');
        $sheet->setCellValue('M2', 'Division');
        
        
        //query mp
        $origin_queryMp = "SELECT 
            view_organization.npk,
            view_organization.nama,
            view_organization.tgl_masuk,
            view_organization.jabatan,
            view_organization.shift,
            view_organization.pos,
            view_organization.status,
            view_organization.pos,
            view_organization.groupfrm,
            view_organization.section,
            view_organization.dept,
            view_organization.subpos,
            view_organization.division,
            view_organization.dept_account,
            view_organization.plant
            
            FROM view_organization ";
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $access_org = orgAccessOrg($level);
        // echo $group_filter;
        $queryMP = filtergenerator($link, $level, $generate, $origin_queryMp, $access_org);
        




        $query_mp = $queryMP;
       
        $sql = mysqli_query($link, $query_mp)or die(mysqli_error($link));

        $data_total = mysqli_num_rows($sql);
        if( $data_total > 0){
            $no = 3;
            $i = 1;
            while($data = mysqli_fetch_assoc($sql)){
                $npk = $data['npk'];
                $nama = $data['nama'];
                $status = $data['status'];
                $jabatan = $data['jabatan'];
                $tgl_masuk = $data['tgl_masuk'];
                $shift = $data['shift'];
                $pos_leader = (!empty($data['pos']))? $data['pos'] : "";
                $groupfrm = (!empty($data['groupfrm']))? $data['groupfrm'] : ""; 
                $section = (!empty($data['section']))? $data['section'] : ""; 
                $department = (!empty($data['dept']))? $data['dept'] : ""; 
                $dept_Account = (!empty($data['dept_account']))? $data['dept_account'] : ""; 
                $division = (!empty($data['division']))? $data['division'] : "-"; 
                $company = $data['plant'];
                
    
                $sheet->setCellValue('A'.$no, $i);
                $sheet->setCellValue('B'.$no, $npk);
                $sheet->setCellValue('C'.$no, $nama);
                $sheet->setCellValue('D'.$no, $jabatan);
                $sheet->setCellValue('E'.$no, $status);
                $sheet->setCellValue('F'.$no, $shift);
                $sheet->setCellValue('G'.$no, $tgl_masuk);
                $sheet->setCellValue('H'.$no, $pos_leader);
                $sheet->setCellValue('I'.$no, $groupfrm);
                $sheet->setCellValue('J'.$no, $section);
                $sheet->setCellValue('K'.$no, $department);
                $sheet->setCellValue('L'.$no, $dept_Account);
                $sheet->setCellValue('M'.$no, $division);
                
                
                $no ++;
                $i++;
                
            }
            

        }
        
            //styling
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $i = $i+1;
            $sheet->getStyle('A1:T'.$i)->applyFromArray($styleArray);
            $color = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFE800',
                    ],
                    'endColor' => [
                        'argb' => 'FFE800',
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ];
            $sheet->getStyle('A1:T2')->applyFromArray($color);
            //lebar kolom
            $sheet->getColumnDimension('A')->setWidth(3);
            $sheet->getColumnDimension('B')->setWidth(11);
            $sheet->getColumnDimension('C')->setWidth(39);
            $sheet->getColumnDimension('D')->setWidth(11);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(35);
            $sheet->getColumnDimension('I')->setWidth(35);
            $sheet->getColumnDimension('J')->setWidth(35);
            $sheet->getColumnDimension('K')->setWidth(35);
            $sheet->getColumnDimension('L')->setWidth(35);
            $sheet->getColumnDimension('M')->setWidth(35);
            
            $sheet->mergeCells('A1:C1');
            $sheet->mergeCells('D1:G1');
            $sheet->mergeCells('H1:M1');
                
            //ketika diprint row 1 tetap muncul
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


            

        //membuat file name
        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "Register-Organization_".$date.".xlsx";

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