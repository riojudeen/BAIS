<?php
require_once("../../../../config/config.php"); 
// $_POST['idLine'] = '';
// $_POST['idModel'] = '1';
// $_POST['namaModel'] = 'XENIA-AVANZA tes';
// $_POST['statsModel'] = 'active';
// $_POST['aliasModel'] = 'D12L';
if(isset($_SESSION['user'])){
    if(isset($_POST['updatePosArea'])){
        $q_addPos = "INSERT INTO pos (`id_post`, `nama`,`npk_cord`, `id_pos_leader`,`id_prod_area`,`part`,`employee_type`) VALUES ";
        // $q_addOrg = "UPDATE org (`sub_post`) VALUES ";
        $total = $_POST['totalData'];
        echo $total;
        for($i=1;$i <= $total;$i++){
            $npk = $_POST["inputDataNpk-$i"];
            $nama_pos = $_POST['inputDataPos-'.$i];
            $id_group = $_POST['inputDataGroup-'.$i];
            $id_pos_leader = $_POST['inputDataPosLeader-'.$i];
            $id_labor = $_POST['inputDataLabor-'.$i];
            $id_Area = $_POST['inputDataArea-'.$i];
            $id = idIncrement($link, 'pos','id_post')+($i-1);
            $q_addPos .= " ('$id', '$nama_pos','$npk','$id_pos_leader','$id_Area','subpos','$id_labor'),";
            mysqli_query($link, "UPDATE org SET `sub_post` = '$id' WHERE npk = '$npk'")or die(mysqli_error($link));
        }
        $sql = substr($q_addPos, 0 , -1); //untuk trim koma terakhir
        // echo $sql;
        mysqli_query($link,$sql)or die(mysqli_error($link));
        // echo "berhasil";
    }else{
        echo "gagal";
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
    }
?>