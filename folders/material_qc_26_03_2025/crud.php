<?php
require_once __DIR__ . '/../../config/env.php'; 

// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table_com = "view_stock_completed_list";
$table             = "view_stock_position_list";
$table_po = "po_form";
$table_material_qc = "material_qc";
// $table1 = "stock_position_main";
// $table2 = "stock_position";
// $table3 = "stock_position_main";
// $table4 = "invoice_creation_main";

// $table_dependent_details = "view_stock_position_list";

// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

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
    

        case 'stock_position_sublist':

            $main_unique_id = $_POST["main_unique_id"];
            //  $part_no = $_POST["part_no_val"];
            // $stock_date = $_POST["stock_date"];
            $item_code = $_POST["item_code"];
            $item_name = $_POST["item_name"];
            $item_qty = $_POST["item_qty"];
            // $billed_qty = $_POST["billed_qty"];
            // $remaining_qty = $_POST["remaining_qty"];
            $product_unique_id = $_POST["product_unique_id"];
            $po_num = $_POST["po_num"];
            $po_date = $_POST["po_date"];
            $po_unique_id = $_POST["po_auto_id"];
            $exe_name = $_POST["exe_name"];
            $no_of_con = $_POST["no_of_con"];
            $no_of_items = $_POST["no_of_items"];
            $total_qty = $_POST["total_qty"];
            // $product_tax = $_POST["product_tax"];
            $net_value = $_POST["net_value"];
            $unit_price = $_POST["unit_price"];
    
            $unique_id = $_POST["unique_id"];
            $formatted_date = date("Y-m-d", strtotime($po_date));
          
            $update_where = "";
            $columns = [
    
                'form_main_unique_id' => $main_unique_id,
                'po_unique_id' => $po_unique_id,
                'po_num' => $po_num,
                'po_date' => $formatted_date,
                'no_of_consignee' => $no_of_con,
                'no_of_item' => $no_of_items,
                'executive_name' => $exe_name,
                'product_unique_id' => $product_unique_id,
                'item_code' => $item_code,
                'product' => $item_name,
                'item_qty' => $item_qty,
                // 'billed_qty' => $billed_qty,
                // 'stock_qty' => $stock_qty,
                // 'product_tax' => $product_tax,
                // 'remaining_qty' => $remaining_qty,
                // 'part_no' => $part_no,
                'total_qty' => $total_qty,
                'net_value' => $net_value,
                'unit_price' => $unit_price,
                // 'stock_date' => $stock_formatted_date,
                // 'stock_id' => $data[0]['stock_id'],
                'unique_id' => unique_id($prefix)
    
            ];
    
         
    
                $action_obj = $pdo->insert($table_material_qc, $columns);
    
    
                // Insert Ends
            // }
            //  $action_obj1     = $pdo->insert($product_details_sub,$columns);
            // Insert Ends
    
            // }
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
    
            $json_array = [
                "status" => $status,
                "data" => $data,
                "error" => $error,
                "msg" => $msg,
                "sql" => $sql
            ];
    
            echo json_encode($json_array);
    
            break;



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

            // "po_date",
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date", 
            "(SELECT department FROM department_creation WHERE department_creation.unique_id = ".$table.".department group by department_creation.unique_id  ) AS department",
            "(SELECT executive_name FROM executive_name AS executive_name WHERE executive_name.unique_id = ".$table.".executive_name group by executive_name.unique_id ) AS executive_name",
            "no_of_consignee",
            "no_of_po",
            "qty",
            "net_value",
            // 'FORMAT(ROUND(total_value, 2), 2)',
            "(select file_name from po_form where unique_id = ".$table.".unique_id group by unique_id) AS file_name",

            // "DATE_FORMAT(delivery_due_dates, '%d-%m-%Y') AS delivery_due_dates",
        
            "delivery_due_dates",
            "status",
           
            "unique_id",
            "(select stock_qty from stock_position_main where form_main_unique_id = ".$table.".unique_id group by form_main_unique_id) AS stock_qty",

            "po_unique_id",
              "product_due_days"

        ];
        $table_details  = [
            $table,
            $columns
        ];
       

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
  
                // $delivery_due_dates = $value['delivery_due_dates'];
                $delivery_due_days = $value['delivery_due_dates'];

            // new changes
                if ($delivery_due_days!="") {
                    $delivery_due_dates = $value['delivery_due_dates'];
                } else {
                    $delivery_due_dates = $value['product_due_days'];
                }
            // end
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';
                $po_date = $value['po_date'];
                $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
                $poDate->modify('+' . $delivery_due_dates . ' days');

                $resultDate = $poDate->format('d-m-Y');
                // print_R($resultDate);
                $currentDate = new DateTime();
                if ($poDate < $currentDate) {
                    $value['delivery_due_dates'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
                } else {
                    $value['delivery_due_dates'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
                }
                $btn_update         = btn_update($folder_name,$value['unique_id']);
                 $btn_delete         = btn_delete($folder_name,$value['unique_id']); 


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
                 
                    else{
                        $value['unique_id'] = '';
                    }
                  }
    



                $qty=$value['qty'];
                $stok_qty=$value['stock_qty'];
                if ($value['status'] == "0") {
                    $value['status'] = "<span style='color: red;'>Pending</span>";
                }
                
              
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

    
    case 'delete':
        
        $unique_id      = $_POST['unique_id'];

        $columns        = [
            "is_delete"   => 1
        ];

        $update_where   = [
            "unique_id"     => $unique_id
        ];

        $action_obj     = $pdo->update($table_material_qc,$columns,$update_where);

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
    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
    $password = "";
    $database_name = "operation_team";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team", $username, $password);
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
            $database_name = "operation_team";

            try {
                $conn = new PDO( "mysql:host=$servername;dbname=operation_team", $username, $password );
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

