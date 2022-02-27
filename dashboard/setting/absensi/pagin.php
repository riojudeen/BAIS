<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
if(isset($_SESSION['user'])){
    $tanggalAwal = $_GET['start'];
    $tanggalAkhir = $_GET['end'];
    $totalHari = hitungHari($tanggalAwal, $tanggalAkhir);
    $sort = 10;
    $no = 1;
    
    $sqlAtt = mysqli_query($link, "SELECT view_organization.npk AS `npk`,
    view_organization.nama AS `nama`, 
    view_organization.dept_account AS `dept_account`,
    view_organization.shift AS `shift`,
    absensi.date AS `work_date`,
    absensi.date_in AS `in_date`,
    absensi.date_out AS `out_date`,
    absensi.check_in AS `check_in`,
    absensi.check_out AS `check_out`,
    absensi.ket AS `ket`,
    karyawan.nama AS `requester`
    
    FROM view_organization
    JOIN absensi ON view_organization.npk = absensi.npk 
    JOIN karyawan ON karyawan.npk = absensi.requester
    
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' ")or die(mysqli_error($link));
    $total = mysqli_num_rows($sqlAtt);
    $data = mysqli_fetch_assoc($sqlAtt);
    $hal = 6;
    ?>
    <div class="col-md-9">
        <div class="row">
            <span class="col-md-2 pr-1">
                <label for="">Data Sort</label>
                <div class="form-group-sm">
                    <input type="number" class="form-control" id="sort" placeholder="sort" value="<?=$sort?>" readonly>
                </div>
            </span>
            <span class="col-md-2 pl-1">
                <label for="">Total Data</label>
                <div class="form-group-sm">
                    <input type="number" class="form-control" placeholder="sort" value="<?=$total?>" readonly>
                </div>
            </span>
            <div class="col-md-4 border-left">
                <label for="">Halaman</label>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" id="first" href="#link" aria-label="Previous" data-id="1">
                            <span aria-hidden="true">FIRST</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" id="prev" href="#link" aria-label="Previous">
                            <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <input type="number" id="now" class="form-control" value="1">
                    </li>
                    <li class="page-item ">
                        <a class="page-link" id="next"  href="#link" aria-label="Next" >
                            <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                        </a>
                    </li>
                    <li class="page-item" >
                        <a class="page-link" id="last" href="#link" aria-label="Next" data-id="<?=$hal?>">
                            <span aria-hidden="true">LAST</span>
                        </a>
                    </li>
                </ul>
            </div>
            <span class="col-md-2 pl-1">
                <label for="">Total Halaman</label>
                <div class="form-group-sm">
                    <input type="number" class="form-control" placeholder="sort" value="<?=$hal?>" readonly>
                </div>
            </span>
            
        </div>
    </div>
    <span class="col-md-3 text-right">
        <label class="text-left" for="">Cari Data</label>
        <!-- <div class="input-group no-border">
            <input type="text" id="cari" value="" class="form-control" placeholder="Cari data..">
            <div class="input-group-append">
            <div class="input-group-text">
                <i class="nc-icon nc-zoom-split"></i>
            </div>
            </div>
        </div> -->
        <div class="input-group no-border">
            <select name="cari" id="cari"  class="form-control">
                <option value="">BODY 1</option>
                <option value="">BODY 2</option>
                <option value="">BQC</option>
                <option selected value="">Tidak Dipilih</option>
            </select>
            <div class="input-group-append">
            <div class="input-group-text">
                <i class="nc-icon nc-zoom-split"></i>
            </div>
            </div>
        </div>
    </span>   
    <script>
        $(document).ready(function(){
            

            $('#sort').on('change', function(){
                var sort = $(this).val();
                var cari = $('#cari').val();
                var now = $('#now').val();
                var last = $('#last').val();
                var first = $('#first').val();
            })
            
            $('#next').on('click', function(){
                var sort = $('#sort').val();
                var first = $('#first').attr('data-id');
                var last = $('#last').attr('data-id');
                var cari = $('#cari').val();
                var now = $('#now').val();
                var next = Number(now)+Number('1');
                var url = "absensi/ajax_monitor.php?index="+next+"&start=<?=$tanggalAwal?>&end=<?=$tanggalAkhir?>&sort="+sort+"&cari="+cari;
                loadData('data-monitor', url);
                // console.log(url)
                // console.log(last)
                // console.log(next);
                $('#now').val(next);
                
                if(Number(next)>=Number(last)){
                    // console.log("OK")
                    $('#next').parent().addClass('disabled')
                    $('#last').parent().addClass('disabled')
                }else if((Number(now)+Number(1))>Number(first)){
                    $('#prev').parent().removeClass('disabled')
                    $('#first').parent().removeClass('disabled')
                }


            })
            $('#prev').on('click', function(){
                var sort = $('#sort').val();
                var first = $('#first').attr('data-id');
                var last = $('#last').attr('data-id');
                var cari = $('#cari').val();
                var now = $('#now').val();
                var prev = Number(now)-Number('1');
                var url = "absensi/ajax_monitor.php?index="+prev+"&start=<?=$tanggalAwal?>&end=<?=$tanggalAkhir?>&sort="+sort+"&cari="+cari;
                loadData('data-monitor', url);
                // console.log(url)
                // console.log(first)
                // console.log(prev);
                $('#now').val(prev);
                if(Number(prev)<=Number(first)){
                    // console.log("OK")
                    $('#prev').parent().addClass('disabled')
                    $('#first').parent().addClass('disabled')
                }else if((Number(now)-Number(1))<Number(last)){
                    
                    $('#next').parent().removeClass('disabled')
                    $('#last').parent().removeClass('disabled')
                }
            })
            $('#now').on('change', function(){
                var sort = $('#sort').val();
                var first = $('#first').attr('data-id');
                var last = $('#last').attr('data-id');
                var cari = $('#cari').val();
                var now = $(this).val();
                var url = "absensi/ajax_monitor.php?index="+now+"&start=<?=$tanggalAwal?>&end=<?=$tanggalAkhir?>&sort="+sort+"&cari="+cari;
                // console.log("OK");
                if(Number(now)>Number(first) && Number(now)<Number(last)){
                    $('#prev').parent().removeClass('disabled')
                    $('#first').parent().removeClass('disabled')
                    $('#last').parent().removeClass('disabled')
                    $('#next').parent().removeClass('disabled')
                    
                }else{
                    if(Number(now)>=Number(last)){
                        $('#next').parent().addClass('disabled')
                         $('#last').parent().addClass('disabled')
                    }else if(Number(now)<=Number(first)){
                        $('#prev').parent().addClass('disabled')
                        $('#first').parent().addClass('disabled')
                    }
                }
                loadData('data-monitor', url);
            })
           
            var sort = $('#sort').val();
            var cari = $('#cari').val();
            var now = $('#now').val();
            var last = $('#last').val();
            var first = $('#first').val();
            var url = "absensi/ajax_monitor.php?index="+now+"&start=<?=$tanggalAwal?>&end=<?=$tanggalAkhir?>&sort="+sort+"&cari="+cari;
            function loadData(target, url){
                $('.'+target).load(url);
            }
            loadData('data-monitor',url)
            
            
        })
    </script>
<?php
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
    ?>