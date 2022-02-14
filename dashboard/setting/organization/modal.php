<?php
?>
<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content mx-0 px-0">
            <form action="proses/add.php" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title title-up">Sub Area </h5>
                </div>
                <div class="modal-body px-2">
                
                    <div class="form-group-sm ">
                        <select required class="form-control selectpicker part text-center"data-size="7" name="part" data-style="btn btn-warning bg-white btn-link border" title="Select Organization Part" data-width="100%" data-id="" required>
                            
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
                    <div class="form-group">
                        <input type="number" name="count" class="form-control text-center gen" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
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
<div class="modal fade" id="data_sub" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content mx-0 px-0">
            <form action="proses/add.php" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title title-up">Jumlah Record Organization</h5>
                </div>
                <div class="modal-body px-2">
                
                    <div class="form-group-sm " id="sub_area_preview" >
                        
                       
                    </div>
                    <h6>Tambah sub organisasi</h6>
                    <div class="form-group">
                        
                        <input type="number" name="count" class="form-control text-center gen" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
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