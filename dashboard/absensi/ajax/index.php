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
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100d'
    )";
$gabungSukses = ($gabung != '')?" AND (".substr($gabung, 0, -2).")":" AND 
    (CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100a' OR 
    CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '100f' 
    )";
echo $gabung;

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
        $exception = " AND view_absen_hr.CODE  <> '' AND (view_absen_hr.CODE = 'M' OR view_absen_hr.CODE = 'TL' ) ";
        // view_absen_hr.req_in IS NULL OR view_absen_hr.req_out IS NULL OR view_absen_hr.req_code IS NULL OR view_absen_hr.att_alias = '9'
        $filter_cari = ($add_filter != '')?"( $add_filter)":'';
        // echo $filter_cari;
        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterProg.$exception;
        
        // echo $query_req_absensi;

        // $qry = "SELECT
        //     bais_db.absensi.id AS id_absensi,
        //     bais_db.absensi.npk AS npk,
        //     bais_db.karyawan.nama AS nama,
        //     bais_db.karyawan.shift AS employee_shift,

        //     bais_db.org.sub_post AS sub_post,
        //     bais_db.org.post AS post,
        //     bais_db.org.grp AS grp,
        //     bais_db.org.sect AS sect,
        //     bais_db.org.dept AS dept,
        //     bais_db.org.dept_account AS dept_account,
        //     bais_db.org.division AS division,
        //     bais_db.org.plant AS plant,

        //     bais_db.absensi.shift AS att_shift,
        //     bais_db.absensi.date AS work_date,
        //     bais_db.absensi.check_in AS check_in,
        //     bais_db.absensi.check_out AS check_out,
        //     bais_db.absensi.ket AS CODE,

        //     bais_db.attendance_code.keterangan AS keterangan,
        //     bais_db.attendance_code.type AS att_type,
        //     bais_db.attendance_code.alias AS att_alias

        //     -- bais_db.req_absensi.shift AS req_shift,
        //     -- bais_db.req_absensi.date AS req_work_date,
        //     -- bais_db.req_absensi.date_in AS req_date_in,
        //     -- bais_db.req_absensi.date_out AS req_date_out,
        //     -- bais_db.req_absensi.check_in AS req_in,
        //     -- bais_db.req_absensi.check_out AS req_out,
        //     -- bais_db.req_absensi.keterangan AS req_code,
            
        //     -- bais_db.req_absensi.requester AS requester,
        //     -- bais_db.req_absensi.status AS req_status_absen,
        //     -- bais_db.req_absensi.req_status AS req_status,
        //     -- bais_db.req_absensi.req_date AS req_date

           
            
        // FROM bais_db.absensi
        // JOIN bais_db.org ON bais_db.absensi.npk = bais_db.org.npk
        // LEFT JOIN bais_db.karyawan ON bais_db.org.npk = bais_db.karyawan.npk
        
        // LEFT JOIN bais_db.attendance_code ON bais_db.attendance_code.kode = bais_db.absensi.ket";
    //  $sql= mysqli_query($link, $qry)or die(mysqli_error($link));
    //  echo mysqli_num_rows($sql);
        ?>
    
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="col-md-6">Pengajuan Absensi</h6>
                    
                </div>
                <div class="collapse show collapse-view" id="tambah">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                
                                    <form method="get" action="schedule.php">
                                        
                                        <div class="row">
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label for="">Tanggal Mulai</label>
                                                    <?php
                                                    $hari_ini = date('Y-m-d');
                                                    ?>
                                                    <input type="date" name="tanggal" value="<?=$hari_ini?>" class="datepicker form-control no-border" id="tanggal_mulai" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2 pl-1 pr-1">
                                                <div class="form-group">
                                                    <label for="">NPK Karyawan</label>
                                                    <input name="npk" type="number" class="form-control no-border data-npk" id="npk_karyawan" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label for="">Nama Karyawan</label>
                                                    <input type="text" readonly class="form-control no-border data-nama" >
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label for="">Jabatan</label>
                                                    <input type="text" readonly class="form-control no-border data-jabatan" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label for="">Jenis Pengajuan</label>
                                                    <select name="jenis" type="number" id="attendance_type" class="form-control no-border" required>
                                                        <option value="">Pilih Jenis Pengajuan</option>
                                                        <?php
                                                        $query_attendance_type = mysqli_query($link, "SELECT * FROM attendance_type WHERE `name` <> '' ")or die(mysqli_error($link));
                                                        while($data_attendance_type = mysqli_fetch_assoc($query_attendance_type)){
                                                            ?>
                                                            <option value="<?=$data_attendance_type['id']?>"><?=$data_attendance_type['name']?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5 pl-1 pr-1">
                                                <label for="">Pilih Pengajuan</label>
                                                <div class="input-group">
                                                    <select name="att_code" type="number" class="form-control no-border" id="attendance_code" required>
                                                        <option value="-">Pengajuan Belum Dipilih</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text px-2 py-0" id="att_code">
                                                            Kode
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Jumlah Hari</label>
                                                <div class="input-group">
                                                    <input type="number" name="count" min="1" class="form-control no-border" id="jumlah_hari" value="1" required>
                                                    <div class="input-group-append ">
                                                        <span class="input-group-text px-3 py-0">
                                                            Hari
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="reset" class="btn btn-sm btn-warning reset">Reset</button>
                                        <button type="submit" name="add_request" disabled id="prosesrequest"  class="d-none btn btn-sm btn-primary load-data pull-right" >Proses</button>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="notification"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <h6 class="col-md-6 float-left mt-2">Konfirmasi Absensi</h6>
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
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                

                                $q_cekReq = mysqli_query($link, "SELECT check_in , check_out, keterangan, requester FROM req_absensi WHERE shift_req <> 1 AND id_absensi = '$data[id_absensi]' ")or die(mysqli_error($link));
                                
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
                                            <span class="badge badge-sm badge-warning">
                                                <?=tgl(date('Y-m-t', strtotime($data['work_date'])))?>

                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <?php
                                                if($str_today > $str_limit){

                                                    ?>
                                                        <a  href="add.php?id=<?=$data['id_absensi']?>&req=SUKET" class="  btn btn-info  btn-sm">SKTA</a>
                                                        <a  href="add.php?id=<?=$data['id_absensi']?>&req=SUPEM" class="  btn btn-primary btn-sm">SUPEM</a>
                                        
                                                    <?php
                                                }else{
                                                    if($level == 8 || $level == 7 || $level == 6 || $level == 5){
                                                        ?>
                                                        <a  href="add.php?id=<?=$data['id_absensi']?>&req=SUKET" class="  btn btn-info  btn-sm">SKTA</a>
                                                        <a  href="add.php?id=<?=$data['id_absensi']?>&req=SUPEM" class="  btn btn-primary btn-sm">SUPEM</a>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="badge badge-sm badge-danger">expired</span>
                                                        <?php
                                                    }
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
    }else if($_GET['id'] == 'approve'){
        
        $_GET['prog'] = '';
        $_GET['cari'] = '';
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
        $origin_query = "SELECT view_absen_req.id_absensi,
            view_absen_req.npk,
            view_absen_req.nama,
            view_absen_req.employee_shift, 
            view_absen_req.grp,
            view_absen_req.dept_account,
            view_absen_req.req_work_date,
            view_absen_req.req_date_in,
            view_absen_req.req_date_out,
            view_absen_req.req_in,
            view_absen_req.req_out,
            view_absen_req.shift_req,
            view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
            FROM view_absen_req ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL  AND shift_req = '0' ";
        

        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$exception.$gabungApproval;
        // echo $query_req_absensi;
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
                                <th>Ket</th>
                                <th>Progress</th>
                                <th></th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']) && ($_GET['page'] != 'undefined' OR $_GET['page'] != ''))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY req_date, requester DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        $no = 1;

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
                                $clr = authColor($data['req_status']);
                                $stt = authText($data['status']);
                                $prs = $data['req_status_absen'];
                                $checkIn = ($data['req_in'] == '00:00:00')? "-" : jam($data['req_in']);
                                $checkOut = ($data['req_out'] == '00:00:00')? "-" : jam($data['req_out']);
                                ?>
                                <tr id="<?=$data['id_absensi']?>" >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['employee_shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                    <td class="td"><?=$dept_acc ?></td>
                                    <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                    <td class="td"><?=$data['req_code']?></td>
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?=$stt?></td>
                                    <td class="text-right">
                                        
                                            
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
    }else if($_GET['id'] == 'proccess'){
        $_GET['prog'] = '';
        $_GET['cari'] = '';
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
        $cari = $_GET['cari'];
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_absen_req.id_absensi,
            view_absen_req.npk,
            view_absen_req.nama,
            view_absen_req.employee_shift, 
            view_absen_req.grp,
            view_absen_req.dept_account,
            view_absen_req.req_work_date,
            view_absen_req.req_date_in,
            view_absen_req.req_date_out,
            view_absen_req.req_in,
            view_absen_req.req_out,
            view_absen_req.shift_req,
            view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
            FROM view_absen_req ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL  AND shift_req = '0' ";
        

        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$exception.$gabungProses;
        
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Overtime Diproses Admin</h6>
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
                                <th>Ket</th>
                                <th>Progress</th>
                                <th></th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']) && ($_GET['page'] != 'undefined' OR $_GET['page'] != ''))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY req_date, requester DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        $no = 1;

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
                                $clr = authColor($data['req_status']);
                                $stt = authText($data['status']);
                                $prs = $data['req_status_absen'];
                                $checkIn = ($data['req_in'] == '00:00:00')? "-" : jam($data['req_in']);
                                $checkOut = ($data['req_out'] == '00:00:00')? "-" : jam($data['req_out']);
                                ?>
                                <tr id="<?=$data['id_absensi']?>" >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['employee_shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                    <td class="td"><?=$dept_acc ?></td>
                                    <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                    <td class="td"><?=$data['req_code']?></td>
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?=$stt?></td>
                                    <td class="text-right">
                                        
                                            
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
        
    }else if($_GET['id'] == 'success'){
        $_GET['prog'] = '';
        $_GET['cari'] = '';
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
        $cari = $_GET['cari'];
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_absen_req.id_absensi,
            view_absen_req.npk,
            view_absen_req.nama,
            view_absen_req.employee_shift, 
            view_absen_req.grp,
            view_absen_req.dept_account,
            view_absen_req.req_work_date,
            view_absen_req.req_date_in,
            view_absen_req.req_date_out,
            view_absen_req.req_in,
            view_absen_req.req_out,
            view_absen_req.shift_req,
            view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
            FROM view_absen_req ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL  AND shift_req = '0' ";
        

        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$exception.$gabungSukses;
        
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Pengajuan Close</h6>
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
                                <th>Ket</th>
                                <th>Progress</th>
                                <th></th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        $sql_jml = mysqli_query($link, $query_req_absensi)or die(mysqli_error($link));
                        $total_records= mysqli_num_rows($sql_jml);
                        // echo $total_records;

                        $page = (isset($_GET['page']) && ($_GET['page'] != 'undefined' OR $_GET['page'] != ''))? $_GET['page'] : 1;
                        // echo $page;
                        $limit = 100; 
                        $limit_start = ($page - 1) * $limit;
                        $no = $limit_start + 1;
                        // echo $limit_start;
                        $addOrder = " ORDER BY req_date, requester DESC ";
                        $addLimit = " LIMIT $limit_start, $limit";
                        $no = 1;

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
                                $clr = authColor($data['req_status']);
                                $stt = authText($data['status']);
                                $prs = $data['req_status_absen'];
                                $checkIn = ($data['req_in'] == '00:00:00')? "-" : jam($data['req_in']);
                                $checkOut = ($data['req_out'] == '00:00:00')? "-" : jam($data['req_out']);
                                ?>
                                <tr id="<?=$data['id_absensi']?>" >
                                    <td class="td"><?=$no++?></td>
                                    <td class="td"><?=$data['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                    <td class="td"><?=$data['employee_shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                    <td class="td"><?=$dept_acc ?></td>
                                    <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                    <td class="td"><?=$data['req_code']?></td>
                                    <td class="td">
                                        <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                            <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="td"><?=$stt?></td>
                                    <td class="text-right">
                                        
                                            
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