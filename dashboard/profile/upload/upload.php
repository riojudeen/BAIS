<?php
include("../../../config/config.php"); 
// new filename
if(isset($_GET['ganti_foto'])){
	$file_mimes = array('image/png');
	$npk = $_GET['ganti_foto'];
	$filename = $npk . '.jpg';
	if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
		$ImageName       = $_FILES['file_import']['name'];
		$image = $_FILES['file_import']['name'];

		$dir = $_FILES['file_import']['tmp_name']; //file upload

		$query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'FOTO' ")or die(mysqli_error($link));
		$sql_dir = mysqli_fetch_assoc($query_dir);
		$root_path = $sql_dir['root'];
		$path = "$root_path";
		
		$newPath = "$root_path".$filename;
	if($root_path){
		if($newPath){
			unlink($newPath);
			move_uploaded_file($_FILES['file_import']['tmp_name'],$newPath);
		}else{
			move_uploaded_file($_FILES['file_import']['tmp_name'],$newPath);
		}
	
	}else{
		if(file_exists('upload/'.$filename)){
			unlink('upload/'.$filename);
			
			if( move_uploaded_file($_FILES['file_import']['tmp_name'],'upload/'.$filename) ){
				$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
			}	
		}else{
			if( move_uploaded_file($_FILES['file_import']['tmp_name'],'upload/'.$filename) ){
				$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
			}	
		}
	
	}

	}else{
		$imageName = "'NULL'";
	}
}else{

	$npk = $_GET['npk'];
	$filename = $npk . '.jpg';
	$url = '';
	echo $npk;
	
	$query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'FOTO' ")or die(mysqli_error($link));
			$sql_dir = mysqli_fetch_assoc($query_dir);
			$root_path = $sql_dir['root'];
	$path = "//adm-fs/HRD/HRD-Photo/".$npk.".jpg";
	
	$newPath = "$root_path".$filename;
	if($root_path){
		if($newPath){
			unlink($newPath);
			move_uploaded_file($_FILES['webcam']['tmp_name'],$newPath);
		}else{
			move_uploaded_file($_FILES['webcam']['tmp_name'],$newPath);
		}
	
	}else{
		if(file_exists('upload/'.$filename)){
			unlink('upload/'.$filename);
			
			if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
				$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
			}	
		}else{
			if( move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename) ){
				$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename;
			}	
		}
	
	}
}
		

// if(file_exists($dir)){
// 	if(file_exists($dir.$filename)){
// 		unlink($dir.$filename);
// 		move_uploaded_file($_FILES['webcam']['tmp_name'],$dir.$filename);
		
// 		echo $url;
// 	}else{
// 		move_uploaded_file($_FILES['webcam']['tmp_name'],$dir.$filename);
			
// 	}
// }else{
// 	if(file_exists('upload/'.$filename)){
// 		unlink('upload/'.$filename);
// 		move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename);
			
// 	}else{
// 		move_uploaded_file($_FILES['webcam']['tmp_name'],'upload/'.$filename);
		
// 	}
	
// }
// echo $npk;
// move_uploaded_file($_FILES['webcam']['tmp_name'],$dir.$filename);
// Return image url
echo $url;