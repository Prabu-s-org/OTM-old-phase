<?php
require_once __DIR__ . '/../../config/env.php';
require_once '../../config/dbconfig.php'; // Adjust path as needed
header('Content-Type: application/json');

try {
    $batch_id = $_POST['batch_id'] ?? '';

    if (empty($batch_id)) {
        throw new Exception('Batch ID is required.');
    }

    // Create PDO instance (if not already set in config)
    $pdo = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = "
        SELECT 
            con_address,
            (
                SELECT SUM(qty) 
                FROM product_details_sub 
                WHERE product_details_sub.form_main_unique_id = po_product_assign_details.form_main_unique_id
            ) AS order_qty,
            SUM(assign_qty) AS assign_qty,
            con_contact_no
        FROM po_product_assign_details
        WHERE batch_id = :batch_id
        GROUP BY con_address, con_contact_no, form_main_unique_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['batch_id' => $batch_id]);
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



