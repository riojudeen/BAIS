<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
require_once("../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    if($level < 6){
        $addFilterNpk = "publisher = '$npkUser' ";
        $title_card = "Support Ticket";
    }else{
        $addFilterNpk ="";
        $title_card = "Information Management";
    }
    $filterNpk = ($addFilterNpk != '')?" AND $addFilterNpk":"";
    // echo $_GET['data'];
    if(isset($_GET['data'])){
        switch($_GET['data']){
            case "nav-general":
                $addFilter = " category = 'ext' OR category = 'int' OR category = 'oth' ";
                $icon = '<i class="fas fa-bullhorn"></i>';
                $text_close = "";
                $text_publish = "published";
                
                $close_date = 0;
                break;
            case "nav-support":
                $addFilter = " category = 'report' ";
                $icon = '<i class="fas fa-ticket-alt"></i>';
                $text_close = "solved date";
                $text_publish = "reported";
                $close_date = 1;
                break;
            case "nav-notif":
                $addFilter = " category = 'at' OR category = 'ot' OR category = 'mtc' ";
                $icon = '<i class="far fa-bell"></i>';
                $text_close = "";
                $text_publish = "created";
                $close_date = 0;
                break;
            case "nav-holiday":
                $addFilter = " category = 'holidays' ";
                $icon = '<i class="fas fa-umbrella-beach"></i>';
                $text_close = "";
                $text_publish = "created";
                $close_date = 0;
                break;
        }
    }
    $addFilter = ($addFilter != '')?" WHERE ($addFilter) ".$filterNpk:"";
    $noInfo = 1;
    $query = "SELECT * FROM info ".$addFilter;
    
    $sql_jml = mysqli_query($link, $query)or die(mysqli_error($link));
    $total_records= mysqli_num_rows($sql_jml);
    // echo $total_records;

    $page = (isset($_GET['page']))? $_GET['page'] : 1;
    // echo $page;
    $limit = 100; 
    $limit_start = ($page - 1) * $limit;
    $no = $limit_start + 1;
    // echo $limit_start;
    $addOrder = " ORDER BY id DESC";
    $addLimit = " LIMIT $limit_start, $limit";
    // $no = 1*$page;
                    // echo 
    // pagin
    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
    
    $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
    
    $sqlInfo = mysqli_query($link, $query.$addOrder.$addLimit)or die(mysqli_error($link));
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
            if(strlen($dataInfo['info'])>200){
                $substr = substr($dataInfo['info'], 0, 200)."...";
                $load_more = "1";
            }else{
                $substr = $dataInfo['info'];
                $load_more = "0";
            }
            ?>
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
                                                                <span class="form-check ">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="<?=$dataInfo['id']?>">
                                                                        <span class="form-check-sign"></span>
                                                                    </label>
                                                                </span>
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
                                        <?=$substr?>
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
                                            <div class="col-md-6 col-6 mt-0 text-right">
                                                                
                                                <a href="proses/prosesInfo.php?del=<?=$dataInfo['id']?>" class="btn-round btn btn-outline-danger btn-icon btn-sm remove"><i class="fa fa-trash"></i></a>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" row">
                <div class="col-12">
                    
                    <div style="box-shadow: inset 1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:1rem; margin-right:-2rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                    class=" pull-right btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <!-- Monitoring Absensi & Lembur -->
                        <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                    </div>
                    <div style="box-shadow: inset -1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:1rem; margin-left:-2rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                    class=" pull-left btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <!-- Filter -->
                        <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                    </div>
                    <hr style="border: 3px dashed #F4F3EF; margin-top:2rem;">
                    
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
    <div class="row">
        <div class="col-md-6">
            <ul class="pagination ">
            <?php
            // echo $page."<br>";
            // echo $jumlah_page."<br>";
            // echo $jumlah_number."<br>";
            // echo $start_number."<br>";
            // echo $end_number."<br>";
            if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" >First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item halaman" id="1"><a class="page-link" >First</a></li>';
                echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active page_active' : '';
                echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
            }

            if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
            } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
            }
            ?>
            </ul>
        </div>
        
    </div>
    <?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

