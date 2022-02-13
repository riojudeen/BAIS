<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Working Hours Seting";
    include_once("../../header.php");
    if($_GET['add'] == 'break'){
        ?>
        <!-- halaman utama -->

        <div class="row ">

            <div class="col-md-12 ">
            
                <div class="card">
                    <div class="card-header">
                        <h5 class="title pull-left">Add Master Data</h5>
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
                            <input type="hidden" name="addbreak" class="form-control" value="<?=$_GET['add']?>">
                            <div class="control-group after-add-more data-add-1" data-id="1">
                                <h5 class="text-uppercase">Data 1</h5>
                                <label>Skema</label>
                                <input type="text" name="skema[]" class="form-control" maxLength="30"  required >
                                <label>Start Time</label>
                                <input type="text" name="start[]" class="form-control datepicker" data-date-format="HH:mm"   required >
                                <label>End Time</label>
                                <input type="text" name="end[]" class="form-control datepicker" data-date-format="HH:mm"  required >
                                
                                <label>Effective Date</label>
                                <input type="text" name="effective[]" class="form-control datepicker" data-date-format="DD/MM/Y" required >
                                <br>
                            </div>
                        </div>
                        <hr>
                        <div class="card-footer"> 
                            <button class="btn btn-info add-more" data-id="1">
                                <i class="nc-icon nc-simple-add"></i> Add
                            </button>
                            <button class="btn btn-success pull-right" type="submit">SUBMIT</button>
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
            <script type="text/javascript">
                $(document).ready(function() {
                    
                $(".add-more").click(function(e){
                    e.preventDefault();
                    var count = $('.after-add-more').length;
                        var newData = count+1;
                        console.log(newData);
                    var html = "";  
                    html += '<div class="control-group after-add-more data-add-'+newData+'" data-id="'+newData+'">';
                    html += '<hr style="border: 2px dashed #F4F3EF; margin-top:2rem;">';
                    html += '<h5 class="text-uppercase">Data '+newData+'</h5>';
                    html += '<label>Skema</label>';
                    html += '<input type="text" name="skema[]" class="form-control" maxLength="30"  required >';
                    html += '<label>Start Time</label>';
                    html += '<input type="time" name="start[]" class="form-control datepicker" data-date-format="HH:mm:ss"   required >';
                    html += '<label>End Time</label>';
                    html += '<input type="time" name="end[]" class="form-control datepicker" data-date-format="HH:mm:ss"  required >';
                    html += '<label>Effective Date</label>';
                    html += '<input type="date" name="effective[]" class="form-control datepicker" data-date-format="DD/MM/Y" required >';
                
                    html += '<div class="btn btn-danger remove" data-id="'+newData+'">';
                    html += '<i class="nc-icon nc-simple-add"></i> Remove';
                    html += '</div>';
                    html += '</div>';
                    $(".data-add-"+count).after(html);
                });
                // saat tombol remove dklik control group akan dihapus 
                    $("body").on("click",".remove",function(){ 
                        var data = $(this).attr('data-id')
                        $(this).parents(".data-add-"+data).remove();
                    });
                });
            </script>

        <?php
        include_once("../../endbody.php"); 
    }else if($_GET['add'] == 'breakshift'){
        ?>
        <!-- halaman utama -->

        <div class="row ">

            <div class="col-md-12 ">
            
                <div class="card">
                    <div class="card-header">
                        <h5 class="title pull-left">Add Seting Data Break / Shift</h5>
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
                            <input type="hidden" name="addbreakshift" class="form-control" value="<?=$_GET['add']?>">
                            
                                
                            <label>Shift</label>
                            <select name="shift" class="form-control" id="">
                                <?php
                                $q = mysqli_query($link, "SELECT * FROM working_day_shift")or die(mysqli_error($link));
                                if(mysqli_num_rows($q) > 0){
                                    while($data =mysqli_fetch_assoc($q)){
                                        ?>
                                        <option value="<?=$data['id']?>"><?=$data['name']?></option>
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
                                            ?>
                                            <option data-subtext="<?=$data['scheme_name']?>" value="<?=$data['id']?>"> Start: <?=$data['start_time']?> End: <?=$data['end_time']?></option>
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
                            <input type="text" name="effective" class="form-control datepicker" data-date-format="DD/MM/Y" required >
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
        include_once("../../endbody.php"); 
    }

    //javascript
    
    
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
