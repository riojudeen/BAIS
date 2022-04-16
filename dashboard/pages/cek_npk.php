<?php
require_once("../../config/config.php");
//tampung id department 


if(isset($_POST['npk'])){
    $npk = $_POST['npk'];
    $cekvalidasi = mysqli_query($link, "SELECT * FROM karyawan WHERE npk='$npk'");
    if(mysqli_num_rows($cekvalidasi) > 0){
        echo "1";
        // echo "<script>alert('karayawan dengan NPK $npk sudah ada di dalam database!');window.location='addmp.php'</script>";
        
    }else{
        echo '0';
    }
}


?>