<?php

?>
<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
                <div class="pull-left ">
                    <h4 class="card-title " >Overtime Monitoring</h4>
                    <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                </div>
            </div>
           
            <hr>
            <div class="card-body " >
                <div class="row">
                    <div class="col">
                        <div class="table-responsive" >
                            <table class="table table-striped text-uppercase">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Shift</th>
                                        <th>Area</th>
                                        <th>Dept</th>
                                        <th>Tanggal</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Ket</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase">
                                <?php
                                // echo mysqli_num_rows($sqlLembur) ;
                                $no = 1;
                                
                                if(mysqli_num_rows($sqlLembur) > 0){
                                    while($dataOt = mysqli_fetch_assoc($sqlLembur)){
                                        $qryAbsen = $qryAbsenHr." WHERE absensi.npk = '$dataOt[npk_]' AND absensi.date = '$dataOt[date_lemburHr]' ";
                                        $dataAbsen = mysqli_query($link, $qryAbsen)or die(mysqli_error($link));
                                        $absen = mysqli_fetch_assoc($dataAbsen);
                                        $check_in = ($absen['check_in'] == "00:00:00" OR $absen['check_in'] == "")?"-":$absen['check_in'];
                                        $check_out = ($absen['check_out'] == "00:00:00" OR $absen['check_out'] == "")?"-":$absen['check_out'];
                                        ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$dataOt['npk_']?></td>
                                            <td><?=$dataOt['nama_']?></td>
                                            <td><?=$dataOt['shift_']?></td>
                                            <td><?=$dataOt['groupfrm']?></td>
                                            <td><?=$dataOt['deptAcc']?></td>
                                            <td><?=$dataOt['date_lemburHr']?></td>
                                            <td><?=$check_in?></td>
                                            <td><?=$check_out?></td>
                                            <td><?=$absen['ket']?></td>
                                            <td><?=$dataOt['start_lemburHr']?></td>
                                            <td><?=$dataOt['end_lemburHr']?></td>
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr><td colspan="12" class="text-center">Tidak Ada Data Overtime di database</td></tr>
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
