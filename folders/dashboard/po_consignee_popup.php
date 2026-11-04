<!-- !-- This file Only PHP Functions  -->
<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

try {
    // Database connection
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected sucessfully";
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed: " . $e->getMessage()]);
    exit;
}

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
        <h2 class="text_po">Total Purchase Stock</h2>
    </div>
    <form class="was-validated" autocomplete="off">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table" id="ins_pen">
                            <thead class="table-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>PO Date</th>
                                    <th>PO Number</th>
                                    <th style="width: 500px;">Customer</th>
                                    <th style="text-align: right;">Qty</th>
                                    <th style="text-align: right;">Total Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$table_po = "po_consignee_assign";

                                $acc_year = $_GET['acc_year'] ?? '';
                                
                                $status = $_GET['status'] ?? '';

                                $columns = [
                                    'form_main_unique_id',
                                    'total_invoice_qty',
                                    'invoice_qty_value',
                                    'df',
                                    'df_val'
                                ];
                                $table_details = [$table_po, $columns];

                                $where = "1";

                                if (!empty($acc_year)) {
                                    $where .= " AND acc_year = '$acc_year'";
                                }

                                if ($status == 1) {
                                    $where .= " AND df = 0 and stock_qty != 0 and total_invoice_qty != 0";
                                }

                                if ($status == 2 || $status == 3) {
                                    $where .= " AND stock_qty != 0 and total_invoice_qty != 0 and df != 0";
                                }

                                if ($status == 4) {
                                    $where .= "AND stock_qty != 0 and total_invoice_qty = 0 and df != 0";
                                }

                                $order_column = $_POST['order'][0]['column'] ?? 0;
                                $order_dir = $_POST['order'][0]['dir'] ?? 'desc';
                                $start = $_POST['start'] ?? 0;

                                $result = $pdo->select($table_details, $where, null, $start, '', 'SQL_CALC_FOUND_ROWS');
                                // print_r($result);
                                $sno = $start + 1;
                                $total = 0;
                                $total_qty = 0;
                                // print_r($result);
                                if ($result->status) {
                                    foreach ($result->data as $value) {
                                        $po_num = $value['form_main_unique_id'] ?? null;
                                        $total_invoice_qty = $value['total_invoice_qty'] ?? null;
                                        $invoice_qty_value = $value['invoice_qty_value'] ?? null;
                                        $df = $value['df'] ?? null;
                                        $df_val = $value['df_val'] ?? null;
                                        if (empty($po_num)) continue;
                                        $stmt = $conn->prepare("CALL get_po_details_by_number(:po_num)");
                                        $stmt->bindParam(':po_num', $po_num, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $sub_result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $stmt->closeCursor();
                                        if (!$sub_result) continue;
                                        $po_num_value = $sub_result['po_num'] ?? '-';
                                        $po_date = $sub_result['po_date'] ?? '-';
                                        $department = $sub_result['department'] ?? '-';
                                        $bill_address = $sub_result['bill_address'] ?? '';
                                        $gst_value = $sub_result['gst_value'] ?? '';

                                        if($status == 1){
                                            $qty = $sub_result['qty'] ?? 0;
                                            $total_value = $value['invoice_qty_value'] ?? 0;
                                        }

                                        if($status == 2){
                                            $qty = $value['total_invoice_qty'] ?? 0;
                                            $total_value = $value['invoice_qty_value'] ?? 0;
                                        }
                                        
                                        if($status == 3){
                                            $qty = $value['df'] ?? 0;
                                            $total_value = $value['df_val'] ?? 0;
                                        }

                                        if($status == 4){
                                            $qty = $value['df'] ?? 0;
                                            $total_value = $value['df_val'] ?? 0;
                                        }

                                        $total_qty += $qty;
                                        $total += $total_value;
                                        $total_value_formatted = moneyFormatIndia1($total_value);
                                        ?>
                                        <tr>
                                            <td><?php
echo $sno++; ?></td>
                                            <td><?php
echo $po_date; ?></td>
                                            <td><?php
echo $po_num_value; ?></td>
                                            <td>
                                                <b><?php
echo $department; ?></b>&nbsp;-&nbsp;<?php
echo $bill_address; ?>
                                                <?php
if (!empty($gst_value)): ?>
                                                    <br>(<?php
echo $gst_value; ?>)
                                                <?php
endif; ?>
                                            </td>
                                            <td style="text-align: right;"><?php
echo $qty; ?></td>
                                            <td style="text-align: right;"><?php
echo $total_value_formatted; ?></td>
                                        </tr>
                                        <?php
}
                                    ?>
                                    <tr style="border-top: 2px solid #506018;background-color: #506018;font-size: 20px;">
                                        <td colspan="4" style="text-align: right; color:white;"><strong>Total</strong></td>
                                        <td style="text-align: right; color:white;"><strong><?php
echo $total_qty; ?></strong></td>
                                        <td style="text-align: right; color:white;"><strong><?php
echo moneyFormatIndia1($total); ?></strong></td>
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




