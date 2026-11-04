<?php 
// session_start();

$folder_name        = explode("/",$_SERVER['PHP_SELF']);

$folder_name        = $folder_name[count($folder_name)-2];

$table              = "user";
$table_log          = "user_login_details";
$table_install             = "view_installation_followups1";
$table_3             = "view_installation_followups";

// Database Country Table Name
$table_sub             = "installation_details";
$table_sub_dc         = "dc_ir_doc_dispatch_details";
$table_inst_sublist = "installation_details_sublist";
// $table_inv="view_invoice_creation_main";
$table_inv="invoice_creation_main";



// Include DB file and Common Functions
include '../config/dbconfig.php';
// include('D:/xampp/htdocs/aed_elcot/config/dbconfig.php');



// Variables Declaration 
$action             = $_REQUEST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

// $acc_year       = explode(" to ",$_REQUEST['acc_year']);
// $from_year      = (explode("-",$acc_year[0]))[0];
// $to_year        = (explode("-",$acc_year[1]))[0];

// $acc_year       = explode(" to ",$_REQUEST['acc_year']);
$from_year      = "2020";
$to_year        = "2021";

$sess_acc_year  = $from_year."-".$to_year;

$sess_acc_year  = acc_year();

switch ($action) {
    
    
    case 'login':

        $user_name  = $_REQUEST['user_name'];
        // $password   = md5($_REQUEST['password']);
        $password  = $_REQUEST['password'];


        $columns    = [
            "COUNT(unique_id) AS count",
            "user_type_unique_id",
            "staff_name",
            "staff_id",
            "(select engineer_name from view_eng_data  where emp_id=$table.unique_id) AS eng_unique_id",
            // "profile_image AS user_image",
            // "zone_name",
            // "ward_name",
            "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = [
            "user_name" => $user_name,
            "password"  => $password,
            "is_active" => 1,
            "is_delete" => 0 
        ]; 

        // $where  = " (user_name LIKE BINARY '".$user_name."' OR phone_no LIKE BINARY  '".$user_name."') AND password LIKE BINARY  '".$password."' AND is_active = 1 AND is_delete = 0 ";

        $where  = "user_name = '".$user_name."'  AND password =  '".$password."' AND is_delete = 0 AND is_active = 1";

        $action_obj    = $pdo->select($table_details,$where);
        // print_r( $action_obj);
// 
        if ($action_obj->status) {
            $count_data     = $action_obj->data[0]["count"];
            if ($count_data == 1) {
                // session_start();
                $user                              = $action_obj->data[0];
                $msg                               = "success_login";

                $user_id                           = $user['unique_id'];
                $staff_id                          = $user['staff_id'];
               $eng_unique_id                       = $user['eng_unique_id'];
               $_SESSION["eng_unique_id"]              = $eng_unique_id;
                $_SESSION["acc_year"]              = $sess_acc_year;
                $_SESSION["user_id"]               = $user_id;
                $_SESSION["staff_name"]            = $user['staff_name'];
                $_SESSION["user_name"]             = $user_name;
                $user_type                         = user_type($user['user_type_unique_id']);
                $_SESSION['sess_user_type']        = $user_type[0]['user_type'];
                $_SESSION['user_type_unique_id']    = $user['user_type_unique_id'];
                $_SESSION['sess_zone_name']  = $user['zone_name'];
                $_SESSION['sess_ward_name']  = $user['ward_name'];
                $_SESSION['sess_user_id']          = $user_id;
                $_SESSION['sess_user_location']    = 'Erode';
                $_SESSION['sess_company_name']     = 'Ascent E-Digit Solutions';
                $_SESSION['sess_company_address']  = '64, Kalaimagal School Road,';
                $_SESSION['sess_company_district'] = 'Erode 638001,';
                $_SESSION['sess_company_state']    = 'Tamil Nadu, INDIA.';
                $_SESSION['sess_company_phone_no'] = '0424-2269797';
                $_SESSION['sess_company_id']       = "comp5fa3b1c2a3bab70290";
                $_SESSION['sess_img_path']         = "img/";
                //$_SESSION['company_logo']          = "logo-light.png";
		        $_SESSION['company_logo']          = "logo-new.png";
                $_SESSION['sess_branch_id']        = "bran5fa3b1dced5d363322";
                $_SESSION['ip_address']            = get_client_ip();
                $msg                               = "success_login";

               $permissions                       = menu_permission($user['user_type_unique_id']);
                 //print_r($permissions);
                $main_screens                      = $permissions["main_screens"];
                $sections                          = $permissions["sections"];
                $screens                           = $permissions["screens"];
                $actions                           = $permissions["actions"];
                $_SESSION['actions']               = $actions;
                $_SESSION['main_screens']          = $main_screens;
                $_SESSION['sections']              = $sections;
                $_SESSION['screens']               = $screens;
               
                $user_image                        = "upload/user/user.png";

         
                if ($user['user_image']) {
                    $user_image = "upload/user/".$user['user_image'];
                }

                
                $_SESSION["user_image"] = $user_image;

                //login CURD function

                if($user_id!=''){

                $columns_login       = [
                        
                        "user_id"              => $user_id,
                        "entry_date"           => date('Y-m-d'),
                        "entry_time"           => date('h:i:s'),
                        "log_type"             => 1,
                        "unique_id"            => unique_id($prefix)
                 ];

                 $action_obj_log     = $pdo->insert($table_log,$columns_login);

              }


                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "success_login",
                    // "test"      => $_SESSION["file_status"],
                    "sql"       => $_SESSION["user_id"],
                    "session"   => $_SESSION
                ];

            } else {
                // Incorrect username and password handling 
                $json_array = [
                    "status"    => 0,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "incorrect",
                    "sql"       => ""
                ];
            }
        } else {
            $msg    = "error";
        }
        
        echo json_encode($json_array); 
        
        break;








        case 'datatable':
            // DataTable Variables
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $from_date  = $_POST['from_date'];
            $to_date    = $_POST['to_date'];
            $opt    = $_POST['opt'];
            $limit         = $length;
            $installation_status    =  $_POST['installation_status'];
            $con_district = $_POST['con_district'];
            // $department = $_POST['department'];
    
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
    
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as  s_no",
                "po_num",
                "po_date",
                "ledger_name",
                "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups.con_district) AS con_district",
                "con_address",
                "invoice_no",
                // "invoice_date",
                "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                "invoice_value",
                "po_file_name",
                "dc_file_name",
                "ir_file_name",
                "file_invoice",
            "(select staff_name from view_eng_data WHERE view_eng_data.eng_unique_id=$table_3.engineer_name) AS engineer_name",
    
                "installation_status",
                "delivery_due_dates",
    
                "consignee_unique_id",
                "form_main_unique_id",
                "con_pincode",
                "dc_required",
              
               "invoice_auto_id",
                "(SELECT sum(delivery_due_days) FROM invoice_creation WHERE invoice_creation.invoice_no = view_installation_followups.invoice_no group by invoice_no) AS delivery_due_days",
    
                
            ];
            $table_details  = [
                $table_3,
                $columns
            ];
           
          
                
    
            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
            // Datatable Ordering 
            $order_by       = datatable_sorting_ins1($order_column, $order_dir, $columns);
          
         
    $order_by = "CASE 
    WHEN installation_status = '3' THEN 0 
    WHEN installation_status = '0' THEN 1
    WHEN installation_status = '4' THEN 2
    WHEN installation_status = '5' THEN 3
    WHEN installation_status = '1' THEN 4
    WHEN installation_status = '2' THEN 5
    ELSE 6
    END $order_dir, DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
    
            // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
    
    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
            // if($installation_status != ''){
            //     $where = "installation_status LIKE '%".$installation_status."%'";
            // }
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    // Apply search only if filter values are present
    // if ($search && $where) {
    //     $where .= " AND " . $search;
    // }
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r( $result );die();
            $total_records  = total_records();
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type  = $_POST['user_type_unique_id'];
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
            // print_r($select_where);
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
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
                    // $value['po_unique_id'] = $value['po_num'];
                    $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];
                    // $value['invoice_auto_id'] = $value['invoice_no'];
                    // if($value['installation_status'] == 0){
                    //     $value['installation_status'] = 'Pending';
                    // }else if($value['installation_status'] == 1){
                    //     $value['installation_status'] = 'Partial Completed';
                    // }else if($value['installation_status'] == 2){
                    //   $value['installation_status'] = 'Completed';
                    // }
                    // else if($value['installation_status'] == 3){
                    //     $value['installation_status'] = "<span style='color: red;'>Rejected</span>";
    
                    //   }
                  
                    if($value['installation_status'] == 0){
                        $value['installation_status'] = 'Pending';
                    }
                    else if($value['installation_status'] == 5){
                        $value['installation_status'] = 'Partial completed';
                    }
                    else if($value['installation_status'] == 2){
                      $value['installation_status'] = 'Completed';
                    }
                    else if($value['installation_status'] == 3){
                        $value['installation_status'] = "<span style='color: red;'>Rejected</span>";
    
                      }
                      else if($value['installation_status'] == 4){
                        $value['installation_status'] = "Eng Assigned";
                      }
                      else if($value['installation_status'] == 1){
                        $value['installation_status'] = "SNR";
                      }
                    // $value['file_invoice']     =  image_view_2("invoice", $value['unique_id'], $value['file_invoice']);
                    // $orgDate = $value['po_date'];
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                    $value['invoice_date']  = '<span class="po_date">'.$value['invoice_date'] .'</span>';
    
    // new changes
    
                    $delivery_due_dates = $value['delivery_due_dates'];
                    if ($delivery_due_dates!="") {
                        $delivery_due_dates = $value['delivery_due_dates'];
                    } else {
                        $delivery_due_dates = $value['delivery_due_days'];
                    }
    
                    $value['po_date']  = '<span class="po_date">'.$value['po_date'] .'</span>';
    
                    
                    $po_date = $value['po_date'];
                    $poDate = DateTime::createFromFormat('Y-m-d', strip_tags($po_date));
                    $poDate->modify('+' . $delivery_due_dates . ' days');
    
                    $resultDate = $poDate->format('d-m-Y');
                  
                    $value['delivery_due_dates']=   "<span class='po_date'>$resultDate</span>";
    
    // end
    
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['po_file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['po_file_name']);
    
                    $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
    
                    $po_file = $value['file_name'];
                    $file2 =  $value['dc_file_name'];
                   
                    $value['ir_file_name']     =  image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                    $value['file_invoice']     =  image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);
    
                    $d = $value['invoice_no'];
                    
                 $where_2 = "invoice_no = '" . $d . "' AND is_delete='0' ";
                    //  AND " . $value['installation_status'] . " = 3 ORDER BY " . $value['installation_status'] . " ASC
    
                    // $where_2 = "invoice_no = '" . $d . "'  ORDER BY installation_status='0' DESC";
                    // $where_2 = "invoice_no = '" . $d . "' ORDER BY " . $value['installation_status'] . "DESC";
                    // and dc_received_sts!='' and ir_rec_status!='' and snr_rec_status!=''
    // and dc_received_sts=1 and ir_rec_status=1 and snr_rec_status=1
                    $table_1      =  "installation_details";
    
                    $columns_2    = [
                        'COUNT(invoice_no) AS count',
                        "documents_type",
                        "documents_type1",
                        "documents_type2",
                        "dc_required"
                    ];
    
                    $table_details_1   = [
                        $table_1,
                        $columns_2
                    ];
    
                    $result_values_12  = $pdo->select($table_details_1, $where_2);
                    // print_r($result_values_12);
                    $data_st       = $result_values_12->data;
                   
                    $invoice_no= $value['invoice_no'];
               
                   
    
                    $btn_view         = btn_view_ins($folder_name,$value['consignee_unique_id'],$value['invoice_no']); 
    
                  
                    $btn_update         = btn_update1($folder_name, $value['consignee_unique_id'],$invoice_no);
    
                    if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))){
                        if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){
    
                           // print_r($value['stock_qty']==$value['invoice_qty']);die();
                           $value['consignee_unique_id']     =  $btn_view;
                      } 
                       else{
                       // $value['form_main_unique_id']='<a href="index.php?file=invoice/update1&unique_id=' . $value['form_main_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
                   
                           // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                           //     $value['unique_id'] = $btn_update.$btn_delete;                   
                           // }
                           if(in_array('5f88082b25ec031952', $action_ids)){
                            $value['consignee_unique_id'] = $btn_update;
                        }
                           // else if(in_array('5f8808504271036738', $action_ids)){
                           //    $value['form_main_unique_id'] = $btn_delete;
                           // }
                           else{
                            $value['consignee_unique_id'] = '';
                           }
                         }
                       
                     }
                     if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                       
                       // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                       //     $value['unique_id'] = $btn_update.$btn_delete;                   
                       // }
                       // else
                        if(in_array('5f88082b25ec031952', $action_ids)){
                            $value['consignee_unique_id']     =  $btn_update;
                       }
                       // else if(in_array('5f8808504271036738', $action_ids)){
                       //     $value['unique_id'] = $btn_delete;
                       // }
                       else{
                        $value['consignee_unique_id'] = '';
                       }
                     }
       
    
                    $data[]             = array_values($value);
                    $sno++;
                }
                print_r($data);
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;
    



         case 'validate':

        $mobile_no  = $_REQUEST["mobile_no"];
        //$email_id   = $_REQUEST["email_id"];

        $columns    = [
            "COUNT(unique_id) AS count",
            "user_type_unique_id",
            "staff_name",
            "email_id",
            "mobile_no",
            "profile_image AS user_image",
            "zone_name",
            "ward_name",
            "unique_id",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        
        $where  = "mobile_no = '".$mobile_no."' AND is_delete = 0 ";

        $action_obj    = $pdo->select($table_details,$where);

        if ($action_obj->status) {
            $count_data        = $action_obj->data[0]["count"];
            $active_status     = $action_obj->data[0]["is_active"];
            if (($count_data == 1)&&($active_status == 1)) {
               
                $user                              = $action_obj->data[0];
                $msg                               = "success_login";
                
                $user_id                           = $user['unique_id'];
                
                $msg                               = "success_login";

                $user_image                        = "upload/user/user.png";

                $mobile_no = $user['mobile_no'];
			$mobile_no_enc = base64_encode(openssl_encrypt($mobile_no, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
            // echo $mobile_no_enc;

            $unique_id = $user['unique_id'];
			$unique_id_enc = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

         
                if ($user['user_image']) {
                    $user_image = "upload/user/".$user['user_image'];
                }
              

                if($user_id!=''){

                $columns_login       = [
                        
                        "user_id"              => $user_id,
                        "entry_date"           => date('Y-m-d'),
                        "entry_time"           => date('h:i:s'),
                        "log_type"             => 1,
                        "unique_id"            => unique_id($prefix)
                 ];

                 $action_obj_log     = $pdo->insert($table_log,$columns_login);

              }


                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "success_login",
                    "mobile_no"      => $mobile_no,
                    "unique_id_enc"       => $unique_id_enc,
                    "mobile_no_enc"       => $mobile_no_enc,
                    "unique_id"       => $user_id,
                    "session"   => $_SESSION
                ];

            }elseif(($count_data != 0)&&($active_status == 0)){
                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "inactive_user",
                    "sql"       => ""
                ];
            }else {
                // Incorrect username and password handling 
                $json_array = [
                    "status"    => 0,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "incorrect",
                   "sql"       => ""
                ];
            }
        } else {
            $msg    = "error";
        }
        
        echo json_encode($json_array);
        
        break;

        case 'dc_ir_dispatch_datatable':
            // DataTable Variables
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $from_date  = $_POST['from_date'];
            $to_date    = $_POST['to_date'];
            $opt1 = $_POST['opt1'];
            $limit         = $length;
            $dc_delivery_status  = $_POST['dc_delivery_status'];
    $con_district = $_POST['con_district'];
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
    
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as  s_no",
               
                "po_num",
                
                "ledger_name",
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
                
                // "invoice_no",
    
    
            ];
            $table_details  = [
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
    
            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
           
            $order_by       = datatable_sorting_ins2($order_column, $order_dir, $columns);
            $order_by = " 
      CASE 
        WHEN dc_delivery_status = '0' THEN 1
        WHEN dc_delivery_status = '5' THEN 2
        WHEN dc_delivery_status = '1' THEN 3
        WHEN dc_delivery_status = '3' THEN 4
        ELSE 5
      END $order_dir
    ";
    
    
    
    
            $search         = datatable_searching($search, $columns);
            
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records  = total_records();
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type  = $_POST['user_type_unique_id'];
            
        $table_user ="user_screen_permission";
            $columns        = [
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
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
                    $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];
    
                    $dc_delivery_status=$value['dc_delivery_status'];
                    
    
                    $dc_delivery_status=$value['dc_delivery_status'];
                    if($value['dc_delivery_status'] == 0){
                        $value['dc_delivery_status'] = 'Pending';
                    }
                    else if($value['dc_delivery_status'] == 5){
                        $value['dc_delivery_status'] = 'partial Completed';
                    }
                    else if($value['dc_delivery_status'] == 1){
                        $value['dc_delivery_status'] = 'SNR';
                    }
                    else if($value['dc_delivery_status'] == 3){
                        $value['dc_delivery_status'] = 'Completed';
                    }
                   
                  
                    $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';
                    $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
    
                    $orgDate1 = $value['installation_com_date'];
                    if(  $orgDate1!=''){
                    $value['installation_com_date'] = date("d-m-Y", strtotime($orgDate1));
                    }
                    else{
                        $value['installation_com_date']='';
                    }
                    $d = $value['invoice_no'];
                    $where_2 = "invoice_no = '" . $d . "' ";
                    
                    $table_1      =  "dc_ir_doc_dispatch_details";
    
                    $columns_2    = [
                        'COUNT(invoice_no) AS count',
                        "dc_dispatch_mode",
                        "ir_dispatch_mode",
                        "snr_dispatch_mode",
                        "(select dc_required from installation_details where po_form_unique_id=$table_1.po_form_unique_id )as dc_required",
                    ];
    
                    $table_details_1   = [
                        $table_1,
                        $columns_2
                    ];
    
                    $result_values_12  = $pdo->select($table_details_1, $where_2);
                    $data_st       = $result_values_12->data;
    
                     $invoice_no=  $value['invoice_no'];
                  
                    $btn_update          = btn_update_install($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                    // print_R($btn_update);
                    $btn_view          = btn_view_ins_dc_ir($folder_name, $value['consignee_unique_id'], $value['invoice_no']);
                    if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                        if($dc_delivery_status=='3') {
                           // print_r($value['stock_qty']==$value['invoice_qty']);die();
                           $value['consignee_unique_id']     =  $btn_view;
                      } 
                       else{
                      
                           if(in_array('5f88082b25ec031952', $action_ids)){
                            $value['consignee_unique_id'] = $btn_update;
                        }
                           
                           else{
                            $value['consignee_unique_id'] = '';
                           }
                         }
                       
                     }
                     if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                       
                    
                        if(in_array('5f88082b25ec031952', $action_ids)){
                            $value['consignee_unique_id']     =  $btn_update;
                       }
                      
                       else{
                        $value['consignee_unique_id'] = '';
                       }
                     }
       
    
    
    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;
    
            // 2tab



        case 'createupdate':

            $old_password          = $_POST["old_password"];
            $new_password          = $_POST["new_password"];
            // $profile_image         = $_POST["image_name"];
            $unique_id             = $_POST["unique_id"];
    
            $update_where       = "";
    
            if(($old_password != '')) {
            $columns            = [
                "password"      => $new_password,
                // "profile_image" => $profile_image,
                "unique_id"     => $unique_id
            ];
    
           // check already Exist Or not
            $table_details      = [
                $table,
                [
                    "COUNT(unique_id) AS count"
                ]
            ];
            $select_where       = '(password = "'.$old_password.'") AND is_delete = 0  ';
    
            // When Update Check without current id
            if ($unique_id) {
                $select_where   .= ' AND unique_id ="'.$unique_id.'" ';
            }
    
            $action_obj         = $pdo->select($table_details,$select_where);
    
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
            }
            
            if ($data[0]["count"] == 1) {
            // Update Begins
            if($unique_id) {
    
                unset($columns['unique_id']);
    
                $update_where   = [
                    "unique_id"     => $unique_id
                ];
    
                $action_obj     = $pdo->update($table,$columns,$update_where);
    
            // Update Ends
            } else {
            // Insert Begins
               
                $msg    = "Old Password doesn't Match";
            // Insert Ends
            }
    
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
                if ($unique_id) {
                    $msg        = "update";
                } 
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
            }
        } else {
            // Insert Begins
               
                $msg    = "Old Password doesn't Match";
            // Insert Ends
            }
    
        } else if(($old_password == '')) {
            $columns            = [
                //"password"      => $new_password,
                // "profile_image" => $profile_image,
                "unique_id"     => $unique_id
            ];
    
           // check already Exist Or not
           
            // Update Begins
            if($unique_id) {
    
                    unset($columns['unique_id']);
    
                    $update_where   = [
                        "unique_id"     => $unique_id
                    ];
    
                    $action_obj     = $pdo->update($table,$columns,$update_where);
    
                // Update Ends
                
                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = "";
                    $sql        = $action_obj->sql;
    
                    if ($unique_id) {
                        $msg        = "update";
                    } 
                } else {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = $action_obj->error;
                    $sql        = $action_obj->sql;
                    $msg        = "error";
                }
            } 
        } else {
              $columns            = [
                "password"      => $new_password,
                // "profile_image" => $profile_image,
                "unique_id"     => $unique_id
            ];
    
           // check already Exist Or not
            $table_details      = [
                $table,
                [
                    "COUNT(unique_id) AS count"
                ]
            ];
            $select_where       = '(password = "'.$old_password.'") AND is_delete = 0  ';
    
            // When Update Check without current id
            if ($unique_id) {
                $select_where   .= ' AND unique_id ="'.$unique_id.'" ';
            }
    
            $action_obj         = $pdo->select($table_details,$select_where);
    // print_r($action_obj);
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
            }
            
            if ($data[0]["count"] == 1) {
            // Update Begins
            if($unique_id) {
    
                unset($columns['unique_id']);
    
                $update_where   = [
                    "unique_id"     => $unique_id
                ];
    
                $action_obj     = $pdo->update($table,$columns,$update_where);
    
            // Update Ends
            } else {
            // Insert Begins
               
                $msg    = "Old Password doesn't Match";
            // Insert Ends
            }
    // print_r(
    //     $action_obj );
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
                if ($unique_id) {
                    $msg        = "update";
                } 
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
            }
        } else {
            // Insert Begins
               
                $msg    = "Old Password doesn't Match";
            // Insert Ends
            }
        }
            $json_array   = [
                "status"    => $status,
                "data"      => $data,
                "error"     => $error,
                "msg"       => $msg,
                "sql"       => $sql
            ];
    
            echo json_encode($json_array);
    
         break;
    
    
    default:
        
        break;
}

?>

 
