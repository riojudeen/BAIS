<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Adda Data Holiday";
    include_once("../../../header.php");
?>
<div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="nc-icon nc-simple-remove"></i>
            </button>
            <h5 class="modal-title" id="myModalLabel">How Do You Become an Affiliate?</h5>
            </div>
            <div class="modal-body">
            <div class="instruction">
                <div class="row">
                <div class="col-md-8">
                    <strong>1. Register</strong>
                    <p class="description">The first step is to create an account at <a href="https://www.creative-tim.com/">Creative Tim</a>. You can choose a social network or go for the classic version, whatever works best for you.</p>
                </div>
                <div class="col-md-4">
                    <div class="picture">
                    <img src="../../assets/img/bg/daniel-olahs.jpg" alt="Thumbnail Image" class="rounded img-raised">
                    </div>
                </div>
                </div>
            </div>
            <div class="instruction">
                <div class="row">
                <div class="col-md-8">
                    <strong>2. Apply</strong>
                    <p class="description">The first step is to create an account at <a href="https://www.creative-tim.com/">Creative Tim</a>. You can choose a social network or go for the classic version, whatever works best for you.</p>
                </div>
                <div class="col-md-4">
                    <div class="picture">
                    <img src="../../assets/img/bg/david-marcu.jpg" alt="Thumbnail Image" class="rounded img-raised">
                    </div>
                </div>
                </div>
            </div>
            <p>If you have more questions, don't hesitate to contact us or send us a tweet @creativetim. We're here to help!</p>
            </div>
            <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-info btn-round" data-dismiss="modal">Sounds good!</button>
            </div>
        </div>
    </div>
</div>
<?php
    //javascript
    include_once("../../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
