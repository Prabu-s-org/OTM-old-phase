<?php
require_once __DIR__ . '/../../config/env.php';
$conn = new mysqli("localhost", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'), "operation_team_beta");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo "Connected Successfully";
$conn->query("CALL update_po_department_count()");
$conn->close();
}
?>



