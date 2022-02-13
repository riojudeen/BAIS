<?php
?>
<div class="collapse" id="collapseExample">
   
    <div class="row">
        <div class="col-md-9 pull-left">
            <h6 class="card-category " ></h6>
        </div>
    </div>
    <div class="row">
        <h6 class="col-md-6">TAMBAH DATA</h6>
    </div>
    <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

        <div class="card-body  mt-2">

            <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Tanggal</label>
                                <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                    <input type="text" name="tanggal" id="tanggal" class="form-control datepicker tanggal" placeholder="tanggal">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Model Unit</label>
                                <div class="form-group" style="background:rgba(255, 255, 255, 0.3)">
                                <select class="form-control model" name="model" id="model">
                                    <?php
                                    $q_model = mysqli_query($link, "SELECT * FROM production_model WHERE stats = 'active'")or die(mysqli_error($ink));
                                    if(mysqli_num_rows($q_model)>0){
                                        while($data = mysqli_fetch_assoc($q_model)){
                                            ?>
                                            <option value="<?=$data['id_model']?>"><?=$data['name']?> - <?=$data['alias']?></option>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <option disabled>Belum ada data</option>

                                        <?php
                                    }
                                    ?>
                                </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Shift</label>
                                    <div class="form-group" >
                                        <select required id="data_shift" name="data_shift" class="form-control data_shift">
                                            <?php
                                            $q_shift = mysqli_query($link, "SELECT `id_shift` AS id, `shift` AS `name` FROM `shift` WHERE `production` = '1' ")or die(mysqli_error($ink));
                                            if(mysqli_num_rows($q_shift)>0){
                                                while($data = mysqli_fetch_assoc($q_shift)){
                                                    ?>
                                                    <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option disabled>Belum ada data</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                
                            </div>
                            <div class="col-md-2">
                                <label for="">Result</label>
                                <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                    <input type="number" name="result" id="result" class="form-control result" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group rounded py-auto text-center mt-2 mb-2" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                                    <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail mx-0" style="min-width:300px">
                                            <input type="text" class="form-control mx-0">
                                        </div>
                                        <div >
                                            <span class="btn btn-sm btn-link btn-round btn-rose btn-file ">
                                            <span class="fileinput-new ">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                                <input type="file" name="upload_img" />
                                            </span>
                                            <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists " data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input all" type="checkbox" name="doccek" id="documentcek" value="1">
                                <span class="form-check-sign">upload dari file</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for=""></label>
                        <div class="form-group-sm pull-right" >
                            <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                            <button type="submit" id="add_model" class="btn btn-sm btn-primary  add_line" name="add">
                            <i class="fas fa-plus"></i> add
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>