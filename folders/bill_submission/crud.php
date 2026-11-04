<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table_1 = "view_bill_submission_main_table";
$table_sub_1 = "view_bill_submission_sub_table";


$table = "bill_submission_main_table";
$table_sub = "bill_submission_sub";
$table_sign = "sign_doc_verification_detail";
$table_bill = "bill_submission_form";
// Include DB file and Common Functions
include '../../config/dbconfig.php';

// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    "status" => 0,
    "data" => "",
    "error" => "Action Not Performed"
];
$json_array = "";
$sql = "";

$user_type = "";
$is_active = "";
$unique_id = "";
$prefix = "";

$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose

switch ($action) {
    case 'createupdate':


        // print_r('test');die();
        $unique_id = $_POST["unique_id"];
        $e_no = $_POST["e_no"];
        $bill_sub_date = $_POST["bill_sub_date"];
        $bill_form_main_unique_id = $_POST["bill_form_main_unique_id"];
        $bill_no = $_POST["bill_no"];
        $invoice_no = $_POST["invoice_no"];

        // $acc_year = getFinancialYear($po_date);


        // print_r($acc_year);die();


        $update_where = "";

        $columns = [
            "e_no" => $e_no,
            "bill_submission_date" => $bill_sub_date,
            // 'acc_year' => $acc_year,
            "elcot_ent_status" => 1
        ];

        $columns_1 = [
            "e_no" => $e_no,
            "bill_submission_date" => $bill_sub_date,
            // 'acc_year' => $acc_year,
            "elcot_ent_status" => 1
        ];

        $update_where_1 = "bill_form_main_unique_id='" . $bill_form_main_unique_id . "'  AND  bill_no='" . $bill_no . "' and unique_id = '".$unique_id."'";

        // $action_obj_1 = $pdo->update($table_sub, $columns_1, $update_where_1);

        $action_obj = $pdo->update($table,$columns_1,$update_where_1);
    //  print_r(  $action_obj);die();   

        // Update Begins
//         if ($unique_id) {

//             unset($columns['unique_id']);

//             $update_where = [
//                 "unique_id" => $unique_id,
//             ];

//             $action_obj = $pdo->update($table, $columns, $update_where);

//             // Update Ends
//         }

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($unique_id) {
                $msg = "update";
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


    case 'bill_cancel_add_update':

        $bill_form_unique_id = $_POST["bill_form_unique_id"];
        $invoice_qty = $_POST["invoice_qty"];
        $invoice_value = $_POST["invoice_value"];
        $invoice_no = $_POST["invoice_no"];
        $bill_no = $_POST["bill_no"];
        $reject_reason = $_POST["reject_reason"];
        $tot_invoice_no = $_POST["tot_invoice_no"];
        $remaining_invoice_no = $_POST["remaining_invoice_no"];
        // if($remaining_invoice_no)


        $update_where = "";

        $table_main = "bill_submission_main_table";

        $table_details = [
            $table_main,
            [
                "invoice_value",
                "invoice_qty",
                "cancel_invoice_no",
            ]
        ];
        $select_where = 'is_delete = 0 AND invoice_no="' . $tot_invoice_no . '" AND is_delete=0';
        $action_obj_1 = $pdo->select($table_details, $select_where);
        // print_r( $action_obj_1);die();
        if ($action_obj_1->status) {
            $status = $action_obj_1->status;
            $data = $action_obj_1->data;
            $error = '';
            $sql = $action_obj_1->sql;
        } else {
            $status = $action_obj_1->status;
            $data = $action_obj_1->data;
            $error = $action_obj_1->error;
            $sql = $action_obj_1->sql;
            $msg = 'error';
        }

        $total_inv_qty = $data[0]['invoice_qty'] - $invoice_qty;
        // print_r( $total_inv_qty);
        $total_inv_value = $data[0]['invoice_value'] - $invoice_value;

        $rem_inv_nos = $data[0]['cancel_invoice_no'];
        // Assuming $rem_inv_nos is a comma-separated string, convert it to an array


        // print_r($total_inv_value);die();
        if ($remaining_invoice_no != '') {
            $columns = [
                "inv_cancel_status" => 1,
                "bill_reject_reason" => $reject_reason,
                "cancel_invoice_no" => $invoice_no,
                "rem_inv_no" => $remaining_invoice_no,
                "invoice_value" => $total_inv_value,
                "invoice_qty" => $total_inv_qty,
                "invoice_no" => $remaining_invoice_no,


            ];
        } else {
            // The invoice_no is either empty or null
            // Handle the case where invoice_no is empty or null
            $columns = [
                "is_delete" => 1,
                // "invoice_value"           => 0,
                // "invoice_qty"           =>0,
                "inv_cancel_status" => 1,
                "bill_reject_reason" => $reject_reason,
                "cancel_invoice_no" => $invoice_no,
                "rem_inv_no" => $remaining_invoice_no,
                // "invoice_no"     => null,
            ];
        }
        // }

        // BILL SUB TABLE DELTE
        $columns_sub = [
            "is_delete" => 1,
            "inv_cancel_status" => 1,
            "bill_reject_reason" => $reject_reason,
        ];

        $invoice_no_array = explode(',', $invoice_no);
        $invoice_no_array = array_map('trim', $invoice_no_array);

        // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
        $update_where_sub = "invoice_no IN('" . implode("','", $invoice_no_array) . "') AND bill_form_unique_id='" . $bill_form_unique_id . "'";

        $action_obj_sub = $pdo->update($table_sub, $columns_sub, $update_where_sub);
        //END
        // SIGNED DOCUMENT DELTE
        $columns_sign = [
            // "is_delete"     => 1,
            "inv_cancel_status" => 1,
            "bill_status" => 3,
            "bill_reject_reason" => $reject_reason,
            "bill_no" => "",
        ];

        $invoice_no_array = explode(',', $invoice_no);
        $invoice_no_array = array_map('trim', $invoice_no_array);

        // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
        $update_where_sign = "invoice_no IN('" . implode("','", $invoice_no_array) . "') AND form_main_unique_id='" . $bill_form_unique_id . "'";

        $action_obj_sign = $pdo->update($table_sign, $columns_sign, $update_where_sign);
        // print_r()
        //END
        // bill form DELTE
        $columns_bill = [
            "is_delete" => 1,
            "inv_cancel_status" => 1,
            // "bill_status"           =>3,
            "bill_reject_reason" => $reject_reason,
        ];

        $invoice_no_array = explode(',', $invoice_no);
        $invoice_no_array = array_map('trim', $invoice_no_array);

        // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
        $update_where_bill = "invoice_no IN('" . implode("','", $invoice_no_array) . "') AND bill_form_main_unique_id='" . $bill_form_unique_id . "' AND is_delete='0'";

        $action_obj_bill = $pdo->update($table_bill, $columns_bill, $update_where_bill);
        //END




        // print_r($action_obj_sub);
        // Update Begins
        if ($bill_no) {

            unset($columns['bill_no']);

            $update_where = [
                "bill_no" => $bill_no,
            ];

            $action_obj = $pdo->update($table_main, $columns, $update_where);


            // print_r($action_obj);die();

            // Update Ends
        }
        // print_r($action_obj);
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($bill_no) {
                $msg = "update";
            }
            // else {
            //     $msg        = "create";
            // }
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

    case 'datatable':

        //   print_r($_SESSION['user_type_unique_id']);die();
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $data = [];

        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
            "'' as sno",
            "get_po_number(bill_form_main_unique_id) as po_num",
            "bill_no",
            "'' as invoice_count",
            "claim_amount",
            "claimamt",
            "invoice_value",
            "e_no",
            "bill_submission_date",
            "elcot_ent_status",
            
            "bill_submission_date as b_submit_date",
            "e_no as eno",
            // "'' as view",
            "unique_id",
            "bill_form_main_unique_id",
            "po_date",
            "invoice_no",

        ];

        // $table = 'your_table_name'; // Replace with your actual table name
        $where = "is_delete = 0";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        $order_by = "(elcot_ent_status = 1) $order_dir";

        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            $where .= " AND $search";
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select([$table_1, $columns], $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();

        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns_user = [
            "action_unique_id",
            "user_type"
        ];

        $select_where = "screen_unique_id = '$screen_id_val' AND user_type = '$user_type'";

        $table_users = $pdo->select([$table_user, $columns_user], $select_where);
        $table_users = $table_users->data;

                        // print_r($table_users);die();


        $action_ids = [];
        foreach ($table_users as $item) {
            if(isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];

            //  print_r($action_ids);die();
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            $sno = 1;
            foreach ($res_array as $key => $value) {
                $bill_no = $value['bill_no'];

                $value['sno'] = $sno++;
                if($value['b_submit_date'] != ''){
                $value['b_submit_date'] = disdate($value['b_submit_date']);
                }else{
                $value['b_submit_date'] = '-'; 
                }
                if($value['eno'] != ''){
                $value['eno'] = $value['eno'];
                }else{
                $value['eno'] = '-';
                }
                $invoice_value = $value['invoice_value'];
                $po_num = $value['po_num'];

                $value['invoice_value'] ='<span class="po_date text-right d-block" id="po">'. moneyFormatIndia1($invoice_value) .'</span>';

$value['claim_amount'] = '<div style="text-align:right;"><b>' . moneyFormatIndia1($value['claim_amount']) . '</b></div>';

                $value['claimamt'] = '<div style="text-align:right;"><b>' .moneyFormatIndia1($value['claimamt']) . '</b></div>';

                $value['po_num'] = '<b>'.$po_num.'</b><br><span class="po_date">' . disdate($value['po_date']) . '</span>';

                $arrayOfValues = explode(",", $value['invoice_no']);
                $value['invoice_count'] = '<span class="po_date text-right d-block" id="po">'.count($arrayOfValues) .'</span>';

                if ($value['elcot_ent_status'] == "0") {

                    $value['elcot_ent_status'] = "Pending";

                } else {
                    $value['elcot_ent_status'] = "Completed";
                }

                

                $value['bill_no'] = '<a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">' . $bill_no . '</a>
                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Bill Submission List </h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <strong class="label-col me-2">PO No.</strong>
                                                    <span>:</span>
                                                    <span class="ms-2">'. $po_num .'</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <strong class="label-col me-2">Invoice Count</strong>
                                                    <span>:</span>
                                                    <span class="ms-2">' . $value['invoice_count'] . '</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <strong class="label-col me-2">Bill No.</strong>
                                                    <span>:</span>
                                                    <span class="ms-2">' . $bill_no . '</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <strong class="label-col me-2">Bill Value</strong>
                                                    <span>:</span>
                                                    <span class="ms-2">' . $value['invoice_value'] . '</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex">
                                                    <strong class="label-col me-2">Bill Date</strong>
                                                    <span>:</span>
                                                    <span class="ms-2">' . $value['bill_submission_date'] . '</span>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive mt-3">
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
                // print_r($result_main);
                if ($result_main->status) {
                    $res_array_main = $result_main->data;
                    $s_no = 1;
                    $value['bill_no'] .= '';
                    $total_invoice_qty = '0';
                    $total_invoice_value = '0';
                    foreach ($res_array_main as $value_ot) {
                        $total_invoice_qty += $value_ot['invoice_qty'];
                        $total_invoice_value += $value_ot['invoice_value'];
                        $value['bill_no'] .= '
                        <tbody>
                                    <tr>
                                        <td>' . $s_no++ . '</td>
                                        <td>' . $value_ot['invoice_no'] . '</td>
                                        <td>' . $value_ot['invoice_date'] . '</td>
                                        <td style="text-align:right">' . $value_ot['invoice_qty'] . '</td>
                                        <td style="text-align:right">' . moneyFormatIndia1($value_ot['invoice_value']) . '</td>
                                    </tr>';
                    }
                    $value['bill_no'] .= '<tr>
                                            <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                                            <td style="text-align:right">' . $total_invoice_qty . '</td>
                                            <td style="text-align:right">' . moneyFormatIndia1($total_invoice_value) . '</td>
                                        </tr>
                                        </tbody>';
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

                $value['view'] = '<a href="#" data-bs-toggle="modal" data-bs-target=".bs-example1-modal-xl' . $sno . '" type="button"><i class="mdi mdi-eye-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-pink mr-1"></i></a>
                <div class="modal fade bs-example1-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Bill Submission </h3>
                            
                        </div>' ?>
                <?php
                $where1 = "unique_id = '" . $value['unique_id'] . "' and invoice_no='" . $value['invoice_no'] . "' AND is_delete=0";
                //    $where='unique_id="'.$value["unique_id"].'" and invoice_no="'.$value["invoice_no"].'"';

                $table1 = "bill_submission_main_table";

                $columns1 = [
                    "unique_id",
                    "bill_submission_date",
                    "e_no",
                    "invoice_no",
                    "bill_form_main_unique_id",
                    "bill_no"
                ];

                $table_details1 = [
                    $table1,
                    $columns1
                ];

                $result_values = $pdo->select($table_details1, $where1);
                // print_r($result_values);die();

                if ($result_values->status) {

                    $test = $result_values->data;

                    foreach ($test as $key => $result_values1) {
                        $unique_id_val = $result_values1["unique_id"];
                        $e_no = $result_values1["e_no"];
                        $bill_sub_date = $result_values1["bill_submission_date"];
                        $invoice_no = $result_values1["invoice_no"];
                        $bill_form_main_unique_id = $result_values1["bill_form_main_unique_id"];
                        $bill_no = $result_values1["bill_no"];



                        $value['view'] .= '<div class="modal-body">
                            
                            <div class="row">
                               <div class="col-md-6">
                                 
                                 <label>Bill Submission Date: ' . $bill_sub_date . '</label>
                               </div>
                                 <div class="col-md-6">
                                 <label class="col-5">E No :' . $e_no . '</label>
                                
                                 </div>' ?>
                        <?php
                    }

                    // $exp_under_user_type  = explode(",", $under_user_type);


                }

                $value['view'] .= '</div>
                            
                                <div class="table-responsive">
               
                        </div>
                                <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                        
                    </div>
                       
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->';

                $value['e_no'] = btn_download($folder_name, $value['unique_id'], $bill_no, 'elcot', "", "", "");
                // $value['bill_submission_date'] = btn_download_inv($folder_name, $value['unique_id'], $bill_no, 'elcot2', "", "", "");
                $view = $value['view'];


                $download = btn_download_inv($folder_name, $value['unique_id'], $bill_no, 'elcot2', "", "", "");
                $download1 = btn_download_inv($folder_name, $value['unique_id'], $bill_no, 'elcot1', "", "", "");

                $value['bill_submission_date'] = '
            <input type="checkbox" id="myCheckbox" onclick="toggleCheckbox(this)">
            <input type="hidden" id="myInput" value="0" readonly>
            <div id="downloadContainer">
                <span id="downloadElcot" style="display: none;">' . $download . '</span>
                <span id="downloadElcot1">' . $download1 . '</span>
            </div>';








                $btn_update = btn_bill_submission_update($folder_name, $value['unique_id'], $value['invoice_no'],$value['bill_form_main_unique_id'],$bill_no);
                $btn_delete = btn_delete($folder_name, $value['unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))) {


                    if ($bill_submission_date != "") {

                        // print_r($value['stock_qty']==$value['invoice_qty']);die();
                        $value['view'] = $view;
                    } else {

                        $value['view'] = '';

                    }

                }

               

                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {
                    // if(in_array('5f88085e1fcea66282', $action_ids)){
                    if ($bill_submission_date != "") {

                        // print_r($value['stock_qty']==$value['invoice_qty']);die();
                        $value['view'] = $view;
                    }
                    // }
                    else {
                        $value['view'] = '';
                    }
                }

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {
                    // if(($data_st[0]['documents_type1'] == "IR") && ($data_st[0]['documents_type'] == "DC") || $data_st[0]['dc_required'] == "on" ){
                    if ($bill_submission_date != "") {

                        // print_r($value['stock_qty']==$value['invoice_qty']);die();
                        $value['unique_id'] = "";
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                            $value['unique_id'] = $btn_update . $btn_delete;
                        } else if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['unique_id'] = $btn_update;
                        } else if (in_array('5f8808504271036738', $action_ids)) {
                            $value['unique_id'] = $btn_delete;
                        } else {
                            $value['unique_id'] = '';
                        }
                    }

                }

                 if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {


                     if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                        // if()if()

                       $value['unique_id'] = $btn_update;
                 } else if (in_array('5f88082b25ec031952', $action_ids)) {
                     $value['unique_id'] = $btn_update;
                 }
                //   else if (in_array('5f8808504271036738', $action_ids)) {
                //      $value['unique_id'] = $btn_delete;
                //  }

                //  else if(in_array('5f8808504271036738', $action_ids)){
                //      $value['unique_id'] = $btn_delete;
                //  }
                     else {
                         $value['unique_id'] = '';
                   }
                 }

                


                $data[] = array_values($value);
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



    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
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
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;


    case 'delete':

        $unique_id = $_POST['unique_id'];

        $columns = [
            "is_delete" => 1
        ];

        $update_where = [
            "unique_id" => $unique_id
        ];

        $action_obj = $pdo->update($table, $columns, $update_where);

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "success_delete";

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
