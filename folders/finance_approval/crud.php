<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "vendor_payment_details";






include '../../config/dbconfig.php';

$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);



// Include DB file and Common Functions


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

$sess_user_id = $_SESSION['user_id'];





switch ($action) {
    case 'createupdate':

        $payement_receive = $_POST["payement_receive"];
        //$under_user_type    = $_POST["under_user_type"];
        $payment_status = $_POST["payment_status"];
        $payment_date = $_POST["payment_date"];
        $ld_amount = $_POST["ld_amount"];
        $ld_days = $_POST["ld_days"];
        $bill_no = $_POST["bill_no"];
        $claim_amount = $_POST["claim_amount"];

        $gst = $_POST["gst"];
        $gst_value = $_POST["gst_value"];
        $tds = $_POST["tds"];
        $tds_value = $_POST["tds_value"];
        $ld = $_POST["ld"];

        $tran_amt = $_POST["tran_amt"];
        $rem_amt = $_post["rem_amt"];
        $unique_id = $_POST["unique_id"];

        $update_where = "";
        $myinv_no = $_POST['my_inv_no'];
        $parts = explode('/', $myinv_no);
        // Get the last value from the array
        $myinv_no_value = end($parts);
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = "Payment-" . $myinv_no_value . '.pdf';

            move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/payment/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
        if (($file_names) && ($file_org_names)) {
            $columns = [
                "payement_receive" => $payement_receive,
                "payment_status" => $payment_status,
                "payment_date" => $payment_date,
                "ld_amount" => $ld_amount,
                "ld_days" => $ld_days,
                // "claim_percentage"           => $claim_amount,
                'file_name' => $file_names,
                'file_org_name' => $file_org_names,


            ];
        } else {
            $columns = [
                "payement_receive" => $payement_receive,
                "payment_status" => $payment_status,
                "payment_date" => $payment_date,
                "ld_amount" => $ld_amount,
                "ld_days" => $ld_days,



            ];
        }
        if (($file_names) && ($file_org_names)) {
            $columns_1 = [
                "payement_receive" => $payement_receive,
                "payment_status" => $payment_status,
                "payment_date" => $payment_date,
                "ld_amount" => $ld_amount,
                "ld_days" => $ld_days,

                "claim_percentage" => $claim_amount,
                'file_name' => $file_names,
                'file_org_name' => $file_org_names,
                'gst' => $gst,
                'gst_value' => $gst_value,
                'tds' => $tds,
                'tds_value' => $tds_value,
                'ld' => $ld,
                'tran_amt' => $tran_amt,
                'rem_amt' => $rem_amt,
            ];
        } else {
            $columns_1 = [
                "payement_receive" => $payement_receive,
                "payment_status" => $payment_status,
                "payment_date" => $payment_date,
                "ld_amount" => $ld_amount,
                "ld_days" => $ld_days,
                "claim_percentage" => $claim_amount,
                "gst" => $gst,
                "gst_value" => $gst_value,
                "tds" => $tds,
                "tds_value" => $tds_value,
                "ld" => $ld,
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

            $action_obj = $pdo->update($table_main_1, $columns, $update_where);
            // print_r($action_obj);

            // Update Ends
        }
        // print_r($action_obj);die();
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($unique_id) {
                $msg = "update";
            }
            // else {
            //     $msg        = "create";
            // }
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

        $data = [];
        $claim_amount = $_POST['claim_amount'];

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            // "DATE_FORMAT(bill_date,'%d-%m-%Y')AS bill_date",
           "CONCAT(
  DATE_FORMAT(bill_date, '%d-%m-%Y'),
  ' <br> <b>',
  bill_no,
  '</b>'
) AS bill_display",

            "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
        //    
            // "bill_no",
            "vendor_name",
            "count(dc_num) as dccount",  
            // "IFNULL(SUM(amount), 0) AS total_amount",
            "total_amount",
           "advancepayment",
            "acctotalpaybleamount",
             "get_staff_name((vendor_bill_approval)) AS vendor_bill_approval",
            "managment_team_approval_sts",
            "managment_team_reject_reason",
            "get_staff_name(managment_team_approvedby) AS management_approved_by",
            "finance_remark",
           
            "unique_id",
            //    "bill_no",
          
            "finance_approval",
            "dc_num",
            "vendor_id",
            // "(select contact_no from vendor_creation where unique_id = $table.vendor_id) as contact_no",
            // "(select mail_id from vendor_creation where unique_id = $table.vendor_id) as mail",
            // "(select address from vendor_creation where unique_id = $table.vendor_id) as address",
            "get_vendor_mail(vendor_id) AS mail",
            "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_company_name(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "finance_remark",
             "accountbillid",
             "acctotalpaybleamount",
            "acctdsvalue",
            "accotherdeduction",
            "bill_no",
            "veninvverifyid",
              "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y')AS vendor_bill_approval_date",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",

          
            
            // "engineer_name"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

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

        $where .= "accstatus ='1' AND is_delete = 0 AND (finance_approval = '0' or finance_approval = '2' ) ";


        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

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

        $group_by = "bill_no,vendor_id";
        

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);
// PRINT_R( $result);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];

        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
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

                $vendor_id = $value['vendor_id'];
                $contact_no = $value['contact_no']; // assuming vendor_id is the unique_id
                $address = $value['address']; // assuming vendor_id is the unique_id

                $value['s_no'] = $sno + 1;

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';


                $dc_num = $value["dc_num"];

                // $total_amount = $value["total_amount"];

                $remarks=  $value['finance_remark'];

                $btn_view = '<span style="display:block; text-align:center;"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green view-btn" data-bill-no="' . $value['bill_no'] . '" data-bill-date="' . $value['bill_date'] . '" data-remark = "'.$remarks.'"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '"   data-vendor-address ="' . $value['address'] . '"data-vendor-mail ="' . $value['mail'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $value['total_amount'] . '"data-accountbillid= "' . $value['accountbillid'] . '" data-acctotalpaybleamount = "' . $value['acctotalpaybleamount'] . '" data-advancepayment = "' . $value['advancepayment'].'" data-acctdsvalue = "' . $value['acctdsvalue'] . '" data-accotherdeduction = "' . $value['accotherdeduction'] . '" title="View"></i></span>';

                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";
                }


                // $value['total_amount'] = '<span><b>' . $value['total_amount'] . '</b></span>';
               $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' 
    . formatIndianCurrency($value['total_amount']) . '</b></span>';

                $value['acctotalpaybleamount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['acctotalpaybleamount']) . '</b></span>';

            //    $value['bill_date'] = '<span style="display:block; text-align:right;"><b>'
    // . $value['bill_date']
    // . '<br>'
    // . $value['bill_no']
    // . '</b></span>';
$value['dccount'] = '<span style="display:block; text-align:right;">' 
    . $value['dccount'] . '</span>';

                

                $vendor_name = $value['vendor_name'];
                $vendor_reg_id = $value['vendor_reg_id'];
                $address = $value['address'];
                $contact_no = $value['contact_no'];

                $value['vendor_name'] = "<div>
                        <strong>{$vendor_reg_id}</strong><br>
                        <span>{$address} - Ph.No. {$contact_no}</span>
                    </div>";


     $managment_team_approval_sts = $value['managment_team_approval_sts'];

if ($value['managment_team_approval_sts']== '0') {
    $value['managment_team_approval_sts'] =
        '<span style="color: orange; font-weight: bold;">Pending</span>';
} else if ($value['managment_team_approval_sts']== '1') {
    $value['managment_team_approval_sts'] =
        '<span style="color: green; font-weight: bold;">Approved</span>';
} else if ($value['managment_team_approval_sts']== '2') {
    $value['managment_team_approval_sts'] =
        '<span style="color: red; font-weight: bold;">Management Team Rejected</span>';
}

if($value['vendor_inv_attach_approval_date']==""){

$value['vendor_inv_attach_approval_date']="-";
$value['veninvverifyid']="-";
 }

 else{
 $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
 
 }
                $value["advancepayment"] = '<span style="display:block; text-align:right;">' . formatIndianCurrency($value['advancepayment']) . '</span>';


                      $value['vendor_bill_approval'] = $value['vendor_bill_approval'] . "&nbsp;&nbsp;<br><b>" . (($value['vendor_bill_approval_date'])) . "</b>";

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


           
       case 'vendor_bill_status':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $bill_no = $_POST['bill_no'];

        $data = [];

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
         
            // "vendor_bill_created_date as bill_created_date",
            "get_staff_name(vendor_bill_created_by) as bill_created_by",
            // " as bill_created_Status",

            "get_staff_name(vendor_bill_approval) as bill_approved",
            // "vendor_bill_approval_date",
            "vendor_bill_app_status",
            "get_staff_name(vendor_account_approved_by) as acc_approve",
            // "vendor_account_approval_date",
            "acc_ent_sts",

            "get_staff_name(finance_approved_by)as finance_approve",
            // "finance_approved_date",
            "finance_approval as finance_approval_sts",
            "get_staff_name(managment_team_approvedby) as managed_approve",
            // "managment_team_approvaldate",
            "managment_team_approval_sts",
            "unique_id",
            "bill_no",
             "accounts_approval as payment_status",
              "DATE_FORMAT(vendor_bill_created_date,'%d-%m-%Y %H:%i:%s') as bill_created_date",
         "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y %H:%i:%s') as vendor_bill_approval_date",
         "DATE_FORMAT(vendor_account_approval_date,'%d-%m-%Y %H:%i:%s') as vendor_account_approval_date",
         "DATE_FORMAT(finance_approved_date,'%d-%m-%Y %H:%i:%s') as finance_approved_date",
         "DATE_FORMAT(managment_team_approvaldate,'%d-%m-%Y %H:%i:%s') as managment_team_approvaldate",
         "DATE_FORMAT(transaction_date,'%d-%m-%Y') as transfer_date",
            "acctotalpaybleamount as transfer_amount",
            "transaction_id as udr"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "bill_no = '$bill_no' AND is_delete = 0 Group By bill_no";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

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

                
                $data[] = [
    "bill_createdby" => $value['bill_created_by'] ?? '',
    "created_date" => $value['bill_created_date'] ?? '',
    "bill_create_status" => 
        (!empty($value['bill_created_by']) && !empty($value['bill_created_date'])) 
        ? 'Bill Created' : 'Pending',

    "bill_approved" => $value['bill_approved'] ?? '',
    "vendor_bill_approval_date" => $value['vendor_bill_approval_date'] ?? '',
    "vendor_bill_status" => getStatusText($value['vendor_bill_app_status'] ?? 0),

    "acc_approve" => $value['acc_approve'] ?? '',
    "vendor_account_approval_date" => $value['vendor_account_approval_date'] ?? '',
    "acc_status" => getStatusText($value['acc_ent_sts'] ?? 0),

    "finance_approve" => $value['finance_approve'] ?? '',
    "finance_approved_date" => $value['finance_approved_date'] ?? '',
    "finance_status" => getStatusText($value['finance_approval_sts'] ?? 0),


 "transfer_date" => $value['transfer_date'] ?? '',
                    "transfer_amount" => $value['transfer_amount'] ?? '',
                    "udr" => $value['udr'] ?? '',

    "managed_approve" => $value['managed_approve'] ?? '',
    "managment_team_approvaldate" => $value['managment_team_approvaldate'] ?? '',
    "management_status" => getStatusText($value['managment_team_approval_sts'] ?? 0),
     "payment_status" => ($value['payment_status'] == '1')
    ? '<span class="text-success fw-semibold">Paid</span>'
    : '<span class="text-warning fw-semibold">Pending</span>'
];

             
               
            }

            $json_array = [
                "data" => $data,
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


    

   case 'datatable_completed':
    $search     = $_POST['search']['value'];
    $length     = $_POST['length'];
    $start      = $_POST['start'];
    $draw       = $_POST['draw'];
    $from_date  = $_POST['from_date'];
    $to_date    = $_POST['to_date'];
    $opt        = $_POST['opt'];
    $limit      = ($length == '-1') ? "" : $length;

    $data = [];
    $sno = $start + 1;
    $table_vendor = "vendor_payment_details";

    $sql_function = "SQL_CALC_FOUND_ROWS";
    $order_column = $_POST["order"][0]["column"];
    $order_dir    = $_POST["order"][0]["dir"];
    $order_by     = datatable_sorting($order_column, $order_dir, []);

    // Base where condition
    $whereBase = "accstatus = 1 and is_delete=0";

    // 🔹 Step 1: Fetch grouped accepted records (finance_approval = 1)
    $accepted_columns = [
        "'' as s_no",
        // "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
         "CONCAT('<b>', bill_no, '</b>', ' <br> ', DATE_FORMAT(bill_date, '%d-%m-%Y')) AS bill_display",
        "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
       
        "vendor_name",
       "count(dc_num) as dccount",  
        "SUM(amount) AS total_amount",
          "acctdsvalue",
            "accotherdeduction",
              "advancepayment",
        "acctotalpaybleamount",
          "get_staff_name(MAX(finance_approved_by)) AS finance_approved_by",
        "finance_approval",
        // "'1' AS finance_approval",
         
        "MAX(unique_id) AS unique_id",
        "MAX(accounts_approval) AS accounts_approval",
        "vendor_id",
        "GROUP_CONCAT(invoice_no) AS invoice_no",
        "GROUP_CONCAT(po_num) AS po_num",
        "get_vendor_address(vendor_id) AS address",
        "get_vendor_company_name(vendor_id) AS vendor_reg_id",
        "get_vendor_contact(vendor_id) AS contact_no",
     
        "DATE_FORMAT(MAX(finance_approved_date), '%d-%m-%Y') AS finance_approved_date",
        "finance_reject_reason",
        "accountbillid",
        "acctdsvalue",
        "accotherdeduction",
        // "acctotalpaybleamount",
        "accstatus",
         "bill_no",
        //  "vendor_inv_attach_approval_date",
         "veninvverifyid"
    ];

    $accepted_condition = "finance_approval = 1 AND $whereBase";
    $accepted_result = $pdo->select(
        [$table_vendor, $accepted_columns],
        $accepted_condition,
        '',
        '',
        $order_by,
        $sql_function,
        "vendor_id, bill_no"
    );

    // 🔹 Step 2: Fetch individual rejected records (finance_approval = 2)
    $rejected_columns = [
        "'' as s_no",
          "CONCAT('<b>', bill_no, '</b>', ' <br> ', DATE_FORMAT(bill_date, '%d-%m-%Y')) AS bill_display",
        "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
       
        "vendor_name",
       "count(dc_num) as dccount",  
        "SUM(amount) AS total_amount",
        "acctotalpaybleamount",
          "get_staff_name(MAX(finance_approved_by)) AS finance_approved_by",
        "finance_approval",
        // "'1' AS finance_approval",
         
        "MAX(unique_id) AS unique_id",
        "MAX(accounts_approval) AS accounts_approval",
        "vendor_id",
        "GROUP_CONCAT(invoice_no) AS invoice_no",
        "GROUP_CONCAT(po_num) AS po_num",
        "get_vendor_address(vendor_id) AS address",
        "get_vendor_id(vendor_id) AS vendor_reg_id",
        "get_vendor_contact(vendor_id) AS contact_no",
     
        "DATE_FORMAT(MAX(finance_approved_date), '%d-%m-%Y') AS finance_approved_date",
        "finance_reject_reason",
        "accountbillid",
        "acctdsvalue",
        "accotherdeduction",
        // "acctotalpaybleamount",
        "accstatus",
         "bill_no",
        //  "vendor_inv_attach_approval_date",
         "veninvverifyid",
         "advancepayment"
    ];

    $rejected_condition = "finance_approval = 2 AND $whereBase";
    $rejected_result = $pdo->select(
        [$table_vendor, $rejected_columns],
        $rejected_condition,
        '',
        '',
        $order_by,
        $sql_function,
        "vendor_id, bill_no"
    );

    // 🔹 Step 3: Merge both results
    $accepted_data = $accepted_result->status ? $accepted_result->data : [];
    $rejected_data = $rejected_result->status ? $rejected_result->data : [];
    $res_array = array_merge($accepted_data, $rejected_data);

    $total_records = total_records();  // your function to get total count
    $screen_id_val = $_POST['screen_id_val'];
    $user_type = $_POST['user_type_unique_id'];

    // 🔹 Get permitted actions
    $table_user = "user_screen_permission";
    $action_data = $pdo->select(
        [$table_user, ["action_unique_id", "user_type"]],
        "screen_unique_id = '$screen_id_val' AND user_type = '$user_type'"
    );
    $action_ids = array_column($action_data->data ?? [], 'action_unique_id');

    // 🔹 Step 4: Format each row
    foreach ($res_array as $value) {
        $value['s_no'] = $sno++;

        $bill_no = $value['bill_no'];
        $vendor_id = $value['vendor_id'];

        $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';
        // $value['total_amount'] = '<span style="display:block; text-align:right;"><b>'
            // . formatIndianCurrency($value['total_amount']) . '</b></span>';
// $value['total_amount'] = '<span style="text-align:right; font-size:13px;">' 
//     . formatIndianCurrency($value['total_amount']) . '</span>';
// $value['dccount'] = '<span style="text-align:right; font-size:13px;">' 
//     . ($value['dccount']) . '</span>';
$value['total_amount'] = '<span style="display:inline-block; width:100%; text-align:right; font-size:13px;font-weight:bold">' 
    . formatIndianCurrency($value['total_amount']) . '</span>';
$value['dccount'] = '<span style="display:inline-block; width:100%; text-align:right; font-size:13px;">' 
    . $value['dccount'] . '</span>';

               
    
        // Accounts Approval Status
        $accounts_approval = $value['accounts_approval'] ?? 0;
        $value['accounts_approval'] = ($accounts_approval == 1)
            ? '<span style="color: green; font-weight: bold;">Processed</span>'
            : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';

        // View Button
        $btn_view = '<span style="display:block; text-align:center;">'
            . '<i class="mdi mdi-eye view-btn-2" '
            . 'data-ponum="' . htmlspecialchars($value['po_num']) . '" '
            . 'data-billno="' . htmlspecialchars($bill_no) . '" '
            . 'data-vendor="' . htmlspecialchars($vendor_id) . '" '
            . 'data-billdate="' . ($value['bill_date']) . '" '
            . 'data-financerejectreason="' . htmlspecialchars($value['finance_reject_reason']) . '" '
            . 'data-financeapproval="' . htmlspecialchars($value['finance_approval']) . '" '
            . 'data-approver="' . htmlspecialchars($value['finance_approved_by']) . '" '
            . 'data-approvedate="' . htmlspecialchars($value['finance_approved_date']) . '" '
            . 'data-accountbillidcom="' . htmlspecialchars($value['accountbillid']) . '" '
            . 'data-tds_value_detuctioncom="' . htmlspecialchars($value['acctdsvalue']) . '" '
            . 'data-othersvalcom="' . htmlspecialchars($value['accotherdeduction']) . '" '
            . 'data-payamountcom="' . htmlspecialchars($value['acctotalpaybleamount']) . '" '
            .'data-advancepayment="' . htmlspecialchars($value['advancepayment']) . '" '
            . 'title="View"></i></span>';

        $value['unique_id'] = $btn_view;

        // Finance Approval Icon
        $finance_status = strval($value['finance_approval']);
        if ($finance_status === '1') {
            $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>"
                . "<i class='mdi mdi-check-circle mdi-24px' style='color:green;' title='Approved'></i>"
                . "</div>";
        } elseif ($finance_status === '2') {
            $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>"
                . "<i class='mdi mdi-close-circle mdi-24px' style='color:red;' title='Rejected'></i>"
                . "</div>";
        }

        // Vendor Display
        $vendor_name = $value['vendor_name'];
        $vendor_reg_id = $value['vendor_reg_id'];
        $address = $value['address'];
        $contact_no = $value['contact_no'];
        // $value['acctotalpaybleamount'] = '<b>' . $value['acctotalpaybleamount'] . '</b>';
  $value['acctotalpaybleamount'] = '<span style="display:block; text-align:right; font-size:13px;font-weight:bold">' 
    . formatIndianCurrency($value['acctotalpaybleamount']) . '</span>';


        $value['vendor_name'] = "<div style='white-space: nowrap'>"
            . "<strong>" . htmlspecialchars($vendor_reg_id) . "</strong><br>"
            . "<span>" . htmlspecialchars($address) . " - Ph.No. " . htmlspecialchars($contact_no) . "</span>"
            . "</div>";


              $value["finance_approved_by"] = '<span style="display: inline-block; width: 100%; text-align: right;white-space: nowrap">' . $value['finance_approved_by'] . '<br>'. $value['finance_approved_date'] . '</span>';

                if ($value['vendor_inv_attach_approval_date'] == "") {
            $value['vendor_inv_attach_approval_date'] = "-";
            $value['veninvverifyid'] = "-";
        } else {
            $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
        }


$value["acctdsvalue"] = '<span style="display:block; text-align:right; ">' . formatIndianCurrency($value['acctdsvalue']) . '</span>';


            //      "accotherdeduction",
            // "IFNULL(SUM(acctotalpaybleamount), 0) AS acctotalpaybleamount",
                  $value["accotherdeduction"] = '<span style="display:block; text-align:right; ">' . formatIndianCurrency($value['accotherdeduction']) . '</span>';
 $value["advancepayment"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['advancepayment']) . '</span>';

        $data[] = array_values($value);
    }

    $json_array = [
        "draw" => intval($draw),
        "recordsTotal" => intval($total_records),
        "recordsFiltered" => intval($total_records),
        "data" => $data
    ];

    echo json_encode($json_array);
    break;



    case 'vendor_bill_details':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $unique_id =

            $data = [];
        $bill_no = $_POST['bill_no'];

        $vendor = $_POST['vendor'];

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            'po_num',
            'dc_num',
            'dc_date',
            'invoice_qty',
            "vendor_name",
            "rate",
            "gst",
            "amount",
            "total_amount",
            "po_form_unique_id",
            "unique_id",
            "invoice_no",
            "bill_no",
            "finance_approval",
              "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.dc_num = view_outsource_vendor_verified_invoice.dc_number LIMIT 1)) AS consignee_name",

            "(SELECT invoice_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS po_date",
            "accstatus",
              "accountbillid",
             "acctotalpaybleamount",
            "acctdsvalue",
            "accotherdeduction",
               "inv_verfiy_attach",
               "po_ven_filename",
            //  "vendor_inv_attach_approval_date",
        "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",

             "veninvverifyid",
                 "gst",
            "rate",
            "invoice_qty",
            "(Select staff_name from user where unique_id = $table.vendor_bill_created_by)as bill_created_by",
            "vendor_bill_created_date",
              "(Select staff_name from user where unique_id = $table.vendor_bill_approval)as bill_approved_by",
              "vendor_bill_approval_date",

                "(Select staff_name from user where unique_id = $table.vendor_account_approved_by)as acc_bill_by",
                "vendor_account_approval_date as acc_bill_date",
                "accdetuctionremarks",
               "(SELECT additional_amount 
 FROM vendor_payment_details_main 
 WHERE vendor_payment_details_main.bill_no = $table_vendor.bill_no 
 LIMIT 1) AS additional_amount"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = "bill_no = '$bill_no' AND vendor_id = '$vendor' AND (finance_approval = 0 or finance_approval=2) and accstatus='1' and is_delete='0'";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order



        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }


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

        // $group_by = "outsrc_eng_name";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        //  print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_qty = $value['invoice_qty'];

                $bill_no = $value['bill_no'];

                $dc_number = $value['dc_num'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];

                $rate = $value['rate'];
                $gst = $value['gst'];
                $amnt = $value['amount'];
  $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;

                $value['po_num'] = $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>";
                $value['invoice_no'] = $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>";
                $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>";

                $form_main_unique_id = $value['form_main_unique_id'];

                $unique_id = $value['unique_id'];



                $value['po_form_unique_id'] = '<select class="form-select status-select" data-unqiue-id ="' . $unique_id . '" data-bill-no ="' . $bill_no . '" name="status[' . $unique_id . ']"<option value="approved" selected>Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <textarea class="form-control mt-1 reject-reason" name="reason[' . $unique_id . ']" placeholder="Reason for Rejection" style="display: none;" rows="2"></textarea>';

                $value['amount'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>";
                $value['invoice_qty'] = "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>";
                $value['rate'] = "<span style='display:block; text-align:right;'>" . $value['rate'] . "</span>";
                $value['gst'] = "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>";

                $vendor_bill_created  = $value['bill_created_by'] . ' ' . $value['vendor_bill_created_date'];
                $vendor_bill_approved = $value['bill_approved_by'] . ' ' . $value['vendor_bill_approval_date'];
                $acc_bill             = $value['acc_bill_by'] . ' ' . $value['acc_bill_date'];
                $accdetuctionremarks             = $value['accdetuctionremarks'] ;


                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_number" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "additional_amount" => $value['additional_amount'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "total_amount" => $value['total_amount'],
                    "bill_no" => $value['bill_no'],
                    "invoice_no" => $value['invoice_no'],
                    "unique_id" => $unique_id,
                    "po_form_unique_id" => $value['po_form_unique_id'],
                    "consignee_name" => $value['consignee_name'],
                      "accountbillid" => $value['accountbillid'],
                    "acctotalpaybleamount" => $value['acctotalpaybleamount'],
                    "acctdsvalue" => $value['acctdsvalue'],
                    "accotherdeduction" => $value['accotherdeduction'],
                       "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                        "po_ven_filename" => $value['po_ven_filename'],
                    "vendor_inv_attach_approval_date" => $value['vendor_inv_attach_approval_date'],
                    "veninvverifyid" => $value['veninvverifyid'],
                    "vendor_bill_created" => $vendor_bill_created,
                    "vendor_bill_approved" => $vendor_bill_approved,
                     "acc_bill" => $acc_bill,
                     "dc_no" => $dc_number,
                    //   "veninvverifyid" => $value['veninvverifyid'],


//   "rate" => $value['rate'],
                     "basicamt" =>$basicamt,
                    //    "gst" =>$gst,
                     "gstcamt" =>$withgsttotal,
                     "accdetuctionremarks" =>$accdetuctionremarks

                 
                ];

            }

            $json_array = [

                "data" => $data,

            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'bill_summary_popup':
        $bill_no = $_POST['bill_no'] ?? null;
        $vendor_id = $_POST['vendor_id'];
        // echo $vendor_id;
        $table_user = "vendor_creation";
        $columns = [
            "name",
            "company_name",
            "contact_no",
            "mail_id",
            "pan_no",
            "gst_no",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
            "acc_holder_name",
            "pan_attach_file_name",
              "bank_proof",
        ];
        $select_where = "unique_id='" . $vendor_id . "'";

        $table_details = [
            $table_user,
            $columns
        ];

        $result = $pdo->select($table_details, $select_where);

        $response = [];

        if ($result->status && count($result->data) > 0) {
            $vendor = $result->data[0]; // Only take first row
            $response = [
                'status' => true,
                'summary_data' => [
                    'name' => $vendor['name'],
                    'company_name' => $vendor['company_name'],
                    'contact_no' => $vendor['contact_no'],
                    'mail_id' => $vendor['mail_id'],
                    'pan_no' => $vendor['pan_no'],
                    'gst_no' => $vendor['gst_no'],
                    'address' => $vendor['address'],
                    'account_no' => $vendor['account_no'],
                    'ifsc_code' => $vendor['ifsc_code'],
                    'bank_name' => $vendor['bank_name'],
                    'branch_name' => $vendor['branch_name'],
                     'acc_holder_name' => $vendor['acc_holder_name'],
                    'pan_attach_file_name' => $vendor['pan_attach_file_name'],
                    'bank_proof' => $vendor['bank_proof'],
                ]
            ];
        } else {
            $response = [
                'status' => false,
                'summary_data' => []
            ];
        }

        echo json_encode($response);
        break;


    case 'vendor_bill_details_popup':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $unique_id =

            $data = [];
        // $po_num = $_POST['po_num'];

        $vendor = $_POST['vendor'];
        $bill_no = $_POST['bill_no'];
        $financeapproval = $_POST['financeapproval'];
        // echo $vendor;
        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // echo $table_vendor;
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            'po_num',
            "invoice_no",
            'dc_num',
            "dc_date",
            // "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            'invoice_qty',
            'rate',
            'gst',
            'amount',
            'unique_id',
            'finance_approval',
            'vendor_name',
            'bill_no',
            // "get_consignee_contact_name((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1)) AS consignee_name",
               "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.dc_num = view_outsource_vendor_verified_invoice.dc_number LIMIT 1)) AS consignee_name",

            "(SELECT invoice_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS po_date",
            'acctdsvalue',
        'accotherdeduction' ,
        'acctotalpaybleamount' ,
        'accountbillid',
         "veninvstatus",
             "inv_verfiy_attach",
             "po_ven_filename",
             "DATE_FORMAT(vendor_inv_attach_approval_date, '%d-%m-%Y') AS vendor_inv_attach_approval_date",
            //  "vendor_inv_attach_approval_date",
             "veninvverifyid",
            //  "vendor_account_approved_by",
                "get_staff_name((vendor_account_approved_by)) AS vendor_account_approved_by",

             "vendor_account_approval_date",
             "bill_date",
             
              "gst",
            "rate",
            "invoice_qty",
                "(select additional_amount from vendor_payment_details_main where vendor_payment_details.bill_no=$table_vendor.bill_no limit 1) as additional_amount"

            // "FORMAT(invoice_value, 2) AS invoice_value",
            // "accountbillid",
            // "(acctdsvalue)",
            // "vendor_bulk_rate",
            // "vendor_bulk_gst",
            // "bulk_total_amount",
            // "bulk_dc_total_amount",
            // "form_main_unique_id",
            // "vendor_payment_allocated"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        if ($financeapproval == 1 || $financeapproval == 2) {
            $where = "vendor_id = '$vendor' AND finance_approval = $financeapproval AND bill_no = '$bill_no'";
        }


        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

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

        // $group_by = "outsrc_eng_name";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        //  print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_qty = $value['invoice_qty'];

                $dc_num = $value['dc_num'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];

                $rate = $value['rate'];
                $gst = $value['gst'];
                $amnt = $value['amount'];

                $po_num = $value['po_num'];
                $bill_no = $value['bill_no'];

                   $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;

                $unique_id = $value['unique_id'];
                $date = date("d-m-Y", strtotime($value['bill_date']));

                $value['unique_id'] = '<div class="checkbox-container">
                                    <input class="myCheck" type="checkbox" name="bill_checkbox[]" data-bill-no ="' . $bill_no . '" data-unique-id = "' . $unique_id . '" 
                                    data-id = "' . $dc_num . '" data-amnt = "' . $amnt . '">
                                </div>';

                $value['po_num'] = $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>";
                $value['invoice_no'] = $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>";
                $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . (($value['dc_date'])) . "</b>";

                $value['amount'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>";
                $value['invoice_qty'] = "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>";
                $value['rate'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['rate']) . "</b></span>";
                $value['gst'] = "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>";
if($value['additional_amount']==''){
$value['additional_amount']=0;
}


                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "additional_amount" => $value['additional_amount'],
                    "consignee_name" => $value['consignee_name'],
                    "sum_amount" => $amnt,
                    "invoice_no" => $value['invoice_no'],
                    "checkbox" => $value['unique_id'],
                        "acctdsvalue" => $value['acctdsvalue'],
                    "accotherdeduction" => $value['accotherdeduction'],
                    "acctotalpaybleamount" => $value['acctotalpaybleamount'],
                    "accountbillid" => $value['unique_id'],
                     "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                     "po_ven_filename" => $value['po_ven_filename'],
                    "vendor_inv_attach_approval_date" => $value['vendor_inv_attach_approval_date'],
                    "veninvverifyid" => $value['veninvverifyid'],
                    "vendor_account_approved_by" => $value['vendor_account_approved_by'],
                    "vendor_account_approval_date" => $value['vendor_account_approval_date'],

                    "bill_date" => $date,
                       "rate" => $value['rate'],
                     "basicamt" =>$basicamt,
                       "gst" =>$gst,
                     "gstcamt" =>$withgsttotal,

 

                ];

            }

            $json_array = [

                "data" => $data,

            ];
        } else {
            print_r($result);
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



    case 'payment_store_detail':

        $po_num = $_POST['po_num'];

        $po_unique_id = $_POST['po_unique_id'];
        $invoice_no = $_POST['invoice_no'];
        $invoice_qty = $_POST['invoice_qty'];
        $dc_no = $_POST['dc_no'];
        $dc_date = $_POST['dc_date'];
        $rate = $_POST['rate'];
        $gst = $_POST['gst'];
        $amount = $_POST['amount'];
        $vendor_name = $_POST['vendor_name'];

        $vendor_bill_no = vendor_payment_bill_no();

        // print_r($vendor_bill_no);
        $prefix = "";
        // $unique_id      = ;
        $unique_id = unique_id();

        $table = 'vendor_payment_details';

        $table_inv = 'invoice_verfication_table';


        $columns = [
            "unique_id" => $unique_id,

            "bill_no" => $vendor_bill_no,
            "po_num" => $po_num,
            "po_form_unique_id" => $po_unique_id,
            "invoice_no" => $invoice_no,
            "invoice_qty" => $invoice_qty,
            "dc_num" => $dc_no,
            "dc_date" => $dc_date,
            "rate" => $rate,
            "gst" => $gst,
            "total_amount" => $amount,
            "vendor_name" => $vendor_name

        ];

        $upd_col = [
            'vendor_payment_allocated' => 1
        ];

        $update_where = [
            "dc_number" => $dc_no
        ];



        $action_obj = $pdo->insert($table, $columns);


        $action_obj_1 = $pdo->update($table_inv, $upd_col, $update_where);


        // print_r($action_obj);die();

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "create";
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




    case 'finance_approval':
        // print_r($_POST);
        // die();
        $bill_no = $_POST['bill_no'];
       $status = $_POST['acc_approval_sts'];

        $unique_id = $_POST['unique_id'];

        $reject_reason = $_POST['reject_reason'];

          $rejected_by = $_SESSION['user_id'];

        // $date = date('Y-m-d H:i:s');
        $accountbillid = $_POST['accountbillid'];


        $prev_stage = $_POST['prev_stage'];

        $dc_no = $_POST['crct_dc_num'];

        $date = date('Y-m-d H:i:s');

        $table = 'vendor_payment_details';

        $table_main = 'vendor_payment_details_main';


        $table2 = "invoice_verfication_table";



        if ($status == '1') {
            $columns = [

                "finance_approval" => $status,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                "managment_team_reject_reason"=>"",
                "managementremark"=>"",
                   "managment_team_approval_sts"=>"0",


            ];

        } 
        
        
        else if ($status == '2') {

            if($prev_stage == '2'){

                 $columns = [

                "finance_approval" => $status,
                "finance_reject_reason" => $reject_reason,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                'acctdsvalue' => "",
                'accotherdeduction' => "",
                'acctotalpaybleamount' => "",
                'accountbillid' => "",
                  "acc_ent_sts" => "0",
                'vendor_account_approved_by' => "",
                // 'vendor_account_approval_date' => "NULL",
                "vendor_account_approval_date" => null,

                'accstatus' => 2,
                // "managment_team_reject_reason"=>"",
                // "managementremark"=>"",
                //   "managment_team_approval_sts"=>"0",
                //   "managment_team_approvedby"=>"",
                //   "managment_team_approvaldate"=>"NULL"
                // "managment_team_approvaldate" => null,

                // "vendor_bill_approval"=> "",
                // 'vendor_bill_approval_date'=> "NULL",
                // 'vendor_bill_reject_reason'=> "",

            ];

            }
            else if($prev_stage == '1'){

                  $columns = [
                 "vendor_bill_app_status"      => $status,
                "vendor_bill_reject_reason"    => $reject_reason,
                "vendor_bill_approval"         => $_SESSION['user_id'],
                "vendor_bill_approval_date"    => $date,
                "is_delete"                    => 1,

            ];
            }
           


        }
        
$update_where = "bill_no = '$bill_no' AND unique_id ='$unique_id'";

      
 $action_obj = $pdo->update($table, $columns, $update_where);






  if ($status == '1') {
            $invoice_verify_columns = [
                "vendor_finance_approval" => $status,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                 "finance_reject_reason" => "",

            ];
        } else if ($status == '2') {

            if($prev_stage == '2'){


                    $invoice_verify_columns = [
                "vendor_finance_approval" => $status,
                "finance_reject_reason" => $reject_reason,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                'acctdsvalue' => "",
                'accotherdeduction' => "",
                'acctotalpaybleamount' => "",
                'accountbillid' => "",
                'vendor_account_approved_by' => "",
                // 'vendor_account_approval_date' => "NULL",
                "vendor_account_approval_date" => null,

                'accstatus' => 2,

                
                //   "vendor_bill_app_status"=>"1",
                // "vendor_bill_approval"=> "",
                // 'vendor_bill_approval_date'=> "NULL",
              
            ];
            }

            else if($prev_stage == '1'){

                 $invoice_verify_columns = [

            "vendor_bill_app_status" => $status,
            "vendor_bill_reject_reason" => $reject_reason,
            "vendor_bill_approval_allocated" => '0',
             "vendor_payment_allocated" => '0',
             'vendor_bill_no'=>"",
             "vendor_inv_attach_approval" => '',
             "vendor_inv_attach_approval_date" => '',
             "inv_verfiy_attach" => '',
             "inv_verfiy_attach_org_name" => '',
              "veninvid" => '',
             "veninvstatus" => '0',
            //   "vendor_bill_approval_allocated" => '0',
              "vendor_bill_rejected_by" => $rejected_by

            
        ];
            }


        
        }
        
        $update_where_dc = "dc_number ='$dc_no'";
   // 'vendor_bill_reject_reason'=> "",

        // print_r($action_obj);die();

        $action_obj_1 = $pdo->update($table2, $invoice_verify_columns, $update_where_dc);

        // print_r($action_obj_1);die();

        // $invoice_verify_columns = [

        //     "vendor_finance_approval" => $status,
        //     "finance_reject_reason" => $reject_reason,
        //     //  'accstatus' => 2,
        //     // "vendor_payment_allocated" => '0'

        // ];


// print_r( $action_obj_1);
      

// MAINTABLEVENDOR
         if ($status == '1') {
            $columns_main = [
                "finance_approval" => $status,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                  "managment_team_reject_reason"=>"",
                "managementremark"=>"",

            ];
        } else if ($status == '2') {

            if($prev_stage == '2'){
                       $columns_main = [

                "finance_approval" => $status,
                "finance_reject_reason" => $reject_reason,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date,
                'acctdsvalue' => "",
                'accotherdeduction' => "",
                'acctotalpaybleamount' => "",
                'accountbillid' => "",
                 "acc_ent_sts" => "0",
             

                'vendor_account_approved_by' => "",
                // 'vendor_account_approval_date' => "NULL",
                "vendor_account_approval_date" => null,
                'accstatus' => 2,
                 "acc_ent_sts" => "0",
                //   "managment_team_reject_reason"=> "",
                // "managementremark"=>"",

                
                // "finance_approval" => $status,
                // "finance_reject_reason" => $reject_reason,
                // "finance_approved_by" => $_SESSION['user_id'],
                // "finance_approved_date" => $date,
                // 'acctdsvalue' => "",
                // 'accotherdeduction' => "",
                // 'acctotalpaybleamount' => "",
                // 'accountbillid' => "",
                // 'vendor_account_approved_by' => "",
                // // 'vendor_account_approval_date' => "NULL",
                // "vendor_account_approval_date" => null,

                // 'accstatus' => 2,
                // "managment_team_reject_reason"=>"",
                // "managementremark"=>"",
                  "managment_team_approval_sts"=>"0",
                  "managment_team_approvedby"=>"",
                //   "managment_team_approvaldate"=>"NULL"
                "managment_team_approvaldate" => null,
                // "vendor_bill_app_status"=>"0",
                // "vendor_bill_approval"=> "",
                // 'vendor_bill_approval_date'=> "NULL",
                // 'vendor_bill_reject_reason'=> "",


            ];
            }
            else if($prev_stage == '1'){

                 $columns_main = [
                 "vendor_bill_app_status" => $status,
                "vendor_bill_reject_reason" => $reject_reason,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                "is_delete"=>1,
                // "vendor_bill_reject_reason" => $reject_reason,


            ];
            }
         
        }
        $update_where_main = "bill_no ='$bill_no' AND is_delete=0";

        $action_obj_main = $pdo->update($table_main, $columns_main, $update_where_main);

//  print_r( $action_obj_main);

        $total_amount = 0;

        $amount_column = [
            "(amount) as ttl_amount"
        ];

        $table_details = [

            $table,
            $amount_column
        ];

        $amount_where = "bill_no  = '$bill_no' AND finance_approval != '2' AND is_delete=0";
        // print_r('test1');die();
        $get_total_sql = $pdo->select($table_details, $amount_where);

        $get_total_result = $get_total_sql->data;
        // print_r($get_total_sql);die();


        if ($get_total_result) {
            $total_amount = $get_total_result[0]['ttl_amount'];
        }

        // print_r($action_obj);

        if ($action_obj->status) {


            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "create";
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
            "sql" => $sql,
            "total_amount" => $total_amount
        ];

        echo json_encode($json_array);
        break;




        case 'update_remark':

        $bill_no     = $_POST["bill_no"];
        $remark       =  $_POST["remark"];
         $table       = "vendor_payment_details";


       $table = "vendor_payment_details";

     $columns = [

            'finance_remark' => $remark
        ];


    $select_where = "bill_no  = '$bill_no' AND  is_delete = '0'";

    $action_obj = $pdo->update($table, $columns, $select_where);

     $table_main = "vendor_payment_details_main";

     $columns_main = [

            'finance_remark' => $remark
        ];


    $select_where_main = "bill_no  = '$bill_no' AND  is_delete = '0'";

    $action_obj_main = $pdo->update($table_main, $columns_main, $select_where_main);

    // print_r($action_obj);die();


 if ($action_obj->status) {
        $json_array = [
            "status" => 1,
            "msg"    => "update",
            "sql"    => $action_obj->sql ?? ''
        ];
    } else {
        $json_array = [
            "status" => 0,
            "msg"    => "error",
            "error"  => $action_obj->error ?? '',
            "sql"    => $action_obj->sql ?? ''
        ];
    }




  
    echo json_encode($json_array);

        break;




   

    default:

        break;
}






function vendor_payment_bill_no()
{

    $prefix = 'VEN';

    $year_month = date("Ym");

    $basePrefix = $prefix . '-' . $year_month;

    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connected successfully';
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
    }
    $stmt = $conn->prepare("SELECT * FROM vendor_payment_details where `bill_no` LIKE :prefix order by unique_id desc");

    $stmt->execute(['prefix' => $basePrefix . '-%']);

    $latestBill = $stmt->fetchColumn();

    if ($latestBill) {
        // Extract the last serial number and increment
        $parts = explode('-', $latestBill); // [VEN, 202506, 0001]
        $lastSerial = (int) end($parts);
        $nextSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $nextSerial = '0001';
    }

    return $basePrefix . '-' . $nextSerial;
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

// function formatIndianCurrency($amount)
// {
//     $amount = round($amount);
//     $num = (string) $amount;
//     $len = strlen($num);
//     if ($len > 3) {
//         $last3 = substr($num, -3);
//         $restUnits = substr($num, 0, $len - 3);
//         $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
//         return $restUnits . ',' . $last3;
//     } else {
//         return $num;
//     }
// }


function getStatusText($sts)
{
    if ($sts === '1' || $sts === 1) return 'Approved';
    if ($sts === '2' || $sts === 2) return 'Rejected';
    return 'Pending';
}

function formatIndianCurrency($amount)
{
    // Round to 2 decimal places
    $amount = number_format((float) $amount, 2, '.', '');

    // Split integer and decimal parts
    list($integer, $decimal) = explode('.', $amount);

    $len = strlen($integer);
    if ($len > 3) {
        $last3 = substr($integer, -3);
        $restUnits = substr($integer, 0, $len - 3);
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . ',' . $last3;
    } else {
        $formatted = $integer;
    }

    return $formatted . '.' . $decimal;
}


