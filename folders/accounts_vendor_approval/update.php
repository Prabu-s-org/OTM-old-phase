<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }

    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }

    button#export {
        float: right;
        padding: 5px 10px;
    }

    table.dataTable.nowrap td {
        white-space: unset;
    }

    span.po_date {
        white-space: nowrap;
    }

    .field-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

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

    .custom-wide-modal {
        max-width: 85vw;
        width: 80vw;
    }
</style>
<!-- Include Bootstrap Icons (for the credit card icon) -->

<?php

$action_type = "Update";
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641adb14666c465380';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

$unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : null;
$vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : null;
$bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : null;
$bill_date = isset($_GET['bill_date']) ? $_GET['bill_date'] : null;
// $accounts_approval = isset($_GET['accounts_approval']) ? $_GET['accounts_approval'] : null;
$newVendorId = vendor_generate_payment_id($payment_id);


if (isset($_GET["vendor_id"])) {
    if (!empty($_GET["vendor_id"])) {

        $vendor_id = $_GET["vendor_id"];
        $where = [
            "unique_id" => $vendor_id
        ];

        $table = "vendor_creation";

        $columns = [
            "name",
            "company_name",
            "contact_no",
            "mail_id",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
            "(SELECT d.district_name from district_creation d LEFT JOIN vendor_creation v ON d.unique_id = v.district_name LIMIT 1) AS district_name",
            "pincode",
            "gst_no",
            "pan_no",
            "acc_holder_name",
            "pan_attach_file_name",
            "bank_proof"
        ];

        $table_details = [
            $table,
            $columns
        ];
        $result_values = $pdo->select($table_details, $where);
        if ($result_values->status) {

            $result_values = $result_values->data;

            $name = $result_values[0]["name"];
            $company_name = $result_values[0]["company_name"];
            $contact_no = $result_values[0]["contact_no"];
            $mail_id = $result_values[0]["mail_id"];
            $address = $result_values[0]["address"];
            $account_no = $result_values[0]["account_no"];
            $ifsc_code = $result_values[0]["ifsc_code"];
            $bank_name = $result_values[0]["bank_name"];
            $branch_name = $result_values[0]["branch_name"];
            $district_name = $result_values[0]["district_name"];
            $pincode = $result_values[0]["pincode"];
            $gst_no = $result_values[0]["gst_no"];
            $pan_no = $result_values[0]["pan_no"];
            $acc_holder_name = $result_values[0]["acc_holder_name"];
            $pan_attach_file_name = $result_values[0]["pan_attach_file_name"];
            $bank_proof = $result_values[0]["bank_proof"];


            //  $result_values[0]['pan_attach_file_name'] = image_view_4("vendor_creation", $result_values[0]['unique_id'],   $pan_attach_file_name);
            //   $result_values[0]['bank_proof'] = image_view_5("vendor_creation", $result_values[0]['unique_id'],   $bank_proof);




        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }

    $table_vendor = "vendor_payment_details";

    $columns1 = [
        "account_remark",
        "CONCAT('<b>', bill_no, '</b>', ' <br> ', DATE_FORMAT(bill_date, '%d-%m-%Y')) AS bill_display",
        // "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
        // "count(dc in(dc_num)) as dccount",
        // "COUNT(DISTINCT dc_num) AS dccount",
        "vendor_inv_attach_approval_date",
        "vendor_name",
        "SUM(amount) AS total_amount",
        "acctdsvalue",
        "accotherdeduction",
        "advancepayment",
        "acctotalpaybleamount",

        "get_staff_name((vendor_bill_approval)) AS vendor_bill_approval",
        "get_staff_name((finance_approved_by)) AS finance_approved_by",
        "get_staff_name((managment_team_approvedby)) AS managment_team_approvedby",


        "account_remark",

        "unique_id",
        "bill_no",
        "accounts_approval",
        "vendor_id",
        "invoice_no",
        "po_num",
        "finance_approval",
        "get_vendor_address(vendor_id) AS address",
        "get_vendor_id(vendor_id) AS vendor_reg_id",
        "get_vendor_contact(vendor_id) AS contact_no",
        "acctdsvalue",
        "accotherdeduction",
        "acctotalpaybleamount",
        "veninvverifyid",
        "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y')AS vendor_bill_approval_date",
        "DATE_FORMAT(finance_approved_date,'%d-%m-%Y')AS finance_approved_date",
        "DATE_FORMAT(managment_team_approvaldate,'%d-%m-%Y')AS managment_team_approvaldate",
        "bill_date",
        "inv_verfiy_attach",
        "po_ven_filename"
    ];

    $table_details_ven = [
        $table_vendor,
        $columns1
    ];

    $where_1 = [
        "bill_no" => $bill_no,
        "is_delete" => 0
    ];


    $result_values1 = $pdo->select($table_details_ven, $where_1);


    if ($result_values1->status) {
        $result_values1 = $result_values1->data;

        $remarks = $result_values1[0]["account_remark"];
        $vendor_inv_attach_approval_date = $result_values1[0]["vendor_inv_attach_approval_date"];
        $veninvverifyid = $result_values1[0]["veninvverifyid"];
        $inv_verfiy_attach = $result_values1[0]["inv_verfiy_attach"];
        $bill_no = $result_values1[0]["bill_no"];
        $bill_date = $result_values1[0]["bill_date"];

        $vendor_bill_approval = $result_values1[0]["vendor_bill_approval"];
        $vendor_bill_approval_date = $result_values1[0]["vendor_bill_approval_date"];


        $result_values1[0]['inv_verfiy_attach'] = image_view_3("vendorpayment", $result_values1[0]['unique_id'], $inv_verfiy_attach);

        $attach = $result_values1[0]['inv_verfiy_attach'];

         $po_venfile_name = $result_values1[0]['po_ven_filename'];

        // $po_venfile_name = image_view_4("vendorpayment", $result_values1[0]['unique_id'], $po_attach);
// 
        

        $vendor_name = $result_values1[0]['vendor_name'];
        $vendor_reg_id = $result_values1[0]['vendor_reg_id'];
        $address = $result_values1[0]['address'];
        $contact_no = $result_values1[0]['contact_no'];
        $accounts_approval = $result_values1[0]['accounts_approval'];
        $finance_approved_by = $result_values1[0]['finance_approved_by'];
        $finance_approved_by = $result_values1[0]['finance_approved_by'];
        $finance_approved_date = $result_values1[0]['finance_approved_date'];

        $managment_team_approvedby = $result_values1[0]['managment_team_approvedby'];
        $managment_team_approvaldate = $result_values1[0]['managment_team_approvaldate'];



        $result_values1[0]['vendor_name'] = "<div>
                        <strong>{$vendor_reg_id}</strong><br>
                        <span>{$address} - Ph.No. {$contact_no}</span>
                    </div>";
        // print_r( $attach);die();

    }
}


function image_view_3($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view_3 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_3(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_3(\'/' . $file_name . '\')"><img src="uploads/vendor_payment/pdf.png"  height="30px" width="50px" ></a>';
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

?>

<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <input type="HIDDEN" id="payment_id" name="payment_id" class="form-control" value="<?php echo $newVendorId; ?>">
        <input type="hidden" name="unique_id" id="unique_id" value="<?= $unique_id ?>">
        <input type="hidden" name="bill_no" id="bill_no" value="<?= $bill_no ?>">
        <input type="hidden" name="vendor_id" id="vendor_id" value="<?= $vendor_id ?>">
        <input type="hidden" name="vendor_name" id="vendor_name" value="<?= $name ?>">
        <div class="card-body">
            <div class="card-header" style="margin:0px !important">
                <h5 class="modal-title fw-bold w-100" style="color: #506018;">Payment Transaction Form</h5>
            </div>
            <div class="container-fluid">

                <input type="hidden" name="po_num" id="po_num">
                <input type="hidden" name="vendor_name" id="vendor_name">
                <input type="hidden" name="vendor_id" id="vendor_id">
                <input type="hidden" name="main_unique_id_1" id="main_unique_id_1">
                <!-- <input type="hidden" name="main_unique_id_1" id="main_unique_id_1"> -->
                <!-- Vendor Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">

                            <!-- Vendor Details -->
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-body-secondary mb-3"
                                    style="font-size: large; color: #878a99;">Vendor Details</h6>
                                <h6 style="font-size: 16px; color: #506018;"><strong><span
                                            id="vendor_com_name_popup_1"><?= htmlspecialchars($company_name) ?></span></strong><br><strong><span
                                            id="vendor_name_popup_1"><?= htmlspecialchars($name) ?></span></strong></h6>
                                <p class="mb-1"><i data-feather="map-pin"
                                        style="width:15px; height:15px; color:#506018"></i> <span
                                        id="address_popup_1"><?= htmlspecialchars($address) ?></span></p>
                                <p class="mb-1">GST No: <b><span
                                            id="gst_no_popup_1"><?= htmlspecialchars($gst_no) ?></span></b>, PAN No:
                                    <b><span id="pan_no_popup_1"><?= htmlspecialchars($pan_no) ?></span></b></p>
                                <p class="mb-1"><i data-feather="mail"
                                        style="width:15px; height:15px; color:#506018"></i> <span
                                        id="mail_popup_1"><?= htmlspecialchars($mail_id) ?></span></p>
                                <p class="mb-1"><i data-feather="phone"
                                        style="width:15px; height:15px; color:#506018"></i> <span
                                        id="contact_no_popup_1"><?= htmlspecialchars($contact_no) ?></span></p>
                                <br>
                                <br>
                                <br>
                                <!-- Vendor Bill Approval -->
                                <h6 class="text-uppercase text-body-secondary mt-4 mb-3"
                                    style="font-size: large; color: #878a99;">Vendor Bill Approval Details</h6>
                                <h6 style="font-size: 16px; color: #506018;"><strong><span
                                            id="ven_approval_id_1"><?= htmlspecialchars($vendor_bill_approval) ?></span></strong>
                                </h6>
                                <p class="mb-1"><i data-feather="calendar"
                                        style="width:15px; height:15px; color:#506018"></i> <b><span
                                            id="ven_approval_date_1"><?= !empty($vendor_bill_approval_date) ? date('d-m-Y', strtotime($vendor_bill_approval_date)) : 'N/A'; ?></span></b>
                                </p>
                            </div>

                            <!-- Vendor Bill & Invoice -->
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-body-secondary mb-3"
                                    style="font-size: large; color: #878a99;">Vendor Bill Details</h6>
                                <h6 style="font-size: 16px; color: #506018;"><strong><span
                                            id="bill_no_popup_1"><?= htmlspecialchars($bill_no) ?></span></strong></h6>
                                <p class="mb-1"><i data-feather="calendar"
                                        style="width:15px; height:15px; color:#506018"></i> <b><span
                                            id="bill_date_popup_1"><?= !empty($bill_date) ? date('d-m-Y', strtotime($bill_date)) : 'N/A'; ?></span></b>
                                </p>

                                <h6 class="text-uppercase text-body-secondary mt-4 mb-3"
                                    style="font-size: large; color: #878a99;">Vendor Invoice Details</h6>
                                <h6 style="font-size: 16px; color: #506018;"><strong><span
                                            id="ven_inv_id_1"><?= htmlspecialchars($veninvverifyid) ?></span></strong>
                                </h6>
                                <p class="mb-1"><i data-feather="calendar"
                                        style="width:15px; height:15px; color:#506018"></i> <b><span
                                            id="ven_inv_date_1"><?= !empty($vendor_inv_attach_approval_date) ? date('d-m-Y', strtotime($vendor_inv_attach_approval_date)) : 'N/A'; ?></span></b>
                                </p>

                                <!-- Invoice Attachment -->
                                <div class="d-flex align-items-center mb-1">
                                    <strong class="label-col text-body-secondary">Invoice Attach</strong>
                                    <span class="ms-1">:</span>
                                    <span class="ms-2">
                                        <?php if (!empty($inv_verfiy_attach)): ?>
                                            <a href="uploads/vendorpayment/<?= htmlspecialchars($inv_verfiy_attach) ?>"
                                                target="_blank">
                                                <img src="uploads/vendorpayment/pdf.png" height="20" width="20"
                                                    alt="Preview PDF">
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </span>
                                </div>

                                 <div class="d-flex align-items-center mb-1">
                                    <strong class="label-col text-body-secondary">PO Attach</strong>
                                    <span class="ms-1">:</span>
                                    <span class="ms-2">
                                        <?php if (!empty($po_venfile_name)): ?>
                                            <a href="uploads/vendorpayment/PO copy/<?= htmlspecialchars($po_venfile_name) ?>"
                                                target="_blank">
                                                <img src="uploads/vendorpayment/pdf.png" height="20" width="20"
                                                    alt="Preview PDF">
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </span>
                                </div>


                                <!-- ACCOUNTS TEAM APPROVAL -->

                                <h6 class="text-uppercase text-body-secondary mt-4 mb-3"
                                    style="font-size: large; color: #878a99;">Accounts Team Approval Details</h6>
                                <h6 style="font-size: 16px; color: #506018;"><strong><span
                                            id="ven_inv_id_1"><?= htmlspecialchars($finance_approved_by) ?></span></strong>
                                </h6>
                                <p class="mb-1"><i data-feather="calendar"
                                        style="width:15px; height:15px; color:#506018"></i> <b><span
                                            id="ven_inv_date_1"><?= $finance_approved_date ?></span></b></p>
                            </div>

                            <!-- Vendor Bank Details -->
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-body-secondary mb-3"
                                    style="font-size: large; color: #878a99;">Vendor Bank Details</h6>
                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">Vendor Bank Name</div>
                                    <div style="width: 10px;">:</div>
                                    <div><?= htmlspecialchars($bank_name) ?></div>
                                </div>

                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">Branch</div>
                                    <div style="width: 10px;">:</div>
                                    <div><i data-feather="map-pin" style="width:15px; height:15px;"></i>
                                        <?= htmlspecialchars($branch_name) ?></div>
                                </div>

                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">Account No</div>
                                    <div style="width: 10px;">:</div>
                                    <div><?= htmlspecialchars($account_no) ?></div>
                                </div>

                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">IFSC Code</div>
                                    <div style="width: 10px;">:</div>
                                    <div><?= htmlspecialchars($ifsc_code) ?></div>
                                </div>

                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">Account Holder</div>
                                    <div style="width: 10px;">:</div>
                                    <div><?= htmlspecialchars($acc_holder_name) ?? '-'; ?></div>
                                </div>

                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">PAN Copy</div>
                                    <div style="width: 10px;">:</div>
                                    <div>
                                        <?php if (!empty($pan_attach_file_name)) { ?>

                                            <a href="uploads/vendor_creation/<?= htmlspecialchars($pan_attach_file_name) ?>"
                                                target="_blank">
                                                <img src="uploads/vendor_creation/pdf.png" height="20" width="20"
                                                    alt="Preview PDF">
                                            </a>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="d-flex mb-1">
                                    <div style="width: 120px;">Bank Proof</div>
                                    <div style="width: 10px;">:</div>
                                    <div>
                                        <?php if (!empty($bank_proof)) { ?>
                                            <a href="uploads/vendor_creation/<?= htmlspecialchars($bank_proof) ?>"
                                                target="_blank">
                                                <img src="uploads/vendor_creation/pdf.png" height="20" width="20"
                                                    alt="Preview PDF">
                                            </a>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ACCOUNTS TEAM APPROVAL -->
                                <br>

                                <h6 class="text-uppercase text-body-secondary mt-4 mb-3"
                                    style="font-size: large; color: #878a99;">Management Team Approval Details</h6>
                                <h6 style="font-size: 16px; color: #506018;">
                                    <strong><span><?= htmlspecialchars($managment_team_approvedby) ?></span></strong>
                                </h6>
                                <p class="mb-1"><i data-feather="calendar"
                                        style="width:15px; height:15px; color:#506018"></i>
                                    <b><span><?= $managment_team_approvaldate ?></span></b></p>
                            </div>
                            </br>
                            <div id="list">
                                <div class="table-responsive">
                                    <table id="vendor_datatable"
                                        class="table table-bordered table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <!-- <th>Selection<br>(Select All)
                                                <?php echo '<input type="checkbox" id="select_all">' ?>
                                            </th> -->
                                                <th style="text-align:center;">S.No</th>
                                                <th style="text-align:center;">PO No. / Date</th>
                                                <th style="text-align:center;">Invoice No / Date</th>
                                                <th style="text-align:center;">Invoice Qty</th>
                                                <th style="text-align:center;">DC No / Date</th>
                                                <th style="text-align:center;">Unit Price</th>
                                                <th style="text-align:center;">Basic amount</th>
                                                <th style="text-align:center;">GST</th>
                                                <th style="text-align:center;">GsT Amount</th>
                                                <th style="text-align:center;">Total Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Right Column: Amounts -->
                            <style>
                                /* Consistent right alignment with fixed label width */
                                .amount-row {
                                    display: flex;
                                    justify-content: flex-end;
                                    align-items: center;
                                    margin-bottom: 4px;
                                }

                                .amount-label {
                                    min-width: 220px;
                                    /* Adjust for equal alignment */
                                    text-align: right;
                                    font-weight: bold;
                                }

                                .amount-value {
                                    min-width: 100px;
                                    text-align: right;
                                    color: #506018 !important;
                                    font-weight: bold;
                                }
                            </style>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="amount-row">
                                        <div class="amount-label">Total Amount:</div>
                                        <div class="amount-value" id="ttl_span_amnt" style="font-size:17px;"></div>
                                    </div>
                                    <div class="amount-row">
                                        <div class="amount-label">TDS Deduction:</div>
                                        <div class="amount-value" id="ttl_tds_amnt"></div>
                                    </div>
                                    <div class="amount-row">
                                        <div class="amount-label">Other Deduction:</div>
                                        <div class="amount-value" id="ttl_others_amnt"></div>
                                    </div>
                                    <div class="amount-row">
                                        <div class="amount-label">Advance Amount:</div>
                                        <div class="amount-value" id="advanceamount"></div>
                                    </div>
                                    <div class="amount-row">
                                        <div class="amount-label">Total Payable Amount:</div>
                                        <div class="amount-value" id="ttl_payble_amnt"></div>
                                    </div>
                                </div>

                                <!-- Amount in Words (Full Width Right-Aligned) -->
                                <div class="col-md-12 mt-2 text-end">
                                    <div class="fw-bold">
                                        Total Amount In Words:&nbsp;
                                        <span id="ttl_span_amnt_words"
                                            style="color: #506018 !important; font-size:15px;">
                                            Sixty-Four Thousand Six Hundred One Only
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <style>
                                /* General layout consistency */
                                .form-label {
                                    font-weight: 600;
                                }

                                .form-section {
                                    margin-top: 25px;
                                }

                                /* Remarks alignment */
                                .remarks-section {
                                    display: flex;
                                    align-items: flex-start;
                                    justify-content: space-between;
                                }

                                .remarks-section .remarks-box {
                                    width: 100%;
                                }

                                .remarks-section button {
                                    white-space: nowrap;
                                    height: 40px;
                                }
                            </style>

                            <div class="row mt-3">
                                <div class="col-md-6 remarks-section">
                                    <div class="remarks-box me-3">
                                        <label for="remark" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="4"
                                            oninput="validateremark(this)"><?php echo $remarks; ?></textarea>
                                    </div>
                                    <!-- <div class="d-flex align-items-start">
                                        <button type="button" class="btn btn-primary mt-5"
                                            onclick="update_remark()">Update</button>
                                    </div> -->
                                </div>
                            </div>

                            <!-- Transaction Section -->
                            <div class="row form-section align-items-end">
                                <div class="col-md-3">
                                    <label for="transaction_type" class="form-label">Transaction Type</label>
                                    <select class="form-select" id="transaction_type">
                                        <option value="">Select transaction type</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Bank</option>
                                        <option value="3">UPI</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="transaction_date" class="form-label">Transaction Date</label>
                                    <input type="date" class="form-control" id="transaction_date">
                                </div>

                                <div class="col-md-3" id="cash_section" style="display: none;">
                                    <label for="cash_receipt" class="form-label">
                                        Upload Cash Receipt <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" id="cash_receipt"
                                        accept=".pdf, .jpg, .jpeg, .png" onchange="validateFileType(this);">
                                    <div id="cash_receipt_error" class="text-danger small"></div>
                                </div>


                                <!-- Online Section -->
                                <div class="col-md-3" id="online_section" style="display: none;">
                                    <label for="online_type" class="form-label">Select Online Method</label>
                                    <select class="form-select" id="online_type">
                                        <option value="" selected disabled>Select method</option>
                                        <option value="1">Google Pay</option>
                                        <option value="2">PhonePe</option>
                                        <option value="3">Paytm</option>
                                    </select>
                                </div>

                                <!-- UPI ID -->
                                <div class="col-md-3" id="upi_id_section" style="display: none;">
                                    <label for="upi_id" class="form-label">UPI ID<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="upi_id" placeholder="Enter UPI ID"
                                        onkeydown="return allowOnlyValidUpiCharacters(event)"
                                        oninput="removeUpiRedBorder(this)">
                                    <div id="upi_id_error" class="text-danger small"></div>
                                </div>

                                <!-- Mobile Number -->
                                <div class="col-md-3" id="upi_mobile_section" style="display: none;">
                                    <label for="upi_mobile" class="form-label">Mobile Number<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="upi_mobile"
                                        placeholder="Enter mobile number" onkeydown="return allowOnlyMobileKeys(event)"
                                        oninput="removeUpiRedBorder(this)" maxlength="10">
                                    <div id="mobile_error" class="text-danger small"></div>
                                </div>

                                <!-- Transaction ID (UPI) -->
                                <div class="col-md-3 mt-3" id="upi_transaction_section_2" style="display: none;">
                                    <label for="transaction_id_2" class="form-label">Transaction ID<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="transaction_id_2"
                                        placeholder="Enter transaction ID"
                                        onkeydown="return allowOnlyAlphanumeric(event)"
                                        oninput="removeUpiRedBorder(this)">
                                    <div id="transaction_error_2" class="text-danger small"></div>
                                </div>
                                <style>
                                    .bank-info {
                                        display: flex;
                                        align-items: center;
                                        margin-bottom: 6px;
                                    }

                                    .bank-label {
                                        min-width: 130px;
                                        /* Adjust width for perfect alignment */
                                        text-align: right;
                                        font-weight: 600;
                                        color: #343a40;
                                    }

                                    .bank-separator {
                                        width: 10px;
                                        text-align: center;
                                    }

                                    .bank-value {
                                        flex: 1;
                                        color: #506018;
                                        font-weight: 500;
                                    }
                                </style>
                                <!-- Bank Section -->
                                <div class="row form-section align-items-end" id="bank_section" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="row g-4">
                                            <!-- Left Column -->
                                            <div class="col-md-3">
                                                <div class="bank-info">
                                                    <div class="bank-label">Bank Name</div>
                                                    <div class="bank-separator">:</div>
                                                    <div class="bank-value"><?= $bank_name ?></div>
                                                </div>
                                                <input type="hidden" id="bank_name" value="<?= $bank_name; ?>">

                                                <div class="bank-info">
                                                    <div class="bank-label">IFSC Code</div>
                                                    <div class="bank-separator">:</div>
                                                    <div class="bank-value"><?= $ifsc_code ?></div>
                                                </div>
                                                <input type="hidden" id="ifsc_code" value="<?= $ifsc_code ?>">

                                                <div class="bank-info">
                                                    <div class="bank-label">Pincode</div>
                                                    <div class="bank-separator">:</div>
                                                    <div class="bank-value"><?= $pincode ?></div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-3">
                                                <div class="bank-info">
                                                    <div class="bank-label">Account No</div>
                                                    <div class="bank-separator">:</div>
                                                    <div class="bank-value"><?= $account_no ?></div>
                                                </div>
                                                <input type="hidden" id="account_no" value="<?= $account_no ?>">
                                                <div class="bank-info">
                                                    <div class="bank-label">Branch Name</div>
                                                    <div class="bank-separator">:</div>
                                                    <div class="bank-value"><?= $branch_name ?></div>
                                                </div>
                                                <input type="hidden" id="branch_name" value="<?= $branch_name ?>">
                                            </div>

                                            <!-- Transaction ID -->
                                            <div class="col-md-3">
                                                <label for="transaction_id_1" class="form-label fw-bold">
                                                    Transaction ID<span class="text-danger">*</span>
                                                </label>

                                                <input type="text" class="form-control" id="transaction_id_1"
                                                    placeholder="Enter transaction ID"
                                                    onkeydown="return allowOnlyAlphanumeric(event)"
                                                    oninput="validateTransactionId1();removeTransactionRedBorder(this)"
                                                    required>
                                                <div id="transaction_error_1" class="text-danger small"></div>
                                            </div>


                                            <div class="col-md-3">
                                                <label for="transaction_id_1" class="form-label fw-bold">
                                                    Bank Name<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="bankname"
                                                    placeholder="Enter transaction ID"
                                                    onkeydown="return allowOnlyAlphanumeric(event)"
                                                    oninput="validateTransactionId1();removeTransactionRedBorder(this)"
                                                    required>
                                                <div id="banknameerror" class="text-danger small"></div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- Submit Buttons -->
                                <div class="row mt-3">
                                    <div class="col-md-12 text-end">
                                        <?= btn_cancel($btn_cancel); ?>
                                        <?php if ($accounts_approval != '1'): ?>
                                            <button type="button" class="btn btn-success"
                                                onclick="vendor_payment();update_remark();">Submit</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function allowOnlyValidUpiCharacters(event) {
                        const allowedKeys = [
                            ...'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@._-',
                            'Backspace', 'ArrowLeft', 'ArrowRight', 'Delete', 'Tab'
                        ];

                        // Block Enter key
                        if (event.key === "Enter") {
                            event.preventDefault();
                            return false;
                        }

                        // Allow only valid characters
                        if (!allowedKeys.includes(event.key)) {
                            event.preventDefault();
                            return false;
                        }

                        return true;
                    }

                    function validateUpiId() {
                        const upiInput = document.getElementById('upi_id');
                        const errorDiv = document.getElementById('upi_id_error');
                        const upi = upiInput.value.trim();

                        const upiRegex = /^[a-zA-Z0-9.\-_]{2,256}@[a-zA-Z]{2,64}$/;

                        if (upi === '') {
                            errorDiv.textContent = '';
                            upiInput.classList.remove('is-invalid');
                        } else if (!upiRegex.test(upi)) {
                            errorDiv.textContent = 'Invalid UPI ID format (e.g., name@bank)';
                            upiInput.classList.add('is-invalid');
                        } else {
                            errorDiv.textContent = '';
                            upiInput.classList.remove('is-invalid');
                        }
                    }


                    // ✅ Allow only number keys, Backspace, Delete, Arrow keys, Tab
                    function allowOnlyMobileKeys(event) {
                        const key = event.key;

                        // Allow control keys
                        const allowedControlKeys = [
                            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'
                        ];

                        // Allow digits 0–9
                        const isDigit = /^[0-9]$/.test(key);

                        if (isDigit || allowedControlKeys.includes(key)) {
                            return true;
                        }

                        // ❌ Block everything else
                        event.preventDefault();
                        return false;
                    }

                    // ✅ Validate full mobile number format (starts with 6–9, 10 digits)
                    function validateMobileNumber() {
                        const input = document.getElementById('upi_mobile');
                        const errorDiv = document.getElementById('mobile_error');
                        const mobile = input.value.trim();

                        const mobileRegex = /^[6-9][0-9]{9}$/;

                        if (mobile === '') {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                        } else if (!mobileRegex.test(mobile)) {
                            errorDiv.textContent = 'Enter a valid 10-digit mobile number starting with 6, 7, 8, or 9';
                            input.classList.add('is-invalid');
                        } else {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                        }
                    }

                    // Allow only letters, numbers, and control keys
                   function allowOnlyAlphanumeric(event) {
    const key = event.key;

    // Allow letters and numbers
    const isAlphanumeric = /^[a-zA-Z0-9]$/.test(key);

    // Allow space
    const isSpace = key === " ";

    // Allow control keys
    const allowedControlKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];

    if (isAlphanumeric || isSpace || allowedControlKeys.includes(key)) {
        return true;
    }

    // Block other characters
    event.preventDefault();
    return false;
}

                    // Optional: Validate input (e.g., min length)
                    function validateTransactionId() {
                        const input = document.getElementById('transaction_id_2');
                        const errorDiv = document.getElementById('transaction_error');
                        const value = input.value.trim();

                        if (value === '') {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                            // input.style.border = '1px solid red';
                        } else if (value.length < 6) {
                            errorDiv.textContent = 'Transaction ID must be at least 6 characters';
                            input.classList.add('is-invalid');

                        } else {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                            // input.style.border = '1px solid red';
                        }
                    }

                    // function allowOnlyAlphanumeric(event) {
                    //     const key = event.key;

                    //     // Allow only letters and numbers
                    //     const isAlphanumeric = /^[a-zA-Z0-9]$/.test(key);

                    //     // Allow control keys (Backspace, arrows, delete, tab)
                    //     const allowedControlKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];

                    //     if (isAlphanumeric || allowedControlKeys.includes(key)) {
                    //         return true;
                    //     }

                    //     // Block anything else (like !, @, #, etc.)
                    //     event.preventDefault();
                    //     return false;
                    // }





                    // function validatePdfOnly() {
                    //     const input = document.getElementById('cash_receipt');
                    //     const errorDiv = document.getElementById('cash_receipt_error');
                    //     const file = input.files[0];

                    //     if (!file) {
                    //         errorDiv.textContent = '';
                    //         return;
                    //     }

                    //     const fileName = file.name;
                    //     const fileExtension = fileName.split('.').pop().toLowerCase();

                    //     if (fileExtension !== 'pdf') {
                    //         errorDiv.textContent = 'Only PDF files are allowed.';
                    //         input.value = ''; // Clear the invalid file
                    //     } else {
                    //         errorDiv.textContent = '';
                    //     }
                    // }

                    // function validateFileType() {
                    //     const input = document.getElementById('cash_receipt');
                    //     const errorDiv = document.getElementById('cash_receipt_error');
                    //     const file = input.files[0];

                    //     if (!file) {
                    //         errorDiv.textContent = '';
                    //         return;
                    //     }

                    //     const fileName = file.name;
                    //     const fileExtension = fileName.split('.').pop().toLowerCase();
                    //     const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

                    //     if (!allowedExtensions.includes(fileExtension)) {
                    //         errorDiv.textContent = 'Only PDF, JPG, JPEG, or PNG files are allowed.';
                    //         input.value = ''; // Clear invalid file
                    //     } else {
                    //         errorDiv.textContent = '';
                    //     }
                    // }

                    // function validateFileType(input) {
                    //     const errorDiv = document.getElementById('cash_receipt_error');
                    //     const file = input.files[0];

                    //     if (!file) {
                    //         // No file selected — show red border
                    //         input.style.border = '1px solid red';
                    //         errorDiv.textContent = 'Please upload a file.';
                    //         return false;
                    //     }

                    //     const fileName = file.name;
                    //     const fileExtension = fileName.split('.').pop().toLowerCase();
                    //     const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

                    //     if (!allowedExtensions.includes(fileExtension)) {
                    //         // Invalid file type — show red border
                    //         input.style.border = '1px solid red';
                    //         errorDiv.textContent = 'Only PDF, JPG, JPEG, or PNG files are allowed.';
                    //         input.value = ''; // Clear invalid file
                    //         return false;
                    //     }

                    //     // Valid file — remove red border
                    //     input.style.border = '1px solid #ced4da'; // Bootstrap default
                    //     errorDiv.textContent = '';
                    //     return true;
                    // }
                    function validateFileType(input) {
                        const errorDiv = document.getElementById('cash_receipt_error');
                        const file = input.files[0];

                        if (!file) {
                            // No file selected — show red border
                            input.style.border = '1px solid red';
                            errorDiv.textContent = 'Please upload a file.';
                            return false;
                        }

                        const fileName = file.name;
                        const fileExtension = fileName.split('.').pop().toLowerCase();
                        const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];

                        if (!allowedExtensions.includes(fileExtension)) {
                            // Invalid file type — show red border and clear input
                            input.style.border = '1px solid red';
                            errorDiv.textContent = 'Only PDF, JPG, JPEG, or PNG files are allowed.';
                            input.value = '';
                            return false;
                        }

                        // ✅ Valid file — remove red border and error
                        input.style.border = '1px solid #ced4da'; // Bootstrap default
                        errorDiv.textContent = '';
                        return true;
                    }



                    // function validateFileType() {
                    //   const fileInput = document.getElementById('cash_receipt');
                    //   const filePath = fileInput.value;
                    //   const allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.png)$/i;
                    //   const errorDiv = document.getElementById('cash_receipt_error');

                    //   if (!allowedExtensions.exec(filePath)) {
                    //     errorDiv.textContent = "Only PDF, JPG, JPEG, or PNG files are allowed.";
                    //     fileInput.value = ''; // clear invalid file
                    //     return false;
                    //   } else {
                    //     errorDiv.textContent = ''; // clear error
                    //   }
                    // }


                    $(document).ready(function () {

                        const today = new Date();
                        const formattedDate = today.getFullYear() + '-' +
                            String(today.getMonth() + 1).padStart(2, '0') + '-' +
                            String(today.getDate()).padStart(2, '0');

                        document.getElementById("transaction_date").value = formattedDate;

                        // var po_num = $(this).data('ponum');
                        var vendor = document.getElementById("vendor_id").value;
                        var bill_no = document.getElementById("bill_no").value;

                        // document.getElementById("po_num").value = po_num;
                        // document.getElementById("vendor_name").value = vendor;

                        var ajax_url = sessionStorage.getItem("folder_crud_link");

                        $.ajax({
                            url: ajax_url,
                            method: 'POST',
                            data: {
                                vendor: vendor,
                                bill_no: bill_no,
                                action: 'vendor_payment_details'
                            },
                            success: function (res) {
                                if (res.data && res.data.length > 0) {
                                    const firstRow = res.data[0];  // Use this for TDS, deductions, payable, invoice_no

                                    $('#ttl_tds_amnt').text('₹ ' + (firstRow.acctdsvalue || '0'));
                                    $('#ttl_others_amnt').text('₹ ' + (firstRow.accotherdeduction || '0'));
                                    $('#ttl_payble_amnt').text('₹ ' + (firstRow.acctotalpaybleamount || '0'));
                                    $('#advanceamount').text('₹ ' + (firstRow.advancepayment || '0'));



                                    $('#transaction_type_1').text(firstRow.transaction_type || '-');
                                    $('#transaction_date_1').text(firstRow.transaction_date || '-');
                                    $('#transaction_id_1').text(firstRow.transaction_id || '-');

                                    console.log(firstRow);
                                    $('#invoice_val').text(firstRow.invoice_no);

                                    //             if (firstRow.cash_receipt_file_name) {
                                    //     var fileUrl = "http://103.110.236.187/otm_beta/uploads/accounts_approval/" + firstRow.cash_receipt_file_name;
                                    //     $('#cash_receiptile').html(
                                    //         '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
                                    //             '<img src="uploads/accounts_approval/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
                                    //         '</a>'
                                    //     );
                                    // } else {
                                    //     $('#cash_receiptile').text('N/A');
                                    // }

                                    let total_amount = 0;
                                    let total_amount1 = 0
                                    let tableHtml = '';

                                    res.data.forEach((row, index) => {
                                        let rawAmount = row.sum_amount || row.amount || 0;

                                        let rawAmount1 = row.acctotalpaybleamount || 0;

                                        // Clean the amount
                                        let cleanAmount = parseFloat(
                                            rawAmount.toString().replace(/₹/g, '').replace(/,/g, '')
                                        ) || 0;
                                        total_amount += cleanAmount;


                                        // Clean the amount
                                        let cleanAmount1 = parseFloat(
                                            rawAmount1.toString().replace(/₹/g, '').replace(/,/g, '')
                                        ) || 0;


                                        total_amount1 = cleanAmount1;

                                        tableHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.po_num || ''}</td>
                        <td>${row.invoice_no || ''}</td>
                        <td>${row.invoice_qty || ''}</td>
                        <td>${row.dc_num || ''}</td>
                        <td>${row.rate || ''}</td>
      <td style="text-align:right;">${row.basicamt || 0}</td>

                        <td>${row.gst || ''}</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

                        <td>${row.amount || ''}</td>
                    </tr>
                `;
                                    });

                                    $('#vendor_datatable tbody').html(tableHtml);

                                    // Format total amount with 2 decimal places in Indian format
                                    const formattedTotal = total_amount.toLocaleString('en-IN', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });

                                    // ✅ Append values from firstRow (not undefined row)
                                    $('#ttl_span_amnt').text('₹ ' + formattedTotal);

                                    // Convert to words using your function
                                    $('#ttl_span_amnt_words').text(numberToWords(total_amount1));
                                } else {
                                    $('#vendor_datatable tbody').html('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                                }
                            },

                            error: function () {
                                alert('Failed to fetch details');
                            }

                        });
                    });



                    function update_remark() {

                        var remark = $('#remark').val();

                        var bill_no = $('#bill_no').val();

                        var ajax_url = sessionStorage.getItem("folder_crud_link");

                        var url = sessionStorage.getItem("list_link");

                        var data = {
                            remark: remark,
                            bill_no: bill_no,
                            "action": 'update_remark'
                        };

                        $.ajax({
                            url: ajax_url,
                            type: 'POST',
                            data: data,

                            success: function (data) {
                                let res = JSON.parse(data);
                                if (res.status == 1) {
                                    // sweetalert(res.msg, url);
                                } else {
                                    alert("Error: " + res.msg);
                                    console.log(res.error, res.sql);
                                }
                            }


                        });
                    }


                    // function vendor_payment() {
                    //     var ajax_url = sessionStorage.getItem("folder_crud_link");

                    //     var vendor_name = $('#vendor_name').val();
                    //     var bill_no = $('#bill_no').val();
                    //     var transaction_type = $('#transaction_type').val();

                    //     var data = new FormData();
                    //     data.append("vendor_name", vendor_name);
                    //     data.append("bill_no", bill_no);
                    //     data.append("transaction_type", transaction_type);

                    //     // Transaction Type: 1 - Cash
                    //     if (transaction_type == 1) {
                    //         var cashReceipt = document.getElementById("cash_receipt");
                    //         if (cashReceipt && cashReceipt.files.length > 0) {
                    //             data.append("cash_receipt", cashReceipt.files[0]);
                    //         } else {
                    //             data.append("cash_receipt", '');
                    //         }

                    //         data.append("bank_name", "");
                    //         data.append("ifsc_code", "");
                    //         data.append("account_no", "");
                    //         data.append("branch_name", "");
                    //         data.append("online_type", "");
                    //         data.append("upi_id", "");
                    //         data.append("upi_mobile", "");
                    //     }

                    //     // Transaction Type: 2 - Bank
                    //     else if (transaction_type == 2) {
                    //         var bank_name = $('#bank_name').val();
                    //         var ifsc_code = $('#ifsc_code').val();
                    //         var account_no = $('#account_no').val();
                    //         var branch_name = $('#branch_name').val();

                    //         data.append("bank_name", bank_name);
                    //         data.append("ifsc_code", ifsc_code);
                    //         data.append("account_no", account_no);
                    //         data.append("branch_name", branch_name);

                    //         data.append("online_type", "");
                    //         data.append("upi_id", "");
                    //         data.append("upi_mobile", "");
                    //         data.append("cash_receipt", '');
                    //     }

                    //     // Transaction Type: 3 - UPI
                    //     else if (transaction_type == 3) {
                    //         var online_type = $('#online_type').val();
                    //         var upi_id = $('#upi_id').val();
                    //         var upi_mobile = $('#upi_mobile').val();

                    //         data.append("online_type", online_type);
                    //         data.append("upi_id", upi_id);
                    //         data.append("upi_mobile", upi_mobile);

                    //         data.append("bank_name", "");
                    //         data.append("ifsc_code", "");
                    //         data.append("account_no", "");
                    //         data.append("branch_name", "");
                    //         data.append("cash_receipt", '');
                    //     }

                    //     // If no transaction type matched
                    //     else {
                    //         data.append("bank_name", "");
                    //         data.append("ifsc_code", "");
                    //         data.append("account_no", "");
                    //         data.append("branch_name", "");
                    //         data.append("online_type", "");
                    //         data.append("upi_id", "");
                    //         data.append("upi_mobile", "");
                    //         data.append("cash_receipt", '');
                    //     }

                    //     data.append("action", "payment_store_detail");

                    //     $.ajax({
                    //         type: "POST",
                    //         url: ajax_url,
                    //         data: data,
                    //         processData: false,
                    //         contentType: false,
                    //         success: function (response) {
                    //             sweetalert('create');
                    //             window.location = "index.php?file=accounts_vendor_approval/list";
                    //         },
                    //         error: function () {
                    //             alert("Network Error");
                    //         }
                    //     });
                    // }

                    // Optional: validate content (e.g., minimum 6 characters)
                    // Validate Transaction ID length
                    function validateTransactionId1() {
                        const input = document.getElementById('transaction_id_1');
                        const errorDiv = document.getElementById('transaction_error_1');
                        const value = input.value.trim();

                        if (value === '') {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                        } else if (value.length < 6) {
                            errorDiv.textContent = 'Transaction ID must be at least 6 characters';
                            input.classList.add('is-invalid');
                        } else {
                            errorDiv.textContent = '';
                            input.classList.remove('is-invalid');
                        }
                    }

                    // Remove red border on typing
                    function removeTransactionRedBorder(input) {
                        input.classList.remove('is-invalid');
                    }

                    // // Remove red border when typing
                    // function removeUpiRedBorder(input) {
                    //     input.classList.remove('is-invalid');  // Removes red border
                    //     const errorDiv = document.getElementById(input.id + '_error');
                    //     if (errorDiv) errorDiv.textContent = ''; // Clear error message
                    // }

                    function removeUpiRedBorder(input) {
                        // Remove red border
                        input.classList.remove('is-invalid');

                        // Remove corresponding error message
                        let errorDivId = '';

                        if (input.id === 'upi_id') errorDivId = 'upi_id_error';
                        else if (input.id === 'upi_mobile') errorDivId = 'mobile_error';
                        else if (input.id === 'transaction_id_2') errorDivId = 'transaction_error_2';

                        if (errorDivId) {
                            document.getElementById(errorDivId).textContent = '';
                        }
                    }


                    // Validate UPI fields and apply red border if invalid
                    function validateUpiFields() {
                        const upiIdInput = document.getElementById('upi_id');
                        const upiMobileInput = document.getElementById('upi_mobile');
                        const transactionIdInput = document.getElementById('transaction_id_2');

                        let hasError = false;

                        // UPI ID
                        if (!upiIdInput.value.trim()) {
                            upiIdInput.classList.add('is-invalid');  // Red border
                            document.getElementById('upi_id_error').textContent = 'Please enter UPI ID';
                            hasError = true;
                        }

                        // Mobile
                        if (!upiMobileInput.value.trim()) {
                            upiMobileInput.classList.add('is-invalid');
                            document.getElementById('mobile_error').textContent = 'Please enter mobile number';
                            hasError = true;
                        } else if (!/^\d{10}$/.test(upiMobileInput.value.trim())) {
                            upiMobileInput.classList.add('is-invalid');
                            document.getElementById('mobile_error').textContent = 'Mobile number must be 10 digits';
                            hasError = true;
                        }

                        // Transaction ID
                        if (!transactionIdInput.value.trim()) {
                            transactionIdInput.classList.add('is-invalid');
                            document.getElementById('transaction_error_2').textContent = 'Please enter Transaction ID';
                            hasError = true;
                        } else if (transactionIdInput.value.trim().length < 6) {
                            transactionIdInput.classList.add('is-invalid');
                            document.getElementById('transaction_error_2').textContent = 'Transaction ID must be at least 6 characters';
                            hasError = true;
                        }

                        return !hasError; // True if all valid
                    }


                    function vendor_payment() {
                        var ajax_url = sessionStorage.getItem("folder_crud_link");

                        var vendor_name = $('#vendor_name').val();
                        var bill_no = $('#bill_no').val();
                        var transaction_type = $('#transaction_type').val();
                        var transaction_date = $('#transaction_date').val();
                        var payment_id = $('#payment_id').val();


                        // Basic Transaction Details Check
                        if (!transaction_type || !transaction_date) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Missing Fields',
                                text: 'Please Select Transaction Details.'
                            });
                            return;
                        }

                        // Prepare FormData
                        var data = new FormData();
                        data.append("vendor_name", vendor_name);
                        data.append("bill_no", bill_no);
                        data.append("transaction_type", transaction_type);
                        data.append("transaction_date", transaction_date);
                        data.append("payment_id", payment_id);
                        // data.append("bankname", bankname);



                        // ----------------- Transaction Type 1: Cash -----------------
                        if (transaction_type === "1") {
                            var cashReceipt = document.getElementById("cash_receipt");
                            var errorDiv = document.getElementById("cash_receipt_error");

                            if (!cashReceipt || cashReceipt.files.length === 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Cash Receipt Required',
                                    text: 'Please upload the Cash Receipt.'
                                });
                                if (cashReceipt) cashReceipt.classList.add('is-invalid');
                                errorDiv.textContent = 'Please upload the Cash Receipt.';
                                return;
                            }

                            data.append("cash_receipt", cashReceipt.files[0]);

                            // Reset bank & UPI fields
                            data.append("bank_name", "");
                            data.append("ifsc_code", "");
                            data.append("account_no", "");
                            data.append("branch_name", "");
                            data.append("online_type", "");
                            data.append("upi_id", "");
                            data.append("upi_mobile", "");
                            data.append("transaction_id_1", "");
                        }

                        // ----------------- Transaction Type 2: Bank -----------------
                        else if (transaction_type === "2") {
                            var payment_id = $('#payment_id').val();
                            const bank_name = $('#bank_name').val();
                            const ifsc_code = $('#ifsc_code').val();
                            const account_no = $('#account_no').val();
                            const branch_name = $('#branch_name').val();
                            const transaction_id_input = document.getElementById('transaction_id_1');
                            const transaction_id = transaction_id_input.value.trim();
                            const errorDiv = document.getElementById('transaction_error_1');
                            var banknamenew = $('#bankname').val();

                            let hasError = false;

                            // Bank fields validation
                            if (!bank_name || !ifsc_code || !account_no || !branch_name || !banknamenew) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Missing Bank Details',
                                    text: 'Please fill out all Bank details.'
                                });
                                hasError = true;
                            }

                            // Transaction ID validation
                            if (!transaction_id) {
                                transaction_id_input.classList.add('is-invalid');
                                errorDiv.textContent = 'Please Enter the Transaction ID.';
                                hasError = true;
                            } else if (transaction_id.length < 6) {
                                transaction_id_input.classList.add('is-invalid');
                                errorDiv.textContent = 'Transaction ID must be at least 6 characters';
                                hasError = true;
                            }

                            if (hasError) return;

                            // Append Bank Data
                            data.append("bank_name", bank_name);
                            data.append("banknamenew", banknamenew);
                            data.append("ifsc_code", ifsc_code);
                            data.append("account_no", account_no);
                            data.append("branch_name", branch_name);
                            data.append("transaction_id_1", transaction_id);
                            data.append("payment_id", payment_id);


                            // Reset Cash & UPI fields
                            data.append("online_type", "");
                            data.append("upi_id", "");
                            data.append("upi_mobile", "");
                            data.append("transaction_id_2", "");
                            data.append("cash_receipt", "");
                        }

                        // ----------------- Transaction Type 3: UPI -----------------
                        else if (transaction_type === "3") {
                            var payment_id = $('#payment_id').val();
                            if (!validateUpiFields()) return; // Stop submission if invalid
                            var online_type = $('#online_type').val();
                            var upi_id = $('#upi_id').val();
                            var upi_mobile = $('#upi_mobile').val();
                            var transaction_id_2 = $('#transaction_id_2').val();

                            if (!online_type || !upi_id || !upi_mobile || !transaction_id_2) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Missing UPI Details',
                                    text: 'Please fill out all UPI payment details.'
                                });
                                return;
                            }

                            data.append("online_type", online_type);
                            data.append("upi_id", upi_id);
                            data.append("upi_mobile", upi_mobile);
                            data.append("transaction_id_2", transaction_id_2);
                            data.append("payment_id", payment_id);


                            // Reset Bank & Cash fields
                            data.append("bank_name", "");
                            data.append("ifsc_code", "");
                            data.append("account_no", "");
                            data.append("branch_name", "");
                            data.append("transaction_id_1", "");
                            data.append("cash_receipt", "");
                        }

                        // ----------------- Invalid Transaction Type -----------------
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Transaction Type',
                                text: 'Please select a valid payment method.'
                            });
                            return;
                        }

                        // Submit via AJAX
                        data.append("action", "payment_store_detail");
                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Payment details saved successfully.'
                                }).then(() => {
                                    window.location = "index.php?file=accounts_vendor_approval/list";
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Network Error',
                                    text: 'Something went wrong. Please try again.'
                                });
                            }
                        });
                    }

                    function removeFileRedBorder(input) {
                        const errorDiv = document.getElementById('cash_receipt_error');

                        if (input.files.length > 0) {
                            input.style.border = '1px solid #ced4da'; // Bootstrap default
                            errorDiv.textContent = '';
                        }

                    }


                    $("#export").click(function () {
                        // alert("hi");
                        window.location = "folders/payment/excel.php";
                    });
                    $(document).ready(function () {
                        get_user_permission();

                    });

                    function get_user_permission() {
                        var screen_id_val = $('#screen_id_val').val();

                        var user_type_unique_id = $('#user_type_unique_id').val();

                        var data = {
                            "screen_id_val": screen_id_val,
                            "user_type_unique_id": user_type_unique_id,
                            "action": 'user_permission',
                        };

                        var ajax_url = sessionStorage.getItem("folder_crud_link");
                        var url = sessionStorage.getItem("list_link");

                        // console.log(data);
                        $.ajax({
                            type: "POST",
                            url: ajax_url,
                            data: data,
                            success: function (data) {

                                var obj = JSON.parse(data);

                                var dataString = obj.data;

                                var listpage = document.getElementById('list');

                            },
                            error: function (data) {
                                alert("Network Error");
                            }
                        });
                    }


                    $(document).on('change', '#select_all', function () {
                        $('.myCheck').prop('checked', this.checked);
                    });

                    $(document).ready(function () {
                        $('#transaction_type').on('change', function () {
                            var value = $(this).val();

                            // Hide all sections initially
                            $('#cash_section').hide();
                            $('#bank_section').hide();
                            $('#online_section').hide();
                            $('#upi_id_section').hide();
                            $('#upi_mobile_section').hide();
                            $('#upi_transaction_section_2').hide();

                            // Show selected section
                            if (value === '1') {
                                $('#cash_section').show();
                            } else if (value === '2') {
                                $('#bank_section').show();
                            } else if (value === '3') {
                                $('#online_section').show();
                            }
                        });
                    });

                    function fetchBankDetails(transaction_type) {
                        const vendor = $('#vendor_name').val();

                        alert(vendor);
                        var ajax_url = sessionStorage.getItem("folder_crud_link");

                        if (!vendor || !transaction_type) return;

                        $.ajax({
                            url: ajax_url,
                            type: 'POST',
                            data: {
                                action: 'getbankdeails',
                                vendor_name: vendor,
                                transaction_type: transaction_type
                            },
                            success: function (response) {
                                console.log('Bank Details:', response); // handle your logic here
                            },
                            error: function () {
                                alert('Failed to fetch bank details');
                            }
                        });
                    }

                    function numberToWords(num) {
                        const ones = [
                            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                            'Seventeen', 'Eighteen', 'Nineteen'
                        ];

                        const tens = [
                            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
                            'Eighty', 'Ninety'
                        ];

                        // Scales for Indian numbering system (Thousand, Lakh, Crore)
                        const scales = ['', 'Thousand', 'Lakh', 'Crore'];

                        // Helper function to convert a two or three-digit number to words
                        function convertLessThanOneThousand(n) {
                            let words = '';
                            if (n >= 100) {
                                words += ones[Math.floor(n / 100)] + ' Hundred ';
                                n %= 100;
                            }
                            if (n < 20) {
                                words += ones[n];
                            } else {
                                words += tens[Math.floor(n / 10)];
                                if (n % 10 > 0) {
                                    words += ' ' + ones[n % 10];
                                }
                            }
                            return words.trim();
                        }

                        // Convert number to string and split into rupees and paise
                        // Use Math.round for better precision with floating-point numbers
                        const numStr = (Math.round(parseFloat(num) * 100) / 100).toFixed(2).toString();
                        const [rupeesStr, paiseStr] = numStr.split('.');
                        let rupees = parseInt(rupeesStr);
                        const paise = parseInt(paiseStr);

                        let result = '';

                        // Convert rupees part
                        if (rupees === 0) {
                            result = 'Zero Rupees';
                        } else {
                            let rupeesWords = [];
                            let scaleIndex = 0; // Represents the index for scales array

                            // Handle negative numbers (optional, but good practice)
                            if (rupees < 0) {
                                result += 'Minus ';
                                rupees = Math.abs(rupees);
                            }

                            // Process number in groups of 2 for Lakhs/Crores, and 3 for Thousands
                            // Indian numbering system: last three digits (hundreds, tens, ones), then groups of two
                            // e.g., 1,23,45,678 -> 1 Crore, 23 Lakh, 45 Thousand, 678

                            // Handle the first three digits (0-999)
                            if (rupees % 1000 !== 0) {
                                rupeesWords.unshift(convertLessThanOneThousand(rupees % 1000));
                            }
                            rupees = Math.floor(rupees / 1000);
                            scaleIndex++; // Now we are at 'Thousand' scale

                            while (rupees > 0) {
                                let chunk;
                                if (scaleIndex === 1) { // For Thousands, it's a group of 2 (tens and ones of thousands)
                                    chunk = rupees % 100;
                                    rupees = Math.floor(rupees / 100);
                                } else { // For Lakhs and Crores, it's a group of 2
                                    chunk = rupees % 100;
                                    rupees = Math.floor(rupees / 100);
                                }

                                if (chunk > 0) {
                                    let chunkWords = convertLessThanOneThousand(chunk);
                                    if (scales[scaleIndex]) { // Add scale only if it exists
                                        chunkWords += ' ' + scales[scaleIndex];
                                    }
                                    rupeesWords.unshift(chunkWords);
                                }
                                scaleIndex++;
                            }

                            result = rupeesWords.join(' ').trim() + ' Rupees';
                        }

                        // Convert paise part
                        if (paise > 0) {
                            let paiseWords = convertLessThanOneThousand(paise);
                            if (paiseWords) { // Only add if paiseWords is not empty
                                result += ' and ' + paiseWords + ' Paise';
                            }
                        } else if (paise === 0 && numStr.includes('.')) {
                            // If there's a decimal part but paise is 0, add "Zero Paise"
                            // This handles cases like 100.00 where we still want "Zero Paise"
                            result += ' and Zero Paise';
                        }

                        return result.trim();
                    }

                    // function numberToWords(num) {
                    //     const ones = [
                    //         '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                    //         'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                    //         'Seventeen', 'Eighteen', 'Nineteen'
                    //     ];

                    //     const tens = [
                    //         '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
                    //         'Eighty', 'Ninety'
                    //     ];

                    //     const scales = ['', 'Thousand', 'Lakh', 'Crore'];

                    //     function convertLessThanOneThousand(n) {
                    //         let words = '';
                    //         if (n >= 100) {
                    //             words += ones[Math.floor(n / 100)] + ' Hundred ';
                    //             n %= 100;
                    //         }
                    //         if (n < 20) {
                    //             words += ones[n];
                    //         } else {
                    //             words += tens[Math.floor(n / 10)];
                    //             if (n % 10 > 0) {
                    //                 words += ' ' + ones[n % 10];
                    //             }
                    //         }
                    //         return words.trim();
                    //     }

                    //     let rupees = Math.floor(Number(num)); // Only take integer part
                    //     let result = '';

                    //     if (rupees === 0) {
                    //         result = 'Zero Rupees';
                    //     } else {
                    //         let rupeesWords = [];
                    //         let scaleIndex = 0;

                    //         if (rupees < 0) {
                    //             result += 'Minus ';
                    //             rupees = Math.abs(rupees);
                    //         }

                    //         if (rupees % 1000 !== 0) {
                    //             rupeesWords.unshift(convertLessThanOneThousand(rupees % 1000));
                    //         }
                    //         rupees = Math.floor(rupees / 1000);
                    //         scaleIndex++;

                    //         while (rupees > 0) {
                    //             let chunk = rupees % 100;
                    //             rupees = Math.floor(rupees / 100);
                    //             if (chunk > 0) {
                    //                 let chunkWords = convertLessThanOneThousand(chunk);
                    //                 if (scales[scaleIndex]) {
                    //                     chunkWords += ' ' + scales[scaleIndex];
                    //                 }
                    //                 rupeesWords.unshift(chunkWords);
                    //             }
                    //             scaleIndex++;
                    //         }

                    //         result += rupeesWords.join(' ').trim() + ' Rupees';
                    //     }

                    //     return result.trim();
                    // }


                    document.getElementById('online_type').addEventListener('change', function () {
                        const selectedMethod = this.value;
                        const upiIdSection = document.getElementById('upi_id_section');
                        const upiMobileSection = document.getElementById('upi_mobile_section');
                        const upiTransactionSection = document.getElementById('upi_transaction_section_2');

                        // Hide both sections first
                        upiIdSection.style.display = 'none';
                        upiMobileSection.style.display = 'none';
                        upiTransactionSection.style.display = 'none';

                        // Show relevant sections based on selection
                        if (selectedMethod === '1' || selectedMethod === '2' || selectedMethod === '3') {
                            upiIdSection.style.display = 'block';
                            upiMobileSection.style.display = 'block';
                            upiTransactionSection.style.display = 'block';
                        }

                        // If you want to show only one field for specific methods:
                        /*
                        if (selectedMethod === '1') { // Google Pay
                            upiIdSection.style.display = 'block';
                        } else if (selectedMethod === '2') { // PhonePe
                            upiMobileSection.style.display = 'block';
                        } else if (selectedMethod === '3') { // Paytm
                            upiIdSection.style.display = 'block';
                            upiMobileSection.style.display = 'block';
                        }
                        */
                    });



                    function print_view_3(file_name) {

                        window.location = 'uploads/vendorpayment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
                    }
                    function print_pdf_3(file_name) {
                        // alert();

                        onmouseover = window.open('uploads/vendorpayment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
                    }
                      function print_view_4(file_name) {

                        window.location = 'uploads/vendorpayment/PO copy' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
                    }

                     function print_pdf_4(file_name) {
                        // alert();

                        onmouseover = window.open('uploads/vendorpayment/PO copy/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
                    }
                </script>
