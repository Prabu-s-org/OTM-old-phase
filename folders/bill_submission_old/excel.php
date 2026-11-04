<?php
require_once __DIR__ . '/../../config/env.php';
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
    $username       = project_env('APP_DB_USERNAME', 'root');
    $password       = project_env('APP_DB_PASSWORD');
    $databasename   = "operation_team_beta";  
    
    
    
    try{
        $conn = new PDO("mysql:host=$host;dbname=$databasename",$username,$password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    catch(PDOException $e){
         echo "Connection failed: " . $e->getMessage(); 
        
    }  
    
    
    
$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);


$excel->getActiveSheet()
->mergeCells('A1:G1');

$excel->getActiveSheet()
->setCellValue('A1','Bill Submission');



$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','PO No')
->setCellValue('C3','PO Date')
->setCellValue('D3','Bill ID')
->setCellValue('E3','Invoice Count')
->setCellValue('F3','Bill Value')
->setCellValue('G3','Status');
// ->setCellValue('H3','Invoice value');
// ->setCellValue('I3','Bg status');
// ->setCellValue('J3','Invoice Value')
// ->setCellValue('K3','No Of BG Months')
// ->setCellValue('L3','Status');
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
          
    $sql = ("SELECT *  from view_bill_submission_main_table");

        $users       = $conn->query($sql);
        foreach ($users as $row) {


            // $product_details_sub  = $conn->prepare("SELECT product FROM product_details_sub WHERE product_details_sub.unique_id = '".$row['product']."'");
            // $product_details_sub->execute();
            // $product_name    = $product_details_sub->fetch();
           if($row['elcot_ent_status']=='0')
           {
            $row['elcot_ent_status']='Pending';
           }
           else if($row['elcot_ent_status']=='1')
           {
            $row['elcot_ent_status']='Complete';
           }

           
            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($row["bill_no"]))
            ->setCellValue('E'.$row_val, ($row["invoice_qty"]))
            ->setCellValue('F'.$row_val, ($row["invoice_value"]))
            ->setCellValue('G'.$row_val, ($row["elcot_ent_status"]));
            // ->setCellValue('H'.$row_val, ($row["invoice_value"]))
            // ->setCellValue('I'.$row_val, ($row["bill_status"]));
            // ->setCellValue('J'.$row_val, ($row["invoice_value"]))
            // ->setCellValue('K'.$row_val, ($row["bg_month"]))
            // ->setCellValue('L'.$row_val, ($row["bg_status"]));
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
$excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);
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
// $excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
// $excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);




header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bill Submission.xls"');
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



