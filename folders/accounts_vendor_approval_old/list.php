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
      <h4 class="mb-sm-0">Accounts Approval</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li> -->
          <li class="breadcrumb-item ">Vendor Payment</li>
          <li class="breadcrumb-item active">Accounts Approval</li>
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
            <span class="d-none d-sm-block">Accounts Pending</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
            <span class="d-none d-sm-block">Accounts Approved</span>
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
                      <th style="text-align: center;">Bill Date</th>
                      <th style="text-align: center;">Bill No</th>
                      <th style="text-align: center;">Vendor Name</th>
                      <th style="text-align: center;">Total Amount</th>
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
        <div class="tab-pane" id="arrow-contact" role="tabpanel">
          <table id="vendorpayment_datatable_processed" class="table table-bordered table-striped align-middle">
            <div class="table-responsive">
              <thead>
                <tr>
                  <th style="text-align: center;">S.No</th>
                  <th style="text-align: center;">Bill Date</th>
                  <th style="text-align: center;">Bill No</th>
                  <th style="text-align: center;">Vendor Name</th>
                  <th style="text-align: center;">Total Amount</th>
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
          Accounts Team Approval</h5>
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
              <!-- Approved By (first line) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <label class="me-2 mb-0">Approved By:
                  <span id="approver" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                </label>

                <!-- Total Amount -->
                <label class="me-2 mb-0">Total Amount:
                  <span id="ttl_span_amnt" class="fw-bold text-success"
                    style="display: inline-block; color: #506018 !important; font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount" class="form-control d-inline"
                    style="width: 200px; display: inline;" readonly>
                </label>
              </div>

              <!-- Approved Date and Total Amount (same row) -->
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <!-- Approved Date -->
                <label class="me-2 mb-0">Approved Date:
                  <span id="approvedate" class="fw-bold text-success"
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
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');

    var mail = $(this).data('vendor-mail');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');

    var ttl_amount = $(this).data('ttl-amount');

    var vendor_name = $(this).data('vendor-name');

    // Populate modal header
    $('#bill_no').text(bill_no);
    $('#bill_date').text(bill_date);
    $('#approver').text(approver);
    $('#approvedate').text(approvedate);

    $('#mail').text(mail);
    $('#contact').text(contact);
    $('#address').text(address);


    $('#vndr_name').text(vendor_name);

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
  });

</script>
