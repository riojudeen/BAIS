<?php
?>
<div class="modal fade bd-example-modal-xl" id="datapreview" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="proses/proses.php" method="POST" id="RangeValidation">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title text-left">Data Preview</h5>
                </div>
                <div class="modal-body px-2">
                    
                    <div id='ajax-wait' class="text-center">
                        <img alt='loading...' src='<?=base_url()?>/assets/img/Ellipsis-1s-200px.gif' width='32' height='32' style="display:none"/>
                    </div>
                    <div class="data_load  col-md-12"></div>
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
</div>