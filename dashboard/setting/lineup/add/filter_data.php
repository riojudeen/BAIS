<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    // $_GET['posAreaProd'] = '';
    // $_GET['type'] = '';
    // $_GET['group'] = '';
    // $_GET['shift'] = '';
    // $_GET['line'] = '';
    // $_GET['model'] = '';
    if(isset($_GET['posGroup'])){
        ?>
        <option value="">Pilih Group Foreman</option>
        <?php
        $q_group = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_line = '$_GET[data]' GROUP BY id_group ")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_group)>0){
            while($data = mysqli_fetch_assoc($q_group)){
                // $select = ($_GET['posGroup'] == $data['id_group'])?"selected":"";
                ?>
                <option value="<?=$data['id_group']?>"><?=$data['nama_group']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['posModel'])){
        $q_model = mysqli_query($link, "SELECT * FROM production_model WHERE stats = 'active'")or die(mysqli_error($ink));
        ?>
        <option value="">Pilih Model</option>
        <?php
        if(mysqli_num_rows($q_model)>0){
            while($data = mysqli_fetch_assoc($q_model)){
                
                ?>
                <option value="<?=$data['id_model']?>"><?=$data['name']?> - <?=$data['alias']?></option>
                <?php
            }
            ?>
            <?php
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['posLine'])){
        ?>
        <option value="">Pilih Line Produksi</option>
        <?php
        $q_line = mysqli_query($link, "SELECT * FROM production_line WHERE id_model = '$_GET[data]' " )or die(mysqli_error($ink));
        if(mysqli_num_rows($q_line)>0){
            while($data = mysqli_fetch_assoc($q_line)){
                // $select = ($_GET['posLine'] == $data['id_line'])?"selected":"";
                ?>
                <option value="<?=$data['id_line']?>"><?=$data['nama']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['posAreaProd']) || isset($_GET['posAreaProd']) ){
        $q_area = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_prod_type = '$_GET[type]' AND shift = '$_GET[shift]' AND id_group = '$_GET[group]' AND id_line = '$_GET[line]' AND id_model = '$_GET[model]'")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_area)>0){
            while($data = mysqli_fetch_assoc($q_area)){
                // $select = ($_GET['posAreaProd'] == $data['id'])?"selected":"";
                ?>
                <option  value="<?=$data['id']?>"><?=$data['prod_name']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled>Belum ada data</option>

            <?php
        }
    }else if(isset($_GET['posType'])){
        $q_type = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_group = '$_GET[data]' GROUP BY id_prod_type ")or die(mysqli_error($ink));
        // echo mysqli_num_rows($q_type);
        if(mysqli_num_rows($q_type)>0){
            while($data = mysqli_fetch_assoc($q_type)){
                // $select = ($_GET['posType'] == $data['id_prod_type'])?"selected":"";
                ?>
                <option  value="<?=$data['id_prod_type']?>"><?=$data['prod_type']?></option>
                <?php
            }
        }else{
            ?>
            <option disabled><?=$_GET['posType']?></option>

            <?php
        }
    }else if(isset($_GET['posShift'])){
        $q_shift = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_prod_type = '$_GET[data]' GROUP BY shift ")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_shift)>0){
            while($data = mysqli_fetch_assoc($q_shift)){
                // $select = ($_GET['posShift'] == $data['shift'])?"selected":"";
                ?>
                <option <?=$select?> value="<?=$data['shift']?>">Shift <?=$data['shift']?></option>
                <?php
            }
            ?>

            <?php
        }else{
            ?>
            <option disabled>Masuk</option>
            <?php
        }
    }else if(isset($_GET['posPosLeader'])){
        $query = mysqli_query($link, "SELECT  * FROM`view_daftar_area` WHERE part = 'pos'")or die(mysqli_error($ink));
        if(mysqli_num_rows($q_shift)>0){
            while($data = mysqli_fetch_assoc($q_shift)){
                ?>
                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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