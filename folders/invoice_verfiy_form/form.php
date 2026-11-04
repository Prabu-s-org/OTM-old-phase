<!-- This file Only PHP Functions -->
<?php include 'function2.php'; ?>
<style>
input[type="checkbox"].myCheck:checked:disabled {
    accent-color: blue; /* Blue tick mark */
}
</style>
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
$session_approved_by = $_SESSION["staff_name"];
//  print_r($session_approved_by);die();

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id = $_GET["unique_id"];
        $where = [
            "invoice_unique_id" => $unique_id
        ];


        $table = "view_doc_approval_list_final";

        $columns = [
            "po_num",
            "po_date",
            // "con_contact_name",
            "(SELECT department FROM department_creation WHERE department_creation.unique_id = " . $table . ".department group by  department_creation.unique_id) AS department",
            "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id 
            group by consignee_details_sub.unique_id) AS con_address",
            // "con_address",
            "(SELECT con_pincode FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id
            group by consignee_details_sub.unique_id) AS con_pincode",
            "(SELECT con_district FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id
            group by consignee_details_sub.unique_id) AS con_district",

            "invoice_no",
            "doc_approval_sts",
            "approved_by",
            "invoice_unique_id",
            "invoice_date",
            "form_main_unique_id",

            "ac_team_verifiy_status",
            "invoice_auto_id",
            "invoice_doc_status",
            "consignee_unique_id",
            "dc_number",
            "dc_date"

        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);
        // print_r($result_values);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $po_num = $result_values[0]["po_num"];

            $po_date = date("d-m-Y", strtotime($result_values[0]["po_date"]));
            ;
            $department = $result_values[0]["department"];
            // $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address = $result_values[0]["con_address"];
            $con_pincode = $result_values[0]["con_pincode"];
            $con_districts = district_name($result_values[0]['con_district']);
            $con_district = disname($con_districts[0]['district_name']);
            $invoice_no = $result_values[0]["invoice_no"];
            $doc_approval_sts = $result_values[0]["doc_approval_sts"];
            $invoice_unique_id = $result_values[0]["invoice_unique_id"];
            $invoice_date = date("d-m-Y", strtotime($result_values[0]["invoice_date"]));
            $form_main_unique_id = $result_values[0]["form_main_unique_id"];
            $ac_team_verifiy_status = $result_values[0]["ac_team_verifiy_status"];
            $invoice_auto_id = $result_values[0]["invoice_auto_id"];
            $ledger_name = $result_values[0]["ledger_name"];
            $ledger_no = $result_values[0]["ledger_no"];
            $invoice_doc_status = $result_values[0]["invoice_doc_status"];
            $consignee_unique_id = $result_values[0]["consignee_unique_id"];
            $dc_number = $result_values[0]["dc_number"];
            $dc_date = date("d-m-Y", strtotime($result_values[0]["dc_date"]));

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

$appr_type_options = [
    [
        "id" => 1,
        "text" => "Approved"
    ],
    [
        "id" => 2,
        "text" => "Rejected"
    ],


];

$appr_type_options = select_option($appr_type_options, "Select", $ac_team_verifiy_status);

?>
<style>
    label {
        /* font-weight: bold;
  color: black; */
        margin-right: 20px;
        /* You can add more styles as needed */
    }

    /* .form-label {
  display: inline-block;
  width: 100px;
  text-align: left;
}

.form-label {
 
  margin-left: 10px;
}

.form-label span {
  margin-left: 10px;
} */
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Docs Approval</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Docs Approval </li>
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
                    <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $session_approved_by ?>">
                    <!--<input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="">-->
                    <input type="hidden" name="invoice_unique_id" id="invoice_unique_id"
                        value="<?php echo $invoice_unique_id ?>">
                    <input type="hidden" name="form_main_unique_id" name="form_main_unique_id"
                        value="<?php echo $form_main_unique_id ?>">

                    <input type="hidden" name="invoice_auto_id" id="invoice_auto_id"
                        value="<?php echo $invoice_auto_id ?>">
                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
                    <input type="hidden" name="ledger_name" id="ledger_name" value="<?php echo $ledger_name ?>">
                    <input type="hidden" name="ledger_no" name="ledger_no" value="<?php echo $ledger_no; ?>">
                    <input type="hidden" name="invoice_doc_status" name="invoice_doc_status"
                        value="<?php echo $invoice_doc_status; ?>">
                    <input type="hidden" name="dc_number" name="dc_number" value="<?php echo $dc_number; ?>">
                    <input type="hidden" name="dc_date" name="dc_date" value="<?php echo $dc_date; ?>">


                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_num ?></div>

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_date ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Customer</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $department ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Location</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_address ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Pincode</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_pincode ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee District</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_district ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_no ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_date ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">DC No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $dc_number ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">DC Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $dc_date ?></div>

                                    </div>
                                </div><br><br>
                                <div class="col-12 mt-2">
                                    <div class="table-responsive mb-4">
                                        <table
                                            class="table table-striped table-bordered align-middle  mb-0 small_table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th scope="col">Item Code</th>
                                                    <th scope="col">Item Details</th>

                                                    <!-- <th scope="col">Invoice QTY</th> -->
                                                    <th scope="col">DC Qty</th>
                                                    <th scope="col">Invoice Value</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $where1 = "po_unique_id = '" . $form_main_unique_id . "' and consignee_id = '" . $consignee_unique_id . "' and dc_num = '" . $dc_number . "' and is_delete=0 ";
                                                //  print_r($where1); die();
                                                $table1 = "invoice_creation";
                                                $columns1 = [
                                                    "item_code",
                                                    "product",
                                                    // "(SELECT sum(invoice_qty) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id = ".$table1.".form_main_unique_id ) AS invoice_qty",
                                                    "invoice_qty",
                                                    "invoice_qty_value",

                                                    //  "invoice_qty_value",
                                                    // "(SELECT sum(invoice_value) FROM view_doc_approval_list_final WHERE view_doc_approval_list_final.invoice_auto_id = ".$table1.".invoice_auto_id ) AS invoice_value",
                                                
                                                    //  "(SELECT sum(invoice_value) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id = ".$table1.".form_main_unique_id ) AS invoice_value",
                                                

                                                    "unique_id",
                                                    "po_unique_id"

                                                ];
                                                $table_details1 = [
                                                    $table1,
                                                    $columns1
                                                ];
                                                $values_product = $pdo->select($table_details1, $where1);
                                                // Print_r($values_product);
                                                $j = 1;
                                                if ($values_product->status) {
                                                    $product_array = $values_product->data;
                                                    //   print_r($product_array);
                                                
                                                    $btn_update = btn_update($folder_name, $value['unique_id']);
                                                    foreach ($product_array as $key => $product) {
                                                        $invoice_value_with_tax = $product['invoice_qty_value'] + ($product['invoice_qty_value'] * 0.18);

                                                        // $product['po_unique_id']='<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';
                                                
                                                        // $product['po_unique_id'] = $product['stock_qty']- $product['invoice_qty'];
                                                        //   $s_no = $sno + 1;
                                                        ?>


                                                        <tr>
                                                            <td><?php echo $j; ?></td>

                                                            <td><?php echo $product['item_code'] ?></td>
                                                            <td><?php echo $product['product'] ?></td>
                                                            <td><?php echo $product['invoice_qty'] ?></td>
                                                            <!-- <td><?php echo $product['invoice_value'] ?></td> -->
                                                            <td><?php echo moneyFormatIndia($invoice_value_with_tax); ?></td>

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


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Approval Status</label>

                                        <select name="ac_team_verifiy_status" id="ac_team_verifiy_status"
                                            class="select2 form-control" <?php if ($ac_team_verifiy_status == '1') {
                                                echo "disabled";
                                            } else {
                                                echo '';
                                            } ?> required
                                            onchange="show_rejection_reason(this.value);empty_reason();">
                                            <?php echo $appr_type_options; ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xl-3" id="rejection_reason" style="display:none">
                                    <div class="mb-3">
                                        <label class="form-label">Rejected Reason</label>
                                        <textarea id="ac_reason_reject" name="ac_reason_reject"
                                            class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <div class="col-md-12" align="right">
                                        <!-- Cancel,save and update Buttons -->
                                        <?php echo btn_cancel($btn_cancel); ?>
                                        <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                    </div>
                                </div>
                                <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-delimiter" class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="form-group row ">
                                <div class="col-md-12" align="center">

                                    <button type="button" class="btn btn-danger">Submit</button>
                                </div>
                            </div> -->
                            <!-- <div class="form-group row ">
                                <div class="col-md-12" align="right"> -->
                            <!-- Cancel,save and update Buttons -->

                            <!-- <button type="submit">Submit</button> -->
                        </div>
                    </div>
            </div>
            </form>

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div><!-- end col -->
</div>

<script>
    //    $(document).ready(function () {
    //     doc_status();
    //    });

    function show_rejection_reason() {
        var status = document.getElementById("ac_team_verifiy_status").value;
        if (status == 2) {
            document.getElementById("rejection_reason").style.display = "block";
        } else {
            document.getElementById("rejection_reason").style.display = "none";
        }
    }
    function empty_reason() {
        document.getElementById("ac_reason_reject").value = "";
    }
</script>
