<?php

?>
<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
                
                <div class="pull-left ">
                   
                    <h4 class="card-title " >Absensi Karyawan</h4>
                    <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                </div>
            </div>
           
            <hr>
            <div class="card-body " >
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
                                        <th>Dept</th>
                                        <th>Tanggal</th>
                                        <th>Check in</th>
                                        <th>Check out</th>
                                        <th>Ket</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase">
                                    <?php
                                    // echo $tanggalAwal."<br>";
                                    // echo $tanggalAkhir."<br>";
                                    $clm = "org.".$org_access;
                                    $sql_req = mysqli_query($link, $qryAbsenHr)or die(mysqli_error($link));
                                    $no = 1;
                                    // echo mysqli_num_rows($sql_req);
                                    if(mysqli_num_rows($sql_req) > 0){
                                        while($data_reqAbsensi = mysqli_fetch_assoc($sql_req)){
                                            $checkIn = ($data_reqAbsensi['check_in'] == '00:00:00')? "-" : $data_reqAbsensi['check_in'];
                                            $checkOut = ($data_reqAbsensi['check_out'] == '00:00:00')? "-" : $data_reqAbsensi['check_out'];
                                        ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$data_reqAbsensi['npk_absen']?></td>
                                            <td><?=$data_reqAbsensi['nama_']?></td>
                                            <td><?=$data_reqAbsensi['shift_absen']?></td>
                                            <td><?=$data_reqAbsensi['groupfrm']?></td>
                                            <td><?=$data_reqAbsensi['deptAcc']?></td>
                                            <td><?=$data_reqAbsensi['tanggal']?></td>
                                            <td><?=$checkIn?></td>
                                            <td><?=$checkOut?></td>
                                            <td><?=$data_reqAbsensi['ket']?></td>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr><td colspan="10" class="text-center">Tidak ditemukan data di database</td></tr>
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
