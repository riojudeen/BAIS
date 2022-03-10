<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php");
//redirect ke halaman dashboard index jika sudah ada session

if(isset($_SESSION['user'])){
  $npk_user = $_SESSION['user'];
//tanggal hari ini

$date = date('d/m/Y');
$tgl_ = date('Y-m-d');

//mengambil kode divisi
$s_div = mysqli_query($link, "SELECT karyawan.department AS dept , dept_account.id_dept_account AS id_dept , division.nama_divisi AS divisi , karyawan.id_area AS id_area
FROM karyawan JOIN dept_account ON karyawan.department = dept_account.id_dept_account LEFT JOIN division ON dept_account.id_div = division.id_div WHERE npk = '$npk_user' ") or die(mysqli_error($link));
$div = mysqli_fetch_assoc($s_div);
$id_area = $div['id_area'];


    ?>
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      <h5 class="modal-title text-left" id="exampleModalLongTitle">Record Data Overtime</h5>
  </div>
  <form action="req_lembur.php" method="post">
    <div class="modal-body px-3">

        <fieldset data-step="1">
        
            <div class="d-flex justify-content-between align-items-center text-warning">
            <h6 class="row text-danger px-2"><i class="fa fa-calendar pull-left text-danger my-auto pl-2"></i>Pilih Tanggal</h6>
                <span class="lead text-danger">#1</span>
            </div>
            <hr>
            
            <div class="form-group row">
                <div class="col-sm-12">
                <label>
                  Tanggal Overtime
                </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="nc-icon nc-calendar-60"></i></span>
                    </div>
                    <input name="tgl_ot" type="text" class="form-control datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tgl_)?>" id="ot_date" required >
                  </div>
                </div>
            </div>
        </fieldset>

        <fieldset data-step="2">
            <div class="d-flex justify-content-between align-items-center text-warning">
            <h6 class="row text-danger px-2"><i class="fa fa-calendar pull-left text-danger my-auto pl-2"></i>Jam Kerja & Shift</h6>
                  <span class="lead text-danger">#2</span>
            </div>
            <hr class="px-0 mx-0">
            <div class="form-group row p-0">
              <div class="col-sm-12 py-0">
              </div>
            </div>
            <div id="isi"></div>
        </fieldset>
        <fieldset data-step="3">
            <div id="kode"><p class="text-center text-danger text-uppercase">PASTIKAN SEMUA DATA TELAH DIISI</p></div>
            
        </fieldset>
    </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-step-to="prev">
                Previous
            </button>
            <button type="button" id="next" class="btn btn-success" data-step-to="next">
                Next
            </button>
            <button type="submit" class="btn btn-info">
                SAVE
            </button>
        </div>
    </form>

<script>
    $(document).ready(function(){
      $(function () {
          $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
          });
      });
    })
</script>
<script>
$('.selectpicker').selectpicker();
</script>
<script>

    $(document).ready(function() {
        
        $("#next").click(function(){
        var tgl = $("#ot_date").val();
          	$.ajax({
          		type: 'POST',
              	url: "ajax/get_kode.php",
              	data: {'tgl': tgl},
              	cache: false,
              	success: function(msg){
                  $("#isi").html(msg);
                  
                }
            });

        });
    })

</script>
<script>

    $(document).ready(function() {
      $("#next").click(function(){
      	var data = $("#ot_date").val();
        
        $.ajax({
          type: 'POST',
            url: "ajax/gen_kode.php",
            data: {'code': data},
            cache: false,
            success: function(msg){
              $("#kode").html(msg);
            }
        });
      });
    })

</script>



<?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>