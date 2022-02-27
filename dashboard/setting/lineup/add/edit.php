<?php
require_once("../../../../config/config.php"); 
// $_POST['idLine'] = '';
// $_POST['idModel'] = '1';
// $_POST['namaModel'] = 'XENIA-AVANZA tes';
// $_POST['statsModel'] = 'active';
// $_POST['aliasModel'] = 'D12L';
if(isset($_SESSION['user'])){
    if(isset($_POST['idModel'])){
        $id = $_POST['idModel'];
        $nama = $_POST['namaModel'];
        $alias = $_POST['aliasModel'];
        $stats = $_POST['statsModel'];
        // echo $nama;
        $q_data = mysqli_query($link, "SELECT * FROM production_model WHERE id_model = '$id' ")or die(mysqli_error($link));
        $s_data = mysqli_fetch_assoc($q_data);
        $dataLama = $s_data['alias'].".png";
        $temp = '../../../../assets/img/unit_model/';

        if($_POST['control-edit'] == '2'){
            // menghapus gambar lama
            if(file_exists($dataLama)){
                unlink($temp.$dataLama);
            }
            $file = $_FILES['upload_gambar']['tmp_name'];
            // $alias = "Dts";
            $ImageName = $_FILES['upload_gambar']['name'];
            $ImageType       = $_FILES['upload_gambar']['type'];
            $ImageSize       = $_FILES['upload_gambar']['size'];
            $ImageRatio      = getimagesize($_FILES['upload_gambar']['tmp_name']);
            $width =  $ImageRatio[0];
            $height =  $ImageRatio[1];

            if (!empty($file)){
                // validasi ukuran gambar
                if($width == '513' && $height == '514'){
        
                }
                // insert image ke folder
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt); // Extension
                $NewImageName = str_replace(' ', '', $alias.'.'.$ImageExt);
                move_uploaded_file($_FILES["upload_img"]["tmp_name"], $temp.$NewImageName); // Menyimpan file
            }
        }else{
            $namaBaru = $temp.$alias.".png";
            $namaLama = $temp.$dataLama;
            rename($namaLama,$namaBaru);
        }
        mysqli_query($link, "UPDATE production_model SET `name` = '$nama', alias = '$alias', stats = '$stats' WHERE id_model = '$id'")or die(mysqli_error($link));
        
        
    }else if(isset($_POST['idLine'])){
        $model = $_POST['namaModel'] ;
        $dept = $_POST['namaDeptAcc'] ;
        $id = $_POST['idLine'];
        $line = $_POST['namaLine'];
        $_SESSION['tes'] = $model;
        // echo $_SESSION['tes'];
        mysqli_query($link, "UPDATE production_line SET `nama` = '$line', id_dept_account = '$dept', id_model = '$model' WHERE id_line = '$id'")or die(mysqli_error($link));
    }else if(isset($_POST['idArea'])){
        $id = $_POST['idArea'];
        $nama = $_POST['namaArea'];
        $group = $_POST['areaGroup'];
        $shift = $_POST['areaShift'];
        $type = $_POST['areaType'];
        $line = $_POST['areaLine'];
        mysqli_query($link, "UPDATE production_area SET `name` = '$nama', id_groupfrm = '$group', id_type = '$type', id_shift = '$shift', id_line = '$line' WHERE id_area = '$id'")or die(mysqli_error($link));
    }else if(isset($_POST['idPosMP'])){
        $id = $_POST['idPosMP'];
        $nama = $_POST['namaMP'];
        $pos = $_POST['posMP'];
        $npk = $_POST['npkMP'];
        $group = $_POST['groupMP'];
        $team= $_POST['teamMP'];
        $area = $_POST['areaMP'];
        mysqli_query($link, "UPDATE pos SET `nama` = '$pos' WHERE id_post = '$id'")or die(mysqli_error($link));
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
    }
?>