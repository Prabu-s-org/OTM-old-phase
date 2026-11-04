<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "invoice_creation_main";
// $table             = "view_dispatch_list_final";
$table_dispatch = "dispatch_list";
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// Variables Declaration

$action = $_POST['action'];
$action_obj = (object) [
    "status" => 0,
    "data" => "",
    "error" => "Action Not Performed"
];
$json_array = "";
$sql = "";
$user_type = "";
$is_active = "";
$unique_id = "";
$prefix = "";
$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose
try {
    // Database connection
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected sucessfully";
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
    exit;
}
switch ($action) {
    case 'vendor_payment_report_datatable':

    $search = $_POST['search']['value'];
    $length = $_POST['length'];
    $start  = $_POST['start'];
    $draw   = $_POST['draw'];
    $limit  = $length;

    $user_type =  $_SESSION['user_type_unique_id'];
    $user_id   = $_SESSION['sess_user_id']; // change if your session key is different
// print_r($user_type);
    $ROLE_ACCOUNTS   = '68cba503472bd48995';
    $ROLE_MANAGEMENT = '65fac54da3aac66007';
    $ROLE_FINANCE    = '6986d6e18a16169083';
    $ROLE_ALL        = '65deef78ba17d65741';

    $data = [];
    if ($length == '-1') {
        $limit = "";
    }

    $table = "vendor_payment_details vpd, vendor_creation vc, user U";

    $columns = [
        "'' as sno",
        "vpd.vendor_name",
        "vc.acc_holder_name",
        "vc.bank_name",
        "vc.branch_name",
        "vc.account_no",
        "vc.ifsc_code",
        "U.staff_name",
        "vc.accounts_approval",
        "vc.management_approval",
        "vc.finance_approval",
        "vc.id"
    ];

    $table_details = [$table, $columns];

    $where = "vpd.vendor_id = vc.unique_id 
              AND vpd.sess_user_id = U.unique_id 
              AND U.unique_id = vpd.vendor_bill_created_by";

    if ($user_type == $ROLE_ACCOUNTS) {
        $where .= " AND (vc.accounts_approval = 0 OR vc.accounts_approval IS NULL)";
    } elseif ($user_type == $ROLE_MANAGEMENT) {
        $where .= " AND vc.accounts_approval = 1
                    AND (vc.management_approval = 0 OR vc.management_approval IS NULL)";
    } elseif ($user_type == $ROLE_FINANCE) {
        $where .= " AND vc.accounts_approval = 1
                    AND vc.management_approval = 1
                    AND (vc.finance_approval = 0 OR vc.finance_approval IS NULL)";
    } elseif ($user_type == $ROLE_ALL) {
        // show all records
    }

    $search_columns = [
        "vpd.vendor_name",
        "vc.acc_holder_name",
        "vc.bank_name",
        "vc.branch_name",
        "vc.account_no",
        "vc.ifsc_code",
        "U.staff_name"
    ];

    $search_where = datatable_searching($search, $search_columns);
    if ($search_where) {
        $where .= " AND (" . $search_where . ")";
    }

    $group_by = "vc.unique_id";
    $sql_function = "SQL_CALC_FOUND_ROWS";

    $result = $pdo->select($table_details, $where, $limit, $start, "vc.id DESC", $sql_function, $group_by);
    $total_records = total_records();

    if ($result->status) {
        $res_array = $result->data;
        $sno = $start;

        foreach ($res_array as $key => $value) {
            $accounts_status = ((int)$value['accounts_approval'] === 1)
                ? '<span class="badge bg-success">Approved</span>'
                : '<span class="badge bg-warning text-dark">Pending</span>';

            $management_status = ((int)$value['management_approval'] === 1)
                ? '<span class="badge bg-success">Approved</span>'
                : '<span class="badge bg-warning text-dark">Pending</span>';

            $finance_status = ((int)$value['finance_approval'] === 1)
                ? '<span class="badge bg-success">Approved</span>'
                : '<span class="badge bg-warning text-dark">Pending</span>';

            if ((int)$value['finance_approval'] === 1) {
                $final_status = '<span class="badge bg-success">Completed</span>';
            } elseif ((int)$value['management_approval'] === 1) {
                $final_status = '<span class="badge bg-info text-dark">Management Approved</span>';
            } elseif ((int)$value['accounts_approval'] === 1) {
                $final_status = '<span class="badge bg-primary">Accounts Approved</span>';
            } else {
                $final_status = '<span class="badge bg-secondary">Pending</span>';
            }

            $approve_btn = '-';
            if ($user_type == $ROLE_ACCOUNTS && (int)$value['accounts_approval'] === 0) {
                $approve_btn = '<button class="btn btn-success btn-sm approve-btn" data-id="'.$value['id'].'" data-type="accounts">Approve</button>';
            } elseif ($user_type == $ROLE_MANAGEMENT && (int)$value['accounts_approval'] === 1 && (int)$value['management_approval'] === 0) {
                $approve_btn = '<button class="btn btn-primary btn-sm approve-btn" data-id="'.$value['id'].'" data-type="management">Approve</button>';
            } elseif ($user_type == $ROLE_FINANCE && (int)$value['accounts_approval'] === 1 && (int)$value['management_approval'] === 1 && (int)$value['finance_approval'] === 0) {
                $approve_btn = '<button class="btn btn-danger btn-sm approve-btn" data-id="'.$value['id'].'" data-type="finance">Approve</button>';
            } elseif ($user_type == $ROLE_ALL) {
                if ((int)$value['accounts_approval'] === 0) {
                    $approve_btn = '<button class="btn btn-success btn-sm approve-btn" data-id="'.$value['id'].'" data-type="accounts">Approve</button>';
                } elseif ((int)$value['management_approval'] === 0) {
                    $approve_btn = '<button class="btn btn-primary btn-sm approve-btn" data-id="'.$value['id'].'" data-type="management">Approve</button>';
                } elseif ((int)$value['finance_approval'] === 0) {
                    $approve_btn = '<button class="btn btn-danger btn-sm approve-btn" data-id="'.$value['id'].'" data-type="finance">Approve</button>';
                } else {
                    $approve_btn = '-';
                }
            }

            $data[] = [
                $sno + 1,
                $value['vendor_name'],
                $value['acc_holder_name'],
                $value['bank_name'],
                $value['branch_name'],
                $value['account_no'],
                $value['ifsc_code'],
                $value['staff_name'],
                $accounts_status,
                $management_status,
                $finance_status,
                $final_status,
                $approve_btn
            ];

            $sno++;
        }

        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $data
        ];
    } else {
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ];
    }

    echo json_encode($json_array);
    break;
    case 'approve_vendor_bank':

    $id   = $_POST['id'];
    $type = $_POST['type'];
    $user_id = $_SESSION['sess_user_id']; // change if your session key differs

    if ($type == 'accounts') {
        $sql = "UPDATE vendor_creation
                SET accounts_approval = 1,
                    accounts_approved_by = '$user_id',
                    accounts_approved_date = NOW()
                WHERE id = '$id'";
    } elseif ($type == 'management') {
        $sql = "UPDATE vendor_creation
                SET management_approval = 1,
                    management_approved_by = '$user_id',
                    management_approved_date = NOW()
                WHERE id = '$id'";
    } elseif ($type == 'finance') {
        $sql = "UPDATE vendor_creation
                SET finance_approval = 1,
                    finance_approved_by = '$user_id',
                    finance_approved_date = NOW()
                WHERE id = '$id'";
    } else {
        echo json_encode([
            "status" => 0,
            "msg" => "Invalid approval type"
        ]);
        exit;
    }

    $stmt = $conn->prepare($sql);
    $status = $stmt->execute();

    if ($status) {
        echo json_encode([
            "status" => 1,
            "msg" => "Approved successfully"
        ]);
    } else {
        echo json_encode([
            "status" => 0,
            "msg" => "Approval failed"
        ]);
    }
    break;
}


