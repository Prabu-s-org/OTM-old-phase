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

  .reject-section {
    padding-top: 5px;
  }

  .mdi-eye {
    font-size: 20px;
  }

  /* .table-responsive {
  overflow-x: auto;
}
.table {
  width: 100% !important;
} */
</style>
<?php
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641adb14666c465380';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

?>

<!-- start page title -->
<div class="row mb-4">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Finance Approval</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id_val; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor Payment</a></li>
          <li class="breadcrumb-item active">Finance Approval</li>
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
            <span class="d-none d-sm-block">Complete</span>
          </a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content ">
        <div class="tab-pane active" id="arrow-overview" role="tabpanel">
          <div class="row">
            <div class="row" id="list">
              <div class="table-responsive">
                <table id="vendorpayment_datatable"
                  class=" pt-2 table table-bordered nowrap table-striped align-middle">
                  <thead>
                    <tr>
                      <th style="text-align:center;">S.No</th>
                      <th style="text-align:center;">Bill Date</th>
                      <th style="text-align:center;">Bill No</th>
                      <th style="text-align:center;">Vendor Name</th>
                      <th style="text-align:center;">Amount</th>
                      <th style="text-align:center;">Action</th>
                    </tr>
                  </thead>
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
                  <th style="text-align:center;">S.No</th>
                  <th style="text-align:center;">Bill Date</th>
                  <th style="text-align:center;">Bill No</th>
                  <th style="text-align:center;">Vendor Name</th>
                  <th style="text-align:center;">Amount</th>
                  <th style="text-align:center;">Status</th>
                  <th style="text-align:center;">Action</th>
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
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">Finance
          Team Approval</h5>
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

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vndr_name"></span></strong>
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
                        <th style="text-align:center;">S NO</th>
                        <th style="text-align:center;">DC No. / Date</th>
                        <th style="text-align:center;">Invoice No. / Date</th>
                        <th style="text-align:center;">PO No. / Date</th>
                        <th style="text-align:center;">Invoice Qty</th>
                        <th style="text-align:center;">Consignee Name</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">Amount</th>
                        <th style="text-align:center;">Status</th>
                      </tr>
                    </thead>
                  </tbody>

                </table>
              </div>
            </div>
            <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">
            <div class="row mt-2">
              <div class="col-md-12 d-flex justify-content-end align-items-center">
                <label class="fw-bold me-2 mb-0">Total Amount: ₹
                  <span id="ttl_span_amnt" class="fw-bold text-success"
                    style="display: inline-block;color: #506018 !important;font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount" class="form-control d-inline"
                    style="width: 200px; display: inline;" readonly>

                </label>
              </div>
              <div class="form-group row ">
                <div class="col-md-12 pt-2 pb-2" align="right">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                  <button type="button" class="btn btn-success" id="apprvl_btn"
                    onclick="vendor_payment()">Submit</button>
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
      <!-- <div class="modal-header bg-success text-white rounded-top"> -->
      <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">Finance
          Team Approval</h5>
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

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_name_popup_2"></span></strong>
                  </h6>
                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="address_popup_2"></span>
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
                    <span id="contact_no_popup_2"></span>
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
                <table id="vendor_datatable_popup" class="table table-bordered table-striped table-hover align-middle">
                  <tbody>

                    <thead>
                      <tr>
                        <th style="text-align:center;">S NO</th>
                        <th style="text-align:center;">DC No. / Date</th>
                        <th style="text-align:center;">Invoice No. / Date</th>
                        <th style="text-align:center;">PO No. / Date</th>
                        <th style="text-align:center;">Invoice Qty</th>
                        <th style="text-align:center;">Consignee Name</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">Amount</th>
                        <!-- <th style="text-align:center;">Status</th> -->
                      </tr>
                    </thead>
                  </tbody>

                </table>
              </div>
            </div>
            <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">

            <div class="row mt-2" style="margin:0 15px" id="approve-div">
              <!-- Approved By (first line) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <label class="me-2 mb-0">Approved By:
                  <span id="approver_1" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

                <!-- Total Amount -->
                <label class="fw-bold me-2 mb-0">Total Amount:
                  <span id="ttl_span_amnt_2" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount" class="form-control d-inline"
                    style="width: 200px; display: inline;" readonly>
                </label>
              </div>

              <!-- Approved Date and Total Amount (same row) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <!-- Approved Date -->
                <label class="me-2 mb-0">Approved Date:
                  <span id="approvedate_1" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

              </div>

              <!-- Close Button -->
              <div class="form-group row">
                <div class="col-md-12 pt-2 pb-2 text-end">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                </div>
              </div>
            </div>

            <div class="row mt-2" style="margin:0 15px" id="reject-div">
              <!-- Approved By (first line) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <label class="me-2 mb-0">Rejected By:
                  <span id="approver_2" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

                <!-- Total Amount -->
                <label class="fw-bold me-2 mb-0">Total Amount:
                  <span id="ttl_span_amnt_3" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount" class="form-control d-inline"
                    style="width: 200px; display: inline;" readonly>
                </label>
              </div>

              <!-- Approved Date and Total Amount (same row) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <!-- Approved Date -->
                <label class="me-2 mb-0">Rejected Date:
                  <span id="approvedate_2" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

              </div>

              <div class="col-md-12 d-flex justify-content-between align-items-center" id="financerejectreason_div">
                <!-- Approved Date -->
                <label class="me-2 mb-0">Reject Reason:
                  <span id="financerejectreason_2" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

              </div>

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

    var mail = $(this).data('vendor-mail');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');

    var ttl_amount = $(this).data('ttl-amount');

    var vendor_name = $(this).data('vendor-name');

    // Populate modal header
    $('#bill_no').text(bill_no);
    $('#bill_date').text(bill_date);

    $('#mail').text(mail);
    $('#contact').text(contact);
    $('#address').text(address);


    $('#vndr_name').text(vendor_name);

    // $('#ttl_span_amnt').text(ttl_amount);

    // $('#ttl_span_amnt').text(Math.round(ttl_amount).toLocaleString('en-IN'));

    $('#ttl_span_amnt').text(
      parseFloat(ttl_amount).toLocaleString('en-IN', {
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

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        vendor: vendor,
        action: 'vendor_bill_details'
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {
          let tableHtml = '';
          res.data.forEach((row, index) => {
            tableHtml += `
            <tr>
              <td>${index + 1}</td>
              <td>${row.dc_number}</td>
              <td>${row.invoice_no}</td>
              <td>${row.po_num}</td>
              <td>${row.invoice_qty}</td>
              <td>${capitalizeWords(row.consignee_name)}</td>
              <td>${row.rate}</td>
              <td>${row.gst}</td>
              <td>${row.amount}</td>
              <td class="text-center">
              <select class="form-select form-select-sm status-select" data-unique-id="${row.unique_id}">
                <option value="approved" selected>Approved</option>
                <option value="rejected">Reject</option>
              </select>

              <div class="reject-section mt-2" style="display: none;">
                <textarea class="form-control form-control-sm reject-reason mb-2" placeholder="Enter reason"></textarea>
                <div class="d-flex gap-2">
                  <button type="button" class="btn btn-danger btn-sm confirm-reject" onclick="reject_payment(this)">Reject</button>
                  <button type="button"  id="reject_cancel" class="btn btn-secondary btn-sm cancel-reject">Cancel</button>
                </div>
              </div>
            </td>
            </tr>
          `;
          });
          // <td>${row.dc_date}</td>

          $('#vendor_datatable tbody').html(tableHtml);

          $('#vendor_datatable .status-select').each(function () {
            updateStatusColor(this);

            // Optional: toggle reject reason section

          });
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

  $(document).on('click', '.view-btn-2', function () {
    // var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_no = $(this).data('billno');
    var bill_date = $(this).data('billdate');
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');
    var financeapproval = $(this).data('financeapproval');
    var financerejectreason = $(this).data('financerejectreason');

    $('#bill_no_2').text(bill_no);
    $('#bill_date_2').text(bill_date);
    $('#approver_1').text(approver);
    $('#approvedate_1').text(approvedate);
    $('#approver_2').text(approver);
    $('#approvedate_2').text(approvedate);
    $('#financerejectreason_2').text(financerejectreason);
    $('#viewModal-2').modal('show');

    // // Handle approval/rejection labels and styles
    // if (financeapproval == 2) {
    //   // Rejected case
    //   $("label:has(#approver)").contents().first()[0].textContent = "Rejected By: ";
    //   $("label:has(#approvedate)").contents().first()[0].textContent = "Rejected Date: ";

    //   $('#approver').css('color', '#506018');
    //   $('#approvedate').css('color', '#506018');
    //   $('#financerejectreason').css('color', '#506018');
    //   // Show reject reason section
    //   $('#financerejectreason').closest('.col-md-12').show();
    //   $('#financerejectreason_div').show();
    // } else {
    //   // Approved case (or default)
    //   $("label:has(#approver)").contents().first()[0].textContent = "Approved By: ";
    //   $("label:has(#approvedate)").contents().first()[0].textContent = "Approved Date: ";

    //   $('#approver').css('color', '#506018');
    //   $('#approvedate').css('color', '#506018');
    //   $('#financerejectreason').css('color', '#506018');
    //   // Hide reject reason section
    //   $('#financerejectreason').closest('.col-md-12').hide();
    //   $('#financerejectreason_div').hide();  // Hide reject reason when approved

    // }

    if (financeapproval == 2) {
      // Rejected
      $('#reject-div').show();
      $('#approve-div').hide();
    } else if (financeapproval == 1) {
      // Approved
      $('#approve-div').show();
      $('#reject-div').hide();
    } else {
      // Neither approved nor rejected – optional case
      $('#approve-div').hide();
      $('#reject-div').hide();
    }

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
        bill_no: bill_no,
        vendor: vendor,
        financeapproval: financeapproval,
        action: 'vendor_bill_details_popup'
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {
          console.log(res.data);
          let tableHtml = '';
          let ttl_amount = 0;

          res.data.forEach((row, index) => {
            // Remove commas and convert amount to number
            let cleanAmount = parseFloat((row.sum_amount || '0').toString().replace(/,/g, '')) || 0;
            ttl_amount += cleanAmount;

            tableHtml += `
      <tr>
        <td>${index + 1}</td>
        <td>${row.dc_num}</td>
        <td>${row.invoice_no}</td>
        <td>${row.po_num}</td>
        <td>${row.invoice_qty}</td>
        <td>${row.consignee_name}</td>
        <td>${row.rate}</td>
        <td>${row.gst}</td>
        <td>${row.amount}</td>
      </tr>
    `;
          });

          $('#vendor_datatable_popup tbody').html(tableHtml);

          // Format total with 2 decimals, Indian format
          const formattedTotal = parseFloat(ttl_amount).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });

          $('#ttl_span_amnt_2').text('₹ ' + formattedTotal);
          $('#ttl_span_amnt_3').text('₹ ' + formattedTotal);

        } else {
          $('#vendor_datatable_popup tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
          $('#ttl_span_amnt_2').text('₹ 0.00');
          $('#ttl_span_amnt_3').text('₹ 0.00');
        }
      },
      error: function () {
        alert('Failed to fetch details');
      }
    });
  });


  $(document).on('change', '.status-select', function () {
    const selected = $(this).val();
    const td = $(this).closest('td');
    const rejectSection = td.find('.reject-section');

    if (selected === 'rejected') {
      rejectSection.slideDown();
      rejectSection.find('.reject-reason').attr('required', true);
    } else {
      rejectSection.slideUp();
      rejectSection.find('.reject-reason').removeAttr('required').val('');
    }
  });


  function reject_btn(selected_status) {

    if (selected_status === 'rejected') {
      reject_reason = row.find('.reject-reason').val() || '';
      row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
      row.find('.reject-section').hide();
    } else {
      row.find('.status-select').replaceWith('<span class="text-success fw-bold">Approved</span>');
    }
  }


  $(document).on('click', '.cancel-reject', function () {
    const td = $(this).closest('td');
    const select = td.find('.status-select');
    const rejectSection = td.find('.reject-section');

    // Reset select to Approved
    select.val('approved');

    // Clear and hide the reject section
    rejectSection.slideUp();
    rejectSection.find('.reject-reason').val('').removeAttr('required');
  });


  // Apply initial color to each select based on selected value
  function updateStatusColor(select) {
    const status = $(select).val();
    if (status === 'approved') {
      $(select).css('color', 'green');
    } else if (status === 'rejected') {
      $(select).css('color', 'red');
    } else {
      $(select).css('color', '');
    }
  }

  $('#vendor_datatable').on('change', '.status-select', function () {
    updateStatusColor(this);

    // Optional: toggle reject reason section
    const row = $(this).closest('tr');
    const rejectSection = row.find('.reject-section');
    if ($(this).val() === 'rejected') {
      rejectSection.show();
    } else {
      rejectSection.hide();
    }
  });

  // Apply initial color to each select based on selected value





  function updateTotalAmount() {

    // alert('test');
    let total = 0;
    document.querySelectorAll(".myCheck:checked").forEach(checkbox => {
      const amount = parseFloat(checkbox.getAttribute('data-amnt')) || 0;
      // alert(amount);
      total += amount;
    });

    document.getElementById("ttl_amount").value = total.toFixed(2);
    // document.getElementById("ttl_span_amnt").textContent = total.toFixed(2);
    document.getElementById("ttl_span_amnt").textContent = '₹ ' + roundedTotal.toLocaleString('en-IN');

  }



  function reject_payment(button) {
    const row = $(button).closest('tr'); // Get the row of the clicked reject button
    const selected_status = row.find('.status-select').val(); // Will be "rejected"
    const dc_no_with_date = row.find('td').eq(1).text().trim();
    const unique_id = row.find('.status-select').attr('data-unique-id'); // Use attr()

    const reject_reason = row.find('.reject-reason').val() || '';
    // alert(reject_reason);

    if (!reject_reason) {
      alert("Please enter a rejection reason.");
      // return;
    }

    // Split by space(s)
    const parts = dc_no_with_date.split(/\s+/);

    // DEBUG
    // alert("REJECTING\nDC No: " + dc_no + "\nUnique ID: " + unique_id);

    // Optional: visually update row
    row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
    row.find('.reject-section').hide();

    // Submit data to server
    const ajax_url = sessionStorage.getItem("folder_crud_link");
    const bill_no = $('#bill_no').text();

    // Assuming the format is always "DCNO DATE"
    const dc_no = parts[0];            // "DCOTM10002"

    // alert('reject_payment');
    $.ajax({
      type: 'POST',
      url: ajax_url,
      data: {
        dc_no: dc_no,
        bill_no: bill_no,
        unique_id: unique_id,
        finance_approval_sts: '2',
        reject_reason: reject_reason,
        action: 'finance_approval'
      },
      success: function (response) {
        // alert(response);
        console.log("Rejected successfully");

        let res = typeof response === 'string' ? JSON.parse(response) : response;

        if (res.total_amount) {
          let roundedAmount = Math.round(res.total_amount);

          // Format in Indian number system
          let formattedAmount = roundedAmount.toLocaleString('en-IN');

          $('#ttl_span_amnt').text(formattedAmount);
        }
      },
      error: function () {
        alert("Error rejecting entry");
      }
    });
  }



  function vendor_payment() {
    $('#apprvl_btn').show();

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var bill_no = $('#bill_no').text();
    var url = sessionStorage.getItem("list_link");

    $('#vendor_datatable tbody tr').each(function () {
      var row = $(this);

      var selected_status = row.find('.status-select').val();
      var dc_no = row.find('td').eq(1).text().trim();
      // var unique_id = row.find('.status-select').data('unique-id');

      var unique_id = row.find('.status-select').attr('data-unique-id');

      // alert(unique_id);

      if (!unique_id) {
        console.warn('Missing unique_id for DC:', dc_no);
        return; // skip this row
      }

      let finance_approval_sts = '';
      let reject_reason = '';

      if (selected_status === 'approved') {
        finance_approval_sts = '1';
      } else if (selected_status === 'rejected') {
        finance_approval_sts = '2';
        reject_reason = row.find('.reject-reason').val() || '';
      } else {
        return; // skip if not approved/rejected
      }

      let data = {
        dc_no: dc_no,
        bill_no: bill_no,
        unique_id: unique_id,
        finance_approval_sts: finance_approval_sts,
        reject_reason: reject_reason,
        action: "finance_approval"
      };

      console.log('Sending Data:', data);

      $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function (response) {
          console.log(`Status Updated for DC ${dc_no} | Status: ${selected_status}`);
        },
        error: function () {
          alert(`Network error for DC ${dc_no}`);
        }
      });
    });

    // Delay redirect or alert slightly to wait for all AJAX calls
    setTimeout(function () {
      sweetalert('create', url);
    }, 1000);
  }





  $("#export").click(function () {
    // alert("hi");
    window.location = "folders/payment/excel.php";
  });
  $(document).ready(function () {
    // var table_id 	= "user_datatable";
    // init_datatable(table_id,form_name,action);
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

    // console.log(data);
    $.ajax({
      type: "POST",
      url: ajax_url,
      data: data,
      success: function (data) {

        var obj = JSON.parse(data);

        var dataString = obj.data;

        // console.log(dataString);

        // var addButton = document.getElementById('add_btn');
        // if (dataString.includes('5f8807ff00bf726601')) {
        // 	addButton.style.visibility = 'visible';  // Show the button
        // } else {
        // 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
        // }
        var listpage = document.getElementById('list');
        // 			if (dataString.includes('5f88083fd50a344823')) {
        // 				listpage.style.visibility = 'visible';  // Show the button
        // 			} else {
        // 				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
        // 			}


      },
      error: function (data) {
        alert("Network Error");
      }
    });
  }


  $(document).on('change', '#select_all', function () {
    $('.myCheck').prop('checked', this.checked);
  });
</script>
