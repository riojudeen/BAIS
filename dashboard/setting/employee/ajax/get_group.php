<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $s_group = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = 'group' AND id_parent = '$id' ")or die(mysqli_error($link));

    if(mysqli_num_rows($s_group)>0){
        ?>
        <option disabled>Pilih Group Area</option>
        <?php
        while($data=mysqli_fetch_assoc($s_group)){
            ?>
            <option value="<?=$data['id']?>"><?=$data['nama_org']?> - (<?=$data['nama_cord']?>)</option>
            <?php
        }
    }else{
        ?>
        <option disabled>Belum Ada Data Group</option>
        <?php
    }
    ?>
    <option value="notset">Kosongkan</option>
    <?php


}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>