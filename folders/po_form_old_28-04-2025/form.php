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

    label {
        font-weight: 500 !important;

    }

    form.was-validated button {
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
     width: 162%;
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
  
  outline: 0;
}
.actions1 {
    
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
    </style>
    <script src='folders/po_form/main_script.js'></script>
<script src='folders/po_form/script.js'></script>

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
            
              
            'unique_id'
           

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
             
            // $po_prepared_by          = $result_values[0]["po_prepared_by"];
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
$department_options = select_option($department_options, "Select Customer", $department);

$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

$tender_code_options = tender_name($tender_code);
$tender_code_options = select_option1($tender_code_options, "Select Tender");

$item_code_options = item_name($item_code);
$item_code_options = select_option($item_code_options, "Select Item Code");

$state_name_options = state_option();
$state_name_options = select_option($state_name_options, "Select State Name", $state_name);

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

$team_members_options = select_option($team_members_options, "Select Team Member" );



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
                            id="wizard" style="height:100%;">
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
                            <div class="multisteps-form__panel js-active" data-animation="slideVert">
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
                                                <div class="row">
                                                <div class="col-xl-3" align="right" style="margin-left: 74%;">
                                                        <div class="mb-3" id="modal">
                                                            <!-- <button type="button" class="btn btn-primary"> -->
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target=".bs-example-modal-xl">
                                                                <i
                                                                    class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2 btn btn-primary"></i></a>
                                                            <!-- </button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">PO
                                                                Number<span class="red-star">*</span></label>
                                                            <input type="text" id="po_num" name="po_num"
                                                                class="form-control" onchange="get_po_no();"
                                                                oninput="validateCharInput(this)" value="<?php
if ($po_num != '') {
                                                                    echo $po_num;
                                                                } ?>" required>

                                                        </div>
                                                    </div>

                                                    
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">PO
                                                                Date<span class="red-star">*</span></label>
                                                            <input type="date" id="po_date" name="po_date"
                                                                class="form-control" value="<?php
echo $po_date; ?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">

                                                            <label class="form-label">Customer<span
                                                                    class="red-star">*</span></label>
                                                                    <br>

                                                            <select  class="select  form-control" data-live-search="true" id="department"
                                                                name="department" onchange="get_account_sector()"  required>
                                                                <?php
echo $department_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
    <div class="mb-3">
        <label class="form-label">Account Sector<span class="red-star">*</span></label><br>
        <input type="hidden" id="acc_sector" name="acc_sector" value="<?php
echo $acc_sector; ?>">
<input type="text" class="form-control" id="acc_sector_name" name="acc_sector_name" value="<?php
echo $acc_sector_name; ?>" readonly>

       
    </div>
</div>
                                                    <div class="col-xl-3">
    <div class="mb-3">
        <label class="form-label">Account Vertical<span class="red-star">*</span></label><br>
        <select class="select form-control" name="acc_vertical" id="acc_vertical" required>
            <?php
echo $account_vertical_options ; ?>
        </select>
    </div>
</div>
                                                    

                                                   
                                                   
                                                    

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="old_gst_option"
                                                                name="old_gst_option"
                                                                value="<?php
echo $gst_option; ?>" />
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
                                                            <?php
} else if ($gst_option == 'no') { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchage="gst_check()" value="<?php
echo $gst_option; ?>">
                                                                        <option>selcet option</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no" selected>No
                                                                        </option>

                                                                    </select>
                                                            <?php
} else { ?>
                                                                    <select class="form-select mb-3" id="gst_option"
                                                                        name="gst_option" onchange="gst_check()" value="<?php
echo $gst_option; ?>">
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
                                                            <input type="text" id="gst_value" name="gst_value"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                onchange="validagst1(this)"
                                                                value="<?php
echo $gst_value; ?>" required>
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
                                                            <select class="form-select mb-3" id="executive_name"
                                                                name="executive_name" required>
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
                                                                required><?php
echo $bill_address; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Name</label>
                                                            <input type="text" id="contact_name" name="contact_name"
                                                                class="form-control" oninput="valid_user_name(this)"
                                                                value="<?php
echo $contact_name; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Number</label>
                                                            <input type="text" id="contact_number" name="contact_number"
                                                                class="form-control" oninput="valid_mobile_number(this)"
                                                                value="<?php
echo $contact_number; ?>" minlength="10"
                                                                maxlength="10">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Landline
                                                                Number</label>
                                                            <input type="text" id="contact_landline_num"
                                                                name="contact_landline_num" class="form-control" maxlength="12"
                                                                value="<?php
echo $contact_landline_num; ?>"
                                                                oninput="validateLandline(this)">
                                                           
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="text" id="email" name="email"
                                                                onkeypress="validateEmail(event)" class="form-control"
                                                                value="<?php
echo $email; ?>">
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
                                                                <?php
echo $state_name_options; ?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">District</label>
                                                         
                                                     
                                                            <select id="district"  name="district" class="form-control"  required> 
                                                                <!--<option value="">Select District</option>-->
                                                               <?php
echo $district_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
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
echo $pin; ?>" required>

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
echo $po_type; ?>" required>
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
echo $no_of_po; ?>" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                                <!--id="checkit" style="display:none"-->
                                              

                                                <?php
if ($update_unique_id != '') { ?>
                                                      <li onclick="po_form_cu_1()"><span class="btn btn-primary js-btn-next"
                                                                title="NEXT"
                                                                class="btn btn-success waves-effect waves-light">Update
                                                                &continue<i class="fa fa-arrow-right"></i></span>
                                                        </li>  

                                                <?php
} else{?>
                                                  <li onclick="po_form_cu_1();" >
                                                        <span class="btn btn-primary js-btn-next" title="NEXT">
                                                            Save & Continue <i class="fa fa-arrow-right"></i>
                                                        </span>
                                                </li>
                                                <?php
}?>
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
                                                                <?php
echo $tender_code_options; ?></select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Item Code</label>
                                                            <!--                                                                 
                                                            <input type="text" id="item_code" name="item_code" 
                                                                class="form-control" value="<?php
echo $item_code; ?>"
                                                                > -->
                                                            <select name="item_code" id="item_code"
                                                                class="select2 form-control select2_op" required
                                                                onchange="item_detail(this.value)">
                                                                 <?php
echo $item_code_options; ?> 
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Product</label>
                                                            <input type="text" id="po_name" name="po_name"
                                                                class="form-control" value="<?php
echo $product; ?>"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Qty</label>
                                                            <input type="text" id="qty" name="qty" onchange="CalculateTotal()" class="form-control"
                                                                oninput=quantity_number(this);
                                                                value="<?php
echo $qty; ?>" required>
                                                            <!-- onkeypress="return isNumber(event)" -->
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-3"  >
                                                        <div class="mb-3">
                                                            <label class="form-label">Unit
                                                                Price</label>
                                                            <input type="text" id="unit_price" name="unit_price"
                                                                class="form-control"
                                                                value="<?php
echo $unit_price; ?>" required readonly>
                                                                
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-3"  >
                                                        <div class="mb-3">
                                                            <label class="form-label">Net price<span style="color:red">(with tax)</span></label>
                                                            <input type="text" id="net_price" name="net_price"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                value="<?php
echo $net_amount; ?>" required readonly>
                                                                 
                                                        </div>
                                                    </div>
                                                    
                                                     
                                                    <div class="col-xl-3 " >
                                                        <div class="mb-3">
                                                            <label class="form-label">Tax</label>
                                                            <!--<select class="form-select mb-3" id="tax" name="tax">-->
                                                                <!--<?php
echo $tax_select_options; ?>-->
                                                            <!--</select>-->
                                                            <input type="text" id="tax" class="form-control" name="tax" value="<?php
echo $tax;?>" readonly>
                                                            <!--required-->
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-xl-3 " >
                                                        <div class="mb-3">
                                                            <label class="form-label">Total
                                                                Net Amount <span style="color:red;">( With Tax )</span></label>
                                                            <input type="text" id="total_value" name="total_value"
                                                                class="form-control" value="<?php
echo $total_value; ?>"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Total Without Tax
                                                            </label>
                                                            <input type="text" id="net_value" name="net_value"
                                                                class="form-control" value="<?php
echo $net_value; ?>"
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
                                                                value="<?php
echo $delivery_due_dates; ?>" required>
                                                                 <span style="color:red">Valid The Delivery Due Dates in RFP</span>
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Installation Due Days</label>
                                                            <input type="text" id="insta_due_days"
                                                                name="insta_due_days" class="form-control"
                                                                onkeypress="return isNumber(event)"
                                                                value="<?php
echo $installation_due_dates; ?>" required>
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
                                                                <input type="text" id="ld_per_day" name="ld_per_day" onkeypress="return isNumberss(event)" onkeyup="validateNumber(this)" class="form-control" value="<?php
echo $ld_per_day; ?>">
                                                                
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">LD
                                                                Maximum
                                                                %</label>
                                                            <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                                class="form-control" onkeypress="return isNumberss(event)" onkeyup="validateNumber(this)"
                                                                value="<?php
echo $ld_maximum_val; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="old_warranty" name="old_warranty"
                                                                value="<?php
echo $warranty; ?>" />

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
                                                            <?php
} else if ($warranty == '0') { ?>
                                                                    <select class="form-select mb-3" id="warranty"
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
                                                                    <select class="form-select mb-3" id="warranty"
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
                                                    </div><!-- end col -->
                                                    <div class="col-xl-3" id="select_warranty">
                                                        <div class="mb-3">
                                                            <label class="form-label">Warranty
                                                                Duration</label>
                                                            <select class="form-select mb-3" id="warranty_duration"
                                                                name="warranty_duration"
                                                                value="<?php
echo $warranty_duration; ?>">
                                                                <?php
echo $warranty_options; ?>
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



                                                    <input type="hidden" name="stored_item" id="stored_item">
                                                    <input type="hidden" name="count_item" id="count_item">

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php
echo $no_of_po; ?>">-->
                                                            <button type="button" id="pro_details" style="margin-top: -2px;position: relative;margin-left: 403%;"
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
                                           $password = project_env('APP_DB_PASSWORD'); 
                                            $databasename= "operation_team";
                                        
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
                                                                value="<?php
echo $batch_id; ?>">
                                                                
                                                                

                                                        </div>
                                                    </div>
                                                   
                                                    
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Received Date</label>
                                                            <input type="date" name="consignee_received_date" id="consignee_received_date" class="form-control"  value="<?php
echo date('Y-m-d');?>"  >
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
                                                        class="form-control" value="<?php
echo $no_of_consignee; ?>">

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
                                                                <?php
echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" id="d2" style="display:none;">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee District</label>
                                                            
                                                            <select name="con_district" id="con_district"
                                                                class="select2 form-control" required>
                                                                <?php
echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Zone</label>
                                                            <input type="text" name="zone" id="zone"
                                                                oninput="valid_user_name(this)" class="form-control"
                                                                value="<?php
echo $zone; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Pincode</label>
                                                            <input type="text" id="con_pincode" name="con_pincode"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                minlength="6" maxlength="6"
                                                                value="<?php
echo $con_pincode ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Contact Name </label>
                                                            <input type="text" id="con_contact_name"
                                                                name="con_contact_name" class="form-control"
                                                                oninput="valid_user_name(this)"
                                                                value="<?php
echo $con_contact_name ?>" required>
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
                                                                value="<?php
echo $con_contact_number ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee Landline Number
                                                            </label>
                                                            <input type="tel" id="con_lan_num" name="con_lan_num"
                                                                oninput="valid_landline_number(this)" maxlength="12"
                                                                class="form-control" value="<?php
echo $con_lan_num ?>">

                                                          
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
                                                                value="<?php
echo $consignee_gst; ?>" required>

                                                           <span id="con_gst_error"
                                                                style="color: red; display: none;">Enter a valid GST
                                                                number</span>

                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Assign Team Member
                                                            </label>
                                                            <select class="form-control" name="assign_team_member" id="assign_team_member">
                                                              <?php
echo $team_members_options;?>
                                                            </select>
                                                                
                                                          
                                                        </div>
                                                    
                                                    <input type="hidden" name="count_consignee" id="count_consignee">
                                                    <input type="hidden" name="stored_consignee" id="stored_consignee">
                                                    
                                                    
<div class="col-xl-3 ">
                                                        <div class="mb-3" style="margin-top: -54px;margin-left: 392px;">
                                                            <button type="button"  style="display:none" id="mybtns" 
                                                                class="btn btn-success consignee_details_add_update_btn"
                                                                onclick="consignee_details_add_update(),get_stored_sublist_count()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>
                                                        </div>
                                                       

                                                    </div>\

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
                                        <input type="hidden" name="batch_record" id="batch_record" value="<?php
echo $batch_id1;?>" >
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
                                                                
                                                        </ul>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                           
                                        </div>
                                        </div>
                                        <?php
include 'import.php';?>

                                           <?php
include 'consigneeimport.php'; ?>
                                             <input type="hidden" name="demoinpt" id="demoinpt">   
                                            
                               
                                  <!--single form panel-->
                            
                            
                            <div class="multisteps-form__panel" data-animation="slideVert"  id="mytabs"
                                style="background: white;margin-top: 151px;margin-left: 15px;width: 96%;">
                                <div class="inner pb-100">
                                   
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                           <?php
?>
                                                                                <div class="row">
                                                                                <div class="col-xl-3 ">
                                                     <div class="mb-3">
                                                         <label class="form-label">Batch ID
                                                            </label>
                                                            <select class="form-control" name="batch_numbers" id="batch_numbers">
                                                             
                                                            </select>
                                                        </div>
                                                         </div>

 <div class="col-xl-3 ">
                                                     <div class="mb-3">
                            <button type="button" style="margin-top: 33px;" name="batch_btn" id="batch_btn" onclick="get_check_po_batchs(batch_numbers.value)" class="btn btn-primary">GO</button>
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
                                                            <!---->
                                                <li id="tab31" onclick="check_qty()"><span title="NEXT" class="btn btn-primary js-btn-next">NEXT <i
                                                            class="fa fa-arrow-right" ></i></span></li>
                                            </ul>
                                         </div>
                                    </div>
                            </div>
                            </div>

                            
                            </div>
                             
                            </div>
                            
                            </div>
                            
                            <div class="multisteps-form__panel" data-animation="slideVert" style="margin-top: 238px;margin-left: 19%;" id="tab51">
                                <div class="inner pb-100">
                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="row">
                                                
                                                <div class="col-xl-3">
                                                    <div class="col-xl-3 mb-3">
                                                        <div class="form-group form-check  mt-2">
                                                            <?php
if ($amc_required == 'on') { ?>
                                                                <input type="checkbox" class="form-check-input amccheckbox"
                                                                    id="amc_required" name="amc_required" onchange="valueChangedamc()" checked>
                                                            <?php
} else { ?>
                                                                <input type="checkbox" class="form-check-input amccheckbox"
                                                                    id="amc_required" name="amc_required"
                                                                    onchange="valueChangedamc()">
                                                            <?php
} ?>
                                                            <label class="form-check-label">IS AMC Required</label>
                                                        </div>
                                                        
          
  
                                                        <div class="form-group form-check  mt-2">

                                                            <?php
if($insurence_required == 'on'){?>
                                                                    <input type="checkbox" class="form-check-input insurence_required"
                                                                            id="insurence_required" name="insurence_required" checked
                                                                            onclick="insurence()">
                                                                    <?php
}
                                                                            else{ ?>
                                                                <input type="checkbox" class="form-check-input insurence_required"
                                                                            id="insurence_required" name="insurence_required" 
                                                                            onclick="insurence()">
                                                                    <?php
}
                                                                    ?>

                                                            <label class="form-check-label">
                                                                Insurance Required
                                                                </label>
    
                                                        </div>
                                                        <div class="form-group form-check  mt-2">
                                                        <?php
if($ld_required == 'on'){?>
                                                               
                                                               <input type="checkbox" class="form-check-input "
                                                                    id="ld_required" name="ld_required" 
                                                                    onchange="ld_cal_validation()" checked>

                                                                <?php
}
                                                                        else{ ?>
                                                            <input type="checkbox" class="form-check-input "
                                                                    id="ld_required" name="ld_required" 
                                                                    onchange="ld_cal_validation()" >

                                                                <?php
}
                                                                ?>

                                                            <label class="form-check-label">
                                                              LD Calculation
                                                            </label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            <div class="col-xl-3" id="insu_types" style="display:none">
                                                



      <div class="mb-3">
        <label class="form-label">Insurance Sub-Type</label>
        <?php
if($insurence_required==""){ ?>
            <select name="insurence_types[]" id="insurence_types" data-live-search="true" multiple onchange="other_insurence_types()" class="selectpicker form-control">
            <?php
echo $insurance_type_options; ?>
            </select>
        <?php
} else { ?>
            <select name="insurence_types[]" id="insurence_types" data-live-search="true"  multiple onchange="other_insurence_types()" class="selectpicker form-control">
               <?php
echo $insurance_type_options; ?>
            </select>
        <?php
} ?>
    </div>
</div>

                                            
                                              <div class="col-xl-3" id="others_insu_types" style="display:none">
                                                <div class="mb-3">
                                                  <label class="form-label">Other Insurance Type</label>
                                                  <input type="text" id="other_insurance_type" name="other_insurance_type" class="form-control" placeholder="Please specify" value="<?php
echo $other_insurance_type; ?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3" id="ld_calculate" style="display:none">
                                                    <div class="mb-3">
                                                      <label class="form-label">LD Calculation Date Type</label>
                                                      <?php
if($ld_required ==""){?>
                                                      
                                                      <select name="ld_date_type" id="ld_date_type"  class="select2 form-control" onchange="ldcalculate()">
                                                    
                                                        <option value="">Select</option>
                                                        <option value="1">From PO Date</option>
                                                        <option value="2">From Consignee Date</option>
                                                      </select>
                                                      <?php
} else if($ld_required !=""){ ?>
                                                     <select name="ld_date_type" id="ld_date_type" class="select2 form-control" onchange="ldcalculate()">
                                                            <option value="">Select</option>
                                                            <option value="1" <?php
if($ld_date_type == "1") echo "selected"; ?>>From PO Date</option>
                                                            <option value="2" <?php
if($ld_date_type == "2") echo "selected"; ?>>From Consignee Date</option>
                                                        </select>
                                                    <?php
} ?>
                                                    </div>
                                                </div>
                                                                     
                                                      
                                                        <div class="col-xl-3" id="ld_calculate_1" style="display:none">
                                                <div class="mb-3">
                                                    <label class="form-label">Delivery Due Date</label>
                                                    <input type="date" id="ld_delivery_due_date" name="ld_delivery_due_date" class="form-control"
                                                           placeholder="Please specify" value="<?php
echo ($ld_required != "") ? $ld_delivery_due_date : ''; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-3" id="ld_calculate_2" style="display:none">
                                                <div class="mb-3">
                                                    <label class="form-label">Installation Due Date</label>
                                                    <input type="date" id="ld_installation_due_date" name="ld_installation_due_date" class="form-control"
                                                           placeholder="Please specify" value="<?php
echo ($ld_required != "") ? $ld_installation_due_date : ''; ?>">
                                                </div>
                                            </div>
                                                  <div class="row">
 
                                                        <div class="col-xl-3 po_filediv">
                                                            <div class="mb-3 " >
                                                                <label class="form-label">Attach PO Copy </label>
        
                                                                <div style="display:flex;">
                                                                    <input type="file" id="po_file" accept="application/pdf"
                                                                    name="po_file" class="form-control "
                                                                    value="<?php
echo $file_org_name; ?>">
                                                                    


                                                                <input type="hidden" name="mypo" id="mypo" value="<?php
if ($po_num != '') {
                                                                    echo $po_num;
                                                                } ?>">
                                                                
                                                       <input type="hidden" name="po_attach_file" id="po_attach_file" value="<?php
echo $fil_name; ?>">
                                                                
                                                      
        <?php
if ($po_file_name != '') {?>
                                                                                           
    <span class="ml-1" id="po_attach_view" >
        <a href="javascript:print_pdf_po('<?php
echo '/' . $po_file_name; ?>')">
            <img src="uploads/po_form/po_attach/pdf.png" height="30" width="30" alt="PDF">
           
        </a>
    </span>
    <?php
}?>
   

                                                                </div>
                                                            </div>
                                                        </div>
                                      
                                                        <div class="col-xl-3 start_datediv" id="start_datediv" style="display:none">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Start Date</label>
                                                                   
                                                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                                                        value="<?php
echo $start_date; ?>">
                                                                </div>
                                                        </div>
                                                        <div class="col-xl-3 end_datediv" id="end_datediv" style="display:none">
                                                                <div class="mb-3">
                                                                    <label class="form-label">End Date</label>
                                                                   
                                                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                                                        value="<?php
echo $end_date; ?>">
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                     <div class="col-xl-3 amcpercendiv" id="amcpercendiv" style="display:none">
                                                        <div class="mb-3">
                                                            <label class="form-label">AMC%</label>
                                                           
                                                            <input type="text" id="amc_percentae" name="amc_percentae" class="form-control"
                                                                value="<?php
echo $amc_percentae; ?>">
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3 amcvaluediv" id="amcvaluediv" style="display:none">
                                                        <div class="mb-3">
                                                            <label class="form-label">AMC Value</label>
                                                           
                                                            <input type="text" id="amcvalue" name="amcvalue" class="form-control"
                                                                value="<?php
echo $amcvalue; ?>">
                                                        </div>
                                                    </div>
                                                     <div class="col-xl-3 amcpofilediv" id="amcpofilediv" style="display:none">
                                                        <div class="mb-3">
                                                            <label class="form-label">AMC PO order</label>
                                                           
                                                            <input type="file" id="amcpofile" name="amcpofile" class="form-control"
                                                                value="" accept=".pdf">
                                                        </div>
                                                    </div>
                                                    
                                               <div class="mb-3 addbtn" id="addbtn" style="display:none">
                                                   <button type="button" class="btn btn-success amcsub_list_datatable_add_update_btn" onclick="amcsub_list_datatable_add_update()">

                                                         <i class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                        Add New
                                                    </button>
                                                </div>


                                                    
                                                
                                                     <div class="table-responsive mb-2" id="amc_table" style="display:none">
                                                            <div id="amc_datatable_wrapper" style="margin-left: -51px;
    width: 77%;
    margin-top: -31px;"
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
                                                                    <div class="col-sm-12 pl-1 pr-1 ">
                                                                        <table id="amc_table_datatable" 
                                                                            class="table table-hover table-bordered align-middle mb-0 dataTable no-footer">
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
                               </div>
                               
                                  <input type="hidden" id="po_form_unique_id" name="po_form_unique_id"
                                value="<?php
echo $result_values[0]["unique_id"];?>">
                                    <style>
                                        .actions1 {
                                    
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
                                
                            

                            </style>
                            <div class="wizard-footer">
                                <div class="actions1">
                                    <ul>
                                        <li class="action-left">
                                            	<?php
echo btn_cancel($btn_cancel); ?>
                                         
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

                            </div> <!--  las tab-->

                    </div>

                    <!----content start---------->
                    <!--  Extra Large modal example -->
                    <div class="modal bs-example-modal-xl" id="demos" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Customer
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
                                                            <label class="form-label">Account Sector</label>
                                                                <select class="select form-control" name="acc_sector_1" id="acc_sector_1" required>
            <?php
echo $account_sector_options ; ?>
        </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-4 head_po">
                                                        <div class="row">
                                                            
                                                        
                                                        <div class="col-xl-12 head_po">
                                                                <label class="form-label">Customer</label>
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
                                                                    <?php
echo $active_status_options; ?>
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
            <input type="text" class="form-control" id="up_con_address" name="up_con_address" >
          </div>
          
          <div class="mb-2">
            <label>District</label>
             <select name="up_con_district" id="up_con_district"
                                                                class="select2 form-control" required>
                                                               </select>
          </div>
          <div class="mb-2">
            <label>Zone</label>
            <input type="text" class="form-control" id="up_zone" name="up_zone" >
          </div>
          <div class="mb-2">
            <label>Pincode</label>
            <input type="text" class="form-control" id="up_con_pincode" name="up_con_pincode" >
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
             <select name="up_assign_team_member" id="up_assign_team_member"
                                                                class="select2 form-control" required>
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
<div class="modal fade" id="editConsigneeModal_old" tabindex="-1" aria-labelledby="editConsigneeLabel" aria-hidden="true">
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
            <input type="text" class="form-control" id="up_con_address" name="up_con_address" >
          </div>
          
          <div class="mb-2">
            <label>District</label>
             <select name="up_con_district" id="up_con_district"
                                                                class="select2 form-control" required>
                                                               </select>
          </div>
          <div class="mb-2">
            <label>Zone</label>
            <input type="text" class="form-control" id="up_zone" name="up_zone" >
          </div>
          <div class="mb-2">
            <label>Pincode</label>
            <input type="text" class="form-control" id="up_con_pincode" name="up_con_pincode" >
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
<!-- <script src='https://code.jquery.com/jquery-3.6.1.min.js'></script> -->

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables + Buttons -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<!-- JSZip and pdfmake for Excel/PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>








<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables core -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- JSZip (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- pdfmake (for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- jQuery -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
<!-- DataTables JS -->
<!--<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>-->
<!-- Buttons extension JS -->
<!--<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>-->
<!-- JSZip for Excel export -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>-->
<!-- pdfmake for PDF export -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>-->
<!-- HTML5 export buttons -->
<!--<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>-->
<!-- Print button -->
<!--<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>-->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">



<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src='folders/po_form/main_script.js'></script>
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
 

 
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
 <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>-->

 
<!-- Bootstrap Selectpicker JS -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script>

$(document).ready(function() {
//    alert('hi');
    // insurence();
    // ld_cal_validation();
    get_po_no();
    po_form_cu_1();
    // get_my_num();
    // valueChangedamc();
    //   get_check_po_batchs(val);
        // get_check_po_batchs();
        // amcsub_list_datatable("amc_table_datatable");
});
 
function get_po_no() {
    document.getElementById('mypo').value = '';
    var po_num = document.getElementById('po_num').value;
    // alert(po_num);
    document.getElementById('mypo').value = po_num;
    document.getElementById('po_numbers').value = po_num;
    // document.getElementById('po_code').value = po_num;
    
}
    



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
            
    
            $("#wizard").steps({
           
           onStepChanging: function (event, currentIndex, newIndex) {
            //   alert();
               if (!po_form_cu_1()) {
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
       
       
      
   
       function po_form_cu_1() {
        alert("hloo");
          
           var internet_status = is_online();
   
           if (!internet_status) {
               sweetalert("no_internet");
               return false;
           }
            $('#no_of_pro_item').empty();
             $('#no_of_po_con').empty();
             
             var testin = document.getElementById('testin').value;
   // if(testin == 1){
       
       
       
           
           var gst_values = document.getElementById('gst_value').value;
   
   // alert(gst_values);
   if(gst_values != ''){
       let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
           if (!gstRegex.test(gst_values)) {
               sweetalert("gst_alert"); // Correct message for invalid GST
               return false;
                
                
           }
           var gst_value = gst_values;
           
   }else{
       
       var gst_value = '';
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
           var acc_vertical = document.getElementById('acc_vertical').value;
           var acc_sector = document.getElementById('acc_sector').value;
          
           var unique_id = document.getElementById('unique_id').value;
           var form_unique_id = document.getElementById('m_unique_id').value;
           var no_of_consignee = document.getElementById('no_of_consignee').value;
           var po_unique_id = document.getElementById('po_unique_id').value;
           //   var gst_value = document.getElementById('gst_value').value;
           // $gst_value
   
           var data = new FormData();
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
            data.append("acc_vertical", acc_vertical);
           data.append("acc_sector", acc_sector);
   
           data.append("email", email);
           data.append("district", district);
           data.append("pin", pin);
          
           data.append("po_type", po_type);
           data.append("no_of_po", no_of_po);
           data.append("state_name", state_name);
          
           data.append("no_of_consignee", no_of_consignee);
           data.append("po_unique_id", po_unique_id);
           //   data.append("gst_value", gst_value);
   
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
              
                   sweetalert(msg);
                   // department_create();
   
   
               },
               error: function (data) {
                   alert("Network Error");
                  
               }
           });
   
       }
   

</script>


