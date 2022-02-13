<?php
include("../../config/config.php"); 
// require("../../_assets/vendor/autoload.php"); 
// use Ramsey\Uuid\Uuid;

if(isset($_SESSION['user'])){
    if(isset($_POST['add'])){
        if(isset($_POST['npk'])){
            $kode = $_SESSION['kode-lembur'];
            // $uuid = Uuid::uuid4();
            $total = count($_POST['npk']);

            $requester = trim(mysqli_real_escape_string($link, $_POST['requester']));//ok
            $start_date = dateToDB(trim(mysqli_real_escape_string($link, $_POST['tanggalmulai'])));//ok
            $end_date = dateToDB(trim(mysqli_real_escape_string($link, $_POST['tanggalselesai'])));//ok
            $s_time = trim(mysqli_real_escape_string($link, $_POST['waktumulai']));//ok
            $e_time = trim(mysqli_real_escape_string($link, $_POST['waktuselesai']));//ok
            $start_time = $s_time;
            $end_time = $e_time;
            $jobcode = trim(mysqli_real_escape_string($link, $_POST['jobcode']));//ok
            $activity = trim(mysqli_real_escape_string($link, $_POST['activity']));//ok
            $date = dateToDB(trim(mysqli_real_escape_string($link, $_POST['work_date'])));//ok
            
            
            for($i=0; $i<$total ; $i++){
                // $id_lembur[$i] = $uuid = Uuid::uuid4();
                
                $npk = trim(mysqli_real_escape_string($link, $_POST['npk'][$i]));//ok
                
                //status untuk identifikasi draft
                $id = $npk.$start_date;
                $status_app = 0;
                $status = "a"; //pending
                
                // $status = "b"; //ditolak
                // $status = "c"; //null
                /* status untuk identifikasi pengajuan
                $status_app = 25; 
                $status = "a"; //approve
                $status = "b"; //pending
                $status = "c"; //dihapus
                status untuk identifikasi approval
                $status_app = 50; 
                $status = "a"; //proses
                $status = "b"; //pending
                $status = "c"; //dihapus
                status untuk identifikasi in admin process
                $status_app = 75; 
                $status = "a"; //proses
                $status = "b"; //pending
                $status = "c"; //dihapus
                status untuk identifikasi success
                $status_app = 100; 
                $status = "a"; //proses
                $status = "b"; //pending
                $status = "c"; //dihapus
                */
                // echo $id."<br />";
                // echo $total." data<br />";
                // echo $kode."<br />";
                // echo $requester."<br />";
                // echo $start_date."<br />";
                // echo $end_date."<br />";
                // echo $start_time."<br />";
                // echo $end_time."<br />";
                // echo $npk."<br />";
                // echo $jobcode."<br />";
                // echo $activity."<br />";
                // echo $status_app."<br />";
                // echo $status."<br />";
                
                $add = mysqli_query($link, "INSERT INTO lembur (_id , kode_lembur, requester, npk, work_date, in_date, out_date, in_lembur, out_lembur, kode_job , aktifitas, status_approve, `status`) 
                VALUES ('$id' , '$kode' , '$requester' , '$npk' ,'$date', '$start_date' , '$end_date' , '$start_time' , '$end_time' , '$jobcode' , '$activity' , '$status_app' , '$status')")or die(mysqli_error($link));
                
            }
            if($add){
                // echo "berhasil";
                $_SESSION['pesan'] = "$total data berhasil direcord";
                echo "<script>window.location='req_lembur.php'</script>";
            }else{
                // echo "gagal";
                $_SESSION['pesan'] = "$total data berhasil direcord";
                echo "<script>window.location='req_lembur.php'</script>";
            }
        }else{
            $_SESSION['info'] = "Kosong";
            echo "<script>window.location='req_lembur.php'</script>";
        }
        
        
 
    }else if(isset($_POST['save'])){
        //jika data input hanya disave
        $kode = $_SESSION['kode-lembur'];
        for($i = 0; $i < count($_POST['npk']) ; $i++){

        
            $start_date = (trim(mysqli_real_escape_string($link, $_POST['date_in'][$i])));//ok
            $end_date = (trim(mysqli_real_escape_string($link, $_POST['date_out'][$i])));//ok
            $s_time = trim(mysqli_real_escape_string($link, $_POST['mulai'][$i]));//ok
            $e_time = trim(mysqli_real_escape_string($link, $_POST['selesai'][$i]));//ok
            $start_time = $s_time;
            $end_time = $e_time;
            $npk = trim(mysqli_real_escape_string($link, $_POST['npk'][$i]));//ok
            $jobcode = trim(mysqli_real_escape_string($link, $_POST['jobcode'][$i]));//ok
            $activity = trim(mysqli_real_escape_string($link, $_POST['activity'][$i]));//ok
            //status untuk identifikasi draft
            $id = trim(mysqli_real_escape_string($link, $_POST['id'][$i]));//ok
            $requester = trim(mysqli_real_escape_string($link, $_POST['requester'][$i]));//ok
            $status_app = 0;
            $status = "a"; //pending
            // $qry = "UPDATE lembur SET 
            // in_lembur = '$s_time', 
            // out_lembur = '$e_time', 
            // kode_job = '$jobcode' , 
            // aktifitas = '$activity'
            // WHERE _id = '$id' ";
            // echo  $qry;
            // echo "save";
            $save = mysqli_query($link,"UPDATE lembur SET 
            in_lembur = '$s_time', 
            out_lembur = '$e_time', 
            kode_job = '$jobcode' , 
            aktifitas = '$activity'
            WHERE _id = '$id' ")or die(mysqli_error($link));
        }
        if($save){
            // echo "berhasil";
            $_SESSION['info'] = 'Disimpan';
            echo "<script>window.location='index.php'</script>";
        }else{
            // echo "gagal";
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>window.location='index.php'</script>";
        }
        
    }else if(isset($_POST['request'])){
        //jika data input hanya disave
        $kode = $_SESSION['kode-lembur'];
        if(isset($_POST['npk'])){
            for($i = 0; $i < count($_POST['npk']) ; $i++){
                $start_date = (trim(mysqli_real_escape_string($link, $_POST['date_in'][$i])));//ok
                $end_date = (trim(mysqli_real_escape_string($link, $_POST['date_out'][$i])));//ok
                $s_time = trim(mysqli_real_escape_string($link, $_POST['mulai'][$i]));//ok
                $e_time = trim(mysqli_real_escape_string($link, $_POST['selesai'][$i]));//ok
                $start_time = $s_time;
                $end_time = $e_time;
                $npk = trim(mysqli_real_escape_string($link, $_POST['npk'][$i]));//ok
                $jobcode = trim(mysqli_real_escape_string($link, $_POST['jobcode'][$i]));//ok
                $activity = trim(mysqli_real_escape_string($link, $_POST['activity'][$i]));//ok
                //status untuk identifikasi draft
                $id = trim(mysqli_real_escape_string($link, $_POST['id'][$i]));//ok
                $requester = trim(mysqli_real_escape_string($link, $_POST['requester'][$i]));//ok
                $status_app = 25;
                $status = "a"; //pending
                $qry = "UPDATE lembur SET 
                in_lembur = '$s_time', 
                out_lembur = '$e_time', 
                kode_job = '$jobcode' , 
                aktifitas = '$activity',
                aktifitas = '$activity',
                status_approve = '$status_app' , 
                `status` = '$status'
                WHERE _id = '$id' ";
                // echo  $qry;
                // echo "request";
                $request = mysqli_query($link, $qry)or die(mysqli_error($link));
            }
            if($request){
                // echo "berhasil";
                $_SESSION['info'] = 'Disimpan';
                echo "<script>window.location='index.php'</script>";
            }else{
                // echo "gagal";
                $_SESSION['info'] = 'Gagal Disimpan';
                echo "<script>window.location='index.php'</script>";
            }
        }else{
            $_SESSION['info'] = 'Kosong';
            echo "<script>window.location='index.php'</script>";
        }
        
    }else if(isset($_GET['del'])){
        //jika data input siap diajukan untuk approval
        mysqli_query($link, "DELETE FROM lembur WHERE _id = '$_GET[del]'");
        echo "<script>window.location='req_lembur.php'</script>";
    }else if(isset($_POST['req'])){
        if(isset($_POST['mpchecked'])){
            $i = 0;
            $total = count($_POST['mpchecked']);
            foreach($_POST['mpchecked'] AS $id){
                $qry = "UPDATE lembur SET 
                status_approve = '25' ,
                `status` = 'a'
                WHERE _id = '$id' ";
                // echo  $qry;
                // echo "request";
                mysqli_query($link, $qry)or die(mysqli_error($link));
                $i++;
            }
            
            $_SESSION['pesan'] = $total;
            $_SESSION['info'] = 'Request';
            echo "<script>window.location='index.php'</script>";
        }else{
            
            $_SESSION['info'] = 'Kosong';
            echo "<script>window.location='index.php'</script>";
        }
        
       
        
    }else if(isset($_POST['delete'])){
        if(isset($_POST['mpchecked'])){
            $i = 0;
            $total = count($_POST['mpchecked']);
            foreach($_POST['mpchecked'] AS $id){
                $qry = "DELETE FROM lembur 
                WHERE _id = '$id' ";
                // echo  $qry;
                // echo "request";
                mysqli_query($link, $qry)or die(mysqli_error($link));
                $i++;
            }
            
            $_SESSION['pesan'] = $total;
            $_SESSION['info'] = 'Dihapus';
            echo "<script>window.location='index.php'</script>";
        }else{
            
            $_SESSION['info'] = 'Kosong';
            echo "<script>window.location='index.php'</script>";
        }
                    
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>window.location='index.php'</script>";
    }

}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}