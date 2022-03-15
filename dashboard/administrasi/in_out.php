<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "In-Out Monitoring";
if(!isset($_SESSION['user'])){
    $level = 10;
    $npkUser = 0;
}

    include_once("../header.php");
    $today = date('Y-m-d');
?>

<div class="row">
    
    <div class="col-md-1">
        <h5 class=""></h5>
    </div>
    <div class="col-md-11 ">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <label class="col-md-5 col-form-label text-right">Based On :</label>
                    <div class="col-md-7">
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
            <div class="col-md-1  pl-1">
                <div class="row text-right">
                    <span class="  active btn btn-primary  btn-sm mt-1 btn-magnify mt-0 search"><i class="fas fa-search-plus"></i></span>
                    <span class="  active btn btn-primary  btn-sm mt-1 btn-magnify mt-0 "><i class="fas fa-tasks"></i></span>
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
    
        <div class="modal-content data_kary">
        
            
        
        </div>
    
        
      </div>
    </div>

</div>
<div class="row">
    <div class="modal fade" id="modal_search"  data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered ">
    
        <div class="modal-content " style="border-radius:100px">
            <div class="modal-body  p-1 m-1 ">
                <div class="row">
                    <div class="input-group no-border mx-4  mt-2">
                        <input type="text" name="cari" id="pencarian" class="form-control cari" placeholder="Cari NPK atau nama" style="border-radius:100px" >
                        <div class="input-group-append " >
                            <div class="input-group-text p-0 bg-transparent">
                                <div class="btn btn-primary btn-sm btn-icon btn-round btn-link m-0 btn-cari"><i class="nc-icon nc-zoom-split"></i></div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- <div class="input-group">
                        <div class="form-group col-md-12 m-0 p-0">
                            <input class="form-control m-1" type="text" >
                        </div>
                        <button class="input-append btn btn-sm">tes</button>
                    </div> -->
                </div>
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
            
            $(document).on('click', '.search', function(a){
                a.preventDefault();
                modalSearch()
            })
            $(document).on('click', '.btn-cari', function(a){
                a.preventDefault();
                var data = $('#pencarian').val()
                $('#modal_search').modal('hide');
                loadModal(data)
            })
            function modalSearch(){
                $('#modal_search').modal('show');
            }
            $(document).on('click', 'td.data-karyawan', function(a){
                a.preventDefault();
                var data = $(this).attr('id');
                loadModal(data)
            })
            function loadModal(data){
                $('#modal_cico').modal('show');
                var date = $('#date_').val()
                // console.log(data)
                    $.ajax({
                        url: 'chart_view/preview.php',
                        method: 'GET',
                        data: {data:data,date:date},
                        success:function(data){
                            $('.data_kary').html(data);
                        }
                    
                });
            }
            

        })
    </script>
    <?php
    include_once("../endbody.php"); 
?>