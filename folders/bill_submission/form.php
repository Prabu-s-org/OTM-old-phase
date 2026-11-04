<!-- This file Only PHP Functions -->

<style>
    .label-col {
        width: 150px;
        font-weight: 500;
        font-size: 15px;
    }

    .colon-col {
        width: 10px;
    }

    .value-col {
        flex: 1;
    }
</style>
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$is_active = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id = $_GET["unique_id"];
        $po_id = $_GET["po_id"];
        $bill_no = $_GET["bill_no"];
        // $ins_unique_id  = $_GET["ins_unique_id"];
        $where = [
            "bill_form_main_unique_id" => $po_id,
            "bill_no" => $bill_no,
            "unique_id" => $unique_id
        ];
        //   print_r($where);die();

        // $table      =  "view_bg_list_final";
        $table = "bill_submission_main_table";

        $columns = [

            "get_po_number(bill_form_main_unique_id) as po_num",
            "po_date",
            "bg_num",
            "bg_id",
            "bg_date",
            "bg_value",
            "bill_no",
            "bill_submission_date",
            "claim_amount",
            "claimamt",
            "(select count(invoice_no) from bill_submission_form where bill_submission_form.bill_form_main_unique_id = bill_submission_main_table.bill_form_main_unique_id and is_delete = 0) as invoice_cnt",
            "(select bg_percen from product_details_sub where product_details_sub.form_main_unique_id = bill_submission_main_table.bill_form_main_unique_id group by form_main_unique_id) as bg_percen",
            "elcot_ent_status",
            "e_no",
            "invoice_no",
            "partial_bill_status"

        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);
        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values = $result_values->data;

            $elcot_ent_status = $result_values[0]["elcot_ent_status"];
            $po_num = $result_values[0]["po_num"];
            $po_date = $result_values[0]["po_date"];
            $bg_num = $result_values[0]["bg_num"];

            $claim_percent = $result_values[0]["claim_amount"];

            $claim_value = moneyFormatIndia1($result_values[0]["claimamt"]);
            $bg_id = $result_values[0]["bg_id"];
            $invoice_value = moneyFormatIndia1($result_values[0]["invoice_value"]);
            $bg_month = $result_values[0]["bg_month"];
            $bg_percentage = $result_values[0]["bg_percentage"];
            $bg_date = $result_values[0]["bg_date"];
            $bg_value = moneyFormatIndia1($result_values[0]["bg_value"]);
            $bill_no = $result_values[0]["bill_no"];
            $bill_submission_date = $result_values[0]["bill_submission_date"];
            $invoice_cnt = $result_values[0]["invoice_cnt"];
            $bg_percen = $result_values[0]["bg_percen"];
            $e_no = $result_values[0]["e_no"];
            $cancel_invoice_no = $result_values[0]["invoice_no"];
            //    partial_bill_status

            $partial_bill_status = $result_values[0]["partial_bill_status"];

            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $po_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($customer_data)) {
                $customerAddress = $customer_data[0]["bill_address"];
                $department = department_name($customer_data[0]["department"]);
                $customerName = $customer_data[0]["contact_name"];
                $customerContact = $customer_data[0]["contact_number"];
                $customerLan = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict = district_name_stock($customer_data[0]["district"]);
                $customerPincode = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
            $stmt->bindParam(':unique_id', $consignee_unique_id);
            $stmt->execute();

            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($consignee_data)) {
                $consigneeName = $consignee_data[0]["con_contact_name"];
                $consigneeContact = $consignee_data[0]["con_contact_number"];
                $consigneeLan = $consignee_data[0]["con_lan_num"];
                $consigneeAddress = $consignee_data[0]["con_address"];
                $consigneeDistrict = district_name_stock($consignee_data[0]["con_district"]);
                $consigneeState = con_state_name_stock($consignee_data[0]["con_state_name"]);
                $consigneePincode = $consignee_data[0]["con_pincode"];
                $consigneeZone = $consignee_data[0]["zone"];
            }

            $stmt->closeCursor();
            // $is_active          = $result_values[0]["is_active"];



            // $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


// $active_status_options   = active_status($is_active);

?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Bill Submission Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Bill Submission </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <center>
                    <h4 class="card-title mb-0">BILL DETAILS </h4>
                </center>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <!-- Customer Details -->
                                <div class="col-md-4">
                                    <h6 class="text-uppercase text-body-primary"
                                        style="font-size: large; color: #878a99;">Customer Details</h6>
                                    <h6 style="font-size: x-large; color: #506018;">
                                        <strong><?php echo $department ?></strong>
                                    </h6>
                                    <p class="mb-1"><?php echo $customerAddress; ?>,<br>
                                        <?php echo $customerDistrict ?><br><?php echo $customerState ?>,
                                        <?php echo $customerPincode ?>
                                    </p>
                                    <p class="mb-1">
                                        <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                        <?php echo !empty($customerContact) ? $customerContact : '--'; ?>
                                    </p>
                                    <p>
                                        <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                                        <?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
                                    </p>
                                </div>


                                <div class="col-md-4">
                                    <h6 class="text-uppercase text-body-primary"
                                        style="font-size: large; color: #878a99;">PO & BILL Details </h6>
                                    <div class="row mb-1">
                                        <div class="col-5 text-body-secondary">PO No</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $po_num; ?></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-5 text-body-secondary">PO Date</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5 text-body-secondary">Bill No</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $bill_no; ?></div>
                                        <input type="hidden" id="bg_month" name="bg_month"
                                            value="<?php echo $bg_month; ?>">
                                    </div>


                                    <div class="row">
                                        <div class="col-5 text-body-secondary">Invoice Count</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $invoice_cnt; ?></div>
                                    </div>

                                    <!-- <div class="row">
                                        <div class="col-5 text-body-secondary">Claim Percent(%)</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $claim_percent; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5 text-body-secondary">Claim Value</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $claim_value; ?></div>
                                    </div> -->
                                </div>



                                <!-- Consignee / Invoice Details -->
                                <?php if ($partial_bill_status != '3') { ?>
                                    <div class="col-md-4" id="bg_detail_data">
                                        <h6 class="text-uppercase text-body-primary"
                                            style="font-size: large; color: #878a99;">BG Details </h6>
                                        <div class="row mb-1">
                                            <div class="col-5 text-body-secondary">BG ID</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6 "><?php echo $bg_id; ?></div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-5 text-body-secondary">BG No</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6 "><?php echo $bg_num ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-body-secondary">BG Date</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6 "><?php echo disdate($bg_date); ?></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-body-secondary">BG Value</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6 "><?php echo $bg_value; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 text-body-secondary">BG %</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6 "><?php echo $bg_percen; ?> %</div>
                                        </div>



                                    </div>
                                <?php } ?>

                                <input type="hidden" name="consignee_unique_id" id="consignee_unique_id"
                                    value="<?php echo $consignee_unique_id; ?>">
                                <input type="hidden" name="po_form_unique_id" id="po_form_unique_id"
                                    value="<?php echo $po_form_unique_id; ?>">

                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <!-- <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"> -->
                                            <table
                                                class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th>#</th>
                                                        <th scope="col" style="width: 50px;">S No</th>

                                                        <th scope="col">Invoice Date</th>
                                                        <th scope="col">Invoice No</th>

                                                        <th scope="col">Consignee Address</th>


                                                        <th scope="col" class="text-end">Invoice QTY</th>
                                                        <th scope="col" class="text-end">Invoice Value</th>
                                                        <!-- <th scope="col" class="text-end">Claim Amount</th> -->


                                                        <!--   <td id="table_td" style="text-align: right;"><?php echo $value['claim_percentage']; ?></td>
                                                                  <td id="table_td" style="text-align: right;"><?php echo $value['claimamt']; ?></td> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // $table_1 = 'view_elcot_entry_final';
                                                    $table_1 = 'bill_submission_sub';

                                                    $columns_1 = [
                                                        "bill_checkbox",
                                                        "'' as s_no",
                                                        "bill_form_unique_id",
                                                        // "bg_num",
                                                        // "bg_date",
                                                        // // "bg_value",
                                                        "po_num",
                                                        "po_date",
                                                        "invoice_qty",
                                                        // "invoice_value",
                                                        "ROUND(invoice_value,2) as invoice_value",
                                                        "invoice_no",
                                                        "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                                                        "con_contact_name",
                                                        "con_address",
                                                        "bill_status",

                                                        "consignee_unique_id",
                                                        "ins_unique_id",
                                                        "claim_percentage",
                                                        "claimamt",
                                                        // "bg_auto_id",
                                                        // "con_contact_name",
                                                        // "con_address",
                                                        // "file_name",
                                                        "unique_id",
                                                        "bill_no",
                                                        "claimamt as claim_amt",
                                                        "(select consignee_id from invoice_creation where invoice_creation.invoice_no = bill_submission_sub.invoice_no group by invoice_no) as consignee_id"

                                                    ];
                                                    $table_details1 = [
                                                        $table_1,
                                                        $columns_1
                                                    ];


                                                    // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
                                                    // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
                                                    
                                                    $where1 = "bill_form_unique_id = '$po_id' and  bill_no ='$bill_no' AND bill_status='2' AND is_delete='0'";
                                                    // $where1 = "invoice_no='".$invoice_no."' AND bill_status='2'";
                                                    

                                                    // $where1 = [
                                                    // 	// "is_delete" => '0',
                                                    // 	"invoice_no" => $invoice_no,
                                                    //     "bill_status"=>1,
                                                    // 	// "con_unique_id" => $consignee_unique_id
                                                    
                                                    // ];
                                                    


                                                    $total_qty = 0;
                                                    $total_value = 0;
                                                    $result1 = $pdo->select($table_details1, $where1);
                                                    // print_r($result1);die();
                                                    if ($result1->status) {
                                                        $res_array1 = $result1->data;


                                                        // print_r($result1->data);
                                                        foreach ($res_array1 as $key => $value) {
                                                            // $remaining_qty = $value['stock_qty'] - $value['product_count'];
                                                            $value['s_no'] = $sno + 1;

                                                            $total_qty += (float) $value['invoice_qty'];
                                                            $total_value += (float) $value['invoice_value'];
                                                            $value['bill_checkbox'] = '<input class="myCheck" hidden checked type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >';
                                                            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                                                            $stmt->bindParam(':unique_id', $value['consignee_id']);
                                                            $stmt->execute();

                                                            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if (!empty($consignee_data)) {
                                                                $consigneeName = $consignee_data[0]["con_contact_name"];
                                                                $consigneeAddress = $consignee_data[0]["con_address"];
                                                                $consigneeDistrict = district_name_stock($consignee_data[0]["con_district"]);
                                                                $consigneeState = con_state_name_stock($consignee_data[0]["con_state_name"]);
                                                                $consigneePincode = $consignee_data[0]["con_pincode"];

                                                            }
                                                            $stmt->closeCursor();



                                                            ?>
                                                            <tr>
                                                                <td id="table_td"><?php echo $value['bill_checkbox']; ?></td>
                                                                <td id="table_td"><?php echo $value['s_no']; ?></td>


                                                                <td id="table_td"><?php echo $value['invoice_date']; ?></td>
                                                                <td id="table_td"><?php echo $value['invoice_no']; ?></td>
                                                                <td><?php echo '<strong>' . disname($consigneeName) . '</strong><br>' . $consigneeAddress . ',' . $consigneeDistrict . ',' . $consigneeState . ',' . $consigneePincode; ?>
                                                                </td>


                                                                <td id="table_td" style="text-align: right;">
                                                                    <?php echo $value['invoice_qty']; ?>
                                                                </td>
                                                                <td id="table_td" style="text-align: right;">
                                                                    <?php echo moneyFormatIndia1($value['invoice_value']); ?>
                                                                    <!-- <td id="table_td" style="text-align: right;"><?php echo moneyFormatIndia1($value['claim_amt']); ?></td> -->

                                                                    <input type="hidden" id="invoice_no" name="invoice_no[]"
                                                                        class="form-control"
                                                                        value="<?php echo $value['invoice_no']; ?>">
                                                                    <input type="hidden" id="bill_form_unique_id"
                                                                        name="bill_form_unique_id[]" class="form-control"
                                                                        value="<?php echo $value['bill_form_unique_id']; ?>">
                                                                    <input type="hidden" name="bill_no" id="bill_no"
                                                                        value="<?php echo $value['bill_no']; ?>">
                                                                    <input type="hidden" name="po_num" id="po_num"
                                                                        value="<?php echo $value['po_num']; ?>">
                                                                    <input type="hidden" name="po_date" id="po_date"
                                                                        value="<?php echo $value['po_date']; ?>">
                                                                    <!-- <input type="hidden" name="invoice_no[]"  id="invoice_no" value="<?php echo $value['invoice_no']; ?>"> -->
                                                                    <input type="hidden" name="invoice_qty[]" id="invoice_qty"
                                                                        value="<?php echo $value['invoice_qty']; ?>">
                                                                    <input type="hidden" name="invoice_value[]"
                                                                        id="invoice_value"
                                                                        value="<?php echo $value['invoice_value']; ?>">

                                                                    <input type="hidden" name="invoice_date[]" id="invoice_date"
                                                                        value="<?php echo $value['invoice_date']; ?>">

                                                                    <input type="hidden" name="con_contact_name"
                                                                        id="con_contact_name"
                                                                        value="<?php echo $value['con_contact_name']; ?>">
                                                                    <input type="hidden" name="bill_form_unique_id"
                                                                        id="bill_form_unique_id"
                                                                        value="<?php echo $value['bill_form_unique_id']; ?>">

                                                                    <input type="hidden" name="con_address" id="con_address"
                                                                        value="<?php echo $value['con_address']; ?>">
                                                                    <input type="hidden" name="consignee_unique_id"
                                                                        id="consignee_unique_id"
                                                                        value="<?php echo $value['consignee_unique_id']; ?>">
                                                                    <input type="hidden" name="invoice_date" id="invoice_date"
                                                                        value="<?php echo $value['invoice_date']; ?>">
                                                                </td>
                                                                <!-- <td id="table_td"><?php echo $value['con_contact_name']; ?></td>
                                                                <td id="table_td"><?php echo $value['con_address']; ?></td> -->

                                                                <?php
                                                                $sno++;
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                                </tr>

                                                <tr class="table-active">
                                                    <td colspan="5" class="text-end fw-bold">Total</td>
                                                    <td class="text-end fw-bold">
                                                        <?php echo number_format($total_qty); ?>
                                                    </td>
                                                    <td class="text-end fw-bold">
                                                        <?php echo moneyFormatIndia1($total_value, 2); ?>
                                                    </td>
                                                </tr>
                                            </table><!--end table-->
                                        </div>


                                        <!-- <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                                <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                            </div> -->
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                            </div><!--end row-->
                            <hr>
                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="form-label">Bill Status</label>
                                        <select class="form-select" name="bill_sts" id="bill_sts"
                                            onchange="bill_change()">
                                            <option value="">Pending</option>
                                            <!-- <option value="">Select</option> -->
                                            <option value="bill_appr" <?php if ($elcot_ent_status == 1) {
                                                echo 'selected';
                                            } else {
                                                echo '';
                                            } ?>>Approve</option>
                                            <option value="bill_reject">Reject</option>

                                        </select>
                                    </div>

                                    <!-- <div class="col-md-4">
                                        <div class="col-5 text-body-secondary">Claim Percent(%)</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $claim_percent; ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-5 text-body-secondary">Claim Value</div>
                                        <div class="col-1">:</div>
                                        <div class="col-6 "><?php echo $claim_value; ?></div>
                                    </div> -->

                                    <div class="col-md-4 mb-2 d-flex justify-content-between">
                                        <span class="text-body-secondary" style="font-size:16px;">Claim Percent(%) :</span>
                                        <span style="font-size:16px;"><strong><?php echo $claim_percent; ?> %</strong></span>
                                        <br>
                                        <span class="text-body-secondary" style="font-size:16px;">Claim Value :</span>
                                        <span style="font-size:16px;"><strong><?php echo $claim_value; ?></strong></span>
                                    </div>

                                    <div class="col-md-4 mb-2 d-flex justify-content-between">
                                        
                                    </div>

                                </div>

                                <div id="approval_card" class="mt-3" style="display: none;">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="main_screen" class="form-label">Bill Submission Date</label>
                                                <input type="date" id="bill_sub_date" name="bill_sub_date"
                                                    class="form-control" required
                                                    value="<?php echo $bill_submission_date; ?>">
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cleave-delimiter" class="form-label">E No</label>
                                                <input type="text" id="e_no" name="e_no" class="form-control" required
                                                    oninput="allowOnlyAlphaNumeric(this)" value="<?php echo $e_no; ?>">

                                                <input type="hidden" id="unique_id" name="unique_id"
                                                    class="form-control" value="<?php echo $unique_id; ?>" required>
                                                <input type="hidden" id="invoice_no" name="invoice_no"
                                                    class="form-control" value="<?php echo $invoice_no; ?>" required>
                                                <input type="hidden" id="bill_form_main_unique_id"
                                                    name="bill_form_main_unique_id" class="form-control"
                                                    value="<?php echo $po_id; ?>" required>
                                                <input type="hidden" id="bill_no" name="bill_no" class="form-control"
                                                    value="<?php echo $bill_no; ?>" required>

                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-md-4" align="right" style="align-self: anchor-center;">
                                            <!-- Cancel,save and update Buttons -->
                                            <?php echo btn_cancel($btn_cancel); ?>
                                            <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                            <?php if ($e_no) { ?>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    style="margin-left: 13px;" onclick="elcot_entry()">Update</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    onclick="elcot_entry()">Save</button>

                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>



                                <div id="reject_card" style="display: none;">


                                    <div class="row">


                                        <div class="col-md-4">
                                            <div class="mb-3 mt-3">

                                                <input type="hidden" id="reject_invoice_no" name="reject_invoice_no[]"
                                                    class="form-control" value="<?php echo $cancel_invoice_no; ?>"
                                                    readonly>
                                                <input type="hidden" id="remaing_invoice_no" name="remaing_invoice_no[]"
                                                    class="form-control">
                                                <label class="form-label">Rejected reason</label>

                                                <textarea name="reject_reason" id="reject_reason"
                                                    class="form-control"><?php echo $bill_reject_reason; ?></textarea>

                                            </div>

                                        </div>


                                        <div class="col-md-4 text-end" id="images" align="right">
                                            <div class="col-md-12 mt-3" style="margin-top:30px">


                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-md-4 text-end" id="images" align="right">
                                            <div class="col-md-12 mt-3" style="margin-top:30px">

                                                <!-- <label class="form-label">Rejected reason</label> -->
                                                <!-- <input type="text" id="reject_invoice_no" name="reject_invoice_no[]"
                                        class="form-control" > -->
                                                <button type="button" class="btn btn-primary"
                                                    onclick="cancel_bill()">Reject</button>
                                                <?php echo btn_cancel($btn_cancel); ?>
                                            </div>
                                        </div><!-- end col -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
            </div>





            <script>

                $(document).ready(function () {
                    var bill_sts = $('#bill_sts').val();
                    if (bill_sts) {
                        bill_change();
                    }
                });


                function bill_change() {

                    var bill_sts = $('#bill_sts').val();

                    $('#approval_card').hide();
                    $('#reject_card').hide();

                    if (bill_sts == 'bill_appr') {
                        $('#approval_card').show();
                        $('#reject_card').hide();
                    }
                    else if (bill_sts == 'bill_reject') {

                        $('#approval_card').hide();
                        $('#reject_card').show();
                    }
                }

                function cancel_bill() {
                    // Check online status
                    var internet_status = is_online();

                    if (!internet_status) {
                        alert("No internet connection. Please check your network.");
                        return;
                    }

                    const checked = document.querySelectorAll('.myCheck:checked');
                    const rejectInvoiceNoInput = document.getElementById('reject_invoice_no');

                    // Input field to show invoice numbers
                    const reject_reason = document.getElementById('reject_reason').value;
                    const tot_invoice_no = document.getElementById('reject_invoice_no').value;

                    const bill_no = document.getElementById('bill_no').value;
                    const bill_form_unique_id = document.getElementById('bill_form_unique_id').value;

                    if (checked.length === 0) {
                        alert("No items selected");
                        return;
                    }

                    let invoice_tot = [];
                    let invoice_qty_amt = [];
                    let invoice_qty_total = [];
                    let selectedInvoiceNos = new Set();

                    // Collect all invoice numbers from the table
                    let allInvoiceNos = Array.from(document.querySelectorAll('[name="invoice_no[]"]')).map(input => input.value);

                    // Process each checked item
                    for (let i = 0; i < checked.length; i++) {
                        let checkbox = checked[i];
                        let row = checkbox.closest('tr'); // Find the closest <tr> element

                        if (!row) {
                            console.error('Row not found for checkbox');
                            continue;
                        }

                        // Extract values from the row
                        let invoice_no = row.querySelector('[name="invoice_no[]"]').value;

                        // alert(invoice_no);
                        let invoice_value_val = parseFloat(row.querySelector('[name="invoice_value[]"]').value);
                        let invoice_qty_val = parseFloat(row.querySelector('[name="invoice_qty[]"]').value);

                        if (invoice_no) {
                            // Add invoice number to the invoice_tot array if it's not already added
                            if (!selectedInvoiceNos.has(invoice_no)) {
                                invoice_tot.push(invoice_no);
                                selectedInvoiceNos.add(invoice_no);
                            }
                        }

                        // Accumulate invoice value amounts
                        if (!isNaN(invoice_value_val)) {
                            invoice_qty_amt.push(invoice_value_val);
                        }

                        // Accumulate invoice quantities
                        if (!isNaN(invoice_qty_val)) {
                            invoice_qty_total.push(invoice_qty_val);
                        }
                    }

                    // Retrieve and split the existing invoice numbers
                    let existingInvoiceNumbers = rejectInvoiceNoInput.value.split(',').map(num => num.trim()).filter(num => num);

                    // Add new invoice numbers to the existing ones, ensuring no duplicates
                    invoice_tot.forEach(invoice => {
                        if (!existingInvoiceNumbers.includes(invoice)) {
                            existingInvoiceNumbers.push(invoice);
                        }
                    });

                    // Sort and join the updated invoice numbers
                    let combinedInvoiceNumbers = existingInvoiceNumbers.sort().join(', ');

                    // Update the input field with the sorted, combined invoice numbers
                    rejectInvoiceNoInput.value = combinedInvoiceNumbers;

                    // Determine the remaining invoice numbers by excluding selected ones
                    let rem_invoice_no_set = new Set(allInvoiceNos.filter(invoice_no => invoice_no && !selectedInvoiceNos.has(invoice_no)));

                    // Get the reference to the input field for remaining invoices
                    let rem_inv_input = document.getElementById('remaing_invoice_no');

                    // Ensure the input field is correctly referenced
                    if (!rem_inv_input) {
                        console.error('Input field "remaing_invoice_no" not found');
                        return;
                    }

                    // Convert the set back to an array and set the new value for the remaining invoice numbers input field
                    rem_inv_input.value = Array.from(rem_invoice_no_set).join(', ');

                    // Calculate totals
                    let sum_of_checkbox_value = invoice_qty_amt.reduce((total, current) => total + current, 0);
                    let sum_of_invoice_qty = invoice_qty_total.reduce((total, current) => total + current, 0);

                    // Prepare data for AJAX request
                    let data = `invoice_no=${combinedInvoiceNumbers}&invoice_value=${sum_of_checkbox_value}&invoice_qty=${sum_of_invoice_qty}&reject_reason=${reject_reason}&tot_invoice_no=${tot_invoice_no}&bill_no=${bill_no}&bill_form_unique_id=${bill_form_unique_id}&remaining_invoice_no=${Array.from(rem_invoice_no_set).join(",")}`;
                    data += "&action=bill_cancel_add_update";

                    // Perform AJAX request
                    let ajax_url = sessionStorage.getItem("folder_crud_link");
                    var url = sessionStorage.getItem("list_link");
                    // let ajax_url = sessionStorage.getItem("folder_crud_link");

                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        beforeSend: function () {
                            $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                            $(".po_delivery_add_update_btn").text("Loading...");
                        },
                        success: function (response) {
                            // success: function(data) {
                            // alert(data);
                            var obj = JSON.parse(response);
                            var msg = obj.msg;
                            var status = obj.status;
                            var error = obj.error;
                            // elcot_sub();

                            sweetalert(msg, url);
                            // Handle success
                            // alert("Request was successful");
                            // Redirect or update UI as needed
                            // window.location.href = url;
                        },
                        error: function () {
                            alert("Network Error");
                        }
                    });
                }

                function elcot_entry() {

                    var internet_status = is_online();


                    var unique_id = document.getElementById('unique_id').value;
                    var bill_form_main_unique_id = document.getElementById('bill_form_main_unique_id').value;

                    var e_no = document.getElementById('e_no').value;

                    var bill_sub_date = document.getElementById('bill_sub_date').value;
                    var bill_no = document.getElementById('bill_no').value;
                    var invoice_no = document.getElementById('invoice_no').value;

                    if (e_no || bill_sub_date) {
                        var data = "unique_id=" + unique_id + "&e_no=" + e_no + "&bill_sub_date=" + bill_sub_date + "&bill_form_main_unique_id=" + bill_form_main_unique_id + "&bill_no=" + bill_no + "&invoice_no=" + invoice_no;

                        data += "&action=createupdate";

                        var ajax_url = sessionStorage.getItem("folder_crud_link");
                        var url = sessionStorage.getItem("list_link");

                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            beforeSend: function () {
                                $(".bg_add_update_btn").attr("disabled", "disabled");
                                $(".bg_add_update_btn").text("Loading...");
                            },
                            success: function (data) {

                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;
                                // elcot_sub();

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

                function elcot_sub() {

                    var invoice_no = document.getElementById('invoice_no').value;



                    for (var i = 0; i < invoice_no.length; i++) {
                        var e_no = document.getElementById('e_no').value;
                        var bill_sub_date = document.getElementById('bill_sub_date').value;
                        var invoice_no = document.getElementsByName('invoice_no[]');
                        var invoice_value = document.getElementsByName('invoice_value[]');
                        var invoice_qty = document.getElementsByName('invoice_qty[]');
                        var invoice_no_val = invoice_no[i].value;
                        var invoice_val = invoice_value[i].value;
                        var invoice_qty_val = invoice_qty[i].value;

                        var form_unique_id = document.getElementById('$invoice_no').value;
                        var po_num = document.getElementById('po_num_val').value;
                        var po_date = document.getElementById('po_date').value;
                        var con_name = document.getElementById('con_name').value;
                        var con_address = document.getElementById('con_address').value;
                        var con_unique_id = document.getElementById('con_unique_id').value;


                        var data = "form_unique_id=" + form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&con_name=" + con_name + "&con_address=" + con_address + "&con_unique_id=" + con_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_qty=" + invoice_qty_val + "&invoice_val=" + invoice_val;

                        data += "&action=bg_sub_addupdate";

                        var ajax_url = sessionStorage.getItem("folder_crud_link");
                        var url = sessionStorage.getItem("list_link");


                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            beforeSend: function () {
                                $(".bg_add_update_btn").attr("disabled", "disabled");
                                $(".bg_add_update_btn").text("Loading...");
                            },
                            success: function (data) {
                                // alert(data);

                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;
                                // alert(msg);
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
                                // location.reload();
                                sweetalert(msg, url);
                            },
                            error: function (data) {
                                alert("Network Error");
                            }
                        });
                    }
                }

            </script>
