<?php
// echo $org_access;
// echo $access_;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card " >
            <div class="card-header ">
                <div class="pull-left ">
                    <h4 class="card-title " >Absensi Karyawan</h4>
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
                                            $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
                                            absensi.npk AS npk_absen, 
                                            absensi.shift AS shift_absen,
                                            absensi.date AS tanggal,
                                            absensi.check_in AS check_in,
                                            absensi.check_out AS check_out,
                                            absensi.ket AS ket,
                                            
                                            attendance_code.kode AS kode_absen,
                                            attendance_code.keterangan AS ket_kode_absen,
                                            attendance_code.type AS tipe_kode_absen,

                                            org.npk AS npk_org,
                                            org.sub_post AS sub_post,
                                            org.post AS post,
                                            org.grp AS grp,
                                            org.sect AS sect,
                                            org.dept AS dept,
                                            org.dept_account AS dept_account,
                                            org.division AS division,
                                            org.plant AS plant,

                                            karyawan.npk AS npk_,
                                            karyawan.nama AS nama_,
                                            karyawan.shift AS shift_,
                                            karyawan.id_area AS id_area_,
                                            karyawan.department AS department_

                                            FROM absensi
                                            JOIN karyawan ON karyawan.npk = absensi.npk
                                            JOIN attendance_code ON attendance_code.kode = absensi.ket 
                                            JOIN org ON org.npk = karyawan.npk
                                            WHERE attendance_code.type = 'REMARK' AND  absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $clm = '$access_' ")or die(mysqli_error($link));
                                        }else{
                                            $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
                                            absensi.npk AS npk_absen, 
                                            absensi.shift AS shift_absen,
                                            absensi.date AS tanggal,
                                            absensi.check_in AS check_in,
                                            absensi.check_out AS check_out,
                                            absensi.ket AS ket,
                                            
                                            attendance_code.kode AS kode_absen,
                                            attendance_code.keterangan AS ket_kode_absen,
                                            attendance_code.type AS tipe_kode_absen,

                                            org.npk AS npk_org,
                                            org.sub_post AS sub_post,
                                            org.post AS post,
                                            org.grp AS grp,
                                            org.sect AS sect,
                                            org.dept AS dept,
                                            org.dept_account AS dept_account,
                                            org.division AS division,
                                            org.plant AS plant,

                                            karyawan.npk AS npk_,
                                            karyawan.nama AS nama_,
                                            karyawan.shift AS shift_,
                                            karyawan.id_area AS id_area_,
                                            karyawan.department AS department_

                                            FROM absensi
                                            JOIN karyawan ON karyawan.npk = absensi.npk
                                            JOIN  attendance_code ON attendance_code.kode = absensi.ket 
                                            JOIN org ON org.npk = karyawan.npk
                                            WHERE attendance_code.type = 'REMARK' AND  absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $clm = '$access_' AND (karyawan.npk LIKE '%$cari%' OR karyawan.nama LIKE '%$cari%')")or die(mysqli_error($link));
                                        }
                                    }else{
                                        $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
                                        absensi.npk AS npk_absen, 
                                        absensi.shift AS shift_absen,
                                        absensi.date AS tanggal,
                                        absensi.check_in AS check_in,
                                        absensi.check_out AS check_out,
                                        absensi.ket AS ket,

                                        attendance_code.kode AS kode_absen,
                                        attendance_code.keterangan AS ket_kode_absen,
                                        attendance_code.type AS tipe_kode_absen,

                                        org.npk AS npk_org,
                                        org.sub_post AS sub_post,
                                        org.post AS post,
                                        org.grp AS grp,
                                        org.sect AS sect,
                                        org.dept AS dept,
                                        org.dept_account AS dept_account,
                                        org.division AS division,
                                        org.plant AS plant,

                                        karyawan.npk AS npk_,
                                        karyawan.nama AS nama_,
                                        karyawan.shift AS shift_,
                                        karyawan.id_area AS id_area_,
                                        karyawan.department AS department_

                                        FROM absensi
                                        JOIN karyawan ON karyawan.npk = absensi.npk
                                        JOIN attendance_code ON attendance_code.kode = absensi.ket 
                                        JOIN org ON org.npk = karyawan.npk
                                        WHERE attendance_code.type = 'REMARK' AND absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $clm = '$access_'  ")or die(mysqli_error($link));
                                    
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
                                                <td><?=$dAbsenHr['id_area_']?></td>
                                                <td><?=$dAbsenHr['tanggal']?></td>
                                                <td><?=$checkIn_?></td>
                                                <td><?=$checkOut_?></td>
                                                <td><?=$dAbsenHr['ket']?></td>
                                                <td class="text-center">
                                                    <p class="badge badge-pill badge-info " data-toggle="tooltip" data-placement="bottom" title="<?=$data_checkHr['check_in']?> s.d. <?=$data_checkHr['check_out']?>"><?=$data_checkHr['keterangan']?></p>
                                                </td>
                                                <td class="text-right text-nowrap">
                                                    <a <?=$tbl_disable?> href="add.php?id=<?=$dAbsenHr['id_absen']?>" class="btn-round btn-outline-primary btn btn-primary btn-link btn-icon btn-sm"><i class="nc-icon nc-simple-add"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr class="text-center"><td colspan="11">Tidak Ditemukan data di database</td></tr>
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
