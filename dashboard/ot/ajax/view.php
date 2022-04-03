<?php
include("../../../config/config.php"); 
include("../../../config/approval_system.php");
$npk =$npkUser;
list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
$id_absen = $_POST['id'];
echo $id_absen;
$qry_abs = "SELECT req_absensi.id AS id_absen,
    req_absensi.npk AS npk_absen, 
    req_absensi.shift AS shift_absen,
    req_absensi.date AS tanggal,
    req_absensi.date_in AS tanggal_masuk,
    req_absensi.date_out AS tanggal_keluar,
    req_absensi.check_in AS check_in,
    req_absensi.check_out AS check_out,
    req_absensi.keterangan AS keterangan,
    req_absensi.requester AS requester,
    req_absensi.status AS status_absen,
    req_absensi.req_status AS req_status,
    req_absensi.req_date AS req_date,
    req_absensi.note AS note,

    CONCAT(req_absensi.status,req_absensi.req_status) AS 'status',
    absensi.ket AS hr_ket,

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
    karyawan.department AS department_,

    attendance_code.keterangan AS ket_supem


    FROM req_absensi
    JOIN karyawan ON karyawan.npk = req_absensi.npk
    JOIN org ON org.npk = karyawan.npk
    LEFT JOIN absensi ON req_absensi.id_absensi = absensi.id
    LEFT JOIN attendance_code ON attendance_code.kode = req_absensi.keterangan
    WHERE req_absensi.id = '$id_absen ' ";
$sql_abs = mysqli_query($link, $qry_abs)or die(mysqli_error($link));
$dataReqAbs = mysqli_fetch_assoc($sql_abs);

$tombolRequest = ($dataReqAbs['status_absen'] == 0)?"":"disabled";
$tahun = date('Y', strtotime($dataReqAbs['tanggal']));
$ket_query = mysqli_query($link, "SELECT attendance_code.keterangan AS `ket`, attendance_type.name AS `name` FROM attendance_code  JOIN attendance_type ON attendance_code.type = attendance_type.id WHERE attendance_code.kode = '$dataReqAbs[keterangan]' ")or die(mysqli_error($link));
$data_ket = mysqli_fetch_assoc($ket_query);

$check_in = ($dataReqAbs['check_in']!='00:00:00')?jam($dataReqAbs['check_in']):'-';
$check_out = ($dataReqAbs['check_out']!='00:00:00')?jam($dataReqAbs['check_out']):'-';



// echo $tombolRequest;
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-left text-secondary" id="exampleModalLongTitle">Detail Information </h5>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table  py-0" >
                <tbody>
                    <tr class="py-0">
                        <td class="text-center" rowspan="3" style="border:1px solid #D6DBDF; height:20px" class="m-0 p-0">
                            <img src="../../../assets/img/logo_daihatsu.png" alt="" style=" margin: 2px; padding:1px">
                        </td>
                        <td class="text-center" rowspan="3" style="border:1px solid #D6DBDF; height:20px">
                            <h5 class="text-uppercase"><?=$data_ket['name']?></h5>
                            <hr>
                            <p><?=$data_ket['ket']?></p>  
                        </td>
                        <td style="border:1px solid #D6DBDF; height:20px">No Form : </td>
                        <td style="border:1px solid #D6DBDF; height:20px">110/Form-HR/ADM </td>
                        <td class="text-center text-uppercase title" rowspan="3" style="border:1px solid #D6DBDF; height:20px">
                            <h5><?=$tahun?></h5>
                        </td>
                    </tr>
                    <tr class="py-0" style="border:1px solid #D6DBDF; height:20px">
                        <td style="border:1px solid #D6DBDF; height:20px">Tgl Efektif : </td>
                        <td style="border:1px solid #D6DBDF; height:20px">01 November 2010 </td>
                    </tr>
                    <tr class="py-0" style="border:1px solid #D6DBDF; height:20px">
                        <td style="border:1px solid #D6DBDF; height:20px">Revisi : </td>
                        <td style="border:1px solid #D6DBDF; height:20px">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-body px-3">
        <!-- isi -->
        <div class="row">
            <div class="col-md-10 pr-1 mb-0">
                <label>Nama :</label>
                <h5 class="title text-uppercase"><?=$dataReqAbs['nama_']?> - <?=$dataReqAbs['npk_']?></h6>
                <input name="req" value="<?=$id_absen?>" type="hidden">
            </div>
        </div>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-3 pr-1">
                <div class="form-group">
                    <label>Group :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $group, "group")?>">
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Section :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $sect, "section")?>">
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Dept Functional :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $dept, "dept")?>">
                </div>
            </div>
            <div class="col-md-3 pl-1">
                <div class="form-group">
                    <label>Dept Administratif :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $dept_account, "deptAcc")?>">
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-4 pr-1">
                <div class="form-group">
                    <label>Tanggal Cuti</label>
                    <input type="text" class="form-control" disabled="true" value="<?=hari($dataReqAbs['tanggal'])?>, <?=tgl_indo($dataReqAbs['tanggal'])?>">
                </div>
            </div>
            
            <div class="col-md-2 px-1">
                <div class="form-group">
                    <label for="exampleInputEmail1">Shift</label>
                    <input type="text" class="form-control" disabled="true"  value="<?=$dataReqAbs['shift_']?>">
                </div>
            </div>
            <div class="col-md-2 pr-1">
                <div class="form-group ">
                    <label for="exampleInputEmail1">Check In</label>
                    <input type="text" class="form-control" disabled="true"  value="<?=$check_in?>">
                </div>
            </div>
            <div class="col-md-2 pl-1">
                <div class="form-group">
                    <label for="exampleInputEmail1">Check Out</label>
                    <input type="text" class="form-control" disabled="true"  value="<?=$check_out?>">
                </div>
            </div>
            <div class="col-md-2 pl-1">
                <div class="form-group">
                    <label>Ket</label>
                    <input type="text" class="form-control" disabled="true" value="<?=$dataReqAbs['hr_ket']?>">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10 pl-3">
                <div class="form-group">
                    <label>Pengajuan </label>
                    <input type="text" class="form-control" disabled="true" value="<?=$dataReqAbs['ket_supem']?>">
                </div>
            </div>
            <div class="col-md-2 pl-1">
                <div class="form-group">
                    <label>Kode</label>
                    <input type="text" class="form-control" disabled="true" value="<?=$dataReqAbs['keterangan']?>">
                </div>
            </div>
            <div class="col-md-12 pl-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Alasan / Note :</label>
                    <textarea disabled class="form-control textarea" name="" id="" cols="30" rows="10"><?=$dataReqAbs['note']?></textarea>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-4 pl-3 pr-1">
                <div class="form-group">
                    <label>Tanggal Pengajuan :</label>
                    <input type="text" class="form-control" disabled="true" value="<?=$dataReqAbs['keterangan']?>">
                </div>
            </div>
            <div class="col-md-4 pl-1">
                <div class="form-group">
                    <label>Diajukan :</label>
                    <input type="text" class="form-control" disabled="true" value="<?=$dataReqAbs['keterangan']?>">
                </div>
            </div>
            <div class="col-md-4 pl-1">
                <div class="form-group">
                    <label>Progress Status :</label>
                    <input type="text" class="form-control text-white bg-<?=authColor($dataReqAbs['req_status'])?>" disabled="true" value="<?=authText($dataReqAbs['status'])?>">
                </div>
            </div>
        </div>

        <hr/>
    </div>

    <div class="modal-footer ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    
    </div>
</div>
