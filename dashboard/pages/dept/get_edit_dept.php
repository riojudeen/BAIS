<?php

include("../../../config/config.php"); 
$npk = $_POST['npk'];

$sql_dept = mysqli_query($link, "SELECT * FROM karyawan WHERE npk = '$npk' ") or die(mysqli_error($link));
                                      while($data_dept = mysqli_fetch_assoc($sql_dept)){
                                        echo '<option value="'.$data_dept['nama'].'">'.$data_dept['nama'].'</option>';
                                      }
?>