<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    
    $total = 0;
    if(isset($_POST['pos'])){
        foreach($_POST['pos'] AS $pos){
            $_SESSION['tab'] = "pos";
            $qry = "DELETE FROM `pos_leader` WHERE `id_post` = '$pos' ";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    if(isset($_POST['group'])){
        foreach($_POST['group'] AS $group){
            $_SESSION['tab'] = "group";
            $qry = "DELETE FROM `groupfrm` WHERE `id_group` = '$group' ";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    if(isset($_POST['section'])){
        $_SESSION['tab'] = "section";
        foreach($_POST['section'] AS $section){
            $qry = "DELETE FROM `section` WHERE `id_section`= '$section' ";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    if(isset($_POST['dept'])){
        $_SESSION['tab'] = "dept";
        foreach($_POST['dept'] AS $dept){
            $qry = "DELETE FROM `department` WHERE `id_dept` = '$dept' ";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    if(isset($_POST['deptacc'])){
        $_SESSION['tab'] = "deptacc";
        foreach($_POST['deptacc'] AS $deptAcc){
            $qry = "DELETE FROM `dept_account` WHERE `id_dept_account` = '$deptAcc' ";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    if(isset($_POST['division'])){
        $_SESSION['tab'] = "division";
        foreach($_POST['division'] AS $division){
            $qry = "DELETE FROM `division` WHERE `id_div` = '$division'";
            $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
        }
    }
    // echo $qry;
    if($sql){
        
        $_SESSION['info'] = "Dihapus";
        echo "<script>window.location='../index.php';</script>";
    
    }else{
        $_SESSION['info'] = "Gagal Hapus";
        echo "<script>window.location='../index.php';</script>";
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

