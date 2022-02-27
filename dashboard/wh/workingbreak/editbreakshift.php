<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Adda Data Holiday";
    include_once("../../header.php");
    $query = "SELECT working_break_shift.id_working_day_shift AS `shift`,
    working_day_shift.name AS working_day,
    working_break_shift.id_working_break AS `id_break`,
    working_break_shift.effective_date AS `effective`,
    working_break_shift.break_group_id AS `break_group`,
    working_break.scheme_name AS `skema`,
    working_break.start_time AS `start`,
    working_break.end_time AS `end`
    FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
    LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
    WHERE working_break_shift.break_group_id = '$_GET[edit]'
    ";
    $queryBreak = mysqli_query($link, $query)or die(mysqli_error($link));
    $queryBreakShift = mysqli_query($link, $query)or die(mysqli_error($link));
    
    $dataArray = array();

    $sqlShift = mysqli_fetch_assoc($queryBreakShift);
    $dataShift = $sqlShift['shift'];
    $dataEff = DBtoForm($sqlShift['effective']);
    while($data = mysqli_fetch_assoc($queryBreak)){
        array_push($dataArray, $data['id_break']);
    }
    var_dump($dataArray);
    // echo $dataShift;
?>
<!-- halaman utama -->


<div class="row ">

    <div class="col-md-12 ">
    
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Edit Seting Data Break / Shift</h5>
                <a href="../index.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <hr>
            <form action="proses.php" method="POST">
                <div class="card-body">
                    <input type="hidden" name="editbreakshift" class="form-control" value="<?=$_GET['edit']?>">
                    <label>Shift</label>
                    <select name="shift" class="form-control" id="" readonly>
                        <?php
                        $q = mysqli_query($link, "SELECT * FROM working_day_shift")or die(mysqli_error($link));
                        if(mysqli_num_rows($q) > 0){
                            while($data =mysqli_fetch_assoc($q)){
                                $select = ($dataShift == $data['id'])?"selected":"";
                                ?>
                                <option <?=$select?> value="<?=$data['id']?>"><?=$data['name']?></option>
                                <?php

                            }
                        }else{
                            ?>
                            <option>Belum Ada Data</option>
                            <?php
                        }

                        ?>
                        
                    </select>
                    <div class="control-group after-add-more data-add-1" data-id="1">
                        <label>Working Break Seting</label>
                        <select name="wb[]" class="form-control selectpicker" id="" data-title="Pilih Jam Istirahat" multiple>
                            <?php
                            $q = mysqli_query($link, "SELECT * FROM working_break")or die(mysqli_error($link));
                            if(mysqli_num_rows($q) > 0){
                                while($data =mysqli_fetch_assoc($q)){
                                    $select = (in_array($data['id'],$dataArray))?"selected":"";
                                    ?>
                                    <option <?=$select?> data-subtext="<?=$data['scheme_name']?>" value="<?=$data['id']?>"> Start: <?=$data['start_time']?> End: <?=$data['end_time']?></option>
                                    <?php

                                }
                            }else{
                                ?>
                                <option>Belum Ada Data</option>
                                <?php
                            }

                            ?>
                            
                        </select>
                        
                    </div>
                    <label>Effective Date</label>
                    <input type="text" name="effective" readonly class="form-control datepicker" data-date-format="DD/MM/Y" required value="<?=$dataEff?>">
                    <br>
                </div>
                <hr>
                <div class="card-footer text-right">
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </div>
                <br/>
                
            </form>
        </div>
        
    </div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../../footer.php");
    ?>
    

<?php
    //javascript
    
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
