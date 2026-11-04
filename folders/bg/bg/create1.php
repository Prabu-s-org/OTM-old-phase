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
            "form_main_unique_id" => $form_unique_id,
            "is_delete" => 0
        ];


        $table      =  "bg_creation_main";

        $columns    = [
            "bg_auto_id",
            "bg_month",
            "bg_num",
            "invoice_no",
            "invoice_qty",
            "invoice_value",
            "bg_percentage",
            "bg_value",
            "bg_date",
            "bg_validity_date",
            "bg_validity_end_date",
            "bank_name",
            "bank_attach_file",
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $bg_auto_id          = $result_values[0]["bg_auto_id"];
            $bg_month             = $result_values[0]["bg_month"];
            $bg_num             = $result_values[0]["bg_num"];
            $invoice_qty              = $result_values[0]["invoice_qty"];
            $invoice_value             = $result_values[0]["invoice_value"];
            $bg_percentage            = $result_values[0]["bg_percentage"];
            $bg_value              = $result_values[0]["bg_value"];

            $bg_date              = $result_values[0]["bg_date"];
            $bg_validity_date             = $result_values[0]["bg_validity_date"];
            $bg_validity_end_date            = $result_values[0]["bg_validity_end_date"];
            $bank_name              = $result_values[0]["bank_name"];
            $bank_attach_file              = $result_values[0]["bank_attach_file"];
            // $invoice_no_get              = $result_values[0]["invoice_no"];





            $arrayOfValues = explode(",", $value['invoice_no']);
            // $invoice_no_get              =   $arrayOfValues;
            $invoice_no = count($arrayOfValues);


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
                    <div class="row">
                        <div class="col-12">
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
                                        <input type="hidden" id="bg_auto_id" name="bg_auto_id" value="<?php echo  $result_values[0]["bg_auto_id"];  ?>">
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
                            </div><br>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">BG Number</label>
                                        <input type="text" id="bg_num" name="bg_num" class="form-control"  value="<?php echo $bg_num ?>" required>
                                        <input type="hidden" name="bg_no" id="bg_no" value="<?php echo $bg_auto_id ?>">

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

                                        <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" class="form-control" value="<?php echo $form_unique_id ?>">
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
        var bg_auto_id = document.getElementById('bg_auto_id').value;
        var bg_no = document.getElementById('bg_no').value;
        alert(bg_auto_id);

        var form_unique_id = document.getElementById('form_main_unique_id').value;

        var bg_num = document.getElementById('bg_num').value;
        var bg_date = document.getElementById('bg_date').value;
        var bg_month = document.getElementById('bg_month').value;
    
        var validity_date = document.getElementById('validity_date').value;
        var validity_end_date = document.getElementById('validity_end_date').value;
        var bank_name = document.getElementById('bank_name').value;


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
            data.append("validity_date", validity_date);
            //  data.append("con_contact_number", con_contact_number);
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
