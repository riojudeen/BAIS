<?php


?>
<button class="btn btn-lock d-none" data-toggle="modal" data-id="0" data-target="#myModal10">
    Lock
</button>
<script>
    //  $('.btn-lock').click()
    var data_lock = $('.btn-lock').attr('data-id')
    // var link = document.getElementsByClassName('data_load');
    var load = 0;
    var approval_num = setInterval(function ()
        { 
            <?php
            $day_today = date('Y-m-d');
            $year = date('Y');
            $date_lock_start = date('Y-m-t', strtotime("$year"."-"."11-01"));
            $date_lock_end = date('Y-m-t', strtotime("$year"."-"."12-01"));
            // $queryLock_s = mysqli_query($link, "SELECT * FROM system_lock WHERE `type` = 'sm' ")or die(mysqli_error($link));
            // $queryLock_at = mysqli_query($link, "SELECT * FROM system_lock WHERE `type` = 'at' ")or die(mysqli_error($link));
            // $queryLock_ot = mysqli_query($link, "SELECT * FROM system_lock WHERE `type` = 'ot' ")or die(mysqli_error($link));
            $queryLock = mysqli_query($link, "SELECT * FROM system_lock WHERE `status` = '1' ")or die(mysqli_error($link));
            if(mysqli_num_rows($queryLock) > 0){
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
            }
            ?>
        }, 1000 // refresh every 10000 milliseconds
    ); 
</script>