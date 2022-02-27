<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 

if(isset($_GET['id'])){
    $collapse1 = ($_GET['id'] == "tambah_one")?"show":"";
    $collapse2 = ($_GET['id'] == "tambah_masal")?"show":"";
}
    
?>

<div class="collapse <?=$collapse1?>" id="tambah">
    <div class="row">
        <div class="col-md-12">
            <h6>TAMBAH DATA</h6>
            
            <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" action="ajax/proses.php" id="form-add" class="form-data">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Group</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-group" name="data-group[]" placeholder="select masal">
                                                <option value="" disabled>Pilih Group</option>
                                            </select>   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Pos - Leader</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-pos" name="data-pos[]" placeholder="select masal">
                                                <option disabled>Pilih Pos Leader</option>
                                            </select>   
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Sub Pos</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="text" class="form-control bg-transparent data-sub_pos" name="data-sub_pos[]" placeholder="Sub Pos" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label for="">NPK Karyawan</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="number" class="form-control bg-transparent data-npk" name="data-npk" id="data-npk" placeholder="input npk" autofocus/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nama Karyawan </label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-nama" placeholder="Nama Karyawan" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="">Jabatan</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-jabatan" placeholder="jabatan" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-stats" placeholder="Status Karyawan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <a  class="btn btn-sm btn-danger  btn-link closecol" data-toggle="collapse" href="#tambah" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                        <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                        <button type="button" id="save" disabled class="btn btn-sm btn-primary" name="add">Tambah</button>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="collapse <?=$collapse2?>" id="masal">
    <div class="row">
        <div class="col-md-12">
            <h6>TAMBAH DATA</h6>
            
            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                <div class="card-body  mt-2">
                
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        <div class="row">
                            
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Group</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-group" placeholder="select masal">
                                                <option disabled>Pilih Group</option>
                                                
                                            </select>   
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Pos - Leader</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <select type="text" class="form-control bg-transparent data-pos" placeholder="select masal">
                                                <option disabled>Pilih Pos Leader</option>
                                            </select>   
                                        </div>
                                    </div>
                                    
                                </div>
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
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <a  class="btn btn-sm btn-danger  btn-link closecol" data-toggle="collapse" href="#masal" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                        <button type="button" class="btn btn-sm btn-primary ">Load Data</button>
                        <button type="button" class="btn btn-sm btn-link btn-info pull-right"><i class="fas fa-file-excel"></i> download format</button>
                        <hr>
                        <!-- load data -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th>#</th>
                                            <th>NPK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th class="text-right">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkall" type="checkbox" id="check-" >
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>44131</td>
                                                <td>Rio Setiawan Judin</td>
                                                <td>TM</td>
                                                <td>P</td>
                                                <td class="text-right">
                                                    <div class="form-check text-right">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input check- checkone" name="[]" value="" type="checkbox" data="">
                                                        <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>   
    </div>
</div>
<div class="viewJson"></div>
<script>
    // function catch data
    function mp_data(){
        var data = $('.data-group').val();
        $.ajax({
            url: 'ajax/get_manpower.php',
            method: 'get',
            data: {data:data},		
            success:function(data){		
                $('.view-group').html(data);
            } 
        })
    }
    
    $(document).ready(function(){
        $('.closecol').click(function(){
            $('.tambah').addClass('btn-link');
            $('#data-mp').removeClass('d-none');
            $.ajax({
                url: 'ajax/get_manpower.php?data=0',
                method: 'get',
                success:function(data){		
                    $('.view-group').html(data);
                }
            })
        });
        
        var id_sect = $('.sect-active').attr('id');
        $.ajax({
            url: 'ajax/get_group.php',
            method: 'get',
            data: {data:id_sect},
            success:function(data){
                $('.data-group').html(data);
            }   
        });
        var data = $('.data-group').val();
        $.ajax({
            url: 'ajax/get_pos.php',
            method: 'get',
            data: {data:data},		
            success:function(data){
                $('.data-pos').html(data);
            }   
        })
        $('.data-group').change(function(){
            mp_data();
            $.ajax({
                url: 'ajax/get_pos.php',
                method: 'get',
                data: {data:data},		
                success:function(data){		
                    $('.data-pos').html(data);
                }   
            })
        });
        
        $('.data-npk').keyup(function(){
            var data = $(this).val();
            $.ajax({
                url: 'ajax/get_kary.php',
                method: 'get',
                data: {data:data},		
                success:function(data){		
                    var obj = $.parseJSON(data);
                    var total = obj.msg[0].total;
                    var msg = obj.msg[0].msg;
                    if(total > 0){
                        var nama = obj.data[0].nama;
                        var status = obj.data[0].status;
                        var jabatan = obj.data[0].jabatan;
                        $('#save').removeAttr('disabled');
                    }else{
                        var nama = obj.msg[0].msg;
                        var status = obj.msg[0].msg;
                        var jabatan = obj.msg[0].msg;
                    }
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                }
            })
        });
        $("#save").click(function(){
            var data = $('.form-add').serialize();
            var sub_pos = $('.data-sub_pos').val();
            var pos = $('.data-pos').val();
            var group = $('.data-group').val();
            var sect = $('.id-section').val();
            var npk = $('.data-npk').val();
            // validasi
            if(pos != "" || group != "" || npk != "" ){
                $.ajax({
                    type: 'POST',
                    url: "ajax/form_action.php",
                    data: {sub_pos: sub_pos, pos:pos, group:group, sect:sect, npk:npk},
                    success: function(data){
                        $('.view-group').load("ajax/get_manpower.php?data="+group);
                        $('.mp_arrangement').html(data);
                        console.log(data);
                    }, error: function(response){
                        console.log(response.responseText);
                    }
                });
            }
        });
    })
</script>