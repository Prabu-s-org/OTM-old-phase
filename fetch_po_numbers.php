<?php
require_once __DIR__ . '/config/env.php';
// include 'config/dbconfig.php';
header('Content-Type: application/json');
// $date = date('Y-m-d');

// // SELECT 
// //             po.po_unique_id,
// //             po.po_num,
// //             po.no_of_consignee,
// //             (SELECT COUNT(con_address) FROM consignee_details_sub as cds WHERE cds.form_main_unique_id = po.unique_id) as cnt,
            
// //           FROM po_form as po 
// //           WHERE po.po_date = '$date'
// echo 
// $query = "SELECT 
//     po.po_num, 
//     COUNT(sub.con_address) AS cnt,
//     po.po_date,
//     (select department from department_creation where po.department = department_creation.unique_id) as department
// FROM `po_form` AS po 
// INNER JOIN `consignee_details_sub` AS sub 
//     ON po.unique_id = sub.form_main_unique_id  
// WHERE 
//     po.po_date = '$date' 
//     AND sub.cons_verify_sts = 0 
//     AND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
//     and sub.is_delete = 0 
//     and po.is_delete = 0
// GROUP BY po.po_num";
          
          

// $result = $conn->query($query);

// if (!$result) {
//     die(json_encode(["error" => $conn->error])); // Return SQL error if query fails
// }
// include '../config/dbconfig.php';
$conn1 = mysqli_connect(project_env('APP_DB_HOST', 'localhost'), project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'), project_env('APP_DB_NAME', 'operation_team_beta'));

// Check connection
if (!$conn1) {
    die(json_encode(["error" => mysqli_connect_error()]));
}
// Prevent SQL injection
  $date = date('Y-m-d');

// SQL Query
$query = "SELECT 
    po.po_num, 
    COUNT(sub.con_address) AS cnt, 
    po.po_date, 
    dept.department
FROM `po_form` AS po 
INNER JOIN `consignee_details_sub` AS sub 
    ON po.unique_id = sub.form_main_unique_id  
LEFT JOIN `department_creation` AS dept 
    ON po.department = dept.unique_id
WHERE 
    sub.cons_verify_sts = 2
    AND sub.is_delete = 0 
    AND po.is_delete = 0
GROUP BY po.po_num, po.po_date, dept.department";


// WHERE 
// AND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
//     po.po_date = '$date' 
//     AND sub.cons_verify_sts = 2
//     AND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
//     AND sub.is_delete = 0 
//     AND po.is_delete = 0
// GROUP BY po.po_num, po.po_date, dept.department";

// $result = $conn->query($query);

// // // Check for query errors
// // if (!$result) {
// //     die(json_encode(["error" => $conn->error])); 
// // }

// // $po_numbers = [];
// $po_count_total = 0; // Initialize variable

// while ($row = $result->fetch_assoc()) {
    
//   echo "rro".$po_count_total += (int) $row['cnt']; // Accumulate total count
//     // echo $po_numbers[] = $row; // Store row data
// }
// Database connection

// Execute the query
$result = mysqli_query($conn1, $query);

// Check for query errors
if (!$result) {
    die(json_encode(["error" => mysqli_error($conn)])); 
}

$po_count_total = 0; // Initialize variable
$po_numbers = [];
while ($row = mysqli_fetch_assoc($result)) {

$po_date = $row['po_date']; // assuming 'po_date' is in a valid date format
$formatted_po_date = date("d-m-Y", strtotime($po_date));

    $po_numbers[] = [
        'po_num' => $row['po_num'],
        'cnt'       => $row['cnt'],
        'po_date' => $formatted_po_date,
        'department'          => $row['department']
    ];
}


echo json_encode($po_numbers);
?>

