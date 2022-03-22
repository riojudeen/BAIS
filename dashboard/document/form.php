<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Administration Form";
if(isset($_SESSION['user'])){

    include("../header.php");
    $dir    ="//adm-fs/BODY/BODY02/Body Plant/BAIS/BAIS-FORM/2022/"; 
    $page    =20;
    $pg        =isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;
    if($pg<2){
        $start    =0;
    }
    else{
        $start    =($pg-1)*$page;
    }
    


    if(isset($_GET['cari']) && !(empty($_GET['cari']))){
        $cari = $_GET['cari'];
        $filter = $cari;
        $folder = '//adm-fs/BODY/BODY02/Body Plant/BAIS/BAIS-FORM/2022/';
        $proses = new RecursiveDirectoryIterator("$folder");
        $files = array();
        foreach(new RecursiveIteratorIterator($proses) as $file){
            if (!((strpos(strtolower($file), $filter)) === false) || empty($filter)){
                $data = preg_replace("#/#", "/", $file);
                array_push($files, $data);
            }
        }
        
    }else{
        $cari = '';
        $open    =opendir($dir) or die('Folder tidak ditemukan ...!');
        while ($file    =readdir($open)) {
            if($file !='.' && $file !='..'){   
                $files[]=$file;
            }
        }
        
    }
    // menghitung jumlah file
    $jumlah_file    =count($files);
    $jumlah_page    =ceil($jumlah_file / $page); 
    sort($files);
    // print_r($files);
// menampilkan folder
    
    // membuka folder direktori
    
    
    ?>
    <div class="row">
        <div class="col-md-6 mb-0">
            <h6 class="mb-0 pb-0">
                Jumlah file: <?=$jumlah_file?> | Jumlah page: <?=$jumlah_page?>

            </h6>
        </div>
        <form class="col-md-6 text-right" method="GETs">
            <div class="mr-2 float-right order-3">
                <div class="input-group ">

                    <input type="text" name="cari"  class="form-control " placeholder="Cari File.." value="<?=$cari?>">
                    <div class="input-group-append bg-transparent">
                        <div class="input-group-text ">
                            <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">

        
        <?php
            // membuka isi file dalam folder
            for($x=$start;$x<($start+$page);$x++){
                
                if($x<$jumlah_file){
                    // echo $file;
                    $file = $dir.$files[$x];
                    $pathinfo = pathinfo($file);
                    $extention = $pathinfo['extension'];
                    $basename = $pathinfo['basename'];
                    if($extention == "xls" || $extention == "xlsx" || $extention == "ppt" || $extention == "pptx" || $extention == "doc" || $extention == "docx" || $extention == "pdf"){

                        switch($extention){
                            case 'xls':
                                $img = "../../assets/img/img/icon-excel.png";
                            case 'xlsx':
                                $img = "../../assets/img/img/icon-excel.png";
                                break;
                            case 'doc':
                                $img = "../../assets/img/img/icon-doc.png";
                            case 'docx':
                                $img = "../../assets/img/img/icon-doc.png";
                                break;
                            case 'ppt':
                                $img = "../../assets/img/img/icon-ppt.png";
                                break;
                            case 'pptx':
                                $img = "../../assets/img/img/icon-ppt.png";
                                break;
                            case 'pdf':
                                $img = "../../assets/img/img/icon-pdf.png";
                                break;
    
                        }
                    }else{
                        $img = "../../assets/img/img/icon-unknow.png";
                    }
                    ?>
                        <div class="card ">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="<?=$img?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="col-md-9">
                                        <h6 class="title"><?=$basename?></h6>
                                        <label for="" class="card-label">
                                            <em>
                                                <i class="nc-icon nc-cloud-download-93"></i>
                                                click to download
                                            </em>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div >
                            <a class="stretched-link" href="download.php?file=<?=$files[$x]?>"></a>
                            </div>
                        </div>
                    <?php
                    // print '» <a href="download.php?file='.$files[$x].'">'.ucwords($files[$x]).'</a><br/>';
                }
            }
    
        ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if($jumlah_file>$page){
                echo '<div> </div>';
                if($pg>1){
                    echo '<a href="?page='.($pg-1).'">« Prev</a>';
                }
                if($pg<$jumlah_page){
                    echo ' | <a href="?page='.($pg+1).'">Next »</a>';
                }
            }
            ?>
        </div>
    </div>
    <?php
//footer
    include_once("../footer.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
	

?>