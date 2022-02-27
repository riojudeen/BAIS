<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Edit Data Day Scheme";
    include_once("../../header.php");
?>
<?php
$explode = explode('/',$_GET['workday']);
$tgl = $explode[0];
$shift = $explode[1];
// echo $_GET['workday'];
$query = mysqli_query($link, "SELECT * FROM working_days WHERE `date` = '$tgl' AND shift = '$shift' ")or die(mysqli_error($link));
$dataWd = mysqli_fetch_assoc($query);
// echo $dataWd['ket'];
?>
<!-- halaman utama -->
<div class="row ">
	<div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Edit Setting</h5>
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
                    <input type="hidden" name="id" class="form-control" value="<?=$_GET['workday']?>">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Working Hours</h6>
                            <div class="loadWh">

                            </div>
                            <h6>Working Break</h6>
                            <div class="loadWb">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Data Seting</h6>
                            <div class="row">
                                
                                <div class="form-group after-add-more col-md-12">
                                    <label for="">Hari</label>
                                    <input class="form-control" type="text" value="<?=$dataWd['date']?>" readonly>
                                </div>
                                <div class="form-group after-add-more col-md-12">
                                    <label for="">Shift</label>
                                    <input class="form-control" type="text" readonly name="shift" value="<?=$dataWd['shift']?>">
                                </div>
                                <div class="form-group after-add-more col-md-12">
                                    <label for="">Operational</label>
                                    <select name="operational" class="form-control" id="">
                                        <?php
                                        $arrayOp = array("DOP","HOP");
                                        foreach($arrayOp as $dataOp){
                                            $select = ($dataWd['ket'] == $dataOp)?"selected":"";
                                            // echo $select;
                                            $operational = ($dataOp == "HOP")?"Holiday Operational":"Daily Operational";
                                            ?>
                                            <option <?=$select?> value="<?=$dataOp?>"><?=$operational?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    
                                </div>
                                <div class="col-md-12">
                                    <label for="">Jam Kerja</label>
                                    <div class="form-group">

                                        <select name="wh" id="datawh" class="form-control" >
                                        <?php
                                        $queryWh = mysqli_query($link, "SELECT * FROM working_hours ")or die(mysqli_error($link));
                                        if(mysqli_num_rows($queryWh)>0){
                                            while($dataWh = mysqli_fetch_assoc($queryWh)){
                                                $selectWh = ($dataWh['id'] == $dataWd['wh'])?"selected":""
                                                ?>
                                                <option <?=$selectWh?> value="<?=$dataWh['id']?>"><?=$dataWh['ket']?> : <?=$dataWh['start']?> s.d. <?=$dataWh['end']?></option>
    
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="0">Belum Ada Data</option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="form-group after-add-more col-md-12">
                                    <label for="">Waktu Istirahat</label>
                                    <select name="wb" id="datawb" class="form-control">
                                    <?php
                                    $queryWb = mysqli_query($link, "SELECT * FROM working_break_shift GROUP BY break_group_id")or die(mysqli_error($link));
                                    if(mysqli_num_rows($queryWb)>0){
                                        while($dataWb = mysqli_fetch_assoc($queryWb)){
                                            $selectWb = ($dataWd['break_id'] == $dataWb['break_group_id'])?"selected":""
                                            ?>
                                            <option <?=$selectWb?> value="<?=$dataWb['break_group_id']?>">SETING <?=$dataWb['break_group_id']?></option>

                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <option value="0">Belum Ada Data</option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>   
                <hr>
                <div class="card-footer text-right">   
                    <input class="btn btn-success" type="submit" name="editWd" value="SUBMIT">
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
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });

      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });
</script>
<script>
    $(document).ready(function(){
        function getWh(){
            var wh = $('#datawh').val();
            
            $('.loadWh').load("ajax/wh.php?wh="+wh);
        }
        function getWb(){
            
            var wb = $('#datawb').val();
            $('.loadWb').load("ajax/wb.php?wb="+wb);
        }
        getWh();
        getWb()
        $('#datawh').click(function(){
            getWh();
        })
        $('#datawb').click(function(){
            getWb();
        })
        
    })
</script>
<?php
    //javascript
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
