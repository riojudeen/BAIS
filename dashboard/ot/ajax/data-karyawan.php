<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >=3){
        // echo "tes";
        $kode_ot = $_GET['kode_ot'];
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $in_date = $_GET['in_date'];
        $out_date = $_GET['out_date'];
        $activity = $_GET['activity'];
        $work_date = $_GET['work_date'];
        $type = $_GET['type'];

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
        $cari = '';
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npkUser);
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
        // echo $group_filter;
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter;
        
        
        
        ?>
        <div class="row">
            <div class="col-md-12">
                
                <div class="card shadow-none border rounded-0 " style="background:rgba(201, 201, 201, 0.2)" >

                    <div class="card-body  mt-2">
                    
                        <form method="get" action="schedule.php">
                            
                            <div class="row">
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label for="">Tanggal Kerja</label>
                                        <input type="date" name="tanggal" value="<?=$hari_ini?>" class=" form-control no-border" id="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-9 pb-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Jenis Overtime</label>
                                            <div class="form-group">
                                                <select name="ot_type" type="number" class="form-control no-border" id="ot_type" required>
                                                    <option value="">Pilih Overtime Type</option>
                                                    <option value="EO">Early Overtime</option>
                                                    <option value="PO" selescted>Post Overtime</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label for="">Tanggal Mulai</label>
                                        <?php
                                        $hari_ini = date('Y-m-d');
                                        ?>
                                        <input type="date" name="tanggal" value="<?=$hari_ini?>" class="form-control no-border" id="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-3 pls-1">
                                    <div class="form-group">
                                        <label for="">Waktu Mulai</label>
                                        <input type="time" name="tanggal" value="" class="form-control no-border" id="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label for="">Tanggal Selesai</label>
                                        <?php
                                        $hari_ini = date('Y-m-d');
                                        ?>
                                        <input type="date" name="tanggal" value="<?=$hari_ini?>" class=" form-control no-border" id="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label for="">Waktu Selesai</label>
                                        <input type="time" name="tanggal" value="" class="form-control no-border" id="tanggal_mulai" required>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                
                                <div class="col-md-5  ">
                                    <label for="">Jenis Activity</label>
                                    <div class="input-group">
                                        <select name="ot_code" type="number" class="form-control no-border" id="ot_code" required>
                                            <option value="">Kode Overtime</option>
                                            <?php
                                            
                                                $query = mysqli_query($link, "SELECT * FROM kode_lembur")or die(mysqli_error($link));
                                                if(mysqli_num_rows($query)){
                                                    while($data=mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <option value="<?=$data['kode_lembur']?>"><?=$data['nama']?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-text px-2 py-0" id="ot_code_display">
                                                Kode
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7  pl-1">
                                    <label for="">Activity</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" >
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="collapse " id="collapsePlot">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label for="">Input NPK</label>
                                        <div class="form-group">
                                            <textarea class="form-control " name="" id="text_input" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive" style="max-height:500px">
            <table class="table table-striped" >
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Tgl Kerja</th>
                        <th colspan="2">Mulai</th>
                        <th colspan="2">Selesai</th>
                        <th>Activity</th>
                        <th>Kode Job</th>
                        <th>

                        </th>
                        
                    </tr>
                </thead>
                <tbody class="text-uppercase text-nowrap">
                    <?php
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
                    
                    // echo $addOrder."<br>";
                    // echo $addLimit."<br>";
                    // pagin
                    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                    
                    $jumlah_number = 1; //jumlah halaman_modal ke kanan dan kiri dari halaman yang aktif
                    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                    // echo $jumlah_page."<br>";s
                
                    $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                    
                    if(mysqli_num_rows($sql)>0){
                        while($data = mysqli_fetch_assoc($sql)){
                            
                            ?>
                            <tr id="<?=$data['npk']?>" >
                                <td class="td"><?=$no++?></td>
                                <td class="td"><?=$data['npk']?></td>
                                <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                <td style="max-width:100px" class="text-truncate"><?=$work_date?></td>
                                <td  class="text-truncate"><?=$in_date?></td>
                                <td  class="text-truncate"><?=$start_time?></td>
                                <td  class="text-truncate"><?=$out_date?></td>
                                <td  class="text-truncate"><?=$end_time?></td>
                                <td  class="text-truncate"><?=$activity?></td>
                                <td  class="text-truncate"><?=$kode_ot?></td>
                                <td  class="text-truncate"></td>
                                
                                
                                
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
        <div class="row">
            <div class="col-md-12 pull-rigt">
                <ul class="pagination ">
                <?php
                if($page == 1){
                    echo '<li class="page-item disabled"><a class="page-link" >First</a></li>';
                    echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&laquo;</span></a></li>';
                } else {
                    $link_prev = ($page > 1)? $page - 1 : 1;
                    echo '<li class="page-item halaman_modal" id="1"><a class="page-link" >First</a></li>';
                    echo '<li class="page-item halaman_modal" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                }

                for($i = $start_number; $i <= $end_number; $i++){
                    $link_active = ($page == $i)? ' active page_active' : '';
                    echo '<li class="page-item halaman_modal '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
                }

                if($page == $jumlah_page){
                    echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
                } else {
                    $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                    echo '<li class="page-item halaman_modal" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                    echo '<li class="page-item halaman_modal" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
                }
                ?>
                </ul>
            </div>
        </div>
        <?php
    }
}