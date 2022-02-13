<?php
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['prod'])){
        
        $prod = $_POST['prod'];
    
        // cari working days
        $query = "SELECT * FROM unit_prod WHERE `id_unit`= '$prod' ";
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        if(mysqli_num_rows($sql) > 0){
            while($data = mysqli_fetch_assoc($sql)){
                
                ?>
                <option value="<?=$data['id_prod']?>"><?=$data['prod_alias']?> - <?=$data['prod_name']?></option>
                <?php
            }
        }else{
            ?>
            <option value="">BQC</option>
            <?php
        }
        
    }else{
        echo "<script>window.location='index.php';</script>";
    }
?>


<?php
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>