<?php
require_once("../../../config/config.php");
    if(isset($_POST['id'])){
    $i = $_POST['id'];

    $id_jabatan = (isset($_POST['jab']))? $_POST['jab'] : "";
    if($id_jabatan == "DH" || $id_jabatan == "ADH" ){
        $disable = "disabled";
        $selectDh = "selected";
    }else{
        $disable = "";
        $selectDh = "";
    }
    $select = ($_POST['val'] == "-") ? "selected" : "";


?>
    <option disabled>Pilih Dept Funct.</option>
    <?php
    $sDept = mysqli_query($link, "SELECT * FROM department ORDER BY `dept` ASC")or die(Mysqli_error($link));
    while($dDept = mysqli_fetch_assoc($sDept)){
        ?>
        <option  <?=$disable?> title="<?=$dDept['id_dept']?>" value="<?=$dDept['id_dept']?>"><?=$dDept['dept']?></option>
        <?php
    }
    ?>
    <option <?= $selectDh." ".$select?> value="0">-</option>


<?php
}
?>
