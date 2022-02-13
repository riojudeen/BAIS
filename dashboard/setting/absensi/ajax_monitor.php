<?php
require_once("../../../config/config.php");
require "../../../_assets/vendor/autoload.php";
if(isset($_SESSION['user'])){
    
    $tanggalAwal = $_GET['start'];
    $tanggalAkhir = $_GET['end'];
    $sort = $_GET['sort'];
    $page = $_GET['index'];
    $cari = $_GET['cari'];
    $sqlAbs = mysqli_query($link, "SELECT view_organization.npk AS `npk`,
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
        
        WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir'")or die(mysqli_error($link));
        $jml = mysqli_num_rows($sqlAbs);
        $jml_hal = ceil($jml / $sort);
        echo $jml;



    // $cari = (@$_GET['cari'] != '') ? @$_GET['cari'] : "";
    // $index_hal = 2;
    // $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
    // $next = $hal + 1;
    

    ?>
    <form method="post" name="proses" action="" id="form_absensi">
        <?php
    $total = mysqli_num_rows(mysqli_query($link, "SELECT * FROM absensi WHERE `date` BETWEEN '$tanggalAwal' AND '$tanggalAkhir' LIMIT $sort"))
    ?>
    <div class="table-responsive">
        <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NPK</th>
                    <th>Nama</th>
                    <th>Shift</th>
                    <th>Dept</th>
                    <th>Tanggal Kerja</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Pulang</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Ket</th>
                    <th>Diupdate Oleh</th>
                    <th class="text-right">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="allcek">
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($cari == ""){
            $no = 1;
            $mulai = ($page <= 1)?0:$page - 1;
            $offset = $mulai * $sort;
            // page 1 --> start offset 0
            // page > 1 --> start offset page*sort - 1
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
            
            WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' LIMIT $offset,  $sort ")or die(mysqli_error($link));
            
            // echo mysqli_num_rows($sqlAtt);
            if(mysqli_num_rows($sqlAtt) > 0){
                while($dataAtt = mysqli_fetch_assoc($sqlAtt)){
                    $check_in = ($dataAtt['check_in'] == "00:00:00")?"-": jam($dataAtt['check_in']);
                    $check_out = ($dataAtt['check_out'] == "00:00:00")?"-": jam($dataAtt['check_out']);
            ?>
            
                <tr>
                    <td><?=$no?></td>
                    <td><?=$dataAtt['npk']?></td>
                    <td><?=$dataAtt['nama']?></td>
                    <td><?=$dataAtt['shift']?></td>
                    <td><?=$dataAtt['dept_account']?></td>
                    <td><?=hari_singkat($dataAtt['work_date']).", ".DBtoForm($dataAtt['work_date'])?></td>
                    <td><?=DBtoForm($dataAtt['in_date'])?></td>
                    <td><?=DBtoForm($dataAtt['out_date'])?></td>
                    <td><?=$check_in?></td>
                    <td><?=$check_out?></td>
                    <td><?=$dataAtt['ket']?></td>
                    <td><?=$dataAtt['requester']?></td>
                    

                    <td class="text-right">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="<?=$dataAtt['id']?>">
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>
                </tr>
            <?php
                $no++;
                }
            }else{
                echo "<td class=\"text-center\" colspan=\"13\">Tidak ditemukan data di database</td>";
            }
        }else{
            echo "pencarian";
        }
            ?>
        </tbody>
        
    </table>
</div>

<label for="" class="text-danger">
<?=$page?> / 
    <span id="hal"><?=$jml_hal?></span>
</label>

<hr>
<div class="box pull-right">
    <button  class="btn btn-danger  deleteall" >
        <span class="btn-label">
            <i class="nc-icon nc-simple-remove" ></i>
        </span>    
        Delete
    </button>

</div>
</form>

<?php
    
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
    ?>
    