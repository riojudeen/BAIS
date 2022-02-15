<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
?>
<style>

    .view {
    margin: auto;
    width: 600px;
    }
    tr:hover td
    { background: #F4F4F4;
    }
    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 100px;
    min-width: 50px;
    max-width: 100px;
    left: 0px;
    
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    left: 50px;
    }
    .second-top-col {
    width: 20px;
    min-width: 20px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    left: 100px;
    }
    .third-top-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }
    .fourth-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 170px;
    }
    .fourth-top-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }
    .first-last-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    .second-last-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }

</style>
<?php
$id = (isset($_GET['id']))?$_GET['id']:'';
$div = (isset($_GET['divisi']))?$_GET['divisi']:'';
$deptAcc = (isset($_GET['deptAcc']))?$_GET['deptAcc']:'';
$shift = (isset($_GET['shift']))?$_GET['shift']:'';
$jab = (isset($_GET['jab']))?$_GET['jab']:'';
$stat = (isset($_GET['stat']))?$_GET['stat']:'';
$cari = (isset($_GET['cari']))?$_GET['cari']:'';


if($id == 'local'){
    $filter_divisi = ($div != '')?"AND id_division = '$div' ":'';
    $filter_deptAcc = ($deptAcc != '')?"AND id_dept_account = '$deptAcc' ":'';
    $filter_shift = ($shift != '')?"AND shift = '$shift' ":'';
    $filter_jab = ($jab != '')?"AND jabatan = '$div' ":'';
    $filter_status = ($stat != '')?"AND `status` = '$stat' ":'';
    $filter_cari = ($cari != '')?"AND ( npk LIKE '%$cari%' OR nama LIKE '%$cari%' )":'';

    $filter_gabung = $filter_divisi.$filter_deptAcc.$filter_shift.$filter_jab.$filter_status.$filter_cari;
    $filter = ($filter_gabung != '' )?" ". $filter_gabung :"";

    // echo $div;
    // echo $deptAcc;
    // echo $shift;
    // echo $jab;
    // echo $stat;
    // echo $cari;
    // echo $id;

    $q_dataKaryawan = "SELECT `npk`,`nama`,`tgl_masuk`,`jabatan`,
            `shift`,`status`,`subpos`,`pos`,`groupfrm`,`section`,`dept`,
            `dept_account`,`division`,`plant`,`id_sub_pos`,`id_post_leader`,
            `id_grp`,`id_sect`,`id_dept`,`id_dept_account`,`id_division`,
            `id_plant`,`id_area`
            FROM `view_organization` WHERE id_plant = '1' AND (SELECT count(`npk`) AS `exp` FROM expatriat WHERE npk = view_organization.npk ) = 0";



    $page = (isset($_GET['page']) && $_GET['page'] != 'undefined')? $_GET['page'] : 1;
    // echo $page;
    $limit = 100; 
    $limit_start = ($page - 1) * $limit;
    $no = $limit_start + 1;
    // echo $limit_start;

    $addLimit = " LIMIT $limit_start, $limit";

    $total_dataKaryawan = $q_dataKaryawan;
    $jml = mysqli_query($link, $total_dataKaryawan)or die(mysqli_error($link));
    $j_dataKaryawan = $q_dataKaryawan.$filter;
    $q_dataKaryawan .= $filter.$addLimit;
    $sql_dataKaryawan = mysqli_query($link, $q_dataKaryawan)or die(mysqli_error($link));
    $total_records= mysqli_num_rows($jml);

    // echo $total_records;
    // pagin
    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                    
    $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;

    // echo $q_dataKaryawan;
    ?>

    
    <div class="row">
        <div class="col-md-6 text-left mt-3">
            <h6 >Data Karyawan </h6>
        </div>
        <div class="col-md-6 text-right">
            <a class="btn btn-sm btn-info" data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="collapseExample">Tambah data</a>
        </div>
        <div class="col-md-12">
            
            <form class="table-responsive" name="proses" method="post">
                <table class="table table-hover">
                    <thead>
                        <th class="text-right first-top-col first-col sticky-col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input check-all" type="checkbox" id="allmp">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                        <th class="text-nowrap sticky-col second-col second-top-col">#</th>
                        <th class="text-nowrap sticky-col third-col third-top-col">Npk</th>
                        <th class="text-nowrap sticky-col fourth-col fourth-top-col">Nama</th>
                        <th class="text-nowrap">Tanggal Masuk</th>
                        <th class="text-nowrap">Jabatan</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Shift</th>
                        <th class="text-nowrap">Dept Account</th>
                        <th class="text-nowrap">Atasan</th>
                    </thead>
                    <tbody class="text-nowrap">
                        <?php
                        
                        
                        
                        if(mysqli_num_rows($sql_dataKaryawan)>0){
                            $no = $limit_start +1 ;  
                            while($dataKaryawan = mysqli_fetch_assoc($sql_dataKaryawan)){
                                $q_atasan = mysqli_query($link, "SELECT id, nama_cord FROM view_cord_area WHERE id = '$dataKaryawan[id_area]' ");
                                $s_atasan = mysqli_fetch_assoc($q_atasan);
                                $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:'';
                                ?>
                                <tr>
                                    <td class="sticky-col first-col">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input mp check" type="checkbox" name="index[]"  value="<?=$dataKaryawan['npk']?>">
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="sticky-col second-col"><?=$no++?></td>
                                    <td class="sticky-col third-col"><?=$dataKaryawan['npk']?></td>
                                    <td class="sticky-col fourth-col"><?=$dataKaryawan['nama']?></td>
                                    <td><?=DBtoForm($dataKaryawan['tgl_masuk'])?></td>
                                    <td><?=$dataKaryawan['jabatan']?></td>
                                    <td><?=$dataKaryawan['status']?></td>
                                    <td><?=$dataKaryawan['shift']?></td>
                                    <td><?=$dataKaryawan['dept_account']?></td>
                                    <td><?=$dataAtasan?></td>
                                </tr>
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="10" class="text-uppercase text-center sticky-col first-col">belum ada data</td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
                    </form>

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
    <div class="row">

        <div class="col-md-12 text-right">
            <a href="" class="btn btn-sm btn-warning editall ">Edit data</a>
            <a href="" class="btn btn-sm btn-danger delete">Delete data</a>
            <a class="btn btn-sm btn-info" data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="collapseExample">Tambah data</a>
        </div>
    </div>
    <?php
}else if($id == 'expatriat'){
    ?>
    <div class="collapse show" id="tambah">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" action="ajax/proses.php" id="form-add" class="form-data">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">NPK</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="number" class="form-control bg-transparent data-npk" id="data-npk" placeholder="input npk" autofocus/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nama </label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-nama" placeholder="Nama" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Jabatan</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-jabatan" placeholder="jabatan" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-stats" placeholder="Status Karyawan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                        <button type="button" id="save" class="btn btn-sm btn-primary pull-right d-none" name="add">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 text-left">
                <h6 >Data Expatriat</h6>
            </div>
        </div>
        <form class="table-responsive" method="post">
            <div class="data-expatriat">

            </div>
        </form>
    </div>
</div>
<script>
    $('.data-npk').keyup(function(){
        var npk = $(this).val();
        $.ajax({
            url: 'ajax/get_resource.php',
            method: 'get',
            data: {data:npk},
            success:function(data){
                var obj = $.parseJSON(data);
                var total = obj.msg[0].total;
                var msg = obj.msg[0].msg;
                if(total > 0){
                    var nama = obj.data[0].nama;
                    var status = obj.data[0].status;
                    var jabatan = obj.data[0].jabatan;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').removeClass('d-none');
                }else if(total === 0){
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').addClass('d-none');
                }else{
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').addClass('d-none');
                }
            }
        })
    })
</script>
<script>
    $('.data-expatriat').load("ajax/data-expatriat.php");
    $('#save').click(function(){
        var npk = $('.data-npk').val();
        $.ajax({
            url: 'ajax/data-expatriat.php',
            method: 'get',
            data: {proses:"add", npk:npk},
            success:function(data){
                $('.data-expatriat').load("ajax/data-expatriat.php");
            }
        })
    })
</script>
    <?php
}
