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


$tax_select_status ="";

$is_active          = 1;

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        // $unique_id  = $get_uni_id;
        $where      = [
            "unique_id" => $uni_dec
        ];


        $table      =  "po_form";

        $columns    = [
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
           $po_update_unique_id    = $result_values[0]["po_unique_id"];
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

// $department_options = department_creation($department);
// $department_options = select_option($department_options, "Select Department",  $department);

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

echo "Generated ID: $generatedId";

// PO Unique ID Number generate function
function generatePoUniqueId($prefix, $numericPart) {
    // Use sprintf to format the numeric part with leading zeros
    $formattedNumericPart = sprintf("%05d", $numericPart);

    // Concatenate the prefix and the formatted numeric part
    $prefixedId = $prefix . $formattedNumericPart;
    return $prefixedId;
}

// $prefix = "PO-";
$date = date("Y");
$st_date = substr($date, 2);
$month = date("m");
$datee = $st_date . $month;
$prefix = 'PO-' . $datee.'-';
$numericPart = 1;
$po_unique_Id = generatePoUniqueId($prefix, $numericPart);

echo "Generated ID: $po_unique_Id";

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


<section class="mt-4">
    <div class="container-12">
        <form class="was-validated card" autocomplete="off">
            <div class="card-header">
                <nav class="nav nav-pills nav-fill">
                    <a class="nav-link tab-pills" href="#">PO Details</a>
                    <a class="nav-link tab-pills" href="#">Product Details</a>
                    <a class="nav-link tab-pills" href="#">Consignee Details</a>
                    <a class="nav-link tab-pills" href="#">Assign Qty Details</a>
                    <a class="nav-link tab-pills" href="#">Terms & Condition</a>
                </nav>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="hidden" id="m_unique_id" name="m_unique_id" value="<?php echo $unique_id; ?>">
                    <input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
                        value="<?php echo $unique_id; ?>">

                    <input type="hidden" id="unique_id" name="unique_id" value="<?php echo $update_unique_id; ?>">

                    <input type="hidden" id="demo" name="demo"
                        value="<?php if($update_unique_id !=''){ echo  $update_unique_id;}else{ echo $unique_id;} ?>">

                    <input type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $po_unique_Id; ?>">

                    <div class="card-body">
                        <div class="tab d-none">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h5 style="float:right;">
                                        <b><?php if($po_update_unique_id !=''){ echo  $po_update_unique_id;}else{ echo $po_unique_Id;} ?></b>
                                    </h5>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Number</label>
                                        <input type="text" id="po_num" name="po_num" class="form-control"
                                            value="<?php if($po_num !=''){ echo  $po_num;}?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Date</label>
                                        <input type="date" id="po_date" name="po_date" class="form-control"
                                            value="<?php echo $po_date; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Department</label>
                                        <input type="text" id="department" name="department" class="form-control"
                                            value="<?php echo $department; ?>" required>
                                        <!-- <select class="form-select mb-3" id="department" name="department"> -->

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <input type="hidden" id="old_gst_option" name="old_gst_option"
                                            value="<?php echo $gst_option; ?>" />
                                        <label for="main_screen" class="form-label">GST Option</label>
                                        <?php 
                                        if($gst_option == 'yes'){?>
                                        <select class="form-select mb-3" id="gst_option" name="gst_option">
                                            <option>selcet option</option>
                                            <option value="yes" selected>Yes</option>
                                            <option value="no">No</option>

                                        </select>
                                        <?php }else if($gst_option == 'no'){ ?>
                                        <select class="form-select mb-3" id="gst_option" name="gst_option"
                                            value="<?php echo $gst_option; ?>">
                                            <option>selcet option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no" selected>No</option>

                                        </select>
                                        <?php }else{?>
                                        <select class="form-select mb-3" id="gst_option" name="gst_option"
                                            value="<?php echo $gst_option; ?>">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>

                                        </select>
                                        <?php } ?>

                                    </div>
                                </div>

                                <div class="col-xl-3" id="gst_num">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Customer GST Number</label>
                                        <input type="text" id="gst_value" name="gst_value" minlength="15" maxlength="15"
                                            class="form-control" value="<?php echo $gst_value; ?>" required>

                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Excutive Name</label>
                                        <select class="form-select mb-3" id="executive_name" name="executive_name">
                                            <?php echo $executive_name_options; ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Billing Address</label>
                                        <input type="text" id="bill_address" name="bill_address" class="form-control"
                                            value="<?php echo $bill_address; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Conatact Name</label>
                                        <input type="text" id="contact_name" name="contact_name" class="form-control"
                                            value="<?php echo $contact_name; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number"
                                            class="form-control" value="<?php echo $contact_number; ?>"
                                            onkeypress="return isNumber(event)" minlength="10" maxlength="10" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            value="<?php echo $email; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">District</label>
                                        <select class="form-select mb-3" id="district" name="district">
                                            <?php echo $district_options; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Pin Code</label>
                                        <input type="text" id="pin" name="pin" class="form-control"
                                            onkeypress="return isNumber(event)" minlength="6" maxlength="6"
                                            value="<?php echo $pin; ?>" required>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Prepared by </label>
                                        <input type="text" id="po_prepared_by" name="po_prepared_by"
                                            class="form-control" value="<?php echo $po_prepared_by; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label"> PO Type </label>
                                        <select class="form-select mb-3" id="po_type" name="po_type"
                                            aria-label="Default select example" value="<?php echo $po_type; ?>">
                                            <?php echo $po_type_options; ?>
                                            <!-- <option value="">Select Option </option>
                                            <option value="1">Product</option>
                                            <option value="2">Service</option> -->
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Items in PO </label>
                                        <input type="text" id="no_of_po" name="no_of_po" class="form-control"
                                            onkeypress="return isNumber(event)" maxlength="3"
                                            value="<?php echo $no_of_po; ?>">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Consignee</label>
                                        <input type="text" id="no_of_consignee" name="no_of_consignee"
                                            class="form-control" onkeypress="return isNumber(event)" maxlength="3"
                                            value="<?php echo $no_of_consignee; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="tab d-none">


                            <form class="was-validated product_details_form" id="product_details_form">

                                <div class="row">
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Elcot Item Code</label>
                                            <input type="text" id="item_code" name="item_code" class="form-control"
                                                value="<?php echo $item_code; ?>" required>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Po Category</label>
                                      
                                        <select class="form-select mb-3" aria-label="Default select example">
                                            <option selected="">Select District </option>
                                            <option value="1">Product</option>
                                            <option value="2">Service</option>
                                    
                                        </select>
                                    </div>
                                </div> -->
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Product</label>
                                            <input type="text" id="po_name" name="po_name" class="form-control"
                                                value="<?php echo $po_name; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Qty</label>
                                            <input type="text" id="qty" name="qty" class="form-control"
                                                onkeypress="return isNumber(event)" value="<?php echo $qty; ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Unit Price</label>
                                            <input type="text" id="unit_price" name="unit_price" class="form-control"
                                                onkeypress="return isNumber(event)" value="<?php echo $unit_price; ?>"
                                                required>
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
                                            <label for="main_screen" class="form-label">Total Value</label>
                                            <input type="text" id="total_value" name="total_value" class="form-control"
                                                value="<?php echo $total_value; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Net Value</label>
                                            <input type="text" id="net_value" name="net_value" class="form-control"
                                                value="<?php echo $net_value; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 mt-4">
                                        <div class="mb-3">
                                            <input type="hidden" name="count" id="count">
                                            <button type="button"
                                                class="btn btn-success btn-label rounded-pill product_details_add_update_btn"
                                                onclick="product_details_add_update()"><i
                                                    class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                Add New</button>

                                        </div>
                                    </div><!-- end col -->

                                    <div class="table-responsive mb-4">
                                        <table id="product_details_datatable"
                                            class="table table-hover table-bordered align-middle table-nowrap mb-0"
                                            width='100%'>
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID </th>
                                                    <th scope="col">Elcot Item Code</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Unit Price</th>
                                                    <th scope="col">Tax </th>
                                                    <th scope="col">Total Value </th>
                                                    <th scope="col">Net Value </th>
                                                    <th scope="col">Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <div class="tab d-none">
                            <form class="was-validated consignee_details_form" id="consignee_details_form">

                                <div class="row">

                                    <!-- <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Elcot Item code</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="">
                                    </div>
                                    </div> -->
                                    <!-- <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Product</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="">
                                    </div>
                                    </div> -->
                                    <!-- <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Qty</label>
                                            <input type="text" id="con_qty" name="con_qty" class="form-control"
                                                value="">
                                        </div>
                                    </div> -->
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Address</label>
                                            <input type="text" id="con_address" name="con_address" class="form-control"
                                                value="" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee District</label>
                                            <input type="text" id="con_district" name="con_district"
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Pincode</label>
                                            <input type="text" id="con_pincode" name="con_pincode" class="form-control"
                                                onkeypress="return isNumber(event)" minlength="6" maxlength="6"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Contact Name </label>
                                            <input type="text" id="con_contact_name" name="con_contact_name"
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Contact Number
                                            </label>
                                            <input type="text" id="con_contact_number" name="consignee_number"
                                                class="form-control" value="" onkeypress="return isNumber(event)"
                                                minlength="10" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Landline Number
                                            </label>
                                            <input type="text" id="con_lan_num" name="con_lan_num" class="form-control"
                                                value="" onkeypress="return isNumber(event)" minlength="10"
                                                maxlength="10">
                                        </div>
                                    </div><!-- end col -->

                                    <!-- <div class="table-responsive mb-4">
                                    <table id="fixed-header"
                                        class="table table-hover table-bordered align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID </th>
                                                <th scope="col">No of Consignee</th>
                                                <th scope="col">Elcot Item Code</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Consignee Address</th>
                                                <th scope="col">Consignee District</th>
                                                <th scope="col">Consignee Pincode</th>
                                                <th scope="col">Consignee Contact Name</th>
                                                <th scope="col">Consignee Contact Number </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>1 </td>
                                                <td>10</td>
                                                <td>10</td>
                                                <td>Desktop</td>
                                                <td>7</td>
                                                <td>Chennai</td>
                                                <td>Erode</td>
                                                <td>638 052</td>
                                                <td> Surya Kumar</td>
                                                <td> +91 98765 4321</td>
                                            </tr>
                                            <tr>
                                                <td>2 </td>
                                                <td>20</td>
                                                <td>20</td>
                                                <td>Printer</td>
                                                <td>8</td>
                                                <td>Salem</td>
                                                <td>Erode</td>
                                                <td>638 116</td>
                                                <td> Raj Kumar</td>
                                                <td> +91 98765 4321</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> -->
                                    <!-- </div> -->

                                    <div class="col-xl-3 mt-4">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-success btn-label rounded-pill"
                                                onclick="consignee_details_add_update()"><i
                                                    class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                Add New</button>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="table-responsive mb-4">
                                        <table id="consignee_details_datatable"
                                            class="table table-hover table-bordered align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID </th>
                                                    <!-- <th scope="col">No of Consignee</th> -->
                                                    <!-- <th scope="col">Elcot Item Code</th>
                                                <th scope="col">Product</th> -->
                                                    <!-- <th scope="col">Qty</th> -->
                                                    <th scope="col">Consignee Address</th>
                                                    <th scope="col">Consignee District</th>
                                                    <th scope="col">Consignee Pincode</th>
                                                    <th scope="col">Consignee Contact Name</th>
                                                    <th scope="col"> Contact Number </th>
                                                    <th scope="col"> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>

                                            <td>1 </td>
                                            <td>10</td>
                                            <td>10</td>
                                            <td>Desktop</td>
                                            <td>7</td>
                                            <td>Chennai</td>
                                            <td>Erode</td>
                                            <td>638 052</td>
                                            <td> Surya Kumar</td>
                                            <td> +91 98765 4321</td>
                                            <td> <i class="lab la as las la-trash text-danger"></i> </td>
                                        </tr>
                                        <tr>

                                            <td>2 </td>
                                            <td>20</td>

                                            <td>20</td>
                                            <td>Printer</td>
                                            <td>8</td>
                                            <td>Salem</td>
                                            <td>Erode</td>
                                            <td>638 116</td>
                                            <td> Raj Kumar</td>
                                            <td> +91 98765 4321</td>
                                            <td> <i class="lab la as las la-trash text-danger"></i> </td>
                                        </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- </div> -->
                        <!-- assign qty -->
                        <div class="tab d-none">
                            <!-- <button type="button" id="next_button" class="btn btn-primary" onclick="next()">Next</button> -->
                            <?php if($update_unique_id ==''){ ?>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen"
                                                    class="form-label">Consignee
                                                    name</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen"
                                                    class="form-label">Consignee
                                                    Contact</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen"
                                                    class="form-label">Consignee
                                                    Address</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen"
                                                    class="form-label">Consignee
                                                    Landline</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="table-responsive mb-4">
                                        <form class="was-validated po_delivery_form" autocomplete="off">
                                            <table
                                                class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th scope="col">Item Code</th>
                                                        <th scope="col">Item Name</th>
                                                        <th scope="col">Assign QTY</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group row ">-->
                            <!--     <div class="col-md-12" align="right">';-->
                            <!--    <a href="index.php?file=po_form/list"><button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button></a>';-->
                            <!--    <button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="po_delivery_add_update()">Save</button>';-->

                            <!--</div>-->
                        </div>
                        <?php } else{
                                ?>
                        <div class="card-body" id="mytable">
                            <?php }?>
                        </div>
                    </div>

                    <!-- end -->
                    <div class="tab d-none">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Delivery Due Days</label>
                                    <input type="text" id="delivery_due_dates" name="delivery_due_dates"
                                        class="form-control" value="<?php echo $delivery_due_dates; ?>">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">LD% Per Day</label>
                                    <input type="text" id="ld_per_day" name="ld_per_day" class="form-control"
                                        value="<?php echo $ld_per_day; ?>">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">LD Maximum Value</label>
                                    <input type="text" id="ld_maximum_val" name="ld_maximum_val" class="form-control"
                                        value="<?php echo $ld_maximum_val; ?>">
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
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <?php } else if($warranty == '0'){?>
                                    <select class="form-select mb-3" id="warranty" name="warranty">
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                    <?php }else{?>
                                    <select class="form-select mb-3" id="warranty" name="warranty">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <?php }?>
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3" id="select_warranty">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Warranty Duration</label>
                                    <select class="form-select mb-3" id="warranty_duration" name="warranty_duration"
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
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                            name="exampleCheck1" checked>

                                        <?php }
                                        else{ ?>
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                            name="exampleCheck1">
                                        <?php }
                                        ?>

                                        <label class="form-check-label" for="exampleCheck1">
                                            Installation Required
                                        </label>
                                    </div>
                                    <div class="form-group form-check  mt-2">
                                        <?php if($exampleCheck2 == 'on'){?>
                                        <input type="checkbox" class="form-check-input bgcheckbox" id="exampleCheck2"
                                            name="exampleCheck2" checked>
                                        <?php }else{?>
                                        <input type="checkbox" class="form-check-input bgcheckbox" id="exampleCheck2"
                                            name="exampleCheck2" onchange="valueChanged()">
                                        <?php }?>
                                        <label class="form-check-label" for="exampleCheck2">Bank Gurantee
                                            Required</label>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Attach PO Copy </label>

                                    <input type="file" id="file" name="file" class="form-control dropify"
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
                                    <label for="main_screen" class="form-label">BG MONTHS </label>
                                    <input type="text" id="bg_month" name="bg_month" class="form-control"
                                        value="<?php echo $bg_month; ?>">
                                </div>
                            </div><!-- end col -->

                            <div class="" style="margin-top: 34px;">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <!-- <div>
                                        <?php echo btn_cancel($btn_cancel); ?>
                                        <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                    </div> -->
                                    <a href="index.php?file=po_form/list">
                                        <button type="button"
                                            class="btn btn-danger waves-effect waves-light">Cancel</button></a>
                                    <?php if($update_unique_id ==''){?>
                                    <button type="button"
                                        class="btn btn-success waves-effect waves-light createupdate_btn"
                                        onclick="po_form_cu()">Save</button>
                                    <?php }else if($update_unique_id != ''){?>
                                    <button type="button"
                                        class="btn btn-success waves-effect waves-light createupdate_btn"
                                        onclick="po_form_cu(unique_id.value)">Update</button>
                                    <?php }?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <!--  <button type="button" id="back_button" class="btn btn-primary " style="margin-right:1rem;"
                            onclick="back()">Previous</button><br><br>-->
                        <button type="button" id="next_button" class="btn btn-primary" onclick="next()">Next</button>
                        <!-- <button type="submit" id="next_button" class="btn btn-primary " onclick="next()">Next</button> -->

                    </div>
                </div>

            </div>
    </div>
    </form>
    </div>
</section>

<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
<!-- <script src="jquery-3.5.1.min.js"></script>   -->
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
    // var table_id 	= "user_type_datatable";
    // init_datatable(table_id,form_name,action);

    var val1 = document.getElementById('old_gst_option').value;
    if (val1 == 'no') {
        $("#gst_num").hide();
    } else {
        $("#gst_num").show();
    }

    $('#gst_option').on('change', function() {
        if (this.value == 'yes') {
            $("#gst_num").show();
            document.getElementById('old_gst_option').value = 'yes';
        } else {
            $("#gst_num").hide();
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
    // Add your validation logic for the current tab
    // Return true if validation passes, false otherwise
    // Example: Check if required fields are filled
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

    var is_form = form_validity_check("product_details_form");

    // console.log(is_form);



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
    var data = "item_code=" + item_code + "&po_name=" + po_name + "&qty=" + qty + "&unit_price=" + unit_price +
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
                if (msg !== "already") {
                    form_reset("product_details_form");
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
    // alert("hello");
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
            //alert(msg);
            if (!status) {
                $(".consignee_details_add_update_btn").text("Error");
                console.log(error);
            } else {
                if (msg == "already") {
                    // sweetalert(msg, url);
                    form_reset("consignee_details_form");
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
    //alert("test");

    // if(){

    // }
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


function get_assign_qty_record() {
    // alert('hi');
    // var next_button = $('#next_button').val();
    // alert(next_button);
    var form_main_unique_id = $('#demo').val();
    // alert(form_main_unique_id);
    // var form_main_unique_id = document.getElementById('form_main_unique_id').value;

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var data = {
        // "next_button"  : next_button,
        "form_main_unique_id": form_main_unique_id,
        "action": 'get_assign_qty_record',
    };
    $.ajax({
        url: ajax_url,
        type: "POST",
        data: data,
        success: function(data) {
            var obj = JSON.parse(data);
            var data = obj.data;
            $('#mytable').html(data);
        }

    });
}


// consignee sub crud
function po_delivery_add_update(unique_id = "") {
    //alert('hi');
    var internet_status = is_online();
    var bill_qty = document.getElementsByName('bill_qty[]');

    for (var i = 0; i < bill_qty.length; i++) {
        var bill_qty_val = bill_qty[i].value;

        if (bill_qty_val != '') {
            var qty_val = bill_qty[i].value;
            var item_code = document.getElementsByName('item_code[]');
            var item_name = document.getElementsByName('item_name[]');
            var unit_price = document.getElementsByName('unit_price[]');
            var tax = document.getElementsByName('tax[]');

            var con_unique_id = document.getElementsByName('con_unique_id[]');
            var con_name = document.getElementsByName('con_name[]');
            var con_contact_no = document.getElementsByName('con_contact_no[]');
            var product_unique_id = document.getElementsByName('product_unique_id[]');


            var item_code_val = item_code[i].value;
            var item_name_val = item_name[i].value;
            var item_unit_price = unit_price[i].value;
            var item_tax = tax[i].value;

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
                "&po_unique_id=" + po_unique_id + "&product_unique_id_val=" + product_unique_id_val;

            data += "&unique_id=" + unique_id + "&action=po_delivery_add_update";

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = "";


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
                        location.reload();
                        // Init Datatable
                        sub_list_datatable("po_delivery_datatable");
                    }
                    sweetalert(msg, url);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        }
    }
    // }
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
