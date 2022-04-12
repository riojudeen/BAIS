<?php
require_once("../../../config/config.php");
require_once("../../../config/schedule_system.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // echo $_FILES['file_hospital']['name'];
    if(isset($_FILES['file_hospital']['name']) && in_array($_FILES['file_hospital']['type'], $file_mimes)) {
        $path =  $_FILES['file_hospital']['tmp_name'];
    
        // echo $path;
        // print_r($array_tgl);
        $arr_file = explode('.', $_FILES['file_hospital']['name']);
        $extension = end($arr_file);
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file_hospital']['tmp_name']);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetColumn = $spreadsheet->getActiveSheet();
        $lastColumn = $sheetColumn->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
        $cat = $_POST['hosp_type_upload'];
        mysqli_query($link, "DELETE FROM hospital WHERE category = '$cat' ")or die(mysqli_error($link));
        $query_hosp = "INSERT INTO hospital (`id`,`nama`,`alamat`,`kota`,`category`) VALUES";
        $id = idIncrement($link, "hospital","id");
        echo $id;
        for($i = 1;$i < count($sheetData);$i++){
            // menangkap nilai data apakah absen atau lembur
            
            $alamat = $sheetData[$i]['2'];
            $nama = $sheetData[$i]['1'];
            $kota = $sheetData[$i]['0'];
            $query_hosp .= " ('$id','$nama','$alamat','$kota', '$cat'),";
            $id++;
            // echo $i." : ".$nama."<br>";

        }
        $sql = substr($query_hosp, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $sql_hospital = mysqli_query($link, $sql);
        if($sql_hospital){
            ?>
            <script>
                Swal.fire({
                    title: 'Berhasil Disimpan',
                    text: 'Data Telah Diperbaharui',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else{
            ?>
            <script>
                Swal.fire({
                    title: 'Gagal Disimpan',
                    text: '<?=mysqli_error($link)?>',
                    // timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }
    }else{
        echo "data belum masuk";
    }
    ?>