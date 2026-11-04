<?php
require_once __DIR__ . '/../../config/env.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

$driver         = "mysql";
$host           = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = "";
$databasename   = "aed_elcot_beta";
try {
    $conn = new PDO($driver . ":host=" . $host . ";dbname=" . $databasename, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()
    ->mergeCells('A1:F1');
$excel->getActiveSheet()
    ->setCellValue('A1', 'Overall Excel');
$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'Po No')
    ->setCellValue('C3', 'Po Date')
    ->setCellValue('D3', 'Department')
    ->setCellValue('E3', 'Ledger Name')
    ->setCellValue('F3', 'Ledger No')
    ->setCellValue('G3', 'Bill Address')
    ->setCellValue('H3', 'Pincode')
    ->setCellValue('I3', 'Consignee Address')
    ->setCellValue('J3', 'Con Location')
    ->setCellValue('K3', 'Con Pincode')
    ->setCellValue('L3', 'Contact Person')
    ->setCellValue('M3', 'Contact Number')
    ->setCellValue('N3', 'Po Prepared By')
    ->setCellValue('O3', 'Item Code')
    ->setCellValue('P3', 'Product')
    ->setCellValue('Q3', 'Qty')
    ->setCellValue('R3', 'Unit Price')
    ->setCellValue('S3', 'Tax')
    ->setCellValue('T3', 'Total value')
    ->setCellValue('U3', 'Net Value')
    // ->setCellValue('V3','Dc NO')
    // ->setCellValue('W3','Stock Position')
    ->setCellValue('V3', 'Invoice No')
    ->setCellValue('W3', 'Invoice Date')
    ->setCellValue('X3', 'Invoice Verfied By')
    ->setCellValue('Y3','Dispatch Date')
    ->setCellValue('Z3','POD NO.')
    ->setCellValue('AA3','Mode Of Delivery')
    ->setCellValue('AB3','Delivery Status')
    ->setCellValue('AC3','Payment Status')
    ->setCellValue('AD3','Payment Date');
// ->setCellValue('E4','Closing Date')
// ->setCellValue('F4','LD Days')
// ->setCellValue('G4','Closing Date');
$i = 0;
$row_val    = 4;
// .$relieve_date
$sql = ("SELECT *  from view_overall_form_final");
$overall_form       = $conn->query($sql);
foreach ($overall_form as $row) {
    $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '" . $row['department'] . "'");
    $department_details->execute();
    $department_name      = $department_details->fetch();
    // print_r($department_name);
    $consignee_districts   = $conn->prepare("SELECT district_name FROM district_creation WHERE unique_id = '".$row['con_district']."'");
    $consignee_districts->execute();
    $consignee_district      = $consignee_districts->fetch();
    // $mode_of_delivery=$row["mode_of_delivery"];

    if ($row["mode_of_delivery"] == "1") {
        $row['mode_of_delivery'] = "Hand";
    } else if($row["mode_of_delivery"] == "2"){
        $row['mode_of_delivery'] = "Courier";
    }
    if ($row['delivery_status'] == "1") {
        $row['delivery_status'] = "DELIVERD";
    } else if ($row['delivery_status'] == "2") {
        $row['delivery_status'] = "UNDELIVERD";
    }
    if ($row['payment_status'] == "1") {
        $row['payment_status'] = " PAYMENT PENDING";
    } else if ($row['payment_status'] == "2") {
        $row['payment_status'] = "PAYMENT RECEIVED";
    }

    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, ++$i)
        ->setCellValue('B' . $row_val, ($row["po_num"]))
        ->setCellValue('C' . $row_val, disdate($row["po_date"]))
        ->setCellValue('D' . $row_val, ($department_name["department"]))
        ->setCellValue('E' . $row_val, ($row["ledger_name"]))
        ->setCellValue('F' . $row_val, ($row["ledger_no"]))
        ->setCellValue('G' . $row_val, ($row["po_bill_address"]))
        // ->setCellValue('H'.$row_val, ($row["father_name"]))
        ->setCellValue('H' . $row_val, ($row["po_pin"]))
        ->setCellValue('I' . $row_val, ($row["con_address"]))
        // ->setCellValue('I'.$row_val, ($con_address["con_address"]))
        ->setCellValue('J' . $row_val, ($consignee_district["district_name"]))
        ->setCellValue('K' . $row_val, ($row["con_pincode"]))
        ->setCellValue('L' . $row_val, ($row["con_contact_name"]))
        ->setCellValue('M' . $row_val, ($row["con_contact_number"]))
        ->setCellValue('N' . $row_val, ($row["po_prepared_by"]))
        ->setCellValue('O' . $row_val, ($row["item_code"]))
        ->setCellValue('P' . $row_val, ($row["product"]))
        ->setCellValue('Q' . $row_val, ($row["qty"]))
        ->setCellValue('R' . $row_val, ($row["unit_price"]))
        ->setCellValue('S' . $row_val, ($row["tax"]))
        ->setCellValue('T' . $row_val, ($row["total_value"]))
        ->setCellValue('U' . $row_val, ($row["net_value"]))
        ->setCellValue('V' . $row_val, ($row["invoice_no"]))
        ->setCellValue('W' . $row_val, ($row["invoice_date"]))
        ->setCellValue('X' . $row_val, ($row["invoice_verified_by"]))
        ->setCellValue('Y'.$row_val, ($row["dispatch_date"]))
        ->setCellValue('Z'.$row_val, ($row["pod_no"]))
        ->setCellValue('AA'.$row_val, ($row["mode_of_delivery"]))
       
        ->setCellValue('AB'.$row_val, ($row["delivery_status"]))
        ->setCellValue('AC'.$row_val, ($row["payment_status"]))
        ->setCellValue('AD'.$row_val, ($row["payment_date"]));
    $row_val++;
}
//for Styling
$styleArray = array(
    'font' => array(
        'bold' => true
    )
);
// $excel->mergeCells('A1:E1');
$excel->getActiveSheet()->getStyle('A1:AD3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:AD3')->applyFromArray($styleArray);
// $excel->getActiveSheet()->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
// $excel = [
//     'borders' => [
//         'outline' => [
//             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//             'color' => ['rgb' => '000000'],
//         ],
//     ],
// ];
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
$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="overall Form Excel.xls"');
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


