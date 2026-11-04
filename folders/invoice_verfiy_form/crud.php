<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table_invoice_main = "invoice_creation_main";
$table = "view_doc_approval_list_final_ac_team";


// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$session_approved_by = $_SESSION['staff_name'];

$fileUploadPath = $fileUploadConfig->get("upload_folder");

// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

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

        $ac_team_verifiy_status = $_POST["ac_team_verifiy_status"];
        $ac_reason_reject = $_POST["ac_reason_reject"];
        $approved_by = $_POST["approved_by"];
        $invoice_unique_id = $_POST["invoice_unique_id"];
        $invoice_auto_id = $_POST["invoice_auto_id"];

        $dc_number = $_POST["dc_number"];
        // $invoice_doc_status=$_POST["invoice_doc_status"];
        $cur_date = date('Y-m-d');
        // $invoice_no    = $_POST["invoice_no"];
        // if($doc_approval_sts==1){
        //   $doc_approval_sts='Apporval';
        // }
        // else if($doc_approval_sts==2){
        //   $doc_approval_sts='Not_Apporval';
        // }
        $update_where = "";

        $table_inv_main = "invoice_creation_main";
        $table_inv = "invoice_creation";

        if ($ac_team_verifiy_status == '2') {
            $inv_doc_status = '2';
        } elseif ($ac_team_verifiy_status == '1') {
            $inv_doc_status = '4';
        }

        $columns = [
            "ac_team_verifiy_status" => $ac_team_verifiy_status,
            "invoice_doc_status" => $inv_doc_status,
            "reject_reason_elcot" => $ac_reason_reject,
            "ac_approved_date" => $cur_date,
            "ac_team_approved_by" => $approved_by,
            // "unique_id"           => unique_id($prefix)
        ];
        // }
        if ($ac_team_verifiy_status == '2') {
            $columns_1 = [
                "dc_number" => "",
                "dc_date" => NULL,
                "invoice_no" => "",
                "ledger_name" => "",
                "ledger_no" => "",
                "invoice_date" => NULL,
                // "approved_date" => $cur_date
                // "unique_id"           => unique_id($prefix)
            ];
            //    $update_where_1       = "unique_id = '".$invoice_unique_id."'";
            $update_where_1 = "dc_number = '" . $dc_number . "'";
            $action_obj1 = $pdo->update($table_inv_main, $columns_1, $update_where_1);
            // print_r($action_obj1);
            $columns_2 = [
                "dc_num" => "",
                "dc_date" => NULL,
                "invoice_no" => "",
                "ledger_name" => "",
                "ledger_no" => "",
                "invoice_date" => NULL,
                // "approved_date" => $cur_date
                // "unique_id"           => unique_id($prefix)
            ];
            // $update_where_2       = "invoice_auto_id = '".$invoice_auto_id."'";
            $update_where_2 = "dc_num = '" . $dc_number . "'";
            //  and po_unique_id='".$form_main_unique_id."'
            $action_obj2 = $pdo->update($table_inv, $columns_2, $update_where_2);

            // print_r($action_obj2);
        }

        // print_r($action_obj2);

        $table_sub = 'invoice_sublist';
        if ($ac_team_verifiy_status == '2') {
            $columns1
                = [
                    "ac_team_verifiy_status" => $ac_team_verifiy_status,
                    "reject_reason" => $ac_reason_reject,
                    "is_delete" => 1,
                    // "ledger_name"     => $ledger_name,

                ];
        } else {
            $columns1 = [
                "ac_team_verifiy_status" => $ac_team_verifiy_status,
                "reject_reason" => $ac_reason_reject,
            ];
        }



        // $update_where1       = "dc_number = '" . $dc_number . "'";
        $update_where1 = "invoice_id = '" . $invoice_unique_id . "'";
        // and form_main_unique_id='".$form_main_unique_id."'



        $action_obj1 = $pdo->update($table_sub, $columns1, $update_where1);
        // print_r($action_obj1);


        // $table_invoice = 'invoice_creation';
        // $columns1            = [
        //     //  "billed_qty"     => $data[0]['billed_qty'],
        //     "doc_approval_sts"     =>$doc_approval_sts,
        //      "approved_by"           => $approved_by,
        // ];

        // $update_where1       = "po_unique_id = '".$invoice_unique_id."'";

        // $action_obj1     = $pdo->update($table_stock_po,$columns1,$update_where1);



        // Update Beginsda
        $update_where = 'unique_id ="' . $invoice_unique_id . '" ';
        // $update_where  = 'dc_number ="' . $dc_number . '" ';



        $action_obj = $pdo->update($table_invoice_main, $columns, $update_where);

        // print_r($action_obj);
        // Update Ends

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($invoice_unique_id) {
                $msg = "update";
            } else {
                $msg = "create";
            }
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
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];

        $limit = ($length == '-1') ? "" : $length;
        $data = [];

        // Define table name
        $table_snr = 'invoice_verfication_table';

        // Define columns for SELECT
        $columns = [
            "'' as s_no",
            "get_po_number(form_main_unique_id) As po_num",
            "MAX(DATE_FORMAT(po_date, '%d-%m-%Y')) AS po_date",
            "invoice_no",
            "(DATE_FORMAT(invoice_date, '%d-%m-%Y')) AS invoice_date",
            "COUNT(dc_number) AS dc_count",
            "MAX(inv_verify_status) as inv_verify_status",
            "MAX(DATE_FORMAT(inv_verify_approved_date, '%d-%m-%Y')) as inv_verify_approved_date",
            "MAX(inv_verify_approvedby) as inv_verify_approvedby",
            "'' as inv",
            "MAX(unique_id) as unique_id",
            "MAX(document_verification_status) as document_verification_status"
        ];

        // Table details array
        $table_details = [
            $table_snr,
            $columns
        ];

        // Order handling
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Search and filter
        $search_condition = datatable_searching($search, $columns);

        // // ✅ Correct filter: only include invoices where ALL rows have document_verification_status = 2
        // $completed_invoice_filter = "invoice_no IN (
        // SELECT invoice_no
        // FROM invoice_verfication_table
        // GROUP BY invoice_no
        // HAVING COUNT(*) = SUM(CASE WHEN document_verification_status = 2 THEN 1 ELSE 0 END) )";

        // // Final WHERE condition
        // $where = $completed_invoice_filter;
        // if (!empty($search_condition)) {
        //     $where = "($search_condition) AND ($completed_invoice_filter)";
        // }

        $where .= "signed_complete_status = 2 AND inv_verify_status = 1";

        // Group by invoice_no
        $group_by = "invoice_no";

        // Fetch filtered data
        $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);
        // print_r($result);
        // Total records (you may need to implement this function)
        $total_records = total_records();

        // Permission handling
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
        $table_user = "user_screen_permission";
        $perm_columns = ["action_unique_id", "user_type"];
        $perm_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $perm_details = [$table_user, $perm_columns];
        $user_permissions = $pdo->select($perm_details, $perm_where)->data;

        $action_ids = [];
        foreach ($user_permissions as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        // Prepare DataTables JSON response
        $json_array = [];

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;


            foreach ($res_array as $value) {
                $value['s_no'] = $sno++;

                $value['s_no'] = '<div style="text-align:right;"><span>' . $value['s_no'] . '</span></div>';

                $invoice_no = $value['invoice_no'];
                $invoice_date = $value['invoice_date'];
                $dc_count = $value['dc_count'];
                $inv_verify_approved_date = $value['inv_verify_approved_date'];

                // Optional: format or transform fields
                $value['inv_verify_approved_date'] = $inv_verify_approved_date;

                $value['dc_count'] = '<div style="text-align:right;"><span>' . $value['dc_count'] . '</span></div>';

                                    $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/view&invoice_no=' . $invoice_no . '" class=""><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1""></i></a>';

                // Show action button only if verified
                if ($value['document_verification_status'] == '2') {
                    // $value['inv_verify_status'] = ($value['inv_verify_status'] == "1") ? "Approved" : "Pending";
                    $value['inv_verify_status'] = "Approved";


                    // $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/pending&invoice_no=' . $invoice_no . '" class="btn btn-primary waves-effect waves-light" >Verify</a>';

                    $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/view&invoice_no=' . $invoice_no . '" class=""><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1""></i></a>';                                                                                               
                }


                $data[] = array_values($value);
            }

            // Build JSON response
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql // Optional: debug output
            ];
        } else {
            print_r($result); // Debug on failure
            exit;
        }

        echo json_encode($json_array);
        break;




    // completed datatable

    case 'approval_datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];

        $limit = ($length == '-1') ? "" : $length;
        $data = [];

        // Define table name
        $table_snr = 'invoice_verfication_table';

        // Define columns for SELECT
        $columns = [
            "'' as s_no",
            // "MAX(po_num) as po_num",
            // "get_po_num_by_po_unique_id(po_unique_id) AS po_num",
            "get_po_number(form_main_unique_id) As po_num",
            // "MAX(DATE_FORMAT(po_date, '%d-%m-%Y')) AS po_date",
            "DATE_FORMAT((SELECT po_date FROM po_form WHERE po_form.unique_id = invoice_verfication_table.form_main_unique_id and is_delete=0), '%d-%m-%Y') AS po_date",
            "invoice_no",
            "(DATE_FORMAT(invoice_date, '%d-%m-%Y')) AS invoice_date",
            "COUNT(dc_number) AS dc_count",
            // "MAX(inv_verify_approvedby) as inv_verify_approvedby",
            // "MAX(DATE_FORMAT(inv_verify_approved_date, '%d-%m-%Y')) as inv_verify_approved_date",
            // "MAX(inv_verify_status) as inv_verify_status",
            "'' as inv",
            "MAX(unique_id) as unique_id",
            "MAX(document_verification_status) as document_verification_status"
        ];

        // Table details array
        $table_details = [
            $table_snr,
            $columns
        ];
// print_r($table_details);
        // Order handling
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Search and filter
        $search_condition = datatable_searching($search, $columns);


        $where .= "signed_complete_status = 2 AND (inv_verify_status IS NULL OR inv_verify_status = 0)";

        // Group by invoice_no
        $group_by = "invoice_no";
 
        // Fetch filtered data
        $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);
        // print_r($result);
        // Total records (you may need to implement this function)
        $total_records = total_records();

        // Permission handling
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
        $table_user = "user_screen_permission";
        $perm_columns = ["action_unique_id", "user_type"];
        $perm_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $perm_details = [$table_user, $perm_columns];
        $user_permissions = $pdo->select($perm_details, $perm_where)->data;

        $action_ids = [];
        foreach ($user_permissions as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        // Prepare DataTables JSON response
        $json_array = [];

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;


            foreach ($res_array as $value) {
                $value['s_no'] = $sno++;

                $value['s_no'] = '<div style="text-align:right;"><span>' . $value['s_no'] . '</span></div>';

                $invoice_no = $value['invoice_no'];
                $invoice_date = $value['invoice_date'];
                $dc_count = $value['dc_count'];
                $inv_verify_approved_date = $value['inv_verify_approved_date'];

                // Optional: format or transform fields
                $value['inv_verify_approved_date'] = $inv_verify_approved_date;

                $value['dc_count'] = '<div style="text-align:right;"><span>' . $value['dc_count'] . '</span></div>';

            $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/pending&invoice_no=' . $invoice_no . '" class="btn btn-primary waves-effect waves-light" >Verify</a>';

                // Show action button only if verified
                if ($value['document_verification_status'] == '2') {
                    // $value['inv_verify_status'] = ($value['inv_verify_status'] == "1") ? "Approved" : "Pending";
                    // $value['inv_verify_status'] = ($value['inv_verify_status'] == "1") ? "Approved" : "Pending";


                    // $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/pending&invoice_no=' . $invoice_no . '" class="btn btn-primary waves-effect waves-light" >Verify</a>';
                    // style="float:right;margin-right: 10px;margin-top: 5px; width:152px"
                }


                $data[] = array_values($value);
            }

            // Build JSON response
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql // Optional: debug output
            ];
        } else {
            print_r($result); // Debug on failure
            exit;
        }

        echo json_encode($json_array);
        break;


    case 'pending_datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];

        $limit = ($length == '-1') ? "" : $length;
        $data = [];

        // Define table name
        $table_snr = 'dc_num_status';

        // Define columns for SELECT
        $columns = [
            "'' as s_no",
            // "get_po_num_by_po_unique_id(po_unique_id) AS po_num",
            // "form_main_unique_id",
            "(SELECT po_num  FROM po_form  WHERE po_form.unique_id = $table_snr.form_main_unique_id and po_form.is_delete = 0) as po_num",
            "(SELECT po_date  FROM po_form  WHERE po_form.unique_id = $table_snr.form_main_unique_id and po_form.is_delete = 0) as po_date",
            // "DATE_FORMAT((SELECT po_date FROM po_form WHERE dc_num_status.form_main_unique_id = po_form.unique_id LIMIT 1), '%d-%m-%Y') AS po_date",
            // "(DATE_FORMAT(po_date, '%d-%m-%Y')) AS po_date",
            "invoice_no",
            "DATE_FORMAT((SELECT invoice_date FROM invoice_creation_main WHERE dc_num_status.invoice_no = invoice_creation_main.invoice_no LIMIT 1), '%d-%m-%Y') AS invoice_date",
            "COUNT(dc_number) AS dc_number",
            "unique_id",
            "form_main_unique_id AS po_unique_id"
        ];

        // Table details array
        $table_details = [
            $table_snr,
            $columns
        ];

        $where = "invoice_no IS NOT NULL";
        $where .= " AND po_unique_id IS NOT NULL";
        $where .= " AND signed_complete_status IS NULL ";

        // Order handling
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Search and filter
        $search_condition = datatable_searching($search, $columns);

        // ✅ Correct filter: only include invoices where ALL rows have document_verification_status = 2
        //     $completed_invoice_filter = "invoice_no IN (
        //     SELECT invoice_no
        //     FROM invoice_verfication_table
        //     GROUP BY invoice_no
        //     HAVING COUNT(*) = SUM(CASE WHEN document_verification_status = 2 THEN 1 ELSE 0 END)
        // )";

        // Final WHERE condition
        // $where = $completed_invoice_filter;
        // if (!empty($search_condition)) {
        //     $where = "($search_condition) AND ($completed_invoice_filter)";
        // }
        // $where = "signed_doc_status != 2";

        // Group by invoice_no
        $group_by = "invoice_no";


        // Fetch filtered data
        $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);
        // print_r($result);die();

        // Total records (you may need to implement this function)
        $total_records = total_records();

        // Permission handling
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
        $table_user = "user_screen_permission";
        $perm_columns = ["action_unique_id", "user_type"];
        $perm_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $perm_details = [$table_user, $perm_columns];
        $user_permissions = $pdo->select($perm_details, $perm_where)->data;

        $action_ids = [];
        foreach ($user_permissions as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        // Prepare DataTables JSON response
        $json_array = [];

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;

            foreach ($res_array as $value) {
                $value['s_no'] = '<div style="text-align:right;"><span>' . $sno++ . '</span></div>';

                $po_date = $value['po_date'];
                $invoice_no = $value['invoice_no'];
                $invoice_date = $value['invoice_date'];
                $po_num = $value['po_num'];
                $po_unique_id = $value['po_unique_id'];

                $value['dc_number'] = '<div style="text-align:right;"><span>' . $value['dc_number'] . '</span></div>';
                // $inv_verify_approved_date = $value['inv_verify_approved_date'];

                // Optional: format or transform fields
                // $value['inv_verify_approved_date'] = $inv_verify_approved_date;

                // Show action button only if verified
                // if ($value['document_verification_status'] == '2') {
                //     
                //     $value['inv_verify_status'] = ($value['inv_verify_status'] == "1") ? "Approved" : "Pending";

                //     $value['inv'] = '<a href="index.php?file=invoice_verfiy_form/pending&invoice_no=' . $invoice_no . '" class="btn btn-primary waves-effect waves-light" >Verify</a>';
                //     // style="float:right;margin-right: 10px;margin-top: 5px; width:152px"
                // }

                $btn_update = btn_view_dc_status($folder_name, $value['unique_id'], $po_unique_id, $invoice_no);
                $value['unique_id'] = ($accounts_approval == 1) ? '-' : $btn_update;

                $data[] = array_values($value);
            }

            // Build JSON response
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql // Optional: debug output
            ];
        } else {
            print_r($result); // Debug on failure
            exit;
        }

        echo json_encode($json_array);
        break;


    case 'dc_status_datatable':

        $table_pending = "dc_num_status";
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
            "form_main_unique_id",
            "dc_number",
            "doc_approval_sts",
            "ac_team_verifiy_status",
            "material_qc",
            "dispatch_status",
            "delivery_status",
            "delv_conf_status",
            "dc_ir_dispatch_sts",
            "vendor_bulk_sts",
            "vendor_team_sts",
            "installation_status",
            "signed_doc_status",
            "unique_id",
            "invoice_no",
            "dc_operation_date",
            "dc_app_date",
            "dc_mat_date",
            "dc_dispatch_date",
            "vend_allc_date",
            "dc_install_date",
            "dc_sign_doc_date",
            "dc_complete_status",
            "signed_complete_status",
            "delv_conf_date",

        ];
        $table_details = [
            $table_pending,
            $columns
        ];

        // $where = "";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $po_no = $_POST['po_no'];
        $invoice_no = $_POST['invoice_no'];

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

        if ($po_no) {
            $where .= "form_main_unique_id = '$po_no' ";
        }

        if ($invoice_no) {
            $where .= " AND invoice_no = '$invoice_no' ";
        }

        $where .= " AND dc_number IS NOT NULL AND invoice_no IS NOT NULL";

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['usertype'];

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

                $dc_number = $value['dc_number'];

                $invoice = $value['invoice_no'];

                $unique_id = $value['unique_id'];

                $dc_completed_status = $value['dc_complete_status'];

                // $dc_operation_date = date('d-m-Y', strtotime($value['dc_operation_date']));
                // $dc_app_date = date('d-m-Y', strtotime($value['dc_app_date']));
                // $dc_mat_date = date('d-m-Y', strtotime($value['dc_mat_date']));
                // $dc_dispatch_date = date('d-m-Y', strtotime($value['dc_dispatch_date']));
                // $vend_allc_date = date('d-m-Y', strtotime($value['vend_allc_date']));
                // $dc_install_date = date('d-m-Y', strtotime($value['dc_install_date']));
                // $dc_sign_doc_date = date('d-m-Y', strtotime($value['dc_sign_doc_date']));

                $dc_operation_date = !empty($value['dc_operation_date']) ? date('d-m-Y', strtotime($value['dc_operation_date'])) : null;
                $dc_app_date = !empty($value['dc_app_date']) ? date('d-m-Y', strtotime($value['dc_app_date'])) : null;
                $dc_mat_date = !empty($value['dc_mat_date']) ? date('d-m-Y', strtotime($value['dc_mat_date'])) : null;
                $dc_dispatch_date = !empty($value['dc_dispatch_date']) ? date('d-m-Y', strtotime($value['dc_dispatch_date'])) : null;
                $vend_allc_date = !empty($value['vend_allc_date']) ? date('d-m-Y', strtotime($value['vend_allc_date'])) : null;
                $dc_install_date = !empty($value['dc_install_date']) ? date('d-m-Y', strtotime($value['dc_install_date'])) : null;
                $dc_sign_doc_date = !empty($value['dc_sign_doc_date']) ? date('d-m-Y', strtotime($value['dc_sign_doc_date'])) : null;
                $delv_conf_date = !empty($value['delv_conf_date']) ? date('d-m-Y', strtotime($value['delv_conf_date'])) : null;

                // print_r($unique_id);die();

                // Convert status values to icons
                // $doc_approval_icon = $value['doc_approval_sts'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                $doc_approval_icon = $value['doc_approval_sts'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_operation_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                $ac_team_verify_icon = $value['ac_team_verifiy_status'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_app_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                $material_qc_icon = $value['material_qc'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_mat_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                if ($value['dispatch_status'] == 1 && $value['delivery_status'] == 1 || $value['delivery_status'] == 3) {
                    $dispatch_status_icon = '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_dispatch_date . '</small></div>';
                } else {
                    $dispatch_status_icon = '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                }
                if ($value['delv_conf_status'] == 3) {
                    $delv_conf_icon = '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $delv_conf_date . '</small></div>';
                } else {
                    $delv_conf_icon = '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                }

                // $dispatch_status_icon = $value['dispatch_status'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                if ($value['vendor_bulk_sts'] == 1 || $value['vendor_team_sts'] == 2) {
                    $vendor_icon = '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $vend_allc_date . '</small></div>';
                } else {
                    $vendor_icon = '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                }

                // $vendor_bulk_icon = $value['vendor_bulk_sts'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                // $installation_icon = $value['installation_status'] == 2
                //     ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_install_date . '</small></div>'
                //     : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';


                if ($value['installation_status'] == 2) {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>IR</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } elseif ($value['installation_status'] == 5) {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>DC</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } elseif ($value['installation_status'] == 1) {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>SNR</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } else {
                    $installation_icon = '<div class="text-center">
                        <i class="fas fa-times-circle" style="color:red;"></i>
                    </div>';
                }


                $dc_ir_icon = $value['dc_ir_dispatch_sts'] == 3
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_install_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                $signed_doc_icon = $value['signed_complete_status'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_sign_doc_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                // if (($dc_completed_status == '0') && ($value['signed_doc_status'] == 0)) {
                //     $signed_doc_icon = $value['signed_doc_status'] == 2
                //         ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><button type="button" class="btn btn-success" onclick="dc_complete(\'' . htmlspecialchars($dc_number) . '\')">Complete</button>'
                //         : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                // } elseif (($dc_completed_status == '0') && ($value['signed_doc_status'] == 2)) {
                //     $signed_doc_icon = $value['signed_doc_status'] == 2
                //         ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><button type="button" class="btn btn-success" onclick="dc_complete(\'' . htmlspecialchars($dc_number) . '\')">Complete</button>'
                //         : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                // } elseif (($dc_completed_status == '1') && ($value['signed_doc_status'] == 2)) {
                //     $signed_doc_icon = $value['signed_doc_status'] == 2
                //         ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><b>Completed</b>'
                //         : '';
                // }



                $data[] = [
                    "s_no" => $value['s_no'],
                    "invoice_no" => $value['invoice_no'],
                    "dc_number" => $value['dc_number'],
                    "doc_approval_sts" => $doc_approval_icon,
                    "ac_team_verifiy_status" => $ac_team_verify_icon,
                    "material_qc" => $material_qc_icon,
                    "dispatch_status" => $dispatch_status_icon,
                    "delv_conf_status" => $delv_conf_icon,
                    "vendor_icon" => $vendor_icon,
                    "installation_status" => $installation_icon,
                    "dc_ir_dispatch_sts" => $dc_ir_icon,
                    "signed_doc_status" => $signed_doc_icon,
                ];
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


    case 'cardData':
        $po_no = $_POST['po_no'];
        $invoice_no = $_POST['invoice_no'];

        $table = "dc_num_status";


        if (!empty($invoice_no)) {
            // If invoice_no is provided, use it directly
            $columns = [
                "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
                "'$invoice_no' AS invoice_no",  // inject the value as a static string column
                "invoice_no AS invoice_num"
            ];
        } else {
            // If not provided, use GROUP_CONCAT from invoice_creation_main
            $columns = [
                "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
                "(SELECT GROUP_CONCAT(DISTINCT invoice_no SEPARATOR ', ') 
                    FROM invoice_creation_main 
                    WHERE invoice_creation_main.po_num = 
                        (SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id)
                ) AS invoice_no",
                "invoice_no AS invoice_num"
            ];
        }

        $select_where = [];

        if ($po_no) {
            $select_where[] = "form_main_unique_id = '" . $po_no . "'";
        }
        if ($invoice_no) {
            $select_where[] = "invoice_no = '" . $invoice_no . "'";
        }

        // $group_by = " invoice_num";
        $where_clause = implode(" AND ", $select_where); // Combine both if present

        $table_details = [$table, $columns];
        $result = $pdo->select($table_details, $where_clause, "", "", "", "");

        // print_r($result);

        if ($result->status && !empty($result->data)) {
            $row = $result->data[0]; // assuming only one row
            echo json_encode([
                "po_no" => $row['po_no'] ?? '',
                "invoice_no" => $row['invoice_no'] ?? ''
            ]);
        } else {
            echo json_encode([
                "po_no" => '',
                "invoice_no" => ''
            ]);
        }

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


    case 'pending_list_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $invoice_no = $_POST['invoice_no'];


        $data = [];


        if ($length == '-1') {
            $limit = "";
        }
        $table_inv_verfy = "invoice_verfication_table";
        // Query Variables
        $json_array = "";
        $columns = [

            "'' as  sno",
            "'' as  inv",
            // "invoice_auto_id",
            "dc_number",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS po_date",
            // "dc_date",
            "(SELECT con_contact_name FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table_inv_verfy . ".consignee_unique_id group by consignee_details_sub.unique_id ) AS con_contact_name",
            "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table_inv_verfy . ".consignee_unique_id group by consignee_details_sub.unique_id ) AS con_address",
            "invoice_qty",
            "invoice_value",
            "po_num",
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            // "po_date",
            "invoice_no",
            "inv_verify_status",
            // "con_contact_name",
            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = " . $table . ".department group by department_creation.unique_id ) AS department",
            // "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete=0 group by consignee_details_sub.unique_id) AS con_address",
            // "con_address",

            // "invoice_date",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            // "invoice_date",
            // "file_name",
            // "dc_file_name",
            // "ir_file_name",
            // "file_invoice",
            // "invoice_file_org_name",
            "ac_team_verifiy_status",
            "ac_team_approved_by",
            // "invoice_unique_id",
            "doc_approval_sts"
            // "is_active",
            // "unique_id"
        ];
        $table_details = [
            $table_inv_verfy,
            $columns
        ];


        $where = "invoice_no = '$invoice_no'";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "ac_team_verifiy_status='0' $order_dir";


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
        // print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['sno'] = $sno++;

                $invoice_auto_id = $value['invoice_auto_id'];
                $dc_number = $value['dc_number'];
                $invoice_no = $value['invoice_no'];
                $current_date = date('Y-m-d');



                // Create checkbox HTML based on inv_verify_status
                // if ($value['inv_verify_status'] == 1) {
                $checkbox = '<input class="myCheck" type="checkbox" name="bill_checkbox[]" id="bill_checkbox" checked disabled=disbled style=" accent-color: blue">';
                // } else {
                //     $checkbox = '<input class="myCheck" type="checkbox" name="bill_checkbox[]" id="bill_checkbox">';
                // }

                // $value['inv'] = '<div class="checkbox-container">

                //         <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox">
                //      <input type="hidden" name="invoice_no" id="invoice_no" value="' . $invoice_no . '">
                //         <input type="hidden" name="inv_verify_status" id="inv_verify_status" value="1">
                //         <input type="hidden" name="inv_verify_approved_date" id="inv_verfy_approved_date" value="' . $current_date . '">
                //         <input type="hidden" name="inv_verify_approvedby" id="inv_verify_approvedby" value="' . $session_approved_by . '">
                //         <input type="hidden" name="dc_number" id="dc_number" value="' . $dc_number . '">
                //     </div>';
                // Complete inv HTML block
                $value['inv'] = '<div class="checkbox-container">'
                    . $checkbox
                    . '<input type="hidden" name="invoice_no" id="invoice_no" value="' . $invoice_no . '">'
                    . '<input type="hidden" name="inv_verify_status" id="inv_verify_status" value="1">'
                    . '<input type="hidden" name="inv_verify_approved_date" id="inv_verfy_approved_date" value="' . $current_date . '">'
                    . '<input type="hidden" name="inv_verify_approvedby" id="inv_verify_approvedby" value="' . $session_approved_by . '">'
                    . '<input type="hidden" name="dc_number" id="dc_number" value="' . $dc_number . '">'
                    . '</div>';
                $podate = $value['po_date'];
                $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    //     $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                }
                $invoice_value = $value['invoice_value'];
                $value['invoice_qty'] = '<div style="text-align:right;"><span>' . $value['invoice_qty'] . '</span></div>';


                $value['invoice_value'] = '<div style="text-align:right;"><span>' . moneyFormatIndia1($invoice_value) . '</span></div>';

                $po_num = $value['po_num'];
                $po_date = $podate;
                $invoice_no = $value['invoice_no'];

                $data[] = array_values($value);
                // $sno++;
            }

            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                'po_num' => $po_num,
                'po_date' => $po_date,
                'invoice_no' => $invoice_no,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;


    case 'approval_list':

        // $table_invoice_main = "invoice_creation_main";

        // $approved_by = $_POST['approved_by'];
        // $doc_approval_sts = $_POST['approval_status'];
        // $invoice_unique_id = $_POST['invoice_unique_id'];
        // $dc_number = $_POST['dc_number'];

        // $columns = [
        //     'ac_team_verifiy_status' => 1,
        //     'ac_team_approved_by' => $approved_by,
        //     'ac_approved_date' => date('Y-m-d'),
        //     "invoice_doc_status" => 4,
        // ];

        $table_invoice_main = "sign_doc_verification_detail";
        $inv_approval_sts = $_POST['inv_verify_status'];
        $approved_by = $_POST['inv_verify_approvedby'];
        $inv_approval_date = $_POST['inv_verify_approved_date'];

        // $invoice_unique_id = $_POST['invoice_unique_id'];
        $dc_number = $_POST['dc_number'];

        $columns = [
            'inv_verify_status' => 1,
            'inv_verify_approvedby' => $approved_by,
            'inv_verify_approved_date' => date('Y-m-d'),
            // "invoice_doc_status" => 4,
        ];


        $update_where = 'dc_number="' . $dc_number . '" ';

        $action_obj = $pdo->update($table_invoice_main, $columns, $update_where);

        // print_r( $action_obj);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            $msg = "update";


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

function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
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
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}



// doc 2

function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file_name);
    $image_view1 = '';

    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view1 .= "&nbsp";
                } else {
                    $image_view1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file_name);

            if ($ir_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view1 .= '<a href="javascript:print_pdf(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view1;
}


// doc3
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $file_invoice);
    $image_view2 = '';

    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view2 .= "&nbsp";
                } else {
                    $image_view2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_invoice);

            if ($file_invoice) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view2 .= '<a href="javascript:print_pdf(\'/' . $file_invoice . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view2;
}


// doc3


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
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}

