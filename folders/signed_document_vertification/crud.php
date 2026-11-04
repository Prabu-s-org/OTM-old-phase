<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "view_sign_document_vertification";
$table_sub = "sign_doc_verification_detail";
$table_install = "installation_details_sublist";
$table_po = "po_form";
// Include DB file and Common Functions
include '../../config/dbconfig.php';

include 'function.php';
// File Upload Library Call



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
$test = "";





// For Developer Testing Purpose
switch ($action) {


//     case 'createupdate':

//         $po_num = $_POST["po_num"];
//         $po_date = $_POST["po_date"];
//         $con_contact_name = $_POST["con_contact_name"];
//         $con_address = $_POST["con_address"];
//         $con_unique_id = $_POST["con_unique_id"];
//         $invoice_no = $_POST["invoice_no"];
//         $dc_number = $_POST["dc_number"];
//         $invoice_date = $_POST["invoice_date"];
//         $dc_received_status = $_POST["dc_received_status"] ?? '';
//         $dc_signed_date = $_POST["dc_signed_date"] ?? '';
//         $ir_status = $_POST["ir_status"] ?? '';
//         $ir_signed_date = $_POST["ir_signed_date"] ?? '';
//         $snr_status = $_POST["snr_status"] ?? '';
//         $snr_signed_date = $_POST["snr_signed_date"] ?? '';
//         $po_product_name = $_POST["po_product_name"];
//         $sts1 = $_POST["sts1"];
//         $sts = $_POST["sts"];
//         $sts2 = $_POST["sts2"];
//         $doc_chn = $_POST["doc_chn"];
//         $reject_reason = $_POST["reject_reason"];
//         $with_bg = $_POST["with_bg"];
//         $without_bg = $_POST["without_bg"];
//         $status_data = $_POST["status"];
//         $form_main_unique_id = $_POST["form_main_unique_id"];
//         $ins_unique_id = $_POST["ins_unique_id"];
//         $unique_id = $_POST["unique_id"];
//         $snr_verify_status = $_POST["snr_verify_status"] ;
//         $signed_complete_status = $_POST["signed_complete_status"] ?? null;
//         $update_where = "";

//         if ($status_data == '1') {
//             $columns = [
//                 "po_num" => $po_num,
//                 "po_date" => $po_date,
//                 "con_contact_name" => $con_contact_name,
//                 "con_address" => $con_address,
//                 "con_unique_id" => $con_unique_id,
//                 "invoice_no" => $invoice_no,
//                 "dc_number" => $dc_number,
//                 "invoice_date" => $invoice_date,
//                 "dc_received_status" => $dc_received_status,
//                 "dc_signed_date" => $dc_signed_date,
//                 "ir_status" => $ir_status,
//                 "ir_signed_date" => $ir_signed_date,
//                 "po_product_name" => $po_product_name,
//                 // "approval"             => $approval,
//                 "ins_unique_id" => $ins_unique_id,
//                 "with_bg" => $with_bg,
//                 "without_bg" => $without_bg,
//                 "status_app" => $status_data,
//                 "reject_reason" => $reject_reason,
//                 "doc_chn" => $doc_chn,
//                 "is_delete" => 1,
//                 'snr_status' => $snr_status,
//                 'snr_signed_date' => $snr_signed_date,
//                 // 'signed_complete_status' => $signed_complete_status,
//                 "form_main_unique_id" => $form_main_unique_id,
//                 "unique_id" => unique_id($prefix),
//                 "inv_verify_approvedby" => $_SESSION["staff_name"],
//                 "inv_verify_approved_date" => date('Y-m-d H:i:s'),
//                 "inv_verify_status" => 1
//             ];
//         } else {
//             $columns = [
//                 "po_num" => $po_num,
//                 "po_date" => $po_date,
//                 "con_contact_name" => $con_contact_name,
//                 "con_address" => $con_address,
//                 "con_unique_id" => $con_unique_id,
//                 "invoice_no" => $invoice_no,
//                 "dc_number" => $dc_number,
//                 "invoice_date" => $invoice_date,
//                 "dc_received_status" => $dc_received_status,
//                 "dc_signed_date" => $dc_signed_date,
//                 "ir_status" => $ir_status,
//                 "ir_signed_date" => $ir_signed_date,
//                 "po_product_name" => $po_product_name,
//                 // "approval"             => $approval,
//                 "ins_unique_id" => $ins_unique_id,
//                 "with_bg" => $with_bg,
//                 "without_bg" => $without_bg,
//                 "status_app" => $status_data,
//                 "reject_reason" => $reject_reason,
//                 "doc_chn" => $doc_chn,
//                 'snr_status' => $snr_status,
//                 'snr_signed_date' => $snr_signed_date,
//                 "form_main_unique_id" => $form_main_unique_id,
//                 "snr_verify_status" => 1,
//                 // 'signed_complete_status' => $signed_complete_status,
//                 "unique_id" => unique_id($prefix),
//                 "inv_verify_approvedby" => $_SESSION["staff_name"],
//                 "inv_verify_approved_date" => date('Y-m-d H:i:s'),
//                 "inv_verify_status" => 1
//             ];


//             $column_upd_ver = [
//                 "snr_verify_status" => 1
//             ];
//             $update_where_ver = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '"';

//             $action_obj_upd_ver = $pdo->update('installation_details', $column_upd_ver, $update_where_ver);
//         }
//         // print_r($action_obj_upd_ver);

//         // Update in dc_num_status
//         if ($signed_complete_status) {
//             // echo " ".$form_main_unique_id;

//             $table_dc_status = "dc_num_status";

//             $columns_sign_status = [
//                 "signed_complete_status" => $signed_complete_status,
//                 "dc_sign_doc_date" => date('Y-m-d H:i:s')
//             ];

//             $update_dc_status = 'form_main_unique_id="' . $form_main_unique_id . '" AND invoice_no="' . $invoice_no . '"';
//             $action_dc_status = $pdo->update($table_dc_status, $columns_sign_status, $update_dc_status);
//             // print_r(  $action_dc_status);die();
//             if ($action_dc_status->status) {
//                 $status = $action_dc_status->status;
//                 $data = $action_dc_status->data;
//                 $error = '';
//                 $sql = $action_dc_status->sql;
//             } else {
//                 $status = $action_dc_status->status;
//                 $data = $action_dc_status->data;
//                 $error = $action_dc_status->error;
//                 $sql = $action_dc_status->sql;
//                 $msg = 'error';
//             }
//         }

//         // Update in invoice_verfication_table

//         $table_invoice_table = "invoice_verfication_table";

//         $columns_sign_status = [
//             "signed_complete_status" => 2
//         ];

//         $update_invoice_table = 'form_main_unique_id="' . $form_main_unique_id . '" AND invoice_no="' . $invoice_no . '"';
//         $action_invoice_table = $pdo->update($table_invoice_table, $columns_sign_status, $update_invoice_table);

//         if ($action_invoice_table->status) {
//             $status = $action_invoice_table->status;
//             $data = $action_invoice_table->data;
//             $error = '';
//             $sql = $action_invoice_table->sql;
//         } else {
//             $status = $action_invoice_table->status;
//             $data = $action_invoice_table->data;
//             $error = $action_invoice_table->error;
//             $sql = $action_invoice_table->sql;
//             $msg = 'error';
//         }
//         ////////////////////

//         $table_details = [
//             $table_sub,
//             [
//                 'COUNT(invoice_no) AS count',

//             ]
//         ];





//         $select_where = 'invoice_no = "' . $invoice_no . '" AND dc_number = "' . $dc_number . '" and ins_unique_id = "' . $ins_unique_id . '" AND is_delete = 0';
//         $action_obj = $pdo->select($table_details, $select_where);
//         // print_r($action_obj);

//         if ($action_obj->status) {
//             $status = $action_obj->status;
//             $data = $action_obj->data;
//             $error = '';
//             $sql = $action_obj->sql;
//         } else {
//             $status = $action_obj->status;
//             $data = $action_obj->data;
//             $error = $action_obj->error;
//             $sql = $action_obj->sql;
//             $msg = 'error';
//         }

//         if ($data[0]['count']) {
//             $msg = 'already';

//         } else if (($data[0]['count'] == 0)) {

//             if ($sts1 == '0') {

//                 $columns_1 = [
//                     "document_verification_status" => $status_data
//                 ];
//                 $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND
//                     invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" and unique_id = "' . $ins_unique_id . '" AND documents_type1="' . $sts1 . '" AND is_delete=0';

//                 $action_obj_1 = $pdo->update($table_install, $columns_1, $update_where_1);

//             } else if ($sts1 == 'IR') {
//                 // print_r($status_data);die();
                
//                 $columns_1 = [
//                     "document_verification_status" => $status_data
//                 ];
//                 $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND
//                     invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" and unique_id = "' . $ins_unique_id . '" AND is_delete=0';

//                 $action_obj_1 = $pdo->update($table_install, $columns_1, $update_where_1);
//                 // print_r($action_obj_1);die();

//             } else {
//                 $columns_1 = [
//                     "document_verification_status" => $status_data
//                 ];
//                 $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND
//                     invoice_no="' . $invoice_no . '"  AND dc_number="' . $dc_number . '" and unique_id = "' . $ins_unique_id . '" AND is_delete=0';

//                 $action_obj_1 = $pdo->update($table_install, $columns_1, $update_where_1);
//                 // print_r($action_obj_1);die();
//             }


//             if ($with_bg == 'on') {
//                 $columns_2 = [
//                     "proceed_bg" => 1
//                 ];
//                 $update_where_2 = 'unique_id="' . $form_main_unique_id . '" AND is_delete=0';
//                 $action_obj_2 = $pdo->update($table_po, $columns_2, $update_where_2);
//             }


//             $columns_dc = [
//                 "dc_status_bill" => 1
//             ];
//             $update_where_dc = 'unique_id="' . $form_main_unique_id . '" AND is_delete=0';

//             $action_obj_dc = $pdo->update($table_po, $columns_dc, $update_where_dc);

//             if ($without_bg == 'on') {
//                 $columns_3 = [
//                     "proceed_bg" => 2
//                 ];
//                 $update_where_3 = 'unique_id="' . $form_main_unique_id . '" AND is_delete=0';
//                 $action_obj_3 = $pdo->update($table_po, $columns_3, $update_where_3);
//             }



//             // ========   mismatch data ==============================================================================


//             $table_inv = "invoice_creation_main";

//             if ($status_data == '1') {
//                 $columns_inv = [
//                     "sign_mismatch_status" => $status_data,
//                     "installation_status" => 3,
//                     // "engineer_name" =>"",
//                     "eng_remarks" => "",
//                     "installation_com_date" => "",
//                     "sign_reject_reason" => $reject_reason,
//                 ];
//                 $update_where_inv = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                 $action_obj_inv = $pdo->update($table_inv, $columns_inv, $update_where_inv);
//                 // print_r($action_obj_inv);
//             }


//             if ($status_data == '1') {

//                 $columns_install = [
//                     "is_delete" => 1,
//                     "sign_mismatch_status" => $status_data,
//                     "sign_reject_reason" => $reject_reason,
//                 ];

//                 $update_where_install = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" and unique_id = "' . $ins_unique_id . '" AND is_delete=0';
//                 $action_obj_install = $pdo->update($table_install, $columns_install, $update_where_install);



//                 //   $table_install_main = "installation_details";
// //                  $columns_install_main = [
// //                     "is_delete" => 1,
// //                     "sign_mismatch_status" => $status_data,
// //                     "sign_reject_reason" => $reject_reason,
// //                 ];

//                 //                 $update_where_install_main = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '"';
// //                 $action_obj_install = $pdo->update($table_install_main, $columns_install_main, $update_where_install);

//             }

//             //to remove column values in installation details main 

//             if ($status_data == '1') {
//                 if ($sts != '' && ($sts1 == '' || $sts1 == 0) && ($sts2 == '' || $sts2 == 0)) {
//                     $table_install_main = "installation_details";
//                     $columns_install_main = [
//                         // "is_delete" => 1,
//                         "dc_file" => '',
//                         "dc_received_sts" => '',
//                         "dc_cus_signed_date" => '',
//                         "dc_original_name" => '',
//                         "sign_mismatch_status" => $status_data,
//                         "sign_reject_reason" => $reject_reason,
//                         "documents_type" => 0

//                     ];
//                     $update_where_main = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                     $action_obj_install_main = $pdo->update($table_install_main, $columns_install_main, $update_where_main);

//                 } elseif ($sts != '' && ($sts1 == '' || $sts1 == 0) && $sts2 != '') {

//                     $table_install_main = "installation_details";
//                     $columns_install_main = [
//                         // "is_delete" => 1,
//                         "dc_file" => '',
//                         "dc_received_sts" => '',
//                         "dc_cus_signed_date" => '',
//                         "dc_original_name" => '',
//                         "snr_file" => '',
//                         "snr_rec_status" => '',
//                         "snr_cus_signed_date" => '',
//                         "snr_original_name" => '',
//                         "sign_mismatch_status" => $status_data,
//                         "sign_reject_reason" => $reject_reason,
//                         "documents_type" => 0,
//                         "documents_type2" => 0
//                     ];
//                     $update_where_main = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0 ';
//                     // echo $update_where_main;

//                     $action_obj_install_main = $pdo->update($table_install_main, $columns_install_main, $update_where_main);

//                 } elseif ($sts != '' && $sts1 != '' && $sts2 != '') {

//                     if ($snr_verify_status == 1) {

//                         $columns_install_main = [
//                             // "is_delete" => 1,
//                             "ir_file" => '',
//                             "ir_rec_status" => '',
//                             "ir_cus_signed_date" => '',
//                             "ir_original_name" => '',
//                             "sign_mismatch_status" => $status_data,
//                             "sign_reject_reason" => $reject_reason,
//                             "documents_type1" => 0
//                         ];
//                     } elseif ($snr_verify_status == 0) {

//                         $columns_install_main = [
//                             // "is_delete" => 1,
//                             "dc_file" => '',
//                             "dc_received_sts" => '',
//                             "dc_cus_signed_date" => '',
//                             "dc_original_name" => '',
//                             "ir_file" => '',
//                             "ir_rec_status" => '',
//                             "ir_cus_signed_date" => '',
//                             "ir_original_name" => '',
//                             "sign_mismatch_status" => $status_data,
//                             "sign_reject_reason" => $reject_reason,
//                             "documents_type" => 0,
//                             "documents_type1" => 0,
//                         ];
//                     }
//                     $table_install_main = "installation_details";

//                     $update_where_main = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                     $action_obj_install_main = $pdo->update($table_install_main, $columns_install_main, $update_where_main);
//                 }

//             }

//             //to remove column values in dc_ir_doc_dispatch_details

//             if ($status_data == '1') {

//                 if ($sts != '' && ($sts1 == '' || $sts1 == 0) && ($sts2 == '' || $sts2 == 0)) {

//                     $table_dc_ir = "dc_ir_doc_dispatch_details";
//                     $columns_dc_ir = [
//                         // "is_delete" => 1,
//                         "dc_dispatch_mode" => '',
//                         "name_of_courier" => '',
//                         "dc_pod_no" => '',
//                         "dc_pod_date" => '',
//                         "sign_mismatch_status" => $status_data,
//                         "sign_reject_reason" => $reject_reason,
//                     ];
//                     $update_where_dc_ir = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                     $action_obj_dc_ir = $pdo->update($table_dc_ir, $columns_dc_ir, $update_where_dc_ir);

//                 } elseif ($sts != '' && ($sts1 == '' || $sts1 == 0) && $sts2 != '') {

//                     $table_dc_ir = "dc_ir_doc_dispatch_details";
//                     $columns_dc_ir = [
//                         // "is_delete" => 1,
//                         "dc_dispatch_mode" => '',
//                         "name_of_courier" => '',
//                         "dc_pod_no" => '',
//                         "dc_pod_date" => '',
//                         "snr_dispatch_mode" => '',
//                         "snr_name_courier" => '',
//                         "snr_pod_no" => '',
//                         "snr_pod_date" => '',
//                         "sign_mismatch_status" => $status_data,
//                         "sign_reject_reason" => $reject_reason,
//                     ];
//                     $update_where_dc_ir = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                     $action_obj_dc_ir = $pdo->update($table_dc_ir, $columns_dc_ir, $update_where_dc_ir);


//                 } elseif ($sts != '' && $sts1 != '' && $sts2 != '') {

//                     if ($snr_verify_status == 1) {
//                         $columns_dc_ir = [
//                             // "is_delete" => 1,
//                             "ir_dispatch_mode" => '',
//                             "ins_name_of_courier" => '',
//                             "ir_pod_no" => '',
//                             "ir_pod_date" => '',
//                             "sign_mismatch_status" => $status_data,
//                             "sign_reject_reason" => $reject_reason,
//                         ];
//                     } elseif ($snr_verify_status == 0) {
//                         $columns_dc_ir = [
//                             // "is_delete" => 1,
//                             "dc_dispatch_mode" => '',
//                             "name_of_courier" => '',
//                             "dc_pod_no" => '',
//                             "dc_pod_date" => '',
//                             "ir_dispatch_mode" => '',
//                             "ins_name_of_courier" => '',
//                             "ir_pod_no" => '',
//                             "ir_pod_date" => '',
//                             "sign_mismatch_status" => $status_data,
//                             "sign_reject_reason" => $reject_reason,
//                         ];
//                     }

//                     $table_dc_ir = "dc_ir_doc_dispatch_details";

//                     $update_where_dc_ir = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $con_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

//                     $action_obj_dc_ir = $pdo->update($table_dc_ir, $columns_dc_ir, $update_where_dc_ir);
//                 }


//             }


//             // ========   mismatch data==============================================================================

//             $action_obj = $pdo->insert($table_sub, $columns);

//             // $pdo->query("CALL update_inv_verfiy_document_verification_status()");
//             // $pdo->query("CALL update_invoice_verification_1_snr()");
//             // $pdo->query("CALL update_invoice_bill_status()");

//             // print_r($pdo);

//             if ($action_obj->status) {
//                 $status = $action_obj->status;
//                 $data = $action_obj->data;
//                 $error = '';
//                 $sql = $action_obj->sql;

//                 if ($unique_id) {
//                     $msg = 'update';

//                 } else {
//                     $msg = 'create';
//                 }
//             } else {
//                 $status = $action_obj->status;
//                 $data = $action_obj->data;
//                 $error = $action_obj->error;
//                 $sql = $action_obj->sql;
//                 $msg = 'error';
//             }

//         } else {
//             $status = $action_obj->status;
//             $data = $action_obj->data;
//             $error = $action_obj->error;
//             $sql = $action_obj->sql;
//             $msg = 'error';
//         }
//         // }

//         $json_array = [
//             "status" => $status,
//             "data" => $data,
//             "error" => $error,
//             "msg" => $msg,
//             "sql" => $sql
//         ];
//         echo json_encode($json_array);
//         break;


case 'createupdate':

    $po_num = $_POST["po_num"];
    $po_date = $_POST["po_date"];
    $con_contact_name = $_POST["con_contact_name"];
    $con_address = $_POST["con_address"];
    $con_unique_id = $_POST["con_unique_id"];
    $invoice_no = $_POST["invoice_no"];
    $dc_number = $_POST["dc_number"];
    $invoice_date = $_POST["invoice_date"];
    $dc_received_status = $_POST["dc_received_status"] ?? '';
    $dc_signed_date = $_POST["dc_signed_date"] ?? '';
    $ir_status = $_POST["ir_status"] ?? '';
    $ir_signed_date = $_POST["ir_signed_date"] ?? '';
    $snr_status = $_POST["snr_status"] ?? '';
    $snr_signed_date = $_POST["snr_signed_date"] ?? '';
    $po_product_name = $_POST["po_product_name"];
    $sts1 = $_POST["sts1"];
    $sts = $_POST["sts"];
    $sts2 = $_POST["sts2"];
    $doc_chn = $_POST["doc_chn"];
    $reject_reason = $_POST["reject_reason"];
    $with_bg = $_POST["with_bg"];
    $without_bg = $_POST["without_bg"];
    $status_data = $_POST["status"];
    $form_main_unique_id = $_POST["form_main_unique_id"];
    $ins_unique_id = $_POST["ins_unique_id"];
    $unique_id = $_POST["unique_id"];
    $snr_verify_status = $_POST["snr_verify_status"];
    $signed_complete_status = $_POST["signed_complete_status"] ?? null;

    function checkQuery($result)
    {
        if (!$result->status) {

            $json_array = [
                "status" => 0,
                "data" => "",
                "error" => $result->error,
                "msg" => "error",
                "sql" => $result->sql
            ];

            echo json_encode($json_array);
            exit;
        }
    }

    if ($status_data == '1') {

        $columns = [
            "po_num" => $po_num,
            "po_date" => $po_date,
            "con_contact_name" => $con_contact_name,
            "con_address" => $con_address,
            "con_unique_id" => $con_unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number,
            "invoice_date" => $invoice_date,
            "dc_received_status" => $dc_received_status,
            "dc_signed_date" => $dc_signed_date,
            "ir_status" => $ir_status,
            "ir_signed_date" => $ir_signed_date,
            "po_product_name" => $po_product_name,
            "ins_unique_id" => $ins_unique_id,
            "with_bg" => $with_bg,
            "without_bg" => $without_bg,
            "status_app" => $status_data,
            "reject_reason" => $reject_reason,
            "doc_chn" => $doc_chn,
            'snr_status' => $snr_status,
            'snr_signed_date' => $snr_signed_date,
            "form_main_unique_id" => $form_main_unique_id,
            "unique_id" => unique_id($prefix),
            "inv_verify_approvedby" => $_SESSION["staff_name"],
            "inv_verify_approved_date" => date('Y-m-d H:i:s'),
            "inv_verify_status" => 1
        ];

    } else {

        $columns = [
            "po_num" => $po_num,
            "po_date" => $po_date,
            "con_contact_name" => $con_contact_name,
            "con_address" => $con_address,
            "con_unique_id" => $con_unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number,
            "invoice_date" => $invoice_date,
            "dc_received_status" => $dc_received_status,
            "dc_signed_date" => $dc_signed_date,
            "ir_status" => $ir_status,
            "ir_signed_date" => $ir_signed_date,
            "po_product_name" => $po_product_name,
            "ins_unique_id" => $ins_unique_id,
            "with_bg" => $with_bg,
            "without_bg" => $without_bg,
            "status_app" => $status_data,
            "reject_reason" => $reject_reason,
            "doc_chn" => $doc_chn,
            'snr_status' => $snr_status,
            'snr_signed_date' => $snr_signed_date,
            "form_main_unique_id" => $form_main_unique_id,
            "snr_verify_status" => 1,
            "unique_id" => unique_id($prefix),
            "inv_verify_approvedby" => $_SESSION["staff_name"],
            "inv_verify_approved_date" => date('Y-m-d H:i:s'),
            "inv_verify_status" => 1
        ];

        $column_upd_ver = [
            "snr_verify_status" => 1
        ];

        $update_where_ver = 'po_form_unique_id="' . $form_main_unique_id . '" 
        and consignee_unique_id="' . $con_unique_id . '" 
        AND invoice_no="' . $invoice_no . '" 
        AND dc_number="' . $dc_number . '"';

        $action_obj_upd_ver = $pdo->update(
            'installation_details',
            $column_upd_ver,
            $update_where_ver
        );

        checkQuery($action_obj_upd_ver);
    }

    // dc_num_status update

    if ($signed_complete_status) {

        $table_dc_status = "dc_num_status";

        $columns_sign_status = [
            "signed_complete_status" => $signed_complete_status,
            "dc_sign_doc_date" => date('Y-m-d H:i:s')
        ];

        $update_dc_status = 'form_main_unique_id="' . $form_main_unique_id . '" 
        AND invoice_no="' . $invoice_no . '"';

        $action_dc_status = $pdo->update(
            $table_dc_status,
            $columns_sign_status,
            $update_dc_status
        );

        checkQuery($action_dc_status);
    }

    // invoice_verfication_table

    $table_invoice_table = "invoice_verfication_table";

    $columns_sign_status = [
        "signed_complete_status" => 2
    ];

    $update_invoice_table = 'form_main_unique_id="' . $form_main_unique_id . '" 
    AND invoice_no="' . $invoice_no . '"';

    $action_invoice_table = $pdo->update(
        $table_invoice_table,
        $columns_sign_status,
        $update_invoice_table
    );

    checkQuery($action_invoice_table);

    // already check

    $table_details = [
        $table_sub,
        [
            'COUNT(invoice_no) AS count',
        ]
    ];

    $select_where = 'invoice_no = "' . $invoice_no . '" 
    AND dc_number = "' . $dc_number . '" 
    and ins_unique_id = "' . $ins_unique_id . '" 
    AND is_delete = 0';

    $action_obj = $pdo->select($table_details, $select_where);

    checkQuery($action_obj);

    $data = $action_obj->data;

    if ($data[0]['count']) {

        $msg = 'already';

    } else {

        // installation_details_sublist update

        $columns_1 = [
            "document_verification_status" => $status_data
        ];

        $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" 
        and consignee_unique_id="' . $con_unique_id . '" 
        AND invoice_no="' . $invoice_no . '" 
        AND dc_number="' . $dc_number . '" 
        and unique_id = "' . $ins_unique_id . '" 
        AND is_delete=0';

        $action_obj_1 = $pdo->update(
            $table_install,
            $columns_1,
            $update_where_1
        );

        checkQuery($action_obj_1);

        // proceed bg

        if ($with_bg == 'on') {

            $columns_2 = [
                "proceed_bg" => 1
            ];

            $update_where_2 = 'unique_id="' . $form_main_unique_id . '" 
            AND is_delete=0';

            $action_obj_2 = $pdo->update(
                $table_po,
                $columns_2,
                $update_where_2
            );

            checkQuery($action_obj_2);
        }

        // dc status bill

        $columns_dc = [
            "dc_status_bill" => 1
        ];

        $update_where_dc = 'unique_id="' . $form_main_unique_id . '" 
        AND is_delete=0';

        $action_obj_dc = $pdo->update(
            $table_po,
            $columns_dc,
            $update_where_dc
        );

        checkQuery($action_obj_dc);

        // without bg

        if ($without_bg == 'on') {

            $columns_3 = [
                "proceed_bg" => 2
            ];

            $update_where_3 = 'unique_id="' . $form_main_unique_id . '" 
            AND is_delete=0';

            $action_obj_3 = $pdo->update(
                $table_po,
                $columns_3,
                $update_where_3
            );

            checkQuery($action_obj_3);
        }

        // mismatch update

        if ($status_data == '1') {

            $table_inv = "invoice_creation_main";

            $columns_inv = [
                "sign_mismatch_status" => $status_data,
                "installation_status" => 3,
                "eng_remarks" => "",
                "installation_com_date" => "",
                "sign_reject_reason" => $reject_reason,
            ];

            $update_where_inv = 'form_main_unique_id="' . $form_main_unique_id . '" 
            and consignee_unique_id="' . $con_unique_id . '" 
            AND invoice_no="' . $invoice_no . '" 
            AND dc_number="' . $dc_number . '" 
            AND is_delete=0';

            $action_obj_inv = $pdo->update(
                $table_inv,
                $columns_inv,
                $update_where_inv
            );

            checkQuery($action_obj_inv);
        }

        // FINAL insert

        $action_obj = $pdo->insert($table_sub, $columns);

        checkQuery($action_obj);

        // LAST update is_delete

        if ($status_data == '1') {

            $columns_install = [
                "is_delete" => 1,
                "sign_mismatch_status" => $status_data,
                "sign_reject_reason" => $reject_reason,
            ];

            $update_where_install = 'po_form_unique_id="' . $form_main_unique_id . '" 
            and consignee_unique_id="' . $con_unique_id . '" 
            AND invoice_no="' . $invoice_no . '" 
            AND dc_number="' . $dc_number . '" 
            and unique_id = "' . $ins_unique_id . '" 
            AND is_delete=0';

            $action_obj_install = $pdo->update(
                $table_install,
                $columns_install,
                $update_where_install
            );

            checkQuery($action_obj_install);
        }

        $msg = ($unique_id) ? 'update' : 'create';
    }

    $json_array = [
        "status" => 1,
        "data" => "",
        "error" => "",
        "msg" => $msg,
        "sql" => ""
    ];

    echo json_encode($json_array);

break;
   

    case 'datatable':


        // print_r('test');die();
        $table_snr = 'view_sign_document_vertification_with_snr';
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $data = [];
        $from_date = $_POST['from_date'];

        $to_date = $_POST['to_date'];

        $status = $_POST['status'];
        $opt = $_POST['opt'];
        $snr_team_mem = $_POST['snr_team_mem'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "po_date",
            //     "(SELECT staff_name FROM user 
            // WHERE user.staff_id = view_sign_document_vertification_with_snr.team_member ) AS team_member",

            "get_user_name(view_sign_document_vertification_with_snr.team_member) AS team_member",

            "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_sign_document_vertification_with_snr.department group by department_creation.unique_id) AS department",
            // "con_contact_name",

            // "invoice_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_dates",


            "dc_status",
            "dc_file",
            // "ir_status",
            // "ir_file",
            "snr_status",
            "snr_file",
            // "(select snr_pod_date from dc_ir_doc_dispatch_details where invoice_no = view_sign_document_vertification_with_snr.invoice_no AND is_delete=0  group by invoice_no ) AS snr_pod_date",
            "(SELECT DATE_FORMAT(snr_pod_date, '%d-%m-%Y') FROM dc_ir_doc_dispatch_details WHERE invoice_no = view_sign_document_vertification_with_snr.invoice_no  AND is_delete = 0 GROUP BY invoice_no ) AS snr_pod_date",

            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            "invoice_no",
            "po_num",
            "dc_number",
            "invoice_no",
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = ( SELECT con_state_name FROM consignee_details_sub  WHERE unique_id = view_sign_document_vertification_with_snr.consignee_unique_id   LIMIT 1) LIMIT 1) AS con_state_name",

            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = ( SELECT con_district FROM consignee_details_sub WHERE unique_id = view_sign_document_vertification_with_snr.consignee_unique_id LIMIT 1)  LIMIT 1) AS con_district",

            "(SELECT zone FROM consignee_details_sub WHERE consignee_details_sub.unique_id = view_sign_document_vertification_with_snr.consignee_unique_id  LIMIT 1) as zone",
            "con_address",
            "dc_date"


        ];
        $table_details = [
            $table_snr,
            $columns
        ];
        // if(document_verification_status)


        $where = "document_verification_status = '0' AND ir_status = '0' AND dc_dispatch_mode IS NOT NULL AND dc_dispatch_mode != ''
AND snr_dispatch_mode IS NOT NULL AND snr_dispatch_mode != '' ";

if (!empty($from_date) && !empty($to_date)) {
        if ($opt == '4') {

            $where .= " AND po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
        } else if ($opt == '5') {

            $where .= "AND invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
        }
}
        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741' || $_SESSION['user_type_unique_id'] === '65fac54da3aac66007') {
            if ($snr_team_mem == '') {
                $where .= "";
            } else {
                $where .= " and team_member = '$snr_team_mem' ";
            }
        } else {
            if ($snr_team_mem == '') {
                $where .= "";
            } else {
                $where .= " and team_member = '$snr_team_mem' ";
            }
        }


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
        // print_r($result);die();
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

        // print_r()


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                // $value['po_num'] = '<span class="po_date d-block" id="po">' . $value['po_num'] . '</span>';

                // $value['po_date'] = '<span class="po_date" id="po">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                // $value['po_date'] = '<span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


                $value['po_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'];
                $value['invoice_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'];
                $value['dc_dates'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br>' . $value['dc_dates'];
                $value['department'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['department'] . '</span><br>' . $value['con_district'] . '<br>' . $value['con_state_name'];


                // $value['dc_date'] = '<span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';
                $value['snr_pod_date'] = '<span class="po_date  d-block" id="po">' . $value['snr_pod_date'] . '</span>';

                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    // $orgDate1 = $value['invoice_date'];
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="po_date d-block" id="po">' . $value['invoice_date'] . '</span>';

                }


                // $value['invoice_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['invoice_date'])) . '</span>';
                // $orgDate1 = $value['invoice_date'];
                // $value['invoice_date']  = '<span class="po_date">'.$value['invoice_date'] .'</span>';

                $dc_dispatch_mode = $value['dc_dispatch_mode'];
                if ($value['dc_status'] != '0') {
                    $value['dc_status'] = 'Yes';
                } else {
                    $value['dc_status'] = '-';
                }
                // if ($value['ir_status'] != '0') {
                //     $value['ir_status'] = 'Yes';
                // } else {
                //     $value['ir_status'] = '-';
                // }
                if ($value['snr_status'] != '0') {
                    $value['snr_status'] = 'Yes';
                } else {
                    $value['snr_status'] = '-';
                }
                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                // $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);
                $value['snr_file'] = image_view_2("installation", $value['consignee_unique_id'], $value['snr_file']);
                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);
                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status'] = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status'] = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status'] = "Verified";
                }
                // $document_verification_status = asort('document_verification_status');
                $btn_update = btn_update_7($folder_name, $value['consignee_unique_id'], $value['invoice_no'], $value['ins_unique_id'], $value['dc_number']);
                $value['invoice_no'] = '<span class="po_date d-block" id="po">' . $value['invoice_no'] . '</span>';
                $value['dc_number'] = '<span class="po_date d-block" id="po">' . $value['dc_number'] . '</span>';



                $where_21 = "consignee_unique_id = '" . $value['consignee_unique_id'] . "'";

                $columns_21 = [
                    'snr_status'
                ];

                $table_details_21 = [
                    $table,
                    $columns_21
                ];

                $result_values_21 = $pdo->select($table_details_21, $where_21);
                // print_r($result_values_12);die();
                $status_data = $result_values_21->data;

                // if ($status_data[0]['snr_status'] != '' ) {
                //     $value['consignee_unique_id'] = $btn_update;
                // } 
                // else {
                //     $value['consignee_unique_id'] = '';
                // }
                if ($status_data[0]['snr_status'] != '') {
                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['consignee_unique_id'] = $btn_update;
                    } else {
                        //  if(in_array('5f8808504271036738', $action_ids)){
                        //     $value['unique_id'] = $btn_delete;
                        // }
                        // else{
                        $value['consignee_unique_id'] = '';
                    }
                }
                // }
                // else{
                //     $value['consignee_unique_id'] ='';  
                // }
                // $value['consignee_unique_id'] = $btn_update.$btn_delete;
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

    case 'datatable_with_ir':

        $table_ir = 'view_sign_document_vertification_with_ir';
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $team_mem = $_POST['team_mem'];

        $opt = $_POST['opt'];
        $limit = $length;
        $data = [];

        $status = $_POST['status'];
        $date = date('01-m-Y');
        $date1 = date('d-m-y');
        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "po_date",
            "get_user_name(view_sign_document_vertification_with_ir.team_member) AS team_member",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_ir . ".ledger_name
            group by department_creation_sublist.unique_id) AS ledger_name",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "dc_date",
            "dc_status",
            "dc_file",
            "ir_status",
            "ir_file",
            "(SELECT DATE_FORMAT(ir_pod_date, '%d-%m-%Y') FROM dc_ir_doc_dispatch_details WHERE invoice_no = view_sign_document_vertification_with_ir.invoice_no  AND is_delete = 0 GROUP BY invoice_no ) AS ir_pod_date",
            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            "invoice_no",
            "po_num",
            "(SELECT state_name FROM state_creation  WHERE state_creation.unique_id = (SELECT con_state_name FROM consignee_details_sub  WHERE unique_id = view_sign_document_vertification_with_ir.consignee_unique_id  LIMIT 1 )  LIMIT 1) AS con_state_name",
            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = (SELECT con_district FROM consignee_details_sub WHERE unique_id = view_sign_document_vertification_with_ir.consignee_unique_id  LIMIT 1) LIMIT 1) AS con_district",
            "(SELECT zone FROM consignee_details_sub WHERE consignee_details_sub.unique_id = view_sign_document_vertification_with_ir.consignee_unique_id LIMIT 1) as zone",
            "con_address",
            "invoice_no",
            "dc_number"

        ];
        $table_details = [
            $table_ir,
            $columns
        ];

        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

        $where = ""; // Initialize empty

        if ($opt == '4') {
            if (!empty($from_date)) {
                $where .= " po_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                // Add AND only if there's already a condition
                $where .= (!empty($where) ? " AND " : "") . "po_date <= '" . $to_date . "'";
            }
        } else if ($opt == '5') {
            if (!empty($from_date)) {
                $where .= " invoice_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                $where .= (!empty($where) ? " AND " : "") . "invoice_date <= '" . $to_date . "'";
            }
        }

        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= "";
            } else {
                $where .= (!empty($where) ? " AND " : "") . "team_member = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= "";
            } else {
                $where .= (!empty($where) ? " AND " : "") . " team_member = '$team_mem' ";
            }
        }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns, );

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
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];
                $ins_unique_id = $value['ins_unique_id'];
                $status = $value['document_verification_status'];

                $value['invoice_date'] = '<span style="font-weight:bold; text-transform: uppercase;" id="po">' . $value['invoice_no'] . '</span><br><span class="po_date d-block" id="po">' . $value['invoice_date'] . '</span>';
                $value['po_date'] = '<span style="font-weight:bold; text-transform: uppercase;" id="po">' . $value['po_num'] . '</span><br><span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                $value['dc_date'] = '<span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';
                $value['ledger_name'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['ledger_name'] . '</span><br>' . $value['con_district'] . '<br>' . $value['con_state_name'];
                $value['dc_date'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['dc_number'] . '</span><br>' . $value['dc_date'];

                $dc_dispatch_mode = $value['dc_dispatch_mode'];
                if ($value['dc_status'] != '0') {
                    $value['dc_status'] = 'Yes';
                } else {
                    $value['dc_status'] = '-';
                }

                if ($value['ir_status'] == '0' || $value['ir_status'] == 'undefined' || $value['ir_status'] == '') {
                    $value['ir_status'] = 'NA';
                } else {
                    $value['ir_status'] = 'YES';
                }

                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);

                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status'] = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status'] = "Mismatch";

                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status'] = "Verified";
                }

                $btn_update = btn_update_7($folder_name, $value['consignee_unique_id'], $value['invoice_no'], $value['ins_unique_id'], $value['dc_number']);

                $btn_verified_view = btn_view_signed_doc($folder_name, $value['consignee_unique_id'], $value['invoice_no'], $value['ins_unique_id']);


                if (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['consignee_unique_id'] = $btn_update;
                } else {

                    $value['consignee_unique_id'] = '';
                }

                $value['invoice_no'] = '<span class="po_date d-block" id="po">' . $value['invoice_no'] . '</span>';
                $value['dc_number'] = '<span class="po_date d-block" id="po">' . $value['dc_number'] . '</span>';

                $value['ir_pod_date'] = '<span class="po_date d-block" id="po">' . $value['ir_pod_date'] . '</span>';

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

    case 'mismatch_datatable':
        $table_sign = "view_mismatch_data";

        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        // $from_date  = $_POST['from_date'];
        // $to_date    = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        $data = [];
        // $from_date = date("d-m-Y", strtotime($_POST['from_date']));
        // $to_date = date("d-m-Y", strtotime($_POST['to_date']));
        $status = $_POST['status'];
        $mismatch_team_mem = $_POST['mismatch_team_mem'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "po_date",
            // "ledger_name",
            "ledger_name",
            "(select staff_name from user where user.staff_id = view_mismatch_data.team_mem) as team_mem",

            "invoice_date",
            "dc_date",
            "dc_file",
            "ir_file",
            "document_verification_status",
            "sign_reject_reason",
            "consignee_unique_id",
            "po_form_unique_id",
            "unique_id as ins_unique_id",
            "get_po_number(po_form_unique_id) as po_num",
            "invoice_no",
            "dc_number",
            "con_address",
            'get_district_name(con_district) as con_district',
            'get_state_name(con_state_name) as con_state_name',


        ];
        $table_details = [
            $table_sign,
            $columns
        ];
        $where = "document_verification_status = '1' and is_delete = 1";

        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

        if ($opt1 == '40') {
            if (!empty($from_date)) {
                $where .= " AND po_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                $where .= " AND po_date <= '" . $to_date . "'";
            }
        } else if ($opt1 == '50') {
            if (!empty($from_date)) {
                $where .= " AND invoice_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                $where .= " AND invoice_date <= '" . $to_date . "'";
            }
        }

        if ($mismatch_team_mem != '') {
            $where .= " and team_mem = '" . $mismatch_team_mem . "'";
        }


        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns, );
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
                $SNO = $sno + 1;

                $value['s_no'] = '<span class="po_date d-block" id="po">' . $SNO . '</span>';
                // $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];

                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($orgDate)) . '</span>';


                $orgDate1 = $value['invoice_date'];
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['invoice_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($orgDate1)) . '</span>';

                $value['dc_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';


                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);

                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);

                $value['po_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'];
                $value['dc_date'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['dc_number'] . '</span><br>' . $value['dc_date'];

                $value['invoice_date'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'];

                $value['ledger_name'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['ledger_name'] . '</span><br>' . $value['con_district'] . '<br>' . $value['con_state_name'];

                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status'] = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status'] = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status'] = "Verified";
                }
                // $document_verification_status = asort('document_verification_status');
                // $btn_update         = btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no']);
                // $btn_update         =  btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);

                // $btn_delete         = btn_delete($folder_name,$value['form_main_unique_id']);
                // $value['consignee_unique_id'] = $btn_update;
                // $value['consignee_unique_id'] = $btn_update.$btn_delete;
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

    case 'verified_datatable':
        $table_ver = 'view_verified_data';
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $verified_team_mem = $_POST['verified_team_mem'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $limit = $length;
        $data = [];
        // $from_date = $_POST['from_date'];
        // $to_date = $_POST['to_date'];
        $opt2 = $_POST['opt2'];
        $status = $_POST['status'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "po_date",

            "ledger_name",
            "(SELECT staff_name FROM user WHERE user.staff_id = view_verified_data.team_mem) AS team_mem",
            // "invoice_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "dc_date",
            "dc_file",
            "ir_file",
            "document_verification_status",
            "consignee_unique_id",
            "po_form_unique_id",
            "unique_id as ins_unique_id",
            // "get_po_number(po_form_unique_id) as po_num",
            "po_num",
            "invoice_no",
            "dc_number",
            'get_district_name(con_district) as con_district',
            'get_state_name(con_state_name) as con_state_name',
            "con_address"

            // "invoice_no"
        ];
        $table_details = [
            $table_ver,
            $columns
        ];
        $where = ""; // Initialize empty
        $where = "document_verification_status = 2 and is_delete = 0 AND po_date >= '$from_date'
          AND po_date <= '$to_date'";
        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';



        if ($opt2 == '100') {
            if (!empty($from_date)) {
                $where .= " and po_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                // Add AND only if there's already a condition
                $where .= " and po_date <= '" . $to_date . "'";
            }
        } else if ($opt2 == '102') {
            if (!empty($from_date)) {
                $where .= " and invoice_date >= '" . $from_date . "'";
            }
            if (!empty($to_date)) {
                $where .= " and invoice_date <= '" . $to_date . "'";
            }
        }

        if ($verified_team_mem != '') {
            $where .= " and team_mem = '" . $verified_team_mem . "'";
        }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns, );
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
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                // $value['s_no'] = $sno + 1;
                $SNO = $sno + 1;

                $value['s_no'] = '<span class="po_date  d-block" id="po">' . $SNO . '</span>';
                // $value['po_num'] = '<span class="po_date d-block" id="po">'. $value['po_num'].'</span>';

                $orgDate = $value['po_date'];
                $ins_unique_id = $value['ins_unique_id'];
                $status = $value['document_verification_status'];
                $po_date = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($po_date)) . '</span>';
                // $value['invoice_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['invoice_date'])) . '</span>';
                // $orgDate1 = $value['invoice_date'];
                $value['invoice_date'] = '<span class="po_date  d-block" id="po">' . $value['invoice_date'] . '</span>';
                $value['dc_date'] = '<span class="po_date d-block" id="po">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';

                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);
                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);

                $po_num = $value['po_num'];
                $value['po_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $po_num . '</span><br>' . $value['po_date'];
                $value['dc_date'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['dc_number'] . '</span><br>' . $value['dc_date'];

                $value['invoice_date'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'];

                $value['ledger_name'] = '<span style="font-weight:bold; text-transform: uppercase;">' . $value['ledger_name'] . '</span><br>' . $value['con_district'] . '<br>' . $value['con_state_name'];


                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status'] = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status'] = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status'] = "Verified";
                }

                // $document_verification_status = asort('document_verification_status');
                // $btn_update         = btn_update($folder_name, $value['ins_unique_id']);
                $btn_update = btn_update_7($folder_name, $value['consignee_unique_id'], $value['invoice_no'], $value['ins_unique_id']);
                $btn_verified_view = btn_view_signed_doc($folder_name, $value['consignee_unique_id'], $value['invoice_no'], $value['ins_unique_id'], $value['dc_number']);
                // $value['invoice_no'] = '<span class="po_date d-block" id="po">' . $value['invoice_no'] . '</span>';
                // $value['dc_number'] = '<span class="po_date d-block" id="po">' . $value['dc_number'] . '</span>';

                // if(in_array('5f88082b25ec031952', $action_ids)){
                //     $value['consignee_unique_id'] = $btn_update;
                // }else{

                //     $value['consignee_unique_id'] = '';
                // }

                // new change
                // if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))) {
                // if ($status == '2') {
                // if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){

                // print_r($value['stock_qty']==$value['invoice_qty']);die();
                $value['consignee_unique_id'] = $btn_verified_view;
                // } else {

                //     if (in_array('5f88082b25ec031952', $action_ids)) {
                //         $value['consignee_unique_id'] = $btn_update;

                //     }
                //     // else if(in_array('5f8808504271036738', $action_ids)){
                //     //    $value['form_main_unique_id'] = $btn_delete;
                //     // }
                //     else {
                //         $value['consignee_unique_id'] = '';
                //     }
                // }

                // }
                // if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
//     $value['unique_id'] = $btn_update.$btn_delete;                   
// }
// else
                // if (in_array('5f88082b25ec031952', $action_ids)) {
                //     $value['consignee_unique_id'] = $btn_update;
                // }
                // else if(in_array('5f8808504271036738', $action_ids)){
//     $value['unique_id'] = $btn_delete;
// }
                //     else {
                //         $value['consignee_unique_id'] = '';
                //     }
                // }


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
    //  case 'user_type_options':
    // $user_type          = $_POST['user_type'];
    // $user_type_options  = under_user_type($user_type);
    // $user_type_options  = select_option($user_type_options,"Select");
    // echo $user_type_options;
    // break;
    default:
        break;
}
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
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="20px" width="20px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_excel(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
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
                    $image_view_1 .= '<a href="javascript:print_view(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="20px" width="20px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_1 .= '<a href="javascript:print_pdf(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_1 .= '<a href="javascript:print_excel(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_1 .= '<a href="javascript:print(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
    return $image_view_1;
}
function image_view_2($folder_name = "", $unique_id = "", $snr_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $snr_file);
    $image_view_2 = '';
    if ($snr_file) {
        foreach ($file_names as $file_key => $snr_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_2 .= "&nbsp";
                } else {
                    $image_view_2 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $snr_file);
            if ($snr_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_2 .= '<a href="javascript:print_view(\'/' . $snr_file . '\')"><img src="uploads/' . $folder_name . '/' . $snr_file . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="20px" width="20px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_2 .= '<a href="javascript:print_pdf(\'/' . $snr_file . '\')"><img src="uploads/installation/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_2 .= '<a href="javascript:print_excel(\'/' . $snr_file . '\')"><img src="uploads/installation/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_2 .= '<a href="javascript:print(\'/' . $snr_file . '\')"><img src="uploads/installation/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
    return $image_view_2;
}

