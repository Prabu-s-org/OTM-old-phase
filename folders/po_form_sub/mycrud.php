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
        // $po_prepared_by          = $_POST['po_prepared_by'];
        $po_type    = $_POST['po_type'];
        $no_of_po          = $_POST['no_of_po'];

        $no_of_consignee    = $_POST['no_of_consignee'];
        $unique_id          = $_POST['unique_id'];
        $m_unique_id = $_POST['m_unique_id'];
        $po_unique_id = $_POST['po_unique_id'];
        $state_name = $_POST['state_name'];
        // $zone = $_POST['zone'];

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
            'state_name' => $state_name,
            // 'zone' => $zone,

            
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
            // print_r($action_obj1);die();
            
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
            // print_r($data[0]['count']);

        if($data[0]['count'] !== 0) {
            if ($unique_id) {
                unset($columns['unique_id']);
                $update_where   = [
                    'unique_id'     => $unique_id
                ];
                // $update_where =  'unique_id ="'.$unique_id.'"';
                $action_obj     = $pdo->update($table, $columns, $update_where);
                // Update Ends
            }
        }else if(($data[0]['count'] === 0)) {
 
        // Update Begins
        
            // Insert Begins
           $action_obj     = $pdo->insert($table, $columns);
            // Insert Ends
        }
        // print_r("hii".$action_obj);die();
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


   case "get_consignee_product_details":

    // $main_unique_id = $_POST["main_unique_id"];
    
     $batch_id = $_POST['batch_id'];
    $search         = $_POST['search']['value'];
    $length         = $_POST['length'];
    $start          = $_POST['start'];
    $draw           = $_POST['draw'];
   

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
        // "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=view_consignee_product_details.item_code)as item_code",
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

    // Base WHERE clause
    // $where = "main_unique_id = '" . $main_unique_id . "'";
    $where = "batch_id = '" . $batch_id . "'";
    
    

    // Apply search filter
    $search_filter = datatable_searching($_POST['search']['value'], $columns);
    if ($search_filter) {
        $where .= " AND ($search_filter)";
    }

    $order_by = ""; // Add ordering logic here if needed

    // Fetch data
    $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');
// print_r($result);die();
    $total_records = total_records();

    if ($result->status) {
        foreach ($result->data as $row) {
            $data[] = [
                "batch_no" => $row['batch_id'],
                "po_number" =>$row['po_number'],
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

            $item_code   = $_POST["item_code"];
    
            $details    = [
                "item_description"          => "",
                "rc_unit_price"           => "",
                "rc_net_price"              => "",
                "gst"           => ""
                
            ];
    $items_where='unique_id="'.$item_code.'" ';
            // if ($item_code) {
                // $items_where = [
                //     "unique_id" => $item_code
                // ];
    // print_r($items_where);die();
                $items__columns = [
                    "item_description",
                    "rc_unit_price",
                    "rc_net_price",
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
        // $bg          = $_POST['bg'];
        $ld          = $_POST['ld'];
        
        $tat          = $_POST['tat'];
      
        $apd          = $_POST['apd'];
        
        $amc          = $_POST['amc'];
        
         $start_date          = $_POST['start_date'];
        
        $end_date          = $_POST['end_date'];
      
        $amc_percentae          = $_POST['amc_percentae'];
        
        $amcvalue          = $_POST['amcvalue'];
       
        $bg_month    = $_POST['bg_month'];
          $bg    = $_POST['bg'];
        $demo    = $_POST['demo'];
         $amc_required    = $_POST['amc_required'];
        
        
        $po_no = $_POST['po_no'];
        $parts = explode('/', $po_no);
        // Get the last value from the array
        $po_num_value = end($parts);
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['po_file']['name'], PATHINFO_EXTENSION);

        if ($_FILES['po_file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            // $tem_name = random_strings(25) . '.pdf';
            $tem_name = "PO-".$po_num_value . '.pdf'; 
            move_uploaded_file($_FILES['po_file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
            // Set $file_names to the stored filename with .pdf extension
            $file_names = $tem_name;
            $file_org_names = $_FILES['po_file']['name'];
        }
        
        
        
        
        
        $amcpofile = $_POST['amcpofile'];
       
        $amcpofileparts = explode('/', $amcpofile);
        // Get the last value from the array
        $amcfile_value = end($amcpofileparts);
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['amcpofile']['name'], PATHINFO_EXTENSION);

        if ($_FILES['amcpofile']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
            // $tem_name = random_strings(25) . '.pdf';
            $tem_name = "PO-".$amcfile_value . '.pdf'; 
            move_uploaded_file($_FILES['amcpofile']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name);
            // Set $file_names to the stored filename with .pdf extension
         $amcfile_names = $tem_name;
            $amcfile_org_names = $_FILES['amcpofile']['name'];
        }
        
         $amcreqtable= 'amcrequired';
             
             
             $amccolumns            = [
              'po_unique_id'           => $demo,
            'start_date'           => $start_date,
             'end_date'           => $end_date,
              'amc_percentae'           => $amc_percentae,
              'amcvalue'           => $amcvalue,
              
               'amcfile_names'           => $amcfile_names,
                'amcfile_org_names'           => $amcfile_org_names
              ];
              
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
              'ld'           => $ld,
             'tat'           => $tat,
              'amc'           => $amc,
              'apd'           => $apd,
               'amc_required'           => $amc_required,
                'bg_month'           => $bg_month,
                 'bg'           => $bg,
                'file_name'           => $file_names,
                'file_org_name'           => $file_org_names,
                 


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
              'ld'           => $ld,
             'tat'           => $tat,
              'amc'           => $amc,
              'apd'           => $apd,
              'amc_required'           => $amc_required,
               'bg'           => $bg,
                'bg_month'           => $bg_month,
                


            ];
        }
        
        
        if($amc_required=='on'){
            
           
             
                $amc_action_obj     = $pdo->insert($amcreqtable, $amccolumns);
           
        }
        // Update Begins
        if ($demo) {

            // unset( $columns['unique_id'] );

            // $update_where   = [
            //     'po_unique_id'     => $demo
            // ];
            $update_where  = 'unique_id ="' . $demo . '"';

            $action_obj     = $pdo->update($table, $columns, $update_where);
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
        
        
        case 'vendor_creation':
            
            
            $table = "vendor_allocation";
            
           $vendor_name = $_POST["vendor_name"];

        $po_code          = $_POST["po_code"];
        $vendor_state_name          = $_POST["vendor_state_name"];
        $vendor_district          = $_POST["vendor_district"];
        $vendor_zone          = $_POST["vendor_zone"];
        
        $unique_id          = $_POST["unique_id"];
if ($_POST["unique_id"]== '') {
            $ids = unique_id($prefix);
        } else if ($unique_id != '') {
            $ids = $unique_id;
        }

        $update_where       = "";
        // $table_department = 'department_creation';
        $columns            = [
            "vendor_name" => $vendor_name,
            "po_number"           => $po_code,
            "state_name"           => $vendor_state_name,
            "district"           => $vendor_district,
            "zone"           => $vendor_zone,
            "unique_id"           => $ids
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
            
            
if($_POST["unique_id"] == ''){
            $action_obj     = $pdo->insert($table, $columns);
}else {
     unset($columns['unique_id']);
                $update_where   = [
                    'po_number'     => $po_code
                ];
                // $update_where =  'unique_id ="'.$unique_id.'"';
                $action_obj     = $pdo->update($table, $columns, $update_where);
}
            // Insert Ends
    // print_r($action_obj);

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


        case 'get_state_name':

            $state_name           = $_POST['state_id'];
    
            $pre_state_options  = district("",$state_name);
    
            $pre_state_option  = select_option($pre_state_options,"Select the district");
    
            echo $pre_state_option;
            
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
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $limit          = $length;
    
            $data        = [];
            $sno = $start + 1;
            // echo $sno;
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
            $table_po = "view_po_form_list";

            // Query Variables
            $json_array = '';
            $columns = [
                "'' as s_no",
                'po_num',
                "po_date",
                "state_name",
                "district as district_name",
                // "(SELECT department FROM department_creation AS dis WHERE dis.unique_id = $table_po.department group by dis.unique_id) AS department",
                "department",
                'gst_value',
                // "(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = $table_po.executive_name group by dis.unique_id) AS executive_name",
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
            
           
            // print_r($result);die();

            $total_records  = total_records();
       
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id  = $_POST['user_type_unique_id'];
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            // print_r($select_where );
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
                    $value['s_no'] = $sno;
                    // $sno = $start + 1;
                    // $data[] = array_values($value);
                    // $value['state_name'] = disname( $value['state_name'] );
                    $po_num= $value['po_num'];
                    $total_value         = $value['total_value'];
                    $value['total_value']  = moneyFormatIndia1(($total_value));
                    
                    $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                    $gst_value= $value['gst_value'];
                    if($gst_value==''){
                        $value['gst_value']="Unregistered";
                    }
                   
                   
                    $file_name =  $value['file_name'];
                    $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                    
                    
                    $value['is_active'] = is_active_show($value['is_active']);

                    // echo $value['cnt'];
                    if($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0'  || $value['file_name']==''){
                        $value['po_num']='<span style="color:#da1c34;"
                        >'.$po_num.'</span>';
                        // echo "cnt: " . $value['cnt'] . ", cnt1: " . $value['cnt1'] . ", cnt2: " . $value['cnt2'];
            
                        // $value['po_num'] = '<span style="color:red">'.$po_num.'</span>';
                    }else{
                        $value['po_num'] = $po_num;
                    }
                   
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
                    $data_st       = $result_values_12->data;
                    $btn_update         = btn_update($folder_name, $value['unique_id']);
                    $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                    $btn_cancel         = btn_cancel_po($folder_name, $value['unique_id']);
                                                               
                    if (($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741") ||($value['po_count'] >= 1 && $_SESSION['user_type_unique_id'] == "65deef78ba17d65741" )) {
                        // echo"hi";
                            $value['po_count'] = $btn_cancel;
                          }
                          else if(($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "5f97fc3257f2525529") ||
                          ($value['po_count'] == 0 && $_SESSION['user_type_unique_id'] == "65efd97b4df4040205")){
                            $value['po_count'] = $btn_cancel;
                            // echo"hlo";
                          }
                          else if($value['cnt'] == '0' || $value['cnt1'] == '0' || $value['cnt2'] == '0' || $value['delivery_due_dates']=='' || $value['file_name']==''){
                            $value['po_count'] = '';  
                            // echo"hi hlo";        
                        }
                          else{
                            
                            if(in_array('5ff043a4f277448188', $action_ids)){
                                $value['po_count'] =  $btn_cancel;
                                // echo"345";
                            }
                            else{
                                
                                $value['po_count'] = '';
                                // echo "gfhgfhgfhgfh";
                            }
                          }
                
                   
                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                                if($data_st[0]['count']){
                                    $value['unique_id'] = "";
                                  }
                                  else{
                                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                                        $value['unique_id'] = $btn_update.$btn_delete;                   
                                    }
                                    else if(in_array('5f88082b25ec031952', $action_ids)){
                                        $value['unique_id'] = $btn_update;
                                    }
                                    else if(in_array('5f8808504271036738', $action_ids)){
                                        $value['unique_id'] = $btn_delete;
                                    }
                                    else{
                                        $value['unique_id'] = '';
                                    }
                                  }
                                
                              }
                              if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                                
                                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                                    $value['unique_id'] = $btn_update.$btn_delete;                   
                                }
                                else if(in_array('5f88082b25ec031952', $action_ids)){
                                    $value['unique_id'] = $btn_update;
                                }else if(in_array('5f8808504271036738', $action_ids)){
                                    $value['unique_id'] = $btn_delete;
                                }else{
                                    $value['unique_id'] = '';
                                }
                              }
                
                
                            //   $data[]             = array_values($value);
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
                                // "gst_value" => $value['gst_value'],
                                "po_count" => $value['po_count'],
                                "is_active" => $value['is_active'],
                                "unique_id" => $value['unique_id']
                              ];
                    $sno++;
                }   
    // print_r($data);
                $json_array = [
                    'draw'                => intval($draw),
                    'recordsTotal'         => intval($total_records),
                    'recordsFiltered'     => intval($total_records),
                    'data'                 => $data,
                    'testing'            => $result->sql
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

        //   cancel po
        
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
                // "state_name",
                '(SELECT state_name FROM state_creation AS dis WHERE dis.unique_id ='.$table_po.'.state_name ) AS state_name',
               
                // "district",
                '(SELECT district_name FROM district_creation AS dis WHERE dis.unique_id ='.$table_po.'.district ) AS district',
               
                '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_po.'.department ) AS department',
                'gst_value',
                '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id ='.$table_po .'.executive_name ) AS executive_name',
                '(SELECT sum(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS total_value ',
                // 'ROUND((SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = '.$table_po.'.unique_id  and dis.is_delete=0), 2) AS total_value',
               
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

           
            $table_product= 'product_details_sub';
            $columns1 = [
                  "is_delete" => 1
                ];
                            
             $select_where2      =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_product= $pdo->update($table_product,$columns1,$select_where2);
            

            $table_con= 'consignee_details_sub';
            $columns_con = [
                  "is_delete" => 1
                ];
                            
             $select_where3      =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_con= $pdo->update($table_con,$columns_con,$select_where3);

            $table_product_assign= 'po_product_assign_details';
            $columns_assign = [
                  "is_delete" => 1
                ];
                            
             $select_where4      =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_assign= $pdo->update($table_product_assign,$columns_assign,$select_where4);


            $table_stock= 'stock_position';
            $columns_stock = [
                  "is_delete" => 1
                ];
                            
             $select_where_stk     =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_stk= $pdo->update($table_stock,$columns_stock,$select_where_stk);


            $table_stock_main= 'stock_position_main';
            $columns_stock_main = [
                  "is_delete" => 1
                ];
                            
             $select_where_stk_main     =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_stk_main= $pdo->update($table_stock_main,$columns_stock_main,$select_where_stk_main);

            $table_stock_sublist= 'stock_position_sublist';
            $columns_stock_sub = [
                  "is_delete" => 1
                ];
                            
             $select_where_stk_sub     =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_stk_main= $pdo->update($table_stock_sublist,$columns_stock_sub,$select_where_stk_sub);

            $table_inv= 'invoice_creation';
            $columns_inv = [
                  "is_delete" => 1
                ];
                            
             $select_where_inv     =  "po_unique_id = '".$unique_id."'";
            $action_obj_inv= $pdo->update($table_inv,$columns_inv,$select_where_inv);


            $table_inv_main= 'invoice_creation_main';
            $columns_inv_main = [
                  "is_delete" => 1
                ];
                            
             $select_where_inv_main     =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_inv= $pdo->update($table_inv_main,$columns_inv_main,$select_where_inv_main);

            $table_inv_sub= 'invoice_sublist';
            $columns_inv_sub = [
                  "is_delete" => 1
                ];
                            
             $select_where_inv_sub     =  "form_main_unique_id = '".$unique_id."'";
            $action_obj_sub= $pdo->update($table_inv_sub,$columns_inv_sub,$select_where_inv_sub);

           

                // Update Begins
                if ($unique_id) {

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
        $net_value              = $_POST['net_price'];
        // new changes
        $delivery_due_dates = $_POST['delivery_due_dates'];
        $ld_per_day = $_POST['ld_per_day'];
        $ld_maximum_val = $_POST['ld_maximum_val'];
        $warranty = $_POST['warranty'];
        $warranty_duration = $_POST['warranty_duration'];
// end
        $form_main_unique_id       = $_POST['form_main_unique_id'];

        $unique_id             = $_POST['unique_id'];
        
        
         $insta_due_days = $_POST['insta_due_days'];
        $bg_required = $_POST['bg_required'];
// end
        $bg_percen       = $_POST['bg_percen'];

        $bg_month             = $_POST['bg_month'];
        
        
        
        
        
        
        $update_where          = '';
        // print_r( 'hii'.$po_name );
        if($unique_id==""){
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

                'delivery_due_dates' =>  $delivery_due_dates,
                'ld_per_day'  => $ld_per_day,
                'ld_maximum_val'  => $ld_maximum_val,
                'warranty' => $warranty,
                'warranty_duration' => $warranty_duration,
                'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' =>  $bg_percen,
                'bg_month' => $bg_month,
                'form_main_unique_id'   => $form_main_unique_id,
                // 'rem_qty'                   => $qty,
                'unique_id'              => unique_id($prefix)
            ];
        }
        else{
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
             
             'delivery_due_dates' =>  $delivery_due_dates,
             'ld_per_day'  => $ld_per_day,
             'ld_maximum_val'  => $ld_maximum_val,
             'warranty' => $warranty,
            //  'warranty_duration' => $warranty_duration,
            'insta_due_days' => $insta_due_days,
                'bg_required' => $bg_required,
                'bg_percen' =>  $bg_percen,
                'bg_month' => $bg_month,
    
             'form_main_unique_id'   => $form_main_unique_id,
             // 'rem_qty'                   => $qty,
             'unique_id'              => unique_id($prefix)
         ];
        }
    
     
    
    
    
    
            if($unique_id!="" && $warranty!='1' ){
                $columns_new = [
                            'warranty_duration' => "",
                        ];
                        $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
                        $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
    
            }
         else{
                $columns_new = [
                            'warranty_duration' =>  $warranty_duration,
                        ];
                        $update_where_new = 'form_main_unique_id ="' . $form_main_unique_id . '" AND unique_id ="' . $unique_id . '"';
                        $action_obj_new = $pdo->update($table_product_details, $columns_new, $update_where_new);
    
            }
          // check already Exist Or not
          $table_details      = [
            $table_product_details,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        $select_where       = 'is_delete = 0 AND product ="' . $po_name.'" AND unique_id ="' . $unique_id . '" ';
            
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
            // '@a:=@a+1 s_no',
            '"" as s_no',
            'tender_code',
            "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details.item_code group by item_creation_sub.unique_id)as item_code",
             'product',
            'qty',
            'unit_price',
            'tax',
            'net_value',
            'total_value',
            'delivery_due_dates',
            'ld_per_day',
            'ld_maximum_val',
            'warranty',
            // 'warranty_duration',
            "(select warrenty_year from product_warrenty where product_warrenty.unique_id=$table_product_details.warranty_duration group by product_warrenty.unique_id) as warranty_duration",

            'unique_id',
            'form_main_unique_id'
        ];

        $table_details  = [
            // $table_product_details . ' , (SELECT @a:= ' . $start . ') AS a ',
            $table_product_details,
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
                $value['s_no'] = $sno + 1;
                 $sum_net_value += floatval($value['net_value']);
        $sum_total_value += floatval($value['total_value']);

                if($value['warranty']==1)
                {
                    $value['warranty']='yes'; }
                else{
                $value['warranty']='no';
                }
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
                $sno++;
            }

            $json_array = [
                'draw'                => intval($draw),
                'recordsTotal'         => intval($total_records),
                'recordsFiltered'     => intval($total_records),
                'data'                 => $data,
                'sum_net_value'    => $sum_net_value,   // Include sum of net_value
        'sum_total_value'  => $sum_total_value, // Include sum of total_value
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
           "(select item_code from item_creation_sub where item_creation_sub.unique_id=$table_product_details.item_code) as item_code",
            // 'item_code',
            'product',
            'qty',
            'unit_price',
            'tax',
            'total_value',
            'net_value',
            'delivery_due_dates',
            'ld_per_day',
            'ld_maximum_val',
            'warranty',
            // 'warranty_duration',
            "(select warranty_duration from product_warrenty where product_warrenty.unique_id=$table_product_details.warranty_duration) as warranty_duration",

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
       $batch_id          = $_POST['batch_id'];
        $consignee_received_date          = $_POST['consignee_received_date'];
        $con_address            = $_POST['con_address'];
        $con_district     = $_POST['con_district'];
        $con_pincode         = $_POST['con_pincode'];
         $consignee_gst         = $_POST['consignee_gst'];
        $con_contact_name            = $_POST['con_contact_name'];
        $con_contact_number              = $_POST['con_contact_number'];
        $con_lan_num              = $_POST['con_lan_num'];
        $form_main_unique_id       = $_POST['form_main_unique_id'];
        $zone = $_POST['zone'];
        $cons_verify_sts    = $_POST['cons_verify_sts'];
        $unique_id             = $_POST['unique_id'];
         $po_numbers             = $_POST['po_numbers'];
        $update_where          = '';

        $dateee = date('Y-m-d');
        // print_r($con_district );die();
        $columns            = [
            'no_of_consignee'        => $no_of_consignee,
            'batch_id' => $batch_id,
            'consignee_received_date' => $consignee_received_date,
            'batch_entry_date' => $dateee,
            'con_address'                   => $con_address,
             'consignee_gst'                   => $consignee_gst,
            'con_district'                 => $con_district,
            'con_pincode'             => $con_pincode,
            'con_contact_name'              => $con_contact_name,
            'con_contact_number'             => $con_contact_number,
            'con_lan_num'             => $con_lan_num,
            'form_main_unique_id'   => $form_main_unique_id,
            'zone'                   => $zone,
            'cons_verify_sts'        => $cons_verify_sts,
            'po_number' => $po_numbers,
            'unique_id'              => unique_id($prefix)
        ];

        // check already Exist Or not
        $table_details      = [
            $table_consignee_details,
            [
                'COUNT(unique_id) AS count'
            ]
        ];
        

        $select_where       = ' is_delete = 0 AND con_address ="'.$con_address .'"  AND form_main_unique_id ="' .$form_main_unique_id . '"';
       

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
                $table_product_po='po_product_assign_details';
                $columns_po = [
                    "con_name" =>$con_contact_name ,
                    "con_contact_no" =>$con_contact_number ,
        
                ];
               
                $update_where_po = 'form_main_unique_id="' . $form_main_unique_id . '" and con_unique_id="' . $unique_id . '" ';
                $action_obj_1 = $pdo->update($table_product_po, $columns_po, $update_where_po);
                // print_r(

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


                $total_record        = $pdo->select($table_details1, $count_where);
                // print_r( $total_record );

                $data_record       = $total_record->data;

                // if ($data_record[0]['count'] == $_POST['no_of_consignee']) {
                //     $msg        = 'e_already';
                // } else {
                    // Insert Begins
                    $action_obj     = $pdo->insert($table_consignee_details, $columns);
                    $msg        = 'add';
                    // Insert Ends

                // }
                // print_r($action_obj);
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




case 'consignee_details_datatable_test':
        $form_main_unique_id = $_POST['form_main_unique_id'];
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = ($length == '-1') ? '' : $length;

        $columns = [
            '"" as s_no',
            'batch_id',
            'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
            'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
            'COUNT(*) as count',
            'MIN(unique_id) as unique_id'
        ];

        $table = 'consignee_details_sub';
        $where = "is_active = 1 AND is_delete = 0 AND form_main_unique_id = :form_main_unique_id";
        $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(',', $columns) . " 
                FROM $table 
                WHERE $where 
                GROUP BY batch_id 
                ORDER BY batch_entry_date DESC 
                LIMIT $start, $limit";

        $stmt = $pdo_conn->prepare($sql);
        $stmt->execute(['form_main_unique_id' => $form_main_unique_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalRecords = $pdo_conn->query("SELECT FOUND_ROWS()")->fetchColumn();

        $data = [];
        $sno = $start;
        foreach ($result as $row) {
            $sno++;
            $row['s_no'] = $sno;
            $row['count'] = '<span class="count-badge" data-batch-id="' . $row['batch_id'] . '" style="cursor:pointer;color:blue;">' . $row['count'] . '</span>';
            $data[] = array_values($row);
        }

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords),
            'data' => $data
        ]);
        break;

    case 'get_consignee_by_batch123':
        $batch_id = $_POST['batch_id'];

        $query = "SELECT consignee_name, address, city 
                  FROM consignee_details_sub 
                  WHERE batch_id = :batch_id AND is_active = 1 AND is_delete = 0";
        $stmt = $pdo_conn->prepare($query);
        $stmt->execute(['batch_id' => $batch_id]);

        $output = '<table class="table table-bordered">
                    <thead><tr><th>Name</th><th>Address</th><th>City</th></tr></thead><tbody>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= '<tr><td>' . $row['consignee_name'] . '</td><td>' . $row['address'] . '</td><td>' . $row['city'] . '</td></tr>';
        }
        $output .= '</tbody></table>';

        echo $output;
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
      $columns = [
    '"" as s_no',
    'batch_id',
    'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
    'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
    'COUNT(*) as count',
     "(select count(item_code) as item_count from product_details_sub WHERE form_main_unique_id = $table_consignee_details.form_main_unique_id) as item_count",
    "(select SUM(qty) as qty from product_details_sub WHERE form_main_unique_id = $table_consignee_details.form_main_unique_id) as qty_count",

    'MIN(unique_id) as unique_id', // Use MIN to fetch a reference ID for actions
           "'' as imports",
    "(select count(batch_id) as batch_cnt from po_product_assign_details where po_product_assign_details.batch_id = $table_consignee_details.batch_id) as batch_cnt",
    // "(select qty from po_product_assign_details where po_product_assign_details.batch_id = $table_consignee_details.batch_id ORDER BY updated DESC 
    //     LIMIT 1) as order_qty",
    //  "(select batch_id from po_product_assign_details where po_product_assign_details.batch_id = $table_consignee_details.batch_id ORDER BY updated DESC 
    //     LIMIT 1) as order_qty",
        
        
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
$result = $pdo->select($table_details, $where.$group_by);
// print_r($result);
        // print_r($result);die();
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $batch_id = $value['batch_id'];
                $value['item_count'] = $value['item_count'];
                $value['qty_count'] = $value['qty_count'];
                
                
$value['count'] = '<span class="badge bg-primary count-badge" style="font-size: 15px;" data-batch-id="' . $value['batch_id'] . '" style="cursor:pointer;">' . $value['count'] . '</span>';


if($value['batch_cnt'] === 0){
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
}else{
    $value['unique_id'] = 'Exported Done';

$value['imports'] = 'Imported Done';

// $value['unique_id'] = 'Exported Done'.'<input type="text" name="batch_code" id="batch_code" value=' . $value['input_batch_id'] . '>';

// $value['input'] = '<input type="text" name="batch_code" id="batch_code" value=' . $value['batch_id'] . '>';


}
                                                                   
// $value['item_count'] = '
// <span 
//     class="badge bg-primary show-consignee" 
//     style="font-size: 15px; cursor:pointer;" 
//     data-batch-id="' . $value['batch_id'] . '">
//     ' . $value['item_count'] . '
// </span>';

$value['item_count'] = '<span class="badge bg-primary show-consignee" style="font-size: 15px; cursor:pointer;" data-batch-id="' . $value['batch_id'] . '">' . $value['item_count'] . '</span>';


                // $btn_edit               = btn_edit($btn_edit_delete, $value['unique_id']);
                // $btn_delete             = btn_delete($btn_edit_delete, $value['unique_id']);

                // if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                //     if($data_st[0]['count']){
                //         $value['unique_id'] = "";
                //       }else{
                //         $value['unique_id']     =  $btn_edit  . $btn_delete;
                //     }
                    
                // }
                // if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                //     $value['unique_id']     =  $btn_edit  . $btn_delete;
                // }
                $data[]                 = array_values($value);
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
        
        
        
        case 'get_consignee_group_data':
    $batch_id = $_POST['batch_id'];

    $query = "
        SELECT 
            consignee_name,
            SUM(order_qty) as total_order_qty,
            SUM(assign_qty) as total_assign_qty
        FROM po_product_assign_details
        WHERE batch_id = :batch_id
        GROUP BY consignee_name
    ";

    $stmt = $pdo_conn->prepare($query);
    $stmt->execute(['batch_id' => $batch_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create a simple HTML table
    $html = '<table class="table table-bordered">';
    $html .= '<thead><tr><th>Consignee</th><th>Order Qty</th><th>Assigned Qty</th></tr></thead><tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>
            <td>' . htmlspecialchars($row['consignee_name']) . '</td>
            <td>' . $row['total_order_qty'] . '</td>
            <td>' . $row['total_assign_qty'] . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    echo json_encode(['html' => $html]);
    break;

case 'get_consignee_by_batch':
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

$i=0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $status = $row['cons_verify_sts'] == 1 ? 'Verified' : 'Not Verified';
            $html .= '<tr>';
            $html .= '<td>' . $i+1 . '</td>';
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

case 'delete_consignee':
    $unique_id = $_POST['unique_id'] ?? '';

    if (!$unique_id) {
        echo 'error';
        break;
    }

    try {
        $stmt = $conn->prepare("UPDATE consignee_details_sub SET is_delete = 1 WHERE unique_id = :unique_id");
        $stmt->execute(['unique_id' => $unique_id]);

        echo 'success';
    } catch (PDOException $e) {
        echo 'error';
    }
    break;

case 'consignee_details_datatable_oldas':
    $driver         = "mysql";
    $host           = "localhost";
    $username       = project_env('APP_DB_USERNAME', 'root');
    $password       = project_env('APP_DB_PASSWORD');
    $databasename   = "operation_team_beta";

    try {
        $conn = new PDO("$driver:host=$host;port=3306;dbname=$databasename", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    echo $form_main_unique_id = $_POST['form_main_unique_id'] ?? '';
    $search              = $_POST['search']['value'] ?? '';
    $length              = $_POST['length'] ?? 10;
    $start               = $_POST['start'] ?? 0;
    $draw                = $_POST['draw'] ?? 1;

    $limit = ($length == '-1') ? '' : "LIMIT $start, $length";

    $columns = [
        '"" as s_no',
        'batch_id',
        'DATE_FORMAT(batch_entry_date, "%d-%m-%Y") as batch_entry_date',
        'DATE_FORMAT(consignee_received_date, "%d-%m-%Y") as consignee_received_date',
        'COUNT(*) as count',
        'MIN(unique_id) as unique_id'
    ];

    $column_str = implode(", ", $columns);
    $where = "is_active = 1 AND is_delete = 0 AND form_main_unique_id = :form_main_unique_id";
    $group_by = "GROUP BY batch_id";

    $sql = "SELECT SQL_CALC_FOUND_ROWS $column_str 
            FROM consignee_details_sub 
            WHERE $where 
            $group_by 
            $limit";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['form_main_unique_id' => $form_main_unique_id]);
print_r();
    $data = [];
    $sno = $start + 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['s_no'] = $sno++;
        $row['count'] = '<span class="badge bg-primary count-badge" data-batch-id="' . htmlspecialchars($row['batch_id']) . '" style="cursor:pointer;">' . $row['count'] . '</span>';
        $row['unique_id'] = ''; // Optional: add buttons or actions if needed
        $data[] = array_values($row);
    }

    $total_records = $conn->query("SELECT FOUND_ROWS()")->fetchColumn();

    echo json_encode([
        'draw' => intval($draw),
        'recordsTotal' => intval($total_records),
        'recordsFiltered' => intval($total_records),
        'data' => $data
    ]);
    break;




 case 'consignee_details_datatable_1':
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
            // '@a:=@a+1 s_no',
            '"" as s_no',
            // 'no_of_consignee',
            // 'con_qty',
            'batch_id',
            'batch_insert_date',
            'consignee_received_date',
            'count(batch_id) as count',
//             'con_address',
//             // "con_district",
//             // "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
//  "IFNULL(
//         (SELECT district_name 
//          FROM district_creation 
//          WHERE district_creation.unique_id = consignee_details_sub.con_district group by district_name), 
//         '') AS district_name",
//             'con_pincode',
//             'zone',
//             'con_contact_name',
//             'con_contact_number',
            
//             "con_lan_num",
//             "consignee_gst",
//             "cons_verify_sts",
            // "zone",
            'unique_id'
        ];
        $table_details  = [
            // $table_consignee_details . ' , (SELECT @a:= ' . $start . ') AS a ',
            $table_consignee_details,
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
                $value['s_no'] = $sno + 1;
                
                // $verify_sts = $value['cons_verify_sts'];
                
                // if($verify_sts == '2'){
                //     $value['cons_verify_sts'] = 'Not Verified';
                // }
                // elseif($verify_sts == '1'){
                //      $value['cons_verify_sts'] = 'Verified';

                // }
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


case 'amc_datatable':

    $form_main_unique_id = $_POST['form_main_unique_id'];

    // DataTable Parameters
    $search  = $_POST['search']['value'];
    $length  = $_POST['length'];
    $start   = $_POST['start'];
    $draw    = $_POST['draw'];
    $limit   = ($length == '-1') ? '' : $length;

    $amctable = 'amcrequired';
    $data     = [];
    $sno      = $start + 1; // Initialize serial number properly

    // Query Variables
    $columns = [
        '"" as s_no', 
        'start_date', 
        'end_date', 
        'amc_percentae', 
        'amcvalue',
         'amcfile_names',
         'amcfile_org_names', 
        'po_unique_id'
    ];

    $table_details = [
        $amctable,
        $columns
    ];

    $where = 'is_active = 1 AND is_delete = 0 AND po_unique_id = "' . $form_main_unique_id . '"';
    $order_by = '';

    $sql_function = 'SQL_CALC_FOUND_ROWS';

    // Fetch Data
    $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
    $total_records = total_records();

    if ($result->status) {
        $res_array = $result->data;

        foreach ($res_array as $key => $value) {
            $value['s_no'] = $sno++; // Increment serial number correctly
               $file_name =  $value['amcfile_names'];
               
                $value['amcfile_names'] = image_view_2("po_form", $value['po_unique_id'], $value['amcfile_names']);
              
            $data[] = array_values($value);
        }
    }

    // JSON Response
    echo json_encode([
        'draw'            => intval($draw),
        'recordsTotal'    => intval($total_records),
        'recordsFiltered' => intval($total_records),
        'data'            => $data,
        'query'           => $result->sql // Keeping query for debugging
    ]);

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
            "zone",
            'unique_id',
            'con_district',
            'cons_verify_sts'
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
    ];
    $table_details = [
        $table,
        $columns
    ];

    // $where = "main_unique_id = '$form_main_unique_id' AND is_delete = '0'";
     $where = "batch_id = '$batch_ids' AND is_delete = '0'";
    $result = $pdo->select($table_details, $where);
    // print_r($result);
    $total_records = total_records();

    $table_po_assign = "po_product_assign_details";
    $columns23 = [
        "con_unique_id"
    ];
    $table_details23 = [
        $table_po_assign,
        $columns23
    ];

    // $where23 = "form_main_unique_id = '$form_main_unique_id' AND is_delete = '0'";
     $where23 = "batch_id = '$batch_ids' AND is_delete = '0'";
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

                $product_display_options   = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                foreach ($product_display_options as $key => $form_val) {
                    if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {
                        // echo 'hi';
                        // print_r('hi');die();                                <th scope="col">Assigned QTY</th>


                        $table_product_details      =  'product_details_sub';
                        $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
                        $columns1    = [
                            
                            "(select item_code from item_creation_sub WHERE item_creation_sub.unique_id=$table_product_details .item_code group by item_creation_sub.unique_id)as item_code",
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
                        $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
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
                    //  print_r( $values_product );die();
                    if ($values_product->status) {
                        $product_array      = $values_product->data;

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
            }else if (in_array($value['con_unique_id'], $stored_consignees)) {
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

                $product_display_options   = assign_qty($value['main_unique_id'], $value['con_unique_id']);

                foreach ($product_display_options as $key => $form_val) {
                    if (($form_val['con_unique_id'] == '') && ($form_val['con_count'] == 0)) {
                        // echo 'hi';
                        // print_r('hi');die();                                <th scope="col">Assigned QTY</th>


                        $table_product_details      =  'product_details_sub';
                        $where1 = "batch_id = '" . $value['batch_id'] . "' AND is_delete = 0";
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
                        $where1 = "batch_id = '" . $value['batch_id'] . "' AND con_unique_id = '" . $form_val['con_unique_id'] . "'";
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
            }
        // }
        $json_array = [
            'data'            => $data,
        ];

        echo json_encode($json_array);

        break;

    default:

        break;
}





// po product assign po num generate

function product_assign_po_no_get()
{
    // $date = date( 'Y' );
    // $st_date = substr( $date, 2 );
    // $month = date( 'm' );
    // $datee = $st_date . $month;
    $servername = 'localhost';
   $username       = project_env('APP_DB_USERNAME', 'root');
$password       = project_env('APP_DB_PASSWORD');
$databasename   = "operation_team_beta";

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
?>





