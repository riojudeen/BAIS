<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_GET['group'])){
        $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_group)>0){
            while($data = mysqli_fetch_assoc($q_group)){
                ?>
                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['dept_account'])){
        $q_dept = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc'")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_dept)>0){
            while($data = mysqli_fetch_assoc($q_dept)){
                ?>
                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['model'])){
        $q_model = mysqli_query($link, "SELECT * FROM production_model WHERE stats = 'active'")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_model)>0){
            while($data = mysqli_fetch_assoc($q_model)){
                ?>
                <option value="<?=$data['id_model']?>"><?=$data['name']?> - <?=$data['alias']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['line'])){
        $q_line = mysqli_query($link, "SELECT * FROM production_line")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_line)>0){
            while($data = mysqli_fetch_assoc($q_line)){
                ?>
                <option value="<?=$data['id_line']?>"><?=$data['nama']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['type'])){
        $q_type = mysqli_query($link, "SELECT * FROM production_type")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_type)>0){
            while($data = mysqli_fetch_assoc($q_type)){
                ?>
                <option value="<?=$data['id_type']?>"><?=$data['name']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['shift'])){
        $q_shift = mysqli_query($link, "SELECT `id_shift` AS id, `shift` AS `name` FROM `shift` WHERE `production` = '1' ")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_shift)>0){
            while($data = mysqli_fetch_assoc($q_shift)){
                ?>
                <option value="<?=$data['id']?>"><?=$data['name']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>
            <?php
        }
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>