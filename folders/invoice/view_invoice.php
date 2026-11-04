<!-- This file Only PHP Functions -->
<style>
	table thead tr th {
		text-align: center;
	}
</style>

<?php include 'function.php';

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';
?>
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
		$unique_id = $_GET["unique_id"];
		//  $form_main_unique_id  = $_GET["form_main_unique_id"];

		$where = [
			"unique_id" => $unique_id
		];
		$table = "invoice_creation_main";
		$columns = [
			"get_po_num_by_po_unique_id(po_unique_id) AS po_num",
			"po_date",
			"executive_name",
			"(select con_contact_name from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_contact_name",

			"(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_address",
			"(select billing_address from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS billing_address",
			"no_of_items",
			"stock_qty",
			"invoice_value",
			"(SELECT file_name FROM po_form WHERE po_form.unique_id  = " . $table . ".form_main_unique_id group by form_main_unique_id) AS po_file",

			"(select department from stock_position_main where form_main_unique_id=$table.form_main_unique_id group by form_main_unique_id) AS department",

			"(select department from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS department_unique_id",

			"(select con_district from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_district",

			"(select con_state_name from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_state_name",

			"(select zone from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS zone",

			"(select con_pincode from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_pincode",

			"(select con_contact_number from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_contact_number",
			"(select con_lan_num from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_lan_num",

			"po_unique_id",
			"unique_id",
			"form_main_unique_id",
			"invoice_auto_id",
			"invoice_date",
			"consignee_unique_id",
			"stock_id",
			"stock_date",
			"invoice_no",
			"(select ledger_name from department_creation_sublist where unique_id= $table.ledger_name  and is_delete=0)as ledger_name",
			"(select ledger_no from department_creation_sublist where unique_id= $table.ledger_no and is_delete=0 )as ledger_no",
			"ledger_no as ledger_unique_id",
			"(select remarks from stock_position_main where form_main_unique_id = $table.form_main_unique_id group by form_main_unique_id) AS remarks",
			"(SELECT part_no_file FROM stock_position_main WHERE form_main_unique_id  = " . $table . ".form_main_unique_id group by form_main_unique_id) AS part_no_file",
			"(select gst_value from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS gst_value",
			"invoice_auto_id",
			"dc_number",
			"dc_date",
			"material_qc",
			"get_district_name_po(po_unique_id) AS district_name",
			"get_state_name_po(po_unique_id) AS state_name",
			"get_address_po(po_unique_id) AS bill_address",
			"get_contact_no_po(po_unique_id) AS contact_number",
			"get_contact_email_po(po_unique_id) AS email",
			"get_consignee_contact_no(unique_id) AS con_contact_no",
			"invoice_doc_status",
			"reject_reason_elcot",
			"doc_approval_sts",
			"ac_team_verifiy_status",
			"approved_by",
			"DATE_FORMAT(approved_date, '%d-%m-%Y') AS approved_date",
			"ac_team_approved_by",
			"DATE_FORMAT(ac_approved_date, '%d-%m-%Y') AS ac_approved_date",


		];
		$table_details = [
			$table,
			$columns
		];
		$result_values = $pdo->select($table_details, $where);
		// print_r($result_values);
		if ($result_values->status) {
			$result_values = $result_values->data;
			$po_num = $result_values[0]["po_num"];
			$po_unique_id = $result_values[0]["po_unique_id"];
			// $po_num_get =  $po_num . ' / ' . $po_unique_id;
			// $po_num_get =  $po_num;
			$po_date = $result_values[0]["po_date"];
			$executive_name = $result_values[0]["executive_name"];
			$con_contact_name = $result_values[0]["con_contact_name"];
			$con_address = $result_values[0]["con_address"];

			$stock_qty = $result_values[0]["stock_qty"];
			// $no_of_items = $result_values[0]["no_of_items"];
			$invoice_value = $result_values[0]["invoice_value"];
			$department = $result_values[0]['department'];
			$gst_value = $result_values[0]['gst_value'];
			$con_pincode = $result_values[0]['con_pincode'];
			$con_districts = district_name($result_values[0]['con_district']);
			$con_district = disname($con_districts[0]['district_name']);
			$con_states = con_state_name($result_values[0]["con_state_name"]);
			$con_state = disname($con_states[0]['state_name']);
			$con_zone = $result_values[0]["zone"];
			$district_name = district_name_stock($result_values[0]["district_name"]);
			$state_name = con_state_name_stock($result_values[0]["state_name"]);
			$bill_address = $result_values[0]["bill_address"];
			$contact_number = $result_values[0]["contact_number"];
			$email = $result_values[0]["email"];
			$invoice_auto_id = $result_values[0]["invoice_auto_id"];
			$unique_id = $result_values[0]["unique_id"];
			$form_main_unique_id = $result_values[0]["form_main_unique_id"];
			$invoice_date = $result_values[0]["invoice_date"];
			$consignee_unique_id = $result_values[0]["consignee_unique_id"];
			$stock_id = $result_values[0]["stock_id"];
			$stock_date = $result_values[0]["stock_date"];
			$invoice_no = $result_values[0]["invoice_no"];
			$ledger_name = $result_values[0]["ledger_name"];
			$ledger_no = $result_values[0]["ledger_no"];
			$department_unique_id = $result_values[0]["department_unique_id"];
			$billing_address = $result_values[0]["billing_address"];
			$con_contact_number = $result_values[0]["con_contact_number"];
			$con_lan_num = $result_values[0]["con_lan_num"];

			$po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);

			$stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
			$stmtCus->bindParam(':unique_id', $form_main_unique_id);
			$stmtCus->execute();

			$po_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($po_data)) {
				$executive_name = $po_data[0]["executive_name"];
				$no_of_items = $po_data[0]["no_of_po"];
				$file_name = $po_data[0]["file_name"];
			}
			$stmtCus->closeCursor();
			$part_no_file = image_view_4("po_form", $result_values[0]['po_unique_id'], $file_name);

			$dc_number = $result_values[0]["dc_number"];
			$dc_date = $result_values[0]["dc_date"];
			// $exp_under_user_type  = explode(",", $under_user_type);
			$btn_text = "Update";
			$btn_action = "update";
		} else {
			$btn_text = "Error";
			$btn_action = "error";
			$is_btn_disable = "disabled='disabled'";
		}
	}
}


$consignee_type_options = consignee_option($unique_id);
$consignee_type_options = select_option($consignee_type_options, "Select consignee", $unique_id);


// $ledger_type_options = legder_inv($department_unique_id);
// $ledger_type_options = select_option($ledger_type_options, "Select Legder Name", $ledger_name);

// $ledger_no_type_options = legder_no_po($department_unique_id);
// $ledger_no_type_options = select_option($ledger_no_type_options, "Select Legder No", $ledger_no);
// print_r($consignee_type_options);die();
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$active_status_options = active_status($is_active);
?>
<style>
	table.dataTable.nowrap td {
		white-space: unset !important;
	}
</style>
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Invoice Form</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active"> Invoice </li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="col-xxl-12 cf">
	<div class="card">
		<div class="card-body">
			<ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
						<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
						<span class="d-none d-sm-block">Stock Details</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
						<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
						<span class="d-none d-sm-block">Invoice Details</span>
					</a>
				</li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="arrow-overview" role="tabpanel">
					<div class="row">
						<div class="col-12">
							<form class="was-validated" autocomplete="off">
								<div class="col-12">
									<div class="row pb-3">

										<!-- Customer Details -->
										<div class="col-md-4">
											<h6 class="text-uppercase text-body-primary mb-3 sub_header_small" style="">
												Customer
												Details</h6>
											<h6 class="text-body-primary" style="font-size: x-large; color: #506018;">
												<strong><?php echo $department ?></strong>
											</h6>
											<p class="text-body-primary mb-2"><?php echo $bill_address ?>,
												<?php echo $district_name ?><br><?php echo $state_name ?>
											</p>
											<p class="mb-2"><i data-feather="phone"
													style="width:15px; height:15px; color:#506018;"></i>
												<?php echo !empty($contact_number) ? $contact_number : '--'; ?></p>
											<p class="mb-4"><i data-feather="mail"
													style="width:15px; height:15px; color:#506018;"></i>
												<?php echo !empty($email) ? $email : '--'; ?></p>
										</div>



										<!-- Consignee Details -->
										<div class="col-md-4">
											<h6 class="text-uppercase text-body-primary mb-3 sub_header_small">Consignee
												Details</h6>
											<h6 class="text-body-primary" style="font-size: x-large; color: #506018;">
												<strong><?php echo $con_contact_name ?></strong>
											</h6>
											<p class="text-body-primary mb-2"><?php echo $con_address ?>,
												<?php echo $con_zone ?>
											</p>
											<p class="text-body-primary mb-2"><?php echo $con_district ?>,
												<?php echo $con_state ?>
											</p>
											<p class="mb-2"><i data-feather="phone"
													style="width:15px; height:15px; color:#506018;"></i>
												<?php echo !empty($con_contact_number) ? $con_contact_number : '--'; ?>
											</p>
											<p class="mb-2"><i data-feather="phone"
													style="width:15px; height:15px; color:#506018;"></i>
												<?php echo !empty($con_lan_num) ? $con_lan_num : '--'; ?></p>

											<h6 class="text-uppercase text-body-primary mb-3 sub_header_small" style="">
												Billing Address</h6>
											<p class="text-body-primary mb-2">
												<?php echo !empty($billing_address) ? $billing_address : 'NIL'; ?>
											</p>

											<!-- <div class="mb-2 d-flex"><div class="col-5 text-body-secondary">Consignee Name</div><div class="col-1">:</div><div class="col-6"><?php echo $con_contact_name ?></div></div>
				<div class="mb-2 d-flex"><div class="col-5 text-body-secondary">Consignee Address</div><div class="col-1">:</div><div class="col-6"><?php echo $con_address ?></div></div>
				<div class="mb-2 d-flex"><div class="col-5 text-body-secondary">Consignee Zone</div><div class="col-1">:</div><div class="col-6"><?php echo $con_zone; ?></div></div>
				<div class="mb-2 d-flex"><div class="col-5 text-body-secondary">Consignee District</div><div class="col-1">:</div><div class="col-6"><?php echo $con_district; ?></div></div>
				<div class="mb-2 d-flex"><div class="col-5 text-body-secondary">Consignee State</div><div class="col-1">:</div><div class="col-6"><?php echo $con_state ?></div></div> -->
										</div>

										<!-- PO Details -->
										<div class="col-md-4">
											<h6 class="text-uppercase text-body-primary mb-3 sub_header_small">PO
												Details</h6>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">Invoice ID</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><strong><?php echo $invoice_auto_id ?></strong></div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">PO Number</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo $po_num ?></div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">PO Date</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo $po_date ?></div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">Executive Name</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo get_executive_name($executive_name); ?>
												</div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">GST IN No</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo $pro_gst_value ?></div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">No of Items in PO</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo $no_of_items ?></div>
											</div>
											<div class="mb-1 d-flex">
												<div class="col-5 text-body-secondary">PO Attachment</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6"><?php echo $part_no_file ?></div>
											</div>
										</div>


									</div>
								</div>
								<div class="row">
									<div class="col-12 mt-2">
										<div class="table-responsive mb-4">
											<table
												class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
												<thead class="table-light">
													<tr>
														<th>S.No</th>

														<th scope="col">Item Details</th>
														<th scope="col">Stock QTY</th>
														<th scope="col"> Con Assign QTY</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$table_1 = 'view_product_assign_con_details';
													$columns_1 = [
														// "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_1.item_code)as item_code",
														"item_code",
														"product",
														"stock_qty",
														"assign_qty",
														// "(SELECT assign_qty FROM po_product_assign_details WHERE po_product_assign_details.form_main_unique_id = " . $table_1 . ".form_main_unique_id ) AS con_assign_qty",
														// "invoice_qty",
														// "stock_qty",
														// "remaining_qty",
														// "unique_id",
														"form_main_unique_id",
														"product_unique_id",
														// "count(item_code) as product_count "
													];
													$table_details1 = [
														$table_1,
														$columns_1
													];
													$where1 = " is_delete = '0' AND form_main_unique_id = '$form_main_unique_id' and consignee_unique_id = '$consignee_unique_id'";
													// $where1 = [
													// 	// "is_delete" => '0',
													// 	"form_main_unique_id" => $form_main_unique_id,
													// 	"con_unique_id" => $consignee_unique_id
													// ];
													$result1 = $pdo->select($table_details1, $where1);
													// print_r($result1);die();
													if ($result1->status) {
														$res_array1 = $result1->data;
														// print_r($result1->data);
														foreach ($res_array1 as $key => $value) {
															// $remaining_qty = $value['stock_qty'] - $value['product_count'];
															$value['s_no'] = $sno + 1; ?>
															<tr>
																<td id="table_td"><?php echo $value['s_no']; ?></td>
																<td id="table_td"><b><?php echo $value['item_code']; ?></b><br>
																	<?php echo $value['product']; ?></td>
																<!-- <td id="table_td"></td> -->
																<td id="table_td"><?php echo $value['stock_qty']; ?></td>
																<td id="table_td"><?php echo $value['assign_qty']; ?></td>
																<!-- <td><?php echo $con_assign_qty; ?></td> -->
																<!--<td><?php echo $value['stock_qty']; ?></td>-->
																<!--<td><?php echo $remaining_qty; ?></td>-->
															</tr>
															<?php
															$sno++;
														}
													}
													?>

												</tbody>
											</table>
										</div>
									</div>
							</form>
						</div> <!-- end card-body -->
					</div>
				</div>
			</div>
			<div class="tab-pane" id="arrow-profile" role="tabpanel">
				<form class="was-validated" autocomplete="off">
					<div class="row">
						<input type="hidden" id="po_num" name="po_num" value="<?php echo $po_num; ?>">
						<input type="hidden" id="po_date" name="po_date" value="<?php echo $po_date; ?>">
						<input type="hidden" id="executive_name" name="executive_name"
							value="<?php echo $executive_name; ?>">
						<input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
							value="<?php echo $form_main_unique_id; ?>">
						<input type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $po_unique_id; ?>">
						<input type="hidden" id="consignee" name="consignee" value="<?php echo $con_contact_name; ?>">
						<input type="hidden" name="consignee_unique_id" id="consignee_unique_id"
							value="<?php echo $consignee_unique_id ?>">
						<input type="hidden" id="invoice_date" name="invoice_date" class="form-control"
							value="<?php echo $invoice_date; ?>">
						<input type="hidden" id="invoice_unique_id" name="invoice_unique_id"
							value="<?php echo $unique_id; ?>">
						<input type="hidden" id="invoice_auto_id" name="invoice_auto_id"
							value="<?php echo $result_values[0]["invoice_auto_id"]; ?>">

						<div class="col-lg-12">
							<div class="row mb-3">
								<!-- Left: Consignee Details -->
								<div class="col-md-6">
									<h6 class="text-uppercase mb-3 sub_header_small">Consignee Details</h6>
									<h6 class="text-body-primary" style="font-size: x-large; color: #506018;">
										<strong><?php echo $con_contact_name ?></strong>
									</h6>
									<p class="text-body-primary mb-2"><?php echo $con_address ?>,
										<?php echo $con_zone ?>
									</p>
									<p class="text-body-primary mb-2"><?php echo $con_district ?>,
										<?php echo $con_state ?>
									</p>
									<p class="mb-2"><i data-feather="phone"
											style="width:15px; height:15px; color:#506018;"></i>
										<?php echo !empty($con_contact_number) ? $con_contact_number : '--'; ?></p>
									<p class="mb-2"><i data-feather="phone"
											style="width:15px; height:15px; color:#506018;"></i>
										<?php echo !empty($con_lan_num) ? $con_lan_num : '--'; ?></p>

									<!-- Customer Details -->

									<h6 class="text-uppercase text-body-primary mb-3 sub_header_small" style="">Billing
										Address</h6>
									<p class="text-body-primary mb-2">
										<?php echo !empty($billing_address) ? $billing_address : 'NIL'; ?>
									</p>


								</div>

								<!-- Right: PO & Invoice Details -->
								<div class="col-md-6">
									<h6 class="text-uppercase mb-3 sub_header_small">PO Details</h6>
									<div class="mb-2 d-flex">
										<div class="col-5 text-body-secondary">Invoice ID</div>
										<div class="col-1">:</div>
										<div class="col-6"><strong><?php echo $invoice_auto_id ?></strong></div>
									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">DC Number</div>
										<div class="col-1">:</div>
										<div class="col-6"><strong><?php echo $dc_number; ?></strong></div>

										<input type="hidden" id="old_dc_number" name="old_dc_number"
											class="form-control mb-2" value="<?php echo $dc_number; ?>" required>


										<input type="hidden" name="mydc_no" id="mydc_no"
											value="<?php echo $dc_number; ?>">
										<input type="hidden" name="myinv_auto_id" id="myinv_auto_id"
											value="<?php echo $invoice_auto_id; ?>" <?php if ($material_qc == 1) {
												   echo 'readonly';
											   } ?>>
									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">DC Date</div>
										<div class="col-1">:</div>
										<div class="col-6"><strong><?php echo $result_values[0]["dc_date"]; ?></strong>
										</div>

										<input type="hidden" name="dc_date" id="dc_date" class="form-control" required
											value="<?php echo $result_values[0]["dc_date"]; ?>"
											max="<?= date('Y-m-d') ?>" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">Invoice No</div>
										<div class="col-1">:</div>
										<div class="col-6"><strong><?php echo $invoice_no; ?></strong></div>
										<input type="hidden" name="invoice_no" id="invoice_no" class="form-control"
											value="<?php echo $invoice_no ?>" required onchange="get_invoice_no()" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
										<input type="hidden" name="myinv_no" id="myinv_no"
											value="<?php echo $invoice_no; ?>">
									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">Invoice Date</div>
										<div class="col-1">:</div>
										<div class="col-6">
											<strong><?php echo $result_values[0]["invoice_date"]; ?></strong>
										</div>
										<input type="hidden" name="invoice_date_1" id="invoice_date_1"
											class="form-control" required
											value="<?php echo $result_values[0]["invoice_date"]; ?>"
											max="<?= date('Y-m-d') ?>" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">Ledger Name</div>
										<div class="col-1">:</div>
										<div class="col-6"><strong>
												<?php echo $ledger_name; ?>
											</strong></div>

									</div>

									<div class="mb-2 d-flex align-items-center">
										<div class="col-5 text-body-secondary">Ledger Number</div>
										<div class="col-1">:</div>
										<div class="col-6">
											<strong> <?php echo $ledger_no; ?>
											</strong>
										</div>

									</div>

									<div class="mb-2 d-flex">
										<div class="col-5 text-body-secondary">PO Attachment</div>
										<div class="col-1">:</div>
										<div class="col-6"><?php echo $part_no_file ?></div>
									</div>
								</div>
							</div>
							<div class="row">
								<p class="mb-0"><b>Attachment List</b></p>

							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-12 mt-2">
				<div class="table-responsive mb-4">
					<table class="table table-striped table-bordered align-middle mb-0 small_table"
						id="invoice_details_datatable">
						<thead class="table-light">
							<tr>
								<th>S.No</th>
								<th scope="col">Consignee Name</th>
								<th scope="col">Ledger Name & No</th>
								<th scope="col">DC</th>
								<th scope="col">Invoice</th>
								<th scope="col">DC Attachment</th>
								<th scope="col">IR Attachment</th>
								<th scope="col">Inv. Attachment</th>
								<!-- <th scope="col">Action</th> -->
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<!--invoice table records start-->
			<div class="col-12 mt-4">
				<div class="table-responsive mb-4">
					<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
						<thead class="table-light">
							<tr>
								<th>S.No</th>
								<!-- <th scope="col">Item Code</th> -->
								<th scope="col">Item Details</th>
								<th scope="col">Stock QTY</th>
								<th scope="col">Invoice Bill QTY </th>
								<th scope="col">Remaining QTY</th>
								<th scope="col">Serial No</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$where1 = "dc_num = '" . $dc_number . "' and po_unique_id = '" . $form_main_unique_id . "' AND consignee_id = '" . $consignee_unique_id . "'";
							$table1 = "invoice_creation";
							$columns1 = [

								"item_code",
								"product",
								"item_qty",
								"invoice_qty",
								"unique_id",
								"product_unique_id",
								"ser_no",
							];
							$table_details1 = [
								$table1,
								$columns1
							];
							// 			}
							$values_product = $pdo->select($table_details1, $where1);
							// print_r($values_product);
							// echo $values_product;
							$s_no = 0;
							if ($values_product->status) {
								$product_array = $values_product->data;
								// print_R($product_array);
								foreach ($product_array as $key => $product) {
									$s_no = $s_no + 1;


									$rem_qty = $product['item_qty'] - $product['invoice_qty'];
									?>
									<tr>
										<td><?php echo $s_no; ?></td>
										<td><b><?php echo $product['item_code']; ?></b><br>
											<?php echo $product['product']; ?></td>
										<!-- <td></td> -->
										<td><?php echo $product['item_qty']; ?></td>
										<td><?php echo $product['invoice_qty']; ?></td>
										<td><?php echo $rem_qty; ?></td>
										<td><?php echo $product['ser_no']; ?></td>
									</tr>
									<?php
								}
								$sno++;
							}
							// }
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- <input type="text" id="product_unique_id" name="product_unique_id" value="<?php echo $result_values_datas[0]["unique_id"]; ?>"> -->

			<!--invoice table records end-->
			<div class="form-group row ">
				<div class="col-md-12" align="right">
					<!-- Cancel,save and update Buttons -->
					<?php echo btn_cancel($btn_cancel); ?>
					<!-- <button type="button" class="btn btn-primary " onclick="invoice_update()">Update</button> -->
					<!--<?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>-->
				</div>
			</div>
		</div>
	</div>
</div>
</div><!-- end card-body -->
</div><!-- end card -->
</div>
<!--end col-->
<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
<script>
</script>
<script>
	$(document).ready(function () {
		sub_list_datatable("invoice_details_datatable");
	});

	function invoice_details(unique_id = "") { // au = add,update
		var internet_status = is_online();

		if (!internet_status) {
			sweetalert("no_internet");
			return false;
		}
		var is_form = form_validity_check("was-validated");

		if (is_form) {

			// alert("hello");
			var internet_status = is_online();
			var po_num = document.getElementById('po_num').value;
			var po_date = document.getElementById('po_date').value;
			var executive_name = document.getElementById('executive_name').value;
			var consignee_unique_id = document.getElementById('consignee_unique_id').value;
			var form_main_unique_id = document.getElementById('form_main_unique_id').value;
			var invoice_unique_id = document.getElementById('invoice_unique_id').value;
			var consignee = document.getElementById('consignee').value;
			var ledger_name = document.getElementById('ledger_name').value;
			var ledger_no = document.getElementById('ledger_no').value;
			var invoice_no = document.getElementById('invoice_no').value;
			var invoice_date_1 = document.getElementById('invoice_date_1').value;
			var test_doc = document.getElementById('dc_file_name').value;
			var test_doc1 = document.getElementById('ir_file_name').value;
			var test_doc2 = document.getElementById('file_invoice').value;
			var po_unique_id = document.getElementById('po_unique_id').value;
			var image_s = document.getElementById("dc_file_name");
			var image_ir = document.getElementById("ir_file_name");
			var image_in = document.getElementById("file_invoice");
			var data = new FormData();
			if (image_s != '') {
				for (var i = 0; i < image_s.files.length; i++) {
					data.append("test_file[]", document.getElementById('dc_file_name').files[i]);
				}
			} else {
				data.append("test_doc", '');
			}
			if (image_ir != '') {
				for (var i = 0; i < image_ir.files.length; i++) {
					data.append("test_file1[]", document.getElementById('ir_file_name').files[i]);
				}
			} else {
				data.append("test_doc1", '');
			}
			if (image_in != '') {
				for (var i = 0; i < image_in.files.length; i++) {
					data.append("test_file2[]", document.getElementById('file_invoice').files[i]);
				}
			} else {
				data.append("test_doc2", '');
			}
			//    alert(image_s);
			// data.append("no_of_po", no_of_po);
			data.append("po_num", po_num);
			data.append("po_date", po_date);
			data.append("executive_name", executive_name);
			data.append("consignee", consignee);
			data.append("consignee_unique_id", consignee_unique_id);
			data.append("form_main_unique_id", form_main_unique_id);
			data.append("ledger_name", ledger_name);
			data.append("ledger_no", ledger_no);
			data.append("invoice_no", invoice_no);
			data.append("invoice_date_1", invoice_date_1);
			data.append("invoice_unique_id", invoice_unique_id);
			// 	data.append("demo", demo);
			data.append("po_unique_id", po_unique_id);
			data.append("action", "invoice_add_update");
			// // var data = $(".product_details_form").serialize();"&po_num=" + po_num +po_date=" + po_date + 
			// var data = "po_num=" + po_num + "&po_date=" + po_date +
			//     "&excutive_name=" + excutive_name +
			//     "&no_of_consignee=" + no_of_consignee + "&consignee=" + consignee + "&ledger_name=" +
			//     ledger_name + "&invoice_no=" + invoice_no + "&invoice_date=" +
			//     invoice_date;
			// data += "&unique_id=" + unique_id + "&action=invoice_add_update";
			var ajax_url = sessionStorage.getItem("folder_crud_link");
			// var url      = sessionStorage.getItem("list_link");
			var url = "";
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
					$(".invoice_details_add_update_btn").attr("disabled", "disabled");
					$(".invoice_details_add_update_btn").text("Loading...");
				},
				success: function (data) {
					// alert(data);
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
					//alert(msg);
					if (!status) {
						$(".invoice_details_add_update_btn").text("Error");
						console.log(error);
					} else {
						if (msg == "already") {
							// sweetalert(msg, url);
							form_reset("consignee_details_form");
						}
						$(".invoice_details_add_update_btn").removeAttr("disabled", "disabled");
						if (unique_id && msg == "already") {
							$(".invoice_details_add_update_btn").text("Update");
						} else {
							$(".invoice_details_add_update_btn").text("Add");
							$(".invoice_details_add_update_btn").attr("onclick",
								"invoice_details_add_update('')");
						}
						// Init Datatable
						sub_list_datatable("invoice_details_datatable");
						// document.getElementById('con_address').value = '';
						// document.getElementById('con_district').value = '';
						// document.getElementById('con_pincode').value = '';
						// document.getElementById('con_contact_name').value = '';
						// document.getElementById('con_contact_number').value = '';
						// document.getElementById('con_lan_num').value = '';
					}
					sweetalert(msg, url);
				},
				error: function (data) {
					alert("Network Error");
				}
			});
		} else {
			sweetalert("form_alert");
		}
	}

	function invoice_details_delete(unique_id = "") {
		if (unique_id) {
			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url = sessionStorage.getItem("list_link");
			confirm_delete('delete')
				.then((result) => {
					if (result.isConfirmed) {
						var data = {
							"unique_id": unique_id,
							"action": "invoice_details_delete"
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
									sub_list_datatable("invoice_details_datatable");
								}
								sweetalert(msg, url);
							}
						});
					} else {
						// alert("cancel");
					}
				});
		}
	}
	// get invoice update
	function invoice_update(unique_id = "") {
		// alert('hi');
		var internet_status = is_online();
		if (!internet_status) {
			sweetalert("no_internet");
			return false;
		}
		var consignee_unique_id = document.getElementById('consignee_unique_id').value;
		//	alert(consignee_unique_id);
		var form_main_unique_id = document.getElementById('form_main_unique_id').value;
		var invoice_id = document.getElementById('invoice_unique_id').value;
		var invoice_auto_id = document.getElementById('invoice_auto_id').value;
		//	alert(invoice_auto_id);
		// var product_unique_id = document.getElementById('product_unique_id').value;
		// alert(product_unique_id)
		var ledger_name = document.getElementById('ledger_name').value;
		var ledger_no = document.getElementById('ledger_no').value;
		var invoice_no = document.getElementById('invoice_no').value;
		//	alert(invoice_no);
		var data = new FormData();
		data.append("form_main_unique_id", form_main_unique_id);
		data.append("consignee_unique_id", consignee_unique_id);
		data.append("invoice_id", invoice_id);
		data.append("invoice_auto_id", invoice_auto_id);
		//data.append("product_unique_id", product_unique_id);
		data.append("ledger_name", ledger_name);
		data.append("ledger_no", ledger_no);
		data.append("invoice_no", invoice_no);
		data.append("action", "deleivery_status");
		var is_form = form_validity_check("was-validated");
		if (is_form) {
			// var data 	 = $(".was-validated").serialize();
			// data 		+= "&unique_id="+unique_id+"&action=demo";
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
				// beforeSend 	: function() {
				// 	$(".createupdate_btn").attr("disabled","disabled");
				// 	$(".createupdate_btn").text("Loading...");
				// },
				success: function (data) {
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
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
							}
						}
					}
					sweetalert(msg, url);
				},
				error: function (data) {
					alert("Network Error");
				}
			});
		}
		// else {
		//     sweetalert("form_alert");
		// }
	}
	// }

	function print_view_2(file_name) {

		window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
	}

	function print_pdf_2(file_name) {

		onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
	}
</script>
<?php
function image_view_3($folder_name = "", $unique_id = "", $po_file = "")
{
	// echo $file_name;
	$file_names = explode(',', $po_file);
	$image_view_3 = '';
	if ($po_file) {
		foreach ($file_names as $file_key => $po_file) {
			if ($file_key != 0) {
				if ($file_key % 4 != 0) {
					$image_view_3 .= "&nbsp";
				} else {
					$image_view_3 .= "<br><br>";
				}
			}
			$cfile_name = explode('.', $po_file);
			if ($po_file) {
				if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
					$image_view_3 .= '<a href="javascript:print_view_2(\'/' . $po_file . '\')"><img src="uploads/' . $folder_name . '/' . $po_file . '"  height="30px" width="30px" ></a>';
					// $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="30px" width="30px" >';
				} else if ($cfile_name[1] == 'pdf') {
					$image_view_3 .= '<a href="javascript:print_pdf_2(\'/' . $po_file . '\')"><img src="uploads/pdf.png"  height="30px" width="30px" ></a>';
				} else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
					$image_view_3 .= '<a href="javascript:print_2(\'/' . $po_file . '\')"><img src="uploads/excel.png"  height="30px" width="30px" ></a>';
				} else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
					$image_view_3 .= '<a href="javascript:print_2(\'/' . $po_file . '\')"><img src="uploads/word.png"  height="30px" width="30px" ></a>';
				}
			}
		}
	}
	return $image_view_3;
}


function image_view_4($folder_name = "", $unique_id = "", $file_name = "")
{
	// echo $file_name;
	$file_names = explode(',', $file_name);
	$image_view_4 = '';
	if ($file_name) {
		foreach ($file_names as $file_key => $file_name) {
			if ($file_key != 0) {
				if ($file_key % 4 != 0) {
					$image_view_4 .= "&nbsp";
				} else {
					$image_view_4 .= "<br><br>";
				}
			}
			$cfile_name = explode('.', $file_name);
			if ($file_name) {
				if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
					$image_view_4 .= '<a href="javascript:print_view_3(\'/' . $file_name . '\')"><img src="uploads/po_form/' . $file_name . '"  height="30px" width="30px" ></a>';
				} else if ($cfile_name[1] == 'pdf') {
					$image_view_4 .= '<a href="javascript:print_pdf_2(\'/' . $file_name . '\')"><img src="uploads/pdf.png"  height="30px" width="30px" ></a>';
				} else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
					$image_view_4 .= '<a href="javascript:print_2(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
				} else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
					$image_view_4 .= '<a href="javascript:print_2(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
				}
			}
		}
	}
	return $image_view_4;
}

?>
</script>
