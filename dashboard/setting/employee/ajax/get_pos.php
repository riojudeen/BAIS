<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
// if(isset($_GET['id'])){
    $id = $_GET['id'];
    $s_pos = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = 'pos' AND id_parent = '$id' ")or die(mysqli_error($link));
    if(mysqli_num_rows($s_pos)>0){
        ?>
        <option disabled>Pilih Pos Leader</option>
        <?php
        while($data=mysqli_fetch_assoc($s_pos)){
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


// }else{
    // echo "<script>window.location='".base_url('auth/login.php')."';</script>";
// }
?>