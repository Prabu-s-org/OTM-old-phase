<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

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
// echo "hi";die();
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // echo "hi";die();

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id_1  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        // $ins_unique_id  = $_GET["ins_unique_id"];
        // $dc_number  = $_GET["dc_number"];


        // $where ="consignee_unique_id='".$unique_id_1."' AND invoice_no ='".$invoice_no."'";
        // print_r($where);
        $where ="unique_id='".$unique_id_1."' AND invoice_no ='".$invoice_no."'";

        // print_r(   $where );die();
        // and ins_unique_id ='".$ins_unique_id."'and dc_number ='".$dc_number."
        // $table      =  "view_bill_submission_list_pending_1";
         $table      =  "view_otm_bill_pending_list";
        

        $columns    = [
            "get_po_number(unique_id) as po_num",
            "po_date",
            // "con_contact_name",
            // "con_address",
            "invoice_no",
            "invoice_date",
            "sum(invoice_value) AS invoice_value",
            "sum(invoice_qty) as invoice_qty",
            // "file_name",
            // "consignee_unique_id",
            "unique_id",
            "(SELECT file_name FROM po_form WHERE po_form.unique_id = {$table}.unique_id) AS file_name",
            // "ins_unique_id",
            // "ir_status",
            // "snr_status",
            // "bill_reject_reason",
            // "payment_cancel_reason",
            // "dc_number",
            // "dc_date"
             "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.po_num = $table.po_num 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",
  "(SELECT ledger_name 
 FROM invoice_creation_main 
 WHERE invoice_creation_main.po_num = $table.po_num 
 AND invoice_creation_main.is_delete = 0 
 LIMIT 1
) AS cutomername",
        ];

        $table_details   = [
            $table,
            $columns
        ];
        // $where      = [
        //     "consignee_unique_id" => $unique_id_1,
        //     "invoice_no" => $invoice_no,
        // ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
             $po_date          = $result_values[0]["po_date"];
            $invoice_date    = $result_values[0]["invoice_date"];
            $cutomername    = $result_values[0]["cutomername"];
            $ledger_name    = $result_values[0]["ledger_name"];
            
            // $con_contact_name          = $result_values[0]["con_contact_name"];
            // $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            // $ins_unique_id           = $result_values[0]["ins_unique_id"];
            $invoice_value_amt       = moneyFormatIndia1($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt ;
            $file_name    = $result_values[0]["file_name"];
            // $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
            $invoice_qty                = $result_values[0]["invoice_qty"];
            $form_main_unique_id          = $result_values[0]["unique_id"];
            // $bill_reject_reason                = $result_values[0]["bill_reject_reason"];
            // $payment_cancel_reason          = $result_values[0]["payment_cancel_reason"];
            // $dc_number          = $result_values[0]["dc_number"];
            // $dc_date          = $result_values[0]["dc_date"];
            
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));

            $orgDate1 = $result_values[0]["invoice_date"];  
            $invoice_date = date("d-m-Y", strtotime($orgDate1));

            $file_name_po = image_view("po_form", $result_values[0]['invoice_no'], $result_values[0]['file_name']);


            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

$stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
            $stmtCus->bindParam(':unique_id', $unique_id_1);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($customer_data)) {
                    $customerAddress    = $customer_data[0]["bill_address"];
                    $customerDept    = department_name($customer_data[0]["department"]);
                    $customerName  = $customer_data[0]["contact_name"];
                    $customerContact  = $customer_data[0]["contact_number"];
                    $customerLan         = $customer_data[0]["landline_number"];
                    $customerEmail = $customer_data[0]["email"];
                    $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                    $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                    $customrePincode      = $customer_data[0]["pin"];
                }

$stmtCus->closeCursor();






// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);

?>
<style>
    .table {
    --bs-table-head-bg: var(--bs-gray-100);
    --bs-table-head-color: var(--bs-secondary-color)
}

.table thead th {
    background-color: var(--bs-table-head-bg);
    text-transform: uppercase;
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
    text-transform: uppercase;}
</style>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Bill Creation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> Bill Creation</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<style>

.table>:not(caption)>*>* {
    padding:5px 10px !important;
    font-size: 13px;
}
.table>thead {
    background-color: #eeece0 !important;
    color: #506018 !important;
}
.white_text { color: #506018 !important;}
.white_text::after{ color: #fff; opacity: 0.5 !important;}
.border-top {
    border-top:  #506018 1px solid !important;
}
.table>:not(caption)>*>* {    padding: 1rem;}
.table_tr_bg{ background-color: #f9fbf0;}
.form-label {    margin-bottom: .3rem; font-size: 15px; }
p{font-size: 15px;}
.text_style{font-size: 15px;    color: #000;    font-weight: 500;}
.text_style_one{font-size: 18px;    color:  #506018;font-weight: 700;}
</style>

<div class="row ">
          <div class="col-12 col-lg-12 col-xl-12 mt-4">


            <!-- Content -->
            <div class="card card-body p-5">
              <div class="row">
                <div class="col text-end">

                

                </div>
              </div> <!-- / .row -->
              
              <div class="row">
                  <!-- Heading -->
                  
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase text-body-primary" style="font-size:large; color:#9aa965;">
                    Customer Details
                  </h6>
                

                  <!-- Text -->
                    <h6 class=" text-body-primary" style="font-size: 20px; color:#506018 !important;"> <strong> <?=$customerDept;?> </strong></h6>
                  <p class="text-body-primary mb-3">  <?=$customerAddress .','. $customerDistrict .','. $customerState ;?> </br><?=$customrePincode;?> </p>

                
                  <!-- Text -->
                  <p class=""><span><i data-feather="phone" style="width:15px; height:15px; color:#506018 "></i></span>
                    <?=$customerLan;?>
                  </p>
                <!-- Text -->
                  <p class="mb-4"><span><i data-feather="mail" style="width:15px; height:15px;color:#506018"></i></span>
                    <?=$customerEmail;?>
                  </p>

                </div>

                <div class="col-12 col-md-4"></div> 

                <div class="col-12 col-md-4">
                    
                     <h6 class="text-uppercase text-body-primary" style="font-size:large; color:#9aa965;">
                    PO & Invoice Details
                  </h6>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">PO Number</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $po_num ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">PO Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $po_date ?></div>
                    </div>
                   
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Invoice No</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $invoice_no ?></div>
                        <input type="hidden" name="my_inv_no" id="my_inv_no" value="<?php echo $invoice_no ?>">
                    </div>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Invoice Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $invoice_date ?></div>
                    </div>
                    

                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label" style="color: black; font-weight: 500;">Invoice Qty</label></div>
                        <div class="col-xl-1">:</div>
                        <!-- <div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div> -->
                        <div class="col-xl-7 text_style_one"><?php echo $invoice_qty ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label" style="color: black; font-weight: 500;">Invoice Value</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style_one"> ₹ <?php echo $invoice_value ?></div>
                    </div>
                    <?php if($bill_status=='3'){?>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Bill Reject Reason</label></div>
                        <div class="col-xl-1">:</div>
                        <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                        <div class="col-xl-7 text_style"><?php echo $bill_reject_reason ?></div>
                    </div>

                    <?php } else if($bill_status=='4'){?>
                    <div class="row">
                        <div class="col-xl-4 "> <label for="main_screen" class="form-label">Payment Reject Reason</label></div>
                        <div class="col-xl-1">:</div>
                        <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                        <div class="col-xl-7 text_style"><?php echo $payment_cancel_reason ?></div>
                    </div>
                    <?php } ?>
                </div>

              </div> <!-- / .row -->





              <div class="row">
                <div class="col-12">

                  <!-- Table -->

                 <div class="table-responsive" data-list='{"valueNames": ["tables-row", "tables-first", "tables-last", "tables-handle"]}'>
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-row">#</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-last">DC Date</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-first">DC No</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-handle">Consignee Address</a>
                            </th>
                            <th scope="col" class="text-md-end">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-handle">Qty</a>
                            </th>
                            <th scope="col" class="text-md-end">
                            <a href="#" class="text-body-secondary list-sort white_text " data-sort="tables-handle"> Value</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">

                        <?php

                        $unique_id  = $_GET["unique_id"];
                        $invoice_no  = $_GET["invoice_no"];
                                   
                                    $where1 = "po_unique_id = '$unique_id' and invoice_no = '" . $invoice_no . "' AND  is_delete='0'";
                                    // print_r($where1); die();
                                    $table1 = "invoice_creation";
                                    $columns1 = [
                                        
                                        "dc_num",
                                        "dc_date",
                                        "consignee_id",
                                        "invoice_qty",
                                        "invoice_qty_value",
                                        "unique_id",
                                        "po_unique_id"

                                    ];
                                    $table_details1 = [
                                        $table1,
                                        $columns1
                                    ];
                                    $values_product = $pdo->select($table_details1, $where1);
                                    
                                    $j = 1;
                                    if ($values_product->status) {
                                        $product_array = $values_product->data;
                                        //   print_r($product_array);
                                    
                                        $btn_update = btn_update($folder_name, $value['unique_id']);
                                        foreach ($product_array as $key => $product) {
                                            
                                             $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                                            $stmt->bindParam(':unique_id', $product['consignee_id']);
                                            $stmt->execute();

                                            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                                if (!empty($consignee_data)) {
                                                    $consigneeName    = $consignee_data[0]["con_contact_name"];
                                                    $consigneeAddress         = $consignee_data[0]["con_address"];
                                                    $consigneeDistrict        = district_name_stock($consignee_data[0]["con_district"]);
                                                    $consigneeState      = con_state_name_stock($consignee_data[0]["con_state_name"]);
                                                    $consigneePincode      = $consignee_data[0]["con_pincode"];

                                                }
                                            $stmt->closeCursor();
                                            
                                           
                                            ?>

                                            <tr>
                                                <td><?php echo $j; ?></td>
                                                <td><?php echo disdate($product['dc_date']); ?></td>
                                                <td><?php echo $product['dc_num'] ?></td>
                                                <td><?php echo '<strong>'.disname($consigneeName) .'</strong><br>'.  $consigneeAddress .','. $consigneeDistrict .','. $consigneeState .','. $consigneePincode ; ?></td>
                                                <td style="text-align: right"><?php echo $product['invoice_qty'] ?></td>
                                                <!-- <td><?php echo $product['invoice_value'] ?></td> -->
                                                <td style="text-align: right"><?php echo '<strong>'.moneyFormatIndia($product['invoice_qty_value']).'</strong>' ; ?></td>

                                            </tr>
                                            <?php
                                            $j++;
                                            $tot_invoice_val += $product['invoice_qty_value'];
                                        }
                                    }
                                    // }
                                    ?>
                        <!-- <tr>
                            <th scope="row" class="tables-row">1</th>
                            <td class="tables-first">Mark</td>
                            <td class="tables-last">Otto</td>
                            <td class="tables-handle">@mdo</td>
                            <td class="tables-handle">1</td>
                            <td class="tables-handle text-md-end">₹ 1000</td>
                            
                        </tr>
                        <tr class="table_tr_bg">
                            <th scope="row" class="tables-row">2</th>
                            <td class="tables-first">Jacob</td>
                            <td class="tables-last">Thornton</td>
                            <td class="tables-handle">@fat</td>
                            <td class="tables-handle">4</td>
                            <td class="tables-handle text-md-end">₹ 4000</td>
                        </tr>
                        <tr>
                            <th scope="row" class="tables-row">3</th>
                            <td class="tables-first">Larry</td>
                            <td class="tables-last">the Bird</td>
                            <td class="tables-handle">@twitter</td>
                            <td class="tables-handle">2</td>
                            <td class="tables-handle text-md-end">₹ 2000</td>
                        </tr> -->




                        <tr class="border-top border-top-2">

                            <th scope="row" class="tables-row"></th>
                            <td class="tables-handle"></td>
                            <td class="tables-handle"></td>
                            <td class="tables-handle"></td>
                          <td class="px-0 " style=" font-size:14px">
                            <strong>Total Amount </strong>
                          </td>
                          <td colspan="2" class="px-0 text-end ">
                            <span class="h3 text_style_one"> ₹
                              <?php echo '<strong>'.moneyFormatIndia($tot_invoice_val).'</strong>';?>
                            </span>
                          </td>
                        </tr>



                        </tbody>
                    </table>
                    </div>

                  <hr class="my-5">

                  <!-- Title -->
                
                </div>
              </div> <!-- / .row -->
                <?php
                        $where      = [
                            "bill_form_main_unique_id" => $unique_id_1,
                            "invoice_no" => $invoice_no,
                            // "dc_number" => $dc_number,
                            // "ins_unique_id" => $ins_unique_id,
                            "is_delete" => 0,
                        ];

                        $table_sub      =  "bill_submission_form";

                        $columns    = [
                            // "installation_reference_no",
                            // "supplier_invoice_number",
                            "bill_form_main_unique_id",
                            "unique_id",
                            // "scanned_dc_copy",
                            // "scanned_snr_copy",
                            // "scanned_ir_copy",
                            // "invoice_copy",
                            "claim_amount",
                            "bill_form_main_unique_id",
                            // "ins_unique_id",
                        ];

                        $table_details   = [
                            $table_sub,
                            $columns
                        ];

                        $result_values_data  = $pdo->select($table_details, $where);
                        // print_r($result_values_data);die();

                        if ($result_values_data->status) {

                            $result_values_data      = $result_values_data->data;
                            // $installation_reference_no    = $result_values_data[0]["installation_reference_no"];
                            // $supplier_invoice_number          = $result_values_data[0]["supplier_invoice_number"];
                            $bill_form_main_unique_id         = $result_values_data[0]["bill_form_main_unique_id"];
                            // $scanned_ir_copy         = $result_values_data[0]["scanned_ir_copy"];
                            // $invoice_copy         = $result_values_data[0]["invoice_copy"];
                            $unique_id_data         = $result_values_data[0]["unique_id"];
                            // $scanned_snr_copy         = $result_values_data[0]["scanned_snr_copy"];
                            $claim_amount         = $result_values_data[0]["claim_amount"];
                            // $exp_under_user_type  = explode(",", $under_user_type);

                            $btn_text           = "Update";
                            $btn_action         = "update";
                        } else {
                            $btn_text           = "Error";
                            $btn_action         = "error";
                            $is_btn_disable     = "disabled='disabled'";
                        }
                        $claim_amount_options      = [
                            // [
                            //     "id"    => '5',
                            //     "value"  => "5%"
                            // ],
                         
                            [
                                "id"    => '75',
                                "value"  => "75%"
                            ],
                               [
                                "id"    => '25',
                                "value"  => "25%"
                            ],
                            [
                                "id"    => '90',
                                "value"  => "90%"
                            ],
                            [
                                "id"    => '100',
                                "value"  => "100%"
                            ],
                            // [
                            //     "id"    => '20',
                            //     "value"  => "20%"
                            // ],
                        ];
                        $claim_amount_options    = select_option($claim_amount_options, "Select", $claim_amount);
                        ?>

              <div class="row mt-4">
                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Claim Amount</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="claim_amount" id="claim_amount">
                                        <?php echo $claim_amount_options ?>
                                        </select>
                                    </div>
                                </div>


                        <div class="col-xl-3">
                            <div style='display:none' ;>
                                <label for="exampleInputdate" class="form-label"></label>
                                <select name="bill_status" id="bill_status" class="select2 form-control">
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="bill_form_main_unique_id" name="bill_form_main_unique_id" class="form-control" value="<?php echo $form_main_unique_id ?>">
                        <input type="hidden" id="po_num" name="po_num" class="form-control" value="<?php echo $po_num ?>">
                        <input type="hidden" id="po_date" name="po_date" class="form-control" value="<?php echo $po_date ?>">
                        <!-- <input type="hidden" id="con_contact_name" name="con_contact_name" class="form-control" value="<?php echo $con_contact_name ?>">
                        <input type="hidden" id="con_address" name="con_address" class="form-control" value="<?php echo $con_address ?>"> -->
                        <input type="hidden" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo $invoice_no ?>">
                        <input type="hidden" id="invoice_date" name="invoice_date" class="form-control" value="<?php echo $invoice_date ?>">
                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control" value="<?php echo $result_values[0]["invoice_value"]; ?>">
                        <input type="hidden" id="file_name" name="file_name" class="form-control" value="<?php echo $file_name ?>">
                        <input type="hidden" id="cutomername" name="cutomername" class="form-control" value="<?php echo $cutomername; ?>">
                        <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                        <input type="hidden" id="invoice_qty" name="invoice_qty" value="<?php echo $invoice_qty; ?>">
                        
                        <!-- <input type="hidden" id="ins_unique_id" name="ins_unique_id" value="<?php echo $ins_unique_id; ?>"> -->
                        <!-- <input type="hidden" id="ir_status" name="ir_status" value="<?php echo $ir_status; ?>">
                        <input type="hidden" id="snr_status" name="snr_status" value="<?php echo $snr_status; ?>">
                        <input type="hidden" id="dc_date" name="dc_date" value="<?php echo $dc_date; ?>"> -->
            </div>
               <div class="col-12 mt-3">
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>

                                    <?php if ($unique_id_data != '') { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="bill_submission_cu()">Update</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="bill_submission_cu()">Save</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

            </div>

          </div>
        </div>




        <!-- Try -->







<?php
function image_view($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}


?>
<script>

      // Function to trim spaces
      function trimInput(input) {
        input.value = input.value.trim();
    }
function isAlphaNumeric(event) {
    const char = String.fromCharCode(event.which);
    const regex = /^[a-zA-Z0-9]$/;

    // If not letter or number, prevent input
    if (!regex.test(char)) {
        event.preventDefault();
        return false;
    }
    return true;
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

