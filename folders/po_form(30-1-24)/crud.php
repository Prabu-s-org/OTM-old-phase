<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = 'po_form';
$table_product_details = 'product_details_sub';
$table_consignee_details = 'consignee_details_sub';


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';
// File Upload Library Call

$fileUploadPath = $fileUploadConfig->get('upload_folder' );

// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set('upload_folder', $fileUploadPath. $folder_name . DIRECTORY_SEPARATOR );
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
        
    if ($gst_option =='yes') {
        $gst_value1 = $gst_value;
    } else if ( $gst_option=='no') {
        $gst_value1 = '';
    }

    if ($unique_id ==''){
        $ids = $m_unique_id;
    } else if($unique_id!='') {
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
        'no_of_consignee'           =>$no_of_consignee,
        'po_unique_id' => $po_unique_id,
        'unique_id'           =>$ids,
    ];

//  $table_details      = [
//             $table,
//             [
//                 'COUNT(unique_id) AS count'
//             ]
//         ];
//     $select_where = 'is_delete = 0 AND contact_name ="'.$contact_name.'"';
//     $action_obj1         = $pdo->select($table_details,$select_where);

//     // print_r($action_obj1);
//     if ($action_obj1->status ) {
//         $status     = $action_obj1->status;
//         $data       = $action_obj1->data;
//         $error      = '';
//         $sql        = $action_obj1->sql;

//     } else {
//         $status     = $action_obj1->status;
//         $data       = $action_obj1->data;
//         $error      = $action_obj1->error;
//         $sql        = $action_obj1->sql;
//         $msg        = 'error';

//     }
    // if($data[0]['count']) {
    //     $msg = 'already';
    // }else
    //  if(($data[0]['count']== 0)) {

    // Update Begins
    if ($unique_id) {
        unset($columns['unique_id']);
        $update_where   = [
            'unique_id'     =>$unique_id
        ];
        // $update_where =  'unique_id ="'.$unique_id.'"';
        $action_obj     = $pdo->update($table,$columns,$update_where);
        // Update Ends
    } else {
        // Insert Begins
        $action_obj     = $pdo->insert($table,$columns);
        // Insert Ends
    }
    // print_r($action_obj);
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

    case 'terms_condition':
      
        $delivery_due_dates          = $_POST['delivery_due_dates'];
        $ld_per_day          = $_POST['ld_per_day'];
        $ld_maximum_val    = $_POST['ld_maximum_val'];
        $warranty          = $_POST['warranty'];
        $warranty_duration    = $_POST['warranty_duration'];
        $ins_reqired          = $_POST['ins_reqired'];
        $bank_required          = $_POST['bank_required'];
        $bg          = $_POST['bg'];
        $bg_month    = $_POST['bg_month'];
        $demo    = $_POST['demo'];
        // $unique_id          = $_POST['unique_id' ];
        // $m_unique_id = $_POST['m_unique_id' ];
        // $po_unique_id = $_POST['po_unique_id'];
    
            // $po_unique_id = po_no_get();
        // if ($gst_option == 'yes') {
        //     $gst_value1 = $gst_value;
        // } else if ( $gst_option  == 'no' ) {
        //     $gst_value1 = '';
        // }
    
        // if ($unique_id == '' ) {
        //     $ids = $m_unique_id;
        // } else if ($unique_id  != '' ) {
        //     $ids = $unique_id;
        // }
    
        $allowedExts = array('pdf');
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    
        if ($_FILES['file']['type'] == 'application/pdf') {
            $file_exp = explode( '.', $_FILES['file']['name'] );
            $tem_name =  random_strings( 25 ).'.'.$file_exp[1];
    
            move_uploaded_file( $_FILES['file']['tmp_name'],'../../uploads/po_form/po_attach/'.$tem_name );
        }
        if ( !empty( $_FILES['file']['name'] ) ) {
            $file_names     = $tem_name;
            $file_org_names = $_FILES['file']['name'];
        }
    
      
        $update_where       = '';
        // print_r( $m_unique_id );
        $columns            = [
           
            'delivery_due_dates'           => $delivery_due_dates,
            'ld_per_day'     => $ld_per_day,
            'ld_maximum_val'           => $ld_maximum_val,
            'warranty'           => $warranty,
            'warranty_duration'     => $warranty_duration,
            'ins_reqired'           => $ins_reqired,
            'bank_required'           => $bank_required,
            'bg'     => $bg,
            'bg_month'           => $bg_month,
            'file_name'           => $file_names,
            'file_org_name'           => $file_org_names
            
            
        ];
    
        // Update Begins
        if($demo) {
    
            // unset( $columns['unique_id'] );
    
            // $update_where   = [
            //     'po_unique_id'     => $demo
            // ];
            $update_where  = 'unique_id ="'.$demo.'"';
    
            $action_obj     = $pdo->update($table, $columns, $update_where);
    
            // Update Ends
        } 
        // else {
        //     // Insert Begins
    
        //     $action_obj     = $pdo->insert($table, $columns );
        //     // Insert Ends
        // }
        // print_r($action_obj );
        if ($action_obj->status ) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;
    
            if ($demo ) {
                $msg        = 'update';
            } 
            else {
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
       // $unique_id          = $_POST["unique_id"];

       $update_where       = "";
       $table_department = 'department_creation';
       $columns            = [
           "department" => $department,
           "is_active"           => $is_active,
           "unique_id"           => unique_id($prefix)
       ];
       $table_details      = [
           $table_department,
           [
               'COUNT(unique_id) AS count'
           ]
       ];
       $select_where       = ' is_delete = 0 AND department ="' . $department . '"';

       
   $action_obj         = $pdo->select( $table_details, $select_where );
   // print_r( $action_obj );
   if ( $action_obj->status ) {
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
   if ( $data[ 0 ][ 'count' ] ) {
       $msg        = 'already';
   } else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {

       // Insert Begins
          
           $action_obj     = $pdo->insert($table_department,$columns);
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

        $columns            = [
            
        ];
       
        $table_details      = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';

        
    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r( $action_obj );
    if ( $action_obj->status ) {
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
    if ($data[0]['count'] ) {
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

    $columns            = [
        
    ];
   
    $table_details      = [
        "consignee_details_sub",
        [
            'COUNT(form_main_unique_id) AS count'
        ]
    ];
    $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';

    
$action_obj         = $pdo->select($table_details, $select_where );
// print_r( $action_obj );
if ( $action_obj->status ) {
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
if ($data[0]['count'] ) {
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
   
    if($result->status) {
        $s_no = 0;
        $res_array      = $result->data;
        foreach($res_array as $key => $value) {
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

        $columns            = [
            
        ];
       
        $table_details      = [
            "consignee_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';

        
    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r( $action_obj );
    if ( $action_obj->status ) {
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

        $columns            = [
            
        ];
       
        $table_details      = [
            "product_details_sub",
            [
                'COUNT(form_main_unique_id) AS count'
            ]
        ];
        $select_where       = ' is_delete = 0 AND form_main_unique_id ="' . $uni_id . '"';

        
    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r( $action_obj );
    if ( $action_obj->status ) {
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
   
    if($result->status) {
        $s_no = 0;
        $res_array      = $result->data;
        foreach($res_array as $key => $value) {
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
    $search 	 = $_POST['search']['value'];
    $length 	 = $_POST['length'];
    $start 		 = $_POST['start'];
    $draw 		 = $_POST['draw'];
    $limit 		 = $length;

    $data	    = [];

    if ( $length == '-1' ) {
        $limit  = '';
    }

    // Query Variables
    $json_array     = '';
    $columns        = [
        "'' as  s_no",
        'po_num',
        'po_date',
         '(SELECT department FROM department_creation AS dis WHERE dis.unique_id = '.$table.'.department ) AS department',
        'gst_value',
        '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = '.$table.'.executive_name ) AS executive_name',
        'unique_id',
   ];
    $table_details  = [
        $table,
        $columns
   ];
    // $where          = [
    //     'is_delete'     => 0
    //];
    // $order_by       = '';

    $where = " is_delete = '0' ";

    $order_column   = $_POST['order'][0]['column'];
    $order_dir      = $_POST['order'][0]['dir'];

    // Datatable Ordering
    $order_by       = datatable_sorting($order_column, $order_dir, $columns);

    // Datatable Searching
    $search         = datatable_searching($search, $columns);

    if ( $search ) {
        if ( $where ) {
            $where .= ' AND ';
        }

        $where .= $search;
    }

    $sql_function   = 'SQL_CALC_FOUND_ROWS';

    $result         = $pdo->select($table_details,$where,$limit,$start, $order_by, $sql_function );
    $total_records  = total_records();

    if ( $result->status ) {

        $res_array      = $result->data;

        foreach ($res_array as $key => $value ) {
            $value['s_no'] = $sno + 1;
            // $value['state_name'] = disname( $value['state_name'] );
            $value['is_active'] = is_active_show( $value['is_active'] );

            // $btn_view           = btn_view1($folder_name, $value['unique_id'] );
            $btn_update         = btn_update( $folder_name, $value['unique_id'] );
           
            $btn_delete         = btn_delete( $folder_name, $value['unique_id'] );
            $value['unique_id'] = $btn_update.$btn_delete;

            // if ( $value['is_active'] == '1' ) {
            //     $value['is_active']   = 'Active';
            // } else {

            //     $value['is_active']   = 'Inactive';
            // }

            $value['unique_id'] = $btn_update.$btn_delete;
            $data[]             = array_values($value);
            $sno ++;
        }

        $json_array = [
            'draw'				=> intval($draw),
            'recordsTotal' 		=> intval($total_records),
            'recordsFiltered' 	=> intval($total_records),
            'data' 				=> $data,
            'testing'			=> $result->sql
       ];
    } else {
        print_r( $result );
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
    $select_where = 'is_delete = 0 AND form_main_unique_id ="'.$unique_id.'"';
    
    $action_obj         = $pdo->select($table_details,$select_where );
   
     if ($action_obj->status ) {
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

   if($data[0]['count']) {
        $msg = 'stock';
    }else if(($data[0]['count']== 0) && ($msg!='error')) {
    $action_data     = $pdo->update( $table, $columns, $update_where );
    
    if ( $action_data->status ) {
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

    echo json_encode( $json_array );
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
        'item_code'        => $item_code,
        'product'           => $po_name,
        'qty'                   => $qty,
        'unit_price'                 => $unit_price,
        'tax'          => $tax,
        'total_value'              => $total_value,
        'net_value'             => $net_value,
        'no_of_items'             => $no_of_items,
        'form_main_unique_id'   => $form_main_unique_id,
        'unique_id'              => unique_id( $prefix )
   ];

    // check already Exist Or not
    $table_details      = [
        $table_product_details,
        [
            'COUNT(unique_id) AS count'
       ]
   ];
    $select_where       = ' is_delete = 0 AND product ="'.$po_name .'" AND unique_id ="'.$unique_id.'" ';

    // When Update Check without current id
    // if ( $unique_id ) {
    //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
    // }

    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r( $action_obj );
    if ( $action_obj->status ) {
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
    if ( $data[0]['count'] ) {
        $msg        = 'already';
    } else if (($data[0]['count'] == 0 ) && ( $msg != 'error' ) ) {
        // Update Begins
        if ( $unique_id ) {

            unset( $columns['unique_id'] );

            $update_where   = [
                'unique_id'     => $unique_id
           ];

            $action_obj     = $pdo->update($table_product_details, $columns, $update_where );

            // Update Ends
        } else {

            $table_details1      = [
                'product_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where       = ' is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id.'" ';

            $total_record        = $pdo->select( $table_details1, $count_where );
            // print_r( $total_record );

            $data_record       = $total_record->data;
         
           if ($data_record[0]['count'] == $_POST['no_of_po']) {
                $msg        = 'product';
           }
           else{
                // Insert Begins
                $action_obj     = $pdo->insert($table_product_details,$columns);
                $msg        = 'add';
                // Insert Ends

           }
           
            // Insert Ends

            }
            if ($action_obj->status ) {
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
    }

    $json_array   = [
        'status'    => $status,
        'data'      => $data,
        'error'     => $error,
        'msg'       => $msg,
        'sql'       => $sql
   ];

    echo json_encode( $json_array );

    break;

    case 'product_details_datatable':

    // Function Name button prefix
    $btn_edit_delete    = 'product_details';

    // Fetch Data
    $form_main_unique_id = $_POST['form_main_unique_id'];

    // DataTable
    $search 	 = $_POST['search']['value'];

    $length 	 = $_POST['length'];
    $start 		 = $_POST['start'];
    $draw 		 = $_POST['draw'];
    $limit 		 = $length;

    $data	    = [];

    if ( $length == '-1' ) {
        $limit  = '';
    }

    // Query Variables
    $json_array     = '';
    $columns        = [
        '@a:=@a+1 s_no',
        'item_code',
        'product',
        'qty',
        'unit_price',
        'tax',
        'total_value',
        'net_value',
        'unique_id'
   ];

    $table_details  = [
        $table_product_details.' , (SELECT @a:= '.$start.') AS a ',
        $columns
   ];
//     $where          = [
//         'is_active'                     => 1,
//         'is_delete'                     => 0
//    ];

    $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id .'" ';

    // if ( $form_main_unique_id != '' ) {
    // $where = [];
    // $where = ['form_main_unique_id'    => $form_main_unique_id,];
    // }
    $order_by = '';

    $sql_function   = 'SQL_CALC_FOUND_ROWS';

    $result         = $pdo->select( $table_details, $where, $limit, $start, $order_by, $sql_function );
    $total_records  = total_records();

    if ($result->status ) {

        $res_array      = $result->data;

        foreach ($res_array as $key => $value ) {

            $btn_edit               = btn_edit( $btn_edit_delete, $value['unique_id'] );
            $btn_delete             = btn_delete( $btn_edit_delete, $value['unique_id'] );
            $value['unique_id']     = $btn_delete;
            $data[]                 = array_values( $value );

        }

        $json_array = [
            'draw'				=> intval( $draw ),
            'recordsTotal' 		=> intval( $total_records ),
            'recordsFiltered' 	=> intval( $total_records ),
            'data' 				=> $data,
            'testing'			=> $result->sql
       ];
    } else {
        print_r( $result );
    }

    echo json_encode( $json_array );
    break;





    case 'product_details_edit':
    // Fetch Data
    $unique_id  = $_POST['unique_id'];
    $data	    = [];

    // Query Variables
    $json_array     = '';
    $columns        = [
        'item_code',
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

    $result         = $pdo->select( $table_details, $where );

    if ( $result->status ) {

        $json_array = [
            'data' 		=> $result->data[0],
            'status'    => $result->status,
            'sql'       => $result->sql,
            'error'     => $result->error,
            'testing'	=> $result->sql
       ];
    } else {
        print_r( $result );
    }

    echo json_encode( $json_array );
    break;

    case 'product_details_delete':

    $unique_id  = $_POST['unique_id'];

    $columns            = [
        'is_delete'   => 1,
   ];

    $update_where   = [
        'unique_id'     => $unique_id
   ];

    $action_obj     = $pdo->update( $table_product_details, $columns, $update_where );

    if ( $action_obj->status ) {
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

    echo json_encode( $json_array );

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
        'unique_id'              => unique_id( $prefix )
   ];

    // check already Exist Or not
    $table_details      = [
        $table_consignee_details,
        [
            'COUNT(unique_id) AS count'
       ]
   ];
    $select_where       = ' is_delete = 0 AND con_contact_number ="'.$con_contact_number .'"';
    if ($unique_id) {
        $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
    }

    // print_r( $form_main_unique_id_count );
    // When Update Check without current id
    // if ( $unique_id ) {
    //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
    // }

    $action_obj         = $pdo->select( $table_details, $select_where );
    // print_r( $action_obj );
    if ( $action_obj->status ) {
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
    if ($data[0]['count'] ) {
        $msg        = 'already';
    } else if (($data[0]['count']== 0) && ($msg != 'error')) {
        // Update Begins
        if ( $unique_id ) {

            unset($columns['unique_id'] );

            $update_where   = [
                'unique_id'     => $unique_id
           ];

            $action_obj     = $pdo->update($table_consignee_details, $columns, $update_where );

            // Update Ends
        } else {

            $table_details1      = [
                'consignee_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
               ]
           ];
            $count_where       = 'is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id.'" ';

            // print_r( $form_main_unique_id_count );
            // When Update Check without current iassign_qty
            // if ( $unique_id ) {
            //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
            // }

            $total_record        = $pdo->select($table_details1, $count_where );
            // print_r( $total_record );

            $data_record       = $total_record->data;

            if ($data_record[0]['count'] == $_POST['no_of_consignee']) {
                            $msg        = 'e_already';
                       }
                       else{
                           // Insert Begins
                            $action_obj     = $pdo->insert($table_consignee_details,$columns);
                            $msg        = 'add';
                            // Insert Ends
            
                       }
           
        }

        if ( $action_obj->status ) {
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
    }

    $json_array   = [
        'status'    => $status,
        'data'      => $data,
        'error'     => $error,
        'msg'       => $msg,
        'sql'       => $sql

   ];

    echo json_encode( $json_array );

    break;

    case 'consignee_details_datatable':
    // Function Name button prefix
    $btn_edit_delete    = 'consignee_details';

    // Fetch Data
    $form_main_unique_id = $_POST['form_main_unique_id'];

    // DataTable
    $search 	 = $_POST['search']['value'];

    $length 	 = $_POST['length'];
    $start 		 = $_POST['start'];
    $draw 		 = $_POST['draw'];
    $limit 		 = $length;

    $data	    = [];

    if ( $length == '-1' ) {
        $limit  = '';
    }

    // Query Variables
    $json_array     = '';
    $columns        = [
        '@a:=@a+1 s_no',
        // 'no_of_consignee',
        // 'con_qty',
        'con_address',
        "(select district_name from district_creation WHERE district_creation.unique_id=$table_consignee_details.con_district)as district_name",
        'con_pincode',
        'con_contact_name',
        'con_contact_number',
        'unique_id'
   ];
    $table_details  = [
        $table_consignee_details.' , (SELECT @a:= '.$start.') AS a ',
        $columns
   ];
    $where          = [
        'is_active'                     => 1,
        'is_delete'                     => 0,
   ];

    // $where = [];
    $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id .'" ';
    $order_by = '';

    $sql_function   = 'SQL_CALC_FOUND_ROWS';

    $result         = $pdo->select( $table_details, $where, $limit, $start, $order_by, $sql_function );
    $total_records  = total_records();

    if ( $result->status ) {

        $res_array      = $result->data;

        foreach ( $res_array as $key => $value ) {

            $btn_edit               = btn_edit( $btn_edit_delete, $value['unique_id'] );
            $btn_delete             = btn_delete( $btn_edit_delete, $value['unique_id'] );
            $value['unique_id']     = $btn_delete;
            $data[]                 = array_values( $value );

        }

        $json_array = [
            'draw'				=> intval( $draw ),
            'recordsTotal' 		=> intval( $total_records ),
            'recordsFiltered' 	=> intval( $total_records ),
            'data' 				=> $data,
            'testing'			=> $result->sql
       ];
    } else {
        print_r( $result );
    }

    echo json_encode( $json_array );
    break;

    case 'consignee_details_edit':
    // Fetch Data
    $unique_id  = $_POST['unique_id'];
    $data	    = [];

    // Query Variables
    $json_array     = '';
    $columns        = [
        'item_code',
        'product',
        // 'qty',
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

    $result         = $pdo->select( $table_details, $where );

    if ( $result->status ) {

        $json_array = [
            'data' 		=> $result->data[0],
            'status'    => $result->status,
            'sql'       => $result->sql,
            'error'     => $result->error,
            'testing'	=> $result->sql
       ];
    } else {
        print_r( $result );
    }

    echo json_encode( $json_array );
    break;



    case 'consignee_details_delete':

    $unique_id  = $_POST['unique_id'];

    $columns            = [
        'is_delete'   => 1,
   ];

    $update_where   = [
        'unique_id'     => $unique_id
   ];

    $action_obj     = $pdo->update( $table_consignee_details, $columns, $update_where );

    if ( $action_obj->status ) {
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

    echo json_encode( $json_array );

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
        'po_unique_id'  =>$po_unique_id,
        'product_unique_id'  =>$product_unique_id_val,

        // 'po_product_assign_id'  =>$po_product_assign_id,
        'is_active'           => 1,
        'unique_id'           => unique_id( $prefix )
   ];
    $po_product_assign_details = 'po_product_assign_details';
    // Update Begins
    if($unique_id) {

        // unset( $columns['unique_id'] );

        $update_where   = [
            'unique_id' => $unique_id,
       ];

        $action_obj     = $pdo->update($po_product_assign_details, $columns, $update_where );

        // Update Ends
    } else {
        // Insert Begins

        $action_obj     = $pdo->insert($po_product_assign_details, $columns );
        // Insert Ends
    }

    if ($action_obj->status ) {
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

    $json_array   = [
        'status'    => $status,
        'data'      => $data,
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
            "po_unique_id"
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
   
    if($result->status) {
        $s_no = 0;
        $res_array      = $result->data;
        foreach($res_array as $key => $value) {
           
        $data   .= '<div class="col-12">
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">'.$value['con_contact_name'].'</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Contact</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">'.$value['con_contact_number'].'</div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Address</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">'.$value['con_address'].'</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Consignee
                                Landline</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-7">'.$value['con_lan_num'].'</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                <div class="table-responsive mb-4">
                    <form class="was-validated po_delivery_form" autocomplete="off">
                        <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
                            <thead class="table-light">
                                <tr>
                                <th>S.No</th>
                                <th scope="col">Item Code</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Assign QTY</th>
                            </tr>
                            </thead>
                            <tbody>';
                               
                                $product_display_options   = assign_qty($value['main_unique_id'], $value['con_unique_id'] );

                                    foreach ($product_display_options as $key => $form_val ) {
                                        if(($form_val['con_unique_id'] == '' ) && ($form_val['con_count'] == 0 ) ) {
                                            // echo 'hi';
                                          $table_product_details      =  'product_details_sub';
                                            $where1 = "form_main_unique_id = '".$value['main_unique_id']."' AND is_delete = 0";
                                            $columns1    = [
                                                'item_code',
                                                'product',
                                                'qty',
                                                'assign_qty',
                                                'form_main_unique_id',
                                                'unit_price',
                                                'tax',
                                                'unique_id',
                                           ];

                                            $table_details1   = [
                                                $table_product_details,
                                                $columns1
                                           ];

                                        }else {
                                            // echo 'hello';
                                          $table_assign_details      =  'po_product_assign_details';
                                            $where1 = "form_main_unique_id = '".$value['main_unique_id']."' AND con_unique_id = '".$form_val['con_unique_id']."'";
                                            $columns1    = [
                                                'item_code',
                                                'product',
                                                'qty',
                                                'assign_qty',
                                                'form_main_unique_id',
                                                'unit_price',
                                                'unique_id',
                                                'product_unique_id',
                                                'item_tax'
                                           ];

                                            $table_details1   = [
                                              $table_assign_details,
                                            $columns1
                                           ];
                                        }

                                        $values_product  = $pdo->select($table_details1, $where1 );
                                        //  print_r( $values_product );
                                        if($values_product->status ) {
                                            $product_array      = $values_product->data;
                                            
                                            foreach($product_array as $key => $product) {
                                                 $s_no= $s_no+1;
                                              
                                                if($value['con_unique_id'] != '' ) { 
                                                    
                                                    $data .= '<tr>
                                                        <td>'.$s_no.'</td>
                                                        <td>'.$product['item_code'].'</td>
                                                        <td>'.$product['product'].'</td>
                                                        <td>
                                                            <div class="">';
                                                                if ($product['product_unique_id']) {
                                                                    $data .= '<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                        class="form-control" value="'.$product['product_unique_id'].'">';
                                                                } else {
                                                                    $data .='<input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                                                    class="form-control" value="'.$product['unique_id'].'">';
                                                                }
                                                                $data .= '<input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                    class="form-control" value="'.$product['form_main_unique_id'].'">
                                                                    <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                    class="form-control" value="'.$value['con_unique_id'].'">
                                                                    <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                    class="form-control" value="'.$value['po_unique_id'].'">

                                                                    <input type="hidden" id="con_name" name="con_name[]"
                                                                    class="form-control" value="'.$value['con_contact_name'].'">
                                                                    <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                    class="form-control" value="'.$value['con_contact_number'].'">
                                                                    <input type="hidden" id="item_code" name="item_code[]"
                                                                    class="form-control" value="'.$product['item_code'].'">
                                                                    <input type="hidden" id="item_name" name="item_name[]"
                                                                    class="form-control" value="'.$product['product'].'">

                                                                    <input type="hidden" id="unit_price" name="unit_price[]"
                                                                    class="form-control" value="'.$product['unit_price'].'">
                                                                    
                                                                     <input type="hidden" id="qty" name="qty[]"
                                                                    class="form-control"  value="'.$product['qty'].'">

                                                                    <input type="hidden" id="tax" name="tax[]"
                                                                    class="form-control" value="'.$product['item_tax'].'">';
                                                               
                                                                    $data .= '<input type="text" id="bill_qty" name="bill_qty[]" onkeyup="get_qty()" class="form-control" value="'.$product['assign_qty'].'">
                                                                      <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]"></label>';
                                                            $data .= '</div>';
                                                                $data .= '</div>
                                                        </td>
                                                    </tr>';
                                                }else {
                                                    $data .= '<tr>
                                                        <td>'.$s_no.'</td>
                                                        <td>'.$product['item_code'].'</td>
                                                        <td>'.$product['product'].'</td>
                                                        <td>
                                                            <div class="">
                                                                <input type="hidden" id="product_unique_id" name="product_unique_id[]"
                                                                class="form-control" value="'.$product['product_unique_id'].'">
                                                            
                                                                <input type="hidden" id="main_unique_id" name="main_unique_id"
                                                                class="form-control" value="'.$product['form_main_unique_id'].'">
                                                                <input type="hidden" id="con_unique_id" name="con_unique_id[]"
                                                                class="form-control" value="'.$value['con_unique_id'].'">
                                                                <input type="hidden" id="po_unique_id" name="po_unique_id"
                                                                class="form-control" value="'.$value['po_unique_id'].'">
                                                                <input type="hidden" id="con_name" name="con_name[]"
                                                                    class="form-control" value="'.$value['con_contact_name'].'">
                                                                <input type="hidden" id="con_contact_no" name="con_contact_no[]"
                                                                    class="form-control" value="'.$value['con_contact_number'].'">
                                                                <input type="hidden" id="item_code" name="item_code[]"
                                                                    class="form-control" value="'.$product['item_code'].'">
                                                                <input type="hidden" id="item_name" name="item_name[]"
                                                                    class="form-control" value="'.$product['product'].'">

                                                                <input type="hidden" id="unit_price" name="unit_price[]"
                                                                    class="form-control" value="'.$product['unit_price'].'">
                                                                <input type="hidden" id="tax" name="tax[]"
                                                                    class="form-control" value="'.$product['tax'].'">
                                                                    
                                                                      <input type="hidden" id="qty" name="qty[]"
                                                                    class="form-control"  value="'.$product['qty'].'">';

                                                    
                                                                $data .= '<input type="text" id="bill_qty" name="bill_qty[]" onkeyup="get_qty(qty.value,bill_qty.value)"
                                                                    class="form-control">
                                                                    <label style="color :red; font-weight : bold;" id="max_limit" name="max_limit[]"></label>';

                                                $data .= '</div>';

                                                    $data .= '</div>
                                            </td>
                                        </tr>';
                                                    
                                                }
                                            }
                                            
                                        }
                                    }
                                // }
                            $data .= '</tbody>
                        </table>
                    </div>
                                
               </form>
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

    default:
        
break;

}


     
        function po_no_get() {
            $date = date( 'Y' );
            $st_date = substr( $date, 2 );
            $month = date( 'm' );
            $datee = $st_date . $month;
            $servername = 'localhost';
            $username = project_env('APP_DB_USERNAME', 'root');
            $password = '';
            $database_name = 'aed_elcot';

            try {
                $conn = new PDO( "mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password );
                // set the PDO error mode to exception
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                //echo 'Connected successfully';
            } catch ( PDOException $e ) {
                // echo 'Connection failed: ' . $e->getMessage();
            }
            $stmt = $conn->query( "SELECT * FROM po_form where `po_unique_id` LIKE 'PO%' order by unique_id desc" );
            // $bill = $stmt->fetch();
            // $res_array = $bill['id'];
            // $result = $res_array + 1;

            // if ( $res1 = $stmt->fetch( $stmt ) )
            if ( $res1 = $stmt->fetch() ) {
                $pur_array = explode( '-', $res1['po_unique_id'] );

                $year1 = $pur_array[1];
                $year2 = substr( $year1, 0, 2 );
                $year = '20' . $year2;
                $booking_no = $pur_array[2];
                // print_r( $booking_no );
            }
            if ( $booking_no == '' )
            $booking_nos = 'PO-' . $datee . '-0001';
            elseif ( $year != date( 'Y' ) )
            $booking_nos = 'PO-' . $datee . '-0001';
            else {
                $booking_no += 1;
                $booking_nos = 'PO-' . $datee . '-' . str_pad( $booking_no, 4, '0', STR_PAD_LEFT );
            }

            return $booking_nos;
        }

        // po product assign po num generate

        function product_assign_po_no_get() {
            // $date = date( 'Y' );
            // $st_date = substr( $date, 2 );
            // $month = date( 'm' );
            // $datee = $st_date . $month;
            $servername = 'localhost';
            $username = project_env('ELCOT_DB_USERNAME');
            $password = project_env('ELCOT_DB_PASSWORD');
            $database_name = 'aed_elcot';

            try {
                $conn = new PDO( "mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password );
                // set the PDO error mode to exception
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                //echo 'Connected successfully';
            } catch ( PDOException $e ) {
                // echo 'Connection failed: ' . $e->getMessage();
            }
            $stmt = $conn->query( "SELECT * FROM po_product_assign_details where `po_unique_id` LIKE '".$_POST['po_unique_id']."' order by unique_id desc" );
            // $bill = $stmt->fetch();
            // $res_array = $bill['id'];
            // $result = $res_array + 1;

            // if ( $res1 = $stmt->fetch( $stmt ) )
            if ( $res1 = $stmt->fetch() ) {

                $pur_array = $res1['po_unique_id'];

                // $year1 = $pur_array[1];
                // $year2 = substr( $year1, 0, 2 );
                // $year = '20' . $year2;
                // $booking_no = $pur_array[2];
                // print_r( $booking_no );
            }
            if ( $pur_array == '' )
            $pur_arrays = $_POST['po_unique_id'].'-0001';
            // elseif ( $year != date( 'Y' ) )
            //     $pur_arrays = 'PO-' . $datee . '-0001';
            else {
                $pur_array += 1;
                $pur_arrays = $_POST['po_unique_id']. '-' . str_pad( $pur_array, 4, '0', STR_PAD_LEFT );
            }

            return $pur_arrays;
        }


 
        ?>

    


