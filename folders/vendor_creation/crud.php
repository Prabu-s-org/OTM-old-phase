<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "vendor_creation";


// Include DB file and Common Functions
include '../../config/dbconfig.php';

//     
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath =  $fileUploadConfig->get("upload_folder");
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    "status" => 0,
    "data" => "",
    "error" => "Action Not Performed"
];
$json_array            = "";
$sql                   = "";
$user_type             = "";
$is_active             = "";
$unique_id             = "";
$prefix                = "";
$data                  = "";
$msg                   = "";
$error                 = "";
$status                = "";
$test                  = "";

 // For Developer Testing Purpose
switch ($action) {
    case 'createupdate':


        $company_name               = $_POST["company_name"];
        $name                       = $_POST["name"];
        $contact_no                 = $_POST["contact_no"];
        $mail_id                    = $_POST["mail_id"];
        $pan_no                     = $_POST["pan_no"];
        $gst_no                     = $_POST["gst_no"];
        $alt_contact_no             = $_POST["alt_contact_no"];
        $address                    = $_POST["address"];
        $account_no                 = $_POST["account_no"];
        $ifsc_code                  = $_POST["ifsc_code"];
        $bank_name                  = $_POST["bank_name"];
        $branch_name                = $_POST["branch_name"];
        $vendor_user_type_unique_id = $_POST["vendor_user_type_unique_id"];
        $vendor_id                  = $_POST["vendor_id"];
        $district_name              = $_POST["district_name"];
        $zone_name                  = $_POST["zone_name"];
        $state_name                 = $_POST["state_name"];
        $pincode                    = $_POST["pincode"];
        $user_name                  = $_POST["user_name"];
        $password                   = $_POST["password"];
        $confirm_password           = $_POST["confirm_password"];
        $unique_id                  = $_POST["unique_id"];
        $acc_holder_name            = $_POST["acc_holder_name"];

        $my_no                     = $_POST["my_no"];

        $file_names_pan = $_POST['pan_old'];  // default old
$file_org_names_pan = '';            

$file_names_bank = $_POST['bank_old']; // default old
$file_org_names_bank = '';   



        $allowedExts  = ['pdf'];

 if (isset($_FILES['pan_file']) && $_FILES['pan_file']['error'] == 0) {

    $extension = pathinfo($_FILES['pan_file']['name'], PATHINFO_EXTENSION);

    if (strtolower($extension) == 'pdf') {
        $upload_dir = '../../uploads/vendor_creation/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $tem_name = $my_no . "-PAN.pdf";
        move_uploaded_file($_FILES['pan_file']['tmp_name'], $upload_dir . $tem_name);

        $file_names_pan = $tem_name;                // new file
        $file_org_names_pan = $_FILES['pan_file']['name'];
    }
}

if (isset($_FILES['bank_file']) && $_FILES['bank_file']['error'] == 0) {

    $extension = pathinfo($_FILES['bank_file']['name'], PATHINFO_EXTENSION);

    if (strtolower($extension) == 'pdf') {
        $upload_dir = '../../uploads/vendor_creation/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $tem_name = $my_no . "-BANK.pdf";
        move_uploaded_file($_FILES['bank_file']['tmp_name'], $upload_dir . $tem_name);

        $file_names_bank = $tem_name;
        $file_org_names_bank = $_FILES['bank_file']['name'];
    }
}




        $table = "vendor_creation";  // Define the table name

        $update_where = "";
        $columns = [
            "company_name"                  => $company_name,
            "name"                          => $name,
            "contact_no"                    => $contact_no,
            "mail_id"                       => $mail_id,
            "pan_no"                        => $pan_no,
            "gst_no"                        => $gst_no,
            "alt_contact_no"                => $alt_contact_no,
            "address"                       => $address,
            "account_no"                    => $account_no,
            "ifsc_code"                     => $ifsc_code,
            "bank_name"                     => $bank_name,
            "vendor_user_type_unique_id"    => $vendor_user_type_unique_id,
            "vendor_id"                     => $vendor_id,
            "branch_name"                   => $branch_name,
            "district_name"                 => $district_name,
            "zone_name"                     => $zone_name,
            "state_name"                    => $state_name,
            "pincode"                       => $pincode,
            "user_name"                     => $user_name,
            "password"                      => $password,
            "confirm_password"              => $confirm_password,
            'pan_attach_file_name' => $file_names_pan,
            'pan_attach_file_org_name' => $file_org_names_pan,
            'bank_proof' => $file_names_bank,
           'bank_proof_org_name' => $file_org_names_bank,
           'acc_holder_name' => $acc_holder_name
        ];

        // Update Existing Record
        if ($unique_id) {
            $update_where = ["unique_id" => $unique_id];
            $action_obj = $pdo->update($table, $columns, $update_where);

            // print_r($columns);die();
        } else {
            // Generate Vendor ID only for new entries

            $columns["unique_id"] = unique_id($prefix);

            // Insert New Record
            $action_obj = $pdo->insert($table, $columns);
        }

        if ($action_obj->status) {
            $status   = $action_obj->status;
            $data     = $action_obj->data;
            $error    = "";
            $sql      = $action_obj->sql;
            $msg      = $unique_id ? "update" : "create";
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
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start      = $_POST['start'];
        $draw       = $_POST['draw'];
        $limit      = ($length == '-1') ? "" : $length;
        $data       = [];

        if ($length == '-1') {
            $limit = "";
        }

        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];

        // Define the columns for the query
        $columns = [
            "'' as s_no",
            "vendor_user_type_unique_id",
            "vendor_id",
            "company_name",
            "name",
            "contact_no",
            "alt_contact_no",
            "pan_no",
            "mail_id",
            "gst_no",
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = " . $table . ".state_name group by state_name) AS state_name",
            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = " . $table . ".district_name  group by district_name) AS district_name",
            "zone_name",
            "pincode",
            "user_name",
            "password",
            "bank_name",
            "branch_name",
            "account_no",
            "ifsc_code",
            "address",
            "unique_id",
            // "user_name",
            // "password",
            // "confirm_password",
        ];

        // Datatable Query
        $limit  = $_POST['length'] == '-1' ? "" : $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'];

        $where = "is_delete = '0'";
        if ($search) {
            $where .= " AND (company_name LIKE '%$search%' OR name LIKE '%$search%' OR contact_no LIKE '%$search%')";
        }

        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];

        // Datatable Sorting Logic
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Fetching data
        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select([$table, $columns], $where, $limit, $start, $order_by, $sql_function);
        // Get total records
        $total_records = total_records();

        // Prepare the data for the DataTable
        $data = [];
        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;  // Initialize serial number

            foreach ($res_array as &$value) {
                $value['s_no'] = $sno++;  // Dynamically add the serial number

                // You can also apply any transformation here, like formatting the state and district names
                $value['state_name'] = disname($value['state_name']);
                $value['district_name'] = disname($value['district_name']);

                if ($value['vendor_user_type_unique_id'] == '67e7997ad327489044') {

                    $value['vendor_user_type_unique_id'] = 'Vendor Team';
                }

                // Adding action buttons based on permissions
                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);
                $value['unique_id'] = $btn_update . " " . $btn_delete;  // Assign buttons to unique_id

                // Add row data to the response
                $data[] = array_values($value);
            }

            $json_array = [
                "draw" => intval($_POST['draw']),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data
            ];
        } else {
            $json_array = [
                "draw" => intval($_POST['draw']),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }

        // Output the JSON response
        echo json_encode($json_array);
        break;

    case 'datatable_10':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start      = $_POST['start'];
        $draw       = $_POST['draw'];
        $limit      = ($length == '-1') ? "" : $length;
        $data       = [];
        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $columns = [
            "'' as s_no",  // Generate serial number
            "company_name",
            "name",
            "contact_no",
            "alt_contact_no",
            "pan_no",
            "mail_id",
            "gst_no",
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = " . $table . ".state_name ) AS state_name",
            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = " . $table . ".district_name ) AS district_name",
            "zone_name",
            "pincode",
            "bank_name",
            "branch_name",
            "account_no",
            "ifsc_code",
            "address",
            "unique_id",
        ];

        $table_details = [$table, $columns];

        $where = " is_delete = '0' ";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            $where .= " AND " . $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();

        // Fetch User Permissions
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
        $table_user = "user_screen_permission";
        $columns_user = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";

        $table_details_user = [
            $table_user,
            $columns_user
        ];

        $table_users = $pdo->select($table_details_user, $select_where);
        $table_users = $table_users->data;

        $action_ids = [];

        if ($table_users->status) {
            foreach ($table_users->data as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;
            foreach ($res_array as &$value) {
                // Dynamically set serial number for each row
               
                $value['s_no'] = $sno++;
                $value['state_name'] = disname($value['state_name']);
                $value['district_name'] = disname($value['district_name']);

                // Assigning Action Buttons Based on Permissions
                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                // Conditional rendering of buttons based on user permissions
                $value['unique_id'] = $btn_update . " " . $btn_delete;  // Always show both buttons for now

                // Add the row data to the response array
                $data[] = array_values($value);
            }

            // Return the final JSON response with data
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data
            ];
        } else {
            // In case of no results, return empty data
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }

        echo json_encode($json_array);
        break;

    case 'datatable_olds1':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? "" : $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $columns = [
            "'' as s_no",  // Generate serial number
            "company_name",
            "name",
            "contact_no",
            "alt_contact_no",
            "pan_no",
            "mail_id",
            "gst_no",
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = " . $table . ".state_name ) AS state_name",
            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = " . $table . ".district_name ) AS district_name",
            "zone_name",
            "pincode",
            "bank_name",
            "branch_name",
            "account_no",
            "ifsc_code",
            "address",
            "unique_id",
        ];

        $table_details = [$table, $columns];

        $where = " is_delete = '0' ";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            $where .= " AND " . $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();

        // Fetch User Permissions
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
        $table_user = "user_screen_permission";
        $columns_user = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";

        $table_details_user = [
            $table_user,
            $columns_user
        ];

        $table_users = $pdo->select($table_details_user, $select_where);
        $table_users = $table_users->data;

        $action_ids = [];

        if ($table_users->status) {
            foreach ($table_users->data as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;
            foreach ($res_array as &$value) {
                // Dynamically set serial number for each row
                $value['s_no'] = $sno;
                $value['state_name'] = disname($value['state_name']);
                $value['district_name'] = disname($value['district_name']);

                // Assigning Action Buttons Based on Permissions
                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                // Conditional rendering of buttons based on user permissions
                $value['unique_id'] = $btn_update . " " . $btn_delete;  // Always show both buttons for now

                // Add the row data to the response array
                $data[] = array_values($value);
                $sno++;  // Increment serial number for each row
            }

            // Return the final JSON response with data
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data
            ];
        } else {
            // In case of no results, return empty data
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }

        echo json_encode($json_array);
        break;

    case 'datatable_old':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? "" : $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        // Query Variables
        $columns = [
            "'' as s_no",
            "company_name",
            "name",
            "contact_no",
            "alt_contact_no",
            "pan_no",
            "mail_id",
            "gst_no",
           
            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = " . $table . ".state_name ) AS state_name",

            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = " . $table . ".district_name ) AS district_name",

            "zone_name",
            "pincode",
            "bank_name",
            "branch_name",
            "account_no",
            "ifsc_code",
            "address",
            "unique_id",

        ];
        $table_details = [$table, $columns];

        $where = " is_delete = '0' ";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            $where .= " AND " . $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();


        // Fetch User Permissions
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];
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

        if ($table_users->status) {
            foreach ($table_users->data as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;
            foreach ($res_array as &$value) {

                $value['s_no'] = $sno;
                $value['state_name'] = disname($value['state_name']);
                $value['district_name'] = disname($value['district_name']);
                // Assigning Action Buttons Based on Permissions
                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                $value['unique_id'] = $btn_update . " " . $btn_delete;
                
                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data
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

    case 'district_type_option':

        $state_name = $_POST['state_name'];

        $district_type_options = district_option("", $state_name);

        $district_type_options = select_option($district_type_options, "Select District");

        echo $district_type_options;

        break;

        case 'vendor_id_creation':

            $state_name = $_POST['state_name'];
    
            
$state_names = state_option_short_name($state_name);
 $st_name = $state_names[0]['short_name'];




              $vendor_generate_id = vendor_generate_id($st_name);
echo $vendor_generate_id;
             
//             if (!empty($vendor_generate_id)) {
//     $latestId = $vendor_generate_id;
    
//     // Extract the last 3 digits using substr
//     // $num = (int) substr($latestId, -3); // Get last 3 characters
//     $num = (int) substr($latestId, 3);
//     $num++; // Increment the number
// } else {
//     $num = 1; // Start from 1 if no vendor exists
// }

// // Format the number with leading zeros to maintain 3-digit format
// $newId = 'VEN'.'-' .$st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

// echo $newId;

// if (!empty( $vendor_generate_id)) {
//                 $latestId =  $vendor_generate_id;
//                 $num = (int) substr($latestId, 3); // Extract numeric part
//                 $num++; // Increment the number
//             } else {
//                 $num = 1; // Start from 1 if no vendor exists
//             }
    
//             // Generate new vendor_id with leading zeros (e.g., VEN001, VEN002)
//             $newVendorId = 'VEN'.'-' .$st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    
//             echo $newVendorId; // Send response back to AJAX
// if (!empty($vendor_generate_id)) {
//     $latestId = $vendor_generate_id;

//     // Extract the numeric part after the last hyphen
//     $lastPart = substr($latestId, strrpos($latestId, '-') + 1); // gets '001'
//     $num = (int) $lastPart;
//     $num++; // Increment the number
// } else {
//     $num = 1; // Start from 1 if no vendor exists
// }

// // Generate new vendor_id with leading zeros and dynamic state code
// $newVendorId = 'VEN' . '-' . $st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

// echo $newVendorId;
// if (!empty($vendor_generate_id)) {
//     $latestId = $vendor_generate_id;

//     // Extract the numeric part after the last hyphen
//     $lastPart = substr($latestId, strrpos($latestId, '-') + 1); // gets '001'
//     $num = (int) $lastPart;
//     $num++; // Increment the number
// } else {
//     $num = 1; // Start from 1 if no vendor exists
// }

// // Generate new vendor_id with leading zeros and dynamic state code
// $newVendorId = 'VEN' . '-' . $st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

// echo $newVendorId;
// if (!empty($vendor_generate_id)) {
//     // Extract numeric part after the last hyphen
//     $lastNum = substr($vendor_generate_id, strrpos($vendor_generate_id, '-') + 1);
//     $num = (int)$lastNum + 1;
// } else {
//     $num = 1;
// }

// // Format new vendor ID
// $newVendorId = 'VEN-' . $st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

// echo $newVendorId;


            break;
    
    
            break;

        

    case 'vendoridgen':

        $max_ven_id = maxvenid();


        if (!empty($max_ven_id)) {
            $latestId = $max_ven_id;
            $num = (int) substr($latestId, 3); // Extract numeric part
            $num++; // Increment the number
        } else {
            $num = 1; // Start from 1 if no vendor exists
        }

        // Generate new vendor_id with leading zeros (e.g., VEN001, VEN002)
        $newVendorId = 'VEN' . str_pad($num, 3, '0', STR_PAD_LEFT);

        echo $newVendorId; // Send response back to AJAX
        break;


    case 'get_district_by_state':

        $state_name = $_POST['state_name'];


        $district_name_options = district_option('', $state_name);

        $district_name_options = select_option($district_name_options, "Select District");

        echo $district_name_options;

        break;

    default:
        break;
}

function generateVendorId($prefix)
{
    // Fetch the latest vendor_id from the database
    print_r('ii');
}

