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
   $driver       = "mysql";
$host         = "localhost";
$username     = project_env('APP_DB_USERNAME', 'root');
$password     = project_env('LEGACY_CREDENTIAL_3');
$databasename = "operation_team_beta";

try {
    $conn = new PDO("$driver:host=$host;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

   
    
    
$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);


$excel->getActiveSheet()
->mergeCells('A1:F1');

$excel->getActiveSheet()
->setCellValue('A1','Installation');



$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','PO No')
->setCellValue('C3','PO Date')
->setCellValue('D3','Consignee')
->setCellValue('E3','Location')
->setCellValue('F3','Invoice No')
->setCellValue('G3','Invoice Date')
->setCellValue('H3','Invoice Value')
->setCellValue('I3','Department')
->setCellValue('J3','Delivery Due Date')
->setCellValue('K3','Status');
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
           if ($_POST['from_date'] == '') {
                $from_date = date('Y-m-d');
            } else {
                $from_date = $_POST['from_date'];
            }
    
            if ($_POST['to_date'] == '') {
                $to_date = date('Y-m-d');
            } else {
                $to_date = $_POST['to_date'];
            }
    
    
            // if($from_date && $to_date != '') {
            if ($opt == '4') {
    
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') AND installation_status = '" . $installation_status . "'";
            } else if ($opt == '5') {
    
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' AND installation_status = '" . $installation_status . "'";
            } 
            else if($installation_status!='' ){

                $where="installation_status = '" . $installation_status . "'";
                }

 
    // $sql = ("SELECT *  from view_installation_followups where installation_status='0' OR installation_status='3'");
$sql = ("SELECT *  from view_installation_followups WHERE $where");
        $users       = $conn->query($sql);


        foreach ($users as $row) {

          

            $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '".$row['department']."'");
            $department_details->execute();
            $department_name      = $department_details->fetch();


            if($row['installation_status'] == 0){
                $row['installation_status'] = 'Pending';
            }else if($row['installation_status'] == 1){
                $row['installation_status'] = 'Partial Completed';
            }else if($row['installation_status'] == 2){
                $row['installation_status'] = 'Completed';
            }
            else if($row['installation_status'] == 3){
                $row['installation_status'] = "Rejected";

              }
        

            $delivery_due_dates;
            $delivery_due_dates = $row['delivery_due_dates'];
            $po_date = $row['po_date'];
            $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
             $poDate->modify('+' . $delivery_due_dates . ' days');

             $resultDate = $poDate->format('d-m-Y');


            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($row["con_contact_name"]))
            ->setCellValue('E'.$row_val, ($row["con_address"]))
            ->setCellValue('F'.$row_val, ($row["invoice_no"]))
            ->setCellValue('G'.$row_val, ($row["invoice_date"]))
            ->setCellValue('H'.$row_val, ($row["invoice_value"]))
            // ->setCellValue('I'.$row_val, ($row["department"]));
            ->setCellValue('I'.$row_val, ($department_name["department"]))

            ->setCellValue('J'.$row_val, (                $resultDate))
            ->setCellValue('K' . $row_val, ($row["installation_status"]));
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
$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);




header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Installation Followsup.xls"');
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



