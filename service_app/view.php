<?php
error_log(0);
include 'header.php';
?>
<?php
include 'header.php';
include '../config/dbconfig.php';

?>
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

$consignee_unique_id = isset($_GET['consignee_unique_id']) ? $_GET['consignee_unique_id'] : '';
$invoice_no = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
$dc_number = isset($_GET['dc_number']) ? $_GET['dc_number'] : '';


if (isset($_GET["invoice_no"])) {
    if (!empty($_GET["invoice_no"])) {

        $invoice_auto_id = $_GET["invoice_no"];
        $where = [
            "invoice_no" => $invoice_auto_id,
            "dc_number" => $dc_number,

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
            "invoice_date",
            "form_main_unique_id",
            "consignee_unique_id",
            "ins_reqired",
            "dc_required",
            "document_required",
            // "dc_date",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "dc_number",
            "engineer_name as engineer_id",
            "(SELECT staff_name FROM view_login WHERE view_login.unique_id = view_installation_followups.engineer_name) AS engineer_name",
            "DATE_FORMAT(date, '%d-%m-%Y') AS date",
            "in_charge",
            'con_district',
            'con_state_name',
            'zone',
            "con_pincode",
            "sign_reject_reason",
            "installation_status",
            "engg_type",
            "(SELECT CASE 
     WHEN SUM(CASE WHEN document_required = 'ir_required' THEN 1 ELSE 0 END) > 0 
     THEN 2 
     ELSE 1 
 END 
 FROM product_details_sub 
 WHERE form_main_unique_id = view_installation_followups.form_main_unique_id) AS doc_required_status",

        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);
        if ($result_values->status) {
            $result_values = $result_values->data;

            $po_unique_id = $result_values[0]["po_num"];
            $con_contact_name = $result_values[0]["con_contact_name"];
            $con_address = $result_values[0]["con_address"];
            $invoice_no = $result_values[0]["invoice_no"];
            $consignee_unique_id = $result_values[0]["consignee_unique_id"];
            $dc_required = $result_values[0]["dc_required"];
            $ins_reqired = $result_values[0]["ins_reqired"];
            $engineer_name = $result_values[0]["engineer_name"];
            $engineer_id = $result_values[0]["engineer_id"];
            $installation_com_date = $result_values[0]["date"];
            $eng_remarks = $result_values[0]["in_charge"];
            $con_district = $result_values[0]["con_district"];
            $con_state_name = $result_values[0]["con_state_name"];
            $zone = $result_values[0]["zone"];
            $con_pincode = $result_values[0]["con_pincode"];
            $sign_reject_reason = $result_values[0]["sign_reject_reason"];
            $installation_status = $result_values[0]["installation_status"];
            $engg_type = $result_values[0]["engg_type"];
            $doc_required_status = $result_values[0]["doc_required_status"];

            $document_required = $result_values[0]["document_required"];
            $dc_date = $result_values[0]["dc_date"];
            $dc_number = $result_values[0]["dc_number"];
            // Format PO Date
            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));
            $date = $result_values[0]["date"];  
                  $gst = $result_values[0]["vendor_bulk_gst"]; 
    $total_amount = $result_values[0]["bulk_ttl_amnt"]; 
            // Format Invoice Date
            if ($result_values[0]["invoice_date"] == '') {
                $invoice_date = '';
            } else {
                $orgDate1 = $result_values[0]["invoice_date"];
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }
 if ($engg_type == '1') {

        $engg_type = 'Own Engineer';
    } else if($engg_type == '2') {
        $engg_type = 'Outsource Vendor';
    }
            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

$engineer_name_optionss = engineer_name();
$engineer_name_option = select_option($engineer_name_optionss, "Select Eng Name", $engineer_name_inv);

$active_status_options = active_status($is_active);

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
    .card{    border: 1px solid rgb(255 255 255 / 13%);}
</style>
<div class="body_style ">
    <div class="sub-hed ">
        <div class="row">
            <div class="col-12 log-out">
                <h4 class="mb-sm-0" style=" text-align:center"> Installation </h4>
                <div class="page-title-right pt-2 pb-2">
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
            <h3 class="mb-4 text_style">Installation Completed Details</h3>
            <div class="col-12 border_style">
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">PO Number</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $po_unique_id; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">PO Date</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $po_date; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">Invoice No</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $invoice_no; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po">
                        <label class="form-label">Invoice Date</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $invoice_date; ?></div>
                </div>
 <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">DC No</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $dc_number; ?></div>
                </div>
<div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">DC Date</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $dc_date; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Consignee
                            Name</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $con_contact_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Consignee
                            Address</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $con_address; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">State Name</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $con_state_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">District
                            Name</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $con_district; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Zone Name</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $zone; ?></div>
                </div>

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Pincode</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $con_pincode; ?></div>
                </div>

                <?php if ($installation_status == '3') { ?>
                    <div class="row">
                        <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Reject
                                Reason</label></div>
                        <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo  $sign_reject_reason; ?></div>
                    </div>
                <?php } ?>

               <!-- <?php if ($engg_type == 'outsource-vendor') {?>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Installation
                            Charge</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $in_charge; ?></div>
                </div>
<?php } ?> -->
                   

                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Engg. Type</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $engg_type; ?></div>
                </div>
<div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Engg. Name</label>
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $engineer_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Date</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $installation_com_date; ?></div>
                </div>


               <?php if ($engg_type == 'outsource-vendor') {?>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Installation
                            Charge</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $in_charge; ?></div>
                </div>
                 <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Installation allocation Date</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $date; ?></div>
                </div>
                 <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Vendor Timeline Complition Date</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $vendor_bulk_timeline; ?></div>
                </div>
                 <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Rate</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $in_charge; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">GST</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $gst; ?></div>
                </div>
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Total Amount</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php echo $total_amount; ?></div>
                </div>
<?php }?>
               
                
                <div class="row">
                    <div class="col-5 col-sm-5 col-md-5 col-lg-5 head_po"> <label class="form-label">Document
                            Type</label></div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1">:</div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6"><?php
                    if ($document_required == 'ir_required') {
                        echo "IR Required";
                    } elseif ($document_required == 'dc_required') {
                        echo "DC Required";
                    } else {
                        echo "N/A";
                    }
                    ?></div>
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
            </div>
        </div>
        
        <?php
        $where = [
            "consignee_unique_id" => $consignee_unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number,
            "is_delete" => 0,

        ];
        $table_sub_install = "installation_details";

        $columns = [
            "po_form_unique_id",
            "(SELECT staff_name FROM view_login WHERE view_login.unique_id = installation_details.engineer_name) AS engineer_name",
            "installation_com_date",
            "cus_ack_date",
            "documents_type",
            "documents_type1",
            "documents_type2",
            "dc_received_sts",
            "dc_cus_signed_date",
            "ir_rec_status",
            "ir_cus_signed_date",
            "snr_rec_status",
            "snr_cus_signed_date",
            "dc_file",
            "ir_file",
            "snr_file",
            "unique_id",
            "consignee_unique_id",
            "dc_original_name",
            "ir_original_name",
            "snr_original_name"
        ];

        $table_details = [
            $table_sub_install,
            $columns
        ];

        $result_values_data = $pdo->select($table_details, $where);
        if ($result_values_data->status) {

            $result_values_data = $result_values_data->data;
            $engineer_name = $result_values_data[0]["engineer_name"];
            $installation_com_date = $result_values_data[0]["installation_com_date"];
            $cus_ack_date = $result_values_data[0]["cus_ack_date"];
            $documents_type = $result_values_data[0]["documents_type"];
            $documents_type1 = $result_values_data[0]["documents_type1"];
            $documents_type2 = $result_values_data[0]["documents_type2"];
            $dc_received_sts = $result_values_data[0]["dc_received_sts"];
            $dc_cus_signed_date = $result_values_data[0]["dc_cus_signed_date"];
            $ir_rec_status = $result_values_data[0]["ir_rec_status"];
            $ir_cus_signed_date = $result_values_data[0]["ir_cus_signed_date"];
            $snr_rec_status = $result_values_data[0]["snr_rec_status"];
            $snr_cus_signed_date = $result_values_data[0]["snr_cus_signed_date"];

            $ir_file = $result_values_data[0]["ir_file"];
            $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);

            $dc_file = $result_values_data[0]["dc_file"];
            $dc_file_show = image_view_dc_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['dc_file']);


            $snr_file = $result_values_data[0]["snr_file"];
            $snr_file_show = image_view_snr_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['snr_file']);

            $dc_original_name = $result_values_data[0]["dc_original_name"];
            $ir_original_name = $result_values_data[0]["ir_original_name"];
            $snr_original_name = $result_values_data[0]["snr_original_name"];


            $sign_unique_id = $result_values_data[0]["unique_id"];
            $consignee_unique_id = $result_values_data[0]["consignee_unique_id"];



            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }


        $dc_received_sts_options = [
            [
                "id" => '1',
                "text" => "Yes"
            ],


        ];
        $dc_received_sts_options = select_option($dc_received_sts_options, "Select Status", $dc_received_sts);

        $ir_rec_status_options = [
            [
                "id" => '1',
                "text" => "Yes"
            ],


        ];

        $ir_rec_status_options = select_option($ir_rec_status_options, "Select Status", $ir_rec_status);

        $snr_rec_status_options = [
            [
                "id" => '1',
                "text" => "Yes"
            ],


        ];

        $snr_rec_status_options = select_option($snr_rec_status_options, "Select Status", $snr_rec_status);

        $engineer_name_options = engineer_name();
        $engineer_name_options = select_option($engineer_name_options, "Select Eng Name", $engineer_name);
        $engineer_type_options = engineer_type();
        $engineer_type_options = select_option($engineer_type_options, "Select Eng Type", $engineer_name);
        if ($engg_type == '1') {

            $engg_type_name = 'Own Engineer';
        } else if($engg_type == '2') {
            $engg_type_name = 'Outsource Vendor';
        }
        ?>
        <div class="card cf m-3">
            <div class="card-body">
                <label class="form-label">Document uploads</label>

                <?php if ($doc_required_status == "1") { ?>

                    <!-- Hidden Install Date -->
                    <input type="hidden" class="form-control" id="install_date" onchange="demo()" name="install_date"
                        value="<?php echo $current_date; ?>" style="display:none;">
                    <label class="container">DC
                        <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type"
                            value="DC" <?php echo ($documents_type == 'DC') ? 'checked disabled' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                <?php } elseif ($doc_required_status == "2") { ?>
                    <!-- DC Checkbox -->
                    <label class="container">DC
                        <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type"
                            value="DC" <?php echo ($documents_type == 'DC') ? 'checked disabled' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>

                    <!-- IR Checkbox -->
                    <label class="container">IR
                        <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1"
                            id="documents_type1" value="IR" <?php echo ($documents_type1 == 'IR') ? 'checked disabled' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>

                    <!-- SNR Checkbox -->
                    <label class="container">SNR
                        <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1"
                            id="documents_type2" value="SNR" <?php echo ($documents_type2 == 'SNR') ? 'checked disabled' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>

                    <!-- Hidden Install Date for IR (only if IR is not already selected) -->
                    <?php if ($documents_type1 != 'IR') { ?>
                        <input type="hidden" class="form-control" id="ir_install_date" name="ir_install_date"
                            value="<?php echo $current_date; ?>" style="display:none;">
                    <?php } ?>
                <?php } ?>

                <div class="row">
                    <?php if ($dc_received_sts == '') { ?>
                        <div class="col-xl-3" id="dc_option" style="display:none;">
                            <label class="form-label">DC Received Status</label>
                            <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" required>
                                <?php echo $dc_received_sts_options; ?>
                            </select>
                        </div>
                    <?php } else if ($dc_received_sts != '') { ?>
                            <div class="col-xl-3" id="dc_option" style="display:none;">
                                <label class="form-label">DC Received Status</label>
                                <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" disabled required>
                                <?php echo $dc_received_sts_options; ?>
                                </select>
                            </div>
                    <?php } ?>
                    <?php if ($dc_cus_signed_date == '') { ?>
                        <div class="col-xl-3" id="dc_option1" style="display:none;">

                            <label class="form-label">DC Customer Signed Date</label>
                            <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date"
                                value="<?php echo $dc_cus_signed_date ?>" required>

                        </div>
                    <?php } else if ($dc_cus_signed_date != '') { ?>
                            <div class="col-xl-3" id="dc_option1" style="display:none;">

                                <label class="form-label">DC Customer Signed Date</label>
                                <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date"
                                    value="<?php echo $dc_cus_signed_date ?>" disabled required>
                            </div>
                    <?php } ?>

                    <?php if ($dc_file == '') { ?>
                        <div class="col-xl-3" id="dc_option2" style="display:none;">

                            <label class="form-label">DC Signed Proof</label>
                            <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf"
                                value="<?php echo $dc_file; ?>">

                        </div>
                    <?php } else if ($dc_file != '') { ?>
                            <div class="col-xl-3" id="dc_option2" style="display:none;">

                                <label class="form-label">DC Signed Proof</label>
                                <div>
                                    <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf"
                                        disabled value="<?php echo $dc_file; ?>" disabled>

                                </div>
                            </div>
                            <div class="col-xl-3" id="dc_option3">
                                <label class="form-label">DC Attached Proof</label><br>


                                <input class="form-control" type="hidden" id="dc_file_data" name="dc_file_data"
                                    value="<?php echo $dc_file ?>">
                                <input class="form-control" type="hidden" id="dc_file_name" name="dc_file_name"
                                    value="<?php echo $dc_original_name ?>">

                            <?php echo $dc_file_show; ?>
                            <?php echo $dc_original_name; ?>
                            </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if ($ir_rec_status == '') { ?>
                        <!-- IR Received Status -->
                        <div class="col-xl-3" id="ir_option" style="display:none;">
                            <label class="form-label">IR Received Status</label>
                            <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status" required>
                                <?php echo $ir_rec_status_options ?>
                            </select>
                        </div>
                    <?php } else if ($ir_rec_status != '') { ?>

                            <div class="col-xl-3" id="ir_option" style="display:none;">
                                <label class="form-label">IR Received Status</label>
                                <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status" disabled>
                                <?php echo $ir_rec_status_options ?>
                                </select>
                            </div>
                    <?php } ?>

                    <?php if ($ir_cus_signed_date == '') { ?>
                        <!-- IR Customer Signed Date -->
                        <div class="col-xl-3" id="ir_option1" style="display:none;">
                            <label class="form-label">IR Customer Signed Date</label>
                            <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date"
                                value="<?php echo $ir_cus_signed_date ?>" <?php //echo ($ir_cus_signed_date) ? 'disabled' : ''; ?> required>
                        </div>
                    <?php } else if ($ir_cus_signed_date != '') { ?>
                            <div class="col-xl-3" id="ir_option1" style="display:none;">

                                <label class="form-label">IR Customer Signed Date</label>
                                <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date"
                                    value="<?php echo $ir_cus_signed_date ?>" disabled>

                            </div>
                    <?php } ?>

                    <!-- IR Signed Proof -->
                    <?php if ($ir_file == '') { ?>
                        <div class="col-xl-3" id="ir_option2" style="display:none;">
                            <label class="form-label">IR Signed Proof</label>
                            <input class="form-control" type="file" id="ir_file" name="ir_file" accept="application/pdf">
                        </div>
                    <?php } else { ?>
                        <!-- Disabled file input -->
                        <div class="col-xl-3" id="ir_option2" style="display:none;">
                            <label class="form-label">IR Signed Proof</label>
                            <input class="form-control" type="file" id="ir_file_display" name="ir_file_display"
                                accept="application/pdf" disabled>
                        </div>

                        <!-- Display Attached File Info -->
                        <div class="col-xl-3" id="ir_option3">
                            <label class="form-label">IR Attached Proof</label><br>
                            <input type="hidden" class="form-control" id="ir_file" name="ir_file"
                                value="<?php echo $ir_original_name; ?>">
                            <input type="hidden" class="form-control" id="ir_file_data" name="ir_file_data"
                                value="<?php echo $ir_file; ?>">
                            <input type="hidden" class="form-control" id="ir_file_name" name="ir_file_name"
                                value="<?php echo $ir_original_name; ?>">

                            <?php echo $ir_file_show; ?>
                            <?php echo $ir_original_name; ?>
                        </div>
                    <?php } ?>

                </div>
                <!-- NEW CANES -->
                <div class="row">

                    <?php if ($snr_rec_status == '') { ?>
                        <div class="col-xl-3" id="snr_option" style="display:none;">
                            <label class="form-label">SNR Received Status</label>
                            <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status">
                                <?php echo $snr_rec_status_options ?>
                            </select>
                        </div>
                    <?php } else if ($snr_rec_status != '') { ?>
                            <div class="col-xl-3" id="snr_option" style="display:none;">
                                <label class="form-label">SNR Received Status</label>
                                <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status" disabled>
                                <?php echo $snr_rec_status_options ?>
                                </select>
                            </div>
                    <?php } ?>
                    <?php if ($snr_cus_signed_date == '') { ?>
                        <div class="col-xl-3" id="snr_option1" style="display:none;">

                            <label class="form-label">SNR Customer Signed Date</label>
                            <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date"
                                value="<?php echo $snr_cus_signed_date ?>">

                        </div>
                    <?php } else if ($snr_cus_signed_date != '') { ?>
                            <div class="col-xl-3" id="snr_option1" style="display:none;">

                                <label class="form-label">SNR Customer Signed Date</label>
                                <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date"
                                    value="<?php echo $snr_cus_signed_date ?>" disabled>

                            </div>
                    <?php } ?>
                    <?php if ($snr_file == '') { ?>
                        <div class="col-xl-3" id="snr_option2" style="display:none;">

                            <label class="form-label">SNR Signed Proof</label>
                            <input class="form-control" type="file" id="snr_file" name="snr_file" accept="application/pdf"
                                value="<?php echo $snr_file; ?>">

                            <!-- $snr_file_show -->
                        </div>
                    <?php } else if ($snr_file != '') { ?>


                            <div class="col-xl-3" id="snr_option2" style="display:none;">
                                <label class="form-label">SNR Signed Proof</label>
                                <input class="form-control" type="file" id="snr_file" name="snr_file" accept="application/pdf"
                                    value="<?php echo $snr_file; ?>" disabled>

                            </div>

                            <div class="col-xl-3" id="snr_option3">


                                <label class="form-label">SNR Attached Proof</label><br>
                                <input type="hidden" class="form-control" id="snr_file" name="snr_file"
                                    value="<?php echo $snr_original_name; ?>">
                                <input type="hidden" class="form-control" id="snr_file_data" name="snr_file_data"
                                    value="<?php echo $snr_file; ?>">
                                <input type="hidden" class="form-control" id="snr_file_name" name="snr_file_name"
                                    value="<?php echo $snr_original_name; ?>">

                            <?php echo $snr_file_show; ?>
                            <?php echo $snr_original_name; ?>



                            </div>

                    <?php } ?>



                    <input class="form-control" type="hidden" id="form_unique_id" name="form_unique_id"
                        value="<?php echo $result_values_data[0]["unique_id"] ?>">
                    <input class="form-control" type="hidden" id="unique_id" name="unique_id"
                        value="<?php echo $result_values_data[0]["unique_id"] ?>">
                    <input class="form-control" type="hidden" id="po_unique_id" name="po_unique_id"
                        value="<?php echo $result_values[0]["po_unique_id"] ?>">
                    <input class="form-control" type="hidden" id="po_num" name="po_num"
                        value="<?php echo $result_values[0]["po_num"] ?>">
                    <input class="form-control" type="hidden" id="po_date" name="po_date"
                        value="<?php echo $result_values[0]["po_date"] ?>">
                    <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id"
                        value="<?php echo $result_values[0]["invoice_auto_id"] ?>">
                    <input class="form-control" type="hidden" id="invoice_no" name="invoice_no"
                        value="<?php echo $result_values[0]["invoice_no"] ?>">
                    <input class="form-control" type="hidden" id="invoice_date" name="invoice_date"
                        value="<?php echo $result_values[0]["invoice_date"] ?>">
                    <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id"
                        value="<?php echo $result_values[0]["consignee_unique_id"] ?>">
                    <input class="form-control" type="hidden" id="po_form_unique_id" name="po_form_unique_id"
                        value="<?php echo $result_values[0]["form_main_unique_id"] ?>">
                    <input class="form-control" type="hidden" id="dc_required" name="dc_required"
                        value="<?php echo $result_values[0]["dc_required"] ?>">
                    <input class="form-control" type="hidden" id="ins_reqired" name="ins_reqired"
                        value="<?php echo $result_values[0]["ins_reqired"] ?>">
                    <input class="form-control" type="hidden" id="engineer_name" name="engineer_name"
                        value="<?php echo $result_values[0]["engineer_name"] ?>">
                    <input class="form-control" type="hidden" id="installation_com_date" name="installation_com_date"
                        value="<?php echo $result_values[0]["date"] ?>">
                    <input class="form-control" type="hidden" id="eng_remarks" name="eng_remarks"
                        value="<?php echo $result_values[0]["in_charge"] ?>">
                    <input class="form-control" type="hidden" id="engineer_id" name="engineer_id"
                        value="<?php echo $result_values[0]["engineer_id"] ?>">


                </div>
            </div>
        </div>
        </form>
        <div class="form-group row ">
            <div class="col-md-12" align="right">
                <!-- Cancel,save and update Buttons -->

                <a class="nav-link" href="install_list.php"><button
                        class="btn btn-info waves-effect btn-danger waves-light">cancel</button></a>




            </div>
        </div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$where = [
    "consignee_unique_id" => $consignee_unique_id,
    "invoice_no" => $invoice_no,
    "dc_number" => $dc_number,
    "is_delete" => 0

];
$table_sub_install = "installation_details";

$columns = [
    "po_form_unique_id",
    "(SELECT staff_name FROM view_login WHERE view_login.unique_id = installation_details.engineer_name) AS engineer_name",
    "installation_com_date",
    "cus_ack_date",
    "documents_type",
    "documents_type1",
    "documents_type2",
    "dc_received_sts",
    "dc_cus_signed_date",
    "ir_rec_status",
    "ir_cus_signed_date",
    "snr_rec_status",
    "snr_cus_signed_date",
    "dc_file",
    "ir_file",
    "snr_file",
    "unique_id",
    "consignee_unique_id",
    "dc_original_name",
    "ir_original_name",
    "snr_original_name"
];

$table_details = [
    $table_sub_install,
    $columns
];

$result_values_data = $pdo->select($table_details, $where);
if ($result_values_data->status) {

    $result_values_data = $result_values_data->data;
    $engineer_name = $result_values_data[0]["engineer_name"];
    $installation_com_date = $result_values_data[0]["installation_com_date"];
    $cus_ack_date = $result_values_data[0]["cus_ack_date"];
    $documents_type = $result_values_data[0]["documents_type"];
    $documents_type1 = $result_values_data[0]["documents_type1"];
    $documents_type2 = $result_values_data[0]["documents_type2"];
    $dc_received_sts = $result_values_data[0]["dc_received_sts"];
    $dc_cus_signed_date = $result_values_data[0]["dc_cus_signed_date"];
    $ir_rec_status = $result_values_data[0]["ir_rec_status"];
    $ir_cus_signed_date = $result_values_data[0]["ir_cus_signed_date"];
    $snr_rec_status = $result_values_data[0]["snr_rec_status"];
    $snr_cus_signed_date = $result_values_data[0]["snr_cus_signed_date"];

    $ir_file = $result_values_data[0]["ir_file"];
    $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);

    $dc_file = $result_values_data[0]["dc_file"];
    $dc_file_show = image_view_dc_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['dc_file']);


    $snr_file = $result_values_data[0]["snr_file"];
    $snr_file_show = image_view_snr_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['snr_file']);

    $dc_original_name = $result_values_data[0]["dc_original_name"];
    $ir_original_name = $result_values_data[0]["ir_original_name"];
    $snr_original_name = $result_values_data[0]["snr_original_name"];


    $sign_unique_id = $result_values_data[0]["unique_id"];
    $consignee_unique_id = $result_values_data[0]["consignee_unique_id"];



    $btn_text = "Update";
    $btn_action = "update";
} else {
    $btn_text = "Error";
    $btn_action = "error";
    $is_btn_disable = "disabled='disabled'";
}


$dc_received_sts_options = [
    [
        "id" => '1',
        "text" => "Yes"
    ],


];
$dc_received_sts_options = select_option($dc_received_sts_options, "Select Status", $dc_received_sts);

$ir_rec_status_options = [
    [
        "id" => '1',
        "text" => "Yes"
    ],


];

$ir_rec_status_options = select_option($ir_rec_status_options, "Select Status", $ir_rec_status);

$snr_rec_status_options = [
    [
        "id" => '1',
        "text" => "Yes"
    ],


];

$snr_rec_status_options = select_option($snr_rec_status_options, "Select Status", $snr_rec_status);

$engineer_name_options = engineer_name();
$engineer_name_options = select_option($engineer_name_options, "Select Eng Name", $engineer_name);
$engineer_type_options = engineer_type();
$engineer_type_options = select_option($engineer_type_options, "Select Eng Type", $engineer_name);
if ($engg_type == '1') {

    $engg_type_name = 'Own Engineer';
} elseif($engg_type == '2') {
    $engg_type_name = 'Outsource Vendor';
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>


    function toggleSections() {
        var doc_required_status = $("#doc_required_status").val();

        if (doc_required_status === '1') {

            var isDCChecked = $("#documents_type").prop("checked");

            $("#dc_option, #dc_option1, #dc_option2,#dc_option3, #installation_date").toggle(isDCChecked);


        }

        else if (doc_required_status === '2') {

            var isDCChecked = $("#documents_type").prop("checked");
            var isIRChecked = $("#documents_type1").prop("checked");

            var isSNRChecked = $("#documents_type2").prop("checked");



            $("#dc_option, #dc_option1, #dc_option2,#dc_option3, #installation_date").toggle(isDCChecked);
            $("#ir_option, #ir_option1, #ir_option2,#ir_option3, #ir_install_date").toggle(isIRChecked);
            $("#snr_option, #snr_option1, #snr_option2,#snr_option3").toggle(isSNRChecked);
        }




        if (isDCChecked || isIRChecked || isSNRChecked) {
            $("#submitButton").show();
        } else {
            $("#submitButton").hide();
        }
    }

    $(document).ready(function () {
        toggleSections();

        $("#documents_type, #documents_type1, #documents_type2").on("change", function () {
            toggleSections();
        });
    });



    document.getElementById("backButton").addEventListener("click", function () {
        window.location.href = "list.php"; // Redirects to list.php
    });

    $(document).ready(function () {
        var documents_type = $('.check_box');
        var documents_type1 = $('.check_box1');
        var documents_type2 = $('.check_box2');

        // Check if checkbox exists and is checked
        if (documents_type.length && documents_type.prop('checked')) {
            $('#dc_option').show();
            $('#dc_option1').show();
            $('#dc_option2').show();
            $('#submitButton').show();
        } else {
            $('#dc_option').hide();
            $('#dc_option1').hide();
            $('#dc_option2').hide();
        }

        if (documents_type1.length && documents_type1.prop('checked')) {
            $('#ir_option').show();
            $('#ir_option1').show();
            $('#ir_option2').show();
            $('#submitButton').show();
        } else {
            $('#ir_option').hide();
            $('#ir_option1').hide();
            $('#ir_option2').hide();
        }

        if (documents_type2.length && documents_type2.prop('checked')) {
            $('#snr_option').show();
            $('#snr_option1').show();
            $('#snr_option2').show();
            $('#submitButton').show();
        } else {
            $('#snr_option').hide();
            $('#snr_option1').hide();
            $('#snr_option2').hide();
        }
    });


    $("#documents_type").on('change', function () {
        var tags = $("#dc_option,#dc_option1,#dc_option2,#submitButton");
        if ($(this).prop('checked')) {
            tags.show();
        } else {
            tags.hide();
        }
    });
    $("#documents_type1").on('change', function () {
        var tags = $("#ir_option,#ir_option1,#ir_option2,#submitButton");
        if ($(this).prop('checked')) {
            tags.show();
        } else {
            tags.hide();
        }
    });
    $("#documents_type2").on('change', function () {
        var tags = $("#snr_option,#snr_option1,#snr_option2,#submitButton");
        if ($(this).prop('checked')) {
            tags.show();
        } else {
            tags.hide();
        }
    });


    function print_dc(file_name) {
        // 
        window.location = '../uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }

    function print_pdf_dc(file_name) {

        onmouseover = window.open('../uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }


    function print_view_dc(file_name) {
        window.open('../uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
<?php
function image_view_dc_file($folder_name = "", $unique_id = "", $dc_file = "")
{
    $file_names = explode(',', $dc_file);
    $image_view_dc_file = '';

    if ($dc_file) {
        foreach ($file_names as $file_key => $dc_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_dc_file .= "&nbsp";
                } else {
                    $image_view_dc_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file);

            if ($dc_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_dc_file .= '<a href="javascript:print_view_dc(\'/' . $dc_file . '\')"><img src="../uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_dc_file .= '<a href="javascript:print_pdf_dc(\'/' . $dc_file . '\')"><img src="../uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_dc_file;
}


function image_view_ir_file($folder_name = "", $unique_id = "", $ir_file = "")
{
    $file_names = explode(',', $ir_file);
    $image_view_ir_file = '';

    if ($ir_file) {
        foreach ($file_names as $file_key => $ir_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_ir_file .= "&nbsp";
                } else {
                    $image_view_ir_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file);

            if ($ir_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_ir_file .= '<a href="javascript:print_view_dc(\'/' . $ir_file . '\')"><img src="../uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_ir_file .= '<a href="javascript:print_pdf_dc(\'/' . $ir_file . '\')"><img src="../uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_ir_file;
}


function image_view_snr_file($folder_name = "", $unique_id = "", $snr_file = "")
{
    $file_names = explode(',', $snr_file);
    $image_view_snr_file = '';

    if ($snr_file) {
        foreach ($file_names as $file_key => $snr_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_snr_file .= "&nbsp";
                } else {
                    $image_view_snr_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $snr_file);

            if ($snr_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_snr_file .= '<a href="javascript:print_view_dc(\'/' . $snr_file . '\')"><img src="../uploads/' . $folder_name . '/' . $snr_file . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_snr_file .= '<a href="javascript:print_pdf_dc(\'/' . $snr_file . '\')"><img src="../uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_snr_file;
}



?>

<script>


    $(document).ready(function () {
        // Set initial engineer name options based on selected Engg. Type
        updateEngineerNameOptions();

        // Listen for changes in Engg. Type dropdown
        $('#engg_type').on('change', function () {
            updateEngineerNameOptions();
        });

        function updateEngineerNameOptions() {
            var enggType = $('#engg_type').val();
            var engineerNameSelect = $('#engineer_name');

            // Clear existing options
            engineerNameSelect.empty();

            // Add default option
            engineerNameSelect.append('<option value="">Select Engg. Name</option>');

            // Check which Engg. Type is selected and load corresponding options
            if (enggType == '1') { // Own Engineer
                // Append Own Engineer options

            } else if (enggType == '2') { // Outsource Vendor
                // Append Outsource Vendor options

            }
        }
    });

    function installation_cu() {
        var dc_required = document.getElementById('dc_required').value;
        var ins_reqired = document.getElementById('ins_reqired').value;
        if (ins_reqired == 'on') {
            var po_num = document.getElementById('po_num').value;
            var po_unique_id = document.getElementById('po_unique_id').value;
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var po_date = document.getElementById('po_date').value;
            var invoice_auto_id = document.getElementById('invoice_auto_id').value;
            var invoice_no = document.getElementById('invoice_no').value;

            var invoice_date = document.getElementById('invoice_date').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var engineer_id = document.getElementById('engineer_id').value;
            var installation_com_date = document.getElementById('installation_com_date').value;
            var eng_remarks = document.getElementById('eng_remarks').value;
            var dc_received_sts = document.getElementById('dc_received_sts').value;
            var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
            var ir_rec_status = document.getElementById('ir_rec_status').value;
            var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
            var snr_rec_status = document.getElementById('snr_rec_status').value;
            var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;
            var unique_id = document.getElementById('unique_id').value;
            var documents_type = document.getElementById('documents_type');
            if (documents_type.checked) {
                var dc_checkbox = 'DC';
            } else {
                var dc_checkbox = '0';
            }

            var documents_type1 = document.getElementById('documents_type1');
            if (documents_type1.checked) {
                var ir_checkbox = 'IR';
            } else {
                var ir_checkbox = '0';
            }

            var documents_type2 = document.getElementById('documents_type2');
            if (documents_type2.checked) {
                var snr_checkbox = 'SNR';
            } else {
                var snr_checkbox = '0';
            }


            var test_doc = document.getElementById('dc_file').value;
            var test_doc1 = document.getElementById('ir_file').value;
            var test_doc2 = document.getElementById('snr_file').value;
            var image_s = document.getElementById("dc_file");
            var image_ir = document.getElementById("ir_file");
            var image_in = document.getElementById("snr_file");
            var data = new FormData();
            if (image_s != '') {
                if (image_s.files) {
                    for (var i = 0; i < image_s.files.length; i++) {
                        data.append("test_file[]", document.getElementById('dc_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc", '');

            }

            if (image_ir != '') {
                if (image_ir.files) {
                    for (var i = 0; i < image_ir.files.length; i++) {
                        data.append("test_file1[]", document.getElementById('ir_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc1", '');

            }

            if (image_in != '') {
                if (image_in.files) {
                    for (var i = 0; i < image_in.files.length; i++) {
                        data.append("test_file2[]", document.getElementById('snr_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc2", '');

            }


            var snr_file_data;
            element2 = document.getElementById('snr_file_data');
            if (element2 != null) {
                snr_file_data = element2.value;
            }
            else {
                snr_file_data = null;
            }

            var snr_file_name;
            element3 = document.getElementById('snr_file_name');
            if (element3 != null) {
                snr_file_name = element3.value;
            }
            else {
                snr_file_name = null;
            }



        }
        else if (dc_required == 'on') {

            var po_num = document.getElementById('po_num').value;
            var po_unique_id = document.getElementById('po_unique_id').value;
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var po_date = document.getElementById('po_date').value;
            var invoice_auto_id = document.getElementById('invoice_auto_id').value;
            var invoice_no = document.getElementById('invoice_no').value;
            var invoice_date = document.getElementById('invoice_date').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var engineer_id = document.getElementById('engineer_id').value;
            var installation_com_date = document.getElementById('installation_com_date').value;
            var eng_remarks = document.getElementById('eng_remarks').value;
            var dc_received_sts = document.getElementById('dc_received_sts').value;
            var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
            var unique_id = document.getElementById('unique_id').value;
            var documents_type = document.getElementById('documents_type');
            if (documents_type.checked) {
                var dc_checkbox = 'DC';
            } else {
                var dc_checkbox = '0';
            }

            var test_doc = document.getElementById('dc_file').value;
            var image_s = document.getElementById("dc_file");

            var data = new FormData();
            if (image_s != '') {
                if (image_s.files) {
                    for (var i = 0; i < image_s.files.length; i++) {
                        data.append("test_file[]", document.getElementById('dc_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc", '');

            }


        }
        data.append("po_num", po_num);
        data.append("po_form_unique_id", po_form_unique_id);
        data.append("po_unique_id", po_unique_id);
        data.append("po_date", po_date);
        data.append("invoice_auto_id", invoice_auto_id);
        data.append("invoice_no", invoice_no);
        data.append("invoice_date", invoice_date);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("engineer_id", engineer_id);
        data.append("installation_com_date", installation_com_date);
        data.append("eng_remarks", eng_remarks);
        data.append("dc_required", dc_required);
        data.append("documents_type", dc_checkbox);
        data.append("documents_type1", ir_checkbox);
        data.append("documents_type2", snr_checkbox);
        data.append("dc_received_sts", dc_received_sts);
        data.append("dc_cus_signed_date", dc_cus_signed_date);
        data.append("ir_rec_status", ir_rec_status);
        data.append("ir_cus_signed_date", ir_cus_signed_date);
        data.append("snr_rec_status", snr_rec_status);
        data.append("snr_cus_signed_date", snr_cus_signed_date);
        data.append("unique_id", unique_id);
        data.append("snr_file_data", snr_file_data);
        data.append("snr_file_name", snr_file_name);

        data.append("action", "createupdate");

        $.ajax({
            type: "POST",
            url: "crud.php",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                try {

                    var jsonData = JSON.parse(response);
                    console.log("Parsed JSON:", jsonData);


                    if (jsonData.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: jsonData.msg,
                            timer: 1500, // Auto-close in 500ms
                            showConfirmButton: false
                        });


                        setTimeout(() => {
                            installation_creation_sub(); // Call function if needed
                            window.location.reload(); // Force page reload to get updated data
                            window.location.href = 'install_list.php';
                        }, 800);



                    } else {
                        console.error("First CRUD failed:", jsonData.msg);
                    }

                    // Call the other function after successful response


                } catch (error) {
                    alert("Server returned an invalid JSON response.");
                }
            }

        });
    }

    function installation_creation_sub() {
        var dc_required = document.getElementById('dc_required').value;
        var ins_reqired = document.getElementById('ins_reqired').value;
        if (ins_reqired == 'on') {
            var po_num = document.getElementById('po_num').value;
            var po_unique_id = document.getElementById('po_unique_id').value;
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var po_date = document.getElementById('po_date').value;
            var invoice_auto_id = document.getElementById('invoice_auto_id').value;
            var invoice_no = document.getElementById('invoice_no').value;

            var invoice_date = document.getElementById('invoice_date').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var engineer_id = document.getElementById('engineer_id').value;
            var installation_com_date = document.getElementById('installation_com_date').value;
            var eng_remarks = document.getElementById('eng_remarks').value;
            var dc_received_sts = document.getElementById('dc_received_sts').value;
            var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
            var ir_rec_status = document.getElementById('ir_rec_status').value;
            var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
            var snr_rec_status = document.getElementById('snr_rec_status').value;
            var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;
            var unique_id = document.getElementById('unique_id').value;



            var dc_file_data;
            element = document.getElementById('dc_file_data');
            if (element != null) {
                dc_file_data = element.value;
            }
            else {
                dc_file_data = null;
            }


            var dc_file_name;
            element1 = document.getElementById('dc_file_name');
            if (element1 != null) {
                dc_file_name = element1.value;
            }
            else {
                dc_file_name = null;
            }

            var snr_file_data;
            element2 = document.getElementById('snr_file_data');
            if (element2 != null) {
                snr_file_data = element2.value;
            }
            else {
                snr_file_data = null;
            }

            var snr_file_name;
            element3 = document.getElementById('snr_file_name');
            if (element3 != null) {
                snr_file_name = element3.value;
            }
            else {
                snr_file_name = null;
            }


            var documents_type = document.getElementById('documents_type');
            if (documents_type.checked) {
                var dc_checkbox = 'DC';
            } else {
                var dc_checkbox = '0';
            }

            var documents_type1 = document.getElementById('documents_type1');
            if (documents_type1.checked) {
                var ir_checkbox = 'IR';
            } else {
                var ir_checkbox = '0';
            }

            var documents_type2 = document.getElementById('documents_type2');
            if (documents_type2.checked) {
                var snr_checkbox = 'SNR';
            } else {
                var snr_checkbox = '0';
            }


            var test_doc = document.getElementById('dc_file').value;
            var test_doc1 = document.getElementById('ir_file').value;
            var test_doc2 = document.getElementById('snr_file').value;
            var image_s = document.getElementById("dc_file");
            var image_ir = document.getElementById("ir_file");
            var image_in = document.getElementById("snr_file");
            var data = new FormData();
            if (image_s != '') {
                if (image_s.files) {
                    for (var i = 0; i < image_s.files.length; i++) {
                        data.append("test_file[]", document.getElementById('dc_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc", '');

            }

            if (image_ir != '') {
                if (image_ir.files) {
                    for (var i = 0; i < image_ir.files.length; i++) {
                        data.append("test_file1[]", document.getElementById('ir_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc1", '');

            }
            if (image_in != '') {
                if (image_in.files) {
                    for (var i = 0; i < image_in.files.length; i++) {
                        data.append("test_file2[]", document.getElementById('snr_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc2", '');

            }


        }
        else if (dc_required == 'on') {

            var po_num = document.getElementById('po_num').value;
            var po_unique_id = document.getElementById('po_unique_id').value;
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var po_date = document.getElementById('po_date').value;
            var invoice_auto_id = document.getElementById('invoice_auto_id').value;
            var invoice_no = document.getElementById('invoice_no').value;
            var invoice_date = document.getElementById('invoice_date').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var engineer_id = document.getElementById('engineer_id').value;
            var installation_com_date = document.getElementById('installation_com_date').value;
            var eng_remarks = document.getElementById('eng_remarks').value;
            var dc_received_sts = document.getElementById('dc_received_sts').value;
            var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
            var unique_id = document.getElementById('unique_id').value;

            var dc_file_data;
            element = document.getElementById('dc_file_data');
            if (element != null) {
                dc_file_data = element.value;
            }
            else {
                dc_file_data = null;
            }


            var dc_file_name;
            element1 = document.getElementById('dc_file_name');
            if (element1 != null) {
                dc_file_name = element1.value;
            }
            else {
                dc_file_name = null;
            }

            var documents_type = document.getElementById('documents_type');
            if (documents_type.checked) {
                var dc_checkbox = 'DC';
            } else {
                var dc_checkbox = '0';
            }


            var test_doc = document.getElementById('dc_file').value;

            var image_s = document.getElementById("dc_file");

            var data = new FormData();
            if (image_s != '') {
                if (image_s.files) {
                    for (var i = 0; i < image_s.files.length; i++) {
                        data.append("test_file[]", document.getElementById('dc_file').files[i]);
                    }
                }
            } else {

                data.append("test_doc", '');

            }


        }
        data.append("po_num", po_num);
        data.append("po_form_unique_id", po_form_unique_id);
        data.append("po_unique_id", po_unique_id);
        data.append("po_date", po_date);
        data.append("invoice_auto_id", invoice_auto_id);
        data.append("invoice_no", invoice_no);
        data.append("invoice_date", invoice_date);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("engineer_id", engineer_id);
        data.append("installation_com_date", installation_com_date);
        data.append("eng_remarks", eng_remarks);
        data.append("dc_required", dc_required);
        data.append("documents_type", dc_checkbox);
        data.append("documents_type1", ir_checkbox);
        data.append("documents_type2", snr_checkbox);
        data.append("dc_received_sts", dc_received_sts);
        data.append("dc_cus_signed_date", dc_cus_signed_date);
        data.append("ir_rec_status", ir_rec_status);
        data.append("ir_cus_signed_date", ir_cus_signed_date);
        data.append("snr_rec_status", snr_rec_status);
        data.append("snr_cus_signed_date", snr_cus_signed_date);
        data.append("dc_file_data", dc_file_data);
        data.append("dc_file_name", dc_file_name);
        data.append("snr_file_data", snr_file_data);
        data.append("snr_file_name", snr_file_name);
        data.append("action", "demo");



        $.ajax({
            type: "POST",
            url: "crud.php",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                try {

                    var jsonData = JSON.parse(response);
                    console.log("Parsed JSON:", jsonData);

                    // If the first CRUD operation is successful, call the second CRUD function
                    if (jsonData.status === true) {
                    }

                    else {
                        console.error("First CRUD failed:", jsonData.msg);
                    }

                    // Call the other function after successful response


                } catch (error) {

                }
            }

        });

    }
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
