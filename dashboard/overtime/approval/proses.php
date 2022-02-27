<?php
//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");

if(isset($_SESSION['user'])){
    if($level <= 4){
        $status_approval = 50;
    }else{
        $status_approval = 75;
    }
    if(isset($_GET['del'])){
        $qry = "DELETE FROM lembur
                WHERE _id = '$_GET[del]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Disimpan";
        echo "<script>window.location='index.php';</script>";
    }else if(isset($_GET['approve'])){
        $qry = "UPDATE lembur SET 
                status_approve = '$status_approval' ,
                `status` = 'a'
                WHERE _id = '$_GET[approve]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Approve";
        echo "<script>window.location='index.php';</script>";
    }else if(isset($_GET['reject'])){
        $qry = "UPDATE lembur SET 
                status_approve = '$status_approval' ,
                `status` = 'b'
                WHERE _id = '$_GET[reject]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Reject";
        echo "<script>window.location='index.php';</script>";
    }else if(isset($_GET['return'])){
        $qry = "UPDATE lembur SET 
                status_approve = '$status_approval' ,
                `status` = 'c'
                WHERE _id = '$_GET[return]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Return";
        echo "<script>window.location='index.php';</script>";
    }else if(isset($_GET['pause'])){
        $qry = "UPDATE lembur SET 
                status_approve = '100' ,
                `status` = 'b'
                WHERE _id = '$_GET[pause]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Stop";
        echo "<script>window.location='index.php';</script>";
    }else if(isset($_GET['arsip'])){
        $qry = "UPDATE lembur SET 
                status_approve = '100' ,
                `status` = 'c'
                WHERE _id = '$_GET[arsip]' ";

        mysqli_query($link, $qry)or die(mysqli_error($link));
        $_SESSION['info'] = "Arsipkan";
        echo "<script>window.location='index.php';</script>";
    }else{
        $_SESSION['info'] = "Kosong";
        echo "<script>window.location='index.php';</script>";
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}