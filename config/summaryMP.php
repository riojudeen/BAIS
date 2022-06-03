<?php
// function untuk get menit istirahat overtime
include_once('config.php');

function summaryMP($link, $date){ 
    $query_area = "SELECT DISTINCT view_daftar_area.id AS id, 
    view_daftar_area.nama_org AS nama,
    view_daftar_area.part AS part_area,
    view_daftar_area.id_parent AS id_parent,
    jabatan.jabatan AS jabatan,
    jabatan.id_jabatan AS id_jabatan,
    detail.id AS dept, 
    detail.nama_org AS nama_dept,
    IF(detail.id <> '' OR detail.id IS NOT NULL,
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_division = view_daftar_area.id AND view_organization.id_dept_account = detail.id AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        ), 
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_division = view_daftar_area.id AND view_organization.id_dept_account IS NULL AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        )
    )
          AS total_karyawan
    FROM view_daftar_area
    LEFT JOIN view_organization ON view_organization.id_division = view_daftar_area.id
    JOIN jabatan ON jabatan.id_jabatan = view_organization.jabatan
    LEFT JOIN (SELECT view_organization.id_dept_account , view_daftar_area.id, view_daftar_area.nama_org
        FROM view_organization LEFT JOIN (SELECT nama_org , id, part FROM  view_daftar_area WHERE part = 'deptAcc') view_daftar_area
        ON view_daftar_area.id = view_organization.id_dept_account  GROUP BY view_organization.id_dept_account ) detail

    ON detail.id = view_organization.id_dept_account
    WHERE view_daftar_area.part = 'division' 
    

    UNION ALL 
    SELECT DISTINCT view_daftar_area.id AS id, 
    view_daftar_area.nama_org AS nama,
    view_daftar_area.part AS part_area,
    view_daftar_area.id_parent AS id_parent,
    jabatan.jabatan AS jabatan,
    jabatan.id_jabatan AS id_jabatan,
    detail.id AS dept, 
    detail.nama_org AS nama_dept,
    IF(detail.id <> '' OR detail.id IS NOT NULL,
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_dept = view_daftar_area.id AND view_organization.id_dept_account = detail.id AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        ), 
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_dept = view_daftar_area.id AND view_organization.id_dept_account IS NULL AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        )
    )
        AS total_karyawan
    FROM view_daftar_area
    LEFT JOIN view_organization ON view_organization.id_dept = view_daftar_area.id
    
    JOIN jabatan ON jabatan.id_jabatan = view_organization.jabatan
    LEFT JOIN (SELECT view_organization.id_dept_account , view_daftar_area.id, view_daftar_area.nama_org
        FROM view_organization LEFT JOIN (SELECT nama_org , id, part FROM  view_daftar_area WHERE part = 'deptAcc') view_daftar_area
        ON view_daftar_area.id = view_organization.id_dept_account  GROUP BY view_organization.id_dept_account ) detail

    ON detail.id = view_organization.id_dept_account
    WHERE view_daftar_area.part = 'dept'

    UNION ALL 
    SELECT DISTINCT view_daftar_area.id AS id, 
    view_daftar_area.nama_org AS nama,
    view_daftar_area.part AS part_area,
    view_daftar_area.id_parent AS id_parent,
    jabatan.jabatan AS jabatan,
    jabatan.id_jabatan AS id_jabatan,
    detail.id AS dept, 
    detail.nama_org AS nama_dept,
    IF(detail.id <> '' OR detail.id IS NOT NULL,
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_sect = view_daftar_area.id AND view_organization.id_dept_account = detail.id AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        ), 
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_sect = view_daftar_area.id AND view_organization.id_dept_account IS NULL AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        )
    )
        AS total_karyawan
    FROM view_daftar_area
    LEFT JOIN view_organization ON view_organization.id_sect = view_daftar_area.id
    
    JOIN jabatan ON jabatan.id_jabatan = view_organization.jabatan
    LEFT JOIN (SELECT view_organization.id_dept_account , view_daftar_area.id, view_daftar_area.nama_org
        FROM view_organization LEFT JOIN (SELECT nama_org , id, part FROM  view_daftar_area WHERE part = 'deptAcc') view_daftar_area
        ON view_daftar_area.id = view_organization.id_dept_account  GROUP BY view_organization.id_dept_account ) detail

    ON detail.id = view_organization.id_dept_account
    WHERE view_daftar_area.part = 'section'

    UNION ALL 
    SELECT DISTINCT view_daftar_area.id AS id, 
    view_daftar_area.nama_org AS nama,
    view_daftar_area.part AS part_area,
    view_daftar_area.id_parent AS id_parent,
    jabatan.jabatan AS jabatan,
    jabatan.id_jabatan AS id_jabatan,
    detail.id AS dept, 
    detail.nama_org AS nama_dept,
    IF(detail.id <> '' OR detail.id IS NOT NULL,
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_grp = view_daftar_area.id AND view_organization.id_dept_account = detail.id AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        ), 
        ( SELECT COUNT(view_organization.npk)
            FROM view_organization
            WHERE view_organization.id_grp = view_daftar_area.id AND view_organization.id_dept_account IS NULL AND jabatan.id_jabatan = view_organization.jabatan
            -- WHERE view_organization.id_division = view_daftar_area.id AND jabatan.id_jabatan = view_organization.jabatan
        )
    )
        AS total_karyawan
    FROM view_daftar_area
    LEFT JOIN view_organization ON view_organization.id_grp = view_daftar_area.id
    
    JOIN jabatan ON jabatan.id_jabatan = view_organization.jabatan
    LEFT JOIN (SELECT view_organization.id_dept_account , view_daftar_area.id, view_daftar_area.nama_org
        FROM view_organization LEFT JOIN (SELECT nama_org , id, part FROM  view_daftar_area WHERE part = 'deptAcc') view_daftar_area
        ON view_daftar_area.id = view_organization.id_dept_account  GROUP BY view_organization.id_dept_account ) detail

    ON detail.id = view_organization.id_dept_account
    WHERE view_daftar_area.part = 'group' "; 
    
    
    $sql_area = mysqli_query($link, $query_area)or die(mysqli_error($link)); 
    // mysqli_query($link, "DELETE karyawan_record");
    $cek = mysqli_query($link, "SELECT `date`  FROM karyawan_record WHERE `date` = '$date' ")or die(mysqli_error($link));
    $q_cek = mysqli_query($link, "SELECT MAX(id) AS id FROM karyawan_record ")or die(mysqli_error($link));
    if(mysqli_num_rows($cek) <= 0){
        $sql_cek = mysqli_fetch_assoc($q_cek);
        $id = $sql_cek['id']+1;
        if(mysqli_num_rows($sql_area)>0){ 
            while($data = mysqli_fetch_assoc($sql_area)){ 
                $id_area = $data['id'];
                $nama_area = $data['nama'];
                $id_jabatan = $data['id_jabatan'];
                $date = $date;
                $updated = Date('Y-m-d');
                $part = $data['part_area'];
                $mp = $data['total_karyawan'];
                $dept_account = $data['dept'];
                // mysqli_query($link, "UPDATE karyawan_record SET id = '$id', id_area = '$id_area' , part = '$part' , nama_area = '$nama_area', id_jabatan = '$id_jabatan' , `date` = '$date' , updated = '$updated' ")or die(mysqli_error($link));
                mysqli_query($link, "INSERT INTO karyawan_record (`id`, `id_area`, `part`, `nama_area`, `id_jabatan`, `id_dept_account`, `date`, `updated` , `mp` ) VALUES ('$id' , '$id_area' , '$part' , '$nama_area', '$id_jabatan' , '$dept_account' , '$date', '$updated', '$mp' ) ")or die(mysqli_error($link));
                $id++;
            }
        
        } 
    
    }else{
        echo "ga perlu update";
    }
    
} 

// summaryMP($link, $date);
function summaryAtt($link, $date){
    $q_absensi = "SELECT (COUNT(view_absen_hr.npk)) AS attends 
        FROM (
                SELECT  view_absen_hr.npk AS npk , view_absen_hr.dept_account , view_absen_hr.division , view_absen_hr.dept, view_absen_hr.sect, view_absen_hr.grp,
                view_absen_hr.att_alias , karyawan.jabatan FROM view_absen_hr 
                LEFT JOIN karyawan ON karyawan.npk = view_absen_hr.npk WHERE view_absen_hr.work_date = '$date'
            ) view_absen_hr ";
    $q_mp = "SELECT id , id_area , nama_area, part, id_jabatan , id_dept_account, `date` FROM karyawan_record WHERE  `date` = '$date' ";
    $sql_mp = mysqli_query($link, $q_mp)or die(mysqli_error($link));
    if(mysqli_num_rows($sql_mp) > 0){
        while($data_mp = mysqli_fetch_assoc($sql_mp)){
            // echo $data_mp['nama_area']." - ".$data_mp['id_dept_account']." - ".$data_mp['part']." - ".$data_mp['id_jabatan']." - ";
            if($data_mp['part'] == 'division'){
                $query= " WHERE view_absen_hr.dept_account = '$data_mp[id_dept_account]' AND view_absen_hr.division = '$data_mp[id_area]' AND view_absen_hr.jabatan = '$data_mp[id_jabatan]'  ";
            }else if($data_mp['part'] == 'dept'){
                $query= " WHERE view_absen_hr.dept_account = '$data_mp[id_dept_account]' AND view_absen_hr.dept = '$data_mp[id_area]' AND view_absen_hr.jabatan = '$data_mp[id_jabatan]' ";
            }else if($data_mp['part'] == 'section'){
                $query= " WHERE view_absen_hr.dept_account = '$data_mp[id_dept_account]' AND view_absen_hr.sect = '$data_mp[id_area]' AND view_absen_hr.jabatan = '$data_mp[id_jabatan]' ";
            }else if($data_mp['part'] == 'group'){
                $query= " WHERE view_absen_hr.dept_account = '$data_mp[id_dept_account]' AND view_absen_hr.grp = '$data_mp[id_area]' AND view_absen_hr.jabatan = '$data_mp[id_jabatan]' ";
            }
            $sql_absensi = mysqli_query($link, $q_absensi.$query)or die(mysqli_error($link));
            $data_absensi = mysqli_fetch_assoc($sql_absensi );
            $attends = $data_absensi['attends'];
            mysqli_query($link, "UPDATE karyawan_record SET attends = '$attends' WHERE id = '$data_mp[id]' ")or die(mysqli_error($link));
            // echo $attends."<br>";
            // echo $q_absensi.$query."<br>";
        }
    }
}

    
?>
