<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

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

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];

        $table      =  "consignee_creation";

        $columns    = [

            "consignee_address",
            "consignee_district",
            "consignee_pincode",
            "consignee_contactnumber",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;
            $consignee_address = $result_values[0]["consignee_address"];
           $consignee_district = $result_values[0]["consignee_district"];
            $consignee_pincode = $result_values[0]["consignee_pincode"];
            $consignee_contactnumber = $result_values[0]["consignee_contactnumber"];
            $is_active          = $result_values[0]["is_active"];


            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}


$district_option = district_option();
$district_option = select_option($district_option, "Select District", $consignee_district);

$active_status_options   = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Consignee Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee Address</label>
                                        <input type="text" id="consignee_address" name="consignee_address" oninput="validateAddress(this)" class="form-control" value="<?php echo $consignee_address; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee District</label>
                                        <select name="consignee_district" id="consignee_district" class="select2 form-control" required>
                                            <?php echo $district_option; ?></select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee Pincode</label>
                                        <input type="text" id="consignee_pincode" name="consignee_pincode" class="form-control" maxlength="6" value="<?php echo $consignee_pincode; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consignee Contact Number</label>
                                        <input type="text" id="consignee_contactnumber" name="consignee_contactnumber" oninput="validateNum(this)" maxlength="10" class="form-control" value="<?php echo $consignee_contactnumber; ?>" required>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
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
<script>
     document.getElementById('consignee_pincode').addEventListener('input', function(event) {
      const pincodeInput = event.target.value;


      const numericValue = pincodeInput.replace(/\D/g, '');

      
      const sanitizedValue = numericValue.slice(0, 6);

      event.target.value = sanitizedValue;
    });


function validateName(input) {
    input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Allow letters, numbers, and spaces
}

function validateAddress(input) {
    input.value = input.value.replace(/[^A-Za-z0-9,-\s]/g, ''); // Allow letters, numbers, and spaces
}

function validateNum(input) {
    input.value = input.value.replace(/[^0-9\s]/g, ''); // Allow letters, numbers, and spaces
}


</script>
