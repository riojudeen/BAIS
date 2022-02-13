<?php
include("../../../config/config.php"); 
// $id_group = $_POST['group'];

?>
<select class="form-control px-0 py-0 my-0" data-live-search="true" data-style="btn-warning btn-outline-warning" data-size="7" id="leader1" name="leader[]" title="Pilih Leader" multiple>
<?php

$sql_ldr = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$id_group' ORDER BY npk_cord ASC") or die(mysqli_error($link));
if($totaldata = (mysqli_num_rows($sql_ldr) > 0)) {
    while($data_ldr = mysqli_fetch_assoc($sql_ldr)){
        $s_cordname = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = $data_ldr[npk_cord] ")or die(mysqli_error($link));
        $d_cordname = mysqli_fetch_assoc($s_cordname);

        echo "<option data-subtext=\"$data_ldr[nama_pos]\" title=\"$data_ldr[nama_pos]\" value=\"$data_ldr[id_post]\">$d_cordname[nama]</option>";
        
    }
} else { echo '<option selected disabled value="0">Tidak ditemukan</option>';}
?>
</select>
<script>
$('#leader1').selectpicker();
</script>
