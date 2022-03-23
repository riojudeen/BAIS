<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Monitor Request Absensi";
$part_lock = "at";
$redirect_lock = base_url()."/dashboard/pages/absensi.php";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    include("../../config/approval_system.php");
    if($level >=1 && $level <=8){
        // mysqli_query($link, "DELETE FROM req_absensi");
        $_SESSION['tahunnn'] = (isset($_SESSION['thn']))? $_SESSION['thn']: date('Y');

        $_SESSION['thn'] = (isset($_GET['tahun']))? $_GET['tahun'] : $_SESSION['tahunnn'];
        $_SESSION['startM'] = (isset($_GET['start']))? $_GET['start'] : date('m');
        $_SESSION['endM'] = (isset($_GET['end']))? $_GET['end'] : date('m');

        
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
            $hari = date_diff($count_awal,$count_akhir)->days +1;
        }else{
            $hari = 0;
        }

        $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
        $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

        $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
        $totalBln = count($bln);


        
        ?>
    <div class="row">
        <div class="col-md-12">
            <div id="sumary"></div>
        </div>
    </div>
    <form method="GET">
    <div class="row">
        <div class="col-md-12" >
            <div class="card bg-transparent" >
                <div class="card-body bg-transparent">
                <div class="row">
                <div class="col-md-5 border-2">
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
                    <div class="col-md-7 border-2 ">
                        <p class="box float-right order-1">
                            <button class="btn btn-icon btn-round btn-default" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                            <i class="nc-icon nc-simple-add "></i>
                            </button>
                        </p>
                        <p class="float-right mr-2">
                            <button data-toggle="modal" data-id="" id="" data-target="#modal" class="btn btn-icon btn-info btn-outline-info btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                                <i class="nc-icon nc-calendar-60 "> </i>
                            </button>
                        </p>
                        
                        
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
    <?php
        // include('monitor.php');
        // require_once('leave_request.php');
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="title " id="mainpage"> Pengajuan Absensi</h5>
                            <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                            <input type="hidden" id="startDate" value="<?=$tanggalAwal?>">
                            <input type="hidden" id="endDate" value="<?=$tanggalAkhir?>">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group no-border">
                                <select class="form-control" name="div" id="s_div">
                                    <option value="">Pilih Divisi</option>
                                </select>
                                <select class="form-control" name="dept" id="s_dept">
                                    <option value="">Pilih Department</option>
                                    <option value="" disabled>Pilih Division Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="section" id="s_section">
                                    <option value="">Pilih Section</option>
                                    <option value="" disabled>Pilih Department Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="groupfrm" id="s_goupfrm">
                                    <option value="">Pilih Group</option>
                                    <option value="" disabled>Pilih Section Terlebih Dahulu</option>
                                </select>
                                <select class="form-control" name="shift" id="s_shift">
                                    <option value="">Pilih Shift</option>
                                    <?php
                                        $query_shift = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query_shift)>0){
                                            while($data = mysqli_fetch_assoc($query_shift)){
                                                ?>
                                                <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data Shift</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="form-control" name="deptacc" id="s_deptAcc">
                                    <option value="">Pilih Department Administratif</option>
                                    <?php
                                        $q_div = mysqli_query($link, "SELECT `id`,`nama_org`,`cord`,`nama_cord` FROM `view_cord_area` WHERE `part` = 'deptAcc'")or die(mysqli_error($link));
                                        if(mysqli_num_rows($q_div) > 0){
                                            while($data = mysqli_fetch_assoc($q_div)){
                                            ?>
                                            <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data Department Administratif</option>
                                            <?php
                                        }
                                    ?>
                                    </select>
                                <div class="input-group-append ">
                                    <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form name="organization" method="POST" class="card-body">
                    <!-- <div class="nav-tabs-navigation "> -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sticker">
                                <h6>Access Control</h6>
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                        <!--  -->
                                        <li class="nav-item ">
                                        
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi active data-active"  data-toggle="tab" data-id="req" href="#result" role="tab" aria-expanded="true"></i>Pengajuan & Konfirmasi</a>
                                        </li>
                                        
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="approve" href="#approved" role="tab" aria-expanded="true">Aproval Monitoring</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="proccess" href="#proccess" role="tab" aria-expanded="true">Admin Proccess Monitoring</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-info org navigasi-absensi"  data-toggle="tab" data-id="success" href="#success" role="tab" aria-expanded="true">Close/Succesed Monitoring</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="my-tab-content" class="tab-content ">
                                <div class="tab-pane active " id="request" role="tabpanel" aria-expanded="true">
                                    
                                    <div id="monitor">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <?php
    // include_once('hr_absensi.php');
    }else{
        include_once ("../../no_access.php");
    }
    include_once("../time_lock/system-lock.php"); 
    include_once("../footer.php");

    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        function getSumary(){
            var id ='req_leave';
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var cari = $('#cari').val();
            var start = $('#startDate').val();
            var end = $('#endDate').val();
            var att_type = $('#att_type').val();
            var prog = $('#att_progress').val();
            $.ajax({
                url: 'approval/ajax/sumary.php',	
                method: 'GET',
                data:{id:id, start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,att_type:att_type,prog:prog,filter:'yes'},		
                success:function(data){
                    $('#sumary').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        getSumary()
        dataActive()
        function dataActive(page){
            if($(".data-active")[0]){
                var div_id = $('#s_div').val();
                var dept_id = $('#s_dept').val();
                var section_id = $('#s_section').val();
                var group_id = $('#s_goupfrm').val();
                var deptAcc_id = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();
                // var start = $('#start_date').val();
                // var end = $('#end_date').val();
                var cari = $('#cari').val();

                var id = $('.data-active').attr('data-id');
                var start = $('#startDate').val();
                var end = $('#endDate').val();
                // console.log(cari);
                // $('#monitor').load("ajax/index.php?id="+id+"&start="+start+"&end="+end);
               
                $.ajax({
                    url:"ajax/index.php",
                    method:"GET",
                    data:{page:page,cari:cari,id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,filter:'yes'},
                    success:function(data){
                        $('#monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                        // $('#data-monitoring').html(data)
                    }
                })
            }
        }
        
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
        
        function get_cek(){
            
            var npk = $('#npk_karyawan').val();
            var mulai = $('#tanggal_mulai').val();
            var jumlah_hari = $('#jumlah_hari').val();
            var code = $('#attendance_code').val();

            // console.log("ok");
            $.ajax({
                url:"ajax/notification.php",
                method:"GET",
                data:{npk:npk,mulai:mulai,total:jumlah_hari,code:code},
                success:function(data){
                    $('.notification').fadeOut('fast', function(){
                        $(this).html(data).fadeIn('fast');
                        get_notifData()
                    });
                    // $('#data-monitoring').html(data)
                }
            })
            // $('.notification').html()
        }
        $(document).on('click', '.cek_data', function(e){
            e.preventDefault();
            get_cek();
        })
        $(document).on('blur', '.data-npk',function(){
            get_cek();
        })
        $(document).on('change', '#attendance_code', function(){
            get_cek();
        })
        $(document).on('change', '#attendance_type', function(){
            get_cek();
        })
        $(document).on('change', '#tanggal_mulai', function(){
            get_cek();
        })
        $(document).on('change', '#jumlah_hari', function(){
            get_cek();
        })
        $(document).on('click', '.reset', function(){
            $('.data-npk').val('');
            get_cek();
        })
        $(document).on('click','.navigasi-absensi', function(){
            $('.navigasi-absensi').removeClass('data-active');
            $(this).addClass('data-active');
            dataActive()
        });
        $(document).on('click', '.halaman', function(){
            var page = $(this).attr("id");
            dataActive(page)
            // console.log(hal)
        });
        // getSumary()
        function getDiv(){
            var data = $('#s_div').val()
            $.ajax({
                url: 'ajax/get_div.php',
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
                url: 'ajax/get_dept.php',	
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
                url: 'ajax/get_sect.php',	
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
                url: 'ajax/get_group.php',
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
        })
        
        $(document).on('click', '.sort', function(){
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();

            var id = $('.data-active').attr('data-id');
            var start = $('#startDate').val();
            var end = $('#endDate').val();
            var sort = $("#dataSort").serialize()
            var page = $('.page_active').attr('id');
            console.log(sort);
            // dataActive(page)
            $.ajax({
                            
                url:"ajax/index.php?page="+page+"&id="+id+"&start="+start+"&end="+end+"&div="+div_id+"&dept="+dept_id+"&sect="+section_id+"&group="+group_id+"&deptAcc="+deptAcc_id+"&shift="+shift+"&filter=yes",
                method:"GET",
                data:sort,
                success:function(data){
                    $('#monitor').fadeOut('fast', function(){
                        $(this).html(data).fadeIn('fast');
                    });
                }
            })
        })
        $('.checkOne').on('click', function() {
            if($('.checkOne:checked').length == $('.checkOne').length){
                $('.checkAll').prop('checked', true)
            } else {
                $('.checkAll').prop('checked', false)
            }
        })
        $(document).on('click', '.remove', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan dihapus permanent",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#CB4335',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{del:data},
                        success:function(){
                            dataActive(page)
                            // getSumary()
                            success('Dihapus','data pengajuan telah dihapus, silakan ajukan kembali');
                        }
                    })
                }
            })
        
        });
        function success(data1,data2){
            Swal.fire({
                title: data1,
                text: data2,
                timer: 2000,
                
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
                
            })
        }
    })
    </script>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('.view_data').click(function(){
                var id = $(this).parents("tr").attr("id");
                
                
                $.ajax({
                    url: 'ajax/view.php',	
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
    
    $(document).on('keyup', '.data-npk',function(){
        var npk = $(this).val();
        
        $.ajax({
            url: 'ajax/get_resource.php',
            method: 'get',
            data: {data:npk},
            success:function(data){
                var obj = $.parseJSON(data);
                var total = obj.msg[0].total;
                var msg = obj.msg[0].msg;
                if(total > 0){
                    var nama = obj.data[0].nama;
                    var status = obj.data[0].status;
                    var jabatan = obj.data[0].jabatan;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#prosesrequest').removeClass("d-none");
                    // $('#cek_data').removeClass("d-none");
                    // $('#cek_data').prop("disabled", false);
                    
                }else if(total === 0){
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#prosesrequest').addClass("d-none", true);
                    // $('#cek_data').addClass("d-none");
                }else{
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#prosesrequest').addClass("d-none", true);
                    // $('#prosesrequest').prop("disabled", true);
                    // $('#cek_data').addClass("d-none");
                }
            }
        })
    })
</script>
<?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>