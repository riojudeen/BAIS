<?php

//////////////////////////////////////////////////////////////////////
include("../../../../config/config.php");
include("../../../../config/approval_system.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        $q_div = mysqli_query($link, "SELECT `id`,`nama_org`,`cord`,`nama_cord` FROM `view_cord_area` WHERE `part` = 'deptAcc' AND id_parent = '$_GET[data]' ")or die(mysqli_error($link));
        if(mysqli_num_rows($q_div) > 0){
            ?>
                <option value="">Pilih Dept Administratif</option>
            <?php
            while($data = mysqli_fetch_assoc($q_div)){
            ?>
            <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
            <?php
            }
        }else{
            ?>
            <option value="">Belum Ada Data Department Administratif</option>
            <?php
        }
    }else{
        include_once ("../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>