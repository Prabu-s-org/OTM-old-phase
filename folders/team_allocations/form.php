<!-- This file Only PHP Functions -->
<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;
$eng_name          = "";
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "team_allocation";

        $columns    = [
            "region"  ,
            "state_name",

           "district_name",

            "po_no",
            "consignee_address" ,
            "consignee_name" ,
            "consignee_district",
            // "eng_name"   ,
            "(SELECT GROUP_CONCAT(staff_name SEPARATOR ', ') 
         FROM user 
         WHERE FIND_IN_SET(user.unique_id, team_allocation.eng_name)) AS eng_name",
            "user_role" ,
                "is_active",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
// print_r($result_values);
        if ($result_values->status) {

            $result_values      = $result_values->data;

            $region          = $result_values[0]["region"];
            $state_name          = $result_values[0]["state_name"];
            $district_name          = $result_values[0]["district_name"];
            $po_no          = $result_values[0]["po_no"];
           $consignee_address          = $result_values[0]["consignee_address"];
            $consignee_name          = $result_values[0]["consignee_name"];
            $consignee_district          = $result_values[0]["consignee_district"];
            $eng_name    = $result_values[0]["eng_name"];
             $user_role    = $result_values[0]["user_role"];
            $is_active          = $result_values[0]["is_active"];

            // $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}


$state_type_options = state_option();
$state_type_options = select_option($state_type_options, "Select State", $state_name);

$district_type_options = district_option();
$district_type_options = select_option($district_type_options, "Select District", $district_name);

$po_num_options = po_numers();
$po_num_options = select_option($po_num_options, "Select PO No", $po_no);


$consignee_address_options = consignee_option_sub();
$consignee_address_options = select_option($consignee_address_options, "Select Consignee Address", $consignee_address);
// print_r($consignee_address_options);

$eng_name_options = engineer_name_options();
$eng_name_options = select_option($eng_name_options, "Select Engineer Name", $eng_name);
// print_r($eng_name_options);
$active_status_options   = active_status($is_active);

// Generate options for the Service Engineer dropdown
$eng_name_options = "";
if (!empty($eng_name)) {
    $eng_name_array = explode(", ", $eng_name); // Convert comma-separated string into an array

    foreach ($eng_name_array as $name) {
        $eng_name_options .= "<option value=\"$name\" selected>$name</option>";
    }
}

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Team Allocation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                 <div class="col-xl-6">
                                   <div class="mb-3">
                                    <label class="form-label">Region</label>
                                   <select name="region" id="region" class="select2 form-control" required>
    <option value="">Select Region</option>
    <option value="north" <?php echo ($region == 'north') ? 'selected' : ''; ?>>North</option>
    <option value="east" <?php echo ($region == 'east') ? 'selected' : ''; ?>>East</option>
    <option value="west" <?php echo ($region == 'west') ? 'selected' : ''; ?>>West</option>
    <option value="south" <?php echo ($region == 'south') ? 'selected' : ''; ?>>South</option>
</select>
                                </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">State Name</label>
                                        <select name="state_name" id="state_name" class="select2 form-control" required onchange="get_district_name()"
                                            >
                                            <?php echo $state_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                               
                            </div>
                            <div class="row">
                                 <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">District Name</label>
                                        <select name="district_name" id="district_name" class="select2 form-control" 
                                            required>
                                            
                                            <?php echo $district_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">PO No</label>
                                        <select name="po_no" id="po_no" class="select2 form-control" required >
                                            <?php echo $po_num_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee Address</label>
                                        <select name="consignee_address" id="consignee_address" class="select2 form-control" required onchange="get_consignee_name(); get_con_district();">
                                            <?php echo $consignee_address_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee Name</label>
                                         <input type="text" id="consignee_name" name="consignee_name" class="form-control" value="<?php echo $consignee_name; ?>" required readonly>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee District</label>
                                        <input type="text" id="consignee_district" name="consignee_district" class="form-control" value="<?php echo $consignee_district; ?>" required readonly >
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Operation Team Members</label>
                                        <select class="selectpicker" id="eng_name" name="eng_name[]" multiple data-live-search="true">
                                            <?php echo $eng_name_options; ?>
                                        </select> 
                                        
                                        </div>
                                </div><!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Role</label>
                                        <input name="user_role" id="user_role" class="select2 form-control" value="<?php echo $user_role; ?>" required >
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                   
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

 <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
$(document).ready(function() {
    $('#eng_name').select2({
        placeholder: "Select Service Engineer(s)",
        allowClear: true
    });
});


document.getElementById("eng_name").addEventListener("change", function () {
    let selectedValues = Array.from(this.selectedOptions).map(option => option.value);
    console.log("Selected Engineers:", selectedValues);

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: { action: "engineer_role_option", eng_name: JSON.stringify(selectedValues) }, // Send as JSON
        dataType: "json",
        success: function (response) {
            console.log("AJAX Response:", response); // Debugging log

            if (response.success) {
                $("#user_role").val(response.user_roles); // No need to use .join() as it's already joined in PHP
            } else {
                $("#user_role").val(""); // Clear if no data found
                alert(response.message); // Show error message
            }
        },
        error: function () {
            alert("Error fetching engineer role.");
        }
    });
});





function validateName(input) {
  // alert('test');
    input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove special characters & numbers
}

function get_consignee_name() {
    var consignee_address = $("#consignee_address").val().trim(); // Trim input to avoid extra spaces

    if (consignee_address === "") {
        $("#consignee_name").val(""); // Clear field if empty
        return;
    }

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: { action: "consignee_name_option", consignee_address: consignee_address },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#consignee_name").val(response.consignee_name);
            } else {
                $("#consignee_name").val(""); // Clear field if no data found
                alert(response.message); // Show error message from the server
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error fetching consignee name. Please try again.");
        }
    });
}
function get_con_district() {
    var consignee_address = $("#consignee_address").val().trim(); // Trim input to avoid extra spaces

    if (consignee_address === "") {
        $("#consignee_district").val(""); // Clear field if empty
        return;
    }

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: { action: "consignee_district_option", consignee_address: consignee_address },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#consignee_district").val(response.consignee_district); // ✅ Correct key
            } else {
                $("#consignee_district").val(""); // Clear field if no data found
                alert(response.message); // Show error message from the server
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Error fetching consignee district. Please try again.");
        }
    });
}



function get_engineer_role() {
    var eng_name = $("#eng_name").val(); 
    alert(eng_name);
    console.log("Selected Engineer Name:", eng_name); // Debugging log

    if (eng_name === "") {
        $("#user_role").val(""); // Clear user_role if no engineer selected
        return;
    }

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: { action: "engineer_role_option", eng_name: eng_name },
        dataType: "json",
        success: function (response) {
            console.log("AJAX Response:", response); // Debugging log

            if (response.success) {
                $("#user_role").val(response.user_role); // Correctly setting the value
            } else {
                $("#user_role").val(""); // Clear if no data found
                alert(response.message); // Show error message
            }
        },
        error: function () {
            alert("Error fetching engineer role.");
        }
    });
}

    </script>

