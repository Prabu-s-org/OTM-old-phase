<?php
require_once __DIR__ . '/../../config/env.php';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';
// File Upload Library Call

// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    'status' => 0,
    'data' => '',
    'error' => 'Action Not Performed'
];
$json_array = '';
$sql = '';

$user_type = '';
$is_active = '';
$unique_id = '';
$prefix = '';

$data = '';
$msg = '';
$error = '';
$status = '';
$test = '';
// For Developer Testing Purpose

// try {
//     // Database connection
//     $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", project_env('VENDOR_DB_PASSWORD'));
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // echo "connected sucessfully";
// } catch (PDOException $e) {
//     echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
//     exit;

// }

switch ($action) {

   case 'get_state_name':
        $state_name = $_POST['state_id'];

        $district = $_POST['district'];
        $po_num = $_POST['po_num'];

        $pre_state_options = district_Name_option("", $state_name, $po_num);

        $pre_state_option = select_option($pre_state_options, "Select the district", $district);

        echo $pre_state_option;

        break;

  case 'get_state':
        $po_num = $_POST['po_num'];

        $pre_state_options = state_name_option($po_num);

        $pre_state_option = select_option($pre_state_options, "Select the State", $zone);

        echo $pre_state_option;

        break;





         case 'get_zone':
        $po_num = $_POST['po_num'];

        $pre_state_options = zone_name_option($po_num);

        $pre_state_option = select_option($pre_state_options, "Select the Zone", $zone);

        echo $pre_state_option;

        break;

    case 'get_po_num':

        $customer = $_POST['customer'];

        // $district = $_POST['district'];

        $po_num = get_po_by_customer($customer);

        // print_r($po_num);die();

        $po_num_options = select_option($po_num, "Select PO");

        echo $po_num_options;

        break;


    default:

        break;
}



