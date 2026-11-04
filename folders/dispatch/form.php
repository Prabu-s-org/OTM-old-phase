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
        $dc_no  = $_GET["dc_no"];
        $consignee_unique_id  = $_GET["consignee_unique_id"];
         $where      = [
             "form_main_unique_id" => $unique_id,
             "dc_number" => $dc_no,
             "consignee_unique_id" => $consignee_unique_id,
 
             
         ];
        $table      =  "view_dispatch_pending_list";
        
        $columns    = [
            "get_po_number(form_main_unique_id) as po_num",
            "po_date",
            "cns_get_contact_name(consignee_unique_id) AS con_contact_name",
            "get_address(consignee_unique_id) AS con_address",
            "invoice_no",
            "invoice_date",
            "stock_id",
            "(select po_unique_id from po_form where unique_id = $table.form_main_unique_id and po_form.is_delete=0 group by unique_id) AS po_unique_id",
            "invoice_auto_id",
            "cns_get_contact_number(consignee_unique_id) AS con_contact_number",
            "form_main_unique_id",
            "consignee_unique_id",
            "dispatch_status",
            "dc_date",
            "dc_number",
            "(SELECT billing_gst_no   FROM consignee_details_sub   WHERE unique_id = '$consignee_unique_id'   AND is_delete = 0   LIMIT 1) AS billing_gst",

            
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // Fallback to invoice_creation_main if view_dispatch_pending_list returned empty or no invoice_no
        if (!$result_values->status || empty($result_values->data) || empty($result_values->data[0]["invoice_no"])) {
            $table_pending = "invoice_creation_main";
            $columns_pending = [
                "get_po_number(form_main_unique_id) as po_num",
                "po_date",
                "cns_get_contact_name(consignee_unique_id) AS con_contact_name",
                "get_address(consignee_unique_id) AS con_address",
                "invoice_no",
                "invoice_date",
                "stock_id",
                "(select po_unique_id from po_form where unique_id = $table_pending.form_main_unique_id and po_form.is_delete=0 group by unique_id) AS po_unique_id",
                "invoice_auto_id",
                "cns_get_contact_number(consignee_unique_id) AS con_contact_number",
                "form_main_unique_id",
                "consignee_unique_id",
                "dispatch_status",
                "dc_date",
                "dc_number",
                "(SELECT billing_gst_no FROM consignee_details_sub WHERE unique_id = '$consignee_unique_id' AND is_delete = 0 LIMIT 1) AS billing_gst",
            ];
            $table_details_pending = [
                $table_pending,
                $columns_pending
            ];
            $result_values = $pdo->select($table_details_pending, $where);

            // If still empty or no invoice_no, try flexible DC number matching
            if (!$result_values->status || empty($result_values->data) || empty($result_values->data[0]["invoice_no"])) {
                $clean_dc = str_replace(['/', '-', ' '], '', $dc_no);
                $where_flexible = "form_main_unique_id = '$unique_id' AND consignee_unique_id = '$consignee_unique_id' AND (dc_number = '$dc_no' OR REPLACE(REPLACE(REPLACE(dc_number, '/', ''), '-', ''), ' ', '') = '$clean_dc') AND is_delete = 0";
                $result_values = $pdo->select($table_details_pending, $where_flexible);
            }

            // If still empty, match dc_number only in invoice_creation_main
            if (!$result_values->status || empty($result_values->data) || empty($result_values->data[0]["invoice_no"])) {
                $clean_dc = str_replace(['/', '-', ' '], '', $dc_no);
                $where_dc = "(dc_number = '$dc_no' OR REPLACE(REPLACE(REPLACE(dc_number, '/', ''), '-', ''), ' ', '') = '$clean_dc') AND is_delete = 0";
                $result_values = $pdo->select($table_details_pending, $where_dc);
            }
        }
// print_r($result_values);
        if ($result_values->status && !empty($result_values->data)) {

            
            $result_values      = $result_values->data;
             $po_num             = $result_values[0]["po_num"];
             $billing_gst  = $result_values[0]["billing_gst"];
            $po_unique_id            = $result_values[0]["po_unique_id"];
            $po_unique_id_get =  $po_num;
            $con_contact_number            = $result_values[0]["con_contact_number"];
            $con_contact_name   = $result_values[0]["con_contact_name"];
            $con_address        = $result_values[0]["con_address"];
            $invoice_no         = $result_values[0]["invoice_no"];
            $invoice_auto_id         = $result_values[0]["invoice_auto_id"];
            $invoice_no_get = $invoice_no;
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));


            $orgDate1 = $result_values[0]["invoice_date"];  
            $invoice_date= date("d-m-Y", strtotime($orgDate1));
            $stock_id        = $result_values[0]["stock_id"];
            $con_contact_number        = $result_values[0]["con_contact_number"];
            $form_unique_id          = $result_values[0]["form_main_unique_id"];
            $dispatch_status          = $result_values[0]["dispatch_status"];
            $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
            $dc_date          = $result_values[0]["dc_date"];
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $result_values[0]["form_main_unique_id"]);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $cusAdd    = $customer_data[0]["bill_address"];
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
            
            $stmt->closeCursor(); // <--- this clears the result set

            if (empty($invoice_no) && !empty($dc_no)) {
                $clean_dc = str_replace(['/', '-', ' '], '', $dc_no);
                $stmt_inv = $conn->prepare("SELECT invoice_no, dc_date, invoice_date, form_main_unique_id, consignee_unique_id FROM invoice_creation_main WHERE (dc_number = :dc OR REPLACE(REPLACE(REPLACE(dc_number, '/', ''), '-', ''), ' ', '') = :clean_dc) AND is_delete = 0 ORDER BY unique_id DESC LIMIT 1");
                $stmt_inv->execute([':dc' => $dc_no, ':clean_dc' => $clean_dc]);
                $inv_row = $stmt_inv->fetch(PDO::FETCH_ASSOC);
                if (!empty($inv_row['invoice_no'])) {
                    $invoice_no = $inv_row['invoice_no'];
                    $invoice_no_get = $invoice_no;
                    if (empty($dc_date)) $dc_date = $inv_row['dc_date'];
                    if (empty($invoice_date) && !empty($inv_row['invoice_date'])) $invoice_date = date("d-m-Y", strtotime($inv_row['invoice_date']));
                    if (empty($form_unique_id)) $form_unique_id = $inv_row['form_main_unique_id'];
                    if (empty($consignee_unique_id)) $consignee_unique_id = $inv_row['consignee_unique_id'];
                }
            }

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}
            $where_2 = "po_num = '".$po_num."' AND is_delete=0";

                $table_1      =  "po_form";
        
                $columns_2    = [
                    'gst_option AS gst_option'
                ];
        
                $table_details_1   = [
                    $table_1,
                    $columns_2
                ];
        
                $result_values_12  = $pdo->select($table_details_1, $where_2); 
                $data_st       = $result_values_12->data;

                $gst_option = $data_st[0]['gst_option'];
                $active_status_options   = active_status($is_active);
?>


<style>
    form.was-validated button {
        float: none;
        margin: 0px;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Dispatch </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active"> Dispatch </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="col-12">
                        <div class="row">

                        <div class="row">
                        <!-- Customer Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details</h6>
                            <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $department ?></strong></h6>
                            <p class="mb-1"><?php echo $cusAdd ?>, <?php echo $customerDistrict ?><br><?php echo $customerState ?>, <?php echo $customerPincode ?></p>
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
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Consignee Details</h6>
                            <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $consigneeName ?></strong></h6>
                            <p class="mb-1"><?php echo $consigneeAddress ?>, <?php echo $consigneeDistrict ?><br><?php echo $consigneeState ?>, <?php echo $consigneePincode ?></p>
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
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & Invoice Details</h6>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">PO Number</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $po_num ?></div>
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
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">DC Number</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $dc_no ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-body-secondary">DC Date</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
                            </div>

                            <input type="hidden" name="po_form_unique_id" id="po_form_unique_id" value="<?php echo $unique_id; ?>">
                            <input type="hidden" name="po_num" id="po_num" value="<?php echo $po_num; ?>">
                            <input type="hidden" name="po_unique_id" id="po_unique_id" value="<?php echo $po_unique_id; ?>">
                            <input type="hidden" name="po_date" id="po_date" value="<?php echo $po_date; ?>">
                            <input type="hidden" name="con_contact_name" id="con_contact_name" value="<?php echo $con_contact_name; ?>">
                            <input type="hidden" name="con_contact_number" id="con_contact_number" value="<?php echo $con_contact_number; ?>">
                            <input type="hidden" name="con_address" id="con_address" value="<?php echo $con_address; ?>">
                            <input type="hidden" name="consignee_unique_id" id="consignee_unique_id" value="<?php echo $consignee_unique_id; ?>">
                            <input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice_date; ?>">
                            <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                            <input type="hidden" name="dc_no" id="dc_no" value="<?php echo $dc_no; ?>">
                            <input type="hidden" name="dc_date" id="dc_date" value="<?php echo $dc_date; ?>">
                            <input type="hidden" name="invoice_auto_id" id="invoice_auto_id" value="<?php echo $invoice_auto_id; ?>">
                            <input type="hidden" name="stock_id" id="stock_id" value="<?php echo $stock_id; ?>">
                            <input type="hidden" name="billing_gst" id="billing_gst" value="<?php echo $billing_gst; ?>">
                        </div>
                    </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-12 mt-2">
                                <form class="was-validated" autocomplete="off">
                                    <div class="row">
                                    <?php 
                                         $where      = "po_form_unique_id='".$form_unique_id."' and consignee_unique_id='".$consignee_unique_id."' and invoice_no='".$invoice_no."' and dc_number = '".$dc_no."' AND is_delete='0'";
                                         // print_r($where);die();
                                         $table_dispatch      =  "dispatch_list";
                                         $columns    = [
                                             "po_num",
                                             "po_date",
                                             "consignee",
                                             "con_address",
                                             "invoice_no",
                                             "invoice_date",
                                             "dispatch_date",
                                             "mode_of_delivery",
                                             "name_of_courier",
                                             "pod_no",
                                             "status",
                                             "po_unique_id",
                                             "invoice_auto_id",
                                             "po_form_unique_id",
                                             "unique_id",
                                             "consignee_unique_id",
                                         ];
                                         $table_details   = [
                                             $table_dispatch,
                                             $columns
                                         ];
                                         $result_values_data  = $pdo->select($table_details, $where);
                                         if ($result_values_data->status) {
                                             $result_values_data      = $result_values_data->data;
                                             $dispatch_unique_id          = $result_values_data[0]["unique_id"];
                                            }

                                        ?>
                                        <div class="col-xl-3">
                                        <input type="hidden" name="dispatch_unique_id" id="dispatch_unique_id" value="<?php echo $dispatch_unique_id; ?>">
                                            <label class="form-label">Dispatch
                                                Date</label>
                                                <input type="hidden" name="gst_option" id="gst_option" value="<?php echo $gst_option; ?>">
                                                  <input type="date" name="dispatch_date" id="dispatch_date" class="form-control" id="exampleInputdate" required>
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Mode of
                                                Delivery</label>
                                                
                                            <select name="mode_of_delivery" id="mode_of_delivery" class="form-select mb-3" aria-label="Default select example" onchange="shows()" required>
                                                <option selected value="">Select MOD </option>
                                                <option value="1">Hand</option>
                                                <option value="2">Courier</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <div>
                                                <label class="form-label">Name of Courier / Person
                                                    Name</label>
                                                <input type="text" id="name_of_courier" name="name_of_courier" class="form-control" oninput="restrictToAlphaNumeric(this)" value="" required>
                                                <input type="hidden" name="myno" id="myno" value="<?php echo $invoice_no_get; ?>">
                                    <input type="hidden" name="dc_no" id="dc_no" value="<?php echo $dc_no; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3" id="pod_nos">
                                            <label class="form-label">POD
                                                NO.</label>
                                            <input type="text" id="pod_no" name="pod_no" oninput="restrictToAlphaNumeric1(this)" class="form-control" value="" >
                                        </div>
                                        <div class="col-xl-3" id="images">
                                            <div class="mb-3">
                                                <label class="form-label">E Invoice </label>

                                            <input type="file" id="file" accept="application/pdf" name="file" class="form-control " 
                                                value="<?php echo $file_org_name; ?>">
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-xl-3">
                                            <div>
                                                <input type="hidden" name="dispatch_status" id="dispatch_status" value="<?php echo $dispatch_status ?>">
                                            </div>
                                        </div>
                                    </div> <!-- end card -->
                                    <div class="col-md-12" align="right">
                                        <!-- Cancel,save and update Buttons -->
                                        <a href="index.php?file=dispatch/list" class="btn btn-danger">Close</a>
                                        <button type="button" class="btn btn-primary  " onclick="get_dispatch_pending()">Save</button>
                                    </div>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div><!-- end col -->
            </div>
            <script>
            
            
      document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];
        
        // Set the max attribute of the PO Date input field
        document.getElementById("dispatch_date").setAttribute("max", today);
    });       
            
            
            
            
            
            
            
            

$(document).ready(function () {
	var gst_option = document.getElementById('gst_option').value;
                    // alert(gst_option);
                    if(gst_option == 'Yes'){
                        $('#images').show();
                    }
                    if(gst_option == 'No'){
                        $('#images').hide();
                    }
shows();
get_po_no();
});
function get_po_no(){
    document.getElementById('myno').value = '';
    var invoice_no = document.getElementById('invoice_no').value;
    // alert(po_num);
    document.getElementById('myno').value = invoice_no;
}

                function shows(){
                    var mode_of_delivery = document.getElementById('mode_of_delivery').value;
                    // alert();
                    if(mode_of_delivery == '1'){
                        $('#pod_nos').hide();
                    }else{
                        $('#pod_nos').show();
                    }
                }
                function get_dispatch_pending() {
                    // alert('hi');
                    var internet_status = is_online();
                    if (!internet_status) {
                        sweetalert("no_internet");
                        return false;
                    }
                    var my_no = document.getElementById('myno').value;
                    var dispatch_date = document.getElementById('dispatch_date').value;
                    var mode_of_delivery = document.getElementById('mode_of_delivery').value;
                    var name_of_courier = document.getElementById('name_of_courier').value;
                    var image_val = document.getElementById("file").value;
                    var pod_no = document.getElementById('pod_no').value;
                    var billing_gst = document.getElementById('billing_gst').value;
                    var valid = false;

if (billing_gst != '') {
    if (dispatch_date != '' && mode_of_delivery != '' && name_of_courier != '' && image_val != '') {
        valid = true;
    }
} else {
    if (dispatch_date != '' && mode_of_delivery != '' && name_of_courier != '') {
        valid = true;
    }
}

                    if (valid) {

                        var po_num = document.getElementById('po_num').value;
                        var po_unique_id = document.getElementById('po_unique_id').value;
                        var po_form_unique_id = document.getElementById('po_form_unique_id').value;
                        var consignee_unique_id = document.getElementById('consignee_unique_id').value;
                        var unique_id = document.getElementById('dispatch_unique_id').value;
                        //   alert(consignee_unique_id);
                        var po_date = document.getElementById('po_date').value;
                        var con_contact_name = document.getElementById('con_contact_name').value;
                        var con_contact_number = document.getElementById('con_contact_number').value;
                        var con_address = document.getElementById('con_address').value;
                        var invoice_date = document.getElementById('invoice_date').value;
                        var invoice_no = document.getElementById('invoice_no').value;
                        var dc_no = document.getElementById('dc_no').value;
                        var dc_date = document.getElementById('dc_date').value;
                        var invoice_auto_id = document.getElementById('invoice_auto_id').value;
                        var dispatch_status = document.getElementById('dispatch_status').value;
                        var stock_id = document.getElementById('stock_id').value;

                        var data = new FormData();
                        var image_s = document.getElementById("file");
                        
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("file", document.getElementById('file').files[i]);
 
                }
            } else {
                data.append("file", '');
            }
           
                        data.append("po_num", po_num);
                        data.append("my_no", my_no);
                        data.append("po_date", po_date);
                        data.append("po_form_unique_id", po_form_unique_id);
                        data.append("consignee_unique_id", consignee_unique_id);
                        data.append("con_contact_name", con_contact_name);
                        data.append("con_contact_number", con_contact_number);
                        data.append("con_address", con_address);
                        data.append("invoice_date", invoice_date);
                        data.append("invoice_no", invoice_no);
                        data.append("dc_no", dc_no);
                        data.append("dc_date", dc_date);
                        data.append("invoice_auto_id", invoice_auto_id);
                        data.append("dispatch_status", dispatch_status);
                        data.append("stock_id", stock_id);
                        data.append("dispatch_date", dispatch_date);
                        data.append("mode_of_delivery", mode_of_delivery);
                        data.append("name_of_courier", name_of_courier);
                        data.append("pod_no", pod_no);
                        // data.append("district", district);
                        data.append("unique_id", unique_id);
                        data.append("po_unique_id", po_unique_id);
                        data.append("action", "createupdate");
                        var is_form = form_validity_check("was-validated");
                        //  if (is_form) {
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
                                $(".createupdate_btn").attr("disabled", "disabled");
                                $(".createupdate_btn").text("Loading...");
                            },
                            success: function(data) {
                                // alert(data);
                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;
                                if (!status) {
                                    url 	= '';
                                    $(".createupdate_btn").text("Error");
                                    console.log(error);
                                    // sweetalert(msg);
                                } else {
                                    if (msg == "already") {
                                        // Button Change Attribute
                                        // url 		= '';
                                        // sweetalert(msg);	
                                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                                        if (unique_id) {
                                            $(".createupdate_btn").text("Update");
                                        } else {
                                            $(".createupdate_btn").text("Save");
                                            // 			sweetalert(msg);	
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
                
                  $(document).ready(function () {
        // Initialize visibility and required attributes based on the initial GST option
        if ($('#gst_option').val() === 'yes') {
           
            $('#file').prop('required', true); // Make E Invoice mandatory
        } else {
            
            $('#file').prop('required', false); // Remove E Invoice mandatory requirement
        }

        // On GST option change
        $('#gst_option').on('change', function () {
            if (this.value === 'yes') {
              
                document.getElementById('old_gst_option').value = 'yes';
                $('#file').prop('required', true); // Make E Invoice mandatory
            } else {
            
                document.getElementById('old_gst_option').value = 'no';
                $('#file').prop('required', false); // Remove E Invoice mandatory requirement
            }
        });
    });
                
                
            </script>
