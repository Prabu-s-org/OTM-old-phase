<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style type="text/css">
   .modal-full-width {
      max-width: 1000px !important;
   }

   .image_area {
      position: relative;
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
      width: 100%;
   }

   .image_area:hover .overlay {
      height: 50%;
      cursor: pointer;
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

   .text {
      color: #333;
      font-size: 20px;
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      text-align: center;
   }

   .displayBadge {
      display: none;
      text-align: center;
   }

   span#StrengthDisp {
      font-size: 12px;
      white-space: normal;
      text-align: left;
      font-weight: normal;
   }

   .accordion {
      background-color: #08649d;
      color: #fff !important;
      cursor: pointer;
      padding: 13px 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px !important;
      transition: 0.4s;
      text-transform: uppercase;
      font-weight: 500;
      margin-bottom: 10px;
   }

   .active,
   .accordion:hover {
      background-color: #c4d9ff;
      color: #000 !important;
   }

   .panel {
      padding: 0 18px;
      display: none;
      background-color: white;
      overflow: hidden;
   }

   .accordion:after {
      content: '\02795';
      /* Unicode character for "plus" sign (+) */
      font-size: 13px;
      color: #777;
      float: right;
      margin-left: 5px;
   }

   .active:after {
      content: "\2796";
      /* Unicode character for "minus" sign (-) */
   }

   #captcha_validate {
      display: none;
   }

   .display-none {
      display: none !important;
   }

   .dropify-wrapper {
      width: 100% !important;
      height: 100px !important;
   }

   .btn {

      padding: 0.45rem 0.6rem;
      font-size: .7125rem;

   }
   .form-label {
        margin: 10px 0px !important;
    }
</style>
<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";
$form_type          = "Create";

$name               = "";
$user_name          = "";
$password           = "";
$user_type          = "";
$is_active          = 1;
$mobile_no          = "";
$profile_status     = 0;
$document_type      = "";
$document_number    = "";

$other_proof_name_class = " display-none ";

$profile_image_val       = "uploads/user/user.png";


if (isset($_GET["unique_id"])) {
   if (!empty($_GET["unique_id"])) {

      // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
      // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);


      $unique_id  = $_GET["unique_id"];
      $where      = [
         "unique_id" => $unique_id
      ];

      $table      =  "user";

      $columns    = [
         "staff_name",
         "staff_id",
         "user_type_unique_id",
         "mobile_no",
         "email_id",
         // "department",
         // "ward_name",
         "user_name",
         "address",
         "is_active",
         // "profile_image",
         // "password",
         // "securityquestion1",
         // "securityquestion2",
         // "securityquestion3",
         // "document_type",
         // "document_number",
         // "otherProof_name",
      ];

      $table_details   = [
         $table,
         $columns
      ];

      $user_values  = $pdo->select($table_details, $where);

      if ($user_values->status) {

         $user_values     = $user_values->data;

         $user_type              = $user_values[0]["user_type_unique_id"];
         $staff_name             = $user_values[0]["staff_name"];
         $staff_id               = $user_values[0]["staff_id"];
         $mobile_no              = $user_values[0]["mobile_no"];
         $email_id               = $user_values[0]["email_id"];
         $user_name              = $user_values[0]["user_name"];
         // $zone_name              = $user_values[0]["zone_name"];
         // $ward_name              = $user_values[0]["ward_name"];
         $address                = $user_values[0]["address"];
         $password               = $user_values[0]["password"];
         $is_active              = $user_values[0]["is_active"];
         // $profile_image          = $user_values[0]["profile_image"];
         // $profile_status         = 1;
         // $securityquestion1      = $user_values[0]["securityquestion1"];
         // $securityquestion2      = $user_values[0]["securityquestion2"];
         // $securityquestion3      = $user_values[0]["securityquestion3"];
         // $document_type          = $user_values[0]["document_type"];
         // $document_number        = $user_values[0]["document_number"];
         // $otherProof_name        = $user_values[0]["otherProof_name"];
         if ($profile_image != '') {
            $profile_image_val = "uploads/user/" . $profile_image;
         } else {
            $profile_image_val = "uploads/user/user.png";
         }

         if ($document_type == 6) {
            $other_proof_name_class = "";
         } else {
            $other_proof_name_class = " display-none ";
         }


         $form_type          = "Update";
         $btn_text           = "Update";
         $btn_action         = "update";
      } else {
         $btn_text           = "Error";
         $btn_action         = "error";
         $is_btn_disable     = "disabled='disabled'";
      }
   }
}

$user_type_options  = user_type();
$user_type_options  = select_option($user_type_options, "Select User Type", $user_type);

// $zone_options      = zone_name();
// $zone_options      = select_option($zone_options, "Select Zone", $zone_name);

// $ward_options      = ward_name();
// $ward_options      = select_option($ward_options, "Select Ward", $ward_name);

$active_status_options = active_status($is_active);

$document_options        = [
   "1" => [
      "unique_id" => "1",
      "value"     => "PAN",
   ],
   "2" => [
      "unique_id" => "2",
      "value"     => "License",
   ],
   "3" => [
      "unique_id" => "3",
      "value"     => "Passport",
   ],
   "4" => [
      "unique_id" => "4",
      "value"     => "Voter Registration No.",
   ],
   "5" => [
      "unique_id" => "5",
      "value"     => "UID No.",
   ],
   "6" => [
      "unique_id" => "6",
      "value"     => "Other ID Proof",
      "type"      => "text",
   ],
];
$document_options        = select_option($document_options, "Select", $document_type);

?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">User Creations <?= $form_type; ?></h4>
            <div>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item ">User Creations</li>
                </ol>
            </div>
        </div>
    </div>
</div>
</br>
<!-- end page title --> 

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <form class="was-validated" autocomplete="off">
               <input type="hidden" name="profile_status" id="profile_status" class="form-control" value="<?= $profile_status; ?>">

               <div class="row">
                  <div class="col-12">
                     <div class="accordion" id="accordion" style="color: red;font-size: 18px;">Staff Profile</div>
                     <div class="panel" id="panel"><br>
                        <div class=" row ">
                           <!-- <label class="col-md-6" style="color: red">Staff Profile :</label> -->
                        </div>
                        <div class="row col-6">
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Staff Name</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="text" name="staff_name" id="staff_name" class="form-control" value="<?= $staff_name; ?>" required>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Staff Id</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="text" name="staff_id" id="staff_id" class="form-control" value="<?= $staff_id; ?>" required>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Mobile No.</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="text" id="mobile_no" name="mobile_no" class="form-control" onkeypress="number_only(event);" minlength="10" maxlength="10" value="<?php echo $mobile_no; ?>" required>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Email Id</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="mail" id="email_id" name="email_id" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $email_id; ?>" required>
                           </div><br><br><br>
                           <!-- <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Zone Name</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <select name="zone_name" id="zone_name" class="select2 form-control">
                                 <?php echo $zone_options; ?>
                              </select>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Ward Name</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <select name="ward_name" id="ward_name" class="select2 form-control">
                                 <?php echo $ward_options; ?>
                              </select>
                           </div><br><br><br> -->
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Image Upload</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <div class="image_area" style="width: 150px;">
                                 <label for="upload_image">
                                    <img src="<?= $profile_image_val; ?>" id="uploaded_image" class="img-responsive img-circle" />
                                    <div class="overlay">
                                       <div class="text">Click to Change Profile Image</div>
                                    </div>
                                    <input type="file" name="image" class="image" id="upload_image" style="display:none">
                                 </label>
                                 <input type="hidden" name="profile_image" id="profile_image" class="form-control" value="<?= $profile_image; ?>">
                              </div>
                           </div>
                        </div><br>
                     </div>
                     <div class="accordion" style="color: red;font-size: 18px;">User Details</div>
                     <div class="panel"><br>
                        <div class=" row ">
                           <!-- <label class="col-md-6" style="color: red;font-size: 18px;">User Details :</label> -->
                        </div>
                        <div class="row col-6">
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">User Type</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <select name="user_type" id="user_type" class="select2 form-control" required><?php echo $user_type_options; ?></select>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">User Name</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo $user_name; ?>" required>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Password</label>
                           <div class="col-6 col-xl-7 mrg-btm">
                              <input type="text" id="password" name="password" class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+.])[A-Za-z\d~!@#$%^&*()_+.]{8,}$" value="<?php echo $password; ?>" minlength="8" required>
                              <span id="StrengthDisp" class="badge displayBadge" style="color:red">Password must at least be 8 characters,one uppercase,one lowercase and one special character </span>

                           </div><br><br><br>
                           <div class="col-2 col-xl-2 mrg-btm">
                              <button type="button" id="button" class="btn btn-primary" onclick="generatePassword()">Generate</button>
                           </div><br><br><br>

                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Confirm Password</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $password; ?>" required>
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Active Status</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <select name="is_active" id="is_active" class="select2 form-control" required><?php echo $active_status_options; ?></select>
                           </div>
                        </div><br><br><br>
                     </div>
                     <div class="accordion" style="color: red;font-size: 18px;">Document Details</div>
                     <div class="panel">
                       
                        <div class="row col-6">
                           <label for="inputEmail3" class="col-4 col-xl-3  col-form-label">Document Type</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <select name="document_type" id="document_type" class="select2 form-control" onchange="get_other_proof_type(this.value)">
                                 <?php echo $document_options; ?>
                              </select>
                           </div><br><br><br>
                           <div class="">
                              <input type="text" id="otherProof_name" name="otherProof_name" class="form-control <?= $other_proof_name_class; ?> other_proof_name_class" value="<?php echo $otherProof_name; ?>" placeholder="Other Details">
                           </div>
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Document Number</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="text" id="document_number" name="document_number" class="form-control" value="<?php echo $document_number; ?>">
                           </div><br><br><br>
                        </div>
                        <div class="row col-6">
                           <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">Documents Upload</label>
                           <div class="col-8 col-xl-9 mrg-btm">
                              <input type="file" class="form-control dropify " data-default-file="" multiple id="doc_upload" name="doc_upload">
                           </div>
                        </div>
                     </div>
                     <div class="accordion" style="color: red;font-size: 18px;">Security Questions</div>
                     <div class="panel"><br>
                        <div class=" row ">
                           <!-- <label class="col-md-6" style="color: red;font-size: 18px;">Security Questions :</label> -->
                        </div>
                        <div class="row col-6">
                           <label for="inputEmail3" class="col-4 col-xl-5 col-form-label">What was your favorite school teacher’s name?</label>
                           <div class="col-8 col-xl-7 mrg-btm">
                              <input type="text" id="securityquestion1" name="securityquestion1" class="form-control" value="<?php echo $securityquestion1; ?>">
                           </div><br><br><br>
                           <label for="inputEmail3" class="col-4 col-xl-5 col-form-label">What city were you born in?</label>
                           <div class="col-8 col-xl-7 mrg-btm">
                              <input type="text" id="securityquestion2" name="securityquestion2" class="form-control" value="<?php echo $securityquestion2; ?>">
                           </div><br><br><br>
                           <!-- <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">What is your DOB?</label> -->
                           <label for="inputEmail3" class="col-4 col-xl-5 col-form-label">What school did you attend for sixth grade?</label>
                           <div class="col-8 col-xl-7 mrg-btm">
                              <input type="text" id="securityquestion3" name="securityquestion3" class="form-control" value="<?php echo $securityquestion3; ?>">
                           </div>
                           <div align="right" id="captcha"> </div>
                           <label for="inputEmail3" class="col-4 col-xl-5 col-form-label">Enter Above Code :</label>
                           <div class="col-8 col-xl-7 mrg-btm">
                              <input onkeyup="validateCaptcha()" minlength="6" id="captcha_code" name="captcha_code" class="form-control" type="text">
                              <span id="captcha_validate" class="badge displayBadge" style="color: red;text-align: left;font-size: 13px;font-weight: normal;">Invalid Captcha! Try again</span>
                           </div>
                        </div>
                     </div><br>
                     <div class="form-group row ">
                        <div class="col-md-12" align="right">
                           <!-- Cancel,save and update Buttons -->
                           <?php echo btn_cancel($btn_cancel); ?>
                           <a><?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?></a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div> <!-- end card-body -->
      </div><!-- end card -->
   </div><!-- end col -->





   <!-- Standard modal content -->
   <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="img-container">
                  <div class="row">
                     <div class="col-md-8">
                        <img src="" id="sample_image" />
                     </div>
                     <div class="col-md-4">
                        <div class="preview"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->


   <script>
      $(document).ready(function() {

         var $modal = $('#modal');

         var image = document.getElementById('sample_image');

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
                     url: 'upload.php',
                     method: 'POST',
                     data: {
                        image: base64data
                     },
                     success: function(data) {
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', data);
                        const myArray = data.split("/");
                        $("#profile_image").val(myArray[2]);
                     }
                  });
               };
            });
         });

      });


      let timeout;


      let password = document.getElementById('password')
      let strengthBadge = document.getElementById('StrengthDisp')

      let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
      let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')

      function StrengthChecker(PasswordParameter) {

         if (strongPassword.test(PasswordParameter)) {
            // strengthBadge.style.backgroundColor = "green"
            strengthBadge.textContent = 'Strong'
            strengthBadge.style.color = "#21b921"
            //strengthBadge.style.margin-left = "-114px"
         } else if (mediumPassword.test(PasswordParameter)) {
            //strengthBadge.style.backgroundColor = 'blue'
            strengthBadge.textContent = 'Medium'
            strengthBadge.style.color = "yellow"
         } else {
            //strengthBadge.style.backgroundColor = 'red'
            strengthBadge.textContent = 'Password must at least be 8 characters,one uppercase,one lowercase and one special character'
            strengthBadge.style.color = "red"
         }
      }


      password.addEventListener("input", () => {

         strengthBadge.style.display = 'block'
         clearTimeout(timeout);

         timeout = setTimeout(() => StrengthChecker(password.value), 500);

         if (password.value.length !== 0) {
            strengthBadge.style.display != 'block'
         } else {
            strengthBadge.style.display = 'none'
         }
      });

      var acc = document.getElementsByClassName("accordion");
      var i;

      for (i = 0; i < acc.length; i++) {
         acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
               panel.style.display = "none";
            } else {
               panel.style.display = "block";
            }
         });
      }

      $(document).ready(function() {
         $("#panel").css("display", "block");
         $('#accordion').addClass('active');
      });

      var code;

      function createCaptcha() {
         //clear the contents of captcha div first 
         document.getElementById('captcha').innerHTML = "";
         var charsArray =
            "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
         var lengthOtp = 6;
         var captcha = [];
         for (var i = 0; i < lengthOtp; i++) {
            //below code will not allow Repetition of Characters
            var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
            if (captcha.indexOf(charsArray[index]) == -1)
               captcha.push(charsArray[index]);
            else i--;
         }
         var canv = document.createElement("canvas");
         canv.id = "captcha";
         canv.width = 100;
         canv.height = 50;
         var ctx = canv.getContext("2d");
         ctx.font = "25px Georgia";
         ctx.strokeText(captcha.join(""), 0, 30);
         //storing captcha so that can validate you can save it somewhere else according to your specific requirements
         code = captcha.join("");
         document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
      }

      function validateCaptcha() {
         event.preventDefault();

         if (document.getElementById("captcha_code").value == code) {
            //alert('hello');
            //user_cu(unique_id = "");
            document.getElementById("captcha_validate").style.display = 'none';
         } else {
            //alert("Invalid Captcha. try Again");
            document.getElementById("captcha_validate").style.display = 'block';
         }
      }

      window.addEventListener('load', function() {

         createCaptcha();

      });

      function get_other_proof_type(document_type) {
         if (document_type == 6) {
            $('.other_proof_name_class').removeClass('display-none');
         } else {
            $('.other_proof_name_class').addClass('display-none');
         }
      }

      //var password=document.getElementById("password");

      // function genPassword() {
      //    var numberChars = "0123456789";
      //    var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      //    var lowerChars = "abcdefghijklmnopqrstuvwxyz";
      //    var specialChars = "~!@#$%^&*()_.";
      //    var chars = numberChars + upperChars + lowerChars + specialChars;
      //    var passwordLength = 12;
      //    var password = "";
      //    for (var i = 0; i <= passwordLength; i++) {
      //       var randomNumber = Math.floor(Math.random() * chars.length);
      //       password += chars.substring(randomNumber, randomNumber + 1);
      //    }
      //    document.getElementById("password").value = password;
      // }

      // JavaScript code for the password generator
      function generatePassword() {
         // Define variables containing possible characters for each type of requirement
         const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         const lowercase = 'abcdefghijklmnopqrstuvwxyz';
         const numbers = '0123456789';
         const special = '~!@#$%^&*()_+.';

         // Initialize variables for the password and each requirement
         let password = '';
         let upperCount = 0;
         let lowerCount = 0;
         let numberCount = 0;
         let specialCount = 0;

         // Generate password by selecting characters from each requirement until all requirements are met
         while (upperCount < 3 || lowerCount < 3 || numberCount < 2 || specialCount < 2) {
            let randomChar = '';
            if (upperCount < 3) {
               randomChar = uppercase[Math.floor(Math.random() * uppercase.length)];
               upperCount++;
            } else if (lowerCount < 3) {
               randomChar = lowercase[Math.floor(Math.random() * lowercase.length)];
               lowerCount++;
            } else if (numberCount < 2) {
               randomChar = numbers[Math.floor(Math.random() * numbers.length)];
               numberCount++;
            } else if (specialCount < 2) {
               randomChar = special[Math.floor(Math.random() * special.length)];
               specialCount++;
            }
            password += randomChar;
         }

         // Display generated password in the textbox
         document.getElementById('password').value = password;
      }
   </script>
