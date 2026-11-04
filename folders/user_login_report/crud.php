<?php

// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name

$table           = "user_login_details";

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

$is_active          = "";
$unique_id          = "";
$prefix             = "pro";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

switch ($action) {

    case 'datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start      = $_POST['start'];
        $draw       = $_POST['draw'];
        $limit      = $length;

        $data       = [];

        $an_count_label               = 0;
        $week_count_label             = 0;
        $percentage_count_label       = 0;



        if ($length == '-1') {
            $limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "@a:=@a+1 s_no",
            "user_id",
            "entry_date",
            "entry_time",
        ];

        $table_details  = [
            $table . " , (SELECT @a:= " . $start . ") AS a ",
            $columns
        ];

        // if ($_POST['search']['value']) {
        //     $where .= " AND user_id IN (".user_name($_POST['search']['value']).") ";
        //     // $where .= " OR employee_name LIKE '".mysql_like($_POST['search']['value'])."' ";
        //     // $where .= " OR muster_place LIKE '".mysql_like($_POST['search']['value'])."') ";
        //     // $where .= " OR zone_id IN (".zone_name_like($_POST['search']['value']).") ";
        //     // $where .= " OR ward_id IN (".ward_name_like($_POST['search']['value']).") ";
        //     // $where .= " OR customer_group_id IN (".customer_group_name_like($_POST['search']['value']).") ";

        // }

        $where  = "entry_date != '' AND entry_date between '" . $_POST['from_date'] . "' AND '" . $_POST['to_date'] . "'";

        $order_by       = "";

        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {

                $user = get_user_name($value['user_id']);
                $value['user_id'] = $user[0]['staff_name'];                

                $data[]             = array_values($value);
            }

            $json_array = [
                "draw"              => intval($draw),
                "recordsTotal"      => intval($total_records),
                "recordsFiltered"   => intval($total_records),
                "data"              => $data,
                "testing"           => $result->sql,
                "an_count_label"         => ($an_count_label),
                "week_count_label"       => ($week_count_label),
                "percentage_count_label" => ($percentage_count_label)

            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    default:

        break;
}

