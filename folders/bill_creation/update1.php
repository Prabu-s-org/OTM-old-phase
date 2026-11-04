
<style>
    table thead tr th{
        text-align:center;
    }
</style>
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

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET["unique_id"];
        $bill_no  = $_GET["bill_no"];
        // $ins_unique_id  = $_GET["ins_unique_id"];
        $where      = [
            "bill_form_main_unique_id" => $unique_id,
            "bill_no" => $bill_no,
            // "ins_unique_id" => $ins_unique_id
        ];
//   print_r($where);die();

        // $table      =  "view_bg_list_final";
        $table = "bill_submission_main_table";

        $columns    = [
            
           "get_po_number (bill_form_main_unique_id) as po_num",
            "po_date",
            "bg_num",
            "bg_id",
            "bg_date",
            "bg_value",
            "bill_no",
            "bill_submission_date",
            "(select count(invoice_no) from bill_submission_form where bill_submission_form.bill_form_main_unique_id = bill_submission_main_table.bill_form_main_unique_id and is_delete = 0) as invoice_cnt",
            "(select bg_percen from product_details_sub where product_details_sub.form_main_unique_id = bill_submission_main_table.bill_form_main_unique_id group by form_main_unique_id) as bg_percen",
            "claim_amount",
            "claimamt"

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
            $po_date    = $result_values[0]["po_date"];
            $bg_num    = $result_values[0]["bg_num"];
            $bg_id    = $result_values[0]["bg_id"];
             $claim_percent    = $result_values[0]["claim_amount"];
              $claim_value    = moneyFormatIndia1($result_values[0]["claimamt"]);
            $invoice_value          = moneyFormatIndia1($result_values[0]["invoice_value"]);
            $bg_month         = $result_values[0]["bg_month"];
            $bg_percentage    = $result_values[0]["bg_percentage"];
            $bg_date    = $result_values[0]["bg_date"];
            $bg_value    = moneyFormatIndia1($result_values[0]["bg_value"]);
            $bill_no    = $result_values[0]["bill_no"];
            $bill_submission_date    = $result_values[0]["bill_submission_date"];
            $invoice_cnt    = $result_values[0]["invoice_cnt"];
            $bg_percen    = $result_values[0]["bg_percen"];
           
                            
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
            $stmt->bindParam(':unique_id', $consignee_unique_id);
            $stmt->execute();

            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
            if (!empty($consignee_data)) {
                $consigneeName    = $consignee_data[0]["con_contact_name"];
                $consigneeContact  = $consignee_data[0]["con_contact_number"];
                $consigneeLan  = $consignee_data[0]["con_lan_num"];
                $consigneeAddress   = $consignee_data[0]["con_address"];
                $consigneeDistrict  = district_name_stock($consignee_data[0]["con_district"]);
                $consigneeState      = con_state_name_stock($consignee_data[0]["con_state_name"]);
                $consigneePincode      = $consignee_data[0]["con_pincode"];
                $consigneeZone      = $consignee_data[0]["zone"];
            }
            
            $stmt->closeCursor();
            // $is_active          = $result_values[0]["is_active"];



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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              <center><h4 class="card-title mb-0">BILL DETAILS </h4></center>  
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                           <div class="row">
                            <!-- Customer Details -->
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details</h6>
                                <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $department ?></strong></h6>
                                <p class="mb-1"><?php echo $customerAddress; ?>,<br> <?php echo $customerDistrict ?><br><?php echo $customerState ?>, <?php echo $customerPincode ?></p>
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
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & BILL Details </h6>
                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">PO No</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $po_num;?></div>
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
                                       <input type="hidden" id="bg_month" name="bg_month" value="<?php echo $bg_month; ?>">
                                </div>
                                

                                 <div class="row">
                                    <div class="col-5 text-body-secondary">Invoice Count</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $invoice_cnt; ?></div>
                                </div>

                                
                                 <div class="row">
                                    <div class="col-5 text-body-secondary">Claim Percent(%)</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $claim_percent; ?> </div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Claim Value</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $claim_value; ?></div>
                                </div>
                            </div>
                           

                           
                            <!-- Consignee / Invoice Details -->
                            <div class="col-md-4">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">BG Details </h6>
                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">BG ID</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_id;?></div>
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
                                    <div class="col-5 text-body-secondary">BG (%)</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_percen; ?> </div>
                                </div>

                               
                                <input type="hidden" name="consignee_unique_id" id="consignee_unique_id" value="<?php echo $consignee_unique_id; ?>">
                                <input type="hidden" name="po_form_unique_id" id="po_form_unique_id" value="<?php echo $po_form_unique_id; ?>">
                                </div>

                                          <div class="row">
                <div class="col-12">

                  <!-- Table -->

                 <div class="table-responsive" data-list='{"valueNames": ["tables-row", "tables-first", "tables-last", "tables-handle"]}'>
                    <table  class="table table-bordered table-striped align-middle">
                        <thead>
                        <tr>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-row">S.No</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-last">Invoice Date</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-first">Invoice No</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-first">Consignee Address</a>
                            </th>
                            <th scope="col">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-handle">Invoice Qty</a>
                            </th>
                            <th scope="col" class="text-md-end">
                            <a href="#" class="text-body-secondary list-sort white_text" data-sort="tables-handle">Invoice Value</a>
                            </th>
                            <th scope="col" class="text-md-end">
                            <a href="#" class="text-body-secondary list-sort white_text " data-sort="tables-handle">Claim Amount</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">

                        <?php

                        $unique_id  = $_GET["unique_id"];
                        $bill_no  = $_GET["bill_no"];
                                   
                                    $where1 = "bill_form_main_unique_id = '$unique_id' and bill_no = '" . $bill_no . "' AND  is_delete='0'";
                                    // print_r($where1); die();
                                    $table1 = "bill_submission_form";
                                    $columns1 = [
                                        
                                        "invoice_no",
                                        "invoice_date",
                                        "invoice_qty",
                                        "invoice_value",
                                        "claim_amt",
                                        "(select consignee_id from invoice_creation where invoice_creation.invoice_no = bill_submission_form.invoice_no group by invoice_no) as consignee_id"
                                       

                                    ];
                                    $table_details1 = [
                                        $table1,
                                        $columns1
                                    ];
                                    $values_product = $pdo->select($table_details1, $where1);
                                    // print_r($values_product);
                                    
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
                                                <td><?php echo ($product['invoice_date']); ?></td>
                                                <td><?php echo $product['invoice_no'] ?></td>
                                                <td><?php echo '<strong>'.disname($consigneeName) .'</strong><br>'.  $consigneeAddress .','. $consigneeDistrict .','. $consigneeState .','. $consigneePincode ; ?></td>
                                                <td style="text-align: right"><b><?php echo $product['invoice_qty'] ?></b></td>
                                                <td style="text-align: right"><b><?php echo moneyFormatIndia($product['invoice_value']); ?></b></td>
                                                <td style="text-align: right"><?php echo '<strong>'.moneyFormatIndia($product['claim_amt']).'</strong>' ; ?></td>

                                            </tr>
                                            <?php
                                            $j++;
                                            $tot_invoice_val += $product['invoice_qty_value'];
                                        }
                                    }
                                    // }
                                    ?>
                      



                        </tbody>
                    </table>
                    </div>

                  <!-- <hr class="my-5"> -->

                  <!-- Title -->
                
                </div>
              </div> <!-- / .row -->







                         

                            
                        </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
