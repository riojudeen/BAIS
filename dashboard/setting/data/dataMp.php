<?php 

// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'bais_db' 
); 
 
// DB table to use 
// $table = 'members'; 
$table = <<<EOT
 (
    SELECT 
      karyawan.nama ,
      karyawan.npk ,
      karyawan.id_area ,
      pos_leader.id_post ,
      pos_leader.nama_pos,
      pos_leader.id_group,
      groupfrm.nama_group,
      section.section
    FROM karyawan 
    LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post 
    LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group
    LEFT JOIN section ON section.id_section = groupfrm.id_section
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'npk'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'npk', 'dt' => 0 ),
    array( 'db' => 'nama', 'dt' => 1 ), 
    array( 'db' => 'id_area',  'dt' => 2 ), 
    array( 'db' => 'nama_pos',      'dt' => 3 ), 
    array( 'db' => 'nama_group',      'dt' => 3 ), 
    array( 'db' => 'section',      'dt' => 3 ), 

    // array( 
    //     'db'        => 'created', 
    //     'dt'        => 6, 
    //     'formatter' => function( $d, $row ) { 
    //         return date( 'jS M Y', strtotime($d)); 
    //     } 
    // ), 
    // array( 
    //     'db'        => 'status', 
    //     'dt'        => 7, 
    //     'formatter' => function( $d, $row ) { 
    //         return ($d == 1)?'<span style="color: blue;">Active</span> '.$d:'Inactive'; 
    //     } 
    // ),
    // array( 'db' => 'nama_kelas',    'dt' => 8 ),
    // array( 'db' => 'harga_kelas',    'dt' => 9 ),
    // array( 'db' => 'nama_mapel',    'dt' => 10 )
    // array( 'db' => 'kesulitan_mapel',    'dt' => 9 )
); 

// Include SQL query processing class 
require 'ssp.php'; 

// require('ssp.class.php');

// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns )
    // SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns)

);