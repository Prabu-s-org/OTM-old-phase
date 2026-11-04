<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php include 'crud.php'; ?>
<?php include '../../config/dbconfig.php'; ?>

<?php include '../../congig/comfun.php'; ?>
<style>
    #images .mb-3 {
        min-height: 80px;
        /* Adjust this value based on the height of the Rejected reason box */
    }

    #reject_reason:empty {
        display: none;
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

        echo   $unique_ids  = $_GET['unique_id'];



        echo '.';
        echo  $bill_no  = $_GET['bill_no'];
        echo '.';
        echo   $invoice_no  = $_GET['invoice_no'];
        echo '.';

        echo   $ins_unique_id  = $_GET['ins_unique_id'];


        $where      = [

            "bill_form_unique_id" => $unique_ids,
            "bill_no" => $bill_no,
            "invoice_no" => $invoice_no,
            "ins_unique_id" => $ins_unique_id,
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
            "(select invoice_qty from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND is_delete='0' group by po_unique_id) as qty",
            "unit_price",
            // "dc_signed_date",
            "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table.invoice_no AND is_delete = '0' group by bill_form_unique_id) as dc_signed_date",
            "delivery_due_dates",
            // 'ld_per_day',
            // 'ld_maximum_val',
            "gst",
            "gst_value",
            "tds",
            "tds_value",
            "ld",
            "tran_amt",
            "rem_amt",
            "file_name",
            "payement_receive",
            "payment_status",
            "payment_date",
            'bill_form_unique_id',
            "bill_no",
            "claim_amount",
            "main_invoice_no",
            "(select cancel_invoice_no from bill_submission_main_table as bill where bill.bill_no= $table.bill_no AND is_delete = '0' group by bill_form_unique_id) as cancel_invoice_no",
            "delivery_due_dates",
            "payment_cancel_reason"

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
            // $invoice_date          = $result_values[0]["invoice_date"];
            // $invoice_value          = $result_values[0]["invoice_value"];
            $invoice_value_amt       = moneyFormatIndia($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt;
            $unit_price    = $result_values[0]["unit_price"];
            $e_no          = $result_values[0]["e_no"];
            $cancel_invoice_no          = $result_values[0]["cancel_invoice_no"];
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
            $rem_amt = $result_values[0]["rem_amt"];
            $tran_amt = $result_values[0]["tran_amt"];
            $file_names = $result_values[0]["file_name"];
            $cancel_reason = $result_values[0]["payment_cancel_reason"];
            // $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);

            $file_name = image_view_3("payment", $value['bill_form_unique_id'], $file_names);

            $invoice_nos = $result_values[0]["main_invoice_no"];
            // $invoice_no_array = explode(',', $invoice_nos);
            //gst value
            $where_1 = [
                //  $invoice_no_array = explode(',', $invoice_nos); "po_unique_id" => $bill_form_unique_id,
                // "consignee_id" => $consignee_unique_id,
                "invoice_no"  => $invoice_no,

            ];


            $table_1 = "invoice_creation";

            $columns_1 = [
                "sum(unit_price) as unit_price",
                "sum(invoice_qty) as invoice_qty"
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

            if ($dc_signed_date == '') {
                $dc_signed_date = '';
            } else {
                $dc_signed_date = date("d-m-Y", strtotime($dc_signed_date));
            }
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
            $duedate = $poDate->format('d-m-Y');
            $duedate1 = new DateTime($duedate);
            // print_r($duedate1);
            $poDate->modify('+' . $delivery_due_dates . ' days');
            $interval = $duedate1->diff($signedDate);


            //   if($resultDate<=$dc_signed_date){
            //     $lddays = $interval->format('%a');


            // }

            // else {

            //     $lddays ='0';
            // }
            if ($signedDate > $duedate1) {
                $lddays =  $interval->format('%a');
            } else if ($signedDate = $duedate1) {
                $lddays = 0;
            } else {
                $lddays = 0;
            }
            // Update the original array with the new calculated values
            $result_values[0]['net_value'] = $lddays;

            if ($lddays > 40) {
                $ldvalue = $lddays * $qty * ($unit_price *  0.1);
            } else {
                $ldvalue = $lddays * $qty * ($unit_price * 0.0025);
            }
            // Calculate the new value (25% of the total price)

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
        "" => [
            "unique_id" => "",
            "value" => "Select Option",
        ],
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

$tax_select_options = select_option($tax_select_options);

$tax_select_options_tds =
    [
        "" => [
            "unique_id" => "",
            "value" => "Select Option",
        ],

        "10%" => [
            "unique_id" => "10",
            "value" => "10%",
        ],

    ];
$tax_select_options_tds = select_option($tax_select_options_tds);

// $payemt_status=[
//     "1"=>"pending",
// ]
$payment_status_option = [
    "Rejected" => [
        "unique_id" => "1",
        "value"     => "Rejected",
    ],
    "Completed" => [
        "unique_id" => "2",
        "value"     => "Completed",
    ],
];



// Extract the label (value) corresponding to the selected status
$current_status_label = $payment_status_option[$payment_status]['value'] ?? "Rejected" ?? "Completed";


if ($payment_status == '1') {


    $payment_status = 'Rejected';
} elseif ($payment_status == '2') {
    $payment_status = 'Completed';
}


// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


// $active_status_options   = active_status($is_active);

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
                                <div class="col-xl-7"><?php echo $po_num ?></div>
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
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Days </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $result_values[0]['net_value']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Value </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $result_values[0]['qty']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Dc Signed Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $dc_signed_date; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Delivery Due Days</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $delivery_due_dates; ?></div>
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
                <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $bill_form_unique_id ?>">
                <input type="hidden" name="ld_amount" id="ld_amount" value="<?php echo $result_values[0]['qty']; ?>">
                <input type="hidden" name="ld_days" id="ld_days" value="<?php echo $result_values[0]['net_value'] ?>">
                <input type="hidden" name="claim_amount" id="claim_amount" value="<?php echo $result_values[0]['claim_amount'] ?>">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
                <input type="hidden" name="cancel_invoice_no" id="cancel_invoice_no" value="<?php echo $cancel_invoice_no ?>">
                <!-- <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                    <input type="hidden" name="payment_status" id="payment_status" value="<?php echo $payment_status ?>"> -->
                <!-- <input type="hidden" name="payment_date" id="payment_date" value="<?php echo $payment_date ?>"> -->
                <hr />

                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">


                                <div class="col-lg-3">
                                    <label for="main_screen" class="form-label">Current Status: &nbsp; &nbsp;<b><?php echo $payment_status; ?></b></label>

                                    <!-- <input type="text" id="state_name" name="state_name" class="form-control" value="" > -->

                                    <!-- <select class="select2 form-control" aria-label="Default select example" name="payment_status" id="payment_status">
                                        <?php echo $payemt_status_options ?> -->
                                    <!-- <option selected>Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option> -->
                                    </select>
                                    <br><br>
                                    <label for="main_screen" class="form-label">Transacation Amount</label> : &nbsp;<b><?php echo $tran_amt; ?></b>
                                    <!-- 
                                            <input type="number" id="tran_amt" name="tran_amt" class="form-control"
                                            value="<?php echo $tran_amt; ?>" step="any" > -->
                                </div>
                                </br></br>
                                <div class="col-xl-3" id="images">
                                    <?php if ($payment_status == '1'): ?>
                                        <div class="mb-3">
                                            <label class="form-label">Rejected reason</label>
                                            <textarea name="reject_reason" id="reject_reason" readonly class="form-control"></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div><!-- end col -->

                                <!-- <div class="col-xl-3" id="images">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Total Invoice no</label> :&nbsp;&nbsp;
                                        <b><?php echo $invoice_nos; ?></b>
                                    </div>
                                </div>end col -->


                                <br><br>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST % :</label>&nbsp;&nbsp;&nbsp;<b><?php echo  $gst . '%'; ?></b>

                                            <!-- <select class="form-select mb-3" aria-label="Default select example"
                                                name="gst" id="gst" onchange="getGst_value()">
                                                <?php echo $tax_select_options ?> -->

                                            </select>
                                            <input type="hidden" id="unit_price" name="unit_price" class="form-control"
                                                value="<?php echo $unit_price; ?>">
                                            <input type="hidden" id="qty" name="qty" class="form-control"
                                                value="<?php echo $invoice_qty; ?>">


                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST Value : </label>&nbsp;<b><?php echo $gst_value ?></b>
                                            <!-- <input type="text" id="gst_value" name="gst_value" class="form-control"
                                                value="<?php echo $gst_value ?>" readonly> -->
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="mb-3"><?php if ($tds == '') {
                                                                $tds_per = '-';
                                                            } else {
                                                                $tds_per = $tds;
                                                            } ?>
                                            <label for="main_screen" class="form-label">TDS % :</label>&nbsp;&nbsp;<b><?php echo $tds_per; ?></b>

                                            <!-- <select class="form-select mb-3" aria-label="Default select example" name="tds"
                                            id="tds" onchange="getTds_value()">
                                            <?php echo $tax_select_options_tds ?>

                                        </select> -->
                                            <!-- <input type="text" id="gst" name="gst" class="form-control" value=""> -->
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <?php if ($tds_value == '') {
                                                $tds_per = '-';
                                            } else {
                                                $tds_per = $tds_value;
                                            } ?>
                                            <label for="main_screen" class="form-label">TDS Value </label><b>&nbsp;&nbsp;<?php echo $tds_per; ?></b>
                                            <!-- <input type="text" id="tds_value" name="tds_value" class="form-control"
                                            value="<?php echo $tds_value ?>" readonly> -->
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">LD Deducted by Elcot :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $ld; ?></b>
                                        <input type="number" hidden id="ld" name="ld" class="form-control"
                                            value="<?php echo $ld ?>" onchange="cal_rem()" step="any">
                                        <input type="hidden" id="ld_value" name="ld_value" class="form-control"
                                            value="<?php echo $ld ?>">
                                    </div>
                                </div><!-- end col -->


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Payment Received from ELCOT : </label>&nbsp;&nbsp;<b><?php echo $payement_receive ?></b>
                                        <input type="hidden" id="payement_receive" name="payement_receive" class="form-control" value="<?php echo $payement_receive ?>"
                                            onchange="cal_rem()" step="any">
                                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control"
                                            value="<?php echo $invoice_value ?>">
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-3">
                                    <div class="mb-3"> <?php if ($rem_amt == '') {
                                                            $rem_amts = '-';
                                                        } else {
                                                            $rem_amts = $rem_amt;
                                                        } ?>
                                        <label for="main_screen" class="form-label">Remaning Amt :</label>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $rem_amts ?></b>
                                        <!-- <input type="number" id="rem_amt" name="rem_amt"
                                            class="form-control" value="<?php echo $rem_amt ?>" readonly> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label for="exampleInputdate" class="form-label">Payment Received Date :</label><b>&nbsp;&nbsp;&nbsp;<?php echo $payment_date; ?></b>

                                        <!-- <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo $payment_date; ?>"> -->
                                    </div>
                                    <div class="col-xl-3" id="images">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Receipt :</label> &nbsp;&nbsp;<?php echo ($file_name); ?>

                                            <!-- <input type="file" id="file" accept="application/pdf" name="file" class="form-control " value="<?php echo $file_org_name; ?>"> -->
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-12" align="right">
                                        <!-- Cancel,save and update Buttons -->
                                        <?php echo btn_cancel($btn_cancel); ?>
                                        <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                        <!-- <?php if ($bill_form_unique_id) { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="payment_cu()">Update</button> -->
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
    function cal_rem() {
        // Helper function to remove commas from a number string and convert to float
        function parseNumber(value) {
            return parseFloat(value.replace(/,/g, '')) || 0;
        }

        // Retrieve and parse values
        let gst_value = parseNumber(document.getElementById("gst_value").value);
        let tds_value = parseNumber(document.getElementById("tds_value").value);
        let ld = parseNumber(document.getElementById("ld").value);
        let payement_receive = parseNumber(document.getElementById("payement_receive").value);
        let invoice_value = parseNumber(document.getElementById("invoice_value").value);

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
        let unitPrice = document.getElementById("unit_price").value;
        // alert(unitPrice);
        let qty = document.getElementById("qty").value;
        // alert(qty);
        // Calculate the GST value
        let gstValue = (unitPrice * qty * 0.02);

        // alert(gstValue);

        // Set the calculated GST value to the input field
        document.getElementById("gst_value").value = gstValue;

    }


    function getTds_value() {
        let unitPrice = document.getElementById("unit_price").value;
        let qty = document.getElementById("qty").value;

        // Calculate the GST value
        let gstValue = (unitPrice * qty * 0.1);

        // Set the calculated GST value to the input field
        document.getElementById("tds_value").value = gstValue;

    }


    function payment_cu() {
        // alert("hii");
        var internet_status = is_online();

        var unique_id = document.getElementById('unique_id').value;
        // alert(unique_id);
        var payement_receive = document.getElementById('payement_receive').value;
        // alert(payement_receive);
        var claim_amount = document.getElementById('claim_amount').value;
        //  alert(claim_amount);
        var payment_status = document.getElementById('payment_status').value;
        //  alert(payment_status);
        var payment_date = document.getElementById('payment_date').value;
        var ld_amount = document.getElementById('ld_amount').value;

        var ld_days = document.getElementById('ld_days').value;
        var gst = document.getElementById('gst').value;
        var gst_value = document.getElementById('gst_value').value;
        var tds = document.getElementById('tds').value;
        var tds_value = document.getElementById('tds_value').value;
        var ld = document.getElementById('ld').value;
        var tran_amt = document.getElementById('tran_amt').value;
        var rem_amt = document.getElementById('rem_amt').value;

        var bill_no = document.getElementById('bill_no').value;

        var reject_reason = document.getElementById('reject_reason').value;

        var rejectInvoiceNoInput = document.getElementById('invoice_no').value;
        var main_invoice_no = document.getElementById('main_invoice_no').value;
        var remaing_main_invoice_no = document.getElementById('remaing_main_invoice_no').value;

        var mainInvoiceNo = document.getElementById('main_invoice_no').value;

        var rejectInvoiceNo = document.getElementById('invoice_no').value;
        // alert(rejectInvoiceNo);

        // Update the remaining invoice numbers input field
        var remainingInvoiceInput = document.getElementById('remaing_main_invoice_no');
        //     if (!remainingInvoiceInput) {
        //         console.error('Input field "remaing_main_invoice_no" not found');
        //         return;
        //     }
        //     remainingInvoiceInput.value = updatedMainInvoices.join(',');

        //     // Debugging: Check the updated values
        //     console.log('Updated Cancel Invoice No:', cancelInvoiceInput.value);
        //     console.log('Updated Remaining Invoices:', remainingInvoiceInput.value);

        //     // Optionally, update the cancel invoice number input field if necessary
        //     // var cancelInvoiceInput = document.getElementById('cancel_invoice_no');
        //     // cancelInvoiceInput.value = rejectInvoiceNo;
        // // Update the cancel invoice number input field by appending the new invoice
        //  // Update the cancel invoice number input field by appending the new invoice
        var cancelInvoiceInput = document.getElementById('cancel_invoice_no');

        //     var existingCancelInvoiceNo = cancelInvoiceInput.value.split(',').map(num => num.trim()).filter(num => num);

        //     alert(existingCancelInvoiceNo);
        //     if (!existingCancelInvoiceNo.includes(rejectInvoiceNo)) {
        //         existingCancelInvoiceNo.push(rejectInvoiceNo);
        //     }

        //     cancelInvoiceInput.value = existingCancelInvoiceNo.join(',');
        //     // remainingInvoiceInput.value = updatedMainInvoices.join(',');

        // Ensure input fields are correctly referenced
        if (!remainingInvoiceInput) {
            console.error('Input field "remaing_main_invoice_no" not found');
            return;
        }
        if (!cancelInvoiceInput) {
            console.error('Input field "cancel_invoice_no" not found');
            return;
        }

        // Split the main invoice numbers into an array
        var mainInvoiceNumbers = mainInvoiceNo.split(',').map(num => num.trim());

        // Get the already rejected invoices from the cancel_invoice_no input field
        var existingCancelInvoiceNo = cancelInvoiceInput.value.split(',').map(num => num.trim()).filter(num => num);

        // Add the new rejected invoice to the list if not already included
        if (!existingCancelInvoiceNo.includes(rejectInvoiceNo)) {
            existingCancelInvoiceNo.push(rejectInvoiceNo);
        }

        // Update the cancel_invoice_no field with the new list of rejected invoices
        cancelInvoiceInput.value = existingCancelInvoiceNo.join(',');

        // Filter out the rejected invoices from the main invoice numbers to get remaining invoices
        var updatedMainInvoices = mainInvoiceNumbers.filter(num => !existingCancelInvoiceNo.includes(num));

        // Update the remaining invoice numbers input field
        remainingInvoiceInput.value = updatedMainInvoices.join(',');

        // Debugging: Check the updated values
        console.log('Updated Cancel Invoice No:', cancelInvoiceInput.value);
        console.log('Updated Remaining Invoices:', remainingInvoiceInput.value);

        // alert(rejectInvoiceNo);

        var data = new FormData();
        var image_s = document.getElementById("file");
        if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("file", document.getElementById('file').files[i]);

            }
        } else {
            data.append("file", '');
        }
        data.append("unique_id", unique_id);
        data.append("payment_date", payment_date);
        data.append("payement_receive", payement_receive);
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
        data.append("reject_reason", reject_reason);
        // data.append("cancel_invoice_no", existingCancelInvoiceNo.join(','));
        // data.append("remaining_invoice_no", updatedMainInvoices.join(','));
        data.append("cancel_invoice_no", cancelInvoiceInput.value);
        data.append("remaining_invoice_no", remainingInvoiceInput.value);
        data.append("invoice_no", rejectInvoiceNo);

        data.append("main_invoice_no", main_invoice_no);
        data.append("action", "createupdate");
        var is_form = form_validity_check("was-validated");
        //  if (is_form) {
        // var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url = sessionStorage.getItem("list_link");

        //  if(payment_date || payment_status){
        //  var data = "unique_id=" + unique_id +"&payment_date=" + payment_date + "&payement_receive=" + payement_receive+ "&bill_no=" + bill_no + "&payment_status=" + payment_status;

        //  data += "&action=createupdate";

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
                $(".bg_add_update_btn").attr("disabled", "disabled");
                $(".bg_add_update_btn").text("Loading...");
            },
            success: function(data) {
                //  alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                // elcot_sub();
                // alert(msg);
                sweetalert(msg, url);

            },
            error: function(data) {
                alert("Network Error");
            }
        });
        //  }
        //  else {
        // 	 sweetalert("form_alert");
        //  }

    }

    function image_view_3($folder_name = "", $unique_id = "", $file_name = "") {
        // echo $file_name;
        $file_names = explode(',', $file_name);
        $image_view_3 = '';

        if ($file_name) {
            foreach($file_names as $file_key => $file_name) {
                if ($file_key != 0) {
                    if ($file_key % 4 != 0) {
                        $image_view_3. = "&nbsp";
                    } else {
                        $image_view_3. = "<br><br>";
                    }
                }

                $cfile_name = explode('.', $file_name);

                if ($file_name) {

                    if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                        $image_view_3. = '<a href="javascript:print_view_1(\'/'.$file_name.
                        '\')"><img src="uploads/'.$folder_name.
                        '/'.$file_name.
                        '"  height="30px" width="30px" ></a>';
                        // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                    } else if ($cfile_name[1] == 'pdf') {
                        $image_view_3. = '<a href="javascript:print_pdf(\'/'.$file_name.
                        '\')"><img src="uploads/payment/pdf.png"  height="30px" width="50px" ></a>';
                    }
                    // else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/excel.png"  height="30px" width="30px" ></a>';
                    // } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/word.png"  height="30px" width="30px" ></a>';
                    // }
                }
            }
        }

        return $image_view_3;
    }

    // function print(file_name) {
    //     // 
    //     window.location = 'uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    // }

    // function print_pdf(file_name) {

    //     onmouseover = window.open('uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
</script>
