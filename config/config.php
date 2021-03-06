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
    if($_SERVER['HTTP_HOST'] !== '10.59.12.51' ){
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
    }else{
        $base_url = "/CAIS/BAIS";
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
    if($part == 'plant'){
        $q_area = mysqli_query($link, "SELECT id_company AS id, nama AS nama_org, npk_cord AS cord  FROM company WHERE id_company = '$id' ")or die(mysqli_error($link));
        if($column == 'id_company'){
            $data = "";
        }else if($column == 'id_parent'){
            $data = "";
        }else if($column == 'part'){
            $data = "";
        }else if($column == 'nama_cord'){
            $data = "";
        }else{
            $sql = mysqli_fetch_assoc($q_area);
            $data = $sql[$column];
        }
        
        return $data;
    }else{
        $q_area = mysqli_query($link, "SELECT id, nama_org, cord, nama_cord, id_parent, part FROM view_cord_area WHERE part = '$part' AND id = '$id' ")or die(mysqli_error($link));
        $sql = mysqli_fetch_assoc($q_area);
        $data = $sql[$column];
        return $data;
    }
}
function cariID_area($pos,$group,$section,$dept,$division,$plant){
    if($pos==""){
        if($group==""){
            if($section==""){
                if($dept == ""){
                    if($division == ""){
                        $id_area = $plant;
                    }else{
                        $id_area = "division&&".$division;
                    }
                }else{
                    $id_area = "dept&&".$dept;
                }
            }else{
                $id_area = "section&&".$section;
            }
        }else{
            $id_area = "group&&".$group;
        }
    }else{
        $id_area = "pos&&".$pos;
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
function initial($nama){
    $arr = explode(' ', $nama);
    $singkatan = '';
    foreach($arr as $kata)
    {
        $singkatan .= substr($kata, 0, 1);
    }
    return $singkatan;
}
function cutName($nama){
    $singkatan = substr($nama, 0, 7);
    return $singkatan."...";
}
function getFoto($npk){
    $link = $GLOBALS['link'];
    $query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'FOTO' ")or die(mysqli_error($link));
            $sql_dir = mysqli_fetch_assoc($query_dir);
            $root_path = $sql_dir['root'];
    $path = "//adm-fs/HRD/HRD-Photo/".$npk.".jpg";
    $newPath = "$root_path".$npk.".jpg";
    if(file_exists($newPath)){
        
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($newPath);
        $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
        $base64 = ($image)? $image : "";
    }else{
        $type = pathinfo($path, PATHINFO_EXTENSION);
        if (file_exists($path)) {
            
            // compress image
            $source = $path;
            $imgInfo = getimagesize($source); 
            $mime = $imgInfo['mime'];  
            // $fileName = $npk.".jpg";
            $destination = $newPath;
            $quality = 50;
            // membuat image baru
            switch($mime){ 
            // proses kode memilih tipe tipe image 
                case 'image/jpeg': 
                    $image = imagecreatefromjpeg($source); 
                    break; 
                case 'image/png': 
                    $image = imagecreatefrompng($source); 
                    break; 
                case 'image/gif': 
                    $image = imagecreatefromgif($source); 
                    break; 
                default: 
                    $image = imagecreatefromjpeg($source); 
            } 
            
            imagejpeg($image, $newPath, $quality); 
            // $base64 = $newPath;

            $dataImage = file_get_contents($newPath);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
            $base64 = ($image)? $image : "";
        } else {
            $base64 = base_url()."/assets/img/img/tm.png";
            // $file = fopen($path, "r");
            // echo "File berhasil dibaca.";
        }

    }
    return $base64;
}
// table view yang sering error 
"SELECT division.id_div AS id , division.nama_divisi AS nama_org , division.npk_cord AS cord , division.id_company AS id_parent , division.part AS part FROM division
UNION ALL SELECT department.id_dept AS id , department.dept AS nama_org , department.npk_cord AS cord , department.id_div AS id_parent, department.part AS part   FROM department
    UNION ALL SELECT dept_account.id_dept_account AS id , dept_account.department_account AS nama_org , dept_account.npk_dept AS cord , dept_account.id_div AS id_parent, dept_account.part AS part FROM dept_account 
    UNION ALL SELECT section.id_section AS id , section.section AS nama_org , section.npk_cord AS cord , section.id_dept AS id_parent, section.part AS part  FROM section 
    UNION ALL SELECT groupfrm.id_group AS id , groupfrm.nama_group AS nama_org , groupfrm.npk_cord AS cord , groupfrm.id_section AS id_parent, groupfrm.part AS part  FROM groupfrm 
    UNION ALL SELECT pos_leader.id_post AS id , pos_leader.nama_pos AS nama_org , pos_leader.npk_cord AS cord , pos_leader.id_group AS id_parent, pos_leader.part AS part  FROM pos_leader";
function cekSubPost($link, $npk){
    $query = "SELECT sub_post FROM org WHERE npk = '$npk' ";
    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($sql);
    $id_sub_post = $data['sub_post'];
    return $id_sub_post;
}
function cekIdArea($link, $npk){
    $query = "SELECT id_area FROM karyawan WHERE npk = '$npk' ";
    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($sql);
    $id_area = $data['id_area'];
    return $id_area;
}
function cariAtasan($link, $npk, $id_area){
    
    if($id_area != ''){
        $pecah = explode('&&', $id_area);
        $part = $pecah[0];
        $id = $pecah[1];
        $q_atasan = mysqli_query($link, "SELECT cord, nama_cord FROM view_cord_area WHERE id = '$id' AND part = '$part' ");
        $s_atasan = mysqli_fetch_assoc($q_atasan);
        $npkAtasan = $s_atasan['cord'];
        $namaAtasan = $s_atasan['nama_cord'];
        if($npkAtasan == $npk){
            $q_kary = mysqli_query($link, "SELECT post , grp, sect, dept_account, dept, division FROM org WHERE npk = '$npk'")or die(mysqli_error($link));
            $data_kary = mysqli_fetch_assoc($q_kary);
            $grp = $data_kary['grp'];
            $sect = $data_kary['sect'];
            $dept = $data_kary['dept'];
            $division = $data_kary['division'];
            $array_cord = array();
            $array_part = array();
            if($part != 'division'){

                if($part == 'pos'){
                    $add = " AND (id = '$grp' OR id = '$sect' OR id = '$dept' OR id = '$division')";
                }else if($part == 'group'){
                    $add = " AND (id = '$sect' OR id = '$dept' OR id = '$division')";
                }else if($part == 'section'){
                    $add = " AND (id = '$dept' OR id = '$division')";
                }else if($part == 'dept'){
                    $add = " AND (id = '$division')";
                }
                $query = mysqli_query($link, "SELECT cord , nama_cord, part
                    FROM view_cord_area 
                    WHERE part <> '$part' AND part <> 'deptAcc' AND cord <> '$npk' ".$add." ORDER BY id DESC");
                if(mysqli_num_rows($query)>0){
                    while($data = mysqli_fetch_assoc($query)){
                        $npkAtasan = $data['cord'];
                        $partAtasan = $data['nama_cord'];
                        array_push($array_cord, $npkAtasan);
                        array_push($array_part, $partAtasan);
                    }
                }
                $npkAtasan = $array_cord[0];
                $namaAtasan = $array_part[0];
            }else{
                $npkAtasan = "";
                $namaAtasan = "";
            }
        }else{
            $npkAtasan = $s_atasan['cord'];
            $namaAtasan = $s_atasan['nama_cord'];
        }
    }else{
        $npkAtasan = "";
        $namaAtasan = "";
    }
    return array($npkAtasan, $namaAtasan);
    // $query = "SELECT id_area FROM karyawan WHERE npk = '$npk' ";
    // $sql = mysqli_query($link, $query)or die(mysqli_error($link));
    // $data = mysqli_fetch_assoc($sql);
    // $id_area = $data['id_area'];
    // return $id_area;
}
if($_SERVER['HTTP_HOST'] === '10.59.12.51' ){
    error_reporting(0);
}
// view_karyawan_record
"SELECT
`working_days`.`date` AS `date`,
`bais_db`.`karyawan_record`.`mp` AS `mp`,
`bais_db`.`karyawan_record`.`id_area` AS `id_area`,
`bais_db`.`karyawan_record`.`part` AS `part`,
`bais_db`.`karyawan_record`.`id_jabatan` AS `id_jabatan`,
`bais_db`.`karyawan_record`.`nama_area` AS `nama_area`,
`bais_db`.`karyawan_record`.`id_dept_account` AS `id_dept_account`
FROM
(
    (
    SELECT
        `bais_db`.`working_days`.`date` AS `date`
    FROM
        `bais_db`.`working_days`
    GROUP BY
        `bais_db`.`working_days`.`date`
) `working_days`
LEFT JOIN `bais_db`.`karyawan_record` ON
(
    `bais_db`.`karyawan_record`.`date` = `working_days`.`date`
)
)";
//view_organization_mp
"SELECT
COUNT(`view_organization`.`npk`) AS `jml_mp`,
`view_organization`.`shift` AS `shift`,
`view_organization`.`id_sub_pos` AS `id_sub_pos`,
`view_organization`.`id_post_leader` AS `id_post_leader`,
`view_organization`.`id_grp` AS `id_grp`,
`view_organization`.`id_sect` AS `id_sect`,
`view_organization`.`id_dept` AS `id_dept`,
`view_organization`.`id_dept_account` AS `id_dept_account`,
`view_organization`.`id_division` AS `id_division`,
`view_organization`.`id_plant` AS `id_plant`
FROM
`bais_db`.`view_organization`
GROUP BY
`view_organization`.`shift`,
`view_organization`.`id_sub_pos`,
`view_organization`.`id_post_leader`,
`view_organization`.`id_grp`,
`view_organization`.`id_sect`,
`view_organization`.`id_dept`,
`view_organization`.`id_dept_account`,
`view_organization`.`id_division`,
`view_organization`.`id_plant`";
//view_prod_overtime
"SELECT
`bais_db`.`working_days`.`date` AS `date`,
SUM(`view_req_ot_bulk`.`jml_ot`) AS `jm_ot`,
COUNT(`view_req_ot_bulk`.`mp_ot`) AS `jm_mp`,
`bais_db`.`working_days`.`id` AS `id`,
`bais_db`.`working_days`.`wh` AS `wh`,
`bais_db`.`working_days`.`shift` AS `shift`,
`bais_db`.`working_days`.`ket` AS `ket`,
`bais_db`.`working_days`.`break_id` AS `break_id`,
`view_req_ot_bulk`.`sub_post` AS `sub_post`,
`view_req_ot_bulk`.`post` AS `post`,
`view_req_ot_bulk`.`grp` AS `grp`,
`view_req_ot_bulk`.`sect` AS `sect`,
`view_req_ot_bulk`.`dept` AS `dept`,
`view_req_ot_bulk`.`dept_account` AS `dept_account`,
`view_req_ot_bulk`.`division` AS `division`,
`view_req_ot_bulk`.`plant` AS `plant`
FROM
(
    `bais_db`.`working_days`
LEFT JOIN(
    SELECT
        `view_req_ot_bulk`.`npk` AS `npk`,
        SUM(`view_req_ot_bulk`.`over_time`) AS `jml_ot`,
        COUNT(`view_req_ot_bulk`.`npk`) AS `mp_ot`,
        `view_req_ot_bulk`.`work_date` AS `work_date`,
        `view_req_ot_bulk`.`sub_post` AS `sub_post`,
        `view_req_ot_bulk`.`post` AS `post`,
        `view_req_ot_bulk`.`grp` AS `grp`,
        `view_req_ot_bulk`.`sect` AS `sect`,
        `view_req_ot_bulk`.`dept` AS `dept`,
        `view_req_ot_bulk`.`dept_account` AS `dept_account`,
        `view_req_ot_bulk`.`division` AS `division`,
        `view_req_ot_bulk`.`plant` AS `plant`
    FROM
        `bais_db`.`view_req_ot_bulk`
    GROUP BY
        `view_req_ot_bulk`.`npk`,
        `view_req_ot_bulk`.`work_date`,
        `view_req_ot_bulk`.`sub_post`,
        `view_req_ot_bulk`.`post`,
        `view_req_ot_bulk`.`grp`,
        `view_req_ot_bulk`.`sect`,
        `view_req_ot_bulk`.`dept`,
        `view_req_ot_bulk`.`dept_account`,
        `view_req_ot_bulk`.`division`,
        `view_req_ot_bulk`.`plant`
) `view_req_ot_bulk`
ON
(
    `view_req_ot_bulk`.`work_date` = `bais_db`.`working_days`.`date`
)
)
GROUP BY
`bais_db`.`working_days`.`date`,
`view_req_ot_bulk`.`sub_post`,
`view_req_ot_bulk`.`post`,
`view_req_ot_bulk`.`grp`,
`view_req_ot_bulk`.`sect`,
`view_req_ot_bulk`.`dept`,
`view_req_ot_bulk`.`dept_account`,
`view_req_ot_bulk`.`division`,
`view_req_ot_bulk`.`plant`";
?>