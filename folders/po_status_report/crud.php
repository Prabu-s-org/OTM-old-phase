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
        // $from_date       = $_POST['from_date'];
        // $to_date         = $_POST['to_date'];
        // $department_name = $_POST['department_name'];
        // $po_numbers      = $_POST['search'];
        // $executive_name  = $_POST['executive_name'];
        // $brand_name      = $_POST['brand_name'];
        $po_num_search          = $_POST['po_num_search'];
    // print_r( $po_num_search  );
        $data = [];
        // $table_po = "view_report_on_item_code";
        $table_po = "view_product_postatus_report";
       
        $columns = [
            "'' as s_no",
            'item_code',
            'item_description',
            // "(SELECT department FROM department_creation AS dis WHERE dis.unique_id = {$table_po}.department) AS department",
            // 'qty',
            "assign_qty",
            // "(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id = {$table_po}.executive_name) AS executive_name",
            'unit_price',
            'without_tax_amount',
            'with_tax_amount',
            // 'tax',
            'po_delivery_due_dates',
            "(SELECT warrenty_year FROM product_warrenty AS dis WHERE dis.unique_id = {$table_po}.warranty) AS warranty",
            // 'warranty',
            'product_delivery_due_dates',
            "(SELECT warrenty_year FROM product_warrenty AS dis WHERE dis.unique_id = {$table_po}.product_warranty_duration) AS product_warranty_duration",
            // 'product_warranty_duration',
            'po_unique_id',
            // "(SELECT delivery_due_dates FROM department_creation AS dis WHERE dis.unique_id = {$table_po}.department) AS department",

        ];
    
        $table_details = [$table_po, $columns];
    
        // Prepare the WHERE clause
        $where = "po_unique_id='".$po_num_search."'";
      
       
        // print_r($where);die();
        // Fetch results from the database
        $result = $pdo->select($table_details, $where);
        // print_r($result);

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
        $warranty=$value['warranty'];
        $product_warranty=$value['product_warranty_duration'];

        $po_delivery_due_dates=$value['po_delivery_due_dates'];
        $product_delivery_due_dates=$value['product_delivery_due_dates'];

        // $value['tax']= $warranty;
// 
// $tax = $value['tax'] . '%';

// $value['tax']=$tax ;
        if($warranty=="")
        {

            // $product_warranty=$value['product_warranty_duration'];
            $value['warranty']=$product_warranty;
        }
        else{
            $value['warranty']= $warranty;
            // $warranty=$value['warranty'];
        }


        
        if($po_delivery_due_dates=="")
        {
           $value['po_delivery_due_dates']= $product_delivery_due_dates;
        }
        else{
            $value['po_delivery_due_dates']= $po_delivery_due_dates;
        }
// new changes

// $no_of_consignee = $value['no_of_consignee'];
// $no_of_items = $value['no_of_items'];
// $qty = $value['qty'];
$assign_qty = $value['assign_qty'];

$po_delivery_due_days = $value['po_delivery_due_dates'];



 // Calculate totals for the current page
//  $total_no_of_consignee += $no_of_consignee; // Summing actual numeric values
//  $total_no_of_items += $no_of_items; // Summing actual numeric values
 $total_qty += $assign_qty; 

 $total_po_delivery_due_days+= $po_delivery_due_days; 




                $data[] = array_values($value);
            }

           
            // Prepare the response JSON
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
               'page_without_tax_total' => moneyFormatIndia($page_without_tax_total),
                'page_with_tax_total' => moneyFormatIndia($page_with_tax_total),
                'total_po_delivery_due_days' => moneyFormatIndia($total_po_delivery_due_days),
                
            //       'total_no_of_consignee' => $total_no_of_consignee,
            //      'total_no_of_items' => $total_no_of_items,
                 'total_no_of_qty' => $total_qty,
                'val1' => $val1,
                'val2' => $val2,
                'val3' => $val3,
                'val4' => $val4,
            ];
    
        } else {
            print_r($result);
        }
    
        echo json_encode($json_array);
        break;
      

        case 'search2':
          
        global $pdo;
       
        $po_num_search          = $_POST['po_num_search'];
   
        $data = [];
        $table_inv = "view_invoice_report_1";
       
        $columns = [
            "'' as s_no",
            // consignee_id
            "con_address",
            // "con_district",
            // "(SELECT con_address FROM consignee_details_sub AS dis WHERE dis.unique_id = {$table_inv}.consignee_id AND dis.is_delete='0' group by dis.form_main_unique_id) AS con_address",
            "(SELECT district_name FROM district_creation AS dis WHERE dis.unique_id = {$table_inv}.con_district AND dis.is_delete='0' group by $table_inv.po_unique_id) AS con_district",
            'item_code',
            "(SELECT item_description FROM item_creation_sub AS dis WHERE dis.item_code = {$table_inv}.item_code AND dis.is_delete='0' group by $table_inv.po_unique_id) AS item_description",
            "(SELECT assign_qty FROM po_product_assign_details AS dis WHERE dis.product_unique_id = {$table_inv}.product_unique_id AND dis.form_main_unique_id = {$table_inv}.po_unique_id and dis.is_delete='0' group by $table_inv.po_unique_id) AS assign_qty",
            // 'assign_qty',
            'invoice_qty',
            'invoice_no',
            'invoice_date',
            'invoice_doc_status',
            'payment_status',
            // 'days_difference',
            'po_date',
            'po_unique_id',
            
            'deleivery_status',
            'documents_type',
            'ir_dispatch_mode',
            'dc_required',
            'sign_dc_received_status',
            'status_app',
            'bill_status',
            'e_no',
          
        ];
    
        $table_details = [$table_inv, $columns];
    
        // Prepare the WHERE clause
        $where = "po_unique_id='".$po_num_search."'";
      
       
        // print_r($where);die();
        // Fetch results from the database
        $result = $pdo->select($table_details, $where);
        // print_r(  $result);
        $total_records = total_records();
        $s_no = 0;
      
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = ++$s_no;
                $deleivery_status= $value['deleivery_status'];
                // $po_date = $value['po_date']; // Assuming this is in 'Y-m-d' format

                // $current_date = date('Y-m-d'); // Get current date in correct format
                
                // $poDateObj = new DateTime($po_date);
                // $currentDateObj = new DateTime($current_date);
                // $interval = $currentDateObj->diff($poDateObj);
                
                // $value['po_date'] = $interval->days; // Store only the number of days
                
                // 'po_date',
            // print_r( $interval);

            $po_date = $value['po_date']; // Assuming format is 'Y-m-d'
            $current_date = date('Y-m-d'); // Get current date
            
            $poDateObj = new DateTime($po_date);
            $currentDateObj = new DateTime($current_date);
            $interval = $currentDateObj->diff($poDateObj);
            $days_difference = $interval->days;
            
            // Determine past or future wording
            if ($poDateObj > $currentDateObj) {
                $value['po_date'] = "$days_difference days remaining";
            } elseif ($poDateObj < $currentDateObj) {
                $value['po_date'] = "$days_difference days ago";
            } else {
                $value['po_date'] = "Today";
            }
            
                
                
                
                


// new changes
if ($value['invoice_doc_status'] == 0) {

    $value["invoice_doc_status"] = "Accounts Team Pending";
}
else if ($value['invoice_doc_status'] == 1) {
    $value["invoice_doc_status"] = "Accounts Team Pending";
} elseif ($value['invoice_doc_status'] == 2) {
    $value["invoice_doc_status"] = "Invoice Rejected";
} elseif ($value['invoice_doc_status'] == 3) {
    $value["invoice_doc_status"] = "Elcot Team Pending";
} 

else if ($value['deleivery_status'] == 1) {
    $value["invoice_doc_status"] = 'Transit Pending';
} 
elseif ($value['deleivery_status'] === '' || $value['deleivery_status'] === null) {
    $value["invoice_doc_status"] = 'Dispatch Pending';
}

elseif ($value['documents_type'] == 0) {
    $value["invoice_doc_status"] = 'Installation pending';
} elseif ($value['ir_dispatch_mode'] == '' && $value['dc_required'] != 'on') {
    $value["invoice_doc_status"] = 'Installation document pending';
} elseif ($value['sign_dc_received_status'] == '' || $value['status_app'] != 2) {
    $value["invoice_doc_status"] = 'Signed document pending';
} elseif ($value['bill_status'] == 0 || $value['bill_status'] == 1) {
    $value["invoice_doc_status"] = 'Elcot Entry Pending';
} elseif ($value['bill_status'] == 3) {
    $value["invoice_doc_status"] = 'Bill Rejected';
} elseif ($value['bill_status'] == 4) {
    $value["invoice_doc_status"] = 'Payment Rejected';
} elseif ($value['e_no'] === '') {
    $value["invoice_doc_status"] = 'Bill submission Pending';
} elseif ($value['payment_status'] == '') {
    $value["invoice_doc_status"] = 'Payment Pending';
} elseif ($value['payment_status'] == 2) {
    $value["invoice_doc_status"] = 'Payment Complete';
}
//  elseif ($value['bg_num'] == '' && $value['with_bg'] == 'on') {
//     $value["invoice_doc_status"] = 'Bg pending';
// }

// Handle payment_status separately
if ($value['payment_status'] == '0' || $value['payment_status'] == '') {
    $value['payment_status'] == '';
} elseif ($value['payment_status'] == '1') {
    $value['payment_status'] = 'Rejected';
} elseif ($value['payment_status'] == '2') {
    $value['payment_status'] = 'Complete';
}

 

                $data[] = array_values($value);
            }

           
            // Prepare the response JSON
            $json_array = [
                'draw' => intval($draw),
                'recordsTotal' => intval($total_records),
                'recordsFiltered' => intval($total_records),
                'data' => $data,
            //    'page_without_tax_total' => moneyFormatIndia($page_without_tax_total),
                // 'page_with_tax_total' => moneyFormatIndia($page_with_tax_total),
                // 'total_po_delivery_due_days' => moneyFormatIndia($total_po_delivery_due_days),
                
            //       'total_no_of_consignee' => $total_no_of_consignee,
            //      'total_no_of_items' => $total_no_of_items,
                //  'total_no_of_qty' => $total_qty,
                // 'val1' => $val1,
                // 'val2' => $val2,
                // 'val3' => $val3,
                // 'val4' => $val4,
            ];
    
        } else {
            print_r($result);
        }
    
        echo json_encode($json_array);
        break;
      

        
            case 'rename_data':
                $po_num_search = $_POST['po_num_search'];
            
                $val1 = '';
                $val2 = '';
            
                            if (!empty($po_num_search)) {
                    $data = po_numers_with_department($po_num_search);
            
                    if (!empty($data)) {
                        $val1 = $data[0]['po_num'];
                        $val2 = $data[0]['po_date']; // Assuming this column exists
                        $val3 = $data[0]['department_name'];
                        $val4 = $data[0]['executive_name'];
                        
                    }
                }
            
                $json_array = [
                    'val1' => $val1,
                    'val2' => $val2,
                    'val3' => $val3,
                    'val4' => $val4
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




