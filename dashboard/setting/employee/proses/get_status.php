<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
if(isset($_GET['val']) ){
    if($_GET['val'] == "TM" ){
        $q_data = mysqli_query($link, "SELECT *  FROM status_mp  ")or die(mysqli_error($link));
            ?>
            <option value="-">Pilih Status</option>
            <?php
        if(mysqli_num_rows($q_data)>0){
            while($data = mysqli_fetch_assoc($q_data)){
                
                ?>
                <option value="<?=$data['id']?>"><?=$data['status_mp']?></option>
                <?php
            }
        }else{
            ?>
            <option value="-">Belum Ada Data</option>
            <?php
        }
    }else{
        ?>
            <option value="P">Permanent</option>
        <?php
    }
    
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>