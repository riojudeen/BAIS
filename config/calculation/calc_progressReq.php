<?php
list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
$query_lembur = "SELECT 
    lembur._id AS id_lembur,
    lembur.kode_lembur AS kode_lembur, 
    lembur.requester AS requester,
    lembur.npk AS npk_lembur, 
    lembur.in_date AS inDate_lembur, 
    lembur.out_date AS outDate_lembur, 
    lembur.in_lembur AS in_lembur, 
    lembur.work_date AS work_date, 
    lembur.out_lembur AS out_lembur,
    lembur.kode_job AS kode_job,
    lembur.aktifitas AS aktivity, 
    lembur.status_approve AS status_approve, 
    lembur.status AS status_lembur,

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
    karyawan.shift AS shift_

    FROM lembur
    JOIN org ON org.npk = lembur.npk
    JOIN karyawan ON karyawan.npk = lembur.npk WHERE $area_access = '$value_access'";


$qry_aproval = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve BETWEEN '25' AND '50' ) ";
$qry_draft = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve = '0') ";
$qry_process = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve = '75') ";
$qry_success = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100a') ";
$qry_arsip = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100c') ";

$qry_waitingspv = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '25a') ";
$qry_waitingadmin = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '50a') ";
$qry_return = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '75c') ";
$qry_processproblem = $query_lembur." AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100b') ";

$sqlApproval = mysqli_query($link, $qry_aproval)or die(mysqli_error($link));
$sqlDraft = mysqli_query($link, $qry_draft)or die(mysqli_error($link));
$sqlProcess = mysqli_query($link, $qry_process)or die(mysqli_error($link));
$sqlSuccess = mysqli_query($link, $qry_success)or die(mysqli_error($link));
$sqlArsip = mysqli_query($link, $qry_arsip)or die(mysqli_error($link));

$sqlWaitingSPV = mysqli_query($link, $qry_waitingspv)or die(mysqli_error($link));
$sqlWaitingAdmin = mysqli_query($link, $qry_waitingadmin)or die(mysqli_error($link));
$sqlProcessReturn = mysqli_query($link, $qry_return)or die(mysqli_error($link));
$sqlProcessProblem = mysqli_query($link, $qry_processproblem)or die(mysqli_error($link));

$jml_Approval = mysqli_num_rows($sqlApproval);
$jml_Draft = mysqli_num_rows($sqlDraft);
$jml_Process = mysqli_num_rows($sqlProcess);
$jml_Success = mysqli_num_rows($sqlSuccess);
$jml_Arsip = mysqli_num_rows($sqlArsip);


$waitingSPV = mysqli_num_rows($sqlWaitingSPV);
$waitingAdmin = mysqli_num_rows($sqlWaitingAdmin);
$problem = mysqli_num_rows($sqlProcessProblem);
$return = mysqli_num_rows($sqlProcessReturn);

$draft = ($jml_Draft != '0')?$jml_Draft." In Draft":"";
$waitSpv = ($waitingSPV != '0')?$waitingSPV." Waiting Approve":"";
$waitAdm = ($waitingAdmin != '0')?$waitingAdmin." Waiting Process":"";
$prob = ($problem != '0')?$problem." Dihentikan":"";
$return = ($problem != '0')?$problem." Dikembalikan Admin":"";

$jml_pengajuan = $jml_Draft+$jml_Approval+$jml_Process+$jml_Success;

?>

<div class="row">
    <div class="col-xl-3 ">
        <div class="card-plain card-stats bg-transparent h-100 my-0 border-left border-right">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-danger ">
                        <i class="nc-icon nc-ruler-pencil text-danger "></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers ">
                            <p class="card-category">Pengajuan</p>
                            <p class="card-title"><?=$jml_pengajuan?><p>
                        </div>
                        <span class="badge badge-pill badge-danger pull-right"><?=$draft?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 ">
        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning ">
                        <i class="nc-icon nc-paper text-warning "></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers ">
                            <p class="card-category">Approval</p>
                            <p class="card-title"><?=$jml_Approval?><p>
                        </div>
                        <span class="badge badge-pill badge-warning pull-right"><?=$waitSpv?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 ">
        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning ">
                        <i class="nc-icon nc-single-copy-04 text-primary "></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers ">
                            <p class="card-category">In Process</p>
                            <p class="card-title"><?=$jml_Process?><p>
                        </div>
                        <span class="badge badge-pill badge-info pull-right"><?=$waitAdm?></span>
                        <span class="badge badge-pill badge-info pull-right"><?=$return?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 ">
        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning ">
                        <i class="nc-icon nc-check-2 text-success "></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers ">
                            <p class="card-category">Success</p>
                            <p class="card-title"><?=$jml_Success?><p>
                        </div>
                        <span class="badge badge-pill badge-info pull-right"><?=$prob?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>