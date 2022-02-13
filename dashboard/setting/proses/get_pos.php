<?php
require_once("../../../config/config.php"); 
    $i = $_POST['id'];
    $id_group = $_POST['val'];
    $id_jabatan = (isset($_POST['jab']))? $_POST['jab'] : "";
    $select = ($_POST['val'] == "-") ? "selected" : "";
?>

<option disabled>Pilih pos</option>
    <?php
    $sPos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$id_group' ORDER BY `nama_pos` ASC")or die(Mysqli_error($link));
    while($dPos = mysqli_fetch_assoc($sPos)){
        ?>
        <option value="<?=$dPos['id_post']?>"><?=$dPos['nama_pos']?></option>
        <?php
    }
    ?>
    <option <?=$select?> value="0">-</option>


