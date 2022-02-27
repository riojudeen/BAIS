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
                    <h5 class="card-title pull-left">Import Data Excel</h5>
                    <div class="pull-right">    
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body text-center">
                    <form method="post" enctype="multipart/form-data" action="proses/import.php">
                        <div class="form-group border rounded py-auto">
                            <div class="form-group-sm">
                                <select class="form-control selectpicker part text-center" data-size="7" name="tipe[]" data-style="btn btn-warning bg-white btn-link border" title="Select Information" data-width="300px" data-id="" id="area" required>
                                    <option value="obat">Pengobatan</option>
                                    <option value="um">Uang Makan</option>
                                </select>
                            </div>
                            <hr class="my-0">
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
        </div>
    </div>
</div>
<div class="row ">

	<div class="col-md-12 ">
    
		<div class="card">
			<div class="card-header">
				<h5 class="title pull-left">Informasi Transfer</h5>
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
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#uangobat" role="tab" data-toggle="tab"><h6 class="text-right ">Transfer Pengobatan</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#uangmakan" role="tab" data-toggle="tab"><h6 class="text-right ">Transfer Uang Makan</h6></a>
                        </li>
                        
                    
                    </ul>
                </div>
            </div>
			<div class="card-body">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="uangmakan">

                    <h5>Transfer Uang Makan</h5>
                        <div class="">
                            <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Upload</th>
                                    <th>Total Transfer</th>
                                    <th>Total MP</th>
                                    <th class="text-right">Action</th>
                                 </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $no = 1;
                                    $sqlTrfum = mysqli_query($link, "SELECT * FROM `transfer` WHERE category = 'um' GROUP BY tgl_upload")or die(mysqli_error($link));
                                    $totalum = mysqli_num_rows($sqlTrfum);
                                    
                                    if($totalum > 0){
                                        while($dataTrfum = mysqli_fetch_assoc($sqlTrfum)){
                                            echo "<tr>";
                                            echo "<td>".$no++."</td>";
                                            echo "<td>$dataTrfum[tgl_upload]</td>";
                                            $sqlNom = mysqli_query($link, "SELECT SUM(nominal) AS 'tot' FROM `transfer` WHERE category = 'um' AND tgl_upload = '$dataTrfum[tgl_upload]' ")or die(mysqli_error($link));
                                            $totalNom = mysqli_fetch_assoc($sqlNom);
                                            $totNom = "Rp. ".number_format($totalNom['tot'], 0, ',' ,'.');
                                            echo "<td >$totNom</td>";
                                            $totalUmMp = mysqli_num_rows(mysqli_query($link, "SELECT npk FROM `transfer` WHERE category = 'um' AND tgl_upload = '$dataTrfum[tgl_upload]' "));
                                            
                                            echo "<td class=\"text-right\">$totalUmMp</td>";
                                            ?>
                                            <td class="text-right">
                                            <a href="?code=<?=$dataTrfum['tgl_upload']?>" class="btn-round btn-outline-success btn btn-success btn-link btn-icon btn-sm remove"><i class="nc-icon nc-bullet-list-67"></i></a>
                                                <a href="?code=<?=$dataTrfum['tgl_upload']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="nc-icon nc-ruler-pencil"></i></a>
                                                <a href="?code=<?=$dataTrfum['tgl_upload']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="nc-icon nc-simple-remove"></i></a>

                                            </td>
                                                
                                            <?php
                                            echo "</tr>";

                                        }
                                    }else{
                                        echo "<td class=\"text-center\" colspan=\"5\">tidak ada data di database</td>";
                                    }


                                    ?>  
                                </tbody>
                                
                            </table>
                        </div>  
                    </div>
                    <div class="tab-pane " id="uangobat">
                    <h5>Transfer Uang Penobatan</h5>
                        <div class="">
                            <table class="table table-striped table_org" id="uangobat" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Upload</th>
                                    <th>Total Transfer</th>
                                    <th>Total MP</th>
                                    <th class="text-right">Action</th>
                                 </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $no = 1;
                                    $sqlTrfuo = mysqli_query($link, "SELECT * FROM `transfer` WHERE category = 'uo' GROUP BY tgl_upload")or die(mysqli_error($link));
                                    $totaluo = mysqli_num_rows($sqlTrfuo);
                                    
                                    if($totaluo  > 0){
                                        while($dataTrfuo = mysqli_fetch_assoc($sqlTrfuo)){
                                            echo "<tr>";
                                            echo "<td>".$no++."</td>";
                                            echo "<td>$dataTrfum[tgl_upload]</td>";
                                            $sqlNom = mysqli_query($link, "SELECT SUM(nominal) AS 'tot' FROM `transfer` WHERE category = 'uo' AND tgl_upload = '$dataTrfuo[tgl_upload]' ")or die(mysqli_error($link));
                                            $totalNom = mysqli_fetch_assoc($sqlNom);
                                            $totNom = "Rp. ".number_format($totalNom['tot'], 0, ',' ,'.');
                                            echo "<td>$totNom</td>";
                                            $totalUmMp = mysqli_num_rows(mysqli_query($link, "SELECT npk FROM `transfer` WHERE category = 'uo' AND tgl_upload = '$dataTrfuo[tgl_upload]' "));
                                            
                                            echo "<td>$totalUmMp</td>";
                                            ?>
                                            <td class="text-right">
                                            <a href="?code=<?=$dataTrfuo['tgl_upload']?>" class="btn-round btn-outline-success btn btn-success btn-link btn-icon btn-sm remove"><i class="nc-icon nc-bullet-list-67"></i></a>
                                                <a href="?code=<?=$dataTrfuo['tgl_upload']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="nc-icon nc-ruler-pencil"></i></a>
                                                <a href="?code=<?=$dataTrfuo['tgl_upload']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="nc-icon nc-simple-remove"></i></a>

                                            </td>
                                                
                                            <?php
                                            echo "</tr>";

                                        }
                                    }else{
                                        echo "<td class=\"text-center\"  colspan=\"5\">tidak ada data di database</td>";
                                    }


                                    ?>  
                                </tbody>
                                
                            </table>
                        </div>  
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
                
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
