
<?php
//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
include("../../../config/function.php");
require_once("../../../config/function_status_approve.php");
require_once("../../../config/function_access_query.php");
require_once("../../../config/function_filter.php");
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Overtime Request";
if(isset($_SESSION['user'])){

    include("../../header.php");
    //menghapus session kode lembur
    if(isset($_SESSION['kode-lembur'])){
        unset($_SESSION['kode-lembur']);
    }
    
    $_SESSION['startD'] = (isset($_POST['start']))? dateToDB($_POST['start']) : date('Y-m-01');
    $_SESSION['endD'] = (isset($_POST['end']))? dateToDB($_POST['end']) : date('Y-m-d');

    $sD = $_SESSION['startD'];
    $eD = $_SESSION['endD'];
   
    $tanggalAwal = date('Y-m-d', strtotime($sD));
    // echo "tanggal awal : ".$tanggalAwal."<br>";
    $tanggalAkhir = date('Y-m-d', strtotime($eD));
    // echo "tanggal akhir : ". $tanggalAkhir."<br>";

    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);

    if($sD <= $eD){
        $hari = date_diff($count_awal,$count_akhir)->days +1;
    }else{
        $hari = 0;
    }

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);
    
    $kolom = access_area($level);
    $t = "org.".$org_access;
    $_SESSION['area'] = "" ;
    $_SESSION['shift'] = "" ;
    $_SESSION['sumary'] = "" ;
    $index = 0;
    if(isset($_POST['area'])){
        
        foreach($_POST['area'] AS $area){
            $_SESSION['area'] .= "OR $kolom = '$area' ";
            $array_area[$index] = $area;
            $index++; 
        }
    }else{
        $array_area[$index] = $access_;
        $_SESSION['area'] = "";
    }
    if(isset($_POST['shift'])){
        foreach($_POST['shift'] AS $shift){
            $_SESSION['shift'] .= "OR karyawan.shift = '$shift' ";
            $array_shift[$index] = $shift;
            $index++; 
        }
    }else{
        $array_shift[$index] = '';
        $_SESSION['shift'] = "";
    }
    if(isset($_POST['sumary'])){
        foreach($_POST['sumary'] AS $sumary){
            $_SESSION['sumary'] .= "OR CONCAT(lembur.status_approve, lembur.status) = '$sumary' ";
            $array_sumary[$index] = $sumary;
            $index++;
        }
    }else{
        $array_sumary[$index] = '';
        $_SESSION['sumary'] = "";
    }
    if(isset($_POST['pencarian'])){
            $_SESSION['pencarian'] = "AND (karyawan.npk LIKE '%$_POST[pencarian]%' OR karyawan.nama LIKE '%$_POST[pencarian]%')";
    }else{
        $_SESSION['pencarian'] = "";
    }
    //filter shift

    $jml_query = mysqli_num_rows(table_access($link, $level, 'lembur', $access_ , "AND karyawan.npk = '37290' " ));
    $area = ($_SESSION['area'] != '')?" AND (".substr($_SESSION['area'], 2).")":"";
    $shift = ($_SESSION['shift'] != '')?" AND (".substr($_SESSION['shift'], 2).")":"";
    $progress = ($_SESSION['sumary'] != '')?" AND (".substr($_SESSION['sumary'], 2).")":"";
    $cari = ($_SESSION['pencarian'] != '')?"$_SESSION[pencarian]":"";
    // echo $shift;
    // // print_r($array_shift);
    // echo $area;
    // echo $progress;
    // mysqli_query($link, "DELETE FROM lembur");
    
    $no = 1;
    $dataArea = area($link, $level, $access_);
    // echo $access_;
require_once("../../../config/calculation/calc_progress.php");
?>
<br>

<form method="POST">
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
                <div class="row">
                    <div class="col-md-3 border-2">
                        <div class="input-group border-2 bg-transparent no-border">
                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <input type="text" name="start" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAwal)?>">
                                
                            <div class="input-group-prepend ml-0 bg-transparent">
                                <div class="input-group-text px-2 bg-transparent">
                                    <i>to</i>
                                </div>
                            </div>
                            <input type="text" name="end" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAkhir)?>">
                            
                            <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                            
                        </div>
                        
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                    <div class="col-md-9 border-2 ">
                        <div class="box float-right">
                            <a href="../index.php" type="button" class="btn btn-default btn-icon btn-round align-center align-bottom generate" data-toggle="modalgenerate" data-target=".bd-example-modal-xl">
                                <span class="btn-label">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </div>
                        <div class="box float-right border-left pl-2">
                            <span style="position:absolute; z-index:1000" class="badge badge-sm badge-pill badge-success pull-right"><?=$jml_Arsip?></span>
                            <button type="button" class="btn btn-success btn-icon btn-outline-success mr-1 btn-link btn-round align-center align-bottom " data-toggle="modalgenerate" data-target=".bd-example-modal-xl">
                                <span class="btn-label">
                                    <i class="nc-icon nc-book-bookmark"></i>
                                </span>
                            </button>
                        </div>
                        <p class="float-right mr-2">
                            <button id="" type="submit" name="cari" class="btn btn-icon btn-default btn-outline-default btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                                <i class="nc-icon nc-zoom-split "> </i>
                            </button>   
                        </p>
                        <div class="mr-2 my-0 py-0 float-right order-1">
                            <div class="input-group bg-transparent">
                                <select type="text" name="sumary[]" class="text-uppercase bg-transparent selectpicker" data-title="Progress" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    $sumary = array(
                                            array( 'Draft' , '0a'),
                                            array( 'Waiting Approval' , '25a'),
                                            array( 'Disetujui SPV' , '50a'),
                                            array( 'Ditolak SPV' , '50b'),
                                            array( 'Dikembalikan SPV' , '50c'),
                                            array( 'Diproses Admin' , '75a'),
                                            array( 'Ditolak Admin' , '75b'),
                                            array( 'Dikembalikan Admin' , '75c'),
                                            array( 'Pengajuan Dihentikan' , '100b'),
                                            array( 'Close' , '100a')
                                    );
                                    foreach($sumary AS $data){
                                        $select = (in_array($data['1'], $array_sumary))?"selected":"";
                                    ?>
                                        <option <?=$select?> value="<?=$data['1']?>"><?=$data['0']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mr-2 my-0 py-0 float-right order-2">
                            <div class="input-group bg-transparent">
                                <select type="text" name="area[]" class="bg-transparent selectpicker" data-title="area" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    while($area = mysqli_fetch_assoc($dataArea)){
                                        $select = (in_array($area['id_area'], $array_area))?"selected":"";
                                        ?>
                                        
                                        <option <?=$select?> data-subtext="<?=$area['id_area']?>"  value="<?=$area['id_area']?>"><?=$area['nama_area']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mr-2 my-0 py-0 float-right order-3 col-2">
                            <div class="input-group bg-transparent">
                                <select type="text" name="shift[]" class="bg-transparent selectpicker" data-title="shift" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    $sqlShift = mysqli_query($link , "SELECT * FROM shift");
                                    while($dataShift = mysqli_fetch_assoc($sqlShift)){
                                        $select = (in_array($dataShift['id_shift'], $array_shift))?"selected":"";
                                        ?>
                                        <option <?=$select?> value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                       
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</form>

<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <form action="" method="POST">
                    <div class="pull-left ">
                        <h4 class="card-title " >Pengajuan Overtime</h4>
                        <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                    </div>
                    
                    <div class="pull-right border-left ">
                        <button class="btn btn-icon btn-round btn-primary approveall ml-2" type="button" 
                                data-toggle="tooltip" data-placement="bottom" title="approve">
                                <i class="fa fa-check-circle"></i>
                        </button>
                        <button class="btn btn-icon btn-round  btn-danger rejectall" type="button" 
                                data-toggle="tooltip" data-placement="bottom" title="reject">
                                <i class="fa fa-ban"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-warning returnall" type="button"
                            data-toggle="tooltip" data-placement="bottom" title="Kembalikan">
                            <i class="fa fa-undo"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-info  mr-2 pauseall" type="button"
                            data-toggle="tooltip" data-placement="bottom" title="Cuti Habis">
                            <i class="nc-icon nc-button-pause"></i>
                        </button>
                        
                    </div>
                    <div class="pull-right ">
                        <button class="btn btn-icon btn-round btn-success arsipall" type="button" 
                                data-toggle="tooltip" data-placement="bottom" title="arsipkan">
                                <i class="nc-icon nc-book-bookmark"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-danger deleteall mr-2" type="button"
                            data-toggle="tooltip" data-placement="bottom" title="Delete All">
                            <i class="nc-icon nc-simple-remove "></i>
                        </button>
                        
                    </div>
                    
                </form>
                
            </div>
            <div class="card-body ">
            <form action="" method="post">
                <div class="my-2 mr-2 float-right order-3">
                    <div class="input-group bg-transparent">
                        <input type="text" name="pencarian" class="form-control bg-transparent" placeholder="Cari nama atau npk..">
                        <div class="input-group-append bg-transparent">
                            <div class="input-group-text bg-transparent">
                                <i class="nc-icon nc-zoom-split"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                
            <div class="table-responsive" style="height:200">
            <form name="proses" method="POST">
                <table class="table text-uppercase table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Npk</th>
                            <th scope="col">Nama</th>
                            <th scope="col">SHF</th>
                            <th scope="col">Area</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Mulai</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Progress</th>
                            
                            <th scope="col" >Status</th>
                            <th scope="col" class="text-right">Action</th>
                            
                            <th scope="col" class="text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                    <input class="form-check-input " id="allreq" type="checkbox">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </th>
                            
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                        <?php

                            $no = 1;
                                $addclause = "AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift $progress $cari AND CONCAT(lembur.status_approve, lembur.status) <> '100c'  ORDER BY lembur.status_approve, lembur.status, lembur.in_date, groupfrm.nama_group  ASC";
                                $sqlLembur = table_access($link, $level, 'lembur', $access_, $addclause);
                                
                                if(mysqli_num_rows($sqlLembur)){
                                    while($data_Lembur = mysqli_fetch_assoc($sqlLembur)){

                                        $dataStatus = $data_Lembur['status_approve_lembur'].$data_Lembur['status_lembur'];

                                        $info = sumary($data_Lembur['status_approve_lembur'], $data_Lembur['status_lembur'], 'info');
                                        $progress = sumary($data_Lembur['status_approve_lembur'], $data_Lembur['status_lembur'], 'progress');
                                        $color = sumary($data_Lembur['status_approve_lembur'], $data_Lembur['status_lembur'], 'color');
                                        ?>
                                        <tr id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>">
                                            <td><?=$no++?></td>
                                            <td><?=$data_Lembur['npk_']?></td>
                                            <td><?=$data_Lembur['nama_']?></td>
                                            <td><?=$data_Lembur['shift_']?></td>
                                            <td><?=$data_Lembur['groupfrm']?></td>
                                            <td><?=DBtoForm($data_Lembur['in_date_lembur'])?></td>
                                            <td><?=$data_Lembur['in_lembur']?></td>
                                            <td><?=$data_Lembur['out_lembur']?></td>
                                            
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-animated progress-bar-<?=$color?> progress-bar-striped" role="progressbar" style="width: <?=$progress?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            
                                            <td><?=$info?></td>
                                            
                                            <td class="text-nowrap text-right" >
                                                <a <?=tbl_approval($level, $dataStatus, 'approve')?> data-id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>" href="proses.php?approve=<?=$data_Lembur['id_lembur']?>" class="btn btn-sm btn-link btn-icon btn-outline-primary btn-round btn-primary  ml-2 approvebtn" type="button" 
                                                        data-toggle="tooltip" data-placement="bottom" title="approve">
                                                        <i class="fa fa-check-circle"></i>
                                                </a>
                                                <a <?=tbl_approval($level, $dataStatus, 'reject')?> data-id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>" href="proses.php?reject=<?=$data_Lembur['id_lembur']?>" class="btn btn-sm btn-icon btn-outline-danger btn-link btn-round  btn-danger rejectbtn" type="button" 
                                                        data-toggle="tooltip" data-placement="bottom" title="reject">
                                                        <i class="fa fa-ban"></i>
                                                </a>
                                                <a <?=tbl_approval($level, $dataStatus, 'return')?> data-id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>" href="proses.php?return=<?=$data_Lembur['id_lembur']?>" class="btn btn-sm btn-icon btn-link btn-round btn-outline-warning btn-warning returnbtn" type="button"
                                                    data-toggle="tooltip" data-placement="bottom" title="Kembalikan">
                                                    <i class="fa fa-undo"></i>
                                                </a>
                                                <a <?=tbl_approval($level, $dataStatus, 'pause')?> data-id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>" href="proses.php?pause=<?=$data_Lembur['id_lembur']?>" class="btn btn-sm btn-icon btn-link btn-round btn-info btn-outline-info  pausebtn mr-2" type="button"
                                                    data-toggle="tooltip" data-placement="bottom" title="Absen TA">
                                                    <i class="nc-icon nc-button-pause"></i>
                                                </a>
                                                <a <?=tbl_approval($level, $dataStatus, 'arsip')?> data-id="<?=$data_Lembur['npk_']?> tanggal <?=$data_Lembur['in_date_lembur']?>" href="proses.php?arsip=<?=$data_Lembur['id_lembur']?>" class="btn btn-sm btn-icon btn-link btn-round btn-success btn-outline-success  arsipbtn " type="button"
                                                    data-toggle="tooltip" data-placement="bottom" title="Arsipkan">
                                                    <i class="nc-icon nc-book-bookmark"></i>
                                                </a>
                                                <a  class="btn btn-sm btn-icon btn-link btn-round btn-success btn-outline-success  " type="button"
                                                    data-toggle="tooltip" data-placement="bottom" title="No Doc : <?=$data_Lembur['kode_lembur']?>  ">
                                                    <i class="nc-icon nc-alert-circle-i"></i>
                                                </a>
                                                <?php
                                                if($level > 0 && $progress <= 0){
                                                    $tbl = "disabled";
                                                }else{
                                                    $tbl = "";
                                                }
                                                ?>
                                                <a <?=tbl_approval($level, $dataStatus, 'delete')?> href="proses.php?del=<?=$data_Lembur['id_lembur']?>" type="button" class="btn btn-danger btn-simple btn-round btn-icon btn-sm hapus">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                <div class="form-check <?=tbl_approval($level, $dataStatus, 'check')?>">
                                                    <label class="form-check-label ">
                                                        <input class="form-check-input <?=name_check($level, $dataStatus, 'req')?>" <?=tbl_approval($level, $dataStatus, 'check')?> type="checkbox" value="<?=$data_Lembur['id_lembur']?>" name="mpchecked[]">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="11">TIDAK DITEMUKAN DATA DI DATABASE</td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            <div class="card-footer text-right">
                
            </div>
        </div>
    </div>
</div>





    <?php
//footer
    include_once("../../footer.php");
    ?>
<script type="text/javascript">
    
    $('.hapus').on('click', function(e){
	    e.preventDefault();
        var getLink = $(this).attr('href');
        var id = $(this).parents("tr").attr("id");
         
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "SPL dengan Kode : " + id +" akan dihapus secara permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                window.location.href = getLink;
            }
        })
        
    });
    
</script>


<script type="text/javascript">
   $(function () {
       $('#DateTimePicker1').datetimepicker({format: 'YYYY-MM-DD'});
       $('#DateTimePicker2').datetimepicker({format: 'YYYY-MM-DD',
        useCurrent: true //Important! See issue #1075     
   });
       $("#DateTimePicker1").on("dp.change", function (e) {
           $('#DateTimePicker2').data("DateTimePicker").minDate(e.date);
       });
       $("#DateTimePicker2").on("dp.change", function (e) {
           $('#DateTimePicker1').data("DateTimePicker").maxDate(e.date);
       });
   });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });
})
</script>




<!-- ajax untuk modal -->
<script type="text/javascript">
    $(document).ready(function(){

		$('.generate').click(function(){

			var id = $(this).attr("id");
			$.ajax({
				url: 'generate.php',
				method: 'post',	
				data: {id:id},		
				success:function(data){	
					$('#generate').html(data);	
					$('#modalgenerate').modal("show");
				}
			});
		});
	});

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'ajax/set_record.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);
                }
            });
         });
    });
</script>

<script>
    $(document).ready(function(){
        $('#allreq').on('click', function() {
            if(this.checked){
                $('.req').each(function() {
                    this.checked = true;
                })
            } else {
                $('.req').each(function() {
                    this.checked = false;
                })
            }

        });

        $('.req').on('click', function() {
            if($('.req:checked').length == $('.req').length){
                $('#allreq').prop('checked', true)
            } else {
                $('#allreq').prop('checked', false)
            }
        })
    })
</script>
<script>
$(document).ready(function() {
    $('#modalgenerate').modalWizard().on('submit', function (e) {
        // alert('submited');
        Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: 'Surat Pengajuan berhasil Dibuat!'
        });
        $(this).trigger('reset');
        $(this).modal('hide');
    });
});
</script>
<script>
    //untuk crud masal update department
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'mass_del.php';
            
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
    include_once("../../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}