    <?php
    include '../../config/dbconfig.php';
    include 'simplexlsx.php'; 
    require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");

    session_start();

    try {
        $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "DB Connection failed."]);
        exit;
    }

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
        $errors = [];

        // Pre-validate all rows
        foreach ($rows as $index => $fields) {
            if ($index === 0) continue;
            $row_num = $index + 1;

            $district_name = trim($fields[1]);
            $assign_team_member = trim($fields[8]);

            // Check district
            $select_district = $conn->prepare("SELECT unique_id FROM district_creation WHERE district_name = ?");
            $select_district->execute([$district_name]);
            if (!$select_district->fetch()) {
                $errors[] = "Row $row_num - District \"$district_name\" not found.";
            }

            // Check staff
            $check_user = $conn->prepare("SELECT COUNT(*) FROM user WHERE staff_id = ? AND is_delete = 0");
            $check_user->execute([$assign_team_member]);
            if ($check_user->fetchColumn() <= 0) {
                $errors[] = "Row $row_num - Staff ID \"$assign_team_member\" not found.";
            }
        }

        if (!empty($errors)) {
            echo json_encode(["status" => "error", "message" => "Upload failed:\n" . implode("\n", $errors)]);
            exit;
        }

        // Prepare insert
        $stmt = $conn->prepare("INSERT INTO consignee_details_sub(
            con_address, con_district, con_pincode, zone, 
            con_contact_name, con_contact_number, con_lan_num, consignee_gst, 
            assign_team_member, unique_id, form_main_unique_id, no_of_consignee, 
            cons_verify_sts, batch_id, po_number, batch_entry_date, consignee_received_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($rows as $index => $fields) {
            if ($index === 0) continue;

            $con_address = trim($fields[0]);
            $district_name = trim($fields[1]);
            $con_pincode = trim($fields[2]);
            $zone = trim($fields[3]);
            $con_contact_name = trim($fields[4]);
            $con_contact_number = trim($fields[5]);
            $con_lan_num = trim($fields[6]);
            $consignee_gst = trim($fields[7]);
            $assign_team_member = trim($fields[8]);

            $select_district = $conn->prepare("SELECT unique_id FROM district_creation WHERE district_name = ?");
            $select_district->execute([$district_name]);
            $row_district = $select_district->fetch();
            $district_id = $row_district['unique_id'];

            // Generate unique ID
            $unique_id = uniqid("con_");

            $stmt->execute([
                $con_address,
                $district_id,
                $con_pincode,
                $zone,
                $con_contact_name,
                $con_contact_number,
                $con_lan_num,
                $consignee_gst,
                $assign_team_member,
                $unique_id,
                $form_main_unique_id,
                $no_of_consignee,
                $cons_verify_sts,
                $batch_id,
                $po_number,
                $batch_entry_date,
                $consignee_received_date
            ]);
        }

        echo json_encode(["status" => "success", "message" => "Upload Successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Please upload an Excel file."]);
    }
    ?>

