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
        // $bill_no  = $_GET['bill_no'];
        $dc_number  = $_GET['dc_number'];
        // $ins_unique_id  = $_GET['ins_unique_id'];

        // $where      = [
        //     "unique_id" => $unique_id,
        //     "dc_number" => $dc_number,
        //     // "invoice_no" => $invoice_no,
        //     // "ins_unique_id" => $ins_unique_id,
            
        // ];
        $where="dc_number='".$dc_number."' AND unique_id='".$unique_id."'";


        $table      =  "view_outsource_vendor_verified_invoice";

        $columns    = [

            'po_num',
            'po_date',
            "invoice_no",
            "invoice_date",
            "dc_number",
            "dc_date",
            "invoice_qty",
            "invoice_value",
            "(select con_contact_name from consignee_details_sub as con where con.unique_id= $table.consignee_unique_id AND is_delete=0 group by unique_id) as con_contact_name",
            "(select con_address from consignee_details_sub as con where con.unique_id= $table.consignee_unique_id AND is_delete=0 group by unique_id) as con_address",
            "outsrc_eng_name",
            "vendor_bulk_timeline",
            
            "unique_id",

            // 'con_contact_name',
            // 'con_address',
            // 'invoice_no',
            // 'invoice_date',
            // 'invoice_value',
            // 'bill_submission_date',
            // 'e_no',
            // 'net_value',
            // // 'qty',
            // "(select sum(invoice_qty) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND is_delete='0' group by po_unique_id) as qty",
            // // "unit_price",
            // "(select sum(unit_price) from invoice_creation as invoice_creation where invoice_no= $table.invoice_no AND is_delete=0 group by invoice_no) as unit_price_val",
            // // "dc_signed_date",
            // "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table.invoice_no AND is_delete=0 group by bill_form_unique_id) as dc_signed_date",
            // "delivery_due_dates",
            // // 'ld_per_day',
            // // 'ld_maximum_val',
            // "gst",
            // "gst_value",
            // "tds",
            // "tds_value",
            // "ld",
            // "tran_amt",
            // // tran_amt
            // "rem_amt",
            // "payement_receive",
            // "payment_status",
            // "payment_date",
            // 'bill_form_unique_id',
            // "bill_no",
            // "claim_amount",
            //   "main_invoice_no",
            // "(select cancel_invoice_no from bill_submission_main_table as bill where bill.bill_no= $table.bill_no AND is_delete=0 group by bill_form_unique_id) as cancel_invoice_no",
            // "ins_unique_id",
            // "file_name",
            // "file_org_name",
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
            $dc_number    = $result_values[0]["dc_number"];
            $dc_date          = $result_values[0]["dc_date"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];

            $invoice_qty          = $result_values[0]["invoice_qty"];
            $invoice_val         = $result_values[0]["invoice_value"];

            $invoice_date          = $result_values[0]["invoice_date"];
            $po_date          = $result_values[0]["po_date"];
            $invoice_value_amt       = moneyFormatIndia($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt ;
            $vendor_bulk_timeline    = $result_values[0]["vendor_bulk_timeline"];
           
            $outsrc_eng_name          = $result_values[0]["outsrc_eng_name"];
            // // $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
            // $payement_receive          = $result_values[0]["payement_receive"];
            // $payment_status          = $result_values[0]["payment_status"];
            // $payment_date          = $result_values[0]["payment_date"];
            // $bill_form_unique_id    = $result_values[0]["bill_form_unique_id"];
            // $bill_no    = $result_values[0]["bill_no"];
            // $delivery_due_dates    = $result_values[0]["delivery_due_dates"];
            // $gst = $result_values[0]["gst"];
            // $gst_value = $result_values[0]["gst_value"];
            // $tds = $result_values[0]["tds"];
            // $tds_value = $result_values[0]["tds_value"];
            // $ld = $result_values[0]["ld"];
            // $rem_amt = $rem_amt[0]["rem_amt"];
            // $tran_amt = $tran_amt[0]["tran_amt"];
            // // tran_amt
            // $cancel_invoice_no          = $result_values[0]["cancel_invoice_no"];
            // $invoice_nos = $result_values[0]["main_invoice_no"];


            // $file_name         = $result_values[0]["file_name"];
        


            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

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
    // "Completed" => [
    //     "unique_id" => "",
    //     "value"     => "Completed",
    // ],
];
$payemt_status_options     = select_option($payemt_status_option, "Select", $payment_status);


?>


         
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Vendor Payment form</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Vendor Payment form</li>
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
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Vendor Complition date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $vendor_bulk_timeline  ?></div>
                            </div>
                        </div>
                        <div class="col-6">
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
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Value</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $invoice_value  ?></div>
                            </div>
                            
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Vendor Name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $outsrc_eng_name  ?></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
               
                     
                <!-- $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"]; -->
            
                <!-- <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $bill_form_unique_id ?>">
				 <input type="hidden" name="ld_amount" id="ld_amount" value="<?php echo $ldvalue_new ;?>">
				<input type="hidden" name="ld_days" id="ld_days" value="<?php echo $lddays_new;?>">
                <input type="hidden" name="claim_amount" id="claim_amount" value="<?php echo $result_values[0]['claim_amount']?>">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
                <input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo  $invoice_date  ?>">
                <input type="hidden" name="cancel_invoice_no" id="cancel_invoice_no"
                    value="<?php echo $cancel_invoice_no ?>">
                <input type="hidden" name="invoice_qty" id="invoice_qty" value="<?php echo $invoice_qty ?>">
                <input type="hidden" name="invoice_val" id="invoice_val" value="<?php echo $invoice_val ?>"> -->
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

                                    <select class="select2 form-control"  aria-label="Default select example" name="payment_status" id="payment_status" onchange="toggleRejectedFields()" required>
                                        <?php echo $payemt_status_options ?>
                                        <!-- <option selected>Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option> -->
                                    </select>
                                    <!-- <label for="main_screen" class="form-label">payment Received</label>
                                            <input type="number" id="tran_amt" name="tran_amt" class="form-control"
                                            value="<?php echo $tran_amt ?>" required step="any"> -->
                                </div>
                                <br><br>
                            
                                <br><br>
                               


                              

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Payment Received  </label>
                                        <input type="text" id="payement_receive" name="payement_receive" class="form-control" value="<?php echo $payement_receive ?>"
                                        onchange="cal_rem()" step="any" required>
                                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control"
                                        value="<?php echo $invoice_value ?>">
                                    </div>
                                </div><!-- end col -->
                              
                                <div class="col-xl-3">
                                    <label for="exampleInputdate" class="form-label">Payment Received Date</label>
                                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo $payment_date; ?>" required>
                                </div>
                               
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
 
