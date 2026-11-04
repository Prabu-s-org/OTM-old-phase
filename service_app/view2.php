<?php
include 'header.php';
include '../config/dbconfig.php';

$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$is_active = 1;

$consignee_unique_id = isset($_GET['consignee_unique_id']) ? $_GET['consignee_unique_id'] : '';
$invoice_no = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
$dc_number = isset($_GET['dc_number']) ? $_GET['dc_number'] : '';


if (!empty($invoice_no)) {  // Ensure invoice_no is not empty

    $where = [
        "invoice_no" => $invoice_no,
        "dc_number" => $dc_number
    ];
    $table = "view_installation_followups";

    $columns = [

        "po_unique_id",
        "po_num",
        "po_date",
        "con_contact_name",
        "con_address",
        "invoice_auto_id",
        "invoice_no",
        "(SELECT department FROM department_creation WHERE department_creation.unique_id = " . $table . ".department group by department_creation.unique_id) AS con_district",

        "invoice_date",

        "(SELECT dc_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id AND is_delete=0 group by form_main_unique_id) AS dc_file",

        "(SELECT ir_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id  AND is_delete=0 group by form_main_unique_id) AS ir_file",
        "(SELECT snr_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id  AND is_delete=0 group by form_main_unique_id) AS snr_file",
        "(SELECT installation_date FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id AND is_delete=0 group by form_main_unique_id ) AS installation_date",

        "form_main_unique_id",
        "consignee_unique_id",
        "dc_required",
        "document_required",

    ];

    $table_details = [$table, $columns];

    $result_values = $pdo->select($table_details, $where);

    if ($result_values && $result_values->status && !empty($result_values->data)) {
        // Corrected accessing the data
        $result_values = $result_values->data;
        $po_num = $result_values[0]["po_num"];
        $con_contact_name = $result_values[0]["con_contact_name"];
        $con_address = $result_values[0]["con_address"];
        $invoice_no = $result_values[0]["invoice_no"];
        $dc_required = $result_values[0]["dc_required"];
        $consignee_unique_id = $result_values[0]["consignee_unique_id"];
        $orgDate = $result_values[0]["po_date"];
        $po_date = date("d-m-Y", strtotime($orgDate));

        $document_required = $result_values[0]["document_required"];
        $dc_file_name = $result_values[0]['dc_file'];

        $ir_file_name = $result_values[0]['ir_file'];

        $snr_file_name = $result_values[0]['snr_file'];

        if ($result_values[0]["invoice_date"] == '') {
            $invoice_date = '';
        } else {
            $orgDate1 = $result_values[0]["invoice_date"];
            $invoice_date = date("d-m-Y", strtotime($orgDate1));
        }

        $btn_text = "Update";
        $btn_action = "update";
    } else {
        $btn_text = "Error";
        $btn_action = "error";
        $is_btn_disable = "disabled='disabled'";
    }
}

?>

<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }



    /* checkbox design start */
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 9px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 16px;
        width: 16px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .log-out h4 {
        color: #fff;
    }

    .breadcrumb i {
        padding: 0px;
        padding-right: 10px;
        font-size: 14px;
    }

    .breadcrumb {
        font-size: 14px;
    }

    .breadcrumb-item a,
    .breadcrumb-item.active,
    .breadcrumb-item+.breadcrumb-item::before {
        color: #fff;
        text-decoration: none;
    }

    .sub-hed {
        height: 100%
    }

    .card {
        border-radius: 10px;
    }

    .text_style {
        color: #000 !important;
        font-size: 17px;
    }

    .body_style {
        background-color: #efefef;
    }

    .form-label {
        color: #4a4a4a;
    }

    .border_style .row {}
    
</style>
<div class="body_style ">
    <div class="sub-hed ">
        <div class="row">
            <div class="col-12 log-out" >
                <h4 class="mb-sm-0" align="center"> Installation </h4>
                <div class="page-title-right mb-2 mt-3">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="bi bi-arrow-left" id="backButton" style="cursor: pointer;"></i>
                        </li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active"> Installation </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
    <div class="card cf m-3">
        <div class="card-body">
            <h3 class="mb-4 text_style">Installation - DC & IR Document Dispatch Details</h3>
            <div class="col-12 border_style">
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">PO Number</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $po_num; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">PO Date</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $po_date; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">DC Number</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $dc_number; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">Consignee Name</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $con_contact_name; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">Location</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $con_address; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">Invoice No</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $invoice_no; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Invoice
                            Date</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $invoice_date; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 head_po">
                        <label class="form-label">DC Attachment</label>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-6">
                        <?php if (!empty($dc_file_name)): ?>

                            <a href="javascript:print_pdf_dc('<?php echo '/' . $dc_file_name; ?>')">
                                <img src="uploads/installation/pdf.png" height="30" width="20" alt="PDF">

                            </a>
                        <?php else: ?>
                            <span class=" view_detail">No Attachment</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5 head_po">
                        <label class="form-label">IR Attachment</label>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-6">
                        <?php if (!empty($ir_file_name)): ?>

                            <a href="javascript:print_pdf_dc('<?php echo '/' . $ir_file_name; ?>')">
                                <img src="uploads/installation/pdf.png" height="30" width="20" alt="PDF">

                            </a>
                        <?php else: ?>
                            <span>No Attachment</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5 head_po">
                        <label class="form-label">SNR Attachment</label>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-6">
                        <?php if (!empty($file_invoice)): ?>

                            <a href="javascript:print_pdf_dc('<?php echo '/' . $file_invoice; ?>')">
                                <img src="uploads/installation/pdf.png" height="30" width="30" alt="PDF">

                            </a>

                        <?php else: ?>
                            <span>No Attachment</span>
                        <?php endif; ?>
                    </div>
                </div>
<div class="col-12 mt-2">
										<div class="table-responsive mb-4">
										<table class="table table-striped table-bordered align-middle mb-0 small_table">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
            <th scope="col">Item Code</th>
            <th scope="col">Item Details</th>
            <th scope="col">Item QTY</th>
            <th scope="col">Stock QTY</th>
            <th scope="col">Delivery Date</th>
            <th scope="col">Installation Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $search  = $_POST['search']['value'];    
        $length  = $_POST['length'];
        $start   = $_POST['start'];
        $draw    = $_POST['draw'];
        $limit   = $length;

        if ($length == '-1') {
            $limit = "";
        }

        $where1 = "form_main_unique_id = '".$result_values[0]["form_main_unique_id"]."' AND is_delete=0";
        $where2 = "unique_id = '".$result_values[0]["form_main_unique_id"]."' AND is_delete=0";
        $groupBy = "item_code, stock_date";
        $limit = null;
        $start = null;
        $order_by = null;

        // Stock query
        $table1 = "stock_position_sublist";
        $columns1 = [
            "item_code",
            "product",
            "item_qty",
            "SUM(stock_qty) AS stock_qty",
            "stock_date",
            "unique_id",
            "form_main_unique_id"
        ];
        $table_details1 = [$table1, $columns1];

        // Delivery date query
        $table2 = "po_form";
        $columns2 = [
            "DATE_FORMAT(ld_delivery_due_date,'%d-%m-%Y')as ld_delivery_due_date",
        "DATE_FORMAT(ld_installation_due_date,'%d-%m-%Y')as ld_installation_due_date"
    ];
        $table_details2 = [$table2, $columns2];

        $values_product = $pdo->select($table_details1, $where1, "", "", "", "", $groupBy);
        $values_date    = $pdo->select($table_details2, $where2);
        // Extract the delivery date safely
        $delivery_date = "";
        if (!empty($values_date->data) && isset($values_date->data[0]['ld_delivery_due_date'])) {
            $delivery_date = $values_date->data[0]['ld_delivery_due_date'];
            $installation_date = $values_date->data[0]['ld_installation_due_date'];
        }

        $j = 1;
        if ($values_product->status) {
            $product_array = $values_product->data;

            foreach ($product_array as $key => $product) {
                ?>
                <tr>
                    <td><?php echo $j; ?></td>
                    <td><?php echo $product['item_code']; ?></td>
                    <td><?php echo $product['product']; ?></td>
                    <td><?php echo $product['item_qty']; ?></td>
                    <td><?php echo $product['stock_qty']; ?></td>
                    <td><?php echo $delivery_date; ?></td>
                    <td><?php echo $installation_date; ?></td>
                </tr>
                <?php
                $j++;
            }
        }
        ?>
    </tbody>
</table>

										</div>
									</div>
               
                    <?php

                    $where = "consignee_unique_id='" . $consignee_unique_id . "' and invoice_no='" . $invoice_no . "' AND dc_number='" . $dc_number . "' AND   is_delete=0";

                    $table_sub_dc = "dc_ir_doc_dispatch_details";
                    $columns = [
                        "po_form_unique_id",
                        "dc_dispatch_mode",
                        "dc_pod_no",
                        "DATE_FORMAT(dc_pod_date, '%d-%m-%Y') AS  dc_pod_date",
                        "ir_dispatch_mode",
                        "ir_pod_no",
                        "DATE_FORMAT(ir_pod_date, '%d-%m-%Y') AS  ir_pod_date",
                        "name_of_courier",
                        "ins_name_of_courier",
                        "snr_dispatch_mode",
                        "snr_pod_no",
                        "DATE_FORMAT(snr_pod_date, '%d-%m-%Y') AS  snr_pod_date",
                        "snr_name_courier",
                        "unique_id",
                    ];
                    $table_details = [
                        $table_sub_dc,
                        $columns
                    ];
                    $result_values_data = $pdo->select($table_details, $where);
                    if ($result_values_data->status) {
                        $result_values_data = $result_values_data->data;
                        $dc_dispatch_mode = $result_values_data[0]["dc_dispatch_mode"];
                        $name_of_courier = $result_values_data[0]["name_of_courier"];
                        $dc_pod_no = $result_values_data[0]["dc_pod_no"];
                        $dc_pod_date = $result_values_data[0]["dc_pod_date"];
                        $ir_dispatch_mode = $result_values_data[0]["ir_dispatch_mode"];
                        $ins_name_of_courier = $result_values_data[0]["ins_name_of_courier"];
                        $ir_pod_no = $result_values_data[0]["ir_pod_no"];
                        $ir_pod_date = $result_values_data[0]["ir_pod_date"];
                        $snr_dispatch_mode = $result_values_data[0]["snr_dispatch_mode"];
                        $snr_pod_no = $result_values_data[0]["snr_pod_no"];
                        $snr_pod_date = $result_values_data[0]["snr_pod_date"];
                        $snr_name_courier = $result_values_data[0]["snr_name_courier"];
                        $unique_id = $result_values_data[0]["unique_id"];
                        $btn_text = "Update";
                        $btn_action = "update";
                    } else {
                        $btn_text = "Error";
                        $btn_action = "error";
                        $is_btn_disable = "disabled='disabled'";
                    }
                    $dc_dispatch_mode_options = [
                        [
                            "id" => 'Hand Delivery',
                            "text" => "Hand Delivery"
                        ],
                        [
                            "id" => 'Courier',
                            "text" => "Courier"
                        ],
                        [
                            "id" => 'Transporter',
                            "text" => "Transporter"
                        ],
                    ];
                    $dc_dispatch_mode_options = select_option($dc_dispatch_mode_options, "Select Dispatch Mode", $dc_dispatch_mode);
                    $ir_dispatch_mode_options = [
                        [
                            "id" => 'Hand Delivery',
                            "text" => "Hand Delivery"
                        ],
                        [
                            "id" => 'Courier',
                            "text" => "Courier"
                        ],
                        [
                            "id" => 'Transporter',
                            "text" => "Transporter"
                        ],
                    ];
                    $ir_dispatch_mode_options = select_option($ir_dispatch_mode_options, "Select Ir Dispatch Mode", $ir_dispatch_mode);
                    $snr_dispatch_mode_options = [
                        [
                            "id" => 'Hand Delivery',
                            "text" => "Hand Delivery"
                        ],
                        [
                            "id" => 'Courier',
                            "text" => "Courier"
                        ],
                        [
                            "id" => 'Transporter',
                            "text" => "Transporter"
                        ],
                    ];
                    $snr_dispatch_mode_options = select_option($snr_dispatch_mode_options, "Select Snr Dispatch Mode", $snr_dispatch_mode);
                    ?>
                    <?php

                    $where_1 = "consignee_unique_id='$consignee_unique_id' AND invoice_no='$invoice_no' AND is_delete=0";

                    $table_ins_det = "installation_details";
                    $columns_1 = [
                        "documents_type",
                        "documents_type1",
                        "documents_type2",
                        "without_snr",


                    ];
                    $table_details_1 = [
                        $table_ins_det,
                        $columns_1
                    ];
                    $result_values_data_sts = $pdo->select($table_details_1, $where_1);
                    if ($result_values_data_sts->status) {
                        $result_values_data_status = $result_values_data_sts->data;
                        $dc_sts = $result_values_data_status[0]["documents_type"];
                        $ir_sts = $result_values_data_status[0]["documents_type1"];
                        $snr_sts = $result_values_data_status[0]["documents_type2"];
                        $without_snr = $result_values_data_status[0]["without_snr"];


                        $btn_text = "Update";
                        $btn_action = "update";
                    } else {
                        $btn_text = "Error";
                        $btn_action = "error";
                        $is_btn_disable = "disabled='disabled'";
                    }
                    ?>

                    <input type="hidden" id="dc_sts" name="dc_sts" class="form-control" value="<?php if ($dc_sts != '') {
                        echo $dc_sts;
                    } else {
                        echo '';
                    } ?>" required>
                    <input type="hidden" id="ir_sts" name="ir_sts" class="form-control" value="<?php if ($ir_sts != '') {
                        echo $ir_sts;
                    } else {
                        echo '';
                    } ?>" required>
                    <input type="hidden" id="snr_sts" name="snr_sts" class="form-control" value="<?php if ($snr_sts != '') {
                        echo $snr_sts;
                    } else {
                        echo '';
                    } ?>" required>

                    <br>


                    <div class="table-responsive mb-4" id="dc_option" style="display:none;">
                        <h6><b>Delivery Document</b></h6>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">DC Dispatch Mode</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $dc_dispatch_mode; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">Name of the Person/Courier or Transporter Name</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $name_of_courier; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD No.</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $dc_pod_no; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD Date</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $dc_pod_date; ?></div>
                        </div>
                    </div>


                    <div class="table-responsive mb-4" id="ir_option" style="display:none;">
                        <h6><b>Installation Document</b></h6>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">IR Dispatch Mode</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $ir_dispatch_mode; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">Name of the Person/Courier or Transporter Name</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $ins_name_of_courier; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD No.</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $ir_pod_no; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD Date</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $ir_pod_date; ?></div>
                        </div>
                    </div>


                    <div class="table-responsive mb-4" id="snr_option" style="display:none;">
                        <h6>Signed Document</h6>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">Snr Dispatch Mode</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $snr_dispatch_mode; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">Name of the Person/Courier or Transporter Name</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $snr_pod_no; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD No.</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $snr_pod_date; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                                <label class="form-label">POD Date</label>
                            </div>
                            <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 view_detail"><?php echo $snr_name_courier; ?></div>
                        </div>
                    </div>


                </div>
            </div>
             <div class="form-group row ">
            <div class="col-md-12 " align="right">

                <!-- Cancel,save and update Buttons -->
                <a href="install_list2.php"><button type="button"
                        class="btn btn-danger waves-effect waves-light">Cancel</button>
                </a>
                
            </div>
        </div>
        </div>
    </div>
    </form>


</div>

</div>
</div>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function print_pdf_dc(file_name) {

        onmouseover = window.open('../uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    document.getElementById("backButton").addEventListener("click", function () {
        window.location.href = "list.php"; // Redirects to list.php
    });

    $(document).ready(function () {
        status();
        shows1();
        shows2();
        shows();

    });

    function status() {
        var dc_sts = document.getElementById('dc_sts').value;
        var ir_sts = document.getElementById('ir_sts').value;
        var snr_sts = document.getElementById('snr_sts').value;
        if (dc_sts == 'DC') {
            $('#dc_option').show();
            $('#ir_option').hide();
            $('#snr_option').hide();


        }
        if (dc_sts === 'DC' && ir_sts === 'IR') {
            $('#dc_option').show();
            $('#ir_option').show();
            $('#snr_option').hide();
        }
        if (dc_sts === 'DC' && snr_sts === 'SNR') {
            $('#snr_option').show();
            $('#ir_option').hide();
            $('#dc_option').show();
        }
        if (dc_sts === 'DC' && snr_sts === 'SNR' && ir_sts === 'IR') {
            $('#snr_option').show();
            $('#ir_option').show();
            $('#dc_option').show();
        }

    }

    function shows() {
        var deliveryElement = document.getElementById('dc_dispatch_mode');
        if (deliveryElement) {
            var mode_of_delivery = deliveryElement.value;

            if (mode_of_delivery === 'Hand Delivery') {
                $('#dc_pod_tab').hide();
                $('#dc_pod_label').hide();
                $('#dc_pod_tab1').hide();
            } else {
                $('#dc_pod_tab').show();
                $('#dc_pod_label').show();
                $('#dc_pod_tab1').show();
            }
        } else {
        }
    }


    function shows1() {
        var dispatchEl = document.getElementById('ir_dispatch_mode');
        if (!dispatchEl) {
            return; // Exit the function to avoid errors
        }

        var mode_of_delivery1 = dispatchEl.value;

        if (mode_of_delivery1 === 'Hand Delivery') {
            $('#ir_pdo_tab').hide();
            $('#ir_pod_label').hide();
            $('#ir_pdo_tab1').hide();
        } else {
            $('#ir_pdo_tab').show();
            $('#ir_pod_label').show();
            $('#ir_pdo_tab1').show();
        }
    }


    function shows2() {
        var deliveryElement = document.getElementById('snr_dispatch_mode');
        if (deliveryElement) {
            var mode_of_delivery2 = deliveryElement.value;

            if (mode_of_delivery2 === 'Hand Delivery') {
                $('#snr_pdo_tab').hide();
                $('#snr_pod_label').hide();
                $('#snr_pdo_tab1').hide();
            } else {
                $('#snr_pdo_tab').show();
                $('#snr_pdo_tab1').show();
                $('#snr_pod_label').show();
            }
        } else {
        }
    }


</script>
