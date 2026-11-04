<!-- This file Only PHP Functions -->

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
			"po_num",
			"po_date",
			"executive_name",
			"(select con_contact_name from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_contact_name",
			"(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_address",
			"no_of_items",
			"stock_qty",
			"invoice_value",
			"(SELECT file_name FROM po_form WHERE po_form.unique_id  = " . $table . ".form_main_unique_id group by form_main_unique_id) AS po_file",

			"(select department from stock_position_main where form_main_unique_id=$table.form_main_unique_id group by form_main_unique_id) AS department",
			"(select con_district from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_district",

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
			"ledger_no"
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
			$no_of_items = $result_values[0]["no_of_items"];
			$invoice_value = $result_values[0]["invoice_value"];
			$department = $result_values[0]['department'];
			$con_pincode = $result_values[0]['con_pincode'];
			$con_districts                  = district_name($result_values[0]['con_district']);
			$con_district             = disname($con_districts[0]['district_name']);
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
			$po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);

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
									<div class="row">
										<div class="col-5">
											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">PO
														Number</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $po_num; ?></div>
											</div>

											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">Excutive
														Name</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $executive_name ?></div>
											</div>
											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">Consignee
														Name</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $con_contact_name ?></div>
											</div>
										</div>
										<div class="col-5">
											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">PO Date</label>
												</div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $po_date ?></div>
											</div>

											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">No of Items in
														PO</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $no_of_items ?></div>
											</div>
											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">Consignee
														Address</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $con_address ?></div>
											</div>
										</div>
										<div class="col-5">
											<div class="row">
												<div class="col-xl-4 head_po"> <label
														class="form-label">Department</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $department ?></div>
											</div>
											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">Pincode</label>
												</div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $con_pincode ?></div>
											</div>
											<div class="col-xl-6">
												<div class="mb-3">
													<label for="main_screen" class="form-label">PO Attachment</label>
													<?php echo $po_file ?>

												</div>
											</div>
										</div>
										<div class="col-5">
											<div class="row">
												<div class="col-xl-4 head_po"> <label
														class="form-label">District</label></div>
												<div class="col-xl-1">:</div>
												<div class="col-xl-7"><?php echo $con_district ?></div>
											</div>

											<div class="row">
												<div class="col-xl-4 head_po"> <label class="form-label">GST IN
														No</label></div>
												<div class="col-xl-1">:</div>
												<!-- <div class="col-xl-7"><?php echo $no_of_items ?></div> -->
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
														<th scope="col">Item Code</th>
														<th scope="col">Item Details</th>
														<th scope="col">Stock QTY</th>
														<th scope="col"> Con Assign QTY</th>
														<!-- <th scope="col">Invoice QTY</th> -->
														<!--<th scope="col">Request to Bill QTY </th>-->
														<!-- <th scope="col">Remaining QTY </th> -->
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
													// $where1 = " is_delete = '0' AND form_main_unique_id = $unique_id";
													$where1 = [
														// "is_delete" => '0',
														"form_main_unique_id" => $form_main_unique_id,
														"con_unique_id" => $consignee_unique_id
													];
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
																<td id="table_td"><?php echo $value['item_code']; ?></td>
																<td id="table_td"><?php echo $value['product']; ?></td>
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
													<!--<tr>-->
													<!--	<td>2</td>-->
													<!--	<td>002</td>-->
													<!--	<td>DELL</td>-->
													<!--	<td>20</td>-->
													<!--	<td> 0</td>-->
													<!--	<td>-->
													<!--		5-->
													<!--	</td>-->
													<!--	<td> 15 </td>-->
													<!--</tr>-->
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
						<div class="col-lg-6">
							<div class="row">

								<!-- <div class="col-md-3 head_po"><label class="form-label">Invoice Id</label></div>
							<div class="col-md-1">:</div>
							<div class="col-md-4"><?php echo $invoice_auto_id ?>
							</div> -->
								<div class="col-md-3 head_po ">
									<label class="form-label">Invoice No </label>
								</div>
								<div class="col-md-1">:</div>
								<div class="col-md-4">
									<!-- <input type="text" id="invoice_no" name="invoice_no" class="form-control mb-2"
										value="<?php echo $invoice_no; ?>" required> -->
										<label id="invoice_no" name="invoice_no" class=" mb-2">
                                        <?php echo $invoice_no; ?>
                                        </label>
	
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3 head_po">
									<label class="form-label">Invoice Date</label>
								</div>
								<div class="col-md-1">:</div>
								<div class="col-md-4">
									<!-- <input type="date" id="invoice_date_1" name="invoice_date_1" class="form-control"
										value="<?php echo $result_values[0]["invoice_date"]; ?>" required> -->
										<label id="invoice_date_1" name="invoice_date_1" >
                                        <?php echo $result_values[0]["invoice_date"]; ?>
                                        </label>


								</div>

							</div><br>
							<div class="row">
								<div class="col-md-3 head_po"><label class="form-label">Consignee Name</label></div>
								<div class="col-md-1">:</div>
								<div class="col-md-4"><?php echo $con_contact_name ?></div>
							</div>


						</div>

						<div class="col-lg-6">

							<div class="row">
								<div class="col-md-3 head_po">
									<label class="form-label">Ledger Name</label>
								</div>
								<div class="col-md-1">:</div>
								<div class="col-md-4">
									<!-- <input type="text" id="ledger_name" name="ledger_name" class="form-control"
										value="<?php echo $ledger_name; ?>" required> -->
										<label id="ledger_name" name="ledger_name" class="mb-2">
                                        <?php echo $ledger_name; ?>
                                         </label>

								</div>
							</div><br>
							<div class="row">
								<div class="col-md-3 head_po">
									<label class="form-label">Ledger No.</label>
								</div>
								<div class="col-md-1">:</div>
								<div class="col-md-4">
									<!-- <input type="text" id="ledger_no" name="ledger_no" class="form-control"
										value="<?php echo $ledger_no; ?>" required> -->
										<label id="ledger_no" name="ledger_no" class="mb-2">
                                        <?php echo $ledger_no; ?>
                                        </label>

								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3 head_po"><label class="form-label">Consignee Address</label></div>
								<div class="col-md-1">:</div>
								<div class="col-md-4"><?php echo $con_address ?></div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="row">
								<p class="mb-0"><b>Attachment List</b></p>
								<!-- <div class="col-xl-3">
									<label class="form-label">Dc</label> -->
									<!--<input type="file" id="test_file_exp" multiple name="test_file_exp[]" class="form-control dropify" value="<?php echo $doc_name; ?>">-->
									<!-- <input class="form-control" id="dc_file_name" type="file" name="dc_file_name[]"
										accept="application/pdf" value="<?php echo $dc_file_name; ?>">
								</div>
								<div class="col-xl-3">
									<label class="form-label">IR</label>
									<input class="form-control" id="ir_file_name" type="file" name="ir_file_name[]"
										accept="application/pdf" value="<?php echo $ir_file_name; ?>">
								</div>
								<div class="col-xl-3">
									<label class="form-label">ELCOT Invoice</label>
									<input class="form-control" id="file_invoice" type="file" name="file_invoice[]"
										accept="application/pdf" value="<?php echo $file_invoice; ?>">
									<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control"
										value="<?php echo $unique_id; ?>">
								</div>
								<div class="col-xl-3 mt-4">
									<div class="mb-3">
										<button type="button"
											class="btn btn-primary btn-label rounded-pill invoice_details_add_update_btn"
											onclick="invoice_details();invoice_update();">
											<i
												class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
											Add New</button>
									</div> -->
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
								<th scope="col">Invoice No</th>
								<th scope="col">Invoice Date</th>
								<th scope="col">DC Attachment</th>
								<th scope="col">IR Attachment</th>
								<th scope="col">Inv. Attachment</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<!--<tr>-->
							<!--	<td>1</td>-->
							<!--	<td>10</td>-->
							<!--	<td>001</td>-->
							<!--	<td>Cash & 5342</td>-->
							<!--	<td>4422</td>-->
							<!--	<td>03-11-2023</td>-->
							<!--	<td> DC</td>-->
							<!--</tr>-->
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
								<th scope="col">Item Code</th>
								<th scope="col">Product Name</th>
								<!--<th scope="col">PO QTY</th>-->
								<th scope="col">Stock QTY</th>
								<!--<th scope="col">Old Billed QTY</th>-->
								<th scope="col">Invoice Bill QTY </th>
								<th scope="col">Remaining QTY</th>
								<th scope="col">Serial No</th>
							</tr>
						</thead>
						<tbody>
							<!--<tr>-->
							<!--	<td>1</td>-->
							<!--	<td>001</td>-->
							<!--	<td>Lenovo Thinkpad</td>-->
							<!--	<td>5</td>-->
							<!--	<td> 0</td>-->
							<!--	<td>-->
							<!--		<div class="">-->
							<!--			<input type="text" id="state_name" name="state_name" class="form-control" value="2" required="">-->
							<!--		</div>-->
							<!--	</td>-->
							<!--</tr>-->
							<?php
							$where1 = "po_unique_id = '" . $form_main_unique_id . "' AND consignee_id = '" . $consignee_unique_id . "'";
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
									// $prouduct = $product['product'];
									//  $poruductWithoutSpaces = str_replace(' ', '', $prouduct);
									//  print_r($poruductWithoutSpaces);
							
									$rem_qty = $product['item_qty'] - $product['invoice_qty'];
									?>
									<tr>
										<td><?php echo $s_no; ?></td>
										<td><?php echo $product['item_code']; ?></td>
										<td><?php echo $product['product']; ?></td>
										<td><?php echo $product['item_qty']; ?></td>
										<td><?php echo $product['invoice_qty']; ?></td>
										<td><?php echo $rem_qty; ?></td>
											<td><?php echo $product['ser_no']; ?></td>
										<!--	<td>-->
										<!--	<div class="">-->
										<!--<input type="text" id="invoice_qty" name="invoice_qty[]" class="form-control" required="" value="<?php echo $product['invoice_qty']; ?>">-->
										<!--<input type="text" id="po_unique_id" name="po_unique_id" value="<?php echo $unique_id; ?>">  -->
										<!--   						 <input type="text" id="po_num" name="po_num" value="<?php echo $po_num; ?>">-->
										<!--   						   <input type="text" id="po_date" name="po_date" value="<?php echo $po_date; ?>">-->
										<!--   						    <input type="text" id="executive_name" name="executive_name" value="<?php echo $executive_name; ?>">-->
										<!--<input type="text" id="no_of_consignee" name="no_of_consignee" value="<?php echo $no_of_consignee; ?>">-->
										<!--   						    <input type="text" id="consignee_id" name="consignee_id" value="<?php echo $consignee; ?>">-->
										<!--   						    <input type="text" id="ledger_name" name="ledger_name" value="<?php echo $ledger_name; ?>">-->
										<!--             <input type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_no; ?>">-->
										<!--   						    <input type="text" id="invoice_date" name="invoice_date" value="<?php echo $invoice_date; ?>">-->
										<!--   						     <input type="text" id="item_code" name="item_code[]" value="<?php echo $product['item_code']; ?>">-->
										<!--             <input type="text" id="product" name="product[]" value="<?php echo $product['product']; ?>">-->
										<!--   						    <input type="text" id="item_qty" name="item_qty[]" value="<?php echo $product['item_qty']; ?>">-->
										<!--	</div>-->
										<!--</td>-->
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
?>
</script>
