<?php

if(isset($_SESSION['user'])){
    
    $halaman = "Edit User";
    include_once("../../header.php");
    
    ?>
     <div class="row">
            <div class="col-md-12">
                <div class="card ">

                    <div class="card-header ">
                    <h4 class="card-title pull-left">Edit Authorisasi User</h4>
                        <div class=" box pull-right">
                            <a href="user.php?tab=<?=$_POST['tab']?>" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="card-body ">
                        <?php
                        $no = 1;
                        ?>
                        
                        <form method="post" action="proses/proses.php" class="form-horizontal">
                        <?php
                        
                        foreach($_POST['userchecked'] AS $npk){
                            $q_user = mysqli_query($link,  "SELECT * FROM view_user WHERE npk = '$npk' ")or die(mysqli_error($link));
                            $sql_user = mysqli_fetch_assoc($q_user);
                            $npk = $sql_user['npk'];
                            $nama = $sql_user['nama'];
                            $jabatan = $sql_user['jabatan'];
                            $level_user = $sql_user['level_user'];
                            $username = $sql_user['username'];
                            $pass = $sql_user['pass'];
                            
                        ?>
                        
                            <h5 class="text-uppercase text-info">Data <?=$no?> : <?=$nama?></h5>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">NPK</label>
                                <div class="col-sm-10">
                                    
                                    <div class="form-group">
                                        <input type="hidden" name="tab" value="<?=$_POST['tab']?>">
                                        <input type="number" name="npk[]" id="npk<?=$no?>" value="<?=$npk?>" class="form-control npk" 
                                            readonly data-id="<?=$no?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input readonly type="text" value="<?=$nama?>" name="nama[]" id="nama<?=$no?>" class="form-control nama" placeholder="Nama Lengkap"
                                            required autofocus pattern="[A-Z a-z]+" data-id="<?=$no?>">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input disabled type="text"  value="<?=nick($nama)?>"
                                            name="nick[]" id="nick<?=$no?>" class="form-control nick" pattern="[A-Za-z]+"  data-id="<?=$no?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <select disabled name="jabatan[]" id="jabatan<?=$no?>" class="form-control jabatan" title="Pilih Jabatan" required data-id="<?=$no?>">
                                        <option disabled>Pilih Jabatan</option>
                                            <?php
                                            $optJabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` DESC")or die(Mysqli_error($link));
                                            while($dJabatan = mysqli_fetch_assoc($optJabatan)){
                                                if($dJabatan['id_jabatan'] == $jabatan){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$selected?> title="<?=$dJabatan['id_jabatan']?>" value="<?=$dJabatan['id_jabatan']?>"><?=$dJabatan['jabatan']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    
                                    <div class="form-group">
                                        <input readonly type="text" name="username[]" id="username<?=$no?>" value="<?=$username?>" class="form-control username" 
                                            data-id="<?=$no?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-5">
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                            <input class="form-check-input bg-primary" type="radio" name="passactive<?=$no?>[]" id="passactive<?=$no?>" value="old" checked="">
                                            Gunakan password lama
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"  value="......" readonly class="form-control">
                                        <input type="hidden" name="pass1[]" id="passOld<?=$no?>" value="<?=$pass?>" class="form-control pass1 pass1<?=$no?>" 
                                            data-id="<?=$no?>">
                                        <span class="form-text text-info">password ini telah dienkripsi dengan richtext / bukan sebenarnya</span>
                                    </div>
                                </div>
                                <div class="col-sm-5 pl-0">
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="passactive<?=$no?>[]" id="passNew<?=$no?>" value="new">
                                        Ganti password
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="password"
                                                name="pass2[]" id="pass2<?=$no?>" class="form-control pass2 pass2<?=$no?> passw<?=$no?>" data-id="<?=$no?>" placeholder="ganti password disini...">
                                                <div class="input-group-append">
                                                <div class="input-group-text bg-transparent">
                                                    <i class="fa fa-eye mata2 mata1 mata1<?=$no?> d-none" data-id="<?=$no?>"></i>
                                                    <i class="fa fa-eye-slash mata2 mata2<?=$no?>" data-id="<?=$no?>"></i>
                                                </div>
                                                </div>

                                        </div>
                                            <span class="form-text text-info">isi password baru dan aktifkan pilihan ganti password</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Level User</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <select name="level[]" id="role<?=$no?>" class="form-control role" required data-id="<?=$no?>">
                                        <option disabled>Pilih Role Level</option>
                                            <?php
                                            $optRole = mysqli_query($link, "SELECT * FROM user_role ORDER BY `level` DESC")or die(Mysqli_error($link));
                                            while($dRole = mysqli_fetch_assoc($optRole)){
                                                if($dRole['id_role'] == $level_user){   
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$selected?> value="<?=$dRole['id_role']?>"><?=$dRole['role_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" row">
                                <div class="col-12">
                                    
                                    <div style="box-shadow: inset 1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:1rem; margin-right:-2rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                                    class=" pull-right btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <!-- Monitoring Absensi & Lembur -->
                                        <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                                    </div>
                                    <div style="box-shadow: inset -1px 0 0.2px 0.1px #DFDCDC; background: #F4F3EF; margin-top:1rem; margin-left:-2rem; padding-left: 0.7rem; padding-right: 0.7rem; padding-top: 0.5rem; padding-bottom: 0.5rem;" 
                                    class=" pull-left btn-sm btn-icon btn-round" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <!-- Filter -->
                                        <i style="color: #F4F3EF" class="nc-icon nc-minimal-down "></i>
                                    </div>
                                    <hr style="border: 2px dashed #F4F3EF; margin-top:2rem;">
                                    
                                </div>
                            </div>
                            <?php
                            $no++;
                            }
                            ?>
                            
                            <div class="row">
                                <div  class="col-sm-12">
                                    <button class="btn btn-success pull-right" type="submit" name="edituser_mass">
                                        Save
                                    </button>
                                </div>
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php

    include_once("../../footer.php");
    ?>
    <script>
            $('.mata1').mousedown(function(){
                var index = $(this).attr('data-id')
                $('.mata2'+index).removeClass('d-none')
                $('.mata1'+index).addClass('d-none')
                $('.passw'+index).removeAttr('type')
                $('.passw'+index).attr('type','text')
            })
            $('.mata2').mouseup(function(){
                var index = $(this).attr('data-id')
                $('.mata2'+index).removeClass('d-none')
                $('.mata1'+index).removeClass('d-none')
                $('.mata2'+index).addClass('d-none')
                $('.passw'+index).removeAttr('type')
                $('.passw'+index).attr('type','password')
            })
        </script>
<?php
    include_once("../../endbody.php");
    
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>