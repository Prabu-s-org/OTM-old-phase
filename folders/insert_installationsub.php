<?php
require_once __DIR__ . '/../config/env.php';
$servername = "localhost";
$username = project_env('APP_DB_USERNAME', 'root');
$password = project_env('APP_DB_PASSWORD');
$database_name = "operation_team_beta";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

/* ---------- UNIQUE ID FUNCTION ---------- */
function unique_id($prefix = "")
{
    $unique_id = uniqid() . rand(10000, 99999);
    if ($prefix) {
        $unique_id = $prefix . $unique_id;
    }
    return $unique_id;
}

/* ---------- INSTALLATION NUMBER FUNCTION ---------- */
function ins_no_get($conn)
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;

    $stmt = $conn->query("SELECT installation_id 
                          FROM installation_details_sublist 
                          WHERE installation_id LIKE 'INS-%' 
                          ORDER BY id DESC LIMIT 1");

    $booking_no = 0;

    if ($res1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pur_array = explode('-', $res1['installation_id']);
        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];

        if ($year != date("Y")) {
            $booking_no = 0;
        }
    }

    $booking_no += 1;
    return 'INS-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
}

/* ---------- FETCH DATA TO INSERT ---------- */

$sql = "
SELECT *
FROM installation_details AS id
LEFT JOIN installation_details_sublist AS ids 
    ON id.dc_number = ids.dc_number
WHERE ids.dc_number IS NULL
";

$stmt = $conn->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {

    foreach ($rows as $row) {

        $installation_id = ins_no_get($conn);
        $unique_id_val   = unique_id("INS");

        $insert = $conn->prepare("
            INSERT INTO installation_details_sublist (
                form_unique_id,
                po_form_unique_id,
                po_auto_id,
                po_num,
                po_date,
                invoice_auto_id,
                invoice_no,
                invoice_date,
                consignee_unique_id,
                engineer_name,
                installation_com_date,
                dc_number,
                documents_type,
                documents_type1,
                documents_type2,
                dc_received_sts,
                dc_cus_signed_date,
                ir_rec_status,
                ir_cus_signed_date,
                snr_rec_status,
                snr_cus_signed_date,
                installation_id,
                unique_id
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $insert->execute([
            $row['unique_id'],
            $row['po_form_unique_id'],
            $row['po_auto_id'],
            $row['po_num'],
            $row['po_date'],
            $row['invoice_auto_id'],
            $row['invoice_no'],
            $row['invoice_date'],
            $row['consignee_unique_id'],
            $row['engineer_name'],
            $row['installation_com_date'],
            $row['dc_number'],
            $row['documents_type'],
            $row['documents_type1'],
            $row['documents_type2'],
            $row['dc_received_sts'],
            $row['dc_cus_signed_date'],
            $row['ir_rec_status'],
            $row['ir_cus_signed_date'],
            $row['snr_rec_status'],
            $row['snr_cus_signed_date'],
            $installation_id,
            $unique_id_val
        ]);
    }

    echo "Records inserted successfully.";
} else {
    echo "No new records found.";
}



