<?php
require_once __DIR__ . '/../../config/env.php';
// Include DB config and helper
include '../../config/dbconfig.php';
include 'simplexlsx.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

// DB connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB connection failed: " . $e->getMessage()]);
    exit;
}

// Allowed Excel MIME types
$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

// Check uploaded file type
if (!in_array($_FILES["file"]["type"], $allowedFileType)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Upload a valid Excel file.']);
    exit;
}

// Load Excel data
$file_path = $_FILES['file']['tmp_name'];
$xlsx = new SimpleXLSX($file_path);
$rows = $xlsx->rows();
$uploaded_count = count($rows);

// Prepare insert query
$stmt = $conn->prepare("
    INSERT INTO item_creation_sub (
        tender_code, item_code, item_description, item_specification, 
        brand, product_category, short_category, rc_unit_price, 
        rc_net_price, gst, warranty_in_yrs, unique_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Loop through Excel rows
foreach ($rows as $index => $fields) {

    // ✅ Skip header row if detected (assumes first row is header)
    if ($index === 0 || strtolower($fields[0]) === 'tender_code') {
        continue;
    }

    // ✅ Skip empty rows
    if (empty($fields[0]) || empty($fields[1])) {
        continue;
    }

    // Extract fields safely
    $tender_code        = trim($fields[0]);
    $item_code          = trim($fields[1]);
    $item_description   = trim($fields[2]);
    $item_specification = trim($fields[3]);
    $brand              = trim($fields[4]);
    $product_category   = trim($fields[5]);
    $short_category     = trim($fields[6]);
    $rc_net_price       = floatval($fields[7]);
    $gst                = floatval($fields[8]); // Avoid dividing by non-numeric values
    $warranty_in_yrs    = trim($fields[9]);

    // ✅ Prevent divide-by-zero or NaN for GST
    $rc_unit_price = ($gst > 0) ? ($rc_net_price / (1 + ($gst / 100))) : $rc_net_price;

    // Unique ID
    $unique_id = uniqid("item_");

    // Execute insert
    try {
        $stmt->execute([
            $tender_code, $item_code, $item_description, $item_specification,
            $brand, $product_category, $short_category, round($rc_unit_price, 2),
            $rc_net_price, $gst, $warranty_in_yrs, $unique_id
        ]);
    } catch (PDOException $e) {
        // Log or handle error per row (optional)
        continue;
    }
}

// Response
echo json_encode(['status' => 'success', 'message' => 'Upload successful. Rows inserted: ' . ($uploaded_count - 1)]);



