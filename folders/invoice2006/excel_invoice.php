<?php
require_once __DIR__ . '/../../config/env.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

$driver   = "mysql";
$host     = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = project_env('APP_DB_PASSWORD');
$databasename   = "operation_team";

try {
    $conn = new PDO("$driver:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

$selected_columns = isset($_GET['columns']) ? explode(',', $_GET['columns']) : [];

$column_map = [
    "1"  => ["label" => "PO Number", "db_field" => "po_num"],
    "2"  => ["label" => "PO Date", "db_field" => "po_date"],
    "3"  => ["label" => "Department", "db_field" => "department"],
    "4"  => ["label" => "Executive Name", "db_field" => "executive_name"],
    "5"  => ["label" => "No. of Consignee", "db_field" => "no_of_con"],
    "6"  => ["label" => "No. of Items", "db_field" => "no_of_item"],
    "7"  => ["label" => "Stock Qty", "db_field" => "stock_qty"],
    "8"  => ["label" => "Total Value", "db_field" => "stock_value"],
    "9"  => ["label" => "Status", "db_field" => "po_status"],
    "10" => ["label" => "PO Attachment", "db_field" => "po_attachment"]
];

if (empty($selected_columns)) {
    die("No columns selected!");
}

$excel->getActiveSheet()
    ->setCellValue('A1', 'Invoice')
    ->mergeCells("A1:I1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$col_index = 'A';
foreach ($selected_columns as $col) {
    if (isset($column_map[$col])) {
        $excel->getActiveSheet()->setCellValue($col_index . '3', $column_map[$col]['label']);
        $col_index++;
    }
}

$row_val = 4;
$sql = "SELECT * FROM stock_position_main WHERE is_delete = 0";
$users = $conn->query($sql);

foreach ($users as $row) {
    $col_index = 'A';
    foreach ($selected_columns as $col) {
        if (isset($column_map[$col])) {
            $db_field = $column_map[$col]['db_field'];
            $excel->getActiveSheet()->setCellValue($col_index . $row_val, $row[$db_field]);
            $col_index++;
        }
    }
    $row_val++;
}

// Styling
$styleArray = ['font' => ['bold' => true]];
$excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');

foreach (range('A', 'I') as $columnID) {
    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Invoice_Order.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');



