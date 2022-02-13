<?php
function content($go);
{
    $cek = trim($go);
    if($cek == ""){
        $file = "index.php";
    }
    if($cek == "update_mp"){
        $file = "update_mp.php";
    }
    return $file;
}
?>