<?php

//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
mysqli_query($link, "DELETE FROM karyawan WHERE npk = '$_GET[npk]'") or die(mysqli_error($link));
echo "<script>window.location='manpower.php';</script>";
?>