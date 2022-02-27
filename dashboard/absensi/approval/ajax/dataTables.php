<th>#</th>
<th>NPK</th>
<th>Nama</th>
<th>Shift</th>
<th>Area</th>
<th>Dept</th>

<th>Tanggal</th>
<th>in</th>
<th>out</th>
<th>Ket</th>
<th>Progress</th>
<th>Status</th>
<th class="text-right">Action</th>
<th scope="col" class="sticky-col first-last-col first-last-top-col text-right">
    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" id="allmp">
        <span class="form-check-sign"></span>
        </label>
    </div>
</th>

<?php
// Database connection info 
$dbDetails = array( 
    'user' => 'root',
    'pass' => '',
    'db'   => 'bais_db',
    'host' => 'localhost'
); 
 
// DB table to use 
$table = 'view_absen_req';
 
// Table's primary key 
$primaryKey = 'id_absensi';
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array(  'db' => 'id_absensi', 'dt' => 0 ),
    array(  'db' => 'nama', 'dt' => 1 ),
    array(  'db' => 'npk',  'dt' => 2 ),
    array(  'db' => 'id_absensi',
            'dt' => 3,

            // kalo kalian mau bikin tombol edit pake 'formatter' => function($d, $row) {return ....}
            // kalian bisa custom dengan menggunakan class bootstrap untuk mempercantik tampilan
            'formatter' => function($d, $row) {
                return '<a href="edit?id='.$d.'">EDIT</a>';
            }
         ),
    array( 
        'db'        => 'created', 
        'dt'        => 5, 
        'formatter' => function( $d, $row ) { 
            return date( 'jS M Y', strtotime($d)); 
        } 
    ), 
    array( 
        'db'        => 'status', 
        'dt'        => 6, 
        'formatter' => function( $d, $row ) { 
            return ($d == 1)?'Active':'Inactive'; 
        } 
    ) 
); 
 
$searchFilter = array(); 
if(!empty($_GET['search_keywords'])){ 
    $searchFilter['search'] = array( 
        'first_name' => $_GET['search_keywords'], 
        'last_name' => $_GET['search_keywords'], 
        'email' => $_GET['search_keywords'], 
        'country' => $_GET['search_keywords'] 
    ); 
} 
if(!empty($_GET['filter_option'])){ 
    $searchFilter['filter'] = array( 
        'gender' => $_GET['filter_option'] 
    ); 
} 
 
// Include SQL query processing class 
require 'ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns, $searchFilter ) 
); 
// DB table to use
// $table = 'view_absen_req';
 
// // Table's primary key
// $primaryKey = 'id_absensi';
 

// // Array kolom basisdata akan dikirim kembali ke DataTables.
// // The `db` parameter represents the column name in the database, while the `dt`
// // 'db' mewakili parameter kolom database
// // 'dt' adalah parameter yang akan ditampilkan di database pada index.php

// $columns = array(
//     array(  'db' => 'id_absensi', 'dt' => 0 ),
//     array(  'db' => 'nama', 'dt' => 1 ),
//     array(  'db' => 'npk',  'dt' => 2 ),
//     array(  'db' => 'id_absensi',
//             'dt' => 3,

//             // kalo kalian mau bikin tombol edit pake 'formatter' => function($d, $row) {return ....}
//             // kalian bisa custom dengan menggunakan class bootstrap untuk mempercantik tampilan
//             'formatter' => function($d, $row) {
//                 return '<a href="edit?id='.$d.'">EDIT</a>';
//             }
//          ),
// );
 
// //melakukan koneksi ke database
// $sql_details = array(
//     'user' => 'root',
//     'pass' => '',
//     'db'   => 'bais_db',
//     'host' => 'localhost'
// );

// //code di bawah tidak perlu diedit

// require( 'ssp.class.php' );
 
// echo json_encode(
//     SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
// );