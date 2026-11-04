<?php
require_once __DIR__ . '/../../config/env.php';
require_once dirname(__DIR__, 2) . '/config/env.php';

//$logo_img       = "img/logo-light.png";
//$logo_img_dark  = "img/logo-light.png";

$logo_img       = "img/logo-new.png";
$logo_img_dark  = "img/logo-new.png";
$logo_img_sm    = "";
$logo_img_print = "";

// Default Admin User Type


function get_client_ip() {
    $ipaddress = '';
   if (getenv('HTTP_CLIENT_IP'))
       $ipaddress = getenv('HTTP_CLIENT_IP');
   else if(getenv('HTTP_X_FORWARDED_FOR'))
       $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
   else if(getenv('HTTP_X_FORWARDED'))
       $ipaddress = getenv('HTTP_X_FORWARDED');
   else if(getenv('HTTP_FORWARDED_FOR'))
       $ipaddress = getenv('HTTP_FORWARDED_FOR');
   else if(getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
   else if(getenv('REMOTE_ADDR'))
       $ipaddress = getenv('REMOTE_ADDR');
   else
       $ipaddress = 'UNKNOWN';
   return $ipaddress;
}

$admin_user_type = "5f97fc3257f2525529";
$hr_user_type    = "5ff71f5fb5ca556748";


$password = project_env('SERVICE_ENCRYPTION_PASSWORD');
$enc_method = 'aes-256-cbc';
$enc_password = substr(hash('sha256', $password, true), 0, 32);
$enc_iv = project_env('SERVICE_ENCRYPTION_IV');

// Date Related Function
function today($format = "") {
    if ($format) {
        return date($format);
    }

    return date("Y-m-d");
}


function today_time($format = "") {
    if ($format) {
        return date($format);
    }

    return date("Y-m-d H:i:s");
}

function disdate ($date) {

    $result     = "";

    if ($date) {
        $result =  implode("-",array_reverse(explode("-",$date)));
    }

    return $result;
}

$today            = today();
$today_time       = today_time();

// Bill No Generation

function bill_no ($table_name,$where,$prefix = "", $y = 1,$m = 1, $d = 1,$custom_date = false,$separator = "") {
    $billno = $prefix;

    if (!$custom_date) {
        $custom_date = date("Y-m-d");
    }

    if ($y) {
        $billno .= date('Y',strtotime($custom_date)).$separator;
    }

    if ($m) {
        $billno .= date('m',strtotime($custom_date)).$separator;
    }

    if ($d) {
        $billno .= date('d',strtotime($custom_date)).$separator;
    }

    $bill_order_no  =  save_status($table_name,$where);

    $billno        .= sprintf("%04d",$bill_order_no);

    return $billno;
}


// Get Final Bill No

function save_status ($table_name,$where) {
    if ($table_name) {
        global $pdo;

        $columns    = [
            "count(acc_year) AS save_status"
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $result         = $pdo->select($table_details,$where);

        if ($result->status) {

        $res_array      = $result->data[0]['save_status'] + 1;

        } else {
            print_r($result);
            $res_array = uniqid().rand(10000,99999)."Error";
        }

        return $res_array;
    }
}

// Permissions Extract From user_screen_action Table 

$perm_columns       = [
    'variable_name',
    'is_active',
    'unique_id'
];
$perm_table         = 'user_screen_actions';
$perm_table_details = [
    $perm_table,
    $perm_columns
];
$perm_where         = '';      
$result_obj         = $pdo->select($perm_table_details,$perm_where);

if ($result_obj->status) {
    $status     = $result_obj->status;
    $data       = $result_obj->data;
    $error      = "";
    $sql        = $result_obj->sql;

    $perm_array = [];

    foreach ($data as $data_key => $data_value) {

        if (!$data_value['is_active']) {
            $data_value['unique_id'] = 0;
        }

        $perm_array[$data_value['variable_name']] = $data_value['unique_id'];
    }

    // Extract Permission Variables From $perm_array
    extract($perm_array);

    // Permissions Extract Ends Here

} else {
    $status     = $result_obj->status;
    $data       = $result_obj->data;
    $error      = $result_obj->error;
    $sql        = $result_obj->sql;
    $msg        = "error";
    exit;
}

// Uniqui ID Geneartor
function unique_id($prefix = "") {

    $unique_id = uniqid().rand(10000,99999);

    if($prefix) {
        $unique_id = $prefix.$unique_id;
    }

    return $unique_id;
}

function user_permission ($permission_id = "", $folder_name = "") {

    if (($permission_id) && ($folder_name)) {

    }

    echo "";
    echo '<div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="form-group">
                <h1>You Don\'t Have a Permission to Access This Page</h1>
                </div>
            </div>  
        </div>';
    exit;
    // return false;
}
function menu_permission($user_type_id = "") {
    $return_arr = [
        "main_screens" => "",
        "sections" => "",
        "screens" => "",
        "actions" => ""
    ];

    if ($user_type_id) {
        global $pdo;

        $table_user_permission = "user_screen_permission";
        $select_where = [
            "user_type" => $user_type_id,
        ];

        // Get screen permissions
        $screen_columns = [
            "GROUP_CONCAT(DISTINCT screen_unique_id) AS screens",
            // "GROUP_CONCAT(DISTINCT action_unique_id) AS actions",
            // "action_unique_id AS actions",
        ];
        $screen_result = $pdo->select([$table_user_permission, $screen_columns], $select_where, "", "", "", "", "screen_unique_id");

        if ($screen_result->status) {
            $screen_result_data = $screen_result->data;
            $return_arr["screens"] = array_implode($screen_result_data);
            // $return_arr["actions"] = array_implode($screen_result_data);
        } 
        else {
            echo "Menu Permission Error: ";
            print_r($screen_result);
            exit;
        }

         // Get actions permissions
         $action_columns = [
            
            "GROUP_CONCAT(DISTINCT action_unique_id) AS actions"
            
        ];
        $action_result = $pdo->select([$table_user_permission, $action_columns], $select_where, "", "", "", "", "action_unique_id");

        if ($action_result->status) {
            $action_result_data = $action_result->data;
            $return_arr["actions"] = array_implode($action_result_data);
            // $return_arr["actions"] = $action_result_data;
            // $return_arr["actions"] = array_implode($screen_result_data);
        } 
        else {
            echo "Menu Permission Error: ";
            print_r($action_result);
            exit;
        }

     //Get screen permissions along with their actions
        $screen_action_columns = [
            "screen_unique_id",
            "GROUP_CONCAT(DISTINCT action_unique_id) AS actions"
        ];
        $screen_action_result = $pdo->select([$table_user_permission, $screen_action_columns], $select_where, "", "screen_unique_id", "", "", "screen_unique_id");

        if ($screen_action_result->status) {
            $screen_action_result_data = $screen_action_result->data;

            // Process each screen and its actions
            foreach ($screen_action_result_data as $row) {
                $screen_id = $row['screen_unique_id'];
                $actions = explode(',', $row['actions']);

                $return_arr["screens"][$screen_id] = $actions;
            }
        } else {
            echo "Screen and Action Permission Error: ";
            print_r($screen_action_result);
            exit;
        }

        // Get section permissions
        $section_columns = [
            "GROUP_CONCAT(DISTINCT section_unique_id) AS sections"
        ];
        $section_result = $pdo->select([$table_user_permission, $section_columns], $select_where, "", "", "", "", "section_unique_id");

        if ($section_result->status) {
            $section_result_data = $section_result->data;
            $return_arr["sections"] = array_implode($section_result_data);
        } else {
            echo "Section Permission Error: ";
            print_r($section_result);
            exit;
        }

        // Get main screen permissions
        $main_screen_columns = [
            "GROUP_CONCAT(DISTINCT main_screen_unique_id) AS main_screens"
        ];
        $main_screen_result = $pdo->select([$table_user_permission, $main_screen_columns], $select_where, "", "", "", "", "main_screen_unique_id");

        if ($main_screen_result->status) {
            $main_screen_result_data = $main_screen_result->data;
            $return_arr["main_screens"] = array_implode($main_screen_result_data);
        } else {
            echo "Main Screen Permission Error: ";
            print_r($main_screen_result);
            exit;
        }
    }

    return $return_arr;
}

// function menu_permission($user_type_id = "") {
//     $return_arr = [
//         "main_screens" => "",
//         "sections" => "",
//         "screens" => [],
//     ];

//     if ($user_type_id) {
//         global $pdo;

//         $table_user_permission = "user_screen_permission";
//         $select_where = [
//             "user_type" => $user_type_id,
//         ];

//         // Get screen permissions along with their actions
//         $screen_action_columns = [
//             "screen_unique_id",
//             "GROUP_CONCAT(DISTINCT action_unique_id) AS actions"
//         ];
//         $screen_action_result = $pdo->select([$table_user_permission, $screen_action_columns], $select_where, "", "screen_unique_id", "", "", "screen_unique_id");

//         if ($screen_action_result->status) {
//             $screen_action_result_data = $screen_action_result->data;

//             // Process each screen and its actions
//             foreach ($screen_action_result_data as $row) {
//                 $screen_id = $row['screen_unique_id'];
//                 $actions = explode(',', $row['actions']);

//                 $return_arr["screens"][$screen_id] = $actions;
//             }
//         } else {
//             echo "Screen and Action Permission Error: ";
//             print_r($screen_action_result);
//             exit;
//         }

//         // Get section permissions
//         $section_columns = [
//             "GROUP_CONCAT(DISTINCT section_unique_id) AS sections"
//         ];
//         $section_result = $pdo->select([$table_user_permission, $section_columns], $select_where, "", "", "", "", "section_unique_id");

//         if ($section_result->status) {
//             $section_result_data = $section_result->data;
//             $return_arr["sections"] = array_implode($section_result_data);
//         } else {
//             echo "Section Permission Error: ";
//             print_r($section_result);
//             exit;
//         }

//         // Get main screen permissions
//         $main_screen_columns = [
//             "GROUP_CONCAT(DISTINCT main_screen_unique_id) AS main_screens"
//         ];
//         $main_screen_result = $pdo->select([$table_user_permission, $main_screen_columns], $select_where, "", "", "", "", "main_screen_unique_id");

//         if ($main_screen_result->status) {
//             $main_screen_result_data = $main_screen_result->data;
//             $return_arr["main_screens"] = array_implode($main_screen_result_data);
//         } else {
//             echo "Main Screen Permission Error: ";
//             print_r($main_screen_result);
//             exit;
//         }
//     }

//     return $return_arr;
// }




function array_implode ($value_arr = "") {

    $return_arr = [];

    if (is_array($value_arr)) {

        foreach ($value_arr as $arr_key => $arr_value) {

            $return_arr[] = array_values($arr_value)[0];
            
        }

    }

    return $return_arr;
}

function folder_permission ($folder_name = "") {

}

function acc_year() {
    $acc_year   = '';
    $curr_year  = date("Y");
    
    $today      = strtotime(date("d-m-Y")); 
    $end_date   = strtotime("31-03-".$curr_year);
    $start_date = strtotime("01-04-".$curr_year);
    
    if ($today>=$start_date) {
        $next_year      = $curr_year + 1;
        $acc_year       = $curr_year."-".$next_year;
    }   
    else if ($today<=$end_date) {
        $previous_year  = $curr_year - 1;
        $acc_year       = $previous_year."-".$curr_year; 
    }

    return $acc_year;
    
}

function btn_add ($add_link = "") {
    $final_str = '<a href="'.$add_link.'"><button type="button" class="btn btn-danger waves-effect waves-light flaot-btn" id="add_btn"><i class="mdi mdi-plus-circle-multiple"></i> Add New</button></a>';

    return $final_str;
}

function btn_download($folder_name = "",$unique_id = "",$bill_no = "", $file_name = "",$prefix = "",$suffix = "") {

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'&bill_no='.$bill_no.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-download-circle-outline"></i> Download</button></a>';

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'&bill_no='.$bill_no.'"><i class="mdi mdi-download-circle-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i> Download</a>';
    
    return $final_str;
}
function btn_download_inv($folder_name = "",$unique_id = "",$bill_no = "", $file_name = "",$prefix = "",$suffix = "") {

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'&bill_no='.$bill_no.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-download-circle-outline"></i> Download</button></a>';

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'&bill_no='.$bill_no.'"><i class="mdi mdi-download-circle-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i> Download</a>';
    
    return $final_str;
}
function btn_cancel ($list_link = "") {
    $final_str = '<a href="'.$list_link.'"><button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button></a>';

    return $final_str;
}
function btn_cancel_dar ($list_link = "",$date) {
    $final_str = '<a href="index.php?file=day_attendance_report/list&date='.$date.' "><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2" >Cancel</button></a>';

    return $final_str;
}

function btn_createupdate($folder_name = "", $unique_id = "",$btn_text ,$prefix = "", $suffix = "_cu", $custom_class = "") {
    $final_str = '<button type="button" class="btn btn-success waves-effect waves-light createupdate_btn  '.$custom_class.'" onclick="'.$folder_name.$suffix.'(\''.$unique_id.'\')">'.$btn_text.'</button>';

    return $final_str;
}
function btn_createupdate_dar($folder_name = "", $unique_id = "",$btn_text ,$date,$prefix = "", $suffix = "_cu", $custom_class = "") {
    $final_str = '<button type="button" class="btn btn-asgreen btn-rounded waves-effect waves-light float-right createupdate_btn  '.$custom_class.'" onclick="'.$folder_name.$suffix.'(\''.$unique_id.'\',\''.$date.'\',\'day_attendance_report\')">'.$btn_text.'</button>';

    return $final_str;
}
// update option foe super admin
function btn_update($folder_name = "",$unique_id = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green" ></i></a>';

    
    return $final_str;
}
function btn_update_2($folder_name = "",$unique_id = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/form1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}

// function btn_update_1($folder_name = "",$unique_id = "", $prefix = "",$suffix = "",$date = "",$form = "") {
//     $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
//     $enc_method = 'aes-256-cbc';
//     $enc_password = substr(hash('sha256', $password, true), 0, 32);
//     $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


//     $menu_screen            = $folder_name."/update";
//     // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

//     // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

//     $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
//     return $final_str;
// }
 

// update for users
function btn_update1($folder_name = "",$unique_id = "",$invoice_no = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update_1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    
$final_str ='<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    

    // $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}

function btn_update_1($folder_name = "",$unique_id = "",$bill_no = "",$invoice_no = "", $prefix = "",$suffix = "",$date = "",$form = "") {
//    $ins_unique_id = ""
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&bill_no='.$bill_no.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
// .'&ins_unique_id='.$ins_unique_id.
    
    return $final_str;
}


function btn_update_4($folder_name = "",$unique_id = "",$invoice_no = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}
function btn_update_5($folder_name = "",$consignee_unique_id = "",$invoice_no = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&consignee_unique_id='.$consignee_unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}
// update for users
function btn_update_invoice($folder_name = "",$unique_id = "",$invoice_no = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}




function btn_create($folder_name = "", $prefix = "",$suffix = "",$date = "",$form = "") {
    // $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update&unique_id='.$unique_id.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-square-edit-outline"></i></button></a>';

    $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/create&date='.$date.'&form='.$form.'"><i class="mdi mdi mdi-shape-square-plus mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}

function btn_view($folder_name = "",$unique_id = "", $prefix = "",$suffix = "") {

    $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/view&unique_id='.$unique_id.'"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';

    
    return $final_str;
}

function btn_view1($folder_name = "",$unique_id = "", $prefix = "",$suffix = "") {

    $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/view&unique_id='.$unique_id.'"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';

    
    return $final_str;
}


function btn_delete($folder_name = "",$unique_id = "") {
    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<a href="#" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete mdi-24px waves-effect waves-light text-danger"></a>';

    $final_str = '<a href="#" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')" id="delete_btn"><i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger" ></i></a>';

    return $final_str;
}

function btn_call_update($folder_name = "",$unique_id = "", $prefix = "",$suffix = "") {
    $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update&is_phone=1&unique_id='.$unique_id.'"><i class="mdi mdi-phone-in-talk  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-warning"></i></a>';
    // $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update&is_phone=1&unique_id='.$unique_id.'"><img src="img/start.png" width="27" height="27" alt="Start Call"></a>';
    
    return $final_str;
}

function btn_call_start($customer_id = "", $followup_id = "") {
    $final_str = '<a href="javascript:void(0);" onclick="start_call(\''.$customer_id.'\',\''.$followup_id.'\')"><i class="mdi mdi-play-circle  mdi-24px waves-effect waves-light mt-n2 mb-n2 ml-2 text-primary"></i></a>';
    $final_str = '<a href="javascript:void(0);" onclick="start_call(\''.$customer_id.'\',\''.$followup_id.'\')"><img src="img/start.png" width="27" height="27" alt="Start Call" class="ml-2"></a>';
    
    return $final_str;
}

function btn_map($latitude = "",$longitude = "") {
    
    $def_latitude="13.0456605";
    $def_longitude="80.2086916";

    $final_str = '<a target="_blank" href="https://www.google.com/maps/dir/?api=1&origin='.$def_latitude. "," .$def_longitude.'&destination='.$latitude.','.$longitude.'"><i class="mdi mdi-map-marker mdi-24px waves-effect waves-light mt-n2 mb-n2 text-primary"></i></a>';
    
    return $final_str;
}

function btn_print($folder_name = "",$unique_id = "", $file_name = "",$prefix = "",$suffix = "") {

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-printer"></i></button></a>';

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'"><i class="mdi mdi-printer mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i></a>';
    
    return $final_str;
}

// function btn_print_report($folder_name = "",$unique_id = "", $file_name = "",$prefix = "",$suffix = "") {

//     $menu_screen            = $folder_name."/model";
//     $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

//     $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    
//     $final_str = '<a target="_blank" href="index.php?file='.$file_name_update.'&unique_id='.$uni_id.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-printer"></i></button></a>';

//     $final_str = '<a target="_blank" href="index.php?file='.$file_name_update.'&unique_id='.$uni_id.'"><i class="mdi mdi-printer mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i></a>';
    
//     return $final_str;
// }

function btn_print_in_list($folder_name = "",$unique_id = "", $file_name = "",$prefix = "",$suffix = "",$content = '<button type="button" class="btn btn-info btn-rounded waves-effect waves-light float-right"><i class="mdi mdi-printer mdi-16px waves-effect waves-light text-white"></i></button>') {

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'">'.$content.'</a>';
    
    return $final_str;
}

function btn_print_in_form($folder_name = "",$unique_id = "", $file_name = "",$prefix = "",$suffix = "") {

    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'"><button type="button" class="btn btn-info btn-rounded waves-effect waves-light float-right mr-2"><i class="mdi mdi-printer mdi-16px waves-effect waves-light text-white">'.$file_name.'</i></button></a>';
    
    return $final_str;
}

function btn_approval_print($folder_name = "",$unique_id = "",$sub_unique_id = "", $file_name = "",$prefix = "",$suffix = "") {
    $final_str = '<a target="_blank" href="index.php?file='.$prefix.$folder_name.$suffix.'/'.$file_name.'&unique_id='.$unique_id.'&sub_unique_id='.$sub_unique_id.'"><button type="button" class="btn btn-warning  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-lead-pencil"></i></button></a>';
    
    return $final_str;
}



function btn_edit($folder_name = "",$unique_id = "") {
    $final_str = '<button type="button" class="btn btn-asgreen btn-xs btn-rounded waves-effect waves-light " onclick="'.$folder_name.'_edit(\''.$unique_id.'\')"><i class="ri-pencil-line"></i></button>';
// mdi mdi-square-edit-outline
    $final_str = '<a href="#" onclick="'.$folder_name.'_edit(\''.$unique_id.'\')"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

    return $final_str;
}

function btn_edit1($folder_name = "",$unique_id = "") {
    $final_str = '<button type="button" class="btn btn-asgreen btn-xs btn-rounded waves-effect waves-light " onclick="'.$folder_name.'_edit(\''.$unique_id.'\')"><i class="mdi mdi-square-edit-outline"></i></button>';

    $final_str = '<a href="#" onclick="'.$folder_name.'_edit(\''.$unique_id.'\')"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

    return $final_str;
}



// Datatables Total Records Count Function
function total_records() {
    global $pdo;
    
    $total_records  = 0;
    $sql            = "SELECT FOUND_ROWS() as total";
    $result         = $pdo->query($sql);
    if($result->status){
        $total      = $result->data[0]["total"];
    }
        
    return $total;
}

// Convert Original folder Name to Display Name
function disname($name = "")
{
    if ($name) {
        $name = explode("_",$name);
        $name = array_map("ucfirst",$name);
        $name = implode(" ",$name);

        return $name;
    } else {
        return "Empty Title";
    }
}

// Continents Function
function continent($unique_id = "",$columns = "") {
    global $pdo;

    $where          = [];
    $table          = "continents";

    if (!$columns) {
        $table_columns = [
            $table,
            [
                "unique_id",
                "name"  
                ]
            ];
    } else {
        $table_columns = [
            $table,
            $columns
        ];
    }

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        // $where = " WHERE continent_id = '".$continent_id."' ";
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $continents = $pdo->select($table_columns, $where);

    // print_r($continents);

    if ($continents->status) {
        return $continents->data;
    } else {
        print_r($continents);
        return 0;
    }
}

function select_option($options = [],$description = "", $is_selected = [],$is_disabled = []) {
    
    $option_str     = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str     = "<option value='' selected>".$description."</option>";
        }
        foreach ($options as $key => $value) {

            $value      = array_values($value);
            $selected   = "";
            $disabled   = "";

            if (is_array($is_selected) AND in_array($value[0],$is_selected)) {            
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {
                
                $selected = " selected='selected' ";
            }
            
            if (is_array($is_disabled) AND in_array($value[0],$is_disabled)) {            
                $disabled = " disabled='disabled' ";
            } elseif ($is_disabled == $value[0]) {
                $disabled = " disabled='disabled' ";
            }

            if (strpos($value[1],"_")) {
                $value[1] = disname($value[1]);
            } else {
                $value[1] = ucfirst($value[1]);
            }

            if (isset($value[2])) {
                $data_attribute = "data-extra='".$value[2]."'";
            } 

            $option_str .= "<option value='".$value[0]."'".$data_attribute.$selected.$disabled.">".$value[1]."</option>";
        }
    }
    
    return $option_str;
}

// jaya
function select_option2($options = [], $description = "", $is_selected = [], $is_disabled = []) {
   
    $option_str     = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        if ($description) {
            $option_str = "<option value='' selected>".$description."</option>";
        }
       
        $counter = 1;
        foreach ($options as $key => $value) {

            $value      = array_values($value);
            $selected   = "";
            $disabled   = "";

            if (is_array($is_selected) && in_array($value[0], $is_selected)) {            
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {
                $selected = " selected='selected' ";
            }
           
            if (is_array($is_disabled) && in_array($value[0], $is_disabled)) {            
                $disabled = " disabled='disabled' ";
            } elseif ($is_disabled == $value[0]) {
                $disabled = " disabled='disabled' ";
            }

            if (strpos($value[1], "_")) {
                $value[1] = disname($value[1]);
            } else {
                $value[1] = ucfirst($value[1]);
            }

            if (isset($value[2])) {
                $data_attribute = "data-extra='".$value[2]."'";
            }

            $option_str .= "<option value='".$value[0]."'".$data_attribute.$selected.$disabled.">".$counter.". ".$value[1]."</option>";
            $counter++;
        }
    }
   
    return $option_str;
}
// end
function select_option1($options = [],$description = "", $is_selected = [],$is_disabled = []) {
    
    $option_str     = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str     = "<option value='' selected>".$description."</option>";
        }
        foreach ($options as $key => $value) {

            $value      = array_values($value);
            $selected   = "";
            $disabled   = "";

            if (is_array($is_selected) AND in_array($value[0],$is_selected)) {            
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {
                
                $selected = " selected='selected' ";
            }
            
            if (is_array($is_disabled) AND in_array($value[0],$is_disabled)) {            
                $disabled = " disabled='disabled' ";
            } elseif ($is_disabled == $value[0]) {
                $disabled = " disabled='disabled' ";
            }

            if (strpos($value[1],"_")) {
                $value[1] = disname($value[1]);
            } else {
                $value[1] = ucfirst($value[1]);
            }

            if (isset($value[2])) {
                $data_attribute = "data-extra='".$value[2]."'";
            } 

            $option_str .= "<option value='".$value[1]."'".$data_attribute.$selected.$disabled.">".$value[1]."</option>";
        }
    }
    
    return $option_str;
}


function active_status($is_active_val = 1) {
    $option_str    = "";
    $is_active     = "";
    $is_inactive   = "";

    if ($is_active_val == 1) {
        $is_active     = " selected = 'selected' ";
    } else {
        $is_inactive   = " selected = 'selected' ";
    }
     
    $option_str     =  "<option value='1'".$is_active.">Active</option>";
    $option_str     .=  "<option value='0'".$is_inactive.">In Active</option>";

    return $option_str;
}

// Active and In Active Show in Data Table
function is_active_show($is_active = 0) {
    $act_str = "<span style='color: red'>In Active</span>";

    if ($is_active) {
        $act_str = "<span style='color: green'>Active</span>";
    }

    return $act_str;
}




// Screen Type Function
function screen_type($unique_id = "") {
    global $pdo;

    $table_name    = "user_screen_type";
    $where         = [];
    $table_columns = [
        "unique_id",
        "type_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $screen_types = $pdo->select($table_details, $where);

    // print_r($screen_types);die();

    if ($screen_types->status) {
        return $screen_types->data;
    } else {
        print_r($screen_types);
        return 0;
    }
}


// Main Screen Function
function main_screen($unique_id = "") {
    global $pdo;

    $table_name    = "user_screen_main";
    $where         = [];
    $table_columns = [
        "unique_id",
        "screen_main_name",
        "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where,'','',$order_by);
//print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

// Main Screen Function
function engineer_name($unique_id = "") {
    global $pdo;

    $table_name    = "engineer_name";
    $where         = [];
    $table_columns = [
        "unique_id",
        "engineer_name",
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where,'','','');
//print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

// // Main Screen Function
// function user_screen($unique_id = "") {
//     global $pdo;

//     $table_name    = "user_screen";
//     $where         = [];
//     $table_columns = [
//         "unique_id",
//         // "screen_main_name",
//         // "icon_name"
//     ];

//     $table_details = [
//         $table_name,
//         $table_columns
//     ];

//     $where     = [
//         "is_active" => 1,
//         "is_delete" => 0
//     ];

//     if ($unique_id) {

//         $where              = [];
//         $where["unique_id"] = $unique_id;
//     }

//     $order_by  = 'order_no ASC';

//     $main_screens = $pdo->select($table_details, $where,'','',$order_by);
// //print_r($main_screens);
//     if ($main_screens->status) {
//         return $main_screens->data;
//     } else {
//         print_r($main_screens);
//         return 0;
//     }
// }

// Main Screen Function
function section_name($unique_id ="",$main_screen_id = "") {
    global $pdo;

    $table_name    = "user_screen_sections";
    $where         = [];
    $table_columns = [
        "unique_id",
        "section_name",
        "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    $order_by = [
        "order_no"
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }
    if ($main_screen_id) {

        $where["screen_main_unique_id"] = $main_screen_id;
    }

    $section_names = $pdo->select($table_details, $where, "", "", $order_by);

    if ($section_names->status) {
        return $section_names->data;
    } else {
        // print_r($section_names);
        return 0;
    }
}

// Main Screen Function
function user_screen($unique_id = "",$screen_section_id = "") {
    global $pdo;

    $table_name    = "user_screen";
    $where         = [];
    $table_columns = [
        "unique_id",
        "screen_name",
        "folder_name",
        "actions"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    $order_by = [
        "order_no"
    ];

    if ($screen_section_id) {

        $where["main_screen_unique_id"] = $screen_section_id;
    }  
     if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_screens = $pdo->select($table_details, $where, "", "", $order_by);

    if ($user_screens->status) {
        return $user_screens->data;
    } else {
        print_r($user_screens);
        return 0;
    }
}

// User Screen Actions Function
function user_actions($unique_id = "") {
    global $pdo;

    $table_name    = "user_screen_actions";
    $where         = [];
    $table_columns = [
        "unique_id",
        "action_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_actions = $pdo->select($table_details, $where);

    if ($user_actions->status) {
        return $user_actions->data;
    } else {
        print_r($user_actions);
        return 0;
    }
}

// Main Screen Function
function user_type($unique_id = "") {

    global $pdo;

    $table_name    = "user_type";
    $where         = [];
    $table_columns = [
        "unique_id",
        "user_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}




// BID Type Function
function staff_name ($unique_id = "") {
    global $pdo;

    $table_name    = "staff";
    $where         = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "office_contact_no",
        "designation_unique_id",
        "file_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $staff_name_list = $pdo->select($table_details, $where);

    if ($staff_name_list->status) {
        return $staff_name_list->data;
    } else {
        print_r($staff_name_list);
        return 0;
    }
}

// BID Type Function
function staff_ceo_name ($unique_id = "") {
    global $pdo;

    $table_name    = "staff";
    $where         = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "office_contact_no",
        "designation_unique_id"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active"             => 1,
        "designation_unique_id" => "5ff5d3423713a59778",
        "is_delete"             => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $staff_ceo_name_list = $pdo->select($table_details, $where);

    if ($staff_ceo_name_list->status) {
        return $staff_ceo_name_list->data;
    } else {
        print_r($staff_ceo_name_list);
        return 0;
    }
}




// BID Type Function
function staff_director_name ($unique_id = "") {
    global $pdo;

    $table_name    = "staff";
    $where         = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "office_contact_no",
        "designation_unique_id"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active"             => 1,
        "designation_unique_id" => "5ff5d3585747568896",
        "is_delete"             => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $staff_director_name_list = $pdo->select($table_details, $where);

    if ($staff_director_name_list->status) {
        return $staff_director_name_list->data;
    } else {
        print_r($staff_director_name_list);
        return 0;
    }
}




function btn_approve($folder_name = "",$unique_id = "",$approved_status = "") {
    if($approved_status) {
        $final_str = '<i class="mdi mdi-check btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light"></i>';
    } else {
        $final_str = '<i class=" mdi mdi-24px mdi-alert-circle-outline" style = "color :#e6f22b;"></i>';
    }
    
    return $final_str;
}

function btn_approve_status($folder_name = "",$unique_id = "",$approved_status = "") {
    if($approved_status=='0') {
        $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    } else {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }
    
    return $final_str;
}

function btn_bid_approve_status($folder_name = "",$unique_id = "",$approved_status = "",$approval_stage = "") {

    $final_str = "";

    if($approved_status=='0') {
        $final_str = '<button type="button" onclick="status_show(\'pending\',\''.$unique_id.'\',\''.$approval_stage.'\')" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation-thick"></i></button></a>';
    } else if($approved_status=='1') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }
    else if($approved_status=='2') {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    }
    else if($approved_status=='3') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }
    
    return $final_str;
}

function btn_expense_approve_status($unique_id = "",$approved_status = "",$approval_type = "") {

    $final_str = "";

    if($approved_status=='0') {
        $final_str = '<button type="button" onclick="expense_status_show(\'pending\',\''.$unique_id.'\',\''.$approval_type.'\')" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation-thick"></i></button></a>';
    } else if($approved_status=='1') {
        $final_str = '<button type="button" onclick="expense_status_show(\'approve\',\''.$unique_id.'\',\'\')" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }
    else if($approved_status=='2') {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    }
    else if($approved_status=='3') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }
    
    return $final_str;
}

function btn_approval ($folder_name = "",$unique_id = "",$approved_status = "") {
    
    if (($approved_status=='Cancel') || ($approved_status===2)) {

        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';

    } else if (($approved_status=='Approved') || ($approved_status===1)) {

        $final_str = '<button type="button"  class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';

    } else {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation"></i></button></a>';
    }
    
    return $final_str;
}

// BID Type Function
function blood_group ($unique_id = "") {
    global $pdo;

    $table_name    = "blood_group";
    $where         = [];
    $table_columns = [
        "unique_id",
        "blood_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $blood_name_list = $pdo->select($table_details, $where);

    if ($blood_name_list->status) {
        return $blood_name_list->data;
    } else {
        print_r($blood_name_list);
        return 0;
    }
}

function moneyFormatIndia($num) {
    $explrestunits = "";
    $amount     = explode('.', $num);
    $num        = $amount[0];
    $decimal    = 0;
    if (count($amount)==2) {
        $decimal = $amount[1];
    }
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }

    // $decimal = number_format($decimal, 2, '.', '');
    // $decimal = explode(".",$decimal)[1];

    // return $thecash.".".$decimal;
    $decimal = number_format($decimal, 0, '.', '');
    $decimal = explode(".",$decimal)[1];

    return $thecash.$decimal; // writes the final format where $currency is the currency symbol.
}

function moneyFormatIndia1($num) {
    $explrestunits = "";
    $amount     = explode('.', number_format($num, 2, '.', ''));
    $num        = $amount[0];
    $decimal    = $amount[1];

    if(strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3);
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits;
        $expunit = str_split($restunits, 2);
        for($i = 0; $i < sizeof($expunit); $i++) {
            if($i == 0) {
                $explrestunits .= (int)$expunit[$i] . ","; 
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }

    return $thecash . "." . $decimal;
}

// echo moneyFormatIndia(47685.87657); // Output: 47,685.88

// GST Name
function tax ($unique_id = "") {
    global $pdo;

    $table_name    = "tax";
    $where         = [];
    $table_columns = [
        "unique_id",
        "tax_name",
        "tax_value"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where              = [];
        $where["unique_id"] = $unique_id;

    }

    $tax_id = $pdo->select($table_details, $where);

    if ($tax_id->status) {
        return $tax_id->data;
    } else {
        print_r($tax_id);
        return 0;
    }
}

// GST Name
function account_year ($unique_id = "") {
    global $pdo;

    $table_name    = "account_year";
    $where         = [];
    $table_columns = [
        "unique_id",
        "account_year"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        // "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where              = [];
        $where["unique_id"] = $unique_id;

    }

    $account_year_id = $pdo->select($table_details, $where);

    if ($account_year_id->status) {
        return $account_year_id->data;
    } else {
        print_r($account_year_id);
        return 0;
    }
}

// competitor Function
function competitors ($unique_id = "") {
    global $pdo;

    $table_name    = "competitor_profile";
    $where         = [];
    $table_columns = [
        "unique_id",
        "competitor_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $competitor_list = $pdo->select($table_details, $where);

    if ($competitor_list->status) {
        return $competitor_list->data;
    } else {
        print_r($competitor_list);
        return 0;
    }
}

function file_upload_extention_lowercase_helper () {
    // In case file Extention was uppercase letters convert to lowercase
    foreach ($_FILES as $f_key => $f_value) {

        if (is_array($f_value['name'])) {
            
            // Multi File Upload
            foreach ($f_value['name'] as $fn_key => $fn_value) {
                $_FILES[$f_key]['name'][$fn_key] = strtolower($fn_value);
            }
        } else {
            // Single file Upload
            $_FILES[$f_key]['name'] = strtolower($f_value['name']);
        }
    }
}



// Supplier Function
function supplier($unique_id = "") {
    global $pdo;

    $table_name    = "supplier_profile";
    $where         = [];
    $table_columns = [
        "unique_id",
        "supplier_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        // $where = " WHERE unique_id = '".$unique_id."' ";
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $supplier = $pdo->select($table_details, $where);

    // print_r($countries);

    if ($supplier->status) {
        return $supplier->data;
    } else {
        print_r($supplier);
        return 0;
    }
}

// Supplier Function
function branch($unique_id = "") {
    global $pdo;

    $table_name    = "company_and_branch_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "branch_name"
    ];  

    $where     = [
        "is_active"   => 1,
        "is_delete"   => 0
    ];

    if ($unique_id) {
        // $where = " WHERE unique_id = '".$unique_id."' ";
        $table_columns[]="address";
        $table_columns[]="country";
        $table_columns[]="state";
        $table_columns[]="city";
        $table_columns[]="pin_code";
        $table_columns[]="phone_number";
        $table_columns[]="mobile_number";
        $table_columns[]="gst_number";
        $table_columns[]="email_id";
        $table_columns[]="website";
        $table_columns[]="radius";
        $table_columns[]="latitude";
        $table_columns[]="longitude";
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $table_details = [
        $table_name,
        $table_columns
    ];
    
    $branch = $pdo->select($table_details, $where);

    // print_r($countries);

    if ($branch->status) {
        return $branch->data;
    } else {
        print_r($branch);
        return 0;
    }
}


function sublist_insert_update($table_name = "", $data = "",$prefix = "") {
    global $pdo;
    if ($table_name) {
        foreach ($data as $data_key => $columns) {

            $unique_id = $columns['unique_id'];

            if($unique_id) {

                unset($columns['unique_id']);

                $update_where   = [
                    "unique_id"     => $unique_id
                ];

                $action_obj     = $pdo->update($table_name,$columns,$update_where);

            // Update Ends
            } else {
                $columns['unique_id'] = $prefix.unique_id();
                // Insert Begins            
                $action_obj     = $pdo->insert($table_name,$columns);
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

                print_r($action_obj);
                break;
            }
        }
    } else {
        echo "table name not given";
    }
}

function sublist_delete($table_name = "", $sub_unique_ids = "",$main_unique_id = []) {

    global $pdo;

    if ($table_name) {

        if (($sub_unique_ids) && (!empty($main_unique_id))) {

            $column_name     = array_keys($main_unique_id)[0];
            $column_value    = $main_unique_id[$column_name];
            
            $where           = " unique_id NOT IN (".$sub_unique_ids.") AND ".$column_name."  = '".$column_value."'";
            
            $columns         = [
                "is_delete" => 1
            ];
            
            $update_result   = $pdo->update($table_name,$columns,$where);

            if ($update_result->status) {
                
            } else {
                print_r($update_result);
            }
        } else {
            echo "Sub List Delete Status Update Error";
        }
        
    }
}


function user_name ($unique_id = "" ){
    
    global $pdo;

    $return_result = [
        "user_name"      => "",
        "staff_name"     => ""
    ];

    if ($unique_id) {
        $table_name    = "user";
        $where         = [];
        $table_columns = [
            "unique_id",
            "user_name",
            "(SELECT a.staff_name FROM staff a WHERE a.unique_id = user.staff_unique_id) AS staff_name",
            "staff_unique_id"
        ];
    
        $table_details = [
            $table_name,
            $table_columns
        ];
    
        $where     = [
            "is_active" => 1,
            "is_delete" => 0
        ];
    
        if ($unique_id) {

            $where              = [];
    
            $where["unique_id"] = $unique_id;
    
        }
    
        $user_name_id = $pdo->select($table_details, $where);
    
        if ($user_name_id->status) {
            return $user_name_id->data;
        } else {
            print_r($user_name_id);
            return 0;
        }
    }
}

//For User Login Details Report

function get_user_name ($unique_id = "" ){
    
    global $pdo;

    if ($unique_id) {
        $table_name    = "user";
        $where         = [];
        $table_columns = [
            "unique_id",
            "staff_name"
        ];
    
        $table_details = [
            $table_name,
            $table_columns
        ];
    
        $where     = [
            "is_active" => 1,
            "is_delete" => 0
        ];
    
        if ($unique_id) {

            $where              = [];
    
            $where["unique_id"] = $unique_id;
    
        }
    
        $get_user_name = $pdo->select($table_details, $where);
    
        if ($get_user_name->status) {
            return $get_user_name->data;
        } else {
            print_r($get_user_name);
            return 0;
        }
    }
}

// under user Function
function team_user ($user_id = "") {
    global $pdo;

    $table_name    = "user";
    $where         = "";
    $table_columns = [
        "unique_id",
        "user_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = "is_delete = 0 AND is_active = 1   AND is_team_head = 0 AND user_name != '".$user_id ."'";

   /* if ($unique_id) {

        $where["unique_id"] = $unique_id;
    }*/

    $user_name_list = $pdo->select($table_details, $where);

    if ($user_name_list->status) {
        return $user_name_list->data;
    } else {
        print_r($user_name_list);
        return 0;
    }
}

// under user Function
function under_user ($user_id = "") {
    global $pdo;

    $table_name    = "user";
    $where         = "";
    $table_columns = [
        "unique_id",
        "user_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = "is_delete = 0 AND is_active = 1  AND user_name != '".$user_id ."'";

   /* if ($unique_id) {

        $where["unique_id"] = $unique_id;
    }*/

    $user_name_list = $pdo->select($table_details, $where);

    if ($user_name_list->status) {
        return $user_name_list->data;
    } else {
        print_r($user_name_list);
        return 0;
    }
}

// under user type Function
function under_user_type ($user_type = "") {
    global $pdo;

    $table_name    = "user_type";
    $where         = "";
    $table_columns = [
        "unique_id",
        "user_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = "is_delete = 0 AND is_active = 1 AND user_type != '".$user_type ."'";

   /* if ($unique_id) {

        $where["unique_id"] = $unique_id;
    }*/

    $user_type_list = $pdo->select($table_details, $where);

    if ($user_type_list->status) {
        return $user_type_list->data;
    } else {
        print_r($user_type_list);
        return 0;
    }
}

// Show Entries Based On User Hierarcy
function user_hierarchy ($user_id = "", $user_type_id = "",$team_users = false) {

    global $pdo;

    $table_user         = "user";
    $table_user_type    = "user_type";

    $return_result = [
        "under_user"        => "",
        "under_user_type"   => ""
    ];

    if ($user_id) {
        $user_where = [
            "unique_id" => $user_id
        ];

        $user_columns = [
            "under_user"
        ];

        if ($team_users) {
            $user_columns = [
                "team_members AS under_user"
            ];
        }

        $user_table_details = [
            $table_user,
            $user_columns
        ];

        $user_select = $pdo->select($user_table_details, $user_where);

        if ($user_select->status) {
            $user_data = $user_select->data[0];

            if ($user_data['under_user']) {
                $user_data['under_user'] = '"'.implode('","',explode(",",$user_data['under_user'])).'",';
            }

            $user_data['under_user'] .= '"'.$user_id.'"';

            $return_result['under_user'] = $user_data['under_user'];
        } else {
            print_r($user_select);
            exit;
        }
    }

    if ($user_type_id) {
        $user_where = [
            "unique_id" => $user_type_id
        ];

        $user_columns = [
            "under_user_type"
        ];

        $user_table_details = [
            $table_user_type,
            $user_columns
        ];

        $user_select = $pdo->select($user_table_details, $user_where);

        if ($user_select->status) {
            $user_data = $user_select->data[0];

            if ($user_data['under_user_type']) {
                $user_data['under_user_type'] = '"'.implode('","',explode(",",$user_data['under_user_type'])).'",';
            }

            $user_data['under_user_type'] .= '"'.$user_type_id.'"';

            $return_result['under_user_type'] = $user_data['under_user_type'];
        } else {
            print_r($user_select);
            exit;
        }
    }

    return $return_result;
}

//datatable search
function mysql_like ($search_query = "", $search_term = "") {

    $return_result = "";

    if ($search_query) {
        switch ($search_term) {
            case "first":
                $return_result = "%".$search_query;
                break;
            
            case "last":
                $return_result = $search_query."%";
                break;
            
            default:
                // For All result
                $return_result = "%".$search_query."%";
                break;
        }
    }

    return $return_result;
}
//expense type function
function expense_type ($unique_id = "") {
    global $pdo;

    $table_name    = "expense_type";
    $where         = [];
    $table_columns = [
        "unique_id",
        "expense_type"
        
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $expense_type_list = $pdo->select($table_details, $where);

    if ($expense_type_list->status) {
        return $expense_type_list->data;
    } else {
        print_r($expense_type_list);
        return 0;
    }
}

function item_unit_decimal ($item_id = 0) {

    $decimal  = 0;

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns    = [
            "unit_unique_id"
        ];

        $where      = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result  = $pdo->select($table_details,$where);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            $item_unit = $select_result->data[0];
            
            if ($item_unit) {

                $item_unit          = $item_unit['unit_unique_id'];

                // Get Unit Decimal
                $table_unit         = "units";

                $columns_unit       = [
                    "decimal_points"
                ];
        
                $where_unit         = [
                    "unique_id" => $item_unit
                ];
        
                $table_unit_details = [
                    $table_unit,
                    $columns_unit
                ];

                $decimal_select     = $pdo->select($table_unit_details,$where_unit);

                if (!($decimal_select->status)) {
                    print_r($decimal_select);
                } else {
                    $decimal = $decimal_select->data[0];

                    $decimal = $decimal['decimal_points'];

                    if (!($decimal)) {
                        $decimal    = 0;
                    }
                }
            }
        }
    }

    return $decimal;
}

function item_unit ($item_id = 0) {

    $unit_name  = "";

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns    = [
            "unit_unique_id"
        ];

        $where      = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result  = $pdo->select($table_details,$where);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            $item_unit = $select_result->data[0];
            
            if ($item_unit) {

                $item_unit          = $item_unit['unit_unique_id'];

                // Get Unit Decimal
                $table_unit         = "units";

                $columns_unit       = [
                    "unit_name"
                ];
        
                $where_unit         = [
                    "unique_id" => $item_unit
                ];
        
                $table_unit_details = [
                    $table_unit,
                    $columns_unit
                ];

                $unit_name_select     = $pdo->select($table_unit_details,$where_unit);

                if (!($unit_name_select->status)) {
                    print_r($unit_name_select);
                } else {
                    $unit_name = $unit_name_select->data[0];

                    $unit_name = $unit_name['unit_name'];

                    if (!($unit_name)) {
                        $unit_name    = "";
                    }
                }
            }
        }
    }
    
    return $unit_name;
}

function item_tax1 ($item_id = 0) {

    $item_tax_value  = "";

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns    = [
            "tax_unique_id"
        ];

        $where      = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result  = $pdo->select($table_details,$where);

        print_r($select_result);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            // print_r($select_result);

            $item_tax = $select_result->data[0];
            
            if ($item_tax) {

                $item_tax          = $item_tax['tax_unique_id'];

                // Get Unit Decimal
                $table_tax         = "tax";

                $columns_unit      = [
                    "tax_value"
                ];
        
                $where_unit         = [
                    "unique_id" => $item_tax
                ];
        
                $table_tax_details  = [
                    $table_tax,
                    $columns_unit
                ];

                $item_tax_value_select   = $pdo->select($table_tax_details,$where_unit);

                print_r($item_tax_value_select);

                if (!($item_tax_value_select->status)) {
                    print_r($item_tax_value_select);
                } else {
                    // print_r($item_tax_value_select);

                    if (!empty($item_tax_value_select->data[0])) {
                        $item_tax_value = $item_tax_value_select->data[0];

                        $item_tax_value = $item_tax_value['tax_value'];

                        if (!($item_tax_value)) {
                            $item_tax_value    = 0;
                        }
                    } else {
                        $item_tax_value    = 0;
                    }
                }
            }
        }
    }
    
    return $item_tax_value;
}

function item_tax($item_id = "") {

    $item_tax_value  = 0;

    return 0;

    if ($item_id) {

        global $pdo;

        $table_name = "item_names_code";

        echo $item_id;

        $columns    = [
            "(SELECT t.tax_value FROM tax t WHERE t.unique_id = $table_name.tax_unique_id) AS tax_unique_id"
        ];

        $where      = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result  = $pdo->select($table_details,$where);

        print_r($select_result);
    }
}

function unit_decimal_cal ($number_val = 0,$decimal = 0) {

    $return_result  = 0;

    if ($number_val) {
        $return_result = number_format($number_val,$decimal,".","");
    }

    return $return_result;
}

function getIndianCurrency(float $number) {
    
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    // return strtoupper(($Rupees ? $Rupees . 'Rupees ' : '') . $paise. " only ");
    return (($Rupees ? $Rupees . 'Rupees ' : '') ." only ");
}


function team_heads($head_id = "")
{
    global $pdo;

    $team_heads_sql = "SELECT unique_id,staff_unique_id AS staff_id,team_members FROM user WHERE is_delete = 0 AND is_team_head = 1";

    $team_head_columns = [
        "unique_id",
        "staff_unique_id",
        "(SELECT staff_name FROM staff WHERE unique_id = user.staff_unique_id) AS staff_name",
        "(SELECT file_name FROM staff WHERE unique_id = user.staff_unique_id) AS user_image",
        "team_members",
        "team_id",
        "profile_image"
    ];

    $team_head_details = [
        "user", // Table Name 
        $team_head_columns
    ];

    $team_head_where   = [
        "is_delete" => 0,
        "is_team_head" => 1
    ];

    if ($head_id) {
        $team_head_where['unique_id'] = $head_id;
    }

    $team_head_result = $pdo->select($team_head_details,$team_head_where);

    if ($team_head_result->status) {
        return $team_head_result->data;
    } else {
        print_r($team_head_result);
    }
    return [];
}

function team_members($team_members)
{
    global $pdo;
    if ($team_members) {
        $team_members_columns = [
            "unique_id",
            "staff_unique_id",
            "(SELECT staff_name FROM staff WHERE unique_id = user.staff_unique_id) AS staff_name",
            "(SELECT file_name FROM staff WHERE unique_id = user.staff_unique_id) AS user_image",
            "profile_image"

        ];
    
        $team_members_details = [
            "user", // Table Name 
            $team_members_columns
        ];

        // Exploding the String
        $team_members = explode(",",$team_members);
        $team_members = "'".implode("','",$team_members)."'";
    
        $team_members_where  = "is_delete = 0 AND unique_id IN (".$team_members.")";

        $order_by = " is_team_head DESC";
    
        $team_members_result = $pdo->select($team_members_details,$team_members_where,'','',$order_by);
    
        if ($team_members_result->status) {
            return $team_members_result->data;
        } else {
            print_r($team_members_result);
        }
    }

    return [];
}

function week_range ($week, $year)
{

    $dates          = [];
    $time           = strtotime("1 January $year", time());
    $day            = date('w', $time);
    $time           += ((7*$week)+1-$day)*24*3600;
    $dates["from"]  = date('Y-n-j', $time);
    $time           += 6*24*3600;
    $dates["to"]    = date('Y-n-j', $time);

    return $dates;
}

function datatable_sorting($column = 0, $direction = "ASC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}



function datatable_sorting_po($column = 8, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}


function datatable_sorting_po_report($column = 1, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}



// MYTHILI
function datatable_sorting_inv($column = 9, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}

// MYTHILI
function datatable_sorting_elcot($column = 12, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_ac($column = 12, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_ins1($column = 12, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}


function datatable_sorting_invoice($column = 9, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_inv2($column = 9, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}


function datatable_sorting_ins2($column = 7, $direction = "DESC", $columns_array = []) {
    $order_by   = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found  = strripos($columns_array[$column]," AS ");
            
            if ($is_found) {
                $as_column = substr($columns_array[$column],$is_found+3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by       = $as_column." ".$direction;
            } else {
                $order_by       = $columns_array[$column]." ".$direction;
            }
        }
    }
    return $order_by;
}
function datatable_searching($search_query = '',$columns_array = []) {
    $search_string = "";

    if ($search_query) {
        if (!empty($columns_array)) {
            // Remove AS in Subquery in $columns_array
            $temp_arr   = [];
            foreach ($columns_array as $col_key => $col_value) {
                
                $is_found  = strripos($col_value," AS ");
            
                if ($is_found) {
                    $as_column = substr($col_value,0,$is_found);
                } else {
                    $as_column = $col_value;
                }
                $temp_arr[] = $as_column." LIKE '%".$search_query."%' ";
            }
            
            unset($temp_arr[count($temp_arr)-1]); // Unique ID Endry Disable
            unset($temp_arr[0]); // S.No Search Disable
            $search_string = implode(" OR ",$temp_arr);
        }
    }
    return $search_string;
}



function zone_name($unique_id = "") {

    global $pdo;

    $table_name    = "zone_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "zone_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $zone_name = $pdo->select($table_details, $where);
    if ($zone_name->status) {
        return $zone_name->data;
    } else {
        print_r($zone_name);
        return 0;
    }
}


function department_creation($unique_id = "") {

    global $pdo;

    $table_name    = "department_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "department_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where,'','',$order_by);
   
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}


// department


function department_creation_table($unique_id = "") {

    global $pdo;

    $table_name    = "department_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "department"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);
   
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
// function brand_creation_table($unique_id = "") {

//     global $pdo;

//     $table_name    = "item_creation_sub";
//     $where         = [];
//     $table_columns = [
       
//         // "unique_id",
//         "brand",
        
//     ];

//     $table_details = [
//         $table_name,
//         $table_columns
//     ];

//     $where     = [
//         "is_active" => 1,
//         "is_delete" => 0
//     ];

//     if ($unique_id) {

//         $where              = [];
//         $where["unique_id"] = $unique_id;
//     }

//     // $order_by  = 'order_no ASC';

//     $brand_name = $pdo->select($table_details, $where);
//     // print_r($brand_name);die();
   
//     if ($brand_name->status) {
//         return $brand_name->data;
//     } else {
//         print_r($brand_name);
//         return 0;
//     }
// }


       



function ward_name($unique_id = "",$zone_id="") {

    global $pdo;

    $table_name    = "ward_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "ward_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }
    if ($zone_id) {

        $where              = [];
        $where["zone_name"] = $zone_id;
    }

    $order_by  = '(ward_name) ASC';
    

    $ward_name = $pdo->select($table_details, $where,'','',$order_by);
    if ($ward_name->status) {
        return $ward_name->data;
    } else {
        print_r($ward_name);
        return 0;
    }
}


function designation_name($unique_id = "") {

    global $pdo;

    $table_name    = "designation_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "designation_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $designation_name = $pdo->select($table_details, $where);
   
    if ($designation_name->status) {
        return $designation_name->data;
    } else {
        print_r($designation_name);
        return 0;
    }
}


function dashboard_admin_menu($unique_id = "") {

    global $pdo;

    $table_name    = "dashboard_settings_menu_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "settings_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $dashboard_admin_menu = $pdo->select($table_details, $where);
   
    if ($dashboard_admin_menu->status) {
        return $dashboard_admin_menu->data;
    } else {
        print_r($dashboard_admin_menu);
        return 0;
    }
}

function tax_type($is_active_val = 1) {
    $option_str    = "";
    $is_active     = "";
    $is_inactive   = "";

    if ($is_active_val == 1) {
        $is_active     = " selected = 'selected' ";
    } else {
        $is_inactive   = " selected = 'selected' ";
    }
     
    $option_str     =  "<option value='1'".$is_active.">Active</option>";
    $option_str     .=  "<option value='0'".$is_inactive.">In Active</option>";

    return $option_str;
}


// executive_name
function executive_name($unique_id = "") {

    global $pdo;

    $table_name    = "executive_name";
    $where         = [];
    $table_columns = [
        "unique_id",
        "executive_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}

// District name
function district_name($unique_id = "") {

    global $pdo;

    $table_name    = "district_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}
function tender_name($unique_id = "") {

    global $pdo;

    
    $table_name    = "item_creation";
    $where         = [];
    $table_columns = [
       
        "unique_id",
        "tender_code"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}




function tender_code($unique_id = "" ) {

    global $pdo;

    $table_name    = "item_creation_sub";
    $where         = [];
    $table_columns = [
        "unique_id",
        "tender_code",
        // "unique_id",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }
    $group_by          = "tender_code";
    $tender_codes = $pdo->select($table_details, $where,"","","","",$group_by);
    // print_R($tender_codes);

    if ($tender_codes->status) {
        return $tender_codes->data;
    } else {
        print_r($tender_codes);
        return 0;
    }
}

// item_code
function item_name($tender_code="") {

    global $pdo;

    $table_name    = "item_creation_sub";
    $where         = [];
    $table_columns = [
        "unique_id",
        "item_code",
        // "tender_code",
        // "unique_id",
       
    // "tender_code"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];
// if($tender_code ){
    $where= 'tender_code="'.$tender_code.'"';
    // print_r( $where);
// }
    // $where ="unique_id='".$tender_code."'";
    // print_R($where);
    // $group_by          = "item_code ";
    // $tender_codes = $pdo->select($table_details, $where,"","","","",$group_by);
    $user_types = $pdo->select($table_details, $where);
// print_R( $user_types );
    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}


// Warranty name
function warranty_name($unique_id = "") {

    global $pdo;

    $table_name    = "product_warrenty";
    $where         = [];
    $table_columns = [
        "unique_id",
        "warrenty_year"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}
// assign_qty_taken
function assign_qty_taken($unique_id = "") {

    global $pdo;

    $table_name    = "po_product_assign_details";
    $where         = [];
    $table_columns = [
        // "unique_id",
        "assign_qty"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["con_name"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);
// print_r($user_types);
    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}
// Warranty name
function po_type_option($unique_id = "") {

    global $pdo;

    $table_name    = "po_type";
    $where         = [];
    $table_columns = [
        "unique_id",
        "po_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where              = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}

function random_strings($length_of_string)
{
 
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
 
    // Shuffle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result),
                       0, $length_of_string);
}
//main_category
function main_option ($unique_id = "") {
    global $pdo;

    $table_name    = "main_category";
    $where         = [];
    $table_columns = [
        "unique_id",
        "main_category"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
        
    }

    $main_category_list = $pdo->select($table_details, $where);

    if ($main_category_list->status) {
        return $main_category_list->data;
    } else {
        print_r($main_category_list);
        return 0;
    }
}
//city_creation
function city_option ($unique_id = "", $district_name = "") {
    global $pdo;

    $table_name    = "city_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "city_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
        
    }
    if ($district_name) {
     
        $where["district_name"] = $district_name;
        
    }

    $city_creation_list = $pdo->select($table_details, $where);

    if ($city_creation_list->status) {
        return $city_creation_list->data;
    } else {
        print_r($city_creation_list);
        return 0;
    }
}
// district_creation
function district_option ($unique_id = "", $state_name = "") {
    global $pdo;

    $table_name    = "district_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
        
    }
    if ($state_name) {
     
        $where["state_name"] = $state_name;
        
    }

    $district_creation_list = $pdo->select($table_details, $where);

    if ($district_creation_list->status) {
        return $district_creation_list->data;
    } else {
        print_r($district_creation_list);
        return 0;
    }
}
//state_creation
function state_option ($unique_id = "") {
    global $pdo;

    $table_name    = "state_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "state_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where     = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details      = $table_name;
        $where              = [];
        $where["unique_id"] = $unique_id;
        
    }

    $state_creation_list = $pdo->select($table_details, $where);

    if ($state_creation_list->status) {
        return $state_creation_list->data;
    } else {
        print_r($state_creation_list);
        return 0;
    }
}
// consignee select
// function consignee_option($unique_id = "") {
//     global $pdo;
//     $table_name    = "consignee_details_sub";
//     $where         = [];
//     $table_columns = [
//         "unique_id",
//         "con_address",
//         "form_main_unique_id"
//     ];
//     $table_details = [
//         $table_name,
//         $table_columns
//     ];
//     $where     = [
//         "is_active" => 1,
//         "is_delete" => 0,
//         "form_main_unique_id" => $unique_id
//     ];
    
//     $consignee_details_sub = $pdo->select($table_details, $where);
//     if ($consignee_details_sub->status) {
//         return $consignee_details_sub->data;
//     } else {
//         print_r($consignee_details_sub);
//         return 0;
//     }
// }

function consignee_option($unique_id = "") {
    global $pdo;
    $table_name    = "consignee_details_sub";
    $where         = [];
    $table_columns = [
        "unique_id",
        "CONCAT(con_address,' ', con_pincode, ' ', (SELECT district_name FROM district_creation WHERE unique_id = con_district)
          ) AS con_address",
        "form_main_unique_id"
        
    ];
    $table_details = [ 
        $table_name,
        $table_columns
    ];
    $where     = [
        "is_active" => 1,
        "is_delete" => 0,
    
        "form_main_unique_id" => $unique_id,
         "inv_cons_status"=>0,
    ];
    
    $consignee_details_sub = $pdo->select($table_details, $where);
    if ($consignee_details_sub->status) {
        return $consignee_details_sub->data;
    } else {
        print_r($consignee_details_sub);
        return 0;
    }
}
// mythili
// Supplier Function

function po_product($unique_id = '',$form_main_unique_id=''){
   
    global $pdo;

    $table_name    = "product_details_sub";
    $where         = [];
    $table_columns = [
        "unique_id",
        "product",
        "form_main_unique_id"
       
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id="'.$form_main_unique_id.'"';
    // print_r($where);
// AND form_main_unique_id ="'.$unique_id .'"
    // $where = "main_unique_id = $unique_id AND con_unique_id = $con_unique_id";
    // if ($unique_id) {

    //     $where              = [];
    //     $where["main_unique_id"] = $unique_id;
    // }

    $po_product = $pdo->select($table_details, $where);
    // print_r($po_product);
    if ($po_product->status) {
        return $po_product->data;
    } else {
        print_r($po_product);
        return 0;
    }
}

function btn_update_7($folder_name = "",$unique_id = "",$invoice_no = "", $ins_unique_id="",$prefix = "",$suffix = "",$date = "",$form = "") {
    $password = project_env('SERVICE_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('SERVICE_ENCRYPTION_IV');


    $menu_screen            = $folder_name."/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'&ins_unique_id='.$ins_unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    
    return $final_str;
}

function btn_view_signed_doc($folder_name = "",$unique_id = "",$invoice_no = "", $ins_unique_id= "",$prefix = "", $suffix = "") {




    // $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'&ins_unique_id='.$ins_unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

 $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update1&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'&ins_unique_id='.$ins_unique_id.'"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';

    
    return $final_str;
}



// function status_option($unique_id="") {

//     global $pdo;

//     $table_name    = "sign_doc_verification_detail";
//     $where         = [];
//     $table_columns = [
//         "unique_id",
//         "status_app"
//     ];

//     $table_details = [
//         $table_name,
//         $table_columns
//     ];

//     $where     = [
//         "is_active" => 1,
//         "is_delete" => 0
//     ];
//     //  if($unique_id) {
         
//             // $where="unique_id='".$unique_id."' and is_delete=0";
//         // $table_details      = $table_name;

//         // $where              = [];
//         // $where["unique_id"] = $unique_id;
//     // }
//     // print_R($where);die();
// //   if($status_app) {

// //         $where["unique_id"] .= $status_app;
// //     }
//     // print_R($where);
//     if ($unique_id) {
//         $table_details      = $table_name;
//         $where              = [];
//         $where["unique_id"] = $unique_id;
        
//     }
//     // if ($status_app) {
     
//     //     $where["status_app"] = $status_app;
        
//     // }


//     $status_name = $pdo->select($table_details, $where);
// //   print_r($status_name);
//     if ($status_name->status) {
//         return $status_name->data;
//     } else {
//         print_r($status_name);
//         return 0;
//     }
// }



