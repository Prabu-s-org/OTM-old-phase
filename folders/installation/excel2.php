<?php
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
include '../../config/dbconfig.php';

// Creating new PHPExcel object
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

// Setting headers for the Excel sheet
$excel->getActiveSheet()
    ->setCellValue('A1', 'Installation')
    ->mergeCells("A1:J1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->getActiveSheet()
->setCellValue('A3', 'S.No')
->setCellValue('B3', 'PO No')
->setCellValue('C3', 'Department')
->setCellValue('D3', 'Consignee District')
->setCellValue('E3', 'Location')
->setCellValue('F3', 'Invoice No')
->setCellValue('G3', 'Invoice Date')
->setCellValue('H3', 'Invoice Value')
->setCellValue('I3', 'Status');

// Setting column widths to auto size
$columns = range('A', 'J');
foreach ($columns as $column) {
    $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

$start = 0;
$table = "view_installation_followups1";

$columns = [
    "'' as s_no",
    "po_num",
    "po_date",
    "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_installation_followups1.department) AS department",
    "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups1.con_district) AS con_district",
    "con_address",
    "invoice_no",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "dc_delivery_status",
    "invoice_value"  // Ensure this column exists in your database
];

$table_details = [
    $table,
    $columns
];

$where = "documents_type!='0'";


$dc_delivery_status = $_REQUEST['dc_delivery_status'];
$opt1 = $_GET['opt1'];


$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];


if ($opt1 == '9') {
    $from_date_converted = date('d-m-Y', strtotime($from_date));
    $to_date_converted = date('d-m-Y', strtotime($to_date));
    $where .= " AND STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y')
<= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') AND dc_delivery_status = '" . $dc_delivery_status . "'";
} else if ($opt1 == '10') {
    $where .= " AND invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' AND dc_delivery_status = '" . $dc_delivery_status . "'";
} else {
    $where .= " AND dc_delivery_status = '" . $dc_delivery_status . "'";
}

$result = $pdo->select($table_details, $where);
$res_array = $result->data;

$i = 0;
$s_no = 0;
$row_val = 4; // Start populating data from row 4
if (count($res_array) == 0) {
    $msg = 'No Data Found!';
    $excel->getActiveSheet()->setCellValue('A' . $row_val, $msg);
} else {
    foreach ($res_array as $row) {
        $s_no++;
        
        $status = '';
        // if ($row['dc_delivery_status'] == 0) {
        //     $status = 'Pending';
        // } else if ($row['dc_delivery_status'] == 1) {
        //     $status = 'Partial Completed';
        // } else if ($row['dc_delivery_status'] == 3) {
        //     $status = 'Completed';
        // }
        if($row['dc_delivery_status'] == 0){
             $status['dc_delivery_status'] = 'Pending';
        }
        else if($row['dc_delivery_status'] == 5){
             $status['dc_delivery_status'] = 'partial Completed';
        }
        else if($row['dc_delivery_status'] == 1){
             $status['dc_delivery_status'] = 'SNR';
        }
        else if($row['dc_delivery_status'] == 3){
             $status['dc_delivery_status'] = 'Completed';
        }

        $excel->getActiveSheet()
            ->setCellValue('A' . $row_val, $s_no)
            ->setCellValue('B' . $row_val, $row["po_num"])
            ->setCellValue('C' . $row_val, $row["department"])
            ->setCellValue('D' . $row_val, $row["con_district"])
            ->setCellValue('E' . $row_val, $row["con_address"])
            ->setCellValue('F' . $row_val, $row["invoice_no"])
            ->setCellValue('G' . $row_val, $row["invoice_date"])
            ->setCellValue('H' . $row_val, $row["invoice_value"])
            ->setCellValue('I' . $row_val, $status);
        
        $row_val++;
    }
}

// cell merge and text center
$excel->getActiveSheet()->mergeCells("A1:J1");
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
    array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="installation_engineer_report.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');
?>

