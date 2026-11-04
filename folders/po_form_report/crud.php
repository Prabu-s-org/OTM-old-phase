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
// include 'function.php';
// File Upload Library Call

// $fileUploadPath = $fileUploadConfig->get('upload_folder');

// // Create Folder in root->uploads->( this_folder_name ) Before using this file upload
// $fileUploadConfig->set('upload_folder', $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// // $fileUploadPath = $fileUploadConfig->get( 'upload_folder' );
// $fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
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

    
    case 'search1':
        global $pdo;
        $from_date       = $_POST['from_date'];
        $to_date         = $_POST['to_date'];
        $department_name = $_POST['department_name'];
        $po_numbers      = $_POST['po_numbers'];
        $executive_name  = $_POST['executive_name'];
        $brand_name      = $_POST['brand_name'];
        $search          = $_POST['search'];
    
        $data = [];
        $table_po = "view_report_on_po_no";
        
        $columns = [
            "'' as s_no",
            'po_num',
            'po_date',
            "(SELECT department FROM department_creation AS dis WHERE dis.unique_id = {$table_po}.department) AS department",
            'bill_address',
            "(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = {$table_po}.executive_name) AS executive_name",
            'no_of_consignee',
            'no_of_items',
            'qty',
            'with_tax_amount',
            'without_tax_amount',
        ];
    
        $table_details = [$table_po, $columns];
    
        // Prepare the WHERE clause
        $where = '';
        if (!empty($from_date) && !empty($to_date)) {
            $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
        }
    
        if (!empty($department_name)) {
            $where .= (strlen($where) > 0 ? " AND " : "") . "department = '$department_name'";
        }
    
        if (!empty($executive_name)) {
            $where .= (strlen($where) > 0 ? " AND " : "") . "executive_name = '$executive_name'";
        }
    
        if (!empty($po_numbers)) {
            $where .= (strlen($where) > 0 ? " AND " : "") . "unique_id = '$po_numbers'";
        }
        // Fetch results from the database
        $result = $pdo->select($table_details, $where);
        $total_records = total_records();
        $s_no = 0;
        $page_without_tax_total = 0;
        $page_with_tax_total = 0;
        $grand_without_tax_total = 0;
        $grand_with_tax_total = 0;
    
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = ++$s_no;
                $po_date = $value['po_date'];

                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($po_date)) . '</span>';
            
                    // Convert amounts for display (do not change the original values for calculation)
            $with_tax_amount = $value['with_tax_amount'];
            $without_tax_amount = $value['without_tax_amount'];

            // Calculate totals for the current page
            $page_without_tax_total += $without_tax_amount; // Summing actual numeric values
            $page_with_tax_total += $with_tax_amount; // Summing actual numeric values

            // Format amounts for display
            $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
            $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

    // Calculate percentage (placeholder logic)
    // $total = 100; 
    $value['percentage'] = ($page_with_tax_total / $with_tax_amount) * 100;

// new changes

$no_of_consignee = $value['no_of_consignee'];
$no_of_items = $value['no_of_items'];
$qty = $value['qty'];

 // Calculate totals for the current page
 $total_no_of_consignee += $no_of_consignee; // Summing actual numeric values
 $total_no_of_items += $no_of_items; // Summing actual numeric values
 $total_qty += $qty; 




                $data[] = array_values($value);
            }

            // Fetch related values for val1, val2, val3
            $columns1 = [
                "(SELECT po_num FROM po_form AS dis WHERE dis.unique_id = '{$po_numbers}') AS po_num",
                "(SELECT department FROM department_creation AS dis WHERE dis.unique_id = '{$department_name}') AS department",
                "(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = '{$executive_name}') AS executive_name",
            ];
    
            $table_details1 = [$table_po, $columns1];
            $result1 = $pdo->select($table_details1);
    
            $val1 = '';
            $val2 = '';
            $val3 = '';
            if ($result1->status) {
                $res_array1 = $result1->data;
                foreach ($res_array1 as $value1) {
                    $val1 = $value1['po_num'];
                    $val2 = $value1['department'];
                    $val3 = $value1['executive_name'];
                }
            }
    
            // Prepare the response JSON
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
               'page_without_tax_total' => moneyFormatIndia($page_without_tax_total),
                 'page_with_tax_total' => moneyFormatIndia($page_with_tax_total),
              
                  'total_no_of_consignee' => $total_no_of_consignee,
                 'total_no_of_items' => $total_no_of_items,
                 'total_no_of_qty' => $total_qty,
                'val1' => $val1,
                'val2' => $val2,
                'val3' => $val3,
            ];
    
        } else {
            print_r($result);
        }
    
        echo json_encode($json_array);
        break;
      
        case 'search2':
            // DataTable Variables
            global $pdo;
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $department_name = $_POST['department_name'];
            $po_numbers = $_POST['po_numbers'];
            $executive_name = $_POST['executive_name'];
            $brand_name = $_POST['brand_name'];
            $search = $_POST['search'];
        
            $draw = $_POST['draw'];
            $start = $_POST['start'];  // Pagination start record
            $length = $_POST['length']; 
        
            $without_tax_amount = 0;
            $with_tax_amount = 0;
        
            $data = [];
        
            $table_cus = "view_report_on_customer";
        
            // Query Variables
            $json_array = '';
            $columns = [
                "'' as s_no",
             
                '(SELECT department FROM department_creation AS dis WHERE dis.unique_id =' . $table_cus . '.department) AS departmet',
                
                "count(po_num) as po_num",
                // "(SELECT no_of_po FROM view_po_form_list WHERE view_po_form_list.po_num = view_po_form_list.po_num group by po_num) AS no_of_po",

                'sum(no_of_consignee) AS no_of_consignee',
                'SUM(total_qty) AS total_qty',
                'SUM(with_tax_amount) AS with_tax_amount',
                'SUM(without_tax_amount) AS without_tax_amount',
              //  'SUM(with_tax_amount) AS with_tax_amount',
                
                '" " as percentage',
                "po_date",
                "executive_name",
            ];
        
            $table_details = [$table_cus, $columns];
        
            // Where clause initialization
            $where = '';
        
            // Filter by date range
            if (!empty($from_date) && !empty($to_date)) {
                $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
            }
        
            // Filter by department_name
            if (!empty($department_name)) {
                if (strlen($where) > 0) {
                    $where .= " AND department = '$department_name'";
                } else {
                    $where .= "department = '$department_name'";
                }
            }
        
            // Filter by executive_name
            if (!empty($executive_name)) {
                if (strlen($where) > 0) {
                    $where .= " AND executive_name = '$executive_name'";
                } else {
                    $where .= "executive_name = '$executive_name'";
                }
            }
        
            // Filter by PO numbers
            if (!empty($po_numbers)) {
                if (strlen($where) > 0) {
                    $where .= " AND unique_id = '$po_numbers'";
                } else {
                    $where .= "unique_id = '$po_numbers'";
                }
            }
            
            $group_by          = "departmet";

            // Get total records
            $total_records_result = $pdo->select($table_details, $where,"","","","",$group_by);
            $total_records = count($total_records_result->data);
           
            // Get paginated results
            $result = $pdo->select($table_details, $where,"","","","",$group_by);
        
            $s_no = 0;
            $page_with_tax_total = 0;     // Store page totals

            $page_without_tax_total = 0;  // Store page totals
            
        
            if ($result->status) {
                $res_array = $result->data;
        

                $page_with_tax_total1 = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount


                foreach ($res_array as $key => $value) {
                    $value['s_no'] = $s_no + 1;
                      
            $with_tax_amount = $value['with_tax_amount'];
          $without_tax_amount = $value['without_tax_amount'];
            // Format amounts for display
            $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
            $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

         $page_with_tax_total += $with_tax_amount;
        //  print_r($page_with_tax_total);die();
    $page_without_tax_total += $without_tax_amount; // Summing actual numeric values

   
    
// new changes

$po_num = $value['po_num'];
$no_of_con = $value['no_of_consignee'];
$qty = $value['total_qty'];

 // Calculate totals for the current page
 $total_po_num += $po_num; // Summing actual numeric values
 $total_no_of_con += $no_of_con; // Summing actual numeric values
 $total_qty += $qty; 

    
    // $value['percentage'] = round(($with_tax_amount / $page_with_tax_total), 2);
    $value['percentage'] = $page_with_tax_total1 > 0 
    ? round(($with_tax_amount / $page_with_tax_total1) * 100, 4) 
    : 0; // Avoid division by zero



                    $data[] = array_values($value);
                    $s_no++;
                }
        
                // Prepare response array
                $json_array = [
                    'draw' => intval($draw),
                    'recordsTotal' => intval($total_records),
                    'recordsFiltered' => intval($total_records),
                    'data' => $data,
                    'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)

                    'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                    'total_percentage' => round($total_percentage, 2), // Total percentage

                    'total_po_num' => $total_po_num,
                    'total_no_of_con' => $total_no_of_con,
                    'total_no_of_qty' => $total_qty,

                    'testing' => $result->sql,

                    // 'with_tax_amount' => moneyFormatIndia($with_tax_amount), // Grand total (all records)
                    // 'without_tax_amount' => moneyFormatIndia($without_tax_amount), // Grand total (all records)
                ];
            } else {
                print_r($result);
            }
        
            echo json_encode($json_array);
            break;
        


            case 'search3':
                // DataTable Variables
                global $pdo;
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                $department_name = $_POST['department_name'];
                $po_numbers = $_POST['po_numbers'];
                $executive_name = $_POST['executive_name'];
                $brand_name = $_POST['brand_name'];
                $search = $_POST['search'];
            
                $data = [];
                $table_cus = "view_report_on_excutive";
                
                // Query Variables
                $json_array = '';
                $columns = [
                    "'' as s_no",
                    '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id =' . $table_cus . '.executive_name) AS executive_name_name',
                    // "sum(no_of_po) AS no_of_po",
                    "count(po_num) as po_num",
                    'SUM(no_of_consignee) AS no_of_consignee',
                    // '(SELECT qty FROM executive_name AS dis WHERE dis.unique_id =' . $table_cus . '.qty) AS qty',
                    'SUM(total_qty) AS total_qty',
                    'SUM(with_tax_amount) AS total_value',
                    'SUM(without_tax_amount) AS net_value',
                
                    // 'without_tax_amount',
                    // 'with_tax_amount',
                    '" " as percentage',
                ];
                
                $table_details = [
                    $table_cus,
                    $columns
                ];
            
                // Initialize where clause
                $where = '';
            
                // Date filter
                if (!empty($from_date) && !empty($to_date)) {
                    $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
                }
            
                // Department filter
                if (!empty($department_name)) {
                    $where .= (strlen($where) > 0 ? " AND " : "") . "department = '$department_name'";
                }
            
                // Executive filter
                if (!empty($executive_name)) {
                    $where .= (strlen($where) > 0 ? " AND " : "") . "executive_name = '$executive_name'";
                }
            
                // PO Number filter
                if (!empty($po_numbers)) {
                    $where .= (strlen($where) > 0 ? " AND " : "") . "unique_id = '$po_numbers'";
                }
                $group_by          = "executive_name_name";
                $result = $pdo->select($table_details, $where,"","","","",$group_by);
                // print_r( $result);
                $total_records = total_records();
                $s_no = 0;

                $page_with_tax_total = 0;     // Store page totals
                $page_without_tax_total = 0;  // Store page totals
                // $grand_total_percentage = 0; 
            
                if ($result->status) {
                    $res_array = $result->data;
                    $page_with_tax_total_per = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount
                   
                    foreach ($res_array as $key => $value) {
                        $value['s_no'] = ++$s_no;
                                // Convert amounts for display (do not change the original values for calculation)
            $total_value = $value['total_value'];
            $net_value = $value['net_value'];
             // Format amounts for display
             $value['total_value'] = moneyFormatIndia($total_value);
             $value['net_value'] = moneyFormatIndia($net_value);

            // Calculate totals for the current page
            $page_with_tax_total += $total_value; // Summing actual numeric values

            $page_without_tax_total += $net_value; // Summing actual numeric values


                    
        // new changes

            $po_num = $value['po_num'];
            $no_of_no_con = $value['no_of_consignee'];
            $qty = $value['total_qty'];

        // Calculate totals for the current page
        $total_po_num += $po_num; // Summing actual numeric values
        $total_no_of_con += $no_of_no_con; // Summing actual numeric values
        $total_qty += $qty; 

            // $value['percentage'] = round(($total_value / $page_with_tax_total), 2);
          
            
    // $value['percentage'] = round(($with_tax_amount / $page_with_tax_total), 2);
    // $value['percentage'] = $page_with_tax_total_per > 0 
    // ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 2) 
    // : 0; // Avoid division by zero.
    $value['percentage'] = $page_with_tax_total_per > 0 
    ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 6) 
    : 0; // Avoid division by zero
    // $value['percentage'] = $page_with_tax_total_per > 0 
    // ? ($with_tax_amount / $page_with_tax_total_per) * 100 
    // : 0; // Avoid division by zero


                        $data[] = array_values($value);
                    }


                  
              // Prepare response array
                $json_array = [
                    'draw' => intval($draw),
                    'recordsTotal' => intval($total_records),
                    'recordsFiltered' => intval($total_records),
                    'data' => $data,
                    'total_po_num' => $total_po_num,
                    'total_no_of_con' => $total_no_of_con,
                    'total_no_of_qty' => $total_qty,
                    'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                    'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page page (without tax)
                    'testing' => $result->sql,
                    // 'with_tax_amount' => moneyFormatIndia($with_tax_amount), // Grand total (all records)
                    // 'net_value' => moneyFormatIndia($net_value), // Grand total (all records)
                ];
                } else {
                    print_r($result);
                }
            
                echo json_encode($json_array);
                break;
            
                case 'search4':
                    // DataTable Variables
                    global $pdo;
                    
                    // POST Data
                    $from_date       = $_POST['from_date'];
                    $to_date         = $_POST['to_date'];
                    $department_name  = $_POST['department_name'];
                    $po_numbers       = $_POST['po_numbers'];
                    $executive_name   = $_POST['executive_name'];
                    $brand_name       = $_POST['brand_name'];
                    $search           = $_POST['search'];
                
                    // Initialize variables
                    $data            = [];
                    $table_cus       = "view_report_on_item_code";
                    $json_array      = '';
                
                    // Columns for the query
                    $columns = [
                        "'' as s_no",
                       
                        "item_code",
                        "item_description",
                        "brand",
                        "qty",
                        "with_tax_amount",
                        "without_tax_amount",
                    
                        '" " as percentage',
                        "po_unique_id",
                        "po_date",
                    ];
                    $table_details = [$table_cus, $columns];
                
                    // Prepare the WHERE clause
                    $where = '';
                
                    // Date filtering
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
                    }
                
                    // Department name filtering
                    if (!empty($department_name)) {
                        $where .= (strlen($where) > 0 ? " AND " : "") . "department = '$department_name'";
                    }
                
                    // Executive name filtering
                    if (!empty($executive_name)) {
                        $where .= (strlen($where) > 0 ? " AND " : "") . "executive_name = '$executive_name'";
                    }
                
                    // PO numbers filtering
                    if (!empty($po_numbers)) {
                        $where .= (strlen($where) > 0 ? " AND " : "") . "po_unique_id = '$po_numbers'";
                    }
                
                    // Brand name filtering
                    if (!empty($brand_name)) {
                        $where .= (strlen($where) > 0 ? " AND " : "") . "brand = '$brand_name'";
                    }
                
                    // Execute the query
                    $result = $pdo->select($table_details, $where);
                    $total_records = total_records();
                
                    $s_no = 0;
                    $page_with_tax_total = 0; 
                    $page_without_tax_total = 0;  // Store page totals
                    // Store page totals
                    if ($result->status) {
                        $res_array = $result->data;
                
                    //     foreach ($res_array as $key => $value) {
                    //         $value['s_no'] = ++$s_no; // Increment serial number
                    //         $with_tax_amount = $value['with_tax_amount'];
                    //         $without_tax_amount = $value['without_tax_amount'];
                    //         // Format amounts for display
                    //         $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
                    //         $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

                    //         // Calculate totals for the current page
                    //         $page_without_tax_total += $without_tax_amount; // Summing actual numeric values
                    //         $page_with_tax_total += $with_tax_amount; // Summing actual numeric values

                            
                    //             // $total = 100; 
                    //             // $value['percentage'] = ($with_tax_amount * 100) / $total;

                    //             // old
                    //             $value['percentage'] = round(($with_tax_amount / $page_without_tax_total), 2);

                    //       //   $value['percentage'] = round(($with_tax_amount / $page_with_tax_total), 2);
            

                    //         // Percentage calculation
                           
                    //          $data[] = array_values($value);
                    //     }
                
                    //     // Prepare the JSON response
                    //     $json_array = [
                    //         'draw' => intval($draw),
                    //         'recordsTotal' => intval($total_records),
                    //         'recordsFiltered' => intval($total_records),
                    //         'data' => $data,
                    //         'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                    //         'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)
                    //         'testing' => $result->sql
                    //     ];
                    // } else {
                    //     print_r($result);
                    // }
                
                    // // Output the JSON response
                    // echo json_encode($json_array);
                    // break;
// new changess

                    $page_with_tax_total1 = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount

                foreach ($res_array as $key => $value) {
                    $value['s_no'] = ++$s_no; // Increment serial number

                    $with_tax_amount = $value['with_tax_amount'];
                    $without_tax_amount = $value['without_tax_amount'];

                    // Format amounts for display
                    $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
                    $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

                    // Calculate totals for the current page
                    $page_with_tax_total += $with_tax_amount; // Summing actual numeric values

                    $page_without_tax_total += $without_tax_amount;


                    
            
// new changes

  
    $qty = $value['qty'];

 // Calculate totals for the current page
 
 $total_qty += $qty; 
                    // Calculate percentage of each individual with_tax_amount
                    // $value['percentage'] = $page_with_tax_total1 > 0 
                    //     ? round(($with_tax_amount / $page_with_tax_total1) * 100, 2) 
                    //     : 0; // Avoid division by zero

                        $value['percentage'] = $page_with_tax_total1 > 0 
    ? round(($with_tax_amount / $page_with_tax_total1) * 100, 4) 
    : 0; // Avoid division by zero

                    // Add formatted row to the data array
                    $data[] = array_values($value);
                }

            // Prepare the JSON response
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
                'total_no_of_qty' => $total_qty,
                'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)

                'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                'testing' => $result->sql
            ];
        } else {
            print_r($result);
        }
            // Output the JSON response
            echo json_encode($json_array);
            break;

                
        case 'rename_data':
            $department_name = $_POST['department_name'];
            $po_numbers = $_POST['po_numbers'];
            $executive_name = $_POST['executive_name'];
            $brand_name = $_POST['brand_name'];
            // var brand_name = $("#").val();
            if($department_name == ''){
                $val = '';
            }else{
                $name1 = department_creation_table($department_name);
                $val1 = $name1[0]['department'];
            }

            if($brand_name == ''){
                $val6 = '';
            }else{
                // $name6 = brand_creation_table($brand_name);
                $val6 =   $brand_name;
            }
            // print_r($val6 );die();

if($po_numbers == ''){
$val2 = '';
}else{
$name2 = po_numers($po_numbers);
$val2 = $name2[0]['po_num'];
}
if($executive_name == ''){
$val3 = '';
}else{
$name3 = executive_names($executive_name);
$val3 = $name3[0]['executive_name'];
}


           

            $json_array = [
                
                'val1'                  =>$val1,
                'val2'                  =>$val2,
                'val3'                  =>$val3,
                'val6'                  =>$val6,
                
            ];
        

        echo json_encode($json_array);
        break;
        case 'search5':
            global $pdo;
            $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $department_name = $_POST['department_name'];
            $po_numbers = $_POST['po_numbers'];
            $executive_name = $_POST['executive_name'];
            $brand_name = $_POST['brand_name'];
            $search = $_POST['search'];
            $data = [];
            $table_month = "view_report_on_month";
            
            $columns = [
                "'' as s_no",
                "month",
                // "SUM(no_of_po) as no_of_po",
                "count(po_num) AS no_of_po",
                'sum(no_of_consignee) as no_of_consignee',
                'qty',
                'SUM(with_tax_amount) AS with_tax_amount',
                'SUM(without_tax_amount) AS without_tax_amount',
             
                  
                '"" as percentage',
            ];
            $table_details = [
                $table_month,
                $columns
            ];
            
            // Date range filtering
            if (empty($from_date) || empty($to_date)) {
                $where = '';
            } else {
                $from_month = date('m', strtotime($from_date));
                $from_year = date('Y', strtotime($from_date));
                $to_month = date('m', strtotime($to_date));
                $to_year = date('Y', strtotime($to_date));
        
                $where = "MONTH(po_date) >= '$from_month' AND YEAR(po_date) >= '$from_year' 
                          AND MONTH(po_date) <= '$to_month' AND YEAR(po_date) <= '$to_year'";
            }
        
            // Department filtering
            if (!empty($department_name)) {
                $where .= (strlen($where) > 0 ? " AND " : "") . "department = '$department_name'";
            }
        
            // Executive name filtering
            if (!empty($executive_name)) {
                $where .= (strlen($where) > 0 ? " AND " : "") . "executive_name = '$executive_name'";
            }
        
            // PO numbers filtering
            if (!empty($po_numbers)) {
                $where .= (strlen($where) > 0 ? " AND " : "") . "po_unique_id = '$po_numbers'";
            }

            // $group_by          = "po_date";
            // $result = $pdo->select($table_details, $where,"","","","",$group_by);

            $group_by          = "month";
            // $order_by = "YEAR(po_date), MONTH(po_date)";
        // $orederby
            $result = $pdo->select($table_details, $where,"","","","",$group_by);

            // Define the month order
$month_order = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// Sort the data array
usort( $result->data, function ($a, $b) use ($month_order) {
    $month_a = substr($a['month'], 0, 3);
    $month_b = substr($b['month'], 0, 3);
    $index_a = array_search($month_a, $month_order);
    $index_b = array_search($month_b, $month_order);
    return $index_a <=> $index_b;
});

            // print_r($result);die();
            // $result = $pdo->select($table_details, $where,$group_by, $order_by);

            $total_records = total_records();
            $s_no = 0;
            $page_with_tax_total = 0;
            $page_without_tax_total = 0;
         
        
            if ($result->status) {
                $res_array = $result->data;
           $page_with_tax_total_per = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount
                foreach ($res_array as $key => $value) {
                    $value['s_no'] = ++$s_no; // Increment serial number only once
                    $with_tax_amount = $value['with_tax_amount'];
                    $without_tax_amount = $value['without_tax_amount'];
        
                    // Format amounts for display
                    $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
                    $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);
        
                    // Calculate totals for the current page
                    $page_without_tax_total += $without_tax_amount;
                    $page_with_tax_total += $with_tax_amount;
        
                  

                                
                    // new changes

                    $no_of_po = $value['no_of_po'];
                    $no_of_no_con = $value['no_of_consignee'];
                    $qty = $value['qty'];

                    // Calculate totals for the current page
                    $total_no_of_po += $no_of_po; // Summing actual numeric values
                    $total_no_of_con += $no_of_no_con; // Summing actual numeric values
                    $total_qty += $qty; 

                    $value['percentage'] = $page_with_tax_total_per > 0 
                    ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 4) 
                    : 0; // Avoid division by zero

                    $data[] = array_values($value);
                }
        
                $json_array = [
                    'draw' => intval($draw),
                    'recordsTotal' => intval($total_records),
                    'recordsFiltered' => intval($total_records),
                    'data' => $data,
                    'total_no_of_po' => $total_no_of_po,
                    'total_no_of_con' => $total_no_of_con,
                    'total_no_of_qty' => $total_qty,
                    'page_with_tax_total' => moneyFormatIndia($page_with_tax_total),

                    'page_without_tax_total' => moneyFormatIndia($page_without_tax_total),
                    'testing' => $result->sql
                ];
            } else {
                print_r($result);
            }
        
            echo json_encode($json_array);
            break;
        

            // year wise 
            case 'search6':
                // print_r("hiii");
                // DataTable Variables
               global $pdo;
                 $from_date = $_POST['from_date'];
                 $to_date = $_POST['to_date'];
                 $department_name = $_POST['department_name'];
                 $po_numbers = $_POST['po_numbers'];
                 $executive_name = $_POST['executive_name'];
                 $brand_name = $_POST['brand_name'];
                 $search = $_POST['search'];
                
                
                // $limit          = $length;
        
                $data        = [];
                // if ($length == '-1') {
                //     $limit  = '';
                // }
                 $table_year="view_report_on_year";
                // Query Variables
                $json_array     = '';
                $columns        = [
                    "'' as  s_no",
                    "year",
                    // '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_cus.'.department ) AS department',
                    // "sum(no_of_po) as no_of_po",
                    "count(po_num) AS no_of_po",
                   'sum(no_of_consignee) as no_of_consignee',
                    'qty',
                    'with_tax_amount',
                    'without_tax_amount',
             
                    
                    '" " as percentage',
                    
                    
                ];
                $table_details  = [
                    $table_year,
                    $columns
                ];
                
        
               
               
                // if ($_POST['from_date'] == '') {
                //     $from_date = date('Y-m-d');
                // } else {
                //     $from_date = $_POST['from_date'];
                // }
                // if ($_POST['to_date'] == '') {
                //     $to_date = date('Y-m-d');
                // } else {
                //     $to_date = $_POST['to_date'];
        
                    
                // }
                // if ($from_date || $to_date != '') {
        
                //     $where .= "  po_date>= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
                    
                // }
            //     $from_date = $_POST['from_date'];
            // $to_date = $_POST['to_date'];

            // $from_date = date('Y', strtotime($_POST['from_date']));
            // $to_date = date('Y', strtotime($_POST['to_date']));
            
            // if (empty($from_date) || empty($to_date)) {
            //     // If either date is empty, no filtering is applied
            //     $where = '';
            // } else {
            //     // If both dates are provided, apply the date filter
            //     $where = "year >= '" . $from_date . "' AND year <= '" . $to_date . "'";
            // }
            $from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

if (empty($from_date) || empty($to_date)) {
    // echo "hi";
    $where = '';
} else {
    // Extract month and year from the dates
    $from_month = date('m', strtotime($from_date));
    $from_year = date('Y', strtotime($from_date));

    $to_month = date('m', strtotime($to_date));
    $to_year = date('Y', strtotime($to_date));

    // Use the extracted month and year in the SQL query
    $where = " YEAR(po_date) >= '" . $from_year . "' AND YEAR(po_date) <= '" . $to_year . "'";
}
            
                
                // if($department_name == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And department = '$department_name'";
                // }
                // if($executive_name == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And executive_name = '$executive_name'";
                // }
                // if($po_numbers == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And unique_id = '$po_numbers'";
                // }

                // if($department_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " department = '$department_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And department = '$department_name'";
                // }
        
                // if($executive_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " executive_name = '$executive_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And executive_name = '$executive_name'";
                // }
        
                // if($po_numbers  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " unique_id = '$po_numbers'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And unique_id = '$po_numbers'";
                // }
                // if (!empty($from_date) && !empty($to_date)) {
                //     $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
                // }
                // else{
                //     $where .='';
                // }
                
                // Check if department_name is provided
                if (!empty($department_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND department = '$department_name'";
                    } else {
                        $where .= "department = '$department_name'";
                    }
                }
                
                // Check if executive_name is provided
                if (!empty($executive_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND executive_name = '$executive_name'";
                    } else {
                        $where .= "executive_name = '$executive_name'";
                    }
                }
                
                // Check if po_numbers is provided
                // if (!empty($po_numbers)) {
                //     if (strlen($where) > 0) {
                //         $where .= " AND unique_id = '$po_numbers'";
                //     } else {
                //         $where .= "unique_id = '$po_numbers'";
                //     }
                // }
                
                if (!empty($po_numbers)) {
                    if (strlen($where) > 0) {
                        $where .= " AND po_unique_id = '$po_numbers'";
                    } else {
                        $where .= "po_unique_id = '$po_numbers'";
                    }
                }
                $group_by          = "year";
                 $result         = $pdo->select($table_details,  $where,"","","","",$group_by);
        
        // print_r(  $result );
                // print_r("hii".$result);die();
        
                $total_records  = total_records();
           
                
        $s_no =0;
        
        $page_without_tax_total = 0;  // Store page totals
        $page_with_tax_total = 0;     // Store page totals
        if ($result->status) {
            $res_array = $result->data;
            $page_with_tax_total_per = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount
            foreach ($res_array as $key => $value) {
                $value['s_no'] = ++$s_no; // Increment serial number
                $with_tax_amount = $value['with_tax_amount'];
    $without_tax_amount = $value['without_tax_amount'];
    // Format amounts for display
    $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
    $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

    // Calculate totals for the current page
    $page_with_tax_total += $with_tax_amount; // Summing actual numeric values

    $page_without_tax_total += $without_tax_amount; // Summing actual numeric values


            
// new changes

$no_of_po = $value['no_of_po'];
$no_of_no_con = $value['no_of_consignee'];
$qty = $value['qty'];

// Calculate totals for the current page
$total_no_of_po += $no_of_po; // Summing actual numeric values
$total_no_of_con += $no_of_no_con; // Summing actual numeric values
$total_qty += $qty; 

    //   : 0; // Avoid division by zero
    $value['percentage'] = $page_with_tax_total_per > 0 
    ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 4) 
    : 0; // Avoid division by zero



                        $data[]             = array_values($value);
                        // $s_no++;
                    }
                    $json_array = [
                        'draw'                => intval($draw),
                        'recordsTotal'         => intval($total_records),
                        'recordsFiltered'     => intval($total_records),
                        'data'                 => $data,
                        'total_no_of_po' => $total_no_of_po,
                        'total_no_of_con' => $total_no_of_con,
                        'total_no_of_qty' => $total_qty,
                        'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)

                        'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                        'testing' => $result->sql
                    ];
                } else {
                    print_r($result);
                }
        
                echo json_encode($json_array);
                break;

                // po date  wise 
            case 'search7':
                // print_r("hiii");
                // DataTable Variables
               global $pdo;
                 $from_date = $_POST['from_date'];
                 $to_date = $_POST['to_date'];
                 $department_name = $_POST['department_name'];
                 $po_numbers = $_POST['po_numbers'];
                 $executive_name = $_POST['executive_name'];
                 $brand_name = $_POST['brand_name'];
                 $search = $_POST['search'];
                
                
                // $limit          = $length;
        
                $data        = [];
                // if ($length == '-1') {
                //     $limit  = '';
                // }
                 $table_po_date="view_report_on_po_date";
                // Query Variables
                $json_array     = '';
                $columns        = [
                    "'' as  s_no",
                    "po_date",
                    // "sum(no_of_po) AS no_of_po",
                      "count(po_num) AS no_of_po",
                    'SUM(no_of_consignee) AS no_of_consignee',
                    'SUM(qty) AS qty',
                    'SUM(with_tax_amount) AS with_tax_amount',

                    'SUM(without_tax_amount) AS without_tax_amount',
                  
                    // 'qty',
                    // 'without_tax_amount',
                    // 'with_tax_amount',
                    ' " " as percentage',
                ];
                $table_details  = [
                    $table_po_date,
                    $columns
                ];
                
        

                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                
                // if (empty($from_date) || empty($to_date)) {
                //     // If either date is empty, no date filter is applied
                //     $where = '';
                // } else {
                //     // If both dates are provided, apply the date filter
                //     $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
                // }
              
                // if($department_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " department = '$department_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And department = '$department_name'";
                // }
        
                // if($executive_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " executive_name = '$executive_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And executive_name = '$executive_name'";
                // }
        
                // if($po_numbers  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " unique_id = '$po_numbers'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != ''){
                //     $where .= "And unique_id = '$po_numbers'";
                // }
                if (!empty($from_date) && !empty($to_date)) {
                    $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
                }
                else{
                    $where .='';
                }
                
                // Check if department_name is provided
                if (!empty($department_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND department = '$department_name'";
                    } else {
                        $where .= "department = '$department_name'";
                    }
                }
                
                // Check if executive_name is provided
                if (!empty($executive_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND executive_name = '$executive_name'";
                    } else {
                        $where .= "executive_name = '$executive_name'";
                    }
                }
                
                // Check if po_numbers is provided
                // if (!empty($po_numbers)) {
                //     if (strlen($where) > 0) {
                //         $where .= " AND unique_id = '$po_numbers'";
                //     } else {
                //         $where .= "unique_id = '$po_numbers'";
                //     }
                // }
                
                if (!empty($po_numbers)) {
                    if (strlen($where) > 0) {
                        $where .= " AND unique_id = '$po_numbers'";
                    } else {
                        $where .= "unique_id = '$po_numbers'";
                    }
                }
                $group_by          = "po_date";

                 $result1         = $pdo->select($table_details, $where,"","","","",$group_by);
        
        // print_r($result1);
                // print_r("hii".$result);die();
        
                $total_records  = total_records();
           
                
        $s_no =0;
        
        $page_without_tax_total = 0;  // Store page totals
        $page_with_tax_total = 0;     // Store page totals
        if ($result1->status) {
            $res_array = $result1->data;
            $page_with_tax_total_per = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount
            foreach ($res_array as $key => $value1) {
                $value1['s_no'] = ++$s_no; // Increment serial number
                                $with_tax_amount = $value1['with_tax_amount'];
                    $without_tax_amount = $value1['without_tax_amount'];
                    // Format amounts for display
                    $value1['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
                    $value1['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

                    // Calculate totals for the current page
                    $page_without_tax_total += $without_tax_amount; // Summing actual numeric value1s
                    $page_with_tax_total += $with_tax_amount; // Summing actual numeric value1s



                              
// new changes

    $no_of_po = $value1['no_of_po'];
    $no_of_no_con = $value1['no_of_consignee'];
    $qty = $value1['qty'];

 // Calculate totals for the current page
 $total_no_of_po += $no_of_po; // Summing actual numeric values
 $total_no_of_con += $no_of_no_con; // Summing actual numeric values
 $total_qty += $qty; 

                    // Avoid division by zero
                    $value1['percentage'] = $page_with_tax_total_per > 0 
                    ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 4) 
                    : 0; // Avoid division by zero

                        $data[]             = array_values($value1);
                        // $s_no++;
                    }
    
                    $json_array = [
                        'draw'                => intval($draw),
                        'recordsTotal'         => intval($total_records),
                        'recordsFiltered'     => intval($total_records),
                        'total_no_of_po' => $total_no_of_po,
                        'total_no_of_con' => $total_no_of_con,
                        'total_no_of_qty' => $total_qty,
                        'data'                 => $data,
                         'testing'            => $result->sql,
                         'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)

                         'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                    ];
                } else {
                    print_r($result);
                }
                echo json_encode($json_array);
                break;
    //    break;
                  //  brand name  wise 
            case 'search8':
                // print_r("hiii");
                // DataTable Variables
               global $pdo;
                 $from_date = $_POST['from_date'];
                 $to_date = $_POST['to_date'];
                 $department_name = $_POST['department_name'];
                 $po_numbers = $_POST['po_numbers'];
                 $executive_name = $_POST['executive_name'];
                 $brand_name = $_POST['brand_name'];
                 $search = $_POST['search'];
                
                
                // $limit          = $length;
        
                $data        = [];
                // if ($length == '-1') {
                //     $limit  = '';
                // }
                 $table_brand="view_report_on_brand_name";
                // Query Variables
                $json_array     = '';
                $columns        = [
                    "'' as  s_no",
                    "brand",
                    // '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_cus.'.department ) AS department',
                    "qty",
                   'with_tax_amount',
                    'without_tax_amount',
                    // 'without_tax_amount',
                    // 'with_tax_amount',
                    
                    '" " as percentage',
                    "po_date",
                    
                    
                ];
                $table_details  = [
                    $table_brand,
                    $columns
                ];
                
        
               
               
                // if ($_POST['from_date'] == '') {
                //     $from_date = date('Y-m-d');
                // } else {
                //     $from_date = $_POST['from_date'];
                // }
                // if ($_POST['to_date'] == '') {
                //     $to_date = date('Y-m-d');
                // } else {
                //     $to_date = $_POST['to_date'];
        
                    
                // }
                // if ($from_date || $to_date != '') {
        
                //     $where .= "  po_date>= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
                    
                // }
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    
                    // if (empty($from_date) || empty($to_date)) {
                    //     // If either date is empty, no date filter is applied
                    //     $where = '';
                    // } else {
                    //     // If both dates are provided, apply the date filter
                    //     $where = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
                    // }
                
                // if($department_name == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And department = '$department_name'";
                // }
                // if($executive_name == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And executive_name = '$executive_name'";
                // }
                // if($po_numbers == ''){
                //     $where .= "";
                // }else{
                //     $where .= "And unique_id = '$po_numbers'";
                // }
                // if($department_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " department = '$department_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != '' || $brand_name!=''){
                //     $where .= "And department = '$department_name'";
                // }
        
                // if($executive_name  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " executive_name = '$executive_name'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != '' || $brand_name!=''){
                //     $where .= "And executive_name = '$executive_name'";
                // }
        
                // if($po_numbers  == ''){
                //     $where .= "";
                // }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //     $where .= " po_unique_id = '$po_numbers'";
                // }
                // else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != '' || $brand_name!=''){
                //     $where .= " And po_unique_id = '$po_numbers'";
                // }

                //   if($brand_name == ''){
                //         $where .= "";
                //     }else if($department_name == '' || $executive_name == '' || $po_numbers == ''){
                //         $where .= "  brand = '$brand_name'";
                //     }
                //     else if($from_date !='' || $to_date !='' || $department_name != '' || $executive_name != '' || $po_numbers != '' || $brand_name!=''){
                //         $where .= " AND brand = '$brand_name'";
                //     }
                if (!empty($from_date) && !empty($to_date)) {
                    $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
                }
                else{
                    $where .='';
                }
                
                // Check if department_name is provided
                if (!empty($department_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND department = '$department_name'";
                    } else {
                        $where .= "department = '$department_name'";
                    }
                }
                
                // Check if executive_name is provided
                if (!empty($executive_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND executive_name = '$executive_name'";
                    } else {
                        $where .= "executive_name = '$executive_name'";
                    }
                }
                
                // Check if po_numbers is provided
                // if (!empty($po_numbers)) {
                //     if (strlen($where) > 0) {
                //         $where .= " AND unique_id = '$po_numbers'";
                //     } else {
                //         $where .= "unique_id = '$po_numbers'";
                //     }
                // }
                
                if (!empty($po_numbers)) {
                    if (strlen($where) > 0) {
                        $where .= " AND po_unique_id = '$po_numbers'";
                    } else {
                        $where .= "po_unique_id = '$po_numbers'";
                    }
                }

                if (!empty($brand_name)) {
                    if (strlen($where) > 0) {
                        $where .= " AND brand = '$brand_name'";
                    } else {
                        $where .= "brand = '$brand_name'";
                    }
                }
                 $result         = $pdo->select($table_details, $where);
        
        
                // print_r("hii".$result);die();
        
                $total_records  = total_records();
           
                
        $s_no =0;
        $page_without_tax_total = 0;  // Store page totals
        $page_with_tax_total = 0;     // Store page totals
        if ($result->status) {
            $res_array = $result->data;

            $page_with_tax_total_per = array_sum(array_column($res_array, 'with_tax_amount')); // Calculate the total with_tax_amount
            foreach ($res_array as $key => $value) {
                $value['s_no'] = ++$s_no; // Increment serial number
                $with_tax_amount = $value['with_tax_amount'];
                    $without_tax_amount = $value['without_tax_amount'];
                    // Format amounts for display
                    $value['with_tax_amount'] = moneyFormatIndia($with_tax_amount);
                    $value['without_tax_amount'] = moneyFormatIndia($without_tax_amount);

                    // Calculate totals for the current page
                    $page_without_tax_total += $without_tax_amount; // Summing actual numeric values
                    $page_with_tax_total += $with_tax_amount; // Summing actual numeric values

                    $qty = $value['qty'];
                    $total_qty += $qty; 
                    // $total = 100; 
                   
                    // $value['percentage'] = round(($with_tax_amount / $page_without_tax_total), 2);
 // Calculate percentage of each individual with_tax_amount
 $value['percentage'] = $page_with_tax_total_per > 0 
 ? round(($with_tax_amount / $page_with_tax_total_per) * 100, 2) 
 : 0; // Avoid division by zero


                        $data[]             = array_values($value);
                        // $s_no++;
                        
                    }
        
                    $json_array = [
                        'draw'                => intval($draw),
                        'recordsTotal'         => intval($total_records),
                        'recordsFiltered'     => intval($total_records),
                        'data'                 => $data,
                        'total_no_of_qty' => $total_qty,
                         'testing'            => $result->sql,
                         'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)
                         'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                        
                    ];
                } else {
                    print_r($result);
                }
        
                echo json_encode($json_array);
                break;

                    //  po details wise 
            case 'search9':
                // print_r("hiii");
                // DataTable Variables
               global $pdo;
                 $from_date = $_POST['from_date'];
                 $to_date = $_POST['to_date'];
                 $department_name = $_POST['department_name'];
                 $po_numbers = $_POST['po_numbers'];
                 $executive_name = $_POST['executive_name'];
                 $brand_name = $_POST['brand_name'];
                 $search = $_POST['search'];
                
                
                // $limit          = $length;
        
                $data        = [];
                // if ($length == '-1') {
                //     $limit  = '';
                // }
                 $table_brand="view_report_on_detailed";
                // Query Variables
                $json_array     = '';
                $columns        = [
                    "'' as  s_no",
                    "po_num",
                    "po_date",
                    // "department",
                    '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_brand.'.department ) AS department',
                    // "executive_name",
                    '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id ='.$table_brand.'.executive_name ) AS executive_name',
                
                    "po_bill_address",
                    "po_pin",
                    "con_address",
                    "con_pincode",
                    "con_contact_name",
                    "con_contact_number",
                    "po_prepared_by",
                    '(SELECT item_code FROM item_creation_sub AS dis WHERE dis.unique_id ='.$table_brand.'.item_code ) AS item_code',
                
                    // "item_code",
                    "product",
                    "qty",
                    "unit_price",
                    "tax",
                    "net_value",
                    "total_value",
                    "delivery_due_dates",
                    "product_delivery_due_days",
                    // '(SELECT department FROM department_creation AS dis WHERE dis.unique_id ='.$table_cus.'.department ) AS department',
                //     "qty",
                //    'with_tax_amount',
                //     'without_tax_amount',
                    // 'without_tax_amount',
                    // 'with_tax_amount',
                    
                    // '" " as percentage',
                    
                    
                ];
                $table_details  = [
                    $table_brand,
                    $columns
                ];
                
        
             
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                
             
                
        // new changes
        if (!empty($from_date) && !empty($to_date)) {
            $where .= "po_date >= '$from_date' AND po_date <= '$to_date'";
        }
        else{
            $where .='';
        }
        
        // Check if department_name is provided
        if (!empty($department_name)) {
            if (strlen($where) > 0) {
                $where .= " AND department = '$department_name'";
            } else {
                $where .= "department = '$department_name'";
            }
        }
        
        // Check if executive_name is provided
        if (!empty($executive_name)) {
            if (strlen($where) > 0) {
                $where .= " AND executive_name = '$executive_name'";
            } else {
                $where .= "executive_name = '$executive_name'";
            }
        }
        
        // Check if po_numbers is provided
        // if (!empty($po_numbers)) {
        //     if (strlen($where) > 0) {
        //         $where .= " AND unique_id = '$po_numbers'";
        //     } else {
        //         $where .= "unique_id = '$po_numbers'";
        //     }
        // }
        
        if (!empty($po_numbers)) {
            if (strlen($where) > 0) {
                $where .= " AND unique_id = '$po_numbers'";
            } else {
                $where .= "unique_id = '$po_numbers'";
            }
        }
                 $result         = $pdo->select($table_details, $where);
        
        
                // print_r("hii".$result);die();
        
                $total_records  = total_records();
           
                
        $s_no =0;
        $page_without_tax_total = 0;  // Store page totals
        $page_with_tax_total = 0;     // Store page totals

                if ($result->status) {
        
                    $res_array      = $result->data;
        
                    foreach ($res_array as $key => $value) {
                        
                        
                    $value['s_no'] = $s_no+1;
                    
                    // $value['total_value'] = moneyFormatIndia(($value['total_value']));
                    // $value['net_value'] = moneyFormatIndia(($value['net_value']));

                    // new changes============================================
                    $with_tax_amount = $value['total_value'];
                    $without_tax_amount = $value['net_value'];
                    // Format amounts for display
                    $value['total_value'] = moneyFormatIndia($with_tax_amount);
                    $value['net_value'] = moneyFormatIndia($without_tax_amount);

                    // Calculate totals for the current page
                    $page_without_tax_total += $without_tax_amount; // Summing actual numeric values
                    $page_with_tax_total += $with_tax_amount; // Summing actual numeric values
                    // $total = 100; 
                    // $value['percentage'] = ($with_tax_amount * 100) / $total;

                    // end   ====================================                 
                    $delivery_due_days_1=$value['delivery_due_dates'];
                    // $delivery_due_days_2=$product['delivery_due_dates_org'];
                    if($delivery_due_days_1!='')	{
                        $value['delivery_due_dates']=(int)$value['delivery_due_dates'];
                    }	
                    else{					

                        $value['delivery_due_dates']=(int)$value['product_delivery_due_days'];
                    }


                  

                   $po_date_2 =$value['po_date']; 
                    
                   $product_po_date = '<span class="po_date">' . $po_date_2 . '</span>';

                   $poDate = DateTime::createFromFormat('Y-m-d', strip_tags($po_date_2));

                   // if (!$poDate) {
                   //     echo "Invalid PO date format.";
                   //     return;
                   // }

                   $poDate->modify('+' .  $value['delivery_due_dates'] . ' days');
                   $resultDate = $poDate->format('d-m-Y'); // Ensure this line is correct;
                   $currentDate = new DateTime();

                   if ($poDate < $currentDate) {
                       $value['product_delivery_due_days'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
                   } else {
                       $value['product_delivery_due_days'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
                   }
                        // $total = 100; 
                        // $value['percentage']= ($value['total_value']*100)/$total; 

                        $data[]             = array_values($value);
                        $s_no++;
                    }
        
                   
        
                    $json_array = [
                        'draw'                => intval($draw),
                        'recordsTotal'         => intval($total_records),
                        'recordsFiltered'     => intval($total_records),
                        'data'                 => $data,
                         'testing'            => $result->sql,
                         'page_without_tax_total' => moneyFormatIndia($page_without_tax_total), // Total for current page (without tax)
                         'page_with_tax_total' => moneyFormatIndia($page_with_tax_total), // Total for current page (with tax)
                    ];
                } else {
                    print_r($result);
                }
        
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
                    $image_view_3 .= '<a href="javascript:print_pdf_2(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
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




