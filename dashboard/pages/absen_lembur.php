<?php 
//////////////////////////////////////////////////////////////////////
include_once("../../config/config.php");
$halaman = "Lembur";
if(isset($_SESSION['user'])){
    include_once("../header.php");
    //jika tanggal tidak diset
    $hari_ini = date("Y-m-d");

    $tgl_pertama = date('Y-m-01', strtotime($hari_ini));
    $tgl_terakhir = date('Y-m-t', strtotime($hari_ini));


    $sampai = (isset($_SESSION['end']) && $_SESSION['end'] != '') ? dateToDB($_SESSION['end']) : $hari_ini;
    $dari = (isset($_SESSION['start']) && $_SESSION['end'] != '') ? dateToDB($_SESSION['start']) : $tgl_pertama;

    //menghitung total hari
    $start = $month = strtotime($dari);
    $end = strtotime($sampai);

    $awal = date_create($dari);
    $akhir = date_create($sampai);

    $jml = date_diff($awal,$akhir);
    $jml_hari = $jml->days +1;

    $no_urut = 1;

    //selection department functional
    $qry_functional = "SELECT * FROM department WHERE id_div = '1'";
    $sqlFunctional = mysqli_query($link, $qry_functional);

    $qry_dept = "SELECT * FROM dept_account WHERE id_div = '1'";
    $sqlDept = mysqli_query($link, $qry_dept );

    if($role  > 3){
        $clm = "grp";
        $clm2 = "nama_group";
        $tbl2 = "groupfrm";
        $tbl3 = "id_group";
    }else{
        $clm = "post";
        $clm2 = "nama_pos";
        $tbl2 = "pos_leader";
        $tbl3 = "id_post";
    }
    $t = "org.".$org_access;
    $qry_area = "SELECT org.$clm AS '1', $tbl2.$clm2 AS '2' FROM org 
    LEFT JOIN $tbl2 ON $tbl2.$tbl3 = org.$clm WHERE $t = '$access_' GROUP BY org.$clm";
    $sqlArea = mysqli_query($link, $qry_area );
    // echo $qry_area;

    // query jumlah
    $qry_karyawan = "SELECT karyawan.npk AND org.npk FROM karyawan LEFT JOIN org ON org.npk = karyawan.npk WHERE $t = '$access_'";
    $sqlKaryawan = mysqli_query($link, $qry_karyawan)or die(mysqli_error($link));
    $jml_karyawan = mysqli_num_rows($sqlKaryawan);

    $load_mp = "10";
    $_SESSION['tdata'] = (isset($_SESSION['tdata']))?$_SESSION['tdata']:$load_mp;
    $_SESSION['batas'] = $jml_karyawan;

?>
    <style>
    #ajax-wait {
        display: none;
        /* position: fixed; */
        /* z-index: 1999 */
    }
    </style>


<!--  -->
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <h5 class="card-title">Monitoring Absensi & Lembur<li class="nc-icon nc-circle-10 pull-right"></
                li></h5>
                
                <p class="card-category"></p>
                
                
            </div>
            <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
                <div class="card card-plain">
                    <div class="card-header px-3" role="tab" id="headingOne">
                        <div class="box pull-left">
                            <div class="form-inline" >
                                <div class="border-1 input-group bg-transparent no-border">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-danger pr-2 "><i class="nc-icon nc-calendar-60"></i></span>
                                        
                                    </div>
                                    <input style="background: #EAECEE;" type="text" name="awal" id="start" class="form-control border-right-0 datepicker" placeholder="tanggal mulai" data-date-format="DD/MM/YYYY" id="datetimepicker6" value="<?=DBtoForm($dari)?>">
                                    <div class="input-group-prepend" style="margin-left: -3px">
                                        <span type="text" class="input-group-text px-3" style="font-size: 12px">to</span>
                                    </div>
                                    <input style="background: #EAECEE;" type="text" name="akhir" id="end" class="form-control datepicker" placeholder="tanggal akhir" data-date-format="DD/MM/YYYY" id="datetimepicker7" value="<?=DBtoForm($sampai)?>">
                                    
                                </div>
                                <label class="ml-2 col-form-label ">data :</label>
                                <div class="input-group ml-2 no-border">
                                    <input style="background: #EAECEE;" type="number" name="jumlah" id="totaldata" class="form-control border-right-0"   value="<?=$load_mp?>">
                                </div>
                                <label class="ml-2 col-form-label ">/ <?=$jml_karyawan?></label>
                                
                                <div class="input-group ">
                                    <button class="ml-2 btn btn-danger btn-round btn-link btn-outline-danger sort" aria-hidden="true">SORT</button>
                                </div>
                            </div>
                        </div>
                        <div class=" box pull-right">
                            <div class="form-inline" >
                                <div class="my-2 mr-2 float-right order-3">
                                    <div class="input-group bg-transparent">
                                        <input type="text" name="cari" class="form-control bg-transparent cari"  id="pencarian" placeholder="Cari nama atau npk..">
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
                    <div class=" row">
                        <div class="col-12">
                            
                            <a style="box-shadow: inset 1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:-1rem; margin-right:-1rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                            class=" pull-right btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <!-- Monitoring Absensi & Lembur -->
                                <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                            </a>
                            <a style="box-shadow: inset -1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:-1rem; margin-left:-1rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                            class=" pull-left btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <!-- Filter -->
                                <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                            </a>
                            
                            <p style="background:#F9F9F9" class=" text-center btn-danger text-uppercase text-info btn-sm my-0" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            filter data
                            </p>
                            
                        </div>
                    </div>
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body px-0">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-3 my-0 pl-3 pr-1">
                                        <div class="form-group">
                                            <select class="form-control selectpicker my-0 p-0 filter" name="monitoring" id="monitor" data-style="btn btn-danger btn-outline-danger text-danger" title="data" multiple>
                                                <option value="absensi">Absensi</option>
                                                <option value="overtime">Overtime</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-0 pl-1 pr-1">
                                        <div class="form-group">
                                            <select class="form-control selectpicker my-0 p-0 filter" name="area" id="area" data-style="btn btn-danger btn-outline-danger text-danger" title="area" multiple>
                                                <?php
                                                if(mysqli_num_rows($sqlArea) > 0 ){
                                                    while($dataArea = mysqli_fetch_assoc($sqlArea)){
                                                        ?>
                                                        <option value="<?=$dataArea['1']?>"><?=$dataArea['2']?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-0 pl-1 pr-1">
                                        <div class="form-group">
                                            <select class="form-control selectpicker my-0 p-0 filter" name="shift" id="shift" data-style="btn btn-danger btn-outline-danger text-danger" title="shift" multiple>
                                                <?php
                                                $qShift = mysqli_query($link, "SELECT * FROM shift");
                                                if(mysqli_num_rows($qShift) > 0){
                                                    while($dataShift = mysqli_fetch_assoc($qShift)){
                                                        ?>
                                                        <option value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option>No Data</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-0 pl-1 pr-1">
                                        <div class="form-group">
                                            <select class="form-control selectpicker my-0 p-0 filter" name="functional" id="functional" data-style="btn btn-danger btn-outline-danger text-danger" title="functional" multiple>
                                            <?php
                                            if(mysqli_num_rows($sqlFunctional) > 0 ){
                                                while($dataFunctional = mysqli_fetch_assoc($sqlFunctional)){
                                                    ?>
                                                    <option value="<?=$dataFunctional['id_dept']?>"><?=$dataFunctional['dept']?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-0 pl-1 pr-3">
                                        <div class="form-group">
                                            <select class="form-control selectpicker my-0 p-0 filter" name="dept" id="dept" data-style="btn btn-danger btn-outline-danger text-danger" title="department" multiple>
                                            <?php
                                            if(mysqli_num_rows($sqlDept) > 0 ){
                                                while($dataDept = mysqli_fetch_assoc($sqlDept)){
                                                    ?>
                                                    <option value="<?=$dataDept['id_dept_account']?>"><?=$dataDept['id_dept_account']?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-full-width">
                <div id='ajax-wait' class="text-center">
                    <img alt='loading...' src='<?=base_url()?>/assets/img/loading/loading-x.gif' width='32' height='32' />
                </div>
                <div id="data"></div>
                
            </div>
            <div class="card-footer ">
                <div class="stats">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   $(function () {
       $('#datetimepicker6').datetimepicker({format: 'YYYY-MM-DD'});
       $('#datetimepicker7').datetimepicker({format: 'YYYY-MM-DD',
        useCurrent: true //Important! See issue #1075     
   });
       $("#datetimepicker6").on("dp.change", function (e) {
           $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
       });
       $("#datetimepicker7").on("dp.change", function (e) {
           $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
       });
   });
</script>
<script type="text/javascript">
$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        
        $.ajax({
            url: 'ajax/absen_lembur.php',	
            method: 'post',	
            success:function(data){		
                $('#data').html(data);
            }
        });
        
        $('.filter').change(function(e){
            e.preventDefault();
            var monitor = $('#monitor').val();
            var dept = $('#dept').val();
            var area = $('#area').val();
            var shift = $('#shift').val();
            var functional = $('#functional').val();
            var start = $('#start').val();
            var end = $('#end').val();
            var tdata = $('#totaldata').val();
            var cari = $('#pencarian').val();

            $.ajax({
                url: 'ajax/absen_lembur.php',
                method  : 'post',
                data: {cari:cari, dept:dept, area:area, shift:shift, monitor:monitor, functional:functional, start:start, end:end, tdata:tdata},
                success:function(data){
                    $('#data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">

                }
            });
        });
        $('.sort').click(function(){
            var start = $('#start').val();
            var end = $('#end').val();
            var tdata = $('#totaldata').val();
            var cari = $('#pencarian').val();
            var monitor = $('#monitor').val();
            var dept = $('#dept').val();
            var area = $('#area').val();
            var shift = $('#shift').val();
            var functional = $('#functional').val();
            $.ajax({
                url: 'ajax/absen_lembur.php',	
                method  : 'post',
                data: {cari:cari, start:start, end:end, tdata:tdata, dept:dept, area:area, shift:shift, monitor:monitor, functional:functional},
                success:function(data){
                    $('#data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">

                }
            });
        });
        $('#pencarian').blur(function(){
            var start = $('#start').val();
            var end = $('#end').val();
            var tdata = $('#totaldata').val();
            var cari = $(this).val();
            var monitor = $('#monitor').val();
            var dept = $('#dept').val();
            var area = $('#area').val();
            var shift = $('#shift').val();
            var functional = $('#functional').val();
           
            $.ajax({
                url: 'ajax/absen_lembur.php',	
                method  : 'post',
                data: {cari:cari, start:start, end:end, tdata:tdata, dept:dept, area:area, shift:shift, monitor:monitor, functional:functional},
                success:function(data){
                    $('#data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">

                }
            });
        });
    });

</script>



<?php

    //footer
    include_once("../footer.php");
    ?>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $('.view_data').click(function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: '../absensi/modal_monitoring.php',	
                    method: 'post',
                    data: {id:id},		
                    success:function(data){		
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");	// menampilkan dialog modal nya
                    }
                });
            });
        });

    </script>
    <script>
        $( document ).ajaxStart( function() {
            $( "#ajax-wait" ).css({
                left: ( $( window ).width() - 32 ) / 2 + "px", // 32 = lebar gambar
                top: ( $( window ).height() - 32 ) / 2 + "px", // 32 = tinggi gambar
                display: "block"
            })
        }).ajaxComplete( function() {
            $( "#ajax-wait" ).fadeOut();
        });
    </script>
    
    <?php
    include_once("../endbody.php"); 

} else{
echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}