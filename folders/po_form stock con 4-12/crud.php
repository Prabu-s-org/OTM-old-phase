<?php
require_once __DIR__ . '/../../config/env.php';

// Get folder Name From Currnent Url
$folder_name        = explode( '/', $_SERVER[ 'PHP_SELF' ] );
$folder_name        = $folder_name[ count( $folder_name )-2 ];

// Database Country Table Name
$table             = 'po_form';
$table_product_details = 'product_details_sub';
$table_consignee_details = 'consignee_details_sub';

// Include DB file and Common Functions
include '../../config/dbconfig.php';
// File Upload Library Call

$fileUploadPath = $fileUploadConfig->get( 'upload_folder' );

// Create Folder in root->uploads->( this_folder_name ) Before using this file upload
$fileUploadConfig->set( 'upload_folder', $fileUploadPath. $folder_name . DIRECTORY_SEPARATOR );
// $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
$fileUpload         = new Alirdn\SecureUPload\SecureUPload( $fileUploadConfig );
// Variables Declaration
$action             = $_POST[ 'action' ];
$action_obj         = ( object ) [
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

switch ( $action ) {
    case 'createupdate':

    $po_num          = $_POST[ 'po_num' ];
    $po_date    = $_POST[ 'po_date' ];
    $department          = $_POST[ 'department' ];
    $gst_option          = $_POST[ 'gst_option' ];
    $gst_value          = $_POST[ 'gst_value' ];
    $executive_name    = $_POST[ 'executive_name' ];
    $bill_address          = $_POST[ 'bill_address' ];
    $contact_name          = $_POST[ 'contact_name' ];
    $contact_number          = $_POST[ 'contact_number' ];
    $email    = $_POST[ 'email' ];
    $district          = $_POST[ 'district' ];
    $pin          = $_POST[ 'pin' ];
    $po_prepared_by          = $_POST[ 'po_prepared_by' ];
    $po_type    = $_POST[ 'po_type' ];
    $no_of_po          = $_POST[ 'no_of_po' ];
    $delivery_due_dates          = $_POST[ 'delivery_due_dates' ];
    $ld_per_day          = $_POST[ 'ld_per_day' ];
    $ld_maximum_val    = $_POST[ 'ld_maximum_val' ];
    $warranty          = $_POST[ 'warranty' ];
    $warranty_duration    = $_POST[ 'warranty_duration' ];
    $exampleCheck1          = $_POST[ 'exampleCheck1' ];
    $exampleCheck2          = $_POST[ 'exampleCheck2' ];
    $bg          = $_POST[ 'bg' ];
    $bg_month    = $_POST[ 'bg_month' ];
    $no_of_consignee    = $_POST['no_of_consignee' ];
    $unique_id          = $_POST['unique_id' ];
    $m_unique_id = $_POST['m_unique_id' ];
    $po_unique_id = $_POST['po_unique_id'];

        // $po_unique_id = po_no_get();
    if ( $gst_option == 'yes' ) {
        $gst_value1 = $gst_value;
    } else if ( $gst_option  == 'no' ) {
        $gst_value1 = '';
    }

    if ($unique_id == '' ) {
        $ids = $m_unique_id;
    } else if ($unique_id  != '' ) {
        $ids = $unique_id;
    }

    $allowedExts = array( 'pdf' );
    $extension = pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION );

    if ( $_FILES['file']['type'] == 'application/pdf' ) {
        $file_exp = explode( '.', $_FILES['file']['name'] );
        $tem_name =  random_strings( 25 ).'.'.$file_exp[ 1 ];

        move_uploaded_file( $_FILES['file']['tmp_name'], '../../uploads/po_form/po_attach/' . $tem_name );
    }
    if ( !empty( $_FILES['file']['name'] ) ) {
        $file_names     = $tem_name;
        $file_org_names = $_FILES['file']['name'];
    }

    // if ( is_array( $_FILES[ 'file' ][ 'name' ] ) ) {
    //     if ( $_FILES[ 'file' ][ 'name' ][ 0 ] != '' ) {
    // // Multi file Upload
    //     $confirm_upload     = $fileUpload->uploadFiles( 'file' );
    //         if ( is_array( $confirm_upload ) ) {
    //             $_FILES[ 'file' ][ 'file_name' ] = [];
    //                 foreach ( $confirm_upload as $c_key => $c_value ) {
    //                     if ( $c_value->status == 1 ) {
    //                          $c_file_name = $c_value->name ? $c_value->name.'.'.$c_value->ext : '';
    //                         array_push( $_FILES[ 'file' ][ 'file_name' ], $c_file_name );
    //                     } else {
    // if Any Error Occured in File Upload Stop the loop
    //                         $status     = $confirm_upload->status;
    //                         $data       = 'file not uploaded';
    //                         $error      = $confirm_upload->error;
    //                         $sql        = 'file upload error';
    //                         $msg        = 'file_error';
    //                         break;
    //                     }
    //                 }

    //         } else if ( !empty( $_FILES[ 'file' ][ 'name' ] ) ) {
    // Single File Upload
    //             // if ( ( $_FILES[ 'file' ][ 'type' ] != 'jpeg' ) )

    //             $confirm_upload     = $fileUpload->uploadFile( 'file' );

    //             if ( $confirm_upload->status == 1 ) {
    //                 $c_file_name = $confirm_upload->name ? $confirm_upload->name.'.'.$confirm_upload->ext : '';
    //                 $_FILES[ 'file' ][ 'file_name' ]  = $c_file_name;
    //             } else {
    // if Any Error Occured in File Upload Stop the loop
    //                 $status     = $confirm_upload->status;
    //                 $data       = 'file not uploaded';
    //                 $error      = $confirm_upload->error;
    //                 $sql        = 'file upload error';
    //                 $msg        = 'file_error';
    //             }

    //         }
    //     }
    // }

    // if ( is_array( $_FILES[ 'file' ][ 'name' ] ) ) {
    //     if ( $_FILES[ 'file' ][ 'name' ][ 0 ] != '' ) {
    //         $file_names     = implode( ',', $_FILES[ 'file' ][ 'file_name' ] );
    //         $file_org_names = implode( ',', $_FILES[ 'file' ][ 'name' ] );
    //     }

    // } else if ( !empty( $_FILES[ 'file' ][ 'name' ] ) ) {
    //     $file_names     = $_FILES[ 'file' ][ 'file_name' ];
    //     $file_org_names = $_FILES[ 'file' ][ 'name' ];
    // }

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
        'delivery_due_dates'           => $delivery_due_dates,
        'ld_per_day'     => $ld_per_day,
        'ld_maximum_val'           => $ld_maximum_val,
        'warranty'           => $warranty,
        'warranty_duration'     => $warranty_duration,
        'exampleCheck1'           => $exampleCheck1,
        'exampleCheck2'           => $exampleCheck2,
        'bg'     => $bg,
        'bg_month'           => $bg_month,
        'file_name'           => $file_names,
        'file_org_name'           => $file_org_names,
        'no_of_consignee'           =>$no_of_consignee,
        'po_unique_id' => $po_unique_id,
        'unique_id'           =>$ids
    ];

    // Update Begins
    if ($unique_id ) {

        unset( $columns[ 'unique_id' ] );

        $update_where   = [
            'unique_id'     => $unique_id
        ];

        $action_obj     = $pdo->update( $table, $columns, $update_where );

        // Update Ends
    } else {
        // Insert Begins

        $action_obj     = $pdo->insert( $table, $columns );
        // Insert Ends
    }
    // print_r( $action_obj );
    if ( $action_obj->status ) {
        $status     = $action_obj->status;
        $data       = $action_obj->data;
        $error      = '';
        $sql        = $action_obj->sql;

        if ( $unique_id ) {
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

    echo json_encode( $json_array );

    break;

    case 'datatable':
    // DataTable Variables
    $search 	 = $_POST[ 'search' ][ 'value' ];
    $length 	 = $_POST[ 'length' ];
    $start 		 = $_POST[ 'start' ];
    $draw 		 = $_POST[ 'draw' ];
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
        'department',
        'gst_value',
        '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = '.$table.'.executive_name ) AS executive_name',
        'unique_id'
    ];
    $table_details  = [
        $table,
        $columns
    ];
    // $where          = [
    //     'is_delete'     => 0
    // ];
    // $order_by       = '';

    $where = " is_delete = '0' ";

    $order_column   = $_POST[ 'order' ][ 0 ][ 'column' ];
    $order_dir      = $_POST[ 'order' ][ 0 ][ 'dir' ];

    // Datatable Ordering
    $order_by       = datatable_sorting( $order_column, $order_dir, $columns );

    // Datatable Searching
    $search         = datatable_searching( $search, $columns );

    if ( $search ) {
        if ( $where ) {
            $where .= ' AND ';
        }

        $where .= $search;
    }

    $sql_function   = 'SQL_CALC_FOUND_ROWS';

    $result         = $pdo->select( $table_details, $where, $limit, $start, $order_by, $sql_function );
    $total_records  = total_records();

    if ( $result->status ) {

        $res_array      = $result->data;

        foreach ( $res_array as $key => $value ) {
            $value[ 's_no' ] = $sno + 1;
            $value[ 'state_name' ] = disname($value['state_name']);
            $value[ 'is_active' ] = is_active_show($value['is_active']);

            $btn_view           = btn_view1($folder_name, $value['unique_id']);
            $btn_update         = btn_update($folder_name, $value['unique_id']);
            $btn_delete         = btn_delete($folder_name, $value['unique_id']);
            $value['unique_id'] = $btn_view.$btn_update.$btn_delete;


            // if ( $value[ 'is_active' ] == '1' ) {
            //     $value[ 'is_active' ]   = 'Active';
            // } else {

            //     $value[ 'is_active' ]   = 'Inactive';
            // }

            $value[ 'unique_id' ] = $btn_view.$btn_update.$btn_delete;
            $data[]             = array_values( $value );
            $sno ++;
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

    case 'delete':

    $unique_id      = $_POST[ 'unique_id' ];

    $columns        = [
        'is_delete'   => 1
    ];

    $update_where   = [
        'unique_id'     => $unique_id
    ];

    $action_obj     = $pdo->update( $table, $columns, $update_where );

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

    //  case 'user_type_options':

    // $user_type          = $_POST[ 'user_type' ];

    // $user_type_options  = under_user_type( $user_type );

    // $user_type_options  = select_option( $user_type_options, 'Select' );

    // echo $user_type_options;

    // break;
    // product details

    case 'product_details_add_update':

    $item_code          = $_POST[ 'item_code' ];
    $po_name              = $_POST[ 'po_name' ];
    $qty            = $_POST[ 'qty' ];
    $unit_price     = $_POST[ 'unit_price' ];
    $tax         = $_POST[ 'tax' ];
    $total_value            = $_POST[ 'total_value' ];
    $net_value              = $_POST[ 'net_value' ];
    $form_main_unique_id       = $_POST[ 'form_main_unique_id' ];

    $unique_id             = $_POST[ 'unique_id' ];
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
    if ( $data[ 0 ][ 'count' ] ) {
        $msg        = 'already';
    } else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {
        // Update Begins
        if ( $unique_id ) {

            unset( $columns[ 'unique_id' ] );

            $update_where   = [
                'unique_id'     => $unique_id
            ];

            $action_obj     = $pdo->update( $table_product_details, $columns, $update_where );

            // Update Ends
        } else {

            // Insert Begins
            $action_obj     = $pdo->insert( $table_product_details, $columns );
            // Insert Ends

        }

        if ( $action_obj->status ) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;

            if ( $unique_id ) {
                $msg        = 'update';
            } else {
                $msg        = 'add';
            }
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
    $form_main_unique_id = $_POST[ 'form_main_unique_id' ];

    // DataTable
    $search 	 = $_POST[ 'search' ][ 'value' ];

    $length 	 = $_POST[ 'length' ];
    $start 		 = $_POST[ 'start' ];
    $draw 		 = $_POST[ 'draw' ];
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
    $where          = [
        'is_active'                     => 1,
        'is_delete'                     => 0
    ];

    $where = 'is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id .'" ';


    // if ( $form_main_unique_id != '' ) {
    // $where = [];
    // $where = [ 'form_main_unique_id'    => $form_main_unique_id, ];
    // }
    $order_by = '';

    $sql_function   = 'SQL_CALC_FOUND_ROWS';

    $result         = $pdo->select( $table_details, $where, $limit, $start, $order_by, $sql_function );
    $total_records  = total_records();

    if ( $result->status ) {

        $res_array      = $result->data;

        foreach ( $res_array as $key => $value ) {

            $btn_edit               = btn_edit( $btn_edit_delete, $value[ 'unique_id' ] );
            $btn_delete             = btn_delete( $btn_edit_delete, $value[ 'unique_id' ] );
            $value[ 'unique_id' ]     = $btn_delete;
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
    $unique_id  = $_POST[ 'unique_id' ];
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
            'data' 		=> $result->data[ 0 ],
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

    $unique_id  = $_POST[ 'unique_id' ];

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

    $no_of_consignee          = $_POST[ 'no_of_consignee' ];
    // $con_qty              = $_POST[ 'con_qty' ];
    $con_address            = $_POST[ 'con_address' ];
    $con_district     = $_POST[ 'con_district' ];
    $con_pincode         = $_POST[ 'con_pincode' ];
    $con_contact_name            = $_POST[ 'con_contact_name' ];
    $con_contact_number              = $_POST[ 'con_contact_number' ];
    $con_lan_num              = $_POST[ 'con_lan_num' ];
    $form_main_unique_id       = $_POST[ 'form_main_unique_id' ];

    $unique_id             = $_POST[ 'unique_id' ];
    $update_where          = '';
    // print_r( 'hii'.$con_con_address );
    $columns            = [
        'no_of_consignee'        => $no_of_consignee,
        // 'con_qty'           => $con_qty,
        'con_address'                   => $con_address,
        'con_district'                 => $con_district,
        'con_pincode'          => $con_pincode,
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
    if ( $data[ 0 ][ 'count' ] ) {
        $msg        = 'already';
    } else if ( ( $data[ 0 ][ 'count' ] == 0 ) && ( $msg != 'error' ) ) {
        // Update Begins
        if ( $unique_id ) {

            unset( $columns[ 'unique_id' ] );

            $update_where   = [
                'unique_id'     => $unique_id
            ];

            $action_obj     = $pdo->update( $table_consignee_details, $columns, $update_where );

            // Update Ends
        } else {

            $table_details1      = [
                'consignee_details_sub',
                [
                    'COUNT(form_main_unique_id) AS count'
                ]
            ];
            $count_where       = ' is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id .'" ';

            // print_r( $form_main_unique_id_count );
            // When Update Check without current id
            // if ( $unique_id ) {
            //     $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
            // }

            $total_record        = $pdo->select( $table_details1, $count_where );
            // print_r( $total_record );

            $data_record       = $total_record->data;

            // print( $data_record[ 0 ][ 'count' ] );

            if ( $data_record[ 0 ][ 'count' ] <= $_POST[ 'no_of_consignee' ] ) {
                // print_r($_POST[ 'no_of_consignee' ]);
                // Insert Begins
                $action_obj     = $pdo->insert( $table_consignee_details, $columns );
                // Insert Ends

            }
            // else {
            //     $msg = 'alreadys';
            // }

        }

        if ( $action_obj->status ) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = '';
            $sql        = $action_obj->sql;

            if ( $data_record[ 0 ][ 'count' ] <= $_POST[ 'no_of_consignee' ] ) {
                $msg        = 'add';
            } else {
                $msg        = 'already';
            }
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
    $form_main_unique_id = $_POST[ 'form_main_unique_id' ];

    // DataTable
    $search 	 = $_POST[ 'search' ][ 'value' ];

    $length 	 = $_POST[ 'length' ];
    $start 		 = $_POST[ 'start' ];
    $draw 		 = $_POST[ 'draw' ];
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
        'con_district',
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

            $btn_edit               = btn_edit( $btn_edit_delete, $value[ 'unique_id' ] );
            $btn_delete             = btn_delete( $btn_edit_delete, $value[ 'unique_id' ] );
            $value[ 'unique_id' ]     = $btn_delete;
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
    $unique_id  = $_POST[ 'unique_id' ];
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
            'data' 		=> $result->data[ 0 ],
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

        $main_unique_id          = $_POST["main_unique_id"];
        $act_qty          = $_POST["act_qty"];
        $item_code    = $_POST["item_code"];
        $item_name          = $_POST["item_name"];
      
        $unique_id          = $_POST["unique_id"];
       
        // $po_product_assign_id = po_no_get();

        $update_where       = "";

        $columns            = [
        
            "actual_qty"  =>$act_qty,
        
        ];
        $product_details_sub = 'product_details_sub';
        // if()
        // Update Begins
        if($main_unique_id) {

            // unset($columns['unique_id']);

            $update_where   = [
                "form_main_unique_id"     => $main_unique_id,
                "item_code"                => $item_code,
                "product"                => $item_name,
            ];

            $action_obj     = $pdo->update($product_details_sub,$columns,$update_where);
// print_r($action_obj);
        // Update Ends
        } else {
        // Insert Begins
           
            $action_obj     = $pdo->insert($product_details_sub,$columns);
        // Insert Ends
        }

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = "update";
            } else {
                $msg        = "create";
            }
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
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team"

    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM po_form where `po_unique_id` LIKE 'PO%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;


    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['po_unique_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($booking_no == '')
        $booking_nos = 'PO-' . $datee . '-0001';
    elseif ($year != date("Y"))
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
    // $date = date("Y");
    // $st_date = substr($date, 2);
    // $month = date("m");
    // $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team"

    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . project_env('SERVICE_INSTALL_DB_NAME', 'aed_elcot') . "", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM po_product_assign_details where `po_unique_id` LIKE '".$_POST['po_unique_id']."' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;


    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {

        $pur_array = $res1['po_unique_id'];

        // $year1 = $pur_array[1];
        // $year2 = substr($year1, 0, 2);
        // $year = '20' . $year2;
        // $booking_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($pur_array == '')
        $pur_arrays = $_POST['po_unique_id'].'-0001';
    // elseif ($year != date("Y"))
    //     $pur_arrays = 'PO-' . $datee . '-0001';
    else {
        $pur_array += 1;
        $pur_arrays = $_POST['po_unique_id']. '-' . str_pad($pur_array, 4, '0', STR_PAD_LEFT);
    }

    return $pur_arrays;
}

?>

