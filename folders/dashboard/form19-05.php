<style>
	.c1 {
		background-color: #56b39c !important
	}

	.c1 i {
		color: #ffffff !important;
	}

	.card {
		height: 140px;
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
</style>
<?php
// $acc_year_select =
// 	[
// 		// "" => [
// 		// 	"unique_id" => "",
// 		// 	"value" => "Select Option",
// 		// ],
// 		"2024-2025" => [
// 			"unique_id" => "2024-2025",
// 			"value" => "2024-2025",
// 		],
// 		"2025-2026" => [
// 			"unique_id" => "2025-2026",
// 			"value" => "2025-2026",
// 		],
// 		"2026-2027" => [
// 			"unique_id" => "2026-2027",
// 			"value" => "2026-2027",
// 		],
// 	];

// $acc_year_selects = select_option($acc_year_select);

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

	$default_selected_year = ($startYear + 1) . "-" . ($startYear + 2);

	return [
		'acc_year_select' => $acc_year_select,
		'default_selected_year' => $default_selected_year
	];
}

// Call the function once to populate globals
generateAcademicYearsGlobal();

$acc_year_selects = select_option($acc_year_select, '', $default_selected_year);

?>


<!-- start page title -->
<div class="row">
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
</div>
<!-- end page title -->

<div class="row">
	<div class="col-md-8">
		<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one">
			<h2 class="card-title mb-0 flex-grow-1">Operation Team Purchase </h2>
		</div>
	</div>
	<div class="col-md-2 align-self-center">
		<div class="flex-grow-1">
			<div class="input">

				<select id="acc_year" name="acc_year"
					class="form-control border-0 minimal-border dash-filter-picker shadow">
					<?php echo $acc_year_selects ?>
				</select>

			</div>
		</div>
	</div>
	<div class="col-md-2  align-self-center">
		<button type="button" id="submit" name="submit" class="btn btn-success  ms-auto nexttab nexttab"
			data-nexttab="pills-info-desc-tab" onclick="mydemo()">
			Go </button>
	</div>

</div>
<div class="row mt-3">

	<div class="col-md-4">
		<div class="card mb-2">

			<div class=" border-0 align-items-center d-flex mn-op">

				<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Total Purchase Order</h4>
				<div>

				</div>
			</div>
			<div class="row g-0 text-center">
				<div class="col-6 col-sm-6">
					<div class="p-3 border border-dashed border-start-0">
						<!-- <h5 class="mb-1"><a href="http://122.165.127.123/aed_elcot_beta/folders/dashboard/po_order.php" -->
						<h5 class="mb-1">
							<!-- <span class="color-black" id="po_count"></span> -->
							<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/po_order.php"
								target="_blank"><span class="color-black" id="po_count"></span></a>
						</h5>
						<p class=" mb-0 p-colo">Count</p>
					</div>
				</div>
				<!--end col-->
				<div class="col-6 col-sm-6">
					<div class="p-3 border border-dashed border-start-0 border-end-0">
						<h5 class="mb-1"><span class="color-black" id="invoice_value"></span>
						</h5>
						<p class=" mb-0 p-colo">Value</p>
					</div>
				</div>
				<!--end col-->

				<!--end col-->
			</div>
			<div id="get_po_details"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-2">

			<div class=" border-0 align-items-center d-flex mn-op">

				<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">AMC</h4>
				<div>

				</div>
			</div>
			<div class="row g-0 text-center">
				<div class="col-6 col-sm-4">
					<div class="p-3 border border-dashed border-start-0">
						<h5 class="mb-1"><span class="color-black" id="po_count_amc"></span>

						</h5>
						<p class=" mb-0 p-colo">PO Count</p>
					</div>
				</div>
				<div class="col-6 col-sm-4">
					<div class="p-3 border border-dashed border-start-0">
						<h5 class="mb-1"><span class="color-black" id="amc_percentage"></span>

						</h5>
						<p class=" mb-0 p-colo">Percentage</p>
					</div>
				</div>
				<!--end col-->
				<div class="col-6 col-sm-4">
					<div class="p-3 border border-dashed border-start-0 border-end-0">
						<h5 class="mb-1"><span class="color-black" id="amc_value"></span>



						</h5>
						<p class=" mb-0 p-colo">Value</p>
					</div>
				</div>
				<!--end col-->

				<!--end col-->
			</div>
			<div id="get_po_details"></div>
		</div>
	</div>
</div>

<div class="hed-bgs">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t1">
		<h2 class="card-title mb-0 flex-grow-1">Purchase Team</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-7">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Material Unavailable</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="po_cnt"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/stock.php"
									target="_blank"><span class="color-black" id="po_cnt"></span></a>
							</h5>
							<p class=" mb-0 p-colo info1">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="value"></span>

							</h5>
							<p class=" mb-0 p-colo info1">Value</p>
						</div>
					</div>
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="po_count1"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/partial_stock.php"
									target="_blank"><span class="color-black" id="po_count1"></span>
								</a>
							</h5>
							<!-- <span class="color-black" id="po_count1"></span> -->
							<p class=" mb-0 p-colo info1">Partial Po count</p>
						</div>
					</div>
					<!--end col-->
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="value1"></span>

							</h5>
							<p class=" mb-0 p-colo info1">Partial Value</p>
						</div>
					</div>
					<!--end col-->


					<!--end col-->
				</div>
				<div id="get_stock_details"></div>
			</div>
		</div>
	</div>
</div>
<div class="">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t3">
		<h2 class="card-title mb-0 flex-grow-1">Stores Team</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Invoice Assign Quantity</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-6">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="inv_assign_po_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_assign.php"
									target="_blank"><span class="color-black" id="inv_assign_po_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-6">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="assign_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="invoice_assign_qty_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Invoice Assign Quantity Partial Pending
					</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-6">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="inv_partial_assign_po_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_partial.php"
										target="_blank"><span class="color-black" id="inv_partial_assign_po_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-6">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="partial_assign_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="invoice_partial_assign_qty_details"></div>
			</div>
		</div>



		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Invoice Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="inv_po_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_po_pending.php"
										target="_blank"><span class="color-black" id="inv_po_count"></span></a>
							</h5>
							<!-- <span class="color-black" id="inv_po_count"></span> -->
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="inv_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_pending.php"
										target="_blank"><span class="color-black" id="inv_count"></span></a>
							</h5>
							<!-- <span class="color-black" id="inv_count"></span> -->
							<p class=" mb-0 p-colo info3">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="inv_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="get_inv_pending_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Invoice Completed</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_com_count"></span>

							</h5>
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="inv_com_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/inv_com.php"
										target="_blank"><span class="color-black" id="inv_com_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info3">Invoice Count</p>
							<!-- <span class="color-black" id="inv_com_count"></span> -->
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="inv_com_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="get_inv_com_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">


					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Delivery Status - Dispatch Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="del_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="del_invoice_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/dispatch_pending.php"
										target="_blank"><span class="color-black" id="del_invoice_count"></span></a>
							</h5>
							<!-- <span class="color-black" id="del_invoice_count"></span> -->
							<p class=" mb-0 p-colo info3">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="del_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="get_deleivery_pending"> </div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Delivery Status - Material In Transit</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="del_in_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info3">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="del_in_invoice_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/dispatch_transit.php"
										target="_blank"><span class="color-black" id="del_in_invoice_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info3">Invoice Count</p>
							<!-- <span class="color-black" id="del_in_invoice_count"></span> -->
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="del_in_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info3">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="get_transit_pending"> </div>
			</div>
		</div>
	</div>
</div>


<div class="hed-bgs">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t2">
		<h2 class="card-title mb-0 flex-grow-1">Account Team</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Document Verification Pending - Accounts
					</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="doc_ac_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info2">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="doc_ac_invoice_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/acc_pending.php"
								target="_blank"><span class="color-black" id="doc_ac_invoice_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info2">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="doc_ac_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info2">Value</p>
						</div>
					</div>




					<!--end col-->
				</div>
			</div>
		</div>
	</div>
</div>


<div class="">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t4">
		<h2 class="card-title mb-0 flex-grow-1">Service Team</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Installation Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="ins_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="ins_invoice_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/install_pending.php"
									target="_blank"><span class="color-black" id="ins_invoice_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info4">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="ins_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="install_pending_details"></div>
			</div>
		</div>




		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Document Collection Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="doc_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="doc_invoice_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="doc_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="doc_pending_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Document With Engineer</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="eng_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="eng_invoice_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="eng_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">SNR</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="snr_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="install_count"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="snr_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info4">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="snr_details"></div>
			</div>
		</div>


	</div>
</div>



<div class="">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t5">
		<h2 class="card-title mb-0 flex-grow-1">Operation Team</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Document Verification Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="elcot_po_count"></span>

							</h5>
							<p class=" mb-0 p-colo info5">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1">
								<!-- <span class="color-black" id="elcot_invoice_count"></span> -->
								<a href="http://122.165.127.123:35267/otm_beta/folders/dashboard/elcot_pending.php"
										target="_blank"><span class="color-black" id="elcot_invoice_count"></span></a>
							</h5>
							<p class=" mb-0 p-colo info5">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="elcot_invoice_value"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Value</p>
						</div>
					</div>

					<!--end col-->
				</div>
				<div id="elcot_pending_details"></div>
			</div>
		</div>




		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Signed Document Verfication Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_13"></span>

							</h5>
							<p class=" mb-0 p-colo info5">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_13"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_13"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Value</p>
						</div>
					</div>


					<div id="sign_doc_details"></div>
					<!--end col-->
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">BG Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_14"></span>

							</h5>
							<p class=" mb-0 p-colo info5">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_14"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_14"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="bg_pending_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Entry Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_15"></span>

							</h5>
							<p class=" mb-0 p-colo info5">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_15"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_15"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="entry_pending_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 bg-grey">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Bill Submission Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_16"></span>

							</h5>
							<p class=" mb-0 p-colo info5">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_16"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_16"></span>

							</h5>
							<p class=" mb-0 p-colo info5">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="bill_pending_details"></div>
			</div>
		</div>
	</div>
</div>



<div class="">
	<div class="card-header border-0 align-items-center d-flex mb-3 mt-4 title-one t6">
		<h2 class="card-title mb-0 flex-grow-1">Payment</h2>
	</div>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Bill Submitted Payment Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_17"></span>

							</h5>
							<p class=" mb-0 p-colo info6">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_17"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_17"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="bill_payment_pending_details"></div>
			</div>
		</div>




		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">Payment Received</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_18"></span>

							</h5>
							<p class=" mb-0 p-colo info6">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_18"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_18"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="bill_payment_receive_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">SD Claim Pending</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_20"></span>

							</h5>
							<p class=" mb-0 p-colo info6">PO Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_20"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Invoice Count</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_value_20"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="sd_claim_details"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2 ">

				<div class=" border-0 align-items-center d-flex mn-op">

					<h4 class="card-title mb-0 flex-grow-1 np-ar color-black">LD Value</h4>
					<div>

					</div>
				</div>
				<div class="row g-0 text-center">
					<div class="col-6 col-sm-3">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="po_count_19"></span>

							</h5>
							<p class=" mb-0 p-colo info6">PO Count</p>
						</div>
					</div>
					<!-- <div class="col-6 col-sm-2">
					<div class="p-3 border border-dashed border-start-0">
						<h5 class="mb-1"><span class="color-black" id="total_invoice_count_19"></span>
							
						</h5>
						<p class=" mb-0 p-colo info6" >Invoice Count</p>
					</div>
				</div> -->
					<div class="col-6 col-sm-4">
						<div class="p-3 border border-dashed border-start-0">
							<h5 class="mb-1"><span class="color-black" id="invoice_count_19"></span>

							</h5>
							<p class=" mb-0 p-colo info6">Invoice Count With LD</p>
						</div>
					</div>
					<div class="col-6 col-sm-5">
						<div class="p-3 border border-dashed border-start-0 border-end-0">
							<h5 class="mb-1"><span class="color-black" id="ld_value_19"></span>

							</h5>
							<p class=" mb-0 p-colo info6">LD Value</p>
						</div>
					</div>



					<!--end col-->
				</div>
				<div id="ld_details"></div>
			</div>
		</div>



	</div>
</div>


<script>
	$(document).ready(function () {

		mydemo();
		// ("hii");

	});
	function mydemo() {
		get_amc_details();
		formatCurrency();
		get_po_details();
		get_stock_details();
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
		bill_pending_details();
		bill_payment_pending_details();
		bill_payment_receive_details();
		ld_details();
		sd_claim_details();
	}

	$("#export").click(function () {
		//     ();
		// ("hi");
		window.location = "folders/dashboard/excel.php";
	});


	function get_po_details() {
		// //////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				// var new_complaints          = obj.new_complaints;
				// var completed_complaints    = obj.completed_complaints;

				$('#po_count').html(po_count);
				$('#invoice_value').html(invoice_value);
				// $('#completed_complaints').html(completed_complaints);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
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
				var amc_percentae = obj.amc_percentae;
				var value = obj.value;
				var po_count_amc = obj.po_count_amc;

				$('#amc_percentage').html(amc_percentae + '%');
				$('#amc_value').html(value);
				$('#po_count_amc').html(po_count_amc);

			}
		});
		// });
	}




	function get_stock_details() {

		// //////$('#submit').on('click', function() {
		// ();
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
				var po_count1 = obj.po_count1;
				var value1 = obj.value1;
				var po_count = obj.po_count;
				var value = obj.value;
				// var new_complaints          = obj.new_complaints;
				// var completed_complaints    = obj.completed_complaints;
				$('#po_count1').html(po_count);
				$('#value1').html(value);
				$('#po_cnt').html(po_count1);
				$('#value').html(value1);
				// $('#completed_complaints').html(completed_complaints);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function invoice_assign_qty_details() {
		//$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var stock_value = obj.stock_value;
				// var invoice_count          = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#inv_assign_po_count').html(po_count);
				// $('#assign_invoice_count').html(invoice_value);
				$('#assign_value').html(stock_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function invoice_partial_assign_qty_details() {
		//$('#submit').on('click', function() {
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
			// alert(data);
				var obj = JSON.parse(data);
				var po_count = obj.po_count;
				var stock_value = obj.stock_value;
				// var invoice_count          = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;
// alert(po_count);
				$('#inv_partial_assign_po_count').html(po_count);
				// $('#assign_invoice_count').html(invoice_value);
				$('#partial_assign_value').html(stock_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function get_inv_pending_details() {
		// //////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#inv_po_count').html(po_count);
				$('#inv_count').html(invoice_count);
				$('#inv_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function get_inv_com_details() {
		////////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#po_com_count').html(po_count);
				$('#inv_com_count').html(invoice_count);
				$('#inv_com_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function
		get_deleivery_pending() {
		////////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#del_po_count').html(po_count);
				$('#del_invoice_count').html(invoice_count);
				$('#del_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}
	function
		get_transit_pending() {
		////////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#del_in_po_count').html(po_count);
				$('#del_in_invoice_count').html(invoice_count);
				$('#del_in_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function
		get_ac_pending() {
		////////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#doc_ac_po_count').html(po_count);
				$('#doc_ac_invoice_count').html(invoice_count);
				$('#doc_ac_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}



	function
		install_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#ins_po_count').html(po_count);
				$('#ins_invoice_count').html(invoice_count);
				$('#ins_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function
		doc_pending_details() {
		//////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#doc_po_count').html(po_count);
				$('#doc_invoice_count').html(invoice_count);
				$('#doc_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}



	function
		doc_eng_pending_details() {
		//////$('#submit').on('click', function() {
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;

				$('#eng_po_count').html(po_count);
				$('#eng_invoice_count').html(invoice_count);
				$('#eng_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function snr_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var install_count = obj.install_count;
				// var completed_complaints    = obj.completed_complaints;
				// (data);
				$('#snr_po_count').html(po_count);
				$('#install_count').html(install_count);
				$('#snr_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function elcot_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;
				// (data);
				$('#elcot_po_count').html(po_count);
				$('#elcot_invoice_count').html(invoice_count);
				$('#elcot_invoice_value').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function sign_doc_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				// alert(data);
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;
				// var completed_complaints    = obj.completed_complaints;
				// (data);
				$('#po_count_13').html(po_count);
				$('#invoice_count_13').html(invoice_count);
				$('#invoice_value_13').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function bg_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;

				$('#po_count_14').html(po_count);
				$('#invoice_count_14').html(invoice_count);
				$('#invoice_value_14').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function entry_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;

				$('#po_count_15').html(po_count);
				$('#invoice_count_15').html(invoice_count);
				$('#invoice_value_15').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function bill_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;

				$('#po_count_16').html(po_count);
				$('#invoice_count_16').html(invoice_count);
				$('#invoice_value_16').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function bill_payment_pending_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;

				$('#po_count_17').html(po_count);
				$('#invoice_count_17').html(invoice_count);
				$('#invoice_value_17').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}

	function bill_payment_receive_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				var po_count = obj.po_count;
				var invoice_value = obj.invoice_value;
				var invoice_count = obj.invoice_count;

				$('#po_count_18').html(po_count);
				$('#invoice_count_18').html(invoice_count);
				$('#invoice_value_18').html(invoice_value);
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
	}


	function ld_details() {
		//////$('#submit').on('click', function() {
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
				//    (data);

				$('#po_count_19').html(po_count);
				$('#total_invoice_count_19').html(total_invoice_count);
				$('#invoice_count_19').html(invoice_count);

				// $('#invoice_value_19').html(invoice_value);
				$('#ld_value_19').html(ld_value);
			}
		});
		// });
	}




	function sd_claim_details() {
		//////$('#submit').on('click', function() {
		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");
		var acc_year = document.getElementById('acc_year').value;
		//    (acc_year);
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
				// $('#pending_complaints').html(pending_complaints);
			}
		});
		// });
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
