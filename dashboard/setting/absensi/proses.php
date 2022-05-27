<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
require_once("../../../config/schedule_system.php");
require_once("../../../config/approval_system.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
if(isset($_SESSION['user'])){
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
        $sql = "INSERT INTO absensi (id , npk , shift , `date` , date_in , date_out , check_in , check_out , ket, id_req) VALUES ";
        $max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS id FROM absensi"));

        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        
        
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetColumn = $spreadsheet->getActiveSheet();
        $lastColumn = $sheetColumn->getHighestColumn();
        $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\coordinate::columnIndexFromString($lastColumn);
        
        $no = 1;
        $sqlAtt = mysqli_query($link, "SELECT * FROM absensi 
        JOIN karyawan ON karyawan.npk = absensi.npk
        WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' ")or die(mysqli_error($link));
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
        <div class="card card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 pl-1">
                        <div class="input-group no-border">
                            <select name="sortdate" id="sortdate" class="form-control no-border ml-2">
                                <?php
                                foreach($array_tgl AS $sort){
                                    ?>
                                    <option value="<?=$sort?>"><?=$sort?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            
                            <div class="input-group-append ">
                                <span class=" pr-1 btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            
        </div>
        <div class="card card-body">
            <div class="table-responsive" style=" max-height:1000px" >

                <table class="table table-striped table_org text-nowrap" id="uangmakan" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="allcek">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </th>
                            <th>NPK</th>
                            <th>Nama</th>
                            <th>Shift</th>
                            <th>Dept</th>
                            <th>Tanggal Kerja</th>
                            <th>In</th>
                            <th>Out</th>
                            <th colspan="2">Ket</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    // looping tanggal
                    /* looping tanggal diawal karena harus mendeteksi absensi pertanggal dari format upload horizontal*/
                    $no = 1;
                    foreach($array_tgl AS $date){
                        // looping data karyawan
                        $index_tanggal =( date('d', strtotime($date)) - 1)*3;
                        
                        for($i = 2;$i < count($sheetData);$i++){
                            // echo "<tr>";
                            
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

                            $query = mysqli_query($link, "SELECT * FROM view_organization WHERE npk = '$npk' ")or die(mysqli_error($link));
                            $data_karyawan = mysqli_fetch_assoc($query);
                            if(mysqli_num_rows($query)<=0){
                                $notif = "belum ada data register di BAIS";
                                $color = "table-danger";
                            }else{
                                $notif = $data_karyawan['nama'];
                                $color ="";
                            }
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>
                                <td><?=$npk?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$npk?>" style="border: 0px"> 
                                </td>
                                <td ><?=$nama?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$nama?>" style="border: 0px"> 
                                </td>
                                <td ><?=$shift?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$shift?>" style="border: 0px"> 
                                </td>
                                <td><?=$dept?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$dept?>" style="border: 0px">
                                </td>
                                <td><?=$date?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$date?>" style="border: 0px">
                                </td>
                                <td><?=$checkin?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$checkin?>" style="border: 0px">
                                </td>
                                <td><?=$checkout?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$checkout?>" style="border: 0px">
                                </td>
                                <td><?=$ket?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$ket?>" style="border: 0px">
                                </td>
                                <td><?=$index_mulai?>
                                    <input readonly type="hidden" class="no-border p-0 form-control bg-transparent m-0 text-nowrap border-none" value="<?=$index_mulai?>" style="border: 0px">
                                </td>
                                
                                
                            </tr>
                            <?php
                            // for($indexColumn = 4 ; $indexColumn < $lastColumnIndex ; $indexColumn++){
                            //     $id = $max['id'] + $tmbahid;
                            //     $tmbahid++;
                            //     $npk = $sheetData[$i]['0'];
                            //     $shift = $sheetData[$i]['3'];
                            //     $dateSheet = $sheetData['1'][$indexColumn];
                            //     $date = convertDatetoDB($dateSheet);
                            //     $check_in = date('H:i:s' ,strtotime($date.' '.$sheetData[$i][$indexColumn]));
                                
                            //     $indexColumn = $indexColumn+1;
                            //     $check_out = date('H:i:s' ,strtotime($date.' '.$sheetData[$i][$indexColumn]));
                            //     $indexColumn = $indexColumn+1;
                            //     $ket = $sheetData[$i][$indexColumn];
                            //     $id_req = $npk.$date;
                            //     $date_in = $date;
                            //     $timestampWaktuIn = strtotime($date.' '.$check_in);
                            //     $timestampWaktuOut = strtotime($date.' '.$check_out);
                            //     if($timestampWaktuIn > $timestampWaktuOut){
                            //         $date_out = date('Y-m-d' , strtotime('+1 days', strtotime($date)));
                            //     }else{
                            //         $date_out = $date_in;
                            //     }
                                
                            //     $sql .=" ('$id', '$npk', '$shift','$date','$date_in','$date_out','$check_in','$check_out','$ket','$id_req'),";
                                
                            //     // $npk = $sheetData[$i]['1'];
                            //     // $shift = $sheetData[$i]['2'];
                            //     // $date_mulai = $sheetData[$i]['6'];
                            //     // $date_selesai = $sheetData[$i]['7'];
                                
                            //     // echo "<td>".$npk."</td>";
                            //     // echo "<td>".$shift."</td>";
                            //     // echo "<td>".$date."</td>";
                            //     // echo "<td>".$date_in."</td>";
                            //     // echo "<td>".$date_out."</td>";
                            //     // echo "<td>".$check_in."</td>";
                            //     // echo "<td>".$check_out."</td>";
                            //     // echo "<td>".$ket."</td>";
                            // }
                            // echo "<tr/>";
                        }
                    }
                    // $tmbahid = 1;
                    
                    // $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
                    // echo $sql;
                    // $data = mysqli_query($link, $sql)or die(mysqli_error($link));
                    // // echo $sqlUser;
                    // if($data){
                    //     // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
                    //     $_SESSION['info'] = "Disimpan";
                    //     header("Location: ../portAtt.php"); 
                    // }else{
                    //     $_SESSION['info'] = "Kosong";
                    //     header("Location: ../portAtt.php");
                    // }
                    ?>
                    </tbody>
                        
                </table>
            </div>  
        </div>
        <?php
        }else{
            echo "data belum masuk";
        }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>