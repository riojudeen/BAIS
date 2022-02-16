<?php
?>
<div class="collapse show" id="collapseExample">
    <div class="row">
        <div class="col-md-9 pull-left">
            <h6>tambah data</h6>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow-none border inputnpk " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        <div class="form-group">
                            <textarea class="form-control " name="" id="text_input" cols="30" rows="10"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-sm" >
                                    <select style="background:rgba(255, 255, 255, 0.3)" class="form-control part text-center" data-size="7" name="part" data-style="btn btn-sm btn-outline-default btn-link border" title="Select Organization Part" data-width="300px" data-id="" id="area" required>
                                        <option disabled>Select Organization Part</option>
                                        <option value="division" class="text-uppercase text-center">Division</option>
                                        <option value="deptAcc" class="text-uppercase text-center">Department Account</option>
                                        <option value="dept" class="text-uppercase text-center">Department Functional</option>
                                        <option value="section" class="text-uppercase text-center">Section</option>
                                        <option value="group" class="text-uppercase text-center">Group</option>
                                        <option value="pos" class="text-uppercase text-center">Team</option>
                                        <option value="all" class="text-uppercase text-center">Kosongkan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                                <button type="submit" id="upload_npk" class="btn btn-sm btn-primary pull-right">Upload</button>
                            </div>
                        </div>
                        
                    <!-- <a  class="btn btn-sm btn-danger  btn-link " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a> -->
                    
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>