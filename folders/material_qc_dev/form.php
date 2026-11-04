<?php include 'function2.php'; ?>
<?php
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;
$session_approved_by = $_SESSION["staff_name"];

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

       
        $unique_id  = $_GET["unique_id"];
    try{
        $where      = [
            "unique_id" => $unique_id
        ];
             $table = "invoice_creation_main";
        $columns    = [
            "get_po_number(form_main_unique_id) AS po_num",

    "DATE_FORMAT(
        (SELECT po_date FROM po_form WHERE po_form.unique_id = $table.form_main_unique_id),
        '%d-%m-%Y'
    ) AS po_date",
  "get_department_name(
        (SELECT department FROM po_form WHERE po_form.unique_id = $table.form_main_unique_id)
    ) AS department",
            "invoice_no",
            "doc_approval_sts",
            "approved_by",
            "unique_id as invoice_unique_id",
            "invoice_date",
            "form_main_unique_id",
            "ac_team_verifiy_status",
            "invoice_auto_id",
            "invoice_doc_status",
            "consignee_unique_id",
            "dc_number",
            "dc_date",
            "material_qc",
            "material_qc_reject_reason",
            "material_qc_approved",
          "get_executive_name(
        (SELECT executive_name FROM po_form WHERE po_form.unique_id = $table.form_main_unique_id)
    ) AS executive_name",
            "DATE_FORMAT(approved_date,'%d-%m-%Y') AS approved_date"
            // ""
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];

            $po_date          = $result_values[0]["po_date"];
            $department     =  $result_values[0]["department"];
            $invoice_no          = $result_values[0]["invoice_no"];
            $doc_approval_sts          = $result_values[0]["doc_approval_sts"];
            $invoice_unique_id         = $result_values[0]["invoice_unique_id"];
            $invoice_date        = $result_values[0]["invoice_date"];
            $form_main_unique_id        = $result_values[0]["form_main_unique_id"];
            $ac_team_verifiy_status        = $result_values[0]["ac_team_verifiy_status"];
            $invoice_auto_id        = $result_values[0]["invoice_auto_id"];
            $ledger_name        = $result_values[0]["ledger_name"];
             $ledger_no        = $result_values[0]["ledger_no"];
             $invoice_doc_status        = $result_values[0]["invoice_doc_status"];
             $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
             $dc_number          = $result_values[0]["dc_number"];
             $dc_date          = $result_values[0]["dc_date"];
             $material_qc          = $result_values[0]["material_qc"];
             $material_qc_reject_reason          = $result_values[0]["material_qc_reject_reason"];
             $executive_name          = $result_values[0]["executive_name"];
                $approved_by         = $result_values[0]["material_qc_approved"];
                $approved_date          = $result_values[0]["approved_date"];




            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
            $stmtCus->bindParam(':unique_id', $form_main_unique_id);
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
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor();

            $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
            $stmt->bindParam(':unique_id', $consignee_unique_id);
            $stmt->execute();

            $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
            if (!empty($consignee_data)) {
                $consigneeName    = $consignee_data[0]["con_contact_name"];
                $consigneeContact  = $consignee_data[0]["con_contact_number"];
                $consigneeLan  = $consignee_data[0]["con_lan_num"];
                $consigneeAddress   = $consignee_data[0]["con_address"];
                $consigneeDistrict  = district_name_stock($consignee_data[0]["con_district"]);
                $consigneeState      = con_state_name_stock($consignee_data[0]["con_state_name"]);
                $consigneePincode      = $consignee_data[0]["con_pincode"];
                $consigneeZone      = $consignee_data[0]["zone"];
            }
            $stmt->closeCursor();


            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
    }
}

$appr_type_options      = [

     [
        "id"    => 0,
        "text"  => "Pending"
    ],
    [
        "id"    => 1,
        "text"  => "Yes"
    ],
    [
        "id"    => 2,
        "text"  => "No"
    ],
    

];

$appr_type_options    = select_option($appr_type_options, "", $material_qc);

function toIndianCurrencyFormat($amount) {
    $amount = number_format($amount, 2, '.', ''); // Ensure 2 decimal places

    $parts = explode('.', $amount);
    $integerPart = $parts[0];
    $decimalPart = isset($parts[1]) ? $parts[1] : '00';

    $len = strlen($integerPart);
    if ($len <= 3) {
        $formatted = $integerPart;
    } else {
        $lastThree = substr($integerPart, -3);
        $rest = substr($integerPart, 0, -3);
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        $formatted = $rest . ',' . $lastThree;
    }

    return $formatted . '.' . $decimalPart;
}


?>
<style>
    label {       
        margin-right: 20px;
    }

    th{
        text-align:center;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Material QC</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active">Material QC </li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row cf">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">
                <form class="was-validated" autocomplete="off">
                    <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $session_approved_by ?>">
                    <input type="hidden" name="invoice_unique_id" id="invoice_unique_id" value="<?php echo $invoice_unique_id ?>">
                    <input type="hidden" name="invoice_auto_id" id="invoice_auto_id" value="<?php echo $invoice_auto_id ?>">
                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no?>">
                    <input type="hidden" name="ledger_name" id="ledger_name" value="<?php echo $ledger_name?>">
                    <input type="hidden" name="ledger_no" name="ledger_no" value="<?php echo $ledger_no;?>">
                    <input type="hidden" name="invoice_doc_status" name="invoice_doc_status" value="<?php echo $invoice_doc_status;?>">
                    <input type="hidden" name="dc_number" name="dc_number" value="<?php echo $dc_number;?>">
                    <input type="hidden" name="dc_date" name="dc_date" value="<?php echo $dc_date;?>">
					<input type="hidden" id="stock_status" name="stock_status" class="form-control" value="<?php echo $status; ?>">
					<input type="hidden" id="department" name="department" class="form-control" value="<?php echo $department; ?>">
					<input type="hidden" id="form_main_unique_id" name="form_main_unique_id" class="form-control" value="<?php echo $form_main_unique_id; ?>">


                    <div class="card card-body p-4">
					<div class="row">
						<div class="col text-end">
						</div>
					</div> 
					
					<div class="row">
                        <!-- Customer Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details</h6>
                            <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $department ?></strong></h6>
                            <p class="mb-1"><?php echo $customerAddress ?>, <?php echo $customerDistrict ?><br><?php echo $customerState ?>, <?php echo $customerPincode ?></p>
                            <p class="mb-1">
                                <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($customerContact) ? $customerContact : '--'; ?>
                            </p>
                            <p>
                                <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
                            </p>
                        </div>

                        <!-- Consignee Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Consignee Details</h6>
                            <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $consigneeName ?></strong></h6>
                            <p class="mb-1"><?php echo $consigneeAddress ?>, <?php echo $consigneeDistrict ?><br><?php echo $consigneeState ?>, <?php echo $consigneePincode ?></p>
                            <p class="mb-1">
                                <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($consigneeContact) ? $consigneeContact : '--'; ?>
                            </p>
                            <p class="mb-1">
                                <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($consigneeLan) ? $consigneeLan : '--'; ?>
                            </p>
                        </div>
                        <!-- Consignee / Invoice Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & Invoice Details</h6>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">PO Number</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $po_num ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">PO Date</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">Excutive Name</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $executive_name; ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">Invoice No</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $invoice_no; ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">Invoice Date</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo date('d-m-Y', strtotime($invoice_date)) ?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">DC Number</div>
                                <div class="col-1">:</div>
                                <div class="col-6 "><?php echo $dc_number ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-body-secondary">DC Date</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       <div class="col-12">
                            <div class="row">
                                <div class="col-12 mt-2">
									<div class="table-responsive mb-4">
									    <table class="table table-striped table-bordered align-middle  mb-0 small_table">
											<thead >
												<tr>
                                                    <th>S.No</th>
                                                    <th scope="col">Item Details</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Value</th>
                                                </tr>
											</thead>
											<tbody >
                                                <?php
                                                    $where1 = "po_unique_id = '" . $form_main_unique_id. "' and consignee_id = '" .$consignee_unique_id. "' and dc_num = '".$dc_number."' AND is_delete=0 ";
                                                    $table1      =  "invoice_creation";
                                                    $columns1    = [
                                                        "item_code",
                                                        "invoice_qty",
                                                        "invoice_qty_value",
                                                        "unique_id",
                                                        "po_unique_id",
                                                        "product"
                                                        ];
                                                        $table_details1   = [
                                                        $table1,
                                                        $columns1
                                                    ];
                                                    $values_product  = $pdo->select($table_details1, $where1);
                                                    // print_r($values_product);die();
													$j = 1;

													if ($values_product->status) {
														$product_array      = $values_product->data;														
														$btn_update         = btn_update($folder_name, $value['unique_id']);
														foreach ($product_array as $key => $product) {
                                                            $invoice_value_with_tax = $product['invoice_qty_value'] + ($product['invoice_qty_value'] * 0.18);
												?>
											        <tr>
														<td><?php echo $j; ?></td>
                                                        <td><strong><?php echo $product['item_code'] ?> </strong><br> <?php echo $product['product'] ?></td>
                                                        <!-- <td></td> -->
                                                        <td style="text-align:right;"><?php echo $product['invoice_qty'] ?></td>
                                                        <td style="text-align:right;"><?php echo moneyFormatIndia1($invoice_value_with_tax); ?></td>
													</tr>
												<?php
															$j++;
														}
													}
												?>
											</tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">

                                    <?php if($material_qc == '1' ){?>
                                         <label class="form-label">Material QC Status</label>
                                        <select name="material_qc_status" id="material_qc_status" disabled class="select2 form-control" required onchange="show_rejection_reason(this.value);empty_reason();">
                                            <?php echo $appr_type_options; ?>
                                        </select>
                                    <?php } 
                                    else{ ?>
     <label class="form-label">Material QC Status</label>
                                    <select name="material_qc_status" id="material_qc_status" class="select2 form-control" required onchange="show_rejection_reason(this.value);empty_reason();">
                                            <?php echo $appr_type_options; ?>
                                        </select>

                                    <?php }?>
                                       
                                    </div>
                                </div>
                                <?php if( $material_qc  == '1'){?>
                                         <div class="row">
                            <!-- Approved By -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Approved By</label>
                                    <span class="form-control"><?php echo $approved_by; ?></span>
                                </div>
                            </div>

                            <!-- Approved Date -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Approved Date</label>
                                    <span class="form-control"><?php echo $approved_date; ?></span>
                                </div>
                            </div>
                        </div>
                                <?php }?>
                                
                                <div class="col-xl-3" id="rejection_reason" style="display:none">
                                    <label>Rejected Reason</label>
                                    <textarea  id="ac_reason_reject" name="ac_reason_reject" class="form-control is-invalid" rows="3" value=""><?=$material_qc_reject_reason?></textarea>
                                </div>

                                <div class="form-group row ">
                                    <div class="col-md-12" align="right" id="savebtn" style="display:none;">
                                        <?php echo btn_cancel($btn_cancel); ?>
                                         
                                    </div>
                                     <div class="col-md-12" align="right" id="savebtn1" style="display:none;">
                                        <?php echo btn_cancel($btn_cancel); ?>
                                         <?php if($material_qc != '1' ){?>
                                              <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                         <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </div> 
</div>

<script>
   $(document).ready(function () {
    show_rejection_reason();
   });

    function show_rejection_reason(){
        // alert();
        var status = document.getElementById("material_qc_status").value;
         if (status == "0") {
        document.getElementById("savebtn").style.display = "block";
        document.getElementById("savebtn1").style.display = "none";
    } else {
        document.getElementById("savebtn").style.display = "none";
        document.getElementById("savebtn1").style.display = "block";
    }
        // alert(status);
        if(status == 2){
            document.getElementById("rejection_reason").style.display = "block";
        }else{
            document.getElementById("rejection_reason").style.display = "none";
        }
    }
    function empty_reason(){
        document.getElementById("ac_reason_reject").value = "";
    }

    function toIndianCurrencyFormat(amount) {
    return parseFloat(amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
</script>
