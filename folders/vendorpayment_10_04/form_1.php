
<?php include 'function.php'; ?>

<style>
body {
    font-family: Arial, sans-serif;
    color: #000;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.header div {
    width: 48%;
}

.invoice-box {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed; /* Ensures table width is fixed and does not change based on content */
}

.invoice-box th,
.invoice-box td {
    border: 1px solid #000;
    padding: 6px 8px;
    vertical-align: middle;
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: visible; /* Allow content to overflow if necessary */
    text-overflow: clip; /* Ensure the text is not cut off */
    font-size: 13px;
}

/* Adjust for the amount columns to have more space */
.invoice-box td:nth-child(5), /* Basic Amount */
.invoice-box td:nth-child(6), /* GST % */
.invoice-box td:nth-child(7), /* GST Amount */
.invoice-box td:nth-child(8) { /* Total */
    text-align: right;
    white-space: normal; /* Allow wrapping of content */
    overflow: visible; /* Ensure full content is visible */
}

.invoice-box th:nth-child(5), /* Basic Amount */
.invoice-box th:nth-child(6), /* GST % */
.invoice-box th:nth-child(7), /* GST Amount */
.invoice-box th:nth-child(8) { /* Total */
    text-align: right;
    white-space: normal; /* Allow header text to wrap */
}

/* Ensure proper alignment and visibility for large amounts */
.invoice-box td:nth-child(5), 
.invoice-box td:nth-child(6), 
.invoice-box td:nth-child(7), 
.invoice-box td:nth-child(8) {
    max-width: 200px; /* Limit width for large numbers */
    word-wrap: break-word; /* Allow word wrapping */
}

.invoice-box th {
    background-color: #f2f2f2;
    text-align: center;
}

.invoice-box td:nth-child(2),
.invoice-box th:nth-child(2) {
    text-align: left;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.bill-to,
.account-details {
    margin-top: 30px;
    font-size: 14px;
}

tfoot tr {
    border-top: 2px solid #000;
    font-weight: bold;
    background-color: #f9f9f9;
}

.header-right table {
    width: auto;
    margin-left: auto;
    font-size: 14px;
    white-space: nowrap;
}

.header-right td {
    padding: 2px 4px;
    vertical-align: top;
}

@media print {
    #printhide {
        display: none !important;
    }
    .signature-section {
        display: block;
    }
}

.signature-section {
    margin-top: 40px;
    text-align: right; /* Align text to the right */
    font-size: 16px;
    padding-top: 20px;
    padding-bottom: 20px;
}

.signature-text {
    font-size: 14px;
    margin-top: 5px;
}

/* Align numeric columns (Qty, Unit Price, Basic Amount, GST %, GST Amount, Total) to right */
.invoice-box td:nth-child(3),
.invoice-box td:nth-child(4),
.invoice-box td:nth-child(5),
.invoice-box td:nth-child(6),
.invoice-box td:nth-child(7),
.invoice-box td:nth-child(8),
.invoice-box th:nth-child(3),
.invoice-box th:nth-child(4),
.invoice-box th:nth-child(5),
.invoice-box th:nth-child(6),
.invoice-box th:nth-child(7),
.invoice-box th:nth-child(8) {
    text-align: right;
}

/* Ensure the text stays on one line and does not overflow */
.invoice-box td {
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

.invoice-box td:nth-child(2),
.invoice-box th:nth-child(2) {
    white-space: normal !important;
    overflow: visible !important;
    word-break: break-word !important;
}



</style>
<!-- start page title -->
  <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Print Invoice</h4>
            <!-- <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>"> -->

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                     <li class="breadcrumb-item active">Invoice</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>

<?php
if (isset($_GET["unique_id"]) && !empty($_GET["unique_id"])) {
    $unique_id = $_GET["unique_id"];
    $dc_number = $_GET["dc_number"];
    $unique_ids_array = explode(",", $unique_id);

    // Remove duplicate unique IDs
    $unique_ids_array = array_unique($unique_ids_array);

    // Convert array back to string for SQL
    $unique_ids_string = "'" . implode("','", $unique_ids_array) . "'";

    $where = "unique_id IN ($unique_ids_string)";

    // $where = "unique_id = '" . $unique_id . "'";
    $table_vendorallocation = 'vendor_creation';
    $columns = [
        "name", "contact_no", "mail_id", "pan_no", "gst_no", "address", "account_no",
        "ifsc_code", "bank_name", "branch_name", "acc_holder_name", "pan_attach_file_name", "bank_proof", "unique_id"
    ];

    $table_details = [$table_vendorallocation, $columns];
    $result_values = $pdo->select($table_details, $where);
// print_r($result_values);
    if ($result_values->status) {
        $result_values = $result_values->data[0];

        $name = $result_values["name"];
        $contact_no = $result_values["contact_no"];
        $mail_id = $result_values["mail_id"];
        $pan_no = $result_values["pan_no"];
        $gst_no = $result_values["gst_no"];
        $address = $result_values["address"];
        $account_no = $result_values["account_no"];
        $ifsc_code = $result_values["ifsc_code"];
        $bank_name = $result_values["bank_name"];
    }
}

// Generate Invoice Number
$session_id = $_SESSION['user_type_unique_id'];
$state_code = 'INV';
$newVendorId = vendor_generate_invoiceid($state_code);
?>

<script>
function printInvoice() {
    const downloadBtn = document.querySelector('button.btn.btn-primary');
    downloadBtn.style.display = 'none';
    window.print();
    downloadBtn.style.display = 'inline-block';
}
</script>


  <!-- end page title -->
  
  <!----content start---------->
  <div class="row">
 
    <div class="col-12">
        <div class="card mt-4">
            <div class="card-body">
   
<div style="text-align: right; margin-bottom: 10px;" id="printhide">
    <button onclick="printInvoice()" class="btn btn-primary">Download Invoice</button>
</div>
                <div class="text-center mb-3">
                    <h2 class="mb-0">Invoice</h2>
                </div>

                <div class="header">
                    <div>
                        <div><strong><?php echo $name ?>,</strong></div>
                        <div><?php echo $address ?>,</div>
                        <div><strong>GST NO:</strong> <?php echo $gst_no ?>.</div>
                        <div><?php echo $contact_no ?></div>
                        <div><strong>PAN NO:</strong> <?php echo $pan_no ?></div>
                    </div>

                    <div class="header-right">
                        <table>
                            <tr>
                                <td><strong>DATE</strong></td>
                                <td>:</td>
                                <td><?php echo date('d-m-Y'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>INVOICE NO</strong></td>
                                <td>:</td>
                                <td><?php echo $newVendorId; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="bill-to">
                    <strong>BILL TO,</strong><br>
                    Ascent e-Digit solutions Pvt Ltd.,<br>
                    176/1, Indu Nagar, Perundurai Road,<br>
                    Thindal Post,<br>
                    Erode-638012, Tamil Nadu<br>
                    <strong>GSTIN:</strong> 33AAJCA0977A1Z2
                </div>

                <table class="invoice-box">
                    <thead>
                        <tr>
                            <th>S NO</th>
                            <th>Description</th>
                            <th>Qty</th>
                             <th>Unit Price</th>
                            <th>Basic Amount</th>
                            <th>GST %</th>
                            <th>GST Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dc_numbers = explode(',', $_GET["dc_number"]);
                        $quoted_dc_numbers = array_map(function($dc) {
                            return "'" . trim($dc) . "'";
                        }, $dc_numbers);

                        $engineers = explode(',', $_GET["unique_id"]);
$quoted_engineers = array_map(function($eng) {
    return "'" . trim($eng) . "'";
}, $engineers);
                        $where1 = "engineer_name IN (" . implode(',', $quoted_engineers) . ")  AND dc_number IN (" . implode(',', $quoted_dc_numbers) . ")";
                        $table1 = "invoice_verfication_table";
                        $columns1 = [
                            "po_num", "form_main_unique_id", "get_ledger_name(ledger_name) AS engineer_name", "invoice_no",
                            "dc_number", "dc_date", "invoice_qty", "vendor_bulk_rate", "bulk_total_amount", "vendor_bulk_gst",
                        ];
                        $table_details1 = [$table1, $columns1];
                        $values_product = $pdo->select($table_details1, $where1);
// print_r($values_product);
                        $invoice_qty = 0;
                        $sum_unit_price = 0;
                        $sum_total_amount = 0;
                        $sno = 1;

                        if ($values_product->status) {
                            $product_array = $values_product->data;

                            // Group by engineer + unit price
                            $grouped = [];
                            foreach ($product_array as $product) {
                                $engineer = $product['engineer_name'];
                                $unit_price = $product['vendor_bulk_rate'];

                                if (!isset($grouped[$engineer])) $grouped[$engineer] = [];
                                if (!isset($grouped[$engineer][$unit_price])) {
                                    $grouped[$engineer][$unit_price] = [
                                        'dc_numbers' => [],
                                        'invoice_qty' => 0,
                                        'vendor_bulk_rate' => $unit_price,
                                        'bulk_total_amount' => 0,
                                        'vendor_bulk_gst' => $product['vendor_bulk_gst'],
                                    ];
                                }

                                $grouped[$engineer][$unit_price]['dc_numbers'][] = $product['dc_number'];
                                $grouped[$engineer][$unit_price]['invoice_qty'] += (float)$product['invoice_qty'];
                                $grouped[$engineer][$unit_price]['bulk_total_amount'] += (float)$product['bulk_total_amount'];
                            }

                            // Display rows
                            foreach ($grouped as $engineer => $rates) {
                                foreach ($rates as $rate => $data) {
                                    $invoice_qty += $data['invoice_qty'];
                                    $sum_unit_price += $data['vendor_bulk_rate'];
                                    $sum_total_amount += $data['bulk_total_amount'];

                                     $qty = (float)$data['invoice_qty'];
        $rate = (float)$data['vendor_bulk_rate'];
        $gst = (float)$data['vendor_bulk_gst'];

        $basic_amt = $qty * $rate;
        $gst_amt = ($basic_amt * $gst) / 100;
        $total_amt = $basic_amt + $gst_amt;
         $total_qty += $qty;
        $total_basic += $basic_amt;
        $total_gst_amount += $gst_amt;
        $total_final += $total_amt;

                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo $sno++; ?></td>
                                        <td class="text-left">
                                            <?php echo $engineer; ?><br>
                                            (<?php echo implode(', ', $data['dc_numbers']); ?>)
                                        </td>
                                        <td class="text-right"><?php echo $data['invoice_qty']; ?></td>
                                        <td class="text-right"><?php echo $data['vendor_bulk_rate']; ?></td>
            <td class="text-right"><?php echo number_format($basic_amt, 2); ?></td>

                                        <td class="text-right"><?php echo $data['vendor_bulk_gst'] . '%'; ?></td>
            <td class="text-right;"><?php echo number_format($gst_amt, 2); ?></td>

                                        <td class="text-right">₹<?php echo number_format($data['bulk_total_amount'], 2); ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>

                    <?php if (!empty($grouped)) { ?>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right">TOTAL:</td>
                            <td class="text-right"><?php echo $invoice_qty; ?></td>
                             <td></td>
                     <td class="text-right"><?php echo number_format(round($total_basic, 2)); ?></td>

                            <!-- <td class="text-right"><?php echo $sum_unit_price; ?></td> -->
                              <td></td>
                               <td class="text-right;"><?php echo number_format(round($total_gst_amount, 2)); ?></td>

                            <td class="text-right">₹<?php echo number_format(round($sum_total_amount, 2)); ?></td>
                        </tr>
                    </tfoot>
                    <?php } ?>
                </table>

                <div class="account-details">
                    <strong>ACCOUNT DETAILS:</strong><br>
                    <?php echo $bank_name; ?><br>
                    A/C NO: <?php echo $account_no; ?><br>
                    IFSC  : <?php echo $ifsc_code; ?>
                </div>
<div class="signature-section" id="signature-section">
    <div class="signature-text">
        <strong>Authorized Signature</strong>
    </div>
</div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

  </div>
  <!----content start---------->
  <script>
  $(document).ready(function() {
  $('.invoice-box td').each(function() {
    let val = $(this).text().trim();
    if ($.isNumeric(val)) {
      $(this).text(Math.round(parseFloat(val)));
    }
  });
});
</script>

