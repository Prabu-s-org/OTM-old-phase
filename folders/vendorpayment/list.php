<style>
  i.fa.fa-edit {
    font-size: 20px;
    color: green;
  }

  i.fa-sharp.fa-solid.fa-trash {
    font-size: 20px;
    color: green;
  }

  .date-text {
    font-size: 12px;
    color: #6c757d;
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

  .mandatory-warning {
    font-size: 15px;
    /* increase size */
    font-weight: 600;
    /* slightly bold */
    text-align: left;
    /* force left alignment */
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

  /* #file {
    border: 2px solid red; /* Red border */
</style>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-Vm3jzZn+kMXU+LZ8p4iV5QlUuPjKoUzx1dRrt+J+rXxGQ+O4bEiXn1x3G8w7EoIjPv7MxqFtmKj/NF4w+8nG0A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

<?php
// 
// $screen_id_val = '641adb14666c465380';
$screen_id_val = '68407937dc4dc98743';


session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
$state_code = 'INV'; // Example: dynamically assign based on logged-in user or form input
$newVendorId = vendor_generate_invoiceid($state_code);
$user_unique_id = $_SESSION["unique_id"];
$session_approved_by = $_SESSION["staff_name"];

$team_member_list = assign_team_member();
$team_member_filter_options = [];

if ($team_member_list) {
  foreach ($team_member_list as $team_member) {
    $team_member_filter_options[] = [
      "staff_name" => $team_member["staff_name"],
      "display_name" => $team_member["staff_name"]
    ];
  }
}

$team_member_options = select_option($team_member_filter_options, "All Team Members");


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
<?php
$main_unique_id = unique_id();
?>
<!-- <li class="nav-item" onclick="stock_position_pending()">
<li class="nav-item" onclick="complete_list_datatable()"> -->
<input type="hidden" name=" main_unique_id " id="main_unique_id" value="<?php echo $main_unique_id ?>">
<div class="col-xxl-12">
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
            <span class="d-none d-sm-block">Bill Pending</span>
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

                      <th style="text-align: center;">Status</th>
                      <th style="text-align: center;">Bill Reject Reason</th>
                      <th style="text-align: center;">Bill Rejected By</th>




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
                  <th style="text-align: center;">Bill Date / Bill Date</th>
                  <th style="text-align: center;">Invoice No / Invoice Date.</th>
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

<input type="hidden" id="hidden_bank_file">


<input type="hidden" id="hidden_pan_file">






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
                <!-- Vendor Details -->
                <div class="col-md-6">
                  <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor
                    Details</h6>

                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_name_popup_1"></span></strong><br><strong><span id="vendor_c_name_popup_1"></span></strong>
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

                <!-- Vendor Bank Details -->
                <div class="col-md-6">
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
                    <div class="detail-value">
                      <i data-feather="map-pin" style="width:15px; height:15px;"></i>
                      <span id="bank_branch_popup_1"></span>
                    </div>
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
                  <!-- style="display:none" -->
                  <p class="mb-1" style="display:none">
                    unique_id: <b><span id="unique_id"></span></b>
                  </p>
                </div>
              </div>

               <div class="col-md-6">
                  <small id="proofWarning" class="text-danger mandatory-warning" style="display:none;">
                    *Vendor PAN proof and Bank proof are Mandatory to Create Bill
                  </small>
                </div>
              <div class="row g-2 align-items-end mt-3 mb-2">
                <div class="col-md-6">
                  <label for="vendor_table_search" class="form-label mb-1">Search</label>
                  <input type="text" id="vendor_table_search" class="form-control"
                    placeholder="Search DC No, PO No, Invoice No, Consignee">
                </div>
                <div class="col-md-4">
                  <label for="vendor_team_filter" class="form-label mb-1">Team Member</label>
                  <select id="vendor_team_filter" class="form-select">
                    <?php echo $team_member_options; ?>
                  </select>
                </div>
              </div>

              <div class="table-responsive mt-3">

                <table id="vendor_datatable"  class="pt-2 table table-bordered nowrap table-striped align-middle ">
    
    <thead class="table-light">
      <tr>
        <th style="text-align:center;width:65px">
          <input type="checkbox" id="select_all">&nbsp;&nbsp;All<br>
        </th>
        <th style="text-align:center;">S.No.</th>
        <th style="text-align:center;">DC No / Date</th>
        <th style="text-align:center;">PO No / Date</th>
        <th style="text-align:center;">Invoice No / Date</th>
        <th style="text-align:center;">Team Member</th>
        <th style="text-align:center;">Invoice Qty</th>
        <th style="text-align:center;">Consignee Address</th>
        <th style="text-align:center;">Unit Price</th>
        <th style="text-align:center;">Basic amount</th>
        <th style="text-align:center;">GST</th>
        <th style="text-align:center;">GST Amount</th>
        <th style="text-align:center;">Total Amount</th>
      </tr>
    </thead>

    <tbody>
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
                <input type="hidden" id="additional_amount" class="form-control d-inline" style="width: 200px; display: inline;"
                readonly>
              <div class="row m-2">

               
                <div class="hstack gap-2 justify-content-end d-print-none mt-4 mb-3">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                  <button type="button" id="submitbtn" style="display:none;" class="btn btn-success"
                    onclick="showConfirmationModal()">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered "> <!-- modal-lg makes it bigger -->
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Vendor Invoice Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3">IS vendor Invoice Available?</p>
      </div>

      <div class="modal-footer" id="confirmationButtons">
        <button type="button" class="btn btn-secondary" id="printPageButton">No</button>
        <button type="button" class="btn btn-primary" id="confirmSubmit">Yes</button>
      </div>

    </div>
  </div>
</div>



<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal1" tabindex="-1" aria-labelledby="confirmationModalLabel1"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered "> <!-- modal-lg makes it bigger -->
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel1">Vendor Invoice Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- <p class="mb-3">Are you sure you want to submit the vendor invoice?</p> -->
        <!-- Font Awesome 6 CDN -->

        <!-- Hidden section (shown after Yes is clicked) -->
        <div id="selectedInvoiceDetails" style="display:none;">
          <!-- Font Awesome 6 (latest stable version) -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Vendor Print:</label>
            <div class="col-sm-8">
              <a id="vendorPrintLink" href="#" title="View Print Format">
                <i class="fa-solid fa-print fa-2x" style="color:#333;"></i>
              </a>
              <input type="hidden" id="print" name="print">
            </div>
          </div>

          <!-- Use Bootstrap grid for neat alignment -->
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Vendor Invoice:</label>
            <div class="col-sm-8">
              <input type="hidden" id="vendorid" name="vendorid" value="<?php echo $newVendorId ?>" readonly>
              <label id="vendorid1" class="form-label fw-normal mt-2"><?php echo $newVendorId ?></label>
            </div>

          </div>
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Invoice ID:</label>
            <div class="col-sm-4">
              <input type="text" id="userinvoiceid" class="form-control" name="userinvoiceid"
                oninput="validateInvoiceID(this)">
            </div>

          </div>


          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Vendor Invoice Issue Date:</label>
            <div class="col-sm-8">
              <input type="hidden" id="invoice_date" name="invoice_date" readonly value="<?php echo date('d-m-Y'); ?>">
              <label id="invoice_date1" class="form-label fw-normal mt-2"><?php echo date('d-m-Y'); ?></label>
            </div>
          </div>
 <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Additinal Charges:<span class="text-danger">*</span></label>
              <div class="col-sm-4">
                <input type="number" id="add_charge" name="add_charge" class="form-control"
                 oninput="gettotalinvoice();">
              </div>

          </div>
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Total Invoice Amount:</label>
            <div class="col-sm-8">
              <input type="hidden" id="invoice_value" name="invoice_value" readonly>
              <input type="hidden" id="base_invoice_value" name="base_invoice_value" readonly>
              <label id="invoice_value1" class="form-label fw-normal mt-2"></label>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">Vendor Company Name:</label>
            <div class="col-sm-8">
              <input type="hidden" id="vendcom" name="vendcom" value="<?php echo $newVendorId; ?>" readonly>
              <label id="vendcom1" class="form-label fw-normal mt-2"><?php echo $newVendorId; ?></label>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">
              Upload vendor Invoice Copy(PDF):<span style="color:red">*</span>
            </label>
            <div class="col-sm-8">
              <input type="file" id="file" accept="application/pdf" name="file" class="form-control mt-2" required>
              <input type="hidden" id="old_file">
              <input type="hidden" name="invverifyunique_id" id="invverifyunique_id">
              <input type="hidden" name="unique_id" id="unique_id">

            </div>
          </div>


          <div class="row mb-3">
            <label class="col-sm-4 col-form-label fw-semibold">
              Upload vendor PO Copy(PDF):<span style="color:red">*</span>
            </label>

            <div class="col-sm-8">
              <input type="file" id="po_file" accept="application/pdf" name="po_file" class="form-control mt-2" required>
             
            </div>
          </div>

          <style>
            .is-invalid {
              border: 2px solid red !important;
              /* Red border for invalid file input */
            }
          </style>
          <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $user_unique_id ?>">

          <div class="text-end">
            <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Submit">
            <button type="button" id="close" class="btn btn-secondary" onclick="handleClose()">Close</button>
          </div>

        </div>
      </div>

      <!-- <div class="modal-footer" id="confirmationButtons">
        <button type="button" class="btn btn-secondary" id="printPageButton">No</button>
        <button type="button" class="btn btn-primary" id="confirmSubmit">Yes</button>
      </div> -->

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

        <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Vendor Completed
          Payment
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
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Invoice
                    Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="ven_inv_date"></span></b>
                  <p class="mb-1">

                    <!-- <i style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                    <b><span id="ven_inv_attach_2"></span></b> -->
                    <b>Invoice Attach: <span id="ven_inv_attach_2"></span></b>
                      


                  </p>
                  <p class="mb-1">

                  
                      <b>PO Attach: <span id="ven_po_attach_2"></span></b>


                  </p>
                </div>
              </div>
              <div class="table-responsive mt-3">
                <table id="vendor_datatable_bill_popup"
                  class="table table-bordered table-striped table-hover align-middle">
                  <tbody>
                    <thead class="table-light">
                      <tr>
                        <th style="text-align:center;">S No.</th>
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
                  </tbody>
                </table>
              </div>

              <div class="row mt-2" style="margin:0 15px;">
                <!-- First row: Bill Raised By + Total Amount -->
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                  <div>
                    <span class="aligned-label">Bill Raised By:</span>
                    <span id="approver" class="aligned-value" style="font-size:15px;">0</span>
                  </div>
 <div>
                    <span class="aligned-label">Additional Charges:</span>
                    <span id="additional_amount_lab" name="additional_amount_lab" class="aligned-value" style="font-size:17px;">0</span>
                  </div>
                  <div>
                    <span class="aligned-label">Total Amount:</span>
                    <span id="sum_of_amount" name="sum_of_amount" class="aligned-value" style="font-size:17px;">0</span>
                    <input type="hidden" id="ttl_amount" readonly>
                  </div>
                </div>

                <!-- Second row: Bill Raised Date -->
                <div class="col-md-12 d-flex justify-content-between align-items-center mt-1">
                  <div>
                    <span class="aligned-label">Bill Raised Date:</span>
                    <span id="approvedate" class="aligned-value" style="font-size:15px;">0</span>
                  </div>


                </div>
              </div>

              <div class="table-responsive mt-3">
                <table id="vendor_bill_status" class="table table-bordered table-striped table-hover align-middle">
                  <tbody>
                    <thead class="table-light">
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
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                  <i class="bi bi-x-circle"></i> Close
                </button>
              </div>


              <style>
                .aligned-label {
                  display: inline-block;
                  width: 130px;
                  /* fixed width so all colons align */
                  font-weight: 500;
                }

                .aligned-value {
                  font-weight: 600;
                  color: #506018 !important;
                }
              </style>



            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <th><?php echo '<input type="checkbox" id="select_all">' ?>&nbsp;&nbsp;Selection<br></th> -->

<script>
   function gettotalinvoice() {

    // ? always use original base amount
    let baseAmount = parseFloat(document.getElementById('base_invoice_value').value) || 0;

    // ?? additional charge
    let addCharge = parseFloat(document.getElementById('add_charge').value) || 0;

    // ?? total
    let total = baseAmount + addCharge;

    // ?? update values
    document.getElementById('invoice_value').value = total.toFixed(2);
    document.getElementById('ttl_amount').value = total.toFixed(2);
    document.getElementById('additional_amount').value = addCharge.toFixed(2);
    document.getElementById('invoice_value1').innerText = total.toFixed(2);
}



  function validateInvoiceID(input) {
    // Allow only letters, numbers, and underscores/hyphens
    input.value = input.value.replace(/[^a-zA-Z0-9_-]/g, '');
  }

  function handleClose() {
    $('#confirmationModal1').modal('hide');
  }


  // Function to show the confirmation modal
  function showConfirmationModal() {
    // alert("hi")
    // Show the confirmation modal
    $('#confirmationModal').modal('show');
  }



  $('#printPageButton').on('click', function () {
    // Hide the confirmation modal
    $('#confirmationModal').modal('hide');

    // Get the unique_id value from the <span> element
    // var unique_id = document.getElementById('unique_id').textContent; // or .innerText
    // alert(unique_id);
    //  var unique_id = $('#confirmationModal').data('unique_id');
    //  var unique_id = $('#confirmationModal').data('vendor_id');
    var unique_id = $('#confirmationModal').data('vendor_id');
    var invunique_id = $('#confirmationModal').data('unique_id');

    //  alert(invunique_id);
    var dc_number = document.getElementById('dc_number').textContent; // or .innerText
    // alert(unique_id);
    // Debug: Print the unique_id and constructed URL
    console.log("Unique ID: " + unique_id); // Check if the unique_id is correct
    // var url = 'http://122.165.127.123:35267/otm_beta/index.php?file=vendorpayment/update_1&unique_id=' + unique_id;
    // var url = 'http://122.165.127.123:35267/otm_beta/index.php?file=vendorpayment/update_1&unique_id=' + unique_id&unique_id=' + unique_id;
    var url = 'index.php?file=vendorpayment/update_1&unique_id=' + unique_id + '&dc_number=' + dc_number;

    // Debug: Check the constructed URL
    console.log("Constructed URL: " + url); // Ensure the URL is correct

    // Open the page in a new window or tab
    var printWindow = window.open(url);

    // Check if the printWindow is opened properly
    if (printWindow) {
      // Wait for the new window to fully load before triggering print
      printWindow.onload = function () {
        printWindow.print();
      };
    } else {
      console.error("Failed to open the new window. Check if pop-ups are blocked.");
    }
  });





  // Step 1: Show modal and append selected invoice numbers
  function showConfirmationModal() {

    var invoiceNumbers = [];
    var invoiceDates = [];
    var invoiceValues = [];

    var invoice_unique_ids = []; // data-unique_id
    var vendor_ids = [];         // data-vendor-id
    var vendcom = [];

    $(".myCheck:checked").each(function () {

      invoiceNumbers.push($(this).data("invoice-num"));
      invoiceDates.push($(this).data("invoice_date"));
      invoiceValues.push($(this).data("invoice_value"));

      // ? CORRECT MAPPING
      // invoice_unique_ids.push($(this).data("unique_id"));
      invoice_unique_ids.push($(this).data("unique_id"));
      vendor_ids.push($(this).data("vendor-id"));

      var name = $(this).data("vendcom");
      if (vendcom.indexOf(name) === -1) {
        vendcom.push(name);
      }
    });

    if (invoiceNumbers.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: 'Please select at least one entry'
      });
      return;
    }


    var pan_proof = document.getElementById('hidden_pan_file').value;
    var bank_proof = document.getElementById('hidden_bank_file').value;

    if (!pan_proof) {
      Swal.fire({
        icon: 'warning',
        title: 'Required Documents Missing',

        html: 'Please upload <b>PAN copy</b> for vendor'
      });
      return false;
    }

    if (!bank_proof) {
      Swal.fire({
        icon: 'warning',
        title: 'Required Documents Missing',

        html: 'Please upload <b>Bank Proof</b> for vendor'
      });
      return false;
    }


    // ? STORE PROPERLY IN MODAL
    // $('#confirmationModal').data('invoice_unique_id', invoice_unique_ids.join(','));
    $('#confirmationModal').data('invoice_unique_id', invoice_unique_ids.join(','));
    $('#confirmationModal').data('vendor_id', vendor_ids.join(','));
    $('#confirmationModal').data('invoiceNumbers', invoiceNumbers);
    $('#confirmationModal').data('invoiceDates', invoiceDates);
    $('#confirmationModal').data('invoiceValues', invoiceValues);
    $('#confirmationModal').data('vendcom', vendcom[0]);
    // $('#confirmationModal').data(
    //   'invoice_unique_id',
    //   invoice_unique_ids.join(',')
    // );
    $('#confirmationModal').modal('show');
    $('#selectedInvoiceDetails').hide();
  }


  $(document).ready(function () {
    // $('#confirmSubmit').on('click', function() {

    //     $('#confirmSubmit').show();
    // $('#printPageButton').show();
    // });
    // });
    $('#confirmSubmit').on('click', function () {
      // Show confirmation modal and populate values
      $('#selectedInvoiceDetails').show();
      $('#confirmationModal1').modal('show');
      //  var invoice_unique_id = $('#confirmationModal').data('invoice_unique_id'); // 
      var invoiceNumbers = $('#confirmationModal').data('invoiceNumbers');
      var invoiceDates = $('#confirmationModal').data('invoiceDates');
      var invoiceValues = $('#confirmationModal').data('invoiceValues');
      // var invoiceunique_id = $('#confirmationModal').data('unique_id');
      var invoiceunique_id = $('#confirmationModal').data('invoice_unique_id');
      // alert(invoiceunique_id);
      // var invoiceunique_id = $('#confirmationModal').data('vendor_id');
      var vendcom = $('#confirmationModal').data('vendcom');

      var vendor_id = $('#confirmationModal').data('vendor_id');

      // ? Calculate total sum
      var totalAmount = invoiceValues.reduce(function (sum, val) {
        return sum + parseFloat(val || 0);
      }, 0);
      // $('#invverifyunique_id').val(invoice_unique_id);
      $('#selectedInvoiceDetails #invoice_value1').text(totalAmount);
      $('#selectedInvoiceDetails #invoice_value').val(totalAmount);
      $('#selectedInvoiceDetails #base_invoice_value').val(totalAmount);
      $('#selectedInvoiceDetails #vendcom').val(vendcom);
      $('#selectedInvoiceDetails #vendcom1').text(vendcom);
      // $('#selectedInvoiceDetails #invverifyunique_id').val(invoiceunique_id.join(", "));
      $('#selectedInvoiceDetails #unique_id').val(vendor_id);
      //  $('#selectedInvoiceDetails #invverifyunique_id').val(invoiceunique_id);
      $('#invverifyunique_id').val(invoiceunique_id);



      // Get unique ID and DC number from page
      // var unique_id = document.getElementById('unique_id').textContent.trim();
      var unique_id = $('#confirmationModal').data('unique_id');
      var dc_number = document.getElementById('dc_number').textContent.trim();

      // ? Construct the invoice print URL
      var url = '/index.php?file=vendorpayment/update_1&unique_id=' + unique_id + '&dc_number=' + dc_number;


      // Hide modal
      $('#confirmationModal').modal('hide');
    });

  });

  $('#vendorPrintLink').on('click', function (e) {
    e.preventDefault();

    var unique_id = $('#unique_id').text().trim();
    var dc_number = $('#dc_number').text().trim();

    if (!unique_id || !dc_number) {
      alert('Missing required parameters.');
      return;
    }

    var url = '/otm_beta/index.php?file=vendorpayment/update_1'
      + '&unique_id=' + encodeURIComponent(unique_id)
      + '&dc_number=' + encodeURIComponent(dc_number);

    var printWindow = window.open(
      url,
      'VendorPrintWindow',
      'width=1000,height=800,top=100,left=200,resizable=yes,scrollbars=yes,status=no'
    );
    // Trigger the print dialog

    if (!printWindow) {
      alert("Please allow pop-ups for this site to open the print preview.");
    } else {
      printWindow.focus();
    }
  });


  // Remove red border when user selects a valid PDF file
  $('#file').on('change', function () {
    var file = this.files[0];
    if (file) {
      var fileType = file.type;
      if (fileType !== 'application/pdf') {
        Swal.fire({
          icon: 'error',
          title: 'Invalid File',
          text: 'Only PDF files are allowed!',
          confirmButtonText: 'OK'
        });
        $(this).val('');           // Clear input
        $(this).addClass('is-invalid'); // Add red border
      } else {
        $(this).removeClass('is-invalid'); // Remove red border if valid
      }
    }
  });

  $('#submit').on('click', function (e) {

    // alert('test');

    // return;
    e.preventDefault();

    var fileInput = $('#file')[0].files[0];
    
    var pofile    = $('#po_file')[0].files[0];
    // Selected file

    // File validation
    if (!fileInput) {
      Swal.fire({
        icon: 'warning',
        title: 'File Required',
        text: 'Please attach the verification document before submitting!',
        confirmButtonText: 'OK'
      });
      $('#file').addClass('is-invalid'); // Add red border
      return;
    } else {
      $('#file').removeClass('is-invalid'); // Remove red border if file selected
    }

    if (!pofile) {
      Swal.fire({
        icon: 'warning',
        title: 'File Required',
        text: 'Please attach the verification document before submitting!',
        confirmButtonText: 'OK'
      });
      $('#po_file').addClass('is-invalid'); // Add red border
      return;
    } else {
      $('#po_file').removeClass('is-invalid'); // Remove red border if file selected
    }

    // Collect other form data
    var invoice_no = $('#invoice_no').val();
    var userinvoiceid = $('#userinvoiceid').val();

    var invoice_date = $('#invoice_date').val();
    var unique_id = $('#invverifyunique_id').val();
    // alert(unique_id);
    var vendorid = $('#vendorid').val();
    var vendcom = $('#vendcom').val();
    var approved_by = $('#approved_by').val();
    var add_charge = $('#add_charge').val();
    // Create FormData
    var formData = new FormData();
    formData.append('invoice_date', invoice_date);
    formData.append('userinvoiceid', userinvoiceid);
    formData.append('unique_id', unique_id);
    formData.append('vendorid', vendorid);
    formData.append('vendcom', vendcom);
    formData.append('approved_by', approved_by);
    formData.append('file', fileInput);
    formData.append('pofile',pofile);
    formData.append('add_charge',add_charge);
    formData.append('action', 'inv_verify_update');

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
      url: ajax_url,
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        var res = JSON.parse(response);

        $('#confirmationModal').modal('hide');
        vendor_payment(); // Call your function to refresh table or UI

        Swal.fire({
          icon: 'success',
          title: 'Saved!',
          text: 'Invoice uploaded successfully.',
          timer: 2000,
          showConfirmButton: false
        });
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Something went wrong: ' + error
        });
      }
    });

  });

  // });



  // Optional: "No" button closes modal
  $('#printPageButton').on('click', function () {
    $('#confirmationModal').modal('hide');
  });


  function vendor_payment() {
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var vendor_name = $('#vendor_name').val();
    var ttl_amnt = parseFloat($('#ttl_amount').val()) || 0;
    var additional_amount = parseFloat($('#additional_amount').val()) || 0;
    var main_unique_id = $('#main_unique_id').val();
    var vendorid = $('#vendorid').val();
    var url = sessionStorage.getItem("list_link");

    if (!main_unique_id) {
      main_unique_id = Date.now() + "-" + Math.floor(Math.random() * 1000);
    }

    // Collect selected rows. These values come from crud.php -> vendor_payment_details.
    var checkedData = [];

    $(".myCheck:checked").each(function () {
      var checkbox = $(this);

      checkedData.push({
        dc_no: checkbox.data("id"),
        dc_date: checkbox.data("dcdate"),
        po_num: checkbox.data("po-num"),
        po_unique_id: checkbox.data("form_main_id"),
        invoice_no: checkbox.data("invoice-num"),
        invoice_qty: parseFloat(checkbox.data("qty")) || 0,
        rate: parseFloat(checkbox.data("rate")) || 0,
        gst: parseFloat(checkbox.data("gst")) || 0,
        amount: parseFloat(checkbox.data("amnt")) || 0,
        vendor_id: checkbox.data("vendor-id")
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

    // Correct aggregate values for the main bill row.
    // Do NOT add unit prices or GST percentages together.
    var totalQty = checkedData.reduce(function (sum, e) {
      return sum + e.invoice_qty;
    }, 0);

    var totalBasic = checkedData.reduce(function (sum, e) {
      return sum + (e.rate * e.invoice_qty);
    }, 0);

    var averageRate = totalQty > 0 ? (totalBasic / totalQty) : 0;

    var gstValues = [...new Set(
      checkedData.map(function (e) {
        return e.gst;
      })
    )];

    // Main table has one GST field. Store it only when every selected row has the same GST.
    var mainGst = gstValues.length === 1 ? gstValues[0] : 0;

    var selectedAmount = checkedData.reduce(function (sum, e) {
      return sum + e.amount;
    }, 0);

    // Step 1: Generate a single bill number.
    $.ajax({
      type: "POST",
      url: ajax_url,
      data: { action: "generate_vendor_bill_no" },
      success: function (response) {
        var res = (typeof response === 'string') ? JSON.parse(response) : response;

        if (!res.status || !res.bill_no) {
          Swal.fire('Error', 'Failed to generate vendor bill number', 'error');
          return;
        }

        var billNo = res.bill_no;

        // Step 2: Save one aggregate/main row.
        var mainData = {
          vendor_name: vendor_name,
          vendor_id: checkedData[0].vendor_id,
          po_num: checkedData.map(e => e.po_num).join(","),
          po_unique_id: checkedData.map(e => e.po_unique_id).join(","),
          dc_no: checkedData.map(e => e.dc_no).join(","),
          dc_date: checkedData.map(e => e.dc_date).join(","),
          invoice_no: checkedData.map(e => e.invoice_no).join(","),
          invoice_qty: totalQty,
          rate: averageRate.toFixed(2),
          gst: mainGst,
          amount: selectedAmount.toFixed(2),
          ttl_amount: ttl_amnt.toFixed(2),
          additional_amount: additional_amount.toFixed(2),
          bill_no: billNo,
          main_unique_id: main_unique_id,
          vendorid: vendorid,
          action: "payment_store_detail_1"
        };

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: mainData,
          success: function (resp) {
            var resObj = (typeof resp === 'string') ? JSON.parse(resp) : resp;

            if (resObj.msg !== "create") {
              Swal.fire('Error', 'Failed to save main table entry!', 'error');
              return;
            }

            // Step 3: Save each selected row separately.
            // This keeps its own qty/rate/GST/amount and avoids mixed-product multiplication.
            var completed = 0;
            var failed = 0;

            checkedData.forEach(function (entry) {
              var subData = {
                vendor_name: vendor_name,
                vendor_id: entry.vendor_id,
                po_num: entry.po_num,
                po_unique_id: entry.po_unique_id,
                dc_no: entry.dc_no,
                dc_date: entry.dc_date,
                invoice_no: entry.invoice_no,
                invoice_qty: entry.invoice_qty,
                rate: entry.rate,
                gst: entry.gst,
                amount: entry.amount,
                ttl_amount: ttl_amnt.toFixed(2),
                bill_no: billNo,
                main_unique_id: main_unique_id,
                action: "payment_store_detail"
              };

              $.ajax({
                type: "POST",
                url: ajax_url,
                data: subData,
                success: function (subResp) {
                  var subObj;

                  try {
                    subObj = (typeof subResp === 'string') ? JSON.parse(subResp) : subResp;
                  } catch (e) {
                    subObj = { status: false };
                  }

                  if (!subObj.status && subObj.msg !== 'already') {
                    failed++;
                  }

                  completed++;

                  if (completed === checkedData.length) {
                    if (failed > 0) {
                      Swal.fire('Error', 'One or more bill detail rows failed to save.', 'error');
                    } else {
                      sweetalert("create", url);
                    }
                  }
                },
                error: function () {
                  failed++;
                  completed++;

                  if (completed === checkedData.length) {
                    Swal.fire('Error', 'One or more bill detail rows failed to save.', 'error');
                  }
                }
              });
            });
          },
          error: function () {
            Swal.fire('Error', 'Network error while saving main table!', 'error');
          }
        });
      },
      error: function () {
        Swal.fire('Error', 'Network error while generating bill number!', 'error');
      }
    });
  }
  // Function to show the confirmation modal
  let vendorPaymentModalRows = [];

  function normalizeVendorModalValue(value) {
    return String(value || '').trim().toLowerCase();
  }

  function renderVendorPaymentModalTable(rows) {
    let tableHtml = '';

    if (rows && rows.length > 0) {
      rows.forEach((row, index) => {
        let bulkAmount = row.bulk_total_amount
          ? parseFloat(String(row.bulk_total_amount).replace(/,/g, ''))
          : 0;

        tableHtml += `
    <tr>
      <td>${row.checkbox || ''}</td>
      <td>${index + 1}</td>
      <td>${row.dc_number || ''}</td>
      <td>${row.po_num || ''}</td>
      <td>${row.invoice_no || ''}</td>
      <td>${row.approved_by || '-'}</td>
      <td style="text-align:right;">${row.invoice_qty || 0}</td>
      <td>${row.consignee_name ? capitalizeWords(row.consignee_name) : ''}</td>
      <td style="text-align:right;">${row.vendor_bulk_rate || 0}</td>
      <td style="text-align:right;">${row.basicamt || 0}</td>
      <td style="text-align:right;">${row.vendor_bulk_gst || 0} %</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>
      <td style="text-align:right; font-weight: bold;">
        ₹${bulkAmount.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })}
      </td>
    </tr>
  `;
      });
    } else {
      tableHtml = '<tr><td colspan="13" class="text-center">No data found</td></tr>';
    }

    $('#vendor_datatable tbody').html(tableHtml);
    $('#select_all').prop('checked', false);
    $('#ttl_amount').val('0.00');
    $('#ttl_span_amnt').text('₹ 0.00');
  }

  function applyVendorPaymentModalFilters() {
    const searchValue = normalizeVendorModalValue($('#vendor_table_search').val());
    const teamMember = normalizeVendorModalValue($('#vendor_team_filter').val());

    const filteredRows = vendorPaymentModalRows.filter(function (row) {
      const approvedBy = normalizeVendorModalValue(row.approved_by);
      const searchPool = [
        row.dc_number,
        row.po_num,
        row.invoice_no,
        row.consignee_name,
        row.approved_by
      ].map(normalizeVendorModalValue).join(' ');

      const matchesSearch = !searchValue || searchPool.includes(searchValue);
      const matchesTeam = !teamMember || approvedBy === teamMember;

      return matchesSearch && matchesTeam;
    });

    renderVendorPaymentModalTable(filteredRows);
  }

  $(document).on('input', '#vendor_table_search', function () {
    applyVendorPaymentModalFilters();
  });

  $(document).on('change', '#vendor_team_filter', function () {
    applyVendorPaymentModalFilters();
  });

  $(document).on('click', '.view-btn', function () {
    var po_num = $(this).data('ponum');

    var vendor = $(this).data('vendor');

    // alert(vendor);
    var vendor_id = $(this).data('vendor-id');

    //  alert(vendor_id);

    document.getElementById("po_num").value = po_num;
    document.getElementById("vendor_name").value = vendor;

    document.getElementById("vendor_id").value = vendor_id;
    // alert(vendor_id);

    $('#viewModal').modal('show');
    $('#select_all').prop('checked', false);
    $('#vendor_table_search').val('');
    $('#vendor_team_filter').val('');
    $('#hidden_pan_file').val('');
    $('#hidden_bank_file').val('');
    $('#pan_popup_1').html('-');
    $('#bank_popup_1').html('-');
    $('#proofWarning').hide();
    vendorPaymentModalRows = [];
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
        // console.log(res.summary_data.name);
        if (res.status && res.summary_data) {
          $('#vendor_name_popup_1').text(res.summary_data.company_name || '-');
          $('#vendor_c_name_popup_1').text(res.summary_data.name || '-');
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
          // PAN File
          if (res.summary_data.pan_attach_file_name) {
            var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
            $('#pan_popup_1').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" onerror="this.onerror=null;this.src=\'assets/images/pdf.png\';" height="20px" width="20px" alt="Preview PAN PDF"> ' +
              '<span style="font-size:12px;color:#506018;">' + res.summary_data.pan_attach_file_name + '</span>' +
              '</a>'
            );
            $('#hidden_pan_file').val(res.summary_data.pan_attach_file_name);
          } else {
            $('#pan_popup_1').text('N/A');
            $('#hidden_pan_file').val('');
          }

          // Bank Proof
          if (res.summary_data.bank_proof) {
            var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
            $('#bank_popup_1').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" onerror="this.onerror=null;this.src=\'assets/images/pdf.png\';" height="20px" width="20px" alt="Preview Bank PDF"> ' +
              '<span style="font-size:12px;color:#506018;">' + res.summary_data.bank_proof + '</span>' +
              '</a>'
            );
            $('#hidden_bank_file').val(res.summary_data.bank_proof);
          } else {
            $('#bank_popup_1').text('N/A');
            $('#hidden_bank_file').val('');
          }



          var pan_proof = document.getElementById('hidden_pan_file').value;
          //  alert(pan_proof);
          var bank_proof = document.getElementById('hidden_bank_file').value;

          // alert(bank_proof);prop('disabled', true)

          if (!pan_proof || !bank_proof) {
            $('#submitbtn').hide();
            $('#proofWarning').show();   // show red text
          } else {
            $('#submitbtn').show();
            $('#proofWarning').hide();
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
        action: 'vendor_payment_details'
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.data && res.data.length > 0) {
          vendorPaymentModalRows = res.data;
          applyVendorPaymentModalFilters();
          return;

          const firstRow = res.data[0];


          // $('#dc_number').text(res.summary_data.dc_number || '-');

          // Populate the table
          let tableHtml = '';

          res.data.forEach((row, index) => {
            // Ensure bulk_total_amount is safely handled
            let bulkAmount = row.bulk_total_amount
              ? parseFloat(String(row.bulk_total_amount).replace(/,/g, ''))
              : 0;

            // $('#invoice_no').text(row.invoice_no || '-');

            tableHtml += `
    <tr>
      <td>${row.checkbox || ''}</td>
      <td>${index + 1}</td>
      <td>${row.dc_number || ''}</td>
      <td>${row.po_num || ''}</td>
      <td>${row.invoice_no || ''}</td>
      <td style="text-align:right;">${row.invoice_qty || 0}</td>
      <td>${row.consignee_name ? capitalizeWords(row.consignee_name) : ''}</td>
      <td style="text-align:right;">${row.vendor_bulk_rate || 0}</td>
       <td style="text-align:right;">${row.basicamt || 0}</td>

      <td style="text-align:right;">${row.vendor_bulk_gst || 0} %</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

      <td style="text-align:right; font-weight: bold;">
        ? ${bulkAmount.toLocaleString('en-IN', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            })}
      </td>
    </tr>
  `;
          });


          $('#vendor_datatable tbody').html(tableHtml);
        } else {
          vendorPaymentModalRows = [];
          renderVendorPaymentModalTable([]);
          return;
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

          $('#acc_holder_popup_2').text(res.summary_data.acc_holder_name || '-');

          $('#unique_id').text(res.summary_data.unique_id || '-');
          $('#dc_number').text(res.summary_data.dc_number || '-');

          // $('#pan_popup_2').text(res.summary_data.pan_attach_file_name || '-');
          // $('#bank_popup_2').text(res.summary_data.bank_proof || '-');
          // For the PAN attachment (Click to download PDF)
          // PAN File
          if (res.summary_data.pan_attach_file_name) {
            var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
            $('#pan_popup_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" onerror="this.onerror=null;this.src=\'assets/images/pdf.png\';" height="20px" width="20px" alt="Preview PAN PDF"> ' +
              '<span style="font-size:12px;color:#506018;">' + res.summary_data.pan_attach_file_name + '</span>' +
              '</a>'
            );
          } else {
            $('#pan_popup_2').text('N/A');
          }

          // Bank Proof
          if (res.summary_data.bank_proof) {
            var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
            $('#bank_popup_2').html(
              '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
              '<img src="uploads/vendor_creation/pdf.png" onerror="this.onerror=null;this.src=\'assets/images/pdf.png\';" height="20px" width="20px" alt="Preview Bank PDF"> ' +
              '<span style="font-size:12px;color:#506018;">' + res.summary_data.bank_proof + '</span>' +
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

        console.log(firstRow.inv_verfiy_attach);

        if (firstRow.vendor_inv_attach_approval_date == "01-01-1970") {
            $('#ven_inv_date').text('-');
        } else {
            $('#ven_inv_date').text(firstRow.vendor_inv_attach_approval_date || 'N/A');
        }

        $('#ven_inv_id').text(firstRow.veninvverifyid || '-');

        if (firstRow.inv_verfiy_attach) {
            var fileUrl = "/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
            $('#ven_inv_attach_2').html(
                '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
                '<img src="/otm_beta/uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
                '</a>'
            );
        } else {
            $('#ven_inv_attach_2').text('N/A');
        }

        if (firstRow.po_ven_filename) {
            var fileUrl = "/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
            $('#ven_po_attach_2').html(
                '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
                '<img src="/otm_beta/uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
                '</a>'
            );
        } else {
            $('#ven_po_attach_2').text('N/A');
        }

        let tableHtml = '';
        let rowAmountTotal = 0;

        // Main/bill-level values are repeated in each detail row; take them from the first row.
        let additional_amount = parseFloat(firstRow.additional_amount || 0) || 0;
        let stored_grand_total = parseFloat(firstRow.total_amount || 0) || 0;

        res.data.forEach((row, index) => {

            const rawAmount = row.amount || '0';
            const amount = parseFloat(
                rawAmount.toString().replace(/,/g, '')
            ) || 0;

            rowAmountTotal += amount;

            tableHtml += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${row.dc_num || '-'}</td>
                    <td>${row.po_num || '-'}</td>
                    <td>${row.invoice_no || '-'}</td>
                    <td style="text-align:center;">${row.invoice_qty || 0}</td>
                    <td>${capitalizeWords(row.consignee_name || '-')}</td>
                    <td style="text-align:right;">
                        ${parseFloat(row.rate || 0).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })}
                    </td>
                    <td style="text-align:right;">
                        ${parseFloat(row.basicamt || 0).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })}
                    </td>
                    <td style="text-align:right;">${row.gst || 0} %</td>
                    <td style="text-align:right;">
                        ${parseFloat(row.gstcamt || 0).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })}
                    </td>
                    <td style="text-align:right;font-weight:bold;">
                        ₹ ${row.amount || '0.00'}
                    </td>
                </tr>
            `;
        });

        // Prefer stored bill total because it may include additional charges.
        // If old data has no stored total, rebuild it from row amounts + additional amount.
        const grandTotal = stored_grand_total > 0
            ? stored_grand_total
            : (rowAmountTotal + additional_amount);

        const formattedAdditional = additional_amount.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        const formattedGrandTotal = grandTotal.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $('#vendor_datatable_bill_popup tbody').html(tableHtml);
        $('#additional_amount_lab').html('₹ ' + formattedAdditional);
        $('#sum_of_amount').html('₹ ' + formattedGrandTotal);

    } else {
        $('#vendor_datatable_bill_popup tbody').html(
            '<tr><td colspan="11" class="text-center">No data found</td></tr>'
        );
        $('#sum_of_amount').text('₹ 0.00');
        $('#additional_amount_lab').text('₹ 0.00');
    }
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
            </span><br> <span class="status-text status-${row.transfer_amount}">
              ${row.transfer_amount}
            </span><br>
            ${row.payment_status}

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
      // ? Keep the full decimal value � do NOT round
      document.getElementById("ttl_amount").value = total.toFixed(2);

      // ? Display formatted amount with 2 decimal places
      document.getElementById("ttl_span_amnt").textContent =
        '? ' + total.toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
    }


  });




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

