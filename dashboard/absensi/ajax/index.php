<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){

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
    // echo $gabung;

    if(isset($_GET['id'])){
        // echo count($_GET['sort']);
        // count($_GET['sort']);
        // $level = 3;
        if($_GET['id'] == 'req'){
            
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
                                                        <input name="npk" type="number" class="form-control no-border data-npk" id="npk_karyawan"  required>
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
                                                        <select name="jenis" type="number" id="attendance_type" class="form-control no-border" required >
                                                            <option value="">Pilih Jenis Pengajuan</option>
                                                            <?php
                                                            $query_attendance_type = mysqli_query($link, "SELECT * FROM attendance_type WHERE  `stats` = 1 ")or die(mysqli_error($link));
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
                                                        <select name="att_code" type="number" class="form-control no-border " id="attendance_code" required>
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
                                                        <input type="number" name="count" min="1" max="999" class="form-control no-border" id="jumlah_hari" value="1" required>
                                                        <div class="input-group-append ">
                                                            <span class="input-group-text px-3 py-0">
                                                                Hari
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="notification"></div>
                                                </div>
                                            </div>
                                            <button type="reset" class="btn btn-sm btn-warning reset d-none">Reset</button>
                                            <button type="button" class="btn btn-sm btn-info change_req d-none">Ubah Request</button>
                                            <button type="button" name="cek_request"  id="cekrequest"  class=" btn btn-sm btn-info cek_data " >Cek Request</button>
                                            <button type="submit" name="add_request" disabled id="prosesrequest"  class=" btn btn-sm btn-primary load-data pull-right" >Proses</button>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-none">
                    <div class="alert alert-danger" role="alert">
                        Selama masa testing untuk membantu pengecekan system pengajuan  <strong>SKTA / cuti / ijin lain-lain</strong> , 
                        mohon untuk mengupload juga dokumen Pengajuan  dengan format dan formulir yang telah disediakan. Terima Kasih!
                        <div class="btn btn-sm" data-toggle="modal" data-target="#modal_upload_ot">upload disini</div>
                    </div>
                </div>
            </div>        
            <div class="row">
                <h6 class="col-md-6 float-left mt-2">Konfirmasi Absensi</h6>
                
                <div class="col-md-6">
                    <div class="mr-2 float-right order-3">
                        <div class="input-group bg-transparent">

                            <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." value="">
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
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link navigasi-konfirmasi konfirmasi-active active title" id="TL" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Tidak Lengkap</a>
                            <a class="nav-item nav-link navigasi-konfirmasi title" id="M" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Mangkir / TA Keterangan</a>
                        </div>
                    </nav>
                </div>
            </div>
            <hr class="mt-0">
            <div id="data-absensi">

            </div>
            
            <div class="modal fade" id="modal_upload_ot" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <h5 class="modal-title text-left col-md-6" id="exampleModalLabel">Upload dokumen pengajuan</h5>
                                <div class="col-md-6">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form_upload" action="proses-ot-upload.php" enctype="multipart/form-data">
                                <div class="row">
                                    <?php
                                    list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npkUser);
                                    $query_nama = mysqli_query($link, "SELECT npk, nama from karyawan WHERE npk = '$npk' ")or die(mysqli_error($link));
                                    $sql = mysqli_fetch_assoc($query_nama);
                                    if($group == ''){
                                        if($sect == ''){
                                            if($dept == ''){
                                                $data_area = "";
                                                $name_org = "";
                                            }else{
                                                $data_area = $dept;
                                                $name_org = getOrgName($link, $data_area, "dept");
                                            }
                                        }else{
                                            $data_area = $sect;
                                            $name_org = getOrgName($link, $data_area, "section");
                                        }
                                    }else{
                                        $data_area = $group;
                                        $name_org = getOrgName($link, $data_area, "group");
                                    }
                                    $data_nama = $sql['nama']."-".$npk;
                                    $today = date('Y-m-d');

                                    ?>
                                    <div class="col-md-3 pr-1 d-none">
                                        <div class="form-group">
                                            <input type="hidden" name="name_requester" id="name_requester" value="<?=$data_nama?>" class=" form-control no-border"  required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 pr-1">
                                        <div class="form-group">
                                            <label for="">Area</label>
                                            <input type="text" name="group_ot_name" id="group_ot_name" value="<?=$name_org?>" class=" form-control no-border"  required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 pr-1">
                                        <div class="form-group">
                                            <label for="">Kode Area</label>
                                            <input type="text" name="group_ot" id="group_ot" readonly value="<?=$dept?>" class=" form-control no-border" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 pr-1">
                                        <div class="form-group">
                                            <label for="">NPK Karyawan</label>
                                            <input type="number" name="att_npk" id="att_npk" value="<?=$npkUser?>" class=" form-control no-border"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pr-1">
                                        <div class="form-group">
                                            <label for="">Tanggal Kerja</label>
                                            <input type="date" name="tanggal_kerja_ot" id="tanggal_kerja_ot" value="<?=$today?>" class=" form-control no-border"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pb-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Shift Karyawan s</label>
                                                <div class="form-group">
                                                    <select name="shift_ot" id="shift_ot" class="form-control no-border"  required>
                                                        <?php
                                                            $query_shift_ = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                                            if(mysqli_num_rows($query_shift_)>0){
                                                                while($data = mysqli_fetch_assoc($query_shift_)){
                                                                    ?>
                                                                    <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                                    <?php
                                                                }
                                                            }else{
                                                                ?>
                                                                <option value="">Belum Ada Data Shift</option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pb-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Jenis Pengajuan</label>
                                                <div class="form-group">
                                                    <select name="att_type_upload" id="att_type_upload" class="form-control no-border"  required>
                                                        <option value="SUPEM">Surat Pemberitahuan</option>
                                                        <option value="SKTA">Surat Keterangan Tidak Absen</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                                    
                                    <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                            <input type="text" class="form-control mx-0">
                                        </div>
                                        <div >
                                            <span class="btn btn-sm btn-link btn-round btn-rose btn-file ">
                                            <span class="fileinput-new ">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                                <input type="file"  name="file_ot" id="file_ot"/>
                                            </span>
                                            <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="upload_ot" >Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    data_Active()
                    $('.navigasi-konfirmasi').on('click', function(){
                        $('.navigasi-konfirmasi').removeClass('konfirmasi-active');
                        $(this).addClass('konfirmasi-active');
                        data_Active()
                    })
                    $(document).on('click', '.halaman-konfirmasi', function(){
                        var page = $(this).attr("id");
                        data_Active(page)
                        // console.log(hal)
                    });
                    $(document).on('blur', '#cari', function(){
                        // var cari = $(this).val()
                        data_Active()
                        // console.log(cari);
                    });
                    function data_Active(page){

                        var div_id = $('#s_div').val();
                        var dept_id = $('#s_dept').val();
                        var section_id = $('#s_section').val();
                        var group_id = $('#s_goupfrm').val();
                        var deptAcc_id = $('#s_deptAcc').val();
                        var shift = $('#s_shift').val();
                        
                        var cari = $('#cari').val();
                        
                        var conf = $('.konfirmasi-active').attr('id');
                        var id = $('.data-active').attr('data-id');
                        var start = $('#startDate').val();
                        var end = $('#endDate').val();
                        $.ajax({
                            url:"ajax/data-absensi.php",
                            method:"GET",
                            data:{conf:conf, page:page,cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,filter:'yes'},
                            success:function(data){
                                $('#data-absensi').fadeOut('fast', function(){
                                    $(this).html(data).fadeIn('fast');
                                });
                                // $('#data-monitoring').html(data)
                            }
                        })
                    }
                })
            </script>
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
                                    <th>IN</th>
                                    <th>OUT</th>
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
                                        $sql_absensiHR = mysqli_query($link, "SELECT check_in AS 'in_abs' , check_out AS 'out_abs' FROM absensi WHERE id = '$data[id_absensi]'")or die(mysqli_error($link));
                                        $data_absensiHR = mysqli_fetch_assoc($sql_absensiHR);
                                        $in_abs = isset($data_absensiHR['in_abs'])?(($data_absensiHR['in_abs'] != '00:00:00')?jam($data_absensiHR['in_abs']):'-'):'-';
                                        $out_abs = isset($data_absensiHR['out_abs'])?(($data_absensiHR['out_abs'] != '00:00:00')?jam($data_absensiHR['out_abs']):'-'):'-';
                                    if($data['req_code'] != 'SKTA'){
                                        $in = $in_abs;
                                        $out = $out_abs;
                                        $clr_in = ($in == "-")?"":"";
                                        $clr_out = ($out == "-")?"":"";
                                    }else{
                                        $in = $checkIn;
                                        $out = $checkOut;
                                        $clr_in = ($in_abs == "-")?"text-danger":"";
                                        $clr_out = ($out_abs == "-")?"text-danger":"";
                                    }
                                    
                                    ?>
                                    <tr id="<?=$data['id_absensi']?>" >
                                        <td class="td"><?=$no++?></td>
                                        <td class="td"><?=$data['npk']?></td>
                                        <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                        <td class="td"><?=$data['employee_shift']?></td>
                                        <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                        <td class="td"><?=$dept_acc ?></td>
                                        <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                        <td class="td <?=$clr_in?>"  ><?=$in?></td>
                                        <td class="td <?=$clr_out?>"><?=$out?></td>
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
                        <table class="table table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NPK</th>
                                    <th>Nama</th>
                                    <th>Shift</th>
                                    <th>Group</th>
                                    <th>Administratif</th>
                                    <th>Tanggal</th>
                                    <th>In</th>
                                    <th>Out</th>
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
                                        $sql_absensiHR = mysqli_query($link, "SELECT check_in AS 'in_abs' , check_out AS 'out_abs' FROM absensi WHERE id = '$data[id_absensi]'")or die(mysqli_error($link));
                                        $data_absensiHR = mysqli_fetch_assoc($sql_absensiHR);
                                        $in_abs = isset($data_absensiHR['in_abs'])?(($data_absensiHR['in_abs'] != '00:00:00')?jam($data_absensiHR['in_abs']):'-'):'-';
                                        $out_abs = isset($data_absensiHR['out_abs'])?(($data_absensiHR['out_abs'] != '00:00:00')?jam($data_absensiHR['out_abs']):'-'):'-';
                                    if($data['req_code'] != 'SKTA'){
                                        $in = $in_abs;
                                        $out = $out_abs;
                                        $clr_in = ($in == "-")?"":"";
                                        $clr_out = ($out == "-")?"":"";
                                    }else{
                                        $in = $checkIn;
                                        $out = $checkOut;
                                        $clr_in = ($in_abs == "-")?"text-danger":"";
                                        $clr_out = ($out_abs == "-")?"text-danger":"";
                                    }
                                    ?>
                                    <tr id="<?=$data['id_absensi']?>" >
                                        <td class="td"><?=$no++?></td>
                                        <td class="td"><?=$data['npk']?></td>
                                        <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                        <td class="td"><?=$data['employee_shift']?></td>
                                        <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                        <td class="td"><?=$dept_acc ?></td>
                                        <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                        <td class="td <?=$clr_in?>"><?=$in?></td>
                                        <td class="td <?=$clr_out?>"><?=$out?></td>
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
                                    <th>In</th>
                                    <th>Out</th>
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
                                        $sql_absensiHR = mysqli_query($link, "SELECT check_in AS 'in_abs' , check_out AS 'out_abs' FROM absensi WHERE id = '$data[id_absensi]'")or die(mysqli_error($link));
                                        $data_absensiHR = mysqli_fetch_assoc($sql_absensiHR);
                                        $in_abs = isset($data_absensiHR['in_abs'])?(($data_absensiHR['in_abs'] != '00:00:00')?jam($data_absensiHR['in_abs']):'-'):'-';
                                        $out_abs = isset($data_absensiHR['out_abs'])?(($data_absensiHR['out_abs'] != '00:00:00')?jam($data_absensiHR['out_abs']):'-'):'-';
                                    if($data['req_code'] != 'SKTA'){
                                        $in = $in_abs;
                                        $out = $out_abs;
                                        $clr_in = ($in == "-")?"":"";
                                        $clr_out = ($out == "-")?"":"";
                                    }else{
                                        $in = $checkIn;
                                        $out = $checkOut;
                                        $clr_in = ($in_abs == "-")?"text-danger":"";
                                        $clr_out = ($out_abs == "-")?"text-danger":"";
                                    }
                                    ?>
                                    <tr id="<?=$data['id_absensi']?>" >
                                        <td class="td"><?=$no++?></td>
                                        <td class="td"><?=$data['npk']?></td>
                                        <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                        <td class="td"><?=$data['employee_shift']?></td>
                                        <td style="max-width:100px" class="text-truncate"><?=$group?></td>
                                        <td class="td"><?=$dept_acc ?></td>
                                        <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                        <td class="td <?=$clr_in?>"><?=$in?></td>
                                        <td class="td <?=$clr_out?>"><?=$out?></td>
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
            
            function get_notifData(){
                var data = $('#notification_result').attr('data-id');
                var max = $('#aloc_day').val()
                if(max != 'undefined' || max != ''){
                    console.log(max);
                    $('#jumlah_hari').attr('max', max)
                }
                if(data == '1'){
                    // console.log(data)
                    $('#prosesrequest').prop('disabled', false )
                }else if(data == '0'){
                    // console.log(data)
                    $('#prosesrequest').prop('disabled', true )
                }else{
                    // console.log(data)
                    $('#prosesrequest').prop('disabled', true )
                }
            }
            get_notifData()
            function get_cek(){
            
                var npk = $('#npk_karyawan').val();
                var mulai = $('#tanggal_mulai').val();
                var jumlah_hari = $('#jumlah_hari').val();
                var code = $('#attendance_code').val();

                // console.log("ok");
                $.ajax({
                    url:"ajax/notification.php",
                    method:"GET",
                    data:{npk:npk,mulai:mulai,total:jumlah_hari,code:code},
                    success:function(data){
                        $('.notification').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                            get_notifData()
                        });
                        // $('#data-monitoring').html(data)
                    }
                })
                // $('.notification').html()
            }
            $('.cek_data').on('click',  function(e){
                e.preventDefault();
                var attCode = $('#attendance_code').val();
                var npk = $('#npk_karyawan').val();
                // console.log(attCode)
                if(attCode == '' || npk == ''){
                    Swal.fire({
                        title: 'Form Belum Lengkap',
                        text: 'Pastikan Semua Formulir Telah Diisi',
                        timer: 2000,
                        
                        icon: 'error',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                }else{
                    $('#npk_karyawan').prop('readonly',true);
                    $('#tanggal_mulai').prop('readonly',true);
                    // $('#jumlah_hari').prop('readonly',true);
                    $('#attendance_code').attr('readonly',true);
                    $('#attendance_type').attr('readonly',true);
                    $(this).addClass('d-none')
                    $('.reset').removeClass('d-none')
                    $('.change_req').removeClass('d-none')
                    get_cek();

                }
            })
            // $('.data-npk').on('keyup', function(){
            //     get_cek();
            // })
            // $('#attendance_code').on('change',  function(){
            //     get_cek();
            // })
            // $('#tanggal_mulai').on('change', function(){
            //     get_cek();
            // })
            // $('#jumlah_hari').on('change', function(){
            //     get_cek();
            // })
            $('.change_req').on('click',  function(){
                
                // $('.data-npk').val('');
                $('#npk_karyawan').prop('readonly',false);
                $('#tanggal_mulai').prop('readonly',false);
                $('#jumlah_hari').prop('readonly',false);
                $('#attendance_code').attr('readonly',false);
                    $('#attendance_type').attr('readonly',false);
                $(this).addClass('d-none')
                $('.cek_data').removeClass('d-none')
                // get_cek();
                $('#jumlah_hari').attr('max', 999)
            })
            $('.reset').on('click',  function(){
                $('.data-npk').val('');
                $('#npk_karyawan').prop('readonly',false);
                $('#tanggal_mulai').prop('readonly',false);
                $('#jumlah_hari').prop('readonly',false);
                $('#attendance_code').attr('readonly',false);
                    $('#attendance_type').attr('readonly',false);
                $(this).addClass('d-none')
                $('.cek_data').removeClass('d-none')
                $('.change_req').addClass('d-none')
                // get_cek();
                $('#jumlah_hari').attr('max', 999)
            })
            att_code();
            att_type();
            function att_code(){
                var att_code = $('#attendance_code').val();
                $('#att_code').text(att_code)
            }
            
            function att_type(){
                var id = $('#attendance_type').val();
                $('#attendance_code').load("ajax/attendance_code.php?id="+id, function(){
                    att_code();
                })
            }
            
            $('#attendance_type').on('change',function() {
                att_type();
            });
            $('#attendance_code').on('change', function() {
                att_code();
            });
        })
    </script>
    <?php
}
?>