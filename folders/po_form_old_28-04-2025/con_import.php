<?php
require_once __DIR__ . '/../../config/env.php';
// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

session_start();

$no_of_consignee = $_POST['no_of_consignee'];
$form_main_unique_id = $_POST['form_main_unique_id'];
$cons_verify_sts = $_POST['cons_verfiy_sts'];

        $batch_id = $_POST['batch_id'];
        $po_number = $_POST['po_number'];
        $consignee_received_date = $_POST['consignee_received_date'];
        $batch_entry_date = date('Y-m-d');
        
$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    $file_path = $_FILES['file']['tmp_name'];
    $xlsx = new SimpleXLSX($file_path);
    $rows = $xlsx->rows();
    $uploaded_count  = count($rows);

    $check_existing = $conn->prepare('select COUNT(*) from consignee_details_sub where form_main_unique_id = ? and is_delete = 0');
    $check_existing->execute([$form_main_unique_id]);

    $exisiting_count = $check_existing->fetchColumn();
    $total_after_upload = $exisiting_count + $uploaded_count;

    // if ($total_after_upload > $no_of_consignee) {
    //     echo "<script>alert('Error: You can only have $no_of_consignee consignee records')</script>";
    //     exit;
    // }

    // if ($no_of_consignee == 1 && count($rows) > 1) {
    //     echo json_encode(['status' => 'error', "message" => "Only 1 row is allowed when consignee is 1"]);
    //     exit;
    // }

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO consignee_details_sub(con_address, con_district,con_pincode, zone,  con_contact_name, con_contact_number, con_lan_num, consignee_gst, unique_id, form_main_unique_id, no_of_consignee, cons_verify_sts,batch_id,po_number,batch_entry_date,consignee_received_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($rows as $fields) {
        // Get District ID
        $select_district_name = $conn->prepare("S
        ELECT unique_id FROM district_creation WHERE district_name = ?");
        $select_district_name->execute([$fields[1]]);
        $row_district_name = $select_district_name->fetch();
        $district_name_value = $row_district_name['unique_id'];

        // Prepare data for insertion
        $unique_id = unique_id("");
        $con_address = $fields[0];
        $con_pincode = $fields[2];
        $zone = $fields[3];
        $con_contact_name = $fields[4];
        $con_contact_number = $fields[5];
        $con_lan_num = $fields[6];
        $consignee_gst = $fields[7];
        
        
        // Execute the statement for each row
        $stmt->execute([$con_address, $district_name_value,$con_pincode, $zone,  $con_contact_name, $con_contact_number, $con_lan_num, $consignee_gst, $unique_id, $form_main_unique_id, $no_of_consignee, $cons_verify_sts,$batch_id, $po_number,$consignee_received_date,$batch_entry_date]);
        
        // print_r("hiii".$stmt->execute());die();
    }

    echo "<script>alert('Upload Successful')</script>";

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Please upload an Excel file.']);
}
?>



