<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../config/approval_system.php");
        
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
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org);
        
        // echo $access_org."<br>";
        // echo $data_access."<br>";
        // echo $field_request."<br>";
        // echo $table_field1."<br>";
        // echo $table_field2."<br>";
        // echo $part."<br>";
        // echo $generate."<br>";
        // echo $add_filter."<br>";
        // echo $queryMP."<br>";
        
        
        ?>
        <div class="table-responsive" >
            <table class="table table-hover">
                <thead class="table-warning">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">NPK</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Status</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Shift</th>
                        <th scope="col">Pos Kerja</th>
                        <th scope="col">Team Kerja</th>
                        <th scope="col">Group</th>
                        <th scope="col">Section</th>
                        <th scope="col">Dept</th>
                        <th scope="col">Dept Adm</th>
                        <th scope="col">Action</th>
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
                    // echo $total_records."<br>";

                    $page = (isset($_GET['page']))? $_GET['page'] : 1;
                    // echo $page."<br>";
                    $limit = 100; 
                    $limit_start = ($page - 1) * $limit;
                    $no = $limit_start + 1;
                    // echo $limit_start;
                    $addOrder = " ORDER BY id_division, id_dept_account, id_dept, id_sect, id_grp, id_post_leader DESC ";
                    $addLimit = " LIMIT $limit_start, $limit";
                    $no = 1;
                    // echo $addOrder."<br>";
                    // echo $addLimit."<br>";
                    // pagin
                    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                    
                    $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
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
                                <td style="max-width:100px" class="text-truncate"><?=$data['status']?></td>
                                <td class="td"><?=$data['jabatan']?></td>
                                <td class="td"><?=tgl_indo($data['tgl_masuk'])?></td>
                                <td class="td"><?=$data['shift']?></td>
                                <td class="td"><?=$data['subpos']?></td>
                                <td class="td"><?=$data['pos']?></td>
                                <td class="td"><?=$data['groupfrm']?></td>
                                <td class="td"><?=$data['section']?></td>
                                <td class="td"><?=$data['dept']?></td>
                                <td class="td"><?=$data['dept_account']?></td>
                                
                                <td class="text-right">
                                    
                                        
                                        <?php
                                    
                                    ?>
                                    <span class="dropleft text-center">
                                        <button class="btn btn-sm  btn-info  btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-lg text-center ">
                                            <!-- <div class="dropdown-header">Menu</div> -->
                                            
                                            
                                        </div>
                                    </span>
                                </td>
                                <td>
                                    <div class="form-check ">
                                        <label class="form-check-label ">
                                            <input class="form-check-input mp " name="checked[]" type="checkbox" value="<?=$data['id_absensi']?>">
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
        include_once ("../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>