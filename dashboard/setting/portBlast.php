<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Transfer Uang Makan";
    include_once("../header.php");
?>
<!-- halaman utama -->
<div class="collapse" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title pull-left">Create Information</h5>
                    <div class="pull-right">    
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body ">
                    <form method="post" enctype="multipart/form-data" action="proses/prosesBlast">
                        <div class="form-group border rounded py-auto text-center">
                            <hr class="my-0">
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:100px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div>
                                    <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                    <span class="fileinput-new ">Select Image</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <label>Judul</label>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <label class="text-left">Datail Informasi</label>
                        <div class="form-group">
                            <textarea type="text" class="form-control ckeditor" id="ckedtor" placeholder="" maxlength="500" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                    </form>
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
                    <a href="file/FormatUpdate_MP.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                        <i class="nc-icon nc-paper"></i>
                    </a>
                    <button class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Import
                    </button>
                    
                    <a href="proses/export.php?export=mp" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </a>
                </div>
			</div>
            <hr>
            <form action="" name="proses" method="POST">
			<div class="card-body table-hover">
                <div class="">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Information</th>
                                <th>Category</th>
                                <th class="text-right">Action</th>
                                <th class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="allcek">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $noInfo = 1;
                            $sqlInfo = mysqli_query($link, "SELECT * FROM info ORDER BY id DESC")or die(mysqli_error($link));
                            while($dataInfo = mysqli_fetch_assoc($sqlInfo)){
                                ?>
                                <tr>
                                    <td><?=$noInfo++?></td>
                                    <td class="text-nowrap">
                                        <img src="<?=base_url()?>/dashboard/img/content/<?=$dataInfo['image']?>" alt="" style="width:50px; height:50px; overflow:hidden">
                                    </td>
                                    <td class="text-nowrap"><?=$dataInfo['title']?></td>
                                    <td><?=$dataInfo['info']?></td>
                                    <td class="text-nowrap"><?=$dataInfo['category']?></td>
                                    <td class="text-right text-nowrap">
                                        <a href="editInfo.php?t=info&info=<?=$dataInfo['id']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                        <a href="proses/prosesInfo.php?del=info&info=<?=$dataInfo['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                    </td>

                                    <td class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="<?=$data[$i]['npk']?>">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="box pull-right">
                    <button  class="btn btn-danger  deleteall" >
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove" ></i>
                        </span>    
                        Delete
                    </button>
                </div>
            </div>
            </form>
            
		</div>
        
	</div>
</div>

<!-- halaman utama end -->
<?php
    include_once("../footer.php"); 
    ?>

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
    $('.editall').on('click', function(e){
        e.preventDefault();
        var getLink = 'massEditBlast.php';

        document.proses.action = getLink;
        document.proses.submit();
    });
    </script>
    <script>
    //untuk crud masal update department

    $('.remove').on('click', function(e){
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

