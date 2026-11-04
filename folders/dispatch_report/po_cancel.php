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

        $unique_id  = $_GET['unique_id'];
        // $bill_no  = $_GET['bill_no'];
        $where      = [
            "unique_id" => $unique_id,
            "is_delete" =>0
            // "bill_no" => $bill_no
        ];


        // $table      =  "view_po_form_list";
        $table      =  "po_form";

        $columns    = [

            'reject_reason',
            'po_cancel_file',
            "po_cancel_file_orgname",
            "unique_id"
           
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $reject_reason          = $result_values[0]["reject_reason"];
            $po_cancel_file    = $result_values[0]["po_cancel_file"];
            $po_cancel_file_orgname    = $result_values[0]["po_cancel_file_orgname"];
            $unique_id    = $result_values[0]["unique_id"];
            
         
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
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Po Cancel</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Po Cancel</li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-3">
                                <label for="exampleInputdate" class="form-label">Reject Reason</label>
                                <!-- <div class="mb-3"> -->
                                    
                                    <textarea  id="reject_reason" name="reject_reason" class="form-control" required></textarea>
                                      <!-- </div> -->
                                </div>
                                <div class="col-xl-3" id="images">
                                    <div class="mb-3">
                                        <label class="form-label">Po Cancel Receipt </label>

                                        <input type="file" id="file" accept="application/pdf" name="file" class="form-control " required
                                        value="<?php echo $po_cancel_file; ?>">
                                    </div>
                                </div><!-- end col -->
                                <input type="hidden" id="unique_id"  name="unique_id" value="<?php echo $unique_id?>" >
                                <div class="form-group row ">
                                    <div class="col-md-12" align="right">
                                        <!-- Cancel,save and update Buttons -->
                                        <?php echo btn_cancel($btn_cancel); ?>
                                        <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                        <?php if ($unique_id) { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_cancel()">Update</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_cancel()">Save</button>

                                        <?php } ?>
                                    </div>
                                </div>



                            </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
</div>
</div>

<script>
    function po_cancel() {
        // alert("hii");
        var internet_status = is_online();

        var unique_id = document.getElementById('unique_id').value;
        // alert(unique_id)
        var reject_reason = document.getElementById('reject_reason').value;

        // alert(reject_reason);
       
       

        if(reject_reason != ''){

    //    alert('hi');
       var data = new FormData();
       var image_s = document.getElementById("file");
        if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("file", document.getElementById('file').files[i]);

            }
        } else {
            data.append("file", '');
        }
        data.append("unique_id", unique_id);
        data.append("reject_reason", reject_reason);
    
        data.append("action", "po_cancel_add_update");
        var is_form = form_validity_check("was-validated");
        
        //  if (is_form) {
        // var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url = sessionStorage.getItem("list_link");

        //  if(payment_date || payment_status){
        //  var data = "unique_id=" + unique_id +"&payment_date=" + payment_date + "&payement_receive=" + payement_receive+ "&bill_no=" + bill_no + "&payment_status=" + payment_status;

        //  data += "&action=createupdate";

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

            beforeSend: function() {
                $(".bg_add_update_btn").attr("disabled", "disabled");
                $(".bg_add_update_btn").text("Loading...");
            },
            success: function(data) {
                //  alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                // elcot_sub();
                // alert(msg);
                sweetalert(msg, url);

            },
            error: function(data) {
                alert("Network Error");
            }
        });
         }
         else {
        	 sweetalert("form_alert");
         }

    }

    // function print(file_name) {
    //     // 
    //     window.location = 'uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    // }

    // function print_pdf(file_name) {

    //     onmouseover = window.open('uploads/payment/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
</script>
