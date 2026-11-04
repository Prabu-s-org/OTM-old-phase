<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name

$table_main = "bill_submission_form";
$table_sub = "bill_submission_sub";
$table_main_table = "bill_submission_main_table";
$table_inv = "invoice_creation_main";
$table_bg_main = "bg_creation_main";
$table_bg_sub = "bg_creation_sub";
$table_sign_doc = "sign_doc_verification_detail";


$table_sub_1 = "view_bill_submission_sub_table";
$table_main_table_1 = "view_bill_submission_main_table";
$table = "view_bill_submission_list";

$table_final_elcot = 'view_elcot_entry_final_bill_list';



$table_partial_final_elcot = 'view_partial_elcot_entry_final';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    "status" => 0,
    "data" => "",
    "error" => "Action Not Performed"
];
$json_array = "";
$sql = "";
$user_type = "";
$is_active = "";
$unique_id = "";
$prefix = "";
$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose
switch ($action) {
    case 'createupdate':
        // $ins_unique_id = $_POST["ins_unique_id"];
        $bill_form_main_unique_id = $_POST["bill_form_main_unique_id"];
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        // $con_contact_name = $_POST["con_contact_name"];
        // $con_address = $_POST["con_address"];
        $invoice_no = $_POST["invoice_no"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_value = $_POST["invoice_value"];

        $unique_id = $_POST["unique_id"];
        // $dc_number = $_POST["dc_number"];
        // $dc_date = $_POST["dc_date"];
        $bill_status = $_POST["bill_status"];
        // $dc_no                  = $_POST["dc_no"];
        $invoice_value = floatval($_POST["invoice_value"]);
        $claim_amount = floatval($_POST["claim_amount"]);

        $claim_amt = ($invoice_value * $claim_amount) / 100;

        $invoice_qty = $_POST["invoice_qty"];
        $cutomername = $_POST["cutomername"];

        $acc_year = $_SESSION["acc_year"];

        $update_where = "";
        //  if (($file_names) && ($file_org_names) || ($invoice_file_names) && ($invoice_original_name) || ($ir_file_names) && ($ir_file_org_names)) {
        // if ($unique_id == '') {

        $columns = [
            'bill_form_main_unique_id' => $bill_form_main_unique_id,
            'po_num' => $po_num,
            'po_date' => $po_date,
            'customer_name' => $cutomername,
            // 'con_address' => $con_address,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_value' => $invoice_value,
            // 'file_name' => $file_name,
            // 'consignee_unique_id' => $consignee_unique_id,
            'claim_amount' => $claim_amount,
            // 'installation_reference_no' => $installation_reference_no,
            // 'supplier_invoice_number' => $supplier_invoice_number,
            // 'scanned_dc_copy' => $file_names,
            // 'dc_original_name' => $file_org_names,
            // 'scanned_snr_copy' => $snr_file_names,
            // 'snr_original_name' => $snr_original_name,
            // 'scanned_ir_copy' => $ir_file_names,
            // 'ir_original_name' => $ir_file_org_names,
            // 'invoice_copy' => $invoice_file_names,
            // 'invoice_original_name' => $invoice_original_name,
            'bill_status' => $bill_status,
            'invoice_qty' => $invoice_qty,
            // 'ins_unique_id' => $ins_unique_id,
            'claim_amt' => $claim_amt,
            // 'dc_number'          => $dc_number,
            // 'dc_date'          => $dc_date,
            "unique_id" => unique_id($prefix),
            'acc_year' => $acc_year,
        ];
        // } 

        // }

        if ($unique_id == '') {
            $columns_5 = [
                "bill_status" => $bill_status,
            ];

            $update_where_5 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" ';
            // AND ins_unique_id="' . $ins_unique_id . '
            $action_obj_5 = $pdo->update($table_bg_sub, $columns_5, $update_where_5);

            $columns_7 = [
                "bill_status" => $bill_status,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_7 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '"';
            // and ins_unique_id="' . $ins_unique_id . '
            // and con_unique_id="' . $consignee_unique_id . '"
            $action_obj_7 = $pdo->update($table_sign_doc, $columns_7, $update_where_7);

        }
        // print_r($action_obj_7);

        // print_r($action_obj_1);
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where = [
                "unique_id" => $unique_id
            ];
            $action_obj = $pdo->update($table_main, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj = $pdo->insert($table_main, $columns);
            // Insert Ends
        }
        // print_r($action_obj);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            if ($unique_id) {
                $msg = "update";
            } else {
                $msg = "create";
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }
        // }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);
        break;

    // sub table
    case 'demo':
// echo '1 ';

// print_r('test');die();
        $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        $claim_amount = $_POST["claim_amount"];
        // $con_address = $_POST["con_address"];
        $invoice_no = $_POST["invoice_no"];
        // $invoice_no_val             = $_POST["invoice_no"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_value = $_POST["invoice_value"];
        $invoice_qty = $_POST["invoice_qty"];
        $ledgername = $_POST["ledger_name"];
        $bg_num = $_POST["bg_num"];

        $bg_date = $_POST["bg_date"];
        $bg_value = $_POST["bg_value"];

        // print_r("bg_date");

        $claimamount = floatval($_POST["claim_amount"]);
// echo '2 ';
// echo '3 ';
        $claim_amt = ($invoice_value * $claimamount) / 100;
        // $acc_year = getFinancialYear($po_date);
        $acc_year = $_SESSION["acc_year"];


        // $bill_no = bill_no_get(); // Generate the bill number
// echo '3 ';

        $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        $allowedMimeTypes = array(
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );
        $file = $_FILES['bg_doc']['name'];
        $extension = pathinfo($_FILES['bg_doc']['name'], PATHINFO_EXTENSION);
        $tem_name = $bg_num . "." . $extension;
        $targetDir = '../../uploads/bg/';

// echo '4 ';

        if (move_uploaded_file($_FILES['bg_doc']['tmp_name'], '../../uploads/bg/' . $tem_name)) {
            // Set filenames
            $file_names = $tem_name;
            $file_org_names = $_FILES['bg_doc']['name'];
            //     echo "File uploaded successfully.";
        }
// echo '5 ';
        $columns = [
            'bill_form_main_unique_id' => $bill_form_main_unique_id,
            'po_num' => $po_num,
            'po_date' => $po_date,
            'claim_amount' => $claim_amount,
            'customer_name' => $ledgername,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_value' => $invoice_value,
            'invoice_qty' => $invoice_qty,
            'claimamt' => $claim_amt,
            'bg_num' => $bg_num,
            'bg_id' => bg_no_get(),
            'bg_date' => $bg_date,
            "bg_value" => $bg_value,
            "bg_doc" => $file_names,
            "bill_status" => 2,
            'bill_no' => bill_no_get(),
            'unique_id' => unique_id($prefix),
            'acc_year' => $acc_year,
            'bill_created_date' => date('Y-m-d'),

            // 'dc_number' => $dc_number,
            // 'dc_date' => $dc_date,
        ];

        // print_r($columns);die();


        // print_r('test1');die();
// echo '6 ';
        $table_details = [
            $table_main_table,
            [
                'COUNT(bill_no) AS count',

            ]
        ];
        $select_where = 'bill_no = "' . $bill_no . '" AND is_delete = 0';
        $action_obj = $pdo->select($table_details, $select_where);
// echo '7 ';
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        // print_r($action_obj );die();
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0)) {


            // Update Begins
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where = [
                    "unique_id" => $unique_id
                ];
                $action_obj = $pdo->update($table_main_table, $columns, $update_where);

                // Update Ends
            } else {
                // Insert Begins
                // echo '8 ';
                $action_obj = $pdo->insert($table_main_table, $columns);
                // echo '9 ';
                // Insert Ends
            }
            // print_r($action_obj);
            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = "";
                $sql = $action_obj->sql;
                if ($unique_id) {
                    $msg = "update";
                } else {
                    $msg = "create";
                }
            } else {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = $action_obj->error;
                $sql = $action_obj->sql;
                $msg = "error";
            }
        }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);
        break;
    // bill sub table store
    case 'bill_submission_add_update':

        $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        // $con_contact_name = $_POST["con_contact_name"];
        // $con_address = $_POST["con_address"];
        $invoice_no = $_POST["invoice_no"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_value = $_POST["invoice_value"];
        $invoice_qty = $_POST["invoice_qty"];
        // $con_contact_name          = $_POST["con_contact_name"];
        $con_address = $_POST["con_address"];



        $claimamount = floatval($_POST["claim_amount"]);

        // die();

        $claim_amt = ($invoice_value * $claimamount) / 100;

        // $invoice_auto_id = $_POST["invoice_auto_id"];
        // $ins_unique_id = $_POST["ins_unique_id"];
        //         $con_address          = $invoice_values[0]["con_address"];
        //         $con_address          = $invoice_values[0]["con_address"];
        // $file_name               = $_POST["file_name"];
        // $consignee_unique_id = $_POST["consignee_unique_id"];
        // $bill_main_unique_id        = $_POST["bill_main_unique_id"];
        // $checkbox_qty               = $_POST["checkbox"];
        // bill sub main table update status
        // $columns_2 = [
        //     "bill_status"     => 2,
        // ];
        // $update_where_2 = 'form_main_unique_id="' . $bill_form_main_unique_id.'" and invoice_no="'.$invoice_no.'"';
        // // and invoice_no="' . $invoice_no . '"
        // $action_obj_2    = $pdo->update($table_inv, $columns_2, $update_where_2);

        $columns_7 = [
            "bill_status" => 2,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_7 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '"';
        $action_obj_7 = $pdo->update($table_sign_doc, $columns_7, $update_where_7);
        // and con_unique_id="' . $consignee_unique_id . '"
        // and ins_unique_id="' . $ins_unique_id . '
        // print_r($action_obj_7);

        $columns_8 = [
            "bill_status" => 2,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_8 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '"';
        $action_obj_8 = $pdo->update($table_main, $columns_8, $update_where_8);
        // and consignee_unique_id="' . $consignee_unique_id . '" and ins_unique_id="' . $ins_unique_id . '
        // print_r($action_obj_8);


        $columns_3 = [
            "bill_status" => 2,
        ];
        $update_where_3 = 'form_main_unique_id="' . $bill_form_main_unique_id . '" and invoice_no="' . $invoice_no . '"';
        // and invoice_no="' . $invoice_no . '" and ins_unique_id="' . $ins_unique_id . '
        $action_obj_3 = $pdo->update($table_bg_sub, $columns_3, $update_where_3);
        // print_r($action_obj_3);
        $columns1 = [
            'bill_no',
        ];
        // count taken start
        $table_details = [
            $table_main_table,
            [
                'COUNT(unique_id) AS count',
                // 'bill_no',
                'MAX(bill_no) AS last_bill_no',
                // "invoice_no",
            ],
        ];
        $select_where = "is_delete =0";
        // $select_where       = "is_delete = 0 AND bill_form_main_unique_id = '" . $bill_form_main_unique_id . "' and bill_form_unique_id='" . $bill_form_unique_id . "'";
        // and consignee_unique_id='" . $consignee_unique_id .'
        $order_by = "id DESC";
        $action_obj = $pdo->select($table_details, $select_where, '', '', $order_by);
        // print_r($action_obj);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        if ($data[0]['count'] == 0) {
            $msg = 'already';
        } else if ($data[0]['count'] != 0) {
            $last_bill_nos = $data[0]['last_bill_no'];
            // $last_bill_nos += 1;

            // print_r($last_bill_nos);die();
            // count taken end
            $update_where = "";
            $columns = [
                'bill_form_unique_id' => $bill_form_main_unique_id,
                'po_num' => $po_num,
                'po_date' => $po_date,
                // 'con_contact_name' => $con_contact_name,
                // 'con_address' => $con_address,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'invoice_value' => $invoice_value,
                'invoice_qty' => $invoice_qty,
                "claimamt" => $claim_amt,

                "claim_percentage" => $claimamount,
                // 'consignee_unique_id' => $consignee_unique_id,
                'bill_created_date' => date('Y-m-d'),

                // 'partial_bill_status' => 3,
                'bill_status' => 2,
                'bill_no' => $last_bill_nos,
                'unique_id' => unique_id($prefix)
            ];
            $columns_9 = [
                "bill_no" => $last_bill_nos,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_9 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" AND partial_bill_status=0';
            // and consignee_unique_id="' . $consignee_unique_id . '" AND ins_unique_id="' . $ins_unique_id . '

            $action_obj_9 = $pdo->update($table_main, $columns_9, $update_where_9);
            // print_r($action_obj_9);

            $columns_10 = [
                "bill_no" => $last_bill_nos,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_10 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '"';
            // AND con_unique_id="' . $consignee_unique_id . '"

            $action_obj_10 = $pdo->update($table_sign_doc, $columns_10, $update_where_10);
            // print_r($action_obj_10);


            // $bill_submission = 'bill_submission_sub';
            $action_obj = $pdo->insert($table_sub, $columns);
            // print_r($action_obj);
            // die();
            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = "";
                $sql = $action_obj->sql;
                if ($unique_id) {
                    $msg = "update";
                } else {
                    $msg = "create";
                }
            } else {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = $action_obj->error;
                $sql = $action_obj->sql;
                $msg = "error";
            }
        }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);
        break;

    // // partial create bill
    // case 'partial_bill_main':
    //     $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
    //     $po_num = $_POST["po_num"];
    //     $po_date = $_POST["po_date"];
    //     $claim_amount = $_POST["claim_amount"];
    //     // $con_address = $_POST["con_address"];
    //     $invoice_no = $_POST["invoice_no"];
    //     // $invoice_no_val             = $_POST["invoice_no"];
    //     $invoice_date = $_POST["invoice_date"];
    //     $invoice_value = $_POST["invoice_value"];
    //     $invoice_qty = $_POST["invoice_qty"];
    //     // $consignee_unique_id = $_POST["consignee_unique_id"];
    //     $bg_num = $_POST["bg_num"];
    //     // $claim_amount               = $_POST["claim_amount"];
    //     // $bg_id               = $_POST["bg_id"];
    //     $bg_date = $_POST["bg_date"];
    //     $bg_value = $_POST["bg_value"];
    //     $columns = [
    //         'bill_form_main_unique_id' => $bill_form_main_unique_id,
    //         'po_num' => $po_num,
    //         'po_date' => $po_date,
    //         'claim_amount' => $claim_amount,
    //         // 'con_address' => $con_address,
    //         'invoice_no' => $invoice_no,
    //         'invoice_date' => $invoice_date,
    //         'invoice_value' => $invoice_value,
    //         'invoice_qty' => $invoice_qty,
    //         // 'consignee_unique_id' => $consignee_unique_id,
    //         'bg_num' => $bg_num,
    //         // 'bg_id'           => $bg_id,
    //         'bg_date' => $bg_date,
    //         "bg_value" => $bg_value,
    //         // "claim_amount"           => $claim_amount,
    //         'partial_bill_status' => 3,
    //         "bill_status" => 2,
    //         'bill_no' => bill_no_get(),
    //         // 'bill_created_date' => date('d-m-Y'),
    //         'bill_created_date' => date('Y-m-d'),


    //         'unique_id' => unique_id($prefix)
    //     ];
    //     if ($bg_num != 'NA') {
    //         // bg main table update status
    //         $columns_3 = [
    //             "bill_status" => 2,
    //         ];
    //         // $update_where_3 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  and bg_num="' . $bg_num . '" and invoice_no="'.$invoice_no."'";
    //         $update_where_3 = "form_main_unique_id='" . $bill_form_main_unique_id . "' and bg_num='" . $bg_num . "' and invoice_no='" . $invoice_no . "'";
    //         // and invoice_no="' . $invoice_no . '"
    //         $action_obj_3 = $pdo->update($table_bg_main, $columns_3, $update_where_3);

    //     }
    //     // Update Begins
    //     if ($unique_id) {
    //         unset($columns['unique_id']);
    //         $update_where = [
    //             "unique_id" => $unique_id
    //         ];
    //         $action_obj = $pdo->update($table_main_table, $columns, $update_where);
    //         // Update Ends
    //     } else {
    //         // Insert Begins
    //         $action_obj = $pdo->insert($table_main_table, $columns);
    //         // Insert Ends
    //     }
    //     // print_r($action_obj);
    //     if ($action_obj->status) {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = "";
    //         $sql = $action_obj->sql;
    //         if ($unique_id) {
    //             $msg = "update";
    //         } else {
    //             $msg = "create";
    //         }
    //     } else {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = $action_obj->error;
    //         $sql = $action_obj->sql;
    //         $msg = "error";
    //     }
    //     $json_array = [
    //         "status" => $status,
    //         "data" => $data,
    //         "error" => $error,
    //         "msg" => $msg,
    //         "sql" => $sql
    //     ];
    //     echo json_encode($json_array);
    //     break;
    // // bill sub table store
    // case 'partial_bill_creation_add_update':

    //     $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
    //     $po_num = $_POST["po_num"];
    //     $po_date = $_POST["po_date"];
    //     // $con_contact_name = $_POST["con_contact_name"];
    //     // $con_address = $_POST["con_address"];
    //     $invoice_no = $_POST["invoice_no"];
    //     $invoice_date = $_POST["invoice_date"];
    //     $invoice_value = $_POST["invoice_value"];
    //     $invoice_qty = $_POST["invoice_qty"];

    //     $columns_8 = [
    //         "bill_status" => 2,

    //     ];
    //     // consignee_unique_id
    //     // $update_where_1   = [
    //     //         "form_main_unique_id"     => $po_form_unique_id
    //     //     ];
    //     $update_where_8 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';
    //     // and consignee_unique_id="' . $consignee_unique_id . '" 
    //     $action_obj_8 = $pdo->update($table_main, $columns_8, $update_where_8);


    //      $columns_8 = [
    //         "partial_bill_status" => 3,

    //     ];
    //     // consignee_unique_id
    //     // $update_where_1   = [
    //     //         "form_main_unique_id"     => $po_form_unique_id
    //     //     ];
    //     $update_where_8 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0 and partial_bill_status=2';
    //     // and consignee_unique_id="' . $consignee_unique_id . '" 
    //     $action_obj_8 = $pdo->update($table_main, $columns_8, $update_where_8);
    //     // print_r($action_obj_8);


    //     // $columns_3 = [
    //     //     "bill_status"     => 2,
    //     // ];
    //     // $update_where_3 = 'form_main_unique_id="'.$bill_form_main_unique_id.'" and invoice_no="'.$invoice_no.'" and ins_unique_id="'.$ins_unique_id.'"';
    //     // // and invoice_no="' . $invoice_no . '"
    //     // $action_obj_3    = $pdo->update($table_bg_sub, $columns_3, $update_where_3);
    //     // print_r($action_obj_3);
    //     $columns1 = [
    //         'bill_no',
    //     ];
    //     // count taken start
    //     $table_details = [
    //         $table_main_table,
    //         [
    //             'COUNT(unique_id) AS count',
    //             // 'bill_no',
    //             'MAX(bill_no) AS last_bill_no',
    //             // "invoice_no",
    //         ],
    //     ];
    //     $select_where = "is_delete = '0'";
    //     // AND bill_form_main_unique_id = '" . $bill_form_main_unique_id . "' and invoice_no='" . $invoice_no . "'
    //     // and consignee_unique_id='" . $consignee_unique_id .'
    //     $order_by = "id DESC";
    //     $action_obj = $pdo->select($table_details, $select_where, '', '', $order_by);
    //     // print_r($action_obj);die();
    //     if ($action_obj->status) {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = '';
    //         $sql = $action_obj->sql;
    //     } else {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = $action_obj->error;
    //         $sql = $action_obj->sql;
    //         $msg = 'error';
    //     }
    //     if ($data[0]['count'] == 0) {
    //         $msg = 'already';
    //     } else if ($data[0]['count'] != 0) {
    //         $last_bill_nos = $data[0]['last_bill_no'];
    //         // print_r($data[0]['stock_id']);die();
    //         // count taken end
    //         $update_where = "";
    //         $columns = [
    //             'bill_form_unique_id' => $bill_form_main_unique_id,
    //             'po_num' => $po_num,
    //             'po_date' => $po_date,
    //             // 'con_contact_name' => $con_contact_name,
    //             // 'con_address' => $con_address,
    //             'invoice_no' => $invoice_no,
    //             'invoice_date' => $invoice_date,
    //             'invoice_value' => $invoice_value,
    //             'invoice_qty' => $invoice_qty,
    //             // "invoice_auto_id"    => $invoice_auto_id,
    //             // "ins_unique_id"    => $ins_unique_id,
    //             // 'consignee_unique_id' => $consignee_unique_id,
    //             'partial_bill_status' => 3,
    //             'bill_status' => 2,
    //             'bill_no' => $last_bill_nos,
    //             'unique_id' => unique_id($prefix)
    //         ];
    //         $columns_9 = [
    //             "bill_no" => $last_bill_nos,
    //         ];
    //         // consignee_unique_id
    //         // $update_where_1   = [
    //         //         "form_main_unique_id"     => $po_form_unique_id
    //         //     ];
    //         $update_where_9 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" AND partial_bill_status="2"';
    //         // AND consignee_unique_id="' . $consignee_unique_id . '"

    //         $action_obj_9 = $pdo->update($table_main, $columns_9, $update_where_9);


    //         // new changes====================

    //         $columns_10 = [
    //             "bill_no" => $last_bill_nos,
    //         ];
    //         // consignee_unique_id
    //         // $update_where_1   = [
    //         //         "form_main_unique_id"     => $po_form_unique_id
    //         //     ];
    //         $update_where_10 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '"';
    //         // AND con_unique_id="' . $consignee_unique_id . '"

    //         $action_obj_10 = $pdo->update($table_sign_doc, $columns_10, $update_where_10);
    //         // print_r($action_obj_10);
    //         // end===========

    //         $action_obj = $pdo->insert($table_sub, $columns);
    //         // print_r($action_obj);
    //         // die();
    //         if ($action_obj->status) {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = "";
    //             $sql = $action_obj->sql;
    //             if ($unique_id) {
    //                 $msg = "update";
    //             } else {
    //                 $msg = "create";
    //             }
    //         } else {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = $action_obj->error;
    //             $sql = $action_obj->sql;
    //             $msg = "error";
    //         }
    //     }
    //     $json_array = [
    //         "status" => $status,
    //         "data" => $data,
    //         "error" => $error,
    //         "msg" => $msg,
    //         "sql" => $sql
    //     ];
    //     echo json_encode($json_array);
    //     break;


    case 'datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $status = $_POST['status'];
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // view_bill_submission_list_pending_1
        $table_pending = "invoice_verfication_table";

        // $table_pending = "view_otm_bill_pending_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "(SELECT po_num from po_form where unique_id = $table_pending.form_main_unique_id) AS po_num",

            "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_pending.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",
            // "con_contact_name",
            // "ledger_name",
            // "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_pending . ".ledger_name ) AS ledger_name",

            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_bill_submission_list_pending_1.department) AS department",

            // "con_address",
            "invoice_no",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",

            // "invoice_date",
            "invoice_value",
            // "sum(invoice_value) as invoice_value",
            // "dc_number",
            // "dc_date",
            // "file_name",
            "(SELECT file_name FROM po_form WHERE po_form.unique_id = " . $table_pending . ".form_main_unique_id ) AS file_name",

            // "bill_status",
            // "consignee_unique_id",
            // "bank_required",
            "form_main_unique_id as unique_id",
            // "bg_status",
            "po_date",
            "invoice_date",
            // "ins_unique_id"
        ];
        $table_details = [
            $table_pending,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // inv_verify_status = 1 AND status_app = 2 AND
        $where = "inv_verify_status = 1 AND status_app = 2 AND bill_status != 2 ";
        //    $where = "bill_status=0";


        $group_by = "invoice_no";

        // $where = " is_delete = '0'";

        if ($_POST['from_date'] == '') {
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }


        // if($from_date && $to_date != '') {
        if ($opt == '4') {
            $where .= " and po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
            // $from_date_converted = date('d-m-Y', strtotime($from_date));
            // $to_date_converted = date('d-m-Y', strtotime($to_date));
            // $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
        } else if ($opt == '5') {

            $where .= " and invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
        }


        // $where = " bill_status= '0'";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        
        $order_by = "
    CASE 
        WHEN bill_status = '3' THEN 0  -- Bill Rejected
        WHEN bill_status = '4' THEN 1  -- Payment Rejected
        WHEN bill_status = '0' THEN 2  -- Pending
        WHEN bill_status = '1' THEN 3  -- Completed
        WHEN bill_status = '2' THEN 3  -- Completed (same rank as 1)
        ELSE 4
    END $order_dir, 
    STR_TO_DATE(po_date, '%d-%m-%Y') $order_dir
";

        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }
        $sql_function = "SQL_CALC_FOUND_ROWS";


        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
                //  print_r($action_ids);die();
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {

                $invoice_value = moneyFormatIndia1($value['invoice_value']);
                //  $invoicevalue = moneyFormatIndia1(($invoice_value));
                $value['invoice_value'] = '<span class="po_date text-right d-block" id="po">' . $invoice_value . '</span>';
                // $value['invoice_value'] = $invoice_value;


                // $value['s_no'] = $sno + 1;
                $SNO = $sno + 1;
                $value['s_no'] = $SNO;

                //  $value['po_num'] = '<span class="po_date text-right d-block" id="po">'. $value['po_num'].'</span>';
                $value['po_num'] = '<strong>' . $value['po_num'] . '</strong><br>' . date("d-m-Y", strtotime($value['po_date']));



                // $orgDate = $value['po_date'];
                // $value['invoice_date'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_date'] . '</span>';
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));


                $value['file_name'] = '<span class="po_date text-center d-block" id="po">' . image_view("po_form", $value['unique_id'], $value['file_name']) . '</span>';

                if ($value['bill_status'] == '0') {
                    $value['bill_status'] = 'Pending';
                } else if ($value['bill_status'] == '1') {
                    $value['bill_status'] = 'Completed';
                } else if ($value['bill_status'] == '2') {
                    $value['bill_status'] = 'Completed';
                } else if ($value['bill_status'] == '3') {
                    $value['bill_status'] = "<span style='color: red;'>Bill Rejected</span>";
                } else if ($value['bill_status'] == '4') {
                    $value['bill_status'] = "<span style='color: red;'>payment Rejected</span>";
                }
                // else if(($value['file_name'] && ())
                $btn_update = btn_update_elcot($folder_name, $value['unique_id'], $value['invoice_no'], );
                // , $value['ins_unique_id'], $value['dc_number']

                $btn_view = '<a href="index.php?file=elcot_entry/update1&form_unique_id=' . $value['unique_id'] . '&invoice_no=' . $value['invoice_no'] . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


                $value['invoice_no'] = $value['invoice_no'] . '<br>' . $value['invoice_date'];

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    // if($bill_status=='1' || $bill_status=='2' ) {
                    if ($bill_status == '2') {
                        // echo "h";
                        // print_r($value['stock_qty']==$value['invoice_qty']);die();
                        $value['unique_id'] = $btn_view;
                    } else {
                        // $value['form_main_unique_id']='<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

                        // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        //     $value['unique_id'] = $btn_update.$btn_delete;                   
                        // }
                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            // echo "i";
                            $value['unique_id'] = '<span class="po_date text-center d-block" id="po">' . $btn_update . '</span>';
                        }
                        // else if(in_array('5f8808504271036738', $action_ids)){
                        //    $value['form_main_unique_id'] = $btn_delete;
                        // }
                        else {
                            // echo"l";
                            $value['unique_id'] = '';
                        }
                    }

                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_update.$btn_delete;                   
                    // }
                    // else
                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        // echo"hlo";
                        $value['unique_id'] = '<span class="po_date text-center d-block" id="po">' . $btn_update . '</span>';
                    }
                    // else if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    else {
                        $value['unique_id'] = '';
                    }
                }
                // $value['bill_created_date'] = '<input type="hidden" name="bill_created_date"  id="bill_created_date" value="' >

                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }
        echo json_encode($json_array);
        break;

    case 'bill_generate_datatable':
        // print_r('hi');
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        // $form_main_unique_id         = $_POST['bill_form_main_unique_id'];
        // $invoice_no         = $_POST['invoice_no'];
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",

            "bill_no",

            "get_po_number (bill_form_main_unique_id) as po_num",
            "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_main_table_1.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",

            "(SELECT count(invoice_no) 
                FROM bill_submission_sub 
                WHERE bill_submission_sub.bill_no = $table_main_table_1.bill_no 
                AND bill_submission_sub.is_delete = 0 ) as invcount",
            "invoice_value",
            "claim_amount",
            "'' as claimamnt", // fixed empty column
            "bg_num",
            "bill_form_main_unique_id",
            "invoice_no",
            "invoice_date",
            "bill_status",
            "bill_created_date",
            "po_date",
            "bill_no as bill_num"

        ];
        $table_details = [
            $table_main_table_1,
            $columns
        ];



        // Handle date inputs safely
        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

        $where = "1 AND po_date >= '$from_date'
          AND po_date <= '$to_date'"; // default (no filter)


        if ($opt1 == '40') {
            // Ensure dates are in Y-m-d format for direct SQL comparison
            $from_date_converted = date('Y-m-d', strtotime($from_date));
            $to_date_converted = date('Y-m-d', strtotime($to_date));

            $where = "
        po_date >= '$from_date_converted' AND 
        po_date <= '$to_date_converted'
    ";
        } elseif ($opt1 == '50') {
            $from_date_converted = date('Y-m-d', strtotime($from_date));
            $to_date_converted = date('Y-m-d', strtotime($to_date));

            $where = "
        bill_created_date >= '$from_date_converted' AND 
        bill_created_date <= '$to_date_converted'
    ";
        }

        $where .= " AND (partial_bill_status IS NULL OR partial_bill_status!='3')";
        // Assuming invoice_date is already stored in DATE format
//  // bill_created_date >= '$from_date' AND 
        // bill_created_date <= '$to_date'

        // print_r($where);die();
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // and form_main_unique_id='".$_POST['bill_form_main_unique_id']."'
        // $where = "bill_status='0'";
        // print_R($where);
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }
        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);die();
        $total_records = total_records();
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                // $value['s_no'] = $sno + 1;
                $SNO = $sno + 1;
                $value['s_no'] = $SNO;

                $invoicevalue = $value['invoice_value'];

                $claim_amount = $value["claim_amount"];
                $claim_amt = ((floatval($invoicevalue) * $claim_amount) / 100);
                $value["claimamnt"] = '<span class="po_date text-right d-block" id="po">' . moneyFormatIndia1($claim_amt) . '</span>';
                ;

                // $value['invoice_value'] = moneyFormatIndia($value['invoice_value']);
                $invoice_value = moneyFormatIndia1($value['invoice_value']);
                $value['invoice_value'] = '<span class="po_date text-right d-block" id="po">' . $invoice_value . '</span>';
                // $value['invoice_value'] = $invoice_value;
                // $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));


                $value['po_date'] = date("d-m-Y", strtotime($value['po_date']));
                if ($value['bill_created_date'] != "") {
                    $value['bill_created_date'] = date("d-m-Y", strtotime($value['bill_created_date']));
                } else {
                    $value['bill_created_date'] = "-";
                }

                $value['bill_no'] = '<b>' . $value['bill_no'] . '</b><br>' . $value['bill_created_date'];

                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b><br>' . $value['invoice_date'];
                $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>' . $value['po_date'];


                if ($value['bg_num'] != 'NA') {
                    $value['bg_num'] = "Yes";
                } else if ($value['bg_num'] == 'NA') {
                    $value['bg_num'] = "No";
                }
                $value['claim_amount'] = '<span class="po_date text-right d-block" id="po">' . $value['claim_amount'] . '</span>';
                $value['invcount'] = '<span class="po_date text-right d-block" id="po">' . $value['invcount'] . '</span>';

                $value['bill_form_main_unique_id'] = '<a href="index.php?file=bill_creation/update1&unique_id=' . $value['bill_form_main_unique_id'] . '&bill_no=' . $value['bill_num'] . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';

                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
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
    case 'partial_bill_datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $po_num_bill = $_POST['po_num_bill'];
        // $ins_unique_id     = $_POST['ins_unique_id'];
        $table_data = '';
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "po_num",
            "bank_required",
            "unique_id"
        ];
        $table_po = "po_form";
        $table_details = [
            $table_po,
            $columns
        ];

        // $where = "unique_id ='" . $po_num_bill . "'";
        $result = $pdo->select($table_details, $where);
        if ($result->status) {
            $result_data = $result->data;
            $columns = [
                "file_org_name",
                "'' as s_no",
                //   "bg_date",


                "bg_num",
                // "bg_value",
                "po_num",
                "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_partial_final_elcot.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",
                "get_ledger_no( 
                (SELECT ledger_no 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_partial_final_elcot.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_no",
                "invoice_no",

                "invoice_qty",
                "invoice_value",

                // "con_contact_name",
                // "con_address",
                // "bill_status",
                // "(select claim_amount from bill_submission_form WHERE bill_submission_form.ins_unique_id=$table_final_elcot.ins_unique_id)as claim_amount",
                "claim_amount",

                // "invoice_auto_id",
                // "consignee_unique_id",
                // "ins_unique_id",
                // "bg_auto_id",
                // "con_contact_name",
                // "con_address",
                // "file_name",
                "unique_id",
                "DATE_FORMAT(bg_date, '%d-%m-%Y') AS bg_date",
                "invoice_date",
                "po_date",

                // "select claim_amount from bill_submission_form where bill_submission_form.bill_form_main_unique_id=$table_final_elcot.bill_form_unique_id)as claim_amount",
            ];
            $table_details = [
                $table_partial_final_elcot,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
            // if ($po_num_bill == '') {
            $where = "bill_status='1'";
            //  AND ins_unique_id='".$ins_unique_id."'
            // AND ins_unique_id='".$ins_unique_id."'
            // } else if ($po_num_bill != '') {
            //     $where = "unique_id ='" . $po_num_bill . "' and  bill_status='1'";
            // }
            // print_r($where);die();
            $order_column = $_POST["order"][0]["column"];
            $order_dir = $_POST["order"][0]["dir"];
            // Datatable Ordering 
            $order_by = datatable_sorting($order_column, $order_dir, $columns);
            // Datatable Searching
            $search = datatable_searching($search, $columns);
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
                $where .= $search;
            }
            $sql_function = "SQL_CALC_FOUND_ROWS";
            $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result);
            $total_records = total_records();
            if ($result->status) {
                $res_array = $result->data;
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
                    // if ($value['con_contact_NAme'] == '') {
                    //     $value['con_contact_NAme'] = 'NA';
                    // }
                    // if ($value['con_address'] == '') {
                    //     $value['con_address'] = 'NA';
                    // }
                    if ($value['invoice_no'] == '') {
                        $value['invoice_no'] = 'NA';
                    }
                    if ($value['invoice_date'] == '') {
                        $value['invoice_date'] = 'NA';
                    }
                    // $value['s_no'] = $sno + 1;
                    $SNO = $sno + 1;
                    $value['s_no'] = '<span class="po_date text-right d-block" id="po">' . $SNO . '</span>';

                    //  $value['file_NAme']= image_view("po_form", $value['consignee_unique_id'], $value['file_NAme']);
                    $value['file_org_name'] = '<input class="myCheck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >
                        <input type="hidden" name="bill_form_unique_id"  id="bill_form_unique_id" value="' . $value['unique_id'] . '">
                        <input type="hidden" name="po_num"  id="po_num" value="' . $value['po_num'] . '">
                        <input type="hidden" name="po_date"  id="po_date" value="' . $value['po_date'] . '">
                        <input type="hidden" name="invoice_no[]"  id="invoice_no" value="' . $value['invoice_no'] . '">
                        <input type="hidden" name="invoice_qty[]"  id="invoice_qty" value="' . $value['invoice_qty'] . '">
                        <input type="hidden" name="invoice_value[]"  id="invoice_value" value="' . $value['invoice_value'] . '">
                        <input type="hidden" name="bg_num[]" id="bg_num" value="' . $value['bg_num'] . '">
                      
                        <input type="hidden" name="bg_date[]" id="bg_date" value="' . $value['bg_date'] . '">
                        <input type="hidden" name="bg_value[]" id="bg_value" value="' . $value['bg_value'] . '">
                        <input type="hidden" name="invoice_date[]" id="invoice_date" value="' . $value['invoice_date'] . '">
                       
                       
                        <input type="text" name="claim_amount"  id="claim_amount" value="' . $value['claim_amount'] . '">
                       
                       
                        <input type="hidden" name="invoice_date"  id="invoice_date" value="' . $value['invoice_date'] . '">
                        <input type="hidden" name="bank_required" id="bank_required" value="' . $result_data[0]['bank_required'] . '">';



                    $value['bg_num'] = '<b>' . $value['bg_num'] . '</b><br>' . $value['bg_date'];

                    $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>' . $value['po_date'];

                    $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b><br>' . $value['invoice_date'];
                    $value['invoice_qty'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_qty'] . '</span>';
                    $value['invoice_value'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_value'] . '</span>';
                    $value['claim_amount'] = '<span class="po_date text-right d-block" id="po">' . $value['claim_amount'] . '</span>';


                    $data[] = array_values($value);
                    $sno++;
                }
                $sno++;
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => intval($total_records),
                    "recordsFiltered" => intval($total_records),
                    "data" => $data,
                    "testing" => $result->sql
                ];
            } else {
                print_r($result);
            }
        }
        echo json_encode($json_array);
        break;


    case 'bill_datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $po_num_bill = $_POST['po_num_bill'];
        $po_num = $_POST['po_num'];
        $ins_unique_id = $_POST['ins_unique_id'];
        $table_data = '';
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "po_num",
            "bank_required",
            "unique_id"
        ];
        $table_po = "po_form";
        $table_details = [
            $table_po,
            $columns
        ];

        // $where = "unique_id ='" . $po_num_bill . "'";
        $result = $pdo->select($table_details, $where);
        if ($result->status) {
            $result_data = $result->data;
            $columns = [
                "file_org_name",
                "'' as s_no",
                "(SELECT po_num from po_form where unique_id = $table_final_elcot.unique_id)po_num",
                "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_final_elcot.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",
                "get_ledger_no( 
                (SELECT ledger_no 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_final_elcot.invoice_no 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_no",
                "invoice_no",
                "invoice_qty",
                "invoice_value",
                "claim_amount",
                "bg_auto_id",
                "unique_id",
                "(SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.invoice_no = $table_final_elcot.invoice_no 
                AND invoice_creation_main.is_delete = 0 group by  invoice_no)as ledgername",

                "invoice_date",
                "po_date",
               ];
            $table_details = [
                $table_final_elcot,
                $columns
            ];

            $where = "bill_status = '1' and unique_id = '" . $po_num . "'"; // Filter based on bill status

            $order_column = $_POST["order"][0]["column"];
            $order_dir = $_POST["order"][0]["dir"];

            // Datatable Ordering
            $order_by = datatable_sorting($order_column, $order_dir, $columns);

            // Datatable Searching
            $search_value = $_POST["search"]["value"] ?? ''; // Grab search input
            $search = datatable_searching($search_value, $columns);

            if (!empty($search)) {
                $where .= " AND ($search)";
            }

            $sql_function = "SQL_CALC_FOUND_ROWS";

            // Fetch filtered records
            $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);

            $total_records = total_records();
            if ($result->status) {
                $res_array = $result->data;
                foreach ($res_array as $key => $value) {

                    if ($value['bg_value'] == '') {
                        $value['bg_value'] = 'NA';
                    }
                
                    if ($value['invoice_no'] == '') {
                        $value['invoice_no'] = 'NA';
                    }
                    if ($value['invoice_date'] == '') {
                        $value['invoice_date'] = 'NA';
                    }

                    $SNO = $sno + 1;
                    $value['s_no'] = '<span class="po_date text-center d-block" id="po">' . $SNO . '</span>';

                    //  $value['file_NAme']= image_view("po_form", $value['consignee_unique_id'], $value['file_NAme']);
                    $value['file_org_name'] = '<input class="myCheck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >
                        <input type="hidden" name="bill_form_unique_id"  id="bill_form_unique_id" value="' . $value['unique_id'] . '">
                            <input type="hidden" name="po_num"  id="po_num" value="' . $value['po_num'] . '">
                            <input type="hidden" name="po_date"  id="po_date" value="' . $value['po_date'] . '">
                            <input type="hidden" name="invoice_no[]"  id="invoice_no" value="' . $value['invoice_no'] . '">
                            <input type="hidden" name="invoice_qty[]"  id="invoice_qty" value="' . $value['invoice_qty'] . '">
                            <input type="hidden" name="invoice_value[]"  id="invoice_value" value="' . $value['invoice_value'] . '">
                            <input type="hidden" name="invoice_date[]" id="invoice_date" value="' . $value['invoice_date'] . '">
                            
                            <input type="hidden" name="ledgername"  id="ledgername" value="' . $value['ledgername'] . '">
                            <input type="hidden" name="claim_amount"  id="claim_amount" value="' . $value['claim_amount'] . '">
                            <input type="hidden" name="invoice_auto_id"  id="invoice_auto_id" value="' . $value['invoice_auto_id'] . '">
                            <input type="hidden" name="ledger_no"  id="ledger_no" value="' . $value['ledger_no'] . '">
                            
                            <input type="hidden" name="invoice_date"  id="invoice_date" value="' . $value['invoice_date'] . '">
                            <input type="hidden" name="bank_required" id="bank_required" value="' . $result_data[0]['bank_required'] . '">
                            <input type="hidden" name="dc_number" id="dc_number" value="' . $value['dc_number'] . '">
                            <input type="hidden" name="dc_date" id="dc_date" value="' . $value['dc_date'] . '">';


                    $value['invoice_date'] = date("d-m-Y", strtotime($value['invoice_date']));


                    $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b></br>' . $value['invoice_date'];


                    $value['claim_amount'] = '<span class="po_date text-right d-block" id="po">' . $value['claim_amount'] . '</span>';
                    // $value['claim_amount'] = '<span class="po_date text-right d-block" id="po">'.$value['claim_amount']%.'</span>';
                    $value['invoice_qty'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_qty'] . '</span>';
                    $value['ledger_no'] = '<span class="po_date text-right d-block" id="po">' . $value['ledger_no'] . '</span>';


                    $orgDate = $value['po_date'];
                    $value['po_date'] = date("d-m-Y", strtotime($orgDate));


                    $value['po_num'] = '<b>' . $value['po_num'] . '</b></br>' . $value['po_date'];


                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                    $invoice_value = moneyFormatIndia1($value['invoice_value']);
                    $value['invoice_value'] = '<span class="po_date text-right d-block" id="po">' . $invoice_value . '</span>';
                    // $value['invoice_value'] = $invoice_value;

                    $data[] = array_values($value);
                    $sno++;
                }
                $sno++;
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => intval($total_records),
                    "recordsFiltered" => intval($total_records),
                    "data" => $data,
                    "testing" => $result->sql
                ];
            } else {
                print_r($result);
            }
        }
        echo json_encode($json_array);
        break;
    case 'delete':
        $unique_id = $_POST['unique_id'];
        $columns = [
            "is_delete" => 1
        ];
        $update_where = [
            "unique_id" => $unique_id
        ];
        $action_obj = $pdo->update($table, $columns, $update_where);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "success_delete";
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);
        break;

    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    case 'user_permission_1':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    case 'user_permission_2':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    case 'user_permission_3':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    //  case 'user_type_options':
    // $user_type          = $_POST['user_type'];
    // $user_type_options  = under_user_type($user_type);
    // $user_type_options  = select_option($user_type_options,"Select");
    // echo $user_type_options;
    // break;

    case "get_cus_po_details";

        $po_unique_id = $_POST['po_num'];

        $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
        $stmtCus->bindParam(':unique_id', $po_unique_id);
        $stmtCus->execute();

        $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($customer_data)) {
            $customerAddress = $customer_data[0]["bill_address"];
            $customerDept = department_name($customer_data[0]["department"]);
            $customername = $customer_data[0]["contact_name"];
            $customerContact = $customer_data[0]["contact_number"];
            $customerLan = $customer_data[0]["landline_number"];
            $customerEmail = $customer_data[0]["email"];
            $customerState = con_state_name_stock($customer_data[0]["state_name"]);
            $customerDistrict = district_name_stock($customer_data[0]["district"]);
            $customerPincode = $customer_data[0]["pin"];
            $cus_address = $customerAddress . ',' . $customerDistrict . ',' . $customerState . '<br>' . $customerPincode;
        }

        $stmtCus->closeCursor();




        $table_user = "po_form";
        $columns = [
            "po_num",
            "po_date",
            "get_executive_name(executive_name) as executive_name",

        ];
        $select_where = "unique_id = '" . $po_unique_id . "' and is_delete= 0";

        $table_details = [
            $table_user,
            $columns
        ];

        $result_values = $pdo->select($table_details, $select_where);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $po_num = $result_values[0]["po_num"];
            $po_date = disdate($result_values[0]["po_date"]);
            $executive_name = $result_values[0]["executive_name"];

            $pr_details = pr_details($po_unique_id);

            if (!empty($pr_details)) {
                // If you expect only one row
                $warranty = $pr_details[0]["warranty"];

                if ($warranty == 1) {
                    $warranty = 'Yes';
                } else {
                    $warranty = 'No';
                }

                $bg_percen = $pr_details[0]["bg_percen"];
                if ($bg_percen != '') {
                    $bg_percen = $bg_percen . '%';
                } else {
                    $bg_percen = '-';
                }

                $bg_month = $pr_details[0]["bg_month"];

                if ($bg_month == '') {
                    $bg_month = '-';
                }

            } else {
                // Handle no data
                $warranty = $bg_percen = $bg_month = '-';
            }



        }




        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "customerAddress" => $customerAddress,
            "customerName" => $customerName,
            "customerDept" => $customerDept,
            "customerLan" => $customerLan,
            "customerEmail" => $customerEmail,
            "customerState" => $customerState,
            "customerDistrict" => $customerDistrict,
            "customerPincode" => $customerPincode,
            "customerContact" => $customerContact,
            "po_num" => $po_num,
            "po_date" => $po_date,
            "executive_name" => $executive_name,
            "warranty" => $warranty,
            "bg_percen" => $bg_percen,
            "bg_month" => $bg_month,
            "cus_address" => $cus_address,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);



        break;




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



function image_view_1($folder_name = "", $unique_id = "", $scanned_dc_copy = "")
{
    // echo $file_name;
    $file_names = explode(',', $scanned_dc_copy);
    $image_view_1 = '';

    if ($scanned_dc_copy) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_1 .= "&nbsp";
                } else {
                    $image_view_1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $scanned_dc_copy);

            if ($scanned_dc_copy) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_1 .= '<a href="javascript:print_view_2(\'/' . $scanned_dc_copy . '\')"><img src="uploads/' . $folder_name . '/' . $scanned_dc_copy . '"  height="30px" width="30px" ></a>';
                    // $image_view_1 .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_1 .= '<a href="javascript:print_pdf_2(\'/' . $scanned_dc_copy . '\')"><img src="uploads/elcot_entry/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_1 .= '<a href="javascript:print_2(\'/' . $scanned_dc_copy . '\')"><img src="uploads/elcot_entry/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_1 .= '<a href="javascript:print_2(\'/' . $scanned_dc_copy . '\')"><img src="uploads/elcot_entry/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_1;
}

function image_view_2($folder_name = "", $unique_id = "", $scanned_ir_copy = "")
{
    // echo $file_name;
    $file_names = explode(',', $scanned_ir_copy);
    $image_view_2 = '';

    if ($scanned_ir_copy) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_2 .= "&nbsp";
                } else {
                    $image_view_2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $scanned_ir_copy);

            if ($scanned_ir_copy) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_2 .= '<a href="javascript:print_view_2(\'/' . $scanned_ir_copy . '\')"><img src="uploads/' . $folder_name . '/' . $scanned_ir_copy . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_2 .= '<a href="javascript:print_pdf_2(\'/' . $scanned_ir_copy . '\')"><img src="uploads/elcot_entry/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_2 .= '<a href="javascript:print_2(\'/' . $scanned_ir_copy . '\')"><img src="uploads/elcot_entry/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_2 .= '<a href="javascript:print_2(\'/' . $scanned_ir_copy . '\')"><img src="uploads/elcot_entry/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_2;
}

function image_view_3($folder_name = "", $unique_id = "", $scanned_snr_copy = "")
{
    // echo $file_name;
    $file_names = explode(',', $scanned_snr_copy);
    $image_view_3 = '';

    if ($scanned_snr_copy) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $scanned_snr_copy);

            if ($scanned_snr_copy) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_2(\'/' . $scanned_snr_copy . '\')"><img src="uploads/' . $folder_name . '/' . $scanned_snr_copy . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_2(\'/' . $scanned_snr_copy . '\')"><img src="uploads/elcot_entry/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_2(\'/' . $scanned_snr_copy . '\')"><img src="uploads/elcot_entry/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_2(\'/' . $scanned_snr_copy . '\')"><img src="uploads/elcot_entry/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}

function image_view_4($folder_name = "", $unique_id = "", $invoice_copy = "")
{
    // echo $file_name;
    $file_names = explode(',', $invoice_copy);
    $image_view_4 = '';

    if ($invoice_copy) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_4 .= "&nbsp";
                } else {
                    $image_view_4 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $invoice_copy);

            if ($invoice_copy) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_4 .= '<a href="javascript:print_view_2(\'/' . $invoice_copy . '\')"><img src="uploads/' . $folder_name . '/' . $invoice_copy . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_4 .= '<a href="javascript:print_pdf_2(\'/' . $invoice_copy . '\')"><img src="uploads/elcot_entry/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_4 .= '<a href="javascript:print_2(\'/' . $invoice_copy . '\')"><img src="uploads/elcot_entry/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_4 .= '<a href="javascript:print_2(\'/' . $invoice_copy . '\')"><img src="uploads/elcot_entry/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_4;
}

function bill_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM bill_submission_main_table where bill_no LIKE
     'BN%' order by unique_id desc");
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




function pr_details($unique_id = "")
{

    global $pdo;

    $table_name = "product_details_sub";
    $where = [];
    $table_columns = [
        "warranty",
        "bg_percen",
        "bg_month"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        // $where              = [];
        $where["form_main_unique_id"] .= $unique_id;
    }

    $group_by = 'form_main_unique_id';

    $user_types = $pdo->select($table_details, $where, '', '', '', '', $group_by);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}


function bg_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2); // Last 2 digits of year
    $month = date("m");
    $datee = $st_date . $month; // e.g., "2507"

    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return "DB Connection Error";
    }

    // Get latest BG ID for current year+month
    $stmt = $conn->prepare("SELECT bg_id FROM bill_submission_main_table 
        WHERE bg_id LIKE :bg_pattern ORDER BY unique_id DESC LIMIT 1");
    $likePattern = "BG-" . $datee . "-%";
    $stmt->bindParam(':bg_pattern', $likePattern);
    $stmt->execute();

    $latestBg = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($latestBg) {
        $parts = explode('-', $latestBg['bg_id']); // e.g., ['BG', '2507', '0012']
        $lastNumber = (int)$parts[2];
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    $newBgId = 'BG-' . $datee . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    return $newBgId;
}




