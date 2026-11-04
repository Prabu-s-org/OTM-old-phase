<?php
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table             = "item_creation";
$table_sub             = "item_creation_sub";


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
        $tender_name          = $_POST["tender_name"];
        $tender_code          = $_POST["tender_code_1"];
        $tender_no            = $_POST["tender_no"];
        $tender_type          = $_POST["tender_type"];
        $validity_from        = $_POST["validity_from"];
        $validity_to          = $_POST["validity_to"];
        $validity_date        = $_POST["validity_date"];
        $unique_id            = $_POST["unique_id"];
        $update_where         = "";

        
        $columns              = [
        "tender_name"           => $tender_name,
        "tender_code"           => $tender_code,
        "tender_no"             => $tender_no,
        "tender_type"           => $tender_type,
        "validity_from"         => $validity_from,
        "validity_to"           => $validity_to,
        "validity_date_extension"=> $validity_date,
        "unique_id"             => unique_id($prefix)
        ];

        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where   = [
                "unique_id"     => $unique_id
            ];
            $action_obj     = $pdo->update($table, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table, $columns);
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
            $search     = $_POST['search']['value'];  // Search term
            $length     = $_POST['length'];           // Page length
            $start      = $_POST['start'];            // Starting point for pagination
            $draw       = $_POST['draw'];             // Draw counter (used by DataTables)
            $limit      = $length;
            $data       = [];
            $sno        = $start + 1; // Start serial number from $start + 1
        
            if ($length == '-1') {
                $limit = "";  // Remove limit if length is '-1'
            }
        
            // Query Variables
            $json_array = "";
            $columns = [
                "'' as s_no",
                "tender_name",
                "tender_code",
                "tender_no",
                "tender_type",
                "validity_from",
                "validity_to",
                "validity_date_extension",
                "unique_id"
            ];
            
            $table_details = [
                $table,
                $columns
            ];
        
            $where = "is_delete = '0'";  // Only show non-deleted records
            $order_column = $_POST["order"][0]["column"];  // Get the column index to order by
            $order_dir = $_POST["order"][0]["dir"];        // Ascending or descending order
        
            // Datatable Ordering 
            $order_by = datatable_sorting($order_column, $order_dir, $columns);
        
            // Datatable Searching
            $search_condition = datatable_searching($search, $columns);
            if ($search_condition) {
                if ($where) {
                    $where .= " AND ";
                }
                $where .= $search_condition;
            }
        
            // Run SQL query to fetch data
            $sql_function = "SQL_CALC_FOUND_ROWS";
            $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records = total_records();  // Get total records without pagination
        
            // Fetch user permissions
            $screen_id_val = $_POST['screen_id_val'];
            $user_type = $_POST['user_type_unique_id'];
            $table_user = "user_screen_permission";
            $columns_user = [
                "action_unique_id",
                "user_type"
            ];
            $select_where = "screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
            $table_details_user = [$table_user, $columns_user];
            $table_users = $pdo->select($table_details_user, $select_where);
            $table_users = $table_users->data;
        
            // Extract action ids
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
                    $value['tender_name'] = disname($value['tender_name']);
                    $value['tender_code'] = disname($value['tender_code']);
                    $value['tender_no'] = disname($value['tender_no']);
                    if ($value['tender_type'] == 1) {
                        $value['tender_type'] = "Open Tender";
                    }
                    if ($value['tender_type'] == 2) {
                        $value['tender_type'] = "Limited Tender";
                    }
        
                    // Generate action buttons based on permissions
                    $btn_update = btn_update($folder_name, $value['unique_id']);
                    $btn_delete = btn_delete($folder_name, $value['unique_id']);
                    
                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_update . $btn_delete;  // Show both buttons
                    } elseif (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;  // Show only update button
                    } elseif (in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_delete;  // Show only delete button
                    } else {
                        $value['unique_id'] = '';  // Show no buttons
                    }
        
                    // Add the row data to the final array
                    $data[] = array_values($value);
                    $sno++;
                }
        
                // Prepare JSON response
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => intval($total_records),
                    "recordsFiltered" => intval($total_records),
                    "data" => $data,
                    "testing" => $result->sql // Optional, for debugging the SQL query
                ];
            } else {
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
            }
        
            // Return the response as JSON
            echo json_encode($json_array);
            break;
        
    case 'datatable_old':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start         = $_POST['start'];
        $draw         = $_POST['draw'];
        $limit         = $length;
        $data        = [];
        $sno = $start + 1;
        if ($length == '-1') {
            $limit  = "";
        }
        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "tender_name",
            "tender_code",
            "tender_no",
            "tender_type",
            "unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];
      
        $where = " is_delete = '0' ";
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
        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns        = [
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
                $value['s_no'] = $sno;
                $value['tender_name'] = disname($value['tender_name']);
                $value['tender_code'] = disname($value['tender_code']);
                $value['tender_no'] = disname($value['tender_no']);
                if($value['tender_type']==1  ){
                    $value['tender_type'] ="Open Tender";
                }
                if($value['tender_type']==2){
                    $value['tender_type'] ="Limited Tender";
                }
             
                $btn_update         = btn_update($folder_name, $value['unique_id']);
                $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update.$btn_delete;                   
                }
                else if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }else if(in_array('5f8808504271036738', $action_ids)){
                    $value['unique_id'] = $btn_delete;
                }else{
                    $value['unique_id'] = '';
                }
            
            
                $data[]             = array_values($value);
                $sno ++;
            }
            $json_array = [
                "draw"                => intval($draw),
                "recordsTotal"         => intval($total_records),
                "recordsFiltered"     => intval($total_records),
                "data"                 => $data,
                "testing"            => $result->sql
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
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id   = $_POST['user_type_unique_id'];
            
        $table_user ="user_screen_permission";
            $columns        = [
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            $table_details   = [
                $table_user,
                $columns
            ];
    
            $table_users  = $pdo->select($table_details, $select_where);
    
            if ($table_users->status) {
    
                $table_users      = $table_users->data;
    $action_unique_ids = [];

    foreach ($table_users as $item) {
        if (isset($item['action_unique_id'])) {
            $action_unique_ids[] = $item['action_unique_id'];
        }
    }
    
    // Now $action_unique_ids contains all the action_unique_id values
   
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


        case 'excel_datatable':
            // DataTable Variables
            $search = $_POST['search']['value'];
            $length = $_POST['length'];
            $start = $_POST['start'];
            $draw = $_POST['draw'];
            $limit = $length;
            $data = [];
            $tender_code= $_POST['tender_code'];
            if ($length == '-1') {
                $limit = "";
            }
            // Query Variables
            $json_array = "";
            $columns = [
                "'' as s_no",
              "item_code",
              "item_description",
              "item_specification",
              "brand",
              "product_category",
              "short_category",
              "rc_unit_price",
              "gst",
              "rc_net_price",       
              "warranty_in_yrs",
              "unique_id",
           
              
                
            ];
            $table_details = [
                'item_creation_sub',
                $columns
            ];
            
            $where = " tender_code = '".$tender_code."' and is_delete=0";
            $order_column = $_POST["order"][0]["column"];
            $order_dir = $_POST["order"][0]["dir"];
          
            $sql_function = "SQL_CALC_FOUND_ROWS";
            $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records = total_records();
            if ($result->status) {
                $s_no=1;
                $res_array = $result->data;
                foreach ($res_array as $key => $value) {
                   $value['s_no']=$s_no++;

                    $value['unique_id'] = '<a href="index.php?file=item_creation/form1&unique_id=' . $value['unique_id'] . '">
                    <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
                    
                    
                    if($value['rc_unit_price'] == ''){
                        $value['rc_unit_price'] = '-';
                    }
                    if($value['rc_net_price'] == ''){
                        $value['rc_net_price'] = '-';
                    }
                    
                    $data[] = array_values($value);
                    
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

            case 'items':

                $item_code        = $_POST["item_code"];
                $item_description         = $_POST["item_description"];
                $item_specification        = $_POST["item_specification"];
                $product_category         = $_POST["product_category"];
                $brand = $_POST["brand"];

                $short_category       = $_POST["short_category"];
                $rc_unit_price     = $_POST["rc_unit_price"];
                $rc_net_price     = $_POST["rc_net_price"];
                $gst   = $_POST["gst"];
                $warranty_in_yrs    = $_POST["warranty_in_yrs"];
                $unique_id          = $_POST["unique_id"];
                $update_where       = "";
                $columns            = [
                    "item_code"           => $item_code,
                    "item_description"           => $item_description,
                    "item_specification"           => $item_specification,
                    "brand"    => $brand,
                    "product_category"           => $product_category,
                    "short_category"        => $short_category,
                    "rc_unit_price"          => $rc_unit_price,
                    "rc_net_price"          => $rc_net_price,
                    "gst"        => $gst,
                    "warranty_in_yrs"     => $warranty_in_yrs,
                   
                ];

              
                $update_where ='unique_id="'.$unique_id.'"';
                $action_obj     = $pdo->update($table_sub, $columns, $update_where);
                
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


                case 'delete':
        $unique_id      = $_POST['unique_id'];
        $columns        = [
            "is_delete"   => 1
        ];
        $update_where   = [
            "unique_id"     => $unique_id
        ];
        $action_obj     = $pdo->update($table, $columns, $update_where);
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
       
    default:
        break;

  case 'get_item':
//    echo "hi";die();
$tender_code =$_POST["tender_code"];
          $item_code        = $_POST["item_code"];
                $item_description         = $_POST["item_description"];
                $item_specification        = $_POST["item_specification"];
                $product_category         = $_POST["product_category"];
                $brand = $_POST["brand"];

                $short_category       = $_POST["short_category"];
                $rc_unit_price     = $_POST["rc_unit_price"];
                $gst   = $_POST["gst"];
                $warranty_in_yrs    = $_POST["warranty_in_yrs"];
                // $is_active          = $_POST["is_active"];
                $unique_id          = $_POST["unique_id"];
        $update_where       = "";
        $columns            = [
            "tender_code"  => $tender_code,
            "item_code"           => $item_code,
                    "item_description"           => $item_description,
                    "item_specification"           => $item_specification,
                    "brand"    => $brand,
                    "product_category"           => $product_category,
                    "short_category"        => $short_category,
                    "rc_unit_price"          => $rc_unit_price,
                    "gst"        => $gst,
                    "warranty_in_yrs"     => $warranty_in_yrs,
            "unique_id"           => unique_id($prefix)
        ];
        // Update Begins
        // if ($unique_id) {
        //     unset($columns['unique_id']);
        //     $update_where   = [
        //         "unique_id"     => $unique_id
        //     ];
        //     $action_obj     = $pdo->update($table_sub, $columns, $update_where);
        //     // Update Ends
        // } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table_sub, $columns);
            // print_r( $action_obj);die();
            // Insert Ends
        // }
        // print_r($action_obj);
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
    
    }
