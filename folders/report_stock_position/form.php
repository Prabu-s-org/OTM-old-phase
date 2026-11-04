<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;

if (isset($_GET["unique_id"])) {
	if (!empty($_GET["unique_id"])) {

		// $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
		// $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

		$unique_id  = $_GET["unique_id"];
		$where      = [
			"unique_id" => $unique_id
		];


		$table      =  "view_stock_position_list";

		$columns    = [
			"po_unique_id",
			"po_num",
            "po_date",
            // "department",
            "(SELECT department FROM department_creation AS department_creation WHERE department_creation.unique_id = ".$table.".department ) AS department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name ) AS executive_name",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            "status",
            //  "(SELECT stock_id FROM stock_position WHERE stock_position.form_main_unique_id = ".$table.".unique_id ) AS stock_id",
            "unique_id"
		];

		$table_details   = [
			$table,
			$columns
		];

		$result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);
		if ($result_values->status) {

			$result_values      = $result_values->data;

			$po_unique_id          = $result_values[0]["po_unique_id"];
			$po_num    = $result_values[0]["po_num"];
			// $po_date          = $result_values[0]["po_date"];
			$department          = $result_values[0]["department"];
			$executive_name    = $result_values[0]["executive_name"];
			$no_of_consignee          = $result_values[0]["no_of_consignee"];
			$no_of_po          = $result_values[0]["no_of_po"];
			$qty    = $result_values[0]["qty"];
			$net_value          = $result_values[0]["net_value"];
			$status          = $result_values[0]["status"];
		     $stock_id          = $result_values[0]["stock_id"];
			$under_user_type    = $result_values[0]["under_user_type"];
			$main_unique_id          = $result_values[0]["unique_id"];

            $exe_unique_id = $result_values[0]["executive_name"];
			$orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));


			// if($status == 0){
			// 	print_r('ji');
			// }

			$btn_text           = "Update";
			$btn_action         = "update";
		} else {
			$btn_text           = "Error";
			$btn_action         = "error";
			$is_btn_disable     = "disabled='disabled'";
		}
	}
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);


?>

<style>
	.head_po {
		font-size: .875rem;
		margin-bottom: .3125rem;
	}
</style>

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Stock Position Form</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active"> Stock Position </li>
				</ol>
			</div>

		</div>
	</div>
</div>



<div class="row cf">
	<div class="col-12">
		<div class="card">
			<div class="card-body mt-1">
				<form class="was-validated" autocomplete="off">
					<div class="col-12">
						<div class="row">
							<div class="col-4">
								<div class="row">
									<div class="col-xl-4 head_po"> <label  class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $po_num; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $po_date; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">Executive Name</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $executive_name; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">No of Consignee</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $no_of_consignee; ?></div>
								</div>

							</div>

							<div class="col-4">
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">No of Items in PO</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $no_of_po; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">QTY</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $qty; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label class="form-label">Net Value</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $net_value; ?></div>
									<input type="hidden" id="department" name="department"
												class="form-control" value="<?php echo $department;?>">
									
								</div>
							</div>
							<!-- <div class="col-4">
							<div class="row">
									<div class="col-xl-4 head_po"><label class="form-label"><b>Stock Id</b></label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><b><?php echo $stock_id; ?></b></div>
								</div>
                            </div> -->
							
						</div>
					</div>

					

					<div class="row">
						
						<div class="col-12 mt-3">
							<div class="table-responsive mb-4">

								<table class="table table-striped table-bordered align-middle table mb-0 small_table">
									<thead class="table-light">
										<tr>
											<th>S.No</th>
											<th scope="col">Item Code</th>
											<th scope="col">Item Details</th>
											<th scope="col">Item Specification</th>
											<th scope="col">QTY</th>
											
										
											<!--<th scope="col">Billed QTY</th>-->
											<th scope="col">Request to Stock QTY </th>
											<th scope="col">Remaining QTY</th>
											<th scope="col">Part No</th>
											<th scope="col">Delivery Due Days</th>
											<th scope="col">Delivery Due Date</th>
											


										</tr>
									</thead>
									<tbody>
										
										
									<?php

						// $where2 = "form_main_unique_id = '".$main_unique_id."'";

						$get_stock_position   = get_stock_position($main_unique_id);
						// print_r($get_stock_position);
						foreach($get_stock_position as $key => $form_val){
							// print_r($form_val);
							if(($form_val['form_main_unique_id'] == '') && ($form_val['product_count'] == 0)){
								// print_r('hi');
								$where1 = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."'";
								$table1      =  "product_details_sub";
						
								$columns1    = [
									// "item_code",
									"(SELECT item_code FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code ) AS item_code ",
									// "(SELECT item_description FROM item_creation_sub AS dis WHERE dis.unique_id = ' . $table1 . '.item_code ) AS item_code ",
									"product",
									"(SELECT item_specification FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code ) AS item_specification ",
									"qty",
									"billed_qty",
									"tax",
									"unit_price",
									"form_main_unique_id",
									"unique_id",
									"delivery_due_dates",
									"(SELECT po_date FROM po_form WHERE po_form.unique_id = $table1.form_main_unique_id  group by  form_main_unique_id) AS po_date_wise_product ",
                                    "(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = $table1.form_main_unique_id group by  form_main_unique_id) AS delivery_due_dates_org ",
									
								   ];
						
								$table_details1   = [
									$table1,
									$columns1
								];
							}else{
								// print_r('hello');
								$where1 = "is_delete = '0' AND form_main_unique_id = '".$form_val['form_main_unique_id']."'";
								$table1      =  "stock_position";
						
								$columns1    = [
									"item_code",
									// "(SELECT item_code FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code ) AS item_code ",
									"product",
									"item_qty",
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
									"part_no",
									"(select sum(stock_value) from stock_position_main where form_main_unique_id=$table1.form_main_unique_id group by form_main_unique_id) AS stock_value",
		
									"unique_id",
									"stock_id",
									"unit_price",
									"product_tax",
									"(select stock_date from stock_position_main where form_main_unique_id=$table1.form_main_unique_id )AS stock_date_1",
									"(select sum(stock_qty) from stock_position_main where form_main_unique_id=$table1.form_main_unique_id group by form_main_unique_id) AS stock_qty_1",
									"(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = $table1.form_main_unique_id ) AS delivery_due_dates",
									"(SELECT delivery_due_dates FROM po_form WHERE po_form.unique_id = $table1.form_main_unique_id group by  form_main_unique_id) AS delivery_due_dates_org ",
									
									
								   ];
						
								$table_details1   = [
									$table1,
									$columns1
								];
							
							}
						
                        $values_product  = $pdo->select($table_details1, $where1);
                        // print_r($values_product);
                                               if ($values_product->status) {
               
                                                   $product_array      = $values_product->data;
                               
                                               foreach($product_array as $key => $product) {
                                                   $product[ 's_no' ] = $sno + 1;

												   if($product['product_unique_id']){
													// print_r($product['product_unique_id']);
													$remaining_qty = $product[ 'item_qty' ] - $product['stock_qty'];
													if($product['billed_qty']){
														$billed_qty = $product['billed_qty'];
													}else{
														$billed_qty = '0';
													}


													// $po_date_2 = $product['po_date']; // e.g., '2024-12-31'
										
										// New changes start
$po_date_2 = $product['po_date']; // Example: '12-03-2024'
$delivery_due_days_1 = $product['delivery_due_dates'];
$delivery_due_days_2 = $product['delivery_due_dates_org'];

if ($delivery_due_days_1 != '') {
    $delivery_due_days = (int)$product['delivery_due_dates'];
} else {
    $delivery_due_days = (int)$product['delivery_due_dates_org'];
}

// Print the PO date for reference
$product_po_date = '<span class="po_date">' . $po_date_2 . '</span>';

// Create DateTime object from the PO date in 'd-m-Y' format
$poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date_2));

// Modify the date by adding delivery due days
$poDate->modify('+' . $delivery_due_days . ' days');

// Format the resulting date in 'd-m-Y'
$resultDate = $poDate->format('d-m-Y');

// Get the current date
$currentDate = new DateTime();

if ($poDate < $currentDate) {
    $product['delivery_due_dates'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
} else {
    $product['delivery_due_dates'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
}

										// end 
																
															
																?>
										<tr>
											<td><?php echo $product['s_no' ]?></td>
											<td><?php echo $product['item_code']?></td>
											<td><?php echo $product['product']?></td>
											
											<td><?php echo $product['item_specification']?></td>
                                            <td><?php echo $product['item_qty']?></td>
											<!--<td><?php echo $billed_qty;?></td>-->
											<td>
												<div class="">
												<input type="hidden" id="unique_id" name="unique_id[]"
												class="form-control" value="<?php echo $product['unique_id'];?>">
												<input type="hidden" id="unit_price" name="unit_price[]"
												class="form-control" value="<?php echo $product['unit_price'];?>">
												
											<input type="hidden" id="main_unique_id" name="main_unique_id"
												class="form-control" value="<?php echo $product['form_main_unique_id'];?>">
												<input type="hidden" id="product_unique_id" name="product_unique_id[]"
												class="form-control" value="<?php echo $product['product_unique_id'];?>">
                                                    <input type="hidden" id="stock_date" name="stock_date[]"
												class="form-control" value="<?php echo $today;?>">
                                            <input type="hidden" id="po_num" name="po_num"
                                            class="form-control" value="<?php echo $po_num;?>">
                                            <input type="hidden" id="po_unique_id" name="po_unique_id"
                                            class="form-control" value="<?php echo $po_unique_id;?>">
                                            
                                            <input type="hidden" id="po_date" name="po_date"
                                            class="form-control" value="<?php echo $po_date;?>">
                                            <input type="hidden" id="exe_name" name="exe_name"
                                            class="form-control" value="<?php echo $exe_unique_id;?>">
                                            <input type="hidden" id="no_of_items" name="no_of_items"
                                            class="form-control" value="<?php echo $no_of_po;?>">
                                            <input type="hidden" id="no_of_con" name="no_of_con"
                                            class="form-control" value="<?php echo $no_of_consignee;?>">

											<input type="hidden" id="total_qty" name="total_qty"
                                            class="form-control" value="<?php echo $qty;?>">
                                            <input type="hidden" id="net_value" name="net_value"
                                            class="form-control" value="<?php echo $net_value;?>">

                                            <input type="hidden" id="item_code" name="item_code[]"
                                            class="form-control" value="<?php echo $product['item_code'];?>">
                                            <input type="hidden" id="item_name" name="item_name[]"
                                            class="form-control" value="<?php echo $product[ 'product'];?>">
											<input type="hidden" id="item_qty" name="item_qty[]"
                                            class="form-control" value="<?php echo $product[ 'item_qty'];?>">

											<input type="hidden" id="billed_qty" name="billed_qty[]"
                                            class="form-control" value="<?php echo $billed_qty;?>">
											<input type="hidden" id="product_tax" name="product_tax[]"
                                            class="form-control" value="<?php echo $product[ 'product_tax'];?>">
											<input type="hidden" id="remaining_qty" name="remaining_qty[]"
                                            class="form-control" value="<?php echo $remaining_qty;?>">
											
											<?php if($unique_id!=''){ ?>
                                           <input type="text" id="stock_qty" name="stock_qty[]" class="form-control">
										   <input type="hidden" id="update_stock_value" name="update_stock_value[]" class="form-control">
										   <?php }  else{?>
											 <input type="text" id="stock_qty" name="stock_qty[]" class="form-control" value="<?php echo $product['stock_qty'];?>" required >
											 <input type="hidden" id="update_stock_value" name="update_stock_value[]" class="form-control" value="<?php echo $product['stock_value'];?>" required>
										 <?php  }
											?>

														<!-- <?php if ($unique_id != '') {
																		if ($remaining_qty == 0) { ?>
																			<input type="text" id="stock_qty" name="stock_qty[]"
																				class="form-control" value="<?php echo $remaining_qty; ?>" readonly>

																		<?php } else { ?>
																			<input type="text" id="stock_qty" name="stock_qty[]"
																				class="form-control" >
																		<?php }
																	} else { ?>
																		<input type="text" id="stock_qty" name="stock_qty[]"
																			class="form-control"
																			value="<?php echo $product['stock_qty']; ?>" required>
																	<?php }
																	?> -->
											 <input type="hidden" id="part_no" name="part_no[]"
                                            class="form-control" value="<?php echo $product['part_no'];?>">
											<input type="hidden" id="deleivery_due_dates" name="deleivery_due_dates[]"
                                            class="form-control" value="<?php echo $product['deleivery_due_dates'];?>">
                                           <!-- <input type="text" id="stock_qty" name="stock_qty[]" class="form-control" value="<?php echo $product[ 'stock_qty'];?>" required> -->
										   <input type="hidden" id="update_stock_qty" name="update_stock_qty[]" class="form-control" value="<?php echo $product['stock_qty'];?>" required>
										   <input type="hidden" id="update_stock_value" name="update_stock_value[]" class="form-control" value="<?php echo $product['stock_value'];?>" required>
										   <input type="hidden" name="delivery_due_date[]" id="delivery_due_date" value="<?php echo $resultDate; ?>">
	
										</div>
											</td>
											<td><?php if($remaining_qty){ echo $remaining_qty;}else{echo '0';}?></td>
											<td>
											  <input type="text" id="part_no" name="part_no[]" class="form-control">
											</td>
											<td><?php echo $delivery_due_days?></td>
															
						
											<td><?php echo $product['delivery_due_dates'];?></td>
															
										
										</tr>
										
										<?php }else{
											

										$remaining_qty = $product[ 'qty' ] - $product['stock_qty'];
										if($product['billed_qty']){
											$billed_qty = $product['billed_qty'];
										}else{
											$billed_qty = '0';
										} 
										
										$today = date("d-m-Y");
                                     // new changes start
										$po_date_2 = $product['po_date_wise_product']; // e.g., '2024-12-31'
										// print_r($po_date_2 );die();
										$delivery_due_days_1=$product['delivery_due_dates'];
										$delivery_due_days_2=$product['delivery_due_dates_org'];
										if($delivery_due_days_1!='')	{
											$delivery_due_days=(int)$product['delivery_due_dates'];
										}	
										else{					

									$delivery_due_days=(int)$product['delivery_due_dates_org'];
										}
									
									$product_po_date = '<span class="po_date">' . $po_date_2 . '</span>';

									$poDate = DateTime::createFromFormat('Y-m-d', strip_tags($po_date_2));

									// if (!$poDate) {
									//     echo "Invalid PO date format.";
									//     return;
									// }

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
											<td><?php echo $product['s_no']?></td>
											<td><?php echo $product['item_code']?></td>
											<td><?php echo $product['product']?></td>
											<td><?php echo $product['item_specification']?></td>
                                            <td><?php echo $product['qty']?></td>
											<!--<td><?php echo $billed_qty;?></td>-->
											<td>
												<div class="">
											<input type="hidden" id="unit_price" name="unit_price[]"
												class="form-control" value="<?php echo $product['unit_price'];?>" >
												
											<input type="hidden" id="unique_id" name="unique_id[]"
												class="form-control" >
											<input type="hidden" id="main_unique_id" name="main_unique_id"
												class="form-control" value="<?php echo $product['form_main_unique_id'];?>">
											<input type="hidden" id="product_unique_id" name="product_unique_id[]"
												class="form-control" value="<?php echo $product['unique_id'];?>">
                                            <input type="hidden" id="stock_date" name="stock_date[]"
												class="form-control" value="<?php echo $today;?>">
                                            <input type="hidden" id="po_num" name="po_num"
                                            class="form-control" value="<?php echo $po_num;?>">
                                            
                                            <input type="hidden" id="po_unique_id" name="po_unique_id"
                                            class="form-control" value="<?php echo $po_unique_id;?>">
                                            <input type="hidden" id="po_date" name="po_date"
                                            class="form-control" value="<?php echo $po_date;?>">
                                            <input type="hidden" id="exe_name" name="exe_name"
                                            class="form-control" value="<?php echo $exe_unique_id;?>">
                                            <input type="hidden" id="no_of_items" name="no_of_items"
                                            class="form-control" value="<?php echo $no_of_po;?>">
                                            <input type="hidden" id="no_of_con" name="no_of_con"
                                            class="form-control" value="<?php echo $no_of_consignee;?>">

											<input type="hidden" id="total_qty" name="total_qty"
                                            class="form-control" value="<?php echo $qty;?>">
                                            <input type="hidden" id="net_value" name="net_value"
                                            class="form-control" value="<?php echo $net_value;?>">

                                            <input type="hidden" id="item_code" name="item_code[]"
                                            class="form-control" value="<?php echo $product[ 'item_code'];?>">
                                            <input type="hidden" id="item_name" name="item_name[]"
                                            class="form-control" value="<?php echo $product[ 'product'];?>">
											<input type="hidden" id="item_qty" name="item_qty[]"
                                            class="form-control" value="<?php echo $product[ 'qty'];?>">
											<input type="hidden" id="product_tax" name="product_tax[]"
                                            class="form-control" value="<?php echo $product[ 'tax'];?>">
											<input type="hidden" id="billed_qty" name="billed_qty[]"
                                            class="form-control" value="<?php echo $billed_qty;?>">

											<!-- <input type="hidden" id="remaining_qty" name="remaining_qty[]"
                                            class="form-control" value="<?php echo $remaining_qty;?>"> -->

                                           <input type="text" id="stock_qty" name="stock_qty[]" class="form-control" value="<?php echo $product['stock_qty'];?>" required onkeyup="rem_qty()">
										   
									<input type="hidden" id="update_stock_qty" name="update_stock_qty[]" class="form-control" value="<?php echo $product['stock_qty'];?>" required>
									<input type="hidden" id="update_stock_value" name="update_stock_value[]" class="form-control" value="<?php echo $product['stock_value'];?>" required>
									<input type="hidden" name="delivery_due_date[]" id="delivery_due_date" value="<?php echo $resultDate; ?>">

												</div>
											</td>
											
											
											<td>
												<?php if($product['stock_qty']){echo $remaining_qty; } else{
													echo '<input type="text" id="remaining_qty" name="remaining_qty[]"
                                            class="form-control" readonly>';
											 } ?>
										</td>
										<td>
											<input type="text" id="part_no" name="part_no[]" class="form-control">
															</td>
															<td><?php echo $delivery_due_days?></td>
															
															<td><?php echo $product['delivery_due_dates'];?></td>
															
										<!-- new code beta success after uncomment -->
										<!-- <td>
											<input type="text" id="part_no" name="part_no[]"
                                            class="form-control" value="<?php echo $product['part_no'];?>">
											</td> -->
										<!-- <?php if($remaining_qty){ echo $remaining_qty;}else{echo '0';}?> -->
										</tr>
							<?php
                            $sno ++;
						}
					}
                }
			}
            
										
										?>
									</tbody>
								</table>

							</div>
							<div class="row">
								<div class="col-xl-3">
									<label for="exampleInputdate" class="form-label">Remarks</label>
									<!-- <div class="mb-3"> -->

									<textarea id="remarks" name="remarks"
										class="form-control "> <?php echo $remarks ?></textarea>
									<!-- </div> -->
								</div>
								<div class="col-xl-3" id="images">
									<div class="mb-3">
										<label class="form-label">Part No Attachment</label>

										<input type="file" id="part_no_file" accept="application/image"
											name="part_no_file" class="form-control "
											value="<?php echo $part_no_file; ?>">
									</div>
								</div>
							</div>
							<div class="form-group row ">
								<div class="col-md-12" align="right">
									<!-- Cancel,save and update Buttons -->
									<?php echo btn_cancel($btn_cancel); ?>
									<?php if($product['product_unique_id'] != ''){?>
										<button type="button" class="btn btn-primary " onclick="create()">Update For Invoice</button>
									<?php } else{?>
										<button type="button" class="btn btn-primary " onclick="create()">Request For Invoice</button>
									<?php } ?>


								</div>
								<!-- <div>
								<?php if($product['product_unique_id'] != ''){?>
								<div style="margin-left:150px"><span style='color: red;'><b></b>Stock Already Entered<b> </b><b> <?php echo $product['stock_date_1'];?> </b> QTY <?php echo $product['stock_qty_1'];?> </span></div>
								<?php }?>
								</div> -->
								<div>
									<div class="col-12 mt-2">
										<div class="table-responsive mb-4">
											<table
												class="table table-striped table-bordered align-middle  mb-0 small_table">
												<thead class="table-light">
													<tr>
														<th>S.No</th>
														<th scope="col">Item Code</th>
														<th scope="col">Item Details</th>
														<th scope="col">Item Specification</th>
														<th scope="col">Item QTY</th>

														<th scope="col">Stock QTY</th>
														<th scope="col">Stock Date</th>
														<th scope="col">Part NO</th>

													</tr>
												</thead>
												<tbody>
													<?php
													$where1 = "form_main_unique_id = '" . $unique_id . "'";
													// print_r($where1); die();
													$table1 = "stock_position_sublist";
													$columns1 = [
														"item_code",
														"product",
														// "item_specification",
														//    "item_qty",
														// "(SELECT item_specification FROM item_creation_sub WHERE item_creation_sub.unique_id = $table1.item_code ) AS item_specification ",
														"(select item_specification from item_creation_sub WHERE item_creation_sub.unique_id=$table1.item_code)as item_specification",

														"item_qty",

														"stock_qty",
														"stock_date",
														"part_no",
														"unique_id",
														"form_main_unique_id"

													];
													$table_details1 = [
														$table1,
														$columns1
													];
													$values_product = $pdo->select($table_details1, $where1);
													// print_r($values_product);die();
													$j = 1;
													if ($values_product->status) {
														$product_array = $values_product->data;
														//   print_r($product_array);
													
														$btn_update = btn_update($folder_name, $value['unique_id']);
														foreach ($product_array as $key => $product) {
															// $product['po_unique_id']='<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';
						
															// $product['po_unique_id'] = $product['stock_qty']- $product['invoice_qty'];
															//   $s_no = $sno + 1;
															?>

															<tr>
																<td><?php echo $j; ?></td>
																<td><?php echo $product['item_code'] ?></td>
																<td><?php echo $product['product'] ?></td>
																<td><?php echo $product['item_specification'] ?></td>
																<td><?php echo $product['item_qty'] ?></td>
																<td><?php echo $product['stock_qty'] ?></td>
																<td><?php echo $product['stock_date'] ?></td>
																<td><?php echo $product['part_no'] ?></td>
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




<!--===================================================processing table============================================-->


<!--==================================================end============================================================-->
<script>

	function rem_qty(){
        var stock_qty = document.getElementsByName('stock_qty[]');
		var item_qty = document.getElementsByName('item_qty[]');
		var rem_qty = document.getElementsByName('remaining_qty[]');

		for (var i = 0; i < stock_qty.length; i++){
			var stock_qty_val = stock_qty[i].value;
			var item_qty_val = item_qty[i].value;

			var rem_val = item_qty_val - stock_qty_val;
			var rem_qty_val = rem_qty[i];
			rem_qty_val.value = rem_val;

		}

	}

	
// 	function create(){
// 		var internet_status = is_online();
		
// 		var unique_id = document.getElementById('unique_id').value;
// 	    var stock_date= document.getElementById('stock_date').value;
//         var po_date= document.getElementById('po_date').value;
//         var main_unique_id = document.getElementById('main_unique_id').value;
//         var po_num= document.getElementById('po_num').value;
// 		// var po_num_get = encodeURIComponent(po_num);
// 		// alert(po_num);
//         var exe_name= document.getElementById('exe_name').value;
//         var no_of_items = document.getElementById('no_of_items').value;
//         var po_auto_id = document.getElementById('po_unique_id').value;
//         var no_of_con= document.getElementById('no_of_con').value;
//         var department= document.getElementById('department').value;
		
// 		var item_qty = document.getElementsByName('item_qty[]');
// 		var remarks = document.getElementById('remarks').value;
// 		var part_no_file = document.getElementById('part_no_file').files;

		
//         var stock_qty = document.getElementsByName('stock_qty[]');
// 		var update_stock = document.getElementsByName('update_stock_qty[]');
// 		var update_stock_value = document.getElementsByName('update_stock_value[]');
// 		var part_no = document.getElementsByName('part_no[]');
//         var stock_qty_total = [];
// 		var item_qty_total = [];
//         var stock_qty_amt = [];
// 		var update_stock_qty_amt = [];
// 		var update_qty_amt = [];
// 		// alert(part_no);
//         // Check if any stock quantity field is empty
		
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
//         for (var i = 0; i < stock_qty.length; i++){
//             var stock_qty_val = stock_qty[i].value;
//             var unit_price= document.getElementsByName('unit_price[]');
// 			var product_tax= document.getElementsByName('product_tax[]');
// 			var unique_id = document.getElementsByName('unique_id[]');
// 			var unit_price_val = unit_price[i].value;
//             var unique_id = unique_id[i].value;
// 			var product_tax_val = product_tax[i].value;
// 			var part_no_val = part_no[i].value;
// 			// alert(update_stock_qty);
// 		// ===start=====update amount===========
// 		var update_stock_qty = update_stock[i].value;

// 		var mul_1 = update_stock_qty * unit_price_val;
// 		var mul_val_1 = product_tax_val / 100;
// 		var mul_val1_1 = mul_1 * mul_val_1;

// 		var mul_add_val1_1 = mul_1 + mul_val1_1;
// 		// =======================end=================================
//             var mul = stock_qty_val * unit_price_val;
// 			var mul_val = product_tax_val / 100;
// 			var mul_val1 = mul * mul_val;

// 			var mul_add_val = mul + mul_val1;
// 			// alert(mul_add_val);

// 			var item_qty_val = item_qty[i].value;
// 			var number = parseFloat(item_qty_val);
//             if (!isNaN(number)) {
//               item_qty_total.push(number);
//               var sum_of_item_qty = item_qty_total.reduce(function (total, current) {
//                 return total + current;
//               },0);
              
//             }
// 			// var update_stock_qty = update_stock[i].value;
// 			var number = parseFloat(update_stock_qty);
//             if (!isNaN(number)) {
// 				update_qty_amt.push(number);
//               var sum_of_update_qty = update_qty_amt.reduce(function (total, current) {
//                 return total + current;
//               },0);
              
//             }
// 			// alert(sum_of_update_qty);
//          // amount of value calculate
//             var amount = parseFloat(mul_add_val);
//             if (!isNaN(amount)) {
//               stock_qty_amt.push(amount);
//               var sum_of_stock_value = stock_qty_amt.reduce(function (total, current) {
//                 return total + current;
//               },0);
              
//             } 

// 			var amount1 = parseFloat(mul_add_val1_1);

// 			// alert(amount1);
//             if (!isNaN(amount1)) {
//               update_stock_qty_amt.push(amount1);
//               var sum_of_update_stock_value = update_stock_qty_amt.reduce(function (total, current) {
//                 return total + current;
//               },0);
              
//             } 

//             // total qty calculate
//             var number = parseFloat(stock_qty_val);
//             if (!isNaN(number)) {
//               stock_qty_total.push(number);
//               var sum_of_stock_qty = stock_qty_total.reduce(function (total, current) {
//                 return total + current;
//               },0);
              
//             } else {
//               alert('Please enter a valid number.');
//             }
//         }
	      
//         if(sum_of_item_qty >= sum_of_stock_qty){
// 			// alert(sum_of_stock_value);
// 			var total_amount = sum_of_stock_value;
// 			var update_total_amount = sum_of_update_stock_value;

// 			var data = "stock_date="+stock_date+"&main_unique_id="+main_unique_id+"&po_date="+po_date+"&po_num="+po_num_get+"&po_auto_id="+po_auto_id + "&exe_name=" + exe_name + "&no_of_items=" + no_of_items + "&no_of_con=" + no_of_con + "&department=" + department + "&stock_qty=" + sum_of_stock_qty+ "&unique_id=" + unique_id +"&item_qty=" + sum_of_item_qty + "&total_amount="+total_amount+"&update_total_amount="+update_total_amount+"&update_stock_qty="+ sum_of_update_qty+"&part_no_val="+part_no;
// 			data += "&action=stock_position_create";

// 			var ajax_url = sessionStorage.getItem("folder_crud_link");
// 				var url      = sessionStorage.getItem("list_link");
// 				$.ajax({
// 					type: "POST",
// 					url: ajax_url,
// 					data: data,
// 					beforeSend: function() {
// 						$(".po_delivery_add_update_btn").attr("disabled", "disabled");
// 						$(".po_delivery_add_update_btn").text("Loading...");
// 					},
// 					success: function(data) {
// 						var obj = JSON.parse(data);
//                         var msg = obj.msg;
//                         var status = obj.status;
//                         var error = obj.error;
//                         // alert(msg);
//                         if (!status) {
// 					url 	= '';
//                     $(".createupdate_btn").text("Error");
//                     console.log(error);
// 				} else {
// 					if (msg=="already") {
// 						// Button Change Attribute
// 						url 		= '';

// 						$(".createupdate_btn").removeAttr("disabled","disabled");
// 						if (unique_id) {
// 							$(".createupdate_btn").text("Update");
// 						} else {
// 							$(".createupdate_btn").text("Save");
// 						}
// 					}
// 				}
			
//                         sweetalert(msg,url);
// 						//alert(data);
// 						stock_creation_sub();
// 					stock_position_sublist();

			
// 				},
// 				error: function(data) {
// 					alert("Network Error");
// 				}
// 			});
// 			}else{
// 					alert("Enter Valid Product Quantity..");
// 				// alert('hello');
// 			}
        
   
// 	}
function create() {
		var internet_status = is_online();

		var unique_id = document.getElementById('unique_id').value;
		var stock_date = document.getElementById('stock_date').value;
		var po_date = document.getElementById('po_date').value;
		var main_unique_id = document.getElementById('main_unique_id').value;
		var po_num = document.getElementById('po_num').value;
		// var po_num_get = encodeURIComponent(po_num);
		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var po_auto_id = document.getElementById('po_unique_id').value;
		var no_of_con = document.getElementById('no_of_con').value;
		var department = document.getElementById('department').value;
		var remarks = document.getElementById('remarks').value;
		var part_no_file = document.getElementById('part_no_file').files;

		var item_qty = document.getElementsByName('item_qty[]');
		var stock_qty = document.getElementsByName('stock_qty[]');
		var update_stock = document.getElementsByName('update_stock_qty[]');
		var part_no = document.getElementsByName('part_no[]');
		var unit_price = document.getElementsByName('unit_price[]');
		var product_tax = document.getElementsByName('product_tax[]');
		var unique_id_list = document.getElementsByName('unique_id[]');

		var stock_qty_total = [];
		var item_qty_total = [];
		var stock_qty_amt = [];
		var update_qty_amt = [];

		var anyStockQtyEmpty = false;
		for (var i = 0; i < stock_qty.length; i++) {
			if (stock_qty[i].value === '') {
				anyStockQtyEmpty = true;
				break;
			}
		}
		if (unique_id == '' && anyStockQtyEmpty) {
			Swal.fire({
				icon: 'error',
				text: 'Please enter stock quantity for all items.',
			});
			return;
		}

		for (var i = 0; i < stock_qty.length; i++) {
			var stock_qty_val = parseFloat(stock_qty[i].value);
			var unit_price_val = parseFloat(unit_price[i].value);
			var product_tax_val = parseFloat(product_tax[i].value);
			var unique_id_val = unique_id_list[i].value;
			var part_no_val = part_no[i].value;

			var mul = stock_qty_val * unit_price_val;
			var mul_val = product_tax_val / 100;
			var mul_val1 = mul * mul_val;
			var mul_add_val = mul + mul_val1;

			var item_qty_val = parseFloat(item_qty[i].value);
			if (!isNaN(item_qty_val)) {
				item_qty_total.push(item_qty_val);
			}

			var update_stock_qty = parseFloat(update_stock[i].value);
			if (!isNaN(update_stock_qty)) {
				update_qty_amt.push(update_stock_qty);
			}

			var amount = parseFloat(mul_add_val);
			if (!isNaN(amount)) {
				stock_qty_amt.push(amount);
			}

			if (!isNaN(stock_qty_val)) {
				stock_qty_total.push(stock_qty_val);
			}
		}

		var sum_of_item_qty = item_qty_total.reduce((total, current) => total + current, 0);
		var sum_of_update_qty = update_qty_amt.reduce((total, current) => total + current, 0);
		var sum_of_stock_value = stock_qty_amt.reduce((total, current) => total + current, 0);
		var sum_of_stock_qty = stock_qty_total.reduce((total, current) => total + current, 0);

		if (sum_of_item_qty >= sum_of_stock_qty) {
			var total_amount = sum_of_stock_value;

			var data = new FormData();
			data.append("stock_date", stock_date);
			data.append("main_unique_id", main_unique_id);
			data.append("po_date", po_date);
			data.append("po_num", po_num);
			data.append("po_auto_id", po_auto_id);
			data.append("exe_name", exe_name);
			data.append("no_of_items", no_of_items);
			data.append("no_of_con", no_of_con);
			data.append("department", department);
			data.append("stock_qty", sum_of_stock_qty);
			data.append("unique_id", unique_id);
			data.append("item_qty", sum_of_item_qty);
			data.append("total_amount", total_amount);
			data.append("update_stock_qty", sum_of_update_qty);
			data.append("part_no_val", part_no_val);
			data.append("remarks", remarks);

			if (part_no_file.length > 0) {
				for (var i = 0; i < part_no_file.length; i++) {
					data.append("part_no_file", part_no_file[i]);
				}
			} else {
				data.append("part_no_file", '');
			}

			data.append("action", "stock_position_create");

			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url = sessionStorage.getItem("list_link");

			$.ajax({
				type: "POST",

				url: ajax_url,
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				success: function (data) {
					// alert(data);
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
							url = '';
							$(".createupdate_btn").removeAttr("disabled", "disabled");
							if (unique_id) {
								$(".createupdate_btn").text("Update");
							}
						}
					}
					sweetalert(msg, url);
					stock_creation_sub();
					stock_position_sublist();

				},
				error: function (data) {
					alert("Network Error");
				}
			});
		} else {
			alert('Please enter a valid number.');
		}
	}

	function stock_creation_sub(){
	    
	    var stock_qty = document.getElementsByName('stock_qty[]');
 
    for (var i = 0; i < stock_qty.length; i++){
                var stock_qty_val = stock_qty[i].value;
                                
                if(stock_qty_val != ''){
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
					var update_stock= document.getElementsByName('update_stock_qty[]');
					var part_no= document.getElementsByName('part_no[]');
					
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
                        

                    var po_date= document.getElementById('po_date').value;
                    var total_qty= document.getElementById('total_qty').value;
                    var net_value= document.getElementById('net_value').value;
                    var stock_date= document.getElementById('stock_date').value;
					var unique_id= document.getElementById('unique_id').value;
		        // alert(unique_id);
        var po_auto_id = document.getElementById('po_unique_id').value;

                    var main_unique_id = document.getElementById('main_unique_id').value;
                    var po_num= document.getElementById('po_num').value;
					// var po_num_get = encodeURIComponent(po_num);

                    var exe_name= document.getElementById('exe_name').value;
                    var no_of_items = document.getElementById('no_of_items').value;
                    var no_of_con= document.getElementById('no_of_con').value;
					// var update_stock_qty= document.getElementById('update_stock_qty').value;

                    // var data = "unique_id=" +unique_id_val + "&main_unique_id=" + main_unique_id +
					//  "&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" + 
					//  item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val + 
					//  "&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val +"&po_num=" + po_num_get + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date+ "&unique_id=" + unique_id + "&unit_price=" + unit_price + "&product_tax=" + product_tax+"&update_stock_qty=" + update_stock_qty+"&part_no_val=" + part_no;

					var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id +
					"&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" +
					item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val +
					"&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + 
					product_unique_id_val + "&po_num=" + po_num + "&po_auto_id=" + po_auto_id + 
					"&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" 
					+ no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + 
					"&unique_id=" + unique_id + "&unit_price=" + unit_price + "&product_tax=" + product_tax + "&update_stock_qty="
					 + update_stock_qty + "&part_no_val=" + part_no_val;








                    data += "&action=stock_position_add_update";

                    var ajax_url = sessionStorage.getItem("folder_crud_link");
					var url      = sessionStorage.getItem("list_link");

            
                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        beforeSend: function() {
                            $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                            $(".po_delivery_add_update_btn").text("Loading...");
                        },
                        success: function(data) {
                            // alert(data);
         
                        var obj = JSON.parse(data);
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;
                        // alert(msg);
                        if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} else {
							$(".createupdate_btn").text("Save");
						}
					}
				}
				// location.reload();
                        sweetalert(msg,url);
                    },
                    error: function(data) {
                        alert("Network Error");
                    }
                });
            }
        }
	}

	function stock_position_sublist() {

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
		var delivery_due_date = document.getElementsByName('delivery_due_date[]');
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
		var delivery_due_date = delivery_due_date[i].value;
		var part_no_val = part_no[i].value;
		// alert(delivery_due_date);


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
		// var po_num_get = encodeURIComponent(po_num);

		var exe_name = document.getElementById('exe_name').value;
		var no_of_items = document.getElementById('no_of_items').value;
		var no_of_con = document.getElementById('no_of_con').value;
		// var update_stock_qty= document.getElementById('update_stock_qty').value;

		// var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id +
		// 	"&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" +
		// 	item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val +
		// 	"&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val + "&po_num=" + po_num_get + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + "&unique_id=" + unique_id + "&unit_price=" + unit_price + "&product_tax=" + product_tax + "&update_stock_qty=" + update_stock_qty + "&part_no_val=" + part_no;

		var data = "unique_id=" + unique_id_val + "&main_unique_id=" + main_unique_id +
					"&stock_qty=" + stock_qty_val + "&item_code=" + item_code_val + "&item_name=" +
					item_name_val + "&item_qty=" + item_qty_val + "&billed_qty=" + billed_qty_val +
					"&remaining_qty=" + remaining_qty_val + "&product_unique_id=" + product_unique_id_val + "&po_num=" + po_num + "&po_auto_id=" + po_auto_id + "&po_date=" + po_date + "&exe_name=" + exe_name + "&no_of_con=" + no_of_con + "&no_of_items=" + no_of_items + "&total_qty=" + total_qty + "&net_value=" + net_value + "&stock_date=" + stock_date + "&unique_id=" + unique_id + "&unit_price=" + unit_price +
					 "&product_tax=" + product_tax + "&part_no_val=" + part_no_val+ "&delivery_due_date=" + delivery_due_date;


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
				// location.reload();
				sweetalert(msg, url);
			},
			error: function (data) {
				alert("Network Error");
			}
		});
	}
}
}
</script>
