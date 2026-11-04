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

//echo "Generated ID: $generatedId";

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

//echo "Generated ID: $po_unique_Id";

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

<div class="wrapper clearfix">
		
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
						<button class="multisteps-form__progress-btn">Terms & Condition </button>
					</div>
				</div>
			</div>
			<!--form panels-->

			<!--form panels-->
			<div class="row">
				<div class="col-12 col-lg-12 m-auto">
					<form class="multisteps-form__form clearfix" action="#" method="post" id="wizard">
						
						<!--single form panel-->
						<div class="multisteps-form__panel js-active" data-animation="slideVert">
							<div class="inner pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>1 of 5 Completed</span>
										<div class="progress">
											<div class="progress-bar">
											</div>
										</div>
									</div>
								</div>
							
								<div class="wizard-content-form">
									<div class="wizard-form-field">
										
					                  <div class="tab">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h5 style="float:right;"><b>PO-2312-00001</b></h5>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Number</label>
                                        <input type="text" id="po_num" name="po_num" class="form-control" value="" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Date</label>
                                        <input type="date" id="po_date" name="po_date" class="form-control" value="" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Department</label>
                                        <input type="text" id="department" name="department" class="form-control" value="" required="">
                                            <!-- <select class="form-select mb-3" id="department" name="department"> -->
                                           
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <input type="hidden" id="old_gst_option" name="old_gst_option" value="">
                                        <label for="main_screen" class="form-label">GST Option</label>
                                                                                <select class="form-select mb-3" id="gst_option" name="gst_option" value="">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>

                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="col-xl-3" id="gst_num">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Customer GST Number</label>
                                        <input type="text" id="gst_value" name="gst_value" minlength="15" maxlength="15" class="form-control" value="" required="">

                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Excutive Name</label>
                                        <select class="form-select mb-3" id="executive_name" name="executive_name">
                                            <option value="" selected="">Select Executive</option><option value="5f97fc3257f2525520988">Ranjith</option><option value="62b55fe64789d4021311">Sugan</option><option value="62b55fe64789d411233">Sabari</option>                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Billing Address</label>
                                        <input type="text" id="bill_address" name="bill_address" class="form-control" value="" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Conatact Name</label>
                                        <input type="text" id="contact_name" name="contact_name" class="form-control" value="" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="" onkeypress="return isNumber(event)" minlength="10" maxlength="10" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" value="" required="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">District</label>
                                        <select class="form-select mb-3" id="district" name="district">
                                            <option value="" selected="">Select District</option><option value="62ba945e842c028376">Erode</option><option value="6561dc8d24b7944257">Chennai</option><option value="6561dc9c342dc41389">Cochin</option><option value="6561dce6e273914275">Tirupati</option><option value="6561dcf91c7d170353">Chittoor</option>                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Pin Code</label>
                                        <input type="text" id="pin" name="pin" class="form-control" onkeypress="return isNumber(event)" minlength="6" maxlength="6" value="" required="">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Prepared by </label>
                                        <input type="text" id="po_prepared_by" name="po_prepared_by" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label"> PO Type </label>
                                        <select class="form-select mb-3" id="po_type" name="po_type" aria-label="Default select example" value="">
                                            <option value="" selected="">Select Po Type</option><option value="5f9709087h6576hh7">Product</option><option value="62b55tyyrr4538899">Service</option>                                            <!-- <option value="">Select Option </option>
                                            <option value="1">Product</option>
                                            <option value="2">Service</option> -->
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Items in PO </label>
                                        <input type="text" id="no_of_po" name="no_of_po" class="form-control" onkeypress="return isNumber(event)" maxlength="3" value="">

                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Consignee</label>
                                        <input type="text" id="no_of_consignee" name="no_of_consignee" class="form-control" onkeypress="return isNumber(event)" maxlength="3" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
									
						
									</div>
								</div>
								
								<div class="wizard-footer">
									<div class="actions">
										<ul>
											<li><span class="js-btn-next" title="NEXT">NEXT <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>
								
							</div>
						</div>
						<!--single form panel-->
						
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>2 of 5 Completed</span>
										<div class="progress">
											<div class="progress-bar" style="width: 45%;"></div>
										</div>
									</div>
								</div>
							
								<div class="wizard-content-form">
								    	<div class="wizard-form-field">
<div class="tab">


                            

                                <div class="row">
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Elcot Item Code</label>
                                            <input type="text" id="item_code" name="item_code" class="form-control" value="" required="">
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
                                            <input type="text" id="po_name" name="po_name" class="form-control" value="" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Qty</label>
                                            <input type="text" id="qty" name="qty" class="form-control" onkeypress="return isNumber(event)" value="" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Unit Price</label>
                                            <input type="text" id="unit_price" name="unit_price" class="form-control" onkeypress="return isNumber(event)" value="" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Tax</label>
                                            <select class="form-select mb-3" id="tax" name="tax">
                                                <option value="" selected="">Select Tax</option><option value="18">18%</option><option value="28">28%</option><option value="No">Without Tax</option>                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Total Value</label>
                                            <input type="text" id="total_value" name="total_value" class="form-control" value="" required="" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 ">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Net Value</label>
                                            <input type="text" id="net_value" name="net_value" class="form-control" value="" required="" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 mt-4">
                                        <div class="mb-3">
                                        <input type="hidden" name="count" id="count">
                                            <button type="button" class="btn btn-success btn-label rounded-pill product_details_add_update_btn" onclick="product_details_add_update()"><i class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                Add New</button>
                                               
                                        </div>
                                    </div><!-- end col -->

                                    <div class="table-responsive mb-4">
                                        <div id="product_details_datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="product_details_datatable" class="table table-hover table-bordered align-middle table-nowrap mb-0 dataTable no-footer" width="100%" style="width: 100%;">
                                            <thead class="table-light">
                                                <tr><th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 0px;">ID </th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Elcot Item Code</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Product</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Qty</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Unit Price</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Tax </th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Total Value </th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Net Value </th><th scope="col" class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 0px;">Action </th></tr>
                                            </thead>
                                            <tbody>

                                            <tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No data available in table</td></tr></tbody>
                                        </table><div id="product_details_datatable_processing" class="dataTables_processing card" style="display: none;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></div></div><div class="row"><div class="col-sm-12 col-md-5"></div><div class="col-sm-12 col-md-7"></div></div></div>
                                    </div>

                                </div>
                            

                        </div>
								    </div>
								</div>
								
								
								
								<div class="wizard-footer">
								
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> BACK</span></li>
											<li><span class="js-btn-next" title="NEXT">NEXT <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
									<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>3 of 5 Completed</span>
										<div class="progress">
											<div class="progress-bar" style="width: 65%;"></div>
										</div>
									</div>
								</div>
								
								<div class="wizard-content-form">
								    <div class="wizard-form-field">
<div class="tab">
                            

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
                                            <input type="text" id="con_address" name="con_address" class="form-control" value="" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee District</label>
                                            <input type="text" id="con_district" name="con_district" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Pincode</label>
                                            <input type="text" id="con_pincode" name="con_pincode" class="form-control" onkeypress="return isNumber(event)" minlength="6" maxlength="6" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Contact Name </label>
                                            <input type="text" id="con_contact_name" name="con_contact_name" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Contact Number
                                            </label>
                                            <input type="text" id="con_contact_number" name="consignee_number" class="form-control" value="" onkeypress="return isNumber(event)" minlength="10" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Consignee Landline Number
                                            </label>
                                            <input type="text" id="con_lan_num" name="con_lan_num" class="form-control" value="" onkeypress="return isNumber(event)" minlength="10" maxlength="10">
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
                                        <button type="button" class="btn btn-success btn-label rounded-pill" onclick="consignee_details_add_update()"><i class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                            Add New</button>
                                    </div>
                                </div><!-- end col -->
                                <div class="table-responsive mb-4">
                                    <div id="consignee_details_datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="consignee_details_datatable" class="table table-hover table-bordered align-middle table-nowrap mb-0 dataTable no-footer" style="width: 0px;">
                                        <thead class="table-light">
                                            <tr><th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 0px;">ID </th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Consignee Address</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Consignee District</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Consignee Pincode</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">Consignee Contact Name</th><th scope="col" class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"> Contact Number </th><th scope="col" class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 0px;"> Action </th></tr>
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
                                        <tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No data available in table</td></tr></tbody>
                                    </table><div id="consignee_details_datatable_processing" class="dataTables_processing card" style="display: none;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></div></div><div class="row"><div class="col-sm-12 col-md-5"></div><div class="col-sm-12 col-md-7"></div></div></div>
                                </div>
                            </div>
                        
                    </div>
								</div>
								</div>
								
								
								<div class="wizard-footer">
								
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> BACK</span></li>
											<li><span class="js-btn-next" title="NEXT">NEXT <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>

							</div>
						</div>		
						<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>4 of 5 Completed</span>
										<div class="progress">
											<div class="progress-bar" style="width: 85%;"></div>
										</div>
									</div>
								</div>
								
								<div class="wizard-content-form">
								    <div class="wizard-form-field">
<div class="row">
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                                    name</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                                    Contact</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                                    Address</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                                    Landline</label></div>
                                            <div class="col-xl-1">:</div>
                                            <div class="col-xl-7"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="table-responsive mb-4">
                                       
                                            <table class="table table-striped">
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
                                       
                                   
                                </div>
                           </div>
								</div>
								</div>
								
								
								<div class="wizard-footer">
								
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> BACK</span></li>
											<li><span class="js-btn-next" title="NEXT">NEXT <i class="fa fa-arrow-right"></i></span></li>
										</ul>
									</div>
								</div>

							</div>
						</div>
						<!--single form panel-->
						<div class="multisteps-form__panel" data-animation="slideVert">
							<div class="inner pb-100">
								<div class="wizard-topper">
									<div class="wizard-progress">
										<span>5 of 5 Completed</span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
									</div>
								</div>
							
								<div class="wizard-content-form">
								    <div class="wizard-form-field">
<div class="row">
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Delivery Due Days</label>
                                    <input type="text" id="delivery_due_dates" name="delivery_due_dates" class="form-control" value="">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">LD% Per Day</label>
                                    <input type="text" id="ld_per_day" name="ld_per_day" class="form-control" value="">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">LD Maximum Value</label>
                                    <input type="text" id="ld_maximum_val" name="ld_maximum_val" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <input type="hidden" id="old_warranty" name="old_warranty" value="">

                                    <label for="main_screen" class="form-label">Warranty</label>
                                                                        <select class="form-select mb-3" id="warranty" name="warranty">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3" id="select_warranty">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Warranty Duration</label>
                                    <select class="form-select mb-3" id="warranty_duration" name="warranty_duration" value="">
                                        <option value="" selected="">Select Warranty</option><option value="121ddd257f2523460">1 Year</option><option value="62b55fe6098732h242">2 Year</option><option value="121ddd257f25900988">3 Year</option><option value="62b55fe60966547709">4 Year</option><option value="62b55fe60966500453">5 Year</option>                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <div class="form-group form-check  mt-3">
                                                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
                                        
                                        <label class="form-check-label" for="exampleCheck1">
                                            Installation Required
                                        </label>
                                    </div>
                                    <div class="form-group form-check  mt-2">
                                                                                <input type="checkbox" class="form-check-input bgcheckbox" id="exampleCheck2" name="exampleCheck2" onchange="valueChanged()">
                                                                                <label class="form-check-label" for="exampleCheck2">Bank Gurantee
                                            Required</label>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">Attach PO Copy </label>

                                    <input type="file" id="file" name="file" class="form-control dropify" value="">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3 bgdiv" id="bgdiv" style="display: none;">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">BG%</label>
                                    <input type="text" id="bg" name="bg" class="form-control" value="">
                                </div>
                            </div><!-- end col -->
                            <div class="col-xl-3 bgdiv1" id="bgdiv1" style="display: none;">
                                <div class="mb-3">
                                    <label for="main_screen" class="form-label">BG MONTHS </label>
                                    <input type="text" id="bg_month" name="bg_month" class="form-control" value="">
                                </div>
                            </div><!-- end col -->

                           



                        </div>

                                    </div>
								</div>
								
								<div class="wizard-footer">
								
									<div class="actions">
										<ul>
											<li><span class="js-btn-prev" title="BACK"><i class="fa fa-arrow-left"></i> BACK</span></li>
											<li><button type="submit" id="submit-form" title="NEXT">SUMBIT <i class="fa fa-arrow-right"></i></button></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
	</div>
</div>
		
	

	<script src="assets/js/main.js"></script>
	
	<script>
		$("#files").change(function() {
			filename = this.files[0].name
			console.log(filename);
		});
	</script>
