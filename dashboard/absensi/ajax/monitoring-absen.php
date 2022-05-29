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
        // $origin_query = "SELECT view_absen_hr.id_absensi,
        //     view_absen_hr.npk,
        //     view_absen_hr.nama,
        //     view_absen_hr.employee_shift,
        //     view_absen_hr.grp,
        //     view_absen_hr.dept_account,
        //     view_absen_hr.work_date,
        //     view_absen_hr.check_in,
        //     view_absen_hr.check_out,
        //     view_absen_hr.CODE
        //     FROM view_absen_hr ";
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

        $origin_query_absen = "SELECT view_absen_hr.id_absensi,
                        view_organization.npk,
                        view_organization.groupfrm,
                        view_organization.nama,
                        view_absen_hr.employee_shift,
                        view_absen_hr.grp,
                        view_absen_hr.dept_account,
                        view_absen_hr.work_date,
                        view_absen_hr.check_in,
                        view_absen_hr.check_out,
                        view_absen_hr.CODE 
                        FROM view_organization LEFT JOIN view_absen_hr ON view_organization.npk = view_absen_hr.npk";
        $tanggal_filter = '';
        foreach($data_tanggal AS $tgl){
            $tanggal_filter .= " work_date = '$tgl' OR";
        }
        $tanggal_filter = (substr($tanggal_filter, 0, -2) != '')?" AND (".substr($tanggal_filter, 0, -2).") ":'';
        // echo $tanggal_filter;
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
        $access_org_abs = orgAccess_joinAbsen($level, "view_absen_hr");
        $add_filter_absen = filterData_joinAbsen($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari,"view_absen_hr");
        $queryAbsen = filtergeneratorJoinAbsen($link, $level, $generate, $origin_query_absen, $access_org_abs).$add_filter_absen.$tanggal_filter;
        
    //    echo $queryAbsen ;

       $sql_jml = mysqli_query($link, $queryAbsen)or die(mysqli_error($link));
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
                                <th>in</th>
                                <th>out</th>
                                <th>Ket</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase text-nowrap">
                        <?php
                        
                    
                        $sql = mysqli_query($link, $queryAbsen.$addOrder.$addLimit)or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sql)>0){
                            
                            while($dataAbsen = mysqli_fetch_assoc($sql)){
                                // foreach($data_tanggal AS $date){

                                //     $sql_absen = mysqli_query($link, $queryAbsen." AND npk = '$data[npk]' AND work_date = '$date' ")or die(mysqli_error($link));
                                //     $dataAbsen = mysqli_fetch_assoc($sql_absen);
                                $checkIn = ($dataAbsen['check_in'] == '00:00:00')? "-" : jam($dataAbsen['check_in']);
                                $checkOut = ($dataAbsen['check_out'] == '00:00:00')? "-" : jam($dataAbsen['check_out']);
                                $work_date = $dataAbsen['work_date'];
                                $limit_date = tgl(date('Y-m-t', strtotime($dataAbsen['work_date'])));
                                $str_date = strtotime($work_date);
                                $str_limit = strtotime($limit_date);
                                $today = date('Y-m-d');//harus diganti tanggal out kerja
                                $str_today = strtotime($today);
                                ?>
                                <tr id="<?=$dataAbsen['id_absensi']?>" >
                                    <td class="td"><?=$no?></td>
                                    <td class="td"><?=$dataAbsen['npk']?></td>
                                    <td style="max-width:200px" class="text-truncate td"><?=$dataAbsen['nama']?></td>
                                    <td class="td"><?=$dataAbsen['employee_shift']?></td>
                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,  $dataAbsen['grp'], "group")?></td>
                                    <td class="td"><?=getOrgName($link, $dataAbsen['dept_account'], "deptAcc")?></td>
                                    <td class="td"><?=$dataAbsen['work_date']?></td>
                                    <td class="td"><?=$checkIn?></td>
                                    <td class="td"><?=$checkOut?></td>
                                    <td class="td"><?=$dataAbsen['CODE']?></td>
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
        // list($status, $req_status) = pecahProg("$_GET[prog]");
        $filterProg = ($_GET['prog'] != '' )?" AND CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) = '$_GET[prog]' ":"";
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$today' AND '$today' ".$add_filter.$filterProg;
        // echo $query_req_absensi;
        $addWFO = " AND att_alias = '1' AND (check_in <> '00:00:00' OR  check_out <> '00:00:00' )";
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
                                    <p class="card-category text-white">Masuk Tepat Waktu</p>
                                    <p class="card-title"><?=$totalWFO?> MP
                                    <p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="stretched-link view_data text-white" id="1" ></a> 
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
                                    <p class="card-category text-white">Absen Tidak lengkap</p>
                                    <p class="card-title"><?=$totalTL?> MP
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="stretched-link view_data text-white" id="2" ></a> 
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
                                    <p class="card-category text-white">Terlambat</p>
                                    <p class="card-title"><?=$totalT?> MP
                                    <p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="stretched-link view_data text-white" id="3" ></a> 
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-12 owl-carousel ">
                <!-- <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats text-white" style="background:#81A3FF">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-white">
                                        <i class="fas fa-suitcase-rolling"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">Cuti</p>
                                        <p class="card-title"><?=$totalC?> MP
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="4" ></a> 
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats  text-white" style="background:#A582F5">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-white">
                                        <i class="fa fa-quote-left text-white"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">Cuti Lain-Lain</p>
                                        <p class="card-title"><?=$totalCL?> MP
                                        <p>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="5" ></a>
                    </div>
                <!-- </div>
                
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats bg-primary">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="fa fa-bed text-white"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">Cuti Dokter & Dirawat</p>
                                        <p class="card-title text-white"><?=$totalS?> MP
                                        <p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="6" ></a>
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats  text-white" style="background:#F5828E">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-white">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">Ijin Keluar Perusahaan</p>
                                        <p class="card-title"><?=$totalP?> MP
                                        <p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="7" ></a> 
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats bg-info text-white">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-white">
                                        <i class="fas fa-laptop-house"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">WFH</p>
                                        <p class="card-title"><?=$totalWFH?> MP
                                        <p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="8" ></a> 
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card card-stats bg-danger text-white">
                        <div class="card-body py-2 my-2">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-white">
                                        <i class="fa fa-bell-slash text-white"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category text-white">Mangkir</p>
                                        <p class="card-title"><?=$totalM?> MP
                                        <p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="stretched-link view_data text-white" id="9" ></a> 
                    </div>
                <!-- </div> -->
            </div>

        </div>
        <script>
            $(document).ready(function(){
                var owl = $('.owl-carousel');
                owl.owlCarousel({
                    items:3,
                    loop:true,
                    margin:30,
                    autoplay:true,
                    autoplayTimeout:3000,
                    autoplayHoverPause:true
                });
                $('.play').on('click',function(){
                    owl.trigger('play.owl.autoplay',[1000])
                })
                $('.stop').on('click',function(){
                    owl.trigger('stop.owl.autoplay')
                })
            });
        </script>
        <?php
    }else if($_GET['id'] == 'modal'){
        $_GET['prog'] = '';
        $data_filter = ($_GET['data'] != '')?" AND att_alias = '$_GET[data]' ":'';
        // $_GET['cari'] = '';
        $_GET['att_type'] = '';
        $start = dateToDB($_GET['start']);
        $end = dateToDB($_GET['end']);
        $today = (strtotime($end) >= strtotime(date('Y-m-d')))?date('Y-m-d'):$end;
        $query_attAlias = mysqli_query($link, "SELECT `name` FROM attendance_alias WHERE id = '$_GET[data]' ")or die(mysqli_error($link));
        if($_GET['data'] == 1){
            $add_ = " AND ( check_in <> '00:00:00' OR check_out <> '00:00:00' ) ";
        }else{
            $add_ = " ";
            
        }
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
        $query_req_absensi = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$today' AND '$today' ".$add_filter.$data_filter.$add_;
        

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
        // echo $query_req_absensi.$addOrder.$addLimit;
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
        
                                            while($dataAbsen = mysqli_fetch_assoc($sql)){
                                                $checkIn = ($dataAbsen['check_in'] == '00:00:00')?'':jam($dataAbsen['check_in']);
                                                $checkOut = ($dataAbsen['check_out'] == '00:00:00')?'':jam($dataAbsen['check_out']);
                                                ?>
                                                    <tr id="<?=$dataAbsen['id_absensi']?>" >
                                                    <td class="td"><?=$no++?></td>
                                                    <td class="td"><?=$dataAbsen['npk']?></td>
                                                    <td style="max-width:200px" class="text-truncate td"><?=$dataAbsen['nama']?></td>
                                                    <td class="td"><?=$dataAbsen['employee_shift']?></td>
                                                    <td style="max-width:100px" class="text-truncate"><?=getOrgName($link,  $dataAbsen['grp'], "group")?></td>
                                                    <td class="td"><?=getOrgName($link, $dataAbsen['dept_account'], "deptAcc")?></td>
                                                    <td class="td"><?=tgl($dataAbsen['work_date'])?></td>
                                                    <td class="td"><?=$checkIn?></td>
                                                    <td class="td"><?=$checkOut?></td>
                                                    <td class="td"><?=$dataAbsen['CODE']?></td>
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

        $origin_query_absen = "SELECT view_absen_hr.id_absensi,
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
        $queryAbsen = filtergenerator($link, $level, $generate, $origin_query_absen, $access_org_abs).$add_filter_absen.$tanggal;
    //    echo $queryAbsen;
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
                                echo "<th scope=\"col\" colspan=\"3\" style=\"text-align: center;".$color++."\">$tanggal</th>";
                            }
                            
                        ?>
                        <th scope="col" style="width:100px;border:1px solid white" colspan="10">Rekap Absen</th>

                        <tr>
                        <?php
                        foreach($data_tanggal AS $tgl){
                            $hari = hari_singkat($tgl);
                            $date = $tgl;
                            $cell_ = date('D, d - M', strtotime($date));
                            $cell = explode(' ', $cell_);
                            $color = ($cell['0'] == "Sun," || $cell['0'] == "Sat," ) ? "style=\"background: rgba(211, 84, 0, 0.3)\"" : "";
                            ?>
                            <th scope="col" style="width:100px;border:1px solid white">IN</th>
                            <th scope="col" style="width:100px;border:1px solid white">OUT</th>
                            <th scope="col" style="width:50px;border:1px solid white">KET</th>

                            <?php
                            
                        }
                        
                        ?>
                        <th style="width:50px;border:1px solid white">S1</th>
                        <th style="width:50px;border:1px solid white">S2</th>
                        <th style="width:50px;border:1px solid white">T1</th>
                        <th style="width:50px;border:1px solid white">T2</th>
                        <th style="width:50px;border:1px solid white">T3</th>
                        <th style="width:50px;border:1px solid white">TL</th>
                        <th style="width:50px;border:1px solid white">M</th>
                        <th style="width:50px;border:1px solid white">C1</th>
                        <th style="width:50px;border:1px solid white">C2</th>
                        <th style="width:50px;border:1px solid white">Others</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query mp
                    $no_spl = 1;
                    // $qryMonitoring .= " $limit";
                    // echo $qryMonitoring;
                    $sql_monMp = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql_monMp)>0){

                        while($data_mon = mysqli_fetch_assoc($sql_monMp)){
                            //query lembur sesuai dengan npk karyawan
                            // $sql_lembur = "SELECT * FROM lembur WHERE npk = $data_mon[npk_karyawan]";
                            // $lembur = mysqli_query($link, $sql_lembur)or die(mysqli_error($link));
                            
                            ?>
                        <tr>
                            <th  scope="row"><?=$no++?></td>
                            <td style="max-width:100px" class="text-truncate" ><?=$data_mon['npk']?></td>
                            <td style="max-width:200px" class="text-truncate" ><?=$data_mon['nama']?></td>
                            <td  style="max-width:50px" class="text-truncate"  ><?=$data_mon['shift']?></td>
                            <td  style="max-width:200px" class="text-truncate"  ><?=$data_mon['groupfrm']?></td>
                            <td  style="max-width:200px" class="text-truncate"  ><?=$data_mon['dept_account']?></td>
                            <td  style="max-width:100px" class="text-truncate"  ">Absensi</td>
                            <?php
                            
                            
                                
                            foreach($data_tanggal as $tgl_){//looping tanggal request
                                //ambil array data lembur 
                                $qry_absen = $queryAbsen." AND npk = '$data_mon[npk]' AND work_date = '$tgl_' ";
                                
                                $sqlAbsen = mysqli_query($link, $qry_absen)or die(mysqli_error($link));
                                $dataAbsen = mysqli_fetch_assoc($sqlAbsen);
    
                                $check_in = ($dataAbsen['check_in'] == "00:00:00" || $dataAbsen['check_in'] == "")?"":jam($dataAbsen['check_in']);
                                $check_out = ($dataAbsen['check_out'] == "00:00:00" || $dataAbsen['check_out'] == "")?"":jam($dataAbsen['check_out']);
                                $hari = hari_singkat($tgl_);
                                $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(228, 227, 227, 0.5)" : "";
    
                                // switch($dataAbsen['status_absen']){
                                //     case '':
                                //         $bg_color = "";
                                //         $text_color = "";
                                //         $text_tooltip = "BELUM ADA PENGAJUAN";
                                //         break;
                                //     case '0':
                                //         $bg_color = "muted";
                                //         $text_color = "danger";
                                //         $text_tooltip = "DRAFT PENGAJUAN";
                                //         break;
    
                                //     case '25':
                                //         $bg_color = "danger";
                                //         $text_color = "white";
                                //         $text_tooltip = "WAITING APPROVAL";
                                //         break;
    
                                //     case '50':
                                //         $bg_color = "warning";
                                //         $text_color = "white";
                                //         $text_tooltip = "WAITING ADMIN PROCESS";
                                //         break;
                                //     case '75':
                                //         $bg_color = "info";
                                //         $text_color = "white";
                                //         $text_tooltip = "ADMIN PROCESS";
                                //         break;
                                //     case '100':
                                //         $bg_color = "success";
                                //         $text_color = "white";
                                //         $text_tooltip = "CLOSE / SUCCESS";
                                //         break;
                                // }
                                // $tooltipIn = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[check_in]\"":"";
                                // $tooltipOut = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[check_out]\"":"";
                                // $tooltipKet = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[keterangan] - STATUS : $text_tooltip\"":"";
                                
                                ?>
                                
                                <td style="min-width:100px ;max-width:100px" class="bg- text-" ><?=$check_in?></td>
                                <td style="min-width:100px ;max-width:100px" class="bg- text-" ><?=$check_out?></td>
                                <td style="min-width:50px ;max-width:50px" class="bg- text-"  ><?=$dataAbsen['CODE']?></td>
                                <?php
                                flush();
                            }
                            $qry_absen = $queryAbsen." AND npk = '$data_mon[npk]'";
                            $qry_M = $qry_absen." AND CODE = 'M' ";
                            $qry_TL = $qry_absen." AND CODE = 'TL' ";
                            $qry_C1 = $qry_absen." AND CODE = 'C1' ";
                            $qry_C2 = $qry_absen." AND CODE = 'C2' ";
                            $qry_S1 = $qry_absen." AND CODE = 'S1' ";
                            $qry_S2 = $qry_absen." AND CODE = 'S2' ";
                            $qry_T1 = $qry_absen." AND CODE = 'T1' ";
                            $qry_T2 = $qry_absen." AND CODE = 'T2' ";
                            $qry_T3 = $qry_absen." AND CODE = 'T3' ";
                            $qry_Oth = $qry_absen." AND CODE <> '' ";
    
                            $total_M = mysqli_num_rows(mysqli_query($link, $qry_M));
                            $total_C1 = mysqli_num_rows(mysqli_query($link, $qry_C1));
                            $total_C2 = mysqli_num_rows(mysqli_query($link, $qry_C2));
                            $total_S1 = mysqli_num_rows(mysqli_query($link, $qry_S1));
                            $total_S2 = mysqli_num_rows(mysqli_query($link, $qry_S2));
                            $total_T1 = mysqli_num_rows(mysqli_query($link, $qry_T1));
                            $total_T2 = mysqli_num_rows(mysqli_query($link, $qry_T2));
                            $total_T3 = mysqli_num_rows(mysqli_query($link, $qry_T3));
                            $total_TL = mysqli_num_rows(mysqli_query($link, $qry_TL));
                            $total_Oth = mysqli_num_rows(mysqli_query($link, $qry_Oth));
                            $other = $total_Oth - ($total_M + $total_C1 + $total_C2 +$total_S1 +$total_S2+$total_T1+$total_T2+$total_T3+$total_TL);
    
    
                            ?>
                            <td rowspan=""><?=$total_S1?></td>
                            <td rowspan=""><?=$total_S2?></td>
                            <td rowspan=""><?=$total_T1?></td>
                            <td rowspan=""><?=$total_T2?></td>
                            <td rowspan=""><?=$total_T3?></td>
                            <td rowspan=""><?=$total_TL?></td>
                            <td rowspan=""><?=$total_M?></td>
                            <td rowspan=""><?=$total_C1?></td>
                            <td rowspan=""><?=$total_C2?></td>
                            <td rowspan=""><?=$other?></td>
                            
                            <?php
                                    
                                    
                                   
    
                            ?>
                            
                            
                            <?php
                            
                            
                            
                            
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