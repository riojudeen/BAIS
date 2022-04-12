<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "User Guide";
if(isset($_SESSION['user'])){
    $query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'GUIDE' ")or die(mysqli_error($link));
            $sql_dir = mysqli_fetch_assoc($query_dir);
            $root_path = $sql_dir['root'];
    $folder = $root_path;
    
    switch($_GET['data']){
        case "nav-start":
            $dir = 'Getting Started/';
            break;
        case "nav-dashboard":
            $dir = 'Dashboard/';
            break;
        case "nav-org":
            $dir = 'Organization/';
            break;
        case "nav-attendance":
            $dir = 'Attendance/';
            break;
        case "nav-overtime":
            $dir = 'Overtime/';
            break;
        case "nav-administrator":
            $dir = 'Control Setings/';
            break;
        case "nav-document":
            $dir = 'Documents/';
            break;
    }
    $dir = $folder.$dir;
    if(!file_exists($dir)){
        mkdir($dir);
    }
    
    $getStart =$dir."Getting Started.ppsx";
    $files = array();
    $open    = opendir($dir) or die('Folder tidak ditemukan ...!');
    while ($file    =readdir($open)) {
        if($file !='.' && $file !='..'){   
            // $files[]=$file;
            array_push($files, $file);
        }
    }
    $jml = count($files);
    ?>
    <div class="col-md-12 owl-carousel owl-loaded owl-drag ">
    <?php
    if($jml > 0 ){
        foreach($files AS $file_data){
            $type = pathinfo($dir.$file_data, PATHINFO_EXTENSION);
            $dataImage = file_get_contents($dir.$file_data);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
            
            ?>
            <img src="<?=$image?>" style="width:100%;background:black" ></img>
            <?php
        }
    }
    ?>
    </div>
    <?php
} 
	

?>
 <script>
    $(document).ready(function(){
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:1,
            loop:true,
            margin:10,
            autoplay:false,
            autoplayTimeout:3000,
            autoplayHoverPause:true
        });
    });
</script>