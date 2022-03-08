<?php
?>
<div class="modal fade bd-example-modal-xl" id="datapreview"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl  ">
       
        <form  class="modal-content" action="proses/proses.php" method="POST" id="RangeValidation">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h5 class="title text-left">Data Preview</h5>
            </div>
            <div class="modal-body px-0 mx-0">
                
            <div class="data_load  col-md-12 px-0 mx-0"></div>
                
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-link" name="update">Update</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>