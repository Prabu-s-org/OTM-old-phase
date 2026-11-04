<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "invoice_creation_main";
// $table             = "view_dispatch_list_final";
$table_dispatch = "dispatch_list";
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
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

        if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = $po_num_value ."-Dispatch" . '.pdf';

            move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
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
            'file_name'           => $file_names,
                'file_org_name'           => $file_org_names,
            "unique_id" => unique_id($prefix)
        ];
    }else{
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
        $select_where = 'is_delete = 0 AND invoice_no ="' . $invoice_no.'"';
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
            $update_where_1 = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" and invoice_no="'.$invoice_no.'" AND is_delete=0';
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
            } 
        
            else {
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
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_pending ="view_dispatch_pending_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_num",
            "po_date",
            // "department",
            "ledger_name",

            "(select con_address from consignee_details_sub where unique_id =$table_pending.consignee_unique_id) AS con_address",
            // "con_address",
            "invoice_auto_id",
            // "invoice_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "invoice_qty",
            "invoice_value",
            // "FORMAT(invoice_value, 2) AS invoice_value",
            "doc_approval_sts",
            "ac_team_verifiy_status",
            "unique_id",
            "invoice_no",
            "form_main_unique_id",
            "ac_team_approved_by",
            "approved_by",
            "consignee_unique_id",
           
        ];
        $table_details = [

            $table_pending,
            $columns
        ];
       $where="is_delete='0'";
       if($_POST['from_date'] == ''){
        $from_date = date('Y-m-d');
    } else {
        $from_date = $_POST['from_date'];
    }
    
    if($_POST['to_date'] == ''){
        $to_date = date('Y-m-d');
    } else {
        $to_date = $_POST['to_date'];
    }
       if($from_date && $to_date != '') {
        if($opt1 == '101') {
          
            // $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
             STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

        }
         else if($opt1 == '100') {
            
            $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
        } 
        
    }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
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
        
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        $total_records = total_records();
        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;


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
                
                $invoice_value = $value['invoice_value'];
             
                $value['invoice_value']  = moneyFormatIndia1(($invoice_value));

                $value['invoice_auto_id'] = $value['invoice_no'];
                
                $value['invoice_date'] = '<span class="invoice_date">' . ($value['invoice_date']) . '</span>';
                
                $invoice_qtSy = $value['invoice_qty'];
                $unit_price = $value['unit_price'];
                $value['unit_price'] = (($unit_price) * ($invoice_qty));
                if($value['doc_approval_sts'] == 0){
                    $value['doc_approval_sts'] = 'pending'.' / '.$value['approved_by'];
                }
              else if($value['doc_approval_sts'] == 1){
                    $value['doc_approval_sts'] = 'Approved'.' / '.$value['approved_by'];
                }else{
                    $value['doc_approval_sts'] = 'Rejected'.' / '.$value['approved_by'];
                }
                
                // else{
                //     $value['doc_approval_sts'] = 'Approved'.' / '.$value['approved_by'];
                // }
              if($value['ac_team_verifiy_status'] == 0){
                    $value['ac_team_verifiy_status'] = 'Pending'.' / '.$value['ac_team_approved_by'];
                }
                else if($value['ac_team_verifiy_status'] == 1){
                    $value['ac_team_verifiy_status'] = 'Approved'.' / '.$value['ac_team_approved_by'];
                }else{
                    $value['ac_team_verifiy_status'] = 'Rejected'.' / '.$value['ac_team_approved_by'];
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

              
                // $btn_update = btn_update($folder_name, $value['unique_id']);
                // $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                // $value['unique_id'] = $btn_update;
                $btn_update = btn_update_dispatch_pending($folder_name, $value['form_main_unique_id'],$value['consignee_unique_id'],$value['invoice_no'],);

                // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                //     $value['unique_id'] = $btn_update.$btn_delete;                   
                // }else 
                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }else{
                //  if(in_array('5f8808504271036738', $action_ids)){
                //     $value['unique_id'] = $btn_delete;
                // }
                // else{
                    $value['unique_id'] = '';
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
    case 'fixed_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
       $table_transit= "view_dispatch_transit_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_num",
            // "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            "po_date",
            // "consignee",
            
            // "department",
            "ledger_name",

            "(select con_address from consignee_details_sub where unique_id = $table_transit.consignee_unique_id) AS con_address",
            // "con_address",
            "invoice_no",
            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "invoice_date",
             "DATE_FORMAT(dispatch_date, '%d-%m-%Y') AS dispatch_date",
            // "dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
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
        if($_POST['from_date'] == ''){
            $from_date = date('Y-m-d');
        } else {
            $from_date = $_POST['from_date'];
        }
        
        if($_POST['to_date'] == ''){
            $to_date = date('Y-m-d');
        } else {
            $to_date = $_POST['to_date'];
        }
        //    if($from_date && $to_date != '') {
            if($opt == '4') {
              
                // $where .= "AND po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
                $from_date_converted = date('d-m-Y', strtotime($from_date));
                $to_date_converted = date('d-m-Y', strtotime($to_date));
                $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
                 STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
    
            }
             else if($opt == '5') {
                
                $where .= "AND invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            } 
            else if($opt == '6') {
                
                $where .= "AND dispatch_date >= '" . $from_date . "' AND dispatch_date <= '" . $to_date . "' ";
            } 
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
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
        $screen_id_val      = $_POST['screen_id_val'];
        $user_type  = $_POST['user_type_unique_id'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;


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
                $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date']. '</span>';
                $value['dispatch_date'] = '<span class="invoice_date">' . $value['dispatch_date']. '</span>';

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
                $btn_update         = btn_update_dispatch($folder_name,$value['po_form_unique_id'],$value['consignee_unique_id'],$value['invoice_no']);

                if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                   
               
                }else{
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
        $from_date  = $_POST['from_date'];
        $to_date    = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_delivery="view_dispatch_delivery_list";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "po_num",
            "po_date",
            // "consignee",
            // "(select department from stock_position_main where form_main_unique_id = $table_dispatch.po_form_unique_id) AS con_contact_name",
            // "department",
            "ledger_name",
            "(select con_address from consignee_details_sub where unique_id = $table_delivery.consignee_unique_id) AS con_address",
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
        // $where = ""; 
        
        
        if($_POST['from_date'] == ''){
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }
        
        if($_POST['to_date'] == ''){
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }
        //    if($from_date && $to_date != '') {
            if($opt3 == '40') {
              
                $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "' ";
                // $from_date_converted = date('d-m-Y', strtotime($from_date));
                // $to_date_converted = date('d-m-Y', strtotime($to_date));
                // $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
                //  STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
    
            }
             else if($opt3 == '50') {
                
                $where = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "' ";
            } 
            else if($opt3 == '60') {
                
                $where = "dispatch_date >= '" . $from_date . "' AND dispatch_date <= '" . $to_date . "' ";
                //  $from_date_converted = date('d-m-Y', strtotime($from_date));
                // $to_date_converted = date('d-m-Y', strtotime($to_date));
                // $where = "STR_TO_DATE(dispatch_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND
                //  STR_TO_DATE(dispatch_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";
    
            }

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
                $value['delivery_proof']     =  image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
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
    case 'deleivery_status':
        // print_r('hi');
        // print_r($_FILES["test_file"]['name']);die();
       $delivery_status = $_POST["delivery_status"];
        $delivery_date = $_POST["delivery_date"];
        $invoice_no = $_POST["invoice_no"];
        // $delivery_proof    = $_POST["delivery_proof"];
       $status     = $_POST["status"];
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
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id   = $_POST['user_type_unique_id'];
            // print_r( $user_type_unique_id);die();
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            // print_r($select_where);die();
            $table_details   = [
                $table_user,
                $columns
            ];
    
            $table_users  = $pdo->select($table_details, $select_where);
    
            if ($table_users->status) {
    
                $table_users      = $table_users->data;
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
                    "draw"				=> intval($draw),
                    "recordsTotal" 		=> intval($total_records),
                    "recordsFiltered" 	=> intval($total_records),
                    "data" 				=> $action_unique_ids,
                    "testing"			=> $result->sql
                ];
            
             echo json_encode($json_array);
    
            break;
            case 'user_permission_2':
                $screen_id_val      = $_POST['screen_id_val'];
                $user_type_unique_id   = $_POST['user_type_unique_id'];
                // print_r( $user_type_unique_id);die();
                
            $table_user ="user_screen_permission";
                $columns        = [
                    // "screen_unique_id",
                    "action_unique_id",
                    "user_type"
                ];
                $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
                // print_r($select_where);die();
                $table_details   = [
                    $table_user,
                    $columns
                ];
        
                $table_users  = $pdo->select($table_details, $select_where);
        
                if ($table_users->status) {
        
                    $table_users      = $table_users->data;
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
                        "draw"				=> intval($draw),
                        "recordsTotal" 		=> intval($total_records),
                        "recordsFiltered" 	=> intval($total_records),
                        "data" 				=> $action_unique_ids,
                        "testing"			=> $result->sql
                    ];
                
                 echo json_encode($json_array);
        
                break;
    
            case 'user_permission_1':
                $screen_id_val      = $_POST['screen_id_val'];
                $user_type_unique_id   = $_POST['user_type_unique_id'];
                // print_r( $user_type_unique_id);die();
                
            $table_user ="user_screen_permission";
                $columns        = [
                    // "screen_unique_id",
                    "action_unique_id",
                    "user_type"
                ];
                $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
                // print_r($select_where);die();
                $table_details   = [
                    $table_user,
                    $columns
                ];
        
                $table_users  = $pdo->select($table_details, $select_where);
        
                if ($table_users->status) {
        
                    $table_users      = $table_users->data;
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
                        "draw"				=> intval($draw),
                        "recordsTotal" 		=> intval($total_records),
                        "recordsFiltered" 	=> intval($total_records),
                        "data" 				=> $action_unique_ids,
                        "testing"			=> $result->sql
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
function image_view($folder_name = "", $unique_id = "", $delivery_proof = "")
{
    // alert('hi');
    // echo $dc_file_name;
    $file_names = explode(',', $delivery_proof);
    $image_view = '';
    if ($delivery_proof) {
        foreach ($file_names as $file_key => $delivery_proof) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }
            $cfile_name = explode('.', $delivery_proof);
            if ($delivery_proof) {
                
                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $delivery_proof . '\')"><img src="uploads/' . $folder_name . '/' . $delivery_proof . '"  height="50px" width="50px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="50px" width="50px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="50px" width="50px" ></a>';
                }
            }
        }
    }
    return $image_view;
}

