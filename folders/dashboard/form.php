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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th, td { border:1px solid #ccc; padding:8px; }
    tfoot td { font-weight:bold; background:#f0f0f0; }
    .text-center { text-align:center; }
    .text-end { text-align:right; }
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

$acc_vertical = dash_account_vertical();

$acc_verticals= select_option($acc_vertical, 'All',$acc_vertical);

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
		<div class="card" style=" height: 250px; overflow-y: auto;  overflow-x: hidden;">
			<div class="card-header align-items-center d-flex mb-0">
				<h4 class="card-title mb-0 flex-grow-1">Purchase Order Upload</h4>
			</div>
			<!-- card-body open -->
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
						<thead>
							<tr class="bg_stl1">
								<th scope="col" style="width: 30%;text-align: center;">Team </th>
								<th scope="col" style="width: 30%;text-align: center;">Count</th>
								<th scope="col" style="width: 20%;text-align: center;">Value</th>
								<th scope="col" style="width: 20%;text-align: center;">Quantity</th>
								<!-- <th scope="col" style="width: 20%;text-align: center;">Percentage</th> -->
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
								<td style="text-align: center;"><span class="badge  text-success p-2"
										id="po_qty"></span>
								</td>
								<!-- <td style="text-align: center;">-</td> -->
								<td style="text-align: center;">

									<a href="#" target="_blank"
										onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/po_popup.php?acc_year=' + document.getElementById('acc_year').value">
										<span class="badge text-success p-2" id="po_count"></span>
										<i class="fas fa-eye"></i>
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
								<td style="text-align: center;">-</td>
								<!-- <td style="text-align: center;"><span class="badge  text-info p-2"
										id="amc_percentage">0</span> -->
								</td>
								<td style="text-align: center;">
									<a href="#" target="_blank"
										onclick="this.href='folders/dashboard/amcpo_popup.php?acc_year=' + document.getElementById('acc_year').value">
										<span class="badge text-success p-2" id="po_count"></span>
										<i class="fas fa-eye"></i>
									</a>
								</td>
							</tr>

						</tbody><!-- end tbody -->
					</table><!-- end table -->
				</div>
			</div>
			<!-- card-body close -->
		</div>
		<div class="card" style=" height: 250px; overflow-y: auto;  overflow-x: hidden;">
			<div class="card-header align-items-center d-flex mb-0">
				<h4 class="card-title mb-0 flex-grow-1">Purchase Order Pending</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
						<thead>
							<tr class="bg_stl1">
								<th scope="col" style="width: 30%;text-align: center;">Team </th>
								<th scope="col" style="width: 30%;text-align: center;">Count</th>
								<th scope="col" style="width: 20%;text-align: center;">Value</th>
								<th scope="col" style="width: 20%;text-align: center;">Quantity</th>
								<th scope="col" style="width: 20%;text-align: center;">View</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td> Po Not complete</td>
								<td style="text-align: center;"><span class="badge  text-success p-2"
										id="pen_po_count"></span>
								</td>
								<td style="text-align: right;"><span class="badge  text-danger p-2"
										id="pen_invoice_value">0</span>
								</td>
								<td style="text-align: center;"><span class="badge  text-success p-2"
										id="pen_po_qty"></span>
								</td>
								<td style="text-align: center;">

									<a href="#" target="_blank"
										onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/po_popup_pending.php?acc_year=' + document.getElementById('acc_year').value">
										<span class="badge text-success p-2"></span>
										<i class="fas fa-eye"></i>
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
		<div class="card" style=" height: 510px; overflow-y: auto;  overflow-x: hidden;">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">PO Consignee Assign</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 20%;text-align: center;">PO Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Stock Assign</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>
									<th scope="col" style="width: 10%;text-align: center;">View</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Completed</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="con_po_count">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="con_stk_ass_count">0</span></td>
									<td style="text-align: right;"><span class="badge  text-info p-2"
											id="con_po_value_1">0</span></td>
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/po_consignee_popup.php?status=1&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>

								<tr>
									<td>Partial</td>
									<td style="text-align: center;" rowspan="2"><span class="badge  text-success p-2"
											id="con_po_count_par">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="con_stk_ass_count_par">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-info p-2"
											id="con_po_value_2">0</span></td>
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/po_consignee_popup.php?status=2&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>

								<tr>
									<td>Stock Assign Balance</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="con_po_stk_bal">0</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-info p-2"
											id="con_po_value_4">0</span></td>
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/po_consignee_popup.php?status=3&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>

								<tr>
									<td>Consignee Not Assign</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="con_po_count_no_stock">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="con_po_stk_no_stock">-</span>
									</td>
									<td style="text-align: right;"><span class="badge  text-info p-2"
											id="con_po_value_3">0</span></td>
									<!-- <td style="text-align: center;">-</td> -->
									<!-- <td style="text-align:center;">
															</td> -->
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/po_consignee_popup.php?status=4&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>

								<tr>
									<td>Total</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="con_po_count_total">0</span></td>
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="con_stk_ass_count_total">0</span></td>
									<td style="text-align: center;">-</td>
									<!-- <td style="text-align: right;"><span class="badge  text-info p-2"
											id="con_po_value_total">0</span></td> -->
									<td>

									</td>
								</tr>

							</tbody><!-- end tbody -->
						</table><!-- end table -->
						<br>

					</div>
				</div>
			</div>

	</div>
</div>
<div class="row ">
	<div class="col-md-6"><div class="card" >
   
	<!-- style="height: 600px; overflow-y: auto;  overflow-x: hidden;" -->
<div class="card-body text-center" style=" height: 537px;
    overflow-y: auto;
    overflow-x: hidden;">
<h5 class="card-title mb-3">Sector-Wise Summary</h5>
<div class="row">
<div class="col-6" style="margin-left: 51%;">
<label>Account Vertical</label>
<select id="acc_vert" name="acc_vert" onchange="get_sector_wise()"
class="form-control border-1 minimal-border dash-filter-picker">
<?php echo $acc_verticals; ?>
</select>
</div>
</div>
<div class="table-responsive">
<table class="table table-bordered table-nowrap align-middle mb-0 com-tex" id="sector-summary">
							<thead>
								<tr class="bg_stl1">

<!-- <table class="table table-bordered table-striped align-middle" id="sector-summary">
<thead>
<tr> -->
<th  class="text-center">Sector</th>
<th  class="text-center">Count</th>
<th class="text-center">Value</th>
<!-- <th colspan="2" class="text-center">Total</th> -->
<th  class="text-center">View</th>
</tr>

</thead>
<tbody>
</tbody>

<tfoot>

</tfoot>
</table>
</div>
</div>
<!-- </div> -->
</div>

	</div>
	<div class="col-md-6">
		<div class="card"  style="height: 200px; overflow-y: auto;  overflow-x: hidden;">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Railways</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">Count</th>
									<th scope="col" style="width: 20%;text-align: center;">Value</th>
									<th scope="col" style="width: 20%;text-align: center;">Quantity</th>
									<th scope="col" style="width: 20%;text-align: center;">View</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td> Po Count</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_count">0</span>
									</td>


									<td style="text-align: right;"><span class="badge  text-danger p-2"
											id="railways_invoice_value">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_qty"></span>
									</td>
									<td style="text-align: center;">

										<a href="#" target="_blank"
											onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/railway_po_popup.php?acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>

									</td>

								</tr>
								
							</tbody><!-- end tbody -->
						</table><!-- end table -->
					</div>
				</div>
			</div>
<br>
	<div class="card mb-2"  style="height: 327px;
    overflow-y: auto;
    overflow-x: hidden;
    margin-top: -20px;">

				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">PO Wise Consignee Address Details</h4>
				</div>
				<?php
					$v_sts = 1;
					$ntv_sts = 0;

				?>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<th scope="col" style="width: 30%;text-align: center;">Team </th>
									<th scope="col" style="width: 30%;text-align: center;">Count</th>
									<!-- <th scope="col" style="width: 20%;text-align: center;">Total Address</th>
									<th scope="col" style="width: 20%;text-align: center;">Quantity</th> -->
									<th scope="col" style="width: 20%;text-align: center;">View</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td> PO Count</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="consignee_po_count">0</span>
									</td>


									<!-- <td style="text-align: right;"><span class="badge  text-danger p-2"
											id="railways_invoice_value">0</span>
									</td> -->
									<!-- <td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_qty"></span>
									</td> -->
									<td style="text-align: center;">

										<a href="#" target="_blank"
											onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/consignee_address_verification.php?acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>

									</td>

								</tr>
								<tr>
									<td> Total Consignee Address</td>
									
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="consignee_total_address">0</span>
									</td>


									<!-- <td style="text-align: right;"><span class="badge  text-danger p-2"
											id="railways_invoice_value">0</span>
									</td> -->
									<!-- <td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_qty"></span>
									</td> -->
									<td style="text-align: center;">

										<a href="#" target="_blank"
											onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/consignee_address_verification.php?acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>

									</td>

								</tr>
								<tr>
									<td> Verified Consignee Address</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="tot_verify_address">0</span>
									</td>


									<!-- <td style="text-align: right;"><span class="badge  text-danger p-2"
											id="railways_invoice_value">0</span>
									</td> -->
									<!-- <td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_qty"></span>
									</td> -->
									<td style="text-align: center;">

										<a href="#" target="_blank"
   onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/consignee_address_verification.php?acc_year=' + document.getElementById('acc_year').value + '&cons_verify_status=' + <?php echo $v_sts;?>">
   <span class="badge text-success p-2" id="po_count"></span>
   <i class="fas fa-eye"></i>
</a>


									</td>

								</tr>
								<tr>
									<td>Balance</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="tot_not_verify_address">0</span>
									</td>


									<!-- <td style="text-align: right;"><span class="badge  text-danger p-2"
											id="railways_invoice_value">0</span>
									</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="railway_po_qty"></span>
									</td> -->
									<td style="text-align: center;">

										<a href="#" target="_blank"
											onclick="this.href=window.location.origin + '/otm_beta/folders/dashboard/consignee_address_verification.php?acc_year=' + document.getElementById('acc_year').value+ '&cons_verify_status=' + <?php echo $ntv_sts;?>">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>

									</td>

								</tr>
								
							</tbody><!-- end tbody -->
						</table><!-- end table -->
					</div>
				</div>
			</div>

	</div>
	</div>
	
	
</div>
<div class="row ">
	<div class="col-md-6">
		<div class="card"  style="height: 400px; overflow-y: auto;  overflow-x: hidden;">
				<div class="card-header align-items-center d-flex mb-0">
					<h4 class="card-title mb-0 flex-grow-1">Stores Team</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-nowrap align-middle mb-0 com-tex">
							<thead>
								<tr class="bg_stl1">
									<td scope="col" style="width: 30%;text-align: center;"><b></b></td>
									<td scope="col" style="width: 30%;text-align: center;"><b>DC Count</b></td>
									<td scope="col" style="width: 20%;text-align: center;"><b>Quantity</b></td>
									<td scope="col" style="width: 20%;text-align: center;"><b>Value</b></td>
									<td scope="col" style="width: 20%;text-align: center;"><b>View</b></td>


								</tr>
							</thead>

							<tbody>
								<!-- <tr>
									<td>Consignee Assign Quantity</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="inv_assign_po_count"></span></td>
									<td style="text-align: center;">-</span>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="assign_value">0</span>
									</td>

								</tr>
								<tr>
									<td>Consignee Assign Partial Quantity</td>
									<td style="text-align: center;"><span class="badge  text-success p-2"
											id="inv_partial_assign_po_count">0</span></td>
									<td style="text-align: center;">-</td>
									<td style="text-align: right;"><span class="badge  text-success p-2"
											id="partial_assign_value">0</span></td>
								</tr> -->
								<tr>
									<td colspan="5"><b>Invoice/DC</b></td>
								</tr>
								<tr>
									<td>DC Pending</td>
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
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/stores_team_popup.php?status=1&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>

								</tr>
								<tr>
									<td>DC Completed</td>
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
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/stores_team_popup.php?status=2&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>
								<tr>
									<td colspan="5"><b>Delivery</b></td>
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
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/stores_team_delivery.php?status=1&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
										</a>
									</td>
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
									<td style="text-align: center;">
										<a href="#" target="_blank"
											onclick="this.href='folders/dashboard/stores_team_delivery.php?status=2&acc_year=' + document.getElementById('acc_year').value">
											<span class="badge text-success p-2" id="po_count"></span>
											<i class="fas fa-eye"></i>
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
		<div class="card" style="padding-bottom: 13px; height: 400px; overflow-y: auto;  overflow-x: hidden;">
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
									<td>Invoice Verify Pending</td>
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
</div>



<div class="row ">
	<div class="col-md-6">
		<div class="card"  style="height: 400px; overflow-y: auto;  overflow-x: hidden;">
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
									<th scope="col" style="width: 20%;text-align: center;">DC Count</th>
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
									<td style="text-align: center;"><span class="badge  text-danger p-2"
											id="ins_dc_count"></span></td>
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
		<div class="card"  style="height: 400px; overflow-y: auto;  overflow-x: hidden;">
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
</div>

<div class="row ">
	<div class="col-md-6">
		<div class="card"  style="height: 400px; overflow-y: auto;  overflow-x: hidden;">
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
		<div class="card"  style="height: 400px; overflow-y: auto;  overflow-x: hidden;">
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



<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
 <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script> -->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>


<script>
$(document).ready(function () {
    // Run once immediately
    mydemo();

    // Run every 5 seconds (5000 ms)
    setInterval(function () {
        mydemo();
    }, 50000);
});
function runProcedure() {
	// alert("procedure running successfully");
      fetch('folders/dashboard/run_proc.php')
        .then(() => console.log("Procedure called at " + new Date().toLocaleTimeString()));
    }

    // Run every 5 seconds
    //setInterval(runProcedure, 5000);
	function mydemo() {
		runProcedure();
		get_amc_details();
		get_po_pendetails();
		get_railway_po_details();
		// formatCurrency();
		get_po_details();
		get_stock_details();
		get_balstock_details();
		get_overstock_details();
		get_balpartialstock_details();
		get_partialstock_details();
		invoice_assign_qty_details();
		get_consignee_assign_count_complete();
		get_consignee_assign_count_partial();
		get_consignee_assign_count_no_stock();
		get_consignee_assign_count_total();
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
		get_sector_wise();
		get_consignee_address_count();
		
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
// 	function get_sector_wise() {
//   const acc_year = $('#acc_year').val();
//   const acc_sector = $('#acc_sector').val();
//   const acc_verticals = ['6806199e57fc644558', '680619aae08f045496'];

//   $.ajax({
//     type: 'POST',
//     url: 'folders/dashboard/sector_count.php',
//     dataType: 'json',
//     data: {
//       action: 'sector_wise_count',
//       acc_year,
//       acc_sector,
//       acc_verticals
//     },
//     success(response) {
//       if (response.error) {
//         alert(response.error);
//         return;
//       }

//       const rows = response.data || [];
//       const $tbody = $('#sector-summary tbody').empty();

//       let totalPoCount = 0;
//       let totalInvoiceValue = 0;
//       let totalPoQty = 0;

//       // Loop through each sector row
//       rows.forEach(item => {
//         const poCount = parseInt(item.po_count, 10) || 0;
//         const invoiceValue = parseFloat((item.invoice_value || "0").replace(/,/g, '')) || 0;
//         const poQty = parseInt(item.po_qty, 10) || 0;

//         totalPoCount += poCount;
//         totalInvoiceValue += invoiceValue;
//         totalPoQty += poQty;

//         $tbody.append(`
//           <tr>
//             <td>${item.sector_name || ''}</td>
//             <td class="text-center">${poCount}</td>
//             <td class="text-end">${invoiceValue.toLocaleString('en-IN')}</td>
//             <td class="text-center">${poQty}</td>
//           </tr>
//         `);
//       });

//       // Update horizontal totals in tfoot
//       const $tfoot = $('#sector-summary tfoot tr');
//       $tfoot.find('td.total-po-count').text(totalPoCount);
//       $tfoot.find('td.total-invoice-value').text(totalInvoiceValue.toLocaleString('en-IN'));
//       $tfoot.find('td.total-po-qty').text(totalPoQty);

//     },
//     error(xhr, status, err) {
//       console.error('AJAX error:', err);
//     }
//   });
// }


function loadSummary() {
  const year = $('#acc_year').val();
    const acc_sector = $('#acc_sector').val();
  const acc_verticals = ['6806199e57fc644558', '680619aae08f045496'];
  
  $.post('folders/dashboard/sector_count.php', { acc_year: year, acc_sector:acc_sector, acc_verticals:acc_verticals }, function(response) {
    const rows = response.data || [];
    let gEndCnt = 0, gEndVal = 0, gCyberCnt = 0, gCyberVal = 0, gTotCnt = 0, gTotVal = 0;
    const $tbody = $('#sector-summary tbody').empty();

    rows.forEach(item => {
      const ec = item.end_comp_count || 0;
      const ev = parseFloat((item.end_comp_value || '0').replace(/,/g,'')) || 0;
      const cc = item.cyber_sec_count || 0;
      const cv = parseFloat((item.cyber_sec_value || '0').replace(/,/g,'')) || 0;
      const tc = item.total_count || (ec + cc);
      const tv = parseFloat((item.total_value || '0').replace(/,/g,'')) || (ev + cv);

      gEndCnt += ec; gEndVal += ev;
      gCyberCnt += cc; gCyberVal += cv;
      gTotCnt += tc; gTotVal += tv;

      $tbody.append(`
        <tr>
          <td>${item.sector_name || '—'}</td>
          <td class="text-center">${ec}</td>
          <td class="text-end">${ev.toLocaleString('en-IN')}</td>
          <td class="text-center">${cc}</td>
          <td class="text-end">${cv.toLocaleString('en-IN')}</td>
          <td class="text-center">${tc}</td>
          <td class="text-end">${tv.toLocaleString('en-IN')}</td>
        </tr>
      `);
    });

    const $f = $('#sector-summary tfoot tr');
    $f.find('td.grand-end-count').text(gEndCnt);
    $f.find('td.grand-end-value').text(gEndVal.toLocaleString('en-IN'));
    $f.find('td.grand-cyber-count').text(gCyberCnt);
    $f.find('td.grand-cyber-value').text(gCyberVal.toLocaleString('en-IN'));
    $f.find('td.grand-total-count').text(gTotCnt);
    $f.find('td.grand-total-value').text(gTotVal.toLocaleString('en-IN'));
  }, 'json').fail(e => console.error(e));
}

// $('#loadSummary').click(loadSummary);
// $(document).ready(loadSummary);

	function get_sector_wise() {
      const acc_year = $('#acc_year').val();
    //   const acc_sector = $('#acc_sector').val();
	  
	  const acc_verticals = document.getElementById('acc_vert').value;
	//   alert(acc_verticals); 
	//    acc_sector,
    //   const acc_verticals = ['6806199e57fc644558', '680619aae08f045496'];

      $.ajax({
        type: 'POST',
        url: 'folders/dashboard/sector_count.php',
        dataType: 'json',
        data: {
          action: 'sector_wise_count',
          acc_year,
          acc_verticals
        },
//         success(response) {
//           if (response.error) {
//             alert(response.error);
//             return;
//           }

//           const rows = response.data || [];
//           const $tbody = $('#sector-summary tbody').empty();

//           let totalPoCount = 0;
//           let totalInvoiceValue = 0;
//           let totalPoQty = 0;

//           rows.forEach(item => {
//             const poCount = parseInt(item.po_count, 10) || 0;
//             const invoiceValue = parseFloat((item.invoice_value || "0").replace(/,/g, '')) || 0;
//             const poQty = parseInt(item.po_qty, 10) || 0;

//             totalPoCount += poCount;
//             totalInvoiceValue += invoiceValue;
//             totalPoQty += poQty;

//             $tbody.append(`
//               <tr>
//                 <td>${item.sector_name || ''}</td>
//                 <td class="text-center">${poCount}</td>
//                 <td class="text-end">${invoiceValue.toLocaleString('en-IN')}</td>
//                <td class="text-center">
//   <a href="${window.location.origin}/otm_beta/folders/dashboard/sectorsummarypopup.php?acc_year=${document.getElementById('acc_year').value}&acc_verticals=${acc_verticals}&sector_id=${item.unique_id}" target="_blank">
//     <span class="badge text-success p-2"></span>
//     <i class="fas fa-eye"></i>
//   </a>
// </td>

//               </tr>
//             `);
//           });

        
       
//         },
success(response) {
  if (response.error) {
    alert(response.error);
    return;
  }

  const rows = response.data || [];
  const $tbody = $('#sector-summary tbody').empty();
  const $tfoot = $('#sector-summary tfoot').empty();

  // Separate the total row
  const totalRow = rows.find(r => r.sector_name === 'Total (All Sectors)');
  const normalRows = rows.filter(r => r.sector_name !== 'Total (All Sectors)');

  normalRows.forEach(item => {
    const poCount = parseInt(item.po_count, 10) || 0;
    const invoiceValue = parseFloat((item.invoice_value || "0").replace(/,/g, '')) || 0;

    $tbody.append(`
      <tr>
        <td style="text-align: left;">${item.sector_name || ''}</td>
        <td class="text-center"><span class="badge  text-success">${poCount}</span></td>
        <td class="text-end"><span class="badge  text-danger">${invoiceValue.toLocaleString('en-IN')}</span></td>
        <td class="text-center">
          <a href="${window.location.origin}/otm_beta/folders/dashboard/sectorsummarypopup.php?acc_year=${document.getElementById('acc_year').value}&acc_verticals=${acc_verticals}&sector_id=${item.unique_id}" target="_blank">
            <span class="badge text-success p-2"></span>
            <i class="fas fa-eye"></i>
          </a>
        </td>
      </tr>
    `);
  });

  // Append total row to footer
  if (totalRow) {
    const totalCount = parseInt(totalRow.po_count, 10) || 0;
    const totalValue = parseFloat((totalRow.invoice_value || "0").replace(/,/g, '')) || 0;

    $tfoot.append(`
      <tr class="fw-bold">
        <td style="text-align: left;">Total (All Sectors)</td>
        <td class="text-center"><span class="badge  text-success">${totalCount}</span></td>
        <td class="text-end"><span class="badge  text-danger">${totalValue.toLocaleString('en-IN')}</span></td>
       <td class="text-center">
          <a href="${window.location.origin}/otm_beta/folders/dashboard/sectorsummarypopup.php?acc_year=${document.getElementById('acc_year').value}&acc_verticals=${acc_verticals}" target="_blank">
            <span class="badge text-success p-2"></span>
            <i class="fas fa-eye"></i>
          </a>
        </td>
      </tr>
    `);
  }
},
        error(xhr, status, err) {
          console.error('AJAX error:', err);
        }
      });
    }
	// <td class="text-center">${poQty}</td>
	//    $tfoot.find('td.total-po-qty').text(totalPoQty);
// function get_sector_wise_16_08_2025() {
// 	// alert("hii");
//   const acc_year   = $('#acc_year').val();
//   const acc_sector = $('#acc_sector').val();
//   const acc_verticals = ['6806199e57fc644558', '680619aae08f045496'];

//   $.ajax({
//     type: 'POST',
//     url: 'folders/dashboard/sector_count.php',
//     dataType: 'json',
//     data: {
//       action:         'sector_wise_count',
//       acc_year:       acc_year,
//       acc_sector:     acc_sector,
//       acc_verticals:  acc_verticals
//     },
//     success(response) {
//       if (response.error) {
//         alert(response.error);
//         return;
//       }

//       const rows = response.data || [];
//       const $tbody = $('#sector-summary tbody').empty();

//       // Initialize totals
//       let totalPoCount = 0,
//           totalInvoiceValue = 0,
//           totalPoQty = 0;

//       rows.forEach(item => {
//         const poCount = parseInt(item.po_count, 10) || 0;
//         const invoiceValue = parseFloat(item.invoice_value.replace(/,/g, '')) || 0;
//         const poQty = parseInt(item.po_qty, 10) || 0;

//         totalPoCount     += poCount;
//         totalInvoiceValue += invoiceValue;
//         totalPoQty        += poQty;

//         $tbody.append(`
//           <tr>
//             <td>${item.sector_name}</td>
//             <td class="text-center">${poCount}</td>
//             <td class="text-end">${invoiceValue.toLocaleString('en-IN')}</td>
           
//           </tr>
//         `);
//       });

//       // Populate the footer totals
//       const $tfoot = $('#sector-summary tfoot tr');
//       $tfoot.find('td.total-po-count').text(totalPoCount);
//       $tfoot.find('td.total-invoice-value').text(totalInvoiceValue.toLocaleString('en-IN'));
//       $tfoot.find('td.total-po-qty').text(totalPoQty);
//     },
//     error(xhr, status, err) {
//       console.error('AJAX error:', err);
//     }
//   });
// }
//  <td class="text-center">${poQty}</td>
$(document).ready(function() {
  $('#load-button').on('click', get_sector_wise);
});
	function get_sector_wise_funs() {
  const acc_year    = $('#acc_year').val().trim();
  const acc_sector  = $('#acc_sector').val().trim(); // e.g., "BFSI"
  const acc_verticals = [
    '6806199e57fc644558',
    '680619aae08f045496'
  ];

  $.ajax({
    type: 'POST',
    url: 'folders/dashboard/sector_count.php',
    dataType: 'json',
    data: {
      action:          'sector_wise_count',
      acc_year:        acc_year,
      acc_sector:      acc_sector,
      acc_verticals:   acc_verticals
    },
    success(response) {
      if (response.error) {
        alert(response.error);
        return;
      }
      const $tbody = $('#sector-summary tbody').empty();
      response.data.forEach(item => {
        $tbody.append(`
          <tr>
            <td>${item.sector_name}</td>
            <td>${item.po_count}</td>
            <td>${item.invoice_value}</td>
           
          </tr>
        `);
      });
    },
    error(xhr, status, err) {
      console.error('AJAX error:', err);
    }
  });
}
//  <td>${item.po_qty}</td>

// $(function() {
//   $('#load-button').on('click', get_sector_wise);
// });
	function get_sector_wise_main1() {
//   alert("hi");
  const ajax_url = sessionStorage.getItem("folder_crud_link") || "sector_count.php";
  const acc_year = document.getElementById('acc_year').value || '';

  $.ajax({
    type: "POST",
    url: 'folders/dashboard/sector_count.php',
    dataType: "json",
    data: { action: "sector_wise_count", acc_year: acc_year },
    success(response) {
      console.log("AJAX response:", response);

      const rows = response.data || [];
      const $tbody = $('#sector-summary tbody');
      $tbody.empty();

      let totalEndCount = 0, totalEndValue = 0;
      let totalCyberCount = 0, totalCyberValue = 0;

      rows.forEach(item => {
        const endCount = item.end_count ?? 0;
        const endValue = Number((item.end_value ?? "0").replace(/,/g, '')) || 0;
        const cyberCount = item.cyber_count ?? 0;
        const cyberValue = Number((item.cyber_value ?? "0").replace(/,/g, '')) || 0;

        // Optionally fallback total values if missing
        const totalCount = item.total_count ?? (endCount + cyberCount);
        const totalValue = item.total_value
          ? Number(item.total_value.replace(/,/g, ''))
          : (endValue + cyberValue);

        totalEndCount += endCount; totalEndValue += endValue;
        totalCyberCount += cyberCount; totalCyberValue += cyberValue;

        const rowHtml = `
          <tr>
            <td class="text-start">${item.sector_name || ''}</td>
            <td class="text-center">${endCount}</td>
            <td class="text-end">${endValue.toLocaleString('en-IN')}</td>
            <td class="text-center">${cyberCount}</td>
            <td class="text-end">${cyberValue.toLocaleString('en-IN')}</td>
            <td class="text-center">${totalCount}</td>
            <td class="text-end">${totalValue.toLocaleString('en-IN')}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-primary"
                onclick="window.open(window.location.origin
                  + '/otm_beta/folders/dashboard/po_popup_pending.php?acc_year='
                  + encodeURIComponent('${acc_year}'), '_blank')">
                <i class="fas fa-eye"></i>
              </button>
            </td>
          </tr>`;
        $tbody.append(rowHtml);
      });

      // Update footer totals
      const $tfoot = $('#sector-summary tfoot tr');
      $tfoot.find('td:eq(1)').text(totalEndCount);
      $tfoot.find('td:eq(2)').text(totalEndValue.toLocaleString('en-IN'));
      $tfoot.find('td:eq(3)').text(totalCyberCount);
      $tfoot.find('td:eq(4)').text(totalCyberValue.toLocaleString('en-IN'));
      $tfoot.find('td:eq(5)').text(totalEndCount + totalCyberCount);
      $tfoot.find('td:eq(6)').text((totalEndValue + totalCyberValue).toLocaleString('en-IN'));
    },
    error(xhr, status, error) {
      console.error("Ajax error:", status, error);
    }
  });
}




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

				// alert(po_count);
				var invoice_value = obj.invoice_value ?? 0;
				var po_qty = obj.po_qty ?? 0;


				$('#po_count').html(po_count);
				$('#invoice_value').html(invoice_value);
				$('#po_qty').html(po_qty);
			}


		});
	}

	function get_railway_po_details() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "railway_task_details",
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


				$('#railway_po_count').html(po_count);
				$('#railway_invoice_value').html(invoice_value);
				$('#railway_po_qty').html(po_qty);
			}


		});
	}

	function get_consignee_address_count() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "get_consignee_address_cnt",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				// var invoice_value = obj.invoice_value ?? 0;
				var consignee_total_address = obj.consignee_total_address ?? 0;
				var tot_verify_address = obj.tot_verify_address ?? 0;
                var tot_not_verify_address = obj.tot_not_verify_address ?? 0;
				


				$('#consignee_po_count').html(po_count);
				$('#consignee_total_address').html(consignee_total_address);
				$('#tot_verify_address').html(tot_verify_address);
				$('#tot_not_verify_address').html(tot_not_verify_address);
			}


		});
	}


function get_po_pendetails() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "pen_task_details",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.pen_po_count ?? 0;
				var invoice_value = obj.pen_invoice_value ?? 0;
				var po_qty = obj.pen_po_qty ?? 0;


				$('#pen_po_count').html(po_count);
				$('#pen_invoice_value').html(invoice_value);
				$('#pen_po_qty').html(po_qty);
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

	function get_consignee_assign_count_complete() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "get_conginess_completed",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var po_assign_count = obj.po_assign_count ?? 0;
				var stk_assign_count = obj.stk_assign_count ?? 0;
				var total_value = obj.total_value ?? 0;

				$('#con_po_count').html(po_count);
				$('#con_po_ass_count').html(po_assign_count);
				$('#con_stk_ass_count').html(stk_assign_count);
				$('#con_po_value_1').html(total_value);
			}
		});
	}

	function get_consignee_assign_count_no_stock() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "get_conginess_no_stock",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var po_assign_count = obj.po_assign_count ?? 0;
				// var stk_assign_count = obj.stk_assign_count ?? 0;
				var total_value = obj.total_value ?? 0;

				$('#con_po_count_no_stock').html(po_count);
				$('#con_po_ass_no_stock').html(po_assign_count);
				$('#con_po_value_3').html(total_value);

				let com_qty = parseInt(document.getElementById("com_qty").textContent);
				let par_qty = parseInt(document.getElementById("par_qty").textContent);

				let stk_ass_count = parseInt(document.getElementById("con_stk_ass_count").textContent);
				let par_stk_ass_count = parseInt(document.getElementById("con_stk_ass_count_par").textContent);

				let con_not_ass = (com_qty + par_qty) - (stk_ass_count + par_stk_ass_count);

				$('#con_po_stk_no_stock').html(con_not_ass);
			}
		});
	}

	function get_consignee_assign_count_partial() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "get_conginess_partial",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var po_assign_count = obj.po_assign_count ?? 0;
				var stk_assign_count = obj.stk_assign_count ?? 0;
				var total_value = obj.total_value ?? 0;
				var bal_qty = obj.bal_qty ?? 0;
				var bal_val = obj.bal_val ?? 0;

				$('#con_po_count_par').html(po_count);
				$('#con_po_ass_count_par').html(po_assign_count);
				$('#con_stk_ass_count_par').html(stk_assign_count);
				$('#con_po_value_2').html(total_value);
				$('#con_po_stk_bal').html(bal_qty);
				$('#con_po_value_4').html(bal_val);
			}
		});
	}

	function get_consignee_assign_count_total() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;

		var data = {
			"action": "get_conginess_total",
			"acc_year": acc_year,
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {
				var obj = JSON.parse(data);
				var po_count = obj.po_count ?? 0;
				var po_assign_count = obj.po_assign_count ?? 0;
				// var stk_assign_count = obj.stk_assign_count ?? 0;
				var total_value = obj.total_value ?? 0;

				$('#con_po_count_total').html(po_count);
				$('#con_po_ass_count_total').html(po_assign_count);
				// $('#con_stk_ass_count_total').html(stk_assign_count);
				$('#con_po_value_total').html(total_value);

				let con_stk_ass_count = parseInt(document.getElementById("con_stk_ass_count").textContent);
				let con_stk_ass_count_par = parseInt(document.getElementById("con_stk_ass_count_par").textContent);
				let con_po_stk_no_stock = parseInt(document.getElementById("con_po_stk_no_stock").textContent);

				let con_stk_ass_count_total = con_stk_ass_count + con_stk_ass_count_par + con_po_stk_no_stock;

				$('#con_stk_ass_count_total').html(con_stk_ass_count_total);
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
				var dc_count = obj.dc_count ?? 0;

				$('#ins_po_count').html(po_count);
				$('#ins_invoice_count').html(invoice_count);
				$('#ins_dc_count').html(dc_count);
				$('#ins_invoice_value').html(invoice_value);
			}
		});
	}

	function doc_pending_details() {
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
