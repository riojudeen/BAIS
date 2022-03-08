<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
require_once("../../../../config/approval_system.php");
if(isset($_SESSION['user'])){

    if(isset($_GET['delpos'])){
        $del = mysqli_query($link, "DELETE FROM pos_leader WHERE id_post = '$_GET[delpos]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "pos";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "pos";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_GET['deldivision'])){
        $del = mysqli_query($link, "DELETE FROM division WHERE id_div = '$_GET[deldivision]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "division";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "division";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_GET['deldept'])){
        $del = mysqli_query($link, "DELETE FROM department WHERE id_dept = '$_GET[deldept]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "dept";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "dept";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_GET['deldeptacc'])){
        $del = mysqli_query($link, "DELETE FROM dept_account WHERE id_dept_account = '$_GET[deldeptacc]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "deptacc";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "deptacc";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_GET['delsection'])){
        $del = mysqli_query($link, "DELETE FROM section WHERE id_section = '$_GET[delsection]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "section";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "section";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_GET['delgroup'])){
        $del = mysqli_query($link, "DELETE FROM groupfrm WHERE id_group = '$_GET[delgroup]' ")or die(mysqli_error($Link));
        if($del){
            $_SESSION['info'] = "Dihapus";
            $_SESSION['tab'] = "group";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }else{
            $_SESSION['info'] = "Gagal Dihapus";
            $_SESSION['tab'] = "group";
            echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
        }
        
    }else if(isset($_POST['id_area_posting'])){

        $part_area =  $_POST['part_area_posting'];
        $id_area = $_POST['id_area_posting'];
        list($pos,$group,$section,$dept,$division,$plant,$dept_account)=strukturOrg($link, $part_area, $id_area);
        if($_POST['part_area_posting'] == 'pos'){
            $query = "UPDATE  org SET `post` = '$pos' ,`grp` = '$group',`sect` = '$section' ,`dept` = '$dept',`division` = '$division'";
        }else if($_POST['part_area_posting'] == 'group'){
            $query = "UPDATE  org SET `grp` = '$group',`sect` = '$section' ,`dept` = '$dept',`division` = '$division'";
        }else if($_POST['part_area_posting'] == 'section'){
            $query = "UPDATE  org SET `sect` = '$section' ,`dept` = '$dept',`division` = '$division'";
        }else if($_POST['part_area_posting'] == 'dept'){
            $query = "UPDATE  org SET `dept` = '$dept',`division` = '$division'";
        }else if($_POST['part_area_posting'] == 'division'){
            $query = "UPDATE  org SET `division` = '$division'";
        }else if($_POST['part_area_posting'] == 'deptacc'){
            $query = "UPDATE  org SET `dept_account` = '$id_area'";
        }
        // print_r($_POST['checked']);
        $no = 1;
        if(isset($_POST['checked'])){
            foreach($_POST['checked'] AS $npk ){
                $query_update = $query." WHERE npk = '$npk' ";
                // echo $query_update." - $no<br>";
                $no++;
                $sql = mysqli_query($link, $query_update);
            }
            if($sql){
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='../data-update.php?id=$id_area&part=$part_area';</script>";
            }else{
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='../data-update.php?id=$id_area&part=$part_area';</script>";
            }
        }else{
            $_SESSION['info'] = "Kosong";
            header("location:../data-update.php?id=$id_area&part=$part_area");
        }
    }else{
        $_SESSION['info'] = "Kosong";
        $_SESSION['tab'] = "division";
        echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
    }


} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}  

?>