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
      

      


         case "get_po_details":

        // $main_unique_id = $_POST["main_unique_id"];

        $customer_name = $_POST['customer_name'];

        $po_no         = $_POST['po_no'];


        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];


        $data = [];
        $sno = $start + 1;

        if ($length == '-1') {
            $limit = '';
        } else {
            $limit = $length;
        }

        $table_po = "view_po_wise_list";

        // Columns from your view
        $columns = [
            // "'' as s_no",
            "po_num",
            "DATE_FORMAT(po_date,'%d-%m-%Y') as po_date",
            "get_department_name(department) as department_name",
            "gst",
            "con_name",
            "DATE_FORMAT(consignee_batch_date,'%d-%m-%Y') as consignee_batch_date",
            "con_branch",
            "con_branch_code",
            "cons_billing_address",
            "con_address",
            "get_district_name(con_district) as district",
            "get_state_name(con_state)as state",
            "con_pincode",
            "zone",
            "zone_code",
            "con_contact_no",
            "con_lan_num",
            "consignee_gst",
            "contact_name",
            "department",
            "alter_contact_name",
            "alter_number",
            "cons_email_id",
             "item_code",
             "dc_num",
             "DATE_FORMAT(dc_date,'%d-%m-%Y') as dc_date",
             "invoice_no",
             "DATE_FORMAT(invoice_date,'%d-%m-%Y') as invoice_date",
             "serial_no",
             "courier_name",
             "pod_no",
             "DATE_FORMAT(dispatch_date,'%d-%m-%Y') as dispatch_date",
             "delivery_status",
             "DATE_FORMAT(delivery_date,'%d-%m-%Y')as delivery_date",
             "dc_received_sts as dc_status",
             "DATE_FORMAT(dc_cus_signed_date,'%d-%m-%Y') as dc_sign_date",
             "ir_rec_status as ir_status",
             "DATE_FORMAT(ir_cus_signed_date,'%d-%m-%Y') as ir_date",
             "snr_rec_status as snr_status",
             "snr_cus_signed_date as snr_date",
             "assign_qty",
             "invoice_qty",
            "qty",
            "product",
            "get_executive_name(executive_name) AS executive_name",
            "eng_type",
             "CASE 
        WHEN eng_type = 'own-engineer' AND eng_name = '689dd2899d78831162' THEN 'Service Team'
        WHEN eng_type = 'own-engineer' AND eng_name = '689dd241c69a654753' THEN 'Inhouse Team'
        WHEN eng_type = 'own-engineer' AND eng_name NOT IN('689dd2899d78831162','689dd241c69a654753') THEN get_service_engineer_name(eng_name)
        ELSE eng_name
    END AS eng_name",
            // "eng_name",
            "vendor_bulk_rate",
            "vendor_bulk_gst",
            "bulk_total_amount",
            "cons_followed_by",
             "warranty_duration",
            "billing_gst_no",
            "region",
            "consignee_gst",
            "item_warranty"
            // "batch_entry_date as batch_date"
        ];

        $where = "";

        $table_details = [$table_po, $columns];

        if($po_no){

         $where = "po_unique_id = '" . $po_no . "'";

        }


        // $where = "po_unique_id = '" . $po_no . "' AND department = '" . $customer_name . "' ";

        if ($po_no) {
            $where = "dc_num IS NOT NULL and invoice_no IS NOT NULL and po_unique_id = '" . $po_no . "'"; // Initialize WHERE clause with po_no condition

            if ($customer_name) {
                $where .= " AND department = '" . $customer_name . "'";
            }
        } elseif ($customer_name) { 
            $where = "department = '" . $customer_name . "'";
        }        


        // Apply search filter
        $search_filter = datatable_searching($_POST['search']['value'], $columns);
        if ($search_filter) {
            $where .= " AND ($search_filter)";
        }

        $order_by = ""; // Add ordering logic here if needed



        // Fetch data
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');

    //  print_r($result);die();
        $total_records = total_records();

        if ($result->status) {
            foreach ($result->data as $row) {

                $assign_qty = (empty($row['invoice_qty']) || $row['invoice_qty'] == 0)  ? $row['assign_qty'] : $row['invoice_qty'];

                $snr_status = $row['snr_status'];

                if($snr_status == 1){

                    $snr_qty = $row['invoice_qty'];
                }

                else{
                     $snr_qty = '';

                }




                  $gst_percent = (int) $row['vendor_bulk_gst'];  
                $rate        = (float) $row['vendor_bulk_rate'];     

                if ($gst_percent > 0) {
                $gst_amount = $rate * ($gst_percent / 100);  // GST per unit
                } else {
                $gst_amount = 0;  // No GST
                }

                $ttl_amount = $rate + $gst_amount; // Total with GST



                $total_without_gst = '';
                $total_with_gst    = '';

                if ($row['vendor_bulk_gst'] == 0) {

                   
                    $total_without_gst = ($row['bulk_total_amount']);
                } else  {

                    $total_without_gst =  $rate * $assign_qty;
                    $total_with_gst = $row['bulk_total_amount'];
                }


// print_r($gst_amount);die();
                // $gst =  float($row['gst']);

                // $rate = float($row['vendor_bulk_rate']);

                // $gst_amount = ($rate *($gst / 100));

                $data[] = [
                    "po_num" => $row['po_num'],
                 "po_date" => $row['po_date'],
                "batch_date" => $row['consignee_batch_date'],
                "department_name" => $row['department_name'],
                     "gst" => $row['gst'],
                    "zone" => $row['zone'],
                    "zone_code" => $row['zone_code'],
                    "con_branch" => $row['con_branch'],
                    "con_branch_code" => $row['con_branch_code'], 
                    "cons_billing_address" => $row['cons_billing_address'],
                    "con_address" => $row['con_address'],  
                     "con_district" => $row['district'],
                     "con_pincode" => $row['con_pincode'], 
                      "con_state" => $row['state'],  
                        "contact_name" => $row['contact_name'],                  
                    "con_contact_number" => $row['con_contact_no'],
                    "alter_contact_name" => $row['alter_contact_name'],     
                    "alter_number" => $row['alter_number'],   
                 "cons_email_id" => $row['cons_email_id'],                  
                    "con_lan_num" => $row['con_lan_num'],
                    "item_code" => $row['item_code'],
                    "product_name" => $row['product'],
                    "dc_num" => $row['dc_num'],
                     "dc_date" => $row['dc_date'],
                     "invoice_no" => $row['invoice_no'],
                     "invoice_date" => $row['invoice_date'],
                    "serial_no" => $row['serial_no'],

                    "qty" => $row['qty'],

                    "assign_qty" => $assign_qty,
                    "invoice_qty" => $row['invoice_qty'],

                    "courier_name" => $row['courier_name'],
                    "pod_no" => $row['pod_no'],
                    "dispatch_date" => $row['dispatch_date'],
                    // "delivery_status" => $row['delivery_status'],
                     "delivery_status" => ($row['delivery_status'] == 1) ? 'Yes' : 'No',
                    "delivery_date" => $row['delivery_date'],

                     "warranty_duration" => $row['item_warranty'],
                    "billing_gst_no" => $row['billing_gst_no'],

                    // "delivery_date" => $row['delivery_date'],

                    "dc_status" => ($row['dc_status'] == 1) ? 'Yes' : 'No',
                    "dc_sign_date" => $row['dc_sign_date'],
                    "installed_qty" => ($row['ir_status'] == 1) ? $row['invoice_qty'] : 0,


                    "ir_status" => ($row['ir_status'] == 1) ? 'Yes' : 'No',

                    "ir_date" => $row['ir_date'],
                    "snr_status" => ($row['snr_status'] == 1) ? 'Yes' : '',
                    "snr_qty" => $snr_qty,
                    "snr_date" => $row['snr_date'],
                    "executive_name" => $row['executive_name'],
                     "eng_name" => $row['eng_name'],
                     "vendor_rate" => $row['vendor_bulk_rate'],
                      "vendor_gst" => $row['vendor_bulk_gst'],
                      "tax_amount" => $gst_amount,
                    "vendor_total_amount" => $row['bulk_total_amount'],



                    "ttl_amount_per" => $ttl_amount,
                    "total_price_without_gst" => $total_without_gst,
                    "total_price_with_gst" => $total_with_gst,
                    "cons_followed_by" => $row['cons_followed_by'],
                      "consignee_gst" => $row['consignee_gst'],
                      "region" => $row['region'],
 
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





          case 'get_po_num':

        $customer = $_POST['customer'];

        // $district = $_POST['district'];

        $po_num = get_po_by_customer($customer);

        // print_r($po_num);die();

        $po_num_options = select_option($po_num, "Select PO");

        echo $po_num_options;

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




