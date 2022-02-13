<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/approval_system.php");

//redirect ke halaman dashboard index jika sudah ada session

$halaman = "Daftar Man Power";
if(isset($_SESSION['user'])){

    include("../header.php");
    if($level >=1 && $level <=8){

            $shift = array('DAY', 'NIGHT');
            $groupShift = 'A';
            // hitung jumlah group shift
            $jmlShift = 3 ;
            // hirung jumlah hari
            $jmlHari = 21;
            // hitung schema perulangan
            $schema = 7; //peganitan shift setiap 7 hari
            
        // }
    
        // include("../manpower/filter.php"); 
        ?>
        <form action="proses.php" method="GET">
            <div id="view_data"></div>
        </form>
        
        <?php
        $jam = date('H');
        if($jam >= 0 && $jam <= 11){
            $selamat = "Selamat Pagi";
        }else if($jam >= 11 && $jam <= 15 ){
            $selamat = "Selamat Siang";
        }else if($jam >= 16 && $jam <= 18 ){
            $selamat = "Selamat Sore";
        }else if($jam >= 19 && $jam <= 23 ){
            $selamat = "Selamat Malam";
        }

        $filter = '';
        $div_filter = '';
        // echo $div;
        $dept_filter = '';
        // echo $dept_filter;
        $sect_filter = '';
        // echo $sect_filter;
        $group_filter = '';
        // echo $group_filter;
        $deptAcc_filter = '';
        // echo $deptAcc_filter;
        $shift = '';
        // echo $shift;
        $cari = '';
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT 
            view_organization.npk,
            view_organization.nama,
            view_organization.tgl_masuk,
            view_organization.jabatan,
            view_organization.shift,
            view_organization.pos,
            view_organization.status,
            view_organization.pos,
            view_organization.groupfrm,
            view_organization.section,
            view_organization.dept,
            view_organization.subpos,
            view_organization.division,
            view_organization.dept_account
            
            FROM view_organization ";
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        $addPermanent = " AND `status` = 'P' AND jabatan = 'TM' ";
        $addK1 = " AND `status` = 'C1' AND jabatan = 'TM' ";
        $addK2 = " AND `status` = 'C1' AND jabatan = 'TM' ";
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org);
        // echo $add_filter."<br>";
        // echo $access_org."<br>";
        // echo $data_access."<br>";
        // echo $field_request."<br>";
        // echo $table_field1."<br>";
        // echo $table_field2."<br>";
        // echo $part."<br>";
        // echo $generate."<br>";
        // echo $queryMP."<br>";

        ?>
        
        <div class="jumbotron jumbotron-fluid bg-white" style="height:200px;background-image:linear-gradient(to bottom, rgba(244,243,239, 1) 20%, rgba(244,243,239, 0) 80%) , url(../../assets/img/bg/header_otomotif.jpg);background-size: cover;background-attachment:fixed">
            <div class="container " >
                
            </div>
        </div>
        <div class="row" style="margin-top:-200px">
            <div class="col-md-4" >
                <div class="row" style="margin-top:115px">
                    <div class="col-md-12 pl-5">
                        <div class="card card-user " >
                            <div class="card-body">
                                <div class="author">
                                    <a href="#">
                                        <img class="avatar border-gray" src="<?=$base64?>" alt="...">
                                        <h5 class="title text-uppercase"><?=$namaUser?></h5>
                                    </a>
                                    <p class="description">
                                        Coordinator UB Pick Up
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ">
                <div class="row ">
                    <div class="col-md-12 pr-5">
                        
                        <div class="row ">
                            <div class="col-md-12 ">
                                
                                <div class="owl-carousel ">
                                    <!-- <div class="col-lg-4 col-md-6 col-sm-6"> -->
                                        <div class="card card-stats  text-white" style="background:#D2D2D2">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-warning border-right">
                                                            <i class="fa fa-divhead"> </i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Division Head</p>
                                                            <p class="card-title stretched-link"> MP</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="dh"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6" > -->
                                        <div class="card card-stats  text-white" style="background:#FD6C48">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-warning border-right">
                                                            <i class="fa fa-depthead"> </i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Dept Head</p>
                                                            <p class="card-title"> MP </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="de"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md-4"> -->
                                        <div class="card card-stats bg-info text-white">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-warning border-right">
                                                            <i class="fa fa-secthead"> </i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Section Head</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="sh"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6"> -->
                                        <div class="card card-stats  text-white" style="background:#57E4FA">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-warning border-right">
                                                            <i class="fa fa-foreman"> </i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Foreman</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="fr"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6"> -->
                                        <div class="card card-stats text-white" style="background:#F1DB68">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-white border-right">
                                                        <i class="fa fa-leader"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Team leader</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="tl"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md-4 "> -->
                                        <div class="card card-stats bg-danger text-white ">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-white border-right">
                                                            <i class="fa fa-permanent"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Permanent</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="p"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 "> -->
                                        <div class="card card-stats text-white bg-primary" >
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-white border-right">
                                                            <i class="fa fa-kontrak2"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Kontrak 2</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="k2"></a>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6"> -->
                                        <div class="card card-stats bg-success text-white">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-5 col-md-4">
                                                        <div class="icon-big text-center icon-white border-right">
                                                            <i class="fa fa-kontrak1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="numbers">
                                                            <p class="card-category text-white">Kontrak 1</p>
                                                            <p class="card-title"> MP
                                                            <p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="" class="stretched-link view_data" id="k1"></a>
                                            </div>
                                        </div>
                                    <!-- </div> -->

                                </div>
                            </div>
                        </div>
                        <div class="row mt-0">

                            <div class="col-md-12 mt-0">
                                <div class="card ">
                                    <div class="card-body">
                                    <p class="card-category mb-0">Hi, <?=$nick?> , <?=$selamat?>!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="text-uppercase title mb-0">Jalur Under Body</h4>
                                            </div>
                                            <div class="col-md-6 text-right pt-4 mb-0">
                                                <a  href="" class="btn btn-sm btn-success mb-0"> + Register Organisasi</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-full-width">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Area</th>
                                                        <th>Jml Emp</th>
                                                        <th>FRM</th>
                                                        <th>TL</th>
                                                        <th>TM</th>
                                                        <th>TM K1</th>
                                                        <th>TM K2</th>
                                                        <th>TM P</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Team 1</td>
                                                        <td>30</td>
                                                        <td>0</td>
                                                        <td>1</td>
                                                        <td>30</td>
                                                        <td>10</td>
                                                        <td>10</td>
                                                        <td>10</td>
                                                        <td class="text-right">
                                                            <a  href="" class="btn btn-sm btn-success">Detail</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Area Tidak Terdaftar</td>
                                                        <td>30</td>
                                                        <td>0</td>
                                                        <td>1</td>
                                                        <td>30</td>
                                                        <td>10</td>
                                                        <td>10</td>
                                                        <td>10</td>
                                                        <td class="text-right">
                                                            <a  href="" class="btn btn-sm btn-success">Detail</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h5 class="title col-md-6">Daftar Man Power</h5>
                            <div class="col-md-6 ">
                                <div class="my-2 mr-2 float-right order-3">
                                    <div class="input-group bg-transparent">
                                        <input type="text" name="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." id="cari">
                                        <div class="input-group-append bg-transparent">
                                            <div class="input-group-text bg-transparent">
                                                <i class="nc-icon nc-zoom-split"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
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
                                                    <option value="<?=$data['id_shift']?>"><?=$data['shift']?> - <?=$data['id_shift']?></option>
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
                            <div class="col-md-12" id="data-monitoring">
                                <div class="table-responsive" style="height:200">
                                    <table class="table table-striped table-hover text-nowrap" id="table_mp">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">NPK</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Jabatan</th>
                                                <th scope="col">Tanggal Masuk</th>
                                                <th scope="col">Shift</th>
                                                <th scope="col">Area / Pos</th>
                                                <th scope="col">Group</th>
                                                <th scope="col">Section</th>
                                                <th scope="col">Dept</th>
                                                <th scope="col">Dept Adm</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">
                                                    <input type="checkbox" name="select_all" id="select_all" value="">
                                                </th>
            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td colspan="14" class="text-center"><?=noData()?></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else{
            include_once ("../no_access.php");
        }

    
    //footer
        include_once("../footer.php");
        ?>
        <script>
            $(document).ready(function(){
                load_data();
                function load_data(page){
                    var div_id = $('#s_div').val();
                    var dept_id = $('#s_dept').val();
                    var section_id = $('#s_section').val();
                    var group_id = $('#s_goupfrm').val();
                    var deptAcc_id = $('#s_deptAcc').val();
                    var shift = $('#s_shift').val();
                    var cari = $('#cari').val();
                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    var att_type = $('#att_type').val();
                    $.ajax({
                        url:"../manpower/ajax/index.php",
                        method:"GET",
                        data:{page:page,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,filter:'yes'},
                        success:function(data){
                            $('#data-monitoring').fadeOut('fast', function(){
                                $(this).html(data).fadeIn('fast');
                            });
                        }
                    })
                }
                $(document).on('click', '.halaman', function(){
                    var page = $(this).attr("id");
                    load_data(page);
                });

                function success(data1,data2){

                    Swal.fire({
                        title: data1,
                        text: data2,
                        timer: 2000,
                        
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                }
                
                $(document).on('click', '.request', function(e){
                    e.preventDefault();
                    var getLink = $(this).attr('href');
                    var data = $(this).attr('data-id')
                    var page = $('.page_active').attr('id')
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "pengajuan ini akan diproses",
                        icon: false,
                        showCancelButton: true,
                        confirmButtonColor: '#27AE60',
                        cancelButtonColor: '#B2BABB',
                        confirmButtonText: 'Request!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url:getLink,
                                method:"GET",
                                data:{request:data},
                                success:function(){
                                    load_data(page)
                                    getSumary()
                                    success('Diajukan','data pengajuan dibuat untuk dilanjutkan');
                                }
                            })
                        }
                    })
                        
                });
                $('#filterGo').on('click', function(){
                    load_data()
                    getSumary()
                })
                $('#cari').on('keyup', function(){
                    load_data()
                    getSumary()
                
                });
                $('#att_type').on('change', function(){
                    load_data()
                    getSumary()
                });
            
                    
                function getSumary(){
                    var div_id = $('#s_div').val();
                    var dept_id = $('#s_dept').val();
                    var section_id = $('#s_section').val();
                    var group_id = $('#s_goupfrm').val();
                    var deptAcc_id = $('#s_deptAcc').val();
                    var shift = $('#s_shift').val();
                    var cari = $('#cari').val();
                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    var att_type = $('#att_type').val();
                    $.ajax({
                        url: 'ajax/sumary.php',	
                        method: 'GET',
                        data:{start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,att_type:att_type,filter:'yes'},		
                        success:function(data){
                            $('#sumary').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                            
                        }
                    });
                }
                getSumary()
                function getDiv(){
                    var data = $('#s_div').val()
                    $.ajax({
                        url: '../manpower/ajax/get_div.php',	
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
                        url: '../manpower/ajax/get_dept.php',	
                        method: 'GET',
                        data: {data:data},		
                        success:function(data){
                            $('#s_dept').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                            
                        }
                    });
                }
                function getSect(){
                    var data = $('#s_dept').val()
                    $.ajax({
                        url: '../manpower/ajax/get_sect.php',	
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
                        url: '../manpower/ajax/get_group.php',
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

                $('.requestall').on('click', function(e){
                    e.preventDefault();
                    var getLink = 'mass_req.php';

                    document.proses.action = getLink;
                    document.proses.submit();
                });
                

            })
            </script>
            <script>
                $(document).ready(function(){
                var owl = $('.owl-carousel');
                    owl.owlCarousel({
                        items:2,
                        loop:true,
                        margin:30,
                        autoplay:true,
                        autoplayTimeout:3000,
                        autoplayHoverPause:true
                    });
                    owl.on('mousewheel', '.owl-stage', function (e) {
                        if (e.deltaY>0) {
                            owl.trigger('next.owl');
                        } else {
                            owl.trigger('prev.owl');
                        }
                        e.preventDefault();
                    });
                });
            </script>
            <script>
                $(document).ready(function(){
                    
                    $(document).on('click', '#allmp', function(){
                        if(this.checked){
                            $('.mp').each(function() {
                                this.checked = true;
                            })
                        } else {
                            $('.mp').each(function() {
                                this.checked = false;
                            })
                        }

                    });

                    $('.mp').on('click', function() {
                        if($('.mp:checked').length == $('.mp').length){
                            $('#allmp').prop('checked', true)
                        } else {
                            $('#allmp').prop('checked', false)
                        }
                    })
                })
            </script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $(document).on('click', '.view_data', function(){
                        var id = $(this).parents("tr").attr("id");
                        
                        $.ajax({
                            url: '../ajax/view.php',	
                            method: 'post',
                            data: {id:id},		
                            success:function(data){
                                $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                                $('#myView').modal("show");	// menampilkan dialog modal nya
                            }
                        });
                    });
                    $(document).on('click', '.td', function(){
                        var id = $(this).parent('tr').attr("id");
                        
                        
                        $.ajax({
                            url: '../ajax/view.php',	
                            method: 'post',
                            data: {id:id},		
                            success:function(data){
                                $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                                $('#myView').modal("show");	// menampilkan dialog modal nya
                            }
                        });
                    });
                });
                
            </script>
            
         <script>
    //untuk crud masal update department
        function edit() {
            document.prosesdept.action = 'dept/edit.php';
            document.prosesdept.submit();
        }
        function hapus() {            
            var conf = confirm('yakin ingin menghapus data? ');
            if (conf) {
                document.prosesdept.action ='dept/delete.php';
                document.prosesdept.submit();
            }        
        }
    </script>
    <script>
    //untuk data tables

        // $(document).ready(function(){
        //     $('#table_mp').DataTable({
                
        //         columnDefs: [
        //             {
        //                 "searchable": false,
        //                 "orderable": false,
        //                 "targets": [0, ,9, 10]
        //             }
        //         ],
        //         "order": [1,"asc"]
        //     });
        // })
    
    </script>
    <script>
		$(document).ready(function() {
		  $('#searching').on('shown.bs.modal', function() {
			$('#focusInput').trigger('focus');
		  });
		});	
	</script>
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('.view_data').click(function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: '../manpower/detail.php',	
                    method: 'post',
                    data: {id:id},		
                    success:function(data){		
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");	// menampilkan dialog modal nya
                    }
                });
            });
        });
        
    </script>
    
    <!-- <script>
        chartColor = "#FFFFFF";
        ctx = document.getElementById('chartareaorg').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
            labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            datasets: [

                {
                label: "Data",
                borderColor: '#fcc468',
                fill: true,
                backgroundColor: '#fcc468',
                hoverBorderColor: '#fcc468',
                borderWidth: 5,
                data: [100, 120, 80, 100, 90, 130, 110, 100, 80, 110, 130, 140, 130, 120, 130, 80, 100, 90, 120, 130],
                }
            ]
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
            tooltips: {
                tooltipFillColor: "rgba(0,0,0,0.5)",
                tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                tooltipFontSize: 14,
                tooltipFontStyle: "normal",
                tooltipFontColor: "#fff",
                tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                tooltipTitleFontSize: 14,
                tooltipTitleFontStyle: "bold",
                tooltipTitleFontColor: "#fff",
                tooltipYPadding: 6,
                tooltipXPadding: 6,
                tooltipCaretSize: 8,
                tooltipCornerRadius: 6,
                tooltipXOffset: 10,
            },


            legend: {
                display: false
            },
            scales: {

                yAxes: [{
                ticks: {
                    fontColor: "#9f9f9f",
                    fontStyle: "bold",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20
                },
                gridLines: {
                    zeroLineColor: "transparent",
                    display: true,
                    drawBorder: false,
                    color: '#9f9f9f',
                }

                }],
                xAxes: [{
                barPercentage: 0.4,
                gridLines: {
                    zeroLineColor: "white",
                    display: false,

                    drawBorder: false,
                    color: 'transparent',
                },
                ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f",
                    fontStyle: "bold"
                }
                }]
            }
            }
        });
    </script> -->

    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>