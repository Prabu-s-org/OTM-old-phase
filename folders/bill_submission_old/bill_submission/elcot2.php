<style>
 .card-body.print_table p {
    margin-bottom: .375rem;
    margin: 0px 60px;
    /* border: 2px solid #000000; */
    /* margin-right:80px; */
    /* margin: 5% auto; */
  }

  .part1 {
    /* margin-bottom: 1.75rem; */
    /* margin-bottom: 20px; */
    margin-top: 30px; 

  }

  table.print-tabe {
    border-collapse: collapse;

    width: 100%;
  }

  table.print-tabe tr th,
  td {
    /* border: .0625rem solid #dddddd;
     */
    border: 2px solid #000000;
    text-align: left;
    padding: .375rem;
    /* font-weight: bold; */
    /* background: white; */
    /* text-wrap: nowrap; */
    /* font-weight:bold; */
    /* margin-left: 100px; */
    /* margin-left:121px; */
  }

  /* table.print-table tbody {
  background-color: white;
} */
  #total {
    text-align: right;
    /* margin-right: 50px; */

  }

  body {
    background-color: #fff !important;
  }

  .card-header {
    display: flex;
    justify-content: flex-end;/
  }
  .card-footer {
    text-align: center;
    position: fixed;
    bottom: 0px;
    left: 0;
    right: 0;
    margin: 0px auto;
  }

  .card-header img {
    width: 45%;
    margin-top: -20px;
    position: absolute;
    top: 10px;
  }

  img#sign {
    text-align: center;
    align-items: center;
  margin: 0px 100px;
    width: 95px;
 }

  img#seal {
    text-align: center;
    align-items: center;
    max-width: 110px;
    /* width: 50px; */
  }
  #pro td, #pro th {
    border: 1px solid darkblue; 
    padding: 3px; 
    width: 190px;  /* Adjust the width */
   
    color: darkblue; 
    font-size: 20px; 
    line-height: 0; 
}

#pro label {
    color: darkblue; /* Dark blue color for the labels */
    font-weight: bold;
    font-size: 11px; /* Smaller font size for labels */
    padding: 2px; 
}
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
      "(SELECT supplier_invoice_number FROM bill_submission_form WHERE bill_submission_form.invoice_no =
      " . $table_sub . ".invoice_no group by  bill_form_main_unique_id) AS supplier_invoice_number",
      // "(select claim_amount from sign_doc_verification_detail as sign sign.invoice_no IN ('$table_sub'.invoice_no)) as claim_amount",
      // "'' as claim",
      // "(SELECT supplier_invoice_number FROM bill_submission_form WHERE bill_submission_form.invoice_no =
      // " . $table_sub . ".invoice_no ) AS supplier_invoice_number",
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
      $supplier_invoice_number = $result_values_data[0]['supplier_invoice_number'];


      // $invoice_value_val= $invoice_value * ($claim_amount / 100);
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
    <!-- <img src="assets/images/elcot_header.jpeg" style="width: 100%;"> -->
    <img src="assets/images/elcot_header1.png">

  </div>
  <div class="card-body print_table">
  <div class="row">
<div class="col-md-12">
<div class="part1">
  <p>Chennai,</p>
    <P> <?php echo $formattedDate ?></P>
  </div>
</div>
</div>
<div class="row">
<div class="col-sm-6">

    <!-- <div class="part1">
      <p>Chennai,</p>
      <P> <?php echo $formattedDate ?></P>
    </div> -->
    <div class="part1">
      <p><b>To</b></p>
      <p>The Managing Director </p>
      <p>Electronics Corporation of Tamilnadu Ltd.,</p>
      <p>No 692,MHU Complex,</p>
      <p>Anna Salai,Nandanam,</p>
      <p>Chennai 600 035</p>
    </div>

    </div>
    <div class="col-sm-2"></div>
<div class="col-sm-4">
    <table id="pro">
  <tr>
      <td style="width: 100%; text-align: center;"><label for="elcot">ELCOT PROCUREMENT BILLS</label></td>
    </tr>
    <tr>
      <td><label for="no">No:
        <span style="color: black;">
        <?php 
         echo substr($supplier_invoice_number, -5); ?>
         </span>
      </label></td>
    </tr>
    <tr>
      <td><label for="date">Date:
        <span style="color: black;">
        <?php 
          echo $formattedDate; 
            ?>
            </span>
      </label>
    </td>
      </tr>
    <tr>
      <td><label for="received-by">Received By:</label></td>
  </tr>
    <tr>
      <td><label for="signature">Signature:</label></td>
      </tr>
  </table>
  </div>
</div>
    <div class="part1">
      <P><b>Respected Sir,</b> </P>
      <p>Sub: Submission of bills-Reg.</p>
    </div>
    <div class="part1">
      <!-- <p>We are pleased to submit the bills for the supply of Department & Others. 
        <b><?php echo $po_num; ?></b> Date:<b> <?php echo $podate; ?> </b>
        therefore, we request your good self to kindly release 
        <b>RS.<?php echo $invoice_value_val; ?></b>  as <?php echo $claim_amount ?>% 
         as of the bill amount <?php if ($bg_num == 'NA') { ?> and details are as follows.<?php } ?><?php if ($bg_num != 'NA') { ?>and the details are as follows BG Enclosed.<?php } ?>
        </p> -->
        <p>
        With reference to the Purchase Order Number
        <b><?php echo $po_num; ?> </b>dated<b> <?php echo $podate; ?> </b>
        ,we are pleased to submit the bills for the below-mentioned
       Invoices to the <b><?php echo $department ?></b> for the value of
        Rs <b><?php echo $invoice_value_val; ?></b> as a <b><?php echo $claim_amount ?>%</b> claim.
</p>
    </div>
    <div class="part1" style="margin:0px 60px;">
    <table id="print_table" class="table table-bordered nowrap table-striped align-middle" style="border: black" ;>
        <thead style="border: black" ;>
          <tr style="background-color:white;">
            <th>S.No</th>
            <th>Installation Ref No</th>
             <!-- <th>Consignee Address</th> -->
            <th>Supplier Invoice Ref</th>
            <th>Qty</th>
            <th>Invoice No</th>
            <th>Claim Amt <?php echo $claim_amount ?>%</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($result_values_data  as $key => $form_val) {
            $invoice_no = explode(",", $form_val['invoice_no']);
            $invoice_no_string = implode("','", $invoice_no);
            sort($invoice_no);
            // $where1 = "bill_no = '".$form_val['bill_no']."' AND invoice_no IN('" . $invoice_no_string ."')";
            $where1 = "invoice_no IN('" . $invoice_no_string . "')  and  bill_no='" . $bill_no . "' ORDER BY 
  CAST(SUBSTRING_INDEX(invoice_no, '/', -1) AS UNSIGNED) ASC;";
            // print_r( $where1);
            $table1      =  "view_elcot_list";
            $columns1    = [
              "bill_no",
              "invoice_qty",
              "invoice_no",
              "installation_reference_no",
              // "con_address",
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

                // $elcot['invoice_value'] = $elcot['invoice_value'] * ($claim_amount / 100);
                $invoice_val         =  $elcot['invoice_value'];
                $invoice_value =  $invoice_val * ($claim_amount / 100);
                $elcot['invoice_value'] = moneyFormatIndia1($invoice_value);
                // $elcot['invoice_value'] = number_format($money, 2, '.', ''); 
                
          ?>
                <tr>
                  <td><?php echo $s_no ?></td>
                
                   <!-- <td><?php echo $elcot['con_address'] ?></td> -->
                  <td><?php echo $elcot['installation_reference_no'] ?></td>
                  <td><?php echo $elcot['supplier_invoice_number'] ?></td>
                  <td><?php echo $elcot['invoice_qty'] ?></td>
                  <td><?php echo $elcot['invoice_no'] ?></td>
                  <td><?php echo $elcot['invoice_value'] ?></td>
                </tr>
          <?php
                $sno++;
                $total +=  $invoice_value;
              }
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th id="total" colspan="5"><b>TOTAL</b></th>
            <td><b><?php echo moneyFormatIndia1($total) ?></b></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="part1">
      <p>We enclosed necessary documents for the above bill and we assure you that we will co-operate with your esteemed organization in future assignments.</p>
      <h5 style="text-align: center;margin-top:.625rem;">Thank You</h5>
    </div>
    <div class="part1">
     <div class="row">
      <div class="col-5">
      <P style="margin-right:0px;">For Ascent e-Digit Solutions (P) Ltd.,</P>
      <img src="assets/images/sign.png" id="sign">
      <p>Authorized Signatory</p>
      </div>
      <div class="col-4" >
      <img src="assets/images/seal.png" id="seal" style="margin-left: -33px;
    margin-top: -14px;">
<!-- margin-left: -33px;
margin-top: -14px; -->
     
    </div>
     </div>
    </div>
  </div>
  <div class="card-footer">
      <h5 style="font-size: 13px;text-align:center">Bangalore | Coimbatore | Delhi | Erode | Hyderabad | Madurai |
        Mumbai
        | Pune | Salem | Trichy | Tirunelveli | Vijayawada</h5>
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
