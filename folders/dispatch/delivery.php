<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
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
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        $unique_id = $_GET["unique_id"];
        $consignee_unique_id = $_GET["consignee_unique_id"];
        $dc_no = $_GET["dc_no"];
        $where = "po_form_unique_id='$unique_id' and consignee_unique_id='$consignee_unique_id' and dc_number='$dc_no' and is_delete='0'";
        $table = "dispatch_list";
        $columns = [
            "get_po_number(po_form_unique_id) as po_num",
            "po_date",
            "consignee",
            "get_address(consignee_unique_id) AS con_address",
            "invoice_no",
            "invoice_date",
            "dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
            "delivery_status",
            "pod_no",
            "cns_get_contact_number(consignee_unique_id) AS con_contact_number",
            "get_pincode(consignee_unique_id) AS con_pincode",
            "status",
            "po_unique_id",
            "invoice_auto_id",
            "po_form_unique_id",
            "unique_id",
            "consignee_unique_id",
            "dc_date",
            "delivery_date",
            "delivery_proof as delivery_proof",
            "pod_proof",
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


            $po_unique_id = $result_values[0]["po_unique_id"];
            $consignee_unique_id = $result_values[0]["consignee_unique_id"];
            $po_unique_id_get = $po_num;
            $po_form_unique_id = $result_values[0]["po_form_unique_id"];
            $invoice_no_get = $result_values[0]['invoice_no'];
            $delivery_status = $result_values[0]['delivery_status'];
            $mode_of_delivery = $result_values[0]["mode_of_delivery"];
            if ($mode_of_delivery == "1") {
                $mode_of_delivery = "hand";
            } else if ($mode_of_delivery == "2") {
                $mode_of_delivery = "Courier";
            }

            if ($delivery_status == "1") {
                $delivery_status = "Yes";
            }


            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));


            $consignee = $result_values[0]["consignee"];
            $con_address = $result_values[0]["con_address"];
            $invoice_no = $result_values[0]["invoice_no"];
            $con_contact_number = $result_values[0]["con_contact_number"];
            $orgDate1 = $result_values[0]["invoice_date"];
            $invoice_date = date("d-m-Y", strtotime($orgDate1));
            $stock_id = $result_values[0]["stock_id"];
            $con_pincode = $result_values[0]["con_pincode"];
            $orgDate2 = $result_values[0]["dispatch_date"];
            $dispatch_date = date("d-m-Y", strtotime($orgDate2));
            // $delivery_date = date("d-m-Y", strtotime($result_values[0]["delivery_date"]));
            $delivery_date = $result_values[0]["delivery_date"];
            $name_of_courier = $result_values[0]["name_of_courier"];
            $pod_no = $result_values[0]["pod_no"];
            $status = $result_values[0]["status"];
            $unique_id = $result_values[0]["unique_id"];
            $dc_date = $result_values[0]["dc_date"];



            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $po_form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($customer_data)) {
                $cusAdd = $customer_data[0]["bill_address"];
                $department = department_name($customer_data[0]["department"]);
                $customerName = $customer_data[0]["contact_name"];
                $customerContact = $customer_data[0]["contact_number"];
                $customerLan = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict = district_name_stock($customer_data[0]["district"]);
                $customerPincode = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
            $stmt->bindParam(':unique_id', $consignee_unique_id);
            $stmt->execute();

            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($consignee_data)) {
                $consigneeName = $consignee_data[0]["con_contact_name"];
                $consigneeContact = $consignee_data[0]["con_contact_number"];
                $consigneeLan = $consignee_data[0]["con_lan_num"];
                $consigneeAddress = $consignee_data[0]["con_address"];
                $consigneeDistrict = district_name_stock($consignee_data[0]["con_district"]);
                $consigneeState = con_state_name_stock($consignee_data[0]["con_state_name"]);
                $consigneePincode = $consignee_data[0]["con_pincode"];
                $consigneeZone = $consignee_data[0]["zone"];
            }

            $stmt->closeCursor(); // <--- this clears the result set
            $file_name = image_view("dispatch", $result_values[0]['unique_id'], $result_values[0]['delivery_proof']);
            $podfile_name = image_view("dispatch", $result_values[0]['unique_id'], $result_values[0]['pod_proof']);


            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}
function image_view($folder_name = "", $unique_id = "", $delivery_proof = "")
{
    // alert('hi');
    // echo $dc_file_name;
    $file_names = explode(',', $delivery_proof);
    $image_view = '';
    if ($delivery_proof) {
        foreach ($file_names as $file_key => $delivery_proof) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $delivery_proof);
            if ($delivery_proof) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $delivery_proof . '\')"><img src="uploads/' . $folder_name . '/' . $delivery_proof . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png" style="width: 27px;
    height: 38px;"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
    return $image_view;
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Dispatch</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="col-12">
                        <div class="row">
                            <!-- Customer Details -->
                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                    Customer Details</h6>
                                <h6 style="font-size: x-large; color: #506018;">
                                    <strong><?php echo $department ?></strong>
                                </h6>
                                <p class="mb-1"><?php echo $customerAddress ?>,
                                    <?php echo $customerDistrict ?><br><?php echo $customerState ?>,
                                    <?php echo $customerPincode ?>
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

                            <!-- Consignee Details -->
                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                    Consignee Details</h6>
                                <h6 style="font-size: x-large; color: #506018;">
                                    <strong><?php echo $consigneeName ?></strong>
                                </h6>
                                <p class="mb-1"><?php echo $consigneeAddress ?>,
                                    <?php echo $consigneeDistrict ?><br><?php echo $consigneeState ?>,
                                    <?php echo $consigneePincode ?>
                                </p>
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
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                    PO & Invoice Details</h6>
                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">PO Number</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $po_num; ?></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">PO Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?></div>
                                </div>
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
                                    <div class="col-6 "><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
                                </div>

                                <input type="hidden" name="consignee_unique_id" id="consignee_unique_id"
                                    value="<?php echo $consignee_unique_id; ?>">
                                <input type="hidden" name="po_form_unique_id" id="po_form_unique_id"
                                    value="<?php echo $po_form_unique_id; ?>">
                                <input type="hidden" name="invoice_no" id="invoice_no"
                                    value="<?php echo $invoice_no; ?>">
                                <input type="hidden" name="myno" id="myno" value="<?php echo $invoice_no_get; ?>">
                                <input type="hidden" name="dc_date" id="dc_date" value="<?php echo $dc_date; ?>">
                                <input type="hidden" name="dc_no" id="dc_no" value="<?php echo $dc_no; ?>">

                            </div>

                            <div class="col-md-3">
                                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                    Dispatch Details</h6>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Dispatch Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $dispatch_date ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Mode of Delivery</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $mode_of_delivery ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Courier / Person Name</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $name_of_courier ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">POD NO.</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $pod_no ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-2">
                        <div class="col-xl-2">
                            <label class="form-label">Delivery Status</label>
                            <input type="text" name="delivery_status" id="delivery_status" class="form-control"
                                value="<?php echo $delivery_status; ?>" readonly>
                        </div>

                        <div class="col-xl-2">
                            <label class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" class="form-control"
                                value="<?php echo $delivery_date; ?>" required>
                        </div>

                        <div class="col-xl-2">
                            <label class="form-label">Delivery Proof</label>
                            <div class="">
                                                    <?php echo !empty($file_name) ? $file_name : 'No file uploaded'; ?>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <label class="form-label">POD Attachment</label>
                            <input type="file" class="form-control" id="pdo_proof" name="pdo_proof[]"
                                accept="application/pdf,image/*">

                        </div>

                        <div class="col-xl-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="">
                                                     <?php if (!empty($podfile_name)) { ?>
                                                              <?php echo $podfile_name; ?>
                                                        <?php } ?>
                            </div>

                            <input type="hidden" name="status" id="status" value="<?php echo $status ?>">
                        </div>
                    </div>

                </form>
                <div class="modal-footer mt-3">
                    <?php echo btn_cancel($btn_cancel); ?>

                    <button type="button" onclick="modal()" class="btn btn-primary " style="margin-left: 14px;">Save
                        changes</button>
                </div>
                <!--</form>-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];

        // Set the max attribute of the PO Date input field
        document.getElementById("delivery_date").setAttribute("max", today);
    });
    $(document).ready(function () {

        get_po_no();
    });
    function get_po_no() {
        document.getElementById('myno').value = '';
        var invoice_no = document.getElementById('invoice_no').value;
        // alert(po_num);
        document.getElementById('myno').value = invoice_no;
    }

    function modal(unique_id = "") {
        var internet_status = is_online();
        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }

        var dc_no = document.getElementById('dc_no').value;
        var my_no = document.getElementById('myno').value;
        var delivery_date = document.getElementById('delivery_date').value;
        var pdo_s = document.getElementById("pdo_proof");
        var pdo_proof = document.getElementById("pdo_proof").value;
        if (delivery_date != '') {
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var status = document.getElementById('status').value;
            var data = new FormData();



            if (pdo_s != '') {
                for (var i = 0; i < pdo_s.files.length; i++) {
                    data.append("podfile", document.getElementById('pdo_proof').files[i]);
                }
            } else {
                data.append("pdo_proof", '');
            }

            data.append("my_no", my_no);
            data.append("dc_no", dc_no);
            data.append("delivery_date", delivery_date);
            data.append("po_form_unique_id", po_form_unique_id);
            data.append("consignee_unique_id", consignee_unique_id);
            data.append("action", "deleivery_pod");
            var is_form = form_validity_check("was-validated");
            if (is_form) {
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                var url = sessionStorage.getItem("list_link");
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',

                    success: function (data) {
                        var obj = JSON.parse(data);
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;
                        if (!status) {
                            url = '';
                            $(".createupdate_btn").text("Error");
                            console.log(error);
                        } else {
                            if (msg == "already") {
                                url = '';
                                $(".createupdate_btn").removeAttr("disabled", "disabled");
                                if (unique_id) {
                                    $(".createupdate_btn").text("Update");
                                }
                            }
                        }
                        sweetalert(msg, url);
                    },
                    error: function (data) {
                        alert("Network Error");
                    }
                });
            }
        } else {
            sweetalert("form_alert");
        }
    }

</script>
