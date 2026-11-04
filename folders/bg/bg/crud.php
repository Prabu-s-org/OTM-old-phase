<?php
require_once __DIR__ . '/../../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table             = "view_bg_list_final";
$table1             = "bg_creation_main";
$table_invoice_main = 'invoice_creation_main';
$table_sign_doc = 'sign_doc_verification_detail';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
// File Upload Library Call
$fileUploadPath = $fileUploadConfig->get('upload_folder');
// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set('upload_folder', $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
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
   
    case 'datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        // $status    = $_POST['status'];
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
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            // "invoice_date",
            // "(select product from product_details_sub WHERE product_details_sub.unique_id=view_bg_list_final.po_product_name) as product",
            "po_product_name",
            // "bg_percentage",
            "invoice_qty",
            "invoice_value",
            "bg_month",
            // "bg_month",
            "bg_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        $where = " bg_status='0'";
        
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
                $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

				$orgDate1 = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                // $value['is_active'] = is_active_show($value['is_active']);
                // $btn_update         = btn_update($folder_name,$value['consignee_unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['consignee_unique_id']);
                // $value['consignee_unique_id'] = '<a href="index.php?file=bg/update1&unique_id=' . $value['form_main_unique_id'] .'&invoice_no=' . $value['invoice_no'] .'&ins_unique_id=' . $value['ins_unique_id'] .'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>';
                // $value['form_main_unique_id'] = '<input class="" type="checkbox" id="formCheck6" >';
                if ($value['bg_status'] == "0") {
                    $value['bg_status']   = "Pending";
                } else {
                    $value['bg_status']   = "Complete";
                }
                if(in_array('5f88085e1fcea66282', $action_ids)){
                    $value['consignee_unique_id'] = '<a href="index.php?file=bg/update1&unique_id=' . $value['form_main_unique_id'] .'&invoice_no=' . $value['invoice_no'] .'&ins_unique_id=' . $value['ins_unique_id'] .'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>';

                }else{
                //  if(in_array('5f8808504271036738', $action_ids)){
                //     $value['unique_id'] = $btn_delete;
                // }
                // else{
                    $value['consignee_unique_id'] = '';
                }
                // $value['unique_id'] = $btn_update . $btn_delete;
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
        
    case 'bg_create_datatable':
        // print_r("hii");
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $data        = [];
        $po_num     = $_POST['po_num'];
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "form_main_unique_id",
            "'' as  s_no",
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_no",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            // "invoice_date",
            "invoice_value",
            "bg_status",
            "po_product_name",
            "bg_month",
            "bg_percentage",
            "invoice_qty",
            "consignee_unique_id",
            "ins_unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];
        $where = " bg_status = 0";
        if ($po_num != '') {
            $where .= " AND form_main_unique_id = '" . $po_num . "'";
        }
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
        // $group_by = 'invoice_no';
        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r('hi');die();
        $total_records  = total_records();
        if ($result->status) {
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

$orgDate1 = $value['invoice_date'];  
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                // $value['is_active'] = is_active_show($value['is_active']);
                // $btn_update         = btn_update($folder_name,$value['consignee_unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['consignee_unique_id']);
                $form_main_unique_id = $value['form_main_unique_id'];
                $po_num = $value['po_num'];
                $po_date = $value['po_date'];
                $con_name = $value['con_contact_name'];
                $consignee_unique_id = $value['consignee_unique_id'];
                $con_address = $value['con_address'];
                $invoice_no = $value['invoice_no'];
                $invoice_qty = $value['invoice_qty'];
                $invoice_value = $value['invoice_value'];
                $po_product_name = $value['po_product_name'];
                $bg_month = $value['bg_month'];
                $bg_percentage = $value['bg_percentage'];
                $invoice_date = $value['invoice_date'];
                $ins_unique_id = $value['ins_unique_id'];
                
                $value['form_main_unique_id'] = '<input class="myCheck" type="checkbox" id="invoice_check" name="invoice_check[]">
                <input type="hidden" id="form_unique_id" name="form_unique_id[]" value="' . $form_main_unique_id . '">  
                <input type="hidden" id="po_num_val" name="po_num_val[]" value="' . $po_num . '">  
				<input type="hidden" id="po_date" name="po_date[]" value="' . $po_date . '">  
				<input type="hidden" id="con_name" name="con_name[]" value="' . $con_name . '">  
				<input type="hidden" id="con_unique_id" name="con_unique_id[]" value="' . $consignee_unique_id . '">  
				<input type="hidden" id="con_address" name="con_address[]" value="' . $con_address . '">  
				<input type="hidden" id="invoice_no" name="invoice_no[]" value="' . $invoice_no . '">  
				<input type="hidden" id="invoice_qty" name="invoice_qty[]" value="' . $invoice_qty . '">  
				<input type="hidden" id="invoice_value" name="invoice_value[]" value="' . $invoice_value . '">  
                <input type="hidden" id="po_product_name" name="po_product_name[]" value="' . $po_product_name . '">  
				<input type="hidden" id="bg_month" name="bg_month[]" value="' . $bg_month . '">
                <input type="hidden" id="invoice_date" name="invoice_date[]" value="' . $invoice_date . '">
				<input type="hidden" id="bg_per" name="bg_per[]" value="' . $bg_percentage . '">
                <input type="hidden" id="ins_unique_id" name="ins_unique_id[]" value="' . $ins_unique_id . '">';
                $value['unique_id'] = $btn_update . $btn_delete;
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

    case 'bg_main_update':

        $bg_auto_id        = $_POST["bg_auto_id"];
        $form_unique_id         = $_POST["form_unique_id"];
        $unique_id    = $_POST["unique_id"];
        $bg_num          = $_POST["bg_num"];
        $bg_date         = $_POST["bg_date"];
        $validity_date          = $_POST["validity_date"];
        $validity_end_date           = $_POST["validity_end_date"];
        $bank_name           = $_POST["bank_name"];
        $bg_month           = $_POST["bg_month"];

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
        $bg_no       = $_POST['bg_no'];
        $parts = explode('/', $bg_no);
        // Get the last value from the array
        $bg_no_value = end($parts);
        
        $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        $allowedMimeTypes = array(
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );
        $file = $_FILES['test_file']['name'];
            $extension = pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION);
                $tem_name = $bg_no_value .".". $extension;
                $targetDir = '../../uploads/bg/';
        
               
        
                if (move_uploaded_file($_FILES['test_file']['tmp_name'], '../../uploads/bg/' . $tem_name)) {
                    // Set filenames
                    $file_names = $tem_name;
                    $file_org_names = $_FILES['test_file']['name'];
                //     echo "File uploaded successfully.";
                }
        // print_r($file_org_names);die();
        // 1st image close
        $update_where       = "";
        if (($file_names) && ($file_org_names)) {
            $columns            = [
                "bg_num"      => $bg_num,
                "bg_date"     => $bg_date,
                "bg_validity_date"     => $validity_date,
                "bg_validity_end_date"           => $validity_end_date,
                "bank_name"     => $bank_name,
                "status"        => 1,
                "bank_attach_file"               => $file_names,
                "bank_attach_file_org_name"     => $file_org_names,
            ];
        } else {
            $columns            = [
                "bg_num"      => $bg_num,
                "bg_date"     => $bg_date,
                "bg_validity_date"     => $validity_date,
                "bg_validity_end_date"           => $validity_end_date,
                "bank_name"     => $bank_name,
                "status"        => 1,
            ];
        }
        $columns1            = [
            "bg_num"      => $bg_num,
            "bg_date"     => $bg_date,
            "bg_validity_date"     => $validity_date,
            "bg_validity_end_date"           => $validity_end_date,
            "bg_month"           => $bg_month,
           
        ];

        $tabel_sub="bg_creation_sub";
        // $update_where1  = [
        //     // "unique_id"     => $unique_id,
        //     "form_main_unique_id"     => $form_unique_id,
        //     "invoice_no"     => $invoice_no,

        // ];
        $update_where1='form_main_unique_id="'.$form_unique_id.'" AND bg_auto_id="'.$bg_auto_id.'"';
        $action_obj1     = $pdo->update($tabel_sub, $columns1, $update_where1);
// print_R($action_obj1 );die();
        $update_where   = [
            "unique_id"     => $unique_id,
            "form_main_unique_id"     => $form_unique_id
        ];
        $action_obj     = $pdo->update($table1, $columns, $update_where);
        // print_r($action_obj);die();
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            if ($unique_id) {
                $msg        = "update";
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
    case 'bgmain_createupdate':
        $form_unique_id         = $_POST["form_unique_id"];
        $po_num    = $_POST["po_num"];
        $po_date          = $_POST["po_date"];
        $invoice_nos         = $_POST["invoice_nos"];
        $po_product_name          = $_POST["po_product_name"];
        $bg_month           = $_POST["bg_month"];
        $bg_per           = $_POST["bg_per"];
        $invoice_value          = $_POST["invoice_value"];
        $invoice_qty         = $_POST["invoice_qty"];
        $invoice_date        = $_POST["invoice_date"];
        $ins_unique_id        = $_POST["ins_unique_id"];
        $update_where       = "";
        $bg_value = $invoice_value * ($bg_per / 100);
        $columns            = [
            "form_main_unique_id"      => $form_unique_id,
            "po_num"     => $po_num,
            "po_date"           => $po_date,
            "invoice_no"           => $invoice_nos,
            "bg_product_name"     => $po_product_name,
            "bg_month"           => $bg_month,
            "bg_percentage"           => $bg_per,
            "bg_value"           => $bg_value,
            "invoice_value"           => $invoice_value,
            "invoice_qty"     => $invoice_qty,
            "invoice_date"     => $invoice_date,
            "ins_unique_id"     => $ins_unique_id,
            "bg_auto_id"           => bg_no_get(),
            "status"        => 0,
            "unique_id"           => unique_id($prefix)
        ];
        // Update Begins
        // if($unique_id) {
        //     unset($columns['unique_id']);
        //     $update_where   = [
        //         "unique_id"     => $unique_id
        //     ];
        //     $action_obj     = $pdo->update($table,$columns,$update_where);
        // // Update Ends
        // } else {
            $table_details = [
                $table1,
                [
                    'COUNT(unique_id) AS count'
                ]
            ];
            $select_where = 'is_delete = 0 AND ins_unique_id ="' . $ins_unique_id .'"';
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
            // print_r($action_obj );die();
            if ($data[0]['count']) {
                $msg = 'already';
            } else if (($data[0]['count'] == 0)) {

        // Insert Begins
        $action_obj     = $pdo->insert($table1, $columns);
        // print_r($action_obj);
        // die();
        // Insert Ends
        // }
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            // if ($unique_id) {
            //     $msg        = "update";
            // } else {
            $msg        = "create";
            // }
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

        case 'bg_sub_addupdate':
            $form_unique_id          = $_POST["form_unique_id"];
            $po_num          = $_POST["po_num"];
            $po_date    = $_POST["po_date"];
            $con_name         = $_POST["con_name"];
            $con_address          = $_POST["con_address"];
            $con_unique_id          = $_POST["con_unique_id"];
            $invoice_no          = $_POST["invoice_no"];
            $invoice_qty    = $_POST["invoice_qty"];
            $invoice_val          = $_POST["invoice_val"];
            $invoice_date        = $_POST["invoice_date"];
            $po_product_name          = $_POST["po_product_name"];
            $ins_unique_id           = $_POST["ins_unique_id"];
            $bg_per           = $_POST["bg_per"];
            $bg_month           = $_POST["bg_month"];
            $update_where       = "";
            $date = date('d-m-Y');
            // count taken start
            $table_details1      = [
                $table1,
                [
                    'COUNT(unique_id) AS count',
                    'MAX(bg_auto_id) AS last_bg_auto_id',
                    
                ],
            ];
            $select_where       = "is_delete = '0'";
            $order_by       = "id DESC";
            //  AND form_main_unique_id = '" . $form_unique_id . "'
            
            $action_obj         = $pdo->select($table_details1, $select_where, '', '', $order_by);
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
            if ($data[0]['count'] != 0) {
                $last_bg_auto_id = $data[0]['last_bg_auto_id'];
                // print_r($last_bg_auto_id );die();
                $table_bg_sub = 'bg_creation_sub';
                $columns            = [
                    "form_main_unique_id"   => $form_unique_id,
                    "po_num"     => $po_num,
                    "po_date"     => $po_date,
                    "con_unique_id"     => $con_unique_id,
                    "con_name"          => $con_name,
                    "con_location"      => $con_address,
                    "invoice_no"        => $invoice_no,
                    "invoice_qty"       => $invoice_qty,
                    "invoice_value"     => $invoice_val,
                    "invoice_date"     => $invoice_date,

                    "bg_month"           => $bg_month,
                
                    "bg_product_name"     => $po_product_name,
                    "ins_unique_id"           => $ins_unique_id,
                    "bg_percentage"           => $bg_per,
                    "status"           => 1,
                    "bg_auto_id"   => $last_bg_auto_id,
                    "unique_id"      => unique_id($prefix)
                ];

                $columns1            = [
                    "bg_status"     => 1,
                ];
                //    form_main_unique_id = '".$form_unique_id."' AND
                $update_where1       = "invoice_no = '" . $invoice_no . "' AND form_main_unique_id = '" . $form_unique_id . "'";
                $action_obj_update     = $pdo->update($table_invoice_main, $columns1, $update_where1);

                $columns2            = [
                    "bg_status"     => 1,
                ];
                //    form_main_unique_id = '".$form_unique_id."' AND
                $update_where2      = "invoice_no = '" . $invoice_no . "' AND form_main_unique_id = '" . $form_unique_id . "' AND ins_unique_id='" . $ins_unique_id . "'";
                $action_obj_update2     = $pdo->update($table_sign_doc , $columns2, $update_where2);
                // print_r($action_obj_update2);



                $action_obj1     = $pdo->insert($table_bg_sub, $columns);
                // print_r($action_obj1);
                // status change
                // count taken start
                //         $table_invoice_main = 'invoice_creation_main';
                //         $table_details2      = [
                //         $table_invoice_main,
                //         [
                //             'COUNT(unique_id) AS count',
                //             'sum(invoice_qty) AS billed_qty',
                //         ],
                //     ];
                //     $select_where       = "is_delete = '0' AND form_main_unique_id = '".$po_unique_id."'";
                //     // $group_by = 'consignee_id';
                //     // ,"","","","",$group_by
                // $action_obj2         = $pdo->select($table_details2,$select_where);
                // if ($action_obj2->status) {
                //     $status     = $action_obj2->status;
                //     $data       = $action_obj2->data;
                //     $error      = '';
                //     $sql        = $action_obj2->sql;
                // } else {
                //     $status     = $action_obj2->status;
                //     $data       = $action_obj2->data;
                //     $error      = $action_obj2->error;
                //     $sql        = $action_obj2->sql;
                //     $msg        = 'error';
                // }
                // $total_record_consignee = $stock_qty * $no_of_items;
                // if($data[0]['billed_qty'] == $total_record_consignee){
                //      $table_stock_po = 'stock_position_main';
                //         $columns1            = [
                //             "status"     => 2,
                //              "billed_qty"     => $data[0]['billed_qty']
                //         ];
                //         // $update_where1   = [
                //         //         "form_main_unique_id"     => $main_unique_id,
                //         //     ];
                //             $update_where1       = "form_main_unique_id = '".$po_unique_id."'";
                //             $action_obj_update     = $pdo->update($table_stock_po,$columns1,$update_where1);
                // }
                // else{
                //  $table_stock_po = 'stock_position_main';
                //     $columns1            = [
                //          "billed_qty"     => $data[0]['billed_qty'],
                //         // "status"     => 2,
                //     ];
                //         $update_where1       = "form_main_unique_id = '".$po_unique_id."'";
                //         $action_obj_update     = $pdo->update($table_stock_po,$columns1,$update_where1);
                // }
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

            
    case 'bg_update_datatable':
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
            "'' as s_no",
            "bg_month",
            "bg_auto_id",
            "invoice_no",
            // "invoice_qty",
            "invoice_value",
            "bg_value",
            "status",
            "form_main_unique_id",
            "unique_id"
        ];
        $table_details  = [
            $table1,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // $where = " is_delete = '0' and status='1' ";
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
                $arrayOfValues = explode(",", $value['invoice_no']);
                $count = count($arrayOfValues);
                $value['invoice_no'] = $count;
                if ($value['status'] == "0") {
                    $value['status']   = "Pending";
                } else {
                    $value['status']   = "Complete";
                }
                $value['bg_auto_id'] = '<p id="export_1" name="export_1" onclick="excel(this.value ,\'' .  $value['bg_auto_id'] . '\')">' . $value['bg_auto_id'] . '</p>';
                // $value['form_main_unique_id'] = '<a href="index.php?file=bg/create1&form_unique_id=' . $value['form_main_unique_id'] . '&unique_id=' . $value['unique_id'] . '"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
                // $btn_update= '<a href="po_form_unique_id='.$value['po_form_unique_id'].'" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl1"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
                $btn_update         = btn_update($folder_name, $value['consignee_unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['unique_id']);
                // $value['consignee_unique_id'] = $btn_update;
                
                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['form_main_unique_id']  = '<a href="index.php?file=bg/create1&form_unique_id=' . $value['form_main_unique_id'] . '&unique_id=' . $value['unique_id'] . '"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
               
                }else{
                //  if(in_array('5f8808504271036738', $action_ids)){
                //     $value['unique_id'] = $btn_delete;
                // }
                // else{
                    $value['form_main_unique_id'] = '';
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
        // get second tab
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
function bg_no_get()
{

    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "aed_elcot";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM bg_creation_main where `bg_auto_id` LIKE 'BG%' order by unique_id desc");
    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['bg_auto_id']);
        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($booking_no == '')
        $booking_nos = 'BG-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $booking_nos = 'BG-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'BG-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }
    return $booking_nos;
    // print_r($booking_nos);
}



