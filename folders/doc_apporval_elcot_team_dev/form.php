<!-- This file Only PHP Functions -->

<style>
    table thead tr th{
        text-align:center !important;
    }
</style>
<?php include 'function1.php'; ?>
<?php
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$is_active = 1;

$session_approved_by = $_SESSION["staff_name"];

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

         $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];


        $table = "invoice_creation_main";

        $columns = [
           			"get_po_number(form_main_unique_id) AS po_num",
           		   "DATE_FORMAT((select po_date from po_form where  po_form.unique_id=$table.form_main_unique_id), '%d-%m-%Y') as po_date",
           "(SELECT get_department_name(department) 
      FROM po_form 
      WHERE po_form.unique_id = invoice_creation_main.form_main_unique_id
    ) AS department",
            "get_address(consignee_unique_id) AS con_address",

            "(SELECT con_contact_name FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id
        and consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id ) AS con_contact_name",

            "(SELECT con_contact_number FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id
        and consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id ) AS con_contact_number",
            "get_pincode(consignee_unique_id) AS con_pincode",
            "(select con_state_name from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_state_name",
            "(select con_district from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_district",
            "(select con_branch from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_branch",
            "(select con_branch_code from consignee_details_sub where unique_id = $table.consignee_unique_id group by consignee_unique_id) AS con_branch_code",

            "invoice_no",
            "doc_approval_sts",
            "approved_by",
            "unique_id as invoice_unique_id",
            "invoice_date",
            "form_main_unique_id",
            "doc_approval_sts",
            "invoice_auto_id",
            "ledger_name",
            "ledger_no",
            "invoice_doc_status",
            "consignee_unique_id",
            "dc_number",
            "dc_date",
            "(select bill_address from po_form where  po_form.unique_id=$table.form_main_unique_id) as bill_address",
             "(select contact_name from po_form where  po_form.unique_id=$table.form_main_unique_id) as contact_name",
            "(select contact_number from po_form where  po_form.unique_id=$table.form_main_unique_id) as contact_number",
            "(select landline_number from po_form where  po_form.unique_id=$table.form_main_unique_id) as landline_number",
            "(select email from po_form where  po_form.unique_id=$table.form_main_unique_id) as email",
            "(SELECT get_state_name(state_name) 
      FROM po_form 
      WHERE po_form.unique_id = invoice_creation_main.form_main_unique_id
    ) AS state_name",
       "(SELECT get_district_name_po(district) 
      FROM po_form 
      WHERE po_form.unique_id = invoice_creation_main.form_main_unique_id
    ) AS district",
      "(SELECT get_executive_name(executive_name)
      FROM po_form 
      WHERE po_form.unique_id = invoice_creation_main.form_main_unique_id
    ) AS executive_name"
     ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);
        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values = $result_values->data;

            $po_num = $result_values[0]["po_num"];

            $po_date = $result_values[0]["po_date"];
            $con_contact_name = $result_values[0]["con_contact_name"];
            $department = $result_values[0]["department"];
            $con_address = $result_values[0]["con_address"];
            $con_pincode = $result_values[0]["con_pincode"];
            $con_branch = $result_values[0]["con_branch"];
            $con_branch_code = $result_values[0]["con_branch_code"];
            $con_contact_number = $result_values[0]["con_contact_number"];

            $con_districts = district_name($result_values[0]['con_district']);
            $con_district = disname($con_districts[0]['district_name']);

            $con_states = con_state_name($result_values[0]["con_state_name"]);
            $con_state = disname($con_states[0]['state_name']);

            $invoice_no = $result_values[0]["invoice_no"];

            $consignee_unique_id = $result_values[0]["consignee_unique_id"];
            $invoice_unique_id = $result_values[0]["invoice_unique_id"];
            $invoice_date = $result_values[0]["invoice_date"];
            $form_main_unique_id = $result_values[0]["form_main_unique_id"];
            $doc_approval_sts = $result_values[0]["doc_approval_sts"];

            $invoice_auto_id = $result_values[0]["invoice_auto_id"];
            $ledger_name = $result_values[0]["ledger_name"];
            $ledger_no = $result_values[0]["ledger_no"];
            $invoice_doc_status = $result_values[0]["invoice_doc_status"];
            $dc_number = $result_values[0]["dc_number"];
            $dc_date = $result_values[0]["dc_date"];


            $bill_address = $result_values[0]["bill_address"];
            $contact_name = $result_values[0]["contact_name"];
            $contact_number = $result_values[0]["contact_number"];
            $landline_number = $result_values[0]["landline_number"];
            $email = $result_values[0]["email"];
            $state_name = $result_values[0]["state_name"];
            $district = $result_values[0]["district"];
            $executive_name = $result_values[0]["executive_name"];

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

$appr_type_options = [


    [
        "id" => 0,
        "text" => "Pending"
    ],
    [
        "id" => 1,
        "text" => "Approved"
    ],
    [
        "id" => 2,
        "text" => "Not Approved"
    ],


];


if ($doc_approval_sts == "1") {

    $appr_type_options = select_option($appr_type_options,"", $doc_approval_sts);

} else {
    $appr_type_options = select_option($appr_type_options,"", $doc_approval_sts);

}

?>
<style>
    label {
        /* font-weight: bold;
  color: black; */
        margin-right: 20px;
        /* You can add more styles as needed */
    }

    /* .form-label {
  display: inline-block;
  width: 100px;
  text-align: left;
}

.form-label {
 
  margin-left: 10px;
}

.form-label span {
  margin-left: 10px;
} */
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Operation Approval</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">Operation Approval</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row cf">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $session_approved_by ?>">
                    <input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice_date ?>">
                    <input type="hidden" name="invoice_unique_id" id="invoice_unique_id"
                        value="<?php echo $invoice_unique_id ?>">
                    <input type="hidden" name="form_main_unique_id" name="form_main_unique_id"
                        value="<?php echo $form_main_unique_id ?>">

                    <input type="hidden" name="invoice_auto_id" id="invoice_auto_id"
                        value="<?php echo $invoice_auto_id ?>">
                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
                    <input type="hidden" name="ledger_name" id="ledger_name" value="<?php echo $ledger_name ?>">
                    <input type="hidden" name="invoice_doc_status" name="invoice_doc_status"
                        value="<?php echo $invoice_doc_status; ?>">
                    <input type="hidden" name="dc_number" name="dc_number" value="<?php echo $dc_number; ?>">
                    <div class="row">
                        <!-- Customer Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                Customer Details</h6>
                            <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $department ?></strong>
                            </h6>
                            <p class="mb-1"><?php echo ucwords($bill_address) ?>,
                                <?php echo ucwords($district) ?><br><?php echo ucwords($state_name) ?>
                            </p>
                            <p class="mb-1">
                                <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($contact_number) ? $contact_number : '--'; ?>
                            </p>
                            <p>
                                <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($email) ? $email : '--'; ?>
                            </p>
                        </div>

                        <!-- Consignee Details -->
                        
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">
                                Consignee Details</h6>

                            <!-- Capitalize first letter of each word in contact name -->
                            <h6 style="font-size: x-large; color: #506018;">
                                <strong><?php echo ucwords($con_contact_name); ?></strong>
                            </h6>
<p class="mb-1">
    <?php if($con_branch_code){?>
   <?php echo ucwords($con_branch_code); ?>-
     <?php }?>
                              <?php echo ucwords($con_branch); ?>
                            </p>
                            <!-- Capitalize address and district -->
                            <p class="mb-1">
                                <?php echo ucwords($con_address); ?>, <?php echo ucwords($con_district); ?><br>
                                <?php echo ucwords($con_state); ?>-<?php echo ucwords($con_pincode); ?>
                            </p>
                            

                            <!-- Contact number with fallback -->
                            <p class="mb-1">
                                <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                                <?php echo !empty($con_contact_number) ? $con_contact_number : '--'; ?>
                            </p>
                        </div>

                        <!-- Consignee / Invoice Details -->
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO &
                                Invoice Details</h6>
                            <div class="row mb-1">
                                <div class="col-5 text-body-secondary">PO Number</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?php echo $po_num; ?></div>
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
                                <div class="col-6 "><?php echo date('d-m-Y', strtotime($dc_date)) ?></div>
                            </div>
                        </div>
                    </div>

                    <br><br>


                    <div class="col-12 mt-2">
                        <div class="table-responsive mb-4">
                            <table id="invoice_table" class="table table-striped table-bordered align-middle  mb-0 small_table">
                                <thead>
                                    <!-- class="table-light" -->
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item</th>
                                       

                                        <!-- <th scope="col">Invoice QTY</th> -->
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

                                    $where1 = "dc_num = '$dc_number' and po_unique_id = '" . $form_main_unique_id . "' and consignee_id = '" . $consignee_unique_id . "' AND  is_delete='0'";
                                    // print_r($where1); die();
                                    $table1 = "invoice_creation";
                                    $columns1 = [
                                        "item_code",
                                        "product",
                                        // "(SELECT sum(invoice_qty) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id = ".$table1.".form_main_unique_id ) AS invoice_qty",
                                        "invoice_qty",
                                        // "invoice_qty_value",
                                        // "(SELECT sum(invoice_value) FROM view_doc_approval_list_final WHERE view_doc_approval_list_final.invoice_auto_id = ".$table1.".invoice_auto_id ) AS invoice_value",
                                        "(SELECT approved_by FROM invoice_creation_main WHERE invoice_creation_main.invoice_auto_id = " . $table1 . ".invoice_auto_id ) AS approved_by",
                                        "(SELECT approved_date FROM invoice_creation_main WHERE invoice_creation_main.invoice_auto_id = " . $table1 . ".invoice_auto_id ) AS approved_date",

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
                                            $invoice_value_with_tax = '';
                                            $invoice_value_with_tax = $product['invoice_qty_value'] + ($product['invoice_qty_value'] * 0.18);

                                            if ($invoice_value_with_tax != '') {
                                                $invoice_value_with_tax = round($invoice_value_with_tax);
                                            }



                                            // $product['approved_by'] = $product['approved_by'];
                                            $product['approved_date'] = $product['approved_date'];
                                            if($product['approved_date'] != ''){
                                                $dt = DateTime::createFromFormat('Y-m-d', $product['approved_date']);
                                                $approve_date = $dt->format('d-m-Y'); // "07-07-2025"
                                            }
                                           
                                            // $invoice_tax = $invoice_qty_value + 1.18;
                                            // $invoice_tax = $product['invoice_value'] + 1.18% ;
                                    
                                            // $product['po_unique_id']='<i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" onclick="invoice_data_delete()"></i>';
                                    

                                            // $product['po_unique_id'] = $product['stock_qty']- $product['invoice_qty'];
                                            //   $s_no = $sno + 1;
                                            ?>

                                            <tr>
                                                <td><?php echo $j; ?></td>

                                                <td><b><?php echo $product['item_code'] ?></b><br><?php echo $product['product'] ?></td>
                                                <!-- <td></td> -->
                                                <td style="text-align: right"><?php echo $product['invoice_qty'] ?></td>
                                                <!-- <td><?php echo $product['invoice_value'] ?></td> -->
                                                <td style="text-align: right">
                                                    <?php echo moneyFormatIndia($invoice_value_with_tax); ?></td>

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
                        <!-- Approval Status -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                
                                 <?php if ($doc_approval_sts == '0') { ?>
                                    <label class="form-label">Approval Status</label>
                                <select name="doc_approval_sts" id="doc_approval_sts"  class="select2 form-control"
                                    required onchange="doc_status(this.value); empty_reason(); check_sts();">
                                    <?php echo $appr_type_options; ?>
                                </select>

                                 <?php }
                                 else if ($doc_approval_sts == '1'){ ?>
                                 <label class="form-label">Approval Status</label>
                                      <select name="doc_approval_sts" id="doc_approval_sts" disabled class="select2 form-control"
                                    required onchange="doc_status(this.value); empty_reason(); check_sts();">
                                    <?php echo $appr_type_options; ?>
                                </select>
                                 <?php }?>
                            </div>
                        </div>
                        <?php if ($result_values[0]["doc_approval_sts"] == '1') { ?>
                            <div class="row">
                                <!-- Approved By -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Approved By</label>
                                        <span class="form-control"><?php echo $product['approved_by']; ?></span>
                                    </div>
                                </div>

                                <!-- Approved Date -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Approved Date</label>
                                        <span class="form-control"><?php echo $approve_date; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-xl-3" id="rejection_reason" style="display:none">
                            <div class="mb-3">
                                <label class="form-label">Rejected Reason</label>
                                <textarea id="reason_reject" name="reason_reject" class="form-control"></textarea>
                            </div>
                        </div>

<!-- style="margin-left: 620px;" -->
                        <div class="form-group row" >
                            <div class="col-md-6" align="right" style="left: 42%;">
                                <!-- Cancel,save and update Buttons -->
                                <?php echo btn_cancel($btn_cancel); ?>
                                   

                            </div>
                            <div class="col-md-6" id="update_btns" align="right" style="display:none">
                                <!-- Cancel,save and update Buttons -->
                               
                                   <?php if ($result_values[0]["doc_approval_sts"] != '1') { ?>
                                    
                                <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                   <?php }?>

                            </div>
                        </div>
                        <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-delimiter" class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div> -->
                    </div>
                    <!-- <div class="form-group row ">
                                <div class="col-md-12" align="center">

                                    <button type="button" class="btn btn-danger">Submit</button>
                                </div>
                            </div> -->
                    <!-- <div class="form-group row ">
                                <div class="col-md-12" align="right"> -->
                    <!-- Cancel,save and update Buttons -->

                    <!-- <button type="submit">Submit</button> -->
            </div>
        </div>
    </div>
    </form>

</div> <!-- end card-body -->
</div> <!-- end card -->
</div><!-- end col -->
</div>


<script>
    // $(document).ready(function () {
    //     // doc_status();
    //     $("#doc_approval_sts").select2();

    //      $('#invoice_table').DataTable({
    //     "dom": '<"top"f>rt<"bottom"lp><"clear">',
    //     "paging": false,  // remove if pagination is needed
    //     "info": false     // remove if you want to show "Showing x of y entries"
    // });

    // });
function check_sts(){
    var doc_sts = document.getElementById('doc_approval_sts').value;
    // alert(doc_sts);
    if(doc_sts != 0){
        $("#update_btns").show();
    }else{
$("#update_btns").hide();
    }
}


    function doc_status() {
        var status = document.getElementById("doc_approval_sts").value;
        if (status == 2) {
            document.getElementById("rejection_reason").style.display = "block";
        } else {
            document.getElementById("rejection_reason").style.display = "none";
        }
    }
    function empty_reason() {
        document.getElementById("reason_reject").value = "";
    }

$(document).ready(function(){

});

</script>
