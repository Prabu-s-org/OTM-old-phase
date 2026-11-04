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
     $unique_id = $_POST["unique_id"];

        $update_where = "";

        $columns = [
            // "district_name"           => $district_name,
            // "state_name"     => $state_name,
            "department" => $department,
            "description" => $description,
            "ledger_name" => $ledger_name,
            "ledger_no" => $ledger_no,
            "empty"  => $empty,
            "is_active" => $is_active,
            "unique_id" => unique_id($prefix)
        ];
        $table_details = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND department ="' . $department . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
            if ($empty != '') {

                unset($columns['empty']);

                $update_where = [
                    "empty" => $empty
                ];

                $action_obj = $pdo->update($table, $columns, $update_where);

                // Update Ends
            } else {
                // Insert Begins

                $action_obj = $pdo->insert($table, $columns);
                // Insert Ends
            }
            // print_r(  $action_obj);

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

            "department",
            "description",
            // "ledger_name",
            // "ledger_no",

            "is_active",
            "unique_id"
        ];
        $table_details = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";

        $where = " is_delete = '0' ";

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
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['usertype'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
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

                $value['$department'] = disname($value['department']);
                // $value['ledger_name']  = disname($value['ledger_name']);
                // $value['ledger_no']  = disname($value['ledger_no']);

                // $value['$description'] = disname($value['description']);


                $value['is_active'] = is_active_show($value['is_active']);



                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);
                // $value['unique_id'] = $btn_update.$btn_delete;
                // if ($value['is_active'] == "1") {
                //     $value['is_active']   = "Active";
                // } else {

                //     $value['is_active']   = "Inactive";
                // }

                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update . $btn_delete;
                } else if (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['unique_id'] = $btn_update;
                } else if (in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_delete;
                } else {
                    $value['unique_id'] = '';
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
            // [
            //     'COUNT(unique_id) AS count'
            // ]
        ];
        $select_where = ' is_delete = 0 AND department ="' . $department . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );die();
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

                // if ($unique_id) {
                //     $msg        = "update";
                // } else {
                $msg = "create";
                // }
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
    //     if($subs == " "){
    //         $unique_id = unique_id($prefix);
    //     }else{
    //     $unique_id = $_POST['sub_unique_id'];
    // }
        // $unique_id = $_POST['unique_id'];
        $update_where = '';
        // print_r( 'hii'.$po_name );
        $columns = [
           
            'ledger_name' => $ledger_name,
            'ledger_no' => $ledger_no,

            'form_main_unique_id' => $form_main_unique_id,
            // 'rem_qty'                   => $qty,
            'unique_id' => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details = [
            $table_department_details,
            $columns,
            // [
            //     'COUNT(form_main_unique_id) AS count'
            // ]
        ];
        // $select_where = 'is_delete = 0 AND product ="' . $po_name . '" AND form_main_unique_id ="' . $form_main_unique_id . '" ';
        // $select_where = 'is_delete = 0 AND department ="' . $department . '" AND form_main_unique_id ="' . $form_main_unique_id . '" ';
        $select_where       = ' is_delete = 0 ';

        // When Update Check without current id
        // if ( $unique_id ) {
        //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        // }

        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );s
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
    
                    $update_where   = [
                        'unique_id'     => $subs
                    ];
    
                    $action_obj     = $pdo->update($table_department_details, $columns, $update_where);
                    $msg        = 'update';
                    // Update Ends
                }
            //    if($data[0]['count'] != 0) {
            //         $msg        = 'already';
            //     } 
                else if ($subs == '') {
    
                    $action_obj = $pdo->insert($table_department_details, $columns);
                $msg = 'add';
                        // Insert Begins
                        // $action_obj     = $pdo->insert($table_product_details, $columns);
                        // $msg        = 'add';
                        // Insert Ends
    
                    }

            // }
            // print_r( $action_obj );
            // Insert Ends

        // }
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
        // }

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
    
            $btn_edit_delete    = 'department_details';
            // DataTable Variables
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $limit         = $length;
            $data        = [];
    
            if ($length == '-1') {
                $limit  = "";
            }
            // Query Variables
            $json_array     = "";
            $columns        = [

                "'' as  s_no",
                // "consignee",
                "ledger_name",
               "ledger_no",
               "unique_id",
               "unique_id",
              
            ];
    
            $table_details  = [
                $table_department_details,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
            $where = "is_delete='0' AND form_main_unique_id ='" . $form_main_unique_id . "'";
            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
            // Datatable Ordering 
            $order_by       = datatable_sorting($order_column, $order_dir, $columns);
            
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
                $where .= $search;
            }
            $sql_function   = "SQL_CALC_FOUND_ROWS";
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records  = total_records();
            if ($result->status) {
                $res_array      = $result->data;
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;

                    $btn_edit               = btn_edit($btn_edit_delete, $value['unique_id']);
                    $value['unique_id'] = $btn_edit;
                    // $btn_delete             = btn_delete($btn_edit_delete, $value['unique_id']);
                    // $value['unique_id'] = $btn_delete;
                    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;
    
    

            case 'department_details_edit':
                // Fetch Data
                $unique_id  = $_POST['unique_id']; 

                $data        = [];
        
                // Query Variables
                $json_array     = '';
                $columns        = [
                    // 'department',
                    // 'description',
                    'ledger_name',
                    'ledger_no',
                     'unique_id',
                
                ];
                $table_details  = [
                    $table_department_details,
                    $columns
                ];
                $where='unique_id="'.$unique_id.'" AND is_delete=0';
                // $where          = [
                //     'unique_id'    => $unique_id,
                //     'is_active'    => 1,
                //     'is_delete'    => 0
                // ];
                // $update_where = [
                //     "unique_id" => $unique_id
                // ];
        
                // $action_obj = $pdo->update($table_details, $columns, $update_where);
        
                // $update_where   = [
                //     'unique_id'     => $unique_id
                // ];
        
                // $action_obj     = $pdo->update($table_product_details, $columns, $update_where);
        
                $result         = $pdo->select($table_details, $where);
        // print_r($result);
                if ($result->status) {
        
                    $json_array = [
                        'data'         => $result->data[0],
                        'status'    => $result->status,
                        'sql'       => $result->sql,
                        'error'     => $result->error,
                        'testing'    => $result->sql
                    ];
                } else {
                    print_r($result);
                }
        
                echo json_encode($json_array);
                break;
        
        
    // case 'department_details_delete':

    //     $unique_id = $_POST['unique_id'];

    //     $columns = [
    //         'is_delete' => 0,
    //     ];

    //     $update_where = [
    //         'unique_id' => $unique_id
    //     ];

    //     $action_obj = $pdo->update($table_department_details, $columns, $update_where);

    //     if ($action_obj->status) {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = '';
    //         $sql = $action_obj->sql;
    //         $msg = 'success_delete';
    //     } else {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = $action_obj->error;
    //         $sql = $action_obj->sql;
    //         $msg = 'error';
    //     }

    //     $json_array = [
    //         'status' => $status,
    //         'data' => $data,
    //         'error' => $error,
    //         'msg' => $msg,
    //         'sql' => $sql
    //     ];

    //     echo json_encode($json_array);

    //     break;


        // case 'check_department':

        //     $uni_id          = $_POST["uni_id"];
    
        //     $update_where       = "";
    
        //     $columns            = [];
    
        //     $table_details      = [
        //         "department_creation_sublist",
        //         // [
        //         //     'COUNT(form_main_unique_id) AS count'
        //         // ]
        //     ];
        //     $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';
    
    
        //     $action_obj         = $pdo->select($table_details, $select_where);
        //     // print_r( $action_obj );
        //     if ($action_obj->status) {
        //         $status     = $action_obj->status;
        //         $data       = $action_obj->data;
        //         $error      = '';
        //         $sql        = $action_obj->sql;
        //     } else {
        //         $status     = $action_obj->status;
        //         $data       = $action_obj->data;
        //         $error      = $action_obj->error;
        //         $sql        = $action_obj->sql;
        //         $msg        = 'error';
        //     }
        //     $data = array($data[0]['count']);
        //     $json_array   = [
        //         "status"    => $status,
        //         "data"      => $data,
        //         "error"     => $error,
        //         "msg"       => $msg,
        //         "sql"       => $sql
        //     ];
    
        //     echo json_encode($json_array);
    
        //     break;
    
            // check item count
        // case 'department_cre':
    
        //     $uni_id          = $_POST["uni_id"];
    
        //     $columns            = [
        //         "no_of_po"
        //     ];
    
        //     $table_details      = [
        //         "department_creation",
        //         $columns
        //     ];
        //     $select_where       = ' is_delete = 0 AND unique_id ="' . $uni_id . '"';
    
    
        //     $result         = $pdo->select($table_details, $select_where);
        //     // print_r($result);die();
    
        //     $total_records  = total_records();
    
        //     if ($result->status) {
        //         $s_no = 0;
        //         $res_array      = $result->data;
        //         foreach ($res_array as $key => $value) {
        //             $stored_consignee = $value['no_of_po'];
        //         }
        //     }
        //     $data = array($stored_consignee);
    
        //     $json_array   = [
        //         "status"    => $status,
        //         "data"      => $data,
        //         "error"     => $error,
        //         "msg"       => $msg,
        //         "sql"       => $sql
        //     ];
    
        //     echo json_encode($json_array);
    
        //     break;
    
    

}
?>
