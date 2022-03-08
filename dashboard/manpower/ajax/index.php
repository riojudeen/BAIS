<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8 && $_GET['id'] == 'mp'){
        require_once("../../../config/approval_system.php");
        
        $filter = $_GET['filter'];
        $div_filter = $_GET['div'];
        // echo $div;
        $dept_filter = $_GET['dept'];
        // echo $dept_filter;
        $sect_filter = $_GET['sect'];
        // echo $sect_filter;
        $group_filter = $_GET['group'];
        // echo $group_filter;
        $deptAcc_filter = $_GET['deptAcc'];
        // echo $deptAcc_filter;
        $shift = $_GET['shift'];
        // echo $shift;
        $cari = $_GET['cari'];
        $npk = $_GET['npk'];
        $level = $_GET['level'];
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
        // echo $group_filter;
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter;
        // echo $queryMP;
        // echo $access_org."<br>";
        // echo $data_access."<br>";
        // echo $field_request."<br>";
        // echo $table_field1."<br>";
        // echo $table_field2."<br>";
        // echo $part."<br>";
        // echo $generate."<br>";
        // echo $add_filter."<br>";
        // echo $queryMP."<br>";
        
        
        ?>
        <div class="table-responsive" >
            <table class="table table-hover">
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
                        
                    </tr>
                </thead>
                <tbody class="text-uppercase text-nowrap">
                    <?php
                    $sql_jml = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                    $total_records= mysqli_num_rows($sql_jml);
                    // echo $total_records."<br>";

                    $page = (isset($_GET['page']))? $_GET['page'] : 1;
                    // echo $page."<br>";
                    $limit = 100; 
                    $limit_start = ($page - 1) * $limit;
                    $no = $limit_start + 1;
                    // echo $limit_start;
                    $addOrder = " ORDER BY id_division, id_dept_account, id_dept, id_sect, id_grp, id_post_leader DESC ";
                    $addLimit = " LIMIT $limit_start, $limit";
                    
                    // echo $addOrder."<br>";
                    // echo $addLimit."<br>";
                    // pagin
                    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                    
                    $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                    // echo $jumlah_page."<br>";s
                
                    $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                    
                    if(mysqli_num_rows($sql)>0){
                        while($data = mysqli_fetch_assoc($sql)){
                            
                            ?>
                            <tr id="<?=$data['npk']?>" >
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
            <div class="col-md-12 pull-rigt">
                <ul class="pagination ">
                <?php
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
    }else if($level >=1 && $level <=8 && $_GET['id'] == 'layoff'){
        require_once("../../../config/approval_system.php");
        $filter = $_GET['filter'];
        $div_filter = $_GET['div'];
        
        $dept_filter = $_GET['dept'];
        // echo $dept_filter;
        $sect_filter = $_GET['sect'];
        // echo $sect_filter;
        $group_filter = $_GET['group'];
        // echo $group_filter;
        $deptAcc_filter = $_GET['deptAcc'];
        // echo $deptAcc_filter;
        $shift = $_GET['shift'];
        // echo $shift;
        $cari = $_GET['cari'];
        $npk = $_GET['npk'];
        $level = $_GET['level'];
        $eval = $_GET['eval'];
        $filter_eval = ($eval == '')?'':" AND `status` = '$eval' ";
        // echo $npk;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
       
        $tgl_eval = date('Y-m-t');
        
        $akhir_eval = date('Y-m-t');
        $mulai_eval = date('Y-m-1', strtotime('-3 months', strtotime($akhir_eval)));

        // echo $akhir_eval;

        $origin_query = "SELECT `npk`,`nama`, tgl_masuk,
            IF(`status` = 'C1', DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '1' YEAR), INTERVAL '1' DAY), DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '2' YEAR), INTERVAL '1' DAY) ) AS 'date_eval',
            
            `jabatan`,
            `shift`,`status`,`subpos`,`pos`,`groupfrm`,`section`,`dept`,
            `dept_account`,`division`,`plant`,`id_sub_pos`,`id_post_leader`,
            `id_grp`,`id_sect`,`id_dept`,`id_dept_account`,`id_division`,
            `id_plant`,`id_area`
            FROM `view_organization` ";

        $filter_layoff = " AND id_plant = '1' AND ((SELECT count(`npk`) AS `exp` FROM expatriat WHERE npk = view_organization.npk ) = 0) AND (`status` <> 'P' ) AND (DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '1' YEAR), INTERVAL '1' DAY)  BETWEEN DATE_SUB(tgl_masuk, INTERVAL '3' MONTH ) AND '$akhir_eval' )";
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);

        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$filter_layoff.$filter_eval;
        
        // echo $queryMP;

        $page = (isset($_GET['page']) && $_GET['page'] != 'undefined')? $_GET['page'] : 1;
        // echo $page;
        $limit = 100; 
        $limit_start = ($page - 1) * $limit;
        $no = $limit_start + 1;
        // echo $limit_start;
        $filterGroup = " ORDER BY date_eval DESC ";
        $addLimit = " LIMIT $limit_start, $limit";

        $total_dataKaryawan = $queryMP;
        $jml = mysqli_query($link, $total_dataKaryawan)or die(mysqli_error($link));
        
        
        $sql_dataKaryawan = mysqli_query($link, $queryMP.$filterGroup.$addLimit)or die(mysqli_error($link));
        $total_records= mysqli_num_rows($jml);

        
        // echo $total_records;
        // pagin
        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;

        // echo $q_dataKaryawan;
        
        ?>

        
        <div class="row">
            
            
            <div class="col-md-12">
                
                <form class="table-responsive" name="proses" method="post">
                    <table class="table table-hover text-uppercase">
                        <thead>
                            
                            <th class="text-nowrap sticky-col second-col second-top-col">#</th>
                            <th class="text-nowrap sticky-col third-col third-top-col">Npk</th>
                            <th class="text-nowrap sticky-col fourth-col fourth-top-col">Nama</th>
                            <th class="text-nowrap">Shift</th>
                            <th class="text-nowrap">Dept Account</th>
                            <th class="text-nowrap">Tgl Masuk</th>
                            <th class="text-nowrap">Tgl Eval</th>
                            <th class="text-nowrap">Jabatan</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap sticky-col second-col second-top-col"></th>
                            <th class="text-nowrap" colspan="2">Status EMK</th>
                        </thead>
                        <tbody class="text-nowrap">
                            <?php
                            
                            
                            
                                if(mysqli_num_rows($sql_dataKaryawan)>0){
                                    
                                    $no = $limit_start +1 ;  
                                    while($dataKaryawan = mysqli_fetch_assoc($sql_dataKaryawan)){
                                        $tgl_masuk = $dataKaryawan['tgl_masuk'];
                                        $tgl_eval = date('Y-m-d', strtotime($dataKaryawan['date_eval']));
                                        
                                        $tgl_mulai_eval = strtotime($mulai_eval);
                                        $tgl_akhir_eval = strtotime($akhir_eval);
        
                                        $q_atasan = mysqli_query($link, "SELECT id, nama_cord FROM view_cord_area WHERE id = '$dataKaryawan[id_area]' ");
                                        $s_atasan = mysqli_fetch_assoc($q_atasan);
                                        $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:'';
        
                                        $q_layoff = mysqli_query($link, "SELECT `id`,`npk`,`update_by`,`emk` FROM `karyawan_layoff` WHERE npk = '$dataKaryawan[npk]' GROUP BY emk DESC LIMIT 1")or die(mysqli_error($link));
                                        $s_layoff = mysqli_fetch_assoc($q_layoff);
                                        if(mysqli_num_rows($q_layoff) > 0){
                                            if($s_layoff['emk'] == 1 ){
                                                $stats = "evaluasi 1";
                                                $stats_emk = "Sudah Submit";
                                                $stats_kontrak = "Kontrak 1";
                                                $clr = "warning";
                                                $disabled_contract = "disabled";
                                                $disabled_permanent = 1;
                                                $layoff_val = "1";
                                            }else if($s_layoff['emk'] == 2 ){
                                                $stats = "evaluasi 2";
                                                $stats_kontrak = "Kontrak 2";
                                                $stats_emk = "Sudah Submit";
                                                $clr = "warning";
                                                $disabled_contract = "disabled";
                                                $disabled_permanent = 1;
                                                $layoff_val = "2";
                                            }
                                        }else{
                                            if($dataKaryawan['status'] == 'C1'){
                                                $stats = "Evaluasi 1";
                                                $stats_kontrak = "Kontrak 1";
                                                
                                                $stats_emk = "Belum Submit";
                                                $clr = "danger";
                                                $disabled_contract = "";
                                                $disabled_permanent = 1;
                                                $layoff_val = "1";
                                            }else{
                                                $stats = "Evaluasi 2";
                                                $stats_kontrak = "Kontrak 1";
                                                $stats_emk = "Belum Submit";
                                                $clr = "danger";
                                                $disabled_contract = "";
                                                $disabled_permanent = 1;
                                                $layoff_val = "2";
                                            }
                                        }
                                        
                                        // if($tgl_eval >=  $tgl_mulai_eval && $tgl_eval <= $tgl_akhir_eval){
                                        ?>
                                        <tr>
                                            <td class="sticky-col second-col"><?=$no++?></td>
                                            <td class="sticky-col third-col"><?=$dataKaryawan['npk']?></td>
                                            <td class="sticky-col fourth-col"><?=$dataKaryawan['nama']?></td>
                                            <td><?=$dataKaryawan['shift']?></td>
                                            <td><?=$dataKaryawan['dept_account']?></td>
                                            <td><?=DBtoForm($dataKaryawan['tgl_masuk'])?></td>
                                            <td><?=DBtoForm($tgl_eval)?></td>
                                            <td><?=$dataKaryawan['jabatan']?></td>
                                            <td><?=$stats_kontrak?></td>
                                            <td>
                                                <span  class="badge badge-pill badge-<?=$clr?>"><?=$stats?></span>
                                            </td>
                                            <td class="text-<?=$clr?>"><?=$stats_emk?></td>
                                            
                                            
                                        </tr>
        
                                        <?php
                                        
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td colspan="11" class="text-uppercase text-center sticky-col first-col">belum ada data</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                    </table>
                        </form>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pull-rigt">
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
        <div class="row">

            <div class="col-md-12 text-right">
                <a href="" class="btn btn-sm btn-warning editall ">Edit data</a>
                <a href="" class="btn btn-sm btn-danger delete">Delete data</a>
            </div>
        </div>
            <?php
    }else if($level >=1 && $level <=8 && $_GET['id'] == 'sum_layoff'){
        require_once("../../../config/approval_system.php");
        $filter = $_GET['filter'];
        $div_filter = $_GET['div'];
        
        $dept_filter = $_GET['dept'];
        // echo $dept_filter;
        $sect_filter = $_GET['sect'];
        // echo $sect_filter;
        $group_filter = $_GET['group'];
        // echo $group_filter;
        $deptAcc_filter = $_GET['deptAcc'];
        // echo $deptAcc_filter;
        $shift = $_GET['shift'];
        // echo $shift;
        $cari = $_GET['cari'];
        $npk = $_GET['npk'];
        $level = $_GET['level'];
        $eval = (isset($_GET['eval']))?$_GET['eval']:'';
        $filter_eval = ($eval == '')?'':" AND `status` = '$eval' ";
        // echo $npk;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
       
        $tgl_eval = date('Y-m-t');
        
        $akhir_eval = date('Y-m-t');
        $mulai_eval = date('Y-m-1', strtotime('-3 months', strtotime($akhir_eval)));

        // echo $akhir_eval;

        $origin_query = "SELECT `npk`,`nama`, tgl_masuk,
            IF(`status` = 'C1', DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '1' YEAR), INTERVAL '1' DAY), DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '2' YEAR), INTERVAL '1' DAY) ) AS 'date_eval',
            
            `jabatan`,
            `shift`,`status`,`subpos`,`pos`,`groupfrm`,`section`,`dept`,
            `dept_account`,`division`,`plant`,`id_sub_pos`,`id_post_leader`,
            `id_grp`,`id_sect`,`id_dept`,`id_dept_account`,`id_division`,
            `id_plant`,`id_area`
            FROM `view_organization` ";

        $filter_layoff = " AND id_plant = '1' AND ((SELECT count(`npk`) AS `exp` FROM expatriat WHERE npk = view_organization.npk ) = 0) AND (`status` <> 'P' ) AND (DATE_SUB(ADDDATE(tgl_masuk,INTERVAL '1' YEAR), INTERVAL '1' DAY)  BETWEEN DATE_SUB(tgl_masuk, INTERVAL '3' MONTH ) AND '$akhir_eval' )";
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);

        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$filter_layoff.$filter_eval;
        
        echo mysqli_num_rows(mysqli_query($link, $queryMP));

        
    }else{
        include_once ("../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>