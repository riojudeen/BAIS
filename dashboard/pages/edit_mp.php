<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    
?>
<?php
$npk = @$_GET['npk'];
$sql_editmp = mysqli_query($link, "SELECT * FROM karyawan WHERE npk = '$npk'")or die(mysqli_error($link))or die($link);
$data_edit = mysqli_fetch_assoc($sql_editmp);


?>
<!--konten isi -->
<div class="row">
    <div class="col-md-12">
        <div class="card ">

            <div class="card-header ">
                <div class="pull-right">
                    <a href="manpower.php" class="btn btn-default btn-round"><i
                            class="nc-icon nc-minimal-left"></i> Kembali</a>
                </div>
                <h4 class="card-title">Edit Data Man Power</h4>
                
            </div>
            <div class="card-body ">
                <form method="post" action="proses.php" class="form-horizontal">
                    <div class="row">
                        <label class="col-sm-2 col-form-label">NPK</label>
                        <div class="col-sm-10">
                            
                            <div class="form-group">
                                <input type="number" id="npk" value="<?=$data_edit['npk']?>" class="form-control" 
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap / nick</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" value="<?=$data_edit['nama']?>" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap"
                                    required autofocus>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" value="<?php if(empty($data_edit['nama_depan'])){$data_nick = explode(" ", $data_edit['nama']); echo $data_nick['0'];}else{echo $data_edit['nama_depan'];}?>"                              
                                
                                    name="nick" id="nick" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="" name="tgl_masuk" id="tgl_masuk" class="form-control datepicker"
                                    value="<?=tgl_query($data_edit['tgl_masuk'])?>"><?=tgl_query($data_edit['tgl_masuk'])?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="jabatan" id="jabatan" class="form-control" title="Pilih Jabatan" required>
                                    
                                    <?php
                                    $query_jbtn = "SELECT * FROM jabatan";
                                    $sql_jabatan = mysqli_query($link, $query_jbtn) or die(mysqli_error($link));
                                    while ($data_jbtn = mysqli_fetch_assoc($sql_jabatan)){
                                        if ($data_edit['jabatan'] == $data_jbtn['id_jabatan']){
                                            $select = "selected";
                                        } else {
                                            $select = ""; }
                                        echo "<option $select value=\"".$data_jbtn['id_jabatan']."\">".$data_jbtn['jabatan']."</option>";
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
                                    <?php
                                    $status = array('C1', 'C2', 'P');
                                    $sts = array('Kontrak 1', 'Kontrak 2', 'Permanent');
                                    for ($i=0; $i < count($status); $i++){
                                        if($data_edit['status'] == $status[$i]){
                                            $select_status = "selected";
                                        } else {
                                            $select_status = "";
                                        }                                        
                                        echo "<option $select_status value=\"".$status[$i]."\">".$sts[$i]."</option>";
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
                                    <?php
                                    $shift = array('A', 'B', 'N');
                                    $sft = array('A Shift', 'B Shift', 'N Shift');
                                    for ($i=0; $i < count($shift); $i++){
                                        if($data_edit['shift'] == $shift[$i]){
                                            $select_shift = "selected";
                                        } else {
                                            $select_shift = "";
                                        }                                        
                                        echo "<option $select_shift value=\"".$shift[$i]."\">".$sft[$i]."</option>";
                                    }
                                    ?>                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="dept" id="dept" class="form-control" data-size="7"
                                    data-style="btn btn-primary" title="Department" required>
                                    
                                    <?php
                                    //combobox department dari database table department 
                                      $sql_dept = mysqli_query($link, "SELECT * FROM department ORDER BY dept ASC") or die(mysqli_error($link));
                                      while($data_dept = mysqli_fetch_assoc($sql_dept)){
                                        echo '<option value="'.$data_dept['id_dept'].'">'.$data_dept['dept'].'</option>';
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
                                <select name="sect" id="sect" class="form-control" data-size="7"
                                    data-style="btn btn-primary" title="Department" required>
                                    <?php
                                    //combobox department dari database table department 
                                      $sql_sect = mysqli_query($link, "SELECT * FROM section ORDER BY section ASC") or die(mysqli_error($link));
                                      while($data_sect = mysqli_fetch_assoc($sql_sect)){
                                        echo '<option value="'.$data_sect['id_section'].'">'.$data_sect['section'].'</option>';
                                      }
                                    ?>

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
                                    <?php
                                    //combobox department dari database table department 
                                      $grp = mysqli_query($link, "SELECT * FROM groupfrm ORDER BY group_cord ASC") or die(mysqli_error($link));
                                      while($data_grp = mysqli_fetch_assoc($grp)){
                                        echo '<option value="'.$data_grp['id_group'].'">'.$data_grp['group_cord'].'</option>';
                                      }
                                    ?>

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
                                    <option value="id_area">Leader</option>
                                    <?php
                                    
                                    //combobox department dari database table department 
                                      $query_pos = mysqli_query($link, "SELECT * FROM pos_leader ORDER BY post_leader ASC") or die(mysqli_error($link));
                                      while($data_pos = mysqli_fetch_assoc($query_pos)){
                                        echo '<option value="'.$data_grp['id_post'].'">'.$data_grp['post_leader'].'</option>';
                                      }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2">
                            <button type="submit" name="edit" value="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
//untuk combobox organisasi
    $(document).ready(function() {
        $("#jabatan").change(function(){
      	var jabatan = $("#jabatan").val();
          	$.ajax({
          		type: 'POST',
              	url: "mp/get_status.php",
              	data: {jabatan: jabatan},
              	cache: false,
              	success: function(msg){
                  $("#status").html(msg);
                }
            });
        });
        
    var npk = $("#npk").val();
        $.ajax({
            type: 'POST',
            url: "dept/get_edit_dept.php",
            data: {npk: npk},
            cache: false,
            success: function(msg){
                $("#dept").html(msg);
            }
        });
    })
</script>



<?php
//footer
    include_once("../footer.php");


} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>