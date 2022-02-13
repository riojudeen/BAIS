<?php

require_once("../../../config/config.php"); 
// $year = (isset($_SESSION['tahun']))?  $_SESSION['tahun'] : date('Y');
// echo $year;
if(isset($_POST['go'])){
    $_SESSION['tahun'] = $_POST['year'];
    $year = $_SESSION['tahun'];
}else{
    $year = date('Y');
}
$bulanini = date('m');
$bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
$totalBln = count($bln);

?>
<div class="row">
    <div class="col-md-12">

        <div class="box pull-right ">
            <a href="<?=base_url('/dashboard/wh/holidays')?>/add.php?add=holiday" class=" btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                <span class="btn-label">
                    <i class="nc-icon nc-simple-add"></i> Add Seting
                </span>
                
            </a>
            <a  class="btn btn-sm btn-info " data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="#tambah"> Import Massal</a>
            
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="datapreview" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="holidays/proses.php" method="POST" id="RangeValidation">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title text-left">Data Preview</h5>
                </div>
                <div class="modal-body px-2">
                    
                    <div id='ajax-wait' class="text-center">
                        <img alt='loading...' src='<?=base_url()?>/assets/img/Ellipsis-1s-200px.gif' width='32' height='32' style="display:none"/>
                    </div>
                    <div class="data_load  col-md-12"></div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info btn-link" name="addholidays">Tambah Data</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="collapse show tambah collapse-view" id="tambah">
    <div class="row">
        <div class="col-md-12">
            
            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                <div class="card-body  mt-2">
                
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        
                        <div class="row">
                            <div class="col-sm-12 ">
                                
                                <fieldset>
                                <legend class="text-muted h6">Add Seting</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Upload File Excel</label>
                                        
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
                        <a  class="btn btn-sm btn-danger  btn-link closecol" data-toggle="collapse" href=".collapse-view" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                        <button type="button" class="btn btn-sm btn-primary load-data" data-toggle="modal" data-target="#loaddata">Load Data</button>
                        <a href="<?=base_url('file/template/Format_Hari_Libur.xlsx')?>" class="btn btn-sm btn-link btn-info pull-right"><i class="fas fa-file-excel"></i> download format</a>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-inline">
    <div class="input-group no-border">
        <div class="form-group-sm">
            <select type="date" name="start" id="startdate" class="form-control pl-2" >
                <option Disabled>Pilih Bulan</option>
                <?php
                $i =0;
                foreach($bln AS $namaBln){
                    $i++;
                    $selectBln = ($i == $bulanini)?"selected":"";
                    
                    echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group-sm ">
            <div class="form-control">
                to
            </div>
        </div>
        <div class="form-group-sm">
            <select type="date" name="end"  id="enddate" class="form-control pl-2" >
                <option Disabled>Pilih Bulan</option>
                <?php
                $i =0;
                foreach($bln AS $namaBln){
                    
                    $i++;
                    $selectBln = ($i == $bulanini)?"selected":"";
                    echo "<option $selectBln value=\"$i\">$namaBln</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group-sm ">
            <select  name="year" id="year" class="form-control" >
                <?php
                $thn = mysqli_query($link, "SELECT `date` FROM holidays GROUP BY YEAR(`date`) ASC")or die(mysqli_error($link));
                while($dataThn = mysqli_fetch_assoc($thn)){
                    
                    $tgl = $dataThn['date'];
                    $dataThn_pecah = explode("-", $tgl);
                    $tahun = $dataThn_pecah['0'];
                    $select = ($tahun == $year) ? "selected" : "";
                    echo "<option $select value=\"$tahun\">$tahun</option>";
                }
                ?>
                
            </select>
            
        </div>
    </div>
    <div class="input-group-append">
        <input type="submit" name="go" id="sortyear" class="ml-2 col-lg-1 btn btn-sm btn-round btn-icon btn-link" value="go">  
    </div>
    
</div>
<div class="dataview"></div>
<script>
    $(document).ready(function(e){
        e.preventDefault
        $('.load-data').on('click', function() {
            var file_data = $('#file_export').prop('files')[0];   
            var form_data = new FormData();
            
            form_data.append('file-excel', file_data);
            // alert(form_data);                             
            $.ajax({
                url: 'holidays/ajax/import.php',
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                // encode: 'true',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
                    
                    // var cek = Object.keys(file_data).length
                    // console.log(file_data)
                    if(file_data !== undefined){
                        $('#datapreview').modal('show');
                        $(".data_load").html(resp);
                    }else{
                        Swal.fire('Dokumen Belum dipilih')
                    }
                }
            });
        });
    })
</script>
<script>
    $(document).ready(function(e){
        function get_data(){
            var year = $('#year').val();
            var sd = $('#startdate').val();
            var ed = $('#enddate').val();
            $('.dataview').load("holidays/ajax/index.php?year="+year+"&startdate="+sd+"&enddate="+ed);
        }
        get_data();
        $('#sortyear').click(function(a){
            a.preventDefault();
            get_data();
        })
    })
    
</script>
<script>
    //untuk crud masal update department

    $('.hapus').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
        
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Data Akan Dihapus Permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                // document.proses.method = "get";
                document.proses.action = getLink;
                document.proses.submit()
                
               
            }
        })
        
    });
        
</script>
            