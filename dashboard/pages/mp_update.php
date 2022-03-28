
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/approval_system.php");
// halaman khusus untuk kordinator area
//redirect ke halaman dashboard index jika sudah ada session

$halaman = "Daftar Man Power";
if(isset($_SESSION['user'])){

    include("../header.php");
    if($level >=1 && $level <=8){
        $cek_area = mysqli_query($link, "SELECT cord FROM view_daftar_area WHERE cord = '$npkUser' AND part <> 'pos' ")or die(mysqli_error($link));
        // echo mysqli_num_rows($cek_area);
        // if(mysqli_num_rows($cek_area) > 0){

            if(isset($_GET['org'])){
                // jika akses dari admin
                $q_area_cord = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = '$_GET[part]' AND id = '$_GET[org]' ")or die(mysqli_error($link));
                $data_area = mysqli_fetch_assoc($q_area_cord);
                // $npk = $data_area['cord'];
                // Echo $npk;
                $npk = $data_area['cord'];
                $q_user_level = mysqli_query($link, "SELECT user_role.role_name AS 'name', user_role.level AS 'level' FROM data_user JOIN user_role ON user_role.id_role = data_user.level WHERE data_user.npk = '$npk' ")or die(mysqli_error($link));
                $datalevel = mysqli_fetch_assoc($q_user_level);
                $level = $datalevel['level'];
                $part = $_GET['part'];
                $data_access = $_GET['org'];
                $npkCord = $data_area['cord'];

                $sect_filter = ($part == 'section')?" AND id_sect = '$data_access' ":'';
                $group_filter = ($part == 'group')?" AND id_grp = '$data_access'":'';
                
                $stringPart = "part=";
                $headerGroup = " ".getOrgName($link, $data_access, $part)." ";
                // echo $datalevel['level'];
            }else{
                // untuk kordinator area
                $level = $level;
                $part = partAccess($level, "part");
                $npk = $npkUser;
                $data_access = generateAccess($link,$level,$npk);
                // echo $data_access;
                $q_area_cord = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = '$part' AND cord = '$npkUser' ")or die(mysqli_error($link));
                
                // echo mysqli_num_rows($q_area_cord);
                $area = array();
                if(mysqli_num_rows($q_area_cord) > 0){
                    $in = 0;
                    while($data = mysqli_fetch_assoc($q_area_cord)){
                        $area[$in++] = $data['id'];
                        // echo $data['id'];
                    }
                }
                $area_cord = mysqli_query($link, "SELECT * FROM view_cord_area WHERE part = '$part' AND cord = '$npkUser' ")or die(mysqli_error($link));
                $data_area = mysqli_fetch_assoc($area_cord);
                $npkCord = $data_area['cord'];
                $sect_filter = '';
                $group_filter = '';
                
                
                $headerGroup = '';
                foreach($area AS $dataarea){
                    $headerGroup .= " ".getOrgName($link, $dataarea, $part)." & ";
                }
                $headerGroup = substr($headerGroup, 0, -2);
            }
            // echo $npkCord;
            if($npkUser == $npkCord){
                $disabled = ($level == 3)?"":"disabled";
                $mes = "koordinator area";
                $edit = 1;
            }else{
                $disabled = "disabled";
                $mes = "koordinator area";
                $edit = 0;
            }
            
           
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
                view_organization.id_post_leader,
                view_organization.id_grp,
                view_organization.id_sect,
                view_organization.id_dept,
                view_organization.id_sub_pos,
                view_organization.id_division,
                view_organization.id_dept_account,
                view_organization.dept_account
                
                FROM view_organization ";
            $div_filter = '';
            // echo $div;
            $dept_filter = '';
            // echo $dept_filter;
            
            // echo $group_filter;
            $deptAcc_filter = '';
            $add_filter = $sect_filter.$group_filter;
            // echo $data_access_org;
            $access_org = orgAccessOrg($level);
            // echo $access_org;
            $table = partAccess($level, "table");
            $field_request = partAccess($level, "field_request");
            $table_field1 = partAccess($level, "table_field1");
            $table_field2 = partAccess($level, "table_field2");
            
            $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
            // echo $generate;
            // $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
            // echo "$level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access";
            $addTl = " AND  (jabatan = 'TL' OR jabatan = 'ATL')";
            $addFrm = " AND  (jabatan = 'FRM' OR jabatan = 'AFRM')";
            $addSpv = " AND  (jabatan = 'SPV' OR jabatan = 'ASPV')";
            $addMng = " AND  (jabatan = 'MNG' OR jabatan = 'AMNG')";
            $addDh = " AND  (jabatan = 'DH' OR jabatan = 'ADH')";
            $addPermanent = " AND `status` = 'P' AND jabatan = 'TM' ";
            $addK1 = " AND `status` = 'C1' AND jabatan = 'TM' ";
            $addK2 = " AND `status` = 'C2' AND jabatan = 'TM' ";
            $addTtm = " AND jabatan = 'TM' ";
            if($level == 1){
                $addGroup = "";
                $sub = "id_post_leader";
                $sub_part = "pos";
            }else if($level == 2){
                $addGroup = "";
                $sub = "id_post_leader";
                $sub_part = "pos";
            }else if($level == 3){
                $addGroup = "  GROUP BY id_post_leader";
                $sub = "id_post_leader";
                $sub_part = "pos";
            }else if($level == 4){
                $addGroup = "  GROUP BY id_grp";
                $sub = "id_grp";
                $sub_part = "group";
            }else if($level == 5){
                $addGroup = "  GROUP BY id_grp";
                $sub = "id_grp";
                $sub_part = "group";
            }else if($level == 6){
                $addGroup = " GROUP BY id_grp";
                $sub = "id_grp";
                $sub_part = "group";
            }else if($level == 7){
                $addGroup = " GROUP BY id_grp";
                $sub = "id_grp";
                $sub_part = "group";
            }else if($level == 1){
                $addGroup = " GROUP BY id_grp";
                $sub = "id_grp";
                $sub_part = "group";
            }else{
                $addGroup = " GROUP BY groupfrm";
                $sub = "id_grp";
                $sub_part = "group";
            }

            $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter;
            // echo $queryMP;
            // echo $add_filter;
            $sql_group = mysqli_query($link, $queryMP.$add_filter.$addGroup." ORDER by $sub ASC")or die(mysqli_error($link));
            $sql_total_mp = mysqli_query($link, $queryMP.$add_filter)or die(mysqli_error($link));
           
            $permanent = mysqli_query($link, $queryMP.$addPermanent)or die(mysqli_error($link));
            $kontrak1 = mysqli_query($link, $queryMP.$addK1)or die(mysqli_error($link));
            $kontrak2 = mysqli_query($link, $queryMP.$addK2)or die(mysqli_error($link));
            $TM = mysqli_query($link, $queryMP.$addTtm)or die(mysqli_error($link));
            $FRM = mysqli_query($link, $queryMP.$addFrm)or die(mysqli_error($link));
            $TL = mysqli_query($link, $queryMP.$addTl)or die(mysqli_error($link));
            
            $jm_permanen = mysqli_num_rows($permanent);
            $jm_kontrak1 = mysqli_num_rows($kontrak1);
            $jm_kontrak2 = mysqli_num_rows($kontrak2);
            $jm_TM = mysqli_num_rows($TM);
            $jm_TL = mysqli_num_rows($TL);
            $jm_FRM = mysqli_num_rows($FRM);
    
            // echo "$jm_permanen";
            if($edit == 1){
            ?>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="regist" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content mx-1 px-1">
                                <form action="../setting/organization/proses/add.php" method="POST" id="RangeValidation">
                                    <div class="modal-header justify-content-center">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                        <h5 class="title title-up">Sub Area </h5>
                                    </div>

                                    <div class="modal-body px-2">
                                        <div class="form-group-sm ">
                                            <input type="hidden" name="part" value="<?=$sub_part?>">
                                        </div>
                                        
                                        <div class="form-group-sm ">
                                            <select required class="form-control selectpicker part text-center"data-size="7" name="id_parent" data-style="btn btn-warning bg-white btn-link border" title="Pilih Area" data-width="100%" data-id="" required>
                                                
                                                <option class="text-center" disabled>Data Area</option>
                                                <?php
                                                    if(isset($area)){
                                                        foreach($area AS $data_area){
                                                            ?>
                                                            <option class="text-center" value="<?=$data_area?>" ><?=getOrgName($link, $data_area, $part)?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                
                                            </select>
                                        </div>
                                        <hr class="my-0">
                                        <div class="form-group">
                                            <input type="number" name="count" class="form-control text-center gen" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="left-side">
                                            <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="right-side">
                                            <button type="submit" class="btn btn-danger btn-link">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            
            <div class="jumbotron jumbotron-fluid bg-white pattern" style="height:200px;background-image:linear-gradient(to bottom, rgba(244,243,239, 1) 20%, rgba(244,243,239, 0) 80%) , url(../../assets/img/bg/header_otomotif.jpg);background-size: cover;background-attachment:fixed">
                <div class="container " >
                   
                    <input type="hidden" name="npk" id="npk" value="<?=$npk?>">
                    <input type="hidden" name="level" id="level" value="<?=$level?>">
                </div>
            </div>
            <div class="row" style="margin-top:-100px">
                <div class="col-md-4" >
                    <div class="row">
                        <div class="col-md-12 pl-5">
                            <div class="card card-user " >
                                <div class="card-body">
                                    <div class="author">
                                        <a href="#">
                                            <img class="avatar border-gray" src="<?=$base64?>" alt="...">
                                            <h5 class="title text-uppercase"><?=$namaUser?></h5>
                                        </a>
                                        <p class="description text-uppercase">
                                            <?=$mes?>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row rounded flex-row flex-nowrap overflow-auto img_holder d-none" id="b">
    
                        <div class="col-md-12 col-sm-12 pl-5">
                            <div class="card card-stats bg-info">
                                <div class="card-body "id="4">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-white">
                                                <span class="fa-stack" >
                                                <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                <i class="fa fa-info fa-stack-1x fa-inverse mt-1"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers ">
                                                <p class="card-title text-white " id="sumary" >-<p>
                                                <p class="card-category text-right text-white mb-3">MP Layoff</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?=base_url()?>/dashboard/manpower/layoff.php" class="stretched-link card-category text-right text-white mb-3"></a>
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
                                                                <p class="card-title"> <?=$jm_FRM?>
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
                                                                <p class="card-title"> <?=$jm_TL?>
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
                                                                <p class="card-title"> <?=$jm_permanen?>
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
                                                                <p class="card-title"> <?=$jm_kontrak2?>
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
                                                                <p class="card-title"> <?=$jm_kontrak1?>
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
                                <div class="col-md-6">
                                    <h4 class="text-uppercase title "><?=$part.$headerGroup?></h4>
                                    <a class="btn btn-sm btn-info" data-toggle="collapse" href="#collapsesummary" role="button" aria-expanded="true" aria-controls="collapsesummary">Data Sumary</a>
                                </div>
                                <div class="col-md-6 text-right pt-4 mb-0">
                                    
                                <?php
                                if($edit == 1){
                                    ?>
                                    <form name="regist" action="../setting/organization/proses/add.php" method="POST">
                                    
                                        <input type="hidden" name="count" value="1">
                                        <input type="hidden" name="frm" value="1">
                                        <input type="submit" class="btn btn-sm btn-success mb-0 register" value="Register Organisasi">
                                    </form>
                                    <?php
                                }else{
                                    ?>
                                        <a  href="../setting/organization/" class="btn btn-sm mb-0"> Kembali </a>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-full-width no-border text-uppercase">
                                        <table class="table">
                                            <?php
                                            $q_newArea = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE cord = '$npkUser' AND part = '$part'  ")or die(mysqli_error($link));
                                            if(mysqli_num_rows($q_newArea)> 0){
                                                $no=1;
                                                while($dataNewArea = mysqli_fetch_assoc($q_newArea)){
                                                    // echo $sub_part;
                                                    $q_cekPos = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = '$sub_part' AND id_parent = '$dataNewArea[id]' ")or die(mysqli_error($link));
                                                    if(mysqli_num_rows($q_cekPos)>0){
                                                        while($dataPos = mysqli_fetch_assoc($q_cekPos)){
                                                            $query_total = mysqli_query($link, $queryMP.$add_filter." AND $sub = '$dataPos[id]' ")or die(mysqli_error($link));
                                                            if(mysqli_num_rows($query_total) == 0){
                                                                ?>
                                                                <tr class="table-danger">
                                                                    
                                                                    
                                                                    <td class="text-danger pl-4 title">
                                                                        <div class="title"> 
                                                                            <span class="text-white category">NEW </span>
                                                                            <?=$dataPos['nama_org']?>
        
                                                                        </div>
                                                                        <div class="badge badge-pill">Data Karyawan belum diposting. Klik Update untuk melakukan seting</div>
                                                                    </td>
                                                                    <td class="text-right pr-4">
                                                                        <a  <?=$disabled ?> href="../setting/organization/data-update.php?id=<?=$dataPos['id']?>&part=<?=$sub_part?>" class="btn btn-sm btn-round btn-outline-danger btn-success">Update</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            
                                                        }
                                                    }
                                                    
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="collapse " id="collapsesummary">
                                <div class=" table-striped table-full-width text-uppercase" >
                                    <table class="table-sm" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Area</th>
                                                <th>Jml Emp</th>
                                                <th>FRM</th>
                                                <th>TL</th>
                                                <th>TM</th>
                                                <th class="table-warning">TM K1</th>
                                                <th class="table-warning">TM K2</th>
                                                <th class="table-warning">TM P</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(mysqli_num_rows($sql_group)>0){
                                                $no = 1;
                                                while($data = mysqli_fetch_assoc($sql_group)){
                                                    $part = $part;
                                                    $color = ($data[$sub] == '')?"text-danger ":"";
                                                    $filter_sub = ($data[$sub] == '')?" IS NULL":" = '$data[$sub]'";
                                                    $addSub = " AND $sub $filter_sub";
                                                    $query_total = mysqli_query($link, $queryMP.$add_filter.$addSub)or die(mysqli_error($link));
                                                    $total = mysqli_num_rows($query_total);
                                                    // echo $addSub;
                                                    // if($no == 1){
                                                    //     echo $queryMP.$addPermanent.$addSub;
                                                    // }
                                                    $nama_area = ($data[$sub] != '')?getOrgName($link, $data[$sub], $sub_part):'belum diregister';
                                                    $permanent = mysqli_query($link, $queryMP.$addPermanent.$addSub)or die(mysqli_error($link));
                                                    $kontrak1 = mysqli_query($link, $queryMP.$addK1.$addSub)or die(mysqli_error($link));
                                                    $kontrak2 = mysqli_query($link, $queryMP.$addK2.$addSub)or die(mysqli_error($link));
                                                    $TM = mysqli_query($link, $queryMP.$addTtm.$addSub)or die(mysqli_error($link));
                                                    $FRM = mysqli_query($link, $queryMP.$addFrm.$addSub)or die(mysqli_error($link));
                                                    $TL = mysqli_query($link, $queryMP.$addTl.$addSub)or die(mysqli_error($link));
                                                    
                                                    $jm_permanen = mysqli_num_rows($permanent);
                                                    $jm_kontrak1 = mysqli_num_rows($kontrak1);
                                                    $jm_kontrak2 = mysqli_num_rows($kontrak2);
                                                    $jm_TM = mysqli_num_rows($TM);
                                                    $jm_TL = mysqli_num_rows($TL);
                                                    $jm_FRM = mysqli_num_rows($FRM);
                                                    // echo $queryMP.$addMng;
                                                    ?>
                                                    <tr class="<?=$color?>">
                                                        <td><?=$no++?></td>
                                                        <td><?=$nama_area?></td>
                                                        <td><?=$total?></td>
                                                        
                                                        <td><?=$jm_FRM?></td>
                                                        <td><?=$jm_TL?></td>
                                                        <td><?=$jm_TM?></td>
                                                        <td class="table-warning"><?=$jm_kontrak1?></td>
                                                        <td class="table-warning"><?=$jm_kontrak2?></td>
                                                        <td class="table-warning"><?=$jm_permanen?></td>
                                                        <td class="text-right">
                                                            <?php
                                                            if($data[$sub] != ''){
                                                                ?>
                                                                <a  <?=$disabled ?> href="../setting/organization/data-update.php?id=<?=$data['id_post_leader']?>&part=<?=$sub_part?>&frm=group" class="btn btn-sm btn-success">Update</a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="title col-md-6"></h5>
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
            // }else{
            //     include_once ("../no_access.php");
            // }
        }else{
            include_once ("../no_access.php");
        }

    
    //footer
        include_once("../footer.php");
        ?>
        <script>
            $(document).ready(function(){
                load_data();
                getSumary()
                function getSumary(){
                    var eval = $('#eval').val();
                    var id = 'sum_layoff';
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
                    var level = $('#level').val();
                    var npk = $('#npk').val();
                    $.ajax({
                        url: '../manpower/ajax/index.php',	
                        method: 'GET',
                        data:{level:level,npk:npk,id:id,eval:eval,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,att_type:att_type,filter:'yes'},		
                        success:function(data){
                            $('#sumary').html(data);	
                            console.log('success')
                        }
                    });
                }
                function load_data(page){
                    var id = 'mp';
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
                    var level = $('#level').val();
                    var npk = $('#npk').val();
                    $.ajax({
                        url:"../manpower/ajax/index.php",
                        method:"GET",
                        data:{id:id,level:level,npk:npk,page:page,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,filter:'yes'},
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
                
                
                $('#filterGo').on('click', function(){
                    load_data()
                })
                $('#cari').on('keyup', function(){
                    load_data()
                    getSumary()
                
                });
                $('#att_type').on('change', function(){
                    load_data()
                    getSumary()
                });
            
                    
                
                function getDiv(){
                    var data = $('#s_div').val()
                    $.ajax({
                        url: '../manpower/ajax/get_div.php',	
                        method: 'GET',
                        data: {data:data},		
                        success:function(data){
                            $('#s_div').html(data);	
                            
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
                    $(document).on('click', '.register', function(a){
                        a.preventDefault();
                        $('#regist').modal('show');
                    })
                });
            </script>

    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>