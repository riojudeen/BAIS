<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
if(isset($_POST['data'])){
    if($_POST['data'] == 'pos' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM pos_leader WHERE `id_post` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['nama_pos']
        );
        echo json_encode($data);
    }else if($_POST['data'] == 'group' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM groupfrm WHERE `id_group` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['nama_group']
        );
        echo json_encode($data);
    }else if($_POST['data'] == 'section' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM section WHERE `id_section` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['section']
        );
        echo json_encode($data);
    }else if($_POST['data'] == 'dept' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM department WHERE `id_dept` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['dept']
        );
        echo json_encode($data);
    }else if($_POST['data'] == 'deptAcc' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM dept_account WHERE `id_dept_account` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['department_account']
        );
        echo json_encode($data);
    }else if($_POST['data'] == 'division' ){
        $kode = $_POST['kode'];
        $sKode = mysqli_query($link, "SELECT * FROM division WHERE `id_div` = '$kode'");
        $jKode = mysqli_num_rows($sKode);
        $hKode = mysqli_fetch_assoc($sKode);
        $data = array(
            'jumlah' => $jKode ,
            'nama' => $hKode['nama_divisi']
        );
        echo json_encode($data);
    }
   
}


?>