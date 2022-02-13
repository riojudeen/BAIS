<?php
// echo $_GET['sort'];
?>
<div class="row">
    <form  method="GET" class="col-md-7 pull-left">
        <div class="form-inline col-md-2 px-0">
            <div class="input-group no-border">
                <input type="number" name="sort" class="form-control sort" id="sort" value="<?=$batas?>">
                <div class="input-group-apend">
                    <input type="submit" class=" btn btn-light my-0 text-center" value="go">
                </div>
            </div>
        </div>
    </form>
    <!-- <form method="GET" class=" col-md-5 pull-right">
        <div class="input-group no-border">
            <input type="text" name="cari" class="form-control" placeholder="cari area">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                </div>
            </div>
        </div>
    </form> -->
</div>
