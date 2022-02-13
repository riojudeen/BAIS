<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Portal Data Absensi";
    include_once("../header.php");
    // mysqli_query($link, "DELETE FROM absensi ");
    // mysqli_query($link, "DELETE FROM absensi");
//filtering
    $_SESSION['thn'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
    $_SESSION['startM'] = (isset($_POST['start']))? $_POST['start'] : date('m');
    $_SESSION['endM'] = (isset($_POST['end']))? $_POST['end'] : date('m');
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
    echo $tanggalAwal;
    echo $tanggalAkhir;

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
                                        <select class="form-control" name="" id="">
                                            <option value="">Migrasi Absensi</option>
                                            <option value="">Upload Progress</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4  pr-1 ">
                                    <div class="form-group text-left">
                                        <label for="">Tanggal Mulai</label>
                                        <input name="start" type="text" id="mulai" data-date-format="DD/MM/YYYY" class="form-control datepicker" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group text-left">
                                        <label for="">Tanggal Selesai</label>
                                        <input name="end" type="text" id="selesai" data-date-format="DD/MM/YYYY" class="form-control datepicker" required>
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
                                                <div class="progress-bar bg-success text-right progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 25%"  >
                                                
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <p class="category col-md-6 text-left" id="total_upload">Total 2Mb dari 200mb</p>
                                        <p class="category col-md-6 text-right" id="total_upload">100%</p>
                                    </div>
                                    <div class="row">
                                        <h6 class="title col-md-6">Upload</h6>
                                        <div class="col-md-12" id="process_upload" style="display:block;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-warning text-right progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 25%"  >
                                                
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <p class="category col-md-6 text-left" id="total_upload">Total 2Mb dari 200mb</p>
                                        <p class="category col-md-6 text-right" id="total_upload">100%</p>
                                    </div>
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
                                                        <th scope="row">Total Karyawan</th>
                                                        <td>0</td>
                                                        <th scope="row">Unregistered</th>
                                                        <td>0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class='percent_upload' id='percent_upload'></div>
                                    <span id="success_message_upload"></span>
                                    <div class="form-group" id="process" style="display:none;">
                                        <div class="progress" style="height: 50px;">
                                            <div class="progress-bar persen text-right progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" >
                                            
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <p id="total"></p>
                                    <div class='percent' id='percent'></div>
                                    <span id="success_message"></span>
                                    <form method="post" name="proses" action="" id="form_absensi">
                                        <div class="data_preview " >
                                            
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
                    <a href="../file/Format_absensi_upload.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                        <i class="nc-icon nc-paper"></i>
                    </a>
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
                <div class="row pagin">
                    
                    
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
            
            $('.data_load').on('click', function(e) {
                e.preventDefault();
                var file_data = $('#file_import').prop('files')[0]; 
                var mulai = $('#mulai').val();
                var selesai = $('#selesai').val();
               
                // console.log(form_data);
                if(file_data !== undefined && mulai !== '' && selesai !== ''){
                    // jika form diisi
                    var form_data = new FormData();
                    form_data.append('file_import', file_data);
                        
                    var ajax = new XMLHttpRequest();
                    
                    // console.log(xhr);
                    ajax.upload.addEventListener("progress", uploadHandler, false);
                    ajax.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", 'absensi/index.php?mulai='+mulai+'&selesai='+selesai);
                    ajax.send(form_data);
                    ajax.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200) {
                            // console.log(ajax.responseText);
                            var data = ajax.responseText;
                            const size = new TextEncoder().encode(JSON.stringify(ajax.responseText)).length;
                            console.log(size);
                            const kiloBytes = size / 1024;
                            console.log(kiloBytes);
                            var total = data.result;
                            console.log(data.results[loaded])
                            for (var loaded = 0; loaded < total; loaded++){
                                var obj = data.results[loaded];
                                console.log(obj);
                            }
                            // var percent_complete = (loaded / total)*100;
                            // percent_complete = Math.floor(percent_complete);
                            // var duration = ( new Date().getTime() - startTime ) / 1000;
                            // var bps = loaded / duration;
                            // var kbps = bps / 1024;
                            // kbps = Math.floor(kbps);
                            
                            // var time = (total - loaded) / bps;
                            // var seconds = time % 60;
                            // var minutes = time / 60;
                            
                            // seconds = Math.floor(seconds);
                            // minutes = Math.floor(minutes);
                    
                            // progress.setAttribute("aria-valuemax", total);
                            // progress.setAttribute("aria-valuenow", loaded);
                            // progress.style.width = percent_complete + "%";
                            // progress.innerHTML = percent_complete + "%";
                    
                            // downloadProgressText.innerHTML = kbps + " KB / s" + "<br>" + minutes + " min " + seconds + " sec remaining";
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
                    if (event.lengthComputable) {
                        var percentComplete = event.loaded / event.total;
                        // Do something with download progress
                        console.log(percentComplete);
                    }
                    // hitung prosentase
                    $('#process').css("display","block");
                    var percent = (event.loaded / event.total) * 100;
                    $('.progress-bar').css('width', '0%');
                    $('.progress-bar').css('width', percent + '%')
                    // menampilkan prosentase ke komponen id 'status'
                    document.getElementById("success_message").innerHTML = Math.round(percent)+"% telah terupload";
                    // menampilkan file size yg tlh terupload dan totalnya ke komponen id 'total'
                    document.getElementById("total").innerHTML = "Telah terupload "+bytesToSize(event.loaded)+" bytes dari "+event.total;
                    console.log(event.length);
                    
                }
                function uploadHandler(event){
                    // document.getElementById("total").innerHTML = "Telah terupload "+event.loaded+" bytes dari "+event.total;
                    if (event.lengthComputable) {
                        var percent = (event.loaded / event.total) * 100;
                        console.log(event.total)
                        $('.progress-bar').css('width', percentage + '%');
                        $('.persen').text(percentage + '%');
                        if(percentage > 100)
                        {
                            clearInterval(timer);
                            // $('#upload_data')[0].reset();
                            $('#process').css('display', 'none');
                            $('.progress-bar').css('width', '0%');
                            $('.data_load').attr('disabled', false);
                            $('#success_message').html("<div class='alert alert-success'>Data Imported</div>");
                            setTimeout(function(){
                            $('#success_message').html('');
                            }, 5000);
                        }
                    };
                }
                function completeHandler(event){
                    $('.data_preview').html(event.target.responseText);
                    $('#process').css("display","none");
                }
                function errorHandler(event){
                    $('#success_message').html("Upload Failed");
                }
                function abortHandler(event){
                    $('#success_message').html("Upload Aborted");
                }
                
                // alert(form_data);                             
                
                // function progress_bar_process(percentage, timer)
                // {
                //     $('.progress-bar').css('width', percentage + '%');
                //     $('.persen').text(percentage + '%');
                //     if(percentage > 100)
                //     {
                //         clearInterval(timer);
                //         // $('#upload_data')[0].reset();
                //         $('#process').css('display', 'none');
                //         $('.progress-bar').css('width', '0%');
                //         $('.data_load').attr('disabled', false);
                //         $('#success_message').html("<div class='alert alert-success'>Data Imported</div>");
                //         setTimeout(function(){
                //         $('#success_message').html('');
                //         }, 5000);
                //     }
                // }
            });
            $('.reset').click(function(){
                $('#upload_data')[0].reset();
                $('.data_load').css('display', 'block');
                $('.reset').css('display', 'none');
            })
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.pagin').load("absensi/pagin.php?index=1&start=<?=$tanggalAwal?>&end=<?=$tanggalAkhir?>&sort=1&cari=1");
        })
    </script>
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
