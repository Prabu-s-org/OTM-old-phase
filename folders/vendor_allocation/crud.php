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
switch ($action) {
    case 'createupdate':
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        $con_contact_name = $_POST["con_contact_name"];
        $con_address = $_POST["con_address"];
        $con_contact_number = $_POST["con_contact_number"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_no = $_POST["invoice_no"];
        $invoice_auto_id = $_POST["invoice_auto_id"];
        $dispatch_status = $_POST["dispatch_status"];
        $stock_id = $_POST["stock_id"];
        $dispatch_date = $_POST["dispatch_date"];
        $mode_of_delivery = $_POST["mode_of_delivery"];
        $name_of_courier = $_POST["name_of_courier"];
        $pod_no = $_POST["pod_no"];
        $po_unique_id = $_POST["po_unique_id"];
        $po_form_unique_id = $_POST["po_form_unique_id"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $unique_id = $_POST["unique_id"];
        $update_where = "";
        $my_no = $_POST["my_no"];
        $parts = explode('/', $my_no);
        // Get the last value from the array
        $po_num_value = end($parts);

        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);


if (!empty($po_date)) {
    $date = DateTime::createFromFormat('d-m-Y', $po_date);
    if ($date !== false) {
        $po_date = $date->format('Y-m-d');
    }
}



        if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = $po_num_value . "-Dispatch" . '.pdf';

            move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
        // $allowedExts = array('pdf');
        // $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        // if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
        //     $tem_name = random_strings(25) . '.pdf';

        //     move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name);

        //     // Set $file_names to the stored filename with .pdf extension
        //     $file_names = $tem_name;
        //     $file_org_names = $_FILES['file']['name'];
        // }
        if (($file_names) && ($file_org_names)) {
            $columns = [
                "po_num" => $po_num,
                "po_date" => $po_date,
                "consignee" => $con_contact_name,
                "con_address" => $con_address,
                "con_contact_number" => $con_contact_number,
                "invoice_date" => $invoice_date,
                "invoice_no" => $invoice_no,
                "invoice_auto_id" => $invoice_auto_id,
                "stock_id" => $stock_id,
                "dispatch_date" => $dispatch_date,
                "mode_of_delivery" => $mode_of_delivery,
                "name_of_courier" => $name_of_courier,
                "pod_no" => $pod_no,
                "status" => 1,
                "po_unique_id" => $po_unique_id,
                "po_form_unique_id" => $po_form_unique_id,
                "consignee_unique_id" => $consignee_unique_id,
                'file_name' => $file_names,
                'file_org_name' => $file_org_names,
                "unique_id" => unique_id($prefix)
            ];
        } else {
            $columns = [
                "po_num" => $po_num,
                "po_date" => $po_date,
                "consignee" => $con_contact_name,
                "con_address" => $con_address,
                "con_contact_number" => $con_contact_number,
                "invoice_date" => $invoice_date,
                "invoice_no" => $invoice_no,
                "invoice_auto_id" => $invoice_auto_id,
                "stock_id" => $stock_id,
                "dispatch_date" => $dispatch_date,
                "mode_of_delivery" => $mode_of_delivery,
                "name_of_courier" => $name_of_courier,
                "pod_no" => $pod_no,
                "status" => 1,
                "po_unique_id" => $po_unique_id,
                "po_form_unique_id" => $po_form_unique_id,
                "consignee_unique_id" => $consignee_unique_id,
                "unique_id" => unique_id($prefix)
            ];
        }


        $table_details = [
            $table_dispatch,
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

        // print_r($action_obj );die();
        if ($data[0]['count']) {
            $msg = 'already';
        } else if (($data[0]['count'] == 0)) {


            $columns_1 = [
                "dispatch_status" => 1,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_1 = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" and invoice_no="' . $invoice_no . '"';
            $action_obj_1 = $pdo->update($table, $columns_1, $update_where_1);
            // print_r($action_obj_1);die();
            // Update Begins
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where = [
                    "unique_id" => $unique_id
                ];
                $action_obj = $pdo->update($table_dispatch, $columns, $update_where);
                // Update Ends
            } else {
                // Insert Begins
                $action_obj = $pdo->insert($table_dispatch, $columns);
                // Insert Ends
            }
            // print_r($action_obj);
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
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;


        $data = [];
        if ($length == '-1') {
            $limit = "";
        }

        // $table_pending = "dispatch_list";
        $table_pending = "invoice_creation_main";
        // Query Variables
        $json_array = "";

        $team_mem = $_POST['team_mem'];


        $columns = [

            "'' as s_no",
            "(SELECT po_num from po_form where po_form.unique_id = $table_pending.form_main_unique_id) as po_num",
            "invoice_no as inv_no",
            "dc_number",
            "(SELECT department FROM stock_position_main WHERE stock_position_main.form_main_unique_id =$table_pending.form_main_unique_id AND stock_position_main.is_delete=0  LIMIT 1) as department_name",
            // "team_mem",
            "''as cons_details",
            "get_user_name(invoice_creation_main.team_mem) as team_member",

            // "(SELECT con_address FROM consignee_details_sub 
            //     WHERE consignee_details_sub.unique_id = $table_pending.consignee_unique_id  
            //     ORDER BY consignee_details_sub.form_main_unique_id 
            //     LIMIT 1
            // ) as con_address",



            // "(SELECT zone FROM consignee_details_sub 
            //     WHERE consignee_details_sub.unique_id = $table_pending.consignee_unique_id  
            //     ORDER BY consignee_details_sub.form_main_unique_id 
            //     LIMIT 1
            // ) as zone",

            "invoice_qty",
            // "vendor_timeline",
            // "vendor_bulk_timeline",

            "unique_id",
            "invoice_no",
            "vendor_bulk_sts",
            "consignee_unique_id",
            "DATE_FORMAT(dc_date,'%d-%m-%Y')as dc_date",
            "(SELECT get_district_name(po.district) FROM po_form AS po WHERE po.unique_id = $table_pending.form_main_unique_id) AS district",
            "(SELECT get_state_name(po.state_name) FROM po_form AS po WHERE po.unique_id = $table_pending.form_main_unique_id) AS state",
            "bulk_eng_type as eng_type",
            "DATE_FORMAT(po_date,'%d-%m-%Y')as po_date",
            "DATE_FORMAT(invoice_date,'%d-%m-%Y')as invoice_date",
            "bulk_eng_name as eng_name_id",
            "DATE_FORMAT(vendor_bulk_timeline,'%d-%m-%Y') as vendor_timeline",

            "(SELECT state_name FROM state_creation WHERE state_creation.unique_id = ( SELECT con_state_name FROM consignee_details_sub  WHERE unique_id = $table_pending.consignee_unique_id  AND is_delete = 0 ORDER BY consignee_details_sub.form_main_unique_id LIMIT 1)  LIMIT 1) AS con_state_name",

            // "(SELECT district_name FROM district_creation 
            //     WHERE district_creation.unique_id = (
            //         SELECT con_district FROM consignee_details_sub 
            //         WHERE unique_id = $table_pending.consignee_unique_id 
            //           AND is_delete = 0  
            //           ORDER BY consignee_details_sub.form_main_unique_id
            //           LIMIT 1
            //     ) 
            //     LIMIT 1

            /// ) AS con_district",

            // "(SELECT con_address FROM consignee_details_sub  WHERE unique_id = $table_pending.consignee_unique_id AND is_delete = 0 ) AS con_address",
            //  "'' as cons_details",
            //  "(SELECT get_district_name(con_district) FROM consignee_details_sub  WHERE unique_id = $table_pending.consignee_unique_id AND is_delete = 0 ) AS con_district",
            "(SELECT get_state_name(con_state_name) FROM consignee_details_sub  WHERE unique_id = $table_pending.consignee_unique_id AND is_delete = 0 ) AS con_state",
            "team_mem"



            // " "get_district_name(cusdistrict) as district_name",
            //         "get_state_name(cusstate_name) as state_name""
        ];



        $table_details = [

            $table_pending,
            $columns
        ];


        $where = "is_delete='0' AND invoice_doc_status='4' AND vendor_bulk_sts = 0 AND invoice_no !=''";

        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }

        if ($_POST['from_date'] == '') {
            $from_date = date('Y-m-d');
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = date('Y-m-d');
        } else {
            $to_date = $_POST['to_date'];
        }
        if ($from_date && $to_date != '') {
            if ($opt1 == '101') {

                // $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
             STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

            } else if ($opt1 == '100') {

                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            }

        }
        $where .= "Order BY id DESC";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        // $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, '', $sql_function);
        // print_r($result);die();
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

                // $invoice_value = $value['invoice_value'];

                // $value['invoice_value']  = moneyFormatIndia1(($invoice_value));

                // $value['invoice_auto_id'] = $value['invoice_no'];

                // $value['invoice_date'] = '<span class="invoice_date">' . ($value['invoice_date']) . '</span>';
                $dc_number = $value['dc_number'];


                $invoice_qtSy = $value['invoice_qty'];


                $value['invoice_qty'] = '<div class="text-end"><b>' . $value['invoice_qty'] . '</b></div>';

                $eng_type = $value['eng_type'];

                $datetime = $value['vendor_timeline'];
                $formatted = str_replace("T", " ", $datetime);
                $value['vendor_timeline'] = $formatted;







                if ($eng_type == '') {

                    $value['eng_type'] = '--';

                }




                if ($eng_type == 'outsource-vendor') {

                    $eng_id = $value['eng_name_id']; // store ID before overwriting

                    $vendor_name = vendor_names($eng_id);

                    if (is_array($vendor_name) && !empty($vendor_name[0]['name'])) {
                        $value['eng_name_id'] = '<b>' . $vendor_name[0]['name'] . '</b><br>(' . $eng_type . ')';
                    } else {
                        $value['eng_name_id'] = '--';
                    }

                } else if ($eng_type == 'own-engineer') {

                    $eng_id = $value['eng_name_id']; // store ID before overwriting

                    $eng_name = engineer_name($eng_id);

                    if (is_array($eng_name) && !empty($eng_name[0]['engineer_name'])) {
                        $value['eng_name_id'] = '<b>' . $eng_name[0]['engineer_name'] . '</b><br>(' . $eng_type . ')';
                    } else {
                        $value['eng_name_id'] = '--';
                    }

                }

                $consignee_unique_id = $value['consignee_unique_id'];

                $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                $stmt->bindParam(':unique_id', $consignee_unique_id);
                $stmt->execute();

                $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($consignee_data)) {
                    $consigneeName = $consignee_data[0]["con_contact_name"];
                    $consigneeContact = $consignee_data[0]["con_contact_number"];
                    $consigneeLan = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress = $consignee_data[0]["con_address"];

                    $districtData = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeDistrict = is_array($districtData) ? $districtData[0] : $districtData;

                    $consigneeState = con_state_name_stock(($consignee_data[0]["con_state_name"]));
                    $consigneePincode = $consignee_data[0]["con_pincode"];
                    $consigneeZone = $consignee_data[0]["zone"];
                }



                $value['cons_details'] = '<b>' . strtoupper($consigneeName) . '</b><br>' .
                    $consigneeAddress . '<br>' .
                    $consigneeDistrict . '<br>' .
                    $consigneeState;


                // $btn_update = btn_update($folder_name, $value['unique_id']);

                $btn_update = update_dispatch_pending_btn($folder_name, $value['unique_id'], $value['consignee_unique_id'], $dc_number);


                $value['unique_id'] = $btn_update;

                //     $bulk_status = $value['vendor_bulk_sts'];

                //     if($bulk_status == '1'){
                //          $value['unique_id'] = '--';
                //     }

                //     else if((in_array('5f88082b25ec031952', $action_ids)) && ($bulk_status == '0')){
                //     $value['unique_id'] = $btn_update;
                // }
                // // if(in_array('5f88082b25ec031952', $action_ids)){
                // //     $value['unique_id'] = $btn_update;
                // // }
                // else{
                // //  if(in_array('5f8808504271036738', $action_ids)){
                // //     $value['unique_id'] = $btn_delete;
                // // }
                // // else{
                //     $value['unique_id'] = '-';
                // }

                $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>(' . $value['po_date'] . ')';

                $value['inv_no'] = '<b>' . $value['inv_no'] . '</b><br>(' . $value['invoice_date'] . ')';

                $value['dc_number'] = '<b>' . $value['dc_number'] . '</b><br>(' . $value['dc_date'] . ')';
                $value['department_name'] = '<b>' . $value['department_name'] . '</b><br>' . $value['district'] . '<br>' . $value['state'];


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




    case 'completed_datatable':

        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;

        $data = [];
        if ($length == '-1') {
            $limit = "";
        }

        // $table_pending = "dispatch_list";
        $table_pending = "invoice_creation_main";
        // Query Variables
        $json_array = "";

        $team_mem = $_POST['team_mem'];

        $columns = [

            "'' as s_no",
            "get_po_number(form_main_unique_id) AS po_num",
            // "(SELECT po_num from po_form where unique_id=$table_pending.form_main_unique_id) as po_num",
            "invoice_no as inv_no",
            "dc_number",
            "(SELECT department FROM stock_position_main WHERE stock_position_main.form_main_unique_id =$table_pending.form_main_unique_id  LIMIT 1) as department_name",
            "''as cons_details",
            "get_user_name(invoice_creation_main.team_mem) as team_member",
            "bulk_eng_name as eng_name_id",
            "invoice_qty",
            "DATE_FORMAT(vendor_bulk_timeline,'%d-%m-%Y') as vendor_timeline",
            "''as ageing",
            // "'' as installation_com_date",
            "'' as dates",
            "unique_id",
            "invoice_no",
            "vendor_bulk_sts",
            "consignee_unique_id",
            "DATE_FORMAT(dc_date,'%d-%m-%Y')as dc_date",

            "(SELECT get_district_name(po.district) FROM po_form AS po WHERE po.unique_id = $table_pending.form_main_unique_id) AS district",
            "(SELECT get_state_name(po.state_name) FROM po_form AS po WHERE po.unique_id = $table_pending.form_main_unique_id) AS state",
            "bulk_eng_type as eng_type",
            "DATE_FORMAT(po_date,'%d-%m-%Y')as po_date",
            "DATE_FORMAT(invoice_date,'%d-%m-%Y')as invoice_date",
            "DATE_FORMAT(date,'%d-%m-%Y') as date",

            "(SELECT DATE_FORMAT(installation_com_date, '%d-%m-%Y') FROM installation_details AS inst WHERE inst.dc_number = $table_pending.dc_number LIMIT 1) AS installation_com_date",
            "form_main_unique_id",
            "'' as department_details",
            "DATE_FORMAT(ven_assign_date,'%d-%m-%Y') AS assign_date",
            "DATE_FORMAT(vendor_ins_date,'%d-%m-%Y') AS vendor_ins_date",
            "team_mem",
            "ven_assign_date"

        ];



        $table_details = [

            $table_pending,
            $columns
        ];


        $where = "is_delete='0' AND vendor_bulk_sts = 1  AND po_date >= '$from_date'
          AND po_date <= '$to_date'";

        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }

        $to_date_converted = date('d-m-Y', strtotime($to_date));
       
        $where .= "Order BY id DESC";
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
       
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, '', $sql_function);
        // print_r($result);die();
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
                $dc_number = $value['dc_number'];



                $invoice_qtSy = $value['invoice_qty'];


                $value['invoice_qty'] = '<div class="text-end"><b>' . $value['invoice_qty'] . '</b></div>';

                // $value['dates'] = '<pre>Assign  : ' . $value['date'] . "\n" . 'Ins     : ' . $value['installation_com_date'] . '</pre>';
                $value['dates'] = '
<div style="font-family: inherit; font-size: inherit; line-height: 1.4; min-height: 40px;">
  <div>Assign :<b>' . ($value['assign_date'] ?? '-') . '</b></div>
  <div>Ins :<b>' . (!empty($value['vendor_ins_date']) ? $value['vendor_ins_date'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-') . '</b></div>
</div>';




                // $value['dates'] = 'Assign&nbsp;&nbsp;:&nbsp;<b>' . $value['date'] . '</b><br>Ins&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<b>' . $value['installation_com_date'] . '</b>';




                $eng_type = $value['eng_type'];

                $datetime = $value['vendor_timeline'];
                $formatted = str_replace("T", " ", $datetime);
                $value['vendor_timeline'] = $formatted;




                if ($eng_type == '') {

                    $value['eng_type'] = '--';

                }

                if ($eng_type == 'outsource-vendor') {

                    $eng_id = $value['eng_name_id']; // store ID before overwriting

                    $vendor_name = vendor_names($eng_id);

                    if (is_array($vendor_name) && !empty($vendor_name[0]['name'])) {
                        $value['eng_name_id'] = '<b>' . $vendor_name[0]['name'] . '</b><br>(' . $eng_type . ')';
                    } else {
                        $value['eng_name_id'] = '--';
                    }

                } else if ($eng_type == 'own-engineer') {

                    $eng_id = $value['eng_name_id']; // store ID before overwriting

                    $eng_name = engineer_name($eng_id);

                    if (is_array($eng_name) && !empty($eng_name[0]['engineer_name'])) {
                        $value['eng_name_id'] = '<b>' . $eng_name[0]['engineer_name'] . '</b><br>(' . $eng_type . ')';
                    } else {
                        $value['eng_name_id'] = '--';
                    }

                }


                $consignee_unique_id = $value['consignee_unique_id'];

                $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                $stmt->bindParam(':unique_id', $consignee_unique_id);
                $stmt->execute();

                $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($consignee_data)) {
                    $consigneeName = $consignee_data[0]["con_contact_name"];
                    $consigneeContact = $consignee_data[0]["con_contact_number"];
                    $consigneeLan = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress = $consignee_data[0]["con_address"];

                    $districtData = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeDistrict = is_array($districtData) ? $districtData[0] : $districtData;

                    $consigneeState = con_state_name_stock(($consignee_data[0]["con_state_name"]));
                    $consigneePincode = $consignee_data[0]["con_pincode"];
                    $consigneeZone = $consignee_data[0]["zone"];
                }


                $value['cons_details'] = '<b>' . strtoupper($consigneeName) . '</b><br>' .
                    $consigneeAddress . '<br>' .
                    $consigneeDistrict . '<br>' .
                    $consigneeState;

                //  $value['date'] = $value['date'];

                $assigned_date = $value['vendor_ins_date']; // Format should be 'Y-m-d' or similar
                $timeline_date = $value['vendor_timeline'];

                if (!empty($assigned_date) && !empty($timeline_date)) {
                    $date1 = new DateTime($assigned_date);
                    $date2 = new DateTime($timeline_date);
                    $interval = $date1->diff($date2);
                    $value['ageing'] = $interval->days . ' Days';
                } else {
                    $value['ageing'] = '--';
                }


                $btn_update = update_dispatch_pending_btn($folder_name, $value['unique_id'], $value['consignee_unique_id'], $dc_number);

                $value['unique_id'] = $btn_update;

                $value['po_num'] = '<b>' . $value['po_num'] . '</b><br>' . $value['po_date'];

                $value['inv_no'] = '<b>' . $value['inv_no'] . '</b><br> ' . $value['invoice_date'];

                $value['dc_number'] = '<b>' . $value['dc_number'] . '</b><br> ' . $value['dc_date'];


                $value['department_name'] = '<b>' . $value['department_name'] . '</b><br>' . $value['district'] . '<br>' . $value['state'];


                // }
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






    case 'fixed_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_transit = "view_dispatch_transit_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_num",
            // "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            "po_date",
            // "consignee",

            // "department",
            // "ledger_name",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_transit . ".ledger_name and department_creation_sublist.is_delete='0'  ) AS ledger_name",

            "(select con_address from consignee_details_sub where unique_id = $table_transit.consignee_unique_id and consignee_details_sub.is_delete=0) AS con_address",
            // "con_address",
            "invoice_no",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "invoice_date",
            "DATE_FORMAT(dispatch_date, '%d-%m-%Y') AS dispatch_date",
            // "dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
            // "(SELECT courier_name FROM courier_creation WHERE courier_creation.unique_id = " . $table_transit . ".name_of_courier and courier_creation.is_delete='0'  ) AS name_of_courier",

            "pod_no",
            "status",
            "unique_id",
            // "(select po_unique_id from po_form where unique_id = $table_dispatch.po_form_unique_id) AS po_unique_id",
            "invoice_auto_id",
            "po_form_unique_id",
            "consignee_unique_id",
            "invoice_no"
        ];
        $table_details = [
            // $table_dispatch,
            $table_transit,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";
        // $where = " is_delete = '0' and status='1' ";
        $where = "";
        if ($_POST['from_date'] == '') {
            $from_date = date('Y-m-d');
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = date('Y-m-d');
        } else {
            $to_date = $_POST['to_date'];
        }

        if ($opt == '4') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
            STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";


        } else if ($opt == '5') {
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(invoice_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
                      STR_TO_DATE(invoice_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
        }

        // else if($opt == '6') {

        //     $where .= "AND dispatch_date >= '" . $from_date . "' AND dispatch_date <= '" . $to_date . "' ";
        // } 
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";



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
                // $value['invoice_no'] = $value['invoice_no'];
                // $value['po_num'] = $value['po_num'];
                //  $invoice_qty = $value['invoice_qty'];
                //  $unit_price = $value['unit_price'];
                //  $value['unit_price'] =(($unit_price )*($invoice_qty));
                // $orgDate = $value['po_date'];  
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                // $orgDate1 = $value['invoice_date'];  
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                $value['dispatch_date'] = '<span class="invoice_date">' . $value['dispatch_date'] . '</span>';

                // $orgDate2 = $value['dispatch_date'];  
                // $value['dispatch_date'] = date("d-m-Y", strtotime($orgDate2));

                if ($value['status'] == "1") {
                    $value['status'] = "Pending";
                }
                if ($value['mode_of_delivery'] == "1") {
                    $value['mode_of_delivery'] = "Hand";
                } else {
                    $value['mode_of_delivery'] = "Courier";
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

                // $value['unique_id'] = '<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '&consignee_unique_id=' . $value['consignee_unique_id'] . '&invoice_no=' . $value['invoice_no'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

                // $value['po_form_unique_id'] = $btn_update;
                $btn_update = btn_update_dispatch($folder_name, $value['po_form_unique_id'], $value['consignee_unique_id'], $value['invoice_no']);

                if (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['unique_id'] = $btn_update;


                } else {
                    //  if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    // else{
                    $value['unique_id'] = '';
                }
                // '<a href="index.php?file=dispatch/update1&unique_id='.$value['po_form_unique_id'] . '&consignee_unique_id=' . $value['consignee_unique_id'] . '&invoice_no=' . $value['invoice_no'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
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
    // get second tab
    case 'deleivery_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_delivery = "view_dispatch_delivery_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_num",
            "po_date",
            // "consignee",
            // "(select department from stock_position_main where form_main_unique_id = $table_dispatch.po_form_unique_id) AS con_contact_name",
            // "department",
            // "ledger_name",
            // "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_delivery . ".ledger_name and department_creation_sublist.is_delete='0'  ) AS ledger_name",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table_delivery . ".ledger_name) AS ledger_name",

            "(select con_address from consignee_details_sub where unique_id = $table_delivery.consignee_unique_id and consignee_details_sub.is_delete=0 ) AS con_address",
            // "con_address",
            "invoice_no",
            "invoice_date",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",

            "pod_no",
            "delivery_status",
            "delivery_date",
            "delivery_proof",
            // "name_of_courier",
            // "status",
            "unique_id",
            // "(select po_unique_id from po_form where unique_id = $table_dispatch.po_form_unique_id) AS po_unique_id",
            "invoice_auto_id",
            //   "consignee_unique_id"
        ];
        $table_details = [
            // $table_dispatch,
            $table_delivery,
            $columns
        ];
        // print_r(  $columns);die();s
        // $where = ""; 


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
        //    if($from_date && $to_date != '') {
        if ($opt3 == '40') {

            $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
            // $from_date_converted = date('d-m-Y', strtotime($from_date));
            // $to_date_converted = date('d-m-Y', strtotime($to_date));
            // $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
            //  STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

        } else if ($opt3 == '50') {

            $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
        }
        // else if($opt3 == '60') {

        //     $where = "dispatch_date >= '" . $from_date . "' AND dispatch_date <= '" . $to_date . "' ";
        //  $from_date_converted = date('d-m-Y', strtotime($from_date));
        // $to_date_converted = date('d-m-Y', strtotime($to_date));
        // $where = "STR_TO_DATE(dispatch_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
        //  STR_TO_DATE(dispatch_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

        // }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";


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
        $total_records = total_records();
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $orgDate = $value['po_date'];
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                // $orgDate1 = $value['invoice_date'];  
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                $orgDate2 = $value['delivery_date'];
                $value['delivery_date'] = date("d-m-Y", strtotime($orgDate2));
                // $value['invoice_no'] = $value['invoice_no'];
                // $value['po_num'] = $value['po_num'];
                $value['delivery_proof'] = image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
                //  $invoice_qty = $value['invoice_qty'];
                //  $unit_price = $value['unit_price'];
                //  $value['unit_price'] =(($unit_price )*($invoice_qty));
                if ($value['delivery_status'] == "1") {
                    $value['delivery_status'] = "yes";
                } else if ($value['delivery_status'] == "2") {
                    $value['delivery_status'] = "NO";
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

                // else {
                //     $value['status']   = "Complete";
                // }
                // $btn_update= '<a href="po_form_unique_id='.$value['po_form_unique_id'].'" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl1"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>';
                // $btn_update         = btn_update($folder_name,$value['unique_id']);
                $value['unique_id'] = '<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                // $btn_delete         = btn_delete($folder_name,$value['unique_id']);
                $value['po_form_unique_id'] = $btn_update;
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




    case 'pending_list_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];

        $invoice_no = $_POST['invoice_no'];

        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];


        // $table_doc = "view_dispatch_completed_list";
        $table_doc = "invoice_creation_main";


        $data = [];
        $po_id = $_POST['po_id'];

        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [

            "unique_id as invoice_unique_id",

            "'' as sno",
            "unique_id as invoice_unique_id",
            "(Select po_num from po_form where unique_id =$table_doc.form_main_unique_id) AS po_num",
            "invoice_no",
            "dc_number",
            "invoice_qty",
            "''as department",
            "'' as cons_details",

            // "approved_by",

            "po_date",
            "invoice_date",
            "dc_date",
            // "department",

            "vendor_bulk_sts",
            "invoice_qty",


            "form_main_unique_id",
            "consignee_unique_id",
            "(SELECT get_district_name(po.district) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS district",
            "(SELECT get_state_name(po.state_name) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS state",


            // "unique_id"
        ];
        $table_details = [
            $table_doc,
            $columns
        ];


        // $where  = 
        // $where          = [
        //     "is_delete"     => 0
        // ];
        $order_by = "";



        // $where = "invoice_no = '$invoice_no' AND vendor_bulk_sts ='0'";
        
    if($invoice_no != 'All'){
        $where = "form_main_unique_id = '$po_id' and invoice_no = '$invoice_no' AND material_qc = '1'  AND (vendor_bulk_sts = '0' OR vendor_bulk_sts = '' OR vendor_bulk_sts IS NULL)  and is_delete = 0";
}

if($invoice_no == 'All'){
    $where = "form_main_unique_id = '$po_id' and material_qc = '1'  AND (vendor_bulk_sts = '0' OR vendor_bulk_sts = '' OR vendor_bulk_sts IS NULL) and is_delete = 0";
}




        // $where = "ac_team_verifiy_status =  0 and ac_team_verifiy_status != 1 ";

        // if($ac_team_verifiy_status != ''){
        //     $where .= " AND ac_team_verifiy_status LIKE '%".$ac_team_verifiy_status."%'";
        // }


        // $order_by  = "ac_team_verifiy_status='0' DESC";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "ac_team_verifiy_status='0' $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }



        // $sql_function   = "SQL_CALC_FOUND_ROWS";

        // $sql_function = "SQL_CALC_FOUND_ROWS";



        // $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " FROM $table_doc $where $order_by LIMIT $limit OFFSET $start";

        // $total_records = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();



        //  print_r('total_records');die();




        $result = $pdo->select($table_details, $where);

        $total_records = total_records();
        //  print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_unique_id = $value['invoice_unique_id'];

                $invoice_qty = $value['invoice_qty'];

                $dc_number = $value['dc_number'];
                 $po_no  = $value['form_main_unique_id'];

//                 $value['invoice_unique_id'] = '<div class="checkbox-container">

//                         <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox" onclick="get_productdetails();"  data-invoice-qty ="' . $invoice_qty . '"
//                         data-id = "' . $dc_number . '"   data-pono = "' . $po_no . '">

                        
//                     <input type="hidden"  name="dc_total_amount[' . $dc_number . ']" id="dc_total_' . $dc_number . '" 
//                    value="">
// <input type="hidden"  name="dc_total_amount[' . $dc_number . ']" id="dc_total_' . $dc_number . '" 
//                    value="">
//                     <input type="hidden" name="my_dc_num[' . $dc_number . ']" id="my_dc_num' . $dc_number . '" value="' . $dc_number . '">
//                         <input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="1">
//                         <input type="hidden" name="invoice_id" id="invoice_id" value="' . $invoice_unique_id . '">
//                         <input type="hidden" name="approved_by" id="approved_by" value="' . $session_approved_by . '">
//                   <input type="hidden" name="approved_by" id="approved_by" value="' . $invoice_qty . '">

//                     </div>';

$value['invoice_unique_id'] = '
<div class="checkbox-container">

    <input class="myCheck" 
        type="checkbox" 
        name="bill_checkbox[]"  
        onclick="get_productdetails();"  
        data-invoice-qty="' . $invoice_qty . '"
        data-dc="' . $dc_number . '"   
        data-pono="' . $po_no . '">

    <input type="hidden" name="dc_total_amount[' . $dc_number . ']" 
        id="dc_total_' . $dc_number . '" value="">

    <input type="hidden" name="my_dc_num[' . $dc_number . ']" 
        value="' . $dc_number . '">

    <input type="hidden" name="doc_approval_sts" value="1">
    <input type="hidden" name="invoice_id" value="' . $invoice_unique_id . '">
    <input type="hidden" name="approved_by" value="' . $session_approved_by . '">

</div>';

                $value['invoice_qty'] = '<div style="text-align:right;"><b>' . $value['invoice_qty'] . '</b></div>';




                $value['sno'] = $sno++;





                $po_num = $value['po_num'];

                $form_main_unique_id = $value['form_main_unique_id'];



                $department = $value['department'];

                //    $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
                //     $stmtCus->bindParam(':unique_id', $form_main_unique_id);
                //     $stmtCus->execute();

                //     $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

                //     if (!empty($customer_data)) {
                //             $customerAddress    = $customer_data[0]["bill_address"];
                //             $customerName  = $customer_data[0]["contact_name"];
                //             $customerContact  = $customer_data[0]["contact_number"];
                //             $customerLan         = $customer_data[0]["landline_number"];
                //             $customerEmail = $customer_data[0]["email"];
                //             $customerState      = $customer_data[0]["state_name"];
                //             $customerDistrict      = district_name($customer_data[0]["district"]);
                //             $customrePincode      = $customer_data[0]["pin"];
                //         }


                //     $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                //     $stmt->bindParam(':unique_id', $consignee_unique_id);
                //     $stmt->execute();

                //           $value['department'] = '<b>' . strtoupper($customerName) . '</b><br>' .  
                //                  $customerAddress . '<br>' . 
                //                   $customerDistrict.'<br>' .
                //                  $customerState . '<br>' . 
                //                  $customerContact;



                $consignee_unique_id = $value['consignee_unique_id'];



                $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                $stmt->bindParam(':unique_id', $consignee_unique_id);
                $stmt->execute();

                $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($consignee_data)) {
                    $consigneeName = $consignee_data[0]["con_contact_name"];
                    $consigneeContact = $consignee_data[0]["con_contact_number"];
                    $consigneeLan = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress = $consignee_data[0]["con_address"];

                    $districtData = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeDistrict = is_array($districtData) ? $districtData[0] : $districtData;

                    $consigneeState = con_state_name_stock(($consignee_data[0]["con_state_name"]));
                    $consigneePincode = $consignee_data[0]["con_pincode"];
                    $consigneeZone = $consignee_data[0]["zone"];
                }



                $value['cons_details'] = '<b>' . strtoupper($consigneeName) . '</b><br>' .
                    $consigneeAddress . '<br>' .
                    $consigneeZone . '<br>' .
                    $consigneeDistrict . '<br>' .
                    $consigneeState;





                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];



                // $value['file_name']=$value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);


                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
                    Comparison Attachment </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                            <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                            <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                            <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                        </div>
                                    </div>
                                  
                                    <div class="row mt-2">
                                       <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                           <h4 class="text-center">PO Attachment</h4>
                                                <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="400">
                                                    <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="400">
                                                    </iframe>
                                                </object>
                                        </div>
                                        <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">DC Attachment</h4>
                                            <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">IR Attachment</h4>
                                            <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                            <h4 class="text-center">Invoice Attachment</h4>
                                            <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->';

                // $value['file_name']='<a href="uploads/po_form/pdf.png"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a>';
                // $value['file_name']=$value['file_name'];
                // $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                // $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                // $value['ir_file_name']     =  image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                // $value['file_invoice']     =  image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                //   $file2 = "uploads/po_form/po_attach/pdf.png";
                // $orgDate = $value['po_date'];  
                // // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


                // if($value['invoice_date']==''){
                //     $value['invoice_date']='';
                // }
                // else{
                // //     $orgDate1 = $value['invoice_date'];  
                // // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                // $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                // }


                // // $btn_update         = btn_update($folder_name, $value['invoice_unique_id']);
                // // $btn_delete         = btn_delete($folder_name,$value['invoice_unique_id']);
                // // $value['invoice_unique_id'] = $btn_update . $btn_delete;
                // $d = $value['invoice_no'];
                // $where_2 = "invoice_no = '".$d."' and is_delete='0' and ORDER BY ac_team_verifiy_status='0' DESC";
                // // and ORDER BY ac_team_verifiy_status='0' DESC

                // $table_1      =  "dispatch_list";

                // $columns_2    = [
                //     'COUNT(invoice_no) AS count'
                // ];

                // $table_details_1   = [
                //     $table_1,
                //     $columns_2
                // ];

                // $result_values_12  = $pdo->select($table_details_1, $where_2); 
                // print_r($result_values_12);die();
                // $data_st       = $result_values_12->data;
                // // print_r($data_st[0]['count']);
                // print_r($data_st[0]['count']);die();
                // $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                // $btn_view           = btn_view1($folder_name, $value['unique_id'] );
                // 


                // '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" type="button">';

                // $value['unique_id'] = $btn_update . $btn_delete;

                $approval_sts = $value['ac_team_verifiy_status'];

                if ($approval_sts == '1') {

                    $value['ac_team_verifiy_status'] = 'Approved';
                } elseif ($approval_sts == '2') {

                    $value['ac_team_verifiy_status'] = 'Not Approval';
                } else {
                    $value['ac_team_verifiy_status'] = 'Pending';

                }

                $value['po_num'] = '<b>' . $value['po_num'] . '</b>' . '<br>' . $value['po_date'];


                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b>' . '<br>' . $value['invoice_date'];

                $value['dc_number'] = '<b>' . $value['dc_number'] . '</b>' . '<br>' . $value['dc_date'];
                $value['department'] = '<b>' . strtoupper($department) . '</b><br>' . $value['district'] . '<br>' . $$value['state'];


                $data[] = array_values($value);
                // $sno++;
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




           case 'completed_list_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];

        $invoice_no = $_POST['invoice_no'];

        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];


        // $table_doc = "view_dispatch_completed_list";
        $table_doc = "invoice_creation_main";


        $data = [];
        $po_id = $_POST['po_id'];

        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [

            "unique_id as invoice_unique_id",

            "'' as sno",
            "unique_id as invoice_unique_id",
            "(Select po_num from po_form where unique_id =$table_doc.form_main_unique_id) AS po_num",
            "invoice_no",
            "dc_number",
            "invoice_qty",
            "''as department",
            "'' as cons_details",

            // "approved_by",

            "po_date",
            "invoice_date",
            "dc_date",
            // "department",

            "vendor_bulk_sts",
            "invoice_qty",


            "form_main_unique_id",
            "consignee_unique_id",
            "(SELECT get_district_name(po.district) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS district",
            "(SELECT get_state_name(po.state_name) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS state",


            // "unique_id"
        ];
        $table_details = [
            $table_doc,
            $columns
        ];


        // $where  = 
        // $where          = [
        //     "is_delete"     => 0
        // ];
        $order_by = "";



        // $where = "invoice_no = '$invoice_no' AND vendor_bulk_sts ='0'";
        
//     if($invoice_no != ''){
//         $where = "form_main_unique_id = '$po_id' and invoice_no = '$invoice_no' AND material_qc = '1' AND vendor_bulk_sts ='0' and is_delete = 0";
// }

// if($invoice_no == ''){
//     $where = "form_main_unique_id = '$po_id' and material_qc = '1' and vendor_bulk_sts ='0' and is_delete = 0";
// }


  $where = "is_delete='0' AND vendor_bulk_sts = 1 AND invoice_no ='$invoice_no'";


        // $order_by  = "ac_team_verifiy_status='0' DESC";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "ac_team_verifiy_status='0' $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }



       




        $result = $pdo->select($table_details, $where);

        $total_records = total_records();
        //  print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_unique_id = $value['invoice_unique_id'];

                $invoice_qty = $value['invoice_qty'];

                $dc_number = $value['dc_number'];
                 $po_no  = $value['form_main_unique_id'];

                $value['invoice_unique_id'] = '<div class="checkbox-container">

                        <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox"   data-invoice-qty ="' . $invoice_qty . '"
                        data-dc = "' . $dc_number . '"   data-pono = "' . $po_no . '">

                        
                    <input type="hidden"  name="dc_total_amount[' . $dc_number . ']" id="dc_total_' . $dc_number . '" 
                   value="">
<input type="hidden"  name="dc_total_amount[' . $dc_number . ']" id="dc_total_' . $dc_number . '" 
                   value="">
                    <input type="hidden" name="my_dc_num[' . $dc_number . ']" id="my_dc_num' . $dc_number . '" value="' . $dc_number . '">
                        <input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="1">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="' . $invoice_unique_id . '">
                        <input type="hidden" name="approved_by" id="approved_by" value="' . $session_approved_by . '">
                  <input type="hidden" name="approved_by" id="approved_by" value="' . $invoice_qty . '">

                    </div>';


                $value['invoice_qty'] = '<div style="text-align:right;"><b>' . $value['invoice_qty'] . '</b></div>';




                $value['sno'] = $sno++;





                $po_num = $value['po_num'];

                $form_main_unique_id = $value['form_main_unique_id'];



                $department = $value['department'];


                $consignee_unique_id = $value['consignee_unique_id'];



                $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                $stmt->bindParam(':unique_id', $consignee_unique_id);
                $stmt->execute();

                $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($consignee_data)) {
                    $consigneeName = $consignee_data[0]["con_contact_name"];
                    $consigneeContact = $consignee_data[0]["con_contact_number"];
                    $consigneeLan = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress = $consignee_data[0]["con_address"];

                    $districtData = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeDistrict = is_array($districtData) ? $districtData[0] : $districtData;

                    $consigneeState = con_state_name_stock(($consignee_data[0]["con_state_name"]));
                    $consigneePincode = $consignee_data[0]["con_pincode"];
                    $consigneeZone = $consignee_data[0]["zone"];
                }



                $value['cons_details'] = '<b>' . strtoupper($consigneeName) . '</b><br>' .
                    $consigneeAddress . '<br>' .
                    $consigneeZone . '<br>' .
                    $consigneeDistrict . '<br>' .
                    $consigneeState;





                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];



                // $value['file_name']=$value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);


                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
                    Comparison Attachment </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                            <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                            <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                            <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                        </div>
                                    </div>
                                  
                                    <div class="row mt-2">
                                       <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                           <h4 class="text-center">PO Attachment</h4>
                                                <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="400">
                                                    <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="400">
                                                    </iframe>
                                                </object>
                                        </div>
                                        <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">DC Attachment</h4>
                                            <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">IR Attachment</h4>
                                            <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                            <h4 class="text-center">Invoice Attachment</h4>
                                            <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->';


                $approval_sts = $value['ac_team_verifiy_status'];

                if ($approval_sts == '1') {

                    $value['ac_team_verifiy_status'] = 'Approved';
                } elseif ($approval_sts == '2') {

                    $value['ac_team_verifiy_status'] = 'Not Approval';
                } else {
                    $value['ac_team_verifiy_status'] = 'Pending';

                }

                $value['po_num'] = '<b>' . $value['po_num'] . '</b>' . '<br>' . $value['po_date'];


                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b>' . '<br>' . $value['invoice_date'];

                $value['dc_number'] = '<b>' . $value['dc_number'] . '</b>' . '<br>' . $value['dc_date'];
                $value['department'] = '<b>' . strtoupper($department) . '</b><br>' . $value['district'] . '<br>' . $$value['state'];


                $data[] = array_values($value);
                // $sno++;
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





    case 'product_details_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;


        $dc_no = $_POST['dc_no'];

        $po_no = $_POST['po_no'];

        $table = "invoice_creation";

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        $gst_type = $_POST['gst_type'];

        if (is_array($dc_no) && !empty($dc_no)) {
            // Sanitize and quote each value
            $dc_list = array_map(function ($dc) {
                return "'" . addslashes($dc) . "'";
            }, $dc_no);

            // Join with commas properly
            $where = "dc_num IN (" . implode(",", $dc_list) . ")";
        } else {
            $where = "dc_num = '" . addslashes($dc_no) . "'";
        }

        
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as sno",
            "item_code",
            //
            "sum(invoice_qty) as invoice_qty",
            "'' as rate",
            "'' as gst",
            "''as tax_amount",
            "'' as total_amount",
            "product",
            "dc_num as dc_no",
            "po_unique_id",
            "product_unique_id",
            "item_code as itemdetails",
            "product",
            "dc_num",
            "'' as hidden_data",
            "GROUP_CONCAT(DISTINCT dc_num SEPARATOR ', ') as dc_no",
            "GROUP_CONCAT(CONCAT('\"', dc_num, '\":', invoice_qty)) AS dc_qty_map",
            // "JSON_OBJECTAGG(dc_num, invoice_qty) as dc_qty_map",
            "invoice_qty as qty",
            "invoice_no",
            "id"
            // "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $group_by = "product_unique_id";

        $order_by = "id";

        $where .= " AND po_unique_id = '$po_no' AND is_delete = '0'";

        $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);
// print_r( $result);

        $total_records = total_records();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $value['sno'] = $sno;

                $qty = isset($value['invoice_qty']) ? $value['invoice_qty'] : 0;

                $dc_qty_map_array = [];

                foreach ($dc_qty_data as $dc_no => $qty) {
                    $dc_qty_map_array[$dc_no] = (float) $qty; // Make sure it's a number
                }

                // $dc_qty_map_json = htmlspecialchars(json_encode($dc_qty_map_array), ENT_QUOTES, 'UTF-8');

                $value['item_code'] = '
                    <b>' . htmlspecialchars($value['item_code']) . '</b><br>' . htmlspecialchars($value['product']) . '
                    <input type="hidden" class="ven_po_unique_id" value="' . htmlspecialchars($value['po_unique_id']) . '">
                    <input type="hidden" class="ven_product_unique_id" value="' . htmlspecialchars($value['product_unique_id']) . '">
                    <input type="hidden" class="ven_item_code" value="' . htmlspecialchars($value['item_code']) . '">
                    <input type="hidden" class="ven_product" value="' . htmlspecialchars($value['product']) . '">
                    <input type="hidden" class="ven_dc_no" value="' . htmlspecialchars($value['dc_no']) . '">
                     <input type="hidden" class="ven_invoice_no" value="' . htmlspecialchars($value['invoice_no']) . '">

                    <input type="hidden" class="qty_map" value=\'' . $qty . '\'>
                ';


                // $value['item_code'] ='<b>'.$value['item_code'].'</b><br>'.$value['product']
                //  <input type="hidden" class="dc_qty_map" value=\'' . $dc_qty_map_json . '\'>

                //   <input type="hidden" class="ven_po_unique_id" value="' . htmlspecialchars($value['po_unique_id']) . '">
                // <input type="hidden" class="ven_product_unique_id" value="' . htmlspecialchars($value['product_unique_id']) . '">
                // <input type="hidden" class="ven_item_code" value="' . htmlspecialchars($value['item_code']) . '">
                // <input type="hidden" class="ven_product" value="' . htmlspecialchars($value['product']) . '">
                // <input type="hidden" class="ven_dc_no" value="' . htmlspecialchars($value['dc_num']) . '">;

                // $value['dc_no'] = '<input type="hidden" name="dc_no[]" value="'.($value['dc_num']).'">';

                // $value['rate'] = '<input type="text" name="rate[]" class="form-control" id="pd_rate_' . $sno . '" oninput="gstcalculation(' . $sno . ')">';

                $value['invoice_qty'] = '<div style="text-align:right;"><span class="qty" style="font-weight:bold;" name="qty[]"  id="pd_qty_' . $sno . '" data-value="' . htmlspecialchars($qty) . '">' . htmlspecialchars($qty) . '</span></div>';

                if($gst_type == 1){
                    $value['gst'] = '<div style="text-align:right;"><b>18 %</b></div>';
                }else if ($gst_type == 2){
                    $value['gst'] = '<div style="text-align:right;"><b>0 %</b></div>';
                }

                $value['tax_amount'] = '<div style="text-align:right;"><span class="tax_amount" style="font-weight:bold;" id="tax_amnt_' . $sno . '"></span></div>';



                // $value['tax_amount'] = '<span class="tax_amount"  style="text-align:right; font-weight:bold;" id="tax_amnt_' . $sno . '"></span>';

                $value['total_amount'] = '<div style="text-align:right;"><span class="total_amount" style="font-weight:bold;;"  id="pd_ttl_amnt_' . $sno . '"></span></div>';


                // $value['dc_no'] = '<input type="hidden" name="dc_no[]" value="'.($value['dc_num']).'">';

                $value['rate'] = '<div style="text-align:right;"><input type="text" name="rate[]"  onkeypress="allowNumberdecimal(event)" class="form-control" id="pd_rate_' . $sno . '" oninput="gstcalculation(' . $sno . ')"></div>';

                // $value['dc_qty_map'] = '<input type="hidden" class="dc_qty_map" value=\'' . json_encode($dc_qty_map) . '\'>';


                // $value['po_unique_id'] = '<input type="text" name="po_unique_id[]" value="'.($value['po_unique_id']).'">';

                // $value['product_unique_id'] = '<input type="text" name="product_unique_id[]" value="'.($value['product_unique_id']).'">';

                // $value['itemdetails'] = '<input type="text" name="item_code[]" value="'.($value['item_code']).'">';

                // $value['product'] = '<input type="text" name="product[]" value="'.($value['product']).'">';

                // $value['hidden_data'] = '
//     <input type="hidden" class="ven_po_unique_id" value="' . htmlspecialchars($value['po_unique_id']) . '">
//     <input type="hidden" class="ven_product_unique_id" value="' . htmlspecialchars($value['product_unique_id']) . '">
//     <input type="hidden" class="ven_item_code" value="' . htmlspecialchars($value['item_code']) . '">
//     <input type="hidden" class="ven_product" value="' . htmlspecialchars($value['product']) . '">
//     <input type="hidden" class="ven_dc_no" value="' . htmlspecialchars($value['dc_num']) . '">
// ';




                //        $value['po_unique_id'] = '<input type="text" name="po_unique_id[]" value="'.htmlspecialchars($value['po_unique_id']).'">';  
//         $value['product_unique_id'] = '<input type="text" name="product_unique_id[]" value="'.htmlspecialchars($value['product_unique_id']).'">';
//             $value['itemdetails'] = '<input type="text" name="item_code[]" value="'.htmlspecialchars($value['item_code']).'"> ';  
// // product
//             $value['product'] = '<input type="text" name="product[]" value="'.htmlspecialchars($value['product']).'">';  


                // $data[] = array_values($value);

                $data[] = $value;

                $sno++; // increment for the next row
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


// case 'product_details_datatable':

//     // DataTable Variables
//     $search = $_POST['search']['value'] ?? '';
//     $length = $_POST['length'] ?? 10;
//     $start = $_POST['start'] ?? 0;
//     $draw = $_POST['draw'] ?? 1;

//     $dc_no = $_POST['dc_no'] ?? [];
//     $gst_type = $_POST['gst_type'] ?? 1;

//     $table = "invoice_creation";
//     $data = [];

//     // Prepare LIMIT
//     $limit = ($length != '-1') ? $length : "";

//     // WHERE condition for dc_no (single or multi-select)
//     if (is_array($dc_no) && !empty($dc_no)) {
//         $dc_list = array_map(function ($dc) {
//             return "'" . addslashes($dc) . "'";
//         }, $dc_no);
//         $where = "dc_num IN (" . implode(",", $dc_list) . ")";
//     } else {
//         $where = "dc_num = '" . addslashes($dc_no) . "'";
//     }

//     // Columns for SELECT with GROUP BY
//     $columns = [
//         "'' AS sno",
//         "item_code",
//         "product",
//         "po_unique_id",
//         "product_unique_id",
//         "GROUP_CONCAT(DISTINCT dc_num SEPARATOR ', ') AS dc_no",
//         "GROUP_CONCAT(CONCAT(dc_num, ':', invoice_qty)) AS dc_qty_map",
//         "SUM(invoice_qty) AS invoice_qty",
//         "SUM(invoice_qty) AS qty",
//         "GROUP_CONCAT(DISTINCT invoice_no) AS invoice_no",
//         "'' AS rate",
//         "'' AS gst",
//         "'' AS tax_amount",
//         "'' AS total_amount",
//         "'' AS hidden_data",
//         "item_code AS itemdetails"
//     ];

//     $table_details = [$table, $columns];
//     $group_by = "product_unique_id";
//     $where .= " AND is_delete = '0'";

//     // Run Query
//     $result = $pdo->select($table_details, $where, "", "", "", "", $group_by);

//     $total_records = total_records();
//     $sno = 1;

//     if ($result->status) {

//         $res_array = $result->data;

//         foreach ($res_array as $value) {

//             $qty = (float)$value['invoice_qty'];

//             // Convert dc_qty_map → "DC01:5,DC02:3" to array
//             $dc_qty_map_array = [];
//             if (!empty($value['dc_qty_map'])) {
//                 $pairs = explode(",", $value['dc_qty_map']);
//                 foreach ($pairs as $p) {
//                     list($dc, $q) = explode(":", $p);
//                     $dc_qty_map_array[$dc] = (float)$q;
//                 }
//             }

//             $dc_qty_map_json = htmlspecialchars(json_encode($dc_qty_map_array), ENT_QUOTES, 'UTF-8');

//             // Build table HTML
//             $value['sno'] = $sno;

//             $value['item_code'] = '
//                 <b>' . htmlspecialchars($value['item_code']) . '</b><br>' . htmlspecialchars($value['product']) . '
//                 <input type="hidden" class="ven_po_unique_id" value="' . htmlspecialchars($value['po_unique_id']) . '">
//                 <input type="hidden" class="ven_product_unique_id" value="' . htmlspecialchars($value['product_unique_id']) . '">
//                 <input type="hidden" class="ven_item_code" value="' . htmlspecialchars($value['itemdetails']) . '">
//                 <input type="hidden" class="ven_product" value="' . htmlspecialchars($value['product']) . '">
//                 <input type="hidden" class="ven_dc_no" value="' . htmlspecialchars($value['dc_no']) . '">
//                 <input type="hidden" class="ven_invoice_no" value="' . htmlspecialchars($value['invoice_no']) . '">
//                 <input type="hidden" class="dc_qty_map" value="' . $dc_qty_map_json . '">
//             ';
//             $value['invoice_qty'] = '<div style="text-align:right;"><span class="qty" style="font-weight:bold;" name="qty[]"  id="pd_qty_' . $sno . '" data-value="' . htmlspecialchars($qty) . '">' . htmlspecialchars($qty) . '</span></div>';


//             // $value['invoice_qty'] = '<div style="text-align:right;"><b>' . $qty . '</b></div>';

//             // GST Display
//             if ($gst_type == 1) {
//                 $value['gst'] = '<div style="text-align:right;"><b>18 %</b></div>';
//             } else {
//                 $value['gst'] = '<div style="text-align:right;"><b>0 %</b></div>';
//             }

//             // Tax & Total are calculated on UI
//             $value['tax_amount'] = '<div style="text-align:right;"><span class="tax_amount" id="tax_' . $sno . '"></span></div>';
//             $value['total_amount'] = '<div style="text-align:right;"><span class="total_amount" id="total_' . $sno . '"></span></div>';

//             // Rate Input
//             $value['rate'] = '
//                 <div style="text-align:right;">
//                     <input type="text" name="rate[]" onkeypress="allowNumberdecimal(event)" class="form-control" id="rate_' . $sno . '" oninput="gstcalculation(' . $sno . ')">
//                 </div>';

//             $data[] = $value;
//             $sno++;
//         }

//         $json_array = [
//             "draw" => intval($draw),
//             "recordsTotal" => intval($total_records),
//             "recordsFiltered" => intval($total_records),
//             "data" => $data,
//             "testing" => $result->sql
//         ];

//     } else {
//         $json_array = [
//             "draw" => intval($draw),
//             "recordsTotal" => 0,
//             "recordsFiltered" => 0,
//             "data" => [],
//             "error" => $result->message
//         ];
//     }

//     echo json_encode($json_array);
//     break;






    case 'team_list_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];


        $table_doc = "view_dispatch_completed_list";

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [

            "unique_id as invoice_unique_id",

            "'' as sno",
            "unique_id as invoice_unique_id",
            "po_num",
            "po_date",
            "department",
            "'' as location",
            // ""
            "invoice_no",
            "invoice_date",

            "file_name",
            "dc_file_name",
            "ir_file_name",
            "file_invoice",
            "invoice_file_org_name",
            "ac_team_verifiy_status",
            "approved_by",

            // "unique_id"
        ];
        $table_details = [
            $table_doc,
            $columns
        ];


        // $where  = 
        // $where          = [
        //     "is_delete"     => 0
        // ];
        $order_by = "";


        $where = "vendor_team_sts = '0'";



        // $where = "ac_team_verifiy_status =  0 and ac_team_verifiy_status != 1 ";

        // if($ac_team_verifiy_status != ''){
        //     $where .= " AND ac_team_verifiy_status LIKE '%".$ac_team_verifiy_status."%'";
        // }


        // $order_by  = "ac_team_verifiy_status='0' DESC";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "ac_team_verifiy_status='0' $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }



        // $sql_function   = "SQL_CALC_FOUND_ROWS";

        // $sql_function = "SQL_CALC_FOUND_ROWS";



        // $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " FROM $table_doc $where $order_by LIMIT $limit OFFSET $start";

        // $total_records = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();



        //  print_r('total_records');die();




        $result = $pdo->select($table_details, $where);

        $total_records = total_records();
        //  print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_unique_id = $value['invoice_unique_id'];

                $value['invoice_unique_id'] = '<div class="checkbox-container">
                        <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox">
                    
                        <input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="1">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="' . $invoice_unique_id . '">
                        <input type="hidden" name="approved_by" id="approved_by" value="' . $session_approved_by . '">
                    </div>';




                $value['sno'] = $sno++;




                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];



                // $value['file_name']=$value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);


                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
                    Comparison Attachment </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                            <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                            <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                            <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                        </div>
                                    </div>
                                  
                                    <div class="row mt-2">
                                       <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                           <h4 class="text-center">PO Attachment</h4>
                                                <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="400">
                                                    <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="400">
                                                    </iframe>
                                                </object>
                                        </div>
                                        <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">DC Attachment</h4>
                                            <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                            <h4 class="text-center">IR Attachment</h4>
                                            <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                       <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                            <h4 class="text-center">Invoice Attachment</h4>
                                            <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="400">
                                                </iframe>             
                                            </object>
                                       </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                    
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->';

                // $value['file_name']='<a href="uploads/po_form/pdf.png"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a>';

                $approval_sts = $value['ac_team_verifiy_status'];

                if ($approval_sts == '1') {

                    $value['ac_team_verifiy_status'] = 'Approved';
                } elseif ($approval_sts == '2') {

                    $value['ac_team_verifiy_status'] = 'Not Approval';
                } else {
                    $value['ac_team_verifiy_status'] = 'Pending';

                }

                $data[] = array_values($value);
                // $sno++;
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










    case 'vendor_bill':


        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;


        $po_unique_id = $_POST["po_unique_id"];
        $dc_num = $_POST["dc_no"];
        $invoice_qty = $_POST["qty"];
        $product_unique_id = $_POST["product_unique_id"];
        $item_code = $_POST["item_code"];
        $product = $_POST["product"];
        $rate = $_POST["rate"];
        $gst = $_POST["gst"];
        $tax_amount = $_POST["tax_amount"];

        $total_amount = $_POST["total_amount"];




        $table = "vendor_allocation_sublist";

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }


        // Query Variables
        $json_array = "";
        $columns = [

            "po_unique_id" => $po_unique_id,
            "dc_num" => $dc_num,
            "invoice_qty" => $invoice_qty,
            "product_unique_id" => $product_unique_id,
            "item_code" => $item_code,
            "product" => $product,
            "rate" => $rate,
            "gst" => $gst,
            "tax_amount" => $tax_amount,
            "total_amount" => $total_amount,
            "unique_id" => unique_id()
            // "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $order_by = "";

    // 🔎 Check if dc_num already exists
$check_where = "dc_num = '$dc_num' AND product_unique_id = '$product_unique_id'";

$check_data = $pdo->select([$table, ['unique_id']], $check_where);

if ($check_data->status && !empty($check_data->data)) {

    // ✅ Record Exists → UPDATE
    $existing_unique_id = $check_data->data[0]['unique_id'];

    $update_where = "unique_id = '$existing_unique_id'";

    $action_obj = $pdo->update($table, $columns, $update_where);

    if ($action_obj->status) {
        echo json_encode([
            "status" => true,
            "msg"    => "updated"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "msg"    => "error",
            "error"  => $action_obj->error
        ]);
    }

} else {

    // ✅ Record Not Exists → INSERT
    $action_obj = $pdo->insert($table, $columns);

    if ($action_obj->status) {
        echo json_encode([
            "status" => true,
            "msg"    => "created"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "msg"    => "error",
            "error"  => $action_obj->error
        ]);
    }
}


        break;


    case 'allocation_list':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];



        $dc_no = $_POST['dc_no'];


        $table_doc = "invoice_creation_main";


        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [

            //  "unique_id as invoice_unique_id",

            "'' as sno",
            //   "unique_id as invoice_unique_id",
            "(Select po_num from po_form where unique_id = $table_doc.form_main_unique_id) as po_num",
            "invoice_no",
            "dc_number",
            "invoice_qty",

            "'' as department_details",
            "'' as cons_details",
            "'' as action",





            "DATE_FORMAT(po_date,'%d-%m-%Y')as po_date",
            "form_main_unique_id",

            "DATE_FORMAT(invoice_date,'%d-%m-%Y')as invoice_date",
            "DATE_FORMAT(dc_date,'%d-%m-%Y')as dc_date",
            "consignee_unique_id",


            // "department",

            "(SELECT get_district_name(po.district) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS district",
            "(SELECT get_state_name(po.state_name) FROM po_form AS po WHERE po.unique_id = $table_doc.form_main_unique_id) AS state",




            // "unique_id"
        ];
        $table_details = [
            $table_doc,
            $columns
        ];

        $where = "dc_number = '$dc_no'";


        // $where  = 
        // $where          = [
        //     "is_delete"     => 0
        // ];
        $order_by = "";




        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // $order_by = "ac_team_verifiy_status='0' $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if (!empty($where)) {
                $where .= " AND ";
            }
            $where .= $search;
        }




        $result = $pdo->select($table_details, $where);

        $total_records = total_records();
        //  print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {




                $value['sno'] = $sno++;



                $dc_number = $value['dc_number'];

                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];



                $department = $value['department'];


                $po_num = $value['po_num'];

                $form_main_unique_id = $value['form_main_unique_id'];

                $value['po_num'] = '<b>' . $value['po_num'] . '</b>' . '<br>' . $value['po_date'];


                $value['invoice_no'] = '<b>' . $value['invoice_no'] . '</b>' . '<br>' . $value['invoice_date'];

                $value['dc_number'] = '<b>' . $value['dc_number'] . '</b>' . '<br>' . $value['dc_date'];


                //  $value['department'] =  $value['department'];

                // $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:unique_id)");
                // $stmtCus->bindParam(':unique_id', $form_main_unique_id);
                // $stmtCus->execute();

                // // print_r($form_main_unique_id);die();

                // $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

                //             // print_r($customer_data);die();


                // if (($customer_data)) {
                //         $customerAddress    = $customer_data[0]["bill_address"];
                //         $customerName  = $customer_data[0]["contact_name"];
                //         $customerContact  = $customer_data[0]["contact_number"];
                //         $customerLan         = $customer_data[0]["landline_number"];
                //         $customerEmail = $customer_data[0]["email"];

                //         //  $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                //         // $customerDistrict      = district_name_stock($customer_data[0]["district"]);


                //     //    $districtData = district_name_stock($consignee_data[0]["district"]);
                //     //     $customerDistrict = is_array($districtData) ? $districtData[0] : $districtData;
                //         $customrePincode      = $customer_data[0]["pin"];
                //     }



                $value['department_details'] = '<b>' . ($value['department']) . '</b>' . '<br>' . $value['district'] . '<br>' . $value['state'];


                $consignee_unique_id = $value['consignee_unique_id'];



                $stmt = $conn->prepare("CALL GetConsigneeDetailsById(:unique_id)");
                $stmt->bindParam(':unique_id', $consignee_unique_id);
                $stmt->execute();

                $consignee_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($consignee_data)) {
                    $consigneeName = $consignee_data[0]["con_contact_name"];
                    $consigneeContact = $consignee_data[0]["con_contact_number"];
                    $consigneeLan = $consignee_data[0]["con_lan_num"];
                    $consigneeAddress = $consignee_data[0]["con_address"];

                    $districtData = district_name_stock($consignee_data[0]["con_district"]);
                    $consigneeDistrict = is_array($districtData) ? $districtData[0] : $districtData;

                    $consigneeState = con_state_name_stock(($consignee_data[0]["con_state_name"]));
                    $consigneePincode = $consignee_data[0]["con_pincode"];
                    $consigneeZone = $consignee_data[0]["zone"];
                }



                $value['cons_details'] = '<b>' . strtoupper($consigneeName) . '</b><br>' .
                    $consigneeAddress . '<br>' .

                    $consigneeDistrict . '<br>' .
                    $consigneeState;


                $value['file_name'] = $value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                $value['action'] = '<button class="view-btn" onclick="product_popup(\'' . $dc_number . '\')" title="View"><i  class="mdi mdi-eye view-btn-2"></i></button>';



                $approval_sts = $value['ac_team_verifiy_status'];

                if ($approval_sts == '1') {

                    $value['ac_team_verifiy_status'] = 'Approved';
                } elseif ($approval_sts == '2') {

                    $value['ac_team_verifiy_status'] = 'Not Approval';
                } else {
                    $value['ac_team_verifiy_status'] = 'Pending';

                }

                $data[] = array_values($value);
                // $sno++;
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




    case 'product_details':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;




        $dc_no = $_POST['dc_num'];


        $table_doc = "invoice_creation_main";

        $table = "vendor_allocation_sublist";


        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [

            "''as s_no",

            "item_code",
            "invoice_qty",
            "rate",
            "gst",
            "tax_amount",
            "total_amount",
            "product"

            // "unique_id"
        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "dc_num = '$dc_no'";


        // $where  = 
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by = "";




        // $order_column = $_POST["order"][0]["column"];
        // $order_dir = $_POST["order"][0]["dir"];

        // // Datatable Ordering 
        // $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // // $order_by = "ac_team_verifiy_status='0' $order_dir";


        // // Datatable Searching
        // $search = datatable_searching($search, $columns);

        // if ($search) {
        //     if (!empty($where)) {
        //         $where .= " AND ";
        //     }
        //     $where .= $search;
        // }




        $result = $pdo->select($table_details, $where);

        $total_records = total_records();
        //  print_r($result);die();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {




                $value['sno'] = $sno++;


                $value['item_code'] = '<b>' . $value['item_code'] . '</b><br>' . $value['product'];






                // $data[] = array_values($value);

                $data[] = $value;
                // $sno++;
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
















    case 'get_district':
        $state_name = isset($_POST['state_name']) ? $_POST['state_name'] : '';

        // Validate state_name
        if (empty($state_name)) {
            echo json_encode(['status' => 'error', 'message' => 'State ID is missing or invalid.']);
            exit;
        }

        // Fetch districts based on the state_name
        $get_district = state_by_district_name($state_name);

        // print_r($get_district);

        // If no districts are found, return an error message
        if (empty($get_district)) {
            echo json_encode(['status' => 'error', 'message' => 'No districts found for the selected state.']);
            exit;
        }

        // Prepare the district data for the response
        $district_options = [];
        foreach ($get_district as $district) {
            $district_options[] = [
                'unique_id' => $district['unique_id'],
                'district_name' => $district['district_name']
            ];
        }

        // Return the districts as a JSON object
        echo json_encode(['status' => 'success', 'districts' => $district_options]);

        break;



    //                  case 'engineer_role_option':




    //                                  if (isset($_POST['eng_name']) && !empty($_POST['eng_name'])) {
//                 $user_ids = $_POST['eng_name'];  // Array of selected user unique IDs
//                 $user_types = get_engineer_user_type($user_ids);

    //                 if ($user_types) {
//                     // Loop through the results and display the user type for each user
//                     foreach ($user_types as $user_type) {
//                         echo "User ID: " . $user_type['unique_id'] . " - User Type: " . $user_type['user_type_name'] . "<br>";
//                     }
//                 } else {
//                     echo "No user types found.";
//                 }
//             }


    // break;


    case 'engineer_role_option':
        if (isset($_POST['eng_name']) && !empty($_POST['eng_name'])) {
            // Decode the list of selected engineer names (unique IDs)
            $eng_name_list = json_decode($_POST['eng_name'], true);

            if (!is_array($eng_name_list) || count($eng_name_list) == 0) {
                echo json_encode(["success" => false, "message" => "Invalid engineer names"]);
                exit;
            }

            // Database connection
            $conn = new mysqli("localhost", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'), "operation_team_beta");

            if ($conn->connect_error) {
                echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
                exit;
            }

            // Prepare SQL query to fetch user roles based on selected engineers' unique IDs
            $placeholders = implode(',', array_fill(0, count($eng_name_list), '?'));
            $sql = "SELECT u.unique_id, ut.user_type, ut.unique_id AS user_role_unique_id
                FROM user u
                JOIN user_type ut ON u.user_type_unique_id = ut.unique_id
                WHERE u.unique_id IN ($placeholders) 
                AND u.is_active = 1 
                AND u.is_delete = 0";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param(str_repeat("s", count($eng_name_list)), ...$eng_name_list);
                $stmt->execute();
                $result = $stmt->get_result();

                $user_roles = [];
                $user_role_ids = [];
                while ($row = $result->fetch_assoc()) {
                    // Store the user type (role) and user role unique IDs
                    $user_roles[] = $row['user_type'];
                    $user_role_ids[] = $row['user_role_unique_id']; // Store unique_ids
                }

                // Check if we found matching user roles
                if (!empty($user_roles)) {
                    echo json_encode([
                        "success" => true,
                        "user_roles" => implode(", ", $user_roles), // Display user types (roles)
                        "user_role_ids" => $user_role_ids // Return user role unique IDs
                    ]);
                } else {
                    echo json_encode(["success" => false, "message" => "No matching records found for the selected engineers."]);
                }

                $stmt->close();
            } else {
                echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
            }

            $conn->close();
        } else {
            echo json_encode(["success" => false, "message" => "Invalid engineer name"]);
        }
        break;














    //         case 'bulk_vendor_update' : 

    //         $vendor  = $_POST['vendor'];
    //          $rate  = $_POST['rate'];
    //         $gst  = $_POST['gst'];
    //         $time_line  = $_POST['time_line'];

    //          $po_num  = $_POST['po_num']; 
    //          $invoice_no = $_POST['invoice_no'];
    //          $bulk_status = $_POST['bulk_status'];



    //         $table_name  = "invoice_creation_main";


    //         $columns   = [
    //             "vendor_bulk_sts",
    //             "vendor_bulk",
    //             "vendor_bulk_rate",
    //             "vendor_bulk_gst",
    //             "vendor_bulk_zone",
    //             "vendor_bulk_timeline"
    //             ];

    //           $table_details = [
    //                   $table_name,
    //                   $columns
    //           ];




    //              $select_where = 'is_delete = 0 AND invoice_no ="' . $invoice_no.'"';

    //                 // $action_obj = $pdo->select($table_details, $select_where);

    //                       $action_obj = $pdo->update($table_details,$select_where);
    //                       print_r($action_obj);die();




    //         // print_r($action_obj);
    //         if ($action_obj->status) {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = "";
    //             $sql = $action_obj->sql;

    //             $msg = "update";

    //         } else {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = $action_obj->error;
    //             $sql = $action_obj->sql;
    //             $msg = "error";
    //         }

    //   $json_array = [
    //         "status" => $status,
    //         "data" => $data,
    //         "error" => $error,
    //         "msg" => $msg,
    //         "sql" => $sql
    //     ];
    //     echo json_encode($json_array);    

    //     break;




    case 'eng_call_add_update':
        $engg_type = $_POST['engg_type'];
        $engineer_name = $_POST['engineer_name'];
        $date = $_POST['date'];
        $invoice_no = $_POST['invoice_no'];
        $po_form_unique_id = $_POST['po_form_unique_id'];
        $consignee_unique_id = $_POST['consignee_unique_id'];
        $in_charge = $_POST['in_charge'];
        $gst = $_POST['gst'];
        $ttl_amount = $_POST['ttl_amnt'];
        $engineer_name_inv = $_POST['engineer_name_inv'];
        $installation_status = $_POST['installation_status'];





        $dc_number = $_POST['dc_number'];
        $dc_date = $_POST['dc_date'];


        // print_r($file_names);die();
        $update_where = '';
        // print_r( $m_unique_id );

        // }
        if ($engineer_name_inv == "" || $installation_status == '3') {
            // || $engineer_name!="" 
            $columns_call = [
                "installation_status" => 4,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];

            // $update_where_call = 'form_main_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';
            $update_where_call = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

            $action_obj_call = $pdo->update($table_inv, $columns_call, $update_where_call);

        }
        // print_r($action_obj_call);
        // Update Begins
        if ($invoice_no) {

            // unset( $columns['unique_id'] );

            // $update_where   = [
            //     'po_unique_id'     => $demo
            // ];
            $columns_update_install = [
                // "engineer_name"     => $engineer_name,
                // 'installation_com_date'     => $in_charge,
                // 'eng_remarks'     => $eng_remarks,
                "engg_type" => $engg_type,
                'engineer_name' => $engineer_name,
                'date' => $date,
                'in_charge' => $in_charge,

            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];

            // $update_where_ins = 'po_form_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';
            $update_where_ins = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

            $action_obj_ins = $pdo->update($table_sub, $columns_update_install, $update_where_ins);


            // print_r($action_obj_ins);


            $columns_update_install_sub = [
                // "engineer_name"     => $engineer_name,
                // 'installation_com_date'     => $ins_com_date,
                // 'eng_remarks'     => $eng_remarks,
                "engg_type" => $engg_type,
                'engineer_name' => $engineer_name,
                'date' => $date,
                'in_charge' => $in_charge,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];

            // $update_where_ins_sub = 'po_form_unique_id="'.$po_form_unique_id .'" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';
            $update_where_ins_sub = 'po_form_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '" AND dc_number="' . $dc_number . '" AND is_delete=0';

            $action_obj_ins_sub = $pdo->update($table_inst_sublist, $columns_update_install_sub, $update_where_ins_sub);


            if ($engg_type == 'own-engineer') {

                $eng_status = '1';
            } elseif ($engg_type == 'outsource-vendor') {

                $eng_status = '2';
            }

            // Update Ends
        }




        $update_dispatch = [

            "vendor_bulk_sts" => $bulk_status,
            "engineer_name" => $engineer_name,
            "engg_type" => $eng_status,
            "rate" => $in_charge,
            "gst" => $gst,
            "total_amount" => $ttl_amount,
            // "vendor_timeline" => $time_line,
            "date" => $date,



        ];

        $select_where = 'is_delete = 0 AND dc_number ="' . $dc_no . '"';

        // $action_obj = $pdo->update($table_name, $update_values, $select_where);

        $action_obj1 = $pdo->update($table_dispatch, $update_dispatch, $select_where);

        $columns = [
            // 'engineer_name'           => $engineer_name,
            // 'installation_com_date'     => $ins_com_date,
            // 'eng_remarks'     => $eng_remarks,
            "engg_type" => $eng_status,
            'engineer_name' => $engineer_name,
            'date' => $date,
            'in_charge' => $in_charge,
            "vendor_bulk_rate" => $in_charge,
            "vendor_bulk_gst" => $gst,
            "bulk_total_amount" => $ttl_amount,
            "bulk_eng_type" => $engg_type,
            "bulk_eng_name" => $engineer_name
        ];
        // $update_where  = 'invoice_no ="'.$invoice_no.'"';
        $update_where = 'invoice_no ="' . $invoice_no . '" AND dc_number ="' . $dc_number . '"';



        $action_obj = $pdo->update($table_inv, $columns, $update_where);










        // $action_obj_dis     = $pdo->update($table_dispatch, $columns, $update_where);
        // print_r($action_obj);die();

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;

            if ($invoice_no) {
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


    //     case 'bulk_vendor_update':

    //     header('Content-Type: application/json');

    //     try {

    //         $bulk_status  = $_POST['bulk_status'];
    //         $eng_name     = $_POST['eng_name'];
    //         $eng_type     = $_POST['eng_type'];
    //         $total_amount = $_POST['total_amount'];
    //         $po_num       = $_POST['po_num'];
    //         $dc_no        = $_POST['dc_no'];

    //         // ================= INVOICE MAIN =================
    //         $invMain = $pdo->update(
    //             "invoice_creation_main",
    //             [
    //                 "vendor_bulk_sts"   => $bulk_status,
    //                 "engineer_name"     => $eng_name,
    //                 "engg_type"         => $eng_type,
    //                 "bulk_total_amount" => $total_amount
    //             ],
    //             'is_delete = 0 
    //             AND form_main_unique_id="'.$po_num.'" 
    //             AND dc_number="'.$dc_no.'"'
    //         );

    //         print_r($invMain);die();
    //         if (empty($invMain) || !$invMain->status) {
    //             throw new Exception("Invoice main update failed");
    //         }

    //         // ================= DISPATCH =================
    //         $dispatch = $pdo->update(
    //             "dispatch_list",
    //             [
    //                 "vendor_bulk_sts" => $bulk_status,
    //                 "engineer_name"   => $eng_name,
    //                 "engg_type"       => $eng_type,
    //                 "total_amount"    => $total_amount
    //             ],
    //             'is_delete = 0 
    //             AND po_form_unique_id="'.$po_num.'" 
    //             AND dc_number="'.$dc_no.'"'
    //         );

    //         if (empty($dispatch) || !$dispatch->status) {
    //             throw new Exception("Dispatch update failed");
    //         }

    //         // ================= VERIFICATION =================
    //         $verify = $pdo->update(
    //             "invoice_verfication_table",
    //             [
    //                 "vendor_bulk_sts"   => $bulk_status,
    //                 "engineer_name"     => $eng_name,
    //                 "engg_type"         => $eng_type,
    //                 "bulk_total_amount" => $total_amount
    //             ],
    //             'is_delete=0 
    //             AND form_main_unique_id="'.$po_num.'" 
    //             AND dc_number="'.$dc_no.'"'
    //         );

    //         if (empty($verify) || !$verify->status) {
    //             throw new Exception("Verification update failed");
    //         }

    //         echo json_encode([
    //             'status' => true,
    //             'msg'    => 'All 3 tables updated successfully'
    //         ]);
    //         //exit;
    // // 
    //     } catch (Throwable $e) {

    //         echo json_encode([
    //             'status' => false,
    //             'msg'    => $e->getMessage()
    //         ]);
    //         //exit;
    //     }

    // break;



   case 'bulk_vendor_update':

        $rate = $_POST['rate'] ?? '';
        $gst = $_POST['gst'] ?? '';
        $time_line = $_POST['time_line'] ?? '';

        $total_amount = $_POST['total_amount'];

        $assign_no = $_POST['assign_no'];
        $assign_date = $_POST['assign_date'];

        $ins_date = $_POST['ins_date'];
        $eng_type = $_POST['eng_type'] ?? '';
        $eng_name = $_POST['eng_name'] ?? '';
        $date = $_POST['date'] ?? '';


        $current_date = date('Y-m-d H:i:s');

        $po_num = $_POST['po_num'] ?? '';
        $ven_invoice_no = $_POST['ven_invoice_no'];

         $invoice_no = $_POST['invoice_no'] ?? '';
        $dc_no = $_POST['dc_no'] ?? '';
        $bulk_status = $_POST['bulk_status'] ?? '';

        $table_name = "invoice_creation_main";

        $table_dispatch = "dispatch_list";

        $sess_user_type = $_SESSION['sess_user_type'];
        $sess_user_id = $_SESSION['sess_user_id'];

        $installation_status = '4';

        $update_values = [
            "ven_assign_no" => $assign_no,
            "ven_assign_date" => $assign_date,
            "vendor_allocated_by" => $sess_user_id,

            "vendor_allocated_date" => $current_date,
            "vendor_bulk_sts" => $bulk_status,
            "engineer_name" => $eng_name,
            "engg_type" => $eng_type,
            "bulk_eng_type" => $eng_type,
            "bulk_eng_name" => $eng_name,
            "vendor_bulk_rate" => $rate,
            "vendor_bulk_gst" => $gst,
            "bulk_total_amount" => $total_amount,
            "date" => $date,

            "vendor_ins_date" => $ins_date,
            "installation_status" => $installation_status,
            "vendor_timeline" => $time_line,

            "vendor_bulk_timeline" => $time_line
        ];

        


        $update_dispatch = [

            "vendor_bulk_sts" => $bulk_status,
            "engineer_name" => $eng_name,
            "engg_type" => $eng_type,
            "rate" => $rate,
            "gst" => $gst,  
            "total_amount" => $total_amount,
            "date" => $date,

            "vendor_timeline" => $time_line


        ];

        


         $update_inv_values = [

            "ven_assign_no" => $assign_no,
            "ven_assign_date" => $assign_date,
            "vendor_allocated_by" => $sess_user_id,
            "vendor_bulk_sts" => $bulk_status,
            "engineer_name" => $eng_name,
            "engg_type" => $eng_type,
            "bulk_eng_type" => $eng_type,
            "bulk_eng_name" => $eng_name,
            "vendor_bulk_rate" => $rate,
            "vendor_bulk_gst" => $gst,
            "bulk_total_amount" => $total_amount,
            "vendor_inst_allocation_date" => $ins_date,
            "installation_status" => $installation_status,
            "vendor_timeline" => $time_line,
            "vendor_bulk_timeline" => $time_line
        ];


       
          $select_inv_where = 'is_delete = 0 AND form_main_unique_id = "'.$po_num.'" AND  dc_number ="' . $dc_no . '"';

        $inv_where = 'form_main_unique_id = "'.$po_num.'" AND  dc_number ="' . $dc_no . '"';

         $select_disp_where = 'is_delete = 0 AND po_form_unique_id = "'.$po_num.'" AND  dc_number ="' . $dc_no . '"';

         $table_inv = 'invoice_verfication_table';

        

       
         $action_obj = $pdo->update($table_name, $update_values, $select_inv_where);


         $action_obj1 = $pdo->update($table_dispatch, $update_dispatch, $select_disp_where);

         $invoice_obj   = $pdo->update($table_inv,$update_inv_values,$inv_where);

       


        if ($action_obj->status && $action_obj1->status && $invoice_obj->status) {

           echo json_encode([
            "status" => true,
            "msg"    => "update"
        ]);

        } else {

             http_response_code(500); // 🔥 Promise reject
        echo json_encode([
            "status" => false,
            "msg"    => "error",
            "error"  => [
                "main"     => $action_obj->error,
                "dispatch" => $action_obj1->error,
                "invoice"  => $invoice_obj->error
            ]
        ]);
            // $msg = "error";
        }


        echo json_encode([
            "status" => $action_obj->status,
            "data" => $action_obj->data,
            "error" => $action_obj->error,
            "msg" => $msg,
            "sql" => $action_obj->sql
        ]);

        break;




    case 'team_update':


        //   print_r('test');die();

        // $vendor = $_POST['vendor'] ?? '';
        $region = $_POST['region'] ?? '';


        $state = $_POST['state'] ?? '';

        $district = $_POST['district'] ?? '';

        $user_role = $_POST['user_role'] ?? '';

        $eng_name = $_POST['eng_name'];


        //  print_r($region);die();

        $team_status = $_POST['team_status'] ?? '';

        $invoice_no = $_POST['invoice_no'] ?? '';



        //  print_r($zone);die();

        $table_name = "invoice_creation_main";

        $table_dispatch = "dispatch_list";

        $update_values = [
            "team_alloc_region" => $region,
            "team_alloc_state" => $state,
            "team_alloc_district" => $district,
            "team_alloc_eng_type" => $user_role,
            "team_alloc_eng_name" => $eng_name,

            "vendor_team_sts" => $team_status,



        ];


        $update_dispatch = [

            "vendor_team_sts" => $team_status,

        ];

        $select_where = 'is_delete = 0 AND invoice_no ="' . $invoice_no . '"';

        $action_obj = $pdo->update($table_name, $update_values, $select_where);

        // print_r($action_obj);die();

        $action_obj1 = $pdo->update($table_dispatch, $update_dispatch, $select_where);

        if ($action_obj->status) {
            $msg = "update";
        } else {
            $msg = "error";
        }

        echo json_encode([
            "status" => $action_obj->status,
            "data" => $action_obj->data,
            "error" => $action_obj->error,
            "msg" => $msg,
            "sql" => $action_obj->sql
        ]);

        break;





    case 'get_invoice':

        $po_id = $_POST['po_id'];

        // print_r($po_id);die();
        // Correct: only pass $po_id
        $invoice_nos = vendorinvoice_no($po_id);

        // print_r($invoice_nos);die();


        // $invoice_nos = select_option($invoice_nos, "");


        echo json_encode(['data' => $invoice_nos]);
        break;




    case 'get_dc':

        $inv_no = $_POST['inv_no'];


        $dc_no = vendor_dc_no($inv_no);





        echo json_encode($dc_no);
        break;




    case 'deleivery_status':
        // print_r('hi');
        // print_r($_FILES["test_file"]['name']);die();
        $delivery_status = $_POST["delivery_status"];
        $delivery_date = $_POST["delivery_date"];
        $invoice_no = $_POST["invoice_no"];
        // $delivery_proof    = $_POST["delivery_proof"];
        $status = $_POST["status"];
        $po_form_unique_id = $_POST["po_form_unique_id"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $my_no = $_POST["my_no"];
        $parts = explode('/', $my_no);
        // Get the last value from the array
        $po_num_value = end($parts);
        // if (is_array($_FILES["test_file"]['name'])) {
        //     if ($_FILES["test_file"]['name'][0] != "") {
        //         // Multi file Upload 
        //         $confirm_upload = $fileUpload->uploadFiles("test_file");
        //         if (is_array($confirm_upload)) {
        //             // print_r($_FILES["test_file"]['name']);
        //             $_FILES["test_file"]['file_name'] = [];
        //             foreach ($confirm_upload as $c_key => $c_value) {
        //                 if ($c_value->status == 1) {
        //                     $c_file_name = $c_value->name ? $c_value->name . "." . $c_value->ext : "";
        //                     array_push($_FILES["test_file"]['file_name'], $c_file_name);
        //                 } else { // if Any Error Occured in File Upload Stop the loop
        //                     $status = $confirm_upload->status;
        //                     $data = "file not uploaded";
        //                     $error = $confirm_upload->error;
        //                     $sql = "file upload error";
        //                     $msg = "file_error";
        //                     break;
        //                 }
        //             }
        //         } else if (!empty($_FILES["test_file"]['name'])) { // Single File Upload
        //             $confirm_upload = $fileUpload->uploadFile("test_file");
        //             if ($confirm_upload->status == 1) {
        //                 $c_file_name = $confirm_upload->name ? $confirm_upload->name . "." . $confirm_upload->ext : "";
        //                 $_FILES["test_file"]['file_name'] = $c_file_name;
        //             } else { // if Any Error Occured in File Upload Stop the loop
        //                 $status = $confirm_upload->status;
        //                 $data = "file not uploaded";
        //                 $error = $confirm_upload->error;
        //                 $sql = "file upload error";
        //                 $msg = "file_error";
        //             }
        //         }
        //     }
        // }
        // if (is_array($_FILES["test_file"]['name'])) {
        //     if ($_FILES["test_file"]['name'][0] != "") {
        //         $file_names = implode(",", $_FILES["test_file"]['file_name']);
        //         $file_org_names = implode(",", $_FILES["test_file"]['name']);
        //     }
        // } else if(!empty($_FILES["test_file"]['name'])) {
        //     $file_names = $_FILES["test_file"]['file_name'];
        //    $file_org_names = $_FILES["test_file"]['name'];
        // }
        $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        $allowedMimeTypes = array(
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        );
        $file = $_FILES['file']['name'];
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $tem_name = $po_num_value . "-Transit." . $extension;
        $targetDir = '../../uploads/dispatch/';



        if (move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name)) {
            // Set filenames
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
            //     echo "File uploaded successfully.";
        }
        $update_where = "";
        $columns = [
            "delivery_status" => $delivery_status,
            "delivery_date" => $delivery_date,
            'delivery_proof' => $file_names,
            'file_org_name' => $file_org_names,
            "status" => 2,
        ];
        // $table_stock_po = 'invoice_creation_main';
        // $columns1            = [
        //     //  "billed_qty"     => $data[0]['billed_qty'],
        //     "dispatch_status"     => 2,
        // ];
        //     $update_where1       = "consignee_unique_id = '".$consignee_unique_id."'";
        //     $action_obj1     = $pdo->update($table_stock_po,$columns1,$update_where1);
        //  }
        // print_r($action_obj1);die();
        // Update Begins
        if ($consignee_unique_id) {
            $update_where = 'po_form_unique_id ="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '"  and invoice_no="' . $invoice_no . '"';
            $action_obj = $pdo->update($table_dispatch, $columns, $update_where);
            // print_r($action_obj);die();
            // Update Ends
        }
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            if ($consignee_unique_id) {
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
    case 'user_permission_2':
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
    default:
        break;
}



function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    // echo $dc_file_name;
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
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
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



// doc 2

function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $dc_file_name;
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
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
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
    // echo $dc_file_name;
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
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
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
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
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






