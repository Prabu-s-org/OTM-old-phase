<?php
require_once __DIR__ . '/../../config/env.php';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

// DB Connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Retrieve posted data

// Allowed file types for Excel
$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

// Check if the uploaded file is a valid Excel file
if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    // Get the file path
    $file_path = $_FILES['file']['tmp_name'];
    $xlsx = new SimpleXLSX($file_path);
    $rows = $xlsx->rows();
    $uploaded_count  = count($rows);  // Count the number of rows in the Excel file

    // Prepare the SQL insert query
    $stmt = $conn->prepare("INSERT INTO item_creation_sub(
        tender_code, item_code, item_description, item_specification, 
        brand, product_category, short_category, rc_unit_price, rc_net_price, 
        gst, warranty_in_yrs, unique_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Loop through each row in the uploaded Excel file
    foreach ($rows as $index => $fields) {
        // Skip the first row (header)
        // if ($index === 0) continue;

         $rc_net_price = floatval($fields[7]);
            $gst = floatval($fields[8]);
            $rc_unit_price = $rc_net_price / (1 + ($gst / 100));
     


        // Prepare the data for insertion
        $unique_id = uniqid("item_"); // Generate a unique ID for each record
        $tender_code = $fields[0];     // Assuming tender_code is in the first columna
        $item_code = $fields[1];       // Assuming item_code is in the second column
        $item_description = $fields[2]; // Assuming item_description is in the third column
        $item_specification = $fields[3]; // Assuming item_specification is in the fourth column
        $brand = $fields[4];           // Assuming brand is in the fifth column
        $product_category = $fields[5]; // Assuming product_category is in the sixth column
        $short_category = $fields[6];  // Assuming short_category is in the seventh column
        $rc_unit_price = $rc_unit_price;   // Assuming rc_unit_price is in the eighth column
        $rc_net_price = $fields[7];    // Assuming rc_net_price is in the ninth column
        $gst = $fields[8];             // Assuming gst is in the tenth column
        $warranty_in_yrs = $fields[9]; // Assuming warranty_in_yrs is in the eleventh column

        // Execute the SQL query to insert the data
        $stmt->execute([
            $tender_code, $item_code, $item_description, $item_specification,
            $brand, $product_category, $short_category, $rc_unit_price, 
            $rc_net_price, $gst, $warranty_in_yrs, $unique_id
        ]);
        

    }


    // Send success response
    echo json_encode(['status' => 'success', 'message' => 'Upload Successful']);
} else {
    // Send error response if the file type is invalid
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Please upload a valid Excel file.']);
}
?>



