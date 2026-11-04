<?php
require_once __DIR__ . '/../../config/env.php';
// excel.php

// Capture filters
$customer_name = $_GET['customer_name'] ?? '';
$po_no         = $_GET['po_no'] ?? '';

// Database connection
$conn = new mysqli("localhost", "root", project_env('VENDOR_DB_PASSWORD'), "operation_team_beta");

// Build query
$sql = "SELECT po_num, po_date
        FROM po_form WHERE 1=1
        -- LEFT JOIN consignee_details_sub cd ON po.unique_id = cd.form_main_unique_id
";

// if ($customer_name != '') {
//     $sql .= " AND po.customer_name = '" . $conn->real_escape_string($customer_name) . "'";
// }
if ($po_no != '') {
    $sql .= " AND po_num = '" . $conn->real_escape_string($po_no) . "'";
}

$result = $conn->query($sql);

// Send headers for Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=po_report.xls");

// Output table
echo "<table border='1'>";
echo "<tr>
        <th>PO No</th>
        <th>PO Date</th>
        <th>Customer</th>
        <th>Consignee</th>
        <th>Address</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['po_num']}</td>";
    echo "<td>{$row['po_date']}</td>";
    echo "</tr>";
}

echo "</table>";
exit;
?>


