<?php
$qry_aproval = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve BETWEEN '25' AND '50' ) ";
$qry_draft = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve = '0') ";
$qry_process = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (lembur.status_approve = '75') ";
$qry_success = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100a') ";
$qry_arsip = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100c') ";

$qry_waitingspv = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '25a') ";
$qry_waitingadmin = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '50a') ";
$qry_return = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '75c') ";
$qry_processproblem = " AND lembur.in_date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' $area $shift AND (CONCAT(lembur.status_approve, lembur.status) = '100b') ";

$sqlApproval = table_access($link, $level, 'lembur', $access_ , $qry_aproval);
$sqlDraft = table_access($link, $level, 'lembur', $access_ , $qry_draft);
$sqlProcess = table_access($link, $level, 'lembur', $access_ , $qry_process);
$sqlSuccess = table_access($link, $level, 'lembur', $access_ , $qry_success);
$sqlArsip = table_access($link, $level, 'lembur', $access_ , $qry_arsip);

$sqlWaitingSPV = table_access($link, $level, 'lembur', $access_ , $qry_waitingspv);
$sqlWaitingAdmin = table_access($link, $level, 'lembur', $access_ , $qry_waitingadmin);
$sqlProcessReturn = table_access($link, $level, 'lembur', $access_ , $qry_return);
$sqlProcessProblem = table_access($link, $level, 'lembur', $access_ , $qry_processproblem);

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