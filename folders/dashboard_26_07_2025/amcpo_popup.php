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

<script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
<!-- <script src="../../assets/datatable_new/jquery.dataTables.js"></script>
<script src="../../assets/datatable_new/dataTables.buttons.js"></script> -->
<script src="../../assets/datatable_new/jszip.min.js"></script>
<script src="../../assets/datatable_new/buttons.html5.min.js"></script>
<script src="../../assets/datatable_new/buttons.print.min.js"></script>
<script src="../../assets/datatable_new/pdfmake.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

<body class="mt-4" style="background-color: white;">

    <div>
        <h2 class="text_po">Total Purchase Order</h2>
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
                                    <th style="width: 600px;">Customer</th>
                                    <th style="text-align: center;width:100px;">Qty</th>
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
                                    // "(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 GROUP BY dis.form_main_unique_id) AS total_value",
                                    "(SELECT SUM(amcvalue) FROM amcrequired AS dis WHERE dis.po_unique_id = $table_po.unique_id AND dis.is_delete = 0 GROUP BY dis.po_unique_id AND $table_po.amc_required = 'on') AS total_value",
                                    "(SELECT SUM(qty) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = $table_po.unique_id AND dis.is_delete = 0 GROUP BY dis.form_main_unique_id) AS qty",
                                    'unique_id',
                                    "gst_value",
                                    "bill_address"
                                ];

                                $table_details = [$table_po, $columns];
                                $where = "is_delete = '0' AND file_name != '' AND amc_required= 'on'";

                                if (!empty($acc_year)) {
                                    $where .= " AND acc_year = '$acc_year'";
                                }

                                $order_column = $_POST['order'][0]['column'] ?? 0;
                                $order_dir = $_POST['order'][0]['dir'] ?? 'desc';
                                $order_by = "unique_id $order_dir";

                                // $limit = $_POST['length'] ?? 10;
                                $start = $_POST['start'] ?? 0;

                                $result = $pdo->select($table_details, $where, $limit, $start, $order_by, 'SQL_CALC_FOUND_ROWS');
                                // print_r($result);
                                $sno = $start + 1;
                                if ($result->status) {
                                    foreach ($result->data as $value) {
                                        $po_num = $value['po_num'] ?? '-';
                                        $po_date = $value['po_date'] ?? '-';
                                        $department = $value['department'] ?? '-';
                                        $qty = $value['qty'] ?? 0;
                                        $total_value = $value['total_value'] ?? 0;
                                        $gst_value = $value['gst_value'] ?? 0;
                                        $bill_address = $value['bill_address'] ?? 0;
                                        $total_value_formatted = moneyFormatIndia1($total_value);
                                        $total += $total_value;

                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $po_date; ?></td>
                                            <td><?php echo $po_num; ?></td>
                                            <!-- <td> <b><?php echo $department; ?> </b></br>(33AAACI1607G2Z5)</td> -->
                                            <td>
                                                <b><?php echo $department; ?></b>&nbsp;-&nbsp;<?php echo $bill_address; ?>
                                                <?php if (!empty($gst_value)): ?>
                                                    <br>(<?php echo $gst_value; ?>)
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo $qty; ?></td>
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
    </form>
    </div>
    <script>
        new DataTable('#ins_pen', {
            layout: {
                top1: 'searchBuilder'
            }
        });
    </script>
</body>
