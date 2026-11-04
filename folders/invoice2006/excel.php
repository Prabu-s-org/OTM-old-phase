<?php
require_once __DIR__ . '/../../config/env.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

   $driver       = "mysql";
$host         = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = project_env('APP_DB_PASSWORD');
$databasename   = "operation_team";


    
    
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
->setCellValue('A1','Invoice');


$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','Invoice No')
->setCellValue('C3','Invoice Date')
->setCellValue('D3','PO Number')
->setCellValue('E3','Excutive Name')
->setCellValue('F3','Consignee name')
->setCellValue('G3','Invoice Qty')
->setCellValue('H3','Total value')
->setCellValue('I3','Status');
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
          
    $sql = ("SELECT *  from invoice_creation_main where is_delete = 0 ");

        $users       = $conn->query($sql);
        foreach ($users as $row) {


            $consignee_details   = $conn->prepare("SELECT con_contact_name FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."' And is_delete = '0'");
            $consignee_details->execute();
            $consignee_name      = $consignee_details->fetch();

        //   $invoice_doc_status    =  $_POST['invoice_doc_status'];
          if($row['invoice_doc_status'] == 4) {
            // $value['invoice_doc_status'] = "A/c Team Approval";
            $row['invoice_doc_status'] = "Completed";
        } 
         else if($row['invoice_doc_status'] == 1) {
            $row['invoice_doc_status'] = "Elcot Team Approval";
        } 
        // if($value['invoice_doc_status'] == 1 && $value['approved_by']!='' && $value['ac_team_approved_by']!='') {
        //     $value['invoice_doc_status'] = "A/c Team Approval";
        // } 
        //  else if($value['invoice_doc_status'] == 1 && $value['approved_by']!='') {
        //     $value['invoice_doc_status'] = "Elcot Team Approval";
        // } 
        else if ($row['invoice_doc_status'] == 2) {
            $row['invoice_doc_status'] = "Rejected";
            //  = "";
        } else if ($row['invoice_doc_status'] == 3) {
            $row['invoice_doc_status'] = "Invoice Completed";
        } else if ($row['invoice_doc_status'] == 0){
            $row['invoice_doc_status'] = "Pending";
        }

            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["invoice_no"]))
            ->setCellValue('C'.$row_val, disdate($row["invoice_date"]))
            ->setCellValue('D'.$row_val, ($row["po_num"]))
            ->setCellValue('E'.$row_val, ($row["executive_name"]))
            ->setCellValue('F'.$row_val, ($consignee_name["con_contact_name"]))
            ->setCellValue('G'.$row_val, ($row["invoice_qty"]))
            ->setCellValue('H'.$row_val, ($row["invoice_value"]))
            ->setCellValue('I'.$row_val, ($row["invoice_doc_status"]));
            // ->setCellValue('J'.$row_val, ($row["age"]))
            // ->setCellValue('K'.$row_val, disdate($row["doc_dob"]))
            // ->setCellValue('L'.$row_val, ($row["esi_no"]))
            // ->setCellValue('M'.$row_val, ($row["pf_no"]))
            // ->setCellValue('N'.$row_val, ($row["personal_contact_no"]))
            // ->setCellValue('O'.$row_val, ($row["office_contact_no"]))
            // ->setCellValue('P'.$row_val, ($row["personal_email_id"]))
            // ->setCellValue('Q'.$row_val, ($row["office_email_id"]))
            // ->setCellValue('R'.$row_val, ($blood_name["blood_name"]))
            // ->setCellValue('S'.$row_val, ($permanent_address))
            // ->setCellValue('T'.$row_val, ($present_address))
            // ->setCellValue('U'.$row_val, ($row["aadhar_no"]))
            // ->setCellValue('V'.$row_val, ($row["pan_no"]))
            // ->setCellValue('W'.$row_val, ($account_no))
            // ->setCellValue('X'.$row_val, ($bank_name))
            // ->setCellValue('Y'.$row_val, ($ifsc_no))
            // ->setCellValue('Z'.$row_val, ($reporting_staff["staff_name"]));
            
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
$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);




header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Invoice Order.xls"');
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



