<?php
require_once __DIR__ . '/../../config/env.php'; 

// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table_com = "view_stock_completed_list";
$table             = "view_stock_position_list";
$table_po = "po_form";
$table1 = "stock_position_main";
$table2 = "stock_position";
$table3 = "stock_position_main";
$table4 = "invoice_creation_main";

// $table_dependent_details = "view_stock_position_list";

// Include DB file and Common Functions
include '../../config/dbconfig.php';
// include 'function.php';

// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$user_type          = "";
$is_active          = "";
$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

switch ($action) {
    case 'table_stock_position_pending':
        // Function Name button prefix
        $btn_edit_delete    = "table_stock_position_pending";
        
        // Fetch Data
        $staff_unique_id = $_POST['staff_unique_id']; 

        // DataTable 
		$search 	= $_POST['search']['value'];    
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            // "@a:=@a+1 s_no",
            "'' as  s_no",
            "po_unique_id",
            "po_date",
            "department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name ) AS executive_name",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            "unique_id"
        ];
        $table_details  = [
            $table_dependent_details." , (SELECT @a:= ".$start.") AS a ",
            $columns
        ];
        // $where          = [
        //     "staff_unique_id"    => $staff_unique_id,
        //     "is_active"                     => 1,
        //     "is_delete"                     => 0
        // ];
        $where = " is_delete = '0' ";

        $order_by = "";
        
        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
        // print_r('hi'.$result);die();
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;

                $orgDate = $value['po_date'];  
                $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                $btn_update               = btn_edit($btn_edit_delete,$value['unique_id']);
                $btn_delete             = btn_delete($btn_edit_delete,$value['unique_id']);

                $value['unique_id']     = $btn_update;
                $data[]                 = array_values($value);
                $sno ++;

                 
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
        
        
        
        // stock processing
        
        case 'stock_position_processing_datatable':
            // print_r('hi');
        // Function Name button prefix
        $btn_edit_delete    = "table_stock_position_processing";
        
        // Fetch Data
        $staff_unique_id = $_POST['staff_unique_id']; 

        // DataTable 
		$search 	= $_POST['search']['value'];    
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            // "@a:=@a+1 s_no",
            "'' as  s_no",
            "stock_id",
            "stock_date",
            // "po_unique_id",
            "(SELECT po_unique_id FROM po_form WHERE po_form.unique_id = ".$table1.".form_main_unique_id  and is_delete=0 group by po_form.po_unique_id ) AS po_unique_id",
            "po_date",
            "department",
            "executive_name",
            "no_of_con",
            "no_of_item",
            "stock_qty",
            "stock_value",
            "form_main_unique_id",
            "po_num",
           
        ];
        $table_details  = [
            $table1,
            $columns
        ];
 
        $where = "status = '1'";
        //  $group= 'stock_id';
        $order_by = "";
        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
        // print_r($result);die();
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;
            foreach ($res_array as $key => $value) {
                // print_r($value['unit_price']);
                $value['s_no'] = $sno + 1;

                $stock_value         = $value['stock_value'];
                $value['stock_value']  = moneyFormatIndia1(($stock_value));
                $orgDate = $value['stock_date'];  
                $value['stock_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_unique_id'] = $value['po_num'].' / '.$value['po_unique_id'];
                // $value['unit_price'] = $value['stock_qty']*$value['unit_price'];
                $value['po_date'] = '<span class="po_date">' .$value['po_date']. '</span>';
                
                 $value['form_main_unique_id']     =  '<a href="index.php?file=stock_position/update1&unique_id='.$value['form_main_unique_id'].'"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';
              
                // $value['unique_id']     = $btn_update;
                $data[]                 = array_values($value);
                $sno ++;

                 
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
        
        // stock position processing end 
        
        // complete tab start
       case 'stock_position_complete_datatable':
            // print_r('hi');
        // Function Name button prefix
        $btn_edit_delete    = "table_stock_position_complete";

		$search 	= $_POST['search']['value'];    
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            // "@a:=@a+1 s_no",
            "'' as  s_no",
            "po_num",            
            "po_date",
            "department",
            "executive_name",
            "no_of_con",
            "no_of_item",
            "billed_qty",
            "stock_value",
            // "unique_id",
            //  "stock_qty",
            // "stock_value",
            "form_main_unique_id",
            "po_unique_id",
           
        ];
        $table_details  = [
            $table_com,
            $columns
        ];
 
        $where = "is_delete = '0'";
      
        
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

            // $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
            // $where .= "AND DATE_FORMAT(po_date, '%Y-%m-%d') >= '" . $from_date . "' AND DATE_FORMAT(po_date, '%Y-%m-%d') <= '" . $to_date . "'  ";
            $from_date_converted = date('d-m-Y', strtotime($from_date));
            $to_date_converted = date('d-m-Y', strtotime($to_date));
            $where = "STR_TO_DATE(po_date, '%d-%m-%Y') >= STR_TO_DATE('" . $from_date_converted . "', '%d-%m-%Y') AND STR_TO_DATE(po_date, '%d-%m-%Y') <= STR_TO_DATE('" . $to_date_converted . "', '%d-%m-%Y')";

        }
        //  $group= 'stock_id';
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column,$order_dir,$columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";

        $search         = datatable_searching($search,$columns);


        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }
        // $order_by = "";
        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
        // print_r($result);
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

                $stock_value = $value['stock_value'];
             
                $value['stock_value']  = moneyFormatIndia1(($stock_value));
                // print_r($value['unit_price']);
                // $orgDate = $value['po_date'];  
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                // $value['po_num'] = $value['po_num'];
                // $value['unit_price'] = $value['stock_qty']*$value['unit_price'];
                  $btn_view         = btn_view ($folder_name,$value['form_main_unique_id']); 

                if(in_array('5f88085e1fcea66282', $action_ids)){
                    $value['form_main_unique_id']     =  $btn_view;
                    // '<a href="index.php?file=stock_position/view&unique_id='.$value['form_main_unique_id'].'"><i class="ri-eye-fill align-bottom me-2 text-muted">View</i></a>';
                }
                // else if(in_array('5f8808504271036738', $action_ids)){
                //     $value['unique_id'] = $btn_delete;
                // }
                else{
                    $value['form_main_unique_id'] = '';
                }
                //  $value['form_main_unique_id']     =  '<a href="index.php?file=stock_position/view&unique_id='.$value['form_main_unique_id'].'"><i class="ri-eye-fill align-bottom me-2 text-muted">View</i></a>';
              
                // $value['unique_id']     = $btn_update;
                $data[]                 = array_values($value);
                $sno ++;

                 
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
        // complete tab end

        case 'get_consignee':
        $table_consignee = 'consignee_details_sub';

    	$unique_id  = $_POST['unique_id'];
    	
		$where      = [
			"unique_id" => $unique_id
		];

		$columns    = [
			"form_main_unique_id",
			"con_address",
            "con_contact_name",
            "con_contact_number",
            "unique_id"
		];

		$table_details   = [
			$table_consignee,
			$columns
		];

		$consignee_values  = $pdo->select($table_details, $where);
		// print_r($consignee_values);die();

		if ($consignee_values->status) {

			$consignee_values      = $consignee_values->data;

			$con_address          = $consignee_values[0]["con_address"];
			$con_contact_number    = $consignee_values[0]["con_contact_number"];
		

		$data = array($con_address,$con_contact_number);
		} 
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
		
         echo json_encode($json_array);

        break;
        
            
       
     
    case 'datatable':
        // DataTable Variables
		$search 	= $_POST['search']['value'];
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
            "(SELECT department FROM department_creation WHERE department_creation.unique_id = ".$table.".department) AS department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name) AS executive_name",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            "(select file_name from po_form where unique_id = ".$table.".unique_id AND is_delete=0 group by unique_id) AS file_name",
            "delivery_due_dates",
            "status",
            "unique_id",
            "(select stock_qty from stock_position_main where form_main_unique_id = ".$table.".unique_id AND is_delete=0 group by form_main_unique_id ) AS stock_qty",
            "po_unique_id",
            "product_due_days"

        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";

        // $where = " is_delete = '0' AND status = '0' AND delivery_due_dates!=''";
        // $where = "is_delete = '0' AND 
        //   (SELECT count(form_main_unique_id) FROM product_details_sub AS dis 
        //    WHERE dis.form_main_unique_id = $table.unique_id) != 0 AND 
        //   (SELECT count(form_main_unique_id) FROM consignee_details_sub AS dis 
        //    WHERE dis.form_main_unique_id = $table.unique_id) != 0 AND 
        //   (SELECT count(form_main_unique_id) FROM po_product_assign_details AS dis 
        //    WHERE dis.form_main_unique_id = $table.unique_id) != 0 AND 
        //   delivery_due_dates != ''";
        $where = "is_delete = '0' AND 
          (SELECT count(form_main_unique_id) FROM product_details_sub AS dis 
           WHERE dis.form_main_unique_id = ".$table.".unique_id group by form_main_unique_id) != 0 AND 
          (SELECT count(form_main_unique_id) FROM consignee_details_sub AS dis 
           WHERE dis.form_main_unique_id = ".$table.".unique_id group by form_main_unique_id) != 0 AND 
          (SELECT count(form_main_unique_id) FROM po_product_assign_details AS dis 
           WHERE dis.form_main_unique_id = ".$table.".unique_id group by form_main_unique_id) != 0 AND 
          (SELECT file_name FROM po_form WHERE unique_id = ".$table.".unique_id group by unique_id) != ''";

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

            $where = "po_date>= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
            // $where .= "AND DATE_FORMAT(po_date, '%Y-%m-%d') >= '" . $from_date . "' AND DATE_FORMAT(po_date, '%Y-%m-%d') <= '" . $to_date . "'  ";

        }
        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // $order_by ="status='0' DESC";
        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column,$order_dir,$columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
     


        // Datatable Searching
        $search         = datatable_searching($search,$columns);

        if ($search) {
            if ($where) {
                $where .= "AND ";
            }

            $where .= $search;
        }

        $sql_function   = "SQL_CALC_FOUND_ROWS";
        // $result = $pdo->select($table_details, $where, $limit, $start, 'status=0 DESC ,'. $order_by, $sql_function);

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
        // $result= $pdo->select($table_details, $where, $limit, $start, "status='0' DESC,". $order_by, $sql_function);
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
        // print_r($result);
        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $net_value = $value['net_value'];
                // $orgDate = $value['po_date'];  
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                $value['net_value']  = moneyFormatIndia1(($net_value));
                $file_name =  $value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['unique_id'], $value['file_name']);
                // new changes
                $delivery_due_days = $value['delivery_due_dates'];

                if ($delivery_due_days!="") {
                    $delivery_due_dates = $value['delivery_due_dates'];
                } else {
                    $delivery_due_dates = $value['product_due_days'];
                }
                // end
                
                // print_r(  $delivery_due_dates);
                // Format PO date
                $po_date = $value['po_date']; // Expected format: '2024-12-31'
                $formatted_po_date = date("d-m-Y", strtotime($po_date)); // Convert to 'd-m-Y'
                $value['po_date'] = '<span class="po_date">' . $formatted_po_date . '</span>';
                
                // Create DateTime object from the formatted PO date
                $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($formatted_po_date));
                
                if ($poDate === false) {
                    echo "Invalid PO date format.";
                    return;
                }
                
                // Modify PO date based on delivery due dates
                $poDate->modify('+' . (int)$delivery_due_dates . ' days');
                $resultDate = $poDate->format('d-m-Y');
                
                $currentDate = new DateTime();
                
                if ($poDate < $currentDate) {
                    $value['delivery_due_dates'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
                } else {
                    $value['delivery_due_dates'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
                }
                

                $btn_update         = btn_update($folder_name,$value['unique_id']);
                 $btn_delete         = btn_delete($folder_name,$value['unique_id']); 


                // if($_SESSION['user_type_unique_id'] !='65deef78ba17d65741'){
                //     // echo "hello";
                //                 if($value['stock_count']== $value['no_of_consignee']){
                //                     $btn_update         = '';
                //                     $btn_delete         = '';
                //                 }else{
                //                     $btn_update         = btn_update($folder_name,$value['unique_id']);
                //                     $btn_delete         = btn_delete($folder_name,$value['unique_id']);   
                //                     $value['unique_id'] = $btn_update;                             }
                //             }
                // // $value['is_active'] = is_active_show($value['is_active']);
                // // .' / '.$value['po_unique_id'];
                // if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" ){
                //     $btn_update         = btn_update($folder_name,$value['unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['unique_id']);
                // $value['unique_id'] = $btn_update;
                //   }
                if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                    if($value['stock_count']== $value['no_of_consignee']){
                        $value['unique_id'] = "";
                      }else{
                        // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        //     $value['unique_id'] = $btn_update.$btn_delete;                   
                        // }
                        if(in_array('5f88082b25ec031952', $action_ids)){
                            $value['unique_id'] = $btn_update;
                        }
                        // else if(in_array('5f8808504271036738', $action_ids)){
                        //     $value['unique_id'] = $btn_delete;
                        // }
                        else{
                            $value['unique_id'] = '';
                        }
                      }
                    
                  }
                  if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                    
                    // if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_update.$btn_delete;                   
                    // }
                    // else
                     if(in_array('5f88082b25ec031952', $action_ids)){
                        $value['unique_id'] = $btn_update;
                    }
                    // else if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    //     $value['unique_id'] = $btn_update.$btn_delete;                   
                    // }
                    // else if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    else{
                        $value['unique_id'] = '';
                    }
                  }
    



                $qty=$value['qty'];
                $stok_qty=$value['stock_qty'];
                if ($value['status'] == "0") {
                    $value['status'] = "<span style='color: red;'>Pending</span>";
                }
                
                // else if($value['remaing_qty']!=$value['stock_qty']){
                //     $value['status']   = "Partial Pending";
                // }
                // else if($value['qty']==$value['stock_qty']){
                //     $value['status']   = "Partial Pending";
                // }
                else if($value['status'] == "1") {
                    $value['status'] = "<span style='color: red;'>Partial Pending</span>";
                      
                }
                else {
                    $value['status'] = "<span style='color: red;'>Complete</span>";
                    // $value['status']   = "Complete";
                }

                $value['unique_id'] = $btn_update;
                $data[]             = array_values($value);
                $sno ++;
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
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
            "is_delete"   => 1
        ];

        $update_where   = [
            "unique_id"     => $unique_id
        ];

        $action_obj     = $pdo->update($table,$columns,$update_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            $msg        = "success_delete";

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

        //  case 'user_type_options':

        // $user_type          = $_POST['user_type'];

        // $user_type_options  = under_user_type($user_type);

        // $user_type_options  = select_option($user_type_options,"Select");

        // echo $user_type_options;
        
        // break;

         
        case 'stock_position_create':

            $stock_date          = $_POST["stock_date"];
            $main_unique_id    = $_POST["main_unique_id"];
            $po_date         = $_POST["po_date"];
            $po_num         = $_POST["po_num"];
            $exe_name    = $_POST["exe_name"];
            $no_of_items         = $_POST["no_of_items"];
            $no_of_con          = $_POST["no_of_con"];
            $department    = $_POST["department"];
            $part_no         = $_POST["part_no_val"];
            $item_qty         = $_POST["item_qty"];
            // $total_amount          = $_POST["total_amount"];
            $total_amount          = $_POST["total_amount"];
            $update_total         = $_POST["update_total_amount"];

            $po_auto_id          = $_POST["po_auto_id"];
            $remarks = $_POST["remarks"];
            $unique_id          = $_POST["unique_id"];

            if($_POST["update_stock_qty"]==''){
                $update_stock_qty='0';     
            }
            else{
                $update_stock_qty          = $_POST["update_stock_qty"];
            }
         

            if($unique_id!=''){
               
                $stock_qty= $_POST["stock_qty"] + $update_stock_qty;
            }
            else{
                $stock_qty          = $_POST["stock_qty"];
            }
            $allowedExts = array('jpg', 'jpeg', 'png');
            $extension = pathinfo($_FILES['part_no_file']['name'], PATHINFO_EXTENSION);
            
            if (in_array(strtolower($extension), $allowedExts) && 
                ($_FILES['part_no_file']['type'] == 'image/jpeg' || $_FILES['part_no_file']['type'] == 'image/png')) {
            
                // Generate a random name for the uploaded file with the original extension
                $tem_name = random_strings(25) . '.' . $extension;
            
                move_uploaded_file($_FILES['part_no_file']['tmp_name'], '../../uploads/stock_position/' . $tem_name);
            
                // Set $file_names to the stored filename with the original image extension
                $file_names = $tem_name;
                $file_org_names = $_FILES['part_no_file']['name'];
            } 
//             $update_where       = "";
    

//              // update value
//              if($_POST["update_total_amount"]==''){
//                 $update_total='0';     
//             }
//             else{
//                 $update_total          = $_POST["update_total_amount"];
//             }
         
// // print_r($update_total);
//             if($unique_id!=''){
               
//                 $total_amount = $_POST["total_amount"] + $update_total;
//             }
//             else{
//                 $total_amount          = $_POST["total_amount"];
//             }
            
            $update_where       = "";
    
            if($stock_qty == $item_qty){
                $columns            = [
                "stock_date"           => $stock_date,
                "form_main_unique_id"     => $main_unique_id,
                "po_date"           => $po_date,
                "po_num"           => $po_num,
                "po_unique_id"           => $po_auto_id,   
                "executive_name"     => $exe_name,
                "no_of_item"           => $no_of_items,
                "no_of_con"           => $no_of_con,
                "department"     => $department,
                "stock_qty"           => $stock_qty,
                "stock_value"           => $total_amount,
                'part_no'                 => $part_no ,
                "remarks" => $remarks,
                "part_no_file" => $file_names,
                "part_no_file_orgname" => $file_org_names,
                "status"           => 2,
                'stock_id'              => stock_no_get(),
                "unique_id"           => unique_id($prefix)
                
                ];
            }
    
            else{
            $columns            = [
                "stock_date"           => $stock_date,
                "form_main_unique_id"     => $main_unique_id,
                "po_date"           => $po_date,
                "po_num"           => $po_num,
                "po_unique_id"           => $po_auto_id,
                "executive_name"     => $exe_name,
                "no_of_item"           => $no_of_items,
                "no_of_con"           => $no_of_con,
                "department"     => $department,
                "stock_qty"           => $stock_qty,
                "stock_value"           => $total_amount,
                'part_no'                 => $part_no ,
                "remarks" => $remarks,
                "part_no_file" => $file_names,
                "part_no_file_orgname" => $file_org_names,
                "status"           => 1,
                'stock_id'              => stock_no_get(),
                "unique_id"           => unique_id($prefix)
            ];
        }
    
        if($stock_qty == $item_qty){
            $columns_3            = [
                "status"           => 2,
            ];
               
        }
      else if($stock_qty != $item_qty){
            $columns_3            = [
                "status"           => 1,
            ];            
        }
        // else{
        //     $columns_3            = [
        //         "status"           => 0,
        //     ];
        // }
        $update_where_3      = " unique_id = '".$main_unique_id."'";
    // print_R($update_where_3 );
        $action_obj_3     = $pdo->update($table_po,$columns_3,$update_where_3);
        // print_r( $action_obj_3);die();
    
            // count taken start
            $table_details1      = [
            $table3,
            [
                'COUNT(unique_id) AS count',
                'form_main_unique_id',
                
            ]        
        ];
        $select_where1       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."'";
    
        
        $action_obj1         = $pdo->select($table_details1,$select_where1);
        // print_r($action_obj1);die();
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
    
            if ($data[0]['count'] != 0) {
                $msg        = 'already';
                unset($columns['form_main_unique_id']);
                unset($columns['stock_id']);
    
                $update_where   = [
                    "form_main_unique_id"     => $main_unique_id
                ];
                // unset($columns['unique_id']);
    
                // $update_where   = [
                //     "unique_id"     => $unique_id
                // ];
    
                $action_obj     = $pdo->update($table3,$columns,$update_where);
            }else {
            $action_obj     = $pdo->insert($table3, $columns );
            }
            // print_r($action_obj);
            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;
    
                if ($unique_id) {
                    $msg        = "update";
                } 
                else {
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
            
            

        case 'stock_position_add_update':

            $main_unique_id          = $_POST["main_unique_id"];
            $part_no          = $_POST["part_no_val"];
            $stock_date          = $_POST["stock_date"];
            $item_code    = $_POST["item_code"];
            $item_name          = $_POST["item_name"];
            $item_qty          = $_POST["item_qty"];
            $billed_qty          = $_POST["billed_qty"];
            $remaining_qty          = $_POST["remaining_qty"];
            $product_unique_id    = $_POST["product_unique_id"];
            $po_num          = $_POST["po_num"];
            $po_date          = $_POST["po_date"];
            $po_unique_id          = $_POST["po_auto_id"];
            $exe_name          = $_POST["exe_name"];
            $no_of_con          = $_POST["no_of_con"];
            $no_of_items    = $_POST["no_of_items"];
            $total_qty          = $_POST["total_qty"];
            $product_tax          = $_POST["product_tax"];
            $net_value          = $_POST["net_value"];
            $unit_price          = $_POST["unit_price"];
          
            $unique_id          = $_POST["unique_id"];
           
            if($_POST["update_stock_qty"]==''){
                $update_stock_qty='0';     
            }
            else{
                $update_stock_qty          = $_POST["update_stock_qty"];
            }
            if($product_unique_id!=''){
               
                $stock_qty= $_POST["stock_qty"] + $update_stock_qty;
            }
            else{
                $stock_qty          = $_POST["stock_qty"];
            }

            if($_POST["update_stock_qty"]==''){
                $remaining_qty = $item_qty-$_POST["stock_qty"] ;
              }
            // else{
            //     $remaining_qty = 0;
               
            // }

            if($unique_id!=''){
               
                $remaining_qty=  $item_qty -  $stock_qty;
            }
            
            $columns1 = [
                'stock_id',
                ];
            // count taken start
            $table_details      = [
            $table3,
            [
                'COUNT(unique_id) AS count',
                'stock_id',  
            ],
            
        ];
        $select_where       = "is_delete = '0' AND form_main_unique_id = '".$main_unique_id."'";

        
    $action_obj         = $pdo->select($table_details,$select_where );
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
               $update_where       = "";
            $columns            = [
            
                'form_main_unique_id'        => $main_unique_id,
                'po_unique_id'           => $po_unique_id,
                'po_num'           => $po_num,
                'po_date'                   => $po_date,
                'no_of_consignee'                 => $no_of_con,
                'no_of_item'          => $no_of_items,
                'executive_name'              => $exe_name,
                'product_unique_id'             => $product_unique_id,
                'item_code'             => $item_code,
                'product'   => $item_name,
                'item_qty'        => $item_qty,
                'billed_qty'           => $billed_qty,
                'stock_qty'                   => $stock_qty,
                'product_tax'                   => $product_tax,
                'remaining_qty'                 => $remaining_qty,
                'part_no'                 => $part_no,
                'total_qty'          => $total_qty,
                'net_value'              => $net_value,
                'unit_price'              => $unit_price,
                'stock_date'              => $stock_date,
                'stock_id'              =>$data[0]['stock_id'],
                'unique_id'              => unique_id( $prefix )
            
            ];
        
            $product_details_sub = 'stock_position';

        if($unique_id) {
            unset($columns['unique_id']);

            $update_where   = [
                "form_main_unique_id"     => $main_unique_id,
                "product_unique_id" => $product_unique_id
            ];
            
            // $update_where   = "form_main_unique_id='$main_unique_id' and product_unique_id= '$product_unique_id'";
        // print_r($update_where);

            $action_obj1     = $pdo->update($product_details_sub, $columns, $update_where);
            // print_r($action_obj );die();
            // Update Ends
        } 
        else {
            // Insert Begins

            $action_obj1     = $pdo->insert($product_details_sub, $columns);


            // Insert Ends
        }
            //  $action_obj1     = $pdo->insert($product_details_sub,$columns);
            // Insert Ends
        //  print_r($action_obj1 );
    // }
            if ($action_obj1->status) {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = "";
                $sql        = $action_obj1->sql;
    
                if ($unique_id) {
                    $msg        = "update";
                } else {
                    $msg        = "create";
                }
            } else {
                $status     = $action_obj1->status;
                $data       = $action_obj1->data;
                $error      = $action_obj1->error;
                $sql        = $action_obj1->sql;
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

            case 'stock_position_sublist':

                $main_unique_id = $_POST["main_unique_id"];
                $part_no = $_POST["part_no_val"];
                $stock_date = $_POST["stock_date"];
                $item_code = $_POST["item_code"];
                $item_name = $_POST["item_name"];
                $item_qty = $_POST["item_qty"];
                $billed_qty = $_POST["billed_qty"];
                $remaining_qty = $_POST["remaining_qty"];
                $product_unique_id = $_POST["product_unique_id"];
                $po_num = $_POST["po_num"];
                $po_date = $_POST["po_date"];
                $po_unique_id = $_POST["po_auto_id"];
                $exe_name = $_POST["exe_name"];
                $no_of_con = $_POST["no_of_con"];
                $no_of_items = $_POST["no_of_items"];
                $total_qty = $_POST["total_qty"];
                $product_tax = $_POST["product_tax"];
                $net_value = $_POST["net_value"];
                $unit_price = $_POST["unit_price"];
                
                $delivery_due_date = $_POST["delivery_due_date"];
        
                $unique_id = $_POST["unique_id"];
        
                // print_r($_POST["update_stock_qty"].'hello');die();
                // if ($_POST["update_stock_qty"] == '' || $_POST["update_stock_qty"] == 0) {
                //     $update_stock_qty = '0';
                // } else {
                //     $update_stock_qty = $_POST["update_stock_qty"];
                // }
                // if ($update_stock_qty != '') {
        
                //     $stock_qty = $update_stock_qty;
                // } else {
                if($_POST["stock_qty"] == 0){
                    $stock_qty = 0;
        
                }else{
                    $stock_qty = $_POST["stock_qty"];
                    
                }
                // }
                // print_r($_POST["stock_qty"].'hi');die();
        
        
                // if ($_POST["update_stock_qty"] == '') {
                //     $remaining_qty = $item_qty - $_POST["stock_qty"];
                // } else {
                //     $remaining_qty = 0;
        
                // }
        
                // if ($unique_id != '') {
        
                //     $remaining_qty = $item_qty - $stock_qty;
                // }
        
                $columns1 = [
                    'stock_id',
                ];
                // count taken start
                $table_details = [
                    $table3,
                    [
                        'COUNT(unique_id) AS count',
                        'stock_id',
                    ],
        
                ];
                $select_where = "is_delete = '0' AND form_main_unique_id = '" . $main_unique_id . "'";
        
        
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
                $update_where = "";
                $columns = [
        
                    'form_main_unique_id' => $main_unique_id,
                    'po_unique_id' => $po_unique_id,
                    'po_num' => $po_num,
                    'po_date' => $po_date,
                    'no_of_consignee' => $no_of_con,
                    'no_of_item' => $no_of_items,
                    'executive_name' => $exe_name,
                    'product_unique_id' => $product_unique_id,
                    'item_code' => $item_code,
                    'product' => $item_name,
                    'item_qty' => $item_qty,
                    'billed_qty' => $billed_qty,
                    'stock_qty' => $stock_qty,
                    'product_tax' => $product_tax,
                    'remaining_qty' => $remaining_qty,
                    'part_no' => $part_no,
                    'total_qty' => $total_qty,
                    'net_value' => $net_value,
                    'unit_price' => $unit_price,
                    'stock_date' => $stock_date,
                    'delivery_due_date' => $delivery_due_date,
                    
                    'stock_id' => $data[0]['stock_id'],
                    'unique_id' => unique_id($prefix)
        
                ];
        
                $product_details_sub = 'stock_position_sublist';
        
                // if ($unique_id) {
                //     unset($columns['unique_id']);
        
                //     $update_where = [
                //         "unique_id" => $unique_id,
                //         // "product_unique_id" => $product_unique_id
                //     ];
        
                //     // $update_where   = "form_main_unique_id='$main_unique_id' and product_unique_id= '$product_unique_id'";
                //     // print_r($update_where);
        
                //     $action_obj1 = $pdo->update($product_details_sub, $columns, $update_where);
                //     // print_r($action_obj );die();
                //     // Update Ends
                // } else {
                    // Insert Begins
        
                    $action_obj1 = $pdo->insert($product_details_sub, $columns);
        
        // print_r( $action_obj1 );
                    // Insert Ends
                // }
                //  $action_obj1     = $pdo->insert($product_details_sub,$columns);
                // Insert Ends
        
                // }
                if ($action_obj1->status) {
                    $status = $action_obj1->status;
                    $data = $action_obj1->data;
                    $error = "";
                    $sql = $action_obj1->sql;
        
                    if ($unique_id) {
                        $msg = "update";
                    } else {
                        $msg = "create";
                    }
                } else {
                    $status = $action_obj1->status;
                    $data = $action_obj1->data;
                    $error = $action_obj1->error;
                    $sql = $action_obj1->sql;
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


function stock_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM stock_position_main where `stock_id` LIKE 'STK%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;


    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['stock_id']);

        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($booking_no == '')
        $booking_nos = 'STK-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $booking_nos = 'STK-' . $datee . '-0001';
    else {
        $booking_no += 1;
        $booking_nos = 'STK-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }

    return $booking_nos;
}

function invoice_no_get() {
            $date = date( 'Y' );
            $st_date = substr( $date, 2 );
            $month = date( 'm' );
            $datee = $st_date . $month;
            $servername = 'localhost';
            $username = project_env('APP_DB_USERNAME', 'root');
            $password = "";
                $database_name = "operation_team_beta";

            try {
                $conn = new PDO( "mysql:host=$servername;dbname=operation_team_beta", $username, $password );
                // set the PDO error mode to exception
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                //echo 'Connected successfully';
            } catch ( PDOException $e ) {
                // echo 'Connection failed: ' . $e->getMessage();
            }
            $stmt = $conn->query( "SELECT * FROM invoice_creation_main where `invoice_auto_id` LIKE 'INV%' order by unique_id desc" );
            // $bill = $stmt->fetch();
            // $res_array = $bill['id'];
            // $result = $res_array + 1;

            // if ( $res1 = $stmt->fetch( $stmt ) )
            if ( $res1 = $stmt->fetch() ) {
                $pur_array = explode( '-', $res1['invoice_auto_id'] );

                $year1 = $pur_array[1];
                $year2 = substr( $year1, 0, 2 );
                $year = '20' . $year2;
                $booking_no = $pur_array[2];
                // print_r( $booking_no );
            }
            if ( $booking_no == '' )
            $booking_nos = 'INV-' . $datee . '-0001';
            elseif ( $year != date( 'Y' ) )
            $booking_nos = 'INV-' . $datee . '-0001';
            else {
                $booking_no += 1;
                $booking_nos = 'INV-' . $datee . '-' . str_pad( $booking_no, 4, '0', STR_PAD_LEFT );
            }

            return $booking_nos;
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
?>

