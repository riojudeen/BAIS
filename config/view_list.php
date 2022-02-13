<?php
$qryAbsenHr = "SELECT 
                                    
absensi.id AS id_absensi,
absensi.npk AS npk,

karyawan.nama AS nama,
karyawan.shift AS employee_shift,

org.sub_post AS sub_post,
org.post AS post,
org.grp AS grp,
org.sect AS sect,
org.dept AS dept,
org.dept_account AS dept_account,
org.division AS division,
org.plant AS plant,

absensi.shift AS att_shift,
absensi.date AS work_date,
absensi.check_in AS check_in,
absensi.check_out AS check_out,
absensi.ket AS code,

req_absensi.shift AS req_shift,
req_absensi.date AS req_work_date,
req_absensi.date_in AS req_date_in,
req_absensi.date_out AS req_date_out,
req_absensi.check_in AS req_in,
req_absensi.check_out AS req_out,
req_absensi.keterangan AS req_code,
attendance_code.keterangan AS keterangan,

req_absensi.requester AS requester,
req_absensi.status AS req_status_absen,
req_absensi.req_status AS req_status,
req_absensi.req_date AS req_date,


attendance_code.type AS att_type,
attendance_code.alias AS att_alias



FROM absensi
JOIN org ON absensi.npk = org.npk
LEFT JOIN karyawan ON org.npk = karyawan.npk
LEFT JOIN req_absensi ON absensi.id = req_absensi.id_absensi
LEFT JOIN attendance_code ON attendance_code.kode = req_absensi.keterangan";

$qryAbsenReq = "SELECT 
                                    
            req_absensi.id AS id_absensi,
            req_absensi.npk AS npk,

            karyawan.nama AS nama,
            karyawan.shift AS employee_shift,

            org.sub_post AS sub_post,
            org.post AS post,
            org.grp AS grp,
            org.sect AS sect,
            org.dept AS dept,
            org.dept_account AS dept_account,
            org.division AS division,
            org.plant AS plant,

            req_absensi.shift AS req_shift,
            req_absensi.date AS req_work_date,
            req_absensi.date_in AS req_date_in,
            req_absensi.date_out AS req_date_out,
            req_absensi.check_in AS req_in,
            req_absensi.check_out AS req_out,
            req_absensi.keterangan AS req_code,
            attendance_code.keterangan AS keterangan,

            req_absensi.requester AS requester,
            req_absensi.status AS req_status_absen,
            req_absensi.req_status AS req_status,
            req_absensi.req_date AS req_date,

            absensi.shift AS att_shift,
            absensi.date AS work_date,
            absensi.check_in AS check_in,
            absensi.check_out AS check_out,
            absensi.ket AS code,

            attendance_code.type AS att_type,
            attendance_code.alias AS att_alias

            FROM req_absensi
            JOIN org ON req_absensi.npk = org.npk
            LEFT JOIN karyawan ON org.npk = karyawan.npk
            LEFT JOIN absensi ON absensi.id = req_absensi.id_absensi
            LEFT JOIN attendance_code ON attendance_code.kode = req_absensi.keterangan";