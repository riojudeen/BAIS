<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
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
        
    }else if($_POST['id_area_posting']){
        echo "SUKSES";
    }else{
        $_SESSION['info'] = "Kosong";
        $_SESSION['tab'] = "division";
        echo "<script>window.location='".base_url('dashboard/setting/organization')."';</script>";
    }


} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}  

?>