<!-- This file Only PHP Functions -->
<?php
require_once __DIR__ . '/../../config/env.php';
include 'function.php'; ?>

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


		$table = "view_stock_position_list";

		$columns = [
			"po_unique_id",
			"po_num",
			"po_date",
			"bill_address",
			"contact_number",
			"email",
			"contact_name",
			"get_department_name(department) AS department",
			"get_district_name(cusdistrict) as district_name",
			"get_state_name(cusstate_name) as state_name",
			"get_executive_name(executive_name) AS executive_name",
			"(select count(*) from consignee_details_sub WHERE consignee_details_sub.form_main_unique_id=" . $table . ".unique_id and consignee_details_sub.is_delete='0')no_of_consignee",
			"no_of_po",
			"qty",
			"net_value",
			"status",
			"unique_id",
			"get_total_stock_qty(unique_id) AS stock_quantity"
		];

		$table_details = [
			$table,
			$columns
		];

		$result_values = $pdo->select($table_details, $where);
		// print_r($result_values);die();
		if ($result_values->status) {

			$result_values = $result_values->data;

			$po_unique_id = $result_values[0]["po_unique_id"];
			$po_num = $result_values[0]["po_num"];
			// $po_date          = $result_values[0]["po_date"];
			$department = $result_values[0]["department"];
			$executive_name = $result_values[0]["executive_name"];
			$no_of_consignee = $result_values[0]["no_of_consignee"];
			$no_of_po = $result_values[0]["no_of_po"];
			$qty = $result_values[0]["qty"];
			$net_value = moneyFormatIndia1($result_values[0]["net_value"]);
			$net_value1 = $result_values[0]["net_value"];
			// moneyFormatIndia1($stock_value);
			$status = $result_values[0]["status"];
			$stock_id = $result_values[0]["stock_id"];
			$under_user_type = $result_values[0]["under_user_type"];
			$main_unique_id = $result_values[0]["unique_id"];

			$exe_unique_id = $result_values[0]["executive_name"];

			$bill_address = $result_values[0]["bill_address"];
			$contact_number = $result_values[0]["contact_number"];
			$email = $result_values[0]["email"];
			$contact_name = $result_values[0]["contact_name"];
			$district_name = $result_values[0]["district_name"];
			$state_name = $result_values[0]["state_name"];
			$stock_quantity = $result_values[0]["stock_quantity"];


			$orgDate = $result_values[0]["po_date"];
			$po_date = date("d-m-Y", strtotime($orgDate));


			$btn_text = "Update";
			$btn_action = "update";
		} else {
			$btn_text = "Error";
			$btn_action = "error";
			$is_btn_disable = "disabled='disabled'";
		}
	}
}

$stock_quantity = $qty - $stock_quantity;

$active_status_options = active_status($is_active);


?>

<style>
	.no-stock {
		display: inline-block;
		width:
			/* match input width */
		;
		text-align: center;
		color: #888;
	}

	.head_po {
		font-size: .875rem;
		margin-bottom: .3125rem;
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
					<li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
					<li class="breadcrumb-item active"> Stock Position </li>
				</ol>
			</div>

		</div>
	</div>
</div>


<!-- <?= $unique_id ?> -->
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
									<strong> <?php
echo $department ?> </strong>
								</h6>
								<p class="text-body-primary mb-3"> <?php
echo $bill_address ?>,
									<?php
echo $district_name ?> </br><?php
echo $state_name ?>
								</p>
								<!-- Text -->
								<p class=""><span><i data-feather="phone"
											style="width:15px; height:15px; color:#506018 "></i></span>
									<?php
echo !empty($contact_number) ? $contact_number : '--'; ?>
								</p>
								<!-- Text -->
								<p class="mb-4"><span><i data-feather="mail"
											style="width:15px; height:15px;color:#506018"></i></span>
									<?php
echo !empty($email) ? $email : '--'; ?>
								</p>

							</div>
							<div class="col-12 col-md-4"></div>
							<div class="col-12 col-md-4">
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php
echo $po_num ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php
echo $po_date ?></div>
								</div>

								<div class="row">
									<div class="col-xl-4 text-body-secondary"> <label for="main_screen"
											class="form-label">Executive Name</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7 text_style"><?php
echo $executive_name ?></div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Consignee</label>
									<div class="text_style fw-bold"><?php
echo $no_of_consignee ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">No.Of Items</label>
									<div class="text_style fw-bold"><?php
echo $no_of_po ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">QTY</label>
									<div class="text_style fw-bold"><?php
echo $qty ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">Value</label>
									<div class="text_style fw-bold"><?php
echo $net_value ?></div>
								</div>
								<div class="col-12 col-md-2 mb-3">
									<label class="form-label text-body-secondary d-block">Remaining Qty</label>
									<div class="text_style fw-bold"><?php
echo $stock_quantity ?></div>
								</div>

								<input type="hidden" id="stock_status" name="stock_status" class="form-control"
									value="<?php
echo $status; ?>">
								<input type="hidden" id="department" name="department" class="form-control"
									value="<?php
echo $department; ?>">

							</div>

							<div class="row">
								<div class="col-12 mt-3">
									<div class="table-responsive mb-4">
										<!-- <h6>Stock Sub Id - <?php
echo stock_sub_id(); ?></h6> -->
										<table
											class="table table-striped table-bordered align-middle table mb-0 small_table">
											<thead>
												<!-- class="table-light" -->
												<tr>
													<th>S.No</th>
													<!-- <th scope="col">Item Code</th> -->
													<th scope="col">Item Details</th>
													<!-- <th scope="col">Item Spec.</th> -->
													<th scope="col">Order QTY</th>
													<th scope="col">Remaining QTY </th>
													<!--<th scope="col">Billed QTY</th>-->
													<th scope="col">Stock QTY </th>
													<th scope="col">Balance. QTY</th>
													<th scope="col">Part No.</th>
													<th scope="col">Due Date</th>
													<th scope="col">Due Days</th>
												</tr>
											</thead>
											<tbody>


												<?php
// $where2 = "form_main_unique_id = '".$main_unique_id."'";
												// $lu = 1;
												$get_stock_position = get_stock_position($main_unique_id);
												// print_r($get_stock_position);
												foreach ($get_stock_position as $key => $form_val) {
													// print_r($form_val);
													if (($form_val['form_main_unique_id'] == '') && ($form_val['product_count'] == 0)) {
														// print_r('hi');
														$where1 = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "'";
														$table1 = "product_details_sub";

														$columns1 = [
															"(SELECT item_code FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code group by  item_creation_sub.unique_id) AS item_code ",
															"product",
															"(SELECT item_specification FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code group by  item_creation_sub.unique_id) AS item_specification ",
															"qty",
															"billed_qty",
															"tax",
															"unit_price",
															"net_price",
															"form_main_unique_id",
															"unique_id",
															"delivery_due_dates",
															"(SELECT po_date FROM po_form WHERE po_form.unique_id = $table1.form_main_unique_id  group by  po_form.unique_id) AS po_date_wise_product ",
															"(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = $table1.form_main_unique_id group by  po_form.unique_id) AS delivery_due_dates_org ",
														];

														$table_details1 = [
															$table1,
															$columns1
														];
													} else {
														// print_r('hooooi');

														$where1 = "is_delete = '0' AND form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'";

														$table1 = "(SELECT * FROM stock_position sp
            INNER JOIN (
                SELECT MAX(id) AS max_id
                FROM stock_position
                WHERE is_delete = '0' AND form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'
                GROUP BY product_unique_id
            ) AS latest ON sp.id = latest.max_id) AS stock_position";

														$columns1 = [
															"stock_position.item_code",
															"stock_position.product",
															"stock_position.item_qty",
															"stock_position.billed_qty",
															"stock_position.form_main_unique_id",
															"stock_position.total_qty",
															"stock_position.net_value",
															"stock_position.po_num",
															"stock_position.po_date",
															"stock_position.executive_name",
															"stock_position.no_of_consignee",
															"stock_position.no_of_item",
															"stock_position.product_unique_id",
															"stock_position.stock_qty",
															"stock_position.remaining_qty",
															"stock_position.part_no",
															"(SELECT SUM(stock_value) FROM stock_position_main WHERE form_main_unique_id = stock_position.form_main_unique_id) AS stock_value",
															"stock_position.unique_id",
															"stock_position.stock_id",
															"stock_position.unit_price",
															"stock_position.net_price",
															"stock_position.product_tax",
															"(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = stock_position.product_unique_id LIMIT 1) AS delivery_due_dates",
															"(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = stock_position.form_main_unique_id LIMIT 1) AS delivery_due_dates_org"
														];

														$table_details1 = [
															$table1,
															$columns1
														];

														// $where1 = "is_delete = '0' AND form_main_unique_id = '" . $form_val['form_main_unique_id'] . "'GROUP BY product_unique_id";
														// $table1 = "stock_position";
														// $columns1 = [
														// 	"item_code",
														// 	"product",
														// 	"item_qty",
														// 	"billed_qty",
														// 	"form_main_unique_id",
														// 	"total_qty",
														// 	"net_value",
														// 	"po_num",
														// 	"po_date",
														// 	"executive_name",
														// 	"no_of_consignee",
														// 	"no_of_item",
														// 	"product_unique_id",
														// 	"stock_qty",
														// 	"remaining_qty",
														// 	"part_no",
														// 	"(SELECT SUM(stock_value) FROM stock_position_main WHERE form_main_unique_id = stock_position.form_main_unique_id GROUP BY form_main_unique_id) AS stock_value",
														// 	"unique_id",
														// 	"stock_id",
														// 	"unit_price",
														// 	"product_tax",
														// 	"(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = stock_position.product_unique_id GROUP BY product_details_sub.form_main_unique_id) AS delivery_due_dates",
														// 	"(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = stock_position.form_main_unique_id GROUP BY stock_position.form_main_unique_id) AS delivery_due_dates_org"
														// ];
												
														// $table_details1 = [
														// 	$table1,
														// 	$columns1
														// ];
												
													}
													$values_product = $pdo->select($table_details1, $where1);


													// print_r($values_product);die(); 
													$lu = 1;
													if ($values_product->status) {

														$product_array = $values_product->data;

														foreach ($product_array as $key => $product) {


															// $product['s_no'] = $sno + 1;
															if ($product['product_unique_id']) {

																// print_r($product);die();
																$remaining_qty = $product['item_qty'] - $product['stock_qty'];
																if ($product['billed_qty']) {
																	$billed_qty = $product['billed_qty'];
																} else {
																	$billed_qty = '0';
																}

																$today = date("d-m-Y");

																// New changes start
																$po_date_2 = $product['po_date']; // Example: '12-03-2024'
																$delivery_due_days_1 = $product['delivery_due_dates'];
																$delivery_due_days_2 = $product['delivery_due_dates_org'];
																// print_r($delivery_due_days_2);die();
												
																if ($delivery_due_days_1 != '') {
																	$delivery_due_days = (int) $product['delivery_due_dates'];
																} else {
																	$delivery_due_days = (int) $product['delivery_due_dates_org'];
																}


																// Print the PO date for reference
																$product_po_date = '<span class="po_date">' . $po_date_2 . '</span>';

																// Create DateTime object from the PO date in 'd-m-Y' format
																$poDate = DateTime::createFromFormat('Y-m-d', strip_tags($product['po_date']));

																// // Modify the date by adding delivery due days
																$poDate->modify('+' . $delivery_due_days . ' days');
																// print_r($poDate);die();
												
																// Format the resulting date in 'd-m-Y'
																$resultDate = $poDate->format('d-m-Y');

																// Get the current date
																$currentDate = new DateTime();
																// print_r($currentDate);die();
																if ($poDate < $currentDate) {
																	$product['delivery_due_dates'] = "<span class='d_date' style='color: red;text-align:right;'>$resultDate</span>";
																} else {
																	$product['delivery_due_dates'] = "<span class='d_date' style='color: green;text-align:right;'>$resultDate</span>";
																}
																// end 
												
																// print_r($po_date_2);die();
																?>

																<tr>
																	<!-- <td><?php
echo $lu; ?></td> -->
																	<td><?php
echo $lu++;; ?></td>
																	<td>
																		<span
																			class="item-code"><?php
echo $product['item_code']; ?></span><br>
																		<span
																			class="product-name"><?php
echo $product['product']; ?></span>
																	</td>
																	<!-- <td><?php
echo $product['item_specification'] ?></td> -->
																	<td style="text-align: right;"><?php
echo $product['item_qty'] ?>
																	</td>
																	<td style="text-align: right;">
																		<?php
if ($product['remaining_qty']) {
																			// echo '<span id="remaining_qty" class="form-control-plaintext" style="display:block;text-align:right;">' . $product['remaining_qty'] . '</span>';
																			echo '<input type="text" id="remaining_qty" name="remaining_qty[]" class="form-control" value ="' . $product['remaining_qty'] . '" readonly style="border:none;text-align:right;">';
																		} else {
																			echo '0';
																		} ?>
																	</td>
																	<td>
																		<div class="">
																			<input type="hidden" id="remqtyVal" name="remqtyVal[]"
																				class="form-control"
																				value="<?php
echo $product['remaining_qty']; ?>">
																			<input type="hidden" id="unique_id" name="unique_id[]"
																				class="form-control"
																				value="<?php
echo $product['unique_id']; ?>">
																			<input type="hidden" id="unit_price" name="unit_price[]"
																				class="form-control"
																				value="<?php
echo $product['unit_price']; ?>">
																				<input type="hidden" id="net_price" name="net_price[]"
																				class="form-control"
																				value="<?php
echo $product['net_price']; ?>">

																			<input type="hidden" id="main_unique_id"
																				name="main_unique_id" class="form-control"
																				value="<?php
echo $product['form_main_unique_id']; ?>">
																			<input type="hidden" id="product_unique_id"
																				name="product_unique_id[]" class="form-control"
																				value="<?php
echo $product['product_unique_id']; ?>">
																			<input type="hidden" id="stock_date" name="stock_date[]"
																				class="form-control" value="<?php
echo $today; ?>">
																			<input type="hidden" id="po_num" name="po_num"
																				class="form-control" value="<?php
echo $po_num; ?>">
																			<input type="hidden" id="po_unique_id" name="po_unique_id"
																				class="form-control"
																				value="<?php
echo $po_unique_id; ?>">

																			<input type="hidden" id="po_date" name="po_date"
																				class="form-control" value="<?php
echo $po_date; ?>">
																			<input type="hidden" id="exe_name" name="exe_name"
																				class="form-control"
																				value="<?php
echo $exe_unique_id; ?>">
																			<input type="hidden" id="no_of_items" name="no_of_items"
																				class="form-control" value="<?php
echo $no_of_po; ?>">
																			<input type="hidden" id="no_of_con" name="no_of_con"
																				class="form-control"
																				value="<?php
echo $no_of_consignee; ?>">

																			<input type="hidden" id="total_qty" name="total_qty"
																				class="form-control" value="<?php
echo $qty; ?>">

																			<input type="hidden" id="net_value" name="net_value"
																				class="form-control" value="<?php
echo $net_value1;?>">

																			<input type="hidden" id="item_code" name="item_code[]"
																				class="form-control"
																				value="<?php
echo $product['item_code']; ?>">
																			<input type="hidden" id="item_name" name="item_name[]"
																				class="form-control"
																				value="<?php
echo $product['product']; ?>">
																			<input type="hidden" id="item_qty" name="item_qty[]"
																				class="form-control"
																				value="<?php
echo $product['item_qty']; ?>">

																			<input type="hidden" id="billed_qty" name="billed_qty[]"
																				class="form-control" value="<?php
echo $billed_qty; ?>">
																			<input type="hidden" id="product_tax" name="product_tax[]"
																				class="form-control"
																				value="<?php
echo $product['product_tax']; ?>">
																			<input type="hidden" id="rem_ext_qty" name="rem_ext_qty[]"
																				class="form-control"
																				value="<?php
echo $remaining_qty; ?>">

																			<?php
if ($unique_id != '') { ?>
																				<input type="hidden" id="remaining_qty"
																					name="remaining_qty[]" class="form-control"
																					value="<?php
echo $remaining_qty; ?>" readonly>

																				<input type="text" id="stock_qty" name="stock_qty[]"
																					class="form-control" onkeyup="rem_qty_update(this);">
																				<input type="hidden" id="update_stock_value"
																					name="update_stock_value[]" class="form-control"
																					readonly>
																			<?php
} else { ?>
																				<input type="hidden" id="stock_qty" name="stock_qty[]"
																					class="form-control"
																					value="<?php
echo $product['stock_qty']; ?>" required>
																				<input type="hidden" id="update_stock_value"
																					name="update_stock_value[]" class="form-control"
																					value="<?php
echo $product['stock_value']; ?>" required>
																			<?php
}
																			?>

																			<input type="hidden" id="deleivery_due_dates"
																				name="deleivery_due_dates[]" class="form-control"
																				value="<?php
echo $product['deleivery_due_dates']; ?>">

																			<input type="hidden" id="update_stock_qty"
																				name="update_stock_qty[]" class="form-control"
																				value="<?php
echo $product['stock_qty']; ?>" required>
																			<input type="hidden" id="update_stock_value"
																				name="update_stock_value[]" class="form-control"
																				value="<?php
echo $product['stock_value']; ?>" required>
																			<input type="hidden" name="delivery_due_date[]"
																				id="delivery_due_date"
																				value="<?php
echo $resultDate; ?>">
																		</div>
																	</td>

																	<?php
if ($unique_id != '') { ?>
																		<td>
																			<!-- <span id="remaining_qty_ex" class="form-control-plaintext"
																				style="display:block;text-align:right;"><?php
echo $product['remaining_qty']; ?></span> -->

																			<input type="text" id="remaining_qty_ex" style="border:none;text-align:right;"
																				name="remaining_qty_ex[]" class="form-control"
																				value="<?php
echo $product['remaining_qty']; ?>" readonly>
																		</td>
																		<td>
																			<input type="text" id="part_no" name="part_no[]"
																				class="form-control"
																				value="<?php
echo $product['part_no']; ?>" readonly>
																		</td>
																	<?php
} ?>
																	<td><?php
echo $product['delivery_due_dates']; ?></td>

																	<td style="text-align: right;"><span
																			style='text-align:right;'><?php
echo $delivery_due_days ?></span>
																	</td>
																</tr>

															<?php
} else {
																// echo "else working";
																$remaining_qty = $product['qty'] - $product['stock_qty'];
																if ($product['billed_qty']) {
																	$billed_qty = $product['billed_qty'];
																} else {
																	$billed_qty = '0';
																}

																$today = date("d-m-Y");
																// new changes start
																$po_date_2 = $product['po_date_wise_product']; // e.g., '2024-12-31'
																// print_r($po_date_2 );die();
																$delivery_due_days_1 = $product['delivery_due_dates'];
																$delivery_due_days_2 = $product['delivery_due_dates_org'];
																if ($delivery_due_days_1 != '') {
																	$delivery_due_days = (int) $product['delivery_due_dates'];
																} else {

																	$delivery_due_days = (int) $product['delivery_due_dates_org'];
																}

																$product_po_date = '<span class="po_date">' . $po_date_2 . '</span>';

																$poDate = DateTime::createFromFormat('Y-m-d', strip_tags($po_date_2));

																$poDate->modify('+' . $delivery_due_days . ' days');
																$resultDate = $poDate->format('d-m-Y'); // Ensure this line is correct;
																$currentDate = new DateTime();

																if ($poDate < $currentDate) {
																	$product['delivery_due_dates'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
																} else {
																	$product['delivery_due_dates'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
																}


																// new changes	end	// 
												
																?>

																<tr>
																	<!-- <td><?php
echo $lu; ?></td> -->
																	<td><?php
echo $lu++;; ?></td>
																	<td>
																		<span
																			class="item-code"><?php
echo $product['item_code']; ?></span><br>
																		<span
																			class="product-name"><?php
echo $product['product']; ?></span>
																	</td>
																	<!-- <td><?php
echo $product['item_specification'] ?></td> -->
																	<td style="text-align: right;"><?php
echo $product['qty'] ?></td>
																	<td>
																		<?php
if ($remaining_qty) {
																			// echo '<span id="remaining_qty" class="form-control-plaintext" style="display:block;text-align:right;">' . $remaining_qty . '</span>';

																			echo '<input type="text" id="remaining_qty" name="remaining_qty[]" class="form-control" value ="' . $remaining_qty . '"readonly style="border:none;text-align:right;">';
																		} else {
																			echo '0';
																		} ?>
																	</td>
																	<td>
																		<div class="">
																			<input type="hidden" id="remqtyVal" name="remqtyVal[]"
																				class="form-control" value="0">

																			<input type="hidden" id="unit_price" name="unit_price[]"
																				class="form-control"
																				value="<?php
echo $product['unit_price']; ?>">
																				<input type="hidden" id="net_price" name="net_price[]"
																				class="form-control"
																				value="<?php
echo $product['net_price']; ?>">

																			<input type="hidden" id="unique_id" name="unique_id[]"
																				class="form-control">
																			<input type="hidden" id="main_unique_id"
																				name="main_unique_id" class="form-control"
																				value="<?php
echo $product['form_main_unique_id']; ?>">
																			<input type="hidden" id="product_unique_id"
																				name="product_unique_id[]" class="form-control"
																				value="<?php
echo $product['unique_id']; ?>">
																			<input type="hidden" id="stock_date" name="stock_date[]"
																				class="form-control" value="<?php
echo $today; ?>">
																			<input type="hidden" id="po_num" name="po_num"
																				class="form-control" value="<?php
echo $po_num; ?>">

																			<input type="hidden" id="po_unique_id" name="po_unique_id"
																				class="form-control"
																				value="<?php
echo $po_unique_id; ?>">
																			<input type="hidden" id="po_date" name="po_date"
																				class="form-control" value="<?php
echo $po_date; ?>">
																			<input type="hidden" id="exe_name" name="exe_name"
																				class="form-control"
																				value="<?php
echo $exe_unique_id; ?>">
																			<input type="hidden" id="no_of_items" name="no_of_items"
																				class="form-control" value="<?php
echo $no_of_po; ?>">
																			<input type="hidden" id="no_of_con" name="no_of_con"
																				class="form-control"
																				value="<?php
echo $no_of_consignee; ?>">

																			<input type="hidden" id="total_qty" name="total_qty"
																				class="form-control" value="<?php
echo $qty; ?>">

																			<input type="hidden" id="net_value" name="net_value"
																				class="form-control" value="<?php
echo $net_value1;?>">

																			<input type="hidden" id="item_code" name="item_code[]"
																				class="form-control"
																				value="<?php
echo $product['item_code']; ?>">
																			<input type="hidden" id="item_name" name="item_name[]"
																				class="form-control"
																				value="<?php
echo $product['product']; ?>">
																			<input type="hidden" id="item_qty" name="item_qty[]"
																				class="form-control"
																				value="<?php
echo $product['qty']; ?>">
																			<input type="hidden" id="product_tax" name="product_tax[]"
																				class="form-control"
																				value="<?php
echo $product['tax']; ?>">
																			<input type="hidden" id="billed_qty" name="billed_qty[]"
																				class="form-control" value="<?php
echo $billed_qty; ?>">
																			<input type="hidden" id="rem_ext_qty" name="rem_ext_qty[]"
																				class="form-control"
																				value="<?php
echo $product['qty']; ?>">

																			<input type="text" id="stock_qty" name="stock_qty[]"
																				class="form-control"
																				value="<?php
echo $product['stock_qty']; ?>" required
																				onkeyup="rem_qty_update(this);"
																				onkeypress="number_only(event)">
																			<input type="hidden" id="update_stock_qty"
																				name="update_stock_qty[]" class="form-control"
																				value="<?php
echo $product['stock_qty']; ?>" required>
																			<input type="hidden" id="update_stock_value"
																				name="update_stock_value[]" class="form-control"
																				value="<?php
echo $product['stock_value']; ?>" required>
																			<input type="hidden" name="delivery_due_date[]"
																				id="delivery_due_date"
																				value="<?php
echo $resultDate; ?>">
																		</div>
																	</td>

																	<?php
if ($unique_id != '') { ?>
																		<td>
																			<!-- <span id="remaining_qty_ex" class="form-control-plaintext"
																				style="display:block;text-align:right;"><?php
echo $remaining_qty; ?></span> -->
																			<input type="text" id="remaining_qty_ex" style="border:none;text-align:right;"
																				name="remaining_qty_ex[]" class="form-control"
																				value="<?php
echo $remaining_qty; ?>" readonly>
																		</td>
																	<?php
} ?>


																	<td>
																		<input type="text" id="part_no" name="part_no[]"
																			class="form-control"
																			value="<?php
echo $product['part_no']; ?>">
																	</td>
																	<td><?php
echo $product['delivery_due_dates']; ?></td>
																	<td style="text-align: right;"><span
																			style='text-align:right;'><?php
echo $delivery_due_days ?></span>
																	</td>



																</tr>
																<?php
// $lu++;
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
											<!-- <?php
echo btn_cancel($btn_cancel); ?> -->
											<?php
if ($product['product_unique_id'] != '') { ?>
												<button type="button" class="btn btn-primary " onclick="create()">Add
													Stock</button>
											<?php
} else { ?>
												<button type="button" class="btn btn-primary " onclick="create()">Add
													Stock</button>
											<?php
} ?>


										</div>
										<!-- <div>
								<?php
if ($product['product_unique_id'] != '') { ?>
								<div style="margin-left:150px"><span style='color: red;'><b></b>Stock Already Entered<b> </b><b> <?php
echo $product['stock_date_1']; ?> </b> QTY <?php
echo $product['stock_qty_1']; ?> </span></div>
								<?php
} ?>
								</div> -->
										<div>
											<div class="col-12 mt-3">
												<div class="table-responsive mb-4">
													<table
														class="table table-striped table-bordered align-middle  mb-0 small_table">
														<thead>
															<!-- class="table-light" -->
															<tr>
																<th>S.No</th>
																<th scope="col">Stock Id</th>
																<th scope="col">Stock Date</th>
																<!-- <th scope="col">Item Code</th> -->
																<th scope="col">Item Details</th>
																<!-- <th scope="col">Item Specification</th> -->
																<th scope="col">Order QTY</th>
																<!-- <th scope="col">Remaining QTY</th> -->
																<th scope="col">Remaining QTY</th>
																<th scope="col">Stock QTY</th>

																<th scope="col">Balance QTY</th>
															</tr>
														</thead>
														<tbody>
															<?php
// DataTable 
															$search = $_POST['search']['value'];
															$length = $_POST['length'];
															$start = $_POST['start'];
															$draw = $_POST['draw'];
															$limit = $length;

															$data = [];


															if ($length == '-1') {
																$limit = "";
															}
															$where1 = "form_main_unique_id = '" . $unique_id . "' AND is_delete=0";
															// $groupBy = "item_code,stock_date";
															$groupBy = "item_code,stock_id ORDER BY stock_id ASC";
															$limit = null;
															$start = null;
															$order_by = null;

															$table1 = "stock_position_sublist";
															$columns1 = [
																"item_code",
																"item_qty",
																"SUM(stock_qty) AS stock_qty",  // use SUM for group
																"stock_date",
																"unique_id",
																"form_main_unique_id",
																"product",
																// "billed_qty",
																"remaining_qty",
																"stock_id",
																"remqty",

																// "(select remaining_qty form $table1 where ) as bal_last qty"
															
															];

															$table_details1 = [
																$table1,
																$columns1
															];
															// $pdo->select($table_details, $where,"","","","",$group_by);
															$values_product = $pdo->select($table_details1, $where1, "", "", "", "", $groupBy);
															// print_r($values_product);die();
															$j = 1;
															if ($values_product->status) {
																$product_array = $values_product->data;
																//   print_r($product_array);
															
																$btn_update = btn_update($folder_name, $value['unique_id']);

																foreach ($product_array as $product) {
																	$stock_id = $product['stock_id'];
																	$item_code = $product['item_code'];
																	$item_qty = isset($product['item_qty']) ? (float) $product['item_qty'] : 0;
																	$stock_qty = isset($product['stock_qty']) ? (float) $product['stock_qty'] : 0;
																	$stock_date = $product['stock_date'];
																	$product_name = $product['product'];
																	?>

																	<tr>
																		<td><?php
echo $j; ?></td>
																		<td><?php
echo $stock_id; ?></td>
																		<td><?php
echo date('d-m-Y', strtotime($stock_date)); ?>
																		</td>
																		<td>
																			<span
																				class="item-code"><?php
echo $item_code; ?></span><br>
																			<span
																				class="product-name"><?php
echo $product_name; ?></span>
																		</td>
																		<td style="text-align:right;"><?php
echo $item_qty; ?>
																		</td>
																		<td style="text-align:right;"> <?php
if ($stock_qty != '0') {
																			echo htmlspecialchars($product['remqty'], ENT_QUOTES, 'UTF-8');
																		} else {
																			echo '0';
																		}
																		?></td>
																		<td style="text-align:right;"><?php
echo $stock_qty; ?>
																		</td>
																		<td style="text-align:right;">
																			<?php
echo $product['remaining_qty']; ?>
																		</td>
																	</tr>

																	<?php
$j++;
																}
															}
															// }
															?>
														</tbody>
													</table>
												</div>
											</div>
											<div class="col-md-12" align="right">
												<!-- Cancel,save and update Buttons -->
												<?php
echo btn_cancel($btn_cancel); ?>
												<!-- <?php
if ($product['product_unique_id'] != '') { ?>
													<button type="button" class="btn btn-primary " onclick="create()">Add
														Stock</button>
												<?php
} else { ?>
													<button type="button" class="btn btn-primary " onclick="create()">Add
														Stock</button>
												<?php
} ?> -->
											</div>


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

<?php
function stock_sub_id()
{
	$date = date("Y");
	$st_date = substr($date, 2);
	$month = date("m");
	$datee = $date . $month;
	$servername = 'localhost';
	$username = project_env('APP_DB_USERNAME', 'root');
	$password = project_env('APP_DB_PASSWORD');
	$databasename = "operation_team_beta";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
	} catch (PDOException $e) {
		// echo "Connection failed: " . $e->getMessage();
	}
	$stmt = $conn->query("SELECT * FROM stock_position_sublist where `stock_sub_id` LIKE 'STK%' order by unique_id desc");
	// $bill = $stmt->fetch();
	// $res_array = $bill['id'];
	// $result = $res_array + 1;


	// if($res1=$stmt->fetch($stmt))
	if ($res1 = $stmt->fetch()) {
		$pur_array = explode('-', $res1['stock_sub_id']);

		$year1 = $pur_array[1];
		$year2 = substr($year1, 0, 2);
		$year = '20' . $year2;
		$booking_no = $pur_array[2];
		// print_r($booking_no);
	}
	if ($booking_no == '')
		$booking_nos = 'STK-' . $datee . '-0001';
	elseif ($year != date("Y"))
		$booking_nos = 'STK-' . $datee . '-0001';
	else {
		$booking_no += 1;
		$booking_nos = 'STK-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
	}

	return $booking_nos;
}

?>


<!--===================================================processing table============================================-->


<!--==================================================end============================================================-->
<script>
	$(document).ready(() => {


	});
	//  document.addEventListener('DOMContentLoaded', function() {
	//   document.querySelectorAll('input[name="remaining_qty_ex[]"]').forEach(function(remInput) {
	//     const id = remInput.dataset.productId;
	//     const remVal = parseFloat(remInput.value) || 0;
	// alert(remVal);
	//     // Find the matching stock input by product ID
	//     const stockInput = document.querySelector(`input[name="stock_qty[]"][data-product-id="${id}"]`);
	//     if (!stockInput) return;

	//     if (remVal === 0) {
	//       stockInput.style.display = 'none';
	//       if (!stockInput.nextElementSibling || stockInput.nextElementSibling.className !== 'no-stock') {
	//         const dash = document.createElement('span');
	//         dash.className = 'no-stock';
	//         dash.textContent = '–';
	//         stockInput.after(dash);
	//       }
	//     } else {
	//       stockInput.style.display = '';
	//       if (stockInput.nextElementSibling?.classList.contains('no-stock')) {
	//         stockInput.nextElementSibling.remove();
	//       }
	//     }
	//   });
	// });
	$(document).ready(function () {
		const remainingQtyInputs = document.querySelectorAll('input[name="remaining_qty_ex[]"]');

		const stockQtyInputs = document.querySelectorAll('input[name="stock_qty[]"]');


		// alert(stockQtyInputs);
		for (let i = 0; i < remainingQtyInputs.length; i++) {
			const remVal = parseFloat(remainingQtyInputs[i].value) || 0;
			// alert(remVal);
			if (remVal === 0) {
				stockQtyInputs[i].style.display = "none"; // Hide input field
				stockQtyInputs[i].append('-');
			} else {
				stockQtyInputs[i].style.display = "inline-block"; // Or "block" as per layout
			}
		}
	});
	function rem_qty() {
		//   const stockQtyEls = document.getElementsByName('stock_qty[]');
		//   const itemQtyEls  = document.getElementsByName('item_qty[]');
		//   const remQtyEls   = document.getElementsByName('remaining_qty[]');

		const stockEls = document.querySelectorAll('input[name="stock_qty[]"]');
		const itemEls = document.querySelectorAll('input[name="item_qty[]"]');
		const remEls = document.querySelectorAll('input[name="remaining_qty[]"]');

		// alert(stockEls);
		// alert(itemEls);
		// alert(remEls);

		for (let i = 0; i < stockQtyEls.length; i++) {
			const stockEl = stockQtyEls[i];
			const itemEl = itemQtyEls[i];
			const remEl = remQtyEls[i];

			const stockVal = parseFloat(stockEl.value) || 0;
			const itemVal = parseFloat(itemEl.value) || 0;

			if (stockVal > itemVal) {
				// alert("if running");
				alert("Stock quantity can't be greater than item quantity.");
				stockQtyEls[i].value = '';         // ✅ Clear this input only
				remEl.value = itemVal.toFixed(2);  // Reset remainder
			} else {
				// alert("else running");
				remEl.value = (itemVal - stockVal).toFixed(2);
			}
		}
	}

	// function rem_qty() {
	//   const stockQtyEls = document.getElementsByName('stock_qty[]');
	//   const itemQtyEls = document.getElementsByName('item_qty[]');
	//   const remQtyEls = document.getElementsByName('remaining_qty[]');

	//   // Loop over the parallel arrays
	//   for (let i = 0; i < stockQtyEls.length; i++) {
	//     const stockEl = stockQtyEls[i];
	//     const itemEl = itemQtyEls[i];
	//     const remEl = remQtyEls[i];

	//     const stockVal = parseFloat(stockEl.value) || 0;
	//     const itemVal = parseFloat(itemEl.value) || 0;

	//     // If stock > item quantity — that's invalid
	//     if (stockVal > itemVal) {
	//       alert("Stock quantity can't be greater than item quantity.");
	//     //   stockEl.value = '';   
	// 	  stockQtyEls.value = ''         // Clear invalid input
	//       remEl.value = itemVal;         // Reset to full remaining qty
	//     } else {
	//       remEl.value = (itemVal - stockVal).toFixed(2);
	//     }
	//   }
	// }

	function rem_qty12() {
		var stock_qty = document.getElementsByName('stock_qty[]');
		var item_qty = document.getElementsByName('item_qty[]');
		var rem_qty = document.getElementsByName('remaining_qty[]');

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = parseFloat(stock_qty[i].value) || 0;
			var item_qty_val = parseFloat(item_qty[i].value) || 0;

			if (stock_qty_val > item_qty_val) {
				alert("Stock quantity can't be greater than remaining value.");
				stock_qty[i].value = ''; // Fix: target the element, not the string
				rem_qty[i].value = item_qty_val;
			} else {
				var rem_val = item_qty_val - stock_qty_val;
				var rem_qty_val = rem_qty[i];
				rem_qty_val.value = rem_val;
			}

		}

	}



	// 	function valid_alphanumeric(input) {
	//     input.value = input.value.replace(/[^a-zA-Z0-9]/g, '');
	//   }

	// 	//function rem_qty_update() {
	//     var stock_qty = document.getElementsByName('stock_qty[]');
	//     var item_qty = document.getElementsByName('item_qty[]');
	//     var rem_qty = document.getElementsByName('remaining_qty[]');
	//     var rem_qty_value = document.getElementsByName('rem_ext_qty[]');

	//     for (var i = 0; i < stock_qty.length; i++) {
	//         var stock_qty_val = parseFloat(stock_qty[i].value) || 0;
	//         var item_qty_val = parseFloat(item_qty[i].value) || 0;
	//         var rem_value = parseFloat(rem_qty_value[i].value) || 0;

	//         if (stock_qty_val > rem_value) {
	//             alert("Stock quantity can't be greater than remaining value.");
	//             stock_qty[i].value = ''; // Fix: target the element, not the string
	//             rem_qty[i].value = rem_value;
	//         } else {
	//             var rem_val = rem_value - stock_qty_val;
	//             rem_qty[i].value = rem_val;
	//         }
	//     }
	// }


	// new changes
	function rem_qty1() {
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
	function rem_qty_update(elm) {
		// alert();
		var row = elm.closest('tr'); // get the current row only

		var stockQtyInput = row.querySelector('[name="stock_qty[]"]');
		var itemQtyInput = row.querySelector('[name="item_qty[]"]');
		var remainingQtyInput = row.querySelector('[name="remaining_qty[]"]');
		var remaining_qty = row.querySelector('[name="remaining_qty_ex[]"]');

		var stockQty = parseInt(stockQtyInput.value) || 0;
		// alert(stockQty);
		var remaining = parseInt(remainingQtyInput.value) || 0;
		var itemQtyInput = parseInt(itemQtyInput.value) || 0;
		var remaining_qty_ex = parseInt(remaining_qty.value) || 0;
		// alert(remaining_qty_ex);
		// alert(remaining);
		// prevent negative or invalid input
		if (stockQty < 0) {
			alert("Stock quantity cannot be negative!");
			stockQtyInput.value = 0;
			stockQty = 0;
		}

		// optional: clamp to max allowed
		if (stockQty > remaining) {
			alert("Stock quantity cannot exceed item quantity!");
			// stockQtyInput.value = stockQty;
			stockQtyInput.value = '';
			stockQty = remaining;
		} else {

			// remainingQtyInput.value = remaining - stockQty;
			remaining_qty.value = remaining - stockQty;
		}
		// alert(remaining_qty.value);
	}


	$(document).ready(function () {
		stock_status = $('#stock_status').val();
		// alert(stock_status);
		if (stock_status == '') {
			window.location = "index.php?file=stock_position/list";
		}
	});

	// new JSON Format
	function collectStockPayload() {
		const payload = {
			unique_id: document.getElementById('unique_id').value,
			main_unique_id: document.getElementById('main_unique_id').value,
			stock_date: document.getElementById('stock_date').value,
			po_date: document.getElementById('po_date').value,
			po_num: document.getElementById('po_num').value,
			po_unique_id: document.getElementById('po_unique_id').value,
			exe_name: document.getElementById('exe_name').value,
			no_of_items: document.getElementById('no_of_items').value,
			no_of_con: document.getElementById('no_of_con').value,
			department: document.getElementById('department').value,
			total_qty: document.getElementById('total_qty').value,
			net_value: document.getElementById('net_value').value,




			totals: {
				total_item_qty: 0,
				total_stock_qty: 0,
				total_stock_value: 0,
				total_update_qty: 0,
				total_update_value: 0
			},
			products: []
		};

		const rows = document.getElementsByName('stock_qty[]').length;

		for (let i = 0; i < rows; i++) {
			const itemQty = parseFloat(document.getElementsByName('item_qty[]')[i].value) || 0;
			const stockQty = parseFloat(document.getElementsByName('stock_qty[]')[i].value) || 0;
			const up = parseFloat(document.getElementsByName('unit_price[]')[i].value) || 0;
			const net = parseFloat(document.getElementsByName('net_price[]')[i].value) || 0;
			const tx = parseFloat(document.getElementsByName('product_tax[]')[i].value) || 0;
			const updQty = parseFloat(document.getElementsByName('update_stock_qty[]')[i].value) || 0;
			const rems_qty = parseFloat(document.getElementsByName('remaining_qty_ex[]')[i].value) || 0;

			// if(document.getElementsByName('remqtyVal[]')[i].value == 0){
			//  	const remqtyVal   = itemQty;
			// }else{
			//  	const remqtyVal   = document.getElementsByName('remqtyVal[]')[i].value;
			// }

			// const stockVal = stockQty * up * (1 + tx / 100);
			const stockVal = stockQty * net;
			// alert(stockVal);
			const updVal = updQty * up * (1 + tx / 100);

			payload.totals.total_item_qty += itemQty;
			payload.totals.total_stock_qty += stockQty;
			payload.totals.total_stock_value += stockVal;
			payload.totals.total_update_qty += updQty;
			payload.totals.total_update_value += updVal;
			// payload.totals.total_rems_qty+= rems_qty;


			payload.products.push({
				unique_id: document.getElementsByName('unique_id[]')[i].value,
				product_unique_id: document.getElementsByName('product_unique_id[]')[i].value,
				item_code: document.getElementsByName('item_code[]')[i].value,
				item_name: document.getElementsByName('item_name[]')[i].value,
				billed_qty: document.getElementsByName('billed_qty[]')[i].value,
				remqtyVal: document.getElementsByName('remqtyVal[]')[i].value,

				item_qty: itemQty,
				//   remaining_qty: document.getElementsByName('remaining_qty[]')[i].value,
				remaining_qty: rems_qty,
				stock_qty: stockQty,
				update_stock_qty: updQty,
				unit_price: up,
				net_price: net,
				product_tax: tx,
				part_no: document.getElementsByName('part_no[]')[i].value,
				stock_value: stockVal,
				update_stock_value: updVal
			});
		}

		return payload;
	}

	function create() {
		// alert("hii");
		const data = collectStockPayload();
// alert(data);

		console.log(data);
		var unique_id = document.getElementById('unique_id').value;
		var item_qty = document.getElementsByName('item_qty[]');


		var stock_qty = document.getElementsByName('stock_qty[]');
		var update_stock = document.getElementsByName('update_stock_qty[]');
		var update_stock_value = document.getElementsByName('update_stock_value[]');
		var part_no = document.getElementsByName('part_no[]');
		var rem_qty = document.getElementsByName('remaining_qty[]');
		// var rem_ext_qty = document.getElementsByName('rem_ext_qty[]');
		var stock_qty_total = [];
		var item_qty_total = [];
		var stock_qty_amt = [];
		var update_stock_qty_amt = [];
		var update_qty_amt = [];
		

		// Check if any remaining qty is empty
		for (var i = 0; i < stock_qty.length; i++) {
			// alert(stock_qty.length);
			// if (stock_qty[i].value === '' || stock_qty[i].value === 0) {
			// 	Swal.fire({
			// 		icon: 'error',
			// 		text: 'Please enter stock quantity for all items.',
			// 	});
			// 	return;
			// }
		}

		$.ajax({
			url: 'folders/stock_position/crud1.php',
			method: 'POST',
			contentType: 'application/json',
			data: JSON.stringify({ action: 'create_stock', data }),

			success: function (res) {
				if (res.status) {
					alert('Stock saved successfully!');
					location.reload();

				} else {
					alert('Error: ' + res.error);
				}
			},
			error: function () {
				alert('Request failed.');
			}
		});
	}
	
	
	
	
	function createjson() {
		// Gather header-level info
		const payload = {
			unique_id: document.getElementById('unique_id').value,
			stock_date: document.getElementById('stock_date').value,
			po_date: document.getElementById('po_date').value,
			main_unique_id: document.getElementById('main_unique_id').value,
			po_num: document.getElementById('po_num').value,
			exe_name: document.getElementById('exe_name').value,
			no_of_items: document.getElementById('no_of_items').value,
			po_auto_id: document.getElementById('po_unique_id').value,
			no_of_con: document.getElementById('no_of_con').value,
			department: document.getElementById('department').value,
			products: []  // Will fill this below
		};

		// Retrieve per-row input arrays
		const rows = document.getElementsByName('stock_qty[]').length;

		const itemArr = document.getElementsByName('item_qty[]');
		const stockArr = document.getElementsByName('stock_qty[]');
		const remArr = document.getElementsByName('remaining_qty[]');
		const unitArr = document.getElementsByName('unit_price[]');
		const netArr = document.getElementsByName('net_price[]');

		const taxArr = document.getElementsByName('product_tax[]');
		const updateArr = document.getElementsByName('update_stock_qty[]');
		const partNoArr = document.getElementsByName('part_no[]');
		const uidArr = document.getElementsByName('unique_id[]');
		const codeArr = document.getElementsByName('item_code[]');
		const nameArr = document.getElementsByName('item_name[]');
		const billedArr = document.getElementsByName('billed_qty[]');
		const prodUidArr = document.getElementsByName('product_unique_id[]');

		// Totals
		let sumItemQty = 0, sumStockQty = 0, sumStockValue = 0;
		let sumUpdateQty = 0, sumUpdateValue = 0;

		// Loop through rows
		for (let i = 0; i < rows; i++) {
			const itemQty = parseFloat(itemArr[i].value) || 0;
			const stockQty = parseFloat(stockArr[i].value) || 0;
			const remQty = parseFloat(remArr[i].value) || itemQty;
			const unitPrice = parseFloat(unitArr[i].value) || 0;
			const netPrice = parseFloat(netArr[i].value) || 0;

			const prodTax = parseFloat(taxArr[i].value) || 0;
			const updateQty = parseFloat(updateArr[i].value) || 0;

			// Basic validation
			if (stockQty > remQty) {
				Swal.fire({
					icon: 'error',
					text: `Row ${i + 1}: Stock qty exceeds remaining (${remQty}).`,
				});
				return;
			}

			// Calculate amounts
			// const stockValue = stockQty * unitPrice * (1 + prodTax / 100);
			// const updateVal = updateQty * unitPrice * (1 + prodTax / 100);

			const stockValue = stockQty * netPrice;
			const updateVal = updateQty * netPrice;


			sumItemQty += itemQty;
			sumStockQty += stockQty;
			sumStockValue += stockValue;
			sumUpdateQty += updateQty;
			sumUpdateValue += updateVal;

			// Construct product item object
			payload.products.push({
				unique_id: uidArr[i].value,
				product_unique_id: prodUidArr[i].value,
				item_code: codeArr[i].value,
				item_name: nameArr[i].value,
				billed_qty: billedArr[i].value,
				item_qty: itemQty,
				remaining_qty: remQty,
				stock_qty: stockQty,
				update_stock_qty: updateQty,
				po_date: payload.po_date,
				unit_price: unitPrice,
				product_tax: prodTax,
				part_no: partNoArr[i].value,
				stock_value: stockValue,
				update_stock_value: updateVal
			});
		}

		payload.totals = {
			total_item_qty: sumItemQty,
			total_stock_qty: sumStockQty,
			total_stock_value: sumStockValue,
			total_update_qty: sumUpdateQty,
			total_update_value: sumUpdateValue
		};

		// Send JSON in AJAX
		$.ajax({
			type: "POST",
			url: 'folders/stock_position/crud1.php',
			contentType: "application/json",
			data: JSON.stringify({
				action: "stock_position_create",
				data: payload
			}),
			beforeSend: () => {
				$(".po_delivery_add_update_btn")
					.prop("disabled", true)
					.text("Loading...");
			},
			success: (response) => {
				const obj = JSON.parse(response);
				if (obj.status) {
					sweetalert(obj.msg);
					stock_creation_sub();
				} else {
					$(".createupdate_btn")
						.prop("disabled", false)
						.text("Error");
					console.error(obj.error);
				}
			},
			error: () => Swal.fire({ icon: 'error', text: 'Network Error.' })
		});
	}

	// new JSON Format

	// end
	function create_main() {

		// var internet_status = is_online();

		var unique_id = document.getElementById('unique_id').value;
		var stock_date = document.getElementById('stock_date').value;
		var po_date = document.getElementById('po_date').value;
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_num = document.getElementById('po_num').value;
		var po_num_get = encodeURIComponent(po_num);
		// alert(po_num);
		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var po_auto_id = document.getElementById('po_unique_id').value;
		var no_of_con = document.getElementById('no_of_con').value;
		var department = document.getElementById('department').value;

		var item_qty = document.getElementsByName('item_qty[]');


		var stock_qty = document.getElementsByName('stock_qty[]');
		var update_stock = document.getElementsByName('update_stock_qty[]');
		var update_stock_value = document.getElementsByName('update_stock_value[]');
		var part_no = document.getElementsByName('part_no[]');
		var rem_qty = document.getElementsByName('remaining_qty[]');
		// var rem_ext_qty = document.getElementsByName('rem_ext_qty[]');
		var stock_qty_total = [];
		var item_qty_total = [];
		var stock_qty_amt = [];
		var update_stock_qty_amt = [];
		var update_qty_amt = [];
		// alert(part_no);
		// Check if any stock quantity field is empty

		//     var anyStockQtyEmpty = false;
		//     for (var i = 0; i < stock_qty.length; i++) {
		//         if (stock_qty[i].value === '') {
		//             anyStockQtyEmpty = true;
		//             break;
		//         }
		//     }
		// 	if(unique_id==''){

		//     if (anyStockQtyEmpty) {
		//         // If any stock quantity is empty, show SweetAlert
		//         Swal.fire({
		//             icon: 'error',
		//             // title: 'Oops...',
		//             text: 'Please enter stock quantity for all items.',
		//         });
		//         return; // Exit function without proceeding further
		//     }
		// }


		// Check if any remaining qty is empty
		for (var i = 0; i < stock_qty.length; i++) {
			if (stock_qty[i].value === '') {
				Swal.fire({
					icon: 'error',
					text: 'Please enter stock quantity for all items.',
				});
				return;
			}
		}

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = stock_qty[i].value;
			var unit_price = document.getElementsByName('unit_price[]');
			var product_tax = document.getElementsByName('product_tax[]');
			var unique_id = document.getElementsByName('unique_id[]');
			var unit_price_val = unit_price[i].value;
			var unique_id = unique_id[i].value;
			var rem_qty_val = rem_qty[i].value;
			// alert(rem_qty_val);
			// var rem_ext_qty = rem_ext_qty[i].value;
			var product_tax_val = product_tax[i].value;
			var part_no_val = part_no[i].value;
			// alert(update_stock_qty);
			// ===start=====update amount===========
			var update_stock_qty = update_stock[i].value;

			var mul_1 = update_stock_qty * unit_price_val;
			var mul_val_1 = product_tax_val / 100;
			var mul_val1_1 = mul_1 * mul_val_1;

			var mul_add_val1_1 = mul_1 + mul_val1_1;
			// =======================end=================================
			var mul = stock_qty_val * unit_price_val;
			var mul_val = product_tax_val / 100;
			var mul_val1 = mul * mul_val;

			var mul_add_val = mul + mul_val1;
			// alert(mul_add_val);

			var item_qty_val = item_qty[i].value;
			var number = parseFloat(item_qty_val);
			if (!isNaN(number)) {
				item_qty_total.push(number);
				var sum_of_item_qty = item_qty_total.reduce(function (total, current) {
					return total + current;
				}, 0);

			}
			// var update_stock_qty = update_stock[i].value;
			var number = parseFloat(update_stock_qty);
			if (!isNaN(number)) {
				update_qty_amt.push(number);
				var sum_of_update_qty = update_qty_amt.reduce(function (total, current) {
					return total + current;
				}, 0);

			}
			// alert(sum_of_update_qty);
			// amount of value calculate
			var amount = parseFloat(mul_add_val);
			if (!isNaN(amount)) {
				stock_qty_amt.push(amount);
				var sum_of_stock_value = stock_qty_amt.reduce(function (total, current) {
					return total + current;
				}, 0);

			}

			var amount1 = parseFloat(mul_add_val1_1);

			// alert(amount1);
			if (!isNaN(amount1)) {
				update_stock_qty_amt.push(amount1);
				var sum_of_update_stock_value = update_stock_qty_amt.reduce(function (total, current) {
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



			// new changed 14-04-2025

			// 🔄 Check whether we're creating or updating
			if (unique_id === "") {
				// First time: validate against item_qty
				if (parseFloat(stock_qty_val) > parseFloat(item_qty_val)) {
					Swal.fire({
						icon: 'error',
						title: 'Invalid Quantity',
						text: 'Stock quantity should not exceed item quantity for ',
					});
					return;
				}
			} else {
				// Update case: validate against remaining_qty
				if (parseFloat(stock_qty_val) > parseFloat(rem_qty_val)) {
					Swal.fire({
						icon: 'error',
						title: 'Invalid Quantity',
						text: 'Stock quantity should not exceed remaining quantity',
					});
					return;
				}
			}

		}

		//   for "' + rem_qty_val + '"


		if (sum_of_item_qty >= sum_of_stock_qty) {
			// alert(sum_of_stock_value);
			var total_amount = sum_of_stock_value;
			var update_total_amount = sum_of_update_stock_value;

			var data = "stock_date=" + stock_date + "&main_unique_id=" + main_unique_id + "&po_date=" + po_date + "&po_num=" + po_num_get + "&po_auto_id=" + po_auto_id + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&no_of_con=" + no_of_con + "&department=" + department + "&stock_qty=" + sum_of_stock_qty + "&unique_id=" + unique_id + "&item_qty=" + sum_of_item_qty + "&total_amount=" + total_amount + "&update_total_amount=" + update_total_amount + "&update_stock_qty=" + sum_of_update_qty + "&part_no_val=" + part_no_val;
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

					sweetalert(msg);
					//alert(data);
					stock_creation_sub();



				}
				// ,
				// error: function(data) {
				// 	alert("Network Error");
				// }
			});
		} else {
			alert("Enter Valid Product Quantity..");
			// alert('hello');
		}


	}

	function stock_creation_sub_main() {

		var stock_qty = document.getElementsByName('stock_qty[]');

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = stock_qty[i].value;
			// alert(stock_qty_val);
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
				var product_tax = document.getElementsByName('product_tax[]');
				var update_stock = document.getElementsByName('update_stock_qty[]');
				var part_no = document.getElementsByName('part_no[]');

				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				var item_qty_val = item_qty[i].value;
				var billed_qty_val = billed_qty[i].value;
				var remaining_qty_val = remaining_qty[i].value;
				var product_unique_id_val = product_unique_id[i].value;
				var unique_id_val = unique_id[i].value;
				var unit_price = unit_price[i].value;
				var product_tax = product_tax[i].value;
				var update_stock_qty = update_stock[i].value;
				var part_no_val = part_no[i].value;
				// alert(update_stock_qty);


				// alert(remaining_qty_val);


				var po_date = document.getElementById('po_date').value;
				var total_qty = document.getElementById('total_qty').value;
				var net_value = document.getElementById('net_value').value;
				var stock_date = document.getElementById('stock_date').value;
				var unique_id = document.getElementById('unique_id').value;
				// alert(unique_id);
				var po_auto_id = document.getElementById('po_unique_id').value;

				var main_unique_id = document.getElementById('main_unique_id').value;
				var po_num = document.getElementById('po_num').value;
				var po_num_get = encodeURIComponent(po_num);

				var exe_name = document.getElementById('exe_name').value;
				var no_of_items = document.getElementById('no_of_items').value;
				var no_of_con = document.getElementById('no_of_con').value;
				// var update_stock_qty= document.getElementById('update_stock_qty').value;

				var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id +
					"&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" +
					item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val +
					"&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val + "&po_num=" + po_num_get + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + "&unique_id=" + unique_id + "&unit_price=" + unit_price + "&product_tax=" + product_tax + "&update_stock_qty=" + update_stock_qty + "&part_no_val=" + part_no_val;

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


						// sweetalert(msg);
					}
					// ,
					// error: function(data) {
					//     alert("Network Error");
					// }
				});
			}
		}
		// stock_position_sublist();
	}

	function stock_position_sublist_main() {

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
				var product_tax = document.getElementsByName('product_tax[]');
				var update_stock = document.getElementsByName('update_stock_qty[]');
				var part_no = document.getElementsByName('part_no[]');

				var item_code_val = item_code[i].value;
				var item_name_val = item_name[i].value;
				var item_qty_val = item_qty[i].value;
				var billed_qty_val = billed_qty[i].value;
				var remaining_qty_val = remaining_qty[i].value;
				var product_unique_id_val = product_unique_id[i].value;
				var unique_id_val = unique_id[i].value;
				var unit_price = unit_price[i].value;
				var product_tax = product_tax[i].value;
				var update_stock_qty = update_stock[i].value;
				var part_no_val = part_no[i].value;
				// alert(update_stock_qty);


				//alert(unique_id_val);


				var po_date = document.getElementById('po_date').value;
				var total_qty = document.getElementById('total_qty').value;
				var net_value = document.getElementById('net_value').value;
				var stock_date = document.getElementById('stock_date').value;
				var unique_id = document.getElementById('unique_id').value;
				// alert(unique_id);
				var po_auto_id = document.getElementById('po_unique_id').value;

				var main_unique_id = document.getElementById('main_unique_id').value;
				var po_num = document.getElementById('po_num').value;
				var po_num_get = encodeURIComponent(po_num);

				var exe_name = document.getElementById('exe_name').value;
				var no_of_items = document.getElementById('no_of_items').value;
				var no_of_con = document.getElementById('no_of_con').value;
				// var update_stock_qty= document.getElementById('update_stock_qty').value;

				var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id +
					"&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" +
					item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val +
					"&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val + "&po_num=" + po_num_get + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + "&unique_id=" + unique_id + "&unit_price=" + unit_price + "&product_tax=" + product_tax + "&update_stock_qty=" + update_stock_qty + "&part_no_val=" + part_no_val;

				data += "&action=stock_position_sublist";

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
						// sweetalert(msg.url);
						window.location.reload(true);


					}
					// ,
					// error: function (data) {
					// 	alert("Network Error");
					// }
				});
			}
		}

		// location.reload();
	}

	// alternative code
	function create123() {
		// 🧾 Single-value fields
		var unique_id = document.getElementById('unique_id').value;
		var stock_date = document.getElementById('stock_date').value;
		var po_date = document.getElementById('po_date').value;
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_num = encodeURIComponent(document.getElementById('po_num').value);
		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var po_auto_id = document.getElementById('po_unique_id').value;
		var no_of_con = document.getElementById('no_of_con').value;
		var department = document.getElementById('department').value;

		// 📋 Arrays
		var item_qty_arr = document.getElementsByName('item_qty[]');
		var stock_qty_arr = document.getElementsByName('stock_qty[]');
		var rem_qty_arr = document.getElementsByName('remaining_qty[]');
		var update_stock_arr = document.getElementsByName('update_stock_qty[]');
		var unit_price_arr = document.getElementsByName('unit_price[]');
		var product_tax_arr = document.getElementsByName('product_tax[]');
		var part_no_arr = document.getElementsByName('part_no[]');
		//    alert(stock_qty_arr);
		//    alert(rem_qty_arr);
		// Totals
		var sum_item_qty = 0;
		var sum_stock_qty = 0;
		var sum_stock_value = 0;
		var sum_update_qty = 0;
		var sum_update_value = 0;

		// 🔄 Process rows
		for (var i = 0; i < stock_qty_arr.length; i++) {
			var iq = parseFloat(item_qty_arr[i].value) || 0;
			var rq = parseFloat(rem_qty_arr[i].value) || iq;
			var sq = parseFloat(stock_qty_arr[i].value) || 0;
			var us = parseFloat(update_stock_arr[i].value) || 0;
			var up = parseFloat(unit_price_arr[i].value) || 0;
			var tx = parseFloat(product_tax_arr[i].value) || 0;
			var pn = part_no_arr[i].value;

			// Calculate remaining_qty
			var new_rem = rq - sq;
			if (new_rem < 0) {
				Swal.fire({ icon: 'error', text: 'Stock qty exceeds remaining for item ' + (i + 1) });
				return;
			}
			rem_qty_arr[i].value = new_rem;
			// alert(rem_qty_arr[i].value);

			// Validate: first entry -> max is iq, subsequent -> rq
			if (unique_id === "") {
				if (sq > iq) {
					Swal.fire({ icon: 'error', text: 'Stock qty cannot exceed item qty for item ' + (i + 1) });
					return;
				}
			} else {
				if (sq > rq) {
					Swal.fire({ icon: 'error', text: 'Stock qty cannot exceed remaining qty for item ' + (i + 1) });
					return;
				}
			}

			// Aggregate quantities
			sum_item_qty += iq;
			sum_stock_qty += sq;
			sum_update_qty += us;

			// Compute values
			var val_stock = sq * up * (1 + tx / 100);
			var val_update = us * up * (1 + tx / 100);
			sum_stock_value += val_stock;
			sum_update_value += val_update;
		}

		if (sum_item_qty < sum_stock_qty) {
			alert("Total stock qty exceeds total item qty.");
			return;
		}

		// 📨 Prepare AJAX data
		var data =
			"stock_date=" + stock_date +
			"&main_unique_id=" + main_unique_id +
			"&po_date=" + po_date +
			"&po_num=" + po_num +
			"&po_auto_id=" + po_auto_id +
			"&exe_name=" + exe_name +
			"&no_of_items=" + no_of_items +
			"&no_of_con=" + no_of_con +
			"&department=" + department +
			"&stock_qty=" + sum_stock_qty +
			"&item_qty=" + sum_item_qty +
			"&total_amount=" + sum_stock_value.toFixed(2) +
			"&update_stock_qty=" + sum_update_qty +
			"&update_total_amount=" + sum_update_value.toFixed(2) +
			"&unique_id=" + unique_id +
			"&action=stock_position_create";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			beforeSend: function () {
				$(".po_delivery_add_update_btn").attr("disabled", "disabled").text("Loading...");
			},
			success: function (response) {
				var obj = JSON.parse(response);
				var msg = obj.msg;
				var status = obj.status;
				var error = obj.error;

				if (!status) {
					$(".createupdate_btn").text("Error");
					console.log(error);
				} else if (msg == "already") {
					$(".createupdate_btn").removeAttr("disabled").text(unique_id ? "Update" : "Save");
				}

				sweetalert(msg);
				// stock_creation_sub();
			},
			error: function () {
				Swal.fire({ icon: 'error', text: 'Network Error. Please try again.' });
			}
		});
	}
	function stock_creation_sub123() {
		var ajaxUrl = sessionStorage.getItem("folder_crud_link");

		var stockQtyArr = document.getElementsByName('stock_qty[]');
		var itemCodeArr = document.getElementsByName('item_code[]');
		var itemNameArr = document.getElementsByName('item_name[]');
		var billedQtyArr = document.getElementsByName('billed_qty[]');
		var itemQtyArr = document.getElementsByName('item_qty[]');
		var remQtyArr = document.getElementsByName('remaining_qty[]');
		var prodUidArr = document.getElementsByName('product_unique_id[]');
		var uniqueIdArr = document.getElementsByName('unique_id[]');
		var unitPriceArr = document.getElementsByName('unit_price[]');
		var prodTaxArr = document.getElementsByName('product_tax[]');
		var updateStockArr = document.getElementsByName('update_stock_qty[]');
		var partNoArr = document.getElementsByName('part_no[]');

		// Single references
		var po_date = document.getElementById('po_date').value;
		var total_qty = document.getElementById('total_qty').value;
		var net_value = document.getElementById('net_value').value;
		var stock_date = document.getElementById('stock_date').value;
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_num = encodeURIComponent(document.getElementById('po_num').value);
		var po_auto_id = document.getElementById('po_unique_id').value;
		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var no_of_con = document.getElementById('no_of_con').value;

		// Loop over each row
		for (let i = 0; i < stockQtyArr.length; i++) {
			let stock_qty_val = stockQtyArr[i].value;
			if (stock_qty_val === '') continue;
			// alert(remQtyArr[i].value);
			// Pack row-specific variables
			let data = {
				unique_id: uniqueIdArr[i].value,
				main_unique_id,
				stock_qty: stock_qty_val,
				item_code: itemCodeArr[i].value,
				item_name: itemNameArr[i].value,
				item_qty: itemQtyArr[i].value,
				billed_qty: billedQtyArr[i].value,
				remaining_qty: remQtyArr[i].value,
				product_unique_id: prodUidArr[i].value,
				po_num,
				po_auto_id,
				po_date,
				exe_name,
				no_of_con,
				no_of_items,
				total_qty,
				net_value,
				stock_date,
				unit_price: unitPriceArr[i].value,
				product_tax: prodTaxArr[i].value,
				update_stock_qty: updateStockArr[i].value,
				part_no_val: partNoArr[i].value,
				action: 'stock_position_add_update'
			};
			// alert(remaining_qty);
			// Send AJAX
			$.ajax({
				type: "POST",
				url: ajaxUrl,
				data: $.param(data),
				context: { rowIndex: i },  // preserve the index
				beforeSend: function () {
					$(".po_delivery_add_update_btn").prop("disabled", true).text("Loading...");
				},
				success: function (response) {
					var obj = JSON.parse(response);
					if (!obj.status) {
						console.error(`Row ${this.rowIndex} error:`, obj.error);
					} else if (obj.msg === "already") {
						$(".createupdate_btn").prop("disabled", false)
							.text(data.unique_id ? "Update" : "Save");
					}
					// Optionally show row-level feedback here
				},
				error: function () {
					console.error(`Network error on row ${this.rowIndex}`);
				}
			});
		}

		// Refresh your sublist view
		stock_position_sublist();
	}
	function stock_position_sublist123() {
		/* ─────────────────────────────
		   Grab DOM references just once
		   ───────────────────────────── */
		const stockQtyArr = document.getElementsByName('stock_qty[]');
		const itemCodeArr = document.getElementsByName('item_code[]');
		const itemNameArr = document.getElementsByName('item_name[]');
		const billedQtyArr = document.getElementsByName('billed_qty[]');
		const itemQtyArr = document.getElementsByName('item_qty[]');
		const remQtyArr = document.getElementsByName('remaining_qty[]');
		const prodUidArr = document.getElementsByName('product_unique_id[]');
		const uniqueIdArr = document.getElementsByName('unique_id[]');
		const unitPriceArr = document.getElementsByName('unit_price[]');
		const prodTaxArr = document.getElementsByName('product_tax[]');
		const updateStockArr = document.getElementsByName('update_stock_qty[]');
		const partNoArr = document.getElementsByName('part_no[]');

		/* ─────────────────────────────
		   Single-value fields
		   ───────────────────────────── */
		const po_date = document.getElementById('po_date').value;
		const total_qty = document.getElementById('total_qty').value;
		const net_value = document.getElementById('net_value').value;
		const stock_date = document.getElementById('stock_date').value;
		const main_unique_id = document.getElementById('main_unique_id').value;
		const po_num = encodeURIComponent(document.getElementById('po_num').value);
		const po_auto_id = document.getElementById('po_unique_id').value;
		const exe_name = document.getElementById('exe_name').value;
		const no_of_items = document.getElementById('no_of_items').value;
		const no_of_con = document.getElementById('no_of_con').value;

		const ajaxUrl = sessionStorage.getItem('folder_crud_link');

		/* ─────────────────────────────
		   Build an array of AJAX promises
		   ───────────────────────────── */
		const requests = [];

		for (let i = 0; i < stockQtyArr.length; i++) {
			const sq = stockQtyArr[i].value.trim();
			if (sq === '') continue;                // skip blank rows

			const payload = {
				unique_id: uniqueIdArr[i].value,
				main_unique_id,
				stock_qty: sq,
				item_code: itemCodeArr[i].value,
				item_name: itemNameArr[i].value,
				item_qty: itemQtyArr[i].value,
				billed_qty: billedQtyArr[i].value,
				remaining_qty: remQtyArr[i].value,
				product_unique_id: prodUidArr[i].value,
				po_num,
				po_auto_id,
				po_date,
				exe_name,
				no_of_con,
				no_of_items,
				total_qty,
				net_value,
				stock_date,
				unit_price: unitPriceArr[i].value,
				product_tax: prodTaxArr[i].value,
				update_stock_qty: updateStockArr[i].value,
				part_no_val: partNoArr[i].value,
				action: 'stock_position_sublist'
			};

			// push each $.ajax promise into the array
			requests.push(
				$.ajax({ type: 'POST', url: ajaxUrl, data: $.param(payload) })
					.then(resp => ({ ok: true, resp, row: i }))
					.catch(err => ({ ok: false, err, row: i }))
			);
		}

		if (requests.length === 0) {
			Swal.fire({ icon: 'warning', text: 'Enter at least one stock quantity.' });
			return;
		}

		/* ─────────────────────────────
		   Disable button once
		   ───────────────────────────── */
		$('.po_delivery_add_update_btn')
			.prop('disabled', true)
			.text('Loading...');

		/* ─────────────────────────────
		   Wait for *all* requests
		   ───────────────────────────── */
		Promise.all(requests).then(results => {
			let hasError = false;

			results.forEach(r => {
				if (!r.ok) {
					console.error(`Row ${r.row}: network error`, r.err);
					hasError = true;
					return;
				}

				const obj = JSON.parse(r.resp);
				if (!obj.status) {
					console.error(`Row ${r.row}: server error`, obj.error);
					hasError = true;
				}
			});

			if (hasError) {
				$('.createupdate_btn').text('Error').prop('disabled', false);
				Swal.fire({ icon: 'error', text: 'One or more rows failed. Check console for details.' });
			} else {
				// everything succeeded
				window.location.reload(true);
			}
		});
	}



	// alternative code

	function is_online() {
		return true;
		// return(navigator.onLine);
		return false;
	}

	// GEO Location Check Function

	function geo_location() {
		if (!navigator.geolocation) {
			sweetalert("no_location");
			return false;
		}
		return true;

	}

	function is_online1() {
		if (!navigator.onLine) {
			sweetalert("no_internet");
			return false;
		}
	}
</script>


