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
			// "(SELECT po_unique_id FROM po_form WHERE po_form.unique_id = ".$table1.".form_main_unique_id) AS po_unique_id", 
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
			// $po_date          = $result_values[0]["po_date"];
			$department          = $result_values[0]["department"];
			$executive_name    = $result_values[0]["executive_name"];
			$no_of_consignee          = $result_values[0]["no_of_con"];
			$no_of_po          = $result_values[0]["no_of_item"];
			$qty    = $result_values[0]["stock_qty"];
			$net_value          = $result_values[0]["stock_value"];
			$status          = $result_values[0]["status"];
			$stock_id          = $result_values[0]["stock_id"];
			$under_user_type    = $result_values[0]["under_user_type"];
			$main_unique_id          = $result_values[0]["form_main_unique_id"];

			$exe_unique_id = $result_values[0]["executive_name"];
			$orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));
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
$consignee_type_options = select_option($consignee_type_options, "Select consignee", $unique_id);


?>

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Stock Position - Processing</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
					<li class="breadcrumb-item active"> Stock Position </li>
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
									<div class="col-xl-8"><?php echo $po_unique_id . ' / ' . $po_num; ?></div>
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
							<div class="col-6">
								<div class="row">
									<div class="col-xl-3 head_po"><label class="form-label"><b>Stock Id</b></label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-4"><b><?php echo $stock_id; ?></b></div>
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
											<!--<th scope="col">QTY</th>-->

											<th scope="col">Request to Stock QTY </th>
											<th scope="col">Unit Price</th>
											<th scope="col">Net Value </th>

										</tr>
									</thead>
									<tbody>

										<?php


										$get_stock_position   = get_stock_position($main_unique_id);
										foreach ($get_stock_position as $key => $form_val) {

											$where1 = "form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'";
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
												"stock_id",
												"(SELECT unit_price FROM product_details_sub WHERE product_details_sub.unique_id = " . $table1 . ".product_unique_id ) AS unit_price",
											];

											$table_details1   = [
												$table1,
												$columns1
											];


											$values_product  = $pdo->select($table_details1, $where1);
											// print_r($values_product);
											if ($values_product->status) {

												$product_array      = $values_product->data;

												foreach ($product_array as $key => $product) {
													$s_no = $sno + 1;
													if ($product['product_unique_id']) {
														$product_amt = $product['stock_qty'] * $product['unit_price'];

										?>
														<tr>
															<td><?php echo $s_no ?></td>
															<td><?php echo $product['item_code'] ?></td>
															<td><?php echo $product['product'] ?></td>
															<td><?php echo $product['stock_qty'] ?></td>
															<td><?php echo $product['unit_price'] ?></td>
															<td><?php echo $product_amt ?></td>

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
											<h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Stock Position</h5>
											<hr />
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>

										<div class="modal-body">
											<div class="row">
												<div class="col-12">
													<form class="was-validated" autocomplete="off">
														<div class="col-12">
															<div class="row">
																<div class="col-lg-4 head_po">
																	<label class="form-label">Select Consignee </label>
																	<select name="consignee_id" id="consignee_id" class="select2 form-control" required="" onChange="consignee(event)">
																		<?php echo $consignee_type_options; ?>
																	</select>
																</div>
																<div class="col-4 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po">
																			<label class="form-label">Consignee Address</label>
																		</div>

																		<div class="col-xl-12" id="con_address"></div>

																	</div>

																</div>

																<div class="col-4 head_po">
																	<div class="row">
																		<div class="col-xl-12 head_po"> <label class="form-label">Consignee Contact Number</label></div>

																		<div class="col-xl-12" id="con_mobile"></div>
																	</div>

																</div>
															</div>
														</div>

														<br />
														<div class="row">
															<div class="col-12 mt-2">
																<div class="table-responsive mb-4">
																	<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
																		<thead class="table-light">
																			<tr>
																				<th>S.No</th>
																				<th scope="col">Item Code</th>
																				<th scope="col">Item Details</th>
																				<!--<th scope="col">QTY</th>-->
																				<!--<th scope="col">Billed QTY</th>-->
																				<th scope="col">Request to Stock QTY </th>
																				<th scope="col">Invoice QTY</th>
																				<!--<th scope="col">Remaining QTY </th>-->

																			</tr>
																		</thead>
																		<tbody>

																			<?php

																			$get_stock_position   = get_stock_position($main_unique_id);

																			foreach($get_stock_position as $key => $form_val) {

																				$where1 = "form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'";
																				$table1      =  "stock_position";

																				$columns1    = [
																					"item_code",
																					"product",
																					"item_qty",
																					"billed_qty",
																					"form_main_unique_id",
																					"total_qty",
																					"net_value",
																					"po_unique_id",
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
																					"stock_date",
																					"(SELECT unit_price FROM product_details_sub WHERE product_details_sub.unique_id = " . $table1 . ".product_unique_id ) AS unit_price",
																				];

																				$table_details1   = [
																					$table1,
																					$columns1
																				];

																				// 			}

																				$values_product_1  = $pdo->select($table_details1, $where1);
																				// print_r($values_product_1 );die();
																				$i = 1;
																				if ($values_product_1->status) {

																					$product_array      = $values_product_1->data;

																					foreach ($product_array as $key => $product) {
																						//   $i = $i + 1;
																						if ($product['product_unique_id']) {
																							$remaining_qty = $product['stock_qty'] - $product['bill_qty'];

																			?>
																							<tr>
																								<td><?php echo $i; ?></td>
																								<td><?php echo $product['item_code'] ?></td>
																								<td><?php echo $product['product'] ?></td>
																								<td><?php echo $product['stock_qty'] ?></td>
																								<td>
																									<div class="">
																										<input type="hidden" id="po_unique_id" name="po_unique_id[]" value="<?php echo $po_unique_id; ?>">
																										<input type="hidden" id="no_of_consignee" name="no_of_consignee[]" value="<?php echo $product['no_of_consignee']; ?>">
																										<input type="hidden" id="main_unique_id" name="main_unique_id[]" value="<?php echo $unique_id; ?>">
																										<input type="hidden" id="po_num" name="po_num[]" value="<?php echo $po_num; ?>">
																										<input type="hidden" id="executive_name" name="executive_name[]" value="<?php echo $exe_unique_id; ?>">
																										<input type="hidden" id="po_date" name="po_date[]" value="<?php echo $po_date; ?>">
																										<input type="hidden" id="stock_id" name="stock_id[]" value="<?php echo $product['stock_id']; ?>">
																										<input type="hidden" id="stock_date" name="stock_date[]" value="<?php echo $product['stock_date']; ?>">

																										<input type="hidden" id="item_code" name="item_code[]" value="<?php echo $product['item_code']; ?>">
																										<input type="hidden" id="item_name" name="item_name[]" value="<?php echo $product['product']; ?>">
																										<input type="hidden" id="stock_qty" name="stock_qty[]" value="<?php echo $product['stock_qty']; ?>">
																										<input type="hidden" id="unit_price" name="unit_price[]" value="<?php echo $product['unit_price']; ?>">
																										<input type="hidden" id="product_unique_id" name="product_unique_id[]" value="<?php echo $product['product_unique_id']; ?>">


																										<input type="hidden" id="no_of_item" name="no_of_item[]" value="<?php echo $product['no_of_item']; ?>">




																										<input type="text" id="bill_qty" name="bill_qty[]" class="form-control" />
																									</div>
																								</td>
																								<!--<td>0</td>-->
																								<!--<?php echo $product['remaining_qty'] ?>-->
																							</tr>
																			<?php
																							$i++;
																						}
																					}
																				}
																			}

																			?>
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
											<button type="button" class="btn btn-primary " onclick="invoice_create()">Save</button>
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->


							<!-- Inovice details start-->
							<div class="row">
								<div class="col-12 mt-3">
									<h5><b>Invoice Details</b></h5>
									<div class="table-responsive mb-4">
										<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
											<thead class="table-light">
												<tr>
													<th>S.No</th>
													<th scope="col">Invoice No </th>
													<th scope="col">Invoice Date</th>
													<th scope="col">PO Num</th>
													<th scope="col">PO Date</th>
													<th scope="col">Stock ID</th>
													<th scope="col">Stock Date</th>

													<th scope="col">Executive Name </th>
													<th scope="col">Consignee Name</th>
													<!--<th scope="col">Item Code</th>-->
													<!--<th scope="col">Product Name</th>-->
													<th scope="col">Invoice QTY</th>
													<th scope="col">Invoice Value</th>
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
														"(SELECT con_contact_name FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table1 . ".consignee_unique_id ) AS consignee_name",
														// 	"consignee_id",
														"invoice_auto_id",
														"invoice_date",
														// 	"item_code",
														// 	"product",
														"invoice_qty",
														// 	"(SELECT stock_id FROM consignee_details_sub WHERE consignee_details_sub.unique_id = ".$table1.".consignee_id ) AS consignee_name",
														"invoice_value",
														"stock_date",
														"stock_id",
														"invoice_no",
														"po_unique_id",
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
															//   $s_no = $sno + 1;

												?>

															<tr>
																<td><?php echo $j; ?></td>
																<td><?php echo $product['invoice_auto_id'] . ' / ' . $product['invoice_no'] ?></td>
																<td><?php echo $product['invoice_date'] ?></td>
																<td><?php echo $product['po_unique_id'] . ' / ' . $product['po_num'] ?></td>
																<td><?php echo $product['po_date'] ?></td>
																<td><?php echo $product['stock_id'] ?></td>
																<td><?php echo $product['stock_date']; ?></td>

																<td><?php echo $product['executive_name'] ?></td>
																<td><?php echo $product['consignee_name'] ?></td>
																<!--<td><?php echo $product['item_code'] ?></td>-->
																<!--<td><?php echo $product['product'] ?></td>-->
																<td><?php echo $product['invoice_qty'] ?></td>
																<td><?php echo $product['invoice_value'] ?></td>
																<!--<td><?php echo $btn_update; ?></td>-->
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

								<div class="col-md-12" align="right">
									<button type="button" class="btn btn-primary "><a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">
											Add Invoice</a></button>
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

<script>
	function consignee(event) {
		var consignee_val = event.target.value;
		$('#con_address').empty();
		$('#con_mobile').empty();
		$('#con_address1').empty();
		$('#con_mobile1').empty();
		var data = $(".was-validated").serialize();
		data += "&unique_id=" + consignee_val + "&action=get_consignee";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function(data) {

				var obj = JSON.parse(data);
				$('#con_address').append(obj.data[0]);
				$('#con_mobile').append(obj.data[1]);
				$('#con_address1').append(obj.data[0]);
				$('#con_mobile1').append(obj.data[1]);

			}
		});
	}


	function invoice_create() {
		var internet_status = is_online();


		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_unique_id = document.getElementById('po_unique_id').value;
		var po_num = document.getElementById('po_num').value;
		var po_date = document.getElementById('po_date').value;
		var stock_id = document.getElementById('stock_id').value;
		var stock_date = document.getElementById('stock_date').value;
		var exe_name = document.getElementById('executive_name').value;
		var no_of_items = document.getElementById('no_of_item').value;
		var stock_qty = document.getElementById('stock_qty').value;
		var consignee_id = document.getElementById('consignee_id').value;


		var invoice_qty = document.getElementsByName('bill_qty[]');

		var invoice_qty_total = [];
		var invoice_qty_amt = [];

		for (var i = 0; i < invoice_qty.length; i++) {
			var invoice_qty_val = invoice_qty[i].value;
			var unit_price = document.getElementsByName('unit_price[]');
			var unit_price_val = unit_price[i].value;
			var mul = invoice_qty_val * unit_price_val;

			// amount of value calculate
			var amount = parseFloat(mul);
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


		var total_amount = sum_of_invoice_value;
		// alert(total_amount);

		var data = "main_unique_id=" + main_unique_id + "&po_unique_id=" + po_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&stock_id=" + stock_id + "&stock_date=" + stock_date + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&stock_qty=" + stock_qty + "&unit_price=" + unit_price_val + "&consignee_id=" + consignee_id + "&invoice_qty=" + sum_of_invoice_qty + "&total_amount=" + total_amount;

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

	function invoice_create_sub() {
		var internet_status = is_online();

		var bill_qty1 = document.getElementsByName('bill_qty[]');
		for (var i = 0; i < bill_qty1.length; i++) {

			var bill_qty_value = bill_qty1[i].value;
			if (bill_qty_value != '') {
				var bill_qty_val = bill_qty1[i].value;
				var item_code = document.getElementsByName('item_code[]');
				var item_name = document.getElementsByName('item_name[]');
				var item_qty = document.getElementsByName('stock_qty[]');
				var unit_price = document.getElementsByName('unit_price[]');
				var product_unique_id = document.getElementsByName('product_unique_id[]');

				var stock_qty = document.getElementsByName('stock_qty[]');

				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				var item_qty_val = item_qty[i].value;
				var unit_price_val = unit_price[i].value;
				var product_unique_id_val = product_unique_id[i].value;

				var stock_qty_val = stock_qty[i].value;

				var po_num = document.getElementById('po_num').value;

				var po_unique_id = document.getElementById('main_unique_id').value;
				var po_auto_id = document.getElementById('po_unique_id').value;

				var po_date = document.getElementById('po_date').value;
				var stock_id = document.getElementById('stock_id').value;
				var stock_date = document.getElementById('stock_date').value;
				var executive_id = document.getElementById('executive_name').value;
				var consignee_id = document.getElementById('consignee_id').value;
				var no_of_consignee = document.getElementById('no_of_consignee').value;
				var no_of_items = document.getElementById('no_of_item').value;


				var data = "po_unique_id=" + po_unique_id + "&po_date=" + po_date + "&stock_id=" + stock_id + "&stock_date=" + stock_date + "&consignee_id=" + consignee_id + "&item_code_val=" + item_code_val + "&item_name_val=" + item_name_val + "&item_qty_val=" + item_qty_val + "&bill_qty_val=" + bill_qty_val + "&po_num=" + po_num + "&executive_id=" + executive_id + "&unit_price=" + unit_price_val + "&product_unique_id=" + product_unique_id_val + "&stock_qty=" + stock_qty_val + "&po_auto_id=" + po_auto_id + "&no_of_consignee=" + no_of_consignee + "&no_of_items=" + no_of_items;
				data += "&action=invoice_add_update";

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
	}

	function update(unique_id = '') {
				// alert('hi');
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
</script>
