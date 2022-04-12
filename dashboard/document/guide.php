<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Operational Guidance";
if(isset($_SESSION['user'])){

    include("../header.php");
    $query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'GUIDE' ")or die(mysqli_error($link));
            $sql_dir = mysqli_fetch_assoc($query_dir);
            $root_path = $sql_dir['root'];
    $dir = $root_path;
    if(file_exists($dir)){

    $getStart =$dir."Getting Started.ppsx";
    $files = array();
    $open    =opendir($dir) or die('Folder tidak ditemukan ...!');
    while ($file    =readdir($open)) {
        if($file !='.' && $file !='..'){   
            // $files[]=$file;
            array_push($files, $file);
        }
    }
    $jml = count($files);
    // echo $jml;
    
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 float-right text-right" >
                                    <ul class="nav nav-pills  nav-pills-primary nav-pills-icons justify-content-center" role="tablist">
                                        
                                        <li class="nav-item">
                                            <a class="nav-link nav-port " data-toggle="tab" id="nav-start"  href="#link8" role="tablist">
                                            <i class="nc-icon nc-box"></i> | 
                                            Getting Started!
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-port " data-toggle="tab" id="nav-dashboard"  href="#link8" role="tablist">
                                            <i class="nc-icon nc-box"></i> | 
                                            Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-port " data-toggle="tab" id="nav-org"  href="#link8" role="tablist">
                                            <i class="nc-icon nc-box"></i> | 
                                            Organization
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-port " data-toggle="tab" id="nav-attendance"  href="#link8" role="tablist">
                                            <i class="nc-icon nc-box"></i> | 
                                            Attendance
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link nav-port port-active " id="nav-overtime" data-toggle="tab" href="#link9" role="tablist">
                                            <i class="nc-icon nc-touch-id"></i> | 
                                            Overtime
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link nav-port port-active " id="nav-administrator" data-toggle="tab" href="#link9" role="tablist">
                                            <i class="nc-icon nc-touch-id"></i> | 
                                            Control Setings
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link nav-port port-active " id="nav-document" data-toggle="tab" href="#link9" role="tablist">
                                            <i class="nc-icon nc-touch-id"></i> | 
                                            Documents & Forms
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body mx-0 px-0 bg-info ">
                    <div class="row ">
                        <div class="col-md-12 load-info">
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
                        </div>

                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <label for=""><< Swipe left</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
//footer
    
    }else{
        ?>
        <div class="row">
            <div class="col-md-12">
                <p>Halaman Tidak Didukung Karena Tidak Terhubung Ke Intranet</p>
            </div>
        </div>
        <?php
    }
    include_once("../footer.php");
    ?>
    <script>
            $(document).ready(function(){
                
                $('.nav-port').on('click', function(){
                    var data = $(this).attr('id');
                    $.ajax({
                        url : "load-info.php",
                        method: "GET",
                        data: {data:data},
                        success:function(data){
                            $('.load-info').fadeOut('fast', function(){
                                $(this).html(data).fadeIn('fast');
                            });
                        }

                    })
                })
                
            });
        </script>
    <?php
    include_once("../endbody.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
	

?>