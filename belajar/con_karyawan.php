<?php
  $host="localhost"; 
  $username="root"; 
  $password=""; 
  $database="bais_db"; 
  $sambung=@mysql_connect($host,$username,$password); 
  mysql_select_db($database,$sambung); 

?>
