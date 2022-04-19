<?php
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/Calendar-Heatmap-Plugin-jQuery/dist/jquery.CalendarHeatmap.min.css">
<script src="<?=base_url()?>/assets/Calendar-Heatmap-Plugin-jQuery/dist/jquery.CalendarHeatmap.js"></script>

<div class="row my-4">
    <div class="col-md-12">
        <div id="heatmap-5"></div>
    </div>
</div>
<script>
    function randomDate(start, end) {
        var date = new Date(+start + Math.random() * (end - start));
        var out = String(date.getFullYear())+ "-";
        if (date.getMonth() + 1 < 10)
            out += "0" + String(date.getMonth() + 1);
        else
            out += String(date.getMonth() + 1);
        out += "-";
        if (date.getDate() < 10)
            out += "0" + String(date.getDate());
        else
            out += String(date.getDate());
        return out;
    }

    var events = ( Math.random() * 200 ).toFixed(0);
    var data = [];
    for (var i = 0; i < events; i++ ) {
        var current = new Date();
        var rndStart = new Date( current.getFullYear() - 1, current.getMonth() - 5, current.getDate() );
        data.push({
            count: 100,
            date: randomDate( rndStart.valueOf(), current.valueOf() )
        });
    }
    console.log(data);
    // $("#heatmap-5").CalendarHeatmap(data, {
    //     title: "Default Layout"
    // });

    // $("#heatmap-2").CalendarHeatmap(data, {
    //     title: "Gradient \"red\", end one month from current",
    //     lastMonth: new Date().getMonth() + 1,
    //     coloring: "red",
    //     legend: {
    //         minLabel: "Fewer"
    //     },
    //     labels: {
    //         custom: {
    //             monthLabels: "MMM"
    //         }
    //     }
    // });

    // $("#heatmap-3").CalendarHeatmap(data, {
    //     title: "Gradient \"electric\", labels days and custom month labels, end one year from current, week starts on Sunday",
    //     months: 5,
    //     lastYear: new Date().getFullYear() - 1,
    //     coloring: "electric",
    //     legend: {
    //         align: "left",
    //         minLabel: "Fewer"
    //     },
    //     weekStartDay: 0,
    //     labels: {
    //         days: true,
    //         custom: {
    //             monthLabels: "MMM 'YY"
    //         }
    //     },
    //     tooltips:{
    //         show: true
    //     }
    // });

    // $("#heatmap-4").CalendarHeatmap( data, {
    //     title: "Tile shape \"Circle\" and using Moment to localize Weekday and Month Labels",
    //     tiles: {
    //         shape: "circle"
    //     },
    //     labels: {
    //         months: true,
    //         days: true,
    //         custom: {
    //             weekDayLabels: function( weekday ) {
    //                 moment.locale('ar');
    //                 return moment.weekdays(true, weekday);
    //             },
    //             monthLabels: function( year, month ) {
    //                 moment.locale('ar');
    //                 return moment.months(true, month) 
    //                     + " '"
    //                     + moment().year(year).format("YY");
    //             }
    //         }
    //     }
    // });

    $("#heatmap-5").CalendarHeatmap( data, {
        title: "Heatmap",
        labels: {
            days: true,
            custom: {
                weekDayLabels: "dd"
            }
        }
    });

    // $("#heatmap-5-random").on("click", function(){

    //     var events = ( Math.random() * 200 ).toFixed(0);
    //     var data = [];
    //     for (var i = 0; i < events; i++ ) {
    //         var current = new Date();
    //         var rndStart = new Date( current.getFullYear() - 1, current.getMonth() - 5, current.getDate() );
    //         data.push({
    //             count: parseInt( ( Math.random() * 200 ).toFixed(0) ),
    //             date: randomDate( rndStart.valueOf(), current.valueOf() )
    //         });
    //     }

    //     $("#heatmap-5").CalendarHeatmap( 'updateDates', data );
    // });

    // $("#heatmap-5-empty").on("click", function(){
    //     $("#heatmap-5").CalendarHeatmap( 'updateDates', [] );
    // });

    // $("#heatmap-5-append").on("click", function(){
    //     var events = ( Math.random() * 10 ).toFixed(0);
    //     var data = [];
    //     for (var i = 0; i < events; i++ ) {
    //         var current = new Date();
    //         var rndStart = new Date( current.getFullYear() - 1, current.getMonth() - 5, current.getDate() );
    //         data.push({
    //             count: parseInt( ( Math.random() * 200 ).toFixed(0) ),
    //             date: randomDate( rndStart.valueOf(), current.valueOf() )
    //         });
    //     }
    //     $("#heatmap-5").CalendarHeatmap( 'appendDates', data );
    // });

    // $("#heatmap-5-wkday").on("click", function(){
    //     var labels = $("#heatmap-5").CalendarHeatmap( 'getOptions' ).labels;
    //     $("#heatmap-5").CalendarHeatmap( 'updateOptions', {
    //         labels: {
    //             days: (labels.days === true)? false : true
    //         }
    //     } );
    // });

    // $("#heatmap-5-coloring").on("change", function(){
    //     $("#heatmap-5").CalendarHeatmap( 'updateOptions', {
    //         coloring: $(this).val(),
    //         legend: {
    //             divider: " - "
    //         }
    //     } );
    // });

</script>