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
        $where      = [
            "consignee_unique_id" => $unique_id_1
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
            "form_main_unique_id"
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
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
                            "consignee_unique_id" => $unique_id_1
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
                            $file_name         = $result_values_data[0]["file_name"];
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
                            <table id="bill_datatable" class="table table-bordered nowrap table-striped align-middle"
                               >
                                <thead>
                                    <tr>
                                        <th>Selection</th>
                                        <th>S No</th>
                                        <th>BG.No / BG.ID</th>
                                        <th>BG Date</th>
                                        <th>BG Value</th>
                                        <th>PO Number </th>
                                        <th>PO Date </th>
                                        <th>Consignee</th>
                                        <th>Location</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                    </tr>
                                </thead>
                                <tbody id="data_table">
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
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    onclick="po_invoice_create()">Save</button>
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
function po_invoice_create() {
    var internet_status = is_online();
    var bank_req = document.getElementById('bank_required').value;
    //    alert(bank_req);
    // var bg_num= document.getElementsByName('bg_num[]');
    if (bank_req == 'off') {
        const checked = document.querySelectorAll('.myCheck:checked');
        var invoice_qty_total = [];
        var checkbox_qty_amt = [];
        var invoice_tot = [];
        //  const checked = document.querySelectorAll('.myCheck:checked');
        for (var i = 0; i < checked.length; i++) {
            var invoice_qty = document.getElementsByName('invoice_qty[]');
            var invoice_no = document.getElementsByName('invoice_no[]');

            var invoice_value = document.getElementsByName('invoice_value[]');
            var invoice_value_val = invoice_value[i].value;
            var invoice_qty_val = invoice_qty[i].value;
            
            invoice_tot.push(invoice_no[i].value);
            // amount of value calculate
            var amount = parseFloat(invoice_value_val);
            if (!isNaN(amount)) {
                checkbox_qty_amt.push(amount);
                var sum_of_checkbox_value = checkbox_qty_amt.reduce(function(total, current) {
                    return total + current;
                }, 0);
            }
            // total qty calculate
            var number = parseFloat(invoice_qty_val);
            if (!isNaN(number)) {
                invoice_qty_total.push(number);
                var sum_of_invoice_qty = invoice_qty_total.reduce(function(total, current) {
                    return total + current;
                }, 0);
            }
            var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
            var po_num = document.getElementById('po_num').value;
            var po_date = document.getElementById('po_date').value;
            var con_contact_name = document.getElementById('con_contact_name').value;
            var con_address = document.getElementById('con_address').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var invoice_date = document.getElementById('invoice_date').value;
            // var claim_amount = document.getElementById('claim_amount').value;
        }
        invoice_nos = invoice_tot.join(",");
        var total_amount = sum_of_checkbox_value;
        var total_invoice_qty = sum_of_invoice_qty;
        var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date +
            "&con_contact_name=" + con_contact_name + "&con_address=" + con_address + "&invoice_no=" + invoice_nos +
            "&invoice_date=" + invoice_date + "&consignee_unique_id=" + consignee_unique_id + "&invoice_value=" +
            total_amount + "&invoice_qty=" + total_invoice_qty;
        // + "&checkbox_qty=" + checkbox_qty_val
        //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;+ "&claim_amount=" + claim_amount
        data += "&action=demo";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function(data) {
                // alert(data);
            },
            error: function(data) {
                alert("Network Error");
            }
        });
        bill_creation_sub();
        
    } else if (bank_req == 'on') {
        const checked = document.querySelectorAll('.myCheck:checked');
        for (var i = 0; i < checked.length; i++) {
            var invoice_qty = document.getElementsByName('invoice_qty[]');
            var invoice_no = document.getElementsByName('invoice_no[]');
            var invoice_value = document.getElementsByName('invoice_value[]');
            var invoice_value_val = invoice_value[i].value;
            var invoice_qty_val = invoice_qty[i].value;
            var invoice_nos = invoice_no[i].value;
            var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
            var po_num = document.getElementById('po_num').value;
            var po_date = document.getElementById('po_date').value;
            var invoice_date_val = document.getElementById('invoice_date').value;
            // alert(invoice_date_val);
            var bg_num = document.getElementsByName('bg_num[]');
            var bg_id = document.getElementsByName('bg_id[]');
            var bg_date = document.getElementsByName('bg_date[]');
            var bg_value = document.getElementsByName('bg_value[]');
            // var claim_amount = document.getElementsByName('claim_amount[]');
            var bg_num_val = bg_num[i].value;
            var bg_id_val = bg_id[i].value;
            var bg_date_val = bg_date[i].value;
            var bg_value_val = bg_value[i].value;
            // var claim_amount_val = claim_amount[i].value;
            var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date +
                "&invoice_no=" + invoice_nos + "&invoice_value=" + invoice_value_val + "&invoice_qty=" +
                invoice_qty_val + "&bg_num=" + bg_num_val + "&bg_id=" + bg_id_val + "&bg_date="+bg_date_val + "&invoice_date=" +
                invoice_date_val + "&bg_value=" + bg_value_val;
            data += "&action=demo";
            // + "&claim_amount=" + claim_amount_val
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                    $(".po_delivery_add_update_btn").text("Loading...");
                },
                success: function(data) {
                    // alert(data);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        }
        bill_creation_sub1();
    }
}
function bill_creation_sub() {
    const checked = document.querySelectorAll('.myCheck:checked');
        for (var i = 0; i < checked.length; i++) {
    // var stock_qty = document.getElementsByName('stock_qty[]');
    // const checkbox_qty = document.querySelectorAll('.myCheck:checked');
    //  var checkbox_qty_length = checkbox_qty.length;
    // alert(checkbox_qty);
    // for (var i = 0; i < checkbox_qty.length; i++) {
        // alert(checkbox_qty.length);
        // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
        // var checkbox_qty_val = checkbox_qty[i].value;
        //     alert(checkbox_qty_val);
        var invoice_value = document.getElementsByName('invoice_value[]');
        var invoice_no = document.getElementsByName('invoice_no[]');
        var invoice_qty = document.getElementsByName('invoice_qty[]');
        // var checkbox_qty_val = checkbox_qty[i].value;
        var invoice_no_val = invoice_no[i].value;
        var invoice_val = invoice_value[i].value;
        var invoice_qty_val = invoice_qty[i].value;
        var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
        var po_num = document.getElementById('po_num').value;
        var po_date = document.getElementById('po_date').value;
        var con_contact_name = document.getElementById('con_contact_name').value;
        var con_address = document.getElementById('con_address').value;
        var consignee_unique_id = document.getElementById('consignee_unique_id').value;
        var invoice_date = document.getElementById('invoice_date').value;
        // alert(invoice_date);
        // var consignee_unique_id= document.getElementById('consignee_unique_id').value;
        var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" +
            invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num +
            "&po_date=" + po_date + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +
            "&consignee_unique_id=" + consignee_unique_id;
        // + "&checkbox_qty=" + checkbox_qty_val
        data += "&action=bill_submission_add_update";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function(data) {
                // alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                // alert(msg);
                if (!status) {
                    // url = '';
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
                // location.reload();
                sweetalert(msg, url);
            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }
}
function bill_creation_sub1() {
    const checkbox_qty = document.querySelectorAll('.myCheck:checked');
    // alert(checkbox_qty.length);
    for (var i = 0; i < checkbox_qty.length; i++) {
        // alert(checkbox_qty.length);
        var invoice_no = document.getElementsByName('invoice_no[]');
        var invoice_no_val = invoice_no[i].value;
        var invoice_no_count = invoice_no_val.split(',');
        //    var invoice_no_count = numberArray.length;
        for (var k = 0; k <= invoice_no_count.length; k++) {
            var invoice_no_data = invoice_no_count[k];
            // alert(invoice_no_count[k]);
            var data = "invoice_no=" + invoice_no_data;
            data += "&action=bill_sub_table";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                    $(".po_delivery_add_update_btn").text("Loading...");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    // alert(msg);
                    if (!status) {
                        // url = '';
                        $(".createupdate_btn").text("Error");
                    } else {
                        if (msg == "already") {
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
        }
    }
}
</script>
