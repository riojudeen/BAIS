<?php
// echo $org_access;
// echo $access_;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card " >
            <div class="card-header ">
                <div class="pull-left ">
                    <h4 class="card-title " >Konfirmasi Absensi Karyawan</h4>
                    <p class="card-category ">Periode : <?=$tanggalAwal." s.d. ".$tanggalAkhir?></p>
                </div>
                
                <p class="box pull-right ">
                    
                    <button class="btn btn-icon btn-link btn-danger btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                        <i class="nc-icon nc-simple-remove "></i> 
                    </button>
                </p>
                
            </div>
            <hr>
            <div class="card-body ">
                <div class="row">
                    <div class="col">
                        
                        <div class="table-responsive" >
                            <table class="table table-striped">
                                
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Shift</th>
                                        <th>Area</th>
                                        <th>Department</th>
                                        <th>Tanggal</th>
                                        <th>Check in</th>
                                        <th>Check out</th>
                                        <th>Ket</th>
                                        <th>Pengajuan</th>
                                        <th class="text-right ">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase">
                                    <?php
                                    $clm= "org.".$org_access;
                                    // echo $clm;
                                    if(isset($_POST['cari'])){
                                        $cari = trim(mysqli_real_escape_string($link, $_POST['cari']));
                                        if(empty($cari)){
                                            $sql_absenHr = mysqli_query($link, $qryAbsenHr)or die(mysqli_error($link));
                                        }else{
                                            $qryAbsenHr .=  " AND (karyawan.npk LIKE '%$cari%' OR karyawan.nama LIKE '%$cari%')";
                                            $sql_absenHr = mysqli_query($link, $qryAbsenHr)or die(mysqli_error($link));
                                        }
                                    }else{
                                        $sql_absenHr = mysqli_query($link, $qryAbsenHr)or die(mysqli_error($link));
                                    
                                    }
                                    
                                    $noUrut = 1;
                                    if(mysqli_num_rows($sql_absenHr) > 0){
                                        while($dAbsenHr = mysqli_fetch_assoc($sql_absenHr)){
                                            $checkIn_ = ($dAbsenHr['check_in'] == '00:00:00')? "-" :$dAbsenHr['check_in'];
                                            $checkOut_ = ($dAbsenHr['check_out'] == '00:00:00')? "-" :$dAbsenHr['check_out'];
                                            $qry_check = mysqli_query($link, "SELECT 
                                            req_absensi.id AS id_absen,
                                            req_absensi.npk AS npk_absen, 
                                            req_absensi.shift AS shift_absen,
                                            req_absensi.date AS tanggal,
                                            req_absensi.date_in AS tanggal_masuk,
                                            req_absensi.date_out AS tanggal_keluar,
                                            req_absensi.check_in AS check_in,
                                            req_absensi.check_out AS check_out,
                                            req_absensi.keterangan AS keterangan,
                                            req_absensi.requester AS requester,
                                            req_absensi.status AS status_absen,
                                            req_absensi.req_status AS req_status,
                                            req_absensi.req_date AS req_date 
                                            FROM req_absensi
                                            WHERE req_absensi.npk = '$dAbsenHr[npk_absen]' AND req_absensi.date = '$dAbsenHr[tanggal]' ")or die(mysqli_error($link));
                                            $text_clr = (mysqli_num_rows($qry_check) > 0 )? "text-danger":"";
                                            $tbl_disable = (mysqli_num_rows($qry_check) > 0 )? "disabled":"";
                                            $data_checkHr = mysqli_fetch_assoc($qry_check);
                                            ?>
                                            <tr class="<?=$text_clr?>">
                                                <td><?=$noUrut++?></td>
                                                <td><?=$dAbsenHr['npk_absen']?></td>
                                                <td><?=$dAbsenHr['nama_']?></td>
                                                <td><?=$dAbsenHr['shift_absen']?></td>
                                                <td><?=$dAbsenHr['groupfrm']?></td>
                                                <td><?=$dAbsenHr['deptAcc']?></td>
                                                <td><?=$dAbsenHr['tanggal']?></td>
                                                <td><?=$checkIn_?></td>
                                                <td><?=$checkOut_?></td>
                                                <td><?=$dAbsenHr['ket']?></td>
                                                <td class="text-center">
                                                    <p class="badge badge-pill badge-info "data-toggle="tooltip" data-placement="bottom" title="<?=$data_checkHr['check_in']?> s.d. <?=$data_checkHr['check_out']?>"><?=$data_checkHr['keterangan']?></p>
                                                </td>
                                                <td class="text-right text-nowrap">
                                                    <a <?=$tbl_disable?> href="add.php?id=<?=$dAbsenHr['id_absen']?>" class="btn-round btn-outline-primary btn btn-primary btn-link btn-icon btn-sm"><i class="nc-icon nc-simple-add"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr class="text-center"><td colspan="12">Tidak Ditemukan data di database</td></tr>
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
            </div>
        </div>
    </div>
</div>
