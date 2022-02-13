<?php
require_once("../../../config/config.php");
require_once("../../../_assets/vendor/autoload.php"); 
//tampung id department 


if(isset($_POST['add'])){
    $total = $_POST['total'];
    for ($i=1; $i<=$total; $i++){
        $kode = trim(mysqli_real_escape_string($link, $_POST['id-'.$i]));
        $dept = trim(mysqli_real_escape_string($link, $_POST['dept-'.$i]));
        $npk = trim(mysqli_real_escape_string($link, $_POST['npk-'.$i]));
        $cord = trim(mysqli_real_escape_string($link, $_POST['nama-'.$i]));
        $sqldept = mysqli_query($link, "INSERT INTO department (id_dept, dept, dept_cord, npk_cord) 
                                    VALUES ('$kode' , '$dept', '$cord' , '$npk')");

    }

  //validasi inputan primary key yang sudah ada
  
    if($sqldept){
        echo "<script>alert('$total sudah ditambahkan');window.location='index.php'</script>";

    }else{
        echo "<script>alert('$total data gagal ditambahkan');window.location='generate.php'</script>";
    
    }
  


}else if(isset($_POST['edit'])){
    $total = count($_POST['id']);
    for ($i=0; $i<count($_POST['id']); $i++){
        $kode = $_POST['id'][$i];
        $dept = $_POST['dept'][$i];
        $npk = $_POST['npk'][$i];
        $cord = $_POST['nama'][$i];
        $sqldept = mysqli_query($link, "UPDATE department SET dept = '$dept', dept_cord = '$cord', npk_cord = '$npk' WHERE id_dept = '$kode'") or die(mysqli_error($link));

    }
    if($sqldept){
        echo "<script>alert('berhasil $total edit data');window.location='index.php'</script>";
    }else{
        echo "<script>alert('gagal edit $total data');window.location='edit.php'</script>";

    }
}else if(isset($_POST['import'])){
    $file = @$_FILES['file']['name'];
    $ekstensi = explode(".", $file);
    $file_name = "file-".round(microtime(true)).".".end($ekstensi);
    $sumber = @$_FILES['file']['tmp_name'];
    $target_dir = "../../../file/";
    $target_file = $target_dir.$file_name;
    $upload = move_uploaded_file($sumber, $target_file);

    $obj = PHPExcel_IOFactory::load($target_file);
    $all_data = $obj->getActiveSheet()->toArray(null, true, true, true);
    
    //masukkan data excell ke database
    $sql = "INSERT INTO department (id_dept, dept, dept_cord, npk_cord) VALUES";
    for ($i = 6; $i <= count($all_data); $i++){
        $id_dept = $all_data[$i]['B'];
        $dept = $all_data[$i]['C'];
        $dept_cord = $all_data[$i]['D'];
        $npk_cord = $all_data[$i]['E'];
        $sql .= "('$id_dept', '$dept', '$dept_cord', '$npk_cord'),";
    }
    $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
    mysqli_query($link, $sql) or die(mysqli_error($link));
    $total = count($all_data) - 5;
    
    unlink($target_file);
    echo "<script>alert('berhasil tambah $total data');window.location='index.php'</script>";   

    

    
    
}

?>