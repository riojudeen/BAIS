<?php
include("../../../config/config.php"); 
echo "<option value=\"\">Pilih Department</option>";
$sql_dept = mysqli_query($link, "SELECT * FROM department ORDER BY dept ASC") or die(mysqli_error($link));
                                      while($data_dept = mysqli_fetch_assoc($sql_dept)){
                                        echo '<option value="'.$data_dept['id_dept'].'">'.$data_dept['dept'].'</option>';
                                      }
                                      ?>