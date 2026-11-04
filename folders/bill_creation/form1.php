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
        $unique_id_1  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        $ins_unique_id  = $_GET["ins_unique_id"];
        $where      = [
            "consignee_unique_id" => $unique_id_1,
            "invoice_no" => $invoice_no,
            "ins_unique_id" => $ins_unique_id
        ];
        $table      =  "view_bill_submission_list";
        $columns    = [
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_no",
            "invoice_date",
            "invoice_value",
            "file_name",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id"
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r( $result_values);die();
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $po_num          = $result_values[0]["po_num"];
            $po_date    = $result_values[0]["po_date"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $invoice_date          = $result_values[0]["invoice_date"];
            $invoice_value          = $result_values[0]["invoice_value"];
            $file_name    = $result_values[0]["file_name"];
            $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
            $form_main_unique_id          = $result_values[0]["form_main_unique_id"];
            $ins_unique_id          = $result_values[0]["ins_unique_id"];
            $file_name_po = image_view("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['file_name']);
            //      $designation_details   = work_designation($designation_unique_id);
            //  $designation_name      = $designation_details[0]["designation_type"];
            //  print_r($po_num_options);die();
            // $po_num_options = get_po($unique_id);
            // $po_num_options = select_option($po_num_options, "Select Po Num");
            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}
// $po_num_options = get_po($unique_id);
// $po_num_options = select_option($po_num_options, "Select Po Num");
$po_num_options   = get_po($unique_id);
$po_num_options = select_option($po_num_options, "Select Po Num");
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Elcot Entry Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Elcot Entry</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<style>
    .head_po {
        font-size: .875rem;
        margin-bottom: .3125rem;
    }
</style>
<div class="row cf">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <?php
                        $where      = [
                            "consignee_unique_id" => $unique_id_1,
                            "invoice_no" => $invoice_no,
                            "ins_unique_id" => $ins_unique_id
                        ];
                        $table_sub      =  "bill_submission_form";
                        $columns    = [
                            "bill_form_main_unique_id",
                            "po_num",
                            "po_date",
                            "con_contact_name",
                            "con_address",
                            "invoice_no",
                            "invoice_date",
                            "invoice_value",
                            "consignee_unique_id",
                            "file_name",
                            "unique_id",
                            "ins_unique_id"
                        ];
                        $table_details   = [
                            $table_sub,
                            $columns
                        ];
                        $result_values_data  = $pdo->select($table_details, $where);
                        // print_r($result_values_data);die();
                        if ($result_values_data->status) {
                            $result_values_data      = $result_values_data->data;
                            $bill_form_main_unique_id    = $result_values_data[0]["bill_form_main_unique_id"];
                            $po_num         = $result_values_data[0]["po_num"];
                            $po_date         = $result_values_data[0]["po_date"];
                            $con_contact_name         = $result_values_data[0]["con_contact_name"];
                            $con_address         = $result_values_data[0]["con_address"];
                            $invoice_no         = $result_values_data[0]["invoice_no"];
                            $invoice_date         = $result_values_data[0]["invoice_date"];
                            $file_name         = $result_values_data[0]["file_name"];
                            $ins_unique_id         = $result_values_data[0]["ins_unique_id"];
                            // $exp_under_user_type  = explode(",", $under_user_type);
                            $btn_text           = "Update";
                            $btn_action         = "update";
                        } else {
                            $btn_text           = "Error";
                            $btn_action         = "error";
                            $is_btn_disable     = "disabled='disabled'";
                        }
                        ?>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 head_po">
                                            <div class="row">
                                                <div class="col-xl-12 head_po">
                                                    <label class="form-label">po number</label>
                                                    <select name="po_num_bill" id="po_num_bill"
                                                        class="select2 form-control" onchange="get_invoice_data(this)">
                                                        <?php echo $po_num_options; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <table id="bill_datatable" class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Selection</th>
                                        <th>S No</th>
                                        <th>BG.No / BG.ID</th>
                                        <th>BG Date</th>
                                        <th>PO Number </th>
                                        <th>PO Date </th>
                                        <!-- <th>invoice count</th> -->
                                        <th>invoice Qty</th>
                                        <th>Invoice Value</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Consignee</th>
                                        <th>Location</th>
                                        <th>Claim Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- id="data_table" -->
                                    <!-- <tr ></tr> -->
                                </tbody>
                            </table>
                            <!-- <table id="bill_datatable_bg" class="table table-bordered nowrap table-striped align-middle"
                                style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Selection</th>
                                        <th>S.No</th>
                                        <th>BG.No / BG.ID</th>
                                        <th>BG Date</th>
                                        <th>PO Number</th>
                                        <th>PO Date</th>
                                        <th>Total Invoice</th>
                                        <th>Invoice Tot. Qty.</th>
                                        <th>BG Value</th>
                                    </tr>
                                </thead>
                                <tbody id="data_table1">
                                </tbody>
                            </table> -->
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-group row ">
                            <div class="col-md-12" align="right">
                                <!-- Cancel,save and update Buttons -->
                                <!--<button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Update</button>-->
                                <?php echo btn_cancel($btn_cancel); ?>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button>
                            
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<script>

</script>
