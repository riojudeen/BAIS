<?php
?>

<div class="collapse tambah collapse-view" id="tambah">
    <div class="row">
        <div class="col-md-12">
           
            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                <div class="card-body  mt-2">
                
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        
                        <div class="row">
                            <div class="col-sm-12 ">
                                <fieldset > 
                                <legend class="text-muted h6">Employee Data : </legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Department Account</label>
                                        <div class="form-group text-uppercase" style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-deptfunctional text-uppercase" name="dept" id="deptacc" placeholder="select masal">
                                                <?php
                                                $s_div = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'division' ")or die(mysqli_error($link));
                                                if(mysqli_num_rows($s_div)){
                                                    ?>
                                                    <option disabled>Pilih Department Account</option>
                                                    <?php
                                                    while($dataDiv=mysqli_fetch_assoc($s_div)){
                                                        $s_dept = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc' AND id_parent = '$dataDiv[id]' ")or die(mysqli_error($link));
                                                        ?>
                                                        <optgroup label="- <?=$dataDiv['nama_org']?> -">
                                                        <?php
                                                        if(mysqli_num_rows($s_dept)>0){
                                                            while($dataDept = mysqli_fetch_assoc($s_dept)){
                                                                ?>
                                                                <option value="<?=$dataDept['id']?>"><?=$dataDept['nama_org']?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            </optgroup>
                                                            
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option disabled>Belum Ada Data Department</option>
                                                            <?php
                                                        }
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data Divisi</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="notset">Kosongkan</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Group Shift</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-shift text-uppercase" name="groupshift" id="groupshift" placeholder="select masal">
                                                
                                            <?php
                                                $q_shift = mysqli_query($link, "SELECT * FROM shift  ")or die(mysqli_error($link));

                                                if(mysqli_num_rows($q_shift)>0){
                                                    ?>
                                                    <option disabled>Pilih Group Shift</option>
                                                    <?php
                                                    while($dataShift = mysqli_fetch_assoc($q_shift)){
                                                        ?>
                                                        <option value="<?=$dataShift['id_shift']?>"><?=$dataShift['id_shift']?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="notset">Kosongkan</option>
                                            </select>   
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Jabatan</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-jabatan text-uppercase" name="jabatan" id="jabatan" placeholder="select masal">
                                                
                                            <?php
                                                $q_jabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` DESC")or die(mysqli_error($link));

                                                if(mysqli_num_rows($q_jabatan)>0){
                                                    ?>
                                                    <option disabled>Pilih Jabatan</option>
                                                    <?php
                                                    while($dataJabatan = mysqli_fetch_assoc($q_jabatan)){
                                                        ?>
                                                        <option value="<?=$dataJabatan['id_jabatan']?>"><?=$dataJabatan['jabatan']?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="notset">Kosongkan</option>
                                            </select>   
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-status text-uppercase" name="status" id="status" placeholder="select masal">
                                                
                                            <?php
                                                $q_status = mysqli_query($link, "SELECT * FROM `status_mp` ")or die(mysqli_error($link));

                                                if(mysqli_num_rows($q_status)>0){
                                                    ?>
                                                    <option disabled>Pilih Status</option>
                                                    <?php
                                                    while($dataStatus = mysqli_fetch_assoc($q_status)){
                                                        ?>
                                                        <option value="<?=$dataStatus['id']?>"><?=$dataStatus['id']?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="notset">Kosongkan</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <label for="">Role User</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-role text-uppercase" name="roleuser" id="roleuser" placeholder="select masal">
                                                
                                            <?php
                                                $q_role = mysqli_query($link, "SELECT id_role, role_name FROM user_role  ")or die(mysqli_error($link));

                                                if(mysqli_num_rows($q_role)>0){
                                                    ?>
                                                    <option disabled>Atur Role User</option>
                                                    <?php
                                                    while($dataUser = mysqli_fetch_assoc($q_role)){
                                                        ?>
                                                        <option value="<?=$dataUser['id_role']?>"><?=$dataUser['role_name']?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>   
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-7">

                                        <label for="">Passwords</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control bg-transparent passw" name="pass" id="password" disabled placeholder="masukan password user">
                                            <div class="input-group-append">
                                            <div class="input-group-text bg-transparent">
                                                <i class="fa fa-eye mata2 d-none"></i>
                                                <i class="fa fa-eye-slash mata1"></i>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all default-pass" id="defaultpass" type="checkbox" name="pass-default" value="1" checked>
                                                <span class="form-check-sign">default password : tanggal masuk (dd-mm-yyyy)</span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                                </fieldset>
                                <hr> 
                                <fieldset>
                                <legend class="text-muted h6">Organization Data</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Department Functional</label>
                                        <div class="form-group text-uppercase" style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-dept text-uppercase" id="department" placeholder="select masal">
                                                <?php
                                                $s_div = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'division' ")or die(mysqli_error($link));
                                                if(mysqli_num_rows($s_div)){
                                                    ?>
                                                    <option disabled>Pilih Department Functional</option>
                                                    <?php
                                                    while($dataDiv=mysqli_fetch_assoc($s_div)){
                                                        $s_dept = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'dept' AND id_parent = '$dataDiv[id]' ")or die(mysqli_error($link));
                                                        ?>
                                                        <optgroup label="- <?=$dataDiv['nama_org']?> -">
                                                        <?php
                                                        if(mysqli_num_rows($s_dept)>0){
                                                            while($dataDept = mysqli_fetch_assoc($s_dept)){
                                                                ?>
                                                                <option value="<?=$dataDept['id']?>"><?=$dataDept['nama_org']?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            </optgroup>
                                                
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option disabled>Belum Ada Data Department</option>
                                                            <?php
                                                        }
                                                    }
                                                }else{
                                                    ?>
                                                    <option disabled>Belum Ada Data Divisi</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="notset" selected>Kosongkan</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Section</label>
                                        <div class="form-group text-uppercase" style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-section text-uppercase" id="section" placeholder="select masal">
                                                <option value="notset">Kosongkan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Group</label>
                                        <div class="form-group text-uppercase" style="background:rgba(255, 255, 255, 0.3)">
                                            <select id="group" type="text" class="form-control bg-transparent data-group text-uppercase" placeholder="select masal">
                                                <option value="notset">Kosongkan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Pos Leader</label>
                                        <div class="form-group text-uppercase" style="background:rgba(255, 255, 255, 0.3)">
                                            <select id="posleader" type="text" class="form-control bg-transparent data-pos  text-uppercase" placeholder="select masal">
                                                <option value="notset">Kosongkan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                            
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div >
                                    <span class="btn btn-sm btn-link btn-round btn-rose btn-file ">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file-excel" id="file_export"/>
                                    </span>
                                    <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input all" type="checkbox" name="doccek" id="documentcek" value="1">
                                <span class="form-check-sign">gunakan data organisasi dari dokumen upload</span>
                            </label>
                        </div>
                        
                        <a  class="btn btn-sm btn-danger  btn-link closecol" data-toggle="collapse" href=".collapse-view" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                        <button type="button" class="btn btn-sm btn-primary load-data" data-toggle="modal" data-target="#loaddata">Load Data</button>
                        <a href="<?=base_url()?>/file/template/Format_upload_karyawan.xlsx" type="button" class="btn btn-sm btn-link btn-info pull-right"><i class="fas fa-file-excel"></i> download format</a>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>