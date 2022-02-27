<!--- main content--->
<?php
//set nama halaman


//notifikasi bar akan meload nama halaman


?>
<div class="col-md-12">
    <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Summary</h5>
            <p class="card-category"></p>
        </div>
        <div class="card-body ">
            <canvas id="chartDonut2" class="ct-chart ct-perfect-fourth" width="456" height="100"></canvas>
        </div>
        <div class="card-footer ">

            <div class="stats">
                <i class=""></i> Total Organisasi
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Daftar Man Power</h5>
            <span><button type="button" class="btn btn-sm btn-success btn-outline-secondary ml-2"><i class="fa fa-refresh"></i>  Refresh</button> 
            <span class="pull-right">
                <form class="form-inline" action="" method="post">
                    <div class="form-group">
                        <input type="text" name="pencarian" class="form-control" placeholder="pencarian nama">
                    </div>
                    <div class="form-gorup">
                        <button type="submit" class="btn  btn-outline-secondary btn-primary" aria-hidden="true"><i class="fa fa-search"></i></button>
                    </div>                    
                </form>                 
            </span>
        </div>
        <div class="card-body ">
            <div class="table-responsive" style="height:200">
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
                    //////////////////////////////////////////////////////////////////////
                    //conection sudah diinclude di index, jadi ketika diload di dashboard baru akan muncul
                    //redirect ke halaman dashboard index jika sudah ada session

                    //untuk kondisi awal
                    $batas = 10;
                    $hal = @$_GET['hal']; //0
                    if(empty($hal)){
                        //kondisi awal pasti nilainya -5 jika batas di set 5
                        $posisi = 0;
                        $hal = 1;
                    } else {
                     
                        $posisi = ($hal - 1) * $batas;
                    }

                    //kalo ada inputan post
                    $no = 1;
                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                        //jika ada masukan parameter hasil pencarian kedalam variabel $pencarian
                        $pencarian = trim(mysqli_real_escape_string($link, $_POST['pencarian']));
                        //jika yang diinput tidak kosong atau ada, masukan hasil queri pencarian ke dalam variabel query jumlah
                        if($pencarian !== ''){
                            $sql = "SELECT * FROM karyawan WHERE npk LIKE '%$pencarian%'";
                            $query_mp = $sql;
                            $queryjml = $sql;
                        //jika inputan kosong , masukkan  nilai posisi + 1 ke dalam no    
                        } else{
                            $query_mp = "SELECT * FROM karyawan LIMIT $posisi, $batas";
                            $queryjml = "SELECT * FROM karyawan";
                            $no = $posisi + 1;
                        }
                    //jika tidak ada inputan , masukkan  nilai posisi + 1 ke dalam no     
                    } else {
                        $query_mp = "SELECT * FROM karyawan LIMIT $posisi, $batas";
                        $queryjml = "SELECT * FROM karyawan";
                        $no = $posisi + 1;
                    }


                    $data_mp = mysqli_query($link, $query_mp);
                    //jika Query gagal
                    if(!$data_mp){
                        die("Query gagal dijalankan : ".mysqli_errno($link)."-".mysqli_error($link));
                    }

                    //ambil hasil query mysql
                    $no_urut = 0;
                    if(mysqli_num_rows($data_mp) > 0){
                        while($tampil_mp = mysqli_fetch_assoc($data_mp)){
                            $no_urut++;

                            ?>

                            <?php    
                            echo "<tr><td>$no_urut</td>";
                            echo "<td>$tampil_mp[npk]</td>";
                            echo "<td>$tampil_mp[nama]</td>";
                            echo "<td>$tampil_mp[nama_depan]</td>";
                            echo "<td>$tampil_mp[status]</td>";
                            echo "<td>$tampil_mp[jabatan]</td>";
                            echo "<td>$tampil_mp[tgl_masuk]</td>";
                            echo "<td>$tampil_mp[shift]</td>";
                            echo "<td>$tampil_mp[id_area]</td>";
                            echo "<td>";
                            ?>
                            
                            <a href="edit_mp.php?npk=<?=$tampil_mp['npk']?>" class="btn btn-sm btn-outline-default" ><span class="fa fa-edit"></span></a>
                            <a href="del_mp.php?npk=<?=$tampil_mp['npk']?>" onclick="return confirm('yakin akan menghapus <?=$tampil_mp['nama']?> dengan NPK <?=$tampil_mp['npk']?> dari database?')" class="btn btn-sm btn-outline-danger"><span class="fa fa-trash"></span></a>
                            <button type="button" class="btn btn-sm btn-outline-primary">Absensi</button>
                            <?php
                        echo "</td></tr>";    
                        }
                            

                    } else{
                        
                        echo "<tr><td colspan=\"9\">Data tidak ditemukan</td>";

                        
                    }

                    ?>

                    </tbody>
                </table>
                








            </div>
            <div class="card-footer ">
                <?php
                ////////////////////////////////
                //pagination dan result pencarian
                //jika pencarian ada, maka tampilkan total hasil pencarian dari rows database
                if(empty($_POST['pencarian'])){?>
                    <div style="float:left;">
                            <?php
                            $jml = mysqli_num_rows(mysqli_query($link, $queryjml));
                            echo "Jumlah data :  $jml";
                            ?>
                        </div>
                        <div style="float:right">
                            <ul class="pagination pagination-sm">
                                <?php
                                $jml_hal = ceil($jml / $batas);
                                for ($i=1; $i <= $jml_hal ; $i++) {
                                    if($i != $hal){
                                        echo "<li><a href=\"?hal=$i\">$i</a></li>";
                                    } else {
                                        echo "<li class=\"active\"><a>$i</a></li>";
                                    }                                    
                                }
                                ?>
                            </ul>
                        </div>
                    
                    <?php
                } else { 
                    echo "<div style=\"float:left\">";
                    $jml = mysqli_num_rows(mysqli_query($link, $queryjml));
                    echo "ditemukan <strong>$jml</strong> hasil pencarian ";
                    echo "</div>";
                    
                }
                
                
                ?>


                <div class="stats">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php


mysqli_free_result($data_mp);

// tutup koneksi dengan database mysql
mysqli_close($link);

?>


