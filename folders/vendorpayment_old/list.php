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

  .mdi-eye {
    font-size: 20px;
  }

  .table thead th {
    background-color: var(--bs-table-head-bg);
    color: var(--bs-table-head-color);
    font-size: .8125rem;
    font-weight: 600;
    letter-spacing: .08em;
  }
</style>
<?php

$screen_id_val = '641adb14666c465380';

session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
//   print_r( $user_type_unique_id);die();
?>
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Vendor Bill Creation</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id_val; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">
      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor Payment</a></li>
          <li class="breadcrumb-item active">Vendor Bill Creation</li>
        </ol>
      </div>

    </div>
  </div>
</div>

<!-- <li class="nav-item" onclick="stock_position_pending()">
<li class="nav-item" onclick="complete_list_datatable()"> -->

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
            <span class="d-none d-sm-block">Bill Generation</span>
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
                  class="pt-2 table table-bordered nowrap table-striped align-middle ">
                  <thead>
                    <tr>
                      <th style="text-align: center;">S.No</th>
                      <th style="text-align: center;">Vendor Details</th>
                      <th style="text-align: center;">DC Count</th>
                      <th style="text-align: center;">Value</th>
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
          <table id="vendorpayment_datatable_billed" class="table table-bordered table-striped align-middle">
            <div class="table-responsive mb-4">
              <thead>
                <tr>
                  <th style="text-align: center;">S.No</th>
                  <th style="text-align: center;">Bill Date</th>
                  <th style="text-align: center;">Bill No.</th>
                  <th style="text-align: center;">Vendor Details</th>
                  <th style="text-align: center;">DC Count</th>
                  <th style="text-align: center;">Bill Value</th>
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
</div><!-- end card-body -->






<!----content start---------->

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <!-- <div class="modal-dialog modal-xxl modal-dialog-centered modal-dialog-scrollable">
    -->
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <!-- bg-success text-white rounded-top" -->
        <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Vendor Payment
          Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">

          <input type="hidden" name="po_num" id="po_num">
          <input type="hidden" name="vendor_name" id="vendor_name">
          <input type="hidden" name="vendor_id" id="vendor_id">
          <!-- Vendor Table -->

          <div class="card border-0 shadow-sm">
            <div class="card-body">

              <div class="row">
                <div class="col-md-6">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor Details
                  </h6>

                  <h6 style="font-size: 18px; color: #506018;"><strong><span id="vendor_name_popup_1"></span></strong>
                  </h6>
                  <p class="mb-1">
                    <i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i>
                    <span id="address_popup_1"></span>
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
                    <span id="contact_no_popup_1"></span>
                  </p>

                </div>

                <div class="col-md-6">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bank
                    Details</h6>

                  <h6 style="font-size: 18px; color: #506018;"><strong><span id="bank_name_popup_1"></span></strong>
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

              <div class="table-responsive mt-3">
                <table id="vendor_datatable" class="table table-bordered table-striped table-hover align-middle">
                  <tbody>
                    <thead class="table-light">
                      <tr>
                        <th style="text-align:center;width:65px">
                          <?php echo '<input type="checkbox" id="select_all">' ?>&nbsp;&nbsp;All<br>
                        </th>
                        <th style="text-align:center;">S.No.</th>
                        <th style="text-align:center;">DC No / Date</th>
                        <th style="text-align:center;">PO No / Date</th>
                        <th style="text-align:center;">Invoice No / Date</th>
                        <th style="text-align:center;">Invoice Qty</th>
                        <th style="text-align:center;">Consignee Name</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">Amount</th>
                      </tr>
                    </thead>
                  </tbody>
                </table>
              </div>

              <div style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                <span class="me-2">Total Amount: </span>
                <span id="ttl_span_amnt" class="fw-bold text-success text-end"
                  style="display: inline-block;color: #506018 !important;font-size:17px !important;">0.00</span>
              </div>

              <input type="hidden" id="ttl_amount" class="form-control d-inline" style="width: 200px; display: inline;"
                readonly>
              <div class="row m-2">
                <div class="hstack gap-2 justify-content-end d-print-none mt-4 mb-3">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                  <button type="button" class="btn btn-success" onclick="vendor_payment()">Submit</button>
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
        style="background-color: #d6d8b3; color: #506018; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">

        <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Vendor Payment
          Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">

          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <input type="hidden" id="vendor_id_popup">

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
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_popup_2"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="bill_date_popup_2"></span></b>
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

              <div class="table-responsive mt-3">
                <table id="vendor_datatable_bill_popup"
                  class="table table-bordered table-striped table-hover align-middle">
                  <tbody>
                    <thead class="table-light">
                      <tr>
                        <th>S No.</th>
                        <th style="text-align:center;">DC No / Date</th>
                        <th style="text-align:center;">Invoice No / Date</th>
                        <th style="text-align:center;">PO No / Date</th>
                        <th style="text-align:center;">Consignee Name</th>
                        <th style="text-align:center;">Amount</th>
                      </tr>
                    </thead>
                  </tbody>
                </table>
              </div>

              <!-- <div style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                <span class="fw-bold me-2">Total Amount: </span>
                <span id="sum_of_amount" class="fw-bold text-success text-end"
                  style="display: inline-block;color: #506018 !important;font-size:17px !important;">0</span>
              </div>

              <input type="hidden" id="ttl_amount" class="form-control d-inline" style="width: 200px; display: inline;"
                readonly>
              <div class="row m-2">
                <div class="hstack gap-2 justify-content-end d-print-none mt-4 mb-3">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                </div>
              </div> -->

              <div class="row mt-2" style="margin:0 15px">
                <!-- Approved By (first line) -->
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                  <label class="me-2 mb-0">Billed By:
                    <span id="approver" class="fw-bold text-success"
                      style="display: inline-block; color: #506018 !important; font-size:15px !important;">0</span>
                  </label>

                  <!-- Total Amount -->
                  <label class="me-2 mb-0">Total Amount:
                    <span id="sum_of_amount" class="fw-bold text-success"
                      style="display: inline-block; color: #506018 !important; font-size:17px !important;">0</span>
                    <input type="hidden" id="ttl_amount" class="form-control d-inline"
                      style="width: 200px; display: inline;" readonly>
                  </label>
                </div>

                <!-- Approved Date and Total Amount (same row) -->
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                  <!-- Approved Date -->
                  <label class="me-2 mb-0">Billed Date:
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
</div>

<!-- <th><?php echo '<input type="checkbox" id="select_all">' ?>&nbsp;&nbsp;Selection<br></th> -->

<script>

 

  $(document).on('click', '.view-btn', function () {
    var po_num = $(this).data('ponum');
    var vendor = $(this).data('vendor');
    var vendor_id = $(this).data('vendor-id');

    document.getElementById("po_num").value = po_num;
    document.getElementById("vendor_name").value = vendor;

    document.getElementById("vendor_id").value = vendor_id;
    // alert(vendor_id);

    $('#viewModal').modal('show');
    $('#select_all').prop('checked', false);
    document.getElementById("ttl_span_amnt").textContent = '₹ 0.00';


    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        vendor_id: vendor_id,
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
        po_num: po_num,
        vendor_id: vendor_id,
        action: 'vendor_payment_details'
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {

          

$('#vendor_datatable tbody').html('');
          const firstRow = res.data[0];

          // Populate the table
          let tableHtml = '';

          res.data.forEach((row, index) => {
            // alert('test');
            tableHtml += `
                        <tr>
                            <td>${row.checkbox}</td>
                            <td>${index + 1}</td>
                            <td>${row.dc_number}</td>
                            <td>${row.po_num}</td>
                            <td>${row.invoice_no}</td>
                            <td style="text-align:right;">${row.invoice_qty}</td>
                            <td>${capitalizeWords(row.consignee_name)}</td>
                            <td style="text-align:right;">${row.vendor_bulk_rate}</td>
                            <td style="text-align:right;">${row.vendor_bulk_gst} %</td>
                            <td style="text-align:right; font-weight: bold">
                                ₹ ${parseFloat(row.bulk_total_amount.replace(/,/g, '') || 0).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })}
                            </td>
                        </tr>
                    `;
          });

          $('#vendor_datatable tbody').html(tableHtml);
        } else {
          $('#vendor_datatable tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
        }
      },
      error: function () {
        alert('Failed to fetch details');
      }
    });
  });

  // <td style="text-align:right;font-weight: bold">${Math.round(parseFloat(row.bulk_total_amount.replace(/,/g, '')) || 0).toLocaleString('en-IN')}</td>


  $(document).on('click', '.view-btn-2', function () {

    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    var approver = $(this).data('approver');
    var approvedate = $(this).data('approvedate');

    document.getElementById("bill_no_popup_2").textContent = bill_no;
    document.getElementById("vendor_id_popup").value = vendor;
    document.getElementById("bill_date_popup_2").textContent = bill_date;
    $('#approver').text(approver);
    $('#approvedate').text(approvedate);

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

    // Second AJAX call: e.g., Bill Summary or Invoice Status
    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        action: 'vendor_payment_details_popup'
      },
      success: function (response) {

        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {

          const firstRow = res.data[0];

          let tableHtml = '';
          let totalAmount = 0;

          res.data.forEach((row, index) => {
            const rawAmount = row.amount || '0';
            const amount = parseFloat(rawAmount.replace(/,/g, '')) || 0;
            totalAmount += amount;

            const formattedAmount = amount.toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
            tableHtml += `
        <tr>
            <td>${index + 1}</td>
            <td>${row.dc_num}</td>
            <td>${row.invoice_no}</td>
            <td>${row.po_num}</td>
            <td>${capitalizeWords(row.consignee_name)}</td>
            <td style="text-align:right;font-weight:bold">₹ ${formattedAmount}</td>
        </tr>
    `;
          });

          // Format total with 2 decimals
          const formattedTotal = totalAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });

          $('#vendor_datatable_bill_popup tbody').html(tableHtml);
          $('#sum_of_amount').text('₹ ' + formattedTotal);
        } else {
          $('#vendor_datatable_bill_popup tbody').html('<tr><td colspan="6" class="text-center">No data found</td></tr>');
          $('#sum_of_amount').text('0');
        }
      },
      error: function () {
        alert('Failed to fetch details');
      }
    });
  });
  // <td>${row.checkbox}</td>
  // <td style="text-align:right;">${row.vendor_bulk_gst} %</td>
  // <td style="text-align:right;">${row.bulk_total_amount}</td>
  // <td style="text-align:center;">${row.dc_date}</td>



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
      let total = 0;
      document.querySelectorAll(".myCheck:checked").forEach(checkbox => {
        const amount = parseFloat(checkbox.getAttribute('data-amnt')) || 0;
        total += amount;
      });

      const roundedTotal = Math.round(total);

      document.getElementById("ttl_amount").value = roundedTotal;
      // document.getElementById("ttl_span_amnt").textContent = '₹ ' + roundedTotal.toLocaleString('en-IN');
      document.getElementById("ttl_span_amnt").textContent =
        '₹ ' + parseFloat(roundedTotal).toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
    }

  });


  function vendor_payment() {

    // alert('ven');
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var vendor_name = $('#vendor_name').val();
    var ttl_amnt = $('#ttl_amount').val();

    var url = sessionStorage.getItem("list_link");

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
        "amount": checkbox.data("amnt"),
        "vendor_id": checkbox.data('vendor-id')
      });
    });

    if (checkedData.length === 0) {
      // alert("Please select at least one entry");
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: 'Please select at least one entry',
        confirmButtonText: 'OK'
      });
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

          // alert(billNo);


          // Now send each entry with the same billNo
          checkedData.forEach(function (entry, index) {
            var data = {

              "vendor_name": vendor_name,
              "vendor_id": entry.vendor_id,
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
            console.log(data);
            $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              success: function (resp) {
                console.log("Saved for DC: " + entry.dc_no);
                if (index === checkedData.length - 1) {

                  // return;
                  sweetalert("create", url);

                  // alert("Saved successfully.");
                  // alert("Last");
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
