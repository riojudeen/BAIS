<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
require("../../_assets/vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    // $_GET['return'] = '44131';
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM req_absensi")) or die(mysqli_error($link));
    if(isset($_POST['add'])){
        
        if($_POST['tipe'] == 'SUPEM'){
            // pengajuan supem dari konfirmasi absensi
            
            $shift_req = 0;
            $requester =  $npkUser ;
            $date = dateToDB($_POST['d']);
            $cO = $_POST['ci'];
            $cI = $_POST['co'];
            $ket = $_POST['kode_absen'][0];
            $status = authApprove($level, "status", "request");;
            $reqStats = authApprove($level, "request", "request");
            $note = $_POST['note'][0];
            $req_date = date('Y-m-d');
            $npk_ = $_POST['npk'];
            $shift = $_POST['shift'];
            $id = $npk_.$date;
            

            list($tglini, $sesudah, $cin, $cout, $jml) = WD($link, $shift, $date);


            $dO = $tglini;
            $dI = $sesudah;
            // echo $_FILES['attach-upload']['name'];
            // simpan file upload
            $file_mimes = array('image/jpeg','image/jpg','image/png');
            if(isset($_FILES['attach-upload']['name']) && in_array($_FILES['attach-upload']['type'], $file_mimes)) {
                
                $ImageName       = $_FILES['attach-upload']['name'];
                $image = $_FILES['attach-upload']['name'];
                $dir = $_FILES['attach-upload']['tmp_name']; //file upload
                // $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/";
                $path = "image_attachment/";
                if (file_exists($path)){
                    // compress image
                    $namaGambar     = $id_image."_".$tot_tgl."_".$type;
                    $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                    $ImageExt       = str_replace('.','',$ImageExt); // Extension
                    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                    $NewImageName   = str_replace(' ', '', $namaGambar.'.'.$ImageExt);

                    $newPath = $path.$NewImageName; //direktori penyimpanan
                    // echo $newPath;
                    $source =  $dir;
                    // echo $source;
                    $imgInfo = getimagesize($source); 
                    $mime = $imgInfo['mime'];  
                    $quality = 20;
                    // membuat image baru
                    switch($mime){ 
                    // proses kode memilih tipe tipe image 
                        case 'image/jpeg': 
                            $image = imagecreatefromjpeg($source); 
                            break; 
                        case 'image/jpg': 
                            $image = imagecreatefromjpeg($source); 
                            break; 
                        case 'image/png': 
                            $image = imagecreatefrompng($source); 
                            break; 
                        default: 
                            $image = imagecreatefromjpeg($source); 
                    }
                    imagejpeg($image, $newPath, $quality);
                    $imageName = "'".$namaGambar.".$ImageExt"."'";
                }
                $id_absensi = $imageName;
                $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
                    VALUES ('$id', '$npk_' , '$date', '$shift', '$dI', '$dO' , '$cO' , '$cI' , '$ket', '$requester', '$status', '$reqStats', '$req_date' , '$note', '$shift_req', $id_absensi )";

                $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                if($sql){
                    $_SESSION['info'] = 'Disimpan';
                    header('location: req_absensi.php');
                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    
                    header('location: req_absensi.php');
                }
            }else{
                // echo "gagal";
                $cek_attendance_attachement = mysqli_query($link,"SELECT attachment FROM attendance_code WHERE kode = '$ket' ")or die(mysqli_error($link));
                $data_attachment = mysqli_fetch_assoc($cek_attendance_attachement);
                $query = substr($query, 0, -1);
                if(isset($data_attachment['attachment']) && $data_attachment['attachment'] == 1 ){
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( Silakan Ulangi Pengajuan dan Pastikan Lampiran diupload dengan format gambar )";
                    header('location: req_absensi.php');
                }else{
                    // echo $ket;
                    // echo $query;
                    $id_absensi = "NULL";
                    $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
                        VALUES ('$id', '$npk_' , '$date', '$shift', '$dI', '$dO' , '$cO' , '$cI' , '$ket', '$requester', '$status', '$reqStats', '$req_date' , '$note', '$shift_req', $id_absensi )";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if($sql){
                        $_SESSION['info'] = 'Disimpan';
                        header('location: req_absensi.php');
                    }else{
                        $_SESSION['info'] = 'Gagal Disimpan';
                        header('location: req_absensi.php');
                    }
                }
                
            }



            
        }else if($_POST['tipe'] == 'SUKET'){

            $shift_req = 0;
            $requester =  $npkUser ;
            $date = dateToDB($_POST['d']);
            $cO = $_POST['ci'];
            $cI = $_POST['co'];
            $ket = $_POST['kode_absen'][0];
            $status = authApprove($level, "status", "request");;
            $reqStats = authApprove($level, "request", "request");
            $note = $_POST['note'][0];
            $req_date = date('Y-m-d');
            $npk_ = $_POST['npk'];
            $shift = $_POST['shift'];
            $id = $npk_.$date;
            $id_absensi = $_POST['add'];

            list($tglini, $sesudah, $cin, $cout, $jml) = WD($link, $shift, $date);


            $dO = $tglini;
            $dI = $sesudah;

            $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
                    VALUES ('$id', '$npk_' , '$date', '$shift', '$dI', '$dO' , '$cO' , '$cI' , '$ket', '$requester', '$status', '$reqStats', '$req_date' , '$note', '$shift_req', '$id_absensi' )";
                    
             // echo $query;
             $sql = mysqli_query($link, $query)or die(mysqli_error($link));
             if($sql){
                 $_SESSION['info'] = 'Disimpan';
                 echo "<script>document.location.href='req_absensi.php'</script>";
             }else{
                 $_SESSION['info'] = 'Gagal Disimpan';
                 echo "<script>document.location.href='req_absensi.php'</script>";
             }
            
            // echo $id."<br>";
            // echo $checkIn."<br>";
            // echo $checkOut."<br>";
            // echo $requester."<br>";
            // echo $date."<br>";
            // echo $dO."<br>";
            // echo $dI."<br>";
            // echo $status."<br>";
            // echo $reqStats."<br>";
            // echo $req_date."<br>";

            // $sql = mysqli_query($link, "INSERT req_absensi (id , npk, `date` , shift , date_in, date_out, check_in, check_out, keterangan , requester,`status`, req_status, req_date, note ) 
            //                             VALUES ($id, '$npk_' , '$date', '$shift', '$dI', '$dO' , '$checkIn' , '$checkOut' , '$ket', '$requester', '$status', '$reqStats', '$req_date' , '$note' )")or die(mysqli_error($link));
            // if($sql){
            //     $_SESSION['info'] = 'Disimpan';
            //     echo "<script>document.location.href='req_absensi.php'</script>";
            // }else{
            //     $_SESSION['info'] = 'Gagal Disimpan';
            //     echo "<script>document.location.href='req_absensi.php'</script>";
            // }
        }else{

        }
    }else if(isset($_POST['schedule'])){
        $sql = "INSERT req_absensi (id , npk, `date` , shift , date_in, date_out, check_in, check_out, keterangan , requester,`status`, req_status, req_date, note ) VALUES ";
       
        $id = $maxId['id'] + 1;
        $checkIn = '00:00:00';
        $checkOut = '00:00:00';
        $requester =  $npkUser ;
        $shift =  $_POST['shift'][0] ;
        $ket =  $_POST['kode_absen'][0] ;
        $npk_ = $_POST['npk'];
        $note = $_POST['note'][0];
        $sd = dateToDB($_POST['sd']);
        $ed = dateToDB($_POST['ed']);
        $status = "0";
        $reqStats = "a";
        $req_date = date('Y-m-d');
        // echo $sd."<br>";
        // echo $ed."<br>";
        
       

        $tanggalAwal = date('Y-m-d', strtotime($sd));
        // echo "tanggal awal : ".$tanggalAwal."<br>";
        $tanggalAkhir = date('Y-m-d', strtotime($ed));
        // echo "tanggal akhir : ". $tanggalAkhir."<br>";


        $count_awal = date_create($tanggalAwal);
        $count_akhir = date_create($tanggalAkhir);
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
        
        $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
        $akhir =  strtotime($tanggalAkhir); 
        $i = 0;
        while($blnAwal <= $akhir){
            $tgl = date('Y-m-d', $blnAwal);
            $blnAwal = strtotime("+1 day", $blnAwal);
            $array_tgl[$i++] = $tgl;
            // echo $tgl."<br>";
        }
        $i = 0;
        foreach($array_tgl AS $tanggal){

            // cek working days
            $sqlWD = mysqli_query($link, "SELECT working_hours.id AS id_wh,
                                working_hours.start AS ci,
                                working_hours.end AS co,
                                working_days.shift AS shf,
                                working_hours.code_name AS code_wh,
                                working_days.date AS tgl,
                                working_days.wh AS wh,
                                working_days.ket AS ket,
                                working_days.id AS id
                                        
                                FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
                                WHERE working_days.shift = '$shift' AND working_days.date = '$tanggal' ")or die(mysqli_error($link));
            $dataWD = mysqli_fetch_assoc($sqlWD);
            
            $cin = $dataWD['ci'];
            $cout = $dataWD['co'] ;
            
            if($cin > $cout){
                
                $dI[$i] = $tanggal;
                $dO[$i] = date('Y-m-d', strtotime("+1 days", strtotime($tanggal)));
                
            }else{
                
                $dI[$i] = $tanggal;
                $dO[$i] = $tanggal;
              
            }
            $i++;
            
            
        }
        for($i =0 ; $i < $hari ; $i++ ){
            $id_absen = $id + $i;
            $sql .= "('$id_absen', '$npk_', '$array_tgl[$i]', '$shift', '$dI[$i]', '$dO[$i]', '$checkIn', '$checkOut', '$ket', '$requester', '$status', '$reqStats', '$req_date', '$note' ),";
        }
        $sql = substr($sql, 0 , -1); //menghilangkan koma terakhir menggunakan substr
        // echo $sql;
        $schedule = mysqli_query($link, $sql)or die(mysqli_error($link));

        
        if($schedule){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='req_absensi.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='req_absensi.php'</script>";
        }
    }else if(isset($_GET['req'])){
        mysqli_query($link, "UPDATE req_absensi SET `status` = '25', req_status = 'a' WHERE id = '$_GET[req]' ");
        $_SESSION['info'] = 'Request';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }else if(isset($_GET['del'])){
        list($id, $ket, $req_shift) = pecahID($_GET['del']);
        mysqli_query($link , "DELETE FROM req_absensi WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
    }else if(isset($_POST['edit'])){
        
        $checkIn = '00:00:00';
        $checkOut = '00:00:00';
        $requester =  $npkUser ;
        $shift =  $_POST['shift'][0] ;
        $ket =  $_POST['kode_absen'][0] ;
        $npk_ = $_POST['npk'];
        $note = $_POST['note'][0];
        $sd = dateToDB($_POST['sd']);
        $status = "0";
        $reqStats = "a";
        $req_date = date('Y-m-d');
        $id = mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM req_absensi WHERE npk = '$npk_' AND `date` = '$sd' "));

        mysqli_query($link, "UPDATE req_absensi SET keterangan = '$ket' , note = '$note' WHERE id = '$id[id]' ");

        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }else if(isset($_GET['approve'])){
        $status = authApprove($level, "status", "approved");
        $req_status = authApprove($level, "request", "approved");
        list($id, $ket, $req_shift) = pecahID($_GET['approve']);
        // echo "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$_GET[approve]'" ;
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['return'])){
        $status = authApprove($level, "status", "return");
        $req_status = authApprove($level, "request", "return");
        list($id, $ket, $req_shift) = pecahID($_GET['return']);
        // echo $status.$req_status;
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
        
    }else if(isset($_GET['reject'])){
        $status = authApprove($level, "status", "rejected");
        $req_status = authApprove($level, "request", "rejected");
        list($id, $ket, $req_shift) = pecahID($_GET['reject']);
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
        
    }else if(isset($_GET['proses'])){
        $status = authApprove($level, "status", "proses");
        $req_status = authApprove($level, "request", "proses");
        list($id, $ket, $req_shift) = pecahID($_GET['proses']);
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
        
    }else if(isset($_GET['stop'])){
        $status = authApprove($level, "status", "stop");
        $req_status = authApprove($level, "request", "stop");
        list($id, $ket, $req_shift) = pecahID($_GET['stop']);
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
        
    }else if(isset($_GET['request'])){
        $status = authApprove($level, "status", "request");
        $req_status = authApprove($level, "request", "request");
        list($id, $ket, $req_shift) = pecahID($_GET['request']);
        mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
        
    }else if(isset($_GET['approve_multiple'])){
       //proses approve  oleh SPV
       $status = authApprove($level, "status", "approved");
       $req_status = authApprove($level, "request", "approved");
      
       if(count($_POST['checked']) > 0){
           foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
               mysqli_query($link, "UPDATE req_absensi SET note_return = NULL, `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
           }
       }
    }else if(isset($_GET['return_multiple'])){
        //proses retunr oleh admin
        $note_return = $_GET['return_multiple'];
        $status = authApprove($level, "status", "return");
        $req_status = authApprove($level, "request", "return");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET note_return = '$note_return', `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
            }
        }
    }else if(isset($_GET['stop_multiple'])){
        //proses reject / stop  oleh admin
        $note_return = $_GET['stop_multiple'];
        $status = authApprove($level, "status", "stop");
        $req_status = authApprove($level, "request", "stop");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET note_return = '$note_return', `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
    }else if(isset($_GET['proses_multiple'])){
        //proses approve oleh admin
        $status = authApprove($level, "status", "proses");
        $req_status = authApprove($level, "request", "proses");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET note_return = NULL, `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
        
    }else if(isset($_GET['reject_multiple'])){
       //proses approve oleh admin
       $note_return = $_GET['reject_multiple'];
       $status = authApprove($level, "status", "rejected");
       $req_status = authApprove($level, "request", "rejected");
       if(count($_POST['checked']) > 0){
           foreach($_POST['checked'] AS $data){
             list($id, $ket, $req_shift) = pecahID($data);
               mysqli_query($link, "UPDATE req_absensi SET note_return = '$note_return', `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
           }
       }
    }else if(isset($_POST['shift_req'])){
        //proses approve oleh admin
        
        if($_POST['shift_req'] == $_POST['shift_tujuan']){
            $_SESSION['info'] = 'Gagal Disimpan';
            $_SESSION['pesan'] = "( shift asal dan tujuan sama )";
            echo "<script>document.location.href='shift_request.php'</script>";
        }else{
            $req_date = date('Y-m-d');
            $requester = $npkUser;
            $npk = $_POST['shift_req'];
            $ket = 'SHIFT';
            $shift_asal = $_POST['shift_asal'];
            $mulai = $_POST['start'];
            $selesai = ($_POST['end'] == '' || $_POST['end'] == '0000-00-00')?'0000-00-00':$_POST['end'];
            // echo $selesai;
            $shift_tujuan = $_POST['shift_tujuan'];
            $status = authApprove($level, "status", "request");
            $req_status = authApprove($level, "request", "request");
            // echo $status.$req_status;
            $tanggal =  json_decode(get_date($mulai, $selesai));
            
            // print_r($tanggal);
            $or_date = '';
            $or_id = '';
            foreach($tanggal AS $date){
                $id_or = $npk.$date;
                $or_id .= " `id` = '$id_or' OR";
                $or_date .= " `date` = '$date' OR";
            }
            $s = strtotime($mulai);
            $e = strtotime($selesai);

            if($s > $e){
                // echo "tes";
                $q_cek = "SELECT npk FROM req_absensi WHERE npk = '$npk' AND shift_req = '1' AND `date` = '$mulai' AND date_in = '$mulai' AND date_out = '00:00:00'";
                // echo $q_cek;
                $cek_request = mysqli_query($link, $q_cek);
                // echo mysqli_num_rows($cek_request);
                if(mysqli_num_rows($cek_request)>0){
                    echo "mantap sudah ada";
                    // echo $q_cek;
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( pengajuan sudah pernah dibuat ) ";
                    echo "<script>document.location.href='shift_request.php'</script>";
                }else{
                    // echo "OK";
                    $id = $npk.$mulai;
                    
                    $query = " INSERT INTO req_absensi (`id`, `npk`, `shift`, `date`, `date_in` , `keterangan`, `requester` , `status`, `req_status`, `req_date`, `shift_req` ) VALUES ('$id', '$npk', '$shift_tujuan', '$mulai', '$mulai', '$ket', '$requester' , '$status', '$req_status', '$req_date', '1')";
                    // echo $query;
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if($sql){
                        // echo "OK";
                        $_SESSION['info'] = 'Request';
                        $_SESSION['pesan'] = "( pengajuan perpindahan shift telah diteruskan ) ";
                        echo "<script>document.location.href='shift_request.php'</script>";
                        // echo $q_cek;
                    }else{
                        $_SESSION['info'] = 'Gagal Disimpan';
                        $_SESSION['pesan'] = "(".mysqli_error($link).")";
                        echo "<script>document.location.href='shift_request.php'</script>";
                    }
                }
            }else{
                echo "SALAH";
                // $or_id = substr($or_id, 0, -2);
                // $or_date = substr($or_date, 0, -2);
    
                // $add_id = ($or_id != '')?" AND ($or_id)":'';
                // $add_date = ($or_date != '')?" AND ($or_date)":'';
                
                // $q_cek = "SELECT npk FROM req_absensi WHERE npk = '$npk' AND shift_req = '1' AND `date` BETWEEN '$mulai' AND '$selesai' ";
                // // echo $q_cek;
                // $cek_request = mysqli_query($link, $q_cek);
                // // echo mysqli_num_rows($cek_request);
                // if(mysqli_num_rows($cek_request)>0){
                //     // echo $q_cek;
                //     $_SESSION['info'] = 'Gagal Disimpan';
                //     $_SESSION['pesan'] = "( pengajuan sudah pernah dibuat ) ";
                //     echo "<script>document.location.href='shift_request.php'</script>";
                // }else{
                //     $query = " INSERT INTO req_absensi (`id`, `npk`, `shift`, `date`, `keterangan`, `requester` , `status`, `req_status`, `req_date`, `shift_req` ) VALUES";
                //     foreach($tanggal AS $date){
                //         $id = $npk.$date;
                //         $query .= " ('$id', '$npk', '$shift_tujuan', '$date', '$ket', '$requester' , '$status', '$req_status', '$req_date', '1'),";
                //     }
                //     $query = substr($query, 0, -1)or die(mysqli_error($link));
                //     $sql = mysqli_query($link, $query);
                //     if($sql){
                //         $_SESSION['info'] = 'Request';
                //         $_SESSION['pesan'] = "( pengajuan perpindahan shift telah diteruskan ) ";
                //         echo "<script>document.location.href='shift_request.php'</script>";
                //         // echo $q_cek;
                //     }else{
                //         $_SESSION['info'] = 'Gagal Disimpan';
                //         $_SESSION['pesan'] = "(".mysqli_error($link).")";
                //         echo "<script>document.location.href='shift_request.php'</script>";
                //     }
                // }
            }
        }
     }else if(isset($_POST['req_SUPEM']) || isset($_POST['req_CUTI']) ){
        $shift_req = 0;
        $query = $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
             VALUES ";
        $npk = $_POST['npk'];
        $shift = $_POST['shift'][0];
        $type = $_POST['code'];
        $alasan = $_POST['note'];
        $i = 0;
        $reqStats = 'a';
        $status = '25';
        $total_tgl = count($_POST['sd']);
        $tot_tgl = sprintf("%07d", $total_tgl);
        $id_image = $npk.dateToDB($_POST['sd'][0]);
        // simpan file upload
        $file_mimes = array('image/jpeg','image/jpg','image/png');
        if(isset($_FILES['attach-upload']['name']) && in_array($_FILES['attach-upload']['type'], $file_mimes)) {
            $ImageName       = $_FILES['attach-upload']['name'];
            $image = $_FILES['attach-upload']['name'];
            $dir = $_FILES['attach-upload']['tmp_name']; //file upload
            // $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/";
            $path = "image_attachment/";
            if (file_exists($path)){
                // compress image
                $namaGambar     = $id_image."_".$tot_tgl."_".$type;
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt); // Extension
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName   = str_replace(' ', '', $namaGambar.'.'.$ImageExt);

                $newPath = $path.$NewImageName; //direktori penyimpanan
                // echo $newPath;
                $source =  $dir;
                // echo $source;
                $imgInfo = getimagesize($source); 
                $mime = $imgInfo['mime'];  
                $quality = 20;
                // membuat image baru
                switch($mime){ 
                // proses kode memilih tipe tipe image 
                    case 'image/jpeg': 
                        $image = imagecreatefromjpeg($source); 
                        break; 
                    case 'image/jpg': 
                        $image = imagecreatefromjpeg($source); 
                        break; 
                    case 'image/png': 
                        $image = imagecreatefrompng($source); 
                        break; 
                    default: 
                        $image = imagecreatefromjpeg($source); 
                }
                imagejpeg($image, $newPath, $quality);
                $imageName = "'".$namaGambar.".$ImageExt"."'";
            }else{
                $imageName = "NULL";
            }
            $image_judge = 1;
        }else{
            $image_judge = 0;
            $imageName = "'NULL'";
        }
        foreach($_POST['sd'] AS $tgl){
            $tgl = dateToDB($tgl);
            $id_absensi = $npk.$tgl;
            $id = $npk.$tgl;
            $ci = (isset($_POST['ci']) && $_POST['ci'][$i] != '')?$_POST['ci'][$i]:'00:00:00';
            $co = (isset($_POST['ci']) &&  $_POST['co'][$i] != '')?$_POST['co'][$i]:'00:00:00';
            $end_date = end_date($tgl,$link,$shift);
            $start_date = $tgl;

            $req_date = date('Y-m-d');
            $query .= "('$id', '$npk' , '$tgl', '$shift', '$start_date', '$end_date' , '$co' , '$ci' , '$type', '$npkUser', '$status', '$reqStats', '$req_date' , '$alasan', '$shift_req', $imageName ),";
            $i++;
        }
        // cek apakah pengajuan butuh lampiran atau tidak
        $cek_attendance_attachement = mysqli_query($link,"SELECT attachment FROM attendance_code WHERE kode = '$type' ")or die(mysqli_error($link));
        $data_attachment = mysqli_fetch_assoc($cek_attendance_attachement);
        $query = substr($query, 0, -1);
        if(isset($data_attachment['attachment']) && $data_attachment['attachment'] == 1 ){
            if($image_judge == 1){
                $sql = mysqli_query($link, $query);
                if($sql){
                    $_SESSION['info'] = 'Disimpan';
                    header('location: req_absensi.php');
                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( ".mysqli_error($link)." )";
                    header('location: req_absensi.php');
                }
            }else{
                $_SESSION['info'] = 'Gagal Disimpan';
                $_SESSION['pesan'] = "( Silakan Ulangi Pengajuan dan Pastikan Lampiran diupload dengan format gambar )";
                header('location: req_absensi.php');
            }
        }else{
            if($image_judge == 0){
                $sql = mysqli_query($link, $query);
                if($sql){
                    // echo "gambar tidak ada untuk pengajuan yang tidak membutuhkan lampiran";
                    $_SESSION['info'] = 'Disimpan';
                    header('location: req_absensi.php');
                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( ".mysqli_error($link)." )";
                    header('location: req_absensi.php');
                }
            }else{
                $_SESSION['info'] = 'Gagal Disimpan';
                $_SESSION['pesan'] = "( pengajuan tidak mebutuhkan lampiran )";
                header('location: req_absensi.php');
            }
        }
    }else if(isset($_POST['req_SUKET'])){
        // echo "SUKET";
        $shift_req = 0;
        
        // echo count($_POST['sd']);
        // echo count($_POST['ci']);
        // echo count($_POST['co']);
        $query = $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
             VALUES ";

        $npk = $_POST['npk'];
        $shift = $_POST['shift'][0];
        $type = $_POST['code'];
        $alasan = $_POST['note'];
        $i = 0;
        $reqStats = 'a';
        $status = '25';
        
        foreach($_POST['sd'] AS $tgl){
            
            $tgl = dateToDB($tgl);
            $id_absensi = $npk.$tgl;
            $id = $npk.$tgl;
            $ci = ($_POST['ci'][$i] != '')?$_POST['ci'][$i]:'00:00:00';
            $co = ($_POST['co'][$i] != '')?$_POST['co'][$i]:'00:00:00';
            $end_date = end_date($tgl,$link,$shift);
            $start_date = $tgl;

            $req_date = date('Y-m-d');
            // $co = $_POST['ci'][$i];
            // echo $shift."-".$npk."-".$type."-".$alasan."-".$tgl."-".$ci."-".$co."-".$start_date."-".$end_date."<br>";
            $query .= "('$id', '$npk' , '$tgl', '$shift', '$start_date', '$end_date' , '$ci' , '$co' , '$type', '$npkUser', '$status', '$reqStats', '$req_date' , '$alasan', '$shift_req', '$id_absensi' ),";
            $i++;
        }
        $query = substr($query, 0, -1);
        // echo $query;
        $sql = mysqli_query($link, $query);
        if($sql){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='req_absensi.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            $_SESSION['pesan'] = mysqli_error($link);
            echo "<script>document.location.href='req_absensi.php'</script>";
        }
    }else if(isset($_GET['delete_multiple'])){
        //proses approve oleh admin
        
        
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                $query_check = mysqli_query($link, "SELECT CONCAT(`status`, `req_status`) AS `stats` FROM req_absensi WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ")or die(mysqli_error($link));
                $sql = mysqli_fetch_assoc($query_check);
                $code = $sql['stats'];

                if($code == ""){
                    
                }else if($code == "25a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "50a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "75a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100a"){
                    // tidak boleh delete
                }else if($code == "100b"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100c"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100d"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100e"){
                    // tidak boleh delete
                }else if($code == "100f"){
                    // tidak boleh delete
                }else{
                    
                }
                return $text;
            }
        }
     }else if(isset($_GET['shift_delete_multiple'])){
        //proses approve oleh admin
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                $query_check = mysqli_query($link, "SELECT CONCAT(`status`, `req_status`) AS `stats` FROM req_absensi WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ")or die(mysqli_error($link));
                $sql = mysqli_fetch_assoc($query_check);
                $code = $sql['stats'];
                // echo $data."<br>";
                if($code == ""){
                    
                }else if($code == "25a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "50a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "75a"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100a"){
                    // tidak boleh delete
                }else if($code == "100b"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100c"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100d"){
                    if(mysqli_num_rows($query_check) > 0){
                        mysqli_query($link, "DELETE FROM req_absensi  WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
                    }
                }else if($code == "100e"){
                    // tidak boleh delete
                }else if($code == "100f"){
                    // tidak boleh delete
                }else{
                    
                }
            }
        }
     }else if(isset($_GET['shift_close_multiple'])){
        //proses approve oleh admin
        $status = '100';
        $req_status = 'a';
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
              list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
     }else if(isset($_GET['at_download'])){
        if(count($_POST['checked']) > 0){
            $filter_id = '';
            $filter_ket = '';
            $filter_req_shift = '';
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                $filter_id .= " view_absen_req.id_absensi = '$id' OR";
                $filter_ket .= " view_absen_req.req_code = '$ket' OR";
                $filter_req_shift .= " view_absen_req.shift_req = '$req_shift' OR";
            }
            
            $filter_id = substr($filter_id, 0, -2);
            $filter_ket = substr($filter_ket, 0, -2);
            $filter_req_shift = substr($filter_req_shift, 0, -2);
            
            $filter_id = ($filter_id == '' )?'':" AND ($filter_id) ";
            $filter_ket = ($filter_ket == '' )?'':" AND ($filter_ket) ";
            $filter_req_shift = ($filter_req_shift == '' )?'':" AND ($filter_req_shift) ";
            
            
            // echo $filter_id;
            


            $year = date('Y');
            

            $level = $level;
            $npk = $npkUser;
            list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
            $origin_query = "SELECT view_absen_req.id_absensi,
                view_absen_req.npk,
                view_absen_req.nama,
                view_absen_req.employee_shift, 
                view_absen_req.grp,
                view_absen_req.dept_account,
                view_absen_req.req_work_date,
                view_absen_req.req_date_in,
                view_absen_req.req_date_out,
                view_absen_req.req_in,
                view_absen_req.req_out,
                view_absen_req.shift_req,
                view_absen_req.att_type,
                view_absen_req.keterangan,
                view_absen_req.note_return,
                view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
                FROM view_absen_req ";
            
            $access_org = orgAccess($level);
            $data_access = generateAccess($link,$level,$npk);
            $table = partAccess($level, "table");
            $field_request = partAccess($level, "field_request");
            $table_field1 = partAccess($level, "table_field1");
            $table_field2 = partAccess($level, "table_field2");
            $part = partAccess($level, "part");
            $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
            // $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
            $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL  AND shift_req = '0' ";

            $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org).$exception.$filter_id.$filter_ket.$filter_req_shift;
            $status = authApprove($level, "status", "approved");
            $req_status = authApprove($level, "request", "approved");

            $sql = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
            

            // file download
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../../file/template/format_absensi.xlsx");
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
            $sheet->setCellValue('AP3', $year);
            $sheet->setCellValue('J7', $namaUser);
            $sheet->setCellValue('J8', $npk);
            $sheet->setCellValue('J9', getOrgName($link, $dept_account, "deptAcc"));
            $sheet->setCellValue('J10', getOrgName($link, $div, "division"));
            $sheet->mergeCells('J8:M8');
            
            if(mysqli_num_rows($sql)>0){
                $i = 1;
                $no = 15;

                while($data = mysqli_fetch_assoc($sql)){
                    $query_group = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                    $group_ = mysqli_fetch_assoc($query_group);
                    $query_deptAcc = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc'  ")or die(mysqli_error($link));
                    $deptAcc = mysqli_fetch_assoc($query_deptAcc);
                    $group = $group_['nama_org'];
                    $dept_acc = $deptAcc['nama_org'];
                    $clr = authColor($data['req_status']);
                    $stt = authText($data['status']);
                    $prs = $data['req_status_absen'];
                    $checkIn = ($data['req_in'] == '00:00:00')? "-" : jam($data['req_in']);
                    $checkOut = ($data['req_out'] == '00:00:00')? "-" : jam($data['req_out']);
                    $note_return = ($data['note_return'] == '')? "" : $data['note_return'];

                    // $sheet->setCellValue('E5', $queryMP);
                    // echo $i."<br>";
                    // echo $year."<br>";
                    // echo $data['npk']."<br>";
                    // echo $data['nama']."<br>";
                    // echo $data['req_work_date']."<br>";
                    // echo $data['req_date_out']."<br>";
                    // echo $checkIn."<br>";
                    // echo $checkOut."<br>";
                    // echo $data['keterangan']."<br>";
                    // echo $data['att_type']."<br>";
                    
                    $sheet->setCellValue('C'.$no, $i);
                    $sheet->setCellValue('E'.$no, $data['npk']);
                    $sheet->setCellValue('G'.$no, $data['nama']);
                    $sheet->setCellValue('O'.$no, $data['req_work_date']);
                    $sheet->setCellValue('T'.$no, $data['req_date_out']);
                    $sheet->setCellValue('Y'.$no, $checkIn);
                    $sheet->setCellValue('AD'.$no, $checkOut);
                    $sheet->setCellValue('AI'.$no, $data['keterangan']);
                    $sheet->setCellValue('AP'.$no, $data['att_type']);
                    

                    $sheet->getStyle('C'.$no.':D'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('E'.$no.':F'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('G'.$no.':N'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('O'.$no.':S'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('T'.$no.':X'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('Y'.$no.':AC'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('AD'.$no.':AH'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('AI'.$no.':AO'.$no)->applyFromArray($styleArray);
                    $sheet->getStyle('AP'.$no.':AT'.$no)->applyFromArray($styleArray);

                    $sheet->mergeCells('G'.$no.':N'.$no);
                    $sheet->mergeCells('E'.$no.':F'.$no);


                    
                    $no++;
                    $i++;
                
                    
                    
                }
            }
            $styleArray1 = array(
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        // 'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            );

            $no1 = $no +1;
            $no2 = $no1 +1;

            $sheet->getStyle('C13:AT'.$no1)->applyFromArray($styleArray1);
            $sheet->getStyle('B2:AU'.$no2)->applyFromArray($styleArray1);


            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = "Pengajuan_".$date.".xlsx";

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);

            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);
            
            unlink($filename);
            exit($content);
            
        }else{
            $_SESSION['info'] = 'Kosong';
            header('location:approval/index.php');
        }
     }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }
    

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }