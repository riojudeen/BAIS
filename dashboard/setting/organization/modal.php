<?php
?>
<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses/add.php" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title title-up">Jumlah Record Organization</h5>
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