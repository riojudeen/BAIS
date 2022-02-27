<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
if(isset($_SESSION['user'])){ 
    if(isset($_POST['index'])){
        $halaman = "Man Power Management Seting";
        include_once("../../../header.php");
        ///////////////////////////////////////////////////////////////
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">

                    <div class="card-header ">
                    <h4 class="card-title pull-left">Edit Data Resource</h4>
                        <div class=" box pull-right">
                            <a href="../add_karyawan.php" class="btn btn-default "><i
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

            //data organisasi karyawan
            $q_div = $q_org." WHERE part = 'division'";
            $q_deptAcc = $q_org." WHERE part = 'deptAcc'";
            $q_dept = $q_org." WHERE part = 'dept'";
            $q_sect = $q_org." WHERE part = 'section' ";
            $q_group = $q_org." WHERE part = 'group'";
            $q_pos = $q_org." WHERE part = 'pos'";
  
            // data plant
            $sql_div = mysqli_query($link, $q_div)or die(mysqli_error($link));
            $dataDiv = mysqli_fetch_assoc($sql_div);
            $q_plant = "SELECT * FROM company WHERE id_company = '$dataDiv[id_parent]'";
            $s_plant = mysqli_query($link, $q_plant)or die(mysqli_error($link));
            $dataPlant = mysqli_fetch_assoc($s_plant);
        ?>
        
                <h5 class="title text-info"><em>[Data <?=$no?>]</em> : <?=$dMp['nama']?></h5>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <h6>Account & Profile Data</h6>
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
                            <select name="shift[]" id="shift<?=$no?>" data-id="<?=$no?>" class="shift form-control text-uppercase" title="Pilih Jabatan" required>
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
                            <select name="jabatan[]" id="jabatan<?=$no?>" data-id="<?=$no?>" class="jabatan form-control text-uppercase" title="Pilih Jabatan" required><option disabled>Pilih Jabatan</option>
                                <option >-</option>
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
                <div class="row">
                    <label class="col-sm-2 col-form-label">Department Account</label>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select name="deptAcc[]" id="deptAcc<?=$no?>" data-id="<?=$no?>" class="deptAcc form-control text-uppercase" title="Pilih Dept Account" required>
                            <option >-</option>
                            <?php
                            $s_deptAcc = mysqli_query($link, $q_deptAcc)or die(mysqli_error($link));            
                            while($dataDeptAcc = mysqli_fetch_assoc($s_deptAcc)){
                                if($dataDeptAcc['id'] == $dMp['deptAcc']){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option <?=$selected?> value="<?=$dataDeptAcc['id']?>"><?=$dataDeptAcc['nama_org']?></option>
                                    <?php
                            }
                            ?>                   
                            </select>
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label">Division :</label>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select name="division[]" id="division<?=$no?>" data-id="<?=$no?>" class="division form-control text-uppercase" title="Pilih Jabatan" required>
                            <option >-</option>
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
                    <label class="col-sm-1 col-form-label">Plant :</label>
                    <div class="col-sm-2 bg-transparent ml-0">
                        <div class="form-group no-border">
                            <input type="text" readonly class="form-control bg-transparent text-uppercase" value="<?=$dataPlant['nama']?>">
                            <input name="plant[]" type="hidden" id="plant<?=$no?>" data-id="<?=$no?>" readonly class="plant form-control bg-transparent text-uppercase" value="<?=$dataPlant['id_company']?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <h6>Organization Data</h6>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Department Functional</label>
                    <div class="col-sm-10">
                        <div class="form-group">
                        <select name="dept[]" id="dept<?=$no?>"  data-id="<?=$no?>" class="dept form-control text-uppercase" title="pilih dept" required>
                            <option >-</option>
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
                                <option >-</option>
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
                                <option >-</option>
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
                                <option >-</option>
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
    ?>




    

<?php
    include_once("../../../footer.php");
    ?>
    <!-- javascript -->
    <script type="text/javascript">
    $(document).ready(function(){
        $('.division').click(function(){
            var index = $(this).attr('data-id');
            var value = $(this).val();
            var parent = $('#plant'+index).val();
            $.ajax({
                type:"GET",
                url: "get_div.php",
                data :{value:value},
                success: function(data){
                    $('#division'+index).html(data);
                }
            })
        })
        $('.division').change(function(){
            var parent = $(this).val();
            var index = $(this).attr('data-id');
            var value = $('#deptAcc'+index).val();
            $.ajax({
                type:"GET",
                url: "get_deptAcc.php",
                data :{value:value, parent:parent},
                success: function(data){
                    $('#deptAcc'+index).html(data);
                }
            })
        })
        $('.division').change(function(){
            var parent = $(this).val();
            var index = $(this).attr('data-id');
            var value = $('#dept'+index).val();
            $.ajax({
                type:"GET",
                url: "get_dept.php",
                data :{value:value, parent:parent},
                success: function(data){
                    $('#dept'+index).html(data);
                }
            })
        })
        $('.deptAcc').click(function(){
            var index = $(this).attr('data-id');
            var parent = $('#division'+index).val();
            var value = $(this).val();
            $.ajax({
                type:"GET",
                url: "get_deptAcc.php",
                data :{value:value, parent:parent},
                success: function(data){
                    $('#deptAcc'+index).html(data);
                }
            })
        })
		
        $(".dept").click(function(e){
            var index = $(this).attr('data-id');
            var parent = $('#division'+index).val();
            var value = $(this).val();
            $.ajax({
                type: 'GET',
                url: "get_dept.php",
                data :{value:value, parent:parent},
                success: function(msg){
                    $("#dept"+index).html(msg);
                }
            });
        });
        $(".dept").change(function(e){
            var index = $(this).attr('data-id');
            var parent = $(this).val();
            var value = $('#section'+index).val();
            $.ajax({
                type: 'GET',
                url: "get_sect.php",
                data :{value:value, parent:parent},
                success: function(msg){
                    $("#section"+index).html(msg);
                }
            });
        });
        $(".section").click(function(e){
            var index = $(this).attr('data-id');
            var parent = $('#dept'+index).val();
            var value = $(this).val();
            $.ajax({
            type: 'GET',
            url: "get_sect.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#section"+index).html(msg);
                }
            });
        });
        $(".section").change(function(e){
            var index = $(this).attr('data-id');
            var parent = $(this).val();
            var value = $('#group'+index).val();
            $.ajax({
            type: 'GET',
            url: "get_group.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#group"+index).html(msg);
                }
            });
        });
        $(".group").click(function(e){
            var index = $(this).attr('data-id');
            var parent = $('#section'+index).val();
            var value = $(this).val();
            $.ajax({
            type: 'GET',
            url: "get_group.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#group"+index).html(msg);
                }
            });
        });
        $(".group").change(function(e){
            var index = $(this).attr('data-id');
            var parent = $(this).val();
            var value = $('#pos'+index).val();
            $.ajax({
            type: 'GET',
            url: "get_pos.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#pos"+index).html(msg);
                }
            });
        });
        $(".pos").click(function(e){
            var index = $(this).attr('data-id');
            var parent = $('#group'+index).val();
            var value = $(this).val();
            $.ajax({
            type: 'GET',
            url: "get_pos.php",
            data :{value:value, parent:parent},
            success: function(msg){
                $("#pos"+index).html(msg);
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
            url: "get_status.php",
            data: {id : id , val : val},
            success: function(msg){
                $("#status"+id).html(msg);
                }
            });
        });
    });
    </script>
    <?php
    include_once("../../../endbody.php"); 

}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>