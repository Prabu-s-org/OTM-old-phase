<?php

// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = "view_payment_entry_list";
$table_claim="view_payment_entry_list_1";
$table_main             = "view_bill_submission_main_table";
$table_sub   = "view_bill_submission_sub_table";
$table_main_1             = "bill_submission_main_table";
$table_sub_1   = "bill_submission_sub";
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

        $payement_receive          = $_POST["payement_receive"];
        //$under_user_type    = $_POST["under_user_type"];
        $payment_status          = $_POST["payment_status"];
        $payment_date          = $_POST["payment_date"];
		$ld_amount          = $_POST["ld_amount"];
		$ld_days          = $_POST["ld_days"];
        $bill_no       = $_POST["bill_no"];
        $claim_amount       = $_POST["claim_amount"];
        
      $gst = $_POST["gst"];
      $gst_value = $_POST["gst_value"];
      $tds = $_POST["tds"];
      $tds_value = $_POST["tds_value"];
       $ld = $_POST["ld"];

       $tran_amt = $_POST["tran_amt"];
       $rem_amt = $_post["rem_amt"];
        $unique_id          = $_POST["unique_id"];

        $update_where       = "";
        $myinv_no       = $_POST['my_inv_no'];
        $parts = explode('/', $myinv_no);
        // Get the last value from the array
        $myinv_no_value = end($parts);
        // $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        // $allowedMimeTypes = array(
        //     'application/pdf' => 'pdf',
        //     'image/jpeg' => 'jpg',
        //     'image/png' => 'png',
        //     'application/vnd.ms-excel' => 'xls',
        //     'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        // );
        // $file = $_FILES['test_file']['name'];
        //     $extension = pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION);
        //         $tem_name = "elcot_entry-".$myinv_no_value . "-DC." . $extension;
        //         $targetDir = '../../uploads/elcot_entry/';
        
               
        
        //         if (move_uploaded_file($_FILES['test_file']['tmp_name'], '../../uploads/elcot_entry/' . $tem_name)) {
        //             // Set filenames
        //             $file_names = $tem_name;
        //             $file_org_names = $_FILES['test_file']['name'];
        //         //     echo "File uploaded successfully.";
        //         }
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = "Payment-".$myinv_no_value . '.pdf';

            move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/payment/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
        if (($file_names) && ($file_org_names)) {
            $columns            = [
                "payement_receive"           => $payement_receive,
                "payment_status"     => $payment_status,
                "payment_date"           => $payment_date,
				"ld_amount"           => $ld_amount,
				"ld_days"           => $ld_days,
                // "claim_percentage"           => $claim_amount,
                'file_name'           => $file_names,
                'file_org_name'           => $file_org_names,


            ];
        } else {
            $columns            = [
                "payement_receive"           => $payement_receive,
                "payment_status"     => $payment_status,
                "payment_date"           => $payment_date,
				"ld_amount"           => $ld_amount,
				"ld_days"           => $ld_days,
               


            ];
        }
         if (($file_names) && ($file_org_names)) {
        $columns_1 = [
            "payement_receive"           => $payement_receive,
            "payment_status" => $payment_status,
            "payment_date"           => $payment_date,
			"ld_amount"           => $ld_amount,
			"ld_days"           => $ld_days,
            
            "claim_percentage"           => $claim_amount,
            'file_name'           => $file_names,
            'file_org_name'           => $file_org_names,
            'gst'    => $gst,
            'gst_value'  => $gst_value,
                'tds' =>  $tds,
                'tds_value' => $tds_value,
                'ld'  => $ld,
                'tran_amt' => $tran_amt,
                'rem_amt' => $rem_amt,
        ];
    }
    else{
        $columns_1 = [
            "payement_receive"           => $payement_receive,
            "payment_status" => $payment_status,
            "payment_date"           => $payment_date,
			"ld_amount"           => $ld_amount,
			"ld_days"           => $ld_days,
            "claim_percentage"           => $claim_amount,
            "gst"    => $gst,
        "gst_value"  => $gst_value,
      "tds" =>  $tds,
       "tds_value" => $tds_value,
       "ld"   => $ld,
       'tran_amt' => $tran_amt,
                'rem_amt' => $rem_amt,
        ];
    }
        $update_where_1 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no . '"';

        // print_r($update_where_123);die();
        $action_obj_1 = $pdo->update($table_sub_1, $columns_1, $update_where_1);
        // print_r($action_obj_1);

// if($claim_amount=='75' || $claim_amount=='20' || $claim_amount=='95'){
//     $columns_3 = [
//         "claim_status"           => 1,   
//     ];
//     $update_where_3 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no .'"';

//     // print_r($update_where_123);die();
//     $action_obj_3 = $pdo->update($table_sub, $columns_3, $update_where_3);

// }
// if($claim_amount=='75' || $claim_amount=='20'){
//     $columns_3 = [
//         "claim_status"           => 2,   
//     ];
//     $update_where_3 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no .'"';

//     // print_r($update_where_123);die();
//     $action_obj_3 = $pdo->update($table_sub, $columns_3, $update_where_3);

// }
// if($claim_amount=='75' || $claim_amount=='25' || $claim_amount=='5'){
//     $columns_3 = [
//         "claim_status"           => 2,   
//     ];
//     $update_where_3 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no .'"';

//     // print_r($update_where_123);die();
//     $action_obj_3 = $pdo->update($table_sub, $columns_3, $update_where_3);

// }
// if( $claim_amount=='100'){
//     $columns_3 = [
//         "claim_status"           => 3,   
//     ];
//     $update_where_3 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no .'"';

//     // print_r($update_where_123);die();
//     $action_obj_3 = $pdo->update($table_sub, $columns_3, $update_where_3);

// }
// if($claim_amount=='100'){
//     $columns_2 = [
//         "claim_status"           => 2,   
//     ];
//     $update_where_2 = 'bill_form_unique_id="' . $unique_id . '" and bill_no="' . $bill_no .'"';

//     // print_r($update_where_123);die();
//     $action_obj_2 = $pdo->update($table_sub, $columns_2, $update_where_2);

// }


        // Update Begins
        if ($unique_id) {

            unset($columns['bill_form_main_unique_id']);

            // $update_where   = [
            //     "bill_form_unique_id"     => $unique_id,
            // ];
            $update_where = "bill_form_main_unique_id='" . $unique_id . "' AND  bill_no ='" . $bill_no . "' ";

            $action_obj     = $pdo->update($table_main_1, $columns, $update_where);
            // print_r($action_obj);

            // Update Ends
        }
        // print_r($action_obj);die();
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = "update";
            }
            // else {
            //     $msg        = "create";
            // }
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


        case 'bill_cancel_add_update':

          
            $bill_no       = $_POST["bill_no"];
          
            $invoice_qty          = $_POST["invoice_qty"];
            $invoice_val          = $_POST["invoice_val"];
            $unique_id          = $_POST["unique_id"];
            $reject_reason          = $_POST["reject_reason"];
    
            $invoice_no          = $_POST["invoice_no"];
            $tot_invoice_no          = $_POST["main_invoice_no"];
            $cancel_invoice_no          = $_POST["cancel_invoice_no"];
            
            $remaining_invoice_no          = $_POST["remaining_invoice_no"];
    
            $update_where       = "";
    // =========================================rejected=================================================

    $columns_sub= [
        "is_delete"           => 1,
        "inv_cancel_status"           =>1,
        "inv_cancel_reason"           => $reject_reason,

    
    ];

    $table_main="bill_submission_main_table";
                
    $table_details = [
        $table_main,
        [
            "invoice_value",
            "invoice_qty",
            "cancel_invoice_no",
        ]
    ];
    $select_where = 'is_delete = 0 AND invoice_no="'.$tot_invoice_no.'"';
    $action_obj_1 = $pdo->select($table_details, $select_where);
    // print_r( $action_obj_1);die();
    if ($action_obj_1->status) {
        $status = $action_obj_1->status;
        $data = $action_obj_1->data;
        $error = '';
        $sql = $action_obj_1->sql;
    } else {
        $status = $action_obj_1->status;
        $data = $action_obj_1->data;
        $error = $action_obj_1->error;
        $sql = $action_obj_1->sql;
        $msg = 'error';
    }
     $total_inv_qty =$data[0]['invoice_qty']-$invoice_qty;
            // print_r( $total_inv_qty);
            $total_inv_value =$data[0]['invoice_value']- $invoice_val;
    
            $rem_inv_nos =$data[0]['cancel_invoice_no'];
    
    
    
    
    // print_r($action_obj_sub);
      // print_r($total_inv_value);die();
      if($remaining_invoice_no!=''){
        $columns_main            = [
            "inv_cancel_status"           =>1,
            "inv_cancel_reason"           => $reject_reason,
            "cancel_invoice_no"     =>$cancel_invoice_no,
            "rem_inv_no"     => $remaining_invoice_no,
            "invoice_value"           => $total_inv_value,
            "invoice_qty"           =>$total_inv_qty ,
            "invoice_no"     => $remaining_invoice_no,
          
            
    
        ];
    }
       else{
            // The invoice_no is either empty or null
            // Handle the case where invoice_no is empty or null
            $columns_main            = [
                "is_delete"     => 1,
                // "invoice_value"           => 0,
                // "invoice_qty"           =>0,
                "inv_cancel_status"           =>1,
                "inv_cancel_reason"           => $reject_reason,
                "cancel_invoice_no"     =>$cancel_invoice_no,
                "rem_inv_no"     =>$remaining_invoice_no,
                "payment_status"     => 0,
                // "invoice_no"     => null,
                ];
            }
    
    $update_where_main = 'bill_form_main_unique_id="' . $unique_id . '" and bill_no="'.$bill_no.'"';
    
    // print_r($update_where_main);die();
    $action_obj_main = $pdo->update($table_main_1, $columns_main, $update_where_main);
    
    // print_r($action_obj_main);
    
    
    $table_bill_form="bill_submission_form";
    
    $columns_bill_form= [
    "is_delete"           => 1,
    "inv_cancel_reason"           => $reject_reason,
    "inv_cancel_status"           =>1,
    // "cancel_invoice_no"     =>$cancel_invoice_no,
    
    
    ];
    
    $update_where_form = 'bill_form_main_unique_id="' . $unique_id . '" and invoice_no="'.$invoice_no.'"';
    
    // print_r($update_where_123);die();
    $action_obj_form = $pdo->update($table_bill_form, $columns_bill_form, $update_where_form);
    // print_r($action_obj_form);
    
    $table_sign= "sign_doc_verification_detail";
    
    $columns_sign= [
    "bill_status"           => 4,
    "bill_no"       => "" ,
    // "payment_reject"           => 0,
    "inv_cancel_reason"           => $reject_reason,
    "inv_cancel_status"           =>1,
    // "cancel_invoice_no"     =>$cancel_invoice_no,
    ];
    $update_where_sign = 'form_main_unique_id="'.$unique_id .'" and invoice_no="' . $invoice_no . '"';
    // print_r($update_where_123);die();
    $action_obj_sign = $pdo->update($table_sign, $columns_sign, $update_where_sign);
    
    
    // }
    // print_r($action_obj_sign);
            // Update Begins
            if ($unique_id) {
    
                unset($columns['bill_form_main_unique_id']);
    
                // $update_where   = [
                //     "bill_form_unique_id"     => $unique_id,
                // ];
                // $update_where = "bill_form_main_unique_id='" . $unique_id . "' AND  bill_no ='" . $bill_no . "' ";
                $update_where = 'bill_form_unique_id="'.$unique_id.'" and invoice_no="'.$invoice_no.'"';
    
                // $action_obj     = $pdo->update($table_main_1, $columns, $update_where);
                $action_obj = $pdo->update($table_sub_1, $columns_sub, $update_where);
    
                // print_r($action_obj);
    
                // Update Ends
            }
            // print_r($action_obj);
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
                if ($unique_id) {
                    $msg        = "update";
                }
                // else {
                //     $msg        = "create";
                // }
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

        $data        = [];
        $claim_amount = $_POST['claim_amount'];

        if ($length == '-1') {
            $limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as s_no",
            'po_num',
            'po_date',
            // 'con_contact_name',
            // 'con_address',
            'invoice_no',
            'invoice_date',
            "FORMAT(invoice_value, 2) AS invoice_value",
            "(SELECT ledger_name FROM invoice_creation_main WHERE invoice_creation_main.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS ledger_name",
            "(SELECT ledger_no FROM invoice_creation_main WHERE invoice_creation_main.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS ledger_no",
            "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",
            // 'bill_submission_date',
            "claim_amount",
            'e_no',
           
            "ld_amount",
            "delivery_due_dates",
            "payement_receive",
            "file_name",
            "payment_date",
            "(SELECT tran_amt FROM bill_submission_sub WHERE bill_submission_sub.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS tran_amt",
            "(SELECT gst FROM bill_submission_sub WHERE bill_submission_sub.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS gst",
            "(SELECT gst_value FROM bill_submission_sub WHERE bill_submission_sub.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS gst_value",
            "(SELECT rem_amt FROM bill_submission_sub WHERE bill_submission_sub.invoice_no = 
            $table.invoice_no AND is_delete='0' group by bill_form_unique_id) AS rem_amt",        
            "payment_status",
            'bill_form_unique_id',
            "bill_no",
            "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table.invoice_no AND is_delete='0' group by form_main_unique_id) as dc_signed_date",
            "elcot_ent_status",
            'net_value',
            // 'qty',
            "(select sum(invoice_qty) from invoice_creation as invoice_creation where invoice_no= $table.invoice_no AND is_delete=0 group by invoice_no) as qty",
            // "invoice_qty",
            // "(select invoice_qty from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no  group by po_unique_id) as qty",
            "(select sum(unit_price) from invoice_creation as invoice_creation where invoice_no= $table.invoice_no AND is_delete=0 group by invoice_no) as unit_price",
            // "unit_price",
            "ins_unique_id",
            "ld_days",
            // "(select sum(delivery_due_days) from invoice_creation as invoice_creation where invoice_no= $table.invoice_no  group by invoice_no) as product_delivery_due_days",
//             "(SELECT MIN(delivery_due_days) 
//  FROM invoice_creation AS invoice_creation 
//  WHERE invoice_no = $table.invoice_no) AS product_delivery_due_days",
// "(SELECT MIN(CAST(delivery_due_days AS UNSIGNED)) 
//  FROM invoice_creation 
//  WHERE invoice_no = $table.invoice_no) AS product_delivery_due_days",
// // "(SELECT delivery_due_days 
// //  FROM invoice_creation 
// //  WHERE invoice_no = $table.invoice_no) AS product_delivery_due_days",


//  "(SELECT unit_price 
//  FROM invoice_creation 
//  WHERE invoice_no = $table.invoice_no 
//    AND CAST(delivery_due_days AS UNSIGNED) = (SELECT MIN(CAST(delivery_due_days AS UNSIGNED)) 
//                             FROM invoice_creation 
//                             WHERE invoice_no = $table.invoice_no)
//  LIMIT 1) AS unit_price_min_delivery_due_days",
//  "(SELECT invoice_qty 
//  FROM invoice_creation 
//  WHERE invoice_no = $table.invoice_no 
//    AND CAST(delivery_due_days AS UNSIGNED) = (SELECT MIN(CAST(delivery_due_days AS UNSIGNED)) 
//                             FROM invoice_creation 
//                             WHERE invoice_no = $table.invoice_no)
//  LIMIT 1) AS invoice_qty_product",



        ];
        $table_details  = [
            $table,
            $columns
        ];


        
        $where          = "";
        // [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
            // if($claim_amount='75' || $claim_amount='25' ){
                
            //     // $where = " claim_status='1'";
            // }
            // claim_status!='2' || claim_status!='3'  ||
        // $where = "";
              // PRINT_R( $where);

       
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
                // $where =" po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = " STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
            } else if($opt == '5') {
                
                $where .=" AND invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            } 
            else if($opt == '6') {
                
                // $from_date_converted = date('d-m-Y', strtotime($from_date));
                // $to_date_converted = date('d-m-Y', strtotime($to_date));
                // $where = " STR_TO_DATE(payment_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(payment_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";       
                $where ="payment_date >= '" . $from_date . "' AND payment_date <= '" . $to_date . "' ";

            } 
            else if($opt == '7') {
                
                // $from_date_converted = date('d-m-Y', strtotime($from_date));
                // $to_date_converted = date('d-m-Y', strtotime($to_date));
                // $where = " STR_TO_DATE(payment_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(payment_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";       
                $where ="bill_submission_date >= '" . $from_date . "' AND bill_submission_date <= '" . $to_date . "' ";

            } 
            // $where = " claim_status='0' AND bill_submission_date!='' AND e_no!=''";



        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column, $order_dir, $columns);
        $order_by ="(payment_status = 2) $order_dir";
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
        // print_r($result);die();
        $total_records  = total_records();
        $screen_id_val      = $_POST['screen_id_val'];
        // print_r($screen_id_val);die();
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        // print_r($select_where);die();
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;

// print_r($table_users);die();
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
               $ld_days_table= $value['ld_days'];
               $ld_amount_table= $value['ld_amount'];

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';

                $orgDate2 = $value['bill_submission_date'];  
                $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));

                $net_value = $value['net_value'];

                $delivery_due_datess = $value['delivery_due_dates'];
                
                // if ($delivery_due_datess!="") {
                    $delivery_due_dates = $value['delivery_due_dates'];
                // } 
                // else {
                //     $delivery_due_dates = $value['product_delivery_due_days'];
                // }
            //   print_r($delivery_due_dates);
                // $total_price = $net_value * $qty;
                // if ($delivery_due_datess!="") {
                $unit_price = $value['unit_price'];
            //  }
                // else{ 
                // $unit_price = $value['unit_price_min_delivery_due_days'];  
                // }

                // if ($delivery_due_datess!="") {
                $qty = $value['qty'];
            // }
            // else{
            //     $qty = $value['invoice_qty_product'];
            // }

                // print_R(  $qty);
               
                //  print_r($unit_price);
                // $unit_price_min_delivery_due_days
                // $delivery_due_dates = $value['delivery_due_dates'];
              
// print_r($delivery_due_dates);
                // new changes 
                $dc_signed_date1 = $value['dc_signed_date'];  
               
              
                $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date1));

                // print_r($dc_signed_date);
                $dc_signed_date =  $value['dc_signed_date'];

                // end
                // print_r($dc_signed_date1);die();
                $signedDate = new DateTime($dc_signed_date);
                // print_r($signedDate);
                // print_r($signedDate);


                $po_date = $value['po_date'];
                $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
                $poDate->modify('+' . $delivery_due_dates . ' days');

                $duedate = $poDate->format('d-m-Y');
                $duedate1 = new DateTime($duedate);
                // print_r($duedate1);
                $poDate->modify('+' . $delivery_due_dates . ' days');
                $interval = $duedate1->diff($signedDate);

                // print_r(  $interval);
                // $date1 = new DateTime('2024-05-03');
                // $date2 = new DateTime('2024-05-01');
                if($signedDate>$duedate1){
                    $ld_days =  $interval->format('%a');
                    
                  }
                  else if($signedDate=$duedate1){
                    $ld_days=0;
                    
                  }
                  else{
                    $ld_days=0;
                  }
                  if ($delivery_due_datess!="") {
                // print_r( $ld_days);
                $value['ld_days']=   $ld_days;
                  }
                  else{
                    $value['ld_days']=  $ld_days_table;
                  }
                // Calculate the new value (25% of the total price)
                //172.31.99.126
                // $basic = ((floatval($salary) * 40) / 100);

                $lddays = intval($value['ld_days']);  // Convert to integer if needed

  
               
                // $total= $qty * $unit_price;

                
                // if($value['ld_days']>40){
                //     $ldvalue = ((floatval($value['ld_days'])* $qty * ($unit_price * 0.10) / 100));
                // }
                // else{
                //     $ldvalue = ((floatval($value['ld_days'])* $qty * ($unit_price * 0.25) / 100));
                // }
                if($lddays>40){
                    // echo"hi";
                    $ldvalue = $lddays *$qty* ($unit_price *  0.1);  
                }
                else{
                
                    $ldvalue = $lddays *$qty* ($unit_price * 0.0025);
                }

            // print_r(value: $ldvalue);
            //     $d=$lddays *$qty;
            // print_r( $d);
            // $d1= ($d*($unit_price * 0.0025));
            // print_r( $d1);

                // $value['ld_amount'] = floatval($ldvalue);
                if ($delivery_due_datess!="") {
               $value['ld_amount']       = moneyFormatIndia(floatval($ldvalue));
                }
                else{
                    $value['ld_amount'] =$ld_amount_table;
                }
              

               
                // $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no'],$value['invoice_no'],$value['ins_unique_id']);
                $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no'],$value['invoice_no']);
                $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                $btn_view = btn_view_payment($folder_name, $value['bill_form_unique_id'], $value['bill_no'],$value['invoice_no'],$value['ins_unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                // $value['bill_form_unique_id'] = $btn_update . $btn_delete;
                // if(in_array('5f88082b25ec031952', $action_ids)){
                //     $value['bill_form_unique_id'] = $btn_update;
                //  }
                //  // else if(in_array('5f8808504271036738', $action_ids)){
                //  //   
                 $value['bill_form_unique_id'] = $btn_delete;
                //  // }
                //  else{
                //     $value['bill_form_unique_id'] = '';
                //  }
                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))){
                    if($value['payment_status']=='2'){
                    // if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){

                       // print_r($value['stock_qty']==$value['invoice_qty']);die();
                       $value['bill_form_unique_id'] =  $btn_view;
                    }
                   else{
                  
                       if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['bill_form_unique_id'] = $btn_update;
                       
                    }
                       // else if(in_array('5f8808504271036738', $action_ids)){
                       //    $value['form_main_unique_id'] = $btn_delete;
                       // }
                       else{
                        $value['bill_form_unique_id'] = '';
                       }
                     }
                   
                 }
                 if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                   
                   // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                   //     $value['unique_id'] = $btn_update.$btn_delete;                   
                   // }
                   // else
                    if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['bill_form_unique_id']     =  $btn_update;
                   }
                   // else if(in_array('5f8808504271036738', $action_ids)){
                   //     $value['unique_id'] = $btn_delete;
                   // }
                   else{
                    $value['bill_form_unique_id'] = '';
                   }
                 }
 
                $payment_receive = $value['payement_receive'];
                $payment_status = $value['payment_status'];

                if ($payment_receive != '') {
                    $value['payement_receive'] =  $payment_receive;
                } else {
                    $value['payement_receive'] = '-';
                }

                // if (($payment_status == '1') || ($payment_status == '0')) {
                if($payment_status == '0' || $payment_status == ''){
                    $value['payment_status'] = 'Pending';
                }
                else if (($payment_status == '1')) {
                    $value['payment_status'] = 'Rejected';
                } else if ($payment_status == '2') {
                    $value['payment_status'] = 'Complete';
                }
                // if ($value['is_active'] == "1") {
                //     $value['is_active']   = "Active";
                // } else {

                //     $value['is_active']   = "Inactive";
                // }


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


        case 'fixed_datatable':
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
                'po_date',
                // 'con_contact_name',
                // 'con_address',
                'invoice_no',
                'invoice_date',
                'invoice_value',
                'bill_submission_date',
                "claim_amount",
                // "select sum(claim_amount) from bill_submission_main_table where bill_submission_main_table.invoice_no=$table.invoice_no)as claim_amount",
                'e_no',
                // 'qty',
                // 'net_value',
                "ld_days",
               "ld_amount",
              
                // "dc_signed_date",
                "delivery_due_dates",
                "payement_receive",
                "file_name",
                "payment_status",
                // "payment_date",
                'bill_form_unique_id',
                "bill_no",
                
            ];
            $table_details  = [
                $table_claim,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
    
            $where = "claim_amount='95' and claim_status!='0'";   
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
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
    
                    // $orgDate = $value['po_date'];  
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
    
                    // $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
    
                    // $orgDate2 = $value['bill_submission_date'];  
                    // $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));
    
                    // $dc_signed_date = $value['dc_signed_date'];  
                    // $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));
    
                    // $net_value = $value['net_value'];
    
                    // $qty = $value['qty'];
                    // $po_date = $value['po_date'];
    
                    // $delivery_due_dates = $value['delivery_due_dates'];
    
                    // $dc_signed_date = $value['dc_signed_date'];
    
                    // $signedDate = new DateTime($dc_signed_date);
    
                    // $total_price = $net_value * $qty;
    
                    // // Create a DateTime object from the given PO date
                    // $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
    
                    // // Add the specified number of days
                    // $poDate->modify('+' . $delivery_due_dates . ' days');
                    
    
                    // // Display the result PO date
                    // $resultDate = $poDate->format('d-m-Y');
                    // $poDate->setTime(0, 0);
                    // $signedDate->setTime(0, 0);
                    // // Calculate the difference between the result date and signed date
                    // $interval = $poDate->diff($signedDate);
    
                    // // Get the difference in days
                    // $lddays = $interval->format('%a');
    
                    // // Update the original array with the new calculated values
                    // $value['net_value'] = $lddays;
    
                    // // Calculate the new value (25% of the total price)
                    // //172.31.99.126
                    // $basic = ((floatval($salary) * 40) / 100);
    
                    // $lddays = intval($lddays);  // Convert to integer if needed
                    // $total_price = floatval($total_price);  // Convert to float if needed
                    
                    // $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                    
                    // $value['qty'] = floatval($ldvalue);
                   
                    // $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                    $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                    // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                    // $value['bill_form_unique_id'] = $btn_update . $btn_delete;
    
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


            
        case 'deleivery_datatable':
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
                'po_date',
                // 'con_contact_name',
                // 'con_address',
                'invoice_no',
                'invoice_date',
                'invoice_value',
                'bill_submission_date',
                "claim_amount",
                'e_no',
                // 'qty',
                // 'net_value',
                "ld_days",
               "ld_amount",
                // "dc_signed_date",
                "delivery_due_dates",
                "payement_receive",
                "file_name",
                "payment_status",
                // "payment_date",
                'bill_form_unique_id',
                "bill_no",
                
            ];
            $table_details  = [
                $table_claim,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
            // $where = "claim_status='2' || claim_status='3'";
            $where = "claim_amount='100'";  
            // and claim_status='2' || claim_status='3'
            //  $where = "payment_status='2'";
    
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
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
    
                    // $orgDate = $value['po_date'];  
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
    
                    // $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
    
                    // $orgDate2 = $value['bill_submission_date'];  
                    // $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));
    
                    // $dc_signed_date = $value['dc_signed_date'];  
                    // $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));
    
                    // $net_value = $value['net_value'];
    
                    // $qty = $value['qty'];
                    // $po_date = $value['po_date'];
    
                    // $delivery_due_dates = $value['delivery_due_dates'];
    
                    // $dc_signed_date = $value['dc_signed_date'];
    
                    // $signedDate = new DateTime($dc_signed_date);
    
                    // $total_price = $net_value * $qty;
    
                    // // Create a DateTime object from the given PO date
                    // $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
    
                    // // Add the specified number of days
                    // $poDate->modify('+' . $delivery_due_dates . ' days');
                    
    
                    // // Display the result PO date
                    // $resultDate = $poDate->format('d-m-Y');
                    // $poDate->setTime(0, 0);
                    // $signedDate->setTime(0, 0);
                    // // Calculate the difference between the result date and signed date
                    // $interval = $poDate->diff($signedDate);
    
                    // // Get the difference in days
                    // $lddays = $interval->format('%a');
    
                    // // Update the original array with the new calculated values
                    // $value['net_value'] = $lddays;
    
                    // // Calculate the new value (25% of the total price)
                    // //172.31.99.126
                    // $basic = ((floatval($salary) * 40) / 100);
    
                    // $lddays = intval($lddays);  // Convert to integer if needed
                    // $total_price = floatval($total_price);  // Convert to float if needed
                    
                    // $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                    
                    // $value['qty'] = floatval($ldvalue);
                   
                    // // $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                    $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                    // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                    // $value['bill_form_unique_id'] = $btn_update . $btn_delete;
    
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
    

            case 'pending_one_datatable':
                // DataTable Variables
                $search     = $_POST['search']['value'];
                $length     = $_POST['length'];
                $start         = $_POST['start'];
                $draw         = $_POST['draw'];
                $limit         = $length;
        
                $data        = [];
                $claim_amount = $_POST['claim_amount'];
        
                if ($length == '-1') {
                    $limit  = "";
                }
        
                // Query Variables
                $json_array     = "";
                $columns        = [
                    "'' as  s_no",
                    'po_num',
                    'po_date',
                    // 'con_contact_name',
                    // 'con_address',
                    'invoice_no',
                    'invoice_date',
                    'invoice_value',
                    'bill_submission_date',
                    "claim_amount",
                    'e_no',
                    // 'net_value',
                    // 'qty',
                    "ld_amount",
                    "ld_days",
                    
                    "delivery_due_dates",
                    "payement_receive",
                    "file_name",
                    "payment_status",
                    // "payment_date",
                    'bill_form_unique_id',
                    "bill_no",
                    "dc_signed_date",
                ];
                $table_details  = [
                    $table,
                    $columns
                ];
                // $where          = [
                //     "is_delete"     => 0
                // ];
                // $order_by       = "";
                    // if($claim_amount='75' || $claim_amount='25' ){
                        
                    //     // $where = " claim_status='1'";
                    // }
                $where = " claim_amount='25' AND claim_status='0'";
        
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
                // print_R($result);
                $total_records  = total_records();
        
                if ($result->status) {
        
                    $res_array      = $result->data;
        
                    foreach ($res_array as $key => $value) {
                        $value['s_no'] = $sno + 1;
        
                        $orgDate = $value['po_date'];  
                        $value['po_date'] = date("d-m-Y", strtotime($orgDate));
        
                        $orgDate1 = $value['invoice_date'];  
                        $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
        
                        $orgDate2 = $value['bill_submission_date'];  
                        $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));
        
                        $dc_signed_date = $value['dc_signed_date'];  
                        $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));
        
                        $net_value = $value['net_value'];
        
                        $qty = $value['qty'];
                        $po_date = $value['po_date'];
        
                        $delivery_due_dates = $value['delivery_due_dates'];
        
                        $dc_signed_date = $value['dc_signed_date'];
        
                        $signedDate = new DateTime($dc_signed_date);
        
                        $total_price = $net_value * $qty;
        
                        // Create a DateTime object from the given PO date
                        $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
        
                        // Add the specified number of days
                        $poDate->modify('+' . $delivery_due_dates . ' days');
                        
        
                        // Display the result PO date
                        $resultDate = $poDate->format('d-m-Y');
                        $poDate->setTime(0, 0);
                        $signedDate->setTime(0, 0);
                        // Calculate the difference between the result date and signed date
                        $interval = $poDate->diff($signedDate);
        
                        // Get the difference in days
                        $lddays = $interval->format('%a');
        
                        // Update the original array with the new calculated values
                        $value['net_value'] = $lddays;
        
                        // Calculate the new value (25% of the total price)
                        //172.31.99.126
                        $basic = ((floatval($salary) * 40) / 100);
        
                        $lddays = intval($lddays);  // Convert to integer if needed
                        $total_price = floatval($total_price);  // Convert to float if needed
                        
                        $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                        
                        $value['qty'] = floatval($ldvalue);
                       
                        $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                        $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                        // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                        $value['bill_form_unique_id'] = $btn_update . $btn_delete;
        
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
                        // if ($value['is_active'] == "1") {
                        //     $value['is_active']   = "Active";
                        // } else {
        
                        //     $value['is_active']   = "Inactive";
                        // }
        
        
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
    

                case 'pending_5_datatable':
                    // DataTable Variables
                    $search     = $_POST['search']['value'];
                    $length     = $_POST['length'];
                    $start         = $_POST['start'];
                    $draw         = $_POST['draw'];
                    $limit         = $length;
            
                    $data        = [];
                    $claim_amount = $_POST['claim_amount'];
            
                    if ($length == '-1') {
                        $limit  = "";
                    }
            
                    // Query Variables
                    $json_array     = "";
                    $columns        = [
                        "'' as  s_no",
                        'po_num',
                        'po_date',
                        // 'con_contact_name',
                        // 'con_address',
                        'invoice_no',
                        'invoice_date',
                        'invoice_value',
                        'bill_submission_date',
                        "claim_amount",
                        'e_no',
                        // 'net_value',
                        // 'qty',
                        "ld_amount",
                        "ld_days",
                        
                        "delivery_due_dates",
                        "payement_receive",
                        "file_name",
                        "payment_status",
                        // "payment_date",
                        'bill_form_unique_id',
                        "bill_no",
                        "dc_signed_date",
                    ];
                    $table_details  = [
                        $table,
                        $columns
                    ];
                    // $where          = [
                    //     "is_delete"     => 0
                    // ];
                    // $order_by       = "";
                        // if($claim_amount='75' || $claim_amount='25' ){
                            
                        //     // $where = " claim_status='1'";
                        // }
                    $where = " claim_amount='5' AND claim_status='0'";
            
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
            
                    if ($result->status) {
            
                        $res_array      = $result->data;
            
                        foreach ($res_array as $key => $value) {
                            $value['s_no'] = $sno + 1;
            
                            $orgDate = $value['po_date'];  
                            $value['po_date'] = date("d-m-Y", strtotime($orgDate));
            
                            $orgDate1 = $value['invoice_date'];  
                            $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
            
                            $orgDate2 = $value['bill_submission_date'];  
                            $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));
            
                            $dc_signed_date = $value['dc_signed_date'];  
                            $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));
            
                            $net_value = $value['net_value'];
            
                            $qty = $value['qty'];
                            $po_date = $value['po_date'];
            
                            $delivery_due_dates = $value['delivery_due_dates'];
            
                            $dc_signed_date = $value['dc_signed_date'];
            
                            $signedDate = new DateTime($dc_signed_date);
            
                            $total_price = $net_value * $qty;
            
                            // Create a DateTime object from the given PO date
                            $poDate = DateTime::createFromFormat('d-m-Y', $po_date);
            
                            // Add the specified number of days
                            $poDate->modify('+' . $delivery_due_dates . ' days');
                            
            
                            // Display the result PO date
                            $resultDate = $poDate->format('d-m-Y');
                            $poDate->setTime(0, 0);
                            $signedDate->setTime(0, 0);
                            // Calculate the difference between the result date and signed date
                            $interval = $poDate->diff($signedDate);
            
                            // Get the difference in days
                            $lddays = $interval->format('%a');
            
                            // Update the original array with the new calculated values
                            $value['net_value'] = $lddays;
            
                            // Calculate the new value (25% of the total price)
                            //172.31.99.126
                            $basic = ((floatval($salary) * 40) / 100);
            
                            $lddays = intval($lddays);  // Convert to integer if needed
                            $total_price = floatval($total_price);  // Convert to float if needed
                            
                            $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                            
                            $value['qty'] = floatval($ldvalue);
                           
                            $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                            $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                            // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                            $value['bill_form_unique_id'] = $btn_update . $btn_delete;
            
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
                            // if ($value['is_active'] == "1") {
                            //     $value['is_active']   = "Active";
                            // } else {
            
                            //     $value['is_active']   = "Inactive";
                            // }
            
            
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

