<!-- This file Only PHP Functions -->
<?php include 'function.php'; 
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';?>
<style>
	.select2-container {
    z-index: 10000; /* Ensure a high z-index value */
}

	/* appearance: auto; */


</style>
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
			"form_main_unique_id" => $unique_id
		];
		$table      =  "stock_position_main";
		$columns    = [
			"stock_id",
			"stock_date",
			"po_num",
			"po_unique_id",
			"po_date",
			"department",
			"executive_name",
			"no_of_con",
			"no_of_item",
			"stock_qty",
			"stock_value",
			"form_main_unique_id",
			"(SELECT sum(invoice_qty) FROM invoice_creation WHERE invoice_creation.po_unique_id = ".$table.".form_main_unique_id and invoice_creation.is_delete='0') AS invoice_qty", 
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
			$po_unique_id          = $result_values[0]["po_unique_id"];
			$po_num    = $result_values[0]["po_num"];
			$po_date          = $result_values[0]["po_date"];
			$department          = $result_values[0]["department"];
			$executive_name    = $result_values[0]["executive_name"];
			$no_of_consignee          = $result_values[0]["no_of_con"];
			$no_of_po          = $result_values[0]["no_of_item"];
			$qty    = $result_values[0]["stock_qty"];
			$invoice_qty    = $result_values[0]["invoice_qty"];

			$net_value          = $result_values[0]["stock_value"];
			$status          = $result_values[0]["status"];
			$stock_id          = $result_values[0]["stock_id"];
			$under_user_type    = $result_values[0]["under_user_type"];
			$main_unique_id          = $result_values[0]["form_main_unique_id"];
			$exe_unique_id = $result_values[0]["executive_name"];

			$remaining_qty = $qty-$invoice_qty;
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

$consignee_type_options = consignee_option($unique_id);
$consignee_type_options = select_option2($consignee_type_options, "Select consignee", $unique_id);
// print_R($consignee_type_options);die();
?>
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Invoice - Stock assign to Consignee</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
					<li class="breadcrumb-item active"> Invoice </li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card mt-4">
			<div class="card-body ">
				<form class="was-validated" autocomplete="off">
					<div class="col-12">
						<div class="row">
							<div class="col-6">
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $po_num; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $po_date; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">Excutive Name</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $executive_name; ?></div>
								</div>
								<input type="hidden" name="no_of_consignee" id="no_of_consignee" value="<?php echo  $no_of_consignee;?>">
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">No of Consignee</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $no_of_consignee; ?></div>
								</div>
							</div>
							<div class="col-6">
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">No of Items in PO</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $no_of_po; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">Stock QTY</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $qty; ?></div>
									
								</div>
								
								<div class="row">
									<div class="col-xl-3 head_po"> <label class="form-label">Net Value</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-8"><?php echo $net_value; ?></div>
								</div>
							</div>
							<!-- <div class="col-6">
								<div class="row">
									<div class="col-xl-3 head_po"><label class="form-label"><b>Stock Id</b></label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-4"><b><?php echo $stock_id; ?></b></div>
								</div>
							</div> -->
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
											<!--<th scope="col">QTY</th>-->
											<th scope="col">Avaliable QTY </th>
											<th scope="col">Unit Price</th>
											<th scope="col">Total Value </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$get_stock_position   = get_stock_position($main_unique_id);
										foreach ($get_stock_position as $key => $form_val) {
											$where1 = "form_main_unique_id = '" . $form_val['form_main_unique_id'] . "' AND is_delete='0'";
											$table1      =  "stock_position";
											$columns1    = [
												// "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table1.item_code)as item_code",
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
												"stock_id",
												"product_tax",
												"(SELECT unit_price FROM product_details_sub WHERE product_details_sub.unique_id = " . $table1 . ".product_unique_id and is_delete=0 ) AS unit_price",
											];
											$table_details1   = [
												$table1,
												$columns1
											];
											$values_product  = $pdo->select($table_details1, $where1);
											// print_r($values_product);die();
											if ($values_product->status) {
												$product_array      = $values_product->data;
												foreach ($product_array as $key => $product) {
													$s_no = $sno + 1;
													if ($product['product_unique_id']) {
														$product_amt = $product['stock_qty'] * $product['unit_price'];
														$product_per = $product_amt * $product['product_tax'] / 100;
														$total_pro_amt = $product_amt + $product_per;
										?>
														<tr>
															<td><?php echo $s_no ?></td>
															<td><?php echo $product['item_code'] ?></td>
															<td><?php echo $product['product'] ?></td>
															<td><?php echo $product['stock_qty'] ?></td>
															<td><?php echo $product['unit_price'] ?></td>
															<td><?php echo $total_pro_amt ?></td>
														</tr>
										<?php
														$sno++;
													}
												}
											}
										}
										?>
									</tbody>
								</table>
							</div>
							<!--onclick="update()"-->
							<!----content start---------->
							<!--  Extra Large modal example -->
							<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-xl">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Invoice</h5>
											<hr />
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-12">
													<form class="was-validated" autocomplete="off">
														<div class="col-12">
															<div class="row">
																<div class="col-lg-3 head_po">
																	<label class="form-label">Select Consignee Address </label>
																	<select name="consignee_id" id="consignee_id" class="select2 form-control"  onChange="consignee(event)">
																		<?php echo $consignee_type_options; ?>
																	</select>
																</div>
																<!-- <input type="hidden" name="stock_qty" id="stock_qty" value="<?php echo $qty;?>" -->
																<div class="col-2 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po">
																			<label class="form-label">Consignee Name</label>
																		</div>
																		<div class="col-xl-12" id="con_name"></div>
																	</div>
																</div>
																<div class="col-2 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po"> <label class="form-label">Consignee Contact Number</label></div>
																		<div class="col-xl-12" id="con_mobile"></div>
																		<!-- <input type="text" name="demo" id="demo" value='0'> -->
																	</div>
																</div>
																<div class="col-2 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po"> <label class="form-label">Stock Qty</label></div>
																		<div class="col-xl-12" id="con_mobile"><?php echo $result_values[0]["stock_qty"]; ?></div>
																		<!-- <input type="text" name="stock_qty" id="stock_qty"> -->
																	</div>
																</div>
																<div class="col-2 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po"> <label class="form-label">Remaning Qty</label></div>
																		<div class="col-xl-12" id="con_mobile"><?php echo $remaining_qty; ?></div>
																		<!-- <?php echo $remaining_qty ?> -->
																		<!-- <input type="text" name="stock_qty" id="stock_qty"> -->
																	</div>
																</div>
															</div>
														</div>
														<br />
														<div class="row">
															<div class="col-12 mt-2">
																<div class="table-responsive mb-4">
																	<table class="table table-striped table-bordered align-middle  mb-0 small_table">
																		<thead class="table-light">
																			<tr>
																				<th>S.No</th>
																				<th scope="col">Item Code</th>
																				<th scope="col">Item Details</th>
																				<!--<th scope="col">QTY</th>-->
																				<!--<th scope="col">Billed QTY</th>-->
																				<!-- <th scope="col">Request to Stock QTY </th> -->
																			   <!-- <th scope="col">Assign con. Qty </th> -->
																			   <th scope="col">Assign remaining con. Qty </th>
																			   <th scope="col">Avaliable Stock</th> 
																				<th scope="col">Invoice QTY</th>
																				<!-- <th scope="col">Avaliable Stock</th> -->

																				
																				<!--<th scope="col">Remaining QTY </th>-->
																			</tr>
																		</thead>
																		<tbody id="product_detail">
																			
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</form> <!-- end card-body -->
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">
												Close</a>
											<button type="button" class="btn btn-primary " onclick="check_max_limit()">Save</button>
											<!-- invoice_create() -->
											<!-- invoice_create(), -->
											<!-- check_max_limit() -->
											<!-- invoice_create(), -->
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->


							<!-- Inovice details start-->
							<div class="row">
								<div class="col-12 mt-3">
									<h5><b>Invoice Details</b></h5>
									<div class="table-responsive mb-4">
										<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table" id="invoice_data_delete">
											<thead class="table-light">
												<tr>
													<th>S.No</th>
													<!-- <th scope="col">Invoice No </th> -->
													<th scope="col">Invoice Date</th>
													<th scope="col">PO Num</th>
													<th scope="col">PO Date</th>
													<!-- <th scope="col">Stock ID</th> -->
													<!-- <th scope="col">Stock Date</th> -->
													<th scope="col">Executive Name </th>
													<th scope="col">Consignee Name</th>
													<th scope="col">consignee Address</th>
													<!--<th scope="col">Product Name</th>-->
													<th scope="col">Invoice QTY</th>
													<th scope="col">Invoice Value</th>
													<!-- <th scope="col">Action</th> -->
													
												</tr>
											</thead>
											<tbody>
												<?php
												$get_stock_position   = get_invoice($main_unique_id);
												foreach ($get_stock_position as $key => $form_val) {
													$where1 = "form_main_unique_id = '" . $form_val['po_unique_id'] . "'";
													$table1      =  "invoice_creation_main";
													$columns1    = [
														"po_num",
														"po_date",
														"executive_name",
														// "(consignee_unique_id )as consignee_name",
														// "(consignee_unique_id) as con_address ",
														"(SELECT con_contact_name FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table1 . ".consignee_unique_id group by invoice_auto_id) AS consignee_name",
														"(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table1 . ".consignee_unique_id  group by invoice_auto_id) AS con_address",
														// "consignee_id",
														"invoice_auto_id",
														"invoice_date",
														// 	"item_code",
														// 	"product",
														"invoice_qty",
														// 	"(SELECT stock_id FROM consignee_details_sub WHERE consignee_details_sub.unique_id = ".$table1.".consignee_id ) AS consignee_name",
														"invoice_value",
														"po_unique_id",
														"stock_date",
														"stock_id",
														"invoice_no",
														"unique_id",
														"form_main_unique_id"
														
													];
													$table_details1   = [
														$table1,
														$columns1
													];
													$values_product  = $pdo->select($table_details1, $where1);
													// print_r($values_product);
													$j = 1;
													if ($values_product->status) {
														$product_array      = $values_product->data;
														//   print_r($product_array);
														
														$btn_update         = btn_update($folder_name, $value['unique_id']);
														foreach ($product_array as $key => $product) {
															// $product['po_unique_id']='<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';

															// $product['po_unique_id'] = $product['stock_qty']- $product['invoice_qty'];
															//   $s_no = $sno + 1;
												?>
												
															<tr>
																<td><?php echo $j; ?></td>
																<!-- <td><?php echo $product['invoice_auto_id'] ?></td> -->
																<td><?php echo $product['invoice_date'] ?></td>
																<td><?php echo $product['po_num'] ?></td>
																<td><?php echo $product['po_date'] ?></td>
																<!-- <td><?php echo $product['stock_id'] ?></td> -->
																<!-- <td><?php echo $product['stock_date']; ?></td> -->
																<td><?php echo $product['executive_name'] ?></td>
																<td><?php echo $product['consignee_name'] ?></td>
																<td><?php echo $product['con_address'] ?></td>
																<!--<td><?php echo $product['product'] ?></td>-->
																<td><?php echo $product['invoice_qty'] ?></td>
																<td><?php echo $product['invoice_value'] ?></td>
															<!-- <td><?php echo $product['po_unique_id'] ?></td> -->
															</tr>
												<?php
															$j++;
														}
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<input type="hidden" name="unique_id" id="unique_id" value="<?php echo $product['unique_id']?>">
								<input type="hidden" name="invoice_auto_id" id="invoice_auto_id" value="<?php echo $product['invoice_auto_id']?>">
								<input type="hidden" name="form_main_unique_id" id="form_main_unique_id" value="<?php echo $product['form_main_unique_id']?>">
								<div class="col-md-12" align="right">
								<?php echo btn_cancel($btn_cancel); ?>
									<!-- <button type="button" class="btn btn-primary "><a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">
											Assign Consignee Qty</a></button> -->
								</div>
								
							</div>
							<!-- Inovice details end-->
						</div>
					</div>
			</div>
		</div>
		<!--</form>-->
	</div> <!-- end card-body -->
</div> <!-- end card -->
</div><!-- end col -->
</div>
</div>
<!-- jQuery
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 Select2 CSS -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" /> -->

<!-- Select2 JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script> --> -->

<script>
// 	$('#consignee_id').on('select2:open', function (e) {
//     console.log('Select2 dropdown opened');
// });
// <script>
    $(document).ready(function() {
		// alert();
        $('.select2').select2();
    });



	function consignee(event) {
		var consignee_val = event.target.value;
		// $('#con_address').empty();
		$('#con_name').empty();
		$('#con_mobile').empty();
		$('#con_address1').empty();
		$('#product_detail').empty();

		var data = $(".was-validated").serialize();
		data += "&unique_id=" + consignee_val + "&action=get_consignee";
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function(data) { 
				// alert(data);
				var obj = JSON.parse(data);
				// $('#con_address').append(obj.data[0]);
				$('#con_name').append(obj.data[0]);
				$('#con_mobile').append(obj.data[1]);
				// $('#con_address1').append(obj.data[0]);
				$('#product_detail').append(obj.data[2]);
			}
			
		});
	}

	function invoice_create() {
		var internet_status = is_online();
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_unique_id = document.getElementById('po_unique_id').value;
		var po_num = document.getElementById('po_num').value;
		// alert(main_unique_id);
		var po_date = document.getElementById('po_date').value;
		var stock_id = document.getElementById('stock_id').value;
		var stock_date = document.getElementById('stock_date').value;
		var exe_name = document.getElementById('executive_name').value;
		var no_of_items = document.getElementById('no_of_item').value;
		var no_of_con = document.getElementById('no_of_consignee').value;
		var stock_qty = document.getElementById('stock_qty').value;
		var con_assign_qty = document.getElementById('con_assign_qty').value;
		var consignee_id = document.getElementById('consignee_id').value;
		var invoice_qty = document.getElementsByName('bill_qty[]');

		// var limit_value = document.getElementsByName('limit_value[]');
		// // alert(limit_value);
		// var max_limit_value = document.getElementById('max_limit').value='';
	// alert(max_limit_value);
	// alert(y);
	
	 
		// var invoice_qty_total = [];
		// var invoice_qty_amt = [];
		// for (var i = 0; i < invoice_qty.length; i++) {
		// 	var invoice_qty_val = invoice_qty[i].value;

		// 	var unit_price = document.getElementsByName('unit_price[]');
		// 	var unit_price_val = unit_price[i].value;

			var invoice_qty_total = [];
		var invoice_qty_amt = [];
		for (var i = 0; i < invoice_qty.length; i++) {
			var invoice_qty_val = invoice_qty[i].value;

			var unit_price = document.getElementsByName('unit_price[]');
			var unit_price_val = unit_price[i].value;
			var tax = document.getElementsByName('tax[]');
			var tax_val = tax[i].value;
	
	if (tax_val == '18' ) {
		var mul = invoice_qty_val * unit_price_val;
            // const net_value = qty * unit_price;
            var percentage_value = mul * (18 / 100);
            var total_value = mul + percentage_value;
			var amount = parseFloat(total_value);
            // document.getElementById('net_value').value = net_value;
            // document.getElementById('total_value').value = total_value;
        } else if (tax_val == '28' ) {
			var mul = invoice_qty_val * unit_price_val;
            var percentage_value = mul * (28 / 100);
            var total_value = mul + percentage_value;
			var amount = parseFloat(total_value);
			// alert(amount);
            // document.getElementById('net_value').value = net_value;

            // document.getElementById('total_value').value = total_value;
        }

			// var mul = invoice_qty_val * unit_price_val;
			// amount of value calculate
			// var amount = parseFloat(mul);
			if (!isNaN(amount)) {
				invoice_qty_amt.push(amount);
				var sum_of_invoice_value = invoice_qty_amt.reduce(function(total, current) {
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
			} else {
				alert('Please enter a valid number.');
			}
		}

		//  document.getElementById('rate').value = rate;
		var total_amount = sum_of_invoice_value;
		// alert(sum_of_invoice_qty);
		// alert(total_amount);
		var data = "main_unique_id=" + main_unique_id + "&po_unique_id=" + po_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&stock_id=" + stock_id + "&con_assign_qty=" + con_assign_qty +"&stock_date=" + stock_date + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&no_of_con=" + no_of_con + "&stock_qty=" + stock_qty + "&unit_price=" + unit_price_val + "&consignee_id=" + consignee_id + "&invoice_qty=" + sum_of_invoice_qty + "&total_amount=" + total_amount;
		data += "&action=invoice_create";
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
				invoice_create_sub();
			},
			error: function(data) {
				alert("Network Error");
			}
		});
	}
	// old alert
	// function check_max_limit() {
    // var item_name = document.getElementsByName('item_name[]');
    // var remaining_qty = document.getElementsByName('remaining_qty[]');
    // var invoice_qty = document.getElementsByName('bill_qty[]');

    // for (var i = 0; i < item_name.length; i++) {
    //     var item = item_name[i].value;
    //     var stock_qty_value = parseFloat(remaining_qty[i].value);
    //     var invoice_qty_value = parseFloat(invoice_qty[i].value);

       
    // }
	// // if (invoice_qty_value !== 0) {
    //         if (invoice_qty_value <= stock_qty_value) {
    //             // Call a function to create the invoice
    //             invoice_create();
    //         } else {
    //             alert("Insufficient Quantity for " + item);
    //         }
        // } 
		// else {
        //     alert("Invoice quantity is Zero for " + item);
        // }
// }


// new validation 
function check_max_limit() {
    // Get elements
    var item_name = document.getElementsByName('item_name[]');
    var remaining_qty = document.getElementsByName('remaining_qty[]');
    var invoice_qty = document.getElementsByName('bill_qty[]');
    var rem_billed_qty = document.getElementsByName('rem_billed_qty[]');
    // var assign_qty = document.getElementsByName('assign_qty[]');

   // Check if any stock quantity field is empty
var anyStockQtyEmpty = false;
for (var i = 0; i < item_name.length; i++) {
    var item = item_name[i].value;
    var stock_qty_value = parseFloat(remaining_qty[i].value);
    var invoice_qty_value = parseFloat(invoice_qty[i].value);
    var rem_billed_qty_value = parseFloat(rem_billed_qty[i].value);
    // var assign_qty_value = parseFloat(assign_qty[i].value);

    if (item === '') {
        anyStockQtyEmpty = true;
    }

    if (isNaN(stock_qty_value) || isNaN(invoice_qty_value) || isNaN(rem_billed_qty_value)) {
        anyStockQtyEmpty = true;
    }
}

// Check if invoice quantity is greater than remaining billed quantity
for (var i = 0; i < item_name.length; i++) {
    var item = item_name[i].value;
    var stock_qty_value = parseFloat(remaining_qty[i].value);
    var invoice_qty_value = parseFloat(invoice_qty[i].value);
    var rem_billed_qty_value = parseFloat(rem_billed_qty[i].value);
    // var assign_qty_value = parseFloat(assign_qty[i].value);

    if (invoice_qty_value > rem_billed_qty_value) {
        Swal.fire({
            icon: 'error',
            text: 'Invoice quantity cannot be greater than consignee billed quantity for ' + item,
        });
        return; // Exit function without proceeding further
    }
}

// Check if any stock quantity field is empty
if (anyStockQtyEmpty) {
    Swal.fire({
        icon: 'error',
        text: 'Please enter a value for all invoice quantities.',
    });
    return; // Exit function without proceeding further
}

// Check if invoice quantity is less than or equal to remaining billed quantity
if (invoice_qty_value <= rem_billed_qty_value) {
    invoice_create();
}

}



// function check_max_limit() {
//     var item_name = document.getElementsByName('item_name[]');
//     var remaining_qty = document.getElementsByName('remaining_qty[]');
//     var invoice_qty = document.getElementsByName('bill_qty[]');
//     var rem_billed_qty = document.getElementsByName('rem_billed_qty[]');
//     // var assign_qty = document.getElementsByName('assign_qty[]');

//     var anyStockQtyEmpty = false;

//     for (var i = 0; i < item_name.length; i++) {
//         var item = item_name[i].value;
//         var stock_qty_value = parseFloat(remaining_qty[i].value);
//         var invoice_qty_value = parseFloat(invoice_qty[i].value);
//         var rem_billed_qty_value = parseFloat(rem_billed_qty[i].value);
//         // var assign_qty_value = parseFloat(assign_qty[i].value);

//         // Check if any stock quantity field is empty
//         if (item_name[i].value === '') {
//             anyStockQtyEmpty = true;
//             break;
//         }

//         // Check if invoice quantity is greater than remaining billed quantity
//         if (invoice_qty_value > rem_billed_qty_value) {
//             Swal.fire({
//                 icon: 'error',
//                 text: 'Invoice quantity cannot be greater than consignee billed quantity for ' + item,
//             });
//             return; // Exit function without proceeding further
//         }
//     }

//     if (anyStockQtyEmpty) {
//         // Show SweetAlert if any stock quantity is empty
//         Swal.fire({
//             icon: 'error',
//             text: 'Please enter a value for all stock quantities.',
//         });
//         return; // Exit function without proceeding further
//     }

//     // Check if invoice quantity is less than or equal to remaining billed quantity
//     if (invoice_qty_value <= rem_billed_qty_value) {
//         invoice_create();
//     }
// }



// end

	function check_max_limit1() {
	
	var item_name = document.getElementsByName('item_name[]');
	// alert(item_name);
	var stock_qty = document.getElementsByName('stock_qty[]');
	var invoice_qty = document.getElementsByName('bill_qty[]');


	for (var i = 0; i < item_name.length; i++) {
		// alert();
	// 	var stock_qty = stock_qty[i].value;
		var item_name = item_name[i].value;
		// alert(item_name);
		
		var stock_qty_value = stock_qty[i].value;
		// alert(stock_qty_value);
		var invoice_qty_value = invoice_qty[i].value;
		// alert(invoice_qty_value);
if(invoice_qty_value != 0 ){
	
	if (invoice_qty_value<= stock_qty_value) {
            // alert("Condition is true.");
			invoice_create();
          } else {
            alert("InSufficient Quantity");
          }
}
else{
	alert("invoice is Zero");
}
		// if (invoice_qty_value<= stock_qty_value) {
        //     alert("Condition is true.");
        //   } else {
        //     alert("InSufficient Quantity");
        //   }
		
	}
	// 	var invoice_qty = invoice_qty[i].value;
	// 	var con_assign_qty = con_assign_qty[i].value;
	// 	// alert(con_assign_qty);
	// 	var demos = document.getElementById('demo').value;
	// 	// alert(demos);
	// 	var x = parseInt(demos);
	// 	var y = parseInt(invoice_qty);
	// 	var demo = x+y;
	// 	// alert(demo);
	// 	document.getElementById('demo').value = invoice_qty;
	// 	// var max_limit_value = document.getElementById('max_limit').value='';
	// 	// alert(max_limit_value);
	
	// if(con_assign_qty == stock_qty){
	// 	alert('hi');
	// 	if((con_assign_qty <= stock_qty)  ){
	// 		alert("successfully");
			
	// 	}else{
	// 		alert("failure");
	// 	}
	// }
	}
		// var ajax_url = sessionStorage.getItem("folder_crud_link");

		// // if ((con_address && item_name && invoice_qty)) {
		// $.ajax({
		// 	type: "POST",
		// 	url: ajax_url,
		// 	data: {
		// 		con_address: con_address,
		// 		item_name: item_name,
		// 		invoice_qty: invoice_qty,

		// 		action: "get_qty"
		// 	},
		// 	success: function (data) {
		// 		var obj = JSON.parse(data);
		// 		var data = obj.data;
		// 		var rate = data.rate_val;
		// 		document.getElementById('invoice_qty').value = rate;
		// 	}

		// });
	// }
	// else {
	// 	document.getElementById('rate').value = '';
	// }
// }
	// invoice_create()
	function invoice_create_sub() {
		var internet_status = is_online();
		var bill_qty1 = document.getElementsByName('bill_qty[]');
		for (var i = 0; i < bill_qty1.length; i++) {
			var bill_qty_value = bill_qty1[i].value;
// alert(bill_qty_value)
			if (bill_qty_value != 0) {
				var bill_qty_val = bill_qty1[i].value;

// alert(bill_qty_val);

				var item_code = document.getElementsByName('item_code[]');
				var item_name = document.getElementsByName('item_name[]');
				
				var item_qty = document.getElementsByName('stock_qty[]');
				var unit_price = document.getElementsByName('unit_price[]');
				var product_unique_id = document.getElementsByName('product_unique_id[]');
				var stock_qty = document.getElementsByName('stock_qty[]');
				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				// alert(item_name_val);
				var item_qty_val = item_qty[i].value;
				// alert(bill_qty_val);
				var unit_price_val = unit_price[i].value;

				// var invoice_value = bill_qty_val * unit_price_val;

				var product_unique_id_val = product_unique_id[i].value;
				var stock_qty_val = stock_qty[i].value;
				var po_num = document.getElementById('po_num').value;
				// alert(po_num);
				var po_unique_id = document.getElementById('main_unique_id').value;
				var po_auto_id = document.getElementById('po_unique_id').value;
				var po_date = document.getElementById('po_date').value;
				var stock_id = document.getElementById('stock_id').value;
				var stock_date = document.getElementById('stock_date').value;
				var executive_id = document.getElementById('executive_name').value;
				var consignee_id = document.getElementById('consignee_id').value;
				var no_of_consignee = document.getElementById('no_of_consignee').value;
				var no_of_items = document.getElementById('no_of_item').value;
				var update_billed_qty = document.getElementById('update_billed_qty').value;
				var total_invoice_qty = document.getElementById('total_invoice_qty').value;

				//alert(total_invoice_qty);
					var total_assign_qty = document.getElementById('total_assign_qty').value;
				if(bill_qty_val != 0){

					// alert(bill_qty_val);
					var data = "po_unique_id=" + po_unique_id + "&po_date=" + po_date + "&stock_id=" + stock_id + "&stock_date=" + stock_date + "&consignee_id=" + consignee_id + "&item_code_val=" + item_code_val + "&item_name_val=" + item_name_val + "&item_qty_val=" + item_qty_val + "&bill_qty_val=" + bill_qty_val + "&po_num=" + po_num + "&executive_id=" + executive_id + "&unit_price=" + unit_price_val + "&product_unique_id=" + product_unique_id_val + "&stock_qty=" + stock_qty_val + "&po_auto_id=" + po_auto_id + "&no_of_consignee=" + no_of_consignee + "&update_billed_qty=" + update_billed_qty + "&no_of_items=" + no_of_items + "&total_invoice_qty=" + total_invoice_qty + "&total_assign_qty=" +total_assign_qty;
					// + "&invoice_value=" + invoice_value
					data += "&action=invoice_sublist_add_update";
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
							// location.reload();
							sweetalert(msg, url);
						},
						error: function(data) {
							alert("Network Error");
						}
					});
				}
				
			}
		}
	}
	function update(unique_id = '') {
		// 		alert('hi');
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
		var url = sessionStorage.getItem("list_link");
		// console.log(data);
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			/* cache       : false,
			 contentType : false,
			 processData : false,
			 method      : 'POST',*/
			beforeSend: function() {
				$(".createupdate_btn").attr("disabled", "disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success: function(data) {
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
			error: function(data) {
				alert("Network Error");
			}
		});
		// 	} else {
		// 		sweetalert("form_alert");
		// 	}
	}
	// 	}
	
	function invoice_data_delete() {
		// alert();
var unique_id= document.getElementById('unique_id').value;
var form_main_unique_id= document.getElementById('form_main_unique_id').value;
var invoice_auto_id= document.getElementById('invoice_auto_id').value;

			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url = sessionStorage.getItem("list_link");
			
			confirm_delete('delete')
				.then((result) => {
					if (result.isConfirmed) {
						var data = {
							"unique_id":unique_id,
							"form_main_unique_id":form_main_unique_id,
							"invoice_auto_id":invoice_auto_id,
							"action": "invoice_data_delete"
						}
						$.ajax({
							type: "POST",
							url: ajax_url,
							data: data,
							success: function(data) {
								var obj = JSON.parse(data);
								var msg = obj.msg;
								var status = obj.status;
								var error = obj.error;
								if (!status) {
									url = '';
								} else {
									sub_list_datatable("invoice_data_delete");
								}
								sweetalert(msg, url);
							}
						});
					} else {
						// alert("cancel");
					}
				});
		// }
	}
</script>
