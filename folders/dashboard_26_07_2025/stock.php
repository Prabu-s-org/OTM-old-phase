<!-- !-- This file Only PHP Functions  -->
<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

?>
<style>
    table {
        border-collapse: collapse;
        /* Ensures borders don't have spacing between cells */
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        /* Adds border around table cells */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        /* Light background for table headers */
    }

    .text_po {
        text-align-last: center;
    }
</style>
<!-- datatable start -->
<!-- <link rel="stylesheet" type="text/css" href="../../assets/datatable_new/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/buttons.dataTables.css" />

<script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
<script src="../../assets/datatable_new/jquery.dataTables.js"></script>
<script src="../../assets/datatable_new/dataTables.buttons.js"></script>
<script src="../../assets/datatable_new/jszip.min.js"></script>
<script src="../../assets/datatable_new/buttons.html5.min.js"></script>
<script src="../../assets/datatable_new/buttons.print.min.js"></script>
<script src="../../assets/datatable_new/pdfmake.min.js"></script> -->

<h2 class="text_po">Material Unavailable</h2>
<form class="was-validated" autocomplete="off">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                    id="ins_pen">
                    <thead class="table-light">
                        <tr>

                            <th>S.No</th>
                            <th>PO Number </th>
                            <th>PO Date </th>

                            <th>Department</th>
                            <th>Executive Name
                            </th>
                            <th>No of Consignee
                            </th>
                            <th>No of Items in PO
                            </th>
                            <th>Qty
                            </th>
                            <th>Total Value
                            </th>
                            <th>PO Attachment
                            </th>
                            <th> Delivery Due Date</th>
                            <th>Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //  `po`.`file_name` <> ''
                        $table_1 = 'view_po_dashboard_count';
                        $columns_1 = [

                            "'' AS s_no",
                            "po_num",
                            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                            "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_po_dashboard_count.department) AS department",
                            "(SELECT executive_name FROM executive_name WHERE executive_name.unique_id = view_po_dashboard_count.executive_name) AS executive_name",
                            "no_of_consignee",
                            "no_of_po",
                            "qty",
                            "net_value",
                            "file_name",
                            "delivery_due_dates",
                            "status",
                            "unique_id",
                            "(SELECT stock_qty 
                                FROM stock_position_main 
                                WHERE form_main_unique_id = view_po_dashboard_count.unique_id 
                                AND is_delete = 0 
                                GROUP BY form_main_unique_id) AS stock_qty",
                            "product_due_days",
                        ];

                        $table_details1 = [
                            $table_1,
                            $columns_1
                        ];
                        $where1 = "file_name!='' AND status='0'";
                        // print_r(  $where1);
                        $result1 = $pdo->select($table_details1, $where1);
                        // print_r($result1);die();
                        if ($result1->status) {
                            $res_array1 = $result1->data;
                            // print_r($result1->data);
                            foreach ($res_array1 as $key => $value) {
                                // $dc_required = $value['dc_required']; 
                                // - $value['product_count'];
                                $value['s_no'] = $sno + 1;
                                $file_name = $value['file_name'];
                                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);
                                $delivery_due_days = $value['delivery_due_dates'];

                                if ($delivery_due_days != "") {
                                    $delivery_due_dates = $value['delivery_due_dates'];
                                } else {
                                    $delivery_due_dates = $value['product_due_days'];
                                }
                                // print_r(  $delivery_due_dates);
                                // Format PO date
                                $po_date = $value['po_date']; // Expected format: '2024-12-31'
                                $formatted_po_date = date("d-m-Y", strtotime($po_date)); // Convert to 'd-m-Y'
                                $value['po_date'] = '<span class="po_date">' . $formatted_po_date . '</span>';

                                // Create DateTime object from the formatted PO date
                                $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($formatted_po_date));

                                if ($poDate === false) {
                                    echo "Invalid PO date format.";
                                    return;
                                }

                                // Modify PO date based on delivery due dates
                                $poDate->modify('+' . (int) $delivery_due_dates . ' days');
                                $resultDate = $poDate->format('d-m-Y');

                                $currentDate = new DateTime();

                                if ($poDate < $currentDate) {
                                    $value['delivery_due_dates'] = "<span class='d_date' style='color: red;'>$resultDate</span>";
                                } else {
                                    $value['delivery_due_dates'] = "<span class='d_date' style='color: green;'>$resultDate</span>";
                                }

                                $qty = $value['qty'];
                                $stok_qty = $value['stock_qty'];
                                if ($value['status'] == "0") {
                                    $value['status'] = "<span style='color: red;'>Pending</span>";
                                }

                                // else if($value['remaing_qty']!=$value['stock_qty']){
                                //     $value['status']   = "Partial Pending";
                                // }
                                // else if($value['qty']==$value['stock_qty']){
                                //     $value['status']   = "Partial Pending";
                                // }
                                else if ($value['status'] == "1") {
                                    $value['status'] = "<span style='color: red;'>Partial Pending</span>";

                                } else {
                                    $value['status'] = "<span style='color: red;'>Complete</span>";
                                    // $value['status']   = "Complete";
                                }

                                ?>
                                <tr>

                                    <td id="table_td"><?php echo $value['s_no']; ?></td>
                                    <td id="table_td"><?php echo $value['po_num']; ?></td>
                                    <td id="table_td"><?php echo $value['po_date']; ?></td>
                                    <td id="table_td"><?php echo $value['department']; ?></td>
                                    <td id="table_td"><?php echo $value['executive_name']; ?></td>
                                    <td id="table_td"><?php echo $value['no_of_consignee']; ?></td>
                                    <td id="table_td"><?php echo $value['no_of_po']; ?></td>
                                    <td id="table_td"><?php echo $value['qty']; ?></td>

                                    <td id="table_td"><?php echo $value['net_value']; ?></td>
                                    <td id="table_td"><?php echo $value['file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['delivery_due_dates']; ?></td>

                                    <td id="table_td"><?php echo $value['status']; ?></td>





                                </tr>
                                <?php
                                $sno++;
                            }
                        }


                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>


</div>
</div>
</div>
</div>

<?php

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
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_2(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}
?>
<script>
    $(document).ready(function () {


    });
    function print_pdf_1(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_2(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
<script>
    new DataTable('#ins_pen', {
        layout: {
            top1: 'searchBuilder'
        }
    });
</script>


















<!-- !-- This file Only PHP Functions  -->
<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

?>
<style>
    table {
        font-family: 'Poppins', sans-serif;
        border-collapse: collapse;
        /* Ensures borders don't have spacing between cells */
        width: 100%;
    }

    .table>thead {
        background: #eeece0;
        color: #506018;
    }

    th,
    td {
        font-family: 'Poppins', sans-serif;
        border: 0;
        /* Adds border around table cells */
        padding: 8px;
        text-align: left;
        font-size: 13px;
    }

    th {
        font-family: 'Poppins', sans-serif;
        background-color: #eeece0 !important;
        color: #506018 !important;
        /* Light background for table headers */
    }

    .th_bg {
        background-color: #f9fbf0
    }

    .text_po {
        color: #506018;
        text-align-last: center;
        font-size: x-large;
        padding-top: 7px;
        font-weight: 700;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: white;
    }

    table tbody tr:nth-child(even) {
        background-color: #fbfbfb;
    }

    th,
    td {
        padding: 5px !important;
    }
</style>
<!-- datatable start -->
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/buttons.dataTables.css" />

<script src="  assets/datatable_new/jquery-3.7.0.min.js"></script>
<!-- <script src="../../assets/datatable_new/jquery.dataTables.js"></script>
<script src="../../assets/datatable_new/dataTables.buttons.js"></script> -->
<script src="assets/datatable_new/jszip.min.js"></script>
<script src="assets/datatable_new/buttons.html5.min.js"></script>
<script src="assets/datatable_new/buttons.print.min.js"></script>
<script src="assets/datatable_new/pdfmake.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

<body class="mt-4" style="background-color: white;">
    <div>
        <h2 class="text_po">Material Unavailable</h2>
    </div>
    <form class="was-validated" autocomplete="off">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                            id="ins_pen">
                            <thead class="table-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>PO Date</th>
                                    <th>PO Number</th>
                                    <!-- <th>Customer</th> -->
                                    <th style="width: 500px;">Customer</th>
                                    <th style="text-align: right;">Qty</th>
                                    <th style="text-align: right;">Total Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $table_po = "view_po_form_list";
                                $acc_year = $_GET['acc_year'] ?? ''; // or from request()
                                
                                $columns = [
                                    "'' as s_no",
                                    'po_num',
                                    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                                    "department",
                                    "(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 GROUP BY dis.form_main_unique_id) AS total_value",
                                    "(SELECT SUM(qty) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 GROUP BY dis.form_main_unique_id) AS qty",
                                    'unique_id',
                                    'bill_address',
                                    'gst_value'
                                ];

                                $table_details = [$table_po, $columns];
                                $where = "is_delete = '0' AND file_name != ''";

                                if (!empty($acc_year)) {
                                    $where .= " AND acc_year = '$acc_year'";
                                }

                                $order_column = $_POST['order'][0]['column'] ?? 0;
                                $order_dir = $_POST['order'][0]['dir'] ?? 'desc';
                                $order_by = "unique_id $order_dir";

                                // $limit = $_POST['length'] ?? 10;
                                $start = $_POST['start'] ?? 0;

                                $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');
                                $sno = $start + 1;
                                if ($result->status) {
                                    foreach ($result->data as $value) {
                                        $po_num = $value['po_num'] ?? '-';
                                        $po_date = $value['po_date'] ?? '-';
                                        $department = $value['department'] ?? '-';
                                        $qty = $value['qty'] ?? 0;
                                        $total_value = $value['total_value'] ?? 0;
                                        $bill_address = $value['bill_address'] ?? 0;
                                        $gst_value = $value['gst_value'] ?? 0;
                                        $total_value_formatted = moneyFormatIndia1($total_value);
                                        $total += $total_value;
                                        ?>

                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $po_date; ?></td>
                                            <td><?php echo $po_num; ?></td>
                                            <!-- <td> <b><?php echo $department; ?> </b></br>(<?php echo $gst_value; ?>)</td> -->
                                            <td>
                                                <b><?php echo $department; ?></b>&nbsp;-&nbsp;<?php echo $bill_address; ?>
                                                <?php if (!empty($gst_value)): ?>
                                                    <br>(<?php echo $gst_value; ?>)
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: right;"><?php echo $qty; ?></td>
                                            <td style="text-align: right;"><?php echo $total_value_formatted; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    // Show total row
                                    ?>
                                    <tr style="border-top: 2px solid #506018;background-color: #506018;font-size: 20px;">
                                        <td colspan="5" style="text-align: right; color:white; font-size: 20px;">
                                            <strong>Total</strong></td>
                                        <td style="text-align: right; color:white; font-size: 20px;">
                                            <strong><?php echo moneyFormatIndia1($total); ?></strong></td>
                                    </tr>
                                    <?php
                                } else {
                                    echo '<tr><td colspan="6" class="text-center text-muted">No records found</td></tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        new DataTable('#ins_pen', {
            layout: {
                top1: 'searchBuilder'
            }
        });
    </script>
</body>
