<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "invoice_creation_main";
// $table             = "view_dispatch_list_final";
$table_dispatch = "dispatch_list";
$table_dcnum = "dc_num_status";
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
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
    case 'deleivery_confirmation':
        $person_name = $_POST["person_name"];
        $contact_no = $_POST["contact_no"];
        $pro_rec_date = $_POST["pro_rec_date"];
        $remarks = $_POST["remarks"];
        $dc_number = $_POST["dc_number"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $unique_id = $_POST["unique_id"];
        $delv_con = $_POST["delv_con"];
        $deliverconfrimperson = $_SESSION["staff_id"];
        $delv_conf_date = date("Y-m-d");

        if ($delv_con == 'Confirmation') {
            $delv_con = '3';
        } else {
            $delv_con = '5';
        }

        $status = false;
        $msg = '';
        $error = '';
        $sql = '';
        $data = [];

        $columns = [
            "rec_person_name" => $person_name,
            "rec_contact_no" => $contact_no,
            "pro_rec_date" => $pro_rec_date,
            "deliv_remarks" => $remarks,
            "status" => $delv_con,
            "delv_conf_date" => $delv_conf_date,
            "delv_conf_person" => $deliverconfrimperson
        ];

        $update_where = 'consignee_unique_id="' . $consignee_unique_id . '" AND dc_number="' . $dc_number . '"';

        $action_obj = $pdo->update($table_dispatch, $columns, $update_where);



        $dc_numcolumns = [
            "delv_conf_status" => $delv_con,
            "delv_conf_date" => $delv_conf_date
        ];

        $dc_num_where = 'dc_number="' . $dc_number . '"';

        $action_obj = $pdo->update($table_dcnum, $dc_numcolumns, $dc_num_where);




        if ($action_obj->status) {
            $status = true;
            $data = $action_obj->data;
            $sql = $action_obj->sql;
            $msg = $unique_id ? "update" : "create";
        } else {
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


    case 'deleivery_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // $table_delivery = "view_dispatch_delivery_list";
        $table_delivery = "dispatch_list";

        $team_mem3 = $_POST['team_mem3'];
        // Query Variables

        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_date",
            "get_address(consignee_unique_id) AS con_address",
            "(SELECT staff_name
      FROM user
      WHERE staff_id = (
          SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no and dc_number=dispatch_list.dc_number
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS team_member",

            "invoice_no",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "name_of_courier",
            "delivery_date",
            "delivery_proof",
            "status",
            "unique_id",
            "(SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no  and dc_number=dispatch_list.dc_number
            AND is_delete = 0
          LIMIT 1) AS team_mem",
            "invoice_auto_id",
            "po_form_unique_id",
            "consignee_unique_id",

            "(SELECT ledger_name
      FROM department_creation_sublist
      WHERE unique_id = (
          SELECT ledger_name
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS ledger_name",
            "get_po_number(po_form_unique_id) as po_num",
            "invoice_date",
            "mode_of_delivery",
            "dc_number",

        ];
        $table_details = [
            $table_delivery,
            $columns
        ];

        $where = " dispatch_list.is_delete = 0 
           AND (dispatch_list.status = '2' OR dispatch_list.status = '5') ";




        $group_by = " dispatch_list.dc_number ";


        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {

            if ($team_mem3 == '') {

                $where .= " ";
            } else {
                $where .= " AND (
    SELECT team_mem
    FROM invoice_creation_main
    WHERE invoice_no = dispatch_list.invoice_no  and dc_number=dispatch_list.dc_number
      AND is_delete = 0
    LIMIT 1
) = '$team_mem3' ";

            }
        } else {
            if ($team_mem3 == '') {
                $where .= " ";
            } else {
                $where .= " AND (
    SELECT team_mem
    FROM invoice_creation_main
    WHERE invoice_no = dispatch_list.invoice_no  and dc_number=dispatch_list.dc_number
      AND is_delete = 0
    LIMIT 1
) = '$team_mem3' ";

            }
        }


$user=$_SESSION["unique_id"];
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];

  if ($user_type_unique_id =='69b0115ced3bd96390'){
            $where .= " AND (
    SELECT executive_name
    FROM po_form
    WHERE unique_id = dispatch_list.po_form_unique_id
      AND is_delete = 0
    LIMIT 1
) = '$user'";

        }

        $from_date = $_POST['from_date'] ?? '';
        $to_date = $_POST['to_date'] ?? '';

        if ($from_date && $to_date) {

            if ($opt3 == '40') {
                // po_date stored as dd-mm-yyyy
                $where .= " AND po_date
                     BETWEEN '$from_date' AND '$to_date' ";
            } elseif ($opt3 == '50') {
                // invoice_date stored as dd-mm-yyyy
                $where .= " AND invoice_date
                     BETWEEN '$from_date' AND '$to_date' ";
            } elseif ($opt3 == '60') {
                // delivery_date stored as yyyy-mm-dd
                $where .= " AND delivery_date
                     BETWEEN '$from_date' AND '$to_date' ";
            }
        }



        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $datatable_order = datatable_sorting($order_column, $order_dir, $columns);

        // fixed priority order
        $fixed_order = "status  DESC";

        if ($datatable_order) {
            $order_by = $fixed_order . ", " . $datatable_order;
        } else {
            $order_by = $fixed_order;
        }



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
                $value['s_no'] = $sno + 1;

                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                // $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
                $value['po_date'] = '<strong>' . $value['po_num'] . '</strong><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

                // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' . $value['con_address'] . '</span>';

                // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
                $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

                if ($value['mode_of_delivery'] = '1') {
                    $value['mode_of_delivery'] = 'Hand';
                } elseif ($value['mode_of_delivery'] = '2') {
                    $value['mode_of_delivery'] = 'Courier';
                }

                if ($value['status'] == '2') {
                    $value['status'] = 'Pending';
                } elseif ($value['status'] == '5') {
                    $value['status'] = '<span style="color:red;font-weight:600;">Not Delivered</span>';
                }


                $value['name_of_courier'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['name_of_courier'] . '</span><br><span style="text-transform: uppercase;">' . $value['mode_of_delivery'] . '</span>';



                $orgDate2 = $value['delivery_date'];
                $value['delivery_date'] = date("d-m-Y", strtotime($orgDate2));
                $value['delivery_proof'] = image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
                if ($value['delivery_status'] == "1") {
                    $value['delivery_status'] = "yes";
                } else if ($value['delivery_status'] == "2") {
                    $value['delivery_status'] = "NO";
                }
                // $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';


                $value['unique_id'] = '<a href="index.php?file=delivery_confirmation/update1&unique_id=' . $value['po_form_unique_id'] . '&consignee_unique_id=' . $value['consignee_unique_id'] . '&dc_number=' . $value['dc_number'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                $value['po_form_unique_id'] = $btn_update;
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


    case 'deleivery_comdatatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // $table_delivery = "view_delivery_confirmation";
        $table_delivery = "dispatch_list";


        $team_mem3 = $_POST['team_mem3'];
        // Query Variables

        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_date",
            "get_address(consignee_unique_id) AS con_address",
            "(SELECT staff_name
      FROM user
      WHERE staff_id = (
          SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS team_member",

            "invoice_no",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "name_of_courier",
            "delivery_date",
            "delivery_proof",
            "unique_id",
            "status",
            "(SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1) AS team_mem",
            "invoice_auto_id",
            "po_form_unique_id",
            "consignee_unique_id",

            "(SELECT ledger_name
      FROM department_creation_sublist
      WHERE unique_id = (
          SELECT ledger_name
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS ledger_name",
            // "get_po_number(po_form_unique_id) as po_num",
            "invoice_date",
            "mode_of_delivery",
            "dc_number",
            "po_num"

        ];
        $table_details = [
            $table_delivery,
            $columns
        ];

        $where = " dispatch_list.is_delete = 0  AND dispatch_list.status = '3' ";

        $group_by = " dispatch_list.dc_number ";


        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {

            if ($team_mem3 == '') {

                $where .= " ";
            } else {
                $where .= " AND (
    SELECT team_mem
    FROM invoice_creation_main
    WHERE invoice_no = dispatch_list.invoice_no
      AND is_delete = 0
    LIMIT 1
) = '$team_mem3' ";
            }
        } else {
            if ($team_mem3 == '') {
                $where .= " ";
            } else {
                $where .= " AND (
    SELECT team_mem
    FROM invoice_creation_main
    WHERE invoice_no = dispatch_list.invoice_no
      AND is_delete = 0
    LIMIT 1
) = '$team_mem3' ";
            }
        }

        $from_date = $_POST['from_date'] ?? '';
        $to_date = $_POST['to_date'] ?? '';

        if ($from_date && $to_date) {

            if ($opt3 == '40') {
                // po_date stored as dd-mm-yyyy
                $where .= " AND po_date
                     BETWEEN '$from_date' AND '$to_date' ";
            } elseif ($opt3 == '50') {
                // invoice_date stored as dd-mm-yyyy
                $where .= " AND invoice_date
                     BETWEEN '$from_date' AND '$to_date' ";
            } elseif ($opt3 == '60') {
                // delivery_date stored as yyyy-mm-dd
                $where .= " AND delivery_date
                     BETWEEN '$from_date' AND '$to_date' ";
            }
        }
        $user=$_SESSION["unique_id"];
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];

 if ($user_type_unique_id =='69b0115ced3bd96390'){
            $where .= " AND (
    SELECT executive_name
    FROM po_form
    WHERE unique_id = dispatch_list.po_form_unique_id
      AND is_delete = 0
    LIMIT 1
) = '$user'";

        }


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
                // $value['po_date'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['po_date'] . '</span>';
// $value['con_address'] = $value['con_address'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span>';
// $value['invoice_no'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_date'] . '</span>';
//                 $value['dc_date'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                if ($value['mode_of_delivery'] == 1) {
                    $value['mode_of_delivery'] = 'Hand';
                } elseif ($value['mode_of_delivery'] == 2) {
                    $value['mode_of_delivery'] = 'Courier';
                }
                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                // $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
                $value['po_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

                // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' . $value['con_address'] . '</span>';

                // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
                $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';
                $value['name_of_courier'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['name_of_courier'] . '</span><br><span style="text-transform: uppercase;">' . $value['mode_of_delivery'] . '</span>';

                // $value['name_of_courier'] = $value['name_of_courier'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['mode_of_delivery'] . '</span>';
                $value['delv_conf_person'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['delv_conf_person'] . '</span><br><span style="text-transform: uppercase;">' . $value['delv_conf_date'] . '</span>';


                $orgDate2 = $value['delivery_date'];
                $value['delivery_date'] = date("d-m-Y", strtotime($orgDate2));
                $value['delivery_proof'] = image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
                if ($value['delivery_status'] == "1") {
                    $value['delivery_status'] = "yes";
                } else if ($value['delivery_status'] == "2") {
                    $value['delivery_status'] = "NO";
                }

                $value['unique_id'] = '<a href="index.php?file=delivery_confirmation/update1&unique_id=' . $value['po_form_unique_id'] . '&consignee_unique_id=' . $value['consignee_unique_id'] . '&dc_number=' . $value['dc_number'] . '&view=' . 1 . '"><i class="mdi mdi-eye-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                $value['po_form_unique_id'] = $btn_update;
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
    case 'user_permission_2':
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

    case 'user_permission_1':
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


    case 'deleivery_confirmation1':
        $person_name = $_POST["person_name"];
        $contact_no = $_POST["contact_no"];
        $pro_rec_date = $_POST["pro_rec_date"];
        $remarks = $_POST["remarks"];
        $dc_number = $_POST["dc_number"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $unique_id = $_POST["unique_id"];
        $delv_con = '3';
        $deliverconfrimperson = $_SESSION["staff_id"];
        $delv_conf_date = date("Y-m-d");

        $status = false;
        $msg = '';
        $error = '';
        $sql = '';
        $data = [];

        $columns = [
            "rec_person_name" => $person_name,
            "rec_contact_no" => $contact_no,
            "pro_rec_date" => $pro_rec_date,
            "deliv_remarks" => $remarks,
            "status" => $delv_con,
            "delv_conf_date" => $delv_conf_date,
            "delv_conf_person" => $deliverconfrimperson
        ];

        $update_where = 'consignee_unique_id="' . $consignee_unique_id . '" AND dc_number="' . $dc_number . '"';
        $action_obj = $pdo->update($table_dispatch, $columns, $update_where);

        $dc_numcolumns = [
            "delv_conf_status" => $delv_con,
            "delv_conf_date" => $delv_conf_date
        ];
        $dc_num_where = 'dc_number="' . $dc_number . '"';
        $action_obj2 = $pdo->update($table_dcnum, $dc_numcolumns, $dc_num_where);

        if ($action_obj->status && $action_obj2->status) {
            $status = true;
            $msg = "Approved successfully";
        } else {
            $error = $action_obj->error ?? $action_obj2->error;
            $msg = "Approval failed";
        }

        echo json_encode([
            "status" => $status,
            "error" => $error,
            "msg" => $msg
        ]);
        break;



    case 'deleivery_datatable1':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // $table_delivery = "view_dispatch_delivery_list";
        $table_delivery = "view_deleievery_confirmation_pending";


        $team_mem3 = $_POST['team_mem3'];
        // Query Variables

        $json_array = "";
        $columns = [
            "''as selectall",
            "'' as s_no",
            "po_date",
            "get_address(consignee_unique_id) AS con_address",
            "get_staff_name_with_staff_id(team_mem) AS team_member",
            "invoice_no",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "name_of_courier",
            "delivery_date",
            "delivery_proof",
            "unique_id",
            "team_mem",
            "invoice_auto_id",
            "po_form_unique_id",
            "consignee_unique_id",
            "get_ledger_name(ledger_name) AS ledger_name",
            "get_po_number(po_form_unique_id) as po_num",
            "invoice_date",
            "mode_of_delivery",
            "dc_number",

        ];
        $table_details = [
            $table_delivery,
            $columns
        ];
        $where = "1=1";

        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {

            if ($team_mem3 == '') {

                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem3' ";
            }
        } else {
            if ($team_mem3 == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem3' ";
            }
        }

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
        if ($opt3 == '40') {

            $where .= " AND STR_TO_DATE(po_date, '%d-%m-%Y')  >= '" . $from_date . "' AND STR_TO_DATE(po_date, '%d-%m-%Y')  <= '" . $to_date . "' ";

        } else if ($opt3 == '50') {

            $where .= " AND STR_TO_DATE(invoice_date, '%d-%m-%Y') >= '" . $from_date . "' AND STR_TO_DATE(invoice_date, '%d-%m-%Y') <= '" . $to_date . "' ";
        } else if ($opt3 == '60') {

            $where .= " AND delivery_date >= '" . $from_date . "' AND delivery_date <= '" . $to_date . "' ";
            $from_date_converted = date('Y-m-d', strtotime($from_date));
            $to_date_converted = date('Y-m-d', strtotime($to_date));
            $where = "STR_TO_DATE(delivery_date, '%Y-%m-%d') >= STR_TO_DATE('" . $from_date_converted . "', '%Y-%m-%d') AND
                 STR_TO_DATE(delivery_date, '%Y-%m-%d') <= STR_TO_DATE('" . $to_date_converted . "', '%Y-%m-%d')";

        }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

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
                $value['selectall'] = '<div class="checkbox-container">
    <input 
        class="myCheck" 
        type="checkbox" 
        data-consignee-id="' . $value['consignee_unique_id'] . '"
        data-dc-number="' . $value['dc_number'] . '"
        data-unique-id="' . $value['unique_id'] . '"
    >
</div>';


                $value['s_no'] = $sno + 1;

                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';
                $value['po_date'] = '<strong>' . $value['po_num'] . '</strong><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';
                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' . $value['con_address'] . '</span>';
                $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

                if ($value['mode_of_delivery'] = '1') {
                    $value['mode_of_delivery'] = 'Hand';
                } elseif ($value['mode_of_delivery'] = '2') {
                    $value['mode_of_delivery'] = 'Courier';
                }
                $value['name_of_courier'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['name_of_courier'] . '</span><br><span style="text-transform: uppercase;">' . $value['mode_of_delivery'] . '</span>';
                $orgDate2 = $value['delivery_date'];
                $value['delivery_date'] = date("d-m-Y", strtotime($orgDate2));
                $value['delivery_proof'] = image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
                if ($value['delivery_status'] == "1") {
                    $value['delivery_status'] = "yes";
                } else if ($value['delivery_status'] == "2") {
                    $value['delivery_status'] = "NO";
                }
                $value['unique_id'] = '<a href="index.php?file=delivery_confirmation/update1&unique_id=' . $value['po_form_unique_id'] . '&consignee_unique_id=' . $value['consignee_unique_id'] . '&dc_number=' . $value['dc_number'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                $value['po_form_unique_id'] = $btn_update;
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


    default:
        break;
}
function image_view($folder_name = "", $unique_id = "", $delivery_proof = "")
{
    // alert('hi');
    // echo $dc_file_name;
    $file_names = explode(',', $delivery_proof);
    $image_view = '';
    if ($delivery_proof) {
        foreach ($file_names as $file_key => $delivery_proof) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $delivery_proof);
            if ($delivery_proof) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $delivery_proof . '\')"><img src="uploads/' . $folder_name . '/' . $delivery_proof . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }
    return $image_view;
}

