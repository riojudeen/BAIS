<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
$approve = (isset($_GET['approve']))?"checked":"";
$reject = (isset($_GET['reject']))?"checked":"";
$wait = (isset($_GET['wait']))?"checked":"";
$proses = (isset($_GET['proses']))?"checked":"";
$return = (isset($_GET['return']))?"checked":"";
$stop = (isset($_GET['stop']))?"checked":"";
$close = (isset($_GET['close']))?"checked":"";
$online = (isset($_GET['online']))?"checked":"";

if($approve != ''){
    $fillterApp = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[approve]' OR";
}else{
    $fillterApp = '';
}
if($reject != ''){
    $fillterRej = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[reject]' OR";
}else{
    $fillterRej = '';
}
if($wait != ''){
    $fillterWait = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[wait]' OR";
    
}else{
    $fillterWait ='';
}
if($proses != ''){
    $fillterPros = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[proses]' OR";
}else{
    $fillterPros ='';
}
if($return != ''){
    $fillterRet = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[return]' OR";
}else{
    $fillterRet = '';
}
if($stop != ''){
    $fillterStop = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[stop]' OR";
}else{
    $fillterStop = '';
}
if($close != ''){
    $fillterClose = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[close]' OR";
}else{
    $fillterClose = '';
}
if($online != ''){
    $fillterOnl = " CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[online]' OR";
}else{
    $fillterOnl = '';
}
$gabung = $fillterApp.$fillterRej.$fillterWait.$fillterPros.$fillterRet.$fillterStop.$fillterClose.$fillterOnl;
$gabungApproval = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '50a' OR 
    CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100b' OR 
    CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '25a'
    )";
$gabungProses = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '75a' OR 
    CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100c' OR 
    CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100d'
    )";
$gabungSukses = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100a' OR 
    CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100f' 
    )";
// echo $gabung;    

if(isset($_GET['id'])){
    // echo count($_GET['sort']);
    // count($_GET['sort']);
    if($_GET['id'] == 'req'){
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
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
        $filterDraft = " AND CONCAT(view_req_ot.status_approve, view_req_ot.status_progress) IS NULL ";
        $filterProg = "";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterProg.$filterDraft;
        

        // data mp
        $origin_queryMp = "SELECT 
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
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        // echo $group_filter;
        $queryMP = filtergenerator($link, $level, $generate, $origin_queryMp, $access_org).$add_filter;
        
        
        $shift_order = " GROUP BY shift ORDER BY shift ASC ";
        $q_group_shift = $queryMP.$shift_order;
        // echo $q_group_shift;
        $sql_shift = mysqli_query($link, $q_group_shift)or die(mysqli_error($link));

        $today = date('Y-m-d');
        // echo  $query_req_overtime;
        ?>
    
        <div class="row">
            <div class="col-md-12">
                
                <div class="collapse collapse-view show" id="tambah">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                
                                    <form method="get" action="">
                                        
                                        <div class="row">
                                        
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label for="">Tanggal Kerja</label>
                                                    <input type="date" name="tanggal_kerja" value="<?=$today?>" class=" form-control no-border" id="work_date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pb-0">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">Jenis Overtime</label>
                                                        <div class="form-group">
                                                            <select name="ot_type" type="number" class="form-control no-border" id="ot_type" required>
                                                                <option disabled value="">Pilih Overtime Type</option>
                                                                <option value="PO" selescted>Post Overtime</option>
                                                                <option value="EO">Early Overtime</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pb-0">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">Shift Karyawan</label>
                                                        <div class="form-group">
                                                            <select name="shift_request" class="form-control no-border" id="shift_request" required>
                                                                <?php
                                                                    
                                                                    if(mysqli_num_rows($sql_shift)>0){
                                                                        while($data = mysqli_fetch_assoc($sql_shift)){
                                                                            ?>
                                                                            <option value="<?=$data['shift']?>"><?=$data['shift']?></option>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                        <option value="">Belum Ada data Karyawan untuk shift <?=$shift?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Total Activity</label>
                                                <div class="row">
                                                    <div class="col-md-10 pr-1">
                                                        <div class="form-group">
                                                            <input type="number" class="count_more form-control total_activity" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 text-right pl-1">
                                                        <button type="button" class="btn mt-0 btn-success btn-icon  add_more">
                                                        <i class="fas fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn mt-0 btn-danger btn-icon kurangi">
                                                        <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div id="filter-input"></div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <h6 class="col-md-6 title">Pengajuan Overtime</h6>
                    <div class="col-md-6">
                        <div class="mr-2 float-right order-3">
                            <div class="input-group bg-transparent">

                                <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." value="<?=$cari?>">
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
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link navigasi-konfirmasi konfirmasi-active active title" id="TL" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Detail</a>
                        <a class="nav-item nav-link navigasi-konfirmasi title" id="M" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Bulk </a>
                    </div>
                </nav>
            </div>
        </div>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-12">
                <form class="table-responsive text-nowrap" method="POST" id="form_request">
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
                </form>
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
                <div class="btn btn-sm btn-primary request_ot">Request</div>
                <div class="btn btn-sm btn-danger del_ot">Delete</div>
            </div>
        </div>
        <?php
        /*
        <div class="row">
            <div class="col-md-12">
                <form class="table-responsive text-nowrap" method="POST" id="form_request">
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

                        $qry_ot_new = "SELECT  
                            lembur._id AS id_ot,
                            karyawan.npk AS npk,
                            karyawan.nama AS nama,
                            karyawan.shift AS shift,
                            lembur.kode_lembur AS `ot_code`,
                            lembur.requester AS `requester`,
                            
                            lembur.work_date AS work_date,
                            lembur.in_date AS `in_date`,
                            lembur.out_date AS `start`,
                            lembur.max_out AS `out_date`,
                            lembur.min_in AS `end`,
                            lembur.kode_job AS `job_code`,
                            lembur.aktifitas AS `activity`, 
                            
                            lembur.status_approve AS `status_approve`,
                            lembur.status AS `status_progress`,
                            lembur.tanggal_input AS `req_date`,
                            org.sub_post AS sub_post,
                            org.post AS post,
                            org.grp AS grp,
                            org.sect AS sect,
                            org.dept AS dept,
                            org.dept_account AS dept_account,
                            org.division AS division,
                            org.plant AS plant
                            
                        FROM (SELECT lembur._id,
                                lembur.kode_lembur,
                                lembur.requester,
                                lembur.npk,
                                lembur.work_date,
                                lembur.in_date,
                                lembur.out_date,
                                max(lembur.out_lembur) AS max_out, 
                                min(lembur.in_lembur) AS min_in,
                                lembur.tanggal_input,
                                lembur.status_approve, lembur.status ,
                                    GROUP_CONCAT(aktifitas) AS aktifitas,
                                    GROUP_CONCAT(kode_job) AS kode_job
                                FROM lembur GROUP BY lembur.npk,lembur.work_date,lembur._id ) 
                                AS lembur
                        JOIN karyawan ON karyawan.npk = lembur.npk
                        JOIN org ON org.npk = lembur.npk
                        WHERE lembur.work_date = '2022-04-06' AND CONCAT(lembur.status_approve,lembur.status) IS NULL ";
                        $sql_jml = mysqli_query($link, $qry_ot_new )or die(mysqli_error($link));
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
                        
                    
                        $sql_overtime = mysqli_query($link, $qry_ot_new.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql_overtime)>0){
                            while($data = mysqli_fetch_assoc($sql_overtime)){
                                // $query_group = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[grp]' AND part = 'group' ")or die(mysqli_error($link));
                                // $group_ = mysqli_fetch_assoc($query_group);
                                // $query_deptAcc = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$data[dept_account]' AND part = 'deptAcc'  ")or die(mysqli_error($link));
                                // $deptAcc = mysqli_fetch_assoc($query_deptAcc);
                                // $group = $group_['nama_org'];
                                // $dept_acc = $deptAcc['nama_org'];
                                // $start = ($data['start'] == '00:00:00')? "-" : jam($data['start']);
                                // $end = ($data['start'] == '00:00:00')? "-" : jam($data['end']);
                                // $work_date = $data['work_date'];
                                // $limit_date = tgl(date('Y-m-t', strtotime($data['work_date'])));
                                // $str_date = strtotime($work_date);
                                // $str_limit = strtotime($limit_date);
                                // $today = date('Y-m-d');//harus diganti tanggal out kerja
                                // $str_today = strtotime($today);
                                
                                ?>
                                <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"></td>
                                    <td class="td"></td>
                                    <td class="td"><?=$data['work_date']?></td>
                                    <td class="td"><?=$data['in_date']?></td>
                                    <td class="td"><?=$data['start']?></td>
                                    <td class="td"><?=$data['out_date']?></td>
                                    <td class="td"><?=$data['end']?></td>
                                    <td class="td text-truncate" style="max-width:200px"><?=$data['activity']?></td>
                                    <td class="td"><?=$data['job_code']?></td>
                                    <td class="td">
                                        <div class="form-check text-right">
                                            <label class="form-check-label ">
                                                <input class="form-check-input mp_req " name="request[]" type="checkbox" value="">
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
                </form>
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
                <div class="btn btn-sm btn-primary request_ot">Request</div>
                <div class="btn btn-sm btn-danger del_ot">Delete</div>
            </div>
        </div>

        <?php
        */
    }else if($_GET['id'] == 'approve'){
        
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;s
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
            view_req_ot.plant, CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) AS `status`
            FROM view_req_ot ";
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
        $exception = " AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '100e' ";
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[prog]' ":"";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$gabungApproval.$exception;
        // echo $query_req_overtime;
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Approval Pengajuan Overtime</h6>
                <form class="collapse show collapse-view"  method="POST" id="dataSort">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$wait?> class="form-check-input all sort" type="checkbox" name="wait"  value="25a">
                                                    <span class="form-check-sign">Menunggu Approval</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$approve?> class="form-check-input all sort" type="checkbox" name="approve"  value="50a">
                                                    <span class="form-check-sign">Pengajuan Disetujui </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$reject?> class="form-check-input all sort" type="checkbox" name="reject" value="100b">
                                                    <span class="form-check-sign">Pengajuan ditolak</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6 float-left mt-2"></h6>
                    <div class="col-md-6">
                        <div class="mr-2 float-right order-3">
                            <div class="input-group bg-transparent">

                                <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." value="<?=$cari?>">
                                <div class="input-group-append bg-transparent">
                                    <div class="input-group-text bg-transparent">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <th>Tgl Kerja</th>
                                <th colspan="2">Mulai</th>
                                <th colspan="2">Selesai</th>
                                <th>Activity</th>
                                <th>Kode Job</th>
                                <th colspan="2">Progress</th>
                                
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
                                $clr = authColor($data['status_progress']);
                                $stt = authText($data['status']);
                                $prs = $data['status_approve'];
                                
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
                                    <td class="td"><?=tgl($data['out_date'])?></td>
                                    <td class="td"><?=$end?></td>
                                    <td class="td text-truncate" style="max-width:200px"><?=$data['activity']?></td>
                                    <td class="td"><?=$data['job_code']?></td>
                                    
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?= $stt?></td>
                                
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
    }else if($_GET['id'] == 'proccess'){
       
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;s
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
            view_req_ot.plant, CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) AS `status`
            FROM view_req_ot ";
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
        
        $exception = " AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '100e' ";
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[prog]' ":"";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$gabungProses.$exception;
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Approval Pengajuan Overtime</h6>
                <form class="collapse show collapse-view" id="dataSort">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$proses?> class="form-check-input all sort" type="checkbox" name="proses" id="proses" value="75a">
                                                    <span class="form-check-sign">Pangajuan Diproses</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$return?> class="form-check-input all sort" type="checkbox" name="return" id="return" value="100d">
                                                    <span class="form-check-sign">Pengajuan Dikembalikan </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$stop?> class="form-check-input all sort" type="checkbox" name="stop" id="stop" value="100c">
                                                    <span class="form-check-sign">Pengajuan Dihentikan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6 float-left mt-2"></h6>
                    <div class="col-md-6">
                        <div class="mr-2 float-right order-3">
                            <div class="input-group bg-transparent">

                                <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." value="<?=$cari?>">
                                <div class="input-group-append bg-transparent">
                                    <div class="input-group-text bg-transparent">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <th>Tgl Kerja</th>
                                <th colspan="2">Mulai</th>
                                <th colspan="2">Selesai</th>
                                <th>Activity</th>
                                <th>Kode Job</th>
                                <th colspan="2">Progress</th>
                                
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
                                $clr = authColor($data['status_progress']);
                                $stt = authText($data['status']);
                                $prs = $data['status_approve'];
                                
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
                                    <td class="td"><?=tgl($data['out_date'])?></td>
                                    <td class="td"><?=$end?></td>
                                    <td class="td text-truncate" style="max-width:200px"><?=$data['activity']?></td>
                                    <td class="td"><?=$data['job_code']?></td>
                                    
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?= $stt?></td>
                                
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
        
    }else if($_GET['id'] == 'success'){
        
        $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;s
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
            view_req_ot.plant, CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) AS `status`
            FROM view_req_ot ";
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
        
        $exception = " AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '100e' ";
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '$_GET[prog]' ":"";
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$gabungSukses.$exception;
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Approval Pengajuan Overtime</h6>
                <form class="collapse show collapse-view" id="dataSort">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$online?> class="form-check-input all sort" type="checkbox" name="online" id="online" value="100f">
                                                    <span class="form-check-sign">Pending Approval Online</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?=$close?> class="form-check-input all sort" type="checkbox" name="close" id="close" value="100a">
                                                    <span class="form-check-sign">Pengajuan Success / Close</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6 float-left mt-2"></h6>
                    <div class="col-md-6">
                        <div class="mr-2 float-right order-3">
                            <div class="input-group bg-transparent">

                                <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." value="<?=$cari?>">
                                <div class="input-group-append bg-transparent">
                                    <div class="input-group-text bg-transparent">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <th>Tgl Kerja</th>
                                <th colspan="2">Mulai</th>
                                <th colspan="2">Selesai</th>
                                <th>Activity</th>
                                <th>Kode Job</th>
                                <th colspan="2">Progress</th>
                                
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
                                $clr = authColor($data['status_progress']);
                                $stt = authText($data['status']);
                                $prs = $data['status_approve'];
                                
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
                                    <td class="td"><?=tgl($data['out_date'])?></td>
                                    <td class="td"><?=$end?></td>
                                    <td class="td text-truncate" style="max-width:200px"><?=$data['activity']?></td>
                                    <td class="td"><?=$data['job_code']?></td>
                                    
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?= $stt?></td>
                                
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
    }
}
?>

<script>
$(document).ready(function(){
   
    $('.checkAll').on('click', function(){
        if(this.checked){
            $('.checkOne').each(function() {
                this.checked = true;
            })
        } else {
            $('.checkOne').each(function() {
                this.checked = false;
            })
        }
    });
    $('.checkOne').on('click', function() {
        if($('.checkOne:checked').length == $('.checkOne').length){
            $('.checkAll').prop('checked', true)
        } else {
            $('.checkAll').prop('checked', false)
        }
    })
})
</script>

<script>
    $(document).ready(function(){
        
        function add_more(){
            var total = Number($('.count_more').val())+1;
            $('.count_more').val(total)
        }
        function kurangi(){
            var total = Number($('.count_more').val())-1;
            $('.count_more').val(total)
        }
        $('.add_more').on('click', function(){
            add_more()
            filterInput()
        })
        $('.kurangi').on('click', function(){
            kurangi()
            filterInput()
        })
        function filterInput(){
            var count = Number($('.count_more').val())
            var work_date = $('#work_date').val();
            var type = $('#ot_type').val();
            var shift = $('#shift_request').val()
            
            console.log(count);
            $.ajax({
                url:"ajax/filter-input.php",
                method:"GET",
                data:{
                    shift : shift,
                    work_date:work_date,
                    type:type,
                    count : count
                },
                success:function(data){
                    $('#filter-input').html(data)
                }
            })
        }
        $('#shift_request').on('change', function(){
            filterInput()
        })
        $('#ot_type').on('change', function(){
            filterInput()
        })
        $('#work_date').on('change', function(){
            filterInput()
        })
        // filterInput()
        
        
    })
</script>