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
$password = project_env('SERVICE_INSTALL_DB_PASSWORD');
$database_name = "aed_elcot";
try {
    $conn = new PDO($driver . ":host=" . $host . ";dbname=" . $database_name, $username, $password);
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
    ->setCellValue('D3', 'Department')
    ->setCellValue('E3', 'con Address')
    ->setCellValue('F3', 'Invoice No')
    ->setCellValue('G3', 'Invoice Date')
    ->setCellValue('H3', 'Invoice Value')
    // ->setCellValue('I3', 'File Name')
    ->setCellValue('I3', 'Bill Status');
    
$i = 0;
$row_val    = 4;
// .$relieve_date
// $payment_receive='';
$sql = ("SELECT * from view_bill_submission_list_pending_1");
$users       = $conn->query($sql);
foreach ($users as $row) {
    if ($row['bill_status'] == '0') {
        $row['bill_status'] = 'Pending';
    } else if ($row['bill_status'] == '1') {
        $row['bill_status'] = 'Completed';
    } else if ($row['bill_status'] == '2') {
        $row['bill_status'] = 'Bill_submit';
    }

    $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '".$row['department']."'");
    $department_details->execute();
    $department_name      = $department_details->fetch();

    $row['file_name'] = image_view("po_form", $row['consignee_unique_id'], $row['file_name']);
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, ++$i)
        ->setCellValue('B' . $row_val, ($row["po_num"]))
        ->setCellValue('C' . $row_val, disdate($row["po_date"]))
        ->setCellValue('D' . $row_val, ($department_name["department"]))
        ->setCellValue('E' . $row_val, ($row["con_address"]))
        ->setCellValue('F' . $row_val, ($row["invoice_no"]))
        ->setCellValue('G' . $row_val, ($row["invoice_date"]))
        ->setCellValue('H' . $row_val, ($row["invoice_value"]))
        // ->setCellValue('I' . $row_val, ($row["file_name"]))
        ->setCellValue('I' . $row_val, ($row["bill_status"]));
        // ->setCellValue('K' . $row_val, ($row["ld_per_day"]))
        // ->setCellValue('L' . $row_val, ($row["ld_maximum_val"]))
        // ->setCellValue('M' . $row_val, ($row["payement_receive"]))
        // ->setCellValue('O' . $row_val, ($row["payment_status"]));
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
$excel->getActiveSheet()->getStyle('A1:J3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($styleArray);
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
// $excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
// $excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
// $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
// $excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
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
function image_view($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view = '';
    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $file_name);
            if ($file_name) {
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }
    return $image_view;
}
?>
<script>
function print_1(file_name) {
    window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf_1(file_name) {
    onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view_1(file_name) {
    window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
</script>


