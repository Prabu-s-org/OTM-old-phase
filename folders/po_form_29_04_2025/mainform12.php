<style>
    .img {
        width: 49px;
        margin-top: 18px;
        /* margin-right:200px; */
    }

    label {
        font-weight: 500 !important;

    }

    form.was-validated button 2
        float: inline-start;
    }

    #unregistered_message {
        font-size: 15px;
        color: red;

    }
.modal .bs-example-modal-xl{position: relative !important;}
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
    width: 157%;
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
</style>
 
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

<?php
require_once __DIR__ . '/../../config/env.php'; include 'function.php'; ?>
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
            // 
            //     "(SELECT GROUP_CONCAT(staff_name SEPARATOR ', ') 
        //  FROM user 
        //  WHERE FIND_IN_SET(user.unique_id, team_allocation.eng_name)) AS eng_name",
        
        // slect GROUP_CONCAT(po_number) from vendo
            // 

      "(SELECT GROUP_CONCAT(DISTINCT vendor_name SEPARATOR ', ') FROM vendor_allocation  WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_name",
    // "(SELECT state_name FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_state",
    "(SELECT GROUP_CONCAT(DISTINCT state_name SEPARATOR ', ') FROM vendor_allocation  WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_state",
 
 
  "(SELECT GROUP_CONCAT(DISTINCT district SEPARATOR ', ') 
 FROM vendor_allocation 
 WHERE vendor_allocation.po_number = po_form.po_num) AS vendor_district",

    
        // "(SELECT district FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_district",
    "(SELECT zone FROM vendor_allocation WHERE vendor_allocation.po_number = po_form.po_num LIMIT 1) AS vendor_zone"
            // "zone",

        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);
        
        //  print_r($result_values);

        if ($result_values->status) {

            $result_values = $result_values->data;
            $po_unique_id = $result_values[0]["po_unique_id"];
              $amc_required = $result_values[0]["amc_required"];
            $po_num = $result_values[0]["po_num"];
            $po_date = $result_values[0]["po_date"];
            $department = $result_values[0]["department"];
            $gst_option = $result_values[0]["gst_option"];
            $gst_value = $result_values[0]["gst_value"];
            $executive_name = $result_values[0]["executive_name"];
            $bill_address = $result_values[0]["bill_address"];
            $contact_name = $result_values[0]["contact_name"];
            $contact_number = $result_values[0]["contact_number"];
            $contact_landline_num = $result_values[0]["contact_landline_num"];
            $email = $result_values[0]["email"];
            $district = $result_values[0]["district"];
            $pin = $result_values[0]["pin"];
             
            // $po_prepared_by          = $result_values[0]["po_prepared_by"];
            $po_type = $result_values[0]["po_type"];
            $no_of_po = $result_values[0]["no_of_po"];
            $delivery_due_dates = $result_values[0]["delivery_due_dates"];
            $ld_per_day = $result_values[0]["ld_per_day"];
            $ld_maximum_val = $result_values[0]["ld_maximum_val"];
            $warranty = $result_values[0]["warranty"];
            $warranty_duration = $result_values[0]["warranty_duration"];
            $ins_reqired = $result_values[0]["ins_reqired"];
            // $bank_required = $result_values[0]["bank_required"];
            $dc_required = $result_values[0]["dc_required"];
            $bg = $result_values[0]["bg"];
            $file_org_name = $result_values[0]["file_org_name"];
            $bg_month = $result_values[0]["bg_month"];
            $no_of_consignee = $result_values[0]["no_of_consignee"];
            $update_unique_id = $result_values[0]["unique_id"];
            $is_active = $result_values[0]["is_active"];

            $state_name = $result_values[0]["state_name"];
            
            
            
              $vendor_state  = $result_values[0]["vendor_state"];
              
            $vendor_district = $result_values[0]["vendor_district"];

            //   
            // print_r($vendor_state);
            
            $vendor_name  = $result_values[0]["vendor_name"];
            
            $zone          = $result_values[0]["zone"];
            
            $vendor_zone  = $result_values[0]["vendor_zone"];
            
            
            if( $amc_required=='on'){
                $amcwhere = "po_unique_id = '" . $_GET["unique_id"] . "'";
        $tableamc = "amcrequired";
        
        $amccolumns = [
                  
 "start_date",
 "end_date",
 "amc_percentae",
 "amcvalue",
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
$department_options = select_option($department_options, "Select Department", $department);

$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

$tender_code_options = tender_name($tender_code);
$tender_code_options = select_option1($tender_code_options, "Select Tender");

$item_code_options = item_name($item_code);
$item_code_options = select_option($item_code_options, "Select Item Code");

$state_name_options = state_option();
$state_name_options = select_option($state_name_options, "Select State Name", $state_name);


// $vendor_state_values = explode(', ', $vendor_state); // Convert to array


// $vendor_state_options  = state_option();
// $vendor_state_options  = select_option($vendor_state_options,"Select State Name",$vendor_state_values);




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
<!-- start page title -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/fontawesome-all.css">



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

   <script src="assets/libs/select2/js/select2.min.js"></script>
 
<div class="row">

    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> PO Form</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> PO Form</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!--<div class="card-header">
                <h4 class="card-title mb-0">District Creation</h4>
            </div>-->
        <div class="wrapper1 clearfix">

            <!--multisteps-form-->
            <div class="multisteps-form">
                <!--progress bar-->
                <div class="row">
                    <div class="col-12 col-lg-12 ml-auto mr-auto mb-2 mt-0">
                        <div class="multisteps-form__progress">
                            <button class="multisteps-form__progress-btn js-active">PO Details</button>
                            <button class="multisteps-form__progress-btn">Product Details</button>
                            <button class="multisteps-form__progress-btn">Consignee Details</button>
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
                        <form class="multisteps-form__form was-validated clearfix " action="#" method="post"
                            id="wizard">
                            <input type="hidden" id="m_unique_id" name="m_unique_id" value="<?php echo $unique_id; ?>">
                            <input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
                                value="<?php echo $unique_id; ?>">

                            <input type="hidden" id="unique_id" name="unique_id"
                                value="<?php echo $update_unique_id; ?>">

                            <input type="hidden" id="demo" name="demo" value="<?php if ($update_unique_id != '') {
                                echo $update_unique_id;
                            } else {
                                echo $unique_id;
                            } ?>">

                            <input type="hidden" id="po_unique_id" name="po_unique_id"
                                value="<?php echo $po_unique_Id; ?>">

                            <!--single form panel-->
                            <div class="multisteps-form__panel js-active" data-animation="slideVert">
                                <div class="inner pb-100">
                                    <!--<div class="wizard-topper">
                                        <div class="wizard-progress">
                                            <div class="progress">
                                                <div class="progress-bar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="wizard-content-form po_form_valid" id="po_form_valid">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <h5 style="float:right;">

                                                            <b><?php echo $po_unique_id; ?></b>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">PO
                                                                Number<span class="red-star">*</span></label>
                                                            <input type="text" id="po_num" name="po_num"
                                                                class="form-control" onchange="get_po_no();"
                                                                oninput="validateCharInput(this)" value="<?php if ($po_num != '') {
                                                                    echo $po_num;
                                                                } ?>" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">PO
                                                                Date<span class="red-star">*</span></label>
                                                            <input type="date" id="po_date" name="po_date"
                                                                class="form-control" value="<?php echo $po_date; ?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">

                                                            <label class="form-label">Department<span
                                                                    class="red-star">*</span></label>
                                                                    <br>

                                                            <select  class="selectpicker form-control" name="department"   data-live-search="true" id="department"
                                                                name="department" required>
                                                                <?php echo $department_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3" align="right">
                                                        <div class="mb-3" id="modal">
                                                            <!-- <button type="button" class="btn btn-primary"> -->
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target=".bs-example-modal-xl">
                                                                <i
                                                                    class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2 btn btn-primary"></i></a>
                                                            <!-- </button> -->
                                                        </div>
                                                    </div>



                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="old_gst_option"
                                                                name="old_gst_option"
                                                                value="<?php echo $gst_option; ?>" />
                                                            <label class="form-label">GST
                                                                Option</label>
                                                            <?php
                                                            if ($gst_option == 'yes') { ?>
                                                                <select class="form-select mb-3" id="gst_option"
                                                                    name="gst_option" onchange="gst_check()" required>
                                                                    <option>selcet option</option>
                                                                    <option value="yes" selected>Yes
                                                                    </option>
                                                                    <option value="no">No</option>

                                                                </select>
                                                            <?php } else if ($gst_option == 'no') { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchage="gst_check()" value="<?php echo $gst_option; ?>">
                                                                        <option>selcet option</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no" selected>No
                                                                        </option>

                                                                    </select>
                                                            <?php } else { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchange="gst_check()" value="<?php echo $gst_option; ?>">
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>

                                                                    </select>
                                                            <?php } ?>

                                                        </div>

                                                        <span id="unregistered_message">GST Unregistered </span>

                                                    </div>

                                                    <div class="col-xl-3" id="gst_num">
                                                        <div class="mb-3">
                                                            <label class="form-label">Customer GST Number</label>
                                                            <input type="text" id="gst_value" name="gst_value"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                onchange="validagst1(this)"
                                                                value="<?php echo $gst_value; ?>" required>
                                                                <input type="hidden" name="testin" id="testin" value='0'>
                                                            <span id="gst_error"
                                                                style="color: red; display: none;">Enter a valid GST
                                                                number</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">

                                                            <label class="form-label">Excutive
                                                                Name<span class="red-star">*</span></label>
                                                            <select class="form-select mb-3" id="executive_name"
                                                                name="executive_name" required>
                                                                <?php echo $executive_name_options; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">

                                                            <label class="form-label">Billing Address<span
                                                                    class="red-star">*</span></label>
                                                            <textarea id="bill_address" name="bill_address"
                                                                class="form-control" oninput="validateCharInput(this)"
                                                                required><?php echo $bill_address; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Name</label>
                                                            <input type="text" id="contact_name" name="contact_name"
                                                                class="form-control" oninput="valid_user_name(this)"
                                                                value="<?php echo $contact_name; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Number</label>
                                                            <input type="text" id="contact_number" name="contact_number"
                                                                class="form-control" oninput="valid_mobile_number(this)"
                                                                value="<?php echo $contact_number; ?>" minlength="10"
                                                                maxlength="10">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Landline
                                                                Number</label>
                                                            <input type="text" id="contact_landline_num"
                                                                name="contact_landline_num" class="form-control" maxlength="12"
                                                                value="<?php echo $contact_landline_num; ?>"
                                                                oninput="validateLandline(this)">
                                                            <!-- onkeypress="return isNumber(event)" -->
                                                            <!--<span id="landline_error" class="text-danger"></span>-->
                                                            <!-- Error message span -->
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="text" id="email" name="email"
                                                                onkeypress="validateEmail(event)" class="form-control"
                                                                value="<?php echo $email; ?>">
                                                            <span id="emailValidationMessage"></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">State</label>
                                                         
                                                            <!--    class="form-control" value="">-->
                                                             <!--data-live-search="true" data-live-search="true"-->
                                                            <select name="state_name" id="state_name"
                                                                class="form-control" 
                                                                onchange="get_district(this.value)" required>
                                                                <?php echo $state_name_options; ?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">District</label>
                                                         
                                                     
                                                            <select id="district"  name="district" class="form-control"  required> 
                                                                <!--<option value="">Select District</option>-->
                                                               <?php echo $district_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                           <!--  
                                                        class="form-select mb-3"-->
                                                         <!--<?php echo $district_options; ?>-->

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">

                                                            <label class="form-label">Pin
                                                                Code<span class="red-star">*</span></label>
                                                            <input type="text" id="pin" name="pin" class="form-control"
                                                                onkeypress="return isNumber(event)" minlength="6"
                                                                maxlength="6" value="<?php echo $pin; ?>" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">PO
                                                                Prepared by
                                                            </label>
                                                            <input type="text" id="po_prepared_by" name="po_prepared_by"
                                                                class="form-control" 
                                                                value="<?php echo $po_prepared_by; ?>" required>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">

                                                            <label class="form-label"> PO Type<span
                                                                    class="red-star">*</span>
                                                            </label>
                                                            <select class="form-select mb-3" id="po_type" name="po_type"
                                                                aria-label="Default select example"
                                                                value="<?php echo $po_type; ?>" required>
                                                                <?php echo $po_type_options; ?>
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
                                                                maxlength="3" value="<?php echo $no_of_po; ?>" required>

                                                        </div>
                                                    </div>
                                                    <!--<div class="col-xl-3">-->
                                                    <!--    <div class="mb-3">-->

                                                    <!--        <label class="form-label">No of-->
                                                    <!--            Consignee</label>-->
                                                    <!--        <input type="text" id="no_of_consignee"-->
                                                    <!--            name="no_of_consignee" class="form-control"-->
                                                    <!--            onkeypress="return isNumber(event)" maxlength="5"-->
                                                    <!--            value="<?php echo $no_of_consignee; ?>" >-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                                
                                                    <li onclick="po_form_cu();" id="checkit">
    <span class="btn btn-primary js-btn-next" title="NEXT">
        Save & Continue <i class="fa fa-arrow-right"></i>
    </span>
</li>

                                                <?php if ($update_unique_id != '') { ?>
                                                      <li onclick="po_form_cu()"><span class="btn btn-primary js-btn-next"
                                                                title="NEXT"
                                                                class="btn btn-success waves-effect waves-light">Update
                                                                &continue<i class="fa fa-arrow-right"></i></span>
                                                        </li>  

                                                <?php } ?>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--single form panel-->



                            <div class="multisteps-form__panel" data-animation="slideVert" id="sec_tab">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <!-- <form class="was-validated" id="product_detail"> -->
                                                <div class="row">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tender
                                                                Code</label>

                                                            <select name="tender_code" id="tender_code" onchange="tender_codes()"
                                                                class="select2 form-control select2_op" required>
                                                                <?php echo $tender_code_options; ?></select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Item Code</label>
                                                            <!--                                                                 
                                                            <input type="text" id="item_code" name="item_code" 
                                                                class="form-control" value="<?php echo $item_code; ?>"
                                                                > -->
                                                            <select name="item_code" id="item_code"
                                                                class="select2 form-control select2_op" required
                                                                onchange="item_detail(this.value)">
                                                                 <?php echo $item_code_options; ?> 
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Product</label>
                                                            <input type="text" id="po_name" name="po_name"
                                                                class="form-control" value="<?php echo $product; ?>"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Qty</label>
                                                            <input type="text" id="qty" name="qty" onchange="CalculateTotal()" class="form-control"
                                                                oninput=quantity_number(this);
                                                                value="<?php echo $qty; ?>" required>
                                                            <!-- onkeypress="return isNumber(event)" -->
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-xl-3 ">-->
                                                    <!--    <div class="mb-3">-->
                                                    <!--        <label class="form-label">-->
                                                    <!--            Tax Type</label>-->
                                                            
                                                    <!--        <select name="tax_type" id="tax_type"-->
                                                    <!--            class="select2 form-control select2_op" -->
                                                    <!--            onchange="tax_type_chnge()">-->
                                                    <!--            <option value="">Select</option>-->
                                                    <!--           <option value='1'>With Tax</option>-->
                                                    <!--            <option value='2'>WithOut Tax</option>-->
                                                    <!--        </select>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--id="price_1" style="display:none"-->
                                                    <div class="col-xl-3"  >
                                                        <div class="mb-3">
                                                            <label class="form-label">Unit
                                                                Price</label>
                                                            <input type="text" id="unit_price" name="unit_price"
                                                                class="form-control"
                                                                value="<?php echo $unit_price; ?>" required readonly>
                                                                
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-3"  >
                                                        <div class="mb-3">
                                                            <label class="form-label">Net price<span style="color:red">(with tax)</span></label>
                                                            <input type="text" id="net_price" name="net_price"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                value="<?php echo $net_amount; ?>" required readonly>
                                                                 
                                                        </div>
                                                    </div>
                                                    
                                                     
                                                    <div class="col-xl-3 " >
                                                        <div class="mb-3">
                                                            <label class="form-label">Tax</label>
                                                            <!--<select class="form-select mb-3" id="tax" name="tax">-->
                                                                <!--<?php echo $tax_select_options; ?>-->
                                                            <!--</select>-->
                                                            <input type="text" id="tax" class="form-control" name="tax" value="<?php echo $tax;?>" readonly>
                                                            <!--required-->
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-xl-3 " >
                                                        <div class="mb-3">
                                                            <label class="form-label">Total
                                                                Net Amount <span style="color:red;">( With Tax )</span></label>
                                                            <input type="text" id="total_value" name="total_value"
                                                                class="form-control" value="<?php echo $total_value; ?>"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Total Without Tax
                                                            </label>
                                                            <input type="text" id="net_value" name="net_value"
                                                                class="form-control" value="<?php echo $net_value; ?>"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Delivery
                                                                Due
                                                                Days</label>
                                                            <input type="text" id="delivery_due_dates"
                                                                name="delivery_due_dates" class="form-control"
                                                                onkeypress="return isNumber(event)"
                                                                value="<?php echo $delivery_due_dates; ?>" required>
                                                                 <span style="color:red">Valid The Delivery Due Dates in RFP</span>
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Installation Due Days</label>
                                                            <input type="text" id="insta_due_days"
                                                                name="insta_due_days" class="form-control"
                                                                onkeypress="return isNumber(event)"
                                                                value="<?php echo $installation_due_dates; ?>" required>
                                                                <span style="color:red">Valid The Delivery Due Dates in RFP</span>
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">LD Type</label>
                                                            <select class="form-select mb-3"id="ld_type" name="ld_type">
                                                                <!--<option value="">Select</option>-->
                                                               <option value="day">LD Per Day</option>
                                                                <option value="week">LD Per Week</option>
                                                           </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" id="ld_label_day">LD% Per Day</label>
                                                            <label class="form-label" id="ld_label_week" style="display: none;">LD% Per Week</label>
                                                                <input type="text" id="ld_per_day" name="ld_per_day" onkeypress="return isNumberss(event)" onkeyup="validateNumber(this)" class="form-control" value="<?php echo $ld_per_day; ?>">
                                                                
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">LD
                                                                Maximum
                                                                %</label>
                                                            <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                                class="form-control" onkeypress="return isNumberss(event)" onkeyup="validateNumber(this)"
                                                                value="<?php echo $ld_maximum_val; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="old_warranty" name="old_warranty"
                                                                value="<?php echo $warranty; ?>" />

                                                            <label class="form-label">Warranty</label>
                                                            <?php
                                                            if ($warranty == '1') { ?>
                                                                <select class="form-select mb-3" id="warranty"
                                                                    name="warranty">
                                                                    <option value="1" selected>
                                                                        Yes
                                                                    </option>
                                                                    <option value="0">
                                                                        No
                                                                    </option>
                                                                </select>
                                                            <?php } else if ($warranty == '0') { ?>
                                                                    <select class="form-select mb-3" id="warranty"
                                                                        name="warranty">
                                                                        <option value="1">
                                                                            Yes
                                                                        </option>
                                                                        <option value="0" selected>
                                                                            No
                                                                        </option>
                                                                    </select>
                                                            <?php } else { ?>
                                                                    <select class="form-select mb-3" id="warranty"
                                                                        name="warranty">
                                                                        <option value="1">
                                                                            Yes
                                                                        </option>
                                                                        <option value="0">
                                                                            No
                                                                        </option>
                                                                    </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3" id="select_warranty">
                                                        <div class="mb-3">
                                                            <label class="form-label">Warranty
                                                                Duration</label>
                                                            <select class="form-select mb-3" id="warranty_duration"
                                                                name="warranty_duration"
                                                                value="<?php echo $warranty_duration; ?>">
                                                                <?php echo $warranty_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Document Required</label>
                                                    <select name="document_required" id="document_required"  class="select2 form-control" >
                                                                 <option value="">Select</option>
                                                                <option value="dc_required">DC Required</option>
                                                                <option value="ir_required">IR Required</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Warranty Starts From</label>
                                                    <select name="warranty_starts" id="warranty_starts"  class="select2 form-control">
                                                          <option value="">Select</option>
                                                                <option value="delivery_date">Delivery Date</option>
                                                                <option value="installation_date">Installation Date</option>
                                                                    <option value="installation_date">Last Installation Date</option>
                                                                        <option value="installation_date">Invoice Date</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">BG Required</label>
                                                    <select name="bg_required" id="bg_required"  class="select2 form-control"  onchange="BGrequired()">
                                                         <option value="">Select</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                                   
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" style="display:none" id="bgrequireddivs">
                                                        <div class="mb-3">
                                                            <label class="form-label">BG%</label>
                                                            <input type="text" name="bg_percen" id="bg_percen" class="form-control" >
                                                        </div>
                                                    </div><div class="col-xl-3" style="display:none" id="bgrequireddiv">
                                                        <div class="mb-3">
                                                            <label class="form-label">BG Month</label>
                                                            <input type="text" name="bg_month" id="bg_month" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" style="display:none" id="dates">
                                                        <div class="mb-3">
                                                            <label class="form-label">Date</label>
                                                            <input type="date" name="date_type" id="date_type" class="form-control" >
                                                        </div>
                                                    </div>
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
  .datee1{
      margin-top: -28px;
    margin-left: 153px;
  }
  #mydate{
      margin-left: 27px;
  }
  .btns{
      margin-top: 73px;
    margin-left: 139px;
  }
</style>

<!--<div class="col-xl-3" id="mydate">-->
                                                        <!--<div class="mb-3">-->
<!--<div class="mb-3">-->
<!--  <label class="form-label d-block">Select Date Types</label>-->

<!--  <div class="date-row">-->
<!--    <input class="form-check-input" type="checkbox" id="date_delivery" value="delivery" onchange="toggleDateInput(this)">-->
<!--    <label class="form-check-label" for="date_delivery">Delivery Date</label>-->
<!--    <input type="date" name="delivery_date" id="input_delivery" class="form-control datee1" style="display:none;">-->
<!--  </div>-->

<!--  <div class="date-row">-->
<!--    <input class="form-check-input" type="checkbox" id="date_installation" value="installation" onchange="toggleDateInput(this)">-->
<!--    <label class="form-check-label me-3" for="date_installation">Installation Date</label>-->
<!--    <input type="date" name="installation_date" id="input_installation" class="form-control datee1" style="display:none;">-->
<!--  </div>-->

<!--  <div class="date-row">-->
<!--    <input class="form-check-input" type="checkbox" id="date_golive" value="golive" onchange="toggleDateInput(this)">-->
<!--    <label class="form-check-label me-3" for="date_golive">Go Live Date</label>-->
<!--    <input type="date" name="golive_date" id="input_golive" class="form-control datee1" style="display:none;">-->
<!--  </div>-->

<!--  <div class="date-row">-->
<!--    <input class="form-check-input" type="checkbox" id="date_custom" value="custom" onchange="toggleDateInput(this)">-->
<!--    <label class="form-check-label me-3" for="date_custom">Custom Date</label>-->
<!--    <input type="date" name="custom_date" id="input_custom" class="form-control datee1" style="display:none;">-->
<!--  </div>-->
<!--</div>-->
                                                        <!--</div>-->
<!--                                                    </div>-->


                                                    <input type="hidden" name="stored_item" id="stored_item">
                                                    <input type="hidden" name="count_item" id="count_item">

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php echo $no_of_po; ?>">-->
                                                            <button type="button" id="pro_details" style="margin-top: -101px;position: relative;margin-left: 344%;"
                                                                class="btn btn-success btn-label product_details_add_update_btn btns"
                                                                onclick="product_details_add_update(),get_po_item()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>

                                                        </div>
                                                    </div><!-- end col -->
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
                                                                        <thead class="table-light">
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
                                                                                    Elcot Item Code</th>
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
                                                                                    style="width: 0px;">Warranty Starts From</th>
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
            <th colspan="8" class="text-right">Total:</th>
            <th id="sum_net_value">0</th>
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
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-5"></div>
                                                                <div class="col-sm-12 col-md-7"></div>
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
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>

                                                <li id="product_data"><span title="NEXT"
                                                        class="btn btn-primary js-btn-next">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert" id="third_tab">
                                <div class="inner pb-100">
                                  

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">
<style>
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

  .mode-selector input[type="radio"]:checked + label {
    background-color: #0d6efd;
    color: white;
  }

  .mode-label {
    text-align: center;
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 10px;
  }
</style>
<!-- Bootstrap Modal -->
<div class="modal fade" id="consigneeModal"  tabindex="-1" aria-labelledby="consigneeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="mddd">
      <div class="modal-header">
        <h5 class="modal-title">Consignee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="consigneeModalBody">
          
        Loading...
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-auto text-center">
      <div class="mode-label">Select Mode:</div>
      <div class="mode-selector">
        <input type="radio" name="entry_mode" id="mode_entry" value="entry" >
        <label for="mode_entry">Entry</label>

        <input type="radio" name="entry_mode" id="mode_import" value="import" checked>
        <label for="mode_import">Import</label>
      </div>
    </div>
  </div>
</div>
              <?php
                                        
                             

        // $where = "form_main_unique_id = '" . $_GET["unique_id"] . "'";
        $table_2 = "po_form";
        
        // $tabs_po = 'po_product_assign_details';

        $columns_2 = [
          "po_num",
        ];

        $table_details_2 = [
            $table_2,
            $columns_2
        ];
        $where_2 = "is_active = 1 and is_delete = 0 ORDER BY unique_id DESC LIMIT 1";
        $result_values_2 = $pdo->select($table_details_2, $where_2);
        // print_r($result_values_2);
        //  print_r($result_values);

        if ($result_values_2->status) {

            $result_values_2 = $result_values_2->data;
             $store_unique_id = $result_values_2[0]["unique_id"];
             
            
        }
                                        ?>
 <input type="hidden" name="po_numbers" id="po_numbers" class="form-control" >
<div class="row" id="frst_ops" style="display:none">
    
              <div class="col-xl-3">
                  
                  <?php 
 
function batch_id()
{
    $date = date('Y');
    $st_date = substr($date, 2); // last 2 digits of year
    $month = date('m'); // current month
    $datee = $st_date . $month; // e.g., 2504

    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
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
            $last_seq = (int)$pur_array[3];

            if ($last_datee === $datee) {
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
                  
                                                        <div class="mb-3">
                                                            <label class="form-label">Batch ID</label>
                                                             <input type="text" name="batch_id" id="batch_id"
                                                                class="form-control"
                                                                value="<?php echo $batch_id; ?>">
                                                                
                                                                

                                                        </div>
                                                    </div>
                                                   
                                                    
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Received Date</label>
                                                            <input type="date" name="consignee_received_date" id="consignee_received_date" class="form-control"  value="<?php echo date('Y-m-d');?>"  >
                                                        </div>
                                                    </div>
<!--</div>-->
 
                                                                 </div>
<div class="row" id="myrows" style="display:none">
    <div class="col-xl-3">
                                                            <div class="mb-3">
            <div class="btn-header" id="import_option" style="margin-top: -26%;
    margin-left: 221%;">
                                                                    <a href="javascript:excel_popup()">
                                                                        <button  type="button" id="export1" name="export1"
                                                                            class="btn btn-primary  waves-effect waves-light wavw mb-1 mt-1"><i
                                                                                class="ri-file-excel-2-fill"></i>
                                                                            &nbsp;Import </button></a>
                                                                </div>
                                                                 </div>
</div>
</div>
                                                <div class="row" id="sec_ops" style="display:none">
                                                    
                                                    <input type="hidden" id="no_of_consignee" name="no_of_consignee"
                                                        class="form-control" value="<?php echo $no_of_consignee; ?>">
                                                        
                                               
                                                            
                                                            

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Address</label>
                                                            <textarea name="con_address" id="con_address"
                                                                oninput="validateCharInput(this)" class="form-control"
                                                                required></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" id="d1">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee District</label>
                                                           
                                                            <select name="con_district" id="con_district"
                                                                class="select2 form-control" required>
                                                                <?php echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" id="d2" style="display:none;">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee District</label>
                                                            
                                                            <select name="con_district" id="con_district"
                                                                class="select2 form-control" required>
                                                                <?php echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Zone</label>
                                                            <input type="text" name="zone" id="zone"
                                                                oninput="valid_user_name(this)" class="form-control"
                                                                value="<?php echo $zone; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Pincode</label>
                                                            <input type="text" id="con_pincode" name="con_pincode"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                minlength="6" maxlength="6"
                                                                value="<?php echo $con_pincode ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Contact Name </label>
                                                            <input type="text" id="con_contact_name"
                                                                name="con_contact_name" class="form-control"
                                                                oninput="valid_user_name(this)"
                                                                value="<?php echo $con_contact_name ?>" required>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Contact Number
                                                            </label>
                                                            <input type="text" id="con_contact_number"
                                                                name="consignee_number" class="form-control"
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10"
                                                                value="<?php echo $con_contact_number ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Landline Number
                                                            </label>
                                                            <input type="tel" id="con_lan_num" name="con_lan_num"
                                                                oninput="valid_landline_number(this)" maxlength="12"
                                                                class="form-control" value="<?php echo $con_lan_num ?>">

                                                          
                                                        </div>
                                                        
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3 ">
                                                     <div class="mb-3">
                                                         <label class="form-label">Consignee Address verification
                                                            </label>
                                                            <select class="form-control" name="verify_sts" id="verify_sts">
                                                                
                                                                <option value="">Select </option>
                                                                <option value="1">Verified</option>
                                                                 <option value="2">Not Verified</option>
                                                            </select>
                                                        </div>
                                                         </div>
                                                         <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">GST
                                                            </label>
                                                            <input type="text" id="consignee_gst" name="consignee_gst"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                oninput="consigneevalidateGST(this)"
                                                                value="<?php echo $consignee_gst; ?>" required>

                                                           <span id="con_gst_error"
                                                                style="color: red; display: none;">Enter a valid GST
                                                                number</span>

                                                        </div>
                                                        
                                                    </div>
                                                    <input type="hidden" name="count_consignee" id="count_consignee">
                                                    <input type="hidden" name="stored_consignee" id="stored_consignee">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3" style="margin-top: 34px;">
                                                            <button type="button"  style="display:none" id="mybtns" 
                                                                class="btn btn-success consignee_details_add_update_btn"
                                                                onclick="consignee_details_add_update(),get_stored_sublist_count()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>
                                                        </div>
                                                       
                                                        
                                                       

                                                    </div><!-- end col -->
                                                    
                                                    
                                                    

                                                            
                                                                <!--<div class="btn-header" >-->
                                                                <!--    <a href="javascript:excel_export()"><button-->
                                                                <!--            type="button" id="excelexport" name="excelexport"-->
                                                                <!--            class="btn btn-success  waves-effect waves-light wavw mb-1 mt-1"><i-->
                                                                <!--                class="ri-file-excel-2-fill"></i>-->
                                                                <!--            &nbsp;Export</button></a>-->
                                                                <!--</div>-->

                                                    </div>
                                                     </div>
                                                    <div class="row" style="dislay:none" id="frst_1_ops">
                                                    <div class="table-responsive mb-4" >
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
                                                                        <thead class="table-light">
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
                                                                                    Export</th>
                                                                                                                                                         <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Import</th>
                                                                    
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

                                            <!--<div id="consignee_msg">-->
                                            <!--    <p style="color:red;font_size:20px;"> Maximum No.Of.Consignee : <span-->
                                            <!--            id="no_of_po_con"></span></p>-->
                                            <!--</div>-->
                                        </div>
                                        
                                        
                                        <?php
                                        
                             

        // $where = "form_main_unique_id = '" . $_GET["unique_id"] . "'";
        // $table = "po_form";
        
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
        // print_r($result_values_1);
        //  print_r($result_values);

        if ($result_values_1->status) {

            $result_values_1 = $result_values_1->data;
             $batch_id1 = $result_values_1[0]["batch_id"];
             
            
        }
                                        ?>
                            <input type="hidden" name="batch_record" id="batch_record" value="<?php echo $batch_id1;?>" >
                                  <br><br>
                                                   
                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                    
                                                <li onclick="get_details(batch_record.value)"><span
                                                        class="btn btn-primary js-btn-next" title="NEXT">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
<!--id="consignee_btn" -->
                                                <!-- get_tab_checking()" id="nxt" class="js-btn-next"-->
                                            </ul>
                                        </div>
                                    </div>
                                     
                                     </div>
                               
                            </div>
                            </div>
                                    <?php include 'import.php';?>
                               
                               
                             
                            
                            
                            
                            
                             <?php include 'consigneeimport.php'; ?>
                                             <input type="hidden" name="demoinpt" id="demoinpt">   
                                             
                                             
                                             <!--</div>-->
                            <!--        </div>-->
                                     
                            <!--         </div>-->
                               
                            <!--</div>-->
                            <!--</div>-->
                            <!--        </div>-->
                            <!--        </div>-->
                                   
                               
                            <!--single form panel-->
                            
                            
                            <div class="multisteps-form__panel" data-animation="slideVert"  id="mytabs"
                                style="background: white;
    margin-top: 151px;
    margin-left: 15px;
    width: 96%;">
                                <div class="inner pb-100">
                                   
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">

                                            <input type="hidden" name="return_qty" id="return_qty">

                                         
                                            

                                                <input type="hidden" name="demoinpt" id="demoinpt">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="mytable" style="margin-top: -149px;">
                                    <div>
                                        <span id="get_qty_msg"></span>
                                         
                                    </div>
                                    <!--style="display: none;"-->
                                   <div id="loader" style="display: none;">
    <img src="assets/loading.gif" alt="Loading..." style="width: 41%;
    height: 185px;
    margin-left: 24%;" />
</div>
                                  
                                     
                                     </div>
                               <div class="wizard-footer" style="margin-top: 84px;">
                                        <div class="actions">
                                            <!--<ul>-->

                                            <!--    <li><span class="btn btn-primary js-btn-prev" title="BACK"><i-->
                                            <!--                class="fa fa-arrow-left"></i>-->
                                            <!--            BACK</span></li>-->

                                                <!--onclick="check_qty()"--onclick="check1()">-->
                                            <!--    <li ><span class="btn btn-primary js-btn-next"-->
                                            <!--            id="mynxt" title="NEXT">NEXT <i-->
                                            <!--                class="fa fa-arrow-right"></i></span></li>-->
                                               
                                            <!--</ul>-->
                                            <ul>
                                                <li id="back"><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>

                                                <li id="tab31"><span title="NEXT" class="btn btn-primary js-btn-next">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                            </ul>
                                         </div>
                                    </div>
                            </div>
                            </div>



                            <!-- </div> -->
                            <!--vendor allocation tab edit  by pavi-->
                            
                            </div>
                             
                            </div>
                            
                            </div>
                            <!--</div>-->
                            <!----vendor allocation tab edit by pavi>
                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert" style="margin-top: 238px;
    margin-left: 21%;" id="tab51">
                                <div class="inner pb-100">
                                  

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="row">
                                                
                                                <div class="col-xl-3">
                                                    <div class="col-xl-3 mb-3">
                                                          <div class="form-group form-check  mt-2">
                                                            <?php if ($amc_required == 'on') { ?>
                                                                <input type="checkbox" class="form-check-input amccheckbox"
                                                                    id="amc_required" name="amc_required" onchange="valueChangedamc()" checked>
                                                            <?php } else { ?>
                                                                <input type="checkbox" class="form-check-input amccheckbox"
                                                                    id="amc_required" name="amc_required"
                                                                    onchange="valueChangedamc()">
                                                            <?php } ?>
                                                            <label class="form-check-label">IS AMC Required</label>
                                                        </div>
                                                        

                                                        
                                                        
                                                        <div class="form-group form-check  mt-2">
                                                            
                                                                <input type="checkbox" class="form-check-input insurence_required"
                                                                    id="insurence_required" name="insurence_required" checked
                                                                    onclick="insurence()">

                                                           

                                                            <label class="form-check-label">
                                                               Insurence Required
                                                            </label>
                                                        </div>
                                                        <div class="form-group form-check  mt-2">
                                                            
                                                                <input type="checkbox" class="form-check-input "
                                                                    id="ld_required" name="ld_required" 
                                                                    onchange="ld_cal_validation()">

                                                           

                                                            <label class="form-check-label">
                                                              LD Calculation
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3" >
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="mb-3" >
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="mb-3 " >
                                                      
                                                    </div>
                                                </div>
                                               
  <!-- Insurance Sub-Types (conditional) -->
  <div class="col-xl-3" id="insu_types" style="display:none">
    <div class="mb-3">
      <label class="form-label">Insurance Sub-Type</label>
      <select name="insurence_types" id="insurence_types" onchange="other_insurence_types()" class="select2 form-control">
        <option value="">Select</option>
        <option value="1">Overall</option>
        <option value="2">Fire Insurance</option>
        <option value="3">Cyber Insurance</option>
        <option value="4">Others</option>
      </select>
    </div>
  </div>

  <!-- Other Insurance Type Input (only if "Others" selected) -->
  <div class="col-xl-3" id="others_insu_types" style="display:none">
    <div class="mb-3">
      <label class="form-label">Other Insurance Type</label>
      <input type="text" id="other_insurance_type" name="other_insurance_type" class="form-control" placeholder="Please specify">
    </div>
  </div>
</div>
 <div class="row">
<div class="col-xl-3" id="ld_calculate" style="display:none">
    <div class="mb-3">
      <label class="form-label">LD Calculation Date Type</label>
      <select name="ld_date_type" id="ld_date_type"  class="select2 form-control" onchange="ldcalculate()">
        <option value="">Select</option>
        <option value="1">From PO Date</option>
        <option value="2">From Consignee Date</option>
      </select>
    </div>
  </div>
  <div class="col-xl-3" id="ld_calculate_1" style="display:none">
    <div class="mb-3">
      <label class="form-label">Delivery Due Date</label>
      <input type="date" id="ld_delivery_due_date" name="ld_delivery_due_date" class="form-control" placeholder="Please specify">
    </div>
  </div>

<div class="col-xl-3" id="ld_calculate_2" style="display:none">
    <div class="mb-3">
      <label class="form-label">Installation Due Date</label>
      <input type="date" id="ld_installation_due_date" name="ld_installation_due_date" class="form-control" placeholder="Please specify">
    </div>
  </div>
  </div>

          
                                                <div class="row">
 
                                      <div class="col-xl-3 po_filediv" style="display:none">
                                                    <div class="mb-3 " >
                                                        <label class="form-label">Attach PO Copy </label>

                                                        <input type="file" id="po_file" accept="application/pdf"
                                                            name="po_file" class="form-control "
                                                            value="<?php echo $file_org_name; ?>">
                                                        <input type="hidden" name="mypo" id="mypo" value="<?php if ($po_num != '') {
                                                            echo $po_num;
                                                        } ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <!-- <div class="col-xl-3 bgdiv" id="bgdiv">-->
                                                <!--    <div class="mb-3">-->
                                                <!--        <label class="form-label">BG%</label>-->
                                                <!--        <input type="text" id="bg" name="bg" class="form-control"-->
                                                <!--            value="<?php echo $bg; ?>">-->
                                                <!--    </div>-->
                                                <!--</div><!-- end col -->
                                                <!--<div class="col-xl-3 bgdiv1" id="bgdiv1">-->
                                                <!--    <div class="mb-3">-->
                                                <!--        <label class="form-label">BG MONTHS-->
                                                <!--        <input type="text" id="bg_month" name="bg_month"-->
                                                <!--            class="form-control" value="<?php echo $bg_month; ?>">-->
                                                <!--    </div>-->
                                                <!--</div><!-- end col -->
                                                 <div class="col-xl-3 start_datediv" id="start_datediv" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Date</label>
                                                       
                                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                                            value="<?php echo $start_date; ?>">
                                                    </div>
                                                </div>
                                                 <div class="col-xl-3 end_datediv" id="end_datediv" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label">End Date</label>
                                                       
                                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                                            value="<?php echo $end_date; ?>">
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row">
                                                 <div class="col-xl-3 amcpercendiv" id="amcpercendiv" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label">AMC%</label>
                                                       
                                                        <input type="text" id="amc_percentae" name="amc_percentae" class="form-control"
                                                            value="<?php echo $amc_percentae; ?>">
                                                    </div>
                                                </div>
                                                 <div class="col-xl-3 amcvaluediv" id="amcvaluediv" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label">AMC Value</label>
                                                       
                                                        <input type="text" id="amcvalue" name="amcvalue" class="form-control"
                                                            value="<?php echo $amcvalue; ?>">
                                                    </div>
                                                </div>
                                                 <div class="col-xl-3 amcpofilediv" id="amcpofilediv" style="display:none">
                                                    <div class="mb-3">
                                                        <label class="form-label">AMC PO order</label>
                                                       
                                                        <input type="file" id="amcpofile" name="amcpofile" class="form-control"
                                                            value="" accept=".pdf">
                                                    </div>
                                                </div>
                                        
                                                 <div class="table-responsive mb-2" id="amc_table" style="display:none">
                                                        <div id="amc_datatable_wrapper"
                                                            class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6"></div>
                                                              <div class="col-sm-12 col-md-6"></div>
                                                            </div>
                                                            <div class="row m-4">
                                                                <style>
                                                                    .amc_datatable{
                                                                            overflow: auto;
                                                                            width: 79% !important;
                                                                            margin-left: -28px;
                                                                            /* width: 100% !important; */
                                                                                }
                                                                </style>
                                                                <div class="col-sm-12 pl-1 pr-1 amc_datatable">
                                                                    <table id="amc_datatable" 
                                                                        class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                                        width="100%">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">S.No</th>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">Start Date</th>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">End Date</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">AMC%</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    AMC Values</th>
                                                                                     <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Attach AMC PO</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Attach PO Copy</th>
                                                                                
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                      
                                    
                                    
                                </div>
                               
                                    <style>
                                        .actions1 {
    /*position: absolute;*/
    /*right: 38px;*/
    /*bottom: 50px;*/
    /*z-index: 1;*/
    margin-top: 49px;
    margin-left: 59%;
}
.actions1 ul {
    /*display: flex;*/
    justify-content: space-between; /* This will space out the buttons to the left and right */
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

.js-btn-prev, .js-btn-next {
    display: inline-block;
}

                                    </style>
                                     <div class="wizard-footer">
    <div class="actions1">
        <ul>
            <li class="action-left">
                <span class="btn btn-primary js-btn-prev" title="BACK">
                    <i class="fa fa-arrow-left"></i> BACK
                </span>
            </li>
            <?php if ($update_unique_id == '') { ?>
                <li onclick="term_condition();">
                    <span class="btn btn-success js-btn-next" title="NEXT">
                        <i class="fa fa-arrow-right"></i>
                        Save 
                    </span>
                </li>
            <?php } else if ($update_unique_id != '') { ?>
                <li onclick="term_condition();">
                    <span class="btn btn-primary js-btn-next" title="NEXT">
                        <i class="fa fa-arrow-right"></i>
                        Update 
                    </span>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

                            </div> <!--  las tab-->

                    </div>

                    <!----content start---------->
                    <!--  Extra Large modal example -->
                    <div class="modal bs-example-modal-xl" id="demos" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Department
                                        Creation</h5>
                                    <hr />
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <!--<form class="was-validated" autocomplete="off">-->
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-4 head_po">
                                                        <div class="row">
                                                            <div class="col-xl-12 head_po">
                                                                <label class="form-label">Department</label>
                                                                <input type="text" class="form-control"
                                                                    id="department_txt" name="department_txt" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-4 head_po">
                                                        <div class="row">
                                                            <div class="col-xl-12 head_po">
                                                                <label class="form-label">Active Status</label>
                                                                <select name="is_active1" id="is_active1"
                                                                    class="select2 form-control" required>
                                                                    <?php echo $active_status_options; ?>
                                                                </select>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!--</form> end card-body -->

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">
                                        Close</a>
                                    <button type="button" class="btn btn-primary "
                                        onclick="department_create()">Save</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script src='folders/po_form/script.js'></script>
<!-- jQuery (Load First) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Main.js (Can be here if not dependent on DataTables) -->
<script src="assets/js/main.js"></script>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- DataTables JS (Load Before common.js) -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- common.js (Load Last) -->
<script src="assets/js/common.js"></script>
 <!-- Include jQuery & Select2 -->
 <script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>

 
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

 
<!-- Bootstrap Selectpicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
   
    insurence();
    ld_cal_validation();
});
document.getElementById("tab31").addEventListener("click", function () {
    // alert();
        document.getElementById("mytabs").classList.remove("js-active");
        document.getElementById("tab51").classList.add("js-active");
});
document.getElementById("back").addEventListener("click", function () {
    // alert();
     document.getElementById("mytabs").classList.remove("js-active");
        document.getElementById("tab31").classList.remove("js-active");
        document.getElementById("third_tab").classList.add("js-active");
});
function insurence() {
    // alert("Function called");
    var checkbox = document.querySelector('#insurence_required');
    var insuTypes = document.querySelector('#insu_types');

    if (checkbox.checked) {
        insuTypes.style.display = 'block';
    } else {
        insuTypes.style.display = 'none';
         $('#others_insu_types').hide();
        
    }
}

function ld_cal_validation() {
    // alert("Function called");
    var checkbox = document.querySelector('#ld_required');
    var lds = document.querySelector('#ld_calculate');
     var lds_1 = document.querySelector('#ld_calculate_1');
      var lds_2 = document.querySelector('#ld_calculate_2');
    
    
// ld_calculate

    if (checkbox.checked) {
        lds.style.display = 'block';
        lds_1.style.display = 'block';
        lds_2.style.display = 'block';
    } else {
        lds.style.display = 'none';
        lds_1.style.display = 'none';
        lds_2.style.display = 'none';
    }
}


</script>
<script>


function toggleDateInput(checkbox) {
  const type = checkbox.value;
  const inputDiv = document.getElementById('input_' + type);
//   alert();
  if (checkbox.checked) {
    inputDiv.style.display = 'block';
  } else {
    inputDiv.style.display = 'none';
  }
}

function tax_type_chnge(){
    // alert("hii");
    var types = document.getElementById('tax_type').value;
    alert(types);
    if(types == 1){
        
        $('#price_1').show();
        $('#price_1_taxs').show();
        $('#price_1_tots').show();
         $('#price_2').hide();
          $('#price_2_tot_2').hide();
        
    }else if(types == 2){
        $('#price_1').hide();
        $('#price_1_taxs').hide();
        $('#price_1_tots').hide();
         $('#price_2').show();
         $('#price_2_tot_2').show();
        
    }else{
         $('#price_1').hide();
         $('#price_2').hide();
          $('#price_1_taxs').hide();
        $('#price_1_tots').hide();
        //  $('#price_2').show();
         $('#price_2_tot_2').hide();
    }
}
    $(document).ready(function () {
        BGrequired();

        $('#ld_type').on('change', function () {
            var selected = $(this).val();

            if (selected === 'day') {
                $('#ld_label_day').show();
                 $('#ld_per_day').show();
                $('#ld_label_week').hide();
            } else if (selected === 'week') {
                $('#ld_label_day').hide();
                $('#ld_label_week').show();
                $('#ld_per_day').show();
            } else {
                $('#ld_label_day').hide();
                $('#ld_label_week').hide();
                $('#ld_per_day').hide();
            }
        });

        // Optional: trigger change on page load if value is preset
        $('#ld_type').trigger('change');
    });
</script>

<script>
function branch_date_change(){
    
    var date_type = document.getElementById('branch_date_type').value;
    // alert(date_type);
    if(date_type == '1'){
        
        $('#dates').show();
    }else if(date_type == '2'){
         $('#dates').show();
    }else{
         $('#dates').hide();
    }
}
function branch_date_change_2(){
    
    var date_type = document.getElementById('branch_date_type_1').value;
    alert(date_type);
    if(date_type == '1'){
        
        $('#dates_1').show();
    }else if(date_type == '2'){
         $('#dates_1').show();
    }else{
         $('#dates_1').hide();
    }
}
function handleEntryModeChange_old(selectedMode) {
    if (selectedMode === "entry") {
      $('#frst_ops').show();
      $('#frst_1_ops').show();
      $('#sec_ops').hide();
    } else if (selectedMode === "import") {
      $('#frst_ops').hide();
      $('#frst_1_ops').hide();
      $('#sec_ops').show();
    }
  }

  $(document).ready(function () {
      
    // On load: check which radio is selected and show/hide sections
    // const selectedMode = $('input[name="entry_mode"]:checked').val();
    // handleEntryModeChange_old(selectedMode);

    // // On radio change: listen and update UI accordingly
    // $('input[name="entry_mode"]').on('change', function () {
    //   const mode = $(this).val();
    //   alert(mode);
    //   console.log("Selected Mode:", mode);
    //   handleEntryModeChange_old(mode);
    // });
  });
$(document).ready(function() {
    
    valueChanged();
    // valueChangedamc();
    amcsub_list_datatable("amc_datatable");
    sub_list_datatable("product_details_datatable");
        
        // sub_list_datatable("consignee_details_datatable");
        sub_list_datatable("po_delivery_datatable");
    // $('#vendor_state_name').selectpicker();
//     document.querySelectorAll('input[name="entry_mode"]').forEach((radio) => {
//   radio.addEventListener('change', function () {
//     const selectedMode = this.value;
//     alert(selectedMode);
//     console.log("Selected Mode:", selectedMode);

//     if (selectedMode === "entry") {
//       // Entry mode: show specific sections
//       $('#frst_ops').show();
//       $('#frst_1_ops').show();
//       $('#sec_ops').hide();
//     } else if (selectedMode === "import") {
//       // Import mode: maybe hide or switch to other sections
//       $('#frst_ops').hide();
//       $('#frst_1_ops').hide();
//       $('#sec_ops').show();
//     }
//   });
// });
});
    
    
    
    
 

// function excel_import() {
      
//         $("#consignee_details_import").modal("show");
//         // event.preventDefault();
//     }
//      function import_close() {
//         $("#consignee_details_import").modal("hide");
//     }


        
        
     $("#sdasdimport_con123").click(function (e) {
    e.preventDefault();

    var form_main_unique_id = $("#demo").val();
    var fileInput = document.getElementById('files');

    var data = new FormData();

    if (fileInput.files.length > 0) {
        data.append("file", fileInput.files[0]);
    } else {
        Swal.fire("Oops!", "Please select a file to upload.", "warning");
        return;
    }

    data.append("form_main_unique_id", form_main_unique_id);

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_assign_import.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            // jQuery auto-parses JSON when Content-Type is application/json
            if (res.status === "success") {
                Swal.fire("Success!", res.message, "success").then(() => {
                   import_close();
                   get_details();
                });
            } else {
                Swal.fire("Error", res.message || "Something went wrong!", "error");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire("Error", "AJAX request failed. Check console.", "error");
        }
    });
});
   
     
    
    
    
    
    
    
    function BGrequired() {
    var bg_required = $('#bg_required').val();

    if (bg_required === "yes") {
        $('#bgrequireddivs').show();
        $('#bgrequireddiv').show();
    } else {
        $('#bgrequireddivs').hide();
        $('#bgrequireddiv').hide();

        // Optionally clear values when hidden
        $('#bg_percen').val('');
        $('#Month').val('');
    }
}

    
    
    
    
    
    
function store_vendor_det(){
    
var vendor_name = $("#vendor_name").val(); // Get selected vendor names (array)
var po_code = $("#po_code").val();

// Get multiple selected values from multi-select dropdowns
var vendor_state_name = $("#vendor_state_name").val();
var vendor_district = $("#vendor_district").val();
var vendor_zone = document.getElementById('vendor_zone').value;

// Convert arrays to comma-separated strings
vendor_name = vendor_name ? vendor_name.join(",") : "";
vendor_state_name = vendor_state_name ? vendor_state_name.join(",") : "";
vendor_district = vendor_district ? vendor_district.join(",") : "";
// vendor_zone = vendor_zone ? vendor_zone.join(",") : "";

var data = new FormData();
data.append("vendor_name", vendor_name);
data.append("po_code", po_code);
data.append("vendor_state_name", vendor_state_name);
data.append("vendor_district", vendor_district);
data.append("vendor_zone", vendor_zone);
data.append("action", "vendor_creation");


            console.log([...data]);
if(po_code != '' && vendor_name != ''){
            $.ajax({
                type: "POST",
                url: 'folders/po_form/crud.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
               
             success : function(data) {

      var obj     = JSON.parse(data);
        var msg     = obj.msg;
        var unique_id_enc     = obj.unique_id_enc;
        var mobile_no_enc     = obj.mobile_no_enc;
        var msg     = obj.msg;
        var status  = obj.status;
        var error   = obj.error;
        // alert(msg);
if(msg == 'create'){
                    
                     sweetalert(msg);
                   
                }

      }
    
  });
}else{
                alert('Enter the Details');
            }
}
$(document).ready(function () {
   
       let timeout = null; // Variable to track typing delay

    document.getElementById("vendor_zone").addEventListener("input", function () {
        clearTimeout(timeout); // Clear previous timeout
        let searchKey = this.value.trim();
        let suggestionsBox = document.getElementById("suggestions");

        if (searchKey.length > 0) {
            timeout = setTimeout(() => { // Delay AJAX request
                fetch("fetch_zone.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "search_key=" + encodeURIComponent(searchKey)
                })
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    suggestionsBox.style.display = "none";

                    if (data.status && Array.isArray(data.zones) && data.zones.length > 0) {
                        let index = 0;

                        function showNextSuggestion() {
                            if (index < data.zones.length) {
                                let zoneName = data.zones[index]; // Ensure valid data
                                
                                if (zoneName) { // Check if zoneName is not undefined
                                    let div = document.createElement("div");
                                    div.textContent = zoneName;
                                    div.onclick = function () {
                                        document.getElementById("vendor_zone").value = zoneName;
                                        suggestionsBox.style.display = "none";
                                    };
                                    suggestionsBox.appendChild(div);
                                    suggestionsBox.style.display = "block";
                                }
                                index++;
                                setTimeout(showNextSuggestion, 200); // Delay next suggestion
                            }
                        }

                        showNextSuggestion(); // Start showing suggestions one by one
                    }
                })
                .catch(error => console.error("Error fetching data:", error)); // Handle fetch errors
            }, 300); // Typing delay (300ms)
        } else {
            suggestionsBox.style.display = "none";
        }
    });

    document.addEventListener("click", function (e) {
        if (!document.getElementById("vendor_zone").contains(e.target)) {
            document.getElementById("suggestions").style.display = "none";
        }
    });
});
$(document).ready(function() {
    $('#state_name').change(function() {
        let selectedStates = $(this).val();
        if (selectedStates.length > 0) {
            get_district(selectedStates);
        } else { }
    });
});
$(document).ready(function () {
    // Enable button after a condition is met (example: after 3 seconds)
   gst_check();
});

var xx = document.getElementById('testin').value;
// alert(xx);
if(xx == 0){
    $('#checkit').hide();
}




 function get_po_no() {
        document.getElementById('mypo').value = '';
        var po_num = document.getElementById('po_num').value;
        // alert(po_num);
        document.getElementById('mypo').value = po_num;
        document.getElementById('po_numbers').value = po_num;
        // document.getElementById('po_code').value = po_num;
        
    }

function gst_check(){
    // alert();
var val1 = document.getElementById('gst_option').value;
        // alert(val1);
        var unregistered_message = document.getElementById('unregistered_message');
  $("#unregistered_message").hide();
        if (val1 == 'no') {
            // alert("hoo");
            $("#checkit").show();
            $("#gst_num").hide();
            $("#unregistered_message").show();
           document.getElementById('testin').value = 1;

        } else if (val1 == 'Yes') {
            $("#gst_num").show();
            $("#unregistered_message").hide();



        }
}



    
        confirm_delete = function (msg) {
  return sweetalert(msg); // <--- return the swal call which returns a promise
};


    function consignee_details_delete(unique_id = "") {
        if (unique_id) {

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            confirm_delete('delete')
                .then((result) => {
                    if (result.isConfirmed) {

                        var data = {
                            "unique_id": unique_id,
                            "action": "consignee_details_delete"
                        }

                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            success: function (data) {

                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;

                                if (!status) {
                                    url = '';
                                } else {
                                    sub_list_datatable_consignee("consignee_details_datatable");
                                }
                                sweetalert(msg, url);
                            }
                        });

                    }

                });
        }
    }

function tender_codes(){
// 	alert('hi');
	var tender_code = $('#tender_code').val();
	
	
// 	 alert(tender_code);
	var data = "&tender_code=" + tender_code + "&action=item_code_option";


	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			// alert(data);
			if (data) {
				$("#item_code").html(data);
			}
		}
	});

}

function isNumberss(evt) {
    let charCode = evt.which ? evt.which : evt.keyCode;
    // Allow numbers (48-57), dot (46), and backspace (8)
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function validateNumber(input) {
    
    // Remove any non-numeric characters except a single decimal point
    input.value = input.value.replace(/[^0-9.]/g, '');
    
    // Ensure only one decimal point exists
    if ((input.value.match(/\./g) || []).length > 1) {
        input.value = input.value.slice(0, -1);
    }
}

 function quantity_number(input) {

	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  
function validagst1(input) {
    let gstError = document.getElementById("gst_error");
    

    // Convert input to uppercase
    input.value = input.value.toUpperCase();

    // Allow only numbers and uppercase letters
    input.value = input.value.replace(/[^0-9A-Z]/g, '');

    // GST number regex pattern
    let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;

    // if (input.value.length === 15 && gstRegex.test(input.value)) {
    //     gstError.style.display = "none"; // Hide error if valid
    //     document.getElementById('testin').value = 1;
    //      $('#checkit').show();
    // } else {
    //     gstError.style.display = "block"; // Show error if invalid
    //      document.getElementById('testin').value = 0;
    // }
    
    
    if (input.value.length === 15 && gstRegex.test(input.value)) {
    gstError.style.display = "none"; // Hide error if valid

    // Append '1' to existing value
    let currentValue = document.getElementById('testin').value;
    document.getElementById('testin').value = currentValue + '1';

    $('#checkit').show();
} else {
    gstError.style.display = "block"; // Show error if invalid
    document.getElementById('testin').value = '0'; // reset on error
}

}


function validateGST(input) {
   
    let gstError = document.getElementById("gst_error");
    

    // Convert input to uppercase
    input.value = input.value.toUpperCase();

    // Allow only numbers and uppercase letters
    input.value = input.value.replace(/[^0-9A-Z]/g, '');

    // GST number regex pattern
    let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;

    // if (input.value.length === 15 && gstRegex.test(input.value)) {
    //     gstError.style.display = "none"; // Hide error if valid
    //     document.getElementById('testin').value = 1;
    //      $('#checkit').show();
    // } else {
    //     gstError.style.display = "block"; // Show error if invalid
    //      document.getElementById('testin').value = 0;
    // }
    
    
    if (input.value.length === 15 && gstRegex.test(input.value)) {
    gstError.style.display = "none"; // Hide error if valid

    // Append '1' to existing value
    let currentValue = document.getElementById('testin').value;
    document.getElementById('testin').value = currentValue + '1';

    $('#checkit').show();
} else {
    gstError.style.display = "block"; // Show error if invalid
    document.getElementById('testin').value = '0'; // reset on error
}

}


function consigneevalidateGST(input) {
   
    let congstError = document.getElementById("con_gst_error");
    

    // Convert input to uppercase
    input.value = input.value.toUpperCase();

    // Allow only numbers and uppercase letters
    input.value = input.value.replace(/[^0-9A-Z]/g, '');

    // GST number regex pattern
    let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;

    if (input.value.length === 15 && gstRegex.test(input.value)) {
        congstError.style.display = "none"; // Hide error if valid
        $('#mybtns').show();
        
    } else {
        congstError.style.display = "block"; // Show error if invalid
         
    }
}










$('#warranty').on('change', function () {
        if (this.value == '1') {
            $("#select_warranty").show();
            document.getElementById('old_warranty').value = '1';
        } else {
            $("#select_warranty").hide();
            document.getElementById('old_warranty').value = '0';
        }
    });



$('#qty').on('input', function () {

// alert('test');
   var qty = document.getElementById('qty').value;
   // var qty = parseFloat($(this).val());
   var unit_price = document.getElementById('unit_price').value;
   // alert(qty);
   var tax = document.getElementById('tax').value;
   // alert(tax);

   if (tax == '18') {
       const net_value = qty * unit_price;
       const percentage_value = net_value * (18 / 100);
       const total_value = net_value + percentage_value;

       document.getElementById('net_value').value = net_value;
       document.getElementById('total_value').value = total_value;
   } else if (tax == '28') {
       const net_value = qty * unit_price;
       const percentage_value = net_value * (28 / 100);
       const total_value = net_value + percentage_value;

       document.getElementById('net_value').value = net_value;

       document.getElementById('total_value').value = total_value;
   } else {

       const net_value = qty * unit_price;
       // percentage_value = net_value * (28 / 100);
       const total_value = net_value;

       document.getElementById('net_value').value = net_value;

       document.getElementById('total_value').value = total_value;
   }

});

    document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];

        // Set the max attribute of the PO Date input field
        document.getElementById("po_date").setAttribute("max", today);
    });


    $(document).ready(function () {
        sub_list_datatable("product_details_datatable");
        
        sub_list_datatable_consignee("consignee_details_datatable");
        sub_list_datatable("po_delivery_datatable");
    });
   
    // // import function start
    // function excel_popup() {
    //     // alert();
    //     $("#consignee_excel_import").modal("show");
    //     // event.preventDefault();
    // }

    // function modal_close() {
    //     $("#consignee_excel_import").modal("hide");
    // }
    
    
    
    
    
    function excel_export_old() {
    var main_unique_id = $('#m_unique_id').val();
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if (main_unique_id) {
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: {
                main_unique_id: main_unique_id,
                action: "get_consignee_product_details"
            },
            success: function (res) {
                var details = JSON.parse(res);

                if (details.data && details.data.length > 0) {
                    // Format the data with headers
                    let exportData = details.data.map((item, index) => {
                        return {
                            "S.No": item.s_no,
                            "Consignee Name": item.con_contact_name,
                            "Consignee Contact": item.con_contact_number,
                            "Consignee Landline": item.con_lan_num,
                            "Consignee Address": item.con_address,
                            "Zone": item.zone,
                            "Item Code": item.item_code,
                            "Item Name": item.product_name,
                            "Qty": item.qty
                        };
                    });

                    // Create a worksheet
                    var worksheet = XLSX.utils.json_to_sheet(exportData);

                    // Create a workbook and add the worksheet
                    var workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, "Consignee Details");

                    // Export the workbook to Excel file
                    XLSX.writeFile(workbook, "consignee_product_details.xlsx");
                } else {
                    alert("No data found to export.");
                }
            }
        });
    } else {
        alert("Main unique ID not found!");
    }
}

    
   
    
    
    
    
    
    
$("#import12345").click(function () {
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').value;
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;

    // Validate file type
    var allowedFileType = ['.xls', '.xlsx'];
    var fileExtension = file.split('.').pop().toLowerCase();

    if (!allowedFileType.includes('.' + fileExtension)) {
        alert("Please upload a valid Excel file.");
        return;
    }

    var gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/; // GST number format regex
    var invalidRows = []; // To hold rows with invalid GST numbers

    var data = new FormData();
    var image_s = document.getElementById("file");

    if (image_s != '') {
        for (var i = 0; i < image_s.files.length; i++) {
            data.append("file", document.getElementById('file').files[i]);
        }
    } else {
        data.append("file", '');
    }

    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);

    // Read Excel file content using SheetJS
    var fileInput = document.getElementById('file').files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        var workbook = XLSX.read(e.target.result, { type: 'binary' });
        var sheetName = workbook.SheetNames[0]; // Assuming the first sheet
        var sheet = workbook.Sheets[sheetName];
        var rows = XLSX.utils.sheet_to_json(sheet, { header: 1 }); // Convert sheet to JSON

        // Loop through each row and validate GST number
        for (var i = 1; i < rows.length; i++) { // Skipping the header row
            var gstNumber = rows[i][6]; // Assuming GST number is in column 7 (index 6)
            if (!gstRegex.test(gstNumber)) {
                invalidRows.push(i); // Collect rows with invalid GST numbers
            }
        }

        // If there are invalid rows, show alert and prevent upload
        if (invalidRows.length > 0) {
            var errorMessage = "Invalid GST numbers in the following rows: ";
            invalidRows.forEach(function (row) {
                errorMessage += "Row " + (row + 1) + " ";
            });
            alert(errorMessage);
            return; // Stop the import process if validation fails
        }

        // Proceed with uploading the file if validation passes
        $.ajax({
            type: "POST",
            url: 'folders/po_form/con_import.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function (res) {
           
                        // Decode the JSON response
            var response = JSON.parse(res); // Parse the response from JSON string to object

            // Check the status of the response
            if (response.status === 'success') {
                // If the upload is successful, show success alert and proceed
                alert(response.message);
                modal_close(); // Close the modal
                sub_list_datatable("consignee_details_datatable"); // Update the data table
                
            } else if (response.status === 'error') {
                // If there is an error, show the error message
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("An error occurred during the upload process.");
        }
   
        });
    };

    reader.readAsBinaryString(fileInput); // Read the file as binary string
});

$("#import3213131").click(function () {
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').value;
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;

    // Validate GST number format
    var invalidRows = [];
    var gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/; // Example regex for GST format

    var consigneeData = []; // To hold your consignee data rows (you would need to gather this from the form)

    // Loop through your consignee data to validate GST numbers
    // This is an example assuming you have a table or some form of data structure for consignees
    for (var i = 0; i < no_of_consignee; i++) {
        var gstNumber = document.getElementById('gst_' + i).value; // Assuming GST number inputs have ids like gst_0, gst_1, etc.
        if (!gstRegex.test(gstNumber)) {
            invalidRows.push(i); // Collect rows with invalid GST numbers
        }
    }

    // If there are any invalid GST numbers, show an alert
    if (invalidRows.length > 0) {
        var errorMessage = "Invalid GST numbers in the following rows: ";
        invalidRows.forEach(function (row) {
            errorMessage += "Row " + (row + 1) + " ";
        });
        alert(errorMessage);
        return; // Stop the import process if validation fails
    }

    var data = new FormData();

    var image_s = document.getElementById("file");
    if (image_s != '') {
        for (var i = 0; i < image_s.files.length; i++) {
            data.append("file", document.getElementById('file').files[i]);
        }
    } else {
        data.append("file", '');
    }

    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);

    console.log([...data]);

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function (res) {
            console.log(res);
            modal_close();
            sub_list_datatable("consignee_details_datatable");
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});



    // Add event listener for modal close event

        $("#import").click(function () {
            // alert('hi');
            var form_main_unique_id = $("#demo").val();

            // alert(form_main_unique_id);
            var file = document.getElementById('file').value;
            var no_of_consignee = document.getElementById('no_of_consignee').value;
            
            var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;

            var data = new FormData();
            
            var image_s = document.getElementById("file");
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("file", document.getElementById('file').files[i]);

                }
            } else {
                data.append("file", '');
            }

            //    if(no_of_consignee){
            data.append("form_main_unique_id", form_main_unique_id);
            data.append("no_of_consignee", no_of_consignee);
            data.append("cons_verfiy_sts",cons_verfiy_sts);


            console.log([...data]); 

            $.ajax({
                type: "POST",
                url: 'folders/po_form/con_import.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function (res) {
                    console.log(res);
                    //  alert('Upload Successfully');
                    modal_close();
                    sub_list_datatable("consignee_details_datatable");
                    // window.location.reload();


                },

                error:function(xhr,status,error){
                    consloe.error(error);
                }

            });
            // }

        });
    var phone_input = document.getElementById("con_lan_num");

    phone_input.addEventListener('input', () => {
        phone_input.setCustomValidity('');
        phone_input.checkValidity();
    });

    phone_input.addEventListener('invalid', () => {
        if (phone_input.value === '') {
            phone_input.setCustomValidity('Enter phone number!');
        } else {
            phone_input.setCustomValidity('Enter phone number in this format: 123-4567890');
        }
    });


    function get_district(state_id = "") {
        // alert();

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (state_id) {
            var data = {
                "state_id": state_id,
                "action": "get_state_name"
            }

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {

                    if (data) {
                        // alert(data);
                        $("#district").html(data);

                       
                    }
                }
            });
        }
    }




    $("#files").change(function () {
        filename = this.files[0].name
        console.log(filename);
    });








function item_detail() {
    // Clear existing values
    $("#po_name").val('');
    $("#unit_price").val('');
    $("#tax").val('');
    $("#net_price").val('');

    var item_code = $('#item_code').val();
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if (item_code) {
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: {
                item_code: item_code,
                action: "get_item_name"
            },
            success: function (res) {
                console.log(res);

                var details = JSON.parse(res);
                var itemDescription = details['item_description'] || '';
                var netPrice = parseFloat(details['rc_net_price']) || 0;
                var gst = parseFloat(details['gst']) || 0;

                // Reverse-calculate unit price (excluding GST)
                var unitPrice = netPrice / (gst / 100);

                // Set values in form
                $("#po_name").val(itemDescription);
                $("#net_price").val(netPrice.toFixed(2));
                $("#tax").val(gst);
                $("#unit_price").val(unitPrice.toFixed(2)); // set the calculated unit price

                CalculateTotal(); // call total calculation
            },
            error: function () {
                alert("Failed to fetch item details.");
            }
        });
    }
}






//     function item_detail() {



//                     $("#po_name").val('');
//                     $("#unit_price").val('');
//                     $("#tax").val('');
//                     $("#net_price").val('');
//         var item_code = $('#item_code').val();
//         // alert(item_code);
//         var ajax_url = sessionStorage.getItem("folder_crud_link");

//         if (item_code) {
//             $.ajax({
//                 type: "POST",
//                 url: ajax_url,
//                 data: {
//                     item_code: item_code,
//                     action: "get_item_name"
//                 },
//                 success: function (res) {
//                     console.log(res);
// // alert(res);
//                     var details = JSON.parse(res);
//                   var unit_price=val(details['rc_net_price'])/100*18;
                  
//                     $("#po_name").val(details['item_description']);
//                     $("#unit_price").unit_price;
                    
//                     $("#net_price").val(details['rc_net_price']);
//                     $("#tax").val(details['gst']);
//                     CalculateTotal();

                 

//                 }
             
//             });
//         }
//     }

    $("#wizard").steps({
        onStepChanging: function (event, currentIndex, newIndex) {
            if (!po_form_cu()) {
                return false; // Stay on the same step if validation fails
            }
            return true; // Allow navigation to the next step if validation passes
        }
    });

         function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    
   

    function po_form_cu() {
        // alert('hi');
        var internet_status = is_online();

        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
         $('#no_of_pro_item').empty();
          $('#no_of_po_con').empty();

        let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
        var gst_value = document.getElementById('gst_value').value;

        if (!gstRegex.test(gst_value)) {
            sweetalert("gst_alert"); // Correct message for invalid GST
            return false;
        }
        // Show the loader
// document.getElementById("loader").style.display = "block";

        var po_num = document.getElementById('po_num').value;
        var po_date = document.getElementById('po_date').value;
        var department = document.getElementById('department').value;
        var gst_option = document.getElementById('gst_option').value;
        var executive_name = document.getElementById('executive_name').value;
        var bill_address = document.getElementById('bill_address').value;
        var contact_name = document.getElementById('contact_name').value;
        var contact_number = document.getElementById('contact_number').value;
        var contact_landline_num = document.getElementById('contact_landline_num').value;

        var email = document.getElementById('email').value;
        var district = document.getElementById('district').value;
        var pin = document.getElementById('pin').value;
       
        var po_type = document.getElementById('po_type').value;
        var no_of_po = document.getElementById('no_of_po').value;
        var state_name = document.getElementById('state_name').value;
       
        var unique_id = document.getElementById('unique_id').value;
        var form_unique_id = document.getElementById('m_unique_id').value;
        var no_of_consignee = document.getElementById('no_of_consignee').value;
        var po_unique_id = document.getElementById('po_unique_id').value;

        // var file = document.getElementById('file').value;
        // alert(m_unique_id);

        var data = new FormData();
        // var image_s = document.getElementById("file");
        // if (image_s != '') {
        //     for (var i = 0; i < image_s.files.length; i++) {
        //         data.append("file", document.getElementById('file').files[i]);

        //     }
        // } else {
        //     data.append("file", '');
        // }
        data.append("po_num", po_num);
        data.append("m_unique_id", form_unique_id);
        data.append("po_date", po_date);
        data.append("department", department);
        data.append("gst_option", gst_option);
        data.append("gst_value", gst_value);
        data.append("executive_name", executive_name);
        data.append("bill_address", bill_address);
        data.append("unique_id", unique_id);
        data.append("contact_name", contact_name);
        data.append("contact_number", contact_number);
        data.append("contact_landline_num", contact_landline_num);

        data.append("email", email);
        data.append("district", district);
        data.append("pin", pin);
       
        data.append("po_type", po_type);
        data.append("no_of_po", no_of_po);
        data.append("state_name", state_name);
       
        data.append("no_of_consignee", no_of_consignee);
        data.append("po_unique_id", po_unique_id);

        data.append("action", "createupdate");

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

                $('#no_of_pro_item').append(no_of_po);
                $('#no_of_po_con').append(no_of_consignee);
        $.ajax({
            type: "POST",
            url: 'folders/po_form/crud.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            beforeSend: function () {
                $(".createupdate_btn").attr("disabled", "disabled");
                $(".createupdate_btn").text("Loading...");
            },
            success: function (data) {
                // console.log(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                
                 // Hide loader
    // document.getElementById("loader").style.display = "none";

                if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
                } else {
                    if (msg == "already") {
                        // Button Change Attribute
                        url = '';

                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                        if (unique_id) {
                            $(".createupdate_btn").text("Update");
                        } else {
                            $(".createupdate_btn").text("Save");
                        }
                    }
                }


                    

                get_product_sublist_count();
                get_stored_sublist_count();
                var url = $('#sec_tab').show();
                sweetalert(msg);
                // department_create();


            },
            error: function (data) {
                alert("Network Error");
            }
        });

    }

    var product_details_tableid = 'product_details_datatable';
    var consignee_details_tableid = 'consignee_details_datatable';

    $(".bgdiv").hide();
    $(".bgdiv1").hide();

function valueChanged() {
        if ($('.bgcheckbox').is(":checked")) {
            $(".bgdiv").show();
            $(".bgdiv1").show();
        } else {
            $(".bgdiv1").hide();
            $(".bgdiv").hide();

        }
    }
    
    // function valueChanged() {
      
    //     if ($('.bgcheckbox').is(":checked")) {
    //         $(".lddiv").show();
    //           $(".bgdiv").show();
    //             $(".apddiv").show();
    //         $(".amcdiv").show();
    //     } else {
    //         $(".lddiv").hide();
    //           $(".bgdiv").hide();
    //             $(".apddiv").hide();
    //         $(".amcdiv").hide();

    //     }
    // }
    
     function valueChangedamc() {
       
        if ($('.amccheckbox').is(":checked")) {
            $(".start_datediv").show();
              $(".amcpercendiv").show();
                $(".end_datediv").show();
            $(".amcvaluediv").show();
            $(".amcpofilediv").show();
             $(".amc_datatable").show();
              $(".po_filediv").show();
              $("#amc_table").show();
            
        } else {
              $(".start_datediv").hide();
              $(".amcpercendiv").hide();
                $(".end_datediv").hide();
            $(".amcvaluediv").hide();
            $(".amc_datatable").hide();
            $(".amcpofilediv").hide();
             $(".po_filediv").hide();
              $("#amc_table").hide();
           

        }
    }
    
     
    
//     function insurence_type() {
//   var ins_type = document.getElementById('ins_type').value;

//   if (ins_type === '1') {
//     $('#insu_types').show();
//   } else {
//     $('#insu_types').hide();
//      $('#others_insu_types').hide();
   

//   }
// }

function other_insurence_types() {
    
  var insurence_types = document.getElementById('insurence_types').value;
// alert(insurence_types);
  if (insurence_types === '4') {
    //   alert(insurence_types);
    $('#others_insu_types').show();
  } else {
    $('#others_insu_types').hide();
  }
}

    
    

 
    function print_pdf_1(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

    $(document).ready(function () {
        if ($(".bgcheckbox").is(":checked")) {
            $(".bgdiv").show();
            $(".bgdiv1").show();
        } else {
            $(".bgdiv1").hide();
            $(".bgdiv").hide();
        }

        $('.select2_op').select2();

        $('#pro_details').click(function () {
            $('.select2_op').val(null).trigger('change');
        });

      
        // warranty option
        var warranty = document.getElementById('old_warranty').value;
        if (warranty == 'no') {
            $("#select_warranty").hide();
        } else {
            $("#select_warranty").show();
        }



        var unique_id = $('#unique_id').val();
        // alert(unique_id);
        if (unique_id) {
            document.getElementById('m_unique_id').value = '';
        }
        sub_list_datatable(product_details_tableid);
        sub_list_datatable(consignee_details_tableid);

    });


   

    $('#gst_option').on('change', function () {
        if (this.value == 'yes') {
            $("#gst_num").show();
            $("#unregistered_message").hide();
            document.getElementById('old_gst_option').value = 'yes';


        } else {
            $("#gst_num").hide();
            $("#unregistered_message").show();
            document.getElementById('old_gst_option').value = 'no';

        }
    });

    var current = 0;
    var tabs = $(".tab");
    var tabs_pill = $(".tab-pills");

    loadFormData(current);

    function loadFormData(n) {
        $(tabs_pill[n]).addClass("active");
        $(tabs[n]).removeClass("d-none");
        $("#back_button").attr("disabled", n == 0 ? true : false);
        n == tabs.length - 1 ?
            $("#next_button").text("Next").prop("disabled", true).removeAttr("onclick") :
            $("#next_button")
                .attr("type", "button")
                .text("Next").prop("disabled", false)
                .attr("onclick", "next()");
    }

    function next() {
        var unique_id = document.getElementById('unique_id').value;
        if (unique_id == '') {
            if (validateCurrentTab()) {
                $(tabs[current]).addClass("d-none");
                $(tabs_pill[current]).removeClass("active");
                current++;
                loadFormData(current);
            }
        } else {
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");
            current++;
            loadFormData(current);
        }
    }

    function validateCurrentTab() {
        const currentTabFields = $(tabs[current]).find('[required]');

        for (let i = 0; i < currentTabFields.length; i++) {
            if (!currentTabFields[i].value.trim()) {
                // Replace the default alert with SweetAlert
                Swal.fire({
                    icon: 'error',
                    // title: 'Validation Error',
                    text: 'Please fill out all required fields.',
                });
                return false;
            }
        }
        return true;
    }

 function get_details_olds() {

        var unique_id = document.getElementById('demo').value;
        var batch_ids = document.getElementById('batch_record').value;
        // alert(batch_ids);
        data = "unique_id=" + unique_id + "&batch_ids="+ batch_ids +"&action=get_assign_qty_record";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,

            success: function (data) {
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var data = obj.data;
                $('#mytable').html(data);

            }
        });
    }

    function get_details_1() {

        var unique_id = document.getElementById('demo').value;

        data = "unique_id=" + unique_id + "&action=get_assign_qty_record";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,

            success: function (data) {
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var data = obj.data;
                $('#mytable').html(data);

            }
        });
    }

    function back() {
        $(tabs[current]).addClass("d-none");
        $(tabs_pill[current]).removeClass("active");
        current--;
        loadFormData(current);
    }

    function product_details_add_update(unique_id = "") { // au = add,update
        var internet_status = is_online();
       
        var form_class = "product_detail";
        var is_form = form_validity_check(form_class);
        // var is_form = form_validity_check("product_details_form");

        // console.log(is_form);
        var no_of_po = document.getElementById('no_of_po').value;
        var tender_code = document.getElementById('tender_code').value;



        var item_code = document.getElementById('item_code').value;
        var po_name = document.getElementById('po_name').value;
        // alert(po_name);
        var qty = document.getElementById('qty').value;
        var unit_price = document.getElementById('unit_price').value;
        var tax = document.getElementById('tax').value;
        var total_value = document.getElementById('total_value').value;
        // var net_value = document.getElementById('net_value').value;

        var form_main_unique_id = document.getElementById('form_main_unique_id').value;

        //    new change
        var delivery_due_dates = document.getElementById('delivery_due_dates').value;
        var ld_per_day = document.getElementById('ld_per_day').value;
        var ld_maximum_val = document.getElementById('ld_maximum_val').value;
        var warranty = document.getElementById('warranty').value;
        // alert(warranty);
        var warranty_duration = document.getElementById('warranty_duration').value;
         var warranty_starts = document.getElementById('warranty_starts').value;
       
           var document_required = document.getElementById('document_required').value;
           
            var net_value = document.getElementById('net_value').value;
           var net_price = document.getElementById('net_price').value;
           var insta_due_days = document.getElementById('insta_due_days').value;
           
            var ld_type = document.getElementById('ld_type').value;
              var bg_required = document.getElementById('bg_required').value;
              
              if(bg_required === 'yes'){
                  
                   var bg_percen = document.getElementById('bg_percen').value;
           
              var bg_month = document.getElementById('bg_month').value;
              }else{
                  
                   var bg_percen = ''
           
              var bg_month = '';
              }


        // end

        // var data = $(".product_details_form").serialize();
        var data = "no_of_po=" + no_of_po + 
    "&tender_code=" + tender_code + 
    "&item_code=" + item_code + 
    "&po_name=" + po_name + 
    "&qty=" + qty + 
    "&unit_price=" + unit_price +
    "&tax=" + tax + 
    "&total_value=" + total_value + 
    "&net_value=" + net_value + 
    "&net_price=" + net_price + 
    "&delivery_due_dates=" + delivery_due_dates +
    "&ld_per_day=" + ld_per_day + 
    "&ld_maximum_val=" + ld_maximum_val + 
    "&warranty=" + warranty +
    "&warranty_duration=" + warranty_duration + 
    "&form_main_unique_id=" + form_main_unique_id + 
    "&unique_id=" + unique_id + 
    "&insta_due_days=" + insta_due_days +
    "&bg_required=" + bg_required + 
    "&bg_percen=" + bg_percen + 
    "&document_required=" + document_required + 
    "&warranty_starts=" + warranty_starts + 
    "&ld_type=" + ld_type + 
    "&bg_month=" + bg_month + 
    "&action=product_details_add_update";

        // alert(unique_id);
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url      = sessionStorage.getItem("list_link");
        var url = "";

        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".product_details_add_update_btn").attr("disabled", "disabled");
                $(".product_details_add_update_btn").text("Loading...");
            },
            success: function (data) {

                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    $(".product_details_add_update_btn").text("Error");
                    // console.log(error);
                } else {
                    if (msg !== "product") {
                        form_reset("product_details_form");
                    }
                    if (msg == "product") {
                        sweetalert(msg);
                    }
                    $(".product_details_add_update_btn").removeAttr("disabled", "disabled");
                    if (unique_id && msg == "already") {
                        $(".product_details_add_update_btn").text("Update");
                    } else {
                        form_reset("product_details_form");
                        $(".product_details_add_update_btn").text("Add");
                        $(".product_details_add_update_btn").attr("onclick",
                            "product_details_add_update('')");
                    }
                    get_product_sublist_count();
                    // Init Datatable
                    sub_list_datatable("product_details_datatable");
                }


               
                document.getElementById('po_name').value = '';
                document.getElementById('qty').value = '';
                document.getElementById('unit_price').value = '';
                document.getElementById('total_value').value = '';
                document.getElementById('tax').value = '';
                document.getElementById('net_value').value = '';
                document.getElementById('net_price').value = '';
                document.getElementById('delivery_due_dates').value = '';
                document.getElementById('ld_per_day').value = '';
                document.getElementById('ld_maximum_val').value = '';
                document.getElementById('warranty').value = '';
                document.getElementById('warranty_duration').value = '';
                
                document.getElementById('insta_due_days').value = '';
                document.getElementById('bg_required').value = '';
                document.getElementById('bg_percen').value = '';
                document.getElementById('bg_month').value = '';


                var div_contents = document.getElementById("div1");
                var elements = div_contents.getElementsByTagName("select");
                var elements = getElementById("tax");
                for (i = 0; i < elements.length; i++) {
                    elements[i].selectedIndex = -1;
                }
                sweetalert(msg, url);

            },
            error: function (data) {
                alert("Network Error");
            }
        });

       
    }

   


    function product_details_edit(unique_id = "") {
        if (unique_id) {
           
            var data = "unique_id=" + unique_id + "&action=product_details_edit";
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function () {
                    $(".product_details_add_update_btn").attr("disabled", "disabled");
                    $(".product_details_add_update_btn").text("Loading...");
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    var data = obj.data;
                    var status = obj.status;

                    if (!status) {
                        $(".product_details_add_update_btn").text("Error");
                        console.log(obj.error);
                    } else {
                        // Clear existing options before appending new ones


                        var product = data.product;
                        var item_code = data.item_code;
                        var qty = data.qty;
                        var unit_price = data.unit_price;
                         var net_price = data.net_price;
                        var tax = data.tax;
                        var total_value = data.total_value;
                        var net_value = data.net_value;
                        var tender_code = data.tender_code;

                        var delivery_due_dates = data.delivery_due_dates;
                        var ld_per_day = data.ld_per_day;
                        var ld_maximum_val = data.ld_maximum_val;
                        var warranty = data.warranty;
                        var warranty_duration = data.warranty_duration;
                         var insta_due_days = data.insta_due_days;
                          var document_required = data.document_required;
                           var ld_type = data.ld_type; 
                           var bg_required = data.bg_required;
                            var bg_percen = data.bg_percen; 
                            var bg_month = data.bg_month;
                             var warranty_starts = data.warranty_starts;


                      
                        $("#tender_code").val(tender_code);
                  
                        var item_code = data.item_code;
var item_code_name = data.item_code_name;

if ($("#item_code option[value='" + item_code + "']").length === 0) {
    $('#item_code').append(`<option value="${item_code}">${item_code_name}</option>`);
}
$("#item_code").val(item_code).trigger('change');

$("#po_name").val(product);

                        $("#qty").val(qty);
                        $("#unit_price").val(unit_price);
                        $("#tax").val(tax);
                        $("#total_value").val(total_value);
                        $("#net_value").val(net_value);
                         $("#net_price").val(net_price);

                         $("#warranty_starts").val(warranty_starts);
                        $("#delivery_due_dates").val(delivery_due_dates);
                        $("#document_required").val(document_required);
                         $("#insta_due_days").val(insta_due_days);
                         $("#ld_type").val(ld_type);
                         $("#ld_per_day").val(ld_per_day);
                         $("#bg_required").val(bg_required);
                         $("#bg_percen").val(bg_percen);
                         $("#bg_month").val(bg_month);
                        $("#ld_maximum_val").val(ld_maximum_val);
                        $("#warranty").val(warranty);
                        $("#warranty_duration").val(warranty_duration);


                        // Enable update button
                        $(".product_details_add_update_btn").removeAttr("disabled").text("Update");
                        $(".product_details_add_update_btn").attr("onclick", "product_details_add_update('" + unique_id + "')");
                    }
                },
                error: function () {
                    alert("Network Error");
                }
            });
        }
    }



    // consignee sub crud
    function consignee_details_add_update_olds(unique_id = "") { // au = add,update

        var internet_status = is_online();

        var is_form = form_validity_check("consignee_details_form");
       
        var no_of_consignee = document.getElementById('no_of_consignee').value;
        // var con_qty = document.getElementById('con_qty').value;

        var con_address = document.getElementById('con_address').value;
        var con_district = document.getElementById('con_district').value;

        // alert(con_district);

        var con_pincode = document.getElementById('con_pincode').value;
        var con_contact_name = document.getElementById('con_contact_name').value;
        var con_contact_number = document.getElementById('con_contact_number').value;
        var con_lan_num = document.getElementById('con_lan_num').value;
        var consignee_gst = document.getElementById('consignee_gst').value;
        var form_main_unique_id = document.getElementById('demo').value;
        var zone = document.getElementById('zone').value;
        
        var cons_verify_sts = document.getElementById('verify_sts').value;

       
        var data = "no_of_consignee=" + no_of_consignee + "&consignee_gst=" + consignee_gst +"&con_address=" + con_address +
            "&con_district=" + con_district +
            "&con_pincode=" + con_pincode + "&con_contact_name=" + con_contact_name + "&con_contact_number=" +
            con_contact_number + "&con_lan_num=" + con_lan_num + "&form_main_unique_id=" +
            form_main_unique_id + "&zone=" + zone +"&cons_verify_sts=" + cons_verify_sts ;
        data += "&unique_id=" + unique_id + "&action=consignee_details_add_update";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url      = sessionStorage.getItem("list_link");
        var url = "";
if(con_address && con_district !== ''){
        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".consignee_details_add_update_btn").attr("disabled", "disabled");
                $(".consignee_details_add_update_btn").text("Loading...");
            },
            success: function (data) {

                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    $(".consignee_details_add_update_btn").text("Error");
                    // console.log(error);
                } else {
                    if (msg == "e_already") {
                        // sweetalert(msg, url);
                        form_reset("consignee_details_form");
                    }
                    if (msg == "e_already") {
                        sweetalert(msg);
                    }
                    $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                    if (unique_id && msg == "already") {
                        $(".consignee_details_add_update_btn").text("Update");
                    } else {
                        $(".consignee_details_add_update_btn").text("Add");
                        $(".consignee_details_add_update_btn").attr("onclick",
                            "consignee_details_add_update('')");
                    }
                    // Init Datatable
                    get_stored_sublist_count();
                    sub_list_datatable("consignee_details_datatable");
                    
                    document.getElementById('con_district').value = 'your_district_value';
                    document.getElementById('con_district').value = '';

                    // document.getElementById('con_district').selectedIndex = -1;

                    document.getElementById('con_address').value = '';
                    // document.getElementById('con_district').value = '';
                    document.getElementById('con_pincode').value = '';
                    document.getElementById('con_contact_name').value = '';
                    document.getElementById('con_contact_number').value = '';
                    document.getElementById('con_lan_num').value = '';
                     document.getElementById('consignee_gst').value = '';
                    
                    
                }
                sweetalert(msg, url);
            },
            error: function (data) {
                alert("Network Error");
            }
        });
}else{
    alert("To Fill Consignee Address Details first");
}
       
    }

    // consignee edit
    function consignee_details_edit(unique_id = "") {
        if (unique_id) {
            var data = "unique_id=" + unique_id + "&action=consignee_details_edit";
            // alert(data);

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            // var url      = sessionStorage.getItem("list_link");
            var url = "";

            // console.log(data);
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function () {
                    $(".consignee_details_add_update_btn").attr("disabled", "disabled");
                    $(".consignee_details_add_update_btn").text("Loading...");
                },
                success: function (data) {
                    // alert(data);

                    var obj = JSON.parse(data);
                    var data = obj.data;
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;

                    if (!status) {
                        $(".consignee_details_add_update_btn").text("Error");
                        console.log(error);
                    } else {
                        // console.log(obj);

                        var con_address = data.con_address;
                        var con_district = data.district_name;
                        var district_unique_id = data.con_district;
                        var con_pincode = data.con_pincode;
                        var con_contact_name = data.con_contact_name;
                        var con_contact_number = data.con_contact_number;
                        var con_lan_num = data.con_lan_num;
                        var zone= data.zone;
                        
                        var cons_verify_sts  = data.cons_verify_sts;


                        // $("#qty").empty();
                        // $("#tender_code").empty();
                        // Append tender code if it doesn't exist in options
                        if ($("#con_district option[value='" + con_district + "']").length === 0) {
                            $("#con_district").append($('<option>', {
                                value: district_unique_id,
                                text: con_district
                            }));
                        }
                        
                        $('#verify_sts').val(cons_verify_sts);
                        $("#con_address").val(con_address);
                        $("#con_district").val(district_unique_id);
                        // $("#rel_gender").val(gender).trigger("change");
                        $("#con_pincode").val(con_pincode);

                        $("#con_contact_name").val(con_contact_name);
                        $("#con_contact_number").val(con_contact_number);
                        $("#con_lan_num").val(con_lan_num);

                        $("#zone").val(zone);
                        // $("#con_district").empty();
                        // Button Change 
                        $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                        $(".consignee_details_add_update_btn").text("Update");
                        $(".consignee_details_add_update_btn").attr("onclick", "consignee_details_add_update('" + unique_id + "')");
                    }
                },
                error: function (data) {
                    alert("Network Error");
                }
            });
        }
    }
    
    function amcsub_list_datatable(table_id = "", form_name = "", action = "") {
    var form_main_unique_id = $("#demo").val();
    var table = $("#" + table_id);

    var data = {
        "form_main_unique_id": form_main_unique_id,
        "action": table_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if ($.fn.DataTable.isDataTable(table)) {
        // ✅ Destroy existing DataTable before reinitializing
        table.DataTable().destroy();
    }

    // ✅ Reinitialize DataTable without pagination and ordering
    table.DataTable({
        processing: true,
        serverSide: true,
        paging: false,   
        ordering: false,
        searching: false,
        info: false,     
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data
        }
    });
}

    
    
    function sub_list_datatable(table_id = "", form_name = "", action = "") {
    var form_main_unique_id = $("#demo").val();
    var table = $("#" + table_id);

    var data = {
        "form_main_unique_id": form_main_unique_id,
        "action": table_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if (table_id === 'consignee_details_datatable') {
        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            info: true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data
            }
        });
    } else if (table_id === 'product_details_datatable') {
        var datatable = table.DataTable({
            destroy: true,
            ordering: false,
            searching: false,
            paging: false,
            info: false,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data,
                dataSrc: function (json) {
                    // Update footer totals
                    $("#sum_net_value").text(json.sum_net_value);
                    $("#sum_total_value").text(json.sum_total_value);
                    return json.data;
                }
            }
        });
    } else {
        var datatable = table.DataTable({
            destroy: true,
            ordering: false,
            searching: false,
            paging: false,
            info: false,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data
            }
        });
    }
}

    
    

//     function sub_list_datatable(table_id = "", form_name = "", action = "") {
//         var form_main_unique_id = $("#demo").val();

//         var table = $("#" + table_id);
        
//         // alert(table_id);
//         var data = {
//             "form_main_unique_id": form_main_unique_id,
//             "action": table_id,
//         };
//         var ajax_url = sessionStorage.getItem("folder_crud_link");
        
        
//         if(table_id === 'consignee_details_datatable'){
            
//             var datatable = table.DataTable({
//                 destroy  : true,
//                 ordering : true,
//                 searching: true,
//                 paging      : true,
//                 //   lengthChange: false, 
//                 pageLength : 10,
//                 lengthMenu :[[10,25,50,-1],[10,25,50,"All"]],
//                 info:true,
                
//                  "ajax": {
//                 url: ajax_url,
//                 type: "POST",
//                 data: data
//             }
//             });
//         }
// else{
//      var datatable = table.DataTable({
//             destroy: true,
//             ordering: true,
//             searching: true,
//             "searching": false,
//             "paging": false,
//             "ordering": false,
//             "info": false,
//             "ajax": {
//                 url: ajax_url,
//                 type: "POST",
//                 data: data
//             }
//         });
//     }
    
// }
       

    function product_details_delete(unique_id = "") {
        if (unique_id) {

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            confirm_delete('delete')
                .then((result) => {
                    if (result.isConfirmed) {

                        var data = {
                            "unique_id": unique_id,
                            "action": "product_details_delete"
                        }

                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            success: function (data) {

                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;

                                if (!status) {
                                    url = '';
                                } else {
                                    sub_list_datatable("product_details_datatable");
                                }
                                sweetalert(msg, url);
                            }
                        });

                    }

                });
        }
    }


  function check1(){
    //   var element = document.getElementById("finals");
    //         element.classList.remove("js-btn-next");
     var current = document.getElementById("finals");
    var next = current.nextElementSibling;

    if (next && next.classList.contains("multisteps-form__panel")) {
        current.classList.remove("is-active");
        next.classList.add("is-active");
    }
  }

    function validateEmail(event) {
        // Get the input value
        const emailInput = event.target.value;

        // Regular expression for a simple email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Test the input value against the regex
        const isValidEmail = emailRegex.test(emailInput);

        // Get the validation message element
        const validationMessage = document.getElementById('emailValidationMessage');


        // Display the validation message based on the result
        if (isValidEmail) {
            validationMessage.textContent = 'Valid email format';
            validationMessage.style.color = 'green';
        }
        else {
            validationMessage.textContent = 'Invalid email format';
            validationMessage.style.color = 'red';
        }
        if (isValidEmail) {
            validationMessage.textContent = '';
        }
        // Clear the validation message if the email format is valid

    }





    function check_qty() {

        var bill_qty = document.getElementsByName('bill_qty[]');
        var con_sno = document.getElementsByName('con_sno[]');

        var con_unique_id = document.getElementsByName('con_unique_id[]');
        // alert(product_name);
        var main_unique_id = document.getElementById('main_unique_id').value;

        var product_unique_id = document.getElementsByName('product_unique_id[]');
        var product_qty = document.getElementsByName('qty[]');
        var return_qty = document.getElementById('return_qty').value;
        var product_name = document.getElementsByName('item_name[]');


        var item_qty_total = [];
        var assign_qty_total = [];
        var item_name = [];
        let result_qty = [];
        let result_name = [];
        let item_names = [];
        var single = [];
        var qty_value_check = [];
        // var valueToPush = { };
        var bill_qty_total = [];


        for (var i = 0; i < bill_qty.length; i++) {

            var bill_qty_val = bill_qty[i].value;
            var qty_val = product_qty[i].value;
            var product_id = product_unique_id[i].value;
            var con_id_val = con_unique_id[i].value;
            var con_s_no = con_sno[i].value;
            var product_name_val = product_name[i].value;


            var number = parseFloat(bill_qty_val);

            if (!isNaN(number)) {
                assign_qty_total.push(number);
            }

            var item_qty = product_qty[i].value;

            // var item_qty = parseFloat(qty_val);

            if (!isNaN(item_qty)) {
                item_name.push({ product_name_val, item_qty });
                item_qty_total.push(item_qty);
            }

            if (!isNaN(number)) {
                var sum_of_assign_qty1 = assign_qty_total.reduce(function (total, current) {
                    return total + current;
                }, 0);
            }
            // console.log(sum_of_assign_qty1);
        }
        for (var j = 0; j < product_name.length; j++) {
            var product_name_data = product_name[j].value;
            var item_data = bill_qty[j].value;
            // console.log(item_data);
            // console.log(product_name_data);
            item_names.push({ item_name: product_name_data, qty: item_data });

        }
        // console.log(item_names);
        const productQuantities = [];
        item_names.forEach(function (item) {
            // console.log(item['item_name']);
            var productName = item['item_name'];
            var quantity = item['qty'];
            if (productQuantities[productName]) {
                productQuantities[productName] += ',' + quantity;
            } else {
                // Otherwise, initialize the quantity for the product
                productQuantities[productName] = quantity;
            }
        });

        var sums = {};

        // Iterate over each key-value pair in the data object
        for (var key in productQuantities) {
            if (productQuantities.hasOwnProperty(key)) {
                // Split the string of values into an array
                var valuesArray = productQuantities[key].split(',');

                // Initialize a variable to store the sum of values for the current key
                var sum = 0;

                // Iterate over the array of values and sum them up
                valuesArray.forEach(function (value) {
                    sum += parseInt(value, 10);
                });

                // Store the sum for the current key in the sums object
                sums[key] = sum;
                // sums[key] = sum;

            }
        }
        console.log('Sum of values:', sums);

        // item qty total value
        // item_qty_total.forEach((item, index) => { if (item_qty_total.indexOf(item) == index) result_qty.push(item) });
        item_name.forEach((item, index) => { if (item_name.indexOf(item) == index) result_name.push(item) });
        // console.log(result_qty);
        var uniqueProducts = {};

        result_name.forEach(function (entry) {
            var productName = entry.product_name_val;
            var itemQty = parseInt(entry.item_qty, 10);

            // If the product name does not exist in the uniqueProducts object, add it
            if (!uniqueProducts[productName]) {
                uniqueProducts[productName] = itemQty;
            }
        });

        // Convert the uniqueProducts object back into an array of objects
        var filteredData = Object.keys(uniqueProducts).map(function (productName) {
            return { product_name_val: productName, item_qty: uniqueProducts[productName].toString() };
        });

        console.log('Filtered data:', filteredData);

        var conditionMet = true;


        for (var productName in sums) {
            // Check if the product name exists in the sums object
            if (sums.hasOwnProperty(productName)) {
                // Find the corresponding object in the filteredData
                var productObject = filteredData.find(function (obj) {
                    return obj.product_name_val === productName;
                });

                // If the corresponding object is found, compare the quantities
                if (productObject) {
                    var expectedQty = sums[productName];
                    var actualQty = parseInt(productObject.item_qty);

                    // Check if the actual quantity matches the expected quantity
                    if (actualQty !== expectedQty) {
                        conditionMet = false;
                        break; // Break out of the loop if condition is not met
                    }
                } else {
                    conditionMet = false;
                    break; // Break out of the loop if product not found
                }
            }
        }

        // Check the conditionMet flag to determine the result
        // Product actual Qty miss matched Assign Qty
        if (conditionMet) {
            // po_assign_add_update();
            
            myfetchrecord();

            console.log("Condition is true");
            // var element = document.getElementById("mynxt");
            // element.classList.remove("js-btn-next");

        } else {
            var element = document.getElementById("mynxt");
            element.classList.remove("js-btn-next");
            console.log("Condition is false");
            Swal.fire({
                title: 'Error!',
                text: 'Verify the assigned quantity for the mismatch count!..',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                swal.close();
            });
        }


    }
  // Show the loader
document.getElementById("loader").style.display = "block";
    fetch("http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: jsonPayload
})
.then(res => res.json())
.then(response => {
    console.log("API Response:", response);
 // Hide loader
    document.getElementById("loader").style.display = "none";
    if (response.status === true) {
        alert(`✅ PO assignment submitted successfully!\n\nTotal Success: ${response.success_count}`);
    } else {
        let errorMsg = `❌ Failed to submit PO assignment.\n\nSuccess: ${response.success_count}\nFailed: ${response.failed_count}`;
        
        if (response.errors && response.errors.length > 0) {
            // Limit to first 5 errors for readability
            const sampleErrors = response.errors.slice(0, 5).join("\n- ");
            errorMsg += `\n\nSome errors:\n- ${sampleErrors}`;
        }

        alert(errorMsg);
    }
})
.catch(error => {
    console.error("Error:", error);
    alert("Something went wrong while submitting PO assignment.");
});


    function myfetchrecord_1() {
    let data = [];

    // Loop through each row to collect data
    document.querySelectorAll(".assign-row").forEach((row, index) => {
        let record = {};

        const fields = [
            "form_main_unique_id",
            "product_unique_id",
            "item_code",
            "item_name",
            "qty",
            "con_unique_id",
            "con_name",
            "con_contact_no",
            "bill_qty",
            "unit_price"
        ];

        fields.forEach(className => {
            const input = row.querySelector(`.${className}`);
            if (!input) {
                console.warn(`Row ${index + 1}: Missing .${className}`);
                record[className] = "";
            } else {
                record[className] = input.value;
            }
        });

        data.push(record);
    });

    // ✅ Define jsonPayload
    let jsonPayload = JSON.stringify(data);

    console.log("Payload:", jsonPayload);

    fetch("http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: jsonPayload // ✅ Now this is defined
    })
    .then(res => res.json())
    .then(response => {
        console.log("API Response:", response);
    })
    .catch(error => {
        console.error("Error:", error);
    });
}




function myfetchrecord_news() {
    let data = [];

    document.querySelectorAll(".form-block").forEach((block, index) => {
        let record = {};

        // List of input field class names you want to collect
        const fields = [
            "form_main_unique_id",
            "product_unique_id",
            "item_code",
            "item_name",
            "qty",
            "con_unique_id",
            "con_name",
            "con_contact_no",
            "bill_qty",
            "unit_price"
        ];

        // Loop through each field and collect the value if it exists
        fields.forEach(className => {
            const input = block.querySelector(`.${className}`);
            if (!input) {
                console.warn(`Block ${index + 1}: Missing input with class .${className}`);
                record[className] = ""; // fallback value
            } else {
                record[className] = input.value;
            }
        });

        data.push(record);
    });

    // Convert to JSON and print (or send via AJAX)
    let jsonPayload = JSON.stringify(data);
console.log(jsonPayload);


fetch("http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: jsonPayload
})
.then(res => res.json())
.then(response => {
    console.log("API Response:", response);
})
.catch(error => {
    console.error("Error:", error);
});

}

function myfetchrecord12345(){
let data = [];

document.querySelectorAll(".form-block").forEach(block => {
    let record = {
        form_main_unique_id: block.querySelector(".form_main_unique_id").value,
        product_unique_id: block.querySelector(".product_unique_id").value,
        item_code: block.querySelector(".item_code").value,
        item_name: block.querySelector(".item_name").value,
        qty: block.querySelector(".qty").value,
        con_unique_id: block.querySelector(".con_unique_id").value,
        con_name: block.querySelector(".con_name").value,
        con_contact_no: block.querySelector(".con_contact_no").value,
        bill_qty: block.querySelector(".assign_qty").value,
        unit_price: block.querySelector(".unit_price").value
    };
    data.push(record);
    alert("hii");
    alert(data.push(record));
});

let jsonPayload = JSON.stringify(data);
console.log(jsonPayload);
//  var external_api_url = "http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php"; // Replace with actual external API URL

fetch("http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: jsonPayload
})
.then(res => res.json())
.then(response => {
    console.log("API Response:", response);
})
.catch(error => {
    console.error("Error:", error);
});

}

    // consignee sub crud
    // function po_assign_add_update12345(unique_id = "") {
    //     // alert('hi');

    //     var internet_status = is_online();

    //     var demo = document.getElementById('demo').value;
    //     var bill_qty = document.getElementsByName('bill_qty[]');


    //     for (var i = 0; i < bill_qty.length; i++) {
    //         var bill_qty_val = bill_qty[i].value;

    //         // if (bill_qty_val != '') {

    //         var qty_val = bill_qty[i].value;
    //         var item_code = document.getElementsByName('item_code[]');
    //         var item_name = document.getElementsByName('item_name[]');
    //         var unit_price = document.getElementsByName('unit_price[]');
    //         var tax = document.getElementsByName('tax[]');
    //         var qty = document.getElementsByName('qty[]');
    //         // var rem_qty = document.getElementsByName('initial_qty[]');


    //         var con_unique_id = document.getElementsByName('con_unique_id[]');
    //         var con_name = document.getElementsByName('con_name[]');
    //         var con_contact_no = document.getElementsByName('con_contact_no[]');
    //         var product_unique_id = document.getElementsByName('product_unique_id[]');

    //         var item_code_val = item_code[i].value;
    //         var item_name_val = item_name[i].value;
    //         var item_unit_price = unit_price[i].value;
    //         var item_tax = tax[i].value;
    //         var qty = qty[i].value;
    //         // var rem_qty = rem_qty[i].value;

    //         var con_unique_id_val = con_unique_id[i].value;
    //         var con_name_val = con_name[i].value;
    //         var con_contact_no_val = con_contact_no[i].value;
    //         var product_unique_id_val = product_unique_id[i].value;

    //         // var product_unique_id= document.getElementById('product_unique_id').value;
    //         var main_unique_id = document.getElementById('main_unique_id').value;
    //         var po_unique_id = document.getElementById('po_unique_id').value;




    //         var data = "main_unique_id=" + main_unique_id + "&con_unique_id=" + con_unique_id_val +
    //             "&con_name=" + con_name_val + "&con_contact_no=" + con_contact_no_val + "&item_code=" + item_code_val +
    //             "&item_name=" +
    //             item_name_val + "&bill_qty=" + qty_val + "&unit_price=" + item_unit_price + "&item_tax=" + item_tax +
    //             "&po_unique_id=" + po_unique_id + "&product_unique_id_val=" + product_unique_id_val + "&qty=" + qty;

    //         data += "&unique_id=" + unique_id + "&action=po_delivery_add_update";

    //         var ajax_url = sessionStorage.getItem("folder_crud_link");
    //         // var url = "";

    //         $.ajax({
    //             type: "POST",
    //             url: ajax_url,
    //             data: data,
    //             beforeSend: function () {
    //                 $(".po_delivery_add_update_btn").attr("disabled", "disabled");
    //                 $(".po_delivery_add_update_btn").text("Loading...");
    //             },
    //             success: function (data) {
    //                 var obj = JSON.parse(data);
    //                 var msg = obj.msg;
    //                 var status = obj.status;
    //                 var error = obj.error;
    //                 // alert(msg);
    //                 if (!status) {
    //                     $(".po_delivery_add_update_btn").text("Error");
    //                     // console.log(error);
    //                 } else {
    //                     if (msg == "e_already") {
    //                         // sweetalert(msg, url);
    //                         form_reset("po_delivery_form");
    //                     }
    //                     if (msg == "e_already") {
    //                         sweetalert(msg);
    //                     }
    //                     $(".po_delivery_add_update_btn").removeAttr("disabled", "disabled");
    //                     // && msg == "already"
    //                     if (unique_id) {
    //                         $(".po_delivery_add_update_btn").text("Update");
    //                     } else {
    //                         $(".po_delivery_add_update_btn").text("Add");
    //                         $(".po_delivery_add_update_btn").attr("onclick",
    //                             "po_delivery_add_update('')");
    //                     }
    //                     // location.reload();
    //                     // Init Datatable
    //                     sub_list_datatable("po_delivery_datatable");
    //                 }
    //                 // get_po_item();
    //                 sweetalert(msg);
    //                 var element = document.getElementById("mynxt");
    //                 element.classList.add("js-btn-next");
    //             },
    //             error: function (data) {
    //                 alert("Network Error");
    //             }
    //         });
    //     }
    // }
    
    function po_assign_add_update(unique_id = "") {
    // alert();
    var internet_status = is_online();
    var demo = document.getElementById('demo').value;
    var bill_qty = document.getElementsByName('bill_qty[]');

    for (var i = 0; i < bill_qty.length; i++) {
        var bill_qty_val = document.getElementsByName('bill_qty[]')[i].value;
        var item_code = document.getElementsByName('item_code[]')[i].value;
        var item_name = document.getElementsByName('item_name[]')[i].value;
        var unit_price = document.getElementsByName('unit_price[]')[i].value;
        var tax = document.getElementsByName('tax[]')[i].value;
        var qty = document.getElementsByName('qty[]')[i].value;
        var con_unique_id = document.getElementsByName('con_unique_id[]')[i].value;
        var con_name = document.getElementsByName('con_name[]')[i].value;
        var con_contact_no = document.getElementsByName('con_contact_no[]')[i].value;
        var product_unique_id = document.getElementsByName('product_unique_id[]')[i].value;
        var form_main_unique_id = document.getElementById('main_unique_id').value;
        var po_unique_id = document.getElementById('po_unique_id').value;
        // var unique_id_value = document.getElementById('unique_id').value;

        var data = {
            "form_main_unique_id": form_main_unique_id,
            "con_unique_id": con_unique_id,
            "con_name": con_name,
            "con_contact_no": con_contact_no,
            "item_code": item_code,
            "item_name": item_name,
            "bill_qty": bill_qty_val,
            "unit_price": unit_price,
            "item_tax": tax,
            "po_unique_id": po_unique_id,
            "product_unique_id": product_unique_id,
            "qty": qty,
            "unique_id": unique_id
        };

        var external_api_url = "http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php"; // Replace with actual external API URL
 var external_api_url = "http://122.165.127.123:41290/otm_beta/folders/po_form/po_assign_create.php"; // Replace with actual external API URL

        $.ajax({
            type: "POST",
            url: external_api_url,
            data: JSON.stringify(data), // Convert data to JSON string
            contentType: "application/json", // Set content type to JSON
            beforeSend: function() {
                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function(response) {
                var obj = JSON.parse(response);
                var msg = obj.msg;
                var status = obj.status;
                if (!status) {
                    $(".po_delivery_add_update_btn").text("Error");
                } else {
                    if (msg == "e_already") {
                        form_reset("po_delivery_form");
                    }
                    $(".po_delivery_add_update_btn").removeAttr("disabled");
                    if (unique_id) {
                        $(".po_delivery_add_update_btn").text("Update");
                    } else {
                        $(".po_delivery_add_update_btn").text("Add");
                        $(".po_delivery_add_update_btn").attr("onclick", "po_delivery_add_update('')");
                    }
                    sub_list_datatable("po_delivery_datatable");
                   
                }
                // sweetalert(msg);
                // var element = document.getElementById("mynxt");
                // element.classList.add("js-btn-next");
                sweetalert(msg);
                    var element = document.getElementById("mynxt");
                    element.classList.add("js-btn-next");
            },
             error: function(response) {
           
                Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'successfully Saved!',
                        timer: 1000, // Alert will close after 2 seconds
                        showConfirmButton: false // Hides the confirm button
                    });
                }
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Network Error',
            //         text: 'There was a network error while saving.'
            //     });
            // }
        });
    }
}
 
    // get consignee count  -->

    function get_stored_sublist_count() {

        var uni_id = document.getElementById('form_main_unique_id').value;
        var data = "uni_id=" + uni_id + "&action=check_consignee";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                document.getElementById('stored_consignee').value = obj.data[0];
                get_consignee();
            }
        });
    }

    function get_consignee() {

        var uni_id = document.getElementById('form_main_unique_id').value;

        var data = "uni_id=" + uni_id + "&action=no_of_consignee";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                document.getElementById('count_consignee').value = obj.data[0];
                //  get_stored_sublist_count();
                get_tab_checking();

            }
        });

    }

    function get_tab_checking() {
        var x = document.getElementById('stored_consignee').value;
        var y = document.getElementById('count_consignee').value;
        if (x != y) {
            $('#consignee_btn').hide();
            $('#consignee_msg').show();
        }
        else {
            $('#consignee_btn').show();
            $('#consignee_msg').hide();
        }
    }



    function get_product_sublist_count() {

        var uni_id = document.getElementById('form_main_unique_id').value;
        var data = "uni_id=" + uni_id + "&action=check_product";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                document.getElementById('stored_item').value = obj.data[0];
                get_po_item();
            }
        });
    }

    function get_po_item() {

        var uni_id = document.getElementById('form_main_unique_id').value;

        var data = "uni_id=" + uni_id + "&action=no_of_item";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                document.getElementById('count_item').value = obj.data[0];

                get_producttab_checking();
            },
        });

    }

    function get_producttab_checking() {

        var x = document.getElementById('stored_item').value;
        var y = document.getElementById('count_item').value;


        if (x != y) {
            $('#product_data').hide();
            $('#product_msg').show();

        } else {
            $('#product_data').show();
            $('#product_msg').hide();

        }
    }
    //product end-->
    //department creation start-->

    function generateRandomString(length) {
        var result = '';
        var characters = '1234567890abcdefghijklmnopqrstuvwxyz';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function department_create(unique_id = "") {

        var internet_status = is_online();

        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }

        var department = document.getElementById('department_txt').value;
        var randomString = generateRandomString(18); // Generate a random string of length 16
        // console.log(randomString);
        var is_active1 = document.getElementById('is_active1').value;
        // var unique_id = document.getElementById('unique_id').value;


        if (department.trim() !== "") {
            // Create a new option element
            var option = document.createElement('option');

            // Set the value and text of the option to the entered value
            option.value = randomString;
            option.text = department;

            // Append the new option to the select dropdown
            document.getElementById('department').appendChild(option);

            // Optionally, clear the input field after saving
            // document.getElementById('department_txt').value = '';
        } else {
            alert('Please enter a value before saving.');
        }

        if (department && is_active1) {

            // var data = "department=" +department + "&is_active1=" + is_active1;
            // data 		+= "&unique_id="+unique_id+"&action=department_cu";

            var data = {
                unique_id: randomString,
                department: department,
                is_active1: is_active1,

                action: "department_cu"
            };
            // alert(data);


            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    // alert(msg);
                    if (data == "") {
                        alert('enter the value');
                    }
                    else {
                        // alert('saved successfully');
                        sweetalert(msg);
                        $('#demos').modal('hide');
                        // $('').close()
                    }
                },
                error: function (data) {
                    alert("Network Error");

                }
            });
        } else {
            sweetalert("form_alert");
        }
    }

   
   
   
function ldcalculate() {
    var m_unique_id = document.getElementById('m_unique_id').value;
 var ld_date_type = document.getElementById('ld_date_type').value;
 
    if (!m_unique_id) {
        sweetalert("Please select a valid entry.");
        return;
    }

    var data = {
        m_unique_id: m_unique_id,
        action: "get_lddates"
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function (response) {
    try {
        var obj = JSON.parse(response);

        if (obj.data && obj.data.length > 0) {
            var firstRow = obj.data[0];

            var po_date = firstRow[0];
            var insta_due_days = firstRow[1];
            var delivery_due_dates = firstRow[2];
            var consignee_received_date = firstRow[3];

            // Use function to calculate date
            function addDays(dateStr, days) {
                var date = new Date(dateStr);
                date.setDate(date.getDate() + parseInt(days));
                return date.toISOString().split('T')[0];
            }

            let valdeliverydate = '';
            let valinstadates = '';

            if (ld_date_type == '1') {
                valdeliverydate = addDays(po_date, delivery_due_dates);
                valinstadates = addDays(po_date, insta_due_days);
            } else {
                valdeliverydate = addDays(consignee_received_date, delivery_due_dates);
                valinstadates = addDays(consignee_received_date, insta_due_days);
            }

            $('#ld_delivery_due_date').val(valdeliverydate);
            $('#ld_installation_due_date').val(valinstadates);

           
            
            sweetalert("LD data loaded successfully.");
            $('#demos').modal('hide');
        } else {
            sweetalert("No data found.");
        }
    } catch (err) {
        console.error("Invalid JSON or unexpected format", err);
        console.log("Raw response:", response);
        sweetalert("Something went wrong while parsing data.");
    }
},

        error: function () {
            alert("Network Error");
        }
    });
}







function addDays(dateStr, days) {
    var date = new Date(dateStr);
    date.setDate(date.getDate() + parseInt(days));
    return date.toISOString().split('T')[0]; // gives "YYYY-MM-DD"
}





    function term_condition() {
       
        var internet_status = is_online();

        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        var po_no = document.getElementById('mypo').value;
      var amc_required = document.getElementById('amc_required').value;
       var insurence_required = document.getElementById('insurence_required').value;
    //   var batch_assign_qty = document.getElementById('batch_assign_qty').value;
   
           var image_s = document.getElementById("po_file");
           var data = new FormData();
          if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("po_file", document.getElementById('po_file').files[i]);

            }
        } else {
            data.append("po_file", '');
        }
        var start_date = document.getElementById('start_date').value;
       
          var end_date = document.getElementById('end_date').value;
       
          var amc_percentae = document.getElementById('amc_percentae').value; 
          var ld_delivery_due_date = document.getElementById('ld_delivery_due_date').value;
       
          var ld_installation_due_date = document.getElementById('ld_installation_due_date').value; 
          
          var amcvalue = document.getElementById('amcvalue').value;
           var ld_required = document.getElementById('ld_required').value;
          

          var amcpofile = document.getElementById("amcpofile");
           var other_insurance_type = document.getElementById("other_insurance_type").value;
          
        
        
         if (amcpofile != '') {
            for (var i = 0; i < amcpofile.files.length; i++) {
                data.append("amcpofile", document.getElementById('amcpofile').files[i]);
               

            }
        } else {
            data.append("amcpofile", '');
        }

       
        var unique_id = document.getElementById('unique_id').value;
        var demo = document.getElementById('demo').value;
        var insurence_types = document.getElementById('insurence_types').value;
        // alert(insurence_types);
        var po_unique_id = document.getElementById('po_unique_id').value;

       

        data.append("insurence_types", insurence_types);
        data.append("po_no", po_no);
         data.append("ld_required", ld_required);
         data.append("ld_delivery_due_date", ld_delivery_due_date);
          data.append("ld_installation_due_date", ld_installation_due_date);
        data.append("other_insurance_type", other_insurance_type);
      
        data.append("insurence_required", insurence_required);
       
         data.append("amc_required", amc_required);

     data.append("start_date", start_date);
  data.append("end_date", end_date);
  data.append("amc_percentae", amc_percentae);
    data.append("amcvalue", amcvalue);

    // data.append("batch_assign_qty",batch_assign_qty);
        data.append("demo", demo);
        data.append("po_unique_id", po_unique_id);
        data.append("action", "terms_condition");

       
        
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        // console.log(data);
        $.ajax({
            type: "POST",
            url: 'folders/po_form/crud.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
           
            success: function (data) {
                //alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
                }
                else {
                    if (msg == "already") {
                        // Button Change Attribute
                        url = '';

                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                        if (unique_id) {
                            $(".createupdate_btn").text("Update");
                        }
                    }
                }
                // var url = 'folders/po_form/list.php';
                  sweetalert(msg);
                 $('#amc_datatable').DataTable().ajax.reload(null, false); 
                  $("#start_date").val('');
$("#end_date").val('');
$("#amc_percentage").val('');
$("#amcvalue").val('');
$("#amcpofile").val('');
                amcsub_list_datatable("amc_datatable");
                
              
            },
            error: function (data) {
                alert("Network Error");
            }
        });
       
    }
   

// function CalculateTotal() {
//     // For testing purposes
   

//     // Get input values
//     var qty = parseFloat(document.getElementById('qty').value) || 0;
//     var net_price = parseFloat(document.getElementById('net_price').value) || 0;
//     var tax = parseFloat(document.getElementById('tax').value) || 0;

//     // Total value including tax (gross)
//     var total_value = qty * net_price;
//     document.getElementById('total_value').value = total_value.toFixed(2);

//     // Calculate tax amount from total
//     var tax_amount = total_value * (tax / 100);

//     // Net value (excluding tax)
//     var withouttaxamount = total_value - tax_amount;
    
    
//     // Calculate tax amount
// var tax_amount_1 = net_price * (tax / 100);
// console.log("Tax Amount:", tax_amount_1); // Should log 4959

// // Rounded to nearest integer
// var unit_prices = Math.round(net_price - tax_amount_1);
// console.log("Unit Price (Excl. Tax):", unit_prices); // 22591
     
     

//     // Set result
//     document.getElementById('net_value').value = withouttaxamount.toFixed(2);
//      document.getElementById('unit_price').value = unit_prices.toFixed(2);
// }
function CalculateTotal() {
    // Get input values
    var qty = parseFloat(document.getElementById('qty').value) || 0;
    var net_price = parseFloat(document.getElementById('net_price').value) || 0; // Price *with* tax
    var tax = parseFloat(document.getElementById('tax').value) || 0;

    // Calculate unit price (excluding tax)
    var unit_price = net_price / (1 + tax / 100);

    // Calculate total value (gross) = qty * net_price (includes tax)
    var total_value = qty * net_price;

    // Calculate tax amount = total_value - value without tax
    var tax_amount = total_value - (qty * unit_price);

    // Net value = total - tax (value without tax)
    var net_value = total_value - tax_amount;

    // Set results with 2 decimal precision
    document.getElementById('unit_price').value = unit_price.toFixed(2);
    document.getElementById('total_value').value = total_value.toFixed(2);
    document.getElementById('net_value').value = net_value.toFixed(2);
}


    $('#qty').on('change', function () {
        // alert("hii");
        CalculateTotal();

    });

    $('#tax').on('change', function () {
        // alert("hello");
        CalculateTotal();
    });



    function toggleInsRequired() {
        var dcRequired = document.getElementById('dc_required');
        var insRequired = document.getElementById('ins_reqired');

        // Enable both if both are checked, else apply usual disable logic
        if (dcRequired.checked && insRequired.checked) {
            dcRequired.disabled = false;
            insRequired.disabled = false;
        } else {
            insRequired.disabled = dcRequired.checked;
        }
    }

    function toggleDcRequired() {
        var dcRequired = document.getElementById('dc_required');
        var insRequired = document.getElementById('ins_reqired');

        // Enable both if both are checked, else apply usual disable logic
        if (dcRequired.checked && insRequired.checked) {
            dcRequired.disabled = false;
            insRequired.disabled = false;
        } else {
            dcRequired.disabled = insRequired.checked;
        }
    }

    // Call these functions on page load to ensure the correct initial state
    window.onload = function () {
        toggleInsRequired();
        toggleDcRequired();
    };

    // Add event listeners to handle real-time checking
    document.getElementById('dc_required').addEventListener('change', toggleInsRequired);
    document.getElementById('ins_reqired').addEventListener('change', toggleDcRequired);


    function validateLandline(input) {
        // Allow only numbers and hyphen (-)
        input.value = input.value.replace(/[^0-9-]/g, '');

        // Landline number regex pattern (Format: XXXX-XXXXXXX or XXX-XXXXXXX)
        let landlineRegex = /^[0-9]{3,4}-[0-9]{6,8}$/;
        let errorSpan = document.getElementById("landline_error");

        if (!landlineRegex.test(input.value)) {
            errorSpan.innerText = "Enter a valid landline number (e.g., 044-12345678)";
        } else {
            errorSpan.innerText = ""; // Clear error message when valid
        }
    }

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'State Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'po_form_datatable';
var action = "datatable";



function po_form_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	confirm_delete('delete')
		.then((result) => {
			if (result.isConfirmed) {

				var data = {
					"unique_id": unique_id,
					"action": "delete"
				}

				$.ajax({
					type: "POST",
					url: ajax_url,
					data: data,
					success: function (data) {

						var obj = JSON.parse(data);
						var msg = obj.msg;
						var status = obj.status;
						var error = obj.error;

						if (!status) {
							url = '';

						} else {
							init_datatable(table_id, form_name, action);
						}
						sweetalert(msg, url);
					}
				});

			} else {
				// alert("cancel");
			}
		});
}

function print_pdf_2(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

// const weekday = new Array(7);
// weekday[0] = "Sunday";
// weekday[1] = "Monday";
// weekday[2] = "Tuesday";
// weekday[3] = "Wednesday";
// weekday[4] = "Thursday";
// weekday[5] = "Friday";
// weekday[6] = "Saturday";

// var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// var months_short = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];


// Select2 Init

$(document).ready(function () {


  $('.dropify').dropify({
    allowedFileExtensions: "pdf xlsx doc docx txt xls ",
    maxFileSize: "5M",
    errorsPosition: "outside",
    error: {
      'fileSize': 'The file size is too big ({{ value }} max).',
      'minWidth': 'The image width is too small ({{ value }}}px min).',
      'maxWidth': 'The image width is too big ({{ value }}}px max).',
      'minHeight': 'The image height is too small ({{ value }}}px min).',
      'maxHeight': 'The image height is too big ({{ value }}px max).',
      'imageFormat': 'The image format is not allowed ({{ value }} only).'
    }
  });
  $('.dropify_img').dropify({
    allowedFileExtensions: "png jpeg jpg",
    maxFileSize: "5M",
    errorsPosition: "outside",
    error: {
      'fileSize': 'The file size is too big ({{ value }} max).',
      'minWidth': 'The image width is too small ({{ value }}}px min).',
      'maxWidth': 'The image width is too big ({{ value }}}px max).',
      'minHeight': 'The image height is too small ({{ value }}}px min).',
      'maxHeight': 'The image height is too big ({{ value }}px max).',
      'imageFormat': 'The image format is not allowed ({{ value }} only).'
    }
  });

  // Datatables Bottom Button init
  var a = $("#datatable-buttons").DataTable({
    serverSide: false,
    lengthChange: !1,
    buttons: [{
      extend: "copy",
      className: "btn-light"
    }, {
      extend: "print",
      className: "btn-light"
    }, {
      extend: "pdf",
      className: "btn-light"
    }],
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>"
      }
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
    }
  });
});

$.extend($.fn.dataTable.defaults, {
  // searching: false,
  destroy: true,
  stateSave: true,
  ordering: false,
  responsive: true,
  paging: true,
  processing: true,
  serverSide: true,
  searching: false,
  "columnDefs": [
    { "className": "text-center", "targets": [0, -1] }
  ],
  lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
  ],
  language: {
    paginate: {
      previous: "<i class='mdi mdi-chevron-left'>",
      next: "<i class='mdi mdi-chevron-right'>"
    },
    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
  },
  
  drawCallback: function () {
    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
  }
});

// Form Validity Checking Function
function form_validity_check(class_name = '', form_name = '') {

  var forms = document.getElementsByClassName(class_name);

  // If ID based Form validation Needs Not Working
  if (form_name) {
    var forms = document.getElementsByName(form_name);
  }

  var formValidity = false;
  var validation = Array.prototype.filter.call(forms, function (form) {

    if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      formValidity = false;
    } else {
      formValidity = true;
    }
  });
  if (formValidity) {
    return true;
  } else {
    return false;
  }
}

// Form Validity Checking Function Ends

// Sweet Alert Function Starts

function sweetalert(msg = '', url = '', callback = '', title = '') {

  switch (msg) {
    case "create":
      Swal.fire({
        icon: 'success',
        title: 'Successfully Saved',
        // text: 'Modal with a custom image.',  
        // imageUrl:'img/emoji/success.webp',
        // imageWidth: 250,
        // imageHeight: 200,
        imageAlt: 'Custom image',
        showConfirmButton: true,
        timer: 2500,
        timerProgressBar: true,
        willClose: () => {
          if (url) {
            window.location = url;
          }
        }
      });
      break;

    case "update":
      Swal.fire({
        icon: 'success',
        title: 'Successfully Updated',
        // imageUrl:'img/emoji/clapping.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          if (url) {
            window.location = url;
          }
        }
      });
      break;

    case "error":
      Swal.fire({
        icon: 'error',
        title: 'Error Occured',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "network_err":
      Swal.fire({
        icon: 'error',
        title: 'Network Error Occured',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "e_already":
      Swal.fire({
        icon: 'warning',
        title: 'No of consignee count exceed',
        // imageUrl:'img/emoji/already.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "already":
      Swal.fire({
        icon: 'warning',
        title: 'Already Exist',
        // imageUrl:'img/emoji/already.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "stock":

      Swal.fire({
        icon: 'warning',
        title: 'Stock Already Entered',
        // imageUrl:'img/emoji/already.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "exceed":

      Swal.fire({
        icon: 'warning',
        title: 'Please Enter Valid Product Qty!..',
        // imageUrl:'img/emoji/already.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {

        }
      });
      break;

    case "leave_already":
      Swal.fire({
        icon: 'warning',
        title: 'Cancel the Previous leave request',
        // imageUrl:'img/emoji/already.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "no_internet":
      Swal.fire({
        icon: 'warning',
        title: 'Please Check Your Internet Connection!',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "no_location":
      Swal.fire({
        icon: 'warning',
        title: 'Please Check Your Geo Location!',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true,
        willClose: () => {
          // alert("Hi");
        }
      });
      break;

    case "delete":
      return Swal.fire({
        title: 'Are you sure to Delete?',
        text: "You won't be able to revert this!",
        // icon: 'warning',
        // imageUrl:'img/emoji/delete.webp',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        preConfirm: () => {
          return true;
        }
      });
      break;

    case "success_delete":
      Swal.fire({
        icon: 'success',
        title: 'Deleted!',
        // imageUrl:'img/emoji/success_delete.webp',
        showConfirmButton: true,
        timer: 1500,
        timerProgressBar: true
      });
      break;

    case "form_alert":
      Swal.fire({
        icon: 'info',
        title: 'Fill Out All Mantantory Fields',
        // imageUrl:'img/emoji/form_fill.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true
      })
      break;

    case "approve":
      Swal.fire({
        icon: 'success',
        title: 'Successfully Approved',
        showConfirmButton: true,
        timer: 2000,
        willClose: () => {
          window.location = url;
        }
      });
      break;

    case "convert":
      Swal.fire({
        icon: 'success',
        title: 'Successfully Converted',
        showConfirmButton: true,
        timer: 2000,
        willClose: () => {
          window.location = url;
        }
      });
      break;

    case "add":
      Swal.fire({
        icon: 'success',
        title: 'Successfully Added',
        // imageUrl:'img/emoji/success_delete.webp',
        showConfirmButton: true,
        timer: 2000,
        willClose: () => {
          //   window.location = url;
        }
      });
      break;

    case "custom":
      Swal.fire({
        icon: 'info',
        title: title,
        willClose: () => {

          if (url != "") {
            window.location = url;
          }
        }
      });
      break;
    case "custom_attendance":
      Swal.fire({
        icon: 'success',
        title: title,
        willClose: () => {

          if (url != "") {
            window.location = url;
          }
        }
      });
      break;
    case "custom_mail":
      Swal.fire({
        icon: 'success',
        title: title,
        willClose: () => {

          if (url != "") {
            window.location = url;
          }
        }
      });
      break;
    case "password_alert":
      Swal.fire({
        icon: 'info',
        title: 'Please Update either Password Or Profile Image',
        // imageUrl:'img/emoji/form_fill.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true
      })
      break;
    case "gst_alert":
      Swal.fire({
        icon: 'info',
        title: 'Please enter a valid GST Number',
        showConfirmButton: true,
        timer: 4000,
        timerProgressBar: true
      });
      break;
  }
}

//   Sweet Alert Delete Confirmation Function
confirm_delete = function (msg) {
  return sweetalert(msg); // <--- return the swal call which returns a promise
};

//   Sweet Alert Function Ends

// Online Offline Check Function

function is_online() {
  return true;
  // return(navigator.onLine);
  return false;
}

// GEO Location Check Function

function geo_location() {
  if (!navigator.geolocation) {
    sweetalert("no_location");
    return false;
  }
  return true;

}

function is_online1() {
  if (!navigator.onLine) {
    sweetalert("no_internet");
    return false;
  }
}

function form_reset(form_class = "", form_name = "", form_id = "") {

  if (form_class) {
    $('.' + form_class).find('input').val('');
    $('.' + form_class).find('select').val('');
    $('.' + form_class).find('.select2').val(null).trigger('change');
    $('.' + form_class).find('textarea').val('');
  } else if (form_id) {
    $('#' + form_id).find('input').val('');
    $('#' + form_id).find('select').val('');
    $('#' + form_id).find('.select2').val(null).trigger('change');
    $('#' + form_id).find('textarea').val('');
  }
  // $("#mySelect option[value='']").attr('selected', true)
}

// From date must be lower than to date
function fromToDateValidity(fromDate = "", toDate = "") {
  fromDate = new Date(fromDate);
  toDate = new Date(toDate);

  // To calculate the time difference of two dates 
  var Difference_In_Time = fromDate.getTime() - toDate.getTime();

  // To calculate the no. of days between two dates 
  var Difference_In_Days = Math.ceil(Difference_In_Time / (1000 * 3600 * 24));

  // alert(Difference_In_Days);
  if (Difference_In_Days > 0) {
    sweetalert("custom", "", "", "From Date Must be Equal or Lower than To Date");
    return false;
  }

  return true;
}


// function Indian Money Format

function indianMoneyFormat(value = "") {

  value = Number(value);

  if (isNaN(value)) {
    value = 0;
  }

  return (value).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');

}

function number_only(event) {

  if ((event.keyCode < 46) || (event.keyCode > 57)) event.returnValue = false;

}

function same_item_repeat_validation(input_name = "", input_id = "", input_value = "") {

  var input_name = document.getElementsByName(input_name);

  input_name.forEach(insert_arr);

  function insert_arr(data) {

    if ((data.value == input_value) && (data.id != input_id)) {

      sweetalert("custom", "", "", "Already  Exist in List");
      $("#" + input_id).val(null).trigger("change");
      return false;
    }
  }
}

// Geolocation Enable check
function getLocation() {
  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(showPosition, showError);

  } else {

    alert("This form Needs Location Permission! Please allow to continue");
    // document.getElementById('show_locaiton').innerHTML = "Geolocation is not supported by this browser.";

  }
}

function showPosition(position) {

  document.getElementById('latitude').value = position.coords.latitude;
  document.getElementById('longitude').value = position.coords.longitude;

}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "Location information is unavailable."
      break;
    case error.TIMEOUT:
      x.innerHTML = "The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "An unknown error occurred."
      break;
  }
}

function print_image(file_name, folder_name = "bids_management") {
  var url = 'uploads/' + folder_name + '/' + file_name;
  onmouseover = window.open(url, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}



function minute_to_time(min = 0) {
  let time = "00:00";
  if (min) {
    hour = parseInt(min / 60);
    min = min - (hour * 60);
    min = pad(min, 2);
    hour = pad(hour, 2);
    time = hour + ":" + min;
  }
  return time;
}

function pad(num, size) {
  num = num.toString();
  while (num.length < size) num = "0" + num;
  return num;
}




function number_only(input) {

	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.',','
	 ];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function dec_number(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function password(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_aadhar_number(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	 ];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_mobile_number(input) {
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
	const validStartingChars = ['6', '7', '8', '9'];
  
	// Check if the first character is valid
	if (input.value.length > 0 && !validStartingChars.includes(input.value.charAt(0))) {
	  var msg = "number_alert"
	  sweetalert(msg);
	  // Clear the input if the first character is invalid
	  input.value = '';
	  return;
	}
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function off_id(input) {
  
	const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','-','_',
	  '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function description_val(input) {
  
	const allowedChars = [
	 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	  ' ', ',', '.'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function mail_valid(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	  ' ', '_', '.','@'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function validateCharInput(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	  ' ', ',', '.', '!', '-', '/', '_', '@'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_address(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	  ' ', ',', '.','-', '/'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_user_name(input) {
  
	const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',' '
	];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }

  function valid_landline_number(input) {
    const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];

    // Filter out characters that are not in the allowedChars array
    input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
}

  
  function valid_password(input) {
  
	const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	  ' ', ',', '.','-','@','#','$','&','*', '/'];
  
	// Filter out characters that are not in the allowedChars array
	input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }

function print_pdf_1(file_name) {
    
	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

function print_pdf_2(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

 
</script>

