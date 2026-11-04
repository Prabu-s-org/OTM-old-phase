<?php
// include 'db_connection.php'; // Your DB connection
// Get folder name from current URL
$folder_name = basename(dirname($_SERVER['PHP_SELF']));

// Include DB config and functions
include '../../config/dbconfig.php';
include 'function.php';
  $po_id = $_GET['po_id'];

  $ponumber_val = po_numers_pop($po_id);

$po_number = $ponumber_val[0]['po_num'];

$cus_name = $ponumber_val[0]['department'];


// Parameters
$table_po = "consignee_details_sub";
// $acc_year = $_GET['acc_year'] ?? '';


// if($acc_year != ''){
//  $acc_cond_chk = " AND b.acc_year = '$acc_year'
//       AND pf2.acc_year = '$acc_year'";
// }
$columns = [
    "'' as s_no",
    'con_address',
    "get_state_name(con_state_name) as con_state_name",
    "get_district_name(con_district) as con_district",
    "zone",
    "zone_code",
     "con_branch",
    "con_contact_name",
    "con_contact_number",
    "(Select staff_name from user where user.staff_id = consignee_details_sub.assign_team_member and user.is_delete = 0) as assign_team_member",
    "(select po_num from po_form where po_form.unique_id = consignee_details_sub.form_main_unique_id and po_form.is_delete = 0) as po_number",
    // "department",
    // "total_amount AS total_value",
    // "total_qty AS qty",
//     "(
//     SELECT COUNT(b.unique_id)
//     FROM consignee_details_sub AS b
//     INNER JOIN view_po_form_list AS pf2
//       ON b.form_main_unique_id = pf2.unique_id
//     WHERE b.is_delete = 0 AND b.cons_verify_sts = 1 AND pf2.is_delete = 0 
//       AND pf2.type_of_po = 1 $acc_cond_chk
//   ) AS tot_verify_address",
// "(
//         SELECT COUNT(b.unique_id)
//         FROM consignee_details_sub AS b
//         WHERE b.is_delete = 0 
//           AND b.form_main_unique_id = view_po_form_list .unique_id
//     ) AS tot_verify_address",
    'unique_id',
    // 'bill_address',
    // 'gst_value'
];

$table_details = [$table_po, $columns];
$where = "is_delete = '0' and form_main_unique_id = '$po_id'";

if (!empty($acc_year)) {
    $where .= " AND acc_year = '$acc_year'";
}



// Pagination params from DataTables
$limit = null;
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'ASC';
$order_by = "po_date $order_dir";
$order_bys = "po_date ASC";
// Query
$result = $pdo->select($table_details, $where, $limit, $start, '', 'SQL_CALC_FOUND_ROWS');
// print_r($result);
// Totals
$total = 0;
$total_qty = 0;
$sno = $start + 1;

if ($result->status): ?>
    <h6 class="text-center">PO No : <?php echo $po_number;?> - <b><?php echo $cus_name;?></b></h6>


    <table class="table table-striped table-bordered align-middle table-nowrap" id="consignee_address_table">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Consignee Address</th>
                <th>State</th>
                <th>District</th>
                <th>Zone</th>
                <th>Zone Code</th>
                <th>Branch</th>
                <th>Contact Name</th>
                <th>Contact Number</th>
                <th>Assign Team Member</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result->data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($sno++) ?></td>
                    <td><?= htmlspecialchars($row['con_address']) ?></td>
                    <td><?= htmlspecialchars($row['con_state_name']) ?></td>
                    <td><?= htmlspecialchars($row['con_district']) ?></td>
                    <td><?= htmlspecialchars($row['zone']) ?></td>
                    <td><?= htmlspecialchars($row['zone_code']) ?></td>
                    <td><?= htmlspecialchars($row['con_branch']) ?></td>
                    <td><?= htmlspecialchars($row['con_contact_name']) ?></td>
                    <td><?= htmlspecialchars($row['con_contact_number']) ?></td>
                    <td><?= htmlspecialchars($row['assign_team_member']) ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="text-center text-muted">No verified consignee addresses found.</div>
<?php endif;?>
<!-- <script>
    $(document).ready(function() {

        new DataTable('#consignee_address_table', {
            layout: {
                topStart: {
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            }
        });
       

    });
</script> -->
