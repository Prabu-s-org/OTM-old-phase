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
$status_pr       = "Processing";

if (isset($_GET["unique_id"])) {
	if (!empty($_GET["unique_id"])) {

		// $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
		// $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

		$unique_id  = $_GET["unique_id"];
		$where      = [
			"unique_id" => $unique_id
		];


		$table      =  "view_stock_position_processing";

		$columns    = [
			"po_unique_id",
			"po_num",
            "po_date",
            // "department",
             "(SELECT department FROM department_creation AS department_creation WHERE department_creation.unique_id = ".$table.".department ) AS department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name ) AS executive_name",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            "status",
            //  "(SELECT stock_id FROM view_stock_position_processing WHERE view_stock_position_processing.unique_id = ".$table.".unique_id ) AS stock_id",
            "stock_id",
            "unique_id"
		];

		$table_details   = [
			$table,
			$columns
		];

		$result_values  = $pdo->select($table_details, $where);
// 		print_r($result_values);

		if ($result_values->status) {

			$result_values      = $result_values->data;

			$po_unique_id          = $result_values[0]["po_unique_id"];
			$po_num    = $result_values[0]["po_num"];
			$po_date          = $result_values[0]["po_date"];
			$department          = $result_values[0]["department"];
			$executive_name    = $result_values[0]["executive_name"];
			$no_of_consignee          = $result_values[0]["no_of_consignee"];
			$no_of_po          = $result_values[0]["no_of_po"];
			$qty    = $result_values[0]["qty"];
			$net_value          = $result_values[0]["net_value"];
			$status          = $result_values[0]["status"];
		    $stock_id          = $result_values[0]["stock_id"];
			$under_user_type    = $result_values[0]["under_user_type"];
			$main_unique_id          = $result_values[0]["unique_id"];

            $exe_unique_id = $result_values[0]["executive_name"];

			// if($status == 0){
			// 	print_r('ji');
			// }

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


$active_status_options   = active_status($is_active);

$approval_option      = [
    // "0" => [
    //     "unique_id" => "0",
    //     "value"     => "Pending",
    // ],
    "Processing" => [
        "unique_id" => "1",
        "value"     => "Processing",
    ],
    "Completed" => [
        "unique_id" => "2",
        "value"     => "Completed",
    ],
];
$approval_options     = select_option($approval_option, "Select", $status_pr);



?>

<style>
	.head_po {
		font-size: .875rem;
		margin-bottom: .3125rem;
	}
</style>

<div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Stock Position - Processing</h4>
            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                     <li class="breadcrumb-item active"> Stock Position </li>
                  </ol>
            </div>

         </div>
      </div>   
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body mt-1">
                <form class="was-validated" autocomplete="off">
				<div class="col-12">
						<div class="row">
							<div class="col-6">
								<div class="row">
									<div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $po_num;?></div>
								</div>
								<div class="row">
									<div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $po_date;?></div>
								</div>
								<div class="row">
								   <div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">Excutive Name</label></div>
								   <div class="col-xl-1">:</div>
								   <div class="col-xl-8"><?php echo $executive_name; ?></div>
								</div>
								<div class="row">
								   <div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">No of Consignee</label></div>
								   <div class="col-xl-1">:</div>
								   <div class="col-xl-8"><?php echo $no_of_consignee; ?></div>
							    </div>
								
							</div>
							
							<div class="col-6">
								<div class="row">
								   <div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">No of Items in PO</label></div>
								   <div class="col-xl-1">:</div>
								   <div class="col-xl-8"><?php echo $no_of_po; ?></div>
							    </div>
								<div class="row">
								   <div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">QTY</label></div>
								   <div class="col-xl-1">:</div>
								   <div class="col-xl-8"><?php echo $qty; ?></div>
							    </div>
								<div class="row">
								   <div class="col-xl-3 head_po"> <label for="main_screen" class="form-label">Net Value</label></div>
								   <div class="col-xl-1">:</div>
								   <div class="col-xl-8"><?php echo $net_value; ?></div>
							    </div>
							</div>
							<div class="col-6">
							<div class="row">
									<div class="col-xl-4 head_po"><label for="main_screen" class="form-label"><b>Stock Id</b></label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><b><?php echo $stock_id; ?></b></div>
								</div>
                            </div>
						</div>
						</div>
						
						<div class="row">
                            <div class="col-12 mt-3">											
								<div class="table-responsive mb-4">
                                    <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
										<thead class="table-light">
											<tr>
												<th>S.No</th>
												<th scope="col">Item Code</th>
												<th scope="col">Item Details</th>
												<th scope="col">QTY</th>
												<th scope="col">Billed QTY</th>
												<th scope="col">Request to Bill QTY </th>
												<th scope="col">Remaining QTY </th>
												
											</tr>
										</thead>
										<tbody>
														
									<?php

						// $where2 = "form_main_unique_id = '".$main_unique_id."'";

						$get_stock_position   = get_stock_position($main_unique_id);
						// print_r($get_stock_position);
						foreach($get_stock_position as $key => $form_val){
							// print_r($form_val);
			
								// print_r('hello');
								$where1 = "form_main_unique_id = '".$form_val['form_main_unique_id']."'";
								$table1      =  "stock_position";
						
								$columns1    = [
									"item_code",
									"product",
									"item_qty",
									"billed_qty",
									"form_main_unique_id",
									"total_qty",
									"net_value",
									"po_num",
									"po_date",
									"executive_name",
									"no_of_consignee",
									"no_of_item",
									"product_unique_id",
									"stock_qty",
									"remaining_qty",
									"unique_id",
									"stock_id"
								   ];
						
								$table_details1   = [
									$table1,
									$columns1
								];
							
				// 			}
						
                        $values_product  = $pdo->select($table_details1, $where1);
                        // print_r($values_product);
                            if ($values_product->status) {
               
                                             $product_array      = $values_product->data;
                               
                                foreach($product_array as $key => $product) {
                                                   $product[ 's_no' ] = $sno + 1;
									if($product['product_unique_id']){
													// print_r($product['product_unique_id']);
													$remaining_qty = $product[ 'item_qty' ] - $product['billed_qty'];
													if($product['billed_qty']){
														$billed_qty = $product['billed_qty'];
													}else{
														$billed_qty = '0';
													}
					?>
										<tr>
											<td><?php echo $product[ 's_no' ]?></td>
											<td><?php echo $product[ 'item_code' ]?></td>
											<td><?php echo $product[ 'product' ]?></td>
                                            <td><?php echo $product[ 'item_qty' ]?></td>
											<td><?php echo $billed_qty;?></td>
											<td><?php echo $product['stock_qty']?></td>
											<td><?php echo $product['remaining_qty']?></td>
										
										</tr>
							<?php
                            $sno ++;
						}
					}
                }
			}
            
										?>
									</tbody>
								</table>

								</div>
								
								<div class="col-lg-2">
                            <select name="status" id="status" class="select2 form-control" aria-label="Default select example" required="">
                                <!--<select class="form-select mb-3"  aria-label="Default select example" required="">-->-->
                                    <!--<option selected="">Select Status </option>-->
                                    <!--<option value="2">Processing</option>-->
                                    <!--<option value="3">Completed</option>-->
                                    <?php echo $approval_options;?>
                                </select>
                            
                            </div>
                            	<div class="form-group row ">
								<div class="col-md-12" align="right">
									<!-- Cancel,save and update Buttons -->
									<?php echo btn_cancel($btn_cancel); ?>
									<!--<?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
								<button type="button" class="btn btn-primary " onclick="update()">Update</button>
								
								</div>
							</div>
								
                      
						</div>
					</div>
			
				</form>

			</div> <!-- end card-body -->
		</div> <!-- end card -->
	</div><!-- end col -->
</div>
</div>

<script>
	function update(unique_id=''){
		alert('hi');
	var internet_status = is_online();
	if (!internet_status) {
		sweetalert("no_internet");
		return false;
	}

    // var table_count =  $("#expense_table_count").val();

// 	if (table_count == "0") {
// 		sweetalert("custom", "", "", "Mimimun one Entry Needed");
// 		return false;
// 	}

// 	var is_form1 = form_validity_check("was-validated","expense_creation_form_main");
// 	var is_form2 = form_validity_check("was-validated","expense_creation_form_bottom");

// 	if ((is_form1) && (is_form2)) {

		var data = $(".was-validated").serialize();
		data += "&unique_id=" + unique_id + "&action=createupdate";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url      = sessionStorage.getItem("list_link");

		// console.log(data);
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			/* cache       : false,
			 contentType : false,
			 processData : false,
			 method      : 'POST',*/
			beforeSend: function () {
				$(".createupdate_btn").attr("disabled", "disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success: function (data) {

				var obj = JSON.parse(data);
				var msg = obj.msg;
				var status = obj.status;
				var error = obj.error;
				// var unique_id = obj.unique_id;

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
						} else {
							$(".createupdate_btn").text("Save");
						}


					}
				}
				sweetalert(msg, url);
			},
			error: function (data) {
				alert("Network Error");
			}
		});

// 	} else {
// 		sweetalert("form_alert");
// 	}
}
   
// 	}
</script>

