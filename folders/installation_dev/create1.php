<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";
$action_type = "Create";
$unique_id          = "";
$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";
$is_active          = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        $dc_number = $_GET["dc_number"];
        $where      = [
            "consignee_unique_id" => $unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number,
        ];
        $table      =  "invoice_creation_main";
        $columns    = [
            "po_unique_id",
            //    "get_po_number(form_main_unique_id) as po_num",
            "po_num",
            "po_date",
             "(SELECT con_contact_name
        FROM consignee_details_sub
        WHERE consignee_details_sub.unique_id = $table.consignee_unique_id
        AND consignee_details_sub.is_delete = '0'
        GROUP BY consignee_details_sub.unique_id
    ) AS con_contact_name",
               "get_address(consignee_unique_id) AS con_address",
            "invoice_auto_id",
            "invoice_no",
            "(SELECT con_district
        FROM consignee_details_sub
        WHERE unique_id = $table.consignee_unique_id
        GROUP BY consignee_unique_id
    ) AS con_district",
            "invoice_date",

            "(SELECT dc_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id and dc_number = '" . $dc_number . "' AND is_delete=0 group by form_main_unique_id) AS dc_file",

            "(SELECT ir_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id and dc_number = '" . $dc_number . "' AND is_delete=0 group by form_main_unique_id) AS ir_file",
            "(SELECT snr_file FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id and dc_number = '" . $dc_number . "' AND is_delete=0 group by form_main_unique_id) AS snr_file",
            "DATE_FORMAT(installation_com_date,'%d-%m-%Y') AS installation_date",

            "form_main_unique_id",
            "consignee_unique_id",
            "(SELECT dc_required FROM installation_details WHERE po_form_unique_id  = " . $table . ".form_main_unique_id and dc_number = '" . $dc_number . "' AND is_delete=0 group by form_main_unique_id) AS dc_required",
            "dc_number",
            "dc_date",
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $installation_date = $result_values[0]['installation_date'];
            $po_unique_id          = $result_values[0]["po_num"];
            // . ' / ' . $result_values[0]["po_unique_id"]
            // $po_date    = $result_values[0]["po_date"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $con_district = $result_values[0]["con_district"];

            // . ' / ' . $result_values[0]["invoice_auto_id"]
            $dc_required         = $result_values[0]["dc_required"];
            $consignee_unique_id         = $result_values[0]["consignee_unique_id"];
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));
            $form_main_unique_id = $result_values[0]["form_main_unique_id"];

              $dc_file = $result_values[0]['dc_file'];
            $dc_file_name = image_view_dc_file("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['dc_file']);

            $ir_file = $result_values[0]['ir_file'];
            $ir_file_name = image_view_ir_file("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['ir_file']);

            $snr_file = $result_values[0]['snr_file'];
            $snr_file_name = image_view_ir_file("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['snr_file']);
            // // print_r($dc_file_name);

            $dc_number = $result_values[0]['dc_number'];
            $dc_date = $result_values[0]['dc_date'];

         $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
            $stmtCus->bindParam(':unique_id', $form_main_unique_id);
            $stmtCus->execute();
            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($customer_data)) {
                    $customerAddress    = $customer_data[0]["bill_address"];
                    $customerName  = $customer_data[0]["contact_name"];
                    $customerContact  = $customer_data[0]["contact_number"];
                    $customerLan         = $customer_data[0]["landline_number"];
                    $customerEmail = $customer_data[0]["email"];
                    $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                    $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                    $customrePincode      = $customer_data[0]["pin"];
                }

            $stmtCus->closeCursor();

            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
            $stmt->bindParam(':unique_id', $consignee_unique_id);
            $stmt->execute();

            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
                if (!empty($consignee_data)) {
                    $consigneeName    = $consignee_data[0]["con_contact_name"];
                    $consigneeContact  = $consignee_data[0]["con_contact_number"];
                    $consigneeLan  = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress         = $consignee_data[0]["con_address"];
                    $consigneeDistrict        = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeState      = con_state_name_stock($consignee_data[0]["con_state_name"]);
                    $consigneePincode      = $consignee_data[0]["con_pincode"];
                    $consigneeZone      = $consignee_data[0]["zone"];
                }
$stmt->closeCursor();



            if($result_values[0]["invoice_date"]==''){
                $invoice_date='';
            }
            else{
                $orgDate1 = $result_values[0]["invoice_date"];  
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }

            // $exp_under_user_type  = explode(",", $under_user_type);
            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}




// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$active_status_options   = active_status($is_active);
?>
<style>
       .table {
    --bs-table-head-bg: var(--bs-gray-100);
    --bs-table-head-color: var(--bs-secondary-color)
}
 .text-center th {
        text-align: center;
    }
.table thead th {
    background-color: var(--bs-table-head-bg);
    font-size: 15px;
    font-weight: 600;
    letter-spacing: .08em;
    color: var(--bs-table-head-color)
}

.table thead th,tbody th,tbody td {
    vertical-align: middle
}

.table td,.table th {
    border-top: var(--bs-border-width) solid var(--bs-table-border-color);
    border-bottom: 0
}

.table>:not(:first-child) {
    border-top: 0
}

.table-sm {
    font-size: .8125rem
}

.table-sm thead th {
    font-size: .625rem
}

.table-nowrap th,.table-nowrap td {
    white-space: nowrap
}

.table [data-sort] {
    white-space: nowrap
}

.table [data-sort]::after {
    content: url("data:image/svg+xml;utf8,<svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M3 0L6 4H0L3 0ZM3 10L0 6H6L3 10Z' fill='%2395AAC9'/></svg>");
    margin-left: .25rem
}

.table a[class*=text-reset]:hover {
    color: var(--bs-link-color) !important
}

[data-bs-theme=dark] .table {
    --bs-table-border-color: var(--bs-border-color);
    --bs-table-striped-bg: var(--bs-gray-900-dark);
    --bs-table-active-bg: var(--bs-gray-900-dark);
    --bs-table-hover-bg: var(--bs-gray-900-dark);
    --bs-table-head-bg: var(--bs-black)
}
.table thead th {
    background-color: var(--bs-table-head-bg);
    color: var(--bs-table-head-color);
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
}
.text-info {
    --vz-text-opacity: 1;
    color: rgb(80 96 24) !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Installation - DC & IR Document Dispatch Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Installation</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body mt-1">
                <form class="was-validated" autocomplete="off">
                    <div class="col-12">
                        
                    <div class="row">
                         <div class="col-md-3">
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details
                </h6>
                <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $customerName ?></strong></h6>
                <p class="mb-1"><?php echo ucwords($customerAddress) ?>, 
                    <?php echo ($customerDistrict) ?><br><?php echo ucwords($customerState) ?>
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

            <div class="col-md-3">
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Consignee Details
                </h6>

                <!-- Capitalize first letter of each word in contact name -->
                <h6 style="font-size: x-large; color: #506018;">
                    <strong><?php echo ucwords($consigneeName); ?></strong>
                </h6>

                <!-- Capitalize address and district -->
                <p class="mb-1">
                    <?php echo ucwords($consigneeAddress); ?>, <?php echo ucwords($consigneeDistrict); ?><br>
                    <?php echo $consigneeState; ?>
                </p>

                <!-- Contact number with fallback -->
                <p class="mb-1">
                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                    <?php echo !empty($consigneeContact) ? $consigneeContact : '--'; ?>
                </p>
            </div>
                            <div class="col-3">
        <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & Invoice Details</h6>
        <div class="row mb-1">
            <div class="col-5 text-body-secondary">PO Number</div>
            <div class="col-1">:</div>
            <div class="col-6"><?php echo $po_unique_id ?></div>
        </div>
        <div class="row mb-1">
            <div class="col-5 text-body-secondary">PO Date</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?></div>
        </div>
        <div class="row mb-1">
            <div class="col-5 text-body-secondary">DC No</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo $dc_number ?></div>
            <input type="hidden" name="dc_number" id="dc_number" value="<?php echo $dc_number; ?>">

        </div>
        <div class="row mb-1">
            <div class="col-5 text-body-secondary">DC Date</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
        </div>
        </div>
                           
                    <div class="col-3">
<div class="row mb-1">
             <div class="col-5 text-body-secondary"></div>
            <div class="col-1">&nbsp;</div>
            <div class="col-6 "></div>
        </div>
       
        <div class="row">
            <div class="col-5 text-body-secondary">Invoice No</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo $invoice_no ?></div>
        </div>
         <div class="row">
            <div class="col-5 text-body-secondary">Invoice Date</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo  date('d-m-Y', strtotime($invoice_date)) ?></div>
        </div>
         <div class="row">
            <div class="col-5 text-body-secondary">District</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo  $con_district ?></div>
        </div>
                                <?php if($installation_date){?>

         <div class="row">
            <div class="col-5 text-body-secondary">Installation com Date</div>
            <div class="col-1">:</div>
            <div class="col-6 "><?php echo  date('d-m-Y', strtotime($installation_date)) ?></div>
        </div>
                                <?php } ?>

    </div>
    </div><div class="row">
    <div class="col-12">
        <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #506018;">
            Attachment
        </h6>
        
        <div class="row">
            <div class="col-4">
                <div class="row mb-1">
                    <div class="col-5 text-body-secondary">DC Attachment</div>
                    <div class="col-1">:</div>
                    <div class="col-6"><?php echo $dc_file_name; ?></div>
                </div>
            </div>
            
            <div class="col-4">
                <div class="row mb-1">
                    <div class="col-5 text-body-secondary">IR Attachment</div>
                    <div class="col-1">:</div>
                    <div class="col-6"><?php echo $ir_file_name; ?></div>
                </div>
            </div>
            
            <div class="col-4">
                <div class="row mb-1">
                    <div class="col-5 text-body-secondary">SNR Attachment</div>
                    <div class="col-1">:</div>
                    <div class="col-6"><?php echo $snr_file_name; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

                    <br>
                    <div class="col-12 mt-2">
                                    <div class="table-responsive mb-4">
                                        <table
                                            class="table table-striped table-bordered align-middle  mb-0 small_table">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>S.No</th>
                                                    <!-- <th scope="col">Item Code</th> -->
                                                    <th scope="col">Item Details</th>
                                                    <th scope="col">Invoice QTY</th>
                                                    <th scope="col">Delivery Due Date</th>
                                                    <th scope="col">Installation Due Date</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                        $where1 = "po_unique_id = '" . $form_main_unique_id . "' and consignee_id = '" . $consignee_unique_id . "' and dc_num = '".$dc_number."' AND is_delete='0'";

                                                // $where1 = "po_unique_id = '" . $form_main_unique_id . "' and consignee_id = '" . $consignee_unique_id . "' AND is_delete='0'";
                                                // print_r($where1);
                                                $table1 = "invoice_creation";

                                                $columns1 = [
                                                    "item_code",
                                                    "product",
                                                    // "(SELECT sum(invoice_qty) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id = ".$table1.".form_main_unique_id ) AS invoice_qty",
                                                    "invoice_qty",
                                                    // "delivery_date",
                                                    // "(SELECT delivery_date FROM dispatch_list WHERE dispatch_list.po_form_unique_id = ".$table1.".po_unique_id ) AS delivery_date",
                                                    // "(SELECT DATE_FORMAT(delivery_date, '%d-%m-%Y') FROM dispatch_list WHERE dispatch_list.po_form_unique_id = " . $table1 . ".po_unique_id ) AS delivery_date",
                                                    // "(SELECT DATE_FORMAT(delivery_date, '%d-%m-%Y') FROM dispatch_list WHERE dispatch_list.po_form_unique_id = " . $table1 . ".po_unique_id ) AS delivery_date",
                                                   "(SELECT DATE_FORMAT(delivery_date, '%d-%m-%Y') 
                                                    FROM dispatch_list 
                                                    WHERE dispatch_list.po_form_unique_id = " . $table1 . ".po_unique_id 
                                                    LIMIT 1 ) AS delivery_date", 
                                                    "(select DATE_FORMAT(ld_installation_due_date,'%d-%m-%Y') from po_form where po_form.unique_id = invoice_creation.po_unique_id) as installation_due_date", 
                                                    "unique_id",
                                                    "po_unique_id"

                                                ];
                                                $table_details1 = [
                                                    $table1,
                                                    $columns1
                                                ];
                                             
                                                $values_product = $pdo->select($table_details1, $where1);
                                                // print_r($values_product);die();
                                                $j = 1;
                                                if ($values_product->status) {
                                                    $product_array = $values_product->data;
                                                    //   print_r($product_array);
                                                
                                                    $btn_update = btn_update($folder_name, $value['unique_id']);
                                                    foreach ($product_array as $key => $product) {
                                                        // $product['po_unique_id']='<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';
                                                
                                                        // $product['po_unique_id'] = $product['stock_qty']- $product['invoice_qty'];
                                                        //   $s_no = $sno + 1;
                                                        ?>

                                                                  <tr>
                                                       <td><?php echo $j; ?></td>

                                                                                                                     <td><strong><?php echo $product['item_code']; ?></strong><br><?php echo $product['product']; ?></td>

                                                                                                                    <td style="text-align: right;"><?php echo $product['invoice_qty'] ?></td>
                                                                                                                    <td><?php echo $product['delivery_date'] ?></td>
                                                                                                                    <td><?php echo $product['installation_due_date'] ?></td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                                $j++;
                                                    }
                                                }
                                                // }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    <?php
                    // $where      = [
                    //     "consignee_unique_id" => $unique_id
                    // ];
                    // and dc_number ='".$dc_number."'
                    // and dc_number='".$dc_number."'
                    $where      = "consignee_unique_id='".$unique_id."' and dc_number='".$dc_number."'  and invoice_no='".$invoice_no."' AND is_delete=0";

                    $table_sub_dc      =  "dc_ir_doc_dispatch_details";
                    $columns    = [
                        "po_form_unique_id",
                        "dc_dispatch_mode",
                        "dc_pod_no",
                        "dc_pod_date",
                        "ir_dispatch_mode",
                        "ir_pod_no",
                        "ir_pod_date",
                        "name_of_courier",
                        "ins_name_of_courier",
                        "snr_dispatch_mode",
                        "snr_pod_no",
                        "snr_pod_date",
                        "snr_name_courier",
                        "unique_id",
                    ];
                    $table_details   = [
                        $table_sub_dc,
                        $columns
                    ];
                    $result_values_data  = $pdo->select($table_details, $where);
                    // print_r($result_values_data);
                    if ($result_values_data->status) {
                        $result_values_data      = $result_values_data->data;
                        $dc_dispatch_mode    = $result_values_data[0]["dc_dispatch_mode"];
                        $name_of_courier = $result_values_data[0]["name_of_courier"];
                        $dc_pod_no          = $result_values_data[0]["dc_pod_no"];
                        $dc_pod_date          = $result_values_data[0]["dc_pod_date"];
                        $ir_dispatch_mode          = $result_values_data[0]["ir_dispatch_mode"];
                        $ins_name_of_courier = $result_values_data[0]["ins_name_of_courier"];
                        $ir_pod_no          = $result_values_data[0]["ir_pod_no"];
                        $ir_pod_date         = $result_values_data[0]["ir_pod_date"];
                        $snr_dispatch_mode          = $result_values_data[0]["snr_dispatch_mode"];
                        $snr_pod_no          = $result_values_data[0]["snr_pod_no"];
                        $snr_pod_date          = $result_values_data[0]["snr_pod_date"];
                        $snr_name_courier = $result_values_data[0]["snr_name_courier"];
                        $unique_id         = $result_values_data[0]["unique_id"];
                        // $exp_under_user_type  = explode(",", $under_user_type);
                        $btn_text           = "Update";
                        $btn_action         = "update";
                    } else {
                        $btn_text           = "Error";
                        $btn_action         = "error";
                        $is_btn_disable     = "disabled='disabled'";
                    }
                    $dc_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                         [
                            "id"    => 'Soft Copy',
                            "text"  => "Soft Copy"
                        ],
                    ];
                    $dc_dispatch_mode_options    = select_option($dc_dispatch_mode_options, "Select Dispatch Mode", $dc_dispatch_mode);
                    $ir_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                        [
                            "id"    => 'Soft Copy',
                            "text"  => "Soft Copy"
                        ],
                    ];
                    $ir_dispatch_mode_options    = select_option($ir_dispatch_mode_options, "Select Ir Dispatch Mode", $ir_dispatch_mode);
                    $snr_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                        [
                            "id"    => 'Soft Copy',
                            "text"  => "Soft Copy"
                        ],
                    ];
                    $snr_dispatch_mode_options    = select_option($snr_dispatch_mode_options, "Select Snr Dispatch Mode", $snr_dispatch_mode);
                    ?>
                    <?php 
                    //  $where      = [
                    //     "consignee_unique_id" => $unique_id
                    // ];
                    $where_1      = "consignee_unique_id='$consignee_unique_id' AND dc_number = '$dc_number' and invoice_no='$invoice_no' AND is_delete=0";
                    // AND invoice_no='$invoice_no'

                    $table_ins_det      =  "installation_details";
                    $columns_1    = [
                        "documents_type",
                        "documents_type1",
                        "documents_type2",
                        "without_snr",

                       
                    ];
                    $table_details_1   = [
                        $table_ins_det,
                        $columns_1
                    ];
                    $result_values_data_sts  = $pdo->select($table_details_1, $where_1);
                    // print_R($result_values_data_sts);
                    if ($result_values_data_sts->status) {
                        $result_values_data_status      = $result_values_data_sts->data;
                        $dc_sts    = $result_values_data_status[0]["documents_type"];
                        $ir_sts = $result_values_data_status[0]["documents_type1"];
                        $snr_sts = $result_values_data_status[0]["documents_type2"];
                        $without_snr = $result_values_data_status[0]["without_snr"];
                       
                       
                        // $exp_under_user_type  = explode(",", $under_user_type);
                        $btn_text           = "Update";
                        $btn_action         = "update";
                    } else {
                        $btn_text           = "Error";
                        $btn_action         = "error";
                        $is_btn_disable     = "disabled='disabled'";
                    }
                    ?>
                    <div class="row">
                    <input type="hidden" id="dc_sts" name="dc_sts" class="form-control" value="<?php if($dc_sts!=''){ echo $dc_sts; }else{echo '';
                        }?>" required>
                    <input type="hidden" id="ir_sts" name="ir_sts" class="form-control"  value="<?php if($ir_sts!=''){ echo $ir_sts;} else{echo '';
                        } ?>" required>
                    <input type="hidden" id="snr_sts" name="snr_sts" class="form-control"  value="<?php if($snr_sts!=''){ echo $snr_sts; }else{echo '';
                        } ?>"required>
                                        

                        <div class="col-12 mt-3">

                            <!--  new changes skip to snr-->
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <div class="form-group form-check  mt-3">
                                         <?php
                                            if ($snr_sts == 'SNR' && $ir_sts == 'IR') { ?>
                                            <input  style="border-color: #506018; " type="checkbox" class="form-check-input" id="without_snr" name="without_snr" onclick="shows3()" <?php if ($without_snr == 'on') echo 'checked disabled'; ?> >
                                            <!-- <?php //if// ($without_snr == 'on') echo 'checked disabled'; ?> -->

                                                <label class="form-check-label" style="font-weight: bold; font-size: 20px; color: #506018;">
                                                Processed Skip Snr
                                                    </label>
                                                <?php } ?>
                                    </div>
                                           
                                </div>
                            </div>                               
                            <!-- new end  -->
                          <?php if($dc_sts==''){ ?>
                           
                            <div class="table-responsive mb-4" id="dc_option" style="display:none;">
                                <h4 class="text-info">Delivery Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">DC Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="dc_pod_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td>
                                                <select class="form-select mb-3" id="dc_dispatch_mode" name="dc_dispatch_mode" onchange="shows()">
                                                   
                                                    <?php echo $dc_dispatch_mode_options ?>
                                                </select>
                                            </td>
                                            <td><input type="text" id="name_of_courier" name="name_of_courier" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $name_of_courier ?>"></td>
                                            <td id="dc_pod_tab1">
                                                <input type="text" id="dc_pod_no" name="dc_pod_no" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $dc_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="dc_pod_date" name="dc_pod_date" class="form-control" value="<?php echo $dc_pod_date ?>" max="<?=date('Y-m-d');?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else if($dc_sts!=''){?>
                                <div class="table-responsive mb-4" id="dc_option" style="display:none;">
                                <h4 class="text-info">Delivery Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">DC Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="dc_pod_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td>
                                                <select class="form-select mb-3" id="dc_dispatch_mode" name="dc_dispatch_mode" onchange="shows()">
                                                
                                                    <?php echo $dc_dispatch_mode_options ?>
                                                </select>
                                            </td>
                                            <td><input type="text" id="name_of_courier" name="name_of_courier" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $name_of_courier ?>"></td>
                                            <td id="dc_pod_tab1">
                                                <input type="text" id="dc_pod_no" name="dc_pod_no" class="form-control" oninput="filterAlphabetInput(this)" value="<?php echo $dc_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="dc_pod_date" name="dc_pod_date" class="form-control" value="<?php echo $dc_pod_date ?>" max="<?=date('Y-m-d');?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                             <?php } if($ir_sts!=''){?>

                        
                            <div class="table-responsive mb-4" id="ir_option" style="display:none;">
                                <h4 class="text-info">Installation Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">IR Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="ir_pdo_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td><select class="form-select mb-3" id="ir_dispatch_mode" name="ir_dispatch_mode" onchange="shows1()">
                                                    <?php echo $ir_dispatch_mode_options ?>
                                                
                                                </select>
                                            </td>
                                            <td><input type="text" id="ins_name_of_courier" oninput="filterAlphabetInput(this)" name="ins_name_of_courier" class="form-control" value="<?php echo $ins_name_of_courier ?>"></td>
                                            <td id="ir_pdo_tab1">
                                                <input type="text" id="ir_pod_no" name="ir_pod_no" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $ir_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="ir_pod_date" name="ir_pod_date" class="form-control" value="<?php echo $ir_pod_date ?>" max="<?=date('Y-m-d');?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                            <?php } else if($ir_sts==''){?>

                                <div class="table-responsive mb-4" id="ir_option" style="display:none;">
                                <h4 class="text-info">Installation Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">IR Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="ir_pdo_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td><select class="form-select mb-3" id="ir_dispatch_mode" name="ir_dispatch_mode" onchange="shows1()">
                                                    <?php echo $ir_dispatch_mode_options ?>
                                                    <!--<option value="">Select Option</option>-->
                                                    <!--<option>Hand Delivery</option>-->
                                                    <!--<option>Courier</option>-->
                                                    <!--<option>Transporter</option>-->
                                                </select>
                                            </td>
                                            <td><input type="text" id="ins_name_of_courier" name="ins_name_of_courier" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $ins_name_of_courier ?>"></td>
                                            <td id="ir_pdo_tab1">
                                                <input type="text" id="ir_pod_no" name="ir_pod_no" class="form-control" oninput="filterAlphabetInput(this)" value="<?php echo $ir_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="ir_pod_date" name="ir_pod_date" class="form-control" value="<?php echo $ir_pod_date ?>" max="<?=date('Y-m-d');?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>

                            <?php }if($snr_sts!=''){?>
                               
                            <!-- SNR FILE -->
                            <div class="table-responsive mb-4" id="snr_option" style="display:none;">
								<h4 class="text-info">Signed Document</h4>
								<table class="table table-striped table-bordered align-middle mb-0 small_table">
									<thead class="table-light">
										<tr>
											<!--<th>S.No</th>-->
											<th scope="col">Snr Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
											<th scope="col" id="snr_pdo_tab">POD No.</th>
											<th scope="col">POD Date</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<!--<td>1</td>-->
											<td><select class="form-select mb-3" id="snr_dispatch_mode" name="snr_dispatch_mode" onchange="shows2()">
											    <?php echo $snr_dispatch_mode_options?>
													
												</select>
												</td>
                                                <td><input type="text" id="snr_name_courier" name="snr_name_courier" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $snr_name_courier?>"></td>
											<td id="snr_pdo_tab1">
												<input type="text" id="snr_pod_no" name="snr_pod_no" oninput="filterAlphabetInput(this)" class="form-control" value="<?php echo $snr_pod_no?>"  >
											</td>
											<td> <input type="date" id="snr_pod_date" name="snr_pod_date" class="form-control" value="<?php echo $snr_pod_date?>" max="<?=date('Y-m-d');?>" ></td>
										</tr>
									</tbody>
								</table>
								
							</div>
                            <?PHP } else if($snr_sts==''){?>
                                <div class="table-responsive mb-4" id="snr_option" style="display:none;">
								<h4 class="text-info">Signed Document</h4>
								<table class="table table-striped table-bordered align-middle mb-0 small_table">
									<thead class="table-light">
										<tr>
											<!--<th>S.No</th>-->
											<th scope="col">Snr Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
											<th scope="col" id="snr_pdo_tab">POD No.</th>
											<th scope="col">POD Date</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<!--<td>1</td>-->
											<td><select class="form-select mb-3" id="snr_dispatch_mode" name="snr_dispatch_mode" onchange="shows2()">
											    <?php echo $snr_dispatch_mode_options?>
													
												</select>
												</td>
                                                <td><input type="text" id="snr_name_courier" oninput="filterAlphabetInput(this)" name="snr_name_courier" class="form-control" value="<?php echo $snr_name_courier?>"></td>
											<td id="snr_pdo_tab1">
												<input type="text" id="snr_pod_no" oninput="filterAlphabetInput(this)" name="snr_pod_no" class="form-control" value="<?php echo $snr_pod_no?>"  >
											</td>
											<td> <input type="date" id="snr_pod_date" oninput="filterAlphabetInput(this)" name="snr_pod_date" class="form-control" value="<?php echo $snr_pod_date?>"  max="<?=date('Y-m-d');?>"></td>
										</tr>
									</tbody>
								</table>
								
							</div>
                                <?php }?>
                            <input class="form-control" type="hidden" id="unique_id" name="unique_id" value="<?php echo $result_values_data[0]["unique_id"]?>">
								<input class="form-control" type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $result_values[0]["po_unique_id"]?>">
                                <input class="form-control" type="hidden" id="po_num" name="po_num" value="<?php echo $result_values[0]["po_num"]?>">
                                <input class="form-control" type="hidden" id="po_date" name="po_date" value="<?php echo $result_values[0]["po_date"]?>">
                                    <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id" value="<?php echo $result_values[0]["invoice_auto_id"]?>">
                                    <input class="form-control" type="hidden" id="invoice_no" name="invoice_no" value="<?php echo $result_values[0]["invoice_no"]?>">
                                    <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" value="<?php echo $result_values[0]["invoice_date"]?>">
                                    <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id" value="<?php echo $result_values[0]["consignee_unique_id"]?>">
                                    <input class="form-control" type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php echo $result_values[0]["form_main_unique_id"]?>">
                                    <input class="form-control" type="hidden" id="dc_required" name="dc_required" value="<?php echo $result_values[0]["dc_required"]?>">
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <a href="index.php?file=installation/list"><button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                    </a>
                                    <?php if ($unique_id) { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="dispatch_save()">Update</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="dispatch_save()">Save</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div> <!-- end card -->
        </div><!-- end col -->
    </div>
</div>
<script>
    $(document).ready(function () {
        shows();
        shows1();
        shows2();
        status();
        shows3();

});

function status(){
var dc_sts = document.getElementById('dc_sts').value;
	// alert(dc_sts);
var ir_sts = document.getElementById('ir_sts').value;
	// alert(ir_sts);
var snr_sts = document.getElementById('snr_sts').value; 
// alert(snr_sts);
if(dc_sts=='DC') {
    // alert();
    $('#dc_option').show();
    $('#ir_option').hide();
    $('#snr_option').hide();
    // $('#dc_option1').show();
    // $('#dc_option2').show();
    // $('#dc_option3').show();

} 
 if (dc_sts === 'DC' && ir_sts === 'IR') {
        $('#dc_option').show();
        $('#ir_option').show();
        $('#snr_option').hide();
    }
 if (dc_sts === 'DC' && snr_sts === 'SNR' ) {
        $('#snr_option').show();
        $('#ir_option').hide();
        $('#dc_option').show();
    } 
    if (dc_sts === 'DC' && snr_sts === 'SNR' && ir_sts === 'IR') {
        $('#snr_option').show();
        $('#ir_option').show();
        $('#dc_option').show();
    } 
// else if(ir_sts=='IR') {
//     // alert('fdgfd');
//     $('#ir_option').show();
//     $('#dc_option').hide();
//     $('#snr_option').hide();
// } 

// else if(snr_sts=='SNR') {
//     alert(hello);
//     $('#snr_option').show();
//     $('#ir_option').hide();
//     $('#dc_option').hide();
//     // $('#snr_option').show();
    
// } 
}
    
function shows(){
        var mode_of_delivery = document.getElementById('dc_dispatch_mode').value;
        // alert();
        if(mode_of_delivery == 'Hand Delivery'){
            $('#dc_pod_tab').hide();
            $('#dc_pod_tab1').hide();
        }
         else if(mode_of_delivery == 'Soft Copy'){
            $('#dc_pod_tab').hide();
            $('#dc_pod_tab1').hide();
        }
        else{
            $('#dc_pod_tab').show();
            $('#dc_pod_tab1').show();
        }
        
       
    }
    
    function shows1(){
        var mode_of_delivery1 = document.getElementById('ir_dispatch_mode').value;
        // alert();
        if(mode_of_delivery1 == 'Hand Delivery'){
            $('#ir_pdo_tab').hide();
            $('#ir_pdo_tab1').hide();
        }
        else if(mode_of_delivery1 == 'Soft Copy'){
            $('#ir_pdo_tab').hide();
            $('#ir_pdo_tab1').hide();
        }
        
        else{
            $('#ir_pdo_tab').show();
            $('#ir_pdo_tab1').show();
        }
       
    }

    function shows2(){
        var mode_of_delivery2 = document.getElementById('snr_dispatch_mode').value;
        // alert();
        if(mode_of_delivery2 == 'Hand Delivery'){
            $('#snr_pdo_tab').hide();
            $('#snr_pdo_tab1').hide();
        }
         else if(mode_of_delivery2 == 'Soft Copy'){
            $('#snr_pdo_tab').hide();
            $('#snr_pdo_tab1').hide();
        }

        else{
            $('#snr_pdo_tab').show();
            $('#snr_pdo_tab1').show();
        }
        // if(mode_of_delivery == 'Soft Copy'){
        //     $('#snr_pdo_tab').hide();
        //     $('#snr_pdo_tab1').hide();
        // }else{
        //     $('#snr_pdo_tab').show();
        //     $('#snr_pdo_tab1').show();
        // }
    }
// new changes 
function shows3() {
    var without_snr = document.getElementById('without_snr').checked;
    // var snr_sts = document.getElementById('snr_sts').value; 
    var ir_sts = document.getElementById('ir_sts').value;
    // alert(without_snr);
    if (without_snr && ir_sts) {
        $('#snr_option').hide();  // Hide the SNR option if the checkbox is checked
    } 
    else {
        $('#snr_option').show();  // Show the SNR option if the checkbox is unchecked or other conditions fail
    }
}
    function dispatch_save() {
        // alert('hi');
        var internet_status = is_online();
        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        var dc_number = document.getElementById('dc_number').value;
        var unique_id = document.getElementById('unique_id').value;
        var po_form_unique_id = document.getElementById('form_main_unique_id').value;
        var po_num = document.getElementById('po_num').value;
        var po_auto_id = document.getElementById('po_unique_id').value;
        var po_date = document.getElementById('po_date').value;
        var consignee_id = document.getElementById('consignee_unique_id').value;
        var invoice_auto_id = document.getElementById('invoice_auto_id').value;
        var invoice_no = document.getElementById('invoice_no').value;
        var invoice_date = document.getElementById('invoice_date').value;
        var dc_required = document.getElementById('dc_required').value;

        //  alert(dc_required);
        
    var dc_sts = document.getElementById('dc_sts').value;
	// alert(dc_sts);
	var ir_sts = document.getElementById('ir_sts').value;
	// alert(ir_sts);
	var snr_sts = document.getElementById('snr_sts').value;   
    
        // new change

        var without_snr = 'off'; // Default to 'off'
            
        if (document.getElementById("without_snr")) {
            if (document.getElementById("without_snr").checked) {
                without_snr = 'on';
            }
        }
        

    if(dc_sts == "DC"){
        var dc_dispatch_mode = document.getElementById('dc_dispatch_mode').value;
        //  alert(dc_dispatch_mode);
        var name_of_courier = document.getElementById('name_of_courier').value;
        var dc_pod_no = document.getElementById('dc_pod_no').value;
        var dc_pod_date = document.getElementById('dc_pod_date').value;
	}
    else{
        var dc_dispatch_mode = '';
        var name_of_courier = '';
        var dc_pod_no = '';
        var dc_pod_date = '';
    }
	if(ir_sts == "IR"){
        var ir_dispatch_mode = document.getElementById('ir_dispatch_mode').value;
        var ins_name_of_courier = document.getElementById('ins_name_of_courier').value;
        var ir_pod_no = document.getElementById('ir_pod_no').value;
        var ir_pod_date = document.getElementById('ir_pod_date').value;
	}
    else{
        var ir_dispatch_mode = '';
        var ins_name_of_courier = '';
        var ir_pod_no = '';
        var ir_pod_date = '';

    }
	if(snr_sts == "SNR"){
        var snr_dispatch_mode = document.getElementById('snr_dispatch_mode').value;
        var snr_name_courier = document.getElementById('snr_name_courier').value;
        var snr_pod_no = document.getElementById('snr_pod_no').value;
        var snr_pod_date = document.getElementById('snr_pod_date').value;
	}
    else{
        var snr_dispatch_mode = '';
        var snr_name_courier = '';
        var snr_pod_no = '';
        var snr_pod_date = '';
    }
        if (dc_dispatch_mode && dc_pod_date || ir_dispatch_mode && ir_pod_date || snr_dispatch_mode && snr_pod_date) {
            var is_form = form_validity_check("was-validated");
            var data = new FormData();
            data.append("unique_id", unique_id);
            data.append("po_form_unique_id", po_form_unique_id);
            data.append("po_num", po_num);
            data.append("po_auto_id", po_auto_id);
            data.append("po_date", po_date);
            data.append("consignee_id", consignee_id);
            data.append("invoice_auto_id", invoice_auto_id);
            data.append("invoice_no", invoice_no);
            data.append("invoice_date", invoice_date);
            data.append("dc_dispatch_mode", dc_dispatch_mode);
            data.append("name_of_courier", name_of_courier);
            data.append("dc_number", dc_number);
            data.append("dc_pod_no", dc_pod_no);
            data.append("dc_pod_date", dc_pod_date);
            data.append("ir_dispatch_mode", ir_dispatch_mode);
            data.append("ins_name_of_courier", ins_name_of_courier);
            data.append("ir_pod_no", ir_pod_no);
            data.append("ir_pod_date", ir_pod_date);
            data.append("snr_dispatch_mode", snr_dispatch_mode);
            data.append("snr_name_courier", snr_name_courier);
            data.append("snr_pod_no", snr_pod_no);
            data.append("snr_pod_date", snr_pod_date);
            data.append("dc_required", dc_required);
            data.append("without_snr", without_snr);
            
            data.append("action", "dc_ir_add_update");
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
                beforeSend: function() {
                    // 	$(".createupdate_btn").attr("disabled","disabled");
                    // 	$(".createupdate_btn").text("Loading...");
                },
                success: function(data) {
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
                error: function(data) {
                    alert("Network Error");
                }
            });
        } else {
            sweetalert("form_alert");
        }
    }

    function print_pdf_dc(file_name) {

onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
function print_pdf_ir(file_name) {

onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
function print_pdf_snr(file_name) {

onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
</script>
<?php 
    function image_view_dc_file($folder_name = "", $unique_id = "", $dc_file = "")
    {
        // echo $dc_file_name;
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
                        $image_view_dc_file .= '<a href="javascript:print_view_dc(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                        // $image_view_dc_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                    } else if ($cfile_name[1] == 'pdf') {
                        $image_view_dc_file .= '<a href="javascript:print_pdf_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
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
        // echo $dc_file_name;
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
                        $image_view_ir_file .= '<a href="javascript:print_view_dc(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                        // $image_view_ir_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                    } else if ($cfile_name[1] == 'pdf') {
                        $image_view_ir_file .= '<a href="javascript:print_pdf_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
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
        // echo $dc_file_name;
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
                        $image_view_snr_file .= '<a href="javascript:print_view_dc(\'/' . $snr_file . '\')"><img src="uploads/' . $folder_name . '/' . $snr_file . '"  height="30px" width="30px" ></a>';
                        // $image_view_snr_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                    } else if ($cfile_name[1] == 'pdf') {
                        $image_view_snr_file .= '<a href="javascript:print_pdf_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
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

