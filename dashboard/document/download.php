<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "User Guide";
if(isset($_SESSION['user'])){

    if(isset($_GET['file'])){
        $file    ="//adm-fs/BODY/BODY02/Body Plant/BAIS/BAIS-FORM/2022/".$_GET['file'];
        $filename = $_GET['file'];
        if (file_exists($file)) {
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');
            // header('Content-Disposition: attachment; filename='.basename($filename));
            // header('Content-Transfer-Encoding: binary');
            // header('Expires: 0');
            // header('Cache-Control: private');
            // header('Pragma: private');
            // header('Content-Length: ' . filesize($file));
            // ob_clean();
            // flush();

            $content = file_get_contents($file);

            //redirect dan download file
            header("Content-Disposition: attachment; filename=".$filename);
            
            // unlink($file);
            exit($content);
            // // readfile($file);
            // exit;
        } 
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
	

?>