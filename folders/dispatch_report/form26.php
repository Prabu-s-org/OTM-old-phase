<style>
   .img{
 width: 49px;
 margin-top: 18px;
 /* margin-right:200px; */
   }
   label {
    font-weight: 500!important;
   
}
form.was-validated button {
    float: inline-start;
}

#unregistered_message{
    font-size:15px;
    color:red;
    
}
   </style>

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

$tax_select_status ="";

$is_active          = 1;



if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];

        $table      =  "po_form";

        $columns    = [
            "po_unique_id",
            "po_num",
            "po_date",
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
            "po_prepared_by",
            "po_type",
            "no_of_po",
            "delivery_due_dates",
            "ld_per_day",
            "ld_maximum_val",
            "warranty",
            "warranty_duration",
            "exampleCheck1",
            "exampleCheck2",
            "bg",
            "bg_month",
            "file_name",
            "file_org_name",
            "unique_id",
            "no_of_consignee",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;
           $po_unique_id    = $result_values[0]["po_unique_id"];
            $po_num          = $result_values[0]["po_num"];
            $po_date    = $result_values[0]["po_date"];
            $department          = $result_values[0]["department"];
            $gst_option          = $result_values[0]["gst_option"];
            $gst_value    = $result_values[0]["gst_value"];
            $executive_name          = $result_values[0]["executive_name"];
            $bill_address          = $result_values[0]["bill_address"];
            $contact_name    = $result_values[0]["contact_name"];
            $contact_number          = $result_values[0]["contact_number"];
            $email          = $result_values[0]["email"];
            $district    = $result_values[0]["district"];
            $pin          = $result_values[0]["pin"];
            $po_prepared_by          = $result_values[0]["po_prepared_by"];
            $po_type    = $result_values[0]["po_type"];
            $no_of_po          = $result_values[0]["no_of_po"];
            $delivery_due_dates          = $result_values[0]["delivery_due_dates"];
            $ld_per_day    = $result_values[0]["ld_per_day"];
            $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
            $warranty          = $result_values[0]["warranty"];
            $warranty_duration    = $result_values[0]["warranty_duration"];
            $exampleCheck1          = $result_values[0]["exampleCheck1"];
            $exampleCheck2          = $result_values[0]["exampleCheck2"];
            $bg    = $result_values[0]["bg"];
            $file_org_name    = $result_values[0]["file_org_name"];
            $bg_month          = $result_values[0]["bg_month"];
            $no_of_consignee          = $result_values[0]["no_of_consignee"];
           $update_unique_id    = $result_values[0]["unique_id"];
            $is_active          = $result_values[0]["is_active"];

           
            // print_r($result_values[0]["po_unique_id"]);

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

if($_GET["unique_id"] != ''){
    $unique_id =$_GET["unique_id"];
}else{
    $prefix    = "PO";
    $unique_id = unique_id($prefix);
    
}
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$tax_select_options       = 
["18%" => [
    "unique_id" => "18",
    "value"     => "18%",
        ],
        "28%" => [
    "unique_id" => "28",
    "value"     => "28%",
        ],
        "Without Tax" => [
    "unique_id" => "No",
    "value"     => "Without Tax",
        ],
    ];

$tax_select_options        = select_option($tax_select_options,"Select Tax",$tax_select_status);

$active_status_options   = active_status($is_active);

$executive_name_options = executive_name($executive_name);
$executive_name_options = select_option($executive_name_options, "Select Executive", $executive_name);

$district_options = district_name($district);
$district_options = select_option($district_options, "Select District", $district);

$warranty_options = warranty_name($warranty_duration);
$warranty_options = select_option($warranty_options, "Select Warranty", $warranty_duration);

$po_type_options = po_type_option($po_type);
$po_type_options = select_option($po_type_options, "Select Po Type", $po_type);

$department_options = department_creation_table($department);
$department_options = select_option($department_options, "Select Department",  $department);

// PO Number generate function
function generatePrefixedId($prefix, $numericPart) {
    // Use sprintf to format the numeric part with leading zeros
    $formattedNumericPart = sprintf("%03d", $numericPart);

    // Concatenate the prefix and the formatted numeric part
    $prefixedId = $prefix . $formattedNumericPart;
    return $prefixedId;
}

$prefix = "ELT-";
$numericPart = 1;
$generatedId = generatePrefixedId($prefix, $numericPart);

//echo "Generated ID: $generatedId";

// PO Unique ID Number generate function
// function generatePoUniqueId($prefix, $numericPart) {
//     // Use sprintf to format the numeric part with leading zeros
//     $formattedNumericPart = sprintf("%05d", $numericPart);

//     // Concatenate the prefix and the formatted numeric part
//  $prefixedId = $prefix . $formattedNumericPart;
//     return $prefixedId;
// }

// // $prefix = "PO-";
// $date = date("Y");
// $st_date = substr($date, 2);
// $month = date("m");
// $datee = $st_date . $month;
// $prefix = 'PO-' . $datee.'-';
// $numericPart = 1;
// $po_unique_Id = generatePoUniqueId($prefix, $numericPart);

// echo "Generated ID: $po_unique_Id";

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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
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
                            <button  class="multisteps-form__progress-btn" >Consignee Details</button>
                            <button class="multisteps-form__progress-btn">Assign Qty Details </button>
                            <button class="multisteps-form__progress-btn">Terms & Condition </button>
                        </div>
                    </div>
                </div>
                <!--form panels-->

                <!--form panels-->
                <div class="row">
                    <div class="col-12 col-lg-12 m-auto">
                        <form class="multisteps-form__form was-validated clearfix " action="#" method="post" id="wizard">
                        <input type="hidden" id="m_unique_id" name="m_unique_id" value="<?php echo $unique_id; ?>">
                        <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php echo $unique_id; ?>">

                        <input type="hidden" id="unique_id" name="unique_id" value="<?php echo $update_unique_id; ?>">

                        <input type="hidden" id="demo" name="demo"
                            value="<?php if($update_unique_id !=''){ echo  $update_unique_id;}else{ echo $unique_id;} ?>">

                        <input type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $po_unique_Id; ?>">

                            <!--single form panel-->
                            <div class="multisteps-form__panel js-active" data-animation="slideVert" >
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
                                                            <b><?php echo $po_unique_id;?></b>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">PO
                                                                Number</label>
                                                            <input type="text" id="po_num" name="po_num"
                                                                class="form-control"
                                                                value="<?php if($po_num !=''){ echo  $po_num;}?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">PO
                                                                Date</label>
                                                            <input type="date" id="po_date" name="po_date"
                                                                class="form-control" value="<?php echo $po_date; ?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen"
                                                                class="form-label">Department</label>
                                                            <!--<input type="text" id="department" name="department"-->
                                                            <!--    class="form-control" value="<?php echo $department; ?>"-->
                                                            <!--    required>-->
                                                             <select class="form-select mb-3" id="department" name="department" required> 
                                                             <?php echo $department_options;?>
                                                             </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="old_gst_option"
                                                                name="old_gst_option"
                                                                value="<?php echo $gst_option; ?>" />
                                                            <label for="main_screen" class="form-label">GST
                                                                Option</label>
                                                            <?php 
                                        if($gst_option == 'yes'){?>
                                                            <select class="form-select mb-3" id="gst_option"
                                                                name="gst_option">
                                                                <option>selcet option</option>
                                                                <option value="yes" selected>Yes
                                                                </option>
                                                                <option value="no">No</option>

                                                            </select>
                                                            <?php }else if($gst_option == 'no'){ ?>
                                                            <select class="form-select mb-3" id="gst_option"
                                                                name="gst_option" value="<?php echo $gst_option; ?>">
                                                                <option>selcet option</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no" selected>No
                                                                </option>

                                                            </select>
                                                            <?php }else{?>
                                                            <select class="form-select mb-3" id="gst_option"
                                                                name="gst_option" value="<?php echo $gst_option; ?>">
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                         

                                                            </select>
                                                            <?php } ?>
 
                                                        </div>
                                                          
                                                    <span id="unregistered_message">GST  Unregistered </span>

                                                    </div>
                                                  
                                                    <div class="col-xl-3" id="gst_num">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Customer
                                                                GST
                                                                Number</label>
                                                            <input type="text" id="gst_value" name="gst_value"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                value="<?php echo $gst_value; ?>" >

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Excutive
                                                                Name</label>
                                                            <select class="form-select mb-3" id="executive_name"
                                                                name="executive_name">
                                                                <?php echo $executive_name_options; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Billing
                                                                Address</label>
                                                            <!--<input type="text" id="bill_address" name="bill_address"-->
                                                            <!--    class="form-control"-->
                                                            <!--    value="<?php echo $bill_address; ?>" required>-->
                                                        <textarea  id="bill_address" name="bill_address"  class="form-control" required><?php echo $bill_address; ?></textarea>
                                                      
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Conatact
                                                                Name</label>
                                                            <input type="text" id="contact_name" name="contact_name"
                                                                class="form-control"  onkeypress="validateCharacter(event)"
                                                                value="<?php echo $contact_name; ?>" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Contact
                                                                Number</label>
                                                            <input type="text" id="contact_number" name="contact_number"
                                                                class="form-control"
                                                                value="<?php echo $contact_number; ?>"
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Email</label>
                                                            <input type="text" id="email" name="email" onkeypress="validateEmail(event)"
                                                                class="form-control" value="<?php echo $email; ?>"
                                                                required>
                                                                <span id="emailValidationMessage"></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">District</label>
                                                            <select class="form-select mb-3" id="district"
                                                                name="district">
                                                                <?php echo $district_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Pin
                                                                Code</label>
                                                            <input type="text" id="pin" name="pin" class="form-control"
                                                                onkeypress="return isNumber(event)" minlength="6"
                                                                maxlength="6" value="<?php echo $pin; ?>" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">PO
                                                                Prepared by
                                                            </label>
                                                            <input type="text" id="po_prepared_by" name="po_prepared_by"
                                                                class="form-control" onkeypress="validateCharacter(event)"
                                                                value="<?php echo $po_prepared_by; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label"> PO Type
                                                            </label>
                                                            <select class="form-select mb-3" id="po_type" name="po_type"
                                                                aria-label="Default select example"
                                                                value="<?php echo $po_type; ?>">
                                                                <?php echo $po_type_options; ?>
                                                                <!-- <option value="">Select Option </option>
                                                                                      <option value="1">Product</option>
                                                                <option value="2">Service</option> -->
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">No of
                                                                Items in PO
                                                            </label>
                                                            <input type="text" id="no_of_po" name="no_of_po"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                maxlength="3" value="<?php echo $no_of_po; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">No of
                                                                Consignee</label>
                                                            <input type="text" id="no_of_consignee"
                                                                name="no_of_consignee" class="form-control"
                                                                onkeypress="return isNumber(event)" maxlength="3"
                                                                value="<?php echo $no_of_consignee; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                            <?php if($update_unique_id ==''){?>
                                                <!-- <li><span class="js-btn-next" title="NEXT">NEXT <i -->
                                                    <!-- class="fa fa-arrow-right"></i></span></li>  -->
                                              <li><span class="btn btn-primary js-btn-next" title="NEXT" 
                                        onclick="po_form_cu()">Save & Continue <i class="fa fa-arrow-right"></i></span>
                                            </li> 
                                            <!-- <li class="next list-inline-item float-right mr-0"><span class="js-btn-next" title="NEXT">
                                                <a href="javascript: void(0);" class="btn btn-asgreen btn-rounded waves-effect waves-light float-right createupdate_btn"><?php echo $btn_text; ?> & Continue</a></span>
                                            </li> -->
                                    <!-- <a href="index.php?file=po_form/list">
                                        <button type="button"
                                            class="btn btn-danger waves-effect waves-light">Cancel</button></a> -->
                                    <?php }else if($update_unique_id != ''){?>
                                        <li><span class="btn btn-primary js-btn-next" title="NEXT"  class="btn btn-success waves-effect waves-light"
                                        onclick="po_form_cu()">Update &continue<i class="fa fa-arrow-right"></i></span>
                                            </li> 
                                         
                                    <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--single form panel-->


                            <div class="multisteps-form__panel" data-animation="slideVert" id="sec_tab">
                                <div class="inner pb-100">
                                    <!--<div class="wizard-topper">
                                        <div class="wizard-progress">
                                            <span>2 of 5 Completed</span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 45%;"></div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">
                                                <!-- <form class="was-validated" id="product_detail"> -->
                                                <div class="row">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Elcot
                                                                Item Code</label>
                                                                
                                                            <input type="text" id="item_code" name="item_code" 
                                                                class="form-control" value="<?php echo $item_code; ?>"
                                                                >
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Product</label>
                                                            <input type="text" id="po_name" name="po_name"
                                                                class="form-control" value="<?php echo $po_name; ?>"
                                                                >
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Qty</label>
                                                            <input type="text" id="qty" name="qty" class="form-control"
                                                                onkeypress="return isNumber(event)"
                                                                value="<?php echo $qty; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Unit
                                                                Price</label>
                                                            <input type="text" id="unit_price" name="unit_price"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                value="<?php echo $unit_price; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Tax</label>
                                                            <select class="form-select mb-3" id="tax" name="tax">
                                                                <?php echo $tax_select_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Total
                                                                Value</label>
                                                            <input type="text" id="total_value" name="total_value"
                                                                class="form-control" value="<?php echo $total_value; ?>"
                                                                 readonly>
                                                        </div>
                                                    </div>
                                                     <input type="hidden" name="stored_item" id="stored_item">
                                                        <input type="hidden" name="count_item" id="count_item">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Net
                                                                Value</label>
                                                            <input type="text" id="net_value" name="net_value"
                                                                class="form-control" value="<?php echo $net_value; ?>"
                                                                 readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php echo $no_of_po; ?>">-->
                                                            <button type="button"
                                                                class="btn btn-success btn-label product_details_add_update_btn"
                                                                onclick="product_details_add_update(),get_po_item()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>

                                                        </div>
                                                    </div><!-- end col -->
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
                                                                        class="table table-hover table-bordered align-middle table-nowrap mb-0 dataTable no-footer"
                                                                        width="100%" style="width: 100%;">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    ID </th>
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
                                                                                    Tax </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Total Value </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Net Value </th>
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Action </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                          
                                                                    <div id="product_details_datatable_processing"
                                                                        class="dataTables_processing card"
                                                                        style="display: none;">
                                                                        <!-- <i
                                                                    class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                                                    <span
                                                                    class="sr-only">Loading...</span> -->
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
                                      
                                         <div id="product_msg" ><p style="color:red;font_size:20px;">Kindly to create Product Details for No.Of.item Value based.</p></div>
                                     </div>
                                    </div>
                                   
                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                      
                                                <li><span title="NEXT"  class="btn btn-primary js-btn-next" id="product_data">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                                            
                                               
                                                            <!--  <li><span class="js-btn-next" title="NEXT" onclick="check_count()">NEXT <i
                                              class="fa fa-arrow-right"></i></span></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert" id="third_tab">
                                <div class="inner pb-100">
                                   <!-- <div class="wizard-topper">
                                        <div class="wizard-progress">
                                            <span>3 of 5 Completed</span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 65%;"></div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="tab">

                                                <div class="row">
                                                <!-- <input type="text" id="demo" name="demo" value="<?php echo $unique_id; ?>"> -->
                                            <input type="hidden" id="no_of_consignee" name="no_of_consignee"
                                                                class="form-control" value="<?php echo $no_of_consignee;?>">
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                Address</label>
                                                            <!--<input type="text" id="con_address" name="con_address"-->
                                                            <!--    class="form-control" value="" >-->
                                                              <textarea name="con_address" id="con_address" class="form-control"></textarea>
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                District</label>
                                                            <input type="text" id="con_district" name="con_district"
                                                                class="form-control" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                Pincode</label>
                                                            <input type="text" id="con_pincode" name="con_pincode"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                minlength="6" maxlength="6" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                Contact Name </label>
                                                            <input type="text" id="con_contact_name"
                                                                name="con_contact_name" class="form-control" onkeypress="validateCharacter(event)" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                Contact Number
                                                            </label>
                                                            <input type="text" id="con_contact_number"
                                                                name="consignee_number" class="form-control" value=""
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label for="main_screen" class="form-label">Consignee
                                                                Landline Number
                                                            </label>
                                                            <input type="text" id="con_lan_num" name="con_lan_num"
                                                                class="form-control" value=""
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10">
                                                        </div>
                                                    </div><!-- end col -->
                                                        <input type="hidden" name="count_consignee" id="count_consignee">
                                                        <input type="hidden" name="stored_consignee" id="stored_consignee">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <button type="button"
                                                                class="btn btn-success"
                                                                onclick="consignee_details_add_update(),get_stored_sublist_count()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2" ></i>
                                                                Add New</button>
                                                        </div>
                                                    </div><!-- end col -->
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
                                                                        class="table table-hover table-bordered align-middle table-nowrap mb-0 dataTable no-footer"
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
                                                                                    Consignee Address</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Consignee District</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Consignee Pincode</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Consignee Contact Name</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Contact Number </th>
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Action </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                           
                                                                        </tbody>
                                                                    </table>
                                                                    
                                                                    
                                                                    
                                                                    <div id="consignee_details_datatable_processing"
                                                                        class="dataTables_processing card"
                                                                        style="display: none;">
                                                                        <!-- <i
                                                                    class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span
                                                                    class="sr-only">Loading...</span> -->
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

                                            </div>
                                            <div id="consignee_msg"><p style="color:red;font_size:20px;">Kindly to create Consignee Details for No.Of.Consignee Value based.</p></div>
                                        </div>
                                    </div>

                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                        
                                        <li onclick="get_details()"><span  class="btn btn-primary js-btn-next" title="NEXT" id="consignee_btn" >NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                                             
                                <!-- get_tab_checking()" id="nxt" class="js-btn-next"-->
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert" id="tab_nxt">
                                <div class="inner pb-100">
                                    <!--<div class="wizard-topper">
                                        <div class="wizard-progress">
                                            <span>4 of 5 Completed</span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 85%;"></div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                     
                                           
                                            <div class="class="card-body" id="mytable">
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                <li><span  class="btn btn-primary js-btn-next" onclick="po_assign_add_update()" title="NEXT">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                                            <!--  -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert">
                                <div class="inner pb-100">
                                   <!-- <div class="wizard-topper">
                                        <div class="wizard-progress">
                                            <span>5 of 5 Completed</span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="wizard-content-form">
                                        <div class="wizard-form-field">
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">Delivery
                                                            Due
                                                            Days</label>
                                                        <input type="text" id="delivery_due_dates"
                                                            name="delivery_due_dates" class="form-control"
                                                            value="<?php echo $delivery_due_dates; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">LD%
                                                            Per
                                                            Day</label>
                                                        <input type="text" id="ld_per_day" name="ld_per_day"
                                                            class="form-control" value="<?php echo $ld_per_day; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">LD
                                                            Maximum
                                                            Value</label>
                                                        <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                            class="form-control" value="<?php echo $ld_maximum_val; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <input type="hidden" id="old_warranty" name="old_warranty"
                                                            value="<?php echo $warranty; ?>" />

                                                        <label for="main_screen" class="form-label">Warranty</label>
                                                        <?php 
                                        if($warranty == '1'){?>
                                                        <select class="form-select mb-3" id="warranty" name="warranty">
                                                            <option value="1" selected>
                                                                Yes
                                                            </option>
                                                            <option value="0">
                                                                No
                                                            </option>
                                                        </select>
                                                        <?php } else if($warranty == '0'){?>
                                                        <select class="form-select mb-3" id="warranty" name="warranty">
                                                            <option value="1">
                                                                Yes
                                                            </option>
                                                            <option value="0" selected>
                                                                No
                                                            </option>
                                                        </select>
                                                        <?php }else{?>
                                                        <select class="form-select mb-3" id="warranty" name="warranty">
                                                            <option value="1">
                                                                Yes
                                                            </option>
                                                            <option value="0">
                                                                No
                                                            </option>
                                                        </select>
                                                        <?php }?>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3" id="select_warranty">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">Warranty
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
                                                        <div class="form-group form-check  mt-3">
                                                            <?php
                                        if($exampleCheck1 == 'on'){?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="exampleCheck1" name="exampleCheck1" checked>

                                                            <?php }
                                        else{ ?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="exampleCheck1" name="exampleCheck1">
                                                            <?php }
                                        ?>

                                                            <label class="form-check-label" for="exampleCheck1">
                                                                Installation
                                                                Required
                                                            </label>
                                                        </div>
                                                        <div class="form-group form-check  mt-2">
                                                            <?php if($exampleCheck2 == 'on'){?>
                                                            <input type="checkbox" class="form-check-input bgcheckbox"
                                                                id="exampleCheck2" name="exampleCheck2" checked>
                                                            <?php }else{?>
                                                            <input type="checkbox" class="form-check-input bgcheckbox"
                                                                id="exampleCheck2" name="exampleCheck2"
                                                                onchange="valueChanged()">
                                                            <?php }?>
                                                            <label class="form-check-label" for="exampleCheck2">Bank
                                                                Gurantee
                                                                Required</label>
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                         <label for="main_screen" class="form-label">Attach PO Copy </label>

                                                    <input type="file" id="file" name="file" class="form-control "
                                                        value="<?php echo $file_org_name; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3 bgdiv" id="bgdiv">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">BG%</label>
                                                        <input type="text" id="bg" name="bg" class="form-control"
                                                            value="<?php echo $bg; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3 bgdiv1" id="bgdiv1">
                                                    <div class="mb-3">
                                                        <label for="main_screen" class="form-label">BG
                                                            MONTHS
                                                        </label>
                                                        <input type="text" id="bg_month" name="bg_month"
                                                            class="form-control" value="<?php echo $bg_month; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                <!-- <li><button type="submit" id="submit-form" title="NEXT">SUMBIT
                                                        <i class="fa fa-arrow-right"></i></button></li> -->
                                                        <?php if($update_unique_id ==''){?>
                                                <!-- <li><span class="btn btn-primary" title="NEXT">NEXT <i -->
                                                    <!-- class="fa fa-arrow-right"></i></span></li>  -->
                                              <li><span class="btn btn-success js-btn-next" title="NEXT"onclick="term_condition();"
                                        > Save <i class="fa fa-arrow-right"></i></span>
                                        <?php } else if($update_unique_id !=''){?>
                                      
                                                <!-- <li><span class="btn btn-primary js-btn-next" title="NEXT">NEXT <i -->
                                                    <!-- class="fa fa-arrow-right"></i></span></li>  -->
                                              <li><span class="btn btn-primary" title="NEXT"onclick="term_condition();"
                                        >Update<i class="fa fa-arrow-right"></i></span>
                                        <?php }?>
                                            </li> 
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--  las tab-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
<!-- <script src="https://jthemes.net/themes/html/wizard-form/v2/assets/js/main.js"></script> -->
	<script src="assets/js/main.js"></script>
<script>
$("#files").change(function() {
    filename = this.files[0].name
    console.log(filename);
});
</script>
<script>
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

$(document).ready(function() {

<!--product tab btn enable or disable fun-->
get_product_sublist_count();
get_po_item();
<!--product tab end and start consignee-->
get_stored_sublist_count();
get_consignee();




 var uni_id=document.getElementById('demo').value;
 var val1 = document.getElementById('old_gst_option').value;
 var unregistered_message = document.getElementById('unregistered_message');
    
    if (val1 == 'no') {
        $("#gst_num").hide();
         $("#unregistered_message").show();
        
       
       } else {
        $("#gst_num").show();
        $("#unregistered_message").hide();
   
       
       
    }

    $('#gst_option').on('change', function() {
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

    // warranty option
    var warranty = document.getElementById('old_warranty').value;
    if (warranty == 'no') {
        $("#select_warranty").hide();
    } else {
        $("#select_warranty").show();
    }

    $('#warranty').on('change', function() {
        if (this.value == '1') {
            $("#select_warranty").show();
            document.getElementById('old_warranty').value = '1';
        } else {
            $("#select_warranty").hide();
            document.getElementById('old_warranty').value = '0';
        }
    });

    // total and net value calculation
    $('#tax').on('change', function() {
        var qty = document.getElementById('qty').value;
        var unit_price = document.getElementById('unit_price').value;
        if (this.value == '18') {
            const net_value = qty * unit_price;
            const percentage_value = net_value * (18 / 100);
            const total_value = net_value + percentage_value;

            document.getElementById('net_value').value = net_value;

            document.getElementById('total_value').value = total_value;
        } else if (this.value == '28') {
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

    // total and net value calculation
    $('#unit_price').on('change', function() {
        var qty = document.getElementById('qty').value;
        var unit_price = document.getElementById('unit_price').value;

        const net_value = qty * unit_price;
        const total_value = net_value;
        document.getElementById('net_value').value = net_value;
        document.getElementById('total_value').value = total_value;

    });
    var unique_id = $('#unique_id').val();
    // alert(unique_id);
    if (unique_id) {
        document.getElementById('m_unique_id').value = '';
    }
    sub_list_datatable(product_details_tableid);
    sub_list_datatable(consignee_details_tableid);

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
    // alert(unique_id);
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
// function next() {
//     $(tabs[current]).addClass("d-none");

//     $(tabs_pill[current]).removeClass("active");F
//     current++;
//     loadFormData(current);

// }

function get_details(){

var unique_id = document.getElementById('demo').value;

data = "unique_id=" + unique_id + "&action=get_assign_qty_record";
var ajax_url = sessionStorage.getItem("folder_crud_link");
$.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
       
        success: function(data) {
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
    // var staff_unique_id = $("#staff_unique_id").val();

    // if (!internet_status) {
    //     sweetalert("no_internet");
    //     return false;
    // }
                var form_class = "product_detail";
                var is_form = form_validity_check(form_class);
    // var is_form = form_validity_check("product_details_form");

    // console.log(is_form);
    var no_of_po = document.getElementById('no_of_po').value;

    var item_code = document.getElementById('item_code').value;
    var po_name = document.getElementById('po_name').value;

    var qty = document.getElementById('qty').value;
    var unit_price = document.getElementById('unit_price').value;
    var tax = document.getElementById('tax').value;
    var total_value = document.getElementById('total_value').value;
    var net_value = document.getElementById('net_value').value;

    var form_main_unique_id = document.getElementById('form_main_unique_id').value;

    // if (is_form) {

    // var data = $(".product_details_form").serialize();
    var data = "no_of_po=" + no_of_po + "&item_code=" + item_code + "&po_name=" + po_name + "&qty=" + qty + "&unit_price=" + unit_price +
        "&tax=" + tax + "&total_value=" + total_value + "&net_value=" + net_value + "&form_main_unique_id=" +
        form_main_unique_id;
    data += "&unique_id=" + unique_id + "&action=product_details_add_update";

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    // var url      = sessionStorage.getItem("list_link");
    var url = "";

    // console.log(data);
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        beforeSend: function() {
            $(".product_details_add_update_btn").attr("disabled", "disabled");
            $(".product_details_add_update_btn").text("Loading...");
        },
        success: function(data) {

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
                
                // Init Datatable
                sub_list_datatable("product_details_datatable");
            }
            document.getElementById('item_code').value = '';
            document.getElementById('po_name').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('unit_price').value = '';
            document.getElementById('total_value').value = '';
            document.getElementById('net_value').value = '';
            
              var div_contents =document.getElementById("div1");
                var elements = div_contents.getElementsByTagName("select");
            var elements = getElementById("tax");
              for (i=0; i<elements.length; i++) {
                elements[i].selectedIndex = -1; 
              }
            sweetalert(msg, url);
        },
        error: function(data) {
            alert("Network Error");
        }
    });

    // } else {
    //     sweetalert("form_alert");
    // }
}

// consignee sub crud
function consignee_details_add_update(unique_id = "") { // au = add,update
    
    var internet_status = is_online();

    // var staff_unique_id = $("#staff_unique_id").val();

    // if (!internet_status) {
    //     sweetalert("no_internet");
    //     return false;
    // }
    var is_form = form_validity_check("consignee_details_form");
    // var no_of_consignee = document.getElementById('no_of_consignee').value;

    // console.log(is_form);

    var no_of_consignee = document.getElementById('no_of_consignee').value;
    // var con_qty = document.getElementById('con_qty').value;

    var con_address = document.getElementById('con_address').value;
    var con_district = document.getElementById('con_district').value;
    var con_pincode = document.getElementById('con_pincode').value;
    var con_contact_name = document.getElementById('con_contact_name').value;
    var con_contact_number = document.getElementById('con_contact_number').value;
    var con_lan_num = document.getElementById('con_lan_num').value;

    var form_main_unique_id = document.getElementById('demo').value;

    // if (is_form) {

    // var data = $(".product_details_form").serialize();"&con_qty=" + con_qty +no_of_consignee=" + no_of_consignee + 
    var data = "no_of_consignee=" + no_of_consignee + "&con_address=" + con_address +
        "&con_district=" + con_district +
        "&con_pincode=" + con_pincode + "&con_contact_name=" + con_contact_name + "&con_contact_number=" +
        con_contact_number + "&con_lan_num=" + con_lan_num + "&form_main_unique_id=" +
        form_main_unique_id;
    data += "&unique_id=" + unique_id + "&action=consignee_details_add_update";

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    // var url      = sessionStorage.getItem("list_link");
    var url = "";

    // console.log(data);
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        beforeSend: function() {
            $(".consignee_details_add_update_btn").attr("disabled", "disabled");
            $(".consignee_details_add_update_btn").text("Loading...");
        },
        success: function(data) {

            var obj = JSON.parse(data);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;
            
            if (!status) {
                $(".consignee_details_add_update_btn").text("Error");
                console.log(error);
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
                sub_list_datatable("consignee_details_datatable");
            document.getElementById('con_address').value = '';
            document.getElementById('con_district').value = '';
            document.getElementById('con_pincode').value = '';
            document.getElementById('con_contact_name').value = '';
            document.getElementById('con_contact_number').value = '';
            document.getElementById('con_lan_num').value = '';
            }
            sweetalert(msg, url);
        },
        error: function(data) {
            alert("Network Error");
        }
    });
    // } else {
    //     sweetalert("form_alert");
    // }
}

function sub_list_datatable(table_id = "", form_name = "", action = "") {
    var form_main_unique_id = $("#demo").val();

    var table = $("#" + table_id);
    var data = {
        "form_main_unique_id": form_main_unique_id,
        "action": table_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
        "searching": false,
        "paging": false,
        "ordering": false,
        "info": false,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        }
    });
}

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
                        success: function(data) {

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

                } else {
                    // alert("cancel");
                }
            });
    }
}

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
                        success: function(data) {

                            var obj = JSON.parse(data);
                            var msg = obj.msg;
                            var status = obj.status;
                            var error = obj.error;

                            if (!status) {
                                url = '';
                            } else {
                                sub_list_datatable("consignee_details_datatable");
                            }
                            sweetalert(msg, url);
                        }
                    });

                } else {
                    // alert("cancel");
                }
            });
    }
}

// consignee sub crud
function po_assign_add_update(unique_id = "") {
    
    var internet_status = is_online();
    var demo= document.getElementById('demo').value;
    
    var bill_qty = document.getElementsByName('bill_qty[]');


    for (var i = 0; i < bill_qty.length; i++) {
        var bill_qty_val = bill_qty[i].value;


        if (bill_qty_val != '') {
        
            var qty_val = bill_qty[i].value;
            var item_code = document.getElementsByName('item_code[]');
            var item_name = document.getElementsByName('item_name[]');
            var unit_price = document.getElementsByName('unit_price[]');
            var tax = document.getElementsByName('tax[]');
            var qty = document.getElementsByName('qty[]');


            var con_unique_id = document.getElementsByName('con_unique_id[]');
            var con_name = document.getElementsByName('con_name[]');
            var con_contact_no = document.getElementsByName('con_contact_no[]');
            var product_unique_id = document.getElementsByName('product_unique_id[]');

            var item_code_val = item_code[i].value;
            var item_name_val = item_name[i].value;
            var item_unit_price = unit_price[i].value;
            var item_tax = tax[i].value;
            var qty = qty[i].value;


            var con_unique_id_val = con_unique_id[i].value;
            var con_name_val = con_name[i].value;
            var con_contact_no_val = con_contact_no[i].value;
            var product_unique_id_val = product_unique_id[i].value;

            // var product_unique_id= document.getElementById('product_unique_id').value;
            var main_unique_id = document.getElementById('main_unique_id').value;
            var po_unique_id = document.getElementById('po_unique_id').value;

            
            var data = "main_unique_id=" + main_unique_id + "&con_unique_id=" + con_unique_id_val +
                "&con_name=" + con_name_val + "&con_contact_no=" + con_contact_no_val + "&item_code=" + item_code_val +
                "&item_name=" +
                item_name_val + "&bill_qty=" + qty_val + "&unit_price=" + item_unit_price + "&item_tax=" + item_tax +
                "&po_unique_id=" + po_unique_id + "&product_unique_id_val=" + product_unique_id_val + "&qty=" + qty;

            data += "&unique_id=" + unique_id + "&action=po_delivery_add_update";

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            // var url = "";

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                    $(".po_delivery_add_update_btn").text("Loading...");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    // alert(msg);
                    if (!status) {
                        $(".po_delivery_add_update_btn").text("Error");
                        // console.log(error);
                    } else {
                        if (msg == "already") {
                            // sweetalert(msg, url);
                            form_reset("po_delivery_form");
                        }
                        $(".po_delivery_add_update_btn").removeAttr("disabled", "disabled");
                        if (unique_id && msg == "already") {
                            $(".po_delivery_add_update_btn").text("Update");
                        } else {
                            $(".po_delivery_add_update_btn").text("Add");
                            $(".po_delivery_add_update_btn").attr("onclick",
                                "po_delivery_add_update('')");
                        }
                        // location.reload();
                        // Init Datatable
                        sub_list_datatable("po_delivery_datatable");
                    }

                    sweetalert(msg);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        }
        <!--}-->
    }
    }

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


    function validateCharacter(event) {
            // Get the pressed key code
            const keyCode = event.which || event.keyCode;

            // Check if the pressed key is a character (a-z, A-Z)
            if ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)) {
                // Valid character, allow input
                document.getElementById('charValidationMessage').textContent = '';
            } else {
                // Invalid character, prevent input and display a message
                event.preventDefault();
                document.getElementById('charValidationMessage').textContent = 'Only characters are allowed.';
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


function get_qty(){
    

	   var qty = document.getElementsByName('qty[]');
	   
	    var bill_qty = document.getElementsByName('bill_qty[]');
	    
        var max_limit = document.getElementsByName('max_limit[]');

	     // Get the validation message element
	     
        const validationMessage = document.getElementById('max_limit');
        

    for (var i = 0;i < bill_qty.length; i++) {
        var bill_qty_val = bill_qty[i].value;
                var qty_val = qty[i].value;
       
        var max_limit_val = max_limit[i];
    
    <!--alert(qty_val);-->
    <!--alert(bill_qty_val);-->
    <!--alert(max_limit_val);-->
    var re_qty_value = qty_val - bill_qty_val;
    <!--alert(re_qty_value);-->
        if(bill_qty_val == ''){
    		<!--alert('hello');-->
    		<!--$('#max_limit').append("Maximum Value : Unlimited "+ qty_val);-->
    	max_limit_val.textContent=("Maximum Value : limit "+ qty_val);
    	
    	}
    	else if(parseInt(qty_val) < parseInt(bill_qty_val)){
    		<!--alert('hi');-->
    		<!--$('#max_limit').append("Maximum qty Limit Exceed!" "+ qty_val);-->
    	max_limit_val.textContent=("Maximum Qty Limit Exceed! "+qty_val);
    
    	}
    	else{
    		<!--$('#max_limit').append();-->
    		$('#max_limit').empty();
    		max_limit_val.textContent = '';
    	}
	}
}
<!--get consignee count  -->

function get_stored_sublist_count(){

var uni_id=document.getElementById('demo').value;
<!--alert(uni_id);-->
    var data = "uni_id=" + uni_id + "&action=check_consignee";
 <!--var data = "consignee=" + consignee + "&action=check_consignee";-->
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    <!--alert(obj.data[0]);-->
                    
                     document.getElementById('stored_consignee').value = obj.data[0];
                     get_consignee();
                }
            });
}

function get_consignee(){

var uni_id=document.getElementById('demo').value;

    var data = "uni_id=" + uni_id + "&action=no_of_consignee";
 <!--var data = "consignee=" + consignee + "&action=check_consignee";-->
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    <!--alert(obj.data[0]);-->
                    
                     document.getElementById('count_consignee').value = obj.data[0];
                     get_stored_sublist_count();
                     get_tab_checking();

                }
            });
            
}

function get_tab_checking(){

var x = document.getElementById('stored_consignee').value;
var y = document.getElementById('count_consignee').value;
if(x != y){
<!--alert('test');-->
$('#consignee_btn').hide();
$('#consignee_msg').show(); 

}else{
$('#consignee_btn').show(); 
$('#consignee_msg').hide(); 


}
}


<!--Product sublist start-->

<!--get consignee count  -->



function get_product_sublist_count(){

var uni_id=document.getElementById('demo').value;
<!--alert(uni_id);-->
    var data = "uni_id=" + uni_id + "&action=check_product";
 <!--var data = "consignee=" + consignee + "&action=check_consignee";-->
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    <!--alert(obj.data[0]);-->
                    
                     document.getElementById('stored_item').value = obj.data[0];
                     get_po_item();
                }
            });
}

function get_po_item(){

var uni_id=document.getElementById('demo').value;

    var data = "uni_id=" + uni_id + "&action=no_of_item";
 <!--var data = "consignee=" + consignee + "&action=check_consignee";-->
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    <!--alert(obj.data[0]);-->
                    
                     document.getElementById('count_item').value = obj.data[0];
                    
                     get_producttab_checking();
 get_product_sublist_count();
                }
            });
            
}

function get_producttab_checking(){

var x = document.getElementById('stored_item').value;
var y = document.getElementById('count_item').value;
if(x != y){
$('#product_data').hide();
$('#product_msg').show(); 

}else{
$('#product_data').show(); 
$('#product_msg').hide(); 

}
}

<!--product end-->
</script>
