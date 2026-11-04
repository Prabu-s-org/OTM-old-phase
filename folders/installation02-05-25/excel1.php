<?php
// Including PHPExcel library
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
include '../../config/dbconfig.php';

// Creating new PHPExcel object
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

// Setting headers for the Excel sheet
$excel->getActiveSheet()
    ->setCellValue('A1', 'Installation')
    ->mergeCells("A1:K1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'PO No')
    ->setCellValue('C3', 'PO Date')
    ->setCellValue('D3', 'Consignee District')
    ->setCellValue('E3', 'Location')
    ->setCellValue('F3', 'Invoice No')
    ->setCellValue('G3', 'Invoice Date')
    // ->setCellValue('H3', 'Invoice Value')
    ->setCellValue('I3', 'Department')
    ->setCellValue('J3', 'Delivery Due Date')
    ->setCellValue('K3', 'Status');

// Setting column widths to auto size
$columns = range('A', 'K');
foreach ($columns as $column) {
    $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}
$search     = $_POST['search']['value'];
$length     = $_POST['length'];
$start         = $_POST['start'];
$draw         = $_POST['draw'];
$from_date  = $_POST['from_date'];
$to_date    = $_POST['to_date'];
$opt    = $_POST['opt'];
$limit         = $length;
$installation_status    =  $_POST['installation_status'];

$data        = [];


if ($length == '-1') {
    $limit  = "";
}

// Query Variables
$json_array     = "";
// Fetching data from the database
$table = "view_installation_followups";
$columns = [
    "'' as s_no",
    "po_num",
    "po_date",
    "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_installation_followups.department) AS department",
    "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups.con_district) AS con_district",
    "con_address",
    "invoice_no",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "po_file_name",
    "dc_file_name",
    "ir_file_name",
    "file_invoice",
    "installation_status",
    "delivery_due_dates",
    "consignee_unique_id",
    "form_main_unique_id",
    "con_pincode",
    "dc_required",
    "invoice_auto_id"
];

$table_details_list = [
    $table,
    $columns
];
$opt = $_GET['opt'];
$installation_status = $_REQUEST['installation_status'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];

if ($opt == '4') {
    $from_date_converted = date('d-m-Y', strtotime($from_date));
    $to_date_converted = date('d-m-Y', strtotime($to_date));
    $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') AND installation_status = '" . $installation_status . "'";
} else if ($opt == '5') {
    $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' AND installation_status = '" . $installation_status . "'";
} else if ($installation_status != '') {
    $where = "installation_status = '" . $installation_status . "'";
}

// $result = $pdo->select($table_details_list, $where);


$row_val = 4; // Start populating data from row 4
$order_column   = $_POST["order"][0]["column"];
$order_dir      = $_POST["order"][0]["dir"];

// Datatable Ordering 
$order_by       = datatable_sorting_ins1($order_column, $order_dir, $columns);


$order_by = "CASE 
WHEN installation_status = '3' THEN 0 
WHEN installation_status = '0' THEN 1
WHEN installation_status = '4' THEN 2
WHEN installation_status = '5' THEN 3
WHEN installation_status = '1' THEN 4
WHEN installation_status = '2' THEN 5
ELSE 6
END $order_dir, DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";

// $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";


// Datatable Searching
// $search         = datatable_searching($search, $columns);
// if($installation_status != ''){
//     $where = "installation_status LIKE '%".$installation_status."%'";
// }

if ($search) {
    if ($where) {
        $where .= " AND ";
    }

    $where .= $search;
}

$sql_function   = "SQL_CALC_FOUND_ROWS";

$result         = $pdo->select($table_details_list, $where, $limit, $start, $order_by, $sql_function);
$res_array = $result->data;
// print_r( $result );
$total_records  = total_records();

if (count($res_array) == 0) {
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, 'No Data Found!');
} else {
    $i = 0;
    foreach ($res_array as $row) {
        $i++;
        $po_date = $row['po_date'];
        $delivery_due_dates = $row['delivery_due_dates'];
        $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
        $poDate->modify('+' . $delivery_due_dates . ' days');
        $resultDate = $poDate->format('d-m-Y');

        // $installation_status = [
        //     0 => 'Pending',
        //     5 => 'Partial Completed',
        //     2 => 'Completed',
        //     3 => 'Rejected',
        //     1 => 'SNR',
        //     3 => 'Rejected',

        // ];
        if($row['installation_status'] == 0){
            $row['installation_status'] = 'Pending';
        }else if($row['installation_status'] == 5){
            $row['installation_status'] = 'Partial completed';
        }
        else if($row['installation_status'] == 2){
          $row['installation_status'] = 'Completed';
        }
        else if($row['installation_status'] == 3){
            $row['installation_status'] = "Rejected";

          }
          else if($row['installation_status'] == 4){
            $row['installation_status'] = "Eng Assigned";
          }
          else if($row['installation_status'] == 1){
            $row['installation_status'] = "SNR";
          }

        $excel->getActiveSheet()
            ->setCellValue('A' . $row_val, $i)
            ->setCellValue('B' . $row_val, $row["po_num"])
            ->setCellValue('C' . $row_val, disdate($row["po_date"]))
            ->setCellValue('D' . $row_val, $row["con_district"])
            ->setCellValue('E' . $row_val, $row["con_address"])
            ->setCellValue('F' . $row_val, $row["invoice_no"])
            ->setCellValue('G' . $row_val, $row["invoice_date"])
            // ->setCellValue('H' . $row_val, $row["invoice_value"])
            ->setCellValue('I' . $row_val, $row["department"])
            ->setCellValue('J' . $row_val, $resultDate)
            ->setCellValue('K' . $row_val, $row["installation_status"]);
            // ->setCellValue('K' . $row_val, $installation_status[$row["installation_status"]]);


        $row_val++;
    }
}

// Sending the generated Excel file to the browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="installation_report_Tab1.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');

?>

