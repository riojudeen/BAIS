<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");

?>
<option >Pilih Group</option>
<?php
$q_group = mysqli_query($link,"SELECT nama_group, id_group FROM groupfrm WHERE id_section = '$_GET[data]' ")or die(mysqli_error($link));
if(mysqli_num_rows($q_group)>0){
    while($dataGroup = mysqli_fetch_assoc($q_group)){
        ?>
        <option value="<?=$dataGroup['id_group']?>"><?=$dataGroup['nama_group']?></option>
        <?php
    }
}else{
    ?>
    <option value="0" disabled>Belum Ada data</option>
    <?php
}
?>
