<?php
include '../../config/dbconfig.php';
include 'simplexlsx.php'; 
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
session_start();

// DB Connection
try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed."]);
    exit;
}

// Get POST data
$no_of_consignee         = $_POST['no_of_consignee'];
$form_main_unique_id     = $_POST['form_main_unique_id'];
$cons_verify_sts         = $_POST['cons_verfiy_sts'];
$batch_id                = $_POST['batch_id'];
$po_number               = $_POST['po_number'];
$consignee_received_date = $_POST['consignee_received_date'];
$batch_entry_date        = date('Y-m-d');

// Validate file type
$allowedFileType = [
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    $file_path = $_FILES['file']['tmp_name'];
    $xlsx = new SimpleXLSX($file_path);
    $rows = $xlsx->rows();

    $errors = [];
    $missing_staff_ids = [];
    $insert_data = [];

    foreach ($rows as $index => $fields) {
        // if ($index === 0) continue; // Skip header row
        $row_num = 0;
    
        $district_name = trim($fields[1]);
        $assign_team_member_raw = trim($fields[8]);
        $staff_ids = array_filter(array_map('trim', explode(',', $assign_team_member_raw))); // Clean and remove empty
    
        $valid_staff_ids = [];
        $invalid_staff_ids = [];
    
        if (empty($staff_ids)) {
            $errors[] = "Row $row_num - No Staff IDs provided.";
            continue;
        }
    
        foreach ($staff_ids as $sid) {
            if (empty($sid)) {
                $invalid_staff_ids[] = "Empty";
                continue;
            }
    
            // Check if staff ID exists and is not deleted
            $check_user = $conn->prepare("SELECT COUNT(*) FROM user WHERE staff_id = ? AND is_delete = 0");
            $check_user->execute([$sid]);
    
            if ($check_user->fetchColumn() <= 0) {
                $invalid_staff_ids[] = "$sid (not found in user)";
                continue;
            }
    
            // Check if staff ID is already assigned in consignee_details_sub
            // $check_existing = $conn->prepare("SELECT COUNT(*) FROM consignee_details_sub WHERE FIND_IN_SET(?, assign_team_member)");
            // $check_existing->execute([$sid]);
    
            // if ($check_existing->fetchColumn() > 0) {
            //     $invalid_staff_ids[] = "$sid (already assigned)";
            // } else {
            //     $valid_staff_ids[] = $sid;
            // }
        }
    
        // If there are invalid staff IDs, generate a combined error message for the row
        if (!empty($invalid_staff_ids)) {
            $errors[] = "Row $row_num - No valid Staff IDs: " . implode(", ", $invalid_staff_ids);
            $missing_staff_ids = array_merge($missing_staff_ids, $invalid_staff_ids);
            continue;
        }
        // // Fetch district ID
        // $select_district = $conn->prepare("SELECT unique_id FROM district_creation WHERE district_name = ?");
        // $select_district->execute([$district_name]);
        // $row_district = $select_district->fetch();
        // $district_id = $row_district['unique_id'] ?? null;
    
        // if (!$district_id) {
        //     $errors[] = "Row $row_num - Invalid District: $district_name";
        //     continue;
        // }
    
    
        // Prepare insert data
        $unique_id = uniqid("con_");
        $assign_team_member_str = implode(",", $valid_staff_ids);

        $insert_data[] = [
            trim($fields[0]),  // con_address
            $district_id,
            trim($fields[2]),  // con_pincode
            trim($fields[3]),  // zone
            trim($fields[4]),  // con_contact_name
            trim($fields[5]),  // con_contact_number
            trim($fields[6]),  // con_lan_num
            trim($fields[7]),  // consignee_gst
            $assign_team_member_str,
            $unique_id,
            $form_main_unique_id,
            $no_of_consignee,
            $cons_verify_sts,
            $batch_id,
            $po_number,
            $batch_entry_date,
            $consignee_received_date
        ];
    }

    // If errors found, return them
    if (!empty($errors)) {
        echo json_encode([
            "status" => "error",
            "message" => implode("\n", $errors),
            "missing_ids" => array_unique($invalid_staff_ids)
        ]);
        exit;
    }

    // Insert valid data
    if (!empty($insert_data)) {
        $stmt = $conn->prepare("INSERT INTO consignee_details_sub(
            con_address, con_district, con_pincode, zone,
            con_contact_name, con_contact_number, con_lan_num, consignee_gst,
            assign_team_member, unique_id, form_main_unique_id, no_of_consignee,
            cons_verify_sts, batch_id, po_number, batch_entry_date, consignee_received_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($insert_data as $data) {
            $stmt->execute($data);
        }

        echo json_encode(["status" => "success", "message" => "Upload Successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No valid data to insert."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid file type. Please upload a valid Excel file."]);
}
?>

