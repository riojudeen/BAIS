<?php
//function error
function error($kodeError,$pesanError, $table){
    switch($table){
        case 'division':
            $primary_key = 'Kode Divisi';
            break;
        case 'deptAcc':
            $primary_key = 'Kode Dept Account';
            break;
        case 'dept':
            $primary_key = 'Kode Department Functional';
            break;
        case 'section':
            $primary_key = 'Kode Section';
            break;
        case 'goup':
            $primary_key = 'Kode Group';
            break;
        case 'pos':
            $primary_key = 'Kode Pos Leader';
            break;
        case 'karyawan':
            $primary_key = 'Npk Karyawan';
            break;
            
    }
    if($kodeError == '1062'){
        $pesan = "Terdapat nilai duplikat pada id / $primary_key ";
    }else if($kodeError == '1064'){
        $pesan = "Pastikan tidak ada tanda petik (' , `, atau '') ";
    }else{
        $pesan = $pesanError;
    }
    return $pesan;
}