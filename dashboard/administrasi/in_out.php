<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "In-Out Monitoring";
if(isset($_SESSION['user'])){

    include_once("../header.php");
    $today = date('Y-m-d');
?>

<div class="row">
    
    <div class="col-md-4">
        <h5 class=""></h5>
    </div>
    <div class="col-md-8 ">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <label class="col-md-4 col-form-label text-right">Based On :</label>
                    <div class="col-md-8">
                        <div class="form-group-sm pr-1">
                            <select name="show_dept" id="show_dept" class="form-control">
                                <option value="">Departmen Administratif</option>
                                <?php
                                $q_deptAccount = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($q_deptAccount) > 0){
                                    while($data = mysqli_fetch_assoc($q_deptAccount)){
                                        ?>
                                        <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Date :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <input id="date_" type="text" value="<?=DBtoForm($today)?>" data-date-format="DD/MM/YYYY" class="form-control datepicker">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Shift :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                                <?php
                                $q_shift = mysqli_query($link, "SELECT * FROM shift ")or die(mysqli_error($link));
                                if(mysqli_num_rows($q_shift) > 0){
                                    while($data = mysqli_fetch_assoc($q_shift)){
                                        ?>
                                        <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 text-right">
                <div class="row ">
                    <!-- <div class="nav-link active btn-magnify mt-0"><i class="fas fa-th-list"></i></div> -->
                    <div class="nav-link text-danger btn-magnify mt-0"><i class="fas fa-th-large"></i></div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
             <?php
                $q_group = mysqli_query($link,"SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($link));
                $jml_data = mysqli_num_rows($q_group);
                ?>
                <h5 id="data_total" class="d-none" data-id="<?=$jml_data?>">0</h5>

            </div>
        </div>
       
        <div id="data-monitor" class="row"></div>

    </div>
    
</div>
<!-- modal -->
<!-- Modal -->
<div class="row">
    <div class="modal fade" id="modal_cico"  data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
    
        <div class="modal-content">
        
            <div class="modal-body data_kary">
            </div>
        
        </div>
    
        
      </div>
    </div>

</div>
<!-- Modal -->
<!-- modal -->


<?php
?>

<?php
    include_once("../footer.php");
    ?>
    <script>
        $(document).ready(function(){
            // 
            function load_monitor(){
                var date = $('#date_').val()
                var dept = $('#show_dept').val()
                var shift = $('#shift').val()
                var get_group = $('#data_total').text();
                console.log(get_group)
                $.ajax({
                    url: 'chart_view/index.php',
                    method: 'GET',
                    data: {index:get_group,monitor_date:date,dept_account:dept,shift:shift},
                    success:function(data){
                        $('#data-monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                    }
                })
            }
            load_monitor()
            $('#date_').on('blur', function(){
                load_monitor()
            })
            $('#show_dept').on('change', function(){
                load_monitor()
            })
            $('#shift').on('change', function(){
                load_monitor()
                
            })
            
            var autoRefresh;
            // window.onload = resetTimer;
            window.onmousemove = resetTimeInterval;
            window.onmousedown = resetTimeInterval; // catches touchscreen presses
            window.onclick = resetTimeInterval;     // catches touchpad clicks
            window.onscroll = resetTimeInterval;    // catches scrolling with arrow keys
            window.onkeypress = resetTimeInterval;
    
            var link = document.getElementsByClassName('data_load');
            var load = 0;
            var int = 0;
            var total = Number($('#data_total').attr('data-id'));

            function resetTimeInterval(){
                clearInterval(autoRefresh);

                autoRefresh = setInterval(function ()
                    {
                        
                        int++;
                        if(int == 10){
                            int = 0;
                            load++;
                            $('#data_total').text(load)
                            load_monitor()
                            // $('#modal_lock').modal('show');
                        }
                        if(load == total){
                            load = 0;
                        }
                    }, 1000 // refresh every 10000 milliseconds
                );  

                
            }
            
            $(document).on('click', 'td.data-karyawan', function(a){
                a.preventDefault();
                loadModal()
            })
            function loadModal(){
                $('#modal_cico').modal('show');
                var data = $('td.data-karyawan').attr('id');
                // console.log(data)
                    $.ajax({
                        url: 'chart_view/preview.php',
                        method: 'GET',
                        data: {data:data},
                        success:function(data){
                            $('.data_kary').html(data);
                        }
                    
                });
            }
            

        })
    </script>
    <?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
  

?>