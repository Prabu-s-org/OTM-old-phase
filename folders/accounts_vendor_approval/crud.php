<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// echo $folder_name;

// Database Country Table Name
$table = "view_payment_entry_list";
$table_claim = "view_payment_entry_list_1";
$table_main = "view_bill_submission_main_table";
$table_sub = "view_bill_submission_sub_table";
$table_main_1 = "bill_submission_main_table";
$table_sub_1 = "bill_submission_sub";
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




switch ($action) {
   

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
            // "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
           "CONCAT('<b>', bill_no, '</b>', ' <br> ', DATE_FORMAT(bill_date, '%d-%m-%Y')) AS bill_display",
            "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
            // "count(dc in(dc_num)) as dccount",
            // "COUNT(DISTINCT dc_num) AS dccount",
          
            "vendor_name",
            "SUM(amount) AS total_amount",
            "acctdsvalue",
            "accotherdeduction",
            "advancepayment",
            "acctotalpaybleamount",

             "get_staff_name((vendor_bill_approval)) AS vendor_bill_approval",
            "get_staff_name((finance_approved_by)) AS finance_approved_by",
            "get_staff_name((managment_team_approvedby)) AS managment_team_approvedbby",
          

            "account_remark",
            
            "unique_id",
             "bill_no",
            "accounts_approval",
            "vendor_id",
            "invoice_no",
            "po_num",
            "finance_approval",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_company_name(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "acctdsvalue",
            "accotherdeduction",
            "acctotalpaybleamount",
               "veninvverifyid",
              "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y')AS vendor_bill_approval_date",
             "DATE_FORMAT(finance_approved_date,'%d-%m-%Y')AS finance_approved_date",
            "DATE_FORMAT(managment_team_approvaldate,'%d-%m-%Y')AS managment_team_approvaldate",
            "bill_date",
            "managment_team_approval_sts"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = 'finance_approval = 1 AND managment_team_approval_sts = 1 AND accounts_approval IS NULL AND is_delete = 0';
        
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
        // print_r($result);die();

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

                $value['s_no'] = $sno + 1;
                $bill_no = $value['bill_no'];
                $bill_date = $value['bill_date'];

                $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';
   $value['bill_date'] =  $value['bill_date'] . '<br><b>' . $value['bill_no'] . '</b>';

                $vendor_id = $value['vendor_id'];
                $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';

                $accounts_approval = $value['accounts_approval'];
                $value['accounts_approval'] = ($accounts_approval == 1)
                    ? '<span style="color: green; font-weight: bold;">Processed</span>'
                    : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';

                $btn_update = btn_update_accounts_team($folder_name, $value['unique_id'], $vendor_id, $bill_no, $bill_date, $accounts_approval);

                // $btn_view = '<button class="btn btn-sm btn-info view-btn" data-ponum="' . $value['po_num'] . '"  data-vendor ="' . $value['outsrc_eng_name'] . '" title="View">
                // <i class="fas fa-eye"></i></button>';

                $value['unique_id'] = $btn_update;

                $vendor_name = $value['vendor_name'];
                $vendor_reg_id = $value['vendor_reg_id'];
                $address = $value['address'];
                $contact_no = $value['contact_no'];

                $value['vendor_name'] = "<div>
                            <strong>{$vendor_reg_id}</strong><br>
                            <span>{$address} - Ph.No. {$contact_no}</span>
                        </div>";
                        
if($value['vendor_inv_attach_approval_date']==""){

$value['vendor_inv_attach_approval_date']="-";
$value['veninvverifyid']="-";
 }

 else{
 $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
 
 }
 $value['finance_approved_by'] = 
    '<b>' . $value['finance_approved_by'] . '</b>&nbsp;&nbsp;<br>' . 
    ($value['finance_approved_date'] ?? '');

                 $value['vendor_bill_approval'] = 
    '<b>' . $value['vendor_bill_approval'] . '</b>&nbsp;&nbsp;<br>' . 
    ($value['vendor_bill_approval_date'] ?? '');

 if ($value['managment_team_approvedbby'] == "") {
            $value['managment_team_approvedbby'] = "-";
            $value['managment_team_approvedbby'] = "-";
        } else {
            $value['managment_team_approvedbby'] = '<b>' . $value['managment_team_approvedbby'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['managment_team_approvaldate'] . '</span>';
        }

         $value["advancepayment"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['advancepayment']) . '</span>';

     $value["acctdsvalue"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['acctdsvalue']) . '</span>';
                  $value["accotherdeduction"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['accotherdeduction']) . '</span>';
                $value['acctotalpaybleamount'] = '<span style="display:block; text-align:right;font-weight:bold"><b>' . formatIndianCurrency($value['acctotalpaybleamount']) . '</b></span>';


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


 case 'update_remark':

        $bill_no     = $_POST["bill_no"];
        $remark       =  $_POST["remark"];
         $table       = "vendor_payment_details";


       $table = "vendor_payment_details";

     $columns = [

            'account_remark' => $remark
        ];


    $select_where = "bill_no  = '$bill_no' AND  is_delete = '0'";

    $action_obj = $pdo->update($table, $columns, $select_where);

    //  print_r($action_obj);die();
 $table_main = "vendor_payment_details_main";

     $columns_main = [

            'account_remark' => $remark
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






    case 'datatable_processed':
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

        if ($length == '-1') {
            $limit = "";
        }

        $table_vendor = "vendor_payment_details_main";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
        "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
           
            "vendor_name",
            "SUM(amount) AS total_amount",
            "acctdsvalue",
            "accotherdeduction",
            "advancepayment",
            "acctotalpaybleamount",
            "transaction_type",
            "CONCAT('<b>', transaction_id, '</b>', ' <br> ', DATE_FORMAT(transaction_date, '%d-%m-%Y')) AS bill_display",
            "cash_receipt_file_name",
            "unique_id",
            "bill_no",
            "accounts_approval",
            "dc_num",
            "vendor_id",
            "invoice_no",
            "po_num",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "finance_approval",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_company_name(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "get_staff_name(accounts_approved_by) AS accounts_approved_by",
            "DATE_FORMAT(accounts_approved_date, '%d-%m-%Y') AS accounts_approved_date",
            "acctdsvalue",
            "accotherdeduction",
            "veninvverifyid",
            "bill_no",
            "cash_receipt_file_name AS cash",
            "transaction_id"

          
            // "acctotalpaybleamount"
            
        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = 'finance_approval = 1 AND accounts_approval = 1 AND is_delete=0';
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
        // print_r($result);

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

                $value['s_no'] = $sno + 1;
                $bill_no = $value['bill_no'];
                $bill_date = $value['bill_date'];

                $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';

                $vendor_id = $value['vendor_id'];
                $total_amount = $value['total_amount'];
                $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';
                // $value['acctotalpaybleamount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['acctotalpaybleamount']) . '</b></span>';
 
               

                $accounts_approval = $value['accounts_approval'];
                $value['accounts_approval'] = ($accounts_approval == 1)
                    ? '<span style="color: green; font-weight: bold;">Processed</span>'
                    : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';


                $btn_update = btn_update_accounts_team($folder_name, $value['unique_id'], $vendor_id, $bill_no, $bill_date, $accounts_approval);

                // $btn_view = '<button class="btn btn-sm btn-info view-btn" data-ponum="' . $value['po_num'] . '"  data-vendor ="' . $value['outsrc_eng_name'] . '" title="View">
                // <i class="fas fa-eye"></i></button>';

                $btn_view = '<span style="display:block; text-align:center;"><i class=" mdi mdi-eye mdi-24px view-btn" data-bill-no="' . $bill_no . '" data-bill-date="' . $value['bill_date'] . '"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '" data-vendor-address ="' . $value['address'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $total_amount . '" data-approver ="' . $value['accounts_approved_by'] . '" data-approvedate ="' . $value['accounts_approved_date'] . '" 
                 data-acctdsvalue = "' . $value['acctdsvalue'] . '" data-accotherdeduction = "' .$value['accotherdeduction'] . '" data-cash = "' .$value['cash'] . '" data-acctotalpaybleamount ="' . $value['acctotalpaybleamount'] .'" data-transaction_id ="' . $value['transaction_id'] .'" 
                 data-advancepayment ="' . $value['advancepayment'] .'"   
                 title="View"></i></span>';

                // $value['unique_id'] = ($accounts_approval == 1) ? '-' : $btn_view;
                $value['unique_id'] = $btn_view;

                $vendor_name = $value['vendor_name'];
                $vendor_reg_id = $value['vendor_reg_id'];
                $address = $value['address'];
                $contact_no = $value['contact_no'];


                $value['vendor_name'] = "<div>
                            <strong>{$vendor_reg_id}</strong><br>
                            <span>{$address} - Ph.No. {$contact_no}</span>
                        </div>";

// $accounts_approved_by="$value['accounts_approved_by']"
// $accounts_approved_by = !empty($value['accounts_approved_by']) 
//     ? date('d-m-Y', strtotime($value['accounts_approved_by'])) 
//     : '';
if ($value['vendor_inv_attach_approval_date'] == "") {
            $value['vendor_inv_attach_approval_date'] = "-";
            $value['veninvverifyid'] = "-";
        } else {
            $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
        }
                    
                    if($value['transaction_type']=='1'){
$value['transaction_type']='Cash';
                    }
                    else if($value['transaction_type']=='2'){
                        $value['transaction_type']='Bank';
                    }

                        else if($value['transaction_type']=='3'){
$value['transaction_type']='UPI';
                        }


                        $value['cash_receipt_file_name'] = image_view_3("accounts_approval", $value['unique_id'], $value['cash_receipt_file_name']);
            $value['bill_date'] = '<b>' . $value['bill_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['bill_no'] . '</span>';


              $value['acctdsvalue'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['acctdsvalue']) . '</b></span>';

                  $value['accotherdeduction'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['accotherdeduction']) . '</b></span>';
 $value["advancepayment"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['advancepayment']) . '</span>';

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
            "bank_proof",
            "pan_attach_file_name"

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
                    'bank_proof' => $vendor['bank_proof'],
                    'pan_attach_file_name' => $vendor['pan_attach_file_name'],
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

   case 'vendor_payment_details':
    // DataTable Variables
    $search = $_POST['search']['value'] ?? '';
    $length = $_POST['length'] ?? 10;
    $start  = $_POST['start'] ?? 0;
    $draw   = $_POST['draw'] ?? 1;

    $from_date = $_POST['from_date'] ?? '';
    $to_date   = $_POST['to_date'] ?? '';
    $opt       = $_POST['opt'] ?? '';

    $limit = ($length == '-1') ? "" : $length;

    $data   = [];
    $vendor = $_POST['vendor'] ?? '';
    $bill_no = $_POST['bill_no'] ?? '';

    $table_vendor = "vendor_payment_details";
    $columns = [
        "'' as s_no",
        'po_num',
        "invoice_no",
        'dc_num',
        // "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
        "dc_date",
        'invoice_qty',
        'rate',
        'gst',
        'amount',
        'unique_id',
        'finance_approval',
        'vendor_name',
        'bill_no',
        "(SELECT invoice_date 
           FROM view_outsource_vendor_verified_invoice 
           WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id 
           LIMIT 1) AS invoice_date",
        "(SELECT po_date 
           FROM view_outsource_vendor_verified_invoice 
           WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id 
           LIMIT 1) AS po_date",

            "(SELECT accotherdeduction 
           FROM vendor_payment_details_main 
           WHERE vendor_payment_details.main_unique_id = vendor_payment_details_main.main_unique_id 
           LIMIT 1) AS accotherdeduction",
            "(SELECT acctdsvalue 
           FROM vendor_payment_details_main 
           WHERE vendor_payment_details.main_unique_id = vendor_payment_details_main.main_unique_id 
           LIMIT 1) AS acctdsvalue",

            "(SELECT acctotalpaybleamount 
           FROM vendor_payment_details_main 
           WHERE vendor_payment_details.main_unique_id = vendor_payment_details_main.main_unique_id 
          and is_delete=0  ) AS acctotalpaybleamount",
           "transaction_type",
        // "transaction_date",
         "DATE_FORMAT(transaction_date, '%d-%m-%Y') AS transaction_date",
        "transaction_id",
        "cash_receipt_file_name",
        
              "gst",
            "rate",
            "invoice_qty",
            "advancepayment",
            // "",
            "DATE_FORMAT(vendor_inv_attach_approval_date, '%d-%m-%Y') AS vendor_inv_attach_approval_date",
            "inv_verfiy_attach",
            "veninvverifyid"

    ];

    $table_details = [$table_vendor, $columns];

    $where = "vendor_id = '$vendor' AND finance_approval = 1 AND bill_no = '$bill_no'";

    $order_column = $_POST["order"][0]["column"] ?? 0;
    $order_dir    = $_POST["order"][0]["dir"] ?? "asc";

    $order_by = datatable_sorting($order_column, $order_dir, $columns);

    // Datatable Searching
    $search_sql = datatable_searching($search, $columns);
    if ($search_sql) {
        $where .= " AND " . $search_sql;
    }

    $sql_function = "SQL_CALC_FOUND_ROWS";
    $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
// print_r($result);
    $total_records = total_records();

    if ($result->status) {
        $res_array = $result->data;

        foreach ($res_array as $key => $value) {
$invoice_qty = $value['invoice_qty'];
                $rate = $value['rate'];
                $gst = $value['gst'];
   $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;

            $amnt     = $value['amount'];
            $bill_no  = $value['bill_no'];
            $dc_num   = $value['dc_num'];
            $unique_id= $value['unique_id'];

            $value['unique_id'] = '<div class="checkbox-container">
                <input class="myCheck" type="checkbox" 
                       name="bill_checkbox[]" 
                       data-bill-no ="' . $bill_no . '" 
                       data-unique-id = "' . $unique_id . '" 
                       data-id = "' . $dc_num . '" 
                       data-amnt = "' . $amnt . '">
            </div>';

            $data[] = [
                "po_num"     => $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>",
                "dc_num"     => $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>",
                "dc_date"    => $value['dc_date'],
                "invoice_qty"=> "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>",
                "rate"       => "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['rate']) . "</b></span>",
                "gst"        => "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>",
                "amount"     => "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>",
                "sum_amount" => $amnt,
                "invoice_no" => $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>",
                "checkbox"   => $value['unique_id'],
                 "acctdsvalue"   => $value['acctdsvalue'],
                  "accotherdeduction"   => $value['accotherdeduction'],
                "acctotalpaybleamount"   => $value['acctotalpaybleamount'],
                "transaction_type"   => $value['transaction_type'],
                  "transaction_date"   => $value['transaction_date'],
                "transaction_id"   => $value['transaction_id'],
                "cash_receipt_file_name"   => $value['cash_receipt_file_name '],
                 "rate" => $value['rate'],
                "basicamt" =>$basicamt,
                "gst" =>$gst,
                 "gstcamt" =>$withgsttotal,
                "advancepayment" =>$value['advancepayment'],

                 "vendor_inv_attach_approval_date"=>$value['vendor_inv_attach_approval_date'],
                 "inv_verfiy_attach"=>$value['inv_verfiy_attach'],
                 "veninvverifyid"=>$value['veninvverifyid']





            ];
        }

        $json_array = [
            "draw"            => intval($draw),
            "recordsTotal"    => $total_records,
            "recordsFiltered" => $total_records,
            "status"          => true,
            "data"            => $data,
        ];
    } else {
        $json_array = [
            "draw"            => intval($draw),
            "recordsTotal"    => 0,
            "recordsFiltered" => 0,
            "status"          => false,
            "data"            => [],
            "message"         => "No data found"
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($json_array);
    break;
 
    case 'getbankdeails':
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
            'dc_date',
            'invoice_qty',
            'rate',
            'gst',
            'amount',
            'unique_id',
            'finance_approval',
            'vendor_name',
            'bill_no'

            // "FORMAT(invoice_value, 2) AS invoice_value",
            // "outsrc_eng_name",
            // "(invoice_value)",
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

        $where = "vendor_name = '$vendor' AND finance_approval = 1 AND bill_no = '$bill_no'";

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

                $unique_id = $value['unique_id'];





                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'] . ' %',
                    "amount" => $value['amount'],
                    "invoice_no" => $value['invoice_no'],
                    "checkbox" => $value['unique_id'],
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
        $vendor_name = $_POST['vendor_name'];
        $bill_no = $_POST['bill_no'];
        $transaction_type = $_POST['transaction_type'];
        $transaction_date = $_POST['transaction_date'];
        $bank_name = $_POST['bank_name'];
        $ifsc_code = $_POST['ifsc_code'];
        $account_no = $_POST['account_no'];
        $branch_name = $_POST['branch_name'];
        $online_type = $_POST['online_type'];
        $upi_id = $_POST['upi_id'];
        $upi_mobile = $_POST['upi_mobile'];
        $transaction_id_1 = $_POST['transaction_id_1'] ?? '';
        $transaction_id_2 = $_POST['transaction_id_2'] ?? '';
        $payment_id = $_POST['payment_id'] ?? '';
        $bank_namenew = $_POST['banknamenew'] ?? '';

        

        $transaction_id = !empty($transaction_id_1) ? $transaction_id_1 : $transaction_id_2;

        // $file_names = '';
        // $file_org_names = '';

        // if ($transaction_type == 1 && isset($_FILES['cash_receipt']) && $_FILES['cash_receipt']['error'] == 0) {
        //     $allowedExts = ['pdf'];
        //     $extension = pathinfo($_FILES['cash_receipt']['name'], PATHINFO_EXTENSION);

        //     if ($_FILES['cash_receipt']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
        //         $tem_name = "RECEIPT-" . preg_replace('/[^A-Za-z0-9]/', '', $bill_no) . '-' . time() . '.pdf';
        //         $upload_path = '../../uploads/accounts_approval/';

        //         // Make sure directory exists
        //         if (!file_exists($upload_path)) {
        //             mkdir($upload_path, 0777, true);
        //         }

        //         if (move_uploaded_file($_FILES['cash_receipt']['tmp_name'], $upload_path . $tem_name)) {
        //             $file_names = $tem_name;
        //             $file_org_names = $_FILES['cash_receipt']['name'];
        //         }
        //     }
        // }
        $file_names = '';
$file_org_names = '';

if ($transaction_type == 1 && isset($_FILES['cash_receipt']) && $_FILES['cash_receipt']['error'] == 0) {
    // ✅ Allowed file types
    $allowedExts = ['pdf', 'jpg', 'jpeg', 'png'];
    $allowedMime = [
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];

    $extension = strtolower(pathinfo($_FILES['cash_receipt']['name'], PATHINFO_EXTENSION));
    $mime_type = mime_content_type($_FILES['cash_receipt']['tmp_name']);

    if (in_array($extension, $allowedExts) && in_array($mime_type, $allowedMime)) {
        // ✅ Set proper filename extension
        $tem_name = "RECEIPT-" . preg_replace('/[^A-Za-z0-9]/', '', $bill_no) . '-' . time() . '.' . $extension;
        $upload_path = '../../uploads/accounts_approval/';

        // ✅ Ensure upload directory exists
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        if (move_uploaded_file($_FILES['cash_receipt']['tmp_name'], $upload_path . $tem_name)) {
            $file_names = $tem_name;
            $file_org_names = $_FILES['cash_receipt']['name'];
        }
    }
}


        // $vendor_bill_no = vendor_payment_bill_no();

        // print_r($vendor_bill_no);
        $prefix = "";
        // $unique_id      = ;
        // $unique_id = unique_id();

        $table = 'vendor_payment_details';
        $table_main = 'vendor_payment_details_main';

        $upd_col = [

            'accounts_approval' => 1,
            'transaction_type' => $transaction_type ?: null,
            'transaction_date' => $transaction_date ?: null,
            'bank_name' => $bank_name ?: null,
            'banknamenew' => $bank_namenew ?: null,
            'ifsc_code' => $ifsc_code ?: null,
            'account_no' => $account_no ?: null,
            'branch_name' => $branch_name ?: null,
            'upi_method' => $online_type ?: null,
            'upi_id' => $upi_id ?: null,
            'upi_mobile_no' => $upi_mobile ?: null,
            'cash_receipt_file_name' => $file_names ?: null,
            'cash_receipt_file_org' => $file_org_names ?: null,
            'accounts_approved_by' => $_SESSION['user_id'],
            'accounts_approved_date' => date('Y-m-d H:i:s'),
            'transaction_id' => $transaction_id ?: null,
            'payment_id' => $payment_id ?: null,

            
        ];

        $update_where = [
            "bill_no" => $bill_no,
              "is_delete"=>0
            // "accounts_approval" => 1
        ];
        // print_r($bill_no);

        $action_obj = $pdo->update($table, $upd_col, $update_where);

// print_r(   $action_obj );


        $upd_col_main = [

            'accounts_approval' => 1,
            // 'accounts_approval' => null,
            'transaction_type' => $transaction_type ?: null,
            'transaction_date' => $transaction_date ?: null,
            'bank_name' => $bank_name ?: null,
            'banknamenew' => $bank_namenew ?: null,
            'ifsc_code' => $ifsc_code ?: null,
            'account_no' => $account_no ?: null,
            'branch_name' => $branch_name ?: null,
            'upi_method' => $online_type ?: null,
            'upi_id' => $upi_id ?: null,
            'upi_mobile_no' => $upi_mobile ?: null,
            'cash_receipt_file_name' => $file_names ?: null,
            'cash_receipt_file_org' => $file_org_names ?: null,
            'accounts_approved_by' => $_SESSION['user_id'],
            'accounts_approved_date' => date('Y-m-d H:i:s'),
            'transaction_id' => $transaction_id ?: null,
             'payment_id' => $payment_id ?: null,
            // payment_id
            //    'payment_id' =>vendor_payment_bill_no(),
        ];

        $update_where_main = [
            "bill_no" => $bill_no,
            "is_delete"=>0
            // "accounts_approval" => 1
        ];

        $action_obj_main = $pdo->update($table_main, $upd_col_main, $update_where_main);
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
   $password = project_env('VENDOR_DB_PASSWORD');
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
                    $image_view_3 .= '<a href="javascript:print_pdf(\'/' . $file_name . '\')"><img src="uploads/accounts_approval/pdf.png"  height="30px" width="50px" ></a>';
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


