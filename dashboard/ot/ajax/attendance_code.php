<?php
include("../../../config/config.php");
if(isset($_GET['id'])){
    $query_attendance_code = mysqli_query($link, "SELECT * FROM attendance_code WHERE `type`= '$_GET[id]' ORDER BY `kode` ASC ")or die(mysqli_error($link));
    while($data_attendance_code = mysqli_fetch_assoc($query_attendance_code)){
        ?>
        <option value="<?=$data_attendance_code['kode']?>"><?=$data_attendance_code['keterangan']?></option>
        <?php
    }
}