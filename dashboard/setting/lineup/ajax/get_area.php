<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $data = $_GET['data'];
    $area = $_GET['area'];
    if($area == "division"){
        $query = "SELECT * FROM view_daftar_area WHERE part = 'division' AND id_parent = '1' ";
        ?>
        <option value="">Pilih Divisi</option>
        <?php
    }else if($area == "dept"){
        $query = "SELECT * FROM view_daftar_area WHERE part = 'dept' AND id_parent = '$data' ";
        ?>
        <option value="">Pilih Department</option>
        <?php
    }else if($area == "section"){
        $query = "SELECT * FROM view_daftar_area WHERE part = 'section' AND id_parent = '$data' ";
        ?>
        <option value="">Pilih Section</option>
        <?php
    }else if($area == "group"){
        $query = "SELECT * FROM view_daftar_area WHERE part = 'group' AND id_parent = '$data' ";
        ?>
        <option value="">Pilih Group</option>
        <?php
    }
    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
    if(mysqli_num_rows($sql)>0){
        while($data_area = mysqli_fetch_assoc($sql)){
            ?>
            <option value="<?=$data_area['id']?>"><?=$data_area['nama_org']?></option>
            <?php
        }
    }else{
        ?>
        <option value="">Tidak Ada Data</option>
        <?php
    }
    // echo $query;

}
?>