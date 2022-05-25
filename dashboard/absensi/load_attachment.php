<?php
require_once("../../config/config.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        $q_att_code = "SELECT attachment FROM attendance_code WHERE kode = '$_POST[id]'";
        $sql_att = mysqli_query($link, $q_att_code)or die(mysqli_error($link)); 
        if(mysqli_num_rows($sql_att)>0){
            $data = mysqli_fetch_assoc($sql_att);
            $attachement = isset($data['attachment'])?$data['attachment']:"";
            if($attachement == 1){
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <label> <i class="fas fa-paperclip"></i>
                            Attachment / Lampiran
                        </label>
                        <p class="category mb-0">
                            pengajuan membutuhkan lampiran tambahan
                        </p>
                        <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                        
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:500px;">
                                    <input type="text" class="form-control mx-0" >
                                </div>
                                <div >
                                    <span class="btn btn-sm  btn-round btn-rose btn-file ">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file" name="attach-upload" accept="image/png, image/jpeg, image/jpg" id="attach-upload" />
                                    </span>
                                    <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    <p class="category mt-0">
                                        pastikan gambar yang diupload berekstensi JPG, JPEG atau PNG
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            
        }
        
    }
    
    
} else{
echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>