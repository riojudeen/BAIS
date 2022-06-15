<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
if(isset($_SESSION['user'])){
    
    $halaman = "Transfer Data Karyawan";
    include_once("../header.php");
    
    if(isset($_GET['transfer'])){
        $npk = $_GET['transfer'];
        // echo $level;
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
        // echo $dMp['division'];
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

        // explod nick name
        $pecah_nick = explode(" " , $dMp['nama']);
        $nick = $pecah_nick[0];

        $no = 1;

        switch($level){
            case "8":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "7":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "6":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "5":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            
            case "4":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept = "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "3":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "2":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "disabled";
                $dis_group = "disabled";
                $dis_pos = "disabled";
                break;
            case "1":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "disabled";
                $dis_group = "disabled";
                $dis_pos = "disabled";
                break;
        }
        ?>
        <!--konten isi -->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                    <h4 class="card-title pull-left">Transfer Data Man Power</h4>
                        <div class=" box pull-right">
                            <a href="<?=base_url()?>/dashboard/pages/mp_update.php" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form method="POST" action="proses/proses.php">
                            
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
                                        <input type="hidden" name="t_div" value="<?=$dMp['division']?>" >
                                        <select name="division[]" <?=$dis_division?> id="division<?=$no?>" data-id="<?=$no?>" class="division form-control text-uppercase" title="Pilih Jabatan" required>
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
                                            <option <?=$selected?> <?=$dis_division?> value="<?=$dDiv['id']?>"><?=$dDiv['nama_org']?></option>
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
                                        <input type="hidden" name="t_deptAcc" value="<?=$dMp['deptAcc']?>" >
                                        <select name="deptAcc[]" id="deptAcc<?=$no?>" <?=$dis_dept_acc?> data-id="<?=$no?>" class="deptAcc form-control text-uppercase" title="Pilih Dept Account" required>
                                        <option <?=$dis_dept_acc?> value="-">-</option>
                                        <?php
                                        $s_deptAcc = mysqli_query($link, $q_deptAcc)or die(mysqli_error($link));            
                                        while($dataDeptAcc = mysqli_fetch_assoc($s_deptAcc)){
                                            if($dataDeptAcc['id'] == $dMp['deptAcc']){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                            ?>
                                            <option <?=$selected?> <?=$dis_dept_acc?> value="<?=$dataDeptAcc['id']?>"><?=$dataDeptAcc['nama_org']?></option>
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
                                    <input type="hidden" name="t_dept" value="<?=$dMp['dept']?>" >
                                    <select name="dept[]" <?=$dis_dept?> id="dept<?=$no?>"  data-id="<?=$no?>" class="dept form-control text-uppercase" title="pilih dept" required>
                                        <option <?=$dis_dept?> value="-">-</option>
                                            <?php
                                            $s_dept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
                                            while($dataDept = mysqli_fetch_assoc($s_dept)){
                                                if($dataDept['id'] == $dMp['dept'] ){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$selected?> <?=$dis_dept?> title="<?=$dataDept['id']?>" value="<?=$dataDept['id']?>"><?=$dataDept['nama_org']?></option>
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
                                        <select name="sect[]" <?=$dis_sect?> id="section<?=$no?>" data-id="<?=$no?>" class="section form-control text-uppercase" data-size="7"
                                            data-style="btn btn-primary" title="Department" required>
                                            <option <?=$dis_sect?> value="-">-</option>
                                            <?php
                                            $s_sect = mysqli_query($link, $q_sect)or die(mysqli_error($link));
                                            while($dataSect = mysqli_fetch_assoc($s_sect)){
                                                if($dataSect['id'] == $dMp['section']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                                <option <?=$selected?> <?=$dis_sect?> value="<?=$dataSect['id']?>"><?=$dataSect['nama_org']?></option>
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
                                        <select name="group[]" <?=$dis_group?> id="group<?=$no?>" data-id="<?=$no?>" class="group form-control text-uppercase" data-size="7"
                                            data-style="btn btn-primary" title="group" required>
                                            <option <?=$dis_group?> value="-">-</option>
                                            <?php
                                            $s_group = mysqli_query($link, $q_group)or die(mysqli_error($link));
                                            while($dataGroup = mysqli_fetch_assoc($s_group)){
                                                if($dataGroup['id'] == $dMp['group']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$dis_group?> <?=$selected?> value="<?=$dataGroup['id']?>"><?=$dataGroup['nama_org']?></option>
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
                                        <select name="pos[]" <?=$dis_pos?> id="pos<?=$no?>" data-id="<?=$no?>" class="pos form-control text-uppercase" data-size="7"
                                            data-style="btn btn-primary" title="group" required>
                                            <option <?=$dis_pos?> value="-">-</option>
                                            <?php
                                            $s_pos = mysqli_query($link, $q_pos)or die(mysqli_error($link));
                                            while($dataPos = mysqli_fetch_assoc($s_pos)){
                                                if($dataPos['id'] == $dMp['pos']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                                ?>
                                                <option <?=$dis_pos?> <?=$selected?> value="<?=$dataPos['id']?>"><?=$dataPos['nama_org']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr style="border:1px dashed rgba(176, 174, 174, 0.9)"/>
                                    
                                    
                            <div class="row">
                                <div  class="col-sm-12">
                                    <button class="btn btn-success pull-right" type="submit" name="transfer">
                                        Send
                                    </button>
                                </div>
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    include_once("../endbody.php"); 
    ?>
    <script>
        $(document).ready(function(){
            function get_division(index){
                
                var index = index;
                var value = $('#division'+index).val();
                var parent = $('#plant'+index).val();
                $.ajax({
                    type:"GET",
                    url: "employee/proses/get_div.php",
                    data :{value:value},
                    success: function(data){
                        $('#division'+index).html(data);
                        get_dept(index)
                       
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
                        url: "employee/proses/get_deptAcc.php",
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
                    var value = $('#dept'+index).val();
                    console.log(parent)
                    $.ajax({
                        type:"GET",
                        url: "employee/proses/get_dept.php",
                        data :{value:value, parent:parent},
                        success: function(data){
                            $('#dept'+index).html(data);
                            get_sect(index)
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
                        url: "employee/proses/get_sect.php",
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
                    console.log()
                    $.ajax({
                        type: 'GET',
                        url: "employee/proses/get_group.php",
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
                    url: "employee/proses/get_pos.php",
                    data :{value:value, parent:parent},
                    success: function(msg){
                        $("#pos"+index).html(msg);
                        }
                    });
                }
                
            }
            $('.division').on('change',function(){
                var index = $(this).attr('data-id');
                // console.log($(this).val())
                get_deptAcc(index)
                get_dept(index)
            })
            $(".dept").on('change',function(e){
                var index = $(this).attr('data-id');
                get_sect(index)
            });
            $(".section").on('change',function(e){
                var index = $(this).attr('data-id');
                get_group(index)
            });
            $(".group").on('change',function(e){
                var index = $(this).attr('data-id');
                get_pos(index)
            });
        });
    </script>
    <?php
    include_once("../footer.php"); 
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>