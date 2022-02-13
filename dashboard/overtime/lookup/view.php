<?php
//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
 
require_once("../../../config/function_status_approve.php");
require_once("../../../config/function_access_query.php");
require_once("../../../config/function_filter.php");
//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
    $no_surat = $_POST['id'];

    $qOt = "SELECT * FROM lembur WHERE kode_lembur = '$no_surat'";

    $s_ot = mysqli_query($link, $qOt)or die(mysqli_error($link));
    $j_ = mysqli_num_rows($s_ot);
    $qTanggal = $qOt." GROUP BY in_date ";
    $sTanggal = mysqli_query($link, $qTanggal);
    
    while($dTanggal = mysqli_fetch_assoc($sTanggal)){
        $dataTanggal['0'] = $dTanggal['in_date'];
    }
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-left text-secondary" id="exampleModalLongTitle">No Surat : <?=$no_surat?></h5>
    </div>
    <div class="modal-body px-3">
        <!-- isi -->
        <div class="table-responsive">
            <table class="table" rules="cols" style="border: 1px solid black">
                
                <thead class="text-center">
                    <tr>
                        <th style="border: 1px solid black; width: 120px"><img style="width: 100px" src="../../assets/img/logo_daihatsu.png"></th>
                        <th style="border: 1px solid black; font-size: 25px" colspan="7">Surat Perintah Lembur</th>
                        <th style="border: 1px solid black; font-size: 25px; width: 120px"><?=date('Y')?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-1" colspan="9" style="border: 1px solid black; height:2px"></td>
                    </tr>
                    <colgroup>
                        <col style="width: 20px">
                        <col style="width: 25px">
                        <col style="width: 150px">
                    </colgroup>
                    <tr>
                        <td class="py-0" colspan="2" style="height:50px">Line / POS</td>
                        <td class="py-0" style="height:50px">: <?=$areaUser?></td>
                        <td class="p-0 text-muted" rowspan="4" colspan="5">
                        <div class="table-responsive text-nowrap">
                            <table class="table p-0 m-0">
                                <tbody>
                                <?php
                                    // kode lembur
                                    $baris = 5;
                                    $q_jobcode = "SELECT * FROM kode_lembur";
                                    $s_jobcode = mysqli_query($link, $q_jobcode)or die(mysqli_error($link));
                                    $jml_row = mysqli_num_rows($s_jobcode);
                                    
                                    $sisa_kolom = $jml_row % $baris; //sisa baris
                                    if($sisa_kolom > 0){
                                        $hasil_kolom = (($jml_row - $sisa_kolom)/$baris)+1;
                                    }else{
                                        $hasil_kolom = ( $jml_row / $baris);
                                    }
                                    
                                    echo "<tr>";
                                    
                                    for($i=0; $i<$hasil_kolom; $i++){
                                        echo "<td class=\"p-0 m-0\"><table class=\"table table-striped\">"
                                        ?>
                                        <colgroup>
                                            <col style="width: 50px">
                                            <col style="width: 200px">
                                        
                                        </colgroup>

                                        <?php
                                        echo "<thead class=\"p-0 mt-0\">";
                                        echo "<th class=\"py-1 px-1\">Kode</th>";
                                        echo "<th class=\"py-1 px-1\">Activity</th>";
                                        echo "<tbody class=\"p-0 mt-0\">";
                                        
                                        $offset = $i * $baris;
                                        $q_code = "SELECT * FROM kode_lembur LIMIT $offset , $baris";
                                        $s_code = mysqli_query($link, $q_code)or die(mysqli_error($link));

                                        for($hasilbaris=0; $hasilbaris<=$baris; $hasilbaris++){
                                            while($d_jobcode = mysqli_fetch_assoc($s_code)){
                                                echo "<tr>";
                                                echo "<td class=\"py-1 px-1\">".$d_jobcode['kode_lembur']."</td>";
                                                echo "<td class=\"py-1 px-1\">".$d_jobcode['nama']."</td>";
                                                echo "</tr>";
                                                
                                            }
                                        }
                                        if($sisa_kolom > 0 && $hasil_kolom == $i +1){
                                            $tambah = $baris - $sisa_kolom;
                                            for($tbh=0 ; $tbh<$tambah ; $tbh++){
                                                echo "<tr>";
                                                echo "<td class=\"py-1 px-1\"> -</td>";
                                                echo "<td class=\"py-1 px-1\"> -</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "</tbody></table></td>";
                                    }
                                    echo "</tr>";
                                ?>
                                </tbody>
                            </table>
                        </div>
                        </td>
                        <th class="py-0 text-center text-white bg-secondary " rowspan="2">Total MP</th>
                    </tr>
                    <tr>
                        <td class="py-0" style="height:50px" colspan="2">Shift</td>
                        <td class="py-0" style="height:50px" >: A, B , N</td>
                        
                    </tr>
                    <tr>
                        <td class="py-0" style="height:50px" colspan="2">Department</td>
                        <td class="py-0" style="height:50px" >: </td>
                        <td class="py-0 my-0 text-center h1" rowspan="2" style="height:50px" ><?=$j_?></td>
                        
                    </tr>
                    <tr>
                        <td class="py-0" colspan="2" style="height:50px" >Hari / Tanggal </td>
                        <td class="py-0" style="height:50px" >: <?=hari_singkat($dataTanggal['0'])?>, <?=DBtoForm($dataTanggal['0'])?></td>
                        
                    </tr>
                    <!-- isi table form -->
                    <!-- <tr>
                        <td class="py-1" colspan="9" style="border: 1px solid black; height:2px"></td>
                    </tr> -->
                    
                </tbody>
            
            </table>
        </div>
        <div class="table-responsive" style="height:200">
        <table class="table table-striped table-hover text-uppercase">
            <thead>
                <tr>
                    <th scope="col">NO</th> 
                    <th scope="col">Nama</th> 
                    <th scope="col">NPK</th>
                    <th scope="col">Shf</th>
                    <th scope="col">Date In</th>
                    <th scope="col">Date Out</th>
                    <th scope="col">Mulai</th>
                    <th scope="col">Selesai</th>
                    <th scope="col">Status</th>
                    <th>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="allmp">
                        <span class="form-check-sign"></span>
                        </label>
                    </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                $no = 1;
                    while($d_ot = mysqli_fetch_assoc($s_ot)){
                        $s_nama = mysqli_query($link, "SELECT nama, shift FROM karyawan WHERE npk = '$d_ot[npk]' ")or die(mysqli_error($link));
                        $d_nama = mysqli_fetch_assoc($s_nama);

                        $s_requester = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$d_ot[requester]' ")or die(mysqli_error($link));
                        $d_requester = mysqli_fetch_assoc($s_requester);
                        
                        $dataStatus = $d_ot['status_approve'].$d_ot['status'];
                        switch($dataStatus){     
                            case '0a' :
                                $info = "draft";
                                $disp = "d-none";
                                $color = "text-danger";
                                break;

                            //pengajuan pending belum diapproval
                            case '25a' :
                                $info = "approval pending";
                                $disp = "d-none";
                                $color = "text-warning";
                                break;

                            //sistem proses di spv
                            case '50a' :
                                $info = "pengajuan disetujui";
                                $disp = "d-none";
                                $color = "text-primary";
                                break;
                            //perlu dikonfirmasi
                            case '50b' :
                                $info = "pengajuan ditolak";
                                $disp = "d-none";
                                $color = "text-primary";
                                break;
                            case '50c' :
                                $info = "dikembalikan supervisor";
                                $disp = "d-none";
                                $color = "text-primary";
                                break;

                            //pengajuan diproses admin
                            case '75a' :
                                $info = "diproses admin";
                                $disp = "d-none";
                                $color = "text-info";
                                break;
                            //sistem proses di admin
                            case '75c' :
                                $info = "dikembalikan admin";
                                $disp = "d-none";
                                $color = "text-info";
                                break;
                            //sistem proses di admin
                            case '75b' :
                                $info = "cuti habis";
                                $disp = "d-none";
                                $color = "text-info";
                                break;

                            //pengjuan sukses dan sudah berubah di personal site
                            case '100a' :
                                $info = "sukses";
                                $disp = "d-none";
                                $color = "text-success";
                                break;
                            case '100b' :
                                $info = "problem absensi";
                                $disp = "d-none";
                                $color = "text-success";
                                break;
                            case '100c' :
                                $info = "diarsipkan";
                                $disp = "d-none";
                                $color = "text-success";
                                break;
                        }
                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td>$d_nama[nama]</td>";
                        echo "<td>$d_ot[npk]</td>";
                        echo "<td>$d_nama[shift]</td>";
                        echo "<td>".DBtoForm($d_ot['in_date'])."</td>";
                        echo "<td>".DBtoForm($d_ot['out_date'])."</td>";
                        echo "<td>$d_ot[in_lembur]</td>";
                        echo "<td>$d_ot[out_lembur]</td>";
                        echo "<td>$info</td>";
                        
                        if($dataStatus == '0a' || $dataStatus == '50c' || $dataStatus == '75c'){
                            $btn = '';
                            $class = 'mp';
                        }else{
                            $btn = 'disabled';
                            $class = '';
                        }
                        ?>
                        
                        <td>
                            <div class="form-check <?=$btn?>">
                                <label class="form-check-label">
                                    <input  class="form-check-input <?=$class?>" name="mpchecked[]" type="checkbox" value="<?=$d_ot['_id']?>">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                ?>
                    
                
                </tr>
            </tbody>
        </table>
        <!-- isi -->
        
    </div>
    <div class="modal-footer px-0 mx-0">
    <div class="col-12 px-0 mx-0">
        <a href="req_lembur.php" type="button" class="btn btn-warning pull-left" >
            <i class="nc-icon nc-ruler-pencil"></i> Edit
        </a>
    
        <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success pull-right" name="req" >Submit Request</button>
        <button type="submit" class="btn btn-danger pull-right" name="delete">Delete</button>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });
            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                }
            })
        })
    </script> 
<?php
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>