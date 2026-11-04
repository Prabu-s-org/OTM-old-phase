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
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "bill_submission_main_table";

        $columns    = [
            "unique_id",
            "bill_submission_date",
            "e_no",
            "invoice_no"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $unique_id_val          = $result_values[0]["unique_id"];
            $e_no    = $result_values[0]["e_no"];
            $bill_sub_date          = $result_values[0]["bill_submission_date"];
            $invoice_no          = $result_values[0]["invoice_no"];

            
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


// $active_status_options   = active_status($is_active);

?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Elcot Entry</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Elcot Entry </li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Bill Submission Date</label>
                                        <input type="date" id="bill_sub_date" name="bill_sub_date" class="form-control" required value="<?php echo $bill_sub_date; ?>">
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-delimiter" class="form-label">E No</label>
                                        <input type="text" id="e_no" name="e_no" class="form-control" required value="<?php echo $e_no; ?>">
                                        
                                        <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $unique_id_val; ?>" required>
                                        <input type="hidden" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo $invoice_no; ?>" required>

                                    </div>
                                </div><!-- end col -->
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                    <?php if($e_no){?>
                                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="elcot_entry()">Update</button>
                                        <?php } else {?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="elcot_entry()">Save</button>

                                            <?php } ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<script>
 


function elcot_entry(){
  var internet_status = is_online();
  
           
       var unique_id= document.getElementById('unique_id').value;
        var e_no= document.getElementById('e_no').value;
        var bill_sub_date = document.getElementById('bill_sub_date').value;
       
        if(e_no || bill_sub_date){
        var data = "unique_id=" + unique_id + "&e_no=" + e_no + "&bill_sub_date=" + bill_sub_date;

        data += "&action=createupdate";
    
            var ajax_url = sessionStorage.getItem("folder_crud_link");
				var url      = sessionStorage.getItem("list_link");
        
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    beforeSend: function() {
                        $(".bg_add_update_btn").attr("disabled", "disabled");
                        $(".bg_add_update_btn").text("Loading...");
                    },
                    success: function(data) {
                        // alert(data);
                        var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    elcot_sub();

                        // sweetalert(msg, url);

                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        }else {
            sweetalert("form_alert");
        }
   
	}

    function elcot_sub(){

 var invoice_no= document.getElementById('invoice_no').value;
 alert(invoice_no);


// for (var i = 0; i < invoice_no.length; i++){
    // var e_no= document.getElementById('e_no').value;
    //     var bill_sub_date = document.getElementById('bill_sub_date').value;
    //          var invoice_no = document.getElementsByName('invoice_no[]');
    //          var invoice_value = document.getElementsByName('invoice_value[]');
    //          var invoice_qty = document.getElementsByName('invoice_qty[]');
    //              var invoice_no_val = invoice_no[i].value;
    //              var invoice_val = invoice_value[i].value;
    //              var invoice_qty_val = invoice_qty[i].value;

    //              var form_unique_id= document.getElementById('$invoice_no').value;
    //              var po_num= document.getElementById('po_num_val').value;
    //              var po_date = document.getElementById('po_date').value;
    //              var con_name= document.getElementById('con_name').value;
    //              var con_address= document.getElementById('con_address').value;
    //              var con_unique_id = document.getElementById('con_unique_id').value;
                 
                 
    //          var data = "form_unique_id=" + form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&con_name=" + con_name + "&con_address=" + con_address + "&con_unique_id=" + con_unique_id +"&invoice_no=" + invoice_no_val + "&invoice_qty=" + invoice_qty_val + "&invoice_val=" + invoice_val;

    //          data += "&action=bg_sub_addupdate";

    //          var ajax_url = sessionStorage.getItem("folder_crud_link");
    //          var url      = sessionStorage.getItem("list_link");

     
    //          $.ajax({
    //              type: "POST",
    //              url: ajax_url,
    //              data: data,
    //              beforeSend: function() {
    //                  $(".bg_add_update_btn").attr("disabled", "disabled");
    //                  $(".bg_add_update_btn").text("Loading...");
    //              },
    //              success: function(data) {
    //                  // alert(data);
  
    //              var obj = JSON.parse(data);
    //              var msg = obj.msg;
    //              var status = obj.status;
    //              var error = obj.error;
    //              // alert(msg);
    //      if (!status) {
    //          url 	= '';
    //          $(".createupdate_btn").text("Error");
    //          console.log(error);
    //      } else {
    //          if (msg=="already") {
    //              // Button Change Attribute
    //              url 		= '';

    //              $(".createupdate_btn").removeAttr("disabled","disabled");
    //              if (unique_id) {
    //                  $(".createupdate_btn").text("Update");
    //              } else {
    //                  $(".createupdate_btn").text("Save");
    //              }
    //          }
    //      }
    //      // location.reload();
    //              sweetalert(msg,url);
    //          },
    //          error: function(data) {
    //              alert("Network Error");
    //          }
    //      });
    //  }
}
	
    </script>
