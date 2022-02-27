<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php");
if(isset($_SESSION['user'])){ 
    if(isset($_POST['mpchecked'])){
        $halaman = "Man Power Management Seting";
        include_once("../header.php");
        ///////////////////////////////////////////////////////////////
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">

                    <div class="card-header ">
                    <h4 class="card-title pull-left">Edit Data Man Power</h4>
                        <div class=" box pull-right">
                            <a href="manpower.php" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body ">
                    <hr style="border:1px dashed rgba(176, 174, 174, 0.9)"/>
                    <form method="post" action="proses/proses.php" class="form-horizontal">

        <?php
        ////////////////////////////////////////////////////////////////
        $data = $_POST['mpchecked'];
        $tot = count($_POST['mpchecked']);

        $no = 1;
        foreach($data as $npk){
            
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
        ?>
        
                <h5 class="title">Data <?=$no?></h5>
                <div class="row">
                    <label class="col-sm-2 col-form-label">NPK</label>
                    <div class="col-sm-10">
                        
                        <div class="form-group">
                            <input type="number" id="npk" value="<?=$npk?>" class="form-control" 
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" value="<?=$dMp['nama']?>" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap"
                                required autofocus pattern="[A-Z a-z]+">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" value="<?php if($dMp['nama_depan'] == ''){echo $nick;}else{echo $dMp['nama_depan'];}?>"
                                name="nick" id="nick" class="form-control" pattern="[A-Za-z]+">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="text" name="tgl_masuk" id="tgl_masuk" data-date-format="DD-MM-YYYY" class="form-control datepicker"
                                value="<?= tgl_database($dMp['tgl_masuk'])?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Department Account</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="shift" id="shift" class="form-control" title="Pilih Jabatan" required>
                            <option disabled>Pilih Dept</option>
                            <?php
                            $optDeptAcc = mysqli_query($link, "SELECT * FROM dept_account WHERE id_div = 1 ORDER BY id_dept_account")or die(Mysqli_error($link));
                            while($dDeptAcc = mysqli_fetch_assoc($optDeptAcc)){
                                if($dDeptAcc['id_dept_account'] == $dMp['department']){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option <?=$selected?> value="<?=$dDeptAcc['id_dept_account']?>"><?=$dDeptAcc['department_account']?></option>
                                    <?php
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
                            <option disabled>Pilih Shift</option>
                            <?php
                            $optShift = mysqli_query($link, "SELECT * FROM shift ORDER BY id_shift ASC")or die(Mysqli_error($link));
                            while($dShift = mysqli_fetch_assoc($optShift)){
                                if($dShift['id_shift'] == $dMp['shift']){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option <?=$selected?> value="<?=$dShift['id_shift']?>"><?=$dShift['shift']?></option>
                                <?php
                            }
                            ?>
                                                            
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Jabatan</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="jabatan" id="jabatan" class="form-control" title="Pilih Jabatan" required><option disabled>Pilih Jabatan</option>
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
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="status" id="status" class="form-control" title="Pilih Jabatan" required>
                            <option disabled>Pilih Status</option>
                                <?php
                                
                                $optStatus = mysqli_query($link, "SELECT * FROM status_mp ORDER BY `level` ASC")or die(Mysqli_error($link));
                                while($dStatus = mysqli_fetch_assoc($optStatus)){
                                    if($dStatus['id'] == $dMp['status']){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option <?=$selected?> title="<?=$dStatus['id']?>" value="<?=$dStatus['id']?>"><?=$dStatus['status_mp']?></option>
                                    <?php
                                    
                                }
                                ?>
                                
                                
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-sm-2 col-form-label">Department Functional</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                        <select name="dept" id="dept" class="form-control" title="Pilih Jabatan" required>
                            <option disabled>Pilih Dept Funct.</option>
                                <?php
                                $sDept = mysqli_query($link, "SELECT * FROM department ORDER BY `dept` ASC")or die(Mysqli_error($link));
                                while($dDept = mysqli_fetch_assoc($sDept)){
                                    if($dDept['id_dept'] == $dept ){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option <?=$selected?>  title="<?=$dDept['id_dept']?>" value="<?=$dDept['id_dept']?>"><?=$dDept['dept']?></option>
                                    <?php
                                }
                                ?>
                                <option value="0">-</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Section</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="sect" id="sect" class="form-control" data-size="7"
                                data-style="btn btn-primary" title="Department" required>
                                <option disabled>Pilih Section</option>
                                <?php
                                $sSect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$dept' ORDER BY `section` ASC")or die(Mysqli_error($link));
                                while($dSect = mysqli_fetch_assoc($sSect)){
                                    if($dSect['id_section'] == $sect){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                ?>
                                    <option <?=$selected?> value="<?=$dSect['id_section']?>"><?=$dSect['section']?></option>
                                <?php
                                }
                                ?>
                                <option  value="0">-</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Foreman</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="group" id="group" class="form-control" data-size="7"
                                data-style="btn btn-primary" title="group" required>
                                <option disabled>Pilih Group</option>
                                <?php
                                $sGroup = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$sect' ORDER BY `nama_group` ASC")or die(Mysqli_error($link));
                                while($dGroup = mysqli_fetch_assoc($sGroup)){
                                    if($dGroup['id_group'] == $group){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?=$dGroup['id_group']?>"><?=$dGroup['nama_group']?></option>
                                    <?php
                                }
                                
                                ?>
                                <option value="0">-</option>  

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Leader</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <select name="pos" id="pos" class="form-control" data-size="7"
                                data-style="btn btn-primary" title="group" required>
                                <option disabled>Pilih pos</option>
                                <?php
                                $sPos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$group' ORDER BY `nama_pos` ASC")or die(Mysqli_error($link));
                                while($dPos = mysqli_fetch_assoc($sPos)){
                                    if($dPos['id_post'] == $pos){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?=$dPos['id_post']?>"><?=$dPos['nama_pos']?></option>
                                    <?php
                                }
                                ?>
                                <option  value="0">-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr style="border:1px dashed rgba(176, 174, 174, 0.9)"/>
        <?php
        $no++;
        }
        ?>
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
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='manpower.php'</script>";
    }
    ?>




    

<?php
    include_once("../footer.php");
    ?>
    <!-- javascript -->
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
		
        $(".department").change(function(e){
            
            var id = $(this).attr('data-id');
            var val = $(this).val();
            var jab = $('#jabatan'+id).val();

            $.ajax({
            type: 'POST',
            url: "proses/get_sect.php",
            data: {id : id , val : val , jab :jab},
            success: function(msg){
                $("#section"+id).html(msg);
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
        $(".groupfr").change(function(){
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
            url: "proses/get_status.php",
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
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>