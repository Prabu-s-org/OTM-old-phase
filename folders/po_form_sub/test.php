<?php
function unique_id($prefix = "") {
    return $prefix . uniqid() . rand(10000, 99999);
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'database.php';
// include_once 'update_api.php';

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
        !empty($record['con_contact_no']) &&
        !empty($record['product_unique_id']) &&
        isset($record['bill_qty']) // assign_qty
    ) {
        // Assign values
        $item->form_main_unique_id = $record['form_main_unique_id'];
        $item->batch_id = $record['batch_id'];
        $item->con_contact_no = $record['con_contact_no'];
        $item->product_unique_id = $record['product_unique_id'];
        $item->assign_qty = $record['bill_qty']; // New assign_qty

        // Check for existing record
        $checkQuery = "SELECT id, assign_qty FROM po_product_assign_details 
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
            if ($existing['assign_qty'] != $item->assign_qty) {
                $item->id = $existing['id'];

                // Update only assign_qty field
                $updateQuery = "UPDATE po_product_assign_details SET assign_qty = :assign_qty WHERE id = :id";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->bindParam(":assign_qty", $item->assign_qty);
                $updateStmt->bindParam(":id", $item->id);

                if ($updateStmt->execute()) {
                    $updated++;
                } else {
                    $failed++;
                    $errors[] = "Failed to update assign_qty at index $index.";
                }
            }
        } else {
            $failed++;
            $errors[] = "Record not found for update at index $index.";
        }
    } else {
        $failed++;
        $errors[] = "Missing required fields at index $index.";
    }
}

$response = [
    "status" => $updated > 0,
    "updated" => $updated,
    "failed" => $failed,
    "errors" => $errors
];

http_response_code($updated > 0 ? 200 : 400);
echo json_encode($response);
?>

