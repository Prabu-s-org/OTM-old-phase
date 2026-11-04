<?php
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
 $table             = 'po_form';
 $table_product_details = 'product_details_sub';
$table_consignee_details = 'consignee_details_sub';


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';
// File Upload Library Call

$fileUploadPath = $fileUploadConfig->get('upload_folder');

// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set('upload_folder', $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
// Variables Declaration
 $action             = $_POST['action'];
$action_obj         = (object) [
    'status'    => 0,
    'data'      => '',
    'error'     => 'Action Not Performed'
];
$json_array         = '';
$sql                = '';

$user_type          = '';
$is_active          = '';
$unique_id          = '';
$prefix             = '';

$data               = '';
$msg                = '';
$error              = '';
$status             = '';
$test               = '';
// For Developer Testing Purpose

switch ($action) {

    case 'consignee_details_add_update':

        $no_of_consignee         = $_POST['no_of_consignee'];
        $batch_id                = $_POST['batch_id'];
        $consignee_received_date = $_POST['consignee_received_date'];
        $con_address             = $_POST['con_address'];
        $con_district            = $_POST['con_district'];
        $con_state_name          = $_POST['con_state_name'];
        $con_pincode             = $_POST['con_pincode'];
        $consignee_gst           = $_POST['consignee_gst'];
        $con_contact_name        = $_POST['con_contact_name'];
        $con_contact_number      = $_POST['con_contact_number'];
        $con_lan_num             = $_POST['con_lan_num'];
        $form_main_unique_id     = $_POST['form_main_unique_id'];
        $zone                    = $_POST['zone'];
        $cons_verify_sts         = $_POST['cons_verify_sts'];
        $unique_id               = $_POST['unique_id'];
        $po_numbers              = $_POST['po_numbers'];
        $assign_team_member      = $_POST['assign_team_member'];
    
        $dateee = date('Y-m-d');
    
        $columns = [
            'no_of_consignee'         => $no_of_consignee,
            'batch_id'                => $batch_id,
            'consignee_received_date' => $consignee_received_date,
            'batch_entry_date'        => $dateee,
            'con_address'             => $con_address,
            'consignee_gst'           => $consignee_gst,
            'con_state_name'   => $con_state_name,
            'con_district'            => $con_district,
            'con_pincode'             => $con_pincode,
            'con_contact_name'        => $con_contact_name,
            'con_contact_number'      => $con_contact_number,
            'con_lan_num'             => $con_lan_num,
            'form_main_unique_id'     => $form_main_unique_id,
            'zone'                    => $zone,
            'cons_verify_sts'         => $cons_verify_sts,
            'po_number'               => $po_numbers,
            'assign_team_member'      => $assign_team_member,
            'unique_id'               => unique_id($prefix)
        ];
    
        // Step 1: Check for duplicate address within the same form_main_unique_id
        $table_details = [
            $table_consignee_details,
            ['COUNT(unique_id) AS count', 'unique_id']
        ];
    
        $select_where = 'is_delete = 0 AND con_address = "' . $con_address . '" AND form_main_unique_id = "' . $form_main_unique_id . '" AND po_number = "'.$po_numbers.'"';
    
        $action_obj = $pdo->select($table_details, $select_where);
    // print_r($action_obj);
        if ($action_obj->status) {
            $existing_data = $action_obj->data;
    
            // If duplicate found and it's not the same record (i.e., updating someone else's record)
            if ($existing_data[0]['count'] > 0 && $existing_data[0]['unique_id'] !== $unique_id) {
                echo json_encode([
                    'status' => false,
                    'data'   => [],
                    'error'  => 'Duplicate address for this form already exists.',
                    'msg'    => 'already',
                    'sql'    => $action_obj->sql
                ]);
                exit;
            }
        }
    
        // Step 2: If unique_id exists -> Update
        if ($unique_id) {
            unset($columns['unique_id']); // Remove from update fields
    
            // Update po_product_assign_details table
            $table_product_po = 'po_product_assign_details';
            $columns_po = [
                'con_name'       => $con_contact_name,
                'con_contact_no' => $con_contact_number
            ];
            $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" AND con_unique_id="' . $unique_id . '"';
            $pdo->update($table_product_po, $columns_po, $update_where_po);
    
            // Update main table
            $update_where = ['unique_id' => $unique_id];
            $action_obj = $pdo->update($table_consignee_details, $columns, $update_where);
            $msg = 'update';
    
        } else {
            // Step 3: Insert (only if not duplicate)
            $action_obj = $pdo->insert($table_consignee_details, $columns);
            $msg = 'add';
        }
    
        // Step 4: Prepare response
        if ($action_obj->status) {
            $status = true;
            $error  = '';
            $data   = $action_obj->data;
            $sql    = $action_obj->sql;
        } else {
            $status = false;
            $error  = $action_obj->error;
            $data   = [];
            $sql    = $action_obj->sql;
            $msg    = 'error';
        }
    
        // Step 5: Output response
        echo json_encode([
            'status' => $status,
            'data'   => $data,
            'error'  => $error,
            'msg'    => $msg,
            'sql'    => $sql
        ]);
    
        break;
    }
?>



