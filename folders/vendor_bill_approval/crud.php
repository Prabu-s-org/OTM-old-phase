<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Database Country Table Name
$table = "vendor_payment_details";






include '../../config/dbconfig.php';

$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);



// Include DB file and Common Functions


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

$sess_user_id = $_SESSION['user_id'];





switch ($action) {
  
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

        $data = [];
        $claim_amount = $_POST['claim_amount'];

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            "DATE_FORMAT(bill_date,'%d-%m-%Y') AS bill_date",
             "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
            "vendor_name",
            "COUNT(DISTINCT dc_num) AS dccount",
            // "IFNULL(SUM(amount), 0) AS total_amount",
            "total_amount",
           

               "CASE
    WHEN managment_team_approval_sts = 2
        THEN managment_team_approval_sts

    WHEN finance_approval = 2
        THEN finance_approval

    ELSE acc_ent_sts
END AS ven_status",


            "CASE
    WHEN managment_team_approval_sts = 2
        THEN get_staff_name(managment_team_approvedby)

    WHEN finance_approval = 2
        THEN get_staff_name(finance_approved_by)

    ELSE get_staff_name(acc_rejected_by)
END AS rejected_by",

 "CASE
    WHEN managment_team_approval_sts = 2
        THEN(managment_team_reject_reason)

    WHEN finance_approval = 2
        THEN finance_reject_reason

    ELSE acc_ent_rej_reason
END AS rejected_reason",
 "bill_remark",

         


//             "CASE
//     WHEN managment_team_approval_sts = 2
//         THEN (SELECT staff_name FROM users 
//               WHERE unique_id = managment_team_approvedby)

//     WHEN finance_approval = 2
//         THEN (SELECT staff_name FROM users 
//               WHERE unique_id = finance_approved_by)

//     ELSE NULL
// END AS rejected_by",

            "unique_id",
            "finance_approval",
            "dc_num",
            "vendor_id",
            // "(select contact_no from vendor_creation where unique_id = $table.vendor_id) as contact_no",
            // "(select mail_id from vendor_creation where unique_id = $table.vendor_id) as mail",
            // "(select address from vendor_creation where unique_id = $table.vendor_id) as address",
            "get_vendor_mail(vendor_id) AS mail",
            // "DATE_FORMAT(bill_date, '%d-%m-%Y') AS bill_date",
            "get_vendor_address(vendor_id) AS address",
            "get_vendor_company_name(vendor_id) AS vendor_reg_id",
            "get_vendor_contact(vendor_id) AS contact_no",
            "finance_remark",
            "bill_no",
            "veninvverifyid",
            "vendor_bill_app_status",
            "account_remark as udr",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",

           
            // "engineer_name"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "is_delete='0'";

        if ($_POST['from_date'] == '') {
            $from_date = '';
        } else {
            $from_date = $_POST['from_date'];
        }

        if ($_POST['to_date'] == '') {
            $to_date = '';
        } else {
            $to_date = $_POST['to_date'];
        }

        $where .= "AND vendor_bill_app_status = '0'";


        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

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

        $group_by = "bill_no";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function, $group_by);

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
        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $vendor_id = $value['vendor_id'];
                $contact_no = $value['contact_no']; // assuming vendor_id is the unique_id
                $address = $value['address']; // assuming vendor_id is the unique_id

                $value['s_no'] = $sno + 1;

                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';


                $dc_num = $value["dc_num"];

                $total_amount = $value["total_amount"];

                $remarks=  $value['finance_remark'];

                $btn_view = '<span style="display:block; text-align:center;"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green view-btn" data-bill-no="' . $value['bill_no'] . '" data-bill-date="' . $value['bill_date'] . '" data-remark = "'.$remarks.'"  data-vendor-name ="' . $value['vendor_name'] . '" data-vendor ="' . $value['vendor_id'] . '" data-vendor-mobile ="' . $value['contact_no'] . '" data-vendor-address ="' . $value['address'] . '"data-vendor-mail ="' . $value['mail'] . '" data-dc-num = "' . $value['dc_num'] . '" data-ttl-amount = "' . $value['total_amount'] . '" data-additional-amount = "' . $value['additional_amount'] . '" title="View"></i></span>';

                $value['unique_id'] = $btn_view;

                if ($value['vendor_bulk_sts'] == '1') {
                    $value['vendor_bulk_sts'] = "Vendor Allocated";
                }


                // $value['total_amount'] = '<span><b>' . $value['total_amount'] . '</b></span>';
                $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';

                $vendor_name = $value['vendor_name'];
                $vendor_reg_id = $value['vendor_reg_id'];
                $address = $value['address'];
                $contact_no = $value['contact_no'];

                $value['vendor_name'] = "<div>
                        <strong>{$vendor_reg_id}</strong><br>
                        <span>{$address} - Ph.No. {$contact_no}</span>
                    </div>";
 $value['bill_date'] = '<b>' . $value['bill_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['bill_no'] . '</span>';

if($value['vendor_inv_attach_approval_date']==""){

$value['vendor_inv_attach_approval_date']="-";
$value['veninvverifyid']="-";
 }
 else{
 $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
 }
 $value['dccount'] = '<span style="display:block; text-align:right;">' 
    . $value['dccount'] . '</span>';



    $status = $value['ven_status'];

    if($status == '0'){
        $value['ven_status'] = '<span class="text-primary fw-semibold">Pending</span>';
    }

    else if($status == '2'){

         $value['ven_status'] = '<span class="text-danger fw-semibold">Rejected</span>';
    }


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


case 'datatable_completed':
    $search = $_POST['search']['value'];
    $length = $_POST['length'];
    $start = $_POST['start'];
    $draw = $_POST['draw'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $opt = $_POST['opt'];
    $limit = ($length == '-1') ? "" : $length;

    $data = [];
    $sno = $start + 1;
    $table_vendor = "vendor_payment_details";

    $sql_function = "SQL_CALC_FOUND_ROWS";
    $order_column = $_POST["order"][0]["column"];
    $order_dir = $_POST["order"][0]["dir"];
    $order_by = datatable_sorting($order_column, $order_dir, []);

    // ✅ Only fetching accepted (status = 1) entries
    $group_by = "bill_no, vendor_id";

    $accepted_columns = [
        "'' as s_no",
        "DATE_FORMAT(bill_date,'%d-%m-%Y') AS bill_date",
        "DATE_FORMAT(vendor_inv_attach_approval_date,'%d-%m-%Y') AS vendor_inv_attach_approval_date",
        "vendor_name",
         "count(dc_num) as dc_num",   
        // "SUM(amount) AS total_amount",
        "total_amount",
         "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",
        "MAX(unique_id) AS unique_id",
        "MAX(accounts_approval) AS accounts_approval",
        "vendor_id",
        "GROUP_CONCAT(invoice_no) AS invoice_no",
        "GROUP_CONCAT(po_num) AS po_num",
        "get_vendor_address(vendor_id) AS address",
        "get_vendor_company_name(vendor_id) AS vendor_reg_id",
        "get_vendor_contact(vendor_id) AS contact_no",
        "get_staff_name(MAX(finance_approved_by)) AS finance_approved_by",
        "DATE_FORMAT(MAX(finance_approved_date), '%d-%m-%Y') AS finance_approved_date",
        "finance_reject_reason",
        "bill_no",
        "MAX(veninvverifyid) AS veninvverifyid",
        "vendor_bill_app_status",
       
        // "vendor_bill_approval_date",
        "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y') AS vendor_bill_approval_date",

        "vendor_bill_reject_reason",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",

    ];

    $where = "vendor_bill_app_status = 1";
    if (!empty($from_date) && !empty($to_date)) {
    $where .= " AND bill_date BETWEEN '$from_date' AND '$to_date'";
} elseif (!empty($from_date)) {
    $where .= " AND bill_date >= '$from_date'";
} elseif (!empty($to_date)) {
    $where .= " AND bill_date <= '$to_date'";
}

    // ✅ Step 1: Fetch only accepted records
    $accepted_result = $pdo->select(
        [$table_vendor, $accepted_columns],
        $where,
        '',
        '',
        $order_by,
        $sql_function,
        $group_by
    );

    // ✅ Step 2: Use only accepted results
    $res_array = $accepted_result->status ? $accepted_result->data : [];

    // ✅ Step 3: Remove duplicates using bill_no + vendor_id
    $unique = [];
    $filtered_array = [];
    foreach ($res_array as $row) {
        $key = $row['bill_no'] . '_' . $row['vendor_id'];
        if (!isset($unique[$key])) {
            $unique[$key] = true;
            $filtered_array[] = $row;
        }
    }

    $total_records = total_records();
    $screen_id_val = $_POST['screen_id_val'];
    $user_type = $_POST['user_type_unique_id'];

    // 🔹 Get permitted actions
    $table_user = "user_screen_permission";
    $action_data = $pdo->select(
        [$table_user, ["action_unique_id", "user_type"]],
        "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'"
    );
    $action_ids = array_column($action_data->data ?? [], 'action_unique_id');

    // ✅ Step 4: Format rows
    foreach ($filtered_array as $value) {
        $value['s_no'] = $sno++;

        $bill_no = $value['bill_no'];
        $dc_num = $value['dc_num'];

        
        $bill_date = $value['bill_date'];
        $vendor_id = $value['vendor_id'];

        $value['bill_no'] = '<span class="po_date">' . $bill_no . '</span>';
         $value['dc_num'] = '<span style="display:block; text-align:right;">' . $dc_num . '</span>';
        $value['total_amount'] = '<span style="display:block; text-align:right;"><b>' . formatIndianCurrency($value['total_amount']) . '</b></span>';
        // $value['dc_num'] = '<span style="display:block; text-align:right;"><b>' . ($value['dc_num']) . '</b></span>';
                // $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>";

                //  "get_staff_name(MAX(vendor_bill_approval)) AS vendor_bill_approval",
//  "count(dc_num) as dc_num",   
        $accounts_approval = $value['accounts_approval'];
        $value['accounts_approval'] = ($accounts_approval == 1)
            ? '<span style="color: green; font-weight: bold;">Processed</span>'
            : '<span style="color: #e74c3c; font-weight: bold;">Pending</span>';

        $btn_view = '<span style="display:block; text-align:center;"><i class="mdi mdi-eye view-btn-2" 
            data-ponum="' . $value['po_num'] . '" 
            data-billno="' . $bill_no . '"  
            data-vendor ="' . $vendor_id . '" 
            data-billdate ="' . $value['bill_date'] . '" 
            data-financerejectreason ="' . $value['vendor_bill_reject_reason'] . '" 
            data-financeapproval ="' . $value['vendor_bill_app_status'] . '" 
            data-approver ="' . $value['vendor_bill_approval'] . '"
            data-additional-amount ="' . $value['additional_amount'] . '" 
            data-approvedate ="' . $value['vendor_bill_approval_date'] . '" title="View"></i></span>';

        $value['unique_id'] = $btn_view;

        $finance_status = $value['vendor_bill_app_status'];
        if ($finance_status === '1') {
            $value['vendor_bill_app_status'] = "<div style='display:flex; justify-content:center; align-items:center; height:100%;'>
                <i class='mdi mdi-check-circle mdi-24px' style='color:green;' title='Approved'></i>
            </div>";
        }

        $vendor_reg_id = $value['vendor_reg_id'];
        $address = $value['address'];
        $contact_no = $value['contact_no'];

        $value['vendor_name'] = "<div>
            <strong>{$vendor_reg_id}</strong><br>
            <span>{$address} - Ph.No. {$contact_no}</span>
        </div>";

        $value['bill_date'] = '<b>' . $value['bill_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['bill_no'] . '</span>';

        if ($value['vendor_inv_attach_approval_date'] == "") {
            $value['vendor_inv_attach_approval_date'] = "-";
            $value['veninvverifyid'] = "-";
        } else {
            $value['vendor_inv_attach_approval_date'] = '<b>' . $value['vendor_inv_attach_approval_date'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['veninvverifyid'] . '</span>';
        }
        // $value['vendor_bill_approval'] = '<span style="display:block; text-align:right;"><b>' . ($value['vendor_bill_approval']) . '</b></span>';
        // $value['vendor_bill_approval'] = '<b>' . $value['vendor_bill_approval'] . '</b><br><span style="width:20px;white-space: nowrap;">' . $value['vendor_bill_approval_date'] . '</span>';
                $value['vendor_bill_approval'] = $value['vendor_bill_approval'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['vendor_bill_approval_date'])) . "</b>";

        $data[] = array_values($value);
    }

    $json_array = [
        "draw" => intval($draw),
        "recordsTotal" => intval($total_records),
        "recordsFiltered" => intval($total_records),
        "data" => $data
    ];

    echo json_encode($json_array);
    break;


    case 'vendor_bill_details':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $unique_id =

            $data = [];
        $bill_no = $_POST['bill_no'];

        $vendor = $_POST['vendor'];

        if ($length == '-1') {
            $limit = "";
        }

        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            'po_num',
            'dc_num',
            'dc_date',
            'invoice_qty',
            "vendor_name",
            "rate",
            "gst",
            "amount",
            "total_amount",
            "po_form_unique_id",
            "unique_id",
            "invoice_no",
            "bill_no",
            "finance_approval",
            // "get_consignee_contact_name((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1)) AS consignee_name",
            //  "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1)) AS consignee_name",
             "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.dc_num = view_outsource_vendor_verified_invoice.dc_number LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS po_date",
               "veninvverifyid",
            "vendor_inv_attach_approval_date",
        "inv_verfiy_attach",
        "po_ven_filename",
            "bill_remark",
               "gst",
            "rate",
            "invoice_qty",
            "(Select staff_name from user where unique_id = $table_vendor.vendor_bill_created_by) as bill_createdby",
            "vendor_bill_created_date",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",


        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        $where = "bill_no = '$bill_no' AND vendor_id = '$vendor' AND (finance_approval = 0 OR finance_approval = 2) AND is_delete = 0";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order



        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }


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

        // $group_by = "outsrc_eng_name";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        //  print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

                $invoice_qty = $value['invoice_qty'];

                $bill_no = $value['bill_no'];

                $dc_number = $value['dc_num'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];

                $rate = $value['rate'];
                $gst = $value['gst'];
                $amnt = $value['amount'];


                    //  $rate = $value['rate'];

                // $gst = $value['gst'];
                // $invoice_qty = $value['invoice_qty'];

   $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;


                $value['po_num'] = $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>";
                $value['invoice_no'] = $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>";
                $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>";
                // $value['dc_date'] = $value['dc_date'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['dc_date'])) . "</b>";
                

                $form_main_unique_id = $value['form_main_unique_id'];

                $unique_id = $value['unique_id'];

                $value['po_form_unique_id'] = '<select class="form-select status-select" data-unqiue-id ="' . $unique_id . '" data-bill-no ="' . $bill_no . '" name="status[' . $unique_id . ']"<option value="approved" selected>Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <textarea class="form-control mt-1 reject-reason" name="reason[' . $unique_id . ']" placeholder="Reason for Rejection" style="display: none;" rows="2"></textarea>';

                $value['amount'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>";
                $value['invoice_qty'] = "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>";
                $value['rate'] = "<span style='display:block; text-align:right;'>" . $value['rate'] . "</span>";
                $value['gst'] = "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>";

$vendor_inv_attach_approval_date = date('d-m-Y', strtotime($value['vendor_inv_attach_approval_date']));

                $data[] = [
                    "po_num" => $value['po_num'],
                    "dc_number" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "total_amount" => $value['total_amount'],
                    "bill_no" => $value['bill_no'],
                    "invoice_no" => $value['invoice_no'],
                    "unique_id" => $unique_id,
                    "status_control" => $value['po_form_unique_id'],
                    "consignee_name" => $value['consignee_name'],
                     "veninvverifyid" => $value['veninvverifyid'],
                    "vendor_inv_attach_approval_date" =>$vendor_inv_attach_approval_date,
                     "dcno" =>$dc_number,
                     "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                       "po_ven_filename" => $value['po_ven_filename'],
                     "bill_remark" => $value['bill_remark'],
                     "bill_created_by" => $value['bill_createdby'],
                     "bill_crtd_date" => $value['vendor_bill_created_date'],
                     "additional_amount" => $value['additional_amount'],
                     "basicamt" =>$basicamt,
                    //    "gst" =>$gst,
                     "gstcamt" =>$withgsttotal,

                     
                    
                ];

            }

            $json_array = [

                "data" => $data,

            ];
        } else {
            print_r($result);
        }

        echo json_encode($json_array);
        break;

    case 'bill_summary_popup':
        $bill_no = $_POST['bill_no'] ?? null;
        $vendor_id = $_POST['vendor_id'];
        // echo $bill_no;
        $table_user = "vendor_creation";
        $columns = [
            "name",
            "company_name",
            "contact_no",
            "mail_id",
            "pan_no",
            "gst_no",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
             "acc_holder_name",
            "pan_attach_file_name",
              "bank_proof",
              
        ];
        $select_where = "unique_id='" . $vendor_id . "'";

        $table_details = [
            $table_user,
            $columns
        ];

        $result = $pdo->select($table_details, $select_where);
// print_r( $result );die();
        $response = [];

        if ($result->status && count($result->data) > 0) {
            $vendor = $result->data[0]; // Only take first row
            $response = [
                'status' => true,
                'summary_data' => [
                    'name' => $vendor['name'],
                    'company_name' => $vendor['company_name'],
                    'contact_no' => $vendor['contact_no'],
                    'mail_id' => $vendor['mail_id'],
                    'pan_no' => $vendor['pan_no'],
                    'gst_no' => $vendor['gst_no'],
                    'address' => $vendor['address'],
                    'account_no' => $vendor['account_no'],
                    'ifsc_code' => $vendor['ifsc_code'],
                    'bank_name' => $vendor['bank_name'],
                    'branch_name' => $vendor['branch_name'],
                      'acc_holder_name' => $vendor['acc_holder_name'],
                    'pan_attach_file_name' => $vendor['pan_attach_file_name'],
                    'bank_proof' => $vendor['bank_proof']
                ]
            ];
        } else {
            $response = [
                'status' => false,
                'summary_data' => []
            ];
        }

        echo json_encode($response);
        break;


    case 'vendor_bill_details_popup':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $unique_id =

            $data = [];
        // $po_num = $_POST['po_num'];

        $vendor = $_POST['vendor'];
        $bill_no = $_POST['bill_no'];
        $vendor_bill_app_status = $_POST['financeapproval'];
        // echo $vendor;
        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // echo $table_vendor;
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
            'po_num',
            "invoice_no",
            'dc_num',
            "dc_date",
            // "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            'invoice_qty',
            'rate',
            'gst',
            'amount',
            'unique_id',
            'finance_approval',
            'vendor_name',
            'bill_no',
             "get_address((SELECT consignee_unique_id from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.dc_num = view_outsource_vendor_verified_invoice.dc_number LIMIT 1)) AS consignee_name",
            "(SELECT invoice_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS invoice_date",
            "(SELECT po_date from view_outsource_vendor_verified_invoice WHERE vendor_payment_details.po_form_unique_id = view_outsource_vendor_verified_invoice.form_main_unique_id LIMIT 1) AS po_date",
             "veninvverifyid",
            "vendor_inv_attach_approval_date",
            "vendor_bill_app_status",
            "vendor_bill_approval",
            "vendor_bill_approval_date",
            "vendor_bill_reject_reason",
            "inv_verfiy_attach",
            "po_ven_filename",

              "gst",
            "rate",
            "invoice_qty",
            "total_amount",
                    "(select additional_amount from vendor_payment_details_main where bill_no= $table_vendor.bill_no) as additional_amount",


        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "";

        if ($vendor_bill_app_status == 1 || $vendor_bill_app_status == 2) {
            $where = "vendor_id = '$vendor' AND vendor_bill_app_status = $vendor_bill_app_status AND bill_no = '$bill_no'";
        }


        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

        // Adjust order by PO date (index 2)
        if ($order_column == 2) {
            $order_by = "po_date $order_dir";
        }

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

        // $group_by = "outsrc_eng_name";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        //  print_r($result);die();
        $total_records = total_records();

        if ($result->status) {

            $res_array = $result->data;

            foreach ($res_array as $key => $value) {

              

                $dc_num = $value['dc_num'];

                $invoice_no = $value['invoice_no'];

                $dc_date = $value['dc_date'];
  $invoice_qty = $value['invoice_qty'];
                $rate = $value['rate'];
                $gst = $value['gst'];
                $amnt = $value['amount'];

                $po_num = $value['po_num'];
                $bill_no = $value['bill_no'];

                $unique_id = $value['unique_id'];
                 $basicamt = $invoice_qty * $rate;
                $withgsttotal = ($basicamt *( $gst / 100));

                $toatlamt = $basicamt + $withgsttotal;

                $value['unique_id'] = '<div class="checkbox-container">
                                    <input class="myCheck" type="checkbox" name="bill_checkbox[]" data-bill-no ="' . $bill_no . '" data-unique-id = "' . $unique_id . '" 
                                    data-id = "' . $dc_num . '" data-amnt = "' . $amnt . '">
                                </div>';

                $value['po_num'] = $value['po_num'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['po_date'])) . "</b>";
                $value['invoice_no'] = $value['invoice_no'] . "&nbsp;&nbsp;<br><b>" . date('d-m-Y', strtotime($value['invoice_date'])) . "</b>";
                $value['dc_num'] = $value['dc_num'] . "&nbsp;&nbsp;<br><b>" . (($value['dc_date'])) . "</b>";

                $value['amount'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['amount']) . "</b></span>";
                $value['invoice_qty'] = "<span style='display:block; text-align:right;'>" . $value['invoice_qty'] . "</span>";
                $value['rate'] = "<span style='display:block; text-align:right;'><b>" . formatIndianCurrency($value['rate']) . "</b></span>";
                $value['gst'] = "<span style='display:block; text-align:right;'>" . $value['gst'] . " %</span>";

$vendor_inv_attach_approval_date = date('d-m-Y', strtotime($value['vendor_inv_attach_approval_date']));

                $data[] = [

                    "po_num" => $value['po_num'],
                    "dc_num" => $value['dc_num'],
                    "dc_date" => $value['dc_date'],
                    "invoice_qty" => $value['invoice_qty'],
                    "rate" => $value['rate'],
                    "gst" => $value['gst'],
                    "amount" => $value['amount'],
                    "total_amount" => $value['total_amount'],
                    "consignee_name" => $value['consignee_name'],
                    "sum_amount" => $amnt,
                    "invoice_no" => $value['invoice_no'],
                    "checkbox" => $value['unique_id'],
                    "veninvverifyid" => $value['veninvverifyid'],
                    "vendor_inv_attach_approval_date" =>$vendor_inv_attach_approval_date,
                    "inv_verfiy_attach" => $value['inv_verfiy_attach'],
                     "po_ven_filename" => $value['po_ven_filename'],
                      "additional_amount" => $value['additional_amount'],
                     "basicamt" =>$basicamt,
                       "gst" =>$gst,
                     "gstcamt" =>$withgsttotal,

                    
                ];

            }

            $json_array = [

                "data" => $data,

            ];
        } else {
            print_r($result);
        }

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



    case 'payment_store_detail':

        $po_num = $_POST['po_num'];

        $po_unique_id = $_POST['po_unique_id'];
        $invoice_no = $_POST['invoice_no'];
        $invoice_qty = $_POST['invoice_qty'];
        $dc_no = $_POST['dc_no'];
        $dc_date = $_POST['dc_date'];
        $rate = $_POST['rate'];
        $gst = $_POST['gst'];
        $amount = $_POST['amount'];
        $vendor_name = $_POST['vendor_name'];

        $vendor_bill_no = vendor_payment_bill_no();

        // print_r($vendor_bill_no);
        $prefix = "";
        // $unique_id      = ;
        $unique_id = unique_id();

        $table = 'vendor_payment_details';

        $table_inv = 'invoice_verfication_table';


        $columns = [
            "unique_id" => $unique_id,

            "bill_no" => $vendor_bill_no,
            "po_num" => $po_num,
            "po_form_unique_id" => $po_unique_id,
            "invoice_no" => $invoice_no,
            "invoice_qty" => $invoice_qty,
            "dc_num" => $dc_no,
            "dc_date" => $dc_date,
            "rate" => $rate,
            "gst" => $gst,
            "total_amount" => $amount,
            "vendor_name" => $vendor_name,
            

        ];

        $upd_col = [
            'vendor_payment_allocated' => 1
        ];

        $update_where = [
            "dc_number" => $dc_no
        ];



        $action_obj = $pdo->insert($table, $columns);


        $action_obj_1 = $pdo->update($table_inv, $upd_col, $update_where);


        // print_r($action_obj);die();

        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "create";
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




    case 'vendor_bill_approval':
        // print_r($_POST);die();
        // die();
        $bill_no = $_POST['bill_no'];
       $status = $_POST['ven_approval_sts'];

        $unique_id = $_POST['unique_id'];

        $reject_reason = $_POST['reject_reason'];


        $dc_no = $_POST['dc_no'];

        $rejected_by = $_SESSION['user_id'];

        $date = date('Y-m-d H:i:s');

        $table = 'vendor_payment_details';

        $table_main = 'vendor_payment_details_main';

        $table2 = "invoice_verfication_table";

        if ($status == '1') {
            $columns = [
                "vendor_bill_app_status" => $status,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                 "acc_ent_sts"                => "0",
                 

            ];


        } else if ($status == '2') {

            $columns = [
                 "vendor_bill_app_status"      => $status,
                "vendor_bill_reject_reason"    => $reject_reason,
                "vendor_bill_approval"         => $_SESSION['user_id'],
                "vendor_bill_approval_date"    => $date,
               
                // "is_delete"                    => 1,

            ];
        }
        
        $update_where = "bill_no = '$bill_no' AND unique_id ='$unique_id'";

        $action_obj = $pdo->update($table, $columns, $update_where);

//  print_r(  $action_obj );die();
         if ($status == '1') {
            // alert("hi");
            $invoice_verify_columns = [
                "vendor_bill_app_status" => $status,
                // "vendor_bill_approval" => $_SESSION['user_id'],
                // "vendor_bill_approval_date" => $date,
                 "vendor_bill_approval_allocated" => '1',
                  "vendor_bill_reject_reason" => "",

            ];
        } else if ($status == '2') {
// alert("hlo");
         $invoice_verify_columns = [

            "vendor_bill_app_status" => $status,
            "vendor_bill_reject_reason" => $reject_reason,
            "vendor_bill_approval_allocated" => '0',
             "vendor_payment_allocated" => '0',
             'vendor_bill_no'=>"",
             "vendor_inv_attach_approval" => '',
             "vendor_inv_attach_approval_date" => '',
             "inv_verfiy_attach" => '',
             "inv_verfiy_attach_org_name" => '',
              "veninvid" => '',
             "veninvstatus" => '0',
            //   "vendor_bill_approval_allocated" => '0',
              "vendor_bill_rejected_by" => $rejected_by

            
        ];
        
        }
        $update_where_dc = "dc_number ='$dc_no'";

        $action_obj_1 = $pdo->update($table2, $invoice_verify_columns, $update_where_dc);
    //    print_r(  $action_obj_1);
        if ($status == '1') {
            $columns_main = [
                "vendor_bill_app_status" => $status,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                 "acc_ent_sts"                => "0"
                

            ];
        } else if ($status == '2') {

            $columns_main = [
                 "vendor_bill_app_status" => $status,
                "vendor_bill_reject_reason" => $reject_reason,
                "vendor_bill_approval" => $_SESSION['user_id'],
                "vendor_bill_approval_date" => $date,
                

                // "is_delete"=>1,
                // "vendor_bill_reject_reason" => $reject_reason,


            ];
        }
        
        $update_where_main = "bill_no = '$bill_no' and is_delete = 0";

        $action_obj_main = $pdo->update($table_main, $columns_main, $update_where_main);
// print_r(  $action_obj);
// print_r(  $action_obj_main);



        $total_amount = 0;

        $amount_column = [
            "(amount) as ttl_amount"
        ];

        $table_details = [

            $table,
            $amount_column
        ];

        $amount_where = "bill_no  = '$bill_no' AND dc_number ='$dc_no' and  vendor_bill_app_status != '2'";
        // print_r('test1');die();
        $get_total_sql = $pdo->select($table_details, $amount_where);

        $get_total_result = $get_total_sql->data;
        // print_r($get_total_sql);die();


        if ($get_total_result) {
            $total_amount = $get_total_result[0]['ttl_amount'];
        }

        // print_r($action_obj);die();

        if ($action_obj->status) {


            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "create";
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
            "sql" => $sql,
            "total_amount" => $total_amount
        ];

        echo json_encode($json_array);
        break;


        
        case 'vendor_bill_status':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;

        $bill_no = $_POST['bill_no'];

        $data = [];

        if ($length == '-1') {
            $limit = "";
        }
        $table_vendor = "vendor_payment_details";
        // Query Variables
        $json_array = "";
        $columns = [
            "'' as s_no",
         
            // "vendor_bill_created_date as bill_created_date",
         "DATE_FORMAT(vendor_bill_created_date,'%d-%m-%Y %H:%i:%s') as bill_created_date",

            "get_staff_name(vendor_bill_created_by) as bill_created_by",

            // " as bill_created_Status",

            "get_staff_name(vendor_bill_approval) as bill_approved",
            // "vendor_bill_approval_date",
         "DATE_FORMAT(vendor_bill_approval_date,'%d-%m-%Y %H:%i:%s') as vendor_bill_approval_date",
            
            "vendor_bill_app_status",
            "get_staff_name(vendor_account_approved_by) as acc_approve",
            // "vendor_account_approval_date",
         "DATE_FORMAT(vendor_account_approval_date,'%d-%m-%Y %H:%i:%s') as vendor_account_approval_date",

            "acc_ent_sts",

            "get_staff_name(finance_approved_by)as finance_approve",
            // "finance_approved_date",
         "DATE_FORMAT(finance_approved_date,'%d-%m-%Y %H:%i:%s') as finance_approved_date",

            "finance_approval as finance_approval_sts",
            "get_staff_name(managment_team_approvedby) as managed_approve",
            // "managment_team_approvaldate",
         "DATE_FORMAT(managment_team_approvaldate,'%d-%m-%Y %H:%i:%s') as managment_team_approvaldate",

            "managment_team_approval_sts",
            "unique_id",
            "bill_no",
            "acctotalpaybleamount as transfer_amount",
         "DATE_FORMAT(transaction_date,'%d-%m-%Y') as transfer_date",
            "transaction_id as udr",
            "accounts_approval as payment_status"

        ];
        $table_details = [
            $table_vendor,
            $columns
        ];

        $where = "bill_no = '$bill_no' AND is_delete = 0 GROUP BY bill_no";

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];

        $order_by = "unique_id $order_dir"; // Default order

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

                
                $data[] = [
    "bill_createdby" => $value['bill_created_by'] ?? '',
    "created_date" => $value['bill_created_date'] ?? '',
    "bill_create_status" => 
        (!empty($value['bill_created_by']) && !empty($value['bill_created_date'])) 
        ? 'Bill Created' : 'Pending',

    "bill_approved" => $value['bill_approved'] ?? '',
    "vendor_bill_approval_date" => $value['vendor_bill_approval_date'] ?? '',
    "vendor_bill_status" => getStatusText($value['vendor_bill_app_status'] ?? 0),
 "transfer_date" => $value['transfer_date'] ?? '',
                    "transfer_amount" => $value['transfer_amount'] ?? '',
                    "udr" => $value['udr'] ?? '',
    "acc_approve" => $value['acc_approve'] ?? '',
    "vendor_account_approval_date" => $value['vendor_account_approval_date'] ?? '',
    "acc_status" => getStatusText($value['acc_ent_sts'] ?? 0),

    "finance_approve" => $value['finance_approve'] ?? '',
    "finance_approved_date" => $value['finance_approved_date'] ?? '',
    "finance_status" => getStatusText($value['finance_approval_sts'] ?? 0),

    "managed_approve" => $value['managed_approve'] ?? '',
    "managment_team_approvaldate" => $value['managment_team_approvaldate'] ?? '',
    "management_status" => getStatusText($value['managment_team_approval_sts'] ?? 0),

"payment_status" => ($value['payment_status'] == '1')
    ? '<span class="text-success fw-semibold">Paid</span>'
    : '<span class="text-warning fw-semibold">Pending</span>',
];

             
               
            }

            $json_array = [
                "data" => $data,
            ];
        } else {
            print_r($result);
        }
        echo json_encode($json_array);
        break;





        case 'update_remark':

        $bill_no     = $_POST["bill_no"];
        $remark       =  $_POST["remark"];
         $table       = "vendor_payment_details";


       $table = "vendor_payment_details";

     $columns = [

            'bill_remark' => $remark
        ];


    $select_where = "bill_no  = '$bill_no' AND  is_delete = '0'";

    $action_obj = $pdo->update($table, $columns, $select_where);

    // print_r($action_obj);

      $table_main = "vendor_payment_details_main";

     $columns_main = [

            'bill_remark' => $remark
        ];


    $select_where_main = "bill_no  = '$bill_no' AND  is_delete = '0'";

    $action_obj_main = $pdo->update($table_main, $columns_main, $select_where_main);

    // print_r($action_obj_main);


 if ($action_obj->status) {
        $json_array = [
            "status" => 1,
            "msg"    => "update",
            "sql"    => $action_obj->sql ?? ''
        ];
    } else {
        $json_array = [
            "status" => 0,
            "msg"    => "error",
            "error"  => $action_obj->error ?? '',
            "sql"    => $action_obj->sql ?? ''
        ];
    }




  
    echo json_encode($json_array);

        break;
    default:

        break;
}






function vendor_payment_bill_no()
{

    $prefix = 'VEN';

    $year_month = date("Ym");

    $basePrefix = $prefix . '-' . $year_month;

    $servername = 'localhost';
    $username = project_env('APP_DB_USERNAME', 'root');
   $password = project_env('VENDOR_DB_PASSWORD');
    $database_name = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'Connected successfully';
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
    }
    $stmt = $conn->prepare("SELECT * FROM vendor_payment_details where `bill_no` LIKE :prefix order by unique_id desc");

    $stmt->execute(['prefix' => $basePrefix . '-%']);

    $latestBill = $stmt->fetchColumn();

    if ($latestBill) {
        // Extract the last serial number and increment
        $parts = explode('-', $latestBill); // [VEN, 202506, 0001]
        $lastSerial = (int) end($parts);
        $nextSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $nextSerial = '0001';
    }

    return $basePrefix . '-' . $nextSerial;
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

// function formatIndianCurrency($amount)
// {
//     $amount = round($amount);
//     $num = (string) $amount;
//     $len = strlen($num);
//     if ($len > 3) {
//         $last3 = substr($num, -3);
//         $restUnits = substr($num, 0, $len - 3);
//         $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
//         return $restUnits . ',' . $last3;
//     } else {
//         return $num;
//     }
// }

function getStatusText($sts)
{
    if ($sts === '1' || $sts === 1) return 'Approved';
    if ($sts === '2' || $sts === 2) return 'Rejected';
    return 'Pending';
}

function formatIndianCurrency($amount)
{
    // Round to 2 decimal places
    $amount = number_format((float) $amount, 2, '.', '');

    // Split integer and decimal parts
    list($integer, $decimal) = explode('.', $amount);

    $len = strlen($integer);
    if ($len > 3) {
        $last3 = substr($integer, -3);
        $restUnits = substr($integer, 0, $len - 3);
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . ',' . $last3;
    } else {
        $formatted = $integer;
    }

    return $formatted . '.' . $decimal;
}


