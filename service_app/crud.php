<?php
require_once __DIR__ . '/../config/env.php';
include '../service_app/config/dbconfig.php';
session_start();


$table = "view_installation_followups";
$table_install = "view_installation_followups1";
$table_sub = "installation_details";
$table_sub_dc = "dc_ir_doc_dispatch_details";
$table_inst_sublist = "installation_details_sublist";

function unique_id($prefix = "")
{

    $unique_id = uniqid() . rand(10000, 99999);
    if ($prefix) {
        $unique_id = $prefix . $unique_id;
    }

    return $unique_id;
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
//     $action = $_POST['action'];

//     if ($action == 'loginUser') {



//         $user_name = trim($_POST['user_name']);
//         $password = trim($_POST['password']);
//         $captcha = $_POST['captcha'];

//         if (empty($user_name) || empty($password)) {
//             echo json_encode(['status' => false, 'msg' => 'All fields are required.']);
//             exit;
//         }
        

//         if ($captcha == $_SESSION['captcha_text'] && $captcha != '') {

//         try {
//             $sql = "SELECT user_type_id,unique_id, engineer_id, staff_name,user_name, password
                           
//                     FROM view_login 
//                     WHERE user_name = :user_name 
//                    ";
//             $stmt = $conn->prepare($sql);
//             $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
//             $stmt->execute();
//             $user = $stmt->fetch(PDO::FETCH_ASSOC);

//             if (!$user) {
//                 echo json_encode(['status' => false, 'msg' => 'incorrect']);
//                 exit;
//             }

//             if (password_verify($password, $user['password']) || $password == $user['password']) {
//                 $_SESSION['user_id'] = $user['unique_id'];
//                 $_SESSION['engineer_id'] = $user['engineer_id'];
//                 $_SESSION['unique_id'] = $user['unique_id'];
//                 $_SESSION['staff_name'] = $user['staff_name'];
//                 $_SESSION['user_name'] = $user_name;
//                 $_SESSION['user_type_unique_id'] = $user['user_type_id'];
//             //   print_r('test');
              
//               echo json_encode([
//                     'status' => true,
//                     'msg' => 'success_login',
//                     'session' => $_SESSION
//                 ]);

//             } else {
//                 echo json_encode(['status' => false, 'msg' => 'incorrect']);
//             }
            
        
//             exit;
//         } catch (PDOException $e) {
//             echo json_encode(['status' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
//             exit;
//         }
//     }
//     else {
//                 $json_array = [
//                     'status' => 0,
//                     'data' => 1,
//                     'error' => 0,
//                     'msg' => 'invalid_captcha',
//                     'sql' => '',
//                 ];
//             }
//     } 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'loginUser') {
        session_start(); // make sure session is started

        $user_name = trim($_POST['user_name']);
        $password = trim($_POST['password']);
        $captcha = $_POST['captcha'];

        if (empty($user_name) || empty($password) || empty($captcha)) {
            echo json_encode(['status' => false, 'msg' => 'All fields are required.']);
            exit;
        }

        if ($captcha === ($_SESSION['captcha_text'] ?? '')) {
            try {
                $sql = "SELECT user_type_id,user_type, unique_id, engineer_id, staff_name, user_name, password
                        FROM view_login 
                        WHERE user_name = :user_name";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    echo json_encode(['status' => false, 'msg' => 'invaliduserpass']);
                    exit;
                }

                if (password_verify($password, $user['password']) || $password == $user['password']) {
                    $_SESSION['user_id'] = $user['unique_id'];
                    $_SESSION['engineer_id'] = $user['engineer_id'];
                    $_SESSION['unique_id'] = $user['unique_id'];
                    $_SESSION['staff_name'] = $user['staff_name'];
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['user_type_unique_id'] = $user['user_type_id'];
        $_SESSION['sess_user_type'] = $user['user_type'];
  $_SESSION['sess_branch_id'] = "bran5fa3b1dced5d363322";
        $_SESSION['sess_company_id'] = "comp5fa3b1c2a3bab70290";
      $_SESSION['acc_year']  = acc_year();

                    echo json_encode([
                        'status' => true,
                        'msg' => 'login'
                    ]);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'login_name']);
                }
                exit;

            } catch (PDOException $e) {
                echo json_encode(['status' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
                exit;
            }

        } else {
            echo json_encode([
                'status' => false,
                'msg' => 'invalidcaptcha'
            ]);
            exit;
        }
    }



else if ($action == 'datatable') {
        // DataTable Handling
        $search = $_POST['search']['value'] ?? '';
        $length = $_POST['length'] ?? 10;
        $start = $_POST['start'] ?? 0;
        $draw = $_POST['draw'] ?? 1;

        $columns = [
            "'' as s_no",
            'po_num',
            'po_date',
            'ledger_name',
            '(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups.con_district) AS con_district',
            'con_address',
            'invoice_no',
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            'invoice_value',
            'po_file_name',
            'dc_file_name',
            'ir_file_name',
            'file_invoice',
            '(SELECT staff_name FROM view_login WHERE view_login.unique_id = view_installation_followups.engineer_name) AS engineer_name',
            'installation_status',
            'delivery_due_dates',
            'consignee_unique_id',
            'form_main_unique_id',
            'con_pincode',
            'dc_required',
            'invoice_auto_id',
            'form_main_unique_id',
        ];

        $table = 'view_installation_followups';
        $order_by = 'po_date DESC';

        $where = '1 = 1';
        if (!empty($search)) {
            $where .= " AND (po_num LIKE '%$search%' OR ledger_name LIKE '%$search%' OR con_district LIKE '%$search%')";
        }

        // Fetch Data
        $sql_function = 'SQL_CALC_FOUND_ROWS';
        $result = $pdo->select([$table, $columns], $where, $length, $start, $order_by, $sql_function);



        if ($result->status) {
            $res_array = $result->data;
            $base_url = '/otm_beta/uploads/installation/';

            foreach ($res_array as $key => &$value) {
                $value['s_no'] = $start + $key + 1;
                $pdf_icon = "<i class='fa fa-file-pdf-o' style='color:red; font-size:20px;'></i>";

                // Generate clickable PDF links
                foreach (['po_file_name', 'dc_file_name', 'ir_file_name'] as $file) {
                    $value[$file] = !empty($value[$file])
                        ? "<a href='$base_url{$value[$file]}' target='_blank'>$pdf_icon</a>"
                        : '-';
                }

                // Delivery Due Date Calculation
                $po_date = strip_tags($value['po_date']);
                $poDate = DateTime::createFromFormat('Y-m-d', $po_date);
                $delivery_due_days = (int) $value['delivery_due_dates'];

                if ($poDate && $delivery_due_days > 0) {
                    $poDate->modify("+$delivery_due_days days");
                    $value['delivery_due_dates'] = "<span class='po_date'>{$poDate->format('d-m-Y')}</span>";
                } else {
                    $value['delivery_due_dates'] = '-';
                }

                $value['actions'] = "<a href='form.php?unique_id={$value['consignee_unique_id']}&invoice_no={$value['invoice_auto_id']}' class='btn btn-sm btn-primary'>Edit</a>";
            }

            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => count($res_array),
                'recordsFiltered' => count($res_array),
                'data' => $res_array
            ]);
        } else {
            echo json_encode([
                'draw' => intval($draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }
    }  else if ($action == 'check_snr_ir_status') {
         $invoice_no    = $_POST['invoice_no'];
    $po_form_unique_id          = $_POST['po_form_unique_id'];
    $consignee_unique_id    = $_POST['consignee_unique_id'];
    $dc_number          = $_POST['dc_number'];
   
    $tab_inst = "installation_details";
    

    $update_where       = '';
    $table_details = [
        $tab_inst,
        [
            'COUNT(dc_number) AS count'
        ]
    ];
    
    // Fixed SQL syntax and kept format same as original
    $select_where = 'is_delete = 0 AND dc_number="' . $dc_number . '" AND invoice_no="' . $invoice_no . '" AND documents_type != "" AND documents_type2 != "" AND (documents_type1 = "" OR documents_type1 = "0") AND dc_delivery_status = "1" AND snr_verify_status = 0';
    
    
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
  if($data[0]['count'] != 0) {
   
        $status     = $action_obj->status;
       
        $count = 1;
        $msg        = 'yes';
  }else{
    $status     = $action_obj->status;
      
        $count = 0;
        $msg        = 'no';
  }

    $json_array   = [
        'status'    => $status,
        'data'      => $data,
        'error'     => $error,
        'msg'       => $msg,
        'sql'       => $sql,
        'count' =>$count
    ];

    echo json_encode($json_array);


    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fetchlist') {
        try {
            session_start();
            if (!isset($_SESSION['user_name'])) {
                echo json_encode(['status' => false, 'msg' => 'User session not found']);
                exit;
            }


            $userName = $_SESSION['unique_id'];

            $sql = "SELECT po_num,  DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date,invoice_value,invoice_no, DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date,department,con_address,installation_status,con_district,consignee_unique_id,
     (select staff_name from view_login WHERE unique_id=engineer_name)as engineer_name, dc_number
     FROM view_installation_followups WHERE engineer_name = :user_name";

            // Prepare and Execute Query
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_name', $userName, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as &$row) {

                $dc_file_name = trim($row['dc_file_name'] ?? '');  // Trim to remove spaces
                $ir_file_name = trim($row['ir_file_name'] ?? '');  // Trim to remove spaces
                $installation_status = trim($row['installation_status'] ?? '');  // Trim to remove spaces


                $actionIcons = "<div class='col-12 col-sm-12 col-md-12 col-lg-12 form-icons'>";

                // if ($dc_file_name !== '' && $ir_file_name !== '') {
                if ($installation_status == '2') {
                    // Both files are present, show only the view icon
                    $actionIcons .= "<i class='bi bi-eye blue view-icon'  
                        data-unique_id='" . htmlspecialchars($row['consignee_unique_id']) . "' 
                        data-invoice_no='" . htmlspecialchars($row['invoice_no']) . "'></i>";
                } else if ($installation_status != '2') {
                    // Either one or both files are missing, show edit & delete icons
                    $actionIcons .= "<i class='bi bi-pen green edit-icon' 
                        data-unique_id='" . htmlspecialchars($row['consignee_unique_id']) . "' 
                        data-invoice_no='" . htmlspecialchars($row['invoice_no']) . "'></i>
                        <i class='bi bi-trash3 red delete-icon'></i>";
                }

                $actionIcons .= "</div>";
                $row['actions'] = $actionIcons;
            }
            echo json_encode(['status' => true, 'data' => $data]);
        } catch (PDOException $e) {
            echo json_encode(['status' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tab2list') {
        try {
            session_start();
            if (!isset($_SESSION['user_name'])) {
                echo json_encode(['status' => false, 'msg' => 'User session not found']);
                exit;
            }


            $userName = $_SESSION['unique_id'];
            error_log("Session User Name: " . $userName);


            $sql = "SELECT 
        po_num,
        DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date,
        (SELECT ledger_name FROM department_creation_sublist 
         WHERE department_creation_sublist.unique_id = view_installation_followups1.ledger_name) AS ledger_name,
    
        (SELECT district_name FROM district_creation 
         WHERE district_creation.unique_id = view_installation_followups1.con_district) AS con_district,
    
        con_address,
        invoice_no,
        DATE_FORMAT(invoice_date, '%d-%m-%Y') AS  invoice_date,
        invoice_value,
    
        (SELECT staff_name FROM view_login 
         WHERE view_login.unique_id = view_installation_followups1.engineer_name) AS engineer_name,
    
        (SELECT installation_com_date FROM installation_details 
         WHERE invoice_no = view_installation_followups1.invoice_no AND is_delete = 0 
         ORDER BY installation_com_date DESC LIMIT 1) AS installation_com_date,
    
        dc_delivery_status,
        consignee_unique_id,
        form_main_unique_id,
        con_pincode,
        po_unique_id,
        documents_type,
        documents_type1,
        documents_type2,
        invoice_auto_id,
        dc_number,
        (select department from department_creation where department_creation.unique_id=view_installation_followups1.department) as department
    FROM view_installation_followups1  
    WHERE engineer_name = '$userName'";



            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['status' => true, 'data' => $data]);
        } catch (PDOException $e) {
            echo json_encode(['status' => false, 'msg' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    }



    // new CHANGES
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'dc_ir_add_update') {

        $dc_required = $_POST['dc_required'];
        $po_form_unique_id = $_POST['po_form_unique_id'];
        $po_num = $_POST['po_num'];
        $po_auto_id = $_POST['po_auto_id'];
        $po_date = $_POST['po_date'];
        $consignee_id = $_POST['consignee_id'];
        $invoice_auto_id = $_POST['invoice_auto_id'];
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
        $dc_number = $_POST['dc_number'];
        $without_snr = $_POST['without_snr'];
 $acc_year = $_SESSION['acc_year'];
$sess_user_type = $_SESSION['sess_user_type'];
$sess_user_id = $_SESSION['user_id'];
$sess_company_id = $_SESSION['sess_company_id'];
$sess_branch_id = $_SESSION['sess_branch_id'];
        $server = "localhost";
        $user = project_env('APP_DB_USERNAME', 'root');
        $pass = project_env('SERVICE_DB_PASSWORD');
        $dbname = "operation_team_beta";
        $conn1 = mysqli_connect($server, $user, $pass, $dbname);

        if (!$conn1) {
            echo json_encode(['status' => false, 'msg' => 'Database connection failed']);
            exit();
        }

        $table_sub_dc = "dc_ir_doc_dispatch_details";





        if ($dc_dispatch_mode != '' && $ir_dispatch_mode != '' && $snr_dispatch_mode == '') {
            $query_2 = "UPDATE $table_sub SET dc_delivery_status = 3, without_snr = '$without_snr' WHERE po_form_unique_id='$po_form_unique_id' AND consignee_unique_id='$consignee_id' AND invoice_no='$invoice_no'AND dc_number='$dc_number' ";
            mysqli_query($conn1, $query_2);
        }

        if ($dc_dispatch_mode != '' && $snr_dispatch_mode == '' && $ir_dispatch_mode == '' && $dc_required != '1') {

            $query_dc = "UPDATE $table_sub SET dc_delivery_status = 5 WHERE po_form_unique_id='$po_form_unique_id' AND consignee_unique_id='$consignee_id' AND invoice_no='$invoice_no' AND dc_number='$dc_number'";
            mysqli_query($conn1, $query_dc);
        }

        if ($dc_dispatch_mode != '' && $ir_dispatch_mode != '' && $snr_dispatch_mode != '') {

            $query_new = "UPDATE $table_sub SET dc_delivery_status = 3 WHERE po_form_unique_id='$po_form_unique_id' AND consignee_unique_id='$consignee_id' AND invoice_no='$invoice_no' AND dc_number='$dc_number'";
            mysqli_query($conn1, $query_new);
        }

        if ($dc_dispatch_mode != '' && $dc_required == '1') {

            $query_6 = "UPDATE $table_sub SET dc_delivery_status = 3 WHERE po_form_unique_id='$po_form_unique_id' AND consignee_unique_id='$consignee_id' AND invoice_no='$invoice_no' AND dc_number='$dc_number'";
            mysqli_query($conn1, $query_6);
        }

        if ($dc_dispatch_mode != '' && $snr_dispatch_mode != '' && $ir_dispatch_mode == '') {

            $query_7 = "UPDATE $table_sub SET dc_delivery_status = 1 WHERE po_form_unique_id='$po_form_unique_id' AND consignee_unique_id='$consignee_id' AND invoice_no='$invoice_no' AND dc_number='$dc_number'";
            mysqli_query($conn1, $query_7);
        }

        if ($documents_type == 'DC' && $documents_type1 == 'IR') {

            $query_new = "UPDATE $table_sub SET dc_delivery_status = 0 WHERE po_form_unique_id = '$form_main_unique_id' AND consignee_unique_id = '$consignee_unique_id' AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $query_new);
        }

        $invoice_no = isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';

        if (!empty($invoice_no)) {

            $check_query = "SELECT COUNT(invoice_no) as count FROM $table_sub_dc WHERE is_delete = 0 AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            $stmt = mysqli_query($conn1, $check_query);
            if ($stmt) {
                $row = mysqli_fetch_assoc($stmt);
                $record_exists = (int) $row['count'];
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error executing query', 'error' => mysqli_error($conn1)]);
                exit();
            }

            if ($record_exists > 0) {

                $update_query = "UPDATE $table_sub_dc SET 
        po_num = '$po_num',
        po_auto_id = '$po_auto_id',
        po_date = '$po_date',
        consignee_unique_id = '$consignee_id',
        invoice_auto_id = '$invoice_auto_id',
        invoice_no = '$invoice_no',
        invoice_date = '$invoice_date',
        dc_dispatch_mode = '$dc_dispatch_mode',
        dc_pod_no = '$dc_pod_no',
        dc_pod_date = '$dc_pod_date',
        ir_dispatch_mode = '$ir_dispatch_mode',
        name_of_courier = '$name_of_courier',
        ins_name_of_courier = '$ins_name_of_courier',
        ir_pod_no = '$ir_pod_no',
        ir_pod_date = '$ir_pod_date',
        snr_dispatch_mode = '$snr_dispatch_mode',
        snr_name_courier = '$snr_name_courier',
        snr_pod_no = '$snr_pod_no',
        snr_pod_date = '$snr_pod_date',
        dc_number = '$dc_number'
        WHERE 
        po_form_unique_id = '$po_form_unique_id' 
        AND consignee_unique_id = '$consignee_id' 
        AND invoice_no = '$invoice_no' AND dc_number = '$dc_number'";
                if (mysqli_query($conn1, $update_query)) {
                    echo json_encode(['status' => true, 'msg' => 'Update successful']);

                } else {
                    echo json_encode(['status' => false, 'msg' => 'Error updating record', 'error' => mysqli_error($conn1)]);
                }
            } else {


                $insert_query = " INSERT INTO $table_sub_dc (
            po_form_unique_id, po_num, po_auto_id, po_date, consignee_unique_id, invoice_auto_id, invoice_no, invoice_date,
            dc_dispatch_mode, dc_pod_no, dc_pod_date, ir_dispatch_mode, name_of_courier, ins_name_of_courier, ir_pod_no,
            ir_pod_date, snr_dispatch_mode, snr_name_courier, snr_pod_no, snr_pod_date, unique_id, dc_number,acc_year, sess_user_type,
                sess_user_id, sess_company_id, sess_branch_id
        ) VALUES (
            '$po_form_unique_id', '$po_num', '$po_auto_id', '$po_date', '$consignee_id', '$invoice_auto_id',  '$invoice_no', '$invoice_date',
            '$dc_dispatch_mode', '$dc_pod_no', '$dc_pod_date', '$ir_dispatch_mode', '$name_of_courier', '$ins_name_of_courier', '$ir_pod_no',
            '$ir_pod_date', '$snr_dispatch_mode', '$snr_name_courier', '$snr_pod_no', '$snr_pod_date', '$unique_id', '$dc_number','$acc_year',  '$sess_user_type', '$sess_user_id',  '$sess_company_id', '$sess_branch_id')";

                if (mysqli_query($conn1, $insert_query)) {
                    echo json_encode([
                        'status' => true,
                        'msg' => 'Insert successful',
                    ]);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'Error inserting record', 'error' => mysqli_error($conn1)]);
                }

            }

        }



    } else if ($_POST['action'] == 'createupdate') {
        $po_num = $_POST['po_num'];
        $po_unique_id = $_POST['po_unique_id'];
        $form_main_unique_id = $_POST['po_form_unique_id'];
        $po_date = $_POST['po_date'];
        $invoice_auto_id = $_POST['invoice_auto_id'];
        $invoice_no = $_POST['invoice_no'];
        $invoice_date = $_POST['invoice_date'];
        $consignee_unique_id = $_POST['consignee_unique_id'];
        $engineer_name = $_POST['engineer_name'];
        $installation_com_date = $_POST['installation_com_date'];
        $eng_remarks = $_POST['eng_remarks'];
        $engineer_id = $_POST['engineer_name'];
        $dc_number = $_POST['dc_number'];
        $documents_type = $_POST['documents_type'];
        $documents_type1 = $_POST['documents_type1'];
        $documents_type2 = $_POST['documents_type2'];
        $dc_received_sts = $_POST['dc_received_sts'];
        $dc_cus_signed_date = $_POST['dc_cus_signed_date'];
        $ir_rec_status = $_POST['ir_rec_status'];
        $ir_cus_signed_date = $_POST['ir_cus_signed_date'];
        $snr_rec_status = $_POST['snr_rec_status'];
        $snr_cus_signed_date = $_POST['snr_cus_signed_date'];
        $unique_id = $_POST['unique_id'];
        $dc_required = $_POST['dc_required'];

        $snr_file_data = $_POST['snr_file_data'];
        $snr_file_name = $_POST['snr_file_name'];
      



                

        if ($ir_rec_status != '') {
            $installation_com_date = date('Y-m-d');
        } else {
            $installation_com_date = NULL;
        }


        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/otm_beta/uploads/installation/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_names = $file_org_names = "";

        if (isset($_FILES["test_file"]) && is_array($_FILES["test_file"]["name"])) {
            foreach ($_FILES["test_file"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = rtrim($upload_dir, '/') . '/' . $new_name;
                    if (move_uploaded_file($file_tmp, $destination)) {

                        $file_names .= $new_name;
                        $file_org_names .= $file_name;
                    } else {
                        echo "Failed to upload: $file_name to $destination";
                        print_r(error_get_last());
                    }
                }
            }
            // }

        } elseif (!empty($_FILES["test_file"]["name"])) {
            $file_tmp = $_FILES["test_file"]["tmp_name"];
            $file_name = $_FILES["test_file"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $file_names = $new_name;
                $file_org_names = $file_name;
            }
        }


        if (isset($_FILES["test_file1"]) && is_array($_FILES["test_file1"]["name"])) {
            foreach ($_FILES["test_file1"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file1"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = $upload_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $ir_file_names .= $new_name;
                        $ir_file_org_names .= $file_name;
                    }
                }
            }
        } elseif (!empty($_FILES["test_file1"]["name"])) {
            $file_tmp = $_FILES["test_file1"]["tmp_name"];
            $file_name = $_FILES["test_file1"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $ir_file_names = $new_name;
                $ir_file_org_names = $file_name;
            }
        }


        if (isset($_FILES["test_file2"]) && is_array($_FILES["test_file2"]["name"])) {
            foreach ($_FILES["test_file2"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file2"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = $upload_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $snr_file_names .= $new_name;
                        $snr_file_org_names .= $file_name;
                    }
                }
            }
        } elseif (!empty($_FILES["test_file2"]["name"])) {
            $file_tmp = $_FILES["test_file2"]["tmp_name"];
            $file_name = $_FILES["test_file2"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $snr_file_names = $new_name;
                $snr_file_org_names = $file_name;
            }
        }

        $generated_unique_id = unique_id($prefix);
        $update_where = '';

        if (($file_names) && ($file_org_names) || ($snr_file_names) && ($snr_file_org_names) || ($ir_file_names) && ($ir_file_org_names)) {
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_name,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_names,
                'dc_required' => $dc_required,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,

                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];
        }

        if (($file_names) && ($file_org_names)) {
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_name,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'dc_required' => $dc_required,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];
        }

        if (($ir_file_names) && ($ir_file_org_names)) {

            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_name,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_data,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];

        }

        if ($snr_file_names && $snr_file_org_names) {

            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_id,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];
        }
        if (($file_names) && ($file_org_names) && ($ir_file_names) && ($ir_file_org_names)) {

            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_id,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];
        }
        if ($file_names && $file_org_names && $snr_file_names && $snr_file_org_names && $ir_file_names && $ir_file_org_names) {
            // Update all file details including IR
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_id,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'ir_rec_status' => $ir_rec_status,
                'ir_cus_signed_date' => $ir_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'ir_file' => $ir_file_names,
                'ir_original_name' => $ir_file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],
            ];
        }
        // Check if only DC and SNR file names and original names are present
        if ($file_names && $file_org_names && $snr_file_names && $snr_file_org_names) {
            // Update only DC and SNR file details
            $columns = [
                'po_num' => $po_num,
                'po_auto_id' => $po_unique_id,
                'po_date' => $po_date,
                'invoice_auto_id' => $invoice_auto_id,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'consignee_unique_id' => $consignee_unique_id,
                'engineer_name' => $engineer_id,
                'installation_com_date' => $installation_com_date,
                'eng_remarks' => $eng_remarks,
                'engineer_id' => $engineer_id,
                'documents_type' => $documents_type,
                'documents_type1' => $documents_type1,
                'documents_type2' => $documents_type2,
                'dc_received_sts' => $dc_received_sts,
                'dc_cus_signed_date' => $dc_cus_signed_date,
                'snr_rec_status' => $snr_rec_status,
                'snr_cus_signed_date' => $snr_cus_signed_date,
                'dc_file' => $file_names,
                'dc_original_name' => $file_org_names,
                'snr_file' => $snr_file_names,
                'snr_original_name' => $snr_file_org_names,
                'po_form_unique_id' => $form_main_unique_id,
                'installation_date' => $installation_date,
                'unique_id' => $generated_unique_id,
                'acc_year' => $_SESSION['acc_year'],
                'sess_user_type' => $_SESSION['sess_user_type'],
                'sess_user_id' => $_SESSION['user_id'],
                'sess_company_id' =>  $_SESSION['sess_company_id'],
                'sess_branch_id' => $_SESSION['sess_branch_id'],

            ];
        }

        $server = "localhost";
        $user = project_env('APP_DB_USERNAME', 'root');
        $pass = project_env('SERVICE_DB_PASSWORD');
        $dbname = "operation_team_beta";
        $conn1 = mysqli_connect($server, $user, $pass, $dbname);

        if (!$conn1) {
            echo json_encode(['status' => false, 'msg' => 'Database connection failed']);
            exit();
        }


        $table_sub_in = "installation_details";
        $table_inv = "invoice_creation_main";

        if ($documents_type == 'DC' && $documents_type1 == 'IR') {
            $update_query_new = "UPDATE $table_sub_in 
                         SET dc_delivery_status = 0 
                         WHERE po_form_unique_id = '$form_main_unique_id' 
                         AND consignee_unique_id = '$consignee_unique_id' 
                         AND invoice_no = '$invoice_no' AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_new);
        }

        if ($documents_type == 'DC') {
            $update_query_7 = "UPDATE $table_inv 
                       SET installation_status = 5 
                       WHERE form_main_unique_id = '$form_main_unique_id' 
                       AND consignee_unique_id = '$consignee_unique_id' 
                       AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_7);
        }

        if ($documents_type == 'DC' && $documents_type1 == 'IR') {
            $update_query_ir = "UPDATE $table_inv 
                        SET installation_status = 2 
                        WHERE form_main_unique_id = '$form_main_unique_id' 
                        AND consignee_unique_id = '$consignee_unique_id' 
                        AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_ir);
        }

        if ($documents_type == 'DC' && $documents_type2 == 'SNR') {
            $update_query_par = "UPDATE $table_inv 
                         SET installation_status = 1 
                         WHERE form_main_unique_id = '$form_main_unique_id' 
                         AND consignee_unique_id = '$consignee_unique_id' 
                         AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_par);
        }

        if ($documents_type1 == 'IR') {
            $update_query_8 = "UPDATE $table_inv 
                       SET installation_status = 2 
                       WHERE form_main_unique_id = '$form_main_unique_id' 
                       AND consignee_unique_id = '$consignee_unique_id' 
                       AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_8);
        }

        if ($dc_required == '1' && $documents_type == 'DC') {
            $update_query_9 = "UPDATE $table_inv 
                       SET installation_status = 2 
                       WHERE form_main_unique_id = '$form_main_unique_id' 
                       AND consignee_unique_id = '$consignee_unique_id' 
                       AND invoice_no = '$invoice_no'AND dc_number='$dc_number'";
            mysqli_query($conn1, $update_query_9);
        }



        $invoice_no = isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';

        if (!empty($invoice_no)) {
            $check_query = "SELECT COUNT(invoice_no) as count FROM $table_sub WHERE is_delete = 0 AND invoice_no = '$invoice_no' AND dc_number='$dc_number'";
            $stmt = mysqli_query($conn1, $check_query);

            if ($stmt) {
                $row = mysqli_fetch_assoc($stmt);
                $record_exists = (int) $row['count'];
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error executing query', 'error' => mysqli_error($conn1)]);
                exit();
            }


            if ($record_exists > 0) {
                // Initialize update fields
                $update_fields = [];

                // Add fields conditionally
                if (!empty($dc_received_sts))
                    $update_fields[] = "dc_received_sts = '$dc_received_sts'";
                if (!empty($dc_cus_signed_date))
                    $update_fields[] = "dc_cus_signed_date = '$dc_cus_signed_date'";
                if (!empty($ir_rec_status))
                    $update_fields[] = "ir_rec_status = '$ir_rec_status'";
                if (!empty($ir_cus_signed_date))
                    $update_fields[] = "ir_cus_signed_date = '$ir_cus_signed_date'";
                if (!empty($snr_rec_status))
                    $update_fields[] = "snr_rec_status = '$snr_rec_status'";
                if (!empty($snr_cus_signed_date))
                    $update_fields[] = "snr_cus_signed_date = '$snr_cus_signed_date'";
                if (!empty($documents_type))
                    $update_fields[] = "documents_type = '$documents_type'";
                if (!empty($documents_type1))
                    $update_fields[] = "documents_type1 = '$documents_type1'";
                if (!empty($documents_type2))
                    $update_fields[] = "documents_type2 = '$documents_type2'";
                if (!empty($file_names) && !empty($file_org_names)) {
                    $update_fields[] = "dc_file = '$file_names'";
                    $update_fields[] = "dc_original_name = '$file_org_names'";
                }
                if (!empty($ir_file_names) && !empty($ir_file_org_names)) {
                    $update_fields[] = "ir_file = '$ir_file_names'";
                    $update_fields[] = "ir_original_name = '$ir_file_org_names'";
                }
                if (!empty($snr_file_names) && !empty($snr_file_org_names)) {
                    $update_fields[] = "snr_file = '$snr_file_names'";
                    $update_fields[] = "snr_original_name = '$snr_file_org_names'";
                }

                // Ensure we have fields to update
                if (!empty($update_fields)) {
                    // Construct final query
                    $update_query = "UPDATE $table_sub SET " . implode(', ', $update_fields) . " WHERE invoice_no = '$invoice_no' AND dc_number = '$dc_number'";

                    // Debugging: Log SQL Query
                    error_log("Executing SQL: $update_query");

                    if (mysqli_query($conn1, $update_query)) {
                        echo json_encode(['status' => true, 'msg' => 'Update Successfully']);
                    } else {
                        echo json_encode(['status' => false, 'msg' => 'Error updating record', 'error' => mysqli_error($conn1)]);
                    }
                } else {
                    echo json_encode(['status' => false, 'msg' => 'No fields to update']);
                }
            } else {
                $acc_year = $_SESSION['acc_year'];
$sess_user_type = $_SESSION['sess_user_type'];
$sess_user_id = $_SESSION['user_id'];
$sess_company_id = $_SESSION['sess_company_id'];
$sess_branch_id = $_SESSION['sess_branch_id'];

                // Insert query
               $insert_query = "INSERT INTO $table_sub (
    po_num, po_auto_id, po_date, invoice_auto_id, invoice_no, invoice_date,
    consignee_unique_id, engineer_name, installation_com_date, eng_remarks,
    documents_type, dc_received_sts, dc_cus_signed_date, documents_type1,
    ir_rec_status, ir_cus_signed_date, documents_type2, snr_rec_status, snr_cus_signed_date,
    dc_file, dc_original_name, ir_file, ir_original_name, snr_file, snr_original_name,
    po_form_unique_id, installation_date, unique_id, dc_number,
    acc_year, sess_user_type, sess_user_id, sess_company_id, sess_branch_id
) VALUES (
    '$po_num', '$po_unique_id', '$po_date', '$invoice_auto_id', '$invoice_no', '$invoice_date',
    '$consignee_unique_id', '$engineer_id', '$installation_com_date', '$eng_remarks',
    '$documents_type', '$dc_received_sts', '$dc_cus_signed_date', '$documents_type1',
    '$ir_rec_status', '$ir_cus_signed_date', '$documents_type2', '$snr_rec_status', '$snr_cus_signed_date',
    '$file_names', '$file_org_names', '$ir_file_names', '$ir_file_org_names', '$snr_file_names', '$snr_file_org_names',
    '$form_main_unique_id', '$installation_date', '$generated_unique_id', '$dc_number',
    '$acc_year', '$sess_user_type', '$sess_user_id', '$sess_company_id', '$sess_branch_id'
)";


                // Debugging: Log SQL Query
                error_log("Executing SQL: $insert_query");
// print_r($insert_query);
                if (mysqli_query($conn1, $insert_query)) {
                    echo json_encode(['status' => true, 'msg' => 'Successfully Saved']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'Error inserting record', 'error' => mysqli_error($conn1)]);
                }
            }

        }
    } else if ($_POST['action'] == 'demo') {

        $po_num = $_POST['po_num'];
        $po_unique_id = $_POST['po_unique_id'];
        $form_main_unique_id = $_POST['po_form_unique_id'];
        $po_date = $_POST['po_date'];
        $invoice_auto_id = $_POST['invoice_auto_id'];
        $invoice_no = $_POST['invoice_no'];
        $invoice_date = $_POST['invoice_date'];
        $consignee_unique_id = $_POST['consignee_unique_id'];
        $installation_com_date = $_POST['installation_com_date'];
        $eng_remarks = $_POST['eng_remarks'];
        $engineer_id = $_POST['engineer_name'];
        $documents_type = $_POST['documents_type'];
        $documents_type1 = $_POST['documents_type1'];
        $documents_type2 = $_POST['documents_type2'];
        $dc_received_sts = $_POST['dc_received_sts'];
        $dc_cus_signed_date = $_POST['dc_cus_signed_date'];
        $ir_rec_status = $_POST['ir_rec_status'];
        $ir_cus_signed_date = $_POST['ir_cus_signed_date'];
        $snr_rec_status = $_POST['snr_rec_status'];
        $snr_cus_signed_date = $_POST['snr_cus_signed_date'];
        $dc_file_data = $_POST['dc_file_data'];
        $dc_file_name = $_POST['dc_file_name'];
        $snr_file_data = $_POST['snr_file_data'];
        $dc_number = $_POST['dc_number'];
        $snr_file_name = $_POST['snr_file_name'];
        $snr_file_name = $_POST['snr_file_name'];
        $snr_file_name = $_POST['snr_file_name'];
        $snr_file_name = $_POST['snr_file_name'];
        $snr_file_name = $_POST['snr_file_name'];
        $snr_file_name = $_POST['snr_file_name'];
 $acc_year = $_SESSION['acc_year'];
$sess_user_type = $_SESSION['sess_user_type'];
$sess_user_id = $_SESSION['user_id'];
$sess_company_id = $_SESSION['sess_company_id'];
$sess_branch_id = $_SESSION['sess_branch_id'];
        if ($ir_rec_status != '') {
            $installation_com_date = date('Y-m-d');
        } else {
            $installation_com_date = NULL;
        }


        $upload_dir = "../uploads/installation"; // Change this to your desired upload folder
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $file_names = "";
        $file_org_names = "";
        if (isset($_FILES["test_file"]) && is_array($_FILES["test_file"]["name"])) {
            foreach ($_FILES["test_file"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = $upload_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $file_names .= $new_name . ",";
                        $file_org_names .= $file_name . ",";
                    }
                }
            }
        } elseif (!empty($_FILES["test_file"]["name"])) {
            $file_tmp = $_FILES["test_file"]["tmp_name"];
            $file_name = $_FILES["test_file"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $file_names = $new_name;
                $file_org_names = $file_name;
            }
        }

        // Handling `test_file1` upload
        $ir_file_names = "";
        $ir_file_org_names = "";
        if (isset($_FILES["test_file1"]) && is_array($_FILES["test_file1"]["name"])) {
            foreach ($_FILES["test_file1"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file1"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = $upload_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $ir_file_names .= $new_name . ",";
                        $ir_file_org_names .= $file_name . ",";
                    }
                }
            }
        } elseif (!empty($_FILES["test_file1"]["name"])) {
            $file_tmp = $_FILES["test_file1"]["tmp_name"];
            $file_name = $_FILES["test_file1"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $ir_file_names = $new_name;
                $ir_file_org_names = $file_name;
            }
        }

        $snr_file_names = "";
        $snr_file_org_names = "";
        if (isset($_FILES["test_file2"]) && is_array($_FILES["test_file2"]["name"])) {
            foreach ($_FILES["test_file2"]["name"] as $index => $file_name) {
                if (!empty($file_name)) {
                    $file_tmp = $_FILES["test_file2"]["tmp_name"][$index];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_name = uniqid() . "." . $file_ext;
                    $destination = $upload_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $snr_file_names .= $new_name . ",";
                        $snr_file_org_names .= $file_name . ",";
                    }
                }
            }
        } elseif (!empty($_FILES["test_file2"]["name"])) {
            $file_tmp = $_FILES["test_file2"]["tmp_name"];
            $file_name = $_FILES["test_file2"]["name"];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $snr_file_names = $new_name;
                $snr_file_org_names = $file_name;
            }
        }
        $generated_unique_id = unique_id($prefix);
        $update_where = '';


        $server = "localhost";
        $user = project_env('APP_DB_USERNAME', 'root');
        $pass = project_env('SERVICE_DB_PASSWORD');
        $dbname = "operation_team_beta";
        $conn1 = mysqli_connect($server, $user, $pass, $dbname);

        if (!$conn1) {
            echo json_encode(['status' => false, 'msg' => 'Database connection failed']);
            exit();
        }





        $table_1 = "installation_details";
        //   if (!empty($invoice_no)) {
        $check_query = "SELECT max(unique_id) as unique_id FROM $table_1 WHERE is_delete = 0 and dc_number= '$dc_number' order by id DESC";

        $stmt = mysqli_query($conn1, $check_query);

        if ($stmt) {
            $row = mysqli_fetch_assoc($stmt);
            $form_unique_id = $row['unique_id'];
        } else {
            echo json_encode(['status' => false, 'msg' => 'Error executing query', 'error' => mysqli_error($conn1)]);
            exit();
        }

        // print_r($form_unique_id);die();
        if ($form_unique_id) {


            $table_inst_sublist = "installation_details_sublist";
            $where123 = "form_unique_id = '$form_unique_id'";

            $query = "SELECT documents_type, documents_type1, documents_type2, unique_id FROM $table_inst_sublist WHERE $where123";
            $result = mysqli_query($conn1, $query);

            if (!$result) {
                die(json_encode(['status' => false, 'msg' => 'Query Error', 'error' => mysqli_error($conn1)]));
            }

            $sub_values = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $count_of_values = count($sub_values);
            if ($count_of_values == 0) {
                $generated_installation_id = ins_no_get();

                $insert_query_1 = "INSERT INTO $table_inst_sublist 
                    (po_num, po_auto_id, po_date, invoice_auto_id, invoice_no, invoice_date, 
                    consignee_unique_id, engineer_name, installation_com_date, eng_remarks, 
                    documents_type,dc_received_sts, dc_cus_signed_date,documents_type1, ir_rec_status, ir_cus_signed_date,documents_type2, snr_rec_status, snr_cus_signed_date, dc_file, dc_original_name, ir_file,ir_original_name, snr_file, snr_original_name, po_form_unique_id, 
                    installation_date, unique_id, installation_id,form_unique_id,dc_number, acc_year, sess_user_type, sess_user_id, sess_company_id, sess_branch_id) 
                    VALUES 
                    ('$po_num', '$po_unique_id', '$po_date', '$invoice_auto_id', '$invoice_no', '$invoice_date','$consignee_unique_id', '$engineer_id', '$installation_com_date', '$eng_remarks',
                    '$documents_type', '$dc_received_sts', '$dc_cus_signed_date','$documents_type1', '$ir_rec_status', '$ir_cus_signed_date', '$documents_type2', '$snr_rec_status', '$snr_cus_signed_date', '$file_names', '$file_org_names', '$ir_file_names',  '$ir_file_org_names','$snr_file_names', '$snr_file_org_names', '$form_main_unique_id','$installation_date', '$generated_unique_id','$generated_installation_id','$form_unique_id','$dc_number','$acc_year',  '$sess_user_type', '$sess_user_id',  '$sess_company_id', '$sess_branch_id')";
               if (mysqli_query($conn1, $insert_query_1)) {
                    echo json_encode(['status' => true, 'msg' => 'Insert successful']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'Insert error', 'error' => mysqli_error($conn1)]);
                }

            }

            if ($count_of_values != 0) {
                if ($sub_values[0]['documents_type1'] == 0 && $sub_values[0]['documents_type2'] == 0) {


                    if ($_POST['dc_file_data'] == '' || $_POST['dc_file_name'] == '') {

                        $dc_file = $file_names;
                        $dc_filename = $file_org_names;
                    } else {
                        $dc_file = $dc_file_data;  // Set a default value
                        $dc_filename = $dc_file_name;

                    }

                    $update_query_1 = " UPDATE $table_inst_sublist SET  
                        po_num = '$po_num', 
                                            po_auto_id = '$po_unique_id', 
                                            po_date = '$po_date', 
                                            invoice_auto_id = '$invoice_auto_id', 
                                            invoice_no = '$invoice_no', 
                                            invoice_date = '$invoice_date', 
                                            consignee_unique_id = '$consignee_unique_id', 
                                            engineer_name = '$engineer_id',
                                            documents_type = '$documents_type', 
                                             documents_type1 = '$documents_type1', 
                                            documents_type2 = '$documents_type2', 
                                            dc_received_sts = '$dc_received_sts', 
                                            dc_cus_signed_date = '$dc_cus_signed_date', 
                                            ir_rec_status = '$ir_rec_status', 
                                            ir_cus_signed_date = '$ir_cus_signed_date', 
                                            snr_rec_status = '$snr_rec_status', 
                                            snr_cus_signed_date = '$snr_cus_signed_date', 
                                            dc_file = '$dc_file', 
                                            dc_original_name = '$dc_filename', 
                                            ir_file = '$ir_file_names', 
                                            ir_original_name = '$ir_file_org_names', 
                                            snr_file = '$snr_file_names,', 
                                            snr_original_name = '$snr_file_org_names',
                                        
                                            installation_date = '$installation_date' 
                                             
                                            WHERE form_unique_id = '$form_unique_id' AND dc_number='$dc_number'";

                    if (mysqli_query($conn1, $update_query_1)) {
                        echo json_encode(['status' => true, 'msg' => 'Update successful']);
                    } else {
                        echo json_encode(['status' => false, 'msg' => 'Error updating record', 'error' => mysqli_error($conn1)]);
                    }
                } else {

                    $generated_installation_id = ins_no_get();

                    if ($_POST['dc_file_data'] == '' || $_POST['dc_file_name'] == '') {
                        $dc_file = $file_names;
                        $dc_filename = $file_org_names;

                    } else {
                        $dc_file = $dc_file_data;  // Set a default value
                        $dc_filename = $dc_file_name;

                    }


                    if ($_POST['snr_file_data'] == "" || $_POST['snr_file_name'] == "") {
                        $snr_file = $snr_file_names;
                        $snr_filename = $snr_file_org_names;

                    } else {

                        $snr_file = $snr_file_data;
                        $snr_filename = $snr_file_name;

                    }
                  
                  $insert_query_1 = "INSERT INTO $table_inst_sublist 
                    (po_num, po_auto_id, po_date, invoice_auto_id, invoice_no, invoice_date, 
                    consignee_unique_id, engineer_name, installation_com_date, eng_remarks, 
                    documents_type,dc_received_sts, dc_cus_signed_date,documents_type1, ir_rec_status, ir_cus_signed_date,documents_type2, snr_rec_status, snr_cus_signed_date, dc_file, dc_original_name, ir_file,ir_original_name, snr_file, snr_original_name, po_form_unique_id, 
                    installation_date, unique_id, installation_id,form_unique_id,dc_number,acc_year, sess_user_type, sess_user_id, sess_company_id, sess_branch_id) 
                    VALUES 
                    ('$po_num', '$po_unique_id', '$po_date', '$invoice_auto_id', '$invoice_no', '$invoice_date','$consignee_unique_id', '$engineer_id', '$installation_com_date', '$eng_remarks',
                    '$documents_type', '$dc_received_sts', '$dc_cus_signed_date','$documents_type1', '$ir_rec_status', '$ir_cus_signed_date', '$documents_type2', '$snr_rec_status', '$snr_cus_signed_date', '$dc_file', '$dc_filename', '$ir_file_names',  '$ir_file_org_names','$snr_file', '$snr_filename', '$form_main_unique_id','$installation_date', '$generated_unique_id','$generated_installation_id','$form_unique_id','$dc_number','$acc_year',  '$sess_user_type', '$sess_user_id',  '$sess_company_id', '$sess_branch_id')";


                    if (mysqli_query($conn1, $insert_query_1)) {
                        echo json_encode([
                            'status' => true,
                            'msg' => 'Insert successful',
                        ]);
                    } else {
                        echo json_encode([
                            'status' => false,
                            'msg' => 'Error inserting record',
                            'error' => mysqli_error($conn1)
                        ]);
                    }
                }
            }

        } else {
            echo json_encode(['status' => false, 'msg' => 'Invalid input']);
        }
    }
}



function ins_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2); // Extract last two digits of the year
    $month = date("m");
    $datee = $st_date . $month;

    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('SERVICE_DB_PASSWORD');
    $database_name = "operation_team_beta";

    // Create MySQLi connection
    $conn = new mysqli($servername, $username, $password, $database_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the latest installation_id
    $query = "SELECT installation_id FROM installation_details_sublist WHERE installation_id LIKE 'INS%' ORDER BY unique_id DESC LIMIT 1";
    $result = $conn->query($query);

    $booking_no = '';

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pur_array = explode('-', $row['installation_id']);

        $year1 = $pur_array[1]; // Extract year part
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2]; // Extract last number
    }

    if ($booking_no == '' || $year != date("Y")) {
        $booking_nos = 'INS-' . $datee . '-0001';
    } else {
        $booking_no += 1;
        $booking_nos = 'INS-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }

    // Close the connection
    $conn->close();

    return $booking_nos;
}




function acc_year() {
    $acc_year   = '';
    $curr_year  = date("Y");
    
    $today      = strtotime(date("d-m-Y")); 
    $end_date   = strtotime("31-03-".$curr_year);
    $start_date = strtotime("01-04-".$curr_year);
    
    if ($today>=$start_date) {
        $next_year      = $curr_year + 1;
        $acc_year       = $curr_year."-".$next_year;
    }   
    else if ($today<=$end_date) {
        $previous_year  = $curr_year - 1;
        $acc_year       = $previous_year."-".$curr_year; 
    }

    return $acc_year;
    
}





?>


