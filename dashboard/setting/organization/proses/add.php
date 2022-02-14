<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_POST['part'])){
        $halaman = "Add Organization";
        $total = $_POST['count'];
        include_once("../../../header.php");

        // echo $_POST['part'];
        switch($_POST['part']){
            case "division":
                $namaOrg = "Division";
                $id = "division";
                $q_area = "SELECT company.id_company AS id_area,
                company.nama AS nama_area ,
                company.npk_cord AS cordinator,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `company`
                LEFT JOIN karyawan ON karyawan.npk = company.npk_cord ORDER BY company.id_company ASC";

                break;
            case "deptAcc":
                $namaOrg = "Department Account";
                $id = "deptAcc";
                $q_area = "SELECT division.id_div AS id_area, 
                division.nama_divisi AS nama_area, 
                division.npk_cord AS cordinator, 
                division.id_company AS id_parent,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `division`
                LEFT JOIN karyawan ON karyawan.npk = division.npk_cord ORDER BY division.id_div ASC";
                break;
            case "dept":
                $namaOrg = "Department Functional";
                $id = "dept";
                $q_area = "SELECT division.id_div AS id_area, 
                division.nama_divisi AS nama_area, 
                division.npk_cord AS cordinator, 
                division.id_company AS id_parent,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `division`
                LEFT JOIN karyawan ON karyawan.npk = division.npk_cord ORDER BY division.id_div ASC";
                break;
            case "section":
                $namaOrg = "Section";
                $id = "section";
                $q_area = "SELECT department.id_dept AS id_area, 
                department.dept AS nama_area, 
                department.npk_cord AS cordinator, 
                department.id_div AS id_parent,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `department`
                LEFT JOIN karyawan ON karyawan.npk = department.npk_cord ORDER BY department.id_dept ASC";

                break;
            case "group":
                $namaOrg = "Group / Line";
                $id = "group";
                $q_area = "SELECT section.id_section AS id_area, 
                section.section AS nama_area, 
                section.npk_cord AS cordinator, 
                section.id_dept AS id_parent,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `section`
                LEFT JOIN karyawan ON karyawan.npk = section.npk_cord";

                break;
            case "pos":
                $namaOrg = "Pos Leader";
                $id = "pos";

                $q_area = "SELECT groupfrm.id_group AS id_area, 
                groupfrm.nama_group AS nama_area, 
                groupfrm.npk_cord AS cordinator, 
                groupfrm.id_section AS id_parent,
                karyawan.npk AS npk_kary,
                karyawan.nama AS nama_kary
                
                FROM `groupfrm`
                LEFT JOIN karyawan ON karyawan.npk = groupfrm.npk_cord ORDER BY groupfrm.id_group ASC";

                break;
        }
        ?>
        <form method="post" action="proses.php">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title pull-left">Register <?=$namaOrg?></h4>
                        <div class=" box pull-right">
                            <a href="../index.php" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped ">
                            <thead>
                                <tr class="">
                                    <th>#</th>
                                    
                                    <th>Nama Org</th>
                                    <th colspan="2">Coord Area</th>
                                    
                                    <th>Parent Organization</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($i=1; $i<= $total ; $i++){
                                ?>
                               <tr class="p-0">
                                    <td ><?=$i?></td>
                                    
                                    <td class="col-md-3">
                                        <div class="form-group  py-0 my-0">
                                            <input type="hidden" name="kode_<?=$id?>[]">
                                            <input placeholder="input nama area" type="text" name="nama_<?=$id?>[]" class="form-control namaorg" id="namaorg<?=$i?>" minLength="2" maxLength="40" autocomplete="off" required/>
                                        </div>
                                    </td>
                                    <td class="col-md-1">
                                        <div class="form-group py-0 my-0">
                                            <input placeholder="npk" name="cord_<?=$id?>[]" class="form-control npk" id="npk<?=$i?>" data-id="<?=$i?>" minLength="2" maxLength="6"  autocomplete="off" required/>
                                        </div>
                                    </td>
                                    <td class="col-md-3">
                                        <div class="form-group py-0 my-0">
                                            <input type="text" name="namaCord[]" class="form-control bnama" id="nama<?=$i?>" readonly />
                                        </div>
                                    </td>
                                    <td class="col-md-4">
                                        <span class="form-group py-0 my-0">
                                            <select name="parent<?=$id?>[]" data-id="<?=$i?>" data-size="5" data-live-search="true" data-width="400px" class=" selectpicker parent" data-style="btn btn-outline-primary" required>
                                            <?php
                                            $s_area = mysqli_query($link, $q_area)or die(mysqli_error($link));
                                            while($d_area = mysqli_fetch_assoc($s_area)){
                                                if(isset($_POST['id_parent'])){
                                                    $select = ($_POST['id_parent'] == $d_area['id_area'])?'selected':'';
                                                }else{
                                                    $select = "";
                                                }
                                                ?>
                                                <option <?=$select ?> data-subtext="<?=$d_area['nama_kary']?>" value="<?=$d_area['id_area']?>"><?=$d_area['nama_area']?></option>
                                                <?php
                                            }
                                            
                                            ?>
                                                
                                        </select>
                                    </span>
                                        
                                            
                                    </td>
                                    <td class="col-md-1">
                                    <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-warning" type="reset" name="add">
                            RESET
                        </button>
                        <button class="btn btn-success tambah" type="submit" name="add">
                            ADD
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php

        include_once("../../../footer.php");
        //javascript
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.npk').keyup(function() {
                    var id = $(this).attr('data-id');
                    var npk = $(this).val();

                    if('#npk'+id == '') {
                        $('#nama'+id).val('');
                    }
                    else {
                        $.ajax({
                            url: 'validasi.php',
                            type: 'POST',
                            data: {npk : npk},
                            // success: function(hasil) {
                            //     if(hasil > 0) {
                            //         $('#nama'+id).val();
                            //         $('#nama'+id).attr('disabled','true');
                            //         $('#submit').attr('disabled','true');
                            //     }
                            //     else {
                            //         $('#nama'+id).val('NPK belum ada di database');
                            //         $('#nama'+id).removeAttr('disabled');
                            //         $('#submit').removeAttr('disabled');
                            //     }
                            // }
                            
                        })
                        .done(function(hasilajax){
                            var jsondata = hasilajax,
                            obj = JSON.parse(jsondata);
                            if(obj.jumlah > 0){
                                $('#nama'+id).val(obj.nama);
                            }else{
                                $('#nama'+id).val('NPK TIDAK TERSEDIA');
                            }
                        })
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.kode').keyup(function() {
                    var id = $(this).attr('data-id');
                    var kode = $(this).val();
                    var data = $(this).attr('data');

                    if('#kode'+id == '') {
                        $('#namaorg'+id).val('');
                    }else{
                        $.ajax({
                            url: 'validasikode.php',
                            type: 'POST',
                            data: {kode : kode , data : data},
                        })
                        .done(function(hasil){
                            var jsondata = hasil,
                            obj = JSON.parse(jsondata);
                            if(obj.jumlah > 0){
                                $('#namaorg'+id).val('KODE AREA SUDAH DIGUNAKAN');
                                $('.tambah').attr('disabled','true');
                            }else{
                                $('#namaorg'+id).val('');
                                $('.tambah').removeAttr('disabled','true');
                            }
                        })
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                $('.npk').keypress(function hanyaAngka(event) {
                    var angka = (event.which)?
                    event.which : event.keyCode
                    if(angka != 46 && angka > 31 && (angka < 48 || angka > 57))
                    return false;
                    return true;
                })
            })
        </script>
        <!-- get kode parent -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('.parent').change(function() {
                    var id = $(this).attr('data-id');
                    var parent = $(this).val();
                    $("#areacode-"+id).text(parent);
                    
                });
            });
        </script>
        <?php
        include_once("../../../endbody.php"); 

    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>window.location='".base_url('../../organization')."';</script>";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }

?>