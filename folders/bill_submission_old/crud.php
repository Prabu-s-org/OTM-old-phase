<?php 

// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = "view_bill_submission_main_table";
$table_sub  ="view_bill_submission_sub_table";
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
    case 'createupdate':

        $unique_id          = $_POST["unique_id"];
        $e_no          = $_POST["e_no"];
        $bill_sub_date          = $_POST["bill_sub_date"];
        $bill_form_main_unique_id          = $_POST["bill_form_main_unique_id"];
        $bill_no          = $_POST["bill_no"];
        $invoice_no          = $_POST["invoice_no"];
        

        $update_where       = "";

        $columns            = [
            "e_no"           => $e_no,
            "bill_submission_date"           => $bill_sub_date,
            "elcot_ent_status"     => 1
        ];
        $columns_1            = [
            "e_no"           => $e_no,
            "bill_submission_date"           => $bill_sub_date,
            "elcot_ent_status"     => 1
        ];
        $update_where_1       = "bill_form_unique_id='".$bill_form_main_unique_id."' and invoice_no='".$invoice_no."' or bill_no='".$bill_no."'" ;
        $action_obj_1    = $pdo->update($table_sub,$columns_1,$update_where_1);
        // print_r(  $action_obj_1 );

        // Update Begins
        if($unique_id) {

            unset($columns['unique_id']);

            $update_where   = [
                "unique_id"     => $unique_id,
            ];
            
            $action_obj     = $pdo->update($table,$columns,$update_where);

        // Update Ends
        } 

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

        
        case 'datatable':
            
            // print_r('test');die();
            // DataTable Variables
            $search         = $_POST['search']['value'];
            $length         = $_POST['length'];
            $start          = $_POST['start'];
            $draw           = $_POST['draw'];
            $limit          = $length;
            $data           = [];
        
            if($length == '-1') {
                $limit  = "";
            }
        
            // Query Variables
            $json_array     = "";
            $columns        = [
                "'' as sno",
                "po_num",
                "po_date",
                // "ledger_name",
                "bill_no",
                "'' as invoice_count",
                "invoice_no",
                "invoice_value",
                "e_no",
                "bill_submission_date",
                "elcot_ent_status",
                "unique_id",
                "bill_form_main_unique_id",
            
            ];
        
           
            $where = "is_delete = 0";
        
            $order_column   = $_POST["order"][0]["column"];
            $order_dir      = $_POST["order"][0]["dir"];
        
            // Datatable Ordering 
            $order_by = datatable_sorting($order_column, $order_dir, $columns);
            $order_by = "(elcot_ent_status = 1) $order_dir";
        
            // Datatable Searching
            $search = datatable_searching($search, $columns);
        
            if ($search) {
                $where .= " AND $search";
            }
        
            $sql_function   = "SQL_CALC_FOUND_ROWS";
        
            $result         = $pdo->select([$table, $columns], $where, $limit, $start, $order_by, $sql_function);
            $total_records  = total_records();
        
            $screen_id_val  = $_POST['screen_id_val'];
            $user_type      = $_POST['user_type_unique_id'];
        
            $table_user     = "user_screen_permission";
            $columns_user   = [
                "action_unique_id",
                "user_type"
            ];
            $select_where   = "screen_unique_id = '$screen_id_val' AND user_type = '$user_type'";
        
            $table_users    = $pdo->select([$table_user, $columns_user], $select_where);
            $table_users    = $table_users->data;
            
            $action_ids = [];
            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }
        
            if ($result->status) {
                $res_array = $result->data;
                $sno = 1;
                foreach ($res_array as $key => $value) {
                    $bill_no = $value['bill_no'];
        
                    $value['sno'] = $sno++;
                    $invoice_value = $value['invoice_value'];
                    $value['invoice_value'] = moneyFormatIndia($invoice_value);
                    $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
        
                    $arrayOfValues = explode(",", $value['invoice_no']);
                    $value['invoice_count'] = count($arrayOfValues);
        
                    if ($value['elcot_ent_status'] == "0") {
                        $value['elcot_ent_status'] = "Pending";
                    } else {
                        $value['elcot_ent_status'] = "Complete";
                    }
        
                    $value['bill_no'] = '<a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">' . $bill_no . '</a>
                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Bill Submission List </h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                           <div class="col-md-6">
                                             <label>Invoice count: ' . $value['invoice_count'] . '</label>
                                           </div>
                                             <div class="col-md-6">
                                             <label class="col-5">Bill ID :' . $bill_no . '</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6">
                                             <label class="col-5">Bill Value:' . $value['invoice_value'] . '</label>
                                            </div>
                                             <div class ="col-md-6">
                                             <label class="col-5">Bill Date: ' . $value['bill_submission_date'] . '</label>
                                         </div>
                                        </div>
                                        <div class="table-responsive">
                                         <table class="table table-striped table-bordered align-middle">
                                             <thead>
                                             <tr>
                                                 <th>S.No</th>
                                                 <th>Invoice No</th>
                                                 <th>Invoice Date</th>
                                                 <th>Invoice Qty</th>
                                                 <th>Invoice Value</th>  
                                             </tr>
                                             </thead>';
        
                    $table_sub = "view_bill_submission_sub_table";
                    $columns_main = [
                        "'' as s_no",
                        "invoice_no",
                        "invoice_date",
                        "invoice_qty",
                        "invoice_value",
                        "bill_no",
                        "ins_unique_id"
                    ];
                    $where_main = "bill_form_unique_id = '" . $value['bill_form_main_unique_id'] . "' and bill_no = '$bill_no' AND is_delete = 0";
        
                    $result_main = $pdo->select([$table_sub, $columns_main], $where_main);
                    if ($result_main->status) {
                        $res_array_main = $result_main->data;
                        $s_no = 1;
                        foreach ($res_array_main as $value_ot) {
                            $value['bill_no'] .= '
                                <tbody>
                                    <tr>
                                        <td>' . $s_no++ . '</td>
                                        <td>' . $value_ot['invoice_no'] . '</td>
                                        <td>' . $value_ot['invoice_date'] . '</td>
                                        <td>' . $value_ot['invoice_qty'] . '</td>
                                        <td>' . $value_ot['invoice_value'] . '</td>
                                    </tr>
                                </tbody>';
                        }
                    }
        
                    $value['bill_no'] .= '
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                </div>
                            </div>
                        </div>
                    </div>';
        

                    // $value['e_no'] = btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "") ;

                    // $value['e_no'] = btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot1', "", "", "") ;

//                     $value['e_no'] = '<input type="checkbox" name="elcot" value="' . $value['unique_id'] . '" />
// ' . btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "") . '';

// $value['e_no'] = '
//     <input type="text" name="elcot[' . $value['unique_id'] . ']" value="0" id="elcot_value_' . $value['unique_id'] . '" />
//     <input type="checkbox" name="elcot1[' . $value['unique_id'] . ']" value="1" id="elcot_checkbox_' . $value['unique_id'] . '" 
//     onclick="toggleElcotValue(' . $value['unique_id'] . ')" />
//     ' . btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "") . '';



$download = btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "");
$download1 = btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot1', "", "", "");

$value['e_no'] = '
    <input type="checkbox" id="myCheckbox" onclick="toggleCheckbox(this)">
    <input type="hidden" id="myInput" value="0" readonly>
    <div id="downloadContainer">
        <span id="downloadElcot" style="display: none;">'.$download.'</span>
        <span id="downloadElcot1">'.$download1.'</span>
    </div>';


// $value['e_no'] = ' . btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "") . '';

    // <input type="checkbox" name="elcot[' . $value['unique_id'] . ']" value="1" />



                    $value['bill_submission_date'] = btn_download_inv($folder_name, $value['unique_id'], $bill_no, 'elcot2', "", "", "");
        
                    $btn_update = btn_update_7($folder_name, $value['unique_id'], $value['invoice_no'], $value['ins_unique_id']);
                    $btn_delete = btn_delete($folder_name, $value['unique_id']);
        
                    if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_update . $btn_delete;
                    } else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    } else if (in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_delete;
                    } else {
                        $value['unique_id'] = '';
                    }
        
                    $data[] = array_values($value);
                }
        
                $json_array = [
                    "draw"              => intval($draw),
                    "recordsTotal"      => intval($total_records),
                    "recordsFiltered"   => intval($total_records),
                    "data"              => $data,
                    "testing"           => $result->sql
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

    
    default:
        
        break;
}



// function btn_download(){
    
//   if(!empty($_GET['file'])){
//     $filename =basename($_GET['file']);
//     $filepath='elcot_entry/'. $filename;
//     if(!empty($filename)&&file_exists( $filepath)){
//         header("cache-Control:public");
//         header("Content-Description:File Transfer");
//         header("Content-Desposition:attachment;filename=$filename");
//         header("content-Type:application/zip");
//         header("content-transfer-Emcodeing:binary");
//         readfile($filepath);
//         exit;


//     }
//     else{
//         echo "This File Doses not exist.";

//     }
//   }  
// }

   
?>

