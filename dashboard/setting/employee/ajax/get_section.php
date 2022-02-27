<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $s_section = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = 'section' AND id_parent = '$id' ")or die(mysqli_error($link));
    if(mysqli_num_rows($s_section)>0){
        ?>
        <option disabled>Pilih Section Area</option>
        <?php
        while($dataSection=mysqli_fetch_assoc($s_section)){
            ?>
            <option value="<?=$dataSection['id']?>"><?=$dataSection['nama_org']?> - (<?=$dataSection['nama_cord']?>)</option>
            <?php
        }
    }else{
        ?>
        <option disabled>Belum Ada Data Section</option>
        <?php
    }
    ?>
    <option value="notset">Kosongkan</option>
    <?php


}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>