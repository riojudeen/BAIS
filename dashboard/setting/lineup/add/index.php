<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../../header.php");
    require_once('../../organization/card.php');
    $listMenu = array(
        "car model" => "model",
        "production type" => "type",
        "production line" => "line",
    );
    // $q_data = mysqli_query($link, "SELECT * FROM production_model WHERE id_model = '2' ")or die(mysqli_error($link));
    // $s_data = mysqli_fetch_assoc($q_data);
    // $dataLama = $s_data['alias'].".png";
    // $alias = "tes";
    // $temp = '../../../../assets/img/unit_model/';
    // $namaBaru = $temp.$alias.".png";
    //         $namaLama = $temp.$dataLama;
    //         echo $namaLama;
    //         echo "<br>".$namaBaru;
    //         rename("$namaLama","$namaBaru");
    ?>
    <div class="row">
        <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notice">
                <div class="modal-content modalEdit">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="modalLoadDataArea" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
            <div class="modal-dialog modal-xl " role="document">
                <div class="modal-content modalLoadDataArea">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header">
                <div class="row">
                    <h5 class="title pull-left col-md-6" id="mainpage"><i class="fas fa-network-wired "></i> Data Register Organization</h5>
                    <div class="col-md-6 text-right">
                        <a href="../index.php" class="btn btn-sm">Kembali</a>
                    </div>
                </div>
                
            </div>
            <!-- <div class="nav-tabs-navigation "> -->
            <div class="card-body">
                
            
                <div class="row">
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker">
                            <h6>Navigasi</h6>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <!--  -->
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-info active navigasi_data"  data-toggle="tab" data-id="model" href="#model" role="tab" aria-expanded="true">Model Kendaraan</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="line" href="#line" role="tab" aria-expanded="true">Line Produksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="area" href="#area" role="tab" aria-expanded="true">Area Produksi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info  navigasi_data"  data-toggle="tab" data-id="pos" href="#pos" role="tab" aria-expanded="true">Pos Produksi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <?php
                        ?>
                        <div id="my-tab-content" class="tab-content ">
                            <div class="tab-pane active " id="model" role="tabpanel" aria-expanded="true">
                                <div class="collapse show" id="tambah">
                                    <div class="row ">
                                        <div class="col-md-12 ">
                                            <h6>TAMBAH DATA</h6>
                                            <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                                                <div class="card-body  mt-2">
                                                    <form action="upload.php" id="add-model" class="form-data" method="post" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="">Model Name</label>
                                                                <div class="form-group-sm" style="background:rgba(255, 255, 255, 0.3)">
                                                                    <input required type="text" class="form-control data_model" name="data_model" id="data_model" placeholder="input model kendaraan" autofocus/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">Alias</label>
                                                                <div class="form-group-sm" >
                                                                    <input required type="text" name="alias" class="form-control data_alias" placeholder="input nama alias" id="data_alias"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">Status</label>
                                                                <div class="form-group-sm">
                                                                    <select required name="stats" id="data_status" class="form-control data_status">
                                                                        <option value="active">Aktif</option>
                                                                        <option value="discontinued">Discontinued</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group border rounded py-auto text-center mt-4 mb-0 border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
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
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for=""></label>
                                                                <div class="form-group-sm" >
                                                                    
                                                                    <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                                                                    <button type="submit" id="add_model" class="btn btn-sm btn-primary pull-right add_model" name="add">
                                                                    <i class="fas fa-plus"></i> add
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="data-model">
                                    
                                </div>
                            </div>
                            <div class="tab-pane " id="line" role="tabpanel" aria-expanded="true">
                                <h6>TAMBAH DATA</h6>
                                <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                                    <div class="card-body  mt-2">
                                        <form  action="" id="add-line" class="form-data">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Nama Line</label>
                                                    <div class="form-group-sm" style="background:rgba(255, 255, 255, 0.3)">
                                                        <input required type="text" class="form-control data_line" name="data_line" id="data_line" placeholder="nama line produksi" autofocus/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Department Account</label>
                                                    <div class="form-group-sm" >
                                                        <select required id="data_deptAcc" name="data_deptAcc" class="form-control data_deptAcc">
                                                            <?php
                                                            $q_dept = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc'")or die(mysqli_error($ink));
                                                            if(mysqli_num_rows($q_dept)>0){
                                                                while($data = mysqli_fetch_assoc($q_dept)){
                                                                    ?>
                                                                    <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                                                <div class="col-md-4">
                                                    <label for="">Model</label>
                                                    <div class="form-group-sm">
                                                        <select required name="modelData" id="modelData" name="modelData" class="form-control modelData">
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
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for=""></label>
                                                    <div class="form-group-sm" >
                                                        <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                                                        <button type="submit" id="add_model" class="btn btn-sm btn-primary pull-right add_line" name="add">
                                                        <i class="fas fa-plus"></i> add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="data-line">

                                </div> 
                            </div>
                            <div class="tab-pane " id="area" role="tabpanel" aria-expanded="true">
                            <h6>TAMBAH DATA</h6>
                                <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                                    <div class="card-body  mt-2">
                                        <form  action="" id="add-area" class="form-data">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="">Nama Area</label>
                                                    <div class="form-group-sm" style="background:rgba(255, 255, 255, 0.3)">
                                                        <input required type="text" class="form-control data_area" name="data_area" id="data_area" placeholder="nama area produksi" autofocus/>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="">Group</label>
                                                    <div class="form-group-sm" >
                                                        <select required id="data_group" name="data_group" class="form-control data_group">
                                                            <?php
                                                            $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($ink));
                                                            if(mysqli_num_rows($q_group)>0){
                                                                while($data = mysqli_fetch_assoc($q_group)){
                                                                    ?>
                                                                    <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
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
                                                <div class="col-md-4">
                                                    <label for="">Shift</label>
                                                    <div class="form-group-sm" >
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
                                                <div class="col-md-4">
                                                    <label for="">Type Produksi</label>
                                                    <div class="form-group-sm">
                                                        <select required name="typeData" id="typeData" name="typeData" class="form-control typeData">
                                                        <?php
                                                            $q_type = mysqli_query($link, "SELECT * FROM production_type")or die(mysqli_error($ink));
                                                            if(mysqli_num_rows($q_type)>0){
                                                                while($data = mysqli_fetch_assoc($q_type)){
                                                                    ?>
                                                                    <option value="<?=$data['id_type']?>"><?=$data['name']?></option>
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
                                                <div class="col-md-4">
                                                    <label for="">Line</label>
                                                    <div class="form-group-sm">
                                                        <select required name="lineData" id="lineData" name="lineData" class="form-control lineData">
                                                        <?php
                                                            $q_line = mysqli_query($link, "SELECT * FROM production_line")or die(mysqli_error($ink));
                                                            if(mysqli_num_rows($q_line)>0){
                                                                while($data = mysqli_fetch_assoc($q_line)){
                                                                    ?>
                                                                    <option value="<?=$data['id_line']?>"><?=$data['nama']?></option>
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
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for=""></label>
                                                    <div class="form-group-sm" >
                                                        <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                                                        <button type="submit" id="add_model" class="btn btn-sm btn-primary pull-right add_line" name="add">
                                                        <i class="fas fa-plus"></i> add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="data-area">

                                </div>
                            </div>
                            <div class="tab-pane " id="pos" role="tabpanel" aria-expanded="true">
                                <h6>TAMBAH DATA</h6>
                                
                                <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                                    <div class="card-body  mt-2">
                                        <form action="upload.php" id="add-model" class="form-data" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Model Kendaraan</label>
                                                    <select required name="posModel" id="posModel" name="posModel" class="form-control posModel">
                                                    <?php
                                                        // 
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Line Produksi</label>
                                                    <div class="form-group-sm">
                                                        <select required name="posLine" id="posLine" name="posLine" class="form-control posLine">
                                                            <option value="">Pilih Data</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Group Foreman</label>
                                                    <div class="form-group-sm" >
                                                        <select required id="posGroup" name="posGroup" class="form-control posGroup">
                                                            <option value="">Pilih Data</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Tipe Produksi</label>
                                                    <div class="form-group-sm">
                                                        <select required name="posType" id="posType" class="form-control posType">
                                                            <option value="">Pilih Data</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Shift</label>
                                                    <div class="form-group-sm" >
                                                        <select required id="posShift" name="posShift" class="form-control posShift">
                                                            <option value="">Pilih Data</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Area Produksi</label>
                                                    <div class="form-group-sm">
                                                        <select required name="posAreaProd" id="posAreaProd" class="form-control posAreaProd">
                                                            <option value="">Pilih Data</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group border rounded py-auto text-center mt-4 mb-0" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for=""></label>
                                                    <div class="form-group-sm" >
                                                        <a href="import.php" class="btn btn-sm btn-default loadAreaProd">Load Data</a>
                                                        
                                                        <button type="button" class="btn btn-sm btn-default ">Upload File</button>
                                                        <a href=""class="btn btn-sm btn-danger btn-link">download Format</a>
                                                        <button type="reset" class="btn btn-sm btn-warning pull-right">Reset</button>
                                                        <button type="submit" id="add_model" class="btn btn-sm btn-primary pull-right add_model" name="add">
                                                        <i class="fas fa-plus"></i> add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="data-pos">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="lihat"></div>
    <?php
    include_once("../../../footer.php");
    ?>
    <script src="<?=base_url('assets/js/crud.js')?>"></script>
    <script>
        $(document).ready(function(){
            loadAjax("data-model","kelas","../ajax/model.php?tab=model");
            loadAjax("data-line","kelas","../ajax/model.php?tab=line");
            loadAjax("data-area","kelas","../ajax/model.php?tab=area");
            loadAjax("data-pos","kelas","../ajax/model.php?tab=pos");
        })
        $(document).ready(function(){
            $('.navigasi_data').click(function(){
                loadAjax("data-model","kelas","../ajax/model.php?tab=model");
                loadAjax("data-line","kelas","../ajax/model.php?tab=line");
                loadAjax("data-area","kelas","../ajax/model.php?tab=area");
                loadAjax("data-pos","kelas","../ajax/model.php?tab=pos");
                var id = $(this).attr('data-id');
                // console.log(id);
                $('.data_deptAcc').load('get_data.php?dept_account=');
                $('.modelData').load('get_data.php?model=');
                $('.typeData').load('get_data.php?type=');
                $('.lineData').load('get_data.php?line=');
                $('.data_group').load('get_data.php?group=');
            })
        })

        $(document).ready(function(){
            $('#add-model').submit(function(e){
                e.preventDefault();
                
                var form = $(this)[0];
                var data = new FormData(form);
                $.ajax({
                    url: 'upload.php',
                    type: 'post',
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        sendForm('add-model','data-model','kelas','../ajax/model.php','post','../ajax/model.php?tab=model')
                    }
                });
            })
        })
       
        $(document).ready(function(){
            $('#add-line').submit(function(e){
                e.preventDefault();
                sendForm('add-line','data-line','kelas','../ajax/model.php','get','../ajax/model.php?tab=line')
            })
        })
        $(document).ready(function(){
            $('#add-area').submit(function(e){
                e.preventDefault();
                sendForm('add-area','data-area','kelas','../ajax/model.php','get','../ajax/model.php?tab=area')
            })
        })
        
    </script>
    <script>
        $(document).ready(function(){
            function get_pos(){
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posModel:""},		
                    success:function(data){
                        $('#posModel').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            function get_Line(){
                var id = $('#posModel').val()
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posLine:"",data:id},		
                    success:function(data){
                        $('#posLine').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            function get_Group(){
                var posLine = $('#posLine').val()
                var data = $('#posModel').val();
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posLine:"",data:data},		
                    success:function(data){
                        $('#posGroup').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            function get_Type(){

                var data = $('#posGroup').val();
                var posType = $('#posType').val()
                // $('#posType').load('filter_data.php?posType='+posType+'&data='+data);
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posType:"",data:data},	
                    success:function(data){
                        $('#posType').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            function get_Shift(){

                var data = $('#posType').val();
                var posType = $('#posType').val()
                // $('#posType').load('filter_data.php?posType='+posType+'&data='+data);
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posShift:"",data:data},	
                    success:function(data){
                        $('#posShift').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            get_pos()
            $('#posModel').change(function(){
                var data = $(this).val();
                get_Line()
                get_Group()
                get_Type()
                get_Shift()
                // $('#posLine').load('filter_data.php?posLine=&data='+data);
            });
            // group
            $('#posLine').change(function(){
                get_Group()
                get_Type()
                get_Shift()
            });
            // type
            $('#posGroup').change(function(){
                get_Type()
                get_Shift()
            });
            // shift
            $('#posType').change(function(){
                get_Shift()
            });
            // area produksi
            function get_area(){
                var shift = $('#posShift').val();
                var type = $('#posType').val();
                var group = $('#posGroup').val();
                var line = $('#posLine').val();
                var model = $('#posModel').val();
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posAreaProd:"",shift:shift,type:type,group:group,line:line,model:model},
                    success:function(data){
                        $('#posAreaProd').html(data);
                    }
                })
            }
            $('#posShift').change(function(){
                var shift = $('#posShift').val();
                var type = $('#posType').val();
                var group = $('#posGroup').val();
                var line = $('#posLine').val();
                var model = $('#posModel').val();
                $('#posAreaProd').load('filter_data.php?posAreaProd=&shift='+shift+'&type='+type+'&group='+group+'&line='+line+'&model='+model);
            });
            $('#posAreaProd').click(function(){
                var posArea = $(this).val()
                var shift = $('#posShift').val();
                var type = $('#posType').val();
                var group = $('#posGroup').val();
                var line = $('#posLine').val();
                var model = $('#posModel').val();
                $('#posAreaProd').load('filter_data.php?posAreaProd='+posArea+'&shift='+shift+'&type='+type+'&group='+group+'&line='+line+'&model='+model);
            });
            
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.loadAreaProd').click(function(e){
                e.preventDefault();
                var data = $('#posAreaProd').val();
                var idGroup = $('#posGroup').val();
                var link = $(this).attr('href');
                console.log(data)
                
                console.log(idGroup);
                $.ajax({
                    url: 'import.php',
                    type: 'GET',
                    data: {loadData:data,idGroup:idGroup},
                    success: function(resp){
                        $('.modalLoadDataArea').load('import.php?loadData='+data+'&idGroup='+idGroup, function(){
                            $('#modalLoadDataArea').modal('show'); 
                        });
                    }
                })
        
    
            });
        })
    </script>
    <?php
    include_once("../../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

