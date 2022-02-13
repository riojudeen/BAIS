<?php
//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/function_status_approve.php");
require_once("../../config/function_access_query.php");
require_once("../../config/function_filter.php");
?>
<div class="modal fade bd-example-modal-xl"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left text-uppercase" id="staticBackdropLabel">Detail Data</h5>
                <p class="badge badge-pill"><?=""?></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo $_POST['id'];
                ?>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
            </div>

        </div>

    
  </div>
</div>