
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
    
    $startDate = date('Y-m-01');
    $endDate = date('Y-m-t');
    if($level >=1 && $level <=8){
        ?>
        
        <div class="row ">
            <div class="col-md-3 position-sticky" >
                <!-- <div class="card card-plain" >  -->
                    <div class="nav-tabs-wrapper "  data-spy="affix" data-offset-top="205" >
                        <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left "   role="tablist">
                            <!--  -->
                            <li class="nav-item w-100">
                                <a class="btn  btn-link btn-round btn-info org navigasi-absensi "  data-toggle="tab" data-id="mp" href="#mp" role="tab" aria-expanded="true">
                                <i class="nc-icon nc-circle-10"></i>  
                                Employee Movement</a>
                            </li>
                            
                            <li class="nav-item ">
                                <a class="btn  btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="at" href="#at" role="tab" aria-expanded="true">Attendance Rate</a>
                            </li>
                            <li class="nav-item ">
                                <a class="btn btn-link btn-round btn-info org navigasi-absensi active data-active"  data-toggle="tab" data-id="ot" href="#ot" role="tab" aria-expanded="true">Overtime Achievement</a>
                            </li>
                            <li class="nav-item ">
                                <a class="btn btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="sc" href="#sc" role="tab" aria-expanded="true">Request Overview</a>
                            </li>
                            
                        </ul>
                    </div>
               <!-- </div> -->
            </div> 
            <div class="col-md-9 ">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <h5 class="title title-page">Area</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group no-border">
                                    <input type="text" class="form-control datepicker" id="start_date" data-date-format="YYYY-MM-DD" value="<?=$startDate?>">
                                    <input type="text" disabled class="form-control text-center"  value="to" style="max-width:50px">
                                    <input type="text" class="form-control datepicker" data-date-format="YYYY-MM-DD" id="end_date" value="<?=$endDate?>">
                                    
                                    
                                    <div class="input-group-append ">
                                        <span id="filterDate" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
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
                                    
                                    <div class="input-group-append ">
                                        <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 spinner_load " style="display:none">
                                <div class="card shadow-none">
                                    <div class="card-body " style="background-image: linear-gradient(to right, rgb(255,255,255), rgb(244,243,239)  ,rgb(255,255,255));">
                                        <div class="text-center" >
                                            <img id="img-spinner" src="../../assets/img/loading/load.gif" style="height:50px">
                                            <label class="label">please be patient , your request is being downloaded and may take a minutes...</label>
                                        </div>
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
        <?php
        }else{
            include_once("../no_access.php");
        }

    //footer
    include_once("../footer.php");
    ?>
    <script>
        $(document).ready(function(){
            function getDiv(){
                console.log("tes");
                var data = $('#s_div').val()
                $.ajax({
                    url: '../absensi/ajax/get_div.php',
                    method: 'GET',
                    data: {data:data},		
                    
                    success:function(data){

                        $('#s_div').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        
                    }
                });
            }
            function getDept(){
                var data = $('#s_div').val()
                $.ajax({
                    url: '../absensi/ajax/get_dept.php',	
                    method: 'GET',
                    data: {data:data},
                    success:function(data){
                        $('#s_dept').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        // console.log(data)
                    }
                });
            }
            function getSect(){
                var data = $('#s_dept').val()
                $.ajax({
                    url: '../absensi/ajax/get_sect.php',	
                    method: 'GET',
                    data: {data:data},		
                    success:function(data){
                        $('#s_section').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        
                    }
                });
            }
            function getGroup(){
                var data = $('#s_section').val()
                $.ajax({
                    url: '../absensi/ajax/get_group.php',
                    method: 'GET',
                    data: {data:data},
                    success:function(data){
                        $('#s_goupfrm').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                });
            }
            getDiv()
            $('#s_div').on('change', function(){
                getDept()
                getSect()
                getGroup()
            })
            $('#s_dept').on('change', function(){
                getSect()
                getGroup()
            })
            $('#s_section').on('change', function(){
                getGroup()
            })
            
        dataActive()
        $(document).on('click','.navigasi-absensi', function(){
            $('.navigasi-absensi').removeClass('data-active');
            $(this).addClass('data-active');
            dataActive()
        });
        function dataActive(){
            if($(".data-active")[0]){
                var title = $('.data-active').text();
                $('.title-page').text(title);
                var div_id = $('#s_div').val();
                var dept_id = $('#s_dept').val();
                var section_id = $('#s_section').val();
                var group_id = $('#s_goupfrm').val();
                var deptAcc_id = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                
                var cari = $('#cari').val();
    
                var id = $('.data-active').attr('data-id');
                if(id == 'mp'){
                    var url = "achievement/monitor.php"; 
                }else if(id == 'at'){
                    var url = "achievement/monitor-attendance.php"; 
                }else if(id == 'sc'){
                    var url = "achievement/monitor-salary.php"; 
                }else if(id == 'ot'){
                    var url = "achievement/monitor-overtime.php"; 
                }
                $.ajax({
                    url:url,
                    method:"GET",
                    data:{data:'mp',div_id : div_id, dept_id : dept_id, section_id:section_id,group_id:group_id,deptAcc_id:deptAcc_id,shift:shift,start:start,end:end},
                    beforeSend:function(){$(".spinner_load").css("display","block").fadeIn('slow');},
                    success:function(data){
                        // $('#load_data').fadeOut('fast', function(){
                        //     $(this).html(data).fadeIn('fast');
                        // });
                        $('#load_data').html(data)
                        $(".spinner_load").css("display","none")
                    }
                })
            }
        }
        $('#filterGo').on('click', function(){
            dataActive();
        })
        $('#filterDate').on('click', function(){
            dataActive();
        })
    })
    </script>
    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
//view_organization_mp
"select count(`view_organization`.`npk`) AS `jml_mp`,`view_organization`.`shift` AS `shift`,`view_organization`.`id_sub_pos` AS `id_sub_pos`,`view_organization`.`id_post_leader` AS `id_post_leader`,`view_organization`.`id_grp` AS `id_grp`,`view_organization`.`id_sect` AS `id_sect`,`view_organization`.`id_dept` AS `id_dept`,`view_organization`.`id_dept_account` AS `id_dept_account`,`view_organization`.`id_division` AS `id_division`,`view_organization`.`id_plant` AS `id_plant` from `bais_db`.`view_organization` group by `view_organization`.`shift`,`view_organization`.`id_sub_pos`,`view_organization`.`id_post_leader`,`view_organization`.`id_grp`,`view_organization`.`id_sect`,`view_organization`.`id_dept`,`view_organization`.`id_dept_account`,`view_organization`.`id_division`,`view_organization`.`id_plant`";
//view_prod_overtime
"select `bais_db`.`working_days`.`date` AS `date`,sum(`view_req_ot_bulk`.`jml_ot`) AS `jm_ot`,count(`view_req_ot_bulk`.`mp_ot`) AS `jm_mp`,`bais_db`.`working_days`.`id` AS `id`,`bais_db`.`working_days`.`wh` AS `wh`,`bais_db`.`working_days`.`shift` AS `shift`,`bais_db`.`working_days`.`ket` AS `ket`,`bais_db`.`working_days`.`break_id` AS `break_id`,`view_req_ot_bulk`.`sub_post` AS `sub_post`,`view_req_ot_bulk`.`post` AS `post`,`view_req_ot_bulk`.`grp` AS `grp`,`view_req_ot_bulk`.`sect` AS `sect`,`view_req_ot_bulk`.`dept` AS `dept`,`view_req_ot_bulk`.`dept_account` AS `dept_account`,`view_req_ot_bulk`.`division` AS `division`,`view_req_ot_bulk`.`plant` AS `plant` from (`bais_db`.`working_days` left join (select `view_req_ot_bulk`.`npk` AS `npk`,sum(`view_req_ot_bulk`.`over_time`) AS `jml_ot`,count(`view_req_ot_bulk`.`npk`) AS `mp_ot`,`view_req_ot_bulk`.`work_date` AS `work_date`,`view_req_ot_bulk`.`sub_post` AS `sub_post`,`view_req_ot_bulk`.`post` AS `post`,`view_req_ot_bulk`.`grp` AS `grp`,`view_req_ot_bulk`.`sect` AS `sect`,`view_req_ot_bulk`.`dept` AS `dept`,`view_req_ot_bulk`.`dept_account` AS `dept_account`,`view_req_ot_bulk`.`division` AS `division`,`view_req_ot_bulk`.`plant` AS `plant` from `bais_db`.`view_req_ot_bulk` group by `view_req_ot_bulk`.`npk`,`view_req_ot_bulk`.`work_date`,`view_req_ot_bulk`.`sub_post`,`view_req_ot_bulk`.`post`,`view_req_ot_bulk`.`grp`,`view_req_ot_bulk`.`sect`,`view_req_ot_bulk`.`dept`,`view_req_ot_bulk`.`dept_account`,`view_req_ot_bulk`.`division`,`view_req_ot_bulk`.`plant`) `view_req_ot_bulk` on(`view_req_ot_bulk`.`work_date` = `bais_db`.`working_days`.`date`)) group by `bais_db`.`working_days`.`date`,`view_req_ot_bulk`.`sub_post`,`view_req_ot_bulk`.`post`,`view_req_ot_bulk`.`grp`,`view_req_ot_bulk`.`sect`,`view_req_ot_bulk`.`dept`,`view_req_ot_bulk`.`dept_account`,`view_req_ot_bulk`.`division`,`view_req_ot_bulk`.`plant`";
//view_karyawan_record
"select `working_days`.`date` AS `date`,`bais_db`.`karyawan_record`.`mp` AS `mp`,`bais_db`.`karyawan_record`.`id_area` AS `id_area`,`bais_db`.`karyawan_record`.`part` AS `part`,`bais_db`.`karyawan_record`.`id_jabatan` AS `id_jabatan`,`bais_db`.`karyawan_record`.`nama_area` AS `nama_area`,`bais_db`.`karyawan_record`.`id_dept_account` AS `id_dept_account` from ((select `bais_db`.`working_days`.`date` AS `date` from `bais_db`.`working_days` group by `bais_db`.`working_days`.`date`) `working_days` left join `bais_db`.`karyawan_record` on(`bais_db`.`karyawan_record`.`date` = `working_days`.`date`))";
?>