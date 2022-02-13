<?php
function sumary($status_approval, $status, $info){
    $data = $status_approval.$status;
    if($info == 'info'){
        switch($data){
            case '0a' :
                $result = "draft pengajuan";
                break;
            //pengajuan pending belum diapproval
            case '25a' :
                $result = "Waiting Approval";
                break;
            //sistem proses di spv
            case '50a' :
                $result = "Disetujui SPV";
                break;
            //perlu dikonfirmasi
            case '50b' :
                $result = "Ditolak SPV";
                break;
            case '50c' :
                $result = "Dikembalikan SPV";
                break;
            //pengajuan diproses admin
            case '75a' :
                $result = "Diproses";
                break;
            //sistem proses di admin
            case '75b' :
                $result = "Ditolak Admin";
                break;
            //sistem proses di admin
            case '75c' :
                $result = "Dikembalikan Admin";
                break;
        
            //pengjuan sukses dan sudah berubah di personal site
            case '100a' :
                $result = "Close";
                break;
            case '100b' :
                $result = "Problem Absensi";
                break;
            case '100c' :
                $result = "Arsip";
                break;
        }
    }else if($info == 'progress'){
        $result = $status_approval;
    }else if($info == 'color'){
        switch($status_approval){
            case '0' :
                $result = "danger";
                break;
            //pengajuan pending belum diapproval
            case '25' :
                $result = "warning";
                break;
            //sistem proses di spv
            case '50' :
                $result = "info";
                break;
            //perlu dikonfirmasi
            case '75' :
                $result = "primary";
                break;
            case '100' :
                $result = "success";
                break;
        }
    }else if($info == 'status'){
        switch($status_approval){
            case '0' :
                $result = "draft";
                break;
            //pengajuan pending belum diapproval
            case '25' :
                $result = "pengajuan";
                break;
            //sistem proses di spv
            case '50' :
                $result = "approval";
                break;
            //perlu dikonfirmasi
            case '75' :
                $result = "proses";
                break;
            case '100' :
                $result = "sukses";
                break;
        }
    }
    return $result;
}