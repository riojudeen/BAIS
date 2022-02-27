<?php
include("../../../config/config.php"); 

$id_section = $_POST['pos'];
echo "<option value=\"\">Pilih Team Leader / Pos Kerja</option>";
$query_pos = mysqli_query($link, "SELECT * FROM pos_leader ORDER BY post_leader ASC") or die(mysqli_error($link));
if($totaldata = (mysqli_num_rows($grp) > 0)) {
    while($data_pos = mysqli_fetch_assoc($query_pos)){
        echo '<option value="'.$data_pos['id_post'].'">'.$data_pos['post_leader'].'</option>';
    }
}else{echo '<option value="" selected>Data Team Leader / Pos Kerja Tidak ditemukan</option>';}




?>