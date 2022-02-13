<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Leave Allocation Settings";
if(isset($_SESSION['user'])){

    include_once("../../header.php");
    //query database
    // mysqli_query($link, "DELETE FROM req_absensi");
    $qry_leave = mysqli_query($link, "SELECT leave_alocation.id AS id_aloc,
    leave_alocation.effective_date AS eff_date,
    leave_alocation.id_leave AS id_leave,
    leave_alocation.alocation AS alocation,
    attendance_code.kode AS leave_code,
    attendance_code.keterangan AS jenis_cuti

    FROM leave_alocation 
    JOIN attendance_code ON leave_alocation.id_leave = attendance_code.kode
    ")or die(mysqli_error($link));

    //filtering
    $_SESSION['thn'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
    $_SESSION['startM'] = (isset($_POST['start']))? $_POST['start'] : 01;
    $_SESSION['endM'] = (isset($_POST['end']))? $_POST['end'] : 12;
    $y = $_SESSION['thn'];
    // echo $y."<br>";
    $sM = $_SESSION['startM'];
    $eM = $_SESSION['endM'];
    // mysqli_query($link, "UPDATE working_days SET ket = 'DOP' WHERE ket = 'DOT' ");
    // echo $_SESSION['startM']."<br >";
    // echo $_SESSION['endM']."<br >";
    $tahun = $_SESSION['thn'];

    $tanggalAwal = date('Y-m-d', strtotime($y.'-'.$sM.'-01'));
    // echo "tanggal awal : ".$tanggalAwal."<br>";
    $tanggalAkhir = date('Y-m-t', strtotime($y.'-'.$eM.'-01'));
    // echo "tanggal akhir : ". $tanggalAkhir."<br>";


    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);
    if($sM <= $eM){
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
    }else{
        $hari = 0;
    }

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);

?>
<!-- halaman utama -->
<!-- filter -->

<form method="POST">
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
            <div class="row">
                <div class="col-md-6 border-2">
                    <div class="input-group border-2 bg-transparent no-border">
                        <div class="input-group-prepend ">
                            <div class="input-group-text bg-transparent">
                                <i class="nc-icon nc-calendar-60"></i>
                            </div>
                        </div>
                        <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                        <select type="date" name="start" class="form-control bg-transparent" >
                            <option Disabled>Pilih Bulan</option>
                            <?php
                            
                            $i =0;
                            foreach($bln AS $namaBln){
                                $i++;
                                $selectBln = ($i == $sM)?"selected":"";
                                
                                echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                            }
                            ?>
                        </select>
                        <div class="input-group-prepend ml-0 bg-transparent">
                            <div class="input-group-text px-2 bg-transparent">
                                <i>to</i>
                            </div>
                        </div>
                        <select type="date" name="end" class="form-control bg-transparent" >
                            <option Disabled>Pilih Bulan</option>
                            <?php
                            
                            $i =0;
                            foreach($bln AS $namaBln){
                                $i++;
                                $selectBln = ($i == $eM)?"selected":"";
                                
                                echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                            }
                            ?>
                        </select>
                        <select type="text" name="tahun" class=" form-control bg-transparent">
                        <option Disabled>Tahun</option>
                        <?php
                        $thnPertama = 2021;
                        for($i=date("Y"); $i>=$thnPertama; $i--){
                            $selectThn = ($i == $tahun)?"selected":"";
                            echo "<option $selectThn value=\"$i\">$i</option>";
                        }
                        ?>
                        </select>
                        <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                        
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
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sticker">
                            <h5 class="title text-uppercase">Access Control</h5>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab active" href="#leaveAlloc" role="tab" data-toggle="tab">Leave Allocation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab " href="#dataTransfer" role="tab" data-toggle="tab">Data Transfer</a>
                                    </li>
                                        
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <div class="tab-content">
                            <div class="tab-pane active" id="leaveAlloc" role="tabpanel" aria-expanded="true">
                                <?php
                                    include_once("leave_setting.php");
                                ?>
                            </div>
                            <div class="tab-pane " id="dataTransfer" role="tabpanel" aria-expanded="true">
                                <div class="collapse" id="collapseExample">
                                    <div class="row">
                                        <div class="col-md-9 pull-left">
                                            <h6>tambah data</h6>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
                                                <div class="card-body  mt-2">
                                                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                                                        <div class="form-group rounded py-auto text-center" style="border:1px dashed rgb(223, 220, 220);background:rgba(255, 255, 255, 0.3)">
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
                                                        <div class="form-group-sm" >
                                                        <select style="background:rgba(255, 255, 255, 0.3)" class="form-control part text-center" data-size="7" name="part" data-style="btn btn-sm btn-outline-default btn-link border" title="Select Organization Part" data-width="300px" data-id="" id="area" required>
                                                            <option disabled>Select Organization Part</option>
                                                            <option value="division" class="text-uppercase text-center">Division</option>
                                                            <option value="deptAcc" class="text-uppercase text-center">Department Account</option>
                                                            <option value="dept" class="text-uppercase text-center">Department Functional</option>
                                                            <option value="section" class="text-uppercase text-center">Section</option>
                                                            <option value="group" class="text-uppercase text-center">Group</option>
                                                            <option value="pos" class="text-uppercase text-center">Team</option>
                                                            <option value="all" class="text-uppercase text-center">Kosongkan</option>
                                                        </select>
                                                    </div>
                                                    <a  class="btn btn-sm btn-danger  btn-link " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                                                    <a  class="btn btn-sm btn-warning btn-link" href="" role="button" ><i class="nc-icon nc-cloud-download-93"></i> Download Format</a>
                                                    <button type="submit" class="btn btn-sm btn-primary pull-right">Upload</button>
                                        
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    include_once("data_transfer.php");
                                    // echo "5"
                                ?>
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
</div>
<!-- end filter -->


    

    

<?php
    include_once("../../footer.php");
    ?>
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
                document.location.href=getLink;
            }
        })
        
    });
    </script>
    <script>
    //untuk crud masal update department

    $('.proses').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
            
        Swal.fire({
        title: 'Pengajuan Siap Diproses',
        text: "Draft pengajuan anda akan dikirim untuk diproses",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00B9FF',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, Proses!'
        }).then((result) => {
            if (result.value) {
                document.location.href=getLink;
            }
        })
        
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
    $('.requestall').on('click', function(e){
        e.preventDefault();
        var getLink = 'mass_req.php';

        document.proses.action = getLink;
        document.proses.submit();
    });
    </script>
<?php
    include_once("../../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>