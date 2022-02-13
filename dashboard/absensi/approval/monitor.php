<?php
$show = (isset($_GET['cari']))? "collapse show" : "collapse";

// echo $status;
list($request,$proses,$return,$stop,$approve,$reject,$delete) = authBtn($level);

                                            
?>
<div class="row">
    <div class="col-md-12">
    <?php
    include_once('modal.php');
    ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title " >Pengajuan Absensi</h4>
                        <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>

                    </div>
                    <div class="col-md-6 text-right">
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group bg-transparent ">
                                    <select class="form-control" name="att_type" id="att_type">
                                        <option value="">Pilih Tipe Pengajuan</option>
                                        <?php
                                        $q_attType = mysqli_query($link, "SELECT * FROM attendance_type")or die(mysqli_error($link));
                                        if(mysqli_num_rows($q_attType)){
                                            $collect = array();
                                            while($data = mysqli_fetch_assoc($q_attType)){
                                                ?>
                                                <option value="<?=$data['id']?>"><?=$data['name']?> / <?=$data['id']?></option>
                                                <?php
                                                $collect[] = $data['id'];
                                            }
                                            $data_collect = "";
                                            foreach($collect AS $collect){
                                                $data_collect .= $collect." + ";
                                            }
                                            $data_collect=substr($data_collect, 0, -2);
                                            ?>
                                            <option value=""><?=$data_collect?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group bg-transparent">
                                    <select class="form-control" name="att_type" id="att_progress">
                                        <option value="">Pilih Progress Pengajuan</option>
                                        <?php
                                            $dataProgress = array('25a','50a','75a','100a','100b','100c','100d','100f');
                                            foreach($dataProgress AS $prog){
                                                ?>
                                                <option value="<?=$prog?>"><?=authText($prog)?></option>
                                                <?php
                                            }
                                        ?>
                                        <option value="">Tampilkan Semua</option>
                                        
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="my-2 mr-2 float-left order-3">
                            <div class="input-group bg-transparent">
                                <input type="text" name="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk.." id="cari">
                                <div class="input-group-append bg-transparent">
                                    <div class="input-group-text bg-transparent">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 text-right">
                        <label for="">approval data :</label>
                        <?php
                            if($approve == 1){
                                ?>
                                <button class="btn btn-sm btn-primary ml-2 approveAll" type="button" 
                                        data-toggle="tooltip" data-placement="bottom" title="approve">
                                        <i class="fa fa-check-circle"></i> Approve
                                </button>
                                <?php
                            }
                            if($reject == 1){
                                ?>
                                <button class="btn btn-sm btn-danger rejectAll" type="button" 
                                        data-toggle="tooltip" data-placement="bottom" title="reject">
                                        <i class="fa fa-ban"></i> Reject
                                </button>
                                <?php
                            }
                            if($proses == 1){
                                ?>
                                <button class="btn btn-sm btn-primary ml-2 prosesAll" type="button" 
                                        data-toggle="tooltip" data-placement="bottom" title="approve">
                                        <i class="fa fa-check-circle"></i> Proses
                                </button>
                                <?php
                            }
                            if($stop == 1){
                                ?>
                                <button class="btn btn-sm btn-danger stopAll" type="button" 
                                        data-toggle="tooltip" data-placement="bottom" title="reject">
                                        <i class="fa fa-ban"></i> Stop
                                </button>
                                <?php
                            }
                            if($return == 1){
                                ?>
                                <button class="btn btn-sm btn-warning returnAll" type="button"
                                    data-toggle="tooltip" data-placement="bottom" title="Kembalikan">
                                    <i class="fa fa-undo"></i> Kembalikan
                                </button>
                                <?php
                            }
                            if($delete == 1){
                                ?>
                                <button class="btn btn-sm btn-danger deleteAll" type="button"
                                    data-toggle="tooltip" data-placement="bottom" title="Kembalikan">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <?php
                            }
                        ?>                        
                    </div>
                </div>
                
            </div>
            <hr class="my-0">
            <div class="card-body " >
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
                    <div class="col-md-12" id="data-monitoring">
                    
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

