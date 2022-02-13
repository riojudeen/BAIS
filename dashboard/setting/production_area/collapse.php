<?php
?>
<div class="collapse show" id="collapseExample">
   
    <div class="row">
        <div class="col-md-9 pull-left">
            <h6 class="card-category " ></h6>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="text" class="form-control bg-transparent" placeholder="select masal">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="text" class="form-control bg-transparent" placeholder=".col-md-3">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="text" class="form-control bg-transparent" placeholder=".col-md-4">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="text" class="form-control bg-transparent" placeholder=".col-md-5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group rounded py-auto text-center" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                            
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
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >
                        <select style="background:rgba(255, 255, 255, 0.3)" class="form-control part text-center" data-size="7" name="part" data-style="btn btn-sm btn-outline-default btn-link border" title="Select Organization Part" data-width="300px" data-id="" id="area" required>
                            <option disabled>Select Organization Part</option>
                            <option value="division" class="text-uppercase text-center">Division</option>
                            <option value="deptAcc" class="text-uppercase text-center">Department Account</option>
                            <option value="dept" class="text-uppercase text-center">Department Functional</option>
                            <option value="section" class="text-uppercase text-center">Section</option>
                            <option value="group" class="text-uppercase text-center">Group</option>
                            <option value="pos" class="text-uppercase text-center">Pos Leader</option>
                        </select>
                    </div>
                    <a  class="btn btn-sm btn-danger  btn-link " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    <button type="submit" class="btn btn-sm btn-primary ">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>