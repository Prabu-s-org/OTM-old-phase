<?php

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
        $rem_amt = $_POST["rem_amt"];
        //   print_r($rem_amt);die();
        $unique_id = $_POST["unique_id"];
        $myinv_no = $_POST['my_inv_no'];
        $acc_year = getFinancialYeardate($po_date);
        $parts = explode('/', $myinv_no);
        // Get the last value from the array
        $myinv_no_value = end($parts);

        $update_where = "";
        // $allowedExts = array('pdf');
        // $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        // if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
        //     $tem_name = random_strings(25) . '.pdf';

        //     move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/payment/' . $tem_name);

        //     // Set $file_names to the stored filename with .pdf extension
        //     $file_names = $tem_name;
        //     $file_org_names = $_FILES['file']['name'];
        // }
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
                'acc_year' => $acc_year,

            ];
        } else {
            $columns = [
                "payement_receive" => $payement_receive,
                "payment_status" => $payment_status,
                "payment_date" => $payment_date,
                "ld_amount" => $ld_amount,
                "ld_days" => $ld_days,
                'acc_year' => $acc_year,



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
                'acc_year' => $acc_year,
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
                "tran_amt" => $tran_amt,
                "rem_amt" => $rem_amt,
                'acc_year' => $acc_year,
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
            "payment_cancel_reason" => $reject_reason,
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

        $columns_main = [
            "inv_cancel_status" => 1,
            "payment_cancel_reason" => $reject_reason,
            "cancel_invoice_no" => $invoice_no,
            // "rem_inv_no"     => $remaining_invoice_no,
            // "invoice_value"           => $total_inv_value,
            // "invoice_qty"           =>$total_inv_qty ,
            // "invoice_no"     => $remaining_invoice_no,

        ];



        $update_where_main = 'bill_form_main_unique_id="' . $unique_id . '" and bill_no="' . $bill_no . '"';

        // print_r($update_where_main);die();
        $action_obj_main = $pdo->update($table_main_1, $columns_main, $update_where_main);

        // print_r($action_obj_main);


        $table_bill_form = "bill_submission_form";

        $columns_bill_form = [
            "is_delete" => 1,
            "payment_cancel_reason" => $reject_reason,
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
            "payment_cancel_reason" => $reject_reason,
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



    // payment update detail

    case 'payment_update_detail':


        $bill_no = $_POST["bill_no"];

        $po_unique_id = $_POST["po_unique_id"];

        $invoice_no = $_POST["invoice_no"];

        $bill_no = $_POST["bill_no"];
        $reciceved_amount = $_POST["reciceved_amount"];

        $claim_amount = $_POST["claim_amount"];

        $trans_id = $_POST["trans_id"];

        //  $trans_id          = $_POST["trans_id"];


        $trans_date = $_POST["trans_date"];

        $tds_amount = $_POST["tds_amount"];
        $gst_amount = $_POST["gst_amount"];
        $ld_amount = $_POST["ld_amount"];

        $balance_amnt = $_POST["balance_amnt"];

        $ttl_amnt = $_POST["ttl_amnt"];

        $trans_amount = $_POST["trans_amount"];

        $date = date('Y-m-d H:i:s');


        $update_where = "";
        // =========================================rejected=================================================

        $columns_sub = [


            "gst_value" => $gst_amount,
            "tds_value" => $tds_amount,
            "trans_date" => $trans_date,
            "tran_amt" => $trans_amount,
            "trans_id" => $trans_id,
            "ld_amount" => $ld_amount,
            "payment_received" => $reciceved_amount,

            "ttl_amount" => $ttl_amnt,
            "balance_amount" => $balance_amnt,
            "payment_status" => 2,
            "payment_date" => $date


        ];

        $table_main = "bill_submission_main_table";


        $main_column = [

            'payment_status' => 2,
            "payment_date" => $date

        ];

        $table_details = [
            $table_main,
            $main_column
        ];

        $select_where = 'is_delete = 0 AND invoice_no="' . $invoice_no . '" AND  bill_no="' . $bill_no . '" ';

        $action_obj_main = $pdo->update($table_main, $main_column, $select_where);



        $table_bill_sub = "bill_submission_sub";



        $update_where_form = 'bill_form_unique_id ="' . $po_unique_id . '" and invoice_no="' . $invoice_no . '" and bill_no="' . $bill_no . '" ';

        // print_r($update_where_123);die();
        $action_obj_form = $pdo->update($table_bill_sub, $columns_sub, $update_where_form);

        //  print_r($action_obj_form);die();




        // }
        // print_r($action_obj_sign);
        // Update Begins

        // print_r($action_obj);
        if ($action_obj_form->status) {
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
        // Query Variables
        $json_array = "";


        $columns = [
            "'' as s_no",
            "bill_no",
            //   "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",
            //         "CASE
            // WHEN bill_submission_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN 
            //     DATE_FORMAT(bill_submission_date, '%d-%m-%Y')  -- already a DATE format
            // WHEN bill_submission_date REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}$' THEN 
            //     DATE_FORMAT(STR_TO_DATE(bill_submission_date, '%d-%m-%Y'), '%d-%m-%Y') -- string format
            // ELSE bill_submission_date
            // END AS bill_submission_date",

            'po_num',
            "(SELECT get_department_name(department) FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS department",
            'invoice_no',
            'invoice_value',
            //   "FORMAT(invoice_value, 2) AS invoice_value",
            "claim_percent",
            "claim_amount",
            "bill_form_unique_id",
            // "DATE_FORMAT(po_date,'%d-%m-%Y') AS po_date",
            "CASE 
                WHEN po_date LIKE '__-__-____' THEN po_date
                ELSE DATE_FORMAT(STR_TO_DATE(po_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS po_date",
            "(SELECT bill_address FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS bill_address",
            // "DATE_FORMAT(invoice_date,'%d-%m-%Y') AS invoice_date",
            "CASE 
                WHEN invoice_date LIKE '__-__-____' THEN invoice_date
                ELSE DATE_FORMAT(STR_TO_DATE(invoice_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS invoice_date",
            //    "DATE_FORMAT(bill_submission_date,'%d-%m-%Y') AS bill_submission_date",
            "CASE 
                WHEN bill_submission_date LIKE '__-__-____' THEN bill_submission_date
                ELSE DATE_FORMAT(STR_TO_DATE(bill_submission_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS bill_submission_date",
            //    "po_date"

        ];

        $table_details = [
            $table,
            $columns
        ];

        // Handle date filters
        $from_date = $_POST['from_date'] ?: '';
        $to_date = $_POST['to_date'] ?: '';
        $where = [];

        if ($from_date && $to_date) {
            $where[] = "bill_submission_date >= '$from_date' AND bill_submission_date <= '$to_date'";
        } elseif ($from_date) {
            $where[] = "bill_submission_date >= '$from_date'";
        } elseif ($to_date) {
            $where[] = "bill_submission_date <= '$to_date'";
        }

        // Add static conditions


        // Convert array to string for SQL

        if ($opt == '4') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where[] = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        } else if ($opt == '5') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where[]  = "STR_TO_DATE(invoice_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(invoice_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        }
        //  else if ($opt == '6') {
        //     $where[]  = "payment_date >= '$from_date' AND payment_date <= '$to_date'";
        // }
         else if ($opt == '7') {
            $where[]  = "bill_submission_date >= '$from_date' AND bill_submission_date <= '$to_date'";
        }




        // Datatable Sorting
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Apply custom sorting logic (payment_status)
        $order_by = "(bill_status = 2) $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        // SQL_CALC_FOUND_ROWS for pagination
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $where[] = "bill_status = '2' AND payment_status IS NULL";

        $where_clause = implode(" AND ", $where);



        // $where .= "bill_status = '2'  AND payment_status IS NULL";
// $where .= "bill_status = '2' AND payment_status != '2'";


        // Execute the query
        $result = $pdo->select($table_details, $where_clause, $limit, $start, $order_by, $sql_function);
        // , $po_date
        // print_r(  $result );die();
        // Fetch the total number of records
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
                $value['s_no'] = $sno + 1;


                $invoice_num = $value['invoice_no'];

                $bill_no = $value['bill_no'];

                $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>(' . $value['po_date'] . ')';

                $value['bill_no'] = '<b>' . $value['bill_no'] . '</b><br>(' . $value['bill_submission_date'] . ')';

                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b><br>(' . $value['invoice_date'] . ')';

                $value['invoice_value'] = '<div class="text-end"><b>' . indian_format(round($value['invoice_value'], 0)) . '</b></div>';
                $value['claim_amount'] = '<div class="text-end"><b>' . indian_format(round($value['claim_amount'], 0)) . '</b></div>';


                // $value['invoice_value'] =  '<b>' . $value['invoice_value'] .'</b>';

                $value['claim_percent'] = '<div class="text-end"><b>' . $value['claim_percent'] . '%' . '</b></div>';

                //   $value['claim_amount'] =  '<  b>' . $value['claim_amount'] .'</b>';
                $address_parts = explode(',', $value['bill_address']);
                $formatted_address = '';

                foreach ($address_parts as $index => $part) {
                    $part = trim($part);
                    $formatted_address .= $part;

                    // Add comma if not last and if comma was not in original part
                    if ($index < count($address_parts) - 1) {
                        $formatted_address .= ',<br>';
                    }
                }

                $form_unique_id = $value['bill_form_unique_id'];

                $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
                $stmtCus->bindParam(':po_unique_id', $form_unique_id);
                $stmtCus->execute();

                $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($customer_data)) {
                    $customerAddress = $customer_data[0]["bill_address"];
                    $department = department_name($customer_data[0]["department"]);
                    $customerName = $customer_data[0]["contact_name"];
                    $customerContact = $customer_data[0]["contact_number"];
                    $customerLan = $customer_data[0]["landline_number"];
                    $customerEmail = $customer_data[0]["email"];
                    $customerState = con_state_name_stock($customer_data[0]["state_name"]);
                    $customerDistrict = district_name_stock($customer_data[0]["district"]);
                    $customerPincode = $customer_data[0]["pin"];
                }
                $stmtCus->closeCursor();

                $value['department'] = '<b>' . $department . '</b><br>' . $customerDistrict . '<br>' . $customerState;

                $orgDate2 = $value['bill_submission_date'];

                $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));



                // new changes==========================================================

                $where_inv = "po_unique_id = '" . $value['bill_form_unique_id'] . "' AND invoice_no = '" . $invoice_num . "'";

                $table1 = "invoice_creation";

                $columns1 = [
                    "item_code",
                    "product",
                    "unit_price",
                    "invoice_qty",
                    "delivery_due_days",
                    "po_date",

                ];

                $table_details1 = [
                    $table1,
                    $columns1
                ];

                $values_product = $pdo->select($table_details1, $where_inv);
                //  print_r($values_product);die();

                if ($values_product) {

                    $product_array = $values_product->data;

                    //  print_r($product_array);die();


                    $ld_total = 0;
                    $ld_daystotal = 0;


                    //  print_r('test');die();

                    foreach ($product_array as $key => $product) {
                        $s_no = $sno + 1;

                        // print_r('test');die();


                        $unit_price_val = $product['unit_price'];

                        //  print_r($unit_price_val);die();

                        $dc_signed_date1 = $product['dc_signed_date'];

                        $btn_update = btn_update_1($folder_name, $value['bill_form_unique_id'], $bill_no, $invoice_num, "");

                        //  print_r($btn_update);die();

                        //  $value['bill_form_unique_id'] = $btn_update;

                        // ,$value['ins_unique_id']s

                        $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);


                    }




                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['bill_form_unique_id'] = $btn_update;

                    } else {
                        $value['bill_form_unique_id'] = '';
                    }
                    //                   if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
//        $value['bill_form_unique_id'] = $btn_update.$btn_delete;                   
//    }
//    else
//     if(in_array('5f88082b25ec031952', $action_ids)){
//         $value['bill_form_unique_id']     =  $btn_update;
//    }
//    else if(in_array('5f8808504271036738', $action_ids)){
//        $value['unique_id'] = $btn_delete;
//    }
//    else{
//     $value['bill_form_unique_id'] = '';
//    }
//  new change

                    if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))) {

                        if ($value['payment_status'] == '2') {
                            // if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){

                            // print_r($value['stock_qty']==$value['invoice_qty']);die();
                            $value['bill_form_unique_id'] = $btn_view;
                        } else {

                            if (in_array('5f88082b25ec031952', $action_ids)) {

                                $value['bill_form_unique_id'] = $btn_update;

                            } else {
                                $value['bill_form_unique_id'] = $btn_update;
                            }
                        }

                    }


                }



                $payment_receive = $value['payement_receive'];

                $payment_status = $value['payment_status'];

                // if ($payment_receive != '') {
                //     $value['payement_receive'] =  $payment_receive;
                // } else {
                //     $value['payement_receive'] = '-';
                // }

                // // if (($payment_status == '1') || ($payment_status == '0')) {
                // if($payment_status == '0' || $payment_status == ''){
                //     $value['payment_status'] = 'Pending';
                // }
                // else if (($payment_status == '1')) {
                //     $value['payment_status'] = 'Rejected';
                // } else if ($payment_status == '2') {
                //     $value['payment_status'] = 'Complete';
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



    case 'payment_completed_datatable':
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
        // Query Variables
        $json_array = "";

        $table = 'bill_submission_sub';


        $columns = [
            "'' as s_no",
            "bill_no",
            // 'po_num',
            "get_po_number(bill_form_unique_id) As po_num",
            "(SELECT get_department_name(department) FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS department",
            'invoice_no',
            'invoice_value',
            //   "FORMAT(invoice_value, 2) AS invoice_value",
            "claim_percentage",
            "claimamt",
            "invoice_qty",
            "bill_form_unique_id",
            // "DATE_FORMAT(po_date,'%d-%m-%Y') AS po_date",
            "CASE 
                WHEN po_date LIKE '__-__-____' THEN po_date
                ELSE DATE_FORMAT(STR_TO_DATE(po_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS po_date",
            "(SELECT bill_address FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS bill_address",
            // "DATE_FORMAT(invoice_date,'%d-%m-%Y') AS invoice_date",
            "CASE 
                WHEN invoice_date LIKE '__-__-____' THEN invoice_date
                ELSE DATE_FORMAT(STR_TO_DATE(invoice_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS invoice_date",
            // "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",
            "CASE 
                WHEN bill_submission_date LIKE '__-__-____' THEN bill_submission_date
                ELSE DATE_FORMAT(STR_TO_DATE(bill_submission_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS bill_submission_date",


        ];

        $table_details = [
            $table,
            $columns
        ];

        // Handle date filters
        $from_date = $_POST['from_date'] ?: '';
        $to_date = $_POST['to_date'] ?: '';
        $where = '';

                $where = "bill_status = '2' AND payment_status = '2'";



          if ($from_date && $to_date) {
            $where .= " AND bill_submission_date >= '$from_date' AND bill_submission_date <= '$to_date'";
        } elseif ($from_date) {
            $where .= " AND bill_submission_date >= '$from_date'";
        } elseif ($to_date) {
            $where .= " AND bill_submission_date <= '$to_date'";
        }


        if ($opt == '4') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where .= " AND STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        } else if ($opt == '5') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where .= " AND  STR_TO_DATE(invoice_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(invoice_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        } else if ($opt == '6') {
            $where .= " AND payment_date >= '$from_date' AND payment_date <= '$to_date'";
        } else if ($opt == '7') {
            $where .= " AND bill_submission_date >= '$from_date' AND bill_submission_date <= '$to_date'";
        }




        // Datatable Sorting
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Apply custom sorting logic (payment_status)
        $order_by = "(payment_status = 2) $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        // SQL_CALC_FOUND_ROWS for pagination
        $sql_function = "SQL_CALC_FOUND_ROWS";


        // Execute the query
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // , $po_date
        // print_r(  $result );die();
        // Fetch the total number of records
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
                $value['s_no'] = $sno + 1;


                $invoice_num = $value['invoice_no'];

                $bill_no = $value['bill_no'];

                $value['bill_no'] = '<b>' . $bill_no . '</b><br>(' . $value['bill_submission_date'] . ')';

                $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>(' . $value['po_date'] . ')';
                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b><br>(' . $value['invoice_date'] . ')';

                $value['invoice_value'] = '<div class="text-end"><b>' . indian_format(round($value['invoice_value'], 0)) . '</b></div>';

                $value['claimamt'] = '<div class="text-end"><b>' . indian_format(round($value['claimamt'], 0)) . '</b></div>';


                // $value['invoice_value'] =  '<b>' . $value['invoice_value'] .'</b>';

                $value['claim_percentage'] = '<div class="text-end"><b>' . $value['claim_percentage'] . '%' . '</b></div>';

                //   $value['claim_amount'] =  '<  b>' . $value['claim_amount'] .'</b>';
                $address_parts = explode(',', $value['bill_address']);
                $formatted_address = '';

                foreach ($address_parts as $index => $part) {
                    $part = trim($part);
                    $formatted_address .= $part;

                    // Add comma if not last and if comma was not in original part
                    if ($index < count($address_parts) - 1) {
                        $formatted_address .= ',<br>';
                    }
                }



                $form_unique_id = $value['bill_form_unique_id'];

                $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
                $stmtCus->bindParam(':po_unique_id', $form_unique_id);
                $stmtCus->execute();

                $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($customer_data)) {
                    $customerAddress = $customer_data[0]["bill_address"];
                    $department = department_name($customer_data[0]["department"]);
                    $customerName = $customer_data[0]["contact_name"];
                    $customerContact = $customer_data[0]["contact_number"];
                    $customerLan = $customer_data[0]["landline_number"];
                    $customerEmail = $customer_data[0]["email"];
                    $customerState = con_state_name_stock($customer_data[0]["state_name"]);
                    $customerDistrict = district_name_stock($customer_data[0]["district"]);
                    $customerPincode = $customer_data[0]["pin"];
                }
                $stmtCus->closeCursor();

                $value['department'] = '<b>' . $department . '</b><br>' . $customerDistrict . '<br>' . $customerState;


                // $value['department'] = '<b>' . $value['department'] . '</b><br>' . $formatted_address;

                $orgDate2 = $value['bill_submission_date'];

                $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));




                //                  $value['bill_form_unique_id'] =   '<button type="button" class="btn btn-sm btn-outline-primary view-btn" 
//           data-unique-id="' . $value['bill_form_unique_id'] . '" 
//           data-bs-toggle="modal" data-bs-target="#billDetailsModal">
//     <i class="fas fa-eye"></i>
//   </button>';


                $value['invoice_qty'] = '
                                        <i class="mdi mdi-eye mdi-18px view-btn" 
                                            data-po-unique-id="' . $value['bill_form_unique_id'] . '" 
                                            data-invoice-no="' . $invoice_num . '"  
                                            data-bill-no="' . $bill_no . '" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#billDetailsModal" 
                                            title="View">
                                        </i>';



                // new changes==========================================================


                $payment_receive = $value['payement_receive'];

                $payment_status = $value['payment_status'];



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









    case 'get_completed_bill':
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


        $po_unique_id = $_POST['po_unique_id'];

        $invoice_no = $_POST['invoice_no'];
        $bill_no = $_POST['bill_no'];


        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";

        $table = 'bill_submission_sub';


        $columns = [
            "'' as s_no",
            "bill_no",
            //  "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",

            // 'po_num',
            "get_po_number(bill_form_unique_id) As po_num",
            "(SELECT get_department_name(department) FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS department",
            'invoice_no',
            'invoice_value',
            //   "FORMAT(invoice_value, 2) AS invoice_value",
            "claim_percentage",
            "claimamt",
            "bill_form_unique_id",
           "get_po_date(bill_form_unique_id)as po_date",

            "(SELECT bill_address FROM po_form WHERE unique_id = " . $table . ".bill_form_unique_id) AS bill_address",
            "DATE_FORMAT(invoice_date,'%d-%m-%Y') AS invoice_date",
            // "bill_no",

            "(SELECT get_department_name(department) from po_form where unique_id = $table.bill_form_unique_id) AS customer",

            "(SELECT get_district_name(district) from po_form where unique_id = $table.bill_form_unique_id) AS district",
            "(SELECT get_state_name(state_name) from po_form where unique_id = $table.bill_form_unique_id) AS state_name",


            "(SELECT (bill_address) from po_form where unique_id = $table.bill_form_unique_id) AS address",
            "(SELECT (contact_name) from po_form where unique_id = $table.bill_form_unique_id) AS contact_name",
            "(SELECT (contact_number) from po_form where unique_id = $table.bill_form_unique_id) AS contact_number",
            "(SELECT (email) from po_form where unique_id = $table.bill_form_unique_id) AS email",
            "(SELECT (executive_name) from po_form where unique_id = $table.bill_form_unique_id) AS executive_name",
            "(SELECT (pin) from po_form where unique_id = $table.bill_form_unique_id) AS pincode",

            "DATE_FORMAT(payment_date,'%d-%m-%Y') AS payment_date",
            "payment_received",
            "ld_amount",
            "claimamt",
            "gst_value",
            "tds_value",
            "trans_id",
            "DATE_FORMAT(trans_date,'%d-%m-%Y') AS trans_date",
            "tran_amt",
            "ttl_amount",
            "DATE_FORMAT(bill_created_date,'%d-%m-%Y') AS bill_created_date",
            "e_no",
            "DATE_FORMAT(bill_submission_date, '%d-%m-%Y') AS bill_submission_date",
            "balance_amount"

            //   ""

        ];

        $table_details = [
            $table,
            $columns
        ];

        // Handle date filters
        $from_date = $_POST['from_date'] ?: '';
        $to_date = $_POST['to_date'] ?: '';
        $where = '';

        if ($opt == '4') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        } else if ($opt == '5') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(invoice_date, '%d-%m-%Y') >= STR_TO_DATE('$from_date_converted', '%d-%m-%Y') AND STR_TO_DATE(invoice_date, '%d-%m-%Y') <= STR_TO_DATE('$to_date_converted', '%d-%m-%Y')";
        } else if ($opt == '6') {
            $where = "payment_date >= '$from_date' AND payment_date <= '$to_date'";
        } else if ($opt == '7') {
            $where = "bill_submission_date >= '$from_date' AND bill_submission_date <= '$to_date'";
        }




        // Datatable Sorting
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Apply custom sorting logic (payment_status)
        $order_by = "(payment_status = 2) $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        // SQL_CALC_FOUND_ROWS for pagination
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $where .= "bill_no = '$bill_no' AND bill_form_unique_id  = '$po_unique_id' AND invoice_no = '$invoice_no'";

        // Execute the query
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // , $po_date
        // print_r(  $result );die();
        // Fetch the total number of records
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
                $value['s_no'] = $sno + 1;


                $value['invoice_value'] = indian_format(round($value['invoice_value']), 0);

                $value['claimamt'] = indian_format(round($value['claimamt']), 0);

                $value['gst_value'] = indian_format(round($value['gst_value']), 0);
                $value['tds_value'] = indian_format(round($value['tds_value']), 0);
                $value['tran_amt'] = indian_format(round($value['tran_amt']), 0);

                $value['ttl_amount'] = indian_format(round($value['ttl_amount']), 0);

                $value['balance_amount'] = indian_format(round($value['balance_amount']), 0);



                //    "balance_amount"

                $value['payment_received'] = indian_format(round($value['payment_received']), 0);

                $value['ld_amount'] = indian_format(round($value['ld_amount']), 0);


                $data[] = ($value);
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

function indian_format($num)
{
    $num_parts = explode('.', $num);
    $int = $num_parts[0];
    $dec = isset($num_parts[1]) ? '.' . $num_parts[1] : '';

    $last_three = substr($int, -3);
    $rest = substr($int, 0, -3);

    if ($rest != '') {
        $last_three = ',' . $last_three;
    }

    $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
    return $rest . $last_three . $dec;
}

