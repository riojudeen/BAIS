<?php
include("../../../config/config.php"); 

$id_section = $_POST['sect'];
echo "<option value=\"\">Pilih Group Foreman</option>";

$grp = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$id_section' ORDER BY group_cord ASC") or die(mysqli_error($link));
if($totaldata = (mysqli_num_rows($grp) > 0)) {
    while($data_grp = mysqli_fetch_assoc($grp)){
    echo '<option value="'.$data_grp['id_group'].'">'.$data_grp['group_cord'].'</option>';
    }
}else{ echo '<option value="" selected>Data Group Foreman Tidak ditemukan</option>';}
                                    
                                    
                                      ?>