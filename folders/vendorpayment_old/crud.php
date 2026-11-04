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



    case 'bill_cancel_add_update':


        $bill_no = $_POST["bill_no"];

        $invoice_qty = $_POST["invoice_qty"];
        $invoice_val = $_POST["invoice_val"];
        $unique_id = $_POST["unique_id"];
        $reject_reason = $_POST["reject_reason"];

        $invoice_no = $_POST["invoice_no"];
        $tot_invoice_no = $_POST["main_invoice_no"];
        $cancel_invoice_no = $_POST["cancel_invoice_no"];

        $remaining_invoice_no = $_POST["remaining_invoice_no"];

        $update_where = "";
        // =========================================rejected=================================================

        $columns_sub = [
            "is_delete" => 1,
            "inv_cancel_status" => 1,
            "inv_cancel_reason" => $reject_reason,


        ];

        $table_main = "bill_submission_main_table";

        $table_details = [
            $table_main,
            [
                "invoice_value",
                "invoice_qty",
                "cancel_invoice_no",
            ]
        ];
        $select_where = 'is_delete = 0 AND invoice_no="' . $tot_invoice_no . '"';
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
        $total_inv_qty = $data[0]['invoice_qty'] - $invoice_qty;
        // print_r( $total_inv_qty);
        $total_inv_value = $data[0]['invoice_value'] - $invoice_val;

        $rem_inv_nos = $data[0]['cancel_invoice_no'];




        // print_r($action_obj_sub);
        // print_r($total_inv_value);die();
        if ($remaining_invoice_no != '') {
            $columns_main = [
                "inv_cancel_status" => 1,
                "inv_cancel_reason" => $reject_reason,
                "cancel_invoice_no" => $cancel_invoice_no,
                "rem_inv_no" => $remaining_invoice_no,
                "invoice_value" => $total_inv_value,
                "invoice_qty" => $total_inv_qty,
                "invoice_no" => $remaining_invoice_no,



            ];
        } else {
            // The invoice_no is either empty or null
            // Handle the case where invoice_no is empty or null
            $columns_main = [
                "is_delete" => 1,
                // "invoice_value"           => 0,
                // "invoice_qty"           =>0,
                "inv_cancel_status" => 1,
                "inv_cancel_reason" => $reject_reason,
                "cancel_invoice_no" => $cancel_invoice_no,
                "rem_inv_no" => $remaining_invoice_no,
                "payment_status" => 0,
                // "invoice_no"     => null,
            ];
        }

        $update_where_main = 'bill_form_main_unique_id="' . $unique_id . '" and bill_no="' . $bill_no . '"';

        // print_r($update_where_main);die();
        $action_obj_main = $pdo->update($table_main_1, $columns_main, $update_where_main);

        // print_r($action_obj_main);


        $table_bill_form = "bill_submission_form";

        $columns_bill_form = [
            "is_delete" => 1,
            "inv_cancel_reason" => $reject_reason,
            "inv_cancel_status" => 1,
            // "cancel_invoice_no"     =>$cancel_invoice_no,


        ];

        $update_where_form = 'bill_form_main_unique_id="' . $unique_id . '" and invoice_no="' . $invoice_no . '"';

        // print_r($update_where_123);die();
        $action_obj_form = $pdo->update($table_bill_form, $columns_bill_form, $update_where_form);
        // print_r($action_obj_form);

        $table_sign = "sign_doc_verification_detail";

        $columns_sign = [
            "bill_status" => 4,
            "bill_no" => "",
            // "payment_reject"           => 0,
            "inv_cancel_reason" => $reject_reason,
            "inv_cancel_status" => 1,
            // "cancel_invoice_no"     =>$cancel_invoice_no,
        ];
        $update_where_sign = 'form_main_unique_id="' . $unique_id . '" and invoice_no="' . $invoice_no . '"';
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
            $update_where = 'bill_form_unique_id="' . $unique_id . '" and invoice_no="' . $invoice_no . '"';

            // $action_obj     = $pdo->update($table_main_1, $columns, $update_where);
            $action_obj = $pdo->update($table_sub_1, $columns_sub, $update_where);

            // print_r($action_obj);

            // Update Ends
        }
        // print_r($action_obj);
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
        $table_vendor = "view_vendor_billdata";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "'' as outsrc_eng_name",
            "COUNT(dc_number) as dc_number",
            "ROUND(SUM(invoice_value),2)as rounded_invoice_value",
            "unique_id",
            "invoice_no",
            "po_num",
            "'' as vendor_payment_allocated",
            // "'' as vendor_finance_approval",
            "bulk_eng_name",
            
            // "dc_required",
            // "document_verification_status",
            "get_vendor_address(bulk_eng_name) AS address",
            "get_vendor_id(bulk_eng_name) AS vendor_id",
            "get_vendor_contact(bulk_eng_name) AS contact_no",
            
            "(select company_name from vendor_creation where unique_id = $table_vendor.bulk_eng_name) as ven_company_name",
            "document_verification_status",

            "(SELECT finance_approval FROM vendor_payment_details vpd 
      WHERE vpd.invoice_no = $table_vendor.invoice_no 
      AND vpd.dc_num = $table_vendor.dc_number 
     ) as vendor_finance_approval"   

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        // $where = "doc_approval_sts = 1 AND document_verification_status = 2 AND ac_team_verifiy_status = 1 AND vendor_payment_status = 0  AND installation_status = 2  AND material_qc = 1 AND vendor_bulk_sts = 1 AND bulk_eng_name != '' AND bulk_eng_type = 'outsource-vendor' ";

        // //  $where .= ' AND vendor_payment_allocated = 0 AND ((vendor_finance_approval = 2) or (vendor_finance_approval = 0))AND (dc_required IS NULL OR TRIM(dc_required) != '1') ';

        // if ($_POST['from_date'] == '') {
        //     $from_date = '';
        // } else {
        //     $from_date = $_POST['from_date'];
        // }

        // if ($_POST['to_date'] == '') {
        //     $to_date = '';
        // } else {
        //     $to_date = $_POST['to_date'];
        // }


$where = "doc_approval_sts = 1 
          AND document_verification_status = 2 
          AND ac_team_verifiy_status = 1 
          AND vendor_payment_status = 0  
          AND installation_status = 2  
          AND material_qc = 1 
          AND vendor_bulk_sts = 1 
          AND bulk_eng_name != '' 
          AND bulk_eng_type = 'outsource-vendor'";

         $where .= " AND(
    (SELECT finance_approval FROM vendor_payment_details vpd 
     WHERE vpd.invoice_no = $table_vendor.invoice_no 
     AND vpd.dc_num = $table_vendor.dc_number) IN (0, 2) 
    OR 
    NOT EXISTS (
        SELECT 1 FROM vendor_payment_details vpd2 
        WHERE vpd2.invoice_no = $table_vendor.invoice_no 
        AND vpd2.dc_num = $table_vendor.dc_number
    )
)";

// Fix empty or valid dates
$from_date = $_POST['from_date'] ?? '';
$to_date   = $_POST['to_date'] ?? '';

if ($from_date != '') {
    $where .= " AND entry_date >= '$from_date'";
}

if ($to_date != '') {
    $where .= " AND entry_date <= '$to_date'";
}

// Proper searchable columns
$searchable_columns = [
    "invoice_no",
    "po_num",
    "bulk_eng_name",
    "dc_number"
];

$search = datatable_searching($_POST['search']['value'], $searchable_columns);  

if ($search != '') {
    $where .= " AND ($search)";
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
        // $search = datatable_searching($search, $columns);

        // if ($search) {
        //     if ($where) {
        //         $where .= " AND ";
        //     }

        //     $where .= $search;
        // }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $group_by = "bulk_eng_name";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);
        //  print_r($result);

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

                $vendor_name = $value['bulk_eng_name'];

                $address = $value['address'];

                $vendor_id = $value['vendor_id'];

                $contact_no = $value['contact_no'];

                $ven_cmp_name = $value['ven_company_name'];

                $value['outsrc_eng_name'] = "<div>
                        <strong>{$ven_cmp_name} - {$vendor_id}</strong><br>
                        <span>{$address} - Ph.No. {$contact_no}</span>
                    </div>";

                $value['dc_number'] = '<span style="display:block; text-align:right;">' . $value['dc_number'] . '</span>';

                $value['rounded_invoice_value'] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['rounded_invoice_value']) . '</span>';

                $btn_view = '<span style="display:block; text-align:center;"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green view-btn" data-ponum="' . $value['po_num'] . '" data-vendor-id ="' . $value['bulk_eng_name'] . '"  data-vendor ="' . $outsrc_eng_name . '" title="View"></i></span>';
                // <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>
                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";

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
            "bill_no",
            "vendor_name",
            "COUNT(dc_num) AS dc_count",
            "IFNULL(SUM(amount), 0) AS total_amount",
            "unique_id",
            "finance_approval",
            "dc_num",
            "vendor_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "get_vendor_mail(vendor_id) AS mail",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_id(vendor_id) AS vendor_id_value",
            "get_staff_name(sess_user_id) AS accounts_approved_by",
            "DATE_FORMAT(created, '%d-%m-%Y') AS accounts_approved_date",
            "(Select company_name from vendor_creation where unique_id = $table_vendor.vendor_id) as ven_cmp_name"

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


        // $where .= " accounts_approval = '1' ";
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

        $group_by = "bill_no";

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

                $bill_date = $value['bill_date'];

                $vendor_id_value = $value['vendor_id_value'];

                $vendor_name = $value['ven_cmp_name'];

                $contact_no = $value['contact_no']; // assuming vendor_id is the unique_id

                $address = $value['address']; // assuming vendor_id is the unique_id

                $value['s_no'] = $sno + 1;

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';

                $dc_num = $value["dc_num"];

                $total_amount = $value["total_amount"];

                $btn_view = '<span style="display:block; text-align:center;"><i class=" mdi mdi-eye view-btn-2" data-bill-no="' . $value['bill_no'] . '" data-bill-date="' . $bill_date . '"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '" data-vendor-address ="' . $value['address'] . '"data-vendor-mail ="' . $value['mail'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $value['total_amount'] . '" data-approver ="' . $value['accounts_approved_by'] . '" data-approvedate ="' . $value['accounts_approved_date'] . '" title="View"></i></span>';

                $value["total_amount"] = '<span style="display:block; text-align:right; font-weight:bold">' . formatIndianCurrency($value['total_amount']) . '</span>';

                // $value["dc_count"] = '<span style="text-align:center; font-weight:bold">' . $value['dc_count'] . '</span>';
                $value["dc_count"] = '<span style="display: inline-block; width: 100%; text-align: right;">' . $value['dc_count'] . '</span>';

                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";

                }

                $value['vendor_name'] = "<div>
                        <strong>{$vendor_name} - {$vendor_id_value}</strong><br>
                        <span>{$address} <br> Ph.No. {$contact_no}</span>
                    </div>";

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


    //     case 'bill_summary_popup':
//         $screen_id_val = $_POST['screen_id_val'];
//         $user_type_unique_id = $_POST['user_type_unique_id'];
//         // print_r( $user_type_unique_id);die();
//         $bill_no = $_POST['bill_no'];
//         $vendor_id = $_POST['vendor_id'];

    //         $table_user = "vendor_creation";
//         $columns = [
//             "name",
//             "contact_no",
//             "mail_id",
//             "pan_no",
//             "gst_no",
//             "address",
//             "account_no",
//             "ifsc_code",
//             "bank_name",
//             "branch_name"
//         ];
//         $select_where = "unique_id='" . $vendor_id . "'";
//         // print_r($select_where);die();
//         $table_details = [
//             $table_user,
//             $columns
//         ];

    //         $result = $pdo->select($table_details, $select_where);
// // print_r($result);
//         if ($result->status) {

    //             $result = $result->data;

    //             $data = [];

    //             foreach ($result as $value) {
//                 $data[] = $value['name'];
//                 $data[] = $value['contact_no'];
//                 $data[] = $value['mail_id'];
//                 $data[] = $value['pan_no'];
//                 $data[] = $value['gst_no'];
//                 $data[] = $value['address'];
//                 $data[] = $value['account_no'];
//                 $data[] = $value['ifsc_code'];
//                 $data[] = $value['bank_name'];
//                 $data[] = $value['branch_name'];
//             }

    //             // Now $data contains all the action_unique_id values
//             // print_r($data);die();



    //             // $data = array($table_users);
//         }
//         $json_array = [
//             "draw" => intval($draw),
//             "recordsTotal" => intval($total_records),
//             "recordsFiltered" => intval($total_records),
//             "data" => $data,
//             "testing" => $result->sql
//         ];

    //         echo json_encode($json_array);

    //         break;


    case 'bill_summary_popup':
        $bill_no = $_POST['bill_no'] ?? null;
        $vendor_id = $_POST['vendor_id'];
        // echo $vendor_id;
        $table_user = "vendor_creation";
        $columns = [
            "name",
            "contact_no",
            "mail_id",
            "pan_no",
            "gst_no",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name"
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
                    'contact_no' => $vendor['contact_no'],
                    'mail_id' => $vendor['mail_id'],
                    'pan_no' => $vendor['pan_no'],
                    'gst_no' => $vendor['gst_no'],
                    'address' => $vendor['address'],
                    'account_no' => $vendor['account_no'],
                    'ifsc_code' => $vendor['ifsc_code'],
                    'bank_name' => $vendor['bank_name'],
                    'branch_name' => $vendor['branch_name'],
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


    case 'fixed_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;



        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
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
        $table_details = [
            $table_claim,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";

        $where = "claim_amount='95' and claim_status!='0'";
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
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;


                // $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);

                $payment_receive = $value['payement_receive'];
                $payment_status = $value['payment_status'];

                if ($payment_receive != '') {
                    $value['payement_receive'] = $payment_receive;
                } else {
                    $value['payement_receive'] = '-';
                }

                if (($payment_status == '1') || ($payment_status == '0')) {
                    $value['payment_status'] = 'Pending';
                } else if ($payment_status == '2') {
                    $value['payment_status'] = 'Complete';
                }
                if ($value['is_active'] == "1") {
                    $value['is_active'] = "Active";
                } else {

                    $value['is_active'] = "Inactive";
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



    case 'deleivery_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
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
        $table_details = [
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
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;


                // // $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                // $value['bill_form_unique_id'] = $btn_update . $btn_delete;

                $payment_receive = $value['payement_receive'];
                $payment_status = $value['payment_status'];

                if ($payment_receive != '') {
                    $value['payement_receive'] = $payment_receive;
                } else {
                    $value['payement_receive'] = '-';
                }

                if (($payment_status == '1') || ($payment_status == '0')) {
                    $value['payment_status'] = 'Pending';
                } else if ($payment_status == '2') {
                    $value['payment_status'] = 'Complete';
                }
                if ($value['is_active'] == "1") {
                    $value['is_active'] = "Active";
                } else {

                    $value['is_active'] = "Inactive";
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

        if ($length == '-1') {
            $limit = "";
        }

        $table_vendor = "view_vendor_billdata";
        // Query Variables
        $json_array = "";

        $columns = [
            "'' as s_no",
            'get_po_number(form_main_unique_id) AS po_num',
            'po_date',
            "invoice_no",
            'dc_number',
            'get_consignee_contact_name(consignee_unique_id) AS consignee_name',
            'invoice_qty',
            "'' as outsrc_eng_name",
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
            "vendor_payment_status",
            // " '' as vendor_finance_approval",
            "bulk_eng_name",
            "document_verification_status",
// "(SELECT finance_approval FROM vendor_payment_details vpd 
//       WHERE vpd.invoice_no = $table_vendor.invoice_no 
//       AND vpd.dc_num = $table_vendor.dc_number 
//       AND (vpd.finance_approval = 2 OR vpd.finance_approval = 0)
//      ) as vendor_finance_approval"   
        // "dc_required"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = "bulk_eng_name = '$vendor' ";

        $where .= " AND document_verification_status = 2";
        //  AND (dc_required IS NULL OR TRIM(dc_required) != '1') 

         $where .= ' AND vendor_payment_status = 0';

         $where .= " AND (
    (SELECT finance_approval FROM vendor_payment_details vpd 
     WHERE vpd.invoice_no = $table_vendor.invoice_no 
     AND vpd.dc_num = $table_vendor.dc_number) IN (0, 2) 
    OR 
    NOT EXISTS (
        SELECT 1 FROM vendor_payment_details vpd2 
        WHERE vpd2.invoice_no = $table_vendor.invoice_no 
        AND vpd2.dc_num = $table_vendor.dc_number
    )
)";


// AND  ((vendor_finance_approval = 2) or (vendor_finance_approval = 0)) 
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

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);

        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_qty = $value['invoice_qty'];

                $dc_number = $value['dc_number'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];

                $rate = $value['vendor_bulk_rate'];

                $gst = $value['vendor_bulk_gst'];

                $amnt = $value['bulk_total_amount'];

                $po_num = $value['po_num'];

                $form_main_unique_id = $value['form_main_unique_id'];

                $vendor_name_id = $value['bulk_eng_name'];

                $value['unique_id'] = '<div class="checkbox-container">
                    <input class="myCheck" type="checkbox" name="bill_checkbox[]"  
                            data-qty ="' . $invoice_qty . '" data-invoice-num = "' . $invoice_no . '" data-dcdate = "' . $dc_date . '" data-rate = "' . $rate . '" data-gst = "' . $gst . '" data-amnt = "' . $amnt . '"
                        data-form_main_id = "' . $form_main_unique_id . '"  data-po-num ="' . $po_num . '"   data-id = "' . $dc_number . '"  data-vendor-id = "' . $vendor_name_id . '">
                    </div>';

                $value['dc_number'] = $value['dc_number'] . '&nbsp;&nbsp;<br><b>' . $value['dc_date'] . '</b>';
                $value['po_num'] = $value['po_num'] . '&nbsp;&nbsp;<br><b>' . $value['po_date'] . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '&nbsp;&nbsp;<br><b>' . $value['invoice_date'] . '</b>';

                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_number" => $value['dc_number'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "vendor_bulk_rate" => $value['vendor_bulk_rate'],
                    "vendor_bulk_gst" => $value['vendor_bulk_gst'],
                    "bulk_total_amount" => $value['bulk_total_amount'],
                    // "bulk_total_amount" => $value['bulk_total_amount'],
                    "invoice_no" => $value['invoice_no'],
                    "checkbox" => $value['unique_id'],
                    "consignee_name" => $value['consignee_name']
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
            "get_consignee_contact_name((SELECT consignee_unique_id from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS po_date",
            // "(invoice_value)",
            // "vendor_bulk_rate",
            // "vendor_bulk_gst",
            // "invoice_no",
            // "form_main_unique_id",
            // "vendor_payment_allocated",
            // "vendor_finance_approval",
            // "bulk_eng_name",
            // "document_verification_status",
            // "dc_required"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "bill_no = '$bill_no' AND is_delete = 0 ";

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

                // $gst = $value['vendor_bulk_gst'];

                // $amnt = $value['total_amount'];

                // $po_num = $value['po_num'];

                // $form_main_unique_id = $value['form_main_unique_id'];

                // $vendor_name_id = $value['bulk_eng_name'];

                $value['dc_num'] = $value['dc_num'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['dc_date'])) . '</b>';
                $value['invoice_no'] = $value['invoice_no'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['invoice_date'])) . '</b>';
                $value['po_num'] = $value['po_num'] . '&nbsp;&nbsp;<br><b>' . date('d-m-Y', strtotime($value['po_date'])) . '</b>';



                $data[] = [
                    "po_num" => $value['po_num'],
                    "invoice_no" => $value['invoice_no'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "amount" => formatIndianCurrency($value['amount']),
                    "consignee_name" => $value['consignee_name'],
                    // "vendor_bulk_gst" => $value['vendor_bulk_gst'],
                    // "bulk_total_amount" => $value['bulk_total_amount'],
                    // "invoice_no" => $value['invoice_no'],
                    // "checkbox" => $value['unique_id'],
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






    case 'pending_one_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];
        $claim_amount = $_POST['claim_amount'];

        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
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
        $table_details = [
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
        // print_R($result);
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

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

                $btn_update = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                $value['bill_form_unique_id'] = $btn_update . $btn_delete;

                $payment_receive = $value['payement_receive'];
                $payment_status = $value['payment_status'];

                if ($payment_receive != '') {
                    $value['payement_receive'] = $payment_receive;
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


    case 'pending_5_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];
        $claim_amount = $_POST['claim_amount'];

        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
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
        $table_details = [
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
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

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

                $btn_update = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
                $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                $value['bill_form_unique_id'] = $btn_update . $btn_delete;

                $payment_receive = $value['payement_receive'];
                $payment_status = $value['payment_status'];

                if ($payment_receive != '') {
                    $value['payement_receive'] = $payment_receive;
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
        
        $mainTable = 'vendor_payment_main';

        $table = 'vendor_payment_details';

        $table_inv = 'invoice_verfication_table';

        $bill_date = date("Y-m-d H:i:s");

        $columnsMain = [
            "unique_id" => $main_unique_id,
            "bill_no" => $vendor_bill_no,
            "bill_date" => $bill_date,
            "po_form_unique_id" => $po_unique_id,
            "po_num" => $po_num,
            "vendor_id" => $vendor_id,
            "rate" => $rate,
            "gst" => $gst,
            "total_amount" => $ttl_amount
        ];

        $action_obj_main = $pdo->insert($mainTable, $columnsMain);

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

        ];

        $upd_col = [

            'vendor_payment_allocated' => 1
        ];

        $update_where = [
            "dc_number" => $dc_no
        ];

      $ven_status = [
    'vendor_payment_status' => 1
];

$vend_where = [
    "dc_number" => $dc_no,
    "is_delete" => 0
];

$update_status = $pdo->update('invoice_creation_main', $ven_status, $vend_where);



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
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return $basePrefix . '-0001'; // fallback in case of DB error
    }

    $stmt = $conn->prepare("SELECT bill_no FROM vendor_payment_details WHERE `bill_no` AND is_delete = 0 LIKE :prefix ORDER BY id DESC LIMIT 1");
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



