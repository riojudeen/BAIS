<?php
require_once("../../config/config.php");
//tampung id department 

$id_dept = $_POST['id_dept'];
//proses inputan form add man power

$sql_section = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$id_dept'");
while($data_section =  mysqli_fetch_array($sql_section)){
  echo '<option value="'.$data_section['id_section'].'">'.$data_section['section'].'</option>';
}
?>