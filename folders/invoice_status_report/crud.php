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
        $invoice_no_search          = $_POST['invoice_no_search'];
    // print_r( $po_num_search  );
        $data = [];
        $table_inv = "view_invoice_report_1";
       
        $columns = [
            "'' as s_no",
            'item_code',
            "(SELECT item_description FROM item_creation_sub AS dis WHERE dis.item_code = {$table_inv}.item_code AND dis.is_delete='0' group by dis.item_code) AS item_description",
            'invoice_qty',
            "unit_price",
             'invoice_qty_value',
            "'' as total_value",
            'po_delivery_due_dates',
            "(SELECT warrenty_year FROM product_warrenty AS dis WHERE dis.unique_id = {$table_inv}.warranty) AS warranty",
            "con_address",
            // 'assign_qty',
           
            
            // "con_district",
            // "(SELECT con_address FROM consignee_details_sub AS dis WHERE dis.unique_id = {$table_inv}.consignee_id AND dis.is_delete='0' group by dis.form_main_unique_id) AS con_address",
            "(SELECT district_name FROM district_creation AS dis WHERE dis.unique_id = {$table_inv}.con_district AND dis.is_delete='0' group by $table_inv.po_unique_id) AS con_district",
            'invoice_doc_status',
            'payment_status',
            // 'invoice_qty',
            'invoice_date',
            'invoice_no',
           
          
          
            'po_unique_id',
            'deleivery_status',
            'documents_type',
            'ir_dispatch_mode',
            'dc_required',
            'sign_dc_received_status',
            'status_app',
            'bill_status',
            'e_no',
            'inv_main_unique_id',
            "(SELECT tax FROM product_details_sub AS dis WHERE dis.unique_id = {$table_inv}.product_unique_id AND dis.is_delete='0' group by $table_inv.po_unique_id) AS tax",
            'product_delivery_due_dates',
            "(SELECT warrenty_year FROM product_warrenty AS dis WHERE dis.unique_id = {$table_inv}.product_warranty_duration) AS product_warranty_duration",
           

            'documents_type',
            'ir_dispatch_mode',
            'dc_required',
          
          
          
        ];
    
        $table_details = [$table_inv, $columns];
    
        // Prepare the WHERE clause
        $where = "invoice_no='".$invoice_no_search."'";
      
    //    $group_by="product_unique_id";
    //    $result = $pdo->select($table_details, $where,"","","","",$group_by);
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
              

                $invoice_date = $value['invoice_date']; // Assuming format is 'Y-m-d'
                $current_date = date('Y-m-d'); // Get current date
                
                $invoiceDateObj = new DateTime($invoice_date);
                $currentDateObj = new DateTime($current_date);
                $interval = $currentDateObj->diff($invoiceDateObj);
                $days_difference = $interval->days;
                
                // Determine past or future wording
                if ($invoiceDateObj > $currentDateObj) {
                    $value['invoice_date'] = "$days_difference days remaining";
                } elseif ($poDateObj < $currentDateObj) {
                    $value['invoice_date'] = "$days_difference days ago";
                } else {
                    $value['invoice_date'] = "Today";
                }




             
                $tax = $value['tax'];
                $invoice_qty = $value['invoice_qty'];

                $unit_price = $value['unit_price'];
              
                  $net_value = $invoice_qty * $unit_price; // Base value (quantity * unit price).
            // print_r( $net_value);die();
            $percentage_value = $net_value * ($tax / 100); // Calculate tax.
            $total_value = $net_value + $percentage_value; // Total 
            $value['total_value'] = $net_value + $percentage_value;

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
$qty = $value['qty'];

$po_delivery_due_days = $value['po_delivery_due_dates'];



// Calculate totals for the current page
//  $total_no_of_consignee += $no_of_consignee; // Summing actual numeric values
//  $total_no_of_items += $no_of_items; // Summing actual numeric values
$total_qty += $qty; 

$total_po_delivery_due_days+= $po_delivery_due_days; 

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
// elseif ($value['invoice_doc_status'] == 4) {
//     $value["invoice_doc_status"] = "Dispatch Pending";
// } 

// elseif($value['deleivery_status'] =='') {
//     $value["invoice_doc_status"] = 'Dispatch Pending';
// }
// elseif($value['deleivery_status'] == 1) {
//     $value["invoice_doc_status"] = 'Transit Pending';
// } 
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
                'total_po_delivery_due_days' => moneyFormatIndia($total_po_delivery_due_days),
                
            //    'page_without_tax_total' => moneyFormatIndia($page_without_tax_total),
            //     'page_with_tax_total' => moneyFormatIndia($page_with_tax_total),
            //     'total_po_delivery_due_days' => moneyFormatIndia($total_po_delivery_due_days),
                
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
      

       

        
            case 'rename_data':
                $invoice_no_search = $_POST['invoice_no_search'];
            
                $val1 = '';
                $val2 = '';
            
                            if (!empty($invoice_no_search)) {
                    $data = invoice_no_with_department($invoice_no_search);
            
                    if (!empty($data)) {
                        $val1 = $data[0]['invoice_no'];
                        $val2 = $data[0]['invoice_date']; // Assuming this column exists
                        $val3 = $data[0]['department'];
                        $val4 = $data[0]['executive_name'];
                        $val5 = $data[0]['ledger_name'];
                        $val6 = $data[0]['ledger_no'];
                        
                    }
                }
            
                $json_array = [
                    'val1' => $val1,
                    'val2' => $val2,
                    'val3' => $val3,
                    'val4' => $val4,
                    'val5' => $val5,
                    'val6' => $val6
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




