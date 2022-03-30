<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "General Information";
    include_once("../header.php");
    $start = date('Y-m-01');
        $end = date('Y-m-t');
?>
<div class="row ">
    <div class="col-md-12">
        
                <?php
                $no = 1;
                $query_info = "SELECT info, publisher, title, category, stats, date_start, date_end, `image` FROM info 
                WHERE (category = 'ext' 
                OR category = 'int' 
                OR category = 'mtc' 
                OR category = 'oth' ) AND `stats` = '1' AND ((date_start BETWEEN '$start' AND '$end') OR (date_end BETWEEN '$start' AND '$end'))";
                $sqlInfo = mysqli_query($link, $query_info)or die(mysqli_error($link));
                if(mysqli_num_rows($sqlInfo)>0){
                    while($dataInfo = mysqli_fetch_assoc($sqlInfo)){
                        $clr = (isset($dataInfo['stats']) && $dataInfo['stats'] == 0)?"muted":"success";
                        $text = (isset($dataInfo['stats']) && $dataInfo['stats'] == 0)?"Not-active":"active";
                        $image = (isset($dataInfo['image']))?$dataInfo['image']:"";
                        $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/$image";
                        $start = (isset($dataInfo['date_start']))?tgl($dataInfo['date_start']):"";
                        $end = (isset($dataInfo['date_end']))?tgl($dataInfo['date_end']):"";
                        $text_color = ($dataInfo['stats'] == 1)?"text-success":"";
                        if(file_exists($path)){
            
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $dataImage = file_get_contents($path);
                            $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
                            $imageSupport = ($image)? $image : "";
                        }else{
                            $imageSupport = base_url()."/assets/img/img/no-image.png";
                        }
                        // echo strlen($dataInfo['info']);
                        
                        $active = ($no == 1)?"active":"";
                        $no++;
                        switch($dataInfo['category']){
                            case "int":
                                $addFilter = " category = 'ext' OR category = 'int' OR category = 'oth' ";
                                $icon = '<i class="fas fa-bullhorn"></i>';
                                $text_close = "";
                                $text_publish = "published";
                                $close_date = 0;
                                break;
                            case "ext":
                                $addFilter = " category = 'ext' OR category = 'int' OR category = 'oth' ";
                                $icon = '<i class="fas fa-bullhorn"></i>';
                                $text_close = "";
                                $text_publish = "published";
                                $close_date = 0;
                                break;
                            case "oth":
                                $addFilter = " category = 'ext' OR category = 'int' OR category = 'oth' ";
                                $icon = '<i class="fas fa-bullhorn"></i>';
                                $text_close = "";
                                $text_publish = "published";
                                $close_date = 0;
                                break;
                            case "mtc":
                                $addFilter = " category = 'ext' OR category = 'int' OR category = 'oth' ";
                                $icon = '<i class="far fa-bell"></i>';
                                $text_close = "";
                                $text_publish = "published";
                                $close_date = 0;
                                break;
                            
                        }
                        
                        ?>
                        
                        <!--  -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?=$imageSupport?>" alt="" style="width:100%; overflow:hidden">
                                            </div>
                                            <div class="col-md-8">
                                                
                                                
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <ul class="list-unstyled team-members col-md-12">
                                                                        <li>
                                                                            <div class="row">
                                                                                <div class="col-md-9 col-9 pr-0">
                                                                                    <div class="icon <?=$text_color?>">
                                                                                        <?=$icon?>
                                                                                    </div>
                                                                                    <h5 class="text-uppercase mb-0 <?=$text_color?> title">
                                                                                        <?=$dataInfo['title']?>
                                                                                    </h5>
                                                                                    <span class="legend card-category mb-0 pb-0 mt-3 mr-4">
                                                                                        <i class="fa fa-circle text-<?=$clr?>"></i>
                                                                                        <span class="category"><?=$text?></span>
                                                                                    </span>
                                                                                    <span class="legend mr-4 card-category mb-0 pb-0 mt-3 ">
                                                                                        <i class="fa fa-calendar text-category"></i>
                                                                                        <span class="category"> created : <?=$start?></span>
                                                                                    </span>
                                                                                    <?php
                                                                                    if($close_date == 1){
                                                                                        ?>
                                                                                        <span class="legend border-left pl-4 card-category mb-0 pb-0 mt-3 ">
                                                                                            <span class="category"><?=$text_close?> : <?=$end?></span>
                                                                                        </span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="col-md-3 col-3 mx-0 px-0 text-right mb-0 pb-0">
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    
                                                                    </ul>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="card-text">
                                                            <?=$dataInfo['info']?>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="card-text">
                                                            <div class="row">
                                                                
                                                                <div class="col-md-6 col-6">
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-2">
                                                                            <div class="avatar">
                                                                                <img src="<?=getFoto($dataInfo['publisher'])?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10 col-10 mx-0 px-0 mt-0">
                                                                            <label for=""><?=$text_publish?>: <br> 
                                                                            <strong>
                                                                                <?php
                                                                                $updater = mysqli_query($link, "SELECT nama , npk FROM karyawan WHERE npk = '$dataInfo[publisher]' ")or die(mysqli_error($link));
                                                                                $dataUpdater = mysqli_fetch_assoc($updater);
                                                                                $namaUpdater = (isset($dataUpdater['nama']))?"$dataUpdater[npk] ".nick($dataUpdater['nama']):'';
                                                                                ?>
                                                                            <?=$namaUpdater?>
                                                                            </strong>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="text-muted text-uppercase"> -- Informasi Belum Pernah Dibuat -- </p>
                        </div>
                    </div>
                    
                    <?php
                }
                ?>
           
    </div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../footer.php");
    //javascript
    ?>
    <script>
    //untuk crud masal update department

    $('.remove').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Data Akan Dihapus Permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                document.proses.action = getLink;
                document.proses.submit();
            }
        })
        
    });
    </script>
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
