<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table             = "view_payment_entry_list";
$table_claim="view_payment_entry_list_1";
$table_main             = "bill_submission_main_table";
$table_sub   = "bill_submission_sub";



// $table             = "view_bill_submission_list";
$table_sub_form     = "bill_submission_form";
$table_inv     = "invoice_creation_main";
// $table_sub  =  "bill_submission_sub";
// $table_main_table    = "bill_submission_main_table";
$table_bg_main   =  "bg_creation_main";
$table_bg_sub   =  "bg_creation_sub";
$table_sign_doc  =  "sign_doc_verification_detail";

$table_final_elcot = 'view_elcot_entry_final';
include '../../config/dbconfig.php';
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

// Include DB file and Common Functions


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
    case 'createupdate':
        // $ins_unique_id                  = $_POST["ins_unique_id"];
        $bill_form_main_unique_id         = $_POST["bill_form_main_unique_id"];
        $po_num    = $_POST["po_num"];
        $po_date          = $_POST["po_date"];
        // $con_contact_name          = $_POST["con_contact_name"];
        // $con_address          = $_POST["con_address"];
        $invoice_no    = $_POST["invoice_no"];
        $invoice_date          = $_POST["invoice_date"];
        $invoice_value          = $_POST["invoice_value"];
        $file_name          = $_POST["file_name"];
        // $consignee_unique_id    = $_POST["consignee_unique_id"];
        // $scanned_dc_copy          = $_POST["scanned_dc_copy"];
        // $scanned_ir_copy          = $_POST["scanned_ir_copy"];
        // $scanned_snr_copy          = $_POST["scanned_snr_copy"];
        $invoice_copy          = $_POST["invoice_copy"];
        // $installation_reference_no    = $_POST["installation_reference_no"];
        // $supplier_invoice_number          = $_POST["supplier_invoice_number"];
        $unique_id                  = $_POST["unique_id"];
        $bill_status                  = $_POST["bill_status"];
        // $dc_no                  = $_POST["dc_no"];

        $invoice_qty              = $_POST["invoice_qty"];
        $claim_amount              = $_POST["claim_amount"];
        $claim_amt = ((floatval($invoice_value) *  $claim_amount ) / 100);


        $update_where       = "";
        //  if (($file_names) && ($file_org_names) || ($invoice_file_names) && ($invoice_original_name) || ($ir_file_names) && ($ir_file_org_names)) {
        $columns            = [
            'bill_form_main_unique_id'               => $bill_form_main_unique_id,
            'po_num'     => $po_num,
            'po_date'           => $po_date,
            // 'con_contact_name'  => $con_contact_name,
            // 'con_address'          => $con_address,
            'invoice_no'           => $invoice_no,
            'invoice_date'  => $invoice_date,
            'invoice_value'          => $invoice_value,
            // 'file_name'           => $file_name,
            // 'consignee_unique_id'  => $consignee_unique_id,
            'claim_amount'          => $claim_amount,
            // 'installation_reference_no'          => $installation_reference_no,
            // 'supplier_invoice_number'          => $supplier_invoice_number,
            // 'scanned_dc_copy'               => $file_names,
            // 'dc_original_name'     => $file_org_names,
            // 'scanned_snr_copy'               => $snr_file_names,
            // 'snr_original_name'     => $snr_original_name,
            // 'scanned_ir_copy'           => $ir_file_names,
            // 'ir_original_name'  => $ir_file_org_names,
            // 'invoice_copy'          => $invoice_file_names,
            // 'invoice_original_name'          => $invoice_original_name,
            'partial_bill_status'          => 2,
            'bill_status'          => $bill_status,
            'invoice_qty'          => $invoice_qty,
            // 'ins_unique_id'          => $ins_unique_id,
            'claim_amt'          => $claim_amt,
            // 'dc_no'          => $dc_no,
            "unique_id"             => unique_id($prefix)
        ];

        // $columns_5 = [
        //     "bill_status"     => $bill_status,
        // ];
        // // consignee_unique_id
        // // $update_where_1   = [
        // //         "form_main_unique_id"     => $po_form_unique_id
        // //     ];
        // $update_where_5 = 'form_main_unique_id="'.$bill_form_main_unique_id.'" and con_unique_id="'.$consignee_unique_id.'" AND invoice_no="'.$invoice_no.'"  AND ins_unique_id="'.$ins_unique_id.'"  ';
        // $action_obj_5    = $pdo->update($table_bg_sub  ,$columns_5, $update_where_5);
        // print_r($action_obj_5);
        // } else {
        //     $columns            = [
        // 'bill_form_main_unique_id'               => $bill_form_main_unique_id,
        // 'po_num'     => $po_num,
        // 'po_date'           => $po_date,
        // 'con_contact_name'  => $con_contact_name,
        // 'con_address'          => $con_address,
        // 'invoice_no'           => $invoice_no,
        // 'invoice_date'  => $invoice_date,
        // // 'invoice_value'          => $invoice_value,
        // 'file_name'           => $file_name,
        // 'consignee_unique_id'  => $consignee_unique_id,
        // 'invoice_value'          => $invoice_value,
        // 'installation_reference_no'          => $installation_reference_no,
        // 'supplier_invoice_number'          => $supplier_invoice_number,
        //  'bill_status'              => $bill_status,
        //  'invoice_qty'          =>$invoice_qty,
        //  'unique_id'           => unique_id($prefix)
        //     ];
        // }
        // bg main table update
        // $columns_12 = [
        //     "bill_status"     => $bill_status,
        // ];
        // // consignee_unique_id
        // // $update_where_1   = [
        // //         "form_main_unique_id"     => $po_form_unique_id
        // //     ];
        // $update_where_12 = 'form_main_unique_id="' . $bill_form_main_unique_id .'"';
        // $action_obj_12     = $pdo->update($table_bg_main, $columns_12, $update_where_12);
        // invoice main table update
        // $columns_1 = [
        //     "bill_status"     => $bill_status,
        // ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        // $update_where_1 = 'form_main_unique_id="' . $bill_form_main_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" AND invoice_no="' . $invoice_no . '"';
        // $action_obj_1     = $pdo->update($table_inv, $columns_1, $update_where_1);


        $columns_7 = [
            "partial_bill_status"     => $bill_status,
        ];
        // consignee_unique_id
        // $update_where_1   = [
        //         "form_main_unique_id"     => $po_form_unique_id
        //     ];
        $update_where_7 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" AND is_delete=0';
        // and consignee_unique_id="' . $consignee_unique_id . '"
        $action_obj_7     = $pdo->update($table_sub_form , $columns_7, $update_where_7);
// print_r($action_obj_7);
       
        // print_r($action_obj_1);
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where   = [
                "unique_id"     => $unique_id
            ];
            $action_obj     = $pdo->update($table_sub_form, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj     = $pdo->insert($table_sub_form, $columns);
            // Insert Ends
        }
        // print_r($action_obj);
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


        
        


    // case 'datatable':
    //     // DataTable Variables
    //     $search     = $_POST['search']['value'];
    //     $length     = $_POST['length'];
    //     $start         = $_POST['start'];
    //     $draw         = $_POST['draw'];
    //     $limit         = $length;

    //     $data        = [];
    //     $claim_amount = $_POST['claim_amount'];

    //     if ($length == '-1') {
    //         $limit  = "";
    //     }

    //     // Query Variables
    //     $json_array     = "";
    //     $columns        = [
    //         "'' as  s_no",
    //         'po_num',
    //         'po_date',
    //         // 'con_contact_name',
    //         // 'con_address',
    //         'invoice_no',
    //         'invoice_date',
    //         'invoice_value',
    //         'bill_submission_date',
    //         "claim_amount",
    //         'e_no',
    //         // 'net_value',
    //         // 'qty',
    //         "ld_amount",
    //         "ld_days",
            
    //         "delivery_due_dates",
    //         "payement_receive",
    //         "file_name",
    //         "payment_status",
    //         // "payment_date",
    //         'bill_form_unique_id',
    //         "bill_no",
    //         "dc_signed_date",
    //     ];
    //     $table_details  = [
    //         $table,
    //         $columns
    //     ];
    //     // $where          = [
    //     //     "is_delete"     => 0
    //     // ];
    //     // $order_by       = "";
    //         // if($claim_amount='75' || $claim_amount='25' ){
                
    //         //     // $where = " claim_status='1'";
    //         // }
    //     $where = " claim_status='0' and claim_amount!='5' and claim_amount!='25'";

    //     $order_column   = $_POST["order"][0]["column"];
    //     $order_dir      = $_POST["order"][0]["dir"];

    //     // Datatable Ordering 
    //     $order_by       = datatable_sorting($order_column, $order_dir, $columns);

    //     // Datatable Searching
    //     $search         = datatable_searching($search, $columns);

    //     if ($search) {
    //         if ($where) {
    //             $where .= " AND ";
    //         }

    //         $where .= $search;
    //     }

    //     $sql_function   = "SQL_CALC_FOUND_ROWS";

    //     $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
    //     $total_records  = total_records();

    //     if ($result->status) {

    //         $res_array      = $result->data;

    //         foreach ($res_array as $key => $value) {
    //             $value['s_no'] = $sno + 1;

    //             $orgDate = $value['po_date'];  
    //             $value['po_date'] = date("d-m-Y", strtotime($orgDate));

    //             $orgDate1 = $value['invoice_date'];  
    //             $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));

    //             $orgDate2 = $value['bill_submission_date'];  
    //             $value['bill_submission_date'] = date("d-m-Y", strtotime($orgDate2));

    //             $dc_signed_date = $value['dc_signed_date'];  
    //             $value['dc_signed_date'] = date("d-m-Y", strtotime($dc_signed_date));

    //             $net_value = $value['net_value'];

    //             $qty = $value['qty'];
    //             $po_date = $value['po_date'];

    //             $delivery_due_dates = $value['delivery_due_dates'];

    //             $dc_signed_date = $value['dc_signed_date'];

    //             $signedDate = new DateTime($dc_signed_date);

    //             $total_price = $net_value * $qty;

    //             // Create a DateTime object from the given PO date
    //             $poDate = DateTime::createFromFormat('d-m-Y', $po_date);

    //             // Add the specified number of days
    //             $poDate->modify('+' . $delivery_due_dates . ' days');
                

    //             // Display the result PO date
    //             $resultDate = $poDate->format('d-m-Y');
    //             $poDate->setTime(0, 0);
    //             $signedDate->setTime(0, 0);
    //             // Calculate the difference between the result date and signed date
    //             $interval = $poDate->diff($signedDate);

    //             // Get the difference in days
    //             $lddays = $interval->format('%a');

    //             // Update the original array with the new calculated values
    //             $value['net_value'] = $lddays;

    //             // Calculate the new value (25% of the total price)
    //             //172.31.99.126
    //             $basic = ((floatval($salary) * 40) / 100);

    //             $lddays = intval($lddays);  // Convert to integer if needed
    //             $total_price = floatval($total_price);  // Convert to float if needed
                
    //             $ldvalue = ((floatval($lddays) * ($total_price * 0.25) / 100));
                
    //             $value['qty'] = floatval($ldvalue);
               
    //             $btn_update         = btn_update_1($folder_name, $value['bill_form_unique_id'], $value['bill_no']);
    //             $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
    //             // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
    //             $value['bill_form_unique_id'] = $btn_update . $btn_delete;

    //             $payment_receive = $value['payement_receive'];
    //             $payment_status = $value['payment_status'];

    //             if ($payment_receive != '') {
    //                 $value['payement_receive'] =  $payment_receive;
    //             } else {
    //                 $value['payement_receive'] = '-';
    //             }

    //             if (($payment_status == '1') || ($payment_status == '0')) {
    //                 $value['payment_status'] = 'Pending';
    //             } else if ($payment_status == '2') {
    //                 $value['payment_status'] = 'Complete';
    //             }
    //             // if ($value['is_active'] == "1") {
    //             //     $value['is_active']   = "Active";
    //             // } else {

    //             //     $value['is_active']   = "Inactive";
    //             // }


    //             $data[]             = array_values($value);
    //             $sno++;
    //         }

    //         $json_array = [
    //             "draw"                => intval($draw),
    //             "recordsTotal"         => intval($total_records),
    //             "recordsFiltered"     => intval($total_records),
    //             "data"                 => $data,
    //             "testing"            => $result->sql
    //         ];
    //     } else {
    //         print_r($result);
    //     }

    //     echo json_encode($json_array);
    //     break;


        case 'datatable':
            // DataTable Variables
            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $limit         = $length;

              $from_date     = $_POST['from_date'];

               $to_date     = $_POST['to_date'];

               $opt1 = $_POST['opt'];
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
          $table_partial="bill_submission_sub";
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as  s_no",

                "'' as bill_details",
    
                "'' as po_details",
                "'' as invoice_details",
                "'' as customer_details",
                'invoice_value',
                "claim_percentage",
                "'' as claim_value",
                //  'with_bg',
                // "claim_ttl_amount",
               
               
                'bill_form_unique_id',    
                 "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_dates",
                "CASE 
                WHEN invoice_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' 
            THEN DATE_FORMAT(invoice_date, '%d-%m-%Y') 
            ELSE invoice_date 
            END AS invoice_date",
                //  "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                "get_po_number(bill_form_unique_id) as po_num",
                "CASE 
                WHEN po_date LIKE '_--_' THEN po_date
                ELSE DATE_FORMAT(STR_TO_DATE(po_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS po_date",
                // "po_date",
                "invoice_no",   
                // "without_bg",
                "bill_no",
            "DATE_FORMAT(bill_created_date, '%d-%m-%Y') AS bill_created_dates",
            "bill_created_date",


                "partial_bill_status",
                "bill_form_unique_id",
                "claim_percentage",
                "(SELECT dc_required from installation_details  where documents_type = 'DC' AND invoice_no =  bill_submission_sub.invoice_no) as dc_required"
                // "(SELECT ir_status from sign_doc_verification_detail where dc_received_status = '2' AND invoice_no =  $table_partial.invoice_no) AS irstatus"

               
                  

                
            ];
            $table_details  = [
                $table_partial,
                $columns
            ];



            $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
$to_date   = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

// $where ="claim_amount = 25";

$where = '1'; // default (no filter)



if ($opt1 == '40') {
    // Ensure dates are in Y-m-d format for direct SQL comparison
    $from_date_converted = date('Y-m-d', strtotime($from_date));
    $to_date_converted   = date('Y-m-d', strtotime($to_date));

    $where = "
        po_date >= '$from_date_converted' AND 
        po_date <= '$to_date_converted'
    ";
} elseif ($opt1 == '50') {
    $from_date_converted = date('Y-m-d', strtotime($from_date));
    $to_date_converted   = date('Y-m-d', strtotime($to_date));

    $where = "
        bill_created_date >= '$from_date_converted' AND 
        bill_created_date <= '$to_date_converted' ";
}
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
    
            // $where = " partial_bill_status='0' AND claim_amount='95' || claim_amount='75'";  claim_amount!='100' AND   

            // AND (partial_bill_status = 0 OR partial_bill_status IS NULL))
//           $where = "((partial_bill_status != 3) OR (partial_bill_status IS NULL))"; 

// $where .= "AND bill_status = '2' AND sd_status = '0'";

// $where .= "AND (
//     SELECT ir_status 
//     FROM sign_doc_verification_detail 
//     WHERE dc_received_status = '2' 
//     AND invoice_no = bill_submission_sub.invoice_no
// ) = '1' ";

// $where = "((partial_bill_status != 3) OR (partial_bill_status IS NULL))";

// $where .= "AND bill_status = '2' AND sd_status = '0'";

// if($dc_required == '1'){

//     $where .="AND dc_received_status = '1'";
// }

// else{
// $where .= " AND EXISTS (
//     SELECT 1
//     FROM sign_doc_verification_detail 
//     WHERE dc_received_status = '2' 
//     AND invoice_no = bill_submission_sub.invoice_no 
//     AND ir_status = '1'
// )";
// }


$where  = "((partial_bill_status != 3) OR (partial_bill_status IS NULL))";
$where .= " AND bill_status = '2' AND sd_status = '0'";

$where .= " AND (
    (
        EXISTS (
            SELECT 1
            FROM installation_details
            WHERE 
                installation_details.invoice_no = bill_submission_sub.invoice_no
                AND installation_details.documents_type = 'DC'
                AND installation_details.dc_required = '1'
        )
        AND EXISTS (
            SELECT 1
            FROM sign_doc_verification_detail 
            WHERE 
                sign_doc_verification_detail.invoice_no = bill_submission_sub.invoice_no
                AND sign_doc_verification_detail.dc_received_status = '1'
        )
    )
    OR
    (
        NOT EXISTS (
            SELECT 1
            FROM installation_details
            WHERE 
                installation_details.invoice_no = bill_submission_sub.invoice_no
                AND installation_details.documents_type = 'DC'
                AND installation_details.dc_required = '1'
        )
        AND EXISTS (
            SELECT 1
            FROM sign_doc_verification_detail 
            WHERE 
                sign_doc_verification_detail.invoice_no = bill_submission_sub.invoice_no
                AND sign_doc_verification_detail.dc_received_status = '2'
                AND sign_doc_verification_detail.ir_status = '1'
        )
    )
)";


// $where .="AND EXISTS()";

// $where .= "AND (
//     SELECT ir_status 
//     FROM sign_doc_verification_detail 
//     WHERE dc_received_status = '2' 
//     AND invoice_no = bill_submission_sub.invoice_no
//     LIMIT 1
// ) = '1'";

            // AND (claim_amount='90' || claim_amount='75' || claim_amount='95')

            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
            // Datatable Ordering 
            $order_by       = datatable_sorting($order_column, $order_dir, $columns);
    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result);
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    
                    
                    // $value['s_no'] = $sno + 1;
                       $SNO = $sno + 1;
                    $value['s_no'] = '<span class="po_date text-right d-block" id="po">'.$SNO.'</span>';


                    $claim_amount = $value['claim_percentage'];  


                    $invoice_value = $value['invoice_value'];



                    if($claim_amount =='75'){
                        $claim_amt = 100-$claim_amount;
                    }
                    else if($claim_amount =='95'){
                        $claim_amt = 100-$claim_amount;
                    }
                     else if($claim_amount =='90'){
                        $claim_amt = 100-$claim_amount;
                    }
                    elseif($claim_amount =='25'){
                        $claim_amt = 100-$claim_amount;
                    }


                    // $value['claim_amount'] = '<span >' . $value['claim_amount'] . '</span> / <span >' . $claim_amt . '</span>';


                $value['claim_percentage'] = '<span style="font-weight: bold; text-align: right; display: block;">' . $claim_amt . '%</span>';

                    //  $claim_value = indian_format_value($value['claim_ttl_amount']); 


                    //  $value['claim_ttl_amount'] = '<span style="font-weight: bold; text-align: right; display: block;">'. $claim_value .'</span>';



                    //  $value['claim_value'] = claim_value_cal($claim_amt,$invoice_value);
                
                    $claim_value = moneyFormatIndia1(claim_value_cal($claim_amt, $invoice_value));

                    $value['claim_value'] ='<span class="po_date text-right d-block" id="po">'. $claim_value .'</span>';

                   
                        $invoice_no= $value['invoice_no'];  

                        $value['bill_details'] = '<b>'.$value['bill_no'].'</b><br>'.$value['bill_created_dates'];

                      $value['po_details'] = '<b>'.$value['po_num'].'</b><br>'.$value['po_dates'];

                       $value['invoice_details'] = '<b>'.$value['invoice_no'].'</b><br>'.$value['invoice_date'];


                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));invoice_details
                    // $value['po_num'] = '<span class="po_date text-right d-block" id="po">' . $value['po_num'] . '</span> <br> <span class="po_date text-right d-block" id="po">' . $value['po_date'] . '</span>';
                    $value['invoice_no'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_no'] . '</span> <br> <span class="po_date text-right d-block" id="po">' . $value['invoice_date'] . '</span>';

                      $invoice_value = moneyFormatIndia1($value['invoice_value']);
                //  $invoicevalue = moneyFormatIndia1(($invoice_value));
                   $value['invoice_value']  = '<span class="po_date text-right d-block" id="po">'. $invoice_value .'</span>';


                     $value['bill_submission_date'] = '<span class="po_date text-right d-block" id="po">'.  $value['bill_submission_date'].'</span>';

                     
                     $value['e_no'] = '<span class="po_date text-right d-block" id="po">'.  $value['e_no'].'</span>';



                     
            $form_unique_id = $value['bill_form_unique_id'];
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

          

             $value['customer_details'] = '<b>'.$department.'</b><br>'.$customerDistrict .'<br>'.$customerState;




                    if($value['with_bg']=='on'){

                     $bg='yes';

                        $value['with_bg']= '<span style="font-weight: bold; text-align: right; display: block;">' . $bg . '</span>';
                       
                    }
                    if($value['with_bg']=='off'){
                        $bg='No';

                                                $value['with_bg']= '<span style="font-weight: bold; text-align: right; display: block;">' . $bg . '</span>';

                    }

                  
                    $btn_update         = btn_update_invoice($folder_name,$value['bill_form_unique_id'], $invoice_no);  

            //     if($claim_amount=='95'){
            //         $btn_update         = btn_update_invoice($folder_name,$value['bill_form_unique_id'], $invoice_no);  
            //     }
            //   else {
            //     $btn_update='<span style="color:#da1c34;">Go To Ir File upload</span>';
            //   }
            $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                    // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                    $value['bill_form_unique_id'] = $btn_update;
    
                    $payment_receive = $value['payement_receive'];
                    $payment_status = $value['payment_status'];
    
                    if ($payment_receive != '') {
                        $value['payement_receive'] =  $payment_receive;
                    } else {
                        $value['payement_receive'] = '-';
                    }
    
                    if (($payment_status == '1') || ($payment_status == '0')) {
                        $value['payment_status'] = 'Pending';
                    } else if ($payment_status == '2') {
                        $value['payment_status'] = 'Complete';
                    }
                    if ($value['is_active'] == "1") {
                        $value['is_active']   = "Active";
                    } else {
    
                        $value['is_active']   = "Inactive";
                    }
    
    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;


      // get second tab
    case 'partial_bill_datatable':

    $table_partial_final_elcot = 'view_partial_elcot_entry_final';
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $po_num_bill = $_POST['po_num_bill'];
        // $ins_unique_id     = $_POST['ins_unique_id'];
        $table_data = '';
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        // Query Variables
        $json_array = "";
        $columns = [
            "po_num",
            "bank_required",
            "unique_id"
        ];
        $table_po = "po_form";
        $table_details = [
            $table_po,
            $columns
        ];

        // $where = "unique_id ='" . $po_num_bill . "'";
        $result = $pdo->select($table_details, $where);
        if ($result->status) {
            $result_data = $result->data;
            $columns = [
                "file_org_name",
                "'' as s_no",
                "'' as bg_details",
                "'' as po_details",
                "'' as invoice_details",
                "'' as customer_details",
                 "invoice_qty",
                "invoice_value",
                  "claim_amount",
                     "unique_id",   
                //   "bg_date",
           
              "get_ledger_name( 
                (SELECT ledger_name 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.po_num = $table_partial_final_elcot.po_num 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_name",
              "get_ledger_no( 
                (SELECT ledger_no 
                FROM invoice_creation_main 
                WHERE invoice_creation_main.po_num = $table_partial_final_elcot.po_num 
                AND invoice_creation_main.is_delete = 0 
                LIMIT 1)
            ) AS ledger_no",
              
               
               
                "bg_date",


                "DATE_FORMAT(bg_date, '%d-%m-%Y') AS formattedbg_date",

                "bg_num",
                "po_date",
                "invoice_date",
                "invoice_no",
                "invoice_date",
                "CASE 
  WHEN po_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' 
    THEN DATE_FORMAT(po_date, '%d-%m-%Y') 
  ELSE po_date 
END AS formattedpo_date",
 "CASE 
  WHEN invoice_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' 
    THEN DATE_FORMAT(invoice_date, '%d-%m-%Y') 
  ELSE invoice_date 
END AS formattedinvoice_date",

                //  "DATE_FORMAT(po_date,'%d-%m-%Y')as formattedpo_date",
                //  "DATE_FORMAT(invoice_date,'%d-%m-%Y')as formattedinvoice_date",
                // "bg_value",
                "po_num",
                
                // "select claim_amount from bill_submission_form where bill_submission_form.bill_form_main_unique_id=$table_final_elcot.bill_form_unique_id)as claim_amount",
            ];
            $table_details = [
                $table_partial_final_elcot,
                $columns
            ];
            // $where          = [
            //     "is_delete"     => 0
            // ];
            // $order_by       = "";
            // if ($po_num_bill == '') {
            $where = "bill_status='1'";
            //  AND ins_unique_id='".$ins_unique_id."'
            // AND ins_unique_id='".$ins_unique_id."'
            // } else if ($po_num_bill != '') {
            //     $where = "unique_id ='" . $po_num_bill . "' and  bill_status='1'";
            // }
            // print_r($where);die();
            $order_column = $_POST["order"][0]["column"];
            $order_dir = $_POST["order"][0]["dir"];
            // Datatable Ordering 
            $order_by = datatable_sorting($order_column, $order_dir, $columns);
            // Datatable Searching
            $search = datatable_searching($search, $columns);
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
                $where .= $search;
            }
            $sql_function = "SQL_CALC_FOUND_ROWS";
            $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result);
            $total_records = total_records();
            if ($result->status) {
                $res_array = $result->data;
                foreach ($res_array as $key => $value) {
                    $orgDate = $value['po_date'];
                    $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                    $orgDate1 = $value['invoice_date'];
                    $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    if ($value['bg_num'] == '') {
                        $value['bg_num'] = 'NA';
                    }
                    if ($value['bg_date'] == '') {
                        $value['bg_date'] = 'NA';
                    }
                    if ($value['bg_value'] == '') {
                        $value['bg_value'] = 'NA';
                    }
                    // if ($value['con_contact_NAme'] == '') {
                    //     $value['con_contact_NAme'] = 'NA';
                    // }
                    // if ($value['con_address'] == '') {
                    //     $value['con_address'] = 'NA';
                    // }
                    if ($value['invoice_no'] == '') {
                        $value['invoice_no'] = 'NA';
                    }
                    if ($value['invoice_date'] == '') {
                        $value['invoice_date'] = 'NA';
                    }
                    // $value['s_no'] = $sno + 1;
                        $SNO = $sno + 1;
                    $value['s_no'] = '<span class="po_date text-right d-block" id="po">'.$SNO.'</span>';

                    //  $value['file_NAme']= image_view("po_form", $value['consignee_unique_id'], $value['file_NAme']);
                    $value['file_org_name'] = '<input class="myChck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >
                        <input type="hidden" name="bill_form_unique_id"  id="bill_form_unique_id" value="' . $value['unique_id'] . '">
                        <input type="hidden" name="po_num"  id="po_num" value="' . $value['po_num'] . '">
                        <input type="hidden" name="po_date"  id="po_date" value="' . $value['po_date'] . '">
                        <input type="hidden" name="invoice_no[]"  id="invoice_no" value="' . $value['invoice_no'] . '">
                        <input type="hidden" name="invoice_qty[]"  id="invoice_qty" value="' . $value['invoice_qty'] . '">
                        <input type="hidden" name="invoice_value[]"  id="invoice_value" value="' . $value['invoice_value'] . '">
                        <input type="hidden" name="bg_num[]" id="bg_num" value="' . $value['bg_num'] . '">
                      
                        <input type="hidden" name="bg_date[]" id="bg_date" value="' . $value['bg_date'] . '">
                        <input type="hidden" name="bg_value[]" id="bg_value" value="' . $value['bg_value'] . '">
                        <input type="hidden" name="invoice_date[]" id="invoice_date" value="' . $value['invoice_date'] . '">
                       
                       
                        <input type="hidden" name="claim_amount"  id="claim_amount" value="' . $value['claim_amount'] . '">
                       
                       
                        <input type="hidden" name="invoice_date"  id="invoice_date" value="' . $value['invoice_date'] . '">
                        <input type="hidden" name="bank_required" id="bank_required" value="' . $result_data[0]['bank_required'] . '">';


                $value['bg_details'] = '<b>'.$value['bg_num'].'</b><br>'.$value['formattedbg_date'];

                $value['po_details'] = '<b>'.$value['po_num'].'</b><br>'.$value['formattedpo_date'];

                $value['invoice_details'] = '<b>'.$value['invoice_no'].'</b><br>'.$value['formattedinvoice_date'];



                                  
            $form_unique_id = $value['unique_id'];
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

          

             $value['customer_details'] = '<b>'.$department.'</b><br>'.$customerDistrict .'<br>'.$customerState;

// invoice_details


                //   $value['bg_date'] = '<span class="po_date text-right d-block" id="po">' .$value['bg_date'] . '</span>';
                //   $value['bg_num'] = '<span class="po_date text-right d-block" id="po">' .$value['bg_num'] . '</span>';
                  $value['po_date'] = '<span class="po_date text-right d-block" id="po">' .$value['po_date'] . '</span>';
                  $value['po_num'] = '<span class="po_date text-right d-block" id="po">' .$value['po_num'] . '</span>';
                  $value['invoice_date'] = '<span class="po_date text-right d-block" id="po">' .$value['invoice_date'] . '</span>';
                  $value['invoice_no'] = '<span class="po_date text-right d-block" id="po">' .$value['invoice_no'] . '</span>';
                  $value['invoice_qty'] = '<span class="po_date text-right d-block" id="po">' .$value['invoice_qty'] . '</span>';
                  $value['invoice_value'] = '<span class="po_date text-right d-block" id="po">' .$value['invoice_value'] . '</span>';
                  $value['claim_amount'] = '<span class="po_date text-right d-block" id="po">' . $value['claim_amount'] . '</span>';


                     








                    $data[] = array_values($value);
                    $sno++;
                }
                $sno++;
                $json_array = [
                    "draw" => intval($draw),
                    "recordsTotal" => intval($total_records),
                    "recordsFiltered" => intval($total_records),
                    "data" => $data,
                    "testing" => $result->sql
                ];
            } else {
                print_r($result);
            }
        }
        echo json_encode($json_array);
        break;



      // get second tab
    case 'partial_payment_datatable':

     $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $limit         = $length;


            $po_id = $_POST['po_id'];
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
          $table_partial="bill_submission_sub";
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as chek_box",
                "'' as  s_no",
                       "('') AS bg_no", 

                "'' as bill_details",
                "'' as po_details",
                "'' as invoice_details",
                "'' as customer_details",
                'invoice_value',

                "claim_percentage",
                "'' as claim_value",
                // 'with_bg',
                'bill_form_unique_id',

            //    "claim_ttl_amount",
                //  "claim_amount",
                
                 "CASE 
                WHEN po_date LIKE '_--_' THEN po_date
                ELSE DATE_FORMAT(STR_TO_DATE(po_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS po_date",
                //  "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                "CASE 
                WHEN invoice_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' 
            THEN DATE_FORMAT(invoice_date, '%d-%m-%Y') 
            ELSE invoice_date 
            END AS invoice_date",
                //  "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                "po_num",
                "invoice_no",   
                // "without_bg",
                "bill_no",
            "DATE_FORMAT(bill_created_date, '%d-%m-%Y') AS bill_created_date",
                "partial_bill_status",

    //             "(SELECT bg_date 
    //  FROM bg_creation_sub AS bg 
    //  WHERE bg.form_main_unique_id = view_partial_bill_1.bill_form_unique_id 
    //    AND bg.invoice_no = view_partial_bill_1.invoice_no 
    //  LIMIT 1) AS bg_date", 

      "partial_bill_status",
                "bill_form_unique_id",
                "claim_percentage",

      "('') AS bg_value", 
     "invoice_qty"

                //  "(SELECT bg_num from bg_creation_sub where form_main_unique_id  = $table_partial.bill_form_unique_id AND invoice_no  = $table_partial.invoice_no ) AS  bg_no"
                     
            ];
            $table_details  = [
                $table_partial,
                $columns
            ];
           
    
            // $where = " partial_bill_status='0' AND claim_amount='95' || claim_amount='75'";   
            // $where = "claim_amount!='100' AND (partial_bill_status = 0 ||  partial_bill_status IS NULL) ";   

//               $where = "((partial_bill_status != 3) OR (partial_bill_status IS NULL))"; 

// $where .= " AND bill_status = '2' AND sd_status = '0'  ";


// $where .= " AND EXISTS (
//     SELECT 1
//     FROM sign_doc_verification_detail 
//     WHERE dc_received_status = '2' 
//     AND invoice_no = bill_submission_sub.invoice_no
//     AND ir_status = '1'
// )";

$where  = "((partial_bill_status != 3) OR (partial_bill_status IS NULL))";
$where .= " AND bill_status = '2' AND sd_status = '0'";

$where .= " AND (
    (
        EXISTS (
            SELECT 1
            FROM installation_details
            WHERE 
                installation_details.invoice_no = bill_submission_sub.invoice_no
                AND installation_details.documents_type = 'DC'
                AND installation_details.dc_required = '1'
        )
        AND EXISTS (
            SELECT 1
            FROM sign_doc_verification_detail 
            WHERE 
                sign_doc_verification_detail.invoice_no = bill_submission_sub.invoice_no
                AND sign_doc_verification_detail.dc_received_status = '1'
        )
    )
    OR
    (
        NOT EXISTS (
            SELECT 1
            FROM installation_details
            WHERE 
                installation_details.invoice_no = bill_submission_sub.invoice_no
                AND installation_details.documents_type = 'DC'
                AND installation_details.dc_required = '1'
        )
        AND EXISTS (
            SELECT 1
            FROM sign_doc_verification_detail 
            WHERE 
                sign_doc_verification_detail.invoice_no = bill_submission_sub.invoice_no
                AND sign_doc_verification_detail.dc_received_status = '2'
                AND sign_doc_verification_detail.ir_status = '1'
        )
    )
)";




            $where .= " AND bill_form_unique_id = '$po_id' "; 
            // AND (claim_amount='90' || claim_amount='75' || claim_amount='95')

            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
            // Datatable Ordering 
            $order_by       = datatable_sorting($order_column, $order_dir, $columns);
    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result );
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    


                     $bg_num = $value['bg_no'];
                    
                    // $value['s_no'] = $sno + 1;
                       $SNO = $sno + 1;
                    $value['s_no'] = '<span class="po_date text-right d-block" id="po">'.$SNO.'</span>';


                    $claim_amount = $value['claim_percentage'];  


                    $invoice_value = $value['invoice_value'];


                    if($claim_amount =='75'){
                        $claim_amt = 100-$claim_amount;
                    }
                    else if($claim_amount =='95'){
                        $claim_amt = 100-$claim_amount;
                    }
                     else if($claim_amount =='90'){
                        $claim_amt = 100-$claim_amount;
                    }
                    elseif($claim_amount =='25'){
                        $claim_amt = 100-$claim_amount;
                    }


                     $claim_amntcheck_value = (claim_value_cal($claim_amt, $invoice_value));


            // $value['chek_box'] = '<input type="checkbox" name="row_select[]">';
                    
                      $value['bg_no'] = '<b>'.$value['bg_no'].'</b><br>'.$value['bg_date'];


                     
                



                $value['chek_box'] = '<input class="myCheck" type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >
                        <input type="hidden" name="bill_form_unique_id"  id="bill_form_unique_id" value="' . $value['bill_form_unique_id'] . '">
                        <input type="hidden" name="po_num"  id="po_num" value="' . $value['po_num'] . '">
                        <input type="hidden" name="po_date"  id="po_date" value="' . $value['po_date'] . '">
                        <input type="hidden" name="invoice_no[]"  id="invoice_no" value="' . $value['invoice_no'] . '">
                        <input type="hidden" name="invoice_qty[]"  id="invoice_qty" value="' . $value['invoice_qty'] . '">
                        <input type="hidden" name="invoice_value[]"  id="invoice_value" value="' . $value['invoice_value'] . '">
                        <input type="hidden" name="bg_num[]" id="bg_num" value="' . $bg_num . '">
                      
                        <input type="hidden" name="bg_date[]" id="bg_date" value="' . $value['bg_date'] . '">
                        <input type="hidden" name="bg_value[]" id="bg_value" value="' . $value['bg_value'] . '">
                        <input type="hidden" name="invoice_date[]" id="invoice_date" value="' . $value['invoice_date'] . '">
                       
                        <input type="hidden" name="claim_checkpercent"  id="claim_checkpercent" value="' . $claim_amt . '">


                        <input type="hidden" name="claim_checkamount"  id="claim_checkamount" value="' . $claim_amntcheck_value. '">
                       
                       
                        <input type="hidden" name="invoice_date"  id="invoice_date" value="' . $value['invoice_date'] . '">';

                      


                


            $value['claim_percentage'] = '<span style="font-weight: bold; text-align: right; display: block;">' . $claim_amt . '%</span>';


                    //  $value['claim_value'] = claim_value_cal($claim_amt,$invoice_value);
                
                   $claim_value = moneyFormatIndia1(claim_value_cal($claim_amt, $invoice_value));

                    $value['claim_value'] ='<span class="po_date text-right d-block" id="po">'. $claim_value .'</span>';



                    //  $claim_value = indian_format_value($value['claim_ttl_amount']); 


                    //  $value['claim_ttl_amount'] = '<span style="font-weight: bold; text-align: right; display: block;">'. $claim_value .'</span>';



                
                   
                    $invoice_no= $value['invoice_no'];  

                        $value['bill_details'] = '<b>'.$value['bill_no'].'</b><br>'.$value['bill_created_date'];

                      $value['po_details'] = '<b>'.$value['po_num'].'</b><br>'.$value['po_date'];

                       $value['invoice_details'] = '<b>'.$value['invoice_no'].'</b><br>'.$value['invoice_date'];


                    // $value['po_date'] = date("d-m-Y", strtotime($orgDate));invoice_details
                    // $value['po_num'] = '<span class="po_date text-right d-block" id="po">' . $value['po_num'] . '</span> <br> <span class="po_date text-right d-block" id="po">' . $value['po_date'] . '</span>';
                    $value['invoice_no'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_no'] . '</span> <br> <span class="po_date text-right d-block" id="po">' . $value['invoice_date'] . '</span>';

                      $invoice_value = moneyFormatIndia1($value['invoice_value']);
                //  $invoicevalue = moneyFormatIndia1(($invoice_value));
                    $value['invoice_value'] = '<span style="display: block; text-align: right;">' . $invoice_value . '</span>';


                     $value['bill_submission_date'] = '<span class="po_date text-right d-block" id="po">'.  $value['bill_submission_date'].'</span>';

                     
                     $value['e_no'] = '<span class="po_date text-right d-block" id="po">'.  $value['e_no'].'</span>';



                     
            $form_unique_id = $value['bill_form_unique_id'];
            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

          

             $value['customer_details'] = '<b>'.$department.'</b><br>'.$customerDistrict .'<br>'.$customerState;

                  

                    if($value['with_bg']=='on'){
                        $value['with_bg']='yes';
                    }
                    if($value['with_bg']=='off'){
                        $value['with_bg']='No';
                    }

                  
                    // $btn_update         = btn_update_invoice($folder_name,$value['bill_form_unique_id'], $invoice_no);  

         
            $value['file_name'] = image_view_3("payment", $value['bill_form_unique_id'], $value['file_name']);
                    // // $btn_delete         = btn_delete($folder_name,$value['bill_form_unique_id'],$value['bill_no']);
                    $value['bill_form_unique_id'] = $btn_update;
    
                    $payment_receive = $value['payement_receive'];
                    $payment_status = $value['payment_status'];
    
                    if ($payment_receive != '') {
                        $value['payement_receive'] =  $payment_receive;
                    } else {
                        $value['payement_receive'] = '-';
                    }
    
                    if (($payment_status == '1') || ($payment_status == '0')) {
                        $value['payment_status'] = 'Pending';
                    } else if ($payment_status == '2') {
                        $value['payment_status'] = 'Complete';
                    }
                    if ($value['is_active'] == "1") {
                        $value['is_active']   = "Active";
                    } else {
    
                        $value['is_active']   = "Inactive";
                    }
    
    
                    $data[]             = array_values($value);
                    $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;





           case 'customerDetails':

            $search     = $_POST['search']['value'];
            $length     = $_POST['length'];
            $start         = $_POST['start'];
            $draw         = $_POST['draw'];
            $limit         = $length;


            $po_id = $_POST['po_id'];
    
            $data        = [];
    
    
            if ($length == '-1') {
                $limit  = "";
            }
          $table_partial="view_partial_bill_1";
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as chek_box",
                "'' as  s_no",
                "'' as bill_details",
    
                "'' as po_details",
                "'' as invoice_details",
                "'' as customer_details",
                'invoice_value',

                "'' as claim_percent",
                "'' as claim_value",
                'with_bg',
                'bill_form_unique_id',

               "claim_ttl_amount",
                "claim_amount",
                
                //  "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                "CASE 
                WHEN po_date LIKE '_--_' THEN po_date
                ELSE DATE_FORMAT(STR_TO_DATE(po_date, '%Y-%m-%d'), '%d-%m-%Y')
            END AS po_date",
                "CASE 
                WHEN invoice_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' 
            THEN DATE_FORMAT(invoice_date, '%d-%m-%Y') 
            ELSE invoice_date 
            END AS invoice_date",
                //  "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                "po_num",
                "invoice_no",   
                // "without_bg",
                "bill_no",
            "DATE_FORMAT(bill_created_date, '%d-%m-%Y') AS bill_created_date",
                "partial_bill_status",

    //              "(SELECT bg_num 
    //  FROM bg_creation_sub AS bg 
    //  WHERE  bg.invoice_no =  $table_partial.invoice_no 
    //  LIMIT 1) AS bg_no",

    //  "(SELECT bg_date 
    //  FROM bg_creation_sub 
    //  WHERE  invoice_no =  $table_partial.invoice_no 
    //  LIMIT 1) AS bg_date,"
                     
            ];
            $table_details  = [
                $table_partial,
                $columns
            ];
           
    
            // $where = " partial_bill_status='0' AND claim_amount='95' || claim_amount='75'";   
            $where = "claim_amount!='100' AND (partial_bill_status = 0 ||  partial_bill_status IS NULL)";   


            $where .= " AND bill_form_unique_id = '$po_id'"; 
            // AND (claim_amount='90' || claim_amount='75' || claim_amount='95')

            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
    
            // Datatable Ordering 
            $order_by       = datatable_sorting($order_column, $order_dir, $columns);
    
            // Datatable Searching
            $search         = datatable_searching($search, $columns);
    
            if ($search) {
                if ($where) {
                    $where .= " AND ";
                }
    
                $where .= $search;
            }
    
            $sql_function   = "SQL_CALC_FOUND_ROWS";
    
            $result         = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
            // print_r($result );
            $total_records  = total_records();
    
            if ($result->status) {
    
                $res_array      = $result->data;
    
                foreach ($res_array as $key => $value) {
                    
                    
                    // $value['s_no'] = $sno + 1;
                       $SNO = $sno + 1;
            $value['s_no'] = '<span class="po_date text-right d-block" id="po">'.$SNO.'</span>';

            $form_unique_id = $value['bill_form_unique_id'];     


            $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); 



            $po_num    = $value['po_num'];

            $po_date    = $value['po_date'];


            $dep_name     =   $department;
            $addrss       =  $customerAddress;
            $district     =  $customerDistrict;
            $state        =   $customerState;
            
            $cnt_num      =   $customerContact;
            $email        =   $customerEmail;


            $value['po_number'] = $po_num;
$value['po_date'] = $po_date;
$value['department'] = $dep_name;
$value['address'] = $addrss;
$value['district'] = $district;
$value['state'] = $state;
$value['contact'] = $cnt_num;
$value['email'] = $email;

// $value['bg']

        
           $data[] = $value;
            $sno++;
                }
    
                $json_array = [
                    "draw"                => intval($draw),
                    "recordsTotal"         => intval($total_records),
                    "recordsFiltered"     => intval($total_records),
                    "data"                 => $data,
                    "testing"            => $result->sql
                ];
            } else {
                print_r($result);
            }
    
            echo json_encode($json_array);
            break;




        













         // partial create bill
    case 'partial_bill_main':
        $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        $claim_percent = $_POST["claim_percent"];
        // $con_address = $_POST["con_address"];
        $invoice_no = $_POST["invoice_no"];
        // $invoice_no_val             = $_POST["invoice_no"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_value = $_POST["invoice_value"];



        $claim_value = $_POST['claim_value'];

        $invoice_qty = $_POST["invoice_qty"];
        // $consignee_unique_id = $_POST["consignee_unique_id"];
        $bg_num = $_POST["bg_num"];
        // $claim_amount               = $_POST["claim_amount"];
        // $bg_id               = $_POST["bg_id"];
        $bg_date = $_POST["bg_date"];
        $bg_value = $_POST["bg_value"];

//   $claim_amount              = $_POST["claim_amount"];
        // $claim_amt = ((floatval($invoice_value) *  $claim_amount ) / 100);
// print_r($claim_amt );

        $columns = [
            'bill_form_main_unique_id' => $bill_form_main_unique_id,
            'po_num' => $po_num,
            'po_date' => $po_date,

            'claim_amount' => $claim_percent,
            // 'con_address' => $con_address,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_value' => $invoice_value,
            'invoice_qty' => $invoice_qty,
            // 'consignee_unique_id' => $consignee_unique_id,
            'bg_num' => $bg_num,
            // 'bg_id'           => $bg_id,
            'bg_date' => $bg_date,
            "bg_value" => $bg_value,
            "claimamt"           => $claim_value,
            'partial_bill_status' => 3,

            "bill_status" => 2,
            'bill_no' => bill_no_get(),
            // 'bill_created_date' => date('d-m-Y'),
            'bill_created_date' => date('Y-m-d'),


            'unique_id' => unique_id($prefix)
        ];
        

        // print_r($bill_form_main_unique_id);die();
        $table_bg_main = "bg_creation_main";

        $table_main_table = "bill_submission_main_table";

          $table_sub = "bill_submission_sub";

        

        if ($bg_num != 'NA') {
            // bg main table update status
            $columns_3 = [
                "bill_status" => 2,
            ];
            // $update_where_3 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  and bg_num="' . $bg_num . '" and invoice_no="'.$invoice_no."'";
            $update_where_3 = "form_main_unique_id='" . $bill_form_main_unique_id . "' and bg_num='" . $bg_num . "' and invoice_no='" . $invoice_no . "'";
            // and invoice_no="' . $invoice_no . '"
            $action_obj_3 = $pdo->update($table_bg_main, $columns_3, $update_where_3);

        }
        // Update Begins
        if ($unique_id) {
            unset($columns['unique_id']);
            $update_where = [
                "unique_id" => $unique_id
            ];
            $action_obj = $pdo->update($table_main_table, $columns, $update_where);
            // Update Ends
        } else {
            // Insert Begins
            $action_obj = $pdo->insert($table_main_table, $columns);

         


            //  print_r($action_obj_8);die();

          
            // Insert Ends
        }

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

    // bill sub table store
    case 'partial_bill_creation_add_update':

        $bill_form_main_unique_id = $_POST["bill_form_unique_id"];
        $po_num = $_POST["po_num"];
        $po_date = $_POST["po_date"];
        // $con_contact_name = $_POST["con_contact_name"];
        // $con_address = $_POST["con_address"];
        $invoice_no = $_POST["invoice_no"];
        $invoice_date = $_POST["invoice_date"];
        $invoice_value = $_POST["invoice_value"];
        $invoice_qty = $_POST["invoice_qty"];



        $claim_amount  = $_POST["claim_amount"];

        $claim_percent  = $_POST["claim_percent"];



       


       $table_sub_form     = "bill_submission_form";

        // $columns_8 = [
        //     "bill_status" => 2,
           
        // ];
      
        // $update_where_8 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0';
      
        // $action_obj_8 = $pdo->insert($table_sub_form, $columns_8, $update_where_8);


        //  $columns_8 = [
        //     "partial_bill_status" => 3,
           
        // ];
      
        // $update_where_8 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '" AND invoice_no="' . $invoice_no . '" AND is_delete=0 and partial_bill_status=2';
        // // and consignee_unique_id="' . $consignee_unique_id . '" 
        // $action_obj_8 = $pdo->update($table_sub_form, $columns_8, $update_where_8);
      


        
$table_main_table = "bill_submission_main_table";

        $columns1 = [
            'bill_no',
        ];
        // count taken start
        $table_details = [
            $table_main_table,
            [
                'COUNT(unique_id) AS count',
                // 'bill_no',
                'MAX(bill_no) AS last_bill_no',
                // "invoice_no",
            ],
        ];
        $select_where = "is_delete = 0 ";
        // AND partial_bill_status IS NULL
        // AND bill_form_main_unique_id = '" . $bill_form_main_unique_id . "' and invoice_no='" . $invoice_no . "'
        // and consignee_unique_id='" . $consignee_unique_id .'
        $order_by = "id DESC";
        $action_obj = $pdo->select($table_details, $select_where, '', '', $order_by);
        // print_r($action_obj);die();
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
        if ($data[0]['count'] == 0) {
            $msg = 'already';
        } else if ($data[0]['count'] != 0) {
            $last_bill_nos = $data[0]['last_bill_no'];


            // print_r($data[0]['last_bill_no']);die();
            // count taken end
            $update_where = "";
            $columns = [
                'bill_form_unique_id' => $bill_form_main_unique_id,
                'po_num' => $po_num,
                'po_date' => $po_date,
                // 'con_contact_name' => $con_contact_name,
                // 'con_address' => $con_address,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'invoice_value' => $invoice_value,
                'invoice_qty' => $invoice_qty,
                  "claimamt" => $claim_amount,

                "claim_percentage" => $claim_percent,
                // "invoice_auto_id"    => $invoice_auto_id,
                // "ins_unique_id"    => $ins_unique_id,
                // 'consignee_unique_id' => $consignee_unique_id,
                'partial_bill_status' => 3,
                'sd_status' => 2,
                'bill_status' => 2,
                'bill_no' => $last_bill_nos,
                   'bill_created_date' => date('Y-m-d'),
                'unique_id' => unique_id($prefix)
            ];


              $columns_main = [
                'bill_form_main_unique_id' => $bill_form_main_unique_id,
                'po_num' => $po_num,
                'po_date' => $po_date,
                // 'con_contact_name' => $con_contact_name,
                // 'con_address' => $con_address,
                'invoice_no' => $invoice_no,
                'invoice_date' => $invoice_date,
                'invoice_value' => $invoice_value,
                'invoice_qty' => $invoice_qty,
                  "claim_amount" => $claim_percent,

                "claim_amt" => $claim_amount,
                // "invoice_auto_id"    => $invoice_auto_id,
                // "ins_unique_id"    => $ins_unique_id,
                // 'consignee_unique_id' => $consignee_unique_id,
                'partial_bill_status' => 3,
                'bill_status' => 2,
                'sd_status' => 2,
                'bill_no' => $last_bill_nos,
                //    'bill_created_date' => date('Y-m-d'),
                'unique_id' => unique_id($prefix)
            ];
         
         

            // new changes====================
            $columns_9 = [
                "bill_no" => $last_bill_nos,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_9 = 'bill_form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" AND partial_bill_status="3"';

            $columns_10 = [
                "bill_no" => $last_bill_nos,
            ];
            // consignee_unique_id
            // $update_where_1   = [
            //         "form_main_unique_id"     => $po_form_unique_id
            //     ];
            $update_where_10 = 'form_main_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" ';
            // AND con_unique_id="' . $consignee_unique_id . '"

            $action_obj_10 = $pdo->update($table_sign_doc, $columns_10, $update_where_10);
            // print_r($action_obj_10);
            // end===========


              $update_where_sd = 'bill_form_unique_id="' . $bill_form_main_unique_id . '"  AND invoice_no="' . $invoice_no . '" ';

            $columns_sd =[
                'sd_status' => 1,
            ];

            $action_obj_sd = $pdo->update($table_sub, $columns_sd, $update_where_sd);

            $action_obj = $pdo->insert($table_sub, $columns);

             $action_obj2 = $pdo->insert($table_sub_form, $columns_main);




            // $action_obj = $pdo->insert()
            // print_r($action_obj);
            // die();
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


 case 'bill_generate_datatable':

    $table_main_table_1 = "view_bill_submission_main_table";
        // print_r('hi');
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        // $form_main_unique_id         = $_POST['bill_form_main_unique_id'];
        // $invoice_no         = $_POST['invoice_no'];
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "'' as bill_details",
            "po_num",
            "'' as customer_details",
       


           "(SELECT COUNT(invoice_no)
  FROM bill_submission_sub AS sub
  WHERE sub.bill_no = view_bill_submission_main_table.bill_no
  AND is_delete = 0) AS invcount",

                  "invoice_value",
                 "claim_amount",
              "'' as claimamnt", // fixed empty column
                   "bg_num",
                   "''as view",
            "invoice_no",
            "invoice_date",
           
           
            "bill_status",
            "po_date",
            "bill_no",
            "bill_form_main_unique_id",
             "DATE_FORMAT(bill_created_date,'%d-%m-%Y') AS bill_created_dates",
             "bill_created_date"

        ];
        $table_details = [
            $table_main_table_1,
            $columns
        ];

      
        
// Handle date inputs safely
$from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : '';
$to_date   = !empty($_POST['to_date']) ? $_POST['to_date'] : '';

// $where = '1'; // default (no filter)


$where = "partial_bill_status = '3'";

if ($opt1 == '40') {
    $from_date_converted = date('Y-m-d', strtotime($from_date));
    $to_date_converted   = date('Y-m-d', strtotime($to_date));

    $where .= " AND po_date >= '$from_date_converted' AND po_date <= '$to_date_converted'";
} elseif ($opt1 == '50') {
    $from_date_converted = date('Y-m-d', strtotime($from_date));
    $to_date_converted   = date('Y-m-d', strtotime($to_date));

    $where .= " AND bill_created_date >= '$from_date_converted' AND bill_created_date <= '$to_date_converted'";
}



// if ($opt1 == '40') {
//     // Ensure dates are in Y-m-d format for direct SQL comparison
//     $from_date_converted = date('Y-m-d', strtotime($from_date));
//     $to_date_converted   = date('Y-m-d', strtotime($to_date));

//     $where = "
//         po_date >= '$from_date_converted' AND 
//         po_date <= '$to_date_converted'
//     ";
// } elseif ($opt1 == '50') {
//     $from_date_converted = date('Y-m-d', strtotime($from_date));
//     $to_date_converted   = date('Y-m-d', strtotime($to_date));

//     $where = "
//         bill_created_date >= '$from_date_converted' AND 
//         bill_created_date <= '$to_date_converted' ";
// }



        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        // Datatable Searching
        // $search = datatable_searching($search, $columns);
        // if ($search) {
        //     if ($where) {
        //         $where .= " AND ";
        //     }
        //     $where .= $search;
        // }
        // $where ="partial_bill_status = '3' ";


        
        $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);die();
        $total_records = total_records();
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                // $value['s_no'] = $sno + 1;
                   $SNO = $sno + 1;
        $value['s_no'] = '<span class="po_date text-right d-block" id="po">'.$SNO.'</span>';

            $invoice_value=$value['invoice_value'];

          $claim_amount              = $value["claim_amount"];
        $claim_amt = ((floatval($invoice_value) *  $claim_amount ) / 100);
        $claim_amounts =  moneyFormatIndia1($claim_amt);

             $value["claimamnt"] ='<span class="po_date text-right d-block" id="po">'. $claim_amounts .'</span>';

                    $value['po_num'] = '<b>'. $value['po_num'] .'</b><br>'.$value['po_date'];






                // $value['invoice_value'] = moneyFormatIndia($value['invoice_value']);
                $invoice_value = moneyFormatIndia1($value['invoice_value']);
                  $value['invoice_value']  = '<span class="po_date text-right d-block" id="po">'. $invoice_value .'</span>';
                // $value['invoice_value'] = $invoice_value;
                // $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
          $value['invoice_date'] = '<span class="po_date text-right d-block" id="po">' . $value['invoice_date'] . '</span>';
                
       

     $value['bill_details'] = '<b>'.$value['bill_no'].'</b><br>'.$value['bill_created_dates'];


           
           
                  $value['invoice_no'] = '<span class="po_date text-right d-block" id="po">'. $value['invoice_no'] .'</span>';


                   $form_unique_id = $value['bill_form_main_unique_id'];

                  $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_unique_id);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $customerAddress    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

          

            $value['customer_details'] = '<b>'. $department.'</b>'.'<br>'. $customerDistrict .'<br>'.  $customerState;

              $value['invoice_no'] = '<span class="po_date text-right d-block" id="po">'. $value['invoice_no'] .'</span>';

    // $value['bill_form_main_unique_id'] = '<a href="index.php?file=bill_creation/update1&unique_id=' . $value['bill_form_main_unique_id'] . '&bill_no=' . $value['bill_num'].'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>';

             $value['view'] = '<a href="index.php?file=security_despoist/view&unique_id=' . $value['bill_form_main_unique_id'] . '&bill_no=' . $value['bill_no'].'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>';
                // $value['invoice_value'] = htmlentities(moneyFormatIndia1($value['invoice_value']), ENT_QUOTES, 'UTF-8');

                // $invoice_value       = moneyFormatIndia($value['invoice_value']);
                // $value['invoice_value']=$invoice_value;

                // $invoice_value       = moneyFormatIndia1($value['invoice_value']);
                // $value['invoice_value']=$invoice_value;

                // $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));

                // $orgDate1 = $value['invoice_date'];
                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));

                // if ($value['bg_num'] != 'NA') {
                //     $value['bg_num'] = "Yes";
                // } else if ($value['bg_num'] == 'NA') {
                //     $value['bg_num'] = "No";
                // }
                  $value['claim_amount'] = '<span class="po_date text-right d-block" id="po"><b>' . $value['claim_amount'] . '</b></span>';
                    $value['invcount'] = '<span class="po_date text-right d-block" id="po">'. $value['invcount'] .'</span>';

                //    $value['file_name']= image_view("po_form", $value['consignee_unique_id'], $value['file_name']);
                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }
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

        $action_obj     = $pdo->update($table, $columns, $update_where);

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


    default:

        break;
}

function claim_value_cal($claim_percent = "", $invoice_value = "") {
    // if (!is_numeric($claim_percent) || !is_numeric($invoice_value)) {
    //     return 0; // Return 0 if inputs are invalid
    // }

    $claim_value = ($invoice_value * $claim_percent) / 100;

    return round($claim_value); // Rounded to nearest whole number
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
                    $image_view_3 .= '<a href="javascript:print_pdf(\'/' . $file_name . '\')"><img src="uploads/payment/pdf.png"  height="30px" width="50px" ></a>';
                }
                // else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/excel.png"  height="30px" width="30px" ></a>';
                // } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                //     $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/payment/word.png"  height="30px" width="30px" ></a>';
                // }
            }
        }
    }

    return $image_view_3;
}


function bill_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;
    $servername = "localhost";
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('APP_DB_PASSWORD');
    $database_name = "operation_team_beta";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=operation_team_beta", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->query("SELECT * FROM bill_submission_main_table where bill_no LIKE
     'BN%' order by unique_id desc");
    // $bill = $stmt->fetch();
    // $res_array = $bill['id'];
    // $result = $res_array + 1;
    // if($res1=$stmt->fetch($stmt))
    if ($res1 = $stmt->fetch()) {
        $pur_array = explode('-', $res1['bill_no']);
        $year1 = $pur_array[1];
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $bill_no = $pur_array[2];
        // print_r($booking_no);
    }
    if ($bill_no == '')
        $bill_nos = 'BN-' . $datee . '-0001';
    elseif ($year != date("Y"))
        $bill_nos = 'BN-' . $datee . '-0001';
    else {
        $bill_no += 1;
        $bill_nos = 'BN-' . $datee . '-' . str_pad($bill_no, 4, '0', STR_PAD_LEFT);
    }
    // print_r($bill_nos);
    return $bill_nos;
}


function indian_format_value($num) {
    $rounded = round($num); // Round off the number to nearest integer
    $int = (string)$rounded;

    $last_three = substr($int, -3);
    $rest = substr($int, 0, -3);

    if ($rest != '') {
        $last_three = ',' . $last_three;
    }

    $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
    return $rest . $last_three;
}




