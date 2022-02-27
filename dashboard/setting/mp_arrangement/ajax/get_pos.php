<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
// echo $_GET['data'];
?>
<option >Pilih Pos Leader</option>
<?php
$q_pos = mysqli_query($link,"SELECT nama_pos,  id_post FROM pos_leader WHERE id_group = '$_GET[data]' ")or die(mysqli_error($link));
if(mysqli_num_rows($q_pos)>0){
    while($dataPos = mysqli_fetch_assoc($q_pos)){
        ?>
        <option value="<?=$dataPos['id_post']?>"><?=$dataPos['nama_pos']?></option>
        <?php
    }
}else{
    ?>
    <option value="0" disabled>Belum Ada data</option>
    <?php
}
?>
