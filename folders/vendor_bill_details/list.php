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
      <h4 class="mb-sm-0">Bill Details</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li> -->
          <li class="breadcrumb-item ">Vendor Payment</li>
          <li class="breadcrumb-item active">Bill Details</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!----content start---------->
<div class="col-xxl-12">
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
            <span class="d-none d-sm-block">Pending</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
            <span class="d-none d-sm-block">Completed</span>
          </a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content ">
        <div class="tab-pane active" id="arrow-overview" role="tabpanel">
          <div class="row">
            <div class="row" id="list">
              <div class="table-responsive">
                <table id="vendorpayment_datatable" class="table table-bordered table-striped align-middle">
                  <thead>
                    <tr>
                      <th style="text-align: center;">S.No</th>
                      <th style="text-align: center;">Bill Date</th>
                      <th style="text-align: center;">Bill No</th>
                      <th style="text-align: center;">Vendor Name</th>
                      <th style="text-align: center;">Amount</th>
                      <th style="text-align: center;">Finance</th>
                      <th style="text-align: center;">Account</th>
                      <th style="text-align: center;">Action</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="arrow-contact" role="tabpanel">
          <table id="vendorpayment_datatable_completed" class="table table-bordered table-striped align-middle">
            <div class="table-responsive">
              <thead>
                <tr>
                  <th style="text-align: center;">S.No</th>
                  <th style="text-align: center;">Bill Date</th>
                  <th style="text-align: center;">Bill No</th>
                  <th style="text-align: center;">Vendor Name</th>
                  <th style="text-align: center;">Amount</th>
                  <th style="text-align: center;">Finance</th>
                  <th style="text-align: center;">Account</th>
                  <th style="text-align: center;">Action</th>
              </thead>
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
          Bill details</h5>
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

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_name_popup_1"></span></strong>
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
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">Amount</th>
                      </tr>
                    </thead>
                  </tbody>

                </table>
              </div>
            </div>
            <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">

            <div class="row mt-2" style="margin:0 15px">
              <div class="col-md-12 d-flex justify-content-end align-items-center">
                <label class="me-2 mb-0">Total Amount:
                  <span id="ttl_span_amnt" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount" class="form-control d-inline"
                    style="width: 200px; display: inline;" readonly>
                </label>
              </div>
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

<div class="modal fade" id="viewModal-2" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">
          Bill Approved</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">

          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

              <div class="row">
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor Details
                  </h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_name_popup_2"></span></strong>
                  </h6>
                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="address_2"></span>
                  </p>
                  <p class="mb-1">
                    GST No: <b><span id="gst_no_popup_2"></span></b>, PAN No: <b><span id="pan_no_popup_2"></span></b>
                  </p>
                  <p class="mb-1">
                    <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                    <span id="mail_popup_2"></span>
                  </p>
                  <p class="mb-1">
                    <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                    <span id="contact_2"></span>
                  </p>
                </div>

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bill
                    Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_2"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="bill_date_2"></span></b>
                  </p>
                </div>

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bank
                    Details</h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bank_name_popup_2"></span></strong>
                  </h6>

                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="bank_branch_popup_2"></span>
                  </p>
                  <p class="mb-1">
                    Account No: <b><span id="acc_no_popup_2"></span></b>
                  </p>
                  <p class="mb-1">
                    IFSC Code: <b><span id="ifsc_popup_2"></span></b>
                  </p>
                </div>

                <hr class="mt-3 mb-3">

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Transaction
                    Details</h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span
                        id="transaction_amount_label"></span></strong>
                  </h6>

                  <div id="row_transaction_type" class="mb-1">
                    Transaction Type:
                    <strong><span id="transaction_type_label"></span></strong>
                  </div>

                  <div id="row_transaction_date" class="mb-1">
                    Transaction Date:
                    <strong><span id="transaction_date_label"></span></strong>
                  </div>

                  <div id="row_online_type" class="mb-1">
                    Online Method:
                    <strong><span id="online_type_label"></span></strong>
                  </div>

                  <div id="row_cash_receipt_file" class="mb-1" style="display:none;">
                    Receipt File(s):
                    <div id="cash_receipt_file_label" class="mt-2"></div>
                  </div>

                  <div id="row_transaction_id" class="mb-1">
                    Transaction ID:
                    <strong><span id="transaction_id_label"></span></strong>
                  </div>

                  <div id="row_upi_id" class="mb-1">
                    UPI ID:
                    <strong><span id="upi_id_label"></span></strong>
                  </div>

                  <div id="row_upi_mobile" class="mb-1">
                    Mobile No:
                    <strong><span id="upi_mobile_label"></span></strong>
                  </div>

                  <div id="row_bank_name" class="mb-1">
                    Bank Name:
                    <strong><span id="bank_name_label"></span></strong>
                  </div>

                  <div id="row_account_no" class="mb-1">
                    Account No:
                    <strong><span id="account_no_label"></span></strong>
                  </div>
                </div>


                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Finance
                    Approval</h6>

                  <p class="mb-1">
                    Approved By:
                    <strong style="color: #506018;"><span id="finance_approve_name"></span></strong>
                  </p>

                  <p class="mb-1">
                    Approved On:
                    <strong style="color: #506018;"><span id="finance_approve_date"></span></strong>
                  </p>

                </div>

                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Accounts
                    Approval</h6>

                  <p class="mb-1">
                    Approved By:
                    <strong style="color: #506018;"><span id="accounts_appove_name"></span></strong>
                  </p>

                  <p class="mb-1">
                    Approved On:
                    <strong style="color: #506018;"><span id="accounts_approve_date"></span></strong>
                  </p>

                </div>

              </div>
            </div>
          </div>
          <div class="row" style="margin:0 15px">
            <div class="form-group row">
              <div class="col-md-12 pt-2 pb-2 text-end">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                  <i class="bi bi-x-circle"></i> Close
                </button>
              </div>
            </div>
          </div>

          <input type="hidden" name="po_num" id="po_num">
          <input type="hidden" name="vendor_name" id="vendor_name">


        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.view-btn', function () {
    var po_num = $(this).data('ponum');
    var vendor = $(this).data('vendor');
    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');
    var ttl_amount = $(this).data('ttl-amount');
    var vendor_name = $(this).data('vendor-name');


    $('#bill_no').text(bill_no);
    $('#bill_date').text(bill_date);
    $('#approver').text(approver);
    $('#approvedate').text(approvedate);
    $('#contact').text(contact);
    $('#address').text(address);
    $('#vndr_name').text(vendor_name);

    $('#ttl_span_amnt').text(
      '₹ ' + parseFloat(ttl_amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })
    );

    document.getElementById("po_num").value = po_num;
    document.getElementById("vendor_name").value = vendor;

    $('#viewModal').modal('show');

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        vendor: vendor,
        action: 'vendor_payment_details'
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {
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
              <td>${row.gst}</td>
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

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        vendor_id: vendor,
        action: 'bill_summary_popup'
      },
      success: function (response) {
        var res = JSON.parse(response);
        console.log(res.summary_data);
        if (res.status && res.summary_data) {
          $('#vendor_name_popup_1').text(res.summary_data.name || '-');
          $('#mail_popup_1').text(res.summary_data.mail_id || '-');
          $('#gst_no_popup_1').text(res.summary_data.gst_no || '-');
          $('#pan_no_popup_1').text(res.summary_data.pan_no || '-');
          $('#contact_no_popup_1').text(res.summary_data.contact_no || '-');
          $('#address_popup_1').text(res.summary_data.address || '-');
          $('#bank_name_popup_1').text(res.summary_data.bank_name || '-');
          $('#bank_branch_popup_1').text(res.summary_data.branch_name || '-');
          $('#acc_no_popup_1').text(res.summary_data.account_no || '-');
          $('#ifsc_popup_1').text(res.summary_data.ifsc_code || '-');
        } else {
          alert('No vendor data found.');
        }
      }
    });
  });

  $(document).on('click', '.view-btn-2', function () {
    var po_num = $(this).data('ponum');
    var vendor = $(this).data('vendor');
    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');
    var ttl_amount = $(this).data('ttl-amount');
    var vendor_name = $(this).data('vendor-name');


    $('#bill_no_2').text(bill_no);
    $('#bill_date_2').text(bill_date);
    $('#approver_2').text(approver);
    $('#approvedate_2').text(approvedate);
    $('#contact_2').text(contact);
    $('#address_2').text(address);
    $('#vndr_name_2').text(vendor_name);

    $('#ttl_span_amnt_2').text(
      '₹ ' + parseFloat(ttl_amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      })
    );

    document.getElementById("po_num").value = po_num;
    document.getElementById("vendor_name").value = vendor;

    $('#viewModal-2').modal('show');

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        vendor_id: vendor,
        action: 'bill_summary_popup'
      },
      success: function (response) {
        var res = JSON.parse(response);
        console.log(res.summary_data);
        if (res.status && res.summary_data) {
          $('#vendor_name_popup_2').text(res.summary_data.name || '-');
          $('#mail_popup_2').text(res.summary_data.mail_id || '-');
          $('#gst_no_popup_2').text(res.summary_data.gst_no || '-');
          $('#pan_no_popup_2').text(res.summary_data.pan_no || '-');
          $('#contact_no_popup_2').text(res.summary_data.contact_no || '-');
          $('#address_popup_2').text(res.summary_data.address || '-');
          $('#bank_name_popup_2').text(res.summary_data.bank_name || '-');
          $('#bank_branch_popup_2').text(res.summary_data.branch_name || '-');
          $('#acc_no_popup_2').text(res.summary_data.account_no || '-');
          $('#ifsc_popup_2').text(res.summary_data.ifsc_code || '-');
        } else {
          alert('No vendor data found.');
        }
      }
    });

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        vendor_id: vendor,
        bill_no: bill_no,
        action: 'get_transaction_details'
      },

      success: function (response) {
        var res = JSON.parse(response);
        console.log(res.summary_data);

        if (res.status && res.summary_data) {
          const data = res.summary_data;

          // Display mappings
          const transactionTypeMap = {
            "1": "Cash",
            "2": "Bank",
            "3": "UPI"
          };

          const onlineTypeMap = {
            "1": "Google Pay",
            "2": "PhonePe",
            "3": "Paytm"
          };

          // Helper function to set text and show/hide row
          function showIfHasValue(rowId, labelId, value) {
            if (value && value.toString().trim() !== '') {
              $(`#${labelId}`).text(value);
              $(`#${rowId}`).show();
            } else {
              $(`#${rowId}`).hide();
            }
          }

          // Set all values conditionally
          $('#transaction_amount_label').text('₹ ' + data.total_amount || '-');
          showIfHasValue("row_transaction_type", "transaction_type_label", transactionTypeMap[data.transaction_type]);
          showIfHasValue("row_transaction_date", "transaction_date_label", data.transaction_date);
          showIfHasValue("row_online_type", "online_type_label", onlineTypeMap[data.upi_method]);
          showIfHasValue("row_transaction_id", "transaction_id_label", data.transaction_id);
          showIfHasValue("row_upi_id", "upi_id_label", data.upi_id);
          showIfHasValue("row_upi_mobile", "upi_mobile_label", data.upi_mobile_no);
          showIfHasValue("row_bank_name", "bank_name_label", data.bank_name);
          showIfHasValue("row_account_no", "account_no_label", data.account_no);

          showIfHasValue("row_accounts_approve_name", "accounts_appove_name", data.accounts_approved_by);
          showIfHasValue("row_accounts_approve_date", "accounts_approve_date", data.accounts_approved_date);
          showIfHasValue("row_finance_approve_name", "finance_approve_name", data.finance_approved_by);
          showIfHasValue("row_finance_approve_date", "finance_approve_date", data.finance_approved_date);

          // showIfHasValue("row_finance_approve_date", "finance_approve_date", data.cash_receipt_file_org);
          // showIfHasValue("row_finance_approve_date", "finance_approve_date", data.cash_receipt_file_name);

          const receiptFilesHtml = renderFileIcons("accounts_approval", data.cash_receipt_file_name, data.cash_receipt_file_org);
          if (receiptFilesHtml) {
            $('#cash_receipt_file_label').html(receiptFilesHtml);
            $('#row_cash_receipt_file').show();
          } else {
            $('#row_cash_receipt_file').hide();
          }

        } else {
          alert('No transaction data found.');
        }
      }

    });

  });


  document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById("select_all");

    // Event listener for "Select All" checkbox
    selectAll.addEventListener("change", function () {
      const checkboxes = document.querySelectorAll(".myCheck");
      checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
      });

      updateTotalAmount();
      // calculateGST();
    });

    // Event listener for individual checkboxes
    document.addEventListener("change", function (event) {

      let ttl_amount;
      // alert('test');
      if (event.target.classList.contains("myCheck")) {
        const checkboxes = document.querySelectorAll(".myCheck");
        const checkedBoxes = document.querySelectorAll(".myCheck:checked");

        selectAll.checked = (checkedBoxes.length === checkboxes.length);
        updateTotalAmount();

        // Uncheck "Select All" if any checkbox is unchecked
        if (checkedBoxes.length !== checkboxes.length) {
          selectAll.checked = false;
        } else {
          selectAll.checked = true;
        }
      }
    });

    function updateTotalAmount() {

      // alert('test');
      let total = 0;
      document.querySelectorAll(".myCheck:checked").forEach(checkbox => {
        const amount = parseFloat(checkbox.getAttribute('data-amnt')) || 0;
        // alert(amount);
        total += amount;
      });

      document.getElementById("ttl_amount").value = total.toFixed(2);
      document.getElementById("ttl_span_amnt").textContent = total.toFixed(2);

    }

  });

  function vendor_payment() {

    alert('ven');
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var vendor_name = $('#vendor_name').val();
    var ttl_amnt = $('#ttl_amount').val();

    // Collect all checked data first
    var checkedData = [];
    $(".myCheck:checked").each(function () {
      var checkbox = $(this);
      checkedData.push({
        "dc_no": checkbox.data("id"),
        "dc_date": checkbox.data("dcdate"),
        "po_num": checkbox.data("po-num"),
        "po_unique_id": checkbox.data("form_main_id"),
        "invoice_no": checkbox.data("invoice-num"),
        "invoice_qty": checkbox.data("qty"),
        "rate": checkbox.data("rate"),
        "gst": checkbox.data("gst"),
        "amount": checkbox.data("amnt")
      });
    });

    if (checkedData.length === 0) {
      alert("Please select at least one entry");
      return;
    }

    // Send a single request to get a new bill number
    $.ajax({
      type: "POST",
      url: ajax_url,
      data: {
        action: "generate_vendor_bill_no"
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.status && res.bill_no) {
          var billNo = res.bill_no;

          // Now send each entry with the same billNo
          checkedData.forEach(function (entry, index) {
            var data = {
              "vendor_name": vendor_name,
              "dc_no": entry.dc_no,
              "dc_date": entry.dc_date,
              "po_num": entry.po_num,
              "po_unique_id": entry.po_unique_id,
              "invoice_no": entry.invoice_no,
              "invoice_qty": entry.invoice_qty,
              "rate": entry.rate,
              "gst": entry.gst,
              "amount": entry.amount,
              "ttl_amount": ttl_amnt,
              "bill_no": billNo,
              "action": "payment_store_detail"
            };

            $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              success: function (resp) {
                console.log("Saved for DC: " + entry.dc_no);
                if (index === checkedData.length - 1) {
                  sweetalert("Created");
                  alert("Saved successfully.");
                  window.location.reload();
                }
              },
              error: function () {
                alert("Network error while saving for DC: " + entry.dc_no);
              }
            });
          });
        } else {
          alert("Failed to generate vendor bill number");
        }
      },
      error: function () {
        alert("Error generating bill number");
      }
    });
  }









  $("#export").click(function () {

    window.location = "folders/payment/excel.php";
  });
  $(document).ready(function () {

    get_user_permission();

  });

  function get_user_permission() {
    var screen_id_val = $('#screen_id_val').val();

    var user_type_unique_id = $('#user_type_unique_id').val();

    var data = {
      "screen_id_val": screen_id_val,
      "user_type_unique_id": user_type_unique_id,
      "action": 'user_permission',
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");

    $.ajax({
      type: "POST",
      url: ajax_url,
      data: data,
      success: function (data) {

        var obj = JSON.parse(data);

        var dataString = obj.data;

        var listpage = document.getElementById('list');


      },
      error: function (data) {
        alert("Network Error");
      }
    });
  }


  $(document).on('change', '#select_all', function () {
    $('.myCheck').prop('checked', this.checked);
  });


  function renderFileIcons(folderName = "", storedFileNames = "", originalFileNames = "") {

    let fileNames = storedFileNames.split(",");
    let originalNames = originalFileNames.split(",");
    let html1 = "";

    fileNames.forEach((storedFile, index) => {
      if (!storedFile.trim()) return;

      if (index !== 0) {
        html1 += (index % 4 !== 0) ? "&nbsp;" : "<br><br>";
      }

      const extension = storedFile.split('.').pop().toLowerCase();
      const filePath = `${folderName}/${storedFile}`;

      if (["jpg", "jpeg", "png"].includes(extension)) {
        html1 += `<a href="javascript:void(0);" onclick="openFilePopup('uploads/${filePath}')">
              <img src="${filePath}" height="20px" width="30px" title="${originalNames[index] || storedFile}">
            </a>`;
      } else if (extension === "pdf") {
        html1 += `<a href="javascript:void(0);" onclick="openFilePopup('uploads/${filePath}')"> 
              <img src="/otm_beta/uploads/invoice/pdf.png" height="20px" width="20px" title="${originalNames[index] || storedFile}">
            </a>`;
      } else if (["xls", "xlsx"].includes(extension)) {
        html1 += `<a href="javascript:void(0);" onclick="openFilePopup('uploads/${filePath}')">
              <img src="/otm_beta/uploads/invoice/excel.png" height="20px" width="20px" title="${originalNames[index] || storedFile}">
            </a>`;
      } else if (["txt", "docx", "doc"].includes(extension)) {
        html1 += `<a href="javascript:void(0);" onclick="openFilePopup('uploads/${filePath}')">
              <img src="/otm_beta/uploads/invoice/word.png" height="20px" width="20px" title="${originalNames[index] || storedFile}">
            </a>`;
      }

    });

    return html1;
  }

  function openFilePopup(url) {
    window.open(
      url,
      '_blank',
      'width=1000,height=700,top=100,left=200,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes'
    );
  }


</script>
