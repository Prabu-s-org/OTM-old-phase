<?php
include '../../config/dbconfig.php';

$date = date('Y-m-d');
// $query = "SELECT * FROM po_form WHERE entry_date = '$date' and  status = 'pending' ORDER BY created_at DESC";
$query = "SELECT po.po_unique_id,po.po_num,po.no_of_po,(select count(con_address) as count from consignee_details_sub as cds where cds.form_main_unique_id = po.unique_id ) as cnt FROM `po_form` as po WHERE po.po_date = '$date'";
$result = $conn->query($query);

$po_numbers = [];
while ($row = $result->fetch_assoc()) {
    $po_numbers[] = $row;
}

header('Content-Type: application/json');
echo json_encode($po_numbers);
?>
