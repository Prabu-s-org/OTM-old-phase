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
$status_pr = "Processing";
if (isset($_GET["unique_id"])) {
	if (!empty($_GET["unique_id"])) {
		// $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
		// $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
		$unique_id = $_GET["unique_id"];
		$stock_id = $_GET["stock_id"];
		$view = $_GET["view"];
		$where = [
			"form_main_unique_id" => $unique_id,
			"stock_id" => $stock_id,
			"is_delete" => 0
		];
		$table = "stock_position_main";
		$columns = [
			"stock_id",
			"stock_date",
			"get_po_number(form_main_unique_id) AS po_num",
			"po_unique_id",
			"DATE_FORMAT((select po_date from po_form where  po_form.unique_id=$table.form_main_unique_id), '%d-%m-%Y') as po_date",
			"department",
			"executive_name",

			"(select count(*) from consignee_details_sub WHERE consignee_details_sub.form_main_unique_id=" . $table . ".form_main_unique_id and consignee_details_sub.is_delete='0')no_of_con",
			"no_of_item",
			"stock_qty",
			// "select sum(invoice_qty) from invoice_creation_main ",
			"stock_value",
			"form_main_unique_id",
			"(SELECT sum(invoice_qty) FROM invoice_creation WHERE invoice_creation.stock_id = " . $table . ".stock_id  and invoice_creation.po_unique_id = " . $table . ".form_main_unique_id and invoice_creation.is_delete='0' group by po_unique_id) AS invoice_qty",
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
			$no_of_consignee = $result_values[0]["no_of_con"];
			$no_of_po = $result_values[0]["no_of_item"];
			$qty = $result_values[0]["stock_qty"];
			$invoice_qty = $result_values[0]["invoice_qty"];

			$net_value = $result_values[0]["stock_value"];
			$status = $result_values[0]["status"];
			// $stock_id = $result_values[0]["stock_id"];
			$stock_date = date("d-m-Y", strtotime($result_values[0]["stock_date"]));
			$under_user_type = $result_values[0]["under_user_type"];
			$main_unique_id = $result_values[0]["form_main_unique_id"];
			$exe_unique_id = $result_values[0]["executive_name"];


			$remaining_qty = $qty - $invoice_qty;



			$stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
			$stmtCus->bindParam(':unique_id', $main_unique_id);
			$stmtCus->execute();

			$customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($customer_data)) {
				$customerAddress = $customer_data[0]["bill_address"];
				$customerName = $customer_data[0]["contact_name"];
				$customerContact = $customer_data[0]["contact_number"];
				$customerLan = $customer_data[0]["landline_number"];
				$customerEmail = $customer_data[0]["email"];
				$customerState = con_state_name_stock($customer_data[0]["state_name"]);
				$customerDistrict = district_name_stock($customer_data[0]["district"]);
				$customerPincode = $customer_data[0]["pin"];
			}
			$stmtCus->closeCursor();
			// $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
			// $stmt->bindParam(':unique_id', $consignee_unique_id);
			// $stmt->execute();


			// 			print_r($remaining_qty);
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
$approval_option = [
	// "0" => [
	//     "unique_id" => "0",
	//     "value"     => "Pending",
	// ],
	"Processing" => [
		"unique_id" => "1",
		"value" => "Processing",
	],
	"Completed" => [
		"unique_id" => "2",
		"value" => "Completed",
	],
];
$approval_options = select_option($approval_option, "Select", $status_pr);



$consignee_type = consignee_select($unique_id);

$consignee_type_options = select_option2($consignee_type, "Select consignee", $unique_id);

$popval = $_GET["popval"];
// print_r($consignee_type_options);die();
?>

<style>
	th {
		text-align: center !important;
	}

	select {
		width: 250px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	option {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
</style>
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Consignee Stock Assign</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
					<li class="breadcrumb-item active"> Consignee Stock Assign </li>
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
					<div class="card card-body p-5">
						<div class="row">
							<div class="col text-end">
							</div>
						</div>

						<div class="row">
							<!-- Customer Details -->
							<div class="col-md-4">
								<h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
									Customer Details</h6>
								<h6 style="font-size: x-large; color: #506018;">
									<strong><?php echo $customerName ?></strong>
								</h6>
								<p class="mb-1"><?php echo $customerAddress ?>,
									<?php echo $customerDistrict ?><br><?php echo $customerState ?>,
									<?php echo $customerPincode ?>
								</p>
								<p class="mb-1">
									<i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
									<?php echo !empty($customerContact) ? $customerContact : '--'; ?>
								</p>
								<p>
									<i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
									<?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
								</p>
							</div>

							<!-- </div> -->
							<div class="col-12 col-md-4"></div>
							<div class="col-12 col-md-4">
								<h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
									Stock Details</h6>
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">Stock ID</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php echo $stock_id ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">Stock Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php echo $stock_date ?></div>
								</div>
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
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Consignee</label>
									<div class="text_style fw-bold"><?php echo $no_of_consignee ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Items</label>
									<div class="text_style fw-bold"><?php echo $no_of_po ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">Stock QTY</label>
									<div class="text_style fw-bold"><?php echo $qty ?></div>

								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">Net Value</label>
									<div class="text_style fw-bold"><?php echo moneyFormatIndia1($net_value) ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">Assign Qty</label>
									<div class="text_style fw-bold"><?php echo $invoice_qty ?></div>
								</div>
							</div>

						</div>
						<br>
						<div class="row">
							<div class="col-12 mt-3">
								<div class="table-responsive mb-4">
									<table
										class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
										<thead>
											<tr>
												<th>S.No</th>
												<th scope="col">Item Code</th>
												<th scope="col">Part No</th>
												<th scope="col">Avaliable QTY </th>
												<th scope="col">Net price</th>
												<th scope="col">Total Value </th>
											</tr>
										</thead>
										<tbody>
											<?php
											$get_stock_position = get_stock_position($main_unique_id);

											foreach ($get_stock_position as $key => $form_val) {
												$where1 = "stock_id = '" . $stock_id . "' and form_main_unique_id = '" . $form_val['form_main_unique_id'] . "' AND is_delete='0'";
												// 		print_r(	$where1);
												$table1 = "stock_position";
												$columns1 = [
													// "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table1.item_code)as item_code",
													"item_code",
													// "item_sp",
													// "item_specification",
													"(select item_specification from item_creation_sub WHERE item_creation_sub.unique_id=$table1.item_code AND item_creation_sub.is_delete='0' group by unique_id)as item_specification",

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
													"part_no",
													"product_tax",
													"(SELECT unit_price FROM product_details_sub WHERE product_details_sub.unique_id = " . $table1 . ".product_unique_id AND product_details_sub.is_delete='0' group by unique_id) AS unit_price",
													"(SELECT net_price FROM product_details_sub WHERE product_details_sub.unique_id = " . $table1 . ".product_unique_id AND product_details_sub.is_delete='0' group by unique_id) AS net_price",
													"product",

												];
												$table_details1 = [
													$table1,
													$columns1
												];
												$values_product = $pdo->select($table_details1, $where1);
												// print_r($values_product);die();
												$table112 = "invoice_creation";

												$columns112 = [
													"product_unique_id",
													"invoice_qty",
												];
												$table_details112 = [
													$table112,
													$columns112
												];
												$where112 = "po_unique_id = '" . $form_val['form_main_unique_id'] . "'  AND is_delete='0'";
												$values_invoice = $pdo->select($table_details112, $where112);
												// 			print_r($values_invoice);die();
											

												if ($values_product->status) {
													$product_array = $values_product->data;

													$invoice_array = $values_invoice->data;

													// Create an associative array to map product_unique_id to invoice_qty
													$invoice_qty_map = [];
													foreach ($invoice_array as $invoice) {
														$invoice_qty_map[$invoice['product_unique_id']] = $invoice['invoice_qty'];
													}

													foreach ($product_array as $key => $product) {
														$s_no = $sno + 1;
														if ($product['product_unique_id']) {
															$product_amt = $product['stock_qty'] * $product['unit_price'];
															$product_per = $product_amt * $product['product_tax'] / 100;
															$total_pro_amt = $product_amt + $product_per;
															$invoice_qty = $product['invoice_qty'];
															$avil_qty = $product['stock_qty'];

															?>
															<tr>
																<td><?php echo $s_no ?></td>
																<td><?php echo $product['item_code'] ?> <br>
																	<?php echo $product['product'] ?> </td>
																<!-- <td></td> -->
																<!-- <td><?php echo $product['item_specification'] ?></td>
															<td style="text-align:right;"><?php echo $product['part_no'] ?></td> -->
																<td style="text-align:right;">
																	<?php echo (!empty(trim($product['part_no'] ?? ''))) ? htmlspecialchars($product['part_no']) : '-'; ?>
																</td>
																<td style="text-align:right;"><?php echo $avil_qty; ?></td>
																<td style="text-align:right;">
																	<?php echo moneyFormatIndia1($product['net_price']) ?>
																</td>
																<td style="text-align:right;">
																	<?php echo moneyFormatIndia1($total_pro_amt) ?>
																</td>
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
								<div class="modal fade bs-example-modal-xl" id="myassign_modal" tabindex="-1"
									role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-xl">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">
													Consignee Assign Stock
												</h5>
												<hr />
												<button type="button" class="btn-close" data-bs-dismiss="modal"
													aria-label="Close"></button>
											</div>

											<div class="modal-body">
												<div class="row">
													<div class="col-12">
														<form id="invoice_create_form" class="was-validated"
															autocomplete="off">
															<div class="row">
																<!-- Select Consignee -->
																<div class="col-lg-4 head_po">
																	<label class="form-label">Consignee
																		Name/Branch</label>
																	<select name="consignee_id" id="consignee_id"
																		class="select form-select" required
																		onchange="consignee(event)">
																		<?php echo $consignee_type_options; ?>
																	</select>
																</div>

																<!-- Consignee Details -->
																<div class="col-lg-4 head_po">
																	<label class="form-label">Consignee Details</label>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Name
																		</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6"><strong
																				id="con_name"></strong></div>
																	</div>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Contact
																			No</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6"><strong
																				id="con_mobile"></strong></div>
																	</div>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Address
																		</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6"><strong
																				id="con_address"></strong></div>
																	</div>
																</div>

																<!-- Stock Details -->
																<div class="col-lg-4 head_po">
																	<label class="form-label">Stock Details</label>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Stock ID
																		</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6">
																			<strong><?php echo $result_values[0]["stock_id"]; ?></strong>
																		</div>
																	</div>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Stock
																			Date</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6">
																			<strong><?php echo $stock_date; ?></strong>
																		</div>
																	</div>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Batch ID
																		</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6"><strong
																				id="batch_id"></strong></div>
																	</div>
																	<div class="row mb-1">
																		<div class="col-5 text-body-secondary">Followed
																			By</div>
																		<div class="col-1 text-body-secondary">:</div>
																		<div class="col-6"><strong
																				id="follwed_by"></strong></div>
																	</div>
																</div>

															</div>

															<!-- Billing Address -->
															<div class="row mt-3">
																<div class="col-xl-12 head_po">
																	<label class="form-label">Billing Address</label>
																</div>
																<div class="col-xl-12"><strong
																		id="billing_address"></strong></div>
															</div>

															<!-- Table Section -->
															<div class="row mt-4">
																<div class="col-12">
																	<div class="table-responsive mb-4">
																		<table
																			class="table table-striped table-bordered align-middle mb-0 small_table">
																			<thead>
																				<tr>
																					<th>S.No</th>
																					<th>Item Details</th>
																					<th>Assign Con. Qty</th>
																					<th>Assign Remaining Con. Qty</th>
																					<th>Available Stock</th>
																					<th>Bill QTY</th>
																				</tr>
																			</thead>
																			<tbody id="product_detail">

																				<!-- Dynamic rows will be appended here -->
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-danger"
													onclick="window.location.href='index.php?file=consignee_stock_assign/update1&unique_id=<?php echo $unique_id; ?>&stock_id=<?php echo $stock_id; ?>'">
													Close
												</button>

												<button type="button" class="btn btn-primary"
													onclick="check_max_limit();">
													Assign Stock
												</button>
											</div>
										</div>
									</div>
								</div>

								<!-- Inovice details start-->
								<div class="row">
									<div class="col-12 mt-3">
										<h5><b>Invoice Details</b></h5>
										<div class="table-responsive mb-4">
											<table
												class="table table-striped table-bordered align-middle table mb-0 small_table"
												id="invice_list">
												<thead>
													<tr>
														<th>S.No</th>
														<th scope="col">Assign ID/ Date</th>
														<th scope="col">DC No.</th>
														<th scope="col">Invoice No.</th>
														<th scope="col">Followed By Team Member </th>
														<th scope="col">Consignee Datails</th>
														<th scope="col">Invoice QTY</th>
														<th scope="col">Invoice Value</th>
														<th scope="col">Action</th>

													</tr>
												</thead>
												<tbody>
													<?php
													$get_stock_position = get_invoice($main_unique_id);
													foreach ($get_stock_position as $key => $form_val) {
														$where1 = "form_main_unique_id = '" . $form_val['po_unique_id'] . "' AND stock_id = '" . $_GET["stock_id"] . "' AND is_delete=0";
														$table1 = "invoice_creation_main";
														// 	$table1      =  "view_invoice_creation_main";
													
														$columns1 = [
															"assign_stock_id",
															"executive_name",
															"dc_number",
															"invoice_no",
															"(SELECT con_contact_name FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table1 . ".consignee_unique_id group by consignee_details_sub.unique_id) AS consignee_name",


															"invoice_auto_id",
															"invoice_date",

															"invoice_qty",

															"invoice_value",
															"po_unique_id",
															"stock_date",
															"stock_id",
															"unique_id",
															"form_main_unique_id",
															"consignee_unique_id",
															"(SELECT staff_name FROM user WHERE user.staff_id = " . $table1 . ".team_mem and user.is_delete='0') AS team_member",
															"(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table1 . ".consignee_unique_id group by consignee_details_sub.unique_id) AS con_address",
															"assign_date",
															"DATE_FORMAT(dc_date, '%d-%m-%Y') as dc_date",
															"invoice_date",



														];
														$table_details1 = [
															$table1,
															$columns1
														];
														$values_product = $pdo->select($table_details1, $where1);
														// print_r($values_product);die();s
														$j = 1;
														if ($values_product->status) {
															$product_array = $values_product->data;
															//   print_r($product_array);
															$btn_update = btn_update($folder_name, $value['unique_id']);
															foreach ($product_array as $key => $product) {
																$product['po_unique_id'] = '<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';


																?>

																<tr>
																	<td><?php echo $j; ?></td>
																	<td><?php echo $product['assign_stock_id'] ?><br>
																		<?php echo date('m-d-Y', strtotime($product['assign_date'])); ?>
																	</td>
																	<!-- <td></td> -->
																	<td><?php echo $product['dc_number'] ?><br>
																		<?php echo $product['dc_date'] ?></td>
																	<td><?php echo $product['invoice_no'] ?><br>
																		<?php echo $product['invoice_date'] ?></td>
																	<td><?php echo $product['team_member'] ?></td>
																	<td><?php echo $product['consignee_name'] ?> <br>
																		<?php echo $product['con_address'] ?></td>
																	<td style="text-align:right;">
																		<?php echo $product['invoice_qty'] ?>
																	</td>
																	<td style="text-align:right;">
																		<?php echo moneyFormatIndia1($product['invoice_value']) ?>
																	</td>
																	<td><?php echo $product['po_unique_id'] ?></td>
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
									<input type="hidden" name="popup" id="popup" value="<?php echo $popval; ?>">
									<input type="hidden" name="overqty" id="overqty" value="<?php echo $qty; ?>">
									<input type="hidden" name="unique_id" id="unique_id"
										value="<?php echo $product['unique_id'] ?>">
									<input type="hidden" name="invoice_auto_id" id="invoice_auto_id"
										value="<?php echo $product['invoice_auto_id'] ?>">
									<input type="hidden" name="form_main_unique_id" id="form_main_unique_id"
										value="<?php echo $product['form_main_unique_id'] ?>">
									<input type="hidden" name="consignee_unique_id" id="consignee_unique_id"
										value="<?php echo $product['consignee_unique_id'] ?>">
									<input type="hidden" name="stock_id" id="stock_id"
										value="<?php echo $_GET["stock_id"] ?>">
									<div class="col-md-12" align="right">
										<?php echo btn_cancel($btn_cancel); ?>
										<!-- <button type="button" class="btn btn-danger"><a href="http://localhost/otm_beta/index.php?file=consignee_stock_assign/update1&unique_id=<?php echo $unique_id; ?>&stock_id=<?php echo $stock_id; ?>">
												Cancel</a></button> -->
										<?php if ($view == '') { ?>
											<button type="button" class="btn btn-primary"
												onclick="window.location.href='index.php?file=consignee_stock_assign/update1&unique_id=<?php echo $unique_id; ?>&popval=1&stock_id=<?php echo $stock_id; ?>'">
												Assign Consignee Qty
											</button>
										<?php } ?>

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

	$(document).ready(function () {

		var vals = document.getElementById('popup').value;
		// alert(vals);
		if (vals != '' && vals != '0') {
			// alert("if working");

			mypopup();
		} else {
			//  alert("else  working");
			myclosepopup()
		}

	});


	function consignee(event) {
		var consignee_val = event.target.value;

		var stock_id = document.getElementById('stock_id').value;

		// $('#con_address').empty();
		$('#con_name').empty();
		$('#con_mobile').empty();
		$('#con_address').empty();
		$('#billing_address').empty();
		$('#batch_id').empty();
		$('#batch_id').empty();
		$('#follwed_by').empty();
		$('#product_detail').empty();

		var data = $(".was-validated").serialize();
		data += "&unique_id=" + consignee_val + "&stock_id=" + stock_id + "&action=get_consignee";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			cache: false,
			success: function (data) {
				// alert(data);
				var obj = JSON.parse(data);
				// $('#con_address').append(obj.data[0]);
				$('#con_name').append(obj.data[0]);
				$('#con_mobile').append(obj.data[1]);
				$('#billing_address').append(obj.data[2]);
				$('#product_detail').append(obj.data[3]);
				$('#batch_id').text(obj.data[4]);      // Append batch ID
				$('#follwed_by').text(obj.data[5]);    // Append followed by
				$('#con_address').text(obj.data[6]);

			}
		});
	}



	function mypopup() {
		// var popupval = document.getElementById('popup').value;
		var popupval = document.getElementById('popup').value;
		// alert(popupval);
		// if(){
		//     var popupval = document.getElementById('popup').value;
		// }

		$('#myassign_modal').modal('show');

	}

	function myclosepopup() {
		// var popupval = document.getElementById('popup').value;
		// var popupval = document.getElementById('popup').value = 0;
		// alert(popupval);
		// if(){
		//     var popupval = document.getElementById('popup').value;
		// }
		$('#myassign_modal').modal('hide');

	}

	// new validation 13-04-205===================================


	function check_max_limit() {



		var item_name = document.getElementsByName('item_name[]');
		var assign_remaining_qty = document.getElementsByName('rem_billed_qty[]'); // Assign remaining con. Qty
		var available_stock = document.getElementsByName('remaining_qty[]'); // Available Stock
		var invoice_qty = document.getElementsByName('bill_qty[]'); // Invoice QTY

		let hasValidProduct = false;

		for (let i = 0; i < item_name.length; i++) {
			let item = item_name[i].value.trim();
			// alert(item);
			let remaining_qty = parseFloat(assign_remaining_qty[i].value);
			// alert(remaining_qty);
			let stock_qty = parseFloat(available_stock[i].value);
			// alert(stock_qty);

			let invoice_qty_value = parseFloat(invoice_qty[i].value);
			// alert(invoice_qty_value);


			if (item === '' || isNaN(remaining_qty) || isNaN(stock_qty) || isNaN(invoice_qty_value)) {
				Swal.fire({
					icon: 'error',
					text: 'Please enter valid quantities for item: ' + item
				});
				return;
			}

			// Skip if both values are 0 (do not store this row)
			if (remaining_qty === 0 && invoice_qty_value === 0) {
				continue;
			}

			// Validation: Invoice qty should not exceed either limit
			if (invoice_qty_value > remaining_qty) {
				Swal.fire({
					icon: 'error',
					text: 'Invoice quantity for "' + item + '" cannot exceed remaining consignee quantity.'
				});
				return;
			}

			if (invoice_qty_value > stock_qty) {
				Swal.fire({
					icon: 'error',
					text: 'Invoice quantity for "' + item + '" cannot exceed available stock.'
				});
				return;
			}

			// At least one valid product to save
			if (invoice_qty_value > 0) {
				hasValidProduct = true;
			}
		}

		if (!hasValidProduct) {
			Swal.fire({
				icon: 'warning',
				text: 'No valid product to save. Please enter at least one valid invoice quantity.'
			});
			return;
		}

		// Proceed only with valid rows
		invoice_create(); // this function must filter out zero-value rows before saving
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
		var no_of_con = document.getElementById('no_of_consignee').value;
		var stock_qty = document.getElementById('stock_qty').value;
		var con_assign_qty = document.getElementById('con_assign_qty').value;
		var consignee_id = document.getElementById('consignee_id').value;
		var invoice_qty = document.getElementsByName('bill_qty[]');
		var rem_billed_qty = document.getElementsByName('rem_billed_qty[]');
		var team_mem = document.getElementById('team_mem').value;

		var invoice_qty_total = [];
		var invoice_qty_amt = [];
		for (var i = 0; i < invoice_qty.length; i++) {


			var invoice_qty_val = invoice_qty[i].value;

			var unit_price = document.getElementsByName('unit_price[]');
			var net_price = document.getElementsByName('net_price[]');

			var unit_price_val = unit_price[i].value;
			var net_price_val = net_price[i].value;

			var tax = document.getElementsByName('tax[]');
			var tax_val = tax[i].value;

			if (tax_val == '18') {
				// var mul = invoice_qty_val * unit_price_val;
				var mul = invoice_qty_val * net_price_val;

				// const net_value = qty * unit_price;
				// var percentage_value = mul * (18 / 100); percentage_value
				var total_value = mul;
				var amount = parseFloat(total_value);
				// document.getElementById('net_value').value = net_value;
				// document.getElementById('total_value').value = total_value;
			} else if (tax_val == '28') {
				// var mul = invoice_qty_val * unit_price_val;
				var mul = invoice_qty_val * net_price_val;

				// var percentage_value = mul * (28 / 100); percentage_value
				var total_value = mul;
				var amount = parseFloat(total_value);
				// document.getElementById('net_value').value = net_value;

				// document.getElementById('total_value').value = total_value;
			}

			// var mul = invoice_qty_val * unit_price_val;
			// amount of value calculate
			// var amount = parseFloat(mul);
			if (!isNaN(amount)) {
				invoice_qty_amt.push(amount);
				var sum_of_invoice_value = invoice_qty_amt.reduce(function (total, current) {
					return total + current;
				}, 0);
			}

			// total qty calculate
			var number = parseFloat(invoice_qty_val);
			if (!isNaN(number)) {
				invoice_qty_total.push(number);
				var sum_of_invoice_qty = invoice_qty_total.reduce(function (total, current) {
					return total + current;
				}, 0);
			} else {
				alert('Please enter a valid number.');
			}
		}


		var rem_billed_qty_total = [];
		for (var i = 0; i < rem_billed_qty.length; i++) {
			var rem_billed_qty_val = rem_billed_qty[i].value;
			var rem_number = parseFloat(rem_billed_qty_val);
			if (!isNaN(rem_number)) {
				rem_billed_qty_total.push(rem_number);
			} else {
				alert('Please enter a valid Remaining Billed Quantity number.');
			}
		}
		var sum_of_rem_billed_qty = rem_billed_qty_total.reduce(function (total, current) {
			return total + current;
		}, 0);
		//  document.getElementById('rate').value = rate;
		var total_amount = sum_of_invoice_value;
		// alert(sum_of_invoice_qty);
		// alert(total_amount);
		var data = "main_unique_id=" + main_unique_id + "&po_unique_id=" + po_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&stock_id=" + stock_id + "&con_assign_qty=" + con_assign_qty + "&stock_date=" + stock_date + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&no_of_con=" + no_of_con + "&stock_qty=" + stock_qty + "&unit_price=" + unit_price_val + "&consignee_id=" + consignee_id + "&invoice_qty=" + sum_of_invoice_qty + "&team_mem=" + team_mem + "&total_amount=" + total_amount + "&assign_remaining_qty=" + sum_of_rem_billed_qty + "&net_price=" + net_price_val;
		data += "&action=invoice_create";
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");


		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			cache: false,
			beforeSend: function () {
				$(".po_delivery_add_update_btn").attr("disabled", "disabled");
				$(".po_delivery_add_update_btn").text("Loading...");
			},
			success: function (data) {
				console.log(data);

				var obj = JSON.parse(data);
				var msg = obj.msg;
				var status = obj.status;
				var assign_stock_id = obj.assign_stock_id;
				var assign_date = obj.assign_date;

				invoice_create_sub(assign_stock_id, assign_date);

			},
			error: function (data) {
				alert("Network Error");
			}
		});
	}

	// invoice_create()
	function invoice_create_sub(assign_stock_id = '', assign_date = '') {

		// debugger;
		var internet_status = is_online();
		var bill_qty1 = document.getElementsByName('bill_qty[]');
		for (var i = 0; i < bill_qty1.length; i++) {
			var bill_qty_value = bill_qty1[i].value;

			if (bill_qty_value != 0) {
				var bill_qty_val = bill_qty1[i].value;

				// alert(bill_qty_val);

				// 	var bill_qty_val += bill_qty1[i].value;


				var item_code = document.getElementsByName('item_code[]');
				var item_name = document.getElementsByName('item_name[]');

				var item_qty = document.getElementsByName('stock_qty[]');
				var unit_price = document.getElementsByName('unit_price[]');
				var net_price = document.getElementsByName('net_price[]');

				var product_unique_id = document.getElementsByName('product_unique_id[]');
				var stock_qty = document.getElementsByName('stock_qty[]');
				// new changes
				var delivery_due_days = document.getElementsByName('delivery_due_days[]');
				var delivery_due_days = delivery_due_days[i].value;

				// end
				// alert(delivery_due_days);

				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				// alert(item_name_val);
				var item_qty_val = item_qty[i].value;
				// alert(bill_qty_val);
				var unit_price_val = unit_price[i].value;
				var net_price_val = net_price[i].value;




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
				// var consignee_unique_id = document.getElementById('consignee_unique_id').value;
				var no_of_consignee = document.getElementById('no_of_consignee').value;
				var no_of_items = document.getElementById('no_of_item').value;
				var update_billed_qty = document.getElementById('update_billed_qty').value;
				// alert(update_billed_qty);
				var total_invoice_qty = document.getElementById('total_invoice_qty').value;
				// alert(total_invoice_qty);
				//alert(total_invoice_qty);
				var total_assign_qty = document.getElementById('total_assign_qty').value;
				var team_mem = document.getElementById('team_mem').value;
				var overqty = document.getElementById('overqty').value;
				// alert(total_assign_qty);
				if (bill_qty_val != 0) {

					// alert(bill_qty_val);
					var data = "po_unique_id=" + po_unique_id + "&po_date=" + po_date + "&overqty=" + overqty + "&assign_stock_id=" + assign_stock_id + "&assign_date=" + assign_date + "&stock_id=" + stock_id + "&stock_date=" + stock_date + "&consignee_id=" + consignee_id + "&item_code_val=" + item_code_val + "&item_name_val=" + item_name_val + "&item_qty_val=" + item_qty_val + "&bill_qty_val=" + bill_qty_val + "&po_num=" + po_num + "&executive_id=" + executive_id + "&unit_price=" + unit_price_val + "&product_unique_id=" + product_unique_id_val + "&stock_qty=" + stock_qty_val + "&po_auto_id=" + po_auto_id + "&no_of_consignee=" + no_of_consignee + "&update_billed_qty=" + update_billed_qty + "&no_of_items=" + no_of_items + "&total_invoice_qty=" + total_invoice_qty + "&total_assign_qty=" + total_assign_qty + "&team_mem=" + team_mem + "&delivery_due_days=" + delivery_due_days + "&net_price=" + net_price_val;
					// + "&invoice_value=" + invoice_value
					data += "&action=invoice_sublist_add_update";
					var ajax_url = sessionStorage.getItem("folder_crud_link");
					var url = sessionStorage.getItem("list_link");
					$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						cache: false,
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
							sweetalert(msg);


							// Instead of location.reload(), use DataTable redraw
							// if ($.fn.DataTable.isDataTable("#invice_list")) {
							//     $("#invice_list").DataTable().ajax.reload(null, false); // Reload without page refresh
							// }

							// setTimeout(function() {
							//     $('.bs-example-modal-xl').modal('show');
							// }, 500);
							//      if ($('#invoice_create_form').length > 0) {
							//     $('#invoice_create_form')[0].reset();
							//     $('.bs-example-modal-xl').modal('show');
							// } else {
							//     console.warn("Form not found. Cannot reset.");
							// }

							//   $('.bs-example-modal-xl').modal('show');
							// document.getElementById('popup').value = 1;


							// Store the flag to show the modal after page reload
							// sessionStorage.setItem("showModal", "true");





							window.location.reload(true);

							// localStorage.clear();
							//   sessionStorage.clear();	

							// ✅ Properly reload DataTable without full page reload
							if ($.fn.DataTable.isDataTable("#invice_list")) {
								// alert("dd");

								$("#invice_list").DataTable().ajax.reload(null, false);
								// window.location.reload(true);
							}

							// ✅ Clear session/local storage to prevent cache issues
							localStorage.clear();
							sessionStorage.clear();


							//   window.location.reload(true);
							// location.reload();



							// Reload DataTable
							// $("#invice_list").DataTable().clear().draw();	
							// location.reload();

						},
						error: function (data) {
							alert("Network Error");
						}
					});
				}

			}
		}

		// 		myupval();
		// 			var myvalues = document.getElementById('popup').value;
		// 		alert(myvalues);

		// 		if(myvalues){




		//   document.getElementById('popup').value = 1;
		//  $('#myassign_modal').modal('show');
		// 		}
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
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			cache: false,
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

	function invoice_data_delete(unique_id = "") {
		
		var unique_id = document.getElementById('unique_id').value;

		var form_main_unique_id = document.getElementById('form_main_unique_id').value;
		var invoice_auto_id = document.getElementById('invoice_auto_id').value;
		var consignee_unique_id = document.getElementById('consignee_unique_id').value;



		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		confirm_delete('delete')
			.then((result) => {
				if (result.isConfirmed) {
					var data = {
						"unique_id": unique_id,
						"form_main_unique_id": form_main_unique_id,
						"invoice_auto_id": invoice_auto_id,
						"consignee_unique_id": consignee_unique_id,

						"action": "invoice_data_delete"
					}
					$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						success: function (data) {
							var obj = JSON.parse(data);
							var msg = obj.msg;
							var status = obj.status;
							var error = obj.error;
							if (!status) {
								url = '';
							} else {
								sub_list_datatable("invoice_data_delete");
							}
							// sweetalert(msg, url);
							sweetalert(msg);
							window.location.reload(true);

						}
					});
				} else {
					// alert("cancel");
				}
			});
		// }
	}
</script>
<?php


function consignee_select($unique_id = "")
{
	global $pdo;

	// Auto-heal DB: If any consignee has remaining unbilled stock or remaining items to assign/bill,
	// ensure inv_cons_status is reset to 0 so they remain available and active in DB.
	if (!empty($unique_id)) {
		$pdo->query("UPDATE consignee_details_sub cds 
			SET cds.inv_cons_status = 0 
			WHERE cds.form_main_unique_id = '" . $unique_id . "' 
			  AND cds.inv_cons_status = 1 
			  AND cds.is_delete = 0 
			  AND (
				(SELECT COUNT(id) FROM invoice_creation ic WHERE ic.consignee_id = cds.unique_id AND ic.is_delete = 0) = 0
				OR (SELECT IFNULL(SUM(stock_qty), 0) - IFNULL(SUM(billed_qty), 0) FROM stock_position WHERE form_main_unique_id = cds.form_main_unique_id AND is_delete = 0) > 0
				OR (SELECT IFNULL(total_qty, 0) FROM po_form WHERE unique_id = cds.form_main_unique_id) > (SELECT IFNULL(SUM(invoice_qty), 0) FROM invoice_creation WHERE po_unique_id = cds.form_main_unique_id AND is_delete = 0)
				OR (SELECT COUNT(id) FROM po_product_assign_details WHERE con_unique_id = cds.unique_id AND is_delete = 0 AND (assign_qty = 0 OR assign_qty < qty)) > 0
			  )");
	}
	
	$table_name = "consignee_details_sub";
	$table_columns = [
		"unique_id",
		"IF(con_branch IS NOT NULL AND TRIM(con_branch) != '', CONCAT(TRIM(con_branch), ' - ', TRIM(con_address)), IF(con_contact_name IS NOT NULL AND TRIM(con_contact_name) != '', CONCAT(TRIM(con_contact_name), ' - ', TRIM(con_address)), con_address)) AS con_address",
	];
	$table_details = [
		$table_name,
		$table_columns
	];

	// Consignee is available in dropdown if:
	// 1. inv_cons_status = 0
	// OR 2. Consignee has NO invoices at all
	// OR 3. Total invoiced quantity is less than assigned quantity
	// OR 4. Has products in po_product_assign_details with pending assignment (assign_qty = 0 or assign_qty < qty)
	// OR 5. PO or stock still has remaining unbilled quantity
	$where = "is_active = 1 and is_delete = 0 and form_main_unique_id = '" . $unique_id . "' 
	AND (
		inv_cons_status = 0 
		OR (SELECT COUNT(id) FROM invoice_creation WHERE invoice_creation.consignee_id = consignee_details_sub.unique_id AND invoice_creation.is_delete = 0) = 0
		OR (SELECT IFNULL(SUM(invoice_qty), 0) FROM invoice_creation WHERE invoice_creation.consignee_id = consignee_details_sub.unique_id AND invoice_creation.is_delete = 0) < (SELECT IFNULL(SUM(assign_qty), 0) FROM po_product_assign_details WHERE po_product_assign_details.con_unique_id = consignee_details_sub.unique_id AND po_product_assign_details.is_delete = 0)
		OR (SELECT COUNT(id) FROM po_product_assign_details WHERE con_unique_id = consignee_details_sub.unique_id AND is_delete = 0 AND (assign_qty = 0 OR assign_qty < qty)) > 0
		OR (SELECT IFNULL(SUM(stock_qty), 0) - IFNULL(SUM(billed_qty), 0) FROM stock_position WHERE form_main_unique_id = consignee_details_sub.form_main_unique_id AND is_delete = 0) > 0
		OR (SELECT IFNULL(total_qty, 0) FROM po_form WHERE unique_id = consignee_details_sub.form_main_unique_id) > (SELECT IFNULL(SUM(invoice_qty), 0) FROM invoice_creation WHERE po_unique_id = consignee_details_sub.form_main_unique_id AND is_delete = 0)
	)";

	$consignee_details_sub = $pdo->select($table_details, $where);

	if ($consignee_details_sub->status) {
		return $consignee_details_sub->data;
	} else {
		return [];
	}
}

?>
