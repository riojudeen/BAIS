<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
if(isset($_POST['data'])){
    mysqli_query($link, "INSERT karyawan_layoff(`npk`,`emk`,`update_by`) VALUES ('$_POST[npk]','$_POST[data]','$npkUser')")or die(mysqli_error($link));

}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>