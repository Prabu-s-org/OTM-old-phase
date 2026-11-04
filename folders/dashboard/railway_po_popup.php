<?php
// Get folder name from current URL
$folder_name = basename(dirname($_SERVER['PHP_SELF']));

// Include DB config and functions
include '../../config/dbconfig.php';
include 'function.php';

// Parameters
$table_po = "view_po_form_list";
$acc_year = $_GET['acc_year'] ?? '';

$columns = [
    "'' as s_no",
    'po_num',
    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
    "department",
    "total_amount AS total_value",
    "total_qty AS qty",
    'unique_id',
    'bill_address',
    'gst_value'
];

$table_details = [$table_po, $columns];
$where = "is_delete = '0' and type_of_po = 2";

if (!empty($acc_year)) {
    $where .= " AND acc_year = '$acc_year'";
}

// Pagination params from DataTables
$limit = null;
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'desc';
$order_by = "id $order_dir";

// Query
$result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');

// Totals
$total = 0;
$total_qty = 0;
$sno = $start + 1;
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/datatable_new/jquery.dataTables.css">
<link rel="stylesheet" href="../../assets/datatable_new/buttons.dataTables.css">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: white;
        font-size: 0.5rem !important;
    }
    .text_po {
        color: #506018;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    table thead {
        background: #eeece0;
        color: #506018;
    }
    table tbody tr:nth-child(even) {
        background-color: #fbfbfb;
    }
</style>

<div class="container mt-4">
    <h2 class="text_po">Total Purchase Order</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle table-nowrap" id="ins_pen">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>PO Date</th>
                    <th>PO Number</th>
                    <th style="width: 500px;">Customer</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Total Value</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->status): ?>
                    <?php foreach ($result->data as $row): ?>
                        <?php
                        $po_num = htmlspecialchars($row['po_num'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $po_date = htmlspecialchars($row['po_date'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $department = htmlspecialchars($row['department'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $bill_address = htmlspecialchars($row['bill_address'] ?? '', ENT_QUOTES, 'UTF-8');
                        $gst_value = htmlspecialchars($row['gst_value'] ?? '', ENT_QUOTES, 'UTF-8');
                        $qty = (int)($row['qty'] ?? 0);
                        $total_value = (float)($row['total_value'] ?? 0);
                        $total_value_formatted = moneyFormatIndia1($total_value);

                        $total += $total_value;
                        $total_qty += $qty;
                        ?>
                        <tr>
                            <td><?= $sno++; ?></td>
                            <td><?= $po_date; ?></td>
                            <td><?= $po_num; ?></td>
                            <td>
                                <b><?= $department; ?></b>
                                <?= $bill_address ? ' - ' . $bill_address : ''; ?>
                                <?= $gst_value ? "<br>($gst_value)" : ''; ?>
                            </td>
                            <td class="text-end"><?= $qty; ?></td>
                            <td class="text-end"><?= $total_value_formatted; ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Totals Row -->
                    <tr style="background-color: #506018; color: white; font-size: 1rem; font-weight: bold;">
                        <td style="color: white;" colspan="4" class="text-end">Total</td>
                        <td style="color: white;" class="text-end"><?= $total_qty; ?></td>
                        <td style="color: white;" class="text-end"><?= moneyFormatIndia1($total); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
<script src="../../assets/datatable_new/jquery.dataTables.min.js"></script>
<script src="../../assets/datatable_new/dataTables.buttons.min.js"></script>
<script src="../../assets/datatable_new/jszip.min.js"></script>
<script src="../../assets/datatable_new/pdfmake.min.js"></script>
<script src="../../assets/datatable_new/buttons.html5.min.js"></script>
<script src="../../assets/datatable_new/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    $('#ins_pen').DataTable({
        pageLength: 1000,
        lengthMenu: [1000, 2500, 50000, 100000],
        ordering: true,
        searching: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
