<?php
include("../../../config/config.php"); 
include("../../../config/approval_system.php");
$npk = $_POST['id'];
list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
$q_karyawan = mysqli_query($link, "SELECT nama, npk, shift FROM karyawan WHERE npk = '$npk'")or die(mysqli_error($link));
$data_karyawan = mysqli_fetch_assoc($q_karyawan);
$nama = $data_karyawan['nama'];

$q_shift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));


// echo $tombolRequest;
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-left text-secondary" id="exampleModalLongTitle">Pengajuan Shift</h5>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table  py-0" >
                <tbody>
                    <tr class="py-0">
                        <td class="text-center"  style="border:1px solid #D6DBDF; width:100px " class="m-0 p-0">
                            <img src="../../assets/img/logo_daihatsu.png" alt="" style=" margin: 2px; padding:1px">
                        </td>
                        <td class="text-center" style="border:1px solid #D6DBDF; ">
                            <h5 class="text-uppercase title">Memo Perpindahan Shift</h5>
                        </td>
                        <td class="text-center"  style="border:1px solid #D6DBDF; ">
                            <h3 class="text-uppercase title"><?=date('Y')?></h3>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-body px-3">
       
        
        <div class="row">
            <div class="col-md-3 pr-1">
                <div class="form-group">
                    <label>Group :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $group, "group")?>">
                    <input type="hidden" class="form-control bg-transparent " name="npk" value="<?=$npk?>">
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Section :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $sect, "section")?>">
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Dept Functional :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $dept, "dept")?>">
                </div>
            </div>
            <div class="col-md-3 pl-1">
                <div class="form-group">
                    <label>Dept Administratif :</label>
                    <input type="text" class="form-control bg-transparent " disabled="true" value="<?=getOrgName($link, $dept_account, "deptAcc")?>">
                </div>
            </div>
            
        </div>
        <hr class="mt-0">
         <!-- isi -->
         <div class="row">
            <div class="col-md-10 pr-1 mb-0">
                <label>Nama :</label>
                <h5 class="title text-uppercase"><?=$nama?> - <?=$npk?></h6>
                <input name="shift" value="<?=$npk?>" type="hidden">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pr-1">
                <div class="form-group">
                    <label>Shift Asal :</label>
                    <select name="shift_asal" readonly class="form-control">
                        <?php
                        if(mysqli_num_rows($q_shift)>0){
                            while($sql_shift = mysqli_fetch_assoc($q_shift)){
                                $selected = ($sql_shift['id_shift'] == $data_karyawan['shift'])?'selected':'';
                                $disabled = ($sql_shift['id_shift'] != $data_karyawan['shift'])?'disabled':'';
                                ?>
                                <option <?=$selected?> <?=$disabled?> value="<?=$sql_shift['id_shift']?>"><?=$sql_shift['shift']?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Pindah Shift :</label>
                    <select name="shift_tujuan" class="form-control">
                        <?php
                        if(mysqli_num_rows($q_shift)>0){
                            $q_shift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                            while($sql_shift = mysqli_fetch_assoc($q_shift)){
                                
                                $disabled = ($sql_shift['id_shift'] == $data_karyawan['shift'])?'disabled':'';
                                ?>
                                <option <?=$disabled?> value="<?=$sql_shift['id_shift']?>"><?=$sql_shift['shift']?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    
                </div>
            </div>
            <div class="col-md-3 px-1">
                <div class="form-group">
                    <label>Tanggal Mulai : </label>
                    <input type="date" name="start" required class="form-control datepicker bg-transparent" value="<?=getOrgName($link, $dept, "dept")?>">
                </div>
            </div>
            <div class="col-md-3 pl-1">
                <div class="form-group">
                    <label>Tanggal Selesai :</label>
                    <input type="date" name="end"  required class="form-control datepicker bg-transparent" value="<?=getOrgName($link, $dept_account, "deptAcc")?>">
                </div>
            </div>
            
        </div>
        
    </div>

    <div class="modal-footer ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-secondary" >Subit Request</button>
    
    </div>
</div>
