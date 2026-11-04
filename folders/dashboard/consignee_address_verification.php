<?php
// Get folder name from current URL
$folder_name = basename(dirname($_SERVER['PHP_SELF']));

// Include DB config and functions
include '../../config/dbconfig.php';
include 'function.php';

// Parameters
$table_po = "view_po_form_list";
$acc_year = $_GET['acc_year'] ?? '';

  $cons_verify_status = $_GET['cons_verify_status'] ?? '';

// Condition for acc_year if provided
$acc_cond_chk = '';
if ($acc_year !== '') {
    $acc_cond_chk = " AND b.acc_year = '$acc_year' AND pf2.acc_year = '$acc_year'";
}

$cons_verify_status_cond = '';

if ($cons_verify_status !== '') {
    if ($cons_verify_status === '0') {
        $cons_verify_status_cond = " AND (b.cons_verify_sts != 1 )";
    } elseif ($cons_verify_status === '1') {
        $cons_verify_status_cond = " AND b.cons_verify_sts = '1'";
    } else {
        $cons_verify_status_cond = " AND b.cons_verify_sts = '$cons_verify_status'";
    }
}


// b.cons_verify_sts = 0 OR b.cons_verify_sts IS NULL OR b.cons_verify_sts = ''

$columns = [

    "'' as s_no",
    'po_num',
    "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
    "department",
    "(
        SELECT COUNT(b.unique_id)
        FROM consignee_details_sub AS b
        WHERE b.is_delete = 0 
          AND b.form_main_unique_id = view_po_form_list.unique_id  $cons_verify_status_cond
    ) AS tot_verify_address",
    'unique_id',
    'bill_address',
    'gst_value'
];

$table_details = [$table_po, $columns];

$where = "is_delete = '0' AND type_of_po = 1";
if ($acc_year !== '') {
    $where .= " AND acc_year = '$acc_year'";
}
// if ($cons_verify_status !== '' || $cons_verify_status !== '0') {
//     $where .= " AND EXISTS (
//         SELECT 1 FROM consignee_details_sub AS b 
//         WHERE b.form_main_unique_id = view_po_form_list.unique_id 
//           AND b.is_delete = 0 
//           AND b.cons_verify_sts = '$cons_verify_status'
//     )";
// }
// if ($cons_verify_status !== '' || $cons_verify_status !== '1') {
//     $where .= " AND EXISTS (
//         SELECT 1 FROM consignee_details_sub AS b 
//         WHERE b.form_main_unique_id = view_po_form_list.unique_id 
//           AND b.is_delete = 0 
//           AND b.cons_verify_sts = '$cons_verify_status' OR b.cons_verify_sts IS NULL 
//     )";
// }

if ($cons_verify_status !== '') {
    if ($cons_verify_status == '0') {
        $where .= " AND EXISTS (
            SELECT 1 FROM consignee_details_sub AS b 
            WHERE b.form_main_unique_id = view_po_form_list.unique_id 
              AND b.is_delete = 0 
              AND (b.cons_verify_sts != 1)
        )";

    } elseif ($cons_verify_status == '1') {
        $where .= " AND EXISTS (
            SELECT 1 FROM consignee_details_sub AS b 
            WHERE b.form_main_unique_id = view_po_form_list.unique_id 
              AND b.is_delete = 0 
              AND b.cons_verify_sts = '1'
        )";
    } else {
        $where .= " AND EXISTS (
            SELECT 1 FROM consignee_details_sub AS b 
            WHERE b.form_main_unique_id = view_po_form_list.unique_id 
              AND b.is_delete = 0 
              AND (b.cons_verify_sts = 0 OR b.cons_verify_sts IS NULL OR b.cons_verify_sts = '')
        )";
    }
}


// Pagination params (if needed)
$limit = null;
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'ASC';
$order_bys = "po_date ASC";

// Query the database
$result = $pdo->select($table_details, $where, $limit, $start, $order_bys, 'SQL_CALC_FOUND_ROWS');
// print_r($result);   
$total_qty = 0;
$sno = $start + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Total Purchase Order</title>

<!-- Fonts and CSS -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.min.css" /> -->

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ DataTables 2.x + Buttons 3.x -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: white;
        font-size: 0.875rem;
    }

    .text_po {
        color: #506018;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    th {
       color:  #506018 !important;
    }
    
    table thead {
        background: #f7f7f7ff;
        color: #506018;
    } 
    table tbody tr:nth-child(even) {
        background-color: #fbfbfb;
    }
    .text-center {
        text-align: center;
    }


    /* Customizing the search box position */
/* .dataTables_filter {
    position: absolute;
    top: 0;
    right: 0;
    padding: 10px;
} */

</style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text_po">Total Purchase Order</h2>
    
    <!-- Table Wrapper with DataTable functionality -->
    <div class="table-responsive">
        <!-- table table-bordered table-nowrap align-middle mb-0 com-tex -->
        <table id="ins_pen" class="table table-striped table-bordered align-middle table-nowrap display" style="width:100%">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>PO Date</th>
                    <th>PO Number</th>
                    <th style="width: 500px;">Customer</th>
                    <th class="text-center">Consignee Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->status && !empty($result->data)): ?>
                    <?php foreach ($result->data as $row): 
                        $po_num = htmlspecialchars($row['po_num'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $po_date = htmlspecialchars($row['po_date'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $department = htmlspecialchars($row['department'] ?? '-', ENT_QUOTES, 'UTF-8');
                        $bill_address = htmlspecialchars($row['bill_address'] ?? '', ENT_QUOTES, 'UTF-8');
                        $gst_value = htmlspecialchars($row['gst_value'] ?? '', ENT_QUOTES, 'UTF-8');
                        $tot_verify_address = (int)($row['tot_verify_address'] ?? 0);
                        $unique_id = $row['unique_id'];
                        $total_qty += $tot_verify_address;
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
                        <td class="text-center">
                            <a href="javascript:void(0);" class="view-consignees" data-po-id="<?= $unique_id; ?>" data-po-no="<?= $po_num; ?>" data-po-cus="<?= $department; ?>">
                                <?= $tot_verify_address; ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                     <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No records found</td>
                    </tr>
                <?php endif; ?>

                    <!-- Totals Row -->

                    <?php  if($result->status && !empty($result->data)): ?>

                    <tfoot>
                <tr style="background-color: #506018; color: white; font-weight: bold;">
                    <td colspan="4" class="text-end">Total</td>
                    <td class="text-center"><?= $total_qty; ?></td>
                </tr>
                </tfoot>
                    <?php endif; ?>
               
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="consigneeModal" tabindex="-1" aria-labelledby="consigneeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content gsg">
      <div class="modal-header">
        <h5 class="modal-title" id="consigneeModalLabel">Consignee Addresses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="consigneeModalBody">
        <div class="text-center">Loading...</div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->



<script>

$(document).ready(function () {


    // alert('test');
$('#ins_pen').DataTable({

    dom:
        "<'d-flex justify-content-between align-items-center mb-2'<'dt-length'l><'dt-search'f>>" +
        "<'table-responsive'tr>" +
        "<'d-flex justify-content-between align-items-center mt-2'<'dt-info'i><'dt-pagination'p>>",
    buttons:[],
     paging: true,
    searching:true,
     ordering: true,
        info: true,
    // order:[1,'desc'],

});

    // $('#ins_pen').DataTable({
    //     paging: false,
    //     ordering: false,
    //     info: true,
    //     searching: true,
    //     columns: [
    //         null,
    //         null,
    //         null,
    //         null,
    //         { className: "text-center" }
    //     ]
    // });

    // Click event for consignee address link

    $(document).on('click','.view-consignees',function() {

   
        const poId = $(this).data('po-id');
        const poNo = $(this).data('po-no');
        const cusName = $(this).data('po-cus');
        const modalBody = $('#consigneeModalBody');

        modalBody.html('<div class="text-center">Loading...</div>');
        const consigneeModal = new bootstrap.Modal(document.getElementById('consigneeModal'));
        consigneeModal.show();

        // Fetch consignee data via AJAX
        fetch('get_consignees.php?po_id=' + poId)
            .then(response => response.text())
            .then(data => {
                modalBody.html(data);

                // Initialize DataTable inside modal if table present
                if ($.fn.DataTable.isDataTable('#consignee_address_table')) {
                    $('#consignee_address_table').DataTable().destroy();
                }
                $('#consignee_address_table').DataTable({
                    ordering: true,
                    paging: true,
                    searching: true,
                    info: true,
                    lengthChange: true,
                    dom: "<'d-flex justify-content-between align-items-center mb-2'<'dt-buttons'B><'dt-search'f>>" +
                         "<'table-responsive'tr>" +
                         "<'d-flex justify-content-between align-items-center mt-2'<'dt-info'i><'dt-pagination'p>>",
                    buttons: [
                        'copy',
                        {
                            extend: 'excelHtml5',
                            title: '',
                            filename: `PO_${poNo} - ${cusName}`
                        },
                        'colvis'
                    ],
                });
            })
            .catch(() => {
                modalBody.html('<div class="text-danger">Failed to load data.</div>');
            });
    });
});
</script>

</body>
</html>

