<?php
?>
<hr>
<script src="<?=base_url()?>/assets/cal-heatmap-master/d3.min.js" charset="utf-8"></script>
<link rel="stylesheet" href="<?=base_url()?>/assets/cal-heatmap-master/cal-heatmap.css" />
<script type="text/javascript" src="<?=base_url()?>/assets/cal-heatmap-master/cal-heatmap.min.js"></script>
<div class="row">
    <!-- <div class="col-md-3 pl-4">
        <div class="mr-2  order-3">
            <div class="input-group bg-transparent">
                <input type="text" name="cari" id="cari" class="form-control bg-transparent datepicker" placeholder="Cari nama atau npk.." value="">
                <div class="input-group-append bg-transparent">
                    <div class="input-group-text bg-transparent">
                        <i class="nc-icon nc-zoom-split"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-md-12">

        <button id="minDate-previous" style="margin-bottom: 10px;margin-left:10px" class="btn btn-sm btn-primary pull-left"><i class="fas fa-angle-left"></i></button>
        <button id="minDate-next" style="margin-bottom: 10px;" class="btn btn-sm btn-primary pull-right "><i class="fas fa-angle-right"></i></button>
    </div>
</div>           

<div class="data">

</div>
<script>
    $(document).ready(function(){
        sendAjax()
        $('#refresh_data').on('click', function(){
            sendAjax()
        })
        function sendAjax(){
            $.ajax({
                method: "POST",
                url : 'generate.php',
                data : {data:"data"},
                success : function(a){
                    $('.data').html(a);
                }
            })
        }
        
    })
</script>
<hr>
