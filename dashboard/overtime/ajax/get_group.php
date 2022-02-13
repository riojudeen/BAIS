<?php
include("../../../config/config.php"); 
$id_section = $_POST['sect'];
echo "<option disabled selected>pilih group</option>";
?>

<?php
$sql_grp = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$id_section' ORDER BY npk_cord ASC") or die(mysqli_error($link));
if($totaldata = (mysqli_num_rows($sql_grp) > 0)) {
    while($data_grp = mysqli_fetch_assoc($sql_grp)){
        $s_cordname = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = $data_grp[npk_cord] ")or die(mysqli_error($link));
        $d_cordname = mysqli_fetch_assoc($s_cordname);

        echo '<option value="'.$data_grp['id_group'].'">'.$d_cordname['nama'].'</option>';
    }
} else { 
    echo '<option selected disabled>Tidak ditemukan</option>';
}
?>
