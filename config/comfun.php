<?php
require_once __DIR__ . '/env.php';

//$logo_img       = "img/logo-light.png";
//$logo_img_dark  = "img/logo-light.png";

$logo_img = "img/logo-new.png";
$logo_img_dark = "img/logo-new.png";
$logo_img_sm = "";
$logo_img_print = "";

// Default Admin User Type





function team_member($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "staff_id",
        "staff_name",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["staff_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', '');
    // print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

function get_po_by_customer($customer_id = "")
{


    // print_r($customer_id);die();

    global $pdo;

    $table_name = "po_form";
    $where = [];

    $table_columns = [
        "unique_id",
        "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    $where = "is_delete = 0 and is_active = 1 and department = '$customer_id'";

    // if ($customer_id) {

    //     $where = [];
    //     $where["department"] = $customer_id;
    // }

    $user_types = $pdo->select($table_details, $where);
    // print_r($user_types);
    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}
function assign_team_member($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "staff_id",
        "staff_name",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["staff_id"] = $unique_id;
    }

    $order_by = "staff_name ASC";

    $main_screens = $pdo->select($table_details, $where, '', '', $order_by);
    // print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}


function engineer_name($unique_id = "")
{
    global $pdo;

    $table_name = "engineer_name_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "(SELECT staff_name FROM user WHERE user.unique_id = $table_name.engineer_name) AS engineer_name",
        "emp_id"
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'staff_name ASC';

    $main_screens = $pdo->select($table_details, $where, '', '');
    // print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$admin_user_type = "5f97fc3257f2525529";
$hr_user_type = "5ff71f5fb5ca556748";


$password = project_env('APP_ENCRYPTION_PASSWORD');
$enc_method = 'aes-256-cbc';
$enc_password = substr(hash('sha256', $password, true), 0, 32);
$enc_iv = project_env('APP_ENCRYPTION_IV');

// Date Related Function
function today($format = "")
{
    if ($format) {
        return date($format);
    }

    return date("Y-m-d");
}


function today_time($format = "")
{
    if ($format) {
        return date($format);
    }

    return date("Y-m-d H:i:s");
}

function disdate($date)
{

    $result = "";

    if ($date) {
        $result = implode("-", array_reverse(explode("-", $date)));
    }

    return $result;
}

$today = today();
$today_time = today_time();

// Bill No Generation

function bill_no($table_name, $where, $prefix = "", $y = 1, $m = 1, $d = 1, $custom_date = false, $separator = "")
{
    $billno = $prefix;

    if (!$custom_date) {
        $custom_date = date("Y-m-d");
    }

    if ($y) {
        $billno .= date('Y', strtotime($custom_date)) . $separator;
    }

    if ($m) {
        $billno .= date('m', strtotime($custom_date)) . $separator;
    }

    if ($d) {
        $billno .= date('d', strtotime($custom_date)) . $separator;
    }

    $bill_order_no = save_status($table_name, $where);

    $billno .= sprintf("%04d", $bill_order_no);

    return $billno;
}


// Get Final Bill No

function save_status($table_name, $where)
{
    if ($table_name) {
        global $pdo;

        $columns = [
            "count(acc_year) AS save_status"
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $result = $pdo->select($table_details, $where);

        if ($result->status) {

            $res_array = $result->data[0]['save_status'] + 1;

        } else {
            print_r($result);
            $res_array = uniqid() . rand(10000, 99999) . "Error";
        }

        return $res_array;
    }
}

// Permissions Extract From user_screen_action Table 

$perm_columns = [
    'variable_name',
    'is_active',
    'unique_id'
];
$perm_table = 'user_screen_actions';
$perm_table_details = [
    $perm_table,
    $perm_columns
];
$perm_where = '';
$result_obj = $pdo->select($perm_table_details, $perm_where);

if ($result_obj->status) {
    $status = $result_obj->status;
    $data = $result_obj->data;
    $error = "";
    $sql = $result_obj->sql;

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
    $status = $result_obj->status;
    $data = $result_obj->data;
    $error = $result_obj->error;
    $sql = $result_obj->sql;
    $msg = "error";
    exit;
}

// Uniqui ID Geneartor
function unique_id($prefix = "")
{

    $unique_id = uniqid() . rand(10000, 99999);

    if ($prefix) {
        $unique_id = $prefix . $unique_id;
    }

    return $unique_id;
}

function user_permission($permission_id = "", $folder_name = "")
{

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

function menu_permission($user_type_id = "")
{

    $return_arr = [
        "main_screens" => "",
        "sections" => "",
        "screens" => ""
    ];

    if (($user_type_id)) {

        global $pdo;

        $table_user_permission = "user_screen_permission";

        $select_where = [
            "user_type" => $user_type_id,

        ];

        $screen_columns = [
            // "GROUP_CONCAT(main_screen_unique_id) AS main_screens",
            // "GROUP_CONCAT(section_unique_id) AS sections",
            "GROUP_CONCAT(DISTINCT  screen_unique_id) AS screens"
        ];

        $table_details = [
            $table_user_permission,
            $screen_columns
        ];

        $group_by = " screen_unique_id ";

        $screen_result = $pdo->select($table_details, $select_where, "", "", "", "", $group_by);

        if ($screen_result->status) {
            $screen_result_data = $screen_result->data;

            $return_arr["screens"] = array_implode($screen_result_data);
        } else {
            print_r($screen_result);
            echo "Menu Permission Error";
            exit;
        }

        $section_columns = [
            "GROUP_CONCAT(DISTINCT  section_unique_id) AS sections"
        ];

        $table_details = [
            $table_user_permission,
            $section_columns
        ];

        $group_by = " section_unique_id ";

        $section_result = $pdo->select($table_details, $select_where, "", "", "", "", $group_by);

        if ($section_result->status) {
            $section_result_data = $section_result->data;

            $return_arr["sections"] = array_implode($section_result_data);
        } else {
            print_r($section_result);
            echo "Section Permission Error";
            exit;
        }

        $main_screen_columns = [
            "GROUP_CONCAT(DISTINCT  main_screen_unique_id) AS main_screens"
        ];

        $table_details = [
            $table_user_permission,
            $main_screen_columns
        ];

        $group_by = " main_screen_unique_id ";

        $main_screen_result = $pdo->select($table_details, $select_where, "", "", "", "", $group_by);

        if ($main_screen_result->status) {
            $main_screen_result_data = $main_screen_result->data;

            $return_arr["main_screens"] = array_implode($main_screen_result_data);
            ;
        } else {
            print_r($main_screen_result);
            echo "Section Permission Error";
            exit;
        }
    }

    return $return_arr;
}

function array_implode($value_arr = "")
{

    $return_arr = [];

    if (is_array($value_arr)) {

        foreach ($value_arr as $arr_key => $arr_value) {

            $return_arr[] = array_values($arr_value)[0];

        }

    }

    return $return_arr;
}

function folder_permission($folder_name = "")
{

}

function acc_year()
{
    $acc_year = '';
    $curr_year = date("Y");

    $today = strtotime(date("d-m-Y"));
    $end_date = strtotime("31-03-" . $curr_year);
    $start_date = strtotime("01-04-" . $curr_year);

    if ($today >= $start_date) {
        $next_year = $curr_year + 1;
        $acc_year = $curr_year . "-" . $next_year;
    } else if ($today <= $end_date) {
        $previous_year = $curr_year - 1;
        $acc_year = $previous_year . "-" . $curr_year;
    }

    return $acc_year;

}

function btn_add($add_link = "")
{
    $final_str = '<a href="' . $add_link . '"><button type="button" class="btn btn-primary waves-effect waves-light flaot-btn" id="add_btn"><i class="mdi mdi-plus-circle-multiple"></i> Add New</button></a>';

    return $final_str;
}

function btn_download($folder_name = "", $unique_id = "", $bill_no = "", $file_name = "", $prefix = "", $suffix = "", $checkbox_value = "")
{

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '&checkbox=' . $checkbox_value . '"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-download-circle-outline"></i> </button></a>';

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '&checkbox=' . $checkbox_value . '"><i class="mdi mdi-download-circle-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i> </a>';

    return $final_str;
}

// function btn_download($folder_name = "", $unique_id = "", $bill_no = "", $file_name = "", $prefix = "", $suffix = "", $value = 0) {
//     if ($value == 1) {
//         $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '">
//                         <i class="mdi mdi-download-circle-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i> Download
//                       </a>';
//     } else {
//         $final_str = ''; // Return empty string if value is 0
//     }
//     return $final_str;
// }



function btn_download_inv($folder_name = "", $unique_id = "", $bill_no = "", $file_name = "", $prefix = "", $suffix = "")
{

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-download-circle-outline"></i> </button></a>';

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '"><i class="mdi mdi-download-circle-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i> </a>';

    return $final_str;
}
function btn_cancel($list_link = "")
{
    $final_str = '<a href="' . $list_link . '"><button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button></a>';

    return $final_str;
}
function btn_cancel_dar($list_link = "", $date)
{
    $final_str = '<a href="index.php?file=day_attendance_report/list&date=' . $date . ' "><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2" >Cancel</button></a>';

    return $final_str;
}

function btn_cancel_po($list_link = "", $unique_id)
{
    // $final_str = '<a href="index.php?file=po_form/po_cancel&unique_id='.$unique_id.'" id="btn_cancel"><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2" >Cancel</button></a>';
    $final_str = '<a href="index.php?file=po_form/po_cancel&unique_id=' . $unique_id . '" id="btn_cancel"
    class="waves-effect waves-light float-right ml-2 d-inline-flex align-items-center justify-content-center action-icon"
    style="    width: 21.3px; height: 21.5px; padding: 0; background-color: red; border-radius: 20px; color: white;"
    title="Cancel">
    <i class="mdi mdi-cancel" style="font-size: 16px; margin-top: 0.5px;"></i>
</a>';

    return $final_str;
}
function btn_createupdate($folder_name = "", $unique_id = "", $btn_text, $prefix = "", $suffix = "_cu", $custom_class = "")
{
    $final_str = '<button type="button" class="btn btn-success waves-effect waves-light createupdate_btn  ' . $custom_class . '" onclick="' . $folder_name . $suffix . '(\'' . $unique_id . '\')">' . $btn_text . '</button>';

    return $final_str;
}
function btn_createupdate_dar($folder_name = "", $unique_id = "", $btn_text, $date, $prefix = "", $suffix = "_cu", $custom_class = "")
{
    $final_str = '<button type="button" class="btn btn-asgreen btn-rounded waves-effect waves-light float-right createupdate_btn  ' . $custom_class . '" onclick="' . $folder_name . $suffix . '(\'' . $unique_id . '\',\'' . $date . '\',\'day_attendance_report\')">' . $btn_text . '</button>';

    return $final_str;
}
// update option foe super admin
function btn_update($folder_name = "", $unique_id = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '" id="update_btn" class="action-icon"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function btn_matview($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '" id="btn_veiw" class="action-icon"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;

}

// invoice_no
function btn_update_dispatch_pending($folder_name = "", $unique_id = "", $consignee_unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&consignee_unique_id=' . $consignee_unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function update_dispatch_pending_btn($folder_name = "", $unique_id = "", $consignee_unique_id = "", $dc_number = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&consignee_unique_id=' . $consignee_unique_id . '&dc_no=' . $dc_number . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function btn_update_dispatch($folder_name = "", $unique_id = "", $consignee_unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&consignee_unique_id=' . $consignee_unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function dispatch_transit_update_btn($folder_name = "", $unique_id = "", $consignee_unique_id = "", $dc_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&consignee_unique_id=' . $consignee_unique_id . '&dc_no=' . $dc_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function dispatch_delivery_update_btn($folder_name = "", $unique_id = "", $consignee_unique_id = "", $dc_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/delivery";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&consignee_unique_id=' . $consignee_unique_id . '&dc_no=' . $dc_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function consignee_details_view_btn($folder_name = "", $batch_id = "", $count = "", $form_main_unique_id = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');

    // Construct the target file path
    $menu_screen = $folder_name . "/consigneedetails";

    // Optionally encrypt values if needed
    // $file_name = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    // $enc_unique_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // Generate the HTML link
    $final_str = '<a href="index.php?file=' . $menu_screen .
        '&batch_id=' . $batch_id . '&form_main_unique_id=' . $form_main_unique_id .
        '" class="consignee-view-btn" title="View Consignee Details">' .
        '<span class="badge bg-primary count-badge" style="font-size: 15px;"  style="cursor:pointer;">' . $count . '</span>' .
        '</a>';

    return $final_str;
}


function btn_update_2($folder_name = "", $unique_id = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/form1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

// function btn_update_1($folder_name = "",$unique_id = "", $prefix = "",$suffix = "",$date = "",$form = "") {
//     $password = project_env('APP_ENCRYPTION_PASSWORD');
//     $enc_method = 'aes-256-cbc';
//     $enc_password = substr(hash('sha256', $password, true), 0, 32);
//     $enc_iv = project_env('APP_ENCRYPTION_IV');


//     $menu_screen            = $folder_name."/update";
//     // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

//     // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

//     $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


//     return $final_str;
// }


// update for users
function btn_update1($folder_name = "", $unique_id = "", $dc_number = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update_1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';



    // $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function btn_update_1($folder_name = "", $unique_id = "", $bill_no = "", $invoice_no = "", $ins_unique_id = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '&invoice_no=' . $invoice_no . '&ins_unique_id=' . $ins_unique_id . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function btn_update_4($folder_name = "", $unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}
function btn_update_5($folder_name = "", $consignee_unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&consignee_unique_id=' . $consignee_unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}
// update for users
function btn_update_invoice($folder_name = "", $unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

// installation

function btn_update_install($folder_name = "", $unique_id = "", $dc_number = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/create1";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
    // $final_str='<a href="index.php?file=installation/create1&unique_id='.$value['consignee_unique_id'].'&invoice_no='.$invoice_no.'" ><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';


    return $final_str;
}


// elcot entry


function btn_update_elcot($folder_name = "", $unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
    // $final_str='<a href="index.php?file=installation/create1&unique_id='.$value['consignee_unique_id'].'&invoice_no='.$invoice_no.'" ><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';


    return $final_str;
}


function btn_create($folder_name = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    // $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update&unique_id='.$unique_id.'"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-square-edit-outline"></i></button></a>';

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/create&date=' . $date . '&form=' . $form . '"><i class="mdi mdi mdi-shape-square-plus mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function btn_view($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '" id="btn_veiw"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_batch($folder_name = "", $unique_id = "", $prefix = "", $suffix = "", $batch_id = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . ' &batch_id=' . $batch_id . '" id="btn_veiw"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}
// function btn_view_stk($folder_name = "",$unique_id = "", $prefix = "",$suffix = "") {

//     $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/view&unique_id='.$unique_id.'" id="btn_veiw"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


//     return $final_str;
// }

function btn_view1($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}


function btn_delete($folder_name = "", $unique_id = "")
{
    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<a href="#" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete mdi-24px waves-effect waves-light text-danger"></a>';

    $final_str = '<a href="#" onclick="' . $folder_name . '_delete(\'' . $unique_id . '\')" id="delete_btn" class="action-icon"><i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></a>';

    return $final_str;
}

function btn_delete_pro($folder_name = "", $unique_id = "", $form_main_unique_id = "")
{
    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete"></i></button>';

    // $final_str = '<a href="#" onclick="'.$folder_name.'_delete(\''.$unique_id.'\')"><i class="mdi mdi-delete mdi-24px waves-effect waves-light text-danger"></a>';

    $final_str = '<a href="#" onclick="' . $folder_name . '_delete(\'' . $unique_id . '\',\'' . $form_main_unique_id . '\')" id="delete_btn" class="action-icon"><i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></a>';

    return $final_str;
}

function btn_call_update($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{
    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/update&is_phone=1&unique_id=' . $unique_id . '"><i class="mdi mdi-phone-in-talk  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-warning"></i></a>';
    // $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update&is_phone=1&unique_id='.$unique_id.'"><img src="img/start.png" width="27" height="27" alt="Start Call"></a>';

    return $final_str;
}

function btn_call_start($customer_id = "", $followup_id = "")
{
    $final_str = '<a href="javascript:void(0);" onclick="start_call(\'' . $customer_id . '\',\'' . $followup_id . '\')"><i class="mdi mdi-play-circle  mdi-24px waves-effect waves-light mt-n2 mb-n2 ml-2 text-primary"></i></a>';
    $final_str = '<a href="javascript:void(0);" onclick="start_call(\'' . $customer_id . '\',\'' . $followup_id . '\')"><img src="img/start.png" width="27" height="27" alt="Start Call" class="ml-2"></a>';

    return $final_str;
}

function btn_map($latitude = "", $longitude = "")
{

    $def_latitude = "13.0456605";
    $def_longitude = "80.2086916";

    $final_str = '<a target="_blank" href="https://www.google.com/maps/dir/?api=1&origin=' . $def_latitude . "," . $def_longitude . '&destination=' . $latitude . ',' . $longitude . '"><i class="mdi mdi-map-marker mdi-24px waves-effect waves-light mt-n2 mb-n2 text-primary"></i></a>';

    return $final_str;
}

function btn_print($folder_name = "", $unique_id = "", $file_name = "", $prefix = "", $suffix = "")
{

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '"><button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-printer"></i></button></a>';

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '"><i class="mdi mdi-printer mdi-24px waves-effect waves-light mt-n2 mb-n2 mr-1 text-success"></i></a>';

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

function btn_print_in_list($folder_name = "", $unique_id = "", $file_name = "", $prefix = "", $suffix = "", $content = '<button type="button" class="btn btn-info btn-rounded waves-effect waves-light float-right"><i class="mdi mdi-printer mdi-16px waves-effect waves-light text-white"></i></button>')
{

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '">' . $content . '</a>';

    return $final_str;
}

function btn_print_in_form($folder_name = "", $unique_id = "", $file_name = "", $prefix = "", $suffix = "")
{

    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '"><button type="button" class="btn btn-info btn-rounded waves-effect waves-light float-right mr-2"><i class="mdi mdi-printer mdi-16px waves-effect waves-light text-white">' . $file_name . '</i></button></a>';

    return $final_str;
}

function btn_approval_print($folder_name = "", $unique_id = "", $sub_unique_id = "", $file_name = "", $prefix = "", $suffix = "")
{
    $final_str = '<a target="_blank" href="index.php?file=' . $prefix . $folder_name . $suffix . '/' . $file_name . '&unique_id=' . $unique_id . '&sub_unique_id=' . $sub_unique_id . '"><button type="button" class="btn btn-warning  btn-xs btn-rounded waves-effect waves-light mr-1"><i class="mdi mdi-lead-pencil"></i></button></a>';

    return $final_str;
}



function btn_edit($folder_name = "", $unique_id = "")
{
    $final_str = '<button type="button" class="btn btn-asgreen btn-xs btn-rounded waves-effect waves-light " onclick="' . $folder_name . '_edit(\'' . $unique_id . '\')"><i class="ri-pencil-line"></i></button>';
    // mdi mdi-square-edit-outline
    $final_str = '<a href="#" onclick="' . $folder_name . '_edit(\'' . $unique_id . '\')"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

    return $final_str;
}

function btn_edit1($folder_name = "", $unique_id = "")
{
    $final_str = '<button type="button" class="btn btn-asgreen btn-xs btn-rounded waves-effect waves-light " onclick="' . $folder_name . '_edit(\'' . $unique_id . '\')"><i class="mdi mdi-square-edit-outline"></i></button>';

    $final_str = '<a href="#" onclick="' . $folder_name . '_edit(\'' . $unique_id . '\')"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

    return $final_str;
}



// Datatables Total Records Count Function
function total_records()
{
    global $pdo;

    $total_records = 0;
    $sql = "SELECT FOUND_ROWS() as total";
    $result = $pdo->query($sql);
    if ($result->status) {
        $total = $result->data[0]["total"];
    }

    return $total;
}

// Convert Original folder Name to Display Name
function disname($name = "")
{
    if ($name) {
        $name = explode("_", $name);
        $name = array_map("ucfirst", $name);
        $name = implode(" ", $name);

        return $name;
    } else {
        return "Empty Title";
    }
}

// Continents Function
function continent($unique_id = "", $columns = "")
{
    global $pdo;

    $where = [];
    $table = "continents";

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

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        // $where = " WHERE continent_id = '".$continent_id."' ";
        $where = [];
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



function select_option($options = [], $description = "", $is_selected = [], $is_disabled = [])
{

    $option_str = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }
        foreach ($options as $key => $value) {

            $value = array_values($value);
            $selected = "";
            $disabled = "";

            if (is_array($is_selected) and in_array($value[0], $is_selected)) {
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {

                $selected = " selected='selected' ";
            }

            if (is_array($is_disabled) and in_array($value[0], $is_disabled)) {
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
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $value[0] . "'" . $data_attribute . $selected . $disabled . ">" . $value[1] . "</option>";
        }
    }

    return $option_str;
}



function select_option_3($options = [], $description = "", $is_selected = [], $is_disabled = [])
{

    $option_str = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }
        foreach ($options as $key => $value) {

            $value = array_values($value);
            $selected = "";
            $disabled = "";

            if (is_array($is_selected) and in_array($value[0], $is_selected)) {
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {

                $selected = " selected='selected' ";
            }

            if (is_array($is_disabled) and in_array($value[0], $is_disabled)) {
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
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $value[1] . "'" . $data_attribute . $selected . $disabled . ">" . $value[1] . "</option>";
        }
    }

    return $option_str;
}

function select_option_4($options = [], $description = "", $is_selected = [], $is_disabled = [])
{

    $option_str = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }
        foreach ($options as $key => $value) {

            $value = array_values($value);
            $selected = "";
            $disabled = "";

            if (is_array($is_selected) and in_array($value[0], $is_selected)) {
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {

                $selected = " selected='selected' ";
            }

            if (is_array($is_disabled) and in_array($value[0], $is_disabled)) {
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
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $value[1] . "'" . $data_attribute . $selected . $disabled . ">" . $value[1] . "</option>";
        }
    }

    return $option_str;
}

function select_option3($options = [], $description = "", $is_selected = [], $is_disabled = [])
{
    $option_str = "<option value='' disabled>No Options to Select</option>";
    if ($options) {
        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }

        $counter = 1;
        foreach ($options as $key => $value) {
            $value = array_values($value); // ensure indexed

            $selected = (is_array($is_selected) && in_array($value[0], $is_selected)) || $is_selected == $value[0]
                ? " selected='selected' "
                : "";

            $disabled = (is_array($is_disabled) && in_array($value[0], $is_disabled)) || $is_disabled == $value[0]
                ? " disabled='disabled' "
                : "";

            // Optional: data attribute
            $data_attribute = isset($value[2]) ? " data-extra='" . htmlspecialchars($value[2], ENT_QUOTES) . "'" : "";

            // Display con_branch as text (from $value[3])
            $display_text = isset($value[3]) ? $value[3] : "Unknown";

            $option_str .= "<option value='" . $value[0] . "'" . $data_attribute . $selected . $disabled . ">" . $counter . ". " . $display_text . "</option>";
            $counter++;
        }
    }

    return $option_str;
}

// jaya
function select_option2($options = [], $description = "", $is_selected = [], $is_disabled = [])
{

    $option_str = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }

        $counter = 1;
        foreach ($options as $key => $value) {

            $value = array_values($value);
            $selected = "";
            $disabled = "";

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
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $value[0] . "'" . $data_attribute . $selected . $disabled . ">" . $counter . ". " . $value[1] . "</option>";
            $counter++;
        }
    }

    return $option_str;
}
// end
function select_option1($options = [], $description = "", $is_selected = [], $is_disabled = [])
{

    $option_str = "<option value='' disabled>No Options to Select</option>";

    $data_attribute = "";

    if ($options) {

        // $option_str     = "<option value=''>Select</option>";

        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }
        foreach ($options as $key => $value) {

            $value = array_values($value);
            $selected = "";
            $disabled = "";

            if (is_array($is_selected) and in_array($value[0], $is_selected)) {
                $selected = " selected='selected' ";
            } elseif ($is_selected == $value[0]) {

                $selected = " selected='selected' ";
            }

            if (is_array($is_disabled) and in_array($value[0], $is_disabled)) {
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
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $value[1] . "'" . $data_attribute . $selected . $disabled . ">" . $value[1] . "</option>";
        }
    }

    return $option_str;
}


function invoice_select_option($options = [], $description = "", $is_selected = [], $is_disabled = [])
{
    $option_str = "<option value='' disabled>No Options to Select</option>";
    $data_attribute = "";

    if ($options) {
        if ($description) {
            $option_str = "<option value='' selected>" . $description . "</option>";
        }

        foreach ($options as $key => $value) {
            $invoice_value = $value['invoice_no'] ?? '';
            $invoice_label = $value['invoice_no'] ?? '';

            $selected = (is_array($is_selected) && in_array($invoice_value, $is_selected)) || $is_selected == $invoice_value ? " selected='selected' " : "";
            $disabled = (is_array($is_disabled) && in_array($invoice_value, $is_disabled)) || $is_disabled == $invoice_value ? " disabled='disabled' " : "";

            if (strpos($invoice_label, "_")) {
                $invoice_label = disname($invoice_label);
            } else {
                $invoice_label = ucfirst($invoice_label);
            }

            if (isset($value[2])) {
                $data_attribute = "data-extra='" . $value[2] . "'";
            }

            $option_str .= "<option value='" . $invoice_value . "' $data_attribute $selected $disabled>$invoice_label</option>";
        }
    }

    return $option_str;
}


function active_status($is_active_val = 1)
{
    $option_str = "";
    $is_active = "";
    $is_inactive = "";

    if ($is_active_val == 1) {
        $is_active = " selected = 'selected' ";
    } else {
        $is_inactive = " selected = 'selected' ";
    }

    $option_str = "<option value='1'" . $is_active . ">Active</option>";
    $option_str .= "<option value='0'" . $is_inactive . ">In Active</option>";

    return $option_str;
}

// Active and In Active Show in Data Table
function is_active_show($is_active = 0)
{
    $act_str = "<span style='color: red'>In Active</span>";

    if ($is_active) {
        $act_str = "<span style='color: green'>Active</span>";
    }

    return $act_str;
}




// Screen Type Function
function screen_type($unique_id = "")
{
    global $pdo;

    $table_name = "user_screen_type";
    $where = [];
    $table_columns = [
        "unique_id",
        "type_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $screen_types = $pdo->select($table_details, $where);


    // print_r($screen_types);

    if ($screen_types->status) {
        return $screen_types->data;
    } else {
        print_r($screen_types);
        return 0;
    }
}

function engineer_name_options($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "user_type_unique_id"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $engineer_name = $pdo->select($table_details, $where, '', '', '');
    //print_r($main_screens);
    if ($engineer_name->status) {
        return $engineer_name->data;
    } else {
        print_r($engineer_name);
        return 0;
    }
}

function engineer_type($unique_id = "")
{
    global $pdo;
    // print_r($unique_id);
    $table_name = "vendor_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', '');
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}
function engineer_name_pavi($unique_id = "")
{
    global $pdo;

    $table_name = "engineer_name_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        // "engineer_name",
        "(select staff_name from user where user.unique_id=$table_name.engineer_name)AS engineer_name",
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', '');
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}


function engineer_type_pavi($unique_id = "")
{
    global $pdo;
    // print_r($unique_id);
    $table_name = "vendor_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', '');
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

function vendor_names($unique_id = "")
{
    global $pdo;
    // print_r($unique_id);
    $table_name = "vendor_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'name ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', $order_by);
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}


function vendor_company_name($unique_id = "")
{
    global $pdo;
    // print_r($unique_id);
    $table_name = "vendor_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "company_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'company_name ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', $order_by);
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}



function vendor_generate_invoiceid($state_code)
{
    global $pdo;

    $table_name = "invoice_verfication_table";
    $table_columns = [
        "MAX(veninvid) AS latest_id"
    ];

    // No WHERE condition needed for MAX
    $where = [];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // Fetch latest vendorinvoiceid
    $result = $pdo->select($table_details, $where);

    // Check result and calculate next number
    if ($result->status && !empty($result->data[0]['latest_id'])) {
        $latestId = $result->data[0]['latest_id'];

        // Extract number from the latest vendor ID (after last '-')
        $lastNum = (int) substr($latestId, strrpos($latestId, '-') + 1);
        $newNum = $lastNum + 1;
    } else {
        // First entry → start from 1
        $newNum = 1;
    }

    // Format new Vendor ID
    $newVendorId = 'VEN-' . strtoupper($state_code) . '-' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    // Return value (echo after return will never run)
    return $newVendorId;
}


function vendor_generate_accbillid($state_code)
{
    global $pdo;

    $table_name = "vendor_payment_details";
    $table_columns = [
        "MAX(accountbillid) AS latest_id"
    ];

    // No WHERE condition needed for MAX
    $where = [];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // Fetch latest vendorinvoiceid
    $result = $pdo->select($table_details, $where);

    // Check result and calculate next number
    if ($result->status && !empty($result->data[0]['latest_id'])) {
        $latestId = $result->data[0]['latest_id'];

        // Extract number from the latest vendor ID (after last '-')
        $lastNum = (int) substr($latestId, strrpos($latestId, '-') + 1);
        $newNum = $lastNum + 1;
    } else {
        // First entry → start from 1
        $newNum = 1;
    }

    // Format new Vendor ID
    $newVendorId = 'VEN-' . strtoupper($state_code) . '-' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    // Return value (echo after return will never run)
    return $newVendorId;
}







function user_id_name($emp_id = "")
{
    // PRINT_R($unique_id);
    // PRINT_R($emp_id);

    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "unique_id",
        "staff_id"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    // if ($emp_id) {
    //     // $where = " WHERE country_id = '".$country_id."' ";
    //     $where["staff_id"] = $emp_id;
    // }

    // if ($unique_id) {
    //     $table_details = $table_name;
    //     $where         = [
    //         "unique_id" => $unique_id,
    //         "user_type_unique_id"=>'66a3334baa22534432',


    //     ];
    // }
    // if($emp_id) {
    // $where ='user_type_unique_id="66a3334baa22534432 " ';


    $where = "is_delete = '0'";

    if ($emp_id) {
        $where .= "AND unique_id ='$emp_id'";

    }
    // AND unique_id="'.$emp_id.'"
    // }
// PRINT_R($where);
    $user = $pdo->select($table_details, $where);

    // print_r($user);

    if ($user->status) {
        return $user->data;
    } else {
        print_r($user);
        return 0;
    }
}


function user_engineer_name($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "staff_id"
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    // if ($unique_id) {

    //     $where              = [];
    //     $where["unique_id"] = $unique_id;
    // }
    $where = 'user_type_unique_id="66a3334baa22534432"';

    // if()
// print_r($where);
    // $order_by  = 'order_no ASC';

    $user = $pdo->select($table_details, $where, '', '', '');
    // print_r($user);
    if ($user->status) {
        return $user->data;
    } else {
        print_r($user);
        return 0;
    }
}


function usertype_engineer_name($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "staff_id"
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    // if ($unique_id) {

    //     $where              = [];
    //     $where["unique_id"] = $unique_id;
    // }
    $where = 'user_type_unique_id="66a3334baa22534432"';

    // if()
// print_r($where);
    // $order_by  = 'order_no ASC';

    $user = $pdo->select($table_details, $where, '', '', '');
    // print_r($user);
    if ($user->status) {
        return $user->data;
    } else {
        print_r($user);
        return 0;
    }
}




// Main Screen Function
function main_screen($unique_id = "")
{
    global $pdo;

    $table_name = "user_screen_main";
    $where = [];
    $table_columns = [
        "unique_id",
        "screen_main_name",
        "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'order_no ASC';

    $main_screens = $pdo->select($table_details, $where, '', '', $order_by);
    //print_r($main_screens);
    if ($main_screens->status) {
        return $main_screens->data;
    } else {
        print_r($main_screens);
        return 0;
    }
}

// Main Screen Function
function section_name($unique_id = "", $main_screen_id = "")
{
    global $pdo;

    $table_name = "user_screen_sections";
    $where = [];
    $table_columns = [
        "unique_id",
        "section_name",
        "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    $order_by = [
        "order_no"
    ];

    if ($unique_id) {

        $where = [];
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
function user_screen($unique_id = "", $screen_section_id = "")
{
    global $pdo;

    $table_name = "user_screen";
    $where = [];
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

    $where = [
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

        $where = [];
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
function user_actions($unique_id = "")
{
    global $pdo;

    $table_name = "user_screen_actions";
    $where = [];
    $table_columns = [
        "unique_id",
        "action_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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
function user_type($unique_id = "")
{

    global $pdo;

    $table_name = "user_type";
    $where = [];
    $table_columns = [
        "unique_id",
        "user_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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
function staff_name($unique_id = "")
{
    global $pdo;

    $table_name = "staff";
    $where = [];
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

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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
function staff_ceo_name($unique_id = "")
{
    global $pdo;

    $table_name = "staff";
    $where = [];
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

    $where = [
        "is_active" => 1,
        "designation_unique_id" => "5ff5d3423713a59778",
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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


//operation team member
function inhouse($unique_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = [];
    $table_columns = [
        "unique_id",
        "staff_name",
        "staff_id"
        // "icon_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];


    $order_by = 'staff_name ASC';




    $where = 'user_type_unique_id="65efd97b4df4040205"';


    $user = $pdo->select($table_details, $where, '', '', $order_by);

    if ($user->status) {
        return $user->data;
    } else {
        print_r($user);
        return 0;
    }
}




// BID Type Function
function staff_director_name($unique_id = "")
{
    global $pdo;

    $table_name = "staff";
    $where = [];
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

    $where = [
        "is_active" => 1,
        "designation_unique_id" => "5ff5d3585747568896",
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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




function btn_approve($folder_name = "", $unique_id = "", $approved_status = "")
{
    if ($approved_status) {
        $final_str = '<i class="mdi mdi-check btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light"></i>';
    } else {
        $final_str = '<i class=" mdi mdi-24px mdi-alert-circle-outline" style = "color :#e6f22b;"></i>';
    }

    return $final_str;
}

function btn_approve_status($folder_name = "", $unique_id = "", $approved_status = "")
{
    if ($approved_status == '0') {
        $final_str = '<button type="button" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    } else {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }

    return $final_str;
}

function btn_bid_approve_status($folder_name = "", $unique_id = "", $approved_status = "", $approval_stage = "")
{

    $final_str = "";

    if ($approved_status == '0') {
        $final_str = '<button type="button" onclick="status_show(\'pending\',\'' . $unique_id . '\',\'' . $approval_stage . '\')" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation-thick"></i></button></a>';
    } else if ($approved_status == '1') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    } else if ($approved_status == '2') {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    } else if ($approved_status == '3') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }

    return $final_str;
}

function btn_expense_approve_status($unique_id = "", $approved_status = "", $approval_type = "")
{

    $final_str = "";

    if ($approved_status == '0') {
        $final_str = '<button type="button" onclick="expense_status_show(\'pending\',\'' . $unique_id . '\',\'' . $approval_type . '\')" class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation-thick"></i></button></a>';
    } else if ($approved_status == '1') {
        $final_str = '<button type="button" onclick="expense_status_show(\'approve\',\'' . $unique_id . '\',\'\')" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    } else if ($approved_status == '2') {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';
    } else if ($approved_status == '3') {
        $final_str = '<button type="button" class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';
    }

    return $final_str;
}

function btn_approval($folder_name = "", $unique_id = "", $approved_status = "")
{

    if (($approved_status == 'Cancel') || ($approved_status === 2)) {

        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-window-close"></i></button></a>';

    } else if (($approved_status == 'Approved') || ($approved_status === 1)) {

        $final_str = '<button type="button"  class="btn btn-asgreen  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-check"></i></button></a>';

    } else {
        $final_str = '<button type="button"  class="btn btn-danger  btn-xs btn-rounded waves-effect waves-light" ><i class="mdi mdi-exclamation"></i></button></a>';
    }

    return $final_str;
}

// BID Type Function
function blood_group($unique_id = "")
{
    global $pdo;

    $table_name = "blood_group";
    $where = [];
    $table_columns = [
        "unique_id",
        "blood_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where = [];
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


// function moneyFormatIndia($num) {
//     $explrestunits = "";
//     $amount     = explode('.', $num);
//     $num        = $amount[0];
//     $decimal    = 0;
//     if (count($amount)==2) {
//         $decimal = $amount[1];
//     }
//     if(strlen($num)>3) {
//         $lastthree = substr($num, strlen($num)-3, strlen($num));
//         $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
//         $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
//         $expunit = str_split($restunits, 2);
//         for($i=0; $i<sizeof($expunit); $i++) {
//             // creates each of the 2's group and adds a comma to the end
//             if($i==0) {
//                 $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
//             } else {
//                 $explrestunits .= $expunit[$i].",";
//             }
//         }
//         $thecash = $explrestunits.$lastthree;
//     } else {
//         $thecash = $num;
//     }

//     // $decimal = number_format($decimal, 2, '.', '');
//     // $decimal = explode(".",$decimal)[1];

//     // return $thecash.".".$decimal;
//     $decimal = number_format($decimal, 0, '.', '');
//     $decimal = explode(".",$decimal)[1];

//     return $thecash.$decimal; // writes the final format where $currency is the currency symbol.
// }

function moneyFormatIndia($num)
{
    $explrestunits = "";
    $amount = explode('.', $num);
    $num = $amount[0];
    $decimal = isset($amount[1]) ? $amount[1] : '00';

    if (strlen($num) > 3) {
        $lastthree = substr($num, -3);
        $restunits = substr($num, 0, -3);
        $restunits = (strlen($restunits) % 2 != 0) ? '0' . $restunits : $restunits;
        $expunit = str_split($restunits, 2);

        foreach ($expunit as $i => $unit) {
            $explrestunits .= ($i == 0) ? (int) $unit . ',' : $unit . ',';
        }
        $formatted = $explrestunits . $lastthree;
    } else {
        $formatted = $num;
    }

    // Ensure 2-digit decimal
    $decimal = str_pad(substr($decimal, 0, 2), 2, '0', STR_PAD_RIGHT);

    return $formatted;
}



// function moneyFormatIndia1($num) {
//     $explrestunits = "";
//     $amount     = explode('.', $num);
//     $num        = $amount[0];
//     $decimal    = "0";  // Default decimal value

//     if (count($amount) == 2) {
//         $decimal = substr($amount[1], 0, 2); // Take only first two digits of decimal part
//         if(strlen($amount[1]) == 1) {
//             $decimal .= "0"; // Add trailing zero if there's only one digit
//         }
//     }

//     if(strlen($num) > 3) {
//         $lastthree = substr($num, strlen($num) - 3, strlen($num));
//         $restunits = substr($num, 0, strlen($num) - 3); // Extract the last three digits
//         $restunits = (strlen($restunits) % 2 == 1) ? "0".$restunits : $restunits; // Add a zero to maintain 2's grouping
//         $expunit = str_split($restunits, 2);
//         for($i = 0; $i < sizeof($expunit); $i++) {
//             // Create each of the 2's group and add a comma to the end
//             if($i == 0) {
//                 $explrestunits .= (int)$expunit[$i].","; // If it's the first value, convert to integer
//             } else {
//                 $explrestunits .= $expunit[$i].",";
//             }
//         }
//         $thecash = $explrestunits.$lastthree;
//     } else {
//         $thecash = $num;
//     }

//     return $thecash.".".$decimal; // Return the final formatted string
// }

// old
// function moneyFormatIndia1($num) {
//     $explrestunits = "";
//     $amount     = explode('.', number_format($num, 2, '.', ''));
//     $num        = $amount[0];
//     $decimal    = $amount[1];

//     if(strlen($num) > 3) {
//         $lastthree = substr($num, strlen($num) - 3, strlen($num));
//         $restunits = substr($num, 0, strlen($num) - 3);
//         $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits;
//         $expunit = str_split($restunits, 2);
//         for($i = 0; $i < sizeof($expunit); $i++) {
//             if($i == 0) {
//                 $explrestunits .= (int)$expunit[$i] . ","; 
//             } else {
//                 $explrestunits .= $expunit[$i] . ",";
//             }
//         }
//         $thecash = $explrestunits . $lastthree;
//     } else {
//         $thecash = $num;
//     }

//     return $thecash . "." . $decimal;
// }


function moneyFormatIndia1($num, $withSymbol = false, $withDecimals = true)
{
    // Convert to float first
    $num = (float) $num;

    // Handle negative numbers
    $sign = ($num < 0) ? '-' : '';
    $num = abs($num);

    // Ensure always 2 decimals or none
    $num = $withDecimals ? sprintf("%.2f", $num) : sprintf("%.0f", $num);

    // Split into integer and decimal parts
    $parts = explode('.', $num);
    $int = $parts[0];
    $dec = $parts[1] ?? '';

    // Apply Indian number system formatting
    if (strlen($int) > 3) {
        $last3 = substr($int, -3);
        $rest = substr($int, 0, -3);
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        $int = $rest . ',' . $last3;
    }

    // Build final string
    $formatted = $sign . $int;
    if ($withDecimals && $dec !== '') {
        $formatted .= '.' . $dec;
    }

    // Add rupee symbol if requested
    if ($withSymbol) {
        $formatted = '₹ ' . $formatted;
    }

    return $formatted;
}
// new
function moneyFormatIndia1_main($num)
{
    $explrestunits = "";
    $num = (int) $num; // Remove decimal completely
    $numStr = (string) $num;

    if (strlen($numStr) > 3) {
        $lastthree = substr($numStr, -3);
        $restunits = substr($numStr, 0, -3);
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits;
        $expunit = str_split($restunits, 2);

        foreach ($expunit as $i => $unit) {
            if ($i == 0) {
                $explrestunits .= (int) $unit . ",";
            } else {
                $explrestunits .= $unit . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $numStr;
    }

    // Wrap in bold tags before returning
    return "<b>" . rtrim($thecash, ",") . "</b>";
}


//without bold value display
function moneyFormatIndia2($num)
{
    $explrestunits = "";
    $num = (int) $num; // Remove decimal completely
    $numStr = (string) $num;

    if (strlen($numStr) > 3) {
        $lastthree = substr($numStr, -3);
        $restunits = substr($numStr, 0, -3);
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits;
        $expunit = str_split($restunits, 2);

        foreach ($expunit as $i => $unit) {
            if ($i == 0) {
                $explrestunits .= (int) $unit . ",";
            } else {
                $explrestunits .= $unit . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $numStr;
    }

    // Wrap in bold tags before returning
    return rtrim($thecash, ",");
}


// GST Name
function tax($unique_id = "")
{
    global $pdo;

    $table_name = "tax";
    $where = [];
    $table_columns = [
        "unique_id",
        "tax_name",
        "tax_value"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where = [];
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
function account_year($unique_id = "")
{
    global $pdo;

    $table_name = "account_year";
    $where = [];
    $table_columns = [
        "unique_id",
        "account_year"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        // "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $where = [];
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
function competitors($unique_id = "")
{
    global $pdo;

    $table_name = "competitor_profile";
    $where = [];
    $table_columns = [
        "unique_id",
        "competitor_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $table_details = $table_name;
        $where = [];
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

function file_upload_extention_lowercase_helper()
{
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
function supplier($unique_id = "")
{
    global $pdo;

    $table_name = "supplier_profile";
    $where = [];
    $table_columns = [
        "unique_id",
        "supplier_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        // $where = " WHERE unique_id = '".$unique_id."' ";
        $where = [];
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
function branch($unique_id = "")
{
    global $pdo;

    $table_name = "company_and_branch_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "branch_name"
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        // $where = " WHERE unique_id = '".$unique_id."' ";
        $table_columns[] = "address";
        $table_columns[] = "country";
        $table_columns[] = "state";
        $table_columns[] = "city";
        $table_columns[] = "pin_code";
        $table_columns[] = "phone_number";
        $table_columns[] = "mobile_number";
        $table_columns[] = "gst_number";
        $table_columns[] = "email_id";
        $table_columns[] = "website";
        $table_columns[] = "radius";
        $table_columns[] = "latitude";
        $table_columns[] = "longitude";
        $where = [];
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


function sublist_insert_update($table_name = "", $data = "", $prefix = "")
{
    global $pdo;
    if ($table_name) {
        foreach ($data as $data_key => $columns) {

            $unique_id = $columns['unique_id'];

            if ($unique_id) {

                unset($columns['unique_id']);

                $update_where = [
                    "unique_id" => $unique_id
                ];

                $action_obj = $pdo->update($table_name, $columns, $update_where);

                // Update Ends
            } else {
                $columns['unique_id'] = $prefix . unique_id();
                // Insert Begins            
                $action_obj = $pdo->insert($table_name, $columns);
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

                print_r($action_obj);
                break;
            }
        }
    } else {
        echo "table name not given";
    }
}

function sublist_delete($table_name = "", $sub_unique_ids = "", $main_unique_id = [])
{

    global $pdo;

    if ($table_name) {

        if (($sub_unique_ids) && (!empty($main_unique_id))) {

            $column_name = array_keys($main_unique_id)[0];
            $column_value = $main_unique_id[$column_name];

            $where = " unique_id NOT IN (" . $sub_unique_ids . ") AND " . $column_name . "  = '" . $column_value . "'";

            $columns = [
                "is_delete" => 1
            ];

            $update_result = $pdo->update($table_name, $columns, $where);

            if ($update_result->status) {

            } else {
                print_r($update_result);
            }
        } else {
            echo "Sub List Delete Status Update Error";
        }

    }
}


function user_name($unique_id = "")
{

    global $pdo;

    $return_result = [
        "user_name" => "",
        "staff_name" => ""
    ];

    if ($unique_id) {
        $table_name = "user";
        $where = [];
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

        $where = [
            "is_active" => 1,
            "is_delete" => 0
        ];

        if ($unique_id) {

            $where = [];

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

function get_user_name($unique_id = "")
{

    global $pdo;

    if ($unique_id) {
        $table_name = "user";
        $where = [];
        $table_columns = [
            "unique_id",
            "staff_name"
        ];

        $table_details = [
            $table_name,
            $table_columns
        ];

        $where = [
            "is_active" => 1,
            "is_delete" => 0
        ];

        if ($unique_id) {

            $where = [];

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
function team_user($user_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = "";
    $table_columns = [
        "unique_id",
        "user_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = "is_delete = 0 AND is_active = 1   AND is_team_head = 0 AND user_name != '" . $user_id . "'";

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
function under_user($user_id = "")
{
    global $pdo;

    $table_name = "user";
    $where = "";
    $table_columns = [
        "unique_id",
        "user_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = "is_delete = 0 AND is_active = 1  AND user_name != '" . $user_id . "'";

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
function under_user_type($user_type = "")
{
    global $pdo;

    $table_name = "user_type";
    $where = "";
    $table_columns = [
        "unique_id",
        "user_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = "is_delete = 0 AND is_active = 1 AND user_type != '" . $user_type . "'";

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
function user_hierarchy($user_id = "", $user_type_id = "", $team_users = false)
{

    global $pdo;

    $table_user = "user";
    $table_user_type = "user_type";

    $return_result = [
        "under_user" => "",
        "under_user_type" => ""
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
                $user_data['under_user'] = '"' . implode('","', explode(",", $user_data['under_user'])) . '",';
            }

            $user_data['under_user'] .= '"' . $user_id . '"';

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
                $user_data['under_user_type'] = '"' . implode('","', explode(",", $user_data['under_user_type'])) . '",';
            }

            $user_data['under_user_type'] .= '"' . $user_type_id . '"';

            $return_result['under_user_type'] = $user_data['under_user_type'];
        } else {
            print_r($user_select);
            exit;
        }
    }

    return $return_result;
}

//datatable search
function mysql_like($search_query = "", $search_term = "")
{

    $return_result = "";

    if ($search_query) {
        switch ($search_term) {
            case "first":
                $return_result = "%" . $search_query;
                break;

            case "last":
                $return_result = $search_query . "%";
                break;

            default:
                // For All result
                $return_result = "%" . $search_query . "%";
                break;
        }
    }

    return $return_result;
}
//expense type function
function expense_type($unique_id = "")
{
    global $pdo;

    $table_name = "expense_type";
    $where = [];
    $table_columns = [
        "unique_id",
        "expense_type"

    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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

function item_unit_decimal($item_id = 0)
{

    $decimal = 0;

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns = [
            "unit_unique_id"
        ];

        $where = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result = $pdo->select($table_details, $where);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            $item_unit = $select_result->data[0];

            if ($item_unit) {

                $item_unit = $item_unit['unit_unique_id'];

                // Get Unit Decimal
                $table_unit = "units";

                $columns_unit = [
                    "decimal_points"
                ];

                $where_unit = [
                    "unique_id" => $item_unit
                ];

                $table_unit_details = [
                    $table_unit,
                    $columns_unit
                ];

                $decimal_select = $pdo->select($table_unit_details, $where_unit);

                if (!($decimal_select->status)) {
                    print_r($decimal_select);
                } else {
                    $decimal = $decimal_select->data[0];

                    $decimal = $decimal['decimal_points'];

                    if (!($decimal)) {
                        $decimal = 0;
                    }
                }
            }
        }
    }

    return $decimal;
}

function item_unit($item_id = 0)
{

    $unit_name = "";

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns = [
            "unit_unique_id"
        ];

        $where = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result = $pdo->select($table_details, $where);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            $item_unit = $select_result->data[0];

            if ($item_unit) {

                $item_unit = $item_unit['unit_unique_id'];

                // Get Unit Decimal
                $table_unit = "units";

                $columns_unit = [
                    "unit_name"
                ];

                $where_unit = [
                    "unique_id" => $item_unit
                ];

                $table_unit_details = [
                    $table_unit,
                    $columns_unit
                ];

                $unit_name_select = $pdo->select($table_unit_details, $where_unit);

                if (!($unit_name_select->status)) {
                    print_r($unit_name_select);
                } else {
                    $unit_name = $unit_name_select->data[0];

                    $unit_name = $unit_name['unit_name'];

                    if (!($unit_name)) {
                        $unit_name = "";
                    }
                }
            }
        }
    }

    return $unit_name;
}

function item_tax1($item_id = 0)
{

    $item_tax_value = "";

    if ($item_id) {
        global $pdo;
        $table_name = "item_names_code";

        $columns = [
            "tax_unique_id"
        ];

        $where = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result = $pdo->select($table_details, $where);

        print_r($select_result);

        if (!($select_result->status)) {
            print_r($select_result);
        } else {
            // print_r($select_result);

            $item_tax = $select_result->data[0];

            if ($item_tax) {

                $item_tax = $item_tax['tax_unique_id'];

                // Get Unit Decimal
                $table_tax = "tax";

                $columns_unit = [
                    "tax_value"
                ];

                $where_unit = [
                    "unique_id" => $item_tax
                ];

                $table_tax_details = [
                    $table_tax,
                    $columns_unit
                ];

                $item_tax_value_select = $pdo->select($table_tax_details, $where_unit);

                print_r($item_tax_value_select);

                if (!($item_tax_value_select->status)) {
                    print_r($item_tax_value_select);
                } else {
                    // print_r($item_tax_value_select);

                    if (!empty($item_tax_value_select->data[0])) {
                        $item_tax_value = $item_tax_value_select->data[0];

                        $item_tax_value = $item_tax_value['tax_value'];

                        if (!($item_tax_value)) {
                            $item_tax_value = 0;
                        }
                    } else {
                        $item_tax_value = 0;
                    }
                }
            }
        }
    }

    return $item_tax_value;
}

function item_tax($item_id = "")
{

    $item_tax_value = 0;

    return 0;

    if ($item_id) {

        global $pdo;

        $table_name = "item_names_code";

        echo $item_id;

        $columns = [
            "(SELECT t.tax_value FROM tax t WHERE t.unique_id = $table_name.tax_unique_id) AS tax_unique_id"
        ];

        $where = [
            "unique_id" => $item_id
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $select_result = $pdo->select($table_details, $where);

        print_r($select_result);
    }
}

function unit_decimal_cal($number_val = 0, $decimal = 0)
{

    $return_result = 0;

    if ($number_val) {
        $return_result = number_format($number_val, $decimal, ".", "");
    }

    return $return_result;
}

function getIndianCurrency(float $number)
{

    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    // return strtoupper(($Rupees ? $Rupees . 'Rupees ' : '') . $paise. " only ");
    return (($Rupees ? $Rupees . 'Rupees ' : '') . " only ");
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

    $team_head_where = [
        "is_delete" => 0,
        "is_team_head" => 1
    ];

    if ($head_id) {
        $team_head_where['unique_id'] = $head_id;
    }

    $team_head_result = $pdo->select($team_head_details, $team_head_where);

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
        $team_members = explode(",", $team_members);
        $team_members = "'" . implode("','", $team_members) . "'";

        $team_members_where = "is_delete = 0 AND unique_id IN (" . $team_members . ")";

        $order_by = " is_team_head DESC";

        $team_members_result = $pdo->select($team_members_details, $team_members_where, '', '', $order_by);

        if ($team_members_result->status) {
            return $team_members_result->data;
        } else {
            print_r($team_members_result);
        }
    }

    return [];
}

function week_range($week, $year)
{

    $dates = [];
    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7 * $week) + 1 - $day) * 24 * 3600;
    $dates["from"] = date('Y-n-j', $time);
    $time += 6 * 24 * 3600;
    $dates["to"] = date('Y-n-j', $time);

    return $dates;
}

function datatable_sorting($column = 0, $direction = "ASC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}



function datatable_sorting_po($column = 8, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}



// MYTHILI
function datatable_sorting_inv($column = 9, $direction = "DESC", $columns_array = [])
{
    $order_by = "";

    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_elcot($column = 15, $direction = "ASC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_ac($column = 12, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}
function datatable_sorting_mq($column = 18, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}
// MYTHILI
function datatable_sorting_elcot1($column = 12, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_ac1($column = 12, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_ins1($column = 12, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}


function datatable_sorting_invoice($column = 9, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}

function datatable_sorting_inv2($column = 9, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}


function datatable_sorting_ins2($column = 7, $direction = "DESC", $columns_array = [])
{
    $order_by = "";
    if (!empty($columns_array)) {
        if ($column) {

            $is_found = strripos($columns_array[$column], " AS ");

            if ($is_found) {
                $as_column = substr($columns_array[$column], $is_found + 3);
            } else {
                $as_column = false;
            }

            if ($as_column) {
                $order_by = $as_column . " " . $direction;
            } else {
                $order_by = $columns_array[$column] . " " . $direction;
            }
        }
    }
    return $order_by;
}
function datatable_searching($search_query = '', $columns_array = [])
{
    $search_string = "";

    if ($search_query) {
        if (!empty($columns_array)) {
            // Remove AS in Subquery in $columns_array
            $temp_arr = [];
            foreach ($columns_array as $col_key => $col_value) {

                $is_found = strripos($col_value, " AS ");

                if ($is_found) {
                    $as_column = substr($col_value, 0, $is_found);
                } else {
                    $as_column = $col_value;
                }
                $temp_arr[] = $as_column . " LIKE '%" . $search_query . "%' ";
            }

            unset($temp_arr[count($temp_arr) - 1]); // Unique ID Endry Disable
            unset($temp_arr[0]); // S.No Search Disable
            $search_string = implode(" OR ", $temp_arr);
        }
    }
    return $search_string;
}






function zone_name($unique_id = "")
{

    global $pdo;

    $table_name = "zone_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "zone_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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


function department_creation($unique_id = "")
{

    global $pdo;

    $table_name = "department_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "department_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where, '', '', $order_by);

    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}


// department


function department_creation_table($unique_id = "")
{

    global $pdo;

    $table_name = "department_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "department"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $order_by = 'department ASC';

    $department_name = $pdo->select($table_details, $where, '', '', $order_by);
    //    print_r($department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
// po numbers
function po_numers_pop($unique_id = "")
{
    // echo $unique_id;
    global $pdo;

    $table_name = "po_form";
    $where = [];
    $table_columns = [
        "unique_id",
        "po_num",
        "get_department_name(department) as department"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    // if ($unique_id) {

    //     $where = [];
    //     $where["unique_id"] = $unique_id;
    // }
    $where = "unique_id = '$unique_id' ";
    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);
    // print_r($department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
function po_numers($unique_id = "")
{
    // echo $unique_id;
    global $pdo;

    $table_name = "po_form";
    $where = [];
    $table_columns = [
        "unique_id",
        "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);
    // print_r($department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
// Executive Names



function vendor_po_number($unique_id = "")
{

    global $pdo;

    $table_name = "invoice_creation_main";

    $where = [];
    $table_columns = [
        "form_main_unique_id as unique_id",
        "(SELECT po_num from po_form where unique_id = $table_name.form_main_unique_id) as po_num",
        // "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0,
        "material_qc" => 1,
        "vendor_bulk_sts" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);

    // print_r($department_name);die();

    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}


function invoice_no($unique_id = "")
{

    global $pdo;

    $table_name = "invoice_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "invoice_no"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    if ($unique_id) {

        $where = [];
        $where["invoice_no"] = $unique_id;
    }
    $where = "invoice_no!='' AND is_delete=0  group by invoice_no";
    // $where= "invoice_no='"$unique_id"' AND invoice_no IS NOT NULL AND invoice_no != '' AND is_delete=0";

    // $group_by          = "invoice_no";
    $department_name = $pdo->select($table_details, $where);
    // $department_name = $pdo->select($table_details, $where,$group_by);
//    print_r( $department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
// Executive Names





function executive_names($unique_id = "")
{

    global $pdo;

    $table_name = "executive_name";
    $where = [];
    $table_columns = [
        "unique_id",
        "executive_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name1 = $pdo->select($table_details, $where);

    if ($department_name1->status) {
        return $department_name1->data;
    } else {
        print_r($department_name1);
        return 0;
    }
}


function department_name($unique_id = "")
{

    global $pdo;

    $table_name = "department_creation";
    $where = [];
    $table_columns = [
        "department"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name1 = $pdo->select($table_details, $where);

    if ($department_name1->status) {
        // return $department_name1->data;
        return $department_name1->data[0]['department']; // ✅ return state name

    } else {
        print_r($department_name1);
        return 0;
    }
}



function vendorpo_numer($unique_id = "")
{

    global $pdo;

    $table_name = "invoice_creation_main";
    $where = [];
    $table_columns = [
        "form_main_unique_id ",
        "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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




// function vendorinvoice_no($po_id = "")
// {



//     global $pdo;

//     // Debug - check if the value is coming in
//     // You can remove this later
//     // print_r("Received Unique ID: " . $unique_id);

//     $table_name = "invoice_creation_main";

//     $table_columns = [
//         "unique_id",
//         "invoice_no",
//         "form_main_unique_id"
//     ];

//     $table_details = [$table_name, $table_columns];

//     // $group_name = $pdo->select($table_details, $where);/\

//     // Prepare WHERE clause
//     $where = "invoice_no IS NOT NULL AND invoice_no != '' AND is_delete = 0 AND (partial_sts = 2 OR partial_sts = '' OR partial_sts IS NULL) AND vendor_bulk_sts IS NOT NULL";

//     // Add PO filter if provided
//     if (!empty($po_id)) {
//         $where .= " AND form_main_unique_id = '$po_id' 
//                 AND (
//                     partial_sts = 2
//                     OR (
//                         (partial_sts = '' OR partial_sts IS NULL)
//                         AND (vendor_bulk_sts IS NULL OR vendor_bulk_sts = '0' OR vendor_bulk_sts = '')
//                     )
//                 )";
//     }
//     $groupBy = "invoice_no";
//     $result = $pdo->select($table_details, $where, null, null, "", "", $groupBy);

//     // print_r($result);die();

//     if ($result->status) {
//         return $result->data;
//     } else {
//         return []; // safer than returning 0 for foreach/select usage
//     }
// }

function vendorinvoice_no($po_id = "")
{
    global $pdo;

    $table_name = "invoice_creation_main";

    $table_columns = [
        "unique_id",
        "invoice_no",
        "form_main_unique_id"
    ];

    $table_details = [$table_name, $table_columns];

    $where = "invoice_no IS NOT NULL 
              AND invoice_no != '' 
              AND is_delete = 0";

    if (!empty($po_id)) {
        $where .= " AND form_main_unique_id = '$po_id' 
                    AND (
                        partial_sts = 2
                        OR (
                            (partial_sts = '' OR partial_sts IS NULL)
                            AND (vendor_bulk_sts IS NULL OR vendor_bulk_sts = '0' OR vendor_bulk_sts = '')
                        )
                    )";
    } else {
        $where .= " AND (
                        partial_sts = 2
                        OR (
                            (partial_sts = '' OR partial_sts IS NULL)
                            AND (vendor_bulk_sts IS NULL OR vendor_bulk_sts = '0' OR vendor_bulk_sts = '')
                        )
                    )";
    }

    $groupBy = "invoice_no";
    $result = $pdo->select($table_details, $where, null, null, "", "", $groupBy);

    if ($result->status) {
        return $result->data;
    } else {
        return [];
    }
}


function vendor_dc_no($inv_no = "")
{



    // print_r($po_id);
    global $pdo;

    // Debug - check if the value is coming in
    // You can remove this later
    // print_r("Received Unique ID: " . $unique_id);

    $table_name = "invoice_creation_main";

    $table_columns = [
        // "unique_id",
        "dc_number",
        // "form_main_unique_id",
        // "invoice_no"
    ];

    $table_details = [$table_name, $table_columns];

    // Prepare WHERE clause
    $where = "invoice_no IS NOT NULL AND invoice_no != '' AND is_delete = 0";


    // Add filter by unique ID if provided
    if (!empty($inv_no)) {
        $where .= " AND invoice_no = '$inv_no'";
    }

    $result = $pdo->select($table_details, $where);

    if ($result->status) {
        return $result->data;
    } else {
        return []; // safer than returning 0 for foreach/select usage
    }
}



function generateVenAssignNo(): string
{
    $prefix = 'ASN';
    $initialSerial = '0001';

    // Database connection details
    $servername = 'localhost';
    $username = 'root';
    $password = project_env('APP_DB_PASSWORD');
    $database_name = 'operation_team_beta';

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // If DB connection fails, return the initial number
        return $prefix . $initialSerial;
    }

    // Corrected table name and query
    $stmt = $pdo->prepare("
        SELECT ven_assign_no 
        FROM invoice_creation_main 
        WHERE ven_assign_no LIKE :prefix 
        ORDER BY ven_assign_no DESC 
        LIMIT 1
    ");
    $stmt->execute(['prefix' => $prefix . '%']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['ven_assign_no'])) {
        // Extract numeric part and increment
        $latest = $result['ven_assign_no'];
        $number = (int) substr($latest, strlen($prefix));
        $newNumber = $number + 1;
    } else {
        // Start from 1 if no existing records
        $newNumber = 1;
    }

    // Format with leading zeros and return full ID
    return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}






function vendor_generate_payment_id($payment_id)
{
    global $pdo;

    $table_name = "vendor_payment_details";
    $table_columns = [
        "MAX(payment_id) AS latest_id"
    ];

    // No WHERE condition needed for MAX
    $where = [];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // Fetch latest payment_id
    $result = $pdo->select($table_details, $where);

    if ($result->status && !empty($result->data[0]['latest_id'])) {
        $latestId = $result->data[0]['latest_id'];

        // Extract number from latest ID (after last '-')
        $lastNum = (int) substr($latestId, strrpos($latestId, '-') + 1);
        $newNum = $lastNum + 1;
    } else {
        $newNum = 1;
    }

    // Get current date in DDMM format
    $currentDate = date('dm');

    // Format new Payment ID → e.g., PAYABC-1410-001
    $newVendorId = 'PAY' . strtoupper($payment_id) . '-' . $currentDate . '-' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    return $newVendorId;
}






// Status Names
function status($unique_id = "")
{

    global $pdo;

    $table_name = "stock_position_main";
    $where = [];
    $table_columns = [
        "unique_id",
        "status"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name1 = $pdo->select($table_details, $where);

    if ($department_name1->status) {
        return $department_name1->data;
    } else {
        print_r($department_name1);
        return 0;
    }
}

// Brand Name
function brand_names($unique_id = "")
{

    global $pdo;

    $table_name = "item_creation_sub";
    $where = [];
    $table_columns = [
        "unique_id",
        "brand"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = "brand!='' AND is_delete=0 group by brand";
    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
    //     "brand"!='',

    // ];

    // if ($unique_id) {

    //     $where              = [];
    //     $where["unique_id"] = $unique_id;
    // }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);

    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}

// Brand Name





function ward_name($unique_id = "", $zone_id = "")
{

    global $pdo;

    $table_name = "ward_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "ward_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }
    if ($zone_id) {

        $where = [];
        $where["zone_name"] = $zone_id;
    }

    $order_by = '(ward_name) ASC';


    $ward_name = $pdo->select($table_details, $where, '', '', $order_by);
    if ($ward_name->status) {
        return $ward_name->data;
    } else {
        print_r($ward_name);
        return 0;
    }
}


function designation_name($unique_id = "")
{

    global $pdo;

    $table_name = "designation_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "designation_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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


function dashboard_admin_menu($unique_id = "")
{

    global $pdo;

    $table_name = "dashboard_settings_menu_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "settings_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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

function tax_type($is_active_val = 1)
{
    $option_str = "";
    $is_active = "";
    $is_inactive = "";

    if ($is_active_val == 1) {
        $is_active = " selected = 'selected' ";
    } else {
        $is_inactive = " selected = 'selected' ";
    }

    $option_str = "<option value='1'" . $is_active . ">Active</option>";
    $option_str .= "<option value='0'" . $is_inactive . ">In Active</option>";

    return $option_str;
}


// executive_name
function executive_name($unique_id = "")
{

    global $pdo;

    $table_name = "executive_name";
    $where = [];
    $table_columns = [
        "unique_id",
        "executive_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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
function district_name($unique_id = "")
{

    global $pdo;

    $table_name = "district_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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

function district_name_stock($unique_id = "")
{
    global $pdo;

    $table_name = "district_creation";
    $table_columns = ["unique_id", "district_name"];
    $table_details = [$table_name, $table_columns];

    $where = [
        "is_active" => 1,
        "is_delete" => 0,
        "unique_id" => $unique_id
    ];

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status && count($user_types->data) > 0) {
        return $user_types->data[0]['district_name']; // ✅ return only name
    } else {
        return ''; // ✅ return empty string instead of 0 or array
    }
}
function con_state_name_stock($unique_id = "")
{
    global $pdo;

    $table_name = "state_creation";
    $table_columns = ["unique_id", "state_name"];
    $table_details = [$table_name, $table_columns];

    $where = [
        "is_active" => 1,
        "is_delete" => 0,
        "unique_id" => $unique_id
    ];

    $result = $pdo->select($table_details, $where);

    if ($result->status && count($result->data) > 0) {
        return $result->data[0]['state_name']; // ✅ return state name
    } else {
        return ''; // ✅ return empty string if not found
    }
}

function name_stock($unique_id = "")
{
    global $pdo;

    $table_name = "consignee_details_sub";
    $table_columns = ["unique_id", "con_contact_name"];
    $table_details = [$table_name, $table_columns];

    $where = [
        "is_active" => 1,
        "is_delete" => 0,
        "unique_id" => $unique_id
    ];

    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status && count($user_types->data) > 0) {
        return $user_types->data[0]['con_contact_name']; // ✅ return only name
    } else {
        return ''; // ✅ return empty string instead of 0 or array
    }
}
// function batch_nos($unique_id = "") {
//     global $pdo;

//     $where = "WHERE is_delete = 0 AND is_active = 1";
//     $params = [];

//     if (!empty($unique_id)) {
//         $where .= " AND form_main_unique_id = :unique_id";
//         $params[':unique_id'] = $unique_id;
//     }

//     $sql = "SELECT batch_id FROM consignee_details_sub $where GROUP BY batch_id";

//     $stmt = $pdo->prepare($sql);
//     $stmt->execute($params);

//     $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

//     return $result ?: []; // return unique batch_ids as a simple array
// }
function batch_nos($unique_id = "")
{
    global $pdo;

    $table_name = "consignee_details_sub";
    $table_columns = ["batch_id"];
    $table_details = [$table_name, $table_columns];

    $where = "is_delete = 0 AND is_active = 1";

    if (!empty($unique_id)) {
        $where .= " AND form_main_unique_id = '$unique_id'";
    }

    $group_by = "batch_id";
    $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);

    return $result->data; // array of batch_id values
}
function select_option_batch($array, $default_text = "Select")
{
    $options = "<option value=''>$default_text</option>";

    foreach ($array as $row) {
        $value = $row['batch_id'];
        $options .= "<option value='$value'>$value</option>";
    }

    return $options;
}


function batch_nos_mains($unique_id = "")
{
    global $pdo;

    $table_name = "consignee_details_sub";
    $table_columns = ["batch_id"];
    $table_details = [$table_name, $table_columns];

    $where = "is_delete = 0 AND is_active = 1";

    if (!empty($unique_id)) {
        $where .= " AND form_main_unique_id = '$unique_id'";
    }

    $group_by = "batch_id";

    $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);

    // print_r($result);

    // if ($result->status && !empty($result->data)) {

    return $result->data; // returns an array of batch_id
    // } else {
    //     return []; // return empty array instead of 0 for consistency
    // }
}

// function batch_nos($unique_id = "") {

//     global $pdo;

//     $table_name    = "consignee_details_sub";
//     // $where         = [];
//     $table_columns = [
//         // "unique_id",
//         "batch_id"
//     ];

//     $table_details = [
//         $table_name,
//         $table_columns
//     ];

//     // $where     = [
//     //     "is_active" => 1,
//     //     "is_delete" => 0
//     // ];
// $where = "is_delete =0  and is_active = 1";
//     if ($unique_id) {

//         // $where              = [];
//         // $where["form_main_unique_id"] = $unique_id;

//         $where .= " AND form_main_unique_id = '$unique_id'";
//     }


//     $user_types = $pdo->select($table_details, $where);
//     print_r($user_types);
//     if ($user_types->status) {
//         return $user_types->data;
//         echo "hiii" . $user_types->data;die();
//     } else {
//         print_r($user_types);
//         return 0;
//     }
// }
function tender_name($unique_id = "")
{

    global $pdo;


    $table_name = "item_creation";
    $where = [];
    $table_columns = [

        "unique_id",
        "tender_code"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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




function tender_code($unique_id = "")
{

    global $pdo;

    $table_name = "item_creation_sub";
    $where = [];
    $table_columns = [
        "unique_id",
        "tender_code",
        // "unique_id",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }
    $group_by = "tender_code";
    $tender_codes = $pdo->select($table_details, $where, "", "", "", "", $group_by);
    // print_R($tender_codes);

    if ($tender_codes->status) {
        return $tender_codes->data;
    } else {
        print_r($tender_codes);
        return 0;
    }
}

// item_code
function item_name($tender_code = "")
{

    global $pdo;

    $table_name = "item_creation_sub";
    $where = [];
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
    $where = 'tender_code="' . $tender_code . '" and is_delete = 0';
    // print_r( $where);
// }
    // $where ="unique_id='".$tender_code."'";
    // print_R($where);
    // $group_by          = "item_code ";
    // $tender_codes = $pdo->select($table_details, $where,"","","","",$group_by);
    $user_types = $pdo->select($table_details, $where);
    // print_r($user_types );
    if ($user_types->status) {
        return $user_types->data;

    } else {
        print_r($user_types);
        return 0;
    }
}


// Warranty name
function warranty_name($unique_id = "")
{

    global $pdo;

    $table_name = "product_warrenty";
    $where = [];
    $table_columns = [
        "unique_id",
        "warrenty_year"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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

// dispatch select courier 
function courier_option($unique_id = "")
{
    global $pdo;
    $table_name = "courier_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "courier_name",
        // "CONCAT(con_address,' ', con_pincode, ' ', (SELECT district_name FROM district_creation WHERE unique_id = con_district)
        //   ) AS con_address",
        // "form_main_unique_id"

    ];
    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = [
        "is_active" => 1,
        "is_delete" => 0,

        // "unique_id" => $unique_id,
        //  "inv_cons_status"=>0,
    ];
    if ($unique_id) {
        $where = [
            "unique_id" => $unique_id,
        ];
    }

    $courier_creation = $pdo->select($table_details, $where);
    // print_r( $courier_creation);die();
    if ($courier_creation->status) {
        return $courier_creation->data;
    } else {
        print_r($courier_creation);
        return 0;
    }
}




// new changes
function btn_update_vendor($folder_name = "", $unique_id = "", $dc_number = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}







// Legder no & Name 
function legder_inv($department = "")
{
    global $pdo;

    $table_name = "view_po_ledger_list";
    $where = [];
    $table_columns = [
        "unique_id",
        "ledger_name",
        // "unique_id",
        // "ledger_no"
        // "(SELECT ledger_name FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.department GROUP BY department) AS ledger_name",
        // "(SELECT ledger_no FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.unique_id) AS ledger_no"

    ];

    // $where = [];

    // if (!empty($department)) {
    //     $where['department'] = $department;
    // }

    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = 'department_unique_id = "' . $department . '"';
    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    // if ($unique_id) {
    //     $table_details      = $table_name;
    //     $where              = [];
    //     $where["unique_id"] = $unique_id;

    // }
    $status_name = $pdo->select($table_details, $where);
    //   print_r($status_name);die();
    if ($status_name->status) {
        return $status_name->data;
    } else {
        print_r($status_name);
        return 0;
    }
}

function legder_no_po($department = "")
{
    global $pdo;

    $table_name = "view_po_ledger_list";
    $where = [];
    $table_columns = [
        "unique_id",
        "ledger_no",
        // "unique_id",
        // "ledger_no"
        // "(SELECT ledger_name FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.department GROUP BY department) AS ledger_name",
        // "(SELECT ledger_no FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.unique_id) AS ledger_no"

    ];

    // $where = [];

    // if (!empty($department)) {
    //     $where['department'] = $department;
    // }

    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = 'department_unique_id = "' . $department . '"';
    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    // if ($unique_id) {
    //     $table_details      = $table_name;
    //     $where              = [];
    //     $where["unique_id"] = $unique_id;

    // }
    $status_name = $pdo->select($table_details, $where);
    //   print_r($status_name);die();
    if ($status_name->status) {
        return $status_name->data;
    } else {
        print_r($status_name);
        return 0;
    }
}
function legder_inv_no($unique_id = "", $department = "")
{
    global $pdo;

    $table_name = "view_po_ledger_list";
    $where = [];
    $table_columns = [
        "unique_id",
        // "ledger_name",
        "ledger_no"
        // "(SELECT ledger_name FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.department GROUP BY department) AS ledger_name",
        // "(SELECT ledger_no FROM department_creation_sublist  WHERE form_main_unique_id = $table_name.unique_id) AS ledger_no"

    ];

    $table_details = [
        $table_name,
        $table_columns
    ];


    // $where='department_unique_id = "'.$department.'"';
    $where = 'unique_id = "' . $department . '"';




    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    // if ($unique_id) {
    //     $table_details      = $table_name;
    //     $where              = [];
    //     $where["unique_id"] = $unique_id;

    // }
    $status_name = $pdo->select($table_details, $where);
    //   print_r($status_name);
    if ($status_name->status) {
        return $status_name->data;
    } else {
        print_r($status_name);
        return 0;
    }
}


// assign_qty_taken
function assign_qty_taken($unique_id = "")
{

    global $pdo;

    $table_name = "po_product_assign_details";
    $where = [];
    $table_columns = [
        // "unique_id",
        "assign_qty"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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
function po_type_option($unique_id = "")
{

    global $pdo;

    $table_name = "po_type";
    $where = [];
    $table_columns = [
        "unique_id",
        "po_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}
//main_category
function main_option($unique_id = "")
{
    global $pdo;

    $table_name = "main_category";
    $where = [];
    $table_columns = [
        "unique_id",
        "main_category"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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
function city_option($unique_id = "", $district_name = "")
{
    global $pdo;

    $table_name = "city_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "city_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
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
function con_state_name($unique_id = "")
{
    global $pdo;

    $table_name = "state_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "state_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }
    // if ($state_name) {

    //     $where["state_name"] = $state_name;

    // }

    $district_creation_list = $pdo->select($table_details, $where);

    // print_r($district_creation_list);

    if ($district_creation_list->status) {
        return $district_creation_list->data;
    } else {
        print_r($district_creation_list);
        return 0;
    }
}
// district_creation
function district_option($unique_id = "", $state_name = "")
{
    global $pdo;

    $table_name = "district_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }
    if ($state_name) {

        $where["state_name"] = $state_name;

    }

    $district_creation_list = $pdo->select($table_details, $where);

    // print_r($district_creation_list);

    if ($district_creation_list->status) {
        return $district_creation_list->data;
    } else {
        print_r($district_creation_list);
        return 0;
    }
}


function district_option_conginee_wise($unique_id = "", $district_name = "")
{
    global $pdo;

    $table_name = "consignee_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "consignee_district",
        "(SELECT district_name FROM district_creation WHERE unique_id = consignee_creation.consignee_district) AS consignee_district_name"
    ];


    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }


    $district_creation_list_conginee = $pdo->select($table_details, $where);
    // print_r($district_creation_list_conginee);
    if ($district_creation_list_conginee->status) {
        return $district_creation_list_conginee->data;
    } else {
        print_r($district_creation_list_conginee);
        return 0;
    }
}




function state_by_district_name($state_unique_id = "")
{

    global $pdo;

    $table_name = "district_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "state_name",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($state_unique_id) {

        $where = [];
        $where["state_name"] = $state_unique_id;
    }

    $districts = $pdo->select($table_details, $where);


    // print_r($districts);

    if ($districts->status) {
        return $districts->data;
    } else {
        print_r($districts);
        return 0;
    }
}




function state_option_short_name($unique_id = "")
{
    global $pdo;

    $table_name = "state_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "short_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }
    $order = " state_name ASC";
    // $order_by = "ORDER BY statename ASC";

    $state_creation_list = $pdo->select($table_details, $where, "", "", $order);
    // print_r($state_creation_list);
    if ($state_creation_list->status) {
        return $state_creation_list->data;
    } else {
        print_r($state_creation_list);
        return 0;
    }
}

//state_creation
function state_option($unique_id = "")
{
    global $pdo;

    $table_name = "state_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "state_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }
    $order = " state_name ASC";
    // $order_by = "ORDER BY statename ASC";

    $state_creation_list = $pdo->select($table_details, $where, "", "", $order);
    // print_r($state_creation_list);
    if ($state_creation_list->status) {
        return $state_creation_list->data;
    } else {
        print_r($state_creation_list);
        return 0;
    }
}

// vendor name creation start
// function engineer_type($unique_id = "") {
//     global $pdo;

//     $table_name    = "vendor_creation";
//     $where         = [];
//     $table_columns = [
//         "unique_id",
//         "name"
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

//     $main_screens = $pdo->select($table_details, $where,'','','');
// //print_r($main_screens);
//     if ($main_screens->status) {
//         return $main_screens->data;
//     } else {
//         print_r($main_screens);
//         return 0;
//     }
// }


// vendor name creation end

// City Function
function district($unique_id = "", $state_id = "")
{
    global $pdo;

    $table_name = "district_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];
    $where = "is_delete = 0 and is_active = 1";

    if ($state_id) {
        $where .= " AND state_name = '" . $state_id . "' ";
        // $where["state_name"] = $state_id;
    }

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where = [
            "unique_id" => $unique_id
        ];
    }
    $order = " district_name ASC";
    $cities = $pdo->select($table_details, $where, "", "", $order);

    // print_r($cities);

    if ($cities->status) {
        return $cities->data;
    } else {
        print_r($cities);
        return 0;
    }
}

function consignee_option_sub($unique_id = "")
{
    global $pdo;
    $table_name = "consignee_details_sub";
    $where = [];
    $table_columns = [
        "unique_id",
        "con_address",
        "con_district",
        "con_contact_name",
        "form_main_unique_id"

    ];
    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = [
        "is_active" => 1,
        "is_delete" => 0,
    ];

    // group by invoice_no
    // $groupby="form_main_unique_id";
    $consignee_details_sub_options = $pdo->select($table_details, $where);
    // print_r($consignee_details_sub);
    if ($consignee_details_sub_options->status) {
        return $consignee_details_sub_options->data;
    } else {
        print_r($consignee_details_sub_options);
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



// DC Date get by invoice and po based

function dc_dateLD($bill_form_unique_id = "", $invoice_no = "")
{
    global $pdo;
    $table_name = "invoice_creation_main";
    $where = "";
    $table_columns = [
        "dc_date",
        "dc_number"
    ];
    $table_details = [
        $table_name,
        $table_columns
    ];

    $where .= "is_delete = 0 and form_main_unique_id = '" . $bill_form_unique_id . "' and invoice_no = '" . $invoice_no . "'";


    $dc_date_options = $pdo->select($table_details, $where);
    // print_r($dc_date_options);
    if ($dc_date_options->status) {
        return $dc_date_options->data;
    } else {
        print_r($dc_date_options);
        return 0;
    }
}



function consignee_option($unique_id = "")
{
    global $pdo;
    $table_name = "consignee_details_sub";
    $where = "";
    $table_columns = [
        "unique_id",
        "CONCAT_WS(con_address,' ', con_pincode, ' ', (SELECT district_name FROM district_creation WHERE unique_id = con_district group by unique_id)
          ) AS con_address",
        "form_main_unique_id",
        "con_branch"


    ];
    $table_details = [
        $table_name,
        $table_columns
    ];

    $where .= "is_active = 1 and is_delete = 0 and form_main_unique_id = '" . $unique_id . "' and inv_cons_status = 0";

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

function po_product($unique_id = '', $form_main_unique_id = '')
{

    global $pdo;

    $table_name = "product_details_sub";
    $where = [];
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
    $where = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id="' . $form_main_unique_id . '"';
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

function btn_update_7($folder_name = "", $unique_id = "", $invoice_no = "", $ins_unique_id = "", $dc_number = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '&ins_unique_id=' . $ins_unique_id . '&dc_number=' . $dc_number . '"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}

function btn_bill_submission_update($folder_name = "", $unique_id = "", $invoice_no = "", $po_id = "", $bill_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '&po_id=' . $po_id . '&bill_no=' . $bill_no . '"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function btn_view_signed_doc($folder_name = "", $unique_id = "", $invoice_no = "", $ins_unique_id = "", $dc_number = "", $prefix = "", $suffix = "")
{


    // $final_str = '<a href="index.php?file='.$menu_screen.'&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'&ins_unique_id='.$ins_unique_id.'"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/update1&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '&ins_unique_id=' . $ins_unique_id . '&dc_number=' . $dc_number . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}


// new ==============================================================================

function btn_view_ins($folder_name = "", $unique_id = "", $dc_number = "", $invoice_no = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/update_1&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '&invoice_no=' . $invoice_no . '"  id="_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_ins2($folder_name = "", $unique_id = "", $dc_number = "", $invoice_no = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/update_view&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '&invoice_no=' . $invoice_no . '"  id="_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_ins_dc_ir($folder_name = "", $unique_id = "", $dc_number = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/view";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&dc_number=' . $dc_number . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
    // $final_str='<a href="index.php?file=installation/create1&unique_id='.$value['consignee_unique_id'].'&invoice_no='.$invoice_no.'" ><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';


    return $final_str;
}
// function btn_view_ins($folder_name = "",$unique_id = "",$invoice_no="",$prefix = "",$suffix = "") {

//     $final_str = '<a href="index.php?file='.$prefix.$folder_name.$suffix.'/update_1&unique_id='.$unique_id.'&invoice_no='.$invoice_no.'"  id="_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


//     return $final_str;
// }
function btn_view_install($folder_name = "", $unique_id = "", $invoice_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/view_tab";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&invoice_no=' . $invoice_no . '" id="update_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
    // $final_str='<a href="index.php?file=installation/create1&unique_id='.$value['consignee_unique_id'].'&invoice_no='.$invoice_no.'" ><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';


    return $final_str;
}


function btn_view_invoice($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{
    //  $batch_id = ""

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view_invoice&unique_id=' . $unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_bill($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view1_inv($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_inv($folder_name = "", $unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function btn_view_payment($folder_name = "", $unique_id = "", $bill_no = "", $invoice_no = "", $ins_unique_id = "", $prefix = "", $suffix = "")
{

    $final_str = '<a href="index.php?file=' . $prefix . $folder_name . $suffix . '/view&unique_id=' . $unique_id . '&bill_no=' . $bill_no . '&invoice_no=' . $invoice_no . '&ins_unique_id=' . $ins_unique_id . '"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}




// po numbers

function po_numers_with_department($unique_id = "")
{

    global $pdo;

    $table_name = "po_form";
    // $dept_table = "department_creation";
    $where = [];
    $table_columns = [
        "unique_id",
        "po_num",
        "po_date",
        '(SELECT department FROM  department_creation AS dis WHERE dis.unique_id =' . $table_name . '.department ) AS department_name',
        '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id =' . $table_name . '.executive_name) AS executive_name',
        //  "(SELECT department FROM $dept_table WHERE unique_id = $po_table.department) AS department_name"
        // "(selct department from department_creation where unique_id=$table_name.department) AS department_name",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);
    //    print_r( $department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}
// department
function invoice_no_with_department($unique_id = "")
{

    // print_r($unique_id);
    global $pdo;

    $table_name = "view_invoice_with_department";
    // $dept_table = "department_creation";
    $where = [];
    $table_columns = [
        // "unique_id",
        "invoice_no",
        "invoice_date",
        "executive_name",
        "department",
        // "executive_name",
        // '(SELECT department FROM  department_creation AS dis WHERE dis.unique_id ='.$table_name.'.ledger_name ) AS department_name',
        // '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id =' . $table_name . '.executive_name) AS executive_name',
        "ledger_name",
        "ledger_no",
        //  "(SELECT department FROM $dept_table WHERE unique_id = $po_table.department) AS department_name"
        // "(selct department from department_creation where unique_id=$table_name.department) AS department_name",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0
    // ];

    if ($unique_id) {

        $where = [];
        $where["invoice_no"] = $unique_id;
    }

    // $order_by  = 'order_no ASC';

    $department_name = $pdo->select($table_details, $where);
    //    print_r( $department_name);
    if ($department_name->status) {
        return $department_name->data;
    } else {
        print_r($department_name);
        return 0;
    }
}


// BID Type Function
function vendor_generate_id1()
{
    global $pdo;

    $table_name = "vendor_creation";
    $where = '';
    $table_columns = [
        "max(user_name) as vendor_user_id",

    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];



    $staff_director_name_list = $pdo->select($table_details, $where);
    // print_r($staff_director_name_list);
    if ($staff_director_name_list->status) {
        return $staff_director_name_list->data[0]['vendor_user_id'];
    } else {
        print_r($staff_director_name_list);
        return 0;
    }
}



function vendor_generate_id($state_code)
{

    // Example: $st_name = 'TN'; or 'ANP'
    $st_name = $state_code; // or whatever state you're generating for

    // Database connection (adjust with your actual DB config)
    $conn = new mysqli(project_env('APP_DB_HOST', 'localhost'), project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'), project_env('APP_DB_NAME', 'operation_team_beta'));

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the latest vendor ID for that state
    $sql = "SELECT user_name FROM vendor_creation WHERE user_name LIKE 'VEN-$st_name-%' ORDER BY user_name DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Get the last vendor ID
        $row = $result->fetch_assoc();
        $latestId = $row['user_name'];

        // Extract the last numeric part
        $lastNum = substr($latestId, strrpos($latestId, '-') + 1);
        $num = (int) $lastNum + 1;
    } else {
        $num = 1; // Start fresh if none exist
    }

    // Generate new vendor ID
    $newVendorId = 'VEN-' . $st_name . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

    echo $newVendorId;

    $conn->close();


}
function vendor_generate_id2($state_code)
{
    global $pdo;
    $state_code;
    $table_name = "vendor_creation";

    // Query the latest vendor_id for the given state
    $table_columns = [
        "MAX(user_name) AS latest_vendor_id"
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0,
        "user_name[~]" => "VEN-" . $state_code . "-%" // LIKE 'VEN-TN-%'
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $result = $pdo->select($table_details, $where);
    print_r($result);
    if ($result->status && !empty($result->data[0]['latest_vendor_id'])) {
        $latestId = $result->data[0]['latest_vendor_id'];

        // Extract number from the latest vendor ID
        $lastNum = (int) substr($latestId, strrpos($latestId, '-') + 1);
        $newNum = $lastNum + 1;
    } else {
        $newNum = 1; // Start at 1 if none found
    }

    // Format new ID
    $newVendorId = 'VEN-' . $state_code . '-' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    return $newVendorId;
    echo $newVendorId;
}



// BID Type Function
function maxvenid()
{
    global $pdo;

    $table_name = "vendor_creation";
    $where = '';
    $table_columns = [
        "max(vendor_id) as vendor_id",

    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];



    $staff_director_name_list = $pdo->select($table_details, $where);

    if ($staff_director_name_list->status) {
        return $staff_director_name_list->data[0]['vendor_id'];
    } else {
        print_r($staff_director_name_list);
        return 0;
    }
}


// po numbers

//   ===============new end==================================================
function account_vertical($unique_id = "")
{
    global $pdo;

    $table_name = "account_vertical";
    $where = [];
    $table_columns = [
        "unique_id",
        "account_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }

    $account_name_list = $pdo->select($table_details, $where);

    if ($account_name_list->status) {
        return $account_name_list->data;
    } else {
        print_r($account_name_list);
        return 0;
    }
}

function dash_account_vertical($unique_id = "")
{
    global $pdo;

    $table_name = "account_vertical";
    $where = [];
    $table_columns = [
        "unique_id",
        "account_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }

    $account_name_list = $pdo->select($table_details, $where);

    if ($account_name_list->status) {
        return $account_name_list->data;
    } else {
        print_r($account_name_list);
        return 0;
    }
}

//state_creation
function account_sector($unique_id = "")
{
    global $pdo;

    $table_name = "account_sector";
    $where = [];
    $table_columns = [
        "unique_id",
        "sector_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }

    $sector_name_list = $pdo->select($table_details, $where);

    if ($sector_name_list->status) {
        return $sector_name_list->data;
    } else {
        print_r($sector_name_list);
        return 0;
    }
}
//state_creation
function insurence_type($unique_id = "")
{
    global $pdo;

    $table_name = "insurence_type";
    $where = [];
    $table_columns = [
        "unique_id",
        "insurence_type"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {
        $table_details = $table_name;
        $where = [];
        $where["unique_id"] = $unique_id;

    }

    $account_name_list = $pdo->select($table_details, $where);

    if ($account_name_list->status) {
        return $account_name_list->data;
    } else {
        print_r($account_name_list);
        return 0;
    }
}

function select_option_multi($options, $default_text, $selected_values = [])
{
    // Initialize the option list with the default option
    $html = '<option value="">' . $default_text . '</option>';

    // Check if selected_values is not empty and split it into an array
    $selected_values = !empty($selected_values) ? explode(",", $selected_values) : [];

    // Loop through all the available options
    foreach ($options as $option) {
        $selected = ''; // Default to not selected

        // Check if the current option's unique_id is in the selected_values array
        if (in_array($option['unique_id'], $selected_values)) {
            $selected = 'selected'; // Mark as selected
        }

        // Add the option to the HTML string
        $html .= '<option value="' . $option['unique_id'] . '" ' . $selected . '>' . $option['insurence_type'] . '</option>';
    }

    return $html;
}


function list_of_po($unique_id = "")
{

    global $pdo;

    $table_name = "po_form";
    $where = [];
    $table_columns = [
        "unique_id",
        "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    if ($unique_id) {

        $where = [];
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

function get_executive_name($unique_id = "")
{

    global $pdo;

    $table_name = "executive_name";
    $where = [];
    $table_columns = [
        "executive_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where = [
        "is_active" => 1,
        "is_delete" => 0
    ];

    $limit = '1';

    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $user_types = $pdo->select($table_details, $where, $limit);
    // print_r($user_types->data['executive_name']);

    if ($user_types->status) {
        return $user_types->data['executive_name'];
    } else {
        print_r($user_types);
        return 0;
    }
}




// function list_of_po_inv($unique_id = "")
// {

//     global $pdo;

//     $table_name = "po_form";
//     $where = [];
//     $table_columns = [
//         "unique_id",
//         "po_num"
//     ];

//     $table_details = [
//         $table_name,
//         $table_columns
//     ];

//     $where = [
//         "is_active" => 1,
//         "is_delete" => 0
//     ];

//     if ($unique_id) {

//         $where = [];
//         $where["unique_id"] = $unique_id;
//     }

//     $user_types = $pdo->select($table_details, $where);

//     if ($user_types->status) {
//         return $user_types->data;
//     } else {
//         print_r($user_types);
//         return 0;
//     }
// }


function getFinancialYear($dateStr)
{
    // echo $dateStr;
    $date = DateTime::createFromFormat('Y-m-d', $dateStr);
    if (!$date) {
        return "Invalid date format";
    }

    $year = (int) $date->format("Y");
    $month = (int) $date->format("m");

    if ($month < 4) {
        return ($year - 1) . "-" . $year;
    } else {
        return $year . "-" . ($year + 1);
    }
}



function list_of_invoice($unique_id = "", $po_form = '')
{

    global $pdo;

    $table_name = "invoice_creation_main";

    $where = [];
    $table_columns = [
        "unique_id",
        "invoice_no"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
    //      "invoice_no[!]"    => null 
    // ];

    // $where .=" AND invoice_no IS NOT NULL";

    $group_by = " invoice_no";

    // if ($unique_id) {

    //     $where = [];
    //     $where["unique_id"] = $unique_id;
    // }

    // if ($po_form) {
    //     // $where = [];
    //     $where['form_main_unique_id'] .= $po_form;
    // }

    $where = "is_active = 1 AND is_delete = 0 AND invoice_no IS NOT NULL";

    if (!empty($unique_id)) {
        $where .= " AND unique_id = '$unique_id'";
    }

    if (!empty($po_form)) {
        $where .= " AND form_main_unique_id = '$po_form'";
    }


    $user_types = $pdo->select($table_details, $where, "", "", "", "", $group_by);
    // print_r($user_types);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}

function btn_update_accounts_team($folder_name = "", $unique_id = "", $vendor_id = "", $bill_no = "", $bill_date = "", $accounts_approval = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/update";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&vendor_id=' . $vendor_id . '&bill_no=' . $bill_no . '&bill_date=' . $bill_date . '&accounts_approval=' . $accounts_approval . '" id="update_btn"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';


    return $final_str;
}


function btn_view_dc_status($folder_name = "", $unique_id = "", $po_no = "", $inv_no = "", $prefix = "", $suffix = "", $date = "", $form = "")
{
    $password = project_env('APP_ENCRYPTION_PASSWORD');
    $enc_method = 'aes-256-cbc';
    $enc_password = substr(hash('sha256', $password, true), 0, 32);
    $enc_iv = project_env('APP_ENCRYPTION_IV');


    $menu_screen = $folder_name . "/dc_status";
    // $file_name_update       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    // $uni_id = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

    $final_str = '<a href="index.php?file=' . $menu_screen . '&unique_id=' . $unique_id . '&po_no=' . $po_no . '&inv_no=' . $inv_no . '" id="update_btn"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>';


    return $final_str;
}

function formatIndianNumber($number)
{
    $number = round($number);

    if (!is_numeric($number) || $number == 0) {
        return '-';
    }

    $number = (string) $number;
    $last3 = substr($number, -3);
    $rest = substr($number, 0, -3);

    if ($rest != '') {
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        return $rest . "," . $last3;
    } else {
        return $last3;
    }
}



// executive_name
function inv_verify_po($unique_id = "")
{

    global $pdo;

    $table_name = "invoice_verfication_table";
    $where = [];
    $table_columns = [
        "form_main_unique_id",
        "(SELECT po_num from po_form where unique_id = $table_name.form_main_unique_id) AS po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];



    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }

    $where = 'inv_verify_status = "1"';
    // 
    // 

    $group_by = 'form_main_unique_id';

    $user_types = $pdo->select($table_details, $where, '', '', '', '', $group_by);
    // print_r($user_types);die();
    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}

//partial payment po list

function partial_paypo($unique_id = "")
{

    global $pdo;

    $table_name = "view_partial_bill_1";
    $where = [];
    $table_columns = [
        "bill_form_unique_id",
        "(SELECT po_num from po_form where unique_id = $table_name.bill_form_unique_id) AS po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];



    if ($unique_id) {

        $where = [];
        $where["unique_id"] = $unique_id;
    }


    $where = "claim_amount!='100' AND (partial_bill_status = 0 ||  partial_bill_status IS NULL)";

    $group_by = 'po_num';

    $user_types = $pdo->select($table_details, $where, '', '', '', '', $group_by);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}




function zone_name_option($unique_id = "")
{
    global $pdo;

    $table_name = "consignee_details_sub";
    $table_columns = [
        "zone as unique_id",
        "zone"
    ];

    $table_details = [$table_name, $table_columns];

    $where = "is_active =1 and is_delete =0 and  zone !=''";

    if ($unique_id) {
        $where .= "and form_main_unique_id ='$unique_id' ";

    }
    $where .= " group by zone ";
    // Pass group by separately if your $pdo->select supports it

    // Assuming your select method signature supports group by as third param
    $user_types = $pdo->select($table_details, $where);

    if ($user_types->status) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }
}

function zone_namesby_state($unique_id = "")
{

    global $pdo;

    $table_name = "consignee_details_sub";

    $columns = [
        "zone as unique_id",
        "zone"
    ];

    $table_details = [$table_name, $columns];


    $where = "is_active = 1 AND is_delete = 0  AND zone IS NOT NULL 
           AND TRIM(zone) != ''";


    if ($unique_id) {

        $where .= " AND con_state_name = '$unique_id'";

    }

    $groupby = "zone";

    $user_types = $pdo->select($table_details, $where, null, null, "", "", $groupby);

    // print_r($user_types);

    if ($user_types->status && (($user_types->data != null) && ($user_types->data != ""))) {
        return $user_types->data;
    } else {
        print_r($user_types);
        return 0;
    }


}

function state_name_option($unique_id = "")
{
    global $pdo;

    $table_name = "consignee_details_sub";
    $table_columns = [
        "con_state_name as unique_id",
        "get_state_name(con_state_name) as state_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];
    $where = "is_active =1 and is_delete =0 and  form_main_unique_id = '$unique_id' group by con_state_name ";


    $order = "state_name ASC";

    // Assuming your custom select() supports 5th parameter as ORDER BY
    // and 4th parameter as GROUP BY
    $state_creation_list = $pdo->select($table_details, $where, "", "", $order);
    if ($state_creation_list->status) {
        return $state_creation_list->data;
    } else {
        print_r($state_creation_list);
        return 0;
    }
}


function district_Name_option($unique_id = "", $state_id = "", $po_num = "")
{
    global $pdo;
    $table_name = "consignee_details_sub";
    $where = [];
    $table_columns = [
        "con_district as unique_id",
        "get_district_name(con_district) as district_name"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];



    $where = "is_active =1 and is_delete =0 and  form_main_unique_id = '$po_num' and con_state_name= '$state_id' group by con_district ";


    $order = " district_name ASC";
    $cities = $pdo->select($table_details, $where, "", "", $order);

    // print_r($cities);

    if ($cities->status) {
        return $cities->data;
    } else {
        print_r($cities);
        return 0;
    }
}



function vendorinvoice_no_update($unique_id = "", $po = "")
{
    global $pdo;

    $table_name = "invoice_creation_main";

    $table_columns = [
        "unique_id",
        "invoice_no",
        "form_main_unique_id"
    ];

    $table_details = [$table_name, $table_columns];

    $where = "invoice_no IS NOT NULL 
              AND invoice_no != '' 
              AND is_delete = 0";

    // FIXED CONDITION
    if (!empty($unique_id)) {
        $where .= " AND unique_id = '$unique_id' AND form_main_unique_id= '$po'";
    }

    $groupBy = "invoice_no";

    $result = $pdo->select($table_details, $where, null, null, "", "", $groupBy);

    if ($result->status) {
        return $result->data;
    } else {
        return [];
    }
}



function generateVenProductAssignNo()
{
    $prefix = 'PAR';
    $servername = "localhost";
    $username = 'root';
    $password = project_env('VENDOR_DB_PASSWORD');
    $database_name = 'operation_team_beta';

    // Get YearMonth format (YYMM)
    $yearMonth = date("ym"); // Example: 2509 for Sept 2025
    $midfix = $prefix . $yearMonth . "-DC";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        return $midfix . "0001"; // Default if DB fails
    }

    // 1️⃣ Find the last ven_partial_sno used in this month
    $stmt = $pdo->prepare("
        SELECT ven_partial_sno 
        FROM vendor_allocation_sublist  
        WHERE ven_partial_sno LIKE :prefix 
        ORDER BY ven_partial_sno DESC 
        LIMIT 1
    ");
    $stmt->execute(['prefix' => $midfix . '%']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['ven_partial_sno'])) {
        $latest = $result['ven_partial_sno'];

        // Extract the numeric part after "-DC"
        $number = (int) substr($latest, strrpos($latest, 'DC') + 2);
        $newNumber = $number + 1;
    } else {
        $newNumber = 1; // Start fresh
    }

    // 2️⃣ Return the new serial (always increment for each new allocation, even for same DC)
    return $midfix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}



