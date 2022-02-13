
<?php

require_once("../../../config/config.php"); 
    $i = $_POST['id'];
    $id_section = $_POST['val'];
    $id_jabatan = (isset($_POST['jab']))? $_POST['jab'] : "";
    $select = ($_POST['val'] == "-") ? "selected" : "";
?>

    <option disabled>Pilih Group</option>
    <?php
    $sGroup = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$id_section' ORDER BY `nama_group` ASC")or die(Mysqli_error($link));
    while($dGroup = mysqli_fetch_assoc($sGroup)){
        ?>
        <option value="<?=$dGroup['id_group']?>"><?=$dGroup['nama_group']?></option>
        <?php
    }
    
    ?>
    <option <?=$select?> value="0">-</option>

