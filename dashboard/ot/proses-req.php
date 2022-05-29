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
            $in_date = '2022-05-29';
            $out_date = '2022-05-29';
            $work_date = '2022-05-29';
            // //load spreadsheet
            
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../../file/template/overtime.xlsx");

            // //change it
            $sheet = $spreadsheet->getActiveSheet();
            // $sheet->setCellValue('C14', 'New Value');

            // //write it again to Filesystem with the same name (=replace)
            // $writer = new Xlsx($spreadsheet);
            // // $writer->save('yourspreadsheet.xlsx');
            // // foreach($_POST['request'] AS $data){
            // //     echo "mantap";
            // // }
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
                    view_req_ot.activity 
                    FROM view_req_ot 
                WHERE view_req_ot.in_date = '$in_date' 
                AND view_req_ot.out_date = '$out_date' 
                
                 ) AS view_req_ot 
                
                ON  view_organization.npk = view_req_ot.npk";
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
            
            $sql = mysqli_query($link, $queryMP)or die(mysqli_error($link));
            $data_total = mysqli_num_rows($sql);
            $no = 14;
            $i = 1;

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
                
                $sheet->setCellValue('C'.$no, $i);
                $sheet->setCellValue('D'.$no, $npk);
                $sheet->setCellValue('E'.$no, $nama);
                $sheet->setCellValue('F'.$no, $start);
                $sheet->setCellValue('G'.$no, $end);
                $sheet->setCellValue('I'.$no, $activity);
                $sheet->setCellValue('O'.$no, $job_code);
                $sheet->setCellValue('R'.$no, $grp);
                $sheet->setCellValue('S'.$no, $sect);
                $sheet->setCellValue('T'.$no, $dept);
                $sheet->setCellValue('U'.$no, $dept_account);
                // echo $npk;

                $sheet->getStyle('I'.$no.':N'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('C'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('D'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('E'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('F'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('F'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('G'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('H'.$no)->applyFromArray($styleArray);
                $sheet->getStyle('O'.$no)->applyFromArray($styleArray);
                // $sheet->mergeCells('I'.$no.':C'.$no);
               


                $no++;
                $i++;
            }
            $no2 = $no;
            $no = $no+1;
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
            $sheet->getStyle('B2:P'.$no)->applyFromArray($styleArray1);
            $sheet->getStyle('C12:O'.$no2)->applyFromArray($styleArray1);
            
            

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