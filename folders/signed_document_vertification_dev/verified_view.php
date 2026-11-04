<!-- This file Only PHP Functions -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    #myImg1 {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg1:hover {
        opacity: 0.7;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>
<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';
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
        $invoice_no = $_GET["invoice_no"];
        $ins_unique_id = $_GET["ins_unique_id"];
        $dc_number = $_GET["dc_number"];

        // $where      = [
        //     "ins_unique_id" => $unique_id,
        //     "invoice_no" => $invoice_no,
        // ];
        $where = "consignee_unique_id= '$unique_id' and  invoice_no= '$invoice_no'  AND ins_unique_id='" . $ins_unique_id . "' and dc_number = '" . $dc_number . "'";
        // print_r($where);die();
        $table = "view_sign_document_vertification";
        $columns = [
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_no",
            "invoice_date",
            "DATE_FORMAT(invoice_date,'%d-%m-%Y')as form_invoice_date",
            "(select delivery_date from dispatch_list where dispatch_list.invoice_no = $table.invoice_no and dispatch_list.dc_number = $table.dc_number) as delivery_date",
            "dc_status",
            "dc_file",
            "ir_status",
            "ir_file",
            "snr_status",
            "snr_file",
            "document_verification_status",
            "form_main_unique_id",
            "consignee_unique_id",
            "bank_required",
            "ins_reqired",
            "po_file",
            "ins_unique_id",
            "dc_required",
            "dc_number",
            "dc_date"
        ];
        $table_details = [
            $table,
            $columns
        ];
        // $document_verification_status = asort($document_verification_status);
        $result_values = $pdo->select($table_details, $where);
        // print_r($result_values);die();
        if ($result_values->status) {
            $result_values = $result_values->data;
            $po_num = $result_values[0]["po_num"];
            $ins_unique_id = $result_values[0]["ins_unique_id"];
            $con_contact_name = $result_values[0]["con_contact_name"];
            $con_address = $result_values[0]["con_address"];
            $invoice_no = $result_values[0]["invoice_no"];
            $delivery_date = $result_values[0]['delivery_date'];

            $con_contact_name = $result_values[0]["con_contact_name"];
            $con_address = $result_values[0]["con_address"];
            $invoice_no = $result_values[0]["invoice_no"];

            $invoice_date = $result_values[0]["invoice_date"];

            $formatetd_invoice_date = $result_values[0]["form_invoice_date"];

            $document_verification_status = $result_values[0]["document_verification_status"];
            $orgDate = $result_values[0]["po_date"];
            $dc_required = $result_values[0]["dc_required"];
            $dc_number = $result_values[0]["dc_number"];
            $dc_date = disdate($result_values[0]["dc_date"]);

            $po_date = date("d-m-Y", strtotime($orgDate));
            if ($result_values[0]['invoice_date'] == "") {
                $invoice_date = '';
            } else {
                $orgDate1 = $result_values[0]["invoice_date"];
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }


            $consignee_unique_id = $result_values[0]["consignee_unique_id"];
            $form_main_unique_id = $result_values[0]["form_main_unique_id"];
            $bank_required = $result_values[0]["bank_required"];
            $ins_reqired = $result_values[0]["ins_reqired"];
            $dc_status1 = $result_values[0]["dc_status"];
            $ir_status1 = $result_values[0]["ir_status"];

            $snr_status1 = $result_values[0]["snr_status"];
            $po_file_name = $result_values[0]['po_file'];
            // echo $po_file_name;
            $dc_file_name = $result_values[0]['dc_file'];
            $ir_file_name = $result_values[0]['ir_file'];
            $snr_file_name = $result_values[0]['snr_file'];

            $dc_file = image_view("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['dc_file']);
            // print_r($dc_file);
            $ir_file = image_view_1("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['ir_file']);
            // $po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);
            $po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);





            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
            $stmtCus->bindParam(':unique_id', $form_main_unique_id);
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
                $customrePincode = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor();
            $consignee_unique_id = $result_values[0]["consignee_unique_id"];


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












            // $result_values[0]["dc_file"]=image_view()
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
$po_product_options = po_product($unique_id, $form_main_unique_id);
$po_product_options = select_option($po_product_options, "Select Product", $po_product_name);
?>


<?php

$where = "con_unique_id = '$unique_id' and  invoice_no= '$invoice_no' AND ins_unique_id='$ins_unique_id' and dc_number = '$dc_number'";
$table_sign = "sign_doc_verification_detail";
$columns = [
    "po_num",
    "po_date",
    "con_contact_name",
    "con_address",
    "con_unique_id",
    "invoice_no",
    "invoice_date",
    "dc_received_status",
    "DATE_FORMAT(dc_signed_date,'%d-%m-%Y')as dc_signed_date",
    "ir_status",
    "ir_signed_date",
    "snr_signed_date",
    "snr_status",
    "po_product_name",
    "approval",
    "doc_chn",
    "claim_amount",
    "status_app",
    "installation_reference_no",
    "supplier_invoice_number",
    "unique_id",
    "scanned_dc_copy",
    "scanned_ir_copy",
    "invoice_copy",
    "unique_id",
    "form_main_unique_id",
    "with_bg",
    "without_bg",
    "ins_unique_id",
    "reject_reason",
    "inv_verify_approvedby",
    "DATE_FORMAT(inv_verify_approved_date,'%d-%m-%Y')as inv_verify_approved_date",
    "inv_verify_status"

];
$table_details = [
    $table_sign,
    $columns
];
$result_values_data = $pdo->select($table_details, $where);
// print_r($result_values_data);
if ($result_values_data->status) {
    $result_values_data = $result_values_data->data;
    $po_num = $result_values_data[0]["po_num"];
    $po_date = $result_values_data[0]["po_date"];
    $con_contact_name = $result_values_data[0]["con_contact_name"];
    $con_address = $result_values_data[0]["con_address"];
    $con_unique_id = $result_values_data[0]["con_unique_id"];
    $invoice_no = $result_values_data[0]["invoice_no"];
    $invoice_date = $result_values_data[0]["invoice_date"];
    $dc_received_status = $result_values_data[0]["dc_received_status"];
    $dc_signed_date = $result_values_data[0]["dc_signed_date"];
    $ir_status = $result_values_data[0]["ir_status"];
    $ir_signed_date = $result_values_data[0]["ir_signed_date"];
    $po_product_name = $result_values_data[0]["po_product_name"];
    $approval = $result_values_data[0]["approval"];
    $claim_amount = $result_values_data[0]["claim_amount"];
    $status = $result_values_data[0]["status_app"];
    $doc_chn = $result_values_data[0]["doc_chn"];

    $with_bg = $result_values_data[0]["with_bg"];
    $without_bg = $result_values_data[0]["without_bg"];
    $ins_unique_id_data = $result_values_data[0]["ins_unique_id"];
    $reject_reason = $result_values_data[0]["reject_reason"];
    $form_main_unique_id_1 = $result_values_data[0]["form_main_unique_id"];
    $update_unique_id = $result_values_data[0]["unique_id"];
    $snr_status = $result_values_data[0]["snr_status"];

    $snr_signed_date = $result_values_data[0]["snr_signed_date"];


    $inv_verify_status = $result_values_data[0]["inv_verify_status"];

    if ($inv_verify_status === 1) {

        $inv_verify_status = 'Verified';
    }

    $inv_verify_approvedby = $result_values_data[0]["inv_verify_approvedby"];

    $inv_verify_approved_date = $result_values_data[0]["inv_verify_approved_date"];

    if ($ins_unique_id_data == '') {
        $ins_unique_id_data = "";

    } else {
        $ins_unique_id_data = $result_values_data[0]["ins_unique_id"];
    }

    $btn_text = "Update";
    $btn_action = "update";
} else {
    $btn_text = "Error";
    $btn_action = "error";
    $is_btn_disable = "disabled='disabled'";
}

$dc_received_status_option = [
    [
        "id" => '1',
        "value" => "Received"
    ],
    [
        "id" => '2',
        "value" => "Pending"
    ],
];

if ($dc_received_status == 1) {
    $dc_received_status_options = "Received";
} elseif ($dc_received_status == 2) {
    $dc_received_status_options = "Pending";
}
$ir_status_options = [
    [
        "id" => '1',
        "value" => "Received"
    ],
    [
        "id" => '2',
        "value" => "Pending"
    ],
];
if ($ir_status == 1) {
    $ir_status_options = 'Recieved';
} elseif ($ir_status == 2) {
    $ir_status_options = 'Pending';
}

$snr_status_options = [
    [
        "id" => '1',
        "value" => "Received"
    ],
    [
        "id" => '2',
        "value" => "Pending"
    ],


];

$snr_status_options = select_option($snr_status_options, "Select", $snr_status);

$claim_amount_options = [
    [
        "id" => '5',
        "value" => "5%"
    ],
    [
        "id" => '25',
        "value" => "25%"
    ],
    [
        "id" => '75',
        "value" => "75%"
    ],
    [
        "id" => '95',
        "value" => "95%"
    ],
    [
        "id" => '100',
        "value" => "100%"
    ],
];
$claim_amount_options = select_option($claim_amount_options, "Select", $claim_amount);
$status_options = [

    [
        "id" => '1',
        "value" => "Mismatch"
    ],
    [
        "id" => '2',
        "value" => "Verified"
    ],
];

if ($status == 1) {
    $status_options = "Mismatch";
} elseif ($status == 2) {
    $status_options = "Verified";
}
?>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Signed Document Verification</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active">Signed Document Verification</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row cf">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="row">


                                    <div class="row">
                                        <!-- Customer Details -->
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-body-primary"
                                                style="font-size: large; color: #878a99;">Customer Details
                                            </h6>
                                            <h6 style="font-size: x-large; color: #506018;">
                                                <strong><?php echo $department ?></strong>
                                            </h6>
                                            <p class="mb-1"><?php echo ucwords($customerAddress) ?>,<br>
                                                <?php echo ($customerDistrict) ?><br><?php echo ($customerState) ?>
                                            </p>
                                            <p class="mb-1">
                                                <i data-feather="phone"
                                                    style="width:15px; height:15px; color:#506018"></i>
                                                <?php echo !empty($customerContact) ? $customerContact : '--'; ?>
                                            </p>
                                            <p>
                                                <i data-feather="mail"
                                                    style="width:15px; height:15px; color:#506018"></i>
                                                <?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-body-primary"
                                                style="font-size: large; color: #878a99;">Consignee Details
                                            </h6>

                                            <!-- Capitalize first letter of each word in contact name -->
                                            <h6 style="font-size: x-large; color: #506018;">
                                                <strong><?php echo ucwords($consigneeName); ?></strong>
                                            </h6>

                                            <!-- Capitalize address and district -->
                                            <p class="mb-1">
                                                <?php echo ucwords($consigneeAddress); ?>,
                                                <br><?php echo ucwords($consigneeDistrict); ?><br>
                                                <?php echo $consigneeState; ?>
                                            </p>

                                            <!-- Contact number with fallback -->
                                            <p class="mb-1">
                                                <i data-feather="phone"
                                                    style="width:15px; height:15px; color:#506018"></i>
                                                <?php echo !empty($consigneeContact) ? $consigneeContact : '--'; ?>
                                            </p>
                                        </div>

                                        <!-- Consignee / Invoice Details -->
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase text-body-primary"
                                                style="font-size: large; color: #878a99;">PO & Invoice
                                                Details</h6>
                                            <div class="row mb-1">
                                                <div class="col-4 text-body-secondary">PO Number</div>
                                                <div class="col-1">:</div>
                                                <div class="col-6"><?php echo $po_num ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-4 text-body-secondary">PO Date</div>
                                                <div class="col-1">:</div>
                                                <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-4 text-body-secondary">Invoice No</div>
                                                <div class="col-1">:</div>
                                                <div class="col-6 "><?php echo $invoice_no; ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-4 text-body-secondary">Invoice Date</div>
                                                <div class="col-1">:</div>
                                                <div class="col-6 "><?php echo $formatetd_invoice_date; ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-4 text-body-secondary">DC Number</div>
                                                <div class="col-1">:</div>
                                                <div class="col-6 "><?php echo $dc_number ?></div>
                                            </div>
                                            <?php
                                            if ($dc_required == 'on') { ?>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">DC Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $dc_date ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">Delivery Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 ">
                                                        <?php echo date('d/m/Y', strtotime($delivery_date)) ?>
                                                    </div>
                                                </div>
                                            <?php } else if ($ir_status1 == '0') { ?>
                                                    <div class="row">
                                                        <div class="col-4 text-body-secondary">DC Received status</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-6 "><?php echo $dc_received_status_options ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 text-body-secondary">DC Signed Date</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-6 "><?php echo $dc_signed_date ?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4 text-body-secondary">SNR Status</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-6 "><?php echo $snr_status_options ?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4 text-body-secondary">SNR Signed Date</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-6 "><?php echo $snr_signed_date ?></div>
                                                    </div>


                                            <?php }


                                            if ($ir_status1 == 'IR') { ?>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">DC Received status</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $dc_received_status_options ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">DC Signed Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $dc_signed_date ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">IR Received Status</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $ir_status_options ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">IR Signed Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $ir_status_options ?></div>
                                                </div>
                                            <?php }
                                            if ($ir_status1 == '0') { ?>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">IR Received Status</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $snr_pod_no ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">IR Signed Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo $ir_signed_date ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4 text-body-secondary">Doc Chennai Date</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-6 "><?php echo disdate($doc_chn); ?></div>
                                                </div>

                                                <input type="hidden" id="snr_status" name="snr_status" class="form-control"
                                                    required>

                                                <input type="hidden" id="snr_signed_date" name="snr_signed_date"
                                                    class="form-control" value="<?php if ($snr_signed_date != '') {
                                                        echo $snr_signed_date;
                                                    } else {
                                                        echo '';
                                                    } ?>" required>


                                            <?php } ?>

                                        </div>
                                    </div>

                                    <input type="hidden" id="sts" name="sts" class="form-control" value="<?php if ($dc_status1 != '') {
                                        echo $dc_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>
                                    <input type="hidden" id="sts1" name="sts1" class="form-control" value="<?php if ($ir_status1 != '') {
                                        echo $ir_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>

                                    <input type="hidden" id="sts2" name="sts2" class="form-control" value="<?php if ($snr_status1 != '') {
                                        echo $snr_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>
                                    <input type="hidden" id="sts" name="sts" class="form-control" value="<?php if ($dc_status1 != '') {
                                        echo $dc_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>
                                    <input type="hidden" id="sts1" name="sts1" class="form-control" value="<?php if ($ir_status1 != '') {
                                        echo $ir_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>

                                    <input type="hidden" id="sts2" name="sts2" class="form-control" value="<?php if ($snr_status1 != '') {
                                        echo $snr_status1;
                                    } else {
                                        echo '';
                                    } ?>" required>


                                    <div class="row mt-5">
                                        <!-- <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Attachment</h4>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-3"
                                                            style="text-align: center;border-right: 1px solid #ccc;">
                                                            <?php if ($bank_required == 'on') { ?>
                                                                <p>Primary Product For BG</p>
                                                                <input type="text" id="po_product_name"
                                                                    name="po_product_name" class="form-control"
                                                                    value="<?php echo $po_product_name; ?>" required
                                                                    readonly>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-3"
                                                            style="text-align: center;border-right: 1px solid #ccc;">
                                                            <p>PO <br>Attachment</p>
                                                            <?php echo $po_file ?>
                                                        </div>
                                                        <div class="col-3"
                                                            style="text-align: center;border-right: 1px solid #ccc;">

                                                            <p>DC Signed Document</p>
                                                            <?php echo $dc_file; ?>
                                                        </div>
                                                        <div class="col-3" style="text-align: center">
                                                            <?php if ($dc_required != 'on') {
                                                                if ($ir_file_name != '') { ?>

                                                                    <p>Installation Signed Report</p>
                                                                    <div class="col-md-1"></div>
                                                                    <?php echo $ir_file ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                                }
                                                            } ?>
                                                            
                                                <div class="col-md-6">

                                                    <h4>Comparision</h4>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-4"
                                                            style="text-align: center;border-right: 1px solid #ccc;">

                                                            <p> PO DC<br> Comparision </p>


                                                            <img src="uploads/compare-icon.png" height="30px"
                                                                width="30px" data-bs-toggle="modal"
                                                                data-bs-target=".bs-example-modal-xl" type="button">


                                                        </div>

                                                        <?php if ($ir_status1 == '0' && $dc_required != 'on') { ?>
                                                            <div class="col-4"
                                                                style="text-align: center;border-right: 1px solid #ccc;">
                                                                <p>PO SNR <br>Comparision </p>

                                                                <img src="uploads/compare-icon.png" height="30px"
                                                                    width="30px" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-x2" type="button">


                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($ir_status1 == 'IR') { ?>
                                                            <div class="col-4" style="text-align: center;">
                                                                <p>PO IR<br> Comparision </p>


                                                                <img src="uploads/compare-icon.png" height="30px"
                                                                    width="30px" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-x2" type="button">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="col-12">
                                            <div class="row">
                                                <!-- Attachments Section -->
                                                <div class="col-md-6">
                                                    <h4>Attachment</h4>
                                                    <hr>
                                                    <div class="row text-center">
                                                        <?php if ($bank_required == 'on') { ?>
                                                            <div class="col-4 border-end">
                                                                <p>Primary Product For BG</p>
                                                                <input type="text" id="po_product_name"
                                                                    name="po_product_name" class="form-control text-center"
                                                                    value="<?php echo $po_product_name; ?>" readonly>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="col-4 border-end">
                                                            <p>PO Attachment</p>
                                                            <?php echo $po_file ?>
                                                        </div>

                                                        <div class="col-4 border-end">
                                                            <p>DC Signed Document</p>
                                                            <?php echo $dc_file; ?>
                                                        </div>

                                                        <?php if ($dc_required != 'on' && $ir_file_name != '') { ?>
                                                            <div class="col-4">
                                                                <p>Installation Signed Report</p>
                                                                <?php echo $ir_file ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <!-- Comparison Section -->
                                                <div class="col-md-6">
                                                    <h4>Comparison</h4>
                                                    <hr>
                                                    <div class="row text-center">
                                                        <!-- PO DC Comparison -->
                                                        <div class="col-4 border-end">
                                                            <p>PO DC Comparison</p>
                                                            <img src="uploads/compare-icon.png" height="30px"
                                                                width="30px" data-bs-toggle="modal"
                                                                data-bs-target=".bs-example-modal-xl" type="button">
                                                        </div>

                                                        <!-- PO SNR Comparison -->
                                                        <?php if ($ir_status1 == '0' && $dc_required != 'on') { ?>
                                                            <div class="col-4 border-end">
                                                                <p>PO SNR Comparison</p>
                                                                <img src="uploads/compare-icon.png" height="30px"
                                                                    width="30px" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-x2" type="button">
                                                            </div>
                                                        <?php } ?>

                                                        <!-- PO IR Comparison -->
                                                        <?php if ($ir_status1 == 'IR') { ?>
                                                            <div class="col-4">
                                                                <p>PO IR Comparison</p>
                                                                <img src="uploads/compare-icon.png" height="30px"
                                                                    width="30px" data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-x2" type="button">
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="row mt-4">

                            <h4>Verification</h4>

                            <div class="col-md-4">

                                <div class="row mb-1">
                                    <div class="col-4 text-body-secondary">Verified By</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6"><?php echo $inv_verify_approvedby; ?></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-4 text-body-secondary">Verified Status</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><span style="color:green"><?php echo $inv_verify_status; ?></span></div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-4 text-body-secondary">Verified Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $inv_verify_approved_date; ?></div>
                                </div>

                            </div>

                            <?php if ($bank_required == 'yes') { ?>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <div class="form-group form-check  mt-3">
                                            <?php
                                            if ($with_bg == 'on') { ?>
                                                <input type="checkbox" class="form-check-input" id="with_bg" name="with_bg"
                                                    checked>
                                            <?php } else { ?>
                                                <input type="checkbox" class="form-check-input" id="with_bg" name="with_bg">
                                            <?php }
                                            ?>
                                            <label class="form-check-label">
                                                Processed With BG
                                            </label>
                                        </div>
                                        <div class="form-group form-check  mt-2">
                                            <?php if ($without_bg == 'on') { ?>
                                                <input type="checkbox" class="form-check-input bgcheckbox" id="without_bg"
                                                    name="without_bg" checked>
                                            <?php } else { ?>
                                                <input type="checkbox" class="form-check-input bgcheckbox" id="without_bg"
                                                    name="without_bg">
                                            <?php } ?>
                                            <label class="form-check-label"> Processed Without BG</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Claim Amount</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="claim_amount" id="claim_amount">
                                            <?php echo $claim_amount_options ?>
                                        </select>
                                    </div>
                                </div> -->
                            <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Approval</label>
                                        <select name="approval" id="approval" class="select2 form-control" required>
                                            <?php echo $approval_options ?>
                                        </select>
                                    </div>
                                </div> -->

                            <?php if ($reject_reason != "") { ?>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Reject Reason</label>
                                        <textarea id="reject_reason" name="reject_reason" class="form-control"
                                            readonly></textarea>
                                        <!-- <input type="text" id="reject_reason" name="reject_reason" class="form-control" value="<?php echo $reject_reason; ?>" > -->
                                    </div>
                                </div>
                            <?php } ?>


                            <input type="hidden" id="po_num" name="po_num"
                                value="<?php echo $result_values[0]["po_num"] ?>">
                            <input type="hidden" id="po_date" name="po_date"
                                value="<?php echo $result_values[0]["po_date"] ?>">
                            <input type="hidden" id="con_contact_name" name="con_contact_name"
                                value="<?php echo $result_values[0]['con_contact_name'] ?>">
                            <input type="hidden" id="con_address" name="con_address"
                                value="<?php echo $result_values[0]["con_address"] ?>">
                            <input type="hidden" id="invoice_no" name="invoice_no"
                                value="<?php echo $result_values[0]["invoice_no"] ?>">
                            <input type="hidden" id="invoice_date" name="invoice_date"
                                value="<?php echo $result_values[0]["invoice_date"] ?>">
                            <input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
                                value="<?php echo $result_values[0]["form_main_unique_id"] ?>">
                            <input type="hidden" id="con_unique_id" name="con_unique_id"
                                value="<?php echo $result_values[0]["consignee_unique_id"] ?>">
                            <input type="hidden" id="update_unique_id" name="update_unique_id"
                                value=" <?php echo $result_values_data[0]["unique_id"] ?>">
                            <input type="hidden" id="po_product_name" name="po_product_name"
                                value=" <?php echo $result_values[0]["po_product_name"] ?>">
                            <input type="hidden" id="bank_required" name="bank_required"
                                value="<?php echo $result_values[0]["bank_required"] ?>">
                            <input type="hidden" id="con_unique_id" name="con_unique_id"
                                value="<?php echo $result_values[0]["bank_required"] ?>">
                            <input type="hidden" id="ins_unique_id" name="ins_unique_id"
                                value="<?php echo $result_values[0]["ins_unique_id"] ?>">
                            <input type="hidden" id="snr_file" name="snr_file" value="<?php echo $snr_file_name; ?>">
                            <input type="hidden" id="ir_file" name="ir_file" value="<?php echo $ir_file_name; ?>">

                            <input type="hidden" id="dc_required" name="dc_required"
                                value="<?php echo $dc_required; ?>">

                            <!-- modal start for po dc comparision -->
                            <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO
                                                & DC Comparison Attachment </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <h4 class="text-center">PO Attachment</h4>
                                                    <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                        type="application/pdf" width="100%" height="400">
                                                        <iframe
                                                            src="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                            width="100%" height="400">
                                                        </iframe>
                                                    </object>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 class="text-center">DC Attachment</h4>
                                                    <object data="uploads/installation/<?php echo $dc_file_name ?>"
                                                        type="application/pdf" width="100%" height="400">
                                                        <iframe src="uploads/installation/<?php echo $dc_file_name ?>"
                                                            width="100%" height="400">
                                                        </iframe>
                                                    </object>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- modal end -->
                            <!-- modal start for po IR comparision -->
                            <div class="modal fade bs-example-modal-x2" tabindex="-1" role="dialog"
                                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO
                                                & IR Comparison Attachment </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if ($ir_status1 == '0') { ?>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">PO Attachment</h4>
                                                        <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                            type="application/pdf" width="100%" height="400">
                                                            <iframe
                                                                src="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                                width="100%" height="400">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">SNR Attachment</h4>
                                                        <object data="uploads/installation/<?php echo $snr_file_name; ?>"
                                                            type="application/pdf" width="100%" height="400">
                                                            <iframe src="uploads/installation/<?php echo $snr_file_name; ?>"
                                                                width="100%" height="400">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($ir_status1 == 'IR') { ?>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">PO Attachment</h4>
                                                        <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                            type="application/pdf" width="100%" height="400">
                                                            <iframe
                                                                src="uploads/po_form/po_attach/<?php echo $po_file_name ?>"
                                                                width="100%" height="400">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">IR Attachment</h4>
                                                        <object data="uploads/installation/<?php echo $ir_file_name; ?>"
                                                            type="application/pdf" width="100%" height="400">
                                                            <iframe src="uploads/installation/<?php echo $ir_file_name; ?>"
                                                                width="100%" height="400">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="modal-footer">
                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- modal end -->
                            <!-- <div class="col-xl-6"> -->
                            <div class="mb-3">
                                <div class="col-md-12" align="right">
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <!--<?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>-->
                                    <!-- <?php if ($result_values_data[0]["unique_id"] != '') { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="signed_document_vertification_cu()">Update</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="signed_document_vertification_cu()">Save</button>
                                        <?php } ?> -->
                                </div>
                            </div>
                            <!-- </div>end col -->
                        </div>
                    </div>
            </div>
            </form>
        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div><!-- end col -->
</div>

<script>
    var modal = document.getElementById("myModal");
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
        modal.style.display = "none";
    }
</script>
<script>
    var modal = document.getElementById("myModal1");
    var img = document.getElementById("myImg1");
    var modalImg = document.getElementById("img02");
    var captionText = document.getElementById("caption");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
    var span = document.getElementsByClassName("close")[1];
    span.onclick = function () {
        modal.style.display = "none";
    }

    function print_pdf(file_name) {
        onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    function print_excel(file_name) {
        // alert('hi');
        window.location = 'uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }
    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view(file_name) {
        onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    function print_1(file_name) {
        window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }

    function print_pdf_1(file_name) {
        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view_1(file_name) {
        window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
<?php
function image_view($folder_name = "", $unique_id = "", $dc_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file);
    $image_view = '';
    if ($dc_file) {
        foreach ($file_names as $file_key => $dc_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $dc_file);
            if ($dc_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_excel(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    // print_r($image_view);
    return $image_view;
}
function image_view_1($folder_name = "", $unique_id = "", $ir_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file);
    $image_view_1 = '';
    if ($ir_file) {
        foreach ($file_names as $file_key => $ir_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_1 .= "&nbsp";
                } else {
                    $image_view_1 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $ir_file);
            if ($ir_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_1 .= '<a href="javascript:print_view(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="30px" width="30px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_1 .= '<a href="javascript:print_pdf(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_1 .= '<a href="javascript:print_excel(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_1 .= '<a href="javascript:print(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    return $image_view_1;
}
function image_view_3($folder_name = "", $unique_id = "", $po_file = "")
{
    // echo $file_name;
    $file_names = explode(',', $po_file);
    $image_view_3 = '';
    if ($po_file) {
        foreach ($file_names as $file_key => $po_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $po_file);
            if ($po_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $po_file . '\')"><img src="uploads/' . $folder_name . '/' . $po_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="30px" width="30px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    return $image_view_3;
}
?>
<script>
    $(document).ready(function () {
        // alert();
        // var documents_type = document.querySelector('.snr_status');
        // var documents_type1 = document.querySelector('.check_box1').checked;
        // var documents_type2 = document.querySelector('.check_box2').checked;
        var dc_required = document.getElementById('dc_required').value;
        var snr_file = document.getElementById('snr_file').value;
        var ir_file = document.getElementById('ir_file').value;
        //  alert(ir_file);
        //  alert(snr_file);
        //  alert(dc_required);

        // alert(snr_signed_date);
        if (snr_file == '' || snr_file == 'null') {
            $('#dc_status').show();
            $('#dc_date').show();
            $('#dc_rec_snr').hide();
            $('#dc_date_snr').hide();

            // $('#dc_option2').show();
        }
        else if ((snr_file != '')) {
            $('#dc_status').hide();
            $('#dc_date').hide();
            $('#dc_rec_snr').show();
            $('#dc_date_snr').show();
        }
        if ((dc_required == 'on')) {
            $('#dc_status').hide();
            $('#dc_date').hide();
            $('#dc_rec_snr').show();
            $('#dc_date_snr').show();
        }

        // if (documents_type1) {

    });
</script>
