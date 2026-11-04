<?php
require_once __DIR__ . '/../../config/env.php';  

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
//require("../../config/comfun.php");
if($_REQUEST['staff_status'] == 0){
    $relieve_date = '';
}else if($_REQUEST['staff_status'] == 1){
    $relieve_date = ' AND relieve_date = ""';
}else{
    $relieve_date = ' AND relieve_date != ""';
}
$driver         = "mysql";
$host           = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = "";
$databasename   = "operation_team"  


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


$excel->getActiveSheet()
->mergeCells('A1:F1');

$excel->getActiveSheet()
->setCellValue('A1','Purchase Order');



$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','Po Number')
->setCellValue('C3','Po Date')
->setCellValue('D3','Department')
->setCellValue('E3','Customer GST Number')
->setCellValue('F3','Excutive name')
->setCellValue('G3','Total Value');


    $i = 0;
    $row_val    = 4;
    // .$relieve_date
          
    $sql = ("SELECT *  from view_po_form_list where is_delete = 0 ORDER BY unique_id ASC");

        $users       = $conn->query($sql);
        foreach ($users as $row) {


            $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '".$row['department']."'");
            $department_details->execute();
            $department_name      = $department_details->fetch();

            // $executive_name  = $conn->prepare("SELECT executive_name FROM executive_name WHERE unique_id = '".$row['executive_name']."'");
            // $executive_name->execute();
            // $executive_name      = $executive_name->fetch();
            $executive   = $conn->prepare("SELECT executive_name FROM executive_name WHERE unique_id = '" . $row['executive_name'] . "'");
            $executive->execute();
            $executive      = $executive->fetch();
        
            $total_value   = $conn->prepare("SELECT sum(total_value) AS total_value  FROM view_product_details_list WHERE form_main_unique_id = '" . $row['unique_id'] . "'");
            $total_value->execute();
            $total_value      = $total_value->fetch();
           
            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($department_name["department"]))
            ->setCellValue('E'.$row_val, ($row["gst_value"]))
            ->setCellValue('F'.$row_val, ($executive["executive_name"]))
            // ->setCellValue('G' . $row_val, $total_value_sum);
            ->setCellValue('G'.$row_val, ($total_value["total_value"]));
            
            $row_val++; 

       }
//for Styling

$styleArray = array(

    'font'=>array(

        'bold'=>true
    )
);
// $excel->mergeCells('A1:E1');
$excel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:Z3')->applyFromArray($styleArray);
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



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Purchase Order.xls"');
header('Cache-Control: max-age=0');

$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');

function disdate ($date) {

    $result     = "";

    if ($date) {
        $result =  implode("-",array_reverse(explode("-",$date)));
    }

    return $result;
}


