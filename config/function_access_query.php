<?php
//mendapatkan table akses user
function table_access($link, $level, $request, $id_area, $addclause){
    $clase = $addclause;
    if($request == 'lembur'){
        $maintable = 'lembur._id AS id_lembur, 
            lembur.kode_lembur AS kode_lembur, 
            lembur.requester AS requester_lembur, 
            lembur.npk AS npk_lembur, 
            lembur.in_date AS in_date_lembur, 
            lembur.out_date AS out_date_lembur,
            lembur.in_lembur AS in_lembur, 
            lembur.out_lembur AS out_lembur, 
            lembur.kode_job AS kode_job_lembur, 
            lembur.aktifitas AS aktifitas_lembur, 
            lembur.tanggal_input AS tanggal_input_lembur, 
            lembur.status_approve AS status_approve_lembur,
            lembur.status AS status_lembur';
        $concate = 'lembur.status_approve, lembur.status';
        $query_second_table = 'kode_lembur.kode_lembur AS ot_kode,
            kode_lembur.nama AS nama_kode';
        $main_table = 'lembur';
        $second_table = 'kode_lembur';
        $key_main = 'lembur.npk';
        $key_foreign = 'lembur.kode_job';
        $key_second = 'kode_lembur.kode_lembur';
        
    }else if($request = 'absensi'){
        $maintable = 'req_absensi.id AS id_absen,
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
            req_absensi.req_date AS req_date';
            
        $query_second_table = 'attendance_code.kode AS kode_absen,
            attendance_code.keterangan AS ket_kode_absen,
            attendance_code.type AS tipe_kode_absen';
        $concate = 'CONCATE(req_absensi.status, req_absensi.req_status)';
        $main_table = 'absensi';
        $second_table = 'attendance_code';
        $key_main = 'absensi.npk';
        $key_foreign = 'absensi.ket';
        $key_second = 'attendance_code.kode';
    }
    
    //query karyawan 
    $karyawan = 'karyawan.npk AS npk_,
        karyawan.nama AS nama_,
        karyawan.shift AS shift_';
    
    $plant = 'company.id_company AS id_company ,
        company.nama AS nama_company ,
        company.npk_cord AS direktur';
    $division = 'division.id_div AS id_div ,
        division.nama_divisi AS nama_divisi ,
        division.npk_cord AS div_cord ,
        division.id_company AS div_company';
    $dept_account = 'dept_account.id_dept_account AS id_dept_account , 
        dept_account.department_account  AS department_account , 
        dept_account.npk_dept AS dept_acc_cord , 
        dept_account.id_div AS deptAcc_div';
    $department = 'department.id_dept AS id_dept, 
        department.dept AS department, 
        department.npk_cord AS cord_dept, 
        department.id_div AS dept_div';
    $section = 'section.id_section AS id_section ,
        section.section AS nama_section ,
        section.npk_cord AS sect_npk ,
        section.id_dept AS section_dept';
    $grpfrm = 'groupfrm.id_group AS idGroup,
        groupfrm.nama_group AS groupfrm,
        groupfrm.npk_cord AS group_cord,
        groupfrm.id_section AS id_sect';
    $pos = 'pos_leader.id_post AS idPos,
        pos_leader.nama_pos AS pos,
        pos_leader.npk_cord AS pos_cord,
        pos_leader.id_group AS id_group';
    $org = 'org.npk AS npk_org,
        org.sub_post AS sub_post,
        org.post AS post,
        org.grp AS grp,
        org.sect AS sect,
        org.dept AS dept,
        org.dept_account AS dept_account,
        org.division AS division,
        org.plant AS plant';

   
    $key_karyawan = 'karyawan.npk';
    $key_org = 'org.npk';
    $key_plant = 'company.id_company';
    $key_division = 'division.id_div';
    $key_dept_account = 'dept_account.id_dept_account';
    $key_department = 'department.id_dept';
    $key_section = 'section.id_section';
    $key_grpfrm = 'groupfrm.id_group';
    $key_pos = 'pos_leader.id_post';

    switch($level){
        case 1:
            $result = 'sub_post';
            break;
        case 2:
            $result = 'post';
            break;
        case 3:
            $result = 'grp';
            break;
        case 4:
            $result = 'sect';
            break;
        case 5:
            $result = 'dept';
            break;
        case 6:
            $result = 'dept_account';
            break;
        case 7:
            $result = 'plant';
            break;
        case 8:
            $result = 'plant';
            break;
    }
    $query = "SELECT $maintable , $query_second_table , $org , $plant , $division , $dept_account , $department , $section , $grpfrm , $pos , $karyawan,
        CONCAT($concate) AS arsip
        FROM $main_table
        JOIN org ON $key_main = $key_org
        JOIN pos_leader ON org.post = $key_pos
        JOIN groupfrm ON org.grp = $key_grpfrm
        JOIN section ON org.sect = $key_section
        JOIN department ON org.dept = $key_department
        JOIN dept_account ON org.dept_account = $key_dept_account
        JOIN division ON org.division = $key_division
        JOIN company ON org.plant = $key_plant
        JOIN karyawan ON $key_org = $key_karyawan
        JOIN $second_table ON $key_foreign = $key_second
        WHERE org.$result = '$id_area' $clase ";
    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
    return $sql;
    
}
//query jumlah
