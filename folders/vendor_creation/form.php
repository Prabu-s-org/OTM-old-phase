<!-- This file Only PHP Functions -->
<style>
    button#export {
        float: right;
        padding: 5px 10px;
    }

    #icon {
        font-size: x-large;
    }
</style>
<?php include 'simplexlsx.php'; ?>
<?php
require_once("assets/PHPExcel-1.8/Classes/PHPExcel.php");
?>
<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text              = "Save";
$btn_action            = "create";
$is_btn_disable        = "";
$unique_id             = "";
$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";
$is_active = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];
        $table = "vendor_creation";
        $columns = [
            "company_name",
            "name",
            "contact_no",
            "alt_contact_no",
            "mail_id",
            "pan_no",
            "gst_no",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
            "district_name",
            "acc_holder_name",
            "vendor_id",
            "zone_name",
            "state_name",
            "pincode",
            "user_name",
            "password",
            "pan_attach_file_name",
            "bank_proof",
            "confirm_password",
            "is_active"
        ];
        $table_details = [
            $table,
            $columns
        ];
        $result_values = $pdo->select($table_details, $where);
        if ($result_values->status) {
            $result_values = $result_values->data;
            
            $comp_name = $result_values[0]["company_name"];
            $name = $result_values[0]["name"];
            $vendor_id = $result_values[0]["vendor_id"];
            $mail_id = $result_values[0]["mail_id"];
            $contact_no = $result_values[0]["contact_no"];
            $alt_contact_no = $result_values[0]["alt_contact_no"];
            $pan_no = $result_values[0]["pan_no"];
            $gst_no = $result_values[0]["gst_no"];
            $address = $result_values[0]["address"];
            $account_no = $result_values[0]["account_no"];
            $ifsc_code = $result_values[0]["ifsc_code"];
            $bank_name = $result_values[0]["bank_name"];
            $branch_name = $result_values[0]["branch_name"];
            $district_name = $result_values[0]["district_name"];
            $zone_name = $result_values[0]["zone_name"];
            $acc_holder_name = $result_values[0]["acc_holder_name"];
            $state_name = $result_values[0]["state_name"];
            $pincode = $result_values[0]["pincode"];
             $pan_filename = $result_values[0]["pan_attach_file_name"];
             $bank_filename  = $result_values[0]["bank_proof"];
              
            $user_name = $result_values[0]["user_name"];
            $my_password = $result_values[0]["password"];
            $confirm_password = $result_values[0]["confirm_password"];


            $is_active = $result_values[0]["is_active"];
            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

$state_type_options = state_option();
$state_type_options = select_option($state_type_options, "Select State", $state_name);

$district_type_options = district_option();
$district_type_options = select_option($district_type_options, "Select District", $district_name);


$active_status_options = active_status($is_active);
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Vendor Creation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">Vendor Creation </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="col-xxl-12 cf">
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <form class="was-validated" autocomplete="off">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Company name</label>
                                            <input type="text" id="company_name" name="company_name"
                                                oninput="validateNameNum(this)" class="form-control"
                                                value="<?php echo $comp_name;?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" id="name" name="name" oninput="validateName(this)"
                                                class="form-control" value="<?php echo $name ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Contact no</label>
                                            <input type="text" id="contact_no" name="contact_no"
                                                oninput="validateNum(this)" class="form-control" maxlength="10"
                                                value="<?php echo $contact_no; ?>" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Alternative Contact No</label>
                                            <input type="text" id="alt_contact_no" name="alt_contact_no"
                                                oninput="validateNum(this)" class="form-control" maxlength="10"
                                                value="<?php echo $alt_contact_no; ?>">
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Mail ID</label>
                                            <input type="text" id="mail_id" name="mail_id" oninput="validateEmail(this)"
                                                class="form-control" value="<?php echo $mail_id; ?>">
                                            <span id="email_error" class="text-danger" style="display:none;"></span>

                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Pan No</label>
                                            <input type="text" id="pan_no" name="pan_no" class="form-control"
                                                oninput="validatePAN(this)" value="<?php echo $pan_no ?>" >
                                            <span id="pan_error" class="text-danger" style="display:none;"></span>

                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-6 mt-2">
                                            <label class="form-label">GST No</label>
                                            <input type="text" id="gst_no" name="gst_no" class="form-control"
                                                oninput="validateGST(this)" maxlength="15" value="<?php echo $gst_no ?>"
                                                >
                                            <span id="gst_error" class="text-danger" style="display:none;">Invalid GST
                                                Number</span>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">State Name</label>
                                            <select name="state_name" id="state_name" class="select2 form-control"
                                                required onchange=get_district();>
                                                <?php echo $state_type_options; ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">District Name</label>
                                            <select name="district_name" id="district_name" class="select2 form-control"
                                                required>

                                                <?php echo $district_type_options; ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Zone Name</label>
                                            <input type="text" id="zone_name" name="zone_name"
                                                oninput="validateName(this)" class="form-control"
                                                value="<?php echo $zone_name ?>">
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" id="pincode" name="pincode" class="form-control"
                                                oninput="validateNum(this)" maxlength="6" value="<?php echo $pincode ?>"
                                                required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text" id="bank_name" name="bank_name"
                                                oninput="validatebank(this)" class="form-control"
                                                value="<?php echo $bank_name ?>" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Branch Name</label>
                                            <input type="text" id="branch_name" name="branch_name"
                                                oninput="validatebank(this)" class="form-control"
                                                value="<?php echo $branch_name ?>" required>
                                        </div>

                                         <div class="col-6 mt-2">
                                            <label class="form-label">Account Holder Name</label>
                                            <input type="text" id="acc_holder_name" name="acc_holder_name"
                                                oninput="validatebank(this)" class="form-control"
                                                value="<?php echo $acc_holder_name; ?>">
                                         </div>

                                        <div class="col-6 mt-2 d-flex align-items-center gap-2">
                                            
                                            <div class="flex-grow-1">
                                                <label class="form-label">Pan Copy Attach</label>
                                                <input type="file" id="pan_file" 
                                                    accept="application/pdf,image/jpeg,image/png,image/jpg" 
                                                    name="pan_file" class="form-control">

                                                <input type="hidden" id="old_pan_file" name="old_pan_file" value="<?php echo $pan_filename;?>">
                                            </div>

                                            <div id="pan_preview" class="ms-2">
                                                <?php if (!empty($pan_filename)) { 
                                                    $ext = strtolower(pathinfo($pan_filename, PATHINFO_EXTENSION));

                                                    if ($ext == 'pdf') { ?>
                                                        
                                                        <a href="/otm_beta/uploads/vendor_creation/<?php echo $pan_filename; ?>" target="_blank">
                                                            <img src="/otm_beta/uploads/vendor_creation/pdf.png"
                                                                width="50" height="50" style="cursor:pointer;">
                                                        </a>

                                                    <?php } else { ?>
                                                        
                                                        <a href="/otm_beta/uploads/vendor_creation/<?php echo $pan_filename; ?>" target="_blank">
                                                            <img src="/otm_beta/uploads/vendor_creation/<?php echo $pan_filename; ?>"
                                                                width="50" height="50"
                                                                style="object-fit:cover; border:1px solid #ccc; cursor:pointer;">
                                                        </a>

                                                    <?php } ?>
                                                <?php } ?>
                                            </div>

                                        </div>




                                        <div class="col-6 mt-2 d-flex align-items-center gap-2">

                                        <div class="flex-grow-1">
                                            <label class="form-label">Bank Proof Attach</label>
                                            <input type="file" id="bank_proof_file" accept="application/pdf" name="bank_proof_file" class="form-control">
                                            <!-- Hidden field to hold existing file name -->
                                             <input type="hidden" id="old_bank_file" value="<?php echo $bank_filename; ?>">
                                            
                                        </div>

                                        <div id="bank_preview" class="ms-2">

                                        <?php if(!empty($bank_filename)) {

                                         $ext = strtolower(pathinfo($bank_filename, PATHINFO_EXTENSION));

                                         if($ext == 'pdf'){ ?>

                                          <a href="/otm_beta/uploads/vendor_creation/<?php echo $bank_filename; ?>" target="_blank">
                                                            <img src="/otm_beta/uploads/vendor_creation/pdf.png"
                                                                width="50" height="50" style="cursor:pointer;">
                                                        </a>
                                            
                                        <?php } else{?>

                                             <a href="/otm_beta/uploads/vendor_creation/<?php echo $bank_filename; ?>" target="_blank">
                                                            <img src="/otm_beta/uploads/vendor_creation/<?php echo $bank_filename; ?>"
                                                                width="50" height="50"
                                                                style="object-fit:cover; border:1px solid #ccc; cursor:pointer;">
                                                        </a>

                                       <?php } ?>

                                       <?php }?>
                                        </div>
                                        </div>

                                        <div class="col-6 mt-2">
                                            <label class="form-label">Account No</label>
                                            <input type="text" id="account_no" name="account_no"
                                                oninput="validatebankacc(this)" class="form-control" maxlength="20"
                                                value="<?php echo $account_no ?>" required>
                                            <span id="accno_error" class="text-danger" style="display:none;"></span>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">IFSC Code</label>
                                            <input type="text" id="ifsc_code" name="ifsc_code"
                                                oninput="validateNameNum(this)" class="form-control"
                                                value="<?php echo $ifsc_code ?>" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Address</label>
                                            <textarea id="address" name="address" class="form-control"
                                                oninput="validateAddress(this)" rows="4"
                                                required><?php echo $address; ?></textarea>
                                        </div>
                                        <input type="hidden" id="vendor_user_type_unique_id"
                                            name="vendor_user_type_unique_id" class="form-control"
                                            value="67e7997ad327489044" required>
                                        <input type="hidden" id="vendor_id" name="vendor_id" class="form-control"
                                            value="<?php echo $vendor_id; ?>" required>

                                            <div class="col-6 mt-3">
                                            <label class="form-label">User Name</label>
                                            <input type="text" id="user_name" name="user_name"
                                                oninput="validateNameNum(this)" class="form-control"
                                                value="<?php echo $user_name ?>" required readonly>
                                        </div>
                                    </div>

                                          <input type="hidden" id="unique_id" name="unique_id" value="<?php echo $unique_id; ?>">
                                    <div class="row">
                                        

                                        <div class="col-6">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control" value="<?php echo $my_password;?>" required>
                                                <span class="input-group-text toggle-password" toggle="#password"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" id="confirm_password" name="confirm_password"
                                                    class="form-control" value="<?php echo $confirm_password ?>"
                                                    required>
                                                <span class="input-group-text toggle-password"
                                                    toggle="#confirm_password" style="cursor: pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                    </div>
                                    <br>
                                    <div class="form-group row ">
                                        <div class="col-md-12" align="right">
                                            <?php echo btn_cancel($btn_cancel); ?>
                                            <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>

<!-- <script src="jquery-3.5.1.min.js"></script>   -->
<script>

function get_district() {



var state_name = $('#state_name').val();
get_ven_id();
// alert(state_name);

var data = "state_name=" + state_name + "&action=get_district_by_state";

var ajax_url = sessionStorage.getItem("folder_crud_link");

$.ajax({
    type: "POST",
    url: ajax_url,
    data: data,
    success: function (data) {


        if (data) {
            $("#district_name").html(data);
        }
    }
});

}
    $('#state_name').on('change', function () {
// alert();
        var state_name = $('#state_name').val();
        //    alert(state_name);
          
        var data = "&state_name=" + state_name + "&action=district_type_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
       
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#district_name").html(data);
                }
            }
        });

    })

    $(document).ready(function () {
        var unique_id = new URLSearchParams(window.location.search).get("unique_id"); // Get unique_id from URL

        if (!unique_id) { // Run only if unique_id is empty
            var data = "&action=vendoridgen";
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
                    if (data) {
                        $("#vendor_id").val(data); // Set the value of the input field
                    }
                }
            });
        }
    });
    // get_ven_id();

document.getElementById('pan_file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const previewBox = document.getElementById('pan_preview');

    if (file) {
        const fileURL = URL.createObjectURL(file);
        let previewHTML = '';

        // Check if PDF
        if (file.type === "application/pdf") {
            previewHTML = `<a href="${fileURL}" target="_blank" class="btn btn-sm  mt-1">
                              <img src="/otm_beta/uploads/pdf.png"width="60" height="60" style="object-fit:contain; cursor:pointer;">
                           </a>`;
        } else {
            // For image preview
           previewHTML = `
                <a href="${fileURL}" target="_blank" class="mt-1 d-inline-block">
                    <img src="${fileURL}" width="120" height="120" style="object-fit:cover; border:1px solid #ccc; cursor:pointer;">
                </a>
            `;
        }

        previewBox.innerHTML = previewHTML;
    }
});


document.getElementById('bank_proof_file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const previewBox = document.getElementById('bank_preview');

    if (file) {
        const fileURL = URL.createObjectURL(file);
        let previewHTML = '';

        // Check if PDF
        if (file.type === "application/pdf") {
            previewHTML = `<a href="${fileURL}" target="_blank" class="btn btn-sm  mt-1">
                              <img src="/otm_beta/uploads/pdf.png"width="60" height="60" style="object-fit:contain; cursor:pointer;">
                           </a>`;
        } else {
            // For image preview
           previewHTML = `
                <a href="${fileURL}" target="_blank" class="mt-1 d-inline-block">
                    <img src="${fileURL}" width="120" height="120" style="object-fit:cover; border:1px solid #ccc; cursor:pointer;">
                </a>
            `;
        }

        previewBox.innerHTML = previewHTML;
    }
});


    function get_ven_id(){

        // alert("hiii");
        var state_name = $('#state_name').val();
        //    alert(state_name);
        document.getElementById('user_name').value = '';
        var data = "&state_name=" + state_name + "&action=vendor_id_creation";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        // get_ven_id();
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    // alert(data);
                    document.getElementById('user_name').value = data;
                    // $("#user_name").html(data);
                }
            }
        });




    }

    document.querySelectorAll('.toggle-password').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const input = document.querySelector(toggle.getAttribute('toggle'));
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            const icon = toggle.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });


    function validateName(input) {
        input.value = input.value.replace(/[^A-Za-z,./-\s]/g, ''); // Allow letters, numbers, and spaces
    }

    function validateNum(input) {
        input.value = input.value.replace(/[^0-9\s]/g, ''); // Allow letters, numbers, and spaces
    }

    function validateNameNum(input) {
        input.value = input.value.replace(/[^A-Za-z0-9\s]/g, ''); // Allow letters, numbers, and spaces
    }

    function validateAddress(input) {
        input.value = input.value.replace(/[^A-Za-z0-9-,./ \s]/g, ''); // Allow letters, numbers, and spaces
    }



    function validatebank(input) {
        input.value = input.value.replace(/[^A-Za-z0-9\s]/g, ''); // Allow letters, numbers, and spaces
    }


    function validatebankacc(input) {
        // Remove non-digit characters
        input.value = input.value.replace(/\D/g, '');

        let accno_error = document.getElementById("accno_error");

        // Limit to 12 digits
        if (input.value.length > 20) {
            input.value = input.value.slice(0, 20);
        }

        // Validate length
        // if (input.value.length !== 20) {
        //     accno_error.style.display = "inline";
        //     accno_error.innerText = "Account number must be exactly 20 digits";
        //     return false;
        // } else {
        //     accno_error.style.display = "none"; // Hide error once valid
        // }

        return true;
    }



    function validateGST(input) {
        let gstError = document.getElementById("gst_error");

        // Allow only numbers [0-9] and uppercase letters [A-Z]
        input.value = input.value.toUpperCase().replace(/[^0-9A-Z]/g, '');

        // GST number regex pattern (Valid when exactly 15 characters)
        let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;

        if (input.value.length === 15 && gstRegex.test(input.value)) {
            gstError.style.display = "none"; // Hide error if valid
        } else {
            gstError.style.display = "inline"; // Show error while typing
            gstError.innerText = "Invalid GST Format"; // Error message
        }
    }

    function mail_valid(input) {

        const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            ' ', '_', '.', '@'];

        // Filter out characters that are not in the allowedChars array
        input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
    }


    function validateEmail(input) {
        let emailError = document.getElementById("email_error");

        // Allow only valid email characters
        input.value = input.value.replace(/[^a-zA-Z0-9@._-]/g, '');

        // Email validation regex pattern
        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (emailRegex.test(input.value)) {
            emailError.style.display = "none"; // Hide error if valid
        } else {
            emailError.style.display = "inline"; // Show error while typing
            emailError.innerText = "Invalid email format";
        }
    }


    function validatePAN(input) {
        let panError = document.getElementById("pan_error");

        // Allow only uppercase letters [A-Z] and numbers [0-9]
        input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

        // PAN validation regex pattern (5 letters, 4 digits, 1 letter)
        let panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

        if (panRegex.test(input.value)) {
            panError.style.display = "none"; // Hide error if valid
        } else {
            panError.style.display = "inline"; // Show error while typing
            panError.innerText = "Invalid PAN format (e.g., ABCDE1234F)";
        }
    }



</script>
