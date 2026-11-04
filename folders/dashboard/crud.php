<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];


// // Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

// // Variables Declaration
$action = $_POST['action'];

$is_active = "";
$unique_id = "";
$prefix = "";

$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose

switch ($action) {

    // case 'task_details':

    //     $json_array = "";
    //     $acc_year = $_POST['acc_year'];
    //     $table = "po_department_count";
    //     $today = date('Y-m-d');
    //     if ($acc_year == '') {
    //         $columns = [
    //             "SUM(total) as po_count",
    //             // "ROUND(SUM(total_value), 0) AS invoice_value",
    //             "'' AS acc_year",
    //             "(SELECT SUM(total_amount) FROM po_form WHERE file_name IS NOT NULL AND is_delete = 0) AS invoice_value",
    //             "(SELECT SUM(total_qty) FROM po_form WHERE file_name IS NOT NULL AND is_delete = 0) AS po_qty"
    //         ];
    //     } else {
    //         $columns = [
    //             "total as po_count",
    //             // "ROUND(total_value, 0) AS invoice_value",
    //             "acc_year",
    //             "(SELECT SUM(total_amount) FROM po_form WHERE is_delete = 0) AS invoice_value",
    //             "(SELECT SUM(total_qty) FROM po_form WHERE is_delete = 0) AS po_qty"
    //         ];
    //     }


    //     $table_details = [
    //         $table,
    //         $columns
    //     ];


    //     $where = "1"; // Default always true condition

    //     // Add acc_year condition if set
    //     if (!empty($acc_year)) {
    //         $where .= " AND acc_year = '$acc_year'";
    //     }
    //     if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
    //         $session_user_type = $_SESSION['sess_user_type'];
    //         if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
    //             $where .= " AND sess_user_type = '$session_user_type'";
    //         } else {
    //             $where .= '';
    //         }
    //     }

    //     $result = $pdo->select($table_details, $where);
    //     print_r($result);
    //     $res_array = $result->data;
    //     foreach ($res_array as $value) {

    //         $po_count = $value['po_count'];
    //         $po_qty = $value['po_qty'];
    //         if ($value['invoice_value'] == '') {
    //             $invoice_value = 0;
    //         } else {
    //             $invoice_value = formatIndianNumber($value['invoice_value']);

    //         }
    //     }

    //     $json_array = [
    //         "po_count" => $po_count,
    //         "invoice_value" => $invoice_value,
    //         "po_qty" => $po_qty,

    //     ];


    //     echo json_encode($json_array);
    //     break;.


    case 'task_details':

        $json_array = [];
        $acc_year = $_POST['acc_year'];
        $table = "po_department_count";

        // Columns depending on whether acc_year is provided
        if (empty($acc_year)) {
            $columns = [
                "SUM(total) AS po_count",
                "'' AS acc_year",
                "(SELECT SUM(total_amount) 
             FROM po_form 
             WHERE is_delete = 0) AS invoice_value",
                "(SELECT SUM(total_qty) 
             FROM po_form 
             WHERE is_delete = 0) AS po_qty"
            ];
            $where = "1"; // no acc_year filter
        } else {
            $columns = [
                "total AS po_count",
                "acc_year",
                "(SELECT SUM(total_amount) 
             FROM po_form 
             WHERE is_delete = 0 
               AND acc_year = po_department_count.acc_year) AS invoice_value",
                "(SELECT SUM(total_qty) 
             FROM po_form 
             WHERE is_delete = 0 
               AND acc_year = po_department_count.acc_year) AS po_qty"
            ];
            $where = "acc_year = '$acc_year'";
        }

        // Filter by session user type if not Admin/SuperAdmin
        // if (!empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     }
        // }

        $table_details = [$table, $columns];
        $result = $pdo->select($table_details, $where);
// $pdo->query("CALL update_po_department_count()");
//         $pdo->query("CALL insert_stock_summary_by_year()");
//         $pdo->query("CALL update_installation_summary()");
//         $pdo->query("CALL update_snr_installation_summary()");
//         $pdo->query("CALL update_doc_verifi_ac()");
//         $pdo->query("CALL sp_update_invoice_summary()");
//         $pdo->query("CALL update_sign_doc_summary()");
//         $pdo->query("CALL bill_generation_pending()");
//         $pdo->query("CALL update_bill_submission_pending_summary()");
        // print_r($result);die();

        if ($result->status && !empty($result->data)) {
            foreach ($result->data as $value) {
                $po_count = $value['po_count'] ?? 0;
                $po_qty = $value['po_qty'] ?? 0;
  $invoice_value = empty($value['invoice_value']) 
            ? '0.00' 
            : formatIndianNumbers1(number_format((float)$value['invoice_value'], 2, '.', ''));
                    }
        } else {
            $po_count = 0;
            $po_qty = 0;
            $invoice_value = 0;
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "po_qty" => $po_qty,
        ];

        echo json_encode($json_array);
        break;


case 'railway_task_details':

    $json_array = [];
    $acc_year = $_POST['acc_year'] ?? '';
    $table = "po_form";

    // Columns depending on whether acc_year is provided
    if (empty($acc_year)) {
        $columns = [
            "COUNT(unique_id) AS po_count",
            "'' AS acc_year",
            "SUM(total_amount) AS invoice_value",
            "SUM(total_qty) AS po_qty"
        ];
        $where = "is_delete = 0 AND type_of_po = 2";
    } else {
        $columns = [
            "COUNT(unique_id) AS po_count",
            "acc_year",
            "SUM(total_amount) AS invoice_value",
            "SUM(total_qty) AS po_qty"
        ];
        $where = "acc_year = '$acc_year' AND is_delete = 0 AND type_of_po = 2";
    }

    $table_details = [$table, $columns];
    $result = $pdo->select($table_details, $where);

    if ($result->status && !empty($result->data)) {
        foreach ($result->data as $value) {
            $po_count = $value['po_count'] ?? 0;
            $po_qty = $value['po_qty'] ?? 0;
            $invoice_value = empty($value['invoice_value']) ? 0 : formatIndianNumber($value['invoice_value']);
        }
    } else {
        $po_count = 0;
        $po_qty = 0;
        $invoice_value = 0;
    }

    $json_array = [
        "po_count" => $po_count,
        "invoice_value" => $invoice_value,
        "po_qty" => $po_qty,
    ];

    echo json_encode($json_array);
    break;

    case 'get_consignee_address_cnt':

    $json_array = [];
    $acc_year = $_POST['acc_year'] ?? '';
    $table = "po_form";

    // Columns depending on whether acc_year is provided
    if (empty($acc_year)) {

        
        $columns = [
            
            "COUNT(unique_id) AS po_count",
            "'' AS acc_year",
            //  "(select COUNT(b.unique_id) from consignee_details_sub as b where b.is_delete = 0 and b.form_main_unique_id = po_form.unique_id and b.acc_year = '$acc_year')  AS consignee_total_address",
            " (
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1
  ) AS consignee_total_address",
//    " (
//     SELECT COUNT(b.unique_id)
//     FROM consignee_details_sub AS b
//     INNER JOIN po_form AS pf2
//       ON b.form_main_unique_id = pf2.unique_id
//     WHERE b.is_delete = 0 
//       AND pf2.is_delete = 0 AND b.cons_verify_sts = 1 AND b.cons_verify_sts = 0
//       AND pf2.type_of_po = 1
//   ) AS tot_par_consignee_po_count",
    " (
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 AND b.cons_verify_sts = 1 AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1 
  ) AS tot_verify_address",
   "(
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 AND (b.cons_verify_sts != 1 OR b.cons_verify_sts IS NULL) AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1 $acc_cond_chk
  ) AS tot_not_verify_address"
            // "SUM(total_qty) AS po_qty"
        ];
        $where = "is_delete = 0 AND type_of_po = 1";
    } else {
        $acc_cond_chk = " AND b.acc_year = '$acc_year'
      AND pf2.acc_year = '$acc_year'";
        $columns = [
            "COUNT(unique_id) AS po_count",
            "acc_year",
          " (
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 
      AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1 $acc_cond_chk
  ) AS consignee_total_address",
//    " (
//     SELECT COUNT(b.unique_id)
//     FROM consignee_details_sub AS b
//     INNER JOIN po_form AS pf2
//       ON b.form_main_unique_id = pf2.unique_id
//     WHERE b.is_delete = 0 
//       AND pf2.is_delete = 0 AND b.cons_verify_sts = 1 AND b.cons_verify_sts = 0
//       AND pf2.type_of_po = 1 $acc_cond_chk
//   ) AS tot_par_consignee_po_count",
   "(
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 AND b.cons_verify_sts = 1 AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1 $acc_cond_chk
  ) AS tot_verify_address",
   "(
    SELECT COUNT(b.unique_id)
    FROM consignee_details_sub AS b
    INNER JOIN po_form AS pf2
      ON b.form_main_unique_id = pf2.unique_id
    WHERE b.is_delete = 0 AND (b.cons_verify_sts != 1 OR b.cons_verify_sts IS NULL) AND pf2.is_delete = 0 
      AND pf2.type_of_po = 1 $acc_cond_chk
  ) AS tot_not_verify_address"
            // "SUM(total_qty) AS po_qty"
        ];

        
        $where = "acc_year = '$acc_year' AND is_delete = 0  AND type_of_po = 1";
    }

    $table_details = [$table, $columns];
    $result = $pdo->select($table_details, $where);
    // print_r($result);
    if ($result->status && !empty($result->data)) {
        foreach ($result->data as $value) {
            $po_count = $value['po_count'] ?? 0;
            $consignee_total_address = $value['consignee_total_address'] ?? 0;

            $tot_verify_address = $value['tot_verify_address'] ?? 0;
         $tot_not_verify_address = $value['tot_not_verify_address'] ?? 0;


            // $tot_par_consignee_po_count = $value['tot_par_consignee_po_count'] ?? 0;

            
            // $invoice_value = empty($value['invoice_value']) ? 0 : formatIndianNumber($value['invoice_value']);
        }
    } else {
        $po_count = 0;
        $consignee_total_address = 0;
        $tot_par_consignee_po_count = 0;
        $tot_verify_address = 0;
     $tot_not_verify_address = 0;
    }

    $json_array = [
        "po_count" => $po_count,
        // "invoice_value" => $invoice_value,
        "consignee_total_address" => $consignee_total_address,
        // "tot_par_consignee_po_count" => $tot_par_consignee_po_count,
        // "tot_par_consignee_address" => $tot_par_consignee_po_count,
        "tot_verify_address" => $tot_verify_address,
        "tot_not_verify_address" => $tot_not_verify_address,
    ];

    echo json_encode($json_array);
    break;


        case 'sector_wise_count_main':

        $json_array = [];
        $acc_year = $_POST['acc_year'];
        $table = "account_sector";

        $sql = "
SELECT 
    s.sector_name,
    COUNT(pf.acc_sector) AS po_count,
    COALESCE(SUM(pf.total_amount), 0) AS invoice_value,
    COALESCE(SUM(pf.total_qty), 0) AS po_qty
FROM account_sector s
LEFT JOIN po_form pf
  ON pf.acc_sector = s.unique_id
  AND pf.is_delete = 0
";

// Add year filter only if provided
if (!empty($_POST['acc_year'])) {
    $sql .= " AND pf.acc_year = :acc_year ";
}

$sql .= " GROUP BY s.sector_name";

$stmt = $pdo->prepare($sql);

// Bind the parameter safely
if (!empty($_POST['acc_year'])) {
    $stmt->bindValue(':acc_year', $_POST['acc_year'], PDO::PARAM_STR);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'data' => $data
]);
break;

         case 'sector_wise_count_test':

        $json_array = [];
        $acc_year = $_POST['acc_year'];
        $table = "account_sector";

        // Columns depending on whether acc_year is provided
        // if (empty($acc_year)) {
            $columns = [
                // "get_sector_name()",
                // "(select get_sector_name(acc_sector))"
                "sector_name",
                "(SELECT count(acc_sector) from po_form where acc_sector = $table.unique_id and is_delete = 0) as end",
                "(SELECT count(acc_sector) from po_form where acc_sector = $table.unique_id and is_delete = 0) as end",
            ];
            $where = "1"; // no acc_year filter
       

        $table_details = [$table, $columns];
        $result = $pdo->select($table_details, $where);

        if ($result->status && !empty($result->data)) {
            foreach ($result->data as $value) {
                $po_count = $value['po_count'] ?? 0;
                $po_qty = $value['po_qty'] ?? 0;
                $invoice_value = empty($value['invoice_value']) ? 0 : formatIndianNumber($value['invoice_value']);
            }
        } else {
            $po_count = 0;
            $po_qty = 0;
            $invoice_value = 0;
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "po_qty" => $po_qty,
        ];

        echo json_encode($json_array);
        break;


    case 'pen_task_details':

        $json_array = [];
        $acc_year = $_POST['acc_year'] ?? '';
        $table = "po_form";

        // Base WHERE clause
        $where = "file_name IS NULL AND is_delete = 0";

        // Add year filter if provided
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // Add user type filter if not Admin/SuperAdmin
        // if (!empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if (!in_array($session_user_type, ['Admin', 'SuperAdmin'])) {
        //         $where .= " AND user_type = '$session_user_type'";
        //     }
        // }

        // Build columns
        $columns = [
            "COUNT(DISTINCT unique_id) AS pen_po_count",
            "'" . (!empty($acc_year) ? $acc_year : "All Years") . "' AS acc_year",
            "SUM(total_amount) AS pen_invoice_value",
            "SUM(total_qty) AS pen_po_qty"
        ];

        // Table details for your custom $pdo->select() method
        $table_details = [$table, $columns];

        // Run query
        $result = $pdo->select($table_details, $where);

        // Default values
        $po_count = 0;
        $po_qty = 0;
        $invoice_value = 0;

        // If query successful and has data
        if ($result->status && !empty($result->data)) {
            $value = $result->data[0]; // First row only
            $po_count = $value['pen_po_count'] ?? 0;
            $po_qty = $value['pen_po_qty'] ?? 0;
            $invoice_value = !empty($value['pen_invoice_value'])
                ? formatIndianNumber($value['pen_invoice_value'])
                : 0;
        }

        // JSON Response
        $json_array = [
            "pen_po_count" => $po_count,
            "pen_invoice_value" => $invoice_value,
            "pen_po_qty" => $po_qty
        ];

        echo json_encode($json_array);
        break;



    // case 'task_details':

    //     $json_array = "";
    //     $acc_year = $_POST['acc_year'];
    //     $table = "po_department_count";
    //     $today = date('Y-m-d');
    //     if ($acc_year == '') {
    //         $columns = [
    //             "SUM(total) as po_count",
    //             // "ROUND(SUM(total_value), 0) AS invoice_value",
    //             "(SELECT SUM(with_tax) FROM po_form_processed) AS invoice_value",
    //             "'All Years' AS acc_year"
    //         ];
    //     } else {
    //         $columns = [
    //             "total as po_count",
    //             // "ROUND(total_value, 0) AS invoice_value",
    //             "(SELECT SUM(with_tax) FROM po_form_processed WHERE acc_year = '$acc_year') AS invoice_value", // Filter by acc_year
    //             "acc_year",
    //         ];
    //     }


    //     $table_details = [
    //         $table,
    //         $columns
    //     ];


    //     $where = "1"; // Default always true condition

    //     // Add acc_year condition if set
    //     if (!empty($acc_year)) {
    //         $where .= " AND acc_year = '$acc_year'";
    //     }

    //     if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
    //         $session_user_type = $_SESSION['sess_user_type'];
    //         if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
    //             $where .= " AND sess_user_type = '$session_user_type'";
    //         } else {
    //             $where .= '';
    //         }
    //     }

    //     $result = $pdo->select($table_details, $where);
    //     $res_array = $result->data;
    //     foreach ($res_array as $value) {

    //         $po_count = $value['po_count'];
    //         if ($value['invoice_value'] == '') {
    //             $invoice_value = 0;
    //         } else {
    //             $invoice_value = formatIndianNumber($value['invoice_value']);

    //         }
    //     }

    //     $json_array = [
    //         "po_count" => $po_count,
    //         "invoice_value" => $invoice_value,

    //     ];


    //     echo json_encode($json_array);
    //     break;

    case 'stock_details':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table = "view_dash_stock_position";
        $today = date('Y-m-d');
        $columns = [
            "(count(unique_id)) as po_count",
            "(SUM(total_qty)) as total_qty",
            "(sum(total_amount)) as total_value",
            "acc_year",
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "bal_qty=0"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where .= '';
        //     }
        // }

        $result = $pdo->select($table_details, $where);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            $total_qty = $value['total_qty'];
            $total_value = $value['total_value'];
            if ($value['total_value'] == '') {
                $value2 = 0;
            } else {
                $value2 = formatIndianNumber($value['total_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "total_qty" => $total_qty,
            "total_value" => $value2,
        ];


        echo json_encode($json_array);
        break;

    case 'par_stock_details':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table = "view_dash_stock_position";
        $today = date('Y-m-d');
        $columns = [
            "(count(unique_id)) as po_count",
            "(SUM(stock_qty)) as total_qty",
            "(sum(stock_value)) as total_value",
            "acc_year",
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "bal_qty != 0 and bal_qty IS NOT NULL"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where .= '';
        //     }
        // }

        $result = $pdo->select($table_details, $where);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            $total_qty = $value['total_qty'];
            $total_value = $value['total_value'];
            if ($value['total_value'] == '') {
                $value2 = 0;
            } else {
                $value2 = formatIndianNumber($value['total_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "total_qty" => $total_qty,
            "total_value" => $value2,
        ];


        echo json_encode($json_array);
        break;
    case 'balpar_stock_details':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table = "view_dash_stock_position";
        $today = date('Y-m-d');
        $columns = [
            "(SUM(bal_qty)) as total_qty",
            "(sum(bal_value)) as total_value",
            "acc_year",
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "bal_qty != 0 and bal_qty IS NOT NULL"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where .= '';
        //     }
        // }

        $result = $pdo->select($table_details, $where);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $total_qty = $value['total_qty'];
            $total_value = $value['total_value'];
            if ($value['total_value'] == '') {
                $value2 = 0;
            } else {
                $value2 = formatIndianNumber($value['total_value']);
            }

        }

        $json_array = [
            "total_qty" => $total_qty,
            "total_value" => $value2,
        ];


        echo json_encode($json_array);
        break;

    case 'bal_stock_details':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table = "view_dash_stock_position";
        $today = date('Y-m-d');
        $columns = [
            "(count(unique_id)) as po_count",
            "(SUM(total_qty)) as total_qty",
            "(sum(total_amount)) as total_value",
            "acc_year",
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "bal_qty IS NULL"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where .= '';
        //     }
        // }

        $result = $pdo->select($table_details, $where);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            $total_qty = $value['total_qty'];
            $total_value = $value['total_value'];
            if ($value['total_value'] == '') {
                $value2 = 0;
            } else {
                $value2 = formatIndianNumber($value['total_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "total_qty" => $total_qty,
            "total_value" => $value2,
        ];


        echo json_encode($json_array);
        break;

    case 'over_stock_details':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table = "view_dash_stock_position";
        $today = date('Y-m-d');
        $columns = [
            "(count(unique_id)) as po_count",
            "(SUM(total_qty)) as total_qty",
            "(sum(total_amount)) as total_value",
            "acc_year",
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = "1"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where .= '';
        //     }
        // }

        $result = $pdo->select($table_details, $where);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            $total_qty = $value['total_qty'];
            $total_value = $value['total_value'];
            if ($value['total_value'] == '') {
                $value2 = 0;
            } else {
                $value2 = formatIndianNumber($value['total_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "total_qty" => $total_qty,
            "total_value" => $value2,
        ];


        echo json_encode($json_array);
        break;

    case 'amc_details':

        $table_stock = "po_department_count";
        $json_array = [];

        $acc_year = $_POST['acc_year'];
        $acc_year_condition = !empty($acc_year) ? " AND ar.acc_year = '$acc_year'" : '';

        if (!empty($acc_year)) {
            // If acc_year is provided, fetch raw values for that year
            $columns = [
                "amcpercent",
                "amc_count",
                "amc_total_value",
                "total_value",
                "acc_year"
            ];
        } else {
            // If acc_year is empty, sum all values
            $columns = [
                "ROUND(SUM(amcpercent), 2) AS amcpercent",
                "SUM(amc_count) AS amc_count",
                "SUM(amc_total_value) AS amc_total_value",
                "SUM(total_value) AS total_value",
            ];
        }
        // Define table details
        $table_details = [
            $table_stock,
            $columns
        ];


        $where_1 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_1 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_1 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_1 .= '';
        //     }
        // }
        // Execute query
        $result_values = $pdo->select($table_details, $where_1);

        if ($result_values->status) {
            $res_array = $result_values->data;

            // Initialize default values
            $po_count_1 = 0;
            $value_1 = 0;
            $po_count = 0;
            $value = 0;
            $po_count_amc = 0;
            $amc_count = 0;
            $percentage = 0;

            foreach ($res_array as $row) {
                // Original string values with commas
                $amc_raw = $row['amc_total_value'] ?? 0;
                $total_raw = $row['total_value'] ?? 0;
                $amc_count = $row['amc_count'] ?? 0;

                // Remove commas and cast to float
                $value = (float) str_replace(',', '', $amc_raw);
                $total_value = (float) str_replace(',', '', $total_raw);

                // Calculate percentage safely
                $percentage = ($total_value != 0) ? round(($value / $total_value) * 100, 2) : 0;
                $values = moneyFormatIndia1($value);
            }
            $json_array = [

                "value" => $values, // Optional: round to 2 decimal places
                "amc_percentae" => $percentage,
                "amc_count" => $amc_count,
            ];
        } else {
            $json_array = ["error" => "No data found"];
        }

        echo json_encode($json_array);
        break;

    //     case 'amc_details':

    //         $table_stock = "po_form_processed";
//         $json_array = [];

    //         $acc_year = $_POST['acc_year'];
//         $acc_year_condition = !empty($acc_year) ? " AND acc_year = '$acc_year'" : '';

    //         // if (!empty($acc_year)) {
//         //     // If acc_year is provided, fetch raw values for that year
//         //     $columns = [
//         //         "COUNT(DISTINCT po_unique_id) AS amc_count",
//         //         "(SELECT SUM(ar.amcvalue) FROM amcrequired ar WHERE ar.po_unique_id IN ( SELECT po_unique_id FROM po_form_processed WHERE amc_required = 'on')) AS amc_total_value",
//         //         "SUM(with_tax) AS total_value",
//         //     ];
//         // } else {
//         //     // If acc_year is empty, sum all values
//         //     $columns = [
//         //         "COUNT(DISTINCT po_unique_id) AS amc_count",
//         //         "(SELECT SUM(ar.amcvalue) FROM amcrequired ar WHERE ar.po_unique_id IN ( SELECT po_unique_id FROM po_form_processed WHERE amc_required = 'on')) AS amc_total_value",
//         //         "SUM(with_tax) AS total_value",
//         //     ];
//         // }

    //         $columns = [
//                     "COUNT(DISTINCT po_unique_id) AS amc_count",
//                     "(SELECT SUM(ar.amcvalue) 
//                         FROM amcrequired ar 
//                             WHERE ar.po_unique_id IN (
//                                 SELECT po_unique_id 
//                                 FROM po_form_processed 
//                                 WHERE amc_required = 'on' $acc_year_condition
//                             )) AS amc_total_value",
//                     "SUM(with_tax) AS total_value"
//         ];
//         // Define table details
//         $table_details = [
//             $table_stock,
//             $columns
//         ];


    //         $where_1 = "amc_required = 'on'"; // Default always true condition

    //         // Add acc_year condition if set
//         if (!empty($acc_year)) {
//             $where_1 .= " AND acc_year = '$acc_year'";
//         }
//         if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
//             $session_user_type = $_SESSION['sess_user_type'];
//             if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
//                 $where_1 .= " AND sess_user_type = '$session_user_type'";
//             } else {
//                 $where_1 .= '';
//             }
//         }
//         // Execute query
//         $result_values = $pdo->select($table_details, $where_1);
// // print_r($result_values);die();
//         if ($result_values->status) {
//             $res_array = $result_values->data;

    //             // Initialize default values
//             $po_count_1 = 0;
//             $value_1 = 0;
//             $po_count = 0;
//             $value = 0;
//             $po_count_amc = 0;
//             $amc_count = 0;
//             $percentage = 0;

    //             foreach ($res_array as $row) {
//                 // Original string values with commas
//                 $amc_total_value = $row['amc_total_value'] ?? 0;
//                 $total_raw = $row['total_value'] ?? 0;
//                 $amc_count = $row['amc_count'] ?? 0;

    //                 // Remove commas and cast to float
//                 $amc_value = (float) str_replace(',', '', $amc_total_value);
//                 $total_value = (float) str_replace(',', '', $total_raw);

    //                 // Calculate percentage safely
//                 $percentage = ($total_value != 0) ? round(($amc_value / $total_value) * 100, 2) : 0;

    //             }

    //             $json_array = [

    //                 "value" => formatIndianNumber($amc_value), // Optional: round to 2 decimal places
//                 "amc_percentae" => $percentage,
//                 "amc_count" => $amc_count,
//             ];
//         } else {
//             $json_array = ["error" => "No data found"];
//         }

    //         echo json_encode($json_array);
//         break;

    // assign qty
    case 'assign_qty':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_inv_assign = "stock_invoice_summary";
        if (!empty($acc_year)) {
            $columns = [
                "po_count",
                "stock_value"
            ];
        } else {
            $columns = [
                "SUM(po_count) AS po_count",
                "SUM(stock_value) AS stock_value"
            ];
        }

        $table_details = [
            $table_inv_assign,
            $columns
        ];
        $where3 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['stock_value'] == '') {
                $stock_value = 0;
            } else {
                $stock_value = formatIndianNumber($value['stock_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "stock_value" => $stock_value,
        ];


        echo json_encode($json_array);
        break;
    case 'partial_assign_qty':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_inv_assign = "view_invoice_assign_qty_count";
        $columns = [
            "count(form_main_unique_id) As po_count",
            "SUM(total_value) AS stock_value",

        ];
        $table_details = [
            $table_inv_assign,
            $columns
        ];

        $where3 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['stock_value'] == '') {
                $stock_value = 0;
            } else {
                $stock_value = formatIndianNumber($value['stock_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "stock_value" => $stock_value,
        ];


        echo json_encode($json_array);
        break;


    // invoice pending 
    case 'inv_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        // $table_inv = "invoice_summary";
        // if ($acc_year) {
        //     $columns = [
        //         "po_count",
        //         "invoice_count",
        //         "invoice_value",
        //     ];
        // } else {
        //     $columns = [
        //         "SUM(po_count) AS po_count",
        //         "SUM(invoice_count) AS invoice_count",
        //         "SUM(invoice_value) AS invoice_value",
        //     ];
        // }
        $table_inv = "invoice_creation_main";

        $columns = [
            "count(unique_id) as po_count",
            "sum(invoice_qty) as invoice_count",
            "sum(invoice_value) as invoice_value",
        ];


        $table_details = [
            $table_inv,
            $columns
        ];


        $where3 = "is_delete = 0 and (dc_number IS NULL OR dc_number = '')"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        // $group_by = 'po_num';
        $result = $pdo->select($table_details, $where3);
        // print_r($result);die();
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;

    // invoice pending 
    case 'get_conginess_completed':

        $json_array = "";
        $acc_year = $_POST['acc_year'];


        $table_inv = "po_consignee_assign";
        if ($acc_year) {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(total_invoice_qty) AS stk_assign_count",
                "sum(invoice_qty_value) AS total_value"
            ];
        } else {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(total_invoice_qty) AS stk_assign_count",
                "sum(invoice_qty_value) AS total_value"
            ];
        }
        $table_details = [
            $table_inv,
            $columns
        ];
        $where3 = "df = 0 and stock_qty !=0 and total_invoice_qty !=0"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        // print_r($result);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['po_assign_count'] == '') {
                $po_assign_count = 0;
            } else {
                $po_assign_count = $value['po_assign_count'];
            }

            if ($value['stk_assign_count'] == '') {
                $stk_assign_count = 0;
            } else {
                $stk_assign_count = $value['stk_assign_count'];
            }

            if ($value['total_value'] == '') {
                $total_value = 0;
            } else {
                $total_value = formatIndianNumber($value['total_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "po_assign_count" => $po_assign_count,
            "stk_assign_count" => $stk_assign_count,
            "total_value" => $total_value
        ];


        echo json_encode($json_array);
        break;

    case 'get_conginess_no_stock':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        // $table_inv = "stock_assign_case_summary";
        // if ($acc_year) {
        //     $columns = [
        //         "total_count AS po_count",
        //         "total_po_assign_qty AS po_assign_count",
        //         "total_stc_assign_qty AS stk_assign_count",
        //         "total_po_total_value AS total_value"
        //     ];
        // } else {
        //     $columns = [
        //         "total_count AS po_count",
        //         "total_po_assign_qty AS po_assign_count",
        //         "total_stc_assign_qty AS stk_assign_count",
        //         "total_po_total_value AS total_value"
        //     ];
        // }
        // $table_details = [
        //     $table_inv,
        //     $columns
        // ];

        // $where3 = "case_status = 2"; // Default always true condition
        $table_inv = "po_consignee_assign";
        if ($acc_year) {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(stock_qty_value) AS total_value"
            ];
        } else {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(stock_qty_value) AS total_value"
            ];
        }

        $table_details = [
            $table_inv,
            $columns
        ];

        $where3 = "stock_qty !=0 and total_invoice_qty =0 and df !=0"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        // print_r($result);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['po_assign_count'] == '') {
                $po_assign_count = 0;
            } else {
                $po_assign_count = $value['po_assign_count'];
            }

            if ($value['stk_assign_count'] == '') {
                $stk_assign_count = 0;
            } else {
                $stk_assign_count = $value['stk_assign_count'];
            }

            if ($value['total_value'] == '') {
                $total_value = 0;
            } else {
                $total_value = formatIndianNumber($value['total_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "po_assign_count" => $po_assign_count,
            "stk_assign_count" => $stk_assign_count,
            "total_value" => $total_value
        ];

        echo json_encode($json_array);
        break;

    case 'get_conginess_partial':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        // $table_inv = "stock_assign_case_summary";
        // if ($acc_year) {
        //     $columns = [
        //         "total_count AS po_count",
        //         "total_po_assign_qty AS po_assign_count",
        //         "total_stc_assign_qty AS stk_assign_count",
        //         "total_po_total_value AS total_value",
        //         "partial_balance_qty AS bal_qty",
        //         "partial_balance_value AS bal_val"
        //     ];
        // } else {
        //     $columns = [
        //         "total_count AS po_count",
        //         "total_po_assign_qty AS po_assign_count",
        //         "total_stc_assign_qty AS stk_assign_count",
        //         "total_po_total_value AS total_value",
        //         "partial_balance_qty AS bal_qty",
        //         "partial_balance_value AS bal_val"
        //     ];
        // }
        $table_inv = "po_consignee_assign";
        if ($acc_year) {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(total_invoice_qty) AS stk_assign_count",
                "sum(invoice_qty_value) AS total_value",
                "sum(df) AS bal_qty",
                "sum(df_val) AS bal_val"
            ];
        } else {
            $columns = [
                "count(distinct form_main_unique_id) AS po_count",
                "sum(stock_qty) AS po_assign_count",
                "sum(total_invoice_qty) AS stk_assign_count",
                "sum(invoice_qty_value) AS total_value",
                "sum(df) AS bal_qty",
                "sum(df_val) AS bal_val"
            ];
        }

        $table_details = [
            $table_inv,
            $columns
        ];

        $where3 = "stock_qty !=0 and total_invoice_qty !=0 and df !=0"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        // print_r($result);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['po_assign_count'] == '') {
                $po_assign_count = 0;
            } else {
                $po_assign_count = $value['po_assign_count'];
            }

            if ($value['stk_assign_count'] == '') {
                $stk_assign_count = 0;
            } else {
                $stk_assign_count = $value['stk_assign_count'];
            }

            if ($value['bal_qty'] == '') {
                $bal_qty = 0;
            } else {
                $bal_qty = $value['bal_qty'];
            }

            if ($value['total_value'] == '') {
                $total_value = 0;
            } else {
                $total_value = formatIndianNumber($value['total_value']);
            }

            if ($value['bal_val'] == '') {
                $bal_val = 0;
            } else {
                $bal_val = formatIndianNumber($value['bal_val']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "po_assign_count" => $po_assign_count,
            "stk_assign_count" => $stk_assign_count,
            "bal_qty" => $bal_qty,
            "total_value" => $total_value,
            "bal_val" => $bal_val
        ];

        echo json_encode($json_array);
        break;

    case 'get_conginess_total':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_inv = "po_consignee_assign";
        if ($acc_year) {
            $columns = [
                "count(form_main_unique_id) AS po_count",
                "SUM(stock_qty) AS po_assign_count",
                "SUM(total_invoice_qty) AS stk_assign_count"

            ];
        } else {
            $columns = [
                "count(form_main_unique_id) AS po_count",
                "SUM(stock_qty) AS po_assign_count",
                "SUM(total_invoice_qty) AS stk_assign_count"
            ];
        }
        $table_details = [
            $table_inv,
            $columns
        ];

        // $where3 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where3 .= " acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where3 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where3 .= '';
        //     }
        // }
        $result = $pdo->select($table_details, $where3);
        // print_r($result);
        $res_array = $result->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['po_assign_count'] == '') {
                $po_assign_count = 0;
            } else {
                $po_assign_count = $value['po_assign_count'];
            }

            if ($value['stk_assign_count'] == '') {
                $stk_assign_count = 0;
            } else {
                $stk_assign_count = $value['stk_assign_count'];
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "po_assign_count" => $po_assign_count,
            "stk_assign_count" => $stk_assign_count
        ];

        echo json_encode($json_array);
        break;

    // invoice complete 
    case 'inv_complete':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        // $table_com = "invoice_summary_approved";
        // // $columns_4 = [
        // //     "po_count",
        // //     "invoice_count",
        // //     "invoice_value",
        // // ];
        // if ($acc_year) {
        //     $columns_4 = [
        //         "po_count",
        //         "invoice_count",
        //         "invoice_value",
        //     ];
        // } else {
        //     $columns_4 = [
        //         "SUM(po_count) AS po_count",
        //         "SUM(invoice_count) AS invoice_count",
        //         "SUM(invoice_value) AS invoice_value",
        //     ];
        // }


        $table_com = "invoice_creation_main";

        $columns_4 = [
            "count(distinct dc_number) as po_count",
            "sum(invoice_qty) as invoice_count",
            "sum(invoice_value) as invoice_value",
        ];


        $table_details_4 = [
            $table_com,
            $columns_4
        ];

        $where_4 = "is_delete= 0 and dc_number IS NOT  NULL "; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_4 .= " AND acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_4 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_4 .= '';
        //     }
        // }
        $result_values_4 = $pdo->select($table_details_4, $where_4);
        // print_r($result_values_4);
        $res_array = $result_values_4->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;


    // delivery pending
    case 'delivery_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        // // $table_dis = "view_dispatch_pending_count";
        // $table_dis = "invoice_summary_pending_dispatch";

        // // $columns_5 = [
        // //     "count(form_main_unique_id) As po_count",
        // //     "sum(invoice_count) AS invoice_count",
        // //     "SUM(invoice_value) AS invoice_value",

        // // ];
        // if ($acc_year) {
        //     $columns_5 = [
        //         "po_count",
        //         "invoice_count",
        //         "invoice_value",
        //     ];
        // } else {
        //     $columns_5 = [
        //         "SUM(po_count) AS po_count",
        //         "SUM(invoice_count) AS invoice_count",
        //         "SUM(invoice_value) AS invoice_value",
        //     ];
        // }


        $table_dis = "invoice_creation_main";



        $columns_5 = [
            "count(DISTINCT dc_number) AS po_count",
            "sum(invoice_qty) AS invoice_count",
            "sum(invoice_value) AS invoice_value",
        ];


        $table_details_5 = [
            $table_dis,
            $columns_5
        ];


        $where_5 = "is_delete = '0' and dispatch_status = '0' and material_qc = '1' and ac_team_verifiy_status = '1'"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_5 .= " AND acc_year = '$acc_year'";
        }

        $result_values_5 = $pdo->select($table_details_5, $where_5);
        $res_array = $result_values_5->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;



    // delivery transit
    case 'delivery_transit':
        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_dispatch = "dispatch_list dl JOIN invoice_creation_main icm ON dl.dc_number = icm.dc_number";

        $columns = [
            "COUNT(DISTINCT dl.dc_number) AS po_count",
            "SUM(icm.invoice_qty) AS invoice_count",
            "SUM(icm.invoice_value) AS invoice_value"
        ];

        $table_details = [
            $table_dispatch,
            $columns
        ];

        $where = "dl.is_delete = 0 AND dl.status = 1 AND icm.is_delete = 0";

        // Optional: add academic year condition if needed (based on invoice table or dispatch)
        if (!empty($acc_year)) {
            $where .= " AND icm.acc_year = '$acc_year'";
        }

        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where .= " AND dl.sess_user_type = '$session_user_type'";
        //     }
        // }

        $result_values = $pdo->select($table_details, $where);
        $res_array = $result_values->data;

        foreach ($res_array as $value) {
            $po_count = $value['po_count'];
            $invoice_count = $value['invoice_count'] == '' ? 0 : $value['invoice_count'];
            $invoice_value = $value['invoice_value'] == '' ? 0 : formatIndianNumber($value['invoice_value']);
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];

        echo json_encode($json_array);
        break;

    // $json_array = "";
    // $acc_year = $_POST['acc_year'];
    // $table_dis_com = "delivery_status_in_transit";
    // $columns_6 = [
    //     "SUM(po_count) As po_count",
    //     "Sum(invoice_count) AS invoice_count",
    //     "SUM(invoice_value) AS invoice_value",

    // ];
    // $table_details_6 = [
    //     $table_dis_com,
    //     $columns_6
    // ];

    // $where_6 = "1"; // Default always true condition

    // // Add acc_year condition if set
    // if (!empty($acc_year)) {
    //     $where_6 .= " AND acc_year = '$acc_year'";
    // }

    // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
    //     $session_user_type = $_SESSION['sess_user_type'];
    //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
    //         $where_6 .= " AND sess_user_type = '$session_user_type'";
    //     } else {
    //         $where_6 .= '';
    //     }
    // }
    // $result_values_6 = $pdo->select($table_details_6, $where_6);
    // $res_array = $result_values_6->data;
    // foreach ($res_array as $value) {

    //     $po_count = $value['po_count'];
    //     if ($value['invoice_count'] == '') {
    //         $invoice_count = 0;
    //     } else {
    //         $invoice_count = $value['invoice_count'];
    //     }


    //     if ($value['invoice_value'] == '') {
    //         $invoice_value = 0;
    //     } else {
    //         $invoice_value = formatIndianNumber($value['invoice_value']);
    //     }
    // }

    // $json_array = [
    //     "po_count" => $po_count,
    //     "invoice_value" => $invoice_value,
    //     "invoice_count" => $invoice_count,
    // ];


    // echo json_encode($json_array);
    // break;

    // ac team pending

    case 'ac_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_ac_team = "document_verification_accounts";
        if (!empty($acc_year)) {
            $columns_7 = [
                "po_count",
                "invoice_count",
                "invoice_value",

            ];
        } else {
            $columns_7 = [
                "sum(po_count) as po_count",
                "sum(invoice_count)as invoice_count",
                "sum(invoice_value) as invoice_value",

            ];
        }
        $table_details_7 = [
            $table_ac_team,
            $columns_7
        ];

        $where_7 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_7 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_7 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_7 .= '';
        //     }
        // }
        $result_values_7 = $pdo->select($table_details_7, $where_7);
        $res_array = $result_values_7->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }

            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;



    // install  pending

    case 'install_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        // $table_install = "installation_summary";
        // if (!empty($acc_year)) {
        //     $columns_8 = [
        //         "po_count",
        //         "invoice_count",
        //         "invoice_value",

        //     ];
        // } else {
        //     $columns_8 = [
        //         "sum(po_count) as po_count",
        //         "sum(invoice_count) as invoice_count",
        //         "sum(invoice_value)as invoice_value",

        //     ];
        // }

        $table_install = "view_installation_followups";
        $columns_8 = [
            "count(DISTINCT form_main_unique_id) as po_count",
            "count(DISTINCT dc_number) as dc_count",
            "count(DISTINCT invoice_no) as invoice_count",
            "sum(invoice_value) as invoice_value",

        ];

        $table_details_8 = [
            $table_install,
            $columns_8
        ];


        $where_8 = "installation_status IN(0, 5, 1, 4) AND STATUS = 3 AND vendor_bulk_status = 1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_8 .= " AND acc_year = '$acc_year'";
        }

        $result_values_8 = $pdo->select($table_details_8, $where_8);

        $res_array = $result_values_8->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }

            if ($value['dc_count'] == '') {
                $dc_count = 0;
            } else {
                $dc_count = $value['dc_count'];
            }

            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "dc_count" => $dc_count,

        ];


        echo json_encode($json_array);
        break;

    // doc pending


    case 'document_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_document = "installation_summary";
        if (!empty($acc_year)) {
            $columns_9 = [
                "doc_po_count As po_count",
                "doc_invoice_count AS invoice_count",
                "doc_invoice_value AS invoice_value",

            ];
        } else {
            $columns_9 = [
                "sum(doc_po_count) As po_count",
                "sum(doc_invoice_count) AS invoice_count",
                "sum(doc_invoice_value) AS invoice_value",

            ];
        }
        $table_details_9 = [
            $table_document,
            $columns_9
        ];

        $where_9 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_9 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_9 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_9 .= '';
        //     }
        // }
        $result_values_9 = $pdo->select($table_details_9, $where_9);


        $res_array = $result_values_9->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,

        ];


        echo json_encode($json_array);
        break;

    //     doc eng pending

    case 'document_eng_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_eng = "installation_summary";
        if (!empty($acc_year)) {
            $columns_10 = [
                "engg_po_count As po_count",
                "engg_invoice_count AS invoice_count",
                "engg_invoice_value AS invoice_value",

            ];
        } else {
            $columns_10 = [
                "sum(engg_po_count) As po_count",
                "sum(engg_invoice_count) AS invoice_count",
                "sum(engg_invoice_value) AS invoice_value",

            ];
        }
        $table_details_10 = [
            $table_eng,
            $columns_10
        ];
        $where_10 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_10 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_10 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_10 .= '';
        //     }
        // }
        $result_values_10 = $pdo->select($table_details_10, $where_10);


        $res_array = $result_values_10->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;

    case 'vendor_payment_details':

        $data = [];
        $json_array = "";

        $acc_year = $_POST['acc_year'];

        $table_vendor = "vendor_payment_count";
        // Query Variables
        // $columns_10 = [
        //     "get_outsource_engineer_name(vendor_id) AS name",
        //     "assign_dc_count",
        //     "assign_dc_value",
        //     "issue_dc_count",
        //     "issue_dc_value"
        // ];
        if ($acc_year) {
            $columns_10 = [
                "get_outsource_engineer_name(vendor_id) AS name",
                "assign_dc_count",
                "assign_dc_value",
                "issue_dc_count",
                "issue_dc_value"
            ];
        } else {
            $columns_10 = [
                "get_outsource_engineer_name(vendor_id) AS name",
                "SUM(assign_dc_count) AS assign_dc_count",
                "SUM(assign_dc_value) AS assign_dc_value",
                "SUM(issue_dc_count) AS issue_dc_count",
                "SUM(issue_dc_value) AS issue_dc_value"
            ];
        }
        $table_details = [
            $table_vendor,
            $columns_10
        ];
        if ($acc_year) {
            $where_10 = "acc_year = '$acc_year'";
        }
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $group_by = "vendor_id";

        $result = $pdo->select($table_details, $where_10, '', '', '', $sql_function, $group_by);
        $screen_id_val = $_POST['screen_id_val'];

        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";

        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;

        $action_ids = [];

        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $name = $value['name'];
                $assign_dc_count = $value['assign_dc_count'];
                $assign_dc_value = formatIndianNumber($value['assign_dc_value']);
                $issue_dc_count = $value['issue_dc_count'];
                $issue_dc_value = formatIndianNumber($value['issue_dc_value']);

                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;


    case 'snr_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_snr = "installation_summary";
        if (!empty($acc_year)) {
            $columns_11 = [
                "snr_po_count As po_count",
                "snr_install_count AS install_count",
                "snr_invoice_value AS invoice_value",

            ];
        } else {
            $columns_11 = [
                "sum(snr_po_count) As po_count",
                "sum(snr_install_count) AS install_count",
                "sum(snr_invoice_value) AS invoice_value",

            ];
        }
        $table_details_11 = [
            $table_snr,
            $columns_11
        ];


        $where_11 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_11 .= " AND acc_year = '$acc_year'";
        }

        $result_values_11 = $pdo->select($table_details_11, $where_11);

        $res_array = $result_values_11->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['install_count'] == '') {
                $install_count = 0;
            } else {
                $install_count = $value['install_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "install_count" => $install_count,

        ];


        echo json_encode($json_array);
        break;

    //     doc eng pending

    case 'elcot_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_elcot = "opera_doc_table";
        if (!empty($acc_year)) {
            $columns_12 = [
                "po_count",
                "invoice_count",
                "invoice_value",
                "dc_count",

            ];
        } else {
            $columns_12 = [
                "sum(po_count) as po_count",
                "sum(invoice_count) as invoice_count",
                "sum(invoice_value) as invoice_value",
                "sum(dc_count) as dc_count",

            ];
        }
        $table_details_12 = [
            $table_elcot,
            $columns_12
        ];

        $where_12 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_12 .= " AND acc_year = '$acc_year'";
        }
        // if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
        //     $session_user_type = $_SESSION['sess_user_type'];
        //     if ($session_user_type !== 'Admin' && $session_user_type !== 'SuperAdmin') {
        //         $where_12 .= " AND sess_user_type = '$session_user_type'";
        //     } else {
        //         $where_12 .= '';
        //     }
        // }
        $result_values_12 = $pdo->select($table_details_12, $where_12);

        $res_array = $result_values_12->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }
            if ($value['dc_count'] == '') {
                $dc_count = 0;
            } else {
                $dc_count = $value['dc_count'];
            }

            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "dc_count" => $dc_count,
        ];


        echo json_encode($json_array);
        break;

    case 'sign_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        // $table_sign_doc = "opera_sign_table";
        // if (!empty($acc_year)) {
        //     $columns_13 = [
        //         "sign_po_count As po_count",
        //         "sign_invoice_count AS invoice_count",
        //         "sign_invoice_value AS invoice_value",
        //         "sign_dc_count"

        //     ];
        // } else {
        //     $columns_13 = [
        //         "sum(sign_po_count) As po_count",
        //         "sum(sign_invoice_count) AS invoice_count",
        //         "sum(sign_invoice_value) AS invoice_value",
        //         "sum(sign_dc_count) as sign_dc_count"

        //     ];
        // }


        $table_sign_doc = "dc_num_status AS dcs 
LEFT JOIN (
    SELECT dc_number, SUM(invoice_value) AS total_invoice_value
    FROM invoice_creation_main
    WHERE is_delete = 0
    GROUP BY dc_number
) AS icm_sum ON dcs.dc_number = icm_sum.dc_number";

        $columns_13 = [
            "COUNT(DISTINCT dcs.form_main_unique_id) AS po_count",
            "COUNT(DISTINCT dcs.invoice_no) AS invoice_count",
            "IFNULL(SUM(icm_sum.total_invoice_value), 0) AS invoice_value",
            "COUNT(DISTINCT dcs.dc_number) AS sign_dc_count"
        ];

        $table_details_13 = [
            $table_sign_doc,
            $columns_13
        ];

        $where_13 = "dcs.invoice_no IS NOT NULL AND dcs.po_unique_id IS NOT NULL AND dcs.signed_complete_status IS NULL";

        // Add acc_year condition if set
        // if (!empty($acc_year)) {
        //     $where_13 .= " AND acc_year = '$acc_year'";
        // }

        $result_values_13 = $pdo->select($table_details_13, $where_13);
        // print_r($result_values_13);

        $res_array = $result_values_13->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }

            if ($value['sign_dc_count'] == '') {
                $sign_dc_count = 0;
            } else {
                $sign_dc_count = $value['sign_dc_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "sign_dc_count" => $sign_dc_count,
        ];


        echo json_encode($json_array);
        break;


    case 'bg_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_bg = "sign_doc_summary";
        if (!empty($acc_year)) {
            $columns_14 = [
                "po_count",
                "invoice_count",
                "invoice_value",
                "dc_count",

            ];
        } else {
            $columns_14 = [
                "sum(po_count) as po_count",
                "sum(invoice_count) as invoice_count",
                "sum(invoice_value) as invoice_value",
                "sum(dc_count) as dc_count",

            ];
        }
        $table_details_14 = [
            $table_bg,
            $columns_14
        ];
        $where_14 = "1"; // Default always true condition
        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_14 .= " AND acc_year = '$acc_year'";
        }

        $result_values_14 = $pdo->select($table_details_14, $where_14);

        //    print_r($result_values_14);


        $res_array = $result_values_14->data;
        foreach ($res_array as $value) {
            if ($value['po_count'] == '') {
                $po_count = 0;
            } else {
                $po_count = $value['po_count'];
            }
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }
            if ($value['dc_count'] == '') {
                $dc_count = 0;
            } else {
                $dc_count = $value['dc_count'];
            }

            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "dc_count" => $dc_count,

        ];


        echo json_encode($json_array);
        break;


    case 'entry_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];
        $table_bill_pending = "bill_generation_summary";
        if (!empty($acc_year)) {
            $columns_16 = [
                "po_count",
                "invoice_count",
                "invoice_value",
                "dc_count",
            ];
        } else {
            $columns_16 = [
                "sum(po_count) as po_count",
                "sum(invoice_count) as invoice_count",
                "sum(invoice_value) as invoice_value",
                "sum(dc_count) as dc_count",
            ];
        }
        $table_details_16 = [
            $table_bill_pending,
            $columns_16
        ];
        $where_16 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_16 .= " AND acc_year = '$acc_year'";
        }

        $result_values_16 = $pdo->select($table_details_16, $where_16);


        $res_array = $result_values_16->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }
            if ($value['dc_count'] == '') {
                $dc_count = 0;
            } else {
                $dc_count = $value['dc_count'];
            }

            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "dc_count" => $dc_count,
        ];


        echo json_encode($json_array);
        break;


    case 'bill_sub_pending':
        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_bill_submission_pending = "bill_submission_pending_summary";
        if (!empty($acc_year)) {

            $columns_25 = [
                "po_count",
                "invoice_count",
                "dc_count",
                "invoice_value",

            ];
        } else {
            $columns_25 = [
                "sum(po_count) as po_count",
                "sum(invoice_count) as invoice_count",
                "sum(dc_count) as dc_count",
                "sum(invoice_value) as invoice_value",

            ];
        }
        $table_details_25 = [
            $table_bill_submission_pending,
            $columns_25
        ];
        $where_25 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_25 .= " AND acc_year = '$acc_year'";
        }
        $result_values_25 = $pdo->select($table_details_25, $where_25);
        $res_array = $result_values_25->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }

            if ($value['dc_count'] == '') {
                $dc_count = 0;
            } else {
                $dc_count = $value['dc_count'];
            }
            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
            "dc_count" => $dc_count,


        ];


        echo json_encode($json_array);
        break;

    case 'payment_pending':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_payment_pending = "bill_submitted_payment_pending";
        $columns_17 = [
            "count(bill_form_unique_id) As po_count",
            "sum(invoice_count) AS invoice_count",
            "SUM(invoice_value) AS invoice_value",

        ];
        $table_details_17 = [
            $table_payment_pending,
            $columns_17
        ];


        $where_17 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_17 .= " AND acc_year = '$acc_year'";
        }

        $result_values_17 = $pdo->select($table_details_17, $where_17);


        $res_array = $result_values_17->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }
        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];


        echo json_encode($json_array);
        break;

    case 'payment_receive':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_payment_rec = "view_payment_received_count";
        $columns_18 = [
            "count(bill_form_unique_id) As po_count",
            "sum(invoice_count) AS invoice_count",
            "SUM(invoice_value) AS invoice_value",

        ];
        $table_details_18 = [
            $table_payment_rec,
            $columns_18
        ];
        $where_18 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_18 .= " AND acc_year = '$acc_year'";
        }

        $result_values_18 = $pdo->select($table_details_18, $where_18);
        $res_array = $result_values_18->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }


            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,
        ];
        echo json_encode($json_array);
        break;



    // ld value
    case 'ld_detail':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_ld = 'view_ld_value_count';
        $columns_19 = [
            "count(bill_form_unique_id) As po_count",
            "sum(ld_value) AS ld_value",
            "SUM(invoice_count) AS invoice_count",

        ];
        $table_details_19 = [
            $table_ld,
            $columns_19
        ];

        $where_19 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_19 .= " AND acc_year = '$acc_year'";
        }

        $result_values_19 = $pdo->select($table_details_19, $where_19);
        $res_array = $result_values_19->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }

            if ($value['ld_value'] == '') {
                $ld_value = 0;
            } else {
                $ld_value = formatIndianNumber($value['ld_value']);
            }
        }

        $table_total_ld = 'view_total_ld_invoice_count';
        $columns_21 = [
            "SUM(total_invoice_count) AS total_invoice_count",
            "acc_year",

        ];
        $table_details_21 = [
            $table_total_ld,
            $columns_21
        ];
        $where_21 = "acc_year = '" . $acc_year . "'";
        $result_values_21 = $pdo->select($table_details_21, $where_21);
        $res_array_21 = $result_values_21->data;
        foreach ($res_array_21 as $value_21) {
            $total_invoice_count = $value_21['total_invoice_count'];
        }

        $json_array = [
            "po_count" => $po_count,
            "ld_value" => $ld_value,
            "invoice_count" => $invoice_count,
            "total_invoice_count" => $total_invoice_count,
        ];
        echo json_encode($json_array);
        break;

    case 'sd_claim':

        $json_array = "";
        $acc_year = $_POST['acc_year'];

        $table_sd = "view_sd_claim_pending";
        $columns_20 = [
            "count(bill_form_unique_id) As po_count",
            "sum(invoice_count) AS invoice_count",
            "SUM(invoice_value) AS invoice_value",

        ];
        $table_details_20 = [
            $table_sd,
            $columns_20
        ];

        $where_20 = "1"; // Default always true condition

        // Add acc_year condition if set
        if (!empty($acc_year)) {
            $where_20 .= " AND acc_year = '$acc_year'";
        }

        $result_values_20 = $pdo->select($table_details_20, $where_20);


        $res_array = $result_values_20->data;
        foreach ($res_array as $value) {

            $po_count = $value['po_count'];

            $invoice_count = $value['invoice_count'];
            if ($value['invoice_count'] == '') {
                $invoice_count = 0;
            } else {
                $invoice_count = $value['invoice_count'];
            }
            if ($value['invoice_value'] == '') {
                $invoice_value = 0;
            } else {
                $invoice_value = formatIndianNumber($value['invoice_value']);
            }

        }

        $json_array = [
            "po_count" => $po_count,
            "invoice_value" => $invoice_value,
            "invoice_count" => $invoice_count,


        ];
        echo json_encode($json_array);
        break;

    default;
        break;
}



function formatIndianNumbers1($num) {
    $num = number_format((float)$num, 2, '.', ''); // ensures 2 decimals
    $parts = explode('.', $num);
    $lastThree = substr($parts[0], -3);
    $restUnits = substr($parts[0], 0, -3);
    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
    }
    return $restUnits . ($restUnits == '' ? '' : ',') . $lastThree . '.' . $parts[1];
}


?>
