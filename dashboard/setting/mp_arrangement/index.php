<?php
$_SESSION['tab'] = 'pos';
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    // mysqli_query($link, "DELETE FROM org")or die(mysqli_error($link));
    $halaman = "Organization Settings";
    include_once("../../header.php");
    require_once('../organization/card.php');
    // require_once('collapse.php');
    require_once('modal.php');
    ?>
    
    <div class="row">
        <h5 class="card-title pull-left col-md-6" id="mainpage"><i class="fas fa-hard-hat "></i> Department</h5>
        <div class="col-md-6 text-right">
            <div class="dropleft">
                <button class="btn btn-sm btn-outline-default btn-icon btn-round text-default" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Menu</div>
                    <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                    <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Download Format</a>
                    <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Add</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $q_department = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'dept' ")or die(mysqli_error($link));
        if(mysqli_num_rows($q_department) > 0){
            $i = 1;
            
            while($data_dept = mysqli_fetch_assoc($q_department)){
                $dataActive = ($i == 1)?"data-active":"";
                $dataColor = ($i == 1)?"bg-warning":"";
                $i++
            ?>
            <div class="col-lg-4 col-md-4 col-sm-12 data_arrangement ">
                <div class="card card-stats bg-transparent shadow-none <?=$dataColor?> arrangement border-left border-right" data-id="<?=$data_dept['nama_org']?>" style="max-width: 540px;" id="card<?=$data_dept['id']?>">
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-3 col-md-4 mt-0 pt-0">
                                <div class="icon-big text-center icon-warning ">
                                    <span class="fa-stack " >
                                        <i class="fas fa-car-side fa-stack-1x fa-inverse mt-1 mb-0 text-info"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8 col-9 ">
                                <div class="border-left pl-3 my-0 ml-0">
                                    <h5 class="card-title py-0 my-0 text-uppercase"><?=$data_dept['nama_org']?></h5>
                                    <p class="card-text py-0 my-0 badge badge-sm badge-pill badge-info">department</p>
                                    <!-- <p class="card-text">line 1</p> -->
                                </div>
                            </div>
                            
                            <a href="?model=<?=$data_dept['id']?>"  class="mb-0 stretched-link card-category text-right text-white mb-3 view_data <?=$dataActive?>"  data-id="<?=$data_dept['nama_org']?>" id="<?=$data_dept['id']?>"></a>
                        </div>
                        
                    </div>
                </div>
            </div>
           
            <?php
            }
        }else{
            ?>
            <div class="col-md-12 col-sm-12 datamodel " >
                <div class="card card-stats shadow-none model" id="card" style="background-color:#EBEBE7">
                    <div class="card-body" id="2">
                        <div class="row">
                            <div class="col-1 col-md-1 mt-0 pt-0">
                                <div class="icon-big text-center ">
                                    <span class="fa-stack " >
                                        <i class="fas fa-info-circle  fa-stack-1x fa-inverse mt-1 text-info"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-11 ">
                                <div class="border-left border-info pl-3 my-0 ml-0 text-info">
                                    <h5 class="card-title py-0 my-0">N/A</h5>
                                    <p class="card-text">data belum ada</p>
                                </div>
                            </div>
                            

                        </div>
                        
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        
        
    </div>
    <form method="POST">
        <div class="row">
            <div class="col-md-12" >
                <div class="card bg-transparent" >
                    <div class="card-body bg-transparent">
                    
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3 col-sm-12 " >
                            <div class="">

                                <h5 class="text-uppercase " id="department">Section</h5>
                                <div class="list_section">
                                    <!-- daftar section di sini  -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12 border-left">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-uppercase" id="dept-title">Sumary Report</h5>
                                </div>
                                
                                <div class="col-md-6 text-right">
                                    
                                    <span class="dropdown dropleft">
                                        <button class="btn btn-sm btn-primary btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-header">Menu</div>
                                            <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                                            <a class="dropdown-item" href="proses/export.php?export=organization">Simulasi Data</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tampil-data "></div>

                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
                <hr>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
    <?php    
    include_once("../../footer.php");
    //javascript
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            
           
            $(".arrangement").hover(function(){
                $(this).css("background-color", "#EBEBE7");
                $(this).removeClass("bg-transparent");
            }, 
            function(){
                $(this).css("background-color", "transparent");
            });

            
        });
        </script>
        
            <script>
                $(document).ready(function(){
                    data_active()
                    $('.view_data').on('click' , function(e){
                        e.preventDefault();
                        var id = $(this).attr('id');
                        $('.arrangement').removeClass("bg-warning");
                        $('.view_data').removeClass("data-active");
                        $('#card'+id).addClass('bg-warning');
                        $('#'+id).addClass('data-active');
                        data_active()
                        
                    });
                    function data_active(){
                        if($(".data-active")[0]){
                            var id = $('.data-active').attr('id');
                            $.ajax({
                                url:"ajax/section.php",
                                method:"GET",
                                data:{id:id},
                                success:function(data){
                                    $('.list_section').fadeOut('fast', function(){
                                        $(this).html(data).fadeIn('fast');
                                        pilihSection()
                                        
                                    });
                                    // $('#data-monitoring').html(data)
                                }
                            })
                            // $('.list_section').load("ajax/section.php?id="+id);
                            
                        }
                    }
                    
                    function pilihSection(){
                        if($(".section-active")[0]){
                            var name = $('.section-active').attr('data-name');
                            $('#dept-title').text("Section "+name);
                            // console.log(name)
                            var id = $('.section-active').attr('id');
                            var dept = $('.data-active').attr('id')
                            $.ajax({
                                url:"ajax/index.php",
                                method:"GET",
                                data:{section:id},
                                success:function(data){
                                    $('.tampil-data').html(data).fadeIn('fast');
                                    // $('#data-monitoring').html(data)
                                }
                            })
                            // $('.tampil-data').load("ajax/index.php?section="+id+"&dept="+dept);
                        }
                    }
                    
                    $(document).on('click', '.datasect',function(){
                        var id = $(this).attr('data-id');
                        // console.log(id)
                        var dept = $('.data-active').attr('id')
                        $('.group').addClass('d-none')
                        $('.group'+id).removeClass('d-none')
                        $('.datagroup').removeClass('active')
                        $('.datagroup').removeClass('group-active')
                        
                        $('.datasect').removeClass('section-active')
                        $(this).addClass('section-active')
                        pilihSection()
                    })
                    $(document).on('click','.datagroup', function(){
                        $('.datagroup').removeClass('group-active')
                        $(this).addClass('group-active')
                        get_group()
                    })
                    function get_group(){
                        
                        if($('.group-active')[0]){
                            var name = $('.group-active').attr('data-name');
                            $('#dept-title').text("Group "+name);
                            var id = $('.group-active').attr('id');
                            $.ajax({
                                url:"ajax/index.php",
                                method:"GET",
                                data:{group:id},
                                success:function(data){
                                    $('.tampil-data').html(data).fadeIn('fast');
                                    // $('#data-monitoring').html(data)
                                }
                            })
                        }
                    }
                })
            </script>
        <!-- <script>
            $(document).ready(function(){
                
                if($(".data-active")[0]){
                    var id = $('.data-active').attr('id');
                    var title = $('.data-active').attr('data-id');
                    $('.data-active').addClass('bg-warning');
                    // console.log(id);
                    $('#dept-title').text(title);
                    $('.list_section').load("ajax/section.php?id="+id);
                }
                
            })
        </script> -->
        
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

