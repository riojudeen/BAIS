<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");

if(isset($_SESSION['user'])){
    $_GET['prog'] = '';
            // $_GET['cari'] = '';
            $_GET['att_type'] = $_GET['conf'];
            $start = $_GET['start'];
            $end = $_GET['end'];
            // echo $start;
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
            list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
            $origin_query = "SELECT view_absen_hr.id_absensi,
                view_absen_hr.npk,
                view_absen_hr.nama,
                view_absen_hr.employee_shift,
                view_absen_hr.grp,
                view_absen_hr.dept_account,
                view_absen_hr.work_date,
                view_absen_hr.check_in,
                view_absen_hr.check_out,
                view_absen_hr.CODE
                FROM view_absen_hr ";
            $access_org = orgAccess($level);
            $data_access = generateAccess($link,$level,$npk);
            $table = partAccess($level, "table");
            $field_request = partAccess($level, "field_request");
            $table_field1 = partAccess($level, "table_field1");
            $table_field2 = partAccess($level, "table_field2");
            $part = partAccess($level, "part");
            $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
            $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
            $exception = " AND view_absen_hr.CODE  <> '' AND view_absen_hr.CODE = '$_GET[att_type]' ";
            // view_absen_hr.req_in IS NULL OR view_absen_hr.req_out IS NULL OR view_absen_hr.req_code IS NULL OR view_absen_hr.att_alias = '9'
            $filter_cari = ($add_filter != '')?"( $add_filter)":'';
            // list($status, $req_status) = pecahProg("$_GET[prog]");
            $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
            $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterProg.$exception;
            
            // echo $query_req_absensi;
            // echo $_GET['conf'];
?>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive text-nowrap" >
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NPK</th>
                            <th>Nama</th>
                            <th>Shift</th>
                            <th>Group</th>
                            <th>Administratif</th>
                            <th>Tanggal</th>
                            <th>in</th>
                            <th>out</th>
                            <th>Ket</th>
                            <th>Batas</th>
                            <th class="text-right">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody class="text-uppercase text-nowrap">
                    <?php
                    $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
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
                    
                
                    $sql = mysqli_query($link, $query_req_absensi.$addOrder.$addLimit)or die(mysqli_error($link));
                    
                    if(mysqli_num_rows($sql)>0){
                        while($data = mysqli_fetch_assoc($sql)){
                            $query_group = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                            $group_ = mysqli_fetch_assoc($query_group);
                            $query_deptAcc = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc'  ")or die(mysqli_error($link));
                            $deptAcc = mysqli_fetch_assoc($query_deptAcc);
                            $group = $group_['nama_org'];
                            $dept_acc = $deptAcc['nama_org'];
                            $checkIn = ($data['check_in'] == '00:00:00')? "-" : jam($data['check_in']);
                            $checkOut = ($data['check_out'] == '00:00:00')? "-" : jam($data['check_out']);
                            $work_date = $data['work_date'];
                            $limit_date = tgl(date('Y-m-t', strtotime($data['work_date'])));
                            $today = date('Y-m-d');//harus diganti tanggal out kerja
                            $str_date = strtotime($work_date);
                            $str_limit = strtotime($limit_date);
                            $str_today = strtotime($today);
                            $q_cekReq = mysqli_query($link, "SELECT check_in , check_out, keterangan, requester FROM req_absensi WHERE shift_req <> 1 AND id_absensi = '$data[id_absensi]' ")or die(mysqli_error($link));
                            


                            if($str_today < $str_limit){
                                $dsbld = "";
                                $clr = "warning";
                            }else{
                                $clr = "danger";
                                if( $level == 8 || $level == 7 || $level == 6 || $level == 5){
                                    $dsbld = "";
                                }else{
                                    $dsbld = "disabled";
                                }
                            }
                            if(mysqli_num_rows($q_cekReq) <= 0 ){
                                ?>
                                <tr id="<?=$data['id_absensi']?>" >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['employee_shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                    <td class="td"><?=$dept_acc ?></td>
                                    <td class="td"><?=tgl($data['work_date'])?></td>
                                    <td class="td"><?=$checkIn?></td>
                                    <td class="td"><?=$checkOut?></td>
                                    <td class="td"><?=$data['CODE']?></td>
                                    <td class="td">
                                        <span class="badge badge-sm badge-<?=$clr?>">
                                            <?=tgl(date('Y-m-t', strtotime($data['work_date'])))?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                            
                                            if($_GET['conf'] == 'TL'){
                                                ?>
                                                <a <?=$dsbld?> href="add.php?id=<?=$data['id_absensi']?>&req=SUKET" class="  btn btn-success  btn-sm">SKTA</a>
                                                <a <?=$dsbld?> href="add.php?id=<?=$data['id_absensi']?>&req=SUPEM" class="  btn btn-primary btn-sm">Cuti / Ijin</a>
                                                <?php

                                            }else{
                                                ?>
                                                <a <?=$dsbld?> href="add.php?id=<?=$data['id_absensi']?>&req=SUKET" class="  btn btn-success  btn-sm">SKTA</a>
                                                <a <?=$dsbld?> href="add.php?id=<?=$data['id_absensi']?>&req=SUPEM" class="  btn btn-primary btn-sm">Cuti / Ijin</a>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                
                                </tr>

                                <?php
                            }
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
        </div>
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
}
?>



