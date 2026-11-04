<?php
require_once __DIR__ . '/../../config/env.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = 'po_form';
$table_product_details = 'product_details_sub';
$table_consignee_details = 'consignee_details_sub';


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';
// File Upload Library Call

$fileUploadPath = $fileUploadConfig->get('upload_folder');
// print_r($fileUploadPath);
// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set('upload_folder', $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);

// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    'status' => 0,
    'data' => '',
    'error' => 'Action Not Performed'
];
$json_array = '';
$sql = '';

$user_type = '';
$is_active = '';
$unique_id = '';
$prefix = '';

$data = '';
$msg = '';
$error = '';
$status = '';
$test = '';
// For Developer Testing Purpose

if (!isset($conn) || $conn === null) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
        exit;
    }
}


switch ($action) {


    case 'datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $limit = $length;

        $data = [];
        $sno = $start + 1;
        $month_val = date("F/Y", strtotime($month_fill));


        $date = new DateTime($month_fill);


        $date->modify('-1 month');


        $dec_date = $date->format('Y-m');


        if ($length == '-1') {
            $limit = '';
        }
        $table_po = "view_po_form_list";

        // Query Variables
        $json_array = '';
        $columns = [
            "'' as s_no",
            'po_num',
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            "state_name",
            "district as district_name",
            "department",
            'gst_value',
            "executive_name",
            // "(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 group by dis.form_main_unique_id) AS total_value",
            "total_amount as total_value",

            'file_name',
            "(SELECT COUNT(form_main_unique_id) AS po_count FROM stock_position AS stock WHERE stock.form_main_unique_id = $table_po.unique_id group by stock.form_main_unique_id) AS po_count",
            'unique_id',
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt",
            "(SELECT SUM(qty) AS pro_qty FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS pro_qty",
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt1",
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM po_product_assign_details AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt2",
            "delivery_due_dates",
            "is_active",
            "bill_address",
            "(SELECT COUNT(form_main_unique_id) AS pro_cnt FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS pro_cnt",
            "(SELECT COUNT(form_main_unique_id) AS cons_cnt FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cons_cnt",
            "(SELECT COUNT(*) FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.cons_verify_sts = '1' AND dis.is_delete = 0) AS cons_verified_cnt",
            "(SELECT COUNT(*) FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND (dis.cons_verify_sts = '2' OR dis.cons_verify_sts IS NULL OR dis.cons_verify_sts = '' OR dis.cons_verify_sts = '0') AND dis.is_delete = 0) AS cons_pending_cnt",

            "ld_required",
            "IFNULL((SELECT COUNT(form_main_unique_id) FROM stock_position_main AS stock WHERE stock.form_main_unique_id = $table_po.unique_id GROUP BY stock.form_main_unique_id), 0) AS stock_cnt",
            "(SELECT IF(EXISTS(
    SELECT 1 
    FROM consignee_details_sub AS dis 
    WHERE dis.form_main_unique_id = $table_po.unique_id 
      AND dis.is_delete = 0
), 1, 0)) AS consignee_exists",

"(SELECT IF(EXISTS(
    SELECT 1 
    FROM po_product_assign_details AS dis 
    WHERE dis.form_main_unique_id = $table_po.unique_id 
      AND dis.is_delete = 0
), 1, 0)) AS po_product_assign_exists",

"(SELECT IF(EXISTS(
SELECT 1 FROM product_details_sub AS dis
WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0), 1, 0)) AS product_detail_exist"

            
        ];

        $user=$_SESSION["unique_id"];
        // print_r($user);
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // Table Details
        $table_details = [
            $table_po,
            $columns
        ];

        // Base WHERE condition
        $where = "is_delete = '0'";

        // Date Filters
        if (!empty($month_fill)) {
            $where .= " AND DATE_FORMAT(po_date, '%Y-%m') LIKE '%$month_fill%'";
        }

        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

        if (!empty($from_date) && !empty($to_date)) {
            $where .= " AND po_date >= '$from_date' AND po_date <= '$to_date'";
        }

        if ($user_type_unique_id =='69b0115ced3bd96390'){
            $where .= " AND executive_name_unique_id = '$user'";

        }

        // Sorting
        $order_column = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : '';
        $order_dir = (isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) == 'asc') ? 'ASC' : 'DESC';
        $order_by = "unique_id $order_dir"; // Default order

        if ($order_column == '1') {
            $order_by = "po_date $order_dir";
        } else if ($order_column == '2') {
            $order_by = "po_num $order_dir";
        } else if ($order_column == '3') {
            $order_by = "department $order_dir";
        } else if ($order_column == '4') {
            $order_by = "executive_name $order_dir";
        } else if ($order_column == '9') {
            $order_by = "CAST(total_amount AS DECIMAL(15,2)) $order_dir";
        }

        // Search Filter - optimized fast search across visible columns with strict parentheses
        $search_val = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';
        if ($search_val != '') {
            $search_columns = [
                'po_num',
                "DATE_FORMAT(po_date, '%d-%m-%Y')",
                'state_name',
                'district',
                'department',
                'gst_value',
                'executive_name',
                'bill_address',
                'total_amount'
            ];
            $search_conditions = [];
            foreach ($search_columns as $col) {
                $search_conditions[] = "$col LIKE '%$search_val%'";
            }
            $where .= " AND (" . implode(" OR ", $search_conditions) . ")";
        }

        // Limit and Start for Pagination
        $limit = $_POST['length'];
        $start = $_POST['start'];
        // 
        // SQL Query Execution
        $sql_function = 'SQL_CALC_FOUND_ROWS';


        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);die();


        $total_records = total_records();


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

        $table_users = $table_users->data;

// print_r($table_users);
        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }


        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno;
                $po_num = $value['po_num'];
                $uni_id = $value['unique_id'];
                // $total_value = $value['total_value'];
                // $value['total_value'] = moneyFormatIndia1(($total_value));

//                 $total_value = $value['total_value'];
// $value['total_value'] = moneyFormatIndia1($total_value);
       $total_value = $value['total_value'];
$value['total_value'] = moneyFormatIndia1($total_value);



                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                $gst_value = $value['gst_value'];
                if ($gst_value == '') {
                    $value['gst_value'] = "Unregistered";
                }


                $file_name = $value['file_name'];
                // $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['file_name'] = image_view_3("po_form", $value['unique_id'], $file_name);

                

                $stock_cnt = $value['stock_cnt'];

                $value['is_active'] = is_active_show($value['is_active']);

                // echo $value['cnt'];
                if ($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['file_name'] == '' || $value['consignee_exists'] == '0' || $value['po_product_assign_exists'] == '0' || $value['product_detail_exist'] == '0') {
                    $value['po_num'] = '<span style="color:#da1c34;"
                    >' . $po_num . '</span>';
                } else {
                    $value['po_num'] = $po_num;
                }

                // Re-use stock_cnt pre-fetched in main query instead of redundant DB query per row
                $data_st = [['count' => intval($stock_cnt)]];

                $btn_update = btn_update($folder_name, $uni_id);
                if ($stock_cnt == '0') {
                    $btn_delete = btn_delete($folder_name, $uni_id);
                    $btn_cancel = btn_cancel_po($folder_name, $uni_id);
                } else {
                    $btn_cancel = btn_cancel_po($folder_name, $uni_id);
                }


                $actionBtn = '';

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    if ($data_st[0]['count']) {
                        // $value['unique_id'] = "";
                        $actionBtn .= "";

                    } else {
                        if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                            // $value['unique_id'] = $btn_update . $btn_delete;
                            $actionBtn .= $btn_update . $btn_delete;
                        } else if (in_array('5f88082b25ec031952', $action_ids)) {
                            $actionBtn .= $btn_update;
                        } else if (in_array('5f8808504271036738', $action_ids)) {
                            $actionBtn .= $btn_delete;
                        } else {
                            // $value['unique_id'] = '';
                            $actionBtn .= "";
                        }
                    }
                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") {

                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        // $value['unique_id'] = $btn_update . $btn_delete;
                        $actionBtn .= $btn_update . $btn_delete;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $actionBtn .= $btn_update;
                    } else if (in_array('5f8808504271036738', $action_ids)) {
                        $actionBtn .= $btn_delete;
                    } else {
                        $actionBtn .= '';
                    }
                }

                if ($_SESSION['user_type_unique_id'] == "65efd97b4df4040205") {
                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $actionBtn .= $btn_update;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $actionBtn .= $btn_update;
                    } else {
                        $actionBtn .= '';
                    }
                }

                if (($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741") || ($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741")) {
                    // $actionBtn .= $btn_cancel;
                        $actionBtn .= $btn_update . $btn_delete . $btn_cancel;

                    // $value['po_count'] = $btn_cancel;
                } else if (
                    ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "5f97fc3257f2525529") ||
                    ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205")
                ) {
                    // $value['po_count'] = $btn_cancel;
                    $actionBtn .= $btn_cancel;
                } else if ($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['delivery_due_dates'] == '' || $value['file_name'] == '') {
                    // $value['po_count'] = '';
                    $actionBtn .= '';
                } else {

                    if (in_array('5ff043a4f277448188', $action_ids)) {
                        // $value['po_count'] =  $btn_cancel;
                        $actionBtn .= $btn_cancel;
                    } else {
                        $actionBtn .= '';
                        // $value['po_count'] = '';
                    }
                }
                 if ($_SESSION['user_type_unique_id'] == "65fac54da3aac66007") {
  $actionBtn .= $btn_update;  
                 }
                  if ($_SESSION['user_type_unique_id'] == "65efd9a0b2e8b80472") {
  $actionBtn .= $btn_update;  
                 }

                   if ($_SESSION['user_type_unique_id'] == "68cba503472bd48995") {
  $actionBtn .= $btn_update;  
                 }


                 
                //  $actionBtn .= $btn_update;
                $value['unique_id'] = '<input type="hidden" name ="main_id" id="main_id" value="' . $uni_id . '">' . $actionBtn;


                $data[] = [
                    "s_no" => $value['s_no'],
                    "po_date" => $value['po_date'],
                    "po_num" => $value['po_num'],
                    "raw_unique_id" => $uni_id,
                    "raw_po_num" => $po_num,
                    "state_name" => $value['state_name'],
                    "district_name" => $value['district_name'],
                    "department" => $value['department'],
                    "gst_value" => $value['gst_value'],
                    "executive_name" => $value['executive_name'],
                    "total_value" => $value['total_value'],
                    "file_name" => $value['file_name'],
                    // "po_count" => $value['po_count'],
                    "is_active" => $value['is_active'],
                    "unique_id" => $value['unique_id'],
                    "bill_address" => $value['bill_address'],
                    "pro_cnt" => $value['pro_cnt'],
                    "cons_cnt" => intval($value['cons_cnt']),
                    "cons_verified_cnt" => intval($value['cons_verified_cnt']),
                    "cons_pending_cnt" => intval($value['cons_pending_cnt']),
                    "ld_required" => $value['ld_required'],
                    "qty" => $value['pro_qty']
                ];
                $sno++;
            }
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql
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




    case 'createupdate':


        $po_num = $_POST['po_num'];
        $old_po_num = $_POST['old_po_num'];
        $po_date = $_POST['po_date'];
        $department = $_POST['department'];
        $gst_option = $_POST['gst_option'];
        $gst_value = $_POST['gst_value'];
        $executive_name = $_POST['executive_name'];
        $bill_address = $_POST['bill_address'];
        $contact_name = $_POST['contact_name'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $district = $_POST['district'];
        $pin = $_POST['pin'];
        $po_type = $_POST['po_type'];
        $no_of_po = $_POST['no_of_po'];
        $no_of_consignee = $_POST['no_of_consignee'];
        $unique_id = $_POST['unique_id'];
        $m_unique_id = $_POST['m_unique_id'];
        $po_unique_id = $_POST['po_unique_id'];
        $acc_vertical = $_POST['acc_vertical'];
        $acc_sector = $_POST['acc_sector'];
        $state_name = $_POST['state_name'];
        $landline_number = $_POST['contact_landline_num'];

        $po_unique_id = po_no_get1();

        if ($gst_option == 'yes') {
            $gst_value1 = $gst_value;
        } else if ($gst_option == 'no') {
            $gst_value1 = '';
        }

        if ($unique_id == '') {
            $ids = $m_unique_id;
        } else if ($unique_id != '') {
            $ids = $unique_id;
        }

        $update_where = '';
        // print_r( $m_unique_id );
        $columns = [
            'po_num' => $po_num,
            'po_date' => $po_date,
            'department' => $department,
            'gst_option' => $gst_option,
            'gst_value' => $gst_value1,
            'executive_name' => $executive_name,
            'bill_address' => $bill_address,
            'contact_name' => $contact_name,
            'contact_number' => $contact_number,
            'landline_number' => $landline_number,
            'email' => $email,
            'district' => $district,
            'pin' => $pin,
            'po_prepared_by' => $po_prepared_by,
            'po_type' => $po_type,
            'no_of_po' => $no_of_po,
            'no_of_consignee' => $no_of_consignee,
            'po_unique_id' => $po_unique_id,
            'state_name' => $state_name,
            'acc_vertical' => $acc_vertical,
            'acc_sector' => $acc_sector,
            // 'zone' => $zone,
            'unique_id' => $ids,
        ];

        $table_details = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = 'is_delete = 0  and unique_id = "' . $ids . '"';
        // AND contact_name ="' . $contact_name . '"
        // AND po_num = "' . $po_num . '"
        $action_obj1 = $pdo->select($table_details, $select_where);
        // print_r($action_obj1);

        if ($action_obj1->status) {
            $status = $action_obj1->status;
            $data = $action_obj1->data;
            $error = '';
            $sql = $action_obj1->sql;
        } else {
            $status = $action_obj1->status;
            $data = $action_obj1->data;
            $error = $action_obj1->error;
            $sql = $action_obj1->sql;
            $msg = 'error';
        }

        $table_details_5 = [
            $table,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where_5 = 'is_delete = 0  and po_num = "' . $po_num . '"';
        // AND contact_name ="' . $contact_name . '"
        // AND po_num = "' . $po_num . '"
        $action_obj5 = $pdo->select($table_details_5, $select_where_5);
        // print_r($action_obj5);

        if ($action_obj5->status) {
            $status = $action_obj5->status;
            $data5 = $action_obj5->data;
            $error = '';
            $sql = $action_obj5->sql;
        } else {
            $status = $action_obj5->status;
            $data5 = $action_obj5->data;
            $error = $action_obj5->error;
            $sql = $action_obj5->sql;
            $msg = 'error';
        }


        // $table_details_6      = [
        //     $table,
        //     [
        //         'COUNT(unique_id) AS count'
        //     ]
        // ];
        // $select_where_6 = 'is_delete = 0  and po_num = "'.$old_po_num.'"';
        // // AND contact_name ="' . $contact_name . '"
        // // AND po_num = "' . $po_num . '"
        // $action_obj6         = $pdo->select($table_details_6, $select_where_6);
        // // print_r($action_obj6);

        // if ($action_obj6->status) {
        //     $status     = $action_obj6->status;
        //     $data6       = $action_obj6->data;
        //     $error      = '';
        //     $sql        = $action_obj6->sql;
        // } else {
        //     $status     = $action_obj6->status;
        //     $data6       = $action_obj6->data;
        //     $error      = $action_obj6->error;
        //     $sql        = $action_obj6->sql;
        //     $msg        = 'error';
        // }


        //  $table_details2      = [
        //     $table,
        //     [
        //         'unique_id'
        //     ]
        // ];
        // $select_where2 = 'is_delete = 0 AND unique_id = "' . $unique_id . ' "';

        // // AND contact_name ="' . $contact_name . '"
        // $action_obj2         = $pdo->select($table_details2, $select_where2);
        // // print_r($action_obj2);

        // if ($action_obj2->status) {
        //     $status     = $action_obj2->status;
        //     $data_old       = $action_obj2->data;
        //     $error      = '';
        //     $sql        = $action_obj2->sql;
        // } else {
        //     $status     = $action_obj2->status;
        //     $data_old       = $action_obj2->data;
        //     $error      = $action_obj2->error;
        //     $sql        = $action_obj2->sql;
        //     $msg        = 'error';
        // }
        // print_r($data[0]['count'] . '-' .$data5[0]['count']);
        // echo $status;die();
        if (($data[0]['count'] === 0) && ($data5[0]['count'] !== 0) || ($data[0]['count'] !== 0) && ($data5[0]['count'] !== 0) || ($data[0]['count'] !== 0) && ($data5[0]['count'] === 0)) {

            // == $data_old[0]['unique_id']
            // if($unique_id == $data_old[0]['unique_id']) {
//              if($unique_id != '' && ($data[0]['count'] === 1) && ($data5[0]['count'] === 0)) {
//                 unset($columns['unique_id']);
//                 $update_where   = [
//                     'unique_id'     => $unique_id
//                 ];
//                 $action_obj     = $pdo->update($table, $columns, $update_where);

            //                 // Update Ends
//             }
// //////////////////
//             // else if($unique_id != '' && ($data[0]['count'] === 1) && ($data6[0]['count'] === 1) && $data6 == 1) {
//             //     unset($columns['unique_id']);
//             //     $update_where   = [
//             //         'unique_id'     => $unique_id
//             //     ];
//             //     $action_obj     = $pdo->update($table, $columns, $update_where);

            //             //     // Update Ends
//             // }
// //////////////////
//             else if($unique_id != '' && ($data[0]['count'] === 1) && ($data5[0]['count'] === 1) ){
//             $msg        = 'already';
//             $action_obj->status = 1;
//             }
//              else if($unique_id == '' ){
//             $msg        = 'already';
//             $action_obj->status = 1;
//             }
            if ($unique_id != '') {
                unset($columns['unique_id']);
                $update_where = [
                    'unique_id' => $unique_id
                ];
                $action_obj = $pdo->update($table, $columns, $update_where);

                // Update Ends
            }
            //    
        } else if (($data[0]['count'] === 0) && ($data5[0]['count'] === 0)) {

            // Update Begins

            // Insert Begins
            $action_obj = $pdo->insert($table, $columns);
            // Insert Ends
        }
        // print_r($action_obj->status);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            if ($msg === "already") {
                $msg = 'already';
            } else {
                if ($unique_id) {
                    $msg = 'update';
                } else {
                    $msg = 'create';
                }
            }

        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        // print_r($msg);   
        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;


    case 'district_name_option':

        $district_name = $_POST['district_name'];


        $district_name_options = district();

        $district_name_option = select_option($district_name_options, "Select District", $district_name);

        echo $district_name_option;

        break;

    case 'con_state_name_option':

        $state_name = $_POST['state_name'];


        $con_state_name_options = state_option();

        $con_state_name_options = select_option($con_state_name_options, "Select State Name", $state_name);

        echo $con_state_name_options;

        break;


    case 'assign_team_member_id_option':

        $assign_team_member_id = $_POST['assign_team_member_id'];


        $assign_team_member_id_options = team_member();

        $assign_team_member_id_option = select_option($assign_team_member_id_options, "Select Team Member", $assign_team_member_id);

        echo $assign_team_member_id_option;

        break;


    case "get_consignee_product_details_old":

        $main_unique_id = $_POST["main_unique_id"];
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];


        $data = [];
        $sno = $start + 1;

        if ($length == '-1') {
            $limit = '';
        } else {
            $limit = $length;
        }

        $table_po_con = "view_consignee_product_details";

        // Columns from your view
        $columns = [
            "'' as s_no",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "con_address",
            "zone",
            "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=view_consignee_product_details.item_code)as item_code",
            "product_name",
            "qty",
            "unit_price",
            "tax",
            "assign_qty",
            "con_unique_id",
            "product_unique_id",
        ];

        $table_details = [$table_po_con, $columns];

        // Base WHERE clause
        $where = "main_unique_id = '" . $main_unique_id . "'";

        // Apply search filter
        $search_filter = datatable_searching($_POST['search']['value'], $columns);
        if ($search_filter) {
            $where .= " AND ($search_filter)";
        }

        $order_by = ""; // Add ordering logic here if needed

        // Fetch data
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');

        $total_records = total_records();

        if ($result->status) {
            foreach ($result->data as $row) {
                $data[] = [
                    "s_no" => $sno++,
                    "con_contact_name" => $row['con_contact_name'],
                    "con_contact_number" => $row['con_contact_number'],
                    "con_lan_num" => $row['con_lan_num'],
                    "con_address" => $row['con_address'],
                    "zone" => $row['zone'],
                    "item_code" => $row['item_code'],
                    "product_name" => $row['product_name'],
                    "qty" => $row['qty'],
                    "unit_price" => $row['unit_price'],
                    "tax" => $row['tax'],
                    "assign_qty" => $row['assign_qty'],
                    "con_unique_id" => $row['con_unique_id'],
                    "product_unique_id" => $row['product_unique_id']
                ];
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql // Optional: Remove in production
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



    case "get_item_name":

        $item_code = $_POST["item_code"];

        $details = [
            "item_description" => "",
            "rc_unit_price" => "",
            "rc_net_price" => "",
            "gst" => ""

        ];
        $items_where = 'unique_id="' . $item_code . '" ';

        $items__columns = [
            "item_description",
            "rc_unit_price",
            "rc_net_price",
            "gst",
            "warranty_in_yrs"

        ];

        $items__table_details = [
            "item_creation_sub",
            $items__columns
        ];

        $items__details = $pdo->select($items__table_details, $items_where);

        if ($items__details->status) {
            if (!empty($items__details->data)) {
                $details = $items__details->data[0];
            }
        } else {
            print_r($items__details);
        }


        echo json_encode($details);

        break;

    case 'item_code_option':

        $tender_code = $_POST['tender_code'];

        $item_code_options = item_name($tender_code);

        $item_code_options = select_option($item_code_options, "Select Item Code");

        echo $item_code_options;

        break;
    // if($status=='2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205" )
// 
    case 'delete_consignee':


        $unique_id = $_POST['unique_id'];


        $table = 'consignee_details_sub';

        $column = [
            'is_delete' => 1
        ];


        $where = [
            "unique_id" => $unique_id
        ];

        $action_obj = $pdo->update($table, $column, $where);

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
    // pavitoday
    case 'get_consignee_by_batch1':
        $batch_id = $_POST['batch_id'] ?? '';

        try {
            $stmt = $conn->prepare("
        SELECT 
            billing_address,con_address, con_pincode, zone, con_contact_name, con_contact_number,
            con_lan_num, consignee_gst, cons_verify_sts,
            assign_team_member as assign_team_member_id,
            (select staff_name from user where user.staff_id = assign_team_member) as assigned_team_member,
            get_district_name(con_district) AS district_name,
            get_state_name(con_state_name) AS state_name,
            con_district,
            con_state_name,
            unique_id,
            inv_cons_status,
            (select status from po_form where po_form.unique_id = form_main_unique_id) as po_status
        FROM consignee_details_sub
        WHERE batch_id = :batch_id AND is_active = 1 AND is_delete = 0
    ");
            $stmt->execute(['batch_id' => $batch_id]);

            $html = '
    <table id="test_demos" class="table table-hover table-bordered align-middle mb-0 dataTable no-footer" style="width:100%">
 
    <thead class="table-light">
        <tr>
            <th class="text-center">ID</th>
            <th>Address</th>
            <th>Billing Address</th>
            <th>State</th>
            <th>District</th>
            <th>Zone</th>
            <th>Pincode</th>
            <th>Contact Name</th>
            <th>Contact Number</th>
            <th>Landline</th>
            <th>GST</th>
            <th>Assigned Team Member</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead><tbody>';

            $i = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $status = $row['cons_verify_sts'] == 1 ? 'Verified' : 'Not Verified';
                $sts = $row['inv_cons_status'];
                $unique_id = $row['unique_id'];
                $po_status = $row['po_status'];
                $html .= '<tr>';
                $html .= '<td>' . $i . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_address']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['billing_address']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['state_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['district_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['zone']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_pincode']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_number']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_lan_num']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['consignee_gst']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['assigned_team_member']) . '</td>';
                $html .= '<td>' . $status . '</td>';

                if ($sts == 0) {
                    $html .= '<td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <button class="btn btn-outline-primary edit-consignee"
            title="Edit"
            data-uniqueid="' . htmlspecialchars($row['unique_id'], ENT_QUOTES) . '"
            data-address="' . htmlspecialchars($row['con_address'], ENT_QUOTES) . '"
            data-billing_address="' . htmlspecialchars($row['billing_address'], ENT_QUOTES) . '"
            data-district="' . htmlspecialchars($row['district_name'], ENT_QUOTES) . '"
            data-district_id="' . htmlspecialchars($row['con_district'], ENT_QUOTES) . '"
             data-con_state_name="' . htmlspecialchars($row['state_name'], ENT_QUOTES) . '"
            data-con_state_id="' . htmlspecialchars($row['con_state_name'], ENT_QUOTES) . '"
            data-zone="' . htmlspecialchars($row['zone'], ENT_QUOTES) . '"
            data-pincode="' . htmlspecialchars($row['con_pincode'], ENT_QUOTES) . '"
            data-contactname="' . htmlspecialchars($row['con_contact_name'], ENT_QUOTES) . '"
            data-contactnumber="' . htmlspecialchars($row['con_contact_number'], ENT_QUOTES) . '"
            data-landline="' . htmlspecialchars($row['con_lan_num'], ENT_QUOTES) . '"
            data-gst="' . htmlspecialchars($row['consignee_gst'], ENT_QUOTES) . '"
            data-team_member="' . htmlspecialchars($row['assigned_team_member'], ENT_QUOTES) . '"
            data-team_member_id="' . htmlspecialchars($row['assign_team_member_id'], ENT_QUOTES) . '"
            data-status="' . htmlspecialchars($row['cons_verify_sts'], ENT_QUOTES) . '"
            onclick="editConsignee_over(this)">
            <i class="bi bi-pencil"></i>
      </button>';

                    // Delete button with conditional icon visibility
                    if ($po_status == '2' && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205") {
                        $html .= '<button class="btn btn-outline-danger delete-consignee"
            title="Delete"
            data-uniqueid="' . htmlspecialchars($row['unique_id'], ENT_QUOTES) . '" style="display:none;">
            <i class="bi bi-trash" ></i>
        </button>';
                    } else {
                        $html .= '<button class="btn btn-outline-danger delete-consignee"
            title="Delete"
            data-uniqueid="' . htmlspecialchars($row['unique_id'], ENT_QUOTES) . '">
            <i class="bi bi-trash"></i>
        </button>';
                    }

                    $html .= '</div></td>';
                } else if ($sts == 1) {
                    $html .= '<td class="text-center">
    <div class="btn-group btn-group-sm" role="group">
        <button class="btn btn-outline-primary edit-consignee"
            title="Edit"
            data-uniqueid="' . htmlspecialchars($row['unique_id'], ENT_QUOTES) . '"
            data-address="' . htmlspecialchars($row['con_address'], ENT_QUOTES) . '"
            data-billing_address="' . htmlspecialchars($row['billing_address'], ENT_QUOTES) . '"
            data-district="' . htmlspecialchars($row['district_name'], ENT_QUOTES) . '"
            data-district_id="' . htmlspecialchars($row['con_district'], ENT_QUOTES) . '"
            data-con_state_name="' . htmlspecialchars($row['state_name'], ENT_QUOTES) . '"
            data-con_state_id="' . htmlspecialchars($row['con_state_name'], ENT_QUOTES) . '"
            data-zone="' . htmlspecialchars($row['zone'], ENT_QUOTES) . '"
            data-pincode="' . htmlspecialchars($row['con_pincode'], ENT_QUOTES) . '"
            data-contactname="' . htmlspecialchars($row['con_contact_name'], ENT_QUOTES) . '"
            data-contactnumber="' . htmlspecialchars($row['con_contact_number'], ENT_QUOTES) . '"
            data-landline="' . htmlspecialchars($row['con_lan_num'], ENT_QUOTES) . '"
            data-gst="' . htmlspecialchars($row['consignee_gst'], ENT_QUOTES) . '"
            data-team_member="' . htmlspecialchars($row['assigned_team_member'], ENT_QUOTES) . '"
             data-team_member_id="' . htmlspecialchars($row['assign_team_member_id'], ENT_QUOTES) . '"
            data-status="' . htmlspecialchars($row['cons_verify_sts'], ENT_QUOTES) . '"
            onclick="editConsignee_over(this)">
            <i class="bi bi-pencil"></i>
        </button>
        
        
    </div>
</td>';
                }

                $html .= '</tr>';

                $i++;
            }

            $html .= '</tbody></table>';
            echo $html;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        break;



    case 'get_consignee_by_batch':


        // print_r("hii");
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $limit = $length;

        $data = [];
        $sno = $start + 1;
        // echo $sno;
        $month_fill = $_POST["month_fill"];
        // echo $month_fill;
        $month_val = date("F/Y", strtotime($month_fill));


        $date = new DateTime($month_fill);


        $date->modify('-1 month');


        $dec_date = $date->format('Y-m');


        if ($length == '-1') {
            $limit = '';
        }
        $table_po = "view_po_form_list";

        // Query Variables
        $json_array = '';
        $columns = [
            "'' as s_no",
            'po_num',
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            "state_name",
            "district as district_name",
            "department",
            'gst_value',
            "executive_name",
            "(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 group by dis.form_main_unique_id) AS total_value",

            'file_name',
            "(SELECT COUNT(form_main_unique_id) AS po_count FROM stock_position AS stock WHERE stock.form_main_unique_id = $table_po.unique_id group by stock.form_main_unique_id) AS po_count",
            'unique_id',
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt",
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt1",
            "(SELECT COUNT(form_main_unique_id) AS cnt FROM po_product_assign_details AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0  group by dis.form_main_unique_id) AS cnt2",
            "delivery_due_dates",
            "is_active",

        ];

        // Table Details
        $table_details = [
            $table_po,
            $columns
        ];

        // Base WHERE condition
        $where = "is_delete = '0'";

        // Date Filters
        if (!empty($month_fill)) {
            $where .= " AND DATE_FORMAT(po_date, '%Y-%m') LIKE '%$month_fill%'";
        }

        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

        if (!empty($from_date) && !empty($to_date)) {
            $where .= " AND po_date >= '$from_date' AND po_date <= '$to_date'";
        }

        // Sorting
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];
        $order_by = "unique_id $order_dir"; // Default order



        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

        // Search Filter
        $search = datatable_searching($search, $columns);
        if ($search) {
            $where .= " AND $search";
        }

        // Limit and Start for Pagination
        $limit = $_POST['length'];
        $start = $_POST['start'];
        // 
        // SQL Query Execution
        $sql_function = 'SQL_CALC_FOUND_ROWS';


        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);



        $total_records = total_records();

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
                $value['s_no'] = $sno;
                $po_num = $value['po_num'];
                $total_value = $value['total_value'];
                $value['total_value'] = moneyFormatIndia1(($total_value));

                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                $gst_value = $value['gst_value'];
                if ($gst_value == '') {
                    $value['gst_value'] = "Unregistered";
                }


                $file_name = $value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);


                $value['is_active'] = is_active_show($value['is_active']);

                // echo $value['cnt'];
                if ($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['file_name'] == '') {
                    $value['po_num'] = '<span style="color:#da1c34;"
                    >' . $po_num . '</span>';
                } else {
                    $value['po_num'] = $po_num;
                }

                $where_1 = "form_main_unique_id='" . $value['unique_id'] . "'";
                // ORDER BY unique_id DESC

                $table_1 = "stock_position_main";

                $columns_1 = [
                    'COUNT(form_main_unique_id) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_1
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_1);
                $data_st = $result_values_12->data;

                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);
                $btn_cancel = btn_cancel_po($folder_name, $value['unique_id']);

                if (($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741") || ($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741")) {
                    // echo"hi";
                    $value['po_count'] = $btn_cancel;
                } else if (
                    ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "5f97fc3257f2525529") ||
                    ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205")
                ) {
                    $value['po_count'] = $btn_cancel;
                    // echo"hlo";
                } else if ($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['delivery_due_dates'] == '' || $value['file_name'] == '') {
                    $value['po_count'] = '';
                    // echo"hi hlo";        
                } else {

                    if (in_array('5ff043a4f277448188', $action_ids)) {
                        $value['po_count'] = $btn_cancel;
                        // echo"345";
                    } else {

                        $value['po_count'] = '';
                        // echo "gfhgfhgfhgfh";
                    }
                }


                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && $_SESSION['user_type_unique_id'] != "65efd97b4df4040205") {
                    if ($data_st[0]['count']) {
                        $value['unique_id'] = "";
                    } else {
                        if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                            $value['unique_id'] = $btn_update . $btn_delete;
                        } else if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['unique_id'] = $btn_update;
                        } else if (in_array('5f8808504271036738', $action_ids)) {
                            $value['unique_id'] = $btn_delete;
                        } else {
                            $value['unique_id'] = '';
                        }
                    }
                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_update . $btn_delete;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    } else if (in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_delete;
                    } else {
                        $value['unique_id'] = '';
                    }
                }

                if ($_SESSION['user_type_unique_id'] == "65efd97b4df4040205") {
                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    }
                    // else if (in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_delete;
                    // } 
                    else {
                        $value['unique_id'] = '';
                    }
                }



                $data[] = [
                    "s_no" => $value['s_no'],
                    "po_num" => $value['po_num'],
                    "po_date" => $value['po_date'],
                    "state_name" => $value['state_name'],
                    "district_name" => $value['district_name'],
                    "department" => $value['department'],
                    "gst_value" => $value['gst_value'],
                    "executive_name" => $value['executive_name'],
                    "total_value" => $value['total_value'],
                    "file_name" => $value['file_name'],
                    "po_count" => $value['po_count'],
                    "is_active" => $value['is_active'],
                    "unique_id" => $value['unique_id']
                ];
                $sno++;
            }
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql
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





    case 'update_consignee_olds':
        $unique_id = $_POST['unique_id'];
        $con_address = $_POST['con_address'];

        // Step 1: Check if the same consignee address exists (excluding current record)
        $check_sql = "SELECT COUNT(*) as total FROM consignee_details_sub 
                      WHERE con_address = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$con_address]);
        $check_result = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($check_result['total'] > 0) {
            // Duplicate address exists in another record
            echo json_encode([
                'status' => false,
                'data' => '',
                'error' => 'Duplicate consignee address exists.',
                'msg' => 'duplicate_address',
                'sql' => $check_sql
            ]);
            break;
        }

        // Step 2: If no duplicate, proceed with update
        $columns = [
            'con_branch' => $_POST['con_branch'],
            'con_address' => $_POST['con_address'],
            'con_district' => $_POST['con_district'],
            'zone' => $_POST['zone'],
            'con_pincode' => $_POST['con_pincode'],
            'con_contact_name' => $_POST['con_contact_name'],
            'con_contact_number' => $_POST['con_contact_number'],
            'con_lan_num' => $_POST['con_lan_num'],
            'consignee_gst' => $_POST['consignee_gst'],
            'assign_team_member' => $_POST['up_assign_team_member'],
            'billing_address' => $_POST['billing_address'],
            'cons_verify_sts' => $_POST['verify_sts']
        ];

        $update_where = ['unique_id' => $unique_id];
        $action_data = $pdo->update('consignee_details_sub', $columns, $update_where);

        // Step 3: Update related PO product assign details
        $table_product_po = 'po_product_assign_details';
        $columns_po = [
            "con_name" => $_POST['con_contact_name'],
            "con_contact_no" => $_POST['con_contact_number'],
            "con_address" => $_POST['con_address'],
            "con_assign_team_member" => $_POST['up_assign_team_member']
        ];
        $update_where_po = 'con_unique_id="' . $unique_id . '" ';
        $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);

        // Final response
        if ($action_data->status) {
            echo json_encode([
                'status' => true,
                'data' => $action_data->data,
                'error' => '',
                'msg' => 'success_update',
                'sql' => $action_data->sql
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'data' => $action_data->data,
                'error' => $action_data->error,
                'msg' => 'error',
                'sql' => $action_data->sql
            ]);
        }
        break;


    case 'update_con_rec_date':

        $po_unique_id = $_POST['po_unique_id'];
        $batch_id = $_POST['batch_id'];
        $consignee_date = $_POST['consignee_date'];

        $table = 'consignee_details_sub';
        $columns = [
            "consignee_received_date" => $consignee_date
        ];

        $update_where = 'form_main_unique_id ="' . $po_unique_id . '" and batch_id = "' . $batch_id . '"';
        $action_obj = $pdo->update($table, $columns, $update_where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            $msg = 'success_update';
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);


        break;



    case 'update_consignee':
        $unique_id = $_POST['unique_id'];
        $form_main_unique_id = $_POST['form_main_unique_id'];

        $columns_cons = [
            "count(*) as cnt"
        ];


        $where_cons = "unique_id != '" . $unique_id . "' and con_address = '" . $_POST['con_address'] . "' and form_main_unique_id = '" . $form_main_unique_id . "'";

        $table_cons = [
            "consignee_details_sub",
            $columns_cons // Alias for vendor_creation table
        ];

        $action_obj_cons = $pdo->select($table_cons, $where_cons);
// print_r($action_obj_cons);

        if ($action_obj_cons->status) {
            $cons_status = $action_obj_cons->status;
            $cons_data = $action_obj_cons->data;
            $cons_error = "";
            $cons_sql = $action_obj->sql;
        }

        // if ($cons_data[0]["cnt"]) {

        //     $msg = "already";
        // } else if ($cons_data[0]["cnt"] == 0) {

            $table_product_po = 'po_product_assign_details';
            $columns_po = [
                "con_name" => $_POST['con_contact_name'],
                "con_contact_no" => $_POST['con_contact_number'],
                "con_address" => $_POST['con_address'],
                "con_assign_team_member" => $_POST['up_assign_team_member']

            ];

            $update_where_po = 'con_unique_id="' . $unique_id . '" ';
            
            $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);


            $table_inv = 'invoice_creation';

            $columns_inv_cr = [

                "team_mem" => $_POST['up_assign_team_member']

            ];
            //    and ponum = "" 
            $update_where_inv = 'consignee_id="' . $unique_id . '" and po_unique_id= "' . $form_main_unique_id . '" ';

            $action_obj_3 = $pdo->update($table_inv, $columns_inv_cr, $update_where_inv);



            $table_inv_main = 'invoice_creation_main';
            $columns_inv_main = [
                "team_mem" => $_POST['up_assign_team_member']

            ];
            // and ponum = "" 
            $update_where_invoice_main = 'consignee_unique_id="' . $unique_id . '" and form_main_unique_id= "' . $form_main_unique_id . '" ';
            $action_obj_4 = $pdo->update($table_inv_main, $columns_inv_main, $update_where_invoice_main);



           $columns = [
                'con_branch' => $_POST['con_branch'],
                'con_branch_code' => $_POST['con_branch_code'],
                'alter_contact_name' => $_POST['con_alter_name'],
                'alter_number' => $_POST['con_alter_num'],
                'cons_email_id' => $_POST['con_email_id'],
                'zone_code' => $_POST['con_zone_code'],

                'con_address' => $_POST['con_address'],
                'billing_address' => $_POST['billing_address'],
                'con_state_name' => $_POST['con_state_name'],
                'con_district' => $_POST['con_district'],
                'zone' => $_POST['zone'],
                'con_pincode' => $_POST['con_pincode'],
                'con_contact_name' => $_POST['con_contact_name'],
                'con_contact_number' => $_POST['con_contact_number'],
                'con_lan_num' => $_POST['con_lan_num'],
                'consignee_gst' => $_POST['consignee_gst'],
                'assign_team_member' => $_POST['up_assign_team_member'],
                'cons_verify_sts' => $_POST['verify_sts'],
                'billing_gst_no' => $_POST['billing_gst'],
                'region' => $_POST['region']
            ];


            $update_where = ['unique_id' => $unique_id];

            $action_data = $pdo->update('consignee_details_sub', $columns, $update_where);



            if ($action_data->status) {
                $status = $action_data->status;
                $data = $action_data->data;
                $error = '';
                $sql = $action_data->sql;
                $msg = 'success_update';
            } else {
                $status = $action_data->status;
                $data = $action_data->data;
                $error = $action_data->error;
                $sql = $action_data->sql;
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


    // pavitoday
    case 'mytermsterms_condition':
        $delivery_due_dates = $_POST['delivery_due_dates'];
        $ld_per_day = $_POST['ld_per_day'];
        $other_insurance_type = $_POST['other_insurance_type'];
        $warranty = $_POST['warranty'];
        $warranty_duration = $_POST['warranty_duration'];
        $ins_reqired = $_POST['ins_reqired'];
        $insurence_required = $_POST['insurence_required'];
        $insurence_types = $_POST['insurence_types'];
        $ld_required = $_POST['ld_required'];
        $ld_delivery_due_date = $_POST['ld_delivery_due_date'];
        $ld_installation_due_date = $_POST['ld_installation_due_date'];
        $ld = $_POST['ld'];

        // $tat = $_POST['tat'];

        $apd = $_POST['apd'];

        $amc = $_POST['amc'];

        $start_date = $_POST['start_date'];

        $end_date = $_POST['end_date'];

        $amc_percentae = $_POST['amc_percentae'];

        $amcvalue = $_POST['amcvalue'];

        $bg_month = $_POST['bg_month'];
        $bg = $_POST['bg'];
        $demo = $_POST['demo'];
        $amc_required = $_POST['amc_required'];
        $batch_id = $_POST['batch_assign_qty'];
        $ld_date_type = $_POST['ld_date_type'];


        $po_no = $_POST['po_no'];
        $parts = explode('/', $po_no);
        $form_main_unique_id = $_POST['form_main_unique_id'];
        // Get the last value from the array
        $po_num_value = end($parts);
        $allowedExts = array('pdf');

        $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['po_file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            // $tem_name = random_strings(25) . '.pdf';
            $tem_name = "PO-" . $po_num_value . '.pdf';
            move_uploaded_file($_FILES['po_file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['po_file']['name'];
        }





        // $amcpofile = $_POST['amcpofile'];

        // $amcpofileparts = explode('/', $amcpofile);
        // // Get the last value from the array
        // $amcfile_value = end($amcpofileparts);
        // $allowedExts = array('pdf');
        // $extension = pathinfo($_FILES['amcpofile']['name'], PATHINFO_EXTENSION);

        // if ($_FILES['amcpofile']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
        //     // $tem_name = random_strings(25) . '.pdf';
        //     $tem_name = "PO-".$amcfile_value . '.pdf'; 
        //     move_uploaded_file($_FILES['amcpofile']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
        //     // Set $file_names to the stored filename with .pdf extension
        //  $amcfile_names = $tem_name;
        //     $amcfile_org_names = $_FILES['amcpofile']['name'];
        // }

        //  $amcreqtable= 'amcrequired';


        //  $amccolumns            = [
        //      'batch_id'           => $batch_id,
        //   'po_unique_id'           => $demo,
        // 'start_date'           => $start_date,
        //  'end_date'           => $end_date,
        //   'amc_percentae'           => $amc_percentae,
        //   'amcvalue'           => $amcvalue,

        //   'amcfile_names'           => $amcfile_names,
        //     'amcfile_org_names'           => $amcfile_org_names
        //   ];

        // print_r($file_names);die();
        $update_where = '';
        // print_r( $m_unique_id );
        if (($file_names) && ($file_org_names)) {

            $columns = [

                'delivery_due_dates' => $delivery_due_dates,
                'batch_id' => $batch_id,
                'form_main_unique_id' => $form_main_unique_id,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_duration' => $warranty_duration,
                'ins_reqired' => $ins_reqired,
                'insurence_required' => $insurence_required,
                'insurence_types' => $insurence_types,
                'ld_required' => $ld_required,
                'ld_installation_due_date' => $ld_installation_due_date,
                'ld_delivery_due_date' => $ld_delivery_due_date,
                'ld_date_type' => $ld_date_type,

                'ld' => $ld,
                'ld' => $ld,
                // 'tat' => $tat,
                'amc' => $amc,
                'apd' => $apd,
                'amc_required' => $amc_required,
                'other_insurance_type' => $other_insurance_type,
                'bg' => $bg,
                'file_name' => $file_names,
                'file_org_name' => $file_org_names,



            ];
        } else {

            $columns = [

                'delivery_due_dates' => $delivery_due_dates,
                'batch_id' => $batch_id,
                'form_main_unique_id' => $form_main_unique_id,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_duration' => $warranty_duration,
                'ins_reqired' => $ins_reqired,
                'insurence_required' => $insurence_required,
                'insurence_types' => $insurence_types,
                'ld_required' => $ld_required,
                'ld_installation_due_date' => $ld_installation_due_date,
                'ld_delivery_due_date' => $ld_delivery_due_date,
                'ld_date_type' => $ld_date_type,
                'ld' => $ld,
                // 'tat' => $tat,
                'amc' => $amc,
                'apd' => $apd,
                'amc_required' => $amc_required,
                'other_insurance_type' => $other_insurance_type,
                'bg_month' => $bg_month,



            ];
        }


        // if($amc_required=='on'){



        //         $amc_action_obj     = $pdo->insert($amcreqtable, $amccolumns);

        // }
        // print_r(  $amc_action_obj );
        $table_terms = 'po_form';
        // Update Begins
        if ($demo) {
            if ($unique_id) {
                unset($columns['unique_id']);

                // $update_where   = [
                //     'po_unique_id'     => $demo
                // ];
                $update_where = 'unique_id ="' . $demo . '"';

                $action_obj = $pdo->update($table_terms, $columns, $update_where);
            }
            // else{
            //  $amc_action_obj     = $pdo->insert($table_terms, $columns);
            // }
            // print_r($action_obj);
            // Update Ends
        }
        // print_r( $action_obj );
        // else {
        //     // Insert Begins

        //     $action_obj     = $pdo->insert($table, $columns );
        //     // Insert Ends
        // }
        // print_r($action_obj );
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

            if ($demo) {
                $msg = 'update';
            } else {
                $msg = 'create';
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'terms_condition':
        $delivery_due_dates = $_POST['delivery_due_dates'];
        $ld_per_day = $_POST['ld_per_day'];
        $other_insurance_type = $_POST['other_insurance_type'];
        $warranty = $_POST['warranty'];
        $warranty_duration = $_POST['warranty_duration'];
        $ins_reqired = $_POST['ins_reqired'];

        $insurence_required = $_POST['insurence_required'];
        if ($insurence_required == '') {
            $insurence_types = '';
        } else {
            $insurence_types = $_POST['insurence_types'];
        }
        $ld_required = $_POST['ld_required'];
        $ld_delivery_due_date = $_POST['ld_delivery_due_date'];
        $ld_installation_due_date = $_POST['ld_installation_due_date'];

        $ld_date_type = $_POST['ld_date_type'];




        $ld = $_POST['ld'];

        // $tat = $_POST['tat'];

        $apd = $_POST['apd'];

        $amc = $_POST['amc'];

        $start_date = $_POST['start_date'];

        $end_date = $_POST['end_date'];

        $amc_percentae = $_POST['amc_percentae'];

        $amcvalue = $_POST['amcvalue'];

        $bg_month = $_POST['bg_month'];
        $bg = $_POST['bg'];
        $demo = $_POST['demo'];
        $amc_required = $_POST['amc_required'];


        $po_no = $_POST['po_no'];
        // below old
        // $parts = explode('/', $po_no);
        // // Get the last value from the array
        // $po_num_value = end($parts);
        // $allowedExts = array('pdf');
        // $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);

        // if ($_FILES['po_file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
        //     // $tem_name = random_strings(25) . '.pdf';
        //     $tem_name = "PO-" . $po_num_value . '.pdf';
        //     move_uploaded_file($_FILES['po_file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
        //     // Set $file_names to the stored filename with .pdf extension
        //      $file_names = $tem_name;
        //      $file_org_names = $_FILES['po_file']['name'];
        // }

        // above old
if($_FILES['po_file']['name']){
        function makeSafePdfFilename(string $raw): string {
    // Replace slash with underscore
    $clean = str_replace('/', '_', $raw);

    // Strip out any characters except alphanumerics, dash, underscore, period, and space
    $clean = preg_replace('/[^A-Za-z0-9 _\-.]/', '', $clean);

    // Collapse multiple spaces into one
    $clean = preg_replace('/\s+/', ' ', $clean);

    // Trim leading/trailing separators
    $clean = trim($clean, " .-_");

    // Replace spaces with underscores
    $clean = str_replace(' ', '_', $clean);

    return $clean; // return without extension
}

// Example usage
$po_no = $_POST['po_no'] ?? '';
$po_num_value = makeSafePdfFilename($po_no);

$allowedExts = ['pdf'];
$extension = strtolower(pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION));

if ($_FILES['po_file']['type'] === 'application/pdf' && in_array($extension, $allowedExts)) {
    // Generate safe filename: PO-[po_num_value].pdf
    $random_id = uniqid(); // Generates a unique ID based on microtime
$tem_name = "PO-" . $po_num_value. '-' . $random_id . ".pdf";

    // $tem_name = "PO-" . $po_num_value . ".pdf";

    // Move uploaded file
    if (move_uploaded_file($_FILES['po_file']['tmp_name'], "../../uploads/po_form/po_attach/" . $tem_name)) {
         $file_names = $tem_name;                          // stored filename
         $file_org_names = $_FILES['po_file']['name'];    // original filename
    } else {
        die("Error moving uploaded file.");
    }
} else {
    die("Invalid file format. Only PDF allowed.");
}

}


        $amcpofile = $_POST['amcpofile'];

        $amcpofileparts = explode('/', $amcpofile);
        // Get the last value from the array
        $amcfile_value = end($amcpofileparts);
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['amcpofile']['name'], PATHINFO_EXTENSION);

        if ($_FILES['amcpofile']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            // $tem_name = random_strings(25) . '.pdf';
            $tem_name = "PO-" . $amcfile_value . '.pdf';
            move_uploaded_file($_FILES['amcpofile']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
            // Set $file_names to the stored filename with .pdf extension
            $amcfile_names = $tem_name;
            $amcfile_org_names = $_FILES['amcpofile']['name'];
        }

        $amcreqtable = 'amcrequired';


        $amccolumns = [

            'is_delete' => 1
        ];

        // print_r($file_names);die();
        $update_where = '';
        // print_r( $m_unique_id );
        if (($file_names) && ($file_org_names)) {

            $columns = [

                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_duration' => $warranty_duration,
                'ins_reqired' => $ins_reqired,
                'insurence_required' => $insurence_required,
                'insurence_types' => $insurence_types,
                'ld_required' => $ld_required,
                'ld_installation_due_date' => $ld_installation_due_date,
                'ld_delivery_due_date' => $ld_delivery_due_date,
                'ld_date_type' => $ld_date_type,
                'ld' => $ld,
                'ld' => $ld,
                'tat' => $tat,
                'amc' => $amc,
                'apd' => $apd,
                'amc_required' => $amc_required,
                'other_insurance_type' => $other_insurance_type,
                'bg' => $bg,
                'file_name' => $file_names,
                'file_org_name' => $file_org_names,



            ];
        } else {

            $columns = [

                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_duration' => $warranty_duration,
                'ins_reqired' => $ins_reqired,
                'insurence_required' => $insurence_required,
                'insurence_types' => $insurence_types,
                'ld_required' => $ld_required,
                'ld_installation_due_date' => $ld_installation_due_date,
                'ld_delivery_due_date' => $ld_delivery_due_date,
                'ld_date_type' => $ld_date_type,
                'ld' => $ld,
                'tat' => $tat,
                'amc' => $amc,
                'apd' => $apd,
                'amc_required' => $amc_required,
                'other_insurance_type' => $other_insurance_type,
                'bg_month' => $bg_month,



            ];
        }

        $update_where_amc = 'po_unique_id ="' . $demo . '"';
        if ($amc_required == '') {



            $amc_action_obj = $pdo->update($amcreqtable, $amccolumns, $update_where_amc);
        }
        // Update Begins
        if ($demo) {

            // unset( $columns['unique_id'] );

            // $update_where   = [
            //     'po_unique_id'     => $demo
            // ];
            $update_where = 'unique_id ="' . $demo . '"';

            $action_obj = $pdo->update($table, $columns, $update_where);
            // print_r($action_obj);
            // Update Ends
        }
        // print_r( $action_obj );
        // else {
        //     // Insert Begins

        //     $action_obj     = $pdo->insert($table, $columns );
        //     // Insert Ends
        // }
        // print_r($action_obj );
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

            if ($demo) {
                $msg = 'update';
            } else {
                $msg = 'create';
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'get_my_batchids2':

        $form_main_unique_id = $_POST['form_main_unique_id'];

        $batch_no_options = batch_nos($form_main_unique_id);

        $batch_no_options = select_option($batch_no_options, "Select");

        echo $batch_no_options;

        break;
    case 'get_my_batchids':
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $tested_data = batch_nos($form_main_unique_id);
        $demos = select_option_batch($tested_data, "Select Batch Number");
        echo $demos;
        break;

    case 'vendor_creation':


        $table = "vendor_allocation";

        $vendor_name = $_POST["vendor_name"];

        $po_code = $_POST["po_code"];
        $vendor_state_name = $_POST["vendor_state_name"];
        $vendor_district = $_POST["vendor_district"];
        $vendor_zone = $_POST["vendor_zone"];

        $unique_id = $_POST["unique_id"];
        if ($_POST["unique_id"] == '') {
            $ids = unique_id($prefix);
        } else if ($unique_id != '') {
            $ids = $unique_id;
        }

        $update_where = "";
        // $table_department = 'department_creation';
        $columns = [
            "vendor_name" => $vendor_name,
            "po_number" => $po_code,
            "state_name" => $vendor_state_name,
            "district" => $vendor_district,
            "zone" => $vendor_zone,
            "unique_id" => $ids
        ];
        // $table_details      = [
        //     $table,
        //     [
        //         'COUNT(unique_id) AS count'
        //     ]
        // ];
        // // $select_where       = ' is_delete = 0 AND department ="' . $department . '"';


        // $action_obj         = $pdo->select($table_details, $select_where);
        // // print_r( $action_obj );
        // if ($action_obj->status) {
        //     $status     = $action_obj->status;
        //     $data       = $action_obj->data;
        //     $error      = '';
        //     $sql        = $action_obj->sql;
        // } else {
        //     $status     = $action_obj->status;
        //     $data       = $action_obj->data;
        //     $error      = $action_obj->error;
        //     $sql        = $action_obj->sql;
        //     $msg        = 'error';
        // }
        // if ($data[0]['count']) {
        //     $msg        = 'already';
        // } else if (($data[0]['count'] == 0) && ($msg != 'error')) {

        // Insert Begins


        if ($_POST["unique_id"] == '') {
            $action_obj = $pdo->insert($table, $columns);
        } else {
            unset($columns['unique_id']);
            $update_where = [
                'po_number' => $po_code
            ];
            // $update_where =  'unique_id ="'.$unique_id.'"';
            $action_obj = $pdo->update($table, $columns, $update_where);
        }
        // Insert Ends
        // print_r($action_obj);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            // if ($unique_id) {
            //     $msg        = "update";
            // } else {
            $msg = "create";
            // }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }
        // }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);

        break;

        break;

    case 'department_cu':
        $department = $_POST["department"];
        $acc_sector = $_POST["acc_sector"];
        $is_active = $_POST["is_active1"];
        $unique_id = $_POST["unique_id"];

        $update_where = "";
        $table_department = 'department_creation';
        $columns = [
            "department" => $department,
            "acc_sector" => $acc_sector,
            "is_active" => $is_active,
            "unique_id" => $unique_id
        ];
        $table_details = [
            $table_department,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND department ="' . $department . '"';


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

            // Insert Begins

            $action_obj = $pdo->insert($table_department, $columns);
            // Insert Ends


            if ($action_obj->status) {
                $status = $action_obj->status;
                $data = $action_obj->data;
                $error = "";
                $sql = $action_obj->sql;

                // if ($unique_id) {
                //     $msg        = "update";
                // } else {
                $msg = "create";
                // }
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



    // product count
    case 'check_count':

        $uni_id = $_POST["uni_id"];

        $update_where = "";

        $columns = [];

        $table_details = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
            $data = $data[0]['count'];
            // $msg        = 'sub';

        }
        // else{
        //     $data =$data[0]['count'];
        //     $msg        = '';
        // }
        // else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {

        //     $data=$data[0]['count'];
        // }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;


    case 'get_state_name':

        $state_name = $_POST['state_id'];

        $district = $_POST['district'];

        $pre_state_options = district("", $state_name);

        $pre_state_option = select_option($pre_state_options, "Select the district", $district);

        echo $pre_state_option;

        break;


    case 'con_get_state_name':

        $state_name = $_POST['state_id'];

        // $district = $_POST['district'];

        $pre_state_options = district("", $state_name);

        $pre_state_option = select_option($pre_state_options, "Select the Consignee district");

        echo $pre_state_option;

        break;


    case 'up_con_get_state_name':

        $state_name = $_POST['state_id'];

        $district = $_POST['district'];

        $pre_state_options = district("", $state_name);

        $pre_state_option = select_option($pre_state_options, "Select the Consignee district", $district);

        echo $pre_state_option;

        break;



    case 'get_account_sector':

        $department = $_POST["department"];

        $update_where = "";

        $columns = [];

        $table_details = [
            "department_creation",
            [
                "acc_sector",
                "(select sector_name from account_sector where account_sector.unique_id=department_creation.acc_sector) as acc_sector_name",
            ]
        ];
        $select_where = ' is_delete = 0 AND unique_id ="' . $department . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
            $data = $data[0]['count'];
            // $msg        = 'sub';

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




    case 'get_customer':

        $department_options = department_creation_table();
        $department_options = select_option($department_options, "Select Customer");

        echo $department_options;

        break;






    // consignee count
    // product count
    case 'consignee_check_count':

        $uni_id = $_POST["uni_id"];

        $update_where = "";

        $columns = [];

        $table_details = [
            "consignee_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
            $data = $data[0]['count'];
            // $msg        = 'sub';

        }
        // else{
        //     $data =$data[0]['count'];
        //     $msg        = '';
        // }
        // else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {

        //     $data=$data[0]['count'];
        // }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;

    // check consignee count
    case 'no_of_consignee':

        $uni_id = $_POST["uni_id"];

        $update_where = "";

        $columns = [

            "no_of_consignee"
        ];

        $table_details = [
            "po_form",
            $columns
        ];
        $select_where = ' is_delete = 0 AND unique_id ="' . $uni_id . '"';


        $result = $pdo->select($table_details, $select_where);
        // print_r($result);

        $total_records = total_records();

        if ($result->status) {
            $s_no = 0;
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $stored_consignee = $value['no_of_consignee'];
            }
        }
        $data = array($stored_consignee);

        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'check_consignee':

        $uni_id = $_POST["uni_id"];

        $update_where = "";

        $columns = [];

        $table_details = [
            "consignee_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
        $data = array($data[0]['count']);
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;




    // end

    case 'check_product':

        $uni_id = $_POST["uni_id"];

        $update_where = "";

        $columns = [];

        $table_details = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
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
        $data = array($data[0]['count']);
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;

    // check item count
    case 'no_of_item':

        $uni_id = $_POST["uni_id"];

        $columns = [
            "no_of_po"
        ];

        $table_details = [
            "po_form",
            $columns
        ];
        $select_where = ' is_delete = 0 AND unique_id ="' . $uni_id . '"';


        $result = $pdo->select($table_details, $select_where);
        // print_r($result);die();

        $total_records = total_records();

        if ($result->status) {
            $s_no = 0;
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $stored_consignee = $value['no_of_po'];
            }
        }
        $data = array($stored_consignee);

        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];

        echo json_encode($json_array);

        break;




    //   cancel po

    case 'po_cancel_datatable':
        // DataTable Variables
        // echo "";

        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];
        $month_fill = $_POST["month_fill"];
        // echo $month_fill;
        $month_val = date("F/Y", strtotime($month_fill));

        // $date_format = strtotime($month_val);

        // $new_date = date("Y-m",$date_format);

        $date = new DateTime($month_fill);


        $date->modify('-1 month');


        $dec_date = $date->format('Y-m');


        if ($length == '-1') {
            $limit = '';
        }
        $table_po = "po_form";
        // Query Variables
        $json_array = '';
        $columns = [
            "'' as  s_no",
            'po_num',
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            '(SELECT state_name FROM state_creation AS dis WHERE dis.unique_id =' . $table_po . '.state_name) AS state_name',
            '(SELECT district_name FROM district_creation AS dis WHERE dis.unique_id =' . $table_po . '.district ) AS district',
            '(SELECT department FROM department_creation AS dis WHERE dis.unique_id =' . $table_po . '.department ) AS department',
            'gst_value',
            '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id =' . $table_po . '.executive_name ) AS executive_name',
            '(SELECT sum(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS total_value ',
            'po_cancel_file',
            "file_org_name",
            'unique_id',
        ];
        $table_details = [
            $table_po,
            $columns
        ];


        $where = " is_delete = '1' AND reject_reason!=''";
        
$user=$_SESSION["unique_id"];
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
  if ($user_type_unique_id =='69b0115ced3bd96390'){
            $where .= " AND executive_name = '$user'";

        }
        // $dec_date = $date->format('Y-m');
        // if($month_fill != ''){
        //     $where = "DATE_FORMAT(po_date, '%Y-%m') LIKE '%".$month_fill."%'";
        // }

        // $order_by ="id desc";
        $order_column = $_POST['order'][0]['column'];
        $order_dir = $_POST['order'][0]['dir'];

        // Datatable Ordering
        $order_by = datatable_sorting_po($order_column, $order_dir, $columns);

        // $order_by = "unique_id $order_dir";
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";




        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= 'AND ';
            }

            $where .= $search;
        }

        $sql_function = 'SQL_CALC_FOUND_ROWS';
        // $result= $pdo->select($table_details, $where, $limit, $start, 'po_num DESC,'. $order_by, $sql_function);
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                // $value['state_name'] = disname( $value['state_name'] );
                $po_num = $value['po_num'];
                $total_value = $value['total_value'];
                $value['total_value'] = '<div style="text-align:right;"><span>' . moneyFormatIndia1(($total_value)) . '</span></div>';
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                // echo $value['cnt'];
                // if($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['delivery_due_dates']=='' || $value['file_name']==''){
                //     $value['po_num']='<span style="color:#da1c34;"
                //     >'.$po_num.'</span>';
                // echo "cnt: " . $value['cnt'] . ", cnt1: " . $value['cnt1'] . ", cnt2: " . $value['cnt2'];

                // $value['po_num'] = '<span style="color:red">'.$po_num.'</span>';
                // }else{
                //     $value['po_num'] = $po_num;
                // }
                // $value['po_num']='<span style="color:#da1c34;"
                //     ></span>';

                $gst_value = $value['gst_value'];
                if ($gst_value == '') {
                    $value['gst_value'] = "Unregistered";
                }


                $file_name = $value['file_name'];
                $value['po_cancel_file'] = image_view_4("po_form", $value['invoice_unique_id'], $value['po_cancel_file']);


                $value['is_active'] = is_active_show($value['is_active']);
                // $orgDate = $value['po_date'];  
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));  

                // $where_1      = [
                //     "form_main_unique_id" => $value['unique_id']
                // ];
                $where_1 = "form_main_unique_id='" . $value['unique_id'] . "'";
                // ORDER BY unique_id DESC

                $table_1 = "stock_position_main";

                $columns_1 = [
                    'COUNT(form_main_unique_id) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_1
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_1);
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;
                $btn_update = btn_update($folder_name, $value['unique_id']);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                // $value['file_org_name'] = '<a href="index.php?file=po_form/po_cancel&unique_id=' . $value['unique_id'] . '"><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2">Cancel</button></a>';

                // $btn_view           = btn_cancel($folder_name );
                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    if ($data_st[0]['count']) {
                        $value['unique_id'] = "";
                    } else {
                        $value['unique_id'] = $btn_update . $btn_delete;
                    }
                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    $value['unique_id'] = $btn_update . $btn_delete;
                }


                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'po_cancel_add_update':
        $table_po = 'po_form';
        // $payement_receive          = $_POST["payement_receive"];
        //$under_user_type    = $_POST["under_user_type"];
        $reject_reason = $_POST["reject_reason"];

        $unique_id = $_POST["unique_id"];

        $update_where_cancel = "";
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = random_strings(25) . '.pdf';

            move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
        if (($file_names) && ($file_org_names)) {
            $columns_cancel = [
                "reject_reason" => $reject_reason,
                "is_delete" => 1,
                // "payment_status"     => $payment_status,
                // "payment_date"           => $payment_date,
                // "ld_amount"           => $ld_amount,
                // "ld_days"           => $ld_days,
                // "claim_percentage"           => $claim_amount,
                'po_cancel_file' => $file_names,
                'po_cancel_file_orgname' => $file_org_names,


            ];
        } else {
            $columns_cancel = [
                "reject_reason" => $reject_reason,
                "is_delete" => 1,
            ];
        }




        $where = " is_delete = '1' AND reject_reason!=''";


        $table_product = 'product_details_sub';
        $columns1 = [
            "is_delete" => 1
        ];

        $select_where2 = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_product = $pdo->update($table_product, $columns1, $select_where2);


        $table_con = 'consignee_details_sub';
        $columns_con = [
            "is_delete" => 1
        ];

        $select_where3 = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_con = $pdo->update($table_con, $columns_con, $select_where3);

        $table_product_assign = 'po_product_assign_details';
        $columns_assign = [
            "is_delete" => 1
        ];

        $select_where4 = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_assign = $pdo->update($table_product_assign, $columns_assign, $select_where4);


        $table_stock = 'stock_position';
        $columns_stock = [
            "is_delete" => 1
        ];

        $select_where_stk = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_stk = $pdo->update($table_stock, $columns_stock, $select_where_stk);


        $table_stock_main = 'stock_position_main';
        $columns_stock_main = [
            "is_delete" => 1
        ];

        $select_where_stk_main = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_stk_main = $pdo->update($table_stock_main, $columns_stock_main, $select_where_stk_main);

        $table_stock_sublist = 'stock_position_sublist';
        $columns_stock_sub = [
            "is_delete" => 1
        ];

        $select_where_stk_sub = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_stk_main = $pdo->update($table_stock_sublist, $columns_stock_sub, $select_where_stk_sub);

        $table_inv = 'invoice_creation';
        $columns_inv = [
            "is_delete" => 1
        ];

        $select_where_inv = "po_unique_id = '" . $unique_id . "'";
        $action_obj_inv = $pdo->update($table_inv, $columns_inv, $select_where_inv);


        $table_inv_main = 'invoice_creation_main';
        $columns_inv_main = [
            "is_delete" => 1
        ];

        $select_where_inv_main = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_inv = $pdo->update($table_inv_main, $columns_inv_main, $select_where_inv_main);

        $table_inv_sub = 'invoice_sublist';
        $columns_inv_sub = [
            "is_delete" => 1
        ];

        $select_where_inv_sub = "form_main_unique_id = '" . $unique_id . "'";
        $action_obj_sub = $pdo->update($table_inv_sub, $columns_inv_sub, $select_where_inv_sub);



        // Update Begins
        if ($unique_id) {

            // $update_where   = [
            //     "bill_form_unique_id"     => $unique_id,
            // ];
            $update_where_cancel = "unique_id='" . $unique_id . "'";

            $action_obj = $pdo->update($table_po, $columns_cancel, $update_where_cancel);
            // print_r($action_obj);

            // Update Ends
        }
        // print_r($action_obj_cancel);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($unique_id) {
                $msg = "update";
            }
            // else {
            //     $msg        = "create";
            // }
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


    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
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
        echo "fff";
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);
        // print_r($table_users);die();

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
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

    case 'delete':

        $unique_id = $_POST['unique_id'];
        $columns = [
            'is_delete' => 1
        ];

        $update_where = [
            'unique_id' => $unique_id
        ];

        $table_details = [
            "stock_position",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];

        $select_where = 'is_delete = 0 AND form_main_unique_id ="' . $unique_id . '"';

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
            $msg = 'stock';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            $action_data = $pdo->update($table, $columns, $update_where);


            if ($action_data->status) {
                $status = $action_data->status;
                $data = $action_data->data;
                $error = '';
                $sql = $action_data->sql;
                $msg = 'success_delete';
            } else {
                $status = $action_data->status;
                $data = $action_data->data;
                $error = $action_data->error;
                $sql = $action_data->sql;
                $msg = 'error';
            }
        }
        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);
        break;

    //  case 'user_type_options':

    // $user_type          = $_POST['user_type'];

    // $user_type_options  = under_user_type( $user_type );

    // $user_type_options  = select_option( $user_type_options, 'Select' );

    // echo $user_type_options;

    // break;

    case 'product_details_add_update':
        $no_of_items = $_POST['no_of_po'];
        $tender_code = $_POST['tender_code'];

        $item_code = $_POST['item_code'];
        $po_name = $_POST['po_name'];
        $qty = $_POST['qty'];
        $unit_price = $_POST['unit_price'];
        $warranty_starts = $_POST['warranty_starts'];
        $document_required = $_POST['document_required'];
        $tax = $_POST['tax'];
        $total_value = $_POST['total_value'];
        $net_price = $_POST['net_price'];
        $net_value = $_POST['net_value'];
        $insta_due_days = $_POST['insta_due_days'];
        $ld_type = $_POST['ld_type'];
        $bg_required = $_POST['bg_required'];
        // end
        $bg_percen = $_POST['bg_percen'];

        $bg_month = $_POST['bg_month'];
        // new changes
        $delivery_due_dates = $_POST['delivery_due_dates'];
        $ld_per_day = $_POST['ld_per_day'];
        $ld_maximum_val = $_POST['ld_maximum_val'];
        $warranty = $_POST['warranty'];
        $warranty_duration = $_POST['warranty_duration'];
        // end 

        $form_main_unique_id = $_POST['form_main_unique_id'];

        $unique_id = $_POST['unique_id'];









        $update_where = '';
        // print_r( 'hii'.$po_name );
        if ($unique_id == "") {
            $columns = [
                'tender_code' => $tender_code,
                'item_code' => $item_code,
                'product' => $po_name,
                'qty' => $qty,
                'unit_price' => $unit_price,
                'tax' => $tax,
                'total_value' => $total_value,
                'net_value' => $net_value,
                'net_price' => $net_price,
                'no_of_items' => $no_of_items,
                'ld_type' => $ld_type,
                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'document_required' => $document_required,
                'warranty_duration' => $warranty_duration,
                'warranty_starts' => $warranty_starts,
                'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' => $bg_percen,
                'bg_month' => $bg_month,
                'form_main_unique_id' => $form_main_unique_id,
                // 'rem_qty'                   => $qty,
                'unique_id' => unique_id($prefix)
            ];
        } else {
            $columns = [
                'tender_code' => $tender_code,
                'item_code' => $item_code,
                'product' => $po_name,
                'qty' => $qty,
                'unit_price' => $unit_price,
                'tax' => $tax,
                'total_value' => $total_value,
                'net_value' => $net_value,
                'net_price' => $net_price,
                'no_of_items' => $no_of_items,
                'ld_per_day' => $ld_per_day,
                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_starts' => $warranty_starts,
                'warranty_duration' => $warranty_duration,
                'document_required' => $document_required,
                'ld_type' => $ld_type,
                //  'warranty_duration' => $warranty_duration,
                'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' => $bg_percen,
                'bg_month' => $bg_month,
                'warranty_starts' => $warranty_starts,
                'form_main_unique_id' => $form_main_unique_id,
                // 'rem_qty'                   => $qty,
                'unique_id' => unique_id($prefix)
            ];
        }






        if ($unique_id != "" && $warranty != '1') {
            $columns_new = [
                'warranty_duration' => "",
            ];
            $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
            $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
        } else {
            $columns_new = [
                'warranty_duration' => $warranty_duration,
            ];
            $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
            $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
        }
        // check already Exist Or not
        $table_details = [
            $table_product_details,
            [
                'COUNT(unique_id) AS count'
                // 'qty',
            ]
        ];
        $select_where = 'is_delete = 0 AND product ="' . $po_name . '" AND unique_id ="' . $unique_id . '" ';

        // When Update Check without current id
        // if ( $unique_id ) {
        //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        // }

        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $stored_qty = isset($data[0]['qty']) ? (int) $data[0]['qty'] : 0;
            $new_qty = (int) $qty;
            $error = '';
            $sql = $action_obj->sql;
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        //  else if (($data[0]['count'] == 0) && ($msg != 'error')) {
        // Update Begins
        if ($unique_id) {

            unset($columns['unique_id']);

            $update_where = [
                'unique_id' => $unique_id
            ];

            // $update_where_po   = [
            //     'form_main_unique_id'     => $form_main_unique_id,
            //     "product_unique_id" => $unique_id
            // ];

            // $update_columns_po = [

            //     "qty" => $qty

            //     ];


            // if($new_qty >= $stored_qty){
            $action_obj = $pdo->update($table_product_details, $columns, $update_where);
            $stmtCus = $conn->prepare("CALL po_total_values_updates(:form_id)");

            $stmtCus->bindParam(':form_id', $form_main_unique_id, PDO::PARAM_STR);
            // $stmtCus->bindParam(':qty', $qty, PDO::PARAM_INT);
            // $stmtCus->bindParam(':total_value', $total_value, PDO::PARAM_STR);

            $stmtCus->execute();
            //  $action_obj_po     = $pdo->update('po_product_assign_details', $update_columns_po, $update_where_po);
            // }else{
            //     $msg = 'invalid_quantity';
            // }

            // Update Ends
        } else {
            //   if($data[0]['count'] != 0) {
            //         $msg        = 'already';
            //     } 
            // else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            $table_details1 = [
                'product_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where = ' is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

            $total_record = $pdo->select($table_details1, $count_where);

            $data_record = $total_record->data;

            if ($data_record[0]['count'] == $_POST['no_of_po']) {
                $msg = 'product';
            } else {
                // procedure 
                // $stmtCus = $conn->prepare("CALL po_total_values_update(:form_id, :qty, :total_value)");
                //     $stmtCus->bindParam(':form_id', $form_main_unique_id,':qty', $qty, ':total_value', $total_value);
                //     $stmtCus->execute();




                // Insert Begins
                $action_obj = $pdo->insert($table_product_details, $columns);
                $stmtCus = $conn->prepare("CALL po_total_values_update(:form_id, :qty, :total_value)");

                $stmtCus->bindParam(':form_id', $form_main_unique_id, PDO::PARAM_STR);
                $stmtCus->bindParam(':qty', $qty, PDO::PARAM_INT);
                $stmtCus->bindParam(':total_value', $total_value, PDO::PARAM_STR);

                $stmtCus->execute();
                $msg = 'add';
                // Insert Ends

            }
        }
        // print_r( $action_obj );
        // Insert Ends

        // }
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

    // product details

    case 'product_details_add_update_main':
        $no_of_items = $_POST['no_of_po'];
        $tender_code = $_POST['tender_code'];

        $item_code = $_POST['item_code'];
        $po_name = $_POST['po_name'];
        $qty = $_POST['qty'];
        $unit_price = $_POST['unit_price'];
        $warranty_starts = $_POST['warranty_starts'];
        $document_required = $_POST['document_required'];
        $tax = $_POST['tax'];
        $total_value = $_POST['total_value'];
        $net_price = $_POST['net_price'];
        $net_value = $_POST['net_value'];
        $insta_due_days = $_POST['insta_due_days'];
        $ld_type = $_POST['ld_type'];
        $bg_required = $_POST['bg_required'];
        // end
        $bg_percen = $_POST['bg_percen'];

        $bg_month = $_POST['bg_month'];
        // new changes
        $delivery_due_dates = $_POST['delivery_due_dates'];
        $ld_per_day = $_POST['ld_per_day'];
        $ld_maximum_val = $_POST['ld_maximum_val'];
        $warranty = $_POST['warranty'];
        $warranty_duration = $_POST['warranty_duration'];
        // end 

        $form_main_unique_id = $_POST['form_main_unique_id'];

        $unique_id = $_POST['unique_id'];









        $update_where = '';
        // print_r( 'hii'.$po_name );
        if ($unique_id == "") {
            $columns = [
                'tender_code' => $tender_code,
                'item_code' => $item_code,
                'product' => $po_name,
                'qty' => $qty,
                'unit_price' => $unit_price,
                'tax' => $tax,
                'total_value' => $total_value,
                'net_value' => $net_value,
                'net_price' => $net_price,
                'no_of_items' => $no_of_items,
                'ld_type' => $ld_type,
                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'document_required' => $document_required,
                'warranty_duration' => $warranty_duration,
                'warranty_starts' => $warranty_starts,
                'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' => $bg_percen,
                'bg_month' => $bg_month,
                'form_main_unique_id' => $form_main_unique_id,
                // 'rem_qty'                   => $qty,
                'unique_id' => unique_id($prefix)
            ];
        } else {
            $columns = [
                'tender_code' => $tender_code,
                'item_code' => $item_code,
                'product' => $po_name,
                'qty' => $qty,
                'unit_price' => $unit_price,
                'tax' => $tax,
                'total_value' => $total_value,
                'net_value' => $net_value,
                'net_price' => $net_price,
                'no_of_items' => $no_of_items,
                'ld_per_day' => $ld_per_day,
                'delivery_due_dates' => $delivery_due_dates,
                'ld_per_day' => $ld_per_day,
                'ld_maximum_val' => $ld_maximum_val,
                'warranty' => $warranty,
                'document_required' => $document_required,
                'ld_type' => $ld_type,
                //  'warranty_duration' => $warranty_duration,
                'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' => $bg_percen,
                'bg_month' => $bg_month,
                'warranty_starts' => $warranty_starts,
                'form_main_unique_id' => $form_main_unique_id,
                // 'rem_qty'                   => $qty,
                'unique_id' => unique_id($prefix)
            ];
        }






        if ($unique_id != "" && $warranty != '1') {
            $columns_new = [
                'warranty_duration' => "",
            ];
            $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
            $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
        } else {
            $columns_new = [
                'warranty_duration' => $warranty_duration,
            ];
            $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
            $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
        }
        // check already Exist Or not
        $table_details = [
            $table_product_details,
            [
                'COUNT(unique_id) AS count'
                // 'qty',
            ]
        ];
        $select_where = 'is_delete = 0 AND product ="' . $po_name . '" AND unique_id ="' . $unique_id . '" ';

        // When Update Check without current id
        // if ( $unique_id ) {
        //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        // }

        $action_obj = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $stored_qty = isset($data[0]['qty']) ? (int) $data[0]['qty'] : 0;
            $new_qty = (int) $qty;
            $error = '';
            $sql = $action_obj->sql;
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        //  else if (($data[0]['count'] == 0) && ($msg != 'error')) {
        // Update Begins
        if ($unique_id) {

            unset($columns['unique_id']);

            $update_where = [
                'unique_id' => $unique_id
            ];

            // $update_where_po   = [
            //     'form_main_unique_id'     => $form_main_unique_id,
            //     "product_unique_id" => $unique_id
            // ];

            // $update_columns_po = [

            //     "qty" => $qty

            //     ];


            // if($new_qty >= $stored_qty){
            $action_obj = $pdo->update($table_product_details, $columns, $update_where);
            //  $action_obj_po     = $pdo->update('po_product_assign_details', $update_columns_po, $update_where_po);
            // }else{
            //     $msg = 'invalid_quantity';
            // }

            // Update Ends
        } else {
            //   if($data[0]['count'] != 0) {
            //         $msg        = 'already';
            //     } 
            // else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            $table_details1 = [
                'product_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where = ' is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

            $total_record = $pdo->select($table_details1, $count_where);

            $data_record = $total_record->data;

            if ($data_record[0]['count'] == $_POST['no_of_po']) {
                $msg = 'product';
            } else {
                // Insert Begins
                $action_obj = $pdo->insert($table_product_details, $columns);
                $msg = 'add';
                // Insert Ends

            }
        }
        // print_r( $action_obj );
        // Insert Ends

        // }
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

    case 'product_details_datatable':

        // Function Name button prefix
        $btn_edit_delete = 'product_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search = $_POST['search']['value'];

        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];

        if ($length == '-1') {
            $limit = '';
        }

        // Query Variables
        $json_array = '';
        $columns = [
            // '@a:=@a+1 s_no',
            '"" as s_no',
            'tender_code',
            // "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details.item_code group by item_creation_sub.unique_id)as item_code",
            'get_item_name(item_code) as item_code',

            'product',
            'qty',
            'unit_price',
            'net_price',
            'tax',
            'net_value',
            'total_value',
            'delivery_due_dates',
            'insta_due_days',
            'ld_type',
            'ld_per_day',
            'ld_maximum_val',
            'warranty',

            // 'warranty_duration',
            // "(select warrenty_year from product_warrenty where product_warrenty.unique_id=$table_product_details.warranty_duration group by product_warrenty.unique_id) as warranty_duration",
            "(select warranty_in_yrs from item_creation_sub where item_creation_sub.unique_id=$table_product_details.item_code) as warranty_duration",
            
            'document_required',
            'warranty_starts',
            'bg_required',
            'bg_percen',
            'bg_month',
            'unique_id',
            'form_main_unique_id',
            "(select status from po_form where po_form.unique_id=$table_product_details.form_main_unique_id group by po_form.unique_id) as po_status",
        ];

        $table_details = [
            $table_product_details,
            $columns
        ];
       

        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

        
        $order_by = '';

        $sql_function = 'SQL_CALC_FOUND_ROWS';

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $sum_net_value += floatval($value['net_value']);
                $sum_total_value += floatval($value['total_value']);

                if ($value['warranty'] == 1) {
                    $value['warranty'] = 'yes';
                } else {
                    $value['warranty'] = 'no';
                }
                $where_1 = [
                    "form_main_unique_id" => $value['unique_id']
                ];

                $table_1 = "stock_position_main";

                $columns_1 = [
                    'COUNT(form_main_unique_id) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_1
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_1);
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;

                $btn_edit = btn_edit($btn_edit_delete, $value['unique_id']);
                $btn_delete = btn_delete_pro($btn_edit_delete, $value['unique_id'], $value['form_main_unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    if ($data_st[0]['count']) {
                        $value['unique_id'] = "";
                    } else {
                        $value['unique_id'] = $btn_edit . $btn_delete;
                    }
                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    $value['unique_id'] = $btn_edit . $btn_delete;
                }
                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {

                    $value['unique_id'] = $btn_edit;
                }
                // operateam unique_id
                if ($_SESSION['user_type_unique_id'] == "65efd97b4df4040205" && $value['po_status'] == '2') {
                    if ($data_st[0]['count']) {
                        $value['unique_id'] = "";
                    } else {
                        $value['unique_id'] = "";
                    }
                }

                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'sum_net_value' => $sum_net_value,   // Include sum of net_value
                'sum_total_value' => $sum_total_value, // Include sum of total_value
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;



    case 'product_details_edit':
        // Fetch Data
        $unique_id = $_POST['unique_id'];
        $data = [];

        // Query Variables
        $json_array = '';
        $columns = [
            // '@a:=@a+1 s_no',
            'tender_code',
            "(select item_code from item_creation_sub where item_creation_sub.unique_id=$table_product_details.item_code) as item_code_name",
            'item_code',
            'product',
            'qty',
            'unit_price',
            'net_price',
            'tax',
            'total_value',
            'net_value',
            'delivery_due_dates',
            'ld_per_day',
            'ld_maximum_val',
            'warranty',
            'document_required',
            'insta_due_days',
            'warranty_starts',
            'bg_required',
            'bg_percen',
            'bg_month',
            'ld_type',
            'net_value',
            // 'warranty_duration',
            "(select warranty_duration from product_warrenty where product_warrenty.unique_id=$table_product_details.warranty_duration) as warranty_duration",

            'unique_id'
        ];
        $table_details = [
            $table_product_details,
            $columns
        ];
        $where = [
            'unique_id' => $unique_id,
            'is_active' => 1,
            'is_delete' => 0
        ];

        $result = $pdo->select($table_details, $where);
        // print_r($result);

        if ($result->status) {

            $json_array = [
                'data' => $result->data[0],
                'status' => $result->status,
                'sql' => $result->sql,
                'error' => $result->error,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;


    case 'get_verify_status':

        $batch_id = $_POST['batch_id'];

        $columns = [
            'cons_verify_sts' => 1,
        ];

        $update_where = [
            'batch_id' => $batch_id
        ];

        $action_obj = $pdo->update('consignee_details_sub', $columns, $update_where);
        // print_r($action_obj);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            $msg = 'update';
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'product_details_delete':

        $unique_id = $_POST['unique_id'];

        $form_main_id = $_POST['form_main_id'];

        $columns = [
            'is_delete' => 1,
        ];

        $update_where = [
            'unique_id' => $unique_id
        ];

        $action_obj = $pdo->update($table_product_details, $columns, $update_where);

        $stmtCus = $conn->prepare("CALL po_total_values_updates(:form_id)");

        $stmtCus->bindParam(':form_id', $form_main_id, PDO::PARAM_STR);
        // $stmtCus->bindParam(':qty', $qty, PDO::PARAM_INT);
        // $stmtCus->bindParam(':total_value', $total_value, PDO::PARAM_STR);

        $stmtCus->execute();

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            $msg = 'success_delete';
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

    // Consignee sublist

    case 'consignee_details_add_update_old':

        $no_of_consignee = $_POST['no_of_consignee'];
        // $con_qty              = $_POST['con_qty'];
        $con_address = $_POST['con_address'];
        $con_district = $_POST['con_district'];
        $con_pincode = $_POST['con_pincode'];
        $consignee_gst = $_POST['consignee_gst'];
        $con_contact_name = $_POST['con_contact_name'];
        $con_contact_number = $_POST['con_contact_number'];
        $con_lan_num = $_POST['con_lan_num'];
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $zone = $_POST['zone'];
        $cons_verify_sts = $_POST['cons_verify_sts'];
        $unique_id = $_POST['unique_id'];
        $update_where = '';


        // print_r($con_district );die();
        $columns = [
            'no_of_consignee' => $no_of_consignee,
            // 'con_qty'           => $con_qty,
            'con_address' => $con_address,
            'consignee_gst' => $consignee_gst,
            'con_district' => $con_district,
            'con_pincode' => $con_pincode,
            'con_contact_name' => $con_contact_name,
            'con_contact_number' => $con_contact_number,
            'con_lan_num' => $con_lan_num,
            'form_main_unique_id' => $form_main_unique_id,
            'zone' => $zone,
            'cons_verify_sts' => $cons_verify_sts,
            'unique_id' => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details = [
            $table_consignee_details,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        // $select_where       = ' is_delete = 0 AND con_contact_number ="' . $con_contact_number . '"';
        // if ($unique_id) {
        //     $select_where   .= ' AND unique_id !="' . $unique_id . '" ';
        // }

        // print_r( $form_main_unique_id_count );
        // When Update Check without current id
        // if ( $unique_id ) {
        //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        // }

        $select_where = ' is_delete = 0 AND con_address ="' . $con_address . '"  AND form_main_unique_id ="' . $form_main_unique_id . '"';
        // AND con_address ="'.$con_address .'"  and form_main_unique_id ="' . $form_main_unique_id . '"
        //  


        $action_obj = $pdo->select($table_details, $select_where);
        // // print_r( $action_obj );
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

        // Update Begins
        if ($unique_id) {

            unset($columns['unique_id']);
            $table_product_po = 'po_product_assign_details';
            $columns_po = [
                "con_name" => $con_contact_name,
                "con_contact_no" => $con_contact_number,

            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" and con_unique_id="' . $unique_id . '" ';
            $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);
            // print_r(

            $update_where = [
                'unique_id' => $unique_id
            ];


            $action_obj = $pdo->update($table_consignee_details, $columns, $update_where);
            // print_R($action_obj );die();
            // Update Ends
        }
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {
            // else{
            $table_details1 = [
                'consignee_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where = 'is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

            // print_r( $form_main_unique_id_count );
            // When Update Check without current iassign_qty
            // if ( $unique_id ) {
            //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
            // }

            $total_record = $pdo->select($table_details1, $count_where);
            // print_r( $total_record );

            $data_record = $total_record->data;

            if ($data_record[0]['count'] == $_POST['no_of_consignee']) {
                $msg = 'e_already';
            } else {
                // Insert Begins
                $action_obj = $pdo->insert($table_consignee_details, $columns);
                $msg = 'add';
                // Insert Ends

            }
        }

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            if ($unique_id) {
                $msg = "update";
            } else {
                $msg = "add";
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


    case 'get_lddates':

        $form_main_unique_id = $_POST['m_unique_id'];

        // DataTable
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? '' : $length;

        $data = [];
        $json_array = [];
        $sno = $start + 1;

        // Columns to select
        $columns_po = ['po_date'];
        $columns_product = ['insta_due_days', 'delivery_due_dates'];
        $columns_consig = ['consignee_received_date'];

        // Table details
        $table_details_po = [$table, $columns_po];
        $table_details_product = [$table_product_details, $columns_product];
        $table_details_consig = [$table_consignee_details, $columns_consig];

        // Common WHERE clause
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id = "' . $form_main_unique_id . '"';
        $powhere = 'is_active = 1 AND is_delete = 0 AND unique_id = "' . $form_main_unique_id . '"';
        $order_by = '';
        $sql_function = 'SQL_CALC_FOUND_ROWS';
        $last_consig_order_by = 'id DESC';
        // Fetch from all tables
        $po_result = $pdo->select($table_details_po, $powhere, $limit, $start, $order_by, $sql_function);
        $product_result = $pdo->select($table_details_product, $where, $limit, $start, $order_by, $sql_function);
        $consig_result = $pdo->select($table_details_consig, $where, $limit, $start, $last_consig_order_by, $sql_function);

        $total_records = total_records();

        // If all successful
        if ($po_result->status && $product_result->status && $consig_result->status) {

            $po_data = $po_result->data;
            $product_data = $product_result->data;
            $consig_data = $consig_result->data;

            // Assuming the data from all 3 are row-wise matched (index 0 in all 3 corresponds to the same row)
            $max_rows = max(count($po_data), count($product_data), count($consig_data));

            for ($i = 0; $i < $max_rows; $i++) {
                $row = [];

                $row[] = $po_data[$i]['po_date'] ?? '';
                $row[] = $product_data[$i]['insta_due_days'] ?? '';
                $row[] = $product_data[$i]['delivery_due_dates'] ?? '';
                $row[] = $consig_data[$i]['consignee_received_date'] ?? '';

                $data[] = $row;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => [
                    'po_sql' => $po_result->sql,
                    'product_sql' => $product_result->sql,
                    'consig_sql' => $consig_result->sql,
                ]
            ];
        } else {
            // Debug: show error if any of the results failed
            echo json_encode([
                'error' => 'One or more queries failed.',
                'po_result' => $po_result,
                'product_result' => $product_result,
                'consig_result' => $consig_result
            ]);
            exit;
        }

        echo json_encode($json_array);
        break;



    case 'consignee_details_datatable_old':
        // Function Name button prefix
        $btn_edit_delete = 'consignee_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search = $_POST['search']['value'];

        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];

        if ($length == '-1') {
            $limit = '';
        }

        // Query Variables
        $json_array = '';
        $columns = [
            // '@a:=@a+1 s_no',
            '"" as s_no',
            // 'no_of_consignee',
            // 'con_qty',
            'con_address',
            // "con_district",
            // "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
            "IFNULL(
        (SELECT district_name 
         FROM district_creation 
         WHERE district_creation.unique_id = consignee_details_sub.con_district group by district_name), 
        '') AS district_name",
            'con_pincode',
            'zone',
            'con_contact_name',
            'con_contact_number',

            "con_lan_num",
            "consignee_gst",
            "cons_verify_sts",
            // "zone",
            'unique_id'
        ];
        $table_details = [
            // $table_consignee_details . ' , (SELECT @a:= ' . $start . ') AS a ',
            $table_consignee_details,
            $columns
        ];
        $where = [
            'is_active' => 1,
            'is_delete' => 0,
        ];

        // $where = [];
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';
        $order_by = '';

        $sql_function = 'SQL_CALC_FOUND_ROWS';

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;

                $verify_sts = $value['cons_verify_sts'];

                if ($verify_sts == '2') {
                    $value['cons_verify_sts'] = 'Not Verified';
                } elseif ($verify_sts == '1') {
                    $value['cons_verify_sts'] = 'Verified';
                }
                $btn_edit = btn_edit($btn_edit_delete, $value['unique_id']);
                $btn_delete = btn_delete($btn_edit_delete, $value['unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    if ($data_st[0]['count']) {
                        $value['unique_id'] = "";
                    } else {
                        $value['unique_id'] = $btn_edit . $btn_delete;
                    }
                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    $value['unique_id'] = $btn_edit . $btn_delete;
                }
                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;





    case 'amc_table_datatable':

        $form_main_unique_id = $_POST['form_main_unique_id'];
 $btn_edit_delete = 'amcrequired';
        // DataTable Parameters
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? '' : $length;





        $amctable = 'amcrequired';
        $data = [];
        $sno = $start + 1; // Initialize serial number properly
        // $tableamcrequired="amcrequired";
        // Query Variables
        $columns = [
            '"" as s_no',
            'start_date',
            'end_date',
            'amc_percentae',
            'amcvalue',
            'amc_tax',
            'amc_unit_price',
            'amc_remarks',
            'amcfile_names',
            "(Select file_name from po_form where po_form.unique_id = amcrequired.po_unique_id and po_form.is_delete = 0 ) as po_file_name",
'unique_id',
            'amcfile_org_names',

            'po_unique_id',
            

            // "select"
        ];

        $table_details = [
            $amctable,
            $columns
        ];

        $where = 'is_delete = 0 AND po_unique_id = "' . $form_main_unique_id . '"';
        $order_by = '';

        $sql_function = 'SQL_CALC_FOUND_ROWS';

        // Fetch Data
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r( $result );
        $total_records = total_records();

        if ($result->status) {
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = '<div style="text-align:right;">' . $sno++ . '</div>';

                $value['amc_percentae'] = '<div style="text-align:right;">' . $value['amc_percentae'] . '</div>';
                $value['amcvalue'] = '<div style="text-align:right;">' . moneyFormatIndia1($value['amcvalue']) . '</div>';
$value['amc_unit_price'] = '<div style="text-align:right;">' . moneyFormatIndia1($value['amc_unit_price']) . '</div>';
$value['amc_tax'] = '<div style="text-align:right;">' . $value['amc_tax'] .'%'. '</div>';
$value['amc_remarks'] = '<div style="text-align:center;">' . $value['amc_remarks'] .'%'. '</div>';

                $file_name = $value['amcfile_names'];
                $po_file_name = $value['po_file_name'];
$value['start_date'] = isset($value['start_date']) && !empty($value['start_date']) 
    ? date('d-m-Y', strtotime($value['start_date'])) 
    : '';

$value['end_date'] = isset($value['end_date']) && !empty($value['end_date']) 
    ? date('d-m-Y', strtotime($value['end_date'])) 
    : '';




                //  $pofile_name =  $value['po_file_name'];
                $value['po_file_name'] = image_view_4("po_attach", $value['unique_id'], $value['po_file_name']);

                $value['amcfile_names'] = image_view_amc("amc", $value['unique_id'], $value['amcfile_names']);
 $btn_delete = btn_delete($btn_edit_delete, $value['unique_id']);

                $value['unique_id'] = $btn_delete;
                $data[] = array_values($value);
            }
        }

        // JSON Response
        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => intval($total_records),
            'recordsFiltered' => intval($total_records),
            'data' => $data,
            'query' => $result->sql // Keeping query for debugging
        ]);

        break;

  case 'amc_required_delete':

             $table = "amcrequired";
         $unique_id  = $_POST['unique_id'];

        $columns            = [
            'is_delete'   => 1,
        ];

        $update_where   = [
            'unique_id'     => $unique_id
        ];

        $action_obj     = $pdo->update($table,$columns, $update_where);
        // print_r($action_obj);
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
            $msg        = 'success_delete';
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }

        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql
        ];

        echo json_encode($json_array);

        break;


    case 'amc_add_update':

        $amctable = 'amcrequired';
        $table = 'po_form';
        $form_main_unique_id = $_POST['po_form_unique_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $amc_percentae = $_POST['amc_percentae'];
        $amcvalue = $_POST['amcvalue'];
        // $amc_required        = $_POST['amc_required'];
        $batch_id = $_POST['batch_id'];



         $amc_tax = $_POST['amc_tax'];
         $amc_unit_price = $_POST['amc_unit_price'];
           $amc_remarks = $_POST['amc_remarks'];

        $amcfile_names = "";
        $amcfile_org_names = "";
        $file_names = "";
        $file_org_names = "";
        // $po_file = $_POST['po_file'];

        // // print_r($po_file);die();

        // $amcpofile = $_POST['amcpofile'];

        $po_file = isset($_FILES['po_file']) ? $_FILES['po_file'] : null;

        $amcpofile = isset($_FILES['amcpofile']) ? $_FILES['amcpofile'] : null;

        $po_no = $_POST['po_no'];
        $parts = explode('/', $po_no);
        $random = substr(md5(mt_rand()), 0, 6); // random 6-character string
        $amcfile_value = end($parts);

        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['amcpofile']['name'], PATHINFO_EXTENSION);

        if ($_FILES['amcpofile']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            // $tem_name = random_strings(25) . '.pdf';
            // $tem_name = "POAMC-".$amcfile_value $random. '.pdf'; 
            $tem_name = "POAMC-" . $amcfile_value . "-" . $random . ".pdf";
            move_uploaded_file($_FILES['amcpofile']['tmp_name'], '../../uploads/amc/' . $tem_name);
            // Set $file_names to the stored filename with .pdf extension
            $amcfile_names = $tem_name;
            $amcfile_org_names = $_FILES['amcpofile']['name'];
        }

        //   print_r($amcfile_names);die();
        $po_no = $_POST['po_no'];
        $parts = explode('/', $po_no);

        $form_main_unique_id = $_POST['po_form_unique_id'];
        // Get the last value from the array
        $po_num_value = end($parts);
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);

        if (!empty($_FILES['po_file']['name'])) {
            $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);
            if ($_FILES['po_file']['type'] === 'application/pdf' && strtolower($extension) === 'pdf') {
                $tem_name = "PO-" . $po_num_value . "-" . $random . ".pdf";
                move_uploaded_file($_FILES['po_file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
                $file_names = $tem_name;
                $file_org_names = $_FILES['po_file']['name'];
            }
        } else {
            $file_names = $_POST['po_file_existing'];
            $file_org_names = $_POST['po_file_org_existing'];
        }


        if (($amcfile_org_names && $amcfile_names) && ($file_names && $file_org_names)) {
            $columns = [
                'po_unique_id' => $form_main_unique_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'amc_percentae' => $amc_percentae,
                'amcvalue' => $amcvalue,
                'amc_tax' => $amc_tax,
                'amc_unit_price' => $amc_unit_price,
                'amc_remarks' => $amc_remarks,
                'amcfile_names' => $amcfile_names,
                'amcfile_org_names' => $amcfile_org_names,
                'po_file_name' => $file_names,
                'po_file_org_name' => $file_org_names,
                'batch_id' => $batch_id,
                'unique_id' => unique_id($prefix)
            ];
        } else if (($file_names && $file_org_names)) {
            $columns = [
                'po_unique_id' => $form_main_unique_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'amc_percentae' => $amc_percentae,
                'amcvalue' => $amcvalue,
                'amc_tax' => $amc_tax,
                'amc_unit_price' => $amc_unit_price,
                'amc_remarks' => $amc_remarks,
                'po_file_name' => $file_names,
                'po_file_org_name' => $file_org_names,
                'batch_id' => $batch_id,
                'unique_id' => unique_id($prefix)
            ];
        } else if (($amcfile_org_names && $amcfile_names)) {
            $columns = [
                'po_unique_id' => $form_main_unique_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'amc_percentae' => $amc_percentae,
                'amcvalue' => $amcvalue,
                'amc_tax' => $amc_tax,
                'amc_unit_price' => $amc_unit_price,
                'amc_remarks' => $amc_remarks,
                'amcfile_names' => $amcfile_names,
                'amcfile_org_names' => $amcfile_org_names,
                'batch_id' => $batch_id,
                'unique_id' => unique_id($prefix)
            ];
        } else {
            $columns = [
                'po_unique_id' => $form_main_unique_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'amc_percentae' => $amc_percentae,
                'amcvalue' => $amcvalue,
                'amc_tax' => $amc_tax,
                'amc_unit_price' => $amc_unit_price,
                'amc_remarks' => $amc_remarks,
                'batch_id' => $batch_id,
                'unique_id' => unique_id($prefix)
            ];
        }

        $columns_table = [
            'file_name' => $file_names,
            'file_org_name' => $file_org_names,
        ];

        $update_table = ' is_delete = 0 AND unique_id ="' . $form_main_unique_id . '"';
        // Perform DB insert
        $action_obj = $pdo->insert($amctable, $columns);


        // print_r($action_obj);die();

        if (($file_names && $file_org_names)) {

            $action_obj_1 = $pdo->update($table, $columns_table, $update_table);
        }

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

            if ($unique_id) {
                $msg = 'update';
            } else {
                $msg = 'create';
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        echo json_encode([
            'status' => $status,
            'msg' => $msg,
            'error' => $error,
            'data' => $action_obj->data,
            'sql' => $action_obj->sql
        ]);
        break;


    // check already Exist Or not
    // $table_details      = [
    //     $table_consignee_details,
    //     [
    //         'COUNT(unique_id) AS count'
    //     ]
    // ];

    // $select_where       = ' is_delete = 0 AND con_address ="'.$con_address .'"  AND form_main_unique_id ="' .$form_main_unique_id . '"';
    // // AND con_address ="'.$con_address .'"  and form_main_unique_id ="' . $form_main_unique_id . '"
    //  


    // $action_obj         = $pdo->select($table_details, $select_where);
    // // // print_r( $action_obj );
    // if ($action_obj->status) {
    //     $status     = $action_obj->status;
    //     $data       = $action_obj->data;
    //     $error      = '';
    //     $sql        = $action_obj->sql;
    // } else {
    //     $status     = $action_obj->status;
    //     $data       = $action_obj->data;
    //     $error      = $action_obj->error;
    //     $sql        = $action_obj->sql;
    //     $msg        = 'error';
    // }

    // Update Begins
    // if ($unique_id) {

    //     unset($columns['unique_id']);
    //     // $table_product_po='po_product_assign_details';
    //     // $columns_po = [
    //     //     "con_name" =>$con_contact_name ,
    //     //     "con_contact_no" =>$con_contact_number ,

    //     // ];
    //     // consignee_unique_id
    //     // $update_where_1   = [
    //     //         "form_main_unique_id"     => $po_form_unique_id
    //     //     ];
    //     $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" and con_unique_id="' . $unique_id . '" ';
    //     $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);
    //     // print_r(

    //     $update_where   = [
    //         'unique_id'     => $unique_id
    //     ];



    // print_R($action_obj );die();
    // Update Ends
    // }



    //     if ($action_obj->status) {
    //         $status     = $action_obj->status;
    //         $data       = $action_obj->data;
    //         $error      = '';
    //         $sql        = $action_obj->sql;
    //         if ($unique_id) {
    //             $msg        = "update";
    //         } else {
    //             $msg        = "add";
    //         }

    //     } else {
    //         $status     = $action_obj->status;
    //         $data       = $action_obj->data;
    //         $error      = $action_obj->error;
    //         $sql        = $action_obj->sql;
    //         $msg        = 'error';
    //     }
    // // }

    // $json_array   = [
    //     'status'    => $status,
    //     'data'      => $data,
    //     'error'     => $error,
    //     'msg'       => $msg,
    //     'sql'       => $sql

    // ];

    // echo json_encode($json_array);

    // break;






    case 'consignee_details_edit':
        // Fetch Data
        $unique_id = $_POST['unique_id'];
        $data = [];

        // Query Variables
        $json_array = '';
        $columns = [
            'con_address',
            "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
            'con_pincode',
            'con_contact_name',
            'con_contact_number',
            "con_lan_num",
            "zone",
            'unique_id',
            'con_district',
            'cons_verify_sts'
        ];
        $table_details = [
            $table_consignee_details,
            $columns
        ];
        $where = [
            'unique_id' => $unique_id,
            'is_active' => 1,
            'is_delete' => 0
        ];

        $result = $pdo->select($table_details, $where);
        // print_r($result);
        if ($result->status) {

            $json_array = [
                'data' => $result->data[0],
                'status' => $result->status,
                'sql' => $result->sql,
                'error' => $result->error,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;



    case 'consignee_details_delete':

        $unique_id = $_POST['unique_id'];

        $columns = [
            'is_delete' => 1,
        ];

        $update_where = [
            'unique_id' => $unique_id
        ];

        $action_obj = $pdo->update($table_consignee_details, $columns, $update_where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            $msg = 'success_delete';
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

       

    case 'po_delivery_add_update':

        $main_unique_id = $_POST['main_unique_id'];
        $con_unique_id = $_POST['con_unique_id'];
        $con_name = $_POST['con_name'];
        $con_contact_no = $_POST['con_contact_no'];
        $item_code = $_POST['item_code'];
        $item_name = $_POST['item_name'];
        $bill_qty = $_POST['bill_qty'];
        $qty = $_POST['qty'];
        $unit_price = $_POST['unit_price'];
        $item_tax = $_POST['item_tax'];
        $unique_id = $_POST['unique_id'];
        $po_unique_id = $_POST['po_unique_id'];
        $product_unique_id_val = $_POST['product_unique_id_val'];
        // $rem_qty          = $_POST['rem_qty'];
        // $po_product_assign_id = po_no_get();

        $update_where = '';




        $columns = [
            'form_main_unique_id' => $main_unique_id,
            'con_unique_id' => $con_unique_id,
            'con_name' => $con_name,
            'con_contact_no' => $con_contact_no,
            'item_code' => $item_code,
            'product' => $item_name,
            'assign_qty' => $bill_qty,
            'qty' => $qty,
            'unit_price' => $unit_price,
            'item_tax' => $item_tax,
            'po_unique_id' => $po_unique_id,
            'product_unique_id' => $product_unique_id_val,


            'is_active' => 1,
            'unique_id' => unique_id($prefix)
        ];



        $po_product_assign_details = 'po_product_assign_details';

        $columns1 = [
            'form_main_unique_id',
        ];
        $table_details1 = [
            $po_product_assign_details,
            [
                'COUNT(unique_id) AS count',
                'form_main_unique_id',

            ],

        ];
        $select_where = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "' AND con_unique_id = '" . $con_unique_id . "' AND product_unique_id = '" . $product_unique_id_val . "'";


        $action_obj1 = $pdo->select($table_details1, $select_where);

        if ($action_obj1->status) {
            $status = $action_obj1->status;
            $data = $action_obj1->data;
            $error = '';
            $sql = $action_obj1->sql;
        } else {
            $status = $action_obj1->status;
            $data = $action_obj1->data;
            $error = $action_obj1->error;
            $sql = $action_obj1->sql;
            $msg = 'error';
        }
        if ($data[0]['count'] != 0) {
            $update_where = 'form_main_unique_id="' . $main_unique_id . '" and con_unique_id="' . $con_unique_id . '" AND product_unique_id = "' . $product_unique_id_val . '"';

            $action_obj = $pdo->update($po_product_assign_details, $columns, $update_where);

            // Update Ends
        } else {
            // Insert Begins
            $action_obj = $pdo->insert($po_product_assign_details, $columns);
            // $msg        = 'add';
            // Insert Ends
        }

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

            if ($unique_id) {
                $msg = 'update';
            } else {
                $msg = 'create';
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

    case 'check_status':

        $bill_qty_val = $_POST['bill_qty_val'];
        $item_qty = $_POST['qty'];
        $main_unique_id = $_POST['main_unique_id'];
        $product_unique_id = $_POST['product_unique_id'];
        $con_unique_id = $_POST['con_unique_id'];
        $con_s_no = $_POST['con_s_no'];


        $product_details = 'product_details_sub';
        $column = [
            'unique_id',
            'product',
            'qty',
            'rem_qty',
            'assign_qty',
            'con_serial_no',
            'assign_int_val'
        ];


        $table_details12 = [
            $product_details,
            $column,
        ];
        $select_where12 = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "' AND unique_id = '" . $product_unique_id . "'";



        $action_obj12 = $pdo->select($table_details12, $select_where12);



        if ($action_obj12->status) {
            $status = $action_obj12->status;
            $data = $action_obj12->data;
            $error = '';
            $sql = $action_obj12->sql;
        } else {
            $status = $action_obj12->status;
            $data = $action_obj12->data;
            $error = $action_obj12->error;
            $sql = $action_obj12->sql;
            $msg = 'error';
        }



        if ($data[0]['unique_id'] == $product_unique_id) {
            if ($data[0]['rem_qty'] == '' || $data[0]['rem_qty'] == 0 && $data[0]['assign_qty'] == '' || $data[0]['assign_qty'] == 0) {
                if ($data[0]['qty'] >= $bill_qty_val) {

                    $data1 = $data[0]['qty'] - $bill_qty_val;
                    $assign_qty = $bill_qty_val;
                    if ($data[0]['con_serial_no'] != '') {
                        $con_ser_no = $data[0]['con_serial_no'] . ',' . $con_s_no;
                    } else {
                        $con_ser_no = $con_s_no;
                    }

                    if ($data[0]['assign_int_val'] != '') {
                        $bill_val = $data[0]['assign_int_val'] . ',' . $bill_qty_val . '-' . $con_s_no;
                    } else {
                        $bill_val = $bill_qty_val . '-' . $con_s_no;
                    }

                    $table_po_details = 'product_details_sub';

                    $columns12 = [
                        "rem_qty" => $data1,
                        "assign_qty" => $bill_qty_val,
                        "assign_int_val" => $bill_val,
                        "con_serial_no" => $con_ser_no
                    ];
                    $update_where12 = "form_main_unique_id = '" . $main_unique_id . "' AND unique_id= '" . $product_unique_id . "'";

                    $action_obj_update = $pdo->update($table_po_details, $columns12, $update_where12);
                    $msg = 'available';
                } else {
                    $data1 = $data[0]['qty'] - $bill_qty_val;
                    $msg = 'unavailable';
                }
            }
        }


        if ($data[0]['rem_qty'] != '' && $data[0]['assign_qty'] != '') {

            if ($data[0]['rem_qty'] >= $bill_qty_val) {

                $product_details_po = 'product_details_sub';
                $column_po = [
                    'unique_id',
                    'product',
                    'qty',
                    'rem_qty',
                    'assign_qty',
                    'con_serial_no',
                    'assign_int_val',
                    'COUNT(con_serial_no) AS con_count'
                ];

                $table_details12_po = [
                    $product_details_po,
                    $column_po,
                ];

                $select_where12_po = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "' AND unique_id = '" . $product_unique_id . "'";

                if ($con_s_no) {
                    $select_where12_po .= " AND FIND_IN_SET('$con_s_no',con_serial_no)>0";
                }

                $po_action = $pdo->select($table_details12_po, $select_where12_po);

                if ($po_action->status) {
                    $status = $po_action->status;
                    $data_po = $po_action->data;
                    $error = '';
                    $sql = $po_action->sql;
                } else {
                    $status = $po_action->status;
                    $data_po = $po_action->data;
                    $error = $po_action->error;
                    $sql = $po_action->sql;
                    $msg = 'error';
                }

                if ($data_po[0]['con_count'] != 0) {


                    $product_details_po = 'product_details_sub';
                    $column_po1 = [

                        'qty',
                        'rem_qty',
                        'assign_qty',
                        'con_serial_no',
                        'assign_int_val',
                        'COUNT(con_serial_no) AS con_count'
                    ];

                    $table_details12_po1 = [
                        $product_details_po,
                        $column_po1,
                    ];

                    $select_where12_po1 = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "' AND unique_id = '" . $product_unique_id . "'";

                    if ($con_s_no) {
                        $select_where12_po1 .= " AND con_serial_no IN (" . $con_s_no . ")";
                    }


                    $po_action1 = $pdo->select($table_details12_po1, $select_where12_po1);


                    $data1 = $data[0]['qty'] - $bill_qty_val;


                    $assign_qty1 = $data1 - $data[0]['assign_qty'];



                    $table_po_details = 'product_details_sub';

                    $columns12 = [
                        "rem_qty" => $data1,
                        "assign_qty" => $assign_qty1,

                    ];
                    $update_where12 = "form_main_unique_id = '" . $main_unique_id . "' AND unique_id= '" . $product_unique_id . "'";

                    $action_obj_update = $pdo->update($table_po_details, $columns12, $update_where12);
                    $msg = 'available';
                }
                // $data_po[0]['con_serial_no'] != $con_s_no && 
                else if ($data_po[0]['con_count'] == 0) {

                    $assign_qty1 = $data[0]['assign_qty'] + $bill_qty_val;

                    $data1 = $data[0]['rem_qty'] - $bill_qty_val;
                    // $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                    if ($data[0]['con_serial_no'] != '') {
                        $con_ser_no = $data[0]['con_serial_no'] . ',' . $con_s_no;
                    } else {
                        $con_ser_no = $con_s_no;
                    }

                    if ($data[0]['assign_int_val'] != '') {
                        $bill_val = $data[0]['assign_int_val'] . ',' . $bill_qty_val . '-' . $con_s_no;
                    } else {
                        $bill_val = $bill_qty_val . '-' . $con_s_no;
                    }
                    // print_r($data[0]['assign_int_val']);die();
                    $table_po_details = 'product_details_sub';

                    $columns12 = [
                        "rem_qty" => $data1,
                        "assign_qty" => $assign_qty1,
                        "assign_int_val" => $bill_val,
                        "con_serial_no" => $con_ser_no

                    ];
                    $update_where12 = "form_main_unique_id = '" . $main_unique_id . "' AND unique_id= '" . $product_unique_id . "'";

                    $action_obj_update = $pdo->update($table_po_details, $columns12, $update_where12);
                    $msg = 'available';
                }
            } else {
                $data1 = $data[0]['rem_qty'] - $bill_qty_val;
                $msg = 'unavailable';
            }
        }
        $json_array = [
            'status' => $status,
            'data' => $data1,
            'assign_qty' => $bill_qty_val,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];

        echo json_encode($json_array);

        break;

    // assign qty
    case 'get_assign_qty_record_my':

        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $form_main_unique_id = $_POST['unique_id'];

        $batch_ids = $_POST['batch_ids'];

        $table = "view_po_consignee_deatail";
        $columns = [
            "con_address",
            "con_district",
            "con_pincode",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "main_unique_id",
            "con_unique_id",
            "zone",
            "po_unique_id",
            "batch_id",
            "po_number",
        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "batch_id = '$batch_ids' AND is_delete = '0'";
        $result = $pdo->select($table_details, $where);
        $total_records = total_records();

        $table_po_assign = "po_product_assign_details";
        $columns23 = [
            "con_unique_id"
        ];
        $table_details23 = [
            $table_po_assign,
            $columns23
        ];

        $where23 = "batch_id = '$batch_ids' AND is_delete = '0'";
        $result23 = $pdo->select($table_details23, $where23);
        $stored_consignees = array_column($result23->data, 'con_unique_id');
        if ($result->status) {
            $s_no = 0;
            $sno = 0;
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                if (!in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block" >
                    <div class="col-5">
                        <div class="row">
                       <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Batch ID</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['batch_id'] . '</div>
                             <input type="hidden" name="mybatch_no" id="mybatch_no" value="' . $value['batch_id'] . '">
                             <input type="hidden" name="myponumber" id="myponumber" value="' . $value['po_number'] . '">
                             <input type="hidden" name="con_addr" id="con_addr" value="' . $value['con_address'] . '">
                        </div>
                         
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee name</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Contact</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Serial No</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $sno . '</div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Address</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_address'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Landline</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Zone</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['zone'] . '</div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {



                            $table_product_details = 'product_details_sub';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code group by item_creation_sub.unique_id)as item_code",
                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',

                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',
                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);
                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];

                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id
" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">
<input type="text" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';


                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control 
bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {


                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
                                                            
                                                            
<input type="hidden" id="product_unique_id" name="product_unique_id[]" class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['tax'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">
<input type="text" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';

                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                } else if (in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block">
                    <div class="col-5">
                        <div class="row">
                        <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Batch ID</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['batch_id'] . '</div>
                             <input type="hidden" name="mybatch_no" id="mybatch_no" value="' . $value['batch_id'] . '">
                             <input type="hidden" name="myponumber" id="myponumber" value="' . $value['po_number'] . '">
                             <input type="hidden" name="con_addr" id="con_addr" value="' . $value['con_address'] . '">
                        </div>
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee name</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Contact</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Serial No</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $sno . '</div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Address</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_address'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Landline</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Zone</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['zone'] . '</div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {




                            $table_product_details = 'product_details_sub';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code)as item_code",

                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',

                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',
                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);
                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];

                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id"
    class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]"
    class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id"
    class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]"
    class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]"
    class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]"
    class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]"
    class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]"
    class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]"
    class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]"
    class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]"
    class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]"
    class="form-control con_sno" value="' . $sno . '">
    <input type="text" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';


                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {


                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
    <input type="hidden" id="product_unique_id" name="product_unique_id[]"
        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

    <input type="hidden" id="main_unique_id" name="main_unique_id"
        class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

    <input type="hidden" id="con_unique_id" name="con_unique_id[]"
        class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

    <input type="hidden" id="po_unique_id" name="po_unique_id"
        class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

    <input type="hidden" id="con_name" name="con_name[]"
        class="form-control con_name" value="' . $value['con_contact_name'] . '">

    <input type="hidden" id="con_contact_no" name="con_contact_no[]"
        class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

    <input type="hidden" id="item_code" name="item_code[]"
        class="form-control item_code" value="' . $product['item_code'] . '">

    <input type="hidden" id="item_name" name="item_name[]"
        class="form-control item_name" value="' . $product['product'] . '">

    <input type="hidden" id="unit_price" name="unit_price[]"
        class="form-control unit_price" value="' . $product['unit_price'] . '">

    <input type="hidden" id="less_qty" name="less_qty[]"
        class="form-control less_qty" value="' . $product['qty'] . '">

    <input type="hidden" id="tax" name="tax[]"
        class="form-control tax" value="' . $product['tax'] . '">

    <input type="hidden" id="qty" name="qty[]"
        class="form-control qty" value="' . $product['qty'] . '">

    <input type="hidden" id="con_sno" name="con_sno[]"
        class="form-control con_sno" value="' . $sno . '">
        <input type="text" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';



                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';



                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                }
            }
        }
        // }
        $json_array = [
            'data' => $data,
        ];

        echo json_encode($json_array);

        break;


    // new end
    case 'get_assign_qty_record_old':

        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $form_main_unique_id = $_POST['unique_id'];

        $table = "view_po_consignee_deatail";
        $columns = [
            "con_address",
            "con_district",
            "con_pincode",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "main_unique_id",
            "con_unique_id",
            "zone",
            "po_unique_id",
        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "main_unique_id = '$form_main_unique_id' AND is_delete = '0'";
        $result = $pdo->select($table_details, $where);
        // print_r( $result);
        $total_records = total_records();

        $table_po_assign = "po_product_assign_details";
        $columns23 = [
            "con_unique_id"
        ];
        $table_details23 = [
            $table_po_assign,
            $columns23
        ];

        $where23 = "form_main_unique_id = '$form_main_unique_id' AND is_delete = '0'";
        $result23 = $pdo->select($table_details23, $where23);
        $stored_consignees = array_column($result23->data, 'con_unique_id');
        // print_r(   $result23);
        if ($result->status) {
            $s_no = 0;
            $sno = 0;
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                if (!in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block" >
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee name</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Contact</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Serial No</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $sno . '</div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Address</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_address'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Landline</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Zone</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['zone'] . '</div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {



                            $table_product_details = 'product_details_sub';
                            $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code group by item_creation_sub.unique_id)as item_code",

                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',

                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',

                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);
                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];

                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id
" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">';


                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control 
bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {

                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
                                                            
                                                            
<input type="hidden" id="product_unique_id" name="product_unique_id[]" class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['tax'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">

';

                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';


                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                } else if (in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block">
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee name</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Contact</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Serial No</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $sno . '</div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Address</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_address'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Consignee Landline</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 head_po">
                                <label for="main_screen" class="form-label">Zone</label>
                            </div>
                            <div class="col-xl-1">:</div>
                            <div class="col-xl-7">' . $value['zone'] . '</div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {



                            $table_product_details = 'product_details_sub';
                            $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code)as item_code",

                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',
                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',
                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);
                        //print_r( $values_product );die();
                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];

                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id"
    class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]"
    class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id"
    class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]"
    class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]"
    class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]"
    class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]"
    class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]"
    class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]"
    class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]"
    class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]"
    class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]"
    class="form-control con_sno" value="' . $sno . '">
';


                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {


                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
    <input type="hidden" id="product_unique_id" name="product_unique_id[]"
        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

    <input type="hidden" id="main_unique_id" name="main_unique_id"
        class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

    <input type="hidden" id="con_unique_id" name="con_unique_id[]"
        class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

    <input type="hidden" id="po_unique_id" name="po_unique_id"
        class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

    <input type="hidden" id="con_name" name="con_name[]"
        class="form-control con_name" value="' . $value['con_contact_name'] . '">

    <input type="hidden" id="con_contact_no" name="con_contact_no[]"
        class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

    <input type="hidden" id="item_code" name="item_code[]"
        class="form-control item_code" value="' . $product['item_code'] . '">

    <input type="hidden" id="item_name" name="item_name[]"
        class="form-control item_name" value="' . $product['product'] . '">

    <input type="hidden" id="unit_price" name="unit_price[]"
        class="form-control unit_price" value="' . $product['unit_price'] . '">

    <input type="hidden" id="less_qty" name="less_qty[]"
        class="form-control less_qty" value="' . $product['qty'] . '">

    <input type="hidden" id="tax" name="tax[]"
        class="form-control tax" value="' . $product['tax'] . '">

    <input type="hidden" id="qty" name="qty[]"
        class="form-control qty" value="' . $product['qty'] . '">

    <input type="hidden" id="con_sno" name="con_sno[]"
        class="form-control con_sno" value="' . $sno . '">';



                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';



                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                }
            }
        }
        // }
        $json_array = [
            'data' => $data,

        ];

        echo json_encode($json_array);

        break;
    // pavi crud case
    case "get_consignee_product_details":

        // $main_unique_id = $_POST["main_unique_id"];

        $batch_id = $_POST['batch_id'];
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];


        $data = [];
        $sno = $start + 1;

        if ($length == '-1') {
            $limit = '';
        } else {
            $limit = $length;
        }

        $table_po_con = "view_consignee_product_details";

        // Columns from your view
        $columns = [
            // "'' as s_no",
            "batch_id",
            "po_number",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "con_address",
            "zone",
            "get_item_name(item_code) as item_code",
            "product_name",
            "qty",
            "unit_price",
            "tax",
            "assign_qty",
            "con_unique_id",
            "product_unique_id",
        ];

        $table_details = [$table_po_con, $columns];


        $where = "batch_id = '" . $batch_id . "' order BY con_unique_id,product_unique_id";



        // Apply search filter
        $search_filter = datatable_searching($_POST['search']['value'], $columns);
        if ($search_filter) {
            $where .= " AND ($search_filter)";
        }

        $order_by = ""; // Add ordering logic here if needed



        // Fetch data
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');
        $total_records = total_records();

        if ($result->status) {
            foreach ($result->data as $row) {
                $data[] = [
                    "batch_no" => $row['batch_id'],
                    "po_number" => $row['po_number'],
                    "con_contact_name" => $row['con_contact_name'],
                    "con_contact_number" => $row['con_contact_number'],
                    "con_lan_num" => $row['con_lan_num'],
                    "con_address" => $row['con_address'],
                    "zone" => $row['zone'],
                    "item_code" => $row['item_code'],
                    "product_name" => $row['product_name'],
                    "qty" => $row['qty'],
                    "unit_price" => $row['unit_price'],
                    "tax" => $row['tax'],
                    "assign_qty" => $row['assign_qty'],
                    "con_unique_id" => $row['con_unique_id'],
                    "product_unique_id" => $row['product_unique_id']
                ];
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql // Optional: Remove in production
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


    case 'consignee_details_add_update':

        $no_of_consignee = $_POST['no_of_consignee'];
        // $batch_id                = $_POST['batch_id'];
        $consignee_received_date = $_POST['consignee_received_date'];
        $con_address = $_POST['con_address'];
        $con_district = $_POST['con_district'];
        $con_state_name = $_POST['con_state_name'];
        $con_pincode = $_POST['con_pincode'];
        $consignee_gst = $_POST['consignee_gst'];
        $con_contact_name = $_POST['con_contact_name'];
        $con_contact_number = $_POST['con_contact_number'];
        $con_lan_num = $_POST['con_lan_num'];
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $zone = $_POST['zone'];
        $cons_verify_sts = $_POST['cons_verify_sts'];
        $unique_id = $_POST['unique_id'];
        $po_numbers = $_POST['po_numbers'];
        $assign_team_member = $_POST['assign_team_member'];

         $cons_branch_code   = $_POST['cons_branch_code'];
        $zone_code          = $_POST['zone_code'];
        $con_email          = $_POST['con_email'];
        $alter_contact_name = $_POST['alter_contact_name'];
        $alter_contact_no   = $_POST['alter_contact_no'];
        $con_bill_gst_no    = $_POST['con_bill_gst_no'];
        $con_region         = $_POST['con_region'];



        $billing_address = $_POST['billing_address'];
        $con_branch = $_POST['con_branch'];
        if ($unique_id == '') {
            $batch_id = batch_id();
        }

        // print_r($billing_address);die();
        $dateee = date('Y-m-d');

        $columns = [
            'no_of_consignee' => $no_of_consignee,
            'batch_id' => $batch_id,
            'consignee_received_date' => $consignee_received_date,
            'batch_entry_date' => $dateee,
            'con_address' => $con_address,
            'consignee_gst' => $consignee_gst,
            'con_state_name' => $con_state_name,
            'con_district' => $con_district,
            'con_pincode' => $con_pincode,
            'con_contact_name' => $con_contact_name,
            'con_contact_number' => $con_contact_number,
            'con_branch_code' => $cons_branch_code,
            'alter_contact_name' => $alter_contact_name,

            'alter_number' => $alter_contact_no,
            'cons_email_id' => $con_email,
            'zone_code' => $zone_code,
             "billing_gst_no" => $con_bill_gst_no,
            'region'   => $con_region,
            'con_lan_num' => $con_lan_num,
            'form_main_unique_id' => $form_main_unique_id,
            'zone' => $zone,
            'cons_verify_sts' => $cons_verify_sts,
            'po_number' => $po_numbers,
            'assign_team_member' => $assign_team_member,
            'billing_address' => $billing_address,
            'con_branch' => $con_branch,
            'unique_id' => unique_id($prefix)
        ];

        // Step 1: Check for duplicate address within the same form_main_unique_id
        $table_details = [
            $table_consignee_details,
            ['COUNT(unique_id) AS count', 'unique_id']
        ];

        $select_where = 'is_delete = 0 AND con_address = "' . $con_address . '" AND form_main_unique_id = "' . $form_main_unique_id . '"';

        $action_obj = $pdo->select($table_details, $select_where);
        if ($action_obj->status) {
            $existing_data = $action_obj->data;

            // If duplicate found and it's not the same record (i.e., updating someone else's record)
            if ($existing_data[0]['count'] > 0 && $existing_data[0]['unique_id'] !== $unique_id) {
                echo json_encode([
                    'status' => false,
                    'data' => [],
                    'error' => 'Duplicate address for this form already exists.',
                    'msg' => 'already',
                    'sql' => $action_obj->sql
                ]);
                exit;
            }
        }

        // Step 2: If unique_id exists -> Update
        if ($unique_id) {
            unset($columns['unique_id']); // Remove from update fields

            // Update po_product_assign_details table
            $table_product_po = 'po_product_assign_details';
            $columns_po = [
                'con_name' => $con_contact_name,
                'con_contact_no' => $con_contact_number
            ];
            $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" AND con_unique_id="' . $unique_id . '"';
            $pdo->update($table_product_po, $columns_po, $update_where_po);

            // Update main table
            $update_where = ['unique_id' => $unique_id];
            $action_obj = $pdo->update($table_consignee_details, $columns, $update_where);
            $msg = 'update';
        } else {
            // Step 3: Insert (only if not duplicate)
            $action_obj = $pdo->insert($table_consignee_details, $columns);
            $msg = 'add';
        }

        // Step 4: Prepare response
        if ($action_obj->status) {
            $status = true;
            $error = '';
            $data = $action_obj->data;
            $sql = $action_obj->sql;
        } else {
            $status = false;
            $error = $action_obj->error;
            $data = [];
            $sql = $action_obj->sql;
            $msg = 'error';
        }

        // Step 5: Output response
        echo json_encode([
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ]);

        break;

    case 'consignee_details_add_update_23-04-25_main':

        $no_of_consignee = $_POST['no_of_consignee'];
        $batch_id = $_POST['batch_id'];
        $consignee_received_date = $_POST['consignee_received_date'];
        $con_address = $_POST['con_address'];
        $con_district = $_POST['con_district'];
        $con_pincode = $_POST['con_pincode'];
        $consignee_gst = $_POST['consignee_gst'];
        $con_contact_name = $_POST['con_contact_name'];
        $con_contact_number = $_POST['con_contact_number'];
        $con_lan_num = $_POST['con_lan_num'];
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $zone = $_POST['zone'];
        $cons_verify_sts = $_POST['cons_verify_sts'];
        $unique_id = $_POST['unique_id'];
        $po_numbers = $_POST['po_numbers'];
        $assign_team_member = $_POST['assign_team_member'];
        $update_where = '';

        $dateee = date('Y-m-d');
        // print_r($con_district );die();
        $columns = [
            'no_of_consignee' => $no_of_consignee,
            'batch_id' => $batch_id,
            'consignee_received_date' => $consignee_received_date,
            'batch_entry_date' => $dateee,
            'con_address' => $con_address,
            'consignee_gst' => $consignee_gst,
            'con_district' => $con_district,
            'con_pincode' => $con_pincode,
            'con_contact_name' => $con_contact_name,
            'con_contact_number' => $con_contact_number,
            'con_lan_num' => $con_lan_num,
            'form_main_unique_id' => $form_main_unique_id,
            'zone' => $zone,
            'cons_verify_sts' => $cons_verify_sts,
            'po_number' => $po_numbers,
            'assign_team_member' => $assign_team_member,
            'unique_id' => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details = [
            $table_consignee_details,
            [
                'COUNT(unique_id) AS count'
            ]
        ];


        $select_where = ' is_delete = 0 AND con_address ="' . $con_address . '"  AND form_main_unique_id ="' . $form_main_unique_id . '"';


        $action_obj = $pdo->select($table_details, $select_where);
        // // print_r( $action_obj );
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

        // Update Begins
        if ($unique_id) {

            unset($columns['unique_id']);
            $table_product_po = 'po_product_assign_details';
            $columns_po = [
                "con_name" => $con_contact_name,
                "con_contact_no" => $con_contact_number,

            ];

            $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" and con_unique_id="' . $unique_id . '" ';
            $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);

            $update_where = [
                'unique_id' => $unique_id
            ];


            $action_obj = $pdo->update($table_consignee_details, $columns, $update_where);

        }
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {
            // else{
            $table_details1 = [
                'consignee_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where = 'is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';


            $total_record = $pdo->select($table_details1, $count_where);

            $data_record = $total_record->data;


            // Insert Begins
            $action_obj = $pdo->insert($table_consignee_details, $columns);
            $msg = 'add';
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
                $msg = "add";
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
    case 'consignee_details_datatable':
        // Function Name button prefix
        $btn_edit_delete = 'consignee_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search = $_POST['search']['value'];

        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];

        if ($length == '-1') {
            $limit = '';
        }

        // Query Variables
        $json_array = '';
        $columns = [
            '"" as s_no',
            'batch_id',
            'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
            'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
            'COUNT(*) as count',
            "(select count(item_code) as item_count from product_details_sub WHERE form_main_unique_id = $table_consignee_details.form_main_unique_id and is_delete=0) as item_count",
            "(select SUM(qty) as qty from product_details_sub WHERE form_main_unique_id = $table_consignee_details.form_main_unique_id and is_delete=0  ) as qty_count",

            'MIN(unique_id) as unique_id', // Use MIN to fetch a reference ID for actions
            "'' as imports",
            'batch_id as main_batch_id',
            "(select count(batch_id) as batch_cnt from po_product_assign_details where po_product_assign_details.batch_id = $table_consignee_details.batch_id) as batch_cnt",
            "form_main_unique_id"



        ];

        $table_details = [
            $table_consignee_details,
            $columns
        ];

        // Filtering condition
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id = "' . $form_main_unique_id . '"';

        // Grouping the result by batch_id to get count and group-level info
        $group_by = ' GROUP BY batch_id';

        // No specific ordering
        $order_by = '';

        // Use SQL_CALC_FOUND_ROWS to calculate total filtered records
        $sql_function = 'SQL_CALC_FOUND_ROWS';

        // Execute the grouped SELECT query
        $result = $pdo->select($table_details, $where . $group_by);
        // print_r($result);
        // print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $batch_id = $value['batch_id'];

                $count = $value['count'];

                $value['item_count'] = $value['item_count'];
                $value['qty_count'] = $value['qty_count'];

                $form_main_unique_id = $value['form_main_unique_id'];


                $value['count'] = consignee_details_view_btn($folder_name, $batch_id, $count, $form_main_unique_id);


                // $value['count'] = '<span class="badge bg-primary count-badge" style="font-size: 15px;" data-batch-id="' . $value['batch_id'] . '" style="cursor:pointer;">' . $value['count'] . '</span>';
// $value['count']="onclick="po_from/create.php?. $value['batch_id'] . '"""
                //  $value['count'] = '<a href="po_from/create_1.php?batch_id=' . $value['batch_id'] . '" target="_blank">Open Form</a>';
                //    $value['count'] = '<a href="index.php?file=po_form/create_1&batch_id=' . $value['batch_id'] . '" target="_blank">' . $value['count'] . '</a>';


                //  $value['count'] = '<span class="badge bg-primary count-badge" style="font-size: 15px;" data-batch-id="' . $value['batch_id'] . '" style="cursor:pointer;">' . $value['count'] . '</span>';


                if ($value['batch_cnt'] === 0) {
                    $value['unique_id'] = '
    <button type="button" 
            onclick="excel_export(\'' . $value['batch_id'] . '\')" 
            class="btn btn-success waves-effect waves-light wavw mb-1 mt-1">
        <i class="ri-file-excel-2-fill"></i> &nbsp;Export
        
    </button>
    
';

                    $value['imports'] = '
    <button type="button" 
            onclick="excel_import(\'' . $value['batch_id'] . '\')" 
            class="btn btn-success waves-effect waves-light wavw mb-1 mt-1">
        <i class="ri-file-excel-2-fill"></i> &nbsp;Import
    </button>
';
                } else {
                    $value['unique_id'] = 'Exported Done';

                    $value['imports'] = 'Imported Done';




                }

                  if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" ||$_SESSION['user_type_unique_id'] == "5f97fc3257f2525529"||$_SESSION['user_type_unique_id'] == "68cba503472bd48995") { 

                  $main_id = $value['main_batch_id'];

  if ($value['batch_cnt'] === 0) {
$value['main_batch_id'] = '
    <button type="button" 
            onclick="delete_batch(\'' . $value['form_main_unique_id'] . '\',\'' . $main_id . '\')" 
            class="btn btn-success waves-effect waves-light wavw mb-1 mt-1">
        <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></button>';
 }else {
    $value['main_batch_id'] = ' - ';
    }
                  }


                $value['item_count'] = '<span class="badge bg-primary show-consignee" style="font-size: 15px; cursor:pointer;" data-batch-id="' . $value['batch_id'] . '">' . $value['item_count'] . '</span>';



                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;


case 'batch_consignee_delete':

    // Getting the post data
    $unique_id = $_POST['unique_id'];
    $batch_id = $_POST['batch_id'];

    // Prepare where conditions for both unique_id and form_main_unique_id
    $delete_where = [
        'form_main_unique_id' => $unique_id,
        'batch_id' => $batch_id  // Assuming the same value for both
    ];

    // Perform the delete query
    $action_obj = $pdo->delete("consignee_details_sub", $delete_where);

    if ($action_obj->status) {
        // If delete operation was successful
        $status = $action_obj->status;
        $data = $action_obj->data;
        $error = '';
        $sql = $action_obj->sql;
        $msg = 'success_delete';
    } else {
        // If an error occurred during the delete operation
        $status = $action_obj->status;
        $data = $action_obj->data;
        $error = $action_obj->error;
        $sql = $action_obj->sql;
        $msg = 'error';
    }

    // Prepare response array
    $json_array = [
        'status' => $status,
        'data' => $data,
        'error' => $error,
        'msg' => $msg,
        'sql' => $sql
    ];

    // Return the JSON response
    echo json_encode($json_array);

    break;


    case 'consignee_details_datatable_main_mainS':
        // Function Name button prefix
        $btn_edit_delete = 'consignee_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? '' : $length;

        $data = [];
        $sno = $start;

        $columns = [
            '"" as s_no',
            'batch_id',
            'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
            'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
            'COUNT(*) as count',
            'MIN(unique_id) as unique_id',
            "'' as imports",
            "(SELECT COUNT(batch_id) FROM po_product_assign_details WHERE po_product_assign_details.batch_id = $table_consignee_details.batch_id) as batch_cnt",
            'form_main_unique_id',

        ];

        $table_details = [$table_consignee_details, $columns];

        // Filtering condition
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id = "' . $form_main_unique_id . '"';
        $group_by = ' GROUP BY batch_id';
        $order_by = '';
        $sql_function = 'SQL_CALC_FOUND_ROWS';

        // Execute the grouped SELECT query
        $result = $pdo->select($table_details, $where . $group_by);
        $total_records = total_records();






        if ($result->status) {
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $sno++;
                $value['s_no'] = $sno;
                $batch_id = $value['batch_id'];
                $form_main_unique_id = $value['form_main_unique_id'];

                $value['count'] = '<span class="badge bg-primary count-badge" style="font-size: 15px;" data-batch-id="' . $batch_id . '" style="cursor:pointer;">' . $value['count'] . '</span>';

                if ($value['batch_cnt'] === 0) {
                    $value['unique_id'] = '
                    <button type="button" onclick="excel_export(\'' . $batch_id . '\')" class="btn btn-success waves-effect waves-light mb-1 mt-1">
                        <i class="ri-file-excel-2-fill"></i> &nbsp;Export
                    </button>';
                    $value['imports'] = '
                    <button type="button" onclick="excel_import(\'' . $batch_id . '\')" class="btn btn-success waves-effect waves-light mb-1 mt-1">
                        <i class="ri-file-excel-2-fill"></i> &nbsp;Import
                    </button>';


                } else {
                    $value['unique_id'] = 'Exported Done';
                    $value['imports'] = 'Imported Done';
                }

                $data[] = array_values($value);

            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                // 'batch_id' => $last_batch_id, // ✅ Last inserted batch_id included
                'testing' => $result->sql
            ];

            echo json_encode($json_array);
        } else {
            print_r($result);
        }

        break;


    case 'consignee_details_datatable_mains':
        // Function Name button prefix
        $btn_edit_delete = 'consignee_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search = $_POST['search']['value'];

        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $data = [];

        if ($length == '-1') {
            $limit = '';
        }

        // Query Variables
        $json_array = '';
        $columns = [
            '"" as s_no',
            'batch_id',
            'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
            'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
            'COUNT(*) as count',
            'MIN(unique_id) as unique_id', // Use MIN to fetch a reference ID for actions
            "'' as imports",
            "(select count(batch_id) as batch_cnt from po_product_assign_details where po_product_assign_details.batch_id = $table_consignee_details.batch_id) as batch_cnt",
            "form_main_unique_id"



        ];

        $table_details = [
            $table_consignee_details,
            $columns
        ];

        // Filtering condition
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id = "' . $form_main_unique_id . '"';

        // Grouping the result by batch_id to get count and group-level info
        $group_by = ' GROUP BY batch_id';

        // No specific ordering
        $order_by = '';

        // Use SQL_CALC_FOUND_ROWS to calculate total filtered records
        $sql_function = 'SQL_CALC_FOUND_ROWS';

        // Execute the grouped SELECT query
        $result = $pdo->select($table_details, $where . $group_by);

        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $batch_id = $value['batch_id'];

                $value['count'] = '<span class="badge bg-primary count-badge" style="font-size: 15px;" data-batch-id="' . $value['batch_id'] . '" style="cursor:pointer;">' . $value['count'] . '</span>';


                if ($value['batch_cnt'] === 0) {
                    $value['unique_id'] = '
    <button type="button" 
            onclick="excel_export(\'' . $value['batch_id'] . '\')" 
            class="btn btn-success waves-effect waves-light wavw mb-1 mt-1">
        <i class="ri-file-excel-2-fill"></i> &nbsp;Export
        
    </button>';

                    $value['imports'] = '
    <button type="button" 
            onclick="excel_import(\'' . $value['batch_id'] . '\')" 
            class="btn btn-success waves-effect waves-light wavw mb-1 mt-1">
        <i class="ri-file-excel-2-fill"></i> &nbsp;Import
    </button>';




                } else {
                    $value['unique_id'] = 'Exported Done';

                    $value['imports'] = 'Imported Done';




                }



                $data[] = array_values($value);
                $sno++;
            }

            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'batch_id' => $last_batch_id,
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'get_consignee_by_batch_olds':
        $batch_id = $_POST['batch_id'] ?? '';

        try {
            $stmt = $conn->prepare("
        SELECT 
            con_address, con_pincode, zone, con_contact_name, con_contact_number,
            con_lan_num, consignee_gst, cons_verify_sts,
            get_district_name(con_district) AS district_name,
            con_district,
            unique_id
        FROM consignee_details_sub
        WHERE batch_id = :batch_id AND is_active = 1 AND is_delete = 0
    ");
            $stmt->execute(['batch_id' => $batch_id]);

            $html = '
    <table class="table table-hover table-bordered align-middle mb-0 dataTable no-footer">
    <button type="button" name="verify" id="verify" onclick="verify_consignee_address(\'' . $batch_id . '\')">Verify</button>
    <thead class="table-light">
        <tr>
            <th class="text-center">ID</th>
            <th>Address</th>
            <th>Pincode</th>
            <th>Zone</th>
            <th>District</th>
            <th>Contact Name</th>
            <th>Contact Number</th>
            <th>Landline</th>
            <th>GST</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead><tbody>';

            $i = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $status = $row['cons_verify_sts'] == 1 ? 'Verified' : 'Not Verified';
                $unique_id = $row['unique_id'];
                $html .= '<tr>';
                $html .= '<td>' . $i . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_address']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_pincode']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['zone']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['district_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_number']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_lan_num']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['consignee_gst']) . '</td>';
                $html .= '<td>' . $status . '</td>';
                $html .= '<td>
    <button class="btn btn-sm btn-danger delete-consignee" data-unique-id="' . $row['unique_id'] . '">Delete</button><br>
    <button class="btn btn-sm btn-primary edit-consignee"
        data-unique-id="' . $row['unique_id'] . '"
        data-address="' . htmlspecialchars($row['con_address'], ENT_QUOTES) . '"
        data-district="' . htmlspecialchars($row['con_district'], ENT_QUOTES) . '"
        data-zone="' . htmlspecialchars($row['zone'], ENT_QUOTES) . '"
        data-pincode="' . htmlspecialchars($row['con_pincode'], ENT_QUOTES) . '"
        data-contact-name="' . htmlspecialchars($row['con_contact_name'], ENT_QUOTES) . '"
        data-contact-number="' . htmlspecialchars($row['con_contact_number'], ENT_QUOTES) . '"
        data-landline="' . htmlspecialchars($row['con_lan_num'], ENT_QUOTES) . '"
        data-gst="' . htmlspecialchars($row['consignee_gst'], ENT_QUOTES) . '"
        data-status="' . htmlspecialchars($row['cons_verify_sts'], ENT_QUOTES) . '"
        onclick="editConsignee(\'' . htmlspecialchars($row['unique_id'], ENT_QUOTES) . '\')">Edit</button>
</td>';
                $html .= '</tr>';

                $i++;
            }

            $html .= '</tbody></table>';
            echo $html;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        break;
    case 'get_consignee_by_batch_15-04-2025':
        $batch_id = $_POST['batch_id'] ?? '';

        try {
            $stmt = $conn->prepare("
            SELECT 
                con_address,
                con_pincode,
                zone,
                con_contact_name,
                con_contact_number,
                con_lan_num,
                consignee_gst,
                cons_verify_sts,
                get_district_name(con_district) AS district_name,
                unique_id
            FROM consignee_details_sub
            WHERE batch_id = :batch_id AND is_active = 1 AND is_delete = 0
        ");
            $stmt->execute(['batch_id' => $batch_id]);


            $html = '
<table 
                                                                        class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                                        style="width: 0px;">
                                                                        <button type="button" name="verify" id="verify" onclick="verify_consignee_address(\'' . $batch_id . '\')">Verify</button>

                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    ID </th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Address</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                     Pincode</th>
                                                                                     <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                     Zone</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    District</th>
                                                                                    
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Contact Name</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Contact Number</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Landline</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    GST</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Status</th>
                                                                                    <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Action</th>
                                                                                    
                                                                    
                                                                            </tr>
                                                                        </thead><tbody>';

            $i = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $status = $row['cons_verify_sts'] == 1 ? 'Verified' : 'Not Verified';
                $html .= '<tr>';
                $html .= '<td>' . $i + 1 . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_address']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_pincode']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['zone']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['district_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_contact_number']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['con_lan_num']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['consignee_gst']) . '</td>';
                $html .= '<td>' . $status . '</td>';
                $html .= '<td><button class="btn btn-sm btn-danger delete-consignee" data-unique-id="' . $row['unique_id'] . '">Delete</button></td>';

                $html .= '</tr>';
                $i++;
            }


            $html .= '</tbody></table>';
            echo $html;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        break;

    case "get_assign_qty_record_pavi":

        $unique_id = $_POST['unique_id'] ?? '';
        $batch_ids = $_POST['batch_ids'] ?? '';

        $values = $pdo->select(["po_consignee_assign_view", "*"], "main_unique_id = '$unique_id' AND batch_id = '$batch_ids'");
        $stored_consignees = [];
        $data = '';
        $sno = 0;
        $s_no = 0;
        $sum_item_qty = 0;

        if ($values->status && !empty($values->data)) {
            foreach ($values->data as $value) {
                if (in_array($value['con_unique_id'], $stored_consignees)) {
                    continue;
                }

                $sno++;
                $stored_consignees[] = $value['con_unique_id'];

                $data .= '
            <div class="row form-block">
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Consignee name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Consignee Contact</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Consignee Serial No</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $sno . '</div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Consignee Address</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_address'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Consignee Landline</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"><label class="form-label">Zone</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['zone'] . '</div>
                    </div>
                </div>
            </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Item QTY</th>
                                        <th>Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                foreach ($product_display_options as $form_val) {
                    $type = ($form_val['con_unique_id'] == '' && $form_val['con_count'] == 0) ? 'new' : 'assigned';

                    switch ($type) {
                        case 'assigned':
                            $table = 'po_product_assign_details';
                            $where = "batch_id = '{$value['batch_id']}' AND con_unique_id = '{$form_val['con_unique_id']}'";
                            $columns = [
                                "item_code",
                                "product",
                                "qty",
                                "assign_qty",
                                "form_main_unique_id",
                                "unit_price",
                                "unique_id",
                                "product_unique_id",
                                "item_tax",
                                "rem_qty"
                            ];
                            break;

                        case 'new':
                        default:
                            $table = 'product_details_sub';
                            $where = "batch_id = '{$value['batch_id']}' AND is_delete = 0";
                            $columns = [
                                "(SELECT item_code FROM item_creation_sub WHERE item_creation_sub.unique_id = $table.item_code) AS item_code",
                                "product",
                                "qty",
                                "rem_qty",
                                "form_main_unique_id",
                                "unit_price",
                                "tax",
                                "unique_id"
                            ];
                            break;
                    }

                    $values_product = $pdo->select([$table, $columns], $where);

                    if ($values_product->status) {
                        foreach ($values_product->data as $product) {
                            $s_no++;
                            $sum_item_qty += $product['qty'];

                            $data .= '<tr class="assign-row">
                            <td>' . $s_no . '</td>
                            <td>' . $product['item_code'] . '</td>
                            <td>' . $product['product'] . '</td>
                            <td>' . $product['qty'] . '</td>
                            <td>
                                <input type="hidden" name="product_unique_id[]" class="form-control product_unique_id" value="' . ($product['product_unique_id'] ?? $product['unique_id']) . '">
                                <input type="hidden" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">
                                <input type="hidden" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">
                                <input type="hidden" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">
                                <input type="hidden" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">
                                <input type="hidden" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">
                                <input type="hidden" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">
                                <input type="hidden" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">
                                <input type="hidden" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">
                                <input type="hidden" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">
                                <input type="hidden" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">
                                <input type="hidden" name="tax[]" class="form-control tax" value="' . ($product['item_tax'] ?? $product['tax']) . '">
                                <input type="hidden" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">
                                <input type="tel" name="bill_qty[]" class="form-control bill_qty" value="' . ($product['assign_qty'] ?? '') . '">
                                <label style="color: red; font-weight: bold;" class="max_limit"></label>
                            </td>
                        </tr>';
                        }
                    }
                }

                $data .= '</tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>';
            }

            echo json_encode([
                "status" => true,
                "message" => "Consignee and product data loaded successfully.",
                "html" => $data
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "No consignee data found or already assigned.",
                "html" => ""
            ]);
        }

        break;


    case 'get_assign_qty_record':

        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;

        $form_main_unique_id = $_POST['unique_id'];

        $batch_ids = $_POST['batch_ids'];

        $table = "view_po_consignee_deatail";
        $columns = [
            "con_address",
            "con_district",
            "con_pincode",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "main_unique_id",
            "con_unique_id",
            "zone",
            "po_unique_id",
            "batch_id",
            "batch_entry_date",
            "po_number",
        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "batch_id = '$batch_ids' AND is_delete = '0'";
        $result = $pdo->select($table_details, $where);
        $total_records = total_records();

        $table_po_assign = "po_product_assign_details";
        $columns23 = [
            "con_unique_id"
        ];
        $table_details23 = [
            $table_po_assign,
            $columns23
        ];

        $where23 = "batch_id = '$batch_ids' AND is_delete = '0'";
        $result23 = $pdo->select($table_details23, $where23);
        $stored_consignees = array_column($result23->data, 'con_unique_id');
        if ($result->status) {
            $s_no = 0;
            $sno = 0;
            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                if (!in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block" >
                    <div class="col-12">
                        <div class="row">
                            <h6 class="text-uppercase text-body-primary" style="font-size:large; color:#878a99;">
                                Consignee Details
                            </h6>
                            <div class="col-12 col-md-4">
                                <h6 class=" text-body-primary text-capitalize" style="font-size: large; color:#506018 !important;"> <strong> ' . ucwords(strtolower($value['con_contact_name'])) . ' </strong></h6>
                                <p class="text-body-primary mb-1" style="font-size: 14px;">' . ucwords(strtolower($value['con_address'])) . '</p>
                                <p class="mb-1" style="font-size: 14px;">' . ucwords(strtolower($value['zone'])) . '</p>
                                <p class="mb-1">Ph.  : ' . $value['con_contact_number'] . '</p>
                                <p class="mb-1">Lan. : ' . $value['con_lan_num'] . '</p>
                            </div>

                            <div class="col-12 col-md-4"></div>

                            <div class="col-12 col-md-4">
                                <div class="mb-2" style="padding-left: 65px;">
                                    <span class="badge bg-success" style="width: 30px;height: 30px;line-height: 30px;text-align: center;padding: 0;border-radius: 50%;font-size: 14px;">' . $sno . '</span>
                                </div>
                                <input type="hidden" name="mybatch_no" id="mybatch_no" value="' . $value['batch_id'] . '">
                                <input type="hidden" name="myponumber" id="myponumber" value="' . $value['po_number'] . '">
                                <input type="hidden" name="con_addr" id="con_addr" value="' . $value['con_address'] . '">

                                <h6 style="color:black !important;"> <strong> ' . $value['batch_id'] . ' </strong></h6>
                                <p class="text-body-primary mb-3">' . date("d-m-Y", strtotime($value['batch_entry_date'])) . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                       
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {



                            $table_product_details = 'product_details_sub';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code group by item_creation_sub.unique_id)as item_code",

                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',

                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',
                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);
                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];
                                $get_bal_qty = get_bal_qty($product['product_unique_id'], $product['form_main_unique_id'], $value['batch_id']);
                                if (!empty($get_bal_qty)) {
                                    $bal_qty = $get_bal_qty[0]['bal_qty'];
                                } else {
                                    $bal_qty = $product['qty'];
                                }
                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                      
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id
" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="rem_qty" name="rem_qty[]"
    class="form-control rem_qty" value="' . $bal_qty . '">
    
    <input type="hidden" id="stored_qty" name="stored_qty[]"
    class="form-control stored_qty" value="' . $get_bal_qty[0]['assign_qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">
<input type="hidden" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';

                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control 
bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {

                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
                                                            
                                                            
<input type="hidden" id="product_unique_id" name="product_unique_id[]" class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

<input type="hidden" id="main_unique_id" name="main_unique_id" class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]" class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id" class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]" class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]" class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]" class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]" class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]" class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="less_qty" name="less_qty[]" class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]" class="form-control tax" value="' . $product['tax'] . '">

<input type="hidden" id="qty" name="qty[]" class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="rem_qty" name="rem_qty[]"
    class="form-control rem_qty" value="' . $bal_qty . '">
    
    
    <input type="hidden" id="stored_qty" name="stored_qty[]"
    class="form-control stored_qty" value="' . $get_bal_qty[0]['assign_qty'] . '">

<input type="hidden" id="con_sno" name="con_sno[]" class="form-control con_sno" value="' . $sno . '">
<input type="hideen" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';

                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';


                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                } else if (in_array($value['con_unique_id'], $stored_consignees)) {
                    $sno++;
                    $stored_consignees[] = $value['con_unique_id'];

                    $data .= '
                <div class="row form-block" >
                    <div class="col-12">
                        <div class="row">
                            <h6 class="text-uppercase text-body-primary" style="font-size:large; color:#878a99;">
                                Consignee Details
                            </h6>
                            <div class="col-12 col-md-4">
                                <h6 class=" text-body-primary text-capitalize" style="font-size: large; color:#506018 !important;"> <strong> ' . ucwords(strtolower($value['con_contact_name'])) . ' </strong></h6>
                                <p class="text-body-primary mb-1" style="font-size: 14px;">' . ucwords(strtolower($value['con_address'])) . '</p>
                                <p class="mb-1" style="font-size: 14px;">' . ucwords(strtolower($value['zone'])) . '</p>
                                <p class="mb-1">Ph.  : ' . $value['con_contact_number'] . '</p>
                                <p class="mb-1">Lan. : ' . $value['con_lan_num'] . '</p>
                            </div>

                            <div class="col-12 col-md-4"></div>

                            <div class="col-12 col-md-4">
                                <div class="mb-2" style="padding-left: 65px;">
                                    <span class="badge bg-success" style="width: 30px;height: 30px;line-height: 30px;text-align: center;padding: 0;border-radius: 50%;font-size: 14px;">' . $sno . '</span>
                                </div>
                                <input type="hidden" name="mybatch_no" id="mybatch_no" value="' . $value['batch_id'] . '">
                                <input type="hidden" name="myponumber" id="myponumber" value="' . $value['po_number'] . '">
                                <input type="hidden" name="con_addr" id="con_addr" value="' . $value['con_address'] . '">

                                <h6 style="color:black !important;"> <strong> ' . $value['batch_id'] . ' </strong></h6>
                                <p class="text-body-primary mb-3">' . date("d-m-Y", strtotime($value['batch_entry_date'])) . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row form-block">
                <div class="col-12 mt-3">
                    <div class="table-responsive mb-4">
                        <form class="was-validated po_delivery_form" autocomplete="off">
                            <table class="table table-striped table-bordered align-middle table mb-0 small_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Item QTY</th>
                                       
                                        <th scope="col">Assign QTY</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $product_display_options = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                    foreach ($product_display_options as $key => $form_val) {
                        if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {



                            $table_product_details = 'product_details_sub';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
                            $columns1 = [

                                "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code)as item_code",

                                'product',
                                'qty',
                                'rem_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'tax',
                                'unique_id',

                            ];

                            $table_details1 = [
                                $table_product_details,
                                $columns1
                            ];
                        } else {

                            $table_assign_details = 'po_product_assign_details';
                            $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                            $columns1 = [
                                "item_code",
                                'product',
                                'qty',
                                'assign_qty',
                                'form_main_unique_id',
                                'unit_price',
                                'unique_id',
                                'product_unique_id',
                                'item_tax',
                                'rem_qty',

                            ];

                            $table_details1 = [
                                $table_assign_details,
                                $columns1
                            ];
                        }

                        $values_product = $pdo->select($table_details1, $where1);

                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            foreach ($product_array as $key => $product) {
                                $s_no = $s_no + 1;
                                $sum_item_qty += $product['qty'];
                                $get_bal_qty = get_bal_qty($product['product_unique_id'], $product['form_main_unique_id'], $value['batch_id']);

                                if (!empty($get_bal_qty)) {
                                    $bal_qty = $get_bal_qty[0]['bal_qty'];
                                } else {
                                    $bal_qty = $product['qty'];
                                }
                                if ($value['con_unique_id'] != '') {
                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                       
                                                    
                                                        <td>';
                                    if ($product['product_unique_id']) {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">';
                                    } else {
                                        $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control product_unique_id" value="' . $product['unique_id'] . '">';
                                    }
                                    $data .= '
<input type="hidden" id="main_unique_id" name="main_unique_id"
    class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

<input type="hidden" id="con_unique_id" name="con_unique_id[]"
    class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

<input type="hidden" id="po_unique_id" name="po_unique_id"
    class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

<input type="hidden" id="con_name" name="con_name[]"
    class="form-control con_name" value="' . $value['con_contact_name'] . '">

<input type="hidden" id="con_contact_no" name="con_contact_no[]"
    class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

<input type="hidden" id="item_code" name="item_code[]"
    class="form-control item_code" value="' . $product['item_code'] . '">

<input type="hidden" id="item_name" name="item_name[]"
    class="form-control item_name" value="' . $product['product'] . '">

<input type="hidden" id="unit_price" name="unit_price[]"
    class="form-control unit_price" value="' . $product['unit_price'] . '">

<input type="hidden" id="qty" name="qty[]"
    class="form-control qty" value="' . $product['qty'] . '">

<input type="hidden" id="rem_qty" name="rem_qty[]"
    class="form-control rem_qty" value="' . $bal_qty . '">
    
    <input type="hidden" id="stored_qty" name="stored_qty[]"
    class="form-control stored_qty" value="' . $get_bal_qty[0]['assign_qty'] . '">

<input type="hidden" id="less_qty" name="less_qty[]"
    class="form-control less_qty" value="' . $product['qty'] . '">

<input type="hidden" id="tax" name="tax[]"
    class="form-control tax" value="' . $product['item_tax'] . '">

<input type="hidden" id="con_sno" name="con_sno[]"
    class="form-control con_sno" value="' . $sno . '">
    <input type="hidden" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';


                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control bill_qty" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    $data .= '</td>
                                        </tr>';
                                } else {


                                    $data .= '<tr class="assign-row">
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
    <input type="hidden" id="product_unique_id" name="product_unique_id[]"
        class="form-control product_unique_id" value="' . $product['product_unique_id'] . '">

    <input type="hidden" id="main_unique_id" name="main_unique_id"
        class="form-control form_main_unique_id" value="' . $product['form_main_unique_id'] . '">

    <input type="hidden" id="con_unique_id" name="con_unique_id[]"
        class="form-control con_unique_id" value="' . $value['con_unique_id'] . '">

    <input type="hidden" id="po_unique_id" name="po_unique_id"
        class="form-control po_unique_id" value="' . $value['po_unique_id'] . '">

    <input type="hidden" id="con_name" name="con_name[]"
        class="form-control con_name" value="' . $value['con_contact_name'] . '">

    <input type="hidden" id="con_contact_no" name="con_contact_no[]"
        class="form-control con_contact_no" value="' . $value['con_contact_number'] . '">

    <input type="hidden" id="item_code" name="item_code[]"
        class="form-control item_code" value="' . $product['item_code'] . '">

    <input type="hidden" id="item_name" name="item_name[]"
        class="form-control item_name" value="' . $product['product'] . '">

    <input type="hidden" id="unit_price" name="unit_price[]"
        class="form-control unit_price" value="' . $product['unit_price'] . '">

    <input type="hidden" id="less_qty" name="less_qty[]"
        class="form-control less_qty" value="' . $product['qty'] . '">

    <input type="hidden" id="tax" name="tax[]"
        class="form-control tax" value="' . $product['tax'] . '">
        
        <input type="hidden" id="rem_qty" name="rem_qty[]"
    class="form-control rem_qty" value="' . $bal_qty . '">
    
    <input type="hidden" id="stored_qty" name="stored_qty[]"
    class="form-control stored_qty" value="' . $get_bal_qty[0]['assign_qty'] . '">

    <input type="hidden" id="qty" name="qty[]"
        class="form-control qty" value="' . $product['qty'] . '">

    <input type="hidden" id="con_sno" name="con_sno[]"
        class="form-control con_sno" value="' . $sno . '">
        <input type="hidden" id="con_main_address" name="con_main_address[]" class="form-control con_main_address" value="' . $value['con_address'] . '">';



                                    $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control bill_qty">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]" class="max_limit"></label>';

                                    // $data .= '</div>';

                                    $data .= '</td>
                                       </tr>';
                                }
                            }
                        }
                    }

                    $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
                }
            }
        }
        // }
        $json_array = [
            'data' => $data,
        ];

        echo json_encode($json_array);

        break;
    // pavi crud case






    case 'pending_verify_datatable':
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $unique_id = $_POST['unique_id'];
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
            "batch_id",
            // "'' as sno",
             "batch_id as batch",
            // "get_po_number(form_main_unique_id) as po_num",
            "'Not verified' as status"
        ];
    
    
    
    
        $table_details = [
            'consignee_details_sub',
            $columns
        ];
    
       $where = "form_main_unique_id ='".$unique_id."' and cons_verify_sts='2' GROUP BY batch_id";
    
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
    
        // Datatable Ordering 
        $order_by = datatable_sorting_elcot($order_column, $order_dir, $columns);
    
        // Datatable Searching
        $search_condition = datatable_searching($search, $columns);
    
        if ($search_condition) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search_condition;
        }
    
        $sql_function = "SQL_CALC_FOUND_ROWS";
    
        $result = $pdo->select($table_details, $where, $limit, $start,  $order_by, $sql_function);
        $total_records = total_records();
        $data = [];
    
        if ($result->status) {
            $res_array = $result->data;
    
            foreach ($res_array as $value) {
                $data[] = array_values($value);
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
    
    
    
       case 'approval':
    
        $table_cons = "consignee_details_sub";
    
        // Array of IDs received from AJAX
        $ids = $_POST['ids'];  // Example: ["PO123", "PO456"]
    
        // Convert to safe quoted list
        $ids_list = "'" . implode("','", $ids) . "'";
    
        // Columns to update
        $columns = [
            'cons_verify_sts' => 1
        ];
    
        // WHERE IN condition
        $update_where = "batch_id IN ($ids_list)";
    
        // Update
        $action_obj = $pdo->update($table_cons, $columns, $update_where);
    
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "update";
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }
    
        echo json_encode([
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ]);
    
        break;

    case 'get_po_consignees_verification':
        $po_id = $_POST['po_id'] ?? '';
        $data = [];
        $status = 0;
        $total = 0;
        $verified = 0;
        $pending = 0;

        if (!empty($po_id)) {
            $stmt = $conn->prepare("
                SELECT 
                    cds.unique_id,
                    cds.con_branch,
                    cds.con_branch_code,
                    cds.con_address,
                    get_district_name(cds.con_district) as district_name,
                    get_state_name(cds.con_state_name) as state_name,
                    cds.zone,
                    cds.con_pincode,
                    cds.con_contact_name,
                    cds.con_contact_number,
                    cds.con_lan_num,
                    cds.consignee_gst,
                    cds.cons_verify_sts,
                    (SELECT staff_name FROM user WHERE user.staff_id = cds.assign_team_member LIMIT 1) as assigned_team_member
                FROM consignee_details_sub cds
                WHERE cds.form_main_unique_id = :po_id AND cds.is_active = 1 AND cds.is_delete = 0
                ORDER BY cds.id ASC
            ");
            $stmt->execute([':po_id' => $po_id]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total = count($rows);

            foreach ($rows as $r) {
                if ($r['cons_verify_sts'] == '1') {
                    $verified++;
                } else {
                    $pending++;
                }
                $data[] = $r;
            }
            $status = 1;
        }

        echo json_encode([
            "status" => $status,
            "data" => $data,
            "total" => $total,
            "verified" => $verified,
            "pending" => $pending
        ]);
        break;

    case 'quick_toggle_consignee_verification':
        $consignee_id = $_POST['consignee_id'] ?? '';
        $new_status = $_POST['new_status'] ?? '1';

        $action_obj = (object)["status" => 0];
        if (!empty($consignee_id)) {
            $action_obj = $pdo->update('consignee_details_sub', ['cons_verify_sts' => $new_status], ['unique_id' => $consignee_id]);
        }

        echo json_encode([
            "status" => $action_obj->status ? 1 : 0,
            "msg" => $action_obj->status ? "success" : "error"
        ]);
        break;

    default:

        break;
}





function po_no_get1()
{
    $date = date('Y');
    $st_date = substr($date, 2);
    $month = date('m');
    $datee = $st_date . $month;
    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    }
    $stmt = $conn->query("SELECT * FROM po_form where `po_unique_id` LIKE 'PO%' order by id desc");

    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['po_unique_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r( $booking_no );
    }
    if ($booking_no == '') {
        $booking_nos = 'PO-' . $datee . '-0001';
        // echo "hii";
    } else {
        $booking_no += 1;
        $booking_nos = 'PO-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }
    // print_r( $booking_nos);die();
    return $booking_nos;
}

// po product assign po num generate

function product_assign_po_no_get()
{

    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connected successfully';
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM po_product_assign_details where `po_unique_id` LIKE '" . $_POST['po_unique_id'] . "' order by unique_id desc");

    if ($res1 = $stmt->fetch()) {

        $pur_array = $res1['po_unique_id'];
    }
    if ($pur_array == '')
        $pur_arrays = $_POST['po_unique_id'] . '-0001';
    // elseif ( $year != date( 'Y' ) )
    //     $pur_arrays = 'PO-' . $datee . '-0001';
    else {
        $pur_array += 1;
        $pur_arrays = $_POST['po_unique_id'] . '-' . str_pad($pur_array, 4, '0', STR_PAD_LEFT);
    }

    return $pur_arrays;
}





function image_view_2($folder_name = "", $unique_id = "", $file_name = "")
{
    $file_names = explode(',', $file_name);
    $image_view_2 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_2 .= "&nbsp";
                } else {
                    $image_view_2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_2 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_2 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_2 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_2 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }


    return $image_view_2;
}





function image_view_3($folder_name = "", $unique_id = "", $file_name = "")
{

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
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
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

// po filename

function image_view_po_file($folder_name = "", $unique_id = "", $file_name = "")
{


    $file_names = explode(',', $file_name);
    $image_view_po_file = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_po_file .= "&nbsp";
                } else {
                    $image_view_po_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_po_file .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_po_file .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/amc/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_po_file .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/amc/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_po_file .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/amc/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_po_file;
}

// po filename

function image_view_amc($folder_name = "", $unique_id = "", $po_file_name = "")
{


    $file_names = explode(',', $po_file_name);
    $image_view_amc = '';

    if ($po_file_name) {
        foreach ($file_names as $file_key => $po_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_amc .= "&nbsp";
                } else {
                    $image_view_amc .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $po_file_name);

            if ($po_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_amc .= '<a href="javascript:print_view_1(\'/' . $po_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_amc .= '<a href="javascript:print_pdf_amc(\'/' . $po_file_name . '\')"><img src="uploads/amc/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_amc .= '<a href="javascript:print_1(\'/' . $po_file_name . '\')"><img src="uploads/amc/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_amc .= '<a href="javascript:print_1(\'/' . $po_file_name . '\')"><img src="uploads/amc/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_amc;
}




// end 


function image_view_4($folder_name = "", $unique_id = "", $po_cancel_file = "")
{
    // echo $file_name;
    $file_names = explode(',', $po_cancel_file);
    $image_view_4 = '';

    if ($po_cancel_file) {
        foreach ($file_names as $file_key => $po_cancel_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_4 .= "&nbsp";
                } else {
                    $image_view_4 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $po_cancel_file);

            if ($po_cancel_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_4 .= '<a href="javascript:print_view_1(\'/' . po_cancel_file . '\')"><img src="uploads/' . $folder_name . '/' . $po_cancel_file . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_4 .= '<a href="javascript:print_pdf_1(\'/' . $po_cancel_file . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_4 .= '<a href="javascript:print_1(\'/' . $po_cancel_file . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_4 .= '<a href="javascript:print_1(\'/' . $po_cancel_file . '\')"><img src="uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_4;
}
// ───── Helper function to call stored procedure and consume all result sets ─────────
function myFunction(PDO $pdo, $formId, $qty, $totalValue)
{
    // debugging output
    echo $formId, '-', $qty, '-', $totalValue;

    $stmt = $pdo->prepare("CALL po_total_values_update(:form_id, :qty, :total_value)");
    $stmt->execute([
        ':form_id' => $formId,
        ':qty' => $qty,
        ':total_value' => $totalValue
    ]);

    do {
        $stmt->fetchAll(PDO::FETCH_ASSOC);
    } while ($stmt->nextRowset());

    $stmt->closeCursor();
}

function batch_id()
{
    $date = date('Y');
    $st_date = substr($date, 2); // last 2 digits of year
    $month = date('m'); // current month
    $datee = $st_date . $month; // e.g., 2504

    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    // echo "SELECT batch_id FROM consignee_details_sub WHERE batch_id LIKE 'PO-BAT-%' group by batch_id ORDER BY id DESC LIMIT 1";
    // Get latest batch ID
    $stmt = $conn->query("SELECT batch_id FROM consignee_details_sub WHERE batch_id LIKE 'PO-BAT-%' group by batch_id ORDER BY batch_id DESC LIMIT 1");

    $booking_no = 0;
    if ($res1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pur_array = explode('-', $res1['batch_id']); // e.g. [PO, BAT, YYMM, XXXX]
        if (count($pur_array) === 4) {
            $last_datee = $pur_array[2];
            $last_seq = (int) $pur_array[3];

            // if ($last_datee === $datee) {
            if ($last_seq) {
                $booking_no = $last_seq + 1;
            } else {
                $booking_no = 1; // reset for new month
            }
        }
    } else {
        $booking_no = 1; // first batch ever
    }

    $booking_nos = 'PO-BAT-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    return $booking_nos;
}
function moneyFormatIndia3($num) {
    // Ensure always 2 decimals
    $num = sprintf("%.2f", (float)$num);

    // Split into integer and decimal parts
    $parts = explode('.', $num);
    $int   = $parts[0];
    $dec   = $parts[1];

    // Handle negative numbers
    $sign = '';
    if ($num < 0) {
        $sign = '-';
        $int = ltrim($int, '-');
    }

    // Apply Indian number system formatting
    if (strlen($int) > 3) {
        $last3 = substr($int, -3);
        $rest  = substr($int, 0, -3);
        $rest  = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        $int   = $rest . ',' . $last3;
    }

    // return $sign . $int . '.' . $dec;
    echo  $sign . $int . '.' . $dec;
}





