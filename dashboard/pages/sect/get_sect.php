<?php
include("../../../config/config.php"); 
$id_dept = $_POST['dept'];
echo "<option >Pilih Section</option>";
$sql_sect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$id_dept' ORDER BY section ASC") or die(mysqli_error($link));
if($totaldata = (mysqli_num_rows($sql_sect) > 0)) {
    while($data_sect = mysqli_fetch_assoc($sql_sect)){
        echo '<option value="'.$data_sect['id_section'].'">'.$data_sect['section'].'</option>';
    }
} else { echo '<option selected>Data Section Tidak ditemukan</option>';}
?>