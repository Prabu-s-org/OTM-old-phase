<!-- This file Only PHP Functions -->
<?php include 'function.php';

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
        $form_unique_id  = $_GET["form_unique_id"];
        $where      = [
            "unique_id" => $unique_id,
            "form_main_unique_id" => $form_unique_id
        ];


        $table      =  "bg_creation_main";

       $columns = [
    "bg_auto_id",
    
    // Use subquery with LIMIT 1 instead of GROUP BY for single value
    "(SELECT bg_month 
      FROM product_details_sub 
      WHERE product_details_sub.form_main_unique_id = '$form_unique_id' 
      ORDER BY bg_required DESC 
      LIMIT 1) AS bg_month",

    "bg_num",
    "invoice_no",
    "invoice_qty",
    "invoice_value",
    "bg_percentage",

    // Same as above: corrected bg_value
    "(SELECT bg_percen 
      FROM product_details_sub 
      WHERE product_details_sub.form_main_unique_id = '$form_unique_id' 
      ORDER BY bg_required DESC 
      LIMIT 1) AS bg_per",
    "bg_date",
    "bg_validity_date",
    "bg_validity_end_date",
    "bank_name",
    "bank_attach_file",
    "bg_value",
     "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.po_num = $table.po_num 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",

             "(SELECT unique_id from consignee_details_sub where form_main_unique_id = $table.form_main_unique_id LIMIT 1) AS cons_unique_id",
             "po_num",
             "DATE_FORMAT(po_date,'%d-%m-%Y') as po_date"
];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
        // print_r( $result_values );

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $bg_auto_id          = $result_values[0]["bg_auto_id"];
            $bg_month             = $result_values[0]["bg_month"];
            $bg_num             = $result_values[0]["bg_num"];
            $invoice_qty              = $result_values[0]["invoice_qty"];
            $invoice_value             = $result_values[0]["invoice_value"];

            $upd_invoice_value     = moneyFormatIndia2($result_values[0]["invoice_value"]);

            $bg_percentage            = $result_values[0]["bg_percentage"];
            $bg_per              = $result_values[0]["bg_per"];
            $bg_date              = $result_values[0]["bg_date"];
            $bg_validity_date             = $result_values[0]["bg_validity_date"];
            $bg_validity_end_date            = $result_values[0]["bg_validity_end_date"];
            $bank_name              = $result_values[0]["bank_name"];
            $bank_attach_file              = $result_values[0]["bank_attach_file"];
                $ledger_name              = $result_values[0]["ledger_name"];
            
            $bg_value              = $result_values[0]["bg_value"];


            $upd_bg_value  = moneyFormatIndia2($result_values[0]["bg_value"]);

             $po_num             = $result_values[0]["po_num"];

             $po_date             = $result_values[0]["po_date"];

               $consignee_unique_id              = $result_values[0]["cons_unique_id"];

               $invoice_nos              = $result_values[0]["invoice_no"];

//  $bg_value = $invoice_value * ($bg_per / 100);



            $arrayOfValues = explode(",", $value['invoice_no']);
            // $invoice_no_get              =   $arrayOfValues;
            $invoice_no = count($arrayOfValues);





            
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
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


?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0"><b>BG Update Form</b></h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                   
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
                                <!-- <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">Invoice No</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $invoice_no; ?></div>
                                </div> -->


                                <!-- <div class="row mb-1">
                                    <div class="col-5 text-body-secondary">Invoice Date</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo date('d-m-Y', strtotime($invoice_date)) ?></div>
                                </div> -->
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
                                    <div class="col-5 text-body-secondary">BG ID</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_auto_id ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">BG Month</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $bg_month; ?></div>
                                       <input type="hidden" id="bg_month" name="bg_month" value="<?php echo $bg_month; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">BG Value</div>
                                    <div class="col-1">:</div>

                                    <div class="col-6 "><?php echo $upd_bg_value; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-5 text-body-secondary">Invoice Count.</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $invoice_no ?></div>
                                    <input type="hidden" id="bg_auto_id" name="bg_auto_id" value="<?php echo  $result_values[0]["bg_auto_id"];  ?>">
                                </div>

                                 <div class="row">
                                    <div class="col-5 text-body-secondary">Total Invoice Value</div>
                                    <div class="col-1">:</div>
                                    <div class="col-6 "><?php echo $upd_invoice_value; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- 
                    <div class="row mt-4">

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <input type="hidden" id="bg_month" name="bg_month" value="<?php echo $bg_month ?>">
                                        <div class="col-md-3">BG Month</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $bg_month ?></div>
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">BG ID</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $bg_auto_id ?></div>
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Count</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_no ?></div>
                                        
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Total Invoice Value</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_value ?></div>
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">BG Value</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $bg_value ?></div>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Customer Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $ledger_name; ?></div>

                                    </div>
                                </div>

                            </div>
                            </div> -->
                            
                            
                            <div class="row mt-4">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">BG Number</label>
                                        <input type="text" id="bg_num" name="bg_num" class="form-control"  value="<?php echo $bg_num ?>" required>
                                        <input type="hidden" name="bg_no" id="bg_no" value="<?php echo $bg_auto_id ?>">

                                        <input type="hidden" name="bg_value" id="bg_value" value="<?php echo $bg_value;?>">

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">BG Date</label>
                                        <input type="date" id="bg_date" name="bg_date" class="form-control"  value="<?php echo $bg_date ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Validity Startdate</label>
                                        <input type="date" id="validity_date" name="validity_date" class="form-control" value="<?php echo $bg_validity_date ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Validity Enddate</label>
                                        <input type="date" id="validity_end_date" name="validity_end_date" class="form-control" value="<?php echo $bg_validity_end_date ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" id="bank_name" name="bank_name" multiple="multiple" class="form-control" value="<?php echo $bank_name ?>" required>
                                        <input type="hidden" id="invoice_nos" name="invoice_nos" class="form-control" value="<?php echo $invoice_nos ?>" >

                                        <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" class="form-control" value="<?php echo $form_unique_id; ?>">
                                        <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $unique_id ?>">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Attach proof</label>
                                        <input type="file" id="bank_attach_file" name="bank_attach_file[]" class="form-control" value="<?php echo $bank_attach_file?>">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="bg_update()">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<script>
    function bg_update() {

        var unique_id = document.getElementById('unique_id').value;
        // alert(unique_id);
        var bg_auto_id = document.getElementById('bg_auto_id').value;
        // alert(bg_auto_id);
        var bg_no = document.getElementById('bg_no').value;
        //  alert(bg_no);
        

        var form_unique_id = document.getElementById('form_main_unique_id').value;

        // alert(form_unique_id);

        var bg_num = document.getElementById('bg_num').value;

        // alert(bg_num);
        var bg_date = document.getElementById('bg_date').value;

        // alert(bg_date);
        var bg_month = document.getElementById('bg_month').value;

        // alert(bg_month);
        var bg_value = document.getElementById('bg_value').value;

        // alert(bg_value);
    
        var validity_date = document.getElementById('validity_date').value;
        var validity_end_date = document.getElementById('validity_end_date').value;
        var bank_name = document.getElementById('bank_name').value;

         var invoice_nos = document.getElementById('invoice_nos').value;
         


        var test_doc = document.getElementById('bank_attach_file').value;

        var image_s = document.getElementById("bank_attach_file");



        if (bg_num && bg_date && validity_date && validity_end_date && bank_name) {

            var data = new FormData();

            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("test_file", document.getElementById('bank_attach_file').files[i]);
                }
            } else {

                data.append("test_doc", '');

            }
            data.append("form_unique_id", form_unique_id);
            data.append("bg_auto_id", bg_auto_id);
            data.append("bg_no", bg_no);
            data.append("bg_num", bg_num);
            data.append("bg_date", bg_date);
            data.append("bg_month", bg_month);
            data.append("bg_value", bg_value);
            data.append("validity_date", validity_date);
             data.append("invoice_nos", invoice_nos);
            data.append("validity_end_date", validity_end_date);
            data.append("bank_name", bank_name);

            data.append("unique_id", unique_id);
            data.append("action", "bg_main_update");

            // // if(){
            //     var data = "form_unique_id=" + form_unique_id + "&unique_id=" + unique_id + "&bg_num=" + bg_num + "&bg_date=" + bg_date + "&validity_date=" + validity_date + "&validity_end_date=" + validity_end_date + "&bank_name=" + bank_name;

            //     data += "&action=bg_main_update";
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
			beforeSend: function () {
				// 	$(".createupdate_btn").attr("disabled","disabled");
				// 	$(".createupdate_btn").text("Loading...");
			},

                success: function(data) {
                    //  alert(data);
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;

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
</script>
