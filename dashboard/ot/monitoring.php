<?php

?>
<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-6 ">
                       
                        <h4 class="card-title " >Absensi Karyawan</h4>
                        <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-sm btn-primary tb_absensi">
                            Export to Excel
                        </button>
                    </div>
                </div>
            </div>
           
            <hr>
            <div class="card-body " >
                <div class="row">
                    <div class="col-md-12 spinner_load " style="display:none">
                        <div class="card shadow-none">
                            <div class="card-body " style="background-image: linear-gradient(to right, rgb(255,255,255) ,rgb(244,243,239) ,  rgb(255,255,255));">
                                <div class="text-center" >
                                    <img id="img-spinner" src="../../assets/img/loading/load.gif" style="height:50px">
                                    <label class="label">please wait downloading resources...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group no-border">
                                    <select class="form-control" name="div" id="s_div">
                                        <option value="">Pilih Divisi</option>
                                    </select>
                                    <select class="form-control" name="dept" id="s_dept">
                                        <option value="">Pilih Department</option>
                                        <option value="" disabled>Pilih Division Terlebih Dahulu</option>
                                    </select>
                                    <select class="form-control" name="section" id="s_section">
                                        <option value="">Pilih Section</option>
                                        <option value="" disabled>Pilih Department Terlebih Dahulu</option>
                                    </select>
                                    <select class="form-control" name="groupfrm" id="s_goupfrm">
                                        <option value="">Pilih Group</option>
                                        <option value="" disabled>Pilih Section Terlebih Dahulu</option>
                                    </select>
                                    <select class="form-control" name="shift" id="s_shift">
                                        <option value="">Pilih Shift</option>
                                        <?php
                                            $query_shift = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                            if(mysqli_num_rows($query_shift)>0){
                                                while($data = mysqli_fetch_assoc($query_shift)){
                                                    ?>
                                                    <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option value="">Belum Ada Data Shift</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <select class="form-control" name="deptacc" id="s_deptAcc">
                                        <option value="">Pilih Department Administratif</option>
                                        <?php
                                            $q_div = mysqli_query($link, "SELECT `id`,`nama_org`,`cord`,`nama_cord` FROM `view_cord_area` WHERE `part` = 'deptAcc'")or die(mysqli_error($link));
                                            if(mysqli_num_rows($q_div) > 0){
                                                while($data = mysqli_fetch_assoc($q_div)){
                                                ?>
                                                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                                <?php
                                                }
                                            }else{
                                                ?>
                                                <option value="">Belum Ada Data Department Administratif</option>
                                                <?php
                                            }
                                        ?>
                                        </select>
                                    <div class="input-group-append ">
                                        <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="monitor"></div>
                        </div>
                        <?php
                        /*
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
                        */
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
