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
        <?php
        $q_department = mysqli_query($link, "SELECT * FROM department")or die(mysqli_error($link));
        if(mysqli_num_rows($q_department) > 0){
            $i = 1;

            while($data_dept = mysqli_fetch_assoc($q_department)){
                $dataActive = ($i++ == 1)?"data-active":"";
            ?>
            <div class="col-lg-4 col-md-4 col-sm-12 data_arrangement ">
                <div class="card card-stats bg-transparent shadow-none arrangement border-left border-right <?=$dataActive?>" data-id="<?=$data_dept['dept']?>" style="max-width: 540px;" id="<?=$data_dept['id_dept']?>">
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
                                    <h5 class="card-title py-0 my-0 text-uppercase"><?=$data_dept['dept']?></h5>
                                    <p class="card-text py-0 my-0 badge badge-sm badge-pill badge-info">department</p>
                                    <!-- <p class="card-text">line 1</p> -->
                                </div>
                            </div>
                            
                            <a href="?model=<?=$data_dept['id_dept']?>"  class="mb-0 stretched-link card-category text-right text-white mb-3 view_data" data-id="<?=$data_dept['dept']?>" id="<?=$data_dept['id_dept']?>"></a>
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
        <div class="card" >
            <div class="card-header">
                <div class="row">
                    <h5 class="title pull-left col-md-6" id="mainpage"><i class="fas fa-network-wired "></i> Man Power Simulation</h5>
                    <div class="col-md-6 text-right">
                        <div class="dropdown dropleft">
                            <button class="btn btn-primary btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                
            </div>
            <form name="organization" method="POST" class="card-body">
                <!-- <div class="nav-tabs-navigation "> -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="sticker">
                            <h6>Access Control</h6>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <!--  -->
                                    <?php
                                    $q_section = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'section' ")or die(mysqli_error($link));
                                    if(mysqli_num_rows($q_section)>0){
                                        while($data = mysqli_fetch_assoc($q_section)){
                                            ?>
                                            <li class="nav-item ">
                                                <a class="btn btn-sm btn-link btn-round btn-info org navigasi-result active"  data-toggle="tab" data-id="result" href="#result" role="tab" aria-expanded="true"><?=$data['nama_org']?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="my-tab-content" class="tab-content ">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card card-stats border border-info">
                                        <div class="card-body " id="2">
                                            <div class="row">
                                                <div class="col-5 col-md-4 ">
                                                    <div class="icon-big text-center icon-info">
                                                        <span class="fa-stack text-primary" >
                                                            <i class="fas fa-sitemap fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                                        
                                                            <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                            <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                        </span>
                                                
                                                    </div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers ">
                                                        <p class="card-title text-primary ">53<p>
                                                        <p class="card-category text-right text-primary mb-3">Total MP</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card card-stats border border-info">
                                        <div class="card-body " id="2">
                                            <div class="row">
                                                <div class="col-5 col-md-4 ">
                                                    <div class="icon-big text-center icon-info">
                                                        <span class="fa-stack text-primary" >
                                                            <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                                        
                                                            <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                            <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                        </span>
                                                
                                                    </div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers ">
                                                        <p class="card-title text-primary ">53<p>
                                                        <p class="card-category text-right text-primary mb-3">Foreman</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card card-stats border border-info">
                                        <div class="card-body " id="2">
                                            <div class="row">
                                                <div class="col-5 col-md-4 ">
                                                    <div class="icon-big text-center icon-info">
                                                        <span class="fa-stack text-primary" >
                                                            <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                                        
                                                            <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                            <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                        </span>
                                                
                                                    </div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers ">
                                                        <p class="card-title text-primary ">53<p>
                                                        <p class="card-category text-right text-primary mb-3">Team Leader</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active " id="result" role="tabpanel" aria-expanded="true">
                                <div id="monitor">
                                    <div class="row">
                                        <h6 class="col-md-6">Data Area Produksi</h6>
                                        <div class="col-md-6 text-right">
                                            <button class="btn btn-sm btn-info">data area</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="card border border-info shadow-none ">

                                                <div class="card-body ">
                                                    <div class="row">
                                                        <div class="col-md-4 ">
                                                            <label for="">Group</label>
                                                            <div class="form-group">
                                                                <select name="" id="" class="form-control">
                                                                <?php
                                                                    $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($ink));
                                                                    if(mysqli_num_rows($q_group)>0){
                                                                        while($data = mysqli_fetch_assoc($q_group)){
                                                                            ?>
                                                                            <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                        <option disabled>Belum ada data</option>
    
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Shift</label>
                                                            <div class="form-group" >
                                                                <select required id="data_shift" name="data_shift" class="form-control data_shift">
                                                                    <?php
                                                                    $q_shift = mysqli_query($link, "SELECT `id_shift` AS id, `shift` AS `name` FROM `shift` WHERE `production` = '1' ")or die(mysqli_error($ink));
                                                                    if(mysqli_num_rows($q_shift)>0){
                                                                        while($data = mysqli_fetch_assoc($q_shift)){
                                                                            ?>
                                                                            <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        ?>
                                                                        <option disabled>Belum ada data</option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="">Man Power Qualification</label>
                                                            <div class="form-group">
                                                                <select name="" id="" class="form-control">
                                                                    <option value="1">Direct Man Power</option>
                                                                    <option value="2">Indirect MP</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-hover">
                                                <table class="table">
                                                    <thead>
                                                        <th>ACTION</th>
                                                        <th>#</th>
                                                        <th>NPK</th>
                                                        <th>Nama</th>
                                                        <th>SHIFT</th>
                                                        <th>Group</th>
                                                        <th>Area</th>
                                                        <th>CT</th>
                                                        <th>Dir. MP</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $q_shift = mysqli_query($link,"SELECT * FROM shift GROUP BY id_shift")or die(mysqli_error($link));
                                                        if(mysqli_num_rows($q_shift)>0){
                                                            $no = 1;
                                                            while($shift = mysqli_fetch_assoc($q_shift)){
                                                                $query = mysqli_query($link,"SELECT * FROM view_production_area WHERE shift = '$shift[id_shift]'")or die(mysqli_error($link));
                                                                if(mysqli_num_rows($query)>0){
                                                                    
                                                                    while($data = mysqli_fetch_assoc($query)){
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-left sticky-col first-col">
                                                                                <a href="proses/proses.php?edit=<?=$data['id']?>" data-id="<?=$data['id']?>" class="btn-warning btn btn-sm btn-icon btn-round view">
                                                                                    <i class="far fa-edit"></i>
                                                                                </a>
                                                                                <a href="proses/proses.php?del=<?=$data['id']?>" data-id="<?=$data['id']?>" class="btn-danger btn btn-sm btn-icon btn-round update_mp">
                                                                                    <i class="far fa-trash-alt"></i>
                                                                                </a>
                                                                            </td>
                                                                            <td><?=$no++?></td>
                                                                            <td><?=$data['prod_name']?></td>
                                                                            <td><?=$data['prod_type']?></td>
                                                                            <td><?=$data['shift']?></td>
                                                                            <td><?=$data['nama_line']?></td>
                                                                            <td><?=$data['nama_group']?></td>
                                                                            <td style="width:50px">
                                                                                

                                                                                <div class="form-group-sm p-0 m-0 no-border">
                                                                                    <input  class="form-control p-0 m-0 text-center border-none">
                                                                                </div>
                                                                            </td>
                                                                            <td><?="120"?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
    <?php    
    include_once("../../footer.php");
    //javascript
    ?>
    
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

