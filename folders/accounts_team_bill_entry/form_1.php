
<head>
    <title>Invoice</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }
        .header, .footer {
            display: flex;
            justify-content: space-between;
        }
        .invoice-box {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-box th, .invoice-box td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .invoice-box th {
            background-color: #f2f2f2;
        }
        .bill-to, .account-details {
            margin-top: 30px;
        }
        .bold {
            font-weight: bold;
        }
      /* .align { text-align: left; } */
       /* .align {
    white-space: nowrap;
} */
    /* .text-right { text-align: right; }
    .text-center { text-align: center; } */
.invoice-box {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.invoice-box th, .invoice-box td {
    border: 1px solid #000;
    padding: 8px;
}
.invoice-box td.text-left {
    /* background-color: #f2f2f2;  */
    /* optional */
    text-align: left;          /* align text to left */
}

.invoice-box td.text-right {
    text-align: right;         /* align text to right */
}

.invoice-box td.text-center {
    text-align: center;        /* align text to center */
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

    </style>
</head>
<body>
    <?php
    // print_r("hi");die();
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

         $unique_id = $_GET["unique_id"];
         
        // $where      = [
        //     "unique_id" => $_GET["unique_id"]
        // ];

        $where = "unique_id = '" . $_GET["unique_id"] . "'";

        // $table = "po_form";

        $table_vendorallocation = 'vendor_creation';

        $columns = [
           "name",
            "contact_no",
            "mail_id",
            "pan_no",
            "gst_no",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
            "acc_holder_name",
            "pan_attach_file_name",
              "bank_proof",
            // "pan_attach_file_org_name",
            // "bank_proof_org_name",
            "unique_id"
        ];

        $table_details = [
            $table_vendorallocation,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values = $result_values->data;
            $name = $result_values[0]["name"];

            $contact_no = $result_values[0]["contact_no"];
            $mail_id = $result_values[0]["mail_id"];
            $pan_no = $result_values[0]["pan_no"];
            $gst_no = $result_values[0]["gst_no"];
            $address = $result_values[0]["address"];
            $account_no = $result_values[0]["account_no"];

             $ifsc_code = $result_values[0]["ifsc_code"];
            $bank_name = $result_values[0]["bank_name"];
            $acc_holder_name = $result_values[0]["acc_holder_name"];
            $pan_attach_file_name = $result_values[0]["pan_attach_file_name"];
           

            // print_r($vendor_zone);die();/

            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$tax_select_status = "";

$insurence_required = "";
 $ld_required = "";
 $amc_required = "";
 $update_unique_id= "";
$is_active = 1;

// $_SESSION['user_type_unique_id'] == "65efd97b4df4040205";
// echo $_SESSION['user_type_unique_id'];
// echo $unique_id = $_GET["unique_id"];


$session_id = $_SESSION['user_type_unique_id'];
$state_code = 'INV'; // Example: dynamically assign based on logged-in user or form input
$newVendorId = vendor_generate_invoiceid($state_code);
 $dc_number = $_GET["dc_number"];
// print_r($newVendorId);
// Explode and sanitize

// print_r($dc_numbers_in);

?>

    <div class="header">
        <div>
            <div class="bold"><?php echo $name ?>,</div>
            <div><?php echo $address ?>,</div>
            <div><span>GST NO:</span><?php  echo $gst_no?>.</div>
            <div><?php echo $contact_no ?></div>
            <div><span>Pan No :</span><?php echo $pan_no ?></div>
        </div>
        <div style="text-align: right;">
            <div><strong>DATE:</strong> <?php echo date('d-m-Y'); ?></div>
            <div><strong>INVOICE NO:</strong> <?php echo $newVendorId ?></div>
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
            <th>GST</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody class="align">
        <?php
        

// $where1 = "engineer_name = " . $pdo->quote($unique_id) . " AND dc_number IN ($dc_number)";
       // Get dc_numbers from GET and explode into array
$dc_numbers = explode(',', $_GET["dc_number"]);
// print_r($dc_numbers);

// Trim each DC number and wrap with single quotes manually
$quoted_dc_numbers = array_map(function($dc) {
    return "'" . trim($dc) . "'";
}, $dc_numbers);

// Manually wrap unique_id in single quotes too
$where1 = "engineer_name = '" . trim($_GET["unique_id"]) . "' AND dc_number IN (" . implode(',', $quoted_dc_numbers) . ")";

      
        $table1 = "invoice_verfication_table";

        $columns1 = [
            "po_num",
            "form_main_unique_id",
            "get_ledger_name(ledger_name) AS engineer_name",
            "invoice_no",
            "dc_number",
            "dc_date",
            "invoice_qty",
            "vendor_bulk_rate",
            "bulk_total_amount",
            "vendor_bulk_gst",
        ];

        $table_details1 = [
            $table1,
            $columns1
        ];
 
//   $where1 = "engineer_name = '" . $_GET["unique_id"] . "' AND dc_number IN='" . $_GET["dc_number"] . "'";

        $values_product = $pdo->select($table_details1, $where1);
// print_r($values_product);
        if ($values_product->status) {
            $product_array = $values_product->data;

            $sno = 1;
            $grouped = [];
            $sum_unit_price = 0;
            $sum_total_amount = 0;

            // Group product_array by engineer_name
            foreach ($product_array as $product) {
                $name = $product['engineer_name'];

                if (!isset($grouped[$name])) {
                    $grouped[$name] = [
                        'dc_numbers' => [],
                        'invoice_qty' => 0,
                        'vendor_bulk_rate' => 0,
                        'bulk_total_amount' => 0,
                        'vendor_bulk_gst' => $product['vendor_bulk_gst'], // just once
                    ];
                }

                $grouped[$name]['dc_numbers'][] = $product['dc_number'];
                $grouped[$name]['invoice_qty'] += (float)$product['invoice_qty'];
                $grouped[$name]['vendor_bulk_rate'] += $product['vendor_bulk_rate'];
                $grouped[$name]['bulk_total_amount'] += (float)$product['bulk_total_amount'];
            }

            // Display rows
            foreach ($grouped as $engineer => $data) {
                $sum_unit_price += $data['vendor_bulk_rate'];
                $sum_total_amount += $data['bulk_total_amount'];
                ?>
               <tr>
                <td class="text-right"><?php echo $sno++; ?></td>
                <td class="text-left">
                    <?php echo $engineer; ?><br>
                    (<?php echo implode(', ', $data['dc_numbers']); ?>)
                </td>
                <td class="text-right"><?php echo number_format($data['invoice_qty'], 2); ?></td>
                <td class="text-right"><?php echo number_format($data['vendor_bulk_rate'], 2); ?></td>
                <td class="text-right"><?php echo ($data['vendor_bulk_gst']) . '%'; ?></td>
                <td class="text-right"> ₹<?php echo number_format($data['bulk_total_amount'], 2); ?></td>
            </tr>
                <?php
            }
        }
        ?>
    </tbody>

    <?php if (!empty($grouped)) { ?>
    <tfoot>
        <tr style="font-weight:bold; border-top:2px solid #000;">
            <td colspan="3" style="text-align:right;">TOTAL:</td>
            <td class="text-right"><?php echo number_format($sum_unit_price); ?></td>
            <td></td> <!-- GST column intentionally left empty -->
            <td class="text-right">  ₹<?php echo number_format($sum_total_amount, 2); ?></td>
        </tr>
    </tfoot>
    <?php } ?>
</table>


    <div class="account-details">
        <strong>ACCOUNT DETAILS:</strong><br>
        <?php echo $bank_name; ?><br>
        A/C NO:  <?php echo $account_no; ?>
    </div>

</body>
</html>

