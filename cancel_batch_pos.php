<?php
/**
 * Script to Cancel / Soft-Delete Specific POs and their dependent records
 * Usage:
 *   Browser: http://localhost/otm_beta/cancel_batch_pos.php (Preview / Dry Run)
 *            http://localhost/otm_beta/cancel_batch_pos.php?action=cancel&confirm=yes (Execute PO Cancellation)
 *            http://localhost/otm_beta/cancel_batch_pos.php?action=delete&confirm=yes (Execute PO Deletion)
 *   CLI:     D:\xampp\php\php.exe cancel_batch_pos.php
 *            D:\xampp\php\php.exe cancel_batch_pos.php --action=cancel --confirm
 *            D:\xampp\php\php.exe cancel_batch_pos.php --action=delete --confirm
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/config/dbconfig.php';

$po_numbers = [
    'GEMC-511687773441943',
    'GEMC-511687766373213',
    'GEMC-511687777830264',
    'GEMC-511687773320612',
    'GEMC-511687710807908',
    'GEMC-511687761684399',
    'GEMC-511687721753238',
    'GEMC-511687700226425',
    'GEMC-511687787238108',
    'GEMC-511687787975346',
    'GEMC-511687761416175',
    'GEMC-511687759142513',
    'GEMC-511687735664467',
    'GEMC-511687793255369',
    'GEMC-511687799972080',
    'GEMC-511687787956687',
    'GEMC-511687761537357',
    'GEMC-511687737465063',
    'GEMC-511687799303381',
    'GEMC-511687790037414',
    'GEMC-511687707106258',
    'GEMC-511687747139220',
    'GEMC-511687720284700',
    'GEMC-511687711997010',
    'GEMC-511687798934670',
    'GEMC-511687739535804',
    'GEMC-511687777147849',
    'GEMC-511687774746410',
    'GEMC-511687701924178',
    'GEMC-511687792057593',
    'GEMC-511687772594655',
    'GEMC-511687782676845',
    'GEMC-511687764696632',
    'GEMC-511687735199816',
    'GEMC-511687760026225',
    'GEMC-511687722122977',
    'GEMC-511687727909045',
    'GEMC-511687767355625',
    'GEMC-511687783299333',
    'GEMC-511687719313006',
    'GEMC-511687780795680',
    'GEMC-511687792243055',
    'GEMC-511687766986583',
    'GEMC-511687795990966',
    'GEMC-511687702746783',
    'GEMC-511687717020222',
    'GEMC-511687734091720',
    'GEMC-511687729579459',
    'GEMC-511687705939345'
];

$is_cli = (php_sapi_name() === 'cli');
$action = '';
$confirm = false;

if ($is_cli) {
    $options = getopt('', ['action:', 'confirm']);
    $action = $options['action'] ?? '';
    $confirm = isset($options['confirm']);
} else {
    $action = $_GET['action'] ?? '';
    $confirm = (isset($_GET['confirm']) && $_GET['confirm'] === 'yes');
}

echo $is_cli ? "\n=== PO Batch Cancellation / Deletion Tool ===\n" : "<h2>PO Batch Cancellation / Deletion Tool</h2><pre>";

try {
    // 1. Fetch matching PO records
    $in_placeholders = implode(',', array_fill(0, count($po_numbers), '?'));
    $stmt = $conn->prepare("SELECT unique_id, po_number, is_delete, reject_reason FROM po_form WHERE po_number IN ($in_placeholders)");
    $stmt->execute($po_numbers);
    $found_pos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $found_po_numbers = array_column($found_pos, 'po_number');
    $unique_ids = array_column($found_pos, 'unique_id');

    echo "Total Target POs: " . count($po_numbers) . "\n";
    echo "Found in Database: " . count($found_pos) . "\n";

    $missing = array_diff($po_numbers, $found_po_numbers);
    if (!empty($missing)) {
        echo "\n[Notice] The following POs were NOT found in po_form table:\n";
        foreach ($missing as $m) {
            echo " - $m\n";
        }
    }

    if (empty($unique_ids)) {
        echo "\nNo matching POs found to process.\n";
        if (!$is_cli) echo "</pre>";
        exit;
    }

    $u_placeholders = implode(',', array_fill(0, count($unique_ids), '?'));

    // Count dependent records
    $dependent_tables = [
        'product_details_sub'       => 'form_main_unique_id',
        'consignee_details_sub'     => 'form_main_unique_id',
        'po_product_assign_details' => 'form_main_unique_id',
        'stock_position'            => 'form_main_unique_id',
        'stock_position_main'       => 'form_main_unique_id',
        'stock_position_sublist'    => 'form_main_unique_id',
        'invoice_creation'          => 'po_unique_id',
        'invoice_creation_main'     => 'form_main_unique_id',
        'invoice_sublist'           => 'form_main_unique_id'
    ];

    echo "\nDependent Records Summary:\n";
    foreach ($dependent_tables as $tbl => $col) {
        $q = $conn->prepare("SELECT COUNT(*) AS cnt FROM $tbl WHERE $col IN ($u_placeholders)");
        $q->execute($unique_ids);
        $res = $q->fetch(PDO::FETCH_ASSOC);
        echo " - $tbl ($col): " . ($res['cnt'] ?? 0) . " records\n";
    }

    if (!$confirm || !in_array($action, ['cancel', 'delete'])) {
        echo "\n[DRY RUN MODE - NO CHANGES MADE]\n";
        echo "To execute CANCEL (sets reject_reason & is_delete = 1 across all tables):\n";
        if ($is_cli) {
            echo " Run: D:\\xampp\\php\\php.exe cancel_batch_pos.php --action=cancel --confirm\n";
        } else {
            echo ' Click: <a href="?action=cancel&confirm=yes">Execute CANCEL Now</a>' . "\n";
        }
        echo "\nTo execute DELETE (sets is_delete = 1 across all tables):\n";
        if ($is_cli) {
            echo " Run: D:\\xampp\\php\\php.exe cancel_batch_pos.php --action=delete --confirm\n";
        } else {
            echo ' Click: <a href="?action=delete&confirm=yes">Execute DELETE Now</a>' . "\n";
        }
        if (!$is_cli) echo "</pre>";
        exit;
    }

    // 2. Perform Execution within Transaction
    $conn->beginTransaction();
    echo "\nStarting Transaction ($action)...\n";

    if ($action === 'cancel') {
        $reason = 'Cancelled by GeM / User Request';
        $params = array_merge([$reason], $unique_ids);
        $update_po = $conn->prepare("UPDATE po_form SET is_delete = 1, reject_reason = ? WHERE unique_id IN ($u_placeholders)");
        $update_po->execute($params);
        echo " -> po_form: Updated " . $update_po->rowCount() . " rows (marked cancelled with reject reason)\n";
    } else if ($action === 'delete') {
        $update_po = $conn->prepare("UPDATE po_form SET is_delete = 1 WHERE unique_id IN ($u_placeholders)");
        $update_po->execute($unique_ids);
        echo " -> po_form: Updated " . $update_po->rowCount() . " rows (marked is_delete = 1)\n";
    }

    // Cascade update all dependent tables
    foreach ($dependent_tables as $tbl => $col) {
        $upd = $conn->prepare("UPDATE $tbl SET is_delete = 1 WHERE $col IN ($u_placeholders)");
        $upd->execute($unique_ids);
        echo " -> $tbl: Updated " . $upd->rowCount() . " rows (marked is_delete = 1)\n";
    }

    $conn->commit();
    echo "\n[SUCCESS] All records have been successfully " . strtoupper($action) . "LED!\n";

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "\n[ERROR] " . $e->getMessage() . "\n";
}

if (!$is_cli) {
    echo "</pre>";
}
