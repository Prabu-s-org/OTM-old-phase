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
            // 'con_contact_name',
            // 'con_address',
            'invoice_no',
            'invoice_date',
            'invoice_value',
            "invoice_qty",
            'bill_submission_date',
            'e_no',
            'net_value',
            'qty',
            // "(select sum(invoice_qty) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND is_delete='0' group by po_unique_id) as qty",
            // "unit_price",
            "(select sum(unit_price) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND invoice_creation.po_num= $table.po_num AND is_delete='0' order by invoice_creation.id desc limit 1) as unit_price",
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
            // "ins_unique_id",
            //  "(select delivery_due_dates from product_details_sub as pro where pro.form_main_unique_id= $table.bill_form_unique_id AND is_delete=0 group by bill_form_unique_id) as product_delivery_due_dates",
            "(select pro.ld_per_day from product_details_sub as pro where pro.form_main_unique_id = $table.bill_form_unique_id and pro.is_delete = 0 order by pro.id desc limit 1) as ld_per_day",
            "(select ld_delivery_due_date from po_form as po where po.unique_id= $table.bill_form_unique_id AND is_delete=0 ) as ld_delivery_due_date",

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
            // $con_contact_name          = $result_values[0]["con_contact_name"];
            // $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];

            $invoice_qty          = $result_values[0]["invoice_qty"];
            $invoice_val         = $result_values[0]["invoice_value"];

            // $invoice_date          = $result_values[0]["invoice_date"];
            // $invoice_value          = $result_values[0]["invoice_value"];
            $invoice_value_amt       = moneyFormatIndia($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt ;
           $unit_price_val    = $result_values[0]["unit_price"];
            $e_no          = $result_values[0]["e_no"];
            // $ld_per_day          = $result_values[0]["ld_per_day"];
            // $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
            $payement_receive          = $result_values[0]["payement_receive"];
            $payment_status          = $result_values[0]["payment_status"];
            $payment_date          = $result_values[0]["payment_date"];
            $bill_form_unique_id    = $result_values[0]["bill_form_unique_id"];
            $bill_no    = $result_values[0]["bill_no"];
          
            $gst = $result_values[0]["gst"];
            $gst_value = $result_values[0]["gst_value"];
            $tds = $result_values[0]["tds"];
            $tds_value = $result_values[0]["tds_value"];
            $ld = $result_values[0]["ld"];
            $rem_amt = $result_values[0]["rem_amt"];
            $tran_amt = $result_values[0]["tran_amt"];
            $cancel_invoice_no          = $result_values[0]["cancel_invoice_no"];
            $invoice_nos = $result_values[0]["main_invoice_no"];
              $dc_signed_date = $result_values[0]["dc_signed_date"];
              
$orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));

            $orgDate1 = $result_values[0]["invoice_date"];
           $invoice_date = date("d-m-Y", strtotime($orgDate1));

             $orgDate2 = $result_values[0]["bill_submission_date"];
            
            $bill_submission_date = date("d-m-Y", strtotime($orgDate2));
             $ld_per_day = $result_values[0]["ld_per_day"];
                 $ld_delivery_due_date    = $result_values[0]["ld_delivery_due_date"];

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
        "2%" => [
                "unique_id" => "2",
                "value" => "2%",
            ]
    ];

$tax_select_options = select_option($tax_select_options,"Select Option");

$tax_select_options_tds =
    [
        
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

$payemt_status_option      = [
    "Rejected" => [
        "unique_id" => "1",
        "value"     => "Rejected",
    ],
    "Completed" => [
        "unique_id" => "2",
        "value"     => "Completed",
    ]
];
$payemt_status_options     = select_option($payemt_status_option, "Select", $payment_status);


$active_status_options   = active_status($is_active);



$dc_select_options = dc_dateLD($bill_form_unique_id,$invoice_no);
$dc_select_options = select_option($dc_select_options, "Select DC Date");
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
                            <!-- <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee Name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $con_contact_name  ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Location</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $con_address  ?></div>
                            </div> -->
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
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice QTY</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $invoice_qty  ?></div>
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
                                <div class="col-xl-7"><?php echo $lddays_new;?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">LD Value </label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $ldvalue_new;?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Dc Signed Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $dc_signed_date;?></div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Delivery Due Days</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo  $delivery_due_dates;?></div>
                            </div> -->
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Payment Receivable</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $payement_receive  ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                               
                <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">
                <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $bill_form_unique_id ?>">
                <input type="hidden" name="product_unit_price" id="product_unit_price" value="<?php echo $unit_price_val ?>">

                <input type="hidden" name="ld_amount" id="ld_amount" >
				<input type="hidden" name="ld_days" id="ld_days" >
                
                <input type="hidden" name="claim_amount" id="claim_amount" value="<?php echo $result_values[0]['claim_amount']?>">
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">

                <input type="hidden" name="cancel_invoice_no" id="cancel_invoice_no"
                    value="<?php echo $cancel_invoice_no ?>">
                <input type="hidden" name="invoice_qty" id="invoice_qty" value="<?php echo $invoice_qty ?>">
                <input type="hidden" name="invoice_val" id="invoice_val" value="<?php echo $invoice_val ?>">
                <hr />

                    <div class="row">
                        <div class="col-lg-3 head_po">
                            <label class="form-label">LD DC Date</label>
                            <input type="date" name="dcDate" id="dcDate" class="form-control" onChange="ldCal(event)" required />

                            <input type="hidden" name="deliveryDate" id="deliveryDate" class="form-control" value="<?php echo $ld_delivery_due_date; ?>"/>
                            <input type="hidden" name="ld_per_day" id="ld_per_day" class="form-control" value="<?php echo $ld_per_day; ?>" />
                            <!-- <select name="dcDate" id="dcDate" class="select form-control" required="" onChange="ldCal(event)">
                                <?php echo $dc_select_options; ?>
                            </select> -->
                        </div>
                        <div class="col-2 head_po">
                            <div class="row">
                                <div class="col-xl-12 head_po">
                                    <label class="form-label">LD Days</label>
                                </div>
                                <div class="col-xl-12" id="ldDayDisplay"></div>
                            </div>
                        </div>
                        <div class="col-2 head_po">
                            <div class="row">
                                <div class="col-xl-12 head_po"> 
                                    <label class="form-label">LD Value</label>
                                </div>
                                <div class="col-xl-12" id="ldValDisplay"></div>
                            </div>
                        </div>
                    </div>

                 <hr>                                   
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
                                    <label for="main_screen" class="form-label">Transacation Amount</label>
                                            <input type="number" id="tran_amt" name="tran_amt" class="form-control"
                                            value="<?php echo $tran_amt ?>" required step="any">
                                </div>
                                <br><br>
                                
                                <div class="col-xl-3 hidden_1" id="rejected_reason_section">
                                    <div class="mb-3">
                                        <label class="form-label">Rejected reason</label>

                                        <textarea name="reject_reason" id="reject_reason"
                                            class="form-control"></textarea>
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
                                        <input type="hidden" id="main_invoice_no" name="main_invoice_no"
                                            class="form-control" value="<?php echo $invoice_nos ; ?>">

                                        <input type="hidden" id="remaing_main_invoice_no" name="remaing_main_invoice_no"
                                            class="form-control">

                                    </div>
                                </div>


                                <br><br>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST %</label>
                                            <select class="form-select mb-3" aria-label="Default select example"
                                                name="gst" id="gst" onchange="getGst_value()" >
                                                <?php echo $tax_select_options ?>

                                            </select>
                                            <input type="hidden" id="invoice_qty_value" name="invoice_qty_value" class="form-control"
                                                value="<?php echo $invoice_qty_value; ?>">
                                            <!-- <input type="hidden" id="qty" name="qty" class="form-control"
                                                value="<?php echo $invoice_qty; ?>"> -->
                                                

                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">GST Value </label>
                                            <input type="text" id="gst_value" name="gst_value" class="form-control"
                                                value="<?php echo $gst_value ?>" readonly >
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">TDS %</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="tds"
                                            id="tds" onchange="getTds_value()" >
                                            <?php echo $tax_select_options_tds ?>

                                        </select>
                                        <!-- <input type="text" id="gst" name="gst" class="form-control" value=""> -->
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">TDS Value </label>
                                        <input type="text" id="tds_value" name="tds_value" class="form-control"
                                            value="<?php echo $tds_value ?>" readonly >
                                    </div>
                                </div><!-- end col -->
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">LD Deducted by Elcot</label>
                                        <input type="number" id="ld" name="ld" class="form-control" 
                                            value="<?php echo $ld ?>" onchange="cal_rem(),checkLdValue();" step="any" required>
                                            <input type="hidden" id="ld_value" name="ld_value" class="form-control" 
                                            value="<?php echo $ld ?>">
                                            <input type="hidden" id="ld_display_value" name="ld_display_value" class="form-control"
                                             value="<?php echo $result_values[0]['qty'];?>" >
                                            <span id="ld_error" style="color: red;"></span>
                                    </div>
                                </div><!-- end col -->


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Payment Received</label>
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
                                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo $payment_date; ?>" required>
                                </div>
                                <div class="col-xl-3" id="images">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Receipt </label>

                                        <input type="file" id="file" accept="application/pdf" name="file" class="form-control " value="<?php echo $file_org_name; ?>" required >

                          
                          
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

document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];
        
        // Set the max attribute of the PO Date input field
        document.getElementById("payment_date").setAttribute("max", today);
    });

    function ldCal(){
        document.getElementById("ldDayDisplay").innerText = '';
        const deliveryDateVal = document.getElementById('deliveryDate').value;
        const [refYear, refMonth, refDay] = deliveryDateVal.split('-'); // Correct order
        const referenceDate = new Date(Number(refYear), Number(refMonth) - 1, Number(refDay));

        // console.log("Formatted:", referenceDate);
        let dcDateVal = document.getElementById('dcDate').value;
        const [year, month, day] = dcDateVal.split("-");
        const selectedDate = new Date(Number(year), Number(month) - 1, Number(day));

        // console.log("Formatted:", selectedDate);
        referenceDate.setHours(0,0,0,0);
        selectedDate.setHours(0,0,0,0);
        if (selectedDate <= referenceDate) {
            console.log("Selected date is before or same as 15-06-2025. No action needed.");
        } else {
            const diffTime = selectedDate - referenceDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            // console.log(`Selected date is ${diffDays} day(s) after 15-06-2025.`);

            document.getElementById("ldDayDisplay").innerText = diffDays;
            document.getElementById("ld_days").value = diffDays;

            let ldPerDay = document.getElementById('ld_per_day').value;
            let product_unit_price = document.getElementById('product_unit_price').value;

            let ldAmt = product_unit_price * diffDays * ldPerDay/100;

            let fixedNumber = parseFloat(ldAmt.toFixed(2));
            document.getElementById("ldValDisplay").innerText = fixedNumber;

            document.getElementById("ld_amount").value = fixedNumber;

            console.log(fixedNumber);
            




        }




    }
function checkLdValue() {
    let ldValue = parseFloat(document.getElementById('ld_display_value').value);
    // alert(ldValue);
    
    let ldInput = parseFloat(document.getElementById('ld').value);
    // alert(ldInput);
    let errorMessage = document.getElementById('ld_error');

    if (ldInput > ldValue + 2) {
        // alert('higher value');
        errorMessage.textContent = "This is more than one rupee higher than the LD value.";
    } else if (ldInput < ldValue - 2) {
        // alert('lower value');
        errorMessage.textContent = "This is more than one rupee lower than the LD value.";
    } else {
        errorMessage.textContent = "";
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
    // alert(tds_value);
    let ld = parseNumber(document.getElementById("ld").value);
    // alert(ld);
    let payement_receive = parseNumber(document.getElementById("payement_receive").value);
    // alert(payement_receive);
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
   // document.getElementById("rem_amt").value = total_deduction;
   document.getElementById("rem_amt").value = total_deduction.toFixed(2);

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
        // alert(tds_value);
        var ld = document.getElementById('ld').value;
        var tran_amt = document.getElementById('tran_amt').value;
        // alert(tran_amt);
        var rem_amt = document.getElementById('rem_amt').value;
        var my_inv_no = document.getElementById('my_inv_no').value;
var payement_receive = document.getElementById('payement_receive').value;
// alert(payement_receive);

        var bill_no = document.getElementById('bill_no').value;
        // if (gst && tds) {
        var data = new FormData();
        var image_s = document.getElementById("file");
        if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("file", document.getElementById('file').files[i]);

            }
        } else {
            data.append("file", '');
        }
        data.append("my_inv_no", my_inv_no);
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
    


        data.append("action", "createupdate");
        
        var is_form = form_validity_check("was-validated");
         if (is_form) {
            // if(gst && tds){
        // var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url = sessionStorage.getItem("list_link");

        //  if(payment_date || payment_status){
        //  var data = "unique_id=" + unique_id +"&payment_date=" + payment_date + "&payement_receive=" + payement_receive+ "&bill_no=" + bill_no + "&payment_status=" + payment_status;

        //  data += "&action=createupdate";
//    if(gst && tds){
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
         }
         else {
        	 sweetalert("form_alert");
         }
    //     } else {
    //     Swal.fire( "Please fill in both GST and TDS fields.");
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
