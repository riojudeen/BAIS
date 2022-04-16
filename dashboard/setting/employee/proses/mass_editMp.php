<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
require_once("../../../../config/approval_system.php");
if(isset($_SESSION['user'])){ 
    if(isset($_GET['org'])){
        if(isset($_POST['index'])){
            $halaman = "Organization Settings";
            $id_area = $_GET['id'];
            $part_area = $_GET['part'];
            include_once("../../../header.php");
            ///////////////////////////////////////////////////////////////
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
    
                        <div class="card-header ">
                        <h4 class="card-title pull-left">Edit Structural Org Data</h4>
                            <div class=" box pull-right">
                                <a href="../../organization/data-update.php?org=1&id=<?=$id_area?>&part=<?=$part_area?>" class="btn btn-default "><i
                                    class="nc-icon nc-minimal-left"></i> Kembali</a>
                            </div>
                        </div>
                        <hr />
                        <div class="card-body ">
                        <form method="post" action="proses.php" class="form-horizontal ">
    
            <?php
            ////////////////////////////////////////////////////////////////
            $data = $_POST['index'];
            $tot = count($_POST['index']);
    
            $no = 1;
            foreach($data as $npk){
                
                $sMp = mysqli_query($link, "SELECT view_organization.npk AS npk,
                view_organization.nama AS nama,
                view_organization.tgl_masuk AS tgl_masuk,
                view_organization.jabatan AS jabatan , 
                view_organization.shift AS shift, 
                view_organization.status AS `status`,
                view_organization.id_post_leader AS pos,
                view_organization.id_grp AS `group` , 
                view_organization.id_sect AS section , 
                view_organization.id_dept AS dept,
                view_organization.id_dept_account AS deptAcc,
                view_organization.id_division AS division,
                view_organization.id_plant AS plant,
                view_organization.id_area AS area
                FROM view_organization WHERE npk = '$npk' ")or die(mysqli_error($link));
                $dMp = mysqli_fetch_assoc($sMp);
                // explod nick name
                $pecah_nick = explode(" " , $dMp['nama']);
                $nick = $pecah_nick[0];
    
                $q_org = "SELECT id, nama_org, cord, id_parent, part FROM view_daftar_area";
                list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
                //data organisasi karyawan
                $q_div = $q_org." WHERE part = 'division' AND id_parent = '1' ";
                $q_deptAcc = $q_org." WHERE part = 'deptAcc' AND id_parent = '$div' ";
                $q_dept = $q_org." WHERE part = 'dept' AND id_parent = '$div' ";
                $q_sect = $q_org." WHERE part = 'section' AND id_parent = '$dept'  ";
                $q_group = $q_org." WHERE part = 'group' AND id_parent = '$sect' ";
                $q_pos = $q_org." WHERE part = 'pos' AND id_parent = '$group' ";
      
                // data plant
                $sql_div = mysqli_query($link, $q_div)or die(mysqli_error($link));
                $dataDiv = mysqli_fetch_assoc($sql_div);
                $q_plant = "SELECT * FROM company WHERE id_company = '$dataDiv[id_parent]'";
                $s_plant = mysqli_query($link, $q_plant)or die(mysqli_error($link));
                $dataPlant = mysqli_fetch_assoc($s_plant);
            ?>
            
                    
                    <div class="row">
                        <div class="col-md-2 text-right"></div>
                        <div class="col-md-10">
                            <h5 class="category mb-0">[Data <?=$no?>]</h5>
                            <h5 class="text-uppercase mb-0">Account & Profile Data</h5>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">NPK</label>
                        <div class="col-sm-10">
                            
                            <div class="form-group">
                                <input type="number" id="npk<?=$no?>" data-id="<?=$no?>" name="npk[]" value="<?=$npk?>" class="npk form-control text-uppercase" 
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input readonly type="text" value="<?=$dMp['nama']?>" data-id="<?=$no?>" name="nama[]" id="nama<?=$no?>" class="nama form-control text-uppercase" placeholder="Nama Lengkap"
                                    required autofocus pattern="[A-Z a-z]+">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group no-border bg-transparent">
                                <input readonly type="text" readonly value="<?=$nick?>"
                                    name="nick[]" id="nick<?=$no?>" data-id="<?=$no?>" class="nick form-control bg-transparent text-uppercase" pattern="[A-Za-z]+">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input readonly type="text" name="tgl_masuk[]" data-id="<?=$no?>" id="tgl_masuk<?=$no?>" data-date-format="DD-MM-YYYY" class="tgl_masuk form-control text-uppercase datepicker"
                                    value="<?= tgl_database($dMp['tgl_masuk'])?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Group Shift</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select disabled name="shift[]" id="shift<?=$no?>" data-id="<?=$no?>" class="shift form-control text-uppercase" title="Pilih Shift" required>
                                <option >Pilih Shift</option>
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
                                <?php
                                $optShift = mysqli_query($link, "SELECT * FROM shift WHERE id_shift = '$dMp[shift]' ")or die(Mysqli_error($link));
                                $dShift = mysqli_fetch_assoc($optShift)

                                ?>
                                <input type="hidden"  name="shift[]" value="<?=$dShift['id_shift']?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select disabled name="jabatan[]" id="jabatan<?=$no?>" data-id="<?=$no?>" class="jabatan form-control text-uppercase" title="Pilih Jabatan" required>
                                    <option value="-">Pilih Jabatan</option>
                                    <?php
                                    $optJabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` DESC")or die(Mysqli_error($link));
                                    if(mysqli_num_rows($optJabatan)>0){
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

                                    }else{
                                        ?>
                                        <option value="-">Tida Ada Data</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php
                                $optJabatan = mysqli_query($link, "SELECT * FROM jabatan WHERE id_jabatan = '$dMp[jabatan]' ")or die(Mysqli_error($link));
                                $dJabatan = mysqli_fetch_assoc($optJabatan)

                                ?>
                                <input type="hidden" name="jabatan[]" name="status[]" value="<?=$dJabatan['id_jabatan']?>">
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select disabled name="status[]" id="status<?=$no?>" data-id="<?=$no?>" class="status form-control text-uppercase" title="Pilih Jabatan" required>
                                <option >Pilih Status</option>
                                
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
                                <?php
                                $optStatus = mysqli_query($link, "SELECT * FROM status_mp WHERE id = '$dMp[status]' ")or die(Mysqli_error($link));
                                $dStatus = mysqli_fetch_assoc($optStatus);

                                ?>
                                <input type="hidden"  name="status[]" value="<?=$dStatus['id']?>">
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-2 text-right"></div>
                        <div class="col-md-10 ">
                            <h5 class="text-uppercase mb-0">Organization Data</h5>
                        </div>
                    </div>
                    
                    <div class="row">
                    <label class="col-sm-2 col-form-label">Plant :</label>
                        <div class="col-sm-10 bg-transparent ml-0">
                            <div class="form-group no-border">
                                <input type="text" readonly class="form-control bg-transparent text-uppercase" value="<?=$dataPlant['nama']?>">
                                <input name="plant[]" type="hidden" id="plant<?=$no?>" data-id="<?=$no?>" readonly class="plant form-control bg-transparent text-uppercase" value="<?=$dataPlant['id_company']?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Division :</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="division[]" id="division<?=$no?>" data-id="<?=$no?>" class="division form-control text-uppercase" title="Pilih Jabatan" required>
                                <option value="-">-</option>
                                <?php
                                $s_div = mysqli_query($link, $q_div)or die(mysqli_error($link));
                                while($dDiv = mysqli_fetch_assoc($s_div)){
                                    if($dDiv['id'] == $dMp['division']){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option <?=$selected?> value="<?=$dDiv['id']?>"><?=$dDiv['nama_org']?></option>
                                        <?php
                                }
                                ?>                   
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Department Account</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="deptAcc[]" id="deptAcc<?=$no?>" data-id="<?=$no?>" class="deptAcc form-control text-uppercase" title="Pilih Dept Account" required>
                                <option value="-">-</option>
                                <?php
                                $s_deptAcc = mysqli_query($link, $q_deptAcc)or die(mysqli_error($link));            
                                while($dataDeptAcc = mysqli_fetch_assoc($s_deptAcc)){
                                    if($dataDeptAcc['id'] == $dMp['deptAcc']){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                    <option <?=$selected?>  value="<?=$dataDeptAcc['id']?>"><?=$dataDeptAcc['nama_org']?></option>
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
                            <select name="dept[]" id="dept<?=$no?>"  data-id="<?=$no?>" class="dept form-control text-uppercase" title="pilih dept" required>
                                <option value="-">-</option>
                                    <?php
                                    $s_dept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
                                    while($dataDept = mysqli_fetch_assoc($s_dept)){
                                        if($dataDept['id'] == $dMp['dept'] ){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        ?>
                                        <option <?=$selected?>  title="<?=$dataDept['id']?>" value="<?=$dataDept['id']?>"><?=$dataDept['nama_org']?></option>
                                        <?php
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Section</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="sect[]" id="section<?=$no?>" data-id="<?=$no?>" class="section form-control text-uppercase" data-size="7"
                                    data-style="btn btn-primary" title="Department" required>
                                    <option value="-">-</option>
                                    <?php
                                    $s_sect = mysqli_query($link, $q_sect)or die(mysqli_error($link));
                                    while($dataSect = mysqli_fetch_assoc($s_sect)){
                                        if($dataSect['id'] == $dMp['section']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                    ?>
                                        <option <?=$selected?> value="<?=$dataSect['id']?>"><?=$dataSect['nama_org']?></option>
                                    <?php
                                    }
                                    ?>
    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Group Foreman</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="group[]" id="group<?=$no?>" data-id="<?=$no?>" class="group form-control text-uppercase" data-size="7"
                                    data-style="btn btn-primary" title="group" required>
                                    <option value="-">-</option>
                                    <?php
                                    $s_group = mysqli_query($link, $q_group)or die(mysqli_error($link));
                                    while($dataGroup = mysqli_fetch_assoc($s_group)){
                                        if($dataGroup['id'] == $dMp['group']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        ?>
                                        <option <?=$selected?> value="<?=$dataGroup['id']?>"><?=$dataGroup['nama_org']?></option>
                                        <?php
                                    }
                                    
                                    ?>
                                    
    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Pos Leader</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="pos[]" id="pos<?=$no?>" data-id="<?=$no?>" class="pos form-control text-uppercase" data-size="7"
                                    data-style="btn btn-primary" title="group" required>
                                    <option value="-">-</option>
                                    <?php
                                    $s_pos = mysqli_query($link, $q_pos)or die(mysqli_error($link));
                                    while($dataPos = mysqli_fetch_assoc($s_pos)){
                                        if($dataPos['id'] == $dMp['pos']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        ?>
                                        <option <?=$selected?> value="<?=$dataPos['id']?>"><?=$dataPos['nama_org']?></option>
                                        <?php
                                    }
                                    ?>
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
                                        <input type="hidden" name="redirect" value="../../organization/data-update.php?id=<?=$id_area?>&part=<?=$part_area?>">
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
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }
    }else{
        // untuk edit organisasi 

        if(isset($_POST['index'])){
            $halaman = "Man Power Management Seting";
            include_once("../../../header.php");
            ///////////////////////////////////////////////////////////////
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
    
                        <div class="card-header ">
                        <h4 class="card-title pull-left">Edit Structural Org Data</h4>
                            <div class=" box pull-right">
                                <a href="<?=base_url()?>dashboard/setting/employee/add_karyawan.php" class="btn btn-default "><i
                                    class="nc-icon nc-minimal-left"></i> Kembali</a>
                            </div>
                        </div>
                        <hr />
                        <div class="card-body ">
                        <form method="post" action="proses.php" class="form-horizontal ">
    
                        <?php
                        ////////////////////////////////////////////////////////////////
                        $data = $_POST['index'];
                        $tot = count($_POST['index']);
                
                        $no = 1;
                        foreach($data as $npk){
                            
                            $sMp = mysqli_query($link, "SELECT view_organization.npk AS npk,
                            view_organization.nama AS nama,
                            view_organization.tgl_masuk AS tgl_masuk,
                            view_organization.jabatan AS jabatan , 
                            view_organization.shift AS shift, 
                            view_organization.status AS `status`,
                            view_organization.id_post_leader AS pos,
                            view_organization.id_grp AS `group` , 
                            view_organization.id_sect AS section , 
                            view_organization.id_dept AS dept,
                            view_organization.id_dept_account AS deptAcc,
                            view_organization.id_division AS division,
                            view_organization.id_plant AS plant,
                            view_organization.id_area AS area
                            FROM view_organization WHERE npk = '$npk' ")or die(mysqli_error($link));
                            $dMp = mysqli_fetch_assoc($sMp);
                            // explod nick name
                            $pecah_nick = explode(" " , $dMp['nama']);
                            $nick = $pecah_nick[0];
                
                            $q_org = "SELECT id, nama_org, cord, id_parent, part FROM view_daftar_area";
                            list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
                            //data organisasi karyawan
                            $q_div = $q_org." WHERE part = 'division' AND id_parent = '1' ";
                            $q_deptAcc = $q_org." WHERE part = 'deptAcc' AND id_parent = '$div' ";
                            $q_dept = $q_org." WHERE part = 'dept' AND id_parent = '$div' ";
                            $q_sect = $q_org." WHERE part = 'section' AND id_parent = '$dept'  ";
                            $q_group = $q_org." WHERE part = 'group' AND id_parent = '$sect' ";
                            $q_pos = $q_org." WHERE part = 'pos' AND id_parent = '$group' ";
                
                            // data plant
                            $sql_div = mysqli_query($link, $q_div)or die(mysqli_error($link));
                            $dataDiv = mysqli_fetch_assoc($sql_div);
                            $q_plant = "SELECT * FROM company WHERE id_company = '$dataDiv[id_parent]'";
                            $s_plant = mysqli_query($link, $q_plant)or die(mysqli_error($link));
                            $dataPlant = mysqli_fetch_assoc($s_plant);
                        ?>
            
                    
                                <div class="row">
                                    <div class="col-md-2 text-right"></div>
                                    <div class="col-md-10">
                                        <h5 class="category mb-0">[Data <?=$no?>]</h5>
                                        <h5 class="text-uppercase mb-0">Account & Profile Data</h5>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">NPK</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="form-group">
                                            <input type="number" id="npk<?=$no?>" data-id="<?=$no?>" name="npk[]" value="<?=$npk?>" class="npk form-control text-uppercase" 
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" value="<?=$dMp['nama']?>" data-id="<?=$no?>" name="nama[]" id="nama<?=$no?>" class="nama form-control text-uppercase" placeholder="Nama Lengkap"
                                                required autofocus pattern="[A-Z a-z]+">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <div class="form-group no-border bg-transparent">
                                            <input type="text" readonly value="<?=$nick?>"
                                                name="nick[]" id="nick<?=$no?>" data-id="<?=$no?>" class="nick form-control bg-transparent text-uppercase" pattern="[A-Za-z]+">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input type="text" name="tgl_masuk[]" data-id="<?=$no?>" id="tgl_masuk<?=$no?>" data-date-format="DD-MM-YYYY" class="tgl_masuk form-control text-uppercase datepicker"
                                                value="<?= tgl_database($dMp['tgl_masuk'])?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Group Shift</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select name="shift[]" id="shift<?=$no?>" data-id="<?=$no?>" class="shift form-control text-uppercase" title="Pilih Shift" required>
                                            <option >Pilih Shift</option>
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
                                            <select name="jabatan[]" id="jabatan<?=$no?>" data-id="<?=$no?>" class="jabatan form-control text-uppercase" title="Pilih Jabatan" required>
                                                <option value="-">Pilih Jabatan</option>
                                                <?php
                                                $optJabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` DESC")or die(Mysqli_error($link));
                                                if(mysqli_num_rows($optJabatan)>0){
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

                                                }else{
                                                    ?>
                                                    <option value="-">Tida Ada Data</option>
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
                                            <select name="status[]" id="status<?=$no?>" data-id="<?=$no?>" class="status form-control text-uppercase" title="Pilih Jabatan" required>
                                            <option >Pilih Status</option>
                                            
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
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-md-2 text-right"></div>
                                    <div class="col-md-10 ">
                                        <h5 class="text-uppercase mb-0">Organization Data</h5>
                                    </div>
                                </div>
                                
                                <div class="row">
                                <label class="col-sm-2 col-form-label">Plant :</label>
                                    <div class="col-sm-10 bg-transparent ml-0">
                                        <div class="form-group no-border">
                                            <input type="text" readonly class="form-control bg-transparent text-uppercase" value="<?=$dataPlant['nama']?>">
                                            <input name="plant[]" type="hidden" id="plant<?=$no?>" data-id="<?=$no?>" readonly class="plant form-control bg-transparent text-uppercase" value="<?=$dataPlant['id_company']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label ">Division :</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select disabled name="division[]" id="division<?=$no?>" data-id="<?=$no?>" class="division form-control text-uppercase" title="Pilih Jabatan" required>
                                            <option value="-">-</option>
                                            <?php
                                            $s_div = mysqli_query($link, $q_div)or die(mysqli_error($link));
                                            while($dDiv = mysqli_fetch_assoc($s_div)){
                                                if($dDiv['id'] == $dMp['division']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$selected?> value="<?=$dDiv['id']?>"><?=$dDiv['nama_org']?></option>
                                                    <?php
                                            }
                                            ?>                   
                                            </select>
                                            <?php
                                            $s_div = mysqli_query($link, $q_div." AND id = '$dMp[division]' ")or die(mysqli_error($link));
                                            $dDiv = mysqli_fetch_assoc($s_div);
                                            ?>
                                            <input type="hidden" name="division[]" value="<?=$dDiv['id']?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Department Account</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select  disabled name="deptAcc[]" id="deptAcc<?=$no?>" data-id="<?=$no?>" class="deptAcc form-control text-uppercase" title="Pilih Dept Account" required>
                                            <option value="-">-</option>
                                            <?php
                                            $s_deptAcc = mysqli_query($link, $q_deptAcc)or die(mysqli_error($link));            
                                            while($dataDeptAcc = mysqli_fetch_assoc($s_deptAcc)){
                                                if($dataDeptAcc['id'] == $dMp['deptAcc']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$selected?>  value="<?=$dataDeptAcc['id']?>"><?=$dataDeptAcc['nama_org']?></option>
                                                    <?php
                                            }
                                            ?>               
                                            </select>
                                            <?php
                                            $s_deptAcc = mysqli_query($link, $q_deptAcc." AND id = '$dMp[deptAcc]' ")or die(mysqli_error($link));
                                            $dataDeptAcc = mysqli_fetch_assoc($s_deptAcc);
                                            ?>
                                            <input type="hidden" name="deptAcc[]" value="<?=$dataDeptAcc['id']?>" >
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Department Functional</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                        <select disabled name="dept[]" id="dept<?=$no?>"  data-id="<?=$no?>" class="dept form-control text-uppercase" title="pilih dept" required>
                                            <option value="-">-</option>
                                                <?php
                                                $s_dept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
                                                while($dataDept = mysqli_fetch_assoc($s_dept)){
                                                    if($dataDept['id'] == $dMp['dept'] ){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option <?=$selected?>  title="<?=$dataDept['id']?>" value="<?=$dataDept['id']?>"><?=$dataDept['nama_org']?></option>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </select>
                                            <?php
                                            $s_dept = mysqli_query($link, $q_dept." AND id = '$dMp[dept]' ")or die(mysqli_error($link));
                                            $dataDept = mysqli_fetch_assoc($s_dept);
                                            ?>
                                            <input type="hidden" name="dept[]" value="<?=$dataDept['id']?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Section</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select disabled name="sect[]" id="section<?=$no?>" data-id="<?=$no?>" class="section form-control text-uppercase" data-size="7"
                                                data-style="btn btn-primary" title="Department" required>
                                                <option value="-">-</option>
                                                <?php
                                                $s_sect = mysqli_query($link, $q_sect)or die(mysqli_error($link));
                                                while($dataSect = mysqli_fetch_assoc($s_sect)){
                                                    if($dataSect['id'] == $dMp['section']){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                ?>
                                                    <option <?=$selected?> value="<?=$dataSect['id']?>"><?=$dataSect['nama_org']?></option>
                                                <?php
                                                }
                                                ?>
                
                                            </select>
                                            <?php
                                            $s_sect = mysqli_query($link, $q_sect." AND id = '$dMp[section]' ")or die(mysqli_error($link));
                                            $dataSect = mysqli_fetch_assoc($s_sect)
                                            ?>
                                            <input type="hidden" name="sect[]" value="<?=$dataSect['id']?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Group Foreman</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select disabled name="group[]" id="group<?=$no?>" data-id="<?=$no?>" class="group form-control text-uppercase" data-size="7"
                                                data-style="btn btn-primary" title="group" required>
                                                <option value="-">-</option>
                                                <?php
                                                $s_group = mysqli_query($link, $q_group)or die(mysqli_error($link));
                                                while($dataGroup = mysqli_fetch_assoc($s_group)){
                                                    if($dataGroup['id'] == $dMp['group']){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option <?=$selected?> value="<?=$dataGroup['id']?>"><?=$dataGroup['nama_org']?></option>
                                                    <?php
                                                }
                                                
                                                ?>
                                                
                
                                            </select>
                                            <?php
                                            $s_group = mysqli_query($link, $q_group." AND id = '$dMp[group]' ")or die(mysqli_error($link));
                                            $dataGroup = mysqli_fetch_assoc($s_group)
                                            ?>
                                            <input type="hidden" name="group[]" value="<?=$dataGroup['id']?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Pos Leader</label>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <select disabled name="pos[]" id="pos<?=$no?>" data-id="<?=$no?>" class="pos form-control text-uppercase" data-size="7"
                                                data-style="btn btn-primary" title="group" required>
                                                <option value="-">-</option>
                                                <?php
                                                $s_pos = mysqli_query($link, $q_pos)or die(mysqli_error($link));
                                                while($dataPos = mysqli_fetch_assoc($s_pos)){
                                                    if($dataPos['id'] == $dMp['pos']){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option <?=$selected?> value="<?=$dataPos['id']?>"><?=$dataPos['nama_org']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php
                                            $s_pos = mysqli_query($link, $q_pos." AND id = '$dMp[pos]' ")or die(mysqli_error($link));
                                            $dataPos = mysqli_fetch_assoc($s_pos);
                                            ?>
                                            <input type="hidden" name="pos[]" value="<?=$dataPos['id']?>" >
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
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }
        include_once("../../../endbody.php"); 
    }

}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>   
<?php
include_once("../../../footer.php");
?>
<!-- javascript -->
<script type="text/javascript">
$(document).ready(function(){
    function get_division(index){
        var index = index;
        var value = $('#division'+index).val();
        var parent = $('#plant'+index).val();
        $.ajax({
            type:"GET",
            url: "get_div.php",
            data :{value:value},
            success: function(data){
                $('#division'+index).html(data);
            }
        })    
    }
    function get_deptAcc(index){
        if($('#division'+index)[0]){
            var parent = $('#division'+index).val();
            var index = index
            var value = $('#deptAcc'+index).val();
            $.ajax({
                type:"GET",
                url: "get_deptAcc.php",
                data :{value:value, parent:parent},
                success: function(data){
                    $('#deptAcc'+index).html(data);
                    // get_dept(index)
                    
                }
            })
        }
        
    }
    function get_dept(index){
        if($('#division'+index)[0]){
            var parent = $('#division'+index).val();
            var index = index
            var value = $('#deptAcc'+index).val();
            $.ajax({
                type:"GET",
                url: "get_dept.php",
                data :{value:value, parent:parent},
                success: function(data){
                    $('#dept'+index).html(data);
                    get_sect(index)
                    // get_group(index)
                    // get_pos(index)
                }
            })
        }
    }
    function get_sect(index){
        if($('#dept'+index)[0]){
            var index = index;
            var parent = $('#dept'+index).val();
            var value = $('#section'+index).val();
            $.ajax({
                type: 'GET',
                url: "get_sect.php",
                data :{value:value, parent:parent},
                success: function(msg){
                    $("#section"+index).html(msg);
                    get_group(index)
                    // get_pos(index)
                }
            });
        }
    }
    function get_group(index){
        if($('#section'+index)[0]){
            var index = index;
            var parent = $('#section'+index).val();
            var value = $('#group'+index).val();
            $.ajax({
                type: 'GET',
                url: "get_group.php",
                data :{value:value, parent:parent},
                success: function(msg){
                    $("#group"+index).html(msg);
                    get_pos(index)
                }
            });
        }
        
    }
    function get_pos(index){
        if($('#group'+index)[0]){
            var index = index;
            var parent = $('#group'+index).val();
            var value = $('#pos'+index).val();
            $.ajax({
            type: 'GET',
            url: "get_pos.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#pos"+index).html(msg);
                }
            });
        }
        
    }
    $('.division').on('change',function(){
        var index = $(this).attr('data-id');
        get_deptAcc(index)
        get_dept(index)
        
       
    })
    $(".dept").on('change',function(e){
        var index = $(this).attr('data-id');
        get_sect(index)
        // get_group(index)
        // get_pos(index)
    });
    $(".section").on('change',function(e){
        var index = $(this).attr('data-id');
        get_group(index)
        // get_pos(index)
    });
    $(".group").on('change',function(e){
        var index = $(this).attr('data-id');
        get_pos(index)
    });
});
</script>
<script>
$(document).ready(function(){
    function get_status(index){

        var id = index;
        var val = $('#jabatan'+id).val();

        $.ajax({
            type: 'GET',
            url: "get_status.php",
            data: {id : id , val : val},
            success: function(msg){
                $("#status"+id).html(msg);
            }
        });
    }
    $(".jabatan").on('change', function(){
        var index = $(this).attr('data-id');
        get_status(index)
    });
    
});
</script>