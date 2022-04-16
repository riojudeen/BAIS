<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
// if(isset($_GET['id'])){
    $q_data = mysqli_query($link, "SELECT id, nama_org, cord nama_cord, id_parent FROM view_cord_area WHERE part = 'division' ")or die(mysqli_error($link));
    if(mysqli_num_rows($q_data)>0){
        ?>
        <option value="-">Pilih Division</option>
        <?php
        while($data = mysqli_fetch_assoc($q_data)){
            if($_GET['value'] == $data['id']){
                $selected = "selected";
            }else{
                $selected = "";
            }
            ?>
            <option <?=$selected?> value="<?=$data['id']?>"><?=$data['nama_org']?></option>
            <?php
        }
    ?>
    <option value="-">-</option>
    <?php
    }else{
        ?>
        <option value="-">-</option>
        <?php
    }
   

// }else{
    // echo "<script>window.location='".base_url('auth/login.php')."';</script>";
// }
?>