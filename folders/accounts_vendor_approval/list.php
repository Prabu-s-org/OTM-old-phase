<style>
  i.fa.fa-edit {
    font-size: 20px;
    color: green;
  }

  i.fa-sharp.fa-solid.fa-trash {
    font-size: 20px;
    color: green;
  }

  button#export {
    float: right;
    padding: 5px 10px;
  }

  table.dataTable.nowrap td {
    white-space: unset;
  }

  span.po_date {
    white-space: nowrap;
  }

  .field-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .label-col {
    width: 150px;
    font-weight: 500;
    font-size: 15px;
  }

  .colon-col {
    width: 10px;
  }

  .value-col {
    flex: 1;
  }


  .custom-wide-modal {
    max-width: 85vw;
    width: 80vw;
  }
  
  .detail-row {
    display: flex;
    margin-bottom: 8px;
  }
  .detail-label {
    width: 130px; /* fixed width for label */
    font-weight: 500;
  }
  .detail-colon {
    width: 10px; /* width for colon */
    text-align: center;
  }
  .detail-value {
    flex: 1; /* remaining space for value */
    color: #506018;
    font-weight: 600;
    display: flex;
    align-items: center;
  }
  .detail-value i {
    margin-right: 5px;
  }
</style>
<?php
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641adb14666c465380';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];


?>

<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Payment Transaction Form</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">
       

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li> -->
          <li class="breadcrumb-item ">Vendor Payment</li>
          <li class="breadcrumb-item active">Payment Transaction Form</li>
        </ol>
      </div>

    </div>
  </div>
</div>
<!-- end page title -->


<!----content start---------->
<div class="col-xxl-12">
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
            <span class="d-none d-sm-block">Payment Pending</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
            <span class="d-none d-sm-block">Payment Approved</span>
          </a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content ">
        <div class="tab-pane active" id="arrow-overview" role="tabpanel">
          <div class="row">
            <div class="row" id="list">
              <div class="table-responsive">
                <table id="vendorpayment_datatable" class="pt-2 table table-bordered nowrap table-striped align-middle">
                  <thead>
                    <tr>
                      <th style="text-align: center;">S.No</th>
                     <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
                      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>
                      <th style="text-align: center;">Vendor Name</th>
                      <th style="text-align: center;">Total Amount</th>
                       <th style="text-align: right;">Tds Deduction</th>
                      <th style="text-align: right;">other Deduction</th>
                        <th style="text-align:center;">Advance Amount</th>
                      <th style="text-align: center;">Total Payble Amount</th>
                      <th style="text-align:center;">Vendor Approved By/ Date</th>
                     <th style="text-align:center;">Accounts Approved By /Date</th>
                     <th style="text-align:center;">Management Approved By /Date</th>
                      <th style="text-align: center;">Remark</th>
                      <th style="text-align: center;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="arrow-contact" role="tabpanel">
           <div class="table-responsive">
          <table id="vendorpayment_datatable_processed" class="table table-bordered table-striped align-middle">
           
              <thead>
                <tr>
                  <th style="text-align: center;">S.No</th>
                  <!-- <th style="text-align: center;">Bill Date</th>
                  <th style="text-align: center;">Bill No</th> -->
                    <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
            <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>

                  <th style="text-align: center;">Vendor Name</th>
                  <th style="text-align: center;">Total Amount</th>
                    <th style="text-align: right;">Tds Deduction</th>
                      <th style="text-align: right;">other Deduction</th>
                   <th style="text-align:center;">Advance Amount</th>

                      <th style="text-align: center;">Total Payble Amount</th>
                   <th style="text-align: center;"> Transaction Type </th>
                   <th style="text-align: center;"> Transaction ID/ Date</th>
                    <th style="text-align: center;">Cash Attach File</th>
                  <!-- <th style="text-align: center;">Payment</th> -->
                  <th style="text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end card-body -->


<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content shadow-lg rounded-4 border-0">
      <!-- <div class="modal-header bg-success text-white rounded-top"> -->
      <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">
          Payment  Approval</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">

          <!-- DC Details Card -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

              <div class="row">
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor Details
                  </h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_com_name_popup_1"></span></strong><br><strong><span id="vendor_name_popup_1"></span></strong>
                  </h6>
                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="address"></span>
                  </p>
                  <p class="mb-1">
                    GST No: <b><span id="gst_no_popup_1"></span></b>, PAN No: <b><span id="pan_no_popup_1"></span></b>
                  </p>
                  <p class="mb-1">
                    <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                    <span id="mail_popup_1"></span>
                  </p>
                  <p class="mb-1">
                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                    <span id="contact"></span>
                  </p>
            </br>
          </br>
          <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Invoice Details</h6>
              <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id_1"></span></strong></h6>
              <p class="mb-1">
                <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                <b><span id="ven_inv_date_1"></span></b>
              </p>
               <!-- <p class="mb-1">
                    <h6 style="width:15px; height:15px; color:#506018">Invoice Attach</h6>
                    <b><span id="ven_inv_attach_1"></span></b>
                  </p> -->
                   <p class="mb-1">
                  <b>Invoice Attach: <span id="ven_inv_attach_1"></span></b>
</p>


                </div>

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bill
                    Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="bill_date"></span></b>
                  </p>
                </div>

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bank
                    Details</h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bank_name_popup_1"></span></strong>
                  </h6>

                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="bank_branch_popup_1"></span>
                  </p>
                  <p class="mb-1">
                    Account No: <b><span id="acc_no_popup_1"></span></b>
                  </p>
                  <p class="mb-1">
                    IFSC Code: <b><span id="ifsc_popup_1"></span></b>
                  </p>
                   <div class="detail-row">
                    <div class="detail-label">Account Holder</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="acc_holder_popup_1"></div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label">PAN Copy</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="pan_popup_1"></div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label">Bank Proof</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="bank_popup_1"></div>
                  </div>
                </div>

                <div class="col-md-4">
                </div>
                <div class="col-md-4" style="margin-top:-100px">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Payment
                    Details</h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="transaction_type_1"></span></strong>
                  </h6>
                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <span id="transaction_date_1"></span>
                  </p>
                     <p class="mb-1">
                    <i style="width:15px; height:15px; color:#506018">Transaction Id</i>
                    <span id="transaction_id_1"></span>
                  </p>
                   <p class="mb-1">
                    <!-- <i style="width:15px; height:15px; color:#506018">Cash Receipt</i> -->
                     <span id="">Cash Receipt</span>
                    <span id="cash_receiptile"></span>
                  </p>
                  
                  <!-- <p class="mb-1">
                    Account No: <b><span id="acc_no_popup_1"></span></b>
                  </p>
                  <p class="mb-1">
                    IFSC Code: <b><span id="ifsc_popup_1"></span></b>
                  </p>
                   <div class="detail-row">
                    <div class="detail-label">Account Holder</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="acc_holder_popup_1"></div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label">PAN Copy</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="pan_popup_1"></div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label">Bank Proof</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value" id="bank_popup_1"></div>
                  </div> -->
                </div>

              </div>
            </div>
          </div>

          <input type="hidden" name="po_num" id="po_num">
          <input type="hidden" name="vendor_name" id="vendor_name">

          <!-- Vendor Table -->
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <h6 class="mb-3 fw-semibold text-success" style="color: #506018 !important;"><i class="bi bi-table"></i>
                Vendor Payment Table</h6>
              <div class="table-responsive">
                <table id="vendor_datatable" class="table table-bordered table-striped table-hover align-middle">
                  <tbody>

                    <thead>
                      <tr>
                        <th style="text-align:center;">S.No</th>
                        <th style="text-align:center;">PO No. / Date</th>
                        <th style="text-align:center;">Invoice No / Date</th>
                        <th style="text-align:center;">Invoice Qty</th>
                        <th style="text-align:center;">DC No / Date</th>
                        <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Basic amount</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">GsT Amount</th>
                        <th style="text-align:center;">Total Amount</th>

                      </tr>
                    </thead>
                  </tbody>

                </table>
              </div>
            </div>
            <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">
<div class="row mt-2" style="margin: 0 15px;">
  <!-- Left Column: Approved Info -->
  <div class="col-md-6">
    <div class="mb-2 d-flex">
      <div class="me-4">
        <span class="fw-bold">Approved By:</span>
        <span id="approver" class="text-success fw-bold" style="color: #506018 !important; font-size:15px;">Prabu</span>
      </div>
      <div>
        <span class="fw-bold">Approved Date:</span>
        <span id="approvedate" class="text-success fw-bold" style="color: #506018 !important; font-size:15px;">11-10-2025</span>
      </div>
    </div>
  </div>

  <!-- Right Column: Amounts -->
  <div class="col-md-6">
    <div class="d-flex justify-content-between mb-1">
      <div><strong>Total Amount:</strong></div>
      <div id="ttl_span_amnt" class="text-success fw-bold" style="color:#506018 !important; font-size:17px;">₹ 64,901.18</div>
    </div>
    <div class="d-flex justify-content-between mb-1">
      <div><strong>TDS Deduction:</strong></div>
      <div id="ttl_tds_amnt" class="text-success fw-bold" style="color:#506018 !important; font-size:15px;">100</div>
    </div>
    <div class="d-flex justify-content-between mb-1">
      <div><strong>Other Deduction:</strong></div>
      <div id="ttl_others_amnt" class="text-success fw-bold" style="color:#506018 !important; font-size:15px;">200</div>
    </div>
     <div class="d-flex justify-content-between mb-1">
      <div><strong>Advance Amount:</strong></div>
      <div id="advanceamt1" class="text-success fw-bold" style="color:#506018 !important; font-size:15px;">200</div>
    </div>
     <!-- <th style="text-align:center;">Advance Amount</th> -->
    <div class="d-flex justify-content-between mb-1">
      <div><strong>Total Payable Amount:</strong></div>
      <div id="ttl_payble_amnt" class="text-success fw-bold" style="color:#506018 !important; font-size:15px;">₹ 64,601.18</div>
    </div>
  </div>

  <!-- Full-Width Row: Amount in Words -->
  <div class="col-md-12 mt-2 d-flex justify-content-end">
    <div>
      <strong>Total Amount In Words:</strong>
      <span id="ttl_span_amnt_words" class="text-success fw-bold" style="color: #506018 !important; font-size:15px;">Sixty-Four Thousand Six Hundred One Only</span>
    </div>
  </div>
</div>

              <!-- Approved Date and Total Amount (same row) -->
            
              <!-- Close Button -->
              <div class="form-group row">
                <div class="col-md-12 pt-2 pb-2 text-end">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

  $(document).on('click', '.view-btn', function () {
    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');

    var mail = $(this).data('vendor-mail');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');

    var ttl_amount = $(this).data('ttl-amount');

    var vendor_name = $(this).data('vendor-name');


   var acctdsvalue = $(this).data('acctdsvalue');
    var accotherdeduction = $(this).data('accotherdeduction');
    var acctotalpaybleamount = $(this).data('acctotalpaybleamount');
     var cash = $(this).data('cash');
     var transaction_id_1 = $(this).data('transaction_id');
     var advancepayment = $(this).data('advancepayment');

     
// console.log(transaction_id_1);

//  varif() transaction_id_1 = response.transaction_id; // from your AJAX or data source
if(transaction_id_1==""){
$('#transaction_id_1').text( "N/A");

  }
  else{
$('#transaction_id_1').text(transaction_id_1);

  }

if (cash) {
    var fileUrl = "/otm_beta/uploads/accounts_approval/" + cash;
    var extension = cash.split('.').pop().toLowerCase();

    // Check if the file is an image
    var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    var html = '';

    if (imageExtensions.includes(extension)) {
        // Show image preview
        html = '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
                   '<img src="' + fileUrl + '" height="30px" width="30px" alt="Preview Image">' +
               '</a>';
    } else if (extension === 'pdf') {
        // Show PDF icon
        html = '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
                   '<img src="uploads/accounts_approval/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
               '</a>';
    } else {
        // Unknown file type
        html = '<a href="' + fileUrl + '" target="_blank">View File</a>';
    }

    $('#cash_receiptile').html(html);
} else {
    $('#cash_receiptile').text('N/A');
}

    // $('#approve
// Populate modal header
    $('#ttl_tds_amnt').text( '₹ ' +acctdsvalue );
    $('#ttl_others_amnt').text( '₹ ' +accotherdeduction);
    $('#ttl_payble_amnt').text( '₹ ' +acctotalpaybleamount);


    // Populate modal header
    $('#bill_no').text(bill_no);
    $('#bill_date').text(bill_date);
    $('#approver').text(approver);
    $('#approvedate').text(approvedate);

    $('#mail').text(mail);
    $('#contact').text(contact);
    $('#address').text(address);

// advanceamt1
    $('#vndr_name').text(vendor_name);

    $('#advanceamt1').text(advancepayment);


$('#ttl_span_amnt_words').text(numberToWords(acctotalpaybleamount));
      // $('#ttl_tds_amnt').text('₹ ' + (firstRow.acctdsvalue || '0'));
      //       $('#ttl_others_amnt').text('₹ ' + (firstRow.accotherdeduction || '0'));
      //       $('#ttl_payble_amnt').text('₹ ' + (firstRow.acctotalpaybleamount || '0'));


    // $('#ttl_span_amnt').text(ttl_amount);

    // $('#ttl_span_amnt').text('₹ '+ Math.round(ttl_amount).toLocaleString('en-IN'));

    $('#ttl_span_amnt').text(
      '₹ ' + parseFloat(ttl_amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })
    );

    $('#viewModal').modal('show');

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        vendor_id: vendor,
        action: 'bill_summary_popup'
      },
      success: function (response) {
        var res = JSON.parse(response);
        console.log(res.summary_data);
        if (res.status && res.summary_data) {
          $('#vendor_name_popup_1').text(res.summary_data.name || '-');
          $('#vendor_com_name_popup_1').text(res.summary_data.company_name || '-');
          $('#mail_popup_1').text(res.summary_data.mail_id || '-');
          $('#gst_no_popup_1').text(res.summary_data.gst_no || '-');
          $('#pan_no_popup_1').text(res.summary_data.pan_no || '-');
          $('#contact_no_popup_1').text(res.summary_data.contact_no || '-');
          $('#address_popup_1').text(res.summary_data.address || '-');
          $('#bank_name_popup_1').text(res.summary_data.bank_name || '-');
          $('#bank_branch_popup_1').text(res.summary_data.branch_name || '-');
          $('#acc_no_popup_1').text(res.summary_data.account_no || '-');
          $('#ifsc_popup_1').text(res.summary_data.ifsc_code || '-');
             $('#acc_holder_popup_1').text(res.summary_data.acc_holder_name || '-');
          // $('#pan_popup_2').text(res.summary_data.pan_attach_file_name || '-');
           
// PAN File
if (res.summary_data.pan_attach_file_name) {
    var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
    $('#pan_popup_1').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Preview PAN PDF">' +
        '</a>'
    );
} else {
    $('#pan_popup_1').text('N/A');
}

// Bank Proof
if (res.summary_data.bank_proof) {
    var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
    $('#bank_popup_1').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Preview Bank PDF">' +
        '</a>'
    );
} else {
    $('#bank_popup_1').text('N/A');
}
         
        } else {
          alert('No vendor data found.');
        }
      }
    });

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        vendor: vendor,
        action: 'vendor_payment_details'
      },
      success: function (res) {
        // var res = JSON.parse(response);

     if (res.data && res.data.length > 0) {
  const firstRow = res.data[0];  // Use this for TDS, deductions, payable, invoice_no
  // console.log(firstRow.cash);
  // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
        $('#ven_inv_date_1').text(firstRow.vendor_inv_attach_approval_date || '-');

        $('#ven_inv_id_1').text(firstRow.veninvverifyid || '-');

 // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
if (firstRow.inv_verfiy_attach) {
    var fileUrl = "/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
    $('#ven_inv_attach_1').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
        '</a>'
    );
} else {

    $('#ven_inv_attach_1').text('N/A');
}

  let tra = '';
  if (firstRow.transaction_type =='1') {
    tra = 'Cash';
  } else if (firstRow.transaction_type == '2') {
    tra = 'Bank';
  } else if (firstRow.transaction_type == '3') {
    tra = 'UPI';
  }


  $('#transaction_type_1').text(tra);
  $('#transaction_date_1').text(firstRow.transaction_date || "");
  $('#transaction_id_1').text(firstRow.transaction_id  || "");

          let tableHtml = '';
          res.data.forEach((row, index) => {
            tableHtml += `
            <tr>
              <td>${index + 1}</td>
              <td>${row.po_num}</td>
              <td>${row.invoice_no}</td>
              <td>${row.invoice_qty}</td>
              <td>${row.dc_num}</td>
              <td>${row.rate}</td>
      <td style="text-align:right;">${row.basicamt || 0}</td>

              <td>${row.gst}</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

              <td>${row.amount}</td>
            </tr>
          `;
          });
          // <td>${row.dc_date}</td>

          $('#vendor_datatable tbody').html(tableHtml);

          // updateTotalAmount();
        } else {
          $('#vendor_datatable tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
        }
      },
      error: function () {
        alert('Failed to fetch details');
      }
    });
  });
 function numberToWords(num) {
            const ones = [
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                'Seventeen', 'Eighteen', 'Nineteen'
            ];

            const tens = [
                '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
                'Eighty', 'Ninety'
            ];

            // Scales for Indian numbering system (Thousand, Lakh, Crore)
            const scales = ['', 'Thousand', 'Lakh', 'Crore'];

            // Helper function to convert a two or three-digit number to words
            function convertLessThanOneThousand(n) {
                let words = '';
                if (n >= 100) {
                    words += ones[Math.floor(n / 100)] + ' Hundred ';
                    n %= 100;
                }
                if (n < 20) {
                    words += ones[n];
                } else {
                    words += tens[Math.floor(n / 10)];
                    if (n % 10 > 0) {
                        words += ' ' + ones[n % 10];
                    }
                }
                return words.trim();
            }

            // Convert number to string and split into rupees and paise
            // Use Math.round for better precision with floating-point numbers
            const numStr = (Math.round(parseFloat(num) * 100) / 100).toFixed(2).toString();
            const [rupeesStr, paiseStr] = numStr.split('.');
            let rupees = parseInt(rupeesStr);
            const paise = parseInt(paiseStr);

            let result = '';

            // Convert rupees part
            if (rupees === 0) {
                result = 'Zero Rupees';
            } else {
                let rupeesWords = [];
                let scaleIndex = 0; // Represents the index for scales array

                // Handle negative numbers (optional, but good practice)
                if (rupees < 0) {
                    result += 'Minus ';
                    rupees = Math.abs(rupees);
                }

                // Process number in groups of 2 for Lakhs/Crores, and 3 for Thousands
                // Indian numbering system: last three digits (hundreds, tens, ones), then groups of two
                // e.g., 1,23,45,678 -> 1 Crore, 23 Lakh, 45 Thousand, 678

                // Handle the first three digits (0-999)
                if (rupees % 1000 !== 0) {
                    rupeesWords.unshift(convertLessThanOneThousand(rupees % 1000));
                }
                rupees = Math.floor(rupees / 1000);
                scaleIndex++; // Now we are at 'Thousand' scale

                while (rupees > 0) {
                    let chunk;
                    if (scaleIndex === 1) { // For Thousands, it's a group of 2 (tens and ones of thousands)
                        chunk = rupees % 100;
                        rupees = Math.floor(rupees / 100);
                    } else { // For Lakhs and Crores, it's a group of 2
                        chunk = rupees % 100;
                        rupees = Math.floor(rupees / 100);
                    }

                    if (chunk > 0) {
                        let chunkWords = convertLessThanOneThousand(chunk);
                        if (scales[scaleIndex]) { // Add scale only if it exists
                            chunkWords += ' ' + scales[scaleIndex];
                        }
                        rupeesWords.unshift(chunkWords);
                    }
                    scaleIndex++;
                }

                result = rupeesWords.join(' ').trim() + ' Rupees';
            }

            // Convert paise part
            if (paise > 0) {
                let paiseWords = convertLessThanOneThousand(paise);
                if (paiseWords) { // Only add if paiseWords is not empty
                    result += ' and ' + paiseWords + ' Paise';
                }
            } else if (paise === 0 && numStr.includes('.')) {
                // If there's a decimal part but paise is 0, add "Zero Paise"
                // This handles cases like 100.00 where we still want "Zero Paise"
                result += ' and Zero Paise';
            }

            return result.trim();
        }

</script>
