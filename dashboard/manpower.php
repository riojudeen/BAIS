<?php 


include("connection.php");
include("navigasi.php");
  

$query_mp = "SELECT * FROM karyawan ORDER BY npk ASC LIMIT 11";
$data_mp = mysqli_query($link,$query_mp);

//jika Query gagal
if(!$data_mp){
    die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
}
?>
<h2>Overview</h2>
<div class="card shadow-sm p-3 mb-5 bg-white rounded" style="width: 18rem;">
<div class="card-body">
<h5>PRODUKSI</h5>
</div>
</div>






<table class="table table-striped table-hover">
  <thead>
    <tr>
    <th scope="col">No</th>
    <th scope="col">NPK</th>
    <th scope="col">Nama</th>
    <th scope="col">Nick Name</th>
    <th scope="col">Status</th>
    <th scope="col">Jabatan</th>
    <th scope="col">Tanggal Masuk</th>
    <th scope="col">Shift</th>
    <th scope="col">Pos</th>
    <th scope="col"></th>
      
    </tr>
  </thead>
  <tbody>
    

<?php
$no_urut = 0;
while($tampil = mysqli_fetch_assoc($data_mp)){
    $no_urut++;
    
    echo "<tr><td>$no_urut</td>";
    echo "<td>$tampil[npk]</td>";
    echo "<td>$tampil[nama]</td>";
    echo "<td>$tampil[nama_depan]</td>";
    echo "<td>$tampil[status]</td>";
    echo "<td>$tampil[jabatan]</td>";
    echo "<td>$tampil[tgl_masuk]</td>";
    echo "<td>$tampil[shift]</td>";
    echo "<td>$tampil[id_area]</td>";
    echo "<td>";
    ?>
    
    <button type="button" class="btn btn-outline-secondary">Edit</button>
    <button type="button" class="btn btn-outline-primary">Absensi</button>
    <?php
    echo "</td></tr>";
    



    
}
?>

</tbody>
</table>

<?php
mysqli_free_result($data_mp);

$query_section = "SELECT * FROM section JOIN department USING (id_dept) ORDER BY section ASC";
$section = mysqli_query($link,$query_section);

if(!$section){
  die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
}

?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
    <th scope="col">No</th>
    <th scope="col">ID Section</th>
    <th scope="col">Section</th>
    <th scope="col">Department</th>
    <th scope="col"></th>
      
    
  </thead>
  <tbody>

  <?php
$no = 0;
while($tampil = mysqli_fetch_assoc($section)){
    $no++;
    
    echo "<tr><td>$no</td>";
    echo "<td>$tampil[id_section]</td>";
    echo "<td>$tampil[section]</td>";
    echo "<td>$tampil[dept]</td>";
    


    echo "<td>";
    ?>
    
    <button type="button" class="btn btn-outline-secondary">Edit</button>
    <button type="button" class="btn btn-outline-primary">Absensi</button>
    <?php
    echo "</td></tr>";
    



    
}
?>

</tbody>
  </table>
<?php


include("footer.php");
// bebaskan memory
mysqli_free_result($data_mp);
mysqli_free_result($section);


// tutup koneksi dengan database mysql
mysqli_close($link);
?>
