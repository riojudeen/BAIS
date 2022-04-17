<?php
?>

 <div class="row rounded flex-row flex-nowrap overflow-auto img_holder" id="b">
    <div class="col-md-12">
        <div class="owl-carousel">
            <!-- <div class="col-lg-4 col-md-4 col-sm-12"> -->
                <div class="card card-stats bg-warning">
                    <div class="card-body "id="4">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-white">
                                    <span class="fa-stack" >
                                        <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                       
                                        <i class="fas fa-sitemap fa-stack-1x fa-inverse mt-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-white ">Functional<p>
                                    <p class="card-category text-right text-white mb-3">Structure</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?=base_url()?>/dashboard/setting/organization/" class="stretched-link card-category text-right text-white mb-3"></a>
                    </div>
                </div>
            <!-- </div>
            <div class="col-lg-4 col-md-4 col-sm-12"> -->
                <div class="card card-stats bg-warning">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-white">
                                    <span class="fa-stack" >
                                        <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i>
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-white ">Inline<p>
                                    <p class="card-category text-right text-white mb-3">prod manpower</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?=base_url()?>/dashboard/setting/lineup/" class="stretched-link card-category text-right text-white mb-3"></a>
                    </div>
                </div>
                
            <!-- </div>
            <div class="col-lg-4 col-md-4 col-sm-12"> -->
                <div class="card card-stats bg-warning">
                    <div class="card-body " id="4">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-white">
                                    <span class="fa-stack" >
                                        <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-white ">Man Power<p>
                                    <p class="card-category text-right text-white mb-3">arrangement</p>
                                </div>
                            </div>
                        </div>
                        <a href="<?=base_url()?>/dashboard/setting/mp_arrangement/" class="stretched-link card-category text-right text-white mb-3"></a>
                    </div>
                </div>
            <!-- </div> -->

        </div>
    </div>
    
</div>

<!-- <script>
    var scroller = {};
    scroller.e = document.getElementById("b");

    if (scroller.e.addEventListener) {
        scroller.e.addEventListener("mousewheel", MouseWheelHandler, false);
        scroller.e.addEventListener("DOMMouseScroll", MouseWheelHandler, false);
        scroller.e.addEventListener("mousemove", MouseWheelHandler, false);
    } else scroller.e.attachEvent("onmousewheel", MouseWheelHandler);

    function MouseWheelHandler(e) {

        // cross-browser wheel delta
        var e = window.event || e;
        var delta = - 30 * (Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail))));

        var pst = $('#b').scrollLeft() + delta;

        if (pst < 0) {
            pst = 0;
        } else if (pst > $('.img_holder').width()) {
            pst = $('.img_holder').width();
        }

        $('#b').scrollLeft(pst);

        return false;
    }
</script> -->
<script>
    $(document).ready(function(){
    var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:3,
            loop:true,
            margin:30,
            autoplay:false,
            autoplayTimeout:3000,
            autoplayHoverPause:true
        });
        owl.on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY>0) {
                owl.trigger('next.owl');
            } else {
                owl.trigger('prev.owl');
            }
            e.preventDefault();
        });
    });
</script>