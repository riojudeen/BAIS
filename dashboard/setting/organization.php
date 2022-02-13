<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "User Settings";
    include_once("../header.php");
    if(isset($_SESSION['tab'])){
        if($_SESSION['tab'] == 'pos' ){
            $tab_pos = "active";
        }else if($_SESSION['tab'] == 'group' ){
            $tab_group = "active";
        }else if($_SESSION['tab'] == 'section' ){
            $tab_section = "active";
        }else if($_SESSION['tab'] == 'dept' ){
            $tab_dept = "active";
        }else if($_SESSION['tab'] == 'deptacc' ){
            $tab_deptacc = "active";
        }else if($_SESSION['tab'] == 'division' ){
            $tab_division = "active";
        }else{
            $tab_division = "active";
        }
    }else{
        $tab_division = "active";
        $tab_pos = "";
        $tab_group = "";
        $tab_section = "";
        $tab_dept = "";
        $tab_deptacc = "";
    }
    
?>
<!-- modal add data -->
<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses/org/add.php" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Jumlah Record Organization</h4>
                </div>
                <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group-sm">
                        <select required class="form-control selectpicker part text-center" data-size="7" name="part" data-style="btn btn-warning bg-white btn-link border" title="Select Organization Part" data-width="100%" data-id="" required>
                            
                            <option class="text-center" disabled>ORGANIZATION PART</option>
                            
                            <option value="division" class="text-uppercase text-center">Division</option>
                            <option value="deptAcc" class="text-uppercase text-center">Department Account</option>
                            <option value="dept" class="text-uppercase text-center">Department Functional</option>
                            <option value="section" class="text-uppercase text-center">Section</option>
                            <option value="group" class="text-uppercase text-center">Group</option>
                            <option value="pos" class="text-uppercase text-center">Pos Leader</option>
                                    
                        </select>
                    </div>
                    <hr class="my-o">
                    <div class="form-group">
                            <input type="text" name="count" class="form-control text-center gen" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link">Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- collapse import data -->
<div class="collapse" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Excel</h5>
                    <div class="pull-right">    
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body text-center">
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        <div class="form-group border rounded py-auto">
                            <div class="form-group-sm">
                                <select class="form-control selectpicker part text-center" data-size="7" name="part" data-style="btn btn-warning bg-white btn-link border" title="Select Organization Part" data-width="300px" data-id="" id="area" required>
                                    <option class="text-center" disabled>ORGANIZATION PART</option>
                                    
                                    <option value="division" class="text-uppercase text-center">Division</option>
                                    <option value="deptAcc" class="text-uppercase text-center">Department Account</option>
                                    <option value="dept" class="text-uppercase text-center">Department Functional</option>
                                    <option value="section" class="text-uppercase text-center">Section</option>
                                    <option value="group" class="text-uppercase text-center">Group</option>
                                    <option value="pos" class="text-uppercase text-center">Pos Leader</option>
                                </select>
                            </div>
                            <hr class="my-0">
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div>
                                    <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Upload File Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- halaman utama -->
<div class="row ">
    <div class="col-md-12 " >
        <div class="card " id="navfilter">
            <div class="card-header">
                <h5 class="title pull-left">Organization</h5>
                <div class="box pull-right">
                    <a href="file/Format_Register_Area.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                        <i class="nc-icon nc-paper"></i>
                    </a>
                    <button class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" >
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Import
                    </button>
                    
                    <a href="proses/export.php?export=organization" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </a>
                    <button class="btn btn-default" data-toggle="modal" data-target="#generate">
                    Add Data
                    </button>
                </div>
            </div>
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        
                        <li class="nav-item ">
                            <a class="nav-link <?=$tab_division?>" href="#tab_division" role="tab" data-toggle="tab"><h6 class="text-right ">Division</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab_deptacc?>" href="#deptAccount" role="tab" data-toggle="tab"><h6 class="text-right ">Department Account</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab_dept?>" href="#department" role="tab" data-toggle="tab"><h6 class="text-right ">Department</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab_section?>" href="#tab_section" role="tab" data-toggle="tab"><h6 class="text-right ">Section</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab_group?>" href="#tab_group" role="tab" data-toggle="tab"><h6 class="text-right ">Group</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab_pos?>" href="#tab_pos" role="tab" data-toggle="tab"><h6 class="text-right ">Pos</h6></a>
                        </li>
                    
                    </ul>
                </div>
            </div>
            <form action="" name="organization" method="POST">
            <div class="card-body table-full-width">
                <div class="tab-content">
                    <?php
                    // $i = 0;
                    // $set_indexActive = $tab[0];
                    // foreach($tab as $id_role){
                    //     $tab = ($set_indexActive == $id_role)? "active" : "";
                    ?>
                    <div class="tab-pane <?=$tab_pos?>" id="tab_pos">

                    <h5 class="pl-3">Pos Leader</h5>
                        <div class="" >
                            <table class="table table-striped table_org text-uppercase "text-uppercase " id="table_pos" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Post Name</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Group</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkallpos" type="checkbox" id="pos">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sOrg = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , karyawan.jabatan AS jabatan,
                                    pos_leader.id_post AS id_post_leader ,
                                    pos_leader.nama_pos AS nama_post_leader ,
                                    pos_leader.npk_cord AS npk_pos_cord ,
                                    pos_leader.id_group AS pos_leader_group,

                                    groupfrm.id_group AS id_group ,
                                    groupfrm.nama_group AS nama_group ,
                                    groupfrm.npk_cord AS group_npk ,
                                    groupfrm.id_section AS group_section
                                    FROM pos_leader 
                                    LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
                                    LEFT JOIN karyawan ON karyawan.npk = pos_leader.npk_cord" )or die(mysqli_error($link));
                                    $noOrg = 1;
                                    if(mysqli_num_rows($sOrg) > 0){
                                        while($dOrg = mysqli_fetch_assoc($sOrg)){
                                            $nama_cord = ($dOrg['nama_cord'] != "")?$dOrg['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dOrg['pos_leader_group'] == "" && $dOrg['nama_group'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dOrg['pos_leader_group'] != "" && $dOrg['nama_group'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dOrg['nama_group'];
                                            }
                                           
                                        ?>
                                        <tr >
                                            <td><?=$noOrg++?></td>
                                            <td><?=$dOrg['id_post_leader']?></td>
                                            <td><?=$dOrg['nama_post_leader']?></td>
                                            <td><?=$dOrg['npk_pos_cord']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?pos[]=<?=$dOrg['id_post_leader']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delPos=<?=$dOrg['id_post_leader']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td class="text-right">
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser userpos pos" name="pos[]" value="<?=$dOrg['id_post_leader']?>" type="checkbox" data="pos">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>



                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted bg-light text-uppercase text-center">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </tbody>
                                
                            </table>
                        </div>  
                    </div>
                    <div class="tab-pane <?=$tab_division?>" id="tab_division">

                    <h5 class="pl-3">Division</h5>
                        <div class="">
                            <table class="table table-striped  table_org text-uppercase" id="table_division" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Division Name</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Plant</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkalldivision" type="checkbox" id="division">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sDivision = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , 
                                    karyawan.jabatan AS jabatan,

                                    division.id_div AS id_div ,
                                    division.nama_divisi AS nama_divisi ,
                                    division.npk_cord AS div_cord ,
                                    division.id_company AS div_company,

                                    company.id_company AS id_company,
                                    company.nama AS perusahaan

                                    FROM division LEFT JOIN company ON division.id_company = company.id_company LEFT JOIN karyawan ON karyawan.npk = division.npk_cord")or die(mysqli_error($link));
                                    $noDv = 1;
                                    if(mysqli_num_rows($sDivision) > 0){
                                        while($dDiv = mysqli_fetch_assoc($sDivision)){
                                            $nama_cord = ($dDiv['nama_cord'] != "")?$dDiv['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dDiv['div_company'] == "" && $dDiv['perusahaan'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dDiv['div_company'] != "" && $dDiv['perusahaan'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dDiv['perusahaan'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$noDv++?></td>
                                            <td><?=$dDiv['id_div']?></td>
                                            <td><?=$dDiv['nama_divisi']?></td>
                                            <td><?=$dDiv['div_cord']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?division[]=<?=$dDiv['id_div']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delDiv=<?=$dDiv['id_div']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td class="text-right">
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser userdivision division" name="division[]" value="<?=$dDiv['id_div']?>" type="checkbox" data="division">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            
                                            
                                        </tr>



                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted text-center bg-light">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </tbody>
                                
                            </table>
                        </div>  
                    </div>
                    <div class="tab-pane <?=$tab_deptacc?>" id="deptAccount">

                    <h5 class="pl-3">Department Account</h5>
                        <div class="">
                            <table class="table table-striped table_org text-uppercase" id="table_deptacc" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Department Account</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Division</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkalldeptAcc" type="checkbox" id="deptAcc">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sdeptacc = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , karyawan.jabatan AS jabatan,

                                    dept_account.id_dept_account AS id_dept_account , 
                                    dept_account.department_account AS department_account , 
                                    dept_account.npk_dept AS dept_acc_cord , 
                                    dept_account.id_div AS deptAcc_div , 

                                    division.id_div AS id_div ,
                                    division.nama_divisi AS nama_divisi ,
                                    division.npk_cord AS div_cord ,
                                    division.id_company AS div_company
                                    FROM dept_account LEFT JOIN division ON dept_account.id_div = division.id_div LEFT JOIN karyawan ON karyawan.npk = dept_account.npk_dept" )or die(mysqli_error($link));
                                    $noD = 1;
                                    if(mysqli_num_rows($sdeptacc) > 0){
                                        while($dDepAcc = mysqli_fetch_assoc($sdeptacc)){
                                            $nama_cord = ($dDepAcc['nama_cord'] != "")?$dDepAcc['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dDepAcc['deptAcc_div'] == "" && $dDepAcc['nama_divisi'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dDepAcc['deptAcc_div'] != "" && $dDepAcc['nama_divisi'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dDepAcc['nama_divisi'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$noD++?></td>
                                            <td><?=$dDepAcc['id_dept_account']?></td>
                                            <td><?=$dDepAcc['department_account']?></td>
                                            <td><?=$dDepAcc['dept_acc_cord']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?deptAcc[]=<?=$dDepAcc['id_dept_account']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delDeptacc=<?=$dDepAcc['id_dept_account']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td>
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser userdeptAcc deptAcc" name="deptAcc[]" value="<?=$dDepAcc['id_dept_account']?>" type="checkbox" data="deptAcc">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>



                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted bg-light text-center">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </tbody>
                                
                            </table>
                        </div>  
                    </div>
            
                    <div class="tab-pane <?=$tab_dept?>" id="department">

                    <h5 class="pl-3">Department Functional</h5>
                        <div class="">
                            <table class="table table-striped table_org text-uppercase" id="table_dept" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Departmen Functional</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Division</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkalldept" type="checkbox" id="dept">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sDept = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , karyawan.jabatan AS jabatan,

                                    department.id_dept AS id_dept ,
                                    department.dept AS nama_dept ,
                                    department.npk_cord AS dept_npk ,
                                    department.id_div AS dept_div ,


                                    division.id_div AS id_div ,
                                    division.nama_divisi AS nama_divisi ,
                                    division.npk_cord AS div_cord ,
                                    division.id_company AS div_company

                                    FROM department 
                                    LEFT JOIN division ON department.id_div = division.id_div 
                                    LEFT JOIN karyawan ON karyawan.npk = department.npk_cord" )or die(mysqli_error($link));
                                    $noDept = 1;
                                    if(mysqli_num_rows($sDept) > 0){
                                        while($dDept = mysqli_fetch_assoc($sDept)){
                                            $nama_cord = ($dDept['nama_cord'] != "")?$dDept['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dDept['dept_div'] == "" && $dDept['nama_divisi'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dDept['dept_div'] != "" && $dDept['nama_divisi'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dDept['nama_divisi'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$noDept++?></td>
                                            <td><?=$dDept['id_dept']?></td>
                                            <td><?=$dDept['nama_dept']?></td>
                                            <td><?=$dDept['dept_npk']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?dept[]=<?=$dDept['id_dept']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delDept=<?=$dDept['id_dept']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td>
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser  userdept dept" name="dept[]" value="<?=$dDept['id_dept']?>" type="checkbox" data="dept">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>



                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted bg-light text-center">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </tbody>
                                
                            </table>
                        </div>  
                    
                    </div>
                    <div class="tab-pane <?=$tab_section?>" id="tab_section">

                    <h5 class="pl-3">Section</h5>
                        <div class="">
                            <table class="table table-striped table_org text-uppercase" id="table_section" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Section Name</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Department Funct.</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkallsection" type="checkbox" id="section">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sSect = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , karyawan.jabatan AS jabatan,

                                    department.id_dept AS id_dept ,
                                    department.dept AS nama_dept ,
                                    department.npk_cord AS dept_npk ,
                                    department.id_div AS dept_div ,


                                    section.id_section AS id_section ,
                                    section.section AS nama_section ,
                                    section.npk_cord AS sect_npk ,
                                    section.id_dept AS section_dept 

                                    FROM section LEFT JOIN department ON department.id_dept = section.id_dept LEFT JOIN karyawan ON karyawan.npk = section.npk_cord" )or die(mysqli_error($link));
                                    $noSec = 1;
                                    if(mysqli_num_rows($sSect) > 0){
                                        while($dSect = mysqli_fetch_assoc($sSect)){
                                            $nama_cord = ($dSect['nama_cord'] != "")?$dSect['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dSect['section_dept'] == "" && $dSect['nama_dept'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dSect['section_dept'] != "" && $dSect['nama_dept'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dSect['nama_dept'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$noSec++?></td>
                                            <td><?=$dSect['id_section']?></td>
                                            <td><?=$dSect['nama_section']?></td>
                                            <td><?=$dSect['sect_npk']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?section[]=<?=$dSect['id_section']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delSect=<?=$dSect['id_section']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td>
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser usersection section" name="section[]" value="<?=$dSect['id_section']?>" type="checkbox" data="section">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted bg-light text-center">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </tbody>
                                
                            </table>
                        </div>  
                    
                    </div>
                    <div class="tab-pane <?=$tab_group?>" id="tab_group">

                        <h5 class="pl-3">Group</h5>
                        <div class="">
                            <table class="table table-striped table_org text-uppercase "text-uppercase "" id="table_group" cellspacing="0" width="100%">
                                <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Org. Code</th>
                                    <th>Group Name</th>
                                    <th colspan="2">Kordinator Area</th>
                                    <th>Section</th>
                                    <th class="text-right">Action</th>
                                    <th scope="col" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input all checkallgroup" type="checkbox" id="group">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sGrp = mysqli_query($link, "SELECT 
                                    karyawan.nama AS nama_cord , karyawan.jabatan AS jabatan,
                                    groupfrm.id_group AS id_group ,
                                    groupfrm.nama_group AS nama_group ,
                                    groupfrm.npk_cord AS group_npk ,
                                    groupfrm.id_section AS group_section ,

                                    section.id_section AS id_section ,
                                    section.section AS nama_section ,
                                    section.npk_cord AS sect_npk ,
                                    section.id_dept AS section_dept 

                                    FROM groupfrm LEFT JOIN section ON groupfrm.id_section = section.id_section 
                                    LEFT JOIN karyawan ON karyawan.npk = groupfrm.npk_cord" )or die(mysqli_error($link));
                                    $noGrp = 1;
                                    if(mysqli_num_rows($sGrp) > 0){
                                        while($dGrp = mysqli_fetch_assoc($sGrp)){
                                            $nama_cord = ($dGrp['nama_cord'] != "")?$dGrp['nama_cord']:"DATA KARYAWAN BELUM ADA";
                                            if($dGrp['group_section'] == "" && $dGrp['nama_section'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DISETING";
                                            }else if($dGrp['group_section'] != "" && $dGrp['nama_section'] == ""){
                                                $org_parent = "INDUK ORGANISASI BELUM DIREGISTER";
                                            }else{
                                                $org_parent = $dGrp['nama_section'];
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$noGrp++?></td>
                                            <td><?=$dGrp['id_group']?></td>
                                            <td><?=$dGrp['nama_group']?></td>
                                            <td><?=$dGrp['group_npk']?></td>
                                            <td><?=$nama_cord?></td>
                                            <td><?=$org_parent?></td>
                                            
                                            <td class="text-right">
                                                <a href="proses/org/edit.php?group[]=<?=$dGrp['id_group']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                                <a href="proses/prosesOrg.php?delGrp=<?=$dGrp['id_group']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td>
                                                <div class="form-check text-right">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input checkuser usergroup group" value="<?=$dGrp['id_group']?>" name="group[]" type="checkbox" data="group">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-muted bg-light text-center">TIDAK ADA DATA DI DATABASE</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="card-footer">
                <div class="box pull-right">
                    <button class="btn btn-warning editall" id="edit">
                        <span class="btn-label">
                            <i class="nc-icon nc-ruler-pencil"></i>
                        </span>
                        edit
                    </button>
                    <button class="btn btn-danger deleteall" id="hapus">
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove"></i>
                        </span>
                        delete
                    </button>
                   
                </div>
            </div>
        </div>
    </div>
</div>


<!-- halaman utama end -->
<?php
    include_once("../footer.php");
    //javascript
    ?>
    <script>
    $(document).ready(function() {
      $('#table_pos').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
        

      });
    });
    </script>
      <script>
    $(document).ready(function() {
      $('#table_group').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });
    });
    </script>
    <script>
    $(document).ready(function() {
      $('#table_section').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });
    });
    </script>
     <script>
    $(document).ready(function() {
      $('#table_dept').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });
    });
    </script>
     <script>
    $(document).ready(function() {
      $('#table_division').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
         

      });
     
    });
    </script>
     <script>
    $(document).ready(function() {
      $('#table_deptacc').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6, 7]
            }
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }

      });
    });
    </script>
    
   
<script>
    $(document).ready(function(){
        $('.all').on('click', function(){
            var tab = $(this).attr('id');
            if(this.checked){
                $('.user'+tab).each(function() {
                    this.checked = true;
                })
            } else {
                $('.user'+tab).each(function() {
                    this.checked = false;
                })
            }
        });

        $('.checkuser').on('click', function() {
            var idTab = $(this).attr('data');
            if($('.user'+idTab+':checked').length == $('.user'+idTab).length){
                $('.checkall'+idTab).prop('checked', true)
            } else {
                $('.checkall'+idTab).prop('checked', false)
            }
        })
    })
    </script>
        <script>
    //untuk crud masal update department

        $('.deleteall').on('click', function(e){
            e.preventDefault();
            var getLink = 'proses/org/mass_del.php';
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Semua data yang dicheck / centang akan dihapus permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    document.organization.action = getLink;
                    document.organization.submit();
                }
            })
            
        });
        $('.editall').on('click', function(e){
            e.preventDefault();
            var getLink = 'editOrg.php';

            document.organization.action = getLink;
            document.organization.submit();
        }); 
    </script>
     <script>
    //untuk crud masal update department

        $('.remove').on('click', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Data Akan Dihapus Permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    document.organization.action = getLink;
                    document.organization.submit();
                }
            })
            
        });
        
    </script>
    <script>
        $(document).ready(function(){
            $('.gen').keypress(function hanyaAngka(event) {
                var angka = (event.which)?
                event.which : event.keyCode
                if(angka != 46 && angka > 31 && (angka < 48 || angka > 57))
                return false;
                return true;
            })
        })
    </script>
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

