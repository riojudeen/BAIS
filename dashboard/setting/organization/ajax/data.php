<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        // echo $_POST['part_area'];
        $part_area = (isset($_POST['part_area']))?$_POST['part_area']:'';
        $id_area = (isset($_POST['id_area']))?$_POST['id_area']:'';
        if($level >=1 && $level <=8){
            require_once("../../../../config/approval_system.php");
            if($_POST['id'] == 'mp'){
                
                // echo $part_area;
                if($part_area == 'pos'){
                    $nama_kolom = 'view_organization.id_post_leader';
                    $addOrder = " ORDER BY view_organization.id_post_leader DESC ";
                }else if($part_area == 'group'){
                    $nama_kolom = 'view_organization.id_grp';
                    $addOrder = " ORDER BY view_organization.id_post_leader DESC ";
                }else if($part_area == 'section'){
                    $nama_kolom = 'view_organization.id_sect';
                    $addOrder = " ORDER BY view_organization.id_grp DESC ";
                }else if($part_area == 'dept'){
                    $nama_kolom = 'view_organization.id_dept';
                    $addOrder = " ORDER BY view_organization.id_sect DESC ";
                }else if($part_area == 'deptacc'){
                    $nama_kolom = 'view_organization.id_dept_account';
                    $addOrder = " ORDER BY view_organization.id_sect DESC ";
                }else if($part_area == 'division'){
                    $nama_kolom = 'view_organization.id_division';
                    $addOrder = " ORDER BY view_organization.id_dept DESC ";
                }
                // echo $nama_kolom;
                // echo $id_area;
                $filter_cari = (isset($_POST['cari']) && $_POST['cari'] != '')?$_POST['cari']:'';
                $pencarian = ($filter_cari != '')?" AND ( npk LIKE '%$_POST[cari]%' OR nama LIKE '%$_POST[cari]%' )":'';
                $filter_area = ($id_area != '')?" $nama_kolom = '$id_area' ":'';
                $filter = ($filter_area != '')?" WHERE $filter_area":'';
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
                $q_data = $origin_query.$filter;
                $q_total = $q_data;
                // echo $filter;
                
                ?>
            <div class="table-responsive" >
                <table class="table table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th class="text-right first-top-col first-col sticky-col">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input check-all" type="checkbox" id="allmp">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </th>
                            <th scope="col">No</th>
                            <th scope="col">NPK</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Status</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Shift</th>
                            <th scope="col">Pos Kerja</th>
                            <th scope="col">Team Kerja</th>
                            <th scope="col">Group</th>
                            <th scope="col">Section</th>
                            <th scope="col">Dept</th>
                            <th scope="col">Dept Adm</th>
                        </tr>
                    </thead>
                    <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $q_total)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records."<br>";
    
                        $page = (isset($_POST['page']) && $_POST['page'] != 'undefined')? $_POST['page'] : 1;
                        // echo $page."<br>";
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        
                        $addLimit = " LIMIT $limit_start, $limit";
                        $no = 1;
                        // echo $addOrder."<br>";
                        // echo $addLimit."<br>";
                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        // echo $jumlah_page."<br>";s
                        $query = $q_data.$addOrder.$addLimit;
                        // echo $q_data.$pencarian.$addOrder.$addLimit;
                        $sql = mysqli_query($link, $q_data.$pencarian.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                
                                ?>
                                <tr id="<?=$data['npk']?>" >
                                    <td class="sticky-col first-col">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input mp check" type="checkbox" name="index[]"  value="<?=$data['npk']?>">
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$data['status']?></td>
                                    <td class="td"><?=$data['jabatan']?></td>
                                    <td class="td"><?=tgl_indo($data['tgl_masuk'])?></td>
                                    <td class="td"><?=$data['shift']?></td>
                                    <td class="td"><?=$data['subpos']?></td>
                                    <td class="td"><?=$data['pos']?></td>
                                    <td class="td"><?=$data['groupfrm']?></td>
                                    <td class="td"><?=$data['section']?></td>
                                    <td class="td"><?=$data['dept']?></td>
                                    <td class="td"><?=$data['dept_account']?></td>
                                    
                                </tr>
    
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="14" class="text-center"><?=noData()?></td>
                            </tr>
                            <?php
                        }
                        
                        ?>
                        
                    </tbody>
                    <tfoot>
    
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 ">
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
                <div class="col-md-6 text-right">
                <a href="" class="btn btn-sm btn-warning editall ">Edit data</a>
                </div>
            </div>
            <?php
            }else{
                ?>
                
                <?php
                // echo $_POST['input'];
                list($pos,$group,$section,$dept,$division,$plant,$dept_account)=strukturOrg($link, $part_area, $id_area);
                
                // echo $part_area;
                // echo $id_area;
                // echo  $pos." - ".$group." - ".$section." - ".$dept." - ".$division." - ".$plant."<br>";
                $pos_name = getOrgName($link, $pos, 'pos');
                $group_name = getOrgName($link, $group, 'group');
                $section_name = getOrgName($link, $section, 'section');
                $dept_name = getOrgName($link, $dept, 'dept');
                $div_name = getOrgName($link, $division, 'division');
                // echo $div_name;
                $data_npk = preg_split("/\r\n|\n|\r/", $_POST['input']);
                $q_deptAccount = mysqli_query($link, "SELECT department_account AS `name` FROM dept_account WHERE id_dept_account = '$dept_account' ")or die(mysqli_error($link));
                $data_dept_account = mysqli_fetch_assoc($q_deptAccount);
                $deptAcc_name = (isset($data_dept_account['name']))?$data_dept_account['name']:'';
                
                $origin_query = "SELECT 
                                                view_organization.npk,
                                                view_organization.nama,
                                                view_organization.tgl_masuk,
                                                view_organization.jabatan,
                                                view_organization.shift,
                                                view_organization.subpos,
                                                view_organization.status,
                                                view_organization.pos,
                                                view_organization.groupfrm,
                                                view_organization.section,
                                                view_organization.dept,
                                                view_organization.subpos,
                                                view_organization.division,
                                                view_organization.dept_account
                                                
                                                FROM view_organization";
                $access_org = orgAccessOrg($level);
                $npk = $npkUser;
                $data_access = generateAccess($link,$level,$npk);
                $table = partAccess($level, "table");
                $field_request = partAccess($level, "field_request");
                $table_field1 = partAccess($level, "table_field1");
                $table_field2 = partAccess($level, "table_field2");
                $part = partAccess($level, "part");
                $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
                // $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
                // echo $access_org;
                $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org);
                if($level > 5){
                    // jika administrator , dapat update semua karyawan , jika tidak hanya update rganisasi internal
                    $substr = substr($queryMP, 0,-1);
                    $queryMP = $substr." OR id_plant = '1' )";
                    // echo $queryMP;
                }else{
                    $queryMP = $queryMP;
                }
                $queryData = $queryMP;
                // echo $queryMP;

                if(count($data_npk)>0){
                    // print_r($data_npk);
                    ?>
                    <div class="table-responsive" >
                        <table class="table table-hover table-striped">
                            <thead class="table-warning">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NPK</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Tanggal Masuk</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Pos Kerja</th>
                                    <th scope="col">Team Kerja</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Dept</th>
                                    <th scope="col">Dept Adm</th>
                                    <th scope="col">division</th>
                                    <th scope="col" class="sticky-col first-last-col first-last-top-col text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input checked class="form-check-input check-all" type="checkbox" >
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase text-nowrap">
                                <?php
                                // print_r($data_npk);
                                if(count($data_npk)>0 ){
                                    
                                    if($data_npk[0] != ''){
                                        $no = 1;
                                        
                                        foreach($data_npk AS $npk){
                                            // echo $npk;
                                            // $div_filter = $_GET['div'];
                                            // echo $npk;
                                            $queryMP = $queryData." AND npk = '$npk'";
                                            $query = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                                            $jml = mysqli_num_rows($query);
                                            // echo $queryMP."<br>";
                                            // $checked = ($jml > 0)?'disabled':'';
                                            // $checked_class = ($jml > 0)?'':'check';
                                            
                                            // echo $id_area;
                                            $sql = mysqli_fetch_assoc($query);
                                            $data_nama = (isset($sql['nama']))?$sql['nama']:'';
                                            $data_npk_kary = (isset($sql['npk']))?$sql['npk']:'';
                                            // echo $data_nama;
                                            $data_status = (isset($sql['status']))?$sql['status']:'';
                                            $data_jabatan = (isset($sql['jabatan']))?$sql['jabatan']:'';
                                            $data_tgl_masuk = (isset($sql['tgl_masuk']))?$sql['tgl_masuk']:'';
                                            $tgl_masuk = ($data_tgl_masuk != '')?tgl($data_tgl_masuk):'';
                                            $data_shift = (isset($sql['shift']))?$sql['shift']:'';
                                            $data_pos = (isset($sql['subpos']))?$sql['subpos']:'';
                                            $data_team = (isset($sql['pos']))?$sql['pos']:'';
                                            $data_group = (isset($sql['groupfrm']))?$sql['groupfrm']:'';
                                            $data_section = (isset($sql['section']))?$sql['section']:'';
                                            $data_dept = (isset($sql['dept']))?$sql['dept']:'';
                                            $data_dept_account = (isset($sql['dept_account']))?$sql['dept_account']:'';
                                            $data_division = (isset($sql['division']))?$sql['division']:'';
                                            // echo $data_section;

                                            if($part_area == 'pos'){
                                                $check = ($data_pos != '')?'':'checked';
                                                $check_class = ($data_pos != '')?'':'check';
                                            }else if($part_area == 'group'){
                                                $check = ($data_group != '')?'':'checked';
                                                $check_class = ($data_group != '')?'':'check';
                                            }else if($part_area == 'section'){
                                                $check = ($data_section != '')?'':'checked';
                                                $check_class = ($data_section != '')?'':'check';
                                            }else if($part_area == 'dept'){
                                                $check = ($data_dept != '')?'':'checked';
                                                $check_class = ($data_dept != '')?'':'check';
                                            }else if($part_area == 'deptacc'){
                                                $check = ($data_dept_account != '')?'':'checked';
                                                $check_class = ($data_dept_account != '')?'':'check';
                                            }else if($part_area == 'division'){
                                                $check = ($data_division != '')?'':'checked';
                                                $check_class = ($data_division != '')?'':'check';
                                            }else{
                                                $check = 'disabled';
                                                $check_class = '';
                                            }
                                            if($jml > 0){
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$data_npk_kary?></td>
                                                    <td><?=$data_nama?></td>
                                                    <td><?=$data_status?></td>
                                                    <td><?=$data_jabatan?></td>
                                                    <td><?=$tgl_masuk?></td>
                                                    <td><?=$data_shift?></td>
                                                    <td><?=$data_pos?></td>
                                                    <td><?=$pos_name?></td>
                                                    <td><?=$group_name?></td>
                                                    <td><?=$section_name?></td>
                                                    <td><?=$dept_name?></td>
                                                    <td><?=$deptAcc_name?></td>
                                                    <td><?=$div_name?></td>
                                                    <td class="text-right">
                                                        <div class="form-check text-right">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input check" <?=$check?> name="checked[]" value="<?=$data_npk_kary?>" type="checkbox" data="<?=$no?>">
                                                            <span class="form-check-sign"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }else{
                                                ?>
                                                    <tr class="table-danger">
                                                        <td ><?=$no?></td>
                                                        <td><?=$npk?></td>
                                                        <td colspan="13"> Data Belum Ada atau tidak tersedia untuk area anda</td>
                                                    </tr>
                                                <?php
                                            }
                                            $no++;
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="14" class="text-center"><?=noData()?></td>
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td colspan="14" class="text-center"><?=noData()?></td>
                                    </tr>
                                    <?php
                                }
                                
                                ?>
                                
                            </tbody>
                            <tfoot>
            
                            </tfoot>
                        </table>
                    </div>
                    <button class="btn btn-sm  btn-success posting float-right" type="submit" id="edit">
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-add"></i>
                        </span>
                        posting
                    </button>
                    <?php

                }
            }
        }else{
            include_once ("../../no_access.php");
        }
        
    }else{
        echo "gagal";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}