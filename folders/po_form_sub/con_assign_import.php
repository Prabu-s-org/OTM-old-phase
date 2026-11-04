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
ob_start(); // Prevent accidental output
error_reporting(0);
ini_set('display_errors', 0);

$form_main_unique_id = $_POST['form_main_unique_id'] ?? '';
$product_unique_id = $_POST['$product_unique_id'] ?? '';
$batch_id = $_POST['batch_id'] ?? '';
$po_number = $_POST['po_number'] ?? '';

$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

// Assuming file upload and validation part is already done
if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    $file_path = $_FILES['file']['tmp_name'];
    $xlsx = new SimpleXLSX($file_path);
    $rows = $xlsx->rows();
    $prefix = 'PO_';

    // new changes validationn12-04-2025======================================================================
    $form_main_unique_id = $_POST['form_main_unique_id'] ?? ''; // Assuming it’s posted from JS


// individual product wise qty validationn12-04-2025

// $stmt = $conn->prepare('SELECT unique_id, qty FROM product_details_sub WHERE form_main_unique_id = ? AND is_delete = 0');
// $stmt->execute([$form_main_unique_id]);
// // print_r($stm);
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// // print_r($products );die();
// foreach ($products as $row) {
//     echo "Product Unique ID: " . $row['unique_id'] . " | Qty: " . $row['qty'] . "<br>";
// }

// // print_r();

// // / Get total qty for this product_unique_id from product_details_sub
// $stmt_product = $conn->prepare('SELECT qty FROM product_details_sub WHERE form_main_unique_id = ? AND product_unique_id = ? AND is_delete = 0 LIMIT 1');
// $stmt_product->execute([$form_main_unique_id, $row['unique_id']);
// $product_total_qty = (int) $stmt_product->fetchColumn();

// // Get assigned qty for this product_unique_id from po_product_assign_details
// $stmt_assigned = $conn->prepare('SELECT SUM(assign_qty) as assigned FROM po_product_assign_details WHERE form_main_unique_id = ? AND product_unique_id = ? AND is_delete = 0');
// $stmt_assigned->execute([$form_main_unique_id, $product_unique_id]);
// $already_assigned_qty = (int) $stmt_assigned->fetchColumn();

// // Add current Excel row assign_qty to already assigned
// $current_excel_assign_qty = is_numeric($assign_qty) ? (int)$assign_qty : 0;
// $total_assign_after_this = $already_assigned_qty + $current_excel_assign_qty;

// if ($total_assign_after_this > $product_total_qty) {
//     echo json_encode([
//         'status' => 'error',
//         'message' => "Upload failed. Assigned quantity for product '$product_unique_id' exceeds available quantity ($product_total_qty)."
//     ]);
//     exit;
// }


// end



$excel_qty_total = 0;
for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    $qty_raw = $row[11] ?? '';
    $qty_clean = is_numeric(trim($qty_raw)) ? (int) trim($qty_raw) : 0;

    // echo "Row {$i}: Original: '{$qty_raw}', Clean: {$qty_clean}<br>";
    $excel_qty_total += $qty_clean;
}

    // Step 2: Get total quantity from DB for this form_main_unique_id
    $stmt = $conn->prepare('SELECT SUM(qty) as total_qty FROM product_details_sub WHERE form_main_unique_id = ? AND is_delete = 0');
    $stmt->execute([$form_main_unique_id]);
    $db_qty_total = (int) $stmt->fetchColumn();
    
    
    
    // Step 2: Get total quantity from DB for this form_main_unique_id
    $stmt_po_asign = $conn->prepare('SELECT SUM(assign_qty) as total_qty FROM po_product_assign_details WHERE form_main_unique_id = ? AND is_delete = 0');
     $stmt_po_asign->execute([$form_main_unique_id]);
    // print
    $poassign_qty_total = (int)   $stmt_po_asign->fetchColumn();
    
  
    
    $total_qty=$db_qty_total- $poassign_qty_total ;
    //   print_r( $total_qty); die();
    
    if( $poassign_qty_total==""){
         $stmt = $conn->prepare('SELECT SUM(qty) as total_qty FROM product_details_sub WHERE form_main_unique_id = ? AND is_delete = 0');
    $stmt->execute([$form_main_unique_id]);
    $total_qty = (int) $stmt->fetchColumn();
    
    //   print_r("hi. $total_qty"); 
    }
    else{
        //  $total_qty= $poassign_qty_total-  $db_qty_total;
        $total_qty=$db_qty_total- $poassign_qty_total;
         
        //   print_r("hloo. $total_qty"); 
    }
    // print_r();die();

    // Step 3: If the Excel qty is greater than the DB qty, stop the import
    if ($excel_qty_total >   $total_qty) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Upload failed. Imported quantity (' . $excel_qty_total . ') is greater than available quantity (' . $total_qty . ').'
        ]);
        exit;
    } else {
        // Step 4: Proceed with importing data into the database
        try {
            // Prepare stored procedure call
            $stmt = $conn->prepare("CALL insert_po_product_assign_details(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");

            // Loop through each row of the Excel sheet
            foreach ($rows as $index => $fields) {
                
                // Skip header row if needed
              $con_name               = $fields[0] ?? '';
        $con_contact_no         = $fields[1] ?? '';
        $con_address            = $fields[2] ?? '';
        $batch_id_xls           = $fields[3] ?? '';
        $po_number_xls          = $fields[4] ?? '';
        $item_code              = $fields[5] ?? '';
        $product                = $fields[6] ?? '';
        $qty                    = $fields[7] ?? 0;  // Assuming qty is in index 6
        $assign_qty             = $fields[11] ?? 0; // Assuming assign_qty is in index 10
        $form_main_unique_id    =  $form_main_unique_id;
        $con_unique_id          = $fields[8] ?? '';
        $product_unique_id      = $fields[9] ?? '';
        $unit_price             = $fields[10] ?? '';
        $unique_id              = unique_id($prefix);  // Assuming this generates a unique ID.
        
        
        
        
    $current_excel_assign_qty = is_numeric($assign_qty) ? (int) $assign_qty : 0;

    // --- Step 1: Get total available qty from product_details_sub
    $stmt_product = $conn->prepare('SELECT qty FROM product_details_sub WHERE form_main_unique_id = ? AND unique_id = ? AND is_delete = 0 LIMIT 1');
    $stmt_product->execute([$form_main_unique_id, $product_unique_id]);
    $product_total_qty = (int) $stmt_product->fetchColumn();

    // --- Step 2: Get total already assigned qty for same product
    $stmt_assigned = $conn->prepare('SELECT SUM(assign_qty) FROM po_product_assign_details WHERE form_main_unique_id = ? AND product_unique_id = ? AND is_delete = 0');
    $stmt_assigned->execute([$form_main_unique_id, $product_unique_id]);
    $already_assigned_qty = (int) $stmt_assigned->fetchColumn();

    // --- Step 3: Check if new assign_qty will exceed the available qty
    $total_assign_after_this = $already_assigned_qty + $current_excel_assign_qty;

    if ($total_assign_after_this > $product_total_qty) {
        echo json_encode([
            'status' => 'error',
            'message' => "Upload failed. Assigned quantity for product '$product_unique_id' exceeds available quantity ($product_total_qty)."
        ]);
        exit;
    }

        
        
        
        
        
        

                // If validation passes, execute stored procedure for this row
                $stmt->execute([
                     $unique_id,
            $form_main_unique_id,
            $con_unique_id,
            $con_name,
            $con_contact_no,
            $con_address,
            $unit_price,
            $product_unique_id,
            $item_code,
            $product,
            $qty,
            $assign_qty,
            $batch_id_xls,
            $po_number_xls
                    // $batch_id_xls,
                    // $po_number_xls
                ]);
            }
            ob_end_clean(); // Clean the buffer
            echo json_encode(['status' => 'success', 'message' => 'Upload successful.']);
        } catch (Exception $e) {
            // Catch any errors that happen within the database interaction.
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Please upload an Excel file.']);
}
?>

