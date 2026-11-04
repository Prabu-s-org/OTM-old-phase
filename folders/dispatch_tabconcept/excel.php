<?php
require_once __DIR__ . '/../../config/env.php';  

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
// $con_contact_name="";
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
    $password = "";
    $database_name = "operation_team_beta"; 

try {

    $conn = new PDO($driver.":host=".$host.";dbname=".$database_name, $username, $password);

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
->setCellValue('A1','Dispatch');


$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','PO No')
->setCellValue('C3','PO Date')
->setCellValue('D3','Consignee')
->setCellValue('E3','Location')
->setCellValue('F3','Invoice No')
->setCellValue('G3','Invoice Date')
->setCellValue('H3','Invoice Qty')
->setCellValue('I3','Total Value')
->setCellValue('J3','Elcot Team Verfied Status')
->setCellValue('K3','AC Team');
// ->setCellValue('L3','dispatch_status');
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
          
    $sql = ("SELECT *  from invoice_creation_main where is_delete = 0 and ac_team_verifiy_status = '1' ORDER BY dispatch_status='0' ");

        $users       = $conn->query($sql);
        foreach ($users as $row) {


                //     if($row['dispatch_status']=='0'){
                //         $row['dispatch_status']='dispatch Pending';
                //     }
                //    else if($row['dispatch_status']=='1'){
                //         $row['dispatch_status']='dispatch Complete';
                //     }

                    if($row['ac_team_verifiy_status']=='0'){
                        $row['ac_team_verifiy_status']='Pending';
                    }
                //    else if($row['ac_team_verifiy_status']=='1'){
                //         $row['ac_team_verifiy_status']='Approved';
                //     }
                //     else if($row['ac_team_verifiy_status']=='2'){
                //         $row['ac_team_verifiy_status']='Rejected';
                //     }
            //   else if($row['doc_approval_sts'] == 1){
            //         $row['doc_approval_sts'] = 'Approved'.' / '.$row['approved_by'];
            //     }else{
            //         $row['doc_approval_sts'] = 'Rejected'.' / '.$row['approved_by'];
            //     }
                
               else if($row['ac_team_verifiy_status'] == 1){
                    $row['ac_team_verifiy_status'] = 'Approved'.' / '.$row['ac_team_approved_by'];
                }else{
                    $row['ac_team_verifiy_status'] = 'Rejected'.' / '.$row['ac_team_approved_by'];
                }

                    // $con_contact_name   = $conn->prepare("SELECT con_contact_name FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."'");
                    // $con_contact_name->execute();
                    // $con_contact_name      = $con_contact_name->fetch();
        
            // "(select con_contact_name from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_contact_name",
            // "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_address"

            $con_contact_name   = $conn->prepare("SELECT con_contact_name FROM consignee_details_sub  WHERE unique_id = '".$row['consignee_unique_id']."'");
            $con_contact_name ->execute();
            $con_contact_name      = $con_contact_name ->fetch();
            // print_r($con_contact_name);die();

            $con_address_name  = $conn->prepare("SELECT con_address FROM consignee_details_sub WHERE unique_id = '".$row['consignee_unique_id']."'");
            $con_address_name->execute();
            $con_address_name      = $con_address_name ->fetch();

          
            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($con_contact_name["con_contact_name"]))
            ->setCellValue('E'.$row_val, ($con_address_name["con_address"]))
            ->setCellValue('F'.$row_val, ($row["invoice_no"]))
            ->setCellValue('G'.$row_val, ($row["invoice_date"]))
            ->setCellValue('H'.$row_val, ($row["invoice_qty"]))
            ->setCellValue('I'.$row_val, ($row["invoice_value"]))
            ->setCellValue('J'.$row_val, ($row["ac_team_verifiy_status"]))
            ->setCellValue('K'.$row_val, ($row["ac_team_approved_by"]));
            // ->setCellValue('L'.$row_val, ($row["dispatch_status"]));
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
$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);








header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Dispatch.xls"');
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


