<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        $sql = "INSERT INTO absensi (id , npk , shift , `date` , date_in , date_out , check_in , check_out , ket, id_req) VALUES ";
        $max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS id FROM absensi"));

        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        
        
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetColumn = $spreadsheet->getActiveSheet();
        $lastColumn = $sheetColumn->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
        // echo $lastColumnIndex;

        // echo $lastColumn;
        // echo count($sheetData);
        // print_r($sheetData);
        
        $startColumnIndex = 4;
        // $no = 1;
        $index = 1;
        foreach($_POST['dept'] AS $id_dept){
            for($i = $startColumnIndex ;$i < $lastColumnIndex ;$i = $i+3){
                $tgl = convertDatetoDB($sheetData['1'][$i]);
                // $npk = $sheetData[$i]['1'];
                // $shift = $sheetData[$i]['2'];
                // $date_mulai = $sheetData[$i]['6'];
                // $date_selesai = $sheetData[$i]['7'];
                $tanggal_absensi[$index++] = $tgl;
                mysqli_query($link, "DELETE absensi FROM absensi JOIN karyawan WHERE karyawan.department = '$id_dept' AND absensi.date = '$tgl' ");
                
                // echo $id_dept;
                // echo $i.". ".$tgl."<br />";
            }
        }
        
        // foreach($tanggal_absensi AS $tglAbs){
        //     echo $tglAbs."<br />";
        // }
        ?>

        
        <?php
        $tmbahid = 1;
        for($i = 4;$i < count($sheetData);$i++){
            // echo "<tr>";
            
            for($indexColumn = 4 ; $indexColumn < $lastColumnIndex ; $indexColumn++){
                $id = $max['id'] + $tmbahid;
                $tmbahid++;
                $npk = $sheetData[$i]['0'];
                $shift = $sheetData[$i]['3'];
                $dateSheet = $sheetData['1'][$indexColumn];
                $date = convertDatetoDB($dateSheet);
                $check_in = date('H:i:s' ,strtotime($date.' '.$sheetData[$i][$indexColumn]));
                
                $indexColumn = $indexColumn+1;
                $check_out = date('H:i:s' ,strtotime($date.' '.$sheetData[$i][$indexColumn]));
                $indexColumn = $indexColumn+1;
                $ket = $sheetData[$i][$indexColumn];
                $id_req = $npk.$date;
                $date_in = $date;
                $timestampWaktuIn = strtotime($date.' '.$check_in);
                $timestampWaktuOut = strtotime($date.' '.$check_out);
                if($timestampWaktuIn > $timestampWaktuOut){
                    $date_out = date('Y-m-d' , strtotime('+1 days', strtotime($date)));
                }else{
                    $date_out = $date_in;
                }
                
                $sql .=" ('$id', '$npk', '$shift','$date','$date_in','$date_out','$check_in','$check_out','$ket','$id_req'),";
                
                // $npk = $sheetData[$i]['1'];
                // $shift = $sheetData[$i]['2'];
                // $date_mulai = $sheetData[$i]['6'];
                // $date_selesai = $sheetData[$i]['7'];
                
                // echo "<td>".$npk."</td>";
                // echo "<td>".$shift."</td>";
                // echo "<td>".$date."</td>";
                // echo "<td>".$date_in."</td>";
                // echo "<td>".$date_out."</td>";
                // echo "<td>".$check_in."</td>";
                // echo "<td>".$check_out."</td>";
                // echo "<td>".$ket."</td>";
            }
            // echo "<tr/>";
        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $data = mysqli_query($link, $sql)or die(mysqli_error($link));
        // echo $sqlUser;
        if($data){
            // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
            $_SESSION['info'] = "Disimpan";
            header("Location: ../portAtt.php"); 
        }else{
            $_SESSION['info'] = "Kosong";
            header("Location: ../portAtt.php");
        }
        
    }else{
        // echo "tes NG";
        $_SESSION['info'] = "Kosong";
        header("Location: ../portAtt.php");
    }


 

?>