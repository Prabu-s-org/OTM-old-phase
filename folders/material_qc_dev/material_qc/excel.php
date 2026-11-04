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
 $driver       = "mysql";
$host         = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = project_env('APP_DB_PASSWORD');
$databasename   = "operation_team_beta";

try {
    $conn = new PDO("$driver:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Optional success message
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
    
    
    
$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);


$excel->getActiveSheet()
->mergeCells('A1:F1');

$excel->getActiveSheet()
->setCellValue('A1','Docs Approval AC');



$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','PO No')
->setCellValue('C3','PO Date')
->setCellValue('D3','Consignee')
->setCellValue('E3','Location')
->setCellValue('F3','Invoice No')
->setCellValue('G3','Invoice Date')
->setCellValue('H3','Status')
->setCellValue('I3','Approved By')
->setCellValue('J3','Invoice Value');
// ->setCellValue('J3','Age')
// ->setCellValue('K3','Original DOB')
// ->setCellValue('L3','ESI No')
// ->setCellValue('M3','PF No')
// ->setCellValue('N3','Per. Mob No')
// ->setCellValue('O3','CUG')
// ->setCellValue('P3','Per. Mail ID')
// ->setCellValue('Q3','Off Mail ID')
// ->setCellValue('R3','Blood Group')
// ->setCellValue('S3','Perm Address')
// ->setCellValue('T3','Present Address')
// ->setCellValue('U3','Aadhar No')
// ->setCellValue('V3','PAN No')
// ->setCellValue('W3','Acc NO')
// ->setCellValue('X3','Bank Name')
// ->setCellValue('Y3','IFSC No')
// ->setCellValue('Z3','Reporting Head');


    $i = 0;
    $row_val    = 4;
    // .$relieve_date
          
    $sql = ("SELECT *  from view_doc_approval_list_final WHERE doc_approval_sts = '1' ORDER BY ac_team_verifiy_status='1' ASC");
//  $where = "";
        $users       = $conn->query($sql);
        foreach ($users as $row) {

            if ($row['ac_team_verifiy_status'] == "1") {
                $row['ac_team_verifiy_status']   = "Approval";
            } else if ($row['ac_team_verifiy_status'] == "2") {
                $row['ac_team_verifiy_status']   = "Not Approval";
            } else {
                $row['ac_team_verifiy_status']   = "Pending";
            }

            $consignee_unique_id   = $conn->prepare("SELECT con_contact_name FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."'");
            $consignee_unique_id->execute();

            $consignee_unique_name      = $consignee_unique_id->fetch();

            $consignee_location  = $conn->prepare("SELECT con_address FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."'");
            $consignee_location->execute();
            $consignee_location_name      = $consignee_location->fetch();

            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            // ->setCellValue('D'.$row_val, ($row["con_contact_name"]))
            // ->setCellValue('E'.$row_val, ($row["con_address"]))
            ->setCellValue('D'.$row_val, ($consignee_unique_name["con_contact_name"]))
            ->setCellValue('E'.$row_val, ($consignee_location_name["con_address"]))
            ->setCellValue('F'.$row_val, ($row["invoice_no"]))
            ->setCellValue('G'.$row_val, ($row["invoice_date"]))
            ->setCellValue('H'.$row_val, ($row["ac_team_verifiy_status"]))
            ->setCellValue('I'.$row_val, ($row["ac_team_approved_by"]))
            ->setCellValue('J'.$row_val, ($row["invoice_value"]));
           
            
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
header('Content-Disposition: attachment;filename="Docs Approval AC.xls"');
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



