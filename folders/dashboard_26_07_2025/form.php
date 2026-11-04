<style>
	body {

		background-color: #f3f3f9;
	}

	.card {
		border: 0px;
	}

	.c1 {
		background-color: #56b39c !important
	}

	.c1 i {
		color: #ffffff !important;
	}


	.p-3.border.border-dashed.border-start-0 {
		border-bottom: 0px !important;
	}

	.border {
		border-color: #cdcdcd !important;
	}

	.c2 {
		background: #299cde;
	}

	.t3 h2 {
		color: #0034d5 !important;
	}

	.c4 {
		background: #f06548;
	}

	.c5 {
		background: #9155fd;
	}

	.c6 {
		background: #ffb400;
	}

	.c7 {
		background: #ff6692;
	}

	.p-colo.info3 {
		color: #0034d5;
	}

	.c8 {
		background: #d79d13;
	}

	.t4 h2 {
		color: #4CAF50;
	}

	.p-colo.info4 {
		color: #027a60;
	}

	.t5 h2 {
		color: #a13610 !important;
	}

	.p-colo.info5 {
		color: #a13610;
	}

	.c9 {
		background: #635bff;
	}

	.c10 {
		background: #ff6692;
	}

	.c11 {
		background: #8a8d93;
	}

	.c12 {
		background: #8BC34A;
	}

	.c13 {
		background: #a1362d;
	}



	.np-ar {
		padding-left: 11px;
	}


	.avatar-sm2 {
		height: 35px;
		width: 35px;
	}

	.border h5 span.color-black {
		font-size: 19px;
	}

	.title-one h2 {
		border-bottom: 1px dashed #ccc;
		padding-bottom: 12px;
		color: #027a60;
		font-size: 21px !important;
		font-weight: 600;
	}

	.color-black {
		font-size: 18px;
		font-weight: 500;
		color: #000;
	}

	.p-colo {
		color: #0ab39c;
		font-weight: 600;
		font-size: 14px;
	}

	.title-one.t1 h2 {
		color: #299cdb;
	}

	.mn-op {
		padding: 15px;
	}

	.p-colo.info1 {
		color: #299cde;
	}

	.bg-grey {
		background: #e7e7e7;
	}

	.bg-grey .border {
		border-color: #c9c9c9 !important;
	}

	.t2 h2 {
		color: #cb8306;
	}

	.info2 {
		color: #dd8c00;
		/* font-weight: 600; */
	}

	.t6 h2 {
		color: #673AB7;
	}

	.p-colo.info6 {
		color: #673AB7;
	}

	.hole-div {
		margin-top: 24px;
	}

	table.new-table td,
	th {
		padding: 10px !important;
	}

	.table>:not(caption)>*>* {
		padding: 5px 10px !important;
		font-size: 14px !important;

	}

	table.new-table th,
	td {
		font-size: 14px !important;
	}

	table.new-table th {
		color: #000;
		background: #f3f6f9;
	}

	table.new-table tr:nth-child(even) {
		background-color: #f3f6f9 !important;
	}

	h6.side-hed {
		color: #92358E;
		font-size: 15px !important;
	}

	h4.taab-tile {
		color: #000000;
		margin-bottom: 10px !important;
	}

	.nav-success.nav-tabs-custom .nav-link.active {
		color: #ffffff;
		background-color: #92358E;
	}

	td {
		font-weight: 400;
		font-size: 14px !important;
	}

	table {
		border-collapse: collapse;
	}

	? table.new-table tr:nth-child(odd) {
		background-color: #ffffff;
		/* White for odd rows */
	}

	table.new-table {
		width: 100%;
		border-collapse: collapse;
	}

	table.new-table tr {
		border-bottom: 1px solid #cccccc61;
	}

	.card-header.align-items-center.d-flex.mb-0 {
		border-bottom: 1px solid #e9ebec;
	}

	h4.card-title.mb-0.flex-grow-1 {
		color: #506018;
		font-weight: 600;
	}

	.page-content {
		padding-top: 50px;
	}

	.table>thead {

		background: #fff;
		color: #506018;
	}

	table.com-tex tr td span {
		font-size: 15px;
	}

	.bg_stl1 {
		background: #eeece0;
		color: #506018;
	}

	.bg_stl2 {
		background: #ddd9c0;
	}
</style>

<?php
// Declare global variables
$acc_year_select = [];
$default_selected_year = "";

// Function to generate academic years and store in globals
function generateAcademicYearsGlobal($range = 2)
{
	global $acc_year_select, $default_selected_year;

	$currentYear = date('Y');
	$currentMonth = date('n');

	$startYear = ($currentMonth >= 6) ? $currentYear : $currentYear - 1;

	$acc_year_select = [];

	// Add "All" option
	$acc_year_select[""] = [
		"unique_id" => "",
		"value" => "All",
	];

	for ($i = -$range; $i <= $range; $i++) {
		$fromYear = $startYear + $i;
		$toYear = $fromYear + 1;
		$yearString = "$fromYear-$toYear";

		$acc_year_select[$yearString] = [
			"unique_id" => $yearString,
			"value" => $yearString,
		];
	}

	$default_selected_year = ($startYear) . "-" . ($startYear + 1);

	return [
		'acc_year_select' => $acc_year_select,
		'default_selected_year' => $default_selected_year
	];
}

// Call the function once to populate globals
generateAcademicYearsGlobal();
$acc_year_selects = select_option($acc_year_select, '', $default_selected_year);

$vendor_name = engineer_type();
// print_r($vendor_name);die();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- start page title -->
<!-- <div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0">Dashboard</h4>

			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>

		</div>
	</div>
</div> -->

<div class="hole-div">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<!-- <h4 class="card-title mb-0 flex-grow-1">Upcoming Activities</h4> -->

					<div class="col-md-9">
						<h4 class="card-title mb-0 flex-grow-1">Dashboard</h4>
					</div>
					<div class="col-md-2">
						<select id="acc_year" name="acc_year"
							class="form-control border-1 minimal-border dash-filter-picker">
							<?php echo $acc_year_selects ?>
						</select>
					</div>
					<div class="col-md-1" style="margin: 0 0 0 10px">
						<button type="button" id="submit" name="submit" class="btn btn-success ms-auto nexttab nexttab"
							style="margin-left:10px" data-nexttab="pills-info-desc-tab" onclick="mydemo()">
							Go </button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row ">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Upcoming Activities</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>
									<th scope="col" style="width: 20%;text-align: center;">Percentage</th>
									<th scope="col" style="width: 20%;text-align: center;">Quantity</th>
									<th scope="col" style="width: 20%;text-align: center;">View</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Total Purchase Order</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_count"></span>
									</td>


									<td style="text-align: right;"><span class="badge  text-danger p-2"
											id="invoice_value">0</span>
									</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_qty"></span>
									</td>
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='http://192.168.0.31/otm_beta/folders/dashboard/po_popup.php?acc_year=' + document.getElementById('acc_year').value">
											<span class="badge  text-success p-2" id="po_count"></span><i
												class="fas fa-eye"></i>
										</a>
									</td>
									
								</tr>
								<tr>
									<td>AMC</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="amc_count">0</span></td>
									<td style="text-align: right;"><span class="badge  text-danger p-2"
											id="amc_value">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="amc_percentage">0</span>
									</td>
									<td style="text-align: center;">-</td>
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='http://192.168.0.31/otm_beta/folders/dashboard/amcpo_popup.php?acc_year=' + document.getElementById('acc_year').value">
											<span class="badge  text-success p-2" id="po_count"></span><i
												class="fas fa-eye"></i>
										</a>
									</td>
								</tr>

							</tbody><!-- end tbody -->
						</table><!-- end table -->
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card" style="padding-bottom: 35px;">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Purchase Stock Position</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">PO Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Quantity</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>
								</tr>
							</thead>

							<tbody>
								
								<tr>
									<td>Completed PO</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="com_pocount">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="com_qty">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="com_value">0</span>
									</td>
								</tr>
								<tr>
									<td>Partial Complete PO</td>
									<td style="text-align: center;" rowspan="2"><span class="badge  text-success p-2"
											id="par_pocount">0</span>
									</td>
									<td style="text-align: center;" ><span class="badge  text-danger p-2"
											id="par_qty">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="par_value">0</span>
									</td>
								</tr>
								<tr>
									<td>Balance Partial PO</td>
									
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="balpar_qty">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="balpar_value">0</span>
									</td>
								</tr>
								<tr>
									<td>Balance PO</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="bal_pocount">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="bal_qty">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="bal_value">0</span>
									</td>
								</tr>
								<tr>
									<td>Total</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="over_pocount">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="over_qty">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-info p-2"
											id="over_value">0</span>
									</td>
								</tr>


							</tbody><!-- end tbody -->
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>



		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Stores Team</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<td scope="col" style="width: 30%;text-align: center;"><b>Quantity</b></td>
									<td scope="col" style="width: 30%;text-align: center;"><b>PO Count</b></td>
									<td scope="col" style="width: 20%;text-align: center;"><b>Invoice Count</b></td>
									<td scope="col" style="width: 20%;text-align: center;"><b>Value</b></td>


								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Consignee Assign Quantity</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="inv_assign_po_count"></span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_assign.php"
											target="_blank"><span class="badge  text-success p-2"
												id="inv_assign_po_count"></span></a></td> -->
									<td style="text-align: center;">-</span>

									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="assign_value">0</span>
									</td>

								</tr>
								<tr>
									<td>Consignee Assign Partial Quantity</td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_partial.php"
											target="_blank"><span class="badge  text-success p-2"
												id="inv_partial_assign_po_count">0</span></a></td> -->
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="inv_partial_assign_po_count">0</span></td>
									<td style="text-align: center;">-</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="partial_assign_value">0</span></td>
								</tr>
								<tr>
									<td colspan="4"><b>Invoice/DC</b></td>
								</tr>
								<tr>
									<td>Invoice Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="inv_po_count">0</span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_po_pending.php"
											target="_blank"><span class="badge  text-success p-2"
												id="inv_po_count">0</span></a></td> -->

									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="inv_count">0</span>
									</td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_pending.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="inv_count">0</span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="inv_value">0</span>
									</td>

								</tr>
								<tr>
									<td>Invoice Completed</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_com_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="inv_com_count">0</span>
									</td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_com.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="inv_com_count">0</span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="inv_com_value">0</span></td>

								</tr>
								<tr>
									<td colspan="4"><b>Delivery</b></td>
								</tr>
								<tr>
									<td>Delivery Status - Dispatch Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="del_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="del_invoice_count">0</span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/dispatch_pending.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="del_invoice_count">0</span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="del_invoice_value">0</span></td>

								</tr>
								<tr>
									<td>Delivery Status - Material In Transit</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="del_in_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="del_in_invoice_count">0</span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/dispatch_transit.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="del_in_invoice_count">0</span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="del_in_invoice_value">0</span></td>

								</tr>


							</tbody><!-- end tbody -->
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card" style="padding-bottom: 13px;">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Operation Team</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;" rowspan="2">Team </th>
									<th scope="col" style="width: 30%;text-align: center;" colspan="3">Count</th>
									<th scope="col" style="width: 30%;text-align: center;" rowspan="2">Value</th>
								</tr>
								<tr class="bg_stl2">
									<th scope="col" style="width: 15%;text-align: center;">PO</th>
									<th scope="col" style="width: 15%;text-align: center;">INV</th>
									<th scope="col" style="width: 15%;text-align: center;">DC</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Document Verification Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="elcot_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="elcot_invoice_count">0</span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/elcot_pending.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="elcot_invoice_count">0</span></a></td> -->
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="elcot_dc_count">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="elcot_invoice_value">0</span></td>

								</tr>
								<tr>
									<td>Signed Document Verfication Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_count_13">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="invoice_count_13">0</span></td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="dc_count_13">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="invoice_value_13">0</span></td>

								</tr>
								<tr>
									<td>BG Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_count_14">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="invoice_count_14">0</span></td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="dc_count_14">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="invoice_value_14">0</span></td>

								</tr>
								<tr>
									<td>Bill Generation Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_count_15">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="invoice_count_15">0</span></td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="dc_count_15">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="invoice_value_15">0</span></td>

								</tr>
								<tr>
									<td>Bill Submission Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="po_count_16">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="invoice_count_16">0</span></td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="dc_count_16">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="invoice_value_16">0</span></td>

								</tr>


							</tbody><!-- end tbody -->
						</table><!-- end table -->
						<br>

					</div>
				</div>
			</div>
		</div>




		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Service Team</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">PO Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Invoice Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>

								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Installation Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="ins_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="ins_invoice_count"></span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/install_pending.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="ins_invoice_count"></span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="ins_invoice_value">0</span></td>

								</tr>
								<tr>
									<td>Document Collection Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="doc_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="doc_invoice_count">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="doc_invoice_value">0</span></td>

								</tr>
								<tr>
									<td>Document With Engineer</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="eng_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="eng_invoice_count">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="eng_invoice_value">0</span></td>

								</tr>
								<tr>
									<td>SNR</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="snr_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="install_count">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="snr_invoice_value">0</span></td>

								</tr>


							</tbody><!-- end tbody -->
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Payment</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">PO Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Invoice Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>

								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Bill Submitted Payment Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2">0</span></td>

								</tr>
								<tr>
									<td>Payment Received</td>
									<td style="text-align: center;"><span class="badge  text-success p-2">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2">0</span></td>

								</tr>
								<tr>
									<td>SD Claim Pending</td>
									<td style="text-align: center;"><span class="badge  text-success p-2">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2">0</span></td>

								</tr>
								<tr>
									<td>LD Value</td>
									<td style="text-align: center;"><span class="badge  text-success p-2">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2">0</span></td>
									<td style="text-align: right;"><span class="badge  text-success p-2">0</span></td>

								</tr>



							</tbody><!-- end tbody -->
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Vendor Payment</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex"
							id="vendor_payment_datatable">
							<thead>
								<tr class="bg_stl1">
									<th rowspan="2" style="vertical-align: middle;text-align: center;">Vendor Name</th>
									<th colspan="2" style="text-align: center;">Assign</th>
									<th colspan="2" style="text-align: center;">Issue</th>
									<th colspan="2" style="text-align: center;">Balance</th>
								</tr>
								<tr class="bg_stl2">
									<th style="text-align: center;">DC Count</th>
									<th style="text-align: center;">Value</th>
									<th style="text-align: center;">DC Count</th>
									<th style="text-align: center;">Value</th>
									<th style="text-align: center;">DC Count</th>
									<th style="text-align: center;">Value</th>
								</tr>
							</thead>

							<tbody>
							</tbody>
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Account Team</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">PO Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Invoice Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>

								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Document Verification Pending - Accounts</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="doc_ac_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="doc_ac_invoice_count"></span></td>
									<!-- <td><a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/acc_pending.php"
											target="_blank"><span class="badge  text-danger p-2"
												id="doc_ac_invoice_count"></span></a></td> -->
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="doc_ac_invoice_value">0</span></td>

								</tr>


							</tbody><!-- end tbody -->
						</table><!-- end table -->


					</div>
				</div>
			</div>
		</div>



	</div>
</div>






<script>
	$(document).ready(function () {
		mydemo();

	});
	function mydemo() {
		get_amc_details();
		// formatCurrency();
		get_po_details();
		get_stock_details();
		get_balstock_details();
		get_overstock_details();
		get_balpartialstock_details();
		get_partialstock_details();
		invoice_assign_qty_details();
		invoice_partial_assign_qty_details();
		get_inv_pending_details();
		get_inv_com_details();
		get_deleivery_pending();
		get_transit_pending();
		get_ac_pending();
		install_pending_details();
		doc_pending_details();
		doc_eng_pending_details();
		snr_details();
		elcot_pending_details();
		sign_doc_details();
		bg_pending_details();
		entry_pending_details();
		get_vendor_payment_details();
		bill_pending_details();
		// bill_payment_pending_details();
		// bill_payment_receive_details();
		// ld_details();
		// sd_claim_details();
	}

	$("#export").click(function () {
		//     ();
		// ("hi");
		window.location = "folders/dashboard/excel.php";
	});


	function get_po_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "task_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var po_qty = obj.po_qty ?? 0;


				$('#po_count').html(po_count);
				$('#invoice_value').html(invoice_value);
				$('#po_qty').html(po_qty);
			}


		});
	}



	function get_amc_details() {

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "amc_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var amc_percentae = obj.amc_percentae ?? 0;
				var value = obj.value ?? 0;
				var amc_count = obj.amc_count ?? 0;
				$('#amc_percentage').html(amc_percentae + '%');
				$('#amc_value').html(value);
				$('#amc_count').html(amc_count);
			}

		});
	}




	function get_stock_details() {

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "stock_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var total_qty = obj.total_qty ?? 0;
				var value1 = obj.total_value ?? 0;
				var po_count = obj.po_count ?? 0;
				var value = obj.value ?? 0;
				$('#com_pocount').html(po_count);
				$('#com_qty').html(total_qty);
				$('#com_value').html(value1);

			}
		});
	}

	function get_partialstock_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "par_stock_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var total_qty = obj.total_qty ?? 0;
				var value1 = obj.total_value ?? 0;
				var po_count = obj.po_count ?? 0;
				var value = obj.value ?? 0;
				$('#par_pocount').html(po_count);
				$('#par_qty').html(total_qty);
				$('#par_value').html(value1);

			}
		});
	}

		function get_balpartialstock_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "balpar_stock_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var total_qty = obj.total_qty ?? 0;
				var value1 = obj.total_value ?? 0;
				var value = obj.value ?? 0;
				$('#balpar_qty').html(total_qty);
				$('#balpar_value').html(value1);

			}
		});
	}

function get_balstock_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "bal_stock_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var total_qty = obj.total_qty ?? 0;
				var value1 = obj.total_value ?? 0;
				var po_count = obj.po_count ?? 0;
				var value = obj.value ?? 0;
				$('#bal_pocount').html(po_count);
				$('#bal_qty').html(total_qty);
				$('#bal_value').html(value1);

			}
		});
	}

function get_overstock_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "over_stock_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var total_qty = obj.total_qty ?? 0;
				var value1 = obj.total_value ?? 0;
				var po_count = obj.po_count ?? 0;
				var value = obj.value ?? 0;
				$('#over_pocount').html(po_count);
				$('#over_qty').html(total_qty);
				$('#over_value').html(value1);

			}
		});
	}






	function invoice_assign_qty_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "assign_qty",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var stock_value = obj.stock_value ?? 0;
				$('#inv_assign_po_count').html(po_count);
				$('#assign_value').html(stock_value);
			}
		});
	}


	function invoice_partial_assign_qty_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "partial_assign_qty",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var stock_value = obj.stock_value ?? 0;
				$('#inv_partial_assign_po_count').html(po_count);
				$('#partial_assign_value').html(stock_value);
			}
		});
	}


	function get_inv_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "inv_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#inv_po_count').html(po_count);
				$('#inv_count').html(invoice_count);
				$('#inv_value').html(invoice_value);
			}
		});
	}

	function get_inv_com_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "inv_complete",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#po_com_count').html(po_count);
				$('#inv_com_count').html(invoice_count);
				$('#inv_com_value').html(invoice_value);
			}
		});
	}

	function get_deleivery_pending() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "delivery_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				$('#del_po_count').html(po_count);
				$('#del_invoice_count').html(invoice_count);
				$('#del_invoice_value').html(invoice_value);
			}
		});
	}
	function get_transit_pending() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "delivery_transit",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				$('#del_in_po_count').html(po_count);
				$('#del_in_invoice_count').html(invoice_count);
				$('#del_in_invoice_value').html(invoice_value);
			}
		});
	}

	function
		get_ac_pending() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "ac_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#doc_ac_po_count').html(po_count);
				$('#doc_ac_invoice_count').html(invoice_count);
				$('#doc_ac_invoice_value').html(invoice_value);
			}
		});
	}



	function
		install_pending_details() {

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "install_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#ins_po_count').html(po_count);
				$('#ins_invoice_count').html(invoice_count);
				$('#ins_invoice_value').html(invoice_value);
			}
		});
	}

	function
		doc_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "document_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				$('#doc_po_count').html(po_count);
				$('#doc_invoice_count').html(invoice_count);
				$('#doc_invoice_value').html(invoice_value);
			}
		});
	}



	function doc_eng_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "document_eng_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				$('#eng_po_count').html(po_count);
				$('#eng_invoice_count').html(invoice_count);
				$('#eng_invoice_value').html(invoice_value);
			}
		});
	}

	function formatIndianCurrency(value) {
		let number = Math.round(Number(value));
		if (isNaN(number) || number === 0) return '-';
		return number.toLocaleString('en-IN');
	}

	function get_vendor_payment_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var acc_year = document.getElementById('acc_year').value;

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: {
				action: "vendor_payment_details",
				acc_year: acc_year
			},
			success: function (response) {
				if (typeof response === "string") {
					response = JSON.parse(response);
				}

				const data = response.data || [];
				const tableBody = $('#vendor_payment_datatable tbody');
				tableBody.empty(); // Clear previous rows
				if (data.length === 0) {
					// Show "No data available" row
					tableBody.append(`
			<tr>
				<td colspan="7" class="text-center text-muted">No data available</td>
			</tr>
		`);
					return;
				}
				data.forEach(row => {
					const name = row[0] || '-';
					const assign_count = row[1] || 0;
					const assign_value = formatIndianCurrency(row[2]);

					const issue_count = row[3] || 0;
					const issue_value = formatIndianCurrency(row[4]);

					const balance_count = assign_count - issue_count;
					const balance_value = parseFloat(row[2]) - parseFloat(row[4]);

					tableBody.append(`
										<tr>
											<td>${name}</td>

											<td style="text-align: center;"><span class="badge  text-success p-2">${assign_count || '-'}</span></td>
											<td style="text-align: right;"><span class="badge  text-success p-2">${assign_value || '-'}</span></td>

											<td style="text-align: center;"><span class="badge  text-danger p-2">${issue_count || '-'}</span></td>
											<td style="text-align: right;"><span class="badge  text-danger p-2">${issue_value || '-'}</span></td>

											<td style="text-align: center;"><span class="badge text-warning p-2">${balance_count === 0 ? '-' : balance_count}</span></td>
											<td style="text-align: right;"><span class="badge text-warning p-2">${balance_value === 0 ? '-' : formatIndianCurrency(balance_value)}</span></td>
										</tr>
									`);
				});
			}
		});
	}


	function snr_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "snr_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var install_count = obj.install_count ?? 0;
				$('#snr_po_count').html(po_count) ?? 0;
				$('#install_count').html(install_count) ?? 0;
				$('#snr_invoice_value').html(invoice_value) ?? 0;
			}
		});
		// });
	}


	function elcot_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "elcot_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				var dc_count = obj.dc_count ?? 0;
				$('#elcot_po_count').html(po_count);
				$('#elcot_invoice_count').html(invoice_count);
				$('#elcot_invoice_value').html(invoice_value);
				$('#elcot_dc_count').html(dc_count);
			}
		});
	}

	function sign_doc_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "sign_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				var sign_dc_count = obj.sign_dc_count ?? 0;
				$('#po_count_13').html(po_count);
				$('#invoice_count_13').html(invoice_count);
				$('#invoice_value_13').html(invoice_value);
				$('#dc_count_13').html(sign_dc_count);
			}
		});
	}


	function bg_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "bg_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				var dc_count = obj.dc_count ?? 0;

				$('#po_count_14').html(po_count);
				$('#invoice_count_14').html(invoice_count);
				$('#dc_count_14').html(dc_count);
				$('#invoice_value_14').html(invoice_value);
			}
		});
	}


	function entry_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "entry_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				var dc_count = obj.dc_count ?? 0;

				$('#po_count_15').html(po_count);
				$('#invoice_count_15').html(invoice_count);
				$('#dc_count_15').html(dc_count);
				$('#invoice_value_15').html(invoice_value);
			}
		});
	}

	function bill_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "bill_sub_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;
				var dc_count = obj.dc_count ?? 0;

				$('#po_count_16').html(po_count);
				$('#invoice_count_16').html(invoice_count);
				$('#dc_count_16').html(dc_count);
				$('#invoice_value_16').html(invoice_value);
			}
		});
	}

	function bill_payment_pending_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "payment_pending",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#po_count_17').html(po_count);
				$('#invoice_count_17').html(invoice_count);
				$('#invoice_value_17').html(invoice_value);
			}
		});
	}

	function bill_payment_receive_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "payment_receive",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var invoice_value = obj.invoice_value ?? 0;
				var invoice_count = obj.invoice_count ?? 0;

				$('#po_count_18').html(po_count);
				$('#invoice_count_18').html(invoice_count);
				$('#invoice_value_18').html(invoice_value);
			}
		});
	}


	function ld_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		(acc_year);
		var data = {
			"action": "ld_detail",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count;
				var ld_value = obj.ld_value;
				var total_invoice_count = obj.total_invoice_count;
				var invoice_count = obj.invoice_count;
				$('#po_count_19').html(po_count);
				$('#total_invoice_count_19').html(total_invoice_count);
				$('#invoice_count_19').html(invoice_count);
				$('#ld_value_19').html(ld_value);
			}
		});
	}




	function sd_claim_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		var data = {
			"action": "sd_claim",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				$('#po_count_20').html(po_count);
				$('#invoice_count_20').html(invoice_count);
				$('#invoice_value_20').html(invoice_value);
			}
		});
	}


</script>


<script>
	// Function to format currency
	function formatCurrency(amount) {
		// Assuming the amount is in dollars, you can customize this as per your currency
		var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'USD',
		});

		return formatter.format(amount);
	}
</script>
