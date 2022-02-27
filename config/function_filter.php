<?php
//filter area
function area_jabatan($link, $jabatan, $npkUser){
    $q_levelJab = mysqli_query($link, "SELECT * FROM jabatan WHERE id_jabatan = '$jabatan' ");
    $levelJab = mysqli_fetch_assoc($q_levelJab);
    $s_levelJab = $levelJab['level'];
    if($s_levelJab >= 1 && $s_levelJab <= 2){
        //division head
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, division FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift

        FROM department LEFT JOIN karyawan ON department.npk_cord = karyawan.npk
        WHERE  department.id_div = '$dataArea[division]'")or die(mysqli_error($link));
        return $sArea;

    }else if($s_levelJab >= 3 && $s_levelJab <= 4){
        //department head
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, dept FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        section.id_section AS id_area,
        section.section AS nama_area,
        section.npk_cord AS cordinator,
        section.id_dept AS id_parent,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift

        FROM section LEFT JOIN karyawan ON section.npk_cord = karyawan.npk
        WHERE  section.id_dept = '$dataArea[dept]'")or die(mysqli_error($link));
        return $sArea;
        
    }else if($s_levelJab >= 5 && $s_levelJab <= 6){
        //section head
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, sect FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        groupfrm.id_group AS id_area,
        groupfrm.nama_group AS nama_area,
        groupfrm.npk_cord AS cordinator,
        groupfrm.id_section AS id_parent,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift

        FROM groupfrm LEFT JOIN karyawan ON groupfrm.npk_cord = karyawan.npk
        WHERE  groupfrm.id_section = '$dataArea[sect]'")or die(mysqli_error($link));
        return $sArea;
    }else if($s_levelJab >= 7 && $s_levelJab <= 8){
        //foreman
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, grp FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        pos_leader.id_post AS id_area,
        pos_leader.nama_pos AS nama_area,
        pos_leader.npk_cord AS cordinator,
        pos_leader.id_group AS id_parent,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift

        FROM pos_leader JOIN karyawan ON pos_leader.npk_cord = karyawan.npk
        WHERE  pos_leader.id_group = '$dataArea[grp]'")or die(mysqli_error($link));
        return $sArea;
    
    }else if($s_levelJab >= 9 && $s_levelJab <= 10){
        //team leader
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, post FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        org.npk AS npk_org,
        org.post AS post,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift,

        pos_leader.id_post AS id_area,
        pos_leader.nama_pos AS nama_area,
        pos_leader.npk_cord AS cordinator,
        pos_leader.id_group AS id_parent

        FROM karyawan JOIN org ON org.npk = karyawan.npk
        JOIN pos_leader ON pos_leader.id_post = org.post
        WHERE  karyawan.npk = '$dataArea[npk]'")or die(mysqli_error($link));
        return $sArea;
    }else if($s_levelJab == 11){
        //team member
        //cari akses id area
        $qry_area = mysqli_query($link, "SELECT npk, post FROM org WHERE npk = '$npkUser' 
        ")or die(mysqli_error($link));
        $dataArea = mysqli_fetch_assoc($qry_area);

        $sArea = mysqli_query($link, "SELECT 
        org.npk AS npk_org,
        org.post AS post,

        karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift,

        pos_leader.id_post AS id_area,
        pos_leader.nama_pos AS nama_area,
        pos_leader.npk_cord AS cordinator,
        pos_leader.id_group AS id_parent

        FROM karyawan 
        JOIN org ON org.npk = karyawan.npk
        JOIN pos_leader ON pos_leader.id_post = org.post
        WHERE  karyawan.npk = '$dataArea[npk]'")or die(mysqli_error($link));

        return $sArea;
    }
    
        


}
function area($link, $level, $access_){
    // $tbl_division = " division.id_div AS id_area,
    //     division.nama_divisi AS nama_area,
    //     division.npk_cord AS cordinator,
    //     division.id_company AS id_parent";
    $tbl_deptAcc = "dept_account.id_dept_account AS id_area,
        dept_account.department_account AS nama_area,
        dept_account.npk_dept AS cordinator, 
        dept_account.id_div AS id_parent";
    $tbl_dept = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";
    $tbl_sect = "section.id_section AS id_area,
        section.section AS nama_area,
        section.npk_cord AS cordinator,
        section.id_dept AS id_parent";

    $tbl_grp = "groupfrm.id_group AS id_area,
        groupfrm.nama_group AS nama_area,
        groupfrm.npk_cord AS cordinator,
        groupfrm.id_section AS id_parent";
       
    $tbl_post = "pos_leader.id_post AS id_area,
        pos_leader.nama_pos AS nama_area,
        pos_leader.npk_cord AS cordinator,
        pos_leader.id_group AS id_parent";
        
    $tbl_karyawan = "karyawan.npk AS npk,
        karyawan.nama AS nama,
        karyawan.shift AS shift";
    $org = 'org.npk AS npk_org,
        org.sub_post AS sub_post,
        org.post AS post,
        org.grp AS grp,
        org.sect AS sect,
        org.dept AS dept,
        org.dept_account AS dept_account,
        org.division AS division,
        org.plant AS plant';

        
    //jika dia foreman maka akses filter area adalah pos leader
    switch($level){
        case 1:
            $select = $tbl_post;
            $tbl = 'pos_leader';
            $cord = 'pos_leader.npk_cord';
            $id_parent = 'pos_leader.id_post';
            break;
        case 2:
            $select = $tbl_deptAcc;
            $tbl = 'dept_account';
            $cord = 'dept_account.npk_dept';
            $id_parent = 'pos_leader.npk_cord';
            break;
        case 3:
            $select = $tbl_post;
            $tbl = 'pos_leader';
            $cord = 'pos_leader.npk_cord';
            $id_parent = 'pos_leader.id_group';
            break;
        case 4:
            $select = $tbl_grp;
            $tbl = 'groupfrm';
            $cord = 'groupfrm.npk_cord';
            $id_parent = 'groupfrm.id_section';
            break;
        case 5:
            $select = $tbl_dept;
            $tbl = 'department';
            $cord = 'department.npk_cord';
            $id_parent = 'department.id_div';
            break;
        case 6:
            $select = $tbl_grp;
            $tbl = 'groupfrm';
            $cord = 'groupfrm.npk_cord';
            $id_parent = 'groupfrm.id_section';
            break;
        case 7:
            $select = $tbl_sect;
            $tbl = 'dept_account';
            $cord = 'dept_account.npk_dept';
            $id_parent = 'dept_account.id_div';
            break;
        case 8:
            $select = $tbl_deptAcc;
            $tbl = 'dept_account';
            $cord = 'dept_account.npk_dept';
            $id_parent = 'dept_account.id_div';
            break;
    }
    // cek id area di table org
    if($level == 6){
        $qry = "SELECT $select, $tbl_karyawan, $org
        FROM org 
        JOIN $tbl ON org.grp = groupfrm.id_group
        LEFT JOIN karyawan ON $cord = karyawan.npk
        WHERE org.dept_account = '$access_' ";
    }else{
        $qry = "SELECT $select, $tbl_karyawan
        FROM $tbl LEFT JOIN karyawan ON $cord = karyawan.npk
        WHERE $id_parent = '$access_' ";
    }
    $sql = mysqli_query($link, $qry)or die(mysqli_error($link));
    return  $sql;
}
function access_area($level){
    switch($level){
        case 1:
            $select = 'org.npk';
            break;
        case 2:
            $select = 'org.division';
            break;
        case 3:
            $select = 'org.post';
            break;
        case 4:
            $select = 'org.grp';
            break;
        case 5:
            $select = 'org.dept';
            break;
        case 6:
            $select = 'org.dept';
            break;
        case 7:
            $select = 'org.division';
            break;
        case 8:
            $select = 'org.division';
            break;
    }
    return $select;
}

function access_area_level($level){
    switch($level){
        case 1:
            $parent_org = 'org.post';
            $select = 'org.npk';
            $sub_select = 'org.npk';
            
            break;
        case 2:
            $parent_org = 'org.division';
            $select = 'org.division';
            $sub_select = 'org.dept';
            break;
        case 3:
            $parent_org = 'org.grp';
            $select = 'org.post';
            $sub_select = 'org.post';

            break;
        case 4:
            $parent_org = 'org.sect';
            $select = 'org.grp';
            $sub_select = 'org.post';
            
            break;
        case 5:
            $parent_org = 'org.dept';
            $select = 'org.dept';
            $sub_select = 'org.sect';

            break;
        case 6:
            $parent_org = 'org.dept_account'; //parent data pertama yang diseleksi berdasarkan admin dept
            $select = 'org.dept';
            $sub_select = 'org.sect';
            
            break;
        case 7:
            $parent_org = 'org.division';
            $select = 'org.division';
            $sub_select = 'org.dept';
            break;
        case 8:
            $parent_org = 'org.division';
            $select = 'org.division';
            $sub_select = 'org.dept';
            break;
    }
    return array($select, $parent_org, $sub_select);
}

function access_area_jabatan($link, $jabatan, $npkUser){
    $q_levelJab = mysqli_query($link, "SELECT * FROM jabatan WHERE id_jabatan = '$jabatan' ");
    $levelJab = mysqli_fetch_assoc($q_levelJab);
    $s_levelJab = $levelJab['level'];

    if($s_levelJab >= 1 && $s_levelJab <= 2){
        $select = 'org.division';
        $sub_select = 'org.dept';
    }else if($s_levelJab >= 3 && $s_levelJab <= 4){
        $select = 'org.dept';
        $sub_select = 'org.sect';
    }else if($s_levelJab >= 5 && $s_levelJab <= 6){
        $select = 'org.sect';
        $sub_select = 'org.grp';
    }else if($s_levelJab >= 7 && $s_levelJab <= 8){
        $select = 'org.grp';
        $sub_select = 'org.post';
    }else if($s_levelJab >= 9 && $s_levelJab <= 10){
        $select = 'org.post';
        $sub_select = 'org.npk';
    }else if($s_levelJab == 11){
        $select = 'org.npk';
        $sub_select = 'org.npk';
    }
    $explode = explode('.', $select);
    $clm = $explode['1'];
    $sql_value = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ");
    $value = mysqli_fetch_assoc($sql_value);
    $value_area = $value[$clm];
    return array($clm , $select, $sub_select, $value_area);
}