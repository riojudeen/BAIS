<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Data Migration";
    include_once("../header.php");
    
    
    $_SESSION['start'] = (isset($_POST['start']))? dateToDB($_POST['start']) : date('Y-m-1');
    $_SESSION['end'] = (isset($_POST['end']))? dateToDB($_POST['end']) : date('Y-m-d');
    $sM = $_SESSION['start'];
    $eM = $_SESSION['end'];
    // echo $sM."<br>";


    $tanggalAwal = date('Y-m-d', strtotime($sM));
    $tanggalAkhir = date('Y-m-t', strtotime($eM));

    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);
    if($sM <= $eM){
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
    }else{
        $hari = 0;
    }

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    
    $today = date('Y-m-d');

$a = "style=\"border:5px solid #FF7834\"";
$b = "";
$c = "";
include_once('../component/migration-nav.php');
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
                        <input type="text" id="start_date" value="<?=DBtoForm($sM)?>" name="start" data-date-format="DD/MM/YYYY" class="form-control bg-transparent datepicker" >
                        
                        <div class="input-group-prepend ml-0 bg-transparent">
                            <div class="input-group-text px-2 bg-transparent">
                                <i>to</i>
                            </div>
                        </div>
                        <input type="text" name="end" id="end_date"  value="<?=DBtoForm($eM)?>" data-date-format="DD/MM/YYYY" class="form-control bg-transparent datepicker" >
                        
                        <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                        
                    </div>
                    
                    <!-- <div class="col-4">
                        <input class="btn btn-icon btn-round" name="sort" value="go">
                    </div> -->
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 float-right text-right">
                            <ul class="nav nav-pills  nav-pills-primary nav-pills-icons justify-content-end" role="tablist">
                                
                                <li class="nav-item">
                                    <a class="nav-link nav-port " data-toggle="tab" id="nav-ot"  href="#link8" role="tablist">
                                    <i class="nc-icon nc-box"></i> | 
                                    Overtime
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link nav-port port-active active" id="nav-att" data-toggle="tab" href="#link9" role="tablist">
                                    <i class="nc-icon nc-touch-id"></i> | 
                                    Attendace
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </div>
</div>
</form>
<div class="collapse show" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            
            <div class="card card-plain" style="border: 1px #CACACA solid;  border-radius: 15px 15px 15px 15px">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Absensi</h5>
                    <div class="pull-right"> 
                        <a href="../../file/template/Format_absensi_upload.xlsx" class="btn btn-sm btn-danger btn-link" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                            <i class="nc-icon nc-paper"></i> Dowload Format
                        </a> 
                        <a  class="btn btn-sm btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                
                <div class="card-body px-3" >
                    <div class="row " id="tes">
                        <div class="col-lg-6 col-md-4 col-sm-12 ">
                        <form method="POST" id="upload_data" enctype="multipart/form-data" action="proses/import_absensi.php">
                            <h6 class="title">Input Data</h6>
                            <div class="row">
                                <div class="col-md-4  pr-1 ">
                                    <div class="form-group text-left">
                                        <label for="">Mode Upload</label>
                                        <select class="form-control" name="" id="upload_cat">
                                            <option value="absensi_upload">Migrasi Absensi</option>
                                            <option value="overtime_upload">Migrasi Overtime</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4  pr-1 ">
                                    <div class="form-group text-left">
                                        <label for="">Tanggal Mulai</label>
                                        <input name="start" type="text" id="mulai" value="<?=DBtoForm($tanggalAwal)?>" data-date-format="DD/MM/YYYY" class="form-control datepicker" required>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group text-left">
                                        <label for="">Tanggal Selesai</label>
                                        <input name="end" type="text" id="selesai" value="<?=DBtoForm($today)?>"  data-date-format="DD/MM/YYYY" class="form-control datepicker" required>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group border rounded py-auto  text-center col-md-12 ">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0 shadow-none">
                                        <input type="text" class="form-control mx-0">
                                    </div>
                                    <div>
                                        <span class="btn btn-sm btn-outline-default btn-round btn-rose btn-file">
                                        <span class="fileinput-new ">Select File</span>
                                        <span class="fileinput-exists">Change</span>
                                        
                                            <input type="file" id="file_import" name="file_import" />
                                        </span>
                                        <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="button" class="btn btn-sm btn-primary data_load col-md-12" value="Load">
                                    <input type="reset" class="btn btn-sm btn-warning col-md-12 reset " value="Reset" style="display:none;">
                                </div>
                            </div>
                        </div>  
                        </form>                          
                        <div class="col-lg-6 col-md-7 col-sm-12 border-left">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="row">
                                        <h6 class="title col-md-6">Upload</h6>
                                        <div class="col-md-12" id="process_upload" style="display:block;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success text-info progress-bar-striped active persen " role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"  >
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <p class="category col-md-6 text-left" id="total"></p>
                                        <p class="category col-md-6 text-right" id="success_message"></p>
                                    </div>
                                    
                                    
                                    <form method="post" name="proses" action="" id="form_absensi">
                                        <div class="data_preview " >
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class=" table table-xs table-bordered " width="500px">
                                                        <tbody class="py-0">
                                                            <tr class="py-0">
                                                                <th colspan="3" scope="row">Total Hari</th>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" scope="row">Total Baris Data</th>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" scope="row">Total Karyawan</th>
                                                                <td>0</td>
                                                                
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="row ">
	<div class="col-md-12 ">
		<div class="card">
			<div class="card-header">
				<h5 class="title pull-left">Database Absensi</h5>
                <div class="box pull-right">
                    <button class="btn btn-sm btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Import
                    </button>
                    
                    <button  class="btn btn-sm btn-danger  deleteall" >
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove" ></i>
                        </span>
                        Delete
                    </button>
                </div>
			</div>
			<div class="card-body">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="data-monitor">Belum Ada Data</div>

                    </div>
                </div>
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
    //untuk crud masal 
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var current = location.pathname;
        var port_active = $('.port-active').attr('id')
        var getLink = 'proses/prosesAtt.php?manual=1&port='+port_active+'&current='+current;//
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
                document.proses_absensi.action = getLink;
                document.proses_absensi.submit();//proses merubujuk pada atribut name untuk element form
            }
        })
        
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
    <script>
        $(document).ready(function(){
            
            $('.data_load').on('click', function(e) {
                e.preventDefault();
                var file_data = $('#file_import').prop('files')[0]; 
                var mulai = $('#mulai').val();
                var selesai = $('#selesai').val();
                var upload_cat = $('#upload_cat').val();
               
                // console.log(form_data);
                if(file_data !== undefined && mulai !== '' && selesai !== ''){
                    // jika form diisi
                    var form_data = new FormData();
                    form_data.append('file_import', file_data);
                        
                    var ajax = new XMLHttpRequest();
                    
                    // console.log(xhr);
                    ajax.upload.addEventListener("progress", uploadHandler, false);
                    ajax.addEventListener("progress", progressHandler, true);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", 'absensi/index.php?mulai='+mulai+'&selesai='+selesai+'&upload_cat='+upload_cat);
                    ajax.send(form_data);
                    ajax.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {
                            // console.log(ajax.responseText);
                            var data = ajax.responseText;
                            const size = new TextEncoder().encode(JSON.stringify(ajax.responseText)).length;
                            console.log(size);
                            const kiloBytes = size / 1024;
                            document.getElementById("total").innerHTML = "Telah terupload "+bytesToSize(event.loaded);
                        }
                    };
                        
                    
                }else{
                    Swal.fire('Tanggal Belum Diisi atau Dokumen Belum dipilih')
                }
                function bytesToSize(bytes) {
                    var sizes = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
                    if (bytes == 0) return '0 Byte';  
                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                }
                function progressHandler(event){
                    if(event.lengthComputable) {
                        var percentComplete = event.loaded / event.total;
                        // Do something with download progress
                        console.log(percentComplete);
                    }
                    var percent = (event.loaded / event.total) * 100;
                    $('.progress-bar').css('width', '0%');
                    $('.progress-bar').css('width', percent + '%')
                    $('.progress-bar').removeClass('bg-info');
                    $('.progress-bar').addClass('bg-success');
                    $('#success_message').text('sedang mendownload . . .');
                    
                    document.getElementById("total").innerHTML = "Download Data "+bytesToSize(event.loaded);
                    // console.log(event.length);
                    
                }
                function uploadHandler(event){
                    // document.getElementById("total").innerHTML = "Telah terupload "+event.loaded+" bytes dari "+event.total;
                    if (event.lengthComputable) {
                        var percent = (event.loaded / event.total) * 100;
                        console.log(percent)
                        $('.progress-bar').css('width', percent + '%');
                        $('.persen').text(percent + '%');
                        document.getElementById("success_message").innerHTML = Math.round(percent)+"% telah terupload";
                        if(percent > 100){
                            // clearInterval(timer);
                            
                            // $('#upload_data')[0].reset();
                            $('#process').css('display', 'none');
                            $('.progress-bar').css('width', '0%');
                            $('.data_load').attr('disabled', false);
                            setTimeout(function(){
                            $('#success_message').html('');
                            }, 5000);
                        }
                    };
                }
                function completeHandler(event){
                    $('.data_preview').html(event.target.responseText);
                    $('.progress-bar').css('width','100%'); 
                    $('#total').text(''); 
                    $('#success_message').text('data telah siap 100%');
                    $('.progress-bar').removeClass('bg-success');
                    $('.progress-bar').addClass('bg-info');
                    loadData(1);
                }
                function errorHandler(event){
                    $('#success_message').html("Upload Failed");
                }
                function abortHandler(event){
                    $('#success_message').html("Upload Aborted");
                }
                
            });
            $('.reset').click(function(){
                $('#upload_data')[0].reset();
                $('.data_load').css('display', 'block');
                $('.reset').css('display', 'none');
            })
            $(document).on('click', '.nav-port', function(){
                $('.nav-port').removeClass('port-active');
                $(this).addClass('port-active');
                loadData();
            })
            function loadData(page){
                var data_port = $('.port-active').attr('id');
                var div_id = $('#s_div').val();
                var dept_id = $('#s_dept').val();
                var section_id = $('#s_section').val();
                var group_id = $('#s_goupfrm').val();
                var deptAcc_id = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();

                var start = $('#start_date').val();
                var end = $('#end_date').val();
                var dept = $('#deptAcc').val();
                $.ajax({
                    url:"absensi/ajax_monitor.php",
                    method:"GET",
                    data:{data_port:data_port,page:page,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift},
                    success:function(data){
                        $('.data-monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                        
                    }
                })
            }
            loadData()
            $(document).on('click', '.halaman', function(){
                var page = $(this).attr("id");
                loadData(page)
                // console.log(hal)
            });
            $(document).on('click','.check-all', function(){
                if(this.checked){
                    $('.check').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.check').each(function() {
                        this.checked = false;
                    })
                }
            });
            $(document).on('click', '.check', function() {
                if($('.check:checked').length == $('.check').length){
                    $('.check-all').prop('checked', true)
                } else {
                    $('.check-all').prop('checked', false)
                }
            })
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
            $('#filterGo').on('click', function(){
                loadData();
            })
           
        })
    </script>
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>