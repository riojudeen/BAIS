<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
require("../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    if(isset($_POST['request'])){
        if(isset($_GET['del_req'])){
            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Dihapus',
                    text: 'Draft Pengajuan Telah Dihapus',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else if(isset($_GET['ot_req'])){
            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "UPDATE lembur SET `status` = 'a' , status_approve = '25' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Diajukan',
                    text: 'Draft Pengajuan Telah Diajukan',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else if(isset($_GET['ot_download'])){
            $req = $_POST['request'];
            // print_r($req);
            $no = 12;
            $i = 1;
            $filter_group = '';
            $filter_dept = '';
            $filter_date = '';
            $filter_dataGabung = '';
            foreach($req AS $id){
                $pecah_ID = explode('&&', $id);
                $work_date = $pecah_ID[2];
                $group_ = $pecah_ID[0];
                $dept_acc_ = $pecah_ID[1];

                $filter_group  = ($group_ == '-')?" ( view_req_ot.grp = '' OR view_req_ot.grp is NULL AND view_req_ot.work_date = '$work_date') ":" (view_req_ot.grp = '$group_' AND view_req_ot.work_date = '$work_date') ";
                $filter_dept  = ($dept_acc_ == '-')?" ( view_req_ot.dept_account = '' OR view_req_ot.dept_account is NULL AND view_req_ot.work_date = '$work_date' ) ":" (view_req_ot.dept_account = '$dept_acc_' AND view_req_ot.work_date = '$work_date') ";
                $filter_dataGabung .= " (".$filter_group." AND ".$filter_dept.") OR";
                
            }
            $filter_dataGabung = " (".substr($filter_dataGabung , 0, -2)." ) " ;

            

            // //load spreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../../file/template/overtime.xlsx");

            // //change it
            $sheet = $spreadsheet->getActiveSheet();
            
            // //membuat file name
            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = "Overtime_".$date.".xlsx";
            /* 
                query data overtime
                -- AND  view_req_ot.work_date = '$work_date' AND view_req_ot.id_ot = '$type'
            */

            $origin_query = "SELECT 
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
            view_req_ot.work_date,
            view_req_ot.in_date,
            view_req_ot.out_date,
            view_req_ot.start,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity

            FROM view_organization JOIN 
                (SELECT view_req_ot.npk, 
                    view_req_ot.work_date, 
                    view_req_ot.in_date,  
                    view_req_ot.out_date, 
                    view_req_ot.start, 
                    view_req_ot.end, 
                    view_req_ot.job_code, 
                    view_req_ot.activity ,
                    view_req_ot.grp 
                    FROM view_req_ot 
                WHERE $filter_dataGabung 
                    ) AS view_req_ot 
                
                ON  view_organization.npk = view_req_ot.npk ";
            $access_org = orgAccessOrg($level);
            $data_access = generateAccess($link,$level,$npkUser);
            $table = partAccess($level, "table");
            $field_request = partAccess($level, "field_request");
            $table_field1 = partAccess($level, "table_field1");
            $table_field2 = partAccess($level, "table_field2");
            $part = partAccess($level, "part");
            // $filterJoin = " ";
            $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npkUser, $data_access);
            // echo $group_filter;
            
            $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org);
            // echo $queryMP;
            
            $sql = mysqli_query($link, $queryMP." ORDER BY view_req_ot.work_date, view_req_ot.grp ")or die(mysqli_error($link));
            $data_total = mysqli_num_rows($sql);
            
            $year = date('Y');
            $styleArray = [
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            ];
            while($data = mysqli_fetch_assoc($sql)){
                
                $npk = $data['npk'];
                $nama = $data['nama'];
                $start = $data['start'];
                $end = $data['end'];
                $grp = $data['groupfrm'];
                $sect = $data['section'];
                $dept = $data['dept'];
                $dept_account = $data['dept_account'];
                $disabled = ($data['job_code'] != '')?"disabled":"";
                $mp = ($data['job_code'] != '')?"":"mp";
                $activity = ($data['activity'] != '')?$data['activity']:"";
                $job_code = ($data['job_code'] != '')?$data['job_code']:"";
                $text_activity = ($data['job_code'] != '')?'':"ot_activity";
                // $start = ($data['start'] != '')?jam($data['start']):$min_start;
                // $end = ($data['end'] != '')?jam($data['end']):$max_end;
                
                // $sheet->setCellValue('E5', $queryMP);
                $sheet->setCellValue('Q3', $year);
                $sheet->setCellValue('C'.$no, $i);
                $sheet->setCellValue('D'.$no, $npk);
                $sheet->setCellValue('E'.$no, $nama);
                $sheet->setCellValue('H'.$no, jam($start));
                $sheet->setCellValue('I'.$no, jam($end));
                $sheet->setCellValue('K'.$no, $activity);
                $sheet->setCellValue('Q'.$no, $job_code);
                $sheet->setCellValue('S'.$no, $grp);
                $sheet->setCellValue('T'.$no, $sect);
                $sheet->setCellValue('U'.$no, $dept);
                $sheet->setCellValue('V'.$no, $dept_account);
                $sheet->setCellValue('W'.$no, $data['work_date']);
                // echo $npk;

                $sheet->getStyle('K'.$no.':P'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('C'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('D'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('I'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('J'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('Q'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('E'.$no.':G'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('H'.$no)->applyFromArray($styleArray);
                // $sheet->mergeCells('I'.$no.':C'.$no);
                


                $no++;
                $i++;
            }
            $no2 = $no;
            $no = $no+1;

            $no3 = $no+2;
            $no1 = $no+1;
            $no4 = $no3+5;
            $no5 = $no3+6;
            $sheet->setCellValue('D'.$no1, "Jakarta, ".tgl(Date('Y-m-d')));
            $sheet->setCellValue('D'.$no3, "Menyetujui");
            $sheet->setCellValue('H'.$no3, "Mengetahui");
            $sheet->setCellValue('D'.$no4, "Div Head");
            $sheet->setCellValue('F'.$no4, "Dept Head");
            $sheet->setCellValue('H'.$no4, "Sect Head");
            $sheet->setCellValue('D'.$no5, "");
            $sheet->setCellValue('F'.$no5, "");
            $sheet->setCellValue('H'.$no5, "");

            $no6 = $no5+1;
            $styleArray1 = array(
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        // 'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            );
            
            // $styleArray = [
            //     'borders' => [
            //         'allBorders' => [
            //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //         ],
            //     ],
            // ];
            $sheet->getStyle('B2:R'.$no6)->applyFromArray($styleArray1);
            $sheet->getStyle('C10:Q'.$no2)->applyFromArray($styleArray1);
            $sheet->getStyle('D'.$no3.':I'.$no5)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$no3.':G'.$no3)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$no3.':I'.$no3)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$no4.':E'.$no4)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$no4.':G'.$no4)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$no4.':I'.$no4)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$no5.':E'.$no5)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$no5.':G'.$no5)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$no5.':I'.$no5)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$no3++.':E'.$no5)->applyFromArray($styleArray);
            $sheet->getStyle('H'.$no3.':I'.$no5)->applyFromArray($styleArray);
            
            
            // savng file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);

            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);
            
            unlink($filename);
            exit($content);
        }
        ?>
    <?php
    }else{
        
        ?>
        <script>
            Swal.fire({
                title: 'Data Kosong',
                text: 'Pilih Data Pengajuan Yang ingin Diproses',
                timer: 2000,
                
                icon: 'warning',
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
                
            })
        </script>
        <?php
        
    }
    
    
}