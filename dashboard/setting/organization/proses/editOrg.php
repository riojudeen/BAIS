<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    
    $total = 0;
    if(isset($_POST['pos'])){
        $totalPos =  count($_POST['pos']);
        $namaPos = "Pos Leader";
        $total = $total + $totalPos;
        $_SESSION['tab'] = "pos";
    }
    if(isset($_POST['group'])){
        $totalGroup = count($_POST['group']);
        $namaGroup = "Group";
        $total = $total + $totalGroup;
        $_SESSION['tab'] = "group";
    }
    if(isset($_POST['section'])){
        $totalSection = count($_POST['section']);
        $namaSect = "Section";
        $total = $total + $totalSection;
        $_SESSION['tab'] = "section";
    }
    if(isset($_POST['dept'])){
        $totalDept =  count($_POST['dept']);
        $namaDept = "Department Functional";
        $total = $total + $totalDept;
        $_SESSION['tab'] = "sect";
    }
    if(isset($_POST['deptAcc'])){
        $totalDeptAcc =  count($_POST['deptAcc']);
        $namaDeptAcc = "Dept Account";
        $total = $total + $totalDeptAcc;
        $_SESSION['tab'] = "deptacc";
    }
    if(isset($_POST['division'])){
        $totalDivision =  count($_POST['division']);
        $namaDivision = "Division";
        $total = $total + $totalDivision;
        $_SESSION['tab'] = "division";
    }
    if($total > 0){
    $halaman = "Edit Organisasi";
    include_once("../header.php");
    ?>
    <form method="post" action="proses/org/proses.php">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title pull-left">Edit Register Organisasi</h4>
                        
                        <div class=" box pull-right">
                            <a href="organization.php" class="btn btn-default "><i
                                class="nc-icon nc-minimal-left"></i> Kembali</a>
                        </div>
                       
                    </div>
                    <div class="card-body text-uppercase">
                        <table class="table table-bordered text-uppercase">
                            <thead>
                                <tr class="table-warning">
                                    <th>#</th>
                                    <th>Kode Org</th>
                                    <th>Nama Org</th>
                                    <th>NPK Coord</th>
                                    <th>Nama Coord</th>
                                    <th>parent Organization</th>
                                </tr>
                            </thead>
                            <tbody >
                            <?php
                            
                                for($i=1; $i<= $total ; $i++){
                                    if(isset($_POST['pos'])){
                                        foreach($_POST['pos'] AS $pos){
                                            // echo $pos;
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_post[]" class="form-control bg-transparent " value="<?=$pos?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_pos[]" class="form-control bg-transparent "value="<?=$nama_post?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_pos[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentPos[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary">
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
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_POST['group'])){
                                        foreach($_POST['group'] AS $group){
                                            // echo $pos;
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_group[]" class="form-control bg-transparent " value="<?=$group?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_group[]" class="form-control bg-transparent "value="<?=$nama_group?>" minLength="2" maxLength="40"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_group[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentGroup[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary">
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
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_POST['section'])){
                                        foreach($_POST['section'] AS $sect){
                                            
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_section[]" class="form-control bg-transparent " value="<?=$sect?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_section[]" class="form-control bg-transparent "value="<?=$nama_section?>"  minLength="2" maxLength="40" required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_section[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>"  required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentSection[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary" required>
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
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_POST['dept'])){
                                        foreach($_POST['dept'] AS $dept){
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_dept[]" class="form-control bg-transparent " value="<?=$dept?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_dept[]" class="form-control bg-transparent "value="<?=$nama_dept?>" minLength="2" maxLength="40" required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_dept[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>"  required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly  />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentDept[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary" required>
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
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_POST['deptAcc'])){
                                        foreach($_POST['deptAcc'] AS $deptAcc){
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_deptAcc[]" class="form-control bg-transparent " value="<?=$deptAcc?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_deptAcc[]" class="form-control bg-transparent "value="<?=$nama_deptAcc?>"  minLength="2" maxLength="40" required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_deptAcc[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>"  required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentDeptAcc[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary"  required>
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
                                            </tr>
                                            <?php
                                        }
                                        
                                    }
                                    if(isset($_POST['division'])){
                                        foreach($_POST['division'] AS $division){
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
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="kode_division[]" class="form-control bg-transparent " value="<?=$division?>" readonly/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="nama_division[]" class="form-control bg-transparent "value="<?=$nama_division?>"  minLength="2" maxLength="40" required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="cord_division[]" class="form-control bg-transparent npk"value="<?=$cord?>" id="npk<?=$i?>" data-id="<?=$i?>" required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border border-bottom py-0 my-0">
                                                        <input type="text" name="namaCord[]" class="form-control bg-transparent nama"value="<?=$nama_cord?>" id="nama<?=$i?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group bg-transparent no-border py-0 my-0">
                                                        <select name="parentDivision[]" data-size="5" data-live-search="true" class="form-control bg-transparent no-border selectpicker" data-style="btn btn-sm btn-outline-primary" required>
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
    
    include_once("../footer.php");
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
                        url: 'proses/org/validasi.php',
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
                            $('#nama'+id).val('npk tidak tersedia');
                        }
                    })
                }
            });
        });
    </script>
    <?php
    include_once("../endbody.php");
    }else{
        $_SESSION['info'] = "Kosong";
        echo "<script>window.location='organization.php';</script>";
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

