<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_GET['id']) && $_GET['id'] == 'model'){
        ?>
        <div id="model" >
            <!-- <div class="collapse show" id="tambah"> -->
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
                                                        <span class="btn btn-sm  btn-round btn-rose btn-file ">
                                                        <span class="fileinput-new ">Select File</span>
                                                        <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="upload_img" required accept="image/png"/>
                                                        </span>
                                                        <p for="" class="label category">pastikan gambar berformat PNG dengan background transparan</p>
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
            <!-- </div> -->
            <div class="data-model">
                
            </div>
        </div>
        <?php
    }else if(isset($_GET['id']) && $_GET['id'] == 'line'){
        ?>
        <div id="line">
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
        <?php
    }else if(isset($_GET['id']) && $_GET['id'] == 'area'){
        ?>
        <div id="area" >
            <h6>TAMBAH DATA </h6>
                <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                    <div class="card-body  mt-2">
                        <form  action="" id="add-area" class="form-data">
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <label for="">Division</label>
                                    <div class="form-group-sm" >
                                        <select required id="data_division" name="data_division" class="form-control data_division">
                                            <option value="">Pilih Division</option>
                                            <?php
                                            $q_div = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'division'")or die(mysqli_error($ink));
                                            if(mysqli_num_rows($q_div)>0){
                                                while($data = mysqli_fetch_assoc($q_div)){
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
                                <div class="col-md-4 px-1">
                                    <label for="">Department</label>
                                    <div class="form-group-sm" >
                                        <select required id="data_deptAccount" name="data_deptAccount" class="form-control data_deptAccount">
                                            <option value="">Pilih Department</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-4 pl-1">
                                    <label for="">Section</label>
                                    <div class="form-group-sm" >
                                        <select required id="data_section" name="data_section" class="form-control data_section">
                                            <option value="">Pilih Section</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <label for="">Group</label>
                                    <div class="form-group-sm" >
                                        <select required id="data_group" name="data_group" class="form-control data_group">
                                            <option value="">Pilih Group</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-4 px-1">
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
                                <div class="col-md-4 pl-1">
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
                                <div class="col-md-4 pr-1">
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
                                <div class="col-md-8 pl-1">
                                    <label for="">Nama Area</label>
                                    <div class="form-group-sm" style="background:rgba(255, 255, 255, 0.3)">
                                        <input required type="text" class="form-control data_area" name="data_area" id="data_area" placeholder="nama area produksi" autofocus/>
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
        <?php
    }else if(isset($_GET['id']) && $_GET['id'] == 'pos'){
        ?>
        <div  id="pos" >
            <h6>TAMBAH DATA</h6>
            
            <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form action="upload.php" id="add-model" class="form-data" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Model Kendaraan</label>
                                <select required name="posModel" id="posModel" name="posModel" class="form-control posModel">
                                
                                        <option value="">Pilih Model</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Line Produksi</label>
                                <div class="form-group-sm">
                                    <select required name="posLine" id="posLine" name="posLine" class="form-control posLine">
                                    
                                        <option value="">Pilih Line Produksi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Group Foreman</label>
                                <div class="form-group-sm" >
                                    <select required id="posGroup" name="posGroup" class="form-control posGroup">
                                            <option value="">Pilih Group Foreman</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Tipe Produksi</label>
                                <div class="form-group-sm">
                                    <select required name="posType" id="posType" class="form-control posType">
                                    <option value="">Pilih Tipe Produksi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Shift</label>
                                <div class="form-group-sm" >
                                    <select required id="posShift" name="posShift" class="form-control posShift">
                                    <option value="">Pilih Shift Produksi</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Area Produksi</label>
                                <div class="form-group-sm">
                                    <select required name="posAreaProd" id="posAreaProd" class="form-control posAreaProd">
                                    <option value="">Pilih Area Produksi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                            <label for="">Input NPK</label>
                                <div class="form-group">
                                    <textarea class="form-control "  name="" id="text_input" cols="30" rows="10"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" id="upload_npk" class="btn btn-sm btn-primary pull-right">Upload</button>
                                    </div>
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
        <?php
    }
}
?>



<!--  -->
<script src="<?=base_url('assets/js/crud.js')?>"></script>

<script>
        $(document).ready(function(){
            $('.loadAreaProd').click(function(e){
                e.preventDefault();
                var data = $('#posAreaProd').val();
                var idGroup = $('#posGroup').val();
                var idShift = $('#posShift').val();
                var link = $(this).attr('href');
                if(data === '' ){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Area Produksi Kosong',
                        text: 'Pastikan Input Area Produksi Diisi',
                    });
                }else{
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

                }
        
    
            });
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
                var data = $('#posLine').val();
                $.ajax({
                    url: 'filter_data.php',	
                    method: 'GET',
                    data:{posGroup:"",data:data},		
                    success:function(data){
                        $('#posGroup').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    }
                })
            }
            function get_Type(){
                var data = $('#posGroup').val();
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
            get_pos()
            $('#posModel').on('change', function(){
                // var data = $(this).val();
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
            
            $('#posShift').change(function(){
                get_area()
            });
           
        })
    </script>
<script>
    // $(document).ready(function(){
        if($('.data-model')[0]){
            loadAjax("data-model","kelas","../ajax/model.php?tab=model");
        }else if($('.data-line')[0]){
            loadAjax("data-line","kelas","../ajax/model.php?tab=line");
        }else if($('.data-area')[0]){
            loadAjax("data-area","kelas","../ajax/model.php?tab=area");

        }else if($('.data-pos')[0]){
            loadAjax("data-pos","kelas","../ajax/model.php?tab=pos");

        }
        
        
    // })
    // $(document).ready(function(){
    //     $('.navigasi_data').click(function(){
    //         loadAjax("data-model","kelas","../ajax/model.php?tab=model");
    //         loadAjax("data-line","kelas","../ajax/model.php?tab=line");
    //         loadAjax("data-area","kelas","../ajax/model.php?tab=area");
    //         loadAjax("data-pos","kelas","../ajax/model.php?tab=pos");
    //         var id = $(this).attr('data-id');
    //         // console.log(id);
    //         // $('.data_deptAcc').load('get_data.php?dept_account=');
    //         // $('.data_group').load('get_data.php?group=');
    //         $('.modelData').load('get_data.php?model=');
    //         $('.typeData').load('get_data.php?type=');
    //         $('.lineData').load('get_data.php?line=');
    //     })
    // })

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
        $('.data_division').on('change', function(){
            filterDept()
            filterSect()
            filterGroup()
        })
        $('.data_deptAccount').on('change', function(){
            filterSect()
            filterGroup()
        })
        $('.data_section').on('change', function(){
            filterGroup()
        })
        
        function filterDept(){
            var data = $('.data_division').val();
            var area = "dept"
            // console.log("ok");
            $.ajax({
                url: '../ajax/get_area.php',
                type: 'GET',
                data: {data:data, area:area},
                success: function(data) {
                    $('.data_deptAccount').html(data)
                }
            });
        }
        
        function filterSect(){
            var data = $('.data_deptAccount').val();
            var area = "section"
            // console.log("ok");
            $.ajax({
                url: '../ajax/get_area.php',
                type: 'GET',
                data: {data:data, area:area},
                success: function(data) {
                    $('.data_section').html(data)
                }
            });
        }
        function filterGroup(){
            var data = $('.data_section').val();
            var area = "group"
            // console.log("ok");
            $.ajax({
                url: '../ajax/get_area.php',
                type: 'GET',
                data: {data:data, area:area},
                success: function(data) {
                    $('.data_group').html(data)
                }
            });
        }
        
    })
</script>
<!--  -->
