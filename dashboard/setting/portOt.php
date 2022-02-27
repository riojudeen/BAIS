<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Portal Data Overtime";
    include_once("../header.php");
?>
<!-- modal import data cost -->

<!-- halaman utama -->
<div class="collapse" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <form action="proses/prosesAttPort.php" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Excel</h5>
                    <div class="pull-right">   
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body text-center">
                    <form method="post" enctype="multipart/form-data" action="proses/import.php">
                        <div class="form-group border rounded py-auto">
                            
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div>
                                    <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Upload File Excel</button>
                    </form>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="row ">

	<div class="col-md-12 ">

		<div class="card">
			<div class="card-header">
				<h5 class="title pull-left">Database Overtime</h5>
                <div class="box pull-right">
                    
                    <a href="file/FormatUpdate_MP.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                        <i class="nc-icon nc-paper"></i>
                    </a>
                    <a href="overtime/index.php" class="btn btn-danger btn-icon btn-round" name="export" data-toggle="tooltip" data-placement="bottom" title="Cost Sumary">
                        <span class="btn-label">
                            <i class="nc-icon nc-money-coins"></i>
                        </span>
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
            
			<div class="card-body">
                <form method="post" name="proses" action="" >
                <div class="table-responsive">
                    <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NPK</th>
                                <th>Tanggal</th>
                                
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
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
                        $no = 1;
                        $sqlOt = mysqli_query($link, "SELECT * FROM hr_lembur")or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sqlOt) > 0){
                            while($dataOt = mysqli_fetch_assoc($sqlOt)){
                        ?>
                        
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$dataOt['npk']?></td>
                                <td><?=$dataOt['date']?></td>
                                
                                <td><?=$dataOt['start']?></td>
                                <td><?=$dataOt['end']?></td>
                                <td class="text-right text-nowrap">
                                    <a href="editAttPort.php?t=portAtt&id=<?=$dataOt['id']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                    <a href="proses/prosesAttPort.php?t=portAtt&id=<?=$dataOt['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
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
                        }else{
                            echo "<tr><td class=\"text-center\" colspan=\"10\">Tidak ditemukan data di database</td></tr>";
                        }
                        ?>
                        </tbody>
                        
                    </table>
                </div>
            
                <hr>
                <div class="box pull-right">
                    <button class="btn btn-success editall">
                        <span class="btn-label">
                            <i class="nc-icon nc-check-2"></i>
                        </span>
                        Edit
                    </button>
                    <button  class="btn btn-danger  deleteall" >
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove" ></i>
                        </span>    
                        Delete
                    </button>

                </div>
                </form>
            </div>
            <div class="card-footer">
                
            </div>
                
                
            
	
		
		</div>
	</div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../footer.php"); 
    //javascript
    ?>

    <script>
    //untuk crud masal update department
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'proses/prosesAtt.php';
            
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
        var getLink = 'massEditAtt.php';

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
