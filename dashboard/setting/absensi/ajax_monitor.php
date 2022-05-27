<?php
require_once("../../../config/config.php");
require_once("../../../config/approval_system.php");
require "../../../_assets/vendor/autoload.php";
if(isset($_SESSION['user'])){
    
    $div_filter = $_GET['div'];
    // echo $div_filter;
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
    $cari = '';
    

        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        // echo $start;
        // $div_filter = $dept_filter = $sect_filter = $group_filter = $deptAcc_filter = $shift = $cari = '';
        // echo $shift;
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        // echo $cari;
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);


        if($_GET['data_port'] == 'nav-att'){

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
            // echo $add_filter;
            $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter;
            // echo $query_req_absensi;
    
    
            
            $page = (isset($_GET['page']) && $_GET['page'] != 'undefined' )? $_GET['page'] : 1;
            // echo $page;
            $limit = 100; 
            $limit_start = ($page - 1) * $limit;
            $no = $limit_start + 1;
            // echo $limit_start;
            $addOrder = " ORDER BY work_date DESC ";
            $addLimit = " LIMIT $limit_start, $limit";
            // $no = 1*$page;
    
            $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
            $sql = mysqli_query($link, $query_req_absensi.$addOrder.$addLimit)or die(mysqli_error($link));
            $total_records= mysqli_num_rows($sql_jml);
    
    
            // pagin
            $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
            
            $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
            $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
            $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
            
        
    
        ?>
        <form method="post" name="proses" action="" id="form_absensi">
          
        <div class="table-responsive">
            <table class="text-nowrap table table-striped " id="absensi_hr" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Shift</th>
                        <th>Group</th>
                        <th>Dept</th>
                        <th>Tanggal</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Ket</th>
                        <th>Diupdate Oleh</th>
                        <th class="text-right">
                            <div class="form-check ">
                                <label class="form-check-label">
                                    <input class="form-check-input check-all" type="checkbox" >
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(mysqli_num_rows($sql)>0){
                        while($data = mysqli_fetch_assoc($sql)){
                            $dept = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc' ")or die(mysqli_error($link));
                            $area = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                            $sql_area = mysqli_fetch_assoc($area);
                            $sql_dept = mysqli_fetch_assoc($dept);
                            $updater = mysqli_query($link, "SELECT absensi.date_in AS `date_in` , absensi.date_out AS `date_out` , karyawan.npk AS `npk`, karyawan.nama AS `nama` FROM absensi LEFT JOIN karyawan ON karyawan.npk = absensi.requester WHERE absensi.id = '$data[id_absensi]' ")or die(mysqli_error($link));
                            $dataUpdater = mysqli_fetch_assoc($updater);
                            $namaUpdater = (isset($dataUpdater['nama']))?nick($dataUpdater['nama'])."[$npk]":'';
                            $ci = (isset($data['check_in'])&& $data['check_in'] != '00:00:00')?jam($data['check_in']):"";
                            $co = (isset($data['check_out'])&& $data['check_out'] != '00:00:00')?jam($data['check_out']):"";
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['npk']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['employee_shift']?></td>
                                <td><?=$sql_area['nama_org']?></td>
                                <td><?=$sql_dept['nama_org']?></td>
                                <td><?=tgl($data['work_date'])?></td>
                                <td><?=tgl($dataUpdater['date_in'])?></td>
                                <td><?=tgl($dataUpdater['date_out'])?></td>
                                <td><?=$ci?></td>
                                <td><?=$co?></td>
                                <td><?=$data['CODE']?></td>
                                <td><?=$namaUpdater?></td>
                                <td>
                                    <div class="form-check text-right">
                                        <label class="form-check-label">
                                            <input class="form-check-input check"  name="checked[]" value="<?=$data['npk']?>" type="checkbox" data="<?=$no?>">
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
                            <td colspan="15" class="text-center"><?=noData()?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    
                </tbody>
            
            </table>
        </div>
        <div class="box pull-right">
            <button  class="btn btn-sm btn-danger  deleteall" >
                <span class="btn-label">
                    <i class="nc-icon nc-simple-remove" ></i>
                </span>    
                Delete
            </button>
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
    
    <?php
        
    }else if($_GET['data_port'] == 'nav-ot'){
        $origin_query = "SELECT `id_ot`,
        `npk`,
        `nama`,
        `shift`,
        `sub_post`,
        `post`,
        `grp`,
        `sect`,
        `dept`,
        `dept_account`,
        `division`,
        `plant`,
        `work_date`,
        `in_date`,
        `out_date`,
        `start`,
        `end`, `updated_by` FROM `view_hr_ot`
        ";
        $tanggal_filter = " AND work_date BETWEEN '$start' AND '$end' ";
       
        // echo $tanggal_filter;
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");


        $add_filter = filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $queryOT = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$tanggal_filter." AND ( `start` <> '00:00:00' OR `end` <> '00:00:00' ) ";

        
    //    echo $queryOT ;

       $sql_jml = mysqli_query($link, $queryOT)or die(mysqli_error($link));
       $total_records= mysqli_num_rows($sql_jml);
       // echo $total_records;

       $page = (isset($_GET['page']))? $_GET['page'] : 1;
       // echo $page;
       $limit = 100; 
       $limit_start = ($page - 1) * $limit;
       $no = $limit_start + 1;
       // echo $limit_start;
       $addOrder = " ORDER BY view_hr_ot.work_date DESC ";
       $addLimit = " LIMIT $limit_start, $limit";
       // $no = 1*$page;

       // pagin
       $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
       
       $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
       $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
       $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
       
    //    echo $queryOT.$addOrder.$addLimit;
    //    echo $queryMP.$addLimit;      
        ?>
        <div class="row">
            <form name="" class="col-md-12">

                <div class="table-responsive text-nowrap" >
                    <table class="table table-striped text-uppercase" id="tb_absensi" style="width:100%">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>NPK</th>
                                <th>Nama</th>
                                <th>Shift</th>
                                <th>Group</th>
                                <th>Dept</th>
                                <th>Tanggal</th>
                                <th colspan="2" >Mulai</th>
                                <th colspan="2">Selesai</th>
                                <th colspan="1">Diupdate Oleh</th>
                                <th class="text-right">
                                    <div class="form-check ">
                                        <label class="form-check-label">
                                            <input class="form-check-input check-all" type="checkbox" >
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        
                    
                        $sql = mysqli_query($link, $queryOT.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            
                            while($dataOT = mysqli_fetch_assoc($sql)){
                                $updater = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$dataOT[updated_by]' ")or die(mysqli_error($link));
                                $dataUpdater = mysqli_fetch_assoc($updater);
                                $namaUpdater = (isset($dataUpdater['nama']))?nick($dataUpdater['nama'])."[$npk]":'';
                                $checkIn = ($dataOT['start'] == '00:00:00')? "-" : jam($dataOT['start']);
                                $checkOut = ($dataOT['end'] == '00:00:00')? "-" : jam($dataOT['end']);
                                $work_date = $dataOT['work_date'];
                                $limit_date = tgl(date('Y-m-t', strtotime($dataOT['work_date'])));
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                ?>
                                <tr id="<?=$dataOT['id_ot']?>" >
                                    <td class="td"><?=$no?></td>
                                    <td class="td"><?=$dataOT['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$dataOT['nama']?></td>
                                    <td class="td"><?=$dataOT['shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,  $dataOT['grp'], "group")?></td>
                                    <td class="td"><?=getOrgName($link, $dataOT['dept_account'], "deptAcc")?></td>
                                    <td class="td"><?=tgl($dataOT['work_date'])?></td>
                                    <td class="td"><?=tgl($dataOT['in_date'])?></td>
                                    <td class="td"><?=$checkIn?></td>
                                    <td class="td"><?=tgl($dataOT['out_date'])?></td>
                                    <td class="td"><?=$checkOut?></td>
                                    <td class="td"><?=$namaUpdater?></td>
                                    <td>
                                        <div class="form-check text-right">
                                            <label class="form-check-label">
                                                <input class="form-check-input check"  name="checked[]" value="<?=$dataOT['id_ot']?>" type="checkbox" data="<?=$no?>">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
    
                                <?php
                                    
                                // }
                                $no++;

                                
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
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
    ?>
    