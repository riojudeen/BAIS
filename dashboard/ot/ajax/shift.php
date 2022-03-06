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
    $fillterApp = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[approve]' OR";
}else{
    $fillterApp = '';
}
if($reject != ''){
    $fillterRej = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[reject]' OR";
}else{
    $fillterRej = '';
}
if($wait != ''){
    $fillterWait = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[wait]' OR";
    
}else{
    $fillterWait ='';
}
if($proses != ''){
    $fillterPros = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[proses]' OR";
}else{
    $fillterPros ='';
}
if($return != ''){
    $fillterRet = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[return]' OR";
}else{
    $fillterRet = '';
}
if($stop != ''){
    $fillterStop = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[stop]' OR";
}else{
    $fillterStop = '';
}
if($close != ''){
    $fillterClose = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[close]' OR";
}else{
    $fillterClose = '';
}
if($online != ''){
    $fillterOnl = " CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[online]' OR";
}else{
    $fillterOnl = '';
}
$gabung = $fillterApp.$fillterRej.$fillterWait.$fillterPros.$fillterRet.$fillterStop.$fillterClose.$fillterOnl;
$gabungApproval = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '50a' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100b' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '25a'
    )";
$gabungProses = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '75a' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100c' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100d' OR
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '25a'
    )";
$gabungSukses = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100a' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100f' 
    )";
// echo $gabung;

if(isset($_GET['id'])){
    // echo count($_GET['sort']);
    // count($_GET['sort']);
    if($_GET['id'] == 'shift'){
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
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        // $origin_query = "SELECT view_absen_req.id_absensi,
        // view_absen_req.npk,
        // view_absen_req.nama,
        // view_absen_req.employee_shift, 
        // view_absen_req.req_shift, 
        // view_absen_req.grp,
        // view_absen_req.dept_account,
        // view_absen_req.req_work_date,
        // view_absen_req.keterangan,
        // view_absen_req.req_date_in,
        // view_absen_req.req_date_out,
        // view_absen_req.req_in,
        // view_absen_req.req_out,
        // view_absen_req.shift_req,
        // view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
        // FROM view_absen_req ";
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
     
     
     $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter;
     
      
        ?>
    
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6">Pengajuan Shift</h6>
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
                                <th>Group</th>
                                <th>Administratif</th>
                                <th>Shift</th>
                                <th class="text-right">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY npk DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        // $no = 1*$page;

                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        
                    
                        $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                ?>
                                    <tr >
                                        <td class="td"><?=$no++?></td>
                                        <td class="td"><?=$data['npk']?></td>
                                        <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                        <td style="max-width:100px" class="text-truncate"><?=$data['groupfrm']?></td>
                                        <td class="td"><?=$data['dept_account']?></td>
                                        <td class="td"><?=$data['shift']?></td>
                                        <td class="text-right">
                                            <div id="<?=$data['npk']?>" class="btn btn-sm btn-primary shift_req">Pindah Shift</div>
                                        </td>
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
    }else if($_GET['id'] == 'shift_proccess'){
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
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_absen_req.id_absensi,
        view_absen_req.npk,
        view_absen_req.nama,
        view_absen_req.employee_shift, 
        view_absen_req.req_shift, 
        view_absen_req.grp,
        view_absen_req.dept_account,
        view_absen_req.req_work_date,
        view_absen_req.keterangan,
        view_absen_req.req_date_in,
        view_absen_req.req_date_out,
        view_absen_req.req_in,
        view_absen_req.req_out,
        view_absen_req.shift_req,
        view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
        FROM view_absen_req ";
        // $origin_query = "SELECT 
        //     view_organization.npk,
        //     view_organization.nama,
        //     view_organization.tgl_masuk,
        //     view_organization.jabatan,
        //     view_organization.shift,
        //     view_organization.pos,
        //     view_organization.status,
        //     view_organization.pos,
        //     view_organization.groupfrm,
        //     view_organization.section,
        //     view_organization.dept,
        //     view_organization.subpos,
        //     view_organization.division,
        //     view_organization.dept_account
            
        //     FROM view_organization ";
     $access_org = orgAccess($level);
     $data_access = generateAccess($link,$level,$npk);
     $table = partAccess($level, "table");
     $field_request = partAccess($level, "field_request");
     $table_field1 = partAccess($level, "table_field1");
     $table_field2 = partAccess($level, "table_field2");
     $part = partAccess($level, "part");
     $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
     $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
     $add_tanggal = " AND req_work_date BETWEEN '$start' AND '$end'";
     $add_filter_monitor = "AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL AND shift_req = '1' ";
     
     $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
     $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$add_filter_monitor.$add_tanggal.$filterProg.$gabungProses;
    //   echo $queryMP;
        ?>
        <div class="row">

            <h6 class="col-md-12">Pengajuan Shift</h6>
        </div>
        <form class="collapse show collapse-view" id="dataSort">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                        <div class="card-body  mt-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input <?=$wait?> class="form-check-input all sort" type="checkbox" name="wait" id="wait" value="25a">
                                            <span class="form-check-sign">Waiting</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input <?=$proses?> class="form-check-input all sort" type="checkbox" name="proses" id="proses" value="75a">
                                            <span class="form-check-sign">Diproses</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input <?=$return?> class="form-check-input all sort" type="checkbox" name="return" id="return" value="100d">
                                            <span class="form-check-sign">Dikembalikan </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input <?=$stop?> class="form-check-input all sort" type="checkbox" name="stop" id="stop" value="100c">
                                            <span class="form-check-sign">Dihentikan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6"></h6>
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
                                <th>Group</th>
                                <th>Administratif</th>
                                <th>Shift Asal</th>
                                <th> Pindah Shift</th>
                                <th> Tanggal</th>
                                <th class="">Progress</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY npk DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        // $no = 1*$page;

                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        
                    
                        $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                $clr = authColor($data['req_status']);
                                $stt = authText($data['status']);
                                $prs = $data['req_status_absen'];
                                ?>
                                <tr >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,$data['grp'], 'group')?></td>
                                    <td class="td"><?=getOrgName($link, $data['dept_account'], 'deptAcc')?></td>
                                    <td class="td">Shift <?=$data['employee_shift']?></td>
                                    <td class="td">Shift <?=$data['req_shift']?></td>
                                    <td class="td"><?=tgl($data['req_work_date'])?></td>
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>
                                    <?=$stt?>
                                    </td>
                                    <td>
                                    <?php
                                        $status = $data['status'];
                                        // echo $status;
                                        list($request,$proses,$return,$stop,$approve,$reject,$delete) = btnProses($level, $status, 'btn' );
                                        list($request_,$proses_,$return_,$stop_,$approve_,$reject_,$delete_) = btnProses($level, $status, 'btn_visible' );
                                        // echo $delete;
                                        ?>
                                        <?php
                                        if($request_ == 1){
                                            ?>
                                            <a <?=$request?> href="../proses.php" class="btn btn-sm btn-link btn-icon btn-outline-success btn-round btn-success  request" type="button" 
                                                data-toggle="tooltip" data-placement="bottom" title="diajukan" data-id="<?=$data['id_absensi']?>&&<?=$data['req_code']?>&&<?=$data['shift_req']?>">
                                                <i class="nc-icon nc-send "></i>
                                            </a>
                                            <?php
                                        }
                                        if($delete_ == 1){
                                            ?>
                                            <a <?=$delete?> href="proses.php" class="btn btn-sm btn-icon btn-danger btn-round  remove " type="button" 
                                                data-toggle="tooltip" data-placement="bottom" title="delete" data-id="<?=$data['id_absensi']?>&&<?=$data['req_code']?>&&<?=$data['shift_req']?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
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
    }else if($_GET['id'] == 'shift_success'){
        $_GET['prog'] = '100a';
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
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_absen_req.id_absensi,
        view_absen_req.npk,
        view_absen_req.nama,
        view_absen_req.employee_shift, 
        view_absen_req.req_shift, 
        view_absen_req.grp,
        view_absen_req.dept_account,
        view_absen_req.req_work_date,
        view_absen_req.keterangan,
        view_absen_req.req_date_in,
        view_absen_req.req_date_out,
        view_absen_req.req_in,
        view_absen_req.req_out,
        view_absen_req.shift_req,
        view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
        FROM view_absen_req ";
        // $origin_query = "SELECT 
        //     view_organization.npk,
        //     view_organization.nama,
        //     view_organization.tgl_masuk,
        //     view_organization.jabatan,
        //     view_organization.shift,
        //     view_organization.pos,
        //     view_organization.status,
        //     view_organization.pos,
        //     view_organization.groupfrm,
        //     view_organization.section,
        //     view_organization.dept,
        //     view_organization.subpos,
        //     view_organization.division,
        //     view_organization.dept_account
            
        //     FROM view_organization ";
     $access_org = orgAccess($level);
     $data_access = generateAccess($link,$level,$npk);
     $table = partAccess($level, "table");
     $field_request = partAccess($level, "field_request");
     $table_field1 = partAccess($level, "table_field1");
     $table_field2 = partAccess($level, "table_field2");
     $part = partAccess($level, "part");
     $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
     $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
     $add_tanggal = " AND req_work_date BETWEEN '$start' AND '$end'";
     $add_filter_monitor = "AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL AND shift_req = '1' ";
     
     $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
     $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$add_filter_monitor.$add_tanggal.$filterProg;
    //   echo $queryMP;
        ?>
        
        
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6">Pengajuan Shift Close</h6>
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
                                <th>Group</th>
                                <th>Administratif</th>
                                <th>Shift Asal</th>
                                <th> Pindah Shift</th>
                                <th> Tanggal</th>
                                <th class="" colspan="2">Progress</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY npk DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        // $no = 1*$page;

                        // pagin
                        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                        
                        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                        
                    
                        $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            while($data = mysqli_fetch_assoc($sql)){
                                $clr = authColor($data['req_status']);
                                $stt = authText($data['status']);
                                $prs = $data['req_status_absen'];
                                ?>
                                <tr >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,$data['grp'], 'group')?></td>
                                    <td class="td"><?=getOrgName($link, $data['dept_account'], 'deptAcc')?></td>
                                    <td class="td">Shift <?=$data['employee_shift']?></td>
                                    <td class="td">Shift <?=$data['req_shift']?></td>
                                    <td class="td"><?=tgl($data['req_work_date'])?></td>
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>
                                    <?=$stt?>
                                    </td>
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
        function att_code(){
            var att_code = $('#attendance_code').val();
            $('#att_code').text(att_code)
        }
        att_code();
        att_type();
        function att_type(){
            var id = $('#attendance_type').val();
            $('#attendance_code').load("ajax/attendance_code.php?id="+id, function(){
                att_code();
            })
        }
        
        $('#attendance_type').change(function() {
            att_type();
        });
        $('#attendance_code').change(function() {
            att_code();
        });
    })
</script>