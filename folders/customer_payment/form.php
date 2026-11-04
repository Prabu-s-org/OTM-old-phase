<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<style>
.hidden_1 {
    display: none;
}

.visible {
    display: block;
}
</style>
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
        $bill_no  = $_GET['bill_no'];
        $invoice_no  = $_GET['invoice_no'];
        // $ins_unique_id  = $_GET['ins_unique_id'];

        $where      = [
            "bill_form_unique_id" => $unique_id,
            "bill_no" => $bill_no,
            "invoice_no" => $invoice_no,
            // "ins_unique_id" => $ins_unique_id,
            
        ];


        $table      =  "view_payment_entry_list";

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
            // 'qty',
            "(select sum(invoice_qty) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND is_delete='0' group by po_unique_id) as qty",
            // "unit_price",
            "(select sum(unit_price) from invoice_creation as invoice_creation where invoice_no= $table.invoice_no AND is_delete=0 group by invoice_no) as unit_price_val",
            // "dc_signed_date",
            "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table.invoice_no AND is_delete=0 group by bill_form_unique_id) as dc_signed_date",
            "delivery_due_dates",
            // 'ld_per_day',
            // 'ld_maximum_val',
            "gst",
            "gst_value",
            "tds",
            "tds_value",
            "ld",
            "tran_amt",
            // tran_amt
            "rem_amt",
            "payement_receive",
            "payment_status",
            "payment_date",
            'bill_form_unique_id',
            "bill_no",
            "claim_amount",
              "main_invoice_no",
            "(select cancel_invoice_no from bill_submission_main_table as bill where bill.bill_no= $table.bill_no AND is_delete=0 group by bill_form_unique_id) as cancel_invoice_no",
            "ins_unique_id",
            "file_name",
            "file_org_name",
            // "(select sum(delivery_due_days) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no  group by invoice_no) as product_delivery_due_days",
            
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
            $claim_amount    = $result_values[0]["claim_amount"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];

            $invoice_qty          = $result_values[0]["invoice_qty"];
            $invoice_val         = $result_values[0]["invoice_value"];

            // $invoice_date          = $result_values[0]["invoice_date"];
            // $invoice_value          = $result_values[0]["invoice_value"];
            $invoice_value_amt       = moneyFormatIndia($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt ;
            $unit_price_val    = $result_values[0]["unit_price_val"];
            $e_no          = $result_values[0]["e_no"];
            // $ld_per_day          = $result_values[0]["ld_per_day"];
            // $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
            $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"];
            $bill_form_unique_id    = $result_values[0]["bill_form_unique_id"];
            $bill_no    = $result_values[0]["bill_no"];
            $delivery_due_dates    = $result_values[0]["delivery_due_dates"];
            $gst = $result_values[0]["gst"];
            $gst_value = $result_values[0]["gst_value"];
            $tds = $result_values[0]["tds"];
            $tds_value = $result_values[0]["tds_value"];
            $ld = $result_values[0]["ld"];
            $rem_amt = $rem_amt[0]["rem_amt"];
            $tran_amt = $tran_amt[0]["tran_amt"];
            // tran_amt
            $cancel_invoice_no          = $result_values[0]["cancel_invoice_no"];
            $invoice_nos = $result_values[0]["main_invoice_no"];


            $file_name         = $result_values[0]["file_name"];
            // print_r($file_name);die();
            // echo $file_name;
        //   $file_name_show = image_view_file_name("payment", $result_values[0]['bill_no'], $result_values[0]['file_name']);
                        //    print_r( $file_name_show);die();

        // $file_org_name         = $result_values[0]["file_org_name"];

            // $ir_file         = $result_values_data[0]["ir_file"];
            // $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);


           


            //gst value
            $where_1 = [
                // "po_unique_id" => $bill_form_unique_id,
                // "consignee_id" => $consignee_unique_id,
                "invoice_no"  => $invoice_no,

            ];


            $table_1 = "invoice_creation";

            $columns_1 = [
                "sum(unit_price) as unit_price",
                "sum(invoice_qty) as invoice_qty",
                "sum(invoice_qty_value) as invoice_qty_value"
                // "unit_price",
                // "invoice_qty"
            ];

            $table_details_1 = [
                $table_1,
                $columns_1
            ];

            $result_values_21 = $pdo->select($table_details_1, $where_1);
            // print_r($result_values_21);die();


            if ($result_values_21->status) {

                $result_values_21 = $result_values_21->data;

                $unit_price = $result_values_21[0]["unit_price"];

                $invoice_qty = $result_values_21[0]["invoice_qty"];

                $invoice_qty_value = $result_values_21[0]["invoice_qty_value"];
                // print_r($unit_price);die();

            }
            // get value end


            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));

            $orgDate1 = $result_values[0]["invoice_date"];
            $invoice_date = date("d-m-Y", strtotime($orgDate1));

            $orgDate2 = $result_values[0]["bill_submission_date"];
            $bill_submission_date = date("d-m-Y", strtotime($orgDate2));

            $dc_signed_date = $result_values[0]['dc_signed_date'];
           
                if($dc_signed_date==''){
                    $dc_signed_date = '';
                }
                else{
                    $dc_signed_date = date("d-m-Y", strtotime($dc_signed_date));

                }
                // print_r( $dc_signed_date );die();
            $net_value = $result_values[0]['net_value'];

            $qty = $result_values_21[0]["invoice_qty"];
            // print_r( $qty);die();
            // $po_date = $result_values[0]['po_date'];

        //  new change               //  
        $delivery_due_dates = $result_values[0]['delivery_due_dates'];

// if ($delivery_due_datess!="") {
//     $delivery_due_dates = $result_values[0]['delivery_due_dates'];
// } else {
//     $delivery_due_dates = $result_values[0]['product_delivery_due_days'];
// }

// end

            // $dc_signed_date = $result_values[0]['dc_signed_date'];

            $signedDate = new DateTime($dc_signed_date);

            $total_price = $net_value * $qty;

            // Create a DateTime object from the given PO date
            $poDate = DateTime::createFromFormat('d-m-Y', $po_date);

            // Add the specified number of days
            $poDate->modify('+' . $delivery_due_dates . ' days');
            $duedate = $poDate->format('d-m-Y');
            $duedate1 = new DateTime($duedate);
            // print_r($duedate1);
            $poDate->modify('+' . $delivery_due_dates . ' days');
            $interval = $duedate1->diff($signedDate);

                if($signedDate>$duedate1){
                    $lddays =  $interval->format('%a');
                    
                  }
                  else if($signedDate=$duedate1){
                    $lddays=0;
                    
                  }
                  else{
                    $lddays=0;
                  }
            // Update the original array with the new calculated values
            $result_values[0]['net_value'] = $lddays;

            if($lddays>40){
                // echo "hi";
                $ldvalue = $lddays *$qty* ($unit_price_val *  0.1);  
            }
            else{
                // echo "hlo";
                $ldvalue = $lddays *$qty* ($unit_price_val * 0.0025);
            }
            // print_r($unit_price);die();
            // $d=$lddays *$qty;
            // print_r( $d);
            // $d1= ($d*($unit_price * 0.0025));
            // print_r( $d1);die();
            // Calculate the new value (25% of the total price)
        //   print_r($ldvalue);die();
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

$tax_select_options =
    [
        // "" => [
        //     "unique_id" => "",
        //     "value" => "",
        // ],
        "2%" => [
                "unique_id" => "2",
                "value" => "2%",
            ],
        //     "28%" => [
        // "unique_id" => "28",
        // "value"     => "28%",
        //     ],
        //     "Without Tax" => [
        // "unique_id" => "No",
        // "value"     => "Without Tax",
        //     ],
    ];

$tax_select_options = select_option($tax_select_options,"Select Option");

$tax_select_options_tds =
    [
        // "" => [
        //     "unique_id" => "",
        //     "value" => "",
        // ],
        "10%" => [
                "unique_id" => "10",
                "value" => "10%",
            ],
            "2%" => [
                "unique_id" => "2",
                "value" => "2%",
            ],

    ];
$tax_select_options_tds = select_option($tax_select_options_tds,"Select Option");

// $payemt_status=[
//     "1"=>"pending",
// ]
$payemt_status_option      = [
    // "0" => [
    //     "unique_id" => "0",
    //     "value"     => "Pending",
    // ],
    "Rejected" => [
        "unique_id" => "1",
        "value"     => "Rejected",
    ],
    "Completed" => [
        "unique_id" => "2",
        "value"     => "Completed",
    ],
    // "Completed" => [
    //     "unique_id" => "",
    //     "value"     => "Completed",
    // ],
];
$payemt_status_options     = select_option($payemt_status_option, "Select", $payment_status);


// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);




?>
            <?php
                                    $where1 = "po_unique_id = '" . $unique_id . "' AND invoice_no = '" . $invoice_no . "'";
											$table1      =  "invoice_creation";

											$columns1    = [
												"item_code",
												"product",
												"unit_price",
                                                "invoice_qty",
                                                "delivery_due_days",
                                                "po_date",	
                                                // "po_num",
                                                // "(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = $table1.form_main_unique_id ) AS delivery_due_dates",
									 "(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = $table1.po_unique_id group by  po_unique_id) AS delivery_due_dates_org ",
                                     "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table1.invoice_no AND is_delete=0 group by po_unique_id) as dc_signed_date",
											
									// "(SELECT po_date FROM po_form WHERE po_form.unique_id = " . $table1 . ".po_unique_id ) AS po_date",
											];

											$table_details1   = [
												$table1,
												$columns1
											];
											$values_product  = $pdo->select($table_details1, $where1);
											// print_r($values_product);
											if ($values_product->status) {

												$product_array      = $values_product->data;
                                                $ld_total = 0;
                                                $ld_daystotal=0;
												foreach ($product_array as $key => $product) {
                                                        $s_no = $sno + 1;
                                                      

                                                        $unit_price_val = $product['unit_price'];

                                                $dc_signed_date = $product['dc_signed_date'];
           
                                                if($dc_signed_date==''){
                                                    $dc_signed_date = '';
                                                }
                                                else{
                                                    $dc_signed_date = date("d-m-Y", strtotime($dc_signed_date));
                                
                                                }
                                            $qty = $product["invoice_qty"];
                                            // print_r( $qty);die();
                                        //  new change               //  
                                        $delivery_due_days_1 = $product['delivery_due_dates_org'];           
                                        if ($delivery_due_days_1 != '') {
                                            $delivery_due_days = (int)$product['delivery_due_dates_org'];
                                        } else {
                                            $delivery_due_days = (int)$product['delivery_due_days'];
                                        }
                                        $product['delivery_due_days']= $delivery_due_days;

                                     // end
                                     $po_date = $product['po_date'];
                                    //  print_r($po_date );
                                            // $dc_signed_date = $product['dc_signed_date'];
                                
                                            $signedDate = new DateTime($dc_signed_date);
                                            // Create a DateTime object from the given PO date
                                            $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
                                
                                            // Add the specified number of days
                                            $poDate->modify('+' .  $product['delivery_due_days'] . ' days');
                                            $duedate = $poDate->format('d-m-Y');
                                            $product['po_date']=     $duedate;

                                            $duedate1 = new DateTime($duedate);
                                            // print_r($duedate1);
                                           $poDate->modify('+' .  $product['delivery_due_days'] . ' days');
                                            $interval = $duedate1->diff($signedDate);
                                            // print_r(  $interval);
                                          
                                            
                                            // print_r(   $duedate);

                                                if($signedDate>$duedate1){
                                                    $lddays =  $interval->format('%a');
                                                    
                                                  }
                                                  else if($signedDate=$duedate1){
                                                    $lddays=0;
                                                    
                                                  }
                                                  else{
                                                    $lddays=0;
                                                  }
                                                  $ld_daystotal +=  $lddays; 
                                                //   print_r($lddays);
                                            // Update the original array with the new calculated values
                                            $product['delivery_due_dates_org'] = $ld_daystotal;
                                
                                            if($lddays>40){
                                                // echo "hi";
                                                $ldvalue = $lddays *$qty* ($unit_price_val *  0.1);  
                                            }

                                            else{
                                                // echo "hlo";
                                                $ldvalue = $lddays *$qty* ($unit_price_val * 0.0025);
                                            }
                                           // Sum up the ld values
                                         $ld_total += $ldvalue; 
                                           
                                            $product['dc_signed_date'] =   $ld_total;
                                          
                                            $delivery_due_days_total =$product['delivery_due_days'];
                                                // Sum up the ld values
                                         $delivery_due_days_sum += $delivery_due_days_total; 


                                        }
                                    }
                                    // echo "Total LD Value: " . $ld_total; die();

                                    if ($result_values[0]['delivery_due_dates'] != '') {
                                        $ldvalue_new =  $result_values[0]['qty'];
                                    } else {
                                        $ldvalue_new = $product['dc_signed_date'];
                                    }


                                    if ($result_values[0]['delivery_due_dates'] != '') {
                                        $lddays_new =    $result_values[0]['net_value'];
                                    } else {
                                        $lddays_new =  $product['delivery_due_dates_org'];
                                    }

                                    if ($result_values[0]['delivery_due_dates'] != '') {
                                        $delivery_due_days_sum_total =    $result_values[0]['delivery_due_dates'] ;
                                    } else {
                                        $delivery_due_days_sum_total =   $delivery_due_days_sum;
                                    }

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
                                <input type="hidden" name="my_inv_no" id="my_inv_no" value="<?php echo $invoice_no ?>">
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
                            <?php //if($result_values[0]["delivery_due_dates"]!=''){?>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Days </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $lddays_new;?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Value </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $ldvalue_new;?></div>
                            </div>
                            <?php //} ?>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Dc Signed Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $dc_signed_date;?></div>
                            </div>
                            <?php //if($result_values[0]["delivery_due_dates"]!=''){?>
                            <!-- <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Delivery Due Days</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $delivery_due_days_sum_total;?></div>
                            </div> -->
                            <?php //} ?>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Payment Receivable</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $payement_receive  ?></div>
                                <?php echo $file_name_show; ?>
                                        <?php echo  $file_org_name; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($result_values[0]["delivery_due_dates"]==''){?>
                <div class="row">
						<div class="col-12 mt-3">
							<div class="table-responsive mb-4">
								<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
									<thead class="table-light">
										<tr>
											<th>S.No</th>
											<th scope="col">Item Code</th>
											<th scope="col">Item Details</th>
											<!--<th scope="col">QTY</th>-->
											<!-- <th scope="col">Request to Stock QTY </th> -->
											<th scope="col">Unit Price</th>
                                            <th scope="col">Invoice Qty</th>
											<th scope="col">Delivery Due Days </th>
                                            <th scope="col">Delivery Due date</th>
                                            <th scope="col">Delivery Days </th>

                                            <th scope="col">LD Days </th>

                                            <th scope="col">Ld Value</th>

										</tr>
									</thead>
									<tbody>

										<?php
										// $get_stock_position   = get_stock_position($main_unique_id);
										// foreach ($get_stock_position as $key => $form_val) {

											$where1 = "po_unique_id = '" . $unique_id . "' AND invoice_no = '" . $invoice_no . "'";
											$table1      =  "invoice_creation";

											$columns1    = [
												"item_code",
												"product",
												"unit_price",
                                                "invoice_qty",
                                                "delivery_due_days",
                                                "po_date",	
                                                // "po_num",
                                                // "(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = $table1.form_main_unique_id ) AS delivery_due_dates",
									 "(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = $table1.po_unique_id group by  po_unique_id) AS delivery_due_dates_org ",
                                     "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table1.invoice_no AND is_delete=0 group by po_unique_id) as dc_signed_date",
											
									// "(SELECT po_date FROM po_form WHERE po_form.unique_id = " . $table1 . ".po_unique_id ) AS po_date",
											];

											$table_details1   = [
												$table1,
												$columns1
											];
											$values_product  = $pdo->select($table_details1, $where1);
											// print_r($values_product);
											if ($values_product->status) {

												$product_array      = $values_product->data;

												foreach ($product_array as $key => $product) {
                                                        $s_no = $sno + 1;
                                                      

                                                        $unit_price_val = $product['unit_price'];

                                                $dc_signed_date = $product['dc_signed_date'];
           
                                                if($dc_signed_date==''){
                                                    $dc_signed_date = '';
                                                }
                                                else{
                                                    $dc_signed_date = date("d-m-Y", strtotime($dc_signed_date));
                                
                                                }
                                            $qty = $product["invoice_qty"];
                                            // print_r( $qty);die();
                                        //  new change               //  
                                        $delivery_due_days_1 = $product['delivery_due_dates_org'];           
                                        if ($delivery_due_days_1 != '') {
                                            $delivery_due_days = (int)$product['delivery_due_dates_org'];
                                        } else {
                                            $delivery_due_days = (int)$product['delivery_due_days'];
                                        }
                                        $product['delivery_due_days']= $delivery_due_days;

                                     // end
                                     $po_date = $product['po_date'];
                                    //  print_r($po_date );
                                            // $dc_signed_date = $product['dc_signed_date'];
                                
                                            $signedDate = new DateTime($dc_signed_date);
                                            // Create a DateTime object from the given PO date
                                            $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
                                


                                           // new changes 30_09_2024
                                           $interval_del_days = $signedDate->diff($poDate);
                                           $daysDifference = $interval_del_days->days + 1;
                                           
                                        //    $delivery_due_days = $product['delivery_due_days'];
                                        //    $finalDueDays = $daysDifference -  $product['delivery_due_days']; // Direct subtraction
                                           


                                            // Add the specified number of days
                                            $poDate->modify('+' .  $product['delivery_due_days'] . ' days');
                                            $duedate = $poDate->format('d-m-Y');
                                            $product['po_date']=     $duedate;

                                            $duedate1 = new DateTime($duedate);
                                            // print_r($duedate1);
                                           $poDate->modify('+' .  $product['delivery_due_days'] . ' days');
                                            $interval = $duedate1->diff($signedDate);
                                            // print_r(  $interval);
                                          
                                            
                                            // print_r(   $duedate);

                                                if($signedDate>$duedate1){
                                                    $lddays =  $interval->format('%a');
                                                    
                                                  }
                                                  else if($signedDate=$duedate1){
                                                    $lddays=0;
                                                    
                                                  }
                                                  else{
                                                    $lddays=0;
                                                  }
                                                //   print_r($lddays);
                                            // Update the original array with the new calculated values
                                            $product['delivery_due_dates_org'] = $lddays;
                                
                                            if($lddays>40){
                                                // echo "hi";
                                                $ldvalue = $lddays *$qty* ($unit_price_val *  0.1);  
                                            }

                                            else{
                                                // echo "hlo";
                                                $ldvalue = $lddays *$qty* ($unit_price_val * 0.0025);
                                            }
                                            // print_r($unit_price);die();
                                            // $d=$lddays *$qty;
                                            // print_r( $d);
                                            // $d1= ($d*($unit_price * 0.0025));
                                            // print_r( $d1);die();
                                            // Calculate the new value (25% of the total price)
                                        //   print_r($ldvalue);die();
                                            $product['dc_signed_date'] = $ldvalue;		
										?>
														<tr>
															<td><?php echo $s_no ?></td>
															<td><?php echo $product['item_code'] ?></td>
															<td><?php echo $product['product'] ?></td>
															<td><?php echo $product['unit_price'] ?></td>
                                                            <td><?php echo $product['invoice_qty'] ?></td>
															<td><?php echo  $product['delivery_due_days']; ?></td>
                                                            
                                                            <td><?php echo   $product['po_date']; ?></td>
                                                            <td><?php echo     $daysDifference; ?></td>
                                                          
                                                            <td><?php echo   $product['delivery_due_dates_org']; ?></td>
															<td><?php echo  $product['dc_signed_date'];  ?></td>

														</tr>
										<?php
														$sno++;
													}
												}
											// }
										// }
										?>
									</tbody>
								</table>
							</div>
                            <?php }?>
            
                     
                <!-- $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"]; -->
            
                <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $bill_form_unique_id ?>">
				 <input type="hidden" name="ld_amount" id="ld_amount" value="<?php echo $ldvalue_new ;?>">
				<input type="hidden" name="ld_days" id="ld_days" value="<?php echo $lddays_new;?>">
                <input type="hidden" name="claim_amount" id="claim_amount" value="<?php echo $result_values[0]['claim_amount']?>">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
                <input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo  $invoice_date  ?>">
                <input type="hidden" name="cancel_invoice_no" id="cancel_invoice_no"
                    value="<?php echo $cancel_invoice_no ?>">
                <input type="hidden" name="invoice_qty" id="invoice_qty" value="<?php echo $invoice_qty ?>">
                <input type="hidden" name="invoice_val" id="invoice_val" value="<?php echo $invoice_val ?>">
                <!-- <input type="text" name="ldvalue" id="ldvalue" value="<?php echo $ldvalue_new ?>">
                <input type="text" name="lddays" id="lddays" value="<?php echo $lddays_new ?>"> -->
                <!-- <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                 
                    <input type="hidden" name="payment_status" id="payment_status" value="<?php echo $payment_status ?>"> -->
                <!-- <input type="hidden" name="payment_date" id="payment_date" value="<?php echo $payment_date ?>"> -->
                <hr />

                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">


                                <div class="col-lg-3">
                                    <label for="main_screen" class="form-label">Current Status </label>
                                    <!-- <input type="text" id="state_name" name="state_name" class="form-control" value="" > -->

                                    <select class="form-select mb-3" aria-label="Default select example" name="payment_status" id="payment_status" onchange="toggleRejectedFields()">
                                        <?php echo $payemt_status_options ?>
                                        <!-- <option selected>Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option> -->
                                    </select>
                                    <label for="main_screen" class="form-label">Transacation Amount</label>
                                            <input type="number" id="tran_amt" name="tran_amt" class="form-control"
                                            value="<?php echo $tran_amt ?>" step="any" required>
                                </div>
                                </br></br>

                                <div class="col-xl-3 hidden_1" id="rejected_reason_section">
                                    <div class="mb-3">
                                        <label class="form-label">Rejected reason</label>

                                        <textarea name="reject_reason" id="reject_reason"
                                            class="form-control "></textarea>
                                    </div>
                                </div><!-- end col -->

                                <div class="col-xl-3 hidden_1" id="cancel_bill_section" id="images">
                                    <div class="col-md-12" style="margin-top:30px">

                                        <!-- <label class="form-label">Rejected reason</label> -->
                                        <!-- <input type="text" id="reject_invoice_no" name="reject_invoice_no[]"
                                        class="form-control" > -->
                                        <button type="button" class="btn btn-primary " onclick="cancel_bill()">bill
                                            cancel </button>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-3 hidden_1" id="invoice_section">
                                    <div class="mb-3">
                                        <label for="main_screen" style="display:none" class="form-label"> Total Invoice
                                            no</label>
                                        <input type="text" id="main_invoice_no" name="main_invoice_no"
                                            class="form-control" value="<?php echo $invoice_nos ; ?>">

                                        <input type="text" id="remaing_main_invoice_no" name="remaing_main_invoice_no"
                                            class="form-control">

                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST %</label>
                                            <select class="form-select mb-3" aria-label="Default select example"
                                                name="gst" id="gst" onchange="getGst_value()" required>
                                                <?php echo $tax_select_options ?>

                                            </select>
                                            <input type="hidden" id="unit_price" name="unit_price" class="form-control"
                                                value="<?php echo $unit_price; ?>">
                                                <input type="hidden" id="invoice_qty_value" name="invoice_qty_value" class="form-control"
                                                value="<?php echo $invoice_qty_value; ?>">
                                            <input type="hidden" id="qty" name="qty" class="form-control"
                                                value="<?php echo $invoice_qty; ?>">
                                                

                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST Value </label>
                                            <input type="text" id="gst_value" name="gst_value" class="form-control"
                                                value="<?php echo $gst_value ?>" readonly required>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">TDS %</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="tds"
                                            id="tds" onchange="getTds_value()" required>
                                            <?php echo $tax_select_options_tds ?>

                                        </select>
                                        <!-- <input type="text" id="gst" name="gst" class="form-control" value=""> -->
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">TDS Value </label>
                                        <input type="text" id="tds_value" name="tds_value" class="form-control"
                                            value="<?php echo $tds_value ?>" readonly required>
                                    </div>
                                </div><!-- end col -->
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">LD Deducted by Elcot</label>
                                        <input type="number" id="ld" name="ld" class="form-control" 
                                            value="<?php echo $ld ?>" onchange="cal_rem()" step="any" required>
                                            <input type="hidden" id="ld_value" name="ld_value" class="form-control" 
                                            value="<?php echo $ld ?>">
                                    </div>
                                </div><!-- end col -->


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Payment Received from ELCOT </label>
                                        <input type="text" id="payement_receive" name="payement_receive" class="form-control" value="<?php echo $payement_receive ?>"
                                        onchange="cal_rem()" step="any" required>
                                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control"
                                        value="<?php echo $invoice_value ?>">
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-3">
                                <div class="mb-3">
                                        <label for="main_screen" class="form-label">Remaning Amt</label>
                                        <input type="number" id="rem_amt" name="rem_amt"
                                            class="form-control" value="<?php echo $rem_amt ?>" readonly>
                                            </div>
                                    </div>
                                    <div class="row">
                                <div class="col-xl-3">
                                    <label for="exampleInputdate" class="form-label">Payment Received Date</label>
                                    <input type="date" class="form-control" id="payment_date" name="payment_date" onchange="get_validate_date()" value="<?php echo $payment_date; ?>" >
                                    <p style="color:red" id="pay_err"></p>
                                    <p style="color:green" id="pay_err1"></p>
                                </div>
                                <div class="col-xl-3" id="images">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Receipt </label>

                                        <input type="file" id="file" accept="application/pdf" name="file" class="form-control " value="<?php echo $file_org_name; ?>" required>
                                       
                                    </div>
                                </div><!-- end col -->
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-12" align="right">
                                        <!-- Cancel,save and update Buttons -->
                                        <?php echo btn_cancel($btn_cancel); ?>
                                        <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                        <?php if ($bill_form_unique_id) { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="payment_cu()">Update</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="payment_cu()">Save</button>

                                        <?php } ?>
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
   
function get_validate_date(){
        $('#pay_err').empty();
        $('#pay_err1').empty();
        // alert("hii");
        
        var invoice_dates = document.getElementById('invoice_date').value;
        // alert(invoice_dates);
        var curr_payment_dates = document.getElementById('payment_date').value;
        var x = curr_payment_dates.split("-").reverse().join("-");
        // alert(x);
       
//         var invoice_date = new Date(invoice_dates);
//         alert(invoice_date);
//         var curr_payment_date = new Date(curr_payment_dates);
        
// var firstYear = invoice_dates.getFullYear();
// var firstMonth = invoice_dates.getMonth();
// var firstDay = invoice_dates.getDate();
// var secondYear = curr_payment_dates.getFullYear();
// var secondMonth = curr_payment_dates.getMonth();
// var secondDay = curr_payment_dates.getDate();
dateFirst = invoice_dates.split('-');
dateSecond = x.split('-');
// var value = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
// var current = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);
// alert(dateFirst[2]);
// alert(dateFirst[1]);
// alert(dateFirst[0]);
        if(dateFirst[2] >= dateSecond[2] && dateFirst[1] >= dateSecond[1] && dateFirst[0] >= dateSecond[0]){
            // if(dateSecond[2] <= dateFirst[2]   && dateSecond[1] <=  dateFirst[1] && dateSecond[0] <= dateFirst[0]){
            // alert("Change Payment Date");
            $('#pay_err').append("Lesser Than Invoice Date So Change Payment Date");
            // $('#pay_err1').hide();
        }else {
            // alert("done");
            
            $('#pay_err1').append("done");
            // $('#pay_err').hide();
        }

    }
function cal_rem() {
    // Helper function to remove commas from a number string and convert to float
    function parseNumber(value) {
        return parseFloat(value.replace(/,/g, '')) || 0;
    }

    // Retrieve and parse values
    let gst_value = parseNumber(document.getElementById("gst_value").value);
    // alert(gst_value);
    let tds_value = parseNumber(document.getElementById("tds_value").value);

    let ld = parseNumber(document.getElementById("ld").value);
    // alert(ld);
    let payement_receive = parseNumber(document.getElementById("payement_receive").value);
    // alert(payement_receive);
    let invoice_value = parseNumber(document.getElementById("invoice_value").value);
    
   // alert(invoice_value);

    // // Debugging: Print values to check their correctness
    // console.log("GST Value: " + gst_value);
    // console.log("TDS Value: " + tds_value);
    // console.log("LD: " + ld);
    // console.log("Payment Received: " + payement_receive);
    // console.log("Invoice Value: " + invoice_value);

    // Calculate total deduction
    let total_deduction = invoice_value - (gst_value + tds_value + ld + payement_receive);
    // console.log("Total Deduction: " + total_deduction);

    // Set the remaining amount in the corresponding input field
    document.getElementById("rem_amt").value = total_deduction;
}




     function getGst_value() {
        // let unitPrice = document.getElementById("unit_price").value;
        // alert(unitPrice);
        let invoice_qty_value = document.getElementById("invoice_qty_value").value;
// alert(invoice_qty_value);
        // Calculate the GST value
        // let gstValue = (unitPrice * qty * 0.02);
        let gstValue = (invoice_qty_value*0.02);
    
//    alert(gstValue);

        // Set the calculated GST value to the input field
        document.getElementById("gst_value").value = gstValue.toFixed(2);

    }


    // function getTds_value() {
    //     // let unitPrice = document.getElementById("unit_price").value;
    //     // let qty = document.getElementById("qty").value;
    //     let invoice_qty_value = document.getElementById("invoice_qty_value").value;


    //     // Calculate the GST value
    //     // let gstValue = (unitPrice * qty * 0.1);
    //     let gstValue = (invoice_qty_value*0.1);
        
    //     // Set the calculated GST value to the input field
    //     document.getElementById("tds_value").value = gstValue.toFixed(2);

    // }
    function getTds_value() {
    let invoice_qty_value = document.getElementById("invoice_qty_value").value;
    let tdsSelect = document.getElementById("tds");
    let selectedTds = tdsSelect.value; // Get the selected TDS percentage

    // Parse the selected TDS percentage to a decimal for calculation
    let tdsPercentage = parseFloat(selectedTds) / 100;

    // Calculate the TDS value
    let tdsValue = invoice_qty_value * tdsPercentage;

    // Set the calculated TDS value to the input field
    document.getElementById("tds_value").value = tdsValue.toFixed(2);
}


    
    function payment_cu() {
    var internet_status = is_online();

    // Get element values safely
    var unique_id = document.getElementById('unique_id')?.value || '';
    var payment_receive = document.getElementById('payement_receive')?.value || '';
    var claim_amount = document.getElementById('claim_amount')?.value || '';
    var payment_status = document.getElementById('payment_status')?.value || '';
    var payment_date = document.getElementById('payment_date')?.value || '';
    var ld_amount = document.getElementById('ld_amount')?.value || '';
    var ld_days = document.getElementById('ld_days')?.value || '';
    var gst = document.getElementById('gst')?.value || '';
    var gst_value = document.getElementById('gst_value')?.value || '';
    var tds = document.getElementById('tds')?.value || '';
    var tds_value = document.getElementById('tds_value')?.value || '';
    var ld = document.getElementById('ld')?.value || '';
    var tran_amt = document.getElementById('tran_amt')?.value || '';
    var rem_amt = document.getElementById('rem_amt')?.value || '';
    var my_inv_no = document.getElementById('my_inv_no')?.value || '';
    var bill_no = document.getElementById('bill_no')?.value || '';

    var ld_days = document.getElementById('lddays')?.value || '';
    var ld_value = document.getElementById('ldvalue')?.value || '';
    // <input type="text" name="ldvalue" id="ldvalue" value="<?php echo $ldvalue_new ?>">
    // <input type="text" name="lddays" id="lddays" value="<?php echo $lddays_new ?>">
    // Debugging: Check values of GST and TDS
    // console.log("GST Value:", gst);
    // console.log("TDS Value:", tds);

    // if (gst && tds) {
        var data = new FormData();
        var image_s = document.getElementById("file");

        // Check and append files
        if (image_s && image_s.files.length > 0) {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("file", image_s.files[i]);
            }
        } else {
            data.append("file", '');
        }

        // Append all other fields
        data.append("my_inv_no", my_inv_no);
        data.append("unique_id", unique_id);
        data.append("payment_date", payment_date);
        data.append("payment_receive", payment_receive);
        data.append("bill_no", bill_no);
        data.append("payment_status", payment_status);
        data.append("ld_amount", ld_amount);
        data.append("ld_days", ld_days);
        data.append("claim_amount", claim_amount);
        data.append("gst", gst);
        data.append("gst_value", gst_value);
        data.append("tds", tds);
        data.append("tds_value", tds_value);
        data.append("ld", ld);
        data.append("tran_amt", tran_amt);
        data.append("rem_amt", rem_amt);

        data.append("ld_days", ld_days);
        data.append("ld_value", ld_value);

        data.append("action", "createupdate");

        // Check form validity
        var is_form = form_validity_check("was-validated");
        if (is_form) {
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                beforeSend: function() {
                    $(".bg_add_update_btn").attr("disabled", "disabled").text("Loading...");
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    // Swal.fire(msg, '', 'success');
                    sweetalert(msg, url);
                },
                error: function() {
                    Swal.fire("Error", "Network Error", "error");
                }
            });
        } else {
            sweetalert("form_alert");
        }
    // } else {
    //     Swal.fire( "Please fill in both GST and TDS fields before submitting.");
    // }
}

    
window.onload = function() {
    function toggleRejectedFields() {
        var paymentStatus = document.getElementById('payment_status').value;
        var rejectedReasonSection = document.getElementById('rejected_reason_section');
        var invoiceSection = document.getElementById('invoice_section');
        var cancelBillSection = document.getElementById('cancel_bill_section');
        // alert(cancelBillSection);

        console.log('Payment Status:', paymentStatus);
        console.log('Rejected Reason Section:', rejectedReasonSection);
        console.log('Invoice Section:', invoiceSection);
        console.log('Cancel Bill Section:', cancelBillSection);

        if (paymentStatus === '1') {
            if (rejectedReasonSection) {
                rejectedReasonSection.classList.remove('hidden');
                rejectedReasonSection.classList.add('visible');
            }

            if (invoiceSection) {
                invoiceSection.classList.remove('hidden');
                invoiceSection.classList.add('visible');
            }

            if (cancelBillSection) {
                cancelBillSection.classList.remove('hidden');
                cancelBillSection.classList.add('visible');
            }
        } else {
            if (rejectedReasonSection) {
                rejectedReasonSection.classList.remove('visible');
                rejectedReasonSection.classList.add('hidden');
            }

            if (invoiceSection) {
                invoiceSection.classList.remove('visible');
                invoiceSection.classList.add('hidden');
            }

            if (cancelBillSection) {
                cancelBillSection.classList.remove('visible');
                cancelBillSection.classList.add('hidden');
            }
        }
    }

    document.getElementById('payment_status').onchange = toggleRejectedFields;
};

    function print(file_name) {
        // 
        window.location = 'uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }

    function print_pdf(file_name) {

        onmouseover = window.open('uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }







    
</script>
