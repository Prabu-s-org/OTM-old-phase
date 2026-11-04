<?php
require_once __DIR__ . '/../../config/env.php'; 
include('phpexcel/PHPExcel-1.8/Classes/PHPExcel.php');
// require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);
$driver         = "mysql";
$host           = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = "";
$databasename   = "operation_team_beta"  

try {

$conn = new PDO( $driver.":host=".$host.";dbname=".$databasename, $username, $password);

$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}   
 
$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);

// header
$excel->getActiveSheet()
    ->setCellValue('A1', 'BG Excel');
    // main title
    $excel->getActiveSheet()
    ->setCellValue('A2', 'S.NO');
    $excel->getActiveSheet()
    ->setCellValue('B2', 'Invoice No')
    ->setCellValue('C2','Invoice Date')
    ->setCellValue('D2','Po Number')
    ->setCellValue('E2','Po Date')
    ->setCellValue('F2','Product')
    ->setCellValue('G2','Qty')
    ->setCellValue('H2','Amount')
    ->setCellValue('I2','BG 5%');

// include '../../config/dbconfig.php';


$bg_no=$_GET['bg_no'];

$i = 0;
$row_val    = 4;

    $sql = ("SELECT * from bg_creation_sub where bg_auto_id='".$bg_no."'");

     
    $users       = $conn->query($sql);
  

    foreach($users as $row) {

        // $po_product_name = $conn->prepare("SELECT product FROM product_details_sub WHERE unique_id = :po_product_name");
        // $po_product_name->bindParam(':po_product_name', $row['po_product_name'], PDO::PARAM_STR);
        // $po_product_name->execute();
        
        // $po_product_name_result = $po_product_name->fetch(PDO::FETCH_ASSOC);
        
        $excel->getActiveSheet()
        ->setCellValue('A'.$row_val, ++$i)
        ->setCellValue('B'.$row_val, ($row["invoice_no"]))
        ->setCellValue('C'.$row_val, disdate($row["invoice_date"]))
        ->setCellValue('D'.$row_val, ($row["po_num"]))
        ->setCellValue('E'.$row_val, disdate($row["po_date"]))
        ->setCellValue('F'.$row_val, ($row["bg_product_name"]))
        // ->setCellValue('F'.$row_val, ($po_product_name_result['product'] ?? ''))
        ->setCellValue('G'.$row_val, ($row["invoice_qty"]))
        ->setCellValue('H'.$row_val, ($row["invoice_value"]))
        ->setCellValue('I'.$row_val, ($row["bg_percentage"]));
           $row_val++;
}
   
$styleArray = array(

    'font'=>array(

        'bold'=>true
    )
);
// $excel->mergeCells('A1:E1');
$excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($styleArray);
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
$excel->getActiveSheet()->getColumnDimension('i')->setAutoSize(true);



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="bg.xls"');

// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="bg.xls"');
// header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

ob_clean();
$fileDownload->save('php://output');
// PRINT_R($fileDownload);DIE();
function disdate ($date) {

    $result     = "";

    if ($date) {
        $result =  implode("-",array_reverse(explode("-",$date)));
    }

    return $result;
}


