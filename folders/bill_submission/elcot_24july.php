<style>
  .card-body.print_table p {
    margin-bottom: .375rem;
    margin: 0px 60px;
    /* margin-right:80px; */
    /* margin: 5% auto; */
  }
  .part1 {
    margin-bottom: 1.75rem;
  }
  table.print-tabe {
    border-collapse: collapse;
    width: 100%;
  }
  table.print-tabe tr th,
  td {
    border: .0625rem solid #dddddd;
    text-align: left;
    padding: .375rem;
    /* margin-left: 100px; */
    /* margin-left:121px; */
  }
  #total {
    text-align: right;
    /* margin-right: 50px; */
    
  }
  body{background-color:#fff!important;}

</style>
<?php include 'function.php'; ?>
<!-- <a href="elcot.php" target="_blank">Download PDF</a> -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Elcot Entry</h4>
      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
          <li class="breadcrumb-item active">Elcot Entry</li>
        </ol>
      </div>
    </div>
    <div>
    </div>
  </div>
</div>
<br>
<br>
<?php
if (isset($_GET["unique_id"])) {
  if (!empty($_GET["unique_id"])) {
    $unique_id = $_GET['unique_id'];
    $bill_no = $_GET['bill_no'];
    // $where      = [
    //   "unique_id" => $unique_id,
    //   "bill_no" => $bill_no,

    // ];
    $where      = "unique_id='$unique_id' AND  bill_no='$bill_no'";

    // ];
    $table_sub      =  "bill_submission_main_table";
    $columns    = [
      "po_num",
      "po_date",
      "bill_no",
      "bg_value",
      "invoice_no",
      "invoice_value",
      "e_no",
      "elcot_ent_status",
      "unique_id",
      "bill_submission_date",
      "bg_num",
      "claim_amount",
      "bill_no",
      // "(select claim_amount from sign_doc_verification_detail as sign sign.invoice_no IN ('$table_sub'.invoice_no)) as claim_amount",
      // "'' as claim",
    ];
    $table_details   = [
      $table_sub,
      $columns
    ];
    $result_values_data  = $pdo->select($table_details, $where);
    // print_r($result_values_data);die();
    if ($result_values_data->status) {
      $result_values_data      = $result_values_data->data;
      
      $claim_amount    = $result_values_data[0]["claim_amount"];
      $po_num         = $result_values_data[0]["po_num"];
      $po_date         = $result_values_data[0]["po_date"];
      $dateTime = new DateTime($po_date);
      $podate = $dateTime->format('d-m-Y');
      $bill_no         = $result_values_data[0]["bill_no"];
      $bg_value         = $result_values_data[0]["bg_value"];
      $invoice_no         = $result_values_data[0]["invoice_no"];
      $invoice_value         = $result_values_data[0]["invoice_value"];
      $bill_submission_date         = $result_values_data[0]["bill_submission_date"];
      $bg_num = $result_values_data[0]['bg_num'];
      $claim_amount = $result_values_data[0]['claim_amount'];
      $invoice_values= $invoice_value * ($claim_amount / 100);
      $invoice_value_val = moneyFormatIndia1(($invoice_values));

     
      //  $elcot['invoice_value'] = $elcot['invoice_value'] * ($claim_amount/100) ;
      $btn_text           = "Update";
      $btn_action         = "update";
    } else {
      $btn_text           = "Error";
      $btn_action         = "error";
      $is_btn_disable     = "disabled='disabled'";
    }
  }
}
$cur_date = date('Y-m-d');
$dateTime = new DateTime($cur_date);
$formattedDate = $dateTime->format('d-m-Y');
?>
<div class="card">
  <div class="card-header">
    <img src="assets/images/elcot_header.jpeg" style="width: 100%;">
  </div>
  <div class="card-body print_table">
    <div class="part1">
      <p>Chennai,</p>
      <P> <?php echo $formattedDate ?></P>
    </div>
    <div class="part1">
      <p><b>To</b></p>
      <P>The Managing Director,</P>
      <p>ELCOT,</p>
      <p>Chennai.</p>
    </div>
    <div class="part1">
      <P><b>Respected Sir,</b> </P>
      <p>Sub: Submission of bills-Reg.</p>
    </div>
    <div class="part1">
      <p>We are pleased to submit the bills for the supply of Department & Others. 
        <b><?php echo $po_num; ?></b> Date:<b> <?php echo $podate; ?> </b>
        therefore, we request your good self to kindly release 
        <b>RS.<?php echo $invoice_value_val; ?></b>  as <?php echo $claim_amount ?>% 
         as of the bill amount <?php if ($bg_num == 'NA') { ?> and details are as follows.<?php } ?><?php if ($bg_num != 'NA') { ?>and the details are as follows BG Enclosed.<?php } ?>
        </p>
    </div>
    <div class="part1" style="margin:0px 60px;">
      <table id="print_table" class="table table-bordered nowrap table-striped align-middle">
        <thead>
          <tr>
            <th>S.No</th>
            <!-- <th>Installation Ref No</th> -->
             <th>Consignee Address</th>
            <th>Supplier Invoice Ref</th>
            <th>Qty</th>
            <th>Invoice No</th>
            <th>Claim Amt</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($result_values_data  as $key => $form_val) {
            $invoice_no = explode(",", $form_val['invoice_no']);
            $invoice_no_string = implode("','", $invoice_no);
            // $where1 = "bill_no = '".$form_val['bill_no']."' AND invoice_no IN('" . $invoice_no_string ."')";
            $where1 = "invoice_no IN('" . $invoice_no_string . "')  and  bill_no='" . $bill_no . "'";
            // print_r( $where1);
            $table1      =  "view_elcot_list";
            $columns1    = [
              "bill_no",
              "invoice_qty",
              "invoice_no",
              // "installation_reference_no",
              "con_address",
              "supplier_invoice_number",
              "bill_form_unique_id",
              "invoice_value",
              "claim_amount",
            ];
            $table_details1   = [
              $table1,
              $columns1
            ];
            $values_elcot  = $pdo->select($table_details1, $where1);
            // $invoice_value= $values_elcot['invoice_value'];
            // print_r($values_elcot);die();
            if ($values_elcot->status) {
              // $invoice_val= sum($invoice_value);
              $elcot_array      = $values_elcot->data;
              foreach ($elcot_array as $key => $elcot) {
                $s_no = $sno + 1;
                $claim_amount = $elcot['claim_amount'];
                $invoice_val         =  $elcot['invoice_value'];
                $invoice_value =  $invoice_val * ($claim_amount / 100);
                $elcot['invoice_value'] = moneyFormatIndia1(($invoice_value));

          ?>
                <tr>
                  <td><?php echo $s_no ?></td>
                  <!-- <td><?php echo $con_address ?></td> -->
                   <td><?php echo $elcot['con_address'] ?></td>
                  <!-- <td><?php echo $elcot['installation_reference_no'] ?></td> -->
                  <td><?php echo $elcot['supplier_invoice_number'] ?></td>
                  <td><?php echo $elcot['invoice_qty'] ?></td>
                  <td><?php echo $elcot['invoice_no'] ?></td>
                  <td><?php echo $elcot['invoice_value'] ?></td>
                </tr>
          <?php
                $sno++;
                $total +=   $invoice_value;
              }
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th id="total"  colspan="5" ><b>TOTAL</b></th>
            <!-- <th id="total" colspan="5" align="center"><b>TOTAL</b></th> -->
            <td><b><?php echo moneyFormatIndia1($total)?></b></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="part1">
      <p>We enclosed necessary documents for the above bill and we assure you that we will co-operate with your esteemed organization in future assignments.</p>
      <h5 style="text-align: center;margin-top:.625rem;">Thank You</h5>
    </div>
    <div class="part1">
      <p>Yours truly</p>
      <P>For Ascent e-Digit Solutions (P) Ltd.,</P>
      <br>
      <br>
      <p>Authorized Signatory</p>
    </div>
  </div>
  <div class="card-footer" style="text-align:center; position:fixed;bottom:0;left:40px;">
    <h5 style="font-size: 13px;text-align:center">Bangalore | Coimbatore | Delhi | Erode | Hyderabad | Madurai | Mumbai | Pune | Salem | Trichy | Tirunelveli | Vijayawada</h5>
  </div>
</div>
<script>
  $(document).ready(function() {
    // print_header_and_footer()
    setTimeout(function() {
      window.print();
    }, 1000);
  });
</script>
<style>
  @media print {
    @page {
      margin: 0;
    }
  }
</style>
