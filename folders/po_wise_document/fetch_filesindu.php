<?php
include '../../config/dbconfig.php';

$otm_root = dirname(dirname(__DIR__));

$form_main_unique_id = $_REQUEST['id'] ?? $_POST['id'] ?? $_GET['id'] ?? '';
$raw_doc_type = $_REQUEST['doc_type'] ?? $_POST['doc_type'] ?? $_GET['doc_type'] ?? '';
$selectedFiles = $_REQUEST['selected_files'] ?? $_POST['selected_files'] ?? $_GET['selected_files'] ?? []; // array of selected files
if (!is_array($selectedFiles) && !empty($selectedFiles)) {
    $selectedFiles = [$selectedFiles];
}

$clean_key = strtolower(trim(str_replace([' ', '-', '_'], '', (string)$raw_doc_type)));

if ($clean_key === 'podproof' || $clean_key === 'deliveryproof' || $clean_key === 'einvoice') {
    $baseDir = $otm_root . "/uploads/dispatch/";
} elseif ($clean_key === 'unsigneddc' || $clean_key === 'unsignedir' || $clean_key === 'inv' || $clean_key === 'invoice' || $clean_key === 'po') {
    $baseDir = $otm_root . "/uploads/invoice/";
} elseif ($clean_key === 'signeddc' || $clean_key === 'signedir' || $clean_key === 'signedsnr') {
    $baseDir = $otm_root . "/uploads/installation/";
} else {
    $baseDir = $otm_root . "/uploads/dispatch/";
}

function resolveDocPath($baseDir, $file) {
    if (empty($file)) return false;
    $filePath = rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR . $file;
    if (file_exists($filePath)) {
        return $filePath;
    }
    if (file_exists($file)) {
        return $file;
    }
    // Search subdirectories (e.g. academic year folders like 2025-2026)
    $subdirs = glob(rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
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

// If specific files are selected, serve individually
if (!empty($selectedFiles)) {
    $file = $selectedFiles[0]; // only 1 file in individual download
    $filePath = resolveDocPath($baseDir, $file);
    if (!$filePath || !file_exists($filePath)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'File not found: ' . $file]);
        exit;
    }

    // Serve the file as PDF (force download)
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No files selected']);
    exit;
}

