
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
// halaman khusus untuk kordinator area
//redirect ke halaman dashboard index jika sudah ada session

$halaman = "Achievement Area";
if(isset($_SESSION['user'])){

    include("../header.php");
    if($level >=1 && $level <=8){
        ?>
        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-user card-plain">
                            <div class="sticker">
                                
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                        <!--  -->
                                        <li class="nav-item ">
                                            <a class="btn  btn-link btn-round btn-info org navigasi-absensi active data-active"  data-toggle="tab" data-id="mp" href="#mp" role="tab" aria-expanded="true"></i>MP Movement</a>
                                        </li>
                                        
                                        <li class="nav-item ">
                                            <a class="btn  btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="at" href="#at" role="tab" aria-expanded="true">Attendance Rate</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="sc" href="#sc" role="tab" aria-expanded="true">Salary Cost</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="ot" href="#ot" role="tab" aria-expanded="true">Overtime Cost</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                    <h5 class="title">Area</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group ">
                                            <input type="text" class="form-control datepicker" data-date-format="YYYY-MM-DDD">
                                            <input type="text" disabled class="form-control text-center" value="to" style="max-width:50px">
                                            <input type="text" class="form-control datepicker" data-date-format="YYYY-MM-DDD">
                                            
                                            
                                            <div class="input-group-append ">
                                                <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="py-0 mx-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group no-border">
                                            <select class="form-control" name="div" id="s_div">
                                                <option value="">Pilih Divisi</option>
                                            </select>
                                            <select class="form-control" name="dept" id="s_dept">
                                                <option value="">Pilih Department</option>
                                                <option value="" disabled>Pilih Division Terlebih Dahulu</option>
                                            </select>
                                            <select class="form-control" name="section" id="s_section">
                                                <option value="">Pilih Section</option>
                                                <option value="" disabled>Pilih Department Terlebih Dahulu</option>
                                            </select>
                                            <select class="form-control" name="groupfrm" id="s_goupfrm">
                                                <option value="">Pilih Group</option>
                                                <option value="" disabled>Pilih Section Terlebih Dahulu</option>
                                            </select>
                                            <select class="form-control" name="shift" id="s_shift">
                                                <option value="">Pilih Shift</option>
                                                <?php
                                                    $query_shift = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                                    if(mysqli_num_rows($query_shift)>0){
                                                        while($data = mysqli_fetch_assoc($query_shift)){
                                                            ?>
                                                            <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="">Belum Ada Data Shift</option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <select class="form-control" name="deptacc" id="s_deptAcc">
                                                <option value="">Pilih Department Administratif</option>
                                                <?php
                                                    $q_div = mysqli_query($link, "SELECT `id`,`nama_org`,`cord`,`nama_cord` FROM `view_cord_area` WHERE `part` = 'deptAcc'")or die(mysqli_error($link));
                                                    if(mysqli_num_rows($q_div) > 0){
                                                        while($data = mysqli_fetch_assoc($q_div)){
                                                        ?>
                                                        <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                                        <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="">Belum Ada Data Department Administratif</option>
                                                        <?php
                                                    }
                                                ?>
                                                </select>
                                            <div class="input-group-append ">
                                                <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
// $today = date('Y-m-d');

// print_r($data_tanggal);
$q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
$q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
$q_div = mysqli_query($link, $q_div )or die(mysqli_error($link));
$shift =  (isset($_GET['shift']) && $_GET['shift'] != '')?" AND absensi.shift = '$_GET[shift]' ":'';
$org_shift =  (isset($_GET['shift']) && $_GET['shift'] != '')?" AND shift = '$_GET[shift]' ":'';
// echo mysqli_num_rows($q_div);


?>
        <!-- divisi efficiency -->
        <div class="col-md-12">
            <div class="card card-plain">
                
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="load_data"></div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else{
            include_once("../no_access.php");
        }

    //footer
    include_once("../footer.php");
    ?>
    <script>
    dataActive()
    function dataActive(){
        
        $.ajax({
            url:"achievement/monitor.php",
            method:"GET",
            data:{data:'mp'},
            success:function(data){
                $('#load_data').fadeOut('fast', function(){
                    $(this).html(data).fadeIn('fast');
                });
                // $('#data-monitoring').html(data)
            }
        })
    }
    </script>
    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>