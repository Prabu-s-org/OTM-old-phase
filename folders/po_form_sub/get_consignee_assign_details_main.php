<?php
require_once '../../config/dbconfig.php';
header('Content-Type: application/json');

try {
    $batch_id = $_POST['batch_id'] ?? '';

    if (empty($batch_id)) {
        throw new Exception('Batch ID is required.');
    }

    $pdo = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $stmt = $pdo->prepare("SELECT con_name, con_contact_number, item_code, product, qty, assign_qty FROM po_product_assign_details WHERE batch_id = ?");
    $sql = "
SELECT 
    c.con_contact_name AS con_name, 
    c.con_contact_number, 
    p.item_code, 
    p.product, 
    p.qty, 
    p.assign_qty 
FROM 
    po_product_assign_details p
JOIN 
    consignee_details_sub c 
ON 
    p.con_unique_id = c.unique_id 
WHERE 
    p.batch_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$batch_id]);


// $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $rows
    ]);
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>

