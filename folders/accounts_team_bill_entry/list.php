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

  .detail-row {
    display: flex;
    margin-bottom: 8px;
  }

  .detail-label {
    width: 130px;
    /* fixed width for label */
    font-weight: 500;
  }

  .detail-colon {
    width: 10px;
    /* width for colon */
    text-align: center;
  }

  .detail-value {
    flex: 1;
    /* remaining space for value */
    color: #506018;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .detail-value i {
    margin-right: 5px;
  }

  /* Summary row styling so TDS / Others / Payable align in one line */
  .summary-row {
    display: flex;
    flex-wrap: wrap;
    /* wrap on smaller screens */
    justify-content: space-between;
    align-items: center;
  }

  /* Spacing on small devices */
  @media (max-width: 576px) {
    .summary-row>div {
      width: 100%;
      margin-bottom: 0.5rem;
      text-align: left;
    }
  }

  /* Optional: bold the amounts */
  .summary-row span {
    font-weight: bold;
  }

  .required-input {
    border: 1px solid red;
  }

  .status-text {
    font-weight: 600;
  }

  .status-Approved {
    color: green;
  }

  .status-Pending {
    color: orange;
  }

  .status-Rejected {
    color: red;
  }
</style>
<?php

$screen_id_val = '641adb14666c465380';

session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
$state_code = 'Acc'; // Example: dynamically assign based on logged-in user or form input
$newVendorId = vendor_generate_accbillid($state_code);
$user_unique_id = $_SESSION["unique_id"];
$session_approved_by = $_SESSION["staff_name"];


$inv_status_option = [
  // "0" => [
  //     "unique_id" => "0",
  //     "value"     => "Pending",
  // ],
  "Pending" => [
    "unique_id" => "1",
    "value" => "Pending",
  ],
  "Completed" => [
    "unique_id" => "2",
    "value" => "Completed",
  ],
  "Rejected" => [
    "unique_id" => "3",
    "value" => "Rejected",
  ],
  // "Completed" => [
  //     "unique_id" => "",
  //     "value"     => "Completed",
  // ],
];
$inv_status_options = select_option($inv_status_option, "Select");


?>

?>
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0">Accounts Team Bill Entry</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id_val; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">
      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor Payment</a></li>
          <li class="breadcrumb-item active">Accounts Team Bill Entry</li>
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
            <span class="d-none d-sm-block">Accounts Team Bill Entry Pending</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
            <span class="d-none d-sm-block">Accounts Team Bill Complete</span>
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
                      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
                      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No
                      </th>

                      <th style="text-align: center;">Vendor Details</th>
                      <th style="text-align: center;">DC Count</th>
                      <th style="text-align: center;">Bill Value</th>
                      <th style="text-align: center;">Vendor Bill Approve By./ Date</th>
                      <th style="text-align: center;">Status</th>
                      <th style="text-align: center;">Reject Reason</th>
                      <th style="text-align: center;">Rejected By</th>
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
          <div class="table-responsive mb-4">
            <table id="vendorpayment_datatable_billed"
              class="pt-2 table table-bordered nowrap table-striped align-middle ">

              <thead>
                <tr>
                  <th style="text-align: center;">S.No</th>
                  <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
                  <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No
                  </th>

                  <th style="text-align: center;white-space: nowrap; ">Vendor Details</th>
                  <th style="text-align: center;">DC Count</th>
                  <th style="text-align: center;white-space: nowrap; ">Bill Value</th>
                  <th style="text-align: right;">Tds Deduction</th>
                  <th style="text-align: right;">Other Deduction</th>
                  <th style="text-align: center;">Advance Amount</th>
                  <th style="text-align: center; ">Deduction Payble Bill Value</th>
                  <th style="text-align: center;">Vendor Bill Approve By./ Date</th>
                  <!-- <th style="text-align:center;">Approved By/ Date</th> -->
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
          <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Account Team
            Bill Entry
            Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
          <div class="container-fluid">

            <input type="hidden" name="po_num" id="po_num">
            <input type="hidden" name="vendor_name" id="vendor_name">
            <input type="hidden" name="vendor_id" id="vendor_id">
            <input type="hidden" name="main_unique_id_1" id="main_unique_id_1">
            <!-- <input type="hidden" name="main_unique_id_1" id="main_unique_id_1"> -->


            <!-- Vendor Table -->

            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="row">
                  <!-- Vendor Details -->
                  <div class="col-md-4">
                    <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor
                      Details</h6>
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_companyname_popup_1"></span></strong><br><strong><span id="vendor_name_popup_1"></span></strong>
                    </h6>
                    <p class="mb-1"><i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i> <span
                        id="address_popup_1"></span></p>
                    <p class="mb-1">GST No: <b><span id="gst_no_popup_1"></span></b>, PAN No: <b><span
                          id="pan_no_popup_1"></span></b></p>
                    <p class="mb-1"><i data-feather="mail" style="width:15px; height:15px; color:#506018"></i> <span
                        id="mail_popup_1"></span></p>
                    <p class="mb-1"><i data-feather="phone" style="width:15px; height:15px; color:#506018"></i> <span
                        id="contact_no_popup_1"></span></p>


                    <h6 class="text-uppercase text-body-primary mt-4 mb-3" style="font-size: large; color: #878a99;">
                      Vendor Bill Approval Details</h6>
                    <p class="mb-1">
                      <b>Bill Created By: <span id="ven_created_by"></span></b>
                    </p>
                    <b>Bill Created Date: <span id="ven_created_date"></span></b>
                    </p>

                    <p class="mb-1">
                      <b>Bill Approved By: <span id="ven_approval_id_1"></span></b>
                    </p>
                    <b>Bill Approved Date: <span id="ven_approval_date_1"></span></b>
                    </p>
                    <!-- <h6 style="font-size: 16px; color: #506018;">Bill Created By</h6><strong><span id="ven_approval_id_1"></span></strong> -->
                    <!-- <p class="mb-1"><i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i> <b><span id="ven_approval_date_1"></span></b></p> -->
                  </div>

                  <!-- Vendor Bill & Invoice & Approval Details -->
                  <div class="col-md-4">
                    <!-- Vendor Bill Details -->
                    <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor
                      Bill Details</h6>
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_popup_1"></span></strong>
                    </h6>
                    <p class="mb-1"><i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                      <b><span id="bill_date_popup_1"></span></b></p>

                    <!-- Vendor Invoice Details -->
                    <h6 class="text-uppercase text-body-primary mt-4 mb-3" style="font-size: large; color: #878a99;">
                      Vendor Invoice Details</h6>
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id_1"></span></strong></h6>
                    <p class="mb-1"><i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                      <b><span id="ven_inv_date_1"></span></b></p>
                    <p class="mb-1">
                      <!-- <i  style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                          <b><span id="ven_inv_attach_1"></span></b> -->
                      <b>Invoice Attach: <span id="ven_inv_attach_1"></span></b>

                    </p>

                    <p class="mb-1">
                      <!-- <i  style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                          <b><span id="ven_inv_attach_1"></span></b> -->
                      <b>PO Attach: <span id="ven_po_attach_1"></span></b>

                    </p>

                    <!-- Vendor Bill Approval Details -->

                  </div>

                  <!-- Vendor Bank Details -->
                  <div class="col-md-4">
                    <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor
                      Bank Details</h6>

                    <div class="detail-row">
                      <div class="detail-label">Bank Name</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="bank_name_popup_1"></div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">Branch</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value"><i data-feather="map-pin" style="width:15px; height:15px;"></i> <span
                          id="bank_branch_popup_1"></span></div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">Account No</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="acc_no_popup_1"></div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">IFSC Code</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="ifsc_popup_1"></div>
                    </div>
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
                </div>
                <input type="hidden" id="hidden_dc">



                <div class="table-responsive mt-3">
                 <table id="vendor_datatable" class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th style="text-align:center;width:65px;display:none">
                <input type="checkbox" id="select_all">
            </th>
            <th style="text-align:center;">S.No.</th>
            <th style="text-align:center;">DC No / Date</th>
            <th style="text-align:center;">PO No / Date</th>
            <th style="text-align:center;">Invoice No / Date</th>
            <th style="text-align:center;">Invoice Qty</th>
            <th style="text-align:center;">Consignee Address</th>
            <th style="text-align:center;">Unit Price</th>
            <th style="text-align:center;">Basic amount</th>
            <th style="text-align:center;">GST</th>
            <th style="text-align:center;">GST Amount</th>
            <th style="text-align:center;">Total Amount</th>
        </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
        <tr>
            <th style="display:none;"></th>
            <th colspan="6" style="text-align:right;">Total</th>
            <th id="total_unit_price" style="text-align:right;"></th>
            <th id="total_basic" style="text-align:right;"></th>
            <th></th>
            <th id="total_gst_amt" style="text-align:right;"></th>
            <th id="total_final" style="text-align:right;"></th>
        </tr>
    </tfoot>
</table>
                </div>
<div style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                  <span class="me-2">Additional Charges: </span>
                  <span id="add_charge" class="fw-bold text-success text-end"
                    style="display: inline-block;color: #506018 !important;font-size:17px !important;">0.00</span>
                </div>
                <div style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                  <span class="me-2">Total Amount: </span>
                  <span id="ttl_span_amnt" class="fw-bold text-success text-end"
                    style="display: inline-block;color: #506018 !important;font-size:17px !important;">0.00</span>
                </div>




                <div class="row mt-4 align-items-start">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Status:</label>
                    <select class="form-select" id="acc_app_sts" name="acc_app_sts" onchange="popup_open()"
                      style="width: 400px;">
                      <option value="">Select Status</option>
                      <option value="1">Approved</option>
                      <option value="2">Reject</option>
                    </select>
                  </div>

                  <div class="col-md-5" id="rejectlabel" style="display: none; margin-left: -87px;">
                    <label class="form-label fw-semibold">
                      Reject Reason:<span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control required-textarea" id="reject_reason" name="reject_reason" rows="3"
                      oninput="removeRedBorder(this)" placeholder="Enter reject reason"
                      style="resize: none; display: block;" required></textarea>
                    <small id="remarkError" class="text-danger" style="display: none;">This field is required</small>
                  </div>
                </div>

                <input type="hidden" id="ttl_amount" class="form-control d-inline"
                  style="width: 200px; display: inline;" readonly>
                <div class="row m-2">
                  <div class="hstack gap-2 justify-content-end d-print-none mt-4 mb-3">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle"></i> Close
                    </button>
                    <button type="button" style="display:none;" id="rejectsubmitbtn" onclick="reject_sts()"
                      class="btn btn-success">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Accounts Bill Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <form id="accountBillForm">
            <!-- Hidden and visible fields aligned side by side -->
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Account Bill ID:</label>
              <div class="col-sm-8">
                <input type="hidden" id="accid" name="accid" value="<?php echo $newVendorId ?>" readonly>
                <span id="accid1" class="fw-bold"><?php echo $newVendorId ?></span>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Bill Issue Date:</label>
              <div class="col-sm-8">
                <input type="hidden" id="accbillissuedate" name="accbillissuedate" value="<?php echo date('d-m-Y'); ?>"
                  readonly>
                <span id="accbillissuedate1" class="fw-bold"><?php echo date('d-m-Y'); ?></span>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Basic Amount:</label>
              <div class="col-sm-8">
                <input type="hidden" id="basicamount" name="basicamount" oninput="getdetuction()" readonly>
                <span id="basicamount1" class="fw-bold"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">GST %:</label>
              <div class="col-sm-8">
                <input type="hidden" id="withgsttotinvvalue" name="withgsttotinvvalue" oninput="getdetuction()"
                  readonly>
                <span id="withgsttotinvvalue1" class="fw-bold"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">With Gst Total Amount:</label>
              <div class="col-sm-8">
                <input type="hidden" id="withtotinvvalue" name="withtotinvvalue" oninput="getdetuction()" readonly>
                <span id="withtotinvvalue1" class="fw-bold"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Total Amount:</label>
              <div class="col-sm-8">
                <input type="hidden" id="totalamount" name="totalamount" oninput="getdetuction()" readonly>
                <span id="totalamount1" class="fw-bold"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Additional Charges:</label>
              <div class="col-sm-8">
                <input type="hidden" id="add_charhes_1" name="add_charhes_1"  readonly>
                <span id="add_charhes_2" class="fw-bold"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">TDS %:<span class="text-danger">*</span></label>
              <!-- <div class="col-sm-4">
              <input type="number" id="tdsvalueper" name="tdsvalueper" class="form-control" oninput="getdetuction();removeRedBorder(this);">
            </div> -->
              <div class="col-sm-4">
                <input type="number" id="tdsvaluepercentage" name="tdsvaluepercentage" class="form-control"
                  oninput="getdetuction('tdspercentage');removeRedBorder(this);" required>
                <span id="tdsvalueper" name="tdsvalueper" class="fw-bold" style="display:none"></span>

                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">TDS Deduction Amount:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" onchange="getdetuction('tdsvalue');"
                  required>
              </div>
              <div class="col-sm-4">
                <span id="tdsvaluelab" name="tdsvaluelab" class="fw-bold" style="display:none"></span>
                <!-- <input type="hidden" id="bulk_eng_name" name="bulk_eng_name" readonly> -->
                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Totl TDS Deduction Amount:<span
                  class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="totaltdsvalue" name="totaltdsvalue" class="form-control"
                  onchange="getdetuction();" required>
              </div>
              <div class="col-sm-4">
                <span id="totaltdsvaluelab" name="totaltdsvaluelab" class="fw-bold" style="display:none"></span>
                <!-- <input type="hidden" id="bulk_eng_name" name="bulk_eng_name" readonly> -->
                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Other Deduction Amount:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="ottdsvalue" name="ottdsvalue" class="form-control"
                  oninput="getdetuction();removeRedBorder(this);">
              </div>
              <div class="col-sm-4">
                <span id="ottdsvaluelab" name="ottdsvaluelab" class="fw-bold" style="display:none"></span>
                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Advance payment Amount:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="adpayment" name="adpayment" class="form-control"
                  oninput="getdetuction();removeRedBorder(this);">
              </div>
              <div class="col-sm-4">
                <span id="adpaymentlab" name="adpaymentlab" class="fw-bold" style="display:none"></span>
                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>
 <!-- <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Additinal Charges:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="add_charge" name="add_charge" class="form-control"
                  oninput="getdetuction();removeRedBorder(this);">
              </div>
              <div class="col-sm-4">
                <span id="add_chargelab" name="add_chargelab" class="fw-bold" style="display:none"></span>
              </div>
            </div> -->

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Net Payble Amount:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="netamount" name="netamount" class="form-control"
                  oninput="getdetuction();removeRedBorder(this);">
              </div>
              <div class="col-sm-4">
                <span id="netamountlab" name="netamountlab" class="fw-bold" style="display:none"></span>
                <!-- <input type="number" id="tdsvalue" name="tdsvalue" class="form-control" oninput="getdetuction();"> -->
              </div>
            </div>


            <div class="row mb-3" style="display:none">
              <label class="col-sm-4 col-form-label">Overall Total Payable Amount:</label>
              <div class="col-sm-8">
                <input type="hidden" id="overalltotpayment" name="overalltotpayment" class="form-control">
                <input type="hidden" id="remamnt" name="remamnt">
                <span id="overalltotpayment1" class="fw-bold"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Vendor Company Name:</label>
              <div class="col-sm-8">
                <input type="hidden" id="vendcom" name="vendcom" readonly>
                <span id="vendcom1" class="fw-bold"></span>

                <input type="hidden" name="invverifyunique_id" id="invverifyunique_id">
                <input type="hidden" name="vendorbill_no" id="vendorbill_no">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Remarks:</label>
              <div class="col-sm-8">
                <textarea name="otremarks" id="otremarks" rows='4' class="form-control"
                  oninput="validateremark(this);"></textarea>
                <span class="remarkError" id="remarkError" name="remarkError"></span>

              </div>
            </div>

            <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $user_unique_id ?>">

            <!-- Single line display: TDS / Others / Payable -->
            <div class="row mb-4">
              <div class="col-12">
                <div class="d-flex justify-content-between align-items-center summary-row">
                  <!-- <div class="me-3">
                  <strong>TDS Deduction:</strong> <span id="tdsvalue1">0</span>
                </div>
                <div class="me-3">
                  <strong>Other Deduction:</strong> <span id="ottdsvalue1">0</span>
                </div>
                <div>
                  <strong>Total Payable:</strong> <span id="overalltotpayment1_line">0</span>
                </div> -->
                </div>
              </div>
            </div>

            <div class="text-end">
              <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
              <button type="button" id="close" name="close" class="btn btn-primary">Close</button>

            </div>
            <script>
              // JavaScript (Bootstrap 5)
              document.getElementById('close').addEventListener('click', function () {
                var modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
                modal.hide();
              });

            </script>

          </form>

        </div> <!-- modal-body -->

      </div>
    </div>
  </div>


  <!-- Submit Button -->
  <!-- <button type="button" class="btn btn-success" onclick="showConfirmationModal()">Submit</button> -->


  <div class="modal fade" id="viewModal-2" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">

    <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">

      <div class="modal-content shadow-lg rounded-4 border-0">
        <div class="modal-header"
          style="background-color: #d6d8b3; color: #506018; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">

          <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Vendor Account
            Bill
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
                    <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor
                      Details
                    </h6>

                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_com_name_popup_2"></span></strong><br><strong><span id="vendor_name_popup_2"></span></strong>
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
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_popup_2"></span></strong>
                    </h6>

                    <p class="mb-1">
                      <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                      <b><span id="bill_date_popup_2"></span></b>
                    </p>
                  </div>


                  <!-- Vendor Bank Details -->
                  <div class="col-md-3">
                    <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor
                      Bank Details</h6>

                    <div class="detail-row">
                      <div class="detail-label">Bank Name</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="bank_name_popup_2"></div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">Branch</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value">
                        <i data-feather="map-pin" style="width:15px; height:15px;"></i>
                        <span id="bank_branch_popup_2"></span>
                      </div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">Account No</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="acc_no_popup_2"></div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">IFSC Code</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="ifsc_popup_2"></div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">Account Holder</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="acc_holder_popup_2"></div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">PAN Copy</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="pan_popup_2"></div>
                    </div>

                    <div class="detail-row">
                      <div class="detail-label">Bank Proof</div>
                      <div class="detail-colon">:</div>
                      <div class="detail-value" id="bank_popup_2"></div>
                    </div>
                    <!-- style="display:none" -->
                    <p class="mb-1" style="display:none">
                      unique_id: <b><span id="unique_id"></span></b>
                    </p>
                    <p class="mb-1" style="display:none">
                      Dc number: <b><span id="dc_number"></span></b>
                    </p>
                  </div>

                </div>
                
                <div class="row ">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4" style="margin-top: -130px;">
                    <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor
                      Invoice
                      Details</h6>
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id_2"></span></strong></h6>

                    <p class="mb-1">
                      <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                      <b><span id="ven_inv_date_2"></span></b>
                    </p>

                    <p class="mb-1">
                      <!-- <i  style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                          <b><span id="ven_inv_attach_2"></span></b> -->
                      <b>Invoice Attach: <span id="ven_inv_attach_2"></span></b>

                    </p>
                     <p class="mb-1">
                      <!-- <i  style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                          <b><span id="ven_inv_attach_2"></span></b> -->
                      <b>PO Attach: <span id="ven_po_attach_2"></span></b>

                    </p>
                    <!-- <b>Invoice Attach: <span id="ven_inv_attach_2"></span></b> -->


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
                          <!-- <th style="text-align:center;">Consignee Name</th> -->
                          <th style="text-align:center;">Consignee Address</th>
                          <th style="text-align:center;">Unit Price</th>
                          <th style="text-align:center;">Basic amount</th>
                          <th style="text-align:center;">GST</th>
                          <th style="text-align:center;">GST Amount</th>
                          <!-- <th style="text-align:center;">Advance Amount</th> -->
                          <th style="text-align:center;">Total Amount</th>
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
                  <!-- Left Column -->
                  <div class="col-md-6 d-flex flex-column justify-content-start" style="gap: 8px;">
                    <div style="display:none"><label class="me-2 mb-0">Billed By:
                        <span id="approver_1" class="fw-bold text-success"
                          style="color:#506018!important;font-size:15px;"></span>
                      </label>
                    </div>

                    <div style="display:none"><label class="me-2 mb-0">Billed Date:
                        <span id="approvedate_1" class="fw-bold text-success"
                          style="color:#506018!important;font-size:15px;"></span>
                      </label>
                    </div>

                    <div style="display:none"><label class="me-2 mb-0">Account Billed ID:
                        <span id="accountbillid" class="fw-bold text-success"
                          style="color:#506018!important;font-size:15px;"></span>
                      </label>
                    </div>
                  </div>

                  <!-- Right Column -->
                  <div class="col-md-6 d-flex flex-column align-items-end" style="gap: 8px;">
                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>Total Amount:</span>
                      <span id="sum_of_amount" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">₹ 64,901.18</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>TDS Deduction:</span>
                      <span id="tds_value_detuction" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">600</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>Others Deduction:</span>
                      <span id="othersval" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">500</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>Advance Amount:</span>
                      <span id="advancepayment" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">₹ 63,801.18</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>Additional Charges:</span>
                      <span id="add_charges" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">₹ 63,801.18</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; width:280px;">
                      <span>Total Payable Amount:</span>
                      <span id="tot_payamount" class="fw-bold text-success"
                        style="color:#506018!important;font-size:17px;">₹ 63,801.18</span>
                    </div>
                  </div>
                </div>



                <!-- Close Button -->

              </div>

            </div>

            <div class="table-responsive mt-3">
              <table id="vendor_bill_status" class="table table-bordered table-striped table-hover align-middle">
                <tbody>
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th style="text-align:center;">Bill Created By</th>
                      <th style="text-align:center;">Operation Team Approval</th>
                      <th style="text-align:center;">Account Entry Approval</th>
                      <th style="text-align:center;">Accounts Approval</th>
                      <th style="text-align:center;">Management Approval</th>
                      <th style="text-align:center;">Payment Status</th>

                    </tr>
                  </thead>
                </tbody>
              </table>
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

<!-- <th><?php echo '<input type="checkbox" id="select_all">' ?>&nbsp;&nbsp;Selection<br></th> -->

<script>


  function popup_open() {

    var status = $('#acc_app_sts').val();

    if (status == '1') {

      showConfirmationModal();
      $('#rejectsubmitbtn').hide();

    }
    else if (status == '2') {

      $('#rejectsubmitbtn').show();
    }
  }

  function reject_sts() {

    var status = $('#acc_app_sts').val();

    // alert(status);

    // return;
    var reject_reason = $('#reject_reason').val().trim();


    var vendor_bill_no = $('#bill_no_popup_1').text();
    // alert(vendor_bill_no);
    var dc_no = $('#hidden_dc').val();
    var main_unique_id = $('#main_unique_id_1').val();
    // alert(main_unique_id);

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");

    // 🔒 Validation
    if (reject_reason === '') {
      Swal.fire({
        icon: 'warning',
        text: 'Please enter rejection reason'
      });
      return false;
    }

    $.ajax({
      url: ajax_url,
      type: 'POST',
      data: {
        dc_no: dc_no,
        reject_reason: reject_reason,
        vendor_bill_no: vendor_bill_no,
        main_unique_id: main_unique_id,
        status: status,
        action: 'reject_update'
      },
      success: function (response) {

        Swal.fire({
          icon: 'success',
          text: 'Successfully Rejected'
        }).then(() => {
          window.location.href = url;
        });

      },
      error: function () {
        Swal.fire({
          icon: 'error',
          text: 'Something went wrong. Please try again.'
        });
      }
    });
  }


  function validateremark(textarea) {
    const value = textarea.value.trim();
    const errorEl = document.getElementById('remarkError');

    if (value === "") {
      // Show error message
      errorEl.style.display = 'inline';

      // Optional: add red border (if using Bootstrap)
      textarea.classList.add('is-invalid');
    } else {
      // Hide error message
      errorEl.style.display = 'none';

      // Remove red border
      textarea.classList.remove('is-invalid');
    }
  }
  // Function to show the confirmation modal

  $(document).on('click', '.view-btn', function () {

    // alert('test');
    var po_num = $(this).data('ponum');

    var vendor = $(this).data('vendor');

    var vendor_id = $(this).data('vendor-id');
    var bill_no = $(this).data('bill-no');
    //  alert(bill_no);
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    // alert(bill_date);
    var approver = $(this).data('approver');
    // alert(approver);
    var approvedate = $(this).data('approvedate');

    var main_unique_id = $(this).data('venunique_id');


    var vendor_bill_created_by = $(this).data('vendorBillCreatedBy');

    // alert(vendor_bill_created_by);

    var vendor_bill_created_date = $(this).data('vendorBillCreatedDate');


    // alert(approvedate);

    document.getElementById("bill_no_popup_1").textContent = bill_no;
    document.getElementById("vendor_id_popup").value = vendor;
    document.getElementById("bill_date_popup_1").textContent = bill_date;

    $('#ven_created_by').text(vendor_bill_created_by);

    $('#ven_created_date').text(vendor_bill_created_date);

    // ven_approval_date_1 ven_approval_id_1

    $('#ven_approval_id_1').text(approver);


    $('#ven_approval_date_1').text(approvedate);



    // alert(vendor_id);

    document.getElementById("po_num").value = po_num;
    document.getElementById("vendor_name").value = vendor;

    document.getElementById("vendor_id").value = vendor_id;
    document.getElementById("main_unique_id_1").value = main_unique_id;



    // alert(vendor_id);

    $('#viewModal').modal('show');
    $('#select_all').prop('checked', true);
    $('#add_charge').text('₹ 0.00');
    $('#ttl_span_amnt').text('₹ 0.00');
    $('#ttl_amount').val('0.00');


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
        // console.log(res.summary_data.name);
        if (res.status && res.summary_data) {
          $('#vendor_name_popup_1').text(res.summary_data.name || '-');
          $('#vendor_companyname_popup_1').text(res.summary_data.company_name || '-');
          
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
          if (res.summary_data.pan_attach_file_name) {
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
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
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
            $('#bank_popup_1').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Preview Bank PDF">' +
              '</a>'
            );
          } else {
            $('#bank_popup_1').text('N/A');
          }

          $('#unique_id').text(res.summary_data.unique_id || '-');
          //  $('#dc_number').text(res.summary_data.dc_number || '-');

          $('#invoice_no').text(res.summary_data.invoice_no || '-');


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
    bill_no: bill_no,
    main_unique_id: main_unique_id,
    action: 'vendor_payment_details'
  },
  success: function (response) {
    var res = JSON.parse(response);

    if (res.data && res.data.length > 0) {
      const firstRow = res.data[0];

      console.log(firstRow.vendor_bill_approval);
      console.log(firstRow.vendor_bill_approval_date);

      if (firstRow.vendor_inv_attach_approval_date === "01-01-1970") {
        $('#ven_inv_date_1').text('-');
      } else {
        $('#ven_inv_date_1').text(firstRow.vendor_inv_attach_approval_date || 'N/A');
      }

      $('#ven_inv_id_1').text(firstRow.veninvverifyid || '-');
      $('#hidden_dc').val(firstRow.dc_no);

      if (firstRow.inv_verfiy_attach) {
        var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
        $('#ven_inv_attach_1').html(
          '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
          '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
          '</a>'
        );
      } else {
        $('#ven_inv_attach_1').text('N/A');
      }

      if (firstRow.po_ven_filename) {
        var poFileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
        $('#ven_po_attach_1').html(
          '<a href="javascript:void(0);" onclick="window.open(\'' + poFileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
          '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
          '</a>'
        );
      } else {
        $('#ven_po_attach_1').text('N/A');
      }

      let tableHtml = '';

      let additional_amount = parseFloat((firstRow.additional_amount || '0').toString().replace(/,/g, '')) || 0;

      let totalUnitPrice = 0;
      let totalBasic = 0;
      let totalGstAmt = 0;
      let totalFinal = 0;

      const formattedAdditional = additional_amount.toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      $('#add_charge').text('₹ ' + formattedAdditional);

      res.data.forEach((row, index) => {
        let unitPrice = parseFloat(String(row.vendor_bulk_rate || 0).replace(/,/g, '')) || 0;
        let basic = parseFloat(String(row.basicamt || 0).replace(/,/g, '')) || 0;
        let gstAmt = parseFloat(String(row.gstcamt || 0).replace(/,/g, '')) || 0;
        let bulkAmount = parseFloat(String(row.bulk_total_amount || 0).replace(/,/g, '')) || 0;

        totalUnitPrice += unitPrice;
        totalBasic += basic;
        totalGstAmt += gstAmt;
        totalFinal += bulkAmount;

        tableHtml += `
          <tr>
            <td style="display:none;">${row.checkbox || ''}</td>
            <td>${index + 1}</td>
            <td>${row.dc_number || ''}</td>
            <td>${row.po_num || ''}</td>
            <td>${row.invoice_no || ''}</td>
            <td style="text-align:right;">${row.invoice_qty || 0}</td>
            <td>${row.consignee_name ? capitalizeWords(row.consignee_name) : ''}</td>
            <td style="text-align:right;">${unitPrice.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td style="text-align:right;">${basic.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td style="text-align:right;">${row.vendor_bulk_gst || 0} %</td>
            <td style="text-align:right;">${gstAmt.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td style="text-align:right; font-weight:bold;">
              ₹ ${bulkAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
            </td>
          </tr>
        `;
      });

      $('#vendor_datatable tbody').html(tableHtml);

      $('#total_unit_price').text(
        totalUnitPrice.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      );

      $('#total_basic').text(
        totalBasic.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      );

      $('#total_gst_amt').text(
        totalGstAmt.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      );

      $('#total_final').text(
        '₹ ' + totalFinal.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      );

      let overallTotal = totalFinal + additional_amount;

      const formattedTotal = overallTotal.toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      $('#ttl_span_amnt').text('₹ ' + formattedTotal);
      $('#ttl_amount').val(overallTotal.toFixed(2));

    } else {
      $('#vendor_datatable tbody').html('<tr><td colspan="12" class="text-center">No data found</td></tr>');
      $('#total_unit_price').text('0.00');
      $('#total_basic').text('0.00');
      $('#total_gst_amt').text('0.00');
      $('#total_final').text('₹ 0.00');
      $('#add_charge').text('₹ 0.00');
      $('#ttl_span_amnt').text('₹ 0.00');
      $('#ttl_amount').val('0.00');
    }
  },
  error: function () {
    alert('Failed to fetch details');
  }
});

//     $.ajax({
//       url: ajax_url,
//       method: 'POST',
//       data: {
//         po_num: po_num,
//         vendor_id: vendor_id,
//         bill_no: bill_no,
//         main_unique_id: main_unique_id,

//         action: 'vendor_payment_details'
//       },
//       success: function (response) {
//         var res = JSON.parse(response);

//         if (res.data && res.data.length > 0) {

//           const firstRow = res.data[0];

//           console.log(firstRow.vendor_bill_approval);
//           console.log(firstRow.vendor_bill_approval_date);

//           // Set Invoice Approval Date
//           if (firstRow.vendor_inv_attach_approval_date === "01-01-1970") {
//             $('#ven_inv_date_1').text('-');
//           } else {
//             $('#ven_inv_date_1').text(firstRow.vendor_inv_attach_approval_date || 'N/A');
//           }

//           // Set Invoice ID


//           $('#ven_inv_id_1').text(firstRow.veninvverifyid || '-');

//           // alert(firstRow.dc_no);
//           $('#hidden_dc').val(firstRow.dc_no);


//           if (firstRow.inv_verfiy_attach) {
//             var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
//             $('#ven_inv_attach_1').html(
//               '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
//               '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
//               '</a>'
//             );
//           } else {
//             $('#ven_inv_attach_1').text('N/A');
//           }

//            if (firstRow.po_ven_filename) {
//             var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
//             $('#ven_po_attach_1').html(
//               '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
//               '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
//               '</a>'
//             );
//           } else {
//             $('#ven_po_attach_1').text('N/A');
//           }
//           // Populate the table
//           let tableHtml = '';
//  let total_amount = parseFloat((firstRow.total_amount || '0').toString().replace(/,/g, '')) || 0;
//         let additional_amount = parseFloat((firstRow.additional_amount || '0').toString().replace(/,/g, '')) || 0;
// let totalUnitPrice = 0;
// let totalBasic = 0;
// let totalGstAmt = 0;
// let totalFinal = 0;
//           res.data.forEach((row, index) => {
//             // Ensure bulk_total_amount is safely handled
//             let bulkAmount = row.bulk_total_amount
//               ? parseFloat(String(row.bulk_total_amount).replace(/,/g, ''))
//               : 0;
//                const formattedTotal = parseFloat(total_amount).toLocaleString('en-IN', {
//           minimumFractionDigits: 2,
//           maximumFractionDigits: 2
//         });

//         const formattedadditional = parseFloat(additional_amount).toLocaleString('en-IN', {
//           minimumFractionDigits: 2,
//           maximumFractionDigits: 2
//         });
//          let unitPrice = parseFloat(row.vendor_bulk_rate || 0);
//     let basic = parseFloat(row.basicamt || 0);
//     let gstAmt = parseFloat(row.gstcamt || 0);
//     let totalAmt = row.bulk_total_amount
//         ? parseFloat(String(row.bulk_total_amount).replace(/,/g, ''))
//         : 0;

//     totalUnitPrice += unitPrice;
//     totalBasic += basic;
//     totalGstAmt += gstAmt;
//     totalFinal += totalAmt;

//         $('#add_charge').text('₹ ' + formattedadditional);
//         $('#ttl_span_amnt').text('₹ ' + formattedTotal);

//             tableHtml += `
//     <tr>
//       <td style="display:none;">${row.checkbox || ''}</td>
//       <td>${index + 1}</td>
//       <td>${row.dc_number || ''}</td>
//       <td>${row.po_num || ''}</td>
//       <td>${row.invoice_no || ''}</td>
//       <td style="text-align:right;">${row.invoice_qty}</td>
//       <td>${row.consignee_name ? capitalizeWords(row.consignee_name) : ''}</td>
//       <td style="text-align:right;">${row.vendor_bulk_rate}</td>

//       <td style="text-align:right;">${row.basicamt}</td>

//       <td style="text-align:right;">${row.vendor_bulk_gst} %</td>
//       <td style="text-align:right;">${row.gstcamt}</td>

//       <td style="text-align:right; font-weight: bold;">
//         ₹ ${bulkAmount.toLocaleString('en-IN', {
//               minimumFractionDigits: 2,
//               maximumFractionDigits: 2
//             })}
//       </td>
//     </tr>
//   `;
//           });
// $('#total_unit_price').text(
//     totalUnitPrice.toLocaleString('en-IN', { minimumFractionDigits: 2 })
// );

// $('#total_basic').text(
//     totalBasic.toLocaleString('en-IN', { minimumFractionDigits: 2 })
// );

// $('#total_gst_amt').text(
//     totalGstAmt.toLocaleString('en-IN', { minimumFractionDigits: 2 })
// );

// $('#total_final').text(
//     '₹ ' + totalFinal.toLocaleString('en-IN', { minimumFractionDigits: 2 })
// );

//           $('#vendor_datatable tbody').html(tableHtml);
//         } else {
//           $('#vendor_datatable tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
//         }
//       },
//       error: function () {
//         alert('Failed to fetch details');
//       }
//     });
  });

  // <td style="text-align:right;font-weight: bold">${Math.round(parseFloat(row.bulk_total_amount.replace(/,/g, '')) || 0).toLocaleString('en-IN')}</td>


  document.getElementById('acc_app_sts').addEventListener('change', function () {
    const rejectLabel = document.getElementById('rejectlabel');
    const rejectReason = document.getElementById('reject_reason');
    if (this.value == '2') {
      rejectLabel.style.display = 'block';
      rejectReason.style.display = 'block';
    } else {
      rejectLabel.style.display = 'none';
      rejectReason.style.display = 'none';
    }
  });


  $(document).on('click', '.view-btn-2', function () {

    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');
    var bill_date = $(this).data('bill-date');
    // var approver = $(this).data('approver');
    // var approvedate = $(this).data('approvedate');

    document.getElementById("bill_no_popup_2").textContent = bill_no;
    document.getElementById("vendor_id_popup").value = vendor;
    document.getElementById("bill_date_popup_2").textContent = bill_date;
    // $('#approver').text(approver);
    // $('#approvedate').text(approvedate);

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
          $('#vendor_com_name_popup_2').text(res.summary_data.company_name || '-');
          $('#mail_popup_2').text(res.summary_data.mail_id || '-');
          $('#gst_no_popup_2').text(res.summary_data.gst_no || '-');
          $('#pan_no_popup_2').text(res.summary_data.pan_no || '-');
          $('#contact_no_popup_2').text(res.summary_data.contact_no || '-');
          $('#address_popup_2').text(res.summary_data.address || '-');
          $('#bank_name_popup_2').text(res.summary_data.bank_name || '-');
          $('#bank_branch_popup_2').text(res.summary_data.branch_name || '-');
          $('#acc_no_popup_2').text(res.summary_data.account_no || '-');
          $('#ifsc_popup_2').text(res.summary_data.ifsc_code || '-');

          $('#acc_holder_popup_2').text(res.summary_data.acc_holder_name || '-');

          $('#unique_id').text(res.summary_data.unique_id || '-');
          $('#dc_number').text(res.summary_data.dc_number || '-');

          // $('#pan_popup_2').text(res.summary_data.pan_attach_file_name || '-');
          // $('#bank_popup_2').text(res.summary_data.bank_proof || '-');
          // For the PAN attachment (Click to download PDF)
          if (res.summary_data.pan_attach_file_name) {
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
            $('#pan_popup_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Preview PAN PDF">' +
              '</a>'
            );
          } else {
            $('#pan_popup_2').text('N/A');
          }

          // Bank Proof
          if (res.summary_data.bank_proof) {
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
            $('#bank_popup_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Preview Bank PDF">' +
              '</a>'
            );
          } else {
            $('#bank_popup_2').text('N/A');
          }

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
          // console.log(firstRow.veninvverifyid);
          console.log(firstRow.vendor_inv_attach_approval_date);

          if (firstRow.vendor_inv_attach_approval_date == "01-01-1970") {
            $('#ven_inv_date_2').text('-');

          }
          else {
            $('#ven_inv_date_2').text(firstRow.vendor_inv_attach_approval_date || 'N/A');

          }
          $('#ven_inv_id_2').text(firstRow.veninvverifyid || '-');
          // ✅ Set invoice number in span

          // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
          $('#approver_1').show().text(firstRow.vendor_account_approved_by || '-');
          $('#approvedate_1').show().text(firstRow.vendor_account_approval_date || '-');
          $('#accountbillid').show().text(firstRow.accountbillid || '-');
          $('#additional_amount').show().text(firstRow.additional_amount || '-');



          //         $('#tot_payamount').show().text(firstRow.acctotalpaybleamount || '-');
          //  $('#tds_value_detuction').show().text(firstRow.acctdsvalue || '-');
          //         $('#othersval').show().text(firstRow.accotherdeduction || '-');

          // Log the value of advancepayment
          console.log(firstRow.advancepayment);

          // Check if advancepayment is null or undefined, and set it to 0 if so
          let advancePaymentValue = firstRow.advancepayment;
          if (advancePaymentValue === null || advancePaymentValue === undefined) {
            advancePaymentValue = 0;
          }

          // Display the formatted value (₹ 0.00 if null or undefined)
          $('#advancepayment').text(
            '₹ ' + parseFloat(advancePaymentValue).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })
          );

          let additional_amount = parseFloat((firstRow.additional_amount || '0').toString().replace(/,/g, '')) || 0;


           $('#add_charges').text(
            '₹ ' + parseFloat(additional_amount).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })
          );
          $('#tot_payamount').text(
            '₹ ' + parseFloat(firstRow.acctotalpaybleamount).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })
          );

          $('#tds_value_detuction').text(
            '₹ ' + parseFloat(firstRow.acctdsvalue).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })
          );

          $('#othersval').text(
            '₹ ' + parseFloat(firstRow.accotherdeduction).toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })
          );



          // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
          if (firstRow.inv_verfiy_attach) {
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
            $('#ven_inv_attach_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
              '</a>'
            );
          } else {
            $('#ven_inv_attach_2').text('N/A');
          }

          // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
          if (firstRow.po_ven_filename) {
            var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
            $('#ven_po_attach_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
              '</a>'
            );
          } else {
            $('#ven_po_attach_2').text('N/A');
          }

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

 <td style="text-align:right;">${row.rate || 0}</td>

      <td style="text-align:right;">${row.basicamt || 0}</td>

      <td style="text-align:right;">${row.gst || 0} %</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>
     


            <td style="text-align:right;font-weight:bold">₹ ${formattedAmount}</td>
        </tr>
    `;
          });

          //  <td style="text-align:right;">${row.advancepayment || 0}</td>
          // Format total with 2 decimals
          const formattedTotal = totalAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
          //  $('#invoice_no').text(res.row.invoice_no || '-');

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



    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: {
        bill_no: bill_no,
        action: 'vendor_bill_status'
      },
      success: function (response) {

        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {



          let tableHtml = '';
          let totalAmount = 0;

          res.data.forEach((row, index) => {

            tableHtml += `
                  <tr>
                    <td>${index + 1}</td>

                    <td>
                      ${row.bill_createdby}<br>
                      <span class="date-text">${row.created_date}</span><br>
                      <span class="status-text status-${row.bill_create_status}">
                        ${row.bill_create_status}
                      </span>
                    </td>

                    <td>
                      ${row.bill_approved}<br>
                      <span class="date-text">${row.vendor_bill_approval_date}</span><br>
                      <span class="status-text status-${row.vendor_bill_status}">
                        ${row.vendor_bill_status}
                      </span>
                    </td>

                    <td>
                      ${row.acc_approve}<br>
                      <span class="date-text">${row.vendor_account_approval_date}</span><br>
                      <span class="status-text status-${row.acc_status}">
                        ${row.acc_status}
                      </span>
                    </td>

                    <td>
                      ${row.finance_approve}<br>
                      <span class="date-text">${row.finance_approved_date}</span><br>
                      <span class="status-text status-${row.finance_status}">
                        ${row.finance_status}
                      </span>
                    </td>

                    <td>
                      ${row.managed_approve}<br>
                      <span class="date-text">${row.managment_team_approvaldate}</span><br>
                      <span class="status-text status-${row.management_status}">
                        ${row.management_status}
                      </span>
                    </td>
                     <td>
             <span class="date-text">${row.udr && row.udr !== '' ? `${row.udr}` : ''}</span><br>
             <span class="status-text status-${row.transfer_date}">
              ${row.transfer_date}
            </span><br>
             <span class="status-text status-${row.transfer_amount}">
              ${row.transfer_amount}
            </span><br>
             <span class="status-text">
            ${row.payment_status}
</span>
          </td>
                  </tr>
                  `;
          });

          $('#vendor_bill_status tbody').html(tableHtml);


        } else {
          $('#vendor_bill_status tbody').html('<tr><td colspan="6" class="text-center">No data found</td></tr>');

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

  // $(document).on('change', '.myCheck', function () {
  //     let dcNumbers = [];

  //     $(".myCheck:checked").each(function () {
  //         let dc_no = $(this).data("id");
  //         if (dc_no && !dcNumbers.includes(dc_no)) {
  //             dcNumbers.push(dc_no);
  //         }
  //     });

  //     // ✅ Log the result properly
  //     console.log("Selected DC Numbers:", dcNumbers);

  //     // ✅ Update the span with comma-separated dc_numbers

  // // Join without space after comma
  // let dc_number_str = dcNumbers.join(",");  // No space

  // // Update span (display)
  // $('#dc_number').text(dc_number_str);

  // });
  $(document).ready(function () {
    $('#select_all').on('change', function () {
      let isChecked = $(this).is(':checked');
      $('.myCheck').prop('checked', isChecked);
      updateDcNumbers();
    });

    $(document).on('change', '.myCheck', function () {
      if (!$(this).is(':checked')) {
        $('#select_all').prop('checked', false);
      } else if ($('.myCheck:checked').length === $('.myCheck').length) {
        $('#select_all').prop('checked', true);
      }
      updateDcNumbers();
    });

    function updateDcNumbers() {
      let dcNumbers = [];
      $('.myCheck:checked').each(function () {
        let dc_no = $(this).data('id');
        if (dc_no && !dcNumbers.includes(dc_no)) {
          dcNumbers.push(dc_no);
        }
      });

      let dc_number_str = dcNumbers.join(',');
      $('#dc_number').text(dc_number_str);
      $('#dc_number_input').val(dc_number_str);

      // Log to console:
      console.log("Selected DC Numbers:", dc_number_str);
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById("select_all");
    const checkboxes = document.querySelectorAll(".myCheck");

    // Check all by default
    checkboxes.forEach(checkbox => checkbox.checked = true);
    selectAll.checked = true;

    // Update totals immediately
    updateTotalAmount();

    // Event listener for "Select All" checkbox
    selectAll.addEventListener("change", function () {
      checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
      updateTotalAmount();
    });

    // Event listener for individual checkboxes
    document.addEventListener("change", function (event) {
      if (event.target.classList.contains("myCheck")) {
        const checkedBoxes = document.querySelectorAll(".myCheck:checked");
        selectAll.checked = (checkedBoxes.length === checkboxes.length);
        updateTotalAmount();
      }
    });


    // function updateTotalAmount() {
    //   let total = 0;
    //   document.querySelectorAll(".myCheck:checked").forEach(checkbox => {


    //     const amount = parseFloat(checkbox.getAttribute('data-amnt')) || 0;
    //     total += amount;
    //   });

    //   const roundedTotal = Math.round(total);

    //   document.getElementById("ttl_amount").value = roundedTotal;
    //   // document.getElementById("ttl_span_amnt").textContent = '₹ ' + roundedTotal.toLocaleString('en-IN');
    //   document.getElementById("ttl_span_amnt").textContent =
    //     '₹ ' + parseFloat(roundedTotal).toLocaleString('en-IN', {
    //       minimumFractionDigits: 2,
    //       maximumFractionDigits: 2
    //     });
    // }
    function updateTotalAmount() {
      let total = 0;

      document.querySelectorAll(".myCheck:checked").forEach(checkbox => {
        const amount = parseFloat(checkbox.getAttribute('data-toatlamt') || checkbox.getAttribute('data-amnt')) || 0;
        total += amount;
      });

      let addChargeText = $('#add_charge').text().replace(/[^\d.-]/g, '');
      let additionalAmount = parseFloat(addChargeText) || 0;
      let overallTotal = total + additionalAmount;

      document.getElementById("ttl_amount").value = overallTotal.toFixed(2);

      document.getElementById("ttl_span_amnt").textContent =
        '₹ ' + overallTotal.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
    }


  });




  // function submit(){


  //   var app_sts = document.getElementById("acc_app_sts").value;

  //    var reject_reason = document.getElementById("reject_reason").value;

  //   var vendor_bill_no =   document.getElementById("bill_no_popup_1").textContent;


  //   if(app_sts == '2'){

  //     var data = {

  //       app_sts:app_sts,
  //       reject_reason:reject_reason,
  //       vendor_bill_no:vendor_bill_no,
  //       action:"rej_status_update"


  //     };

  //     alert('test');

  //     return;

  //      var ajax_url = sessionStorage.getItem("folder_crud_link");

  //     $.ajax({

  //       type:'POST',
  //       data:data,
  //       url:ajax_url,

  //       success:function(response){

  //         sweetalert('create', url);


  //       }
  //     });

  //   }

  //   else{
  //     showConfirmationModal();
  //   }
  // }


  function showConfirmationModal() {
    let totinvvalue = [];
    let vendcom = [];
    let invoiceUniqueIds = [];
    let billNos = [];


    let vendor_bulk_rate = [];
    let vendor_bulk_gsts = [];
    let basicamts = [];
    let withgsttotals = [];
    let tdsgsttoatls = [];
    let toatlamts = [];




let additional_amount = null;

    $(".myCheck:checked").each(function () {

      let invoiceVal = $(this).data("invoice_value");
      let invoiceunique_id = $(this).data("venunique_id");
      let engName = $(this).data("vendor-id"); // ✅ renamed
      let bill_no = $(this).data("billno");
      let name = $(this).data("vendcom");

      let toatlamtval = $(this).data("toatlamt");

      let vendor_bulk_rateval = $(this).data("vendor_bulk_rate");
      let vendor_bulk_gstval = $(this).data("vendor_bulk_gst");
      let basicamtval = $(this).data("basicamt");
      let withgsttotalval = $(this).data("withgsttotal");
      // let tdsgsttoatl = $(this).data("tdsgsttoatl");

//  let row_additional_amount = parseFloat($(this).data("additional-amount")) || 0;

  // take first available additional amount
  // if (additional_amount === 0 && row_additional_amount > 0) {
  //   additional_amount = row_additional_amount;
  // }


  let row_additional_amount = parseFloat(
    $(this).data("additional-amount")
);

if (
    additional_amount === null &&
    Number.isFinite(row_additional_amount)
) {
    additional_amount = row_additional_amount;
}

      // Collect unique bill numbers
      if (bill_no && !billNos.includes(bill_no)) {
        billNos.push(bill_no);
      }

      // Collect unique vendor names
      if (name && !vendcom.includes(name)) {
        vendcom.push(name);
      }

      // Collect engineer names
      // if (engName && !bulk_eng_name.includes(engName)) {
      //     bulk_eng_name.push(engName);
      // }

      // Only collect valid numbers
      if (!isNaN(invoiceVal) && invoiceVal !== "" && invoiceVal !== null) {

        basicamts.push(parseFloat(basicamtval));
        withgsttotals.push(parseFloat(withgsttotalval));


        totinvvalue.push(parseFloat(invoiceVal));
        vendor_bulk_rate.push(parseFloat(vendor_bulk_rateval));
        vendor_bulk_gsts.push((vendor_bulk_gstval));

        //  tdsgsttoatls.push((tdsgsttoatl));
        toatlamts.push((toatlamtval));


        invoiceUniqueIds.push(invoiceunique_id);
      }
    });

    // Validate selection
    if (totinvvalue.length === 0) {
      Swal.fire('Warning', 'Please select at least one valid invoice.', 'warning');
      return;
    }

    // Ensure all selected invoices are from the same vendor
    if (vendcom.length > 1) {
      Swal.fire('Error', 'Please select invoices from only one vendor at a time.', 'error');
      return;
    }

   


    let uniqueVendorName = vendcom[0] || '';

    let totalbasicamts = basicamts.reduce((sum, val) => sum + val, 0);
    let totalwithgsttotals = withgsttotals.reduce((sum, val) => sum + val, 0);
    // let totalwithgsttotals = withgsttotals;


    let totalSum = totinvvalue.reduce((sum, val) => sum + val, 0);
    let totalsumvendor_bulk_rateval = vendor_bulk_rate.reduce((sum, val) => sum + val, 0);


    let withgsttotinvuni = vendor_bulk_gsts[0] || '';

    let toatlamtvalsval = toatlamts.reduce((sum, val) => sum + val, 0);

   
    // $('#totinvvalue').val(totalSum.toFixed(2));
    $('#basicamount').val(totalbasicamts.toFixed(2));
    $('#basicamount1').text(totalbasicamts.toFixed(2));

    // $('#add_charhes_1').val(additional_amount);
    // $('#add_charhes_2').text(additional_amount);
    
    $('#withtotinvvalue').val(totalwithgsttotals);
    $('#withtotinvvalue1').text(totalwithgsttotals);
    // $('#totinvvalue').val(totalsumvendor_bulk_rateval.toFixed(2));
    $('#withgsttotinvvalue').val(withgsttotinvuni + '%');
    $('#withgsttotinvvalue1').text(withgsttotinvuni + '%');

    // $('#netamountlab').text(totalnetamount);
    // $('#totalamount').val(toatlamtvalsval);
    // $('#totalamount1').text(toatlamtvalsval);
    $('#vendcom').val(uniqueVendorName);
    $('#vendorbill_no').val(billNos.join(', '));
    $('#invverifyunique_id').val(invoiceUniqueIds.join(','));
    // $('#bulk_eng_name').val(bulk_eng_name.join(','));
additional_amount =
    additional_amount === null
        ? 0
        : additional_amount;

let grossAmount = toatlamts.reduce(
    function (sum, value) {
        return sum + (parseFloat(value) || 0);
    },
    0
);

/*
 * Example:
 * 20300 + (-300) = 20000
 */
let finalBillAmount =
    grossAmount + additional_amount;

$('#add_charhes_1').val(
    additional_amount.toFixed(2)
);

$('#add_charhes_2').text(
    additional_amount.toFixed(2)
);

$('#totalamount').val(
    finalBillAmount.toFixed(2)
);

$('#totalamount1').text(
    finalBillAmount.toFixed(2)
);
    // Format invoice list
    let formattedInvoiceList = totinvvalue
      .map(val => '₹ ' + val.toLocaleString('en-IN', { minimumFractionDigits: 2 }))
      .join(', ');

    // Update modal fields
    // $('#totinvvalue1').text('₹ ' + totalSum.toLocaleString('en-IN', { minimumFractionDigits: 2 }));
    $('#totinvvalue1').text('₹ ' + totalsumvendor_bulk_rateval.toLocaleString('en-IN', { minimumFractionDigits: 2 }));

    // $('#withgsttotinvvalue1').text(withgsttotinvuni);


    $('#vendcom1').text(uniqueVendorName);
    $('#modal_vendor_name').text(uniqueVendorName);
    $('#modal_invoice_list').text(formattedInvoiceList);

    // Show modal
    $('#confirmationModal').modal('show');
  }

  $(document).ready(function () {
    // Run deduction calculation when page ready
    getdetuction();

    // Remove red border when typing or value auto-updates
    $('#tdsvalue, #ottdsvalue,#tdsvaluepercentage').on('input', function () {
      removeRedBorder(this);
    });

    // Initial validation: mark empty fields red
    validateDeductionFields();
  });

  function validateDeductionFields() {
    $('#tdsvalue, #ottdsvalue,tdsvaluepercentage').each(function () {
      if (!$(this).val() || $(this).val().trim() === "") {
        $(this).css('border', '1px solid red');
      } else {
        $(this).css('border', '1px solid #ced4da');
      }
    });
  }

  function removeRedBorder(input) {
    if ($(input).val().trim() !== '') {
      $(input).css('border', '1px solid #ced4da'); // ✅ Remove red border
    } else {
      $(input).css('border', '1px solid red'); // Keep red if still empty
    }
  }

  function getdetuction(source = '') {
    // Allow only numbers and one decimal point in input
    $('#tdsvalue, #ottdsvalue,#tdsvaluepercentage').on('input', function () {
      this.value = this.value.replace(/[^0-9.]/g, '');
      this.value = this.value.replace(/(\..*)\./g, '$1');
    });

    let totalInvoice = parseFloat($('#totinvvalue').val()) || 0;
    let tdsvaluepercentages = parseFloat($('#tdsvaluepercentage').val());
    let basicamt = parseFloat($('#basicamount').val());
    // let add_charge = parseFloat($('#add_charge').val());
    let tdsgsttoatl = 0;
    if (source === 'tdsvalue') {
      let manualTds = parseFloat($('#tdsvalue').val());
      if (Number.isFinite(manualTds)) {
        tdsgsttoatl = Math.round(manualTds);
        $('#tdsvalue').val(tdsgsttoatl.toFixed(2));
        removeRedBorder($('#tdsvalue'));
      }
    } else {
      if (Number.isFinite(tdsvaluepercentages) && Number.isFinite(basicamt)) {
        tdsgsttoatl = Math.round(basicamt * (tdsvaluepercentages / 100));
        // Auto-fill calculated TDS deduction (rounded to nearest whole rupee)
        $('#tdsvalue').val(tdsgsttoatl.toFixed(2));
        removeRedBorder($('#tdsvalue'));
      } else if ($('#tdsvalue').val() !== '' && Number.isFinite(parseFloat($('#tdsvalue').val()))) {
        tdsgsttoatl = Math.round(parseFloat($('#tdsvalue').val()));
        $('#tdsvalue').val(tdsgsttoatl.toFixed(2));
        removeRedBorder($('#tdsvalue'));
      }
    }

    let tdsValue = parseFloat($('#tdsvalue').val());
    let ottdsvalue = parseFloat($('#ottdsvalue').val());
    let totalamount1 = parseFloat($('#totalamount').val());
    let advanceamount = parseFloat($('#adpayment').val());
    let totaltdsvalue = parseFloat($('#totaltdsvalue').val());
    let add_charhes_1 = parseFloat($('#add_charhes_1').val());


    // Calculate the net amounts
    // let totalnetamount = (add_charhes_1 + totalamount1 - tdsValue - ottdsvalue );
    // let totalnetamountadvance = (totalamount1 - tdsValue - ottdsvalue - advanceamount);
    tdsValue = Number.isFinite(tdsValue)
    ? tdsValue
    : 0;

ottdsvalue = Number.isFinite(ottdsvalue)
    ? ottdsvalue
    : 0;

advanceamount = Number.isFinite(advanceamount)
    ? advanceamount
    : 0;

/*
 * Additional charge is already included
 * in totalamount1.
 */
let totalnetamount =
    totalamount1 -
    tdsValue -
    ottdsvalue -
    advanceamount;

if (totalnetamount < 0) {
    totalnetamount = 0;
}

let formattedNetAmount =
    totalnetamount.toFixed(2);

$('#netamount').val(
    formattedNetAmount
);

$('#netamountlab').text(
    formattedNetAmount
);
    let totaltdsamount = (totalamount1 - tdsValue);
    // If the total net amount is negative, set it to 0
    if (totalnetamount < 0) {
      totalnetamount = 0;
    }

    // Format the amounts to two decimal places
    let formattedTdsAmount = totaltdsamount.toFixed(2);
    // let formattedNetAmount = totalnetamount.toFixed(2);
    // let formattedNetAmountAdvance = totalnetamountadvance.toFixed(2);

    // Update the TDS value fields
    $('#totaltdsvalue').val(formattedTdsAmount);
    $('#totaltdsvaluelab').text(formattedTdsAmount);

    // Check if the advance amount is empty or 0
    // if (!advanceamount || advanceamount === "") {
    //   // If no advance amount, display the standard net amount
    //   $('#netamount').val(formattedNetAmount);
    //   $('#netamountlab').text(formattedNetAmount);
    // } else {
    //   // If there's an advance amount, display the net amount with advance deduction
    //   $('#netamount').val(formattedNetAmountAdvance);
    //   $('#netamountlab').text(formattedNetAmountAdvance);
    // }



    // Update display values
    $('#tdsvaluelab').text(Number.isFinite(tdsValue) ? tdsValue.toFixed(2) : '0.00');
    $('#ottdsvaluelab').text(ottdsvalue.toFixed(2));

    // Check & update red borders again
    validateDeductionFields();
  }


  $('#submit').on('click', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Get values from inputs
    var unique_id = $('#invverifyunique_id').val();
    var accid = $('#accid').val();
    var accbillissuedate = $('#accbillissuedate').val();
    var totinvvalue = $('#totinvvalue').val();
    var tdsvalue = $('#tdsvalue').val();
    var ottdsvalue = $('#ottdsvalue').val();
    var overalltotpayment = $('#overalltotpayment').val();
    var netamount = $('#netamount').val();
    var totaltdsvalue = $('#totaltdsvalue').val();
    var adpayment = $('#adpayment').val();
    let add_charge = parseFloat($('#add_charhes_1').val()) || parseFloat($('#add_charge').text().replace(/[^\d.-]/g, '')) || 0;


    var vendcom = $('#vendcom').val();
    var approved_by = $('#approved_by').val();
    var vendorbill_no = $('#vendorbill_no').val();
    var otremarks = $('#otremarks').val();
    var tdsvaluepercentage = $('#tdsvaluepercentage').val();
    // alert(tdsvaluepercentage);


    //  // Validation: Make tdsvalue and ottdsvalue mandatory
    //     if (!tdsvalue) {
    //         Swal.fire('Validation Error', 'Please enter TDS Value', 'warning');
    //         $('#tdsvalue').focus();
    //         return; // Stop execution
    //     }
    //     if (!ottdsvalue) {
    //         Swal.fire('Validation Error', 'Please enter OT Other Detuction Value', 'warning');
    //         $('#ottdsvalue').focus();
    //         return; // Stop execution
    //     }
    if (!tdsvalue) {
      $('#tdsvalue').css('border', '1px solid red').focus();
      Swal.fire('Validation Error', 'Please enter TDS Value', 'warning');
      return;
    }
    if (!ottdsvalue) {
      $('#ottdsvalue').css('border', '1px solid red').focus();
      Swal.fire('Validation Error', 'Please enter Other Deduction Value', 'warning');
      return;
    }

    if (!tdsvaluepercentage) {
      $('#tdsvaluepercentage').css('border', '1px solid red').focus();
      Swal.fire('Validation Error', 'Please enter tds percentage', 'warning');
      return;
    }

    if (!adpayment) {

      Swal.fire('Validation Error', 'Please enter Advance Payment Amount', 'warning');
      return;

    }


    // Create FormData
    var formData = new FormData();
    formData.append('accid', accid);
    formData.append('accbillissuedate', accbillissuedate);
    formData.append('totinvvalue', totinvvalue);
    formData.append('tdsvalue', tdsvalue);
    formData.append('ottdsvalue', ottdsvalue);
    formData.append('add_charge', add_charge);
    formData.append('tdsvaluepercentage', tdsvaluepercentage);
    // formData.append('overalltotpayment', overalltotpayment);
    formData.append('netamount', netamount);
    formData.append('totaltdsvalue', totaltdsvalue);

    formData.append('adpayment', adpayment);


    formData.append('approved_by', approved_by);
    formData.append('vendorbill_no', vendorbill_no);
    formData.append('unique_id', unique_id);
    // formData.append('bulk_eng_name', bulk_eng_name);


    // bulk_eng_name
    formData.append('otremarks', otremarks);


    formData.append('action', 'inv_verify_update');

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res;
        try {
          res = JSON.parse(response);
        } catch (err) {
          console.error("Invalid JSON response:", response);
          Swal.fire('Error', 'Invalid server response', 'error');
          return;
        }

        // Close the modal properly
        $('#confirmationModal').modal('hide');
        $('#viewModal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');

        // Update visible labels
        $('#totinvvalue1').text(totinvvalue || '-');
        $('#vendcom1').text(vendcom || '-');
        $('#accbillissuedate1').text(accbillissuedate || '-');

        // Show SweetAlert success and reload page after
        Swal.fire({
          icon: 'success',
          title: 'Saved!',
          text: 'Accounts Bill successfully updated.',
          timer: 2000,
          showConfirmButton: false,
          willClose: () => {
            // Reload the page when SweetAlert closes
            window.location.reload();
          }
        });
      },

      error: function (xhr, status, error) {
        $('#confirmationModal').modal('hide');
        $('#viewModal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Something went wrong: ' + error
        });
      }
    });
  });

  // Your vendor_payment function (only called after confirmation)
  function vendor_payment() {

    // showConfirmationModal();
    // then->
    // alert();
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
      data: { action: "generate_vendor_bill_no" },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status && res.bill_no) {
          var billNo = res.bill_no;

          // Now send each entry with the same billNo
          checkedData.forEach(function (entry, index) {
            // console.log(entry.vendor_id);
            //  $('#vendorid').val(entry.vendor_id || '-');
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

            $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              success: function (resp) {
                console.log("Saved for DC: " + entry.dc_no);
                if (index === checkedData.length - 1) {
                  sweetalert("create", url);
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



  function print_view_2(file_name) {

    window.location = 'uploads/vendor_creation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
  }
  function print_pdf_2(file_name) {
    // alert();

    onmouseover = window.open('uploads/vendor_creation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }


</script>

