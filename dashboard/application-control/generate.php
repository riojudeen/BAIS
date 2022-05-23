<?php
//////////////////////////////////////////////////////////////////////
include("../../config/config.php");
if(isset($_SESSION['user']) && $_POST['data']){
   
    $today = date('Y-m-d');
    $minDate = date('Y-m-d', strtotime("-29 days", strtotime($today)));
    $pecah_min = explode("-",$minDate);
    $bln_min = $pecah_min['1']-1;
    $tgl_min = $pecah_min['2'];
    $minDate = $pecah_min['0'].",".$bln_min.",".$tgl_min;
    // echo $minDate;
    $pecah = explode("-",$today);
    $bln = $pecah['1']-1;
    $tgl = $pecah['2'];
    $maxDate = $pecah['0'].",".$bln.",".$tgl;
    // echo $maxDate;

    $q_userInteraction = "SELECT COUNT(user) AS val , waktu FROM user_interaction GROUP BY waktu";
    $sql = mysqli_query($link, $q_userInteraction)or die(mysqli_error($link));
    if(mysqli_num_rows($sql)>0){
        $total = mysqli_num_rows($sql);
        $index = 1;
        $key = array();
        $val = array();
        $data_array = array();
        while($data = mysqli_fetch_assoc($sql)){
            $timestamp = strtotime($data['waktu']);
            $val = $data['val'];
            $data_array[$timestamp] = (int)$val;
            // array_push($data_array, $timestamp  => $val);
            // echo "\"".$timestamp."\" : ".$data['val'];
            
        }
    }
    $fp = fopen('datas.json', 'w');
    fwrite($fp, json_encode($data_array));
    // echo json_encode($data_array);
}
?>


<div style=" overflow:auto ; max-height: 150px; overflow-y: hidden;"  class="text-right" id="cal-heatmap"></div>
<div id="onClick-placeholder"></div>
<script type="text/javascript">
    // console.log(parser(datas))
	var cal = new CalHeatMap();
	cal.init({

        data: "datas.json",

        itemName: ["hit", "hits"],
        itemSelector: "#cal-heatmap",
        range: 30,
        cellSize: 10,
        domain: "day",
        domainGutter: 0,
        // tooltip: true,

        // start: new Date(2022, 0, 1, 4),
        // minDate: new Date(2022, 0, 1, 4),
        // maxDate: new Date(2022, 0, 1, 5),
        start: new Date(<?=$minDate?>),
        // minDate: new Date(2022, 5),
        maxDate: new Date(<?=$maxDate?>),
        legend: [50, 150, 250, 350],
        legendCellSize: 8,
        legendMargin: [10, 0, 0, 10],
        // domainLabelFormat: "%d-%m-%Y",   
        // afterLoadData: parser,

        nextSelector: "#minDate-next",
	    previousSelector: "#minDate-previous",
        onMinDomainReached: function(hit) {
            if (hit) {
                $("#onMinDomainReached-placeholder").append(
                    "<li>Lower limit domain reached, will now disable the <strong>PREVIOUS</strong> button</li>"
                );
                $("#onMinDomainReached-previous").attr("disabled", "disabled");
            } else {
                $("#onMinDomainReached-placeholder").append(
                    "<li>Re-enabling <strong>PREVIOUS</strong> button</li>"
                );
                $("#onMinDomainReached-previous").attr("disabled", false);
            }
        },
        onMaxDomainReached: function(hit) {
            if (hit) {
                $("#onMinDomainReached-placeholder").append(
                    "<li>Upper limit domain reached, will now disable the <strong>NEXT</strong> button</li>"
                );
                $("#onMinDomainReached-next").attr("disabled", "disabled");
            } else {
                $("#onMinDomainReached-placeholder").append(
                    "<li>Re-enabling <strong>NEXT</strong> button</li>"
                );
                $("#onMinDomainReached-next").attr("disabled", false);
            }
        },
        // onClick: function(date, nb) {
		// $("#onClick-placeholder").html("You just clicked <br/>on <b>" +
        //         date + "</b> <br/>with <b>" +
        //         (nb === null ? "unknown" : nb) + "</b> items"
        //     );
        // }
    });
    
</script>