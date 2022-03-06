<!-- Modal -->
<?php
include("../../config/config.php"); 
if(isset($_POST['id'])){
    $modalTitle = "Data Karyawan ".$_POST['id'];
    $sD = $_SESSION['startD'];
    $eD = $_SESSION['endD'];
   
    $tanggalAwal = date('Y-m-d', strtotime($sD));
    // echo "tanggal awal : ".$tanggalAwal."<br>";
    $tanggalAkhir = date('Y-m-d', strtotime($eD));
    // echo "tanggal akhir : ". $tanggalAkhir."<br>";
    $t = "org.".$org_access;
    $qryAbsenHr = "SELECT absensi.id AS id_absen,
    absensi.npk AS npk_absen, 
    absensi.shift AS shift_absen,
    absensi.date AS tanggal,
    absensi.check_in AS check_in,
    absensi.check_out AS check_out,
    absensi.ket AS ket,
    
    attendance_code.kode AS kode_absen,
    attendance_code.keterangan AS ket_kode_absen,
    attendance_code.type AS tipe_kode_absen,

    groupfrm.id_group AS idGroup,
    groupfrm.nama_group AS groupfrm,
    groupfrm.npk_cord AS group_cord,
    groupfrm.id_section AS id_sect,

    dept_account.id_dept_account AS idDeptAcc,
    dept_account.department_account AS deptAcc,
    dept_account.npk_dept AS mg, 
    dept_account.id_div AS id_div,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    LEFT JOIN attendance_code ON attendance_code.kode = absensi.ket 
    JOIN org ON org.npk = karyawan.npk
    JOIN groupfrm ON groupfrm.id_group = org.grp
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
  
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $t = '$access_' ";
    $q_masuk = $qryAbsenHr." AND (absensi.check_in <> '00:00:00' OR absensi.check_out <> '00:00:00' OR absensi.ket = 'WFH') ";
    $q_mangkir = $qryAbsenHr." AND attendance_code.kode = 'M' ";
    $q_telat = $qryAbsenHr." AND (attendance_code.kode = 'T1' OR attendance_code.kode = 'T2' OR attendance_code.kode = 'T3')";
    $q_tl = $qryAbsenHr." AND attendance_code.kode = 'TL' ";
    $q_sakit = $qryAbsenHr." AND (attendance_code.kode = 'S1' OR attendance_code.kode = 'S2' OR attendance_code.kode = 'S3')";
    $q_ijin = $qryAbsenHr." AND attendance_code.type = 'SUPEM'  AND (absensi.ket <> 'S1' OR absensi.ket <> 'S2' OR absensi.ket <> 'S3') AND absensi.ket <> 'WFH'";


    switch($_POST['id']){
        case "masuk":
            $absen = mysqli_query($link, $q_masuk)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
        case "mangkir":
            $absen = mysqli_query($link, $q_mangkir)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
        case "telat":
            $absen = mysqli_query($link, $q_telat)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
        case "absen tidak lengkap":
            $absen = mysqli_query($link, $q_tl)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
        case "sakit":
            $absen = mysqli_query($link, $q_sakit)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
        case "ijin":
            $absen = mysqli_query($link, $q_ijin)or die(mysqli_error($link));
            $absenTotal = mysqli_num_rows($absen);
            break;
    }
    
    
?>
<div class="modal fade bd-example-modal-xl"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title pull-left text-uppercase" id="staticBackdropLabel"><?=$modalTitle?></h5>
                <p class="badge badge-pill"><?=""?></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
                <div class="table-full-width" >
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NPK</th>
                                <th>Nama</th>
                                <th>Shift</th>
                                <th>Area</th>
                                <th>Dept</th>
                                <th>Tanggal</th>
                                <th>Check in</th>
                                <th>Check out</th>
                                <th class="text-right">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase">
                        <?php
                        $no = 1;
                        if($absenTotal > 0){
                            while($data = mysqli_fetch_assoc($absen)){
                                $check_in = ($data['check_in'] == "00:00:00")? "-" : $data['check_in'];
                                $check_out = ($data['check_out'] == "00:00:00")? "-" : $data['check_out'];
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['npk_']?></td>
                                
                                <td><?=$data['nama_']?></td>
                                <td><?=$data['shift_absen']?></td>
                                <td><?=$data['groupfrm']?></td>
                                <td><?=$data['deptAcc']?></td>
                                <td><?=hari_singkat($data['tanggal'])?>, <?=DBtoForm($data['tanggal'])?></td>
                                <td><?=$check_in?></td>
                                <td><?=$check_out?></td>
                                <td><?=$data['ket']?></td>
                            </tr>
                            <?php
                            }
                        }else{
                            ?>
                            <tr><td colspan="10" class="text-center">Tidak Ada Data Absensi di Database</td></tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
           
            <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
            </div>

        </div>

    
  </div>
</div>

<?php
}
?>
<!-- Modal -->