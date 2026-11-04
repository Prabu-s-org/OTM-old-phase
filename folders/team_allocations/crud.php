<?php

// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = "team_allocation";
$table_inv             = "invoice_creation_main";



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
    $region              = $_POST["region"];
    $state_name          = $_POST["state_name"];
    $district_name       = $_POST["district_name"];
    $po_no               = $_POST["po_no"];
    $consignee_address   = $_POST["consignee_address"];
    $consignee_name      = $_POST["consignee_name"];
    $consignee_district  = $_POST["consignee_district"];
    $eng_name = is_array($_POST["eng_name"]) ? implode(",", $_POST["eng_name"]) : $_POST["eng_name"];
    $user_role          = $_POST["user_role"];
    $is_active          = isset($_POST["is_active"]) && $_POST["is_active"] !== '' ? (int) $_POST["is_active"] : 0; // ✅ FIXED
    $unique_id          = $_POST["unique_id"];

    $columns = [
        "region"           => $region,
        "state_name"       => $state_name,
        "district_name"    => $district_name,
        "po_no"            => $po_no,
        "consignee_address"=> $consignee_address,
        "consignee_name"   => $consignee_name,
        "consignee_district" => $consignee_district,
        "eng_name"         => $eng_name,
        "user_role"        => $user_role,
        "is_active"        => $is_active, // ✅ Now always an integer
        "unique_id"        => unique_id($prefix)
    ];

        $table_details      = [
            $table_inv,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
$select_where = 'is_delete = 0 
                 AND form_main_unique_id = "' . $po_no . '" 
                 AND material_qc = 1';

        
    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r($action_obj[0]['count']);
    // if ($result['count'] == 0) {
    // echo json_encode([
    //     "status" => 0,
    //     "msg"    => "Error: PO Number does not exist or Material QC is not approved!"
    // ]);
    // exit;
// }
    // print_r( $action_obj );
    if ( $action_obj->status ) {
        $status     = $action_obj->status;
        $data       = $action_obj->data;
        $error      = '';
        $sql        = $action_obj->sql;

    } else {
        $status     = $action_obj->status;
        $data       = $action_obj->data;
        $error      = $action_obj->error;
        $sql        = $action_obj->sql;
        $msg        = 'error';

    }
    if ( $data[ 0 ][ 'count' ] == 0) {
        // $msg        = 'already';
         echo json_encode([
        "status" => 0,
        "msg"    => "Error: PO Number does not exist or Material QC is not approved!"
    ]);
    exit;
    } 
    // else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {
    else{

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
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start      = $_POST['start'];
            $draw       = $_POST['draw'];
            $limit      = $length;
        
            $data        = [];
        
            if ($length == '-1') {
                $limit  = "";
            }
        
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as s_no", 
                 "region"  ,
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = ".$table.".state_name ) AS state_name",

           "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = ".$table.".district_name ) AS district_name",

            "(select po_num from po_form where po_form.unique_id = ".$table.".po_no ) AS po_no",
            "(select con_address from consignee_details_sub where  consignee_details_sub.unique_id = ".$table.".consignee_address) AS consignee_address" ,
            "consignee_name" ,
            "consignee_district",
            // "(select staff_name from user where user.unique_id = ".$table.".eng_name ) AS eng_name"   ,
            "(SELECT GROUP_CONCAT(staff_name SEPARATOR ', ') FROM user WHERE FIND_IN_SET(user.unique_id, ".$table.".eng_name)) AS eng_name",

            "user_role" ,
                "is_active",
                "unique_id"
            ];
            $table_details  = [
                $table,
                $columns
            ];
        
            $where = "is_delete = '0'";
        
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
        
            // Fetch data for DataTable
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records  = total_records();
        
            $screen_id_val  = $_POST['screen_id_val'];
            $user_type      = $_POST['usertype'];
        
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
        
            $table_users  = $pdo->select($table_details, $select_where);
            $table_users = $table_users->data;
        
            $action_ids = [];
            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }
        
            if ($result->status) {
                $res_array = $result->data;
                $sno = 0;  // Start the serial number
        
                foreach ($res_array as $key => $value) {
                    // Add the serial number dynamically
                    $value['s_no'] = $sno + 1; // Use $sno to increment the serial number
                    // $value['state_name'] = disname($value['state_name']);
                    $value['is_active'] = is_active_show($value['is_active']);
        
                    // Buttons for actions based on permissions
                    $btn_update = btn_update($folder_name, $value['unique_id']);
                    $btn_delete = btn_delete($folder_name, $value['unique_id']);
        
                    // Add permission-based actions to the 'unique_id' column
                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_update . $btn_delete;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    } else if (in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_delete;
                    } else {
                        $value['unique_id'] = '';
                    }
        
                    // Add row to data, make sure the 's_no' is in the first column as DataTable expects
                    $data[] = [
                        "s_no" => $value['s_no'],
                        "region" => $value['region'],
                        "state_name" => $value['state_name'],
                        "district_name" => $value['district_name'],
                        "po_no" =>$value["po_no"],
                        "consignee_address" => $value["consignee_address"],
                        "consignee_name" => $value["consignee_name"],
                        "consignee_district" => $value["consignee_district"],
                        "eng_name" =>$value["eng_name"],
                        "user_role" => $value["user_role"],
                        "is_active" => $value['is_active'],
                        "unique_id" => $value['unique_id']
                    ];
        
                    $sno++;  // Increment serial number
                }
        
                // Prepare the JSON response
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => intval($total_records),
                    "recordsFiltered" => intval($total_records),
                    "data" => $data
                ];
            } else {
                // Error handling (optional)
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
         case 'district_type_option':

        $state_name          = $_POST['state_name'];

        $district_type_options  = district_option("",$state_name);

        $district_type_options  = select_option($district_type_options,"Select District");

        echo $district_type_options;
        
        break;
        
        
  case 'consignee_name_option':
    if (isset($_POST['consignee_address']) && !empty(trim($_POST['consignee_address']))) {
        $con_unique_id = trim($_POST['consignee_address']);  
        // Database connection
        $conn = new mysqli("localhost", "root", "", "operation_team_beta");

        if ($conn->connect_error) {
            echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
            exit;
        }

        // Use prepared statement
        $sql = "SELECT con_contact_name FROM consignee_details_sub 
                WHERE unique_id = ? 
                AND is_active = 1 
                AND is_delete = 0 
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $con_unique_id); // Bind parameter as string
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                echo json_encode(["success" => true, "consignee_name" => $row['con_contact_name']]);
            } else {
                echo json_encode(["success" => false, "message" => "No consignee found"]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid consignee address"]);
    }
    break;
case 'consignee_district_option':
    if (isset($_POST['consignee_address']) && !empty(trim($_POST['consignee_address']))) {
        $con_unique_id = trim($_POST['consignee_address']);  

        // Database connection
        $conn = new mysqli("localhost", "root", "", "operation_team_beta");

        if ($conn->connect_error) {
            echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
            exit;
        }

        // Use prepared statement with JOIN to get district name
        $sql = "SELECT d.district_name 
                FROM consignee_details_sub c 
                JOIN district_creation d ON c.con_district = d.unique_id 
                WHERE c.unique_id = ? 
                AND c.is_active = 1 
                AND c.is_delete = 0 
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $con_unique_id); // Bind parameter as string
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                echo json_encode(["success" => true, "consignee_district" => $row['district_name']]);
            } else {
                echo json_encode(["success" => false, "message" => "No district found"]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid consignee address"]);
    }
    break;


case 'engineer_role_option':
    if (isset($_POST['eng_name']) && !empty($_POST['eng_name'])) {
        $eng_name_list = json_decode($_POST['eng_name'], true); // Decode JSON array

        if (!is_array($eng_name_list) || count($eng_name_list) == 0) {
            echo json_encode(["success" => false, "message" => "Invalid engineer names"]);
            exit;
        }

        // Convert array to comma-separated string for storage
        $eng_name_string = implode(", ", $eng_name_list);
        // print_r($eng_name_string);

        // Database connection
        $conn = new mysqli("localhost", "root", "", "operation_team_beta");

        if ($conn->connect_error) {
            echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
            exit;
        }

        // Prepare SQL query using IN clause for multiple selections
        $placeholders = implode(',', array_fill(0, count($eng_name_list), '?'));
        $sql = "SELECT u.unique_id, ut.user_type 
                FROM user u 
                JOIN user_type ut ON u.user_type_unique_id = ut.unique_id 
                WHERE u.unique_id IN ($placeholders) 
                AND u.is_active = 1 
                AND u.is_delete = 0";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(str_repeat("s", count($eng_name_list)), ...$eng_name_list);
            $stmt->execute();
            $result = $stmt->get_result();

            $user_roles = [];
            while ($row = $result->fetch_assoc()) {
                $user_roles[] = $row['user_type'];
            }

            if (!empty($user_roles)) {
                echo json_encode(["success" => true, "user_roles" => implode(", ", $user_roles)]);
            } else {
                echo json_encode(["success" => false, "message" => "No matching records found."]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid engineer name"]);
    }
    break;



// case 'engineer_role_option':
//     if (isset($_POST['eng_name']) && !empty(trim($_POST['eng_name']))) {
//         $eng_name = trim($_POST['eng_name']);

//         // Database connection
//         $conn = new mysqli("localhost", "root", "", "operation_team_beta");

//         if ($conn->connect_error) {
//             echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
//             exit;
//         }

//         // Use prepared statements to prevent SQL injection
//         $sql = "SELECT u.user_type_unique_id, ut.user_type 
//                 FROM user u 
//                 JOIN user_type ut ON u.user_type_unique_id = ut.unique_id 
//                 WHERE u.unique_id = ? 
//                 AND u.is_active = 1 
//                 AND u.is_delete = 0";

//         $stmt = $conn->prepare($sql);

//         if ($stmt) {
//             $stmt->bind_param("s", $eng_name); // Bind parameter as string
//             $stmt->execute();
//             $result = $stmt->get_result();

//             if ($row = $result->fetch_assoc()) {
//                 echo json_encode(["success" => true, "user_role" => $row['user_type']]);
//             } else {
//                 echo json_encode(["success" => false, "message" => "No matching records found."]);
//             }

//             $stmt->close();
//         } else {
//             echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
//         }

//         $conn->close();
//     } else {
//         echo json_encode(["success" => false, "message" => "Invalid engineer name"]);
//     }
//     break;






        
    // case 'datatable':
    //     // DataTable Variables
    //     $search     = $_POST['search']['value'];
    //     $length     = $_POST['length'];
    //     $start         = $_POST['start'];
    //     $draw         = $_POST['draw'];
    //     $limit         = $length;

    //     $data        = [];


    //     if ($length == '-1') {
    //         $limit  = "";
    //     }

    //     // Query Variables
    //     $json_array     = "";
    //     $columns        = [
    //         "'' as  s_no",
    //         "state_name",
    //         "is_active",
    //         "unique_id"
    //     ];
    //     $table_details  = [
    //         $table,
    //         $columns
    //     ];
    //     // $where          = [
    //     //     "is_delete"     => 0
    //     // ];
    //     // $order_by       = "";

    //     $where = " is_delete = '0' ";

    //     $order_column   = $_POST["order"][0]["column"];
    //     $order_dir      = $_POST["order"][0]["dir"];

    //     // Datatable Ordering 
    //     $order_by       = datatable_sorting($order_column, $order_dir, $columns);

    //     // Datatable Searching
    //     $search         = datatable_searching($search, $columns);

    //     if ($search) {
    //         if ($where) {
    //             $where .= " AND ";
    //         }

    //         $where .= $search;
    //     }

    //     $sql_function   = "SQL_CALC_FOUND_ROWS";

    //     $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
    //     $total_records  = total_records();

    //     $screen_id_val      = $_POST['screen_id_val'];
    //     $user_type  = $_POST['usertype'];
        
    // $table_user ="user_screen_permission";
    //     $columns        = [
    //         // "screen_unique_id",
    //         "action_unique_id",
    //         "user_type"
    //     ];
    //     $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
    //     // print_R($select_where);die();
    //     $table_details   = [
    //         $table_user,
    //         $columns
    //     ];

    //     $table_users  = $pdo->select($table_details, $select_where);

    //         $table_users      = $table_users->data;


    //     $action_ids = [];
    //     foreach ($table_users as $item) {
    //         if (isset($item['action_unique_id'])) {
    //             $action_ids[] = $item['action_unique_id'];
    //         }
    //     }

    //     if ($result->status) {

    //         $res_array      = $result->data;

    //         foreach ($res_array as $key => $value) {
    //             $value['s_no'] = $sno + 1;
    //             $value['state_name'] = disname($value['state_name']);
    //             $value['is_active'] = is_active_show($value['is_active']);

    //             $btn_update         = btn_update($folder_name, $value['unique_id']);
    //             $btn_delete         = btn_delete($folder_name, $value['unique_id']);
    //             // $value['unique_id'] = $btn_update . $btn_delete;

    //             // if ($value['is_active'] == "1") {
    //             //     $value['is_active']   = "Active";
    //             // } else {

    //             //     $value['is_active']   = "Inactive";
    //             // }

    //             // $value['unique_id'] = $btn_update . $btn_delete;
    //             if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
    //                 $value['unique_id'] = $btn_update.$btn_delete;                   
    //             }
    //             else if(in_array('5f88082b25ec031952', $action_ids)){
    //                 $value['unique_id'] = $btn_update;
    //             }else if(in_array('5f8808504271036738', $action_ids)){
    //                 $value['unique_id'] = $btn_delete;
    //             }else{
    //                 $value['unique_id'] = '';
    //             }
    //             $data[]             = array_values($value);
    //             $sno++;
    //         }

    //         $json_array = [
    //             "draw"                => intval($draw),
    //             "recordsTotal"         => intval($total_records),
    //             "recordsFiltered"     => intval($total_records),
    //             "data"                 => $data,
    //             "testing"            => $result->sql
    //         ];
    //     } else {
    //         print_r($result);
    //     }

    //     echo json_encode($json_array);
    //     break;

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
    
    // Now $action_unique_ids contains all the action_unique_id values
    // print_r($action_unique_ids);die();
               
            
    
            // $data = array($table_users);
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

        //  case 'user_type_options':

        // $user_type          = $_POST['user_type'];

        // $user_type_options  = under_user_type($user_type);

        // $user_type_options  = select_option($user_type_options,"Select");

        // echo $user_type_options;

        // break;


    default:

        break;
}

