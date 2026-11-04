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
            "department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name ) AS executive_name_val",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            "status",
            "unique_id",
            "executive_name"
		];

		$table_details   = [
			$table,
			$columns
		];

		$result_values  = $pdo->select($table_details, $where);

		if ($result_values->status) {

			$result_values      = $result_values->data;

			$po_unique_id          = $result_values[0]["po_unique_id"];
			$po_num    = $result_values[0]["po_num"];
			$po_date          = $result_values[0]["po_date"];
			$department          = $result_values[0]["department"];
			$executive_name    = $result_values[0]["executive_name_val"];
			$no_of_consignee          = $result_values[0]["no_of_consignee"];
			$no_of_po          = $result_values[0]["no_of_po"];
			$qty    = $result_values[0]["qty"];
			$net_value          = $result_values[0]["net_value"];
			$status          = $result_values[0]["status"];
			$under_user_type    = $result_values[0]["under_user_type"];
			$main_unique_id          = $result_values[0]["unique_id"];
            $exe_unique_id = $result_values[0]["executive_name"];

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
		font-size: 14px;
		margin-bottom: 5px;
	}
</style>

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> PO Form</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
					<li class="breadcrumb-item active"> PO </li>
				</ol>
			</div>

		</div>
	</div>
</div>



<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body mt-1">
				<form class="was-validated" autocomplete="off">
					<div class="col-12">
						<div class="row">
							<div class="col-5">
								<div class="row">
									<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $po_num; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Date</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $po_date; ?></div>
								</div>
								<div class="row">
									<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Excutive Name</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $executive_name; ?></div>
								</div>
								

							</div>

							<div class="col-5">
								<div class="row">
									<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">No of Items in PO</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $no_of_po; ?></div>
								</div>
                                <div class="row">
									<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">No of Consignee</label></div>
									<div class="col-xl-1">:</div>
									<div class="col-xl-7"><?php echo $no_of_consignee; ?></div>
								</div>
								
							</div>
						</div>
					</div>

					
					<div class="row">
						
						<div class="col-12 mt-3">
							<div class="table-responsive mb-4">

								<table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
									<thead class="table-light">
										<tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Po QTY</th>
                                        <th scope="col">Billed QTY</th>
                                        <th scope="col">Available QTY</th>

										</tr>
									</thead>
									<tbody>
										
									<?php
						$where2 = "form_main_unique_id = '".$main_unique_id."'";
                        $table1      =  "product_details_sub";
                
                        $columns1    = [
                            "item_code",
                            "product",
                            "qty",
                            "billed_qty",
                            "actual_qty",
                            "form_main_unique_id",
                           ];
                
                        $table_details1   = [
                            $table1,
                            $columns1
                        ];
                       
                
                        $values_product  = $pdo->select($table_details1, $where2);
                       //  print_r($values_product);
                                               if ($values_product->status) {
               
                                                   $product_array      = $values_product->data;
                               
                                               foreach($product_array as $key => $product) {
                                                   $product[ 's_no' ] = $sno + 1;

							
					?>
										<tr>
											<td><?php echo $product[ 's_no' ]?></td>
											<td><?php echo $product[ 'item_code' ]?></td>
											<td><?php echo $product[ 'product' ]?></td>
                                            <td><?php echo $product[ 'qty' ]?></td>
											<td><?php if($product['billed_qty']){ echo $product['billed_qty'];}else{echo '-';}?></td>
											<td>
												<div class="">
                                                <input type="hidden" id="main_unique_id" name="main_unique_id"
                                                    class="form-control" value="<?php echo $product['form_main_unique_id'];?>">
                                                    
                                                    <input type="hidden" id="po_num" name="po_num"
                                            class="form-control" value="<?php echo $po_num;?>">
                                            <input type="hidden" id="po_date" name="po_date"
                                            class="form-control" value="<?php echo $po_date;?>">
                                            <input type="hidden" id="exe_name" name="exe_name"
                                            class="form-control" value="<?php echo $exe_unique_id;?>">
                                            <input type="hidden" id="no_of_items" name="no_of_items"
                                            class="form-control" value="<?php echo $no_of_po;?>">
                                            <input type="hidden" id="no_of_con" name="no_of_con"
                                            class="form-control" value="<?php echo $no_of_consignee;?>">

                                            <input type="hidden" id="item_code" name="item_code[]"
                                            class="form-control" value="<?php echo $product[ 'item_code'];?>">
                                            <input type="hidden" id="item_name" name="item_name[]"
                                            class="form-control" value="<?php echo $product[ 'product'];?>">


                                           <input type="text" id="act_qty" name="act_qty[]" class="form-control" value="<?php echo $product[ 'actual_qty'];?>" required>

												</div>
											</td>
										</tr>

										<?php 
                                        $sno ++;
						}
					}
                
            
										
										?>

									</tbody>
								</table>

							</div>
							<div class="form-group row ">
								<div class="col-md-12" align="right">
									<!-- Cancel,save and update Buttons -->
									<?php echo btn_cancel($btn_cancel); ?>
                                     <?php if($product['actual_qty'] == ''){?>
                                    <button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="demo()">Save</button>
                                    <?php }else{?>
                                        <button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="demo()">Update</button>
                                        <?php }?>
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

<script>
    
// consignee sub crud
function demo() { 
    alert('ji');
  
    var internet_status = is_online();
    var bill_qty = document.getElementsByName('act_qty[]');
 
    for (var i = 0; i < bill_qty.length; i++){
                var bill_qty_val = bill_qty[i].value;
                                
                if(bill_qty_val != ''){
                    var qty_val = bill_qty[i].value;
                    var item_code = document.getElementsByName('item_code[]');
                    var item_name = document.getElementsByName('item_name[]');

                        var item_code_val = item_code[i].value;
                        var item_name_val = item_name[i].value;
                      
                        

                    var po_date= document.getElementById('po_date').value;
                    // var po_unique_id= document.getElementById('po_unique_id').value;

                    var main_unique_id = document.getElementById('main_unique_id').value;
                    var po_num= document.getElementById('po_num').value;
                    var exe_name= document.getElementById('exe_name').value;
                    var no_of_items = document.getElementById('no_of_items').value;
                    var no_of_con= document.getElementById('no_of_con').value;
                    var data = "main_unique_id=" + main_unique_id + "&act_qty=" + qty_val + "&item_code=" + item_code_val + "&item_name=" + item_name_val;

                    data += "&action=po_delivery_add_update";

                    var ajax_url = sessionStorage.getItem("folder_crud_link");
                    var url = "";
               
            
                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        beforeSend: function() {
                            $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                            $(".po_delivery_add_update_btn").text("Loading...");
                        },
                        success: function(data) {
                            alert(data);
         
                        var obj = JSON.parse(data);
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;
                        // alert(msg);
                        if (!status) {
                            $(".po_delivery_add_update_btn").text("Error");
                            // console.log(error);
                        } else {
                            if (msg == "already") {
                                // sweetalert(msg, url);
                                form_reset("po_delivery_form");
                            }
                            $(".po_delivery_add_update_btn").removeAttr("disabled", "disabled");
                            if (unique_id && msg == "already") {
                                $(".po_delivery_add_update_btn").text("Update");
                            } else {
                                $(".po_delivery_add_update_btn").text("Add");
                                $(".po_delivery_add_update_btn").attr("onclick",
                                    "po_delivery_add_update('')");
                            }
                            // Init Datatable
                            sub_list_datatable("po_delivery_datatable");
                        }
                        sweetalert(msg, url);
                    },
                    error: function(data) {
                        alert("Network Error");
                    }
                });
            }
        }
    // }
}
</script>
