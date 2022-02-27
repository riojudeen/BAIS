
<?php
include("../../config/config.php"); 

if(isset($_POST['add'])){
    $nama_skema = $_POST['nama'];
    $start_skema = $_POST['start'];
    $end_skema = $_POST['end'];
    $tipe_skema = $_POST['type'];
    $period_skema = $_POST['period'];
    // echo $nama_skema;
    // echo $start_skema;
    // echo $end_skema;
    // echo $tipe_skema;
    // echo $period_skema;
    echo "INSERT INTO system_lock (`system_name`, `status`, `off_start`, `off_end`, `type`, `periodic`) 
    VALUES('$nama_skema','0', '$start_skema', '$end_skema', '$tipe_skema', '$period_skema' )";
    mysqli_query($link, "INSERT INTO system_lock (`system_name`, `status`, `off_start`, `off_end`, `type`, `periodic`) 
    VALUES('$nama_skema','0', '$start_skema', '$end_skema', '$tipe_skema', '$period_skema' )")or die(mysqli_error($link));
    
}

?>