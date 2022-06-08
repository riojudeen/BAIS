<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
require("../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    // proses satuan
    if(isset($_GET['approve'])){
        $data = $_GET['approve'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '50' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Diapprove";
            $response["info"] = "data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['proses'])){
        $data = $_GET['proses'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '75' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Diproses";
            $response["info"] = "data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['return'])){
        $data = $_GET['return'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'd' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dikembalikan";
            $response["info"] = "data telah dikembalikan untuk dicheck kembali oleh pimpinan area";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['stop'])){
        $data = $_GET['stop'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'c' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dihentikan";
            $response["info"] = "data pengajuan telah dihentikan";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['reject'])){
        $data = $_GET['reject'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'b' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Ditolak";
            $response["info"] = "data pengajuan telah ditolak";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['del'])){
        $data = $_GET['del'];
        list($id, $npk, $date) = pecahID($data);
        $query = "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dihapus";
            $response["info"] = "data pengajuan telah dihapus dan dapat diajukan kembali";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['approve_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '50' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Diapprove";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['reject_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'b' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Rejected";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Ditolak";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['proses_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '75' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Diproses";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Diproses";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['stop_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'c' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dihentikan";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dikembalikan";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['delete_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dihapus";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dihapus";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['return_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'd' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dikembalikan";
            $response["info"] = "$total data telah dikembalikan untuk dicek kembali oleh pimpinan area";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dihapus";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['ot_download'])){
        if(count($_POST['checked']) > 0){
            $i = 1;
            $no = 12;
            $filter_id = '';
            foreach($_POST['checked'] AS $data){
                list($id, $npk, $date) = pecahID($data);
                $filter_id .= " ( id_ot = '$id' AND npk = '$npk' AND work_date = '$date') OR";
                
            }
            
            $filter_id = substr($filter_id, 0, -2);
            $filter_id = ($filter_id == '' )?'':" WHERE ($filter_id) ";
            $query = "SELECT id_ot, npk, nama, work_date, `start`, `end` , activity, job_code , grp, sect, dept, dept_account, division, plant
            FROM view_req_ot".$filter_id;
            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $year = date('Y');

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../../file/template/overtime.xlsx");
            // // // //change it
            $sheet = $spreadsheet->getActiveSheet(); 
            $styleArray = [
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            ];
            if(mysqli_num_rows($sql)>0){
                while($data = mysqli_fetch_assoc($sql)){
                    // echo $data['npk']."<br>";
                    // echo $data['nama']."<br>";
                    // echo $data['work_date']."<br>";
                    // echo $data['start']."<br>";
                    // echo $data['end']."<br>";
                    // echo $data['activity']."<br>";
                    // echo $data['job_code']."<br>";
                    // echo "---";
                    $grp = getOrgName($link, $data['grp'] ,"group");
                    $sect = getOrgName($link, $data['sect'] ,"section");
                    $dept_acc = getOrgName($link, $data['dept_account'] ,"deptAcc");
                    $dept = getOrgName($link, $data['dept'] ,"dept");
                    $div = getOrgName($link, $data['division'] ,"division");

                    $sheet->setCellValue('Q3', $year);
                    $sheet->setCellValue('C'.$no, $i);
                    $sheet->setCellValue('D'.$no, $data['npk']);
                    $sheet->setCellValue('E'.$no, $data['nama']);
                    $sheet->setCellValue('H'.$no, jam($data['start']));
                    $sheet->setCellValue('I'.$no, jam($data['end']));
                    $sheet->setCellValue('K'.$no, $data['activity']);
                    $sheet->setCellValue('Q'.$no, $data['job_code']);
                    $sheet->setCellValue('S'.$no, $grp);
                    $sheet->setCellValue('T'.$no, $sect);
                    $sheet->setCellValue('U'.$no, $dept);
                    $sheet->setCellValue('V'.$no, $dept_acc);
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
                    $no++;
                    $i++;
                }
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
            $sheet->getStyle('C10:Q'.$no2)->applyFromArray($styleArray);
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
            
            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = "SPL_".$date.".xlsx";
            // savng file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);

            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);
            
            unlink($filename);
            exit($content);

            
            // echo $query;
            
        }else{
            $_SESSION['info'] = 'Kosong';
            header('location:approval/index.php');
        }
    }else{
        $response["message"]="Gagal Dihapus";
        $response["info"] = "$total data gagal diproses (Null Parameter)";
        $response["icon"] = "warning";
        $response["data_query"] = "";
        echo json_encode($response);
    }
}