<?php
require_once __DIR__ . '/../../config/env.php';
header('Content-Type: application/json');
require_once '../../config/dbconfig.php';

try {
    $batch_id = $_POST['batch_id'] ?? '';
    $con_address = $_POST['con_address'] ?? '';

    if (empty($batch_id) || empty($con_address)) {
        throw new Exception("Batch ID and Consignee Name are required.");
    }

    $pdo = new PDO("mysql:host=localhost;dbname=operation_team", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SELECT 
            item_code,
            product,
            qty,
            assign_qty
        FROM po_product_assign_details
        WHERE batch_id = :batch_id 
        AND con_address LIKE :con_address
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'batch_id' => $batch_id,
        'con_address' => '%' . $con_address . '%'
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>


