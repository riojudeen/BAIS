<?php
$part_lock = $part_lock;
$redirect_lock = $redirect_lock;

?>
<div class="modal fade modal-primary" id="myModal10" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content " style="border:5px solid #F3614D">
        <div class="modal-header justify-content-center">
        <div class="modal-profile mx-auto border-danger" style="margin-top:-500">
            <i class="nc-icon nc-time-alarm text-danger"></i>
        </div>
        </div>
        <div class="modal-body text-center">
        <h5 class="title text-danger text-uppercase">Sesi Pengajuan Berakhir</h5>
        <label for="" class="card-label"> anda akan segera dialihkan .. 
            <label for=""  id="waktu">10</label>
        </label>
        </div>
        <div class="modal-footer">
        
        </div>
    </div>
    </div>
</div>
<button class="btn btn-lock d-none" data-toggle="modal" data-id="0" data-target="#myModal10">
    Lock
</button>
<?php
    $day_today = date('Y-m-d');
    $year = date('Y');
    $date_lock_start = date('Y-m-t', strtotime("$year"."-"."11-01"));
    $date_lock_end = date('Y-m-t', strtotime("$year"."-"."12-01"));
    
    $queryLock = mysqli_query($link, "SELECT * FROM system_lock WHERE `status` = '1' AND `type` = '$part_lock' ")or die(mysqli_error($link));
    if(mysqli_num_rows($queryLock) > 0){
        ?>
        <script>
            $(document).ready(function(){
                window.setInterval(function () {
                    var sisawaktu = $("#waktu").html();
                    sisawaktu = eval(sisawaktu);
                    <?php
                        if($part_lock == 'at'){
                            $id = "abs";
                        }else{
                            $id = "ovrtime";
                        }
                    ?>
                    if (sisawaktu == 0) {
                        $('#<?=$id?>').click();
                        location.href = "<?=$redirect_lock?>";
                    } else {
                        $("#waktu").html(sisawaktu - 1);
                    }
                }, 1000);
            });
        </script>
        <script>
            //  $('.btn-lock').click()
            var data_lock = $('.btn-lock').attr('data-id')
            // var link = document.getElementsByClassName('data_load');
            var load = 0;
            var approval_num = setInterval(function (){ 
            <?php
            $i = 1;
            $l_start = array();
            $l_index = array();
            $l_end = array();
                
            while($data = mysqli_fetch_assoc($queryLock)){
                // close book
                if($data['periodic'] == 'y'){

                    if(strtotime($day_today) >= strtotime($date_lock_start)  &&  strtotime($day_today) <= strtotime($date_lock_end)){
                        $pecah_start = explode(':',$data['off_start']);
                        $pecah_end = explode(':',$data['off_end']);
                        // cari menit
                        $menitStart = $pecah_start[0]*60+$pecah_start[1];
                        $menitEnd = $pecah_end[0]*60+$pecah_end[1];
                        array_push($l_start, $menitStart);
                        array_push($l_end, $menitEnd);
                        array_push($l_index, $i);
                        ?>
                        // menit start lock
                        const d_start<?=$i?> = <?=$menitStart?>;
                        const d_end<?=$i?> = <?=$menitEnd?>;
                        <?php
                    }
                }else{
                    $pecah_start = explode(':',$data['off_start']);
                    $pecah_end = explode(':',$data['off_end']);
                    if(strtotime($data['off_start']) <= strtotime($data['off_end'])){
                        $day_after = date('Y-m-d');
                        $menitStart = $pecah_start[0]*60+$pecah_start[1];
                        $menitEnd = $pecah_end[0]*60+$pecah_end[1];
                        
                    }else{
                        $day_after = date('Y-m-d', strtotime("+1 days", strtotime($day_today)));
                        $menitStart = $pecah_start[0]*60+$pecah_start[1];
                        $menitEnd = (24*60)+($pecah_end[0]*60+$pecah_end[1]);
                    }
                    array_push($l_start, $menitStart);
                    array_push($l_end, $menitEnd);
                    array_push($l_index, $i);
                    ?>
                    const d_start<?=$i?> = <?=$menitStart?>;
                    const d_end<?=$i?> = <?=$menitEnd?>;
                    <?php
                }
                
                $i++;
            }
            // print_r($l_start);
            // print_r($l_end);
            // conditional untuk lock system
            if(count($l_end)>0 && count($l_start)>0){
                $i = 1;
                $str_if = '';
                foreach($l_index AS $i){
                    $str_if .= " (d_start".$i." <= now && now <= d_end".$i." ) ||";
                }
                
                $str_if = substr($str_if, 0, -2);
                ?>
                const date = new Date(); 
                const now = date.getHours() * 60 + date.getMinutes();
                // console.log(now);
                // console.log(d_start2);
                if((<?=$str_if?>) ){
                    load++;
                    if(data_lock == 0){
                        $('.btn-lock').click()
                        data_lock = 1
                    }
                    $('.btn-lock').prop('data-id', '1');
                    $('.btn-lock').text('1');
                    // console.log(data_lock)
                    // console.log("true")
                }else{
                    if(data_lock == 1){
                        $('.btn-lock').click()
                        data_lock = 0
                    }
                    // $('.btn-lock').click()
                    $('.btn-lock').prop('data-id', '0');
                    $('.btn-lock').text('0');
                    load = 0;
                    // console.log(data_lock)
                    // console.log("false")
                }
            <?php
            }
            ?>
        }, 1000 // refresh every 10000 milliseconds
    ); 
</script>
<?php
}
?>