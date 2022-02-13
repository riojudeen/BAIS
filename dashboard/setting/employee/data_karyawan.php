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
$pencarian = (isset($_GET['cari']))?$_GET['cari']:"";
$deptAcc = (isset($_GET['deptAcc']))?$_GET['deptAcc']:"";
if(isset($_GET['deptAcc'])){
    $_SESSION['deptAcc'] = (isset($_GET['deptAcc']))?$_GET['deptAcc']:$_SESSION['deptAcc'];
}else{
    $_SESSION['deptAcc'] = (isset($_SESSION['deptAcc']))?$_SESSION['deptAcc']:"";
}

$_GET['deptAcc'] = $_SESSION['deptAcc'];
?>

<div class="collapse show tambah collapse-view" id="data-show">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h6 >Resource Data</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="" class="btn btn-sm btn-warning editall">Edit data</a>
                    <a href="" class="btn btn-sm btn-danger delete">Delete data</a>
                    <a class="btn btn-sm btn-info" data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="collapseExample">Tambah data</a>
                </div>
            </div>
            <div class="row">
                <form class="col-md-4" method="get" action="#data-show">
                    <div class="input-group no-border">
                        <input type="text" name="cari" id="pencarian" class="form-control" placeholder="Cari NPK atau nama" value="<?=$pencarian?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="nc-icon nc-zoom-split"></i>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-8">
                    <form class="pull-right" method="get" action="#data-show">
                        <div class="input-group no-border">
                            <select name="deptAcc" id="deptAcc" class="form-control text-uppercase">
                                <?php
                                $q_deptAcc = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'deptAcc' AND part = 'deptAcc' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($q_deptAcc)){
                                    while($data_deptAcc = mysqli_fetch_assoc($q_deptAcc)){
                                        $selected = ($_SESSION['deptAcc'] == $data_deptAcc['id'])?"selected":"";
                                        ?>
                                        <option <?=$selected?> value="<?=$data_deptAcc['id']?>">department <?=$data_deptAcc['nama_org']?></option>
                                        <?php
                                    }
                                    $selected = ($_SESSION['deptAcc'] == "")?"selected":"";
                                    ?>
                                    <option  <?=$selected?>  value="">Pilih semua</option>
                                    <?php
                                }else{
                                    ?>
                                    <option  value="">Belum Ada Data</option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-link btn-warning btn-icon input-group-append" style="background:#F5F5F5;margin:2px"><i class="nc-icon nc-zoom-split"></i></button>
    
                        </div>
                    </form>

                </div>
            </div>
            <form class="table-responsive" name="proses" method="post">
                <table class="table table-hover">
                    <thead>
                        <th class="text-right first-top-col first-col sticky-col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input check-all" type="checkbox">
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
                        $q_dataKaryawan = "SELECT `npk`,`nama`,`tgl_masuk`,`jabatan`,
                        `shift`,`status`,`subpos`,`pos`,`groupfrm`,`section`,`dept`,
                        `dept_account`,`division`,`plant`,`id_sub_pos`,`id_post_leader`,
                        `id_grp`,`id_sect`,`id_dept`,`id_dept_account`,`id_division`,
                        `id_plant`,`id_area`
                         FROM `view_organization` WHERE id_area IS NOT NULL AND (SELECT count(`npk`) AS `exp` FROM expatriat WHERE npk = view_organization.npk ) = 0";
                        if(isset($_GET['deptAcc']) AND $_GET['deptAcc'] != '' ){
                            $deptAcc = " AND id_dept_account = '$_GET[deptAcc]'";
                        }else{
                            $deptAcc = "";
                            $_GET['deptAcc'] = '';
                        }
                        $batas = 50;
                        if(isset($_GET['hal'])){
                            $hal = $_GET['hal'];
                            $offset = ($hal - 1)* $batas;
                            $sql_dataKaryawan = mysqli_query($link, $q_dataKaryawan.$deptAcc." LIMIT $offset, $batas")or die(mysqli_error($link));
                        }else{
                            $hal = 1;
                            $offset = ($hal - 1)* $batas;
                            $sql_dataKaryawan = mysqli_query($link, $q_dataKaryawan.$deptAcc." LIMIT $offset, $batas")or die(mysqli_error($link));
                        }

                        if(isset($_GET['cari']) AND $_GET['cari'] != ''){
                            $sql_dataKaryawan = mysqli_query($link, $q_dataKaryawan." AND (npk LIKE '%$_GET[cari]%' OR nama LIKE '%$_GET[cari]%')".$deptAcc."LIMIT $offset, $batas ")or die(mysqli_error($link));
                            $q_jml = mysqli_query($link, $q_dataKaryawan." AND (npk LIKE '%$_GET[cari]%' OR nama LIKE '%$_GET[cari]%')".$deptAcc)or die(mysqli_error($link));
                            $jml = mysqli_num_rows($q_jml );
                        }else{
                            $sql_dataKaryawan = $sql_dataKaryawan;
                            $_GET['cari'] = '';
                            $q_jml = mysqli_query($link, $q_dataKaryawan.$deptAcc)or die(mysqli_error($link));
                            $jml = mysqli_num_rows($q_jml);
                        }
                        
                        if(mysqli_num_rows($sql_dataKaryawan)>0){
                            $no = $offset +1 ;
                            while($dataKaryawan = mysqli_fetch_assoc($sql_dataKaryawan)){
                                $q_atasan = mysqli_query($link, "SELECT id, nama_cord FROM view_cord_area WHERE id = '$dataKaryawan[id_area]' ");
                                $s_atasan = mysqli_fetch_assoc($q_atasan);
                                $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:'';
                                ?>
                                <tr>
                                    <td class="sticky-col first-col">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input check" type="checkbox" name="index[]"  value="<?=$dataKaryawan['npk']?>">
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
        <div class="col-md-6">
            <p class="badge badge-warning badge-pill">total data ditemukan : <?=$jml?></p>
        </div>
        <div class="col-md-6 ">
            <ul class="pagination pagination-sm pull-right" id="pagination">
                <?php
                // $sOrg = mysqli_query($link, $qOrg)or die(mysqli_error($link));
                $jml_hal = ceil($jml / $batas);
                $cari = (@$_GET['cari'] != '') ? @$_GET['cari'] : "";
                $index_hal = 2;
                $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
                $next = $hal + 1;
        
                $end = ($hal < ($jml_hal - $index_hal)) ? $hal + $index_hal : $jml_hal;
                if($jml > 0){
                    if($hal == 1){
                        ?>
                        <li class="page-item disabled"><a class="page-link btn-primary page" href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=1#pagination"" aria-label="Previous">FIRST</a></li>
                        <li class="page-item disabled"><a class="page-link btn-primary page" href="#pagination" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                        <?php
                    } else{
                        $prev = ($hal > 1)? $hal - 1 : 1;
                        ?>
                        <li class="page-item"><a class="page-link btn-primary page" data-id="1" href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=1#pagination" aria-label="Previous">FIRST</a></li>
                        <li class="page-item"><a class="page-link btn-primary page" data-id="<?=$prev?>" href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=<?=$prev?>" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                        <?php
                    }
                    for($i = $start; $i <= $end; $i++){
                        $link_active = ($hal == $i)? ' active' : '';
                        ?>
                        <li class="page-item <?=$link_active?>"><a href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=<?=$i?>#pagination" data-id="<?=$i?>" class="page-link btn-primary btn-link page"><?=$i?></a></li>
                        <?php
                    }
                    if($hal == $jml_hal){
                        ?>
                        <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#">LAST</a></li>
                        <?php
                    } else{
                        ?>
                        <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$next?>" href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=<?=$next?>#pagination"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$jml_hal?>" href="?cari=<?=$_GET['cari']?>&deptAcc=<?=$_GET['deptAcc']?>&hal=<?=$jml_hal?>#pagination">LAST</a></li>
                        <?php
                    }
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
</div>

