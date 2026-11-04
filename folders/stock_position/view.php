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

		// $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
		// $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

		$unique_id = $_GET["unique_id"];
		$where = [
			"unique_id" => $unique_id
		];


		$table = "view_stock_position_com_list";

		$columns = [
			"po_unique_id",
			"po_num",
			"po_date",
			// "(SELECT department FROM department_creation AS department_creation WHERE department_creation.unique_id = ".$table.".department group by department_creation.unique_id) AS department",
			"get_department_name(department) AS department",
			"get_district_name(district) AS district",
			"get_state_name(state_name) AS state_name",
			"bill_address",
			"contact_name",
			"contact_number",
			"email",
			// "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name 
			// group by executive_name.unique_id
			// ) AS executive_name",
			"get_executive_name(executive_name) AS executive_name",
			"(select count(*) from consignee_details_sub WHERE consignee_details_sub.form_main_unique_id=" . $table . ".unique_id and consignee_details_sub.is_delete='0')no_of_consignee",
			"no_of_po",
			"qty",
			"net_value",
			"status",
			// "(SELECT stock_id FROM stock_position_main WHERE stock_position_main.form_main_unique_id = " . $table . ".unique_id group by stock_id) AS stock_id",
			"unique_id"
		];

		$table_details = [
			$table,
			$columns
		];

		$result_values = $pdo->select($table_details, $where);
		// print_r($result_values);
		if ($result_values->status) {

			$result_values = $result_values->data;

			$po_unique_id = $result_values[0]["po_unique_id"];
			$po_num = $result_values[0]["po_num"];
			$po_date = $result_values[0]["po_date"];
			$department = $result_values[0]["department"];
			$executive_name = $result_values[0]["executive_name"];
			$no_of_consignee = $result_values[0]["no_of_consignee"];
			$no_of_po = $result_values[0]["no_of_po"];
			$qty = $result_values[0]["qty"];
			$net_value = $result_values[0]["net_value"];
			$status = $result_values[0]["status"];
			// $stock_id = $result_values[0]["stock_id"];
			$under_user_type = $result_values[0]["under_user_type"];
			$main_unique_id = $result_values[0]["unique_id"];


			$bill_address = $result_values[0]["bill_address"];
			$contact_number = $result_values[0]["contact_number"];
			$email = $result_values[0]["email"];
			$contact_name = $result_values[0]["contact_name"];
			$district_name = $result_values[0]["district"];
			$state_name = $result_values[0]["state_name"];

			$exe_unique_id = $result_values[0]["executive_name"];

			// if($status == 0){
			// 	print_r('ji');
			// }

			$btn_text = "Update";
			$btn_action = "update";
		} else {
			$btn_text = "Error";
			$btn_action = "error";
			$is_btn_disable = "disabled='disabled'";
		}
	}
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options = active_status($is_active);


?>

<style>
	.head_po {
		font-size: .875rem;
		margin-bottom: .3125rem;
	}

	.p-5 {
		padding: .5rem 3rem !important;
	}

	.mb-3 {
		margin-bottom: 0.3rem !important;
	}

	p {
		margin-bottom: 0rem !important;
	}

	.item-code {
		font-size: 12px;
		font-weight: bold;
	}

	.product-name {
		font-size: 12px;
	}

	table thead tr th {
		text-align: center;
	}
</style>

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Stock Position</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active"> Stock Position </li>
				</ol>
			</div>

		</div>
	</div>
</div>



<div class="row cf">
	<div class="col-12">
		<div class="card">
			<div class="card-body mt-1">
				<form class="was-validated" autocomplete="off">

					<div class="card card-body p-5">
						<div class="row">
							<div class="col text-end">
							</div>
						</div> <!-- / .row -->

						<div class="row">
							<!-- Heading -->
							<h6 class="text-uppercase text-body-primary" style="font-size:large; color:#878a99;">
								Customer Details
							</h6>
							<div class="col-12 col-md-4">
								<!-- Text -->
								<h6 class=" text-body-primary" style="font-size: x-large; color:#506018 !important;">
									<strong> <?php echo $department ?> </strong></h6>
								<p class="text-body-primary mb-3"> <?php echo $bill_address ?>,
									<?php echo $district_name ?> </br><?php echo $state_name ?> </p>
								<!-- Text -->
								<p class=""><span><i data-feather="phone"
											style="width:15px; height:15px; color:#506018 "></i></span>
									<?php echo !empty($contact_number) ? $contact_number : '--'; ?>
								</p>
								<!-- Text -->
								<p class="mb-4"><span><i data-feather="mail"
											style="width:15px; height:15px;color:#506018"></i></span>
									<?php echo !empty($email) ? $email : '--'; ?>
								</p>

							</div>
							<div class="col-12 col-md-4"></div>
							<div class="col-12 col-md-4">
								<!-- <div class="row">
									<div class="col-xl-4 head_po">
										<label class="form-label"><b>Stock Id</b></label>
									</div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><b><?php echo $stock_id; ?></b></div>
								</div> -->
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php echo $po_num ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php echo $po_date ?></div>
								</div>

								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">Executive Name</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php echo $executive_name ?></div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-md-3 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Consignee</label>
									<div class="text_style fw-bold"><?php echo $no_of_consignee ?></div>
								</div>
								<div class="col-12 col-md-3 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Items</label>
									<div class="text_style fw-bold"><?php echo $no_of_po ?></div>
								</div>
								<div class="col-12 col-md-3 mb-3">
									<label class="form-label text-body-secondary d-block">QTY</label>
									<div class="text_style fw-bold"><?php echo $qty ?></div>
								</div>
								<div class="col-12 col-md-3 mb-3">
									<label class="form-label text-body-secondary d-block">Value</label>
									<div class="text_style fw-bold"><?php echo $net_value ?></div>
								</div>

								<!-- <input type="hidden" id="stock_status" name="stock_status" class="form-control" value="<?php echo $status; ?>"> -->

								<input type="hidden" id="department" name="department" class="form-control"
									value="<?php echo $department; ?>">

							</div>



							<div class="row">

								<div class="col-12 mt-3">
									<div class="table-responsive mb-4">

										<table
											class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
											<thead>
												<tr>
													<th>S.No</th>
													<th scope="col">Stock Id</th>
													<th scope="col">Item Details</th>
													<!-- <th scope="col">Item Details</th> -->
													<th scope="col">Order QTY</th>
													<!--<th scope="col">Billed QTY</th>-->
													<!-- <th scope="col">Request to Stock QTY </th>
													<th scope="col">Remaining QTY</th> -->
													 <th scope="col">Remaining QTY</th>
														<th scope="col">Stock QTY</th>
														
														<th scope="col">Balance QTY</th>

												</tr>
											</thead>
											<tbody>


												<?php

												// $where2 = "form_main_unique_id = '".$main_unique_id."'";
												
												$get_stock_position = get_stock_position($main_unique_id);
												// print_r($get_stock_position);
												foreach ($get_stock_position as $key => $form_val) {
													// print_r($form_val);
													if (($form_val['form_main_unique_id'] == '') && ($form_val['product_count'] == 0)) {
														// print_r('hi');
														$where1 = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "'";
														$table1 = "product_details_sub";

														$columns1 = [
															"select item_code from item_creation_sub where item_creation_sub.unique_id=$table1.item_code
									group by item_creation_sub.unique_id)as item_code",
															// "item_code",
															"product",
															"qty",
															"billed_qty",
															"unit_price",
															"form_main_unique_id",
															"unique_id"
														];

														$table_details1 = [
															$table1,
															$columns1
														];
													} else {
														// print_r('hello');
														$where1 = "is_delete = '0' AND form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'";
														$groupBy = "item_code,stock_id ORDER BY stock_id ASC";
														$table1 = "stock_position";

														$columns1 = [
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
															// "SUM(stock_qty) AS stock_qty",
															"remaining_qty",
															"unique_id",
															"stock_id",
															"unit_price",
															"remqty",
															// "stock_id",
														];

														$table_details1 = [
															$table1,
															$columns1
														];

													}

													$values_product = $pdo->select($table_details1, $where1, "", "", "", "", $groupBy);
													// print_r($values_product);
													if ($values_product->status) {

														$product_array = $values_product->data;

														foreach ($product_array as $key => $product) {
															//    $product[ 's_no' ] = $sno + 1;
															$sno++; // Increment the serial number
															$product['s_no'] = $sno;
															if ($product['product_unique_id']) {
																// print_r($product['product_unique_id']);
																// $remaining_qty = $product['item_qty'] - $product['stock_qty'];
																// if ($product['billed_qty']) {
																// 	$billed_qty = $product['billed_qty'];
																// } else {
																// 	$billed_qty = '0';
																// }

																$stock_id    = $product['stock_id'];
															$item_code   = $product['item_code'];
															$item_qty    = isset($product['item_qty']) ? (float)$product['item_qty'] : 0;
															$stock_qty   = isset($product['stock_qty']) ? (float)$product['stock_qty'] : 0;
															$stock_date  = $product['stock_date'];
															$product_name = $product['product'];

																$today = date("d-m-Y");
																$qty = $product['item_qty'];
$stock = $product['stock_qty'];
$rem_qtys = $qty - $stock;

// echo "Remaining quantity: " . $rem_qtys;
																?>
																<tr>
																	<td><?php echo $product['s_no'] ?></td>
																	<td><?php echo $product['stock_id'] ?></td>
																	<td>
																		<b><?php echo $product['item_code']; ?></b><br>
																		<span
																			style="margin-top: 4px; display: inline-block;"><?php echo $product['product']; ?></span>
																	</td>

																	<!-- <td></td> -->
																	<!-- <td style="text-align:right;"><?php echo $product['item_qty'] ?> -->
																	<td style="text-align:right;"><?php echo $item_qty; ?></td>
																<td style="text-align:right;"><?php echo $rem_qtys; ?></td>
																
																	</td>
																	<!--<td><?php echo $billed_qty; ?></td>-->
																	<td style="text-align:right;">
																		<div class="">
																			<input type="hidden" id="unique_id" name="unique_id[]"
																				class="form-control"
																				value="<?php echo $product['unique_id']; ?>">
																			<input type="hidden" id="unit_price" name="unit_price[]"
																				class="form-control"
																				value="<?php echo $product['unit_price']; ?>">

																			<input type="hidden" id="main_unique_id"
																				name="main_unique_id" class="form-control"
																				value="<?php echo $product['form_main_unique_id']; ?>">
																			<input type="hidden" id="product_unique_id"
																				name="product_unique_id[]" class="form-control"
																				value="<?php echo $product['product_unique_id']; ?>">
																			<input type="hidden" id="stock_date" name="stock_date[]"
																				class="form-control" value="<?php echo $today; ?>">
																			<input type="hidden" id="po_num" name="po_num"
																				class="form-control" value="<?php echo $po_num; ?>">
																			<input type="hidden" id="po_unique_id" name="po_unique_id"
																				class="form-control"
																				value="<?php echo $po_unique_id; ?>">

																			<input type="hidden" id="po_date" name="po_date"
																				class="form-control" value="<?php echo $po_date; ?>">
																			<input type="hidden" id="exe_name" name="exe_name"
																				class="form-control"
																				value="<?php echo $exe_unique_id; ?>">
																			<input type="hidden" id="no_of_items" name="no_of_items"
																				class="form-control" value="<?php echo $no_of_po; ?>">
																			<input type="hidden" id="no_of_con" name="no_of_con"
																				class="form-control"
																				value="<?php echo $no_of_consignee; ?>">

																			<input type="hidden" id="total_qty" name="total_qty"
																				class="form-control" value="<?php echo $qty; ?>">
																			<input type="hidden" id="net_value" name="net_value"
																				class="form-control" value="<?php echo $net_value; ?>">

																			<input type="hidden" id="item_code" name="item_code[]"
																				class="form-control"
																				value="<?php echo $product['item_code']; ?>">
																			<input type="hidden" id="item_name" name="item_name[]"
																				class="form-control"
																				value="<?php echo $product['product']; ?>">
																			<input type="hidden" id="item_qty" name="item_qty[]"
																				class="form-control"
																				value="<?php echo $product['item_qty']; ?>">

																			<input type="hidden" id="billed_qty" name="billed_qty[]"
																				class="form-control" value="<?php echo $billed_qty; ?>">

																			<input type="hidden" id="remaining_qty"
																				name="remaining_qty[]" class="form-control"
																				value="<?php echo $remaining_qty; ?>">

																			<!-- <input type="text" id="stock_qty" name="stock_qty[]" class="form-control" value="<?php echo $product['stock_qty']; ?>" required> -->
																			<!-- <?php echo $product['stock_qty']; ?> -->
																			<?php echo $stock_qty; ?>
																		</div>
																	</td>

																<td style="text-align:right;"><?php echo $product['remaining_qty']; ?></td>
																	<!-- <td style="text-align:right;">
																		<?php if ($remaining_qty && $product['stock_qty'] != 0) {
																			echo $remaining_qty;
																		} else if ($remaining_qty && $product['stock_qty'] == 0) {
																			echo '0';
																		}
																		else {
																			echo '0';
																		} ?>
																	</td> -->

																</tr>

															<?php } else {
																// $remaining_qty = $product['qty'] - $product['stock_qty'];
																// if ($product['billed_qty']) {
																// 	$billed_qty = $product['billed_qty'];
																// } else {
																// 	$billed_qty = '0';
																// }

																$today = date("d-m-Y");
																?>

																<tr>
																	<td><?php echo $product['s_no'] ?></td>
																	<td>
																		<b><?php echo $product['item_code']; ?></b><br>
																		<span
																			style="margin-top: 4px; display: inline-block;"><?php echo $product['product']; ?></span>
																	</td>

																	<!-- <td><?php echo $product['product'] ?></td> -->
																	<!-- <td><?php echo $product['qty'] ?></td>
																	  -->
																	<!--<td><?php echo $billed_qty; ?></td>-->
																	<td style="text-align:right;"><?php echo $item_qty; ?></td>
																<!-- <td style="text-align:right;"><?php echo $product['remqty']; ?></td> -->
																 <td style="text-align:right;"><?php echo $rem_qtys; ?></td>
																	<td>
																		<div class="">
																			<input type="hidden" id="unit_price" name="unit_price[]"
																				class="form-control"
																				value="<?php echo $product['unit_price']; ?>">

																			<input type="hidden" id="unique_id" name="unique_id[]"
																				class="form-control">
																			<input type="hidden" id="main_unique_id"
																				name="main_unique_id" class="form-control"
																				value="<?php echo $product['form_main_unique_id']; ?>">
																			<input type="hidden" id="product_unique_id"
																				name="product_unique_id[]" class="form-control"
																				value="<?php echo $product['unique_id']; ?>">
																			<input type="hidden" id="stock_date" name="stock_date[]"
																				class="form-control" value="<?php echo $today; ?>">
																			<input type="hidden" id="po_num" name="po_num"
																				class="form-control" value="<?php echo $po_num; ?>">

																			<input type="hidden" id="po_unique_id" name="po_unique_id"
																				class="form-control"
																				value="<?php echo $po_unique_id; ?>">
																			<input type="hidden" id="po_date" name="po_date"
																				class="form-control" value="<?php echo $po_date; ?>">
																			<input type="hidden" id="exe_name" name="exe_name"
																				class="form-control"
																				value="<?php echo $exe_unique_id; ?>">
																			<input type="hidden" id="no_of_items" name="no_of_items"
																				class="form-control" value="<?php echo $no_of_po; ?>">
																			<input type="hidden" id="no_of_con" name="no_of_con"
																				class="form-control"
																				value="<?php echo $no_of_consignee; ?>">

																			<input type="hidden" id="total_qty" name="total_qty"
																				class="form-control" value="<?php echo $qty; ?>">
																			<input type="hidden" id="net_value" name="net_value"
																				class="form-control" value="<?php echo $net_value; ?>">

																			<input type="hidden" id="item_code" name="item_code[]"
																				class="form-control"
																				value="<?php echo $product['item_code']; ?>">
																			<input type="hidden" id="item_name" name="item_name[]"
																				class="form-control"
																				value="<?php echo $product['product']; ?>">
																			<input type="hidden" id="item_qty" name="item_qty[]"
																				class="form-control"
																				value="<?php echo $product['qty']; ?>">

																			<input type="hidden" id="billed_qty" name="billed_qty[]"
																				class="form-control" value="<?php echo $billed_qty; ?>">

																			<!-- <input type="hidden" id="remaining_qty" name="remaining_qty[]"
											class="form-control" value="<?php echo $remaining_qty; ?>"> -->

																			<input type="text" id="stock_qty" name="stock_qty[]"
																				class="form-control"
																				value="<?php echo $product['stock_qty']; ?>" required
																				onkeyup="rem_qty()">


																	<?php echo $stock_qty; ?>
																		</div>
																	</td>
																	<td>
																		<?php if ($product['stock_qty']) {
																			echo $remaining_qty;
																		} else {
																			echo '<input type="text" id="remaining_qty" name="remaining_qty[]"
                                            class="form-control">';
																		} ?>
																	</td>
																	<!-- <?php if ($remaining_qty) {
																		echo $remaining_qty;
																	} else {
																		echo '0';
																	} ?> -->
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
									<div class="form-group row ">
										<div class="col-md-12" align="right">
											<!-- Cancel,save and update Buttons -->
											<?php echo btn_cancel($btn_cancel); ?>



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




<!--===================================================processing table============================================-->


<!--==================================================end============================================================-->
<script>

	function rem_qty() {
		var stock_qty = document.getElementsByName('stock_qty[]');
		var item_qty = document.getElementsByName('item_qty[]');
		var rem_qty = document.getElementsByName('remaining_qty[]');

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = stock_qty[i].value;
			var item_qty_val = item_qty[i].value;

			var rem_val = item_qty_val - stock_qty_val;
			var rem_qty_val = rem_qty[i];
			rem_qty_val.value = rem_val;

		}

	}




	function create() {
		var internet_status = is_online();


		var stock_date = document.getElementById('stock_date').value;
		var po_date = document.getElementById('po_date').value;
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_num = document.getElementById('po_num').value;
		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var po_auto_id = document.getElementById('po_unique_id').value;
		var no_of_con = document.getElementById('no_of_con').value;
		var department = document.getElementById('department').value;

		var item_qty = document.getElementsByName('item_qty[]');


		var stock_qty = document.getElementsByName('stock_qty[]');
		var stock_qty_total = [];
		var item_qty_total = [];
		var stock_qty_amt = [];

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = stock_qty[i].value;
			var unit_price = document.getElementsByName('unit_price[]');
			var unit_price_val = unit_price[i].value;
			var mul = stock_qty_val * unit_price_val;

			var item_qty_val = item_qty[i].value;
			var number = parseFloat(item_qty_val);
			if (!isNaN(number)) {
				item_qty_total.push(number);
				var sum_of_item_qty = item_qty_total.reduce(function (total, current) {
					return total + current;
				}, 0);

			}

			// amount of value calculate
			var amount = parseFloat(mul);
			if (!isNaN(amount)) {
				stock_qty_amt.push(amount);
				var sum_of_stock_value = stock_qty_amt.reduce(function (total, current) {
					return total + current;
				}, 0);

			}

			// total qty calculate
			var number = parseFloat(stock_qty_val);
			if (!isNaN(number)) {
				stock_qty_total.push(number);
				var sum_of_stock_qty = stock_qty_total.reduce(function (total, current) {
					return total + current;
				}, 0);

			} else {
				alert('Please enter a valid number.');
			}
		}

		if (sum_of_item_qty >= sum_of_stock_qty) {
			// alert('hi');
			var total_amount = sum_of_stock_value;

			var data = "stock_date=" + stock_date + "&main_unique_id=" + main_unique_id + "&po_date=" + po_date + "&po_num=" + po_num + "&po_auto_id=" + po_auto_id + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&no_of_con=" + no_of_con + "&department=" + department + "&stock_qty=" + sum_of_stock_qty + "&total_amount=" + total_amount;

			data += "&action=stock_position_create";

			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url = sessionStorage.getItem("list_link");


			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
				beforeSend: function () {
					$(".po_delivery_add_update_btn").attr("disabled", "disabled");
					$(".po_delivery_add_update_btn").text("Loading...");
				},
				success: function (data) {
					// alert(data);
					stock_creation_sub();
				},
				error: function (data) {
					alert("Network Error");
				}
			});
		} else {
			alert("Enter Valid Product Quantity..");
			// alert('hello');
		}


	}

	function stock_creation_sub() {

		var stock_qty = document.getElementsByName('stock_qty[]');

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = stock_qty[i].value;

			if (stock_qty_val != '') {
				var stock_qty_val = stock_qty[i].value;
				var item_code = document.getElementsByName('item_code[]');
				var item_name = document.getElementsByName('item_name[]');
				var billed_qty = document.getElementsByName('billed_qty[]');
				var item_qty = document.getElementsByName('item_qty[]');
				var remaining_qty = document.getElementsByName('remaining_qty[]');
				var product_unique_id = document.getElementsByName('product_unique_id[]');
				var unique_id = document.getElementsByName('unique_id[]');
				var unit_price = document.getElementsByName('unit_price[]');


				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				var item_qty_val = item_qty[i].value;
				var billed_qty_val = billed_qty[i].value;
				var remaining_qty_val = remaining_qty[i].value;
				var product_unique_id_val = product_unique_id[i].value;
				var unique_id_val = unique_id[i].value;
				var unit_price = unit_price[i].value;

				//alert(unique_id_val);


				var po_date = document.getElementById('po_date').value;
				var total_qty = document.getElementById('total_qty').value;
				var net_value = document.getElementById('net_value').value;
				var stock_date = document.getElementById('stock_date').value;
				var po_auto_id = document.getElementById('po_unique_id').value;

				var main_unique_id = document.getElementById('main_unique_id').value;
				var po_num = document.getElementById('po_num').value;
				var exe_name = document.getElementById('exe_name').value;
				var no_of_items = document.getElementById('no_of_items').value;
				var no_of_con = document.getElementById('no_of_con').value;

				var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id + "&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" + item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val + "&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val + "&po_num=" + po_num + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + "&unit_price=" + unit_price;

				data += "&action=stock_position_add_update";

				var ajax_url = sessionStorage.getItem("folder_crud_link");
				var url = sessionStorage.getItem("list_link");


				$.ajax({
					type: "POST",
					url: ajax_url,
					data: data,
					beforeSend: function () {
						$(".po_delivery_add_update_btn").attr("disabled", "disabled");
						$(".po_delivery_add_update_btn").text("Loading...");
					},
					success: function (data) {
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
					error: function (data) {
						alert("Network Error");
					}
				});
			}
		}
	}
</script>
