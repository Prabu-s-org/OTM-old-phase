<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table_invoice_main = "invoice_creation_main";
$table = "view_doc_approval_list_final_ac_team";

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


        $material_qc_status = $_POST["material_qc_status"];
        $invoice_unique_id = $_POST["invoice_unique_id"];
        $invoice_auto_id = $_POST["invoice_auto_id"];
        $approved_by = $_POST["approved_by"];
        $unique_id = $_POST["unique_id"];
        $dc_number = $_POST["dc_number"];

        $ac_reason_reject = $_POST['ac_reason_reject'];


        $update_where = "";

        $table_inv_main = "invoice_creation_main";
        $table_inv = "invoice_creation";
        if ($material_qc_status == 1) {
            $columns = [
                "material_qc" => $material_qc_status,
                "material_qc_approved" => $approved_by,
                "material_qc_reject_reason" => $ac_reason_reject
            ];
        } else {
            $columns = [
                "material_qc" => $material_qc_status,
                "material_qc_approved" => $approved_by,
                "material_qc_reject_reason" => $ac_reason_reject
            ];
        }

        $update_where_1 = "dc_number = '" . $dc_number . "'";
        $action_obj1 = $pdo->update($table_inv_main, $columns, $update_where_1);

        if($action_obj1){

            try{
                $pdo->query("CALL update_invoice_verification_by_dcnumber()");
            }
            catch (Exception $e) {
    
}
        }

        if ($action_obj1->status) {
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

//     case 'datatable':
//         // DataTable Variables
//         $search = $_POST['search']['value'];
//         $length = $_POST['length'];
//         $start = $_POST['start'];
//         $draw = $_POST['draw'];
//         $from_date = $_POST['from_date'];
//         $to_date = $_POST['to_date'];
//         $opt = $_POST['opt'];
//         $limit = $length;
//         $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];
//         $team_mem = $_POST['team_mem'];

//         $data = [];

//         if ($length == '-1') {
//             $limit = "";
//         }

//         // Query Variables
//         $json_array = "";
//         $columns = [
//             "'' as  sno",
//             // "get_po_number(form_main_unique_id) AS po_num",
//             "po_num",
//             "get_address(consignee_unique_id) AS con_address",
//             "get_staff_name_with_staff_id(team_mem) AS team_member",
//             "invoice_no",
//              "dc_number",
//             "invoice_value",

//             "file_name",
//             "dc_file_name",
//             "ir_file_name",
//             "file_invoice",
//             "invoice_file_org_name",
//             "ac_team_verifiy_status",
//             "ac_team_approved_by",
          
//             "invoice_unique_id",
//             "doc_approval_sts",

//             "team_mem",
//              "DATE_FORMAT((select po_date from po_form where  po_form.unique_id=$table.form_main_unique_id), '%d-%m-%Y') as po_date",
//             "get_ledger_name(ledger_name) AS ledger_name",
//             "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
//             "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",


//         ];
//         $table_details = [
//             $table,
//             $columns
//         ];
   

//         $where = "doc_approval_sts = '1' AND material_qc != 1";


//         if ($ac_team_verifiy_status != '') {
//             $where .= " AND ac_team_verifiy_status LIKE '%" . $ac_team_verifiy_status . "%'";
//         }


//         if ($_POST['from_date'] == '') {
//             $from_date = date('Y-01-01');
//         } else {
//             $from_date = $_POST['from_date'];
//         }

//         if ($_POST['to_date'] == '') {
//             $to_date = date('Y-m-d');
//         } else {
//             $to_date = $_POST['to_date'];
//         }
//         if ($opt == '4') {

//             $where .= " and po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
//         } else if ($opt == '5') {

//             $where .= " and invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";
//         }

//         if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
//             if ($team_mem == '') {
//                 $where .= " ";
//             } else {
//                 $where .= " and team_mem = '$team_mem' ";
//             }
//         } else {
//             if ($team_mem == '') {
//                 $where .= " ";
//             } else {
//                 $where .= " and team_mem = '$team_mem' ";
//             }
//         }
//         // $order_by  = "ac_team_verifiy_status='0' DESC";

//         $order_column = $_POST["order"][0]["column"];
//         $order_dir = $_POST["order"][0]["dir"];

//         // Datatable Ordering 
//         $order_by = datatable_sorting_mq($order_column, $order_dir, $columns);
   
//         $order_by = "CASE 
//     WHEN material_qc = '2' THEN 1 
//     WHEN material_qc = '0' THEN 2 
//     WHEN material_qc = '1' THEN 3 
//     ELSE 4 
// END $order_dir";


//         // Datatable Searching
//         $search = datatable_searching($search, $columns);

//         if ($search) {
//             if ($where) {
//                 $where .= " AND ";
//             }

//             $where .= $search;
//         }

//         $sql_function = "SQL_CALC_FOUND_ROWS";
//         $group = "group by dc_number";
//         $result = $pdo->select($table_details, $where . $group, $limit, $start, $order_by, $sql_function);
  case 'datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];
        $team_mem = $_POST['team_mem'];

        $data = [];

        if ($length == '-1') {
            $limit = "";
        }
        $table='invoice_creation_main';

        // Query Variables
        $json_array = "";
    $columns = [
    "'' AS sno",
    "(select po_num from po_form where unique_id=invoice_creation_main.form_main_unique_id and is_delete=0) as po_num",
    "get_address(consignee_unique_id) AS con_address",
    "get_staff_name_with_staff_id(team_mem) AS team_member",
    "invoice_no",
    "dc_number",
    "invoice_value",

    "(SELECT file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_name",

    "(SELECT dc_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS dc_file_name",

    "(SELECT ir_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS ir_file_name",

    "(SELECT file_invoice
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_invoice",

    "(SELECT invoice_file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS invoice_file_org_name",

    "ac_team_verifiy_status",
    "ac_team_approved_by",
    "unique_id AS invoice_unique_id",
    "doc_approval_sts",
    "team_mem",
    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
    "get_ledger_name(ledger_name) AS ledger_name",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
];

        $table_details = [
            $table,
            $columns
        ];
   

     $where = "doc_approval_sts = '1' AND material_qc != '1' AND dc_number !='' and is_delete = '0'";
        if ($ac_team_verifiy_status != '') {
            $where .= " AND ac_team_verifiy_status LIKE '%" . $ac_team_verifiy_status . "%'";
        }


        if ($_POST['from_date'] == '') {
            $from_date = date('Y-01-01');
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = date('Y-m-d');
        } else {
            $to_date = $_POST['to_date'];
        }
       if ($opt == '4') {
    $where .= " AND po_date BETWEEN '$from_date' AND '$to_date'";
} 
else if ($opt == '5') {
    $where .= " AND invoice_date BETWEEN '$from_date' AND '$to_date'";
}


        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }
        // $order_by  = "ac_team_verifiy_status='0' DESC";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_mq($order_column, $order_dir, $columns);
   
        $order_by = "CASE 
    WHEN material_qc = '2' THEN 1 
    WHEN material_qc = '0' THEN 2 
    WHEN material_qc = '1' THEN 3 
    ELSE 4 
END $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $group = "group by dc_number";
        $result = $pdo->select($table_details, $where . $group, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();
        // print_r($result);die();
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

                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];
                // $value['file_name']='<a href="uploads/po_form/pdf.png"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a>';
                // $value['file_name']=$value['file_name'];

                // $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                // $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                // $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                // $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);  

                $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';



        //          $value['po_num'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

        //           $value['con_address'] = $value['con_address'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span>';

        //           $value['invoice_no'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

        //    $value['dc_number'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_date'] . '</span>';
$value['dc_number'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                // $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

            // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
$value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

            // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

$value['con_address'] =  '<span style="font-weight:bold;text-transform: uppercase;">'.$value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' .$value['con_address']  . '</span>';

            // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
$value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';


                if (!empty($value['file_name'])) {
                    $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                }

                if (!empty($value['dc_file_name'])) {
                    $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                }

                if (!empty($value['ir_file_name'])) {
                    // echo $value['sno'].' - '.$ir_file_name. ' | ';
                    $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                }

                if (!empty($value['file_invoice'])) {
                    $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);
                }


                
                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    //     $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                }

                

                // $btn_delete         = btn_delete($folder_name,$value['invoice_unique_id']);
                // $value['invoice_unique_id'] = $btn_update . $btn_delete;
                $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' AND is_delete='0'";
                // and ORDER BY ac_team_verifiy_status='0' DESC
                // and ORDER BY ac_team_verifiy_status='0' DESC

                $table_1 = "dispatch_list";

                $columns_2 = [
                    'COUNT(invoice_no) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;
                // print_r($data_st);die();

                $btn_update = btn_update($folder_name, $value['invoice_unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" || $_SESSION['user_type_unique_id'] == "65efd994b203619378") {

                    if ($data_st[0]['invoice_doc_status'] == '4') {
                        // echo "hii";
                        $value['invoice_unique_id'] = "";
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['invoice_unique_id'] = $btn_update;
                            // echo"hi";
                        } else {
                            $value['invoice_unique_id'] = $btn_update;
                        }
                    }

                }
                if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" || $_SESSION['user_type_unique_id'] == "65efd994b203619378") {

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
                $value['invoice_unique_id'] = $btn_update;

                // '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" type="button">';
                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="20px" width="20px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
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
                                    <h4 class="text-center">IR Attachment code</h4>
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

                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';

                if ($value['ac_team_verifiy_status'] == "1") {
                    $value['ac_team_verifiy_status'] = "Approved";
                } else if ($value['ac_team_verifiy_status'] == "2") {
                    $value['ac_team_verifiy_status'] = "Not Approval";
                } else {
                    $value['ac_team_verifiy_status'] = "Pending";
                }
                if ($value['ac_team_approved_by']) {
                    $value['ac_team_approved_by'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['ac_team_approved_by'] = '--';
                }

                if ($value['material_qc_approved']) {
                    $value['material_qc_approved'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['material_qc_approved'] = '--';
                }

                if ($value['material_qc'] == "1") {
                    $value['material_qc'] = "<span style='color:green'>Approved</span>";
                } else if ($value['material_qc'] == "2") {
                    $value['material_qc'] = "<span style='color:red'>Not Approval</span>";
                } else {
                    $value['material_qc'] = "Pending";
                }


                $invoice_value = $value['invoice_value'];

                $invvalue = moneyFormatIndia1(($invoice_value));
                
                $value['invoice_value'] = '<div style="text-align:right;">
                <span >' . $invvalue . '</span></div>';
                // $value['unique_id'] = $btn_update . $btn_delete;

                $data[] = array_values($value);
                // $sno++;
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


        case 'mqc_complete_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];
        $team_mem = $_POST['team_mem'];

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        $table='invoice_creation_main';

        $columns = [
            "'' as  sno",
               "(select po_num from po_form where po_form.unique_id=invoice_creation_main.form_main_unique_id and po_form.is_delete=0) as po_num",
            "get_address(consignee_unique_id) AS con_address",
            "get_staff_name_with_staff_id(team_mem) AS team_member",
            "invoice_no",
            "dc_number",
            "invoice_value",
            "(SELECT file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_name",

    "(SELECT dc_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS dc_file_name",

    "(SELECT ir_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS ir_file_name",

    "(SELECT file_invoice
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_invoice",

    "(SELECT invoice_file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS invoice_file_org_name",
            "ac_team_verifiy_status",
            "ac_team_approved_by",
            "material_qc",
            "material_qc_reject_reason",
            "material_qc_approved",
            "unique_id as invoice_unique_id",

            "doc_approval_sts",

            "invoice_date",
            "team_mem",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            // "DATE_FORMAT((select po_date from po_form where  po_form.unique_id=$table.form_main_unique_id), '%d-%m-%Y') as po_date",
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",

            // "po_date",
             "get_ledger_name(ledger_name) AS ledger_name",
            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",


        ];
        $table_details = [
            $table,
            $columns
        ];
   

        $where = "material_qc = 1  AND po_date >= '$from_date'
          AND po_date <= '$to_date' AND is_delete = '0'";


        if ($ac_team_verifiy_status != '') {
            $where .= " AND ac_team_verifiy_status LIKE '%" . $ac_team_verifiy_status . "%'";
        }


        if ($_POST['from_date'] == '') {
            $from_date = date('Y-01-01');
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = date('Y-m-d');
        } else {
            $to_date = $_POST['to_date'];
        }
        if ($opt == '4') {

            $where .= " and po_date >= '" . $from_date . "' AND po_date <= '" . $to_date . "'";
        } else if ($opt == '5') {

            $where .= " and invoice_date >= '" . $from_date . "' AND invoice_date <= '" . $to_date . "'";
        }


        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        } else {
            if ($team_mem == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem' ";
            }
        }
        // $order_by  = "ac_team_verifiy_status='0' DESC";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_mq($order_column, $order_dir, $columns);
   
        $order_by = "CASE 
    WHEN material_qc = '2' THEN 1 
    WHEN material_qc = '0' THEN 2 
    WHEN material_qc = '1' THEN 3 
    ELSE 4 
END $order_dir";


        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";
        $group = "group by dc_number";
        $result = $pdo->select($table_details, $where . $group, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();
        // print_r($result);die();
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

                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];
                // $value['file_name']='<a href="uploads/po_form/pdf.png"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a>';
                // $value['file_name']=$value['file_name'];

                // $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                // $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                // $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                // $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                if (!empty($value['file_name'])) {
                    $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                }

                if (!empty($value['dc_file_name'])) {
                    $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                }

                if (!empty($value['ir_file_name'])) {
                    // echo $value['sno'].' - '.$ir_file_name. ' | ';
                    $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                }

                if (!empty($value['file_invoice'])) {
                    $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);
                }


                $orgDate = $value['po_date'];
                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


        //          $value['po_num'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

        //           $value['con_address'] = $value['con_address'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span>';

        //           $value['invoice_no'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

        //    $value['dc_number'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_date'] . '</span>';
        $value['dc_number'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                // $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

            // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
$value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

            // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

$value['con_address'] =  '<span style="font-weight:bold;text-transform: uppercase;">'.$value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' .$value['con_address']  . '</span>';

            // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
$value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">'.$value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';


                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    //     $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                }

                $invoice_value = $value['invoice_value'];
                $invvalue = moneyFormatIndia1(($invoice_value));

                $value['invoice_value'] = '<div style="text-align:right;">
                <span >' . $invvalue . '</span></div>';


                // $btn_delete         = btn_delete($folder_name,$value['invoice_unique_id']);
                // $value['invoice_unique_id'] = $btn_update . $btn_delete;
                $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' AND is_delete='0'";
                // and ORDER BY ac_team_verifiy_status='0' DESC
                // and ORDER BY ac_team_verifiy_status='0' DESC

                $table_1 = "dispatch_list";

                $columns_2 = [
                    'COUNT(invoice_no) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;
                // print_r($data_st);die();

                $btn_update = btn_matview($folder_name, $value['invoice_unique_id']);

                if ($_SESSION['user_type_unique_id'] != "65deef78ba17d65741") {

                    if ($data_st[0]['invoice_doc_status'] == '4') {
                        // echo "hii";
                        $value['invoice_unique_id'] = "";
                    } else {

                        if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['invoice_unique_id'] = $btn_update;
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

                // '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" type="button">';
                $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="20px" width="20px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
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
                                    <h4 class="text-center">IR Attachment code</h4>
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

                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';

                if ($value['ac_team_verifiy_status'] == "1") {
                    $value['ac_team_verifiy_status'] = "Approved";
                } else if ($value['ac_team_verifiy_status'] == "2") {
                    $value['ac_team_verifiy_status'] = "Not Approval";
                } else {
                    $value['ac_team_verifiy_status'] = "Pending";
                }
                if ($value['ac_team_approved_by']) {
                    $value['ac_team_approved_by'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['ac_team_approved_by'] = '--';
                }

                if ($value['material_qc_approved']) {
                    $value['material_qc_approved'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['material_qc_approved'] = '--';
                }

                if ($value['material_qc'] == "1") {
                    $value['material_qc'] = "<span style='color:green'>Approved</span>";
                } else if ($value['material_qc'] == "2") {
                    $value['material_qc'] = "<span style='color:red'>Not Approval</span>";
                } else {
                    $value['material_qc'] = "Pending";
                }

                // $value['unique_id'] = $btn_update . $btn_delete;

                $data[] = array_values($value);
                // $sno++;
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
            "'' as  sno",
            "po_num",
            "get_address(consignee_unique_id) AS con_address",
            "get_staff_name_with_staff_id(team_mem) AS team_member",
            "invoice_no",
            "dc_number",
            "invoice_value",
           
            "file_name",
            "dc_file_name",
            "ir_file_name",
            "file_invoice",
            "invoice_file_org_name",
            "ac_team_verifiy_status",
            "ac_team_approved_by",
            "material_qc",
            "material_qc_reject_reason",
            "material_qc_approved",
            "invoice_unique_id",
            "doc_approval_sts",
            "invoice_date",
            "team_mem",
             "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "po_date",
            "get_ledger_name(ledger_name) AS ledger_name",
             "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",

        ];
        $table_details = [
            $table,
            $columns
        ];

        $where = "dispatch_status='0'";
        // print_r( $where);die();
        // $columns_1        = [

        //     // "is_active",
        //     "unique_id",
        //     // "invoice_unique_id",
        // ];
        // $table_details_1  = [
        //     $table_sub,
        //     $columns
        // ];
        // if($doc_approval_sts != ''){
        // $where = "doc_approval_sts LIKE '%".$doc_approval_sts."%'";
        // }
        //    $where .=" ";
        // $order_by  = "doc_approval_sts='0' DESC";

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




                //                     $value['approved_by'] = '
//     <input class="myCheck bill-checkbox" type="checkbox" id="bill_checkbox_' . $sno . '" name="bill_checkbox[]" />
//     <input type="hidden" name="doc_approval_sts" id="doc_approval_sts_' . $sno . '" value="1" />
//     <input type="hidden" name="invoice_id" id="invoice_id_' . $sno . '" value="' . htmlspecialchars($invoice_unique_id) . '" />
//     <input type="hidden" name="approved_by" id="approved_by_' . $sno . '" value="' . htmlspecialchars($session_approved_by) . '" />
// ';

                $value['sno'] = $sno++;
                // $i= $sno+1;
                // print_r($i);
                // $value['po_date']='<span class="sorting_1">' . $value['po_date'] . '</span>';
                $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                 $value['po_num'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                  $value['con_address'] = $value['con_address'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span>';

                  $value['invoice_no'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_date'] . '</span>';

           $value['dc_number'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_date'] . '</span>';


                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                //  $po_date = '<span class="sorting_1">' . $value['po_date'] . '</span>';

                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    // $orgDate1 = $value['invoice_date'];  
                    // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                }
                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];

                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];

                // $value['file_name']='<a href="uploads/po_form/pdf.png"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a>';
                // $value['file_name']=$value['file_name'];
                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                //    $file_name=  $value['file_name'];

                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);


                //   $file2 = "uploads/po_form/po_attach/pdf.png";

                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                // $btn_update         = btn_update($folder_name, $value['invoice_unique_id']);
                // $btn_delete         = btn_delete($folder_name,$value['invoice_unique_id']);


                // $btn_update         = btn_update($folder_name, $value['unique_id']);

                // $value['unique_id'] = $btn_update . $btn_delete;
                // print_r($value['invoice_no']);die();
                // $where_2      = [
                //     "invoice_no" => $value['invoice_no'],
                //     "ac_team_verifiy_status" => '1'
                // ];
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
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;
                // print_r($data_st[0]['count']);
                // print_r($data_st[0]['count']);die();
                // $btn_delete         = btn_delete($folder_name, $value['unique_id']);
                // $btn_view           = btn_view1($folder_name, $value['unique_id'] );
                //   if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741"){
                //     // echo "hii";
                //     if($data_st[0]['count']){
                //         // echo "hii";

                //         $value['invoice_unique_id']     =  "";

                //       }else{
                //         // echo "hoo";
                //         $value['invoice_unique_id']     =   $btn_update;
                //       }

                //   }
                //   if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                //     // echo "hello";
                //     $value['invoice_unique_id']     =   $btn_update;
                //   }
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


    case 'pending_list_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $limit = $length;
        $ac_team_verifiy_status = $_POST['ac_team_verifiy_status'];

        $data = [];


        if ($length == '-1') {
            $limit = "";
        }

        // Query Variables
        $json_array = "";
        // $columns = [
        //     "invoice_unique_id",
        //     "'' as  sno",
        //     "dc_number",
        //     "po_num",
        //     "get_staff_name_with_staff_id(team_mem) AS team_member",
        //     "get_ledger_name(ledger_name) AS ledger_name",
        //     "invoice_no",
        //     "invoice_value",
        //     "file_name",
        //     "dc_file_name",
        //     "ir_file_name",
        //     "file_invoice",
        //     "invoice_file_org_name",
        //     "ac_team_verifiy_status",
        //     "ac_team_approved_by",
        //     "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
        //     "po_date",
        //     "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
        //     "get_address(consignee_unique_id) AS con_address",
        //     "doc_approval_sts",

        //     "invoice_date",
        //     "team_mem",
        // ];
  $table='invoice_creation_main';

         $columns = [
    "unique_id AS invoice_unique_id",
    "'' AS sno",
    "(select po_num from po_form where unique_id=invoice_creation_main.form_main_unique_id and is_delete=0) as po_num",
    "get_address(consignee_unique_id) AS con_address",
    "get_staff_name_with_staff_id(team_mem) AS team_member",
    "invoice_no",
    "dc_number",
    "invoice_value",

    "(SELECT file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_name",

    "(SELECT dc_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS dc_file_name",

    "(SELECT ir_file_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS ir_file_name",

    "(SELECT file_invoice
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS file_invoice",

    "(SELECT invoice_file_org_name
      FROM invoice_sublist
      WHERE invoice_sublist.dc_number = invoice_creation_main.dc_number
      LIMIT 1) AS invoice_file_org_name",

    "ac_team_verifiy_status",
    "ac_team_approved_by",
    "unique_id AS invoice_unique_id",
    "doc_approval_sts",
    "team_mem",
    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
    "get_ledger_name(ledger_name) AS ledger_name",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
];
        $table_details = [
            $table,
            $columns
        ];
    
       $where ="doc_approval_sts = '1' AND material_qc != '1' AND dc_number !='' and is_delete = '0'";

// print_r($where);
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by = datatable_sorting_ac($order_column, $order_dir, $columns);
        $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        $total_records = total_records();
        // print_r($result);die();x
        $sno = 1;
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {
                $value['sno'] = $sno++;

                $invoice_unique_id = $value['invoice_unique_id'];
                $dc_number = $value['dc_number'];

                $value['invoice_unique_id'] = '<div class="checkbox-container">
                        <input class="myCheck" type="checkbox" name="bill_checkbox[]"  id="bill_checkbox">
                    
                        <input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="1">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="' . $invoice_unique_id . '">
                        <input type="hidden" name="approved_by" id="approved_by" value="' . $session_approved_by . '">
                        <input type="hidden" name="dc_number" id="dc_number" value="' . $dc_number . '">
                    </div>';
                // $value['dc_number'] = '<div"><span >' .$value['dc_number']. '</span></div>';


                
    $value['dc_number'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . date("d-m-Y", strtotime($value['dc_date'])) . '</span>';

    
    $value['po_num'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

    $value['ledger_name'] = $value['ledger_name'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span>';

        $value['invoice_no'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_date'] . '</span>';


                $file_name = $value['file_name'];
                $dc_file_name = $value['dc_file_name'];
                $ir_file_name = $value['ir_file_name'];
                $inv_file_name = $value['file_invoice'];
                 if (!empty($value['file_name'])) {
                    $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                }

                if (!empty($value['dc_file_name'])) {
                    $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
                }

                if (!empty($value['ir_file_name'])) {
                    // echo $value['sno'].' - '.$ir_file_name. ' | ';
                    $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                }

                if (!empty($value['file_invoice'])) {
                    $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);
                }


                // $orgDate = $value['po_date'];
                // // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


                if ($value['invoice_date'] == '') {
                    $value['invoice_date'] = '';
                } else {
                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                }

                $invoice_value = $value['invoice_value'];
                $value['invoice_value'] = '<div style="text-align:right;"><span>' .moneyFormatIndia1(($invoice_value)) . '</span></div>';

              $d = $value['invoice_no'];
                $where_2 = "invoice_no = '" . $d . "' AND is_delete='0'";
                $table_1 = "dispatch_list";

                $columns_2 = [
                    'COUNT(invoice_no) AS count'
                ];

                $table_details_1 = [
                    $table_1,
                    $columns_2
                ];

                $result_values_12 = $pdo->select($table_details_1, $where_2);
                // print_r($result_values_12);die();
                $data_st = $result_values_12->data;
                // print_r($data_st);die();

        

              $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
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
                                    <h4 class="text-center">IR Attachment code</h4>
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

                if ($value['ac_team_verifiy_status'] == "1") {
                    $value['ac_team_verifiy_status'] = "Approved";
                } else if ($value['ac_team_verifiy_status'] == "2") {
                    $value['ac_team_verifiy_status'] = "Not Approval";
                } else {
                    $value['ac_team_verifiy_status'] = "Pending";
                }
                if ($value['ac_team_approved_by']) {
                    $value['ac_team_approved_by'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['ac_team_approved_by'] = '--';
                }

                if ($value['material_qc_approved']) {
                    $value['material_qc_approved'] = disname($value['ac_team_approved_by']);
                } else {
                    $value['material_qc_approved'] = '--';
                }

                if ($value['material_qc'] == "1") {
                    $value['material_qc'] = "<span style='color:green'>Approved</span>";
                } else if ($value['material_qc'] == "2") {
                    $value['material_qc'] = "<span style='color:red'>Not Approval</span>";
                } else {
                    $value['material_qc'] = "Pending";
                }
                $data[] = array_values($value);
                // $sno++;
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

  case 'approval_list_qc':
    // echo "gbhn";
    // print_r("test");die();

        $table_invoice_main = "invoice_creation_main";
// print_r($table_invoice_main);
        $approved_by = $_POST['approved_by'];
        // print_r($approved_by);die();
        $doc_approval_sts = $_POST['approval_status'];
        // print_r($doc_approval_sts);die();
        $invoice_unique_id = $_POST['invoice_unique_id'];
        // print_r($invoice_unique_id);die();
        $dc_number = $_POST['dc_number'];
        // print_r($dc_number);die();

        $columns = [
            'ac_team_verifiy_status' => 1,
            'ac_team_approved_by' => $approved_by,
            'ac_approved_date' => date('Y-m-d'),
            "invoice_doc_status" => 4,
            "material_qc" => 1,
            "material_qc_approved" => $approved_by,
        ];

        $update_where = 'dc_number="' . $dc_number . '" ';
        // print_r($update_where);

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

            // if ($dc_file_name) {
            if (!empty($dc_file_name)) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file_name . '"  height="20px" width="20px" ></a>';
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
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file_name . '"  height="20px" width="20px" ></a>';
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
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="uploads/' . $folder_name . '/' . $file_invoice . '"  height="30px" width="30px" ></a>';
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

