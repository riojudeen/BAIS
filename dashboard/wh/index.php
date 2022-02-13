<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Working Hours Setting";
    include_once("../header.php");
    if(isset($_POST['go'])){
        $_SESSION['tahun'] = $_POST['year'];
        $year = $_SESSION['tahun'];
    }else{
        $year = date('Y');
    }
    
?>
<?php
// require_once('wd/index.php');
?>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade bd-example-modal-lg" id="dataexport" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="wd/ajax/export.php" method="GET" id="RangeValidation">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <h5 class="title text-left">Export Data</h5>
                        </div>
                        <div class="modal-body px-3">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label for="">Tanggal Mulai</label>
                                    <div class="form-group">
                                        <input type="hidden" name="export" value="wh" class="form-control">
                                        <input type="text" name="start_date" class="form-control datepicker" data-date-format="DD/MM/YYYY">
                                    </div>
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="">Tanggal Selesai</label>
                                    <div class="form-group">
                                        <input type="text" name="end_date" class="form-control datepicker" data-date-format="DD/MM/YYYY">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-12">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="exp" class="btn btn-info btn-link">Export Data</button>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header">
                <div class="row">
                    <h5 class="title pull-left col-md-6" id="mainpage"> Working Scheme Setting</h5>
                    <div class="col-md-6 text-right">
                        <div class="dropleft ">
                            <button class="btn btn-sm btn-link btn-default btn-outline-default btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                <div class="dropdown-header">Menu</div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataexport">Export Data</a>                    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <form name="organization" method="POST" class="card-body">
                <!-- <div class="nav-tabs-navigation "> -->
                <div class="row">
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker" >
                            <h6>Access Control</h6>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-ws data-active active" data-name="Working Shift"  data-toggle="tab" data-id="ws" href="#ws" role="tab" aria-expanded="true">Working Shift</a>
                                    </li>
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-wh " data-name="Working Hours"  data-toggle="tab" data-id="wh" href="#wh" role="tab" aria-expanded="true">Working Hours</a>
                                    </li>
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-b " data-name="Working Break" data-toggle="tab" data-id="b" href="#b" role="tab" aria-expanded="true">Working Break</a>
                                    </li>
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-wb " data-name="Working Break" data-toggle="tab" data-id="wb" href="#wb" role="tab" aria-expanded="true">Working Break / Shift</a>
                                    </li>
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-hl" data-name="Holidays" data-toggle="tab" data-id="holiday" href="#holiday" role="tab" aria-expanded="true">Holidays</a>
                                    </li>
                                    <li class="nav-item ">
                                         <a class="btn btn-sm btn-link btn-round btn-info org navigasi-wd" data-name="Working Days" data-toggle="tab" data-id="wd" href="#wd" role="tab" aria-expanded="true">Working Days</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <h6 class="pagename">Access Control</h6>
                        
                        <div id="monitor"></div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>


<!-- halaman utama end -->
<?php
    include_once("../footer.php"); 
    //javascript
    ?>
    <script src="../assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="../assets/js/plugins/fullcalendar/daygrid.min.js"></script>
    <script src="../assets/js/plugins/fullcalendar/timegrid.min.js"></script>
    <script src="../assets/js/plugins/fullcalendar/interaction.min.js"></script>
    <script>
    $(document).ready(function() {
      demo.initFullCalendar();
    });
  </script>
    <script>
    //untuk crud masal update department
    $('.deleteall').on('click', function(e){
        e.preventDefault();
        var getLink = 'proses/prosesAtt.php';
            
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
    $('.editall').on('click', function(e){
        e.preventDefault();
        var getLink = 'massEditAtt.php';

        document.proses.action = getLink;
        document.proses.submit();
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
                document.location.href=getLink;
            }
        })
        
    });
    </script>
    <script>
    // $("#datepicker").datepicker( {
    //     format: " mm",
    //     viewMode: "months", 
    //     minViewMode: "months",
    //     defaultViewDate : "month"

    // });
    </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'wd/detail.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#exp').click(function(){
            $('#dataexport').modal('hide');
        });
    });
</script>
<script>
    $(document).ready(function(){
        if($(".data-active")[0]){
            var name = $(".data-active").attr('data-name');
            var id = $(".data-active").attr('data-id');
            console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("shiftsettings/working_shift.php?id="+id);
        }
        $('.navigasi-ws').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("shiftsettings/working_shift.php?id="+id);
        })
        $('.navigasi-hl').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("holidays/index.php?id="+id);
        })
        $('.navigasi-wh').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("workingHour/index.php?id="+id);
        })
        $('.navigasi-b').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("workingbreak/working_break.php?id="+id);
        })
        $('.navigasi-wb').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("workingbreak/index.php?id="+id);
        })
        $('.navigasi-wd').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            // console.log(id)
            $('.pagename').text(name);
            $('#monitor').load("wd/wd.php?id="+id);
        })
       
    })
</script>

    
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
