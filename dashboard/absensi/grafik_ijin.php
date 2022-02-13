<?php

?>
<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
                
                <div class="pull-left ">
                   
                    <h4 class="card-title " >Karyawan Cuti / Ijin</h4>
                    <p class="card-category ">karyawan tidak masuk dengan surat cuti / pemberitahuan</p>
                </div>
                
                <p class="box pull-right ">
                
                    <button class="btn btn-link btn-round btn-outline-primary" type="button" data-toggle="collapse" data-target="#ijin" aria-expanded="false" aria-controls="ijin">
                    <i class="nc-icon nc-chart-bar-32 "></i> monthly report
                    </button>
                </p>
            </div>
            <form method="POST">
                <div class="col-5">
                    <div class="input-group border-1">
                        <div class="input-group-prepend ">
                            <div class="input-group-text">
                                <i class="nc-icon nc-calendar-60"></i>
                            </div>
                        </div>
                        <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                        <select type="date" name="start" class="form-control " >
                            <option Disabled>Pilih Bulan</option>
                            <?php
                            
                            $i =0;
                            foreach($bln AS $namaBln){
                                $i++;
                                $selectBln = ($i == $sM)?"selected":"";
                                
                                echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                            }
                            ?>
                        </select>
                        <div class="input-group-prepend ml-2">
                            <div class="input-group-text px-0">
                                
                            </div>
                        </div>
                        <select type="text" name="tahun" class=" form-control ">
                        <option Disabled>Tahun</option>
                        <?php
                        $thnPertama = 2021;
                        for($i=date("Y"); $i>=$thnPertama; $i--){
                            $selectThn = ($i == $tahun)?"selected":"";
                            echo "<option $selectThn value=\"$i\">$i</option>";
                        }
                        ?>
                        </select>
                        <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto" value="go" >
                        
                    </div>
                    
                    <!-- <div class="col-4">
                        <input class="btn btn-icon btn-round" name="sort" value="go">
                    </div> -->
                </div>
            </form>
           
            <hr>
            <div class="card-body " >
                
                <div class="collapse" id="ijin">
                    <canvas id="chartIjin"></canvas>
                </div>
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
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase">
                                    <?php
                                    // echo $tanggalAwal."<br>";
                                    // echo $tanggalAkhir."<br>";
                                    $clm = "org.".$org_access;
                                    $sql_req = mysqli_query($link, "SELECT 
                                    -- req_absensi.id AS id_absen,
                                    -- req_absensi.npk AS npk_absen, 
                                    -- req_absensi.shift AS shift_absen,
                                    -- req_absensi.date AS tanggal,
                                    -- req_absensi.date_in AS tanggal_masuk,
                                    -- req_absensi.date_out AS tanggal_keluar,
                                    -- req_absensi.check_in AS check_in,
                                    -- req_absensi.check_out AS check_out,
                                    -- req_absensi.keterangan AS keterangan,
                                    -- req_absensi.requester AS requester,
                                    -- req_absensi.status AS status_absen,
                                    -- req_absensi.req_status AS req_status,
                                    -- req_absensi.req_date AS req_date,

                                    absensi.id AS id_absenHr,
                                    absensi.npk AS npk_absenHr, 
                                    absensi.shift AS shift_absenHr,
                                    absensi.date AS tanggalHr,
                                    absensi.check_in AS check_inHr,
                                    absensi.check_out AS check_outHr,
                                    absensi.ket AS keteranganHr,

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
                                    JOIN org ON org.npk = karyawan.npk
                                    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
                                    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND (absensi.ket = 'C1' OR absensi.ket = 'C2') AND $clm = '$access_' ")or die(mysqli_error($link));
                                    $no = 1;
                                    // echo mysqli_num_rows($sql_req);
                                    if(mysqli_num_rows($sql_req) > 0){
                                        while($data_reqAbsensi = mysqli_fetch_assoc($sql_req)){
                                            $checkIn = ($data_reqAbsensi['check_inHr'] == '00:00:00')? "-" : $data_reqAbsensi['check_inHr'];
                                            $checkOut = ($data_reqAbsensi['check_outHr'] == '00:00:00')? "-" : $data_reqAbsensi['check_outHr'];
                                        ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$data_reqAbsensi['npk_absenHr']?></td>
                                            <td><?=$data_reqAbsensi['nama_']?></td>
                                            <td><?=$data_reqAbsensi['shift_absenHr']?></td>
                                            <td><?=$data_reqAbsensi['dept_account']?></td>
                                            <td><?=$data_reqAbsensi['tanggalHr']?></td>
                                            <td><?=$checkIn?></td>
                                            <td><?=$checkOut?></td>
                                            <td><?=$data_reqAbsensi['keteranganHr']?></td>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr><td colspan="9" class="text-center">Tidak ditmukan data di database</td></tr>
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
