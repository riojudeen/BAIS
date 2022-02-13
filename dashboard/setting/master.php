<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Master Data Settings";
    include_once("../header.php");

    $tab = (isset($_GET['tab'])) ? "$_GET[tab]" : "jbtn";
    switch ($tab){
        case 'jbtn':
            $jbtn = "active";
            $ot = "";
            $shf = "";
            $abs= "";
            break;
        case 'ot':
            $jbtn = "";
            $ot = "active";
            $shf = "";
            $abs= "";
            break;
        case 'abs':
            $jbtn = "";
            $ot = "";
            $shf = "";
            $abs= "active";
            break;
        case 'shf':
            $jbtn = "";
            $ot = "";
            $shf = "active";
            $abs= "";
            break;
    }
?>
<!-- halaman utama -->
<form name="proses" method="POST" action="">
<div class="row ">
    <div class="col-md-12 ">
        <div class="card">
            
			<div class="card-body">
                <div class="row">
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                    <h5 class="title title text-uppercase">Master Data</h5>
                        <div class="sticker">
                            <div class="nav-tabs-wrapper ">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab <?=$jbtn?>" href="#jabatan" role="tab" data-toggle="tab">Master Jabatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab <?=$shf?>" href="#shift" role="tab" data-toggle="tab">Master Shift</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab <?=$abs?>" href="#absensi" role="tab" data-toggle="tab">Master Absensi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab <?=$ot?>" href="#overtimetab" role="tab" data-toggle="tab">Master Kode Overtime</a>
                                    </li>
                                    
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <div class="tab-content">
                            
                            <div class="tab-pane <?=$abs?>" id="absensi">

                            <h5 class="pull-left title text-uppercase">Leave & Permition</h5>
                            <a href="addAbsensi.php?t=abs" class="pull-right btn btn-sm  btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                                <span class="btn-label">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </span>
                                
                            </a>
                                <div class="table-hover">
                                    <table class="table table_org" id="" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code </th>
                                            <th>Keterangan</th>
                                            <th>Leave Type</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php  
                                            $noO = 1;
                                            $s_codeAbsensi = mysqli_query($link, "SELECT * FROM attendance_code")or die(mysqli_error($link));
                                            $countCode = mysqli_num_rows($s_codeAbsensi);
                                            if($countCode > 0){
                                                while($dataCodeAbsensi = mysqli_fetch_assoc($s_codeAbsensi)){
                                                    echo "<tr>";
                                                    echo "<td>".$noO++."</td>";
                                                    echo "<td>$dataCodeAbsensi[kode]</td>";
                                                    echo "<td>$dataCodeAbsensi[keterangan]</td>";
                                                    echo "<td>$dataCodeAbsensi[type]</td>";
                                                    ?>
                                                    <td class="text-right">
                                                        <a href="editAtt.php?t=abs&abs=<?=$dataCodeAbsensi['kode']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                        <a href="proses/prosesMaster.php?del=abs&abs=<?=$dataCodeAbsensi['kode']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>

                                                    </td>
                                                        
                                                    <?php
                                                    echo "</tr>";

                                                }
                                            }else{
                                                echo "<td colspan=\"4\">$dataCodeAbsensi[kode]</td>";
                                            }
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </div>
                            <div class="tab-pane <?=$jbtn?>" id="jabatan">

                            <h5 class="pull-left title text-uppercase">Jabatan</h5>
                            <a href="addJabatan.php?t=jbtn" class="pull-right btn btn-sm  btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                                <span class="btn-label">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </span>
                                
                            </a>
                                <div class="table-hover">
                                    <table class="table table_org" id="" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Jabatan</th>
                                            <th>Level</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  
                                            $n = 1;
                                            $s_codejabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` ASC")or die(mysqli_error($link));
                                            $countCodeJ = mysqli_num_rows($s_codejabatan);
                                            if($countCodeJ > 0){
                                                while($dataJabatan = mysqli_fetch_assoc($s_codejabatan)){
                                                    echo "<tr>";
                                                    echo "<td>".$n++."</td>";
                                                    echo "<td>$dataJabatan[id_jabatan]</td>";
                                                    echo "<td>$dataJabatan[jabatan]</td>";
                                                    echo "<td>$dataJabatan[level]</td>";
                                                    ?>
                                                    <td class="text-right">
                                                        <a href="editJbt.php?t=jbtn&jbt=<?=$dataJabatan['id_jabatan']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                        <a href="proses/prosesMaster.php?del=jbtn&jbt=<?=$dataJabatan['id_jabatan']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>

                                                    </td>
                                                        
                                                    <?php
                                                    echo "</tr>";

                                                }
                                            }else{
                                                echo "<td colspan=\"4\">tidak ada data</td>";
                                            }
                                            ?>  
                                            
                                            
                                            
                                            
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </div>
                            <div class="tab-pane <?=$ot?>" id="overtimetab">

                            <h5 class="pull-left title text-uppercase">Overtime Code</h5>
                            <a href="addOT.php?t=ot" class="pull-right btn btn-sm  btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                                <span class="btn-label">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </span>
                                
                            </a>
                                <div class="table-hover">
                                    <table class="table table_org" id="" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Keterangan Lembur</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  
                                            $nO = 1;
                                            $s_codeOt = mysqli_query($link, "SELECT * FROM kode_lembur ORDER BY `kode_lembur` ASC")or die(mysqli_error($link));
                                            $countCodeO = mysqli_num_rows($s_codeOt);
                                            if($countCodeO > 0){
                                                while($dataOt = mysqli_fetch_assoc($s_codeOt)){
                                                    echo "<tr>";
                                                    echo "<td>".$nO++."</td>";
                                                    echo "<td>$dataOt[kode_lembur]</td>";
                                                    echo "<td>$dataOt[nama]</td>";
                                                    
                                                    ?>
                                                    <td class="text-right">
                                                        <a href="editOt.php?t=ot&ot=<?=$dataOt['kode_lembur']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                        <a href="proses/prosesMaster.php?del=ot&ot=<?=$dataOt['kode_lembur']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>

                                                    </td>
                                                        
                                                    <?php
                                                    echo "</tr>";
                                                }
                                            }else{
                                                echo "<td colspan=\"4\">tidak ada data</td>";
                                            }
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </div>
                            <div class="tab-pane <?=$shf?>" id="shift">

                            <h5 class="pull-left title text-uppercase">Shift</h5>
                            <a href="addShf.php?t=shf"  class="pull-right btn btn-sm  btn-default" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                                <span class="btn-label">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </span>
                            </a>
                                <div class="table-hover">
                                    <table class="table table_org" id="" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Shift</th>
                                            <th>Production Shift</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  
                                            $nOoo = 1;
                                            $s_codeShift = mysqli_query($link, "SELECT * FROM shift ORDER BY id_shift ASC")or die(mysqli_error($link));
                                            $countCodeS = mysqli_num_rows($s_codeShift);
                                            if($countCodeS > 0){
                                                while($dataShift = mysqli_fetch_assoc($s_codeShift)){
                                                    $prod = ($dataShift['production'] == 1)?"YES":"NO";
                                                    echo "<tr>";
                                                    echo "<td>".$nOoo++."</td>";
                                                    echo "<td>$dataShift[id_shift]</td>";
                                                    echo "<td>$dataShift[shift]</td>";
                                                    echo "<td>$prod</td>";
                                                    
                                                    ?>
                                                    <td class="text-right">
                                                        <a href="editShift.php?t=shf&shf=<?=$dataShift['id_shift']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                        <a href="proses/prosesMaster.php?del=shf&shf=<?=$dataShift['id_shift']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>

                                                    </td>
                                                        
                                                    <?php
                                                    echo "</tr>";

                                                }
                                            }else{
                                                echo "<td colspan=\"4\">tidak ada data</td>";
                                            }
                                            ?>
                                            
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="card-footer">
            </div>
	
		
		</div>
	</div>
</div>
</form>
<!-- halaman utama end -->
<?php
    include_once("../footer.php"); 
    ?>
    <!-- javascript -->
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });

            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                }
            })
        })
    </script>

    <!-- untuk proses tombol edit & delete masal -->
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
