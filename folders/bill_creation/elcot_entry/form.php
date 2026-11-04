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

        $unique_id_1  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        $ins_unique_id  = $_GET["ins_unique_id"];

        // $where ="consignee_unique_id='".$unique_id_1."' AND invoice_no ='".$invoice_no."'";
        // print_r($where);
        $where ="consignee_unique_id='".$unique_id_1."' AND invoice_no ='".$invoice_no."' and ins_unique_id ='".$ins_unique_id."'";
        $table      =  "view_bill_submission_list_pending_1";

        $columns    = [
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_no",
            "invoice_date",
            "invoice_value",
            "invoice_qty",
            "file_name",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            "ir_status",
            "snr_status",
            "bill_reject_reason",
            "payment_cancel_reason",

        ];

        $table_details   = [
            $table,
            $columns
        ];
        // $where      = [
        //     "consignee_unique_id" => $unique_id_1,
        //     "invoice_no" => $invoice_no,
        // ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
            $ir_status    = $result_values[0]["ir_status"];
            $snr_status    = $result_values[0]["snr_status"];
            
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $ins_unique_id           = $result_values[0]["ins_unique_id"];
            $invoice_value_amt       = moneyFormatIndia($result_values[0]["invoice_value"]);
            // =$invoice_value;
            $invoice_value          = $invoice_value_amt ;
            $file_name    = $result_values[0]["file_name"];
            $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
            $invoice_qty                = $result_values[0]["invoice_qty"];
            $form_main_unique_id          = $result_values[0]["form_main_unique_id"];
            $bill_reject_reason                = $result_values[0]["bill_reject_reason"];
            $payment_cancel_reason          = $result_values[0]["payment_cancel_reason"];
            
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));

            $orgDate1 = $result_values[0]["invoice_date"];  
            $invoice_date = date("d-m-Y", strtotime($orgDate1));

            $file_name_po = image_view("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['file_name']);


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
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Elcot Entry Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Elcot Entry</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }
</style>


<div class="row cf">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $po_num ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Date</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $po_date ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee Name</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $con_contact_name ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Location</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $con_address ?></div>
                                    </div>

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice No</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $invoice_no ?></div>
                                        <input type="hidden" name="my_inv_no" id="my_inv_no" value="<?php echo $invoice_no ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Date</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Value</label></div>
                                        <div class="col-xl-1">:</div>
                                        <div class="col-xl-7"><?php echo $invoice_value ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO COpy </label></div>
                                        <div class="col-xl-1">:</div>
                                        <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                                        <div class="col-xl-7"><?php echo $file_name_po ?></div>
                                    </div>
                                    <!--<div class="row">-->
                                    <!--<div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Qty</label></div>-->
                                    <!--<div class="col-xl-1">:</div>-->
                                    <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                                    <!--<div class="col-xl-7"><?php echo $invoice_qty ?></div>-->
                                    <!--</div>-->
                                    <?php if($bill_status=='3'){?>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bill Reject Reason</label></div>
                                        <div class="col-xl-1">:</div>
                                        <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                                        <div class="col-xl-7"><?php echo $bill_reject_reason ?></div>
                                    </div>

                                    <?php } else if($bill_status=='4'){?>
                                    <div class="row">
                                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Payment Reject Reason</label></div>
                                        <div class="col-xl-1">:</div>
                                        <!--<div class="col-xl-7"><a href="#"><i class="mdi mdi-download-circle-outline"></i><?php echo $file_name_po ?></a></div>-->
                                        <div class="col-xl-7"><?php echo $payment_cancel_reason ?></div>
                                    </div>
                                    <?php } ?>
                                </div>


                                <hr />

                            </div>

                        </div>

                        <?php
                        $where      = [
                            "consignee_unique_id" => $unique_id_1,
                            "invoice_no" => $invoice_no,
                            "ins_unique_id" => $ins_unique_id,
                            "is_delete" => 0,
                        ];

                        $table_sub      =  "bill_submission_form";

                        $columns    = [
                            "installation_reference_no",
                            "supplier_invoice_number",
                            "unique_id",
                            "scanned_dc_copy",
                            "scanned_snr_copy",
                            "scanned_ir_copy",
                            "invoice_copy",
                            "claim_amount",
                            "ins_unique_id",
                        ];

                        $table_details   = [
                            $table_sub,
                            $columns
                        ];

                        $result_values_data  = $pdo->select($table_details, $where);
                        // print_r($result_values_data);die();

                        if ($result_values_data->status) {

                            $result_values_data      = $result_values_data->data;
                            $installation_reference_no    = $result_values_data[0]["installation_reference_no"];
                            $supplier_invoice_number          = $result_values_data[0]["supplier_invoice_number"];
                            $scanned_dc_copy         = $result_values_data[0]["scanned_dc_copy"];
                            $scanned_ir_copy         = $result_values_data[0]["scanned_ir_copy"];
                            $invoice_copy         = $result_values_data[0]["invoice_copy"];
                            $unique_id_data         = $result_values_data[0]["unique_id"];
                            $scanned_snr_copy         = $result_values_data[0]["scanned_snr_copy"];
                            $claim_amount         = $result_values_data[0]["claim_amount"];
                            // $exp_under_user_type  = explode(",", $under_user_type);

                            $btn_text           = "Update";
                            $btn_action         = "update";
                        } else {
                            $btn_text           = "Error";
                            $btn_action         = "error";
                            $is_btn_disable     = "disabled='disabled'";
                        }
                        $claim_amount_options      = [
                            [
                                "id"    => '5',
                                "value"  => "5%"
                            ],
                            [
                                "id"    => '25',
                                "value"  => "25%"
                            ],
                            [
                                "id"    => '75',
                                "value"  => "75%"
                            ],
                            [
                                "id"    => '95',
                                "value"  => "95%"
                            ],
                            [
                                "id"    => '100',
                                "value"  => "100%"
                            ],
                            [
                                "id"    => '20',
                                "value"  => "20%"
                            ],
                        ];
                        $claim_amount_options    = select_option($claim_amount_options, "Select", $claim_amount);
                        ?>

                        <div class="col-xl-3">

                            <label class="form-label">Scanned DC Copy</label>

                            <input class="form-control" type="file" id="scanned_dc_copy" name="scanned_dc_copy" accept="application/pdf"  value="<?php echo $scanned_dc_copy  ?>">
                        </div>
                        <?php if(($snr_status=='1')||($snr_status=='SNR')){?>
                        <div class="col-xl-3">

                        <label class="form-label">Scanned Snr Copy</label>

                        <input class="form-control" type="file" id="scanned_snr_copy" name="scanned_snr_copy" accept="application/pdf"  value="<?php echo $scanned_snr_copy; ?>">
                        </div>
                       <?php } ?>
                        <?php if($ir_status=='1'){?>
                        <div class="col-xl-3">

                            <label class="form-label">Scanned IR Copy</label>

                            <input class="form-control" type="file" id="scanned_ir_copy" name="scanned_ir_copy" accept="application/pdf"  value="<?php echo $scanned_ir_copy; ?>">
                        </div>

                        <?php }?>
                        <div class="col-xl-3">
                            <div>
                                <label class="form-label">Invoice Copy</label>
                                <input class="form-control" type="file" id="invoice_copy" name="invoice_copy" accept="application/pdf"  value="<?php echo $invoice_copy; ?>">
                            </div>
                        </div>
                        
                        <div class="col-xl-3">
                            <div>
                                <label for="exampleInputdate" class="form-label"> Elcot Installation Reference No </label>
                                <input type="text" id="installation_reference_no" name="installation_reference_no" class="form-control" value="<?php echo $installation_reference_no ?>">
                            </div>
                        </div>
                       
                        <!-- <div class="col-xl-3">
                            <div>
                                <label for="exampleInputdate" class="form-label">Supplier Invoice Number </label>
                                <input type="text" id="supplier_invoice_number" name="supplier_invoice_number" class="form-control" value="<?php echo $supplier_invoice_number ?>">
                            </div>
                        </div> -->
                        <div class="col-xl-3">
    <div>
        <label for="exampleInputdate" class="form-label">Supplier Invoice Number</label>
        <input 
            type="text" 
            id="supplier_invoice_number" 
            name="supplier_invoice_number" 
            class="form-control" 
            value="<?php echo $supplier_invoice_number ?>"
            onblur="trimInput(this)"
        >
    </div>
</div>
                        <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Claim Amount</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="claim_amount" id="claim_amount">
                                        <?php echo $claim_amount_options ?>
                                        </select>
                                    </div>
                                </div>


                        <div class="col-xl-3">
                            <div style='display:none' ;>
                                <label for="exampleInputdate" class="form-label"></label>
                                <select name="bill_status" id="bill_status" class="select2 form-control">
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="bill_form_main_unique_id" name="bill_form_main_unique_id" class="form-control" value="<?php echo $form_main_unique_id ?>">
                        <input type="hidden" id="po_num" name="po_num" class="form-control" value="<?php echo $po_num ?>">
                        <input type="hidden" id="po_date" name="po_date" class="form-control" value="<?php echo $po_date ?>">
                        <input type="hidden" id="con_contact_name" name="con_contact_name" class="form-control" value="<?php echo $con_contact_name ?>">
                        <input type="hidden" id="con_address" name="con_address" class="form-control" value="<?php echo $con_address ?>">
                        <input type="hidden" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo $invoice_no ?>">
                        <input type="hidden" id="invoice_date" name="invoice_date" class="form-control" value="<?php echo $invoice_date ?>">
                        <input type="hidden" id="invoice_value" name="invoice_value" class="form-control" value="<?php echo $invoice_value ?>">
                        <input type="hidden" id="file_name" name="file_name" class="form-control" value="<?php echo $file_name ?>">
                        <input type="hidden" id="consignee_unique_id" name="consignee_unique_id" class="form-control" value="<?php echo $result_values[0]["consignee_unique_id"]; ?>">
                        <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                        <input type="hidden" id="invoice_qty" name="invoice_qty" value="<?php echo $invoice_qty; ?>">
                        <input type="hidden" id="ins_unique_id" name="ins_unique_id" value="<?php echo $ins_unique_id; ?>">
                        <input type="hidden" id="ir_status" name="ir_status" value="<?php echo $ir_status; ?>">
                        <input type="hidden" id="snr_status" name="snr_status" value="<?php echo $snr_status; ?>">
                        

                        <div class="col-12 mt-3">
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>

                                    <?php if ($unique_id_data != '') { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="bill_submission_cu()">Update</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="bill_submission_cu()">Save</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>



                    </div> <!-- end card -->

                </form>
            </div><!-- end col -->
        </div>

    </div>

</div>

<?php
function image_view($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}


?>
<script>

      // Function to trim spaces
      function trimInput(input) {
        input.value = input.value.trim();
    }

    function print_1(file_name) {
        window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }


    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view_1(file_name) {

        window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>

