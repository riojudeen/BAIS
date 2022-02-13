<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_GET['editmodel'])){
    ?>
    <form action="" id="form-modalEdit" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="nc-icon nc-simple-remove"></i>
            </button>
            <h5 class="modal-title" id="myModalLabel">Edit Model Kendaraan</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group rounded py-auto text-center mt-4 form-gambar d-none" style="border:1px dashed rgba(213, 213, 213, 0.9) ;background:rgba(213, 213, 213, 0.5)">
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
                                    <input type="file" id="upload_gambar" name="upload_gambar" />
                                </span>
                                <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists " data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="picture">
                        <?php
                        $query = mysqli_query($link, "SELECT * FROM production_model WHERE id_model = '$_GET[editmodel]'")or die (mysqli_error($link));
                        $sql = mysqli_fetch_assoc($query);
                        $dataImage = base_url()."/assets/img/unit_model/".$sql['alias'].".png";
                        ?>
                        <img src="<?=$dataImage?>" alt="Thumbnail Image " class="rounded img-raised shadow-none" >
                    </div>
                    <button type="button" class="btn btn-sm btn-info btn-outline-danger btn-ubah ">ganti gambar</button>
                    <button type="button" class="btn btn-sm btn-info btn-outline-danger d-none btn-cancel">urungkan</button>
                </div>  
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Input Nama Model Kendaraan</label>
                        <input type="text" name="namaModel" id="namaModel" class="form-control" value="<?=$sql['name']?>">
                        <input type="hidden" name="idModel" id="idModel" class="idModel" value="<?=$sql['id_model']?>">
                        <input type="hidden" name="control-edit" id="control-edit" class="form-control control-edit" value="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Alias</label>
                        <input type="text" name="aliasModel" id="aliasModel" class="form-control aliasModel" value="<?=$sql['alias']?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Status</label>
                        <select required  name="statsModel" id="statsModel" class="form-control statsModel">
                            <?php
                            if($sql['stats']=='active'){
                                
                                ?>
                                <option selected value="active">Aktif</option>
                                <option value="discontinued">Discontinued</option>
                                <?php
                            }else{
                                ?>
                                <option value="active">Aktif</option>
                                <option selected value="discontinued">Discontinued</option>
                                <?php
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <input type="submit" class="btn btn-info btn-round" name="edit" id="edit" value="save">
        </div>
    </form>
    <?php
      
    }else if(isset($_GET['editline'])){
        $query = mysqli_query($link, "SELECT * FROM production_line WHERE id_line = '$_GET[editline]'")or die (mysqli_error($link));
        $sql = mysqli_fetch_assoc($query);
        ?>
        <form action="" id="form-modalEdit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="modal-title" id="myModalLabel">Edit Line Produksi</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Input Nama Line Produksi</label>
                            <input type="text" name="namaLine" id="namaLine" class="form-control" value="<?=$sql['nama']?>">
                            <input type="hidden" name="idLine" id="idLine" class="idLine" value="<?=$sql['id_line']?>">
                            
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Department Account</label>
                            <select required  name="namaDeptAcc" id="namaDeptAcc" class="form-control namaDeptAcc">
                            <?php
                            $q_dept = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($q_dept)>0){
                                while($data = mysqli_fetch_assoc($q_dept)){
                                    $select = ($data['id'] == $sql['id_dept_account'])?"selected":"";
                                    ?>
                                    
                                    <option <?=$select?> value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Model</label>
                            <select required  name="namaModel" id="namaModel" class="form-control namaModel">
                            <?php
                                $q_model = mysqli_query($link, "SELECT * FROM production_model WHERE stats = 'active'")or die(mysqli_error($ink));
                                if(mysqli_num_rows($q_model)>0){
                                    while($data = mysqli_fetch_assoc($q_model)){
                                        $select = ($data['id_model'] == $sql['id_model'])?"selected":"";
                                        ?>
                                        <option <?=$select?> value="<?=$data['id_model']?>"><?=$data['name']?> - <?=$data['alias']?></option>
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
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <input type="submit" class="btn btn-info btn-round" name="edit" id="edit" value="save">
            </div>
        </form>
        <?php
    }else if(isset($_GET['editarea'])){
        $query = mysqli_query($link, "SELECT * FROM view_production_area WHERE id = '$_GET[editarea]'")or die (mysqli_error($link));
        $sql = mysqli_fetch_assoc($query);
        ?>
        <form action="" id="form-modalEdit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="modal-title" id="myModalLabel">Edit Area Produksi</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Input Area Produksi</label>
                            <input type="text" name="namaArea" id="namaArea" class="form-control" value="<?=$sql['prod_name']?>">
                            <input type="hidden" name="idArea" id="idArea" class="idArea" value="<?=$sql['id']?>">
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Group</label>
                            <select required  name="areaGroup" id="areaGroup" class="form-control areaGroup">
                            <?php
                            $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($q_group)>0){
                                while($data = mysqli_fetch_assoc($q_group)){
                                    $select = ($data['id'] == $sql['id_group'])?"selected":"";
                                    ?>
                                    
                                    <option <?=$select?> value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Shift</label>
                            <select required  name="areaShift" id="areaShift" class="form-control areaShift">
                            <?php
                            $query = mysqli_query($link, "SELECT * FROM shift WHERE production = '1'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($query)>0){
                                while($data = mysqli_fetch_assoc($query)){
                                    $select = ($data['id_shift'] == $sql['shift'])?"selected":"";
                                    ?>
                                    
                                    <option <?=$select?> value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tipe Produksi</label>
                            <select required  name="areaType" id="areaType" class="form-control areaType">
                            <?php
                            $query = mysqli_query($link, "SELECT * FROM production_type")or die(mysqli_error($ink));
                            if(mysqli_num_rows($query)>0){
                                while($data = mysqli_fetch_assoc($query)){
                                    $select = ($data['id_type'] == $sql['id_prod_type'])?"selected":"";
                                    ?>
                                    
                                    <option <?=$select?> value="<?=$data['id_type']?>"><?=$data['name']?></option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Line</label>
                            <select required  name="areaLine" id="areaLine" class="form-control areaLine">
                            <?php
                                $query = mysqli_query($link, "SELECT * FROM view_production_line WHERE stats_model = 'active'")or die(mysqli_error($ink));
                                if(mysqli_num_rows($query)>0){
                                    while($data = mysqli_fetch_assoc($query)){
                                        $select = ($data['id'] == $sql['id_line'])?"selected":"";
                                        ?>
                                        <option <?=$select?> value="<?=$data['id']?>"><?=$data['nama_line']?> - <?=$data['alias_model']?></option>
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
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <input type="submit" class="btn btn-info btn-round" name="edit" id="edit" value="save">
            </div>
        </form>
        <?php
    }else if(isset($_GET['editpos'])){
        $query = mysqli_query($link, "SELECT * FROM view_production_employee WHERE npk = '$_GET[editpos]'")or die (mysqli_error($link));
        $sql = mysqli_fetch_assoc($query);
        ?>
        <form action="" id="form-modalEdit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="modal-title" id="myModalLabel">Edit Area Produksi</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group-sm">
                            <label for="">NPK</label>
                            <input type="text" readonly name="npkMP" id="npkMP" class="form-control npkMP" value="<?=$sql['npk']?>">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group-sm">
                            <label for="">Nama Man Power</label>
                            <input type="text" readonly name="namaMP" id="namaMP" class="form-control namaMP" value="<?=$sql['nama']?>">
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12">
                        <div class="form-group-sm">
                            <label for="">Group</label>
                            <select required readonly name="groupMP" id="groupMP" class="form-control groupMP">
                            <?php
                            $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($q_group)>0){
                                while($data = mysqli_fetch_assoc($q_group)){
                                    $select = ($data['id'] == $sql['id_groupfrm'])?"selected":"";
                                    ?>
                                    <option <?=$select?> value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                    <div class="col-md-12">
                        <div class="form-group-sm">
                            <label for="">Team</label>
                            <select required readonly name="teamMP" id="teamMP" class="form-control teamMP">
                            <?php
                            $query = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'pos'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($query)>0){
                                while($data = mysqli_fetch_assoc($query)){
                                    $select = ($data['id'] == $sql['id_pos_leader'])?"selected":"";
                                    ?>
                                    <option <?=$select?> value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                    <div class="col-md-12">
                        <div class="form-group-sm">
                            <label for="">Production Area</label>
                            <select required readonly name="areaMP" id="areaMP" class="form-control areaMP">
                            <?php
                            $query = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_group = '$sql[id_groupfrm]'")or die(mysqli_error($ink));
                            if(mysqli_num_rows($query)>0){
                                while($data = mysqli_fetch_assoc($query)){
                                    $select = ($data['id'] == $sql['id_production_area'])?"selected":"";
                                    ?>
                                    <option <?=$select?> value="<?=$data['id']?>"><?=$data['prod_name']?></option>
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
                    <div class="col-md-12">
                        <div class="form-group-sm">
                            <label for="">Nama Pos</label>
                            <input type="text"  name="posMP" id="posMP" class="form-control posMP" value="<?=$sql['production_pos']?>">
                            <input type="text"  name="idPosMP" id="idPosMP" class="form-control idPosMP" value="<?=$sql['id_production_pos']?>">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <input type="submit" class="btn btn-info btn-round" name="edit" id="edit" value="save">
            </div>
        </form>
        <?php
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
<script>
    $('.btn-ubah').click(function(){
        $(this).addClass('d-none');
        $('.btn-cancel').removeClass('d-none');
        $('.form-gambar').removeClass('d-none');
        $('.img-raised').addClass('d-none');
        $('.control-edit').val('2');
        $('#upload_gambar').attr('required','true');
    })
    $('.btn-cancel').click(function(){
        $(this).addClass('d-none');
        $('.btn-ubah').removeClass('d-none');
        $('.form-gambar').addClass('d-none');
        $('.img-raised').removeClass('d-none');
        $('#upload_gambar').removeAttr('required');
        $('.control-edit').val('1');
    })
    $('#form-modalEdit').submit(function(e){
        e.preventDefault();
        var trigger_ubah_gambar = $('#control-edit').val();
        // if(trigger_ubah_gambar == '2'){
            // console.log(trigger_ubah_gambar)
            var form = $(this)[0];
            var data = new FormData(form);
            // console.log(form)
            $.ajax({
                url: 'edit.php',
                type: 'post',
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    
                    $('#dataModal').modal('hide')

                    $('#dataModal').on('hidden.bs.modal', function(){
                        $('.data-model').load("../ajax/model.php?tab=model");
                        
                    });
                    $('#dataModal').on('hidden.bs.modal', function(){
                        
                        $('.data-line').load("../ajax/model.php?tab=line");
                    });
                    $('#dataModal').on('hidden.bs.modal', function(){
                        
                        $('.data-area').load("../ajax/model.php?tab=area");
                    });
                    $('#dataModal').on('hidden.bs.modal', function(){
                        
                        $('.data-pos').load("../ajax/model.php?tab=pos");
                    });
                }
            });
        // }else{
        //     $('#dataModal').modal('hide'); 
        // }
    })
</script>
<script>
    $(document).ready(function(){
        $('#areaMP').click(function(){
            var group = $('#groupMP').val();
            var shift = $('#groupMP').val();
            var group = $('#groupMP').val();
            $('#posLine').load('filter_data.php?posLine='+posLine+'&data='+data);
        });
        
        
    })
</script>

