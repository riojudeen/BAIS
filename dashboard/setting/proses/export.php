<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
require("../../../_assets/vendor/autoload.php");
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
  
            // echo tes('try');
            
            $q_mP = mysqli_query($link, " SELECT 
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure,

            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,

            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,

            department.id_dept AS idDept,
            department.dept AS dept,
            department.npk_cord AS dept_cord,
            department.id_div AS id_div,

            section.id_section AS idSect,
            section.section AS section,
            section.npk_cord AS spv,
            section.id_dept AS id_dept,

            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,

            pos_leader.id_post AS idPost,
            pos_leader.nama_pos AS pos,
            pos_leader.npk_cord AS post_cord,
            pos_leader.id_group AS leader,

            karyawan.npk AS npk,
            karyawan.nama AS nama,
            karyawan.tgl_masuk AS tgl_masuk,
            karyawan.jabatan AS jabatanMp,
            karyawan.shift AS shift,
            karyawan.status AS `status`,
            karyawan.department AS deptMp,
            karyawan.id_area AS id_area,

            jabatan.id_jabatan AS id_jab,
            jabatan.jabatan AS nama_jab ,
            jabatan.level AS level_jab

            FROM karyawan LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post
            LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
            LEFT JOIN section ON section.id_section = groupfrm.id_section
            LEFT JOIN department ON section.id_dept = department.id_dept
            LEFT JOIN division ON department.id_div = division.id_div 
            LEFT JOIN company ON division.id_company = company.id_company
            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
            ")or die(mysqli_error($link));
            // mengambil data department
            // echo tes('try');
            $sComp = mysqli_query($link, "SELECT * FROM company WHERE id_company = '1'")or die(mysqli_error($link));

            $jDiv = mysqli_query($link, "SELECT * FROM division WHERE id_company = '1' ")or die(mysqli_error($link));
            $jDept = mysqli_query($link, "SELECT * FROM department")or die(mysqli_error($link));
            $jSect = mysqli_query($link, "SELECT * FROM section")or die(mysqli_error($link));
            $jGroup = mysqli_query($link, "SELECT * FROM groupfrm")or die(mysqli_error($link));
            $jPos = mysqli_query($link, "SELECT * FROM pos_leader")or die(mysqli_error($link));
            
            $jmlDiv = mysqli_num_rows($jDiv);
            $jmlDept = mysqli_num_rows($jDept);
            $jmlSect = mysqli_num_rows($jSect);
            $jmlGroup = mysqli_num_rows($jGroup);
            $jmlPos = mysqli_num_rows($jPos);
            

            $batas = 10 ;
            $noo = 1;
            $i = 1;
            if($jmlDiv > 0){
                //mendapatkan nilai department
                //ubah code divisi untuk divisi selain body
                $s_Div= mysqli_query($link, "SELECT * FROM division WHERE id_company = '1' ORDER BY id_div ASC")or die(mysqli_error($link));
                
                while($d_Div = mysqli_fetch_assoc($s_Div)){
                    //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                    
                    $qDiv = mysqli_query($link, 
                    "SELECT 
                    company.id_company AS idCompany, 
                    company.nama AS namaCompany , 
                    company.npk_cord AS directure,
                    division.id_div AS idDiv, 
                    division.nama_divisi AS divisi, 
                    division.npk_cord AS dh, 
                    division.id_company AS id_company,
                    
                    karyawan.npk AS npk, 
                    karyawan.nama AS nama, 
                    karyawan.tgl_masuk AS tgl_masuk, 
                    karyawan.jabatan AS jabatanMp, 
                    karyawan.shift AS shift, 
                    karyawan.status AS `status`, 
                    karyawan.department AS deptMp, 
                    karyawan.id_area AS id_area,
                    jabatan.id_jabatan AS id_jab, 
                    jabatan.jabatan AS nama_jab , 
                    jabatan.level AS level_jab
                    FROM karyawan 
                    LEFT JOIN division ON division.id_div = karyawan.id_area
                    LEFT JOIN company ON company.id_company = division.id_company
                    LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                    LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                    WHERE karyawan.id_area = '$d_Div[id_div]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                    if(mysqli_num_rows($qDiv) > 0){
                        while($dataMpDiv = mysqli_fetch_assoc($qDiv)){
                            $data[$noo++] = $dataMpDiv;
                        }
                    }
                    $sDept = mysqli_query($link, "SELECT * FROM department WHERE id_div = '$d_Div[id_div]' ")or die(mysqli_error($link));
                    $deptCount = mysqli_num_rows($sDept);

                    if($deptCount > 0){
                        while($d_Dept = mysqli_fetch_assoc($sDept)){
                            
                            //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                            $qDept = mysqli_query($link, 
                            "SELECT 
                            company.id_company AS idCompany, 
                            company.nama AS namaCompany , 
                            company.npk_cord AS directure,
                            division.id_div AS idDiv, 
                            division.nama_divisi AS divisi, 
                            division.npk_cord AS dh, 
                            division.id_company AS id_company,
                            dept_account.id_dept_account AS idDeptAcc, 
                            dept_account.department_account AS deptAcc, 
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,
                            department.id_dept AS idDept, 
                            department.dept AS dept, 
                            department.npk_cord AS dept_cord, 
                            department.id_div AS id_div,
                            karyawan.npk AS npk, 
                            karyawan.nama AS nama, 
                            karyawan.tgl_masuk AS tgl_masuk, 
                            karyawan.jabatan AS jabatanMp, 
                            karyawan.shift AS shift, 
                            karyawan.status AS `status`, 
                            karyawan.department AS deptMp, 
                            karyawan.id_area AS id_area,
                            jabatan.id_jabatan AS id_jab, 
                            jabatan.jabatan AS nama_jab , 
                            jabatan.level AS level_jab
                            FROM karyawan 
                            LEFT JOIN department ON karyawan.id_area = department.id_dept
                            LEFT JOIN division ON division.id_div = department.id_div
                            LEFT JOIN company ON company.id_company = division.id_company
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                            WHERE karyawan.id_area = '$d_Dept[id_dept]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                            if(mysqli_num_rows($qDept) > 0){
                                while($dataMp = mysqli_fetch_assoc($qDept)){
                                    $data[$noo++] = $dataMp; 
                                }
                            }
                            ////////////////////////////section
                            // cari data section dengan id department yang sama
                            $sSect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$d_Dept[id_dept]' ")or die(mysqli_error($link));
                            $sectCount = mysqli_num_rows($sSect);
                            if($sectCount > 0 ){
                                while($dSect = mysqli_fetch_assoc($sSect)){
                                   
                                    //cari data karyawan dengan id section yang sama 
                                    $mpSect = mysqli_query($link, " SELECT 
                                    company.id_company AS idCompany,
                                    company.nama AS namaCompany ,
                                    company.npk_cord AS directure,
    
                                    division.id_div AS idDiv,
                                    division.nama_divisi AS divisi,
                                    division.npk_cord AS dh,
                                    division.id_company AS id_company,
    
                                    dept_account.id_dept_account AS idDeptAcc,
                                    dept_account.department_account AS deptAcc,
                                    dept_account.npk_dept AS mg, 
                                    dept_account.id_div AS id_div,
    
                                    department.id_dept AS idDept,
                                    department.dept AS dept,
                                    department.npk_cord AS dept_cord,
                                    department.id_div AS id_div,
    
                                    section.id_section AS idSect,
                                    section.section AS section,
                                    section.npk_cord AS spv,
                                    section.id_dept AS id_dept,
    
                                    karyawan.npk AS npk,
                                    karyawan.nama AS nama,
                                    karyawan.tgl_masuk AS tgl_masuk,
                                    karyawan.jabatan AS jabatanMp,
                                    karyawan.shift AS shift,
                                    karyawan.status AS `status`,
                                    karyawan.department AS deptMp,
                                    karyawan.id_area AS id_area,
    
                                    jabatan.id_jabatan AS id_jab,
                                    jabatan.jabatan AS nama_jab ,
                                    jabatan.level AS level_jab
    
                                    FROM karyawan 
                                    LEFT JOIN section ON section.id_section = karyawan.id_area
                                    LEFT JOIN department ON section.id_dept = department.id_dept
                                    LEFT JOIN division ON department.id_div = division.id_div 
                                    LEFT JOIN company ON division.id_company = company.id_company
                                    LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                    LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                    WHERE karyawan.id_area = '$dSect[id_section]' ORDER BY level_jab ASC
                                    ")or die(mysqli_error($link));
                                    $countMpSect = mysqli_num_rows($mpSect);
                                    //cetak mp dengan id section 
                                    if($countMpSect > 0){
                                        while($dataMpSect = mysqli_fetch_assoc($mpSect)){
                                            $data[$noo++] = $dataMpSect; 
                                            
                                        }
                                 
                                    }
                                    
    
                                    ///////////////////////////////group
                                    // cari data group foreman dengan id section yang sama
                                    $sGroup = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$dSect[id_section]' ")or die(mysqli_error($link));
                                    $groupCount = mysqli_num_rows($sGroup);
                                    if($groupCount > 0){
                                        while($dGroup = mysqli_fetch_assoc($sGroup)){
                                            
                                            //cari man power dengan id group yang sama
                                            $s_MpGroup = mysqli_query($link, " SELECT 
                                            company.id_company AS idCompany,
                                            company.nama AS namaCompany ,
                                            company.npk_cord AS directure,
    
                                            division.id_div AS idDiv,
                                            division.nama_divisi AS divisi,
                                            division.npk_cord AS dh,
                                            division.id_company AS id_company,
    
                                            dept_account.id_dept_account AS idDeptAcc,
                                            dept_account.department_account AS deptAcc,
                                            dept_account.npk_dept AS mg, 
                                            dept_account.id_div AS id_div,
    
                                            department.id_dept AS idDept,
                                            department.dept AS dept,
                                            department.npk_cord AS dept_cord,
                                            department.id_div AS id_div,
    
                                            section.id_section AS idSect,
                                            section.section AS section,
                                            section.npk_cord AS spv,
                                            section.id_dept AS id_dept,
    
                                            groupfrm.id_group AS idGroup,
                                            groupfrm.nama_group AS groupfrm,
                                            groupfrm.npk_cord AS group_cord,
                                            groupfrm.id_section AS id_sect,
    
                                            karyawan.npk AS npk,
                                            karyawan.nama AS nama,
                                            karyawan.tgl_masuk AS tgl_masuk,
                                            karyawan.jabatan AS jabatanMp,
                                            karyawan.shift AS shift,
                                            karyawan.status AS `status`,
                                            karyawan.department AS deptMp,
                                            karyawan.id_area AS id_area,
    
                                            jabatan.id_jabatan AS id_jab,
                                            jabatan.jabatan AS nama_jab ,
                                            jabatan.level AS level_jab
    
                                            FROM karyawan 
                                            LEFT JOIN groupfrm ON karyawan.id_area = groupfrm.id_group 
                                            LEFT JOIN section ON section.id_section = groupfrm.id_section
                                            LEFT JOIN department ON section.id_dept = department.id_dept
                                            LEFT JOIN division ON department.id_div = division.id_div 
                                            LEFT JOIN company ON division.id_company = company.id_company
                                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                            WHERE karyawan.id_area = '$dGroup[id_group]' ORDER BY level_jab ASC
                                            ")or die(mysqli_error($link));
                                            $countMpGroup = mysqli_num_rows($s_MpGroup);
                                            if($countMpGroup > 0){
                                                while($dataMpGroup = mysqli_fetch_assoc($s_MpGroup)){
                                                    $data[$noo++] = $dataMpGroup; 
                                                }
                                                
                                            }
                                            ////////////////////pos
                                            //dapatkan nilai pos
                                            $sPos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$dGroup[id_group]' ")or die(mysqli_error($link));
                                            $countPos = mysqli_num_rows($sPos);
                                            if($countPos > 1){
                                                while($dPos = mysqli_fetch_assoc($sPos)){
                                                    
                                                    //cari man power dengan id group yang sama
                                                    $s_MpPos = mysqli_query($link, " SELECT 
                                                    company.id_company AS idCompany,
                                                    company.nama AS namaCompany ,
                                                    company.npk_cord AS directure,
    
                                                    division.id_div AS idDiv,
                                                    division.nama_divisi AS divisi,
                                                    division.npk_cord AS dh,
                                                    division.id_company AS id_company,
    
                                                    dept_account.id_dept_account AS idDeptAcc,
                                                    dept_account.department_account AS deptAcc,
                                                    dept_account.npk_dept AS mg, 
                                                    dept_account.id_div AS id_div,
    
                                                    department.id_dept AS idDept,
                                                    department.dept AS dept,
                                                    department.npk_cord AS dept_cord,
                                                    department.id_div AS id_div,
    
                                                    section.id_section AS idSect,
                                                    section.section AS section,
                                                    section.npk_cord AS spv,
                                                    section.id_dept AS id_dept,
    
                                                    groupfrm.id_group AS idGroup,
                                                    groupfrm.nama_group AS groupfrm,
                                                    groupfrm.npk_cord AS group_cord,
                                                    groupfrm.id_section AS id_sect,
    
                                                    pos_leader.id_post AS idPost,
                                                    pos_leader.nama_pos AS pos,
                                                    pos_leader.npk_cord AS post_cord,
                                                    pos_leader.id_group AS leader,
    
                                                    karyawan.npk AS npk,
                                                    karyawan.nama AS nama,
                                                    karyawan.tgl_masuk AS tgl_masuk,
                                                    karyawan.jabatan AS jabatanMp,
                                                    karyawan.shift AS shift,
                                                    karyawan.status AS `status`,
                                                    karyawan.department AS deptMp,
                                                    karyawan.id_area AS id_area,
    
                                                    jabatan.id_jabatan AS id_jab,
                                                    jabatan.jabatan AS nama_jab ,
                                                    jabatan.level AS level_jab
    
                                                    FROM karyawan LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post
                                                    LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
                                                    LEFT JOIN section ON section.id_section = groupfrm.id_section
                                                    LEFT JOIN department ON section.id_dept = department.id_dept
                                                    LEFT JOIN division ON department.id_div = division.id_div 
                                                    LEFT JOIN company ON division.id_company = company.id_company
                                                    LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                                    LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                                    WHERE karyawan.id_area = '$dPos[id_post]' ORDER BY level_jab ASC
                                                    ")or die(mysqli_error($link));
                                                    $countMpPos = mysqli_num_rows($s_MpPos);
                                                    if($countMpPos > 0){
                                                        //cari data Mp Pos
                                                        while($dataMpPos = mysqli_fetch_assoc($s_MpPos)){
                                                            $data[$noo++] = $dataMpPos; 
                                                            
                                                        }
                                                        
                                                    }
                                                }
                                                mysqli_free_result($sPos);
                                            }
                                        }
                                        mysqli_free_result($sGroup);
                                    }
                                }
                                mysqli_free_result($sSect);
                            }
                        }
                        mysqli_free_result($sDept);
                    }
                }
                mysqli_free_result($s_Div);
            }
        //end query
        //fetch array
        $no = 3;
        for($i = 1 ; $i<=count($data); $i++){
            
            
            $npk = $data[$i]['npk'];
            $nama = $data[$i]['nama'];
            $status = $data[$i]['status'];
            $jabatan = $data[$i]['jabatanMp'];
            $tgl_masuk = $data[$i]['tgl_masuk'];
            $shift = $data[$i]['shift'];
            $idPost = (!empty($data[$i]['idPost']))? $data[$i]['idPost'] : "-";
            $idGroup = (!empty($data[$i]['idGroup']))? $data[$i]['idGroup'] : "-";
            $idSect = (!empty($data[$i]['idSect']))? $data[$i]['idSect'] : "-";
            $idDept = (!empty($data[$i]['idDept']))? $data[$i]['idDept'] : "-";
            $idDiv= (!empty($data[$i]['idDiv']))? $data[$i]['idDiv'] : "-";
            $idDeptAcc= (!empty($data[$i]['idDeptAcc']))? $data[$i]['idDeptAcc'] : "-";
            $pos_leader = (!empty($data[$i]['pos']))? $data[$i]['pos'] : "-";
            $groupfrm = (!empty($data[$i]['groupfrm']))? $data[$i]['groupfrm'] : "-"; 
            $section = (!empty($data[$i]['section']))? $data[$i]['section'] : "-"; 
            $department = (!empty($data[$i]['dept']))? $data[$i]['dept'] : "-"; 
            $dept_Account = (!empty($data[$i]['deptAcc']))? $data[$i]['deptAcc'] : "-"; 
            $division = (!empty($data[$i]['divisi']))? $data[$i]['divisi'] : "-"; 
            $company = $data[$i]['namaCompany'];
            

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

            $sheet->setCellValue('T'.$no, '=IF(N'.$no.'="-",IF(O'.$no.'="-",IF(P'.$no.'="-",IF(Q'.$no.'="-",IF(S'.$no.'="-","-",S'.$no.'),Q'.$no.'),P'.$no.'),O'.$no.'),N'.$no.')');
            
            $no ++;
            
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
        $sheet->getColumnDimension('H')->setWidth(28);
        $sheet->getColumnDimension('I')->setWidth(28);
        $sheet->getColumnDimension('J')->setWidth(28);
        $sheet->getColumnDimension('K')->setWidth(28);
        $sheet->getColumnDimension('L')->setWidth(28);
        $sheet->getColumnDimension('M')->setWidth(28);
        $sheet->getColumnDimension('N')->setWidth(13);
        $sheet->getColumnDimension('O')->setWidth(13);
        $sheet->getColumnDimension('P')->setWidth(13);
        $sheet->getColumnDimension('Q')->setWidth(13);
        $sheet->getColumnDimension('R')->setWidth(13);
        $sheet->getColumnDimension('S')->setWidth(13);
        $sheet->getColumnDimension('T')->setWidth(13);
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
        $filename = "MP-Update_".$date.".xlsx";

        //savng file
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        $content = file_get_contents($filename);

        //redirect dan download file
        header("Content-Disposition: attachment; filename=".$filename);
        
        unlink($filename);
        exit($content);
    }else if($_GET['export'] == "dataUser" ){
        echo "<script>window.location='../user.php';</script>";
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
        $spreadsheet->addSheet($pos, 0); //menambahkan worksheet ke dalam spreadsheet
        $spreadsheet->addSheet($group, 1);
        $spreadsheet->addSheet($sect, 2);
        $spreadsheet->addSheet($dept, 3);
        $spreadsheet->addSheet($division, 4);
        $spreadsheet->addSheet($deptacc, 5);
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);//hapus worksheet

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
        //////////////////////////////////////////////
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
        //////////////////////////////////////////////
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
        //////////////////////////////////////////////
        
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
        //////////////////////////////////////////////
        $sheet = $spreadsheet->setActiveSheetIndex(4);
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
        //////////////////////////////////////////////
        $sheet = $spreadsheet->setActiveSheetIndex(5);
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