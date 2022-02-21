<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    // $_GET['return'] = '44131';
    $maxId = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id) AS 'id' FROM req_absensi")) or die(mysqli_error($link));
    if(isset($_POST['add'])){
        
        if($_POST['tipe'] == 'SUPEM'){
            // echo "tes";
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
            // echo $date."<br>";
            // echo $id."<br>";
            // echo $checkIn."<br>";
            // echo $checkOut."<br>";
            // echo $requester."<br>";
            // echo $date."<br>";
            // echo $npk_."<br>";
            
            // echo $status."<br>";
            // echo $reqStats."<br>";
            // echo $req_date."<br>";

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
               mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket' ");
           }
       }
    }else if(isset($_GET['return_multiple'])){
        //proses retunr oleh admin
        $status = authApprove($level, "status", "return");
        $req_status = authApprove($level, "request", "return");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
    }else if(isset($_GET['stop_multiple'])){
        //proses reject / stop  oleh admin
        $status = authApprove($level, "status", "stop");
        $req_status = authApprove($level, "request", "stop");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
    }else if(isset($_GET['proses_multiple'])){
        //proses approve oleh admin
        $status = authApprove($level, "status", "proses");
        $req_status = authApprove($level, "request", "proses");
        if(count($_POST['checked']) > 0){
            foreach($_POST['checked'] AS $data){
                list($id, $ket, $req_shift) = pecahID($data);
                mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
            }
        }
        
    }else if(isset($_GET['reject_multiple'])){
       //proses approve oleh admin
       $status = authApprove($level, "status", "rejected");
       $req_status = authApprove($level, "request", "rejected");
       if(count($_POST['checked']) > 0){
           foreach($_POST['checked'] AS $data){
             list($id, $ket, $req_shift) = pecahID($data);
               mysqli_query($link, "UPDATE req_absensi SET `status` = '$status' , req_status = '$req_status' WHERE id = '$id' AND shift_req = '$req_shift' AND keterangan = '$ket'  ");
           }
       }
    }else if(isset($_POST['req_SUPEM'])){
        echo "SUPEM";
        count($_POST['sd']);
        // echo "SUKET";
        $shift_req = 0;
        
        // echo count($_POST['sd']);
        // echo count($_POST['ci']);
        // echo count($_POST['co']);
        $query = $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
             VALUES ";

        $npk = $_POST['npk'];
        $shift = $_POST['shift'][0];
        $type = $_POST['tipe'];
        $alasan = $_POST['note'];
        $i = 0;
        $reqStats = 'a';
        $status = '25';
        
        foreach($_POST['sd'] AS $tgl){
            
            $tgl = dateToDB($tgl);
            $id_absensi = $npk.$tgl;
            $id = $npk.$tgl;
            $ci = (isset($_POST['ci']) && $_POST['ci'][$i] != '')?$_POST['ci'][$i]:'00:00:00';
            $co = (isset($_POST['ci']) &&  $_POST['co'][$i] != '')?$_POST['co'][$i]:'00:00:00';
            $end_date = end_date($tgl,$link,$shift);
            $start_date = $tgl;

            $req_date = date('Y-m-d');
            // $co = $_POST['ci'][$i];
            // echo $shift."-".$npk."-".$type."-".$alasan."-".$tgl."-".$ci."-".$co."-".$start_date."-".$end_date."<br>";
            $query .= "('$id', '$npk' , '$tgl', '$shift', '$start_date', '$end_date' , '$co' , '$ci' , '$type', '$npkUser', '$status', '$reqStats', '$req_date' , '$alasan', '$shift_req', '$id_absensi' ),";
            $i++;
        }
        $query = substr($query, 0, -1);
        echo $query;
        // $sql = mysqli_query($link, $query);
        // if($sql){
        //     $_SESSION['info'] = 'Disimpan';
        //     echo "<script>document.location.href='req_absensi.php'</script>";
        // }else{
        //     $_SESSION['info'] = 'Gagal Disimpan';
        //     $_SESSION['pesan'] = "( ".mysqli_error($link)." )";
        //     echo "<script>document.location.href='req_absensi.php'</script>";
        // }


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
        $type = $_POST['tipe'];
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
            $query .= "('$id', '$npk' , '$tgl', '$shift', '$start_date', '$end_date' , '$co' , '$ci' , '$type', '$npkUser', '$status', '$reqStats', '$req_date' , '$alasan', '$shift_req', '$id_absensi' ),";
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
     }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='req_absensi.php'</script>";
    }
    

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }