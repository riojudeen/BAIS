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
            <div class="collapse show collapse-view" id="tambah">
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                            <div class="card-body  mt-2">
                            
                                <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                                    
                                    <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                                        
                                        <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                                <input type="text" class="form-control mx-0">
                                            </div>
                                            <div >
                                                <span class="btn btn-sm btn-link btn-round btn-rose btn-file ">
                                                <span class="fileinput-new ">Select File</span>
                                                <span class="fileinput-exists">Change</span>
                                                    <input type="file"  name="file-excel" id="file_export"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                                    <button type="button" class="btn btn-sm btn-primary load-data pull-right" data-toggle="modal" data-target="#loaddata">Load Data</button>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
    }else if($_GET['id'] == 'draft'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Draft Pengajuan Overtime</h6>
                
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
        </div>
        <?php
    }else if($_GET['id'] == 'approve'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Approval Pengajuan Overtime</h6>
                <div class="collapse show collapse-view" id="filter">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="doccek" id="belumproses" value="1">
                                                    <span class="form-check-sign">Menunggu Approval</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="isetujui" id="disetujui" value="1">
                                                    <span class="form-check-sign">Pengajuan Disetujui </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="ditolak" id="ditolak" value="1">
                                                    <span class="form-check-sign">Pengajuan ditolak</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
        </div>
        <?php
    }else if($_GET['id'] == 'proccess'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Overtime Diproses Admin</h6>
                <div class="collapse show collapse-view" id="filter">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="doccek" id="belumproses" value="1">
                                                    <span class="form-check-sign">Menunggu Proses Admin</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="isetujui" id="disetujui" value="1">
                                                    <span class="form-check-sign">Pengajuan Diproses </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="ditolak" id="ditolak" value="1">
                                                    <span class="form-check-sign">Pengajuan Dikembalikan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
        </div>
        <?php
        
    }else if($_GET['id'] == 'datareq'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Waiting Approval</h6>
                <div class="collapse show collapse-view" id="filter">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="doccek" id="belumproses" value="1">
                                                    <span class="form-check-sign">Menunggu Approval</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="isetujui" id="disetujui" value="1">
                                                    <span class="form-check-sign">Pengajuan Diproses </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="ditolak" id="ditolak" value="1">
                                                    <span class="form-check-sign">Ditolak / Dikembalikan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
        </div>
        <?php
        
    }else if($_GET['id'] == 'breakdown'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <h6>Monitor Data Request</h6>
                <div class="collapse show collapse-view" id="filter">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >

                                <div class="card-body  mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="doccek" id="belumproses" value="1">
                                                    <span class="form-check-sign">Menunggu Approval</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="isetujui" id="disetujui" value="1">
                                                    <span class="form-check-sign">Pengajuan Diproses </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input all" type="checkbox" name="ditolak" id="ditolak" value="1">
                                                    <span class="form-check-sign">Ditolak / Dikembalikan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
                            <th>No Document</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>progress</th>
                            <th>Status</th>
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
