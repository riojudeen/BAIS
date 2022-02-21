<?php
//default timezone untuk upload file supaya set waktunya sesuai //
// error_reporting(1);
date_default_timezone_set('Asia/Jakarta');

//untuk memulai session (session pemanggilan header)//
session_start();

//koneksi database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bais_db";
$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

$hostmos = 'localhost';
$usernamemos = 'root';
$passwordmos = ''; 
$databasemos = 'mosv2_db'; 
// Conn w/ PDO
$pdomos = new PDO('mysql:host='.$hostmos.';dbname='.$databasemos, $usernamemos, $passwordmos);
$cnt = mysqli_connect($hostmos, $usernamemos, $passwordmos, $databasemos);

    $host = 'localhost';
    $username = 'root';
    $password = ''; 
    $database = ''; 
    // Conn w/ PDO
    $pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    $cnts = mysqli_connect($host, $username, $password, $database);

$db_mos = "mosv2_db";
$db_bais = "bais_db";
// defaut password
function default_password($tgl){
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    return sha1($tanggal.$bulan.$tahun);
}
function default_username($npk){
    return "body".$npk;
}
//Total Day in Month
function TotalDays($dates){
    $setthn= date("Y", strtotime($dates));
    $setbln = date("m", strtotime($dates));
    $kal = CAL_GREGORIAN;

    $hitmax= cal_days_in_month($kal,$setbln,$setthn);

    return $hitmax;
  }

//DateConvert
function firstDay($dates){
    $setthn= date("Y", strtotime($dates));
    $setbln = date("m", strtotime($dates));
    $sethari = date("01", strtotime($dates));
    $nowDate=$setthn.'-'.$setbln.'-'.$sethari;
    return $nowDate;
}

//periksa koneksi, tampilkan pesan kesalahan jika gagal
if(!$link){
  die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
       " - ".mysqli_connect_error());
}

//membuat base url , biasanya digunakan jika project diupload di web hosting sehingga base url akan sesuai//
function base_url($url = null){
    $base_url = "/BAIS";
    //jika ada url /url = null //
    if($url != null){
        //maka url akan berubah menjadi http://localhost/BAIS + /url direktori//
        return $base_url."/".$url;
    }
        //jika tidak ada url , maka url akan berubah menjadi http://localhost/BAIS saja
    else {
        return $base_url;
    }
}
function shift_ubah($shift_){
    $shiftHR = $shift_ ;

    if($shiftHR == "SHFA"){
        $shfDB = 'A';
    }else if($shiftHR == "SHFB"){
        $shfDB = 'B';
    }else if($shiftHR== 'NSHF'){
        $shfDB = 'N';
    }else{
        $shfDB = "";
    }
    $shf = $shfDB;
    return $shf;
}
///menyimpan data user
if(isset($_SESSION['user'])){
    $npkUser = $_SESSION['user'];
    $dataUser = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM karyawan WHERE npk = '$npkUser' "))or die(mysqli_error($link));
    $union = mysqli_query($link, "SELECT id_div AS id , nama_divisi AS nama_org , npk_cord AS cord , id_company AS id_parent , part AS part FROM division WHERE id_div='$dataUser[id_area]'
        UNION ALL SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent, part AS part FROM department WHERE id_dept='$dataUser[id_area]'
        UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part FROM section WHERE id_section='$dataUser[id_area]'
        UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part FROM groupfrm WHERE id_group='$dataUser[id_area]'
        UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part FROM pos_leader WHERE id_post='$dataUser[id_area]'")or die(mysqli_error($link));
    $sqlArea = mysqli_fetch_assoc($union);
    $areaUser = (isset($sqlArea['nama_org']))?$sqlArea['nama_org']:"";
    $idAreaUser = (isset($sqlArea['id']))?$sqlArea['id']:"";
    $accUser = $dataUser['department'];
    $jabatan = $dataUser['jabatan'];
    $role = $_SESSION['level'];
    $q_level_jabatan = mysqli_query($link, "SELECT * FROM jabatan WHERE id_jabatan = '$jabatan' ")or die(mysqli_error($link));
    $s_levelJabatan = mysqli_fetch_assoc($q_level_jabatan);
    $levelJabatan = $s_levelJabatan['level'];
    $sql_role = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$role' "));
    $namaRole = $sql_role['role_name'];
    $level = $sql_role['level'];
    $namaUser = $dataUser['nama'];

    //nama depan
    $pecah = explode(" ",$namaUser);
    $nick = $pecah[0];
    $npk_user =$npkUser;

    function nick($nama){
        $pecah = explode(" ", $nama);
        $nick = $pecah[0];
        if(strlen($nick) <= 2){
            $nick = (isset($pecah[1]) && strlen($pecah[1]) > 2 )?$pecah[1]:$pecah[0];
        }else{
            $nick = $pecah[0];
        }
        return $nick;

    }
    
    // cari data area 
    $query_kordinator = mysqli_query($link,"SELECT `cord`, `part`, `id` FROM view_cord_area WHERE cord = '$npkUser' GROUP BY `part`")or die(mysqli_error($link));
    // $query_kordinator = mysqli_query($link,"SELECT `cord`, `part`, `id` FROM view_cord_area WHERE cord = '$npkUser' ")or die(mysqli_error($link));
    $jmlArea = mysqli_num_rows($query_kordinator);

    $array_area_kordinator = array();
    if($jmlArea > 0){
        while($data_area_koodinator = mysqli_fetch_assoc($query_kordinator)){
            $array_area_kordinator[] = $data_area_koodinator['part'];
        }
    }else{
        $array_area_kordinator[] = $npkUser;
        $akses_organisasi = "npk"; //field npk
        $akses_trigger = "npk";//yang sama dengan npknya
    }
    
    // organization access berdasarkan level
    /*digunakan untuk proses yang membutuhkan akses sesuai dengan role user / pekerjaan*/
    if($level != ""){
        if($level == "1"){
            // cek apakah yang karyawan merupakan kordinator?
            $req_access = "disabled";
            $approval = "disabled";
            $admin = "disabled";
            $self = "enabled";

        }else if($level == "2"){
            //spesial user memiliki akses seperti supervisor dan penambahan akses cost
            $req_access = "disabled";
            $approval = "enabled";
            $admin = "disabled";
            $self = "enabled";
            
        }else if($level == "3"){
            //foreman memiliki akses request, dan tidak bisa approval 
            $req_access = "enabled";
            $approval = "disabled";
            $admin = "disabled";
            $self = "enabled";
            
        }else if($level == "4"){
            //foreman memiliki akses request, dan tidak bisa approval 
            $req_access = "disabled";
            $approval = "enabled";
            $admin = "disabled";
            $self = "enabled";
            
        }else if($level == "5"){
            // management tidak memiliki akses apapun selain self monitoring
            $req_access = "disabled";
            $approval = "disabled";
            $admin = "disabled";
            $self = "enabled";
            $akses_organisasi = "grp"; //field department
            $akses_trigger = "grp";//field department
        }else if($level == "6"){
            // admin area perlu cek apakah dia kordinator area apa bukan
            
            $req_access = "disabled";
            $approval = "disabled";
            $admin = "enabled";
            $self = "enabled";
            $akses_organisasi = "division"; //field division
            $akses_trigger = "division";//field division
        }else if($level == "7"){
            // admin divisi perlu cek apakah dia kordinator area apa bukan
            $req_access = "disabled";
            $approval = "disabled";
            $admin = "enabled";
            $self = "enabled";
            $akses_organisasi = "division"; //field division
            $akses_trigger = "division";//field division
        }else{
            //admin sistem memiliki semua akses
            $req_access = "enabled";
            $approval = "enabled";
            $admin = "enabled";
            $self = "enabled";
            $akses_organisasi = "division"; //field division
            $akses_trigger = "division";//field division
        }
    }else{
        $accessOrg = "tidak ada akses";
        $subAccessOrg = "tidak ada akses";
    }
    switch ($level){
        case "1" :
            $org_access = 'npk';
            $sub_org = 'npk';
            
            break ;
        case "2" :
            $org_access = 'post';
            $sub_org = 'sub_post';
            break ;
        case "3" :
            $org_access = 'grp';
            $sub_org = 'post';
            break ;
        case "4" :
            $org_access = 'sect';
            $sub_org = 'grp';
            break ;
        case "5" :
            //mengakses department sesuai kondisi di body
            $org_access = 'dept';
            $sub_org = 'sect';
            break ;
        case "6" :
            //mengakses department account untuk proses adminisrasi 
            $org_access = 'dept_account';
            $sub_org = '';
            break ;
        case "7" :
            $org_access = 'division';
            $sub_org = 'dept_account';
            break ;
        case "8" :
            $org_access = 'division';
            $sub_org = 'dept_account';
            break ;
    }
    $sqlorgUser_ = mysqli_query($link, "SELECT $org_access FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_ = mysqli_fetch_assoc($sqlorgUser_);
    $dataSub_ = mysqli_fetch_assoc($sqlorgUser_);
    $access_ = $dataaccess_[$org_access];
    // $accessSubArea_ = $dataSub_[$sub_org];
}
//function untuk format tanggal
function tgl_bulan($tgl){ 
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $bulan = array (
		1 =>   'jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agu',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecah = explode('-', $tgl);
    return $tanggal." ".$bulan[ (int)$pecah[1]];
}
//function untuk format tanggal
function tgl($tgl){ 
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    $bulan = array (
		1 =>   'jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agu',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecah = explode('-', $tgl);
    return $tanggal." ".$bulan[ (int)$pecah[1]]." ".$tahun;
}
//function untuk format tanggal
function tgl_query($tgl){ 
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    return $bulan."/".$tanggal."/".$tahun;
}
//function untuk format database to datepicker
function tgl_database($tgl){ 
    $pecah_tanggal = explode('-', $tgl);
    $tanggal = $pecah_tanggal[2];
    $bulan = $pecah_tanggal[1];
    $tahun = $pecah_tanggal[0];
    return $tanggal."-".$bulan."-".$tahun;
}
function DBtoForm($tgl){ 
    $pecah_tanggal = explode('-', $tgl);
    $tanggal = $pecah_tanggal[2];
    $bulan = $pecah_tanggal[1];
    $tahun = $pecah_tanggal[0];
    return $tanggal."/".$bulan."/".$tahun;
}
function dateToDB($data){ //dengan format/
    $pecah_tanggal = explode('/', $data);
    
    $date = sprintf("%02d", $pecah_tanggal[0]);
    $month = sprintf("%02d", $pecah_tanggal[1]);
    $year = $pecah_tanggal[2];
    return $year."-".$month."-".$date;
}
function dateToDB2($data){ //dengan format/
    $pecah_tanggal = explode('-', $data);
    $date = $pecah_tanggal[0];
    $month = $pecah_tanggal[1];
    $year = $pecah_tanggal[2];
    return $year."-".$month."-".$date;
}
function getPass($tgl_lahir){ //dengan format/
    $pecah_tanggal = explode('-', $tgl_lahir);
    $date = $pecah_tanggal[2];
    $month = $pecah_tanggal[1];
    $year = $pecah_tanggal[0];
    return $date.$month.$year;
}
function hari_singkat($tanggal){
    
    $day = date('D', strtotime($tanggal));
    $dayList = array(
    'Sun' => 'Min',
    'Mon' => 'Sen',
    'Tue' => 'Sel',
    'Wed' => 'Rab',
    'Thu' => 'Kam',
    'Fri' => 'Jum',
    'Sat' => 'Sab'
    );
    return $dayList[$day];
}
function convertDatetoDB($tglFile){
    $monthList = array(
        'Januari' => '01',
        'Februari' => '02',
        'Maret' => '03',
        'April' => '04',
        'Mei' => '05',
        'Juni' => '06',
        'Juli' => '07',
        'Agustus' => '08',
        'September' => '09',
        'Oktober' => '10',
        'November' => '11',
        'Desember' => '12',
        '' => 'Jum',
    );
    $date = explode(' ', $tglFile);
    return $date['2']."-".$monthList[$date['1']]."-".$date['0'];
}
function hari($tanggal){
    
    $day = date('D', strtotime($tanggal));
    $dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
    );
    return $dayList[$day];
}
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function bln($tanggal){
    
    $bln = date('m', strtotime($tanggal));
    $thn = date('Y', strtotime($tanggal));
    $monthList = array(
    '01' => 'Jan',
    '02' => 'Feb',
    '03' => 'Mar',
    '04' => 'Apr',
    '05' => 'May',
    '06' => 'Jun',
    '07' => 'Jul',
    '08' => 'Ags',
    '09' => 'Sep',
    '10' => 'Oct',
    '11' => 'Nov',
    '12' => 'Des'
    
    );
    return $monthList[$bln];
}
function rupiah($nom){
	
	$hasil_rupiah = "Rp " . number_format($nom,2,',','.');
	return $hasil_rupiah;
 
}
function desimal($nom){
    $hasil = number_format($nom,0);
	return $hasil;
}
 
/*
function tes($a){
    $query = "company.id_company AS idCompany,
    company.nama AS namaCompany ,
    company.npk_cord AS directure,

    division.id_div AS idDiv,
    division.nama_divisi AS divisi,
    division.npk_cord AS dh,
    division.id_company AS id_company,

    dept_account.id_dept_account AS idDeptAcc,
    dept_account.department_account AS deptAcc,
    dept_account.npk_dept AS mg, 
    dept_account.id_div AS id_div,

    department.id_dept AS idDept,
    department.dept AS dept,
    department.npk_cord AS dept_cord,
    department.id_div AS id_div,

    section.id_section AS idSect,
    section.section AS section,
    section.npk_cord AS spv,
    section.id_dept AS id_dept,

    groupfrm.id_group AS idGroup,
    groupfrm.nama_group AS groupfrm,
    groupfrm.npk_cord AS group_cord,
    groupfrm.id_section AS id_sect,

    pos_leader.id_post AS idPost,
    pos_leader.nama_pos AS pos,
    pos_leader.npk_cord AS post_cord,
    pos_leader.id_group AS leader,

    karyawan.npk AS npk,
    karyawan.nama AS nama,
    karyawan.tgl_masuk AS tgl_masuk,
    karyawan.jabatan AS jabatanMp,
    karyawan.shift AS shift,
    karyawan.status AS `status`,
    karyawan.department AS deptMp,
    karyawan.id_area AS id_area,

    jabatan.id_jabatan AS id_jab,
    jabatan.jabatan AS nama_jab ,
    jabatan.level AS level_jab

    ";

    
    if($a == "try"){
    return $query;
    }
}*/

function union($a){
    if($a == "part"){
        $order = "ORDER BY part";
    }else{
        $order = "";
    }
    $union_org = "SELECT id_div AS id , nama_divisi AS nama_org , npk_cord AS cord , id_company AS id_parent , part AS part FROM division $order
        UNION ALL SELECT id_dept_account AS id , department_account AS nama_org , npk_dept AS cord , id_div AS id_parent, part AS part FROM dept_account $order
        UNION ALL SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent, part AS part   FROM department $order
        UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part  FROM section $order
        UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part  FROM groupfrm $order
        UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part  FROM pos_leader $order"; 
    
    return $union_org;

}

function org($id_area){

    $qry_org = "SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent, part AS part   FROM department WHERE id_div = '$id_area'
        UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part  FROM section WHERE id_dept = '$id_area'
        UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part  FROM groupfrm WHERE id_section = '$id_area'
        UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part  FROM pos_leader WHERE id_group = '$id_area'"; 
        
        return $qry_org;
}
function orgAcc($id_area){

    $qry_org = "SELECT id_dept_account AS id , department_account AS nama_org , npk_dept AS cord , id_div AS id_parent, part AS part FROM dept_account WHERE id_div = '$id_area'
        UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part  FROM section WHERE id_dept = '$id_area'
        UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part  FROM groupfrm WHERE id_section = '$id_area'
        UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part  FROM pos_leader WHERE id_group = '$id_area'"; 
        
        return $qry_org;
}
function date_out($date, $in, $out){
    
    $timestampWaktuIn = strtotime($date.' '.$in);
        $timestampWaktuOut = strtotime($date.' '.$out);
        if($timestampWaktuIn > $timestampWaktuOut){
            $date_out = date('Y-m-d' , strtotime('+1 days', strtotime($date)));
        }else{
            $date_out = $date;
        }
        return $date_out;
}
$qry_join = "SELECT 
company.id_company AS idCompany,
company.nama AS namaCompany ,
company.npk_cord AS directure,

division.id_div AS idDiv,
division.nama_divisi AS divisi,
division.npk_cord AS dh,
division.id_company AS id_company,

dept_account.id_dept_account AS idDeptAcc,
dept_account.department_account AS deptAcc,
dept_account.npk_dept AS mg, 
dept_account.id_div AS id_div,

department.id_dept AS idDept,
department.dept AS dept,
department.npk_cord AS dept_cord,
department.id_div AS id_div,

section.id_section AS idSect,
section.section AS section,
section.npk_cord AS spv,
section.id_dept AS id_dept,

groupfrm.id_group AS idGroup,
groupfrm.nama_group AS groupfrm,
groupfrm.npk_cord AS group_cord,
groupfrm.id_section AS id_sect,

pos.id_post AS idsubPost,
pos.nama AS subpos,
pos.npk_cord AS subpost_cord,
pos.id_pos_leader AS id_posleader,

pos_leader.id_post AS idPost,
pos_leader.nama_pos AS pos,
pos_leader.npk_cord AS post_cord,
pos_leader.id_group AS leader,

karyawan.npk AS npk,
karyawan.nama AS nama,
karyawan.tgl_masuk AS tgl_masuk,
karyawan.jabatan AS jabatanMp,
karyawan.shift AS shift,
karyawan.status AS `status`,
karyawan.department AS deptMp,
karyawan.id_area AS id_area,

jabatan.id_jabatan AS id_jab,
jabatan.jabatan AS nama_jab ,
jabatan.level AS level_jab,

org.npk AS npk_org,
org.sub_post AS subpost_org,
org.post AS post_org,
org.grp AS grp_org,
org.sect AS sect_org,
org.dept AS dept_org,
org.dept_account AS dacc_org,
org.division AS division_org,
org.plant AS plant_org,

shift.id_shift AS idShift,
shift.shift AS namaShift,

status_mp.id AS idStats,
status_mp.status_mp AS status_mp,
status_mp.level AS `level`

FROM karyawan 
LEFT JOIN org ON org.npk = karyawan.npk
LEFT JOIN company ON org.plant = company.id_company 
LEFT JOIN division ON org.division = division.id_div
LEFT JOIN dept_account ON org.dept_account = dept_account.id_dept_account 
LEFT JOIN department ON org.dept = department.id_dept
LEFT JOIN section ON org.sect = section.id_section
LEFT JOIN groupfrm ON org.grp = groupfrm.id_group 
LEFT JOIN pos_leader ON org.post = pos_leader.id_post 
LEFT JOIN pos ON org.sub_post = pos.id_post 
LEFT JOIN shift ON karyawan.shift = shift.id_shift
LEFT JOIN status_mp ON karyawan.status = status_mp.id
LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan ";
function data_area($link, $part,$id, $column){
    $q_area = mysqli_query($link, "SELECT id, nama_org, cord, nama_cord, id_parent, part FROM view_cord_area WHERE part = '$part' AND id = '$id' ")or die(mysqli_error($link));
    $sql = mysqli_fetch_assoc($q_area);
    $data = $sql[$column];
    return $data;
}
function cariID_area($pos,$group,$section,$dept,$division,$plant){
    if($pos==""){
        if($group==""){
            if($section==""){
                if($dept == ""){
                    if($division == ""){
                        $id_area = $plant;
                    }else{
                        $id_area = $division;
                    }
                }else{
                    $id_area = $dept;
                }
            }else{
                $id_area = $section;
            }
        }else{
            $id_area = $group;
        }
    }else{
        $id_area = $pos;
    }
    return $id_area;
}
function idIncrement($link, $nama_table,$primary_key){
    $query = mysqli_query($link, "SELECT max($primary_key) AS `id` FROM $nama_table");
    $data = mysqli_fetch_assoc($query);
    $id = $data['id']+1;
    return $id;
}
function hitungHari($tanggalAwal, $tanggalAkhir){
    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);
    
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
    
    return $hari;
}
function jam($jam){
    $jam_baru = date('H:i', strtotime($jam));
    return $jam_baru;
}
function start_date($tgl,$link){
    
}
function end_date($tgl,$link,$shift){
    $shift_karyawan = $shift;
    $q_workingDate = mysqli_query($link,"SELECT 
        working_days.shift AS `shift`, 
        working_hours.start AS `start`,  
        working_hours.end  AS `end`,
        working_hours.end  AS `code_name` FROM working_days 
        LEFT JOIN working_hours ON working_hours.id = working_days.wh 
        WHERE working_days.shift = '$shift_karyawan' AND working_days.date = '$tgl'
    ")or die(mysqli_error($link));
    $sql = mysqli_fetch_assoc($q_workingDate);
    $start_ = $sql['start'];
    $end_ = $sql['end'];

    $strStart = strtotime("$tgl $start_");
    $strEnd= strtotime("$tgl $end_");
    if($strStart > $strEnd){
        $end_date = date('Y-m-d',strtotime('+1day', $tgl));
    }else{
        $end_date = $tgl;
    }
    return $end_date;


}
function MasaKerja($tgl_masuk,$tgl_sekarang){
    if($tgl_masuk=='0000-00-00'){
        return 0;
    }else{
        $date1 = $tgl_masuk;
        $date2 = $tgl_sekarang;
    
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
    
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
    
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
    
        $day1 = date('d', $ts1);
        $day2 = date('d', $ts2);
    
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    
        $tahun=round($diff/12);
        if(!is_integer($diff/12)){
            $tahun=$tahun-1;
        }
        if($tahun < 10){
            $tahun='0'.$tahun;
        }
        $sisabulan=$diff % 12;
    
        if($sisabulan < 10){
            $sisabulan='0'.$sisabulan;
        }
        $data['jumlah_bulan']=$diff;
        
    
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
    
        $diff = $d2->diff($d1);
    
        $data['masa_kerja']=$diff->y.','.$sisabulan;
        return $data;
        }
    }
    function partCode($part, $req){
        switch($part){
            case "division":
                $name = "Division";
                $val = "division";
                $view = "division";
                $tb = "division";
                break;
                case "dept":
                    $name = "Functional Department";
                    $val = "dept";
                    $view = "dept";
                    $tb = "department";
                    break;
                    case "section":
                        $name = "Division";
                        $val = "sect";
                        $view = "section";
                        $tb = "section";
                        break;
                        case "group":
                            $name = "Group Area";
                            $val = "grp";
                            $view = "groupfrm";
                            $tb = "groupfrm";
                            break;
                            case "pos":
                                $name = "Pos Area";
                                $val = "post";
                                $view = "pos";
                                $tb = "pos_leader";
                                break;
                                case "deptAcc":
                                    $name = "Department Administratif / Account";
                                    $val = "dept_account";
                                    $view = "dept_account";
                                    $tb = "dept_account";
                                    break;

        }
        if($req == "nama"){
            return $name;
        }else if($req == "org"){
            return $val;
        }else if($req == "view"){
            return $view;
        }else if($req == "tb"){
            return $tb;
        }
    }
    $db = "localhost";
function dataTableDB($db){
    return $db;
}
?>