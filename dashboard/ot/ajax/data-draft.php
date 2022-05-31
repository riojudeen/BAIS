<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");

if(isset($_SESSION['user'])){
    if($_GET['conf'] == 'dm'){
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;
        // echo $end;
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
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        // echo $cari;
        $level = $level;
        $npk = $npkUser;
        $ot_type = $_GET['conf'];
        // $query = "SELECT "
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_req_ot.id_ot,
            view_req_ot.npk,
            count(view_req_ot.ot_code) AS jml,
            view_req_ot.nama,
            view_req_ot.shift,
            view_req_ot.ot_code,
            view_req_ot.requester,
            view_req_ot.in_date,
            view_req_ot.work_date,
            view_req_ot.start,
            view_req_ot.out_date,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity,
            view_req_ot.status_approve,
            view_req_ot.status_progress,
            view_req_ot.post,
            view_req_ot.grp,
            view_req_ot.sect,
            view_req_ot.dept,
            view_req_ot.dept_account,
            view_req_ot.division,
            SUM(view_req_ot.over_time) AS overtime ,
            view_req_ot.plant
            FROM view_req_ot";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        // echo $filter_cari;
        // $filterOtCode = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterDraft = " AND CONCAT(view_req_ot.status_approve, view_req_ot.status_progress) IS NULL GROUP BY grp, dept_account";
        $filterProg = "";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterProg.$filterDraft;
        
        echo $query_req_overtime
                
        ?>
        <div class="row">
            <div class="col-md-12">
                
                <div class="table-responsive">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group</th>
                                <th>Section</th>
                                <th>Dept</th>
                                <th>Dept Admin</th>
                                <th>Tgl Kerja</th>
                                <th>Σ MP</th>
                                <th>Σ Mins</th>
                                <th></th>
                                <th class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="allreq">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $query_req_overtime)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = "  ORDER BY ot_code DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        // $no = 1*$page;

                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        
                    
                        $sql = mysqli_query($link, $query_req_overtime.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                $query_group = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                                $group_ = mysqli_fetch_assoc($query_group);
                                $query_deptAcc = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc'  ")or die(mysqli_error($link));
                                $deptAcc = mysqli_fetch_assoc($query_deptAcc);
                                $query_dept = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept]' AND part = 'dept'  ")or die(mysqli_error($link));
                                $dept_ = mysqli_fetch_assoc($query_dept);
                                $query_sect = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[sect]' AND part = 'section'  ")or die(mysqli_error($link));
                                $sect_ = mysqli_fetch_assoc($query_sect);
                                
                                $group = $group_['nama_org'];
                                $dept_acc = $deptAcc['nama_org'];
                                $dept = $dept_['nama_org'];
                                $sect = $sect_['nama_org'];
                                $start = ($data['start'] == '00:00:00')? "-" : jam($data['start']);
                                $end = ($data['start'] == '00:00:00')? "-" : jam($data['end']);
                                $work_date = $data['work_date'];
                                $limit_date = tgl(date('Y-m-t', strtotime($data['work_date'])));
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                $ot_code = $data['ot_code'];
                                $ot_menit = ($data['overtime'] == '')?"0 mins":"$data[overtime] min";
                                
                                ?>
                                <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$group?></td>
                                    <td class="td"><?=$sect?></td>
                                    <td class="td"><?=$dept?></td>
                                    <td class="td"><?=$dept_acc?></td>
                                    
                                    <td class="td"><?=tgl($data['work_date'])?></td>
                                    <td class="td"><?=$data['jml']?> </td>
                                    <td class="td text-lowercase"><?=$ot_menit?></td>
                                    <td class="td text-right">
                                        <a href="" class="btn btn-primary btn-sm btn-round btn-icon">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                    
                                    <td class="td">
                                        <div class="form-check text-right">
                                            <label class="form-check-label ">
                                                <input class="form-check-input mp_req " name="request[]" type="checkbox" value="<?=$data['grp']?>&&<?=$data['dept_account']?>&&<?=$data['work_date']?>">
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    
                                
                                </tr>

                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="14" class="text-center">Semua Berkas Telah Diajukan</td>
                            </tr>
                            <?php
                        }
                        
                        ?>
                        
                    </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
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
                    echo '<li class="page-item halaman-draft" id="1"><a class="page-link" >First</a></li>';
                    echo '<li class="page-item halaman-draft" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                }

                for($i = $start_number; $i <= $end_number; $i++){
                    $link_active = ($page == $i)? ' active page_active' : '';
                    echo '<li class="page-item halaman-draft '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
                }

                if($page == $jumlah_page){
                    echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
                } else {
                    $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                    echo '<li class="page-item halaman-draft" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item halaman-draft" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
                }
                ?>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <div class="btn btn-sm btn-primary download_ot">Download</div>
                <!-- <div class="btn btn-sm btn-primary request_ot">Request</div>
                <div class="btn btn-sm btn-danger del_ot">Delete</div> -->
            </div>
        </div>
        
        <?php
    }else{

        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;
        // echo $end;
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
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        // echo $cari;
        $level = $level;
        $npk = $npkUser;
        $ot_type = $_GET['conf'];
        // $query = "SELECT "
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_req_ot.id_ot,
            view_req_ot.npk,
            view_req_ot.nama,
            view_req_ot.shift,
            view_req_ot.ot_code,
            view_req_ot.requester,
            view_req_ot.in_date,
            view_req_ot.work_date,
            view_req_ot.start,
            view_req_ot.out_date,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity,
            view_req_ot.status_approve,
            view_req_ot.status_progress,
            view_req_ot.post,
            view_req_ot.grp,
            view_req_ot.sect,
            view_req_ot.dept,
            view_req_ot.dept_account,
            view_req_ot.division,
            view_req_ot.plant
            FROM view_req_ot";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        // echo $filter_cari;
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterDraft = " AND CONCAT(view_req_ot.status_approve, view_req_ot.status_progress) IS NULL AND view_req_ot.id_ot = '$ot_type' ";
        $filterProg = "";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterProg.$filterDraft;
        
        // echo $query_req_overtime
                
        ?>
        <div class="row">
            <div class="col-md-12">
                
                <div class="table-responsive">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NPK</th>
                                <th>Nama</th>
                                <th>Shift</th>
                                <th>Group</th>
                                <th>Administratif</th>
                                <th>Tgl Kerja</th>
                                <th colspan="2">Mulai</th>
                                <th colspan="2">Selesai</th>
                                <th>Activity</th>
                                <th>Kode Job</th>
                                <th>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="allreq">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $query_req_overtime)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY work_date DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        // $no = 1*$page;

                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        
                    
                        $sql = mysqli_query($link, $query_req_overtime.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                $query_group = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                                $group_ = mysqli_fetch_assoc($query_group);
                                $query_deptAcc = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc'  ")or die(mysqli_error($link));
                                $deptAcc = mysqli_fetch_assoc($query_deptAcc);
                                $group = $group_['nama_org'];
                                $dept_acc = $deptAcc['nama_org'];
                                $start = ($data['start'] == '00:00:00')? "-" : jam($data['start']);
                                $end = ($data['start'] == '00:00:00')? "-" : jam($data['end']);
                                $work_date = $data['work_date'];
                                $limit_date = tgl(date('Y-m-t', strtotime($data['work_date'])));
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                
                                ?>
                                <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                    <td class="td"><?=$dept_acc ?></td>
                                    <td class="td"><?=tgl($data['work_date'])?></td>
                                    <td class="td"><?=tgl($data['in_date'])?></td>
                                    <td class="td"><?=$start?></td>
                                    <td class="td"><?=$data['out_date']?></td>
                                    <td class="td"><?=$end?></td>
                                    <td class="td text-truncate" style="max-width:200px"><?=$data['activity']?></td>
                                    <td class="td"><?=$data['job_code']?></td>
                                    <td class="td">
                                        <div class="form-check text-right">
                                            <label class="form-check-label ">
                                                <input class="form-check-input mp_req " name="request[]" type="checkbox" value="<?=$data['id_ot']?>&&<?=$data['npk']?>&&<?=$data['work_date']?>">
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    
                                
                                </tr>

                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="14" class="text-center">Semua Berkas Telah Diajukan</td>
                            </tr>
                            <?php
                        }
                        
                        ?>
                        
                    </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
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
                    echo '<li class="page-item halaman-draft" id="1"><a class="page-link" >First</a></li>';
                    echo '<li class="page-item halaman-draft" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                }

                for($i = $start_number; $i <= $end_number; $i++){
                    $link_active = ($page == $i)? ' active page_active' : '';
                    echo '<li class="page-item halaman-draft '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
                }

                if($page == $jumlah_page){
                    echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
                } else {
                    $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                    echo '<li class="page-item halaman-draft" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item halaman-draft" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
                }
                ?>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <div class="btn btn-sm btn-primary request_ot">Request</div>
                <div class="btn btn-sm btn-danger del_ot">Delete</div>
            </div>
        </div>
        
        <?php
    }
}
?>



