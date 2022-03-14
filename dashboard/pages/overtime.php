<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 
include("../../config/schedule_system.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitoring Kehadiran";
if(isset($_SESSION['user'])){
    include_once("../header.php");
    $_SESSION['now'] = $tanggalSekarang = date('Y-m-d');

    $_SESSION['startD'] = (isset($_GET['start']))? dateToDB($_GET['start']) : date('Y-m-d');
    $_SESSION['endD'] = (isset($_GET['end']))? dateToDB($_GET['end']) : date('Y-m-d');

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
    

?>

  
<div class="row" >
    <div class="modal fade"  id="myView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl  modal-dialog-scrollable" >
            <div class="modal-content px-0" id="view_data">
                <h5>please wait</h5>
            </div>
        </div>
    </div>
</div>
           

<div class="row">
    <div class="col-md-12" id="summary"></div>
</div>

<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
                <div class="row">
                    <form method="GET" class="col-md-5 border-2">
                        
                        <div class="input-group border-2 bg-transparent no-border">
                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <input type="text" name="start" id="start_date" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAwal)?>">
                                
                            <div class="input-group-prepend ml-0 bg-transparent">
                                <div class="input-group-text px-2 bg-transparent">
                                    <i>to</i>
                                </div>
                            </div>
                            <input type="text" name="end" id="end_date"  class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAkhir)?>">
                            
                            <input type="submit" name="sort" class="btn-icon btn-sm btn btn-round p-0 ml-2 my-auto " value="go" >
                            
                        </div>
                    </form>
                    <div class="col-md-3"></div>
                    <div class="col-md-4 border-2 my-auto">
                        <div class="row">
                            <div class="col-md-8 px-0">
                                <div class="form-group-sm no-border">
                                    <input type="text" name="cari" id="cari"  class="form-control bg-transparent" placeholder="Cari nama atau npk..">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <button id="monitor_view" class="vw-active vw btn btn-sm btn-link btn-primary active btn-magnify my-auto "><i class="fas fa-th-list"></i></button>
                                <button id="callendar_view" class="vw btn vw btn-sm btn-link  btn-primary btn-magnify my-auto"> <i class="nc-icon nc-calendar-60"></i></button>

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
<?php
    include_once('../ot/monitoring.php');
    include_once("../footer.php");
    ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            function modalActive(data,page){
                var id = 'modal';
                var div_id = $('#s_div').val();
                var dept_id = $('#s_dept').val();
                var section_id = $('#s_section').val();
                var group_id = $('#s_goupfrm').val();
                var deptAcc_id = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                var cari = $('#cari').val();
                
                // console.log(page);
                $.ajax({
                    url: '../ot/ajax/monitoring-overtime.php',	
                    method: 'GET',
                    data: {page:page, data:data,cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift},		
                    success:function(data){		
                        	// menampilkan dialog modal nya
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");
                    }
                });
            }
            $(document).on('click','.view_data',function(e){
                var data = $(this).attr("id");
                modalActive(data,'1')
                
            });
            $(document).on('click', '.halaman_modal', function(){
                var page = $(this).attr("id");
                var data = $(this).attr('data-id');
                console.log(data);
                modalActive(data,page)
                // console.log(hal)
            });
        });

    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.tb_absensi', function(){
            
            $("#tb_absensi").table2excel({
                // exclude: ".noExl",
                name: "data",
                filename: "Data Absensi",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true,
                preserveColors: true //tampilan
            })
        })
        $(document).on('click', '.vw', function(){
            var page = $('.page_active').attr('id');
            $('.vw').removeClass('vw-active')
            $('.vw').removeClass('active')
            $(this).addClass('active')
            $(this).addClass('vw-active')
            dataActive(page)
        })
        dataActive()
        
        function dataActive(page){
            if(page=='undefined' || page=='' ){
                var page = $('.page_active').attr('id');
            }else{
                var page = page
            }
            
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();
            var cari = $('#cari').val();
            var id = $('.vw-active').attr('id');
            
            // console.log(page);
            $.ajax({
                url:"../ot/ajax/monitoring-overtime.php",
                method:"GET",
                data:{page:page,cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift},
                beforeSend:function(){$(".spinner_load").css("display","block").fadeIn('slow');},
                success:function(data){
                    // console.log('success')
                    $('#monitor').fadeOut('fast', function(){
                        $(".spinner_load").css("display","none")
                        $(this).html(data).fadeIn('fast');
                    });
                    // $('#data-monitoring').html(data)
                }
            })
        }
        function getSummary(){
            
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();
            var cari = $('#cari').val();
            var id = 'summary';
            // console.log(start);
            
            $.ajax({
                url:"../ot/ajax/monitoring-overtime.php",
                method:"GET",
                data:{cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift},
                success:function(data){
                    console.log('success')
                    $('#summary').fadeOut('fast', function(){
                        $(this).html(data).fadeIn('fast');
                    });
                    // $('#data-monitoring').html(data)
                }
            })
        }
        getSummary()
        function get_notifData(){
            var data = $('#notification_result').attr('data-id');
            // console.log(data)
            if(data == '1'){
                $('#prosesrequest').prop('disabled', false )
            }else if(data == '0'){
                $('#prosesrequest').prop('disabled', true )
            }else{
                $('#prosesrequest').prop('disabled', true )
            }
            
        }
        get_notifData()
        
        $(document).on('click', '.halaman', function(){
            var page = $(this).attr("id");
            dataActive(page)
            // console.log(hal)
        });
       
        // getSumary()
        function getDiv(){
            var data = $('#s_div').val()
            $.ajax({
                url: '../ot/ajax/get_div.php',
                method: 'GET',
                data: {data:data},		
                success:function(data){
                    $('#s_div').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getDept(){
            var data = $('#s_div').val()
            $.ajax({
                url: '../ot/ajax/get_dept.php',	
                method: 'GET',
                data: {data:data},
                success:function(data){
                    $('#s_dept').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    // console.log(data)
                }
            });
        }
        function getSect(){
            var data = $('#s_dept').val()
            $.ajax({
                url: '../ot/ajax/get_sect.php',	
                method: 'GET',
                data: {data:data},		
                success:function(data){
                    $('#s_section').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getGroup(){
            var data = $('#s_section').val()
            $.ajax({
                url: '../ot/ajax/get_group.php',
                method: 'GET',
                data: {data:data},
                success:function(data){
                    $('#s_goupfrm').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                }
            });
        }
        getDiv()
        $('#s_div').on('change', function(){
            getDept()
            getSect()
            getGroup()
        })
        $('#s_dept').on('change', function(){
            getSect()
            getGroup()
        })
        $('#s_section').on('change', function(){
            getGroup()
        })
        $(document).on('blur', '#cari', function(){
            // var cari = $(this).val()
            dataActive()
            // console.log(cari);
        });
        $('#filterGo').on('click', function(){
            dataActive();
            getSummary()
        })
        
        
        
    })
    </script>

<?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>

