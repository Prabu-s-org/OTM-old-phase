


<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table             = "view_stock_position_list";
$table_sub             = "invoice_sublist";
$table_invoice            = "invoice_creation";
$table_invoice_main            = "invoice_creation_main";
$table1 = "stock_position_main";
$table2 = "stock_position";
$table3 = "stock_position_main";
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
        $po_unique_id          = $_POST["po_unique_id"];
        $po_num                 = $_POST["po_num"];
        $po_date                = $_POST["po_date"];
        $executive_name         = $_POST["executive_name"];
        $consignee_id          = $_POST["consignee_id"];
        $ledger_name            = $_POST["ledger_name"];
        $invoice_no         = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $item_code          = $_POST["item_code"];
        $product            = $_POST["product"];
        $item_qty           = $_POST["item_qty"];
        // $is_active          = $_POST["is_active"];
        $unique_id          = $_POST["unique_id"];
        $update_where       = "";
        $dc_number             = $_POST['dc_number'];
        $dc_date             = $_POST['dc_date'];
        $mydc_no             = $_POST['mydc_no'];

        $columns            = [
            "po_num"            => $po_num,
            "po_date"             => $po_date,
            "executive_name"           => $executive_name,
            "consignee_id"           => $consignee_id,
            "ledger_name"           => $ledger_name,
            "invoice_no"             => $invoice_no,
            "invoice_date"           => $invoice_date,
            "item_code"           => $item_code,
            "product"             => $product,
            "item_qty"           => $item_qty,
            "po_unique_id"           => $po_unique_id,
            // "dc_number"           => $dc_number,
            // "dc_date"           => $dc_date,
            "unique_id"           => unique_id($prefix)
        ];
        $table_details      = [
            $table_invoice,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        // $select_where       = ' is_delete = 0 AND dc_number = "'.$dc_number.'" AND unique_id ="' . $unique_id . '" and invoice_no="'.$invoice_no .'"';
        $select_where       = ' is_delete = 0  AND unique_id ="' . $unique_id . '" and invoice_no="'.$invoice_no .'"';

        
        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r($action_obj);
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
        if ($data[0]['count']) {
            $msg        = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            // Update Begins
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where   = [
                    "unique_id"     => $unique_id
                ];
                $action_obj     = $pdo->update($table_invoice, $columns, $update_where);

                // Update Ends
            } else {
                // Insert Begins

                $action_obj     = $pdo->insert($table_invoice, $columns);
                // Insert Ends
            }
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
        
        
        
 

        case 'serial_no_update':
            // print_r($_POST);die();
            $ser_qty          = !empty($_POST["ser_qty"]) ? $_POST['ser_qty'] : NULL;
            $seril_no_selc = $_POST['seril_no_selc'];
            $mon_ser_qty                 = $_POST["mon_ser_qty"];
            $spec_srl_no = !empty($_POST['spec_srl_no']) ? $_POST['spec_srl_no'] : NULL;
            $unique_id          = $_POST["unique_id"];
            
            // !empty($yourInput) ? $yourInput : 'NULL';

            $update_where       = "";
            $columns            = [
                "ser_no"            => $ser_qty,
                "mon_ser_no"             => $mon_ser_qty,
                "seril_no_selc" => $seril_no_selc,
                "spec_srl_no" => $spec_srl_no
            ];

            $table_details      = [
                $table_invoice
            ];

            
            if ($unique_id) {

                unset($columns['unique_id']);
                $update_where   = [
                    "unique_id"     => $unique_id
                ];

                $action_obj     = $pdo->update($table_invoice, $columns, $update_where);

                
                // Update Ends
                } 
                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = "";
                    $sql        = $action_obj->sql;
                    if ($unique_id) {
                        $msg        = "update_ser";
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
            // print_r($action_obj);die();
            $json_array   = [
                "status"    => $status,
                "data"      => $data,
                "error"     => $error,
                "msg"       => $msg,
                "sql"       => $sql
            ];
            echo json_encode($json_array);
            break;
    
    
      case 'update_serial_no':
            
            $serial_no          = !empty($_POST["serial_no"]) ? $_POST['serial_no'] : NULL;
           
            $unique_id          = $_POST["unique_id"];
            
            

            $update_where       = "";
            $columns            = [
                "ser_no"            => $serial_no,    
            ];
            $table_details      = [
                $table_invoice
               
            ];

            if ($unique_id) {
                   
                    $update_where   = [
                        "unique_id"     => $unique_id
                    ];
                    $action_obj     = $pdo->update($table_invoice, $columns, $update_where);
    
                    // Update Ends
                } 
                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = "";
                    $sql        = $action_obj->sql;
                    if ($unique_id) {
                        $msg        = "update_ser";
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
    
    

       
        
        
        
        
    case 'invoice_add_update':
        $po_num          = $_POST['po_num'];
        $po_date              = $_POST['po_date'];
        $excutive_name            = $_POST['executive_name'];
        // $no_of_consignee     = $_POST['no_of_consignee'];
        $consignee        = $_POST['consignee'];
        $ledger_name            = $_POST['ledger_name'];
        $ledger_no            = $_POST['ledger_no'];
        $invoice_no              = $_POST['invoice_no'];
        $invoice_date             = $_POST['invoice_date_1'];
        $serial_no = $_POST['serial_no'];
        $consignee_unique_id            = $_POST['consignee_unique_id'];
        $form_main_unique_id              = $_POST['form_main_unique_id'];
        $invoice_unique_id             = $_POST['invoice_unique_id'];
        $po_unique_id       = $_POST['po_unique_id'];
        $unique_id             = $_POST['unique_id'];

        $dc_number             = $_POST['dc_number'];
        $dc_date             = $_POST['dc_date'];
        $mydc_no             = $_POST['mydc_no'];

        $myinv_auto_id             = $_POST['myinv_auto_id'];


        $invoice_formatted_date = date("Y-m-d", strtotime($invoice_date));

        // 1st image open

        // if (is_array($_FILES["test_file"]['name'])) {
        //     if ($_FILES["test_file"]['name'][0] != "") {
        //         // Multi file Upload 
        //         $confirm_upload     = $fileUpload->uploadFiles("test_file");
        //         if (is_array($confirm_upload)) {
        //             // print_r($_FILES["test_file"]['name']);
        //             $_FILES["test_file"]['file_name'] = [];
        //             foreach ($confirm_upload as $c_key => $c_value) {
        //                 if ($c_value->status == 1) {
        //                     $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
        //                     array_push($_FILES["test_file"]['file_name'], $c_file_name);
        //                 } else { // if Any Error Occured in File Upload Stop the loop
        //                     $status     = $confirm_upload->status;
        //                     $data       = "file not uploaded";
        //                     $error      = $confirm_upload->error;
        //                     $sql        = "file upload error";
        //                     $msg        = "file_error";
        //                     break;
        //                 }
        //             }
        //         } else if (!empty($_FILES["test_file"]['name'])) { // Single File Upload
        //             $confirm_upload     = $fileUpload->uploadFile("test_file");
        //             if ($confirm_upload->status == 1) {
        //                 $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
        //                 $_FILES["test_file"]['file_name']  = $c_file_name;
        //             } else { // if Any Error Occured in File Upload Stop the loop
        //                 $status     = $confirm_upload->status;
        //                 $data       = "file not uploaded";
        //                 $error      = $confirm_upload->error;
        //                 $sql        = "file upload error";
        //                 $msg        = "file_error";
        //             }
        //         }
        //     }
        // }
        // if (is_array($_FILES["test_file"]['name'])) {
        //     if ($_FILES["test_file"]['name'][0] != "") {
        //         $file_names     = implode(",", $_FILES["test_file"]['file_name']);
        //         $file_org_names = implode(",", $_FILES["test_file"]['name']);
        //     }
        // } else if (!empty($_FILES["test_file"]['name'])) {
        //     $file_names     = $_FILES["test_file"]['file_name'];
        //     $file_org_names = $_FILES["test_file"]['name'];
        // }
        // // 1st image close

        // // 2nd image open 
        // if (is_array($_FILES["test_file1"]['name'])) {
        //     if ($_FILES["test_file1"]['name'][0] != "") {
        //         // Multi file Upload 
        //         $confirm_upload     = $fileUpload->uploadFiles("test_file1");
        //         if (is_array($confirm_upload)) {
        //             // print_r($_FILES["test_file"]['name']);
        //             $_FILES["test_file1"]['file_name'] = [];
        //             foreach ($confirm_upload as $c_key => $c_value) {
        //                 if ($c_value->status == 1) {
        //                     $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
        //                     array_push($_FILES["test_file1"]['file_name'], $c_file_name);
        //                 } else { // if Any Error Occured in File Upload Stop the loop
        //                     $status     = $confirm_upload->status;
        //                     $data       = "file not uploaded";
        //                     $error      = $confirm_upload->error;
        //                     $sql        = "file upload error";
        //                     $msg        = "file_error";
        //                     break;
        //                 }
        //             }
        //         } else if (!empty($_FILES["test_file1"]['name'])) { // Single File Upload
        //             $confirm_upload     = $fileUpload->uploadFile("test_file1");
        //             if ($confirm_upload->status == 1) {
        //                 $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
        //                 $_FILES["test_file1"]['file_name']  = $c_file_name;
        //             } else { // if Any Error Occured in File Upload Stop the loop
        //                 $status     = $confirm_upload->status;
        //                 $data       = "file not uploaded";
        //                 $error      = $confirm_upload->error;
        //                 $sql        = "file upload error";
        //                 $msg        = "file_error";
        //             }
        //         }
        //     }
        // }
        // if (is_array($_FILES["test_file1"]['name'])) {
        //     if ($_FILES["test_file1"]['name'][0] != "") {
        //         $ir_file_names     = implode(",", $_FILES["test_file1"]['file_name']);
        //         $ir_file_org_names = implode(",", $_FILES["test_file1"]['name']);
        //     }
        // } else if (!empty($_FILES["test_file1"]['name'])) {
        //     $ir_file_names     = $_FILES["test_file1"]['file_name'];
        //     $ir_file_org_names = $_FILES["test_file1"]['name'];
        // }
        // // 2nd image close
        // // 3rd image open
        // if (is_array($_FILES["test_file2"]['name'])) {
        //     if ($_FILES["test_file2"]['name'][0] != "") {
        //         // Multi file Upload 
        //         $confirm_upload     = $fileUpload->uploadFiles("test_file2");
        //         if (is_array($confirm_upload)) {
        //             // print_r($_FILES["test_file"]['name']);
        //             $_FILES["test_file2"]['file_name'] = [];
        //             foreach ($confirm_upload as $c_key => $c_value) {
        //                 if ($c_value->status == 1) {
        //                     $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
        //                     array_push($_FILES["test_file2"]['file_name'], $c_file_name);
        //                 } else { // if Any Error Occured in File Upload Stop the loop
        //                     $status     = $confirm_upload->status;
        //                     $data       = "file not uploaded";
        //                     $error      = $confirm_upload->error;
        //                     $sql        = "file upload error";
        //                     $msg        = "file_error";
        //                     break;
        //                 }
        //             }
        //         } else if (!empty($_FILES["test_file2"]['name'])) { // Single File Upload
        //             $confirm_upload     = $fileUpload->uploadFile("test_file2");
        //             if ($confirm_upload->status == 1) {
        //                 $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
        //                 $_FILES["test_file2"]['file_name']  = $c_file_name;
        //             } else { // if Any Error Occured in File Upload Stop the loop
        //                 $status     = $confirm_upload->status;
        //                 $data       = "file not uploaded";
        //                 $error      = $confirm_upload->error;
        //                 $sql        = "file upload error";
        //                 $msg        = "file_error";
        //             }
        //         }
        //     }
        // }
        // if (is_array($_FILES["test_file2"]['name'])) {
        //     if ($_FILES["test_file2"]['name'][0] != "") {
        //         $invoice_file_names     = implode(",", $_FILES["test_file2"]['file_name']);
        //         $invoice_file_org_names = implode(",", $_FILES["test_file2"]['name']);
        //     }
        // } else if (!empty($_FILES["test_file2"]['name'])) {
        //     $invoice_file_names     = $_FILES["test_file2"]['file_name'];
        //     $invoice_file_org_names = $_FILES["test_file2"]['name'];
        // }
        // 3rd image close
        // $myinv_no       = $_POST['myinv_no'];
        // $parts = explode('/', $myinv_no);

        $originalString = $_POST['myinv_no'];
        $cleanString = str_replace("/", "", $originalString);

        $doc_dc_number             = $_POST['dc_number'];
        // $originalString = $_POST['myinv_no'];
        $cleanString_dc = str_replace("/", "", $doc_dc_number);

        
        // Get the last value from the array
        $myinv_no_value = $cleanString."_".$cleanString_dc;
        
        $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        $allowedMimeTypes = array(
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );



        $file = $_FILES['file']['name'];
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                
                $targetDir = '../../uploads/invoice/';
        
               
                
                
                // if (move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/invoice/' . $tem_name)) {

                //     // Set filenames
                //     // $file_names = $tem_name;
                //     // $file_org_names = $_FILES['file']['name'];
                // //     echo "File uploaded successfully.";
                // }

                // $allowedExts = array('pdf');
                // $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        
                if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
                    // $tem_name = random_strings(25) . '.pdf';
                    $tem_name = "INV-".$myinv_no_value . "-DC." . $extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/invoice/' . $tem_name);
                    // Set $file_names to the stored filename with .pdf extension
                    $file_names = $tem_name;
                $file_org_names = $_FILES['file']['name'];
                }





                $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        $allowedMimeTypes = array(
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );
        $file = $_FILES['test_file1']['name'];
            $extension = pathinfo($_FILES['test_file1']['name'], PATHINFO_EXTENSION);
               
                // $targetDir = '../../uploads/invoice/';
        
                // $ir_file_names = $tem_name;
                // $ir_file_org_names = $_FILES['test_file1']['name'];
                // move_uploaded_file($_FILES['test_file1']['tmp_name'], '../../uploads/invoice/' . $tem_name);
                // if (move_uploaded_file($_FILES['test_file1']['tmp_name'], '../../uploads/invoice/' . $tem_name)) {
                //     // Set filenames
                //     // $ir_file_names = $tem_name;
                //     // $ir_file_org_names = $_FILES['test_file1']['name'];
                // //     echo "File uploaded successfully.";
                // }


                if ($_FILES['test_file1']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
                    // $tem_name = random_strings(25) . '.pdf';
                    $tem_name = "INV-".$myinv_no_value . "-IR." . $extension;
                    move_uploaded_file($_FILES['test_file1']['tmp_name'], '../../uploads/invoice/' . $tem_name);
                    // Set $file_names to the stored filename with .pdf extension
                    $ir_file_names = $tem_name;
                    $ir_file_org_names = $_FILES['test_file1']['name'];
                }
                
                $file = $_FILES['test_file2']['name'];
            $extension = pathinfo($_FILES['test_file2']['name'], PATHINFO_EXTENSION);
                
                $targetDir = '../../uploads/invoice/';
        
               
                
                // move_uploaded_file($_FILES['test_file2']['tmp_name'], '../../uploads/invoice/' . $tem_name);
                if ($_FILES['test_file2']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
                    // $tem_name = random_strings(25) . '.pdf';
                    $tem_name = "INV-".$cleanString . "-Invoice." . $extension;
                    move_uploaded_file($_FILES['test_file2']['tmp_name'], '../../uploads/invoice/' . $tem_name);
                    // Set $file_names to the stored filename with .pdf extension
                    $invoice_file_names = $tem_name;
                $invoice_file_org_names = $_FILES['test_file2']['name'];
                }
                // if (move_uploaded_file($_FILES['test_file2']['tmp_name'], '../../uploads/invoice/' . $tem_name)) {
                //     // Set filenames
                    
                // //     echo "File uploaded successfully.";
                // }

// print_r($file_names.'-'.$file_org_names);die();
        $update_where          = '';
        // print_r( 'hii'.$con_con_address );
        $columns            = [
            'po_num'        => $po_num,
            'po_date'           => $po_date,
            'excutive_name'     => $excutive_name,
            'consignee_unique_id'   => $consignee_unique_id,
            'invoice_id'      => $invoice_unique_id,
            'consignee'             => $consignee,
            'ledger_name'              => $ledger_name,
            'ledger_no'              => $ledger_no,
            'invoice_no'             => $invoice_no,
            'invoice_date'             => $invoice_formatted_date,
            'serial_no'   => $serial_no,
            'dc_file_name'           => $file_names,
            'file_org_name'          => $file_org_names,
            'ir_file_name'           => $ir_file_names,
            'ir_file_org_name'      => $ir_file_org_names,
            'file_invoice'           => $invoice_file_names,
            'po_unique_id'          => $po_unique_id,
            'invoice_file_org_name'  => $invoice_file_org_names,
            'form_main_unique_id'   => $form_main_unique_id,
            'dc_number'             => $dc_number,
            'dc_date'             => $dc_date,
            // 'invoice_no'             => $invoice_no,
            'unique_id'              => unique_id($prefix)
        ];

        
        // check already Exist Or not
        $table_details      = [
            $table_sub,
            [
                'COUNT(unique_id) AS count'
            ]
        ];


$select_where = 'po_num ="' . $po_num . '" AND invoice_no ="' . $invoice_no . '" AND dc_number = "' . $dc_number . '" AND is_delete = 0';

if ($unique_id) {
    $select_where .= 'AND unique_id !="' . $unique_id . '" ';
}

$action_obj121 = $pdo->select($table_details, $select_where);

// print_r($action_obj121);die();
if ($action_obj121->status) {
    $status = $action_obj121->status;
    $data = $action_obj121->data;
    $error = '';
    $sql = $action_obj121->sql;
} else {
    $status = $action_obj121->status;
    $data = $action_obj121->data;
    $error = $action_obj121->error;


    $sql = $action_obj121->sql;
    $msg = 'error';
}

$table_invoice_detials = [
$table_invoice_main,
 [
                'COUNT(unique_id) AS count'
            ]
];

if ($data[0]['count'] != 0) {
    $msg = 'already'; // Same PO + Invoice + DC exists
} else if ($data[0]['count'] == 0) {

    
    $where_dc_check = 'dc_number = "' . $dc_number . '" AND (po_num != "' . $po_num . '" OR invoice_no != "' . $invoice_no . '") AND is_delete = 0';
    if ($unique_id) {
        $where_dc_check .= ' AND unique_id != "' . $unique_id . '"';
    }
    $check2 = $pdo->select($table_invoice_detials, $where_dc_check);

               


    if ($check2->status && $check2->data[0]['count'] > 0) {
                //   echo 'if'.      print_r($check2);die();

        $msg = "DC already";
    } else {

        $where_invoice_check = 'invoice_no = "' . $invoice_no . '" AND po_num != "' . $po_num . '" AND is_delete = 0';
        if ($unique_id) {
            $where_invoice_check .= ' AND unique_id != "' . $unique_id . '"';
        }
        $check3 = $pdo->select($table_invoice_detials,  $where_invoice_check);

            // print_r($check3);die();


        if ($check3->status && $check3->data[0]['count'] > 0) {
            $msg = "Invoice already";
        } else {
            $table_details_main = [
                $table_invoice_main,
                ['COUNT(unique_id) AS count']
            ];
            $select_where_main = 'invoice_no ="' . $invoice_no . '" AND is_delete = 0';
            if ($unique_id) {
                $select_where_main .= ' AND unique_id !="' . $unique_id . '" ';
            }

            $action_obj_main = $pdo->select($table_details_main, $select_where_main);
            if ($action_obj_main->status) {
                $status = $action_obj_main->status;
                $data1 = $action_obj_main->data;
                $error = '';
                $sql = $action_obj_main->sql;
            }

            $columns1 = [
                "invoice_doc_status" => 3,
                "ledger_no" => $ledger_no,
                "ledger_name" => $ledger_name,
                "doc_approval_sts" => 0,
                "ac_team_verifiy_status" => 0,
                "approved_by" => '',
                "ac_team_approved_by" => '',
                "reject_reason_elcot" => '',
                "invoice_date" => $invoice_formatted_date,
                "dc_number" => $dc_number,
                "dc_date" => $dc_date,
            ];
            $columns2 = [
                "dc_num" => $dc_number,
                "dc_date" => $dc_date,
            ];

            $update_where1 = 'unique_id ="' . $invoice_unique_id . '"';
            $update_where2 = 'invoice_auto_id ="' . $myinv_auto_id . '"';

            $update_invoice_creation = $pdo->update("invoice_creation", $columns2, $update_where2);
            $update_invoice_main = $pdo->update($table_invoice_main, $columns1, $update_where1);

            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where = ['unique_id' => $unique_id];
                $action_obj = $pdo->update($table_sub, $columns, $update_where);
            } else {
                $action_obj = $pdo->insert($table_sub, $columns);
            }

            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = '';
                $sql = $action_obj->sql;
                $msg = 'insert';
            } else {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = $action_obj->error;
                $sql = $action_obj->sql;
                $msg = 'error';
            }
        }
    }
}

$json_array = [
    'status' => $status,
    'data' => $data,
    'error' => $error,
    'msg' => $msg,
    'sql' => $sql
];
echo json_encode($json_array);

        break;
        case 'invoice_add_update_3':

            // Input values
            $po_num          = $_POST['po_num'];
            $po_date         = $_POST['po_date'];
            $executive_name  = $_POST['executive_name'];
            $consignee       = $_POST['consignee'];
            $ledger_name     = $_POST['ledger_name'];
            $ledger_no       = $_POST['ledger_no'];
            $invoice_no      = $_POST['invoice_no'];
            $invoice_date    = $_POST['invoice_date_1'];
            $serial_no       = $_POST['serial_no'];
            $consignee_unique_id = $_POST['consignee_unique_id'];
            $form_main_unique_id = $_POST['form_main_unique_id'];
            $invoice_unique_id = $_POST['invoice_unique_id'];
            $po_unique_id    = $_POST['po_unique_id'];
            $unique_id       = $_POST['unique_id'];
            $dc_number       = $_POST['dc_number'];
            $dc_date         = $_POST['dc_date'];
            $mydc_no         = $_POST['mydc_no'];
            $myinv_auto_id   = $_POST['myinv_auto_id'];
        
            $invoice_formatted_date = date("Y-m-d", strtotime($invoice_date));
        
            $originalString = $_POST['myinv_no'];
            $cleanString = str_replace("/", "", $originalString);
            $myinv_no_value = $cleanString . "_" . $consignee_unique_id;
        
            $columns = [
                'ledger_name'  => $ledger_name,
                'ledger_no'    => $ledger_no,
                'invoice_no'   => $invoice_no,
                'invoice_date' => $invoice_formatted_date,
                'dc_number'    => $dc_number,
                'dc_date'      => $dc_date
            ];
        
            // === 1. Check if same dc_number + invoice_no exists (excluding current record if updating)
            $table_details = [$table_sub, ['COUNT(unique_id) AS count']];
            $select_where = 'dc_number = "' . $dc_number . '"  AND is_delete = 0';

            // AND invoice_no = "' . $invoice_no . '"
        
            if (!empty($unique_id)) {
                $select_where .= ' AND unique_id != "' . $unique_id . '"';
            }
        
            // $check_existing = $pdo->select($table_details, $select_where);
        
            // if ($check_existing->status && $check_existing->data[0]['count'] > 0) {
            //     // Duplicate found
            //     echo json_encode([
            //         'status' => false,
            //         'data'   => [],
            //         'error'  => '',
            //         'msg'    => 'already',
            //         'sql'    => $check_existing->sql
            //     ]);
            //     exit;
            // }
        
            // === 2. Update `invoice_main` and `invoice_creation` tables
            $columns1 = [
                "ledger_no"    => $ledger_no,
                "ledger_name"  => $ledger_name,
                "invoice_date" => $invoice_formatted_date,
                "dc_number"    => $dc_number,
                "dc_date"      => $dc_date,
            ];
        
            $columns2 = [
                "dc_num"  => $dc_number,
                "dc_date" => $dc_date,
            ];
        
            $update_where1 = 'unique_id = "' . $invoice_unique_id . '"';
            $update_where2 = 'invoice_auto_id = "' . $myinv_auto_id . '"';
        
            $pdo->update("invoice_creation", $columns2, $update_where2);
            $pdo->update($table_invoice_main, $columns1, $update_where1);
        
            // === 3. Update or Insert `invoice_sub`
            if (!empty($unique_id)) {
                unset($columns['unique_id']);
                $update_where = ['unique_id' => $unique_id];
                $action_obj = $pdo->update($table_sub, $columns, $update_where);
            } else {
                $columns['unique_id'] = unique_id($prefix); // Make sure unique_id() function exists
                $action_obj = $pdo->insert($table_sub, $columns);
            }
        
            // === 4. Return Final Response
            if ($action_obj->status) {
                $msg = 'success';
            } else {
                $msg = 'error';
            }
        
            echo json_encode([
                'status' => $action_obj->status,
                'data'   => $action_obj->data,
                'error'  => $action_obj->error,
                'msg'    => $msg,
                'sql'    => $action_obj->sql
            ]);
        
            break;
        
        case 'reupdate':
            $po_num          = $_POST['po_num'];
            $po_date              = $_POST['po_date'];
            $excutive_name            = $_POST['executive_name'];
            // $no_of_consignee     = $_POST['no_of_consignee'];
            $consignee        = $_POST['consignee'];
            $ledger_name            = $_POST['ledger_name'];
            $ledger_no            = $_POST['ledger_no'];
            $invoice_no              = $_POST['invoice_no'];
            $invoice_date             = $_POST['invoice_date_1'];
            $serial_no = $_POST['serial_no'];
            $consignee_unique_id            = $_POST['consignee_unique_id'];
            $form_main_unique_id              = $_POST['form_main_unique_id'];
            $invoice_unique_id             = $_POST['invoice_unique_id'];
            $po_unique_id       = $_POST['po_unique_id'];
             $unique_id             = $_POST['unique_id'];
    
            $dc_number             = $_POST['dc_number'];
            $dc_date             = $_POST['dc_date'];
            $mydc_no             = $_POST['mydc_no'];

            $old_dc_number = $_POST['old_dc_number'];
    
            $myinv_auto_id             = $_POST['myinv_auto_id'];
    
    
            $invoice_formatted_date = date("Y-m-d", strtotime($invoice_date));
    
              
            $originalString = $_POST['myinv_no'];
            $cleanString = str_replace("/", "", $originalString);
    
            
            // Get the last value from the array
            $myinv_no_value = $cleanString."_".$consignee_unique_id;
            
            $update_where          = '';
            // print_r( 'hii'.$con_con_address );
            $columns            = [
                // 'po_num'        => $po_num,
                // 'po_date'           => $po_date,
                // 'excutive_name'     => $excutive_name,
                // 'consignee_unique_id'   => $consignee_unique_id,
                // 'invoice_id'      => $invoice_unique_id,
                // 'consignee'             => $consignee,
                'ledger_name'              => $ledger_name,
                'ledger_no'              => $ledger_no,
                'invoice_no'             => $invoice_no,
                'invoice_date'             => $invoice_formatted_date,
                // 'serial_no'   => $serial_no,
                // 'dc_file_name'           => $file_names,
                // 'file_org_name'          => $file_org_names,
                // 'ir_file_name'           => $ir_file_names,
                // 'ir_file_org_name'      => $ir_file_org_names,
                // 'file_invoice'           => $invoice_file_names,
                // 'po_unique_id'          => $po_unique_id,
                // 'invoice_file_org_name'  => $invoice_file_org_names,
                // 'form_main_unique_id'   => $form_main_unique_id,
                'dc_number'             => $dc_number,
                'dc_date'             => $dc_date,
                // 'invoice_no'             => $invoice_no,
                // 'unique_id'              => unique_id($prefix)
            ];
    
            
            // check already Exist Or not
            $table_details      = [
                $table_sub,
                [
                    'COUNT(unique_id) AS count'
                ]
            ];
            $select_where       = 'dc_number = "'.$dc_number.'"  AND is_delete = 0';
            // AND con_contact_number ="'.$con_contact_number .'"is_delete = 0 AND and invoice_no ="'. $invoice_no . '"
            if ($invoice_unique_id) {
                $select_where   .= ' AND invoice_id !="' . $invoice_unique_id . '" ';
            }
            // print_r( $form_main_unique_id_count );
            // When Update Check without current id
            // if ( $unique_id ) {
            //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
            // }
            $action_obj121         = $pdo->select($table_details, $select_where);
            // print_r($action_obj121);die();
            if ($action_obj121->status) {
                $status     = $action_obj121->status;
                $data       = $action_obj121->data;
                $error      = '';
                $sql        = $action_obj121->sql;
            } else {
                $status     = $action_obj121->status;
                $data       = $action_obj121->data;
                $error      = $action_obj121->error;
                $sql        = $action_obj121->sql;
                $msg        = 'error';
            }
    
            if ($data[0]['count'] != 0) {
                $msg        = 'already';
            } else if(($data[0]['count'] == 0)) {
                // print_r('hi');die();
                // $columns_ex           = [
                //     'po_num'        => $po_num,
                //     'po_date'           => $po_date,
                //     'excutive_name'     => $excutive_name,
                //     'consignee_unique_id'   => $consignee_unique_id,
                //     'invoice_id'   => $invoice_unique_id,
                //     'consignee'             => $consignee,
                //     'ledger_name'              => $ledger_name,
                //     'ledger_no'              => $ledger_no,
                //     'invoice_no'             => $invoice_no,
                //     'invoice_date'             => $invoice_date,
                //     'dc_file_name'           => $file_names,
                //     'file_org_name'          => $file_org_names,
                //     'ir_file_name'           => $ir_file_names,
                //     'ir_file_org_name'      => $ir_file_org_names,
                //     'file_invoice'           => $invoice_file_names,
                //     'po_unique_id'          => $po_unique_id,
                //     'invoice_file_org_name'  => $invoice_file_org_names,
                //     'form_main_unique_id'   => $form_main_unique_id,
                //     'doc_approval_sts' =>1,
                //     'ac_team_verifiy_status' => 1,
                //     'unique_id'              => unique_id($prefix)
                // ];
    
                // $columns1            = [
                //     "invoice_doc_status"           => 3,
                //     "ledger_no"           => $ledger_no,
                //     "doc_approval_sts"   => 0,
                //     "ac_team_verifiy_status"   => 0,
                //     "approved_by"   => '',
                //     "ac_team_approved_by"   => '',
                //     "invoice_date"=>$invoice_date
                // ];
                // // AND invoice_no ="'.$invoice_no.'"
                // $update_where1  = 'unique_id ="' . $invoice_unique_id.'"';
                // $update_invoice_main     = $pdo->update($table_invoice_main, $columns1, $update_where1);
    
    
                // $action_obj     = $pdo->insert($table_sub, $columns_ex);
    
            // } else if(($data[0]['count'] == 0)) {
                // print_r('hello');die();
    
                // $table_details_main      = [
                //     $table_invoice_main,
                //     [
                //         'COUNT(unique_id) AS count'
                //     ]
                // ];
                // $select_where_main       = 'invoice_no ="'. $invoice_no . '" AND is_delete = 0';
                // // AND con_contact_number ="'.$con_contact_number .'"is_delete = 0 AND 
                // if ($unique_id) {
                //     $select_where   .= ' AND unique_id !="' . $unique_id . '" ';
                // }
                // // print_r( $form_main_unique_id_count );
                // // When Update Check without current id
                // // if ( $unique_id ) {
                // //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
                // // }
                // $action_obj_main         = $pdo->select($table_details_main, $select_where_main);
                // // print_r($action_obj_main);die();
                // if ($action_obj_main->status) {
                //     $status     = $action_obj_main->status;
                //     $data1       = $action_obj_main->data;
                //     $error      = '';
                //     $sql        = $action_obj_main->sql;
                // } 
    // die($data1[0]['count']);
                // if(($data1[0]['count'] == 0)) {
                    // invoice main status change
                    $columns_sub            = [
                       'dc_number'             => $dc_number,
                        'dc_date'             => $dc_date,
                        'ledger_name'              => $ledger_name,
                        'ledger_no'              => $ledger_no,
                        'invoice_no'             => $invoice_no,
                        'invoice_date'             => $invoice_formatted_date, ];
                    $columns1            = [
                        // "invoice_doc_status"           => 3,
                        "ledger_no"           => $ledger_no,
                        'ledger_name'              => $ledger_name,
                        // "doc_approval_sts"   => 0,
                        // "ac_team_verifiy_status"   => 0,
                        // "approved_by"   => '',
                        // "ac_team_approved_by"   => '',
                        // "reject_reason_elcot" => '',
                        'invoice_no'             => $invoice_no,
                        "invoice_date"=>$invoice_formatted_date,
                        "dc_number" => $dc_number,
                        "dc_date" => $dc_date,
                    ];
                    $columns2            = [
                        'invoice_no'             => $invoice_no,
                        'invoice_date'             => $invoice_formatted_date,
                        "dc_num" => $dc_number,
                        "dc_date" => $dc_date,
                    ];
                    // AND invoice_no ="'.$invoice_no.'"
                    $update_where1  = 'unique_id ="' . $invoice_unique_id.'" AND is_delete = 0';
    
                    $update_where2  = 'invoice_auto_id ="' .  $myinv_auto_id .'" AND is_delete = 0';
                    
                    $update_invoice_creation     = $pdo->update("invoice_creation", $columns2, $update_where2);
                   

                    // $myupdate_where = "invoice_id = '$invoice_unique_id'";
                    // $action_obj_sub     = $pdo->update("invoice_sublist", $columns, $myupdate_where);
                    // $myupdate_where = 'invoice_id = "'.$invoice_unique_id.'"';
                    $myupdate_where = 'dc_number = "'.$old_dc_number.'" AND is_delete = 0';
                    
                    $action_obj     = $pdo->update("invoice_sublist", $columns_sub, $myupdate_where);
                    // print_r($action_obj);die();
                    $update_invoice_main     = $pdo->update($table_invoice_main, $columns1, $update_where1);
                    // $update_invoice_main     = $pdo->update($table_invoice_main, $columns1, $update_where1);
                    // dc_number = "'.$dc_number.'" and 
                // }
                // print_r($update_invoice_main);die();
                // Update Begins
                // if ($unique_id) {
                //     unset($columns['unique_id']);
                //     $update_where   = [
                //         'unique_id'     => $unique_id
                //     ];
                //     $action_obj     = $pdo->update($table_sub, $columns, $update_where);
                //     // Update Ends
                // } else {
                //     // $action_obj     = $pdo->insert($table_sub, $columns);
                // }
                // print_r($action_obj);
                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = '';
                    $sql        = $action_obj->sql;
                    // if ( $data_record[0]['count'] <= $_POST['no_of_consignee'] ) {
                    //     $msg        = 'add';
                    // } else {
                    //     $msg        = 'already';
                    // }
                } else {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = $action_obj->error;
                    $sql        = $action_obj->sql;
                    $msg        = 'error';
                }
            // }
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
        $limit         = $length;
        
       $invoice_doc_status = $_POST['invoice_doc_status'];
       $team_mem = $_POST['team_mem'];
        $data        = [];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            
            "'' as  s_no",
            // "dc_number",
            // "invoice_no",
            "po_unique_id",
            "(select department from stock_position_main where form_main_unique_id = $table_invoice_main.form_main_unique_id group by invoice_auto_id) AS department",
            "get_staff_name_with_staff_id(team_mem) AS team_member",
            "get_name_stock(consignee_unique_id) AS con_contact_name",
            "invoice_qty",
            "invoice_value",
            "(select cons_verify_sts from consignee_details_sub where unique_id = $table_invoice_main.consignee_unique_id  and consignee_details_sub.is_delete='0' group by invoice_auto_id ) AS cons_verify_sts",
            // "invoice_doc_status",
            // "(SELECT COUNT(*) FROM invoice_sublist WHERE invoice_sublist.dc_number = $table_invoice_main.dc_number AND invoice_sublist.is_delete = '0' AND invoice_sublist.dc_number IS NOT NULL) AS doc_status",
            "unique_id",
            "invoice_no",
            "form_main_unique_id",
            "po_num",
            "reject_reason_elcot",
            "(select count(*) from invoice_creation_main where invoice_creation_main.invoice_no = ".$table_invoice_main.".invoice_no  AND invoice_creation_main.is_delete='0')  AS count",
            "approved_by",
            "ac_team_approved_by", 
            "DATE_FORMAT(dc_date, '%d-%m-%Y') as dc_date",  
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "get_district_name_po(po_unique_id) AS district_name",
                "get_state_name_po(po_unique_id) AS state_name",
                "executive_name",
                "get_ledger_name(ledger_name) AS ledger_name",
                 "consignee_unique_id",
                  "(select con_address from consignee_details_sub where unique_id = $table_invoice_main.consignee_unique_id  and consignee_details_sub.is_delete='0' group by invoice_auto_id ) AS con_address",
        ];

        $table_details  = [
            $table_invoice_main,
            $columns
        ];
    $where = "is_delete = '0' AND (dc_number = '' OR dc_number IS NULL) AND (invoice_no = '' OR invoice_no IS NULL)";

        if($invoice_doc_status != ''){
            $where = "invoice_doc_status LIKE '%".$invoice_doc_status."%'";
        }
        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }
        

        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
        $order_by       = datatable_sorting_inv2($order_column, $order_dir, $columns);

    
    $order_by = "CASE 
    WHEN invoice_doc_status = '2' THEN 1 
    WHEN invoice_doc_status = '0' THEN 2 
    WHEN invoice_doc_status = '1' THEN 3 
    WHEN invoice_doc_status = '3' THEN 4
    WHEN invoice_doc_status = '1' THEN 5
    WHEN invoice_doc_status = '4' THEN 6
    ELSE 7 
END $order_dir, DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";

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
        $total_records  = total_records();
        // print_r($result);die();
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
                $value['dc_number'] = $value['dc_number'] . '<br><b>' . $value['dc_date'] . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '<br><b>' . $value['invoice_date'] . '</b>';
                $orgDate = $value['invoice_date'];  
            
            $district_name = district_name_stock($value['district_name']);
            $state_name = con_state_name_stock($value['state_name']);
// // Format department with district and state
            $value['department'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['department'] . '</span><br>' . $district_name . ', ' . $state_name;
            $value['team_member'] = 'FOL - <span style="font-weight:bold; text-transform: uppercase;">' . $value['team_member'] . '</span><br>EXE - ' . $value['executive_name'];
       $con_contact_name = $value['con_contact_name'] ?? '';
$con_address = $value['con_address'] ?? '';

$value['con_contact_name'] = '<span style="font-weight:bold;">' . $con_contact_name . '</span><br> ' . $con_address;


               $consignee_verfied_sts= $value['cons_verify_sts'];
               if( $consignee_verfied_sts=='2'){
            $value['cons_verify_sts']='<span class="verify" style="color:red">Not Verfied</span>';
               }
               else{
             $value['cons_verify_sts']='<span class="verify" style="color:green">Verfied</span>';
               }


                $invoice_value = $value['invoice_value'];
             
                $value['invoice_value']  = moneyFormatIndia1(($invoice_value));

                // $value['invoice_auto_id'] = $value['invoice_no'];
                $value['po_unique_id'] = $value['po_num'];

                $value['po_date'] = '<span class="po_date">'.$value['po_date'].'</span>';
                
                $val = $value['reject_reason_elcot'];
                if($val==''){
                    $value['reject_reason_elcot'] = '-';
                }else{
                    $value['reject_reason_elcot'] = $val ;

                }
                
                  if($value['invoice_doc_status'] == 4) {
                    // $value['invoice_doc_status'] = "A/c Team Approval";
                    $value['invoice_doc_status'] = "Completed";
                } 
                 else if($value['invoice_doc_status'] == 1) {
                    $value['invoice_doc_status'] = "Accounts Team Pending";
                } 

               
                
                else if ($value['invoice_doc_status'] == 2) {
                    $value['invoice_doc_status'] = "<span style='color: red;'>Rejected</span>";
                    //  = "";
                } else if ($value['invoice_doc_status'] == 3) {
                    $value['invoice_doc_status'] = "Operation Team Pending";
                } else if ($value['invoice_doc_status'] == 0){
                    $value['invoice_doc_status'] = "Pending";
                }
                if($value['doc_status'] == 0) {
                    // $value['doc_status'] = "A/c Team Approval";
                    $value['doc_status'] = "<span style='color:red'>Doc Pending</span>";
                } 
                 else if($value['doc_status'] == 1) {
                    $value['doc_status'] = "<span style='color:green'>Doc uploded</span>";
                } 
                $value['is_active'] = is_active_show($value['is_active']);

                $btn_update         = btn_update($folder_name, $value['unique_id']);


                    $where_1="invoice_no='".$value['invoice_no']."' ";
                   
    
                $table_1      =  "invoice_sublist";
        
                $columns_1    = [
                    'COUNT(invoice_no) AS count'
                ];
        
                $table_details_1   = [
                    $table_1,
                    $columns_1
                ];
        
                $result_values_12  = $pdo->select($table_details_1, $where_1);
                // print_r($result_values_12);
                $data_st       = $result_values_12->data;
                $btn_update         = btn_update($folder_name, $value['unique_id']);
             

            $btn_view           = btn_view_invoice($folder_name, $value['unique_id'] );
            //  $value['status']='';
            $status= $value['cons_verify_sts'];

            
                // if (($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741") || ($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741")) {
                //     // echo"hi";
                //     $value['po_count'] = $btn_cancel;
                // } 

            if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                if($data_st[0]['count']){
                    $value['unique_id']     =  $btn_view;
                  }else{
                    // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_update.$btn_delete;                   
                    // }
                    // else


                    // && $value['cons_verify_sts'] == 1
                     if(in_array('5f88082b25ec031952', $action_ids) && ($consignee_verfied_sts == 1)){
                        $value['unique_id'] = $btn_update;
                    }
                    // else if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    else{
                        $value['unique_id'] = '';
                    }
                  }
                
              }

              if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
              
                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }
               
                else{
                    $value['unique_id'] = '';
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


case 'invoice_datatable_pending':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        
       $invoice_doc_status = $_POST['invoice_doc_status'];
       $team_mem = $_POST['team_mem'];
        $data        = [];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            
            "'' as  s_no",
            "dc_number",
            "invoice_no",
            "po_unique_id",
            "(select department from stock_position_main where form_main_unique_id = $table_invoice_main.form_main_unique_id group by invoice_auto_id) AS department",
            "get_staff_name_with_staff_id(team_mem) AS team_member",
            "get_name_stock(consignee_unique_id) AS con_contact_name",
            "invoice_qty",
            "invoice_value",
            "(select cons_verify_sts from consignee_details_sub where unique_id = $table_invoice_main.consignee_unique_id  and consignee_details_sub.is_delete='0' group by invoice_auto_id ) AS cons_verify_sts",
            "invoice_doc_status",
            "(SELECT COUNT(*) FROM invoice_sublist WHERE invoice_sublist.dc_number = $table_invoice_main.dc_number AND invoice_sublist.is_delete = '0' AND invoice_sublist.dc_number IS NOT NULL) AS doc_status",
            "unique_id",
            "invoice_no",
            "form_main_unique_id",
            "po_num",
            "reject_reason_elcot",
            "(select count(*) from invoice_creation_main where invoice_creation_main.invoice_no = ".$table_invoice_main.".invoice_no  AND invoice_creation_main.is_delete='0')  AS count",
            "approved_by",
            "ac_team_approved_by", 
            "DATE_FORMAT(dc_date, '%d-%m-%Y') as dc_date",  
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "get_district_name_po(po_unique_id) AS district_name",
                "get_state_name_po(po_unique_id) AS state_name",
                "executive_name",
                "get_ledger_name(ledger_name) AS ledger_name",
                 "consignee_unique_id",
                  "(select con_address from consignee_details_sub where unique_id = $table_invoice_main.consignee_unique_id  and consignee_details_sub.is_delete='0' group by invoice_auto_id ) AS con_address",
        ];

        $table_details  = [
            $table_invoice_main,
            $columns
        ];
        $where = " is_delete = '0' and dc_number != '' and invoice_no != ''";


        if($invoice_doc_status != ''){
            $where = "invoice_doc_status LIKE '%".$invoice_doc_status."%'";
        }
        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }
        

        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
        $order_by       = datatable_sorting_inv2($order_column, $order_dir, $columns);

    
    $order_by = "CASE 
    WHEN invoice_doc_status = '2' THEN 1 
    WHEN invoice_doc_status = '0' THEN 2 
    WHEN invoice_doc_status = '1' THEN 3 
    WHEN invoice_doc_status = '3' THEN 4
    WHEN invoice_doc_status = '1' THEN 5
    WHEN invoice_doc_status = '4' THEN 6
    ELSE 7 
END $order_dir, DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";

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
        $total_records  = total_records();
        // print_r($result);die();
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
                $value['dc_number'] = $value['dc_number'] . '<br><b>' . $value['dc_date'] . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '<br><b>' . $value['invoice_date'] . '</b>';
                $orgDate = $value['invoice_date'];  
            
            $district_name = district_name_stock($value['district_name']);
            $state_name = con_state_name_stock($value['state_name']);
// // Format department with district and state
            $value['department'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['department'] . '</span><br>' . $district_name . ', ' . $state_name;
            $value['team_member'] = 'FOL - <span style="font-weight:bold; text-transform: uppercase;">' . $value['team_member'] . '</span><br>EXE - ' . $value['executive_name'];
       $con_contact_name = $value['con_contact_name'] ?? '';
$con_address = $value['con_address'] ?? '';

$value['con_contact_name'] = '<span style="font-weight:bold;">' . $con_contact_name . '</span><br> ' . $con_address;


               $consignee_verfied_sts= $value['cons_verify_sts'];
               if( $consignee_verfied_sts=='2'){
            $value['cons_verify_sts']='<span class="verify" style="color:red">Not Verfied</span>';
               }
               else{
             $value['cons_verify_sts']='<span class="verify" style="color:green">Verfied</span>';
               }


                $invoice_value = $value['invoice_value'];
             
                $value['invoice_value']  = moneyFormatIndia1(($invoice_value));

                // $value['invoice_auto_id'] = $value['invoice_no'];
                $value['po_unique_id'] = $value['po_num'];

                $value['po_date'] = '<span class="po_date">'.$value['po_date'].'</span>';
                
                $val = $value['reject_reason_elcot'];
                if($val==''){
                    $value['reject_reason_elcot'] = '-';
                }else{
                    $value['reject_reason_elcot'] = $val ;

                }
                
                  if($value['invoice_doc_status'] == 4) {
                    // $value['invoice_doc_status'] = "A/c Team Approval";
                    $value['invoice_doc_status'] = "Completed";
                } 
                 else if($value['invoice_doc_status'] == 1) {
                    $value['invoice_doc_status'] = "Accounts Team Pending";
                } 

               
                
                else if ($value['invoice_doc_status'] == 2) {
                    $value['invoice_doc_status'] = "<span style='color: red;'>Rejected</span>";
                    //  = "";
                } else if ($value['invoice_doc_status'] == 3) {
                    $value['invoice_doc_status'] = "Operation Team Pending";
                } else if ($value['invoice_doc_status'] == 0){
                    $value['invoice_doc_status'] = "Pending";
                }
                if($value['doc_status'] == 0) {
                    // $value['doc_status'] = "A/c Team Approval";
                    $value['doc_status'] = "<span style='color:red'>Doc Pending</span>";
                } 
                 else if($value['doc_status'] == 1) {
                    $value['doc_status'] = "<span style='color:green'>Doc uploded</span>";
                } 
                $value['is_active'] = is_active_show($value['is_active']);

                $btn_update         = btn_update($folder_name, $value['unique_id']);


                    $where_1="invoice_no='".$value['invoice_no']."' ";
                   
    
                $table_1      =  "invoice_sublist";
        
                $columns_1    = [
                    'COUNT(invoice_no) AS count'
                ];
        
                $table_details_1   = [
                    $table_1,
                    $columns_1
                ];
        
                $result_values_12  = $pdo->select($table_details_1, $where_1);
                // print_r($result_values_12);
                $data_st       = $result_values_12->data;
                $btn_update         = btn_update($folder_name, $value['unique_id']);
             

            $btn_view           = btn_view_invoice($folder_name, $value['unique_id'] );
            //  $value['status']='';
            $status= $value['cons_verify_sts'];

            
                // if (($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741") || ($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741")) {
                //     // echo"hi";
                //     $value['po_count'] = $btn_cancel;
                // } 

            if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                if($data_st[0]['count']){
                    $value['unique_id']     =  $btn_view;
                  }else{
                    // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_update.$btn_delete;                   
                    // }
                    // else


                    // && $value['cons_verify_sts'] == 1
                     if(in_array('5f88082b25ec031952', $action_ids) && ($consignee_verfied_sts == 1)){
                        $value['unique_id'] = $btn_update;
                    }
                    // else if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    else{
                        $value['unique_id'] = '';
                    }
                  }
                
              }

              if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
              
                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }
               
                else{
                    $value['unique_id'] = '';
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



    case 'invoice_details_datatable':

        $invoice_id = $_POST['invoice_id'];

        $btn_edit_delete    = 'invoice_details';
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
            "consignee",
            // "ledger_name",

            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_sub . ".ledger_name) AS ledger_name",

            
            "dc_number",
            "DATE_FORMAT(dc_date,'%d-%m-%Y') as dc_date",
            "invoice_no",
            "invoice_date",
            "dc_file_name",
            "ir_file_name",
            "file_invoice",
            "unique_id",
            "invoice_id"
        ];

        $table_details  = [
            $table_sub,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        $where = "is_delete='0' AND invoice_id ='" . $invoice_id . "'";
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
                // $value['po_num'] = ($value['po_num']);
                // $value['po_date'] = ($value['po_date']);
                // $value['department'] = disname($value['department']);
                // $value['executive_name'] = disname($value['executive_name']);
                //   $value['no_of_consignee'] = disname($value['no_of_consignee']);
                //                   $value['no_of_po'] = disname($value['no_of_po']);
                //       $value['executive_name'] = disname($value['executive_name']);
                // $value['qty'] = disname($value['qty']);
                //           $value['net_value'] = disname($value['net_value']); 
                $orgDate = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate));
                // $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                $value['dc_file_name']     =  image_view("invoice", $value['unique_id'], $value['dc_file_name']);
                $value['ir_file_name']     =  image_view_1("invoice", $value['unique_id'], $value['ir_file_name']);
                $value['file_invoice']     =  image_view_2("invoice", $value['unique_id'], $value['file_invoice']);
                // $value['is_active'] = is_active_show($value['is_active']);
                // $btn_update         = btn_update($folder_name,$value['unique_id']);

                if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    $btn_delete         = btn_delete($folder_name,$value['unique_id']);
                }else{
                $btn_delete         = '';
                }
                $value['unique_id'] = $btn_delete;
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


    case 'invoice_details_delete':
        $unique_id  = $_POST['unique_id'];
        $columns            = [
            'is_delete'   => 1,
        ];
        $update_where   = [
            'unique_id'     => $unique_id
        ];
        $action_obj     = $pdo->update($table_sub, $columns, $update_where);
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
            $msg        = 'success_delete';
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
    case 'stock_processing_datatable':
        $btn_edit_delete    = "table_stock_position_processing";

        // Fetch Data
        $staff_unique_id = $_POST['staff_unique_id'];
        // DataTable 
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $limit         = $length;
        $data        = [];

        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
                "'' as  s_no",
                "po_date",
                "(SELECT po_unique_id FROM po_form WHERE po_form.unique_id = " . $table1 . ".form_main_unique_id AND po_form.is_delete=0 group by form_main_unique_id) AS po_unique_id",
                "executive_name",
                "department",
                "no_of_item",
                "stock_qty",
                "stock_value",
                "(SELECT SUM(invoice_qty) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id  = ".$table1.".form_main_unique_id AND invoice_creation_main.is_delete=0 group by form_main_unique_id) AS invoice_qty",
                "form_main_unique_id",
                "po_num",
                "(SELECT sum(item_qty) FROM stock_position WHERE stock_position.form_main_unique_id  = ".$table1.".form_main_unique_id AND stock_position.is_delete=0) AS item_qty",
                "(SELECT sum(billed_qty) FROM stock_position_main WHERE stock_position_main.form_main_unique_id  = ".$table1.".form_main_unique_id AND stock_position_main.is_delete=0) AS billed_qty",
                "get_district_name_po(po_unique_id) AS district_name",
                "get_state_name_po(po_unique_id) AS state_name",
        ];
        $table_details  = [
            $table1,
            $columns
        ];
        // $where = "status = '1' || status = '2'";
        $where = "status != '0' ";

        if ($_POST['from_date'] == '') {
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }
        if ($_POST['to_date'] == '') {
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];

            // $where .= "DATE_FORMAT(po_date, '%Y-%m-%d') >= '" . $from_date . "' AND DATE_FORMAT(po_date, '%Y-%m-%d') <= '" . $to_date . "' ";

        }
        if ($from_date || $to_date != '') {
            $from_date_converted = date('Y-m-d', strtotime($from_date));
            $to_date_converted = date('Y-m-d', strtotime($to_date));
            $where .= " AND STR_TO_DATE(po_date, '%Y-%m-%d') >= STR_TO_DATE('" . $from_date_converted . "', '%Y-%m-%d') AND STR_TO_DATE(po_date, '%Y-%m-%d') <= STR_TO_DATE('" . $to_date_converted . "', '%Y-%m-%d')";
  }
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
       
        // Datatable Ordering 
        $order_by      = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by ="(stock_qty = invoice_qty) $order_dir";

        // Datatable Searching
        $search         = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }
        //  $group= 'stock_id';
        // $order_by = "";
        $sql_function   = "SQL_CALC_FOUND_ROWS";
       
    $result         = $pdo->select($table_details, $where, $limit, $start, $order_by,$sql_function);
//    print_r($result);
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
            $i=0;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $i+1;
                $value['po_file'] = image_view_po("po_form", $value['form_main_unique_id'], $value['po_file']);
                $district_name = district_name_stock($value['district_name']);
            $state_name = con_state_name_stock($value['state_name']);

            // // Format department with district and state
            $value['department'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['department'] . '</span><br>' . $district_name . ', ' . $state_name;

            $value['item_qty'] = '<div style="text-align: right;">' . moneyFormatIndia1($value['item_qty']) . '</div>';
$value['billed_qty'] = '<div style="text-align: right;">' . moneyFormatIndia1($value['billed_qty']) . '</div>';
                $stock_value       = moneyFormatIndia1($value['stock_value']);
                $value['stock_value']=$stock_value;
                    $invoice_qty1= $value['invoice_qty'];
                    $stock_qty1= $value['stock_qty'];
            if($value['stock_qty']!=$value['invoice_qty']){
                    $value['invoice_qty']='Pending';
                   
            }
                else{
                    $value['invoice_qty']='Completed';
                }
             
// Define colors
$completed_color = "green";
$pending_color = "red";

// Format string with placeholders
if ($value['invoice_qty'] == 'Completed') {
    $value['invoice_qty'] = sprintf('<span style="color: %s;">%s</span>', $completed_color, $value['invoice_qty']);
} else {
    $value['invoice_qty'] = sprintf('<span style="color: %s;">%s</span>', $pending_color, $value['invoice_qty']);
}


                $orgDate = $value['po_date'];  
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                $value['po_unique_id'] = $value['po_num'];

            $btn_view         = btn_view_inv($folder_name,$value['form_main_unique_id']); 
            if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                if($invoice_qty1 == $stock_qty1){
                   // print_r($value['stock_qty']==$value['invoice_qty']);die();
                   $value['form_main_unique_id']=$btn_view;
              } 
               else{
               // $value['form_main_unique_id']='<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
           
                   // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                   //     $value['unique_id'] = $btn_update.$btn_delete;                   
                   // }
                   if(in_array('5f88082b25ec031952', $action_ids)){
                      $value['form_main_unique_id'] = '<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                   }
                   // else if(in_array('5f8808504271036738', $action_ids)){
                   //    $value['form_main_unique_id'] = $btn_delete;
                   // }
                   else{
                      $value['form_main_unique_id'] = '';
                   }
                 }
               
             }
             if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
               
               // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
               //     $value['unique_id'] = $btn_update.$btn_delete;                   
               // }
               // else
                if(in_array('5f88082b25ec031952', $action_ids)){
                   $value['form_main_unique_id']     =  '<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

               }
               // else if(in_array('5f8808504271036738', $action_ids)){
               //     $value['unique_id'] = $btn_delete;
               // }
               else{
                   $value['form_main_unique_id'] = '';
               }
             }

                // $value['unique_id']     = $btn_update;
                $data[]                 = array_values($value);
                $i++;
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



    case 'get_consignee':
        
        $table_consignee = 'view_product_assign_con_details';
        $unique_id = $_POST['unique_id'];

        $where = [
            "con_unique_id" => $unique_id
        ];

        $columns = [
            "form_main_unique_id",
            "con_address",
            "con_contact_name",
            "con_contact_number",
            "sum(assign_qty) as total_assign_qty",
            "con_unique_id"
        ];

        $table_details = [
            $table_consignee,
            $columns
        ];
        
        $group_by = "con_unique_id";

        $consignee_values = $pdo->select($table_details, $where, "", "", "", "", $group_by);
        // print_r($consignee_values);die();
        if ($consignee_values->status) {
            $consignee_values = $consignee_values->data;
            $con_contact_name = $consignee_values[0]['con_contact_name'];
            $con_contact_number = $consignee_values[0]['con_contact_number'];

            $data = [];

            foreach ($consignee_values as $key => $form_val) {
                $where1 = "form_main_unique_id = '" . $form_val['form_main_unique_id'] . "' and con_unique_id='" . $form_val['con_unique_id'] . "' ";
                $table1 = "view_product_assign_con_details";
                $columns1 = [
                    "item_code",
                    // "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table1.item_code)as item_code",
                    "product",
                    "qty",
                    "billed_qty",
                    "form_main_unique_id",
                    "po_num",
                    "po_date",
                    "executive_name",
                    "no_of_consignee",
                    "no_of_item",
                    "product_unique_id",
                    "stock_qty",
                    "stock_id",
                    "unit_price",
                    "stock_date",
                    "assign_qty",
                    "po_unique_id",
                    "(SELECT tax FROM product_details_sub WHERE product_details_sub.unique_id = ".$table1.".product_unique_id and product_details_sub.is_delete='0') AS tax",
                    // "tax",
                    "con_address",
                //    "billed_qty",
                "(SELECT SUM(invoice_qty) FROM invoice_creation WHERE invoice_creation.product_unique_id = ".$table1.".product_unique_id and invoice_creation.is_delete='0') AS invoice_qty", 
                "(SELECT SUM(invoice_qty) FROM invoice_creation WHERE invoice_creation.consignee_id = ".$table1.".con_unique_id AND invoice_creation.is_delete=0) AS total_invoice_qty",
                "(SELECT SUM(invoice_qty) FROM invoice_creation WHERE invoice_creation.product_unique_id = ".$table1.".product_unique_id and invoice_creation.consignee_id = ".$table1.".con_unique_id and invoice_creation.is_delete='0') AS assign_invoice_qty", 
                // "remaining_qty",
                "(SELECT delivery_due_dates FROM product_details_sub WHERE product_details_sub.unique_id = ".$table1.".product_unique_id and product_details_sub.is_delete='0') AS delivery_due_days",
                "batch_id",
                "assign_team_member AS team_mem_id",
                "(SELECT staff_name FROM user WHERE user.staff_id = ".$table1.".assign_team_member and user.is_delete='0') AS team_member"
                    // "(SELECT product_namestock_qty'] FROM invoice_creation WHERE invoice_creation.po_unique_id =$table1.form_main_unique_id ) AS invoice_qty",
                ];

                $table_details1 = [
                    $table1,
                    $columns1
                ];

                $values_product_1 = $pdo->select($table_details1, $where1);
                // print_R($values_product_1);
                $i = 1;
                if ($values_product_1->status) {
                    $product_array = $values_product_1->data;
                    $table_data = '';
                    foreach ($product_array as $key => $product_name) {
                        $remaining_qty_assign = $product_name['assign_qty']-$product_name['assign_invoice_qty'];
                        // print_r($product);die();
                        $poNumber = $product_name['po_num'];
                        $poNumberWithoutSpaces = str_replace(' ', '', $poNumber);
                        // <td>' . $product_name['stock_qty'] . '</td>
                        // $invoice_qty =  $product_name['invoice_qty'];
                        // 
                        // print_r($productWithoutSpaces);
                        //   $i = $i + 1;
                        // if ($product['product_unique_id']) {
                        // $remaining_qty = $product_name['stock_qty'] - $product_name['bill_qty'];
                        // $remaining_qty = $product_name['stock_qty']-$invoice_qty;
                        $remaining_qty = $product_name['stock_qty']-$product_name['invoice_qty'];
                        $table_data .= '<tr>
                            <td>' . $i . '</td>
                             <td>' . $product_name['batch_id'] . '</td>
                              <td>' . $product_name['team_member'] . '</td>
                            <td>' . $product_name['item_code'] . '</td>
                            <td>' . $product_name['product'] . '</td>
                            <td>' . $product_name['assign_qty'] . '</td>
                            <td>' . $remaining_qty_assign . '</td>
                            <td>' .  $remaining_qty  . '</td>

                            
                            <td>
                           
                                <div class="">

                            
                                    <input type="hidden" id="po_unique_id" name="po_unique_id[]" value="'.$product_name['po_unique_id'].'">
                                    <input type="hidden" id="team_mem" name="team_mem[]" value="'.$product_name['team_mem_id'].'">
                                    <input type="hidden" id="no_of_consignee" name="no_of_consignee[]" value="' . $product_name['no_of_consignee'] . '">
                                    <input type="hidden" id="main_unique_id" name="main_unique_id[]" value="' . $product_name['form_main_unique_id'] . '">
                                    <input type="hidden"  id="po_num" name="po_num[]" value="'.$product_name['po_num'].'"  >
                                    <input type="hidden" id="executive_name" name="executive_name[]" value="' . $product_name['executive_name'] . '" >
                                    <input type="hidden" id="po_date" name="po_date[]" value="' . $product_name['po_date'] . '">
                                    <input type="hidden" id="stock_id" name="stock_id[]" value="' . $product_name['stock_id'] . '">
                                    <input type="hidden" id="stock_date" name="stock_date[]" value="' . $product_name['stock_date'] . '">
                                    <input type="hidden"  id="item_code" name="item_code[]" value="' . $product_name['item_code'] . '">
                                    <input type="hidden" id="stock_qty" name="stock_qty[]" value="' . $product_name['stock_qty'] . '">
                                    <input type="hidden" id="unit_price" name="unit_price[]" value="' . $product_name['unit_price'] . '">
                                    <input type="hidden" id="product_unique_id" name="product_unique_id[]" value="' . $product_name['product_unique_id'] . '">
                                    <input type="hidden" id="no_of_item" name="no_of_item[]" value=' . $product_name['no_of_item'] . '>
                                    <input type="hidden" id="tax" name="tax[]" value="' . $product_name['tax'] . '">
                                    <input type="hidden" id="con_assign_qty" name="con_assign_qty[]" value="' . $product_name['assign_qty'] . '">
                                    <input type="hidden" id="con_address" name="con_address[]" value="' . $product_name['con_address'] . '">
                                    <input type="hidden"  id="remaining_qty" name="remaining_qty[]" value="'. $remaining_qty.'" >
                                    <input type="hidden" id="rem_billed_qty" name="rem_billed_qty[]"  value="'.$remaining_qty_assign.'" class="form-control">
                                    <input type="hidden"  id="item_name" name="item_name[]" value="'. $product_name['product'].'" >
                                    <input type="hidden" id="update_billed_qty" name="update_billed_qty[]"  value="'. $product_name['invoice_qty'].'" class="form-control">
                                    <input type="hidden" id="total_assign_qty" name="total_assign_qty[]" value="' . $form_val['total_assign_qty'] . '">
                                    <input type="hidden" id="total_invoice_qty" name="total_invoice_qty[]" value="' .$product_name['total_invoice_qty'].'">
                                    <input type="text" id="bill_qty" name="bill_qty[]" class="form-control"/>
                                     <input type="hidden" id="delivery_due_days" name="delivery_due_days[]" class="form-control" value="' .$product_name['delivery_due_days'].'"/>
                                   
                                </div>
                            </td>
                        </tr>';

                        $i++;
                        // }
                    }
                    // <input type="text" id="item_name" name="item_name[]" value='. $product_name['product'].'  style="max-width: 100%; width: 100%;">

                    // print_r($table_data);die();
                }
            }
        }

        // $data = array($values_product_1);
        $data = array($con_contact_name, $con_contact_number, $table_data);
        // } 



        $json_array = [
            "draw"                => intval($draw),
            "recordsTotal"         => intval($total_records),
            "recordsFiltered"     => intval($total_records),
            "data"                 => $data,
            "testing"            => $result->sql
        ];

        echo json_encode($json_array);
        break;


        // invoice stock
    case 'deleivery_status':
        // $product_unique_id          = $_POST["product_unique_id"];
        $invoice_id          = $_POST["invoice_id"];
        $invoice_auto_id          = $_POST["invoice_auto_id"];
        $consignee_unique_id         = $_POST["consignee_unique_id"];
        $form_main_unique_id          = $_POST["form_main_unique_id"];
        $ledger_name    = $_POST["ledger_name"];
        $ledger_no    = $_POST["ledger_no"];
        $invoice_no          = $_POST["invoice_no"];
        // $invoice_date          = $_POST["invoice_date"];


        $update_where       = "";
         // check already Exist Or not
         $table_details      = [
            $table_invoice_main,
            [
                'COUNT(unique_id) AS count'
            ]
        ];

        $select_where       = 'is_delete = 0 AND invoice_no ="' . $invoice_no . '"';
        // AND con_contact_number ="'.$con_contact_number .'"
        if ($unique_id) {
            $select_where   .= ' AND unique_id !="' . $unique_id . '" ';
        }
        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r($action_obj);
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
        // if ($data[0]['count']) {
        //     $msg        = 'already';
        // } else if (($data[0]['count'] == 0)) {

        $columns            = [
            "invoice_no"      => $invoice_no,
            "ledger_name"     => $ledger_name,
            
        ];


        $table_invoice = 'invoice_creation';
        $columns1            = [
            "invoice_no"      => $invoice_no,
            "ledger_name"     => $ledger_name,
            "ledger_no"       => $ledger_no,

        ];

        $update_where1       = "consignee_id = '".$consignee_unique_id ."' and po_unique_id='". $form_main_unique_id ."'  AND  invoice_auto_id ='".$invoice_auto_id."' AND is_delete='0'";
        //  and  product_unique_id='".$product_unique_id."'
        $action_obj1     = $pdo->update($table_invoice, $columns1, $update_where1);
        // print_r($action_obj1);
        // Update Begins
        // if ($invoice_id) {
        $update_where  = 'unique_id ="'.$invoice_id.'" and consignee_unique_id = "'.$consignee_unique_id .'" AND is_delete=0';
        $action_obj     = $pdo->update($table_invoice_main, $columns, $update_where);

        // }
        // print_r($action_obj);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
            if ($invoice_id) {
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

        // invoice create
    case 'invoice_create':
        $stock_id          = $_POST["stock_id"];
        $stock_date          = $_POST["stock_date"];
        $main_unique_id    = $_POST["main_unique_id"];
        $po_date         = $_POST["po_date"];
        $po_num         = $_POST["po_num"];
        $po_unique_id         = $_POST["po_unique_id"];
        $exe_name    = $_POST["exe_name"];
        $no_of_items         = $_POST["no_of_items"];
        $no_of_con         = $_POST["no_of_con"];
        $consignee_id          = $_POST["consignee_id"];
        $invoice_qty    = $_POST["invoice_qty"];
        $stock_qty         = $_POST["stock_qty"];
        $con_assign_qty         = $_POST["con_assign_qty"];
        $unit_price             = $_POST["unit_price"];
        $total_amount          = $_POST["total_amount"];
        $unique_id          = $_POST["unique_id"];
        $team_mem          = $_POST["team_mem"];
        
        
        
        
         $formatted_date = date("Y-m-d", strtotime($po_date));
         
        $stock_formatted_date = date("Y-m-d", strtotime($stock_date));

        // $batch_id          = $_POST["batch_id"];
        $update_where       = "";
        // $invoice_date = date('d-m-Y');
        // Update Ends
        $columns            = [
            "form_main_unique_id"     => $main_unique_id,
            "po_date"           => $formatted_date,
            "po_num"           => $po_num,
            "stock_id"           => $stock_id,
            "stock_date"           => $stock_formatted_date,
            "stock_qty"           => $stock_qty,
            "po_unique_id"           => $po_unique_id,
            "executive_name"     => $exe_name,
            "no_of_items"           => $no_of_items,
            "consignee_unique_id"     => $consignee_id,
            "invoice_qty"           => $invoice_qty,
            "invoice_value"           => $total_amount,
            "con_assign_qty"           => $con_assign_qty,
            "team_mem" => $team_mem,
            // "batch_id" => $batch_id,
            // "invoice_date"     => $invoice_date,
            "invoice_auto_id"    => invoice_no_get(),
            "unique_id"           => unique_id($prefix)
        ];

        $table_details_inv_main      = [
            $table_invoice_main,
            [
                'COUNT(unique_id) AS count',
                "invoice_qty as invoice_qty",
            ],

        ];

        // if($invoice_qty=='0'){
        //     $select_where_1       = "";
        //     $action_obj_1         = "";
        // }
        // else{
            // AND form_main_unique_id = '".$main_unique_id."'
            $select_where_1       = "is_delete = '0' ";
            $action_obj_1         = $pdo->select($table_details_inv_main,$select_where_1 ); 
        // }
        // $table_stock12 = 'stock_position_main';
        // $columns12           = [
        //     "billed_qty"     => $invoice_qty,
        //     // "status"     => 2,
        // ];
        // // $update_where1   = [
        // //         "form_main_unique_id"     => $main_unique_id,
        // //     ];
        // $update_where12       = "form_main_unique_id = '".$main_unique_id . "'";
        // $action_obj_update12     = $pdo->update($table_stock12, $columns12, $update_where12);
        // print_r($action_obj_1);die();

        if ($action_obj_1->status) {
        $status     = $action_obj_1->status;
        $data       = $action_obj_1->data;
        $error      = '';
        $sql        = $action_obj_1->sql;
        } else {
        $status     = $action_obj_1->status;
        $data       = $action_obj_1->data;
        $error      = $action_obj_1->error;
        $sql        = $action_obj_1->sql;
        $msg        = 'error';
        }
        
        // print_r($data[0]['count']);die();

    //  if($invoice_qty!='0'){
        // if($data[0]['count'] == $no_of_con) {
        // $msg        = 'already';
        // } else if ($data[0]['count'] <= $no_of_con) {
        $action_obj     = $pdo->insert($table_invoice_main, $columns);
        // }
        // }
        // print_r($action_obj);die();
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
    // }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];
        echo json_encode($json_array);
        break;

    // case 'invoice_sublist_add_update':
    //     $po_unique_id          = $_POST["po_unique_id"];
    //     $po_date    = $_POST["po_date"];
    //     // $batch_id = $_POST['batch_id'];
    //     $stock_id          = $_POST["stock_id"];
    //     $stock_date          = $_POST["stock_date"];
    //     $stock_qty          = $_POST["stock_qty"];
    //     $consignee_id          = $_POST["consignee_id"];
    //     $item_code_val    = $_POST["item_code_val"];
    //     $item_name_val          = $_POST["item_name_val"];
    //     $item_qty_val          = $_POST["item_qty_val"];
    //     $bill_qty_val          = $_POST["bill_qty_val"];
    //     $po_num          = $_POST["po_num"];
    //     $po_auto_id         = $_POST["po_auto_id"];
    //     $exe_name          = $_POST["executive_id"];
    //     $unit_price          = $_POST["unit_price"];
    //     $product_unique_id          = $_POST["product_unique_id"];
    //     $no_of_consignee = $_POST["no_of_consignee"];
    //     $no_of_items         = $_POST["no_of_items"];
    //     $unique_id          = $_POST["unique_id"];
    //     $update_billed_qty          = $_POST["update_billed_qty"];
    //     $total_assign_qty          = $_POST["total_assign_qty"];
    //     $total_invoice_qty          = $_POST["total_invoice_qty"];

    //     $delivery_due_days          = $_POST["delivery_due_days"];
        

    //     $net_value = $bill_qty_val * $unit_price;
    //     $update_where       = "";
    //     $date = date('Y-m-d');

        
    //     $table_con = "consignee_details_sub";

    //     if($_POST["total_invoice_qty"]==''){
    //         $total_invoice_qty_val= $_POST["total_assign_qty"];
    //     }
       
    //  else{
    //     $total_invoice_qty_val          = $_POST["total_invoice_qty"]+$_POST["bill_qty_val"];
    //  }
   
    //     if($total_assign_qty == $total_invoice_qty_val){

    //         // $invoice_qty= $invoice_qty+
    //         $columns_con           = [
    //             "inv_cons_status"           => 1,
               
    //         ];
    //         $update_where_con  = 'unique_id ="'.$consignee_id.'"';
    //         $update_con_sts     = $pdo->update($table_con, $columns_con, $update_where_con);
    //         // print_r($update_con_sts);
    //     }
case 'invoice_sublist_add_update':
        $po_unique_id          = $_POST["po_unique_id"];
        $po_date    = $_POST["po_date"];
        $stock_id          = $_POST["stock_id"];
        $stock_date          = $_POST["stock_date"];
        $stock_qty          = $_POST["stock_qty"];
        $consignee_id          = $_POST["consignee_id"];
        $item_code_val    = $_POST["item_code_val"];
        $item_name_val          = $_POST["item_name_val"];
        $item_qty_val          = $_POST["item_qty_val"];
        $bill_qty_val          = $_POST["bill_qty_val"];
        $po_num          = $_POST["po_num"];
        $po_auto_id         = $_POST["po_auto_id"];
        $exe_name          = $_POST["executive_id"];
        $unit_price          = $_POST["unit_price"];
        $product_unique_id          = $_POST["product_unique_id"];
        $no_of_consignee = $_POST["no_of_consignee"];
        $no_of_items         = $_POST["no_of_items"];
        $unique_id          = $_POST["unique_id"];
        $update_billed_qty          = $_POST["update_billed_qty"];
        $total_assign_qty          = $_POST["total_assign_qty"];
        $total_invoice_qty          = $_POST["total_invoice_qty"];

        $delivery_due_days          = $_POST["delivery_due_days"];
        $team_mem          = $_POST["team_mem"];
        
        
         $formatted_date = date("Y-m-d", strtotime($po_date));
        $stock_formatted_date = date("Y-m-d", strtotime($stock_date));

        

        $net_value = $bill_qty_val * $unit_price;
        $update_where       = "";
        $date = date('Y-m-d');

        
        $table_con = "consignee_details_sub";

    

    // new change
    // if($_POST["total_invoice_qty"]==''){
    //     $total_invoice_qty_val= $_POST["bill_qty_val"];
    // }
    //     else{
    //         $total_invoice_qty_val          = $_POST["total_invoice_qty"]+$_POST["bill_qty_val"];
    //     }
        
    //     if($total_assign_qty== $total_invoice_qty_val){
    //         // $invoice_qty= $invoice_qty+
    //         $columns_con           = [
    //             "inv_cons_status"           => 1,
    //         ];
    //         $update_where_con  = 'unique_id ="' . $consignee_id . '"';
    //         $update_con_sts     = $pdo->update($table_con, $columns_con, $update_where_con);
    //     }
        
        $get_bill_qty = get_bill_qty($consignee_id,$po_unique_id);
        // echo $get_bill_qty;
        if($total_assign_qty == $get_bill_qty){
             $columns_con           = [
                "inv_cons_status"           => 1,
            ];
            $update_where_con  = 'unique_id ="' . $consignee_id . '" and form_main_unique_id = "'.$po_unique_id.'"';
             $update_con_sts     = $pdo->update("consignee_details_sub", $columns_con, $update_where_con);
        }
        

        $columns1 = [
            'invoice_auto_id',
        ];
        // count taken start
        $table_details1      = [
            $table_invoice_main,
            [
                'COUNT(unique_id) AS count',
                // 'invoice_auto_id',
                'MAX(invoice_auto_id) AS last_invoice_auto_id',
                

            ],

        ];
        $select_where       = "is_delete = '0'";
        $order_by       = "id DESC";

        $action_obj         = $pdo->select($table_details1, $select_where, '', '', $order_by);
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
            // print_r("hlo");
            $msg        = 'already';
        } else if ($data[0]['count'] != 0) {
            // print_r("hi");
            $last_invoice_auto_ids = $data[0]['last_invoice_auto_id'];
            $table_invoice = 'invoice_creation';

            $columns            = [
                "po_unique_id"           => $po_unique_id,
                "team_mem" => $team_mem,
                "po_num"     => $po_num,
                "po_date"     => $formatted_date,
                "po_auto_id"     => $po_auto_id,
                "executive_name"     => $exe_name,
                "consignee_id"           => $consignee_id,
                "stock_id"               => $stock_id,
                "stock_date"           => $stock_formatted_date,
                "invoice_date"           => $date,
                "invoice_qty"           => $bill_qty_val,
                "unit_price"           => $unit_price,
                "invoice_qty_value"           => $net_value,
                "product_unique_id"           => $product_unique_id,
                "item_code"           => $item_code_val,
                "product"     => $item_name_val,
                "item_qty"           => $item_qty_val,
                "delivery_due_days"           => $delivery_due_days,
                "invoice_auto_id"          => $last_invoice_auto_ids,
                "unique_id"           => unique_id($prefix)
            ];
            

            if($_POST["update_billed_qty"]==''){
                $update_billed_qty= $_POST["bill_qty_val"];
            }
           
             else{
                $update_billed_qty          = $_POST["update_billed_qty"] + $_POST["bill_qty_val"];
             }

           
            $table_stock12 = 'stock_position_main';
            $columns12           = [
                "billed_qty"     => $update_billed_qty,
                // "status"     => 2,
            ];
          
            $update_where12       = "form_main_unique_id = '".$po_unique_id . "'";
            $action_obj_update12     = $pdo->update($table_stock12, $columns12, $update_where12);
            // print_r( $action_obj_update12 );
            
            // count taken start
            $table_invoice_main = 'invoice_creation';
            $table_details2      = [
                $table_invoice_main,
                [
                    'COUNT(unique_id) AS count',
                    'sum(invoice_qty) AS billed_qty',
                    // "invoice_qty as in_qty",
                    // "product_unique_id",
                ],

            ];
            // if($bill_qty_val== '0'){
            //     $select_where       = "";
            // }
            // else{
            $select_where       = "is_delete = '0' AND po_unique_id = '" . $po_unique_id . "'";
            // }
            // $group_by = 'consignee_id';
            // ,"","","","",$group_by

            $action_obj2         = $pdo->select($table_details2, $select_where);
            // print_r($action_obj2);
            if ($action_obj2->status) {
                $status     = $action_obj2->status;
                $data       = $action_obj2->data;
                $error      = '';
                $sql        = $action_obj2->sql;
            } else {
                $status     = $action_obj2->status;
                $data       = $action_obj2->data;
                $error      = $action_obj2->error;
                $sql        = $action_obj2->sql;
                $msg        = 'error';
            }

            // print_r($no_of_consignee);die();
            // $total_record_consignee = $no_of_consignee * $no_of_items;
            // print_r($total_record_consignee);die();
            
            // if ($data[0]['count'] == $total_record_consignee) {
                // $table_stock_po = 'stock_position_main';
                // $columns1            = [
                //     "status"     => 2,
                //     "billed_qty"     => $data[0]['billed_qty']
                // ];
                // // $update_where1   = [
                // //         "form_main_unique_id"     => $main_unique_id,
                // //     ];
                // $update_where1       = "form_main_unique_id = '" . $po_unique_id . "'";
                // $action_obj_update     = $pdo->update($table_stock_po, $columns1, $update_where1);


             
            // } 
 

            $action_obj1     = $pdo->insert($table_invoice, $columns);
        // print_r( $action_obj1);
   
            // status change
        }
        // Update Ends

        if ($action_obj1->status) {
            $status     = $action_obj1->status;
            $data       = $action_obj1->data;
            $error      = "";
            $sql        = $action_obj1->sql;
            if ($unique_id) {
                $msg        = "update";
            }
            // else if($po_unique_id){
            //       $msg        = "update";
            // }
            else {
                $msg        = "create";
            }
        } else {
            $status     = $action_obj1->status;
            $data       = $action_obj1->data;
            $error      = $action_obj1->error;
            $sql        = $action_obj1->sql;
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

        case "get_qty":

            $con_address           = $_POST['con_address'];
            $item_name               = $_POST['item_name'];
            $invoice_qty               = $_POST['invoice_qty'];
            $data       = [];
    
            // Query Variables
            $json_array     = "";
            $columns        = [
                "stock_qty as stock_qty",
    
            ];
    
            $table_details  = [
                "view_product_assign_con_details",
                $columns
            ];
    
            $where = "con_address='" . $con_address . "' and product='" . $item_name . "'  and  billed_qty='" . $invoice_qty . "'";
            $result         = $pdo->select($table_details, $where);
            // print_r($result);
            if ($result->status) {
    
                $json_array = [
                    "data"      => $result->data[0],
                    "status"    => $result->status,
                    "sql"       => $result->sql,
                    "error"     => $result->error,
                    "testing"   => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;
    




    case 'delete':

        $unique_id      = $_POST['unique_id'];
        // $columns        = [
        //     "is_delete"   => 1
        // ];
        $delete_where   = [
            "unique_id"     => $unique_id
        ];
        // $action_obj     = $pdo->update($table_sub, $columns, $update_where);
        $action_obj = $pdo->delete($table_sub, $delete_where);

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
        //  case 'district_type_option':
        // $state_name          = $_POST['state_name'];
        // $district_type_options  = district_option("",$state_name);
        // $district_type_options  = select_option($district_type_options,"Select District");
        // echo $district_type_options;

        case 'invoice_data_delete':
            $table_main="invoice_creation_main";
    
            $unique_id      = $_POST['unique_id'];
            $con_unique_id = $_POST['consignee_unique_id'];
            $form_main_unique_id      = $_POST['form_main_unique_id'];
            // $batch_id = $_POST['batch_id'];
            $invoice_auto_id      = $_POST['invoice_auto_id'];
            $columns        = [
                "is_delete"   => 1
            ];
            // $update_where   = [
            //     "unique_id"     => $unique_id
            // ];

            $columns_con        = [
                "inv_cons_status"   => 0
            ];
            
            $update_where_con       = "unique_id = '".$con_unique_id ."' and form_main_unique_id='". $form_main_unique_id ."' ";
            //  and batch_id = '".$batch_id."'
            
            $action_obj_con = $pdo->update("consignee_details_sub", $columns_con, $update_where_con);
            
    
            $table_invoice_creation="invoice_creation";
            $columns1            = [
                "is_delete"   => 1
    
            ];
           $update_where       = "unique_id = '".$unique_id ."' AND  invoice_auto_id = '".$invoice_auto_id ."'";
        //    print_r($update_where);
            $update_where1       = "invoice_auto_id = '".$invoice_auto_id ."' and po_unique_id='". $form_main_unique_id ."'";
            // print_r()
            //  and  product_unique_id='".$product_unique_id."'
            $action_obj1     = $pdo->update($table_invoice_creation, $columns1, $update_where1);
            // print_r($update_where1 );
    
            $action_obj     = $pdo->update($table_main, $columns, $update_where);
            
           
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

    //         case "get_ledger_no" :
    //             // $ledger_name = $_POST['ledger_name'];
    //             // $ledger_no_options = legder_inv_no('',$ledger_name);
    //             // $ledger_no_options = select_option_ledger($ledger_no_options,'Select', $ledger_name);
    //             //  return $ledger_no_options;
    //             echo $ledger_name = $_POST['ledger_name'];
    // $ledger_no_options = legder_inv_no('', $ledger_name);
    // // echo select_option_ledger($ledger_no_options, 'Select', '');
    // echo $id = $ledger_no_options[0]['unique_id'];
    // echo $ledger_nos = $ledger_no_options[0]['ledger_no'];



   
    //             break;
    case "get_ledger_no":
        header('Content-Type: application/json');
    
        $ledger_name = $_POST['ledger_name'] ?? '';
    
        $ledger_no_options = legder_inv_no('', $ledger_name);
    
        if (!empty($ledger_no_options) && isset($ledger_no_options[0])) {
            $response = [
                'status'     => true,
                'unique_id'  => $ledger_no_options[0]['unique_id'] ?? '',
                'ledger_no'  => $ledger_no_options[0]['ledger_no'] ?? '',
                'data'       => $ledger_no_options // full array if needed
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No ledger data found'
            ];
        }
    
        echo json_encode($response);
        break;
    

       

    default:


        break;
}
function select_option_ledger($options_array, $placeholder = 'Select', $selected_value = '') {
    $html = "<option value=''>$placeholder</option>";
    foreach ($options_array as $value => $label) {
        $selected = ($value == $selected_value) ? 'selected' : '';
        $html .= "<option value='$value' $selected>$label</option>";
    }
    return $html;
}

function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    // alert('hi');
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
                $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '" height="50px" width="50px"></a>';
            } else if ($cfile_name[1] == 'pdf') {
                // Open PDF in a new tab
                $image_view .= '<a href="uploads/invoice/' . $dc_file_name . '" target="_blank"><img src="uploads/invoice/pdf.png" height="50px" width="50px"></a>';
            } else if (($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/excel.png" height="50px" width="50px"></a>';
            } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/word.png" height="50px" width="50px"></a>';
            }
        }
    }
}

    return $image_view;
}
function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $ir_file_name;
    $file_names = explode(',', $ir_file_name);
    $image_view_1 = '';
    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_1 .= "&nbsp";
                } else {
                    $image_view_1 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $ir_file_name);
          if ($ir_file_name) {

    // Handle image files (jpg, png, jpeg)
    if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
        $image_view_1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '" height="50px" width="50px"></a>';
    } 
    
    // Handle PDF files and open them in a new tab
    else if ($cfile_name[1] == 'pdf') {
        $image_view_1 .= '<a href="uploads/invoice/' . $ir_file_name . '" target="_blank"><img src="uploads/invoice/pdf.png" height="50px" width="50px"></a>';
    }
    
    // Handle Excel files (xls, xlsx) and open them in a new tab
    else if (($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
        $image_view_1 .= '<a href="uploads/invoice/' . $ir_file_name . '" target="_blank"><img src="uploads/invoice/excel.png" height="50px" width="50px"></a>';
    }
    
    // Handle Word files (txt, docx, doc) and open them in a new tab
    else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
        $image_view_1 .= '<a href="uploads/invoice/' . $ir_file_name . '" target="_blank"><img src="uploads/invoice/word.png" height="50px" width="50px"></a>';
    }
}

        }
    }
    return $image_view_1;
}
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    // echo $file_invoice;
    $file_names = explode(',', $file_invoice);
    $image_view_2 = '';
    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_2 .= "&nbsp";
                } else {
                    $image_view_2 .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $file_invoice);
            if ($file_invoice) {

               if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
    $image_view_2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '" height="50px" width="50px"></a>';
    // You can leave the JavaScript print_view for images as is if it works fine for you.
} else if ($cfile_name[1] == 'pdf') {
    // Open PDF in a new tab
    $image_view_2 .= '<a href="uploads/invoice/' . $file_invoice . '" target="_blank"><img src="uploads/invoice/pdf.png" height="50px" width="50px"></a>';
} else if (($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
    // Open Excel file in a new tab
    $image_view_2 .= '<a href="uploads/invoice/' . $file_invoice . '" target="_blank"><img src="uploads/invoice/excel.png" height="50px" width="50px"></a>';
} else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
    // Open Word or text file in a new tab
    $image_view_2 .= '<a href="uploads/invoice/' . $file_invoice . '" target="_blank"><img src="uploads/invoice/word.png" height="50px" width="50px"></a>';
}

            }
        }
    }
    return $image_view_2;
}
function image_view_po($folder_name = "", $unique_id = "", $po_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $po_file);
    $image_view = '';
    if ($po_file) {
        foreach ($file_names as $file_key => $po_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $po_file);
            if ($po_file) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view_1(\'/'. $po_file . '\')"><img src="uploads/' . $folder_name . '/' . $po_file . '"  height="50px" width="50px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf_1(\'/'. $po_file . '\')"><img src="uploads/pdf.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_excel_1(\'/' . $po_file . '\')"><img src="uploads/excel.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $po_file . '\')"><img src="uploads/word.png"  height="50px" width="50px" ></a>';
                }
            }
        }
    }
    return $image_view;
}
function invoice_no_get()
{
    $date = date('Y');
    $st_date = substr($date, 2);
    $month = date('m');
    $datee = $st_date . $month;
    $servername = 'localhost';
    $username       = project_env('APP_DB_USERNAME', 'root');
$password       = project_env('APP_DB_PASSWORD');
$databasename   = "operation_team_beta";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connected successfully';
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM invoice_creation_main where `invoice_auto_id` LIKE 'INV%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;
    // if ( $res1 = $stmt->fetch( $stmt ) )
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['invoice_auto_id']);
        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r( $booking_no );
    }
    if ($booking_no == '')
        $booking_nos = 'INV-' . $datee . '-0001';
    elseif ($year != date('Y'))
        $booking_nos = 'INV-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'INV-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }
    return $booking_nos;
}

function get_bill_qty($con_unique_id,$po_unique_id){
    // print_r($unique_id);
    global $pdo;

    $table_name    = "invoice_creation_main";
    $where         = [];
    $table_columns = [
        "sum(invoice_qty) as invoice_qty",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$po_unique_id .'" and consignee_unique_id = "'.$con_unique_id.'"';
    $assign_qty_form = $pdo->select($table_details, $where);
    // print_r($assign_qty_form);
    if ($assign_qty_form->status) {
        return $assign_qty_form->data[0]['invoice_qty'];
    } else {
        print_r($assign_qty_form);
        return 0;
    }
}



