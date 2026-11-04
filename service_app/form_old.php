<?php
include 'header.php';
// include '../../config/dbconfig.php';
include '../config/dbconfig.php';


?>
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

if (isset($_GET["invoice_no"])) {
    if (!empty($_GET["invoice_no"])) {

        $invoice_auto_id  = $_GET["invoice_no"];
        $where      = [
            "invoice_auto_id" => $invoice_auto_id
        ];

        $table      =  "view_installation_followups";

        $columns    = [
            "po_unique_id",
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_auto_id",
            "invoice_no",
            "invoice_date",
            "form_main_unique_id",
            "consignee_unique_id",
            "ins_reqired",
            "dc_required",
            "(SELECT staff_name FROM view_login WHERE view_login.unique_id = view_installation_followups.engineer_name) AS engineer_name",
            "DATE_FORMAT(date, '%d-%m-%Y') AS date",
            "in_charge",
            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups.con_district) AS con_district",
            "con_pincode",   
            "sign_reject_reason", 
            "installation_status" ,
            "engg_type",
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
// print_r($result_values);
        if ($result_values->status) {
            $result_values      = $result_values->data;

            $po_unique_id          = $result_values[0]["po_num"];
            $con_contact_name      = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no           = $result_values[0]["invoice_no"];
            $consignee_unique_id  = $result_values[0]["consignee_unique_id"];
            $dc_required          = $result_values[0]["dc_required"];
            $ins_reqired          = $result_values[0]["ins_reqired"];
            $engineer_name    = $result_values[0]["engineer_name"];  
            $installation_com_date = $result_values[0]["date"];  
            $eng_remarks          = $result_values[0]["in_charge"];  
            $con_district = $result_values[0]["con_district"];
            $con_pincode = $result_values[0]["con_pincode"];
            $sign_reject_reason = $result_values[0]["sign_reject_reason"];
            $installation_status = $result_values[0]["installation_status"];
            $engg_type = $result_values[0]["engg_type"];

              
            // Format PO Date
            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));

            // Format Invoice Date
            if($result_values[0]["invoice_date"]==''){
                $invoice_date = '';
            } else {
                $orgDate1 = $result_values[0]["invoice_date"];
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }

            $btn_text   = "Update";
            $btn_action = "update";
        } else {
            $btn_text   = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

$engineer_name_optionss = engineer_name();
$engineer_name_option = select_option($engineer_name_optionss, "Select Eng Name", $engineer_name_inv);
// $engineer_name_optionss = user_engineer_name();
// $engineer_name_option = select_option($engineer_name_optionss, "Select Eng Name", $engineer_name);


$active_status_options   = active_status($is_active);

?>

<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }



    /* checkbox design start */
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 9px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 16px;
        width: 16px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div class="sub-hed">
    <div class="row">
        <div class="col-3 log-out">
        <h4 class="mb-sm-0"> Installation Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Installation </li>
                </ol>
            </div>
        </div>
       
    </div>
</div>
<div class="card cf">
    <div class="card-body mt-1">
        <h3 class="mb-4 text-info">Installation Completed Details</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">PO Number</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $po_unique_id; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">PO Date</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $po_date; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Invoice No</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $invoice_no; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Invoice Date</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $invoice_date; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Department Name</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $department; ?></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Consignee Name</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $con_contact_name; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Consignee Address</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $con_address; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">District Name</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $con_district; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Pincode</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $con_pincode; ?></div>
                </div>
                <?php if($installation_status == '3') { ?>
                <div class="row mb-2">
                    <div class="col-4"><label class="form-label">Reject Reason</label></div>
                    <div class="col-1">:</div>
                    <div class="col-7"><?php echo $sign_reject_reason; ?></div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
        $where      = [
            "consignee_unique_id" => $consignee_unique_id,
            "invoice_no" => $invoice_no,

            "is_delete" => 0,
            
        ];
// print_r($where);
        $table_sub_install      =  "installation_details";

        $columns    = [
            "po_form_unique_id",
            // "engineer_name",
            "(SELECT staff_name FROM view_login WHERE view_login.unique_id = installation_details.engineer_name) AS engineer_name",
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
            "snr_original_name"
        ];

        $table_details   = [
            $table_sub_install,
            $columns
        ];

        $result_values_data  = $pdo->select($table_details, $where);
// print_r($result_values_data);die();
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

            $ir_file         = $result_values_data[0]["ir_file"];
            $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);

            $dc_file         = $result_values_data[0]["dc_file"];
            $dc_file_show = image_view_dc_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['dc_file']);

           
            $snr_file         = $result_values_data[0]["snr_file"];
            $snr_file_show =  image_view_snr_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['snr_file']);
           
            $dc_original_name         = $result_values_data[0]["dc_original_name"];
            $ir_original_name         = $result_values_data[0]["ir_original_name"];
            $snr_original_name         = $result_values_data[0]["snr_original_name"];


            $sign_unique_id         = $result_values_data[0]["unique_id"];
            $consignee_unique_id         = $result_values_data[0]["consignee_unique_id"];



            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }


        $dc_received_sts_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
            

        ];
        $dc_received_sts_options    = select_option($dc_received_sts_options, "Select Status", $dc_received_sts);

        $ir_rec_status_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
           

        ];

        $ir_rec_status_options    = select_option($ir_rec_status_options, "Select Status", $ir_rec_status);

        $snr_rec_status_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
           

        ];

        $snr_rec_status_options    = select_option($snr_rec_status_options, "Select Status", $snr_rec_status);

        $engineer_name_options = engineer_name();
        $engineer_name_options = select_option($engineer_name_options, "Select Eng Name", $engineer_name);
        $engineer_type_options = engineer_type();
        $engineer_type_options = select_option($engineer_type_options, "Select Eng Type", $engineer_name);
        if($engg_type =='1'){

            $engg_type_name = 'Own Engineer';
        }else{
            $engg_type_name = 'Outsource Vendor';
        }
        ?>
        
        <form class="was-validated mt-3" autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col-4"><label class="form-label">Engg. Type</label></div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <?php 
                                if ($engg_type == '2') {
                                    echo "Outsource Vendor";
                                } elseif ($engg_type == '1') {
                                    echo "Own Engineer";
                                } else {
                                    echo "N/A";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><label class="form-label">Engg. Name</label></div>
                        <div class="col-1">:</div>
                        <div class="col-7"><?php echo $engineer_name; ?></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col-4"><label class="form-label">Date</label></div>
                        <div class="col-1">:</div>
                        <div class="col-7"><?php echo $installation_com_date; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><label class="form-label">Installation Charge</label></div>
                        <div class="col-1">:</div>
                        <div class="col-7"><?php echo $eng_remarks; ?></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if($ins_reqired =='on'){ ?>
                        <div class="col-xl-3">
                            <label class="">Documents</label><br>
                       
                          
                             <?php if ($documents_type == 'DC') { ?>
                                <label class="container">DC
                                    <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="<?php echo $documents_type; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">DC
                                    <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="DC">
                                    <span class="checkmark"></span>
                                </label>
                            <?php }
                            if ($documents_type1 == 'IR') { ?>
                                <label class="container">IR
                                    <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1" id="documents_type1" value="<?php echo $documents_type1; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">IR
                                    <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1" id="documents_type1" value="IR">
                                    <span class="checkmark"></span>
                                </label>
                            <?php }
                            if ($documents_type2 == 'SNR') { ?>
                                <label class="container">SNR
                                    <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1" id="documents_type2" value="<?php echo $documents_type2; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">SNR
                                    <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1" id="documents_type2" value="SNR">
                                    <span class="checkmark"></span>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="row">

                            <?php if ($dc_received_sts == '') { ?>
                                <div class="col-xl-3" id="dc_option" style="display:none;">
                                    <label class="form-label">DC Received Status</label>
                                    <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts">
                                        <?php echo $dc_received_sts_options; ?>
                                    </select>
                                </div>
                            <?php } else if ($dc_received_sts != '') { ?>
                                <div class="col-xl-3" id="dc_option" style="display:none;">
                                    <label class="form-label">DC Received Status</label>
                                    <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" disabled>
                                        <?php echo $dc_received_sts_options; ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($dc_cus_signed_date == '') { ?>
                                <div class="col-xl-3" id="dc_option1" style="display:none;">

                                    <label class="form-label">DC Customer Signed Date</label>
                                    <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>">

                                </div>
                            <?php } else if ($dc_cus_signed_date != '') { ?>
                                <div class="col-xl-3" id="dc_option1" style="display:none;">

                                    <label class="form-label">DC Customer Signed Date</label>
                                    <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>" disabled>
                                </div>
                            <?php } ?>

                            <?php if ($dc_file == '') { ?>
                                <div class="col-xl-3" id="dc_option2" style="display:none;">

                                    <label class="form-label">DC Signed Proof</label>
                                    <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf" value="<?php echo $dc_file; ?>">

                                </div>
                            <?php } else if ($dc_file != '') { ?>
                                <div class="col-xl-3" id="dc_option2" style="display:none;">

                                    <label class="form-label">DC Signed Proof</label>
                                    <div>
                                    <input class="form-control" type="hidden" id="dc_file" name="dc_file" value="<?php echo $dc_file;
                                                                                                                                ?>">
                                        <input class="form-control" type="hidden" id="dc_file_data" name="dc_file_data" value="<?php if ($dc_file != '') {
                                                                                                                                    echo $dc_file;
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?>">
                                        <input class="form-control" type="hidden" id="dc_file_name" name="dc_file_name" value="<?php echo $dc_original_name; ?>">
                                        <?php echo  $dc_file_show; ?>
                                        <?php echo  $dc_original_name; ?>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php if ($ir_rec_status == '') { ?>
                                <div class="col-xl-3" id="ir_option" style="display:none;">
                                    <label class="form-label">IR Received Status</label>
                                    <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status">
                                        <?php echo $ir_rec_status_options ?>
                                    </select>
                                </div>
                            <?php } else if ($ir_rec_status != '') { ?>
                                <div class="col-xl-3" id="ir_option" style="display:none;">
                                    <label class="form-label">IR Received Status</label>
                                    <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status" disabled>
                                        <?php echo $ir_rec_status_options ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($ir_cus_signed_date == '') { ?>
                                <div class="col-xl-3" id="ir_option1" style="display:none;">

                                    <label class="form-label">IR Customer Signed Date</label>
                                    <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date" value="<?php echo $ir_cus_signed_date ?>">

                                </div>
                            <?php } else if ($ir_cus_signed_date != '') { ?>
                                <div class="col-xl-3" id="ir_option1" style="display:none;">

                                    <label class="form-label">IR Customer Signed Date</label>
                                    <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date" value="<?php echo $ir_cus_signed_date ?>" disabled>

                                </div>
                            <?php } ?>
                            <?php if ($ir_file == '') { ?>
                                <div class="col-xl-3" id="ir_option2" style="display:none;">

                                    <label class="form-label">IR Signed Proof</label>
                                    <input class="form-control" type="file" id="ir_file" name="ir_file" accept="application/pdf" value="<?php echo $ir_file; ?>">

                                </div>
                            <?php } else if ($ir_file != '') { ?>
                                <div class="col-xl-3" id="ir_option2" style="display:none;">
                                    <label class="form-label">IR Signed Proof</label>
                                    <div>
                                        <input class="form-control" type="hidden" id="ir_file" name="ir_file" accept="application/pdf">
                                        <?php echo $ir_file_show; ?>
                                        <?php echo  $ir_original_name; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row">

                            <?php if ($snr_rec_status == '') { ?>
                                <div class="col-xl-3" id="snr_option" style="display:none;">
                                    <label class="form-label">SNR Received Status</label>
                                    <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status">
                                        <?php echo $snr_rec_status_options ?>
                                    </select>
                                </div>
                            <?php } else if ($snr_rec_status != '') { ?>
                                <div class="col-xl-3" id="snr_option" style="display:none;">
                                    <label class="form-label">SNR Received Status</label>
                                    <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status" disabled>
                                        <?php echo $snr_rec_status_options ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($snr_cus_signed_date == '') { ?>
                                <div class="col-xl-3" id="snr_option1" style="display:none;">

                                    <label class="form-label">SNR Customer Signed Date</label>
                                    <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date" value="<?php echo $snr_cus_signed_date ?>">

                                </div>
                            <?php } else if ($snr_cus_signed_date != '') { ?>
                                <div class="col-xl-3" id="snr_option1" style="display:none;">

                                    <label class="form-label">SNR Customer Signed Date</label>
                                    <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date" value="<?php echo $snr_cus_signed_date ?>" disabled>

                                </div>
                            <?php } ?>
                            <?php if ($snr_file == '') { ?>
                                <div class="col-xl-3" id="snr_option2" style="display:none;">

                                    <label class="form-label">SNR Signed Proof</label>
                                    <input class="form-control" type="file" id="snr_file" name="snr_file" accept="application/pdf" value="<?php echo $snr_file; ?>">

                                    <!-- $snr_file_show -->
                                </div>
                            <?php } else if ($snr_file != '') { ?>
                                <div class="col-xl-3" id="snr_option2" style="display:none;">

                                    <label class="form-label">SNR Signed Proof</label>
                                    <div>
                                    <input class="form-control" type="hidden" id="snr_file" name="snr_file" accept="application/pdf" value="<?php echo $snr_file; ?>">

                                        <input class="form-control" type="hidden" id="snr_file_data" name="snr_file_data" value="<?php if ($snr_file != '') {
                                                                                                                                        echo $snr_file;
                                                                                                                                    } else {
                                                                                                                                        echo '';
                                                                                                                                    } ?>">
                                        <input class="form-control" type="hidden" id="snr_file_name" name="snr_file_name" value="<?php echo $snr_original_name; ?>">

                                        <?php echo $snr_file_show; ?>
                                        <?php echo  $snr_original_name; ?>
                                    </div>

                                <?php } ?>

                        <?php }else if($dc_required=='on'){?>

                                    <div class="col-xl-3">
                            <label class="">Documents</label><br>
                       
                          
                            <?php if ($documents_type == 'DC') { ?>
                                <label class="container">DC
                                    <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="<?php echo $documents_type; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">DC
                                    <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="DC">
                                    <span class="checkmark"></span>
                                </label>
                            <?php }
                            if ($documents_type1 == 'IR') { ?>
                                <label class="container">IR
                                    <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1" id="documents_type1" value="<?php echo $documents_type1; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">IR
                                    <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1" id="documents_type1" value="IR">
                                    <span class="checkmark"></span>
                                </label>
                            <?php }
                            if ($documents_type2 == 'SNR') { ?>
                                <label class="container">SNR
                                    <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1" id="documents_type2" value="<?php echo $documents_type2; ?>" checked>
                                    <span class="checkmark"></span>
                                </label>
                            <?php } else { ?>
                                <label class="container">SNR
                                    <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1" id="documents_type2" value="SNR">
                                    <span class="checkmark"></span>
                                </label>
                            <?php } ?>
                            
                        </div>
                        <div class="row">

                            <?php if ($dc_received_sts == '') { ?>
                                <div class="col-xl-3" id="dc_option" style="display:none;">
                                    <label class="form-label">DC Received Status</label>
                                    <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts">
                                        <?php echo $dc_received_sts_options; ?>
                                    </select>
                                </div>
                            <?php } else if ($dc_received_sts != '') { ?>
                                <div class="col-xl-3" id="dc_option" style="display:none;">
                                    <label class="form-label">DC Received Status</label>
                                    <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" disabled>
                                        <?php echo $dc_received_sts_options; ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($dc_cus_signed_date == '') { ?>
                                <div class="col-xl-3" id="dc_option1" style="display:none;">

                                    <label class="form-label">DC Customer Signed Date</label>
                                    <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>">

                                </div>
                            <?php } else if ($dc_cus_signed_date != '') { ?>
                                <div class="col-xl-3" id="dc_option1" style="display:none;">

                                    <label class="form-label">DC Customer Signed Date</label>
                                    <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>" disabled>
                                </div>
                            <?php } ?>

                            <?php if ($dc_file == '') { ?>
                                <div class="col-xl-3" id="dc_option2" style="display:none;">

                                    <label class="form-label">DC Signed Proof</label>
                                    <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf" value="<?php echo $dc_file; ?>">

                                </div>
                            <?php } else if ($dc_file != '') { ?>
                                <div class="col-xl-3" id="dc_option2" style="display:none;">

                                    <label class="form-label">DC Signed Proof</label>
                                    <div>
                                    <input class="form-control" type="hidden" id="dc_file" name="dc_file" value="<?php echo $dc_file;
                                                                                                                                ?>">
                                        <input class="form-control" type="hidden" id="dc_file_data" name="dc_file_data" value="<?php if ($dc_file != '') {
                                                                                                                                    echo $dc_file;
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?>">
                                        <input class="form-control" type="hidden" id="dc_file_name" name="dc_file_name" value="<?php echo $dc_original_name; ?>">
                                        <?php echo  $dc_file_show; ?>
                                        <?php echo  $dc_original_name; ?>
                                    </div>

                                </div>
                            <?php } ?>
                            

                        </div>
                       
                                   
                                <br><br>
                                </div>
                                <?php } ?>

                                <input class="form-control" type="hidden" id="form_unique_id" name="form_unique_id" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                                <input class="form-control" type="hidden" id="unique_id" name="unique_id" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                                <input class="form-control" type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $result_values[0]["po_unique_id"] ?>">
                                <input class="form-control" type="hidden" id="po_num" name="po_num" value="<?php echo $result_values[0]["po_num"] ?>">
                                <input class="form-control" type="hidden" id="po_date" name="po_date" value="<?php echo $result_values[0]["po_date"] ?>">
                                <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id" value="<?php echo $result_values[0]["invoice_auto_id"] ?>">
                                <input class="form-control" type="hidden" id="invoice_no" name="invoice_no" value="<?php echo $result_values[0]["invoice_no"] ?>">
                                <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" value="<?php echo $result_values[0]["invoice_date"] ?>">
                                <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id" value="<?php echo $result_values[0]["consignee_unique_id"] ?>">
                                <input class="form-control" type="hidden" id="po_form_unique_id" name="po_form_unique_id" value="<?php echo $result_values[0]["form_main_unique_id"] ?>">
                                <input class="form-control" type="hidden" id="dc_required" name="dc_required" value="<?php echo $result_values[0]["dc_required"] ?>">
                               <input class="form-control" type="hidden" id="ins_reqired" name="ins_reqired" value="<?php echo $result_values[0]["ins_reqired"] ?>">

                        </div>
                    </div>
                </div>
        </form>
        <div class="form-group row ">
            <div class="col-md-12" align="right">
                <!-- Cancel,save and update Buttons -->
                <?php echo btn_cancel($btn_cancel); ?>

                <?php if ($sign_unique_id != '') { ?>
                    <button type="button"  id="submitButton"  style="display:none;"class="btn btn-primary waves-effect waves-light" >Update</button>
                <?php } else { ?>
                    <button type="button"  id="submitButton"  style="display:none;" class="btn btn-primary waves-effect waves-light" >Save</button>
                <?php } ?>
                
            </div>
        </div>
        <!--</form>-->


    </div>
</div>
 <!-- <hr />  -->

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
   $(document).ready(function() {

var documents_type = document.querySelector('.check_box').checked;
var documents_type1 = document.querySelector('.check_box1').checked;
var documents_type2 = document.querySelector('.check_box2').checked;

if (documents_type) {
    $('#dc_option').show();
    $('#dc_option1').show();
    $('#dc_option2').show();
    $('#submitButton').show();
} else {
    $('#dc_option').hide();
    $('#dc_option1').hide();
    $('#dc_option2').hide();
    $('#submitButton').hide();
}

if (documents_type1) {
    $('#ir_option').show();
    $('#ir_option1').show();
    $('#ir_option2').show();
    $('#submitButton').show();
} else {
    $('#ir_option').hide();
    $('#ir_option1').hide();
    $('#ir_option2').hide();
    $('#submitButton').hide();
}

if (documents_type2) {
    $('#snr_option').show();
    $('#snr_option1').show();
    $('#snr_option2').show();
    $('#submitButton').show();
} else {
    $('#snr_option').hide();
    $('#snr_option1').hide();
    $('#snr_option2').hide();
    $('#submitButton').hide();
}


$("#documents_type").on('change', function() {
    var tags = $("#dc_option,#dc_option1,#dc_option2,#submitButton");
    if ($(this).prop('checked')) {
        tags.show();
    } else {
        tags.hide();
    }
});
$("#documents_type1").on('change', function() {
    var tags = $("#ir_option,#ir_option1,#ir_option2,#submitButton");
    if ($(this).prop('checked')) {
        tags.show();
    } else {
        tags.hide();
    }
});
$("#documents_type2").on('change', function() {
    var tags = $("#snr_option,#snr_option1,#snr_option2,#submitButton");
    if ($(this).prop('checked')) {
        tags.show();
    } else {
        tags.hide();
    }
});

});
    function print_dc(file_name) {
        // 
        window.location = 'uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }

    function print_pdf_dc(file_name) {

        onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

  
    function print_view_dc(file_name) {
        // window.location
        window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>

<?php
function image_view_dc_file($folder_name = "", $unique_id = "", $dc_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file);
    $image_view_dc_file = '';

    if ($dc_file) {
        foreach ($file_names as $file_key => $dc_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_dc_file .= "&nbsp";
                } else {
                    $image_view_dc_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file);

            if ($dc_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_dc_file .= '<a href="javascript:print_view_dc(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_dc_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_dc_file .= '<a href="javascript:print_pdf_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_dc_file;
}


function image_view_ir_file($folder_name = "", $unique_id = "", $ir_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file);
    $image_view_ir_file = '';

    if ($ir_file) {
        foreach ($file_names as $file_key => $ir_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_ir_file .= "&nbsp";
                } else {
                    $image_view_ir_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file);

            if ($ir_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_ir_file .= '<a href="javascript:print_view_dc(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_ir_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_ir_file .= '<a href="javascript:print_pdf_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_ir_file;
}


function image_view_snr_file($folder_name = "", $unique_id = "", $snr_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $snr_file);
    $image_view_snr_file = '';

    if ($snr_file) {
        foreach ($file_names as $file_key => $snr_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_snr_file .= "&nbsp";
                } else {
                    $image_view_snr_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $snr_file);

            if ($snr_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_snr_file .= '<a href="javascript:print_view_dc(\'/' . $snr_file . '\')"><img src="uploads/' . $folder_name . '/' . $snr_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_snr_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_snr_file .= '<a href="javascript:print_pdf_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_snr_file;
}



?>

<script>
    //  sub table



    function installation_creation_sub() {
        alert();
        var internet_status = is_online();

        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        var dc_required = document.getElementById('dc_required').value;
        var ins_reqired = document.getElementById('ins_reqired').value;
        if(ins_reqired=='on'){
        var po_num = document.getElementById('po_num').value;
        // alert(po_num);
        var po_unique_id = document.getElementById('po_unique_id').value;
        //   alert(po_form_unique_id);
        var po_form_unique_id = document.getElementById('po_form_unique_id').value;
        //   alert(po_unique_id);
        var po_date = document.getElementById('po_date').value;
        var invoice_auto_id = document.getElementById('invoice_auto_id').value;
        var invoice_no = document.getElementById('invoice_no').value;

        var invoice_date = document.getElementById('invoice_date').value;
        var consignee_unique_id = document.getElementById('consignee_unique_id').value;
        var engineer_name = document.getElementById('engineer_name').value;
        var ins_com_date = document.getElementById('ins_com_date').value;
        var eng_remarks = document.getElementById('eng_remarks').value;
        // var cus_ack_date = document.getElementById('cus_ack_date').value;

        var dc_received_sts = document.getElementById('dc_received_sts').value;
        var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
        var ir_rec_status = document.getElementById('ir_rec_status').value;
        var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
        var snr_rec_status = document.getElementById('snr_rec_status').value;
        var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;
        //  var consignee_unique_id = document.getElementById('consignee_unique_id').value;


        // var form_unique_id = document.getElementById('form_unique_id').value;
        
var dc_file_data;
element = document.getElementById('dc_file_data');
if (element != null) {
    dc_file_data = element.value;
}
else {
    dc_file_data = null;
}


var dc_file_name;
element1 = document.getElementById('dc_file_name');
if (element1 != null) {
    dc_file_name = element1.value;
}
else {
    dc_file_name = null;
}

var snr_file_data;
element2 = document.getElementById('snr_file_data');
if (element2 != null) {
    snr_file_data = element2.value;
}
else {
    snr_file_data = null;
}

var snr_file_name;
element3 = document.getElementById('snr_file_name');
if (element3 != null) {
    snr_file_name = element3.value;
}
else {
    snr_file_name = null;
}

     

var documents_type = document.getElementById('documents_type').checked;
var documents_type1 = document.getElementById('documents_type1').checked;
var documents_type2 = document.getElementById('documents_type2').checked;

// Set checkbox variables based on their checked state
var dc_checkbox = documents_type ? 'DC' : '0';
var ir_checkbox = documents_type1 ? 'IR' : '0';
var snr_checkbox = documents_type2 ? 'SNR' : '0';

// Set checkbox variables based on their checked state
var dc_checkbox = documents_type ? 'DC' : '0';
var ir_checkbox = documents_type1 ? 'IR' : '0';
var snr_checkbox = documents_type2 ? 'SNR' : '0';

// If only one checkbox is checked, store its value
if (documents_type && !documents_type1 && !documents_type2) {
  // Only DC checkbox is checked
  dc_checkbox = 'DC';
} else if (!documents_type && documents_type1 && !documents_type2) {
  // Only IR checkbox is checked
  ir_checkbox = 'IR';
} else if (!documents_type && !documents_type1 && documents_type2) {
  // Only SNR checkbox is checked
  snr_checkbox = 'SNR';
}

// If two checkboxes are checked, store both values
if (documents_type && documents_type1 && !documents_type2) {
  // DC and IR checkboxes are checked
  dc_checkbox = 'DC';
//   alert(dc_checkbox);
  ir_checkbox = 'IR';
//   alert(ir_checkbox);
} else if (documents_type && !documents_type1 && documents_type2) {
  // DC and SNR checkboxes are checked
  dc_checkbox = 'DC';
  snr_checkbox = 'SNR';
} 

else if (documents_type1 && documents_type && documents_type2) {
  // IR checkbox is checked after DC and SNR
  dc_checkbox = 'DC';
//   alert(dc_checkbox);
  snr_checkbox = 'SNR';
//   alert(snr_checkbox);
  ir_checkbox = 'IR'; // Update IR value without changing DC and SNR values
//   alert(ir_checkbox);
}

        var test_doc = document.getElementById('dc_file').value;
        // alert(test_doc);
        var test_doc1 = document.getElementById('ir_file').value;
        // alert(test_doc1);
        var test_doc2 = document.getElementById('snr_file').value;

        var image_s = document.getElementById("dc_file");

        var image_ir = document.getElementById("ir_file");
        var image_in = document.getElementById("snr_file");


        // var is_form = form_validity_check("was-validated");
        var data = new FormData();
        if (image_s != '') {
            if (image_s.files) {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("test_file[]", document.getElementById('dc_file').files[i]);
                }
            }
        } else {

            data.append("test_doc", '');

        }

        if (image_ir != '') {
            if (image_ir.files) {
                for (var i = 0; i < image_ir.files.length; i++) {
                    data.append("test_file1[]", document.getElementById('ir_file').files[i]);
                }
            }
        } else {

            data.append("test_doc1", '');

        }
        if (image_in != '') {
            if (image_in.files) {
                for (var i = 0; i < image_in.files.length; i++) {
                    data.append("test_file2[]", document.getElementById('snr_file').files[i]);
                }
            }
        } else {

            data.append("test_doc2", '');

        }
    }
    else if(dc_required=='on'){
        // alert();
        var po_num = document.getElementById('po_num').value;
        // alert(po_num);
        var po_unique_id = document.getElementById('po_unique_id').value;
        //   alert(po_form_unique_id);
        var po_form_unique_id = document.getElementById('po_form_unique_id').value;
        //   alert(po_unique_id);
        var po_date = document.getElementById('po_date').value;
        var invoice_auto_id = document.getElementById('invoice_auto_id').value;
        var invoice_no = document.getElementById('invoice_no').value;

        var invoice_date = document.getElementById('invoice_date').value;
        var consignee_unique_id = document.getElementById('consignee_unique_id').value;
        var engineer_name = document.getElementById('engineer_name').value;
        var ins_com_date = document.getElementById('ins_com_date').value;
        var eng_remarks = document.getElementById('eng_remarks').value;
        // data.append("", eng_remarks);
        // var cus_ack_date = document.getElementById('cus_ack_date').value;
        // var eng_remarks = document.getElementById('eng_remarks').value;
        var dc_received_sts = document.getElementById('dc_received_sts').value;
        var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
var dc_file_data;
element = document.getElementById('dc_file_data');
if (element != null) {
    dc_file_data = element.value;
}
else {
    dc_file_data = null;
}
var dc_file_name;
element1 = document.getElementById('dc_file_name');
if (element1 != null) {
    dc_file_name = element1.value;
}
else {
    dc_file_name = null;
}
var documents_type = document.getElementById('documents_type').checked;
// var documents_type = document.getElementById('documents_type').checked;
var documents_type1 = document.getElementById('documents_type1').checked;
var documents_type2 = document.getElementById('documents_type2').checked;
var dc_checkbox = documents_type ? 'DC' : '0';
if (documents_type) {
  dc_checkbox = 'DC';
} 
        var test_doc = document.getElementById('dc_file').value;
        var image_s = document.getElementById("dc_file");
        var data = new FormData();
        if (image_s != '') {
            if (image_s.files) {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("test_file[]", document.getElementById('dc_file').files[i]);
                }
            }
        } else {
            data.append("test_doc", '');
        }

    }
        data.append("po_num", po_num);
        data.append("po_form_unique_id", po_form_unique_id);
        data.append("po_unique_id", po_unique_id);
        data.append("po_date", po_date);
        data.append("invoice_auto_id", invoice_auto_id);
        data.append("invoice_no", invoice_no);
        data.append("invoice_date", invoice_date);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("engineer_name", engineer_name);
        data.append("ins_com_date", ins_com_date);
        data.append("eng_remarks", eng_remarks);
        // data.append("", eng_remarks);
        // data.append("cus_ack_date", cus_ack_date);
        data.append("documents_type", dc_checkbox);
        data.append("documents_type1", ir_checkbox);
        data.append("documents_type2", snr_checkbox);
        data.append("dc_received_sts", dc_received_sts);
        data.append("dc_cus_signed_date", dc_cus_signed_date);
        data.append("ir_rec_status", ir_rec_status);
        data.append("ir_cus_signed_date", ir_cus_signed_date);
        data.append("snr_rec_status", snr_rec_status);
        data.append("snr_cus_signed_date", snr_cus_signed_date);
        // data.append("form_unique_id", form_unique_id);
        data.append("dc_file_data", dc_file_data);
        data.append("dc_file_name", dc_file_name);
        data.append("snr_file_data", snr_file_data);
        data.append("snr_file_name", snr_file_name);
        data.append("action", "demo");
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
            beforeSend: function() {
            },
            success: function(data) {
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                } else {
                    if (msg == "already") {
                        url = '';
                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                        if (form_unique_id) {
                            $(".createupdate_btn").text("Update");
                        } else {
                            $(".createupdate_btn").text("Save");
                        }
                    }
                }
                sweetalert(msg, url);
            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }


    $(document).ready(function() {
    // Set initial engineer name options based on selected Engg. Type
    updateEngineerNameOptions();

    // Listen for changes in Engg. Type dropdown
    $('#engg_type').on('change', function() {
        updateEngineerNameOptions();
    });

    function updateEngineerNameOptions() {
        var enggType = $('#engg_type').val();
        var engineerNameSelect = $('#engineer_name');
        
        // Clear existing options
        engineerNameSelect.empty();
        
        // Add default option
        engineerNameSelect.append('<option value="">Select Engg. Name</option>');
        
        // Check which Engg. Type is selected and load corresponding options
        if (enggType == '1') { // Own Engineer
            // Append Own Engineer options
            <?php echo $engineer_name_options; ?>
        } else if (enggType == '2') { // Outsource Vendor
            // Append Outsource Vendor options
            <?php echo $engineer_type_options; ?>
        }
    }
});

</script>
