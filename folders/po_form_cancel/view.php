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
            <h4 class="mb-sm-0"> PO Delivery / Dispatch</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> PO </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<?php
if (isset($_GET["unique_id"])) {
	if (!empty($_GET["unique_id"])) {
        $unique_id = $_GET['unique_id'];
        // print_r($unique_id);


		// $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
		// $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

		// $unique_id  = $get_uni_id;
		// $where      = [
		// 	"unique_id" => $_GET["unique_id"]
		// ];

        $where = "main_unique_id = '$unique_id'";
		$table      =  "view_po_consignee_deatail";

		$columns    = [
			"con_address",
			"con_district",
            "con_pincode",
			"con_contact_name",
            "con_contact_number",
			"con_lan_num",
			"main_unique_id",
            "con_unique_id",
            "po_unique_id"
		];

		$table_details   = [
			$table,
			$columns
		];
		$result_values  = $pdo->select($table_details, $where);
    //    print_r($result_values);

		if ($result_values->status) {

			$res_array      = $result_values->data;
            // print_r($res_array);

            foreach($res_array as $key => $value) {

                
                $data = '<div class="col-12">
                    <div class="row">
                        <div class="col-5">
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                        name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7">'.$value['con_contact_name'].'</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                        Contact</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7">'.$value['con_contact_number'].'</div>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                        Address</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7">'.$value['con_address'].'</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                        Landline</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7">'.$value['con_lan_num'].'</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="table-responsive mb-4">
                            <form class="was-validated po_delivery_form" autocomplete="off">

                                <table
                                    class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th scope="col">Item Code</th>
                                            <th scope="col">Item Name</th>
                                            <th scope="col">Assign QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                        // Product detail data  AND con_unique_id = '".$value['con_unique_id']."'

                                        $where2 = "form_main_unique_id = '".$value['main_unique_id']."'";

                                        $product_display_options   = assign_qty($value['main_unique_id'],$value['con_unique_id']);

                                        // print_r($product_display_options);
                                        foreach($product_display_options as $key => $form_val){
                                            if(($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)){
                                                $table1      =  "product_details_sub";
                                                $where1 = "form_main_unique_id = '".$value['main_unique_id']."' AND is_delete = 0";
                                                $columns1    = [
                                                "item_code",
                                                "product",
                                                "qty",
                                                "assign_qty",
                                                "form_main_unique_id",
                                                "unit_price",
                                                "tax",
                                                "unique_id",
                                            ];
                                    
                                                $table_details1   = [
                                                    $table1,
                                                    $columns1
                                                ];
                                
                                            }else {
                                                $table1      =  "po_product_assign_details";
                                                $where1 = "form_main_unique_id = '".$value['main_unique_id']."' AND con_unique_id = '".$form_val['con_unique_id']."'";
                                                $columns1    = [
                                                "item_code",
                                                "product",
                                                "assign_qty",
                                                "form_main_unique_id",
                                                "unit_price",
                                                "unique_id",
                                                "product_unique_id"
                                                ];
                
                                                $table_details1   = [
                                                    $table1,
                                                    $columns1
                                                ];
                                        
                                            }
    
                                            $values_product  = $pdo->select($table_details1, $where1);
                                            //  print_r($values_product);
                                            if ($values_product->status) {

                                                $product_array      = $values_product->data;
                            
                                                foreach($product_array as $key => $product) {
                                                    $product[ 's_no' ] = $sno + 1;
                                                    // print_r($value['con_unique_id']);

                                                    // echo $value['con_unique_id'];
                                                    if($value['con_unique_id'] != ''){
                                                        $data .= '<tr>
                                                            <td>'.$product['s_no'].'</td>
                                                            <td>'.$product['item_code'].'</td>
                                                            <td>'.$product['product'].'</td>
                                                            <td>
                                                                <div class="">';
                                                                if($product['product_unique_id']){
                                                                    $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                    class="form-control" value="'.$product['product_unique_id'].'">';
                                                                }else{

                                                                $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                class="form-control" value="'.$product['unique_id'].'">';
                                                                }
                                                                $data .= '<input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                class="form-control" value="'.$product['form_main_unique_id'].'">
                                                                <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                class="form-control" value="'.$value['con_unique_id'].'">
                                                                <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                class="form-control" value="'.$value['po_unique_id'].'">

                                                                <input type="hidden" id="con_name" name="con_name[]"
                                                                class="form-control" value="'.$value['con_contact_name'].'">
                                                                <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                class="form-control" value="'.$value['con_contact_number'].'">
                                                                <input type="hidden" id="item_code" name="item_code[]"
                                                                class="form-control" value="'.$product['item_code'].'">
                                                                <input type="hidden" id="item_name" name="item_name[]"
                                                                class="form-control" value="'.$product['product'].'">

                                                                <input type="hidden" id="unit_price" name="unit_price[]"
                                                                class="form-control" value="'.$product['unit_price'].'">
                                                                <input type="hidden" id="tax" name="tax[]"
                                                                class="form-control" value="'.$product['tax'].'">';
                                                                
                                                                $data .='<input type="text" id="bill_qty" name="bill_qty[]"
                                                                class="form-control" value="'.$product['assign_qty'].'">';
                                                                $data .= '</div>';  
                                                                $data .='</div>
                                                            </td>
                                                        </tr>';
                                                    }else {
                                                        $data .= '<tr>
                                                            <td>'.$product['s_no'].'</td>
                                                            <td>'.$product['item_code'].'</td>
                                                            <td>'.$product['product'].'</td>
                                                            <td>
                                                                <div class="">
                                                                <input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                class="form-control" value="'.$product['product_unique_id'].'">
                                                        
                                                                <input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                class="form-control" value="'.$product['main_unique_id'].'">
                                                                <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                class="form-control" value="'.$value['con_unique_id'].'">
                                                                <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                class="form-control" value="'.$value['po_unique_id'].'">

                                                            

                                                                <input type="hidden" id="con_name" name="con_name[]"
                                                                class="form-control" value="'.$value['con_contact_name'].'">
                                                                <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                class="form-control" value="'.$value['con_contact_number'].'">
                                                                <input type="hidden" id="item_code" name="item_code[]"
                                                                class="form-control" value="'.$product['item_code'].'">
                                                                <input type="hidden" id="item_name" name="item_name[]"
                                                                class="form-control" value="'.$product['product'].'">

                                                                <input type="hidden" id="unit_price" name="unit_price[]"
                                                                class="form-control" value="'.$product['unit_price'].'">
                                                                <input type="hidden" id="tax" name="tax[]"
                                                                class="form-control" value="'.$product['tax'].'">';
                                                                
                                                                $data .='<input type="text" id="bill_qty" name="bill_qty[]"
                                                                class="form-control" >';
                                                                $data .= '</div>';
                                                        
                                                                    
                                                                $data .='</div>
                                                            </td>
                                                        </tr>';
                                                    }
                                                }
                                    $data .='</tbody>
                                </table>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">';
                                ?>
                                    <?php
                                if($form_val['con_unique_id'] == ''){
                                    // print_r('hi');
                                $data .='<a href="index.php?file=po_form/list"><button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button></a>';
                                $data .='<button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="po_delivery_add_update()">Save</button>';
                                }else if($form_val['con_unique_id'] != ''){
                                    // print_r('hello');
                                    $data .='<a href="index.php?file=po_form/list"><button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button></a>';
                                $data .='<button type="button" class="btn btn-success waves-effect waves-light createupdate_btn" onclick="po_delivery_add_update()">Update</button>';
                                }
                            
                            $data .= '</div>
                        </div>
                    </form>
                </div>';              
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body mt-1">
                                <?php echo $data ?>

                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div><!-- end col -->
                </div>
            <?php 

            }
        }
    } 

}

    }

    }
        
    
?>

<script>
// consignee sub crud
function po_delivery_add_update(unique_id = "") {
    //alert('hi');
    var internet_status = is_online();
    var bill_qty = document.getElementsByName('bill_qty[]');

    for (var i = 0; i < bill_qty.length; i++) {
        var bill_qty_val = bill_qty[i].value;

        if (bill_qty_val != '') {
            var qty_val = bill_qty[i].value;
            var item_code = document.getElementsByName('item_code[]');
            var item_name = document.getElementsByName('item_name[]');
            var unit_price = document.getElementsByName('unit_price[]');
            var tax = document.getElementsByName('tax[]');

            var con_unique_id = document.getElementsByName('con_unique_id[]');
            var con_name = document.getElementsByName('con_name[]');
            var con_contact_no = document.getElementsByName('con_contact_no[]');
            var product_unique_id = document.getElementsByName('product_unique_id[]');


            var item_code_val = item_code[i].value;
            var item_name_val = item_name[i].value;
            var item_unit_price = unit_price[i].value;
            var item_tax = tax[i].value;

            var con_unique_id_val = con_unique_id[i].value;
            var con_name_val = con_name[i].value;
            var con_contact_no_val = con_contact_no[i].value;
            var product_unique_id_val = product_unique_id[i].value;


            // var product_unique_id= document.getElementById('product_unique_id').value;
            var main_unique_id = document.getElementById('main_unique_id').value;
            var po_unique_id = document.getElementById('po_unique_id').value;



            var data = "main_unique_id=" + main_unique_id + "&con_unique_id=" + con_unique_id_val +
                "&con_name=" + con_name_val + "&con_contact_no=" + con_contact_no_val + "&item_code=" + item_code_val +
                "&item_name=" +
                item_name_val + "&bill_qty=" + qty_val + "&unit_price=" + item_unit_price + "&item_tax=" + item_tax +
                "&po_unique_id=" + po_unique_id + "&product_unique_id_val=" + product_unique_id_val;

            data += "&unique_id=" + unique_id + "&action=po_delivery_add_update";

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
                        location.reload();
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
