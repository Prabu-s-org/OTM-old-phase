<?php
require_once __DIR__ . '/../../config/env.php';
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Database connection
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
    exit;
}

// Check if file is uploaded
if (!isset($_FILES["file"])) {
    echo json_encode(["status" => "error", "message" => "No file uploaded."]);
    exit;
}

// Collect POST data
$no_of_consignee         = $_POST['no_of_consignee'];
$form_main_unique_id     = $_POST['form_main_unique_id'];
$cons_verify_sts         = $_POST['cons_verfiy_sts'];
$batch_id                = $_POST['batch_id'];
$po_number               = $_POST['po_number'];
$consignee_received_date = $_POST['consignee_received_date'];
$batch_entry_date        = date('Y-m-d');

// Allowed file types
$allowedFileType = [
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

// Validate file type
if (!in_array($_FILES["file"]["type"], $allowedFileType)) {
    echo json_encode(["status" => "error", "message" => "Invalid file type."]);
    exit;
}

// Load uploaded file
$file_path = $_FILES['file']['tmp_name'];
$xlsx = new SimpleXLSX($file_path);
$rows = $xlsx->rows();

// Initialize variables
$errors = [];
$missing_staff_ids = [];
$invalid_districts = [];
$insert_data = [];
$seen_addresses = [];


foreach ($rows as $index => $fields) {
    // Skip header row
    // if ($index === 0) continue;

    $row_num = $index + 1;
    $con_address = trim($fields[4]);
     $state_name = $fields[7];
     $district_name = $fields[8];
    $assign_team_member_raw = trim($fields[18]);
    $staff_ids = array_filter(array_map('trim', explode(',', $assign_team_member_raw)));

    // Check for duplicate consignee addresses
    if (in_array($con_address, $seen_addresses)) {
        $errors[] = "Row $row_num - Duplicate consignee address: \"$con_address\"";
        continue;
    } else {
        $seen_addresses[] = $con_address;
    }

    // Check if address already exists in database
    // $check_address = $conn->prepare("SELECT COUNT(*) FROM consignee_details_sub WHERE LOWER(TRIM(con_address)) = LOWER(TRIM(?)) AND po_number = '$po_number' AND is_delete = 0");
    // $check_address->execute([$con_address]);
    // if ($check_address->fetchColumn() > 0) {
    //     $errors[] = "Row $row_num - Address Already Exists Database Table: \"$con_address\"";
    //     continue;
    // }

    // Validate staff IDs
    $valid_staff_ids = [];
    $invalid_staff_ids = [];
    foreach ($staff_ids as $sid) {
        if (empty($sid)) {
            $invalid_staff_ids[] = "Empty";
            continue;
        }

        // echo "SELECT COUNT(*) FROM user WHERE staff_id = '$sid' AND is_delete = 0";

        $check_user = $conn->prepare("SELECT COUNT(*) FROM user WHERE staff_id = ? AND is_delete = 0");
        $check_user->execute([$sid]);
        $check_user;
        if ($check_user->fetchColumn() <= 0) {
            $invalid_staff_ids[] = $sid;
        } else {
            $valid_staff_ids[] = $sid;
        }
    }

    // If invalid staff IDs exist, continue to next row
    if (!empty($invalid_staff_ids)) {
        $errors[] = "Row $row_num - Invalid Staff IDs: " . implode(", ", $invalid_staff_ids);
        $missing_staff_ids = array_merge($missing_staff_ids, $invalid_staff_ids);
        continue;
    }

    // Validate state
    // $state_name = ucwords(strtolower($state_names));
    // $district_name = ucwords(strtolower($district_names));

    // echo "SELECT unique_id FROM state_creation WHERE state_name = '".$state_name."' AND is_delete = 0";

    $select_state = $conn->prepare("SELECT unique_id FROM state_creation WHERE state_name = ? AND is_delete = 0");
    $select_state->execute([$state_name]);
    $row_state = $select_state->fetch();
    $state_id = $row_state['unique_id'] ?? null;

    if (!$state_id) {
        $errors[] = "Row $row_num - Invalid State: \"$state_name\"";
        continue;
    }

    // echo "SELECT unique_id FROM district_creation WHERE state_name = '$state_id' AND district_name = '$district_name' AND is_delete = 0";
    // Validate district
    $select_district = $conn->prepare("SELECT unique_id FROM district_creation WHERE state_name = ? AND district_name = ? AND is_delete = 0");
    // echo "select unique_id FROM district_creation WHERE state_name = '".$state_id."' AND district_name = '".$district_name."' AND is_delete = 0";
    $select_district->execute([$state_id, $district_name]);
    $row_district = $select_district->fetch();
    $district_id = $row_district['unique_id'] ?? null;
    

    if (!$district_id) {
        $invalid_districts[] = [
            'row' => $row_num,
            'district' => $district_name,
            'state' => $state_name
        ];
        continue;
    }

    // Prepare data for insertion
    $unique_id = uniqid("con_");
    $assign_team_member_str = implode(",", $valid_staff_ids);

    $insert_data[] = [
        trim($fields[0]),trim($fields[1]), trim($fields[2]),trim($fields[3]),$con_address, trim($fields[5]),trim($fields[6]), $state_id, $district_id, trim($fields[9]), // con_pincode
    trim($fields[10]), 
    trim($fields[11]),// 
    trim($fields[12]),// 
    trim($fields[13]),// 
    trim($fields[14]),// alte_ontact_name
    trim($fields[15]),// alter_number
    trim($fields[16]),
    trim($fields[17]),
        $assign_team_member_str, $unique_id, $form_main_unique_id, $no_of_consignee,
        $cons_verify_sts, $batch_id, $po_number, $batch_entry_date, $consignee_received_date
    ];
}

// If errors or invalid districts, send error response
if (!empty($errors) || !empty($invalid_districts)) {
    // Prepare error message to show in JavaScript alert
    $error_message = implode("\n", $errors);
    $district_message = '';
    foreach ($invalid_districts as $district) {
        $district_message .= "Row {$district['row']} - District: {$district['district']}, State: {$district['state']}\n";
    }
    $alert_message = "Errors found:\n" . $error_message . "\n" . "Invalid Districts:\n" . $district_message;

    echo json_encode([
        "status" => "error",
        "message" => $alert_message,
        "missing_ids" => array_unique($missing_staff_ids),
        "invalid_districts" => $invalid_districts
    ]);
    exit;
}

// Insert valid data into the database
if (!empty($insert_data)) {
    try {
        $stmt = $conn->prepare("INSERT INTO consignee_details_sub(
            billing_address,billing_gst_no,con_branch,con_branch_code,con_address,cons_email_id,region,con_state_name, con_district, con_pincode, zone,zone_code,
            con_contact_name, con_contact_number, con_lan_num,alter_contact_name,alter_number, consignee_gst,
            assign_team_member, unique_id, form_main_unique_id, no_of_consignee,
            cons_verify_sts, batch_id, po_number, batch_entry_date, consignee_received_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($insert_data as $data) {
            $stmt->execute($data);
        }

        echo json_encode(["status" => "success", "message" => "Upload Successful"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database insertion failed: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No valid data to insert."]);
}
?>



