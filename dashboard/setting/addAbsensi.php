<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Add Master Leave & Permition";
    include_once("../header.php");
?>
<!-- halaman utama -->

<div class="row ">

	<div class="col-md-12 ">
       
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Add Master Data</h5>
                <a href="master.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <hr>
            <form action="proses/prosesMaster.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" name="master" class="form-control" value="<?=$_GET['t']?>">
                    <div class="control-group after-add-more data-add-1" data-id="1">
                        <h5 class="text-uppercase">Data 1</h5>
                        <label>Kode Ijin</label>
                        <input type="text" name="code[]" class="form-control" placeholder="maximum 5 karakter (ex. C1 etc...)" required >
                        <label>Keterangan Ijin dan Pemberitahuan</label>
                        <input type="text" name="ijin[]" class="form-control" placeholder="keterangan" required >
                        <label>Type Ijin dan Pemberitahuan</label>
                        <select name="type[]"  class="form-control">
                            <option value="SUPEM">Surat Pemberitahuan</option>
                            <option value="SUKET">Surat Keterangan</option>
                            <option value="REMARK">Remark</option>
                        </select>
                    </div>
                    <br>
                </div> 
                <hr>
                <div class="card-footer">   
                     <button class="btn btn-info add-more" data-id="1">
                        <i class="nc-icon nc-simple-add"></i> Add
                    </button>
                    <button class="btn btn-success pull-right" type="submit" name="addMaster">SUBMIT</button>
                </div>
                <br/>
                
            </form>
        </div>
        
	</div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../footer.php");
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
          html += '<label>Kode Ijin</label>';
          html += '<input type="text" name="code[]" class="form-control" placeholder="maximum 5 karakter (ex. C1 etc...)" required >';
          html += '<label>Keterangan Ijin dan Pemberitahuan</label>';
          html += '<input type="text" name="ijin[]" class="form-control" placeholder="keterangan" required >';
          html += '<label>Type Ijin dan Pemberitahuan</label>';
          html += '<select name="type[]"  class="form-control">';
          html += '<option value="SUPEM">Surat Pemberitahuan</option>';
          html += '<option value="SUKET">Surat Keterangan</option>';
          html += '<option value="REMARK">Remark</option>';
          html += '</select>';
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
    //javascript
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
