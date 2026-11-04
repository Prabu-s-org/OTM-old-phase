<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = 'po_form';
$table_product_details = 'product_details_sub';
$table_consignee_details = 'consignee_details_sub';


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';
// File Upload Library Call

$fileUploadPath = $fileUploadConfig->get('upload_folder');

// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set('upload_folder', $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    'status'    => 0,
    'data'      => '',
    'error'     => 'Action Not Performed'
];
$json_array         = '';
$sql                = '';

$user_type          = '';
$is_active          = '';
$unique_id          = '';
$prefix             = '';

$data               = '';
$msg                = '';
$error              = '';
$status             = '';
$test               = '';
// For Developer Testing Purpose

switch ($action) {

    case 'createupdate':


        $po_num          = $_POST['po_num'];
        $po_date    = $_POST['po_date'];
        $department          = $_POST['department'];
        $gst_option          = $_POST['gst_option'];
        $gst_value          = $_POST['gst_value'];
        $executive_name    = $_POST['executive_name'];
        $bill_address          = $_POST['bill_address'];
        $contact_name          = $_POST['contact_name'];
        $contact_number          = $_POST['contact_number'];
        $email    = $_POST['email'];
        $district          = $_POST['district'];
        $pin          = $_POST['pin'];
        $po_prepared_by          = $_POST['po_prepared_by'];
        $po_type    = $_POST['po_type'];
        $no_of_po          = $_POST['no_of_po'];

        $no_of_consignee    = $_POST['no_of_consignee'];
        $unique_id          = $_POST['unique_id'];
        $m_unique_id = $_POST['m_unique_id'];
        $po_unique_id = $_POST['po_unique_id'];

        $po_unique_id = po_no_get();

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

        $update_where       = '';
        // print_r( $m_unique_id );
        $columns            = [
            'po_num'           => $po_num,
            'po_date'     => $po_date,
            'department'           => $department,
            'gst_option'           => $gst_option,
            'gst_value'     => $gst_value1,
            'executive_name'           => $executive_name,
            'bill_address'           => $bill_address,
            'contact_name'     => $contact_name,
            'contact_number'           => $contact_number,
            'email'           => $email,
            'district'     => $district,
            'pin'           => $pin,
            'po_prepared_by'           => $po_prepared_by,
            'po_type'     => $po_type,
            'no_of_po'           => $no_of_po,
            'no_of_consignee'           => $no_of_consignee,
            'po_unique_id' => $po_unique_id,
            'unique_id'           => $ids,   
        ];

         $table_details      = [
                    $table,
                    [
                        'COUNT(unique_id) AS count'
                    ]
                ];
            $select_where = 'is_delete = 0 AND po_num = "'.$po_num.'" AND contact_name ="'.$contact_name.'"';
            $action_obj1         = $pdo->select($table_details,$select_where);

            
            if ($action_obj1->status ) {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = '';
                $sql        = $action_obj1->sql;

            } else {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = $action_obj1->error;
                $sql        = $action_obj1->sql;
                $msg        = 'error';

            }
            // print_r($data[0]['count']);die();

        if($data[0]['count'] != 0) {
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where   = [
                    'unique_id'     => $unique_id
                ];
                // $update_where =  'unique_id ="'.$unique_id.'"';
                $action_obj     = $pdo->update($table, $columns, $update_where);
                // Update Ends
            }
        }else if(($data[0]['count']== 0)) {
 
        // Update Begins
        
            // Insert Begins
            $action_obj     = $pdo->insert($table, $columns);
            // Insert Ends
        }

        if ($action_obj->status) {

            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = 'update';
            } else {
                $msg        = 'create';
            }
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
         // print_r($data[0]['count']);die();
//          if ($unique_id) {
//             unset($columns['unique_id']);
//             $update_where   = [
//                 'unique_id'     => $unique_id
//             ];
//             // $update_where =  'unique_id ="'.$unique_id.'"';
//             $action_obj     = $pdo->update($table, $columns, $update_where);
//             // Update Ends
//         }
//         // print_r($data[0]['count']);
//         if ($data[0]['count']) {
//             $msg        = 'already';
//         }
//         else if (($data[0]['count'] == 0) && ($msg != 'error')) {


//     // if($data[0]['count'] != 0) {
       
   
//         $action_obj     = $pdo->insert($table, $columns);
//         // Insert Ends
//         // }
//     // print_r($action_obj);
//     if ($action_obj->status) {
//         $status     = $action_obj->status;
//         $data       = $action_obj->data;
//         $error      = '';
//         $sql        = $action_obj->sql;

//         if ($unique_id) {
//             $msg        = 'update';
//         } else {
//             $msg        = 'create';
//         }
//     } else {
//         $status     = $action_obj->status;
//         $data       = $action_obj->data;
//         $error      = $action_obj->error;
//         $sql        = $action_obj->sql;
//         $msg        = 'error';
//     }
// }

        // }
        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql
        ];

        echo json_encode($json_array);

        break;

        case "get_item_name":

            $item_code   = $_POST["item_code"];
    
            $details    = [
                "item_description"          => "",
                "rc_unit_price"           => "",
                "gst"           => ""
                
            ];
    $items_where='unique_id="'.$item_code.'"';
            // if ($item_code) {
                // $items_where = [
                //     "unique_id" => $item_code
                // ];
    // print_r($items_where);die();
                $items__columns = [
                    "item_description",
                    "rc_unit_price",
                    "gst"
                    
                ];
    
                $items__table_details = [
                    "item_creation_sub",
                    $items__columns
                ];
    
                $items__details = $pdo->select($items__table_details,$items_where);
                // print_r($items__details);
    
                if ($items__details->status) {
                    if (!empty($items__details->data)) {
                        $details = $items__details->data[0];
                    }
                } else {
                    print_r($items__details);
                }
            // }
    
            echo json_encode($details);
    
            break;

            case 'item_code_option':

                $tender_code         = $_POST['tender_code'];
        
                $item_code_options  = item_name($tender_code);
        
                $item_code_options  = select_option($item_code_options,"Select Item Code");
                // print_r($item_code_options);
        
                echo $item_code_options;
                
                break;
                
    case 'terms_condition':

        $delivery_due_dates          = $_POST['delivery_due_dates'];
        $ld_per_day          = $_POST['ld_per_day'];
        $ld_maximum_val    = $_POST['ld_maximum_val'];
        $warranty          = $_POST['warranty'];
        $warranty_duration    = $_POST['warranty_duration'];
        $ins_reqired          = $_POST['ins_reqired'];
        $bank_required          = $_POST['bank_required'];
        $dc_required          = $_POST['dc_required'];
        $bg          = $_POST['bg'];
        $bg_month    = $_POST['bg_month'];
        $demo    = $_POST['demo'];
        
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['po_file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            $tem_name = random_strings(25) . '.pdf';

            move_uploaded_file($_FILES['po_file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);

            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['po_file']['name'];
        }
// print_r($file_names);die();
        $update_where       = '';
        // print_r( $m_unique_id );
        if (($file_names) && ($file_org_names)) {
            $columns            = [

                'delivery_due_dates'           => $delivery_due_dates,
                'ld_per_day'     => $ld_per_day,
                'ld_maximum_val'           => $ld_maximum_val,
                'warranty'           => $warranty,
                'warranty_duration'     => $warranty_duration,
                'ins_reqired'           => $ins_reqired,
                'bank_required'           => $bank_required,
                'dc_required'           => $dc_required,
                'bg'     => $bg,
                'bg_month'           => $bg_month,
                'file_name'           => $file_names,
                'file_org_name'           => $file_org_names


            ];
        } else {
            $columns            = [

                'delivery_due_dates'           => $delivery_due_dates,
                'ld_per_day'     => $ld_per_day,
                'ld_maximum_val'           => $ld_maximum_val,
                'warranty'           => $warranty,
                'warranty_duration'     => $warranty_duration,
                'ins_reqired'           => $ins_reqired,
                'bank_required'           => $bank_required,
                'dc_required'           => $dc_required,
                'bg'     => $bg,
                'bg_month'           => $bg_month,


            ];
        }
        // Update Begins
        if ($demo) {

            // unset( $columns['unique_id'] );

            // $update_where   = [
            //     'po_unique_id'     => $demo
            // ];
            $update_where  = 'unique_id ="' . $demo . '"';

            $action_obj     = $pdo->update($table, $columns, $update_where);

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
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;

            if ($demo) {
                $msg        = 'update';
            } else {
                $msg        = 'create';
            }
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

    case 'department_cu':
        $department = $_POST["department"];

        $is_active          = $_POST["is_active1"];
        $unique_id          = $_POST["unique_id"];

        $update_where       = "";
        $table_department = 'department_creation';
        $columns            = [
            "department" => $department,
            "is_active"           => $is_active,
            "unique_id"           => $unique_id
        ];
        $table_details      = [
            $table_department,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND department ="' . $department . '"';


        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
        if ($data[0]['count']) {
            $msg        = 'already';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {

            // Insert Begins

            $action_obj     = $pdo->insert($table_department, $columns);
            // Insert Ends


            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;

                // if ($unique_id) {
                //     $msg        = "update";
                // } else {
                $msg        = "create";
                // }
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
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



        // product count
    case 'check_count':

        $uni_id          = $_POST["uni_id"];

        $update_where       = "";

        $columns            = [];

        $table_details      = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
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
        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;

        // consignee count
        // product count
    case 'consignee_check_count':

        $uni_id          = $_POST["uni_id"];

        $update_where       = "";

        $columns            = [];

        $table_details      = [
            "consignee_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
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
        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;

        // check consignee count
    case 'no_of_consignee':

        $uni_id          = $_POST["uni_id"];

        $update_where       = "";

        $columns            = [

            "no_of_consignee"
        ];

        $table_details      = [
            "po_form",
            $columns
        ];
        $select_where       = ' is_delete = 0 AND unique_id ="' . $uni_id . '"';


        $result         = $pdo->select($table_details, $select_where);
        // print_r($result);

        $total_records  = total_records();

        if ($result->status) {
            $s_no = 0;
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $stored_consignee = $value['no_of_consignee'];
            }
        }
        $data = array($stored_consignee);

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'check_consignee':

        $uni_id          = $_POST["uni_id"];

        $update_where       = "";

        $columns            = [];

        $table_details      = [
            "consignee_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
        $data = array($data[0]['count']);
        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;




        // end

    case 'check_product':

        $uni_id          = $_POST["uni_id"];

        $update_where       = "";

        $columns            = [];

        $table_details      = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';


        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
        $data = array($data[0]['count']);
        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;

        // check item count
    case 'no_of_item':

        $uni_id          = $_POST["uni_id"];

        $columns            = [
            "no_of_po"
        ];

        $table_details      = [
            "po_form",
            $columns
        ];
        $select_where       = ' is_delete = 0 AND unique_id ="' . $uni_id . '"';


        $result         = $pdo->select($table_details, $select_where);
        // print_r($result);die();

        $total_records  = total_records();

        if ($result->status) {
            $s_no = 0;
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $stored_consignee = $value['no_of_po'];
            }
        }
        $data = array($stored_consignee);

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;


        case 'datatable':
            // DataTable Variables
            $search      = $_POST['search']['value'];
            $length      = $_POST['length'];
            $start          = $_POST['start'];
            $draw          = $_POST['draw'];
            $limit          = $length;
    
            $data        = [];
            $month_fill         = $_POST["month_fill"];
            // echo $month_fill;
            $month_val = date("F/Y", strtotime($month_fill));
    
            // $date_format = strtotime($month_val);
            
            // $new_date = date("Y-m",$date_format);
            
            $date = new DateTime($month_fill);
    
    
    $date->modify('-1 month');
    
    
    $dec_date = $date->format('Y-m');
    
           
            if ($length == '-1') {
                $limit  = '';
            }

            $table_po="view_po_form_list";
            // Query Variables
            $json_array     = '';
            $columns        = [
                "'' as  s_no",
                'po_num',
                "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                // '',
                '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_po.'.department ) AS department',
                'gst_value',
                '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id ='.$table_po .'.executive_name ) AS executive_name',
                // '(SELECT sum(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS total_value ',
                'ROUND((SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  and dis.is_delete=0), 2) AS total_value',
               
                'file_name',
                '(SELECT count(po_unique_id) as po_count FROM invoice_creation AS inv WHERE inv.po_unique_id = '.$table_po.'.unique_id AND inv.is_delete=0) AS po_count',
                'unique_id',
                // '(SELECT form_main_unique_id FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS con_form_main_unique_id',
                '(SELECT count(form_main_unique_id) as cnt FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id AND  dis.is_delete=0 ) AS cnt',
                '(SELECT count(form_main_unique_id) as cnt FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  AND dis.is_delete=0) AS cnt1',
                '(SELECT count(form_main_unique_id) as cnt FROM po_product_assign_details AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id AND dis.is_delete=0) AS cnt2',
                "delivery_due_dates",
                
            ];
            $table_details  = [
                $table_po,
                $columns
            ];
            
    
            $where = " is_delete = '0'";
           
            // $dec_date = $date->format('Y-m');
            if($month_fill != ''){
                $where = "DATE_FORMAT(po_date, '%Y-%m') LIKE '%".$month_fill."%'";
            }
            if ($_POST['from_date'] == '') {
                $from_date = '';
            } else {
                $from_date = $_POST['from_date'];
            }
            if ($_POST['to_date'] == '') {
                $to_date = '';
            } else {
                $to_date = $_POST['to_date'];
    
                // $where .= "DATE_FORMAT(po_date, '%Y-%m-%d') >= '" . $from_date . "' AND DATE_FORMAT(po_date, '%Y-%m-%d') <= '" . $to_date . "' ";
    
            }
            if ($from_date || $to_date != '') {
    
                $where .= " AND po_date>= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
                // $where = "po_date >= '" . $from_date . "' po_date <= '" . $to_date . "'  ";
    
            }
            // $order_by ="id desc";
            $order_column   = $_POST['order'][0]['column'];
            $order_dir      = $_POST['order'][0]['dir'];
    
            // Datatable Ordering
            $order_by       = datatable_sorting_po($order_column, $order_dir, $columns);

            // $order_by = "unique_id $order_dir";
            // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
         
          

    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
           
            if ($search) {
                if ($where) {
                    $where .= 'AND ';
                }
    
                $where .= $search;
            }
    
            $sql_function   = 'SQL_CALC_FOUND_ROWS';
            // $result= $pdo->select($table_details, $where, $limit, $start, 'po_num DESC,'. $order_by, $sql_function);
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
                    // $value['state_name'] = disname( $value['state_name'] );
                    $po_num= $value['po_num'];
                    $total_value         = $value['total_value'];
                    $value['total_value']  = moneyFormatIndia(($total_value));
                    $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                    // echo $value['cnt'];
                    if($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['delivery_due_dates']=='' || $value['file_name']==''){
                        $value['po_num']='<span style="color:#da1c34;"
                        >'.$po_num.'</span>';
                        // echo "cnt: " . $value['cnt'] . ", cnt1: " . $value['cnt1'] . ", cnt2: " . $value['cnt2'];
            
                        // $value['po_num'] = '<span style="color:red">'.$po_num.'</span>';
                    }else{
                        $value['po_num'] = $po_num;
                    }
                    // $value['po_num']='<span style="color:#da1c34;"
                    //     ></span>';
    
                    $gst_value= $value['gst_value'];
                    if($gst_value==''){
                        $value['gst_value']="Unregistered";
                    }
                   
                   
                    $file_name =  $value['file_name'];
                    $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                    
                    
                    $value['is_active'] = is_active_show($value['is_active']);
                    // $orgDate = $value['po_date'];  
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));  
    
                    // $where_1      = [
                    //     "form_main_unique_id" => $value['unique_id']
                    // ];
                    $where_1="form_main_unique_id='".$value['unique_id']."'";
                    // ORDER BY unique_id DESC
            
                    $table_1      =  "stock_position_main";
            
                    $columns_1    = [
                        'COUNT(form_main_unique_id) AS count'
                    ];
            
                    $table_details_1   = [
                        $table_1,
                        $columns_1
                    ];
            
                    $result_values_12  = $pdo->select($table_details_1, $where_1);
                    // print_r($result_values_12);die();
                    $data_st       = $result_values_12->data;
                    $btn_update         = btn_update($folder_name, $value['unique_id']);
                    $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                    // $btn_view           = btn_view1($folder_name, $value['unique_id'] );



                    // if ($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] != "5f97fc3257f2525529") {
                        $value['po_count'] = '<a href="index.php?file=po_form/po_cancel&unique_id=' . $value['unique_id'] . '"><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2">Cancel</button></a>';
                    // }else if ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] != "65efd97b4df4040205") {
                    //     $value['po_count'] = '<a href="index.php?file=po_form/po_cancel&unique_id=' . $value['unique_id'] . '"><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2">Cancel</button></a>';
                    // }else{
                    //     $value['po_count'] = '<p style="color:red;">This Po already Invoiced </p>';
                    // }
                    
                  if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($data_st[0]['count']){
                        $value['unique_id'] = "";
                      }else{
                        $value['unique_id'] = $btn_update . $btn_delete;
                      }
                    
                  }
                  if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                    $value['unique_id'] = $btn_update . $btn_delete;
                  }
    
                    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    'draw'                => intval($draw),
                    'recordsTotal'         => intval($total_records),
                    'recordsFiltered'     => intval($total_records),
                    'data'                 => $data,
                    'testing'            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;
            
            case 'delete':

        $unique_id      = $_POST['unique_id'];
        $columns        = [
            'is_delete'   => 1
        ];

        $update_where   = [
            'unique_id'     => $unique_id
        ];

        $table_details      = [
            "stock_position",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where = 'is_delete = 0 AND form_main_unique_id ="' . $unique_id . '"';

        $action_obj         = $pdo->select($table_details, $select_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }

        if ($data[0]['count']) {
            $msg = 'stock';
        } else if (($data[0]['count'] == 0) && ($msg != 'error')) {
            $action_data     = $pdo->update($table, $columns, $update_where);

            if ($action_data->status) {
                $status     = $action_data->status;
                $data       = $action_data->data;
                $error      = '';
                $sql        = $action_data->sql;
                $msg        = 'success_delete';
            } else {
                $status     = $action_data->status;
                $data       = $action_data->data;
                $error      = $action_data->error;
                $sql        = $action_data->sql;
                $msg        = 'error';
            }
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

        //  case 'user_type_options':

        // $user_type          = $_POST['user_type'];

        // $user_type_options  = under_user_type( $user_type );

        // $user_type_options  = select_option( $user_type_options, 'Select' );

        // echo $user_type_options;

        // break;
        // product details

    case 'product_details_add_update':
        $no_of_items          = $_POST['no_of_po'];
      $tender_code          = $_POST['tender_code'];

        $item_code          = $_POST['item_code'];
       $po_name              = $_POST['po_name'];
        $qty            = $_POST['qty'];
        $unit_price     = $_POST['unit_price'];
        $tax         = $_POST['tax'];
        $total_value            = $_POST['total_value'];
        $net_value              = $_POST['net_value'];
        $form_main_unique_id       = $_POST['form_main_unique_id'];

        $unique_id             = $_POST['unique_id'];
        $update_where          = '';
        // print_r( 'hii'.$po_name );
        $columns            = [
           'tender_code'     => $tender_code,
            'item_code'        => $item_code,
            'product'           => $po_name,
            'qty'                   => $qty,
            'unit_price'                 => $unit_price,
            'tax'          => $tax,
            'total_value'              => $total_value,
            'net_value'             => $net_value,
            'no_of_items'             => $no_of_items,
            'form_main_unique_id'   => $form_main_unique_id,
            // 'rem_qty'                   => $qty,
            'unique_id'              => unique_id($prefix)
        ];

          // check already Exist Or not
          $table_details      = [
            $table_product_details,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND product ="' . $po_name . '" AND unique_id ="' . $unique_id . '" ';

        // When Update Check without current id
        // if ( $unique_id ) {
        //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        // }

        $action_obj         = $pdo->select($table_details, $select_where);
        // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
       
        //  else if (($data[0]['count'] == 0) && ($msg != 'error')) {
            // Update Begins
            if ($unique_id) {

                unset($columns['unique_id']);

                $update_where   = [
                    'unique_id'     => $unique_id
                ];

                $action_obj     = $pdo->update($table_product_details, $columns, $update_where);

                // Update Ends
            }
           if($data[0]['count'] != 0) {
                $msg        = 'already';
            } 
            else if (($data[0]['count'] == 0) && ($msg != 'error')) {

                $table_details1      = [
                    'product_details_sub',
                    [
                        'COUNT(form_main_unique_id) AS count'
                    ]
                ];
                $count_where       = ' is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

                $total_record        = $pdo->select($table_details1, $count_where);
                // print_r( $total_record );

                $data_record       = $total_record->data;

                if ($data_record[0]['count'] == $_POST['no_of_po']) {
                    $msg        = 'product';
                } else {
                    // Insert Begins
                    $action_obj     = $pdo->insert($table_product_details, $columns);
                    $msg        = 'add';
                    // Insert Ends

                }
// print_r( $action_obj );
                // Insert Ends

            }
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = '';
                $sql        = $action_obj->sql;
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = 'error';
            }
        // }

        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'product_details_datatable':

        // Function Name button prefix
        $btn_edit_delete    = 'product_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search      = $_POST['search']['value'];

        $length      = $_POST['length'];
        $start          = $_POST['start'];
        $draw          = $_POST['draw'];
        $limit          = $length;

        $data        = [];

        if ($length == '-1') {
            $limit  = '';
        }

        // Query Variables
        $json_array     = '';
        $columns        = [
            '@a:=@a+1 s_no',
            'tender_code',
            "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details.item_code)as item_code",
             'product',
            'qty',
            'unit_price',
            'tax',
            'net_value',
            'total_value',
            'unique_id',
            'form_main_unique_id'
        ];

        $table_details  = [
            $table_product_details . ' , (SELECT @a:= ' . $start . ') AS a ',
            $columns
        ];
        //     $where          = [
        //         'is_active'                     => 1,
        //         'is_delete'                     => 0
        //    ];

        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

        // if ( $form_main_unique_id != '' ) {
        // $where = [];
        // $where = ['form_main_unique_id'    => $form_main_unique_id,];
        // }
        $order_by = '';

        $sql_function   = 'SQL_CALC_FOUND_ROWS';

        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {

                $where_1      = [
                    "form_main_unique_id" => $value['unique_id']
                ];
        
                $table_1      =  "stock_position_main";
        
                $columns_1    = [
                    'COUNT(form_main_unique_id) AS count'
                ];
        
                $table_details_1   = [
                    $table_1,
                    $columns_1
                ];
        
                $result_values_12  = $pdo->select($table_details_1, $where_1);
                // print_r($result_values_12);die();
                $data_st       = $result_values_12->data;

                $btn_edit               = btn_edit($btn_edit_delete, $value['unique_id']);
                $btn_delete             = btn_delete($btn_edit_delete, $value['unique_id']);

                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($data_st[0]['count']){
                        $value['unique_id'] = "";
                      }else{
                        $value['unique_id']     =  $btn_edit  . $btn_delete;
                    }
                    
                }
                if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                    $value['unique_id']     =  $btn_edit  . $btn_delete;
                }
               
                $data[]                 = array_values($value);
            }

            $json_array = [
                'draw'                => intval($draw),
                'recordsTotal'         => intval($total_records),
                'recordsFiltered'     => intval($total_records),
                'data'                 => $data,
                'testing'            => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;



    case 'product_details_edit':
        // Fetch Data
        $unique_id  = $_POST['unique_id'];
        $data        = [];

        // Query Variables
        $json_array     = '';
        $columns        = [
            // '@a:=@a+1 s_no',
           'tender_code',
           "(select item_code from item_creation_Sub where item_creation_Sub.unique_id=$table_product_details.item_code) as item_code",
            // 'item_code',
            'product',
            'qty',
            'unit_price',
            'tax',
            'total_value',
            'net_value',
            'unique_id'
        ];
        $table_details  = [
            $table_product_details,
            $columns
        ];
        $where          = [
            'unique_id'    => $unique_id,
            'is_active'    => 1,
            'is_delete'    => 0
        ];

        $result         = $pdo->select($table_details, $where);
        // print_r($result);

        if ($result->status) {

            $json_array = [
                'data'         => $result->data[0],
                'status'    => $result->status,
                'sql'       => $result->sql,
                'error'     => $result->error,
                'testing'    => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'product_details_delete':

        $unique_id  = $_POST['unique_id'];

        $columns            = [
            'is_delete'   => 1,
        ];

        $update_where   = [
            'unique_id'     => $unique_id
        ];

        $action_obj     = $pdo->update($table_product_details, $columns, $update_where);

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

        // Consignee sublist

    case 'consignee_details_add_update':

        $no_of_consignee          = $_POST['no_of_consignee'];
        // $con_qty              = $_POST['con_qty'];
        $con_address            = $_POST['con_address'];
        $con_district     = $_POST['con_district'];
        $con_pincode         = $_POST['con_pincode'];
        $con_contact_name            = $_POST['con_contact_name'];
        $con_contact_number              = $_POST['con_contact_number'];
        $con_lan_num              = $_POST['con_lan_num'];
        $form_main_unique_id       = $_POST['form_main_unique_id'];

        $unique_id             = $_POST['unique_id'];
        $update_where          = '';
        // print_r( 'hii'.$con_con_address );
        $columns            = [
            'no_of_consignee'        => $no_of_consignee,
            // 'con_qty'           => $con_qty,
            'con_address'                   => $con_address,
            'con_district'                 => $con_district,
            'con_pincode'             => $con_pincode,
            'con_contact_name'              => $con_contact_name,
            'con_contact_number'             => $con_contact_number,
            'con_lan_num'             => $con_lan_num,
            'form_main_unique_id'   => $form_main_unique_id,
            'unique_id'              => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details      = [
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

        $select_where       = ' is_delete = 0 AND con_address ="'.$con_address .'"  AND form_main_unique_id ="' .$form_main_unique_id . '"';
        // AND con_address ="'.$con_address .'"  and form_main_unique_id ="' . $form_main_unique_id . '"
        //  


        $action_obj         = $pdo->select($table_details, $select_where);
        // // print_r( $action_obj );
        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
        
            // Update Begins
            if ($unique_id) {

                unset($columns['unique_id']);

                $update_where   = [
                    'unique_id'     => $unique_id
                ];

            $action_obj     = $pdo->update($table_consignee_details, $columns, $update_where);
                // print_R($action_obj );die();
                // Update Ends
            }
            if ($data[0]['count']) {
                $msg        = 'already';
            }
            else if (($data[0]['count'] == 0) && ($msg != 'error')) {
            // else{
                $table_details1      = [
                    'consignee_details_sub',
                    [
                        'COUNT(form_main_unique_id) AS count'
                    ]
                ];
                $count_where       = 'is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';

                // print_r( $form_main_unique_id_count );
                // When Update Check without current iassign_qty
                // if ( $unique_id ) {
                //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
                // }

                $total_record        = $pdo->select($table_details1, $count_where);
                // print_r( $total_record );

                $data_record       = $total_record->data;

                if ($data_record[0]['count'] == $_POST['no_of_consignee']) {
                    $msg        = 'e_already';
                } else {
                    // Insert Begins
                    $action_obj     = $pdo->insert($table_consignee_details, $columns);
                    $msg        = 'add';
                    // Insert Ends

                }
            }

            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = '';
                $sql        = $action_obj->sql;
                if ($unique_id) {
                    $msg        = "update";
                } else {
                    $msg        = "add";
                }

            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = 'error';
            }
        // }

        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql

        ];

        echo json_encode($json_array);

        break;







    case 'consignee_details_datatable':
        // Function Name button prefix
        $btn_edit_delete    = 'consignee_details';

        // Fetch Data
        $form_main_unique_id = $_POST['form_main_unique_id'];

        // DataTable
        $search      = $_POST['search']['value'];

        $length      = $_POST['length'];
        $start          = $_POST['start'];
        $draw          = $_POST['draw'];
        $limit          = $length;

        $data        = [];

        if ($length == '-1') {
            $limit  = '';
        }

        // Query Variables
        $json_array     = '';
        $columns        = [
            '@a:=@a+1 s_no',
            // 'no_of_consignee',
            // 'con_qty',
            'con_address',
            // "con_district",
            "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
            'con_pincode',
            'con_contact_name',
            'con_contact_number',
            "con_lan_num",
            'unique_id'
        ];
        $table_details  = [
            $table_consignee_details . ' , (SELECT @a:= ' . $start . ') AS a ',
            $columns
        ];
        $where          = [
            'is_active'                     => 1,
            'is_delete'                     => 0,
        ];

        // $where = [];
        $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="' . $form_main_unique_id . '" ';
        $order_by = '';

        $sql_function   = 'SQL_CALC_FOUND_ROWS';

        $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {

                $btn_edit               = btn_edit($btn_edit_delete, $value['unique_id']);
                $btn_delete             = btn_delete($btn_edit_delete, $value['unique_id']);

                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($data_st[0]['count']){
                        $value['unique_id'] = "";
                      }else{
                        $value['unique_id']     =  $btn_edit  . $btn_delete;
                    }
                    
                }
                if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                    $value['unique_id']     =  $btn_edit  . $btn_delete;
                }
                $data[]                 = array_values($value);
            }

            $json_array = [
                'draw'                => intval($draw),
                'recordsTotal'         => intval($total_records),
                'recordsFiltered'     => intval($total_records),
                'data'                 => $data,
                'testing'            => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;



    case 'consignee_details_edit':
        // Fetch Data
        $unique_id  = $_POST['unique_id'];
        $data        = [];

        // Query Variables
        $json_array     = '';
        $columns        = [
            'con_address',
            "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
            'con_pincode',
            'con_contact_name',
            'con_contact_number',
            "con_lan_num",
            'unique_id'
        ];
        $table_details  = [
            $table_consignee_details,
            $columns
        ];
        $where          = [
            'unique_id'    => $unique_id,
            'is_active'    => 1,
            'is_delete'    => 0
        ];

        $result         = $pdo->select($table_details, $where);
// print_r($result);
        if ($result->status) {

            $json_array = [
                'data'         => $result->data[0],
                'status'    => $result->status,
                'sql'       => $result->sql,
                'error'     => $result->error,
                'testing'    => $result->sql
            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;



    case 'consignee_details_delete':

        $unique_id  = $_POST['unique_id'];

        $columns            = [
            'is_delete'   => 1,
        ];

        $update_where   = [
            'unique_id'     => $unique_id
        ];

        $action_obj     = $pdo->update($table_consignee_details, $columns, $update_where);

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

    case 'po_delivery_add_update':

        $main_unique_id          = $_POST['main_unique_id'];
        $con_unique_id    = $_POST['con_unique_id'];
        $con_name          = $_POST['con_name'];
        $con_contact_no          = $_POST['con_contact_no'];
        $item_code    = $_POST['item_code'];
        $item_name          = $_POST['item_name'];
        $bill_qty          = $_POST['bill_qty'];
        $qty          = $_POST['qty'];
        $unit_price    = $_POST['unit_price'];
        $item_tax          = $_POST['item_tax'];
        $unique_id          = $_POST['unique_id'];
        $po_unique_id       = $_POST['po_unique_id'];
        $product_unique_id_val = $_POST['product_unique_id_val'];
        // $rem_qty          = $_POST['rem_qty'];
        // $po_product_assign_id = po_no_get();

        $update_where       = '';


        

        $columns            = [
            'form_main_unique_id'           => $main_unique_id,
            'con_unique_id'     => $con_unique_id,
            'con_name'           => $con_name,
            'con_contact_no'     => $con_contact_no,
            'item_code'           => $item_code,
            'product'     => $item_name,
            'assign_qty'           => $bill_qty,
            'qty'           => $qty,
            'unit_price'     => $unit_price,
            'item_tax'           => $item_tax,
            'po_unique_id'  => $po_unique_id,
            'product_unique_id'  => $product_unique_id_val,

            // 'rem_qty'  => $rem_qty,
            // 'po_product_assign_id'  =>$po_product_assign_id,
            'is_active'           => 1,
            'unique_id'           => unique_id($prefix)
        ];



        $po_product_assign_details = 'po_product_assign_details';

        $columns1 = [
            'form_main_unique_id',
            ];
                $table_details1      = [
                $po_product_assign_details,
                [
                    'COUNT(unique_id) AS count',
                    'form_main_unique_id',
                    
                ],
        
            ];
            $select_where       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."' AND con_unique_id = '".$con_unique_id."' AND product_unique_id = '".$product_unique_id_val."'";

    
            $action_obj1         = $pdo->select($table_details1,$select_where );

            if ($action_obj1->status) {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = '';
                $sql        = $action_obj1->sql;
        
            } else {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = $action_obj1->error;
                $sql        = $action_obj1->sql;
                $msg        = 'error';
        
            }
            // print_r($data[0]['count']);die();
            if ($data[0]['count'] != 0) {
                $update_where='form_main_unique_id="'.$main_unique_id.'" and con_unique_id="'.$con_unique_id.'" AND product_unique_id = "'.$product_unique_id_val.'"';

                // print_r($update_where);die();
                $action_obj     = $pdo->update($po_product_assign_details, $columns, $update_where);

                // Update Ends
            }
       
            else {
                    // Insert Begins
            $action_obj     = $pdo->insert($po_product_assign_details, $columns);
            // $msg        = 'add';
            // Insert Ends
            }

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = 'update';
            } else {
                $msg        = 'create';
            }
           
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = 'error';
        }
    // }
        $json_array   = [
            'status'    => $status,
            'data'      => $data,
            'error'     => $error,
            'msg'       => $msg,
            'sql'       => $sql
        ];

        echo json_encode($json_array);

        break;

        case 'check_status':

            $bill_qty_val  = $_POST['bill_qty_val'];
            $item_qty  = $_POST['qty'];
            $main_unique_id  = $_POST['main_unique_id'];
            $product_unique_id  = $_POST['product_unique_id'];
            $con_unique_id  = $_POST['con_unique_id'];
            $con_s_no  = $_POST['con_s_no'];
            // $arr = array($con_s_no);

            // if($bill_qty_val != ''){

            $product_details = 'product_details_sub';
                $column =[
                    'unique_id',
                    'product',
                    'qty',
                    'rem_qty',
                    'assign_qty',
                    'con_serial_no',
                    'assign_int_val'
                ];


            $table_details12      = [
                $product_details,
                $column,        
            ];
            $select_where12       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."' AND unique_id = '".$product_unique_id."'";

            // if($con_s_no){
            //     $select_where12       .= " AND con_serial_no IN ('".$con_s_no."')";

            // }

            $action_obj12         = $pdo->select($table_details12,$select_where12 );

            // print_r($action_obj12);die();            

            if ($action_obj12->status) {
                $status     = $action_obj12->status;
                $data       = $action_obj12->data;
                $error      = '';
                $sql        = $action_obj12->sql;
        
            } else {
                $status     = $action_obj12->status;
                $data       = $action_obj12->data;
                $error      = $action_obj12->error;
                $sql        = $action_obj12->sql;
                $msg        = 'error';
        
            }
            // print_r($bill_qty_val);die();
            
            
                if($data[0]['unique_id'] == $product_unique_id){
                    if($data[0]['rem_qty'] == '' || $data[0]['rem_qty'] == 0 && $data[0]['assign_qty'] == '' || $data[0]['assign_qty'] == 0){
                        if($data[0]['qty'] >= $bill_qty_val){
                            
                                    $data1 = $data[0]['qty'] - $bill_qty_val;
                                $assign_qty = $bill_qty_val;
                                if($data[0]['con_serial_no'] != ''){
                                    $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                                }else{
                                    $con_ser_no = $con_s_no;
                                }
                                
                                if($data[0]['assign_int_val'] != ''){
                                    $bill_val = $data[0]['assign_int_val'].','.$bill_qty_val.'-'.$con_s_no;
                                }else{
                                    $bill_val = $bill_qty_val.'-'.$con_s_no;
                                }
                                // $con_ser_no = implode(",",$arr);

                                $table_po_details = 'product_details_sub';
                
                                $columns12            = [
                                    "rem_qty"     => $data1,
                                    "assign_qty" => $bill_qty_val,
                                    "assign_int_val" => $bill_val,
                                    "con_serial_no"  => $con_ser_no
                                ];
                                $update_where12       = "form_main_unique_id = '".$main_unique_id."' AND unique_id= '".$product_unique_id."'";
                        
                                $action_obj_update     = $pdo->update($table_po_details,$columns12,$update_where12);
                                $msg = 'available';
                        }else{
                            $data1 = $data[0]['qty'] - $bill_qty_val;
                            $msg = 'unavailable';
                        }
                    }
                }

            // if($data[0]['con_count'] != 0 || $data[0]['con_serial_no'] != $con_s_no){

                if($data[0]['rem_qty'] != '' && $data[0]['assign_qty'] != ''){
                    
                    if($data[0]['rem_qty'] >= $bill_qty_val){
                   
                        $product_details_po = 'product_details_sub';
                        $column_po =[
                            'unique_id', 
                            'product', 
                            'qty', 
                            'rem_qty', 
                            'assign_qty', 
                            'con_serial_no',
                            'assign_int_val',
                            // '(SUBSTRING_INDEX(SUBSTRING_INDEX(assign_int_val, ',', 1), ',', -1)) AS assign_int_val', 
                            'COUNT(con_serial_no) AS con_count'
                        ];
        
                        $table_details12_po      = [
                            $product_details_po,
                            $column_po,        
                        ];
            
                        $select_where12_po       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."' AND unique_id = '".$product_unique_id."'";
                        // AND con_serial_no LIKE '$con_s_no,%'
                        if($con_s_no){
                            $select_where12_po       .= " AND FIND_IN_SET('$con_s_no',con_serial_no)>0";
                        }
                    
                        $po_action         = $pdo->select($table_details12_po,$select_where12_po );

                    // print_r($po_action);die();
                        if ($po_action->status) {
                            $status     = $po_action->status;
                            $data_po       = $po_action->data;
                            $error      = '';
                            $sql        = $po_action->sql;
                    
                        } else {
                            $status     = $po_action->status;
                            $data_po       = $po_action->data;
                            $error      = $po_action->error;
                            $sql        = $po_action->sql;
                            $msg        = 'error';
                    
                        }
                        // $data_po[0]['con_serial_no'] == $con_s_no && 
                        if($data_po[0]['con_count'] != 0){


                            $product_details_po = 'product_details_sub';
                            $column_po1 =[
                                
                                'qty', 
                                'rem_qty', 
                                'assign_qty', 
                                'con_serial_no',
                                'assign_int_val',
                                'COUNT(con_serial_no) AS con_count'
                            ];
            
                            $table_details12_po1      = [
                                $product_details_po,
                                $column_po1,        
                            ];
                
                            $select_where12_po1       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."' AND unique_id = '".$product_unique_id."'";
                            // AND con_serial_no LIKE '$con_s_no,%'
                            if($con_s_no){
                                $select_where12_po1       .= " AND con_serial_no IN (".$con_s_no.")";
                            }
                            // con_serial_no IN ('".$con_s_no."')";
                            // FIND_IN_SET('$con_s_no',con_serial_no)>0";
                        
                            $po_action1         = $pdo->select($table_details12_po1,$select_where12_po1 );

                            // print_r($po_action1);die();

                                $data1 = $data[0]['qty'] - $bill_qty_val;
                                
                                // $check_assqty = $data[0]['assign_qty'] - $bill_qty_val;
                                // $assign_qty = $bill_qty_val;
                                $assign_qty1 = $data1 - $data[0]['assign_qty'];

                                // $data12 = $data[0]['qty'] - $assign_qty1;
                                // print_r($data1.','.$assign_qty1.','.$data12);die();

                                // $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                                // if($data[0]['con_serial_no'] != ''){
                                //     $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                                // }else{
                                //     $con_ser_no = $con_s_no;
                                // }
                
                                // if($data[0]['assign_int_val'] != ''){
                                //     $bill_val = $data[0]['assign_int_val'].','.$bill_qty_val;
                                // }else{
                                //     $bill_val = $bill_qty_val;
                                // }

                                $table_po_details = 'product_details_sub';
                
                                $columns12            = [
                                    "rem_qty"     => $data1,
                                    "assign_qty" => $assign_qty1,
                                    // "assign_int_val" => $bill_val,
                                    // "con_serial_no"  => $con_ser_no
                                ];
                                $update_where12       = "form_main_unique_id = '".$main_unique_id."' AND unique_id= '".$product_unique_id."'";
                        
                                $action_obj_update     = $pdo->update($table_po_details,$columns12,$update_where12);
                                $msg = 'available';
                        }
                        // $data_po[0]['con_serial_no'] != $con_s_no && 
                        else if($data_po[0]['con_count'] == 0){

                            $assign_qty1 = $data[0]['assign_qty'] + $bill_qty_val;

                            $data1 = $data[0]['rem_qty'] - $bill_qty_val;
                            // $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                            if($data[0]['con_serial_no'] != ''){
                                $con_ser_no = $data[0]['con_serial_no'].','.$con_s_no;
                            }else{
                                $con_ser_no = $con_s_no;
                            }

                            if($data[0]['assign_int_val'] != ''){
                                $bill_val = $data[0]['assign_int_val'].','.$bill_qty_val.'-'.$con_s_no;
                            }else{
                                $bill_val = $bill_qty_val.'-'.$con_s_no;
                            }
                            // print_r($data[0]['assign_int_val']);die();
                            $table_po_details = 'product_details_sub';
            
                            $columns12            = [
                                "rem_qty"     => $data1,
                                "assign_qty" => $assign_qty1,
                                "assign_int_val" => $bill_val,
                                "con_serial_no"  => $con_ser_no

                            ];
                            $update_where12       = "form_main_unique_id = '".$main_unique_id."' AND unique_id= '".$product_unique_id."'";
                    
                            $action_obj_update     = $pdo->update($table_po_details,$columns12,$update_where12);
                            $msg = 'available';
                        } 
                }else{
                                $data1 = $data[0]['rem_qty'] - $bill_qty_val;
                                $msg = 'unavailable';
                    }
            }
            $json_array   = [
                'status'    => $status,
                'data'      => $data1,
                'assign_qty' => $bill_qty_val,
                'error'     => $error,
                'msg'       => $msg,
                'sql'       => $sql
            ];
    
            echo json_encode($json_array);
    
            break;

        // assign qty

    case 'get_assign_qty_record':

        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start      = $_POST['start'];
        $draw       = $_POST['draw'];
        $limit      = $length;



        // $next_button = $_POST['next_button'];
        $form_main_unique_id = $_POST['unique_id'];

        // $where = "main_unique_id = '$unique_id'";
        $table      =  "view_po_consignee_deatail";

        // print_r( 'hii'.$_POST['from_date'] );
        // $table1 = 'consignee_details_sub';
        // $table2 = 'view_complaint_escalate';
        // $data       = [];

        // Query Variables
        $json_array     = '';
        $columns        = [
            "con_address",
            "con_district",
            "con_pincode",
            "con_contact_name",
            "con_contact_number",
            "con_lan_num",
            "main_unique_id",
            "con_unique_id",
            "po_unique_id",
            // "count(con_contact_name) as count"
        ];
        $table_details  = [
            $table,
            $columns
        ];

        // Fetch Data
        // print_r($unique_id);
        $where = "main_unique_id = '$form_main_unique_id' AND is_delete = '0'";

        $order_by       = '';
        $sql_function   = 'SQL_CALC_FOUND_ROWS';
        $result         = $pdo->select($table_details, $where);
        // print_r($result);

        $total_records  = total_records();

        if ($result->status) {
            $s_no = 0;
            $sno = 0;
            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                $sno = $sno + 1;

                $data   .= '
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_contact_name'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Contact</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_contact_number'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Serial No</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' .$sno. '</div>                        
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Address</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_address'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Landline</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">' . $value['con_lan_num'] . '</div>
                    </div>
                </div>
            </div>
            <div class="row">
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

                $product_display_options   = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                foreach ($product_display_options as $key => $form_val) {
                    if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {
                        // echo 'hi';
                        // print_r('hi');die();                                <th scope="col">Assigned QTY</th>


                        $table_product_details      =  'product_details_sub';
                        $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND is_delete = 0";
                        $columns1    = [
                            
                            "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code)as item_code",
                            // 'product',
                            // 'item_code',
                            'product',
                            'qty',
                            'rem_qty',
                            'form_main_unique_id',
                            'unit_price',
                            'tax',
                            'unique_id',
                            // 'sum(qty) as total_qty'
                        ];

                        $table_details1   = [
                            $table_product_details,
                            $columns1
                        ];
                    } else {
                        // echo 'hello';
                        // print_r('hello');die();
                        $table_assign_details      =  'po_product_assign_details';
                        $where1 = "form_main_unique_id = '" . $value['main_unique_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
                        $columns1    = [
                            "item_code",
                            // "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_assign_details .item_code)as item_code",
                            'product',
                            'qty',
                            'assign_qty',
                            'form_main_unique_id',
                            'unit_price',
                            'unique_id',
                            'product_unique_id',
                            'item_tax',
                            'rem_qty',
                            // 'sum(qty) as total_qty'
                        ];

                        $table_details1   = [
                            $table_assign_details,
                            $columns1
                        ];
                    }

                    $values_product  = $pdo->select($table_details1, $where1);
                     //print_r( $values_product );die();
                    if ($values_product->status) {
                        $product_array      = $values_product->data;

                        foreach ($product_array as $key => $product) {
                            $s_no = $s_no + 1;
                            $sum_item_qty += $product['qty'];

                            if ($value['con_unique_id'] != '') {
                                $data .= '<tr>
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                    
                                                        <td>';
                                if ($product['product_unique_id']) {
                                    $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control" value="' . $product['product_unique_id'] . '">';
                                } else {
                                    $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control" value="' . $product['unique_id'] . '">';
                                }
                                $data .= '<input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                    class="form-control" value="' . $product['form_main_unique_id'] . '">
                                                                    <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                    class="form-control" value="' . $value['con_unique_id'] . '">
                                                                    <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                    class="form-control" value="' . $value['po_unique_id'] . '">

                                                                    <input type="hidden" id="con_name" name="con_name[]"
                                                                    class="form-control" value="' . $value['con_contact_name'] . '">
                                                                    <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                    class="form-control" value="' . $value['con_contact_number'] . '">
                                                                    <input type="hidden" id="item_code" name="item_code[]"
                                                                    class="form-control" value="' . $product['item_code'] . '">
                                                                    <input type="hidden" id="item_name" name="item_name[]"
                                                                    class="form-control" value="' . $product['product'] . '">

                                                                    <input type="hidden" id="unit_price" name="unit_price[]"
                                                                    class="form-control" value="' . $product['unit_price'] . '">
                                                                    
                                                                     <input type="hidden" id="qty" name="qty[]"
                                                                    class="form-control"  value="' . $product['qty'] . '">

                                                                    <input type="hidden" id="less_qty" name="less_qty[]"
                                                                    class="form-control"  value="'.$product['qty'].'">

                                                                    <input type="hidden" id="tax" name="tax[]"
                                                                    class="form-control" value="' . $product['item_tax'] . '">
                                                                    
                                                                    <input type="hidden" id="con_sno" name="con_sno[]"
                                                                    class="form-control"  value="' . $sno . '">';

                                $data .= '<input type="tel" id="bill_qty" name="bill_qty[]"  class="form-control" value="' . $product['assign_qty'] . '" >
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]"></label>';
                                // $data .= '</div>';
                                $data .= '</td>
                                        </tr>';
                            } else {
                                // <td><input type="text" id="good" name="good[]"
                                //                         class="form-control" readonly>
                                //                         <input type="text" id="old_good" name="old_good[]"
                                //                         class="form-control" readonly></td>
                                // <td><input type="tel" id="re_qty" name="re_qty[]"  class="form-control" value="' . $product['rem_qty'] . '"></td>
                                // <input type="text" id="good" name="good[]" class="form-control" readonly>onchange="check_qty()"

                                $data .= '<tr>
                                                        <td>' . $s_no . '</td>
                                                        <td>' . $product['item_code'] . '</td>
                                                        <td>' . $product['product'] . '</td>
                                                        <td>' . $product['qty'] . '</td>
                                                        <td>
                                                            
                                                                <input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                class="form-control" value="' . $product['product_unique_id'] . '">
                                                            
                                                                <input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                class="form-control" value="' . $product['form_main_unique_id'] . '">
                                                                <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                class="form-control" value="' . $value['con_unique_id'] . '">
                                                                <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                class="form-control" value="' . $value['po_unique_id'] . '">
                                                                <input type="hidden" id="con_name" name="con_name[]"
                                                                    class="form-control" value="' . $value['con_contact_name'] . '">
                                                                <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                    class="form-control" value="' . $value['con_contact_number'] . '">
                                                                <input type="hidden" id="item_code" name="item_code[]"
                                                                    class="form-control" value="' . $product['item_code'] . '">
                                                                <input type="hidden" id="item_name" name="item_name[]"
                                                                    class="form-control" value="' . $product['product'] . '">

                                                                <input type="hidden" id="unit_price" name="unit_price[]"
                                                                    class="form-control" value="' . $product['unit_price'] . '">
                                                                    <input type="hidden" id="less_qty" name="less_qty[]"                                                    
                                                                    class="form-control"  value="' . $product['qty'] . '">

                                                                <input type="hidden" id="tax" name="tax[]"
                                                                    class="form-control" value="' . $product['tax'] . '">
                                                                    
                                                                      <input type="hidden" id="qty" name="qty[]"
                                                                    class="form-control"  value="' . $product['qty'] . '">
                                                                    
                                                                    <input type="hidden" id="con_sno" name="con_sno[]"
                                                                    class="form-control"  value="' . $sno . '">';

                                                                 

                                $data .= '<input type="tel" id="bill_qty" name="bill_qty[]" class="form-control">

                                <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]"></label>';

                                // $data .= '</div>';

                                $data .= '</td>
                                       </tr>';
                            }
                        }

                    }
                }
                // <td><input type="tel" id="re_qty" name="re_qty[]"  class="form-control" value="' . $product['rem_qty'] . '"></td>
                // <td><input type="text" id="good" name="good[]"
                // class="form-control" readonly></td>
                // }onkeyup="get_qty(qty.value,bill_qty.value)"onchange="check_qty()"
                // onkeyup="get_qty()"
                $data .= '</tbody>
                        </table>
                                
               </form>
            </div>
            </div>
        </div>';
            }
        }
        //     }
        // }
        $json_array = [
            'data'            => $data,
        ];

        echo json_encode($json_array);

        break;


        case 'po_cancel_datatable':
            // DataTable Variables
            $search      = $_POST['search']['value'];
            $length      = $_POST['length'];
            $start          = $_POST['start'];
            $draw          = $_POST['draw'];
            $limit          = $length;
    
            $data        = [];
            $month_fill         = $_POST["month_fill"];
            // echo $month_fill;
            $month_val = date("F/Y", strtotime($month_fill));
    
            // $date_format = strtotime($month_val);
            
            // $new_date = date("Y-m",$date_format);
            
            $date = new DateTime($month_fill);
    
    
    $date->modify('-1 month');
    
    
    $dec_date = $date->format('Y-m');
    
           
            if ($length == '-1') {
                $limit  = '';
            }
            $table_po="po_form";
            // Query Variables
            $json_array     = '';
            $columns        = [
                "'' as  s_no",
                'po_num',
                "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                // '',
                '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_po.'.department ) AS department',
                'gst_value',
                '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id ='.$table_po .'.executive_name ) AS executive_name',
                // '(SELECT sum(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS total_value ',
                'ROUND((SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  and dis.is_delete=0), 2) AS total_value',
               
                'po_cancel_file',
                "file_org_name",
                'unique_id',
               
                // '(SELECT form_main_unique_id FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS con_form_main_unique_id',
                // '(SELECT count(form_main_unique_id) as cnt FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id AND  dis.is_delete=0 ) AS cnt',
                // '(SELECT count(form_main_unique_id) as cnt FROM consignee_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  AND dis.is_delete=0) AS cnt1',
                // '(SELECT count(form_main_unique_id) as cnt FROM po_product_assign_details AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id AND dis.is_delete=0) AS cnt2',
                // "delivery_due_dates",
            ];
            $table_details  = [
                $table_po,
                $columns
            ];
            
    
            $where = " is_delete = '1' AND reject_reason!=''";
           
            // $dec_date = $date->format('Y-m');
            // if($month_fill != ''){
            //     $where = "DATE_FORMAT(po_date, '%Y-%m') LIKE '%".$month_fill."%'";
            // }
           
            // $order_by ="id desc";
            $order_column   = $_POST['order'][0]['column'];
            $order_dir      = $_POST['order'][0]['dir'];
    
            // Datatable Ordering
            $order_by       = datatable_sorting_po($order_column, $order_dir, $columns);

            // $order_by = "unique_id $order_dir";
            // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
         
          

    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
           
            if ($search) {
                if ($where) {
                    $where .= 'AND ';
                }
    
                $where .= $search;
            }
    
            $sql_function   = 'SQL_CALC_FOUND_ROWS';
            // $result= $pdo->select($table_details, $where, $limit, $start, 'po_num DESC,'. $order_by, $sql_function);
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result);die();
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $sno + 1;
                    // $value['state_name'] = disname( $value['state_name'] );
                    $po_num= $value['po_num'];
                    $total_value         = $value['total_value'];
                    $value['total_value']  = moneyFormatIndia(($total_value));
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
    
                    $gst_value= $value['gst_value'];
                    if($gst_value==''){
                        $value['gst_value']="Unregistered";
                    }
                   
                   
                    $file_name =  $value['file_name'];
                    $value['po_cancel_file'] = image_view_4("po_form", $value['invoice_unique_id'], $value['po_cancel_file']);
                    
                    
                    $value['is_active'] = is_active_show($value['is_active']);
                    // $orgDate = $value['po_date'];  
                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));  
    
                    // $where_1      = [
                    //     "form_main_unique_id" => $value['unique_id']
                    // ];
                    $where_1="form_main_unique_id='".$value['unique_id']."'";
                    // ORDER BY unique_id DESC
            
                    $table_1      =  "stock_position_main";
            
                    $columns_1    = [
                        'COUNT(form_main_unique_id) AS count'
                    ];
            
                    $table_details_1   = [
                        $table_1,
                        $columns_1
                    ];
            
                    $result_values_12  = $pdo->select($table_details_1, $where_1);
                    // print_r($result_values_12);die();
                    $data_st       = $result_values_12->data;
                    $btn_update         = btn_update($folder_name, $value['unique_id']);
                    $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                    
                    // $value['file_org_name'] = '<a href="index.php?file=po_form/po_cancel&unique_id=' . $value['unique_id'] . '"><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light float-right ml-2">Cancel</button></a>';

                    // $btn_view           = btn_cancel($folder_name );
                  if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($data_st[0]['count']){
                        $value['unique_id'] = "";
                      }else{
                        $value['unique_id'] = $btn_update . $btn_delete;
                      }
                    
                  }
                  if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                    $value['unique_id'] = $btn_update . $btn_delete;
                  }
    
                    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    'draw'                => intval($draw),
                    'recordsTotal'         => intval($total_records),
                    'recordsFiltered'     => intval($total_records),
                    'data'                 => $data,
                    'testing'            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;


            case 'po_cancel_add_update':
                $table_po             = 'po_form';
                // $payement_receive          = $_POST["payement_receive"];
                //$under_user_type    = $_POST["under_user_type"];
                $reject_reason          = $_POST["reject_reason"];
              
                $unique_id          = $_POST["unique_id"];
        
                $update_where_cancel       = "";
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
                    $columns_cancel            = [
                        "reject_reason"           => $reject_reason,
                        "is_delete"=>1,
                        // "payment_status"     => $payment_status,
                        // "payment_date"           => $payment_date,
                        // "ld_amount"           => $ld_amount,
                        // "ld_days"           => $ld_days,
                        // "claim_percentage"           => $claim_amount,
                        'po_cancel_file'           => $file_names,
                        'po_cancel_file_orgname'           => $file_org_names,
        
        
                    ];
                    

                }
                 else {
                    $columns_cancel            = [
                        "reject_reason"           => $reject_reason,
                        "is_delete"=>1,
                    ];
                    
                }
                
              
            
    
            $where = " is_delete = '1' AND reject_reason!=''";
           
      
                // Update Begins
                if ($unique_id) {

                    $table= 'product_details_sub';
                    $columns1 = [
                          "is_delete" => 1
                        ];
                                    
                     $select_where2      =  "form_main_unique_id = '".$unique_id."'";
                    $action_obj1= $pdo->update($table,$columns1,$select_where2);
                    
                    $table= 'consignee_details_sub';
                    $columns1 = [
                          "is_delete" => 1
                        ];
                                    
                     $select_where3      =  "form_main_unique_id = '".$unique_id."'";
                    $action_obj1= $pdo->update($table,$columns1,$select_where3);

                    // $update_where   = [
                    //     "bill_form_unique_id"     => $unique_id,
                    // ];
                    $update_where_cancel = "unique_id='" .$unique_id . "'";
        
                    $action_obj    = $pdo->update($table_po, $columns_cancel, $update_where_cancel);
                    // print_r($action_obj);
        
                    // Update Ends
                }
                // print_r($action_obj_cancel);
                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = "";
                    $sql        = $action_obj->sql;
        
                    if ($unique_id) {
                        $msg        = "update";
                    }
                    // else {
                    //     $msg        = "create";
                    // }
                } else {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = $action_obj->error;
                    $sql        = $action_obj->sql;
                    $msg        = "error";
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



function po_no_get()
{
    $date = date('Y');
    $st_date = substr($date, 2);
    $month = date('m');
    $datee = $st_date . $month;
    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connected successfully';
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM po_form where `po_unique_id` LIKE 'PO%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;

    // if ( $res1 = $stmt->fetch( $stmt ) )
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['po_unique_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r( $booking_no );
    }
    if ($booking_no == '')
        $booking_nos = 'PO-' . $datee . '-0001';
    elseif ($year != date('Y'))
        $booking_nos = 'PO-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'PO-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }

    return $booking_nos;
}

// po product assign po num generate

function product_assign_po_no_get()
{
    // $date = date( 'Y' );
    // $st_date = substr( $date, 2 );
    // $month = date( 'm' );
    // $datee = $st_date . $month;
    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
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
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;

    // if ( $res1 = $stmt->fetch( $stmt ) )
    if ($res1 = $stmt->fetch()) {

        $pur_array = $res1['po_unique_id'];

        // $year1 = $pur_array[1];
        // $year2 = substr( $year1, 0, 2 );
        // $year = '20' . $year2;
        // $booking_no = $pur_array[2];
        // print_r( $booking_no );
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



