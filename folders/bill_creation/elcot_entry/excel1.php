<?php
require_once __DIR__ . '/../../../config/env.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
//require("../../config/comfun.php");
// if($_REQUEST['staff_status'] == 0){
//     $relieve_date = '';
// }else if($_REQUEST['staff_status'] == 1){
//     $relieve_date = ' AND relieve_date = ""';
// }else{
//     $relieve_date = ' AND relieve_date != ""';
// }
$driver         = "mysql";
$host           = "localhost";
$username       = project_env('SERVICE_INSTALL_DB_USERNAME');
$password       = project_env('SERVICE_INSTALL_DB_PASSWORD');
$databasename   = "aed_elcot";
try {
    $conn = new PDO($driver . ":host=" . $host . ";dbname=" . $databasename, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
// $payment_receive='';
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()
    ->mergeCells('A1:K1');

$excel->getActiveSheet()
    ->setCellValue('A1', 'Elcot Entry');
    
$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'Po Number')
    ->setCellValue('C3', 'Po Date')
    ->setCellValue('D3', 'Consignee Name')
    ->setCellValue('E3', 'con Address')
    ->setCellValue('F3', 'Invoice No')
    ->setCellValue('G3', 'Invoice Date')
    ->setCellValue('H3', 'Invoice Value')
    // ->setCellValue('I3', 'Bg Num')
    ->setCellValue('I3', 'Bg Status');
$i = 0;
$row_val    = 4;
// .$relieve_date
// $payment_receive='';
$sql = ("SELECT * from bill_submission_main_table");
$users       = $conn->query($sql);
foreach ($users as $row) {
    if ($row['bg_num'] != '') {
        $row['bg_num'] = "Yes";
    }else{
        $row['bg_num'] = "No";
    }
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, ++$i)
        ->setCellValue('B' . $row_val, ($row["po_num"]))
        ->setCellValue('C' . $row_val, disdate($row["po_date"]))
        ->setCellValue('D' . $row_val, $row["con_contact_name"])
        ->setCellValue('E' . $row_val, ($row["con_address"]))
        ->setCellValue('F' . $row_val, ($row["invoice_no"]))
        ->setCellValue('G' . $row_val, ($row["invoice_date"]))
        ->setCellValue('H' . $row_val, ($row["invoice_value"]))
        // ->setCellValue('I' . $row_val, ($row["bg_num"]))
        ->setCellValue('I' . $row_val, ($row["bg_num"]));
    $row_val++;
}
//for Styling
// print_r($users);die();
$styleArray = array(
    'font' => array(
        'bold' => true
    )
);
// $excel->mergeCells('A1:E1');
$excel->getActiveSheet()->getStyle('A1:I3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
// $excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Elcot Entry.xls"');
header('Cache-Control: max-age=0');
$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');
function disdate($date)
{
    $result     = "";
    if ($date) {
        $result =  implode("-", array_reverse(explode("-", $date)));
    }
    return $result;
}



