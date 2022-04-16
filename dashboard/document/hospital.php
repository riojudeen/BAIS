<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$data_cat = $_GET['data'];
if($data_cat == "BL"){
    $halaman = "Blacklist Hospital";
}else{
    $halaman = "Hospital Recomendation";
}
if(isset($_SESSION['user'])){

    include("../header.php");
    
    if($level >= 5){
        ?>
        <div class="modal fade" id="modal_upload_ot" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <h5 class="modal-title text-left col-md-6" id="exampleModalLabel">Upload Data</h5>
                            <div class="col-md-6">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form_upload" action="proses-ot-upload.php" enctype="multipart/form-data">
                            <div class="row">
                                <?php
                                $selectBL = ($data_cat == 'BL')?"selected":"";
                                $selectRH = ($data_cat == 'RH')?"selected":"";
                                ?>
                                <div class="col-md-4 pb-0 d-none">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Dokumen Upload</label>
                                            <div class="form-group">
                                                <select name="hosp_type_upload" readonly id="att_type_upload" class="form-control no-border"  required>
                                                    <option <?=$selectBL?> value="BL">BlackList</option>
                                                    <option  <?=$selectRH?> value="RH">Recomendation</option>
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
                                            <input type="file"  name="file_hospital" id="file_hospital"/>
                                        </span>
                                        <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                            <a href="<?=base_url()?>/file/template/Format_upload_hospital.xlsx" type="button" class="btn btn-sm btn-link btn-info"><i class="fas fa-file-excel"></i> download format</a>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="upload_hospital" >Upload</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <h5 class="col-md-6 title">
                            <?=$halaman?>
                        </h5>
                        <div class="col-md-6 text-right">
                            
                            <?php
                            if($level > 5){
                                ?>
                                
                                    <div class="btn mt-0 " data-toggle="modal" data-target="#modal_upload_ot">Update</div>
                                
                                <?php
                            }
                            ?>
                        </div>
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-md-3 text-right ">
                            <div class="mr-2  order-3 ">
                                <div class="input-group bg-transparent">

                                    <input type="text" name="cari" id="cari" class="form-control bg-transparent" placeholder="Cari nama, alamat, dan kota.." value="">
                                    <div class="input-group-append bg-transparent">
                                        <div class="input-group-text bg-transparent">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body mx-0 px-0 ">
                    <div class="row ">
                        <div class="col-md-12 load-hospital">
                            
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                   
                </div>
            </div>
        </div>
    </div>
    <div class="notifikasi_upload"></div>
    <?php
//footer
    
    include_once("../footer.php");
    ?>
    <script>
        
    </script>
    <script>
            $(document).ready(function(){
                loaddata()
                
                function loaddata(page){
                    const data = "data";
                    const cari = $('#cari').val();
                    $.ajax({
                        url : "load-hospital.php?data_cat=<?=$data_cat?>",
                        method: "GET",
                        data: {data:data, cari:cari, page:page},
                        success:function(data){
                            $('.load-hospital').html(data);
                        }

                    })
                }
                $(document).on('click', '.halaman', function(){
                    var page = $(this).attr("id");
                    loaddata(page)
                    // console.log(hal)
                });
                $(document).on('keyup', '#cari', function(){
                    // var cari = $(this).val()
                    loaddata()
                    // console.log(cari);
                });
                $(document).on('click', '#upload_hospital', function(e){
                    e.preventDefault();
                    if($('#att_npk').val() != ''){

                        const file_import = $('#file_hospital').prop('files')[0];
                        // const getLink = 'proses-at-upload.php';
                        let formData = new FormData();
                            formData.append('file_hospital', file_import);
                            formData.append('hosp_type_upload', $('#att_type_upload').val());
                        // console.log(file_import)
                        Swal.fire({
                            title: 'Konfirmasi Pengiriman?',
                            text: "pastikan dokumen pengajuan yang dikirim sudah benar !",
                            icon: false,
                            showCancelButton: true,
                            confirmButtonColor: '#1ABC9C',
                            cancelButtonColor: '#B2BABB',
                            confirmButtonText: 'Kirim!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url:"import/import-hospital.php",
                                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method:"POST",
                                    data:formData,
                                    success:function(data){
                                        $('.notifikasi_upload').html(data);
                                        $('#modal_upload_ot').modal('hide')
                                        loaddata()
                                    }
                                })
                            }
                        })
                    }else{
                        Swal.fire({
                            title: 'Npk Belum Diisi',
                            text: 'pastikan npk karyawan sudah diisi',
                            timer: 2000,
                            
                            icon: 'warning',
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                });
                
            });
        </script>
    <?php
    include_once("../endbody.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
	

?>