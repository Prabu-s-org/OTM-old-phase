<?php
include 'header.php';
error_reporting(0);
include('session.php');
include '../../config/dbconfig.php';
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);

session_start();
$usertype = $_SESSION['user_type_unique_id'];
$usertype = '66a767a6da93e20909';

$curr_date = date("Y-m-d");

$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";
$unique_id = "";
$form_type = "Create";
$name = "";
$user_name = "";
$password = "";
$user_type = "";
$is_active = 1;

$table = "view_eng_data";
$where = "user_type_unique_id='" . $usertype . "'";
$columns = [
    "engineer_name",
    "designation_id",
    "emp_id",
    "user_type_unique_id",
    "eng_unique_id",
];

$table_details = [
    $table,
    $columns
];

$user_values = $pdo->select($table_details, $where);
if ($user_values->status) {
    $user_values = $user_values->data;
    $user_type = $user_values[0]["user_type_unique_id"];
    $employee_name = $user_values[0]["engineer_name"];
    $emp_id = $user_values[0]["emp_id"];
    $eng_unique_id = $user_values[0]["eng_unique_id"];
} else {
    echo "No data found.";
    die();
}
?>

<div class="sub-hed">
    <div class="row">
        <div class="col-3 log-out">
            <a href="logout.php"> <i class="fa fa-sign-out"> </i></a>
        </div>
        <div class="col-9">
            <div class="chnage-pass">
                <p><a href="forgot_password.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="botm-box">
    <div class="row">
        <div class="col-12">
            <table class="list-tab">
                <tr>
                    <th>Eng Name</th>
                    <td><?php echo htmlspecialchars($employee_name); ?></td>
                </tr>
                <tr>
                    <th>Employee ID</th>
                    <td><?php echo htmlspecialchars($emp_id); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
$table_install = "view_eng_calls";
$where_1 = "engineer_name='" . $eng_unique_id . "' AND user_type_unique_id='" . $usertype . "'";
$columns_1 = [
    "'' as  s_no",
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
    // "",
    "DATE_FORMAT(installation_com_date, '%d-%m-%Y') AS installation_com_date",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "invoice_no",
];

$table_details_1 = [
    $table_install,
    $columns_1
];

$result_values_data = $pdo->select($table_details_1, $where_1);
$eng_count = 0;
if ($result_values_data->status) {
    $result_values_data = $result_values_data->data;
    $eng_count = count($result_values_data); // Count the number of engineers
}
?>

<div class="accordion accordion-flush botm-box ox-2" id="accordionFlushExample">
    <div class="count-bg">
        <div class="row">
            <div class="col-6">
                <p>Call Count</p>
            </div>
            <div class="col-6">
                <p style="text-align: end;"><?php echo $eng_count; ?></p>
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
            ?>
            <div class="accordion-item rounded-3 mb-2">
                <h2 class="accordion-header">
                    <button class="border-bottom collapsed fw-semibold acc-defalut" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <?php echo $s_no++; ?>         <?php echo $department; ?>
                        <br><span><?php echo $con_district . " | " . $con_address; ?></span>
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <table class="list-tab">
                                    <tbody>
                                        <tr>
                                            <th>PO NO</th>
                                            <td><?php echo $po_num_1; ?></td>
                                        </tr>
                                        <tr>
                                            <th>PO Date</th>
                                            <td><?php echo $po_date; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td><?php echo $department; ?></td>
                                        </tr>
                                        <tr>
                                            <th>District</th>
                                            <td><?php echo $con_district; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td><?php echo $con_address; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Invoice No</th>
                                            <td><?php echo $invoice_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Call Assign Date</th>
                                            <td><?php echo $installation_com_date; ?></td>
                                        </tr>
                                        <tr class="last-child">
                                            <th>Invoice Date</th>
                                            <td><?php echo $invoice_date; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">

                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>PO. Att.</h4>
                                            <a href="javascript:print_pdf('<?php echo $po_file_name; ?>')" download><img
                                                    src="http://122.165.127.123/aed_elcot_beta/uploads/po_form/po_attach/pdf.png"
                                                    height="30px" width="30px">
                                            </a>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>DC. Att.</h4>
                                            <a href="javascript:print_pdf_1('<?php echo $dc_file_name; ?>')"><img
                                                    src="http://122.165.127.123/aed_elcot_beta/uploads/invoice/pdf.png"
                                                    height="30px" width="30px"></a>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>IR. Att.</h4>

                                            <a href="javascript:print_pdf_2('<?php echo $ir_file_name; ?>')"><img
                                                    src="http://122.165.127.123/aed_elcot_beta/uploads/invoice/pdf.png"
                                                    height="30px" width="30px"></a>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>INV. Att.</h4>

                                            <a href="javascript:print_pdf_3('<?php echo $file_invoice; ?>')"><img
                                                    src="http://122.165.127.123/aed_elcot_beta/uploads/invoice/pdf.png"
                                                    height="30px" width="30px"></a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php

        }
    } ?>
</div>

<?php include 'footer.php'; ?>


<?php
?>
<script>

    function print_pdf(file_name) {
        onmouseover = window.open('http://122.165.127.123/aed_elcot_beta/uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_1(file_name) {
        onmouseover = window.open('http://122.165.127.123/aed_elcot_beta/uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_2(file_name) {
        onmouseover = window.open('http://122.165.127.123/aed_elcot_beta/uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_3(file_name) {
        onmouseover = window.open('http://122.165.127.123/aed_elcot_beta/uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
