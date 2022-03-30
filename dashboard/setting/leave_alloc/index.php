<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Leave Allocation Settings";
if(isset($_SESSION['user'])){

    include_once("../../header.php");
    
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
    
    $c = "style=\"border:5px solid #FF7834\"";
    $a = "";
    $b = "";
    include_once('../../component/migration-nav.php');
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
                    <input type="hidden" name="" id="start_date" value="<?=$tanggalAwal?>">
                    <input type="hidden" name="" id="end_date" value="<?=$tanggalAkhir?>">
                   
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
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab navigasi-data active data-active" data-id="alocation" href="#leaveAlloc" role="tab" data-toggle="tab">Leave Allocation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn-link btn-round btn-info list-tab navigasi-data " href="#dataTransfer" data-id="transfer" role="tab" data-toggle="tab">Data Transfer</a>
                                    </li>
                                        
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <div class="data-monitor-leave">
                            
                        </div>
                        <!-- <div class="tab-content">
                            <div class="tab-pane active" id="leaveAlloc" role="tabpanel" aria-expanded="true">
                                <?php
                                    // include_once("leave_setting.php");
                                ?>
                            </div>
                            <div class="tab-pane " id="dataTransfer" role="tabpanel" aria-expanded="true">
                                
                                
                                <?php
                                    // include_once("data_transfer.php");
                                    // echo "5"
                                ?>
                            </div>

                        </div> -->
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                
                
                
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade modal-primary" id="myModal_attachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content ">
        <div class="modal-header justify-content-center">
        <div class="modal-profile mx-auto " style="margin-top:-500">
            <i class="fa fa-paperclip"></i>
            
        </div>
        </div>
        <form class="modal-body text-center" method="POST" id="attachForm">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="title  text-uppercase">Edit Seting</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="card-label text-uppercase"> Jenis Pengajuan</label>
                        <input type="hidden" name="input_kode_cuti" id="input_kode_cuti" class="form-control">
                        <input type="text" id="input_jenis_cuti" name="input_jenis_cuti" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="card-label text-uppercase">Attachment Seting</label>
                        <select name="attachment_seting" class="form-control">
                            <option value="0">Tidak Ada</option>
                            <option value="1">Ada Attachment</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-footer">
            <a href="proses.php" class="btn btn-link btn-primary attach-update">Update</a>
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
            function update_attach(){
                var form = $('#attachForm').serialize();
                console.log(form)
                $.ajax({
                    url:'proses.php',
                    method:"POST",
                    data:form,
                    success:function(data){
                        dataActive()
                    }
                })
            }
            $(document).on('click', '.btn-attach', function(event){
                event.preventDefault()
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                $('#myModal_attachment').modal('show');
                $('#input_kode_cuti').val(id);
                    $('#input_jenis_cuti').val(name);
                    $('#input_kode_cuti').prop('readonly', true);
                    $('#input_jenis_cuti').prop('readonly', true);
                $('.attach-update').on('click',function(a){
                    a.preventDefault();
                    
                    update_attach()
                })
                
            })


            dataActive()
            $(document).on('click','.navigasi-data', function(){
                $('.navigasi-data').removeClass('data-active');
                $(this).addClass('data-active');
                dataActive()
            });
            $(document).on('click', '.halaman', function(){
                var page = $(this).attr("id");
                dataActive(page)
                // console.log(hal)
            });
            function dataActive(page){
                if($(".data-active")[0]){
                    var id = $('.data-active').attr('data-id');
                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    
                    if(id == 'alocation'){
                        $.ajax({
                            url:"leave_setting.php",
                            method:"GET",
                            data:{start : start, end:end, id:id, page:page},
                            success:function(data){
                                $('.data-monitor-leave').fadeOut('fast', function(){
                                    $(this).html(data).fadeIn('fast');
                                });
                                // $('#data-monitoring').html(data)
                            }
                        })

                    }else{
                        $.ajax({
                            url:"data_transfer.php",
                            method:"GET",
                            data:{ start : start, end:end, id:id, page:page},
                            success:function(data){
                                $('.data-monitor-leave').fadeOut('fast', function(){
                                    $(this).html(data).fadeIn('fast');
                                });
                                // $('#data-monitoring').html(data)
                            }
                        })
                    }
                }
            }
            $(document).on('click', '#allmp' ,function() {
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

            $(document).on('click', '.mp', function() {
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