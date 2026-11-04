<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

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
case 'inv_verify_update':

    $table_vendor = "vendor_payment_details";
    $table_verify = "invoice_verfication_table";

    $table_vendor_main = "vendor_payment_details_main";

    // Get posted data
    $totinvvalue = isset($_POST["totinvvalue"]) ? explode(',', $_POST["totinvvalue"]) : [];
    $tdsvalue = isset($_POST["tdsvalue"]) ? round((float)$_POST["tdsvalue"]) : 0;
    $add_charge = $_POST["add_charge"] ?? 0;
    $tdsvaluepercentage = $_POST["tdsvaluepercentage"] ?? 0;
    $ottdsvalue = $_POST["ottdsvalue"] ?? 0;
    // $overalltotpayment = $_POST["overalltotpayment"] ?? 0;
    $unique_ids = isset($_POST["unique_id"]) ? explode(',', $_POST["unique_id"]) : [];
    $vendorid = $_POST["accid"] ?? '';
    $approved_by = $_POST["approved_by"] ?? '';
    $vendorbill_no = $_POST["vendorbill_no"] ?? '';
    $otremarks = $_POST["otremarks"] ?? '';
    //    $bulk_eng_name = isset($_POST["bulk_eng_name"]) ? explode(',', $_POST["bulk_eng_name"]) : [];

    $overalltotpayment = $_POST["netamount"] ?? 0;
    $totaltdsvalue = $_POST["totaltdsvalue"] ?? 0;
    $adpayment = $_POST["adpayment"] ?? 0;

    

    $date = date('Y-m-d H:i:s');
    

    // Common update columns
    $columns_verify = [

        'acctdsvalue' => $tdsvalue,
        'tdsvaluepercentage' => $tdsvaluepercentage,
        'accotherdeduction' => $ottdsvalue,
        'acctotalpaybleamount' => $overalltotpayment,
        'accountbillid' => $vendorid,
        'add_charge' => $add_charge,
        'vendor_account_approved_by' => $approved_by,
        'vendor_account_approval_date' => $date,
        'accstatus' => 1,
        'accdetuctionremarks'=>$otremarks,
        'finance_reject_reason'=>"",
        'finance_remark'=>"",
        'finance_approval'=>'0',
        "acc_ent_sts" =>"1",

        "finance_approved_by"=>"",
        "finance_approved_date"=>"",
        'advancepayment'=>$adpayment,
        // 'Totaltdsamount'=>$adpayment 
        'Totaltdsamount'=>$totaltdsvalue 
        


        // "accstatus"=>'0'
        // "account_bill_entry_approval" => $_SESSION['user_id'],
        //  "account_bill_entry_approval_date" => $date,
    ];

    $results = [];
    $status = true;
    $error = "";
    $sql = "";

    // Update all invoice rows
    foreach ($unique_ids as $uid) {
        $uid = trim($uid);
        if (empty($uid)) continue;

        $update_where = [ "main_unique_id" => $uid ];
        $action_obj = $pdo->update($table_vendor, $columns_verify, $update_where);
// print_r(   $action_obj);
        $results[] = [
            "unique_id" => $uid,
            "status" => $action_obj->status ?? false,
            "error" => $action_obj->error ?? '',
            "sql" => $action_obj->sql ?? ''
        ];

        if (!$action_obj->status) {
            $status = false;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
        }
    }

    // Update summary table
    $columns_verify_main = $columns_verify;
    $update_where_main = [ "bill_no" => $vendorbill_no,
    // "vendor_id" => $bulk_eng_name,
 ];
    $action_obj_1 = $pdo->update($table_vendor_main, $columns_verify_main, $update_where_main);
// print_r( $action_obj_1);
    if (!$action_obj_1->status) {
        $status = false;
        $error = $action_obj_1->error;
        $sql = $action_obj_1->sql;
    }

    // Final response
    $json_array = [
        "status" => $status,
        "data" => $results,
        "error" => $error,
        "msg" => $status ? 'create' : 'error',
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
        // $table_vendor = "view_vendor_approval_list";
        $table_vendor = "vendor_payment_details";

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
             "DATE_FORMAT(bill_date,'%d-%m-%Y') AS bill_date",
             "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
            // "outsrc_eng_name",
            "vendor_name",
            // "COUNT(dc_number) as dc_number",
            "count(dc_num) as dc_count",   
        //    "ROUND(SUM(amount),2)as rounded_invoice_value",
           "ROUND(total_amount,2)as rounded_invoice_value",
            // "ROUND(SUM(bulk_total_amount),2)as rounded_invoice_value",
            "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",
           
                    "CASE 
                WHEN managment_team_approval_sts = 2 
                THEN managment_team_approval_sts 
                ELSE accstatus 
            END AS venbill_status",

                    "CASE 
                WHEN managment_team_approval_sts = 2 
                THEN managment_team_reject_reason 
                ELSE finance_reject_reason 
            END AS reject_reason",

        "CASE 
            WHEN managment_team_approval_sts = 2 
            THEN get_staff_name(managment_team_approvedby)
            ELSE get_staff_name(finance_approved_by)
        END AS rejected_by",

            // "finance_reject_reason",
            "unique_id",
            "invoice_no",
            "po_num",
            // "vendor_payment_allocated",
            // "vendor_finance_approval",
            "finance_approval",
            // ""
            // "bulk_eng_name",
            // "dc_required",
            // "document_verification_status",
            "get_vendor_address(vendor_id) AS address",
            // "get_vendor_id(vendor_id) AS vendor_id",
             "get_vendor_company_name(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "vendor_id",
             "get_vendor_company_name(vendor_id) AS name",
            //  "vendor_bill_approval_allocated",
            // "vendor_bill_approval",
             "veninvstatus",
              "MAX(veninvverifyid) AS veninvverifyid",
                "vendor_bill_app_status",
                //  "",
              
                // "vendor_bill_approval_date",
                 "DATE_FORMAT(vendor_bill_approval_date, '%d-%m-%Y') AS vendor_bill_approval_date",
                "vendor_bill_reject_reason",
                "bill_no",
                // "bill_date",
                 "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
                 "main_unique_id",
                 "get_staff_name(vendor_bill_created_by)as vendor_bill_created",
                 "vendor_bill_created_date"

                // "accstatus"
                // "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",

                //  ""
           


           
        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        // $where = "document_verification_status = 2 AND (dc_required IS NULL OR TRIM(dc_required) != '1') ";

        // $where = ' AND vendor_payment_allocated = 1 AND vendor_bill_approval_allocated = 1 AND veninvstatus = 1 AND(accstatus=0)';
        $where = "vendor_bill_app_status = 1 AND is_delete='0'  AND (accstatus='0'  OR accstatus ='2') AND (managment_team_approval_sts = '0' or managment_team_approval_sts = '2')";

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

       $group_by = "bill_no, vendor_id";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);

        //  print_r($result);die();s

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

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';

                $outsrc_eng_name = $value['outsrc_eng_name'];

                $dc_number = $value['dc_number'];

                // $vendor_name = $value['bulk_eng_name'];

                // $address = $value['address'];

                $vendor_id = $value['vendor_id'];

                // $contact_no = $value['contact_no'];
                   $get_vendor_company_name = $value['name'];

                // $value['vendor_name'] = "<div> <b style='font-size:16px;'>{$get_vendor_company_name}</b><br>
                //         <strong>{$vendor_id}</strong><br>
                //         <span>{$address} - Ph.No. {$contact_no}</span>
                //     </div>";
 $value["dc_count"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['dc_count'] . '</span>';
                
                 $vendor_reg_id = $value['vendor_reg_id'];
        $address = $value['address'];
        $contact_no = $value['contact_no'];

        $value['vendor_name'] = "<div>
            <strong>{$vendor_reg_id}</strong><br>
            <span>{$address} - Ph.No. {$contact_no}</span>
        </div>";

                $value['dc_number'] = '<span style="display:block; text-align:right;">' . $value['dc_number'] . '</span>';
              

                $value['rounded_invoice_value'] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['rounded_invoice_value']) . '</span>';

               $btn_view = '<span style="display:block; text-align:center;">
    <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green view-btn"
       data-ponum="' . $value['po_num'] . '"
       data-bill-no="' . $value['bill_no'] . '"
       data-vendor-id="' . $value['vendor_id'] . '"
       data-vendor="' . $outsrc_eng_name . '"
       data-bill-date="' . $value['bill_date'] . '"
       data-financerejectreason="' . $value['vendor_bill_reject_reason'] . '"
       data-financeapproval="' . $value['vendor_bill_app_status'] . '"
       data-approver="' . $value['vendor_bill_approval'] . '"
       data-approvedate="' . $value['vendor_bill_approval_date'] . '"
       data-main_unique_id="' . $value['main_unique_id'] . '"
       data-venunique_id="' . $value['main_unique_id'] . '"
       data-additional-amount="' . $value['additional_amount'] . '"

        data-vendor-bill-created-by="' . $value['vendor_bill_created'] . '"
       data-vendor-bill-created-date="' . $value['vendor_bill_created_date'] . '"       
       
       title="View">
    </i>
</span>';
 
                // <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>
                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";

                }


               $accstatus = $value['venbill_status'];  // though this sounds odd; maybe should be $value['accstatus'] ?

if ($accstatus == '0') {
    $value['venbill_status'] = '<span style="color: orange; font-weight: bold;">Pending</span>';
} else if ($accstatus == '1') {
    $value['venbill_status'] = '<span style="color: green; font-weight: bold;">Approved</span>';
} else {
    $value['venbill_status'] = '<span style="color: red; font-weight: bold;">Rejected</span>';
}

// Format the date to dd-mm-yyyy
$formattedDate = date('d-m-Y', strtotime($value['vendor_bill_approval_date']));

$value['vendor_bill_approval'] = '<b><span style="display:block;">' 
    . $value['vendor_bill_approval']
    . '<br>'  // line break between approval status and date
    . $formattedDate 
    . '</span>';

$value['bill_date'] = '<b>' . $value['bill_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['bill_no'] . '</span>';

if($value['vendor_inv_attach_approval_date']==""){

$value['vendor_inv_attach_approval_date']="-";
$value['veninvverifyid']="-";
 }
 else{
 $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
 }

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


    case 'datatable_billed':
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
            "DATE_FORMAT(bill_date,'%d-%m-%Y') AS bill_date",
             "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
            "vendor_name",
            "COUNT(dc_num) AS dc_count",
            // "IFNULL(SUM(amount), 0) AS total_amount",
            "total_amount",
            "acctdsvalue",
            "accotherdeduction",
            "advancepayment",
            "acctotalpaybleamount",
            // "IFNULL(SUM(acctotalpaybleamount), 0) AS acctotalpaybleamount",
            "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",
            // "get_staff_name(vendor_account_approved_by) AS vendor_account_approved_by",
             "unique_id",
            "bill_no",
            "veninvverifyid",
            "finance_approval",
            "dc_num",
            "vendor_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "get_vendor_mail(vendor_id) AS mail",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_company_name(vendor_id) AS vendor_id_value",
            "get_staff_name(sess_user_id) AS accounts_approved_by",
            "DATE_FORMAT(created, '%d-%m-%Y') AS accounts_approved_date",
            // "acctotalpaybleamount",
            "vendor_account_approval_date",
                 "DATE_FORMAT(vendor_bill_approval_date, '%d-%m-%Y') AS vendor_bill_approval_date",
"total_amount",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",

            // "(SELECT acc_holder_name from vendor_creation WHERE vendor_creation.unique_id = vendor_payment_details.vendor_id LIMIT 1) AS acc_holder_name",
            // "(SELECT pan_attach_file_name from vendor_creation WHERE vendor_creation.unique_id = vendor_payment_details.vendor_id LIMIT 1) AS pan_attach_file_name",
            // "(SELECT bank_proof from vendor_creation WHERE vendor_creation.unique_id = vendor_payment_details.vendor_id LIMIT 1) AS bank_proof",

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";


        // $where = 'vendor_payment_allocated = 0';       
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


        $where .= " accstatus='1' and is_delete='0'";
        // finance_approval = '0' AND


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

        // $group_by = "bill_no";
        $group_by = "vendor_id,bill_no";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);
        // print_r($result);die();
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        // print_r($screen_id_val);die();
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];

        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;

        // print_r($table_users);die();
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

               

                $vendor_id_value = $value['vendor_id_value'];
                $bill_date = $value['bill_date'];

                $vendor_name = $value['vendor_name'];

                $contact_no = $value['contact_no']; // assuming vendor_id is the unique_id

                $address = $value['address']; // assuming vendor_id is the unique_id

                $value['s_no'] = $sno + 1;

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';

                $dc_num = $value["dc_num"];

                $total_amount = $value["total_amount"];
                // $value["acctdsvalue"] = '<SPAN style="text-align:right">'.$value["acctdsvalue"]'.</SPAN>';

            

                $btn_view = '<span style="display:block; text-align:center;"><i class=" mdi mdi-eye view-btn-2" data-bill-no="' . $value['bill_no'] . '"data-bill-date="' . $bill_date . '"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '" data-vendor-address ="' . $value['address'] . '"data-vendor-mail ="' . $value['mail'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $value['total_amount'] . '" data-approver ="' . $value['accounts_approved_by'] . '" data-approvedate ="' . $value['accounts_approved_date'] . '" title="View"></i></span>';

                $value["total_amount"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['total_amount']) . '</span>';
 $value['bill_date'] = '<b>' . $value['bill_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['bill_no'] . '</span>';
 if($value['vendor_inv_attach_approval_date']==""){

$value['vendor_inv_attach_approval_date']="-";
$value['veninvverifyid']="-";
 }

 else{
 $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
 
 }

                $value["acctdsvalue"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['acctdsvalue']) . '</span>';
                $value["advancepayment"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['advancepayment']) . '</span>';


            //      "accotherdeduction",
            // "IFNULL(SUM(acctotalpaybleamount), 0) AS acctotalpaybleamount",
                  $value["accotherdeduction"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['accotherdeduction']) . '</span>';
                    $value["acctotalpaybleamount"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['acctotalpaybleamount']) . '</span>';



                // $value["dc_count"] = '<span style="text-align:center; font-weight:bold">' . $value['dc_count'] . '</span>';
                $value["dc_count"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['dc_count'] . '</span>';
              $value["vendor_account_approved_by"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['vendor_account_approved_by'] . '<br>'. $value['vendor_account_approval_date'] . '</span>';

               $value["acctdsvalue"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['acctdsvalue'] . '</span>';
               $value["accotherdeduction"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['accotherdeduction'] . '</span>';

                // $value["acctotalpaybleamount"] = '<span style="display: inline-block; width: 100%; text-align: right; font-weight:bold">' . $value['acctotalpaybleamount'] . '</span>';
               

                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";

                }

                $value['vendor_name'] = "<div>
                        <strong>{$vendor_id_value}</strong><br>
                        <span>{$address} <br> Ph.No. {$contact_no}</span>
                    </div>";
                    // / Format the date to dd-mm-yyyy
$formattedDate = date('d-m-Y', strtotime($value['vendor_bill_approval_date']));

$value['vendor_bill_approval'] = '<b><span style="display:block;">' 
    . $value['vendor_bill_approval']
    . '</span>'  // line break between approval status and date
    . $formattedDate;  // Concatenate the formatted date properly


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

    "managed_approve" => $value['managed_approve'] ?? '',
    "managment_team_approvaldate" => $value['managment_team_approvaldate'] ?? '',
    "management_status" => getStatusText($value['managment_team_approval_sts'] ?? 0),
    "payment_status" => ($value['payment_status'] == '1')
    ? '<span class="text-success fw-semibold">Paid</span>'
    : '<span class="text-warning fw-semibold">Pending</span>',
     "transfer_date" => $value['transfer_date'] ?? '',
                    "transfer_amount" => $value['transfer_amount'] ?? '',
                    "udr" => $value['udr'] ?? '',
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



         case 'rej_status_update':
        // print_r($_POST);die();
        // die();
        $bill_no = $_POST['vendor_bill_no'];

       $status = $_POST['app_sts'];

      

        $reject_reason = $_POST['reject_reason'];


      

        $date = date('Y-m-d H:i:s');

        $table = 'vendor_payment_details';
        $table_main = 'vendor_payment_details_main';

        $table2 = "invoice_verfication_table";

        if ($status == '1') {
            $columns = [
                "vendor_bill_app_status" => $status,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date

            ];
        } else if ($status == '2') {

            $columns = [
                 "vendor_bill_app_status"      => $status,
                "vendor_bill_reject_reason"    => $reject_reason,
                "vendor_bill_approval"         => $_SESSION['user_id'],
                "vendor_bill_approval_date"    => $date,
                "is_delete"                    => 1,

            ];
        }
        
        $update_where = "bill_no = '$bill_no'";

        $action_obj = $pdo->update($table, $columns, $update_where);

//  print_r(  $action_obj );die();
         if ($status == '1') {
            // alert("hi");
            $invoice_verify_columns = [
                "vendor_bill_app_status" => $status,
                // "vendor_bill_approval" => $_SESSION['user_id'],
                // "vendor_bill_approval_date" => $date,
                 "vendor_bill_approval_allocated" => '1',
                  "vendor_bill_reject_reason" => "",

            ];
        } else if ($status == '2') {
// alert("hlo");
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
              "vendor_bill_approval_allocated" => '0'

            
        ];
        
        }
        $update_where_dc = "dc_number ='$dc_no'";

        $action_obj_1 = $pdo->update($table2, $invoice_verify_columns, $update_where_dc);
    //    print_r(  $action_obj_1);
        if ($status == '1') {
            $columns_main = [
                "vendor_bill_app_status" => $status,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                

            ];
        } else if ($status == '2') {

            $columns_main = [
                 "vendor_bill_app_status" => $status,
                "vendor_bill_reject_reason" => $reject_reason,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                "is_delete"=>1,
                // "vendor_bill_reject_reason" => $reject_reason,


            ];
        }
        
        $update_where_main = "bill_no = '$bill_no' and is_delete=0";

        $action_obj_main = $pdo->update($table_main, $columns_main, $update_where_main);
// print_r(  $action_obj);
// print_r(  $action_obj_main);



        $total_amount = 0;

        $amount_column = [
            "(amount) as ttl_amount"
        ];

        $table_details = [

            $table,
            $amount_column
        ];

        $amount_where = "bill_no  = '$bill_no' AND dc_number ='$dc_no' and  vendor_bill_app_status != '2'";
        // print_r('test1');die();
        $get_total_sql = $pdo->select($table_details, $amount_where);

        $get_total_result = $get_total_sql->data;
        // print_r($get_total_sql);die();


        if ($get_total_result) {
            $total_amount = $get_total_result[0]['ttl_amount'];
        }

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
            "sql" => $sql,
            "total_amount" => $total_amount
        ];

        echo json_encode($json_array);
        break;


    case 'bill_summary_popup':
        $bill_no = $_POST['bill_no'] ?? null;
        $vendor_id = $_POST['vendor_id'];
        //  echo $vendor_id;
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
            //   "(select dc_number from invoice_verfication_table where invoice_verfication_table.engineer_name= $table_user.unique_idr)  as  dc_number",
           
        //    "(SELECT dc_number FROM invoice_verfication_table WHERE invoice_verfication_table.engineer_name = vendor_creation.unique_id group by invoice_verfication_table.engineer_name) AS dc_number",
 // "pan_attach_file_org_name",
            // "bank_proof_org_name",
            "unique_id"
        ];
        $select_where = "unique_id='" . $vendor_id . "'";

        $table_details = [
            $table_user,
            $columns
        ];

        $result = $pdo->select($table_details, $select_where);
// print_r(  $result);
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
                    'unique_id' => $vendor['unique_id'],
                    // 'dc_number' => $vendor['dc_number'],

                    
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

        $po_num = $_POST['po_num'];

        $vendor = $_POST['vendor_id'];
        $bill_no = $_POST['bill_no'];
        $main_unique_id_1 = $_POST['main_unique_id'];

        

        //  bill_no: bill_no,

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "view_vendor_approval_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            'get_po_number(form_main_unique_id) AS po_num',
            'po_date',
            "invoice_no",
            'dc_number',
            
            'get_address(consignee_unique_id)AS consignee_name',
            // 'get_consignee_contact_name(consignee_unique_id) AS consignee_name',
            'invoice_qty',
            "outsrc_eng_name",
            "(invoice_value)",
            "vendor_bulk_rate",
            "vendor_bulk_gst",
            "bulk_total_amount",
            "unique_id",
            'DATE_FORMAT(dc_date,"%d-%m-%Y") as dc_date',
            'DATE_FORMAT(invoice_date,"%d-%m-%Y") as invoice_date',
            'DATE_FORMAT(po_date,"%d-%m-%Y") as po_date',
            "invoice_no",
            "form_main_unique_id",
            "vendor_payment_allocated",
            "vendor_finance_approval",
            "bulk_eng_name",
            "document_verification_status",
            "dc_required",
            "engineer_name",
            'invoice_date',
            "invoice_value",
            "venunique_id",
             'get_vendor_company_name(engineer_name) AS vendcom',
              "vendor_bill_approval_allocated",
             "veninvstatus",
             "inv_verfiy_attach",
             "po_ven_filename",
            //  "vendor_inv_attach_approval_date",
            "DATE_FORMAT(vendor_inv_attach_approval_date, '%d-%m-%Y') AS vendor_inv_attach_approval_date",
             "veninvverifyid",
             "vendor_bill_approval",
             "vendor_bill_approval_date",
             "bill_no",
             "dc_number as dc_no",
             "total_amount",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",
             "(SELECT rate FROM vendor_payment_details vpd WHERE vpd.bill_no = $table_vendor.bill_no AND vpd.dc_num = $table_vendor.dc_number AND vpd.is_delete = 0 LIMIT 1) as vpd_rate",
             "(SELECT gst FROM vendor_payment_details vpd WHERE vpd.bill_no = $table_vendor.bill_no AND vpd.dc_num = $table_vendor.dc_number AND vpd.is_delete = 0 LIMIT 1) as vpd_gst",
             "(SELECT amount FROM vendor_payment_details vpd WHERE vpd.bill_no = $table_vendor.bill_no AND vpd.dc_num = $table_vendor.dc_number AND vpd.is_delete = 0 LIMIT 1) as vpd_amount",

            //  "bulk_eng_name"
            
            
            //  "get_staff_name(MAX(accountbillid)) AS accountbillid",
            //  "vendor_account_approved_by",
            //  "vendor_account_approval_date",
            //  "accstatus"

        //       "MAX(veninvverifyid) AS veninvverifyid",
        // "vendor_bill_app_status",
        // //  "",
        //  "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",
        // "vendor_bill_approval_date",
        // "vendor_bill_reject_reason",
        // "bill_no",
        // "bill_date"

            // "bulk_eng_type"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        // $where = "";

        $where = " bill_no='$bill_no'";
        // AND venunique_id='$main_unique_id_1
        // engineer_name = '$vendor' AND

        // $where .= " AND document_verification_status = 2 AND (dc_required IS NULL OR TRIM(dc_required) != '1') ";

        // $where .= ' AND vendor_payment_allocated = 1 AND vendor_bill_approval_allocated = 1 AND veninvstatus = 1 ';
        // $GROUP
        // $where .= ' AND vendor_payment_allocated = 0 AND  ((vendor_finance_approval = 2) or (vendor_finance_approval = 0)) ';

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order



        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }
  $group_by = "";
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function,$group_by);
// PRINT_R( $result );
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_qty = $value['invoice_qty'];

                $dc_number = $value['dc_number'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];

                $rate = (!empty($value['vpd_rate']) && $value['vpd_rate'] > 0) ? $value['vpd_rate'] : $value['vendor_bulk_rate'];
                //  $rate1 += $value['vendor_bulk_rate'];

                $gst = (isset($value['vpd_gst']) && $value['vpd_gst'] !== '') ? $value['vpd_gst'] : $value['vendor_bulk_gst'];

                $amnt = $value['bulk_total_amount'];

                $amnt1 += $value['bulk_total_amount']; // accumulate total
                

                $po_num = $value['po_num'];

                $form_main_unique_id = $value['form_main_unique_id'];

                $vendor_name_id = $value['engineer_name'];


                $dc_no = $value['dc_no'];

                $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;
                $toatlgstamt += $basicamt + $withgsttotal;

            //    print_r($toatlamt);

                $value['unique_id'] = '<div class="checkbox-container">
                    <input class="myCheck" type="checkbox" name="bill_checkbox[]"  checked 
                         data-qty="' . $invoice_qty . '" 
data-invoice-num="' . $invoice_no . '" 
data-dcdate="' . $dc_date . '" 
data-rate="' . $rate . '" 
data-gst="' . $gst . '" 
data-amnt="' . $toatlamt . '" 
data-form_main_id="' . $form_main_unique_id . '" 
data-po-num="' . $po_num . '" 
data-id="' . $dc_number . '" 
data-vendor-id="' . $vendor_name_id . '" 
data-basicamt="' . $basicamt . '" 
data-withgsttotal="' . $withgsttotal . '" 
data-invoice_date="' . $value['invoice_date'] . '" 
data-invoice_value="' . $toatlamt . '" 
data-vendor_bulk_rate="' . $rate . '" 
data-vendor_bulk_gst="' . $gst . '" 
data-toatlamt="' . $toatlamt . '" 
data-unique_id="' . $value['unique_id'] . '"
data-venunique_id="' . $value['venunique_id'] . '"
data-bulk_eng_name="' . $value['bulk_eng_name'] . '"
data-vendcom="' . $value['vendcom'] . '"
 data-billno="' .  $value['bill_no'] . '"  
data-vendor ="' . $vendor_id . '" 
data-additional-amount ="' . $value['additional_amount']  . '" 
data-vendor_inv_attach_approval_date="' .  $value['vendor_inv_attach_approval_date'] . '"  
data-veninvverifyid ="' .  $value['veninvverifyid']. '" 
data-vendor_bill_approval="' .  $value['vendor_bill_approval'] . '"  
data-vendor_bill_approval_date ="' .  $value['vendor_bill_approval_date']. '" 
    



                    </div>';
//   data-vendor_account_approved_by="' .  $value['vendor_account_approved_by'] . '"  
// data-vendor_account_approval_date ="' .  $value['vendor_account_approval_date']. '" 
           
                $value['dc_number'] = $value['dc_number'] . '&nbsp;&nbsp;<br><b>' . $value['dc_date'] . '</b>';
                $value['po_num'] = $value['po_num'] . '&nbsp;&nbsp;<br><b>' . $value['po_date'] . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '&nbsp;&nbsp;<br><b>' . $value['invoice_date'] . '</b>';

                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_number" => $value['dc_number'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "vendor_bulk_rate" => $rate,
                    "vendor_bulk_gst" => $gst,
                    "bulk_total_amount" => $toatlamt,
                    // "bulk_total_amount" => $value['bulk_total_amount'],
                    "invoice_no" => $value['invoice_no'],
                    "checkbox" => $value['unique_id'],
                    "consignee_name" => $value['consignee_name'],
                    "invoice_date" => $value['invoice_date'],
                     "vendcom" => $value['vendcom'],
                       "vendor_inv_attach_approval_date" => $value['vendor_inv_attach_approval_date'],
                     "veninvverifyid" => $value['veninvverifyid'],

                    "unique_id" => $value['unique_id'],
                 "vendor_bill_approval" => $value['vendor_bill_approval'],

                    "vendor_bill_approval_date" => $value['vendor_bill_approval_date'],
                "vendor_account_approved_by" => $value['vendor_account_approved_by'],

                    "vendor_account_approval_date" => $value['vendor_account_approval_date'],
                    "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                     "po_ven_filename" => $value['po_ven_filename'],
                    "bill_no" => $value['bill_no'],
                    "total_amount" => $value['total_amount'],
                    "additional_amount" => $value['additional_amount'],
                     "sumoftotal" =>$amnt1,
                     "basicamt" =>$basicamt,
                     "toatlgstamt" =>$toatlgstamt,
                     "gstcamt" =>$withgsttotal,
                     "dc_no" => $dc_no
 
                ];

            }

            $json_array = [

                "data" => $data,

            ];
        }
         else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'vendor_payment_details_popup':
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
            // 'po_num',
            // "get_po_num_by_po_unique_id(po_form_unique_id) AS po_num",
            'get_po_number(po_form_unique_id) AS po_num',
            'invoice_no',
            'dc_num',
            // 'DATE_FORMAT(dc_date,"%d-%m-%Y") as dc_date',
            'dc_date',
            "amount",
            "unique_id",
            // "get_consignee_contact_name((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1)) AS consignee_name",
              "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.dc_num = view_outsource_vendor_verified_invoice.dc_number LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS po_date",
            // "(veninvverifyid)",
            "veninvverifyid",
            "vendor_inv_attach_approval_date",
            "bill_date",
            "get_staff_name((vendor_account_approved_by)) AS vendor_account_approved_by",
            //  "vendor_account_approved_by",
             "vendor_account_approval_date",
             "accstatus",
             "inv_verfiy_attach",
             "po_ven_filename",
             "accountbillid",
             "acctotalpaybleamount",
            "acctdsvalue",
            "accotherdeduction",
            "gst",
            "rate",
            "invoice_qty",
           "advancepayment",
            "total_amount",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",


        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "bill_no = '$bill_no' AND is_delete = 0   and accstatus='1'";

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

                $po_num = $value['po_num'];

                $invoice_no = $value['invoice_no'];

                $dc_num = $value['dc_num'];

                $dc_date = $value['dc_date'];

                $amount = $value['amount'];

                $consignee_name = $value['consignee_name'];
                $rate = $value['rate'];

                $gst = $value['gst'];
                $invoice_qty = $value['invoice_qty'];


                // $amnt = $value['total_amount'];

                // $po_num = $value['po_num'];

                // $form_main_unique_id = $value['form_main_unique_id'];

                // $vendor_name_id = $value['bulk_eng_name'];

                $value['dc_num'] = $value['dc_num'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['dc_date'])) . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['invoice_date'])) . '</b>';
                $value['po_num'] = $value['po_num'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['po_date'])) . '</b>';

                $vendor_inv_attach_approval_date = date('d-m-Y', strtotime($value['vendor_inv_attach_approval_date']));

                $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;

                $data[] = [
                    "po_num" => $value['po_num'],
                    "invoice_no" => $value['invoice_no'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "amount" => formatIndianCurrency($value['amount']),
                    "consignee_name" => $value['consignee_name'],
                    "veninvverifyid" => $value['veninvverifyid'],
                    "vendor_inv_attach_approval_date" =>$vendor_inv_attach_approval_date,
                    "vendor_bill_approval_date" => $value['vendor_bill_approval_date'],
                    "vendor_account_approved_by" => $value['vendor_account_approved_by'],

                    "vendor_account_approval_date" => $value['vendor_account_approval_date'],


                    "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                    
                    "po_ven_filename" => $value['po_ven_filename'],
                    "accountbillid" => $value['accountbillid'],
                    "acctotalpaybleamount" => $value['acctotalpaybleamount'],

                      "acctdsvalue" => $value['acctdsvalue'],
                    "accotherdeduction" => $value['accotherdeduction'],
                    
                 "rate" => $value['rate'],
                 "total_amount" => $value['total_amount'],
                 "additional_amount" => $value['additional_amount'],
                     "basicamt" =>$basicamt,
                     "toatlamt" =>$toatlamt,
                       "gst" =>$gst,
                     "gstcamt" =>$withgsttotal,
                    "advancepayment"=>$value['advancepayment'],

                    
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


           case 'reject_update':
        // print_r($_POST);die();
        // die();
        $bill_no = $_POST['vendor_bill_no'];
     
             $status = $_POST['status'];
         $unique_id = $_POST['main_unique_id'];

        $reject_reason = $_POST['reject_reason'];


        $dc_no = $_POST['dc_no'];

        $rejected_by = $_SESSION['user_id'];

        $date = date('Y-m-d H:i:s');

        $table = 'vendor_payment_details';
        $table_main = 'vendor_payment_details_main';

        $table2 = "invoice_verfication_table";
        

     

            $columns = [

                 "vendor_bill_app_status" => '0',
                "vendor_bill_reject_reason"    => $reject_reason,
                "vendor_bill_approval"         => $_SESSION['user_id'],
                "vendor_bill_approval_date"    => $date,



                // "managment_team_allocated" => 0,
            //    "managment_team_approval_sts" => 0,
                // "managment_team_reject_reason" => $reject_reason,
                // "managment_team_approvedby" => $_SESSION['user_id'],
                // "managment_team_approvaldate" => $date,
            //    "finance_reject_reason" => "",
                // "finance_approved_by" => "",
                // "finance_approved_date" =>"",
                // "finance_approval"=>0,
                //   "finance_remark"=>"",
                  'accstatus' => '2',
                  "acc_ent_sts" =>'2',
                  "acc_ent_rej_reason" =>$reject_reason,
                    "acc_rejected_by"         => $_SESSION['user_id'],
                    "vendor_account_approved_by" => $_SESSION['user_id'],
                    "vendor_account_approval_date" => $date




                      
                // "is_delete"                    => 1,

            ];
      
        
        $update_where = "bill_no = '$bill_no' AND main_unique_id ='$unique_id'";

        $action_obj = $pdo->update($table, $columns, $update_where);

//   print_r(  $action_obj );die();
         if ($status == '1') {
            // alert("hi");
            $invoice_verify_columns = [
                "vendor_bill_app_status" => $status,
                // "vendor_bill_approval" => $_SESSION['user_id'],
                // "vendor_bill_approval_date" => $date,
                 "vendor_bill_approval_allocated" => '1',
                  "vendor_bill_reject_reason" => "",

            ];
        } 
        
        else if ($status == '2') {
// alert("hlo");
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
              "vendor_bill_rejected_by" => $rejected_by,
              

            
        ];
        
        }
        $update_where_dc = "dc_number ='$dc_no'";

        // $action_obj_1 = $pdo->update($table2, $invoice_verify_columns, $update_where_dc);
    //    print_r(  $action_obj_1);
        if ($status == '1') {
            
            $columns_main = [
                "vendor_bill_app_status" => $status,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                

            ];
        } else if ($status == '2') {

            $columns_main = [

                 "vendor_bill_reject_reason"    => $reject_reason,
                "vendor_bill_approval"         => $_SESSION['user_id'],
                "vendor_bill_approval_date"    => $date,
                // "managment_team_allocated" => 0,

            //    "managment_team_approval_sts" => "0",
                // "managment_team_reject_reason" => $reject_reason,
                // "managment_team_approvedby" => $_SESSION['user_id'],
                // "managment_team_approvaldate" => $date,

            //    "finance_reject_reason" => "",
                // "finance_approved_by" => "",
                // "finance_approved_date" => "",
                // "finance_approval"     => 0,
                //   "finance_remark"=>"",
                  'accstatus' => 2,
                  "vendor_bill_app_status" => '0',
                  "acc_ent_sts" =>'2',
                
                  "acc_ent_rej_reason" => $reject_reason,
                    "acc_rejected_by"         => $_SESSION['user_id'],
                    "vendor_account_approved_by" => $_SESSION['user_id'],
                    "vendor_account_approval_date" => $date
                //  "vendor_bill_app_status" => $status,
                // "vendor_bill_reject_reason" => $reject_reason,
                // "vendor_bill_approval" => $_SESSION['user_id'],
                // "vendor_bill_approval_date" => $date,
                // "is_delete" =>1,
                // "vendor_bill_reject_reason" => $reject_reason,


            ];
        }
        
        $update_where_main = "bill_no = '$bill_no' and is_delete = 0";

        $action_obj_main = $pdo->update($table_main, $columns_main, $update_where_main);
        //  print_r(  $action_obj_main);die();
// print_r(  $action_obj_main);



        $total_amount = 0;

        $amount_column = [
            "(amount) as ttl_amount"
        ];

        $table_details = [

            $table,
            $amount_column
        ];

        $amount_where = "bill_no  = '$bill_no' AND dc_number ='$dc_no' and  vendor_bill_app_status != '2'";
        // print_r('test1');die();
        $get_total_sql = $pdo->select($table_details, $amount_where);

        $get_total_result = $get_total_sql->data;
        // print_r($get_total_sql);die();


        if ($get_total_result) {
            $total_amount = $get_total_result[0]['ttl_amount'];
        }

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
            "sql" => $sql,
            "total_amount" => $total_amount
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
        $ttl_amount = $_POST['ttl_amount'];

        $vendor_name = $_POST['vendor_name'];

        $vendor_id = $_POST['vendor_id'];

        $vendor_bill_no = $_POST['bill_no'];

        // print_r($vendor_bill_no);
        $prefix = "";
        
        $main_unique_id = unique_id();

        $unique_id = unique_id();
        
        $mainTable = 'vendor_payment_details_main';

        $table = 'vendor_payment_details';

        $table_inv = 'invoice_verfication_table';

        $bill_date = date("Y-m-d H:i:s");


        //   $columninv = [
        //     "inv_verfiy_attach",
        //     "inv_verfiy_attach_org_name"
           
        // ];
        
        // $action_obj_main = $pdo->select($table_inv, $columninv);
        //   $table_user = "user_screen_permission";
        $columninv = [
            // "screen_unique_id",
            "inv_verfiy_attach",
            "inv_verfiy_attach_org_name",
            "veninvid",
            "vendor_inv_attach_approval",
            "vendor_inv_attach_approval_date",
            "veninvstatus"
            // "'veninvstatus"
        //         'vendor_inv_attach_approval' => $approved_by,
        // 'vendor_inv_attach_approval_date' =>$date,


        ];
      $select_whereinv = "engineer_name = '$vendor_id' AND dc_number = '$dc_no'";

        $table_details = [
            $table_inv,
            $columninv
        ];

        $table_users = $pdo->select($table_details, $select_whereinv);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            // $action_unique_ids = [];

            foreach ($table_users as $item) {
              $inv_verfiy_attach=$item['inv_verfiy_attach'];
              $inv_verfiy_attach_org_name=$item['inv_verfiy_attach_org_name'];
              $veninvid=$item['veninvid'];
                 $vendor_inv_attach_approval=$item['vendor_inv_attach_approval'];
              $vendor_inv_attach_approval_date=$item['vendor_inv_attach_approval_date'];
              $veninvstatus=$item['veninvstatus'];


            }
        // $action_obj_main = $pdo->insert($mainTable, $columnsMain);

        $columnsMain = [
            "unique_id" => $main_unique_id,
            "bill_no" => $vendor_bill_no,
            "bill_date" => $bill_date,
            "po_form_unique_id" => $po_unique_id,
            "po_num" => $po_num,
            "vendor_id" => $vendor_id,
            "rate" => $rate,
            "gst" => $gst,
            "total_amount" => $ttl_amount,
            'finance_reject_reason'=>"",
             'finance_remark'=>"",
             'finance_approval'=>"0",
            //  "accstatus"=>'1'

             



        ];
 $update_where_main = [
            "bill_no" => $vendor_bill_no
        ];

        $action_obj_main = $pdo->insert($mainTable, $columnsMain,$update_where_main);
// print_r(  $action_obj_main);

        $columns = [
            "unique_id" => $unique_id,
            "main_unique_id" => $main_unique_id,
            "bill_no" => $vendor_bill_no,
            "bill_date" => $bill_date,
            "po_num" => $po_num,
            "po_form_unique_id" => $po_unique_id,
            "invoice_no" => $invoice_no,
            "invoice_qty" => $invoice_qty,
            "dc_num" => $dc_no,
            "dc_date" => $dc_date,
            "rate" => $rate,
            "gst" => $gst,
            "amount" => $amount,
            "total_amount" => $ttl_amount,
            "vendor_name" => $vendor_name,
            "vendor_id" => $vendor_id,
               "inv_verfiy_attach" => $inv_verfiy_attach,
            "inv_verfiy_attach_org_name" => $inv_verfiy_attach_org_name,
        "veninvverifyid" => $veninvid,
         'vendor_inv_attach_approval' => $vendor_inv_attach_approval,
        'vendor_inv_attach_approval_date' =>$vendor_inv_attach_approval_date,
            'veninvstatus'=>1,
            'finance_reject_reason'=>"",
            'finance_remark'=>"",
            //   "accstatus"=>'0',
              "finance_approval"=>'0'




        ];

        $upd_col = [
            'vendor_payment_allocated' => 1
        ];

        $update_where = [
            "dc_number" => $dc_no
        ];


        $action_obj = $pdo->insert($table, $columns);
// print_r(  $action_obj);
        
        $action_obj_1 = $pdo->update($table_inv, $upd_col, $update_where);


            $table_pay="vendor_payment_details";
             $columns_pay = [
        'inv_verfiy_attach' => $file_names,
        'inv_verfiy_attach_org_name' => $file_org_names,
        'veninvstatus'=>1,
    ];


             $update_where_ver = [
                "vendor_id" => $uid,
                "dc_number" => $dc_no
            ];

            $result_po = $pdo->update($table_pay, $columns_pay, $table_pay);
        
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


    case 'generate_vendor_bill_no':


        $bill_no = vendor_payment_bill_no();

        echo json_encode([

            "status" => true,
            "bill_no" => $bill_no
        ]);
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
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return $basePrefix . '-0001'; // fallback in case of DB error
    }

    $stmt = $conn->prepare("SELECT bill_no FROM vendor_payment_details WHERE `bill_no` LIKE :prefix ORDER BY id DESC LIMIT 1");
    $stmt->execute(['prefix' => $basePrefix . '-%']);
    $latestBill = $stmt->fetchColumn();

    // print_r($latestBill);die();

    if ($latestBill) {
        $parts = explode('-', $latestBill); // e.g., VEN-202506-0003
        $lastSerial = (int) end($parts);
        $nextSerial = str_pad($lastSerial + 1, 5, '0', STR_PAD_LEFT);

        // print_r($nextSerial);die();// Five digits like 00001
    } else {
        $nextSerial = '00001';
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




function image_view_4($folder_name = "", $unique_id = "", $pan_attach_file_name = "")
{

    $file_names = explode(',', $file_name);
    $image_view_4 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_4 .= "&nbsp";
                } else {
                    $image_view_4 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_4 .= '<a href="javascript:print_view_2(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_4 .= '<a href="javascript:print_pdf_2(\'/' . $file_name . '\')"><img src="uploads/vendor_creation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_4 .= '<a href="javascript:print_2(\'/' . $file_name . '\')"><img src="uploads/vendor_creation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_4 .= '<a href="javascript:print_2(\'/' . $file_name . '\')"><img src="uploads/vendor_creation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_4;
}

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



