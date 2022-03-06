<!-- Modal -->
<form method="GET" action="schedule.php">
<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">

    <div class="modal-content">
    
        <div class="modal-header">
            <h5 class="modal-title pull-left" id="staticBackdropLabel">Leave Schedule</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body border">
        <div class="form-group">
            <label for="">Dari Tanggal : </label>
           <input type="text" name="tanggal" class="form-control datepicker" data-date-format="DD/MM/YYYY" id="schedule">
           
        </div>
        
            <label for="">NPK : </label>
            <select data-size="5" name="npk" id="" class="form-control selectpicker" data-live-search="true" data-header="input npk">
            <?php
            $tb = "org.".$org_access;
            $sqlkry = mysqli_query($link, "SELECT karyawan.npk AS npk,
            karyawan.nama AS nama, 
            org.post AS post,
            org.grp AS grp,
            org.sect AS sect,
            org.dept AS dept,
            org.dept_account AS dept_acc,
            org.division AS division,
            org.plant AS plant FROM karyawan
            LEFT JOIN org ON org.npk = karyawan.npk
            WHERE $tb = '$access_' ")or die(mysqli_error($link));
            if(mysqli_num_rows($sqlkry) > 0){
                while($datakry = mysqli_fetch_assoc($sqlkry)){
                    ?>
                    <option value="<?=$datakry['npk']?>"><?=$datakry['nama']." - ".$datakry['npk']?></option>
                    <?php
                }
            }
            ?>
            </select>
        
        
        </div>
        
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="add" value="Next"/>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
        </div>
    
    </div>

    
  </div>
</div>
</form>

<!-- Modal -->