<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Information Portal";
    include_once("../header.php");
?>
<!-- halaman utama -->

<div class="modal fade" id="modalInfo" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content mx-1 px-1">
            <div class="modal-header justify-content-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="card-title pull-left">Create Information</h5>
            </div>
            <div class="modal-body px-2">
                <div class="row ">
                    <div class="col-md-12">
                        <form method="POST" id="form_info" enctype="multipart/form-data" action="proses/prosesBlast">
                            <label>Category</label>
                            <div class="form-group">
                                <select name="cat_info" class="form-control" id="cat_info">
                                    <option value="">Pilih Category</option>
                                    <option value="int">Internal Info</option>
                                    <option value="ext">External Info</option>
                                    <option value="at">Attendance Info</option>
                                    <option value="ot">Overtime Info</option>
                                    <option value="oth">Other Info</option>
                                </select>
                            </div>
                            <label>Insert Gambar (optional)</label>
                            <div class="form-group border rounded py-auto text-center">
                                <div class="fileinput fileinput-new text-center " data-provides="fileinput" >
                                    <div class="fileinput-new thumbnail">
                                        
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail mt-4   mx-0 shadow-none" style="width:500px;min-width:500px">
                                        <input type="text"  class="form-control mx-0">
                                    </div>
                                    <div>
                                        <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                        <span class="fileinput-new ">Select Image</span>
                                        <span class="fileinput-exists">Change</span>
                                            <input type="file"  name="file_import" id="file_import" />
                                        </span>
                                        <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    </div>
                                    <p class="category">pastikan gambar berformat .JPG / .JPEG</p>
                                </div>
                            </div>
                            <label>Judul</label>
                            <div class="form-group">
                                <input type="text" id="title_info" name="title_info" class="form-control title text-uppercase" placeholder="">
                            </div>
                            <label class="text-left">Detail Informasi</label>
                            <div class="form-group">
                                <textarea type="text" class="form-control ckeditor" name="desc_info" id="desc_info" placeholder="" maxlength="500" rows="10"></textarea>
                            </div>
                            <button type="reset" class="btn btn-sm btn-warning pull-right">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary pull-right upload-info">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">

	<div class="col-md-12 ">
        
		<div class="card">
			<div class="card-header">
				<h5 class="title pull-left">Info Post</h5>
                <div class="box pull-right">
                    <button class="btn btn-sm btn-info" data-toggle="modal" href="#modalInfo" role="button" aria-expanded="false" aria-controls="modalInfo">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Create New
                    </button>
                </div>
			</div>
            <hr>
			<div class="card-body table-hover">
                
            </div>
            
		</div>
        
	</div>
</div>
<div class="response"></div>

<!-- halaman utama end -->
<?php
    include_once("../footer.php"); 
    ?>
    <script>
        $(document).ready(function(){
            $(document).on('click', '#allcek', function() {
                if(this.checked){
                    $('.cek').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.cek').each(function() {
                        this.checked = false;
                    })
                }

            });

            $(document).on('click', '.cek', function() {
                if($('.cek:checked').length == $('.cek').length){
                    $('#allcek').prop('checked', true)
                } else {
                    $('#allcek').prop('checked', false)
                }
            })
        })
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.remove', function(a){
                a.preventDefault();
                var url = $(this).attr('href');
                var data = 'delete_info';
                // console.log(url)
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Informasi Ini Akan Dihapus Secara Permanent",
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: '#CB4335',
                    cancelButtonColor: '#B2BABB',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {delete_info:data},
                            success: function (msg) {
                                $('.response').html(msg)
                                load_data()
                            },
                            error: function () {
                                alert("Data Gagal dihapus");
                                load_data()
                            }
                        });  
                    }
                })
            })
            function load_data(){
                data = '1'
                $.ajax({
                    type: 'GET',
                    url: "information.php",
                    data: data,
                    success: function (msg) {
                        $('.card-body').html(msg)
                    },
                });
            }
            load_data()
            $('.upload-info').on('click', function(e){
                e.preventDefault();
                upload_data();
                
            })
            function upload_data(){
                const file_import = $('#file_import').prop('files')[0];
                const desc = CKEDITOR.instances.desc_info.getData()
                const category = $('#cat_info').val();
                const title = $('#title_info').val();
                if(category == '' || title == '' || desc == ''){
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'Pastikan formulir diisi semua',
                        timer: 2000,
                        
                        icon: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                }else{
                    let formData = new FormData();
                    formData.append('file_import', file_import);
                    formData.append('cat_info', $('#cat_info').val());
                    formData.append('title_info', $('#title_info').val());
                    formData.append('desc_info', desc);
                    console.log(desc);
        
                    $.ajax({
                        type: 'POST',
                        url: "proses/prosesInfo.php",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (msg) {
                            $('.response').html(msg)
                            document.getElementById("form_info").reset();
                            $('.ckeditor').val('');
                            load_data()
                        },
                        error: function () {
                            alert("Data Gagal Diupload");
                        }
                    });

                }
                
            }
        })
    </script>
    <script>
    //untuk crud masal update department
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'proses/prosesBlast.php';
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Semua data yang dicheck / centang akan dihapus permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                document.proses.action = getLink;
                document.proses.submit();
            }
        })
        
    });
    
    </script>
    
    
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

