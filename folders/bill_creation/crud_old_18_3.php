<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table             = "view_bill_submission_list";
$table_main     = "bill_submission_form";
$table_inv     = "invoice_creation_main";
$table_sub  =  "bill_submission_sub";
$table_main_table    = "bill_submission_main_table";
$table_bg_main   =  "bg_creation_main";
$table_final_elcot = 'view_elcot_entry_final';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
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
        $invoice_copy          = $_POST["invoice_copy"];
        $installation_reference_no    = $_POST["installation_reference_no"];
        $supplier_invoice_number          = $_POST["supplier_invoice_number"];
        $unique_id                  = $_POST["unique_id"];
        $bill_status                  = $_POST["bill_status"];
        $invoice_qty              = $_POST["invoice_qty"];
        $claim_amount              = $_POST["claim_amount"];
       
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
                $invoice_file_names     = implode(",", $_FILES["test_file2"]['file_name']);
                $invoice_original_name = implode(",", $_FILES["test_file2"]['name']);
            }
        } else if (!empty($_FILES["test_file2"]['name'])) {
            $invoice_file_names     = $_FILES["test_file2"]['file_name'];
            $invoice_original_name = $_FILES["test_file2"]['name'];
        }
        // 3rd image close
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
            'file_name'           => $file_name,
            'consignee_unique_id'  => $consignee_unique_id,
            'claim_amount'          => $claim_amount,
            'installation_reference_no'          => $installation_reference_no,
            'supplier_invoice_number'          => $supplier_invoice_number,
            'scanned_dc_copy'               => $file_names,
            'dc_original_name'     => $file_org_names,
            'scanned_ir_copy'           => $ir_file_names,
            'ir_original_name'  => $ir_file_org_names,
            'invoice_copy'          => $invoice_file_names,
            'invoice_original_name'          => $invoice_original_name,
            'bill_status'          => $bill_status,
            'invoice_qty'          => $invoice_qty,
            "unique_id"             => unique_id($prefix)
        ];
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
        $columns_12 = [
            "bill_status"     => $bill_status,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_12 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"';
        $action_obj_12     = $pdo->update($table_bg_main, $columns_12, $update_where_12);
        // invoice main table update
        $columns_1 = [
            "bill_status"     => $bill_status,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_1 = 'form_main_unique_id="' . $bill_form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        $action_obj_1     = $pdo->update($table_inv, $columns_1, $update_where_1);
        // print_R( $action_obj_1 );
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where   = [
                "unique_id"     => $unique_id
            ];
            $action_obj     = $pdo->update($table_main, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table_main, $columns);
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
        // sub table
    case 'demo':
        $bill_form_main_unique_id   = $_POST["bill_form_unique_id"];
        $po_num                     = $_POST["po_num"];
        $po_date                     = $_POST["po_date"];
        $claim_amount        = $_POST["claim_amount"];
        $con_address            = $_POST["con_address"];
        $invoice_no             = $_POST["invoice_no"];
        // $invoice_no_val             = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $invoice_value          = $_POST["invoice_value"];
        $invoice_qty              = $_POST["invoice_qty"];
        $consignee_unique_id        = $_POST["consignee_unique_id"];
        $bg_num               = $_POST["bg_num"];
        // $claim_amount               = $_POST["claim_amount"];
        $bg_id               = $_POST["bg_id"];
        $bg_date        = $_POST["bg_date"];
        $bg_value               = $_POST["bg_value"];
        $columns            = [
            'bill_form_main_unique_id'  => $bill_form_main_unique_id,
            'po_num'     => $po_num,
            'po_date'           => $po_date,
            'claim_amount'  => $claim_amount,
            'con_address'          => $con_address,
            'invoice_no'           => $invoice_no,
            'invoice_date'  => $invoice_date,
            'invoice_value'          => $invoice_value,
            'invoice_qty'           => $invoice_qty,
            'consignee_unique_id'  => $consignee_unique_id,
            'bg_num'          => $bg_num,
            'bg_id'           => $bg_id,
            'bg_date'  => $bg_date,
            "bg_value"           => $bg_value,
            // "claim_amount"           => $claim_amount,
            "bill_status"              => 2,
            'bill_no'              => bill_no_get(),
            'unique_id'           => unique_id($prefix)
        ];
        if ($bg_num!= 'NA') {
            // bg main table update status
            $columns_3 = [
                "bill_status"     => 2,
            ];
            $update_where_3 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  and bg_num="'. $bg_num .'"';
            // and invoice_no="' . $invoice_no . '"
            $action_obj_3   = $pdo->update($table_bg_main, $columns_3, $update_where_3);
            // print_r($action_obj_3);DIE();
        }
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where   = [
                "unique_id"     => $unique_id
            ];
            $action_obj     = $pdo->update($table_main_table, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table_main_table, $columns);
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
        // bill sub table store
    case 'bill_submission_add_update':
        $bill_form_main_unique_id   = $_POST["bill_form_unique_id"];
        $po_num                     = $_POST["po_num"];
        $po_date                   = $_POST["po_date"];
        $con_contact_name        = $_POST["con_contact_name"];
        $con_address            = $_POST["con_address"];
        $invoice_no             = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $invoice_value          = $_POST["invoice_value"];
        $invoice_qty             = $_POST["invoice_qty"];
        $con_contact_name          = $_POST["con_contact_name"];
        $con_address              = $_POST["con_address"];
        $invoice_auto_id          =  $_POST["invoice_auto_id"];
        //         $con_address          = $invoice_values[0]["con_address"];
        //         $con_address          = $invoice_values[0]["con_address"];
        // $file_name               = $_POST["file_name"];
        $consignee_unique_id        = $_POST["consignee_unique_id"];
        // $bill_main_unique_id        = $_POST["bill_main_unique_id"];
        // $checkbox_qty               = $_POST["checkbox"];
        // bill sub main table update status
        $columns_2 = [
            "bill_status"     => 2,
        ];
        $update_where_2 = 'form_main_unique_id="' . $bill_form_main_unique_id . '" and invoice_no="'. $invoice_no . '"';
        // and invoice_no="' . $invoice_no . '"
        $action_obj_2    = $pdo->update($table_inv, $columns_2, $update_where_2);
        // print_r($action_obj_2);die();
        $columns1 = [
            'bill_no',
        ];
        // count taken start
        $table_details      = [
            $table_main_table,
            [
                'COUNT(unique_id) AS count',
                // 'bill_no',
                'MAX(bill_no) AS last_bill_no',
            ],
        ];
        $select_where       = "is_delete = '0'";
        // AND bill_form_main_unique_id = '" . $bill_form_main_unique_id . "' and invoice_no='" . $invoice_no . "'
        // and consignee_unique_id='" . $consignee_unique_id .'
        $order_by       = "id DESC";
        $action_obj         = $pdo->select($table_details, $select_where, '', '', $order_by);
        // print_r($action_obj);die();
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
        if ($data[0]['count'] == 0) {
            $msg        = 'already';
        } else if ($data[0]['count'] != 0) {
            $last_bill_nos = $data[0]['last_bill_no'];
            // print_r($data[0]['stock_id']);die();
            // count taken end
            $update_where       = "";
            $columns            = [
                'bill_form_unique_id'  => $bill_form_main_unique_id,
                'po_num'     => $po_num,
                'po_date'           => $po_date,
                'con_contact_name'  => $con_contact_name,
                'con_address'          => $con_address,
                'invoice_no'           => $invoice_no,
                'invoice_date'    => $invoice_date,
                'invoice_value'          => $invoice_value,
                'invoice_qty'           => $invoice_qty,
                "invoice_auto_id"    =>$invoice_auto_id,
                'consignee_unique_id'  => $consignee_unique_id,
                'bill_status'           => 2,
                'bill_no'         => $last_bill_nos,
                'unique_id'              => unique_id($prefix)
            ];
            // $bill_submission = 'bill_submission_sub';
            $action_obj     = $pdo->insert($table_sub, $columns);
            // print_r($action_obj);
            // die();
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
        // end
        // subdatatable
        // case 'bill_sub_table':
        //     $table_main_inv = "invoice_creation_main";
        //     $where12      = [
        //         "invoice_no" => $_POST["invoice_no"]
        //     ];
        //     $table12      =  "invoice_creation_main";
        //     $columns12    = [
        //         "po_num",
        //         "po_date",
        //         "invoice_no",
        //         "invoice_date",
        //         "invoice_value",
        //         "invoice_qty",
        //         "(select con_contact_name from consignee_details_sub WHERE consignee_details_sub.unique_id=invoice_creation_main.consignee_unique_id)as con_contact_name",
        //         // "con_contact_name",
        //         "(select con_address from consignee_details_sub WHERE consignee_details_sub.unique_id=invoice_creation_main.consignee_unique_id) as con_address",
        //         "consignee_unique_id",
        //         "form_main_unique_id"
        //     ];
        //     $table_details12   = [
        //         $table12,
        //         $columns12
        //     ];
        //     $invoice_values  = $pdo->select($table_details12, $where12);
        //     if ($invoice_values->status) {
        //         $invoice_values      = $invoice_values->data;
        //         $po_num          = $invoice_values[0]["po_num"];
        //         $po_date    = $invoice_values[0]["po_date"];
        //         $con_contact_name          = $invoice_values[0]["con_contact_name"];
        //         $con_address          = $invoice_values[0]["con_address"];
        //         $invoice_no    = $invoice_values[0]["invoice_no"];
        //         $invoice_date          = $invoice_values[0]["invoice_date"];
        //         $invoice_value          = $invoice_values[0]["invoice_value"];
        //         $invoice_qty         = $invoice_values[0]["invoice_qty"];
        //         $consignee_unique_id          = $invoice_values[0]["consignee_unique_id"];
        //         $form_main_unique_id          = $invoice_values[0]["form_main_unique_id"];
        //     }
        //     $columns1 = [
        //         'bill_no',
        //     ];
        //     // count taken start
        //     $table_details      = [
        //         $table_main_table,
        //         [
        //             'COUNT(unique_id) AS count',
        //             'bill_no',
        //         ],
        //     ];
        //     $select_where       = "is_delete = '0' AND bill_form_main_unique_id = '" . $form_main_unique_id . "'";
        //     // print_R($select_where);die();
        //     $action_obj         = $pdo->select($table_details, $select_where);
        //     // print_r($action_obj);die();
        //     if ($action_obj->status) {
        //         $status     = $action_obj->status;
        //         $data       = $action_obj->data;
        //         $error      = '';
        //         $sql        = $action_obj->sql;
        //     } else {
        //         $status     = $action_obj->status;
        //         $data       = $action_obj->data;
        //         $error      = $action_obj->error;
        //         $sql        = $action_obj->sql;
        //         $msg        = 'error';
        //     }
        //     if ($data[0]['count'] == 0) {
        //         $msg        = 'already';
        //     } else if ($data[0]['count'] != 0) {
        //         // $columns    = [
        //         //     "po_num",
        //         //     "po_date",
        //         //     "invoice_no",
        //         //     "invoice_date",
        //         //     "invoice_value",
        //         //     "invoice_qty",
        //         //     "consignee_unique_id",
        //         //     "form_main_unique_id"
        //         // ];
        //         $columns            = [
        //             'bill_form_unique_id'  => $form_main_unique_id,
        //             'po_num'     => $po_num,
        //             'po_date'           => $po_date,
        //             'con_contact_name'  => $con_contact_name,
        //             'con_address'          => $con_address,
        //             'invoice_no'           => $invoice_no,
        //             'invoice_date'  => $invoice_date,
        //             'invoice_value'          => $invoice_value,
        //             'invoice_qty'           => $invoice_qty,
        //             'consignee_unique_id'  => $consignee_unique_id,
        //             "bill_status"      => 2,
        //             'bill_no'              => $data[0]['bill_no'],
        //             'unique_id'              => unique_id($prefix)
        //         ];
        //         // $table_details   = [
        //         //     $table,
        //         //     $columns
        //         // ];
        //         $columns_2 = [
        //             "bill_status"     => 2,
        //         ];
        //         //     // $arrayOfValues = explode(",", $_POST["invoice_no"]);
        //         //     // print_r($arrayOfValues);die();
        //         $update_where_2 = 'form_main_unique_id="' . $form_main_unique_id . '"  and invoice_no="' . $invoice_no . '"';
        //         $action_obj_2    = $pdo->update($table_inv, $columns_2, $update_where_2);
        //         //     // print_r($action_obj_2)
        //         $action_obj     = $pdo->insert($table_sub, $columns);
        //         // print_r($action_obj1);die();
        //         if ($action_obj->status) {
        //             $status     = $action_obj->status;
        //             $data       = $action_obj->data;
        //             $error      = "";
        //             $sql        = $action_obj->sql;
        //             if ($unique_id) {
        //                 $msg        = "update";
        //             } else {
        //                 $msg        = "create";
        //             }
        //         } else {
        //             $status     = $action_obj->status;
        //             $data       = $action_obj->data;
        //             $error      = $action_obj->error;
        //             $sql        = $action_obj->sql;
        //             $msg        = "error";
        //         }
        //     }
        //     $json_array   = [
        //         "status"    => $status,
        //         "data"      => $data,
        //         "error"     => $error,
        //         "msg"       => $msg,
        //         "sql"       => $sql
        //     ];
        //     echo json_encode($json_array);
        //     break;
        // end
        // end
    case 'datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $status    = $_POST['status'];
        $data        = [];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_no",
            "invoice_date",
            "invoice_value",
            "file_name",
            "bill_status",
            "consignee_unique_id",
            "bank_required",
            "form_main_unique_id",
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // $where = "";
        $where = " bill_status= 0";
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
        // print_r( $result );die();
        $total_records  = total_records();
        if ($result->status) {
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

$orgDate1 = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                // $value['state_name'] = disname($value['state_name']);
                // $value['is_active'] = is_active_show($value['is_active']);
                $value['file_name'] = image_view("po_form", $value['consignee_unique_id'], $value['file_name']);
                // if(($value['ins_reqired']=='on' && $value['bank_required']=='on')){
                //      $value['ins_reqired']= 'ins/bg';
                // }
                // else if($value['ins_reqired']=='on'){
                //      $value['ins_reqired']= 'ins';
                // }
                // else if($value['bank_required']=='on'){
                //      $value['ins_reqired']= 'bg';
                // }
                // else if($value['bank_required']==''){
                //      $value['ins_reqired']= '-';
                // }
                if ($value['bill_status'] == '0') {
                    $value['bill_status'] = 'Pending';
                } else if ($value['bill_status'] == '1') {
                    $value['bill_status'] = 'Completed';
                } else if ($value['bill_status'] == '2') {
                    $value['bill_status'] = 'Bill_submit';
                }
                // else if(($value['file_name'] && ())
                // $btn_update         = btn_update($folder_name,$value['consignee_unique_id']);
                // $btn_update = '<a href="index.php?file=bill_submission/update&unique_id='. $value['consignee_unique_id'].'">';
                $btn_update   =  '<a href="index.php?file=elcot_entry/update&unique_id=' . $value['consignee_unique_id'] . '&invoice_no=' . $value['invoice_no'] . '&form_unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                // $btn_delete         = btn_delete($folder_name,$value['consignee_unique_id']);
                $value['consignee_unique_id'] = $btn_update;
                // if ($value['is_active'] == "1") {
                //     $value['is_active']   = "Active";
                // } else {
                //     $value['is_active']   = "Inactive";
                // }
                // $value['unique_id'] = $btn_update.$btn_delete;
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
    case 'bill_generate_datatable':
        // print_r('hi');
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $form_main_unique_id         = $_POST['bill_form_main_unique_id'];
        $invoice_no         = $_POST['invoice_no'];
        $data        = [];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as s_no",
            "po_num",
            "po_date",
            // "select con_contact_name from consigne",
            // "(select con_contact_name from consignee_details_sub WHERE consignee_details_sub.form_main_unique_id= $table_main_table.bill_form_main_unique_id)as con_contact_name",
            // "con_address",
            "invoice_no",
            "invoice_date",
            "invoice_value",
            // // "file_name",
            // "file_name",
            "bg_num",
            "bill_status",
            "bill_form_main_unique_id",
        ];
        $table_details  = [
            $table_main_table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // and form_main_unique_id='".$_POST['bill_form_main_unique_id']."'
        // $where = "bill_status='0'";
        // print_R($where);
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
        // print_r($result);die();
        $total_records  = total_records();
        if ($result->status) {
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

$orgDate1 = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                if ($value['bg_num'] != 'NA') {
                    $value['bg_num'] = "Yes";
                } else if($value['bg_num'] == 'NA') {
                    $value['bg_num'] = "No";
                }
                //    $value['file_name']= image_view("po_form", $value['consignee_unique_id'], $value['file_name']);
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
        //      case 'bill_generate_datatable':
        // // print_r('hi');
        //         // DataTable Variables
        //         $search     = $_POST['search']['value'];
        //         $length     = $_POST['length'];
        //         $start         = $_POST['start'];
        //         $draw         = $_POST['draw'];
        //         $limit         = $length;
        //         $form_main_unique_id         = $_POST['bill_form_main_unique_id'];
        //         $invoice_no         = $_POST['invoice_no'];
        //         $data        = [];
        //         if ($length == '-1') {
        //             $limit  = "";
        //         }
        //         // Query Variables
        //         $json_array     = "";
        //         $columns        = [
        //             "'' as s_no",
        //             "po_num",
        //             "po_date",
        //             "con_contact_name",
        //             "con_address",
        //             "invoice_no",
        //             "invoice_date",
        //             "invoice_value",
        //             // // "file_name",
        //             "file_name",
        //             "bill_status",
        //             "form_main_unique_id",
        //         ];
        //         $table_details  = [
        //             $table,
        //             $columns
        //         ];
        //         $where = "bill_status=1";
        //         // $where          = [
        //         //     "is_delete"     => 0
        //         // ];
        //         // $order_by       = "";
        //     // and form_main_unique_id='".$_POST['bill_form_main_unique_id']."'
        //         // $where = "bill_status='0'";
        // // print_R($where);
        //         $order_column   = $_POST["order"][0]["column"];
        //         $order_dir      = $_POST["order"][0]["dir"];
        //         // Datatable Ordering 
        //         $order_by       = datatable_sorting($order_column, $order_dir, $columns);
        //         // Datatable Searching
        //         $search         = datatable_searching($search, $columns);
        //         if ($search) {
        //             if ($where) {
        //                 $where .= " AND ";
        //             }
        //             $where .= $search;
        //         }
        //         $sql_function   = "SQL_CALC_FOUND_ROWS";
        //         $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        //         // print_r($result);die();
        //         $total_records  = total_records();
        //         if ($result->status) {
        //             $res_array      = $result->data;
        //             foreach ($res_array as $key => $value) {
        //                 $value['s_no'] = $sno + 1;
        //                 if($value['bg_num']!=''){
        //                     $value['bg_num']="Yes";
        //                 }
        //                 else{
        //                     $value['bg_num']="No";
        //                 }
        //             //    $value['file_name']= image_view("po_form", $value['consignee_unique_id'], $value['file_name']);
        //                 $data[]             = array_values($value);
        //                 $sno++;
        //             }
        //             $json_array = [
        //                 "draw"                => intval($draw),
        //                 "recordsTotal"         => intval($total_records),
        //                 "recordsFiltered"     => intval($total_records),
        //                 "data"                 => $data,
        //                 "testing"            => $result->sql
        //             ];
        //         } else {
        //             print_r($result);
        //         }
        //         echo json_encode($json_array);
        //         break;
        // get second tab
    case 'bill_datatable':
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $po_num_bill     = $_POST['po_num_bill'];
        $table_data = '';
        $data        = [];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "po_num",
            "bank_required",
            "unique_id"
        ];
        $table_po = "po_form";
        $table_details  = [
            $table_po,
            $columns
        ];

        // $where = "unique_id ='" . $po_num_bill . "'";
        $result         = $pdo->select($table_details, $where);
        if ($result->status) {
            $result_data      = $result->data;
            $columns        = [
                "file_org_name",
                "'' as s_no",
                "bg_num",
                "bg_date",
                // "bg_value",
                "po_num",
                "po_date",
                "invoice_qty",
                "invoice_value",
                "invoice_no",
                "invoice_date",
                "con_contact_name",
                "con_address",
                // "bill_status",
                "(select claim_amount from bill_submission_form WHERE bill_submission_form.bill_form_main_unique_id=$table_final_elcot.unique_id)as claim_amount",
                // "claim_amount",
                "invoice_auto_id",
                "consignee_unique_id",
                "bg_auto_id",
                "con_contact_name",
                "con_address",
                // "file_name",
                "unique_id",
                // "select claim_amount from bill_submission_form where bill_submission_form.bill_form_main_unique_id=$table_final_elcot.bill_form_unique_id)as claim_amount",
            ];
            $table_details  = [
                $table_final_elcot,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
            // if ($po_num_bill == '') {
            $where = "bill_status='1'";
            // } else if ($po_num_bill != '') {
            //     $where = "unique_id ='" . $po_num_bill . "' and  bill_status='1'";
            // }
            // print_r($where);die();
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
            // print_r($result);die();
            $total_records  = total_records();
            if ($result->status) {
                $res_array      = $result->data;
                foreach ($res_array as $key => $value) {
                    $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

$orgDate1 = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    if ($value['bg_num'] == '') {
                        $value['bg_num'] = 'NA';
                    }
                    if ($value['bg_date'] == '') {
                        $value['bg_date'] = 'NA';
                    }
                    if ($value['bg_value'] == '') {
                        $value['bg_value'] = 'NA';
                    }
                    if ($value['con_contact_NAme'] == '') {
                        $value['con_contact_NAme'] = 'NA';
                    }
                    if ($value['con_address'] == '') {
                        $value['con_address'] = 'NA';
                    }
                    if ($value['invoice_no'] == '') {
                        $value['invoice_no'] = 'NA';
                    }
                    if ($value['invoice_date'] == '') {
                        $value['invoice_date'] = 'NA';
                    }
                    $value['s_no'] = $sno + 1;
                    //  $value['file_NAme']= image_view("po_form", $value['consignee_unique_id'], $value['file_NAme']);
                    $value['file_org_name'] = '<input class="myCheck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >
                    <input type="hidden" name="bill_form_unique_id"  id="bill_form_unique_id" value="' . $value['unique_id'] . '">
                        <input type="hidden" name="po_num"  id="po_num" value="' . $value['po_num'] . '">
                        <input type="hidden" name="po_date"  id="po_date" value="' . $value['po_date'] . '">
                        <input type="hidden" name="invoice_no[]"  id="invoice_no" value="' . $value['invoice_no'] . '">
                        <input type="hidden" name="invoice_qty[]"  id="invoice_qty" value="' . $value['invoice_qty'] . '">
                        <input type="hidden" name="invoice_value[]"  id="invoice_value" value="' . $value['invoice_value'] . '">
                        <input type="hidden" name="bg_num[]" id="bg_num" value="' . $value['bg_num'] . '">
                        <input type="hidden" name="bg_id[]" id="bg_id" value="' . $value['bg_auto_id'] . '">
                        <input type="hidden" name="bg_date[]" id="bg_date" value="' . $value['bg_date'] . '">
                        <input type="hidden" name="bg_value[]" id="bg_value" value="' . $value['bg_value'] . '">
                        <input type="hidden" name="invoice_date[]" id="invoice_date" value="' . $value['invoice_date'] . '">
                        <input type="hidden" name="con_contact_name"  id="con_contact_name" value="' . $value['con_contact_name'] . '">
                        <input type="hidden" name="claim_amount"  id="claim_amount" value="' . $value['claim_amount'] . '">
                        <input type="hidden" name="invoice_auto_id"  id="invoice_auto_id" value="' . $value['invoice_auto_id'] . '">
                        <input type="hidden" name="con_address"  id="con_address" value="' . $value['con_address'] . '">
                        <input type="hidden" name="consignee_unique_id"  id="consignee_unique_id" value="' . $value['consignee_unique_id'] . '">
                        <input type="hidden" name="invoice_date"  id="invoice_date" value="' . $value['invoice_date'] . '">
                        <input type="hidden" name="bank_required" id="bank_required" value="' . $result_data[0]['bank_required'] . '">';
                    $data[]             = array_values($value);
                    $sno++;
                }
                $sno++;
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
    // print_r($image_view);die();
}
// function bill_no_get() {
//             $date = date('Y');
//             $st_date = substr($date,2);
//             $month = date('m');
//             $datee = $st_date.$month;
//             $servername = 'localhost';
//             $username = project_env('ELCOT_DB_USERNAME');
//             $password = project_env('ELCOT_DB_PASSWORD');
//             $database_name = 'aed_elcot';
//             try {
//                 $conn = new PDO( "mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password );
//                 // set the PDO error mode to exception
//                 $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
//                 //echo 'Connected successfully';
//             } catch ( PDOException $e ) {
//                 // echo 'Connection failed: ' . $e->getMessage();
//             }
//             $stmt = $conn->query("SELECT * FROM bill_submission_form where bill_no LIKE 'BN%' order by unique_id desc" );
//             // print_R($stmt);die();
//             if($res1 = $stmt->fetch()){
//                 $pur_array = explode( '-',$res1['bill_no'] );
//                 $year1 = $pur_array[1];
//                 $year2 = substr($year1, 0, 2 );
//                 $year = '20'.$year2;
//                 $bill_no = $pur_array[2];
//             }
//             //  print_r($bill_no);die();
//             if($bill_no == '')
//             $bill_no = 'BN-' . $datee . '-0001';
//             else if( $year != date( 'Y' ) )
//             $bill_no = 'BN-' . $datee . '-0001';
//             else{
//                 $bill_no += 1;
//                 $bill_nos = 'BN-'. $datee. '-' .str_pad($bill_no, 4, '0', STR_PAD_LEFT );
//             }
//             // print_R($bill_nos);die();
//             return $bill_nos;
//         }
function bill_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = project_env('LEGACY_CREDENTIAL_2');
    $database_name = "aed_elcot";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM bill_submission_main_table where bill_no LIKE 'BN%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;
    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['bill_no']);
        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $bill_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($bill_no == '')
        $bill_nos = 'BN-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $bill_nos = 'BN-' . $datee . '-0001';
    else {
        $bill_no += 1;
        $bill_nos = 'BN-' . $datee . '-' . str_pad($bill_no, 4, '0', STR_PAD_LEFT);
    }
    // print_r($bill_nos);
    return $bill_nos;
}




