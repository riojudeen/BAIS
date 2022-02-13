<?php
include("../../../config/config.php");
if(isset($_GET['id'])){
    if($_GET['id'] == 'req'){
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <h6 class="col-md-6">Overtime Request</h6>
                
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group no-border">
                        
                        <select class="form-control" name="dept" id="deptacc">
                            <option value="1">Project</option>
                            <option value="1">Produksi</option>
                            <option value="1">Quality</option>
                        </select>
                        <select class="form-control" name="section" id="section">
                            <option value="1">Section 1</option>
                            <option value="1">Section 2</option>
                            <option value="1">Section 3</option>
                        </select>
                        <select class="form-control" name="groupfrm" id="goupfrm">
                            <option value="1">Group 1</option>
                            <option value="1">Group 2</option>
                            <option value="1">Group 3</option>
                        </select>
                        <select class="form-control" name="shift" id="shift">
                            <option value="1">Shift A</option>
                            <option value="1">Shift B</option>
                            <option value="1">Shift N</option>
                        </select>
                        <select class="form-control" name="deptacc" id="deptacc">
                            <option value="1">Body 1</option>
                            <option value="1">Body 2</option>
                            <option value="1">BQC</option>
                        </select>
                        <div class="input-group-append ">
                            <span class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Group</th>
                        <th>Team</th>
                        <th>Shift</th>
                        <th>Administratif</th>
                        <th class="text-right">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input checkAll" checked type="checkbox">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>44131</td>
                            <td>Rio Setiawan Judin</td>
                            <td>Group 1</td>
                            <td>Team 1</td>
                            <td>A</td>
                            <td>BODY 1</td>
                            <td class="text-right">
                                <div class="form-check ">
                                    <label class="form-check-label">
                                        <input class="form-check-input checkOne" name="index[]" type="checkbox" value="" checked>
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-sm">Dowload Format</button>
            <button class="btn btn-sm">Request</button>
        </div>
    </div>
    <?php
    
    }else if($_GET['id'] == 'success'){
        
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Pengajuan Close</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group no-border">
                            
                            <select class="form-control" name="dept" id="deptacc">
                                <option value="1">Project</option>
                                <option value="1">Produksi</option>
                                <option value="1">Quality</option>
                            </select>
                            <select class="form-control" name="section" id="section">
                                <option value="1">Section 1</option>
                                <option value="1">Section 2</option>
                                <option value="1">Section 3</option>
                            </select>
                            <select class="form-control" name="groupfrm" id="goupfrm">
                                <option value="1">Group 1</option>
                                <option value="1">Group 2</option>
                                <option value="1">Group 3</option>
                            </select>
                            <select class="form-control" name="shift" id="shift">
                                <option value="1">Shift A</option>
                                <option value="1">Shift B</option>
                                <option value="1">Shift N</option>
                            </select>
                            <select class="form-control" name="deptacc" id="deptacc">
                                <option value="1">Body 1</option>
                                <option value="1">Body 2</option>
                                <option value="1">BQC</option>
                            </select>
                            <div class="input-group-append ">
                                <span class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>NPK</th>
                            <th>Nama</th>
                            <th>Shift Awal</th>
                            <th>Pindah Shift</th>
                            <th>Tanggal</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Pembuat</th>
                            <th class="text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input checkAll" checked type="checkbox">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>44131</td>
                                <td>Rio Setiawan Judin</td>
                                <td>N</td>
                                <td>B</td>
                                <td></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-animated progress-bar-danger progress-bar-striped" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>

                                    </div>
                                </td>
                                <td>OK</td>
                                <td>
                                    Rio 4413
                                </td>
                                <td class="text-right">
                                    <div class="form-check ">
                                        <label class="form-check-label">
                                            <input class="form-check-input checkOne" name="index[]" type="checkbox" value="" checked>
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
$(document).ready(function(){
    $('.checkAll').on('click', function(){
        if(this.checked){
            $('.checkOne').each(function() {
                this.checked = true;
            })
        } else {
            $('.checkOne').each(function() {
                this.checked = false;
            })
        }
    });
    $('.checkOne').on('click', function() {
        if($('.checkOne:checked').length == $('.checkOne').length){
            $('.checkAll').prop('checked', true)
        } else {
            $('.checkAll').prop('checked', false)
        }
    })
})
</script>
<script>
    $(document).ready(function(e){
        e.preventDefault
        $('.load-data').on('click', function() {
            var file_data = $('#file_export').prop('files')[0];   
            var form_data = new FormData();
            var groupshift = $('#groupshift').val();
            var jab = $('#jabatan').val();
            var stats = $('#status').val();
            var deptacc = $('#deptacc').val();
            var roleuser = $('#roleuser').val();
            var pass = $('#password').val();
            var d_pass =[];
            $('#defaultpass').each(function(){
                if($(this).is(":checked")){
                    d_pass.push($(this).val());
                }
            });
            var dept = $('#department').val();
            var sect = $('#section').val();
            var group = $('#group').val();
            var posleader = $('#posleader').val();
            var doc_cek = [];
            $('#documentcek').each(function(){
                if($(this).is(":checked")){
                    doc_cek.push($(this).val());
                }
            });
            form_data.append('file-excel', file_data);
            // alert(form_data);                             
            $.ajax({
                url: 'ajax/import.php?groupshift='+groupshift+'&jab='+jab+'&stats='+stats+'&deptacc='+deptacc+'&role='+roleuser+'&pass='+pass+'&dpass='+d_pass+'&dept='+dept+'&sect='+sect+'&group='+group+'&pos='+posleader+'&doccek='+doc_cek, // <-- point to server-side PHP script 
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                // encode: 'true',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
                    
                    // var cek = Object.keys(file_data).length
                    // console.log(file_data)
                    if(file_data !== undefined){
                        $('#datapreview').modal('show');
                        $(".data_load").html(resp);
                    }else{
                        Swal.fire('Dokumen Belum dipilih')
                    }
                }
            });
        });
    })
</script>
