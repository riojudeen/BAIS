<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($_GET['id'] == 'monitor_view'){
        
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        // echo $start;
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
        $data_tanggal = json_decode(get_date($start, $end));
        
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        
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
        `end` FROM `view_hr_ot`
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
        $queryOT = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$tanggal_filter;
        
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
       

    //    echo $queryMP.$addLimit;      
        ?>
        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive text-nowrap" >
                    <table class="table-sm table-striped text-uppercase" id="tb_absensi" style="width:100%">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>NPK</th>
                                <th>Nama</th>
                                <th>Shift</th>
                                <th>Group</th>
                                <th>Administratif</th>
                                <th>Tanggal</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        
                    
                        $sql = mysqli_query($link, $queryOT.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            
                            while($dataOT = mysqli_fetch_assoc($sql)){
                                
                                $checkIn = ($dataOT['start'] == '00:00:00')? "-" : jam($dataOT['start']);
                                $checkOut = ($dataOT['end'] == '00:00:00')? "-" : jam($dataOT['end']);
                                $work_date = $dataOT['work_date'];
                                $limit_date = tgl(date('Y-m-t', strtotime($dataOT['work_date'])));
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                ?>
                                <tr id="<?=$dataOT['id_absensi']?>" >
                                    <td class="td"><?=$no?></td>
                                    <td class="td"><?=$dataOT['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$dataOT['nama']?></td>
                                    <td class="td"><?=$dataOT['shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,  $dataOT['grp'], "group")?></td>
                                    <td class="td"><?=getOrgName($link, $dataOT['dept_account'], "deptAcc")?></td>
                                    <td class="td"><?=$dataOT['work_date']?></td>
                                    <td class="td"><?=$checkIn?></td>
                                    <td class="td"><?=$checkOut?></td>
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
        
    }else if($_GET['id'] == 'summary'){
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        $today = (strtotime($end) >= strtotime(date('Y-m-d')))?date('Y-m-d'):$end;
        // echo $start;
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
            FROM view_req_ot_bulk";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        


        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        $filterSukses = " AND CONCAT(view_req_ot.status_approve, view_req_ot.status_progress) = '100a' ";
       
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterSukses;
        
        echo $query_req_overtime;

        $total_nonProd = " AND job_code <> 'PROD' AND (job_code IS NOT NULL OR job_code = '') ";
        $total_prod = " AND job_code = 'PROD' AND (job_code IS NOT NULL OR job_code = '') ";

        
        /*
        $addWFO = " AND att_alias = '1' ";
        $addTL = " AND att_alias = '2' ";
        $addT = " AND att_alias = '3' ";
        $addC = " AND att_alias = '4' ";
        $addCL = " AND att_alias = '5' ";
        $addS = " AND att_alias = '6' ";
        $addP = " AND att_alias = '7' ";
        $addWFH = " AND att_alias = '8' ";
        $addM = " AND att_alias = '9' ";

        $sql_wfo = mysqli_query($link, $query_req_absensi.$addWFO)or die(mysqli_error($link));
        $sql_tl = mysqli_query($link, $query_req_absensi.$addTL)or die(mysqli_error($link));
        $sql_t = mysqli_query($link, $query_req_absensi.$addT)or die(mysqli_error($link));
        $sql_c = mysqli_query($link, $query_req_absensi.$addC)or die(mysqli_error($link));
        $sql_cl = mysqli_query($link, $query_req_absensi.$addCL)or die(mysqli_error($link));
        $sql_s = mysqli_query($link, $query_req_absensi.$addS)or die(mysqli_error($link));
        $sql_p = mysqli_query($link, $query_req_absensi.$addP)or die(mysqli_error($link));
        $sql_wfh = mysqli_query($link, $query_req_absensi.$addWFH)or die(mysqli_error($link));
        $sql_m = mysqli_query($link, $query_req_absensi.$addM)or die(mysqli_error($link));

        $totalWFO = mysqli_num_rows($sql_wfo);
        $totalTL = mysqli_num_rows($sql_tl);
        $totalT = mysqli_num_rows($sql_t);
        $totalC = mysqli_num_rows($sql_c);
        $totalCL = mysqli_num_rows($sql_cl);
        $totalS = mysqli_num_rows($sql_s);
        $totalP = mysqli_num_rows($sql_p);
        $totalWFH = mysqli_num_rows($sql_wfh);
        $totalM = mysqli_num_rows($sql_m);
        ?>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats bg-success text-white">
                    <div class="card-body py-2 my-2">
                        <div class="row ">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-briefcase text-white"></i>
                                    
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category text-white">Total Overtime</p>
                                    <p class="card-title"><?=$totalWFO?> MP
                                    <p>
                                    <a class="stretched-link view_data text-white" id="1" ></a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats text-white" style="background:#FF9E00">
                    <div class="card-body py-2 my-2">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-white">
                                    <i class="nc-icon nc-touch-id text-white"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category text-white">Overtime Produksi</p>
                                    <p class="card-title"><?=$totalTL?> MP
                                    <p>
                                    <a class="stretched-link view_data text-white" id="2" ></a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats bg-warning text-white" >
                    <div class="card-body py-2 my-2">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-white">
                                    <i class="nc-icon nc-user-run text-white"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category text-white">Overtime Non Produksi</p>
                                    <p class="card-title"><?=$totalT?> MP
                                    <p>
                                    <a class="stretched-link view_data text-white" id="3" ></a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        */
    }else if($_GET['id'] == 'modal'){
        $_GET['prog'] = '';
        $data_filter = ($_GET['data'] != '')?" AND att_alias = '$_GET[data]' ":'';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        $today = (strtotime($end) >= strtotime(date('Y-m-d')))?date('Y-m-d'):$end;

        $query_attAlias = mysqli_query($link, "SELECT `name` FROM attendance_alias WHERE id = '$_GET[data]' ")or die(mysqli_error($link));
        $nama_ = mysqli_fetch_assoc($query_attAlias);
        $nama = $nama_['name'];
        
        // echo $start;
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
            view_absen_hr.CODE,
            view_absen_hr.att_alias
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
        
        // view_absen_hr.req_in IS NULL OR view_absen_hr.req_out IS NULL OR view_absen_hr.req_code IS NULL OR view_absen_hr.att_alias = '9'
        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        // echo $filter_cari;
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$today' AND '$today' ".$add_filter.$data_filter;
        

        $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
        $total_records= mysqli_num_rows($sql_jml);
        // echo $total_records;
 
        $page = (isset($_GET['page']))? $_GET['page'] : 1;
        // echo $page;
        $limit = 100; 
        $limit_start = ($page - 1) * $limit;
        $no = $limit_start + 1;
        // echo $limit_start;
        $addOrder = " ORDER BY view_absen_hr.work_date DESC ";
        $addLimit = " LIMIT $limit_start, $limit";
        // $no = 1*$page;
 
        // pagin
        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
        
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
        
        $sql = mysqli_query($link, $query_req_absensi.$addOrder.$addLimit)or die(mysqli_error($link));
        ?>
            <!-- Modal -->
                    <div class="modal-header">
                        <h5 class="modal-title pull-left" id="staticBackdropLabel"><?=$nama?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body border px-0" data-id="<?=$_GET['data']?>" >
                        <div class="row">
                            <div class="col-md-12">

                                <div class="table-full-width">
                                    <table class="table-sm table-striped text-uppercase" id="tb_absensi" style="width:100%">
                                        <thead class="table-info">
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
                                            </tr>
                                        </thead>
                                        <tbody class="text-uppercase text-nowrap">
                                        
                                        <?php
                                        if(mysqli_num_rows($sql) > 0){
        
                                            while($dataOT = mysqli_fetch_assoc($sql)){
                                                $checkIn = ($dataOT['check_in'] == '00:00:00')?'':jam($dataOT['check_in']);
                                                $checkOut = ($dataOT['check_out'] == '00:00:00')?'':jam($dataOT['check_out']);
                                                ?>
                                                    <tr id="<?=$dataOT['id_absensi']?>" >
                                                    <td class="td"><?=$no++?></td>
                                                    <td class="td"><?=$dataOT['npk']?></td>
                                                    <td style="max-width:200px" class="text-truncate td"><?=$dataOT['nama']?></td>
                                                    <td class="td"><?=$dataOT['employee_shift']?></td>
                                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,  $dataOT['grp'], "group")?></td>
                                                    <td class="td"><?=getOrgName($link, $dataOT['dept_account'], "deptAcc")?></td>
                                                    <td class="td"><?=tgl($dataOT['work_date'])?></td>
                                                    <td class="td"><?=$checkIn?></td>
                                                    <td class="td"><?=$checkOut?></td>
                                                    <td class="td"><?=$dataOT['CODE']?></td>
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
                                    </table>
                                </div>
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
                                    echo '<li class="page-item halaman_modal" id="1" data-id="'.$_GET['data'].'"><a class="page-link" >First</a></li>';
                                    echo '<li class="page-item halaman_modal" id="'.$link_prev.'"data-id="'.$_GET['data'].'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                                }

                                for($i = $start_number; $i <= $end_number; $i++){
                                    $link_active = ($page == $i)? ' active page_modal_active' : '';
                                    echo '<li class="page-item halaman_modal '.$link_active.'" id="'.$i.'" data-id="'.$_GET['data'].'"><a class="page-link" >'.$i.'</a></li>';
                                }

                                if($page == $jumlah_page){
                                    echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                                    echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
                                } else {
                                    $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                                    echo '<li class="page-item halaman_modal" id="'.$link_next.'" data-id="'.$_GET['data'].'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                                    echo '<li class="page-item halaman_modal" id="'.$jumlah_page.'" data-id="'.$_GET['data'].'"><a class="page-link" >Last</a></li>';
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>

                
    
  

<!-- Modal -->

        </div>
        
        <?php
    }else if($_GET['id'] == 'callendar_view'){
        $mulai = dateToDB($_GET['start']);
        $selesai = dateToDB($_GET['end']);
        $data_tanggal = json_decode(get_date($mulai, $selesai));
        // print_r($data_tanggal);

        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        // echo $start;
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

        $origin_query_overtime = "SELECT `id_ot`,
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
        `end` FROM `view_hr_ot`";

        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        // $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        // filter data organisasi
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter;
        // filter data absensi
        $tanggal = " AND work_date BETWEEN '$start' AND '$end' ";
        $access_org_abs = orgAccess($level);
        $add_filter_absen = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $queryOT = filtergenerator($link, $level, $generate, $origin_query_overtime, $access_org_abs).$add_filter_absen.$tanggal;
    //    echo $queryOT;
        // pagination
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
        
        
        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
        
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
       
        // echo $queryMP;
    
        ?>

        <div class="table-responsive table-bordered" >
            <table class="table table-hover  text-uppercase" id="tb_absensi" style="border: #C6C7C8;width:100%">
            
                <thead class="text-white  table-info" style="border: #C6C7C8">
                    <tr >
                        <th scope="col" rowspan="2" style="width:50px;border:1px solid white">No</th>
                        <th scope="col" rowspan="2" style="width:100px;border:1px solid white">NPK</th>
                        <th scope="col" rowspan="2" style="width:200px;border:1px solid white">Nama</th>
                        <th scope="col" rowspan="2" style="width:100px;border:1px solid white">SHF</th>
                        <th scope="col" rowspan="2" style="width:10px;border:1px solid white">area</th>
                        <th scope="col" rowspan="2" style="width:100px;border:1px solid white">dept</th>
                        <th scope="col" rowspan="2" style="width:100px;border:1px solid white">Monitor</th>
                        <?php
                            $offset = 10; //triger offset untuk limit

                            $i = 0;
                            $array_tgl = array();
                            foreach($data_tanggal AS $tgl){
                                $hari = hari_singkat($tgl);
                                $tanggal = tgl($tgl);
                                $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(211, 84, 0, 0.3)" : "";
                                echo "<th scope=\"col\" colspan=\"2\" style=\"text-align: center;".$color."\">$tanggal</th>";
                            }
                            
                        ?>

                        <tr>
                        <?php
                        foreach($data_tanggal AS $tgl){
                            $hari = hari_singkat($tgl);
                            $date = $tgl;
                            $cell_ = date('D, d - M', strtotime($date));
                            $cell = explode(' ', $cell_);
                            $color = ($cell['0'] == "Sun," || $cell['0'] == "Sat," ) ? "background: rgba(211, 84, 0, 0.3)" : "";
                            ?>
                            <th scope="col" style="width:100px;border:1px solid white; <?=$color?>">IN</th>
                            <th scope="col" style="width:100px;border:1px solid white; <?=$color?>">OUT</th>

                            <?php
                            
                        }
                        
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query mp
                    $no_spl = 1;
                    // echo $queryOT;
                    $sql_monMp = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql_monMp)>0){
                        while($data_mon = mysqli_fetch_assoc($sql_monMp)){
                            
                            ?>
                        <tr>
                            <th  scope="row"><?=$no++?></td>
                            <td style="max-width:100px" class="text-truncate" ><?=$data_mon['npk']?></td>
                            <td style="max-width:200px" class="text-truncate" ><?=$data_mon['nama']?></td>
                            <td  style="max-width:50px" class="text-truncate"  ><?=$data_mon['shift']?></td>
                            <td  style="max-width:200px" class="text-truncate"  ><?=$data_mon['groupfrm']?></td>
                            <td  style="max-width:200px" class="text-truncate"  ><?=$data_mon['dept_account']?></td>
                            <td  style="max-width:100px" class="text-truncate"  ">Overtime</td>
                            <?php
                            
                            
                                
                            foreach($data_tanggal as $tgl_){//looping tanggal request
                                //ambil array data lembur 
                                $qry_ot = $queryOT." AND work_date = '$tgl_' ";
                                
                                $sqlOT = mysqli_query($link, $qry_ot)or die(mysqli_error($link));
                                $dataOT = mysqli_fetch_assoc($sqlOT);
    
                                $check_in = ($dataOT['start'] == "00:00:00" || $dataOT['start'] == "")?"":jam($dataOT['start']);
                                $check_out = ($dataOT['end'] == "00:00:00") || $dataOT['end'] == ""?"":jam($dataOT['end']);
                                $hari = hari_singkat($tgl_);
                                $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(228, 227, 227, 0.5)" : "";
    
                                ?>
                                
                                <td style="min-width:100px ;max-width:100px; <?=$color?>" class="bg- text-" ><?=$check_in?></td>
                                <td style="min-width:100px ;max-width:100px; <?=$color?>" class="bg- text-" ><?=$check_out?></td>
                                <?php
                                flush();
                            }
    
                            ?>
                            
                            
                            
                            
                        </tr>
                        
                        <?php
                        
                        }
                    }else{
                        noData();
                    }
                    ?>
                </tbody>
                    
            </table>
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
    }
}else{
    include_once ("../../no_access.php");
}