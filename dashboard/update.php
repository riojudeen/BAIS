<?php 


include("connection.php");
include("navigasi.php");
  

?>
<h2>Update Man Power<span class="badge badge-secondary">55</span></h2>
<div class="card">
    <h5 class="card-header">Upload Data</h5>
    <div class="card-body">
    </div>
</div>
<div class="card my-2">
    <h5 class="card-header">Check Data</h5>
    <div class="card-body">

        <?php  

$query_mp = "SELECT * FROM karyawan ORDER BY npk ASC";
$data_mp = mysqli_query($link,$query_mp);

//jika Query gagal
if(!$data_mp){
    die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
}
?>
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
                <input class="btn btn-primary" type="button" value="<?php echo "$tampil[npk]"; ?>">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#warning_hapus">Hapus</button>
                <div class="modal fade" id="warning_hapus" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Anda yakin?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Hapus <?php echo "$tampil[nama]";?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                <button type="button" class="btn btn-primary">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
    echo "</td></tr>";
}
?>

            </tbody>
        </table>


    </div>
</div>



<?php

include("footer.php");

?>