<?php

?>

<form action="proses.php" method="POST">
    <div class="modal fade bd-example-modal-xl" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalinputdata">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-left" id="exampleModalLongTitle">Input Data Man Power</h5>
                </div>
                <div class="modal-body px-3">
                    <?php
                    // include_once("ajax/set_record.php");
                    
                    ?>
                    <div class="card card-body">
                        <h5 class="text-danger "><i class="fa fa-calendar pull-left text-danger my-auto pl-2"></i>Overtime Activity</h5>
                            <input type="hidden" class="form-control"  name="requester" value="<?=$npk_user?>"/>
                        
                        
                        <div class="row px-2">
                            <div class="col-md-4 px-2 ">
                                <label class="m-0" for="Jobcode">Mulai</label>
                                <div class="form-group mt-2">
                                    <!-- <label>Waktu Mulai</label> -->
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                        </div>
                                        <input type="hidden"  class="form-control datepicker" data-date-format="DD/MM/YYYY" name="work_date" value="<?=$ot_date?>" >
                                        <input type="text"  class="form-control datepicker" id="DateTimePicker1" data-date-format="DD/MM/YYYY" name="tanggalmulai" value="<?=$ot_date?>" placeholder="tanggal mulai"  required>
                                        <div class="input-group-append pl-0 m-0">
                                            <span class="input-group-text px-2"><i class="nc-icon nc-time-alarm"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker waktu" data-date-format="HH:mm:ss" name="waktumulai" required>
                                    </div>
                                </div>
                                <label class="m-0" for="Jobcode">Sampai</label>
                                <div class="form-group mt-2">
                                
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                        </div>
                                        <input id="DateTimePicker2" type="text" class="form-control datepicker" name="tanggalselesai"  data-date-format="DD/MM/YYYY" value="<?=$ot_date?>" required >
                                        
                                        <div class="input-group-append pl-0 m-0">
                                            <span class="input-group-text px-2"><i class="nc-icon nc-time-alarm"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker waktu" data-date-format="HH:mm:ss" name="waktuselesai" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-2 pr-1 mt-1">
                                <div class="form-group p-0" >
                                    <label for="Jobcode">Activity</label>
                                    <input style="height:115px" type="text" class="form-control" placeholder="Improvement area, alat, metode, ... etc." name="activity" required />
                                </div>
                                
                            </div>
                            <div class="col-md-2 px-2 ">
                                <div class="form-group p-0 my-0">
                                <label class="m-0" for="Jobcode">Job Code</label>
                                    <select type="text" class="form-control selectpicker p-0" data-size="5" data-style="btn btn-outline-warning" id="jobcode" data-actions-box="true" name="jobcode" title="Kode Activity" required>
                                    <?php
                                        $q_jobcode = "SELECT * FROM kode_lembur";
                                        $s_jobcode = mysqli_query($link, $q_jobcode)or die(mysqli_error($link));
                                        while($jobcode = mysqli_fetch_assoc($s_jobcode)){
                                            echo "<option data-subtext=\"$jobcode[nama]\" value=\"$jobcode[kode_lembur]\">".$jobcode['kode_lembur']."</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row px-2">
                            <div class="form-group col-md-2 p-0 my-0 pl-2 mt-1">
                                <label class="m-0" for="Jobcode">Shift</label>
                                <select id="shf" class="form-control selectpicker p-0" data-style="btn-warning btn-outline-warning" data-size="7" name="shift[]" title="Pilih Shift" multiple>
                                <optgroup>Tes</optgroup>
                                <?php
                                $s_shift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                                while($dataShift = mysqli_fetch_assoc($s_shift)){
                                    
                                ?>
                                    <option value=<?=$dataShift['id_shift']?>><?=$dataShift['shift']?></option>
                                <?php
                                    
                                }
                                ?>
                               
                                </select>    
                            </div>
                            <div class="form-group col-md-10 p-0 my-0 pl-2 mt-1">
                                <label class="m-0" for="Jobcode">Area</label>
                                <select class="form-control selectpicker p-0" data-actions-box="false" data-style="btn-warning btn-outline-warning" data-size="7" id="area" name="org[]" title="Pilih Area" multiple>
                                <optgroup>Tes</optgroup>
                                <?php
                                $sqlArea = area_jabatan($link, $jabatan, $npkUser);

                                // list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
                                
                                // $qry_area = "SELECT org.$clm AS '1', 
                                // $tbl2.$clm2 AS '2' FROM org
                                // JOIN $tbl2 ON $tbl2.$tbl3 = org.$clm WHERE $t = '$access_'  GROUP BY org.$clm";
                                // $sqlArea = mysqli_query($link, $qry_area );

                                // $qry_Shift = "SELECT org.$clm AS '1', $tbl2.$clm2 AS '2', karyawan.shift AS 'shift' FROM org 
                                // JOIN $tbl2 ON $tbl2.$tbl3 = org.$clm WHERE $t = '$access_' LEFT JOIN karyawan ON org.npk = karyawan.npk GROUP BY org.$clm";
                                // $sqlShift = mysqli_query($link, $qry_area );
                                
                                while($dataArea = mysqli_fetch_assoc($sqlArea)){
                                    
                                    ?>
                                    
                                    <option data-subtext="<?=$dataArea['nama']?>" value=<?=$dataArea['id_area']?>><?=$dataArea['nama_area']?></option>
                                    <?php
                                }
                                ?>
                                </select>    
                            </div>
                            
                        </div> 
                    </div>
                    
                    <div class="card card-body">
                        <h5 class="text-danger "><i class="nc-icon nc-single-02 pull-left text-danger my-auto pl-2"> </i> Select Man Power</h5>
                        
                        <div class="data-mp mx-0 px-0 text-uppercase text-center"><p>area belum dipilih</p></div>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="add" value="Simpan" class="btn btn-primary"/>
                </div>
            
            </div>
        </div>
    </div>
</form>