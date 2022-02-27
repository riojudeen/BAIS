
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title">Daftar Man Power<li class="nc-icon nc-circle-10 pull-right"></li>
                </h5>
                <a href="" type="button" onClick="window.location.reload()"
                    class="btn btn-md btn-success btn-outline-secondary btn-round btn-icon"><i
                        class="fa fa-refresh"></i></a>
                <a href="addmp.php" type="button" class="btn btn-md btn-default btn-round"><i class="fa fa-plus"></i>
                    Tambah
                    Data</a>
                
                <a href="../popup/sort_form.php" class="li-modals btn-rotate">
                    <button type="button" class="btn btn-warning" data-toggle="modal">
                    <i class="nc-icon nc-zoom-split"> </i> Sort Data
                    </button>
                </a>
                <span class="pull-right">
                    <form class="form-inline" action="" method="post">
                        <div class="input-group no-border">
                            <input type="text" name="pencarian" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <button type="submit" class="btn btn-sm my-0 btn-link btn-icon" aria-hidden="true"><i class="nc-icon nc-zoom-split"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </span>
            </div>
            <form method="post" name="proses" action="">
                <div class="card-body ">
                    <div class="table-responsive" style="height:200">
                        <table class="table table-striped table-hover text-nowrap" id="table_mp">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NPK</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nick Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Tanggal Masuk</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Area / Pos</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Dept</th>
                                    <th scope="col">Dept Account</th>

                                    <th scope="col">Kontrol</th>
                                    <th scope="col">
                                        <input type="checkbox" name="select_all" id="select_all" value="">
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //////////////////////////////////////////////////////////////////////
                                //untuk kondisi awal
                                
                                $batas = 10; //untuk mengatur batas halaman perpage
                                $hal = @$_GET['hal']; //apakah halaman ada di url
                                if(empty($hal)){
                                    //jika tiak ada query string yang dikirim, maka masukan nilai 0 ke variabel posisi, dan set hal dengan nilai 1
                                    $posisi = 0;
                                    $hal = 1;
                                } else {                 
                                    $posisi = ($hal - 1) * $batas; //jika tombol pagination tidak diklik maka posisi 0
                                }

                                //kalo ada inputan post search
                                $no = 1;
                                if(isset($_POST['pencarian'])) {
                                /*if($_SERVER['REQUEST_METHOD'] == "POST"){*/
                                    //jika ada masukan parameter hasil pencarian kedalam variabel $pencarian
                                    $pencarian = trim(mysqli_real_escape_string($link, $_POST['pencarian']));
                                    //jika pencarian ada, masukan hasil queri pencarian ke dalam variabel query jumlah
                                    if($pencarian !== ''){
                                        $sql = "SELECT karyawan.status, karyawan.nama_depan AS nama_depan, karyawan.npk AS npk, karyawan.nama AS nama, karyawan.shift AS shift, karyawan.jabatan AS jabatan , karyawan.tgl_masuk AS tgl_masuk, karyawan.department AS department, karyawan.id_area AS id_area, pos_leader.nama_pos AS nama_pos, groupfrm.nama_group AS nama_group , section.section AS section , department.dept AS dept FROM karyawan LEFT JOIN pos_leader ON  
                                        karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept WHERE npk LIKE '%$pencarian%'or nama LIKE '%$pencarian%'";
                                        $query_mp = $sql;
                                        $queryjml = $sql;
                                    //jika inputan kosong , masukkan  nilai posisi + 1 ke dalam no    
                                    } else{
                                        $query_mp = "SELECT karyawan.status, karyawan.nama_depan AS nama_depan, karyawan.npk AS npk, karyawan.nama AS nama, karyawan.shift AS shift, karyawan.jabatan AS jabatan , karyawan.tgl_masuk AS tgl_masuk, karyawan.department AS department, karyawan.id_area AS id_area, pos_leader.nama_pos AS nama_pos, groupfrm.nama_group AS nama_group , section.section AS section , department.dept AS dept FROM karyawan LEFT JOIN pos_leader ON  
                                        karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept ORDER BY nama_group ASC LIMIT $posisi, $batas";
                                        $queryjml = "SELECT karyawan.status, karyawan.nama_depan AS nama_depan, karyawan.npk AS npk, karyawan.nama AS nama, karyawan.shift AS shift, karyawan.jabatan AS jabatan , karyawan.tgl_masuk AS tgl_masuk, karyawan.department AS department, karyawan.id_area AS id_area, pos_leader.nama_pos AS nama_pos, groupfrm.nama_group AS nama_group , section.section AS section , department.dept AS dept FROM karyawan LEFT JOIN pos_leader ON  
                                        karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept ORDER BY nama_group ASC";
                                        $no = $posisi + 1;
                                    }
                                //jika tidak ada inputan pencarian tidak dilakukan, masukkan  nilai posisi + 1 ke dalam no     
                                } else {
                                    $query_mp = "SELECT karyawan.status, karyawan.nama_depan AS nama_depan, karyawan.npk AS npk, karyawan.nama AS nama, karyawan.shift AS shift, karyawan.jabatan AS jabatan , karyawan.tgl_masuk AS tgl_masuk, karyawan.department AS department, karyawan.id_area AS id_area, pos_leader.nama_pos AS nama_pos, groupfrm.nama_group AS nama_group , section.section AS section , department.dept AS dept FROM karyawan LEFT JOIN pos_leader ON  
                                    karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept ORDER BY nama_group ASC LIMIT $posisi, $batas";
                                    $queryjml = "SELECT karyawan.status, karyawan.nama_depan AS nama_depan, karyawan.npk AS npk, karyawan.nama AS nama, karyawan.shift AS shift, karyawan.jabatan AS jabatan , karyawan.tgl_masuk AS tgl_masuk, karyawan.department AS department, karyawan.id_area AS id_area, pos_leader.nama_pos AS nama_pos, groupfrm.nama_group AS nama_group , section.section AS section , department.dept AS dept FROM karyawan LEFT JOIN pos_leader ON  
                                    karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept ORDER BY nama_group ASC";
                                    $no = $posisi + 1;
                                    
                                }


                                $data_mp = mysqli_query($link, $query_mp);
                                //jika Query gagal
                                if(!$data_mp){
                                    die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
                                }

                                //ambil hasil query mysql
                                $no_urut = 1;
                                if(mysqli_num_rows($data_mp) > 0){
                                    while($tampil_mp = mysqli_fetch_assoc($data_mp)){
                                        $id_area = $tampil_mp['id_area'];
                                        
                                        switch ($tampil_mp['jabatan']) {
                                            case 'TM';
                                            $table = 'pos_leader';
                                            $id_table  = 'id_post';
                                            $tb_kolom = 'nama_pos';
                                            break;
                                            case 'TL';
                                            $table = 'groupfrm';
                                            $id_table  = 'id_group';
                                            $tb_kolom = 'nama_group';
                                            break;
                                            case 'FRM';
                                            $table = 'section';
                                            $id_table  = 'id_section';
                                            $tb_kolom = 'section';
                                            break;
                                            case 'SPV';
                                            $table = 'department';
                                            $id_table  = 'id_dept';
                                            $tb_kolom = 'dept';
                                            break;
                                            case 'MNG';
                                            $table = 'division';
                                            $id_table  = 'id_div';
                                            $tb_kolom = 'nama_divisi';
                                            break;
                                            case 'DH';
                                            $table = 'company';
                                            $id_table  = 'id_company';
                                            $tb_kolom = 'nama';
                                            break;
                                        }
                                        // $qry_join = "SELECT karyawan.id_area, pos_leader.nama_pos, groupfrm.nama_group , section.section , department.dept FROM karyawan LEFT JOIN pos_leader ON  
                                        // karyawan.id_area = pos_leader.id_post LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group LEFT JOIN section ON groupfrm.id_section = section.id_section LEFT JOIN department ON section.id_dept = department.id_dept";
                                        // $sql_join = mysqli_query($link,$qry_join)or die(mysqli_error($link));
                                        // $join = mysqli_fetch_assoc($sql_join);
                                        
                                        $qry_join = "SELECT $tb_kolom FROM $table WHERE $id_table = '$id_area'";
                                        $sql_join = mysqli_query($link,$qry_join)or die(mysqli_error($link));
                                        $join = mysqli_fetch_assoc($sql_join);
                                        
                                        
                                        

                                        ?>

                                <?php 
                                echo "<tr><td>".$no_urut++."</td>";
                                echo "<td class=\"py-0\">$tampil_mp[npk]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[nama]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[nama_depan]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[status]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[jabatan]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[tgl_masuk]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[shift]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[nama_pos]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[nama_group]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[section]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[dept]</td>";
                                echo "<td class=\"py-0\">$tampil_mp[department]</td>";
                                
                                echo "<td class=\"py-0\">";
                                ?>
                                <?php
                                /*
                                <!--<a href="edit_mp.php?npk=--><?=$tampil_mp['npk']?>
                                <!---" class="btn btn-sm btn-outline-default"><span class="fa fa-edit"></span></a>-->
                                */
                                ?>
                                <a href="edit_mp.php?npk=<?=$tampil_mp['npk'];?>" type="button"
                                    class="btn btn-sm btn-outline-primary btn-round btn-icon"><i
                                        class="fa fa-edit"></i></a>

                                <?php
                                /* tombol inaktif sementara
                                <a class="btn btn-sm btn-outline-default" id="tomboledit" data-toggle="modal" data-target="#editmp"
                                    data-npk="<?=$tampil_mp['npk']?>" data-nama="<?=$tampil_mp['nama']?>"
                                    data-nick="<?=$tampil_mp['nama_depan']?>" data-status="<?=$tampil_mp['status']?>"
                                    data-jabatan="<?=$tampil_mp['jabatan']?>" data-masuk="<?=$tampil_mp['tgl_masuk']?>"
                                    data-shift="<?=$tampil_mp['shift']?>" data-pos="<?=$tampil_mp['id_area']?>"><i
                                        class="fa fa-edit"></i></a>
                                    */
                                ?>

                                <a href="del_mp.php?npk=<?=$tampil_mp['npk']?>"
                                    onclick="return confirm('yakin akan menghapus <?=$tampil_mp['nama']?> dengan NPK <?=$tampil_mp['npk']?> dari database?')"
                                    class="btn btn-sm btn-outline-danger btn-round btn-icon"><i
                                        class="fa fa-trash"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-round btn-icon"><li class="nc-icon nc-single-02"></button>


                                <?php
                                echo "</td><td>";
                                ?>
                                <input type="checkbox" name="checked[]" class="check"
                                    value="<?=$tampil_mp['npk']?>"></td>
                                </tr>

                                <?php

                                }} else{
                                    echo "<tr><td colspan=\"11\"><center>Data tidak ditemukan</center></td>";
                                }

                                ?>



                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer ">
                    <?php
                    ///////////////////////////////////////////////////////////////////////////////
                    //pagination dan result pencarian
                    //jika pencarian ada, maka tampilkan total hasil pencarian dari rows database
                    if(empty($_POST['pencarian'])){?>
                        <div style="float:left;">
                            <?php
                                $jml = mysqli_num_rows(mysqli_query($link, $queryjml));
                                echo "<h6>Jumlah data :  $jml</h6>";
                                ?>
                        </div>
                                <?php
                                $jml_hal = ceil($jml / $batas);
                                $batas_hal = 10 ;
                                $index_hal = 2;
                                $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
                                $end = ($hal < ($jml_hal - $index_hal)) ? $hal + $index_hal : $jml_hal;
                                
                                $next = $hal + 1;
                                ?>
                        <div style="float:right">
                            <ul class="pagination pagination-sm">
                            <?php
                                if($hal == 1){
                                    echo '<li class="page-item disabled"><a class="page-link btn-primary" href="#" aria-label="Previous">FIRST</a></li>';
                                    echo '<li class="page-item disabled"><a class="page-link btn-primary" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>';
                                
                                } else{
                                    $prev = ($hal > 1)? $hal - 1 : 1;
                                    echo '<li class="page-item"><a class="page-link btn-primary" href="?hal=1" aria-label="Previous">FIRST</a></li>';
                                    echo '<li class="page-item"><a class="page-link btn-primary" href="?hal='.$prev.'" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>';
                                }
                                for($i = $start; $i <= $end; $i++){
                                    $link_active = ($hal == $i)? ' active' : '';
                                    echo "<li class=\"page-item $link_active\"><a href=\"?hal=$i\" class=\"page-link btn-primary btn-link\"\">$i</a></li>";
                                }
                                /*
                                    if ($jml_hal >= $batas_hal){
                                        for ($i=1; $i <= $batas_hal ; $i++) {
                                            if($i != $hal){

                                                echo "<li class=\"page-item\"><a href=\"?hal=$i\" class=\"page-link btn-primary btn-link\"\">$i</a></li>";
                                            } else {
                                                echo "<li class=\"page-item active\"><a class=\"page-link btn-primary btn-link\"\">$i</a></span>";
                                            }                                    
                                        }

                                    }*/
                                    
                                    
                                    
                                if($hal == $jml_hal){
                                    echo "<li class=\"page-item disabled\"><a class=\"page-link btn-primary btn-link\" href=\"#\"><i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></a></li>";
                                    echo "<li class=\"page-item disabled\"><a class=\"page-link btn-primary btn-link\" href=\"#\">LAST</a></li>";
                                } else{
                                    echo "<li class=\"page-item\"><a class=\"page-link btn-primary btn-link\" href=\"?hal=$next\"><i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></a></li>";
                                    echo "<li class=\"page-item\"><a class=\"page-link btn-primary btn-link\" href=\"?hal=$jml_hal\">LAST</a></li>";
                                }
                                ?>
                                
                            
                            </ul>
                        </div>
                        <?php
                        ///////////////////////////////////////////////////////////////
                        } else { 
                            
                            $jml = mysqli_num_rows(mysqli_query($link, $queryjml));
                            echo "<h6>ditemukan <strong>$jml</strong> hasil pencarian ";
                            echo "</h6>";
                            
                        }
                        ?>
                        
                        <div class="stats">
                        
                        
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
///////////////////////////////////////
    mysqli_free_result($data_mp);

    // tutup koneksi dengan database mysql
    mysqli_close($link);