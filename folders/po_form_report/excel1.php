<?php
// Including PHPExcel library
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
include '../../config/dbconfig.php';

// Creating new PHPExcel object
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);

// Setting headers for the Excel sheet
$excel->getActiveSheet()
    ->setCellValue('A1', 'PO Form')
    ->mergeCells("A1:K1")
    ->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'Po Number')
    ->setCellValue('C3', 'Po Date')
    ->setCellValue('D3', 'Department')
    ->setCellValue('E3', 'Customer GST Number')
    ->setCellValue('F3', 'Executive name')
    ->setCellValue('G3', 'Total Value')
    ->setCellValue('H3', 'Unit Price');


// Setting column widths to auto size
$columns = range('A', 'G');
foreach ($columns as $column) {
    $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}

// DataTable Variables
$search     = $_POST['search']['value'];
$length     = $_POST['length'];
$start      = $_POST['start'];
$draw       = $_POST['draw'];
// $from_date  = $_POST['from_date'];
// $to_date    = $_POST['to_date'];
$limit      = $length;
$data        = [];
// $month_fill = $_POST["month_fill"];

$month_val  = date("F/Y", strtotime($month_fill));
$date       = new DateTime($month_fill);
$date->modify('-1 month');
$dec_date   = $date->format('Y-m');

if ($length == '-1') {
    $limit = '';
}

$table_po = "view_po_form_list";

// Columns for the query
$columns = [
    "'' as  s_no",
    "po_num",
    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
    "department",
    // "(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_po.'.department ) AS department",

    // "(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_po.'.department ) AS department",
    "gst_value",
    "executive_name",
    // "net_value",
    // "(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id ='.$table_po .'.executive_name ) AS executive_name",
    // "(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  and dis.is_delete=0) AS total_value",
    "unique_id",
    "delivery_due_dates",
];

$table_details = [
    $table_po,
    $columns
];

// Building the WHERE clause based on the date filters
$where = "is_delete = '0'";
// print_r($where);
// if ($month_fill != '') {
//     $where .= " AND DATE_FORMAT(po_date, '%Y-%m') LIKE '%".$month_fill."%'";
// }

if ($_GET['from_date'] == '') {
    $from_date = '';
} else {
    $from_date = $_GET['from_date'];
}
if ($_GET['to_date'] == '') {
    $to_date = '';
} else {
    $to_date = $_GET['to_date'];

    // $where .= "DATE_FORMAT(po_date, '%Y-%m-%d') >= '" . $from_date . "' AND DATE_FORMAT(po_date, '%Y-%m-%d') <= '" . $to_date . "' ";

}
if ($from_date || $to_date != '') {

    $where .= " AND po_date>= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
    // $where = "po_date >= '" . $from_date . "' po_date <= '" . $to_date . "'  ";

}

$row_val = 4;

$order_column = $_POST['order'][0]['column'];
$order_dir    = $_POST['order'][0]['dir'];

$order_by     = datatable_sorting_po($order_column, $order_dir, $columns);

// Datatable Searching
$search = datatable_searching($search, $columns);

if ($search) {
    $where .= 'AND ' . $search;
}

$sql_function = 'SQL_CALC_FOUND_ROWS';
$result    = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
$res_array = $result->data;

// print_r($result);die();
$total_records  = total_records();

if (count($res_array) == 0) {
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, 'No Data Found!');
} else {
    $i = 0;
    foreach ($res_array as $row) {
        $i++;
       $gst_value= $row['gst_value'];
        if($gst_value==''){
            $row['gst_value']="Unregistered";
        }
        $department_details = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '".$row['department']."'");
        $department_details->execute();
        $department_name = $department_details->fetch();

        $executive = $conn->prepare("SELECT executive_name FROM executive_name WHERE unique_id = '" . $row['executive_name'] . "'");
        $executive->execute();
        $executive = $executive->fetch();

        $total_value = $conn->prepare("SELECT sum(total_value) AS total_value  FROM view_product_details_list WHERE form_main_unique_id = '" . $row['unique_id'] . "'");

        $total_value->execute();

        $total_value = $total_value->fetch();

        $net_value = $conn->prepare("SELECT net_value AS net_value  FROM product_details_sub WHERE form_main_unique_id = '" . $row['unique_id'] . "'");
        // print_r($net_value);die();
// $net_value = $conn->prepare("SELECT net_value FROM product_details_sub WHERE form_main_unique_id = '".$row['unique_id']."'");
        $net_value->execute();
        $net_value = $net_value->fetch();

        $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, $i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($department_name["department"]))
            ->setCellValue('E'.$row_val, ($row["gst_value"]))
            ->setCellValue('F'.$row_val, ($executive["executive_name"]))
            ->setCellValue('G'.$row_val, ($total_value["total_value"]))
            ->setCellValue('H'.$row_val, ($net_value["net_value"]));


        $row_val++;
    }
}

// Sending the generated Excel file to the browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="PO form.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');
?>

