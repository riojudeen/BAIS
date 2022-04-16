<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include_once("../header.php");
?>
<!--konten isi -->

<div class="row">
    <div class="col-md-12">
        <div class="card ">

            <div class="card-header ">
                <div class="pull-right">
                    <a href="<?=base_url()?>/dashboard/setting/employee/add_karyawan.php" class="btn btn-default "><i
                            class="nc-icon nc-minimal-left"></i> Kembali</a>
                </div>
                <h4 class="card-title">Tambah Data Man Power</h4>
            </div>
            <hr>
            <div class="card-body ">
                <form method="post" action="proses.php" class="form-horizontal">
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">NPK</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="number" name="npk" id="npk" class="form-control "
                                    placeholder="Input NPK"  required autofocus>
                                    <label for="" class="label-npk label text-danger"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Nick Name</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" name="nick" id="nick" class="form-control"
                                    placeholder="Input Nama Panggilan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" required name="tgl_masuk" id="tgl_masuk" class="form-control datepicker"
                                    placeholder="dd/mm/yyyy" data-date-format="DD/MM/YYYY">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="jabatan" id="jabatan" class="form-control" title="Pilih Jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                <?php
                                    $query_jab = mysqli_query($link, "SELECT * FROM jabatan")or die(mysqli_error($link));
                                    if(mysqli_num_rows($query_jab)>0){
                                        while($jab = mysqli_fetch_assoc($query_jab)){
                                        ?>
                                            <option value="<?=$jab['id_jabatan']?>"><?=$jab['jabatan']?></option>
                                        <?php

                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="status" id="status" class="form-control" title="Pilih Jabatan" required>
                                <option value="">Pilih Status</option>
                                <?php
                                    $query_status = mysqli_query($link, "SELECT * FROM status_mp")or die(mysqli_error($link));
                                    if(mysqli_num_rows($query_status)>0){
                                        while($status_mp = mysqli_fetch_assoc($query_status)){
                                        ?>
                                            <option value="<?=$status_mp['id']?>"><?=$status_mp['status_mp']?></option>
                                        <?php

                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Shift</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="shift" id="shift" class="form-control" title="Pilih Jabatan" required>
                                <option value="">Pilih Shift</option>
                                    <?php
                                        $query_shift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query_shift)>0){
                                            while($shift = mysqli_fetch_assoc($query_shift)){
                                            ?>
                                                <option value="<?=$shift['id_shift']?>"><?=$shift['shift']?></option>
                                            <?php

                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Default Password</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" name="pass" id="pass" readonly class="form-control "
                                    value="ddmmyyyy" >
                                    <label for=""class="label">default password : tanggal masuk (ddmmyyyy)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Role User</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" class="form-control"
                                    value="General User" readonly>
                                <input type="hidden" name="role" class="form-control"
                                    value="gu" readonly>
                                    <label for=""class="label">role user dapat dirubah kapan saja ketika data sudah ditambahkan</label>
                                    
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <button type="submit" name="add" value="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
<?php
include_once("../footer.php");
?>

<script>
//untuk combobox organisasi
    $(document).ready(function() {
        $('#tgl_masuk').on('blur', function(){
            var val = $(this).val();
            var pecah = val.split("/");
            var pass = pecah[2]+pecah[1]+pecah[0];
            $('#pass').val(pass)
        })
        $('#nama').on('blur', function(){
            var val = $(this).val();
            var pecah = val.split(" ");
            var nick = pecah[0];
            $('#nick').val(nick)
            
        })
        $('#npk').on('keyup', function(){
            var npk = $(this).val()
            $.ajax({
                url : "cek_npk.php",
                method : "POST",
                data : {npk : npk },
                success : function(a){
                    if(npk != ''){
                        if(a == '1'){
                            $('#npk').removeClass('border-success text-white bg-success')
                            $('#npk').addClass('border-danger text-white bg-danger')
                            $('.label-npk').text('data sudah ada')
                        }else if(a == '0'){
                            // if($('#npk')[0])
                            $('#npk').removeClass('border-danger text-white bg-danger')
                            $('#npk').addClass('border-success text-white bg-success')
                            $('.label-npk').text('')
                        }
                    }else{
                        $('#npk').removeClass('border-success text-white bg-success')
                        $('#npk').removeClass('border-danger text-white bg-danger')
                    }
                }
            })
        })
    })
</script>


<?php
//footer
    
    include_once("../endbody.php");


} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>