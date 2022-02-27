<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Portal Data Absensi";
    include_once("../../header.php");
    
    
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

?>
<!-- halaman utama -->
<!-- filter -->

<div id="load_trigger" data-id="0"></div>
<div class="collapse show" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            
            <div class="card card-plain" style="border: 1px #CACACA solid;  border-radius: 15px 15px 15px 15px">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Absensi</h5>
                    <div class="pull-right"> 
                        
                    </div>
                </div>
                <hr>
                
                <div class="card-body px-3" >
                    <div class="row " id="tes">
                         
                        <div class="col-lg-12 col-md-12 col-sm-12 border-left">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="row">
                                        <h6 class="title col-md-6">Progress</h6>
                                        <div class="col-md-12" id="process_upload" style="display:block;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success text-info progress-bar-animated progress-bar-striped active persen " role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 50px"  >
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <p class="category col-md-6 text-left" id="total"></p>
                                        <p class="category col-md-6 text-right" id="success_message"></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-4 col-sm-12 ">
                                            <form method="POST" id="upload_data" enctype="multipart/form-data" action="proses/import_absensi.php">
                                                <h6 class="title">Input Data</h6>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="button" class="btn btn-sm btn-primary data_load col-md-12" value="Load">
                                                    </div>
                                                </div>
                                            </form>                          
                                        </div> 

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
                
            </div>
                
            </div>
        </div>
    </div>
</div>
</form>
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
                    
                    <a href="proses/export.php?export=mp" class="btn btn-sm btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </a>
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
    include_once("../../footer.php"); 
    //javascript
    ?>

    <script>
    //untuk crud masal 
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'proses/prosesAtt.php';//
            
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
                document.proses.submit();//proses merubujuk pada atribut name untuk element form
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
            
            
        })
    </script>
    <script>
        $(document).ready(function(){

            function triggerLoad(val){
                var trigger = 1;
                if(val == trigger){
                    upload_data();
                }
            }
            
            $('.data_load').on('click', function(e) {
                e.preventDefault(); 
                upload_data();
            });
            $('.reset').click(function(){
                $('#upload_data')[0].reset();
                $('.data_load').css('display', 'block');
                $('.reset').css('display', 'none');
            })
            function upload_data(){
                var ajax = new XMLHttpRequest();
                
                // console.log(xhr);
                ajax.upload.addEventListener("progress", uploadHandler, false);
                ajax.addEventListener("progress", progressHandler, true);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", 'migrate.php');
                ajax.send();
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
                // }else{
                //     Swal.fire('Tanggal Belum Diisi atau Dokumen Belum dipilih')
                // }
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
                    $('.progress-bar').removeClass('bg-info');
                    $('#success_message').text('sedang mendownload . . .');
                    $('.progress-bar').addClass('bg-success');
                    
                    setTimeout(function (){
                        $('.progress-bar').css('width', percent + '%')
                    },5000);
                    
                    
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
                    setTimeout(function (){
                        $('.progress-bar').removeClass('bg-info');
                        $('.progress-bar').css('width', '0%');
                    },5000);
                    // loadData();
                }
                function errorHandler(event){
                    $('#success_message').html("Upload Failed");
                }
                function abortHandler(event){
                    $('#success_message').html("Upload Aborted");
                }
            }






            function loadData(page){
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
                    url:"../absensi/ajax_monitor.php",
                    method:"GET",
                    data:{page:page,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift},
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
                    url: '../ajax/get_div.php',
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
                    url: '../ajax/get_dept.php',	
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
                    url: '../ajax/get_sect.php',	
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
                    url: '../ajax/get_group.php',
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
            var link = document.getElementsByClassName('data_load');
            var load = 0;
            var approval_num = setInterval(function ()
                { 
                    const load1 = 6 * 60 + 30;
                        const load2 =  7 * 60 + 0;                 
                    const load3 = 7 * 60 + 30;
                        const load4 =  8 * 60 + 30;
                    const load5 = 9 * 60 + 0;
                        const load6 =  16 * 60 + 0;
                    const load7 = 16 * 60 + 30;
                        const load8 =  17 * 60 + 0;
                    const load9 = 17 * 60 + 30;
                        const load10 =  18 * 60 + 0;
                    const load11 = 18 * 60 + 30;
                        const load12 =  19 * 60 + 0;                 
                    const load13 = 19 * 60 + 48;
                        const load14 =  20 * 60 + 0;
                    const load15 = 20 * 60 + 30;
                        const load16 =  21 * 60 + 0;
                    const load17 = 21 * 60 + 30;
                        const load18 =  22 * 60 + 0;
                    const load19 = 22 * 60 + 30;
                        const load20 =  23 * 60 + 0;
                    const load21 = 4 * 60 + 0;
                        const load22 =  4 * 60 + 30;                 
                    const load23 = 5 * 60 + 0;
                        const load24 =  5 * 60 + 30;
                    const load25 = 6 * 60 + 0;

                    const batas = 20;
                    
                    const date = new Date(); 
                    const now = date.getHours() * 60 + date.getMinutes();
                    // console.log(now);
                    if((load1 == now ) || 
                        (load2 == now ) || 
                        (load3 == now ) || 
                        (load4 == now ) || 
                        (load5 == now ) || 
                        (load6 == now ) || 
                        (load7 == now ) || 
                        (load8 == now ) || 
                        (load9 == now ) || 
                        (load10 == now ) || 
                        (load11 == now ) || 
                        (load12 == now ) || 
                        (load13 == now ) || 
                        (load14 == now ) || 
                        (load15 == now ) || 
                        (load16 == now ) || 
                        (load17 == now ) || 
                        (load18 == now ) || 
                        (load20 == now ) || 
                        (load21 == now ) || 
                        (load22 == now ) || 
                        (load23 == now ) || 
                        (load24 == now ) || 
                        (load25 == now ) 
                       )
                    {
                       
                        load++;
                        triggerLoad(load)
                        
                        $('#load_trigger').attr('data-id', "1");
                        $('#load_trigger').text('data-id 1');
                        
                    }else{
                        $('#load_trigger').attr('data-id', "0");
                        $('#load_trigger').text('data-id 0');
                        // console.log('0')
                        load = 0;
                        
                    }
                }, 1000 // refresh every 10000 milliseconds
            );   
            
        })
    </script>
    <?php
    
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>