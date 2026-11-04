<style>
	.s0 {
		opacity: .05;
		fill: #56ca00;
	}

	.s1 {
		opacity: .05;
		fill: #8A8D93;
	}

	.s2 {
		opacity: .05;
		fill: #9155FD;
	}

	.s3 {
		opacity: .05;
		fill: #FFB400;
	}

	.s4 {
		opacity: .05;
		fill: #16B1FF;
	}

	.s5 {
		opacity: .05;
		fill: #FF4C51;
	}

	.s6 {
		opacity: .05;
		fill: #635bff;
	}

	.s7 {
		opacity: .05;
		fill: #ff6692;
	}

	.s8 {
		opacity: .05;
		fill: #14E9E2;
	}

	.s9 {
		opacity: .05;
		fill: #FFB400;
	}

	.brm-aprr p {
		margin-bottom: 0px;
		font-size: 13px;
		color: #fff;
	}
.ht {
    font-size: 16px;
    color: #fff;
    font-weight: 500;
}

	.brm-aprr h1 {
		font-size: 16px;
		font-weight: 600;
		color: #3a3541de;
	}

hr {
    border-color: #fff;
}
	.icons i {
		font-size: 27px;
		box-shadow: 0px 4px 8px -4px rgba(58, 53, 65, 0.42);
		width: 45px;
		height: 45px;
		border-radius: 40px;
		padding: 10px;
		background: #ffffff;
        color: #8bc34a;
	}

	.icons.o1 i {
		background: #fff;
		color: #8A8D93;
	}

	.icons.o2 i {
		background: #fff;
		color: #9155FD;
	}

	.icons.o3 i {
		background: #fff;
		color: #9155FD;
	}

	.icons.o4 i {
		background: #fff;
		color: #16B1FF;
	}

	.icons.o5 i {
		background: #fff;
		color: #FF4C51;
	}

	.icons.o6 i {
		background: #fff;
		color: #635bff;
	}

	.icons.o7 i {
		background: #fff;
		color: #ff6692;
	}

	.icons.o8 i {
		background: #fff;
		color: #14E9E2;
	}

	.icons.o9 i {
		background: #fff;
		color: #FFB400;
	}

	.icons.o10 i {
		background: #fff;
		color: #0ab39c;
	}

	.icons.o11 i {
		background: #fff;
		color: #299cdb;
	}

	.icons.o12 i {
		background: #fff;
		color: #f06548;
	}

	.icons.o14 i {
		background: #fff;
		color: #405189;
	}

	h4.daf-file.mb-1 {
		color: #000;
	}

	span.all-po {
		margin-bottom: 0px;
		font-size: 13px;
		color: #fff;
	}
span.counter-value {
    color: #fff;
}
	.flex-grow-1.overflow-hidden.po-count {
		margin-top: 17px;
	}
	
	
	.card.card-animate.overflow-hidden.card.profile-project-card.profile-project-info.vf {
    border-left-color: #405189;
    background: #405189;
}
.card.card-animate.overflow-hidden.card.profile-project-card.profile-project-success {
    background: #0ab39c;
}
.card.card-animate.overflow-hidden.card.profile-project-card.profile-project-info {
    background: #299cdb;
}
.card.card-animate.overflow-hidden.card.profile-project-card.profyile-project-danger {
    background: #f06548;
    border-left-color: #f06548;
}
.card.card-animate.overflow-hidden.card.profile-project-card.profile-project-warning {
    background: #ffb400;
}
</style>
<?php
$acc_year_select =
	[
		"" => [
			"unique_id" => "",
			"value" => "Select Option",
		],
		"2024-2025" => [
			"unique_id" => "2024-2025",
			"value" => "2024-2025",
		],
		"2025-2026" => [
			"unique_id" => "2025-2026",
			"value" => "2025-2026",
		],
		"2026-2027" => [
			"unique_id" => "2026-2027",
			"value" => "2026-2027",
		],
	];

$acc_year_selects = select_option($acc_year_select);

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

<div class="row mt-4">
	<div class="">
		<div class="d-flex flex-column h-100">

			<div class="row h-100">
				<div class="row mb-3 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Elcot Purchase Order</h4>

							</div>
							<div class="mt-3 mt-lg-0">
							<form id="filter_form" method="post">
								<div class="mt-3 mt-lg-0">
									<div class="row g-3 mb-0 align-items-center">
										<div class="col-sm-auto d-flex">
											<div class="input-group">
												<select id="acc_year" name="acc_year" class="form-control border-0 minimal-border dash-filter-picker shadow">
													<?php echo $acc_year_selects ?>
												</select>
												<!-- <button type="button" id="submit" name="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab">Go</button> -->
											</div>
										</div>
									</div>
								</div>
							</form>
							</div>
						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="card card-animate overflow-hidden" style="background: #8BC34A;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s0"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>

						<?php


						// $unique_id  = $_GET["unique_id"];
// $where      = [
// 	"unique_id" => $unique_id
// ];
//  $acc_year = $_POST['acc_year'];
						$table = "view_po_count_value";
						$columns = [
							"count(unique_id) as po_count",
							"sum(invoice_value) as invoice_value",
							// "(FORMAT(SUM(invoice_value), 0), ',', ',') AS invoice_value"

						];
						$table_details = [
							$table,
							$columns
						];
						// $where= "acc_year ='".$_POST['acc_year']."'";
						
						$result_values = $pdo->select($table_details, $where);
						// print_r($result_values);
						if ($result_values->status) {
							$result_values = $result_values->data;
							$po_count = $result_values[0]["po_count"];
							$invoice_value = $result_values[0]["invoice_value"];
							// $invoice_value = number_format($result_values[0]["invoice_value"], 2, '.', ',');

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Total Purchase Order </p><br>
							<div class="d-flex align-items-center">

								<div class="flex-grow-1 overflow-hidden ">
									<span class="all-po">Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count; ?>"></span></h4>
								</div>
								<div class="flex-grow-1 overflow-hidden ">
									<span class="all-po">Value</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0">
        <span class="counter-value"data-target="<?php echo $invoice_value; ?>">
        </span>
    </h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons">
										<i class="bx bx-wallet "></i>
									</div>
								</div>
							</div>


						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
			</div>






			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Purchase Team
								</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
					   <div class="col-md-5">
				<div class="card card-animate overflow-hidden" style="background: #8950ef;">
					<div class="position-absolute start-0" style="z-index: 0;">
						<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250" height="195">
							<path id="Shape 8" class="s2" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
						</svg>
					</div>
					<?php
					$table_stock = "view_stock_count_value";
								$columns = [
									"po_count",
									"value",

								];
								$table_details = [
									$table_stock,
									$columns
								];
								$result_values = $pdo->select($table_details, $where);
								// print_r($result_values);
								if ($result_values->status) {
									$result_values = $result_values->data;
									$po_count = $result_values[0]["po_count"];
									$value = $result_values[0]["value"];


								}
								?>
								<!-- <?php
					$table_stock_pending = "view_pur_stock_pending_count";
								$columns = [
									"po_count",
									"value",

								];
								$table_details = [
									$table_stock_pending,
									$columns
								];
								$result_values = $pdo->select($table_details, $where);
								// print_r($result_values);
								if ($result_values->status) {
									$result_values = $result_values->data;
									$po_count1 = $result_values[0]["po_count"];
									$value1 = $result_values[0]["value"];


								}
								?> -->
					<div class="card-body" style="z-index:1 ;">
					<p class="   mb-0 ht"> Material Unavailable	</p><br>
						<div class="d-flex align-items-center">
						
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">PO Count</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0">
									<span class="counter-value" data-target="<?php echo $po_count1; ?>">260</span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Value</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0">
									<span class="counter-value" data-target="<?php echo $value1; ?>">260</span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Partial Po count</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?php echo $po_count; ?>">260</span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Partial Value</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?php echo $value; ?>">260</span></h4>
							</div>
						  <div class="flex-shrink-0">
						  <div class="avatar-sm flex-shrink-0 icons o2">
								<i class="ri-close-circle-fill "></i>
						</div>
						  </div>
						</div>
						
						
					</div><!-- end card body -->
				</div><!-- end card -->
			 </div>
				<!--<div class="col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="avatar-sm flex-shrink-0">
									<span class="avatar-title bg-light text-primary rounded-circle fs-3">
										<i class=" ri-close-circle-fill"></i>
									</span>
								</div>
								<?php
								$table_stock = "view_stock_count_value";
								$columns = [
									"po_count",
									"value",

								];
								$table_details = [
									$table_stock,
									$columns
								];
								$result_values = $pdo->select($table_details, $where);
								// print_r($result_values);
								if ($result_values->status) {
									$result_values = $result_values->data;
									$po_count = $result_values[0]["po_count"];
									$value = $result_values[0]["value"];


								}
								?>
								<div class="flex-grow-1 ms-3">
									<p class="fw-medium   mb-2 ht">Material Unavailable </p>
									<span class="all-po">Po Count</span>
									<h4 class=" fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count; ?>">260</span></h4>
								</div>


							</div>

						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="avatar-sm flex-shrink-0">
									<span class="avatar-title bg-light text-primary rounded-circle fs-3">
										<i class="  ri-hand-coin-fill"></i>
									</span>
								</div>
								<div class="flex-grow-1 ms-3">
									<p class="fw-medium   mb-2 ht">Material Unavailable </p>
									<span class="all-po">Value</span>
									<h4 class=" fs-22 fw-semibold ff-secondary "><span class="counter-value"
											data-target="<?php echo $value; ?>">9802428</span></h4>
								</div>


							</div>

						</div>
					</div>
				</div>-->
			</div>

			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Stores Team</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
					<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-info vf">
					
					<?php
						$table_com = "view_pending_invoice_count_value";
						$columns_4 = [
							"count(po_count) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_4 = [
							$table_com,
							$columns_4
						];
						$result_values_4 = $pdo->select($table_details_4, $where);
						// print_r($result_values);
						if ($result_values_4->status) {
							$result_values_4 = $result_values_4->data;
							$po_count_4 = $result_values_4[0]["po_count"];
							$invoice_count_4 = $result_values_4[0]["invoice_count"];
							$invoice_value_4 = $result_values_4[0]["invoice_value"];


						}
						?>
<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Invoice Assign Quantity </p><br>

							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o14">
										<i class="ri-arrow-up-circle-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<?php
						$table_com = "view_invoice_completed_count_value";
						$columns_4 = [
							"count(po_count) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_4 = [
							$table_com,
							$columns_4
						];
						$result_values_4 = $pdo->select($table_details_4, $where);
						// print_r($result_values);
						if ($result_values_4->status) {
							$result_values_4 = $result_values_4->data;
							$po_count_4 = $result_values_4[0]["po_count"];
							$invoice_count_4 = $result_values_4[0]["invoice_count"];
							$invoice_value_4 = $result_values_4[0]["invoice_value"];


						}
						?>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-success">
						<?php
						$table_inv = "view_pending_invoice_count_value";
						$columns = [
							"count(po_count) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details = [
							$table_inv,
							$columns
						];
						$result_values = $pdo->select($table_details, $where);
						// print_r($result_values);
						if ($result_values->status) {
							$result_values_inv = $result_values->data;
							$po_count_val = $result_values_inv[0]["po_count"];
							$invoice_count = $result_values_inv[0]["invoice_count"];
							$invoice_value_val = $result_values_inv[0]["invoice_value"];


						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Invoice Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_4; ?>"></span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o10">
										<i class="ri-time-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
								<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_val; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-info">
						<?php
						$table_com = "view_invoice_completed_count_value";
						$columns_4 = [
							"count(po_count) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_4 = [
							$table_com,
							$columns_4
						];
						$result_values_4 = $pdo->select($table_details_4, $where);
						// print_r($result_values);
						if ($result_values_4->status) {
							$result_values_4 = $result_values_4->data;
							$po_count_4 = $result_values_4[0]["po_count"];
							$invoice_count_4 = $result_values_4[0]["invoice_count"];
							$invoice_value_4 = $result_values_4[0]["invoice_value"];


						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Invoice Completed </p><br>

							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_4; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o11">
										<i class=" ri-check-double-fill"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_4; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_4; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profyile-project-danger">
						<?php
						$table_dis = "view_dispatch_pending_count";
						$columns_5 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_5 = [
							$table_dis,
							$columns_5
						];
						$result_values_5 = $pdo->select($table_details_5, $where);
						// print_r($result_values);
						if ($result_values_5->status) {
							$result_values_5 = $result_values_5->data;
							$po_count_5 = $result_values_5[0]["po_count"];
							$invoice_count_5 = $result_values_5[0]["invoice_count"];
							$invoice_value_5 = $result_values_5[0]["invoice_value"];


						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Delivery Status - Dispatch Pending

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_5; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o12">
										<i class="ri-message-2-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_5; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_5; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-warning">
						<?php
						$table_dis_com = "view_dispatch_complete_count";
						$columns_6 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_6 = [
							$table_dis_com,
							$columns_6
						];
						$result_values_6 = $pdo->select($table_details_6, $where);
						// print_r($result_values_6);
						if ($result_values_6->status) {
							$result_values_6 = $result_values_6->data;
							$po_count_6 = $result_values_6[0]["po_count"];
							$invoice_count_6 = $result_values_6[0]["invoice_count"];
							$invoice_value_6 = $result_values_6[0]["invoice_value"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Delivery Status - Material In Transit
							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_6; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o9">
										<i class="ri-chat-forward-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_6; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_6; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

			</div>

			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Account Team
								</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<?php
					$table_ac_team = "view_ac_team_pending";
					$columns_7 = [
						"count(po_unique_id) As po_count",
						"sum(invoice_count) AS invoice_count",
						"SUM(invoice_value) AS invoice_value",

					];
					$table_details_7 = [
						$table_ac_team,
						$columns_7
					];
					$result_values_7 = $pdo->select($table_details_7, $where);
					// print_r($result_values_6);
					if ($result_values_7->status) {
						$result_values_7 = $result_values_7->data;
						$po_count_7 = $result_values_7[0]["po_count"];
						$invoice_count_7 = $result_values_7[0]["invoice_count"];
						$invoice_value_7 = $result_values_7[0]["invoice_value"];

					}
					?>

					<div class="card" style="background: #607D8B;">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="avatar-sm flex-shrink-0">
									<span class="avatar-title bg-light text-primary rounded-circle fs-3">
										<i class=" ri-message-2-line "></i>
									</span>
								</div>
								<div class="flex-grow-1 ms-3">
									<p class="  mb-2 ht">Document Verification Pending – Accounts
									</p><span class="all-po">Po Count</span>
									<h4 class=" fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_7; ?>">260</span></h4>
								</div>
								


							</div>
							<hr>
								<div class="brm-aprr">
								<div class="row">
									<div class="col-md-4 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_7; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_7; ?></h1>
									</div>
								</div>
							</div>

						</div><!-- end card body -->
					</div><!-- end card -->
				</div><!-- end col -->
				<!--<div class="col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="avatar-sm flex-shrink-0">
									<span class="avatar-title bg-light text-primary rounded-circle fs-3">
										<i class=" ri-profile-line "></i>
									</span>
								</div>
								<div class="flex-grow-1 ms-3">
									<p class="fw-medium   mb-2 ht">Document Verification Pending </p>
									<span class="all-po">Invoice Count</span>
									<h4 class=" fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $invoice_count_7; ?>">260</span></h4>
								</div>


							</div>

						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div class="avatar-sm flex-shrink-0">
									<span class="avatar-title bg-light text-primary rounded-circle fs-3">
										<i class="  ri-hand-coin-line"></i>
									</span>
								</div>
								<div class="flex-grow-1 ms-3">
									<p class="fw-medium   mb-2 ht">Document Verification Pending
									</p><span class="all-po">Value</span>
									<h4 class=" fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $invoice_value_7; ?>">260</span></h4>
								</div>


							</div>

						</div>
					</div>
				</div>--->
			</div>



			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class=" daf-file mb-1">Service Team

								</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3">
					<div class="card card-animate " style="background: #405189;">
						<?php
						$table_install = "view_installation_pending_count";
						$columns_8 = [
							"count(form_main_unique_id) As po_count",
							"sum(install_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_8 = [
							$table_install,
							$columns_8
						];
						$result_values_8 = $pdo->select($table_details_8, $where);
						// print_r($result_values_6);
						if ($result_values_8->status) {
							$result_values_8 = $result_values_8->data;
							$po_count_8 = $result_values_8[0]["po_count"];
							$invoice_count_8 = $result_values_8[0]["invoice_count"];
							$invoice_value_8 = $result_values_8[0]["invoice_value"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Installation Pending

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_8; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o14">
										<i class=" ri-install-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_8; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_8; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->

				</div>

				<div class="col-md-3">
					<div class="card card-animate " style="background: #0ab39c;">

						<?php
						$table_document = "view_document_pending_count";
						$columns_9 = [
							"count(po_form_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_9 = [
							$table_document,
							$columns_9
						];
						$result_values_9 = $pdo->select($table_details_9, $where);
						// print_r($result_values_6);
						if ($result_values_9->status) {
							$result_values_9 = $result_values_9->data;
							$po_count_9 = $result_values_9[0]["po_count"];
							$invoice_count_9 = $result_values_9[0]["invoice_count"];
							$invoice_value_9 = $result_values_9[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document Collection Pending




							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_9; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o10">
										<i class=" ri-file-warning-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_9; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_9; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate " style="background: #f06548;">

						<?php
						$table_eng = "view_document_engineer_count";
						$columns_10 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_10 = [
							$table_eng,
							$columns_10
						];
						$result_values_10 = $pdo->select($table_details_10, $where);
						// print_r($result_values_6);
						if ($result_values_10->status) {
							$result_values_10 = $result_values_10->data;
							$po_count_10 = $result_values_10[0]["po_count"];
							$invoice_count_10 = $result_values_10[0]["invoice_count"];
							$invoice_value_10 = $result_values_10[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document With Engineer

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?Php echo $po_count_10; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o12">
										<i class="ri-user-settings-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?Php echo $invoice_count_10; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?Php echo $invoice_value_10; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate " style="background: #9155fd;">
						<?php
						$table_snr = "view_snr_pending_count";
						$columns_11 = [
							"count(po_form_unique_id) As po_count",
							"sum(install_count) AS install_count",
							"SUM(invoice_qty_value) AS invoice_value",

						];
						$table_details_11 = [
							$table_snr,
							$columns_11
						];
						$result_values_11 = $pdo->select($table_details_11, $where);
						// print_r($result_values_11);
						if ($result_values_11->status) {
							$result_values_11 = $result_values_11->data;
							$po_count_11 = $result_values_11[0]["po_count"];
							$install_count_11 = $result_values_11[0]["install_count"];
							$invoice_value_11 = $result_values_11[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Snr </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_11; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o2">
										<i class="ri-pie-chart-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $install_count_11; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_11; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
			</div>



			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Elcot Team</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>


			<hr>

			<div class="row">


				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #8a8d93;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s1"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_elcot = "view_elcot_pending";
						$columns_12 = [
							"count(po_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_12 = [
							$table_elcot,
							$columns_12
						];
						$result_values_12 = $pdo->select($table_details_12, $where);
						// print_r($result_values_11);
						if ($result_values_12->status) {
							$result_values_12 = $result_values_12->data;
							$po_count_12 = $result_values_12[0]["po_count"];
							$invoice_count_12 = $result_values_12[0]["invoice_count"];
							$invoice_value_12 = $result_values_12[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document Verification Pending </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_12; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o1">
										<i class="ri-profile-line "></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_12; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_12; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #9155fd;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s2"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_sign_doc = "view_sign_doc_pending_count";
						$columns_13 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_13 = [
							$table_sign_doc,
							$columns_13
						];
						$result_values_13 = $pdo->select($table_details_13, $where);
						// print_r($result_values_11);
						if ($result_values_13->status) {
							$result_values_13 = $result_values_13->data;
							$po_count_13 = $result_values_13[0]["po_count"];
							$invoice_count_13 = $result_values_13[0]["invoice_count"];
							$invoice_value_13 = $result_values_13[0]["invoice_value"];

						}
						?>


						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Signed Document Verfication Pending</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_13; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o2">
										<i class="ri-check-double-fill "></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_13 ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_13; ?> </h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #ffb400;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s3"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_bg = "view_bg_pending_count";
						$columns_14 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_14 = [
							$table_bg,
							$columns_14
						];
						$result_values_14 = $pdo->select($table_details_14, $where);
						// print_r($result_values_11);
						if ($result_values_14->status) {
							$result_values_14 = $result_values_14->data;
							$po_count_14 = $result_values_14[0]["po_count"];
							$invoice_count_14 = $result_values_14[0]["invoice_count"];
							$invoice_value_14 = $result_values_14[0]["invoice_value"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Bg Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_14; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o3">
										<i class="ri-map-pin-time-line "></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_14; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_14; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #16b1ff;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s4"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_update_pen = "view_bg_update_pending_count";
						$columns_15 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_14 = [
							$table_update_pen,
							$columns_15
						];
						$result_values_15 = $pdo->select($table_details_15, $where);
						// print_r($result_values_11);
						if ($result_values_15->status) {
							$result_values_15 = $result_values_15->data;
							$po_count_15 = $result_values_15[0]["po_count"];
							$invoice_count_15 = $result_values_15[0]["invoice_count"];
							$invoice_value_15 = $result_values_15[0]["invoice_value"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Entry Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_15; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o4">
										<i class=" ri-file-edit-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_15; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_15; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #ff4c51;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s5"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_bill_pending = "view_bill_pending_count";
						$columns_16 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_16 = [
							$table_bill_pending,
							$columns_16
						];
						$result_values_16 = $pdo->select($table_details_16, $where);
						// print_r($result_values_16);
						if ($result_values_16->status) {
							$result_values_16 = $result_values_16->data;
							$po_count_16 = $result_values_16[0]["po_count"];
							$invoice_count_16 = $result_values_16[0]["invoice_count"];
							$invoice_value_16 = $result_values_16[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Bill Submission Pending</p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_16; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o5">
										<i class="ri-bill-line "></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_16; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_16; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>


			</div>
			<div class="row h-100">
				<div class="row mb-0 pb-1">
					<div class="col-12">
						<div class="d-flex align-items-lg-center flex-lg-row flex-column">
							<div class="flex-grow-1">
								<h4 class="daf-file mb-1">Payment
								</h4>

							</div>

						</div><!-- end card header -->
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #635bff;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s6"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_payment_pending = "bill_submitted_payment_pending";
						$columns_17 = [
							"count(bill_form_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_17 = [
							$table_payment_pending,
							$columns_17
						];
						$result_values_17 = $pdo->select($table_details_17, $where);
						// print_r($result_values_11);
						if ($result_values_17->status) {
							$result_values_17 = $result_values_17->data;
							$po_count_17 = $result_values_17[0]["po_count"];
							$invoice_count_17 = $result_values_17[0]["invoice_count"];
							$invoice_value_17 = $result_values_17[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht">Bill Submitted Payment Pending </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_17; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o6">
										<i class="ri-secure-payment-line "></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_17; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_17; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #ff6692;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s7"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>

						<?php
						$table_payment_rec = "view_payment_received_count";
						$columns_18 = [
							"count(bill_form_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_18 = [
							$table_payment_rec,
							$columns_18
						];
						$result_values_18 = $pdo->select($table_details_18, $where);
						// print_r($result_values_11);
						if ($result_values_18->status) {
							$result_values_18 = $result_values_18->data;
							$po_count_18 = $result_values_18[0]["po_count"];
							$invoice_count_18 = $result_values_18[0]["invoice_count"];
							$invoice_value_18 = $result_values_18[0]["invoice_value"];

						}
						?>
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Payment Received</p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_18; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o7">
										<i class="ri-checkbox-circle-line"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_18; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_18; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #07d1ca;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s8"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_ld = "view_ld_value_count";
						$columns_19 = [
							"count(bill_form_unique_id) As po_count",
							"sum(ld_value) AS ld_value",
							"SUM(invoice_count) AS invoice_count",

						];
						$table_details_19 = [
							$table_ld,
							$columns_19
						];
						$result_values_19 = $pdo->select($table_details_19, $where);
						// print_r($result_values_11);
						if ($result_values_19->status) {
							$result_values_19 = $result_values_19->data;
							$po_count_19 = $result_values_19[0]["po_count"];
							$ld_value_19 = $result_values_19[0]["ld_value"];
							$invoice_count_19 = $result_values_19[0]["invoice_count"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<div class="d-flex align-items-center">
								<p class="  mb-0 ht" style="width: 100%;"> Ld Value </p>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o8">
										<i class=" ri-hand-coin-line"></i>
									</div>
								</div>
							</div>
							<div class="d-flex align-items-center">

								<div class="flex-grow-1 overflow-hidden  brm-aprr">
									<span class="all-po">Po Count</span>
									<h1 class=" fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_19; ?>">260</span></h1>
								</div>
								<div class="flex-grow-1 overflow-hidden  brm-aprr">
									<span class="all-po">Total Invoice Count </span>
									<h1 class=" fw-semibold ff-secondary mb-0"><?php echo $invoice_count_4; ?></h1>
								</div>

							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-7 bt-e">
										<p>Invoice Count With LD </p>
										<h1><?php echo $invoice_count_19; ?></h1>
									</div>
									<div class="col-md-5 bt-r">
										<p>LD Value</p>
										<h1><?php echo $ld_value_19; ?></h1>
									</div>
								</div>
							</div>

						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden" style="background: #ffb400;">
						<div class="position-absolute start-0" style="z-index: 0;">
							<svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 160" width="250"
								height="195">
								<path id="Shape 8" class="s9"
									d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
								</path>
							</svg>
						</div>
						<?php
						$table_sd = "view_sd_claim_pending";
						$columns_20 = [
							"count(bill_form_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_20 = [
							$table_sd,
							$columns_20
						];
						$result_values_20 = $pdo->select($table_details_20, $where);
						// print_r($result_values_11);
						if ($result_values_20->status) {
							$result_values_20 = $result_values_20->data;
							$po_count_20 = $result_values_20[0]["po_count"];
							$invoice_value_20 = $result_values_20[0]["invoice_value"];
							$invoice_count_20 = $result_values_20[0]["invoice_count"];

						}
						?>

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Sd Claim Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="<?php echo $po_count_20; ?>">260</span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons o9">
										<i class="ri-exchange-funds-fill"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1><?php echo $invoice_count_20; ?></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1><?php echo $invoice_value_20; ?></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
			</div>




		</div>
	</div>
</div>


<script>

	$("#export").click(function () {
		//     alert();
		// alert("hi");
		window.location = "folders/dashboard/excel.php";
	});

	

</script>
