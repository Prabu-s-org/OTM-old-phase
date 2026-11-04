<!-- !-- This file Only PHP Functions  -->
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

 
 $where      = [
    //  "consignee_unique_id" => $unique_id,
    //  "invoice_no" => $invoice_no,
     "is_delete" => 0
 ];

 $table_sub_install      =  "installation_details";

 $columns    = [
     "po_form_unique_id",
     "engineer_name",
     // "",
     // "(select installation_com_date FROM installation_details_sublist WHERE installation_details_sublist.invoice_no=$table_sub_install.invoice_no)AS  installation_com_date",
     // "(SELECT installation_com_date FROM installation_details_sublist WHERE installation_details_sublist.invoice_no = ".$table_sub_install.".invoice_no and installation_details_sublist.is_delete='0') AS installation_com_date",
    "installation_com_date",
     "cus_ack_date",
     "documents_type",
     "documents_type1",
     "documents_type2",
     "dc_received_sts",
     "dc_cus_signed_date",
     "ir_rec_status",
     "ir_cus_signed_date",
     "snr_rec_status",
     "snr_cus_signed_date",
     "dc_file",
     "ir_file",
     "snr_file",
     "unique_id",
     "consignee_unique_id",
     "dc_original_name",
     "ir_original_name",
     "snr_original_name",
    //  "(SELECT form_unique_id FROM installation_details_sublist WHERE installation_details_sublist.invoice_no = ".$table_sub_install.".invoice_no and installation_details_sublist.is_delete='0' group by form_unique_id) AS form_unique_id",
 ];

 $table_details   = [
     $table_sub_install,
     $columns
 ];

 $result_values_data  = $pdo->select($table_details, $where);
//  PRINT_R($result_values_data);

 if ($result_values_data->status) {

     $result_values_data      = $result_values_data->data;
     $engineer_name    = $result_values_data[0]["engineer_name"];
     $installation_com_date          = $result_values_data[0]["installation_com_date"];
     $cus_ack_date          = $result_values_data[0]["cus_ack_date"];
     $documents_type          = $result_values_data[0]["documents_type"];
     $documents_type1          = $result_values_data[0]["documents_type1"];
     $documents_type2          = $result_values_data[0]["documents_type2"];
     $dc_received_sts          = $result_values_data[0]["dc_received_sts"];
     $dc_cus_signed_date         = $result_values_data[0]["dc_cus_signed_date"];
     $ir_rec_status         = $result_values_data[0]["ir_rec_status"];
     $ir_cus_signed_date = $result_values_data[0]["ir_cus_signed_date"];
     $snr_rec_status         = $result_values_data[0]["snr_rec_status"];
     $snr_cus_signed_date         = $result_values_data[0]["snr_cus_signed_date"];

     $dc_original_name = $result_values_data[0]["dc_original_name"];
     $ir_original_name         = $result_values_data[0]["ir_original_name"];
     $snr_original_name         = $result_values_data[0]["snr_original_name"];
    //  $form_unique_id         = $result_values_data[0]["form_unique_id"];
     
     $ir_file         = $result_values_data[0]["ir_file"];
//      $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);

//      $dc_file         = $result_values_data[0]["dc_file"];
//      $dc_file_show = image_view_dc_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['dc_file']);
     
// // print_r($dc_file_show);
//      $snr_file         = $result_values_data[0]["snr_file"];
//      $snr_file_show =  image_view_snr_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['snr_file']);
 //    print_R( $snr_file_show);

     $sign_unique_id         = $result_values_data[0]["unique_id"];
     $consignee_unique_id         = $result_values_data[0]["consignee_unique_id"];

     // $dc_file_1 = image_view("installation", $result_values_data[0]['consignee_unique_id'],  $result_values_data[0]["dc_file"]);
     // $exp_under_user_type  = explode(",", $under_user_type);
     
     // $engineer_name_options = engineer_name($engineer_name);
     // $engineer_name_options = select_option($engineer_name_options, "Select Staff", $engineer_name);

   

     $btn_text           = "Update";
     $btn_action         = "update";
 } else {
     $btn_text           = "Error";
     $btn_action         = "error";
     $is_btn_disable     = "disabled='disabled'";
 }
 ?>

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0">installation</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active"> Invoice </li>
				</ol>
			</div>
		</div>
	</div>
    <form class="was-validated" autocomplete="off">
                                 <div class="row">
									<div class="col-12 mt-2">
										<div class="table-responsive mb-4">
											<table
												class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
												<thead class="table-light">
													<tr>
														<th>S.No</th>
														<th scope="col">po num</th>
														<th scope="col">po date</th>
														<th scope="col">invoice No</th>
														<th scope="col">invoice QTY</th>
														<th scope="col"></th>
														<!-- <th scope="col">Invoice QTY</th> -->
														<!--<th scope="col">Request to Bill QTY </th>-->
														<!-- <th scope="col">Remaining QTY </th> -->
													</tr>
												</thead>
												<tbody>
													<?php
													$table_1 = 'view_install_sub';
													$columns_1 = [
														"po_form_unique_id",
                                                        "engineer_name",
                                                        "po_num",
                                                        "po_date",
                                                        "po_auto_id",
                                                        "invoice_date",
                                                        "eng_remarks",
                                                        // "form_unique_id",
                                                        // "",
                                                        // "(select installation_com_date FROM installation_details_sublist WHERE installation_details_sublist.invoice_no=$table_sub_install.invoice_no)AS  installation_com_date",
                                                        // "(SELECT installation_com_date FROM installation_details_sublist WHERE installation_details_sublist.invoice_no = ".$table_sub_install.".invoice_no and installation_details_sublist.is_delete='0') AS installation_com_date",
                                                       "installation_com_date",
                                                       "invoice_no",
                                                        // "cus_ack_date",
                                                        "documents_type",
                                                        "documents_type1",
                                                        "documents_type2",
                                                        "dc_received_sts",
                                                        "dc_cus_signed_date",
                                                        "ir_rec_status",
                                                        "ir_cus_signed_date",
                                                        "snr_rec_status",
                                                        "snr_cus_signed_date",
                                                        "dc_file",
                                                        "ir_file",
                                                        "snr_file",
                                                        "unique_id",
                                                        "consignee_unique_id",
                                                        "dc_original_name",
                                                        "ir_original_name",
                                                        "snr_original_name",
                                                        "dc_required",
                                                        "invoice_auto_id",
                                                        // "ins_required"
                                                        "(SELECT ins_reqired FROM po_form WHERE po_form.unique_id = ".$table_1.".po_form_unique_id and po_form.is_delete='0' group by unique_id) AS ins_reqired",
                                                        // "(SELECT ins_reqired FROM po_form WHERE po_form.unique_id = ".$table_1.".po_form_unique_id and po_form.is_delete='0' group by unique_id) AS ins_reqired",
                                                          ];
													
													$table_details1 = [
														$table_1,
														$columns_1
													];
                                                
												
													$result1 = $pdo->select($table_details1, $where1);
													// print_r($result1);die();
													if ($result1->status) {
														$res_array1 = $result1->data;
														// print_r($result1->data);
														foreach ($res_array1 as $key => $value) {
															$dc_required = $value['dc_required']; 
                                                            // - $value['product_count'];
															$value['s_no'] = $sno + 1;
                                                            $value['dc_required'] = '
                                                            <input class="myCheck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" checked>
                                                            <input class="form-control" type="hidden" id="unique_id" name="unique_id" value="'.$value["unique_id"].'">
                                                            <input class="form-control" type="hidden" id="po_auto_id" name="po_auto_id" value="'.$value["po_auto_id"].'">
                                                            <input class="form-control" type="hidden" id="po_num" name="po_num" value="'.$value["po_num"].'">
                                                            <input class="form-control" type="hidden" id="po_date" name="po_date" value="'.$value["po_date"].'">
                                                            <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id" value="'.$value["invoice_auto_id"].'">
                                                            <input class="form-control" type="hidden" id="invoice_no" name="invoice_no[]" value="'.$value["invoice_no"].'">
                                                            <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id[]" value="'.$value["consignee_unique_id"].'">
                                                            <input class="form-control" type="hidden" id="po_form_unique_id" name="po_form_unique_id" value="'.$value["po_form_unique_id"].'">
                                                            <input class="form-control" type="hidden" id="dc_required" name="dc_required" value="'.$dc_required.'">
                                                            <input class="form-control" type="hidden" id="ins_reqired" name="ins_reqired[]" value="'.$value["ins_reqired"].'">
                                                            <input class="form-control" type="hidden" id="engineer_name" name="engineer_name" value="'.$value["engineer_name"].'">
                                                            <input class="form-control" type="hidden" id="form_unique_id" name="form_unique_id" value="'.$value["unique_id"].'">
                                                            <input class="form-control" type="hidden" id="dc_file" name="dc_file" value="'.$value["dc_file"].'">
                                                            <input class="form-control" type="hidden" id="ir_file" name="ir_file" value="'.$value["ir_file"].'">
                                                            <input class="form-control" type="hidden" id="snr_file" name="snr_file" value="'.$value["snr_file"].'">
                                                             <input class="form-control" type="hidden" id="documents_type" name="documents_type" value="'.$value["documents_type"].'">
                                                            <input class="form-control" type="hidden" id="documents_type1" name="documents_type1" value="'.$value["documents_type1"].'">
                                                            <input class="form-control" type="hidden" id="documents_type2" name="documents_type2" value="'.$value["documents_type2"].'">
                                                            <input class="form-control" type="hidden" id="dc_original_name" name="dc_original_name" value="'.$value["dc_original_name"].'">
                                                            <input class="form-control" type="hidden" id="ir_original_name" name="ir_original_name" value="'.$value["ir_original_name"].'">
                                                            <input class="form-control" type="text" id="snr_original_name" name="snr_original_name" value="'.$value["snr_original_name"].'">
                                                             <input class="form-control" type="hidden" id="eng_remarks" name="eng_remarks" value="'.$value["eng_remarks"].'">
                                                               <input class="form-control" type="hidden" id="installation_com_date" name="installation_com_date" value="'.$value["installation_com_date"].'">
 
                                                                <input class="form-control" type="hidden" id="dc_received_sts" name="dc_received_sts" value="'.$value["dc_received_sts"].'">
                                                            <input class="form-control" type="hidden" id="dc_cus_signed_date" name="dc_cus_signed_date" value="'.$value["dc_cus_signed_date"].'">
                                                             <input class="form-control" type="hidden" id="ir_rec_status" name="ir_rec_status" value="'.$value["ir_rec_status"].'">
                                                               <input class="form-control" type="hidden" id="ir_cus_signed_date" name="ir_cus_signed_date" value="'.$value["ir_cus_signed_date"].'">
                                                               
                                                                <input class="form-control" type="text" id="snr_rec_status" name="snr_rec_status" value="'.$value["snr_rec_status"].'">
                                                            <input class="form-control" type="text" id="snr_cus_signed_date" name="snr_cus_signed_date" value="'.$value["snr_cus_signed_date"].'">
                                                             
                                                            <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" value="'.$value["invoice_date"].'">
                                                        ';

                                                            

                                                             ?>
															<tr>
																<td id="table_td"><?php echo $value['dc_required']; ?></td>
																<td id="table_td"><?php echo $value['s_no']; ?></td>
																<td id="table_td"><?php echo $value['po_num']; ?></td>
                                                                <td id="table_td"><?php echo $value['po_date']; ?></td>
																<td id="table_td"><?php echo $value['invoice_no']; ?></td>

																
                                                                <td>
												
															</tr>
															<?php
															$sno++;
														}
													}
												
													
													?>
													
												</tbody>
											</table>
										</div>
									</div>
                                    </div>
                            </form>


</div>
         </div>
     </div>
     </div>
<script>
$(document).ready(function () {

    // alert();
var internet_status = is_online();

if (!internet_status) {
  sweetalert("no_internet");
  return false;
}
const checked = document.querySelectorAll('.myCheck:checked');
// alert(checked);

var dc_required = document.getElementById('dc_required').value;
  var ins_reqired = document.getElementById('ins_reqired').value;
//   alert(ins_reqired);

        //  var checkbox_qty_length = checkbox_qty.length;
        for (var i = 0; i < checked.length; i++) {
        var checkbox = checked[i];
        // alert('Checkbox: ' + checkbox.value);

        var parentElement = checkbox.parentElement;
        // alert('Parent Element: ' + parentElement.tagName);

        var po_form_unique_id_element = parentElement.querySelector('#po_form_unique_id');
        // if (po_form_unique_id_element) {
            var po_form_unique_id = po_form_unique_id_element.value;

            // alert('PO Form Unique ID: ' + po_form_unique_id);
        // } 
        // else {
        //     alert('Element with ID "po_form_unique_id" not found in parent element.');
        // }
        // console.log('Checkbox:', checkbox);
        // console.log('Parent Element:', parentElement);
        // console.log('PO Form Unique ID:', po_form_unique_id);

        //    console.log('Parent Element:', parentElement);
        // console.log('Child Elements:', parentElement.children); // Log all children of parentElement

        // function getValue(selector) {
        //     var element = parentElement.querySelector(selector);
        //     if (!element) {
        //         console.warn(`Element not found for selector: ${selector}`);
        //     }
        //     return element ? element.value : null; // Return null if element is not found
        // }


        // var po_form_unique_id = getValue('#po_form_unique_id');
        // alert(po_form_unique_id);
        // console.log('PO Form Unique ID:', po_form_unique_id);
        var po_num_element = parentElement.querySelector('#po_num');
        // if (po_form_unique_id_element) {
            var po_num = po_num_element.value;

            var po_date_element = parentElement.querySelector('#po_date');
        // if (po_form_unique_id_element) {
            var po_date = po_date_element.value;
        // var po_num = getValue('#po_num');
        // console.log('PO Number:', po_num);
        var po_auto_id_element = parentElement.querySelector('#po_auto_id');
        // if (po_form_unique_id_element) {
            var po_auto_id = po_auto_id_element.value;
        // var po_date = getValue('#po_date');
        // var po_auto_id = getValue('#po_auto_id');
        // console.log('PO Date:', po_date);
        var invoice_auto_id_element = parentElement.querySelector('#invoice_auto_id');
        // if (po_form_unique_id_element) {
            var invoice_auto_id = invoice_auto_id_element.value;
            // alert(invoice_auto_id);
        // var invoice_auto_id = getValue('#invoice_auto_id');
        // console.log('Invoice Auto ID:', invoice_auto_id);
        var engineer_name_element = parentElement.querySelector('#engineer_name');
        // if (po_form_unique_id_element) {
            var engineer_name = engineer_name_element.value;

        // var engineer_name = getValue('#engineer_name');
        // console.log('Engineer Name:', engineer_name);

        var consignee_unique_id_element = parentElement.querySelector('#consignee_unique_id');
    var consignee_unique_id = consignee_unique_id_element ? consignee_unique_id_element.value : "";

    var invoice_date_element = parentElement.querySelector('#invoice_date');
    var invoice_date = invoice_date_element ? invoice_date_element.value : "";

    var invoice_qty_element = parentElement.querySelector('#invoice_qty');
    var invoice_qty = invoice_qty_element ? invoice_qty_element.value : "";

    var invoice_value_element = parentElement.querySelector('#invoice_value');
    var invoice_value = invoice_value_element ? invoice_value_element.value : "";

    var invoice_no_element = parentElement.querySelector('#invoice_no');
    var invoice_no = invoice_no_element ? invoice_no_element.value : "";

    var ins_unique_id_element = parentElement.querySelector('#ins_unique_id');
    var ins_unique_id = ins_unique_id_element ? ins_unique_id_element.value : "";

    var ins_com_date_element = parentElement.querySelector('#installation_com_date');
    var installation_com_date = ins_com_date_element ? ins_com_date_element.value : "";

    var eng_remarks_element = parentElement.querySelector('#eng_remarks');
    var eng_remarks = eng_remarks_element ? eng_remarks_element.value : "";

    var dc_received_sts_element = parentElement.querySelector('#dc_received_sts');
    var dc_received_sts = dc_received_sts_element ? dc_received_sts_element.value : "";

    var dc_cus_signed_date_element = parentElement.querySelector('#dc_cus_signed_date');
    var dc_cus_signed_date = dc_cus_signed_date_element ? dc_cus_signed_date_element.value : "";

    var ir_rec_status_element = parentElement.querySelector('#ir_rec_status');
    var ir_rec_status = ir_rec_status_element ? ir_rec_status_element.value : "";
    // alert(ir_rec_status)

    var ir_cus_signed_date_element = parentElement.querySelector('#ir_cus_signed_date');
    var ir_cus_signed_date = ir_cus_signed_date_element ? ir_cus_signed_date_element.value : "";
    alert(ir_cus_signed_date);

    var snr_rec_status_element = parentElement.querySelector('#snr_rec_status');
    var snr_rec_status = snr_rec_status_element ? snr_rec_status_element.value : "";

    var snr_cus_signed_date_element = parentElement.querySelector('#snr_cus_signed_date');
    var snr_cus_signed_date = snr_cus_signed_date_element ? snr_cus_signed_date_element.value : "";

    var documents_type_element = parentElement.querySelector('#documents_type');
    var documents_type = documents_type_element ? documents_type_element.value : "";

    var documents_type1_element = parentElement.querySelector('#documents_type1');
    var documents_type1 = documents_type1_element ? documents_type1_element.value : "";

    var documents_type2_element = parentElement.querySelector('#documents_type2');
    var documents_type2 = documents_type2_element ? documents_type2_element.value : "";

    var dc_file_element = parentElement.querySelector('#dc_file');
    var dc_file = dc_file_element ? dc_file_element.value : "";

    var ir_file_element = parentElement.querySelector('#ir_file');
    var ir_file = ir_file_element ? ir_file_element.value : "";

    var snr_file_element = parentElement.querySelector('#snr_file');
    var snr_file = snr_file_element ? snr_file_element.value : "";

    var dc_original_name_element = parentElement.querySelector('#dc_original_name');
    var dc_original_name = dc_original_name_element ? dc_original_name_element.value : "";

    var ir_original_name_element = parentElement.querySelector('#ir_original_name');
    var ir_original_name = ir_original_name_element ? ir_original_name_element.value : "";

    var snr_original_name_element = parentElement.querySelector('#snr_original_name');
    var snr_original_name = snr_original_name_element ? snr_original_name_element.value : "";

    var unique_id_element = parentElement.querySelector('#unique_id');
    var unique_id = unique_id_element ? unique_id_element.value : "";

var data = "po_num=" + po_num+ "&unique_id=" + unique_id  + "&po_form_unique_id=" + po_form_unique_id + "&po_date=" + po_date  + "&engineer_name=" + engineer_name + "&consignee_unique_id=" + consignee_unique_id +"&installation_com_date=" + installation_com_date +"&invoice_date=" + invoice_date +"&invoice_no=" + invoice_no  + "&eng_remarks=" + eng_remarks + "&documents_type=" + documents_type + "&documents_type1=" + documents_type1 + "&documents_type2=" + documents_type2 + "&dc_received_sts=" + dc_received_sts + "&dc_cus_signed_date=" + dc_cus_signed_date + "&ir_rec_status=" + ir_rec_status + "&ir_cus_signed_date=" + ir_cus_signed_date +"&snr_rec_status="+snr_rec_status+ "&snr_cus_signed_date=" + snr_cus_signed_date+"&dc_file=" + dc_file+"&ir_file="+ir_file+ "&snr_file=" +snr_file +"&dc_original_name=" + dc_original_name+"&ir_original_name="+ir_original_name+ "&snr_original_name=" +snr_original_name+ "&po_auto_id=" +po_auto_id+ "&invoice_auto_id=" +invoice_auto_id;

            // + "&checkbox_qty=" + checkbox_qty_val
            data += "&action=ins_sub_add";

            // data += "&action=demo";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
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
                    sweetalert(msg);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
            // }
        }
    // }
});
</script>
