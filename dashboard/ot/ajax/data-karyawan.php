<?php
include("../../../config/config.php");
include("../../../config/approval_system.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >=3){
        // echo "tes";
        $data_npk = preg_split("/\r\n|\n|\r/", $_GET['npk']);
        // print_r($data_npk);
        $npk_karyawan = '';
        
        $shift_req = $_GET['shift_req'];
        $shift_filter = ($shift_req != '')?" AND view_organization.shift = '$shift_req' ":'';
        if(count($data_npk)>0 && $data_npk[0] != '' && $shift_filter != ''){
            foreach($data_npk AS $dataNpk){
                $npk_karyawan .= " view_organization.npk = '$dataNpk' OR";
            }
            
            
            $npk_karyawan = substr($npk_karyawan, 0, -2);
        }else{
            
            $npk_karyawan = '';
        }
        $filter_shift = $shift_filter;
        $npk_karyawan = ($npk_karyawan != '')?" AND (".$npk_karyawan.") ":'';
        // echo $npk_karyawan;
        $kode_ot = $_GET['kode_ot'];
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $in_date = $_GET['in_date'];
        $out_date = $_GET['out_date'];
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
            view_organization.dept_account,
            view_req_ot.work_date,
            view_req_ot.in_date,
            view_req_ot.out_date,
            view_req_ot.start,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity

            FROM view_organization LEFT JOIN 
                (SELECT view_req_ot.npk, view_req_ot.work_date, view_req_ot.in_date,  view_req_ot.out_date, view_req_ot.start, view_req_ot.end, view_req_ot.job_code, view_req_ot.activity FROM view_req_ot 
                WHERE view_req_ot.in_date = '$in_date' 
                AND view_req_ot.out_date = '$out_date' 
                AND  view_req_ot.work_date = '$work_date' AND view_req_ot.id_ot = '$type' ) AS view_req_ot 
                ON  view_organization.npk = view_req_ot.npk";
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        // $filterJoin = " ";
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        // echo $group_filter;
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org).$add_filter.$npk_karyawan.$filter_shift;
        // echo $queryMP;
        
        $init_group = initial(getOrgName($link, $group, 'group'));
        $init_div = initial(getOrgName($link, $div, 'division'));
        $doc_no = docOt($work_date, $data_access, $init_group, $init_div)
        
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive border">
                    <table class="table border" rules="cols" >
                        
                        <thead class="text-center">
                            <tr>
                                <th style="width: 120px"><img style="width: 100px" src="../../assets/img/logo_daihatsu.png"></th>
                                <th style="font-size: 25px" colspan="7">Surat Perintah Lembur</th>
                                <th style="font-size: 25px; width: 120px"><?=date('Y')?></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1" colspan="9" style="height:2px"></td>
                            </tr>
                            <colgroup>
                                <col style="width: 20px">
                                <col style="width: 25px">
                                <col style="width: 150px">
                            </colgroup>
                            <tr>
                                <td class="py-0" colspan="2" style="height:50px">Group</td>
                                <td class="py-0" style="height:50px">: <?=getOrgName($link, $group,"group")?></td>
                                <td class="p-0 text-muted" rowspan="4" colspan="5">
                                <div class="table-responsive text-nowrap">
                                    <table class="table p-0 m-0">
                                        <tbody>
                                        <?php
                                            // kode lembur
                                            $baris = 5;
                                            $q_jobcode = "SELECT * FROM kode_lembur";
                                            $s_jobcode = mysqli_query($link, $q_jobcode)or die(mysqli_error($link));
                                            $jml_row = mysqli_num_rows($s_jobcode);
                                            
                                            $sisa_kolom = $jml_row % $baris; //sisa baris
                                            if($sisa_kolom > 0){
                                                $hasil_kolom = (($jml_row - $sisa_kolom)/$baris)+1;
                                            }else{
                                                $hasil_kolom = ( $jml_row / $baris);
                                            }
                                            
                                            echo "<tr>";
                                            
                                            for($i=0; $i<$hasil_kolom; $i++){
                                                echo "<td class=\"p-0 m-0\"><table class=\"table table-striped\">"
                                                ?>
                                                <colgroup>
                                                    <col style="width: 50px">
                                                    <col style="width: 200px">
                                                
                                                </colgroup>

                                                <?php
                                                echo "<thead class=\"p-0 mt-0\">";
                                                echo "<th class=\"py-1 px-1\">Kode</th>";
                                                echo "<th class=\"py-1 px-1\">Activity</th>";
                                                echo "<tbody class=\"p-0 mt-0\">";
                                                
                                                $offset = $i * $baris;
                                                $q_code = "SELECT * FROM kode_lembur LIMIT $offset , $baris";
                                                $s_code = mysqli_query($link, $q_code)or die(mysqli_error($link));

                                                for($hasilbaris=0; $hasilbaris<=$baris; $hasilbaris++){
                                                    while($d_jobcode = mysqli_fetch_assoc($s_code)){
                                                        echo "<tr>";
                                                        echo "<td class=\"py-1 px-1\">".$d_jobcode['kode_lembur']."</td>";
                                                        echo "<td class=\"py-1 px-1\">".$d_jobcode['nama']."</td>";
                                                        echo "</tr>";
                                                        
                                                    }
                                                }
                                                if($sisa_kolom > 0 && $hasil_kolom == $i +1){
                                                    $tambah = $baris - $sisa_kolom;
                                                    for($tbh=0 ; $tbh<$tambah ; $tbh++){
                                                        echo "<tr>";
                                                        echo "<td class=\"py-1 px-1\"> -</td>";
                                                        echo "<td class=\"py-1 px-1\"> -</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                echo "</tbody></table></td>";
                                            }
                                            echo "</tr>";
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                </td>
                                <th class="py-0 text-center text-white bg-secondary " rowspan="3">
                                    <h4><?=$kode_ot?></h4>
                                </th>
                            </tr>
                            <tr>
                                <td class="py-0" style="height:50px" colspan="2">Shift</td>
                                <td class="py-0" style="height:50px" >: <?=$shift_req?></td>
                                
                            </tr>
                            <tr>
                                <td class="py-0" style="height:50px" colspan="2">Department</td>
                                <td class="py-0" style="height:50px" >: <?=getOrgName($link, $dept_account,"deptAcc")?></td>
                                
                               
                            </tr>
                            <tr>
                                <td class="py-0" colspan="2" style="height:50px" >Hari / Tanggal </td>
                                <td class="py-0" style="height:50px" >: <?=hari($work_date)?>, <?=tgl($work_date)?></td>
                                <td class="py-0 text-uppercase text-center" style="height:50px" >Kode</td>
                            </tr>
                            <!-- isi table form -->
                            <!-- <tr>
                                <td class="py-1" colspan="9" style="border: 1px solid black; height:2px"></td>
                            </tr> -->
                            
                        </tbody>
                        
                    
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                
                <div class="card shadow-none border rounded-0 " style="background:rgba(201, 201, 201, 0.2)" >

                    <div class="card-body  mt-2">
                    
                        
                        <div class="row">
                            <div class="col-md-12">
                            <h6 class="text-uppercase">Doc No : <?=$doc_no?></h6>
                            <input type="hidden" value="<?=$doc_no?>" name="doc_code" >
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="row">
                        
                            <div class="col-md-2 pr-1">
                                <div class="form-group">
                                    <label for="">Tanggal Kerja</label>
                                    <input type="date" readonly  name="tanggal_kerja" value="<?=$work_date?>" class=" form-control no-border"  required>
                                </div>
                            </div>
                            <div class="col-md-3 pb-0 d-none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Jenis Overtime</label>
                                        <div class="form-group">
                                            <input readonly name="ot_type" type="text" value="<?=$type?>" class="form-control no-border"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 pb-0 pl-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Shift Karyawan</label>
                                        <div class="form-group">
                                            <input type="text" readonly name="shift_request" value="<?=$shift_req?>" class="form-control no-border"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="col-md-2 pr-1">
                                <div class="form-group">
                                    <label for="">Tanggal Mulai</label>
                                    
                                    <input type="date" readonly name="tanggal_mulai" value="<?=$in_date?>" class="form-control no-border"  required>
                                </div>
                            </div>
                            <div class="col-md-2 pl-1">
                                <div class="form-group">
                                    <label for="">Waktu Mulai</label>
                                    <input type="time" readonly   name="waktu_mulai" value="<?=jam($start_time)?>" class="form-control no-border" required>
                                </div>
                            </div>
                            <div class="col-md-2 pr-1">
                                <div class="form-group">
                                    <label for="">Tanggal Selesai</label>
                                    <input type="date" readonly    name="tanggal_selesai"  value="<?=$out_date?>" class=" form-control no-border"  required>
                                </div>
                            </div>
                            <div class="col-md-2 pl-1">
                                <div class="form-group">
                                    <label for="">Waktu Selesai</label>
                                    <input type="time" readonly   name="waktu_selesai" value="<?=jam($end_time)?>" class="form-control no-border"  required>
                                </div>
                            </div>
                            
                        </div>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-md-2  pr-1 d-none">
                                <label for="">Activity Code</label>
                                <div class="form-group">
                                    <input name="ot_code" type="text" readonly class="form-control no-border" value="<?=$kode_ot?>" required>
                                        
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <h6 for="" class="title">Activity Detail :</h6>
                                <div class="form-group">
                                    <?php
                                    foreach($_GET['kode_ot'] AS $data){
                                        ?>
                                            <input type="text" max="50" min="5" name="ot_activity" id="ot_activity" class="form-control" >
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-0">
        <div class="table-responsive" style="max-height:1000px">
            <table class="table table-striped text-uppercase" >
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Tgl Kerja</th>
                        <th colspan="2">Mulai</th>
                        <th colspan="2">Selesai</th>
                        <th>Activity</th>
                        <th class="text-right">Kode</th>
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
                    $sql_jml = mysqli_query($link, $queryMP)or die(mysqli_error($link));
                    $total_records= mysqli_num_rows($sql_jml);
                   
                    $page = (isset($_GET['page']))? $_GET['page'] : 1;
                   
                    $limit = 100; 
                    $limit_start = ($page - 1) * $limit;
                    $no = $limit_start + 1;
                    // echo $limit_start;
                    $addOrder = " ORDER BY id_division, id_dept_account, id_dept, id_sect, id_grp, id_post_leader DESC ";
                    $addLimit = " LIMIT $limit_start, $limit";
                    
                    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                    
                    $jumlah_number = 1; //jumlah halaman_modal ke kanan dan kiri dari halaman yang aktif
                    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                
                    $sql = mysqli_query($link, $queryMP.$addOrder.$addLimit)or die(mysqli_error($link));
                    
                    if(mysqli_num_rows($sql)>0){
                        while($data = mysqli_fetch_assoc($sql)){
                            $disabled = ($data['job_code'] != '')?"disabled":"";
                            $mp = ($data['job_code'] != '')?"":"mp";
                            $activity = ($data['activity'] != '')?$data['activity']:"";
                            $job_code = ($data['job_code'] != '')?$data['job_code']:"";
                            $text_activity = ($data['job_code'] != '')?'':"ot_activity";
                            $start = ($data['start'] != '')?jam($data['start']):$start_time;
                            $end = ($data['end'] != '')?jam($data['end']):$end_time;
                            
                            ?>
                            <tr id="<?=$data['npk']?>" >
                                <td class="td"><?=$no++?></td>
                                <td class="td"><?=$data['npk']?></td>
                                <td style="max-width:200px" class="text-truncate td"><?=$data['nama']?></td>
                                <td style="max-width:100px" class="text-truncate"><?=tgl($work_date)?></td>
                                <td  class="text-truncate"><?=tgl($in_date)?></td>
                                <td  class="text-truncate"><?=$start?></td>
                                <td  class="text-truncate"><?=tgl($out_date)?></td>
                                <td  class="text-truncate "><?=$end?></td>
                                <td  class="text-truncate <?=$text_activity?>" style="width:300px"><?=$activity?></td>
                                <td  class="text-truncate text-right"><?=$job_code?></td>
                                <td>
                                    <div class="form-check text-right <?=$disabled?>">
                                        <label class="form-check-label ">
                                            <input <?=$disabled?> class="form-check-input <?=$mp?> " name="checked[]" type="checkbox" value="<?=$data['npk']?>">
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
                            <td colspan="14" class="text-center">Data NPK karyawan Salah Atau Tidak Tersedia Untuk Area Anda</td>
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