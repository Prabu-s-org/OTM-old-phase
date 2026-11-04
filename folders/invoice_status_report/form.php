
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

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #1A7DB7;
    color: white;
}
.red-star {
    color: red;
    font-size: 30px;
    vertical-align: middle;
    margin-left: 5px;
  }

/* 
.alert>.start-icon {
    margin-right: 0;
    min-width: 20px;
    text-align: center;
}

.alert>.start-icon {
    margin-right: 5px;
}

.alert-simple.alert-info
{
  border: 1px solid rgba(6, 44, 241, 0.46);
    background-color: rgba(7, 73, 149, 0.12156862745098039);
    box-shadow: 0px 0px 2px #0396ff;
    color: #0396ff;
  text-shadow: 2px 1px #00040a;
  transition:0.5s;
  cursor:pointer;
}

.alert-simple.alert-warning
{
      border: 1px solid rgba(241, 142, 6, 0.81);
    background-color: rgba(220, 128, 1, 0.16);
    box-shadow: 0px 0px 2px #ffb103;
    color: #ffb103;
    /* text-shadow: 2px 1px #00040a; */
  /* transition:0.5s;
  cursor:pointer;
} */
.alert-simple.alert-danger
{
  border: 1px solid rgba(241, 6, 6, 0.81);
    background-color: rgba(220, 17, 1, 0.16);
    box-shadow: 0px 0px 2px #ff0303;
    color: #ff0303;
    /* text-shadow: 2px 1px #00040a; */
  transition:0.5s;
  cursor:pointer;
}

.alert-danger:hover
{
     background-color: rgba(220, 17, 1, 0.33);
  transition:0.5s;
}
/* 
.danger
{
      font-size: 18px;
    color: #ff0303;
    text-shadow: none;
} */ */

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

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        // $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $_GET["unique_id"]
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
            "ins_reqired",
            "bank_required",
            "dc_required",
            "bg",
            "bg_month",
            "file_name",
            "file_org_name",
            "unique_id",
            "no_of_consignee",
            "is_active",
            
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
            $contact_landline_num   = $result_values[0]["contact_landline_num"];
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
            $ins_reqired          = $result_values[0]["ins_reqired"];
            $bank_required          = $result_values[0]["bank_required"];
            $dc_required          = $result_values[0]["dc_required"];
            $bg    = $result_values[0]["bg"];
            $file_org_name    = $result_values[0]["file_org_name"];
            $bg_month          = $result_values[0]["bg_month"];
            $no_of_consignee          = $result_values[0]["no_of_consignee"];
           $update_unique_id    = $result_values[0]["unique_id"];
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

if($_GET["unique_id"] != ''){
    $unique_id =$_GET["unique_id"];
}else{
    $prefix    = "PO";
    $unique_id = unique_id($prefix);
    
}
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$tax_select_options       = 
[
    "" => [
        "unique_id" => "",
        "value"     => "Select Option",
            ],
    "18%" => [
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

$tax_select_options        = select_option($tax_select_options);

$active_status_options   = active_status($is_active);

$executive_name_options = executive_name();
$executive_name_options = select_option($executive_name_options, "Select Executive", $executive_name);

$district_options = district_name();
$district_options = select_option($district_options, "Select District", $district);

$warranty_options = warranty_name();
$warranty_options = select_option($warranty_options, "Select Warranty", $warranty_duration);

$po_type_options = po_type_option();
$po_type_options = select_option($po_type_options, "Select Po Type", $po_type);

$department_options = department_creation_table();
$department_options = select_option($department_options, "Select Department",  $department);

$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

$tender_code_options = tender_name($tender_code);
$tender_code_options = select_option1($tender_code_options, "Select Tender", $tender);

$item_code_options = item_name($item_code);
$item_code_options = select_option($item_code_options, "Select Item Code", $item);



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
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">PO
                                                                Number</label>
                                                            <input type="text" id="po_num" name="po_num"
                                                                class="form-control" onchange="get_po_no();"
                                                                value="<?php if($po_num !=''){ echo  $po_num;}?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">PO
                                                                Date</label>
                                                            <input type="date" id="po_date" name="po_date"
                                                                class="form-control" value="<?php echo $po_date; ?>"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                        <label class="form-label">Department</label>
                                        
                                                             <select class="select2 form-control" id="department"  name="department" required> 
                                                             <?php echo $department_options;?>
                                                             </select>
                                                        </div>
                                                    </div>
                                                   
								                <div class="col-xl-3" align="right">
                                                        <div class="mb-3" id="modal">
                                                        <!-- <button type="button" class="btn btn-primary"> -->
                            							<a data-bs-toggle="modal"  data-bs-target=".bs-example-modal-xl">
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
                                                            if($gst_option == 'yes'){?>
                                                            <select class="form-select mb-3" id="gst_option"
                                                                name="gst_option" required>
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
                                                                <option value="yes" >Yes</option>
                                                                <option value="no">No</option>
                                                        
                                                            </select>
                                                            <?php } ?>
 
                                                        </div>
                                                          
                                                    <span id="unregistered_message">GST  Unregistered </span>

                                                    </div>
                                                  
                                                    <div class="col-xl-3" id="gst_num">
                                                        <div class="mb-3">
                                                            <label class="form-label">Customer
                                                                GST
                                                                Number</label>
                                                            <input type="text" id="gst_value" name="gst_value"
                                                                minlength="15" maxlength="15" class="form-control"
                                                                value="<?php echo $gst_value; ?>" required>

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">Excutive
                                                                Name</label>
                                                            <select class="form-select mb-3" id="executive_name"
                                                                name="executive_name" required>
                                                                <?php echo $executive_name_options; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">Billing
                                                                Address</label>
                                                            <textarea  id="bill_address" name="bill_address"  class="form-control" required><?php echo $bill_address; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact
                                                                Name</label>
                                                            <input type="text" id="contact_name" name="contact_name"
                                                                class="form-control" 
                                                                value="<?php echo $contact_name; ?>" >

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact
                                                                Number</label>
                                                            <input type="text" id="contact_number" name="contact_number"
                                                                class="form-control"
                                                                value="<?php echo $contact_number; ?>"
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10" >

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Landline
                                                                Number</label>
                                                            <input type="text" id="contact_landline_num" name="contact_landline_num"
                                                                class="form-control"
                                                                value="<?php echo $contact_landline_num; ?>"
                                                                onkeypress="return isNumber(event)" >

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="text" id="email" name="email" onkeypress="validateEmail(event)"
                                                                class="form-control" value="<?php echo $email; ?>"
                                                                >
                                                                <span id="emailValidationMessage"></span>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label" >District</label>
                                                            <!--  
                                                        class="form-select mb-3"-->
                                                            <select class="select form-control" id="district" 
                                                                name="district" required >
                                                                <?php echo $district_options; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">Pin
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
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">PO
                                                                Prepared by
                                                            </label>
                                                            <input type="text" id="po_prepared_by" name="po_prepared_by"
                                                                class="form-control" 
                                                                value="<?php echo $po_prepared_by; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label"> PO Type
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
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">No of
                                                                Items in PO
                                                            </label>
                                                            <input type="text" id="no_of_po" name="no_of_po"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                maxlength="3" value="<?php echo $no_of_po; ?>" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                        <span class="red-star">*</span>
                                                            <label class="form-label">No of
                                                                Consignee</label>
                                                            <input type="text" id="no_of_consignee"
                                                                name="no_of_consignee" class="form-control"
                                                                onkeypress="return isNumber(event)" maxlength="5"
                                                                value="<?php echo $no_of_consignee; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                            <?php if($update_unique_id ==''){ ?>
                                              <li onclick="po_form_cu()"><span class="btn btn-primary js-btn-next"  title="NEXT" 
                                        >Save & Continue <i class="fa fa-arrow-right"></i></span>
                                            </li> 
                                    <?php } else if($update_unique_id != ''){ ?>
                                        <li onclick="po_form_cu()"><span class="btn btn-primary js-btn-next" title="NEXT" class="btn btn-success waves-effect waves-light"
                                        >Update &continue<i class="fa fa-arrow-right"></i></span>
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
                                                                <!-- <input type="text" id="tender_code" name="tender_code" 
                                                                class="form-control" value="<?php echo $tender_code; ?>"> -->
                                                                <select name="tender_code" id="tender_code" class="select2 form-control select2_op"  required>
                                                        <?php echo $tender_code_options; ?></select>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Elcot
                                                                Item Code</label>
<!--                                                                 
                                                            <input type="text" id="item_code" name="item_code" 
                                                                class="form-control" value="<?php echo $item_code; ?>"
                                                                > -->
                                                                <select name="item_code" id="item_code" class="select2 form-control select2_op" required onchange="item_detail(this.value)">
                                            <!-- <?php echo $item_code_options; ?> -->
                                        </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Product</label>
                                                            <input type="text" id="po_name" name="po_name"
                                                                class="form-control" value="<?php echo $product; ?>"
                                                                required >
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Qty</label>
                                                            <input type="text" id="qty" name="qty" class="form-control"
                                                                onkeypress="return isNumber(event)"
                                                                value="<?php echo $qty; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Unit
                                                                Price</label>
                                                            <input type="text" id="unit_price" name="unit_price"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                value="<?php echo $unit_price; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tax</label>
                                                            <select class="form-select mb-3" id="tax" name="tax">
                                                                <?php echo $tax_select_options; ?>
                                                            </select>
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
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <label class="form-label">Total
                                                                With Tax</label>
                                                            <input type="text" id="total_value" name="total_value"
                                                                class="form-control" value="<?php echo $total_value; ?>"
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
                                                            value="<?php echo $delivery_due_dates; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">LD%
                                                            Per
                                                            Day</label>
                                                        <input type="text" id="ld_per_day" name="ld_per_day"
                                                            class="form-control" value="<?php echo $ld_per_day; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">LD
                                                            Maximum
                                                            %</label>
                                                        <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                            class="form-control" value="<?php echo $ld_maximum_val; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <input type="hidden" id="old_warranty" name="old_warranty"
                                                            value="<?php echo $warranty; ?>" />

                                                        <label class="form-label">Warranty</label>
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
                                                        <label class="form-label">Warranty
                                                            Duration</label>
                                                        <select class="form-select mb-3" id="warranty_duration"
                                                            name="warranty_duration"
                                                            value="<?php echo $warranty_duration; ?>">
                                                            <?php echo $warranty_options; ?>
                                                        </select>
                                                    </div>
                                                </div>
 





                                                     <input type="hidden" name="stored_item" id="stored_item">
                                                        <input type="hidden" name="count_item" id="count_item">
                                                    
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php echo $no_of_po; ?>">-->
                                                            <button type="button" id="pro_details"
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
                                                                                    Tax </th>
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
                                                                                    Action </th>
                                                                            </tr>
                
                                                                        </thead>

                                                                        <tbody>
                                                                        <!-- <td>sum</td> -->
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

                                         <div id="product_msg" ><p style="color:red;font_size:20px;">Maximum No.Of.Product : <span id="no_of_pro_item"></span></p></div>
                                     </div>
                                    </div>
                                   
                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                      
                                                <li id="product_data" ><span title="NEXT"  class="btn btn-primary js-btn-next" >NEXT <i
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
                                            <div class="tab" >

                                                <div class="row">
                                                <!-- <input type="text" id="demo" name="demo" value="<?php echo $unique_id; ?>"> -->
                                            <input type="hidden" id="no_of_consignee" name="no_of_consignee"
                                                                class="form-control" value="<?php echo $no_of_consignee;?>">
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                Address</label>
                                                            <!--<input type="text" id="con_address" name="con_address"-->
                                                            <!--    class="form-control" value="" >-->
                                                              <textarea name="con_address" id="con_address" class="form-control" required></textarea>
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3" id="d1">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                District</label>
                                                            <!-- <input type="hidden" id="con_district1" name="con_district1"
                                                                class="form-control" value=""> -->
                                <select name="con_district" id="con_district" class="select2 form-control" required>
                                            <?php echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3"  id="d2" style="display:none;">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                District</label>
                                                            <!-- <input type="hidden" id="con_district1" name="con_district1"
                                                                class="form-control" value=""> -->
                                <select name="con_district" id="con_district" class="select2 form-control" required >
                                            <?php echo $consignee_district_options; ?></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                Pincode</label>
                                                            <input type="text" id="con_pincode" name="con_pincode"
                                                                class="form-control" onkeypress="return isNumber(event)"
                                                                minlength="6" maxlength="6" value="<?php echo $con_pincode ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                Contact Name </label>
                                                            <input type="text" id="con_contact_name"
                                                                name="con_contact_name" class="form-control" value="<?php echo $con_contact_name ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                Contact Number
                                                            </label>
                                                            <input type="text" id="con_contact_number"
                                                                name="consignee_number" class="form-control"
                                                                onkeypress="return isNumber(event)" minlength="10"
                                                                maxlength="10" value="<?php echo $con_contact_number ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Consignee
                                                                Landline Number
                                                            </label>
                                                            <input type="tel" id="con_lan_num" name="con_lan_num"
                                                                class="form-control"  value="<?php echo $con_lan_num ?>">

                                                                <!--pattern="[0-9]{4}-[0-9]{7}"  -->
                                                               
                                                        </div>
                                                    </div><!-- end col -->
                                                        <input type="hidden" name="count_consignee" id="count_consignee">
                                                        <input type="hidden" name="stored_consignee" id="stored_consignee">
                                                    <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <button type="button"
                                                                class="btn btn-success consignee_details_add_update_btn"
                                                                onclick="consignee_details_add_update(),get_stored_sublist_count()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2" ></i>
                                                                Add New</button>
                                                        </div>
                                                        <div class="col-xl-3">
                                                            <div class="mb-3">
                                                                <div class="btn-header">
                                                                        <a href="javascript:excel_popup()"><button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-1 mt-1"><i class="ri-file-excel-2-fill"></i> &nbsp;Import </button></a>
                                                                </div>
                                                                
                                                            </div>
                                                            
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
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Landline Number </th>
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
                                            <div id="consignee_msg"><p style="color:red;font_size:20px;"> Maximum No.Of.Consignee : <span id="no_of_po_con"></span></p></div>
                                        </div>
                                    </div>

                                    <div class="wizard-footer">

                                        <div class="actions">
                                            <ul>
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                        
                                        <li id="consignee_btn"  onclick="get_details()"><span  class="btn btn-primary js-btn-next" title="NEXT" >NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                                             
                                <!-- get_tab_checking()" id="nxt" class="js-btn-next"-->
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <?php include 'import.php'; ?>
                            </div>
                            <!--single form panel-->
                            <div class="multisteps-form__panel" data-animation="slideVert" id="tab_nxt" id="mytabs" style="background: white;">
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
                                     
                                   <input type="hidden" name="return_qty" id="return_qty">
                                     <!-- <input type="text" name="re_bill_qty" id="re_bill_qty"> -->
                                    <!-- <div class="col-sm-12">
                                        <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                        <button type="button" class="close font__size-18" data-dismiss="alert">
                                            <span aria-hidden="true">
                                                <i class="fa fa-times danger "></i>
                                            </span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                                        <strong class="font__weight-semibold">Oh snap!</strong> Change a few things up and try submitting again.
                                        </div>
                                    </div> -->
                                            <div class="card-body" id="mytable">
                                                
                                                <input type="hidden" name="demoinpt" id="demoinpt">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <span id="get_qty_msg"></span>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="actions">
                                            <ul>
                                                
                                                <li><span class="btn btn-primary js-btn-prev" title="BACK"><i
                                                            class="fa fa-arrow-left"></i>
                                                        BACK</span></li>
                                                        
                                                        <!-- onclick="po_assign_add_update()" 
                                                         onclick="check_qty()"-->
                                                <li onclick="check_qty()" ><span  class="btn btn-primary js-btn-next" id="mynxt" title="NEXT">NEXT <i
                                                            class="fa fa-arrow-right"></i></span></li>
                                                            <!--  -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        

                            <!-- </div> -->
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
                                                <!-- <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Delivery
                                                            Due
                                                            Days</label>
                                                        <input type="text" id="delivery_due_dates"
                                                            name="delivery_due_dates" class="form-control"
                                                            value="<?php echo $delivery_due_dates; ?>">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">LD%
                                                            Per
                                                            Day</label>
                                                        <input type="text" id="ld_per_day" name="ld_per_day"
                                                            class="form-control" value="<?php echo $ld_per_day; ?>">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">LD
                                                            Maximum
                                                            %</label>
                                                        <input type="text" id="ld_maximum_val" name="ld_maximum_val"
                                                            class="form-control" value="<?php echo $ld_maximum_val; ?>">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <input type="hidden" id="old_warranty" name="old_warranty"
                                                            value="<?php echo $warranty; ?>" />

                                                        <label class="form-label">Warranty</label>
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
                                                </div> -->
                                                <!-- <div class="col-xl-3" id="select_warranty">
                                                    <div class="mb-3">
                                                        <label class="form-label">Warranty
                                                            Duration</label>
                                                        <select class="form-select mb-3" id="warranty_duration"
                                                            name="warranty_duration"
                                                            value="<?php echo $warranty_duration; ?>">
                                                            <?php echo $warranty_options; ?>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                        <div class="form-group form-check  mt-3">
                                                            <?php
                                        if($ins_reqired == 'on'){?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="ins_reqired" name="ins_reqired" checked onchange="toggleDcRequired()">

                                                            <?php }
                                        else{ ?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="ins_reqired" name="ins_reqired" onchange="toggleDcRequired()">
                                                            <?php }
                                        ?>

                                                            <label class="form-check-label" >
                                                                Installation
                                                                Required
                                                            </label>
                                                        </div>
                                                        <div class="form-group form-check  mt-2">
                                                            <?php if($bank_required == 'on'){?>
                                                            <input type="checkbox" class="form-check-input bgcheckbox"
                                                                id="bank_required" name="bank_required" checked>
                                                            <?php }else{?>
                                                            <input type="checkbox" class="form-check-input bgcheckbox"
                                                                id="bank_required" name="bank_required"
                                                                onchange="valueChanged()">
                                                            <?php }?>
                                                            <label class="form-check-label" >Bank
                                                                Gurantee
                                                                Required</label>
                                                        </div>
                                                        <div class="form-group form-check  mt-2">
                                                        <?php

                                                              if($dc_required == 'on'){?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="dc_required" name="dc_required" checked onchange="toggleInsRequired()">

                                                            <?php }
                                                                     else{ ?>
                                                            <input type="checkbox" class="form-check-input"
                                                                id="dc_required" name="dc_required" onchange="toggleInsRequired()">
                                                            <?php }
                                                             ?>

                                                            <label class="form-check-label" >
                                                                DC Only Required
                                                                </label>
                                                        </div>

                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3">
                                                    <div class="mb-3">
                                                         <label class="form-label">Attach PO Copy </label>

                                                    <input type="file" id="po_file" accept="application/pdf" name="po_file" class="form-control " 
                                                        value="<?php echo $file_org_name; ?>" >
                                                        
                                                    </div>
                                                    <input type="hidden" name="mypo" id="mypo" value="<?php if($po_num !=''){ echo  $po_num;}?>">
                                                </div><!-- end col -->
                                                <div class="col-xl-3 bgdiv" id="bgdiv">
                                                    <div class="mb-3">
                                                        <label class="form-label">BG%</label>
                                                        <input type="text" id="bg" name="bg" class="form-control"
                                                            value="<?php echo $bg; ?>">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-xl-3 bgdiv1" id="bgdiv1">
                                                    <div class="mb-3">
                                                        <label class="form-label">BG
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
                                              <li onclick="term_condition();"><span class="btn btn-success js-btn-next" title="NEXT" 
                                        > Save <i class="fa fa-arrow-right"></i></span>
                                        <?php } else if($update_unique_id !=''){?>
                                      
                                                <!-- <li><span class="btn btn-primary js-btn-next" title="NEXT">NEXT <i -->
                                                    <!-- class="fa fa-arrow-right"></i></span></li>  -->
                                              <li onclick="term_condition();"><span class="btn btn-primary js-btn-next" title="NEXT"
                                        >Update<i class="fa fa-arrow-right"></i></span>
                                        <?php }?>
                                            </li> 
                                            </ul>
                                        </div>
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
                                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Department Creation</h5><hr/>
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
                        <input type="text" class="form-control" id="department_txt" name="department_txt" required>
                        </div>
                    </div>
                </div>

                <div class="col-4 head_po">
                    <div class="row">
                        <div class="col-xl-12 head_po">
                             <label class="form-label">Active Status</label>
                                    <select name="is_active1" id="is_active1" class="select2 form-control" required>
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
                                <a href="javascript:void(0);" class="btn btn-danger"
                                    data-bs-dismiss="modal">
                                    Close</a>
                                <button type="button" class="btn btn-primary " onclick="department_create()">Save</button>
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


<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>

	<script src="assets/js/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css" >
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

  <script>

$(document).ready(function () {
    sub_list_datatable("product_details_datatable");
                sub_list_datatable("consignee_details_datatable");
                sub_list_datatable("po_delivery_datatable");
});
function get_po_no(){
    document.getElementById('mypo').value = '';
    var po_num = document.getElementById('po_num').value;
    // alert(po_num);
    document.getElementById('mypo').value = po_num;
}
// import function start
function excel_popup() {
    // alert();
    $("#consignee_excel_import").modal("show");
    // event.preventDefault();
}

 function modal_close() {
         $("#consignee_excel_import").modal("hide");
     }



// Add event listener for modal close event

$("#import").click(function() {
    // alert('hi');
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').value;
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    // var file = document.getElementById('file').value;
    // alert(m_unique_id);

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

    $.ajax({
        type : "POST",
        url  : 'folders/po_form/con_import.php',
        data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
        success : function (res) {
            console.log(res);
            alert('Upload Successfully');
            modal_close();
            sub_list_datatable("consignee_details_datatable");
        window.location.reload();
                    
                    
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
  if(phone_input.value === '') {
    phone_input.setCustomValidity('Enter phone number!');
  } else {
    phone_input.setCustomValidity('Enter phone number in this format: 123-4567890');
  }
});



$("#files").change(function() {
    filename = this.files[0].name
    console.log(filename);
});

function item_detail() {

var item_code = $('#item_code').val();
// alert(item_code);
var ajax_url = sessionStorage.getItem("folder_crud_link");

if (item_code) {
    $.ajax({
        type : "POST",
        url  : ajax_url,
        data : {
            item_code : item_code,
            action   : "get_item_name"
        },
        success : function (res) {
            console.log(res);

            var details = JSON.parse(res);

            $("#po_name").val(details['item_description']);
            $("#unit_price").val(details['rc_unit_price']);
            $("#tax").val(details['gst']);

            // $('#item_code').val('');
            
        }
        // $('#tender_code').val('');
   
    });
}	
}


function po_form_cu() {
    // alert('hi');
    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }
	var po_num = document.getElementById('po_num').value;
    var po_date = document.getElementById('po_date').value;
	 var department = document.getElementById('department').value;
	 var gst_option = document.getElementById('gst_option').value;

    var gst_value = document.getElementById('gst_value').value;
    var executive_name = document.getElementById('executive_name').value;
    var bill_address = document.getElementById('bill_address').value;
    var contact_name = document.getElementById('contact_name').value;
    var contact_number = document.getElementById('contact_number').value;
    var contact_landline_num =document.getElementById('contact_landline_num').value;

	var email = document.getElementById('email').value;
    var district = document.getElementById('district').value;
    var pin = document.getElementById('pin').value;
	var po_prepared_by = document.getElementById('po_prepared_by').value;
    var po_type = document.getElementById('po_type').value;
    var no_of_po = document.getElementById('no_of_po').value;
	// var delivery_due_dates = document.getElementById('delivery_due_dates').value;
    // var ld_per_day = document.getElementById('ld_per_day').value;
    // var ld_maximum_val = document.getElementById('ld_maximum_val').value;
	// var warranty = document.getElementById('warranty').value;
	// var warranty_duration = document.getElementById('warranty_duration').value;
	// var exampleCheck1 = document.getElementById('exampleCheck1').value;
	// var exampleCheck2 = document.getElementById('exampleCheck2').value;
	// var bg = document.getElementById('bg').value;
	// var bg_month = document.getElementById('bg_month').value;
	var unique_id = document.getElementById('unique_id').value;
    var form_unique_id = document.getElementById('m_unique_id').value;
	var no_of_consignee = document.getElementById('no_of_consignee').value;
	var po_unique_id = document.getElementById('po_unique_id').value;

	var file = document.getElementById('file').value;
// alert(m_unique_id);

   var data = new FormData();
            var image_s = document.getElementById("file");
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("file", document.getElementById('file').files[i]);
 
                }
            } else {
                data.append("file", '');
            }


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
    data.append("contact_landline_num",contact_landline_num);

	data.append("email", email);
	data.append("district", district);
	data.append("pin", pin);
	data.append("po_prepared_by", po_prepared_by);
	data.append("po_type", po_type);
	data.append("no_of_po", no_of_po);
	// data.append("delivery_due_dates", delivery_due_dates);
	// data.append("ld_per_day", ld_per_day);
	// data.append("ld_maximum_val", ld_maximum_val);
	// data.append("warranty", warranty);
	// data.append("warranty_duration", warranty_duration);
	// data.append("exampleCheck1", exampleCheck1);
	// data.append("exampleCheck2", exampleCheck2);
	// data.append("bg", bg);
	// data.append("bg_month", bg_month);
	data.append("no_of_consignee", no_of_consignee);
	data.append("po_unique_id", po_unique_id);

	data.append("action", "createupdate");

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url      = sessionStorage.getItem("list_link");

        $.ajax({
			type: "POST",
			url: 'folders/po_form/crud.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			beforeSend 	: function() {
				$(".createupdate_btn").attr("disabled","disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success		: function(data) {
            console.log(data);
				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;

				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} else {
							$(".createupdate_btn").text("Save");
						}
					}
				}
              
                
            //    alert(no_of_po);
$('#no_of_pro_item').append(no_of_po);
$('#no_of_po_con').append(no_of_consignee);

                                get_product_sublist_count();
                                get_stored_sublist_count();
                                var url= $('#sec_tab').show();
				sweetalert(msg);
                // department_create();


			},
			error 		: function(data) {
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

$(document).ready(function() {
    if($(".bgcheckbox").is(":checked")){
        $(".bgdiv").show();
        $(".bgdiv1").show();
    }else{
        $(".bgdiv1").hide();
        $(".bgdiv").hide();
    }

    $('.select2_op').select2();

$('#pro_details').click(function() {
  $('.select2_op').val(null).trigger('change');
});

    // var ass_qty_val = document.getElementById('return_qty').value;
    // var assign_qty_total = [];

    //     var number = parseFloat(ass_qty_val);
    //         if (!isNaN(number)) {
    //             assign_qty_total.push(number);
    //           var sum_of_ass_qty = assign_qty_total.reduce(function (total, current) {
    //             return total + current;
    //           },0);
              
    //         }
    //         console.log(sum_of_ass_qty);
    //         console.log(assign_qty_total);

// product tab btn enable or disable fun-->

//setTimeout(function(){

 //   get_product_sublist_count();
// product tab end and start consignee-->
//get_stored_sublist_count();
//},10000);


// gst unregistered
 var uni_id=document.getElementById('m_unique_id').value;
 var val1 = document.getElementById('old_gst_option').value;
 var unregistered_message = document.getElementById('unregistered_message');
    
    if (val1 == 'no') {
        $("#gst_num").hide();
         $("#unregistered_message").show();
        
       
       } else {
        $("#gst_num").show();
        $("#unregistered_message").hide();
   
       
       
    }

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


$('#warranty').on('change', function() {
        if (this.value == '1') {
            $("#select_warranty").show();
            document.getElementById('old_warranty').value = '1';
        } else {
            $("#select_warranty").hide();
            document.getElementById('old_warranty').value = '0';
        }
    });

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
    
// total and net value calculation
    // $('#tax').on('change', function() {
    //     var qty = document.getElementById('qty').value;
    //     var unit_price = document.getElementById('unit_price').value;
    //     if (this.value == '18') {
    //         const net_value = qty * unit_price;
    //         const percentage_value = net_value * (18 / 100);
    //         const total_value = net_value + percentage_value;

    //         document.getElementById('net_value').value = net_value;

    //         document.getElementById('total_value').value = total_value;
    //     } else if (this.value == '28') {
    //         const net_value = qty * unit_price;
    //         const percentage_value = net_value * (28 / 100);
    //         const total_value = net_value + percentage_value;

    //         document.getElementById('net_value').value = net_value;

    //         document.getElementById('total_value').value = total_value;
    //     } else {
    //         const net_value = qty * unit_price;
    //         // percentage_value = net_value * (28 / 100);
    //         const total_value = net_value;

    //         document.getElementById('net_value').value = net_value;

    //         document.getElementById('total_value').value = total_value;
    //     }
    // });
    $('#qty').on('input', function() {
        var qty = document.getElementById('qty').value;
        // var qty = parseFloat($(this).val());
        var unit_price = document.getElementById('unit_price').value;
        // alert(qty);
        var tax = document.getElementById('tax').value;
        // alert(tax);
      
        if (tax == '18' ) {
            const net_value = qty * unit_price;
            const percentage_value = net_value * (18 / 100);
            const total_value = net_value + percentage_value;

            document.getElementById('net_value').value = net_value;
            document.getElementById('total_value').value = total_value;
        } else if (tax == '28' ) {
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
    // $('#unit_price').on('change', function() {
    //     var qty = document.getElementById('qty').value;
    //     var unit_price = document.getElementById('unit_price').value;

    //     const net_value = qty * unit_price;


    //     const total_value = net_value;
    //     document.getElementById('net_value').value = net_value;
    //     document.getElementById('total_value').value = total_value;

    // });
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
    // var product_unique_id = $("#demo").val();
   
    // if (!internet_status) {
    //     sweetalert("no_internet");
    //     return false;
    // }
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
    var net_value = document.getElementById('net_value').value;


    var delivery_due_dates = document.getElementById('delivery_due_dates').value;
    var ld_per_day = document.getElementById('ld_per_day').value;
    var ld_maximum_val = document.getElementById('ld_maximum_val').value;
	var warranty = document.getElementById('warranty').value;
    // alert(warranty);
	var warranty_duration = document.getElementById('warranty_duration').value;

    var form_main_unique_id = document.getElementById('form_main_unique_id').value;

    // if (is_form) {

    // var data = $(".product_details_form").serialize();
    // var data = "no_of_po=" + no_of_po + "&tender_code=" + tender_code + "&item_code=" + item_code + "&po_name=" + po_name + "&qty=" + qty + "&unit_price=" + unit_price +
    //     "&tax=" + tax + "&total_value=" + total_value + "&net_value=" + net_value + "&form_main_unique_id=" +
    //     form_main_unique_id;
    var data = "no_of_po=" + no_of_po + "&tender_code=" + tender_code + "&item_code=" + item_code + "&po_name=" + po_name + "&qty=" + qty + "&unit_price=" + unit_price +
        "&tax=" + tax + "&total_value=" + total_value + "&net_value=" + net_value + "&delivery_due_dates=" + delivery_due_dates
        + "&ld_per_day=" + ld_per_day + "&ld_maximum_val=" + ld_maximum_val + "&warranty=" + warranty
        + "&warranty_duration=" + warranty_duration + "&form_main_unique_id=" + form_main_unique_id;
    data += "&unique_id=" + unique_id + "&action=product_details_add_update";
// alert(unique_id);
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
                get_product_sublist_count();
                // Init Datatable
                sub_list_datatable("product_details_datatable");
            }
       

                // var selectedTenderCode = $('#tender_code').val();
                // var selecteditem_code= $('#item_code').val();
                // // alert(selecteditem_code);
                // // Remove the selected option from the tender_code select box
                // $('#tender_code option[value="' + selectedTenderCode + '"]').remove();

                // // Reset the value of the select box to an empty string
                // // $('#tender_code').val('');
                // // Remove the selected option from the tender_code select box
                // $('#item_code option[value="' + selecteditem_code + '"]').remove();

                // Reset the value of the select box to an empty string
                // $('#item_code').val('');

            // document.getElementById('item_code').value = '';
            document.getElementById('po_name').value = '';
            document.getElementById('qty').value = '';
            document.getElementById('unit_price').value = '';
            document.getElementById('total_value').value = '';
            document.getElementById('tax').value = '';
            document.getElementById('net_value').value = '';

            document.getElementById('delivery_due_dates').value = '';
            document.getElementById('ld_per_day').value = '';
            document.getElementById('ld_maximum_val').value = '';
            document.getElementById('warranty').value = '';
            document.getElementById('warranty_duration').value = '';
            
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

// product edit


// function product_details_edit(unique_id = "") {
//     alert();
//     if (unique_id) {
//         var data = "unique_id=" + unique_id + "&action=product_details_edit";
//         // alert(data);

//         var ajax_url = sessionStorage.getItem("folder_crud_link");
//         // var url      = sessionStorage.getItem("list_link");
//         var url = "";

//         // console.log(data);
//         $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             beforeSend: function() {
//                 $(".product_details_add_update_btn").attr("disabled", "disabled");
//                 $(".product_details_add_update_btn").text("Loading...");
//             },
//             success: function(data) {
//                 // alert(data);

//                 var obj = JSON.parse(data);
//                 var data = obj.data;
//                 var msg = obj.msg;
//                 var status = obj.status;
//                 var error = obj.error;

//                 if (!status) {
//                     $(".product_details_add_update_btn").text("Error");
//                     console.log(error);
//                 } else {
//                     var product = data.product;
//                     var item_code = data.item_code;
//                     alert(item_code);
//                     var qty = data.qty;
//                     var unit_price = data.unit_price;
//                     var tax = data.tax;
//                     var total_value = data.total_value;
//                     var net_value = data.net_value;
//                     var tender_code = data.tender_code;
//                     alert(tender_code);
//                         // var item_code = data.item_code;

//                     // console.log(obj);
//                    // Append tender code if it doesn't exist in options
//                     if ($("#tender_code option[value='" + tender_code + "']").length === 'Select Tender') {
//                         $("#tender_code").append($('<option>', {
//                             value: tender_code,
//                             text: tender_code
//                         }));
//                     }

//                     // Append item code if it doesn't exist in options
//                     if ($("#item_code option[value='" + item_code + "']").length === 0) {
//                         $("#item_code").append($('<option>', {
//                             value: item_code,
//                             text: item_code
//                         }));
//                     }



//                     $("#po_name").val(product);
//                     // $("#item_code").val(item_code);
                  
//                     // $("#rel_gender").val(gender).trigger("change");
//                     $("#qty").val(qty);
                   
//                     $("#unit_price").val(unit_price);
//                     $("#tax").val(tax);
//                     $("#total_value").val(total_value);
//                     // $("#net_value").val(existing_illness).trigger("change");
//                     $("#net_value").val(net_value);
//                     // $("#form_main_unique_id").val(existing_insurance).trigger("change");
//                     // $("#form_main_unique_id").val(form_main_unique_id);
                   
//                     // Button Change 
//                     $(".product_details_add_update_btn").removeAttr("disabled", "disabled");
//                     $(".product_details_add_update_btn").text("Update");
//                     $(".product_details_add_update_btn").attr("onclick", "product_details_add_update('" + unique_id + "')");
//                 }
//             },
//             error: function(data) {
//                 alert("Network Error");
//             }
//         });
//     }
// }


function product_details_edit(unique_id = "") {
    if (unique_id) {
        // $("#item_code").empty();
                    // $("#qty").empty();
        // $("#tender_code").empty();
        var data = "unique_id=" + unique_id + "&action=product_details_edit";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

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
                    var tax = data.tax;
                    var total_value = data.total_value;
                    var net_value = data.net_value;
                    var tender_code = data.tender_code;

                    var delivery_due_dates = data.delivery_due_dates;
                    var ld_per_day = data.ld_per_day;
                    var ld_maximum_val = data.ld_maximum_val;
                    var warranty = data.warranty;
                    var warranty_duration = data.warranty_duration;

                  
                    // Append tender code if it doesn't exist in options
                  //  if ($("#tender_code option[value='" + tender_code + "']").length === 0) {
                    //     $("#tender_code").append($('<option>', {
                    //         value: tender_code,
                    //         text: tender_code
                    //     }));
                    // }

                    // // Append item code if it doesn't exist in options
                    // if ($("#item_code option[value='" + item_code + "']").length === 0) {
                    //     $("#item_code").append($('<option>', {
                    //         value: item_code,
                    //         text: item_code
                    //     }));
                  //  }
                 
                    // Set values for other fields
                    // $("#tender_code").val(tender_code).trigger("change");
                    // $("#item_code").val(item_code).trigger("change");
                    $("#tender_code").val(tender_code);
                    $("#item_code").val(item_code);
                    $("#po_name").val(product);
                    $("#qty").val(qty);
                    $("#unit_price").val(unit_price);
                    $("#tax").val(tax);
                    $("#total_value").val(total_value);
                    $("#net_value").val(net_value);


                    $("#delivery_due_dates").val(delivery_due_dates);
                   $("#ld_per_day").val(ld_per_day);
                   $("#ld_maximum_val").val(ld_maximum_val);
                   $("#warranty").val(warranty);
                   $("#warranty_duration").val(warranty_duration);


                    // Enable update button
                    $(".product_details_add_update_btn").removeAttr("disabled").text("Update");
                    $(".product_details_add_update_btn").attr("onclick", "product_details_add_update('" + unique_id + "')");
                }
            },
            error: function() {
                alert("Network Error");
            }
        });
    }
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

    // alert(con_district);

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
                // $('select[name="con_district"]').empty();
                // $('select[name="con_district"]').show();
                //$('#d1').hide();
                // document.getElementById('').value = '';
            //    $('#d2').show();
// Set district value to null or empty


        //    var selectedcon_district= $('#con_district').val();
        //         // alert(selecteditem_code);
        //         // Remove the selected option from the tender_code select box
        //         $('#con_district option[value="' + selectedcon_district + '"]').remove();

                // Reset the value of the select box to an empty string
                // $('#con_district').val('');
// Select district for null
document.getElementById('con_district').value = 'your_district_value';
document.getElementById('con_district').value = '';

// document.getElementById('con_district').selectedIndex = -1;

            document.getElementById('con_address').value = '';
            // document.getElementById('con_district').value = '';
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
            beforeSend: function() {
                $(".consignee_details_add_update_btn").attr("disabled", "disabled");
                $(".consignee_details_add_update_btn").text("Loading...");
            },
            success: function(data) {
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

                   
                    // $("#qty").empty();
                    // $("#tender_code").empty();
                    // Append tender code if it doesn't exist in options
                    if ($("#con_district option[value='" + con_district + "']").length === 0) {
                        $("#con_district").append($('<option>', {
                            value: district_unique_id,
                            text: con_district
                        }));
                    }
                    $("#con_address").val(con_address);
                    $("#con_district").val(district_unique_id);
                    // $("#rel_gender").val(gender).trigger("change");
                    $("#con_pincode").val(con_pincode);
                   
                    $("#con_contact_name").val(con_contact_name);
                    $("#con_contact_number").val(con_contact_number);
                    $("#con_lan_num").val(con_lan_num);
                    // $("#con_district").empty();
                    // Button Change 
                    $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                    $(".consignee_details_add_update_btn").text("Update");
                    $(".consignee_details_add_update_btn").attr("onclick", "consignee_details_add_update('" + unique_id + "')");
                }
            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }
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
        destroy: true,
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

                } 
                
            });
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


    // function validateCharacter(event) {
    //         // Get the pressed key code
    //         const keyCode = event.which || event.keyCode;

    //         // Check if the pressed key is a character (a-z, A-Z)
    //         if ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)) {
    //             // Valid character, allow input
    //             document.getElementById('charValidationMessage').textContent = '';
    //         } else {
    //             // Invalid character, prevent input and display a message
    //             event.preventDefault();
    //             document.getElementById('charValidationMessage').textContent = 'Only characters are allowed.';
    //         }
    //     }

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

      

    

function check_qty(){
   
    var bill_qty= document.getElementsByName('bill_qty[]');
    var con_sno= document.getElementsByName('con_sno[]');

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
    var bill_qty_total  = [];


    for (var i = 0;i < bill_qty.length; i++) {

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
                item_name.push({product_name_val,item_qty});  
                item_qty_total.push(item_qty);              
            }
           
            if (!isNaN(number)) {
        var sum_of_assign_qty1 = assign_qty_total.reduce(function (total, current) {
        return total + current;
        },0);              
    }
    // console.log(sum_of_assign_qty1);
        }
        for(var j=0; j < product_name.length; j++){
            var product_name_data = product_name[j].value;
            var item_data = bill_qty[j].value;
            // console.log(item_data);
            // console.log(product_name_data);
            item_names.push({item_name:product_name_data,qty:item_data});              

        }
        // console.log(item_names);
    const productQuantities = [];
        item_names.forEach(function(item) {
            // console.log(item['item_name']);
            var productName = item['item_name'];
            var quantity = item['qty'];
            if (productQuantities[productName]) {
                productQuantities[productName] += ','+quantity; 
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
            valuesArray.forEach(function(value) {
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
    var uniqueProducts  = {};

    result_name.forEach(function(entry) {
    var productName = entry.product_name_val;
    var itemQty = parseInt(entry.item_qty, 10);

    // If the product name does not exist in the uniqueProducts object, add it
    if (!uniqueProducts[productName]) {
        uniqueProducts[productName] = itemQty;
    }
    }); 

    // Convert the uniqueProducts object back into an array of objects
    var filteredData = Object.keys(uniqueProducts).map(function(productName) {
        return { product_name_val: productName, item_qty: uniqueProducts[productName].toString() };
    });

    console.log('Filtered data:', filteredData);

    var conditionMet = true;


    for (var productName in sums) {
        // Check if the product name exists in the sums object
        if (sums.hasOwnProperty(productName)) {
            // Find the corresponding object in the filteredData
            var productObject = filteredData.find(function(obj) {
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
        po_assign_add_update();

        console.log("Condition is true");
        var element = document.getElementById("mynxt");
        element.classList.add("js-btn-next");
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



// consignee sub crud
// =======================old before api=========================================================
// function po_assign_add_update(unique_id = "") {
//     // alert('hi');
    
//     var internet_status = is_online();

//     var demo= document.getElementById('demo').value;
//     var bill_qty= document.getElementsByName('bill_qty[]');

  
//     for (var i = 0; i < bill_qty.length; i++) {
//         var bill_qty_val = bill_qty[i].value;

//         // if (bill_qty_val != '') {
        
//             var qty_val = bill_qty[i].value;
//             var item_code = document.getElementsByName('item_code[]');
//             var item_name = document.getElementsByName('item_name[]');
//             var unit_price = document.getElementsByName('unit_price[]');
//             var tax = document.getElementsByName('tax[]');
//             var qty = document.getElementsByName('qty[]');
//             // var rem_qty = document.getElementsByName('initial_qty[]');


//             var con_unique_id = document.getElementsByName('con_unique_id[]');
//             var con_name = document.getElementsByName('con_name[]');
//             var con_contact_no = document.getElementsByName('con_contact_no[]');
//             var product_unique_id = document.getElementsByName('product_unique_id[]');

//             var item_code_val = item_code[i].value;
//             var item_name_val = item_name[i].value;
//             var item_unit_price = unit_price[i].value;
//             var item_tax = tax[i].value;
//             var qty = qty[i].value;
// // var rem_qty = rem_qty[i].value;

//             var con_unique_id_val = con_unique_id[i].value;
//             var con_name_val = con_name[i].value;
//             var con_contact_no_val = con_contact_no[i].value;
//             var product_unique_id_val = product_unique_id[i].value;

//             // var product_unique_id= document.getElementById('product_unique_id').value;
//             var main_unique_id = document.getElementById('main_unique_id').value;
//             var po_unique_id = document.getElementById('po_unique_id').value;

            
        

//             var data = "main_unique_id=" + main_unique_id + "&con_unique_id=" + con_unique_id_val +
//                 "&con_name=" + con_name_val + "&con_contact_no=" + con_contact_no_val + "&item_code=" + item_code_val +
//                 "&item_name=" +
//                 item_name_val + "&bill_qty=" + qty_val + "&unit_price=" + item_unit_price + "&item_tax=" + item_tax +
//                 "&po_unique_id=" + po_unique_id + "&product_unique_id_val=" + product_unique_id_val + "&qty=" + qty;

//             data += "&unique_id=" + unique_id + "&action=po_delivery_add_update";

//             var ajax_url = sessionStorage.getItem("folder_crud_link");
//             // var url = "";

//             $.ajax({
//                 type: "POST",
//                 url: ajax_url,
//                 data: data,
//                 beforeSend: function() {
//                     $(".po_delivery_add_update_btn").attr("disabled", "disabled");
//                     $(".po_delivery_add_update_btn").text("Loading...");
//                 },
//                 success: function(data) {
//                     var obj = JSON.parse(data);
//                     var msg = obj.msg;
//                     var status = obj.status;
//                     var error = obj.error;
//                     // alert(msg);
//                     if (!status) {
//                         $(".po_delivery_add_update_btn").text("Error");
//                         // console.log(error);
//                     } else {
//                         if (msg == "e_already") {
//                             // sweetalert(msg, url);
//                             form_reset("po_delivery_form");
//                         }
//                         if (msg == "e_already") {
//                             sweetalert(msg);
//                         }
//                         $(".po_delivery_add_update_btn").removeAttr("disabled", "disabled");
//                         // && msg == "already"
//                         if (unique_id ) {
//                             $(".po_delivery_add_update_btn").text("Update");
//                         } else {
//                             $(".po_delivery_add_update_btn").text("Add");
//                             $(".po_delivery_add_update_btn").attr("onclick",
//                                 "po_delivery_add_update('')");
//                         }
//                         // location.reload();
//                         // Init Datatable
//                         sub_list_datatable("po_delivery_datatable");
//                     }
//                     // get_po_item();
//                     sweetalert(msg);
//                     var element = document.getElementById("mynxt");
//         element.classList.add("js-btn-next");
//                 },
//                 error: function(data) {
//                     alert("Network Error");
//                 }
//             });
//         }
//     }

// ============================end================================================

// new================api=============================================================
    
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

        var external_api_url = "./folders/po_form/po_assign_create.php"; // Replace with actual external API URL

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
                var element = document.getElementById("mynxt");
                element.classList.add("js-btn-next");
            },
             error: function(response) {
                var element = document.getElementById("mynxt");
                if(element){
                element.classList.remove("js-btn-next");
                }
        //  if(unique_id){
                Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'successfully Saved!',
                        // timer: 1000, // Alert will close after 2 seconds
                        timer: 500, // Alert will close after 0.1 seconds
                        showConfirmButton: false // Hides the confirm button
                    });
                    
                }
            // }
            // else {
            //     Swal.fire({
            //             icon: 'success',
            //             title: 'Success',
            //             text: 'successfully Update!',
            //             timer: 500, // Alert will close after 0.5 seconds
            //             showConfirmButton: false // Hides the confirm button
            //         });
                    
            //     }
            // }
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

function get_stored_sublist_count(){

var uni_id=document.getElementById('form_main_unique_id').value;
    var data = "uni_id=" + uni_id + "&action=check_consignee";
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    
                     document.getElementById('stored_consignee').value = obj.data[0];
                     get_consignee();
                }
            });
}

function get_consignee(){

var uni_id=document.getElementById('form_main_unique_id').value;

    var data = "uni_id=" + uni_id + "&action=no_of_consignee";
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    
                     document.getElementById('count_consignee').value = obj.data[0];
                    //  get_stored_sublist_count();
                     get_tab_checking();

                }
            });
            
}

function get_tab_checking(){
    var x = document.getElementById('stored_consignee').value;
    var y = document.getElementById('count_consignee').value;
    if(x != y){
        $('#consignee_btn').hide();
        $('#consignee_msg').show(); 
    }
    else{
        $('#consignee_btn').show(); 
        $('#consignee_msg').hide(); 
    }
}



function get_product_sublist_count(){

var uni_id=document.getElementById('form_main_unique_id').value;
    var data = "uni_id=" + uni_id + "&action=check_product";
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    
                     document.getElementById('stored_item').value = obj.data[0];
                     get_po_item();
                }
            });
}

function get_po_item(){

var uni_id=document.getElementById('form_main_unique_id').value;

    var data = "uni_id=" + uni_id + "&action=no_of_item";
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(data) {
            
                    var obj = JSON.parse(data);
                    
                     document.getElementById('count_item').value = obj.data[0];

                     get_producttab_checking();
                },
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

var internet_status  = is_online();

if (!internet_status) {
    sweetalert("no_internet");
    return false;
}

var department= document.getElementById('department_txt').value;
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
    var url      = sessionStorage.getItem("list_link");
    $.ajax({
        type 	: "POST",
        url 	: ajax_url,
        data 	: data,
        success		: function(data) {
            var obj  =JSON.parse(data);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;
            // alert(msg);
                if (data==""){
                    alert('enter the value');
                }
                else{
            // alert('saved successfully');
            sweetalert(msg);
            $('#demos').modal('hide');
            // $('').close()
                 }
        },
        error 		: function(data) {
            alert("Network Error");

        }
    });
} else {
    sweetalert("form_alert");
}
}

// function department_create(unique_id = "") {

//     var internet_status  = is_online();

//     if (!internet_status) {
//         sweetalert("no_internet");
//         return false;
//     }

//   var department= document.getElementById('department_name').value;
//         var is_active1 = document.getElementById('is_active1').value;
       
//     if (department && is_active1) {

// var data = "department=" +department + "&is_active1=" + is_active1;
// data 		+= "&unique_id="+unique_id+"&action=department_cu";

//         var ajax_url = sessionStorage.getItem("folder_crud_link");
//         var url      = sessionStorage.getItem("list_link");
//         $.ajax({
// 			type 	: "POST",
// 			url 	: ajax_url,
// 			data 	: data,
// 			success		: function(data) {
//                 var obj     = JSON.parse(data);
// 				var msg     = obj.msg;
// 				var status  = obj.status;
// 				var error   = obj.error;
//                 if (!status) {
// 					url 	= '';
//                     $(".createupdate_btn").text("Error");
//                     console.log(error);
// 				}
// 				 else {

// 					if (msg=="already") {
// 						// Button Change Attribute
// 						url 		= '';

// 						$(".createupdate_btn")NaNpxoveAttr("disabled","disabled");
// 						if (unique_id) {
// 							$(".createupdate_btn").text("Update");
// 						} 
// 					}
// 				}
               
// 				// var url = 'folders/po_form/list.php';
// 				sweetalert(msg);

//                 $('#demos').modal('hide');
//                 <?php
//                 header("Refresh:0; url=department_names.php"); ?>
//                 // location.reload();
             

// 			},
// 			error 		: function(data) {
// 				alert("Network Error");
// 			}
// 		});
//     } else {
//         sweetalert("form_alert");
//     }
// }
// function get_item_name(tender_code = "") {
    

function term_condition() {
    // alert('hi prabu');
    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }
    var po_no = document.getElementById('mypo').value;
    // CalculateTotal
	var delivery_due_dates = document.getElementById('delivery_due_dates').value;
    var ld_per_day = document.getElementById('ld_per_day').value;
    var ld_maximum_val = document.getElementById('ld_maximum_val').value;
	var warranty = document.getElementById('warranty').value;
	var warranty_duration = document.getElementById('warranty_duration').value;
	// var bank_required = document.getElementById("bank_required").checked;
	// var ins_reqired = document.getElementById("ins_reqired").checked;

	var bg = document.getElementById('bg').value;
	var bg_month = document.getElementById('bg_month').value;
	var unique_id = document.getElementById('unique_id').value;
    var demo = document.getElementById('demo').value;
	// var no_of_consignee = document.getElementById('no_of_consignee').value;
	var po_unique_id = document.getElementById('po_unique_id').value;

	var po_file = document.getElementById('po_file').value;

	// alert(file);
	// alert(ins_reqired);
	if(document.getElementById("ins_reqired").checked == true){
		var ins_reqired1 = 'on';
	}else{
		var ins_reqired1 = 'off';
	}

	if(document.getElementById("bank_required").checked == true){
		var bank_required1 = 'on';
	}else{
		var bank_required1 = 'off';
	}
	if(document.getElementById("dc_required").checked == true){
		var dc_required1 = 'on';
	}else{
		var dc_required1 = 'off';
	}
   var data = new FormData();
            var image_s = document.getElementById("po_file");
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("po_file", document.getElementById('po_file').files[i]);
 
                }
            } else {
                data.append("po_file", '');
            }

//    alert(image_s);
	 
	// data.append("no_of_po", no_of_po);
    data.append("po_no",po_no);
	data.append("delivery_due_dates", delivery_due_dates);
	data.append("ld_per_day", ld_per_day);
	data.append("ld_maximum_val", ld_maximum_val);
	data.append("warranty", warranty);
	data.append("warranty_duration", warranty_duration);
	data.append("ins_reqired", ins_reqired1);
	data.append("bank_required", bank_required1);
	data.append("dc_required", dc_required1);
	data.append("bg", bg);
	data.append("bg_month", bg_month);
	data.append("demo", demo);
	data.append("po_unique_id", po_unique_id);
	data.append("action", "terms_condition");

// 	var is_form = form_validity_check("was-validated");
//  if (is_form) {
	// var data 	 = $(".was-validated").serialize();
	// data 		+= "&unique_id="+unique_id+"&action=demo";

			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url      = sessionStorage.getItem("list_link");
	
        // console.log(data);
        $.ajax({
			type: "POST",
			url: 'folders/po_form/crud.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			// beforeSend 	: function() {
			// 	$(".createupdate_btn").attr("disabled","disabled");
			// 	$(".createupdate_btn").text("Loading...");
			// },
			success		: function(data) {
                //alert(data);
				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;
				
				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				}
				 else {

					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} 
					}
				}
				// var url = 'folders/po_form/list.php';
				sweetalert(msg,url);
				

			},
			error 		: function(data) {
				alert("Network Error");
			}
		});
	// } 
	// else {
    //     sweetalert("form_alert");
    // }
}
//podate

// document.addEventListener('DOMContentLoaded', (event) => {
//             var poDateInput = document.getElementById('po_date');
//             var today = new Date().toISOString().split('T')[0];
//             poDateInput.setAttribute('max', today);
//             poDateInput.value = ""; 
//         });

// new
function CalculateTotal(){
    var qty = document.getElementById('qty').value;
        // var qty = parseFloat($(this).val());
        var unit_price = document.getElementById('unit_price').value;
        // alert(qty);
        var tax = document.getElementById('tax').value;
        // alert(tax);
      
        if (tax == '18' ) {
            
            const net_value = qty * unit_price;
            const percentage_value = net_value * (18 / 100);
            const total_value = net_value + percentage_value;

            document.getElementById('net_value').value = net_value;
            document.getElementById('total_value').value = total_value;
        } else if (tax == '28' ) {
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
}


   $('#qty').on('input',function(){
    CalculateTotal();

   });

   $('#tax').on('change',function(){
    CalculateTotal();
   });


//    new change
function toggleInsRequired() {

    // alert();
        var dcRequired = document.getElementById('dc_required');
        var insRequired = document.getElementById('ins_reqired');

        // Disable ins_reqired if dc_required is checked, else enable it
        insRequired.disabled = dcRequired.checked;
    }

    function toggleDcRequired() {
        var insRequired = document.getElementById('ins_reqired');
        var dcRequired = document.getElementById('dc_required');

        // Disable dc_required if ins_reqired is checked, else enable it
        dcRequired.disabled = insRequired.checked;
    }
    // Call these functions on page load to ensure the correct initial state
    window.onload = function() {
        toggleInsRequired();
        toggleDcRequired();
    };

 </script>
