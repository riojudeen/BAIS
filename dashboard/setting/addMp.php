<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Man Power Management Seting";
    include_once("../header.php");
    if(isset($_POST['count'])){

        ?>
<style>
    .view {
    margin: auto;
    width: 600px;
    }

    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    z-index: 100;
    }

    .first-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    left: 0px;
   
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }


    .second-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    left: 50px;
    }
    .second-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 150px;
    }
    .third-top-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }



</style>
<!-- modal reset  -->

<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Jumlah Record MP</h4>
                </div>
                <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <!-- <label>Waktu Mulai</label> -->
                        <input type="text" name="count" value="<?=$_POST['count']?>" class="form-control text-center" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link">Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal reset -->
<div id="tes1"></div>
    <div class="row ">
        <div class="col-md-12">
            <form action="proses/proses.php" method="POST" id="TypeValidation">
                <div class="card">
                    <div class="card-header">
                        <h5 class="pull-left">Tambah data Man Power</h5>
                        <div class="pull-right">
                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#generate">
                                Reset Record
                            </a>
                            <a href="manpower.php" class="btn btn-default"><i class="nc-icon nc-bullet-list-67"></i> Back</a>
                        </div>
                        
                    </div>
                    <div class="card-body ">
                    <!-- <input type="text" class="form-control" name="total" value=">"> -->
                        <div class="table-responsive"  style="height:500px">                    
                            <table class="table  table-bordered">
                            
                                <thead>
                                    <tr>
                                        <th class="sticky-col first-col first-top-col">No</th>
                                        <th class="sticky-col second-col second-top-col">NPK</th>
                                        <th class="sticky-col third-col third-top-col">Nama</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Dept Account</th>
                                        <th>Shift</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Dept Functional</th>
                                        <th>Section</th>
                                        <th>Group</th>
                                        <th>Pos</th>
                                        
                                        
                                        
                                    </tr>
                                    
                                </thead>
                                
                                <?php
                                    for ($i=1; $i<=$_POST['count']; $i++){
                                    ?>
                                    <tr class="">
                                        <td class="py-0 px-1 text-center sticky-col first-col"><?=$i?></td>
                                        <td class="py-0 px-0 sticky-col second-col" >
                                            <div class="form-group-sm" >
                                                <input autocomplete="off" type="text" class="form-control npk" placeholder="NPK" name="npk[]" style="min-width:100px" id="npk<?=$i?>" data-id="<?=$i?>" value="" required autofocus  pattern="[0-9]+">
                                            </div>
                                        </td>
                                        <td class="py-0 px-0 sticky-col third-col"  style="width:100px" class="form-group p-1">
                                            <div class="form-group-sm" >
                                                <input autocomplete="off" type="text" class="form-control" placeholder="Nama Lengkap" name="nama[]" id="nama<?=$i?>" style="min-width:300px" value="" required pattern="[A-Z a-z]+">
                                            </div>
                                        </td>
                                        <td class="py-0 px-0">
                                            <div class="form-group-sm" >
                                                <input  autocomplete="off" type="text" class="form-control datepicker" data-date-format="DD-MM-YYYY" placeholder="Tanggal Masuk" name="tgl_masuk[]" style="min-width:150px" required>
                                            </div>
                                        </td >
                                        <td class="py-0 px-0" style="width:130px">
                                            <select class="form-control selectpicker deptAcc" data-size="7" name="department[]" data-style="btn btn-warning bg-white btn-link border" title="Department" data-width="130px" data-id="<?=$i?>" id="deptAcc<?=$i?>" required>
                                                <option disabled>Pilih Dept</option>
                                                <?php
                                                $optDeptAcc = mysqli_query($link, "SELECT * FROM dept_account WHERE id_div = 1 ORDER BY id_dept_account")or die(Mysqli_error($link));
                                                while($dDeptAcc = mysqli_fetch_assoc($optDeptAcc)){
                                                    ?>
                                                    <option value="<?=$dDeptAcc['id_dept_account']?>"><?=$dDeptAcc['department_account']?></option>
                                                     <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="py-0 px-0" style="width:100px">
                                            <select class="form-control selectpicker" data-size="7"  name="shift[]" data-style="btn btn-warning btn-link border bg-white" title="Shift" data-width="100px" style="min-width:100px" required>
                                                 <option disabled>Pilih Shift</option>
                                                <?php
                                                $optShift = mysqli_query($link, "SELECT * FROM shift ORDER BY id_shift ASC")or die(Mysqli_error($link));
                                                while($dShift = mysqli_fetch_assoc($optShift)){
                                                    ?>
                                                    <option value="<?=$dShift['id_shift']?>"><?=$dShift['shift']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="py-0 px-0" style="width:150px">
                                            <select class="selectpicker jabatan" data-size="7" name="jabatan[]" data-style="btn btn-warning btn-link border bg-white" title="Jabatan" data-width="150px" id="jabatan<?=$i?>" data-id="<?=$i?>" required>
                                                <option disabled>Pilih Jabatan</option>
                                                <?php
                                                $optJabatan = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` DESC")or die(Mysqli_error($link));
                                                while($dJabatan = mysqli_fetch_assoc($optJabatan)){
                                                    ?>
                                                    <option title="<?=$dJabatan['id_jabatan']?>" value="<?=$dJabatan['id_jabatan']?>"><?=$dJabatan['jabatan']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="py-0 px-0" style="width:100px">
                                            <div id="status<?=$i?>">
                                                <select class="selectpicker" data-size="7" name="status[]" data-style="btn btn-warning btn-link border bg-white" title="Status" data-width="100px"  data-id="<?=$i?>" id="stats<?=$i?>" required>
                                                    <option >Pilih Status</option>
                                                    
                                                </select>
                                            </div>
                                        </td >
                                        <td class="py-0 px-0 form-group-sm" style="width:150px">
                                            <select class="form-control department" data-size="7" name="dept[]" data-style="btn btn-warning btn-link border bg-white" title="Dept Functional" data-width="150px" id="dept<?=$i?>" data-id="<?=$i?>" style="width:150px" required placeholder="tes">
                                                <option value="0">-</option>
                                                <?php
                                                
                                                ?>
                                            </select>
                                        </td>
                                        <td class="py-0 px-0"  style="width:150px">
                                            <div id="sect<?=$i?>" style="width:150px">
                                                <select class="form-control sect" data-size="7" name="sect[]" data-style="btn btn-warning btn-link border bg-white" title="Section" data-width="150px" id="section<?=$i?>" data-id="<?=$i?>" style="width:150px" required>
                                                    <option disabled>Pilih Section</option>
                                                    <option value="0">-</option>
                                                   
                                                </select>
                                            
                                            </div>
                                            
                                        </td>
                                        <td class="py-0 px-0" style="width:150px">
                                            <div id="groupfrm<?=$i?>">
                                                <select class="form-control groupfr" name="group[]" data-size="7" data-style="btn btn-warning btn-link border bg-white" title="Group" data-width="150px" id="group<?=$i?>" data-id="<?=$i?>" style="width:150px" required>
                                                    <option disabled>Pilih Group</option>
                                                    <option value="0">-</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="py-0 px-0" style="width:150px">
                                            <div id="posleader<?=$i?>" >
                                                <select class="form-control pos" name="pos[]" data-size="7" data-style="btn btn-warning btn-link border bg-white" title="Pos"  data-width="150px" id="pos<?=$i?>" data-id="<?=$i?>" style="width:150px" required>
                                                    <option disabled>Pilih Pos</option>
                                                    <option value="0">-</option>
                                                </select>
                                            </div>
                                        </td>
                                        
                                        
                                        
                                    
                                    </tr>


                                    <?php
                                    }
                                    ?>
                            
                                    <tbody>
                            </table>
                                
                        </div>
                        <div class="box pull-right">
                            <button class="btn btn-danger" type="reset">
                                <span class="btn-label">
                                    <i class="nc-icon nc-cloud-download-93"></i>
                                </span>
                                Reset
                            </button>
                            <input type="submit" name="save" id="submit" class="btn btn-success" >
                               
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
    // $(document).ready(function(){
    //     $(function () {
    //         $('select').selectpicker();
            
    //     });
    // });
    </script>
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
    <!-- validasi npk -->
    <script type="text/javascript">
		$(document).ready(function(){
            $('.npk').keyup(function() {
                var id = $(this).attr('data-id');
                var npk = $(this).val();

                if('#npk'+id == 0) {
                    $('#nama'+id).val('');
                }
                else {
                    $.ajax({
                        url: 'proses/validasiNpk.php',
                        type: 'POST',
                        data: {npk : npk},
                        success: function(hasil) {
                            
                            if(hasil > 0) {
                                $('#nama'+id).val('NPK Sudah ada di database');
                                $('#nama'+id).attr('disabled','true');
                                $('#submit').attr('disabled','true');
                            }
                            else {
                                $('#nama'+id).val('');
                                $('#nama'+id).removeAttr('disabled');
                                $('#submit').removeAttr('disabled');
                            }
                        }
                    });
                }
            });
        });
    </script>

    <!-- validasi npk -->

        <?php
    }else{
        echo "<script>window.location='manpower.php';</script>";
    }
        include_once("../footer.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>
