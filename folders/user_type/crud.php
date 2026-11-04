<?php 

// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = "user_type";

// Include DB file and Common Functions
include '../../config/dbconfig.php';

// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$user_type          = "";
$is_active          = "";
$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

switch ($action) {
    case 'createupdate':

        $user_type          = $_POST["user_type"];
        //$under_user_type    = $_POST["under_user_type"];
        $is_active          = $_POST["is_active"];
        $unique_id          = $_POST["unique_id"];

        $update_where       = "";

        $columns            = [
            "user_type"           => $user_type,
            //"under_user_type"     => $under_user_type,
            "is_active"           => $is_active,
            "unique_id"           => unique_id($prefix)
        ];

        // Update Begins
        if($unique_id) {

            unset($columns['unique_id']);

            $update_where   = [
                "unique_id"     => $unique_id
            ];

            $action_obj     = $pdo->update($table,$columns,$update_where);

        // Update Ends
        } else {
        // Insert Begins
           
            $action_obj     = $pdo->insert($table,$columns);
        // Insert Ends
        }

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = "update";
            } else {
                $msg        = "create";
            }
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
            "'' as  s_no",
            "user_type",
            "is_active",
            "unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";

        $where = " is_delete = '0' ";

        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column,$order_dir,$columns);

        // Datatable Searching
        $search         = datatable_searching($search,$columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
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

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $value['user_type'] = disname($value['user_type']);
                $value['is_active'] = is_active_show($value['is_active']);

                $btn_update         = btn_update($folder_name,$value['unique_id']);
                $btn_delete         = btn_delete($folder_name,$value['unique_id']);


                if ( $value['unique_id'] == "5f97fc3257f2525529" || $value['unique_id'] == "65deef78ba17d65741") {
                    $btn_update         = "";
                    $btn_delete         = "";
                } 
                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update.$btn_delete;                   
                }else if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }else if(in_array('5f8808504271036738', $action_ids)){
                    $value['unique_id'] = $btn_delete;
                }else{
                    $value['unique_id'] = '';
                }
                // $value['unique_id'] = $btn_update.$btn_delete;
                $data[]             = array_values($value);
                $sno ++;
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
            // print_r($screen_id_val);die();
            
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
        
        $unique_id      = $_POST['unique_id'];

        $columns        = [
            "is_delete"   => 1
        ];

        $update_where   = [
            "unique_id"     => $unique_id
        ];

        $action_obj     = $pdo->update($table,$columns,$update_where);

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

         case 'user_type_options':

        $user_type          = $_POST['user_type'];

        $user_type_options  = under_user_type($user_type);

        $user_type_options  = select_option($user_type_options,"Select");

        echo $user_type_options;
        
        break;

    
    default:
        
        break;
}

?>
