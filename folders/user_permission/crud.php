<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = "user_screen_permission";
$table_log         = "user_screen_permission_log";

// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];

$json_array         = "";
$sql                = "";

$main_screen        = "";
$section_name       = "";
$screen_name        = "";
$screen_folder_name = "";
$icon_name          = "";
$order_no           = "";
$user_actions       = "";
$is_active          = "";
$description        = "";
$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

switch ($action) {

case 'createupdate':

    $json_data = json_decode($_POST['json_data'], true);

    $rows = [];
    $columns = [
        "unique_id",
        "user_type",
        "main_screen_unique_id",
        "section_unique_id",
        "screen_unique_id",
        "action_unique_id"
    ];

    $user_type   = $_POST['user_type'] ?? $_POST['unique_id'];
    $main_screen = $_POST['main_screen'];
    $unique_id   = $_POST['unique_id'] ?? '';

    /* build rows */
    if (!empty($json_data)) {
        foreach ($json_data as $data_value) {
            $rows[] = [
                "unique_id"             => unique_id($prefix),
                "user_type"             => $user_type,
                "main_screen_unique_id" => $main_screen,
                "section_unique_id"     => $data_value['section'],
                "screen_unique_id"      => $data_value['screen'],
                "action_unique_id"      => $data_value['action']
            ];
        }
    }

    /* CREATE: block empty */
    if (!$unique_id && empty($rows)) {
        echo json_encode([
            "status" => 0,
            "msg"    => "error",
            "error"  => "No data to insert"
        ]);
        exit;
    }

    /* duplicate check (create only) */
    $check = $pdo->select(
        [$table, ["COUNT(unique_id) AS count"]],
        'main_screen_unique_id="'.$main_screen.'" 
         AND user_type="'.$user_type.'" 
         AND is_delete=0'
    );

    if (!$check->status) {
        echo json_encode([
            "status" => 0,
            "msg"    => "error",
            "error"  => $check->error
        ]);
        exit;
    }

    if ($check->data[0]['count'] > 0 && !$unique_id) {
        echo json_encode([
            "status" => 0,
            "msg"    => "already"
        ]);
        exit;
    }

    /* UPDATE: delete old permissions */
    if ($unique_id) {
        $pdo->delete($table, [
            "user_type"             => $user_type,
            "main_screen_unique_id" => $main_screen
        ]);

        /* ✅ UPDATE WITH NO VALUES → SUCCESS */
        if (empty($rows)) {
            echo json_encode([
                "status" => 1,
                "msg"    => "update"
            ]);
            exit;
        }
    }

   
    $insert = $pdo->insertMultiple($table, $columns, $rows);

    if ($insert->status) {

        $pdo->insertMultiple($table_log, $columns, $rows);

        echo json_encode([
            "status" => 1,
            "msg"    => $unique_id ? "update" : "create",
            "sql"    => $insert->sql
        ]);
    } else {
        echo json_encode([
            "status" => 0,
            "msg"    => "error",
            "error"  => $insert->error,
            "sql"    => $insert->sql
        ]);
    }

    break;

    // case 'createupdate':

    //     $json_data          = json_decode($_POST['json_data']);
    //     $rows               = [];
    //     $columns_data       = [];
    //     if (isset($_POST["user_type"])) {
    //     $user_type          = $_POST["user_type"];
    //     } else {
    //     $user_type          = $_POST["unique_id"];
    //     }
    //     $main_screen        = $_POST["main_screen"];
    //     $unique_id          = $_POST["unique_id"];

    //     $update_where       = "";

    //     $columns            = [
    //         "unique_id",
    //         "user_type",
    //         "main_screen_unique_id",
    //         "section_unique_id",
    //         "screen_unique_id",
    //         "action_unique_id"
    //     ];

    //     foreach ($json_data as $data_key => $data_value) {
    //         $columns_data            = [
    //             "unique_id"             => unique_id($prefix),
    //             "user_type"             => $user_type,
    //             "main_screen_unique_id" => $main_screen,
    //             "section_unique_id"     => $data_value->section, 
    //             "screen_unique_id"      => $data_value->screen,
    //             "action_unique_id"      => $data_value->action
    //         ];

    //         $rows[] = $columns_data;
    //     }

    //     // check already Exist Or not
    //     $table_details      = [
    //         $table,
    //         [
    //             "COUNT(unique_id) AS count"
    //         ]
    //     ];
    //     $select_where       = ' main_screen_unique_id = "'.$main_screen.'"  AND user_type = "'.$user_type.'" AND is_delete = 0 ';

    //     // When Update Check without current id
    //     if ($unique_id) {
    //         $select_where   .= ' AND user_type !="'.$unique_id.'" ';
    //     }

    //     $action_obj         = $pdo->select($table_details,$select_where);

    //     // print_r($action_obj);

    //     if ($action_obj->status) {
    //         $status     = $action_obj->status;
    //         $data       = $action_obj->data;
    //         $error      = "";
    //         $sql        = $action_obj->sql;

    //     } else {
    //         $status     = $action_obj->status;
    //         $data       = $action_obj->data;
    //         $error      = $action_obj->error;
    //         $sql        = $action_obj->sql;
    //         $msg        = "error";
    //     }
    //     if ($data[0]["count"]) {
    //         $msg        = "already";
    //     } else if (($data[0]["count"] == 0) && ($msg != "error")) {
    //         // Update Begins
    //         if($unique_id) {

    //             // $columns['user_type'] = $unique_id ;

    //             $update_where   = [
    //                 "user_type"             => $unique_id,
    //                 "main_screen_unique_id" => $main_screen
    //             ];

    //             $action_obj     = $pdo->delete($table,$update_where);

    //         // Update Ends
    //         } 

    //         // Insert Begins            
    //         $action_obj     = $pdo->insertMultiple($table,$columns,$rows);
    //         // Insert Ends



    //         if ($action_obj->status) {

    //             // Log data Entry
    //             $pdo->insertMultiple($table_log,$columns,$rows);

    //             $status         = $action_obj->status;
    //             $data           = $action_obj->data;
    //             $error          = "";
    //             $sql            = $action_obj->sql;

    //             if ($unique_id) {
    //                 $msg        = "update";
    //             } else {
    //                 $msg        = "create";
    //             }
    //         } else {
    //             $status     = $action_obj->status;
    //             $data       = $action_obj->data;
    //             $error      = $action_obj->error;
    //             $sql        = $action_obj->sql;
    //             $msg        = "error";
    //         }
    //     }
    //     if ($action_obj->status) {

    //         // Log data Entry
    //         $pdo->insertMultiple($table_log,$columns,$rows);

    //         $status         = $action_obj->status;
    //         $data           = $action_obj->data;
    //         $error          = "";
    //         $sql            = $action_obj->sql;

    //         if ($unique_id) {
    //             $msg        = "update";
    //         } else {
    //             $msg        = "create";
    //         }
    //     } else {
    //         $status     = $action_obj->status;
    //         $data       = $action_obj->data;
    //         $error      = $action_obj->error;
    //         $sql        = $action_obj->sql;
    //         $msg        = "error";
    //     }

    //     $json_array   = [
    //         "status"    => $status,
    //         "data"      => $data,
    //         "error"     => $error,
    //         "msg"       => $msg,
    //         "sql"       => $sql,
    //         "test"      => $columns
    //     ];

    //     echo json_encode($json_array);

    //     break;

    case 'datatable':
        // DataTable Variables
		$search 	= $_POST['search']['value'];
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            // "@a:=@a+1 s_no",
            "(SELECT user_type FROM user_type AS ut WHERE ut.unique_id = ".$table.".user_type ) AS user_type",
            "user_type as unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        $where = " is_delete = '0' ";
        if ($_POST['search']['value']) {
            $where .= " AND user_type IN (".user_type_like($_POST['search']['value']).")";
        }
        // $order_column   = $_POST["order"][0]["column"];
        // $order_dir      = $_POST["order"][0]["dir"];

        // // Datatable Ordering 
        // $order_by       = datatable_sorting($order_column,$order_dir,$columns);

        // // Datatable Searching
        // $search         = datatable_searching($search,$columns);

        // if ($search) {
        //     if ($where) {
        //         $where .= " AND ";
        //     }

        //     $where .= $search;
        // }
        $group_by       = "user_type";
        $order_by       = "";

        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function,$group_by);
        $total_records  = total_records();

        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['usertype'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;


$action_ids = [];
foreach ($table_users as $item) {
    if (isset($item['action_unique_id'])) {
        $action_ids[] = $item['action_unique_id'];
    }
}
        if ($result->status) {

            $res_array      = $result->data;

            $s_no           = 1;

            foreach ($res_array as $key => $value) {
                // $value['s_no']                = $s_no++;
                array_unshift($value,$s_no++);

                $value['user_type']           = disname($value['user_type']);
                // $value['section_screen']        = disname($value['section_screen']);
                // $value['main_screen']           = disname($value['main_screen']);
                // $value['is_active']             = is_active_show($value['is_active']);
                $btn_update                     = btn_update($folder_name,$value['unique_id']);
                $btn_delete                     = btn_delete($folder_name,$value['unique_id']);
                // $value['unique_id']             = $btn_update.$btn_delete;.
                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update.$btn_delete;                   
                }else if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }else if(in_array('5f8808504271036738', $action_ids)){
                    $value['unique_id'] = $btn_delete;
                }else{
                    $value['unique_id'] = '';
                }
                $data[]                         = array_values($value);
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
    
        case 'user_permission':
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id   = $_POST['user_type_unique_id'];
            // print_r( $user_type_unique_id);die();
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            // print_r($select_where);die();
            $table_details   = [
                $table_user,
                $columns
            ];
    
            $table_users  = $pdo->select($table_details, $select_where);
    
            if ($table_users->status) {
    
                $table_users      = $table_users->data;
    // print_r($table_users);die();
    $action_unique_ids = [];

    foreach ($table_users as $item) {
        if (isset($item['action_unique_id'])) {
            $action_unique_ids[] = $item['action_unique_id'];
        }
    }
    
            } 
                $json_array = [
                    "draw"				=> intval($draw),
                    "recordsTotal" 		=> intval($total_records),
                    "recordsFiltered" 	=> intval($total_records),
                    "data" 				=> $action_unique_ids,
                    "testing"			=> $result->sql
                ];
            
             echo json_encode($json_array);
    
            break;

    case 'delete':

        $unique_id  = $_POST['unique_id'];


        $delete_where   = [
            "user_type"     => $unique_id
        ];

        $action_obj     = $pdo->delete($table,$delete_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            $msg        = "success_delete";

        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);
        
        break;

    case 'sections':

            $main_screen_id        = $_POST['main_screen_id'];

            $section_name_options  = section_name('',$main_screen_id);

            $section_name_options  = select_option($section_name_options,"Select the Screen Section");
    
            echo $section_name_options;
            
            break;
    
    case 'permission_ui':

        $main_screen_id         = $_POST['main_screen'];
        $user_type              = $_POST['user_type'];

        $perm_ui               = user_permission_ui($main_screen_id,$user_type);

        // $section_name_options  = section_name('',$main_screen_id);

        // $section_name_options  = select_option($section_name_options,"Select the Screen Section");

        echo $perm_ui;
        
        break;

    default:
            
            break;
}

?>
