<?php
//function tombol approval 
function tbl_approval($level, $status, $type){
    if($type == 'arsip'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = '';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'delete'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = '';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = '';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = '';
                    break;
                case '50c'://dikembalikan spv
                    $btn = '';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = '';
                    break;
                case '75b'://ditolak admin
                    $btn = '';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = '';
                    break;
                case '100c'://arsip
                    $btn = '';
                    break;
            }
        }
    }else if($type == 'request'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = '';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = '';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = '';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'return'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = '';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = '';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = '';
                    break;
                case '75b'://ditolak admin
                    $btn = '';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = '';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'pause'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = '';
                    break;
                case '75b'://ditolak admin
                    $btn = '';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'reject'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = '';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = '';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = '';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = '';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'approve'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = '';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = '';
                    break;
                case '50c'://dikembalikan spv
                    $btn = '';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = '';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = '';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }else if($type == 'check'){
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = '';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = '';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = '';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = '';
                    break;
                case '50c'://dikembalikan spv
                    $btn = '';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = '';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = '';
                    break;
                case '75b'://ditolak admin
                    $btn = '';
                    break;
                case '75c'://dikembalikan admin
                    $btn = '';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = '';
                    break;
                case '100c'://arsip
                    $btn = '';
                    break;
            }
        }
    }else{
        if($level < 4){
            //frm kebawah
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level >= 4 && $level <= 5){
            //supervisor
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }else if($level > 5){
            //admin up
            switch($status){
                case '0a'://draft
                    $btn = 'disabled';
                    break;
                case '25a'://waiting approval
                    $btn = 'disabled';
                    break;
                case '50a'://aproved spv
                    $btn = 'disabled';
                    break;
                case '50b'://ditolak spv
                    $btn = 'disabled';
                    break;
                case '50c'://dikembalikan spv
                    $btn = 'disabled';
                    break;
                case '75a'://diproses admin
                    $btn = 'disabled';
                    break;
                case '75b'://ditolak admin
                    $btn = 'disabled';
                    break;
                case '75c'://dikembalikan admin
                    $btn = 'disabled';
                    break;
                case '100a'://closed
                    $btn = 'disabled';
                    break;
                case '100b'://problem absensi
                    $btn = 'disabled';
                    break;
                case '100c'://arsip
                    $btn = 'disabled';
                    break;
            }
        }
    }
    return $btn;
}
function name_check($level, $status, $class){
    if($level < 4){
        //frm kebawah
        switch($status){
            case '0a'://draft
                $btn = $class;
                break;
            case '25a'://waiting approval
                $btn = '';
                break;
            case '50a'://aproved spv
                $btn = '';
                break;
            case '50b'://ditolak spv
                $btn = '';
                break;
            case '50c'://dikembalikan spv
                $btn = $class;
                break;
            case '75a'://diproses admin
                $btn = '';
                break;
            case '75b'://ditolak admin
                $btn = '';
                break;
            case '75c'://dikembalikan admin
                $btn = $class;
                break;
            case '100a'://closed
                $btn = '';
                break;
            case '100b'://problem absensi
                $btn = '';
                break;
            case '100c'://arsip
                $btn = '';
                break;
        }
    }else if($level >= 4 && $level <= 5){
        //supervisor
        switch($status){
            case '0a'://draft
                $btn = '';
                break;
            case '25a'://waiting approval
                $btn = $class;
                break;
            case '50a'://aproved spv
                $btn = $class;
                break;
            case '50b'://ditolak spv
                $btn = $class;
                break;
            case '50c'://dikembalikan spv
                $btn = $class;
                break;
            case '75a'://diproses admin
                $btn = '';
                break;
            case '75b'://ditolak admin
                $btn = '';
                break;
            case '75c'://dikembalikan admin
                $btn = '';
                break;
            case '100a'://closed
                $btn = '';
                break;
            case '100b'://problem absensi
                $btn = '';
                break;
            case '100c'://arsip
                $btn = '';
                break;
        }
    }else if($level > 5){
        //admin up
        switch($status){
            case '0a'://draft
                $btn = '';
                break;
            case '25a'://waiting approval
                $btn = '';
                break;
            case '50a'://aproved spv
                $btn = $class;
                break;
            case '50b'://ditolak spv
                $btn = '';
                break;
            case '50c'://dikembalikan spv
                $btn = '';
                break;
            case '75a'://diproses admin
                $btn = $class;
                break;
            case '75b'://ditolak admin
                $btn = $class;
                break;
            case '75c'://dikembalikan admin
                $btn = $class;
                break;
            case '100a'://closed
                $btn = '';
                break;
            case '100b'://problem absensi
                $btn = $class;
                break;
            case '100c'://arsip
                $btn = $class;
                break;
        }
    }
    return $btn;
}
