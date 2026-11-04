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
->mergeCells('A1:K1');

$excel->getActiveSheet()
->setCellValue('A1','Stock Position');



$excel->getActiveSheet()
->setCellValue('A3','S.No')
->setCellValue('B3','Po Number')
->setCellValue('C3','Po Date')
->setCellValue('D3','Department')
->setCellValue('E3','Excutive Name')
->setCellValue('F3','No.Of.Consignee')
->setCellValue('G3','No.Of.Items in PO')
->setCellValue('H3','Qty')
->setCellValue('I3','Total Value')
->setCellValue('J3','Status');
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
          
    $sql = ("SELECT * from view_stock_position_list where is_delete = 0");

        $users       = $conn->query($sql);
        foreach ($users as $row) {


            $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '".$row['department']."'");
            $department_details->execute();
            $department_name      = $department_details->fetch();

            $executive_name  = $conn->prepare("SELECT executive_name FROM executive_name WHERE unique_id = '".$row['executive_name']."'");
            $executive_name->execute();
            $executive_name      = $executive_name->fetch();

            if($row['status']=='0'){
                $row['status']='Pending';
            }
            else if($row['status']=='1'){
                $row['status']='Processing';
            }
            else if($row['status']=='2'){
                $row['status']='Complete';
            }
            // $pre_city_details    = $conn->prepare("SELECT city_name FROM cities WHERE unique_id = '".$row['pre_city']."'");
            // $pre_city_details->execute();
            // $pre_city_name       = $pre_city_details->fetch();

            // $pre_state_details   = $conn->prepare("SELECT state_name FROM states WHERE unique_id = '".$row['pre_state']."'");
            // $pre_state_details->execute();
            // $pre_state_name      = $pre_state_details->fetch();

            // $perm_city_details    = $conn->prepare("SELECT city_name FROM cities WHERE unique_id = '".$row['perm_city']."'");
            // $perm_city_details->execute();
            // $perm_city_name       = $perm_city_details->fetch();

            // $perm_state_details   = $conn->prepare("SELECT state_name FROM states WHERE unique_id = '".$row['perm_state']."'");
            // $perm_state_details->execute();
            // $perm_state_name      = $perm_state_details->fetch();

            // $bank_details   = $conn->prepare("SELECT bank_name,account_no,ifsc_code FROM staff_account_details WHERE  staff_unique_id = '".$row['unique_id']."'");
            // $bank_details->execute();
            // $bank       = $bank_details->fetch();
            // if (!empty($bank)) {
            //     $bank_name  = $bank['bank_name'];
            //     $account_no = $bank['account_no'];
            //     $ifsc_no    = $bank['ifsc_code'];
            // }else{
            //     $bank_name  = "";
            //     $account_no = "";
            //     $ifsc_no    = "";
            // }   

            // $reporting_officer   = $conn->prepare("SELECT staff_name FROM staff WHERE unique_id = '".$row['reporting_officer']."'");
            // $reporting_officer->execute();
            // $reporting_staff     = $reporting_officer->fetch();

            // $pre_city        = $pre_city_name['city_name'];
            // $pre_state       = $pre_state_name['state_name'];
            // $pre_building_no = $row['pre_building_no'];
            // $pre_street      = $row['pre_street'];
            // $pre_area        = $row['pre_area'];
            // $pre_pincode     = $row['pre_pincode'];

            // $present_address  = $pre_building_no." ".$pre_street." ".$pre_area." ".$pre_city." ".$pre_state."-".$pre_pincode;


            // $perm_city        = $perm_city_name['city_name'];
            // $perm_state       = $perm_state_name['state_name'];
            // $perm_building_no = $row['perm_building_no'];
            // $perm_street      = $row['perm_street'];
            // $perm_area        = $row['perm_area'];
            // $perm_pincode     = $row['perm_pincode'];

            // $permanent_address  = $perm_building_no." ".$perm_street." ".$perm_area." ".$perm_city." ".$perm_state."-".$perm_pincode;

            $excel->getActiveSheet()
            ->setCellValue('A'.$row_val, ++$i)
            ->setCellValue('B'.$row_val, ($row["po_num"]))
            ->setCellValue('C'.$row_val, disdate($row["po_date"]))
            ->setCellValue('D'.$row_val, ($department_name["department"]))
            ->setCellValue('E'.$row_val, ($executive_name["executive_name"]))
            ->setCellValue('F'.$row_val, ($row["no_of_consignee"]))
            ->setCellValue('G'.$row_val, ($row["no_of_po"]))
            ->setCellValue('H'.$row_val, ($row["qty"]))
            ->setCellValue('I'.$row_val, ($row["net_value"]));
            // ->setCellValue('J'.$row_val, ($row["status"]));
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



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Stock Position.xls"');
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



