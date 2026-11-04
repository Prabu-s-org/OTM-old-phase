<style>
  .hidden_1 {
    display: none;
  }

  .visible {
    display: block;
  }

  .form-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    max-width: 1200px;
    margin: auto;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  }

  .tab-header {
    display: flex;
    gap: 30px;
    border-bottom: 2px solid #eee;
    margin-bottom: 20px;
    padding-bottom: 10px;
  }

  .tab-link {
    padding: 10px;
    font-weight: 500;
    color: #555;
    cursor: pointer;
    border-bottom: 3px solid transparent;
  }

  .tab-link.active {
    color: #6a00ff;
    border-color: #6a00ff;
    font-weight: bold;
  }

  .tab {
    display: none;
  }

  .tab.active {
    display: block;
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-group.full-width {
    grid-column: span 2;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  textarea {
    resize: vertical;
  }

  .form-actions {
    margin-top: 20px;
    text-align: right;
  }

  button {
    padding: 10px 20px;
    background: #007bff;
    border: none;
    border-radius: 5px;
    color: white;
    margin-left: 10px;
    cursor: pointer;
  }

  #cancelTab {
    background: #506018;
  }
</style>
<?php
// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$is_active = 1;

if (isset($_GET["unique_id"])) {
  if (!empty($_GET["unique_id"])) {

    // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
    // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

    $unique_id = $_GET['unique_id'];
    $bill_no = $_GET['bill_no'];
    $invoice_no = $_GET['invoice_no'];
    // $ins_unique_id  = $_GET['ins_unique_id'];

    // $where = [
    //   "bill_form_unique_id" => $unique_id,
    //   "bill_no" => $bill_no,
    //   "invoice_no" => $invoice_no,
    //   // "ins_unique_id" => $ins_unique_id,

    // ];


    // function pr_details($unique_id = "")
// {

    //     global $pdo;

    //     $table_name = "product_details_sub";
//     $where = [];
//     $table_columns = [
//         "warranty",
//         "bg_percen",
//         "bg_month"
//     ];

    //     $table_details = [
//         $table_name,
//         $table_columns
//     ];

    //     $where = [
//         "is_active" => 1,
//         "is_delete" => 0
//     ];

    //     if ($unique_id) {

    //         // $where              = [];
//         $where["form_main_unique_id"] .= $unique_id;
//     }

    //     $group_by = 'form_main_unique_id';

    //     $user_types = $pdo->select($table_details, $where, '', '', '', '', $group_by);

    //     if ($user_types->status) {
//         return $user_types->data;
//     } else {
//         print_r($user_types);
//         return 0;
//     }
// }




    $table = "view_payment_entry_list";

    $where = "bill_no = '$bill_no' AND bill_form_unique_id  = '$unique_id' AND invoice_no = '$invoice_no'";


    $columns = [

      'po_num',
      'po_date',
      // 'con_contact_name',
      // 'con_address',
      'invoice_no',
      'invoice_date',
      'invoice_value',
      "invoice_qty",
      'bill_submission_date',
      'e_no',
      'net_value',
      'qty',
      // "(select sum(invoice_qty) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND is_delete='0' group by po_unique_id) as qty",
      // "unit_price",
      "(select sum(unit_price) from invoice_creation as invoice_creation where invoice_creation.invoice_no= $table.invoice_no AND invoice_creation.po_num= $table.po_num AND is_delete='0' order by invoice_creation.id desc limit 1) as unit_price",
      // "dc_signed_date",
      "(select dc_signed_date from sign_doc_verification_detail as sign where sign.invoice_no= $table.invoice_no AND is_delete=0 group by bill_form_unique_id) as dc_signed_date",
      "delivery_due_dates",
      // 'ld_per_day',
      // 'ld_maximum_val',
      "gst",
      "gst_value",
      "tds",
      "tds_value",
      "ld",
      "tran_amt",
      // tran_amt
      "rem_amt",
      "payement_receive",
      "payment_status",
      "payment_date",
      'bill_form_unique_id',
      "bill_no",
      "claim_amount",
      // "main_invoice_no",
      // "(select cancel_invoice_no from bill_submission_main_table as bill where bill.bill_no= $table.bill_no AND is_delete=0 group by bill_form_unique_id) as cancel_invoice_no",
      // "ins_unique_id",
      //  "(select delivery_due_dates from product_details_sub as pro where pro.form_main_unique_id= $table.bill_form_unique_id AND is_delete=0 group by bill_form_unique_id) as product_delivery_due_dates",
      // "(select pro.ld_per_day from product_details_sub as pro where pro.form_main_unique_id = $table.bill_form_unique_id and pro.is_delete = 0 order by pro.id desc limit 1) as ld_per_day",
      // "(select ld_delivery_due_date from po_form as po where po.unique_id= $table.bill_form_unique_id AND is_delete=0 ) as ld_delivery_due_date",

      "(SELECT get_department_name(department) from po_form where unique_id = $table.bill_form_unique_id) AS customer",
      "(SELECT (bill_address) from po_form where unique_id = $table.bill_form_unique_id) AS address",
      "(SELECT (contact_name) from po_form where unique_id = $table.bill_form_unique_id) AS contact_name",
      "(SELECT (contact_number) from po_form where unique_id = $table.bill_form_unique_id) AS contact_number",
      "(SELECT (email) from po_form where unique_id = $table.bill_form_unique_id) AS email",
      "(SELECT (executive_name) from po_form where unique_id = $table.bill_form_unique_id) AS executive_name",
      "(SELECT (pin) from po_form where unique_id = $table.bill_form_unique_id) AS pincode",
      "bg_value",
      // "bg"
      "(SELECT bg_month 
 FROM product_details_sub 
 WHERE form_main_unique_id = '$unique_id' 
 GROUP BY form_main_unique_id
 LIMIT 1) AS bg_month",

      "(SELECT bg_percen 
 FROM product_details_sub 
 WHERE form_main_unique_id = '$unique_id' 
 GROUP BY form_main_unique_id
 LIMIT 1) AS bg_percen",


      // "(SELECT bg_month from  product_details_sub where form_main_unique_id = '$unique_id' groupby form_main_unique_id) AS bg_month",
      // "(SELECT bg_percen from  product_details_sub where form_main_unique_id = '$unique_id') AS bg_percent",
      // "(SELECT bg_value from  product_details_sub where form_main_unique_id = '$unique_id') AS bg_value",

      "DATE_FORMAT(bill_created_date,'%d-%m-%Y')as bill_created_date",
      "claim_percent",
      "claim_amount"

      //  "(SELECT claim_amount from bill_submission_main_table where bill_no = $table.bill_no ) AS bill_created_date",



    ];

    $table_details = [
      $table,
      $columns
    ];

    $result_values = $pdo->select($table_details, $where);

    // print_r($result_values);die(); 
    if ($result_values->status) {

      $result_values = $result_values->data;

      $po_num = $result_values[0]["po_num"];
      $claim_amount = $result_values[0]["claim_amount"];
      // $con_contact_name          = $result_values[0]["con_contact_name"];
      // $con_address          = $result_values[0]["con_address"];
      $invoice_no = $result_values[0]["invoice_no"];

      $invoice_no_array = explode(',', $invoice_no);
      $invoice_qty = $result_values[0]["invoice_qty"];
      $invoice_val = $result_values[0]["invoice_value"];

      // $invoice_date          = $result_values[0]["invoice_date"];
      // $invoice_value          = $result_values[0]["invoice_value"];
      // indian_format_round
      $invoice_value_amt = indian_format_round(($result_values[0]["invoice_value"]));

      // $invoice_value_amt = moneyFormatIndia(round($result_values[0]["invoice_value"],0));
      // =$invoice_value;
      $invoice_value = $invoice_value_amt;
      $unit_price_val = $result_values[0]["unit_price"];
      $e_no = $result_values[0]["e_no"];

      $claim_percent = $result_values[0]["claim_percent"];
      $claim_amount = indian_format_round($result_values[0]["claim_amount"]);

      // $ld_per_day          = $result_values[0]["ld_per_day"];
      // $ld_maximum_val          = $result_values[0]["ld_maximum_val"];
      $payement_receive = $result_values[0]["payement_receive"];
      $payment_status = $result_values[0]["payment_status"];
      $payment_date = $result_values[0]["payment_date"];
      $bill_form_unique_id = $result_values[0]["bill_form_unique_id"];
      $bill_no = $result_values[0]["bill_no"];

      $gst = $result_values[0]["gst"];
      $gst_value = $result_values[0]["gst_value"];
      $tds = $result_values[0]["tds"];
      $tds_value = $result_values[0]["tds_value"];
      $ld = $result_values[0]["ld"];
      $rem_amt = $result_values[0]["rem_amt"];
      $tran_amt = $result_values[0]["tran_amt"];
      $cancel_invoice_no = $result_values[0]["cancel_invoice_no"];
      $invoice_nos = $result_values[0]["main_invoice_no"];
      $dc_signed_date = $result_values[0]["dc_signed_date"];

      $orgDate = $result_values[0]["po_date"];
      $po_date = date("d-m-Y", strtotime($orgDate));

      $orgDate1 = $result_values[0]["invoice_date"];
      $invoice_date = date("d-m-Y", strtotime($orgDate1));

      $orgDate2 = $result_values[0]["bill_submission_date"];

      $bill_submission_date = date("d-m-Y", strtotime($orgDate2));
      $ld_per_day = $result_values[0]["ld_per_day"];
      $ld_delivery_due_date = $result_values[0]["ld_delivery_due_date"];


      $bill_created_date = $result_values[0]["bill_created_date"];
      $customer_name = $result_values[0]["customer"];

      $address = $result_values[0]["address"];
      $contact_name = $result_values[0]["contact_name"];
      $contact_number = $result_values[0]["contact_number"];

      $email = $result_values[0]["email"];

      $pincode = $result_values[0]["pincode"];
      $executive_name = $result_values[0]["executive_name"];

      $bg_percent = $result_values[0]["bg_percen"];

      if ($bg_percent == '') {
        $bg_percent = '-';
      }

      $bg_value = indian_format_round($result_values[0]["bg_value"]);

      if ($bg_value == '') {
        $bg_value = '-';
      }

      $btn_text = "Update";
      $btn_action = "update";
    } else {
      $btn_text = "Error";
      $btn_action = "error";
      $is_btn_disable = "disabled='disabled'";
    }



    $table_bill = "bill_submission_sub";


    $columns_bill = [

      "claim_percentage as claim_percent",
      "claimamt as claim_amount",




    ];

    $table_details_bill = [
      $table_bill,
      $columns_bill
    ];

    $where_bill = "bill_no = '$bill_no' AND bill_form_unique_id  = '$unique_id' AND invoice_no = '$invoice_no' AND is_delete = 0";


    $result_values_1 = $pdo->select($table_details_bill, $where_bill);

    //  print_r($result_values_1);

    if ($result_values_1->status) {



      $result_values_1 = $result_values_1->data;


      $claim_percent = $result_values_1[0]["claim_percent"];

      $claim_amnt = round($result_values_1[0]["claim_amount"], 0);

      $balance_percent = 100 - $claim_percent;


      //  $bill_claim_amnt = (round($result_values_1[0]["claim_amount"],2));
      $bill_claim_amnt = indian_format_round($result_values_1[0]["claim_amount"]);

      $dc_received_amnt = indian_format_round($invoice_val - $claim_amnt);

      // print_r($dc_received_amnt);

    }


    //  print_r($dc_received_amnt);


  }
}

$tax_select_options =
  [
    "2%" => [
      "unique_id" => "2",
      "value" => "2%",
    ]
  ];

$tax_select_options = select_option($tax_select_options, "Select Option");

$tax_select_options_tds =
  [

    "10%" => [
      "unique_id" => "10",
      "value" => "10%",
    ],
    "2%" => [
      "unique_id" => "2",
      "value" => "2%",
    ],

  ];
$tax_select_options_tds = select_option($tax_select_options_tds, "Select Option");

$payemt_status_option = [


  "Pending" => [

    "unique_id" => "0",
    "value" => "Pending",

  ],

  "Reject" => [
    "unique_id" => "1",
    "value" => "Reject",
  ],

  "Complete" => [
    "unique_id" => "2",
    "value" => "Complete",
  ]
];

$payment_status = isset($payment_status) ? $payment_status : '0';

$payemt_status_options = select_option($payemt_status_option, 'Select Status', $payment_status);


$active_status_options = active_status($is_active);



$dc_select_options = dc_dateLD($bill_form_unique_id, $invoice_no);
$dc_select_options = select_option($dc_select_options, "Select DC Date");
?>

<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Payment Form</h4>

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
          <li class="breadcrumb-item active"> Payment</li>
        </ol>
      </div>

    </div>
  </div>
</div>

<div class="form-card">
  <div class="tab-header">
    <div class="tab-link active" data-tab="0">Bill Details</div>
    <div class="tab-link" data-tab="1">Payment Details</div>
  </div>

  <form id="poForm">
    <!-- Tab 1: Bill Details -->
    <div class="tab active tab-0">
      <!-- Your existing Bill Details content -->
      <div class="col-lg-12">
        <div class="card-body p-4 border-top border-top-dashed">
          <div class="row g-3">
            <!-- Left Section -->
            <div class="row">
              <!-- Left Section -->
              <!-- Left Section -->
              <div class="col-4">
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details
                </h6>

                <h6 style="font-size: x-large; color: #506018;"><strong><?= $customer_name; ?></strong></h6>
                <p class="mb-1"><?= $address; ?></p>
                <p class="mb-1"><?= $pincode; ?></p>
                <h6>
                  <span id="legal-register-no" class="fw-bold"><?= $contact_name; ?></span>
                </h6>
                <h6>
                  <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                  <?= $contact_number; ?></span>
                </h6>
                <h6>
                  <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                  <?= $email; ?></span>
                </h6>
              </div>

              <!-- Center Section -->
              <!-- <div class="col-4 text-start">
                <h6 class="text-uppercase fw-semibold mb-3"
                  style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">Bill Details</h6>
                <h6><span>Bill No </span>: <span class="fw-bold"><?php echo $bill_no; ?></span></h6>
                <h6><span>Bill Date </span>: <span class="fw-bold"><?php echo $bill_created_date; ?></span></h6>
                <h6><span>ENo </span>: <span class="fw-bold"><?php echo $e_no; ?></span></h6>
                <h6><span>Bill Submission Date </span>: <span class="fw-bold"><?php echo $bill_submission_date; ?></span>
                </h6>
              </div> -->

              <!-- BILL DETAILS Section -->
              <div class="col-4">
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">BILL DETAILS</h6>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Bill No</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $bill_no; ?></div>
                </div>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Bill Date</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $bill_created_date; ?></div>
                </div>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">ENo</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $e_no; ?></div>
                </div>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Bill Submission Date</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $bill_submission_date; ?></div>
                </div>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Claim Percent(%)</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $claim_percent; ?></div>
                </div>

                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Claim Value</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $claim_amount; ?></div>
                </div>
              </div>





              <!-- Right Section -->

              <div class="col-4">
                <!-- Invoice Details Heading -->
                <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Invoice Details
                </h6>

                <!-- PO Date -->
                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">PO Date</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $po_date; ?></div>
                </div>

                <!-- PO No -->
                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">PO No</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $po_num; ?></div>
                </div>

                <!-- Invoice NO -->
                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Invoice No</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $invoice_no; ?></div>
                </div>

                <!-- Invoice Date -->
                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">Invoice Date</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $invoice_date; ?></div>
                </div>

                <!-- BG Details Heading -->

                <!-- BG(%) -->
                <div class="row mb-2">


                  <div class="col-5 text-body-secondary">BG(%)</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $bg_percent; ?></div>
                </div>

                <!-- BG Value -->
                <div class="row mb-2">
                  <div class="col-5 text-body-secondary">BG Value</div>
                  <div class="col-1 text-center">:</div>
                  <div class="col-6 "><?php echo $bg_value; ?></div>
                </div>
              </div>

              <!-- <div class="col-4 text-end">
                <h6 class="text-uppercase fw-semibold mb-3"
                  style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">Invoice Details
                </h6>
                <h6><span>PO Date </span>:<span class="fw-bold"><?php echo $po_date; ?></span></h6>
                <h6><span>PO No </span>:<span class="fw-bold"><?php echo $po_num; ?></span></h6>

                <h6><span>Invoice NO </span>:<span class="fw-bold"><?php echo $invoice_no; ?></span></h6>
                <h6><span>Invoice Date </span>:<span class="fw-bold"><?php echo $invoice_date; ?></span></h6>

                <h6 class="text-uppercase fw-semibold mb-3 mt-2"  style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">BG Details</h6>
                <h6><span>BG(%) </span> <span class="fw-bold"><?php echo $bg_percent; ?>%</span></h6>
                <h6><span>BG Value </span> <span class="fw-bold"><?php echo $bg_value; ?></span></h6>
              
              </div> -->



            </div>

          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="col-lg-12">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
              <thead>
                <tr class="table-active">
                  <th>S.No</th>
                  <th>Invoice Date</th>
                  <th>Invoice No</th>
                  <th class="text-end">Invoice Qty</th>
                  <th class="text-end">Invoice Value</th>
                </tr>
              </thead>
              <tbody id="products-list">
              <tbody>
                <?php
                // $table_1 = 'view_elcot_entry_final';
                $table_1 = 'view_payment_entry_list';

                $columns_1 = [
                  // "bill_checkbox",
                  "'' as s_no",
                  "bill_form_unique_id",
                  // "bg_num",
                  // "bg_date",
                  // // "bg_value",
                  "po_num",
                  "po_date",
                  "invoice_qty",
                  // "invoice_value",
                  "ROUND(invoice_value,2) as invoice_value",
                  "invoice_no",
                  // "DATE_FORMAT(invoice_date,'%d-%m-%Y') AS invoice_date",
                  "CASE 
                      WHEN invoice_date LIKE '__-__-____' THEN invoice_date
                      ELSE DATE_FORMAT(STR_TO_DATE(invoice_date, '%Y-%m-%d'), '%d-%m-%Y')
                  END AS invoice_date",


                ];
                $table_details1 = [
                  $table_1,
                  $columns_1
                ];



                // $where1 = "invoice_no IN ('".implode("','", $invoice_no_array) . "') AND bill_status='2'";
                $where1 = "invoice_no='" . $invoice_no . "' AND bill_no = '" . $bill_no . "'";




                $total_qty = 0;
                $total_value = 0;
                $result1 = $pdo->select($table_details1, $where1);
                // print_r($result1);die();
                if ($result1->status) {
                  $res_array1 = $result1->data;


                  // print_r($result1->data);
                  foreach ($res_array1 as $key => $value) {
                    // $remaining_qty = $value['stock_qty'] - $value['product_count'];
                    $value['s_no'] = $sno + 1;

                    $total_qty += (float) $value['invoice_qty'];
                    $total_value += (float) $value['invoice_value'];
                    $value['bill_checkbox'] = '<input class="myCheck" hidden checked type="checkbox" id="bill_checkbox" name="bill_checkbox[]" >';
                    ?>
                    <tr>

                      <td id="table_td"><?php echo $value['s_no']; ?></td>
                      <td id="table_td"><?php echo $value['invoice_date']; ?></td>
                      <td id="table_td"><?php echo $value['invoice_no']; ?></td>

                      <td id="table_td" style="text-align: right;"><?php echo $value['invoice_qty']; ?></td>
                      <td id="table_td" style="text-align: right;"><?php echo moneyFormatIndia1($value['invoice_value']); ?>

                        <?php
                        $sno++;
                  }
                }
                ?>


              </tbody>
              </tr>
              <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="text-end fw-bold"><?php echo number_format($total_qty); ?></td>
                <td class="text-end fw-bold">₹ <?php echo moneyFormatIndia1($total_value) ?></td>
              </tr>


            </table>
          </div>
        </div>
      </div>

      <!-- NEXT button ONLY in Tab 1 -->
      <div class="form-actions">
        <button type="button" id="nextTab" class="btn btn-primary">NEXT</button>
        <?php echo btn_cancel($btn_cancel); ?>
      </div>

    </div>

    <div class="tab tab-1">
      <div class="card-body p-4">
        <div class="row g-4">
          <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no ?>">

          <input type="hidden" name="po_unique_id" id="po_unique_id" value="<?php echo $bill_form_unique_id; ?>">

          <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">


          <!-- <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $bill_form_unique_id ?>">
          <input type="hidden" name="product_unit_price" id="product_unit_price" value="<?php echo $unit_price_val ?>">
          <input type="hidden" name="ld_amount" id="ld_amount">
          <input type="hidden" name="ld_days" id="ld_days">
          <input type="hidden" name="claim_amount" id="claim_amount"
            value="<?php echo $result_values[0]['claim_amount'] ?>">
          <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no ?>">
          <input type="hidden" name="cancel_invoice_no" id="cancel_invoice_no" value="<?php echo $cancel_invoice_no ?>">
          <input type="hidden" name="invoice_qty" id="invoice_qty" value="<?php echo $invoice_qty ?>">
          <input type="hidden" name="invoice_val" id="invoice_val" value="<?php echo $invoice_val ?>"> -->

          <!-- LD Section -->
          <div class="row gx-2 gy-1">

            <div id="ldfileds" style="display:none;">
              <div class="col-md-3">
                <label>LD DC Date</label>
                <input type="date" name="dcDate" id="dcDate" class="form-control" onChange="ldCal(event)" required />
                <input type="hidden" name="deliveryDate" id="deliveryDate" class="form-control"
                  value="<?php echo $ld_delivery_due_date; ?>" />
                <input type="hidden" name="ld_per_day" id="ld_per_day" class="form-control"
                  value="<?php echo $ld_per_day; ?>" />
              </div>
              <div class="col-2 head_po">
                <div class="row">
                  <div class="col-xl-12 head_po">
                    <label class="form-label">LD Days</label>
                  </div>
                  <div class="col-xl-12" id="ldDayDisplay"></div>
                </div>
              </div>

              <div class="col-2 head_po">
                <div class="row">
                  <div class="col-xl-12 head_po">
                    <label class="form-label">LD Value</label>
                  </div>
                  <div class="col-xl-12" id="ldValDisplay"></div>
                </div>
              </div>
            </div>




            <div class="col-12">
              <div class="d-flex justify-content-end">
                <div class="col-md-8">
                  <!-- <h4 class="text-center text-success fw-bold border-bottom pb-2 mb-4">BILL DETAILS</h4> -->

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="3" class="text-center text-uppercase fs-2" style="color: #506018;">BILL DETAILS
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="fw-medium text-start" style="font-size: 1.0rem;">Invoice Amount</td>

                        <td class="fw-bold text-end text-dark" style="font-size: 1.3rem;">
                          <?php echo $invoice_value_amt; ?>
                        </td>
                      </tr>
                      <tr>
                        <td class="fw-medium text-start" style="font-size: 1.0rem;">Claim Amount
                          <b>(<?php echo $claim_percent . '%'; ?>)</b>
                        </td>

                        <td class="fw-bold text-end text-dark" style="font-size: 1.3rem;">
                          <?php echo $bill_claim_amnt; ?>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot class="table-light">
                      <tr>
                        <td class="fw-medium text-start" style="font-size: 1.0rem;">Balance Amount
                          <b>(<?php echo $balance_percent . '%'; ?>)</b>
                        </td>

                        <td class="fw-bold text-end text-dark" style="font-size: 1.3rem;">
                          <?php echo $dc_received_amnt; ?>
                        </td>
                      </tr>
                    </tfoot>
                  </table>

                  <!-- Optional Back/Cancel Buttons -->
                  <!-- <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-secondary me-2">Back</button>
                    <button class="btn btn-danger">Cancel</button>
                  </div> -->
                </div>
              </div>
            </div>

            <div class="col-2">
              <label class="form-label">Pending Status</label>
              <select class="select2 form-control" name="payment_status" id="payment_status"
                onchange="toggleRejectedFields()" required>
                <?php echo $payemt_status_options; ?>
              </select>
              <div style="display: none;">
                <label class="form-label mt-2">Transaction Amount</label>
                <input type="number" id="tran_amt" name="tran_amt" class="form-control" value="<?php echo $tran_amt ?>"
                  required step="any">
              </div>
            </div>






            <!-- Payment Status & Transaction -->


            <div id="rejected_field" style="display: none;">

              <div class="col-md-3" id="rejected_reason_section">
                <label class="form-label"> </label>
                <textarea name="reject_reason" id="reject_reason" class="form-control"
                  style="width: 100%; height: 100%;"></textarea>
              </div>

              <!-- <div class="col-md-3" id="cancel_bill_section">
                <label class="form-label d-block">&nbsp;</label>
                <button type="button" class="btn btn-primary" onclick="cancel_bill()">Bill Cancel</button>
              </div> -->
            </div>

            <div class="container mt-5" id="transcation_detail">
              <h2 class="text-center w-100"><b>PAY TRANSACTION DETAILS</b></h2>
              <hr class="mb-4">

              <!-- ✅ ROW CONTAINER -->
              <div class="row">

                <!-- LEFT COLUMN: AMOUNT FIELDS -->
                <div class="col-md-6">
                  <div id="amountfileds">

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">Received Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" id="recieved_amnt"
                        oninput="transaction_amnt();allowNumbersOnly(this)">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">LD Deducted Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" id="ld_amnt"
                        oninput="transaction_amnt();allowNumbersOnly(this)">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">GST Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" id="gst_amnt"
                        oninput="transaction_amnt();allowNumbersOnly(this)">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">TDS Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" id="tds_amnt"
                        oninput="transaction_amnt();allowNumbersOnly(this)">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">Total Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" readonly id="ttl_amnt">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">Claim Amount</label>
                      <span class="input-group-text">₹</span>
                      <input type="text" class="form-control" id="claim_amnt" readonly
                        value="<?php echo $claim_amnt; ?>">
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                      <label class="form-label col-5">Balance Amount</label>
                      <!-- <span class="input-group-text">₹</span> -->
                      <span class="" name="balance_amnt" id="balance_amnt"><b>₹</b></span>
                      <input type="hidden" id="balance_amount" name="balance_amount">
                      <!-- <input type="text" class="form-control" id="balance_amnt" value="<?php echo $ld_amount; ?>"> -->
                    </div>

                  </div>
                </div>

                <!-- RIGHT COLUMN: TRANSACTION FIELDS -->
                <div class="col-md-6">
                  <div class="mb-3 row align-items-center">
                    <label class="col-4 col-form-label">Date</label>
                    <div class="col-8">
                      <input type="date" id="trans_date" name="trans_date" class="form-control">
                    </div>
                  </div>

                  <div class="mb-3 row align-items-center">
                    <label class="col-4 col-form-label">Reference</label>
                    <div class="col-8">
                      <input type="text" id="trans_id" name="trans_id" class="form-control"
                        oninput="filterAlphanumericOnly(this)">
                    </div>
                  </div>

                  <div class="mb-3 row align-items-center">
                    <label class="col-4 col-form-label">Transaction Amount</label>
                    <div class="col-8">
                      <input type="text" id="trans_amnt" name="trans_amnt" class="form-control"
                        oninput="allowNumbersOnly(this)">
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-3 hidden_1" id="invoice_section">
              <input type="hidden" id="main_invoice_no" name="main_invoice_no" class="form-control"
                value="<?php echo $invoice_nos; ?>">
              <input type="hidden" id="remaing_main_invoice_no" name="remaing_main_invoice_no" class="form-control">
            </div>

            <!-- GST and TDS -->
            <div id="completed_sts" style="display:none;">


              <div class="row gx-2 gy-1">
                <div class="col-md-3">
                  <label class="form-label">GST %</label>
                  <select class="form-select" name="gst" id="gst" onchange="getGst_value()">
                    <?php echo $tax_select_options ?>
                  </select>
                  <input type="hidden" id="invoice_qty_value" name="invoice_qty_value" class="form-control"
                    value="<?php echo $invoice_qty_value; ?>">
                </div>

                <div class="col-md-3">
                  <label class="form-label">GST Value</label>
                  <input type="text" id="gst_value" name="gst_value" class="form-control"
                    value="<?php echo $gst_value ?>" readonly>
                </div>
              </div>
              <div class="row gx-2 gy-1">
                <div class="col-md-3">
                  <label class="form-label">TDS %</label>
                  <select class="form-select" name="tds" id="tds" onchange="getTds_value()">
                    <?php echo $tax_select_options_tds ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label">TDS Value</label>
                  <input type="text" id="tds_value" name="tds_value" class="form-control"
                    value="<?php echo $tds_value ?>" readonly>
                </div>
              </div>

              <!-- LD and Payment Fields -->
              <div class="row gx-2 gy-1">
                <div class="col-md-3">
                  <label class="form-label">LD Deducted by Elcot</label>
                  <input type="number" id="ld" name="ld" class="form-control" value="<?php echo $ld ?>"
                    onchange="cal_rem(),checkLdValue();" step="any" required>
                  <input type="hidden" id="ld_value" name="ld_value" class="form-control" value="<?php echo $ld ?>">
                  <input type="hidden" id="ld_display_value" name="ld_display_value" class="form-control"
                    value="<?php echo $result_values[0]['qty']; ?>">
                  <span id="ld_error" class="text-danger"></span>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Payment Received</label>
                  <input type="text" id="payement_receive" name="payement_receive" class="form-control"
                    value="<?php echo $payement_receive ?>" onchange="cal_rem()" step="any" required>
                  <input type="hidden" id="invoice_value" name="invoice_value" class="form-control"
                    value="<?php echo $invoice_value ?>">
                </div>

                <div class="col-md-3">
                  <label class="form-label">Remaining Amount</label>
                  <input type="number" id="rem_amt" name="rem_amt" class="form-control" value="<?php echo $rem_amt ?>"
                    readonly>
                </div>
              </div>
              <!-- Payment Date and File Upload -->
              <div class="col-md-3">
                <label class="form-label">Payment Received Date</label>
                <input type="date" class="form-control" id="payment_date" name="payment_date"
                  value="<?php echo $payment_date; ?>" required>
              </div>

              <div class="col-md-3" id="images">
                <label class="form-label">Payment Receipt</label>
                <input type="file" id="file" accept="application/pdf" name="file" class="form-control"
                  value="<?php echo $file_org_name; ?>" required>
              </div>
            </div>

          </div>
          <div class="form-actions mt-4">
            <div class="row">
              <div class="col-12 d-flex justify-content-end gap-2">
                <button type="button" id="cancelTab" class="btn btn-primary">Back</button>
                <!-- <div class="col-md-3" id="cancel_bill_section">
                  <label class="form-label d-block">&nbsp;</label> -->
                <button type="button" class="btn btn-primary" id="cancel_bill_section" style="display: none;"
                  onclick="cancel_bill()">Bill Cancel</button>
                <!-- </div> -->
                <?php echo btn_cancel($btn_cancel); ?>
                <button type="button" style="display: none;" id="submit_btn" onclick="transaction_complete()"
                  class="btn btn-success">Submit</button>
              </div>
            </div>
          </div>

        </div>
      </div>
  </form>
</div>

<?php

function indian_format_round($num)
{
  $rounded = round($num); // Round to nearest whole number
  $int = (string) $rounded;
  $lastThree = substr($int, -3);
  $restUnits = substr($int, 0, -3);
  if ($restUnits != '') {
    $lastThree = ',' . $lastThree;
  }
  $formatted = ($restUnits != '')
    ? preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits) . $lastThree
    : $lastThree;
  return $formatted;
}


?>

<!-- JS to handle tab switching -->
<script>
  const tabs = document.querySelectorAll(".tab");
  const links = document.querySelectorAll(".tab-link");



  // Tab switching when header is clicked
  links.forEach(link => {
    link.addEventListener("click", () => {
      const target = link.getAttribute("data-tab");

      // Remove 'active' from all
      links.forEach(l => l.classList.remove("active"));
      tabs.forEach(t => t.classList.remove("active"));

      // Add 'active' to clicked tab
      link.classList.add("active");
      tabs[target].classList.add("active");
    });
  });

  document.getElementById("nextTab").addEventListener("click", () => {
    tabs[0].classList.remove("active");
    tabs[1].classList.add("active");
    links[0].classList.remove("active");
    links[1].classList.add("active");
  });

  document.getElementById("cancelTab").addEventListener("click", () => {
    tabs[1].classList.remove("active");
    tabs[0].classList.add("active");
    links[1].classList.remove("active");
    links[0].classList.add("active");
  });


  window.onload = function () {
    function toggleRejectedFields() {
      var paymentStatus = document.getElementById('payment_status').value;

      var transactionDetail = document.getElementById('transcation_detail');
      var amountFields = document.getElementById('amountfileds');
      var rejectedField = document.getElementById('rejected_field');
      var cancelBillBtn = document.getElementById('cancel_bill_section');

      var submitBtn = document.getElementById('submit_btn');


      if (paymentStatus === '2') { // Completed
        transactionDetail.style.display = 'block';
        amountFields.style.display = 'block';
        rejectedField.style.display = 'none';
        cancelBillBtn.style.display = 'none';

        submitBtn.style.display = 'block';
        // $('#submit_btn').show();

      } else if (paymentStatus === '1') { // Rejected
        transactionDetail.style.display = 'none';
        amountFields.style.display = 'none';
        rejectedField.style.display = 'block';
        cancelBillBtn.style.display = 'block';
        submitBtn.style.display = 'none';

      } else { // Pending or default
        transactionDetail.style.display = 'none';
        amountFields.style.display = 'none';
        rejectedField.style.display = 'none';
        cancelBillBtn.style.display = 'none';
      }
    }

    // Trigger once on page load
    toggleRejectedFields();

    // Bind the function to the dropdown
    document.getElementById('payment_status').onchange = toggleRejectedFields;
  };



  function transaction_amnt() {
    var reciceved_amount = parseInt(document.getElementById('recieved_amnt').value) || 0;

    // alert(reciceved_amount);
    var ld_amount = parseInt(document.getElementById('ld_amnt').value) || 0;
    var gst_amount = parseInt(document.getElementById('gst_amnt').value) || 0;
    var tds_amount = parseInt(document.getElementById('tds_amnt').value) || 0;
    var claim_amount = parseInt(document.getElementById('claim_amnt').value) || 0;

    // alert(claim_amount);

    var sum_ttl_amnt = parseInt(reciceved_amount + ld_amount + gst_amount + tds_amount);

    // alert(sum_ttl_amnt);

    document.getElementById('ttl_amnt').value = sum_ttl_amnt;

    var balance_calc = (sum_ttl_amnt) - (claim_amount);

    var roundedBalance = Math.round(balance_calc);

    document.getElementById('balance_amount').value = roundedBalance;

    document.getElementById('balance_amnt').innerHTML =
      `<span style="font-weight: bold; font-size: 1.4rem; display: block; text-align: center;">₹ ${roundedBalance}</span>`;

    // alert(balance_calc);

    // document.getElementById('balance_amount').innerHTML = `<span style="font-weight: bold; font-size: 1.5rem; display: block; text-align: center;">${balance_calc.toFixed(0)}</span>`;
  }


  // function transaction_amnt() {
  //     function getNumber(id) {
  //         let val = document.getElementById(id).value.replace(/,/g, ''); // remove commas
  //         return parseFloat(val) || 0; // use parseFloat for decimal support
  //     }

  //     let reciceved_amount = getNumber('recieved_amnt');
  //     let ld_amount        = getNumber('ld_amnt');
  //     let gst_amount       = getNumber('gst_amnt');
  //     let tds_amount       = getNumber('tds_amnt');
  //     let claim_amount     = getNumber('claim_amnt');

  //     let sum_ttl_amnt = reciceved_amount + ld_amount + gst_amount + tds_amount;

  //     document.getElementById('ttl_amnt').value = sum_ttl_amnt.toFixed(2);

  //     let balance_calc = sum_ttl_amnt - claim_amount;

  //     document.getElementById('balance_amnt').textContent = balance_calc.toFixed(2);
  // }


  function transaction_complete() {


    var po_unique_id = $('#po_unique_id').val();


    // return;
    var invoice_no = $('#invoice_no').val(); // ✅ Correct this



    var bill_no = $('#bill_no').val();


    var reciceved_amount = $('#recieved_amnt').val();


    var trans_date = $('#trans_date').val();
    var ld_amount = $('#ld_amnt').val();

    var gst_amount = $('#gst_amnt').val();
    var tds_amount = $('#tds_amnt').val();
    var claim_amount = $('#claim_amnt').val();

    var ttl_amnt = $('#ttl_amnt').val();

    var balance_amnt = $('#balance_amount').val();

    var trans_id = $('#trans_id').val();
    var trans_amount = $('#trans_amnt').val();



    if (
      !trans_date || !gst_amount || !tds_amount ||
      !claim_amount || !ttl_amnt || !balance_amnt || !trans_id || !trans_amount
    ) {
      Swal.fire({
        icon: 'warning',
        title: 'Missing Fields',
        text: 'Please fill out all mandatory fields before submitting.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return; // prevent form submission
    }



    var data = {

      "po_unique_id": po_unique_id,
      "invoice_no": invoice_no,
      "bill_no": bill_no,
      "reciceved_amount": reciceved_amount,
      "claim_amount": claim_amount,

      "trans_id": trans_id,
      "trans_date": trans_date,
      "tds_amount": tds_amount,
      "trans_amount": trans_amount,
      "gst_amount": gst_amount,
      "ld_amount": ld_amount,
      "balance_amnt": balance_amnt,
      "ttl_amnt": ttl_amnt,

      "action": "payment_update_detail"

    }
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var url = sessionStorage.getItem("list_link");

    $.ajax({
      url: ajax_url,
      data: data,
      type: "POST",

      success: function (data) {

        // return;

        // alert('saved');
        sweetalert("create", url);
      },

      error: function (data) {
        alert("Network Error");
      }
    });


  }

  // window.onload = function () {
  //   function toggleRejectedFields() {
  //     var paymentStatus = document.getElementById('payment_status').value;
  //     var rejectedReasonSection = document.getElementById('rejected_reason_section');
  //     var invoiceSection = document.getElementById('invoice_section');
  //     var cancelBillSection = document.getElementById('cancel_bill_section');
  //     // alert(cancelBillSection);

  //     console.log('Payment Status:', paymentStatus);
  //     console.log('Rejected Reason Section:', rejectedReasonSection);
  //     console.log('Invoice Section:', invoiceSection);
  //     console.log('Cancel Bill Section:', cancelBillSection);

  //     if (paymentStatus === '1') {
  //       if (rejectedReasonSection) {
  //         rejectedReasonSection.classList.remove('hidden');
  //         rejectedReasonSection.classList.add('visible');
  //          invoiceSection.classList.remove('hidden');
  //       }

  //       if (invoiceSection) {
  //         invoiceSection.classList.remove('hidden');
  //         invoiceSection.classList.add('visible');
  //       }

  //       if (cancelBillSection) {  
  //         cancelBillSection.classList.remove('hidden');
  //         cancelBillSection.classList.add('visible');
  //       }
  //     } else {
  //       if (rejectedReasonSection) {
  //         rejectedReasonSection.classList.remove('visible');
  //         rejectedReasonSection.classList.add('hidden');
  //       }

  //       if (invoiceSection) {
  //         invoiceSection.classList.remove('visible');
  //         invoiceSection.classList.add('hidden');
  //       }

  //       if (cancelBillSection) {
  //         cancelBillSection.classList.remove('visible');
  //         cancelBillSection.classList.add('hidden');
  //       }
  //     }
  //   }

  //   document.getElementById('payment_status').onchange = toggleRejectedFields;
  // };
  function ldCal() {
    document.getElementById("ldDayDisplay").innerText = '';
    const deliveryDateVal = document.getElementById('deliveryDate').value;
    const [refYear, refMonth, refDay] = deliveryDateVal.split('-'); // Correct order
    const referenceDate = new Date(Number(refYear), Number(refMonth) - 1, Number(refDay));

    // console.log("Formatted:", referenceDate);
    let dcDateVal = document.getElementById('dcDate').value;
    const [year, month, day] = dcDateVal.split("-");
    const selectedDate = new Date(Number(year), Number(month) - 1, Number(day));

    // console.log("Formatted:", selectedDate);
    referenceDate.setHours(0, 0, 0, 0);
    selectedDate.setHours(0, 0, 0, 0);
    if (selectedDate <= referenceDate) {
      console.log("Selected date is before or same as 15-06-2025. No action needed.");
    } else {
      const diffTime = selectedDate - referenceDate;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      // console.log(`Selected date is ${diffDays} day(s) after 15-06-2025.`);

      document.getElementById("ldDayDisplay").innerText = diffDays;
      document.getElementById("ld_days").value = diffDays;

      let ldPerDay = document.getElementById('ld_per_day').value;
      let product_unit_price = document.getElementById('product_unit_price').value;

      let ldAmt = product_unit_price * diffDays * ldPerDay / 100;

      let fixedNumber = parseFloat(ldAmt.toFixed(2));
      document.getElementById("ldValDisplay").innerText = fixedNumber;

      document.getElementById("ld_amount").value = fixedNumber;

      console.log(fixedNumber);

    }
  }
  function getGst_value() {
    let invoice_qty_value = document.getElementById("invoice_qty_value").value;
    let gstValue = (invoice_qty_value * 0.02);
    document.getElementById("gst_value").value = gstValue.toFixed(2);

  }
  function getTds_value() {
    let invoice_qty_value = document.getElementById("invoice_qty_value").value;
    let tdsSelect = document.getElementById("tds");
    let selectedTds = tdsSelect.value; // Get the selected TDS percentage

    // Parse the selected TDS percentage to a decimal for calculation
    let tdsPercentage = parseFloat(selectedTds) / 100;

    // Calculate the TDS value
    let tdsValue = invoice_qty_value * tdsPercentage;

    // Set the calculated TDS value to the input field
    document.getElementById("tds_value").value = tdsValue.toFixed(2);
  }
  function cal_rem() {
    // Helper function to remove commas from a number string and convert to float
    function parseNumber(value) {
      return parseFloat(value.replace(/,/g, '')) || 0;
    }

    // Retrieve and parse values
    let gst_value = parseNumber(document.getElementById("gst_value").value);
    // alert(gst_value);
    let tds_value = parseNumber(document.getElementById("tds_value").value);
    // alert(tds_value);
    let ld = parseNumber(document.getElementById("ld").value);
    // alert(ld);
    let payement_receive = parseNumber(document.getElementById("payement_receive").value);
    // alert(payement_receive);
    // alert(payement_receive);
    let invoice_value = parseNumber(document.getElementById("invoice_value").value);
    // alert(invoice_value);

    // // Debugging: Print values to check their correctness
    // console.log("GST Value: " + gst_value);
    // console.log("TDS Value: " + tds_value);
    // console.log("LD: " + ld);
    // console.log("Payment Received: " + payement_receive);
    // console.log("Invoice Value: " + invoice_value);

    // Calculate total deduction
    let total_deduction = invoice_value - (gst_value + tds_value + ld + payement_receive);
    // console.log("Total Deduction: " + total_deduction);

    // Set the remaining amount in the corresponding input field
    // document.getElementById("rem_amt").value = total_deduction;
    document.getElementById("rem_amt").value = total_deduction.toFixed(2);

  }
  function checkLdValue() {
    let ldValue = parseFloat(document.getElementById('ld_display_value').value);
    // alert(ldValue);

    let ldInput = parseFloat(document.getElementById('ld').value);
    // alert(ldInput);
    let errorMessage = document.getElementById('ld_error');

    if (ldInput > ldValue + 2) {
      // alert('higher value');
      errorMessage.textContent = "This is more than one rupee higher than the LD value.";
    } else if (ldInput < ldValue - 2) {
      // alert('lower value');
      errorMessage.textContent = "This is more than one rupee lower than the LD value.";
    } else {
      errorMessage.textContent = "";
    }
  }


  function Calculate_balance_amnt() {


    var reciceved_amount = document.getElementById("recived").value;

    var ld_amount = document.getElementById("recived").value;
    var gst_amount = document.getElementById("recived").value;
    var tds_amount = document.getElementById("recived").value;


    // var reciceved_amount = document.getElementById("recived").value;

  }
</script>


<!-- <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Number</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $po_num ?></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Customer Name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $po_date ?></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label"> Contact Name</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">State</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                         
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice No</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $invoice_no ?></div>
                                <input type="hidden" name="my_inv_no" id="my_inv_no" value="<?php echo $invoice_no ?>" >
                            </div>
                          
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Qty</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $invoice_qty ?></div>
                            </div>
                             
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Dc Count</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bg Num</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                             
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Claim (%)</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $claim_amount; ?></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bill No</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $bill_no ?></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">E No</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $e_no; ?></div>
                            </div>
                              
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Payment Receivable</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $payement_receive ?></div>
                            </div>
                           
                        </div>

                        <div class="col-6">
                          <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">PO Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $po_date ?></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Customr Address</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Contact Number</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">District</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                           
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Invoice Value</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $invoice_value ?></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bg %</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bg Value</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                             <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Claim Value</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                              <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bill Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"></div>
                            </div>
                          
                            <div class="row">
                                <div class="col-xl-4 head_po"> <label for="main_screen" class="form-label">Bill Submission Date</label></div>
                                <div class="col-xl-1">:</div>
                                <div class="col-xl-7"><?php echo $bill_submission_date; ?></div>
                            </div>
                            
                          
                        </div>
                    </div>
                </div> -->
<!-- <div class="form-grid">
            <div class="form-group">
            <label>PO Number *</label>
            <input type="text" required>
            </div>
            <div class="form-group">
            <label>PO Date *</label>
            <input type="date" required>
            </div>
            <div class="form-group">
            <label>Customer *</label>
            <select required>
                <option value="">Select Customer</option>
                <option>Customer A</option>
            </select>
            </div>
            <div class="form-group">
            <label>Account Vertical *</label>
            <select required>
                <option value="">Select Vertical</option>
                <option>Retail</option>
            </select>
            </div>
            <div class="form-group">
            <label>Billing Address *</label>
            <textarea required></textarea>
            </div> -->
<!-- Add other fields here as needed -->
<!-- </div> -->
