<?php
require_once("../../../config/config.php");
require_once("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['editWd'])){
        // echo "tes";
        $edit = mysqli_query($link,"UPDATE working_days SET shift = '$_POST[shift]', wh = '$_POST[wh]', ket= '$_POST[operational]', break_id = '$_POST[wb]' WHERE id = '$_POST[id]' ")or die(mysqli_error($link));
        // echo $_POST['operational'];
        if($edit){
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../index.php#b'</script>";
        }
    }else if(isset($_POST['addWd'])){
        if(isset($_POST['index'])){
            $query = "REPLACE working_days (`id`, `date`, `wh`, `shift`, `ket`, `break_id`) VALUES";
            $id = idIncrement($link, "working_days", "id");
            for($i=1; $i <= count($_POST['index']); $i++){
                $idWd = $id+$i;
                $wb = trim(mysqli_real_escape_string($link, $_POST['wb'.$i]));
                $wh = trim(mysqli_real_escape_string($link, $_POST['wh'.$i]));
                $date = dateToDB(trim(mysqli_real_escape_string($link, $_POST['date'.$i])));
                $shift = trim(mysqli_real_escape_string($link, $_POST['shift'.$i]));
                $operational = trim(mysqli_real_escape_string($link, $_POST['opreationalType'.$i]));
                $query .= " ('$idWd','$date','$wh','$shift','$operational','$wb'),";
            }
            $sql = substr($query, 0 , -1); //menghilangkan koma terakhir menggunakan substr
            echo $sql;
            $add = mysqli_query($link, $sql);
            if($add){
                $_SESSION['info'] = 'Disimpan';
                echo "<script>document.location.href='../index.php?tab=wd'</script>";
            }else{
                $_SESSION['info'] = 'Gagal Disimpan';
                echo "<script>document.location.href='../index.php?tab=wd'</script>";
            }
        }
    }else if(isset($_POST['generate'])){
        $hari = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
        
        
        $start = $_POST['start_date'];
        $end = $_POST['end_date'];
        $shift_start = $_POST['shift_start'];
        $start_day = $_POST['start_day'];
        $skema = $_POST['skema'];
        $shift = $_POST['group_shift'];
        
        $tgl_mulai = $start;
        $tgl_selesai = $end;

        $query_productionShift = mysqli_query($link, "SELECT production FROM shift WHERE id_shift = '$shift'  ")or die(mysqli_error($link));
        $cek_prod_shift = mysqli_fetch_assoc($query_productionShift);
        $data_cek = $cek_prod_shift['production'];
        if( $data_cek > 0 ){
            if($shift_start == "DAY"){
                $arrayShifting = array('DAY','NIGHT');
            }else if($shift_start == "NIGHT"){
                $arrayShifting = array('NIGHT','DAY');
            }else{
                $arrayShifting = array('DAY','DAY');
            }
        }else{
            $arrayShifting = array('DAY','DAY');
        }
        // echo $data_cek;

        $arrayLiburan = array();
        $tanggal = json_decode(workingDays($tgl_mulai, $tgl_selesai, $arrayShifting, $skemaShift, $shift));
        // print_r($tanggal)."<br>";
        foreach($_POST['holiday'] AS $data){
            // echo $data."<br>";
        }
        if(isset($_POST['holiday'])){
            foreach($_POST['holiday'] AS $libur){
                // echo $libur;
                foreach($tanggal as $array => $value){
                    if(hari($value['0']) == $libur ){
                        array_push($arrayLiburan, $value[0]);
                        // echo hari($value['0'])." $libur $value[0] <br>";
                    }
                }
            }
        }
        // echo $end;
        $query_hariLibur = mysqli_query($link, "SELECT `date` FROM holidays WHERE `date` BETWEEN '$start' AND '$end' ")or die(mysqli_error($link));
        while($dataLibur = mysqli_fetch_assoc($query_hariLibur)){
            array_push($arrayLiburan, $dataLibur['date']);
            // echo $dataLibur['date'];
        }
        
       

        // $default_holiday = array('Senin','Selasa');

        $skemaShift = 7;
        // print_r($arrayLiburan);
        //
        $array = json_decode(workingDays($tgl_mulai, $tgl_selesai, $arrayShifting, $skemaShift, $shift));
        // print_r($array);
        $queryWD = "INSERT INTO working_days (`id`,`date`,`wh`,`shift`,`ket`,`break_id`) VALUES ";
        
        foreach($array as $array => $value){
            
            $hari = hari($value[0]);
            $shifting = $value[1];
            $working_break = $_POST["wb_".$hari."_".$shifting];
            $working_hours = $_POST["wh_".$hari."_".$shifting];
            $date = $value[0]; //id 1
            // echo $tanggal."<br>";
            $shifting = $value[1]; 
            // echo $shifting;
            $shift = $value[2]; //id 2
            // echo $shift;
            $op = (array_search($date, $arrayLiburan) > 0 )?"HOP":"DOP";
            // echo $op."-".$shifting."<br>";
            $queryWD .= " ('$date/$shift', '$date', '$working_hours', '$shift', '$op', '$working_break' ) ,";
            
        }
        $query = substr($queryWD , 0, -1);
        // echo $query;
        $delete = mysqli_query($link, "DELETE FROM working_days WHERE `date` BETWEEN '$start' AND '$end' AND shift = '$shift' ")or die(mysqli_error($link));
        if($delete){
            $sql_update = mysqli_query($link, $query)or die(mysqli_error($link));
            if($sql_update){
                $_SESSION['info'] = 'Disimpan';
                echo "<script>document.location.href='../index.php?tab=wd'</script>";
            }else{
                $_SESSION['info'] = 'Gagal Disimpan';
                echo "<script>document.location.href='../index.php?tab=wd'</script>";
            }
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
                echo "<script>document.location.href='../index.php?tab=wd'</script>";
        }

    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>