<!-- This file Only PHP Functions -->
<style>
    #update{
        background-color: skyblue;
        text-justify: auto;
        font-size: medium;
        padding: 6px 8px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
    }
</style>
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


        $table      =  "item_creation_sub";

        $columns    = [
            "item_code",
              "item_description",
              "item_specification",
              "brand",
              "product_category",
              "short_category",
              "rc_unit_price",
              "gst",
              "warranty_in_yrs",
            //   "item_specification",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
// print_r( $result_values );
        if ($result_values->status) {

            $result_values      = $result_values->data;

            $item_code          = $result_values[0]["item_code"];
            $item_description            = $result_values[0]["item_description"];
            $brand   = $result_values[0]["brand"];

            $product_category             = $result_values[0]["product_category"];
            $short_category             = $result_values[0]["short_category"];
            $rc_unit_price             = $result_values[0]["rc_unit_price"];
            $gst                     = $result_values[0]["gst"];
            $warranty_in_yrs           = $result_values[0]["warranty_in_yrs"];
            $item_specification   = $result_values[0]["item_specification"];
            $is_active              = $result_values[0]["is_active"];

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


// $state_type_options = state_option();
// $state_type_options = select_option($state_type_options, "Select State", $state_name);

// $district_type_options = district_option();
// $district_type_options = select_option($district_type_options, "Select District", $district_name);



// $active_status_options   = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Item Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Item Code </label>
                                       <input type="text" id="item_code" name="item_code" class="form-control" value="<?php echo $item_code; ?>" required>

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Item Description</label>
                                        <input type="text" id="item_description" name="item_description" class="form-control" value="<?php echo $item_description; ?>" required>
                                        
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Product Category</label>
                                        <input type="text" id="product_category" name="product_category" class="form-control" value="<?php echo $product_category; ?>" required>
                                        
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Short Category</label>
                                        <input type="text" id="short_category" name="short_category" class="form-control" value="<?php echo $short_category; ?>" required>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">RC Unit Price</label>
                                        <input type="text" id="rc_unit_price" name="rc_unit_price" class="form-control" value="<?php echo $rc_unit_price; ?>" required>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label  class="form-label">GST</label>
                                        <input type="text" id="gst" name="gst" class="form-control" value="<?php echo $gst; ?>" required>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Warranty In Years</label>
                                        <input type="text" id="warranty_in_yrs" name="warranty_in_yrs"class="form-control" value="<?php echo $warranty_in_yrs; ?>" >
                                        
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Item Specification</label>
                                        <input type="text" id="item_specification" name="item_specification"class="form-control" value="<?php echo $item_specification; ?>" >
                                        
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Brand</label>
                                        <input type="text" id="brand" name="brand"class="form-control" 
                                        value="<?php echo $brand; ?>" >
                                        
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $unique_id; ?>" >
                                        
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                   
                                  <?php  if($unique_id){ ?>
                                    <button type="submit" name="button" id="update" class="createupdate_btn" onclick="update_value()"  >Update</button>
                                    <?php } else{?>
                                    
                                    <button type="submit" name="button" class="createupdate_btn" onclick="update_value()" >save</button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>



<script>
function update_value() {
// alert();
// alert('hi');
	// var internet_status  = is_online();
	
	// if (!internet_status) {
	// 	sweetalert("no_internet");
	// 	return false;
	// }
	 var unique_id = document.getElementById("unique_id").value;
	
		var data 	 = $(".was-validated").serialize();
		data 		+= "&unique_id="+unique_id+"&action=items";
        // +"&item_code="+item_code+"&item_description="+item_description+"&product_category="+product_category
		// +"&short_category="+short_category+"&rc_unit_price="+rc_unit_price+"&gst="+gst+"&warranty_in_yrs="+warranty_in_yrs+
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url      = sessionStorage.getItem("list_link");
	
		// console.log(data);
		$.ajax({
			type 	: "POST",
			url: ajax_url,
			// url 	: 'folders/item_creation/list.php',
			data 	: data,
			beforeSend 	: function() {
				$(".createupdate_btn").attr("disabled","disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success		: function(data) {
                // alert(data);
	
				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;
	
				if (!status) {
					url 	= '';
					$(".createupdate_btn").text("Error");
					console.log(error);
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';
	
						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} else {
							$(".createupdate_btn").text("Save");
						}
					}
				}
	
				sweetalert(msg,url);
			},
			error 		: function(data) {
				alert("Network Error");
			}
		});
	
	
	// } else {
	// 	sweetalert("form_alert");
	// }
	}

</script>

<!-- <script src='https://code.jquery.com/jquery-3.6.1.min.js'></script> -->
<!-- <script src="jquery-3.5.1.min.js"></script>   -->
<!-- <script>

$('#state_name').on('change', function() {
   
   var state_name = $('#state_name').val();
   var data = "&state_name=" + state_name + "&action=district_type_option";

   var ajax_url = sessionStorage.getItem("folder_crud_link");
   $.ajax({
       type: "POST",
       url: ajax_url,
       data: data,
       success: function (data) {
           if (data) {
               $("#district_name").html(data);
           }
       }
   });

})

</script> -->
