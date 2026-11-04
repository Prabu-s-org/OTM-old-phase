<?php
require_once __DIR__ . '/../../config/env.php';
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
session_start();

// Set error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB Connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
    exit;
}

// Check if the file is uploaded
if (!isset($_FILES["file"])) {
    echo json_encode(["status" => "error", "message" => "No file uploaded."]);
    exit;
}

// Allowed file types
$allowedFileType = [
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (!in_array($_FILES["file"]["type"], $allowedFileType)) {
    echo json_encode(["status" => "error", "message" => "Invalid file type."]);
    exit;
}

$file_path = $_FILES['file']['tmp_name'];
$xlsx = new SimpleXLSX($file_path);
$rows = $xlsx->rows();

// Initialize arrays for errors
$errors = [];
$insert_data = [];
$seen_districts = [];

foreach ($rows as $index => $fields) {
    $row_num = $index + 1;

    $state_name = trim($fields[0]);
    $district_name = trim($fields[1]);

    if ($state_name === '' || $district_name === '') {
        $errors[] = " Empty state or district.";
        continue; // Don't stop execution on the first error, continue processing
    }

    $unique_key = strtolower($state_name) . '|' . strtolower($district_name);
    if (in_array($unique_key, $seen_districts)) {
        $errors[] = " Duplicate district in file";
        continue;
    }
    $seen_districts[] = $unique_key;

    // Check state
    $stmt = $conn->prepare("SELECT unique_id FROM state_creation WHERE LOWER(TRIM(state_name)) = LOWER(TRIM(?)) AND is_delete = 0");
    $stmt->execute([$state_name]);
    $state = $stmt->fetch();

    if (!$state) {
        $errors[] = $state_name." State not found ";
        continue;
    }

    $state_id = $state['unique_id'];
   $sess_user_type= $_SESSION['sess_user_type'];
  $user_type_unique_id=  $_SESSION['user_type_unique_id'];
 $sess_user_id= $_SESSION['sess_user_id'];
  $sess_company_id=  $_SESSION['sess_company_id'];
  $sess_branch_id=  $_SESSION['sess_branch_id'];
 $acc_year=   $_SESSION["acc_year"];
 $session_id="2r05jb0e2mrdamrhieecjcieg3";
    // Check district already exists
    $check = $conn->prepare("SELECT COUNT(*) FROM district_creation WHERE LOWER(TRIM(district_name)) = LOWER(TRIM(?)) AND is_delete = 0");
    $check->execute([$district_name]);
    if ($check->fetchColumn() > 0) {
        $errors[] = $district_name." District already exists";
        continue;
    }

    $unique_id = uniqid("");
    $insert_data[] = [$unique_id, $district_name, $state_id,$acc_year,$session_id,$sess_user_type,$sess_user_id,$sess_company_id,$sess_branch_id];
}

// Insert into DB
if (!empty($insert_data)) {
    $stmt = $conn->prepare("INSERT INTO district_creation(unique_id, district_name, state_name,acc_year, session_id, sess_user_type, sess_user_id, sess_company_id, sess_branch_id) VALUES (?, ?, ?,?,?,?,?,?,?)");
    foreach ($insert_data as $data) {
        $stmt->execute($data);
    }
}

if (!empty($errors)) {
    echo json_encode([
        "status" => "error",
        "message" => implode("\n",$errors)
    ]);
} else {
    echo json_encode(["status" => "success", "message" => "All records uploaded successfully."]);
}
?>



