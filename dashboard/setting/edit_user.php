<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php");
if(isset($_SESSION['user'])){
    
    $halaman = "Edit User";
    include_once("../header.php");
    
    if(isset($_GET['edit'])){

        $npk = $_GET['edit'];

        $sMp = mysqli_query($link, "SELECT * FROM karyawan WHERE npk = '$npk' ")or die(mysqli_error($link));
        $dMp = mysqli_fetch_assoc($sMp);
        // explod nick name
        $pecah_nick = explode(" " , $dMp['nama']);
        $nick = $pecah_nick[0];

        // echo union();
        $s_org = mysqli_query($link, 
        "SELECT id_div AS id , nama_divisi AS nama_org , npk_cord AS cord , id_company AS id_parent , part AS part FROM division WHERE id_div = '$dMp[id_area]'
        UNION ALL SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent, part AS part FROM department WHERE id_dept = '$dMp[id_area]'
        UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part FROM section WHERE id_section = '$dMp[id_area]'
        UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part FROM groupfrm WHERE id_group = '$dMp[id_area]'
        UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part FROM pos_leader WHERE id_post = '$dMp[id_area]' "
        )or die(mysqli_error($link));
        $d_org = mysqli_fetch_assoc($s_org);

    
        $j_org = mysqli_num_rows($s_org);

        $area =  $d_org['part'];

    
        
        if($area == "section"){
            $s_area = mysqli_query($link ,
            "SELECT company.id_company AS idCompany, company.nama AS namaCompany , company.npk_cord AS directure,
            division.id_div AS idDiv, division.nama_divisi AS divisi, division.npk_cord AS dh, division.id_company AS id_company,
            department.id_dept AS idDept, department.dept AS dept, department.npk_cord AS dept_cord, department.id_div AS id_div,
            section.id_section AS idSect, section.section AS section, section.npk_cord AS spv, section.id_dept AS id_dept
            
            FROM section LEFT JOIN department ON section.id_dept = department.id_dept
            LEFT JOIN division ON department.id_div = division.id_div 
            LEFT JOIN company ON division.id_company = company.id_company
            WHERE section.id_section = '$d_org[id]' ")or die(mysqli_error($link));

            $d_area = mysqli_fetch_assoc($s_area);
            $dept = $d_area['idDept'];
            $sect = $d_area['idSect'];
            $group = "";
            $pos = "";

            
        }else if($area == "dept"){
            $s_area = mysqli_query($link ,
            "SELECT company.id_company AS idCompany, company.nama AS namaCompany , company.npk_cord AS directure,
            division.id_div AS idDiv, division.nama_divisi AS divisi, division.npk_cord AS dh, division.id_company AS id_company,
            department.id_dept AS idDept, department.dept AS dept, department.npk_cord AS dept_cord, department.id_div AS id_div
            
            FROM department LEFT JOIN division ON department.id_div = division.id_div 
            LEFT JOIN company ON division.id_company = company.id_company
            WHERE department.id_dept = '$d_org[id]' ")or die(mysqli_error($link));

            $d_area = mysqli_fetch_assoc($s_area);
            $dept = $d_area['idDept'];
            $sect = "";
            $group = "";
            $pos = "";

        }else if($area == "group"){
            $s_area = mysqli_query($link ,
            "SELECT company.id_company AS idCompany, company.nama AS namaCompany , company.npk_cord AS directure,
            division.id_div AS idDiv, division.nama_divisi AS divisi, division.npk_cord AS dh, division.id_company AS id_company,
            department.id_dept AS idDept, department.dept AS dept, department.npk_cord AS dept_cord, department.id_div AS id_div,
            section.id_section AS idSect, section.section AS section, section.npk_cord AS spv, section.id_dept AS id_dept,
            groupfrm.id_group AS idGroup, groupfrm.nama_group AS groupfrm, groupfrm.npk_cord AS group_cord, groupfrm.id_section AS id_sect
    
            
            FROM groupfrm LEFT JOIN section ON section.id_section = groupfrm.id_section
            LEFT JOIN department ON section.id_dept = department.id_dept
            LEFT JOIN division ON department.id_div = division.id_div 
            LEFT JOIN company ON division.id_company = company.id_company
            WHERE groupfrm.id_group = '$d_org[id]' ")or die(mysqli_error($link));

            $d_area = mysqli_fetch_assoc($s_area);
            $dept = $d_area['idDept'];
            $sect = $d_area['idSect'];
            $group = $d_area['idGroup'];
            $pos = "";


        }else if($area == "pos"){
            $s_area = mysqli_query($link ,
            "SELECT company.id_company AS idCompany, company.nama AS namaCompany , company.npk_cord AS directure,
            division.id_div AS idDiv, division.nama_divisi AS divisi, division.npk_cord AS dh, division.id_company AS id_company,
            department.id_dept AS idDept, department.dept AS dept, department.npk_cord AS dept_cord, department.id_div AS id_div,
            section.id_section AS idSect, section.section AS section, section.npk_cord AS spv, section.id_dept AS id_dept,
            groupfrm.id_group AS idGroup, groupfrm.nama_group AS groupfrm, groupfrm.npk_cord AS group_cord, groupfrm.id_section AS id_sect,
            pos_leader.id_post AS idPost, pos_leader.nama_pos AS pos, pos_leader.npk_cord AS post_cord, pos_leader.id_group AS leader
            
            FROM pos_leader LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
            LEFT JOIN section ON section.id_section = groupfrm.id_section
            LEFT JOIN department ON section.id_dept = department.id_dept
            LEFT JOIN division ON department.id_div = division.id_div 
            LEFT JOIN company ON division.id_company = company.id_company
            WHERE pos_leader.id_post = '$d_org[id]' ")or die(mysqli_error($link));

            $d_area = mysqli_fetch_assoc($s_area);
            $dept = $d_area['idDept'];
            $sect = $d_area['idSect'];
            $group = $d_area['idGroup'];
            $pos = $d_area['idPost'];

        }
        $sDataUser = mysqli_query($link, "SELECT * FROM data_user WHERE npk = '$npk' ")or die(mysqli_error($link));
        $dataUser = mysqli_fetch_assoc($sDataUser);
    
        //cek data user


        $no = 1;
        ?>
        <!--konten isi -->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">

                    <div class="card-header ">
                    <h4 class="card-title pull-left">Edit Data Man Power</h4>
                        <div class=" box pull-right">
                            <a href="user.php?tab=<?=$_GET['tab']?>" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form method="post" action="prosesUser.php" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">NPK</label>
                                <div class="col-sm-10">
                                    
                                    <div class="form-group">
                                        <input type="hidden" name="tab" value="<?=$_GET['tab']?>">
                                        <input type="number" name="npk[]" id="npk<?=$no?>" value="<?=$npk?>" class="form-control npk" 
                                            readonly data-id="<?=$no?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input readonly type="text" value="<?=$dMp['nama']?>" name="nama[]" id="nama<?=$no?>" class="form-control nama" placeholder="Nama Lengkap"
                                            required autofocus pattern="[A-Z a-z]+" data-id="<?=$no?>">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input disabled type="text"  value="<?php if($dMp['nama_depan'] == ''){echo $nick;}else{echo $dMp['nama_depan'];}?>"
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
                                                if($dJabatan['id_jabatan'] == $dMp['jabatan']){
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
                                        <input readonly type="text" name="username[]" id="username<?=$no?>" value="<?=$dataUser['username']?>" class="form-control username" 
                                            data-id="<?=$no?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                
                        
                                <div class="col-sm-5">
                                    <div class="form-check-radio ">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="passactive[]" id="passactive<?=$no?>" value="old" checked="">
                                            Gunakan password lama
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="pass1[]" id="pass2<?=$no?>" value="<?=$dataUser['pass']?>" class="form-control pass1" 
                                            data-id="<?=$no?>">
                                        <span class="form-text text-info">password ini telah dienkripsi dengan richtext / bukan sebenarnya</span>
                                    </div>
                                </div>
                                <div class="col-sm-5 pl-0">
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="passactive[]" id="passactive<?=$no?>" value="new">
                                        Ganti password
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                            name="pass2[]" id="pass2<?=$no?>" class="form-control pass2" data-id="<?=$no?>" placeholder="ganti password disini...">
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
                                                if($dRole['id_role'] == $dataUser['level']){
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
                            
                            <div class="row">
                                <div  class="col-sm-12">
                                    <button class="btn btn-success pull-right" type="submit" name="edit">
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
include_once("../footer.php");
?>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".jabatan").change(function(e){
                    var id = $(this).attr('data-id');
                    var jab = $(this).val();

                    $.ajax({
                    type: 'POST',
                    url: "proses/get_dept.php",
                    data: {id : id , jab :jab},
                    success: function(msg){
                        $("#dept"+id).html(msg);
                        }
                    });
                });
                
                $(".dept").change(function(e){
                    
                    var id = $(this).attr('data-id');
                    var val = $(this).val();
                    var jab = $('#jabatan'+id).val();

                    $.ajax({
                    type: 'POST',
                    url: "proses/get_sect.php",
                    data: {id : id , val : val , jab :jab},
                    success: function(msg){
                        $("#sect"+id).html(msg);
                        }
                    });
                });
            
                $(".sect").change(function(){
                    var id = $(this).attr('data-id');
                    var val = $(this).val();

                    $.ajax({
                    type: 'POST',
                    url: "proses/get_group.php",
                    data: {id : id , val : val},
                    success: function(msg){
                        $("#group"+id).html(msg);
                        }
                    });
                });
                $(".group").change(function(){
                    var id = $(this).attr('data-id');
                    var val = $(this).val();

                    $.ajax({
                    type: 'POST',
                    url: "proses/get_pos.php",
                    data: {id : id , val : val},
                    success: function(msg){
                        $("#pos"+id).html(msg);
                        }
                    });
                });
            });
            </script>
            <script>
            $(document).ready(function(){
                $(".jabatan").change(function(e){
                    var id = $(this).attr('data-id');
                    var val = $(this).val();

                    $.ajax({
                    type: 'POST',
                    url: "proses/get_status2.php",
                    data: {id : id , val : val},
                    success: function(msg){
                        $("#status"+id).html(msg);
                        }
                    });
                });
            });
        </script>
    

    

<?php

    
    include_once("../endbody.php");
    }else{
        // jika tidak ada input edit
        $_SESSION['info']= 'Kosong';
        echo "<script>window.location='user.php';</script>";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>