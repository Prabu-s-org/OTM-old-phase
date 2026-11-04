<?php
require_once __DIR__ . '/../config/env.php';
// header('Content-Type: application/json');
// Get folder Name From Currnent Url 
// $folder_name        = explode("/", $_SERVER['PHP_SELF']);
// $folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "view_installation_followups";
$table_install = "view_installation_followups1";
$table_sub = "installation_details";
$table_sub_dc = "dc_ir_doc_dispatch_details";
$table_inst_sublist = "installation_details_sublist";
// $table_inv="view_invoice_creation_main";
$table_inv = "invoice_creation_main";


// Include DB file and Common Functions
include 'config/dbconfig.php';

// $fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);


// $fileUploadPath = $fileUploadConfig->get("upload_folder");

// // Create Folder in root->uploads->(this_folder_name) Before using this file upload
// $fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

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

// $exe_unique = unique_id($prefix);
switch ($action) {


    case 'fetchlist':
        $data = [];
        $columns = ["'' as s_no", "po_num", "po_date"];
        $table_details = [$table, $columns];

        $result = $pdo->select($table_details);
        $total_records = total_records();

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno++; // Assign serial number
                $data[] = $value; // Keep associative array
            }

            $json_array = [
                "status" => true,  // Use `status` instead of `success`
                "draw" => intval($_POST['draw'] ?? 1),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data
            ];
        } else {
            $json_array = ["status" => false, "message" => "No data found"];
        }

        echo json_encode($json_array);
        exit;

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



    // dc_id dispatch details get
    case 'dc_ir_dispatch_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        $dc_delivery_status = $_POST['dc_delivery_status'];
        $con_district = $_POST['con_district'];
        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as  s_no",

            "po_num",

            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = view_installation_followups1.ledger_name) AS ledger_name",

            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups1.con_district) AS con_district",

            "con_address",
            "invoice_no",

            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "invoice_value",

            "(select staff_name from view_eng_data WHERE view_eng_data.eng_unique_id=$table_install.engineer_name) AS engineer_name",
            "(select installation_com_date from installation_details where invoice_no = view_installation_followups1.invoice_no AND is_delete=0  group by invoice_no ) AS installation_com_date",

            "dc_delivery_status",
            "consignee_unique_id",
            "form_main_unique_id",
            "con_pincode",
            "po_unique_id",
            "documents_type",
            "documents_type1",
            "documents_type2",
            "invoice_auto_id",



        ];
        $table_details = [
            $table_install,
            $columns
        ];


        $where = "documents_type!='0'";


        if ($_POST['from_date'] == '') {
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }



        if ($dc_delivery_status == '') {
            if ($opt1 == '9') {
                // Filter by PO Date
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));

                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') 
                  AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

                if ($con_district != '') {
                    $where .= " AND con_district = '" . $con_district . "'";
                }
            } else if ($opt1 == '10') {
                // Filter by Invoice Date
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";

                if ($con_district != '') {
                    $where .= " AND con_district = '" . $con_district . "'";
                }
            }
        } else {
            if ($opt1 == '9') {
                // Filter by PO Date and Installation Status
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));

                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') 
                  AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y') 
                  AND dc_delivery_status = '" . $dc_delivery_status . "'";

                if ($con_district != '') {
                    $where .= " AND con_district = '" . $con_district . "'";
                }
            } else if ($opt1 == '10') {
                // Filter by Invoice Date and Installation Status
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' 
                  AND dc_delivery_status = '" . $dc_delivery_status . "'";

                if ($con_district != '') {
                    $where .= " AND con_district = '" . $con_district . "'";
                }
            }
        }



        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 

        $order_by = datatable_sorting_ins2($order_column, $order_dir, $columns);
        $order_by = " 
  CASE 
    WHEN dc_delivery_status = '0' THEN 1
    WHEN dc_delivery_status = '5' THEN 2
    WHEN dc_delivery_status = '1' THEN 3
    WHEN dc_delivery_status = '3' THEN 4
    ELSE 5
  END $order_dir
";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
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
                // $value['po_unique_id'] = $value['po_num'];
                $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];

                $dc_delivery_status = $value['dc_delivery_status'];


                $dc_delivery_status = $value['dc_delivery_status'];
                if ($value['dc_delivery_status'] == 0) {
                    $value['dc_delivery_status'] = 'Pending';
                } else if ($value['dc_delivery_status'] == 5) {
                    $value['dc_delivery_status'] = 'partial Completed';
                } else if ($value['dc_delivery_status'] == 1) {
                    $value['dc_delivery_status'] = 'SNR';
                } else if ($value['dc_delivery_status'] == 3) {
                    $value['dc_delivery_status'] = 'Completed';
                }


                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                $orgDate1 = $value['installation_com_date'];
                if ($orgDate1 != '') {
                    $value['installation_com_date'] = date("d-m-Y", strtotime($orgDate1));
                } else {
                    $value['installation_com_date'] = '';
                }
                $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' ";


                $table_1 = "dc_ir_doc_dispatch_details";

                $columns_2 = [
                    'COUNT(invoice_no) AS count',
                    "dc_dispatch_mode",
                    "ir_dispatch_mode",
                    "snr_dispatch_mode",
                    "(select dc_required from installation_details where po_form_unique_id=$table_1.po_form_unique_id )as dc_required",
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                $data_st = $result_values_12->data;

                $invoice_no = $value['invoice_no'];





                $btn_update = btn_update_install($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                $btn_view = btn_view_ins_dc_ir($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    if ($dc_delivery_status == '3') {
                        $value['consignee_unique_id'] = $btn_view;
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['consignee_unique_id'] = $btn_update;
                        } else {
                            $value['consignee_unique_id'] = '';
                        }
                    }

                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {


                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['consignee_unique_id'] = $btn_update;
                    } else {
                        $value['consignee_unique_id'] = '';
                    }
                }




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

    // 2tab

    case 'dc_ir_add_update':

        $dc_required = $_POST['dc_required   '];
        $po_form_unique_id = $_POST['po_form_unique_id'];
        $po_num = $_POST['po_num'];
        $po_auto_id = $_POST['po_auto_id'];
        $po_date = $_POST['po_date'];
        $consignee_id = $_POST['consignee_id'];
        $invoice_auto_id = $_POST['invoice_auto_id'];
        $dc_required = $_POST['dc_required'];
        $invoice_no = $_POST['invoice_no'];
        $invoice_date = $_POST['invoice_date'];
        $dc_dispatch_mode = $_POST['dc_dispatch_mode'];
        $dc_pod_no = $_POST['dc_pod_no'];
        $dc_pod_date = $_POST['dc_pod_date'];
        $ir_dispatch_mode = $_POST['ir_dispatch_mode'];
        $name_of_courier = $_POST['name_of_courier'];
        $ins_name_of_courier = $_POST['ins_name_of_courier'];
        $ir_pod_no = $_POST['ir_pod_no'];
        $ir_pod_date = $_POST['ir_pod_date'];
        $snr_dispatch_mode = $_POST['snr_dispatch_mode'];
        $snr_name_courier = $_POST['snr_name_courier'];
        $snr_pod_no = $_POST['snr_pod_no'];
        $snr_pod_date = $_POST['snr_pod_date'];

        $unique_id = $_POST['unique_id'];
        $without_snr = $_POST['without_snr'];


        $update_where = '';
        // print_r( 'hii'.$con_con_address );
        $columns = [
            'po_form_unique_id' => $po_form_unique_id,
            'po_num' => $po_num,
            'po_auto_id' => $po_auto_id,
            'po_date' => $po_date,
            'consignee_unique_id' => $consignee_id,
            'invoice_auto_id' => $invoice_auto_id,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'dc_dispatch_mode' => $dc_dispatch_mode,
            'name_of_courier' => $name_of_courier,
            'dc_pod_no' => $dc_pod_no,
            'dc_pod_date' => $dc_pod_date,
            'ir_dispatch_mode' => $ir_dispatch_mode,
            'ins_name_of_courier' => $ins_name_of_courier,
            'ir_pod_no' => $ir_pod_no,
            'ir_pod_date' => $ir_pod_date,
            'snr_dispatch_mode' => $snr_dispatch_mode,
            'snr_name_courier' => $snr_name_courier,
            'snr_pod_no' => $snr_pod_no,
            'snr_pod_date' => $snr_pod_date,
            'unique_id' => unique_id($prefix)
        ];
        $table_details = [
            $table_sub_dc,
            [
                'COUNT(invoice_no) AS count'
            ]
        ];
        $select_where = 'is_delete = 0 AND invoice_no ="' . $invoice_no . '"';
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


        // new change
        if ($dc_dispatch_mode != '' && $ir_dispatch_mode != '' && $snr_dispatch_mode == '') {
            $columns_2 = [
                "dc_delivery_status" => 3,
                "without_snr" => $without_snr
            ];

            $update_where_2 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_2 = $pdo->update($table_sub, $columns_2, $update_where_2);
        }
        // NEW CHANES

        if ($dc_dispatch_mode != '' && $snr_dispatch_mode == '' && $ir_dispatch_mode == '' && $dc_required != 'on') {


            $columns_dc = [
                "dc_delivery_status" => 5,
            ];

            $update_where_dc = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_6 = $pdo->update($table_sub, $columns_dc, $update_where_dc);
        }

        if ($dc_dispatch_mode != '' && $ir_dispatch_mode != '' && $snr_dispatch_mode != '') {
            $columns_new = [
                "dc_delivery_status" => 3,
            ];

            $update_where_new = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_new = $pdo->update($table_sub, $columns_new, $update_where_new);
        }
        if ($dc_dispatch_mode != '' && $dc_required == 'on') {
            // ECHO "HI";
            $columns_3 = [
                "dc_delivery_status" => 3,
            ];

            $update_where_6 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_6 = $pdo->update($table_sub, $columns_3, $update_where_6);
        }
        // eng call new change

        if ($dc_dispatch_mode != '' && $snr_dispatch_mode != '' && $ir_dispatch_mode == '') {

            $columns_7 = [
                "dc_delivery_status" => 1,
            ];

            $update_where_7 = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_7 = $pdo->update($table_sub, $columns_7, $update_where_7);
        }


        // new change skip snr==================================
        $table_install_1tab = "installation_details";
        if ($without_snr == 'on') {

            $columns_ins1tab = [
                "documents_type2" => 0,
                "snr_rec_status" => "",
                "snr_cus_signed_date" => "",
                "snr_file" => "",
                "snr_original_name" => "",


            ];

            $update_where_1tab = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '"';
            $action_obj_1tab = $pdo->update($table_install_1tab, $columns_ins1tab, $update_where_1tab);


            $table_install_2tab = "installation_details_sublist";
            $columns_ins2tab = [
                "is_delete" => "1",
            ];

            $update_where_2tab = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '" AND documents_type1!="IR"';
            $action_obj_2tab = $pdo->update($table_install_2tab, $columns_ins2tab, $update_where_2tab);

            $columns_ins21tab = [
                "snr_rec_status" => "",
                "snr_cus_signed_date" => "",
                "snr_file" => "",
                "snr_original_name" => "",
                "documents_type2" => "0",
            ];
            $update_where_21tab = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_id . '" AND invoice_no="' . $invoice_no . '" AND documents_type1="IR"';
            $action_obj_21tab = $pdo->update($table_install_2tab, $columns_ins21tab, $update_where_21tab);

        }

        // ==============================================end=============================================

        if ($data[0]['count'] != 0) {
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where = [
                    'unique_id' => $unique_id
                ];
                $action_obj = $pdo->update($table_sub_dc, $columns, $update_where);
                // Update Ends
            }
        } else if (($data[0]['count'] == 0)) {

            // Update Begins

            // Insert Begins
            $action_obj = $pdo->insert($table_sub_dc, $columns);
            // Insert Ends
        }


        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
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
            $msg = 'error';
        }
        // }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql

        ];

        echo json_encode($json_array);

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

    case 'user_permission_1':
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







    default:

        break;
}



function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    $file_names = explode(',', $dc_file_name);
    $image_view = '';

    if ($dc_file_name) {
        foreach ($file_names as $file_key => $dc_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file_name);

            if ($dc_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}





function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    $file_names = explode(',', $ir_file_name);
    $image_view1 = '';

    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view1 .= "&nbsp";
                } else {
                    $image_view1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file_name);

            if ($ir_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view1 .= '<a href="javascript:print_pdf(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view1;
}


// doc3
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    $file_names = explode(',', $file_invoice);
    $image_view2 = '';

    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view2 .= "&nbsp";
                } else {
                    $image_view2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_invoice);

            if ($file_invoice) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view2 .= '<a href="javascript:print_pdf(\'/' . $file_invoice . '\')"><img src="uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view2;
}


// doc3


function image_view_3($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view_3 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}

function ins_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('SERVICE_INSTALL_DB_USERNAME');
    $password = project_env('SERVICE_INSTALL_DB_PASSWORD');
    $database_name = "aed_elcot";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    }
    $stmt = $conn->query("SELECT * FROM installation_details_sublist where `installation_id` LIKE 'INS%' order by unique_id desc");

    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['installation_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
    }
    if ($booking_no == '')
        $booking_nos = 'INS-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $booking_nos = 'INS-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'INS-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }

    return $booking_nos;
}



