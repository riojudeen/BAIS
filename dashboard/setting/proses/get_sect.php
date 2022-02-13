<?php
require_once("../../../config/config.php");
    if(isset($_POST['id'])){
    $i = $_POST['id'];
    $id_dept = $_POST['val'];
    $id_jabatan = (isset($_POST['jab']))? $_POST['jab'] : "";
    $select = ($_POST['val'] == "-") ? "selected" : "";


?>
    <option disabled>Pilih Section</option>
    <?php
    $sSect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$id_dept' ORDER BY `section` ASC")or die(Mysqli_error($link));
    while($dSect = mysqli_fetch_assoc($sSect)){
    ?>
        <option value="<?=$dSect['id_section']?>"><?=$dSect['section']?></option>
    <?php
    }
    ?>
    <option <?=$select?> value="0">-</option>


<?php
}
?>
