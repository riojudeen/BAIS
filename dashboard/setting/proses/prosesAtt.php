<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['mpchecked'])){
        
        foreach($_POST['mpchecked'] AS $id){
            if($_GET['port'] == 'nav-att'){
                mysqli_query($link, "DELETE FROM absensi WHERE id = '$id' ");
            }else if($_GET['port'] == 'nav-ot'){
                mysqli_query($link, "DELETE FROM hr_lembur WHERE id = '$id' ");
            }
            
        }
        if($_GET['manual'] == 1){
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../portAtt.php'</script>";
        }else{
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../portAtt.php'</script>";
        }
        
    }else{
        echo "TES";
        // $_SESSION['info'] = 'Kosong';
        // echo "<script>document.location.href='../portAtt.php'</script>";
    }
} else{
    echo "<script>document.location.href='../portAtt.php'</script>";
}
?>