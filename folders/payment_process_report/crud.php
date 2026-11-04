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
    // case 'vendor_payment_report_datatable':

    // $search = $_POST['search']['value'];
    // $length = $_POST['length'];
    // $start  = $_POST['start'];
    // $draw   = $_POST['draw'];
    // $limit  = $length;

    // $data = [];
    // if ($length == '-1') {
    //     $limit = "";
    // }

    // $table = "vendor_payment_details vpd
    //           LEFT JOIN vendor_creation vc 
    //                 ON vpd.vendor_id = vc.unique_id
    //           LEFT JOIN user U 
    //                 ON U.unique_id = vpd.vendor_bill_created_by
    //           LEFT JOIN user FU 
    //                 ON FU.unique_id = vpd.finance_approved_by
    //           LEFT JOIN user MU 
    //                 ON MU.unique_id = vpd.managment_team_approvedby";

    // $columns = [
    //     "'' AS sno",
    //     "vc.company_name AS company_name",
    //     "vpd.total_amount AS invoice_amount",
    //     "vpd.tdsvaluepercentage AS tds",
    //     "vpd.acctdsvalue AS deduction",
    //     "vpd.acctotalpaybleamount AS payable_amount",
    //     "vc.account_no AS account_no",
    //     "vc.name AS name",
    //     "vc.bank_name AS bank_name",
    //     "vc.ifsc_code AS ifsc_code",
    //     "U.staff_name AS vendor_bill_created_name",
    //     "FU.staff_name AS finance_approved_name",
    //     "MU.staff_name AS management_approved_name",
    //     "vpd.finance_approved_by AS finance_approved_by",
    //     "vpd.finance_approved_date AS finance_approved_date",
    //     "vpd.managment_team_approvedby AS managment_team_approvedby",
    //     "vpd.managment_team_approvaldate AS managment_team_approvaldate"
    // ];

    // $table_details = [$table, $columns];

    // $where = "(vpd.payment_id IS NULL OR vpd.payment_id = '')
    //           AND vpd.managment_team_approval_sts = 1
    //           AND vpd.finance_approval = 1";

    // $group_by = "vpd.vendor_id";

    // $search_columns = [
    //     "vc.company_name",
    //     "vc.account_no",
    //     "vc.name",
    //     "vc.bank_name",
    //     "vc.ifsc_code",
    //     "U.staff_name",
    //     "FU.staff_name",
    //     "MU.staff_name"
    // ];

    // $search_where = datatable_searching($search, $search_columns);

    // if ($search_where) {
    //     $where .= " AND (" . $search_where . ")";
    // }

    // $order_by = "MAX(vpd.id) DESC";
    // $sql_function = "SQL_CALC_FOUND_ROWS";

    // $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);
    // $total_records = total_records();

    // if ($result->status) {
    //     $res_array = $result->data;
    //     $sno = $start;

    //     foreach ($res_array as $key => $value) {
    //         $value['sno'] = $sno + 1;
    //         $value['invoice_amount'] = number_format((float)$value['invoice_amount'], 2);
    //         $value['deduction'] = number_format((float)$value['deduction'], 2);
    //         $value['payable_amount'] = number_format((float)$value['payable_amount'], 2);

    //         $fin_date = !empty($value['finance_approved_date'])
    //             ? date('d-m-Y H:i:s', strtotime($value['finance_approved_date']))
    //             : '-';

    //         $man_date = !empty($value['managment_team_approvaldate'])
    //             ? date('d-m-Y H:i:s', strtotime($value['managment_team_approvaldate']))
    //             : '-';

    //         $value['finance_approved_name'] =
    //             ($value['finance_approved_name'] ?? '-') . "<br>" . $fin_date;

    //         $value['management_approved_name'] =
    //             ($value['management_approved_name'] ?? '-') . "<br>" . $man_date;

    //         $data[] = [
    //             $value['sno'],
    //             $value['company_name'],
    //             $value['invoice_amount'],
    //             $value['tds'],
    //             $value['deduction'],
    //             $value['payable_amount'],
    //             $value['account_no'],
    //             $value['name'],
    //             $value['bank_name'],
    //             $value['ifsc_code'],
    //             $value['vendor_bill_created_name'],
    //             $value['finance_approved_name'],
    //             $value['management_approved_name']
    //         ];

    //         $sno++;
    //     }

    //     $json_array = [
    //         "draw" => intval($draw),
    //         "recordsTotal" => intval($total_records),
    //         "recordsFiltered" => intval($total_records),
    //         "data" => $data
    //     ];
    // } else {
    //     $json_array = [
    //         "draw" => intval($draw),
    //         "recordsTotal" => 0,
    //         "recordsFiltered" => 0,
    //         "data" => []
    //     ];
    // }

    // echo json_encode($json_array);
    // break;

    case 'vendor_payment_report_datatable':

    $search = $_POST['search']['value'];
    $length = $_POST['length'];
    $start  = $_POST['start'];
    $draw   = $_POST['draw'];
    $limit  = $length;

    $data = [];

    if ($length == '-1') {
        $limit = "";
    }

    /*
     * STEP 1:
     * Create exactly the same bill-wise records as your main datatable:
     *
     * GROUP BY bill_no, vendor_id
     *
     * STEP 2:
     * Group those bill-wise records vendor-wise.
     *
     * Result:
     * One row per vendor
     * + bill count
     * + total invoice amount
     * + total deduction
     * + total payable amount
     */

    $table = "
        (
            SELECT
                bill_data.vendor_id,

                COUNT(*) AS record_count,

                SUM(bill_data.invoice_amount) AS invoice_amount,

                SUM(bill_data.deduction) AS deduction,

                SUM(bill_data.payable_amount) AS payable_amount,

                GROUP_CONCAT(
                    DISTINCT bill_data.tds
                    ORDER BY bill_data.tds
                    SEPARATOR ', '
                ) AS tds,

                MAX(bill_data.latest_id) AS latest_id

            FROM
            (
                SELECT
                    vendor_id,
                    bill_no,

                    SUM(COALESCE(amount, 0)) AS invoice_amount,

                    MAX(COALESCE(acctdsvalue, 0)) AS deduction,

                    MAX(COALESCE(acctotalpaybleamount, 0)) AS payable_amount,

                    MAX(tdsvaluepercentage) AS tds,

                    MAX(id) AS latest_id

                FROM vendor_payment_details

                WHERE finance_approval = 1
                  AND managment_team_approval_sts = 1
                  AND accounts_approval IS NULL
                  AND is_delete = 0

                GROUP BY
                    bill_no,
                    vendor_id

            ) AS bill_data

            GROUP BY bill_data.vendor_id

        ) AS vendor_summary

        LEFT JOIN vendor_creation vc
            ON vendor_summary.vendor_id = vc.unique_id

        LEFT JOIN vendor_payment_details vpd
            ON vpd.id = vendor_summary.latest_id

        LEFT JOIN user U
            ON U.unique_id = vpd.vendor_bill_created_by

        LEFT JOIN user FU
            ON FU.unique_id = vpd.finance_approved_by

        LEFT JOIN user MU
            ON MU.unique_id = vpd.managment_team_approvedby
    ";


    $columns = [

        "'' AS sno",

        "vc.company_name AS company_name",

        "vendor_summary.record_count AS record_count",

        "vendor_summary.invoice_amount AS invoice_amount",

        "vendor_summary.tds AS tds",

        "vendor_summary.deduction AS deduction",

        "vendor_summary.payable_amount AS payable_amount",

        "vc.account_no AS account_no",

        "vc.name AS name",

        "vc.bank_name AS bank_name",

        "vc.ifsc_code AS ifsc_code",

        "U.staff_name AS vendor_bill_created_name",

        "FU.staff_name AS finance_approved_name",

        "MU.staff_name AS management_approved_name",

        "vpd.finance_approved_date AS finance_approved_date",

        "vpd.managment_team_approvaldate AS managment_team_approvaldate"
    ];


    $table_details = [
        $table,
        $columns
    ];


    /*
     * Filtering is already applied inside vendor_summary.
     *
     * Do NOT again filter vpd here because vpd is being used only
     * to obtain the latest approval/user information.
     */
    $where = "";


    $search_columns = [
        "vc.company_name",
        "vc.account_no",
        "vc.name",
        "vc.bank_name",
        "vc.ifsc_code",
        "U.staff_name",
        "FU.staff_name",
        "MU.staff_name"
    ];


    $search_where = datatable_searching(
        $search,
        $search_columns
    );


    if ($search_where) {
        $where = "(" . $search_where . ")";
    }


    $group_by = "";

    $order_by = "vendor_summary.latest_id DESC";

    $sql_function = "SQL_CALC_FOUND_ROWS";


    $result = $pdo->select(
        $table_details,
        $where,
        $limit,
        $start,
        $order_by,
        $sql_function,
        $group_by
    );


    $total_records = total_records();


    if ($result->status) {

        $res_array = $result->data;

        $sno = $start;


        foreach ($res_array as $key => $value) {

            $value['sno'] = $sno + 1;


            /*
             * Vendor total count
             */
            $value['record_count'] =$value['record_count'];


            /*
             * Total invoice amount for this vendor
             */
            $value['invoice_amount'] =
                number_format(
                    (float)$value['invoice_amount'],
                    2
                );


            /*
             * Total deduction for this vendor
             */
            $value['deduction'] =
                number_format(
                    (float)$value['deduction'],
                    2
                );


            /*
             * Total payable amount for this vendor
             */
            $value['payable_amount'] =
                number_format(
                    (float)$value['payable_amount'],
                    2
                );


            /*
             * Latest finance approval date
             */
            $fin_date =
                !empty($value['finance_approved_date'])
                    ? date(
                        'd-m-Y H:i:s',
                        strtotime($value['finance_approved_date'])
                    )
                    : '-';


            /*
             * Latest management approval date
             */
            $man_date =
                !empty($value['managment_team_approvaldate'])
                    ? date(
                        'd-m-Y H:i:s',
                        strtotime(
                            $value['managment_team_approvaldate']
                        )
                    )
                    : '-';


            $value['finance_approved_name'] =
                ($value['finance_approved_name'] ?? '-')
                . "<br>"
                . $fin_date;


            $value['management_approved_name'] =
                ($value['management_approved_name'] ?? '-')
                . "<br>"
                . $man_date;


            $data[] = [

                $value['sno'],

                $value['company_name'],

                $value['record_count'],

                $value['invoice_amount'],

                $value['tds'],

                $value['deduction'],

                $value['payable_amount'],

                $value['account_no'],

                $value['name'],

                $value['bank_name'],

                $value['ifsc_code'],

                $value['vendor_bill_created_name'],

                $value['finance_approved_name'],

                $value['management_approved_name']
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
}


