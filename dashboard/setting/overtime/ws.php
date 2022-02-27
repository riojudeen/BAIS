<?php
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['tgl'])){
        $tgl = dateToDB($_POST['tgl']); 
        
    
        // cari working days
        $query = "SELECT * FROM working_days WHERE `date`= '$tgl' GROUP BY wh ASC";
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        if(mysqli_num_rows($sql) > 0){
            while($data = mysqli_fetch_assoc($sql)){
                $qry_shift = mysqli_query($link, "SELECT * FROM working_hours WHERE id = '$data[wh]'")or die(mysqli_error($link));
                $data_shift = mysqli_fetch_assoc($qry_shift);
                $shift = $data_shift['code_name'];

                $qry_shiftgrp = mysqli_query($link, "SELECT * FROM shift WHERE id_shift = '$data[shift]'")or die(mysqli_error($link));
                $data_shiftgrp = mysqli_fetch_assoc($qry_shiftgrp);
                $shiftgrp = $data_shiftgrp['shift'];
                ?>
                <option value="<?=$data_shift['ket']?>"><?=$shiftgrp?> (<?=$shift?>)</option>
                <?php
            }
        }else{
            ?>
            <option value=""><?=$tgl?></option>
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