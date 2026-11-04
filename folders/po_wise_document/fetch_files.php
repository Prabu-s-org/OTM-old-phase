<?php
include '../../config/dbconfig.php';

$otm_root = dirname(dirname(__DIR__));

$form_main_unique_id = $_REQUEST['id'] ?? $_POST['id'] ?? $_GET['id'] ?? '';
$raw_doc_type = $_REQUEST['doc_type'] ?? $_POST['doc_type'] ?? $_GET['doc_type'] ?? '';
$state_name = $_REQUEST['state_name'] ?? $_POST['state_name'] ?? $_GET['state_name'] ?? '';
$district = $_REQUEST['district'] ?? $_POST['district'] ?? $_GET['district'] ?? '';
$zone = $_REQUEST['zone'] ?? $_POST['zone'] ?? $_GET['zone'] ?? '';
$selected_files = $_REQUEST['selected_files'] ?? $_POST['selected_files'] ?? $_GET['selected_files'] ?? []; // array of selected files
if (!is_array($selected_files) && !empty($selected_files)) {
    $selected_files = [$selected_files];
}
$list_only = isset($_REQUEST['list_only']) ? (bool) $_REQUEST['list_only'] : false;

if (!empty($state_name) || !empty($district) || !empty($zone)) {
    $table_details_1 = [
        "consignee_details_sub",
        [
            'unique_id AS consignee_id'
        ]
    ];

    $select_where_1 = ' is_delete = 0 AND form_main_unique_id  ="' . $form_main_unique_id . '"';

    if (!empty($state_name)) {

        $select_where_1 .= 'AND con_state_name="' . $state_name . '"';
    }
    if (!empty($district)) {

        $select_where_1 .= 'AND con_district="' . $district . '"';
    }

    if (!empty($zone)) {

        $select_where_1 .= 'AND zone="' . $zone . '"';
    }

    $consignee_id = $pdo->select($table_details_1, $select_where_1);

    if (!empty($consignee_id->data)) {
        $consignee_ids = array_column($consignee_id->data, 'consignee_id');
    }
    // Convert to string for SQL: 'id1','id2','id3'
    $consignee_ids_str = "'" . implode("','", $consignee_ids) . "'";
}
// print_r($consignee_ids_str);
// === MAP document type to table/column/path ===
$docConfig = [
    'unsigned_dc' => [
        'table' => 'invoice_sublist',
        'columns' => ['dc_file_name AS file_name', 'get_po_number(form_main_unique_id) AS po_num'],
        'field' => 'dc_file_name',
        'path' => $otm_root . "/uploads/invoice/"
    ],
    'unsigned_ir' => [
        'table' => 'invoice_sublist',
        'columns' => ['ir_file_name AS file_name', 'get_po_number(form_main_unique_id) AS po_num'],
        'field' => 'ir_file_name',
        'path' => $otm_root . "/uploads/invoice/"
    ],
    'inv' => [
        'table' => 'invoice_sublist',
        'columns' => ['file_invoice AS file_name', 'get_po_number(form_main_unique_id) AS po_num'],
        'field' => 'file_invoice',
        'path' => $otm_root . "/uploads/invoice/"
    ],
    'po' => [
        'table' => 'view_doc_approval_list_final',
        'columns' => ['file_name', 'get_po_number(form_main_unique_id) AS po_num'],
        'field' => 'file_name',
        'path' => $otm_root . "/uploads/invoice/"
    ],
    'podproof' => [
        'table' => 'dispatch_list',
        'columns' => ['pod_proof AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'pod_proof',
        'path' => $otm_root . "/uploads/dispatch/"
    ],
    'deliveryproof' => [
        'table' => 'dispatch_list',
        'columns' => ['delivery_proof AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'delivery_proof',
        'path' => $otm_root . "/uploads/dispatch/"
    ],
    'einvoice' => [
        'table' => 'dispatch_list',
        'columns' => ['einvoice_file AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'einvoice',
        'path' => $otm_root . "/uploads/dispatch/"
    ],
    'signed_dc' => [
        'table' => 'installation_details_sublist',
        'columns' => ['dc_file AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'dc_file',
        'path' => $otm_root . "/uploads/installation/"
    ],
    'signed_ir' => [
        'table' => 'installation_details_sublist',
        'columns' => ['ir_file AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'ir_file',
        'path' => $otm_root . "/uploads/installation/"
    ],
    'signed_snr' => [
        'table' => 'installation_details_sublist',
        'columns' => ['snr_file AS file_name', 'get_po_number(po_form_unique_id) AS po_num'],
        'field' => 'snr_file',
        'path' => $otm_root . "/uploads/installation/"
    ]
];

// === Normalize & Validate doc type ===
$docTypeMap = [
    'unsigned_dc'    => 'unsigned_dc',
    'unsigneddc'     => 'unsigned_dc',
    'unsigned_ir'    => 'unsigned_ir',
    'unsignedir'     => 'unsigned_ir',
    'inv'            => 'inv',
    'invoice'        => 'inv',
    'invoices'       => 'inv',
    'po'             => 'po',
    'podproof'       => 'podproof',
    'pod_proof'      => 'podproof',
    'deliveryproof'  => 'deliveryproof',
    'delivery_proof' => 'deliveryproof',
    'einvoice'       => 'einvoice',
    'e_invoice'      => 'einvoice',
    'e-invoice'      => 'einvoice',
    'einvoices'      => 'einvoice',
    'e_invoices'     => 'einvoice',
    'signed_dc'      => 'signed_dc',
    'signeddc'       => 'signed_dc',
    'signed_ir'      => 'signed_ir',
    'signedir'       => 'signed_ir',
    'signed_snr'     => 'signed_snr',
    'signedsnr'      => 'signed_snr',
];

$clean_key = strtolower(trim(str_replace([' ', '-', '_'], '', (string)$raw_doc_type)));
$doc_type = $docTypeMap[$raw_doc_type] ?? $docTypeMap[$clean_key] ?? strtolower(trim((string)$raw_doc_type));

if (!isset($docConfig[$doc_type])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid document type: ' . ($raw_doc_type !== '' ? $raw_doc_type : 'None provided')]);
    exit;
}

$config = $docConfig[$doc_type];
$table_details = [$config['table'], $config['columns']];

if (in_array($doc_type, ['podproof', 'deliveryproof', 'signed_dc', 'signed_ir', 'signed_snr', 'einvoice'])) {
    $where = "(po_form_unique_id = '$form_main_unique_id' OR po_unique_id = '$form_main_unique_id')";
    if ($doc_type === 'einvoice') {
        $where .= " AND is_delete = 0 AND einvoice_file IS NOT NULL AND einvoice_file != ''";
    }
} else {
    $where = "form_main_unique_id = '$form_main_unique_id'";
}

if (!empty($state_name) || !empty($district)) {

    $where .= " AND consignee_unique_id IN ($consignee_ids_str)";
}

$result = $pdo->select($table_details, $where);

// Fallback for einvoice: also check invoice_creation_main_payment_data if no files found in dispatch_list
if (($doc_type === 'einvoice') && (!$result->status || empty($result->data))) {
    $table_fallback = ['invoice_creation_main_payment_data', ['einvoice_file AS file_name', 'get_po_number(form_main_unique_id) AS po_num']];
    $where_fallback = "form_main_unique_id = '$form_main_unique_id' AND einvoice_file IS NOT NULL AND einvoice_file != ''";
    if (!empty($state_name) || !empty($district)) {
        $where_fallback .= " AND consignee_unique_id IN ($consignee_ids_str)";
    }
    $result_fallback = $pdo->select($table_fallback, $where_fallback);
    if ($result_fallback->status && !empty($result_fallback->data)) {
        $result = $result_fallback;
    }
}

if (!$result->status || empty($result->data)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No files found']);
    exit;
}

$rows = $result->data;
$po_num = !empty($rows[0]['po_num']) ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $rows[0]['po_num']) : 'PO';
$baseDir = $config['path'];

// === LIST MODE ===
if ($list_only) {
    $all_files = [];
    foreach ($rows as $row) {
        if (!empty($row['file_name'])) {
            $all_files[] = $row['file_name'];
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['files' => $all_files]);
    exit;
}

// === DOWNLOAD MODE ===
if (empty($selected_files)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No files selected']);
    exit;
}

function resolveDocPath($baseDir, $file) {
    $filePath = $baseDir . $file;
    if (file_exists($filePath)) {
        return $filePath;
    }
    // Search subdirectories (e.g., academic year folders like 2025-2026)
    $subdirs = glob($baseDir . '*', GLOB_ONLYDIR);
    if (!empty($subdirs)) {
        foreach ($subdirs as $dir) {
            $candidate = $dir . DIRECTORY_SEPARATOR . $file;
            if (file_exists($candidate)) {
                return $candidate;
            }
        }
    }
    return false;
}

// ✅ Individual download (if only one file is selected)
if (count($selected_files) === 1) {
    $filePath = resolveDocPath($baseDir, $selected_files[0]);
    if (!$filePath || !file_exists($filePath)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'File not found']);
        exit;
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($selected_files[0]) . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}


$part = max(1, (int) ($_POST['zip_part'] ?? 1));

$filesForThisPart = $selected_files; // ✅ already chunked by JS

if (empty($filesForThisPart)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No files for this ZIP part']);
    exit;
}


$zipFileName = $po_num . '_' . $doc_type . '_part' . $part . '.zip';
$zipPath = sys_get_temp_dir() . '/' . $zipFileName;

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Could not create ZIP']);
    exit;
}

$added = 0;

foreach ($filesForThisPart as $file) {
    $filePath = resolveDocPath($baseDir, $file);
    if ($filePath && is_file($filePath)) {
        $zip->addFile($filePath, basename($file));
        $added++;
    }
}

if ($added === 0) {
    unlink($zipPath);
    echo json_encode(['error' => 'No valid files found for this ZIP']);
    exit;
}


$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($zipPath));
readfile($zipPath);
unlink($zipPath);
exit;

