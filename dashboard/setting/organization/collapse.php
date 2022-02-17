<?php
?>
<div class="collapse " id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow-none border inputnpk " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" enctype="multipart/form-data" action="proses/org/import.php">
                        <div class="form-group">
                            <textarea class="form-control " name="" id="text_input" cols="30" rows="10"><?=$fill_text_area?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                            </div>
                            <div class="col-md-6 text-right">
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