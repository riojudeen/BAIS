<?php 

//////////////////////////////////////////////////////////////////////
include("../../config/config.php");
include("../../config/cost/date.php");
include("../../config/cost/otDL.php"); 
include("../../config/cost/otIDL.php");
include("../../config/cost/index.php"); 
//redirect ke halaman dashboard index jika sudah ada session

if(isset($_SESSION['user'])){
    // echo bln($tanggalAwal);
    if(isset($_GET['dept'])){
        $dept = $_GET['dept'];
        if($dept == '5'){
            $title = 'Labour Cost Body 1';
            $car12 = '46';
            $car14 = '47';
            $mix12 = '43';
            $sp12 = '46';
            $mix14 = '44';
            $sp14 = '47';
            $mix40 = '49';
            $mix26 = '45';
            $sp26 = '48';
            $mix = 'mix';
            $sp = 'shell';
            $idr = 'idr';
            $dataidr1 = '8';//body1
            $dataidr2 = '9';//body2
            //SALARY
            $dept = 5;//$_GET['d'];
            $type = 'overtime';
        }else{
            $title = 'Labour Cost Body 2';
            $car40 = '48';
            $sp40 = '49';
            
            
            $mix = 'mix';
            $sp = 'shell';
            $idr = 'idr';
            
            $dataidr1 = '9';//body2
            //SALARY
            
            $type = 'overtime';
        }
        
      }else{
        echo "<script>window.location='".base_url('')."';</script>";
      }
      $halaman = $title;
      include_once("../header.php");
?>

<!-- modal import data cost -->
<form method=get" id="form_upload" action="">
    <div class="modal fade bd-example-modal-md" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalfilter">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-left" id="exampleModalLongTitle">Pilih Bulan</h5>
                </div>
                <div class="modal-body px-3">
                    <div class="col-lg-12 text-center">
                        <select class="selectpicker" data-size="7" name="start" data-style="btn btn-outline-default text-default btn-sm btn-round" title="Month">
                            <option disabled>Select Month</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <input type="hidden" name="dept" value="<?=$dept?>">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="filter" class="btn btn-primary">Set</button>
                </div>
            </div>
        </div>
    </div>
</form>

    <?php
    if($dept == '5'){
        include_once("b1.php"); 
    }else{
        
        include_once("b2.php");
    }
    include_once("../footer.php"); 
    include_once("../endbody.php");
    include_once("../chart/overtime.php");
    include_once("../chart/salary.php");
    include_once("../chart/activity.php");
///jika tidak ada session maka akan diarahkan ke ahalam login
} else{
  echo "<script>window.location='".base_url('../auth/login.php')."';</script>";
}

?>