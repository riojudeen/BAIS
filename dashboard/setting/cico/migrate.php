<?php
require_once("../../../config/config.php");
require_once("../../../config/schedule_system.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    // if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        // echo $_FILES['file_import']['name'];
        $firstdate = date('Y-m-1');
        $today = date('Y-m-d');
        $pecahtanggal = explode("-", $today);
        $extention = '.xls';
        $nama_file = $pecahtanggal[0].$pecahtanggal[1].$extention;
        $query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'CICO' ")or die(mysqli_error($link));
            $sql_dir = mysqli_fetch_assoc($query_dir);
            $root_path = $sql_dir['root'];
        $path = "$root_path".$nama_file;
        
        
        // echo $path;
        if (file_exists($path)) {
            // echo $path['name'];
            // echo "OK";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            

            $indexColumn = 4 ;
            $jml_hari = hitungHari($firstdate, $today);
            $lastcolomn = $indexColumn + $jml_hari;
            //menghitung total hari
            $mulai = $firstdate ;
            $selesai = $today ;
    
            $tgl_pertama = date('Y-m-d', strtotime($mulai));
            $tgl_terakhir = date('Y-m-d', strtotime($selesai));
            $start = $month = strtotime($tgl_pertama);
            $end = strtotime($tgl_terakhir);
    
            $awal = date_create($tgl_pertama);
            $akhir = date_create($tgl_terakhir);
    
            $no_urut = 1;
            $i = 0;
            $array_tgl = array();
            while($month <= $end){
                $tgl = date('Y-m-d', $month);
                $month = strtotime("+1 day", $month);
                $hari = hari_singkat($tgl);
                $array_tgl[$i++] = $tgl;
            }
            // print_r($array_tgl);
            
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $spreadsheet = $reader->load($path);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $sheetColumn = $spreadsheet->getActiveSheet();
            $lastColumn = $sheetColumn->getHighestColumn();
            $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
            

            $q_replace_absensi =  "REPLACE INTO absensi (`id`,
                `npk`,`shift`,`date`,`date_in`,`date_out`,
                `check_in`,`check_out`,`ket`,`requester`) VALUES ";
            $q_cek_shift = "SELECT npk , shift FROM karyawan ";
            $q_cek_req = "SELECT `npk`, `keterangan`, `date`, `check_in`, `check_out` FROM req_absensi ";

            $q_replace_overtime =  "REPLACE INTO hr_lembur (`id`,
                `npk`,`date`,`in_date`,`out_date`,
                `start`,`end`, `updated_by`) VALUES ";
            
            foreach($array_tgl AS $date){
                // looping data karyawan
                $index_tanggal =( date('d', strtotime($date)) - 1)*3;
                
                for($i = 3;$i < count($sheetData);$i++){
                    // menangkap nilai data apakah absen atau lembur
                    $scope = $sheetData[$i]['4'];
                    
                    if($scope == 'Absen'){
                        $npk = $sheetData[$i]['0'];
                        $nama = $sheetData[$i]['1'];
                        $dept = $sheetData[$i]['2'];
                        $q_shift = mysqli_query($link, $q_cek_shift." WHERE npk = '$npk' ")or die(mysqli_error($link));
                        // jika karyawan ada di database pake shift karyawan
                        if(mysqli_num_rows($q_shift)>0){
                            $data_shift = mysqli_fetch_assoc($q_shift);
                            $shift = $data_shift['shift'];
                        }else{
                            $shift = shift_ubah($sheetData[$i]['3']);
                        }
                        // ambil data check ini -out -ket berdasarkan tanggal mulai
                        $index_mulai = 4 + $index_tanggal; //index pertama 5
                        $in = $index_mulai + 1;
                        $out = $index_mulai + 2;
                        $ket = $index_mulai + 3;

                        $checkin = (isset($sheetData[$i][$in]))?(($sheetData[$i][$in] == '')?"00:00:00":$sheetData[$i][$in]):"00:00:00";
                        $checkout = (isset($sheetData[$i][$out]))?(($sheetData[$i][$out] == '')?"00:00:00":$sheetData[$i][$out]):"00:00:00";
                        $ket = (isset($sheetData[$i][$ket]))?$sheetData[$i][$ket]:'';
                        $id= $npk.$date;

                        list($date_mulai, $date_selesai) = DateOut2($link, $shift, $date);
                        $q_cekAbs = mysqli_query($link, $q_cek_req." WHERE npk = '$npk' AND `date` = '$date' AND shift_req <> 1 ")or die(mysqli_error($link));
                        
                        // echo $iin."-".$iint."-".$iiint."<br>";
                        $q_replace_absensi .= " ('$id','$npk', '$shift', '$date','$date_mulai','$date_selesai','$checkin','$checkout','$ket','$npkUser'),";
                        // cek apalkah sudah ada pengajuan atau belum
                        if(mysqli_num_rows($q_cekAbs)>0){
                            // jika ada cek pengajuan
                            $dataReqAbs = mysqli_fetch_assoc($q_cekAbs);
                            $ket_reqAbs = $dataReqAbs['keterangan'];
                            $cin_reqAbs = $dataReqAbs['check_in'];
                            $cout_reqAbs = $dataReqAbs['check_out'];
                            // jika request SKTA 
                            if($ket_reqAbs == "SKTA"){
                                // jika data in dan out sudah sama maka artinya data SKTA sudah diapprove
                                // jalankan update
                                $iin = strtotime("$cin_reqAbs");
                                $iiin = strtotime("$checkin");
                                $oot = strtotime("$cout_reqAbs");
                                $ooot = strtotime("$checkout");
                                if($iin == $iiin && $oot == $ooot){
                                    mysqli_query($link, "UPDATE req_absensi SET req_status = 'a' , 
                                    `status` = '100' WHERE id_absensi  = '$id' AND shift_req <> '1' AND keterangan = 'SKTA' 
                                    ")or die(mysqli_error($link));
                                }
                            }else{
                                // jika supem dan data absensi sudah sama artinya data sudah diapprove HRD
                                if($ket_reqAbs == $ket){
                                    // echo "SUPEM sukses";
                                    mysqli_query($link, "UPDATE req_absensi SET req_status = 'a' , 
                                    `status` = '100' WHERE id_absensi  = '$id' AND shift_req <> '1' AND keterangan = '$ket' 
                                    ")or die(mysqli_error($link));
                                }
                            }
                        }
                        
                    }else if($scope == 'Lembur'){
                        $npk = $sheetData[$i]['0'];
                        $nama = $sheetData[$i]['1'];
                        $dept = $sheetData[$i]['2'];

                        // ambil data mulai dan selesai lembur
                        $index_mulai = 4 + $index_tanggal; //index pertama 5
                        $in = $index_mulai + 1;
                        $out = $index_mulai + 2;
                        $ket = $index_mulai + 3;

                        $start = (isset($sheetData[$i][$in]))?(($sheetData[$i][$in] == '')?"00:00:00":$sheetData[$i][$in]):"00:00:00";
                        $end = (isset($sheetData[$i][$out]))?(($sheetData[$i][$out] == '')?"00:00:00":$sheetData[$i][$out]):"00:00:00";
                        $id= $npk.$date;
                        $q_shift = mysqli_query($link, $q_cek_shift." WHERE npk = '$npk' ")or die(mysqli_error($link));
                        // jika karyawan ada di database pake shift karyawan
                        if(mysqli_num_rows($q_shift)>0){
                            $data_shift = mysqli_fetch_assoc($q_shift);
                            $shift = $data_shift['shift'];
                        }else{
                            $shift = shift_ubah($sheetData[$i]['3']);
                        }
                        list($date_mulai, $date_selesai) = DateOut2($link, $shift, $date);
                        
                        // echo $iin."-".$iint."-".$iiint."<br>";
                        $q_replace_overtime .= " ('$id','$npk','$date','$date_mulai','$date_selesai','$start','$end','$npkUser'),";
                        // cek apalkah sudah ada pengajuan atau belum
                    }
                    ?>
                    
                    <?php
                    
                }
            }
            // echo $q_replace_overtime;
            $q_replace_overtime = substr($q_replace_overtime, 0, -1);
            $q_replace_absensi = substr($q_replace_absensi, 0, -1);
            $sql_absensi = mysqli_query($link, $q_replace_absensi);
            $sql_overtime = mysqli_query($link, $q_replace_overtime);
            if($sql_absensi && $sql_overtime){
                ?>
                    <script>
                        Swal.fire({
                            title: 'Sukses',
                            text: "data absensi & overtime tanggal <?=tgl($tgl_pertama)?> sampai <?=tgl($tgl_terakhir)?> berhasil diupload",
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
                            title: 'Galat!',
                            text: "<?=mysqli_error($link)?>",
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
        } else {
            ?>
                <script>
                    Swal.fire({
                        title: 'File Belum Siap!',
                        text: "data absensi tanggal <?=tgl($tgl_pertama)?> sampai <?=tgl($tgl_terakhir)?> gagal diupload",
                        timer: 2000,
                        
                        icon: 'info',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                </script>
            <?php
            // echo "null";
            // $file = fopen($path, "r");
            // echo "File berhasil dibaca.";
        }
    // }else{
    //     echo "data belum masuk";
    // }
    ?>