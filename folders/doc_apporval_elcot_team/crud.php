<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table_invoice_main = "invoice_creation_main";
$table = "view_doc_approval_list_final";
$table_sub = "invoice_sublist";
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$session_approved_by = $_SESSION['staff_name'];

$fileUploadPath = $fileUploadConfig->get("upload_folder");

// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

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
        $doc_approval_sts = $_POST["doc_approval_sts"];
        $reason_reject = $_POST["reason_reject"];
        $approved_by = $_POST["approved_by"];
        $invoice_unique_id = $_POST["invoice_unique_id"];
        $invoice_auto_id = $_POST["invoice_auto_id"];
        $invoice_no = $_POST["invoice_no"];
        $invoice_doc_status = $_POST["invoice_doc_status"];
        $cur_date = date('Y-m-d');
        $dc_number = $_POST["dc_number"];
        
        $update_where = "";
        $columns = [
            "doc_approval_sts" => $doc_approval_sts,
            "invoice_doc_status" => $doc_approval_sts,
            "reject_reason_elcot" => $reason_reject,
            "approved_by" => $approved_by,
            "approved_date" => $cur_date
            // "unique_id"           => unique_id($prefix)
        ];

        // $table_inv_main="invoice_creation_main";
        $table_inv = "invoice_creation";
        if ($doc_approval_sts == '2') {
            $columns_4 = [
                "dc_number" => "",
                "dc_date" => NULL,
                "invoice_no" => "",
                "ledger_name" => "",
                "ledger_no" => "",
                "invoice_date" => NULL,
            ];
            $update_where_4 = "dc_number = '" . $dc_number . "'";
            $action_obj4 = $pdo->update($table_invoice_main, $columns_4, $update_where_4);
            $columns_2 = [
                "dc_num" => "",
                "dc_date" => NULL,
                "invoice_no" => "",
                "ledger_name" => "",
                "ledger_no" => "",
                "invoice_date" => NULL,
            ];
            $update_where_2 = "dc_num = '" . $dc_number . "'";
            $action_obj2 = $pdo->update($table_inv, $columns_2, $update_where_2);



        }


        $table_sub = 'invoice_sublist';
        if ($doc_approval_sts == '2') {
            $columns1
                = [
                    "doc_approval_sts" => $doc_approval_sts,
                    "reject_reason" => $reject_reason,
                    "is_delete" => 1,

                ];
        } else {
            $columns1 = [
                "doc_approval_sts" => $doc_approval_sts,
                "reject_reason" => $reject_reason,

            ];
        }
        $update_where1 = "invoice_id = '" . $invoice_unique_id . "'";
        $action_obj1 = $pdo->update($table_sub, $columns1, $update_where1);

        // Update Begin starts
        $update_where = 'unique_id ="' . $invoice_unique_id . '"';
        
 $tableinv_verify ='invoice_verfication_table';


  $inv_ver_columns = [
            "doc_approval_sts" => $doc_approval_sts,
            "invoice_doc_status" => $doc_approval_sts,
           
            "approved_by" => $approved_by,
            "approved_date" => $cur_date
        ];

        $action_obj = $pdo->update($table_invoice_main, $columns, $update_where);


          $update_inv_where  = 'dc_number ="'.$dc_number.'"';


         $action_obj_new = $pdo->update($tableinv_verify, $inv_ver_columns, $update_inv_where);


        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            if ($invoice_unique_id) {
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


    case 'datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length    = $_POST['length'];
        $start     = $_POST['start'];
        $draw      = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date   = $_POST['to_date'];

        $state     = $_POST['state'];
        $zone      = $_POST['zone'];

        $opt       = $_POST['opt'];
        $limit     = $length;
           
        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $table = 'invoice_creation_main';
    //     $columns = [
    //         "'' as  sno",
    //         "(select po_num from po_form where unique_id=invoice_creation_main.form_main_unique_id) as po_num",
         
    //         "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id) AS con_address",
    //         "(SELECT con_branch FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id) AS con_branch",
    //       "(SELECT staff_name
    //   FROM user
    //   WHERE staff_id =   $table.team_mem 
      
    //   AND is_delete = 0
    //   LIMIT 1) AS team_member",
    //         "invoice_no",
    //         "dc_number",
    //         "invoice_value",
    //         "(SELECT file_name FROM po_form
    //   WHERE unique_id = invoice_creation_main.form_main_unique_id
    //     AND is_delete = 0
    //   LIMIT 1) AS file_name",
    //         "(SELECT dc_file_name
    //   FROM invoice_sublist
    //   WHERE dc_number = invoice_creation_main.dc_number
    //     AND is_delete = 0
    //   LIMIT 1) AS dc_file_name",
    //         "(SELECT ir_file_name
    //   FROM invoice_sublist
    //   WHERE dc_number = invoice_creation_main.dc_number
    //     AND is_delete = 0
    //   LIMIT 1) AS ir_file_name",
    //         "(SELECT file_invoice
    //   FROM invoice_sublist
    //   WHERE dc_number = invoice_creation_main.dc_number
    //     AND is_delete = 0
    //   LIMIT 1) AS file_invoice",
    //         "(SELECT invoice_file_org_name
    //   FROM invoice_sublist
    //   WHERE dc_number = invoice_creation_main.dc_number
    //     AND is_delete = 0
    //   LIMIT 1) AS invoice_file_org_name",
    //         "doc_approval_sts",
    //         "approved_by",
    //         "unique_id as invoice_unique_id",
    //         "(SELECT get_executive_name(executive_name)  FROM po_form  WHERE po_form.unique_id = $table.form_main_unique_id and po_form.is_delete = 0) as executive_name",
    //         "po_date",
    //         "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table . ".ledger_name and department_creation_sublist.is_delete='0' group by department_creation_sublist.unique_id ) AS ledger_name",
    //           "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    //         "DATE_FORMAT(dc_date,'%d-%m-%Y') as dc_date",
    //         "team_mem",
    //         "(select zone from consignee_details_sub  where unique_id=invoice_creation_main.consignee_unique_id) as zone"
    //     ];

    $columns = [
    "'' AS sno",
    "pf.po_num",
    "c.con_address",
    "c.con_branch",
    "u.staff_name AS team_member",
    "icm.invoice_no",
    "icm.dc_number",
    "icm.invoice_value",
    "pf.file_name",
    "sub.dc_file_name",
    "sub.ir_file_name",
    "sub.file_invoice",
    "sub.invoice_file_org_name",
    "icm.doc_approval_sts",
    "icm.approved_by",
    "icm.unique_id AS invoice_unique_id",
    "pf.executive_name",
    "icm.po_date",
    "d.ledger_name",
    "DATE_FORMAT(icm.invoice_date, '%d-%m-%Y') AS invoice_date",
    "DATE_FORMAT(icm.dc_date,'%d-%m-%Y') AS dc_date",
    "icm.team_mem",
    "c.zone"
];

     $table_details = [
    "invoice_creation_main icm
     LEFT JOIN po_form pf ON pf.unique_id = icm.form_main_unique_id AND pf.is_delete = 0
     LEFT JOIN invoice_sublist sub ON sub.dc_number = icm.dc_number AND sub.is_delete = 0
     LEFT JOIN user u ON u.staff_id = icm.team_mem AND u.is_delete = 0
     LEFT JOIN consignee_details_sub c ON c.unique_id = icm.consignee_unique_id AND c.is_delete = 0
     LEFT JOIN department_creation_sublist d ON d.unique_id = icm.ledger_name AND d.is_delete = 0",
    $columns
];

      
     $where_parts = [];
     $where_parts[] = "icm.doc_approval_sts = '0' AND icm.dc_number != '' ";
    
         $from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
       if (!empty($from_date) && !empty($to_date)) {

         if ($opt === '4') {
            $where_parts[] = "  icm.po_date >= '" . $from_date . "' AND icm.po_date <= '" . $to_date . "'";
        } else if ($opt === '5') {
            $where_parts[] = "  icm.invoice_date >= '" . $from_date . "' AND icm.invoice_date <= '" . $to_date . "'";
        }
       }

         if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                
            } else {
                $where_parts[] = "icm.team_mem = '$team_mem'";
            }
        } else {
            if ($team_mem == '') {
                
            } else {
                $where_parts[] = "icm.team_mem = '$team_mem'";
            }
        }


        if (!empty($state)) {
            $where_parts[] = "icm.state_name = '" . addslashes($state) . "'";
        }

        if (!empty($zone)) {

            $where_parts[] = "icm.zone = '" . addslashes($zone) . "'";
        }
        
        $where = implode(" AND ", $where_parts);

        $order_column   = $_POST["order"][0]["column"];

        $order_dir      = $_POST["order"][0]["dir"];


        // Datatable Ordering 
        $order_by = datatable_sorting_elcot($order_column, $order_dir, $columns);

        $order_by = "(icm.doc_approval_sts = 1) $order_dir";
        // $order_by = "";

        $search = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }
        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r(  $result);
        $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            "action_unique_id",
            "user_type"
        ];

        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;


            foreach ($res_array as $key => $value) {

                $value['sno'] = $sno++;
                $value['dc_number'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';


                $orgDate = $value['po_date'];
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';



$value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';


$value['con_address'] =  '<span style="font-weight:bold;text-transform: uppercase;">'.$value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' .$value['con_address']  . '</span>';

$value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

                $team_member = $value['team_member'];
               

                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    
                    
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                }
                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];

                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];


                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                $invoice_value = $value['invoice_value'];

                $invvalue = moneyFormatIndia1(($invoice_value));

                
                $value['invoice_value'] = '<div style="text-align:right;">
                <span >' . $invvalue . '</span></div>';

                $d = $value['invoice_no'];
                // $where_2 = "invoice_no = '".$d."' AND ORDER BY doc_approval_sts='0'";
                $where_2 = "invoice_no = '" . $d . "' AND is_delete=0";

                // 

                $table_1 = "invoice_creation_main";

                $columns_2 = [
                    // 'COUNT(invoice_no) AS count'
                    "invoice_doc_status",
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                // print_r($result_values_12);
                $data_st = $result_values_12->data;
                
                $btn_update = btn_update($folder_name, $value['invoice_unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {

                    if ($data_st[0]['invoice_doc_status'] == '4') {
                        // echo "hii";
                        $value['invoice_unique_id'] = "";
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['invoice_unique_id'] = $btn_update;
                            // echo"hi";
                        } else {
                            $value['invoice_unique_id'] = '';
                        }
                    }

                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['invoice_unique_id'] = $btn_update;
                        // echo"hello";
                    }
                    // else if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    else {
                        $value['invoice_unique_id'] = '';
                    }
                }

                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="20px" width="20px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button" >
                <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
            Comparison Attachment </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                    <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                    <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                    <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                </div>
                            </div>
                          
                            <div class="row mt-2">
                               <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                   <h4 class="text-center">PO Attachment</h4>
                                        <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="900">
                                            <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="900">
                                            </iframe>
                                        </object>
                                </div>
                                <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                    <h4 class="text-center">DC Attachment</h4>
                                    <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                               <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                    <h4 class="text-center">IR Attachment</h4>
                                    <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                               <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                    <h4 class="text-center">Invoice Attachment</h4>
                                    <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                            
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->';
                // $sno++;
                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';

                if ($value['doc_approval_sts'] == "1") {
                    $value['doc_approval_sts'] = "Approved";
                } else if ($value['doc_approval_sts'] == "2") {
                    $value['doc_approval_sts'] = "Not Approval";
                } else {
                    $value['doc_approval_sts'] = "Pending";
                }

                if ($value['approved_by']) {
                    $value['approved_by'] = disname($value['approved_by']);
                } else {
                    $value['approved_by'] = '--';
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


        // new 
         case 'elcotteam_complete_datatable':
         // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $doc_approval_sts = $_POST['doc_approval_sts'];
        $team_mem = $_POST['team_mem'];

         $state = $_POST['state_name'];

          $zone = $_POST['zone_name'];

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $table = 'invoice_creation_main';
        $columns = [
            "'' as  sno",
            "(select po_num from po_form where unique_id=invoice_creation_main.form_main_unique_id) as po_num",
         
            "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id) AS con_address",
            "(SELECT con_branch FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0' group by consignee_details_sub.unique_id) AS con_branch",
          "(SELECT staff_name
      FROM user
      WHERE staff_id =   $table.team_mem 
      
      AND is_delete = 0
      LIMIT 1) AS team_member",
            "invoice_no",
            "dc_number",
            "invoice_value",
            "(SELECT file_name FROM po_form
      WHERE unique_id = invoice_creation_main.form_main_unique_id
        AND is_delete = 0
      LIMIT 1) AS file_name",
            "(SELECT dc_file_name
      FROM invoice_sublist
      WHERE dc_number = invoice_creation_main.dc_number
        AND is_delete = 0
      LIMIT 1) AS dc_file_name",
            "(SELECT ir_file_name
      FROM invoice_sublist
      WHERE dc_number = invoice_creation_main.dc_number
        AND is_delete = 0
      LIMIT 1) AS ir_file_name",
            "(SELECT invoice_file_org_name
      FROM invoice_sublist
      WHERE dc_number = invoice_creation_main.dc_number
        AND is_delete = 0
      LIMIT 1) AS invoice_file_org_name",
       "(SELECT file_invoice
      FROM invoice_sublist
      WHERE dc_number = invoice_creation_main.dc_number
        AND is_delete = 0
      LIMIT 1) AS file_invoice",
            "doc_approval_sts",
            "approved_by",
            "unique_id as invoice_unique_id",
            "(SELECT get_executive_name(executive_name)  FROM po_form  WHERE po_form.unique_id = $table.form_main_unique_id and po_form.is_delete = 0) as executive_name",
            "po_date",
            "(SELECT ledger_name FROM department_creation_sublist WHERE department_creation_sublist.unique_id = " . $table . ".ledger_name and department_creation_sublist.is_delete='0' group by department_creation_sublist.unique_id ) AS ledger_name",
              "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            "DATE_FORMAT(dc_date,'%d-%m-%Y') as dc_date",
            "team_mem",
            "(select zone from consignee_details_sub  where unique_id=invoice_creation_main.consignee_unique_id) as zone"
        ];


       $table_details = [
        $table,
    $columns
];


        $where_parts1 = [];


    $where_parts1[] = "doc_approval_sts = '1'";
       

    
            
        
        if(!empty($from_date) && !empty($to_date)) {

        if ($opt === '4') {
            $where_parts1[] = "po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
        } else if ($opt === '5') {

            $where_parts1[] = "invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";
        }

        }

    //    if (!empty($state)) {

    //         $where_parts1[] = "state_name = '" . addslashes($state) . "'";
    //     }
if (!empty($state)) {
    $where_parts1[] = "
        invoice_creation_main.form_main_unique_id IN (
            SELECT unique_id
            FROM po_form
            WHERE state_name = '" . addslashes($state) . "'
            AND is_delete = 0
        )
    ";
}
        // if (!empty($zone)) {

        //     $where_parts1[] = "zone = '" . addslashes($zone) . "'";

        // }
        if (!empty($zone)) {
    $where_parts1[] = "
        invoice_creation_main.consignee_unique_id IN (
            SELECT unique_id
            FROM consignee_details_sub
            WHERE zone = '" . addslashes($zone) . "'
            AND is_delete = 0
        )
    ";
}
// echo $where;
        $where = implode(" AND ", $where_parts1);


// print_r($where);
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];


        // Datatable Ordering 
        $order_by = datatable_sorting_elcot($order_column, $order_dir, $columns);
        $order_by = "(doc_approval_sts = 1) $order_dir";
        // $order_by = "";

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
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;


            foreach ($res_array as $key => $value) {

                $value['sno'] = $sno++;
               
 $value['dc_number'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                $orgDate = $value['po_date'];
                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

            // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
$value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

            // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

$value['con_address'] =  '<span style="font-weight:bold;text-transform: uppercase;">'.$value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' .$value['con_address']  . '</span>';

            // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
$value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';


                $team_member = $value['team_member'];
               

                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    
                    
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                }
                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];

                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];


                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                $invoice_value = $value['invoice_value'];

                $invvalue = moneyFormatIndia1(($invoice_value));

                
                $value['invoice_value'] = '<div style="text-align:right;">
                <span >' . $invvalue . '</span>';
               
                $d = $value['invoice_no'];
                // $where_2 = "invoice_no = '".$d."' AND ORDER BY doc_approval_sts='0'";
                $where_2 = "invoice_no = '" . $d . "' AND is_delete=0";

                // 

                $table_1 = "invoice_creation_main";

                $columns_2 = [
                    // 'COUNT(invoice_no) AS count'
                    "invoice_doc_status",
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                $data_st = $result_values_12->data;
                
                 $btn_view = btn_matview($folder_name, $value['invoice_unique_id']);
                $btn_update = btn_update($folder_name, $value['invoice_unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {

                    if ($data_st[0]['invoice_doc_status'] == '4') {
                        // echo "hii";
                        $value['invoice_unique_id'] = "";
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            // $value['invoice_unique_id'] = $btn_update;
                            $value['invoice_unique_id'] = $btn_view;
                            
                            // echo"hi";
                        } else {
                            $value['invoice_unique_id'] = '';
                        }
                    }

                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") {

                    if (in_array('5f88082b25ec031952', $action_ids)) {
                        // $value['invoice_unique_id'] = $btn_update;
                         $value['invoice_unique_id'] = $btn_view;
                        // echo"hello";
                    }
                   
                    else {
                        $value['invoice_unique_id'] = '';
                    }
                }

               
                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="20px" width="20px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button" >
                <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
            Comparison Attachment </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                    <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                    <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                    <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                </div>
                            </div>
                          
                            <div class="row mt-2">
                               <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                   <h4 class="text-center">PO Attachment</h4>
                                        <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="900">
                                            <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="900">
                                            </iframe>
                                        </object>
                                </div>
                                <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                    <h4 class="text-center">DC Attachment</h4>
                                    <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                               <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                    <h4 class="text-center">IR Attachment</h4>
                                    <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                               <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                    <h4 class="text-center">Invoice Attachment</h4>
                                    <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="900">
                                        <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="900">
                                        </iframe>             
                                    </object>
                               </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                            
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->';
                // $sno++;
                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';

                if ($value['doc_approval_sts'] == "1") {
                    $value['doc_approval_sts'] = "Approved";
                } else if ($value['doc_approval_sts'] == "2") {
                    $value['doc_approval_sts'] = "Not Approval";
                } else {
                    $value['doc_approval_sts'] = "Pending";
                }

                if ($value['approved_by']) {
                    $value['approved_by'] = disname($value['approved_by']);
                } else {
                    $value['approved_by'] = '--';
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

        $screen_id_val        = $_POST['screen_id_val'];
        $user_type_unique_id  = $_POST['user_type_unique_id'];
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



        case 'get_zone':

             $state = $_POST['state_name'];
             $zone = zone_namesby_state($state);
            $zone_options = select_option($zone, "Select Zone");

        echo $zone_options;

        break;


         case 'com_get_zone':

             $state = $_POST['state_name'];

             $zone = zone_namesby_state($state);
            $zone_options = select_option($zone, "Select Zone");

        echo $zone_options;

        break;




    // new changes select all approvall

    case 'pending_approval_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $doc_approval_sts = $_POST['doc_approval_sts'];

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $columns = [
            "invoice_unique_id",
            "'' as  sno",
            // "get_po_number(form_main_unique_id) as po_num",
            "po_num",
            "(SELECT staff_name FROM user WHERE user.staff_id = " . $table . ".team_mem and user.is_delete='0') AS team_member",
            "(SELECT department FROM department_creation WHERE department_creation.unique_id = " . $table . ".department group by department_creation.unique_id ) AS department",
            // "con_contact_name",
            "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete=0 group by consignee_details_sub.unique_id) AS con_address",
            // "con_address",
            "dc_number",
            "invoice_no",
            // "invoice_date",
            "file_name",
            "dc_file_name",
            "ir_file_name",
            "file_invoice",
            "invoice_file_org_name",
            "doc_approval_sts",
            "approved_by",
            "invoice_doc_status",
            "team_mem",
            //  "get_po_date(form_main_unique_id)as po_date",
            "po_date",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
            // "is_active",
            // "unique_id"
        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "doc_approval_sts='0'";
        
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];


        // Datatable Ordering 
        $order_by = datatable_sorting_elcot($order_column, $order_dir, $columns);
        // $order_by = " STR_TO_DATE(po_date, '%Y-%m-%d') $order_dir";

        $order_by = "(doc_approval_sts=1) $order_dir";
        // $order_by = "(doc_approval_sts='1') $order_dir, STR_TO_DATE(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "doc_approval_sts $order_dir, STR_TO_DATE(po_date, '%Y-%m-%d') $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        // $result         = $pdo->select($table_detaWils,$where, '', '',$order_by,  $sql_function);
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        $total_records = total_records();
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;



            foreach ($res_array as $key => $value) {


                $invoice_unique_id = $value['invoice_unique_id'];
                $dc_number = $value['dc_number'];
                $value['invoice_unique_id'] = '<div class="checkbox-container">
                    <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox">
                
                    <input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="1">
                    <input type="hidden" name="invoice_id" id="invoice_id" value="' . $invoice_unique_id . '">
                    <input type="hidden" name="approved_by" id="approved_by" value="' . $session_approved_by . '">
                    <input type="hidden" name="dc_number" id="dc_number" value="' . $dc_number . '">
                           
                    </div>';

                $value['sno'] = $sno++;
                $orgDate = $value['po_date'];
                $value['po_num'] = '<span style="font-weight:bolder">'.$value['po_num'].'</span>'.'<br>'.'<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                }
                 $value['dc_number'] = '<span style="font-weight:bolder">'.$value['dc_number'].'</span>'.'<br>'.'<span class="po_date">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';
              
                 $value['invoice_no'] = '<span style="font-weight:bolder">'.$value['invoice_no'].'</span>'.'<br>'.'<span class="po_date">' . $value['invoice_date'] . '</span>';
                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];

                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];

                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' AND ORDER BY doc_approval_sts='0'";
                // 

                $table_1 = "invoice_creation_main";

                $columns_2 = [
                    'COUNT(invoice_no) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                $data_st = $result_values_12->data;
                
                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
                    <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
                Comparison Attachment </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                        <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                        <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                        <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                    </div>
                                </div>
                              
                                <div class="row mt-2">
                                   <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                       <h4 class="text-center">PO Attachment</h4>
                                            <object data="uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="400">
                                                <iframe src="uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="400">
                                                </iframe>
                                            </object>
                                    </div>
                                    <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                        <h4 class="text-center">DC Attachment</h4>
                                        <object data="uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="400">
                                            <iframe src="uploads/invoice/' . $dc_file_name . '"  width="100%" height="400">
                                            </iframe>             
                                        </object>
                                   </div>
                                   <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                        <h4 class="text-center">IR Attachment</h4>
                                        <object data="uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="400">
                                            <iframe src="uploads/invoice/' . $ir_file_name . '"  width="100%" height="400">
                                            </iframe>             
                                        </object>
                                   </div>
                                   <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                        <h4 class="text-center">Invoice Attachment</h4>
                                        <object data="uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="400">
                                            <iframe src="uploads/invoice/' . $inv_file_name . '"  width="100%" height="400">
                                            </iframe>             
                                        </object>
                                   </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->';
                // $sno++;
                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';

                if ($value['doc_approval_sts'] == "1") {
                    $value['doc_approval_sts'] = "Approved";
                } else if ($value['doc_approval_sts'] == "2") {
                    $value['doc_approval_sts'] = "Not Approval";
                } else {
                    $value['doc_approval_sts'] = "Pending";
                }
$value['team_member'] = disname($value['team_member']);
                // $invoice_doc_status=
                if ($value['approved_by']) {
                    $value['approved_by'] = disname($value['approved_by']);
                } else {
                    $value['approved_by'] = '--';
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



    case 'approval':

        $table_invoice_main = "invoice_creation_main";

        $approved_by = $_POST['approved_by'];
        $doc_approval_sts = $_POST['approval_status'];
        $invoice_unique_id = $_POST['invoice_unique_id'];
        $invoice_doc_status = $_POST['invoice_doc_status'];

        $dc_number = $_POST['dc_number'];


        $columns = [
            'doc_approval_sts' => 1,
            'approved_by' => $approved_by,
            'approved_date' => date('Y-m-d'),
            'invoice_doc_status' => 1,

        ];


        $update_where = 'unique_id="' . $invoice_unique_id . '"  ';
        // print_r($update_where);die();

        $action_obj = $pdo->update($table_invoice_main, $columns, $update_where);

        // print_r($action_obj);die();

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;

            $msg = "update";


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


    case 'delete':

        $unique_id = $_POST['unique_id'];
        // $doc_approval_sts      = $_POST['doc_approval_sts'];

        // if($doc_approval_sts =='2'){
        //     $columns_1        = [
        //         "is_delete"   => 1
        //     ];

        //     $update_where_1   = [
        //         "is_delete"     => 1
        //     ];
        //     $action_obj_1     = $pdo->update($table_sub,$columns_1,$update_where_1);

        // }
        // print_r()

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
function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file_name);
    $image_view = '';

    if ($dc_file_name) {
        foreach ($file_names as $file_key => $dc_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file_name);

            if ($dc_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '"  height="20px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }

    return $image_view;
}



// doc 2

function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file_name);
    $image_view1 = '';

    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view1 .= "&nbsp";
                } else {
                    $image_view1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file_name);

            if ($ir_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '"  height="20px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view1 .= '<a href="javascript:print_pdf(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }

    return $image_view1;
}


// doc3
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $file_invoice);
    $image_view2 = '';

    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view2 .= "&nbsp";
                } else {
                    $image_view2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_invoice);

            if ($file_invoice) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '"  height="20px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view2 .= '<a href="javascript:print_pdf(\'/' . $file_invoice . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }

    return $image_view2;
}


// doc3


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
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="uploads/' . $folder_name . '/' . $file_name . '"  height="20px" width="20px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/pdf.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/excel.png"  height="20px" width="20px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="uploads/po_form/po_attach/word.png"  height="20px" width="20px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}

