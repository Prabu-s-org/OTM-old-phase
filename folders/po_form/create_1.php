<?php
// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$tax_select_status = "";

$is_active = 1;

// echo $_SESSION['user_type_unique_id'];

if (isset($_GET["batch_id"])) {
    if (!empty($_GET["batch_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id = $_GET["batch_id"];
        // $where      = [
        //     "unique_id" => $_GET["unique_id"]
        // ];

        $where = "batch_id = '" . $_GET["batch_id"] . "'";
        $table = "consignee_details_sub";

        // $table_vendorallocation = 'consignee_details_sub';

        $columns = [
            "form_main_unique_id",
            "po_number",
            // "po_date",
            "con_address",
            "con_district",

            "con_state_name",
            "con_pincode",
            "zone",
            "con_contact_name",
            "con_contact_number",
            "consignee_received_date",
            // "bill_address",
            // "contact_name",
            // "contact_number",
            // "landline_number",
            // "email",
            // "district",
            // "pin",
            // // "po_prepared_by",
            // "po_type",
            // "no_of_po",
            // "delivery_due_dates",
            // "ld_per_day",
            // "ld_maximum_val",
            // "warranty",
            // "warranty_duration",
            // "ins_reqired",
            // // "bank_required",
            // "dc_required",
            // "bg",
            // "bg_month",
            // "file_name",
            // "file_org_name",
            "unique_id",
           
           
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        //  print_r($result_values);

        if ($result_values->status) {

            $result_values = $result_values->data;
            $form_main_unique_id = $result_values[0]["form_main_unique_id"];

            $po_number = $result_values[0]["po_number"];
            $po_date = $result_values[0]["po_date"];
            $con_address = $result_values[0]["con_address"];
            $con_district = $result_values[0]["con_district"];
            $con_state_name = $result_values[0]["con_state_name"];
            $con_pincode = $result_values[0]["con_pincode"];
            $zone = $result_values[0]["zone"];
            $con_contact_name = $result_values[0]["con_contact_name"];

            $con_contact_number = $result_values[0]["con_contact_number"];
            $consignee_received_date = $result_values[0]["consignee_received_date"];
         


            // print_r($vendor_zone);die();/

            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}


if ($_GET["unique_id"] != '') {
    $unique_id = $_GET["unique_id"];
} else {
    $prefix = "PO";
    $unique_id = unique_id($prefix);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consignee Management</title>
</head>
<body>
    <h2>Consignee List</h2>
   <form id="editConsigneeForm">

                    <input type="hidden" class="form-control" id="up_stored_consignee" name="up_stored_consignee">
                        <input type="text" id="batch_id_holder" name="batch_id_holder"  value="<?php echo  $_GET["batch_id"];?>"/>
                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" class="form-control" id="up_con_address" name="up_con_address" value="<?php echo $con_address; ?> ">
                    </div>
                    <div class="mb-2">
                        <label>State</label>
                        <select name="up_con_state_name" id="up_con_state_name" class="select2 form-control"
                            onchange="up_con_get_district(this.value);" required >
                            <?php echo $con_state_name; ?>
                        </select>
                        <input type="hidden" class="form-control" id="up_con_state_id" name="up_con_state_id"
                            oninput="handleInput(event)">
                    </div>
                    <div class="mb-2">
                        <label>District</label>
                        <select name="up_con_district" id="up_con_district" class="select2 form-control" required>
                             <?php echo $con_state_name; ?>
                        </select>
                        <input type="hidden" class="form-control" id="up_con_district_id" name="up_con_district_id">
                        <!--<input type="text" class="form-control" id="up_con_district" name="up_con_district" >-->
                    </div>
                    <div class="mb-2">
                        <label>Zone</label>
                        <input type="text" class="form-control" id="up_zone" name="up_zone">
                    </div>
                    <div class="mb-2">
                        <label>Pincode</label>
                        <input type="text" class="form-control" id="up_con_pincode" name="up_con_pincode">
                    </div>

                    <div class="mb-2">
                        <label>Contact Name</label>
                        <input type="text" class="form-control" id="up_con_contact_name" name="up_con_contact_name"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" id="up_con_contact_number" name="up_con_contact_number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Landline</label>
                        <input type="text" class="form-control" id="up_con_lan_num" name="up_con_lan_num"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="mb-2">

                        <label>Assign Team Member</label>
                        <select name="up_assign_team_member" id="up_assign_team_member" class="select2 form-control"
                            required>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>GST</label>
                        <input type="text" class="form-control" id="up_consignee_gst" name="up_consignee_gst"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Status</label>
                        <select class="form-select" id="up_verify_sts" name="up_verify_sts">
                            <!--<option value=""></option>-->

                            <!--<option value="1">Verified</option>-->
                            <!--<option value="2">Not Verified</option>-->
                        </select>
                    </div>
                     <button type="button" onclick="change_verify_address()" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                </form>
            </body>
</html>

