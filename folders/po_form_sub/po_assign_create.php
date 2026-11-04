<?php
function unique_id($prefix = "") {
    return $prefix . uniqid() . rand(10000, 99999);
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'database.php';
include_once 'po_assign.php';

$database = new Database();
$db = $database->getConnection();
$item = new Poassign($db);

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true); // decode as associative array

if (!is_array($data) || empty($data)) {
    http_response_code(400);
    echo json_encode(["status" => false, "message" => "Input must be a non-empty JSON array."]);
    exit;
}

$success = 0;
$failed = 0;
$errors = [];

foreach ($data as $index => $record) {
    if (
        !empty($record['form_main_unique_id']) &&
        !empty($record['con_unique_id']) &&
        !empty($record['con_name']) &&
        !empty($record['con_contact_no']) &&
        !empty($record['unit_price']) &&
        !empty($record['product_unique_id']) &&
        !empty($record['item_code']) &&
        !empty($record['item_name']) &&
        !empty($record['qty']) &&
        !empty($record['bill_qty'])
    ) {
        // Assign values
        $item->unique_id            = unique_id("PO_");
        $item->form_main_unique_id = $record['form_main_unique_id'];
        $item->con_unique_id       = $record['con_unique_id'];
        $item->con_name            = $record['con_name'];
        $item->con_contact_no      = $record['con_contact_no'];
        $item->unit_price          = $record['unit_price'];
        $item->product_unique_id   = $record['product_unique_id'];
        $item->item_code           = $record['item_code'];
        $item->product             = $record['item_name'];
        $item->qty                 = $record['qty'];
        $item->assign_qty          = $record['bill_qty'];

        // Optional: Skip if contact exists
        $checkQuery = "SELECT COUNT(*) as count FROM po_product_assign_details WHERE con_contact_no = :con_contact_no";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindParam(":con_contact_no", $item->con_contact_no);
        $checkStmt->execute();
        $exists = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'];

        if ($exists == 0) {
            if ($item->createPoassign()) {
                $success++;
            } else {
                $failed++;
                $errors[] = "Failed to insert record at index $index.";
            }
        } else {
            $failed++;
            $errors[] = "Already contact number at index $index.";
        }
    } else {
        $failed++;
        $errors[] = "Missing required fields at index $index.";
    }
}

// Final response
$response = [
    "status" => $success > 0,
    "success_count" => $success,
    "failed_count" => $failed,
    "errors" => $errors
];

http_response_code($success > 0 ? 200 : 400);
echo json_encode($response);
?>

