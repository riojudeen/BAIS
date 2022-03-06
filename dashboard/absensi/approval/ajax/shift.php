<?php

//////////////////////////////////////////////////////////////////////
include("../../../../config/config.php");
if(isset($_SESSION['user'])){
    
    if($level >=6 && $level <=8){
        
        require_once("../../../../config/approval_system.php");
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
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
            view_absen_req.req_shift, 
            view_absen_req.grp,
            view_absen_req.dept_account,
            view_absen_req.req_work_date,
            view_absen_req.req_date_in,
            view_absen_req.req_date_out,
            view_absen_req.req_date,
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
        $exception = " AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) <> '100e' AND req_date IS NOT NULL  AND shift_req = '1' ";
        $filterType = ($_GET['att_type'] != '' )?" AND req_code = '$_GET[att_type]'":"";
        list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND req_work_date BETWEEN '$start' AND '$end' ".$add_filter.$filterType.$filterProg.$exception;
        // echo $_GET['att_type'];
        // echo $query_req_absensi;
        
        // echo $addFilterDeptAcc;
        // echo $addFilterShift;
        // if($filter == "yes"){
        //     $query_req_absensi = $origin_query." WHERE req_work_date BETWEEN '$start' AND '$end' ".$add_filter;
        // }else{
        //     $query_req_absensi = $query_req_absensi;
        // }
        // echo $filter;
        // echo $query_req_absensi;
        $status = authApprove($level, "status", "approved");
        $req_status = authApprove($level, "request", "approved");
        // echo $status.$req_status;
        ?>
        
        <form class="table-responsive" name="proses" method="POST" id="formAbsensi">
            <table class="table table-hover">
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Shift</th>
                        <th>Group</th>
                        <th>Dept</th>
                        <th>Shift Asal</th>
                        <th>Shift Tujuan</th>
                        <th>Tanggal Pindah</th>
                        <th>Tanggal Pengajuan</th>
                        <th colspan="2">Progress</th>
                        <th class="text-right">Action</th>
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
                                <td class="td">Shift <?=$data['employee_shift']?></td>
                                <td class="td">Shift <?=$data['req_shift']?></td>
                                <td class="td"><?=tgl_indo($data['req_work_date'])?></td>
                                <td class="td"><?=tgl_indo($data['req_date'])?></td>
                                
                                <td class="td">
                                    <div class="progress" style="border-radius: 50px; width: 100px; height: 20px; margin: 0px">
                                        <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="td"><?=$stt?></td>
                                <td class="text-right">
                                    <div id="<?=$data['npk']?>" class="btn btn-sm btn-link btn-primary shift_req"><i class="fa fa-print"></i>  Print</div>
                                </td>
                                <td>
                                    <div class="form-check text-right">
                                        <label class="form-check-label ">
                                            <input class="form-check-input mp " name="checked[]" type="checkbox" value="<?=$data['id_absensi']?>&&<?=$data['req_code']?>&&<?=$data['shift_req']?>">
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
                            <td colspan="14" class="text-center"><?=noData()?></td>
                        </tr>
                        <?php
                    }
                    
                    ?>
                    
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </form>
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
        
        <!-- <script>
        // Initialize DataTables API object and configure table
        var table = $('#example1').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
            "url": "ajax/dataTables.php",
            "data": function ( d ) {
                return $.extend( {}, d, {
                "search_keywords": $("#searchInput").val().toLowerCase(),
                "filter_option": $("#sortBy").val().toLowerCase()
                } );
            }
            }
        });

        $(document).ready(function(){
            // Redraw the table
            table.draw();
            
            // Redraw the table based on the custom input
            $('#searchInput,#sortBy').bind("keyup change", function(){
                table.draw();
            });
        });
        </script> -->
        <!-- <script>
            
        $(document).ready(function() {
            $('#example').DataTable( {
                "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
                "scrollY":        '50vh',
                "order": [[ 1, "desc" ]],
                "processing": true,
                "serverSide": true,
                "ajax": "ajax/dataTables.php"
                
            } );
        } );
        </script> -->
        <?php
    }else{
        include_once ("../../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>