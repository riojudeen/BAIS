<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Working Hours Setting";
    include_once("../../header.php");
    if(isset($_POST['go'])){
        $_SESSION['tahun'] = $_POST['year'];
        $year = $_SESSION['tahun'];
    }else{
        $year = date('Y');
    }
    
?>
<di class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title pull-left">Monitor Perubahan Shift Karyawan</h5>
                <div class="box pull-right">
                   
                    <a href="proses/export.php?export=mp" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </a>
                    <a href="../index.php" class="btn btn-default" name="shift" data-toggle="tooltip" data-placement="bottom" title="Penjadwalan Shift">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-resposive">
                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>NPK</th>
                            <th>Nama</th>
                            <th>Shift Asal</th>
                            <th>Shift Baru</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>PIC</th>
                            <th>Tanggal Proses</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT shift_record.no AS `no`,
                            shift_record.npk AS npk,
                            shift_record.shift_asal AS shift_asal,
                            shift_record.shift_baru AS shift_baru,
                            shift_record.tgl_mulai AS mulai,
                            shift_record.tgl_akhir AS akhir,
                            shift_record.requester AS pic,
                            shift_record.tgl_request AS tgl_request,
                            
                            karyawan.nama AS nama
                            
                            FROM shift_record JOIN karyawan ON karyawan.npk = shift_record.npk";

                            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                            if(mysqli_num_rows($sql) > 0){
                                while($datashift = mysqli_fetch_assoc($sql)){
                                    ?>
                                    <tr>
                                        <td><?=$datashift['no']?></td>
                                        <td><?=$datashift['npk']?></td>
                                        <td><?=$datashift['nama']?></td>
                                        <td><?=$datashift['shift_asal']?></td>
                                        <td><?=$datashift['shift_baru']?></td>
                                        <td><?=DBtoForm($datashift['mulai'])?></td>
                                        <td><?=DBtoForm($datashift['akhir'])?></td>
                                        <td><?=$datashift['nama'].' ['.$datashift['npk'].']'?></td>
                                        <td><?=DBtoForm($datashift['tgl_request'])?></td>

                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
    </div>
</di>


<!-- halaman utama end -->
<?php
    include_once("../../footer.php"); 
    //javascript
    ?>
    <script src="../../assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="../../assets/js/plugins/fullcalendar/daygrid.min.js"></script>
    <script src="../../assets/js/plugins/fullcalendar/timegrid.min.js"></script>
    <script src="../../assets/js/plugins/fullcalendar/interaction.min.js"></script>
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
    
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
