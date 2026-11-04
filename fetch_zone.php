<?php
require_once __DIR__ . '/config/env.php';
// // Database connection using MySQLi
// $conn1 = mysqli_connect("localhost", "root", "", "operation_team");

// // Check connection
// if (!$conn1) {
//     die(json_encode(["status" => false, "error" => mysqli_connect_error()]));
// }

// $response = ["status" => false, "zone" => ""];

// if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
//     $search_key = trim($_POST['search_key']) . "%"; // Append '%' for LIKE search

//     // Prepare the SQL query using MySQLi
//     $query = "SELECT zone FROM vendor_allocation WHERE zone LIKE ? AND is_active = 1 AND is_delete = 0 LIMIT 1";

//     $stmt = mysqli_prepare($conn1, $query);
    
//     if ($stmt) {
//         // Bind parameters (s = string)
//         mysqli_stmt_bind_param($stmt, "s", $search_key);
        
//         // Execute the query
//         mysqli_stmt_execute($stmt);
        
//         // Get the result
//         $result = mysqli_stmt_get_result($stmt);
        
//         // Fetch the data
//         if ($data = mysqli_fetch_assoc($result)) {
//             $response["status"] = true;
//             $response["zone"] = $data['zone'];
//         }

//         // Close the statement
//         mysqli_stmt_close($stmt);
//     }
// }

// // Close the database connection
// mysqli_close($conn1);

// // Return JSON response
// header('Content-Type: application/json');
// echo json_encode($response);

$conn1 = mysqli_connect(project_env('APP_DB_HOST', 'localhost'), project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'), project_env('ZONE_DB_NAME', 'operation_team'));

if (!$conn1) {
    die(json_encode(["status" => false, "error" => mysqli_connect_error()]));
}

$response = ["status" => false, "zones" => []];

if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
    $search_key = trim($_POST['search_key']) . "%";

    $query = "SELECT DISTINCT zone FROM vendor_allocation WHERE zone LIKE ? AND is_active = 1 AND is_delete = 0 LIMIT 10";
    
    $stmt = mysqli_prepare($conn1, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $search_key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $response["zones"][] = $row['zone'];
        }
        $response["status"] = true;

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn1);

header('Content-Type: application/json');
echo json_encode($response);


?>

