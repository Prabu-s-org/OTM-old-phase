

<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";
$unique_id          = "";
$user_type              = "";
$under_user_type        = "";
$exp_under_user_type    = "";
$is_active          = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id  = $_GET["unique_id"];
        $view  = $_GET["view"];
        // print_r( $unique_id);die();
        $consignee_unique_id=$_GET["consignee_unique_id"];

        $dc_no = $_GET["dc_number"];
       
        $where      = "po_form_unique_id='$unique_id' and consignee_unique_id='$consignee_unique_id' and dc_number='$dc_no' and is_delete='0'";
        $table      =  "dispatch_list";
        $columns    = [
           "get_po_number(po_form_unique_id) as po_num",
            "po_date",
            "consignee",
            // "con_address",
            // "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id) AS con_address",
            "get_address(consignee_unique_id) AS con_address",
            "invoice_no",
            "invoice_date",
            "dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
            "pod_no",
            // "(select con_contact_number from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id) AS con_contact_number",
            "cns_get_contact_number(consignee_unique_id) AS con_contact_number",
            // "(select con_pincode from consignee_details_sub where unique_id = $table.consignee_unique_id and consignee_details_sub.is_delete=0 group by unique_id ) AS con_pincode",
            "get_pincode(consignee_unique_id) AS con_pincode",
            "get_consignee_district('$consignee_unique_id') AS con_district",
            "get_consignee_state('$consignee_unique_id') AS con_state",
            // "get_state_name(consignee_unique_id) AS con_state",
            "status",
            // "delivery_proof",
            "po_unique_id",
            // "(select po_unique_id from po_form where unique_id = $table.po_form_unique_id) AS po_unique_id",
            "invoice_auto_id",
            "po_form_unique_id",
            "unique_id",
            "consignee_unique_id",
            "dc_date",
            "delivery_date",
            "file_name",
            "get_staff_name_with_staff_id(delv_conf_person) as delv_conf_person",
            "delv_conf_date",
            "pro_rec_date",
            "rec_contact_no",
            "rec_person_name",
            "deliv_remarks",
            // "invoice_no",
            // "(select po_unique_id from po_form where unique_id = $table_dispatch.po_form_unique_id) AS po_unique_id",
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);die();
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $po_num             = $result_values[0]["po_num"];
            $po_unique_id            = $result_values[0]["po_unique_id"];
            $con_state            = $result_values[0]["con_state"];
            $con_district            = $result_values[0]["con_district"];
            $consignee_unique_id            = $result_values[0]["consignee_unique_id"];
            $po_unique_id_get =  $po_num ;
            $rec_person_name             = $result_values[0]["rec_person_name"];
            $rec_contact_no             = $result_values[0]["rec_contact_no"];
            $pro_rec_date             = $result_values[0]["pro_rec_date"];
            $delv_conf_date             = $result_values[0]["delv_conf_date"];
            $delv_conf_person             = $result_values[0]["delv_conf_person"];
            $deliv_remarks             = $result_values[0]["deliv_remarks"];

            // . ' / ' . $po_unique_id
            $po_form_unique_id            = $result_values[0]["po_form_unique_id"];
            $invoice_no_get = $result_values[0]['invoice_no'] ;
            // . ' / ' . $result_values[0]['invoice_auto_id']
            $mode_of_delivery           = $result_values[0]["mode_of_delivery"];
            if ($mode_of_delivery == "1") {
                $mode_of_delivery    = "hand";
            } else if ($mode_of_delivery == "2") {
                $mode_of_delivery    = "Courier";
            }
            // $po_date            = $result_values[0]["po_date"];

            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));


 $consigneeDistrict      = district_name_stock($con_district );
 $consigneestate      = con_state_name_stock($con_state );
            $consignee   = $result_values[0]["consignee"];
            $con_address        = $result_values[0]["con_address"];
            $invoice_no         = $result_values[0]["invoice_no"];
            $con_contact_number        = $result_values[0]["con_contact_number"];
            $orgDate1 = $result_values[0]["invoice_date"];  
            $invoice_date= date("d-m-Y", strtotime($orgDate1));
            $stock_id        = $result_values[0]["stock_id"];
            $con_pincode           = $result_values[0]["con_pincode"];
            $orgDate2 = $result_values[0]["dispatch_date"];  
            $dispatch_date = date("d-m-Y", strtotime($orgDate2));
            $name_of_courier           = $result_values[0]["name_of_courier"];
            $pod_no           = $result_values[0]["pod_no"];
            $status           = $result_values[0]["status"];
            $unique_id          = $result_values[0]["unique_id"];
            $dc_date          = date("d-m-Y", strtotime($result_values[0]["dc_date"]));
             $orgDate2 =  $result_values[0]['delivery_date'];
             $delivery_date = date("d-m-Y", strtotime($orgDate2));
               $file_name = image_view("dispatch",$result_values[0]['unique_id'], $result_values[0]['file_name']);


               $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
            $stmtCus->bindParam(':unique_id', $_GET["unique_id"]);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($customer_data)) {
                    $customerAddress    = $customer_data[0]["bill_address"];
                    $customerName  = $customer_data[0]["contact_name"];
                    $customerContact  = $customer_data[0]["contact_number"];
                    $customerLan         = $customer_data[0]["landline_number"];
                    $customerEmail = $customer_data[0]["email"];
                    $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                    $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                    $customrePincode      = $customer_data[0]["pin"];
                }
                $stmtCus->closeCursor();

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}
function image_view($folder_name = "", $unique_id = "", $delivery_proof = "")
{
    // alert('hi');
    // echo $dc_file_name;
    $file_names = explode(',', $delivery_proof);
    $image_view = '';
    if ($delivery_proof) {
        foreach ($file_names as $file_key => $delivery_proof) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $delivery_proof);
            if ($delivery_proof) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $delivery_proof . '\')"><img src="uploads/' . $folder_name . '/' . $delivery_proof . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png" style="width: 27px;
    height: 38px;"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
    return $image_view;
}
?>
<style>
    .table {
    --bs-table-head-bg: var(--bs-gray-100);
    --bs-table-head-color: var(--bs-secondary-color)
}
 .text-center th {
        text-align: center;
    }
.table thead th {
    background-color: var(--bs-table-head-bg);
    font-size: 15px;
    font-weight: 600;
    letter-spacing: .08em;
    color: var(--bs-table-head-color)
}

.table thead th,tbody th,tbody td {
    vertical-align: middle
}

.table td,.table th {
    border-top: var(--bs-border-width) solid var(--bs-table-border-color);
    border-bottom: 0
}

.table>:not(:first-child) {
    border-top: 0
}

.table-sm {
    font-size: .8125rem
}

.table-sm thead th {
    font-size: .625rem
}

.table-nowrap th,.table-nowrap td {
    white-space: nowrap
}

.table [data-sort] {
    white-space: nowrap
}

.table [data-sort]::after {
    content: url("data:image/svg+xml;utf8,<svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M3 0L6 4H0L3 0ZM3 10L0 6H6L3 10Z' fill='%2395AAC9'/></svg>");
    margin-left: .25rem
}

.table a[class*=text-reset]:hover {
    color: var(--bs-link-color) !important
}

[data-bs-theme=dark] .table {
    --bs-table-border-color: var(--bs-border-color);
    --bs-table-striped-bg: var(--bs-gray-900-dark);
    --bs-table-active-bg: var(--bs-gray-900-dark);
    --bs-table-hover-bg: var(--bs-gray-900-dark);
    --bs-table-head-bg: var(--bs-black)
}
.table thead th {
    background-color: var(--bs-table-head-bg);
    color: var(--bs-table-head-color);
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
    }
</style>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Delivery Confirmation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> deliver confirmation</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<style>

.table>:not(caption)>*>* {
    padding:5px 10px !important;
    font-size: 13px;
}
.table>thead {
    background-color: #eeece0 !important;
    color: #506018 !important;
}
.white_text { color: #506018 !important;}
.white_text::after{ color: #fff; opacity: 0.5 !important;}
.border-top {
    border-top:  #506018 1px solid !important;
}
.table>:not(caption)>*>* {    padding: 1rem;}
.table_tr_bg{ background-color: #f9fbf0;}
.form-label {    margin-bottom: .3rem; font-size: 15px; }
p{font-size: 15px;}
.text_style{font-size: 15px;    color: #000;    font-weight: 500;}
.text_style_one{font-size: 18px;    color:  #506018;font-weight: 700;}
</style>

<div class="row ">
          <div class="col-12 col-lg-12 col-xl-12 mt-4">


            <!-- Content -->
            <div class="card card-body p-5">
              
              
              <div class="row">
                <div class="col-md-4">
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details
                </h6>
                <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $customerName ?></strong></h6>
                <p class="mb-1"><?php echo ucwords($customerAddress) ?>,
                    <?php echo ucwords($customerDistrict) ?><br><?php echo ucwords($customerState) ?>
                </p>
                <p class="mb-1">
                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                    <?php echo !empty($customerContact) ? $customerContact : '--'; ?>
                </p>
                <p>
                    <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                    <?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
                </p>
            </div>
                <div class="col-12 col-md-4">
               <h6 class="text-uppercase text-body-primary" style="font-size:large; color:#878a99;">
                  Consignee Details
                </h6>
               
                <h6 class="text-body-primary" style="font-size: x-large; color:#506018 !important;">
                  <strong><?= $consignee; ?></strong>
                </h6>
                 <h6>
  <i data-feather="phone" style="width:15px; height:15px; color:#506018; margin-right: 5px;"></i>
  <strong><?= $con_contact_number; ?></strong>
</h6>
                <p class="text-body-primary mb-2"><?= $con_address; ?></p>
                <p class="text-body-primary mb-2"><?= $consigneeDistrict; ?>,&nbsp;<?= $consigneestate; ?>. Pin-<?= $con_pincode; ?></p>


                </div>
                <div class="col-12 col-md-4">
                     <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & Invoice
                    Details</h6>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">PO Number</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $po_num ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">PO Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $po_date ?></div>
                    </div>
                   
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Invoice No</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $invoice_no ?></div>
                   <input type="hidden" id="dc_number" name="dc_number" class="form-control" value="<?= $dc_no; ?>">
                <input type="hidden" id="consignee_unique_id" name="consignee_unique_id" class="form-control" value="<?= $consignee_unique_id; ?>">
                <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?= $unique_id; ?>">
             
                      </div>
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Invoice Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $invoice_date ?></div>
                    </div>
                     <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">DC NO</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $dc_no ?></div>
                    </div>
                     <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">DC Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $dc_date ?></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Delivery Mode</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $name_of_courier;?> - <?php echo $mode_of_delivery; ?></div>
                    </div>
                     <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Delivery Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $delivery_date; ?></div>
                    </div>
                     <div class="row">
                        <div class="col-xl-4 text-body-secondary"> <label for="main_screen" class="form-label">Delivery Proof</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7 text_style"><?php echo $file_name; ?></div>
                    </div>

                </div>


 <div class="col-12 mt-4">
                                    <div class="table-responsive mb-4">
                                        <table
                                            class="table table-striped table-bordered align-middle  mb-0 small_table">
                                            <thead class="text-center">
    <tr>
        <th>S.No</th>
        <th scope="col">Item Details</th>
        <th scope="col">DC Qty</th>
        <th scope="col">Invoice Value</th>
    </tr>
</thead>

                                            <tbody>
                                                <?php
                                                $tax_rates = [
                                                    'product_unique_id_1' => 0.18, // Replace with actual unique IDs and rates
                                                    'product_unique_id_2' => 0.28,
                                                    // Add more mappings as needed
                                                ];

                                                $where1 = "dc_num = '$dc_no' and po_unique_id = '" . $po_form_unique_id  . "' and consignee_id = '" . $consignee_unique_id . "' AND  is_delete='0'";
                                                $table1 = "invoice_creation";
                                                $columns1 = [
                                                    "item_code",
                                                    "product",
                                                    "invoice_qty",
                                                    // "(SELECT approved_by FROM invoice_creation_main WHERE invoice_creation_main.invoice_auto_id = ".$table1.".invoice_auto_id ) AS approved_by",
                                                    // "(SELECT approved_date FROM invoice_creation_main WHERE invoice_creation_main.invoice_auto_id = ".$table1.".invoice_auto_id ) AS approved_date",

                                                    "invoice_qty_value",

                                                    "unique_id",
                                                    "po_unique_id"

                                                ];
                                                $table_details1 = [
                                                    $table1,
                                                    $columns1
                                                ];
                                                $values_product = $pdo->select($table_details1, $where1);
                                                // Print_r($values_product);
                                                $j = 1;
                                                if ($values_product->status) {
                                                    $product_array = $values_product->data;
                                                    //   print_r($product_array);
                                                
                                                    $btn_update = btn_update($folder_name, $value['unique_id']);
                                                    foreach ($product_array as $key => $product) {
                                                        $invoice_value_with_tax = $product['invoice_qty_value'] + ($product['invoice_qty_value'] * 0.18);

                                                    // $product['approved_by'] = $product['approved_by'];
                                                    // $product['approved_date'] = $product['approved_date'];
                                                       
                                                        ?>

                                                       <tr>
    <td><?= $j; ?></td>
    <td><strong><?= $product['item_code']; ?></strong><br><?= $product['product']; ?></td>
    <td style="text-align: right;"><?= $product['invoice_qty']; ?></td>
    <td style="text-align: right;"><?= formatIndianNumber($invoice_value_with_tax); ?></td>
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




 <div class="row">
          <div class="col-md-4">
            <label class="form-label">Delivery Confirmation Status</label>
            <?php if($view !=''){?>
             <select class="form-select" name="delv_con" id="delv_con" onchange="delivery_change()" disabled>
              <option value="Confirmation">Confirmation</option>
            </select>
                <?php }else{?>
                    <select class="form-select" name="delv_con" id="delv_con" onchange="delivery_change()">
              <option value="pending">Pending</option>
              <option value="Not_deliverd">Not deliverd</option>
              <option value="Confirmation">Confirmation</option>
            </select>
                <?php }?>

          </div>
        </div>

         <div id="approval_card" class="mt-3" style="display: none;">
          <div class="row">
            <h6 class="text-uppercase fw-semibold mb-3">Contact Person Details</h6>
               <?php if($view !=''){?>
 <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Delivery Confirmed Person</label>
                <br>
                <label class="form-label"><strong><?php echo $delv_conf_person;?></strong></label>
                 </div>
            </div>
                <?php }?>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Person Name</label>
               <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $rec_person_name;?></strong></label>
                <?php }else{?>
                <input type="text" id="person_name" name="person_name" onkeypress="allowOnlyAlphabets(event)" class="form-control" value="">
                <?php }?>

                 </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Contact No</label>
                <!-- <input type="text" id="contact_no" name="contact_no" class="form-control" required pattern="^\d{10}$" maxlength="10" title="Enter exactly 10 digits (0-9)" /> -->
               <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $rec_contact_no;?></strong></label>
                <?php }else{?>
            <input type="text" id="contact_no" name="contact_no" class="form-control" required pattern="^\d{10}$" maxlength="10" title="Enter exactly 10 digits (0-9)" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                <?php }?>

            </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Product Received Date</label>
                  <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo date("d-m-Y", strtotime($pro_rec_date));?></strong></label>
                <?php }else{?>
                <input type="date" id="pro_rec_date" name="pro_rec_date" class="form-control" required value="">
                <?php }?>
              
            </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Remarks</label>
                  <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $deliv_remarks;?></strong></label>
                <?php }else{?>
                <textarea id="remarks" name="remarks"  onkeypress="allowAlphanumSymbol(event)" class="form-control"></textarea>
                <?php }?>
              </div>
            </div>


            

          </div> <!-- end row in approval_card -->
          
        </div> <!-- end approval_card -->
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>

             <div class="col-md-4 text-end">
                  <?php if($view =='1'){?>
              <?= btn_cancel($btn_cancel); ?>
                <?php }else{?>
              <?= btn_cancel($btn_cancel); ?>
              <button type="button" class="btn btn-primary waves-effect waves-light" id="savebtn" onclick="delivery_confirmation()">Save</button>
                <?php }?>


            </div>
    </div> <!-- / .row -->
              

            </div>

          </div>
        </div>



<script>
$(document).ready(function () {
    delivery_change();
});

function delivery_change() {
    var status = document.getElementById("delv_con").value;
    var card = document.getElementById("approval_card");
    var savebtn = document.getElementById("savebtn");

    if (status === "Confirmation" || status === "Not_deliverd") {
        card.style.display = "block";
        savebtn.style.visibility = "visible"; 
    } else {
        card.style.display = "none";
        savebtn.style.visibility = "hidden";

    }
}

// Call once on page load in case "Confirmation" is preselected
window.onload = function() {
    delivery_change();
};


function delivery_confirmation() {
    var person_name = document.getElementById('person_name').value;
    var contact_no = document.getElementById('contact_no').value;
    var pro_rec_date = document.getElementById('pro_rec_date').value;
    var remarks = document.getElementById('remarks').value;
    var dc_number = document.getElementById('dc_number').value;
    var consignee_unique_id = document.getElementById('consignee_unique_id').value;
    var unique_id = document.getElementById('unique_id').value;
    var delv_con = document.getElementById('delv_con').value;

    if (contact_no !== '' && pro_rec_date !== '') {
        var data = new FormData();

        data.append("person_name", person_name);
        data.append("contact_no", contact_no);
        data.append("pro_rec_date", pro_rec_date);
        data.append("remarks", remarks);
        data.append("dc_number", dc_number);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("unique_id", unique_id);
        data.append("delv_con", delv_con);
        data.append("action", "deleivery_confirmation"); 
        
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                contentType: false,
                processData: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;

                    if (!status) {
                        $(".createupdate_btn").text("Error");
                    } else {
                        $(".createupdate_btn").removeAttr("disabled");

                        if (unique_id) {
                            $(".createupdate_btn").text("Update");
                        }
                    }
                    sweetalert(msg, url);
                },
                error: function () {
                    alert("Network Error");
                }
            });
        
    } else {
        sweetalert("form_alert");
    }
}

   
</script>


                
                              <!-- <h6 class="text-uppercase fw-semibold mb-3" style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;"></h6>
                                <h6></h6>
                                <h6><strong><?= $con_address; ?></strong></h6>
                                <h6><strong><?= $con_pincode; ?></strong></h6>

                               <h6 class="text-uppercase fw-semibold mb-3" style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">Contact Details</h6>
                                <h6><strong><?= $con_contact_number; ?></strong></h6>

                               <h6 class="text-uppercase fw-semibold mb-3" style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">Delivery Details</h6>
                                <h6><strong><?= $name_of_courier; ?></strong></h6>
                                <h6><strong><?= $dispatch_date; ?></strong></h6> -->
