<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "department_creation";
$table_department_details = 'department_creation_sublist';

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

        $department = $_POST["department"];
        $description = $_POST["description"];
        $ledger_name = $_POST["ledger_name"];
        $ledger_no = $_POST["ledger_no"];
        $empty = $_POST["empty"];
        $is_active = $_POST["is_active"];

        $get_unique_id = $_POST['get_unique_id'];



        $unique_id = $_POST["unique_id"];

        $acc_sector = $_POST['acc_sector'];

        $update_where = "";

        $columns = [
            "acc_sector" => $acc_sector,
            "department" => $department,
            "description" => $description,
            "ledger_name" => $ledger_name,
            "ledger_no" => $ledger_no,
            "empty" => $empty,
            "is_active" => $is_active,
            "unique_id" => $unique_id,
        ];
        $table_details = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND department ="' . $department . '"';


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

        // Update Begins
        if ($get_unique_id != '') {

            unset($columns['unique_id']);

            $update_where = [
                "unique_id" => $get_unique_id
            ];

            $action_obj = $pdo->update($table, $columns, $update_where);

            // Update Ends
        } else if ($get_unique_id == '') {
            // Insert Begins

            $action_obj = $pdo->insert($table, $columns);
            // print_r()
            // Insert Ends
        }

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($get_unique_id != '') {
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
        $limit = ($length == '-1') ? '' : $length;

        $data = [];
        $sno = $start + 1;

        $columns = [
            "'' as s_no",
            "get_sector_name(acc_sector) as acc_sector",
            "department",
            "description",
            "is_active",
            "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "is_delete = '0'";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        $search = datatable_searching($search, $columns);
        if ($search) {
            $where .= " AND " . $search;
        }

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
                $value['s_no'] = $sno;
                $value['acc_sector'] = $value['acc_sector'] ? disname($value['acc_sector']) : '-';
                $value['department'] = disname($value['department']);
                $value['description'] = disname($value['description']);
                $value['is_active'] = is_active_show($value['is_active']);

                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

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
                    "acc_sector" => $value['acc_sector'],
                    "department" => $value['department'],
                    "description" => $value['description'],
                    "is_active" => $value['is_active'],
                    "unique_id" => $value['unique_id']
                ];
                $sno++;
            }

            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
            ];
        } else {
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
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
    case 'department_cu':

        $department = $_POST["department"];
        $description = $_POST["description"];
        $ledger_name = $_POST["ledger_name"];
        $ledger_no = $_POST["ledger_no"];

        $is_active = $_POST["is_active"];
        $unique_id = $_POST["form_main_unique_id"];

        $update_where = "";

        $table = 'department_creation';

        $columns = [
            "department" => $department,
            "ledger_name" => $ledger_name,
            "ledger_no" => $ledger_no,
            "is_active" => $is_active,
            "unique_id" => $unique_id
        ];
        $table_details = [
            $table,
        ];
        $select_where = ' is_delete = 0 AND department ="' . $department . '"';


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

            // Insert Begins

            $action_obj = $pdo->insert($table_department, $columns);
            // Insert Ends


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


    case 'department_details_add_update':


        $ledger_name = $_POST['ledger_name'];
        $ledger_no = $_POST['ledger_no'];
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $subs = $_POST['sub_unique_id'];
        $update_where = '';
        $columns = [

            'ledger_name' => $ledger_name,
            'ledger_no' => $ledger_no,

            'form_main_unique_id' => $form_main_unique_id,
            'unique_id' => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details = [
            $table_department_details,
            $columns,
        ];
        $select_where = ' is_delete = 0 ';


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


        // Insert Ends
        if ($subs) {

            unset($columns['unique_id']);

            $update_where = [
                'unique_id' => $subs
            ];

            $action_obj = $pdo->update($table_department_details, $columns, $update_where);

            // print_r($action_obj);
            $msg = 'update';
        } else if ($subs == '') {

            $action_obj = $pdo->insert($table_department_details, $columns);

            // print_r($action_obj);
            
            $msg = 'add';

        }

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


        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;


    case 'department_details_datatable':

        $form_main_unique_id = $_POST['form_main_unique_id'];

        $btn_edit_delete = 'department_details';
        // DataTable Variables

        $data = [];

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "ledger_name",
            "ledger_no",
            "unique_id",

        ];

        $table_details = [
            $table_department_details,
            $columns
        ];

        $where = "is_delete='0' AND form_main_unique_id ='" . $form_main_unique_id . "'";


        $result = $pdo->select($table_details, $where);
        $total_records = total_records();
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;

                $btn_edit = btn_edit($btn_edit_delete, $value['unique_id']);
                $btn_delete = btn_delete($btn_edit_delete, $value['unique_id']);
                $value['unique_id'] = $btn_edit . $btn_delete;

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


    case 'department_details_edit':
        // Fetch Data
        $unique_id = $_POST['unique_id'];

        $data = [];

        // Query Variables
        $json_array = '';
        $columns = [
            'ledger_name',
            'ledger_no',
            'unique_id',

        ];
        $table_details = [
            $table_department_details,
            $columns
        ];
        $where = 'unique_id="' . $unique_id . '" AND is_delete=0';
        $result = $pdo->select($table_details, $where);
        if ($result->status) {

            $json_array = [
                'data' => $result->data[0],
                'status' => $result->status,
                'sql' => $result->sql,
                'error' => $result->error,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'department_details_delete':

        $unique_id = $_POST['unique_id'];

        $columns = [
            'is_delete' => 1,
        ];
        $update_where = [
            'unique_id' => $unique_id
        ];
        $action_obj = $pdo->update($table_department_details, $columns, $update_where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            $msg = 'success_delete';
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];
        echo json_encode($json_array);
        break;

}
?>
