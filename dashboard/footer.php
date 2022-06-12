<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$link_exception = "http://$_SERVER[HTTP_HOST]".base_url()."/dashboard/setting/cico/index.php";
$link_exception2 = "http://$_SERVER[HTTP_HOST]".base_url()."/dashboard/setting/cico/cico1.php";
$time_lock = "http://$_SERVER[HTTP_HOST]".base_url()."/dashboard/time_lock/";

?>

<!-- maintnance  -->
<label for="" class="d-none"  id="waktu_maintenance">5</label>
<div class="modal fade modal-primary" id="myModal_maintenance" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content ">
        <div class="modal-header justify-content-center">
        <div class="modal-profile mx-auto border-danger" style="margin-top:-500">
            <i class="nc-icon nc-time-alarm text-danger"></i>
        </div>
        </div>
        <div class="modal-body text-center">
        <h5 class="title text-danger text-uppercase">Mohon Maaf</h5>
        <label for="" class="card-label text-uppercase"> System Sedang dalam proses maintenance
            
        </label>
        </div>
        <div class="modal-footer">
          <?php
          if($level > 5){
            ?>
          <a href="<?=$time_lock?>" class="btn btn-link">Time Management</a>

            <?php
          }
          ?>
        </div>
    </div>
    </div>
</div>
<button class="btn btn-maintenance d-none" data-toggle="modal" data-id="0" data-target="#myModal_maintenance">
    Lock
</button>
<!-- maintenance -->
<?php
$time_query = "SELECT 
(TIME_TO_SEC(off_start)) AS 'second' , 
    id, system_name, 
    `status`, 
    off_start, 
    `off_end`, 
    `type` , 
    `periodic`  
    FROM system_lock 
WHERE `status` = '1' ";
$queryLock_maintenance = mysqli_query($link, $time_query." AND `type` = 'sm' ")or die(mysqli_error($link));
if(mysqli_num_rows($queryLock_maintenance) > 0 && $actual_link != $time_lock){
  ?>
  <script>
      $(document).ready(function(){
          var data = $('.btn-maintenance').attr('data-id');
          var number = 1
          
          window.setInterval(function () {
              var sisawaktu = $("#waktu_maintenance").html();
              sisawaktu = eval(sisawaktu);
              
              if (sisawaktu == 0 ) {
                  
                  if(data == 0){
                    $('.btn-maintenance').click();
                    $('.btn-maintenance').prop('data-id', "1");
                  }
                  data = 1
              } else {
                  $("#waktu_maintenance").html(sisawaktu - 1);
              }
          }, 1000);
      });
  </script>
  <?php
}
?>
</div>
<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <nav class="footer-nav">
                <ul>
                    <li><a href="mailto:admin.body1@daihatsu.astra.co.id" target="_blank">Admin Body 1</a></li>
                    <li><a href="mailto:support.body2@daihatsu.astra.co.id" target="_blank">Admin Body 2</a></li>
                    <li><a href="mailto:agus.catur@daihatsu.astra.co.id" target="_blank">Admin BQC</a></li>
                </ul>
            </nav>
            <div class="credits ml-auto">
                <span class="copyright">
                    © <script>
                    document.write(new Date().getFullYear())
                    </script>, Admin x DnA Body Division
                </span>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Sidebar Background</li>
        <li class="adjustments-line">
          <div class="switch-trigger background-color">
            <div class="badge-colors text-center">
              <span class="badge filter badge-default btn-sidebar-color" data-color="default"></span>
              <span class="badge filter badge-light btn-sidebar-color" data-color="white"></span>
            </div>
            <div class="clearfix"></div>
          </div>
        </li>
        <li class="header-title"> Sidebar Active Color</li>
        <li class="adjustments-line text-center">
          <a href="javascript:void(0)" class="switch-trigger active-color">
            <span class="badge filter badge-primary btn-sidebar-active" data-color="primary"></span>
            <span class="badge filter badge-info btn-sidebar-active" data-color="info"></span>
            <span class="badge filter badge-success btn-sidebar-active" data-color="success"></span>
            <span class="badge filter badge-warning btn-sidebar-active" data-color="warning"></span>
            <span class="badge filter badge-danger btn-sidebar-active" data-color="danger"></span>
          </a>
        </li>
       
      </ul>
    </div>
  </div>
<!--   Core JS Files   -->
<script src="<?=base_url('assets/js/core/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/core/popper.min.js')?>"></script>
<script src="<?=base_url('assets/js/core/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/moment.min.js')?>"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?=base_url('assets/js/plugins/bootstrap-switch.js')?>"></script>
<!--  Plugin for Sweet Alert -->
<script src="<?=base_url('assets/js/plugins/sweetalert2.min.js')?>"></script>
<!-- Forms Validations Plugin -->
<script src="<?=base_url('assets/js/plugins/jquery.validate.min.js')?>"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?=base_url('assets/js/plugins/jquery.bootstrap-wizard.js')?>"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?=base_url('assets/js/plugins/bootstrap-selectpicker.js')?>"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?=base_url('assets/js/plugins/bootstrap-datetimepicker.js')?>"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?=base_url('assets/js/plugins/jquery.dataTables.min.js')?>"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?=base_url('assets/js/plugins/bootstrap-tagsinput.js')?>"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?=base_url('assets/js/plugins/jasny-bootstrap.min.js')?>"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?=base_url('assets/js/plugins/fullcalendar/fullcalendar.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/fullcalendar/daygrid.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/fullcalendar/timegrid.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/fullcalendar/interaction.min.js')?>"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?=base_url('assets/js/plugins/jquery-jvectormap.js')?>"></script>
<!--  Plugin for the Bootstrap Table -->
<script src="<?=base_url('assets/js/plugins/nouislider.min.js')?>"></script>
<!--  Google Maps Plugin    
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!-- Chart JS -->
<script src="<?=base_url('assets/js/plugins/chartjs.min.js')?>"></script>
<!--  Notifications Plugin    -->
<script src="<?=base_url('assets/js/plugins/bootstrap-notify.js')?>"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?=base_url('assets/js/paper-dashboard.min.js?v=2.1.1')?>" type="text/javascript"></script>
<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="<?=base_url('assets/demo/demo.js')?>"></script>

<script src="<?=base_url('assets/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script src="<?=base_url('assets/datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('assets/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')?>"></script>

<script src="<?=base_url('assets/timepicker/bootstrap-timepicker.js')?>"></script>
<script src="<?=base_url('assets/floatThead/dist/jquery.floatThead.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap-modal-wizard-master/dist/jquery.modal-wizard.js')?>"></script>
<script src="<?=base_url('assets/js/multi-step-modal-wizard/dist/js/MultiStep.js')?>"></script>
<script src="<?=base_url('assets/js/theia-sticky-sidebar-master/dist/ResizeSensor.js')?>"></script>
<script src="<?=base_url('assets/js/theia-sticky-sidebar-master/dist/theia-sticky-sidebar.min.js')?>"></script>
<script src="<?=base_url('assets/js/sticky-master/jquery.sticky.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.pin-gh-pages/jquery.pin.js')?>"></script>
<script src="<?=base_url('assets/js/loading.js')?>"></script>
<script src="<?=base_url('assets/js/selectcustom.js')?>"></script>
<script src="<?=base_url('assets/js/timeku.js')?>"></script>
<script src="<?=base_url('assets/js/approvalsistem.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.idle-master/jquery.idle.js')?>"></script>
<script src="<?=base_url('assets/jquery-table2excel-master/dist/jquery.table2excel.min.js')?>"></script>
<script src="<?=base_url('assets/js/register.js')?>"></script>


<script src="https://cdn.jsdelivr.net/npm/sticksy/dist/sticksy.min.js"></script>
<!--
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();


    demo.initVectorMap();

});
</script>-->

<!-- <script>
  $(document).ready(function(){
    $(".sticker").sticky({topSpacing:70});
    
  });
</script> -->
<?php
$url_style = base_url('dashboard/style.php');
?>
<script>
  $(document).ready(function(){
    function ubah_sidebar_color(sidebarcolor){
      $.ajax({
          url:'<?=$url_style?>',
          method:"POST",
          data:{sidebar_color : sidebarcolor},
          success:function(){
            $('.sdbr').attr('data-color', sidebarcolor);
          }
      })
    }
    function ubah_sidebar_active(activecolor){
      
      $.ajax({
          url:'<?=$url_style?>',
          method:"POST",
          data:{active_color : activecolor},
          success:function(){
            $('.sdbr').attr('data-active-color', activecolor);
          }
      })
    }

    $('.btn-sidebar-color').on('click',function(a){
      a.preventDefault();
      $('.btn-sidebar-color').removeClass('active');
      $(this).addClass('active');
      var color = $(this).attr('data-color');
      ubah_sidebar_color(color)
    })
    $('.btn-sidebar-active').on('click',function(a){
      a.preventDefault();
      $('.btn-sidebar-active').removeClass('active');
      $(this).addClass('active');
      var color = $(this).attr('data-color');
      ubah_sidebar_active(color)
    })
    

  })
</script>
<script>
    var stickyEl = new Sticksy('.sticker', {topSpacing: 70})
    stickyEl.onStateChanged = function (state) {
        if(state === 'fixed') stickyEl.nodeRef.classList.add('widget--sticky')
        else stickyEl.nodeRef.classList.remove('widget--sticky')
    }
</script>
<script>
//untuk date & time picker
    $(document).ready(function() {
      // initialise Datetimepicker and Sliders
      demo.initDateTimePicker();
      if ($('.slider').length != 0) {
        demo.initSliders();
      }
    });
</script>
    

<script>
    //autofocus form di dalam modal edit data mp
    $('#editmp').on('shown.bs.modal', function () {
  $('#npk').trigger('focus')
})
</script>
<script>
/*
$(document).on("click", "#tomboledit", function(){
    let id = $(this).data('npk'); //menangkap id dari yang dikirim dari tombol edit 
    let id = $(this).data('nama');
    let id = $(this).data('nick');
    let id = $(this).data('status');
    let id = $(this).data('jabatan');
    let id = $(this).data('masuk');
    let id = $(this).data('shift');
    let id = $(this).data('post');

    $(".modal-body #npk").val(npk)); //menangkap id dari yang dikirim dari modal edit 
    $(".modal-body #nama").val($(this).data(nama));
    $("#nick").val($(this).data(nick));
    $("#ststus").val($(this).data(status));
    $("#jabatan").val($(this).data(jabatan));
    $("#tgl_masuk").val($(this).data(masuk));
    $("#shift").val($(this).data(shift));
})*/
</script>

<script>
//untuk checkbox
$(document).ready(function(){
    $('#select_all').on('click', function() {
        if(this.checked){
            $('.check').each(function() {
                this.checked = true;
            })
        } else {
            $('.check').each(function() {
                this.checked = false;
            })
        }

    });

    $('.check').on('click', function() {
        if($('.check:checked').length == $('.check').length){
            $('#select_all').prop('checked', true)
        } else {
            $('#select_all').prop('checked', false)
        }
    })
})
$(document).ready(function(){
    $('#dept_all').on('click', function() {
        if(this.checked){
            $('.deptcheck').each(function() {
                this.checked = true;
            })
        } else {
            $('.deptcheck').each(function() {
                this.checked = false;
            })
        }
    });

    $('.deptcheck').on('click', function() {
        if($('.deptcheck:checked').length == $('.deptcheck').length){
            $('#dept_all').prop('checked', true)
        } else {
            $('#dept_all').prop('checked', false)
        }
    })
})
</script>
<script>
//untuk tombol refresh

function reloadpage()
{
location.reload()
}
</script>
<script>
// $(document).ready(function(){
//     $('ul li a').click(function(){
//       $('li a').removeClass("active");
//       $(this).addClass("active");
//     });
//   });
// </script>
<!-- <script>
$(document).ready(function(){
    $('ul li').on('click', 'ul li' , function(a){
        $(this).addClass('active').sibblings().removeClass('active');
    });
});
</script> -->

<script>
$(document).ready(function(){
    var sesi = localStorage.getItem('session');
    $('body').addClass(sesi);

    $('#minimizeSidebar').on('click', function(e){
        e.preventDefault();
        var getsesi = $('body').attr('class');
        if(getsesi == 'sidebar-mini'){
            localStorage.setItem('session', 'sidebar-mini');
            
        }else{
            localStorage.setItem('session', '');
            $('body').removeClass('sidebar-mini');
        };
        
    });
});
</script>

<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
</script>

<!-- script untuk notifikasi hapus -->
<script>
    $(document).ready(function(){
        const notifikasi = $('.info-data').data('infodata');
        const pesan = $('.message').data('infodata');
        if(notifikasi == "Disimpan" || notifikasi=="Dihapus" ){
            Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: ''+pesan+' data Berhasil '+notifikasi,
            })
        }else if(notifikasi == "Gagal Disimpan" || notifikasi=="Gagal Dihapus"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: ''+pesan+' data '+notifikasi,
            })
        }else if(notifikasi == "Kosong"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: ''+pesan+' data Dipilih '+notifikasi+' atau tidak ada',
            })
        }else if(notifikasi == "Request"){
            Swal.fire({
            icon: 'success',
            title: 'Requested',
            text: ''+pesan+' data '+notifikasi+' telah diteruskan',
            })
        }else if(notifikasi == "Return"){
            Swal.fire({
            icon: 'success',
            title: 'Returned',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Reject"){
            Swal.fire({
            icon: 'success',
            title: 'Rejected',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Stop"){
            Swal.fire({
            icon: 'success',
            title: 'Stopped',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Arsipkan"){
            Swal.fire({
            icon: 'success',
            title: 'Archieved',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Approve"){
            Swal.fire({
            icon: 'success',
            title: 'Approved',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Import Gagal" || notifikasi == "Error" ){
            Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: ''+pesan+'',
            })
        }
        
        $('.del').on('click', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var id = $(this).parents("tr").attr("id");
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Data Man Power dengan NPK : " + id + " akan dihapus secara permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = getLink;
                }
            })
        });
    });
</script>
<?php
if($actual_link != $link_exception || $actual_link != $link_exception2 ){
    ?>
    <script>
    var autoLockTimer;
    // window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer; // catches touchscreen presses
    window.onclick = resetTimer;     // catches touchpad clicks
    window.onscroll = resetTimer;    // catches scrolling with arrow keys
    window.onkeypress = resetTimer;

    function lockScreen() {
        <?php
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $_SESSION['link'] = $actual_link;
        $_npk1 = $npkUser;
        $_npk = sha1($npkUser);
        $_SESSION['lock'] = $_npk1;
        $_SESSION['npk_lock'] = $_npk;
        
        ?>
        localStorage.setItem('page', '<?=$actual_link?>');
        window.location.href = ' <?=base_url('auth/lock.php?')?>u=<?=$_SESSION['npk_lock']?>';
    }

    function resetTimer() {
        clearTimeout(autoLockTimer);
        autoLockTimer = setTimeout(lockScreen, 900000);  // time is in milliseconds
    }

</script>
    <?php
}
?>

<script>
    $('.menu').click(function(){
        if(typeof(Storage) !== "undefined") {
            sessionStorage.activemenu = $(this).data('name');
          } else {
            console.log("Sorry, your browser does not support web storage...");
          }
    });
//   console.log(sessionStorage.activemenu);
  $('#'+sessionStorage.activemenu).addClass('active');
</script>
<script>
    $('.clpse').click(function(){
        if(typeof(Storage) !== "undefined") {
            sessionStorage.activeclpse = $(this).data('name');
          } else {
            console.log("Sorry, your browser does not support web storage...");
          }
    });
//   console.log(sessionStorage.activeclpse);
  $('#'+sessionStorage.activeclpse).addClass('active');
</script>
<script>
    $('.clpse').click(function(){
        if(typeof(Storage) !== "undefined") {
            sessionStorage.showclpse = $(this).data('target');
            
          } else {
            console.log("Sorry, your browser does not support web storage...");
          }
    });
//   console.log(sessionStorage.showclpse);
  $('#'+sessionStorage.showclpse).addClass('show');

</script>
<script type="text/javascript">
        function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||  
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
      $('#fullscreen').removeClass("fa-expand");
      $('#fullscreen').addClass("fa-compress");
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
      $('#fullscreen').removeClass("ffa-expand");
      $('#fullscreen').addClass("fa-compress");
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      $('#fullscreen').removeClass("fa-expand");
      $('#fullscreen').addClass("fa-compress");
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    }
  }
}
</script>
<script type="text/javascript">
        function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||  
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {
      document.documentElement.requestFullScreen();
      $('#fullscreen').removeClass("fa-expand");
      $('#fullscreen').addClass("fa-compress");
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
      $('#fullscreen').removeClass("ffa-expand");
      $('#fullscreen').addClass("fa-compress");
    } else if (document.documentElement.webkitRequestFullScreen) {
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      $('#fullscreen').removeClass("fa-expand");
      $('#fullscreen').addClass("fa-compress");
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
      $('#fullscreen').removeClass("fa-compress");
      $('#fullscreen').addClass("fa-expand");
    }
  }
}
</script>
<script>
  $(document).ready(function(){
    $(document).on('click', '.btn', function(){
      $.ajax({
        method : 'POST',
        url : '/BAIS/dashboard/interaction_counter.php',
        data : {interaction : '1'}
      })
    })
    $(document).on('click', 'a', function(){
      $.ajax({
        method : 'POST',
        url : '/BAIS/dashboard/interaction_counter.php',
        data : {interaction : '1'}
      })
    })
  })
</script>
<?php
$i = 1;
$query_notif = "SELECT info, publisher, title, category, stats, date_start, date_end, `image` FROM info 
WHERE (category = 'at' 
  OR category = 'ot' 
  OR category = 'holidays' 
  OR category = 'mtc') AND `stats` = '1' ";
$sqlNotif = mysqli_query($link, $query_notif)or die(mysqli_error($link));
if(mysqli_num_rows($sqlNotif)>0 ){
  while($dataNotif = mysqli_fetch_assoc($sqlNotif)){
    $title = $dataNotif['title'];
    $info = $dataNotif['info'];
    $cat = $dataNotif['category'];
    if($cat == 'mtc' ){
      $show = 1;
      $color = 4;
      $icon = 'fas fa-tools';
    }else if($cat == 'at' ){
      if(isset($alertMe) && $alertMe == 'at' && $level <= 5){
        $show = 1;
      }else{
        $show = 0;
      }
      $icon = 'far fa-calendar-check';
      $color = 1;
    }else if($cat == 'holidays'){
      $show = 1;
      $icon = 'far fa-sticky-note';
      $color = 3;
    }else if($cat == 'ot' ){
      if(isset($alertMe) && $alertMe == 'ot' && $level <= 5){
        $show = 1;
      }else{
        $show = 0;
      }
      $icon = 'far fa-clock';
      $color = 1;
    }
    if(isset($show) && $show == 1){
      ?>
      
      <script>
          showNotification<?=$i?>('top','right')
          function showNotification<?=$i?>(from, align){
          color = 1;
          // 4 danger //untuk notifikasi pengajuan bermasalah
          // 3 warning //untuk reminder pengajuan
          // 1 info //informasi 
          // 2 success
          $.notify({
            icon: '<?=$icon?>',
            message: '<h6><strong><?=$title?></strong></h6>'+'<?=$info?>'

          },{
            type: type[<?=$color?>],
            timer: 5000,
            placement: {
              from: from,
              align: align
            }
          });
        }
      </script>
      <?php
    
      }
    $i++;
  }
}
?>
  