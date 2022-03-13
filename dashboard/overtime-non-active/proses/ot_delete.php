<?php
//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){

	if($_GET['kl']!=""){
		$kl = $_GET['kl'];
		$del = mysqli_query($link, "DELETE FROM lembur WHERE kode_lembur = '$kl' AND CONCAT(status_approve, `status`) = '0a' ");
		if($del){
			$_SESSION['info'] = 'Dihapus';
			echo "<script>document.location.href='../index.php'</script>";
		}else{
			$_SESSION['info'] = 'Gagal Dihapus';
			echo "<script>document.location.href='../index.php'</script>";
		}
	}

}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>