<?php

require_once("../../../config/config.php");
if(isset($_POST['mpchecked'])){
    $i = 0;
    $index = 0;
    // echo mysqli_num_rows($qry);
    
    foreach($_POST['mpchecked'] AS $data){
        $prod = $_POST['prod'];
        $dept = $_POST['dept'];
        $prodarea = $_POST['prodarea'];
        $tgl = dateToDB($_POST['tanggal']);
        
        $nama = $_POST['nama-'.$data][0];
        $mulai= $_POST['mulai-'.$data][0];
        $npk = $_POST['npk-'.$data][0];
        $selesai= $_POST['selesai-'.$data][0];
        $menit = $_POST['menit-'.$data][0];
        $jalur = $_POST['jalur-'.$data][0];
        
        $area = $_POST['jalur-'.$data][0];
        $shift = $_POST['shift-'.$data][0];
        $kode = $_POST['kode-'.$data][0];
        $id_prodarea = $_POST['id_jalur-'.$data][0];
        $cost_type = $_POST['ot_cost-'.$data][0];

        $qry_rate = mysqli_query($link, "SELECT * FROM ot_rate WHERE id_dept = '$dept' ")or die(mysqli_error($link));
        $sql_rate = mysqli_fetch_assoc($qry_rate);
        $ot_rate = $sql_rate['ot_rate'];

        // $qry = mysqli_query($link, "SELECT * FROM unit_prodarea WHERE id = '$id_jalur' ")or die(mysqli_error($link));
        
        
        // if(mysqli_num_rows($qry) > 0 ){
            
            // $db = mysqli_fetch_assoc($qry);
            $arrayJalur[$index++] = [
                'kode' => $kode,
                'jalur' => $jalur,
                'menit' => $menit,
                'id_prodarea' => $prodarea,
                'ot_rate' => $ot_rate,
                'cost_type' => $cost_type
            ];
        // };
        $i++;
        
    }
    $total = count($arrayJalur);
    $maxID = mysqli_query($link, "SELECT max(`id`) AS `id` FROM ot_cost")or die(mysqli_error($link));
    $max = mysqli_fetch_assoc($maxID);
    // echo $max['id'];
    $id = $max['id'];
    $qryDB = "INSERT INTO ot_cost (`id`,`date`,`id_prodarea`,`ot_code`,`overtime`,`ot_cost`,`cost`) VALUES";
    $indexArea = 0;
    // var_dump($arrayJalur);
    // echo "<br>".$total;
    
    foreach($arrayJalur as $dt => $key){
        $id++;
        $qryDB .= "('$id','$tgl','$key[id_prodarea]','$key[kode]','$key[menit]','$key[ot_rate]','$key[cost_type]'),";
        
    }
    $qry = substr($qryDB, 0, -1);
    // echo $qry;
    $sql = mysqli_query($link,$qry)or die(mysqli_error($link));
    if($sql){
        $_SESSION['info'] = "Disimpan";
        unset($_SESSION['pesan']);
        $_SESSION['pesan'] = "$total";
        header("Location: index.php"); 
    }else{
        $_SESSION['info'] = "Gagal Disimpan";
        unset($_SESSION['pesan']);
        $_SESSION['pesan'] = "$total";
        header("Location: index.php"); 
    }
    
    
        
    
    // echo $arrayJalur[0]['menit'];
    // echo count($arrayJalur);


    
}else{
    echo "<script>window.location='".base_url('../index.php')."';</script>";
}
?>