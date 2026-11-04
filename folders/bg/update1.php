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
        $invoice_no  = $_GET["invoice_no"];
        // $ins_unique_id  = $_GET["ins_unique_id"];
        $where      = [
            "form_main_unique_id" => $unique_id,
            "invoice_no" => $invoice_no,
            // "ins_unique_id" => $ins_unique_id
        ];
//   print_r($where);die();

        // $table      =  "view_bg_list_final";
        $table = "view_sign_final_bg";

        $columns    = [
             "'' as  s_no",
            // "state_name",
            // "is_active",
            // "unique_id"
            "po_num",
            "po_date",
            // "con_contact_name",
            // "con_address",
            // "(select con_contact_name from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_contact_name",
            //  "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_address",
            // "(select con_contact_name from view_bg_select_list2 as view_bg_select_list2 WHERE view_bg_select_list2.consignee_unique_id='$table'.consignee_unique_id)as con_contact_name",
            "invoice_no",
            "invoice_date",
            // "po_product_name",
            // "(select product from product_details_sub WHERE product_details_sub.unique_id=view_bg_list_final.po_product_name)as product",
            // "bg_percentage",
            "invoice_qty",
            "invoice_value",
            "bg_month",
            "bg_percentage",
            // "bg_month",
            // "bg_month",
            // "consignee_unique_id",
            "po_unique_id",
                         "(SELECT unique_id from consignee_details_sub where form_main_unique_id = $table.form_main_unique_id LIMIT 1) AS cons_unique_id",

            // "ins_unique_id"
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
            // $po_date    = $result_values[0]["po_date"];
            // $con_contact_name          = $result_values[0]["con_contact_name"];
            // $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            // $invoice_date          = $result_values[0]["invoice_date"];
            // $product          = $result_values[0]["po_product_name"];
            $invoice_qty    = $result_values[0]["invoice_qty"];
            $invoice_value          = moneyFormatIndia1($result_values[0]["invoice_value"]);
            $bg_month         = $result_values[0]["bg_month"];
            $bg_percentage    = $result_values[0]["bg_percentage"];
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));

                $orgDate1 = $result_values[0]["invoice_date"];  
                $invoice_date = date("d-m-Y", strtotime($orgDate1));

              $consignee_unique_id              = $result_values[0]["cons_unique_id"];
                            
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
              <center><h4 class="card-title mb-0">BG DETAILS </h4></center>  
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                           <div class="row">
                            <!-- Customer Details -->
                            <div class="col-md-3">
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

                            <!-- Consignee Details -->
                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Consignee Details</h6>
                                <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $consigneeName ?></strong></h6>
                                <p class="mb-1"><?php echo $consigneeAddress ?>, <br>   <?php echo $consigneeDistrict ?><br><?php echo $consigneeState ?>, <?php echo $consigneePincode ?></p>
                                <p class="mb-1">
                                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                    <?php echo !empty($consigneeContact) ? $consigneeContact : '--'; ?>
                                </p>
                                <p class="mb-1">
                                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                    <?php echo !empty($consigneeLan) ? $consigneeLan : '--'; ?>
                                </p>
                            </div>
                            <!-- Consignee / Invoice Details -->
                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO Details </h6>
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
                                <!-- <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">Excutive Name</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $executive_name; ?></div>
                                </div> -->
                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">Invoice No</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $invoice_no; ?></div>
                                </div>


                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">Invoice Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo date('d-m-Y', strtotime($invoice_date)) ?></div>
                                </div>
                                <!-- <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">DC Number</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $dc_no ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-body-secondary">DC Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
                                </div> -->

                                <input type="hidden" name="consignee_unique_id" id="consignee_unique_id" value="<?php echo $consignee_unique_id; ?>">
                                <input type="hidden" name="po_form_unique_id" id="po_form_unique_id" value="<?php echo $po_form_unique_id; ?>">
                            </div>

                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">BG Details</h6>

                               

                                <div class="row">
                                    <div class="col-5 text-body-secondary">BG Month</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_month; ?></div>
                                       <input type="hidden" id="bg_month" name="bg_month" value="<?php echo $bg_month; ?>">
                                </div>

                                <!-- <div class="row">
                                    <div class="col-5 text-body-secondary">BG Value</div>
                                    <div class="col-1">:</div>

                                    <div class="col-6 "><?php echo $upd_bg_value; ?></div>
                                </div> -->

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Bg  %</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_percentage ?>  %</div>
                                    <!-- <input type="hidden" id="bg_auto_id" name="bg_auto_id" value="<?php echo  $result_values[0]["bg_auto_id"];  ?>"> -->
                                </div>

                                 <div class="row">
                                    <div class="col-5 text-body-secondary">Total Invoice Value</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $invoice_value; ?></div>
                                </div>
                            </div>
                        </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <!--<?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>-->
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
