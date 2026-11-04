<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "district_creation";

// Include DB file and Common Functions
include '../../config/dbconfig.php';

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

        $district_name = $_POST["district_name"];
        $state_name = $_POST["state_name"];
        $is_active = $_POST["is_active"];
        $unique_id = $_POST["unique_id"];

        $update_where = "";

        $columns = [
            "district_name" => $district_name,
            "state_name" => $state_name,
            "is_active" => $is_active,
            "unique_id" => unique_id($prefix)
        ];

        $table_details = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND unique_id !="' . $unique_id . '" AND district_name ="' . $district_name . '"';


        $action_obj = $pdo->select($table_details, $select_where);

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
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            // Update Begins
            if ($unique_id) {

                unset($columns['unique_id']);

                $update_where = [
                    "unique_id" => $unique_id
                ];

                $action_obj = $pdo->update($table, $columns, $update_where);

                // Update Ends
            } else {
                // Insert Begins

                $action_obj = $pdo->insert($table, $columns);
                // Insert Ends
            }

            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = "";
                $sql = $action_obj->sql;

                if ($unique_id) {
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
        // DataTable Variables with Validation
        $search = $_POST['search']['value'] ?? '';
        $length = $_POST['length'];
        $start = $_POST['start'] ?? 0;
        $draw = $_POST['draw'] ?? 1;
        $limit = ($length == '-1') ? '' : intval($length);
        $sno = $start + 1;

        $data = [];
        $json_array = [];

        // Query Variables
        $columns = [
            "'' as s_no",
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = {$table}.state_name) AS state_name",
            "district_name",
            "is_active",
            "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "is_delete = '0'";

        // Datatable Ordering
        $order_column = $_POST["order"][0]["column"] ?? 0;
        $order_dir = $_POST["order"][0]["dir"] ?? 'asc';

        // Datatable Searching
        $search_condition = datatable_searching($search, $columns);
        if ($search_condition) {
            $where .= " AND " . $search_condition;
        }
        $order_by = "state_name ASC";
        $sql_function = "SQL_CALC_FOUND_ROWS";

        // Fetch Data
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();

        $screen_id_val = $_POST['screen_id_val'] ?? '';
        $user_type = $_POST['usertype'] ?? '';

        // Fetch User Permissions
        $table_user = "user_screen_permission";
        $permission_columns = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id = '$screen_id_val' AND user_type = '$user_type'";
        $permission_details = [
            $table_user,
            $permission_columns
        ];

        $permission_result = $pdo->select($permission_details, $select_where);
        $permission_data = $permission_result->data ?? [];

        $action_ids = array_column($permission_data, 'action_unique_id');

        if ($result->status) {
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno++;
                $value['state_name'] = disname($value['state_name']);
                $value['district_name'] = disname($value['district_name']);
                $value['is_active'] = is_active_show($value['is_active']);

                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                // Action Buttons Rendering Based on Permissions
                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update . $btn_delete;
                } elseif (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['unique_id'] = $btn_update;
                } elseif (in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_delete;
                } else {
                    $value['unique_id'] = '';
                }

                $data[] = [
                    "s_no" => $value['s_no'],
                    "state_name" => $value['state_name'],
                    "district_name" => $value['district_name'],
                    "is_active" => $value['is_active'],
                    "unique_id" => $value['unique_id']
                ];
            }

            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => "Failed to fetch data."
            ];
        }

        echo json_encode($json_array);
        break;

    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
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

    default:

        break;
}

?>
