<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";
$unique_id          = "";
$user_type              = "";
$under_user_type        = "";
$exp_under_user_type    = "";
$is_active          = 1;
// print_r("hi");die();
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id  = $_GET["unique_id"];
        // print_r( $unique_id);die();
        $consignee_unique_id=$_GET["consignee_unique_id"];

        $invoice_no = $_GET["invoice_no"];
        // $where      = [
        //     "po_form_unique_id" => $unique_id
        // ];
        $where      = "po_form_unique_id='$unique_id' and consignee_unique_id='$consignee_unique_id' and invoice_no='$invoice_no' and is_delete='0'";
        // print_r($where);die();
        $table      =  "dispatch_list";
        $columns    = [
            "po_num",
            "po_date",
            "consignee",
            // "con_address",
            "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id) AS con_address",
            "invoice_no",
            "invoice_date",
            "dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
            "pod_no",
            "(select con_contact_number from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id) AS con_contact_number",
            "(select con_pincode from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id ) AS con_pincode",

            "status",
            // "delivery_proof",
            "po_unique_id",
            // "(select po_unique_id from po_form where unique_id = $table.po_form_unique_id) AS po_unique_id",
            "invoice_auto_id",
            "po_form_unique_id",
            "unique_id",
            "consignee_unique_id",
            // "invoice_no",
            // "(select po_unique_id from po_form where unique_id = $table_dispatch.po_form_unique_id) AS po_unique_id",
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);die();
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $po_num             = $result_values[0]["po_num"];
            $po_unique_id            = $result_values[0]["po_unique_id"];
            $consignee_unique_id            = $result_values[0]["consignee_unique_id"];
            $po_unique_id_get =  $po_num ;
            // . ' / ' . $po_unique_id
            $po_form_unique_id            = $result_values[0]["po_form_unique_id"];
            $invoice_no_get = $result_values[0]['invoice_no'] ;
            // . ' / ' . $result_values[0]['invoice_auto_id']
            $mode_of_delivery           = $result_values[0]["mode_of_delivery"];
            if ($mode_of_delivery == "1") {
                $mode_of_delivery    = "hand";
            } else if ($mode_of_delivery == "2") {
                $mode_of_delivery    = "Courier";
            }
            // $po_date            = $result_values[0]["po_date"];

            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));


            $consignee   = $result_values[0]["consignee"];
            $con_address        = $result_values[0]["con_address"];
            $invoice_no         = $result_values[0]["invoice_no"];
            $con_contact_number        = $result_values[0]["con_contact_number"];
            $orgDate1 = $result_values[0]["invoice_date"];  
            $invoice_date= date("d-m-Y", strtotime($orgDate1));
            $stock_id        = $result_values[0]["stock_id"];
            $con_pincode           = $result_values[0]["con_pincode"];
            $orgDate2 = $result_values[0]["dispatch_date"];  
            $dispatch_date = date("d-m-Y", strtotime($orgDate2));
            // $delivery_proof         = $result_values[0]["delivery_proof"];
            $name_of_courier           = $result_values[0]["name_of_courier"];
            $pod_no           = $result_values[0]["pod_no"];
            $status           = $result_values[0]["status"];
            $unique_id          = $result_values[0]["unique_id"];
            // $status  = explode(",", $under_user_type);
            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
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
                            <div class="col-5">
                                <div class="row">
                                    <input type="hidden" name="consignee_unique_id" id="consignee_unique_id" value="<?php echo $consignee_unique_id; ?>">
                                    <input type="hidden" name="po_form_unique_id" id="po_form_unique_id" value="<?php echo $po_form_unique_id; ?>">
                                    <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $po_unique_id_get ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">PO Date</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $po_date ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Consignee</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $consignee ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Location</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $con_address ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Consignee Pincode</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $con_pincode ?></div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Invoice No</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $invoice_no_get; ?></div>
                                    <input type="hidden" name="myno" id="myno" value="<?php echo $invoice_no_get; ?>">
                                    <input type="hidden" id="invoice_no" name="my_no" value="<?php echo $result_values[0]['invoice_no'];?>"> 
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Invoice Date</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Dispatch Date</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $dispatch_date ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Mode of Delivery</label>
                                    </div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $mode_of_delivery ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Name of Courier / Person
                                            Name</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $name_of_courier ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">POD NO.</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $pod_no ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 head_po"> <label class="form-label">Consignee Contact No</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-7"><?php echo $con_contact_number ?></div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="row">
                                <div class="col-xl-3">
                                    <label class="form-label">Delivery
                                        Status</label>
                                    <select name="delivery_status" id="delivery_status" class="form-select mb-3" aria-label="Default select example" required>
                                        <option value="">Select Status </option>
                                        <option value="1">Yes</option>
                                        <!-- <option value="2">No</option> -->
                                    </select>
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Delivery
                                        Date</label>
                                    <input type="date" name="delivery_date" id="delivery_date" class="form-control" id="exampleInputdate" required>
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Delivery Proff Attachment</label>
                                    <input type="file" class="form-control" id="delivery_proof" name="delivery_proof[]" accept="application/pdf,image/*"
                                    
                                    >
                                </div>
                                <div class="col-xl-3">
                                    <div>
                                        <input type="hidden" name="status" id="status" value="<?php echo $status ?>">
                                        <!--<label for="exampleInputdate" class="form-label">Status-->
                                        </label>
                                        <!--    <select  class="form-select mb-3" aria-label="Default select example">-->
                                        <!--<option selected="">Select status </option>-->
                                        <!--    <option value="1">Approved</option>-->
                                        <!--</select>-->
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div>
                    </div>
                </form>
                <div class="modal-footer" >
                    <?php echo btn_cancel($btn_cancel); ?>
                    
                    <!-- <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                        data-bs-dismiss="modal()" onclick="modal()"><i class="ri-close-line me-1 align-middle"></i>
                                        Close</a> -->
                    <button type="button" onclick="modal()" class="btn btn-primary " style="margin-left: 14px;">Save changes</button>
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
function get_po_no(){
    document.getElementById('myno').value = '';
    var invoice_no = document.getElementById('invoice_no').value;
    // alert(po_num);
    document.getElementById('myno').value = invoice_no;
}
    function modal(unique_id = "") {
        // alert('hi');
        var internet_status = is_online();
        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        
        var invoice_no = document.getElementById('invoice_no').value;
        var my_no = document.getElementById('myno').value;
        var delivery_status = document.getElementById('delivery_status').value;
        var delivery_date = document.getElementById('delivery_date').value;
        var delivery_proof = document.getElementById('delivery_proof').value;
        var image_s = document.getElementById("delivery_proof");
        if (delivery_status != '' && delivery_date != '') {
            var po_form_unique_id = document.getElementById('po_form_unique_id').value;
            var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var status = document.getElementById('status').value;
            var data = new FormData();
            // alert('hi');
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("file", document.getElementById('delivery_proof').files[i]);
                }
            } else {
                data.append("delivery_proof", '');
            }
            data.append("my_no", my_no);
            data.append("delivery_status", delivery_status);
            data.append("delivery_date", delivery_date);
            data.append("invoice_no",invoice_no);
            data.append("po_form_unique_id", po_form_unique_id);
            data.append("consignee_unique_id", consignee_unique_id);
            data.append("status", status);
            data.append("action", "deleivery_status");
            var is_form = form_validity_check("was-validated");
            if (is_form) {
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
                    // beforeSend 	: function() {
                    // 	$(".createupdate_btn").attr("disabled","disabled");
                    // 	$(".createupdate_btn").text("Loading...");
                    // },
                    success: function(data) {
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
                                // Button Change Attribute
                                url = '';
                                $(".createupdate_btn").removeAttr("disabled", "disabled");
                                if (unique_id) {
                                    $(".createupdate_btn").text("Update");
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
        } else {
            sweetalert("form_alert");
        }
    }
    // }
    // 
</script>
