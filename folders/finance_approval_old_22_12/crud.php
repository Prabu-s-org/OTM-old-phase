<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "vendor_payment_details";


$sess_user_id = $_SESSION['user_id'];


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
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "DATE_FORMAT(bill_date,'%d-%m-%Y')AS bill_date",
            "bill_no",
            "vendor_name",
            "IFNULL(SUM(amount), 0) AS total_amount",
            "unique_id",
            "finance_approval",
            "dc_num",
            "vendor_id",
            // "(select contact_no from vendor_creation where unique_id = $table.vendor_id) as contact_no",
            // "(select mail_id from vendor_creation where unique_id = $table.vendor_id) as mail",
            // "(select address from vendor_creation where unique_id = $table.vendor_id) as address",
            "get_vendor_mail(vendor_id) AS mail",
            "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_id(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "(select company_name from vendor_creation where unique_id = $table.vendor_id) as ven_cmp_name"

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

        $where .= "finance_approval = '0'";


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

                $total_amount = $value["total_amount"];

                $btn_view = '<span style="display:block; text-align:center;"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green view-btn" data-bill-no="' . $value['bill_no'] . '" data-bill-date="' . $value['bill_date'] . '"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '" data-vendor-address ="' . $value['address'] . '"data-vendor-mail ="' . $value['mail'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $value['total_amount'] . '" title="View"></i></span>';

                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";
                }


                // $value['total_amount'] = '<span><b>' . $value['total_amount'] . '</b></span>';
                $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';

                $vendor_name = $value['ven_cmp_name'];
                $vendor_reg_id = $value['vendor_reg_id'];
                $address = $value['address'];
                $contact_no = $value['contact_no'];

                $value['vendor_name'] = "<div>
                        <strong>{$vendor_name} - {$vendor_reg_id}</strong><br>
                        <span>{$address} - Ph.No. {$contact_no}</span>
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

    // case 'datatable_completed':
    //     // DataTable Variables
    //     $search = $_POST['search']['value'];
    //     $length = $_POST['length'];
    //     $start = $_POST['start'];
    //     $draw = $_POST['draw'];
    //     $from_date = $_POST['from_date'];
    //     $to_date = $_POST['to_date'];
    //     $opt = $_POST['opt'];
    //     $limit = $length;

    //     $data = [];

    //     if ($length == '-1') {
    //         $limit = "";
    //     }

    //     $table_vendor = "vendor_payment_details";
    //     // Query Variables
    //     $json_array = "";
    //     $columns = [
    //         "'' as s_no",
    //         "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
    //         "bill_no",
    //         "vendor_name",
    //         "SUM(amount) AS total_amount",
    //         // "amount AS total_amount",
    //         "finance_approval",
    //         "unique_id",
    //         "accounts_approval",
    //         "vendor_id",
    //         "invoice_no",
    //         "po_num",
    //         "get_vendor_address(vendor_id) AS address",
    //         "get_vendor_id(vendor_id) AS vendor_reg_id",
    //         "get_vendor_contact(vendor_id) AS contact_no",
    //         "get_staff_name(finance_approved_by) AS finance_approved_by",
    //         "DATE_FORMAT(finance_approved_date, '%d-%m-%Y') AS finance_approved_date"
    //     ];
    //     $table_details = [
    //         $table_vendor,
    //         $columns
    //     ];

    //     $where = "";

    //     $where = 'finance_approval = 1 OR finance_approval = 2';
    //     if ($_POST['from_date'] == '') {
    //         $from_date = '';
    //     } else {
    //         $from_date = $_POST['from_date'];
    //     }

    //     if ($_POST['to_date'] == '') {
    //         $to_date = '';
    //     } else {
    //         $to_date = $_POST['to_date'];
    //     }

    //     $order_column = $_POST["order"][0]["column"];
    //     $order_dir = $_POST["order"][0]["dir"];

    //     $order_by = "unique_id $order_dir"; // Default order

    //     // Adjust order by PO date (index 2)
    //     if ($order_column == 2) {
    //         $order_by = "po_date $order_dir";
    //     }

    //     // Datatable Ordering 
    //     $order_by = datatable_sorting($order_column, $order_dir, $columns);

    //     // Datatable Searching
    //     $search = datatable_searching($search, $columns);

    //     if ($search) {
    //         if ($where) {
    //             $where .= " AND ";
    //         }
    //         $where .= $search;
    //     }

    //     $sql_function = "SQL_CALC_FOUND_ROWS";

    //     $group_by = "bill_no";

    //     $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function,$group_by);

    //     $total_records = total_records();
    //     $screen_id_val = $_POST['screen_id_val'];

    //     $user_type = $_POST['user_type_unique_id'];

    //     $table_user = "user_screen_permission";
    //     $columns = [
    //         "action_unique_id",
    //         "user_type"
    //     ];
    //     $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";

    //     $table_details = [
    //         $table_user,
    //         $columns
    //     ];

    //     $table_users = $pdo->select($table_details, $select_where);

    //     $table_users = $table_users->data;

    //     $action_ids = [];

    //     foreach ($table_users as $item) {
    //         if (isset($item['action_unique_id'])) {
    //             $action_ids[] = $item['action_unique_id'];
    //         }
    //     }
    //     if ($result->status) {

    //         $res_array = $result->data;

    //         foreach ($res_array as $key => $value) {

    //             $value['s_no'] = $sno + 1;
    //             $bill_no = $value['bill_no'];
    //             $bill_date = $value['bill_date'];

    //             $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';

    //             $vendor_id = $value['vendor_id'];
    //             $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';

    //             $accounts_approval = $value['accounts_approval'];
    //             $value['accounts_approval'] = ($accounts_approval == 1)
    //                 ? '<span style="color: green; font-weight: bold;">Processed</span>'
    //                 : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';


    //             $btn_update = btn_update_accounts_team($folder_name, $value['unique_id'], $vendor_id, $bill_no, $bill_date, $accounts_approval);

    //             $btn_view = '<span style="display:block; text-align:center;"><i class=" mdi mdi-eye view-btn-2" data-ponum="' . $value['po_num'] . '" data-billno="' . $bill_no . '"  data-vendor ="' . $value['vendor_id'] . '" data-billdate ="' . $value['bill_date'] . '" data-approver ="' . $value['finance_approved_by'] . '" data-approvedate ="' . $value['finance_approved_date'] . '" title="View"></i></span>';

    //             $value['unique_id'] = $btn_view;

    //             $vendor_name = $value['vendor_name'];
    //             $vendor_reg_id = $value['vendor_reg_id'];
    //             $address = $value['address'];
    //             $contact_no = $value['contact_no'];

    //             $finance_status = $value['finance_approval'];

    //             if ($finance_status === '1') {
    //                 $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>
    //     <i class='mdi mdi-check-circle mdi-24px' style='color:green;' title='Approved'></i>
    // </div>";
    //             } elseif ($finance_status === '2') {
    //                 $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>
    //     <i class='mdi mdi-close-circle mdi-24px' style='color:red;' title='Rejected'></i>
    // </div>";
    //             }

    //             $value['vendor_name'] = "<div>
    //                         <strong>{$vendor_name} - {$vendor_reg_id}</strong><br>
    //                         <span>{$address} - Ph.No. {$contact_no}</span>
    //                     </div>";

    //             $data[] = array_values($value);
    //             $sno++;
    //         }

    //         $json_array = [
    //             "draw" => intval($draw),
    //             "recordsTotal" => intval($total_records),
    //             "recordsFiltered" => intval($total_records),
    //             "data" => $data,
    //             "testing" => $result->sql
    //         ];
    //     } else {
    //         print_r($result);
    //     }

    //     echo json_encode($json_array);
    //     break;


    case 'datatable_completed':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = ($length == '-1') ? "" : $length;

        $data = [];
        $sno = $start + 1;
        $table_vendor = "vendor_payment_details";

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, []); // You can modify this line if needed

        // 🔹 Step 1: Fetch grouped accepted records (finance_approval = 1)
        $accepted_columns = [
            "'' as s_no",
            "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
            "bill_no",
            "vendor_name",
            "SUM(amount) AS total_amount",
            "'1' AS finance_approval",
            "MAX(unique_id) AS unique_id",
            "MAX(accounts_approval) AS accounts_approval",
            "vendor_id",
            "GROUP_CONCAT(invoice_no) AS invoice_no",
            "GROUP_CONCAT(po_num) AS po_num",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_id(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "get_staff_name(MAX(finance_approved_by)) AS finance_approved_by",
            "DATE_FORMAT(MAX(finance_approved_date), '%d-%m-%Y') AS finance_approved_date",
            "finance_reject_reason",
            "(select company_name from vendor_creation where unique_id = $table_vendor.vendor_id) as ven_company_name"
        ];

        $accepted_result = $pdo->select(
            [$table_vendor, $accepted_columns],
            "finance_approval = 1",
            '',
            '',
            $order_by,
            $sql_function,
            "bill_no"
        );

        // print_r($accepted_result);

        // 🔹 Step 2: Fetch individual rejected records (finance_approval = 2)
        $rejected_columns = [
            "'' as s_no",
            "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
            "bill_no",
            "vendor_name",
            "amount AS total_amount",
            "'2' AS finance_approval",
            "unique_id",
            "accounts_approval",
            "vendor_id",
            "invoice_no",
            "po_num",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_id(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "get_staff_name(finance_approved_by) AS finance_approved_by",
            "DATE_FORMAT(finance_approved_date, '%d-%m-%Y') AS finance_approved_date",
            "finance_reject_reason"
        ];

        $rejected_result = $pdo->select(
            [$table_vendor, $rejected_columns],
            "finance_approval = 2",
            '',
            '',
            $order_by,
            $sql_function
        );

        // 🔹 Step 3: Merge both results
        $res_array = array_merge(
            $accepted_result->status ? $accepted_result->data : [],
            $rejected_result->status ? $rejected_result->data : []
        );

        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        // 🔹 Get permitted actions
        $table_user = "user_screen_permission";
        $action_data = $pdo->select(
            [$table_user, ["action_unique_id", "user_type"]],
            "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'"
        );
        $action_ids = array_column($action_data->data ?? [], 'action_unique_id');

        // 🔹 Step 4: Format each row
        foreach ($res_array as $value) {
            $value['s_no'] = $sno++;

            $bill_no = $value['bill_no'];
            $bill_date = $value['bill_date'];
            $vendor_id = $value['vendor_id'];

            $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';
            $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';

            // Accounts Approval Status
            $accounts_approval = $value['accounts_approval'];
            $value['accounts_approval'] = ($accounts_approval == 1)
                ? '<span style="color: green; font-weight: bold;">Processed</span>'
                : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';

            // View Button
            $btn_view = '<span style="display:block; text-align:center;"><i class=" mdi mdi-eye view-btn-2" 
            data-ponum="' . $value['po_num'] . '" 
            data-billno="' . $bill_no . '"  
            data-vendor ="' . $vendor_id . '" 
            data-billdate ="' . $value['bill_date'] . '" 
            data-financerejectreason ="' . $value['finance_reject_reason'] . '" 
            data-financeapproval ="' . $value['finance_approval'] . '" 
            data-approver ="' . $value['finance_approved_by'] . '" 
            data-approvedate ="' . $value['finance_approved_date'] . '" title="View"></i></span>';

            $value['unique_id'] = $btn_view;

            // Finance Approval Icon
            $finance_status = $value['finance_approval'];
            if ($finance_status === '1') {
                $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>
                <i class='mdi mdi-check-circle mdi-24px' style='color:green;' title='Approved'></i>
            </div>";
            } elseif ($finance_status === '2') {
                $value['finance_approval'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>
                <i class='mdi mdi-close-circle mdi-24px' style='color:red;' title='Rejected'></i>
            </div>";
            }

            // Vendor Display
            $vendor_name = $value['ven_company_name'];
            $vendor_reg_id = $value['vendor_reg_id'];
            $address = $value['address'];
            $contact_no = $value['contact_no'];

            $value['vendor_name'] = "<div>
            <strong>{$vendor_name} - {$vendor_reg_id}</strong><br>
            <span>{$address} - Ph.No. {$contact_no}</span>
        </div>";

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
            "get_consignee_contact_name((SELECT consignee_unique_id from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS po_date",

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = "bill_no = '$bill_no' AND vendor_id = '$vendor' AND finance_approval = 0";

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

                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_number" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "total_amount" => $value['total_amount'],
                    "bill_no" => $value['bill_no'],
                    "invoice_no" => $value['invoice_no'],
                    "unique_id" => $unique_id,
                    "status_control" => $value['po_form_unique_id'],
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
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            'invoice_qty',
            'rate',
            'gst',
            'amount',
            'unique_id',
            'finance_approval',
            'vendor_name',
            'bill_no',
            "get_consignee_contact_name((SELECT consignee_unique_id from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_vendor_billdata WHERE vendor_payment_details.po_form_unique_id = view_vendor_billdata.form_main_unique_id LIMIT 1) AS po_date",

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

                $unique_id = $value['unique_id'];

                $value['unique_id'] = '<div class="checkbox-container">
                                    <input class="myCheck" type="checkbox" name="bill_checkbox[]" data-bill-no ="' . $bill_no . '" data-unique-id = "' . $unique_id . '" 
                                    data-id = "' . $dc_num . '" data-amnt = "' . $amnt . '">
                                </div>';

                $value['po_num'] = $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>";
                $value['invoice_no'] = $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>";
                $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>";

                $value['amount'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>";
                $value['invoice_qty'] = "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>";
                $value['rate'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['rate']) . "</b></span>";
                $value['gst'] = "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>";

                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "consignee_name" => $value['consignee_name'],
                    "sum_amount" => $amnt,
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
        $status = $_POST['finance_approval_sts'];

        $unique_id = $_POST['unique_id'];

        $reject_reason = $_POST['reject_reason'];


        $dc_no = $_POST['dc_no'];

        $date = date('Y-m-d H:i:s');

        $table = 'vendor_payment_details';

        $table2 = "invoice_verfication_table";

        if ($status == '1') {
            $columns = [
                "finance_approval" => $status,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date

            ];
        } else if ($status == '2') {

            $columns = [
                "finance_approval" => $status,
                "finance_reject_reason" => $reject_reason,
                "finance_approved_by" => $_SESSION['user_id'],
                "finance_approved_date" => $date

            ];
        }


        $invoice_verify_columns = [

            "vendor_finance_approval" => $status,
            "finance_reject_reason" => $reject_reason,
            "vendor_payment_allocated" => '0'

        ];




        $update_where = "bill_no = '$bill_no' AND unique_id ='$unique_id'";

        $update_where_dc = "dc_number ='$dc_no'";

        $action_obj = $pdo->update($table, $columns, $update_where);

        $action_obj_1 = $pdo->update($table2, $invoice_verify_columns, $update_where_dc);

        // echo "<pre>";
        // print_r($action_obj_1->sql); // Show the actual query
        // print_r($action_obj_1->error); // If available
        // echo "</pre>";
        // die();

        $total_amount = 0;

        $amount_column = [
            "(amount) as ttl_amount"
        ];

        $table_details = [

            $table,
            $amount_column
        ];

        $amount_where = "bill_no  = '$bill_no' AND finance_approval != '2'";
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




    //  case 'user_type_options':

    // $user_type          = $_POST['user_type'];

    // $user_type_options  = under_user_type($user_type);

    // $user_type_options  = select_option($user_type_options,"Select");

    // echo $user_type_options;

    // break;


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


