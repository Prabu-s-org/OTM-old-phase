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

<?php
$acc_year = $_GET['acc_year'];

function indian_format($amount)
{
    // Ensure it's a float and format with 2 decimal points
    $amount = number_format((float) $amount, 2, '.', '');

    // Split into whole and decimal parts
    list($whole, $decimal) = explode('.', $amount);

    // Format whole part in Indian format
    $len = strlen($whole);
    if ($len > 3) {
        $last3 = substr($whole, -3);
        $rest = substr($whole, 0, $len - 3);
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        $formatted = $rest . ',' . $last3;
    } else {
        $formatted = $whole;
    }

    return $formatted . '.' . $decimal;
}
?>

<body class="mt-4" style="background-color: white;">
    <div>
        <h2 class="text_po">Material Unavailable Partial</h2>
    </div>
    <form class="was-validated" autocomplete="off">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="table-responsive mb-4" style="margin:0 50 100 50">
                    <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                        id="ins_pen">
                        <thead class="table-light">
                            <tr>
                                <th style="text-align: center;">S.No</th>
                                <th style="text-align: center;width:200px;">PO Date </th>
                                <th style="text-align: center;width:250px;">PO Number </th>
                                <th style="text-align: center;">Customer Name</th>
                                <th style="text-align: center;width:200px;">Executive Name</th>
                                <!-- <th>No of Consignee</th>
                            <th>No of Items in PO</th> -->
                                <th style="text-align: center;width:100px;">Qty</th>
                                <th style="text-align: center;width:170px;">Total Value</th>
                                <!-- <th>PO Attachment</th>
                            <th> Delivery Due Date</th>
                            <th>Status</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            //  `po`.`file_name` <> ''
                            $table_1 = 'view_stock_position_list';
                            $columns_1 = [

                                "'' AS s_no",
                                "po_num",
                                "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                                "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_stock_position_list.department) AS department",
                                "(SELECT executive_name FROM executive_name WHERE executive_name.unique_id = view_stock_position_list.executive_name) AS executive_name",
                                "qty",
                                "net_value",
                                "bill_address"
                            ];

                            $table_details1 = [
                                $table_1,
                                $columns_1
                            ];
                            $where1 = "status='1'";
                            if ($acc_year) {
                                $where1 .= " AND acc_year = '" . $acc_year . "'";
                            }
                            // print_r(  $where1);
                            $result1 = $pdo->select($table_details1, $where1);
                            $total_amount = 0;
                            // print_r($result1);
                            if ($result1->status) {
                                $res_array1 = $result1->data;
                                // print_r($result1->data);
                                foreach ($res_array1 as $key => $value) {
                                    // $dc_required = $value['dc_required']; 
                                    // - $value['product_count'];
                                    $value['s_no'] = $sno + 1;

                                    ?>
                                    <tr>
                                        <td id="table_td"><?php echo $value['s_no']; ?></td>
                                        <td id="table_td"><?php echo $value['po_date']; ?></td>
                                        <td id="table_td"><?php echo $value['po_num']; ?></td>
                                        <!-- <td id="table_td"><?php echo $value['department']; ?></td> -->
                                        <td><b><?php echo $value['department']; ?></b>&nbsp;-&nbsp;<?php echo $value['bill_address']; ?></td>
                                        <td id="table_td"><?php echo $value['executive_name']; ?></td>
                                        <td style="text-align: center;" id="table_td"><?php echo $value['qty']; ?></td>
                                        <td style="text-align: right;font-weight:bold" id="table_td">
                                            <?php echo indian_format($value['net_value']); ?>
                                        </td>

                                    </tr>
                                    <?php
                                    $sno++;
                                    $total_amount += $value['net_value'];
                                } ?>
                                <tr style="border-top: 2px solid #506018;background-color: #506018;font-size: 20px;">
                                    <td colspan="6" style="text-align: right; color:white; font-size: 20px;">
                                        <strong>Total</strong>
                                    </td>
                                    <td style="text-align: right; color:white; font-size: 20px;">
                                        <strong><?php echo formatIndianNumber($total_amount); ?></strong>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
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
