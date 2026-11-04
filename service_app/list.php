<?php
include 'header.php';
include '../config/dbconfig.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get username from session
 $user_name = $_SESSION['user_name'] ?? 'N/A';
 $user_id = $_SESSION['user_id'] ?? 'N/A';
 $user_type_unique_id = $_SESSION['user_type_unique_id'] ?? 'N/A';
if ($user_name === 'N/A') {
    die("User name is missing in session.");
}

$queryFollowups = "SELECT COUNT(*) as total_followups FROM view_installation_followups WHERE engineer_name = :unique_id AND installation_com_date IS NOT NULL";
$stmtFollowups = $conn->prepare($queryFollowups);
$stmtFollowups->bindParam(':unique_id', $user_id, PDO::PARAM_STR);
$stmtFollowups->execute();
$followupCount = $stmtFollowups->fetchColumn();


// Close connections
$stmt = null;
$stmtUniqueId = null;
$stmtFollowups = null;
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accordion Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            margin: 10px;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .accordion-item {
            display: none;
        }

        .accordion-item.show {
            display: block;
        }

        .get {
            padding: 0px 14px;
        }

        .count-bg a {
            text-decoration: none;
            font-size: 18px;
        }
        .sub-hed{ padding:10px 20px;}
        table.stl tr{border-bottom: 1px dotted #cecece;}
        
         .icon-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px auto;
    background: rgba(255, 255, 255, 0.5);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
table.list-tab tr th {   width: 25%;}
  .icon-circle svg {
    width: 16px;
    height: 16px;
    stroke-width: 2.8px;
  }
table.list-tab {    display: inline-table;}
  .user-icon { background-color: #e9f3e9; }
  .id-icon { background-color: #e9f3e9; }
  .zone-icon { background-color: #e9f3e9; }
  .district-icon{ background-color: #e9f3e9; }
   .state-icon{ background-color: #e9f3e9; }
    .email-icon{ background-color: #e9f3e9; }
     .phone-icon{ background-color: #e9f3e9; }

  .icon svg {
    stroke: #359239;
    fill: none;
  }
  table.list-tab tr td {
    font-weight: 500;
    color: #000000;
    font-size: 16px;
}
    </style>
</head>

<body>
    <?php
    error_reporting(0);
    session_start();
    include('session.php');
    $usertype = $_SESSION["user_type_unique_id"];
    $folder_name = explode("/", $_SERVER['PHP_SELF']);
    $folder_name = $folder_name[count($folder_name) - 2];
    $fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
    $fileUploadPath = $fileUploadConfig->get("upload_folder");
    $fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
    $curr_date = date("Y-m-d");

    $table_install = "view_eng_calls";
    $where_1 = "engineer_name='" . $unique_id . "' AND user_type_unique_id='" . $user_type_unique_id . "'";

    $columns_1 = [
        "'' as s_no",
        "engineer_name",
        "po_num",
        "po_date",
        "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_eng_calls.department) AS department",
        "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_eng_calls.con_district) AS con_district",
        "con_address",
        "po_file_name",
        "dc_file_name",
        "ir_file_name",
        "file_invoice",
        "installation_status",
        "delivery_due_dates",
        "consignee_unique_id",
        "form_main_unique_id",
        "con_pincode",
        "DATE_FORMAT(installation_com_date, '%d-%m-%Y') AS installation_com_date",
        "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
        "invoice_no",
        "(SELECT delivery_date FROM dispatch_list WHERE dispatch_list.invoice_no = view_eng_calls.invoice_no ) AS delivery_date",
        "(SELECT delivery_proof FROM dispatch_list WHERE dispatch_list.invoice_no = view_eng_calls.invoice_no AND is_delete='0') AS delivery_proof",


    ];

    $table_details_1 = [$table_install, $columns_1];
    $result_values_data = $pdo->select($table_details_1, $where_1);
    $eng_count = 0;


    if ($result_values_data->status) {
        $result_values_data = $result_values_data->data;
        $eng_count = count($result_values_data);
    }




    // user details
    
   $session_user_id = $_SESSION['user_id'];
// $session_user_id  = $_SESSION['user_name'];
$session_engineer_id = $_SESSION['engineer_id'];



    $user_table = "user";



    $user_where = "unique_id='" . $session_engineer_id . "'";

    $user_columns = [

        "staff_name AS engineer_name",
        "staff_id",
        "mobile_no",
        "email_id",
        "zone_name",
        "'Service Engineer' AS designation"
    ];

    $user_details = $pdo->select([$user_table, $user_columns], $user_where);


    if ($user_details->status && !empty($user_details->data)) {
        $user_data = $user_details->data[0];

        $employee_name = $user_data["engineer_name"];
        $employee_id = $user_data["staff_id"];
        $designation = $user_data["designation"];
        $mobile_no = $user_data["mobile_no"];
        $zone_name = $user_data["zone_name"];
        $email_id = $user_data['email_id'] ?? 'N/A';

 $district_name = $user_data["district_name"]?? '-';
            $zone_name = $user_data["zone_name"]?? '-';
            $state_name = $user_data["state_name"]?? '-';
    } else { 

        $vendor_table = "vendor_creation";
        $vendor_where = "unique_id='" . $session_user_id . "'";

        $vendor_columns = [
            "name AS engineer_name",
            "contact_no AS mobile",
            "'Vendor' AS designation",
            "contact_no",
            "(select district_name from district_creation where vendor_creation.district_name=district_creation.unique_id) as district_name",
            "zone_name",
            "mail_id",
            "(select state_name from state_creation where vendor_creation.state_name=state_creation.unique_id) as state_name"
        ];


      $vendor_details = $pdo->select([$vendor_table, $vendor_columns], $vendor_where);



        if ($vendor_details->status) {
            $vendor_data = $vendor_details->data[0];

            $employee_name = $vendor_data["engineer_name"];
            // $employee_id = '-';
            $designation = $vendor_data["designation"];
            $email_id = $vendor_data["mail_id"];
            $contact_no = $vendor_data["contact_no"];
            $district_name = $vendor_data["district_name"];
            $zone_name = $vendor_data["zone_name"];
            $state_name = $vendor_data["state_name"];
        } else {
            echo "No data found.";
            die();
        }
        
    }
    ?>


    <div class="sub-hed">
        <div class="row">
            <div class="col-3 log-out">
                <a href="index.php"><i class="fa fa-sign-out"></i></a>
            </div>
            <div class="col-9">
                <div class="chnage-pass" style="display: none;">

                    <p><a href="forgot_password.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change
                            Password</a></p>
                </div>
                <div class="chnage-pass">

                </div>
            </div>
        </div>
    </div>
<div class="botm-box mt-3">
        <div class="row">
            
            <div class="col-12">
                <table class="list-tab stl">
                     <?php if ($designation == 'Service Engineer') { ?>
                    <tr>
                        <th>
                            <span class="icon-circle id-icon icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/>
                                    <circle cx="9" cy="10" r="2"/>
                                    <path d="M15 8h4M15 12h4M9 14h0"/>
                                </svg>
                                </span>
                        </th>
                        <td ><?php echo htmlspecialchars($employee_id); ?></td>
                    </tr>
                       <?php } ?>

                    <tr>
                       <th>
                        <span class="icon-circle user-icon icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5z"/>
                                <path d="M2 22c0-5.5 4.5-10 10-10s10 4.5 10 10"/>
                            </svg>
                        </span></th>
                        <td><?php echo htmlspecialchars(ucfirst($_SESSION['user_name'])); ?> </td>
                    </tr>
                     <tr>
                       <th>
                        <span class="icon-circle user-icon icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5z"/>
                                <path d="M2 22c0-5.5 4.5-10 10-10s10 4.5 10 10"/>
                            </svg>
                        </span></th>
                        <td><?php echo htmlspecialchars(ucfirst($_SESSION['staff_name'])); ?> <span style="color: green;">- <?php echo $designation;?> </span></td>
                    </tr>
                    <tr>
                       <th>
                        <span class="icon-circle zone-icon icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M14.31 8l-5.63 8 8-5.63L14.31 8z"/>
                            </svg>
                        </span></th>
                        <td><?php echo htmlspecialchars(ucfirst($zone_name)); ?></td>
                    </tr>
                    <tr>
                       <th>
                        <span class="icon-circle district-icon icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                        </span></th>
                        <td><?php echo htmlspecialchars(ucfirst($district_name)); ?></td>
                    </tr>
                   
                    <?php if ($designation != 'Service Engineer') { ?>
                    <tr>
                       <th>
                        <span class="icon-circle state-icon icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M5 3v18M5 3h9l-2 5 2 5H5"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                        </span></th>
                       <td ><?php echo htmlspecialchars(ucfirst($state_name)); ?></td>
                    </tr>
                    <?php } ?>

                    <tr>

                        <?php if ($designation == 'Service Engineer') { ?>

                        <tr>
                            <th><span class="icon-circle phone-icon icon">
                              <svg viewBox="0 0 24 24">
    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.08 4.18 2 2 0 014.1 2h3a2 2 0 012 1.72c.12.86.39 1.69.8 2.45a2 2 0 01-.45 2.11l-1.27 1.27a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.76.41 1.59.68 2.45.8a2 2 0 011.72 2z"/>
  </svg>
                        </span></th>
                            <td><?php echo htmlspecialchars($mobile_no); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                       <th>
                        <span class="icon-circle email-icon icon">
                            <svg viewBox="0 0 24 24">
    <rect x="3" y="5" width="18" height="14" rx="2" ry="2"/>
    <polyline points="3,7 12,13 21,7"/>
  </svg>
                        </span></th>
                        <td><?php echo htmlspecialchars($email_id); ?></td>
                    </tr>
                    
                   

                    
                    <?php if ($designation != 'Service Engineer') { ?>

                        <tr>
                            <th><span class="icon-circle phone-icon icon">
                              <svg viewBox="0 0 24 24">
    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.08 4.18 2 2 0 014.1 2h3a2 2 0 012 1.72c.12.86.39 1.69.8 2.45a2 2 0 01-.45 2.11l-1.27 1.27a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.76.41 1.59.68 2.45.8a2 2 0 011.72 2z"/>
  </svg>
                        </span></th>
                            <td col-2><?php echo htmlspecialchars($contact_no); ?></td>
                        </tr>
                    <?php } ?>

                    

                    
                </table>
            </div>
        </div>
    </div>
    <!-- <div class="botm-box mt-3">
        <div class="row">
            <div class="col-12">
                <table class="list-tab stl">
                    <tr>
                        <th>Eng Name</th>
                        <td><?php echo htmlspecialchars($_SESSION['user_name']); ?></td>
                    </tr>
                    <tr>

                        <?php if ($designation == 'Service Engineer') { ?>

                        <tr>
                            <th>Mobile No</th>
                            <td><?php echo htmlspecialchars($mobile_no); ?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th>Email Id</th>
                        <td><?php echo htmlspecialchars($email_id); ?></td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td col-2><?php echo htmlspecialchars($designation); ?></td>
                    </tr>

                    <tr>
                        <th>Staff Id</th>
                        <td col-2><?php echo htmlspecialchars($employee_id); ?></td>
                    </tr>
                    <?php if ($designation != 'Service Engineer') { ?>

                        <tr>
                            <th>Contact Name</th>
                            <td col-2><?php echo htmlspecialchars($contact_no); ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($designation != 'Service Engineer') { ?>

                        <tr>
                            <th>District Name</th>
                            <td col-2><?php echo htmlspecialchars($district_name); ?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th>Zone Name</th>
                        <td col-2><?php echo htmlspecialchars($zone_name); ?></td>
                    </tr>
                    <?php if ($designation != 'Service Engineer') { ?>
                        <tr>
                            <th>State Name</th>
                            <td col-2><?php echo htmlspecialchars($state_name); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div> -->

    <div class="m-3" id="accordionFlushExample">
        <div class="row">
            <div class="col-10">
            </div>
            <div class="col-2 align-self-center">
            </div>
        </div>
        <div class="count-bg">
            <div class="row">
                <div class="col-12 " style="text-align: center;">
                    <a href="install_list.php" style="color:white"><i class="fa fa-cog" aria-hidden="true"></i>
                            Installation</a>
                            <span style="font-size: 18px;"><b><?php echo $followupCount; ?></b></span>
                </div>
               
            </div>
        </div>

        <?php if ($result_values_data) {
            $s_no = 1;
            foreach ($result_values_data as $data) {
                $po_num_1 = htmlspecialchars($data['po_num']);
                $po_date = htmlspecialchars($data['po_date']);
                $department = htmlspecialchars($data['department']);
                $con_district = htmlspecialchars($data['con_district']);
                $con_address = htmlspecialchars($data['con_address']);
                $installation_com_date = $data['installation_com_date'];
                $invoice_no = $data['invoice_no'];
                $po_file_name = $data['po_file_name'];
                $invoice_date = $data['invoice_date'];
                $file_invoice = $data['file_invoice'];
                $dc_file_name = $data['dc_file_name'];
                $ir_file_name = $data['ir_file_name'];

                $delivery_proof = $data['delivery_proof'];
                $delivery_date = $data['delivery_date'];
                $orgDate = $data['delivery_date'];
                $installation_status = $data['installation_status'];
                $dc_delivery_status = $data['dc_delivery_status'];

                if ($data['installation_status'] == 5) {
                    $data['installation_status'] = 'Partial completed';
                } else if ($data['installation_status'] == 2) {
                    $data['installation_status'] = 'Completed';
                } else if ($data['installation_status'] == 4) {
                    $data['installation_status'] = "Eng Assigned";
                } else if ($data['installation_status'] == 1) {
                    $data['installation_status'] = "SNR";
                }

                if ($data['dc_delivery_status'] == 0) {
                    $data['dc_delivery_status'] = 'Dispatch Pending';
                } else if ($data['dc_delivery_status'] == 5) {
                    $data['dc_delivery_status'] = 'partial Completed';
                } else if ($data['dc_delivery_status'] == 1) {
                    $data['dc_delivery_status'] = 'SNR';
                }
                if ($orgDate == '') {
                    $data['delivery_date'] = '';
                } else {
                    $data['delivery_date'] = date("d-m-Y", strtotime($orgDate));
                }

                $accordion_id = 'flush-collapse' . $s_no;
                $btn_id = 'btn-toggle' . $s_no;
                $icon_id = 'btn-icon' . $s_no;
                ?>
                <div class="accordion-item rounded-3 mb-2">
                    <h2 class="accordion-header">
                        <button id="<?php echo $btn_id; ?>" class="border-bottom collapsed fw-semibold acc-defalut"
                            type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $accordion_id; ?>"
                            aria-expanded="false" aria-controls="<?php echo $accordion_id; ?>" style="
    width: 100%;
 ">
                            <?php echo $s_no++; ?>         <?php echo $department; ?>
                            <br><span><?php echo $con_district . " | " . $con_address . " | " . $invoice_no; ?></span>
                        </button>
                    </h2>
                    <div id="<?php echo $accordion_id; ?>" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="">
                            <div class="row">
                                <div class="col-12">
                                    <table class="list-tab">
                                        <tbody>
                                            <input type="hidden" name="invoice_no" id="invoice_no"
                                                value="<?php echo $invoice_no; ?>">
                                            <input type="hidden" name="po_num" id="po_num" value="<?php echo $po_num_1; ?>">
                                            <tr>
                                                <th>PO NO</th>
                                                <td class="get">:</td>
                                                <td><?php echo $po_num_1; ?></td>
                                            </tr>
                                            <tr>
                                                <th>PO Date</th>
                                                <td class="get">:</td>
                                                <td><?php echo $po_date; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td class="get">:</td>
                                                <td><?php echo $department; ?></td>
                                            </tr>
                                            <tr>
                                                <th>District</th>
                                                <td class="get">:</td>
                                                <td><?php echo $con_district; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Location</th>
                                                <td class="get">:</td>
                                                <td><?php echo $con_address; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Invoice No</th>
                                                <td class="get">:</td>
                                                <td><?php echo $invoice_no; ?></td>
                                            </tr>
                                            <tr class="last-child">

                                                <th>Invoice Date</th>
                                                <td class="get">:</td>
                                                <td><?php echo $invoice_date; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Call Assign Date</th>
                                                <td class="get">:</td>
                                                <td><?php echo $installation_com_date; ?></td>
                                            </tr>
                                            <tr class="last-child">

                                                <th>Delivery Date</th>
                                                <td class="get">:</td>
                                                <td><?php echo $data['delivery_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Proof</th>
                                                <td class="get">:</td>
                                                <td><a href="javascript:print_pdf_dispatch('<?php echo $delivery_proof; ?>')"
                                                        download>
                                                        <img src="http://122.165.127.123/aed_elcot/uploads/dispatch/pdf.png"
                                                            height="30px" width="30px">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Document Status </th>
                                                <td class="get">:</td>
                                                <td><?php echo $data['installation_status'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Document Dispatch Status</th>
                                                <td class="get">:</td>
                                                <td><?php echo $data['dc_delivery_status']; ?></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="img-box">
                                                <h4>PO. Att.</h4>
                                                <a href="javascript:print_pdf('<?php echo $po_file_name; ?>')" download>
                                                    <img src="http://122.165.127.123/aed_elcot/uploads/po_form/po_attach/pdf.png"
                                                        height="30px" width="30px">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="img-box">
                                                <h4>DC. Att.</h4>
                                                <a href="javascript:print_pdf_1('<?php echo $dc_file_name; ?>')" download>
                                                    <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png"
                                                        height="30px" width="30px">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="img-box">
                                                <h4>IR. Att.</h4>
                                                <a href="javascript:print_pdf_2('<?php echo $ir_file_name; ?>')" download>
                                                    <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png"
                                                        height="30px" width="30px">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="img-box">
                                                <h4>Inv.Att.</h4>
                                                <a href="javascript:print_pdf_3('<?php echo $file_invoice; ?>')" download>
                                                    <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png"
                                                        height="30px" width="30px">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function () {
                const icon = document.getElementById(this.dataset.target.replace('flush-collapse', 'btn-icon'));
                if (this.getAttribute('aria-expanded') === 'true') {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });

        function print_pdf(pdfFileName) {
            const url = 'http://122.165.127.123/aed_elcot/uploads/po_form/po_attach/' + pdfFileName;
            var poNum = document.getElementById('po_num').value;
            const last5Digits = 'PO' + "-" + poNum.slice(-5);

            fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
                .then(response => {
                    if (response.ok) {
                        // File exists, trigger the download
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = last5Digits;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        // File does not exist, show an alert
                        alert('File Not Attached');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking for the file');
                });
        }

        function print_pdf_1(pdfFileName) {
            const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
            var invoice_no = document.getElementById('invoice_no').value;
            const last5Digits = 'DC' + "-" + invoice_no.slice(-5);

            fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
                .then(response => {
                    if (response.ok) {
                        // File exists, trigger the download
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = last5Digits;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        // File does not exist, show an alert
                        alert('File Not Attached');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking for the file');
                });
        }

        function print_pdf_2(pdfFileName) {
            const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
            var invoice_no = document.getElementById('invoice_no').value;
            const last5Digits = 'IR' + "-" + invoice_no.slice(-5);

            fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
                .then(response => {
                    if (response.ok) {
                        // File exists, trigger the download
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = last5Digits;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        // File does not exist, show an alert
                        alert('File Not Attached');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking for the file');
                });
        }
        function print_pdf_3(pdfFileName) {
            const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
            var invoice_no = document.getElementById('invoice_no').value;
            const last5Digits = 'INV' + "-" + invoice_no.slice(-5);

            fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
                .then(response => {
                    if (response.ok) {
                        // File exists, trigger the download
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = last5Digits;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        // File does not exist, show an alert
                        alert('File Not Attached');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking for the file');
                });
        }

        function print_pdf_dispatch(pdfFileName) {
            const url = 'http://122.165.127.123/aed_elcot/uploads/dispatch/' + pdfFileName;

            var invoice_no = document.getElementById('invoice_no').value;
            const last5Digits = 'Dispatch_proof' + "-" + invoice_no.slice(-5);

            fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
                .then(response => {
                    if (response.ok) {
                        // File exists, trigger the download
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = last5Digits;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        // File does not exist, show an alert
                        alert('File Not Attached');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while checking for the file');
                });
        }
        function go_btn() {
            const searchValue = document.querySelector('.search__input').value.toLowerCase();
            document.querySelectorAll('.accordion-item').forEach(item => {
                const invoiceNo = item.querySelector('#invoice_no').value.toLowerCase();
                if (searchValue === "" || invoiceNo.includes(searchValue)) {
                    item.classList.add('show');
                } else {
                    item.classList.remove('show');
                }
            });
        }

        // Attach event listener to the "Go" button
        document.querySelector('.go_btn').addEventListener('click', go_btn);

        // Attach event listener to the search input for real-time filtering
        document.querySelector('.search__input').addEventListener('input', go_btn);

        // Initially show all items
        document.querySelectorAll('.accordion-item').forEach(item => item.classList.add('show'));

    </script>
</body>

</html>
