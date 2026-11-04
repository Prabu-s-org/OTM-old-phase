<!-- This file Only PHP Functions -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    #myImg1 {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg1:hover {
        opacity: 0.7;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 10px;
        /* left: 0;
        top: 0; */
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: 0;
        padding: 0;
        /* display: block; */
        width: 100%;
        height:100%;
        max-width: 99%;
        max-height: 100%;
        /* max-width: 700px; */
    }

    #caption {
        margin: auto;
        display: block;
        width: 100%;
        /* max-width: 700px; */
        text-align: center;
        /* color: #ccc; */
        padding: 10px 0;
        height: 150px;
    }
 
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    } 

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
    .status123 {
    width: 218px;
    height: 40px;
    position: absolute;
    left: 26%;
    top: 55%;
    margin: -20px 0 0 -20px;
}
    </style>

<?php include 'function.php'; ?>

<?php
// Form variables
// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
// $active_status_options   = active_status($is_active);
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
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        $ins_unique_id  = $_GET["ins_unique_id"];

        // $where      = [
        //     "ins_unique_id" => $unique_id,
        //     "invoice_no" => $invoice_no,
        // ];
        $where="consignee_unique_id= '$unique_id' and  invoice_no= '$invoice_no'  AND ins_unique_id='".$ins_unique_id ."'";
        // print_r($where);die();
        $table      =  "view_sign_document_vertification";
        $columns    = [
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address	",
            "invoice_no",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
"invoice_date",
            "(select delivery_date from dispatch_list where dispatch_list.invoice_no = $table.invoice_no AND dispatch_list.is_delete=0 GROUP BY invoice_no) as delivery_date",
            // "invoice_date",
            "(select dc_pod_no from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0 GROUP by dc_ir_doc_dispatch_details.invoice_no) as dc_pod_no",
            // "(select dc_pod_date from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0) as dc_pod_date",
            "(select DATE_FORMAT(dc_pod_date, '%d-%m-%Y') from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no 
AND dc_ir_doc_dispatch_details.is_delete = 0 GROUP by  dc_ir_doc_dispatch_details.invoice_no ) as dc_pod_date",

       "(select ir_pod_no from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0 GROUP by dc_ir_doc_dispatch_details.invoice_no) as ir_pod_no",
       
       "(select DATE_FORMAT(ir_pod_date, '%d-%m-%Y') ir_pod_date from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0 GROUP by dc_ir_doc_dispatch_details.invoice_no) as ir_pod_date",
       
       "(select snr_pod_no from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0 GROUP by dc_ir_doc_dispatch_details.invoice_no) as snr_pod_no",
       
      "(select DATE_FORMAT(snr_pod_date, '%d-%m-%Y') snr_pod_date from dc_ir_doc_dispatch_details where dc_ir_doc_dispatch_details.invoice_no = $table.invoice_no AND dc_ir_doc_dispatch_details.is_delete=0 GROUP by dc_ir_doc_dispatch_details.invoice_no) as snr_pod_date",

            "dc_status",
            "dc_file",
            "ir_status",
            "ir_file",
            "snr_status",
            "snr_file",
            "document_verification_status",
            "form_main_unique_id",
            "consignee_unique_id",
            "bank_required",
            "ins_reqired",
            "po_file",
            "ins_unique_id",
            "dc_required",
        ];
        $table_details   = [
            $table,
            $columns
        ];
        // $document_verification_status = asort($document_verification_status);
        $result_values  = $pdo->select($table_details, $where);
        // print_R($result_values);
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $po_num          = $result_values[0]["po_num"];
            $ins_unique_id    = $result_values[0]["ins_unique_id"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];


            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $invoice_date = $result_values[0]["invoice_date"];
           
            $delivery_date = $result_values[0]['delivery_date'];
            $dc_pod_no  = $result_values[0]["dc_pod_no"];
            $dc_pod_date = $result_values[0]["dc_pod_date"];
            $ir_pod_no  = $result_values[0]["ir_pod_no"];
            $ir_pod_date = $result_values[0]["ir_pod_date"];
            $snr_pod_no          = $result_values[0]["snr_pod_no"];
            $snr_pod_date = $result_values[0]["snr_pod_date"];
            $invoice_date          = $result_values[0]["invoice_date"];
            $document_verification_status          = $result_values[0]["document_verification_status"];
            $orgDate = $result_values[0]["po_date"];
            $dc_required = $result_values[0]["dc_required"];
            
            $po_date = date("d-m-Y", strtotime($orgDate));
            if ($result_values['invoice_date'] == "") {
                $invoice_date='';
            }
            else{
            $orgDate1 = $result_values[0]["invoice_date"];
            $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }

            // if ($result_values['document_verification_status'] == "0") {
            //     $result_values['document_verification_status']   = "Pending";
            // } else if ($result_values['document_verification_status'] == "1") {
            //     $result_values['document_verification_status']   = "Mismatch";
            // } else if ($result_values['document_verification_status'] == "2") {
            //     $result_values['document_verification_status']   = "Verified";
            // }
            $consignee_unique_id    = $result_values[0]["consignee_unique_id"];
            $form_main_unique_id          = $result_values[0]["form_main_unique_id"];
            $bank_required          = $result_values[0]["bank_required"];
            $ins_reqired          = $result_values[0]["ins_reqired"];
            $dc_status1         = $result_values[0]["dc_status"];
            $ir_status1          = $result_values[0]["ir_status"];
            // if($ir_status1=='1'){
            //     $ir_status1=$result_values[0]["ir_status"];
            // }
            // $ir_status         = $result_values[0]["ir_status"];
            $snr_status1          = $result_values[0]["snr_status"];
            $po_file_name  = $result_values[0]['po_file'];
            // echo $po_file_name;
            $dc_file_name = $result_values[0]['dc_file'];
            $ir_file_name = $result_values[0]['ir_file'];
            $snr_file_name = $result_values[0]['snr_file'];

            $dc_file = image_view("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['dc_file']);
            // print_r($dc_file);
            $ir_file = image_view_1("installation", $result_values[0]['consignee_unique_id'], $result_values[0]['ir_file']);
            // $po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);
            $po_file = image_view_3("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['po_file']);
            // $result_values[0]["dc_file"]=image_view()
            // $exp_under_user_type  = explode(",", $under_user_type);
            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}
$po_product_options = po_product($unique_id, $form_main_unique_id);
$po_product_options = select_option($po_product_options, "Select Product", $po_product_name);
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Signed Document Update Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Signed Document Update Form</li>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_num ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_date ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_contact_name ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Location</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_address ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_no ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <!-- <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Date</div>
                                        <div class="col-md-1">:</div>
                                       
                                        <div class="col-md-8"><?php echo $invoice_date ?></div>
                                    </div>
                                </div><br><br> -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Delivery Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo date('d/m/Y',strtotime($delivery_date)) ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">DC Pod No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $dc_pod_no ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">DC Pod Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $dc_pod_date ?></div>
                                        <!-- <div class="col-md-8"><?php echo date('d/m/Y',strtotime($dc_pod_date)) ?></div> -->

                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">IR Pod No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $ir_pod_no ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">IR Pod Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $ir_pod_date ?></div>
                                        <!-- <div class="col-md-8"><?php echo date('d/m/Y',strtotime($ir_pod_date)) ?></div> -->

                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">SNR Pod No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $snr_pod_no ?></div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">SNR Pod Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $snr_pod_date ?></div>
                                        <!-- <div class="col-md-8"><?php echo date('d/m/Y',strtotime($snr_pod_date)) ?></div> -->

                                    </div>
                                </div><br><br><!-- end col -->
                               
                               
                                <?php
                                // $where      = [
                                //     "con_unique_id" => $unique_id,
                                //     "invoice_no" => $invoice_no
                                    
                                // ];
                                $where     = "con_unique_id = '$unique_id' and  invoice_no= '$invoice_no' AND ins_unique_id='$ins_unique_id'  AND is_delete=0";
                                // and (snr_status='$snr_status1' || ir_status='$ir_status1' || dc_received_status='$dc_status1')
                                $table_sign     =  "sign_doc_verification_detail";
                                $columns    = [
                                    "po_num",
                                    "po_date",
                                    "con_contact_name",
                                    "con_address",
                                    "con_unique_id",
                                    "invoice_no",
                                    "invoice_date",
                                    "dc_received_status",
                                    "dc_signed_date",
                                    "ir_status",
                                    "ir_signed_date",
                                    "snr_signed_date",
                                    "snr_status",
                                    "po_product_name",
                                    "approval",
                                    "doc_chn",
                                    "claim_amount",
                                    "status_app",
                                    "installation_reference_no",
                                    "supplier_invoice_number",
                                    "unique_id",
                                    "scanned_dc_copy",
                                    "scanned_ir_copy",
                                    "invoice_copy",
                                    "unique_id",
                                    "form_main_unique_id",
                                    "with_bg",
                                    "without_bg",
                                    "ins_unique_id",
                                    "reject_reason",
                                    // "select ins_unique_id from view_sign_document_vertification where view_sign_document_vertification.ir_status=$table_sign.ir_status)as ins_unique_id ",
                                ];
                                $table_details   = [
                                    $table_sign,
                                    $columns
                                ];
                                $result_values_data  = $pdo->select($table_details, $where);
                                // print_r($result_values_data);
                                if ($result_values_data->status) {
                                    $result_values_data      = $result_values_data->data;
                                    $po_num    = $result_values_data[0]["po_num"];
                                    $po_date          = $result_values_data[0]["po_date"];
                                    $con_contact_name          = $result_values_data[0]["con_contact_name"];
                                    $con_address          = $result_values_data[0]["con_address"];
                                    $con_unique_id          = $result_values_data[0]["con_unique_id"];
                                    $invoice_no         = $result_values_data[0]["invoice_no"];
                                    $invoice_date         = $result_values_data[0]["invoice_date"];
                                    $dc_received_status         = $result_values_data[0]["dc_received_status"];
                                    $dc_signed_date         = $result_values_data[0]["dc_signed_date"];
                                    $ir_status         = $result_values_data[0]["ir_status"];
                                    $ir_signed_date         = $result_values_data[0]["ir_signed_date"];
                                    $po_product_name         = $result_values_data[0]["po_product_name"];
                                    $approval         = $result_values_data[0]["approval"];
                                    $claim_amount         = $result_values_data[0]["claim_amount"];
                                    $status         = $result_values_data[0]["status_app"];
                                    $doc_chn     = $result_values_data[0]["doc_chn"];

                                    $with_bg    = $result_values_data[0]["with_bg"];
                                    $without_bg          = $result_values_data[0]["without_bg"];
                                    $ins_unique_id_data         = $result_values_data[0]["ins_unique_id"];
                                    $reject_reason         = $result_values_data[0]["reject_reason"];
                                    $form_main_unique_id_1         = $result_values_data[0]["form_main_unique_id"];
                                    $update_unique_id       = $result_values_data[0]["unique_id"];
                                    $snr_status         = $result_values_data[0]["snr_status"];
                                    $snr_signed_date        = $result_values_data[0]["snr_signed_date"];
                                    if($ins_unique_id_data==''){
                                        $ins_unique_id_data         = "";

                                    }
                                    else{
                                        $ins_unique_id_data=  $result_values_data[0]["ins_unique_id"];
                                    }
                                    // $exp_under_user_type  = explode(",", $under_user_type);
                                    $btn_text           = "Update";
                                    $btn_action         = "update";
                                } else {
                                    $btn_text           = "Error";
                                    $btn_action         = "error";
                                    $is_btn_disable     = "disabled='disabled'";
                                }
                                // $po_product_options = po_product($unique_id, $form_main_unique_id);
                                // $po_product_options = select_option($po_product_options, "Select Product", $po_product_name);
                                // print_r($po_product_options);
                                $dc_received_status_options      = [
                                    [
                                        "id"    => '1',
                                        "value"  => "Received"
                                    ],
                                    [
                                        "id"    => '2',
                                        "value"  => "Pending"
                                    ],
                                ];
                                $dc_received_status_options    = select_option($dc_received_status_options, "Select Status", $dc_received_status);
                                $ir_status_options      = [
                                    [
                                        "id"    => '1',
                                        "value"  => "Received"
                                    ],
                                    [
                                        "id"    => '2',
                                        "value"  => "Pending"
                                    ],
                                ];
                                $ir_status_options    = select_option($ir_status_options, "Select", $ir_status);
                                $snr_status_options      = [
                                    [
                                        "id"    => '1',
                                        "value"  => "Received"
                                    ],
                                    [
                                        "id"    => '2',
                                        "value"  => "Pending"
                                    ],
                                ];
                                $snr_status_options    = select_option($snr_status_options, "Select", $snr_status);
                                // $approval_options      = [
                                //     [
                                //         "id"    => 'Apporval',
                                //         "value"  => "Apporval"
                                //     ],
                                //     [
                                //         "id"    => 'Not_Apporval',
                                //         "value"  => "Not_Apporval"
                                //     ],
                                // ];
                                // $approval_options    = select_option($approval_options, "Select", $approval);
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
                                ];
                                $claim_amount_options    = select_option($claim_amount_options, "Select", $claim_amount);
                                $status_options      = [
                                    // [
                                    //     "id"    => '0',
                                    //     "value"  => "Pending"
                                    // ],
                                    [
                                        "id"    => '1',
                                        "value"  => "Mismatch/Rejected"
                                    ],
                                    [
                                        "id"    => '2',
                                        "value"  => "Verified"
                                    ],
                                ];
                                $status_options    = select_option($status_options, "Select", $status);
                                ?>
                                <input type="hidden" id="sts" name="sts" class="form-control" value="<?php if ($dc_status1 != '') {
                                                                                                            echo $dc_status1;
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                        } ?>" required>
                                                                                                        <input type="hidden" id="sts1" name="sts1" class="form-control" value="<?php if ($ir_status1 != '') {
                                                                                                            echo $ir_status1;
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                        } ?>" required>
                             
                               <input type="hidden" id="sts2" name="sts2" class="form-control" value="<?php if ($snr_status1 != '') {
                                                                                                            echo $snr_status1;
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                      } ?>" required>
                                <div class="row">
                               <div class="col-6">
                                  <div class="mb-3">
                                      <label for="main_screen" class="form-label" >Status</label>
                                      <select class="select2 form-control status123" name="status" id="status" onchange="toggleRejectReason()">
                                          <?php echo $status_options ?>
                                      </select>
                                  </div>
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-xl-6">
                                    <div class="mb-3"  style="display:none" id="rej_reason">
                                        <label for="main_screen" class="form-label">Reject Reason</label>
                                        <textarea  id="reject_reason" name="reject_reason" class="form-control" required></textarea>

                                    </div>
                                </div>
                              </div>
                                <?php
                                  if($dc_required =='on'){?>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label" style="display:none" id="dc_rec_snr">DC Received status</label>
                                            <select class="form-select mb-3" aria-label="Default select example" name="dc_received_status" id="dc_received_status" >
                                                <?php echo $dc_received_status_options ?>
                                            </select>
                                        </div>
                                    </div><br><br><!-- end col -->
                                    <div class="col-xl-6" style="display:none" id="dc_date_snr">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">DC Signed Date</label>
                                            <input type="date" id="dc_signed_date" name="dc_signed_date" class="form-control" value="<?php echo isset($dc_signed_date) ? $dc_signed_date : date('Y-m-d'); ?>" >
                                        </div>
                                    </div>
                                 <?php }                                
                                else if ($ir_status1 == '0'){ ?>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label" style="display:none" id="dc_rec_snr">DC Received status</label>
                                            <select class="form-select mb-3" aria-label="Default select example" name="dc_received_status" id="dc_received_status" >
                                                <?php echo $dc_received_status_options ?>
                                            </select>
                                        </div>
                                    </div><br><br><!-- end col -->
                                    <div class="col-xl-6" style="display:none" id="dc_date_snr">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">DC Signed Date</label>
                                            <input type="date" id="dc_signed_date" name="dc_signed_date" class="form-control" value="<?php echo $dc_signed_date; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">SNR Status</label>
                                            <select class="form-select mb-3" aria-label="Default select example" name="snr_status" id="snr_status" required>
                                                <?php echo $snr_status_options ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">SNR Signed Date</label>
                                            <input type="date" id="snr_signed_date" name="snr_signed_date" class="form-control" value="<?php echo isset ($snr_signed_date)?$snr_signed_date:date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                    
                                <?php }  if($ir_status1 =='IR') {?>
                               <!--  else if($dc_status1=='DC' && $ir_status1=='IR' && $snr_status1=='SNR') -->
                                 
                                    <div class="col-xl-6" style="display:none" id="dc_status">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">DC Received status</label>
                                            <select class="form-select mb-3" aria-label="Default select example" name="dc_received_status" id="dc_received_status" >
                                                <?php echo $dc_received_status_options ?>
                                            </select>
                                        </div>
                                    </div><br><br><!-- end col -->
                                    <div class="col-xl-6" style="display:none" id="dc_date">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">DC Signed Date</label>
                                            <input type="date" id="dc_signed_date" name="dc_signed_date" class="form-control" value="<?php echo isset($dc_signed_date) ? $dc_signed_date:date('Y-m-d'); ?>" >
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">IR Received Status</label>
                                            <select class="form-select mb-3" aria-label="Default select example" name="ir_status" id="ir_status" required>
                                                <?php echo $ir_status_options ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">IR Signed Date</label>
                                            <input type="date" id="ir_signed_date" name="ir_signed_date" class="form-control" value="<?php echo isset( $ir_signed_date) ?$ir_signed_date:date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="snr_status" name="snr_status" class="form-control" required>
                                    
                                <input type="hidden" id="snr_signed_date" name="snr_signed_date" class="form-control" value="<?php if ($snr_signed_date != '') {
                                                                                                            echo $snr_signed_date;
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                        } ?>" required>
                               
                               
                                <?php } ?>

                             
                              <?php  if ($bank_required == 'on') { ?>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="main_screen" class="form-label">Primary Product For BG</label>
                                            <input type="text" id="po_product_name" name="po_product_name" class="form-control" value="<?php echo $po_product_name; ?>" required>
                                            <!-- <select class="form-select mb-3" aria-label="Default select example" id="po_product_name" name="po_product_name">
                                              
                                            </select> -->
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Attachment</label>
                                        <?php echo $po_file ?>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">DC Signed Document</label>

                                        <?php echo $dc_file; ?>

                                    </div>
                                </div>
                                <?php if($ir_status1!='0' && $dc_required!='on'){?>
                                <div class="col-xl-6">
                                    <div class="mb-6">
                                        <label for="main_screen" class="form-label">Installation Signed Report</label>
                                        <?php echo $ir_file ?>

                                    </div>
                                
                                </div>
                                <?php }?>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO DC Comparision</label><br />
                                        <!-- <img id="myImg" src="assets\images\images.png" style="width:50%;max-width:50px"> -->
                                        <img src="uploads/compare-icon.png" height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" type="button">
                                    </div>
                                </div><!-- end col -->
                                <?php if($ir_status1=='0' && $dc_required!='on'){?>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO SNR Comparision</label><br />
                                        <!-- <img id="myImg1" src="assets\images\images.png" style="width:50%;max-width:100px"> -->
                                        <img src="uploads/compare-icon.png" height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-x2" type="button">
                                    </div>
                                </div>
                                <?php }?>
                                <?php if($ir_status1=='IR'){?>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO IR Comparision</label><br />
                                        <!-- <img id="myImg1" src="assets\images\images.png" style="width:50%;max-width:100px"> -->
                                        <img src="uploads/compare-icon.png" height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-x2" type="button">
                                    </div>
                                </div>
                                <?php }?>
                                <?php if ($bank_required == 'on') { ?>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <div class="form-group form-check  mt-3">
                                                <?php
                                                if ($with_bg == 'on') { ?>
                                                    <input type="checkbox" class="form-check-input" id="with_bg" name="with_bg" checked>
                                                <?php } else { ?>
                                                    <input type="checkbox" class="form-check-input" id="with_bg" name="with_bg">
                                                <?php }
                                                ?>
                                                <label class="form-check-label">
                                                    Processed With BG
                                                </label>
                                            </div>
                                            <div class="form-group form-check  mt-2">
                                                <?php if ($without_bg == 'on') { ?>
                                                    <input type="checkbox" class="form-check-input bgcheckbox" id="without_bg" name="without_bg" checked>
                                                <?php } else { ?>
                                                    <input type="checkbox" class="form-check-input bgcheckbox" id="without_bg" name="without_bg">
                                                <?php } ?>
                                                <label class="form-check-label"> Processed Without BG</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Claim Amount</label>
                                        <select class="form-select mb-3" aria-label="Default select example" name="claim_amount" id="claim_amount">
                                            <?php echo $claim_amount_options ?>
                                        </select>
                                    </div>
                                </div> -->
                                <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Approval</label>
                                        <select name="approval" id="approval" class="select2 form-control" required>
                                            <?php echo $approval_options ?>
                                        </select>
                                    </div>
                                </div> -->
                              
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Doc Chennai Date</label>
                                        <input type="date" id="doc_chn" name="doc_chn" class="form-control" value="<?php echo isset($doc_chn) ? $doc_chn:date('Y-m-d'); ?>" >

                                    </div>
                                </div>
                               
                              
                               
                                </div>
                                <input type="hidden" id="po_num" name="po_num" value="<?php echo $result_values[0]["po_num"] ?>">
                                <input type="hidden" id="po_date" name="po_date" value="<?php echo $result_values[0]["po_date"] ?>">
                                <input type="hidden" id="con_contact_name" name="con_contact_name" value="<?php echo $result_values[0]['con_contact_name'] ?>">
                                <input type="hidden" id="con_address" name="con_address" value="<?php echo $result_values[0]["con_address"] ?>">
                                <input type="hidden" id="invoice_no" name="invoice_no" value="<?php echo $result_values[0]["invoice_no"] ?>">
                                <input type="hidden" id="invoice_date" name="invoice_date" value="<?php echo $result_values[0]["invoice_date"] ?>">
                                <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php echo $result_values[0]["form_main_unique_id"] ?>">
                                <input type="hidden" id="con_unique_id" name="con_unique_id" value="<?php echo $result_values[0]["consignee_unique_id"] ?>">
                                <input type="hidden" id="update_unique_id" name="update_unique_id" value=" <?php echo $result_values_data[0]["unique_id"] ?>">
                                <input type="hidden" id="po_product_name" name="po_product_name" value=" <?php echo $result_values[0]["po_product_name"] ?>">
                                <input type="hidden" id="bank_required" name="bank_required" value="<?php echo $result_values[0]["bank_required"] ?>">
                                <input type="hidden" id="con_unique_id" name="con_unique_id" value="<?php echo $result_values[0]["bank_required"] ?>">
                                <input type="hidden" id="ins_unique_id" name="ins_unique_id" value="<?php echo $result_values[0]["ins_unique_id"] ?>">
                                <input type="hidden" id="snr_file" name="snr_file" value="<?php echo  $snr_file_name;  ?>">
                                <input type="hidden" id="ir_file" name="ir_file" value="<?php echo  $ir_file_name;  ?>">
                                <input type="hidden" id="verified_status" name="verified_status" value="<?php echo  $status;  ?>">
                                
                                <!-- <input type="text" id="status" name="status" value="<?php echo  $status_options;  ?>"> -->
                                
                                <input type="hidden" id="dc_required" name="dc_required" value="<?php echo  $dc_required;  ?>">
                              
                                <!-- modal start for po dc comparision -->
                                <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen">
                                        <!-- modal-fullscreen modal-xl-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC Comparison Attachment </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">PO Attachment</h4>
                                                        <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/po_form/po_attach/<?php echo $po_file_name ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">DC Attachment</h4>
                                                        <object data="uploads/installation/<?php echo $dc_file_name ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/installation/<?php echo $dc_file_name ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- modal end -->
                                <!-- modal start for po IR comparision -->
                                <div class="modal fade bs-example-modal-x2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & IR Comparison Attachment </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                           <?php if($ir_status1 == '0'){ ?>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">PO Attachment</h4>
                                                        <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/po_form/po_attach/<?php echo $po_file_name ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">SNR Attachment</h4>
                                                        <object data="uploads/installation/<?php echo $snr_file_name; ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/installation/<?php echo $snr_file_name; ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if($ir_status1 == 'IR'){ ?>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">PO Attachment</h4>
                                                        <object data="uploads/po_form/po_attach/<?php echo $po_file_name ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/po_form/po_attach/<?php echo $po_file_name ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 class="text-center">IR Attachment</h4>
                                                        <object data="uploads/installation/<?php echo $ir_file_name; ?>" type="application/pdf" width="100%" height="900">
                                                            <iframe src="uploads/installation/<?php echo $ir_file_name; ?>" width="100%" height="900">
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- modal end -->
                                <!-- <div class="col-xl-6"> -->
                                <div class="mb-3">
                                    <div class="col-md-12" align="right">
                                        <?php echo btn_cancel($btn_cancel);     ?>
                                        <!--<?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>-->
                                        <?php if ($result_values_data[0]["unique_id"] != '') { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"  id="upbtn" onclick="signed_document_vertification_cu()">Update</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="signed_document_vertification_cu()">Save</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- </div>end col -->
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<!-- 
<div class="col-md-12" align="right">
              <button type="button" class="btn btn-info">Submit</button></div> -->
<!-- <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script> -->
<script>

document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];
        
        // Set the max attribute of the PO Date input field
        document.getElementById("dc_signed_date").setAttribute("max", today);
    });

document.addEventListener("DOMContentLoaded", function () {
        // Get today's date in YYYY-MM-DD format
        let today = new Date().toISOString().split('T')[0];
        
        // Set the max attribute of the PO Date input field
        document.getElementById("ir_signed_date").setAttribute("max", today);
    });



$(document).ready(function () {
        var verified_status = document.getElementById("verified_status").value;
        // alert(verified_status);
        if(verified_status == '2'){
            document.getElementById("upbtn").setAttribute("disabled", "disabled");
            document.getElementById("status").setAttribute("disabled", "disabled");
            document.getElementById("dc_received_status").setAttribute("disabled", "disabled");
            document.getElementById("dc_signed_date").setAttribute("disabled", "disabled");
            document.getElementById("doc_chn").setAttribute("disabled", "disabled");
            document.getElementById("reject_reason").setAttribute("disabled", "disabled");
            document.getElementById("snr_status").setAttribute("disabled", "disabled");
            document.getElementById("snr_signed_date").setAttribute("disabled", "disabled");
            document.getElementById("ir_status").setAttribute("disabled", "disabled");
            document.getElementById("ir_signed_date").setAttribute("disabled", "disabled");
            

            // aa.addAttribute("disabled", disabled);




        }
});


    var modal = document.getElementById("myModal");
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>
<script>
    var modal = document.getElementById("myModal1");
    var img = document.getElementById("myImg1");
    var modalImg = document.getElementById("img02");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
    var span = document.getElementsByClassName("close")[1];
    span.onclick = function() {
        modal.style.display = "none";
    }

    function print_pdf(file_name) {
        onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    function print_excel(file_name) {
        // alert('hi');
        window.location = 'uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }
    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view(file_name) {
        onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
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
<?php
function image_view($folder_name = "", $unique_id = "", $dc_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file);
    $image_view = '';
    if ($dc_file) {
        foreach ($file_names as $file_key => $dc_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $dc_file);
            if ($dc_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_excel(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    // print_r($image_view);
    return $image_view;
}
function image_view_1($folder_name = "", $unique_id = "", $ir_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file);
    $image_view_1 = '';
    if ($ir_file) {
        foreach ($file_names as $file_key => $ir_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_1 .= "&nbsp";
                } else {
                    $image_view_1 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $ir_file);
            if ($ir_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_1 .= '<a href="javascript:print_view(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="30px" width="30px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_1 .= '<a href="javascript:print_pdf(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_1 .= '<a href="javascript:print_excel(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_1 .= '<a href="javascript:print(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    return $image_view_1;
}
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
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $po_file . '\')"><img src="uploads/' . $folder_name . '/' . $po_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="30px" width="30px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $po_file . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    return $image_view_3;
}
?>
<script>
  $(document).ready(function() {
    // rej_data();
	// alert();
			// var documents_type = document.querySelector('.snr_status');
			// var documents_type1 = document.querySelector('.check_box1').checked;
			// var documents_type2 = document.querySelector('.check_box2').checked;
	 var dc_required=document.getElementById('dc_required').value;
     var snr_file=document.getElementById('snr_file').value;
     var ir_file=document.getElementById('ir_file').value;
    //  var status=document.getElementById('status').value;
    //  alert(status);
    //  alert(ir_file);
    //  alert(snr_file);
    //  alert(dc_required);
	 
	// alert(snr_signed_date);
			if (snr_file=='' || snr_file=='null') {
                $('#dc_status').show();
				$('#dc_date').show();
                $('#dc_rec_snr').hide();
				$('#dc_date_snr').hide();
                
				// $('#dc_option2').show();
			} 
           else if ((snr_file!='')) {
            $('#dc_status').hide();
				$('#dc_date').hide();
                $('#dc_rec_snr').show();
				$('#dc_date_snr').show();
			}
            if ((dc_required=='on')) {
            $('#dc_status').hide();
				$('#dc_date').hide();
                $('#dc_rec_snr').show();
				$('#dc_date_snr').show();
			}
	
			

          
    //  if (status=='1') {
    //             $('#reject_reason').show();
				
    //         }
    //         else if(status=='2') {
    //             $('#reject_reason').hide();
				
    //         }

          
			
		});
    
</script>
<script>
   function toggleRejectReason() {
    var statusSelect = document.getElementById("status").value;

    if (statusSelect == '1') {
        $('#rej_reason').show();

        // Remove 'required' attributes for status 1
        document.getElementById("reject_reason").setAttribute("required", "required");
      
      //  document.getElementById("dc_received_status").removeAttribute("required");
      //  document.getElementById("dc_signed_date").removeAttribute("required");
        // document.getElementById("snr_status").removeAttribute("required");
        // document.getElementById("snr_signed_date").removeAttribute("required");
        var snr_status = document.getElementById("snr_status");
        var snr_signed_date = document.getElementById("snr_signed_date");

        if (snr_status) snr_status.removeAttribute("required");
        if (snr_signed_date) snr_signed_date.removeAttribute("required");

        var irStatus = document.getElementById("ir_status");
        var irSignedDate = document.getElementById("ir_signed_date");

        if (irStatus) irStatus.removeAttribute("required");
        if (irSignedDate) irSignedDate.removeAttribute("required");

        document.getElementById("doc_chn").removeAttribute("required");
    } else if (statusSelect == '2') {
        $('#rej_reason').hide();

        // Add 'required' attributes for status 2
        document.getElementById("reject_reason").removeAttribute("required");
       // document.getElementById("dc_received_status").setAttribute("required", "required");
       // document.getElementById("dc_signed_date").setAttribute("required", "required");

        // document.getElementById("snr_status").setAttribute("required", "required");
        // document.getElementById("snr_signed_date").setAttribute("required", "required");

        var snr_status = document.getElementById("snr_status");
        var snr_signed_date = document.getElementById("snr_signed_date");

        if (snr_status) snr_status.setAttribute("required", "required");
        if (snr_signed_date) snr_signed_date.setAttribute("required", "required");

        var irStatus = document.getElementById("ir_status");
        var irSignedDate = document.getElementById("ir_signed_date");

        if (irStatus) irStatus.setAttribute("required", "required");
        if (irSignedDate) irSignedDate.setAttribute("required", "required");

        document.getElementById("doc_chn").setAttribute("required", "required");
    }
}

    // Trigger initial check in case the status is pre-set on page load
   

//     function checkIRStatus() {
//     var irStatusElement = document.getElementById("ir_status");
// // alert(irStatusElement);
//     if (irStatusElement.style.display === 'none' || irStatusElement.type === 'hidden') {
//         document.getElementById("snr_status").setAttribute("required", "required");
//     } else {
//         document.getElementById("snr_status").removeAttribute("required");
//     }
// }
</script>

