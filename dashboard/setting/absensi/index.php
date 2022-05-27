<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
require_once("../../../config/schedule_system.php");
require_once("../../../config/approval_system.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// untuk absensi
if(($_GET['upload_cat']) == "absensi_upload"){
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        
        $tanggalAwal = dateToDB($_GET['mulai']);
        $tanggalAkhir = dateToDB($_GET['selesai']);
        // echo $tanggalAwal;
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        // $query = "INSERT INTO absensi (id , npk , shift , `date` , date_in , date_out , check_in , check_out , ket, id_req) VALUES ";

        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        
        
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetColumn = $spreadsheet->getActiveSheet();
        $lastColumn = $sheetColumn->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
        
        $no = 1;
        $query = "REPLACE INTO absensi (`id`,`npk`,`shift`,`date`,`date_in`,`date_out`,`check_in`,`check_out`,`ket`,`id_req`,`requester`) VALUES  ";
       
        $q_replace_overtime =  "REPLACE INTO hr_lembur (`id`,
                `npk`,`date`,`in_date`,`out_date`,
                `start`,`end`, `updated_by`) VALUES ";
        $q_cek_req = "SELECT `npk`, `keterangan`, `date`, `check_in`, `check_out` FROM req_absensi ";

        $indexColumn = 4 ;
        $jml_hari = hitungHari($tanggalAwal, $tanggalAkhir);
        $lastcolomn = $indexColumn + $jml_hari;
        //menghitung total hari
        $mulai = $tanggalAwal ;
        $selesai = $tanggalAkhir ;

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
        $total = (count($sheetData)-2) * $jml_hari;

        ?>
        <table class="table table-xs table-bordered " width="500px">
            <tbody class="py-0">
                <tr class="py-0">
                    <th scope="row">Total Hari</th>
                    <td><?=$jml_hari?></td>
                </tr>
                <tr>
                    <th scope="row">Total Karyawan</th>
                    <td><?=count($sheetData)?></td>
                </tr>
                <tr>
                    <th scope="row">Total Baris Data</th>
                    <td><?=$total?></td>
                </tr>
            </tbody>
        </table>
        
        <?php
        
        // looping tanggal
        /* looping tanggal diawal karena harus mendeteksi absensi pertanggal dari format upload horizontal*/
        $no = 1;
       
        foreach($array_tgl AS $date){
            // looping data karyawan
            $index_tanggal =( date('d', strtotime($date)) - 1)*3;
            
            for($i = 2;$i < count($sheetData);$i++){
                
                $npk = $sheetData[$i]['0'];
                $nama = $sheetData[$i]['1'];
                $dept = $sheetData[$i]['2'];
                $shift = $sheetData[$i]['3'];
                // ambil data check ini -out -ket berdasarkan tanggal mulai
                $index_mulai = 4 + $index_tanggal; 
                $in = $index_mulai;
                $out = $index_mulai + 1;
                $ket = $index_mulai + 2;
                $checkin = $sheetData[$i][$in];
                $checkout = $sheetData[$i][$out];
                $ket = $sheetData[$i][$ket];
                $id= $npk.$date;
                 /*
                selama belum ada perubahan data shift , 
                gunakan shift awal
                */
                $q_reqAbsensi = mysqli_query($link, "SELECT `shift` FROM req_absensi WHERE npk = '$npk' AND `date` = '$date' AND shift_req = '1' ")or die(mysqli_error($link));
                
                
                $q_shift = mysqli_query($link, "SELECT shift FROM karyawan WHERE npk = '$npk' ")or die(mysqli_error($link));
                if(mysqli_num_rows($q_shift) > 0){
                    $data = mysqli_fetch_assoc($q_shift);
                    $shift = $data['shift'];
                }else{
                    // menggunakan shift dari dokumen
                    $shift = shift_ubah($shift);
                }
                list($date_mulai, $date_selesai) = DateOut2($link, $shift, $date);
                
                $query .= "('$id','$npk','$shift', '$date', '$date_mulai','$date_selesai','$checkin','$checkout','$ket','$id','$npkUser'),";
                
                
                // update request 
                $q_cekAbs = mysqli_query($link, $q_cek_req." WHERE npk = '$npk' AND `date` = '$date' AND shift_req <> 1 ")or die(mysqli_error($link));
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
                ?>
                
                <?php
                
            }
        }
        $sql = substr($query, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $s_absensi = mysqli_query($link, $sql)or die(mysqli_error($link));
        if($s_absensi){
            ?>
            <script>
                Swal.fire({
                    title: 'Sukses',
                    text: "data absensi tanggal <?=tgl($tgl_pertama)?> sampai <?=tgl($tgl_terakhir)?> berhasil diupload",
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
    }else{
        echo "data belum masuk";
    }
}else if(($_GET['upload_cat']) == "overtime_upload"){
    echo "mantap";
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
        
        $tanggalAwal = dateToDB($_GET['mulai']);
        $tanggalAkhir = dateToDB($_GET['selesai']);
        // echo $tanggalAwal;
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        // $query = "INSERT INTO absensi (id , npk , shift , `date` , date_in , date_out , check_in , check_out , ket, id_req) VALUES ";

        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        
        
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetColumn = $spreadsheet->getActiveSheet();
        $lastColumn = $sheetColumn->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
        
        $no = 1;
        $query = "REPLACE INTO absensi (`id`,`npk`,`shift`,`date`,`date_in`,`date_out`,`check_in`,`check_out`,`ket`,`id_req`,`requester`) VALUES  ";
       
        $q_replace_overtime =  "REPLACE INTO hr_lembur (`id`,
                `npk`,`date`,`in_date`,`out_date`,
                `start`,`end`, `updated_by`) VALUES ";
        $q_cek_req = "SELECT `npk`, `keterangan`, `date`, `check_in`, `check_out` FROM req_absensi ";
        $q_cek_shift = "SELECT npk , shift FROM karyawan ";

        $indexColumn = 4 ;
        $jml_hari = hitungHari($tanggalAwal, $tanggalAkhir);
        $lastcolomn = $indexColumn + $jml_hari;
        //menghitung total hari
        $mulai = $tanggalAwal ;
        $selesai = $tanggalAkhir ;

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
        $total = (count($sheetData)-2) * $jml_hari;

        ?>
        <table class="table table-xs table-bordered " width="500px">
            <tbody class="py-0">
                <tr class="py-0">
                    <th scope="row">Total Hari</th>
                    <td><?=$jml_hari?></td>
                </tr>
                <tr>
                    <th scope="row">Total Karyawan</th>
                    <td><?=count($sheetData)?></td>
                </tr>
                <tr>
                    <th scope="row">Total Baris Data</th>
                    <td><?=$total?></td>
                </tr>
            </tbody>
        </table>
        
        <?php
        
        // looping tanggal
        /* looping tanggal diawal karena harus mendeteksi absensi pertanggal dari format upload horizontal*/
        $no = 1;
       
        foreach($array_tgl AS $date){
            // looping data karyawan
            $index_tanggal =( date('d', strtotime($date)) - 1)*3;
            for($i = 2;$i < count($sheetData);$i++){
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




                
                // $npk = $sheetData[$i]['0'];
                // $nama = $sheetData[$i]['1'];
                // $dept = $sheetData[$i]['2'];
                // $shift = $sheetData[$i]['3'];
                // // ambil data check ini -out -ket berdasarkan tanggal mulai
                // $index_mulai = 4 + $index_tanggal; 
                // $in = $index_mulai;
                // $out = $index_mulai + 1;
                // $ket = $index_mulai + 2;
                // $checkin = $sheetData[$i][$in];
                // $checkout = $sheetData[$i][$out];
                // $ket = $sheetData[$i][$ket];
                // $id= $npk.$date;
                //  /*
                // selama belum ada perubahan data shift , 
                // gunakan shift awal
                // */
                // $q_reqAbsensi = mysqli_query($link, "SELECT `shift` FROM req_absensi WHERE npk = '$npk' AND `date` = '$date' AND shift_req = '1' ")or die(mysqli_error($link));
                
                
                // $q_shift = mysqli_query($link, "SELECT shift FROM karyawan WHERE npk = '$npk' ")or die(mysqli_error($link));
                // if(mysqli_num_rows($q_shift) > 0){
                //     $data = mysqli_fetch_assoc($q_shift);
                //     $shift = $data['shift'];
                // }else{
                //     // menggunakan shift dari dokumen
                //     $shift = shift_ubah($shift);
                // }
                // list($date_mulai, $date_selesai) = DateOut2($link, $shift, $date);
                
                // $query .= "('$id','$npk','$shift', '$date', '$date_mulai','$date_selesai','$checkin','$checkout','$ket','$id','$npkUser'),";
                
                
                // update request 
                // $q_cekAbs = mysqli_query($link, $q_cek_req." WHERE npk = '$npk' AND `date` = '$date' AND shift_req <> 1 ")or die(mysqli_error($link));
                // if(mysqli_num_rows($q_cekAbs)>0){
                //     // jika ada cek pengajuan
                //     $dataReqAbs = mysqli_fetch_assoc($q_cekAbs);
                //     $ket_reqAbs = $dataReqAbs['keterangan'];
                //     $cin_reqAbs = $dataReqAbs['check_in'];
                //     $cout_reqAbs = $dataReqAbs['check_out'];
                //     // jika request SKTA 
                //     if($ket_reqAbs == "SKTA"){
                //         // jika data in dan out sudah sama maka artinya data SKTA sudah diapprove
                //         // jalankan update
                //         $iin = strtotime("$cin_reqAbs");
                //         $iiin = strtotime("$checkin");
                //         $oot = strtotime("$cout_reqAbs");
                //         $ooot = strtotime("$checkout");
                //         if($iin == $iiin && $oot == $ooot){
                //             mysqli_query($link, "UPDATE req_absensi SET req_status = 'a' , 
                //             `status` = '100' WHERE id_absensi  = '$id' AND shift_req <> '1' AND keterangan = 'SKTA' 
                //             ")or die(mysqli_error($link));
                //         }
                //     }else{
                //         // jika supem dan data absensi sudah sama artinya data sudah diapprove HRD
                //         if($ket_reqAbs == $ket){
                //             // echo "SUPEM sukses";
                //             mysqli_query($link, "UPDATE req_absensi SET req_status = 'a' , 
                //             `status` = '100' WHERE id_absensi  = '$id' AND shift_req <> '1' AND keterangan = '$ket' 
                //             ")or die(mysqli_error($link));
                //         }
                //     }
                // }
                ?>
                
                <?php
                
            }
        }
        $sql = substr($q_replace_overtime, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        $s_overtime = mysqli_query($link, $sql)or die(mysqli_error($link));
        if($s_overtime){
           ?>
            <script>
                Swal.fire({
                    title: 'Sukses',
                    text: "data overtime tanggal <?=tgl($tgl_pertama)?> sampai <?=tgl($tgl_terakhir)?> berhasil diupload",
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
    }else{
        echo "data belum masuk";
    }
}
    
    ?>