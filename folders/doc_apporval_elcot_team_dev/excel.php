<?php
require_once __DIR__ . '/../../config/env.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Including PHPExcel library
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
include '../../config/dbconfig.php';


$driver = "mysql";
$host = "localhost";
$username = project_env('APP_DB_USERNAME', 'root');
$password = project_env('APP_DB_PASSWORD');
$databasename = "operation_team_beta";

// require_once('../../config/comfun.php');

try {
    $conn = new PDO("$driver:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional success message
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Creating new PHPExcel object
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

// Setting headers for the Excel sheet
$excel->getActiveSheet()
    ->mergeCells("A1:L1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->getActiveSheet()
    ->setCellValue('A1', 'Doc Approval Elcot ');

$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'PO No')
    ->setCellValue('C3', 'PO Date')
    ->setCellValue('D3', 'Followed By')
    ->setCellValue('E3', 'Department')
    ->setCellValue('F3', 'DC No')
    ->setCellValue('G3', 'DC date')
    ->setCellValue('H3', 'Location')
    ->setCellValue('I3', 'Invoice No')
    ->setCellValue('J3', 'Invoice Date')
    ->setCellValue('K3', 'Status')
    ->setCellValue('L3', 'Approved By')
    ->setCellValue('M3','Invoice Value');

// Setting column widths to auto size
$columns = range('A', 'M');
foreach ($columns as $column) {
    $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

// Fetching data from the database
$table = "view_doc_approval_list_final";

$columns = [
    "'' as  sno",
    "po_num",
    "po_date",
    "dc_number",
    "dc_date",
    "(SELECT staff_name FROM user WHERE user.staff_id = " . $table . ".team_mem and user.is_delete='0') AS team_member",
    "(SELECT department FROM department_creation WHERE department_creation.unique_id = " . $table . ".department ) AS department",
    // "con_contact_name",
    "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0') AS con_address",
    // "con_address",
    "invoice_no",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    // "invoice_date",
    "file_name",
    "dc_file_name",
    "ir_file_name",
    "invoice_value",
    "file_invoice",
    "invoice_file_org_name",
    "doc_approval_sts",
    "approved_by",
    "invoice_unique_id",
    // "is_active",
    // "unique_id"
];
$table_details = [
    $table,
    $columns
];
// echo "1 ";
// echo $columns["doc_approval_sts"];
// echo $_REQUEST['doc_approval_sts'];
// echo "2 ";
$opt = $_GET['opt'];
$doc_approval_sts = $_REQUEST['doc_approval_sts'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];


// if($_POST['from_date'] == ''){
//     $from_date = '';
// } else {
//     $from_date = $_POST['from_date'];
// }

// if($_POST['to_date'] == ''){
//     $to_date = '';
// } else {
//     $to_date = $_POST['to_date'];
// }


if ($opt == '4') {

    $from_date_converted = date('d-m-Y', strtotime($from_date));
    $to_date_converted = date('d-m-Y', strtotime($to_date));
    $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y')
<= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') AND doc_approval_sts = '" . $doc_approval_sts . "'";
} else if ($opt == '5') {

    $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' AND doc_approval_sts = '" . $doc_approval_sts . "'";
} else if ($doc_approval_sts != '') {

    $where = "doc_approval_sts = '" . $doc_approval_sts . "'";
}


$result = $pdo->select($table_details, $where);
// print_r($result);
$res_array = $result;

// echo "echo 0";
// print_r(count($res_array->data));
// echo "echo 0.0";

$row_val = 4; // Start populating data from row 4

// echo "echo 1";
if (count($res_array->data) == 0) {
    // echo "echo 2";
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, 'No Data Found!');

} else {
    $i = 0;
    // echo "echo 3";
    foreach ($res_array->data as $row) {
        // echo "echo 4";
        // echo $row;

        // $po_date = $row['po_date'];
        // $delivery_due_dates = $row['delivery_due_dates'];
        // $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
        // $poDate->modify('+' . $delivery_due_dates . ' days');
        // $resultDate = $poDate->format('d-m-Y');

        // $doc_approval_sts = [
        //     0 => 'Pending',
        //     1 => 'Approved',
        //     // 2 => 'Completed',
        //     // 3 => 'Rejected'
        // ];

        // echo $row['file_name'];
        if ($row['doc_approval_sts'] == "1") {
            $row['doc_approval_sts'] = "Approved";
        } elseif ($row['doc_approval_sts'] == "2") {
            $row['doc_approval_sts'] = "Not Approved";
        } else {
            $row['doc_approval_sts'] = "Pending";
        }

        // $consignee_location  = $conn->prepare("SELECT con_address FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."'");
        // $consignee_location->execute();
        // $consignee_location_name      = $consignee_location->fetch();

        // echo "echo 5";

        $excel->getActiveSheet()
            ->setCellValue('A' . $row_val, ++$i)
            ->setCellValue('B' . $row_val, !empty($row["po_num"]) ? $row["po_num"] : '-')
            ->setCellValue('C' . $row_val, !empty($row["po_date"]) ? disdate($row["po_date"]) : '-')
            ->setCellValue('D' . $row_val, !empty($row["team_member"]) ? $row["team_member"] : '-')
            ->setCellValue('E' . $row_val, !empty($row["department"]) ? $row["department"] : '-')
            // ->setCellValue('B' . $row_val, !empty($row["ledger_name"]) ? $row["ledger_name"] : '-')
            ->setCellValue('F' . $row_val, !empty($row["dc_number"]) ? $row["dc_number"] : '-')
            ->setCellValue('G' . $row_val, !empty($row["dc_date"]) ? disdate($row["dc_date"]) : '-')
            ->setCellValue('H' . $row_val, !empty($row["con_address"]) ? $row["con_address"] : '-')
            ->setCellValue('I' . $row_val, !empty($row["invoice_no"]) ? $row["invoice_no"] : '-')
            ->setCellValue('J' . $row_val, !empty($row["invoice_date"]) ? $row["invoice_date"] : '-')
            ->setCellValue('K' . $row_val, isset($row["doc_approval_sts"]) ? $row["doc_approval_sts"] : '-')
            ->setCellValue('L' . $row_val, !empty($row["approved_by"]) ? $row["approved_by"] : '-')
            ->setCellValue('M' . $row_val, !empty($row["invoice_value"]) ? $row["invoice_value"] : '-');
            // ->setCellValue('M' . $row_val, isset($doc_approval_sts[$row["doc_approval_sts"]]) ? $doc_approval_sts[$row["doc_approval_sts"]] : '-');

        // echo "echo 6";

        $row_val++;
    }
    // echo "echo 7";
}

// Sending the generated Excel file to the browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Doc Approval.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');

?>


