<?php
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

session_start();

$form_main_unique_id = $_POST['form_main_unique_id'] ?? '';
$batch_id = $_POST['batch_id'] ?? '';
$po_number = $_POST['po_number'] ?? '';

$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    $file_path = $_FILES['file']['tmp_name'];
    $xlsx = new SimpleXLSX($file_path);
    $rows = $xlsx->rows();
    $prefix = 'PO_';

    // if (count($rows) <= 1) {
    //     echo json_encode(['status' => 'error', 'message' => 'No data found in Excel.']);
    //     exit;
    // }
    
    
    

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO po_product_assign_details (con_name,con_contact_no,batch_id,po_number,item_code,product,qty,form_main_unique_id, unique_id, con_unique_id, product_unique_id, unit_price, assign_qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($rows as $index => $fields) {
        
        // if ($index === 0) continue; // skip header

       
         $con_name               = $fields[0] ?? '';
        $con_contact_no               = $fields[1] ?? '';
        $batch_id_xls           = $fields[2] ?? '';
        $po_number_xls          = $fields[3] ?? '';
        $item_code              = $fields[4] ?? '';
        $product                = $fields[5] ?? '';
        $qty                    = $fields[6] ?? '';
        $form_main_unique_id    =  $form_main_unique_id;
        $con_unique_id          = $fields[7] ?? '';
        $product_unique_id      = $fields[8] ?? '';
        $unit_price             = $fields[9] ?? '';
        $assign_qty             = $fields[10] ?? '';
        $unique_id              = unique_id($prefix);


      


        $stmt->execute([
            $con_name,
            $con_contact_no,
            $batch_id_xls,
            $po_number_xls,
            $item_code,
            $product,
            $qty,
            $form_main_unique_id,
            $unique_id,
            $con_unique_id,
            $product_unique_id,
            $unit_price,
            $assign_qty
        ]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Upload successful.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Please upload an Excel file.']);
}
?>

