<?php

// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = "view_payment_entry_list";
$table_claim="view_payment_entry_list_1";
$table_main             = "bill_submission_main_table";
$table_sub   = "bill_submission_sub";



// $table             = "view_bill_submission_list";
$table_sub_form     = "bill_submission_form";
$table_inv     = "invoice_creation_main";
// $table_sub  =  "bill_submission_sub";
// $table_main_table    = "bill_submission_main_table";
$table_bg_main   =  "bg_creation_main";
$table_bg_sub   =  "bg_creation_sub";
$table_sign_doc  =  "sign_doc_verification_detail";

$table_final_elcot = 'view_elcot_entry_final';
include '../../config/dbconfig.php';
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

// Include DB file and Common Functions


// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$user_type          = "";
$is_active          = "";
$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose




switch ($action) {
    case 'createupdate':
        $ins_unique_id                  = $_POST["ins_unique_id"];
        $bill_form_main_unique_id         = $_POST["bill_form_main_unique_id"];
        $po_num    = $_POST["po_num"];
        $po_date          = $_POST["po_date"];
        $con_contact_name          = $_POST["con_contact_name"];
        $con_address          = $_POST["con_address"];
        $invoice_no    = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $invoice_value          = $_POST["invoice_value"];
        $file_name          = $_POST["file_name"];
        $consignee_unique_id    = $_POST["consignee_unique_id"];
        $scanned_dc_copy          = $_POST["scanned_dc_copy"];
        $scanned_ir_copy          = $_POST["scanned_ir_copy"];
        $scanned_snr_copy          = $_POST["scanned_snr_copy"];
        $invoice_copy          = $_POST["invoice_copy"];
        $installation_reference_no    = $_POST["installation_reference_no"];
        $supplier_invoice_number          = $_POST["supplier_invoice_number"];
        $unique_id                  = $_POST["unique_id"];
        $bill_status                  = $_POST["bill_status"];
        // $dc_no                  = $_POST["dc_no"];

        $invoice_qty              = $_POST["invoice_qty"];
        $claim_amount              = $_POST["claim_amount"];
        $claim_amt = ((floatval($invoice_value) *  $claim_amount ) / 100);

        if (is_array($_FILES["test_file"]['name'])) {
            if ($_FILES["test_file"]['name'][0] != "") {
                // Multi file Upload 
                $confirm_upload     = $fileUpload->uploadFiles("test_file");
                if (is_array($confirm_upload)) {
                    // print_r($_FILES["test_file"]['name']);
                    $_FILES["test_file"]['file_name'] = [];
                    foreach ($confirm_upload as $c_key => $c_value) {
                        if ($c_value->status == 1) {
                            $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                            array_push($_FILES["test_file"]['file_name'], $c_file_name);
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                            break;
                        }
                    }
                } else if (!empty($_FILES["test_file"]['name'])) { // Single File Upload
                    $confirm_upload     = $fileUpload->uploadFile("test_file");
                    if ($confirm_upload->status == 1) {
                        $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                        $_FILES["test_file"]['file_name']  = $c_file_name;
                    } else { // if Any Error Occured in File Upload Stop the loop
                        $status     = $confirm_upload->status;
                        $data       = "file not uploaded";
                        $error      = $confirm_upload->error;
                        $sql        = "file upload error";
                        $msg        = "file_error";
                    }
                }
            }
        }
        if (is_array($_FILES["test_file"]['name'])) {
            if ($_FILES["test_file"]['name'][0] != "") {
                $file_names     = implode(",", $_FILES["test_file"]['file_name']);
                $file_org_names = implode(",", $_FILES["test_file"]['name']);
            }
        } else if (!empty($_FILES["test_file"]['name'])) {
            $file_names     = $_FILES["test_file"]['file_name'];
            $file_org_names = $_FILES["test_file"]['name'];
        }
        // 1st image close
        // 2nd image open 
        if (is_array($_FILES["test_file1"]['name'])) {
            if ($_FILES["test_file1"]['name'][0] != "") {
                // Multi file Upload 
                $confirm_upload     = $fileUpload->uploadFiles("test_file1");
                if (is_array($confirm_upload)) {
                    // print_r($_FILES["test_file"]['name']);
                    $_FILES["test_file1"]['file_name'] = [];
                    foreach ($confirm_upload as $c_key => $c_value) {
                        if ($c_value->status == 1) {
                            $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                            array_push($_FILES["test_file1"]['file_name'], $c_file_name);
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                            break;
                        }
                    }
                } else if(!empty($_FILES["test_file1"]['name'])) { // Single File Upload
                    $confirm_upload     = $fileUpload->uploadFile("test_file1");
                    if ($confirm_upload->status == 1) {
                        $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                        $_FILES["test_file1"]['file_name']  = $c_file_name;
                    } else { // if Any Error Occured in File Upload Stop the loop
                        $status     = $confirm_upload->status;
                        $data       = "file not uploaded";
                        $error      = $confirm_upload->error;
                        $sql        = "file upload error";
                        $msg        = "file_error";
                    }
                }
            }
        }
        if (is_array($_FILES["test_file1"]['name'])) {
            if ($_FILES["test_file1"]['name'][0] != "") {
                $ir_file_names     = implode(",", $_FILES["test_file1"]['file_name']);
                $ir_file_org_names = implode(",", $_FILES["test_file1"]['name']);
            }
        } else if (!empty($_FILES["test_file1"]['name'])) {
            $ir_file_names     = $_FILES["test_file1"]['file_name'];
            $ir_file_org_names = $_FILES["test_file1"]['name'];
        }
        // 2nd image close
        // 3rd image open
        if (is_array($_FILES["test_file2"]['name'])) {
            if ($_FILES["test_file2"]['name'][0] != "") {
                // Multi file Upload 
                $confirm_upload     = $fileUpload->uploadFiles("test_file2");
                if (is_array($confirm_upload)) {
                    // print_r($_FILES["test_file"]['name']);
                    $_FILES["test_file2"]['file_name'] = [];
                    foreach ($confirm_upload as $c_key => $c_value) {
                        if ($c_value->status == 1) {
                            $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                            array_push($_FILES["test_file2"]['file_name'], $c_file_name);
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                            break;
                        }
                    }
                } else if(!empty($_FILES["test_file2"]['name'])) { // Single File Upload
                    $confirm_upload     = $fileUpload->uploadFile("test_file2");
                    if($confirm_upload->status == 1) {
                        $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                        $_FILES["test_file2"]['file_name']  = $c_file_name;
                    } else{ // if Any Error Occured in File Upload Stop the loop
                        $status     = $confirm_upload->status;
                        $data       = "file not uploaded";
                        $error      = $confirm_upload->error;
                        $sql        = "file upload error";
                        $msg        = "file_error";
                    }
                }
            }
        }
        if (is_array($_FILES["test_file2"]['name'])) {
            if ($_FILES["test_file2"]['name'][0] != "") {
                $invoice_file_names     = implode(",", $_FILES["test_file2"]['file_name']);
                $invoice_original_name = implode(",", $_FILES["test_file2"]['name']);
            }
        } else if(!empty($_FILES["test_file2"]['name'])) {
            $invoice_file_names     = $_FILES["test_file2"]['file_name'];
            $invoice_original_name = $_FILES["test_file2"]['name'];
        }
        // 3rd image close

        // 4rd image open
        if (is_array($_FILES["test_file3"]['name'])) {
            if($_FILES["test_file3"]['name'][0]!= "") {
                // Multi file Upload 
                $confirm_upload     = $fileUpload->uploadFiles("test_file3");
                if (is_array($confirm_upload)) {
                    // print_r($_FILES["test_file"]['name']);
                    $_FILES["test_file3"]['file_name'] = [];
                    foreach ($confirm_upload as $c_key => $c_value) {
                        if ($c_value->status == 1) {
                            $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                            array_push($_FILES["test_file3"]['file_name'], $c_file_name);
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                            break;
                        }
                    }
                } else if (!empty($_FILES["test_file3"]['name'])) { // Single File Upload
                    $confirm_upload     = $fileUpload->uploadFile("test_file3");
                    if ($confirm_upload->status == 1) {
                        $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                        $_FILES["test_file3"]['file_name']  = $c_file_name;
                    } else { // if Any Error Occured in File Upload Stop the loop
                        $status     = $confirm_upload->status;
                        $data       = "file not uploaded";
                        $error      = $confirm_upload->error;
                        $sql        = "file upload error";
                        $msg        = "file_error";
                    }
                }
            }
        }
        if (is_array($_FILES["test_file3"]['name'])) {
            if($_FILES["test_file3"]['name'][0]!= "") {
                $snr_file_names     = implode(",", $_FILES["test_file3"]['file_name']);
                $snr_original_name = implode(",", $_FILES["test_file3"]['name']);
            }
        } else if(!empty($_FILES["test_file3"]['name'])) {
            $snr_file_names     = $_FILES["test_file3"]['file_name'];
            $snr_original_name = $_FILES["test_file3"]['name'];
        }
        // 4rd image close

        $update_where       = "";
        //  if (($file_names) && ($file_org_names) || ($invoice_file_names) && ($invoice_original_name) || ($ir_file_names) && ($ir_file_org_names)) {
        $columns            = [
            'bill_form_main_unique_id'               => $bill_form_main_unique_id,
            'po_num'     => $po_num,
            'po_date'           => $po_date,
            'con_contact_name'  => $con_contact_name,
            'con_address'          => $con_address,
            'invoice_no'           => $invoice_no,
            'invoice_date'  => $invoice_date,
            'invoice_value'          => $invoice_value,
            // 'file_name'           => $file_name,
            'consignee_unique_id'  => $consignee_unique_id,
            'claim_amount'          => $claim_amount,
            'installation_reference_no'          => $installation_reference_no,
            'supplier_invoice_number'          => $supplier_invoice_number,
            'scanned_dc_copy'               => $file_names,
            'dc_original_name'     => $file_org_names,
            'scanned_snr_copy'               => $snr_file_names,
            'snr_original_name'     => $snr_original_name,
            'scanned_ir_copy'           => $ir_file_names,
            'ir_original_name'  => $ir_file_org_names,
            'invoice_copy'          => $invoice_file_names,
            'invoice_original_name'          => $invoice_original_name,
            'bill_status'          => $bill_status,
            'invoice_qty'          => $invoice_qty,
            'ins_unique_id'          => $ins_unique_id,
            'claim_amt'          => $claim_amt,
            // 'dc_no'          => $dc_no,
            "unique_id"             => unique_id($prefix)
        ];

        // $columns_5 = [
        //     "bill_status"     => $bill_status,
        // ];
        // // consignee_unique_id
        // // $update_where_1   = [
        // //         "form_main_unique_id"     => $po_form_unique_id
        // //     ];
        // $update_where_5 = 'form_main_unique_id="'.$bill_form_main_unique_id.'" and con_unique_id="'.$consignee_unique_id.'" AND invoice_no="'.$invoice_no.'"  AND ins_unique_id="'.$ins_unique_id.'"  ';
        // $action_obj_5    = $pdo->update($table_bg_sub  ,$columns_5, $update_where_5);
        // print_r($action_obj_5);
        // } else {
        //     $columns            = [
        // 'bill_form_main_unique_id'               => $bill_form_main_unique_id,
        // 'po_num'     => $po_num,
        // 'po_date'           => $po_date,
        // 'con_contact_name'  => $con_contact_name,
        // 'con_address'          => $con_address,
        // 'invoice_no'           => $invoice_no,
        // 'invoice_date'  => $invoice_date,
        // // 'invoice_value'          => $invoice_value,
        // 'file_name'           => $file_name,
        // 'consignee_unique_id'  => $consignee_unique_id,
        // 'invoice_value'          => $invoice_value,
        // 'installation_reference_no'          => $installation_reference_no,
        // 'supplier_invoice_number'          => $supplier_invoice_number,
        //  'bill_status'              => $bill_status,
        //  'invoice_qty'          =>$invoice_qty,
        //  'unique_id'           => unique_id($prefix)
        //     ];
        // }
        // bg main table update
        // $columns_12 = [
        //     "bill_status"     => $bill_status,
        // ];
        // // consignee_unique_id
        // // $update_where_1   = [
        // //         "form_main_unique_id"     => $po_form_unique_id
        // //     ];
        // $update_where_12 = 'form_main_unique_id="' . $bill_form_main_unique_id .'"';
        // $action_obj_12     = $pdo->update($table_bg_main, $columns_12, $update_where_12);
        // invoice main table update
        // $columns_1 = [
        //     "bill_status"     => $bill_status,
        // ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        // $update_where_1 = 'form_main_unique_id="' . $bill_form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        // $action_obj_1     = $pdo->update($table_inv, $columns_1, $update_where_1);


        $columns_7 = [
            "partial_bill_status"     => $bill_status,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_7 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        $action_obj_7     = $pdo->update($table_sub_form , $columns_7, $update_where_7);
// print_r($action_obj_7);
       
        // print_r($action_obj_1);
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where   = [
                "unique_id"     => $unique_id
            ];
            $action_obj     = $pdo->update($table_sub_form, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table_sub_form, $columns);
            // Insert Ends
        }
        // print_r($action_obj);
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            if ($unique_id) {
                $msg        = "update";
            } else {
                $msg        = "create";
            }
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }
        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];
        echo json_encode($json_array);
        break;



        case 'installation_cu':


            $po_num          = $_POST['po_num'];
            $po_unique_id          = $_POST['po_unique_id'];
            $form_main_unique_id          = $_POST['po_form_unique_id'];
            $po_date              = $_POST['po_date'];
            $invoice_auto_id = $_POST['invoice_auto_id'];
            $invoice_no            = $_POST['invoice_no'];
            // $no_of_consignee     = $_POST['no_of_consignee'];
            $invoice_date        = $_POST['invoice_date'];
            $consignee_unique_id            = $_POST['consignee_unique_id'];
            $engineer_name              = $_POST['engineer_name'];
            // $ins_com_date              = $_POST['ins_com_date'];
            // $cus_ack_date            = $_POST['cus_ack_date'];
            $documents_type              = $_POST['documents_type'];
            $documents_type1              = $_POST['documents_type1'];
            $documents_type2              = $_POST['documents_type2'];
            $dc_received_sts             = $_POST['dc_received_sts'];
            $dc_cus_signed_date       = $_POST['dc_cus_signed_date'];
            $ir_rec_status            = $_POST['ir_rec_status'];
            $ir_cus_signed_date          = $_POST['ir_cus_signed_date'];
            $snr_rec_status              = $_POST['snr_rec_status'];
            $snr_cus_signed_date             = $_POST['snr_cus_signed_date'];
            $unique_id             = $_POST['unique_id'];
            // 1st image open
    
            if (is_array($_FILES["test_file"]['name'])) {
                if ($_FILES["test_file"]['name'][0] != "") {
                    // Multi file Upload 
                    $confirm_upload     = $fileUpload->uploadFiles("test_file");
                    if (is_array($confirm_upload)) {
                        // print_r($_FILES["test_file"]['name']);
                        $_FILES["test_file"]['file_name'] = [];
                        foreach ($confirm_upload as $c_key => $c_value) {
                            if ($c_value->status == 1) {
                                $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                array_push($_FILES["test_file"]['file_name'], $c_file_name);
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                                break;
                            }
                        }
                    } else if (!empty($_FILES["test_file"]['name'])) { // Single File Upload
                        $confirm_upload     = $fileUpload->uploadFile("test_file");
                        if ($confirm_upload->status == 1) {
                            $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                            $_FILES["test_file"]['file_name']  = $c_file_name;
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                        }
                    }
                }
            }
            if (is_array($_FILES["test_file"]['name'])) {
                if ($_FILES["test_file"]['name'][0] != "") {
                    $file_names     = implode(",", $_FILES["test_file"]['file_name']);
                    $file_org_names = implode(",", $_FILES["test_file"]['name']);
                }
            } else if (!empty($_FILES["test_file"]['name'])) {
                $file_names     = $_FILES["test_file"]['file_name'];
                $file_org_names = $_FILES["test_file"]['name'];
            }
            // 1st image close
    
            // 2nd image open 
            if (is_array($_FILES["test_file1"]['name'])) {
                if ($_FILES["test_file1"]['name'][0] != "") {
                    // Multi file Upload 
                    $confirm_upload     = $fileUpload->uploadFiles("test_file1");
                    if (is_array($confirm_upload)) {
                        // print_r($_FILES["test_file"]['name']);
                        $_FILES["test_file1"]['file_name'] = [];
                        foreach ($confirm_upload as $c_key => $c_value) {
                            if ($c_value->status == 1) {
                                $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                array_push($_FILES["test_file1"]['file_name'], $c_file_name);
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                                break;
                            }
                        }
                    } else if (!empty($_FILES["test_file1"]['name'])) { // Single File Upload
                        $confirm_upload     = $fileUpload->uploadFile("test_file1");
                        if ($confirm_upload->status == 1) {
                            $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                            $_FILES["test_file1"]['file_name']  = $c_file_name;
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                        }
                    }
                }
            }
            if (is_array($_FILES["test_file1"]['name'])) {
                if ($_FILES["test_file1"]['name'][0] != "") {
                    $ir_file_names     = implode(",", $_FILES["test_file1"]['file_name']);
                    $ir_file_org_names = implode(",", $_FILES["test_file1"]['name']);
                }
            } else if (!empty($_FILES["test_file1"]['name'])) {
                $ir_file_names     = $_FILES["test_file1"]['file_name'];
                $ir_file_org_names = $_FILES["test_file1"]['name'];
            }
            // 2nd image close
            // 3rd image open
            if (is_array($_FILES["test_file2"]['name'])) {
                if ($_FILES["test_file2"]['name'][0] != "") {
                    // Multi file Upload 
                    $confirm_upload     = $fileUpload->uploadFiles("test_file2");
                    if (is_array($confirm_upload)) {
                        // print_r($_FILES["test_file"]['name']);
                        $_FILES["test_file2"]['file_name'] = [];
                        foreach ($confirm_upload as $c_key => $c_value) {
                            if ($c_value->status == 1) {
                                $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                array_push($_FILES["test_file2"]['file_name'], $c_file_name);
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                                break;
                            }
                        }
                    } else if (!empty($_FILES["test_file2"]['name'])) { // Single File Upload
                        $confirm_upload     = $fileUpload->uploadFile("test_file2");
                        if ($confirm_upload->status == 1) {
                            $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                            $_FILES["test_file2"]['file_name']  = $c_file_name;
                        } else { // if Any Error Occured in File Upload Stop the loop
                            $status     = $confirm_upload->status;
                            $data       = "file not uploaded";
                            $error      = $confirm_upload->error;
                            $sql        = "file upload error";
                            $msg        = "file_error";
                        }
                    }
                }
            }
            if (is_array($_FILES["test_file2"]['name'])) {
                if ($_FILES["test_file2"]['name'][0] != "") {
                    $snr_file_names     = implode(",", $_FILES["test_file2"]['file_name']);
                    $snr_file_org_names = implode(",", $_FILES["test_file2"]['name']);
                }
            } else if (!empty($_FILES["test_file2"]['name'])) {
                $snr_file_names     = $_FILES["test_file2"]['file_name'];
                $snr_file_org_names = $_FILES["test_file2"]['name'];
            }
            // 3rd image close
    
    
            $update_where          = '';
            if (($file_names) && ($file_org_names)  || ($snr_file_names) && ($snr_file_org_names) || ($ir_file_names) && ($ir_file_org_names)) {
    
                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    // 'installation_com_date'             => $ins_com_date,
                    // 'cus_ack_date'             => $cus_ack_date,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    'dc_file'               => $file_names,
                    'dc_original_name'     => $file_org_names,
                    'ir_file'           => $ir_file_names,
                    'ir_original_name'  => $ir_file_org_names,
                    'snr_file'          => $snr_file_names,
                    // 'unique_id'          => $unique_id,
                    'snr_original_name'  => $snr_file_org_names,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'unique_id'              => unique_id($prefix),
                ];
            }
            if (($file_names) && ($file_org_names)) {
    
                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    // 'installation_com_date'             => $ins_com_date,
                    // 'cus_ack_date'             => $cus_ack_date,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    'dc_file'               => $file_names,
                    'dc_original_name'     => $file_org_names,
                    // 'ir_file'           => $ir_file_names,
                    // 'ir_original_name'  => $ir_file_org_names,
                    // 'snr_file'          => $snr_file_names,
                    // 'unique_id'          => $unique_id,
                    // 'snr_original_name'  => $snr_file_org_names,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'unique_id'              => unique_id($prefix),
                ];
            }
            if (($ir_file_names) && ($ir_file_org_names)) {
    
                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    // 'installation_com_date'             => $ins_com_date,
                    // 'cus_ack_date'             => $cus_ack_date,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    // 'dc_file'               => $file_names,
                    // 'dc_original_name'     => $file_org_names,
                    'ir_file'           => $ir_file_names,
                    'ir_original_name'  => $ir_file_org_names,
                    // 'snr_file'          => $snr_file_names,
                    // 'unique_id'          => $unique_id,
                    // 'snr_original_name'  => $snr_file_org_names,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'unique_id'              => unique_id($prefix),
                ];
            }
            if (($snr_file_names) && ($snr_file_org_names)) {
    
                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    // 'installation_com_date'             => $ins_com_date,
                    // 'cus_ack_date'             => $cus_ack_date,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    // 'dc_file'               => $file_names,
                    // 'dc_original_name'     => $file_org_names,
                    // 'ir_file'           => $ir_file_names,
                    // 'ir_original_name'  => $ir_file_org_names,
                    'snr_file'          => $snr_file_names,
                    // 'unique_id'          => $unique_id,
                    'snr_original_name'  => $snr_file_org_names,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'unique_id'              => unique_id($prefix),
                ];
            }
    
            // check already Exist Or not
            if ($unique_id) {
    
                unset($columns['unique_id']);
    
    
                // $update_where   = [
                //     "unique_id"     => $unique_id
                // ];
                $update_where   = 'unique_id="' . $unique_id . '"';
    
                $action_obj     = $pdo->update($table_sub, $columns, $update_where);
    
                // Update Ends
            } else {
                // Insert Begins
    
                $action_obj     = $pdo->insert($table_sub, $columns);
                // Insert Ends
            }
            // print_r($action_obj);die();
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = '';
                $sql        = $action_obj->sql;
                if ($unique_id) {
                    $msg        = "update";
                } else {
                    $msg        = "create";
                }
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = 'error';
            }
            // }
    
            $json_array   = [
                'status'    => $status,
                'data'      => $data,
                'error'     => $error,
                'msg'       => $msg,
                'sql'       => $sql
    
            ];
    
            echo json_encode($json_array);
    
            break;



            case 'installation_sub':
                // print_r('hi');die();
                $po_num          = $_POST['po_num'];
                $po_unique_id          = $_POST['po_unique_id'];
                $form_main_unique_id          = $_POST['po_form_unique_id'];
                $po_date              = $_POST['po_date'];
                $invoice_auto_id = $_POST['invoice_auto_id'];
                $invoice_no            = $_POST['invoice_no'];
                // $no_of_consignee     = $_POST['no_of_consignee'];
                $invoice_date        = $_POST['invoice_date'];
                $consignee_unique_id            = $_POST['consignee_unique_id'];
                $engineer_name              = $_POST['engineer_name'];
                // $ins_com_date              = $_POST['ins_com_date'];
                // $cus_ack_date            = $_POST['cus_ack_date'];
                $documents_type              = $_POST['documents_type'];
                $documents_type1              = $_POST['documents_type1'];
                $documents_type2              = $_POST['documents_type2'];
                $dc_received_sts             = $_POST['dc_received_sts'];
                $dc_cus_signed_date       = $_POST['dc_cus_signed_date'];
                $ir_rec_status            = $_POST['ir_rec_status'];
                $ir_cus_signed_date          = $_POST['ir_cus_signed_date'];
                $snr_rec_status              = $_POST['snr_rec_status'];
                $snr_cus_signed_date             = $_POST['snr_cus_signed_date'];
                $dc_file_data             = $_POST['dc_file_data'];
                $dc_file_name             = $_POST['dc_file_name'];
                $snr_file_data             = $_POST['snr_file_data'];
                $snr_file_name             = $_POST['snr_file_name'];
        
                // print_r($dc_file_data.','.$dc_file_name);die();
                $wheres = "is_delete = 0 order by id DESC";
                $table_1      =  "installation_details";
        
                $columns_3    = [
                    'max(unique_id) as unique_id',
        
                ];
        
                $tables   = [
                    $table_1,
                    $columns_3
                ];
        
                // $order = "id Desc";
                $result_values_12  = $pdo->select($tables, $wheres);
                // print_r($result_values_12);die();
                $datada       = $result_values_12->data;
        
                // if($form_unique_ids == ''){
                $form_unique_id            = $datada[0]['unique_id'];
                // }
        
                // print_r($form_unique_id);die();
        
                // 1st image open
        
                if (is_array($_FILES["test_file"]['name'])) {
                    if ($_FILES["test_file"]['name'][0] != "") {
                        // Multi file Upload 
                        $confirm_upload     = $fileUpload->uploadFiles("test_file");
                        if (is_array($confirm_upload)) {
                            // print_r($_FILES["test_file"]['name']);
                            $_FILES["test_file"]['file_name'] = [];
                            foreach ($confirm_upload as $c_key => $c_value) {
                                if ($c_value->status == 1) {
                                    $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                    array_push($_FILES["test_file"]['file_name'], $c_file_name);
                                } else { // if Any Error Occured in File Upload Stop the loop
                                    $status     = $confirm_upload->status;
                                    $data       = "file not uploaded";
                                    $error      = $confirm_upload->error;
                                    $sql        = "file upload error";
                                    $msg        = "file_error";
                                    break;
                                }
                            }
                        } else if (!empty($_FILES["test_file"]['name'])) { // Single File Upload
                            $confirm_upload     = $fileUpload->uploadFile("test_file");
                            if ($confirm_upload->status == 1) {
                                $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                                $_FILES["test_file"]['file_name']  = $c_file_name;
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                            }
                        }
                    }
                }
                if (is_array($_FILES["test_file"]['name'])) {
                    if ($_FILES["test_file"]['name'][0] != "") {
                        $file_names     = implode(",", $_FILES["test_file"]['file_name']);
                        $file_org_names = implode(",", $_FILES["test_file"]['name']);
                    }
                } else if (!empty($_FILES["test_file"]['name'])) {
                    $file_names     = $_FILES["test_file"]['file_name'];
                    $file_org_names = $_FILES["test_file"]['name'];
                }
                // 1st image close
        
                // 2nd image open 
                if (is_array($_FILES["test_file1"]['name'])) {
                    if ($_FILES["test_file1"]['name'][0] != "") {
                        // Multi file Upload 
                        $confirm_upload     = $fileUpload->uploadFiles("test_file1");
                        if (is_array($confirm_upload)) {
                            // print_r($_FILES["test_file"]['name']);
                            $_FILES["test_file1"]['file_name'] = [];
                            foreach ($confirm_upload as $c_key => $c_value) {
                                if ($c_value->status == 1) {
                                    $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                    array_push($_FILES["test_file1"]['file_name'], $c_file_name);
                                } else { // if Any Error Occured in File Upload Stop the loop
                                    $status     = $confirm_upload->status;
                                    $data       = "file not uploaded";
                                    $error      = $confirm_upload->error;
                                    $sql        = "file upload error";
                                    $msg        = "file_error";
                                    break;
                                }
                            }
                        } else if (!empty($_FILES["test_file1"]['name'])) { // Single File Upload
                            $confirm_upload     = $fileUpload->uploadFile("test_file1");
                            if ($confirm_upload->status == 1) {
                                $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                                $_FILES["test_file1"]['file_name']  = $c_file_name;
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                            }
                        }
                    }
                }
                if (is_array($_FILES["test_file1"]['name'])) {
                    if ($_FILES["test_file1"]['name'][0] != "") {
                        $ir_file_names     = implode(",", $_FILES["test_file1"]['file_name']);
                        $ir_file_org_names = implode(",", $_FILES["test_file1"]['name']);
                    }
                } else if (!empty($_FILES["test_file1"]['name'])) {
                    $ir_file_names     = $_FILES["test_file1"]['file_name'];
                    $ir_file_org_names = $_FILES["test_file1"]['name'];
                }
                // 2nd image close
                // 3rd image open
                if (is_array($_FILES["test_file2"]['name'])) {
                    if ($_FILES["test_file2"]['name'][0] != "") {
                        // Multi file Upload 
                        $confirm_upload     = $fileUpload->uploadFiles("test_file2");
                        if (is_array($confirm_upload)) {
                            // print_r($_FILES["test_file"]['name']);
                            $_FILES["test_file2"]['file_name'] = [];
                            foreach ($confirm_upload as $c_key => $c_value) {
                                if ($c_value->status == 1) {
                                    $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
                                    array_push($_FILES["test_file2"]['file_name'], $c_file_name);
                                } else { // if Any Error Occured in File Upload Stop the loop
                                    $status     = $confirm_upload->status;
                                    $data       = "file not uploaded";
                                    $error      = $confirm_upload->error;
                                    $sql        = "file upload error";
                                    $msg        = "file_error";
                                    break;
                                }
                            }
                        } else if (!empty($_FILES["test_file2"]['name'])) { // Single File Upload
                            $confirm_upload     = $fileUpload->uploadFile("test_file2");
                            if ($confirm_upload->status == 1) {
                                $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
                                $_FILES["test_file2"]['file_name']  = $c_file_name;
                            } else { // if Any Error Occured in File Upload Stop the loop
                                $status     = $confirm_upload->status;
                                $data       = "file not uploaded";
                                $error      = $confirm_upload->error;
                                $sql        = "file upload error";
                                $msg        = "file_error";
                            }
                        }
                    }
                }
                if (is_array($_FILES["test_file2"]['name'])) {
                    if ($_FILES["test_file2"]['name'][0] != "") {
                        $snr_file_names     = implode(",", $_FILES["test_file2"]['file_name']);
                        $snr_file_org_names = implode(",", $_FILES["test_file2"]['name']);
                    }
                } else if (!empty($_FILES["test_file2"]['name'])) {
                    $snr_file_names     = $_FILES["test_file2"]['file_name'];
                    $snr_file_org_names = $_FILES["test_file2"]['name'];
                }
                // 3rd image close
        
        
                $update_where          = '';
        
                if (($file_names) && ($file_org_names)) {
        
                    $columns            = [
                        'po_num'        => $po_num,
                        'po_auto_id'        => $po_unique_id,
                        'po_date'           => $po_date,
                        'invoice_auto_id'     => $invoice_auto_id,
                        'invoice_no'   => $invoice_no,
                        'invoice_date'   => $invoice_date,
                        'consignee_unique_id'   => $consignee_unique_id,
                        'engineer_name'              => $engineer_name,
                        // 'installation_com_date'             => $ins_com_date,
                        // 'cus_ack_date'             => $cus_ack_date,
                        'documents_type'              => $documents_type,
                        'documents_type1'              => $documents_type1,
                        'documents_type2'              => $documents_type2,
                        'dc_received_sts'             => $dc_received_sts,
                        'dc_cus_signed_date'             => $dc_cus_signed_date,
                        'ir_rec_status'              => $ir_rec_status,
                        'ir_cus_signed_date'         => $ir_cus_signed_date,
                        'snr_rec_status'             => $snr_rec_status,
                        'snr_cus_signed_date'             => $snr_cus_signed_date,
                        'dc_file'               => $file_names,
                        'dc_original_name'     => $file_org_names,
                        // 'ir_file'           => $ir_file_names,
                        // 'ir_original_name'  => $ir_file_org_names,
                        // 'snr_file'          => $snr_file_names,
                        'form_unique_id'          => $form_unique_id,
                        // 'snr_original_name'  => $snr_file_org_names,
                        'po_form_unique_id'   => $form_main_unique_id,
                        'installation_id'              => ins_no_get(),
                        'unique_id'              => unique_id($prefix)
                    ];
                }
                if (($ir_file_names) && ($ir_file_org_names)) {
        
                    // if(($dc_file_data) &&($dc_file_name) &&($snr_file_data) && ($snr_file_name)) {
                        $columns            = [
                            'po_num'        => $po_num,
                            'po_auto_id'        => $po_unique_id,
                            'po_date'           => $po_date,
                            'invoice_auto_id'     => $invoice_auto_id,
                            'invoice_no'   => $invoice_no,
                            'invoice_date'   => $invoice_date,
                            'consignee_unique_id'   => $consignee_unique_id,
                            'engineer_name'              => $engineer_name,
                            // 'installation_com_date'             => $ins_com_date,
                            // 'cus_ack_date'             => $cus_ack_date,
                            'documents_type'              => $documents_type,
                            'documents_type1'              => $documents_type1,
                            'documents_type2'              => $documents_type2,
                            'dc_received_sts'             => $dc_received_sts,
                            'dc_cus_signed_date'             => $dc_cus_signed_date,
                            'ir_rec_status'              => $ir_rec_status,
                            'ir_cus_signed_date'         => $ir_cus_signed_date,
                            'snr_rec_status'             => $snr_rec_status,
                            'snr_cus_signed_date'             => $snr_cus_signed_date,
                            'dc_file'               => $dc_file_data,
                            'dc_original_name'     => $dc_file_name,
                            'ir_file'           => $ir_file_names,
                            'ir_original_name'  => $ir_file_org_names,
                            'snr_file'          => $snr_file_data,
                            'form_unique_id'          => $form_unique_id,
                            'snr_original_name'  => $snr_file_name,
                            'po_form_unique_id'   => $form_main_unique_id,
                            'installation_id'              => ins_no_get(),
            
                            'unique_id'              => unique_id($prefix)
                        ];
                //     }else{
                //     $columns            = [
                //         'po_num'        => $po_num,
                //         'po_auto_id'        => $po_unique_id,
                //         'po_date'           => $po_date,
                //         'invoice_auto_id'     => $invoice_auto_id,
                //         'invoice_no'   => $invoice_no,
                //         'invoice_date'   => $invoice_date,
                //         'consignee_unique_id'   => $consignee_unique_id,
                //         'engineer_name'              => $engineer_name,
                //         'installation_com_date'             => $ins_com_date,
                //         // 'cus_ack_date'             => $cus_ack_date,
                //         'documents_type'              => $documents_type,
                //         'documents_type1'              => $documents_type1,
                //         'documents_type2'              => $documents_type2,
                //         'dc_received_sts'             => $dc_received_sts,
                //         'dc_cus_signed_date'             => $dc_cus_signed_date,
                //         'ir_rec_status'              => $ir_rec_status,
                //         'ir_cus_signed_date'         => $ir_cus_signed_date,
                //         'snr_rec_status'             => $snr_rec_status,
                //         'snr_cus_signed_date'             => $snr_cus_signed_date,
                //         // 'dc_file'               => $dc_file_data,
                //         // 'dc_original_name'     => $dc_file_name,
                //         'ir_file'           => $ir_file_names,
                //         'ir_original_name'  => $ir_file_org_names,
                //         // 'snr_file'          => $snr_file_data,
                //         'form_unique_id'          => $form_unique_id,
                //         // 'snr_original_name'  => $snr_file_name,
                //         'po_form_unique_id'   => $form_main_unique_id,
                //         'installation_id'              => ins_no_get(),
        
                //         'unique_id'              => unique_id($prefix)
                //     ];
                // }
                }
                if (($snr_file_names) && ($snr_file_org_names)) {
        
                    $columns            = [
                        'po_num'        => $po_num,
                        'po_auto_id'        => $po_unique_id,
                        'po_date'           => $po_date,
                        'invoice_auto_id'     => $invoice_auto_id,
                        'invoice_no'   => $invoice_no,
                        'invoice_date'   => $invoice_date,
                        'consignee_unique_id'   => $consignee_unique_id,
                        'engineer_name'              => $engineer_name,
                        // 'installation_com_date'             => $ins_com_date,
                        // 'cus_ack_date'             => $cus_ack_date,
                        // 'documents_type'              => $documents_type,
                        'documents_type1'              => $documents_type1,
                        'documents_type2'              => $documents_type2,
                        // 'dc_received_sts'             => $dc_received_sts,
                        // 'dc_cus_signed_date'             => $dc_cus_signed_date,
                        // 'ir_rec_status'              => $ir_rec_status,
                        // 'ir_cus_signed_date'         => $ir_cus_signed_date,
                        'snr_rec_status'             => $snr_rec_status,
                        'snr_cus_signed_date'             => $snr_cus_signed_date,
                        // 'dc_file'               => $file_names,
                        // 'dc_original_name'     => $file_org_names,
                        // 'ir_file'           => $ir_file_names,
                        // 'ir_original_name'  => $ir_file_org_names,
                        'snr_file'          => $snr_file_names,
                        'form_unique_id'          => $form_unique_id,
                        'snr_original_name'  => $snr_file_org_names,
                        'po_form_unique_id'   => $form_main_unique_id,
                        'installation_id'              => ins_no_get(),
        
                        'unique_id'              => unique_id($prefix)
                    ];
                }
        
                // check already Exist Or not
                if ($form_unique_id) {
        
                    $table_12 = 'installation_details_sublist';
                    $where123      = [
                        "form_unique_id" => $form_unique_id
                    ];
        
                    $columns_12    = [
                        "documents_type",
                        "documents_type1",
                        "documents_type2",
                        "unique_id"
                    ];
        
                    $table_details123   = [
                        $table_12,
                        $columns_12
                    ];
        
                    $sub_values  = $pdo->select($table_details123, $where123);
                    // print_r($result_values);die();
        
                    if ($sub_values->status) {
        
                        $sub_values      = $sub_values->data;
                        $count_of_values = count($sub_values);
                        // print_r($count_of_values == 0);die();
                        // print_r($result_values[0]['documents_type1']);die();
                        $current_date = date('Y-m-d');
        
                        // $dd = $sub_values[0]['documents_type2'];
                        if ($count_of_values == 0) {
                            // print_r('hi');die();
                            $action_obj     = $pdo->insert($table_inst_sublist, $columns);
                            // print_r($action_obj);die();
        
                            // Update Ends
                        }
                        if ($count_of_values != 0) {
                            if ($sub_values[0]['documents_type1'] == 0 && $sub_values[0]['documents_type2'] == 0) {
                                // print_r('hi');die();
                                unset($columns['form_unique_id']);
                                unset($columns['unique_id']);
                                unset($columns['installation_id']);
        
                                $update_where   = 'form_unique_id="' . $form_unique_id  . '"';
        
                                $action_obj     = $pdo->update($table_inst_sublist, $columns, $update_where);
                                // print_r($action_obj);die();
        
                            }
                            // if($sub_values[0]['documents_type2'] == "SNR" && $sub_values[0]['snr_rec_status'] == 1){
                            //     $action_obj     = $pdo->insert($table_inst_sublist,$columns);
                            // }
                            else {
                                // print_r('hi');die();
                                $action_obj     = $pdo->insert($table_inst_sublist, $columns);
                            }
                        }
                        // print_r($action_obj);die();
        
                    }
        
        
                    if ($action_obj->status) {
                        $status     = $action_obj->status;
                        $data       = $action_obj->data;
                        $error      = '';
                        $sql        = $action_obj->sql;
                        if ($form_unique_ids) {
                            $msg        = "update";
                        } else {
                            $msg        = "create";
                        }
                    } else {
                        $status     = $action_obj->status;
                        $data       = $action_obj->data;
                        $error      = $action_obj->error;
                        $sql        = $action_obj->sql;
                        $msg        = 'error';
                    }
                }
        
                $json_array   = [
                    'status'    => $status,
                    'data'      => $data,
                    'error'     => $error,
                    'msg'       => $msg,
                    'sql'       => $sql
        
                ];
        
                echo json_encode($json_array);
        
                break;
        
        


    // case 'datatable':
    //     // DataTable Variables
    //     $search     = $_POST['search']['value'];
    //     $length     = $_POST['length'];
    //     $start         = $_POST['start'];
    //     $draw         = $_POST['draw'];
    //     $limit         = $length;

    //     $data        = [];
    //     $claim_amount = $_POST['claim_amount'];

    //     if ($length == '-1') {
    //         $limit  = "";
    //     }

    //     // Query Variables
    //     $json_array     = "";
    //     $columns        = [
    //         "'' as  s_no",
    //         'po_num',
    //         'po_date',
    //         // 'con_contact_name',
    //         // 'con_address',
    //         'invoice_no',
    //         'invoice_date',
    //         'invoice_value',
    //         'bill_submission_date',
    //         "claim_amount",
    //         'e_no',
    //         // 'net_value',
    //         // 'qty',
    //         "ld_amount",
    //         "ld_days",
            
    //         "delivery_due_dates",
    //         "payement_receive",
    //         "file_name",
    //         "payment_status",
    //         // "payment_date",
    //         'bill_form_unique_id',
    //         "bill_no",
    //         "dc_signed_date",
    //     ];
    //     $table_details  = [
    //         $table,
    //         $columns
    //     ];
    //     // $where          = [
    //     //     "is_delete"     => 0
    //     // ];
    //     // $order_by       = "";
    //         // if($claim_amount='75' || $claim_amount='25' ){
                
    //         //     // $where = " claim_status='1'";
    //         // }
    //     $where = " claim_status='0' and claim_amount!='5' and claim_amount!='25'";

    //     $order_column   = $_POST["order"][0]["column"];
    //     $order_dir      = $_POST["order"][0]["dir"];

    //     // Datatable Ordering 
    //     $order_by       = datatable_sorting($order_column, $order_dir, $columns);

    //     // Datatable Searching
    //     $search         = datatable_searching($search, $columns);

    //     if ($search) {
    //         if ($where) {
    //             $where .= " AND ";
    //         }

    //         $where .= $search;
    //     }

    //     $sql_function   = "SQL_CALC_FOUND_ROWS";

    //     $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
    //     $total_records  = total_records();

    //     if ($result->status) {

    //         $res_array      = $result->data;

    //         foreach ($res_array as $key => $value) {
    //             $value['s_no'] = $sno + 1;

    //             $orgDate = $value['po_date'];  
    //             $value['po_date'] = date("d-m-Y", strtotime($orgDate));

    //             $orgDate1 = $value['invoice_date'];  
    //             $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));

    //             $orgDate2 = $value['bill_submission_date'];  
    //             $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));

    //             $dc_signed_date = $value['dc_signed_date'];  
    //             $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));

    //             $net_value = $value['net_value'];

    //             $qty = $value['qty'];
    //             $po_date = $value['po_date'];

    //             $delivery_due_dates = $value['delivery_due_dates'];

    //             $dc_signed_date = $value['dc_signed_date'];

    //             $signedDate = new DateTime($dc_signed_date);

    //             $total_price = $net_value * $qty;

    //             // Create a DateTime object from the given PO date
    //             $poDate = DateTime::createFromFormat('d-m-Y', $po_date);

    //             // Add the specified number of days
    //             $poDate->modify('+' . $delivery_due_dates . ' days');
                

    //             // Display the result PO date
    //             $resultDate = $poDate->format('d-m-Y');
    //             $poDate->setTime(0, 0);
    //             $signedDate->setTime(0, 0);
    //             // Calculate the difference between the result date and signed date
    //             $interval = $poDate->diff($signedDate);

    //             // Get the difference in days
    //             $lddays = $interval->format('%a');

    //             // Update the original array with the new calculated values
    //             $value['net_value'] = $lddays;

    //             // Calculate the new value (25% of the total price)
    //             //172.31.99.126
    //             $basic = ((floatval($salary) * 40) / 100);

    //             $lddays = intval($lddays);  // Convert to integer if needed
    //             $total_price = floatval($total_price);  // Convert to float if needed
                
    //             $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                
    //             $value['qty'] = floatval($ldvalue);
               
    //             $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
    //             $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
    //             // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
    //             $value['bill_form_unique_id'] = $btn_update . $btn_delete;

    //             $payment_receive = $value['payement_receive'];
    //             $payment_status = $value['payment_status'];

    //             if ($payment_receive != '') {
    //                 $value['payement_receive'] =  $payment_receive;
    //             } else {
    //                 $value['payement_receive'] = '-';
    //             }

    //             if (($payment_status == '1') || ($payment_status == '0')) {
    //                 $value['payment_status'] = 'Pending';
    //             } else if ($payment_status == '2') {
    //                 $value['payment_status'] = 'Complete';
    //             }
    //             // if ($value['is_active'] == "1") {
    //             //     $value['is_active']   = "Active";
    //             // } else {

    //             //     $value['is_active']   = "Inactive";
    //             // }


    //             $data[]             = array_values($value);
    //             $sno++;
    //         }

    //         $json_array = [
    //             "draw"                => intval($draw),
    //             "recordsTotal"         => intval($total_records),
    //             "recordsFiltered"     => intval($total_records),
    //             "data"                 => $data,
    //             "testing"            => $result->sql
    //         ];
    //     } else {
    //         print_r($result);
    //     }

    //     echo json_encode($json_array);
    //     break;


        case 'datatable':
            // DataTable Variables
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $limit         = $length;
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
    
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as  s_no",
    
                'po_num',
              
                // 'con_contact_name',
                // 'con_address',
                'invoice_no',
              
                'invoice_value',
                "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",
                // 'bill_submission_date',
                "claim_amount",
                "DATE_FORMAT(dc_signed_date, '%d-%m-%Y') AS dc_signed_date",
                // "dc_signed_date",
                // "snr_signed_date",
                "DATE_FORMAT(snr_signed_date, '%d-%m-%Y') AS snr_signed_date",
                // "ir_signed_date",
                "DATE_FORMAT(ir_signed_date, '%d-%m-%Y') AS ir_signed_date",
               
              
                // "select sum(claim_amount) from bill_submission_main_table where bill_submission_main_table.invoice_no=$table.invoice_no)as claim_amount",
                "bank_required",
                "with_bg",

                'e_no',
                // 'qty',
                // 'net_value',
                // "ld_days",
                // "ld_amount",
              
                // "dc_signed_date",
                // "warranty",
                "(select warrenty_year from product_warrenty where product_warrenty.unique_id=$table_claim.warranty) as warranty ",

                "consignee_unique_id",
                "delivery_due_dates",
               
                // "payement_receive",
                // "file_name",
                // "payment_status",
                // "payment_date",
                'bill_form_unique_id',
                'po_date',
                'invoice_date',
                "without_bg",
                "bill_no",
                "partial_bill_status",
                "(select warrenty_year from product_warrenty where product_warrenty.unique_id=$table_claim.product_warranty_duration ) as product_warranty_duration ",

            //    "(select delivery_due_days from invoice_creation where invoice_creation.product_unique_id=$table_claim.invoice_no group by invoice_no) as product_warranty_duration ",


                
            ];
            $table_details  = [
                $table_claim,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
    
            $where = " partial_bill_status='0' AND claim_amount='95' || claim_amount='75'";   
            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
            // Datatable Ordering 
            $order_by       = datatable_sorting($order_column, $order_dir, $columns);
    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result );
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
                    $claim_amount = $value['claim_amount'];  
                    if($claim_amount =='75'){
                        $claim_amt = 100-$claim_amount;
                    }
                    else if($claim_amount =='95'){
                        $claim_amt = 100-$claim_amount;
                    }
                    $value['claim_amount'] = '<span>' . $value['claim_amount'] . '</span> / <span>' . $claim_amt . '</span>';
                
                   
                    $invoice_no= $value['invoice_no'];  
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                    $value['po_num'] = '<span>' . $value['po_num'] . '</span> <br> <span>' . $value['po_date'] . '</span>';
                    $value['invoice_no'] = '<span>' . $value['invoice_no'] . '</span> <br> <span>' . $value['invoice_date'] . '</span>';



                    $ir_signed_date= $value['ir_signed_date'];
                    // if($ir_signed_date==''){
                    //     $value['ir_signed_date']='';
                    // }
                    // // else{
                    // //     $ir_date= $value['ir_signed_date'];
                    // // }
                    // else{
                    if($ir_signed_date!=''){
                   $value['ir_signed_date'] = date("d-m-Y", strtotime($ir_signed_date));
                    // }
// if($value['warranty']=="")
// {
//     $value['warranty']
// }


                //    start
                $warranty_years = $value['warranty']; 
                // $delivery_due_dates = $value['delivery_due_dates'];
                if ($warranty_years!="") {
                    $warranty_year = $value['warranty']; 
                } else {
                    $warranty_year = $value['product_warranty_duration']; 
                }
                $value['warranty']= $warranty_year;
                   

                //    $ir_date_val = $value['ir_signed_date'];
        
                //    $ir_signed_date = $value['ir_signed_date'];
               
                $ir_date = new DateTime($value['ir_signed_date']);
                    // Create a DateTime object from the IR signed date
                    $ir_signed_datetime = $ir_date;
        
                    // Add warranty years to the IR signed date
                    $warrenty_date = $ir_signed_datetime->modify("+{$warranty_year} years");
        
                    // Format the result as 'Y-m-d' and output
                    $warranty_end_date= $warrenty_date->format('Y-m-d');
                    // print_R($warranty_end_date);
                            //  $ir_signed_month=   month($snr_signed_date);
        // print_R($remaining_warranty_months);
                      $value['consignee_unique_id']= $warranty_end_date;
                }
                else {
                    $value['ir_signed_date']='<span style="color:#da1c34;"
                    >NULL</span>';
                    $value['consignee_unique_id']='<span style="color:#da1c34;"
                    >NULL</span>';
                }
                    // 2025-06-07
        
        
                    // $value['consignee_unique_id'] = $ $signedDate;
                            // end
                  

                    // $irs = '';

                    // if (($value['ir_signed_date'] == 'Null') || ($value['ir_signed_date'] == '')){
                    //     $value['ir_signed_date'] = '<span style="color: #a7a668;
                    //     padding: 13px 19px 15px 20px;"></span>';
                    // }
                    //     $value['ir_signed_date'] = '';
                    // }
                    // <span style="background-color: #a7a668;
                    // padding: 13px 19px 15px 20px;"></span>
                    // if($ir_signed_date!='undefined'){
                        // else{
                            // else{
                        // $value['ir_signed_date'] =  $ir_signed_date;
                    // }
                    // if (($value['ir_signed_date'] == 'Null')){
                    //     $value['ir_signed_date']='<span style="color: #a7a668;
                    //  ></span>';
                    // }
                    // else{
                    //     $value['ir_signed_date'] =  $ir_signed_date; 
                    // }

                    $snr_signed_date=  $value['snr_signed_date'];
                    // if ($value['snr_signed_date'] == '' || $value['snr_signed_date'] == 'undefined') {
                    //     $value['snr_signed_date'] = '';
                    // }
                    // // <span style="background-color: #a7a668;
                    // // padding: 13px 19px 15px 20px;"></span>
                    // else{
                    $value['snr_signed_date'] =  $snr_signed_date;
                    // }
                    if($value['with_bg']=='on'){
                        $value['with_bg']='yes';
                    }
                    if($value['with_bg']=='off'){
                        $value['with_bg']='Nill';
                    }

                    if($value['bank_required']=='on'){
                        $value['bank_required']='yes';
                    }
                    if($value['bank_required']=='off'){
                        $value['bank_required']='no';
                    }
                //    igned_date contains the IR signed date in the format 'Y-m-d'
           

                if($claim_amount=='95'){
                    $btn_update         = btn_update_invoice($folder_name,$value['bill_form_unique_id'], $invoice_no);  
                }
              else {
                $btn_update='<span style="color:#da1c34;">Go To Ir File upload</span>';
              }
            $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                    // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                    $value['bill_form_unique_id'] = $btn_update;
    
                    $payment_receive = $value['payement_receive'];
                    $payment_status = $value['payment_status'];
    
                    if ($payment_receive != '') {
                        $value['payement_receive'] =  $payment_receive;
                    } else {
                        $value['payement_receive'] = '-';
                    }
    
                    if (($payment_status == '1') || ($payment_status == '0')) {
                        $value['payment_status'] = 'Pending';
                    } else if ($payment_status == '2') {
                        $value['payment_status'] = 'Complete';
                    }
                    if ($value['is_active'] == "1") {
                        $value['is_active']   = "Active";
                    } else {
    
                        $value['is_active']   = "Inactive";
                    }
    
    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;


      

    case 'delete':

        $unique_id      = $_POST['unique_id'];

        $columns        = [
            "is_delete"   => 1
        ];

        $update_where   = [
            "unique_id"     => $unique_id
        ];

        $action_obj     = $pdo->update($table, $columns, $update_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            $msg        = "success_delete";
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);
        break;

        //  case 'user_type_options':

        // $user_type          = $_POST['user_type'];

        // $user_type_options  = under_user_type($user_type);

        // $user_type_options  = select_option($user_type_options,"Select");

        // echo $user_type_options;

        // break;


    default:

        break;
}
function image_view_3($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view_3 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf(\'/' . $file_name . '\')"><img src="uploads/payment/pdf.png"  height="30px" width="50px" ></a>';
                }
                // else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/excel.png"  height="30px" width="30px" ></a>';
                // } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/word.png"  height="30px" width="30px" ></a>';
                // }
            }
        }
    }

    return $image_view_3;
}

