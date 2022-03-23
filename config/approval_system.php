<?php
include_once('config.php');

function strukturOrg($link, $part, $id_area){
    if($id_area != ''){
        if($part == 'pos'){
            $query = "SELECT 
            pos_leader.id_post AS idPost,
            pos_leader.nama_pos AS pos,
            pos_leader.npk_cord AS post_cord,
            pos_leader.id_group AS leader,
    
            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,
    
            section.id_section AS idSect,
            section.section AS section,
            section.npk_cord AS spv,
            section.id_dept AS id_dept,
    
            department.id_dept AS idDept,
            department.dept AS dept,
            department.npk_cord AS dept_cord,
            department.id_div AS id_div,
    
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
    
            FROM pos_leader
            JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
            JOIN section ON groupfrm.id_section = section.id_section
            JOIN department ON section.id_dept = department.id_dept
            JOIN division ON department.id_div = division.id_div
            JOIN company ON division.id_company = company.id_company WHERE pos_leader.id_post = '$id_area' ";

            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = (isset($data['idPost']))?$data['idPost']:'';
            $group = (isset($data['idGroup']))?$data['idGroup']:'';
            $section = (isset($data['idSect']))?$data['idSect']:'';
            $dept = (isset($data['idDept']))?$data['idDept']:'';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = '';

        }else if($part == 'group'){
            $query = "SELECT 
            groupfrm.id_group AS idGroup,
            groupfrm.nama_group AS groupfrm,
            groupfrm.npk_cord AS group_cord,
            groupfrm.id_section AS id_sect,
    
            section.id_section AS idSect,
            section.section AS section,
            section.npk_cord AS spv,
            section.id_dept AS id_dept,
    
            department.id_dept AS idDept,
            department.dept AS dept,
            department.npk_cord AS dept_cord,
            department.id_div AS id_div,
    
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
    
            FROM  groupfrm 
            JOIN section ON groupfrm.id_section = section.id_section
            JOIN department ON section.id_dept = department.id_dept
            JOIN division ON department.id_div = division.id_div
            JOIN company ON division.id_company = company.id_company WHERE groupfrm.id_group = '$id_area'";

            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = '';
            $group = (isset($data['idGroup']))?$data['idGroup']:'';
            $section = (isset($data['idSect']))?$data['idSect']:'';
            $dept = (isset($data['idDept']))?$data['idDept']:'';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = '';
            
        }else if($part == 'section'){
            $query = "SELECT 
            section.id_section AS idSect,
            section.section AS section,
            section.npk_cord AS spv,
            section.id_dept AS id_dept,
    
            department.id_dept AS idDept,
            department.dept AS dept,
            department.npk_cord AS dept_cord,
            department.id_div AS id_div,
    
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
    
            FROM  section
            JOIN department ON section.id_dept = department.id_dept
            JOIN division ON department.id_div = division.id_div
            JOIN company ON division.id_company = company.id_company WHERE section.id_section = '$id_area'";

            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = '';
            $group = '';
            $section = (isset($data['idSect']))?$data['idSect']:'';
            $dept = (isset($data['idDept']))?$data['idDept']:'';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = '';
            
        }else if($part == 'dept'){
            $query = "SELECT 
            department.id_dept AS idDept,
            department.dept AS dept,
            department.npk_cord AS dept_cord,
            department.id_div AS id_div,
    
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
    
            FROM department 
            JOIN division ON department.id_div = division.id_div
            JOIN company ON division.id_company = company.id_company WHERE department.id_dept = '$id_area'";

            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = '';
            $group = '';
            $section = '';
            $dept = (isset($data['idDept']))?$data['idDept']:'';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = '';
        }else if($part == 'division'){
            $query = "SELECT 
           
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
    
            FROM division
            JOIN company ON division.id_company = company.id_company WHERE division.id_div = '$id_area'";
            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = '';
            $group = '';
            $section = '';
            $dept = '';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = '';
        }else if($part == 'deptacc'){
            $query = "SELECT 

            dept_account.id_dept_account AS idDeptAcc,
            dept_account.department_account AS deptAcc,
            dept_account.npk_dept AS mg, 
            dept_account.id_div AS id_div,
            
            division.id_div AS idDiv,
            division.nama_divisi AS divisi,
            division.npk_cord AS dh,
            division.id_company AS id_company,
    
            company.id_company AS idCompany,
            company.nama AS namaCompany ,
            company.npk_cord AS directure
            FROM dept_account 
            JOIN division ON dept_account.id_div = division.id_div
            JOIN company ON division.id_company = company.id_company WHERE dept_account.id_dept_account = '$id_area'";
            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($sql);
            $pos = '';
            $group = '';
            $section = '';
            $dept = '';
            $division = (isset($data['idDiv']))?$data['idDiv']:'';
            $plant = (isset($data['idCompany']))?$data['idCompany']:'';
            $dept_account = (isset($data['idDeptAcc']))?$data['idDeptAcc']:'';
        }else{
            $pos = '';
            $group = '';
            $section = '';
            $dept = '';
            $division = '';
            $plant = '';
            $dept_account = '';
        }
    }else{
        $pos = '';
        $group = '';
        $section = '';
        $dept = '';
        $division = '';
        $plant = '';
        $dept_account = '';
    }
    return array($pos,$group,$section,$dept,$division,$plant,$dept_account);
}
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
function orgAccess_joinAbsen($level, $table){
    if($level == 1){
        // general user
        $access = $table.".npk";
    }else if($level == 2){
        // special user
        $access = $table.".npk";
    }else if($level == 3){
        // foreman
        $access = $table.".grp";
    }else if($level == 4){
        // section head
        $access = $table.".sect";
    }else if($level == 5){
        // manajemen
        $access = $table.".dept";
    }else if($level == 6){
        // admin department
        $access = $table.".division";
    }else if($level == 7){
        // admin divisi
        $access = $table.".division";
    }else if($level == 8){
        // admin system
        $access = $table.".division";
    }else{
        $access = $table.".function argumen level user tidak ada";
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
        $data1 = $data4 = $data5 = $data6 = $data8 = "null";
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
    //koneksi database
    $link = $GLOBALS['link'];
    
    if($level >= 1 && $level <= 2){
        $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field1 = '$npkUser' ";
    }else if($level >= 3 && $level <= 8){
        if($level >= 3 && $level <= 5){
            //jika user foreman atau supervisor , meraka hanya bisa mengakses organisasi yang dikoordinir
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field1 = '$npkUser' AND $table.$table_field2 = '$part'  ";
            $sql_org = mysqli_query($link, $query_org);
            if(mysqli_num_rows($sql_org) > 0 ){
                $query_org = $query_org;
            }else{
                $query_org = " SELECT karyawan.npk AS `data` FROM karyawan WHERE karyawan.npk = '$npkUser' ";
            }
        }else if($level >= 6 && $level <= 7){
            // jika admin department , admin division
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field2 = '$part' ";
            $sql_org = mysqli_query($link, $query_org);
            if(mysqli_num_rows($sql_org) > 0 ){
                $query_org = $query_org;
            }else{
                $query_org = " SELECT karyawan.npk AS `data` FROM karyawan WHERE karyawan.npk = '$npkUser' ";
            }
        }else if($level == 8){
            // jika admin sistem bisa mengakses semua data plant
            $query_org = "SELECT $table.$field_request AS `data` FROM $table WHERE $table.$table_field2 = '$part' ";
            $sql_org = mysqli_query($link, $query_org);
            if(mysqli_num_rows($sql_org) > 0 ){
                $query_org = $query_org;
            }else{
                $query_org = " SELECT karyawan.npk AS `data` FROM karyawan WHERE karyawan.npk = '$npkUser' ";
            }
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
        // cek area 
        if($jml > 0){
            // part 
            if($level == 1){
                // general user
                $part = "npk"; //field table untuk kondiwi where statement : WHERE field_data = 'npk' AND $table.$table_field2 = '$part'
               
            }else if($level == 2){
                // special user
                $part = "npk";
               
            }else if($level == 3){
                // foreman
                $part = "group";
               
            }else if($level == 4){
                // section head
                $part = "section";
               
            }else if($level == 5){
                // manajemen
                $part = "dept";
                
            }else if($level == 6){
                // admin department
                $part = "division";
               
            }else if($level == 7){
                // admin divisi
                $part = "division";
               
            }else if($level == 8){
                // admin system
                $part = "division";
                
            }else{
                $part = "function argumen tida lengkap atau salah";
            }
            $npkUser = $GLOBALS['npkUser'];
            $cekArea = mysqli_query($link, " SELECT view_daftar_area.id AS id_area FROM view_daftar_area WHERE cord = '$npkUser' AND part = '$part' ");
            $jmlArea = mysqli_num_rows($cekArea);
            if((($level == 3 || $level == 4 || $level == 5) && $jmlArea > 0) OR ($level == 6 || $level == 7 || $level == 8)){
                $query = " $origin_query WHERE (";
                while($data = mysqli_fetch_assoc($sql)){
                    $query .= " $access_org = '$data[data]' OR";
                }
                $query = substr($query , 0, -2);
                return $query.')';
            }else{
                $query = " $origin_query WHERE (";
                while($data = mysqli_fetch_assoc($sql)){
                    $query .= " npk = '$data[data]' OR";
                }
                $query = substr($query , 0, -2);
                return $query.')';
            }

            
        }

    }else{
        return "tidak akses data";
    }
}
function filtergeneratorJoinAbsen($link, $level, $generate, $origin_query, $access_org){
    if($level >=1 AND $level <= 8){
        
        $sql = mysqli_query($link, $generate)or die(mysqli_error($link));
        $jml = mysqli_num_rows($sql);
        // cek area 
        if($jml > 0){
            // part 
            if($level == 1){
                // general user
                $part = "npk"; //field table untuk kondiwi where statement : WHERE field_data = 'npk' AND $table.$table_field2 = '$part'
               
            }else if($level == 2){
                // special user
                $part = "npk";
               
            }else if($level == 3){
                // foreman
                $part = "group";
               
            }else if($level == 4){
                // section head
                $part = "section";
               
            }else if($level == 5){
                // manajemen
                $part = "dept";
                
            }else if($level == 6){
                // admin department
                $part = "division";
               
            }else if($level == 7){
                // admin divisi
                $part = "division";
               
            }else if($level == 8){
                // admin system
                $part = "division";
                
            }else{
                $part = "function argumen tida lengkap atau salah";
            }
            $npkUser = $GLOBALS['npkUser'];
            $cekArea = mysqli_query($link, " SELECT view_daftar_area.id AS id_area FROM view_daftar_area WHERE cord = '$npkUser' AND part = '$part' ");
            $jmlArea = mysqli_num_rows($cekArea);
            if((($level == 3 || $level == 4 || $level == 5) && $jmlArea > 0) OR ($level == 6 || $level == 7 || $level == 8)){
                $query = " $origin_query WHERE (";
                while($data = mysqli_fetch_assoc($sql)){
                    $query .= " $access_org = '$data[data]' OR";
                }
                $query = substr($query , 0, -2);
                return $query.')';
            }else{
                $query = " $origin_query WHERE (";
                while($data = mysqli_fetch_assoc($sql)){
                    $query .= " view_organization.npk = '$data[data]' OR";
                }
                $query = substr($query , 0, -2);
                return $query.')';
            }

            
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
        $addFilterCari = " AND  ( npk LIKE '%$cari%' OR nama LIKE '%$cari%' )";
    }else{
        $addFilterCari = '';
    }
    $gabung = $addFilter.$addFilterDeptAcc.$addFilterShift.$addFilterCari;
    return $gabung;

}
function filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari){
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
        $addFilterShift = " AND shift = '$shift'";
    }else{
        $addFilterShift = "";
    }
    if($cari != ''){
        $addFilterCari = " AND  ( npk LIKE '%$cari%' OR nama LIKE '%$cari%' )";
    }else{
        $addFilterCari = '';
    }
    $gabung = $addFilter.$addFilterDeptAcc.$addFilterShift.$addFilterCari;
    return $gabung;

}

function filterData_joinAbsen($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari,$table){
    if($div_filter != ''){
        if($dept_filter != ''){
            if($sect_filter != ''){
                if($group_filter != ''){
                    $addFilter = " AND $table.division = '$div_filter' AND $table.dept = '$dept_filter' AND $table.sect = '$sect_filter' AND $table.grp = '$group_filter'";
                }else{
                    $addFilter = " AND $table.division = '$div_filter' AND $table.dept = '$dept_filter' AND $table.sect = '$sect_filter' ";
                }
            }else{
                $addFilter = " AND $table.division = '$div_filter' AND $table.dept = '$dept_filter' ";
            }
        }else{
            $addFilter = " AND $table.division = '$div_filter' ";
        }
    }else{
        $addFilter = "";
    }
    // echo $addFilter;
    if($deptAcc_filter != ''){
        $addFilterDeptAcc =" AND $table.dept_account = '$deptAcc_filter'";
    }else{
        $addFilterDeptAcc ="";
    }
    if($shift != ''){
        $addFilterShift = " AND $table.employee_shift = '$shift'";
    }else{
        $addFilterShift = "";
    }
    if($cari != ''){
        $addFilterCari = " AND  ( view_organization.npk LIKE '%$cari%' OR view_organization.nama LIKE '%$cari%' )";
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
function docOt($tanggal, $data_access, $group, $div){
    $initial = ($group == '')?'-':$group;
    $group = ($group == '')?'-':$group;
    $pecah_tanggal= explode("-", $tanggal);
    $kode_tahun = $pecah_tanggal[0];
    $kode_hari = $pecah_tanggal[2];
    $bln = $pecah_tanggal[1];
        $mList = array(
        '01' => 'I',
        '02' => 'II',
        '03' => 'III',
        '04' => 'IV',
        '05' => 'V',
        '06' => 'VI',
        '07' => 'VII',
        '08' => 'VIII',
        '09' => 'IX',
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII');
    $bln_romawi = $mList[$bln];
    $kode = $div."/OT/$kode_tahun/$bln_romawi/$initial/$data_access/$kode_hari";
    return $kode;
}
// echo docOt($tanggal, $data_access, $group, $div);
?>