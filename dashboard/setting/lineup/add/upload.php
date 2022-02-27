<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $alias = $_POST['alias'];
    echo $_FILES['upload_img']['tmp_name'];
    $file = $_FILES['upload_img']['tmp_name'];
    $temp = '../../../../assets/img/unit_model/';
    if(!file_exists($temp)){
        mkdir($temp);
    }
    // $alias = "Dts";
    $ImageName = $_FILES['upload_img']['name'];
    $ImageType       = $_FILES['upload_img']['type'];
    $ImageSize       = $_FILES['upload_img']['size'];
    $ImageRatio      = getimagesize($_FILES['upload_img']['tmp_name']);
    $width =  $ImageRatio[0];
    $height =  $ImageRatio[1];
    // echo $height;
    // print_r( $ImageRatio);
    if (!empty($file)){
        if($width == '513' && $height == '514'){

        }
        $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt); // Extension
        $NewImageName = str_replace(' ', '', $alias.'.'.$ImageExt);
        move_uploaded_file($_FILES["upload_img"]["tmp_name"], $temp.$NewImageName); // Menyimpan file
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
    }
?>