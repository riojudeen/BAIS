<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
require("../../../../_assets/vendor/autoload.php");
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
        $sheet->setCellValue('A1', 'Update Date: '.$tanggal);
        $sheet->setCellValue('D1', 'Employee ID');
        
        //query mp
        $query_mp = " SELECT * FROM view_organization";
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
                
                
    
                $sheet->setCellValue('A'.$no, $i);
                $sheet->setCellValue('B'.$no, $npk);
                $sheet->setCellValue('C'.$no, $nama);
                $sheet->setCellValue('D'.$no, $jabatan);
                $sheet->setCellValue('E'.$no, $status);
                $sheet->setCellValue('F'.$no, $shift);
                $sheet->setCellValue('G'.$no, $tgl_masuk);
                
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
            $sheet->getStyle('A1:G'.$i)->applyFromArray($styleArray);
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
            $sheet->getStyle('A1:G2')->applyFromArray($color);
            //lebar kolom
            $sheet->getColumnDimension('A')->setWidth(3);
            $sheet->getColumnDimension('B')->setWidth(11);
            $sheet->getColumnDimension('C')->setWidth(39);
            $sheet->getColumnDimension('D')->setWidth(11);
            $sheet->getColumnDimension('E')->setWidth(8);
            $sheet->getColumnDimension('F')->setWidth(8);
            $sheet->getColumnDimension('G')->setWidth(15);
           
            $sheet->mergeCells('A1:C1');
            $sheet->mergeCells('D1:G1');
           
                
            //ketika diprint row 1 tetap muncul
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

            //membuat file name
            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = "MP-Update_".$date.".xlsx";

            //savng file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);
            // echo $content;
            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);
            unlink($filename);
            exit($content);
    }else if($_GET['export'] == "dataUser" ){
        $tanggal = date('d-M-y');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'NPK');
        $sheet->setCellValue('C2', 'Nama');
        $sheet->setCellValue('D2', 'Jabatan');

        $sheet->setCellValue('E2', 'Level User');
        $sheet->setCellValue('F2', 'username');
        $sheet->setCellValue('G2', 'Password');
        
        $sheet->setCellValue('A1', 'Update Date: '.$tanggal);
        $sheet->setCellValue('E1', 'Data Account User');
        
        //query mp
        $query_mp = " SELECT * FROM view_user";
        $sql = mysqli_query($link, $query_mp)or die(mysqli_error($link));

        $data_total = mysqli_num_rows($sql);
        if( $data_total > 0){
            $no = 3;
            $i = 1;
            while($data = mysqli_fetch_assoc($sql)){
                $npk = $data['npk'];
                $nama = $data['nama'];
                $jabatan = $data['jabatan'];
                $level_user = $data['level_user'];
                $password = $data['pass'];
                $username = $data['username'];
    
                $sheet->setCellValue('A'.$no, $i);
                $sheet->setCellValue('B'.$no, $npk);
                $sheet->setCellValue('C'.$no, $nama);
                $sheet->setCellValue('D'.$no, $jabatan);
                $sheet->setCellValue('E'.$no, $level_user);
                $sheet->setCellValue('F'.$no, $username);
                $sheet->setCellValue('G'.$no, $password);
               
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
            $sheet->getStyle('A1:G'.$i)->applyFromArray($styleArray);
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
            $sheet->getStyle('A1:G2')->applyFromArray($color);
            //lebar kolom
            $sheet->getColumnDimension('A')->setWidth(3);
            $sheet->getColumnDimension('B')->setWidth(11);
            $sheet->getColumnDimension('C')->setWidth(39);
            $sheet->getColumnDimension('D')->setWidth(11);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(50);
            $sheet->mergeCells('A1:D1');
            $sheet->mergeCells('E1:G1');
                
            //ketika diprint row 1 tetap muncul
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

            //membuat file name
            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = "User-Account-Data_".$date.".xlsx";

            //savng file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);

            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);

            unlink($filename);
            exit($content);
    }else if($_GET['export'] == "organization" ){
        // echo "tes";
        $tanggal = date('d-M-y');
        $spreadsheet = new Spreadsheet(); //membuat spreadsheet baru
        $pos = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Pos'); //membuat worksheet baru
        $group = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Group');
        $sect = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Section');
        $dept = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Department');
        $division = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Division');
        $deptacc = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Department Account');
        
        
        $posting_data = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Posting Data');
        $spreadsheet->addSheet($pos, 0); //menambahkan worksheet ke dalam spreadsheet
        $spreadsheet->addSheet($group, 1);
        $spreadsheet->addSheet($sect, 2);
        $spreadsheet->addSheet($dept, 3);
        $spreadsheet->addSheet($division, 4);
        $spreadsheet->addSheet($deptacc, 5);
        $spreadsheet->addSheet($posting_data, 6);
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );

        $spreadsheet->removeSheetByIndex($sheetIndex);//hapus worksheet

        // /////pos
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_pos = mysqli_query($link, "SELECT * FROM pos_leader ORDER BY id_group, id_post ASC");
        $jml_pos = mysqli_num_rows($sql_pos);
        $index = 0;
        while($data_pos = mysqli_fetch_assoc($sql_pos)){
            $nama[$index] = $data_pos['nama_pos'];
            $id[$index] = $data_pos['id_post'];
            $induk[$index] = $data_pos['id_group'];
            $cord[$index] = $data_pos['npk_cord'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_pos; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);



        
        //////////////////////////////////////////////groupfrm
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_grp = mysqli_query($link, "SELECT * FROM groupfrm ORDER BY id_section, id_group ASC");
        $jml_grp = mysqli_num_rows($sql_grp);
        $index = 0;
        while($data_grp = mysqli_fetch_assoc($sql_grp)){
            $nama[$index] = $data_grp['nama_group'];
            $id[$index] = $data_grp['id_group'];
            $induk[$index] = $data_grp['id_section'];
            $cord[$index] = $data_grp['npk_cord'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_grp; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);



        //////////////////////////////////////////////section
        $sheet = $spreadsheet->setActiveSheetIndex(2);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_sct = mysqli_query($link, "SELECT * FROM section ORDER BY id_dept, id_section ASC");
        $jml_sct = mysqli_num_rows($sql_sct);
        $index = 0;
        while($data_sect = mysqli_fetch_assoc($sql_sct)){
            $nama[$index] = $data_sect['section'];
            $id[$index] = $data_sect['id_section'];
            $induk[$index] = $data_sect['id_dept'];
            $cord[$index] = $data_sect['npk_cord'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_sct; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);









        //////////////////////////////////////////////department
        
        $sheet = $spreadsheet->setActiveSheetIndex(3);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_dpt = mysqli_query($link, "SELECT * FROM department ORDER BY id_div, id_dept ASC");
        $jml_dpt = mysqli_num_rows($sql_dpt);
        $index = 0;
        while($data_dept = mysqli_fetch_assoc($sql_dpt)){
            $nama[$index] = $data_dept['dept'];
            $id[$index] = $data_dept['id_dept'];
            $induk[$index] = $data_dept['id_div'];
            $cord[$index] = $data_dept['npk_cord'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_dpt; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);




        //////////////////////////////////////////////divisi
        $sheet = $spreadsheet->setActiveSheetIndex(4);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_div = mysqli_query($link, "SELECT * FROM division ORDER BY id_div ASC");
        $jml_div = mysqli_num_rows($sql_div);
        $index = 0;
        while($data_div = mysqli_fetch_assoc($sql_div)){
            $nama[$index] = $data_div['nama_divisi'];
            $id[$index] = $data_div['id_div'];
            $induk[$index] = $data_div['id_company'];
            $cord[$index] = $data_div['npk_cord'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_div; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);




        // ////////////////////////////////////////////////////////
        $sheet = $spreadsheet->setActiveSheetIndex(5);
        $sheet->setCellValue('A1', "Nama Area Organization");
        $sheet->setCellValue('B1', 'NPK Cord');
        $sheet->setCellValue('C1', 'ID Area');
        $sheet->setCellValue('D1', 'ID Induk');
        
        $sql_dpA = mysqli_query($link, "SELECT * FROM dept_account ORDER BY id_div, id_dept_account ASC");
        $jml_dpA = mysqli_num_rows($sql_dpA);
        $index = 0;
        while($data_deptacc = mysqli_fetch_assoc($sql_dpA)){
            $nama[$index] = $data_deptacc['department_account'];
            $id[$index] = $data_deptacc['id_dept_account'];
            $induk[$index] = $data_deptacc['id_div'];
            $cord[$index] = $data_deptacc['npk_dept'];
            $index++;
        }
        $no = 2;
        for($i = 0 ; $i<$jml_dpA; $i++){
            $sheet->setCellValue('A'.$no, $nama[$i]);
            $sheet->setCellValue('B'.$no, $cord[$i]);
            $sheet->setCellValue('C'.$no, $id[$i]);
            $sheet->setCellValue('D'.$no, $induk[$i]);
            $no++;
            
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
        $sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);
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
        $sheet->getStyle('A1:D1')->applyFromArray($color);
        //lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->mergeCells('T1:T2');

        //ketika diprint row 1 tetap muncul
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);




        ////////data posting
        // /////pos
        $sheet = $spreadsheet->setActiveSheetIndex(6);
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
        $sheet->setCellValue('N2', 'ID Pos');
        $sheet->setCellValue('O2', 'ID Group');
        $sheet->setCellValue('P2', 'ID Section');
        $sheet->setCellValue('Q2', 'ID Department');
        $sheet->setCellValue('R2', 'ID Department Account');
        $sheet->setCellValue('S2', 'ID Division');
        $sheet->setCellValue('T1', 'ID Area');
        $sheet->setCellValue('A1', 'Update Date: '.$tanggal);
        $sheet->setCellValue('D1', 'Employee ID');
        $sheet->setCellValue('H1', 'Organization Data');
        $sheet->setCellValue('N1', 'Organization ID');
        
        //query mp
        $query_mp = " SELECT * FROM view_organization";
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
                $idPost = (!empty($data['id_post_leader']))? $data['id_post_leader'] : "";
                $idGroup = (!empty($data['id_grp']))? $data['id_grp'] : "";
                $idSect = (!empty($data['id_sect']))? $data['id_sect'] : "";
                $idDept = (!empty($data['id_dept']))? $data['id_dept'] : "";
                $idDiv= (!empty($data['id_division']))? $data['id_division'] : "";
                $idDeptAcc= (!empty($data['id_dept_account']))? $data['id_dept_account'] : "";
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
                $sheet->setCellValue('N'.$no, $idPost);
                $sheet->setCellValue('O'.$no, $idGroup);
                $sheet->setCellValue('P'.$no, $idSect);
                $sheet->setCellValue('Q'.$no, $idDept);
                $sheet->setCellValue('R'.$no, $idDeptAcc);
                $sheet->setCellValue('S'.$no, $idDiv);
    
                $sheet->setCellValue('T'.$no, '=IF(N'.$no.'="",IF(O'.$no.'="",IF(P'.$no.'="",IF(Q'.$no.'="",IF(S'.$no.'="","",S'.$no.'),Q'.$no.'),P'.$no.'),O'.$no.'),N'.$no.')');
                
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
            $sheet->getColumnDimension('N')->setWidth(23);
            $sheet->getColumnDimension('O')->setWidth(23);
            $sheet->getColumnDimension('P')->setWidth(23);
            $sheet->getColumnDimension('Q')->setWidth(23);
            $sheet->getColumnDimension('R')->setWidth(23);
            $sheet->getColumnDimension('S')->setWidth(23);
            $sheet->getColumnDimension('T')->setWidth(23);
            $sheet->mergeCells('A1:C1');
            $sheet->mergeCells('D1:G1');
            $sheet->mergeCells('H1:M1');
            $sheet->mergeCells('N1:S1');
            $sheet->mergeCells('T1:T2');
                
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