<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    // add
    if(isset($_POST['add'])){
        if($level > 5){
            $url="../index.php";
        }else{
            $url=base_url()."/dashboard/pages/mp_update.php";
        }
        // if(isset($_POST['area_org']))
        $qry_pos = "INSERT INTO `pos_leader`(`id_post`, `nama_pos`, `npk_cord`, `id_group`, `part`) VALUES ";
        $qry_grp = "INSERT INTO `groupfrm`(`id_group`, `nama_group`, `npk_cord`, `id_section`, `part`) VALUES ";
        $qry_sct = "INSERT INTO `section`(`id_section`, `section`, `npk_cord`, `id_dept`, `part`) VALUES ";
        $qry_dpt = "INSERT INTO `department`(`id_dept`, `dept`, `npk_cord`, `id_div`, `part`) VALUES ";
        $qry_dptacc = "INSERT INTO `dept_account`(`id_dept_account`, `department_account`, `npk_dept`, `id_div`, `part`) VALUES ";
        $qry_div = "INSERT INTO `division`(`id_div`, `nama_divisi`, `npk_cord`, `id_company`, `part`) VALUES ";
        // echo "OK";
        if(isset($_POST['kode_pos'])){
            
            $qry_code = mysqli_query($link, "SELECT max(SUBSTRING(`id_post`, -3)) AS pos FROM pos_leader")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);

            for($i=0 ; $i < count($_POST['kode_pos']);$i++){
                // echo $i;
                $nama = $_POST['nama_pos'][$i];
                $cord = $_POST['cord_pos'][$i];
                $id_parent = $_POST['parentpos'][$i];
                $part = "pos";
                // echo $nama;
                $urutan = (int) $d['pos'] + ($i+1);
                // echo $urutan."<br>";
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;
                $qry_pos .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";
            }
            $qry_pos = substr($qry_pos, 0, -1);
            $sql = mysqli_query($link, $qry_pos)or die(mysqli_error($link));
            // echo "pos";
            
            if($sql){
                // echo "tes";
                
                $_SESSION['tab'] = "pos";
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='".$url."';</script>";
            }else{
                $_SESSION['tab'] = "pos";
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='".$url."';</script>";
            }
        }else if(isset($_POST['kode_group'])){
            $qry_code = mysqli_query($link, "SELECT max(SUBSTRING(`id_group`, -3)) AS `group` FROM groupfrm")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);

            for($i=0 ; $i < count($_POST['kode_group']);$i++){
                
                $nama = $_POST['nama_group'][$i];
                $cord = $_POST['cord_group'][$i];
                $id_parent = $_POST['parentgroup'][$i];
                $part = "group";
                
                $urutan = (int) $d['group'] + ($i+1);
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;

                $qry_grp .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";

            }
            $qry_grp = substr($qry_grp, 0, -1);
            // echo $qry_grp;
            $sql = mysqli_query($link, $qry_grp)or die(mysqli_error($link));
            if($sql){
                $_SESSION['tab'] = "group";
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='".$url."';</script>";
            }else{
                $_SESSION['tab'] = "group";
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='".$url."';</script>";
            }
            // echo "group";
        }else if(isset($_POST['kode_section'])){
            $qry_code = mysqli_query($link, "SELECT max(SUBSTRING(`id_section`, -3)) AS `section` FROM section")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);

            for($i=0 ; $i < count($_POST['kode_section']);$i++){
                $nama = $_POST['nama_section'][$i];
                $cord = $_POST['cord_section'][$i];
                $id_parent = $_POST['parentsection'][$i];
                $part = "section";
                
                $urutan = (int) $d['section'] + ($i+1);
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;
                $qry_sct .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";

            }
            $qry_sct = substr($qry_sct, 0, -1);
            $sql = mysqli_query($link, $qry_sct)or die(mysqli_error($link));
            // echo $qry_sct;
            if($sql){
                $_SESSION['tab'] = "section";
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }else{
                $_SESSION['tab'] = "section";
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }
        }else if(isset($_POST['kode_dept'])){
            $qry_code = mysqli_query($link, "SELECT max(SUBSTRING(`id_dept`, -3))  AS `dept` FROM department")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);
            for($i=0 ; $i < count($_POST['kode_dept']);$i++){
                
                $nama = $_POST['nama_dept'][$i];
                $cord = $_POST['cord_dept'][$i];
                $id_parent = $_POST['parentdept'][$i];
                $part = "dept";

                $urutan = (int) $d['dept'] + ($i+1);
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;
                $qry_dpt .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";

            }
            $qry_dpt = substr($qry_dpt, 0, -1);
            $sql = mysqli_query($link, $qry_dpt)or die(mysqli_error($link));
            // echo $qry_dpt;
            if($sql){
                $_SESSION['tab'] = "dept";
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }else{
                $_SESSION['tab'] = "dept";
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }
        }else if(isset($_POST['kode_deptAcc'])){
            $qry_code = mysqli_query($link, "SELECT max(SUBSTRING(`id_dept_account`, -3)) AS `deptAcc` FROM dept_account")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);
            for($i=0 ; $i < count($_POST['kode_deptAcc']);$i++){
                $nama = $_POST['nama_deptAcc'][$i];
                $cord = $_POST['cord_deptAcc'][$i];
                $id_parent = $_POST['parentdeptAcc'][$i];
                $part = "deptAcc";

                $urutan = (int) $d['deptAcc'] + ($i+1);
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;

                $qry_dptacc .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";
                // echo $d['deptAcc']."</br>";
                // echo $id."</br>";
            }
            $qry_dptacc = substr($qry_dptacc, 0, -1);
            // echo $qry_dptacc;
            $sql = mysqli_query($link, $qry_dptacc)or die(mysqli_error($link));
            // echo $qry_dptacc;
            if($sql){
                $_SESSION['tab'] = "deptacc";
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }else{
                $_SESSION['tab'] = "deptacc";
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }
        }else if(isset($_POST['kode_division'])){
            $qry_code = mysqli_query($link, "SELECT  max(SUBSTRING(`id_div`, -3)) AS `div` FROM division")or die(mysqli_error($link));
            $d = mysqli_fetch_assoc($qry_code);
            $_SESSION['tab'] = "division";
            for($i=0 ; $i < count($_POST['kode_division']);$i++){
                
                $nama = $_POST['nama_division'][$i];
                $cord = $_POST['cord_division'][$i];
                $id_parent = $_POST['parentdivision'][$i];
                $part = "division";

                $urutan = (int) $d['div'] + ($i+1);
                $kode = $id_parent."-".sprintf("%03s", $urutan);
                $id = $kode;
                $qry_div .= " ('$id', '$nama', '$cord', '$id_parent', '$part'),";
            }
            $qry_div = substr($qry_div, 0, -1);
            // echo $qry_div;
            $sql = mysqli_query($link, $qry_div)or die(mysqli_error($link));
            if($sql){
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }else{
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='../index.php';</script>";
            }
        }else{
            echo "gagal";
        }
    // edit
    }else if(isset($_POST['edit'])){
        if(isset($_POST['kode_pos'])){
            $_SESSION['tab'] = "pos";
            for($i=0 ; $i < count($_POST['kode_pos']);$i++){
                $id = $_POST['kode_pos'][$i];
                $nama = $_POST['nama_pos'][$i];
                $cord = $_POST['cord_pos'][$i];
                $id_parent = $_POST['parentpos'][$i];
                $part = "pos";
                $qry = "UPDATE `pos_leader` SET `nama_pos` = '$nama' , `npk_cord` = '$cord' , `id_group` = '$id_parent' , `part` = '$part' WHERE `id_post` = '$id'  ";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                // echo $qry."<br>";
            }
        }
        if(isset($_POST['kode_group'])){
            $_SESSION['tab'] = "group";
            for($i=0 ; $i < count($_POST['kode_group']);$i++){
                $id = $_POST['kode_group'][$i];
                $nama = $_POST['nama_group'][$i];
                $cord = $_POST['cord_group'][$i];
                $id_parent = $_POST['parentgroup'][$i];
                $part = "group";
                $qry = "UPDATE `groupfrm` SET `nama_group`= '$nama' , `npk_cord` = '$cord' , `id_section` = '$id_parent' , `part` = '$part'  WHERE `id_group` = '$id' ";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
                // echo $qry;
            }
        }
        if(isset($_POST['kode_section'])){
            $_SESSION['tab'] = "section";
            for($i=0 ; $i < count($_POST['kode_section']);$i++){
                $id = $_POST['kode_section'][$i];
                $nama = $_POST['nama_section'][$i];
                $cord = $_POST['cord_section'][$i];
                $id_parent = $_POST['parentsection'][$i];
                $part = "section";
                $qry = "UPDATE `section`SET `section`  = '$nama' , `npk_cord` = '$cord' , `id_dept` = '$id_parent' , `part` = '$part' WHERE `id_section` = '$id' ";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
            }
        }
        if(isset($_POST['kode_dept'])){
            $_SESSION['tab'] = "dept";
            for($i=0 ; $i < count($_POST['kode_dept']);$i++){
                $id = $_POST['kode_dept'][$i];
                $nama = $_POST['nama_dept'][$i];
                $cord = $_POST['cord_dept'][$i];
                $id_parent = $_POST['parentdept'][$i];
                $part = "dept";
                $qry = "UPDATE `department` SET  `dept` = '$nama' , `npk_cord` = '$cord' , `id_div` = '$id_parent' , `part` = '$part' WHERE `id_dept` = '$id'  ";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
            }
            
        }
        if(isset($_POST['kode_deptacc'])){
            $_SESSION['tab'] = "deptacc";
            for($i=0 ; $i < count($_POST['kode_deptacc']);$i++){
                $id = $_POST['kode_deptacc'][$i];
                $nama = $_POST['nama_deptacc'][$i];
                $cord = $_POST['cord_deptacc'][$i];
                $id_parent = $_POST['parentdeptacc'][$i];
                $part = "deptAcc";
                $qry = "UPDATE `dept_account` SET  `department_account` = '$nama' , `npk_dept` = '$cord' , `id_div` = '$id_parent' , `part` = '$part' WHERE `id_dept_account` = '$id'";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
            }
            
        }
        if(isset($_POST['kode_division'])){
            $_SESSION['tab'] = "division";
            // echo $_POST['kode_division'][0];
            for($i=0 ; $i < count($_POST['kode_division']);$i++){
                $id = $_POST['kode_division'][$i];
                $nama = $_POST['nama_division'][$i];
                $cord = $_POST['cord_division'][$i];
                $id_parent = $_POST['parentdivision'][$i];
                $part = "division";
                $qry = "UPDATE `division` SET `nama_divisi` = '$nama' , `npk_cord` = '$cord' , `id_company` = '$id_parent' , `part` = '$part' WHERE `id_div` = '$id' ";
                $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
            }
            // echo "tes";
        }
        if($sql){
            $_SESSION['info'] = "Disimpan";
            echo "<script>window.location='../index.php';</script>";
        }else{
            $_SESSION['info'] = "Gagal Disimpan";
            echo "<script>window.location='../index.php';</script>";
        }

    }else if(isset($_GET['del_area'])){
        $id = $_GET['del_area'];
        $part = $_GET['part'];
        
        if($part == 'pos'){
            $del = mysqli_query($link, "DELETE FROM pos_leader WHERE id_post = '$id' ")or die(mysqli_error($link));
            if($del){
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='".base_url()."/dashboard/pages/mp_update.php';</script>";
            }else{
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='".base_url()."/dashboard/pages/mp_update.php';</script>";
            }
        }else if($part == 'group'){
            $del = mysqli_query($link, "DELETE FROM groupfrm WHERE id_group = '$id' ")or die(mysqli_error($link));
            if($del){
                $_SESSION['info'] = "Disimpan";
                echo "<script>window.location='".base_url()."/dashboard/pages/mp_update.php';</script>";
            }else{
                $_SESSION['info'] = "Gagal Disimpan";
                echo "<script>window.location='".base_url()."/dashboard/pages/mp_update.php';</script>";
            }
        }
    }

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>