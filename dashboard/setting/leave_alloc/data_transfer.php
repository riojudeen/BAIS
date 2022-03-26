<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
include("../../../config/approval_system.php"); 
//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
    $tanggalAwal = $_GET['start'];
    $tanggalAkhir = $_GET['end'];
?>

<div class="row ">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h5 class="title">Transfer Data Cuti Personal Site</h5>
                <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-sm btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="btn-label">
                        <i class="nc-icon nc-cloud-download-93"></i>
                    </span>
                Import Data
                </button>

            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
                                <div class="card-body  mt-2">
                                    <form method="post" enctype="multipart/form-data" action="import.php">
                                        <input type="hidden" name="import_cuti">
                                        <div class="form-group rounded py-auto text-center" style="border:1px dashed rgb(223, 220, 220);background:rgba(255, 255, 255, 0.3)">
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
                                                        <input type="file"  name="file_import" />
                                                    </span>
                                                    <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-sm" >
                                    </div>
                                    <a  class="btn btn-sm btn-danger  btn-link " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                                    <a  class="btn btn-sm btn-warning btn-link" href="<?=base_url()?>/file/template/Format_Upload_History_Cuti.xlsx" role="button" ><i class="nc-icon nc-cloud-download-93"></i> Download Format</a>
                                    <button type="submit" class="btn btn-sm btn-primary pull-right">Upload</button>
                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <form method="post" name="proses" action="" >
        <div class="table-responsive">
            <table class="table table-striped table_org text-nowrap" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Shift</th>
                        <th>group</th>
                        <th>Dept Admin</th>
                        <th>Tanggal</th>
                        <th>in</th>
                        <th>out</th>
                        <th>Ket</th>
                        <th>Note</th>
                        <th colspan="2">Progress</th>
                        <th>Tgl Arsip</th>
                        <th scope="col" class="sticky-col first-last-col first-last-top-col text-right">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="allmp">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                    <?php
                    // echo $tanggalAwal."<br>";
                    // echo $tanggalAkhir."<br>";
                    $_GET['prog'] = '';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;
        $filter = '';
        $div_filter = '';
        // echo $div;
        $dept_filter = '';
        // echo $dept_filter;
        $sect_filter = '';
        // echo $sect_filter;
        $group_filter = '';
        // echo $group_filter;
        $deptAcc_filter = '';
        // echo $deptAcc_filter;
        $shift = '';
        // echo $shift;
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        // echo $cari;
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
            view_absen_req.note,
            view_absen_req.delete_date,
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
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND (req_date IS NOT NULL) AND note = 'Transfer PS' AND (delete_date IS NOT NULL) AND shift_req = '0' ";
        

        $filterType = ($_GET['att_type'] != '' )?" AND att_type = '$_GET[att_type]'":"";
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$exception;
        
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

        // pagin
        $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
        
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
        
    
        $sql_req = mysqli_query($link, $query_req_absensi.$addOrder.$addLimit)or die(mysqli_error($link));

        // echo $query_req_absensi;
                    // echo mysqli_num_rows($sql_req);
                    if(mysqli_num_rows($sql_req) > 0){
                        while($data_reqAbsensi = mysqli_fetch_assoc($sql_req)){
                            $checkIn = (isset($data_reqAbsensi['req_in']))?(($data_reqAbsensi['req_in'] == '00:00:00')? "" : jam($data_reqAbsensi['req_in'])):"";
                            $checkOut = (isset($data_reqAbsensi['req_out']))?(($data_reqAbsensi['req_out'] == '00:00:00')? "" : jam($data_reqAbsensi['req_out'])):"";
                            $clr = authColor($data_reqAbsensi['req_status']);
                            $stt = authText($data_reqAbsensi['status']);
                            $prs = $data_reqAbsensi['req_status_absen'];
                        ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data_reqAbsensi['npk']?></td>
                            <td><?=$data_reqAbsensi['nama']?></td>
                            <td><?=$data_reqAbsensi['employee_shift']?></td>
                            <td><?=getOrgName($link, $data_reqAbsensi['grp'], "group")?></td>
                            <td><?=getOrgName($link, $data_reqAbsensi['dept_account'], "deptAcc")?></td>
                            <td><?=tgl($data_reqAbsensi['req_work_date'])?></td>
                            <td><?=$checkIn?></td>
                            <td><?=$checkOut?></td>
                            
                            <td><?=$data_reqAbsensi['req_code']?></td>
                            <td><?=$data_reqAbsensi['note']?></td>
                            <td class="td">
                                <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                    <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                            <td class="td"><?=$stt?></td>
                            <td><?=tgl($data_reqAbsensi['delete_date'])?></td>
                            
                            <td class="sticky-col first-last-col text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input  class="form-check-input mp" name="checked[]" type="checkbox" value="<?=$data_reqAbsensi['id_absensi']?>&&<?=$data_reqAbsensi['req_code']?>&&<?=$data_reqAbsensi['shift_req']?>">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </td>
                            
                        </tr>    
                            <?php
                        }
                    }else{
                        ?>
                        <tr><td colspan="13" class="text-center">Tidak ditemukan data di database</td></tr>
                        <?php
                    }
                    ?>
                    
                </tbody>
                <tfoot>

                </tfoot>
                    
            </table>
        

        <hr>
        </form>
           
    </div>
    <div class="box pull-right">
        <button  class="btn btn-danger  deleteall" >
            <span class="btn-label">
                <i class="nc-icon nc-simple-remove" ></i>
            </span>    
            Delete
        </button>

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
flush();
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>