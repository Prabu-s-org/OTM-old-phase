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

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET['unique_id'];
        $invoice_no  = $_GET['invoice_no'];
        $where      = [
            "bill_form_unique_id" => $unique_id,
            "invoice_no" => $invoice_no
        ];


        $table      =  "view_payment_entry_list_1";

        $columns    = [

            'po_num',
            'po_date',
            'con_contact_name',
            'con_address',
            'invoice_no',
            'invoice_date',
            'invoice_value',
            'bill_submission_date',
            'e_no',
            'net_value',
            'qty',
            "dc_signed_date",
            "delivery_due_dates",
            // 'ld_per_day',
            // 'ld_maximum_val',
            "payement_receive",
            "payment_status",
            "payment_date",
            'bill_form_unique_id',
            "bill_no",
            "claim_amount",
            "invoice_qty",
            "consignee_unique_id"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
            $claim_amount    = $result_values[0]["claim_amount"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $invoice_qty         = $result_values[0]["invoice_qty"];
            $invoice_value          = $result_values[0]["invoice_value"];
            $consignee_unique_id    = $result_values[0]["consignee_unique_id"];
            $e_no          = $result_values[0]["e_no"];
            // $ld_per_day          = $result_values[0]["ld_per_day"];
            // $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
            $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"];
            $bill_form_unique_id    = $result_values[0]["bill_form_unique_id"];
            $bill_no    = $result_values[0]["bill_no"];
            $delivery_due_dates    = $result_values[0]["delivery_due_dates"];


            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));

            $orgDate1 = $result_values[0]["invoice_date"];
            $invoice_date = date("d-m-Y", strtotime($orgDate1));

            $orgDate2 = $result_values[0]["bill_submission_date"];
            $bill_submission_date = date("d-m-Y", strtotime($orgDate2));

            $dc_signed_date = $result_values[0]['dc_signed_date'];
            $dc_signed_date = date("d-m-Y", strtotime($dc_signed_date));



            $net_value = $result_values[0]['net_value'];

            $qty = $result_values[0]['qty'];
            // $po_date = $result_values[0]['po_date'];

            $delivery_due_dates = $result_values[0]['delivery_due_dates'];

            // $dc_signed_date = $result_values[0]['dc_signed_date'];

            $signedDate = new DateTime($dc_signed_date);

            $total_price = $net_value * $qty;

            // Create a DateTime object from the given PO date
            $poDate = DateTime::createFromFormat('d-m-Y', $po_date);

            // Add the specified number of days
            $poDate->modify('+' . $delivery_due_dates . ' days');

            // Display the result PO date
            $resultDate = $poDate->format('d-m-Y');
            // Display the result PO date
            // $resultDate = $poDate->format('d-m-Y');
            $poDate->setTime(0, 0);
            $signedDate->setTime(0, 0);
            // Calculate the difference between the result date and signed date
            $interval = $poDate->diff($signedDate);

            // Get the difference in days
            $lddays = $interval->format('%a');

            // Update the original array with the new calculated values
            $result_values[0]['net_value'] = $lddays;

            // Calculate the new value (25% of the total price)
            $ldvalue = $lddays * ($total_price * 0.0025);
            $result_values[0]['qty'] = $ldvalue;

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}


// $payemt_status=[
//     "1"=>"pending",
// ]
$payemt_status_option      = [
    // "0" => [
    //     "unique_id" => "0",
    //     "value"     => "Pending",
    // ],
    "Pending" => [
        "unique_id" => "1",
        "value"     => "Pending",
    ],
    "Completed" => [
        "unique_id" => "2",
        "value"     => "Completed",
    ],
];
$payemt_status_options     = select_option($payemt_status_option, "Select", $payment_status);


// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);

?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Payment Form</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Payment</li>
                </ol>
            </div>

        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-body">

                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $po_num  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $po_date ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee Name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $con_contact_name  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Location</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $con_address  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice No</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $invoice_no  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $invoice_date  ?></div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Value</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $invoice_value  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bill Submission Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $bill_submission_date  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">E No</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $e_no; ?> </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Days </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $result_values[0]['net_value'];?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Value </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $result_values[0]['qty'];?></div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Dc Signed Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $dc_signed_date;?></div>
                            </div> -->
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Delivery Due Days</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $delivery_due_dates;?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Payment Receivable</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $payement_receive  ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"]; -->
                <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                <input type="hidden" name="consignee_unique_id" id="consignee_unique_id" value="<?php echo $consignee_unique_id ?>">
				 <input type="hidden" name="ld_amount" id="ld_amount" value="<?php echo $result_values[0]['qty'];?>">
				<input type="hidden" name="ld_days" id="ld_days" value="<?php echo $result_values[0]['net_value']?>">
                <input type="hidden" id="bill_form_main_unique_id" name="bill_form_main_unique_id" class="form-control" value="<?php echo $bill_form_unique_id ?>">
                <input type="hidden" id="po_num" name="po_num" class="form-control" value="<?php echo $po_num ?>">
                        <input type="hidden" id="po_date" name="po_date" class="form-control" value="<?php echo $po_date ?>">
                        <input type="hidden" id="con_contact_name" name="con_contact_name" class="form-control" value="<?php echo $con_contact_name ?>">
                        <input type="hidden" id="con_address" name="con_address" class="form-control" value="<?php echo $con_address ?>">
                        <input type="hidden" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo $invoice_no ?>">
                        <input type="hidden" id="invoice_date" name="invoice_date" class="form-control" value="<?php echo $invoice_date ?>">
                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control" value="<?php echo $invoice_value ?>">
                        <input type="hidden" id="invoice_qty" name="invoice_qty" value="<?php echo $invoice_qty; ?>">
                      
                <input type="hidden" name="ins_unique_id" id="ins_unique_id" value="<?php echo $ins_unique_id ?>">
                    
                <!-- <input type="hidden" name="payment_date" id="payment_date" value="<?php echo $payment_date ?>"> -->
                <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo  $unique_id_data; ?>">
                      
                <hr />
                <?php
                        $where      = [
                            "bill_form_unique_id" => $unique_id,
                            "invoice_no" => $invoice_no,
                            // "ins_unique_id" => $ins_unique_id,
                        ];

                        $table_sub      =  "bill_submission_form";

                        $columns    = [
                            "installation_reference_no",
                            "supplier_invoice_number",
                            "unique_id",
                            "scanned_dc_copy",
                            "scanned_snr_copy",
                            "scanned_ir_copy",
                            "invoice_copy",
                            "claim_amount",
                            "ins_unique_id",
                        ];

                        $table_details   = [
                            $table_sub,
                            $columns
                        ];

                        $result_values_data  = $pdo->select($table_details, $where);
                        // print_r($result_values_data);die();

                        if ($result_values_data->status) {

                            $result_values_data      = $result_values_data->data;
                            $installation_reference_no    = $result_values_data[0]["installation_reference_no"];
                            $supplier_invoice_number          = $result_values_data[0]["supplier_invoice_number"];
                            $scanned_dc_copy         = $result_values_data[0]["scanned_dc_copy"];
                            $scanned_ir_copy         = $result_values_data[0]["scanned_ir_copy"];
                            $invoice_copy         = $result_values_data[0]["invoice_copy"];
                            $unique_id_data         = $result_values_data[0]["unique_id"];
                            $scanned_snr_copy         = $result_values_data[0]["scanned_snr_copy"];
                            $claim_amount_data         = $result_values_data[0]["claim_amount"];
                            // $exp_under_user_type  = explode(",", $under_user_type);

                            $btn_text           = "Update";
                            $btn_action         = "update";
                        } else {
                            $btn_text           = "Error";
                            $btn_action         = "error";
                            $is_btn_disable     = "disabled='disabled'";
                        }
                        if($claim_amount =='95'){
                        $claim_amount_options      = [
                            [
                                "id"    => '5',
                                "value"  => "5%"
                            ],
                            // [
                            //     "id"    => '25',
                            //     "value"  => "25%"
                            // ],
                            // [
                            //     "id"    => '75',
                            //     "value"  => "75%"
                            // ],
                            // [
                            //     "id"    => '95',
                            //     "value"  => "95%"
                            // ],
                            // [
                            //     "id"    => '100',
                            //     "value"  => "100%"
                            // ],
                        ];
                        $claim_amount_options    = select_option($claim_amount_options, "Select", $claim_amount_data);
                    }
                   else if($claim_amount=='75'){
                        $claim_amount_options      = [
                            [
                                "id"    => '25',
                                "value"  => "25%"
                            ],
                            [
                                "id"    => '20',
                                "value"  => "20%"
                            ],
                            // [
                            //     "id"    => '75',
                            //     "value"  => "75%"
                            // ],
                            // [
                            //     "id"    => '95',
                            //     "value"  => "95%"
                            // ],
                            // [
                            //     "id"    => '100',
                            //     "value"  => "100%"
                            // ],
                        ];
                        $claim_amount_options    = select_option($claim_amount_options, "Select", $claim_amount_data);
                    }
                        ?>
                     
                     
                <form class="was-validated" autocomplete="off">
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    
                                    <label for="main_screen" class="form-label">Scanned DC Copy </label>
                                    <!-- <input type="text" id="state_name" name="state_name" class="form-control" value="" > -->
                                    <input class="form-control mb-3" type="file" id="scanned_dc_copy" name="scanned_dc_copy" value="<?php echo $scanned_dc_copy  ?>">
                                    <!-- <select class="form-select mb-3" aria-label="Default select example" name="payment_status" id="payment_status">
                                        <?php echo $payemt_status_options ?> -->
                                        <!-- <option selected>Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option> -->
                                    <!-- </select> -->
                                </div>
                             
                          
                                <div class="col-xl-3">

                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Scanned Snr Copy</label>
                                        <input class="form-control" type="file" id="scanned_snr_copy" name="scanned_snr_copy" value="<?php echo $scanned_snr_copy; ?>">
                                     </div>
                                     </div><!-- end col -->



            


                                <div class="col-xl-3">
                                    <label for="exampleInputdate" class="form-label">Scanned IR Copy </label>
                                  
                                <input class="form-control" type="file" id="scanned_ir_copy" name="scanned_ir_copy" value="<?php echo $scanned_ir_copy ?>">
                                </div>


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                <label class="form-label">Invoice Copy</label>
                                <input class="form-control" type="file" id="invoice_copy" name="invoice_copy" value="<?php echo $invoice_copy ?>">
                            </div>
                        </div>
                        
                        <div class="col-xl-3">
                            <div class="mb-3">
                                <label for="exampleInputdate" class="form-label"> Elcot Installation Reference No </label>
                                <input type="text" id="installation_reference_no" name="installation_reference_no" class="form-control" value="<?php echo $installation_reference_no; ?>">
                            </div>
                        </div>
                       
                        <div class="col-xl-3">
                            <div class="mb-3">
                                <label for="exampleInputdate" class="form-label">Supplier Invoice Number </label>
                                <input type="text" id="supplier_invoice_number" name="supplier_invoice_number" class="form-control" value="<?php echo $supplier_invoice_number ?>">
                            </div>
                        </div>
                        <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Claim Amount</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="claim_amount" id="claim_amount">
                                        <?php echo $claim_amount_options ?>
                                        </select>
                                    </div>
                                </div>


                        <div class="col-xl-3">
                            <div style='display:none' ;>
                                <label for="exampleInputdate" class="form-label"></label>
                                <select name="bill_status" id="bill_status" class="select2 form-control">
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                        </div>

                                <!-- end col -->

                    
                                <div class="col-12 mt-3">
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                   
                                    <?php if ($unique_id_data != '') { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="partial_payment_cu()">Update</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="partial_payment_cu()">Save</button> 
                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                </div>
                </form>

                    
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
</div>
</div>

                      
<script>
   
    function partial_payment_cu(unique_id = "") {
	// alert();
		var internet_status = is_online();
	
		if (!internet_status) {
			sweetalert("no_internet");
			return false;
		}
		var ins_unique_id = document.getElementById('ins_unique_id').value;
		// alert(ins_unique_id);
		var bill_form_main_unique_id = document.getElementById('bill_form_main_unique_id').value;
        // alert(bill_form_main_unique_id);
		var po_num = document.getElementById('po_num').value;
        // alert(po_num);
		var po_date = document.getElementById('po_date').value;
        // alert(po_date);
		var con_contact_name = document.getElementById('con_contact_name').value;
        // alert(con_contact_name);
		var con_address = document.getElementById('con_address').value;
        // alert(con_address);
	
		var invoice_no = document.getElementById('invoice_no').value;
        // alert(invoice_no);
		var invoice_date = document.getElementById('invoice_date').value;
        // alert(invoice_date);
		var invoice_value = document.getElementById('invoice_value').value;
        // alert(invoice_value);
		// var file_name = document.getElementById('file_name').value;
        // alert(file_name);
		var consignee_unique_id = document.getElementById('consignee_unique_id').value;
		var invoice_qty = document.getElementById('invoice_qty').value;
		// alert(invoice_qty);
		var claim_amount = document.getElementById('claim_amount').value;
		// alert(claim_amount);
		// var invoice_copy = document.getElementById('invoice_copy').value;
		// var ir_status = document.getElementById('ir_status').value;
	  
		var installation_reference_no = document.getElementById('installation_reference_no').value;
			
		var supplier_invoice_number = document.getElementById('supplier_invoice_number').value;
		var unique_id = document.getElementById('unique_id').value;
        // alert(unique_id);
		var bill_status = document.getElementById('bill_status').value;
		// var snr_status = document.getElementById('snr_status').value;
		// alert(snr_status);
	
		// if((snr_status=='1')||(snr_status=='SNR')){
			var test_doc3 = document.getElementById('scanned_snr_copy').value;
			// }  
			// if(ir_status!='1'){
		   
		
			// }
			// else{
			// 	var test_doc3='';
			// }
	
			
		
	
		var test_doc = document.getElementById('scanned_dc_copy').value;
		// if(ir_status=='undefined'){
			// if((snr_status=='1')||(snr_status=='SNR')){
			// var test_doc1 = '';
			// }
			// else{
				var test_doc1 = document.getElementById("scanned_ir_copy");
			// }
		// alert(test_doc);
		// if(ir_status=='1'){
		//     var test_doc1 = document.getElementById('scanned_ir_copy').value;
		//     }
		// alert(test_doc1);
		var test_doc2 = document.getElementById('invoice_copy').value;
		//  alert(test_doc2);
		var image_s = document.getElementById("scanned_dc_copy");
	
		// if(ir_status=='undefined'){
			// if((snr_status=='1')||(snr_status=='SNR')){
			// var image_ir = '';
			// }
			// else{
				var image_ir = document.getElementById("scanned_ir_copy");
			// }
			// if(snr_status=='undefined' || snr_status=='' ){
				// if((snr_status=='1')||(snr_status=='SNR')){
				// var image_snr = '';
				// }
				// else{
					var image_snr = document.getElementById("scanned_snr_copy");
				// }
		// if(ir_status=='1'){
			
		//     }
		// var image_ir = document.getElementById("scanned_ir_copy");
		var image_in = document.getElementById("invoice_copy");
	
		if (test_doc != '' || test_doc1 != '' || test_doc2 != '' || test_doc3!='') {
			var data = new FormData();
			if(image_snr!= '') {
				for (var i = 0; i<image_snr.files.length; i++) {
					data.append("test_file3[]", document.getElementById('scanned_snr_copy').files[i]);
				}
			} else {
				data.append("test_doc3", '');
	
			}
	
			if (image_s != '') {
				for (var i = 0; i < image_s.files.length; i++) {
					data.append("test_file[]", document.getElementById('scanned_dc_copy').files[i]);
				}
			} else {
	
				data.append("test_doc", '');
	
			}
			if (image_ir != '') {
				for (var i = 0; i < image_ir.files.length; i++) {
					data.append("test_file1[]", document.getElementById('scanned_ir_copy').files[i]);
				}
			} else {
	
				data.append("test_doc1", '');
	
			}
			if (image_in != '') {
				for (var i = 0; i < image_in.files.length; i++) {
					data.append("test_file2[]", document.getElementById('invoice_copy').files[i]);
				}
			} else {
	
				data.append("test_doc2", '');
	
			}
			data.append("bill_form_main_unique_id", bill_form_main_unique_id);
			data.append("po_num", po_num);
			data.append("po_date", po_date);
			// data.append("consignee_unique_id", consignee_unique_id);
			data.append("con_contact_name", con_contact_name);
			data.append("ins_unique_id", ins_unique_id);
			//  data.append("con_contact_number", con_contact_number);
			data.append("con_address", con_address);
			data.append("invoice_no", invoice_no);
			data.append("invoice_date", invoice_date);
			// data.append("dc_no", dc_no);
			data.append("invoice_value", invoice_value);
			// data.append("file_name", file_name);
			data.append("consignee_unique_id", consignee_unique_id);
			data.append("invoice_qty", invoice_qty);
			data.append("claim_amount", claim_amount);
			data.append("bill_status", bill_status);
			data.append("installation_reference_no", installation_reference_no);
			data.append("unique_id", unique_id);// data.append("district", district);
			data.append("supplier_invoice_number", supplier_invoice_number);
	
			data.append("action", "createupdate");
	
			// var is_form = form_validity_check("was-validated");
	
			// if (is_form) {
	
	
			// var data 	 = $(".was-validated").serialize();
			// data 		+= "&unique_id="+unique_id+"&action=demo";
	
			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url = sessionStorage.getItem("list_link");
			// console.log(data);
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				beforeSend: function () {
					// 	$(".createupdate_btn").attr("disabled","disabled");
					// 	$(".createupdate_btn").text("Loading...");
				},
	
				success: function (data) {
	// alert(data);
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
	
					if (!status) {
						url = '';
						$(".createupdate_btn").text("Error");
						// console.log(error);
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
	
					sweetalert(msg, url);
				},
				error: function (data) {
					alert("Network Error");
				}
			});
	
	
		} else {
			sweetalert("form_alert");
		}
	}


    function print(file_name) {
        // 
        window.location = 'uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }

    function print_pdf(file_name) {

        onmouseover = window.open('uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
