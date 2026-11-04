<?php
function unique_id($prefix = "") {
    return $prefix . uniqid() . rand(10000, 99999);
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'database.php';
include_once 'update_api.php';

$database = new Database();
$db = $database->getConnection();
$item = new Poassign($db);

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || empty($data)) {
    http_response_code(400);
    echo json_encode(["status" => false, "message" => "Input must be a non-empty JSON array."]);
    exit;
}

$success = 0;
$updated = 0;
$failed = 0;
$errors = [];

foreach ($data as $index => $record) {
    if (
        !empty($record['form_main_unique_id']) &&
        !empty($record['batch_id']) &&
        !empty($record['con_unique_id']) &&
        !empty($record['con_name']) &&
        !empty($record['con_main_address']) &&
        !empty($record['unit_price']) &&
        !empty($record['product_unique_id']) &&
        !empty($record['item_code']) &&
        !empty($record['item_name']) &&
        !empty($record['qty']) &&
       
        !empty($record['po_number']) // ✅ Add this check
    ) {
        // echo $record['bill_qty'];
        //   !empty($record['bill_qty']) &&
        // Assign values
        $item->form_main_unique_id = $record['form_main_unique_id'];
        $item->batch_id            = $record['batch_id'];
        $item->con_unique_id       = $record['con_unique_id'];
        $item->con_name            = $record['con_name'];
        $item->con_contact_no      = $record['con_contact_no'];
        $item->con_address         = $record['con_main_address'];
        $item->unit_price          = $record['unit_price'];
        $item->product_unique_id   = $record['product_unique_id'];
        $item->item_code           = $record['item_code'];
        $item->product             = $record['item_name'];
        $item->qty                 = $record['qty'];
        $item->assign_qty          = $record['bill_qty'];
        $item->po_number           = $record['po_number']; // ✅ Add this line

        // Check if record exists
        $checkQuery = "SELECT id FROM po_product_assign_details 
                       WHERE form_main_unique_id = :form_main_unique_id 
                         AND batch_id = :batch_id 
                         AND con_contact_no = :con_contact_no 
                         AND product_unique_id = :product_unique_id";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindParam(":form_main_unique_id", $item->form_main_unique_id);
        $checkStmt->bindParam(":batch_id", $item->batch_id);
        $checkStmt->bindParam(":con_contact_no", $item->con_contact_no);
        $checkStmt->bindParam(":product_unique_id", $item->product_unique_id);
        $checkStmt->execute();
        $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
        if ($existing) {
            $item->id = $existing['id'];
            if ($item->updatePoassign()) {
                $updated++;
            } else {
                $failed++;
                $errors[] = "Failed to update record at index $index.";
            }
        } 
        // else {
        //     $item->unique_id = unique_id("PO_");
        //     if ($item->createPoassign()) {
        //         $success++;
        //     } else {
        //         $failed++;
        //         $errors[] = "Failed to insert record at index $index.";
        //     }
        // }
    } else {
        $failed++;
        $errors[] = "Missing required fields at index $index.";
    }
}

$response = [
    "status" => ($success + $updated) > 0,
    "inserted" => $success,
    "updated" => $updated,
    "failed" => $failed,
    "errors" => $errors
];

http_response_code(($success + $updated) > 0 ? 200 : 400);
echo json_encode($response); 
?>

