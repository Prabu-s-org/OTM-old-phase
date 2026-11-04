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
        $ins_unique_id  = $_GET["ins_unique_id"];
        $where      = [
            "form_main_unique_id" => $unique_id,
            "invoice_no" => $invoice_no,
            "ins_unique_id" => $ins_unique_id
        ];
//   print_r($where);die();

        $table      =  "view_bg_list_final";

        $columns    = [
             "'' as  s_no",
            // "state_name",
            // "is_active",
            // "unique_id"
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            // "(select con_contact_name from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_contact_name",
            //  "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_address",
            // "(select con_contact_name from view_bg_select_list2 as view_bg_select_list2 WHERE view_bg_select_list2.consignee_unique_id='$table'.consignee_unique_id)as con_contact_name",
            "invoice_no",
            "invoice_date",
            "po_product_name",
            // "(select product from product_details_sub WHERE product_details_sub.unique_id=view_bg_list_final.po_product_name)as product",
            // "bg_percentage",
            "invoice_qty",
            "invoice_value",
            "bg_month",
            // "bg_month",
            // "bg_month",
            "consignee_unique_id",
            "po_unique_id",
            "ins_unique_id"
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
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            // $invoice_date          = $result_values[0]["invoice_date"];
            $product          = $result_values[0]["po_product_name"];
            $invoice_qty    = $result_values[0]["invoice_qty"];
            $invoice_value          = $result_values[0]["invoice_value"];
            $bg_month         = $result_values[0]["bg_month"];
            $consignee_unique_id    = $result_values[0]["consignee_unique_id"];
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));

$orgDate1 = $result_values[0]["invoice_date"];  
$invoice_date = date("d-m-Y", strtotime($orgDate1));
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
                <h4 class="card-title mb-0">BG </h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_num ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_date ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_contact_name ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Location</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_address ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_no ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_date ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Primary Product As Per BG</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $product ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Qty As Per BG</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_qty ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Value</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_value ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">No Of BG Month</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $bg_month ?></div>
                                        <!-- <label for="main_screen" class="form-label">State Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                    </div>
                                </div><br><br>


                                <!-- end col -->
                                <!-- <div class="form-check mb-3">
                                    <input class="" type="checkbox" id="formCheck6" checked>
                                    <label class="" for="formCheck6">
                                        Tick
                                    </label>
                                </div> -->
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
