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
		$unique_id = $_GET["unique_id"];
		//  $form_main_unique_id  = $_GET["form_main_unique_id"];

		$where = [
			"unique_id" => $unique_id,
			"is_delete" => 0,
		];
		$table = "invoice_creation_main";
		$columns = [
			"get_po_number(form_main_unique_id) AS po_num",
			// "po_date",
			"DATE_FORMAT((select po_date from po_form where  po_form.unique_id=$table.form_main_unique_id), '%d-%m-%Y') as po_date",
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
			"(select con_contact_number from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_contact_number",

			"(select zone from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS zone",

			"(select con_pincode from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_pincode",

			"po_unique_id",
			"unique_id",
			"form_main_unique_id",
			"invoice_auto_id",
			"invoice_date",
			"consignee_unique_id",
			"stock_id",
			"stock_date",
			"invoice_no",
			"ledger_name",
			"ledger_no",
			"ledger_no as ledger_unique_id",
			"(select remarks from stock_position_main where form_main_unique_id = $table.form_main_unique_id group by form_main_unique_id) AS remarks",
			"(SELECT part_no_file FROM stock_position_main WHERE form_main_unique_id  = " . $table . ".form_main_unique_id group by form_main_unique_id) AS part_no_file",
			"(select gst_value from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS gst_value",
			"(select contact_number from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS contact_number",
			"(select email from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS email",
			"(select bill_address from po_form where po_form.unique_id=" . $table . ".form_main_unique_id group by form_main_unique_id) AS bill_address",
			"invoice_auto_id",
			"dc_number",
			"dc_date",
			"material_qc",
			"get_district_name_po(po_unique_id) AS district_name",
			"get_state_name_po(po_unique_id) AS state_name",
			// "get_address_po(po_unique_id) AS bill_address",
			// "get_contact_no_po(po_unique_id) AS contact_number",
			// "get_contact_email_po(po_unique_id) AS email",
			// "cns_get_contact_number($table.consignee_unique_id) AS con_contact_no",
			"invoice_doc_status",
			"reject_reason_elcot",
			"doc_approval_sts",
			"ac_team_verifiy_status",
			"approved_by",
			"DATE_FORMAT(approved_date, '%d-%m-%Y') AS approved_date",
			"ac_team_approved_by",
			"DATE_FORMAT(ac_approved_date, '%d-%m-%Y') AS ac_approved_date",

			// "(select contact_number from po_foem where unique_id = $table.consignee_unique_id) AS con_contact_no",



		];
		$table_details = [
			$table,
			$columns
		];
		$result_values = $pdo->select($table_details, $where);
		// print_r($result_values);die();
		if ($result_values->status) {
			$result_values = $result_values->data;
			$po_num = $result_values[0]["po_num"];
			$po_unique_id = $result_values[0]["po_unique_id"];
			// $po_num_get =  $po_num . ' / ' . $po_unique_id;
			// $po_num_get =  $po_num;
			$po_date = $result_values[0]["po_date"];
			// $executive_name = $result_values[0]["executive_name"];
			$con_contact_name = $result_values[0]["con_contact_name"];
			$con_address = $result_values[0]["con_address"];
			$billing_address = $result_values[0]["billing_address"];

			$stock_qty = $result_values[0]["stock_qty"];
			// $no_of_items = $result_values[0]["no_of_items"];
			$invoice_value = $result_values[0]["invoice_value"];
			$department = $result_values[0]['department'];
			$department_unique_id = $result_values[0]["department_unique_id"];
			$con_pincode = $result_values[0]['con_pincode'];
			$con_districts = district_name($result_values[0]['con_district']);
			$con_district = disname($con_districts[0]['district_name']);
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
			$ledger_unique_id = $result_values[0]["ledger_unique_id"];
			$remarks = $result_values[0]["remarks"];
			$invoice_auto_id = $result_values[0]["invoice_auto_id"];
			$material_qc = $result_values[0]["material_qc"];


			$dc_number = $result_values[0]["dc_number"];
			$dc_date = $result_values[0]["dc_date"];

			$con_districts = district_name($result_values[0]['con_district']);
			$con_district = disname($con_districts[0]['district_name']);
			// $con_dis = $result_values[0]["con_district"];
			$con_states = con_state_name($result_values[0]["con_state_name"]);
			$con_state = disname($con_states[0]['state_name']);
			$con_zone = $result_values[0]["zone"];
			$district_name = district_name_stock($result_values[0]["district_name"]);
			$state_name = con_state_name_stock($result_values[0]["state_name"]);
			$bill_address = $result_values[0]["bill_address"];
			$contact_number = $result_values[0]["contact_number"];
			$email = $result_values[0]["email"];
			$con_contact_no = $result_values[0]["con_contact_number"];
			$invoice_doc_status = $result_values[0]['invoice_doc_status'];

			$op_approve_by = $result_values[0]['approved_by'];
			$op_approve_date = $result_values[0]['approved_date'];

			$acc_approve_by = $result_values[0]['ac_team_approved_by'];
			$acc_approve_date = $result_values[0]['ac_approved_date'];
			// print_r($con_contact_no);

			if ($invoice_doc_status == 3) {
				// $invoice_doc_status = "A/c Team Approval";
				$invoice_doc_status = "Completed";
			} else if ($invoice_doc_status == 1) {
				$invoice_doc_status = "Approved";
			} else if ($invoice_doc_status == 2) {
				$invoice_doc_status = "<span style='color: red;'>Rejected</span>";
				//  = "";
			} else if ($invoice_doc_status == 0) {
				$invoice_doc_status = "Pending";
			}

			$reason = $result_values[0]['reject_reason_elcot'];

			$op_team_statuss = $result_values[0]['doc_approval_sts'];

			$acc_team_statuss = $result_values[0]['ac_team_verifiy_status'];

			if ($op_team_statuss == 1) {
				$op_team_status = '<i class="mdi mdi-check-circle mdi-24px" style="color:green;"></i>';
			} else {
				$op_team_status = '<i class="mdi mdi-close-circle mdi-24px" style="color:red;"></i>';
			}
			if ($acc_team_statuss == 1) {
				$acc_team_status = '<i class="mdi mdi-check-circle mdi-24px" style="color:green;"></i>';
			} else {
				$acc_team_status = '<i class="mdi mdi-close-circle mdi-24px" style="color:red;"></i>';
			}

			if ($op_team_statuss != 1) {
				$op_team_div = '<h4>Operation Team</h4><div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Status</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $op_team_status . '</b></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Reject By</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $op_approve_by . '</b></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Rejected Date</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $op_approve_date . '</b></div>
    </div>
	</div>
   <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Reject Reason</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . htmlspecialchars($reason) . '</b></div>
    </div>
  </div>';
			} else if ($op_team_statuss == 1) {

				$op_team_div = '<h4>Operation Team</h4>
						<div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Status</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6">' . $op_team_status . '</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Approved By</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $op_approve_by . '</b></div>
    </div>
  </div>
  
   <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Approved Date</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $op_approve_date . '</b></div>
    </div>
  </div>';

			}

			if ($acc_team_statuss != 1) {
				$acc_team_div = '<h4>Accounts Team</h4><div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Status</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_team_status . '</b></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Reject By</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_approve_by . '</b></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Rejected Date</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_approve_date . '</b></div>
    </div>
	</div>
   <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Reject Reason</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . htmlspecialchars($reason) . '</b></div>
    </div>
  </div>';
			} else if ($acc_team_statuss == 1) {

				$acc_team_div = '<h4>Accounts Team</h4>
						<div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Status</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_team_status . '</b></div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Approved By</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_approve_by . '</b></div>
    </div>
  </div>
  
   <div class="col-md-3">
    <div class="d-flex mb-1">
      <div class="col-5 text-body-secondary"><b>Approved Date</b></div>
      <div class="col-1 px-0">:</div>
      <div class="col-6"><b>' . $acc_approve_date . '</b></div>
    </div>
  </div>';

			}








			if ($result_values[0]["gst_value"] == '') {

				$pro_gst_value = '-';
			} else {
				$pro_gst_value = $result_values[0]["gst_value"];
			}
			$po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);

			// $part_no_file = image_view_4("po_form", $result_values[0]['po_unique_id'], $result_values[0]['part_no_file']);

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

$ledger_type_options = legder_inv($department_unique_id);
$ledger_type_options = select_option($ledger_type_options, "Select Legder Name", $ledger_name);

$ledger_no_type_options = legder_no_po($department_unique_id);
$ledger_no_type_options = select_option($ledger_no_type_options, "Select Legder No", $ledger_no);
// print_r($consignee_type_options);die();
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$active_status_options = active_status($is_active);
?>

<style>
	#dynamicTable td {
		padding: 5px;
	}

	.wrap-cell {
		white-space: normal !important;
		word-break: break-word;
		max-width: 200px;
	}

	.table-row td {
		border: hidden;
	}

	.table-row {
		border: hidden;
	}

	table.dataTable.nowrap td {
		white-space: unset !important;
	}

	#update_dynamicTable td {
		padding: 5px;
	}

	.serial-input-update {
		width: 100%;
		/* Full width of the table cell */
		height: 40px;
		/* Increase the height */
		font-size: 18px;
		/* Larger text for better readability */
		padding: 5px;
		/* Add some padding inside the input */
		box-sizing: border-box;
		/* Ensure padding doesn't affect the width */
	}

	#update_dynamicTable td {
		padding: 15px;
		/* Space inside each table cell */
		text-align: center;
		/* Center text */
		min-width: 100px;
		/* Minimum width for each cell */
	}

	/* Ensure modal's input fields are larger */
	#serialNumberModalNew .form-control {
		font-size: 16px;
		/* Larger font size for inputs */
		padding: 10px;
		/* Add padding to make inputs more spacious */
		height: 45px;
		/* Increase input height for better appearance */
	}

	table thead tr th {
		text-align: center;
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

	.table-header-custom {}

	.table-header-custom th {
		color: #506018;
		font-weight: bold;
	}

	.btn-label {
		padding: 10px;
	}

	span.select2-selection.select2-selection--single {
		width: 100% !important;
		display: inline-grid;
	}

	span.select2.select2-container.select2-container--default {
		width: 100% !important;
	}
</style>
<!-- PAGE HEADER -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0">Invoice Form</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active">DC & Invoice</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- CARD WRAPPER -->
<div class="col-xxl-12 cf">
	<div class="card">
		<div class="card-body">

			<!-- TAB HEADER -->
			<ul class="nav nav-pills arrow-navtabs bg-light " role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
						<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
						<span class="d-none d-sm-block">Stock Details</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
						<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
						<span class="d-none d-sm-block">DC & Invoice Details</span>
					</a>
				</li>
			</ul>

			<!-- TAB CONTENT -->
			<div class="tab-content p-5">
				<!-- Stock Details Tab -->
				<div class="tab-pane active" id="arrow-overview" role="tabpanel">
					<form class="was-validated" autocomplete="off">
						<div class="row pb-3">

							<!-- Customer Details -->
							<div class="col-md-4">
								<h6 class="text-uppercase text-body-primary mb-3 sub_header_small" style="">Customer
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
								<h6 class="text-uppercase text-body-primary mb-3 sub_header_small">Consignee Details
								</h6>
								<h6 class="text-body-primary" style="font-size: x-large; color: #506018;">
									<strong><?php echo $con_contact_name ?></strong>
								</h6>
								<p class="text-body-primary mb-2"><?php echo $con_address ?>, <?php echo $con_zone ?>
								</p>
								<p class="text-body-primary mb-2"><?php echo $con_district ?>,
									<?php echo $con_state ?>,<?php echo $con_pincode ?>
								</p>
								<p class="mb-2"><i data-feather="phone"
										style="width:15px; height:15px; color:#506018;"></i>
									<?php echo !empty($con_contact_no) ? $con_contact_no : '--'; ?></p>

								<h6 class="text-uppercase text-body-primary mb-3 sub_header_small" style="">Billing
									Address</h6>
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
								<h6 class="text-uppercase text-body-primary mb-3 sub_header_small">PO Details</h6>
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
									<div class="col-6"><?php echo get_executive_name($executive_name); ?></div>
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


						</div> <!-- end row -->

						<!-- Product Table -->
						<div class="row">

							<div class="col-12 mt-3">
								<div class="table-responsive mb-4">

									<table class="table table-bordered table-striped align-middle">
										<thead>
											<tr>
												<th style="color: #506018; font-weight: bold;">S.No</th>
												<!-- <th style="color: #506018; font-weight: bold;">Item Code</th> -->
												<th style="color: #506018; font-weight: bold;">Item Details</th>
												<th style="color: #506018; font-weight: bold;">Order QTY</th>
												<th style="color: #506018; font-weight: bold;">Bill QTY</th>
												<!-- <th style="color: #506018; font-weight: bold;">Remaining QTY</th> -->
											</tr>
										</thead>
										<tbody>
											<?php
											// echo $form_main_unique_id;
											// echo "<br>";
											// echo $consignee_unique_id;
											$table_1 = 'view_product_assign_con_details';
											$columns_1 = [
												"item_code",
												"product",
												"stock_qty",
												"assign_qty",
												"form_main_unique_id",
												"product_unique_id",
												"(SELECT part_no FROM stock_position WHERE stock_position.product_unique_id = $table_1.product_unique_id Limit 1) AS part_no",
												// "get_part_no(product_unique_id) AS part_nos",
											];
											$table_details1 = [$table_1, $columns_1];
											$where1 = [
												"form_main_unique_id" => $form_main_unique_id,
												"con_unique_id" => $consignee_unique_id
											];
											$result1 = $pdo->select($table_details1, $where1);
											// print_r($result1);
											if ($result1->status) {
												$res_array1 = $result1->data;
												foreach ($res_array1 as $key => $value) {
													$value['s_no'] = $sno + 1;
													echo "<tr>
                                                        <td>{$value['s_no']}</td>
                                                        <td>
															<div><strong>{$value['item_code']}</strong>-Part No.<strong>{$value['part_no']}<strong></div>
															<div>{$value['product']}</div>
    													</td>
                                                        <td style='text-align: right;'>{$value['stock_qty']}</td>
												        <td style='text-align: right;'>{$value['assign_qty']}</td>
                                                    </tr>";
													$sno++;
												}
											}
											?>
										</tbody>
									</table>
									<?php
									// Assuming you have separate variables for each reject reason:
									$ope_reason = (!empty($ope_reason) ? $ope_reason : '-');
									$acc_reason = (!empty($acc_reason) ? $acc_reason : '-');
									?>

									<div class="row mb-2">
										<div class="col-md-6">
											<div class="d-flex mb-1">
												<div class="col-5 text-body-secondary">
													<h4>Invoice Status</h4>
												</div>
												<div class="col-1 px-0">:</div>
												<div class="col-6">
													<h6><?php echo htmlspecialchars($invoice_doc_status); ?></h6>
												</div>
											</div>
										</div>
										<div class="col-md-6"></div>
									</div>

									<div class="row mb-2">
										<?php echo $op_team_div; ?>
									</div>

									<div class="row mb-2">
										<?php echo $acc_team_div; ?>
									</div>


								</div>
								<div class="form-group row ">
									<div class="col-md-12" align="right">
										<!-- Cancel,save and update Buttons -->
										<?php echo btn_cancel($btn_cancel); ?>

									</div>
								</div>

							</div>
						</div> <!-- end table row -->
					</form>
				</div>
				<div class="tab-pane" id="arrow-profile" role="tabpanel">
					<form class="was-validated" autocomplete="off">
						<div class="row mb-3">
							<!-- Left: Consignee Details -->
							<div class="col-md-6">
								<h6 class="text-uppercase mb-3 sub_header_small">Consignee Details</h6>
								<h6 class="text-body-primary" style="font-size: x-large; color: #506018;">
									<strong><?php echo $con_contact_name ?></strong>
								</h6>
								<p class="text-body-primary mb-2"><?php echo $con_address ?>, <?php echo $con_zone ?>
								</p>
								<p class="text-body-primary mb-2"><?php echo $con_district ?>, <?php echo $con_state ?>
								</p>
								<p class="mb-2"><i data-feather="phone"
										style="width:15px; height:15px; color:#506018;"></i>
									<?php echo !empty($contact_number) ? $contact_number : '--'; ?></p>

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
									<div class="col-6">
										<input type="text" name="dc_number" id="dc_number" class="form-control"
											value="<?php echo $dc_number ?>" required onchange="get_dc_no()" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
										<input type="hidden" id="old_dc_number" name="old_dc_number"
											class="form-control mb-2" value="<?php echo $dc_number; ?>" required>


										<input type="hidden" name="mydc_no" id="mydc_no"
											value="<?php echo $dc_number; ?>">
										<input type="hidden" name="myinv_auto_id" id="myinv_auto_id"
											value="<?php echo $invoice_auto_id; ?>" <?php if ($material_qc == 1) {
												   echo 'readonly';
											   } ?>>
									</div>
								</div>

								<div class="mb-2 d-flex align-items-center">
									<div class="col-5 text-body-secondary">DC Date</div>
									<div class="col-1">:</div>
									<div class="col-6">
										<input type="date" name="dc_date" id="dc_date" class="form-control" required
											value="<?php echo $result_values[0]["dc_date"]; ?>"
											max="<?= date('Y-m-d') ?>" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
									</div>
								</div>

								<div class="mb-2 d-flex align-items-center">
									<div class="col-5 text-body-secondary">Invoice No</div>
									<div class="col-1">:</div>
									<div class="col-6">
										<input type="text" name="invoice_no" id="invoice_no" class="form-control"
											value="<?php echo $invoice_no ?>" required onchange="get_invoice_no()" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
										<input type="hidden" name="myinv_no" id="myinv_no"
											value="<?php echo $invoice_no; ?>">
										<input type="hidden" name="stock_id" id="stock_id" class="ser-qty-input"
											value="<?php echo $stock_id; ?>" readonly>
									</div>
								</div>

								<div class="mb-2 d-flex align-items-center">
									<div class="col-5 text-body-secondary">Invoice Date</div>
									<div class="col-1">:</div>
									<div class="col-6">
										<input type="date" name="invoice_date_1" id="invoice_date_1"
											class="form-control" required
											value="<?php echo $result_values[0]["invoice_date"]; ?>"
											max="<?= date('Y-m-d') ?>" <?php echo ($material_qc == 1) ? 'readonly' : ''; ?>>
									</div>
								</div>

								<div class="mb-2 d-flex align-items-center">
									<div class="col-5 text-body-secondary">Ledger Name</div>
									<div class="col-1">:</div>
									<div class="col-6">
										<select name="ledger_name" id="ledger_name" class="select2 form-control"
											onchange="loadLedgerNumber(this.value)" <?php echo ($material_qc == 1) ? 'disabled' : ''; ?>>
											<?php echo $ledger_type_options; ?>
										</select>
									</div>
								</div>

								<div class="mb-2 d-flex align-items-center">
									<div class="col-5 text-body-secondary">Ledger Number</div>
									<div class="col-1">:</div>
									<div class="col-6">
										<!-- <select name="ledger_no" id="ledger_no" class="form-select" <?php echo ($material_qc == 1) ? 'disabled' : ''; ?>>
											<?php echo $ledger_no_type_options; ?>
										</select> -->
										<input type="hidden" id="ledger_no" name="ledger_no" class="form-control"
											value="<?php echo $ledger_no; ?>" required>
										<input type="text" id="ledger_unique_id" name="ledger_unique_id"
											class="form-control" value="<?php echo $ledger_unique_id; ?>" required <?php if ($material_qc == 1) {
												   echo 'readonly';
											   } ?>>
										<!-- <input type="text" name="ledger_no" class="form-control" value="<?php echo $ledger_no_type_options ?>"> -->
									</div>
								</div>

								<div class="mb-2 d-flex">
									<div class="col-5 text-body-secondary">PO Attachment</div>
									<div class="col-1">:</div>
									<div class="col-6"><?php echo $part_no_file ?></div>
								</div>
							</div>
						</div>


						<!-- 3 DOC Attachment Row -->
						<div class="row mt-4 align-items-end">
							<p class="mb-2"><b>Attachment - 3 DOCS</b></p>

							<div class="col-md-3 mb-2">
								<label class="form-label">Dc</label>
								<input class="form-control form-control" id="dc_file_name" type="file"
									name="dc_file_name[]" accept="application/pdf" value="<?php echo $dc_file_name; ?>">
							</div>

							<div class="col-md-3 mb-2">
								<label class="form-label">IR</label>
								<input class="form-control form-control" id="ir_file_name" type="file"
									name="ir_file_name[]" accept="application/pdf" value="<?php echo $ir_file_name; ?>">
							</div>

							<div class="col-md-3 mb-2">
								<label class="form-label">Invoice</label>
								<input class="form-control form-control" id="file_invoice" type="file"
									name="file_invoice[]" accept="application/pdf" value="<?php echo $file_invoice; ?>">
								<input type="hidden" id="po_unique_id" name="po_unique_id"
									value="<?php echo $unique_id; ?>">
							</div>

							<div class="col-md-3 mb-2">
								<label class="form-label invisible">Add</label>
								<button type="button" id="no_records_msg"
									class="btn btn-primary btn-sm btn-label invoice_details_add_update_btn"
									onclick="invoice_details();">
									<i
										class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-14 me-1"></i>
									Add New
								</button>
							</div>
						</div>

						<div class="row">
							<input type="hidden" id="po_num" name="po_num" value="<?php echo $po_num; ?>">
							<input type="hidden" id="ledger_unique_id" name="ledger_unique_id"
								value="<?php echo $ledger_unique_id; ?>">
							<input type="hidden" id="po_date" name="po_date"
								value="<?php echo date('Y-m-d', strtotime($po_date)); ?>">
							<input type="hidden" id="executive_name" name="executive_name"
								value="<?php echo $executive_name; ?>">
							<input type="hidden" id="form_main_unique_id" name="form_main_unique_id"
								value="<?php echo $form_main_unique_id; ?>">
							<input type="hidden" id="po_unique_id" name="po_unique_id"
								value="<?php echo $po_unique_id; ?>">
							<input type="hidden" id="consignee" name="consignee"
								value="<?php echo $con_contact_name; ?>">
							<input type="hidden" name="consignee_unique_id" id="consignee_unique_id"
								value="<?php echo $consignee_unique_id ?>">
							<input type="hidden" id="invoice_date" name="invoice_date" class="form-control"
								value="<?php echo $invoice_date; ?>">
							<input type="hidden" id="invoice_unique_id" name="invoice_unique_id"
								value="<?php echo $unique_id; ?>">
							<input type="hidden" id="invoice_auto_id" name="invoice_auto_id"
								value="<?php echo $result_values[0]["invoice_auto_id"]; ?>">
							<div class="col-lg-6">

								<div class="row">
									<?php

									if ($dc_number == '' || $material_qc == 1) { ?>
										<div class="col-md-4">

										</div>
										<?php
									} else { ?>
										<div class="col-md-4">
											<button type="button" onclick="main_submit()"
												class="btn btn-success waves-effect waves-light">
												Update
											</button>
										</div>

									<?php } ?>
								</div>
					</form>
				</div>
				<div class="col-12 mt-2">
					<div class="table-responsive mb-4">
						<table class="table table-striped table-bordered align-middle mb-0 small_table"
							id="invoice_details_datatable">
							<thead>
								<tr>
									<th style="color: #506018; font-weight: bold;">S.No</th>
									<th style="color: #506018; font-weight: bold;">Consignee Name</th>
									<th style="color: #506018; font-weight: bold;">Ledger Name & No</th>
									<th style="color: #506018; font-weight: bold;">Dc No / Date</th>
									<!-- <th style="color: #506018; font-weight: bold;">Dc Date</th> -->
									<th style="color: #506018; font-weight: bold;">Invoice No / Date</th>
									<!-- <th style="color: #506018; font-weight: bold;">Invoice Date</th> -->
									<th style="color: #506018; font-weight: bold;">DC Attachment</th>
									<th style="color: #506018; font-weight: bold;">IR Attachment</th>
									<th style="color: #506018; font-weight: bold;">Inv. Attachment</th>
									<th style="color: #506018; font-weight: bold;">Action</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td colspan="11" class="text-center text-muted">No data found</td>
								</tr>
							</tbody>

						</table>
					</div>
				</div>
				<!--invoice table records start-->
				<div class="col-12 mt-4">
					<div class="table-responsive mb-4">
						<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
							<thead>
								<tr>
									<th style="color: #506018; font-weight: bold;">S.No</th>
									<th scope="col" style="color: #506018; font-weight: bold;">Item Details</th>
									<!-- <th scope="col" style="color: #506018; font-weight: bold;">Product Name</th> -->
									<th scope="col" style="color: #506018; font-weight: bold;">Stock QTY</th>
									<th scope="col" style="color: #506018; font-weight: bold;">Invoice Bill QTY </th>
									<th scope="col" style="color: #506018; font-weight: bold;">Remaining QTY</th>
									<th scope="col" style="color: #506018; font-weight: bold;">Serial No</th>

								</tr>
							</thead>
							<tbody>

								<?php
								// $where1 = "po_unique_id = '" . $form_main_unique_id . "' AND consignee_id = '" . $consignee_unique_id . "' AND is_delete='0' and invoice_auto_id = '" . $invoice_auto_id . "'";
								$where1 = "po_unique_id = '" . $form_main_unique_id . "' AND consignee_id = '" . $consignee_unique_id . "' AND is_delete='0'";
								$table1 = "invoice_creation";
								$columns1 = [

									"item_code",
									"product",
									"item_qty",
									"invoice_qty",
									"unique_id",
									"product_unique_id",
									"ser_no",
									"seril_no_selc",
									"spec_srl_no"
								];
								$table_details1 = [
									$table1,
									$columns1
								];

								$values_product = $pdo->select($table_details1, $where1);

								// print_r( $values_product);
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
											<td>
												<div><strong><?php echo $product['item_code']; ?></strong></div>
												<div><?php echo $product['product']; ?></div>
											</td>

											<td style='text-align: right;'><?php echo $product['item_qty']; ?></td>
											<td style='text-align: right;'><?php echo $product['invoice_qty']; ?></td>
											<td style='text-align: right;'><?php echo $rem_qty; ?></td>
											<td class="wrap-cell">
												<select class="form-select mb-2 mt-2" name="seril_no_selc"
													id="seril_no_selc_<?php echo $product['unique_id']; ?>"
													data-product-name="<?= htmlspecialchars($product['product']) ?>"
													onchange="openSerialModal('<?php echo $product['unique_id']; ?>', this, '<?php echo $product['invoice_qty']; ?>')">
													<option value="">Select Serial No</option>
													<option value="With" <?= $product['seril_no_selc'] == 'With' ? 'selected' : '' ?>>With serial number</option>
													<option value="Without" <?= $product['seril_no_selc'] == 'Without' ? 'selected' : '' ?>>Without serial number</option>
												</select>

												<input type="hidden" name="ser_qty"
													id="ser_qty_<?php echo $product['unique_id']; ?>" class="form-control"
													readonly value="<?= $product['ser_no']; ?>">

												<?php if ($product['ser_no']) { ?>
													<b
														id="serial_no_lbl_<?php echo $product['unique_id']; ?>"><?= $product['ser_no']; ?></b><br>

												<?php } else { ?>

													<b id="serial_no_lbl_<?php echo $product['unique_id']; ?>"
														style="display:none;">
														<?= $product['ser_no']; ?></b><br>
												<?php } ?>

												<input type="hidden" name="spec_srl_no"
													id="spec_srl_no<?php echo $product['unique_id']; ?>" class="ser-qty-input"
													readonly>


												<input type="hidden" name="mon_ser_qty"
													id="mon_ser_qty_<?php echo $product['unique_id']; ?>"
													class="mon-ser-qty-input" style="display: none;" readonly>

												<div>

													<button id="save_<?php echo $product['unique_id']; ?>"
														class="btn btn-success waves-effect waves-light mt-3 mb-3"
														onclick="openNewSerialNumberModal('<?php echo $product['unique_id']; ?>', '<?php echo $product['ser_no']; ?>', '<?php echo $product['spec_srl_no']; ?>', '<?php echo $product['invoice_qty']; ?>', '<?php echo $product['item_code']; ?>',event)">
														Update
													</button>




												</div>

											</td>

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

						<!-- <button id="button" class="btn btn-success waves-effect waves-light" onclick="submit('<?php echo $product['unique_id']; ?>')">
						Submit
					</button> -->
						<button id="submit_all" class="btn btn-success waves-effect waves-light"
							onclick="submitAll(event)">Submit All</button>
					</div>
				</div>
			</div> <!-- end tab-content -->
		</div> <!-- end card-body -->
	</div> <!-- end card -->
</div> <!-- end col -->







<!-- Modal -->
<div class="modal fade" id="serialNumberModal" tabindex="-1" aria-labelledby="serialNumberModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="serialNumberModalLabel">Select Serial Number Option</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<div class="mt-3">
					<label>Invoice Qty:</label>
					<input class="form-control" type="number" id="optionInput1" placeholder="Enter a number"
						oninput="filterMainInput(this)" readonly>


					<!--</div>-->
					<!-- <div class="mt-3">-->
					<label>Specify no of Serial Number Per Product: </label>
					<select class="form-control" id="optioninput2" onchange="processInput()">
						<option value="1" selected>1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select><br>


				</div>
				<div class="radio-group">
					<label class="radio_space">
						<input type="radio" name="optionType" value="enter" onclick="toggleInput('enter')" checked>
						Enter
					</label>
					<label>
						<input type="radio" name="optionType" value="upload" onclick="toggleInput('upload')"> Upload
					</label>
				</div>

				<div id="enterSection" style="display: block;">
					<div id="inputContainer"></div>
					<table id="dynamicTable" class="tr_style"></table>
					<div class="mt-3">
						<label for="serial_no">Collected Values:</label>
						<input type="text" id="serial_no" name="serial_no" class="form-control" readonly>
					</div>
				</div>

				<div id="uploadSection" style="display: none;" class="pt-3">
					<div>
						<label>Upload File:</label>
						<input type="file" class="form-control" id="fileInput" accept=".xlsx">
					</div>
					<div class="pt-3">
						<label>Collected Values:</label>
						<input type="text" id="upload_collected_values" class="form-control" readonly>
						<!-- <input type="hidden" id="upload_collected_values" class="form-control" readonly> -->
					</div>

				</div>
				<input type="hidden" id="pop_up_unique_id" class="form-control" readonly>

				<div class="d-flex justify-content-end mt-3 px-3 pb-3">
					<button type="button" class="btn btn-primary"
						onclick="save('<?php echo $product['item_code']; ?>', document.getElementById('pop_up_unique_id').value)">Save</button>
					<!-- onclick="save('<?php echo $product['item_code']; ?>', '<?php echo $product['unique_id']; ?>')">Save</button> -->
				</div>

			</div>
		</div>
	</div>
</div>


<!--- Update serial No modal -->

<div class="modal fade" id="serialNumberModalNew" tabindex="-1" aria-labelledby="serialNumberModalNewLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg"> <!-- Larger modal for better table view -->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="serialNumberModalNewLabel">Update Serial Numbers</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<input type="hidden" id="update_unique_id" class="form-control" readonly>

			<div class="modal-body">
				<div class="mb-3">
					<label for="optionInput1New" class="form-label">Invoice Qty:</label>
					<input type="number" class="form-control" id="optionInput1New" placeholder="Enter a number"
						disabled>
				</div>

				<div class="mb-3">
					<label for="optionInput2New" class="form-label">Specify no of Serial Number Per Product:</label>
					<input type="number" class="form-control" id="optionInput2New" placeholder="Enter a number"
						disabled>
				</div>

				<div id="update_inputContainer" class="mb-3"></div>

				<table id="update_dynamicTable" class="table tr_style"></table>

				<div class="mb-3">
					<label for="update_collected_values_new" class="form-label">Collected Values:</label>
					<input type="text" id="update_collected_values_new" class="form-control" readonly>
				</div>
			</div>


			<div class="d-flex justify-content-end mt-3 px-3 pb-3">
				<button type="button" class="btn btn-primary"
					onclick="update_serial_no(update_collected_values_new.value, update_unique_id.value)">Update</button>
			</div>


		</div>
	</div>
</div>




<style>
	.radio_space {
		padding-right: 30px;
	}
</style>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


end col
<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
Bootstrap CSS
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
Bootstrap JS (For Modal)
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- For SweetAlert2 (Recommended) -->

<script src="assets/js/xlsx.full.min.js"></script>




<script>
	$(document).ready(function () {
		var ledger_name = document.getElementById('ledger_name').value;
		if (ledger_name != '') {
			loadLedgerNumber(ledger_name);
		} else {
			document.getElementById("ledger_no").value = '';
			document.getElementById("ledger_unique_id").value = '';
		}
	});


	// document.getElementById('invoice_date_1').addEventListener('input', function () {
	//     const selectedDate = new Date(this.value);
	//     const today = new Date();
	//     today.setHours(0, 0, 0, 0); // normalize time

	//     if (selectedDate >= today) {
	//         this.value = ''; // silently clear the field
	//     }
	// });

	function loadLedgerNumber(ledgerName) {
		// if (!ledgerName) {
		//     console.warn("No ledger name provided");
		//     return;
		// }

		// alert("Ledger Name: " + ledgerName);
		document.getElementById("ledger_no").value = '';
		document.getElementById("ledger_unique_id").value = '';

		const formData = new FormData();
		formData.append("ledger_name", ledgerName);
		formData.append("action", "get_ledger_no");

		fetch("folders/invoice/crud.php", {
			method: "POST",
			body: formData
		})
			.then(response => {
				if (!response.ok) {
					throw new Error("Network response was not ok");
				}
				return response.json();
			})
			.then(data => {

				if (data.status) {
					let uniqueId = data.unique_id;
					let ledgerNo = data.ledger_no;

					// alert("Unique ID: " + uniqueId + "\nLedger No: " + ledgerNo);


					document.getElementById("ledger_no").value = uniqueId;
					document.getElementById("ledger_unique_id").value = ledgerNo;
				} else {
					// console.warn("Ledger not found:", data.message);
					document.getElementById("ledger_unique_id").value = '';
					document.getElementById("ledger_no").value = '';
				}
			})
			.catch(error => {
				console.error("Error fetching ledger number:", error);
				alert("Error: " + error.message);
			});
	}


	function updateLedgerNo1() {
		var ledger_name = $("#ledger_name").val();
		// alert(ledger_name);
		var data = {
			"ledger_name": ledger_name,
			"action": "get_ledger_no"
		}
		var ajax_url = sessionStorage.getItem("folder_crud_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {

				if (data) {
					$("#ledger_no").html(data);
				}

			}
		});

	}
	document.getElementById('invoice_date_1').addEventListener('input', function () {
		const selectedDate = new Date(this.value);
		const today = new Date();
		today.setHours(0, 0, 0, 0); // normalize time

		if (selectedDate > today) {
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			this.value = `${yyyy}-${mm}-${dd}`; // set to today's date
		}
	});
	// document.getElementById('dc_date').addEventListener('input', function () {
	//     const selectedDate = new Date(this.value);
	//     const today = new Date();
	//     today.setHours(0, 0, 0, 0); // reset time to midnight

	//     if (selectedDate >= today) {
	//         this.value = ''; // silently clear future date
	//     }
	// });
	document.getElementById('dc_date').addEventListener('input', function () {
		const selectedDate = new Date(this.value);
		const today = new Date();
		today.setHours(0, 0, 0, 0); // normalize time

		if (selectedDate > today) {
			// Format today's date as YYYY-MM-DD
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			this.value = `${yyyy}-${mm}-${dd}`; // set current date
		}
	});

	function allowAlphaNumericOnly(input) {
		// Replace any character that is not a-z, A-Z, or 0-9 with ''
		input.value = input.value.replace(/[^a-zA-Z0-9 /-]/g, '');
	}


	function update_serial_no(serial_no, unique_id) {


		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: {
				serial_no: serial_no,

				unique_id: unique_id,
				action: "update_serial_no"
			},
			success: function (response) {
				var obj = JSON.parse(response);
				if (obj.msg === 'duplicate') {
					Swal.fire({
						icon: 'warning',
						title: 'Duplicate Serial',
						text: obj.error || 'Already Exists in Database!.'
					});
				} else if (obj.status === 1) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Successfully Updated Serial Number',
						timer: 1000, // 2 seconds
						timerProgressBar: true,
						showConfirmButton: false
					}).then(() => {
						// Switch to the tab without reloading the page
						const modalElement = document.getElementById('serialNumberModalNew');
						const modal = bootstrap.Modal.getInstance(modalElement);
						modal.hide();
						new bootstrap.Tab(document.querySelector('a[href="#arrow-profile"]')).show();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: obj.error || 'Something went wrong!'
					});
				}
			},
			error: function () {
				alert("Network Error");
			}
		});
	}

	function openNewSerialNumberModal(uniqueId, serial_no, spec_srl_no, invoice_qty, item_code, e) {
		e.preventDefault();
		let selectedItemCode = "";

		selectedItemCode = uniqueId; // store if needed

		let serQtyInput = document.getElementById(`ser_qty_${selectedItemCode}`);
		let ser_no_selc = document.getElementById(`seril_no_selc_${selectedItemCode}`).value;
		// document.getElementById('pop_up_unique_id').value = uniqueId;


		if (ser_no_selc == 'Without') {

			save(item_code, uniqueId);
		} else if (ser_no_selc == 'With') {

			const modal = new bootstrap.Modal(document.getElementById('serialNumberModalNew'));
			modal.show();

			document.getElementById('optionInput1New').value = invoice_qty;
			document.getElementById('optionInput2New').value = spec_srl_no;
			document.getElementById('update_unique_id').value = uniqueId;




			update_processInput(serial_no, selectedItemCode);
		} else {
			alert("Select Serial No type");
		}

	}


	$(document).ready(function () {
		sub_list_datatable("invoice_details_datatable");
	});
	function get_invoice_no() {
		document.getElementById('myinv_no').value = '';
		var invoice_no = document.getElementById('invoice_no').value;
		// alert(po_num);
		document.getElementById('myinv_no').value = invoice_no;
	}



	function get_dc_no() {
		document.getElementById('mydc_no').value = '';
		var dc_number = document.getElementById('dc_number').value;
		// alert(po_num);
		document.getElementById('mydc_no').value = dc_number;
	}
	function submitAll(e) {
		e.preventDefault();
		// Select all product dropdowns dynamically by ID pattern
		const selects = document.querySelectorAll('select[id^="seril_no_selc_"]');
		const missing = [];

		selects.forEach(sel => {
			const id = sel.id.replace('seril_no_selc_', '');
			const productName = sel.dataset.productName || id;
			const val = sel.value;

			if (val === "") {
				missing.push(`"${productName}": please select "With" or "Without" serial number.`);
			} else if (val === "With") {
				const qtyEl = document.getElementById(`ser_qty_${id}`);
				if (!qtyEl || qtyEl.value.trim() === "") {
					missing.push(`"${productName}": serial numbers are required.`);
				}
			}
		});

		if (missing.length) {
			Swal.fire({
				icon: "warning",
				title: "Validation Error",
				html: missing.map(msg => `<p>${msg}</p>`).join(''),
				confirmButtonText: "OK"
			});
			return;
		}

		// If all validated okay
		Swal.fire({
			icon: "success",
			title: "All Valid",
			text: "Submitting data..."
		}).then(() => {
			const redirectUrl = sessionStorage.getItem("list_link");
			if (redirectUrl) window.location.href = redirectUrl;
			// or perform AJAX submission here
		});
	}

	function submitAll_Main() {
		const rows = document.querySelectorAll('select[id^="seril_no_selc_"]');
		const missing = [];

		rows.forEach(sel => {
			const id = sel.id.split('seril_no_selc_')[1];
			const productName = sel.dataset.productName || sel.id.split('seril_no_selc_')[1];
			const val = sel.value;

			if (val === "") {
				missing.push(`Product ${id}: Please select With/Without`);
			} else if (val === "With") {
				const qtyEl = document.getElementById(`ser_qty_${id}`);
				if (!qtyEl || qtyEl.value.trim() === "") {
					missing.push(`Product ${id}: Serial numbers required`);
				}
			}
		});

		if (missing.length) {
			Swal.fire({
				icon: "warning",
				title: "Validation Error",
				html: missing.map(msg => `<p>${msg}</p>`).join('')
			});
			return;
		}

		// All good: submit or redirect
		Swal.fire({
			icon: "success",
			title: "All Valid",
			text: "Submitting data..."
		}).then(() => {
			const redirectUrl = sessionStorage.getItem("list_link");
			if (redirectUrl) window.location.href = redirectUrl;
			// Optionally, send AJAX payload here
		});
	}

	function submit(uniqueId) {
		// Locate dynamic <select> for the selected product
		const selEl = document.getElementById(`seril_no_selc_${uniqueId}`);
		const qtyEl = document.getElementById(`ser_qty_${uniqueId}`);
		const hiddenSerEl = document.getElementById(`spec_srl_no${uniqueId}`);
		const displayLabel = document.getElementById(`serial_no_lbl_${uniqueId}`);

		if (!selEl) {
			console.error(`Missing select: seril_no_selc_${uniqueId}`);
			return;
		}

		if (selEl.value === "") {
			Swal.fire({
				icon: "warning",
				title: "Warning",
				text: "Please select 'With serial number' or 'Without serial number'."
			});
			return;
		}

		if (selEl.value === "With") {
			// Must have serial values when "With" is selected
			if (!qtyEl || qtyEl.value.trim() === "") {
				Swal.fire({
					icon: "warning",
					title: "Incomplete",
					text: "Please enter serial numbers before submitting."
				}).then(() => {
					openSerialModal(uniqueId, selEl, selEl.getAttribute("data-invoice-qty"));
				});
				return;
			}
		}

		// All validation passed
		Swal.fire({
			icon: "success",
			title: "Success",
			text: "Submission successful!"
		}).then(() => {
			const redirectUrl = sessionStorage.getItem("list_link");
			if (redirectUrl) window.location.href = redirectUrl;
		});
	}

	function submit12(uniqueId) {
		// alert(uniqueId);
		// Dynamically find the correct input by ID template
		const selInput = document.getElementById(`seril_no_selc_${uniqueId}`);
		if (!selInput) {
			console.error("Missing input element for ID:", `seril_no_selc_${uniqueId}`);
			return;
		}

		const value = selInput.value.trim();
		const ajaxUrl = sessionStorage.getItem("folder_crud_link");
		const redirectUrl = sessionStorage.getItem("list_link");

		if (value !== "") {
			// Optionally send via AJAX before alert
			// fetch(ajaxUrl, { method: "POST", body: JSON.stringify({ serials: value }) })
			//   .then(resp => resp.json())
			//   .then(() => {
			Swal.fire({
				icon: "success",
				title: "Success",
				text: "Serial numbers submitted successfully"
			}).then(() => {
				if (redirectUrl) window.location.href = redirectUrl;
			});
			//   });
		} else {
			Swal.fire({
				icon: "warning",
				title: "Warning",
				text: "Please fill in the serial numbers first"
			});
			// No redirect on warning to allow user to add values
		}
	}
	function without_submit() {
		const selInput = document.getElementById('seril_no_selc');
		if (!selInput) {
			console.error("Missing element with ID 'seril_no_selc'");
			return;
		}

		const value = selInput.value.trim();
		const ajaxUrl = sessionStorage.getItem("folder_crud_link"); // Use when sending AJAX
		const redirectUrl = sessionStorage.getItem("list_link");

		if (value !== "") {
			// Optional: send serials to server via AJAX, then show success
			// fetch(ajaxUrl, { method: 'POST', body: JSON.stringify({ serials: value }) })
			//   .then(res => res.json())
			//   .then(() => {
			Swal.fire({
				icon: "success",
				title: "Success",
				text: "Serial number submitted successfully"
			}).then(() => {
				if (redirectUrl) window.location.href = redirectUrl;
			});
			//   });
		} else {
			Swal.fire({
				icon: "warning",
				title: "Warning",
				text: "You must fill in the serial number"
			});
			// No redirect – allows user to correct the input
		}
	}


	// function submit() {
	// 	var seril_no_selc = document.getElementById('seril_no_selc').value;
	// 	if(seril_no_selc != '' ){
	// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
	// 	var url = sessionStorage.getItem("list_link");

	// 	Swal.fire({
	// 		icon: 'success',
	// 		title: 'Success',
	// 		text: 'Successfully Submited'
	// 	}).then(() => {
	// 		window.location.href = url; // Redirect if needed
	// 	});
	// 	}else{

	// 		Swal.fire({
	// 		icon: 'Warning',
	// 		title: 'Warning',
	// 		text: 'Must Be fill an Serial Number'
	// 	})
	// 	.then(() => {
	// 		window.location.href = url; // Redirect if needed
	// 	});
	// 	}

	// }



	function save(item_code, unique_id) {
		const dc_number = document.getElementById('dc_number').value;
		// alert(dc_number);
		const sel = $('#seril_no_selc_' + unique_id).val();
		const qty = $('#ser_qty_' + unique_id).val().trim();
		const spec = $('#spec_srl_no' + unique_id).val();
		const mon = $('#mon_ser_qty_' + unique_id).val();

		if (sel === 'With' && !qty) {
			sweetalert('alert_serial');
			return false;
		}

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		// if(dc_number != ''){
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: {
				ser_qty: qty,
				mon_ser_qty: mon,
				seril_no_selc: sel,
				spec_srl_no: spec,
				unique_id: unique_id,
				dc_number: dc_number,
				action: "serial_no_update"
			},
			dataType: "json",
			success: function (obj) {
				if (obj.msg === 'duplicate') {
					Swal.fire({
						icon: 'warning',
						title: 'Duplicate Serial',
						text: obj.error || 'Already Exists in Database!.'
					});
				} else if (obj.status === 1) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Serial number updated successfully',
						timer: 1000,
						timerProgressBar: true,
						showConfirmButton: false
					}).then(() => {
						window.location.hash = '#arrow-profile';
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: obj.error || 'Something went wrong!'
					});
				}
			},
			error: function (xhr) {
				Swal.fire({
					icon: 'error',
					title: 'Network Error',
					text: `Please try again later. (Code: ${xhr.status})`
				});
			}
		});
		//   }else{
		// 	 Swal.fire({
		//         icon: 'Warning',
		//         title: 'DC Fill',
		//         text: 'DC Number Enter First',
		//       });
		//   }
	}


	function save_bkp(item_code, unique_id) {
		const dc_number = document.getElementById('dc_number').value;

		// alert(unique_id);
		var seril_no_selc = $('#seril_no_selc_' + unique_id).val();
		var ser_qty = $('#ser_qty_' + unique_id).val();
		var spec_srl_no = $('#spec_srl_no' + unique_id).val();


		if (seril_no_selc === 'With' && (!ser_qty || ser_qty.trim() === '')) {
			sweetalert("alert_serial"); // Custom alert function
			return false;
		}


		var mon_ser_qty = $('#mon_ser_qty_' + unique_id).val();

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: {
				ser_qty: ser_qty,
				dc_number: dc_number,
				mon_ser_qty: mon_ser_qty,
				seril_no_selc: seril_no_selc,
				spec_srl_no: spec_srl_no,
				unique_id: unique_id,
				action: "serial_no_update"
			},
			success: function (response) {
				var obj = JSON.parse(response);

				if (obj.status === 1) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Successfully Updated Serial Number',
						timer: 1000, // 2 seconds
						timerProgressBar: true,
						showConfirmButton: false
					}).then(() => {

						window.location.hash = '#arrow-profile';
						location.reload();

					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: obj.error || 'Something went wrong!'
					});
				}
			},
			error: function () {
				alert("Network Error");
			}
		});
	}

	window.addEventListener('DOMContentLoaded', () => {
		const hash = window.location.hash;
		if (hash) {
			const tabTriggerEl = document.querySelector(`a[href="${hash}"]`);
			if (tabTriggerEl) {
				const tab = new bootstrap.Tab(tabTriggerEl);
				tab.show();
			}
		}
	});

	let selectedItemCode = ""; // Store selected item code

	function openSerialModal(itemCode, selectElement, invoice_qty) {

		let selectedItemCode = ""; // Store selected item code

		document.getElementById("pop_up_unique_id").value = itemCode; // Append Unique Id
		// alert(itemCode);
		selectedItemCode = itemCode; // Save selected item code
		let selection = selectElement.value; // Get the selected value from the specific dropdown
		console.log("Selected Option:", selection); // Debugging

		let serQtyInput = document.getElementById(`ser_qty_${itemCode}`);
		let serNolbl = document.getElementById(`serial_no_lbl_${itemCode}`);
		document.getElementById(`spec_srl_no${itemCode}`).value = '';

		if (serQtyInput) {
			serQtyInput.value = ""; // Reset ser_qty input field
		}

		// Reset modal values
		document.getElementById("serial_no").value = ""; // Clear previous values
		document.getElementById("optionInput1").value = invoice_qty; // Append invoice qty in the first input
		document.getElementById('optioninput2').selectedIndex = 0;
		// document.getElementById("outputValues1").value = ""; // Reset input
		// document.getElementById("outputValues2").value = ""; // Reset input
		document.getElementById("upload_collected_values").value = ""; // Reset input
		document.getElementById("dynamicTable").innerHTML = ""; // Clear dynamic table
		let fileInput = document.getElementById("fileInput");
		//alert(fileInput);
		fileInput.value = "";


		if (selection === "With") {
			//alert("yes if working");
			let modal = new bootstrap.Modal(document.getElementById("serialNumberModal"));
			modal.show();
			if (serQtyInput) serQtyInput.style.display = "block";
			serNolbl.style.display = "block";
			processInput(selectedItemCode);

		} else {
			if (serQtyInput) serQtyInput.style.display = "none";
			if (serQtyInput) serNolbl.style.display = "none";

		}
	}



	// function serilselect() {
	//     var selection = document.getElementById('seril_no_selc').value;
	//     var serialSection = document.getElementById('serialNumberSection');
	// 	if (selection === "With") {
	//         let modal = new bootstrap.Modal(document.getElementById('serialNumberModal'));
	//         modal.show();
	//     }
	//     if (selection === "With") {
	//         serialSection.style.display = "block";
	//     } else {
	//         serialSection.style.display = "none";
	//     }



	// }

	function main_submit() { // au = add,update
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
			var myinv_no = document.getElementById('myinv_no').value;
			var po_date = document.getElementById('po_date').value;
			var executive_name = document.getElementById('executive_name').value;
			var consignee_unique_id = document.getElementById('consignee_unique_id').value;
			var form_main_unique_id = document.getElementById('form_main_unique_id').value;
			var invoice_unique_id = document.getElementById('invoice_unique_id').value;
			var consignee = document.getElementById('consignee').value;
			var ledger_name = document.getElementById('ledger_name').value;
			// alert(ledger_name);
			var ledger_no = document.getElementById('ledger_no').value;
			var invoice_no = document.getElementById('invoice_no').value;
			var invoice_date_1 = document.getElementById('invoice_date_1').value;
			var serial_no = document.getElementById('serial_no').value;
			// var test_doc = document.getElementById('dc_file_name').value;
			// var test_doc1 = document.getElementById('ir_file_name').value;
			// var test_doc2 = document.getElementById('file_invoice').value;
			var po_unique_id = document.getElementById('po_unique_id').value;

			// var image_s = document.getElementById("dc_file_name");
			// var image_ir = document.getElementById("ir_file_name");
			// var image_in = document.getElementById("file_invoice");
			var data = new FormData();
			// if (image_s != '') {
			// 	for (var i = 0; i < image_s.files.length; i++) {
			// 		data.append("file", document.getElementById('dc_file_name').files[i]);
			// 	}
			// } else {
			// 	data.append("test_doc", '');
			// }
			// if (image_ir != '') {
			// 	for (var i = 0; i < image_ir.files.length; i++) {
			// 		data.append("test_file1", document.getElementById('ir_file_name').files[i]);
			// 	}
			// } else {
			// 	data.append("test_doc1", '');
			// }
			// if (image_in != '') {
			// 	for (var i = 0; i < image_in.files.length; i++) {
			// 		data.append("test_file2", document.getElementById('file_invoice').files[i]);
			// 	}
			// } else {
			// 	data.append("test_doc2", '');
			// }

			// dc number and dc date added
			var dc_number = document.getElementById('dc_number').value;
			var dc_date = document.getElementById('dc_date').value;
			var mydc_no = document.getElementById('mydc_no').value;

			var myinv_auto_id = document.getElementById('myinv_auto_id').value;
			var old_dc_number = document.getElementById('old_dc_number').value;

			// alert(invoice_unique_id);

			// dc number
			//    alert(image_s);
			// data.append("no_of_po", no_of_po);
			data.append("myinv_no", myinv_no);
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
			data.append("serial_no", serial_no);
			data.append("invoice_unique_id", invoice_unique_id);
			data.append("dc_number", dc_number);
			data.append("dc_date", dc_date);
			data.append("mydc_no", mydc_no);
			data.append("myinv_auto_id", myinv_auto_id);
			data.append("old_dc_number", old_dc_number);
			// 	data.append("demo", demo);
			data.append("po_unique_id", po_unique_id);
			data.append("action", "reupdate");
			// // var data = $(".product_details_form").serialize();"&po_num=" + po_num +po_date=" + po_date + 
			// var data = "po_num=" + po_num + "&po_date=" + po_date +
			//     "&excutive_name=" + excutive_name +
			//     "&no_of_consignee=" + no_of_consignee + "&consignee=" + consignee + "&ledger_name=" +
			//     ledger_name + "&invoice_no=" + invoice_no + "&invoice_date=" +
			//     invoice_date;
			// data += "&unique_id=" + unique_id + "&action=invoice_add_update";
			// var ajax_url = sessionStorage.getItem("folder_crud_link");
			// var url      = sessionStorage.getItem("list_link");
			var url = "";


			// console.log(data);
			$.ajax({
				type: "POST",
				url: 'folders/invoice/crud.php',
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				// beforeSend: function () {
				// 	$(".invoice_details_add_update_btn").attr("disabled", "disabled");
				// 	$(".invoice_details_add_update_btn").text("Loading...");
				// },
				success: function (data) {
					// alert(data);
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
					//alert(msg);
					if (!status) {
						// $(".invoice_details_add_update_btn").text("Error");
						console.log(error);
					} else {
						if (msg == "already") {
							alert("DC Number Already Exisits in table");
							sweetalert(msg);
							// form_reset("consignee_details_form");
						}
						else if (msg != "already") {
							// 
							// alert("its working");
							// new bootstrap.Tab(document.querySelector('a[href="#arrow-profile"]')).show();
							document.getElementById('old_dc_number').value = dc_number;
							alert("updated Successfully");

							invoice_update();
						}
						// $(".invoice_details_add_update_btn").removeAttr("disabled", "disabled");
						// if (unique_id && msg == "already") {
						// 	$(".invoice_details_add_update_btn").text("Update");
						// } else {
						// 	$(".invoice_details_add_update_btn").text("Add");
						// 	// $(".invoice_details_add_update_btn").attr("onclick",
						// 	// 	"invoice_details_add_update('')");
						// }
						// sweetalert(msg);
						// Init Datatable
						sub_list_datatable("invoice_details_datatable");

						// document.getElementById('con_address').value = '';
						// document.getElementById('con_district').value = '';
						// document.getElementById('con_pincode').value = '';
						// document.getElementById('con_contact_name').value = '';
						// document.getElementById('con_contact_number').value = '';
						// document.getElementById('con_lan_num').value = '';
					}
					sweetalert(msg);
				},
				error: function (data) {
					alert("Network Error");
				}
			});
		} else {
			sweetalert("form_alert");
		}
	}




	function invoice_details(unique_id = "") { // au = add,update
		// alert("hello");
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
			var myinv_no = document.getElementById('myinv_no').value;
			var stock_id = document.getElementById('stock_id').value;
			var po_date = document.getElementById('po_date').value;
			var executive_name = document.getElementById('executive_name').value;
			var consignee_unique_id = document.getElementById('consignee_unique_id').value;
			var form_main_unique_id = document.getElementById('form_main_unique_id').value;
			var invoice_unique_id = document.getElementById('invoice_unique_id').value;
			var consignee = document.getElementById('consignee').value;
			var ledger_name = document.getElementById('ledger_name').value;
			// alert(ledger_name);
			var ledger_no = document.getElementById('ledger_no').value;
			var invoice_no = document.getElementById('invoice_no').value;
			var invoice_date_1 = document.getElementById('invoice_date_1').value;
			var serial_no = document.getElementById('serial_no').value;
			var test_doc = document.getElementById('dc_file_name').value;
			var test_doc1 = document.getElementById('ir_file_name').value;
			var test_doc2 = document.getElementById('file_invoice').value;
			var po_unique_id = document.getElementById('po_unique_id').value;
			var mydc = document.getElementById("dc_file_name").value;
			var my_ir = document.getElementById("ir_file_name").value;
			var my_in = document.getElementById("file_invoice").value;
			var image_s = document.getElementById("dc_file_name");
			var image_ir = document.getElementById("ir_file_name");
			var image_in = document.getElementById("file_invoice");
			// alert(mydc);
			// alert(my_in);
			var data = new FormData();
			if (image_s != '') {
				for (var i = 0; i < image_s.files.length; i++) {
					data.append("file", document.getElementById('dc_file_name').files[i]);
				}
			} else {
				data.append("test_doc", '');
			}
			if (image_ir != '') {
				for (var i = 0; i < image_ir.files.length; i++) {
					data.append("test_file1", document.getElementById('ir_file_name').files[i]);
				}
			} else {
				data.append("test_doc1", '');
			}
			if (image_in != '') {
				for (var i = 0; i < image_in.files.length; i++) {
					data.append("test_file2", document.getElementById('file_invoice').files[i]);
				}
			} else {
				data.append("test_doc2", '');
			}

			// dc number and dc date added
			var dc_number = document.getElementById('dc_number').value;
			var dc_date = document.getElementById('dc_date').value;
			var mydc_no = document.getElementById('mydc_no').value;

			var myinv_auto_id = document.getElementById('myinv_auto_id').value;


			// dc number
			//    alert(image_s);
			// data.append("no_of_po", no_of_po);
			data.append("myinv_no", myinv_no);
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
			data.append("serial_no", serial_no);
			data.append("invoice_unique_id", invoice_unique_id);
			data.append("dc_number", dc_number);
			data.append("dc_date", dc_date);
			data.append("mydc_no", mydc_no);
			data.append("myinv_auto_id", myinv_auto_id);
			data.append("stock_id", stock_id);
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
			if (mydc != '' && my_in != '') {
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
						// alert(msg);
						if (!status) {
							$(".invoice_details_add_update_btn").text("Error");
							console.log(error);
						} else {
							if ((msg == "already" || (msg == "DC already") || (msg == "Invoice already"))) {
								// alert("DC Number Already Exisits in table");
								sweetalert(msg);
								form_reset("consignee_details_form");
							}
							else if (msg != "already") {
								invoice_update();
							}
							$(".invoice_details_add_update_btn").removeAttr("disabled", "disabled");
							if (unique_id && msg == "already") {
								$(".invoice_details_add_update_btn").text("Update");
							} else {
								$(".invoice_details_add_update_btn").text("Add");
								// $(".invoice_details_add_update_btn").attr("onclick",
								// 	"invoice_details_add_update('')");
							}
							sub_list_datatable("invoice_details_datatable");

							sweetalert(msg);
							// Init Datatable

							// document.getElementById('con_address').value = '';
							// document.getElementById('con_district').value = '';
							// document.getElementById('con_pincode').value = '';
							// document.getElementById('con_contact_name').value = '';
							// document.getElementById('con_contact_number').value = '';
							// document.getElementById('con_lan_num').value = '';
						}
						sweetalert(msg);
					},
					error: function (data) {
						alert("Network Error");
					}
				});
			} else {
				alert("Upload Your DC, IR and Invoice File");
			}
		} else {
			sweetalert("form_alert");
		}

	}


	function invoice_delete(unique_id = "") {

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		confirm_delete('delete')
			.then((result) => {
				if (result.isConfirmed) {

					var data = {
						"unique_id": unique_id,
						"action": "delete"
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
								// init_datatable(table_id,form_name,action);
								sub_list_datatable("invoice_details_datatable");
								window.location.reload();

							}
							window.location.reload();

							sweetalert(msg, url);
						}
					});

				} else {
					// alert("cancel");
				}
			});
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
									window.location.reload();

								}
								window.location.reload();
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
		var invoice_date_1 = document.getElementById('invoice_date_1').value;
		var serial_no = document.getElementById('serial_no').value;
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
		data.append("invoice_date", invoice_date_1);
		data.append("serial_no", serial_no);
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
					sweetalert(msg);
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
					$image_view_3 .= '<a href="javascript:print_2(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
				} else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
					$image_view_3 .= '<a href="javascript:print_2(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
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
