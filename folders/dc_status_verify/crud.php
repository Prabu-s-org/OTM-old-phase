<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "dc_num_status";

// Include DB file and Common Functions
include '../../config/dbconfig.php';

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

switch ($action) {
    case 'createupdate':

        $district_name = $_POST["district_name"];
        $state_name = $_POST["state_name"];
        $city_name = $_POST["city_name"];
        $is_active = $_POST["is_active"];
        $unique_id = $_POST["unique_id"];

        $update_where = "";

        $columns = [
            "district_name" => $district_name,
            "state_name" => $state_name,
            "city_name" => $city_name,
            "is_active" => $is_active,
            "unique_id" => unique_id($prefix)
        ];
        $table_details = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND unique_id !="' . $unique_id . '" AND city_name ="' . $city_name . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';

        }
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {


            // Update Begins
            if ($unique_id) {

                unset($columns['unique_id']);

                $update_where = [
                    "unique_id" => $unique_id
                ];

                $action_obj = $pdo->update($table, $columns, $update_where);



                // Update Ends
            } else {
                // Insert Begins

                $action_obj = $pdo->insert($table, $columns);
                // Insert Ends
            }

            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = "";
                $sql = $action_obj->sql;

                if ($unique_id) {
                    $msg = "update";
                } else {
                    $msg = "create";
                }
            } else {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = $action_obj->error;
                $sql = $action_obj->sql;
                $msg = "error";
            }
        }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",
            "form_main_unique_id",
            "dc_number",
            "doc_approval_sts",
            "ac_team_verifiy_status",
            "material_qc",
            "dispatch_status",
            "delivery_status",
            "dc_ir_dispatch_sts",
            "vendor_bulk_sts",
            "vendor_team_sts",
            "installation_status",
            "signed_doc_status",
            "unique_id",
            "invoice_no",
            "dc_operation_date",
            "dc_app_date",
            "dc_mat_date",
            "dc_dispatch_date",
            "vend_allc_date",
            "dc_install_date",
            "dc_sign_doc_date",
            "dc_complete_status",
            "dc_required"
        ];
        $table_details = [
            $table,
            $columns
        ];

        // $where = "";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $po_no = $_POST['po_no'];
        $invoice_no = $_POST['invoice_no'];

        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        if ($po_no) {
            $where .= "form_main_unique_id = '$po_no' ";
        }

        if ($invoice_no) {
            $where .= " AND invoice_no = '$invoice_no' ";
        }

        $where .= " AND dc_number IS NOT NULL AND invoice_no IS NOT NULL";

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['usertype'];

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
                $value['s_no'] = $sno + 1;

                $dc_number = $value['dc_number'];

                $invoice = $value['invoice_no'];

                $unique_id = $value['unique_id'];

                $dc_completed_status = $value['dc_complete_status'];

                // $dc_operation_date = date('d-m-Y', strtotime($value['dc_operation_date']));
                // $dc_app_date = date('d-m-Y', strtotime($value['dc_app_date']));
                // $dc_mat_date = date('d-m-Y', strtotime($value['dc_mat_date']));
                // $dc_dispatch_date = date('d-m-Y', strtotime($value['dc_dispatch_date']));
                // $vend_allc_date = date('d-m-Y', strtotime($value['vend_allc_date']));
                // $dc_install_date = date('d-m-Y', strtotime($value['dc_install_date']));
                // $dc_sign_doc_date = date('d-m-Y', strtotime($value['dc_sign_doc_date']));

                $dc_operation_date = !empty($value['dc_operation_date']) ? date('d-m-Y', strtotime($value['dc_operation_date'])) : null;
                $dc_app_date = !empty($value['dc_app_date']) ? date('d-m-Y', strtotime($value['dc_app_date'])) : null;
                $dc_mat_date = !empty($value['dc_mat_date']) ? date('d-m-Y', strtotime($value['dc_mat_date'])) : null;
                $dc_dispatch_date = !empty($value['dc_dispatch_date']) ? date('d-m-Y', strtotime($value['dc_dispatch_date'])) : null;
                $vend_allc_date = !empty($value['vend_allc_date']) ? date('d-m-Y', strtotime($value['vend_allc_date'])) : null;
                $dc_install_date = !empty($value['dc_install_date']) ? date('d-m-Y', strtotime($value['dc_install_date'])) : null;
                $dc_sign_doc_date = !empty($value['dc_sign_doc_date']) ? date('d-m-Y', strtotime($value['dc_sign_doc_date'])) : null;

                // print_r($unique_id);die();

                // Convert status values to icons
                // $doc_approval_icon = $value['doc_approval_sts'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                $doc_approval_icon = $value['doc_approval_sts'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_operation_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                $ac_team_verify_icon = $value['ac_team_verifiy_status'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_app_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                $material_qc_icon = $value['material_qc'] == 1
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_mat_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                if ($value['dispatch_status'] == 1 && $value['delivery_status'] == 2) {
                    $dispatch_status_icon = '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_dispatch_date . '</small></div>';
                } else {
                    $dispatch_status_icon = '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                }

                // $dispatch_status_icon = $value['dispatch_status'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                if ($value['vendor_bulk_sts'] == 1 || $value['vendor_team_sts'] == 2) {
                    $vendor_icon = '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $vend_allc_date . '</small></div>';
                } else {
                    $vendor_icon = '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                }

                // $vendor_bulk_icon = $value['vendor_bulk_sts'] == 1
                //     ? '<i class="fas fa-check-circle" style="color:green;"></i>'
                //     : '<i class="fas fa-times-circle" style="color:red;"></i>';

                // $installation_icon = $value['installation_status'] == 2
                //     ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_install_date . '</small></div>'
                //     : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';


                if (($value['installation_status'] == 2) && ($value['dc_required'] == 0))  {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>IR (Completed)</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } 
                elseif(($value['installation_status'] == 2) && ($value['dc_required'] == 1)){
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>DC (Completed)</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                }
                elseif ($value['installation_status'] == 5) {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>DC</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } elseif ($value['installation_status'] == 1) {
                    $installation_icon = '<div class="text-center">
                                            <i class="fas fa-check-circle" style="color:green;"></i><br>
                                            <small>SNR</small><br>
                                            <small>' . $dc_install_date . '</small>
                                        </div>';
                } else {
                    $installation_icon = '<div class="text-center">
                        <i class="fas fa-times-circle" style="color:red;"></i>
                    </div>';
                }


                $dc_ir_icon = $value['dc_ir_dispatch_sts'] == 3
                    ? '<div class="text-center"><i class="fas fa-check-circle" style="color:green;"></i><br><small>' . $dc_install_date . '</small></div>'
                    : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';

                if (($dc_completed_status == '0') && ($value['signed_doc_status'] == 0)) {
                    $signed_doc_icon = $value['signed_doc_status'] == 2
                        ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><button type="button" class="btn btn-success" onclick="dc_complete(\'' . htmlspecialchars($dc_number) . '\')">Complete</button>'
                        : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                } elseif (($dc_completed_status == '0') && ($value['signed_doc_status'] == 2)) {
                    $signed_doc_icon = $value['signed_doc_status'] == 2
                        ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><button type="button" class="btn btn-success" onclick="dc_complete(\'' . htmlspecialchars($dc_number) . '\')">Complete</button>'
                        : '<div class="text-center"><i class="fas fa-times-circle" style="color:red;"></i></div>';
                } elseif (($dc_completed_status == '1') && ($value['signed_doc_status'] == 2)) {
                    $signed_doc_icon = $value['signed_doc_status'] == 2
                        ? '<i class="fas fa-check-circle" style="color:green;"></i> <br><small>' . $dc_sign_doc_date . '</small> <br><b>Completed</b>'
                        : '';
                }



                $data[] = [
                    "s_no" => $value['s_no'],
                    "invoice_no" => $value['invoice_no'],
                    "dc_number" => $value['dc_number'],
                    "doc_approval_sts" => $doc_approval_icon,
                    "ac_team_verifiy_status" => $ac_team_verify_icon,
                    "material_qc" => $material_qc_icon,
                    "dispatch_status" => $dispatch_status_icon,
                    "vendor_icon" => $vendor_icon,
                    "installation_status" => $installation_icon,
                    "dc_ir_dispatch_sts" => $dc_ir_icon,
                    "signed_doc_status" => $signed_doc_icon,
                ];
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

    //     case 'cardData':
//         $po_no = $_POST['po_no'];
//         $invoice_no = $_POST['invoice_no'];

    //         $table = "dc_num_status";
//         $columns = [
//             "(SELECT po_num from po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
//             "(SELECT invoice_no from invoice_creation_main WHERE invoice_creation_main.unique_id = dc_num_status.invoice_unique_id) AS invoice_no"
//         ];

    //         $select_where = '';

    //         if ($po_no) {
//             $select_where = "form_main_unique_id = '" . $po_no . "'";
//         }
//         if ($invoice_no) {
//             $select_where = "invoice_unique_id = '" . $invoice_no . "'";
//         }

    //         // $select_where .= "form_main_unique_id='" . $po_no . "' AND invoice_unique_id='" . $invoice_no . "'";

    //         $table_details = [
//             $table,
//             $columns
//         ];

    //         $result = $pdo->select($table_details, $select_where);

    //         if ($result->status) {

    //             $result = $result->data;
//             // $action_unique_ids = [];
// // print_r($result);die();
//             foreach ($result as $value) {
//                 // if (isset($item['action_unique_id'])) {
//                 //     $action_unique_ids[] = $item['po_no'];
//                 // }
//                 $po_no = $value['po_no'];
//                 $invoice_no = $value['invoice_no'];

    //                 $data[] = [
//                     "po_no" => $value['po_no'],
//                     "invoice_no" => $value['invoice_no'],

    //                 ];
//             }

    //         }


    //         $json_array = [

    //             "data" => $data,

    //         ];

    //         echo json_encode($json_array);

    //         break;


    case 'cardData':
        $po_no = $_POST['po_no'];
        $invoice_no = $_POST['invoice_no'];

        $table = "dc_num_status";
        // $columns = [
        //     "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
        //     "(SELECT invoice_no FROM invoice_creation_main WHERE invoice_creation_main.unique_id = dc_num_status.invoice_unique_id) AS invoice_no"
        // ];

        // $columns = [
        //     "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
        //     "(SELECT GROUP_CONCAT(invoice_no SEPARATOR ', ') 
        //         FROM invoice_creation_main 
        //         WHERE invoice_creation_main.po_num = 
        //             (SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id)
        //         ) AS invoice_no",

        //      "invoice_no as invoice_num"
        // ];

        if (!empty($invoice_no)) {
            // If invoice_no is provided, use it directly
            $columns = [
                "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
                "'$invoice_no' AS invoice_no",  // inject the value as a static string column
                "invoice_no AS invoice_num"
            ];
        } else {
            // If not provided, use GROUP_CONCAT from invoice_creation_main
            $columns = [
                "(SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id) AS po_no",
                "(SELECT GROUP_CONCAT(DISTINCT invoice_no SEPARATOR ', ') 
                    FROM invoice_creation_main 
                    WHERE invoice_creation_main.po_num = 
                        (SELECT po_num FROM po_form WHERE po_form.unique_id = dc_num_status.form_main_unique_id)
                ) AS invoice_no",
                "invoice_no AS invoice_num"
            ];
        }

        $select_where = [];

        if ($po_no) {
            $select_where[] = "form_main_unique_id = '" . $po_no . "'";
        }
        if ($invoice_no) {
            $select_where[] = "invoice_no = '" . $invoice_no . "'";
        }

        // $group_by = " invoice_num";
        $where_clause = implode(" AND ", $select_where); // Combine both if present

        $table_details = [$table, $columns];
        $result = $pdo->select($table_details, $where_clause, "", "", "", "");

        // print_r($result);

        if ($result->status && !empty($result->data)) {
            $row = $result->data[0]; // assuming only one row
            echo json_encode([
                "po_no" => $row['po_no'] ?? '',
                "invoice_no" => $row['invoice_no'] ?? ''
            ]);
        } else {
            echo json_encode([
                "po_no" => '',
                "invoice_no" => ''
            ]);
        }

        break;



    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;


    case 'dc_complete':

        $dc_num = $_POST['dc_num'];

        $invoice_no = $_POST['invoice_num'];

        $unique_id = $_POST['unique_id'];

        $table = "dc_num_status";

        $columns = [

            "dc_complete_status" => 1
        ];

        $where = "dc_number = '$dc_num'";


        $action_obj = $pdo->update($table, $columns, $where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "success_delete";

        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }

        $json_array = [

            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;



    case 'delete':

        $unique_id = $_POST['unique_id'];

        $columns = [
            "is_delete" => 1
        ];

        $update_where = [
            "unique_id" => $unique_id
        ];

        $action_obj = $pdo->update($table, $columns, $update_where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "success_delete";

        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }

        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);
        break;

    case 'district_type_option':

        $state_name = $_POST['state_name'];

        $district_type_options = district_option("", $state_name);

        $district_type_options = select_option($district_type_options, "Select District");

        echo $district_type_options;

        break;


    case 'get_po_no':

        $po_no = $_POST['po_no'];


        $po_no_options = list_of_invoice('', $po_no);

        $invoice_no_options = invoice_select_option($po_no_options, "Select Invoice No");

        echo $invoice_no_options;

        break;

    default:
        break;
}

?>
