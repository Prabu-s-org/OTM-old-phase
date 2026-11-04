<?php
require_once __DIR__ . '/../../../config/env.php';
// header('Content-Type: application/json');
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = "view_installation_followups";
$table_install             = "view_installation_followups1";
$table_sub             = "installation_details";
$table_sub_dc         = "dc_ir_doc_dispatch_details";
$table_inst_sublist = "installation_details_sublist";
// $table_inv="view_invoice_creation_main";
$table_inv="invoice_creation_main";


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

$exe_unique = unique_id($prefix);
switch ($action) {
    case 'createupdate':


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
        $ins_com_date              = $_POST['ins_com_date'];
        $in_charge              = $_POST['in_charge'];
        $engg_type              = $_POST['engg_type'];
        
        $gst                    = $_POST['gst'];
        $ttl_amount             = $_POST['ttl_amount'];
        $eng_remarks            = $_POST['eng_remarks'];
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
        // $dc_required          = $_POST['dc_required'];
// new change
        $installation_date         = $_POST['install_date'];
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




        $update_where = ''; // Initialize update condition

        // Check if both file names and their original names are present
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
                'installation_com_date'             => $ins_com_date,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                'eng_remarks'             => $eng_remarks,
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
                // 'dc_required'          => $dc_required,
                // 'unique_id'          => $unique_id,
                'snr_original_name'  => $snr_file_org_names,
                'po_form_unique_id'   => $form_main_unique_id,

                'installation_date'         => $installation_date,
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
                'installation_com_date'             => $ins_com_date,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                  // $eng_remarks            = $_POST['eng_remarks'];
                'eng_remarks'             => $eng_remarks,
                'documents_type'              => $documents_type,
                // 'documents_type1'              => $documents_type1,
                // 'documents_type2'              => $documents_type2,
                'dc_received_sts'             => $dc_received_sts,
                'dc_cus_signed_date'             => $dc_cus_signed_date,
                'ir_rec_status'              => $ir_rec_status,
                'ir_cus_signed_date'         => $ir_cus_signed_date,
                'snr_rec_status'             => $snr_rec_status,
                'snr_cus_signed_date'             => $snr_cus_signed_date,
                'dc_file'               => $file_names,
                'dc_original_name'     => $file_org_names,
                // 'dc_required'          => $dc_required,
                // 'ir_file'           => $ir_file_names,
                // 'ir_original_name'  => $ir_file_org_names,
                // 'snr_file'          => $snr_file_names,
                // 'form_unique_id'          => $form_unique_id,
                // 'snr_original_name'  => $snr_file_org_names,
                'po_form_unique_id'   => $form_main_unique_id,
                'installation_date'         => $installation_date,
                // 'installation_id'              => ins_no_get(),
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
                    'installation_com_date'             => $ins_com_date,
                    'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                    'eng_remarks'             => $eng_remarks,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    // 'dc_file'               => $dc_file_data,
                    // 'dc_original_name'     => $dc_file_name,
                    'ir_file'           => $ir_file_names,
                    'ir_original_name'  => $ir_file_org_names,
                    // 'snr_file'          => $snr_file_data,
                    // 'form_unique_id'          => $form_unique_id,
                    // 'snr_original_name'  => $snr_file_name,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'installation_date'         => $installation_date,
                    // 'installation_id'              => ins_no_get(),
    
                    'unique_id'              => unique_id($prefix)
                ];
       
        }
       
        if ($snr_file_names && $snr_file_org_names) {
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'installation_com_date'             => $ins_com_date,
                'eng_remarks'             => $eng_remarks,
                'engineer_name' => $engineer_name,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date'         => $installation_date,
                'unique_id' => unique_id($prefix),
            ];
        }
        if(($file_names) && ($file_org_names)&& ($ir_file_names) && ($ir_file_org_names)) {

            $columns            = [
                'po_num'        => $po_num,
                'po_auto_id'        => $po_unique_id,
                'po_date'           => $po_date,
                'invoice_auto_id'     => $invoice_auto_id,
                'invoice_no'   => $invoice_no,
                'invoice_date'   => $invoice_date,
                'consignee_unique_id'   => $consignee_unique_id,
               'engineer_name'              => $engineer_name,
                'installation_com_date'             => $ins_com_date,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                'eng_remarks'             => $eng_remarks,
                'documents_type'              => $documents_type,
                'documents_type1'              => $documents_type1,
                'documents_type2'              => $documents_type2,
                'dc_received_sts'             => $dc_received_sts,
                'dc_cus_signed_date'             => $dc_cus_signed_date,
                'ir_rec_status'              => $ir_rec_status,
                'ir_cus_signed_date'         => $ir_cus_signed_date,
                // 'snr_rec_status'             => $snr_rec_status,
                // 'snr_cus_signed_date'             => $snr_cus_signed_date,
                'dc_file'               => $file_names,
                'dc_original_name'     => $file_org_names,
                'ir_file'           => $ir_file_names,
                'ir_original_name'  => $ir_file_org_names,
                // 'form_unique_id'          => $form_unique_id,
                // 'snr_file'          => $snr_file_names,
                // 'unique_id'          => $unique_id,
                // 'snr_original_name'  => $snr_file_org_names,
                // 'installation_id'              => ins_no_get(),
                'po_form_unique_id'   => $form_main_unique_id,
                'installation_date'         => $installation_date,
                'unique_id'              => unique_id($prefix),
            ];
            
            
            
        }
        if ($file_names && $file_org_names && $snr_file_names && $snr_file_org_names && $ir_file_names && $ir_file_org_names) {
            // Update all file details including IR
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
               'engineer_name' => $engineer_name,
               'installation_com_date'             => $ins_com_date,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                'eng_remarks'             => $eng_remarks,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date'         => $installation_date,
                'unique_id' => unique_id($prefix),
            ];
        } 
        // Check if only DC and SNR file names and original names are present
        if ($file_names && $file_org_names && $snr_file_names && $snr_file_org_names) {
            // Update only DC and SNR file details
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
              'installation_com_date'             => $ins_com_date,
                'engg_type' => $engg_type,
                'in_charge' => $in_charge,
                        'gst_percent'  => $gst,
                'ttl_amnt'    => $ttl_amount,
                'eng_remarks'             => $eng_remarks,
                'engineer_name' => $engineer_name,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date'         => $installation_date,
                'unique_id' => unique_id($prefix),
            ];
        } 
  

// print_r($action_obj );die();
// if ($data[0]['count']) {
//     $msg = 'already';
// } else if (($data[0]['count'] == 0)) {

if($documents_type =='DC' && $documents_type1=='IR'){
    // echo "hi";
    $columns_new = [
        "dc_delivery_status" => 0,
    ];
    // consignee_unique_id
    // $update_where_1   = [
    //         "form_main_unique_id"     => $po_form_unique_id
    //     ];
    $update_where_new = 'po_form_unique_id="'.$form_main_unique_id.'" and consignee_unique_id="'. $consignee_unique_id .'" AND invoice_no="'.$invoice_no.'"';
    $action_obj_new = $pdo->update($table_sub, $columns_new, $update_where_new);
}

if($documents_type=='DC'){
    $columns_7 = [
        "installation_status"     => 5,
    ];
    // consignee_unique_id
    // $update_where_1   = [
    //         "form_main_unique_id"     => $po_form_unique_id
    //     ];
    $update_where_7 = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
    $action_obj_7     = $pdo->update($table_inv, $columns_7, $update_where_7);
    }
    if($documents_type=='DC' && $documents_type1=='IR'){
        $columns_ir = [
            "installation_status"     => 2,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_ir = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        $action_obj_par_ir     = $pdo->update($table_inv, $columns_ir, $update_where_ir);
        }
        // last eng call change 
        // if($documents_type=='DC' && $documents_type2=='SNR'){
        //     $columns_par = [
        //         "installation_status"     => 1,
        //     ];
            
        //     $update_where_par = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        //     $action_obj_par     = $pdo->update($table_inv, $columns_par, $update_where_par);
        //     }

            if($documents_type=='DC' && $documents_type2=='SNR'){
                $columns_par = [
                    "installation_status"     => 1,
                ];
                
                $update_where_par = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
                $action_obj_par     = $pdo->update($table_inv, $columns_par, $update_where_par);
                }
                // PRINT_R($action_obj_par);
            // end

        if($documents_type1=='IR'){
            $columns_8 = [
                "installation_status"     => 2,
            ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_8 = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        $action_obj_8     = $pdo->update($table_inv, $columns_8, $update_where_8);
    }

    if($dc_required=='on' && $documents_type=='DC'){
        $columns_9 = [
            "installation_status"     => 2,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_9 = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        $action_obj_9     = $pdo->update($table_inv, $columns_9, $update_where_9);
    }


$table_details = [
    $table_sub,
    [
        'COUNT(invoice_no) AS count'
    ]
    
];
$select_where = 'is_delete = 0 AND invoice_no ="' . $invoice_no . '"';

$action_obj = $pdo->select($table_details, $select_where);

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


        // if($data[0]['count'] != 0) {
        //     // echo "demotest";
     if ($unique_id) {
                unset($columns['unique_id']);
                $update_where   = [
                    'unique_id'     => $unique_id
                ];
                // $update_where =  'unique_id ="'.$unique_id.'"';
                $action_obj     = $pdo->update($table_sub, $columns, $update_where);
                //  print_r( $action_obj);
                // Update Ends
            }
        else {
 
        // Update Begins
        
            // Insert Begins
            $action_obj     = $pdo->insert($table_sub, $columns);
        //  print_r( $action_obj);
            // Insert Ends
        }
        // print_r( $action_obj); die();
        
        // print_r( $action_obj );die();
        // check already Exist Or not
        // if ($unique_id) {

        //     unset($columns['unique_id']);


        //     // $update_where   = [
        //     //     "unique_id"     => $unique_id
        //     // ];
        //     $update_where   = 'unique_id="'.$unique_id.'"';

        //     $action_obj     = $pdo->update($table_sub, $columns, $update_where);

        //     // Update Ends
        // } else {
        //     // Insert Begins

        //     $action_obj     = $pdo->insert($table_sub, $columns);
        //     // Insert Ends
        // }
        // print_r($action_obj);
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

    
        case 'demo':
        
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
            $ins_com_date              = $_POST['ins_com_date'];
           
            $eng_remarks            = $_POST['eng_remarks'];
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
            $installation_date         = $_POST['install_date'];
    
            // $unique_id =  unique_id($prefix);
            
            
            // $ins = ins_no_get();
            
            // print_r($ins);die();
    
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
                'installation_com_date'             => $ins_com_date,
                // 'eng_remarks'             => $eng_remarks,
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
                'installation_com_date'             => $ins_com_date,
                // 'eng_remarks'             => $eng_remarks,
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
                    'installation_com_date'             => $ins_com_date,
                    // 'eng_remarks'             => $eng_remarks,
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
            }
           
         if (($file_names) && ($file_org_names) && ($ir_file_names) && ($ir_file_org_names)) {
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
                    'installation_com_date'             => $ins_com_date,
                    // 'eng_remarks'             => $eng_remarks,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    'ir_rec_status'              => $ir_rec_status,
                    'ir_cus_signed_date'         => $ir_cus_signed_date,
                    // 'snr_rec_status'             => $snr_rec_status,
                    // 'snr_cus_signed_date'             => $snr_cus_signed_date,
                    'dc_file'               => $file_names,
                    'dc_original_name'     => $file_org_names,
                    'ir_file'           => $ir_file_names,
                    'ir_original_name'  => $ir_file_org_names,
                    // 'snr_file'          => $snr_file_data,
                    'form_unique_id'          => $form_unique_id,
                    // 'snr_original_name'  => $snr_file_name,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'installation_id'              => ins_no_get(),
    
                    'unique_id'              => unique_id($prefix)
                ];
        }

        // }
     
        if (($file_names) && ($file_org_names) && ($snr_file_names) && ($snr_file_org_names)) {
            // if (($snr_file_names) && ($snr_file_org_names)) {

                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    'installation_com_date'             => $ins_com_date,
                    // 'eng_remarks'             => $eng_remarks,
                    'documents_type'              => $documents_type,
                    'documents_type1'              => $documents_type1,
                    'documents_type2'              => $documents_type2,
                    'dc_received_sts'             => $dc_received_sts,
                    'dc_cus_signed_date'             => $dc_cus_signed_date,
                    // 'ir_rec_status'              => $ir_rec_status,
                    // 'ir_cus_signed_date'         => $ir_cus_signed_date,
                    'snr_rec_status'             => $snr_rec_status,
                    'snr_cus_signed_date'             => $snr_cus_signed_date,
                    'dc_file'               => $file_names,
                    'dc_original_name'     => $file_org_names,
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
            if ($file_names && $file_org_names && $snr_file_names && $snr_file_org_names && $ir_file_names && $ir_file_org_names) {
                // Update all file details including IR
                $columns            = [
                    'po_num'        => $po_num,
                    'po_auto_id'        => $po_unique_id,
                    'po_date'           => $po_date,
                    'invoice_auto_id'     => $invoice_auto_id,
                    'invoice_no'   => $invoice_no,
                    'invoice_date'   => $invoice_date,
                    'consignee_unique_id'   => $consignee_unique_id,
                    'engineer_name'              => $engineer_name,
                    'installation_com_date'             => $ins_com_date,
                    // 'eng_remarks'             => $eng_remarks,
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
                    'snr_file'          => $snr_file_data,
                    'form_unique_id'          => $form_unique_id,
                    'snr_original_name'  => $snr_file_name,
                    'po_form_unique_id'   => $form_main_unique_id,
                    'installation_id'              => ins_no_get(),
    
                    'unique_id'              => unique_id($prefix)
                ];
            } 
         
            
         
                
             
           
            // }
            // print_r($columns);die();
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
                // print_r($result_values);
    
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
                            // print_r($action_obj);
    
                        }
                        // if($sub_values[0]['documents_type2'] == "SNR" && $sub_values[0]['snr_rec_status'] == 1){
                        //     $action_obj     = $pdo->insert($table_inst_sublist,$columns);
                        // }
                        else {
                            // print_r('hi');die();
                            $action_obj     = $pdo->insert($table_inst_sublist, $columns);
                        }
                    }
                    // print_r($action_obj);
    
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
    



  // installa sub
  case 'ins_sub_add':
    // print_r('hi');die();
//   echo  $dc_required          = $_POST['dc_required'];
//   echo  $ins_reqired          = $_POST['ins_reqired'];
  
    $po_num          = $_POST['po_num'];
   $po_auto_id          = $_POST['po_auto_id'];
    $form_main_unique_id          = $_POST['po_form_unique_id'];
    $po_date              = $_POST['po_date'];
    $invoice_auto_id = $_POST['invoice_auto_id'];
    $invoice_no            = $_POST['invoice_no'];
    // $no_of_consignee     = $_POST['no_of_consignee'];
    $invoice_date        = $_POST['invoice_date'];
    $consignee_unique_id            = $_POST['consignee_unique_id'];
    $engineer_name              = $_POST['engineer_name'];
    $installation_com_date              = $_POST['installation_com_date'];
    $eng_remarks              = $_POST['eng_remarks'];
    $unique_id            = $_POST['unique_id'];
    $documents_type              = $_POST['documents_type'];
    $documents_type1              = $_POST['documents_type1'];
    $documents_type2              = $_POST['documents_type2'];
    $dc_received_sts             = $_POST['dc_received_sts'];
    $dc_cus_signed_date       = $_POST['dc_cus_signed_date'];
    $ir_rec_status            = $_POST['ir_rec_status'];
    $ir_cus_signed_date          = $_POST['ir_cus_signed_date'];
    $snr_rec_status              = $_POST['snr_rec_status'];
    $snr_cus_signed_date             = $_POST['snr_cus_signed_date'];
    $dc_file_data             = $_POST['dc_file'];
    $dc_file_name             = $_POST['dc_original_name'];
    $ir_file_data             = $_POST['ir_file'];
    $ir_file_name             = $_POST['ir_original_name'];
    $snr_file_data             = $_POST['snr_file'];
    $snr_file_name             = $_POST['snr_original_name'];
    // print_r($dc_file_data.','.$dc_file_name);die();
    // $wheres = "is_delete = 0 order by id DESC";
    // $table_1      =  "installation_details";
    // $columns_3    = [
    //     'max(unique_id) as unique_id',

    // ];
    // $tables   = [
    //     $table_1,
    //     $columns_3
    // ];
    // // $order = "id Desc";
    // $result_values_12  = $pdo->select($tables, $wheres);
    // // print_r($result_values_12);die();
    // $datada       = $result_values_12->data;

    // // if($form_unique_ids == ''){
    // $form_unique_id            = $datada[0]['unique_id'];
    // }
    // print_r($form_unique_id);die();

    // 1st image open

  

    $update_where          = '';
  
   
    // if (($file_names) && ($file_org_names)) {

        $columns            = [
            'po_num'        => $po_num,
            'po_auto_id'        => $po_auto_id,
            'po_date'           => $po_date,
            'invoice_auto_id'     => $invoice_auto_id,
            'invoice_no'   => $invoice_no,
            'invoice_date'   => $invoice_date,
            'consignee_unique_id'   => $consignee_unique_id,
            'engineer_name'              => $engineer_name,
            'installation_com_date'             => $installation_com_date,
            'eng_remarks'             => $eng_remarks,
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
            'ir_file'           => $ir_file_data,
            'ir_original_name'  => $ir_file_name,
            'snr_file'          => $snr_file_data,
            'form_unique_id'          => $unique_id,
            'snr_original_name'  => $snr_file_name,
            'po_form_unique_id'   => $form_main_unique_id,
            'installation_id'              => ins_no_get(),
            'unique_id'              => unique_id($prefix)
        ];
    // }
    
    // check already Exist Or not
    if ($unique_id) {

        $table_12 = 'installation_details_sublist';
        // $where123      = [
        //     "form_unique_id" => $form_unique_id
        // ];
        $where123      = 'form_unique_id ="'.$unique_id.'" AND is_delete=0';
        // ];
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
        // print_r($result_values);

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
                // print_r($action_obj);

                // Update Ends
            }
            if ($count_of_values != 0) {
                if ($sub_values[0]['documents_type1'] == 0 && $sub_values[0]['documents_type2'] == 0) {
                    // print_r('hi');die();
                    unset($columns['form_unique_id']);
                    unset($columns['unique_id']);
                    unset($columns['installation_id']);

                    $update_where   = 'form_unique_id="' . $unique_id  . '" AND is_delete=0';

                    $action_obj     = $pdo->update($table_inst_sublist, $columns, $update_where);
                    // print_r($action_obj);die();

                }
               
                else {
                    // print_r('hi');die();
                    $action_obj     = $pdo->insert($table_inst_sublist, $columns);
                }
            }
            // print_r($action_obj);die();
// 
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


    case 'datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt    = $_POST['opt'];
        $limit         = $length;
        $installation_status    =  $_POST['installation_status'];
        $con_district = $_POST['con_district'];
        
         
         $eng_id = $_SESSION['engineer_id'];
         
         
         if($eng_id){
            
              $eng_id = $_SESSION['engineer_id'];

         }
         
         elseif($eng_id){
            
             $eng_id = $_SESSION["user_id"];
         }
         
         else{
             
              $eng_id = $_SESSION["user_id"]; 
              
               
         }
         
         
         
         
         

        $data        = [];


        if ($length == '-1') {
            $limit  = "";
        }

        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
           
           "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",

           
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = view_installation_followups.ledger_name group by department_creation_sublist.unique_id) AS ledger_name",

            " con_district",
            "con_address",
            "invoice_no",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "invoice_value",
            "po_file_name",
            "dc_file_name",
            "ir_file_name",
            "file_invoice",
           "(select staff_name from view_login WHERE view_login.unique_id=$table.engineer_name) AS engineer_name",

            "installation_status",
            "delivery_due_dates",

            "consignee_unique_id",
            "form_main_unique_id",
            "con_pincode",
            "dc_required",
            
          
           "invoice_auto_id",
           "(SELECT delivery_due_days FROM invoice_creation WHERE invoice_creation.invoice_no = view_installation_followups.invoice_no and invoice_creation.is_delete='0'  group by invoice_no) AS delivery_due_days",
           "bulk_eng_name"

            
        ];
        $table_details  = [
            $table,
            $columns
        ];
       
      

// if ($installation_status == '') {
    if ($opt == '4') {
        // Filter by PO Date
        $from_date_converted = date('d-m-Y', strtotime($from_date));
        $to_date_converted = date('d-m-Y', strtotime($to_date));

        $where = " po_date >= '" . $from_date . "' 
                  AND po_date <=  '" . $to_date . "'";
        
        if ($con_district != '') {
            $where .= " AND con_district_unique_id = '" . $con_district . "'";
        }
    } else if ($opt == '5') {
        // Filter by Invoice Date
        $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";
        
        if ($con_district != '') {
            $where .= " AND con_district_unique_id = '" . $con_district . "'";
        }
    }
// } 
if ($installation_status) {
    $where .= "  AND installation_status = '" . $installation_status . "'";

}

// else {
//     if ($opt == '4') {
//         // Filter by PO Date and Installation Status
//         $from_date_converted = date('d-m-Y', strtotime($from_date));
//         $to_date_converted = date('d-m-Y', strtotime($to_date));

//         $where = "po_date >= " . $from_date . " 
//                   AND po_date <=  " . $to_date . " 
//                   AND installation_status = '" . $installation_status . "'";
        
//         if ($con_district != '') {
//             $where .= " AND con_district_unique_id = '" . $con_district . "'";
//         }
//     } else if ($opt == '5') {
//         // Filter by Invoice Date and Installation Status
//         $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' 
//                   AND installation_status = '" . $installation_status . "'";
        
//         if ($con_district != '') {
//             $where .= " AND con_district_unique_id = '" . $con_district . "'";
//         }
//     }
// }





            

        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by       = datatable_sorting_ins1($order_column, $order_dir, $columns);
      $order_by = "";
     
// $order_by = "CASE 
// WHEN installation_status = '3' THEN 0 
// WHEN installation_status = '0' THEN 1
// WHEN installation_status = '4' THEN 2
// WHEN installation_status = '5' THEN 3
// WHEN installation_status = '1' THEN 4
// WHEN installation_status = '2' THEN 5
// ELSE 6
// END $order_dir";

        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";


        // Datatable Searching
        $search         = datatable_searching($search, $columns);
        // if($installation_status != ''){
        //     $where = "installation_status LIKE '%".$installation_status."%'";
        // }

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }
// Apply search only if filter values are present
// if ($search && $where) {
//     $where .= " AND " . $search;
// }
        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);die();
        $total_records  = total_records();
        
        
        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns1        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        // print_r($select_where);
        $table_details1   = [
            $table_user,
            $columns1
        ];

        $table_users  = $pdo->select($table_details1, $select_where);
        
        // print_r($table_users);die();

            $table_users      = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                // $value['po_unique_id'] = $value['po_num'];
                $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];
              
              
                if($value['installation_status'] == 0){
                    $value['installation_status'] = 'Pending';
                }
                else if($value['installation_status'] == 5){
                    $value['installation_status'] = 'Partial completed';
                }
                else if($value['installation_status'] == 2){
                  $value['installation_status'] = 'Completed';
                }
                else if($value['installation_status'] == 3){
                    $value['installation_status'] = "<span style='color: red;'>Rejected</span>";

                  }
                  else if($value['installation_status'] == 4){
                    $value['installation_status'] = "Eng Assigned";
                  }
                  else if($value['installation_status'] == 1){
                    $value['installation_status'] = "SNR";
                  }
               
                $value['invoice_date']  = '<span class="po_date">'.$value['invoice_date'] .'</span>';

        //         // old changes
        //         // $delivery_due_dates = $value['delivery_due_dates'];
               
        //         // $value['po_date']  = '<span class="po_date">'.$value['po_date'] .'</span>';
        //         // $po_date = $value['po_date'];
        //         // $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
        //         // $poDate->modify('+' . $delivery_due_dates . ' days');
        //         // $resultDate = $poDate->format('d-m-Y');
        //         // $value['delivery_due_dates']=   "<span class='po_date'>$resultDate</span>";
        //      // end

                // new changes

                // $delivery_due_dates = $value['delivery_due_dates'];
                // if ($value['delivery_due_dates'] =="") {
                //      $delivery_due_dates = $value['delivery_due_days'];
                   
                // } else {
                //     $delivery_due_dates = $value['delivery_due_dates'];
                // }
                
                

                // $value['po_date']  = '<span class="po_date">'.$value['po_date'] .'</span>';

                
                // $po_date = $value['po_date'];
                // $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
                // $poDate->modify('+' . $delivery_due_dates . ' days');

                // $resultDate = $poDate->format('d-m-Y');
              
                // $value['delivery_due_dates']=   "<span class='po_date'>$resultDate</span>";
                $delivery_due_dates = empty($value['delivery_due_dates']) 
        ? $value['delivery_due_days'] 
        : $value['delivery_due_dates'];

    // Format 'po_date' with a span
    $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

    // Parse 'po_date' and calculate the result date
    $po_date = strip_tags($value['po_date']); // Remove span tags
    $poDate = DateTime::createFromFormat('Y-m-d', $po_date);

    // Proceed only if 'po_date' and 'delivery_due_dates' are valid
    if ($poDate && $delivery_due_dates) {
        $poDate->modify('+' . $delivery_due_dates . ' days');
        $resultDate = $poDate->format('d-m-Y');

        // Update 'delivery_due_dates' with the calculated date
        $value['delivery_due_dates'] = "<span class='po_date'>$resultDate</span>";
    }

        //   // end


                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['po_file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['po_file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $po_file = $value['file_name'];
                $file2 =  $value['dc_file_name'];
                //   $file2 = "uploads/po_form/po_attach/pdf.png";

                $value['ir_file_name']     =  image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice']     =  image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                $d = $value['invoice_no'];
                
                 $where_2 = "invoice_no = '" . $d . "' AND is_delete='0' ";
                //  AND " . $value['installation_status'] . " = 3 ORDER BY " . $value['installation_status'] . " ASC

                // $where_2 = "invoice_no = '" . $d . "'  ORDER BY installation_status='0' DESC";
                // $where_2 = "invoice_no = '" . $d . "' ORDER BY " . $value['installation_status'] . "DESC";
                // and dc_received_sts!='' and ir_rec_status!='' and snr_rec_status!=''
// and dc_received_sts=1 and ir_rec_status=1 and snr_rec_status=1
                $table_1      =  "installation_details";

                $columns_2    = [
                    'COUNT(invoice_no) AS count',
                    "documents_type",
                    "documents_type1",
                    "documents_type2",
                    "dc_required"
                ];

                $table_details_1   = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12  = $pdo->select($table_details_1, $where_2);
                // print_r($result_values_12);
                $data_st       = $result_values_12->data;
               
                $invoice_no= $value['invoice_no'];
           
               

                $btn_view         = btn_view_ins($folder_name,$value['consignee_unique_id'],$value['invoice_no']); 

              
                $btn_update         = btn_update1($folder_name, $value['consignee_unique_id'],$invoice_no);

                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))){
                    if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){

                       // print_r($value['stock_qty']==$value['invoice_qty']);die();
                       $value['consignee_unique_id']     =  $btn_view;
                  } 
                   else{
                   // $value['form_main_unique_id']='<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
               
                       // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                       //     $value['unique_id'] = $btn_update.$btn_delete;                   
                       // }
                       if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['consignee_unique_id'] = $btn_update;
                    }
                       // else if(in_array('5f8808504271036738', $action_ids)){
                       //    $value['form_main_unique_id'] = $btn_delete;
                       // }
                       else{
                        $value['consignee_unique_id'] = '';
                       }
                     }
                   
                 }
                 if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                   
                   // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                   //     $value['unique_id'] = $btn_update.$btn_delete;                   
                   // }
                   // else
                    if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['consignee_unique_id']     =  $btn_update;
                   }
                   // else if(in_array('5f8808504271036738', $action_ids)){
                   //     $value['unique_id'] = $btn_delete;
                   // }
                   else{
                    $value['consignee_unique_id'] = '';
                   }
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

// eng call update 
case 'eng_call_add_update':
    $engg_type          = $_POST['engg_type'];
    $engineer_name          = $_POST['engineer_name'];
    $date          = $_POST['date'];
    $invoice_no    = $_POST['invoice_no'];
    $po_form_unique_id          = $_POST['po_form_unique_id'];
    $consignee_unique_id    = $_POST['consignee_unique_id'];
    $in_charge          = $_POST['in_charge'];
    $gst                = $_POST['gst'];
    $ttl_amount  = $_POST['ttl_amnt'];
    $engineer_name_inv          = $_POST['engineer_name_inv'];
    $installation_status          = $_POST['installation_status'];
    
// print_r($file_names);die();
    $update_where       = '';
    // print_r( $m_unique_id );
       
        // }
        if($engineer_name_inv==""  ||  $installation_status=='3'){
            // || $engineer_name!="" 
        $columns_call = [
            "installation_status"     => 4,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];

        $update_where_call = 'form_main_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';

        $action_obj_call     = $pdo->update($table_inv, $columns_call, $update_where_call);

        }
        // print_r($action_obj_call);
    // Update Begins
    if($invoice_no) {

        // unset( $columns['unique_id'] );

        // $update_where   = [
        //     'po_unique_id'     => $demo
        // ];
        $columns_update_install = [
            // "engineer_name"     => $engineer_name,
            // 'installation_com_date'     => $in_charge,
            // 'eng_remarks'     => $eng_remarks,
            "engg_type"     => $engg_type,
            'engineer_name'     => $engineer_name,
            'date'     => $date,
            'in_charge'     => $in_charge,
           
         ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];

        $update_where_ins = 'po_form_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';

        $action_obj_ins     = $pdo->update($table_sub,$columns_update_install, $update_where_ins);
        
        
        // print_r($action_obj_ins);


        $columns_update_install_sub = [
            // "engineer_name"     => $engineer_name,
            // 'installation_com_date'     => $ins_com_date,
            // 'eng_remarks'     => $eng_remarks,
            "engg_type"     => $engg_type,
            'engineer_name'     => $engineer_name,
            'date'     => $date,
            'in_charge'     => $in_charge,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];

        $update_where_ins_sub = 'po_form_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';

        $action_obj_ins_sub     = $pdo->update($table_inst_sublist,$columns_update_install_sub, $update_where_ins_sub);


       if($engg_type == 'own-engineer'){
           
           $eng_status = '1';
       }
        elseif($engg_type == 'outsource-vendor'){
           
           $eng_status = '2';
       }

        // Update Ends
    }
    $columns            = [
        // 'engineer_name'           => $engineer_name,
        // 'installation_com_date'     => $ins_com_date,
        // 'eng_remarks'     => $eng_remarks,
        "engg_type"     => $eng_status,
            'engineer_name'     => $engineer_name,
            'date'     => $date,
            'in_charge'     => $in_charge,
             "vendor_bulk_rate"  => $in_charge,
            "vendor_bulk_gst"  => $gst,
            "bulk_total_amount" => $ttl_amount,
            "bulk_eng_type"   => $engg_type,
            "bulk_eng_name"   => $engineer_name
        ];
    $update_where  = 'invoice_no ="'.$invoice_no.'"';

    $action_obj     = $pdo->update($table_inv, $columns, $update_where);
    // print_r($action_obj);die();
    
    if ($action_obj->status) {
        $status     = $action_obj->status;
        $data       = $action_obj->data;
        $error      = '';
        $sql        = $action_obj->sql;

        if($invoice_no) {
            $msg        = 'update';
        } else {
            $msg        = 'create';
        }
    } else {
        $status     = $action_obj->status;
        $data       = $action_obj->data;
        $error      = $action_obj->error;
        $sql        = $action_obj->sql;
        $msg        = 'error';
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


        // dc_id dispatch details get
    case 'dc_ir_dispatch_datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit         = $length;
        $dc_delivery_status  = $_POST['dc_delivery_status'];
        $con_district = $_POST['con_district'];
        $data        = [];


        if ($length == '-1') {
            $limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
           
            "po_num",
          
            // "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = view_installation_followups1.ledger_name) AS ledger_name",

           
            // "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups1.con_district) AS con_district",
           " (SELECT ledger_name 
            FROM department_creation_sublist 
            WHERE department_creation_sublist.unique_id = view_installation_followups1.ledger_name 
            LIMIT 1) AS ledger_name",
           
           "(SELECT district_name 
            FROM district_creation 
            WHERE district_creation.unique_id = view_installation_followups1.con_district 
            LIMIT 1) AS con_district",
           
          
           
            "con_address",
            "invoice_no",
          
             "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
             "invoice_value",
            // "(select staff_name from view_login WHERE view_login.unique_id=$table_install.engineer_name) AS engineer_name",
            "(SELECT staff_name 
            FROM view_login 
            WHERE view_login.unique_id = view_installation_followups1.engineer_name 
            LIMIT 1) AS engineer_name",
            " (SELECT installation_com_date
 FROM installation_details 
 WHERE invoice_no = view_installation_followups1.invoice_no 
 AND is_delete = 0
 LIMIT 1) AS installation_com_date",

            
            "dc_delivery_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "con_pincode",
            "po_unique_id",
            "documents_type",
            "documents_type1",
            "documents_type2",
            "invoice_auto_id",
            
            

        ];
        $table_details  = [
            $table_install,
            $columns
        ];
        
        $where = "documents_type!='0'";


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



if ($dc_delivery_status == '') {
    if ($opt1 == '9') {
        // Filter by PO Date
        $from_date_converted = date('d-m-Y', strtotime($from_date));
        $to_date_converted = date('d-m-Y', strtotime($to_date));

        $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') 
                  AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
        
        if ($con_district != '') {
            $where .= " AND con_district = '" . $con_district . "'";
        }
    } else if ($opt1 == '10') {
        // Filter by Invoice Date
        $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";
        
        if ($con_district != '') {
            $where .= " AND con_district = '" . $con_district . "'";
        }
    }
} else {
    if ($opt1 == '9') {
        // Filter by PO Date and Installation Status
        $from_date_converted = date('d-m-Y', strtotime($from_date));
        $to_date_converted = date('d-m-Y', strtotime($to_date));

        $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') 
                  AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') 
                  AND dc_delivery_status = '" . $dc_delivery_status . "'";
        
        if ($con_district != '') {
            $where .= " AND con_district = '" . $con_district . "'";
        }
    } else if ($opt1 == '10') {
        // Filter by Invoice Date and Installation Status
        $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' 
                  AND dc_delivery_status = '" . $dc_delivery_status . "'";
        
        if ($con_district != '') {
            $where .= " AND con_district = '" . $con_district . "'";
        }
    }
}


        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
       
        $order_by       = datatable_sorting_ins2($order_column, $order_dir, $columns);
        $order_by = " 
  CASE 
    WHEN dc_delivery_status = '0' THEN 1
    WHEN dc_delivery_status = '5' THEN 2
    WHEN dc_delivery_status = '1' THEN 3
    WHEN dc_delivery_status = '3' THEN 4
    ELSE 5
  END $order_dir
";
       
        $search         = datatable_searching($search, $columns);
       
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records  = total_records();
        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }
        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                // $value['po_unique_id'] = $value['po_num'];
                $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];

                $dc_delivery_status=$value['dc_delivery_status'];
                

                $dc_delivery_status=$value['dc_delivery_status'];
                if($value['dc_delivery_status'] == 0){
                    $value['dc_delivery_status'] = 'Pending';
                }
                else if($value['dc_delivery_status'] == 5){
                    $value['dc_delivery_status'] = 'partial Completed';
                }
                else if($value['dc_delivery_status'] == 1){
                    $value['dc_delivery_status'] = 'SNR';
                }
                else if($value['dc_delivery_status'] == 3){
                    $value['dc_delivery_status'] = 'Completed';
                }
               
              
                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                $orgDate1 = $value['installation_com_date'];
                if(  $orgDate1!=''){
                $value['installation_com_date'] = date("d-m-Y", strtotime($orgDate1));
                }
                else{
                    $value['installation_com_date']='';
                }
                $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' ";
               

                $table_1      =  "dc_ir_doc_dispatch_details";

                $columns_2    = [
                    'COUNT(invoice_no) AS count',
                    "dc_dispatch_mode",
                    "ir_dispatch_mode",
                    "snr_dispatch_mode",
                    "(select dc_required from installation_details where po_form_unique_id=$table_1.po_form_unique_id )as dc_required",
                ];

                $table_details_1   = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12  = $pdo->select($table_details_1, $where_2);
                $data_st       = $result_values_12->data;

                 $invoice_no=  $value['invoice_no'];
                
               


                $btn_update          = btn_update_install($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                $btn_view          = btn_view_ins_dc_ir($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($dc_delivery_status=='3') {
                       $value['consignee_unique_id']     =  $btn_view;
                  } 
                   else{
                   
                       if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['consignee_unique_id'] = $btn_update;
                    }
                       
                       else{
                        $value['consignee_unique_id'] = '';
                       }
                     }
                   
                 }
                 if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                   
                 
                    if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['consignee_unique_id']     =  $btn_update;
                   }
                  
                   else{
                    $value['consignee_unique_id'] = '';
                   }
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

        // 2tab

    case 'dc_ir_add_update':

        $dc_required          = $_POST['dc_required   '];
        $po_form_unique_id          = $_POST['po_form_unique_id'];
        $po_num                     = $_POST['po_num'];
        $po_auto_id                 = $_POST['po_auto_id'];
        $po_date                    = $_POST['po_date'];
        $consignee_id               = $_POST['consignee_id'];
        $invoice_auto_id            = $_POST['invoice_auto_id'];
        $dc_required                 = $_POST['dc_required'];
        $invoice_no                 = $_POST['invoice_no'];
        $invoice_date            = $_POST['invoice_date'];
        $dc_dispatch_mode        = $_POST['dc_dispatch_mode'];
        $dc_pod_no              = $_POST['dc_pod_no'];
        $dc_pod_date            = $_POST['dc_pod_date'];
        $ir_dispatch_mode              = $_POST['ir_dispatch_mode'];
        $name_of_courier             = $_POST['name_of_courier'];
        $ins_name_of_courier       = $_POST['ins_name_of_courier'];
        $ir_pod_no             = $_POST['ir_pod_no'];
        $ir_pod_date       = $_POST['ir_pod_date'];
        $snr_dispatch_mode             = $_POST['snr_dispatch_mode'];
        $snr_name_courier       = $_POST['snr_name_courier'];
        $snr_pod_no             = $_POST['snr_pod_no'];
        $snr_pod_date            = $_POST['snr_pod_date'];

        $unique_id             = $_POST['unique_id'];
        $without_snr            = $_POST['without_snr'];


        $update_where          = '';
        // print_r( 'hii'.$con_con_address );
        $columns            = [
            'po_form_unique_id'        => $po_form_unique_id,
            'po_num'        => $po_num,
            'po_auto_id'           => $po_auto_id,
            'po_date'     => $po_date,
            'consignee_unique_id'   => $consignee_id,
            'invoice_auto_id'   => $invoice_auto_id,
            'invoice_no'             => $invoice_no,
            'invoice_date'              => $invoice_date,
            'dc_dispatch_mode'             => $dc_dispatch_mode,
            'name_of_courier'             => $name_of_courier,
            'dc_pod_no'             => $dc_pod_no,
            'dc_pod_date'              => $dc_pod_date,
            'ir_dispatch_mode'             => $ir_dispatch_mode,
            'ins_name_of_courier'             => $ins_name_of_courier,
            'ir_pod_no'             => $ir_pod_no,
            'ir_pod_date'             => $ir_pod_date,
            'snr_dispatch_mode'             => $snr_dispatch_mode,
            'snr_name_courier'             => $snr_name_courier,
            'snr_pod_no'             => $snr_pod_no,
            'snr_pod_date'             => $snr_pod_date,
            // 'dc_delivery_status'             => 1,
            'unique_id'              => unique_id($prefix)
        ];
        $table_details = [
            $table_sub_dc,
            [
                'COUNT(invoice_no) AS count'
            ]
        ];
        $select_where = 'is_delete = 0 AND invoice_no ="'.$invoice_no.'"';
        // print_r($select_where);
        $action_obj = $pdo->select($table_details, $select_where);
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
if($dc_dispatch_mode!='' && $ir_dispatch_mode!='' && $snr_dispatch_mode=='' ){
    // echo "h";
    $columns_2 = [
        "dc_delivery_status" => 3,
        "without_snr"=> $without_snr
    ];
   
    $update_where_2 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
    $action_obj_2 = $pdo->update($table_sub, $columns_2, $update_where_2);
}
if($dc_dispatch_mode!='' && $snr_dispatch_mode=='' &&  $ir_dispatch_mode=='' && $dc_required!='on'){
    
    $columns_dc = [
        "dc_delivery_status" => 5,
    ];
    $update_where_dc = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
    $action_obj_6 = $pdo->update($table_sub, $columns_dc, $update_where_dc);
}

  if($dc_dispatch_mode!='' && $ir_dispatch_mode!='' && $snr_dispatch_mode!=''){

    $columns_new = [
        "dc_delivery_status" => 3,
    ];
    $update_where_new = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
    $action_obj_new = $pdo->update($table_sub, $columns_new, $update_where_new);
}
if($dc_dispatch_mode!='' && $dc_required=='on'){
    $columns_3 = [
        "dc_delivery_status" => 3,
    ];
    $update_where_6 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
    $action_obj_6 = $pdo->update($table_sub, $columns_3, $update_where_6);
}
if($dc_dispatch_mode!='' && $snr_dispatch_mode!='' && $ir_dispatch_mode==''){
    $columns_7 = [
        "dc_delivery_status" => 1,
    ];
    $update_where_7 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id.'" AND invoice_no="' . $invoice_no . '"';
    $action_obj_7 = $pdo->update($table_sub, $columns_7, $update_where_7);
}

$table_install_1tab="installation_details";
if($without_snr=='on'){
   
    $columns_ins1tab = [
        "documents_type2" => 0,
        "snr_rec_status" => "",
        "snr_cus_signed_date" => "",
        "snr_file" => "",
        "snr_original_name" => "",
       

    ];
    
    $update_where_1tab = 'po_form_unique_id="'.$po_form_unique_id.'" and consignee_unique_id="'.$consignee_id.'" AND invoice_no="'.$invoice_no.'"';
    $action_obj_1tab = $pdo->update($table_install_1tab, $columns_ins1tab, $update_where_1tab);
   

    $table_install_2tab="installation_details_sublist";
    $columns_ins2tab = [
        "is_delete" => "1",
    ];
    
    $update_where_2tab = 'po_form_unique_id="'.$po_form_unique_id.'" and consignee_unique_id="'.$consignee_id.'" AND invoice_no="'.$invoice_no.'" AND documents_type1!="IR"';
    $action_obj_2tab = $pdo->update($table_install_2tab, $columns_ins2tab, $update_where_2tab);

   //  print_r($action_obj_2tab);
    $columns_ins21tab = [
        "snr_rec_status" => "",
        "snr_cus_signed_date" => "",
        "snr_file" =>"",
        "snr_original_name" => "",
        "documents_type2"=> "0",
    ];
    $update_where_21tab = 'po_form_unique_id="'.$po_form_unique_id.'" and consignee_unique_id="'.$consignee_id.'" AND invoice_no="'.$invoice_no.'" AND documents_type1="IR"';
    $action_obj_21tab = $pdo->update($table_install_2tab, $columns_ins21tab, $update_where_21tab);
   
}
        if($data[0]['count'] != 0) {
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where   = [
                    'unique_id'     => $unique_id
                ];
                // $update_where =  'unique_id ="'.$unique_id.'"';
                $action_obj     = $pdo->update($table_sub_dc, $columns, $update_where);
                // Update Ends
            }
        }else if(($data[0]['count']== 0)) {
 
        // Update Begins
        
            // Insert Begins
            $action_obj     = $pdo->insert($table_sub_dc, $columns);
            // Insert Ends
        }
        // Update Begins
        // if ($unique_id) {

        //     unset($columns['unique_id']);

        //     $update_where   = [
        //         "unique_id"     => $unique_id
        //     ];

        //     $action_obj     = $pdo->update($table_sub_dc, $columns, $update_where);

        //     // Update Ends
        // } else {
        //     // Insert Begins

        //     $action_obj     = $pdo->insert($table_sub_dc, $columns);
        //     // Insert Ends
        // }

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


        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql

        ];

        echo json_encode($json_array);

        break;


        case 'user_permission':
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id   = $_POST['user_type_unique_id'];
            // print_r( $user_type_unique_id);die();
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            // print_r($select_where);die();
            $table_details   = [
                $table_user,
                $columns
            ];
    
            $table_users  = $pdo->select($table_details, $select_where);
    
            if ($table_users->status) {
    
                $table_users      = $table_users->data;
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
                    "draw"				=> intval($draw),
                    "recordsTotal" 		=> intval($total_records),
                    "recordsFiltered" 	=> intval($total_records),
                    "data" 				=> $action_unique_ids,
                    "testing"			=> $result->sql
                ];
            
             echo json_encode($json_array);
    
            break;
          
            case 'user_permission_1':
                $screen_id_val      = $_POST['screen_id_val'];
                $user_type_unique_id   = $_POST['user_type_unique_id'];
                // print_r( $user_type_unique_id);die();
                
            $table_user ="user_screen_permission";
                $columns        = [
                    // "screen_unique_id",
                    "action_unique_id",
                    "user_type"
                ];
                $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
                // print_r($select_where);die();
                $table_details   = [
                    $table_user,
                    $columns
                ];
        
                $table_users  = $pdo->select($table_details, $select_where);
        
                if ($table_users->status) {
        
                    $table_users      = $table_users->data;
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
                        "draw"				=> intval($draw),
                        "recordsTotal" 		=> intval($total_records),
                        "recordsFiltered" 	=> intval($total_records),
                        "data" 				=> $action_unique_ids,
                        "testing"			=> $result->sql
                    ];
                
                 echo json_encode($json_array);
        
                break;







    default:

        break;
}



function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file_name);
    $image_view = '';

    if ($dc_file_name) {
        foreach ($file_names as $file_key => $dc_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file_name);

            if ($dc_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}



// doc 2

function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file_name);
    $image_view1 = '';

    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view1 .= "&nbsp";
                } else {
                    $image_view1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file_name);

            if ($ir_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view1 .= '<a href="javascript:print_pdf(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view1;
}


// doc3
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $file_invoice);
    $image_view2 = '';

    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view2 .= "&nbsp";
                } else {
                    $image_view2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_invoice);

            if ($file_invoice) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view2 .= '<a href="javascript:print_pdf(\'/' . $file_invoice . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view2;
}


// doc3


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
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}

function ins_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team_beta";
    

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM installation_details_sublist where `installation_id` LIKE 'INS%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;


    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['installation_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($booking_no == '')
        $booking_nos = 'INS-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $booking_nos = 'INS-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'INS-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }

    return $booking_nos;
}


