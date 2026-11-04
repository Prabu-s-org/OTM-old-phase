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
		// "" => [
		// 	"unique_id" => "",
		// 	"value" => "Select Option",
		// ],
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
												<button type="button" id="submit" name="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab" onclick="mydemo()">
                                                            Go </button>
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

					
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Total Purchase Order </p><br>
							<div class="d-flex align-items-center">

								<div class="flex-grow-1 overflow-hidden ">
									<span class="all-po">Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0" ><span class="counter-value"
											data-target="" id="po_count"></span></h4>
								</div>
								<div class="flex-grow-1 overflow-hidden ">
									<span class="all-po">Value</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0" ><span class="counter-value"
											data-target="" id="invoice_value"></span></h4>
								</div>
								<div class="flex-shrink-0">
									<div class="avatar-sm flex-shrink-0 icons">
										<i class="bx bx-wallet "></i>
									</div>
								</div>
							</div>

							<div id="get_po_details"></div>
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
					
					<div class="card-body" style="z-index:1 ;">
					<p class="   mb-0 ht"> Material Unavailable	</p><br>
						<div class="d-flex align-items-center">
						
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">PO Count</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0">
									<span class="counter-value"  data-target="" id="po_cnt"></span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Value</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0">
									<span class="counter-value"  data-target="" id="value"></span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Partial Po count</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"  data-target="" id="po_count1"></span></h4>
							</div>
							<div class="flex-grow-1 overflow-hidden ">
							<span class="all-po">Partial Value</span>
								<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="" id="value1"></span></h4>
							</div>
						  <div class="flex-shrink-0">
						  <div class="avatar-sm flex-shrink-0 icons o2">
								<i class="ri-close-circle-fill "></i>
						</div>
						  </div>
						  
						</div>
						<div id="get_stock_details"></div>
						
					</div><!-- end card body -->
				</div><!-- end card -->
			 </div>
				
					</div>
					<!--end col-->
				</div>
			</div>
			<hr>
			<div class="row">
					<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-info vf">
					
					
<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Invoice Assign Quantity </p><br>

							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="inv_assign_po_count">260</span></h4>
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
									<!-- <div class="col-md-6 bt-e">
										<p>Invoice Count</p>
										<h1 id="assign_invoice_count"></h1>
									</div> -->
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="assign_value"></h1>
									</div>
								</div>
							</div>
							<div id="invoice_assign_qty_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-success">
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Invoice Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="inv_po_count"></span></h4>
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
										<h1 id="inv_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="inv_value"></h1>
									</div>
								</div>
							</div>
							<div id="get_inv_pending_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-info">
						

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Invoice Completed </p><br>

							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0">
										<span class="counter-value"
											data-target="" id="po_com_count">260</span></h4>
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
										<h1 id="inv_com_count"></h1>
											<!-- <span class="counter-value" -->
											 <!-- id="inv_com_count"></span> -->
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="inv_com_value">
											 </h1>
											 <!-- <span class="counter-value"
											 id="inv_com_value"></span> -->
									</div>
								</div>
							</div>
							<div id="get_inv_com_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profyile-project-danger">
						

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Delivery Status - Dispatch Pending

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="del_po_count"></span></h4>
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
										<h1 id="del_invoice_count"></span></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="del_invoice_value"></h1>
									</div>
								</div>
							</div>
						<div id="get_deleivery_pending"> </div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>

				<div class="col-md-3">
					<div class="card card-animate overflow-hidden card profile-project-card  profile-project-warning">
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Delivery Status - Material In Transit
							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="del_in_po_count"></span></h4>
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
										<h1 id="del_in_invoice_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="del_in_invoice_value"></h1>
									</div>
								</div>
							</div>
							<div id="get_transit_pending"> </div>
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
											data-target="" id="doc_ac_po_count">260</span></h4>
								</div>
								


							</div>
							<hr>
								<div class="brm-aprr">
								<div class="row">
									<div class="col-md-4 bt-e">
										<p>Invoice Count</p>
										<h1 id="doc_ac_invoice_count">
											</h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="doc_ac_invoice_value"></h1>
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
						

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Installation Pending

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="ins_po_count">260</span></h4>
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
										<h1 id="ins_invoice_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="ins_invoice_value"></h1>
									</div>
								</div>
							</div>
							<div id="install_pending_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->

				</div>

				<div class="col-md-3">
					<div class="card card-animate " style="background: #0ab39c;">

					
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document Collection Pending




							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="doc_po_count"></span></h4>
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
										<h1 id="doc_invoice_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="doc_invoice_value"></h1>
									</div>
								</div>
							</div>
							<div id="doc_pending_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate " style="background: #f06548;">

						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document With Engineer

							</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="eng_po_count">260</span></h4>
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
										<h1 id="eng_invoice_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="eng_invoice_value"></h1>
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
				<div class="col-md-3">
					<div class="card card-animate " style="background: #9155fd;">
						
						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Snr </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="snr_po_count">260</span></h4>
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
										<h1 id="install_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="snr_invoice_value"></h1>
									</div>
								</div>
							</div>
							<div id="snr_details"></div>
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
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Document Verification Pending </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="elcot_po_count">260</span></h4>
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
										<h1 id="elcot_invoice_count"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="elcot_invoice_value"></h1>
									</div>
								</div>
							</div>
							<div id="elcot_pending_details"></div>
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
						
						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Signed Document Verfication Pending</p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_13">260</span></h4>
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
										<h1 id="invoice_count_13"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_13"> </h1>
									</div>
								</div>
							</div>
							<div id="sign_doc_details"></div>
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
						

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Bg Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_14">260</span></h4>
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
										<h1 id="invoice_count_14"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_14"></h1>
									</div>
								</div>
							</div>
							<div id="bg_pending_details"></div>
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
						

						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht"> Entry Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_15">260</span></h4>
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
										<h1 id="invoice_count_15"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_15"></h1>
									</div>
								</div>
							</div>
							<div id="entry_pending_details"></div>
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
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Bill Submission Pending</p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_16">260</span></h4>
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
										<h1 id="invoice_count_16"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_16"></h1>
									</div>
								</div>
							</div>
							<div id="bill_pending_details"></div>
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
						
						
						
						<div class="card-body" style="z-index:1 ;">
							<p class="  mb-0 ht">Bill Submitted Payment Pending </p>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_17">260</span></h4>
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
										<h1 id="invoice_count_17"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_17"></h1>
									</div>
								</div>
							</div>
							<div id="bill_payment_pending_details"></div>
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

						
						
						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Payment Received</p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target="" id="po_count_18">260</span></h4>
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
										<h1 id="invoice_count_18"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_18"></h1>
									</div>
								</div>
							</div>
							<div id="bill_payment_receive_details"></div>
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
											data-target="" id="po_count_19">260</span></h1>
								</div>
								<div class="flex-grow-1 overflow-hidden  brm-aprr">
									<span class="all-po">Total Invoice Count </span>
									<h1 class=" fw-semibold ff-secondary mb-0" id="total_invoice_count_19"></h1>
								</div>

							</div>
							<hr>
							<div class="brm-aprr">
								<div class="row">
									<div class="col-md-7 bt-e">
										<p>Invoice Count With LD </p>
										<h1 id="invoice_count_19"></h1>
									</div>
									<div class="col-md-5 bt-r">
										<p>LD Value</p>
										<h1 id="ld_value_19"></h1>
									</div>
								</div>
							</div>
                            <div id="ld_details"></div>
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
						

						<div class="card-body" style="z-index:1 ;">
							<p class="   mb-0 ht"> Sd Claim Pending </p><br>
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 overflow-hidden po-count ">
									<span class="all-po">Po Count</span>
									<h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
											data-target=""  id="po_count_20">260</span></h4>
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
										<h1 id="invoice_count_20"></h1>
									</div>
									<div class="col-md-6 bt-r">
										<p>Value</p>
										<h1 id="invoice_value_20"></h1>
									</div>
								</div>
							</div>
							<div id="sd_claim_details"></div>
						</div><!-- end card body -->
					</div><!-- end card -->
				</div>
			</div>




		</div>
	</div>
</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

<script>
$(document).ready(function () {
    
    mydemo();
    // ("hii");

});
function mydemo(){
    get_po_details();
    get_stock_details();
//    acc_year();
    // 
	invoice_assign_qty_details();
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

	
function get_po_details()  
{
    // //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "task_details",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
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
function get_stock_details()  
{
    
    // //////$('#submit').on('click', function() {
        // ();
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;

    var data = {
                "action"    : "stock_details",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count1      = obj.po_count1;
                    var value1      = obj.value1;
                    var po_count      = obj.po_count;
                    var value      = obj.value;
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

function invoice_assign_qty_details()  
{
    //$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "assign_qty",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    // var invoice_value      = obj.invoice_value;
                    var stock_value           = obj.stock_value;
                    // var completed_complaints    = obj.completed_complaints;

                    $('#inv_assign_po_count').html(po_count);
                    // $('#assign_invoice_count').html(invoice_value);
                    $('#assign_value').html(stock_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}


function get_inv_pending_details()  
{
    // //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "inv_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                    // var completed_complaints    = obj.completed_complaints;

                    $('#inv_po_count').html(po_count);
                    $('#inv_count').html(invoice_count);
                    $('#inv_value').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}

function get_inv_com_details()  
{
    ////////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "inv_complete",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
get_deleivery_pending()  
{
    ////////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "delivery_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
get_transit_pending()  
{
    ////////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "delivery_transit",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
get_ac_pending()  
{
    ////////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    
    var data = {
                "action"    : "ac_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
install_pending_details()  
{
   
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;

    var data = {
                "action"    : "install_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
doc_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "document_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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
doc_eng_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   
    var data = {
                "action"    : "document_eng_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                    // var completed_complaints    = obj.completed_complaints;

                    $('#eng_po_count').html(po_count);
                    $('#eng_invoice_count').html(invoice_count);
                    $('#eng_invoice_value').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}

function snr_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "snr_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var install_count          = obj.install_count;
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


function elcot_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "elcot_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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

function sign_doc_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "sign_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
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


function bg_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "bg_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_14').html(po_count);
                    $('#invoice_count_14').html(invoice_count);
                    $('#invoice_value_14').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}


function entry_pending_details()  
{
    //$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;

    var data = {
                "action"    : "entry_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_15').html(po_count);
                    $('#invoice_count_15').html(invoice_count);
                    $('#invoice_value_15').html(invoice_value);
					//(obj.invoice_count);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}



function bill_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "bill_sub_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_16').html(po_count);
                    $('#invoice_count_16').html(invoice_count);
                    $('#invoice_value_16').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}

function bill_payment_pending_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "payment_pending",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_17').html(po_count);
                    $('#invoice_count_17').html(invoice_count);
                    $('#invoice_value_17').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}

function bill_payment_receive_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "payment_receive",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_18').html(po_count);
                    $('#invoice_count_18').html(invoice_count);
                    $('#invoice_value_18').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}


function ld_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
   (acc_year);
    var data = {
                "action"    : "ld_detail",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var ld_value      = obj.ld_value;
                    var total_invoice_count     = obj.total_invoice_count;
                    var invoice_count          = obj.invoice_count;
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




function sd_claim_details()  
{
    //////$('#submit').on('click', function() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url      = sessionStorage.getItem("list_link");
    var acc_year=document.getElementById('acc_year').value;
//    (acc_year);
    var data = {
                "action"    : "sd_claim",
                "acc_year"	: acc_year, 
            }

            $.ajax({
                type    : "POST",
                url     : ajax_url,
                data    : data,
                success : function(data) 
                {
                    var obj     = JSON.parse(data);
                    var po_count      = obj.po_count;
                    var invoice_value      = obj.invoice_value;
                    var invoice_count          = obj.invoice_count;
                   
                    $('#po_count_20').html(po_count);
                    $('#invoice_count_20').html(invoice_count);
                    $('#invoice_value_20').html(invoice_value);
                    // $('#pending_complaints').html(pending_complaints);
                }
            });
            // });
}


</script>
