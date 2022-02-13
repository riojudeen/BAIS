<?php
include_once('config.php');
function noData(){
    return "TIDAK DITEMUKAN DATA DI DATABASE";
}
function authColor($code){
    if($code == "a"){
        $color = "primary";
    }else if($code == "b"){
        $color = "danger";
    }else if($code == "c"){
        $color = "danger";
    }else if($code == "d"){
        $color = "warning";
    }else if($code == "e"){
        $color = "success";
    }else{
        $color = "";
    }
    return $color;
}
function authText($code){
    if($code == ""){
        $text = "Belum Ada Pengajuan";
    }else if($code == "25a"){
        $text = "Waiting";
    }else if($code == "50a"){
        $text = "Disetujui";
    }else if($code == "75a"){
        $text = "Diproses";
    }else if($code == "100a"){
        $text = "Sukses";
    }else if($code == "100b"){
        $text = "Ditolak";
    }else if($code == "100c"){
        $text = "Dihentikan";
    }else if($code == "100d"){
        $text = "Dikembalikan";
    }else if($code == "100e"){
        $text = "Arsip";
    }else if($code == "100f"){
        $text = "Approval Online";
    }else{
        $text = "";
    }
    return $text;
}
function authApprove($level, $request, $app){
    // jika meminta approve
    if($app == "approved"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "50";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "50";
            }else if($level == 7){
                // admin divisi
                $status = "50";
            }else if($level == 8){
                // admin system
                $status = "50";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "a";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "a";
            }else if($level == 7){
                // admin divisi
                $status = "a";
            }else if($level == 8){
                // admin system
                $status = "a";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "rejected"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "100";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "100";
            }else if($level == 7){
                // admin divisi
                $status = "100";
            }else if($level == 8){
                // admin system
                $status = "100";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "b";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "b";
            }else if($level == 7){
                // admin divisi
                $status = "b";
            }else if($level == 8){
                // admin system
                $status = "b";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "request"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "25";
            }else if($level == 4){
                // section head
                $status = "25";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "25";
            }else if($level == 7){
                // admin divisi
                $status = "25";
            }else if($level == 8){
                // admin system
                $status = "25";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "a";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "a";
            }else if($level == 6){
                // admin department
                $status = "a";
            }else if($level == 7){
                // admin divisi
                $status = "a";
            }else if($level == 8){
                // admin system
                $status = "a";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "arsip"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "100";
            }else if($level == 7){
                // admin divisi
                $status = "100";
            }else if($level == 8){
                // admin system
                $status = "100";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "e";
            }else if($level == 7){
                // admin divisi
                $status = "e";
            }else if($level == 8){
                // admin system
                $status = "e";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "return"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "100";
            }else if($level == 7){
                // admin divisi
                $status = "100";
            }else if($level == 8){
                // admin system
                $status = "100";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "d";
            }else if($level == 7){
                // admin divisi
                $status = "d";
            }else if($level == 8){
                // admin system
                $status = "d";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "proses"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "75";
            }else if($level == 7){
                // admin divisi
                $status = "75";
            }else if($level == 8){
                // admin system
                $status = "75";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "a";
            }else if($level == 7){
                // admin divisi
                $status = "a";
            }else if($level == 8){
                // admin system
                $status = "a";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else if($app == "stop"){
        if($request == "status"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "100";
            }else if($level == 7){
                // admin divisi
                $status = "100";
            }else if($level == 8){
                // admin system
                $status = "100";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }else if($request == "request"){
            if($level == 1){
                // general user
                $status = "";
            }else if($level == 2){
                // special user
                $status = "";
            }else if($level == 3){
                // foreman
                $status = "";
            }else if($level == 4){
                // section head
                $status = "";
            }else if($level == 5){
                // manajemen
                $status = "";
            }else if($level == 6){
                // admin department
                $status = "c";
            }else if($level == 7){
                // admin divisi
                $status = "c";
            }else if($level == 8){
                // admin system
                $status = "c";
            }else{
                $status = "function argumen level user tidak ada";
            }
            return $status;
        }
    }else{
        return "function argumen request salah atau belum ada";
    }
}
function orgAccess($level){
    if($level == 1){
        // general user
        $access = "npk";
    }else if($level == 2){
        // special user
        $access = "npk";
    }else if($level == 3){
        // foreman
        $access = "grp";
    }else if($level == 4){
        // section head
        $access = "sect";
    }else if($level == 5){
        // manajemen
        $access = "dept";
    }else if($level == 6){
        // admin department
        $access = "division";
    }else if($level == 7){
        // admin divisi
        $access = "division";
    }else if($level == 8){
        // admin system
        $access = "division";
    }else{
        $access = "function argumen level user tidak ada";
    }
    return $access;
}
function dataOrg($link, $npk){
    $query_org = mysqli_query($link, "SELECT npk, sub_post, post, grp, sect, dept, dept_account, division, plant FROM org WHERE npk = '$npk' ")or die(mysqli_error($link));
    if(mysqli_num_rows($query_org) > 0){
        $sql = mysqli_fetch_assoc($query_org);
        $data1 = $sql['npk'];
        $data2 = $sql['sub_post'];
        $data3 = $sql['post'];
        $data4 = $sql['grp'];
        $data5 = $sql['sect'];
        $data6 = $sql['dept'];
        $data7 = $sql['dept_account'];
        $data8 = $sql['division'];
        $data9 = $sql['plant'];
        return array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9);
    }else{
        return array("null","null","null","null","null","null","null","null","null");
    }
}
function generateAccess($link, $level, $npk){
    $query_org = mysqli_query($link, "SELECT npk, sub_post, post, grp, sect, dept, dept_account, division, plant FROM org WHERE npk = '$npk' ")or die(mysqli_error($link));
    if(mysqli_num_rows($query_org) > 0){
        $sql = mysqli_fetch_assoc($query_org);
        $data1 = $sql['npk'];
        // $data2 = $sql['sub_post'];
        // $data3 = $sql['post'];
        $data4 = $sql['grp'];
        $data5 = $sql['sect'];
        $data6 = $sql['dept'];
        // $data7 = $sql['dept_account'];
        $data8 = $sql['division'];
        // $data9 = $sql['plant'];
    }else{
        $data1 = $data4 = $data5 = $data6 = $data7 = $data8 = "null";
        
    }
    if($level == 1){
        // general user
        $access = $data1;
    }else if($level == 2){
        // special user
        $access = $data1;
    }else if($level == 3){
        // foreman
        $access = $data4;
    }else if($level == 4){
        // section head
        $access = $data5;
    }else if($level == 5){
        // manajemen
        $access = $data6;
    }else if($level == 6){
        // admin department
        $access = $data8;
    }else if($level == 7){
        // admin divisi
        $access = $data8;
    }else if($level == 8){
        // admin system
        $access = $data8;
    }else{
        $access = "function argumen level user tidak ada";
    }
    return $access;
}
function partAccess($level, $req){
    if($level == 1){
        // general user
        $part = "npk"; //field table untuk kondiwi where statement : WHERE field_data = 'npk' AND $table.$table_field2 = '$part'
        $table = "karyawan"; //table yang akan dipakai
        $field_request = "npk"; //field table yang diminta untuk ditampilkan SELECT $table.$field_request FROM $table WHERE
        $table_field1 = "npk"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "npk"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 2){
        // special user
        $part = "npk";
        $table = "karyawan";
        $field_request = "npk";
        $table_field1 = "npk"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "npk"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 3){
        // foreman
        $part = "group";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 4){
        // section head
        $part = "section";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 5){
        // manajemen
        $part = "dept";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 6){
        // admin department
        $part = "division";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 7){
        // admin divisi
        $part = "division";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else if($level == 8){
        // admin system
        $part = "division";
        $table = "view_daftar_area";
        $field_request = "id";
        $table_field1 = "cord"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "part"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }else{
        $part = "function argumen tida lengkap atau salah";
        $table = "function argumen tida lengkap atau salah";
        $field_request = "function argumen tida lengkap atau salah";
        $table_field1 = "function argumen tida lengkap atau salah"; //field table untuk kondisi where statement WHERE $table.$table_field1 = '$user'
        $table_field2 = "function argumen tida lengkap atau salah"; //field table untuk kondisi where statement AND $table.$table_field2 = '$part'
    }
    if($req == "table"){
        return $table;
    }else if($req == "part"){
        return $part;
    }else if($req == "field_request"){
        return $field_request;
    }else if ($req == "table_field1"){
        return $table_field1;
    }else if ($req == "table_field2"){
        return $table_field2;
    }
    
}


function queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npkUser, $val_access){
    if($level >= 1 && $level <= 2){
        $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field1 = '$npkUser' ";
    }else if($level >= 3 && $level <= 8){
        if($level >= 3 && $level <= 5){
            //jika user foreman atau supervisor , meraka hanya bisa mengakses organisasi yang dikoordinir
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field1 = '$npkUser' AND $table.$table_field2 = '$part'  ";
            
        }else if($level >= 6 && $level <= 7){
            // jika admin department , admin division
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field2 = '$part' ";
        }else if($level == 8){
            // jika admin sistem bisa mengakses semua data plant
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field2 = '$part' ";
        }
    }else{
        $query_org = "parameter salah";
    }
    return $query_org;
}
// query data absensi
function filtergenerator($link, $level, $generate, $origin_query, $access_org){
    if($level >=1 AND $level <= 8){
        $sql = mysqli_query($link, $generate)or die(mysqli_error($link));
        $jml = mysqli_num_rows($sql);
        if($jml > 0){
            $query = " $origin_query WHERE (";
            while($data = mysqli_fetch_assoc($sql)){
                $query .= " $access_org = '$data[data]' OR";
            }
            $query = substr($query , 0, -2);
            return $query.')';
        }

    }else{
        return "tidak akses data";
    }
}
function filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari){
    if($div_filter != ''){
        if($dept_filter != ''){
            if($sect_filter != ''){
                if($group_filter != ''){
                    $addFilter = " AND division = '$div_filter' AND dept = '$dept_filter' AND sect = '$sect_filter' AND grp = '$group_filter'";
                }else{
                    $addFilter = " AND division = '$div_filter' AND dept = '$dept_filter' AND sect = '$sect_filter' ";
                }
            }else{
                $addFilter = " AND division = '$div_filter' AND dept = '$dept_filter' ";
            }
        }else{
            $addFilter = " AND division = '$div_filter' ";
        }
    }else{
        $addFilter = "";
    }
    // echo $addFilter;
    if($deptAcc_filter != ''){
        $addFilterDeptAcc =" AND dept_account = '$deptAcc_filter'";
    }else{
        $addFilterDeptAcc ="";
    }
    if($shift != ''){
        $addFilterShift = " AND employee_shift = '$shift'";
    }else{
        $addFilterShift = "";
    }
    if($cari != ''){
        $addFilterCari = " AND  npk LIKE '%$cari%' OR nama LIKE '%$cari%' ";
    }else{
        $addFilterCari = '';
    }
    $gabung = $addFilter.$addFilterDeptAcc.$addFilterShift.$addFilterCari;
    return $gabung;

}
function pagination($jmlData, $sort, $position){
    
}
function btnProses($level, $status, $btn){
    if($level == 1){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan diapprove, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan diptoses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                foreman tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                foreman bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
        }
    }else if($level == 2){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan diapprove, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan diptoses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                foreman tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                foreman bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
        }
    }else if($level == 3){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan diapprove, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan diptoses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses, foreman tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                foreman tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                foreman bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = '';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan dikemablikan admin, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                foreman bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
        }
    }else if($level == 4){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, SPV bsa mengakses approve, dan reject
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = '';
                $reject = '';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan diapprove, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan diptoses, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                SPV tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                SPV tidak bisa apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                SPV tidak bisa melakukan apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100e':
                /*
                ketika pengajuan menjadi arsip, 
                SPV tidak bisa melakukan apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan Approval online, 
                SPV bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
        }
    }else if($level == 5){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, SPV bsa mengakses approve, dan reject
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan diapprove, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan diptoses, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses, SPV tidak bisa akses apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                SPV tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                SPV tidak bisa apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                SPV tidak bisa melakukan apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100e':
                /*
                ketika pengajuan menjadi arsip, 
                SPV tidak bisa melakukan apapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan Approval online, 
                SPV bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
        }
    }else if($level == 6){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, admin tidak bisa mengoperasikan tombol manapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan sudah adiapprove SPV, 
                admin bisa melakukan proses, return , dan stop
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan sudah diproses , 
                admin bisa melakukan cancel dengan mengakses tombol return dan stop
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses , 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                admin bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                admin bisa mengakses tombol approve
                admin bisa mengakses tombol delete, untuk mendelete pengajuan
                */
                $request = 'disabled';
                $proses= '';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan arsip, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;

        }
    }else if($level == 7){
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, admin tidak bisa mengoperasikan tombol manapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan sudah adiapprove SPV, 
                admin bisa melakukan proses, return , dan stop
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan sudah diproses , 
                admin bisa melakukan cancel dengan mengakses tombol return dan stop
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses , 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                admin bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                admin bisa mengakses tombol approve
                admin bisa mengakses tombol delete, untuk mendelete pengajuan
                */
                $request = 'disabled';
                $proses= '';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan arsip, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;

        }
    }else if($level == 8){
        
        switch($status){
            case '25a'://baru diajukan
                /*
                ketika pengajuan diajukan, admin tidak bisa mengoperasikan tombol manapun
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '50a'://approval spv
                /*
                ketika pengajuan sudah adiapprove SPV, 
                admin bisa melakukan proses, return , dan stop
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '75a':
                /*
                ketika pengajuan sudah diproses , 
                admin bisa melakukan cancel dengan mengakses tombol return dan stop
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = '';
                $stop = '';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100a':
                /*
                ketika pengajuan sukses , 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100b':
                /*
                ketika pengajuan ditolak SPV, 
                admin tidak bisa melakukan apa apa
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100c':
                /*
                ketika pengajuan dhentikan Admin, 
                admin bisa mengakses tombol return dan proses
                */
                $request = 'disabled';
                $proses= '';
                $return = '';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100d':
                /*
                ketika pengajuan dikemablikan admin, 
                admin bisa mengakses tombol approve
                admin bisa mengakses tombol delete, untuk mendelete pengajuan
                */
                $request = 'disabled';
                $proses= '';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = '';
                break;
            case '100e':
                /*
                ketika pengajuan arsip, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;
            case '100f':
                /*
                ketika pengajuan approval online, 
                admin bisa melakukan delete pengajuan
                */
                $request = 'disabled';
                $proses= 'disabled';
                $return = 'disabled';
                $stop = 'disabled';
                $approve = 'disabled';
                $reject = 'disabled';
                $delete = 'disabled';
                break;

        }
    }
    if($btn == 'btn'){
        $request = $request;
        $proses= $proses;
        $return =  $return;
        $stop = $stop ;
        $approve = $approve;
        $reject = $reject;
        $delete = $delete;
        
    }else if($btn == 'btn_visible'){
        if($level == 1){
            $request = 0;
            $proses= 0;
            $return =  0;
            $stop = 0 ;
            $approve = 0;
            $reject = 0;
            $delete = 0;
        }else if($level == 2){
            $request = 0;
            $proses= 0;
            $return =  0;
            $stop = 0 ;
            $approve = 0;
            $reject = 0;
            $delete = 0;
        }else if($level == 3){
            if($status == '100d'){
                $request = 1;
                $proses= 0;
                $return =  0;
                $stop = 0 ;
                $approve = 0;
                $reject = 0;
                $delete = 1;
            }else{
                $request = 0;
                $proses= 0;
                $return =  0;
                $stop = 0 ;
                $approve = 0;
                $reject = 0;
                $delete = 0;
            }
            
        }else if($level == 4){
            $request = 1;
            $proses= 0;
            $return =  0;
            $stop = 0 ;
            $approve = 1;
            $reject = 1;
            $delete = 0;
        }else if($level == 5){
            $request = 0;
            $proses= 0;
            $return =  0;
            $stop = 0 ;
            $approve = 0;
            $reject = 0;
            $delete = 0;
        }else if($level == 6){
            $request = 1;
            $proses= 1;
            $return =  1;
            $stop = 1 ;
            $approve = 0;
            $reject = 0;
            $delete = 1;
        }else if($level == 7){
            $request = 1;
            $proses= 1;
            $return =  1;
            $stop = 1 ;
            $approve = 0;
            $reject = 0;
            $delete = 1;
        }else if($level == 8){
            $request = 1;
            $proses= 1;
            $return =  1;
            $stop = 1 ;
            $approve = 1;
            $reject = 1;
            $delete = 1;
        }
        
    }
    return array($request,$proses,$return,$stop,$approve,$reject,$delete, $btn);
}
function getOrgName($link, $params, $part){
    $query = mysqli_query($link, "SELECT nama_org FROM view_daftar_area WHERE id = '$params' AND part = '$part' ")or die(mysqli_error($link));
    $sql = mysqli_fetch_assoc($query);
    $data = $sql['nama_org'];

    return $data;
}
function authBtn($level){
    if($level == 1){
        $request = 0;
        $proses= 0;
        $return =  0;
        $stop = 0 ;
        $approve = 0;
        $reject = 0;
        $delete = 0;
    }else if($level == 2){
        $request = 0;
        $proses= 0;
        $return =  0;
        $stop = 0 ;
        $approve = 0;
        $reject = 0;
        $delete = 0;
    }else if($level == 3){
        $request = 1;
        $proses= 0;
        $return =  0;
        $stop = 0 ;
        $approve = 0;
        $reject = 0;
        $delete = 1;
    }else if($level == 4){
        $request = 1;
        $proses= 0;
        $return =  0;
        $stop = 0 ;
        $approve = 1;
        $reject = 1;
        $delete = 0;
    }else if($level == 5){
        $request = 0;
        $proses= 0;
        $return =  0;
        $stop = 0 ;
        $approve = 0;
        $reject = 0;
        $delete = 0;
    }else if($level == 6){
        $request = 1;
        $proses= 1;
        $return =  1;
        $stop = 1 ;
        $approve = 0;
        $reject = 0;
        $delete = 1;
    }else if($level == 7){
        $request = 1;
        $proses= 1;
        $return =  1;
        $stop = 1 ;
        $approve = 0;
        $reject = 0;
        $delete = 1;
    }else if($level == 8){
        $request = 1;
        $proses= 1;
        $return =  1;
        $stop = 1 ;
        $approve = 1;
        $reject = 1;
        $delete = 1;
    }
    return array($request,$proses,$return,$stop,$approve,$reject,$delete);
}
function pecahID($id_){
    $pecah = explode('&&', $id_);
    $id = $pecah[0];
    $ket = $pecah[1];
    $req_shift = $pecah[2];
    return array($id, $ket, $req_shift);
}
function pecahProg($prog){
    $status = substr($prog, 0, -1);
    $req_status = substr($prog, -1);
    
    return array($status, $req_status);
}

function filterDataOrg($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari){
    if($div_filter != ''){
        if($dept_filter != ''){
            if($sect_filter != ''){
                if($group_filter != ''){
                    $addFilter = " AND id_division = '$div_filter' AND id_dept = '$dept_filter' AND id_sect = '$sect_filter' AND id_grp = '$group_filter'";
                }else{
                    $addFilter = " AND id_division = '$div_filter' AND id_dept = '$dept_filter' AND id_sect = '$sect_filter' ";
                }
            }else{
                $addFilter = " AND id_division = '$div_filter' AND id_dept = '$dept_filter' ";
            }
        }else{
            $addFilter = " AND id_division = '$div_filter' ";
        }
    }else{
        $addFilter = "";
    }
    // echo $addFilter;
    if($deptAcc_filter != ''){
        $addFilterDeptAcc =" AND id_dept_account = '$deptAcc_filter'";
    }else{
        $addFilterDeptAcc ="";
    }
    if($shift != ''){
        $addFilterShift = " AND shift = '$shift'";
    }else{
        $addFilterShift = "";
    }
    if($cari != ''){
        $addFilterCari = " AND  (npk LIKE '%$cari%' OR nama LIKE '%$cari%') ";
    }else{
        $addFilterCari = '';
    }
    $gabung = $addFilter.$addFilterDeptAcc.$addFilterShift.$addFilterCari;
    return $gabung;

}
function filtergeneratorOrg($link, $level, $generate, $origin_query, $access_org){
    if($level >=1 AND $level <= 8){
        $sql = mysqli_query($link, $generate)or die(mysqli_error($link));
        $jml = mysqli_num_rows($sql);
        if($jml > 0){
            $query = " $origin_query WHERE (";
            while($data = mysqli_fetch_assoc($sql)){
                $query .= " $access_org = '$data[data]' OR";
            }
            $query = substr($query , 0, -2);
            return $query.')';
        }

    }else{
        return "tidak akses data";
    }
}
function orgAccessOrg($level){
    if($level == 1){
        // general user
        $access = "npk";
    }else if($level == 2){
        // special user
        $access = "npk";
    }else if($level == 3){
        // foreman
        $access = "id_grp";
    }else if($level == 4){
        // section head
        $access = "id_sect";
    }else if($level == 5){
        // manajemen
        $access = "id_dept";
    }else if($level == 6){
        // admin department
        $access = "id_division";
    }else if($level == 7){
        // admin divisi
        $access = "id_division";
    }else if($level == 8){
        // admin system
        $access = "id_division";
    }else{
        $access = "function argumen level user tidak ada";
    }
    return $access;
}

// list($id, $ket, $req_shift) = pecahID('441312022-01-01&&C1&&');
// $query = "SELECT
// req_absensi.id AS id_absensi,
// req_absensi.npk AS npk,
// karyawan.nama AS nama,
// karyawan.shift AS employee_shift,
// org.sub_post AS sub_post,
// org.post AS post,
// org.grp AS grp,
// org.sect AS sect,
// org.dept AS dept,
// org.dept_account AS dept_account,
// org.division AS division,
// org.plant AS plant,
// req_absensi.shift AS req_shift,
// req_absensi.date AS req_work_date,
// req_absensi.date_in AS req_date_in,
// req_absensi.date_out AS req_date_out,
// req_absensi.check_in AS req_in,
// req_absensi.check_out AS req_out,
// req_absensi.keterangan AS req_code,
// attendance_code.keterangan AS keterangan,
// req_absensi.requester AS requester,
// req_absensi.status AS req_status_absen,
// req_absensi.req_status AS req_status,
// req_absensi.req_date AS req_date,
// req_absensi.shift_req AS shift_req,
// absensi.shift AS att_shift,
// absensi.date AS work_date,
// absensi.check_in AS check_in,
// absensi.check_out AS check_out,
// absensi.ket AS CODE,
// attendance_code.type AS att_type,
// attendance_code.alias AS att_alias
// FROM req_absensi
//     JOIN org ON req_absensi.npk = org.npk
//     LEFT JOIN karyawan ON org.npk = karyawan.npk
//     LEFT JOIN absensi ON absensi.id = req_absensi.id_absensi
//     LEFT JOIN attendance_code ON attendance_code.kode = req_absensi.keterangan ";
// debugging
$level = $level;
$npk = $npkUser;
$access_org = orgAccess($level);
$table = partAccess($level, "table");
$field_request = partAccess($level, "field_request");
$table_field1 = partAccess($level, "table_field1");
$table_field2 = partAccess($level, "table_field2");
$part = partAccess($level, "part");
$data = generateAccess($link,$level,$npk);
// list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
$generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data);
// $origin_query = "SELECT view_absen_req.id_absensi,
// view_absen_req.npk,view_absen_req.nama,view_absen_req.employee_shift, view_absen_req.grp,view_absen_req.dept_account,
// view_absen_req.req_work_date,view_absen_req.req_date_in,view_absen_req.req_date_out,view_absen_req.req_in,
// view_absen_req.req_out,view_absen_req.req_code,CONCAT(view_absen_req.req_status_absen,view_absen_req.req_status) AS `status`,view_absen_req.req_status, view_absen_req.req_status_absen
// FROM view_absen_req ";
// echo filtergenerator($link, $level, $generate, $origin_query, $access_org);
// $query_ = mysqli_query($link, filtergenerator($link, $level, $generate, $origin_query, $access_org))or die(mysqli_error($link));
// while($data = mysqli_fetch_assoc($query_)){
//     echo $data['npk']."<br>";
// }
// echo "level User : ".$level."<br>";
// echo "npk : ".$npk."<br>";
// echo "sub_post : ".$sub_post."<br>";
// echo "pos_leader : ".$post."<br>";
// echo "group : ".$group."<br>";
// echo "section : ".$sect."<br>";
// echo "department : ".$dept."<br>";
// echo "administratif : ".$dept_account."<br>";
// echo "division : ".$div."<br>";
// echo "plant : ".$plant."<br>";
// echo "table yang diakses : ".$table."<br>";
// echo "part table yang diakses : ".$part."<br>";
// echo "field org yang diakses / maksimal akses yang diberikan : ".$access_org."<br>";
// echo "field yang direquest untuk diambil nilainya dari table $table : ".$field_request."<br>";
// echo "field1 yang dipakai untuk conditional statement pada table $table : ".$table_field1."<br>";
// echo "field2 yang dipakai untuk conditional statement pada table $table : ".$table_field2."<br>";
// echo "id organisasi yang diakses sebagai monitoring : ".$data."<br>";
// echo "query yang dijalankan : ".$generate."<br>";
// $sql = mysqli_query($link, $generate)or die(mysqli_error($link));
// echo mysqli_num_rows($sql);
// echo $id."<br>";
// echo $ket."<br>";
// echo $req_shift."<br>";
?>