<?php
include 'config/dbconfig.php'; // Ensure database connection

$response = ["status" => false, "zone" => ""];

if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
    $search_key = trim($_POST['search_key']);

    // Prepare the SQL query
    $query = "SELECT zone FROM vendor_allocation 
              WHERE zone LIKE :search_key AND is_active = 1 AND is_delete = 0 
              LIMIT 1";

    $stmt = $pdo->prepare($query);
    $stmt->execute(["search_key" => $search_key . "%"]); // Proper concatenation

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($data) {
        $response["status"] = true;
        $response["zone"] = $data['zone'];
    }
}

// Set response header & return JSON data
header('Content-Type: application/json');
echo json_encode($response);
?>

