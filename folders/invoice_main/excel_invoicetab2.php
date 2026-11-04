<?php

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
include '../../config/dbconfig.php';

// Creating a new PHPExcel object
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

$selected_columns = isset($_GET['columns']) ? explode(',', $_GET['columns']) : [];
$selected_columns = array_map('trim', $selected_columns);

if (empty($selected_columns)) {
    die("No columns selected!");
}

// Define column mappings
$column_map = [
    "1" => ["label" => "Invoice Number", "db_field" => "invoice_no"],
    "2" => ["label" => "PO Number", "db_field" => "po_num"],
    "3" => ["label" => "PO Date", "db_field" => "po_date"],
    "4" => ["label" => "Executive Name", "db_field" => "executive_name"],
    "5" => ["label" => "Department", "db_field" => "department"],
    "6" => ["label" => "Ledger Name", "db_field" => "ledger_name"],
    "7" => ["label" => "Consignee Address", "db_field" => "con_address"],
    "8" => ["label" => "Invoice Qty", "db_field" => "invoice_qty"],
    "9" => ["label" => "Total Value", "db_field" => "invoice_value"],
    "10" => ["label" => "Status", "db_field" => "invoice_doc_status"],
    "11" => ["label" => "Reason", "db_field" => "reject_reason_elcot"]
];

// Setting headers for the Excel sheet
$excel->getActiveSheet()
    ->setCellValue('A1', 'Invoice Report')
    ->mergeCells("A1:K1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Setting column headers dynamically
$col_index = 'A';
foreach ($selected_columns as $col) {
    if (isset($column_map[$col])) {
        $excel->getActiveSheet()->setCellValue($col_index . '3', $column_map[$col]['label']);
        $col_index = chr(ord($col_index) + 1); // Move to next column
    }
}

// Fetching data from the database
$where = "is_delete = '0'";
$selected_db_fields = array_map(fn($col) => $column_map[$col]['db_field'], $selected_columns);

if (empty($selected_db_fields)) {
    die("No valid columns selected for export.");
}

// Fetching data from database
$query = "SELECT " . implode(", ", $selected_db_fields) . " FROM invoice_creation_main WHERE $where";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populating the Excel sheet
$row_val = 4;
if (count($result) == 0) {
    $excel->getActiveSheet()->setCellValue('A4', 'No Data Found!');
} else {
    foreach ($result as $row) {
        $col_index = 'A';

        foreach ($selected_columns as $col) {
            if (isset($column_map[$col])) {
                $db_field = $column_map[$col]['db_field'];
                $cell_value = $row[$db_field] ?? '';

                // Map invoice status values
                if ($db_field == 'invoice_doc_status') {
                    $status_map = [
                        "0" => "Pending",
                        "1" => "Elcot Team Approval",
                        "2" => "Rejected",
                        "3" => "Invoice Completed",
                        "4" => "A/c Team Approval"
                    ];
                    $cell_value = $status_map[$cell_value] ?? 'Unknown';
                }

                $excel->getActiveSheet()->setCellValue($col_index . $row_val, $cell_value);
                $col_index = chr(ord($col_index) + 1);
            }
        }
        $row_val++;
    }
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="invoice_report.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');


?>

