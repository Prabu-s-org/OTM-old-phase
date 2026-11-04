<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<?php
// Form variables
$btn_text              = "Save";
$btn_action            = "create";
$is_btn_disable        = "";
$btn_cancel            = "index.php";

$unique_id             = $_SESSION['user_id'];


$warning_msg           = "";
$old_readonly          = "";
$old_password          = "";
$new_password          = "";
$confirm_password       = "";
$is_active             = 1;

if (isset($_GET["default"])) {
    $old_readonly   = "readonly";
    $old_password   = "password";
    $warning_msg    = "Please Change Your Default password";
}

// $staff_id       = staff_name($_SESSION['user_id']);
// $staf_name           = disname($staff_details[0]['staff_name']);
// $staff_designation   = disname($staff_details[0]['designation_unique_id']);
//$designation_details = work_designation($staff_designation);
// $designation_type    = disname($designation_details[0]['designation_type']);

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated">
                    <div class="row col-5">
                        <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $unique_id; ?>">
                        <!-- <?php if ($warning_msg) : ?>
                            <h4 class="header-title text-danger"><?php echo $warning_msg; ?></h4>
                        <?php endif; ?> -->
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label  class="form-label"> Old Password </label>
                            
                                    <input type="password" id="old_password" name="old_password" class="form-control" <?php echo $old_readonly; ?> value="<?php echo $old_password; ?>" maxlength="30" size="50">
                                    <div class="position-relative">
                                    <!-- <i class="ri-eye-fill align-middle"></i>  -->
                                 </div>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label"> New Password</label>

                                <div class="input-group input-group-merge col-md-4">
                                    <input type="password" id="new_password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                    <div class="position-relative">
                                       

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label"> Confirm Password </label>

                                <div class="input-group input-group-merge col-md-4">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" maxlength="10" size="30">
                                    <div class="input-group-append" data-password="false">
                                        <!-- <div class="input-group-text form-control">
                                            <span class="password-eye"></span>
                                        </div> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div align="right">
                            <!-- Cancel,save and update Buttons -->
                            <?php echo btn_cancel($btn_cancel); ?>
                            <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>



<!-- <style>

    .image_area {
          position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg{
            max-width: 1000px !important;
        }

        .overlay {
          position: absolute;
          bottom: 10px;
          left: 0;
          right: 0;
          background-color: rgba(255, 255, 255, 0.5);
          overflow: hidden;
          height: 0;
          transition: .5s ease;
          width: 50%;
        }

        .image_area:hover .overlay {
          height: 60%;
          cursor: pointer;
        }

        .text {
          color: #333;
          font-size: 10px;
          position: absolute;
          top: 50%;
          left: 50%;
          -webkit-transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
          text-align: center;
        }

        .img-circle {
        border-radius: 50%;
        display: block;
        max-width: 50%;

        }
</style> -->

<script>
    $(document).ready(function() {

        var $modal = $('#modal');

        var image = document.getElementById('sample_image');
        var unique_id = document.getElementById('unique_id').value;

        var cropper;

        $('#upload_image').change(function(event) {
            var files = event.target.files;

            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        url: 'folders/password/upload.php',
                        method: 'POST',
                        data: {
                            image: base64data,
                            unique_id: unique_id,
                        },
                        success: function(data) {
                            var split_data = data.split("/");

                            $modal.modal('hide');
                            $('#uploaded_image').attr('src', data);
                            $("#image_name").val(split_data[3]);
                        }
                    });
                };
            });
        });

    });
</script>
