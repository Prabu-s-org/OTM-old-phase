<style>
    /*.multisteps-form__form .was-validated .clearfix{ height:100% !important;}*/
    /*.multisteps-form__panel.js-active{ position:none    }*/

    footer.footer {
        position: fixed;
        z-index: -1;
    }

    .dt-buttons {
        margin-bottom: 10px;
    }

    .img {
        width: 49px;
        margin-top: 18px;
        /* margin-right:200px; */
    }

    form.was-validated button {
        float: inline-start;
    }

    #unregistered_message {
        font-size: 15px;
        color: red;

    }

    .modal .bs-example-modal-xl {
        position: relative !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #1A7DB7;
        color: white;
    }

    .red-star {
        color: red;
        font-size: 20px;
        vertical-align: middle;
        margin-left: 5px;
    }

    .alert-simple.alert-danger {
        border: 1px solid rgba(241, 6, 6, 0.81);
        background-color: rgba(220, 17, 1, 0.16);
        box-shadow: 0px 0px 2px #ff0303;
        color: #ff0303;
        /* text-shadow: 2px 1px #00040a; */
        transition: 0.5s;
        cursor: pointer;
    }

    .alert-danger:hover {
        background-color: rgba(220, 17, 1, 0.33);
        transition: 0.5s;
    }


    /* Custom styling for better appearance */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        padding: 6px;
        min-height: 38px;
    }

    #mddd {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 174%;
        margin-left: -208px;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0;
    }

    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 114%;
        pointer-events: auto;
        background-color: $modal-content-bg;
        background-clip: padding-box;
        border: $modal-content-border-width solid $modal-content-border-color;
        @include border-radius($modal-content-border-radius);
        @include box-shadow($modal-content-box-shadow-xs);
        // Remove focus outline from opened modal
        outline: 0;
    }

    .actions1 {

        margin-top: 49px;
        margin-left: 59%;
    }

    .actions1 ul {
        /*display: flex;*/
        justify-content: space-between;
        /* This will space out the buttons to the left and right */
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .actions1 li {
        display: inline-block;
    }

    .action-left {
        margin-right: auto;
    }

    .js-btn-prev,
    .js-btn-next {
        display: inline-block;
    }


    .select2-container {
        width: 100% !important;
    }

    .detail-row td {
        background-color: #f9f9f9;
    }

    .my-row-even {
        background-color: #f0f8ff;
    }

    .my-row-odd {
        background-color: #e6f7ff;
    }

    .select2-container .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }

    .table>:not(caption)>*>* {
        font-size: 14px;
    }


    th {
        text-align: center !important;
    }


    .mode-selector {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .mode-selector input[type="radio"] {
        display: none;
    }

    .mode-selector label {
        padding: 10px 25px;
        border: 2px solid #0d6efd;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 500;
        transition: 0.3s;
        color: #0d6efd;
        background-color: white;
    }

    .mode-selector input[type="radio"]:checked+label {
        background-color: #0d6efd;
        color: white;
    }

    .mode-label {
        text-align: center;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .amc_datatable {
        overflow: auto;
        width: 79% !important;
        margin-left: -28px;
    }

    .actions1 {
        margin-top: 49px;
        margin-left: 59%;
    }

    .actions1 ul {
        justify-content: space-between;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .actions1 li {
        display: inline-block;
    }

    .action-left {
        margin-right: auto;
    }

    .multisteps-form__progress-btn.finished::after {
        content: '✔';
        color: green;
        margin-left: 4px;
    }

    /* , */
    /* #assignQty_third_tab, */
    /* #terms_third_tab */
    /* #product_third_tab, */
    /* #po_tabs,
#third_tab {
  display: none;
} */

    #po_tabs.js-active,
    #third_tab.js-active {
        display: block;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Add Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<?php
require_once __DIR__ . '/../../config/env.php';
include 'function.php'; ?>
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

// $_SESSION['user_type_unique_id'] == "65efd97b4df4040205";
// echo $_SESSION['user_type_unique_id'];

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id = $_GET["unique_id"];
        // $where      = [
        //     "unique_id" => $_GET["unique_id"]
        // ];

        $where = "unique_id = '" . $_GET["unique_id"] . "'";

        $table = "po_form";

        $table_vendorallocation = 'vendor_allocation';

        $columns = [
            "po_unique_id",
            "po_num",
            "po_date",
            "state_name",
            "district",
            "department",
            "gst_option",
            "gst_value",
            "executive_name",
            "bill_address",
            "contact_name",
            "contact_number",
            "landline_number",
            "email",
            "district",
            "pin",
            // "po_prepared_by",
            "po_type",
            "no_of_po",
            "delivery_due_dates",
            "ld_per_day",
            "ld_maximum_val",
            "warranty",
            "warranty_duration",
            "ins_reqired",
            // "bank_required",
            "dc_required",
            "bg",
            "bg_month",
            "file_name",
            "file_org_name",
            "unique_id",
            "no_of_consignee",
            "is_active",
            "state_name",
            "amc_required",
            "insurence_required",
            "ld_required",
            "ld_installation_due_date",
            "ld_delivery_due_date",
            "ld_date_type",
            "insurence_types",
            "other_insurance_type",
            "acc_vertical",
            "(select sector_name from account_sector where account_sector.unique_id=po_form.acc_sector) as acc_sector_name",
            "acc_sector",
            "status",

            'unique_id'
            // 
            //     "(SELECT GROUP_CONCAT(staff_name SEPARATOR ', ') 
            //  FROM user 
            //  WHERE FIND_IN_SET(user.unique_id, team_allocation.eng_name)) AS eng_name",

            // slect GROUP_CONCAT(po_number) from vendo
            // 

            //       "(SELECT GROUP_CONCAT(DISTINCT vendor_name SEPARATOR ', ') FROM vendor_allocation  WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_name",
            //     // "(SELECT state_name FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_state",
            //     "(SELECT GROUP_CONCAT(DISTINCT state_name SEPARATOR ', ') FROM vendor_allocation  WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_state",


            //   "(SELECT GROUP_CONCAT(DISTINCT district SEPARATOR ', ') 
            //  FROM vendor_allocation 
            //  WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_district",


            //         // "(SELECT district FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_district",
            //     "(SELECT zone FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_zone"
            // "zone",

        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        // print_r($result_values);

        if ($result_values->status) {

            $result_values = $result_values->data;
            $po_unique_id = $result_values[0]["po_unique_id"];

            $po_num = $result_values[0]["po_num"];
            $po_date = $result_values[0]["po_date"];
            $department = $result_values[0]["department"];
            $gst_option = $result_values[0]["gst_option"];
            $gst_value = $result_values[0]["gst_value"];
            $executive_name = $result_values[0]["executive_name"];
            $bill_address = $result_values[0]["bill_address"];
            $contact_name = $result_values[0]["contact_name"];

            $contact_number = $result_values[0]["contact_number"];
            $contact_landline_num = $result_values[0]["landline_number"];
            $email = $result_values[0]["email"];
            $district = $result_values[0]["district"];
            $pin = $result_values[0]["pin"];

            $status = $result_values[0]["status"];
            $po_type = $result_values[0]["po_type"];
            $no_of_po = $result_values[0]["no_of_po"];
            $delivery_due_dates = $result_values[0]["delivery_due_dates"];
            $ld_per_day = $result_values[0]["ld_per_day"];
            $ld_maximum_val = $result_values[0]["ld_maximum_val"];
            $warranty = $result_values[0]["warranty"];
            $warranty_duration = $result_values[0]["warranty_duration"];
            $acc_vertical = $result_values[0]["acc_vertical"];
            $acc_sector = $result_values[0]["acc_sector"];
            $acc_sector_name = $result_values[0]["acc_sector_name"];

            $ins_reqired = $result_values[0]["ins_reqired"];
            // $bank_required = $result_values[0]["bank_required"];
            $dc_required = $result_values[0]["dc_required"];
            $bg = $result_values[0]["bg"];

            $file_name = $result_values[0]["file_name"];

            $file_org_name = $result_values[0]["file_org_name"];

            $bg_month = $result_values[0]["bg_month"];
            $no_of_consignee = $result_values[0]["no_of_consignee"];
            $update_unique_id = $result_values[0]["unique_id"];

            $is_active = $result_values[0]["is_active"];

            $state_name = $result_values[0]["state_name"];



            $vendor_state = $result_values[0]["vendor_state"];

            $vendor_district = $result_values[0]["vendor_district"];



            $vendor_name = $result_values[0]["vendor_name"];

            $zone = $result_values[0]["zone"];

            $vendor_zone = $result_values[0]["vendor_zone"];

            // $insurence_reqired = $result_values[0]["insurence_required"];

            $insurence_required = $result_values[0]["insurence_required"];

            $ld_required = $result_values[0]["ld_required"];
            $amc_required = $result_values[0]["amc_required"];
            $ld_date_type = $result_values[0]["ld_date_type"];
            $ld_installation_due_date = $result_values[0]["ld_installation_due_date"];
            $ld_delivery_due_date = $result_values[0]["ld_delivery_due_date"];
            $ld_date_type = $result_values[0]["ld_date_type"];
            $insurence_types = $result_values[0]["insurence_types"];
            $other_insurance_type = $result_values[0]["other_insurance_type"];
            $unique_id = $result_values[0]["unique_id"];
            $po_file_name = $result_values[0]["file_name"];





            if ($amc_required == 'on') {
                $amcwhere = "po_unique_id = '" . $_GET["unique_id"] . "'";
                $tableamc = "amcrequired";

                $amccolumns = [

                    "start_date",
                    "end_date",
                    "amc_percentae",
                    "amcvalue",
                    "amc_tax",
                    "amc_unit_price",
                    "amc_remarks",
                ];

                $table_details = [
                    $tableamc,
                    $amccolumns
                ];

                $amcresult_values = $pdo->select($table_details, $amcwhere);

                if ($amcresult_values->status) {
                    $start_date = $result_values[0]["start_date"];
                    $end_date = $result_values[0]["end_date"];
                    $amc_percentae = $result_values[0]["amc_percentae"];
                    $amcvalue = $result_values[0]["amcvalue"];
                    $amc_tax = $result_values[0]["amc_tax"];
                    $amc_unit_price = $result_values[0]["amc_unit_price"];
                    $amc_remarks = $result_values[0]["amc_remarks"];
                }
            }


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
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$tax_select_options =
    [
        "" => [
            "unique_id" => "",
            "value" => "Select Option",
        ],
        "18%" => [
            "unique_id" => "18",
            "value" => "18%",
        ],
        "28%" => [
            "unique_id" => "28",
            "value" => "28%",
        ],
        "Without Tax" => [
            "unique_id" => "No",
            "value" => "Without Tax",
        ],
    ];

$tax_select_options = select_option($tax_select_options);

$active_status_options = active_status($is_active);

$executive_name_options = executive_name();
$executive_name_options = select_option($executive_name_options, "Select Executive", $executive_name);

$district_options = district_name();
$district_options = select_option($district_options, "Select District", $district);

$warranty_options = warranty_name();
$warranty_options = select_option($warranty_options, "Select Warranty", $warranty_duration);

$po_type_options = po_type_option();
$po_type_options = select_option($po_type_options, "Select Po Type", $po_type);

$department_options = department_creation_table();
$department_options = select_option($department_options, "Select Customer", $department);

$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

$tender_code_options = tender_name($tender_code);
$tender_code_options = select_option1($tender_code_options, "Select Tender");

$item_code_options = item_name($item_code);
$item_code_options = select_option($item_code_options, "Select Item Code");

$state_name_options = state_option();
$state_name_options = select_option($state_name_options, "Select State Name", $state_name);

$con_state_name_options = state_option();
$con_state_name_options = select_option($con_state_name_options, "Select Consignee State Name");

$account_vertical_options = account_vertical();
$account_vertical_options = select_option($account_vertical_options, "Select Account Vertical", $acc_vertical);

$account_sector_options = account_sector();
$account_sector_options = select_option($account_sector_options, "Select Account Sector", $acc_sector);

$insurance_type_options = insurence_type();
$insurence_types_array = explode(",", $insurence_types);

// Conditionally add the "Select Insurance Type" default option
$description = empty($insurence_types_array[0]) ? "Select Insurance Type" : "";

$insurance_type_options = select_option($insurance_type_options, $description, $insurence_types_array);



// $vendor_state_values = explode(', ', $vendor_state); // Convert to array


// $vendor_state_options  = state_option();
// $vendor_state_options  = select_option($vendor_state_options,"Select State Name",$vendor_state_values);

$team_members_options = team_member();

$team_members_options = select_option($team_members_options, "Select Team Member");


$session_id = $_SESSION['user_type_unique_id'];



$state_data = state_option();

// Step 1: Ensure state data is valid
$state_options = [];
if (is_array($state_data) && !empty($state_data)) {
    foreach ($state_data as $state) {
        $state_options[$state['unique_id']] = $state['state_name']; // Store as key-value pair
    }
}

// Step 2: Ensure vendor state is in array format
$vendor_state_values = [];

if (!empty($vendor_state)) {
    if (is_array($vendor_state)) {
        $vendor_state_values = $vendor_state; // Already an array
    } else {
        $vendor_state_values = explode(',', $vendor_state); // Convert comma-separated values to array
    }
}

// Step 3: Generate the multi-select options
$vendor_state_options = '';
foreach ($state_options as $id => $name) {
    $selected = in_array($id, $vendor_state_values) ? 'selected' : ''; // Check if selected
    $vendor_state_options .= "<option value=\"$id\" $selected>$name</option>";
}





// $district_data = district_name();
// $district_options = [];

// if (is_array($district_data) && !empty($district_data)) {
//     foreach ($district_data as $district) {
//         $district_options[$district['unique_id']] = $district['district_name']; 
//     }
// }


$vendor_district_values = !empty($vendor_district) ? (is_array($vendor_district) ? $vendor_district : explode(',', $vendor_district)) : [];

$vendor_district_options = '';
foreach ($district_options as $id => $name) {
    $selected = in_array($id, $vendor_district_values) ? 'selected' : '';
    $vendor_district_options .= "<option value=\"$id\" $selected>$name</option>";
}





$vendor_data = vendor_names();
$vendor_options = [];

if (is_array($vendor_data) && !empty($vendor_data)) {
    foreach ($vendor_data as $vendor) {
        $vendor_options[$vendor['unique_id']] = $vendor['name'];
    }
}

$vendor_name_values = !empty($vendor_name) ? (is_array($vendor_name) ? $vendor_name : explode(',', $vendor_name)) : [];

$vendor_name_options = '';

foreach ($vendor_options as $id => $name) {
    $selected = in_array($id, $vendor_name_values) ? 'selected' : '';
    $vendor_name_options .= "<option value=\"$id\" $selected>$name</option>";
}


// $vendor_names_options = vendor_names();
// $vendor_names_options = select_option($vendor_names_options, "Select Vendor Name", $state_name);




// PO Number generate function
function generatePrefixedId($prefix, $numericPart)
{
    // Use sprintf to format the numeric part with leading zeros
    $formattedNumericPart = sprintf("%03d", $numericPart);

    // Concatenate the prefix and the formatted numeric part
    $prefixedId = $prefix . $formattedNumericPart;
    return $prefixedId;
}

$prefix = "ELT-";
$numericPart = 1;
$generatedId = generatePrefixedId($prefix, $numericPart);

?>
<?php
//    
?>

<!-- start page title -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/fontawesome-all.css">
<link href="assets/css/select2.min.css" rel="stylesheet" />

<script src="assets/libs/select2/js/select2.min.js"></script>

<div class="row">

    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> PO Form</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> PO Form </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="wrapper1 clearfix">

            <!--multisteps-form-->
            <div class="multisteps-form">
                <!--progress bar-->
                <div class="row">
                    <div class="col-12 col-lg-12 ml-auto mr-auto mb-2 mt-0">
                        <div class="multisteps-form__progress">
                            <!-- <button class="multisteps-form__progress-btn js-active">PO Details</button>
                            <button class="multisteps-form__progress-btn">Product Details</button>
                            <button class="multisteps-form__progress-btn">Consignee Details</button> -->
                            <button class="multisteps-form__progress-btn js-active" id="poDetailsBtn">PO Details</button>
                            <button class="multisteps-form__progress-btn" id="productDetailsBtn">Product Details</button>
                            <button class="multisteps-form__progress-btn" id="consigneeDetailsBtn">Consignee Details</button>
                            <button class="multisteps-form__progress-btn">Assign Qty Details </button>
                            <!--<button class="multisteps-form__progress-btn">Vendor Allocation</button>-->
                            <button class="multisteps-form__progress-btn">Terms & Condition </button>
                        </div>
                    </div>
                </div>
                <!--form panels-->

                <!--form panels-->
                <div class="row">
                    <div class="col-12 col-lg-12 m-auto">
                        <form class="multisteps-form__form was-validated clearfix " action="#" method="post" id="wizard" style="1420px !important;">
                            <input type="hidden" id="m_unique_id" name="m_unique_id" value="<?php
echo $unique_id; ?>">
                            <input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
                                value="<?php
echo $unique_id; ?>">

                            <input type="hidden" id="unique_id" name="unique_id"
                                value="<?php
echo $update_unique_id; ?>">

                            <input type="hidden" id="demo" name="demo" value="<?php
if ($update_unique_id != '') {
                                                                                    echo $update_unique_id;
                                                                                } else {
                                                                                    echo $unique_id;
                                                                                } ?>">

                            <input type="hidden" id="po_unique_id" name="po_unique_id"
                                value="<?php
echo $po_unique_Id; ?>">

                            <!--single form panel-->
                            <div class="multisteps-form__panel js-active" data-animation="slideVert" id="po_tabs">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form po_form_valid" id="po_form_valid">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <h5 style="float:right;">

                                                            <b><?php
echo $po_unique_id; ?></b>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                    <div class="row">
                                                        <div class="col-xl-3" align="right" style="margin-left: 74%;">
                                                            <div class="mb-3" id="modal">

                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-xl">
                                                                    <i class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2 btn-primary"
                                                                        style="padding: 11px;"></i></a>
                                                                <!-- </button> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">PO Number<span class="red-star">*</span></label>
                                                                <input type="text" id="po_num" name="po_num"
                                                                    class="form-control" onchange="get_po_no();"
                                                                    oninput="validateCharInput(this)" value="<?php
if ($po_num != '') {
                                                                                                                    echo $po_num;
                                                                                                                } ?>" required disabled="disabled">


                                                                <input type="hidden" id="old_po_num" name="old_po_num"
                                                                    class="form-control" onchange="get_po_no();"
                                                                    oninput="validateCharInput(this)" value="<?php
if ($po_num != '') {
                                                                                                                    echo $po_num;
                                                                                                                } ?>" required disabled="disabled">
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">PO
                                                                    Date<span class="red-star">*</span></label>
                                                                <input type="date" id="po_date" name="po_date"
                                                                    class="form-control" value="<?php
echo $po_date; ?>"
                                                                    required disabled="disabled">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">

                                                                <label class="form-label">Customer<span
                                                                        class="red-star">*</span></label>
                                                                <br>

                                                                <select class="select  form-control" data-live-search="true"
                                                                    id="department" name="department"
                                                                    onchange="get_account_sector()" required
                                                                    disabled="disabled">
                                                                    <?php
echo $department_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Account Sector<span
                                                                        class="red-star">*</span></label><br>
                                                                <input type="hidden" id="acc_sector" name="acc_sector"
                                                                    value="<?php
echo $acc_sector; ?>">
                                                                <input type="text" class="form-control" id="acc_sector_name"
                                                                    name="acc_sector_name"
                                                                    value="<?php
echo $acc_sector_name; ?>" readonly
                                                                    disabled="disabled">


                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Account Vertical<span
                                                                        class="red-star">*</span></label><br>
                                                                <select class="select form-control" name="acc_vertical"
                                                                    id="acc_vertical" required disabled="disabled">
                                                                    <?php
echo $account_vertical_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <input type="hidden" id="old_gst_option"
                                                                    name="old_gst_option" value="<?php
echo $gst_option; ?>"
                                                                    disabled="disabled" />
                                                                <label class="form-label">GST
                                                                    Option</label>
                                                                <?php
if ($gst_option == 'yes') { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchange="gst_check()" required
                                                                        disabled="disabled">
                                                                        <option>selcet option</option>
                                                                        <option value="yes" selected>Yes
                                                                        </option>
                                                                        <option value="no">No</option>

                                                                    </select>
                                                                <?php
} else if ($gst_option == 'no') { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchage="gst_check()"
                                                                        value="<?php
echo $gst_option; ?>" disabled="disabled">
                                                                        <option>selcet option</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no" selected>No
                                                                        </option>

                                                                    </select>
                                                                <?php
} else { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchange="gst_check()"
                                                                        value="<?php
echo $gst_option; ?>" disabled="disabled">
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>

                                                                    </select>
                                                                <?php
} ?>

                                                            </div>

                                                            <span id="unregistered_message">GST Unregistered </span>

                                                        </div>

                                                        <div class="col-xl-3" id="gst_num">
                                                            <div class="mb-3">
                                                                <label class="form-label">Customer GST Number</label>
                                                                <!-- <input type="text" id="gst_value" name="gst_value"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                onchange="validagst1(this)"
                                                                value="<?php
echo $gst_value; ?>" required
                                                                disabled="disabled"> -->
                                                                <input
                                                                    type="text"
                                                                    id="gst_value"
                                                                    name="gst_value"
                                                                    minlength="15"
                                                                    maxlength="15"
                                                                    class="form-control gst-input"
                                                                    required
                                                                    value="<?php
echo $gst_value; ?>" />
                                                                <!-- pattern="[A-Z0-9]{15}" -->
                                                                <input type="hidden" name="testin" id="testin" value='0'>
                                                                <span id="gst_error"
                                                                    style="color: red; display: none;">Enter a valid GST
                                                                    number</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">

                                                                <label class="form-label">Executive
                                                                    Name<span class="red-star">*</span></label>
                                                                <select class="select2 form-control" id="executive_name"
                                                                    name="executive_name" required disabled="disabled">
                                                                    <?php
echo $executive_name_options; ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">

                                                                <label class="form-label">Billing Address<span
                                                                        class="red-star">*</span></label>
                                                                <textarea id="bill_address" name="bill_address"
                                                                    class="form-control" oninput="validateCharInput(this)"
                                                                    required
                                                                    disabled="disabled"><?php
echo $bill_address; ?></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Billing Gst No</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="con_bill_gst" maxlength="15" id="con_bill_gst" oninput="con_validateGST(this)" class="form-control" />
                                                                <small id="con_billgst_error" style="color:red; display:none;">Invalid GST Number</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Contact Name</label>
                                                                <input type="text" id="contact_name" name="contact_name"
                                                                    class="form-control" oninput="valid_user_name(this)"
                                                                    value="<?php
echo $contact_name; ?>"
                                                                    disabled="disabled">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Contact Number</label>
                                                                <input type="text" id="contact_number" name="contact_number"
                                                                    class="form-control" oninput="valid_mobile_number(this)"
                                                                    value="<?php
echo $contact_number; ?>" minlength="10"
                                                                    maxlength="10" disabled="disabled">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Contact Landline
                                                                    Number</label>
                                                                <input type="text" id="contact_landline_num"
                                                                    name="contact_landline_num" class="form-control"
                                                                    maxlength="12"
                                                                    value="<?php
echo $contact_landline_num; ?>"
                                                                    oninput="validateLandline(this)" disabled="disabled">

                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="text" id="email" name="email"
                                                                    class="form-control"
                                                                    value="<?php
echo $email; ?>" disabled="disabled">
                                                                <span id="emailValidationMessage"></span>

                                                            </div>
                                                        </div>
                                                        <!-- onkeypress="validateEmail(event)" -->
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">State</label>

                                                                <!--    class="form-control" value="">-->
                                                                <!--data-live-search="true" data-live-search="true"-->
                                                                <select name="state_name" id="state_name"
                                                                    class="form-control" onchange="get_district(this.value)"
                                                                    required disabled="disabled">
                                                                    <?php
echo $state_name_options; ?>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">District</label>


                                                                <select id="district" name="district" class="form-control"
                                                                    required disabled="disabled">
                                                                    <option value="">Select District</option>


                                                                </select>

                                                            </div>
                                                            <input type="hidden" name="dis_id" id="dis_id"
                                                                value="<?php
echo $district; ?>">
                                                        </div>
                                                        <!-- <?php
echo $district_options; ?> -->
                                                        <!-- <?php
echo $district_options; ?> -->
                                                        <!--  
                                                    class="form-select mb-3"-->
                                                        <!--<?php
echo $district_options; ?>-->

                                                        <div class="col-xl-3">
                                                            <div class="mb-3">

                                                                <label class="form-label">Pin
                                                                    Code<span class="red-star">*</span></label>
                                                                <input type="text" id="pin" name="pin" class="form-control"
                                                                    onkeypress="return isNumber(event)" minlength="6"
                                                                    maxlength="6" value="<?php
echo $pin; ?>" required
                                                                    disabled="disabled">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 ">
                                                            <div class="mb-3">

                                                                <label class="form-label"> PO Type<span
                                                                        class="red-star">*</span>
                                                                </label>
                                                                <select class="form-select mb-3" id="po_type" name="po_type"
                                                                    aria-label="Default select example"
                                                                    value="<?php
echo $po_type; ?>" required
                                                                    disabled="disabled">
                                                                    <?php
echo $po_type_options; ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 ">
                                                            <div class="mb-3">

                                                                <label class="form-label">No of
                                                                    Items in PO<span class="red-star">*</span>
                                                                </label>
                                                                <input type="text" id="no_of_po" name="no_of_po"
                                                                    class="form-control" onkeypress="return isNumber(event)"
                                                                    maxlength="3" value="<?php
echo $no_of_po; ?>" required
                                                                    disabled="disabled">

                                                            </div>
                                                        </div>
                                                    </div>


                                                <?php
} else {
                                                ?>

                                                    <!-- FORM dESIGN start(1)----------------------------------------------------------------------------------------------------------- -->

                                                    <div class="row mt-2">
                                                        <div class="col-xl-6 pr-5" style="">
                                                            <p style="color: #506018;font-weight: 500; font-size: 21px;">Customer Details : </p>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Customer<span class="red-star">*</span></label>
                                                                    <span>
                                                                        <a data-bs-toggle="modal"
                                                                            data-bs-target=".bs-example-modal-xl">
                                                                            <i class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2 btn-primary"
                                                                                style="padding: 11px;"></i></a>

                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select class="select2 form-control" data-live-search="true"
                                                                        id="department" name="department"
                                                                        onchange="get_account_sector()" required>
                                                                        <?php
echo $department_options; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">Billing Address<span class="red-star">*</span></label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <textarea id="bill_address" name="bill_address"
                                                                        class="form-control" oninput="valid_address(this)"
                                                                        required><?php
echo $bill_address; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">State</label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select name="state_name" id="state_name"
                                                                        class="select2 form-control" onchange="get_district(this.value)"
                                                                        required>
                                                                        <?php
echo $state_name_options; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">District</label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select id="district" name="district" class="select2 form-control"
                                                                        required>
                                                                        <option value="">Select District</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="dis_id" id="dis_id"
                                                                    value="<?php
echo $district; ?>">
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Pin
                                                                        Code<span class="red-star">*</span></label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="pin" name="pin" class="form-control"
                                                                        onkeypress="return isNumber(event)" minlength="6"
                                                                        maxlength="6" value="<?php
echo $pin; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Contact Name</label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="contact_name" name="contact_name"
                                                                        class="form-control" oninput="valid_user_name(this)"
                                                                        value="<?php
echo $contact_name; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Contact Number</label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="contact_number" name="contact_number"
                                                                        class="form-control" oninput="valid_mobile_number(this)"
                                                                        value="<?php
echo $contact_number; ?>" minlength="10"
                                                                        maxlength="10">

                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Contact Landline
                                                                        Number</label>

                                                                </div>
                                                                <div class="col-xl-6">

                                                                    <input type="text" id="contact_landline_num"
                                                                        name="contact_landline_num" class="form-control"
                                                                        maxlength="12"
                                                                        value="<?php
echo $contact_landline_num; ?>"
                                                                        oninput="validateLandline(this)">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"> <label class="form-label">Email</label>

                                                                </div>
                                                                <div class="col-xl-6">

                                                                    <input type="text" id="email" name="email"
                                                                        onkeypress="validateEmail(event);return validateEmailChar(event)" class="form-control"
                                                                        value="<?php
echo $email; ?>">
                                                                    <span id="emailValidationMessage"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!---------- right ------------->
                                                        <div class="col-xl-6" style="">
                                                            <p style="color: #506018;font-weight: 500; font-size:21px;">Account Details : </p>
                                                            <div class="row mb-1">
                                                                <div class="col-xl-6"> <label class="form-label">PO Number<span class="red-star">*</span></label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="po_num" name="po_num"
                                                                        class="form-control" onchange="get_po_no();"
                                                                        oninput="validateCharInput(this)" value="<?php
if ($po_num != '') {
                                                                                                                        echo $po_num;
                                                                                                                    } ?>" required>
                                                                </div>
                                                                <input type="hidden" id="old_po_num" name="old_po_num"
                                                                    class="form-control" onchange="get_po_no();"
                                                                    oninput="validateCharInput(this)" value="<?php
if ($po_num != '') {
                                                                                                                    echo $po_num;
                                                                                                                } ?>" required disabled="disabled">
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-xl-6"> <label class="form-label">PO
                                                                        Date<span class="red-star">*</span></label>

                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="date" id="po_date" name="po_date"
                                                                        class="form-control" value="<?php
echo $po_date; ?>"
                                                                        required>

                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-xl-6"> <label class="form-label"> PO Type<span
                                                                            class="red-star">*</span> </label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select class="form-select" id="po_type" name="po_type"
                                                                        aria-label="Default select example"
                                                                        value="<?php
echo $po_type; ?>" required>
                                                                        <?php
echo $po_type_options; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6"><label class="form-label">No of
                                                                        Items in PO<span class="red-star">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="no_of_po" name="no_of_po"
                                                                        class="form-control" onkeypress="return isNumber(event)"
                                                                        maxlength="10" value="<?php
echo $no_of_po; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">GST
                                                                        Option</label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="hidden" id="old_gst_option"
                                                                        name="old_gst_option"
                                                                        value="<?php
echo $gst_option; ?>" />

                                                                    <?php
if ($gst_option == 'yes') { ?>
                                                                        <select class="form-select" id="gst_option"
                                                                            name="gst_option" onchange="gst_check()" required>
                                                                            <option>selcet option</option>
                                                                            <option value="yes" selected>Yes
                                                                            </option>
                                                                            <option value="no">No</option>

                                                                        </select>
                                                                    <?php
} else if ($gst_option == 'no') { ?>
                                                                        <select class="form-select mb-3" id="gst_option"
                                                                            name="gst_option" onchage="gst_check()"
                                                                            value="<?php
echo $gst_option; ?>">
                                                                            <option>selcet option</option>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no" selected>No
                                                                            </option>

                                                                        </select>
                                                                    <?php
} else { ?>
                                                                        <select class="form-select mb-3" id="gst_option"
                                                                            name="gst_option" onchange="gst_check()"
                                                                            value="<?php
echo $gst_option; ?>">
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>

                                                                        </select>
                                                                    <?php
} ?>
                                                                    <span id="unregistered_message">GST Unregistered </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2" id="gst_num">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">Customer GST Number</label>
                                                                </div>
                                                                <!-- onchange="validagst1(this)" onkeypress="return validateGSTChar(event)" -->
                                                                <div class="col-xl-6">
                                                                    <input type="text" id="gst_value" name="gst_value"
                                                                        minlength="15" maxlength="15" class="form-control"
                                                                        value="<?php
echo $gst_value; ?>" required>
                                                                    <input type="hidden" name="testin" id="testin" value='0'>
                                                                    <span id="gst_error"
                                                                        style="color: red; display: none;">Enter a valid GST
                                                                        number</span>

                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">Account Sector<span
                                                                            class="red-star">*</span></label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <input type="hidden" id="acc_sector" name="acc_sector"
                                                                        value="<?php
echo $acc_sector; ?>">
                                                                    <input type="text" class="form-control" id="acc_sector_name"
                                                                        name="acc_sector_name"
                                                                        value="<?php
echo $acc_sector_name; ?>" readonly>

                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">Account Vertical<span
                                                                            class="red-star">*</span></label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select class="select form-control" name="acc_vertical"
                                                                        id="acc_vertical" required>
                                                                        <?php
echo $account_vertical_options; ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-6">
                                                                    <label class="form-label">Executive
                                                                        Name<span class="red-star">*</span></label>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <select class="select2 form-control" id="executive_name"
                                                                        name="executive_name" required>
                                                                        <?php
echo $executive_name_options; ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!------- FORM dESIGN END----------------------------------------------------------------------------------------------------------- -->

                                                <?php
} ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-footer mt-2">
                                        <div class="actions">
                                            <ul>
                                                <!--id="checkit" style="display:none"-->


                                                <?php
if ($update_unique_id != '') { ?>
                                                    <li onclick="po_form_cu()"><span class="btn btn-primary js-btn-next"
                                                            title="NEXT"
                                                            class="btn btn-success waves-effect waves-light">Update
                                                            &continue <i class="fa fa-arrow-right"></i> </span>
                                                    </li>

                                                <?php
} else { ?>
                                                    <li onclick="po_form_cu();">
                                                        <span class="btn btn-primary js-btn-next" title="NEXT">
                                                            Save & Continue <i class="fa fa-arrow-right"></i>
                                                        </span>
                                                    </li>
                                                <?php
} ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--single form panel-->

                            <!----Tender start(2)----------------------------------------------------------------------------------------------------------- -->

                            <div class="multisteps-form__panel" data-animation="slideVert" id="sec_tab">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <div class="row mt-2">
                                                    <div class="col-xl-6 pr-5" style="">
                                                        <!-- <p style="color: #506018;font-weight: 500;">Customer Details : </p> -->
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6"><label class="form-label">Tender Code</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="tender_code" id="tender_code"
                                                                    onchange="tender_codes()"
                                                                    class="select2 form-control select2_op" required>
                                                                    <?php
echo $tender_code_options; ?></select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Item Code</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="item_code" id="item_code" class="select form-control select2_op" required onchange="item_detail(this.value)">
                                                                    <?php
echo $item_code_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Product</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="po_name" name="po_name"
                                                                    class="form-control" value="<?php
echo $product; ?>"
                                                                    required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Qty</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="qty" name="qty" maxlength="15" onkeypress="return validateAmountKeyPress(event)"
                                                                    onchange="CalculateTotal()" class="form-control"
                                                                    oninput=quantity_number(this);
                                                                    value="<?php
echo $qty; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Unit Price</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="unit_price" name="unit_price"
                                                                    class="form-control" value="<?php
echo $unit_price; ?>"
                                                                    required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Net price<span style="color:red">(with tax)</span></label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="net_price" name="net_price"
                                                                    class="form-control" onkeypress="return isNumber(event)"
                                                                    value="<?php
echo $net_amount; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Tax</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="tax" class="form-control" name="tax"
                                                                    value="<?php
echo $tax; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Total Net Amount <span style="color:red;">( With Tax)</span></label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="total_value" name="total_value"
                                                                    class="form-control" value="<?php
echo $total_value; ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Total Without Tax </label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="net_value" name="net_value"
                                                                    class="form-control" value="<?php
echo $net_value; ?>"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">BG Required</label>

                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="bg_required" id="bg_required"
                                                                    class="select form-control" onchange="BGrequired()">
                                                                    <option value="no">No</option>
                                                                    <option value="yes">Yes</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2" style="display:none" id="bgrequireddivs">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">BG%</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="bg_percen" id="bg_percen" class="form-control" maxlength="3" onkeypress="return validateAmountKeyPress(event)">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2" style="display:none" id="bgrequireddiv">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">BG Month</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="bg_month" id="bg_month" class="form-control" maxlength="3" onkeypress="return validateAmountKeyPress(event)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!---------- right ------------->
                                                    <div class="col-xl-6" style="">
                                                        <!-- <p style="color: #506018;font-weight: 500; font-size:16px;">Account Details : </p> -->
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Delivery Due Days</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="delivery_due_dates"
                                                                    name="delivery_due_dates" class="form-control"
                                                                    onkeypress="return isNumber(event)" maxlength="3"
                                                                    value="<?php
echo $delivery_due_dates; ?>" required>
                                                                <span style="color:red">Valid The Delivery Due Dates in
                                                                    RFP</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Installation Due Days</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="insta_due_days" name="insta_due_days" maxlength="3"
                                                                    class="form-control" onkeypress="return isNumber(event)"
                                                                    value="<?php
echo $installation_due_dates; ?>" required>
                                                                <span style="color:red">Valid The Delivery Due Dates in
                                                                    RFP</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">LD Type</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select class="form-select " id="ld_type"
                                                                    name="ld_type">
                                                                    <!--<option value="">Select</option>-->
                                                                    <option value="day">LD Per Day</option>
                                                                    <option value="week">LD Per Week</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label" id="ld_label_day">LD% Per Day</label>
                                                                <label class="form-label" id="ld_label_week" style="display: none;">LD% Per Week</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="ld_per_day" name="ld_per_day"
                                                                    onkeypress="return isNumberss(event)" maxlength="3"
                                                                    onkeyup="validateNumber(this)" class="form-control"
                                                                    value="<?php
echo $ld_per_day; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">LD Maximum %</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                                    class="form-control"
                                                                    onkeypress="return isNumberss(event)"
                                                                    onkeyup="validateNumber(this)" maxlength="3"
                                                                    value="<?php
echo $ld_maximum_val; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Document Required</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="document_required" id="document_required"
                                                                    class="select form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="dc_required">DC Required</option>
                                                                    <option value="ir_required">DC & IR Required</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Warranty</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="hidden" id="old_warranty" name="old_warranty"
                                                                    value="<?php
echo $warranty; ?>" />
                                                                <?php
if ($warranty == '1') { ?>
                                                                    <select class="form-select " id="warranty"
                                                                        name="warranty">
                                                                        <option value="1" selected>
                                                                            Yes
                                                                        </option>
                                                                        <option value="0">
                                                                            No
                                                                        </option>
                                                                    </select>
                                                                <?php
} else if ($warranty == '0') { ?>
                                                                    <select class="form-select" id="warranty"
                                                                        name="warranty">
                                                                        <option value="1">
                                                                            Yes
                                                                        </option>
                                                                        <option value="0" selected>
                                                                            No
                                                                        </option>
                                                                    </select>
                                                                <?php
} else { ?>
                                                                    <select class="form-select" id="warranty"
                                                                        name="warranty">
                                                                        <option value="1">
                                                                            Yes
                                                                        </option>
                                                                        <option value="0">
                                                                            No
                                                                        </option>
                                                                    </select>
                                                                <?php
} ?>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2" id="select_warranty">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Warranty In Months</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <!-- <select class="form-select" id="warranty_duration"
                                                                        name="warranty_duration"
                                                                        value="<?php
echo $warranty_duration; ?>">
                                                                        <?php
echo $warranty_options; ?>
                                                                    </select> -->
                                                                <input class="form-select mb-3" id="warranty_duration"
                                                                    name="warranty_duration"
                                                                    value="<?php
echo $warranty_duration; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2" id="warranty_from">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Warranty Starts From</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="warranty_starts" id="warranty_starts"
                                                                    class="select form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="delivery_date">Delivery Date</option>
                                                                    <option value="installation_date">Installation Date
                                                                    </option>
                                                                    <option value="last_installation_date">Last Installation Date
                                                                    </option>
                                                                    <option value="invoice_date">Invoice Date</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2" style="display:none" id="dates">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Date</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="date" name="date_type" id="date_type" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!----------- FORM dESIGN END (2)----------------------------------------------------------------------------------------------------------- -->

                                                <div class="row">

                                                    <!--</div>-->
                                                    <div class="row">


                                                        <style>
                                                            .date-row {
                                                                display: flex;
                                                                align-items: stretch;
                                                                margin-bottom: 10px;
                                                                justify-content: space-between;
                                                                align-content: stretch;
                                                                flex-wrap: wrap;
                                                                flex-direction: row;
                                                            }

                                                            .date-row input[type="date"] {
                                                                max-width: 200px;
                                                            }

                                                            .datee1 {
                                                                margin-top: -28px;
                                                                margin-left: 153px;
                                                            }

                                                            #mydate {
                                                                margin-left: 27px;
                                                            }

                                                            .btns {
                                                                margin-top: 73px;
                                                                margin-left: 139px;
                                                            }
                                                        </style>



                                                        <input type="hidden" name="stored_item" id="stored_item">
                                                        <input type="hidden" name="count_item" id="count_item">
                                                        <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                            <div class="col-xl-3 " style="display:none">
                                                                <div class="mb-3">
                                                                    <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php
echo $no_of_po; ?>">-->
                                                                    <button type="button" id="pro_details"
                                                                        style="margin-top: -2px;position: relative;margin-left: 403%;"
                                                                        class="btn btn-success btn-label product_details_add_update_btn btns"
                                                                        onclick="product_details_add_update(),get_po_item()"><i
                                                                            class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                        Add New</button>

                                                                </div>
                                                            </div><!-- end col -->
                                                        <?php
} else { ?>
                                                            <div class="col-xl-3 ">
                                                                <div class="mb-3">
                                                                    <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php
echo $no_of_po; ?>">-->
                                                                    <button type="button" id="pro_details"
                                                                        style="margin-top: -2px;position: relative;margin-left: 403%;"
                                                                        class="btn btn-success btn-label product_details_add_update_btn btns"
                                                                        onclick="product_details_add_update(),get_po_item()"><i
                                                                            class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                        Add New</button>

                                                                </div>
                                                            </div><!-- end col -->

                                                        <?php
} ?>
                                                    </div>

                                                    <div class="table-responsive mb-4">
                                                        <div id="product_details_datatable_wrapper"
                                                            class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6"></div>
                                                                <div class="col-sm-12 col-md-6"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <table id="product_details_datatable"
                                                                        class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                                        width="100%" style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    ID </th>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Tender Code </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Item Code</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Product</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Qty</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Unit Price</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Net Price</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Tax </th>
                                                                                <!--<th scope="col" class="sorting_disabled"-->
                                                                                <!--rowspan="1" colspan="1"-->
                                                                                <!--style="width: 0px;">-->
                                                                                <!--Total Net Amount (With Tax)</th>-->
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Total Without Tax </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Total With Tax </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Delivery Due Days </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Installation Due Days </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    LD Type</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    LD% Per Day</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    LD Maximum %</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Warranty</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">

                                                                                    Warranty Duration</th>
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Document Required </th>
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">Warranty Starts
                                                                                    From</th>
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">BG Required</th>

                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">BG%</th>

                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">BG Month</th>

                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Action </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan="8" class="text-right">
                                                                                    Total:</th>
                                                                                <th id="sum_net_value"></th>
                                                                                <th id="sum_total_value">0</th>
                                                                                <th colspan="13"></th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>

                                                                    <div id="product_details_datatable_processing"
                                                                        class="dataTables_processing card"
                                                                        style="display: none;">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- </form> -->
                                            </div>

                                            <div id="product_msg">
                                                <p style="color:red;font_size:20px;">Maximum No.Of.Product : <span
                                                        id="no_of_pro_item"></span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i> BACK</span></li>

                                                <li id="product_data"><span title="NEXT"
                                                        class="btn btn-primary js-btn-next">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--single form panel--------------------------------------------------------->
                            <div class="multisteps-form__panel" data-animation="slideVert" id="third_tab">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <!-- Bootstrap Modal -->
                                                <div class="modal fade" id="consigneeModal" tabindex="-1"
                                                    aria-labelledby="consigneeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content" id="mddd">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Consignee Details</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <input type="hidden" id="batch_id_holder"
                                                                name="batch_id_holder" />
                                                            <div class="modal-body" id="consigneeModalBody">

                                                                Loading...
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- operation team  id-->
                                                <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                    <div class="container" style="display:none">
                                                        <div class="row justify-content-center">
                                                            <div class="col-auto text-center">
                                                                <div class="mode-label">Select Mode:</div>
                                                                <div class="mode-selector">
                                                                    <input type="radio" name="entry_mode" id="mode_entry"
                                                                        value="entry">
                                                                    <label for="mode_entry">Entry</label>

                                                                    <input type="radio" name="entry_mode" id="mode_import"
                                                                        value="import" checked>
                                                                    <label for="mode_import">Import</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
} else { ?>
                                                    <div class="container">
                                                        <div class="row align-items-center">

                                                            <!-- Select Mode -->
                                                            <div class="col-md-6 text-center">
                                                                <div class="mode-label">Select Mode:</div>
                                                                <div class="mode-selector">
                                                                    <input type="radio" name="entry_mode" id="mode_entry"
                                                                        value="entry">
                                                                    <label for="mode_entry">Entry</label>

                                                                    <input type="radio" name="entry_mode" id="mode_import"
                                                                        value="import" checked>
                                                                    <label for="mode_import">Import</label>
                                                                </div>
                                                            </div>

                                                            <!-- Download + Consignee Verify -->
                                                            <div
                                                                class="col-md-6 d-flex justify-content-center align-items-center gap-3">

                                                                <div class="text-end">
                                                                    <span>Consignee Excel Format</span><br>
                                                                    <a class="btn btn-primary waves-effect waves-light mt-1"
                                                                        href="folders/po_form/consignee-details-format.xlsx"
                                                                        download="Consignee import format.xlsx">
                                                                        <i class="mdi mdi-download me-1"
                                                                            aria-hidden="true"></i>
                                                                        Download
                                                                    </a>
                                                                </div>

                                                                <?php
if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"||$_SESSION['user_type_unique_id'] == "68cba503472bd48995") { ?>
                                                                    <button type="button"
                                                                        class="btn btn-primary waves-effect waves-light mt-4"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#bulkVerifyModal">
                                                                        Consignee Verify
                                                                    </button>
                                                                <?php
} ?>

                                                            </div>

                                                        </div>
                                                    </div>


                                                <?php
}
                                                $table_2 = "po_form";
                                                $columns_2 = [
                                                    "po_num",
                                                ];

                                                $table_details_2 = [
                                                    $table_2,
                                                    $columns_2
                                                ];
                                                $where_2 = "is_active = 1 and is_delete = 0 ORDER BY unique_id DESC LIMIT 1";
                                                $result_values_2 = $pdo->select($table_details_2, $where_2);

                                                if ($result_values_2->status) {

                                                    $result_values_2 = $result_values_2->data;
                                                    $store_unique_id = $result_values_2[0]["unique_id"];
                                                }
                                                ?>
                                                <input type="hidden" name="po_numbers" id="po_numbers"
                                                    class="form-control">
                                                <?php
function batch_id()
                                                {
                                                    $date = date('Y');
                                                    $st_date = substr($date, 2); // last 2 digits of year
                                                    $month = date('m'); // current month
                                                    $datee = $st_date . $month; // e.g., 2504

                                                    $servername = 'localhost';
                                                    $username = project_env('APP_DB_USERNAME', 'root');
                                                    $password = project_env('APP_DB_PASSWORD');
                                                    $database_name = "operation_team_beta";

                                                    try {
                                                        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
                                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                    } catch (PDOException $e) {
                                                        die("Connection failed: " . $e->getMessage());
                                                    }

                                                    // Get latest batch ID
                                                    $stmt = $conn->query("SELECT batch_id FROM consignee_details_sub WHERE batch_id LIKE 'PO-BAT-%' group by batch_id ORDER BY id DESC LIMIT 1");

                                                    $booking_no = 0;
                                                    if ($res1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $pur_array = explode('-', $res1['batch_id']); // e.g. [PO, BAT, YYMM, XXXX]
                                                        if (count($pur_array) === 4) {
                                                            $last_datee = $pur_array[2];
                                                            $last_seq = (int) $pur_array[3];

                                                            if ($last_seq) {
                                                                $booking_no = $last_seq + 1;
                                                            } else {
                                                                $booking_no = 1; // reset for new month
                                                            }
                                                        }
                                                    } else {
                                                        $booking_no = 1; // first batch ever
                                                    }

                                                    $booking_nos = 'PO-BAT-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
                                                    return $booking_nos;
                                                }

                                                $batch_id = batch_id();

                                                ?>
                                                <div class="row">

                                                    <div class="col-xl-3">
                                                        <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                            <div class="mb-3">
                                                                <label class="form-label">Consignee Received Date</label>
                                                                <input type="date" name="consignee_received_date"
                                                                    id="consignee_received_date" class="form-control"
                                                                    value="<?php
echo date('Y-m-d'); ?>"
                                                                    disabled="disabled">
                                                            </div>
                                                        <?php
} else { ?>
                                                            <div class="mb-3">
                                                                <label class="form-label">Consignee Received Date</label>
                                                                <input type="date" name="consignee_received_date"
                                                                    id="consignee_received_date" class="form-control"
                                                                    value="<?php
echo date('Y-m-d'); ?>">
                                                            </div>
                                                        <?php
} ?>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                            <div class="mb-3" style="display:none;">
                                                                <label class="form-label">Batch ID</label>
                                                                <input type="text" name="batch_id" id="batch_id"
                                                                    class="form-control" value="<?php
echo $batch_id; ?>"
                                                                    readonly>
                                                            </div>
                                                        <?php
} else { ?>
                                                            <div class="mb-3" style="display:none;">
                                                                <label class="form-label">Batch ID</label>
                                                                <input type="text" name="batch_id" id="batch_id" class="form-control" value="<?php
echo $batch_id; ?>" readonly>
                                                            </div>

                                                        <?php
} ?>
                                                    </div>
                                                    <?php
if ($status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") { ?>
                                                        <div class="col-xl-3" id="myrows" style="display:none">
                                                            <div class="mb-3 mt-4">
                                                                <div class="btn-header" id="import_option">
                                                                    <a href="javascript:excel_popup()"> <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw mb-1 mt-1"><i class="ri-file-excel-2-fill"></i> &nbsp;Import </button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
} else { ?>
                                                        <div class="col-xl-3" id="myrows" style="display:none">
                                                            <div class="mb-3 mt-4">
                                                                <div class="btn-header" id="import_option">
                                                                    <a href="javascript:excel_popup()">
                                                                        <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw mb-1 mt-1"><i class="ri-file-excel-2-fill"></i> &nbsp;Import </button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
} ?>
                                                </div>
                                                <div class="row" id="sec_ops" style="display:none">
                                                    <input type="hidden" id="no_of_consignee" name="no_of_consignee" class="form-control" value="<?php
echo $no_of_consignee; ?>">
                                                    <div class="col-xl-6 pr-5" style="">
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Billing Address</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <textarea name="billing_address" id="billing_address" oninput="validateCharInput(this)" onkeypress="return validateAddressChar(event)" class="form-control" required></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Billing Gst No</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="con_bill_gst" maxlength="15" id="con_bill_gst" oninput="con_validateGST(this)" class="form-control" />
                                                                <small id="con_billgst_error" style="color:red; display:none;">Invalid GST Number</small>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Consignee Name/Branch</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="con_branch" id="con_branch" oninput="valid_user_name(this)" class="form-control" required />
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Consignee Branch Code</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="con_branch_code" id="con_branch_code" oninput="validateCharInput(this)" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Consignee Address</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <textarea name="con_address" id="con_address" oninput="validateCharInput(this)" onkeypress="return validateAddressChar(event)" class="form-control" required></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Consignee GST IN</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="consignee_gst" name="consignee_gst"
                                                                    class="form-control"
                                                                    minlength="12" maxlength="15" onblur="isValidGST(this)"
                                                                    required>
                                                            </div>
                                                            <span id="con_gst_error" style="color: red; display: none;">Enter a valid GST
                                                                number</span>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Consignee Email Id</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="email" name="con_email" id="con_email" oninput="validateCharInput(this);validateEmailInput(this)" class="form-control">
                                                                <small id="emailError" class="text-danger"></small>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2" id="d1">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">State</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="con_state_name" id="con_state_name"
                                                                    class="form-control"
                                                                    onchange="con_get_district(this.value)" required>
                                                                    <?php
echo $con_state_name_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2" id="d1">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">District</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select name="con_district" id="con_district"
                                                                    class="select2 form-control" required>
                                                                    <option value="">Select District</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Region</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="con_region" name="con_region"
                                                                    class="form-control" oninput="valid_user_name(this)">
                                                            </div>
                                                        </div>

                                                        <!-- <div class="row mb-2" id="d2" style="display:none;">
                                                            <div class="col-xl-6"> 
                                                                <label class="form-label">District</label>
                                                            </div>
                                                            <div class="col-xl-6"> 
                                                                <select name="con_district" id="con_district"
                                                                    class="select2 form-control" required>
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="col-xl-6 pr-5" style="">
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Contact Person Name</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="con_contact_name"
                                                                    name="con_contact_name" class="form-control"
                                                                    oninput="valid_user_name(this)"
                                                                    value="<?php
echo $con_contact_name ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Contact Number</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="con_contact_number"
                                                                    name="consignee_number" class="form-control"
                                                                    onkeypress="return isNumber(event)" minlength="10"
                                                                    maxlength="10"
                                                                    value="<?php
echo $con_contact_number ?>">
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Alternate Person Name</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="alter_contact_name"
                                                                    name="alter_contact_name" class="form-control"
                                                                    oninput="valid_user_name(this)"
                                                                    value="">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Alternate Contact Number</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="alter_contact_number"
                                                                    name="alter_contact_number" class="form-control"
                                                                    onkeypress="return isNumber(event)" minlength="10"
                                                                    maxlength="10"
                                                                    value="">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Landline Number</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="tel" id="con_lan_num" name="con_lan_num"
                                                                    oninput="valid_landline_number(this)" maxlength="12"
                                                                    class="form-control" value="<?php
echo $con_lan_num ?>">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="row mb-2" >
                                                            <div class="col-xl-6"> 
                                                                <label class="form-label">GST IN</label>
                                                            </div>
                                                            <div class="col-xl-6"> 
                                                                <input type="text" id="consignee_gst" name="consignee_gst"
                                                                 class="form-control"
                                                                minlength="12" maxlength="15" onblur="isValidGST(this)"
                                                                value="<?php
echo $consignee_gst; ?>" required>
                                                            </div>
                                                            <span id="con_gst_error" style="color: red; display: none;">Enter a valid GST
                                                                number</span>
                                                        </div> -->
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Assign Team Member</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select class="form-control" name="assign_team_member"
                                                                    id="assign_team_member">
                                                                    <?php
echo $team_members_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Address verification</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <select class="form-control" name="verify_sts"
                                                                    id="verify_sts">
                                                                    <option value="">Select </option>
                                                                    <?php
if ($session_id == '65deef78ba17d65741') { ?>
                                                                        <option value="1">Verified</option>
                                                                        <option value="2">Not Verified</option>
                                                                    <?php
} else { ?>
                                                                        <option value="2">Not Verified</option>
                                                                    <?php
} ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Zone</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="zone" id="zone"
                                                                    oninput="valid_user_name(this)" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Zone Code</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" name="zone_code" id="zone_code" oninput="validateCharInput(this)" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-xl-6">
                                                                <label class="form-label">Pincode</label>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <input type="text" id="con_pincode" name="con_pincode"
                                                                    class="form-control" onkeypress="return isNumber(event)"
                                                                    minlength="6" maxlength="6"
                                                                    required>
                                                            </div>
                                                        </div>


                                                        <input type="hidden" name="count_consignee"
                                                            id="count_consignee">
                                                        <input type="hidden" name="stored_consignee"
                                                            id="stored_consignee">
                                                    </div>
                                                    <div class="col-xl-12" style="display: flex;justify-content: flex-end;">
                                                        <!-- style="display: flex;justify-content: flex-end;" style="display:none"-->
                                                        <div class="mb-3" style="margin-right: 33px;">
                                                            <button type="button" id="mybtns"
                                                                class="btn btn-success consignee_details_add_update_btn"
                                                                onclick="consignee_details_add_update(),get_stored_sublist_count()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="dislay:none" id="frst_1_ops">
                                                    <div class="table-responsive mb-4">
                                                        <div id="consignee_details_datatable_wrapper"
                                                            class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6"></div>
                                                                <div class="col-sm-12 col-md-6"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <table id="consignee_details_datatable"
                                                                        class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                                        style="width: 0px;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    ID </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Batch Id</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Batch Insert Date</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Consignee Received Date</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Total Consignee Count</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Item Count</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Order Qty</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Export</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Import</th>
                                                                                <?php
if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" || $_SESSION['user_type_unique_id'] == "5f97fc3257f2525529" || $_SESSION['user_type_unique_id'] == "68cba503472bd48995") { ?>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                        rowspan="1" colspan="1"
                                                                                        style="width: 0px;">
                                                                                        Action</th>
                                                                                <?php
} ?>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-5"></div>
                                                                <div class="col-sm-12 col-md-7"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
$tabs_po = 'po_product_assign_details';
                                            $columns_1 = [
                                                "batch_id",
                                            ];
                                            $table_details_1 = [
                                                $tabs_po,
                                                $columns_1
                                            ];
                                            $where_1 = "is_active = 1 and is_delete = 0 and form_main_unique_id = '$unique_id' ORDER BY updated DESC LIMIT 1";
                                            $result_values_1 = $pdo->select($table_details_1, $where_1);
                                            if ($result_values_1->status) {
                                                $result_values_1 = $result_values_1->data;
                                                $batch_id1 = $result_values_1[0]["batch_id"];
                                            }
                                            ?>
                                            <input type="hidden" name="batch_record" id="batch_record"
                                                value="<?php
echo $batch_id1; ?>">
                                            <br><br>
                                            <div class="wizard-footer">
                                                <div class="actions">
                                                    <ul>
                                                        <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                                    class="fa fa-arrow-left"></i>
                                                                BACK</span></li>
                                                        <li onclick="get_details(batch_record.value);get_loading();">
                                                            <span class="btn btn-primary js-btn-next" title="NEXT">NEXT
                                                                <i class="fa fa-arrow-right"></i></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
include 'import.php'; ?>
                                <?php
include 'consigneeimport.php'; ?>
                                <input type="hidden" name="demoinpt" id="demoinpt">
                                <div id="loader13" style="display:none;position: fixed; top: 0; width: 85%; height: 100%; background-color: rgba(255, 255, 255, 0.7); z-index: 9999; text-align: center;">
                                    <img src="assets/loading.gif" id="myloaders" style="display:none;position: relative; top: 52%; transform: translateY(-50%); width: 21%;" />
                                </div>
                                <div class="multisteps-form__panel" data-animation="slideVert" id="mytabs"
                                    style="background: white;margin-top: 151px;margin-left: 15px;width: 96%;">
                                    <div class="inner pb-100">
                                        <div class="wizard-content-form">
                                            <div class="wizard-form-field">
                                                <div class="row">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Batch ID
                                                            </label>
                                                            <select class="form-control" name="batch_numbers"
                                                                id="batch_numbers">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <button type="button" style="margin-top: 33px;"
                                                                name="batch_btn" id="batch_btn"
                                                                onclick="get_check_po_batchs(batch_numbers.value);get_loading();"
                                                                class="btn btn-primary">GO</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="return_qty" id="return_qty">
                                                <input type="hidden" name="demoinpt" id="demoinpt">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="mytable" style="margin-top: -122px;">
                                        <div>
                                            <span id="get_qty_msg"></span>

                                        </div>
                                    </div>
                                    <div class="wizard-footer" style="margin-top: 84px;">
                                        <div class="actions">
                                            <ul>
                                                <li id="back"><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                <li id="tab31" onclick="check_qty()"><span title="NEXT"
                                                        class="btn btn-primary js-btn-next">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- </div> -->
                            <!--vendor allocation tab edit  by pavi-->

                            <!-- vendor allocation tab edit by pavi> -->
                            <!--single form panel-->


                            <div class="multisteps-form__panel" data-animation="slideVert" style="margin-top:127px;" id="tab51">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="row">
                                                <?php
$is_disabled = ($status == 2 && $_SESSION['user_type_unique_id'] == '65efd97b4df4040205') ? 'disabled' : '';
                                                ?>
                                                <!-- PO Copy Upload -->
                                                <div class="col-xl-3 po_filediv">
                                                    <div class="mb-3">
                                                        <label class="form-label">Attach PO Copy</label>
                                                        <div style="display:flex;">
                                                            <input type="file" id="po_file" accept="application/pdf" name="po_file"
                                                                class="form-control" value="<?php
echo $file_org_name; ?>" <?= $is_disabled ?>>
                                                            <input type="hidden" name="mypo" id="mypo" value="<?php
echo $po_num ?? ''; ?>">
                                                            <input type="hidden" name="po_attach_file" id="po_attach_file"
                                                                value="<?php
echo $fil_name; ?>">

                                                            <?php
if (!empty($po_file_name)) { ?>
                                                                <span class="ml-1" id="po_attach_view">
                                                                    <a href="javascript:print_pdf_po('<?php
echo $po_file_name; ?>')">
                                                                        <img src="uploads/po_form/po_attach/pdf.png" height="30" width="30" alt="PDF">
                                                                    </a>
                                                                </span>
                                                            <?php
} ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Insurance Required -->
                                                <?php
// $insurence_required = "";


                                                ?>
                                                <div class="form-group form-check mt-2" style="padding-left: 47px;">
                                                    <input type="checkbox" class="form-check-input insurence_required"
                                                        id="insurence_required" name="insurence_required"
                                                        onclick="insurence()" <?php
echo ($insurence_required == 'on') ? 'checked' : ''; ?> <?= $is_disabled ?>>
                                                    <label class="form-check-label">Insurance Required</label><br>

                                                    <div class="row">
                                                        <!-- Insurance Types -->
                                                        <div class="col-xl-3" id="insu_types" style="display:none">
                                                            <div class="mb-3">
                                                                <label class="form-label">Insurance Type</label>
                                                                <select name="insurence_types[]" id="insurence_types" multiple
                                                                    onchange="other_insurence_types()" class="select2 form-control" <?= $is_disabled ?>>
                                                                    <?php
echo $insurance_type_options; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Other Insurance Type -->
                                                        <div class="col-xl-3" id="others_insu_types" style="display:none">
                                                            <div class="mb-3">
                                                                <label class="form-label">Other Ins. Type</label>
                                                                <input type="text" id="other_insurance_type" name="other_insurance_type"
                                                                    class="form-control" placeholder="Please specify"
                                                                    value="<?php
echo $other_insurance_type; ?>" <?= $is_disabled ?>>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div style="overflow: visible; height: auto;">
                                                    <hr style="border: 2px solid #3a3636;">
                                                </div>

                                                <!-- Add HR after insurance -->

                                                <!-- LD Calculation -->
                                                <div class="form-group form-check mt-2" style="padding-left: 47px;">
                                                    <input type="checkbox" class="form-check-input" id="ld_required" name="ld_required"
                                                        onchange="ld_cal_validation()" <?php
echo ($ld_required == 'on') ? 'checked' : ''; ?> <?= $is_disabled ?>>
                                                    <label class="form-check-label">LD Calculation</label><br>

                                                    <div class="row">
                                                        <div class="col-xl-3" id="ld_calculate" style="display:none">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date Type</label>
                                                                <select name="ld_date_type" id="ld_date_type"
                                                                    class="select2 form-control" onchange="ldcalculate()" <?= $is_disabled ?>>
                                                                    <option value="">Select</option>
                                                                    <option value="1" <?php
echo ($ld_date_type == "1") ? "selected" : ""; ?>>From PO Date</option>
                                                                    <option value="2" <?php
echo ($ld_date_type == "2") ? "selected" : ""; ?>>From Consignee Date</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3" id="ld_calculate_1" style="display:none">
                                                            <div class="mb-3">
                                                                <label class="form-label">Delivery Due Date</label>
                                                                <input type="date" id="ld_delivery_due_date" name="ld_delivery_due_date"
                                                                    class="form-control" value="<?php
echo $ld_delivery_due_date ?? ''; ?>" <?= $is_disabled ?>>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3" id="ld_calculate_2" style="display:none">
                                                            <div class="mb-3">
                                                                <label class="form-label">Installation Due Date</label>
                                                                <input type="date" id="ld_installation_due_date" name="ld_installation_due_date"
                                                                    class="form-control" value="<?php
echo $ld_installation_due_date ?? ''; ?>" <?= $is_disabled ?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="overflow: visible; height: auto;">
                                                    <hr style="border: 2px solid #3a3636;">
                                                </div>

                                                <!-- AMC Required -->
                                                <form id="amc_form" enctype="multipart/form-data">
                                                    <div class="form-check form--check-inline" style="padding-left: 47px;">
                                                        <input type="checkbox" class="form-check-input amccheckbox"
                                                            id="amc_required" name="amc_required" onchange="valueChangedamc()"
                                                            <?php
echo ($amc_required == 'on') ? 'checked' : ''; ?> <?= $is_disabled ?>>
                                                        <label class="form-check-label">AMC Required</label><br>

                                                        <div class="row  amcpercendiv" id="amcpercendiv" style="display:none">
                                                            <div class="col-xl-6 pr-5">
                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">Start Date<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <input type="date" id="start_date" name="start_date"
                                                                            class="form-control" value="<?php
echo $start_date; ?>" <?= $is_disabled ?>>

                                                                        <input type="hidden" name="po_attach_files" id="po_attach_files" value="<?php
echo $file_name; ?>">
                                                                        <input type="hidden" name="po_attach_org_files" id="po_attach_org_files" value="<?php
echo $file_org_name; ?>">


                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">AMC%<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <input type="text" id="amc_percentae" name="amc_percentae" onkeypress="return allowOnlyNumbers(event)"
                                                                            class="form-control" value="<?php
echo $amc_percentae; ?>" <?= $is_disabled ?>>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">AMC Net Value<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <!-- <input type="text" id="amcvalue" name="amcvalue" maxlength="15" onkeypress="return allowOnlyNumbers(event)"
                                                            class="form-control" value="<?php
echo $amcvalue; ?>" <?= $is_disabled ?>> -->
                                                                        <input type="number"
                                                                            id="amcvalue"
                                                                            name="amcvalue"
                                                                            maxlength="15"
                                                                            step="0.01"
                                                                            onkeypress="return validateDecimalInput(event, this)"
                                                                            class="form-control"
                                                                            onchange="unitPriceCal()"
                                                                            value="<?php
echo htmlspecialchars($amcvalue); ?>"
                                                                            <?= $is_disabled ?>>


                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">AMC Attach Copy<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <input type="file" id="amcpofile" name="amcpofile" class="form-control" value="" accept=".pdf" <?= $is_disabled ?>>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6 pr-5">
                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">End Date<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <input type="date" id="end_date" name="end_date"
                                                                            class="form-control" value="<?php
echo $end_date; ?>" <?= $is_disabled ?>>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">AMC tax%<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <input type="number"
                                                                            id="amc_tax"
                                                                            name="amc_tax"
                                                                            onchange="unitPriceCal()"
                                                                            class="form-control"
                                                                            value="<?php
echo $amc_tax; ?>"
                                                                            <?= $is_disabled ?>>

                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">AMC Unit Price<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <!-- <input type="text" id="amcvalue" name="amcvalue" maxlength="15" onkeypress="return allowOnlyNumbers(event)"
                                                            class="form-control" value="<?php
echo $amcvalue; ?>" <?= $is_disabled ?>> -->
                                                                        <input type="text"
                                                                            id="amc_unit_price"
                                                                            name="amc_unit_price"
                                                                            class="form-control"
                                                                            value="<?php
echo $amc_unit_price; ?>"
                                                                            <?= $is_disabled ?> readonly>

                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-xl-6">
                                                                        <label class="form-label">Remarks<span class="red-star">*</span></label>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <!-- <input type="text" id="amcvalue" name="amcvalue" maxlength="15" onkeypress="return allowOnlyNumbers(event)"
                                                            class="form-control" value="<?php
echo $amcvalue; ?>" <?= $is_disabled ?>> -->
                                                                        <textarea class="form-control" id="amc_remarks" name="amc_remarks" rows="2"><?php
echo $amc_remarks; ?></textarea>

                                                                    </div>
                                                                </div>



                                                                <!-- Add Btn -->
                                                                <div class="mb-3 addbtn" id="addbtn" style="display:none;display: flex; justify-content: flex-end; margin-top: 18px;">
                                                                    <button type="button" class="btn btn-success amcsub_list_datatable_add_update_btn"
                                                                        onclick="amcsub_list_datatable_add_update()">
                                                                        <i class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                        Add New
                                                                    </button>
                                                                </div>
                                                            </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive mb-2" id="amc_table" style="display:none">
                                            <!-- margin-top: -31px; -->
                                            <div id="amc_datatable_wrapper" style=" width: 77%;" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6"></div>
                                                    <div class="col-sm-12 col-md-6"></div>
                                                </div>
                                                <div class="row m-4">
                                                    <div class="col-sm-12 pl-1 pr-1 ">
                                                        <table id="amc_table_datatable" class="table table-hover table-bordered align-middle mb-0 dataTable no-footer">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="sorting_disabled text-center"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        S.No</th>
                                                                    <th class="sorting_disabled text-center"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        Start Date</th>
                                                                    <th class="sorting_disabled text-center"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        End Date</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        AMC%</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        AMC Net Values</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        AMC Tax Amount</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        AMC Unit Price</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        Remarks</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        Attach AMC PO</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        Attach PO Copy</th>
                                                                    <th scope="col" class="sorting_disabled"
                                                                        rowspan="1" colspan="1" style="width: 0px;">
                                                                        Action</th>
                                                            </thead>
                                                            <tbody> </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="po_form_unique_id" name="po_form_unique_id" value="<?php
echo $result_values[0]["unique_id"]; ?>">

                                        <div class="wizard-footer">
                                            <div class="actions1" style="float: right;">
                                                <ul>
                                                    <li class="action-left">
                                                        <?php
echo btn_cancel($btn_cancel); ?>

                                                        <!--<span class="btn btn-primary js-btn-prev" title="BACK">-->
                                                        <!--    <i class="fa fa-arrow-left"></i> BACK-->
                                                        <!--</span>-->
                                                    </li>
                                                    <?php
if ($update_unique_id == '') { ?>
                                                        <li onclick="term_condition();">
                                                            <span class="btn btn-success js-btn-next" title="NEXT">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Save
                                                            </span>
                                                        </li>
                                                    <?php
} else if ($update_unique_id != '') { ?>
                                                        <li onclick="term_condition();">
                                                            <span class="btn btn-primary js-btn-next" title="NEXT">
                                                                <i class="fa fa-arrow-right"></i>
                                                                Update
                                                            </span>
                                                        </li>
                                                    <?php
} ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- <div class="wizard-footer">
                                        <div>
                                            <ul>
                                                <li>
                                                    <?php
echo btn_cancel($btn_cancel); ?>
                                                </li>
                                                <?php
if ($update_unique_id == '') { ?>
                                                    <li onclick="term_condition();">
                                                        <span class="btn btn-success js-btn-next" title="NEXT"> <i class="fa fa-arrow-right"></i> Save </span>
                                                    </li>
                                                <?php
} else if ($update_unique_id != '') { ?>
                                                        <li onclick="term_condition();">
                                                            <span class="btn btn-primary js-btn-next" title="NEXT"> <i class="fa fa-arrow-right"></i> Update </span>
                                                        </li>
                                                <?php
} ?>
                                            </ul>
                                        </div>
                                    </div> -->
                                    </div>

                                </div> <!--  las tab-->
                            </div>
                    </div>
                </div>

                <!----content start---------->
                <!--  Extra Large modal example -->
                <div class="modal bs-example-modal-xl" id="demos" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Customer Creation</h5>
                                <hr />
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4 head_po">
                                                    <div class="row">
                                                        <div class="col-xl-12 head_po">
                                                            <label class="form-label">Account Sector</label>
                                                            <select class="select form-control" name="acc_sector_1" id="acc_sector_1" required>
                                                                <?php
echo $account_sector_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 head_po">
                                                    <div class="row">
                                                        <div class="col-xl-12 head_po">
                                                            <label class="form-label">Customer</label>
                                                            <input type="text" class="form-control" id="department_txt" name="department_txt" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 head_po">
                                                    <div class="row">
                                                        <div class="col-xl-12 head_po">
                                                            <label class="form-label">Active Status</label>
                                                            <select name="is_active1" id="is_active1" class="select2 form-control" required>
                                                                <?php
echo $active_status_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">Close</a>
                                <button type="button" class="btn btn-primary " onclick="department_create()">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>
</div>
<!-- completed -->

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1" aria-labelledby="itemDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="itemDetailsModalLabel">Item Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="item-details-body">
                    <!-- Table gets injected here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<!-- new -->

<div class="modal fade" id="editConsigneeModal" tabindex="-1" aria-labelledby="editConsigneeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editConsigneeLabel">Edit Consignee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editConsigneeForm">
                    <input type="hidden" class="form-control" id="up_stored_consignee" name="up_stored_consignee">

                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" class="form-control" id="up_con_address" name="up_con_address">
                    </div>
                    <div class="mb-2">
                        <label>State</label>
                        <select name="up_con_state_name" id="up_con_state_name" class="select2 form-control"
                            onchange="up_con_get_district(this.value);" required>
                        </select>
                        <input type="hidden" class="form-control" id="up_con_state_id" name="up_con_state_id"
                            oninput="handleInput(event)">
                    </div>
                    <div class="mb-2">
                        <label>District</label>
                        <select name="up_con_district" id="up_con_district" class="select2 form-control" required>
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

                </form>
            </div>


            <div class="modal-footer">
                <button type="button" onclick="change_verify_address()" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>


<!-- new -->
<div class="modal fade" id="editConsigneeModal_old" tabindex="-1" aria-labelledby="editConsigneeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editConsigneeLabel">Edit Consignee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editConsigneeForm">
                    <input type="hidden" class="form-control" id="up_stored_consignee" name="up_stored_consignee">

                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" class="form-control" id="up_con_address" name="up_con_address">
                    </div>

                    <div class="mb-2">
                        <label>District</label>
                        <select name="up_con_district" id="up_con_district" class="select2 form-control" required>
                        </select>

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
                        <label>GST</label>
                        <input type="text" class="form-control" id="up_consignee_gst" name="up_consignee_gst"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Status</label>
                        <select class="form-select" id="up_verify_sts" name="up_verify_sts">

                        </select>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="change_verify_address()" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="bulkVerifyModal" tabindex="-1" aria-labelledby="bulkVerifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="bulkVerifyModalLabel">Bulk Verify Pending Batches</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table id="pending_verify_datatable"
                    class="table table-bordered table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>
                                Selection <br>(Select All)
                                <input type="checkbox" id="select_all">
                            </th>
                            <th>S.No</th>
                            <th>Batch ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-primary waves-effect waves-light"
                    id="approve_btn"
                    onclick="approval()">
                    Verified
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    // Maps tabKey to its order index
    // Define tab order
    // Define your tab order
    const tabOrder = ['po', 'product', 'consignee', 'assignQty', 'terms'];

    function activateTab(tabKey) {
        const idx = tabOrder.indexOf(tabKey);
        if (idx === -1) {
            return console.warn(`Unknown tab: ${tabKey}`);
        }

        // Reset all tab buttons and content panels
        tabOrder.forEach(key => {
            const btn = document.getElementById(`${key}DetailsBtn`);
            const summary = document.getElementById(`${key}po_tabs`);
            const fullPanel = document.getElementById(`${key}third_tab`);

            if (btn) btn.classList.remove('js-active', 'finished');
            if (summary) summary.classList.remove('js-active');
            if (fullPanel) fullPanel.classList.remove('js-active');
        });

        // Mark finished tabs
        tabOrder.slice(0, idx).forEach(key => {
            const btn = document.getElementById(`${key}DetailsBtn`);
            if (btn) btn.classList.add('finished');
        });

        // Activate selected tab button
        const selectedBtn = document.getElementById(`${tabKey}DetailsBtn`);
        if (selectedBtn) {
            selectedBtn.classList.add('js-active');
        }

        // Show only the relevant content panel
        const summaryPanel = document.getElementById(`po_tabs`);
        if (summaryPanel) {
            summaryPanel.classList.remove('js-active');
        }

        const fullPanel = document.getElementById(`third_tab`);
        if (fullPanel) {
            fullPanel.classList.add('js-active');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab');
        if (tab) activateTab(tab);

        document.querySelectorAll('.multisteps-form__progress-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const key = btn.id.replace('DetailsBtn', '');
                activateTab(key);
                // Optionally update URL or load data
            });
        });
    });

    function isValidGST(input) {
        const gstRegex = /^(UNREGISTERED|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z][A-Z][0-9A-Z])$/;
        return gstRegex.test(input);
    }

    function validateDecimalInput(event, element) {
        const charCode = event.which ? event.which : event.keyCode;
        const value = element.value;

        // Allow digits (0-9)
        if (charCode >= 48 && charCode <= 57) {
            return true;
        }

        // Allow one decimal point
        if (charCode == 46) {
            if (value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        }

        // Disallow other keys
        return false;
    }
    // function activateTab(tabKey) {
    //     alert(tabKey);
    // //   const current = document.querySelector(".multisteps-form__progress-btn.js-active");
    // //   if (current) current.classList.remove("js-active");
    //       const currentActive = document.getElementById("poDetailsBtn");
    //        const below_po_tabs = document.getElementById("po_tabs");


    //     if (currentActive) currentActive.classList.remove("js-active");
    //      if (below_po_tabs) below_po_tabs.classList.remove("js-active");
    // // 
    //   const btn = document.getElementById(`${tabKey}DetailsBtn`);
    //   if (btn) btn.classList.add("js-active");
    //   const btn1 = document.getElementById(`${tabKey}third_tab`);
    //   if (btn1) btn1.classList.add("js-active");
    // }

    // document.addEventListener("DOMContentLoaded", () => {
    //   const params = new URLSearchParams(window.location.search);
    //   const tab = params.get("tab");

    //   if (tab) {
    //     activateTab(tab);
    //   }

    //   // Optional: Make tabs clickable to change tab
    //   document.querySelectorAll(".multisteps-form__progress-btn").forEach(btn => {
    //     btn.addEventListener("click", () => {
    //       const id = btn.id; // e.g. "consigneeDetailsBtn"
    //       const key = id.replace("DetailsBtn", ""); // e.g. "consignee"
    //       activateTab(key);
    //       // add your button-specific logic here
    //     });
    //   });
    // });
    $(document).ready(function() {
        $('#insurence_types').selectpicker();
    });

    $("#con_import_data").click(function() {
        const form_main_unique_id = $("#demo").val();
        const fileInput = document.getElementById('file');
        const no_of_consignee = $("#no_of_consignee").val();
        const cons_verfiy_sts = $("#cons_verfiy_sts").val();
        const batch_id = $("#batch_id").val();
        const consignee_received_date = $("#consignee_received_date").val();
        const po_number = $("#po_numbers").val();

        // Check if the file is selected
        if (fileInput.files.length === 0) {
            alert("Please select a file to upload.");
            return;
        }

        // Create FormData object to send the form data
        const data = new FormData();
        data.append("file", fileInput.files[0]);
        data.append("form_main_unique_id", form_main_unique_id);
        data.append("no_of_consignee", no_of_consignee);
        data.append("cons_verfiy_sts", cons_verfiy_sts);
        data.append("batch_id", batch_id);
        data.append("consignee_received_date", consignee_received_date);
        data.append("po_number", po_number);

        // Make the AJAX request
        $.ajax({
            type: "POST",
            url: 'folders/po_form/con_import_test2.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                let response;
                try {
                    response = JSON.parse(res);
                } catch (e) {
                    console.error("Invalid JSON response", e);
                    alert("Unexpected server response. Please contact support.");
                    return;
                }

                // Handle error responses
                if (response.status === "error") {
                    let errorMessage = `Error: ${response.message}`;

                    // Handle missing staff IDs
                    if (response.missing_ids && response.missing_ids.length > 0) {
                        errorMessage += `\nMissing/Invalid Staff IDs:\n${response.missing_ids.join(", ")}`;
                        // alert(errorMessage); // Show alert for missing IDs
                    }

                    // Handle invalid districts (show modal instead of alert)
                    if (response.invalid_districts && response.invalid_districts.length > 0) {
                        let districtRows = '';
                        response.invalid_districts.forEach((item, index) => {
                            districtRows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>Row ${item.row}</td>
                                <td><strong>${item.district}</strong></td>
                                <td>${item.state}</td>
                                <td>District doesn't match the state</td>
                            </tr>
                        `;

                        });

                        // Populate the modal with invalid district rows
                        $('#districtModalTableBody').html(districtRows);

                        // Show the modal (assuming you have a modal with ID #districtModal)
                        $('#districtModal').modal('show');
                        // Add event listener for export button
                        $("#exportExcelBtn").click(function() {
                            exportToExcel(response.invalid_districts);
                        });
                    }

                    // Show general error alert
                    alert(errorMessage);
                } else {
                    // Clear any previous error messages
                    alert("✔️ Upload successful!");

                    // Close modal if any (define this function if needed)
                    modal_close();

                    // Reload datatable (replace with your function to reload)
                    sub_list_datatable_consignee("consignee_details_datatable");
                }

                // Clear the file input after upload
                $('#file').val('');
            },
            error: function(xhr, status, error) {
                console.error("Upload failed:", error);
                alert("An error occurred while uploading the file.");
            }
        });
    });

    function exportToExcel(invalidDistricts) {
        // Create a worksheet from the invalid districts data
        const ws_data = [
            ["State", "District"], // Column headers
            ...invalidDistricts.map((item, index) => [

                item.state,
                item.district

            ])
        ];

        // index + 1,
        const ws = XLSX.utils.aoa_to_sheet(ws_data);

        // Create a new workbook
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Invalid Districts");

        // Export the Excel file
        XLSX.writeFile(wb, "invalid_districts.xlsx");
    }
    $(document).ready(function() {

        var po_attach_file = $('#po_attach_file').val(); // Correct selector

        if (po_attach_file !== '') {
            $('#po_attach_view').show(); // Correct jQuery usage
        }

        $('#test_demos').DataTable({
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            paging: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Consignee List'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Consignee List'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Consignee List'
                },
                {
                    extend: 'print',
                    title: 'Consignee List'
                }
            ]
        });
    });
</script>



<script>
    function unitPriceCal() {
        var amcvalue = document.getElementById('amcvalue').value;
        var amc_tax = document.getElementById('amc_tax').value;

        if (amc_tax != '' && amcvalue != '') {
            var unitValue = amcvalue / (1 + (amc_tax / 100));
            document.getElementById('amc_unit_price').value = unitValue;
        } else {
            console.log('Net Value is first fill then GST');
        }
    }
    $(document).ready(function() {
        // alert("hii");
        var state_name = document.getElementById('state_name').value;
        var district = document.getElementById('dis_id').value;
        // alert(district);
        if (state_name != '') {
            get_district(state_name, district);
        }
    });


    function con_validateGST(input) {
        let gst = input.value.toUpperCase();
        input.value = gst; // force uppercase

        // GST format: 15 characters -> 2 digits + 10 PAN + 1 entity + 1 Z + 1 checksum
        let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;



        if (!gstRegex.test(gst)) {
            document.getElementById("con_billgst_error").style.display = "block";
        } else {
            document.getElementById("con_billgst_error").style.display = "none";
        }
        // } else {
        //     document.getElementById("con_billgst_error").style.display = "none";
        // }
    }


    function update_val() {
        var up_con_state_id = document.getElementById('up_con_state_id').value;
        var up_con_district_id = document.getElementById('up_con_district_id').value;
        if (up_con_state_id != '') {
            up_con_get_district(up_con_state_id, up_con_district_id);
        }
    }

    function con_get_district(state_id = "") {
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (state_id == '' || state_id != '') {
            var data = {
                "state_id": state_id,
                "action": "con_get_state_name"
            }

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {

                    if (data) {
                        $("#con_district").html(data);


                    }
                }
            });
        }
    }

    function up_con_get_district(state_id = "", district = "") {
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (state_id == '' || state_id != '') {
            var data = {
                "state_id": state_id,
                "district": district,
                "action": "up_con_get_state_name"
            }

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {

                    if (data) {

                        $("#up_con_district").html(data);


                    }
                }
            });
        }
    }

    function print_pdf_po(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }


    function print_pdf_amc(file_name) {

        onmouseover = window.open('uploads/amc/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }



    let pendingVerifyTable = null;

    $(document).ready(function() {

        $('#bulkVerifyModal').on('shown.bs.modal', function() {

            var table_id = 'pending_verify_datatable';
            var table = $('#' + table_id);

            var unique_id = $('#unique_id').val() || '';
            // alert(unique_id); // for testing

            if ($.fn.DataTable.isDataTable('#' + table_id)) {
                pendingVerifyTable.ajax.reload(null, false);
                return;
            }

            pendingVerifyTable = table.DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                searching: true,
                autoWidth: false,

                ajax: {
                    url: sessionStorage.getItem("folder_crud_link"),
                    type: "POST",
                    data: function(d) {
                        d.action = "pending_verify_datatable";
                        d.unique_id = unique_id;
                    }
                },

                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="row_check" value="${row[0]}">`;
                        },
                        orderable: false
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 1
                    },
                    {
                        data: 2
                    }
                ],

                dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>>rt<ip>',

                buttons: [{
                        extend: 'copyHtml5'
                    },
                    {
                        extend: 'csvHtml5'
                    },
                    {
                        extend: 'excelHtml5'
                    },
                    {
                        extend: 'pdfHtml5'
                    },
                    {
                        extend: 'print'
                    }
                ]
            });
        });

        /* Select All */
        $(document).on('click', '#select_all', function() {
            $('.row_check').prop('checked', this.checked);
        });

    });



    function approval() {
        var internet_status = is_online();

        // Collect all selected form_main_unique_id values
        let selectedIDs = [];
        document.querySelectorAll('.row_check:checked').forEach(function(cb) {
            selectedIDs.push(cb.value);
        });
        if (selectedIDs.length === 0) {
            sweetalert("Please select at least one record!");
            return;
        }

        // Send all IDs in one AJAX request
        $.ajax({
            type: "POST",
            url: sessionStorage.getItem("folder_crud_link"),
            data: {
                ids: selectedIDs,
                action: "approval"
            },
            beforeSend: function() {
                $("#approve_btn").attr("disabled", "disabled").text("Loading...");
            },
            success: function(data) {
                Swal.fire({
                    title: "Verified Successfully",
                    icon: "success",
                    confirmButtonText: "OK"
                });

                location.reload();
            },
            error: function() {
                alert("Network Error");
            }
        });
    }
</script>
<script src='folders/po_form/main_script.js'></script>
<script src='folders/po_form/script.js'></script>

<!-- jQuery (Load First) -->

<!-- Main.js (Can be here if not dependent on DataTables) -->
<script src="assets/js/main.js"></script>

<script src="assets/js/common.js"></script>

<link rel="stylesheet" href="assets/css/bootstrap4.1.1.min.css">


