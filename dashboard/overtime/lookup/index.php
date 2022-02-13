<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Request Lembur";


if(isset($_SESSION['user'])){

    include("../../header.php");
    

    if(isset($_GET['dr'])){//draft
        $kode = $_GET['dr'];
        $title = "Draft Surat Pengajuan Overtime";
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$kode' AND status_approve = '0' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['de'])){//not approve / deny
        $title = "Pengajuan Overtime Ditolak";
        $kode = $_GET['de'];
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$_GET[de]' AND status_approve = '50' AND `status` = 'b' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['re'])){//request
        $kode = $_GET['re'];
        $title = "Pengajuan Overtime Sudah Disubmit";
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$_GET[re]' AND status_approve = '25' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['pn'])){//approval pending
        $kode = $_GET['pn'];
        $title = "Approval Pending";
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$_GET[pn]' AND status_approve = '50' AND `status` = 'a' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['sc'])){//sukses approve hrd
        $kode = $_GET['sc'];
        $title = "Pengajuan Overtime Selesai";
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$_GET[sc]' AND status_approve = '100' ")or die(mysqli_error($link));
        
    }else if(isset($_GET['pr'])){//proses
        $kode = $_GET['pr'];
        $title = "Pengajuan Overtime Diproses Admin";
        $s_lembur = mysqli_query($link, "SELECT * FROM lembur WHERE kode_lembur = '$_GET[pr]' AND status_approve = '75' ")or die(mysqli_error($link));
        
    }
    $j_data = mysqli_num_rows($s_lembur);
    
    ?>
    <div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <div class="pull-left">
                    <h5 class="card-title"><?=$title?></span>
                        <span class="badge badge-pill badge-danger"><?=$j_data." data"?></span>
                    </h5>
                    <p class="card-category">No Surat : <?= $kode?></p>
                </div>
                
                <div class="box pull-right">
                    
                    <a href="../index.php" class="btn btn-default">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body ">
            
                

                <!-- form -->
                <form method="post" action="">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="row" class="py-0 text-center" rowspan="2">#</th>
                                    <th scope="row" class="py-0 text-center " rowspan="2">NPK</th>
                                    <th scope="row" class="py-0 text-center " rowspan="2" >Nama</th>
                                    <th scope="row" class="py-0 text-center" colspan="2" >Jam Overtime</th>
                                    <th scope="row" class="py-0 text-center" rowspan="2">Activity</th>
                                    <th scope="row" class="py-0 text-center" rowspan="2">Kode</th>
                                    <th scope="row" class="py-0 text-center" rowspan="2">Action</th>
                                    <th scope="row" class="py-0 text-center" rowspan="2">
                                    <div class="form-check text-right">
                                        <label class="form-check-label">
                                        <input class="form-check-input " id="all" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="row" class="py-0 text-center"> OT Mulai</th>
                                    <th scope="row" class="py-0 text-center">OT Selesai</th>
                                    
                                </tr>
                            </thead>

                            <tbody class="after-add-more">
                            <?php
                            $no = 1;
                            while($d_ot = mysqli_fetch_assoc($s_lembur)){
                                $s_nama = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$d_ot[npk]' ")or die(mysqli_error($link));
                                $d_nama = mysqli_fetch_assoc($s_nama);
                                
                                ?>
                                <tr>
                                <td><?=$no++?></td>
                                <td><?=$d_ot['npk']?></td>
                                <td><?=$d_nama['nama']?></td>
                                <td><?=$d_ot['in_lembur']?></td>
                                <td><?=$d_ot['out_lembur']?></td>
                                <td><?=$d_ot['aktifitas']?></td>
                                <td><?=$d_ot['kode_job']?></td>
                                <td class="text-center">
                                    <a type="button" rel="tooltip" class="btn btn-danger btn-simple btn-icon btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="form-check text-right">
                                        <label class="form-check-label">
                                        <input class="form-check-input " id="checkdata" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>

                                </tr>
                                <?php
                            }

                            ?>
                                
                            </tbody>
                            

                                    
                        </table>
                        
                    </div>
                    <div class="box pull-right">
                        <button class="btn btn-primary">
                            <span class="btn-label">
                                <i class="nc-icon nc-settings-gear-65"></i>
                            </span>
                            Delete All
                        </button>
                        <button type="reset" class="btn btn-danger">
                            <span class="btn-label">
                                <i class="nc-icon nc-settings-gear-65"></i>
                            </span>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer ">
                <div class="stats">
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    include("../../footer.php");
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}