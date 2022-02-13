<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    
    $total = 0;
    if(isset($_GET['pos'])){
        $totalPos =  count($_GET['pos']);
        $namaPos = "Pos Leader";
        $namaOrg = $namaPos;
        $total = $total + $totalPos;
        $_SESSION['tab'] = "pos";
    }
    if(isset($_GET['group'])){
        $totalGroup = count($_GET['group']);
        $namaGroup = "Group";
        $namaOrg = $namaGroup;
        $total = $total + $totalGroup;
        $_SESSION['tab'] = "group";
    }
    if(isset($_GET['section'])){
        $totalSection = count($_GET['section']);
        $namaSect = "Section";
        $namaOrg = $namaSect;
        $total = $total + $totalSection;
        $_SESSION['tab'] = "section";
    }
    if(isset($_GET['dept'])){
        $totalDept =  count($_GET['dept']);
        $namaDept = "Department Functional";
        $namaOrg = $namaDept;
        $total = $total + $totalDept;
        $_SESSION['tab'] = "dept";
    }
    if(isset($_GET['deptacc'])){
        $totalDeptAcc =  count($_GET['deptacc']);
        $namaDeptAcc = "Dept Account";
        $namaOrg = $namaDeptAcc;
        $total = $total + $totalDeptAcc;
        $_SESSION['tab'] = "deptacc";
    }
    if(isset($_GET['division'])){
        $totalDivision =  count($_GET['division']);
        $namaDivision = "Division";
        $namaOrg = $namaDivision;
        $total = $total + $totalDivision;
        $_SESSION['tab'] = "division";
    }
    if($total > 0){
    $halaman = "Organization Setings";
    include_once("../../../header.php");
    ?>
    <form method="post" action="proses.php">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title pull-left">Edit Register <?=$namaOrg?></h4>
                        
                        <div class=" box pull-right">
                            <a href="../index.php" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                       
                    </div>
                    <div class="card-body text-uppercase ">
                        <table class="table  text-uppercase">
                            <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Nama Org</th>
                                    <th colspan="2">Area Coordinator</th>
                                    <th colspan="2">Parent Organization</th>
                                </tr>
                            </thead>
                            <tbody >
                            <?php
                            
                                for($i=1; $i<= $total ; $i++){
                                    if(isset($_GET['pos'])){
                                        foreach($_GET['pos'] AS $pos){
                                            // echo $pos;
                                            $id = "pos";
                                            $s_pos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_post = '$pos' ")or die($mysqli_error($link));
                                            $dataPost = mysqli_fetch_assoc($s_pos);
                                            $id_group = $dataPost['id_group'];
                                            $nama_post = $dataPost['nama_pos'];
                                            $cord = $dataPost['npk_cord'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan) > 0 )?$dnama_cord['nama']:"npk tidak tersedia";

                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$pos?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_post?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="selectpicker parent" data-width="300px" data-style="btn btn-outline-primary">
                                                        <?php
                                                        $s_group = mysqli_query($link, "SELECT groupfrm.id_group AS id_area, 
                                                        groupfrm.nama_group AS nama_area, 
                                                        groupfrm.npk_cord AS cordinator, 
                                                        groupfrm.id_section AS id_parent,
                                                        karyawan.npk AS npk_kary,
                                                        karyawan.nama AS nama_kary
                                                        
                                                        FROM `groupfrm`
                                                        LEFT JOIN karyawan ON karyawan.npk = groupfrm.npk_cord")or die(mysqli_error($link));
                                                        while($d_group = mysqli_fetch_assoc($s_group)){
                                                            $select = ($d_group['id_area'] == $id_group)?"selected":"";
                                                            ?>
                                                            <option <?=$select?> data-subtext="<?=$d_group['nama_kary']?>" value="<?=$d_group['id_area']?>"><?=$d_group['nama_area']?></option>
                                                            <?php
                                                        }
                                                        
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_GET['group'])){
                                        foreach($_GET['group'] AS $group){
                                            // echo $pos;
                                            $id = "group";
                                            $s_group = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_group = '$group' ")or die($mysqli_error($link));
                                            $dataGroup = mysqli_fetch_assoc($s_group);
                                            $id_section = $dataGroup['id_section'];
                                            $nama_group = $dataGroup['nama_group'];
                                            $cord = $dataGroup['npk_cord'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan))?$dnama_cord['nama']:"npk tidak tersedia";
                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$group?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_group?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                <div class="form-group py-0 my-0">
                                                    <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="parent selectpicker" data-style="btn btn-outline-primary">
                                                        <?php
                                                        $s_area = mysqli_query($link, "SELECT section.id_section AS id_area, 
                                                        section.section AS nama_area, 
                                                        section.npk_cord AS cordinator, 
                                                        section.id_dept AS id_parent,
                                                        karyawan.npk AS npk_kary,
                                                        karyawan.nama AS nama_kary
                                                        
                                                        FROM `section`
                                                        LEFT JOIN karyawan ON karyawan.npk = section.npk_cord")or die(mysqli_error($link));
                                                        while($d_area = mysqli_fetch_assoc($s_area)){
                                                            $select = ($d_area['id_area'] == $id_section)?"selected":"";
                                                            ?>
                                                            <option <?=$select?> data-subtext="<?=$d_area['nama_kary']?>" value="<?=$d_area['id_area']?>"><?=$d_area['nama_area']?></option>
                                                            <?php
                                                        }
                                                        
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_GET['section'])){
                                        foreach($_GET['section'] AS $sect){
                                            $id = "section";
                                            $s_section = mysqli_query($link, "SELECT * FROM section WHERE id_section = '$sect' ")or die($mysqli_error($link));
                                            $dataSection = mysqli_fetch_assoc($s_section);
                                            $id_dept = $dataSection['id_dept'];
                                            $nama_section = $dataSection['section'];
                                            $cord = $dataSection['npk_cord'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan))?$dnama_cord['nama']:"npk tidak tersedia";
                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$sect?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_section?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                <div class="form-group py-0 my-0">
                                                    <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="parent selectpicker" data-style="btn btn-outline-primary">
                                                        <?php
                                                        $s_area = mysqli_query($link, "SELECT department.id_dept AS id_area, 
                                                        department.dept AS nama_area, 
                                                        department.npk_cord AS cordinator, 
                                                        department.id_div AS id_parent,
                                                        karyawan.npk AS npk_kary,
                                                        karyawan.nama AS nama_kary
                                                        
                                                        FROM `department`
                                                        LEFT JOIN karyawan ON karyawan.npk = department.npk_cord")or die(mysqli_error($link));
                                                        while($d_area = mysqli_fetch_assoc($s_area)){
                                                            $select = ($d_area['id_area'] == $id_dept)?"selected":"";
                                                            ?>
                                                            <option <?=$select?> data-subtext="<?=$d_area['nama_kary']?>" value="<?=$d_area['id_area']?>"><?=$d_area['nama_area']?></option>
                                                            <?php
                                                        }
                                                        
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_GET['dept'])){
                                        foreach($_GET['dept'] AS $dept){
                                            $id="dept";
                                            $s_dept = mysqli_query($link, "SELECT * FROM department WHERE id_dept = '$dept' ")or die($mysqli_error($link));
                                            $dataDept= mysqli_fetch_assoc($s_dept);
                                            $id_div = $dataDept['id_div'];
                                            $nama_dept = $dataDept['dept'];
                                            $cord = $dataDept['npk_cord'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan))?$dnama_cord['nama']:"npk tidak tersedia";
                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$dept?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_dept?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                <div class="form-group py-0 my-0">
                                                    <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="parent selectpicker" data-style="btn btn-outline-primary">
                                                        <?php
                                                         $s_area = mysqli_query($link, "SELECT division.id_div AS id_area, 
                                                         division.nama_divisi AS nama_area, 
                                                         division.npk_cord AS cordinator, 
                                                         division.id_company AS id_parent,
                                                         karyawan.npk AS npk_kary,
                                                         karyawan.nama AS nama_kary
                                                         
                                                         FROM `division`
                                                         LEFT JOIN karyawan ON karyawan.npk = division.npk_cord")or die(mysqli_error($link));
                                                         while($d_area = mysqli_fetch_assoc($s_area)){
                                                             $select = ($d_area['id_area'] == $id_div)?"selected":"";
                                                             ?>
                                                             <option <?=$select?> data-subtext="<?=$d_area['nama_kary']?>" value="<?=$d_area['id_area']?>"><?=$d_area['nama_area']?></option>
                                                             <?php
                                                         }
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>

                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_GET['deptacc'])){
                                        foreach($_GET['deptacc'] AS $deptAcc){
                                            $id="deptacc";
                                            $s_deptAcc= mysqli_query($link, "SELECT * FROM dept_account WHERE id_dept_account = '$deptAcc' ")or die($mysqli_error($link));
                                            $dataDeptAcc = mysqli_fetch_assoc($s_deptAcc);
                                            $id_div = $dataDeptAcc['id_div'];
                                            $nama_deptAcc = $dataDeptAcc['department_account'];
                                            $cord = $dataDeptAcc['npk_dept'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan))?$dnama_cord['nama']:"npk tidak tersedia";
                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$deptAcc?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_deptAcc?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                <div class="form-group py-0 my-0">
                                                    <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="parent selectpicker" data-style="btn btn-outline-primary">
                                                        <?php
                                                         $s_area = mysqli_query($link, "SELECT division.id_div AS id_area, 
                                                         division.nama_divisi AS nama_area, 
                                                         division.npk_cord AS cordinator, 
                                                         division.id_company AS id_parent,
                                                         karyawan.npk AS npk_kary,
                                                         karyawan.nama AS nama_kary
                                                         
                                                         FROM `division`
                                                         LEFT JOIN karyawan ON karyawan.npk = division.npk_cord")or die(mysqli_error($link));
                                                         while($d_area = mysqli_fetch_assoc($s_area)){
                                                             $select = ($d_area['id_area'] == $id_div)?"selected":"";
                                                             ?>
                                                             <option <?=$select?> data-subtext="<?=$d_area['nama_kary']?>" value="<?=$d_area['id_area']?>"><?=$d_area['nama_area']?></option>
                                                             <?php
                                                         }
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_GET['division'])){
                                        $id ="division";
                                        foreach($_GET['division'] AS $division){
                                            $s_division= mysqli_query($link, "SELECT * FROM division WHERE id_div = '$division' ")or die($mysqli_error($link));
                                            $dataDivision = mysqli_fetch_assoc($s_division);
                                            $id_plant = $dataDivision['id_company'];
                                            $nama_division = $dataDivision['nama_divisi'];
                                            $cord = $dataDivision['npk_cord'];

                                            $s_karyawan = mysqli_query($link, "SELECT nama FROM karyawan WHERE npk = '$cord' ")or die(mysqli_error($link));
                                            $dnama_cord = mysqli_fetch_assoc($s_karyawan);
                                            $nama_cord = (mysqli_num_rows($s_karyawan))?$dnama_cord['nama']:"npk tidak tersedia";
                                            ?>
                                            <tr>
                                                <td class="">
                                                    <?=$i++?>
                                                    <input type="hidden" name="kode_<?=$id?>[]" class="form-control bg-transparent " value="<?=$dvision?>"/>
                                                </td>
                                                
                                                <td class="col-md-4">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="nama_<?=$id?>[]" class="form-control bg-transparent "value="<?=$nama_division?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group py-0 my-0">
                                                        <input placeholder="npk" type="text" name="cord_<?=$id?>[]" class="form-control npk" value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                    <div class="form-group py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control nama" value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                        
                                                    </div>
                                                </td>
                                                <td class="col-md-3">
                                                <div class="form-group py-0 my-0">
                                                    <select data-id="<?=$i?>" name="parent<?=$id?>[]" data-size="5" data-live-search="true" class="parent selectpicker" data-style="btn btn-outline-primary">
                                                        <?php
                                                         $s_area = mysqli_query($link, "SELECT * FROM `company` ")or die(mysqli_error($link));
                                                         while($d_area = mysqli_fetch_assoc($s_area)){
                                                            
                                                             ?>
                                                             <option data-subtext="P-4" value="<?=$d_area['id_company']?>"><?=$d_area['nama']?></option>
                                                             <?php
                                                         }
                                                        ?>
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </td>
                                                </td>
                                                <td class="col-md-1 text-right">
                                                <span class="text-right text-muted font-italic" id="areacode-<?=$i?>"></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <p class="badge badge-warning"><?=$total?> data</p>
                    </div>
                    <div class="card-footer">
                        <div class="box">
                            <button class="btn btn-success pull-right" type="submit" name="edit">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php        
    
    include_once("../../../footer.php");
    //javascript
    ?>
    

<script>
    $(document).ready(function() {
    
      $('.table_org').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": [0, 6]
            }
        ],
        "order": [1,"asc"],
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
    <script type="text/javascript">
		$(document).ready(function(){
            $('.npk').keyup(function() {
                var id = $(this).attr('data-id');
                var npk = $(this).val();

                if('#npk'+id == '') {
                    $('#nama'+id).val('');
                }
                else {
                    $.ajax({
                        url: 'validasi.php',
                        type: 'POST',
                        data: {npk : npk},
                        
                        
                    })
                    .done(function(hasilajax){
                        var jsondata = hasilajax,
                        obj = JSON.parse(jsondata);
                        if(obj.jumlah > 0){
                            $('#nama'+id).val(obj.nama);
                        }else{
                            $('#nama'+id).val('npk tidak tersedia');
                        }
                    })
                }
            });
        });
    </script>
     <!-- get kode parent -->
     <script type="text/javascript">
            $(document).ready(function(){
                $('.parent').change(function() {
                    var id = $(this).attr('data-id');
                    var parent = $(this).val();
                    $("#areacode-"+id).text(parent);
                    
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.npk').keyup(function() {
                    var id = $(this).attr('data-id');
                    var npk = $(this).val();

                    if('#npk'+id == '') {
                        $('#nama'+id).val('');
                    }
                    else {
                        $.ajax({
                            url: 'validasi.php',
                            type: 'POST',
                            data: {npk : npk},
                            // success: function(hasil) {
                            //     if(hasil > 0) {
                            //         $('#nama'+id).val();
                            //         $('#nama'+id).attr('disabled','true');
                            //         $('#submit').attr('disabled','true');
                            //     }
                            //     else {
                            //         $('#nama'+id).val('NPK belum ada di database');
                            //         $('#nama'+id).removeAttr('disabled');
                            //         $('#submit').removeAttr('disabled');
                            //     }
                            // }
                            
                        })
                        .done(function(hasilajax){
                            var jsondata = hasilajax,
                            obj = JSON.parse(jsondata);
                            if(obj.jumlah > 0){
                                $('#nama'+id).val(obj.nama);
                            }else{
                                $('#nama'+id).val('NPK TIDAK TERSEDIA');
                            }
                        })
                    }
                });
            });
        </script>
    <?php
    include_once("../../../endbody.php");
    }else{
        $_SESSION['info'] = "Kosong";
        // echo "<script>window.location='/index.php';</script>";
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

