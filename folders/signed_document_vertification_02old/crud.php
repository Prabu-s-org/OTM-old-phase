<?php
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table             = "view_sign_document_vertification";
$table_sub         = "sign_doc_verification_detail";
$table_install    = "installation_details_sublist";
$table_po = "po_form";
// Include DB file and Common Functions
include '../../config/dbconfig.php';

include 'function.php';
// File Upload Library Call



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
$test               = "";






// For Developer Testing Purpose
switch ($action) {
    case 'createupdate':
        $po_num          = $_POST["po_num"];
        $po_date    = $_POST["po_date"];
        $con_contact_name          = $_POST["con_contact_name"];
        $con_address          = $_POST["con_address"];
        $con_unique_id          = $_POST["con_unique_id"];
        $invoice_no    = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $dc_received_status          = $_POST["dc_received_status"];
        $dc_signed_date          = $_POST["dc_signed_date"];
        $ir_status    = $_POST["ir_status"];
        $ir_signed_date          = $_POST["ir_signed_date"];
        $snr_status    = $_POST["snr_status"];
        $snr_signed_date          = $_POST["snr_signed_date"];
        $po_product_name          = $_POST["po_product_name"];
        // $approval          = $_POST["approval"];
       $sts1                  = $_POST["sts1"];
        $doc_chn    = $_POST["doc_chn"];
        $reject_reason          = $_POST["reject_reason"];
        $with_bg          = $_POST["with_bg"];
        $without_bg          = $_POST["without_bg"];
        $status_data          = $_POST["status"];
        $form_main_unique_id         = $_POST["form_main_unique_id"];
        $ins_unique_id          = $_POST["ins_unique_id"];
        $unique_id            = $_POST["unique_id"];
        $update_where       = "";
        
        if($status_data=='1'){
        $columns            = [
            "po_num"            => $po_num,
            "po_date"             => $po_date,
            "con_contact_name"           => $con_contact_name,
            "con_address"           => $con_address,
            "con_unique_id"           => $con_unique_id,
            "invoice_no"             => $invoice_no,
            "invoice_date"           => $invoice_date,
            "dc_received_status"           => $dc_received_status,
            "dc_signed_date"             => $dc_signed_date,
            "ir_status"           => $ir_status,
            "ir_signed_date"           => $ir_signed_date,
            "po_product_name"           => $po_product_name,
            // "approval"             => $approval,
            "ins_unique_id"           => $ins_unique_id,
            "with_bg"             => $with_bg,
            "without_bg"           => $without_bg,
            "status_app"           => $status_data,
            "reject_reason"           => $reject_reason,
            "doc_chn"       => $doc_chn,
            "is_delete"       => 1,
            'snr_status'          => $snr_status,
            'snr_signed_date'          => $snr_signed_date,
            "form_main_unique_id"           => $form_main_unique_id,
            "unique_id"           => unique_id($prefix)
        ];
    }
    else{


        $columns            = [
            "po_num"            => $po_num,
            "po_date"             => $po_date,
            "con_contact_name"           => $con_contact_name,
            "con_address"           => $con_address,
            "con_unique_id"           => $con_unique_id,
            "invoice_no"             => $invoice_no,
            "invoice_date"           => $invoice_date,
            "dc_received_status"           => $dc_received_status,
            "dc_signed_date"             => $dc_signed_date,
            "ir_status"           => $ir_status,
            "ir_signed_date"           => $ir_signed_date,
            "po_product_name"           => $po_product_name,
            // "approval"             => $approval,
            "ins_unique_id"           => $ins_unique_id,
            "with_bg"             => $with_bg,
            "without_bg"           => $without_bg,
            "status_app"           => $status_data,
            "reject_reason"           => $reject_reason,
            "doc_chn"       => $doc_chn,
            'snr_status'          => $snr_status,
            'snr_signed_date'          => $snr_signed_date,
            "form_main_unique_id"           => $form_main_unique_id,
            "unique_id"           => unique_id($prefix)
        ];
    }
        // $columns_1 = [
        //     "document_verification_status" => $status_data
        // ];
        // $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND
        //  invoice_no="'.$invoice_no.'"';
   
        // $action_obj_1     = $pdo->update($table_install, $columns_1, $update_where_1);

        $table_details = [
            $table_sub,
            [
                'COUNT(invoice_no) AS count',
    
            ]
        ];
        $select_where = 'invoice_no = "'.$invoice_no.'" AND ins_unique_id = "'.$ins_unique_id.'" AND is_delete = 0';
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
        // print_r($action_obj );die();
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0)) {
        if($sts1=='0'){
            // echo "hi";
            $columns_1 = [
                "document_verification_status" => $status_data
            ];
            $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND
             invoice_no="'.$invoice_no.'" AND documents_type1="'.$sts1.'"';
       
            $action_obj_1     = $pdo->update($table_install, $columns_1, $update_where_1);
        }
        //  if($dc_status=='DC'  &&  $snr_status=='SNR' && $ir_status=='IR'){
            // echo"h";
        else if($sts1=='IR') {
        $columns_1 = [
            "document_verification_status" => $status_data
        ];
        $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND
         invoice_no="'.$invoice_no.'"  AND unique_id = "'.$ins_unique_id.'"';
    
        $action_obj_1     = $pdo->update($table_install, $columns_1, $update_where_1);
    }
    else  {
        $columns_1 = [
            "document_verification_status" => $status_data
        ];
        $update_where_1 = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND
         invoice_no="'.$invoice_no.'"';
    
        $action_obj_1     = $pdo->update($table_install, $columns_1, $update_where_1);
    }
    

        if ($with_bg == 'on') {
            $columns_2 = [
                "proceed_bg" => 1
            ];
            $update_where_2 = 'unique_id="' . $form_main_unique_id . '"';
            $action_obj_2     = $pdo->update($table_po, $columns_2, $update_where_2);
        }


        $columns_dc = [
            "dc_status_bill" => 1
        ];
        $update_where_dc = 'unique_id="' . $form_main_unique_id . '"';
    
        $action_obj_dc     = $pdo->update($table_po, $columns_dc, $update_where_dc);
       
        if ($without_bg == 'on') {
            $columns_3 = [
                "proceed_bg" => 2
            ];
            $update_where_3 = 'unique_id="' . $form_main_unique_id . '"';
            $action_obj_3     = $pdo->update($table_po, $columns_3, $update_where_3);
        }
        
        // print_r( $action_obj_1 );die();
       
    // ========   mismatch data==============================================================================
    
    
       $table_inv="invoice_creation_main";

          if( $status_data=='1'){
          $columns_inv = [
            "sign_mismatch_status" => $status_data,  
            "installation_status" => 3,   
            "engineer_name" =>"",
            "eng_remarks" =>"",
            "installation_com_date" =>"",
        ];
        $update_where_inv = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND invoice_no="'.$invoice_no.'"';
              
        $action_obj_inv    = $pdo->update($table_inv, $columns_inv, $update_where_inv);
    }
    
    
    if($status_data=='1'){
    $columns_inv = [
        
      "sign_reject_reason" => $reject_reason,   
    ];
    $update_where_inv = 'form_main_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND
    invoice_no="'.$invoice_no.'"';    
    $action_obj_inv    = $pdo->update($table_inv, $columns_inv, $update_where_inv);
    
    }
// print_r($action_obj_inv);
    
    if($status_data=='1'){
    $columns_install = [
        "is_delete" => 1,
        "sign_mismatch_status" => $status_data,  
        "sign_reject_reason" => $reject_reason, 
    
    ];
    $update_where_install = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND invoice_no="'.$invoice_no.'"';
    $action_obj_install     = $pdo->update($table_install, $columns_install, $update_where_install);
    }

    if($status_data=='1'){
    $table_install_main="installation_details";
    $columns_install_main = [
        "is_delete" => 1,
        "sign_mismatch_status" => $status_data,  
        "sign_reject_reason" => $reject_reason, 
    ];
    $update_where_main = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND invoice_no="'.$invoice_no.'"';
    
    $action_obj_install_main     = $pdo->update($table_install_main, $columns_install_main, $update_where_main);
    }
    // print_r($action_obj_install_main);

    if($status_data=='1'){
    $table_dc_ir="dc_ir_doc_dispatch_details";
    $columns_dc_ir = [
        "is_delete" => 1,
        "sign_mismatch_status" => $status_data,  
        "sign_reject_reason" => $reject_reason, 
    ];
    $update_where_dc_ir = 'po_form_unique_id="' . $form_main_unique_id . '" and consignee_unique_id="'.$con_unique_id.'" AND invoice_no="'.$invoice_no.'"';
    
    $action_obj_dc_ir    = $pdo->update($table_dc_ir, $columns_dc_ir, $update_where_dc_ir);
    
    
    }
    // ========   mismatch data==============================================================================
    
$action_obj     = $pdo->insert($table_sub, $columns, $where);
        // }
//  print_r($action_obj);die();
if ($action_obj->status) {
    $status     = $action_obj->status;
    $data       = $action_obj->data;
    $error      = '';
    $sql        = $action_obj->sql;

    if ($unique_id) {
        $msg        = 'update';
    } else {
        $msg        = 'create';
    }
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
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];
        echo json_encode($json_array);
        break;
        
    case 'datatable':
        
        
        // print_r('test');die();
       $table_snr= 'view_sign_document_vertification_with_snr';
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $data        = [];
        // $from_date = date("d-m-Y", strtotime($_POST['from_date']));
        // $to_date = date("d-m-Y", strtotime($_POST['to_date']));
        $status = $_POST['status'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_sign_document_vertification_with_snr.department group by department_creation.unique_id) AS department",

            // "con_contact_name",
            "con_address	",
            "invoice_no",
            // "invoice_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",

            "dc_status",
            "dc_file",
            // "ir_status",
            // "ir_file",
            "snr_status",
            "snr_file",
            // "(select snr_pod_date from dc_ir_doc_dispatch_details where invoice_no = view_sign_document_vertification_with_snr.invoice_no AND is_delete=0  group by invoice_no ) AS snr_pod_date",
            "(SELECT DATE_FORMAT(snr_pod_date, '%d-%m-%Y') FROM dc_ir_doc_dispatch_details
                WHERE invoice_no = view_sign_document_vertification_with_snr.invoice_no  AND is_delete = 0 GROUP BY invoice_no ) AS snr_pod_date",
            
            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            "invoice_no",
        ];
        $table_details  = [
            $table_snr,
            $columns
        ];
        // if(document_verification_status)
       
       
        // $where       = "document_verification_status = '0' AND ir_status = '0' and  dc_dispatch_mode!='' and snr_dispatch_mode!=''";
       
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
        // print_R($result );
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
                // $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                if( $value['invoice_date']==''){
                    $value['invoice_date']='';
                }
                else{
                    // $orgDate1 = $value['invoice_date'];
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';
    
                }
               
                // $value['invoice_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['invoice_date'])) . '</span>';
                // $orgDate1 = $value['invoice_date'];
                // $value['invoice_date']  = '<span class="po_date">'.$value['invoice_date'] .'</span>';
              
                $dc_dispatch_mode =  $value['dc_dispatch_mode'];
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
                    $value['document_verification_status']   = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status']   = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status']   = "Verified";
                }
                // $document_verification_status = asort('document_verification_status');
                $btn_update         = btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);

                $where_21 = "consignee_unique_id = '" . $value['consignee_unique_id'] . "'";

                $columns_21    = [
                    'snr_status'
                ];

                $table_details_21   = [
                    $table,
                    $columns_21
                ];

                $result_values_21  = $pdo->select($table_details_21, $where_21);
                // print_r($result_values_12);die();
                $status_data       = $result_values_21->data;

                // if ($status_data[0]['snr_status'] != '' ) {
                //     $value['consignee_unique_id'] = $btn_update;
                // } 
                // else {
                //     $value['consignee_unique_id'] = '';
                // }
                if ($status_data[0]['snr_status'] != '' ) {
                    if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['consignee_unique_id'] =  $btn_update;
                    }
                    else{
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

    case 'datatable_with_ir':
        $table_ir='view_sign_document_vertification_with_ir';
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit         = $length;
        $data        = [];

        $status = $_POST['status'];
        $date = date('01-m-Y');
        $date1 = date('d-m-y');
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            // "con_contact_name",
            // "ledger_name",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_ir . ".ledger_name
            group by department_creation_sublist.unique_id) AS ledger_name",

            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_sign_document_vertification_with_ir.department) AS department",

            "con_address	",
            "invoice_no",
           
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            // "invoice_date",
            "dc_status",
            "dc_file",
            "ir_status",
            "ir_file",
            // "(select ir_pod_date from dc_ir_doc_dispatch_details where invoice_no = view_sign_document_vertification_with_ir.invoice_no AND is_delete=0  group by invoice_no ) AS ir_pod_date",
            "(SELECT DATE_FORMAT(ir_pod_date, '%d-%m-%Y') FROM dc_ir_doc_dispatch_details
            WHERE invoice_no = view_sign_document_vertification_with_ir.invoice_no  AND is_delete = 0 GROUP BY invoice_no ) AS ir_pod_date",
        
            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            "invoice_no",
            
        ];
        $table_details  = [
            $table_ir,
            $columns
        ];
       
        // $where      = "document_verification_status !='2' and dc_delivery_status='3' AND snr_dispatch_mode=''";
        // and snr_dispatch_mode=''

        if($_POST['from_date'] == ''){
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }
        
        if($_POST['to_date'] == ''){
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }
        
      
        // if($from_date && $to_date != '') {
            if($opt == '4') {
                
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
            } else if($opt == '5') {
                
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            }
       
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
        // Datatable Ordering 

        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(ir_pod_date, '%Y-%m-%d') $order_dir";
        $order_by       = datatable_sorting($order_column, $order_dir, $columns,);
       
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
        // print_r($result);
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
                $ins_unique_id = $value['ins_unique_id'];
                $status = $value['document_verification_status'];

                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                // $orgDate1 = $value['invoice_date'];
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                $dc_dispatch_mode =  $value['dc_dispatch_mode'];
                if ($value['dc_status'] != '0') {
                    $value['dc_status'] = 'Yes';
                } else {
                    $value['dc_status'] = '-';
                }
               
                 if($value['ir_status'] == '0' || $value['ir_status'] == 'undefined' || $value['ir_status'] == ''){
                    $value['ir_status'] = 'NA';
                }
                else {
                    $value['ir_status'] = 'YES';
                    }
                // if ($value['snr_status'] != '0') {
                //     $value['snr_status'] = 'Yes';
                // } else {
                //     $value['snr_status'] = '-';
                // }
                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installatsion", $value['consignee_unique_id'], $value['ir_file']);
                // $value['snr_file'] = image_view_2("installation", $value['consignee_unique_id'], $value['snr_file']);
                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);
                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status']   = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status']   = "Mismatch";

                } else if($value['document_verification_status'] == "2") {
                    $value['document_verification_status']   = "Verified";
                }
               
                $btn_update         = btn_update_7($folder_name, $value['consignee_unique_id'], $value['invoice_no'],$value['ins_unique_id']);
                // $btn_update         = '<a href="index.php?file=signed_document_verfication/update&unique_id=' . $value['ins_unique_id'] . '&invoice_no=' . $value['invoice_no'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                $btn_verified_view           = btn_view_signed_doc($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);
                
                
                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['consignee_unique_id'] = $btn_update;
                }else{
                
                    $value['consignee_unique_id'] = '';
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

    case 'mismatch_datatable':
       $table_sign="view_mismatch_installation";

        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit         = $length;
        $data        = [];
        // $from_date = date("d-m-Y", strtotime($_POST['from_date']));
        // $to_date = date("d-m-Y", strtotime($_POST['to_date']));
        $status = $_POST['status'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            // "ledger_name",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_sign . ".ledger_name GROUP by department_creation_sublist.unique_id) AS ledger_name",

            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_mismatch_installation.department) AS department",

            // "(Select con_contact_name From consignee_details_sub WHERE consignee_details_sub.unique_id=$table_sign.consignee_unique_id AND consignee_details_sub.is_delete='0')AS con_contact_name",
            // "(Select con_address From consignee_details_sub WHERE consignee_details_sub.unique_id=$table_sign.consignee_unique_id AND consignee_details_sub.is_delete='0')AS con_address",
            // "con_contact_name",
            "con_address	",
            "invoice_no",
            "invoice_date",
            "dc_file",
            "ir_file",
            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id"
        ];
        $table_details  = [
            $table_sign,
            $columns
        ];
        $where       = "document_verification_status = '1'";

        if($_POST['from_date'] == ''){
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }
        
        if($_POST['to_date'] == ''){
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }
        
      
        // if($from_date && $to_date != '') {
            if($opt1 == '40') {
                // $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
 
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
            } else if($opt1 == '50') {
                
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            }
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // AND invoice_date >= '".$date."' AND invoice_date <= '".$date1."' 
        // if ($_POST['status'] == '') {
        //     $where = " document_verification_status ='0'";
        // } else if ($_POST['status'] == '0') {
        //     $where = " document_verification_status ='0'";
        // } else if (($from_date != '') && ($to_date != '') && ($_POST['status'] != '0')) {
        //     $where = " invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' and document_verification_status ='" . $_POST['status'] . "' ";
        // }
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column, $order_dir, $columns,);
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
        if ($result->status) {
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                $orgDate1 = $value['invoice_date'];
                $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);
                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);
                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status']   = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status']   = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status']   = "Verified";
                }
                // $document_verification_status = asort('document_verification_status');
                // $btn_update         = btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no']);
                // $btn_update         =  btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);
                
                // $btn_delete         = btn_delete($folder_name,$value['form_main_unique_id']);
                // $value['consignee_unique_id'] = $btn_update;
                // $value['consignee_unique_id'] = $btn_update.$btn_delete;
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

    case 'verified_datatable':
       $table_ver= 'view_sign_document_vertification_verfied';
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        
        $limit         = $length;
        $data        = [];
        // $from_date = date("d-m-Y", strtotime($_POST['from_date']));
        // $to_date = date("d-m-Y", strtotime($_POST['to_date']));
        // $invoice_no = $_POST['invoice_no'];
        $status = $_POST['status'];
        $date = date('01-m-Y');
        // 		$date = date("d-m-Y", strtotime($dates));
        $date1 = date('d-m-y');
        // 		$date1 = date("d-m-Y", strtotime($dates1));
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            // "ledger_name",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_ver . ".ledger_name GROUP by department_creation_sublist.unique_id) AS ledger_name",

            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_sign_document_vertification_verfied.department) AS department",

            // "con_contact_name",
            "con_address	",
            "invoice_no",
            // "invoice_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",

            "dc_file",
            "ir_file",
            "document_verification_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "ins_unique_id",
            // "invoice_no"
        ];
        $table_details  = [
            $table_ver,
            $columns
        ];
        // $where       = "document_verification_status = '2'";
       
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column, $order_dir, $columns,);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
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
        // print_R($result);die();
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
                $ins_unique_id = $value['ins_unique_id'];
                $status=$value['document_verification_status'];
                
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                // $value['invoice_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['invoice_date'])) . '</span>';
                // $orgDate1 = $value['invoice_date'];
                $value['invoice_date']  = '<span class="po_date">'.$value['invoice_date'] .'</span>';
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['dc_file'] = image_view("installation", $value['consignee_unique_id'], $value['dc_file']);
                $value['ir_file'] = image_view_1("installation", $value['consignee_unique_id'], $value['ir_file']);
                // if($value['document_verification_status'] == "1") {
                //     $value['document_verification_status']   = "Pending";
                // $value['document_verification_status'] = asort($value['document_verification_status']);
                if ($value['document_verification_status'] == "0") {
                    $value['document_verification_status']   = "Pending";
                } else if ($value['document_verification_status'] == "1") {
                    $value['document_verification_status']   = "Mismatch";
                } else if ($value['document_verification_status'] == "2") {
                    $value['document_verification_status']   = "Verified";
                }

                // $document_verification_status = asort('document_verification_status');
                // $btn_update         = btn_update($folder_name, $value['ins_unique_id']);
                $btn_update         =  btn_update_7($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);
                $btn_verified_view           = btn_view_signed_doc($folder_name, $value['consignee_unique_id'],$value['invoice_no'],$value['ins_unique_id']);
             
                // if(in_array('5f88082b25ec031952', $action_ids)){
                //     $value['consignee_unique_id'] = $btn_update;
                // }else{
               
                //     $value['consignee_unique_id'] = '';
                // }

 // new change
 if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))){
    if($status=='2'){
    // if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){

    // print_r($value['stock_qty']==$value['invoice_qty']);die();
    $value['consignee_unique_id'] = $btn_verified_view;
    }

else{

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
            case 'user_permission_2':
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
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="50px" width="50px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_excel(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="50px" width="50px" ></a>';
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
                    $image_view_1 .= '<a href="javascript:print_view(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="50px" width="50px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_1 .= '<a href="javascript:print_pdf(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_1 .= '<a href="javascript:print_excel(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_1 .= '<a href="javascript:print(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="50px" width="50px" ></a>';
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
                    $image_view_2 .= '<a href="javascript:print_view(\'/' . $snr_file . '\')"><img src="uploads/' . $folder_name . '/' . $snr_file . '"  height="50px" width="50px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_2 .= '<a href="javascript:print_pdf(\'/' . $snr_file . '\')"><img src="uploads/installation/pdf.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_2 .= '<a href="javascript:print_excel(\'/' . $snr_file . '\')"><img src="uploads/installation/excel.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_2 .= '<a href="javascript:print(\'/' . $snr_file . '\')"><img src="uploads/installation/word.png"  height="50px" width="50px" ></a>';
                }
            }
        }
    }
    return $image_view_2;
}

